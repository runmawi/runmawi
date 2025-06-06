<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;
use Carbon\Carbon;
use URL;
use App\EmailTemplate;

class ResetPasswordNotification extends Notification
{
    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * The callback that should be used to create the reset password URL.
     *
     * @var \Closure|null
     */
    public static $createUrlCallback;

    /**
     * The callback that should be used to build the mail message.
     *
     * @var \Closure|null
     */
    public static $toMailCallback;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        if (static::$createUrlCallback) {
            $url = call_user_func(static::$createUrlCallback, $notifiable, $this->token);
        } else {
            $url = url(route('password.reset', [
                'token' => $this->token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));
        }

       $url = url(config('app.url') . route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));


        try {

            $email_subject =  EmailTemplate::where('id',4)->pluck('heading')->first() ;

            return (new MailMessage)->subject($email_subject)->view('emails.reset', [
                'url' => $url,
                'email' => $notifiable->getEmailForPasswordReset(),
                'token' => $this->token,
                'date' => Carbon::now()->toDayDateTimeString() ,
                'link' =>  URL::to('/').'/password/reset/'.$this->token , 
            ]);

            $email_log      = 'Mail Sent Successfully from Forget E-Mail';
            $email_template = "4";
            $user_id = null;

            Email_sent_log($user_id,$email_log,$email_template);

        } catch (\Throwable $th) {
            return (new MailMessage)->view('emails.reset', [
                'url' => $url,
                'email' => $notifiable->getEmailForPasswordReset(),
                'token' => $this->token,
                'date' => Carbon::now()->toDayDateTimeString() ,
                'link' =>  URL::to('/').'/password/reset/'.$this->token , 
            ]);

            $email_log      = $th->getMessage();
            $email_template = "4";
            $user_id = null;

            Email_notsent_log($user_id,$email_log,$email_template);
        }
    }

    /**
     * Set a callback that should be used when creating the reset password button URL.
     *
     * @param  \Closure  $callback
     * @return void
     */
    public static function createUrlUsing($callback)
    {
        static::$createUrlCallback = $callback;
    }

    /**
     * Set a callback that should be used when building the notification mail message.
     *
     * @param  \Closure  $callback
     * @return void
     */
    public static function toMailUsing($callback)
    {
        static::$toMailCallback = $callback;
    }
}

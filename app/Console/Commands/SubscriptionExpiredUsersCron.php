<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\EmailTemplate;
use App\Subscription;
use App\User;
use Carbon\Carbon;

class SubscriptionExpiredUsersCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptionexpiredusers:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh the role for users whose subscriptions have expired';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users_subscription = User::query()->where('role','subscriber')->whereDate('subscription_ends_at', '>=', Carbon::now()->subDays(3)->format('Y-m-d h:i:s'))
                                                ->whereDate('subscription_ends_at', '<=', Carbon::now()->format('Y-m-d h:i:s') )->get();

        foreach($users_subscription as $key => $user_subscription){

            try {

                $email_subject =  EmailTemplate::where('id',28)->pluck('heading')->first() ;

                $data = array( 'email_subject' => $email_subject );

                \Mail::send('emails.Subscription_Expiry', array(

                    'PlanName'     => Subscription::join('subscription_plans','subscription_plans.plan_id','=','subscriptions.stripe_plan')
                                                ->where('subscriptions.user_id',$user_subscription->id)->where('subscriptions.stripe_id',$user_subscription->stripe_id)
                                                ->groupBy('subscriptions.stripe_plan')->pluck('subscription_plans.plans_name')->first() ?? 'Plan Name' ,

                    'Name'         => $user_subscription->username,
                    'EndSubscriptionDate'  =>  $user_subscription->subscription_ends_at,
                    'website_name' => GetWebsiteName(),
                ), 

                function($message) use ($data,$user_subscription) {
                    $message->from(AdminMail(),GetWebsiteName());
                    $message->to($user_subscription->email, $user_subscription->username)->subject($data['email_subject']);
                });

                $email_log      = 'Mail Sent Successfully from Partner Subscription Expiry Notification !';
                $email_template = "28";
                $user_id = $user_subscription->id;

                Email_sent_log($user_id,$email_log,$email_template);

            } catch (\Throwable $th) {

                $email_log = $th->getMessage();
                $email_template = "28";
                $user_id = $user_subscription->id;

                Email_notsent_log($user_id, $email_log, $email_template);
            }   
        }

        \Log::channel('cron')->info("Subscription Expired Reminder before 3 days Cron is working fine!");
    }
}
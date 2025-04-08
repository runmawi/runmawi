<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use App\HomeSetting;
use App\EmailTemplate;
use App\ForgetPasswordLog;
use App\User;
use Theme;
use Mail ;
use URL;
use App\Setting ;
use App\EmailSetting ;
use App\Services\MicrosoftGraphAuth;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model\Message;

class PasswordForgetController extends Controller
{
    public function __construct()
    {
        $this->email_settings = EmailSetting::first();
        $this->Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses($this->Theme);
    }

    public function Reset_password(Request $request)
    {
        return Theme::view('Forget_Password.Reset_password');
    }

    public function Send_Reset_Password_link(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $reset_token = str_random(15).random_int(1000000, 9999999).str_random(20).random_int(100000, 999999).str_random(1);
        $base64_encode_email = base64_encode($request->email);
        $user =  User::where('email',$request->email)->first() ;

        try {

            $email_template_subject =  EmailTemplate::where('id',4)->pluck('heading')->first() ;
            $email_subject  =  $email_template_subject;
            $data = array(
                'email_subject' => $email_subject,
                'email_id'      => $request->email,
                'crypt_email'   =>  Crypt::encryptString($base64_encode_email) ,
                'reset_token'   =>  $reset_token ,
            );


            if ($this->email_settings->enable_microsoft365 == 1) {
                sendMicrosoftMail($data['email_id'], $data['email_subject'], 'emails.forget_password', [
                    'Name' => $user != null && $user->username ? $user->username : $user->name,
                    'Date' => Carbon::now(),
                    'link' => URL::to('confirm-Reset-password/'.$data['crypt_email'].'/'.$data['reset_token']),
                    'website_name' => GetWebsiteName(),
                ]);
            } else {
                Mail::send('emails.forget_password', [
                    'Name' => $user != null && $user->username ? $user->username : $user->name,
                    'Date' => Carbon::now(),
                    'link' => URL::to('confirm-Reset-password/'.$data['crypt_email'].'/'.$data['reset_token']),
                    'website_name' => GetWebsiteName(),
                ], function($message) use ($data) {
                    $message->from(AdminMail(), GetWebsiteName());
                    $message->to($data['email_id'])->subject($data['email_subject']);
                });
            }

            $email_log      = 'Mail Sent Successfully from Reset password for your account';
            $email_template = "4";
            $user_id        =  $user->id;
            Email_sent_log($user_id,$email_log,$email_template);

            $inputs =array(
                'user_id' => $user->id,
                'token'   => $reset_token,
                'email'   => $user->email,
                'status'  => "Active"
            );
            $ForgetPasswordLog = ForgetPasswordLog::where('user_id',$user->id)->first();
            $ForgetPasswordLog == null ? ForgetPasswordLog::create($inputs) : ForgetPasswordLog::where('user_id',$user->id)->update($inputs) ;
            return redirect()->back()->with('status-success', 'A Password Reset link has been sent to your E-mail account');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            $email_log      = $th->getMessage();    
            $user_id        =  $user->id;
            $email_template = "4";
            Email_notsent_log($user_id, $email_log, $email_template);
            return redirect()->back()->with('status-fails', 'Sorry we cannot send you an email now. Kindly, check your email settings');
        }

    }

    public function confirm_reset_password($crypt_email,$reset_token)
    {
        try {

            $decrypted_email =  base64_decode(Crypt::decryptString($crypt_email));

                                // Verify-Password 
            $ForgetPassword_token = ForgetPasswordLog::where('email',$decrypted_email)->pluck('token')->first();

            $verify_token = ForgetPasswordLog::where('email',$decrypted_email)->where('token',$reset_token)
                                                ->where('status','Active')->latest()->first();

            if($verify_token == null ){
                return Theme::view('Forget_Password.error_page');
            }

            $data = array(
                'decrypted_email' =>  $decrypted_email,
                'reset_token'     => $reset_token
            );

            return Theme::view('Forget_Password.forget_password', ['data' => $data]);

        } catch (\Throwable $th) {

            return Theme::view('Forget_Password.error_page');
        }
    }

    public function forget_password_update(Request $request)
    {
                        // Verify-Password 
        $ForgetPassword_token = ForgetPasswordLog::where('email',$request->email)->pluck('token')->first();

        $verify_token = ForgetPasswordLog::where('email',$request->email)->where('token',$request->reset_token)
                                            ->where('status','Active')->latest()->first();

        if($verify_token == null ){
            return redirect()->back()->with('status_message', 'Token Mismatch / Token Expired!');
        }

        $this->validate($request, [
                'password' => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
            ]
        );

        $user = User::where('email',$request->email)->first();

        User::where('id',$user->id)->update([
                'password' => Hash::make($request->password)
        ]);

        ForgetPasswordLog::where('user_id',$user->id)->update([
                'status' => "used",
                'password_changed_time' => Carbon::now(),
        ]);

        return redirect('/login')->with('message', 'Successfully! Password has been Changed');
    }
}
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use DB;
use App\User;
use Hash;
use App\EmailTemplate;
use Mail;
use App\Setting;
class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    
    
     public function getPassword($token) {

       return view('auth.passwords.reset', ['token' => $token]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',

        ]);
      

        $updatePassword = DB::table('password_resets')
                            ->where(['email' => $request->email, 'token' => $request->token])
                            ->first();

        if(!$updatePassword){
            return back()->withInput()->with('error', 'Invalid token!');
        } else {

          $user = User::where('email', $request->email)
                      ->update(['password' => Hash::make($request->password)]);

                        DB::table('password_resets')->where(['email'=> $request->email])->delete();
            
            
          return redirect('/login')->with('message', 'Your password has been changed!');
        }
    }
    
public function reset(Request $request)
    {
    $updatePassword = DB::table('password_resets')
                            ->where(['email' => $request->email])
                            ->first();

    $user =   User::where('email','=',$request->email)->get();
    $template = EmailTemplate::where('id','=', 8)->get(); 

    foreach($template as $key => $value){
        $heading = $value->heading;
        $template_type = $value->template_type;
    }
    
    $settings = Setting::find(1);
    $email_subject = EmailTemplate::where('id',7)->pluck('heading')->first() ;

        try {
            Mail::send('emails.changed_password', array(
                'heading' => $heading,
                'email' => $request->email,
                'username' => $user[0]->username,
                'website_name' =>  GetWebsiteName(),
            ), 
            function($message) use ($user,$settings,$email_subject){
                $message->from(AdminMail(),GetWebsiteName());
                $message->to($user[0]->email,$user[0]->username);
                $message->subject($email_subject);
            });

            $email_log      = 'Mail Sent Successfully from Change Password E-Mail';
            $email_template = "7";
            $user_id = $user[0]->id;

            Email_sent_log($user_id,$email_log,$email_template);

        } catch (\Throwable $th) {

            $email_log      = $th->getMessage();
            $email_template = "7";
            $user_id = $user[0]->id;

            Email_notsent_log($user_id,$email_log,$email_template);
        }
        

       if(!$updatePassword){

            return back()->withInput()->with('error', 'Invalid token!');
        } else {

          $user = User::where('email', $request->email)
                      ->update(['password' => Hash::make($request->password)]);

          DB::table('password_resets')->where(['email'=> $request->email])->delete();
           


          return redirect('/login')->with('message', 'Your password has been changed!');
        }
   
    }
    
    
}

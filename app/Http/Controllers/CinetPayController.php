<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Config;
use Unicodeveloper\Paystack\Exceptions\IsNullException;
use Unicodeveloper\Paystack\Exceptions\PaymentVerificationFailedException;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use Carbon\Carbon;
use App\PaymentSetting;
use App\Subscription;
use App\PpvPurchase;
use App\Paystack_Andriod_UserId;
use App\VideoCommission;
use App\ModeratorsUser;
use App\Video;
use App\LivePurchase;
use App\LiveStream;
use App\User;
use App\Setting;
use Auth;
use Paystack;
use URL;
use App\SubscriptionPlan;
use App\EmailTemplate;
use App\Audio;

class CinetPayController extends Controller
{
    public function __construct()
    {
        $PaymentSetting = PaymentSetting::where('payment_type','CinetPay')->first();
    }



    public function CinetPay_Video_Rent_Payment(Request $request)
    {
        $data = $request->all();
        $email = User::where('id',Auth::user()->id)->pluck('email')->first();
        
        try{
            $to_time = ppv_expirytime_started(); 

        $video = Video::where('id','=',$request->video_id)->first();
        if(!empty($video)){
        $moderators_id = $video->user_id;
        }

        if(!empty($moderators_id)){
            $moderator        = ModeratorsUser::where('id','=',$moderators_id)->first();  
            $total_amount     = $video->ppv_price;
            $title            =  $video->title;
            $commssion        = VideoCommission::first();
            $percentage       = $commssion->percentage; 
            $ppv_price        = $video->ppv_price;
            $admin_commssion  = ($percentage/100) * $ppv_price ;
            $moderator_commssion = $ppv_price - $percentage;
            $moderator_id = $moderators_id;
        }
        else
        {
            $total_amount   = $video->ppv_price;
            $title          =  $video->title;
            $commssion      = VideoCommission::first();
            $percentage     = null; 
            $ppv_price       = $video->ppv_price;
            $admin_commssion =  null;
            $moderator_commssion = null;
            $moderator_id = null;
        }

        $purchase = new PpvPurchase;
        $purchase->user_id       =  Auth::user()->id ;
        $purchase->video_id       = $request->video_id ;
        $purchase->total_amount  = $video->ppv_price ; 
        $purchase->admin_commssion = $admin_commssion;
        $purchase->moderator_commssion = $moderator_commssion;
        $purchase->status = 'active';
        $purchase->to_time = $to_time;
        $purchase->moderator_id = $moderator_id;
        $purchase->save();

        if ($err) {                 // Error 
            $response = array( 
                "status"  => false , 
                "message" => $err  
            );
        } 
        else {                      // Success 
            $response = array(
                "status"  => true ,
                "message" => "Payment done! Successfully", 
                'data'    =>  $result ,
            );
        }
    

    } catch (\Exception $e) {

        $response = array(
            "status"  => false , 
            "message" => $e->getMessage(), 
       );
    }

    return response()->json($response, 200);

    }

    
    
    public function CinetPaySubscription(Request $request)
    {
        $data = $request->all();
        $email = User::where('id',$request->email)->pluck('email')->first();

        $plandetail = SubscriptionPlan::where('plan_id',$request->plan_name)->first();
        $current_date = date('Y-m-d h:i:s');    
        $next_date = $plandetail->days;
        $ends_at = Carbon::now()->addDays($plandetail->days);
        try{

            
            Subscription::create([
                'user_id'        =>  $request->user_id,
                'name'           =>  $request->user_name,
                'price'          =>  $request->amount ,   // Amount Paise to Rupees
                'stripe_id'      =>  $request->plan_name ,
                'stripe_status'  =>  'active' ,
                'stripe_plan'    =>  $request->plan_name,
                'quantity'       =>  null,
                'countryname'    =>  Country_name(),
                'regionname'     =>  Region_name(),
                'cityname'       =>  city_name(),
                'PaymentGateway' =>  'CinetPay',
                'trial_ends_at'  =>  $ends_at,
                'ends_at'        =>  $ends_at,
                'platform'       => 'WebSite',
            ]);

            User::where('id',$request->user_id)->update([
                'role'                 =>  'subscriber',
                'stripe_id'            =>  $request->transaction_id ,
                'subscription_start'   =>  Carbon::now(),
                'subscription_ends_at' =>  $ends_at,
                'payment_gateway'      =>  'CinetPay',
            ]);

            // Success 
            $response = array(
                "status"  => true ,
                "message" => "Payment done! Successfully", 
            );
       
    

    } catch (\Exception $e) {

        $response = array(
            "status"  => false , 
            "message" => $e->getMessage(), 
       );
    }
        try {
            $user = User::where('id',$request->user_id)->first();
            $email_subject = EmailTemplate::where('id',23)->pluck('heading')->first() ;

            \Mail::send('emails.subscriptionmail', array(
                'name' => ucwords($user->username),
                'uname' => $user->username,
                'paymentMethod' => 'CinetPay',
                'plan' => ucfirst($plandetail->plans_name),
                'price' => $plandetail->price,
                'plan_id' => $plandetail->plan_id,
                'billing_interval' => $plandetail->billing_interval,
                'next_billing' => $ends_at,
                'subscription_type' => 'One Time',

            ), function($message) use ($request,$user,$email_subject){
                $message->from(AdminMail(),GetWebsiteName());
                $message->to($user->email, $user->username)->subject($email_subject);
            });

            $email_log      = 'Mail Sent Successfully from Register Subscription';
            $email_template = "23";
            $user_id = $user->id;

            Email_sent_log($user_id,$email_log,$email_template);

        } catch (\Throwable $th) {

            $user = User::where('id',$request->user_id)->first();

            $email_log      = $th->getMessage();
            $email_template = "23";
            $user_id = $user->id;

            Email_notsent_log($user_id,$email_log,$email_template);
        }
    
    return response()->json($response, 200);

    }

    
    public function CinetPay_audio_Rent_Payment(Request $request)
    {
        $data = $request->all();
        $email = User::where('id',Auth::user()->id)->pluck('email')->first();
        
        try{
            $to_time = ppv_expirytime_started(); 
            $ppv_price = $request->amount;
        $audio = Audio::where('id','=',$request->audio_id)->where('uploaded_by','CPP')->orWhere('uploaded_by','Channel')->first();
        if(!empty($audio)){
        $moderators_id = $audio->user_id;
        }

        if(!empty($moderators_id)){
            $moderator        = ModeratorsUser::where('id','=',$moderators_id)->first();  
            $total_amount     = $audio->ppv_price;
            $title            =  $audio->title;
            $commssion        = VideoCommission::first();
            $percentage       = $commssion->percentage; 
            $ppv_price        = $audio->ppv_price;
            $admin_commssion  = ($percentage/100) * $ppv_price ;
            $moderator_commssion = $ppv_price - $percentage;
            $moderator_id = $moderators_id;
        }
        else
        {
        $audio = Audio::where('id','=',$request->audio_id)->first();

            $total_amount   = $request->ppv_price;
            $title          =  $audio->title;
            $commssion      = VideoCommission::first();
            $percentage     = null; 
            $ppv_price       = $request->amount;
            $admin_commssion =  null;
            $moderator_commssion = null;
            $moderator_id = null;
        }

        $purchase = new PpvPurchase;
        $purchase->user_id       =  Auth::user()->id ;
        $purchase->audio_id       = $request->audio_id ;
        $purchase->total_amount  = $request->amount ; 
        $purchase->admin_commssion = $admin_commssion;
        $purchase->moderator_commssion = $moderator_commssion;
        $purchase->status = 'active';
        $purchase->to_time = $to_time;
        $purchase->moderator_id = $moderator_id;
        $purchase->save();

                    // Success 
            $response = array(
                "status"  => true ,
                "message" => "Payment done! Successfully", 
            );
    

    } catch (\Exception $e) {

        $response = array(
            "status"  => false , 
            "message" => $e->getMessage(), 
       );
    }

    return response()->json($response, 200);

    }

    public function audio_ppv(Request $request)
    {

        if(!Auth::guest()){  
            $countaudioppv = App\PpvPurchase::where('audio_id',$request->id)->where('user_id',Auth::user()->id)->count();

            return $countaudioppv;
          }else {
            return 0;
          }     
        
    }

    
    public function CinetPay_live_Rent( Request $request )
    {
        try {

            $setting = Setting::first();  
            $ppv_hours = $setting->ppv_hours;

            $to_time = ppv_expirytime_started(); 
            

            $video = LiveStream::where('id','=',$request->live_id)->first();

            if(!empty($video)){
            $moderators_id = $video->user_id;
            }

            if(!empty($moderators_id)){
                $moderator        = ModeratorsUser::where('id','=',$moderators_id)->first();  
                $total_amount     = $video->ppv_price;
                $title            =  $video->title;
                $commssion        = VideoCommission::first();
                $percentage       = $commssion->percentage; 
                $ppv_price        = $video->ppv_price;
                $admin_commssion  = ($percentage/100) * $ppv_price ;
                $moderator_commssion = $ppv_price - $percentage;
                $moderator_id = $moderators_id;
            }
            else
            {
                $total_amount   = $video->ppv_price;
                $title          =  $video->title;
                $commssion      = VideoCommission::first();
                $percentage     = null; 
                $ppv_price       = $video->ppv_price;
                $admin_commssion =  null;
                $moderator_commssion = null;
                $moderator_id = null;
            }

            $purchase = new PpvPurchase;
            $purchase->user_id       =  Auth::user()->id ;
            $purchase->live_id       = $request->live_id ;
            $purchase->total_amount  = $request->amount ; 
            $purchase->admin_commssion = $admin_commssion;
            $purchase->moderator_commssion = $moderator_commssion;
            $purchase->status = 'active';
            $purchase->to_time = $to_time;
            $purchase->moderator_id = $moderator_id;
            $purchase->save();

            $livepurchase = new LivePurchase;
            $livepurchase->user_id =  Auth::user()->id ;
            $livepurchase->video_id = $request->live_id;
            $livepurchase->to_time = $to_time;
            $livepurchase->expired_date = $to_time;
            $livepurchase->amount =  $request->amount ;
            $livepurchase->from_time = Carbon::now()->format('Y-m-d H:i:s');
            $livepurchase->unseen_expiry_date = ppv_expirytime_notstarted();
            $livepurchase->status = 1;
            $livepurchase->save();

            if ($err) {                 // Error 
                $response = array( 
                    "status"  => false , 
                    "message" => $err  
                );
            } 
            else {                      // Success 
                $response = array(
                    "status"  => true ,
                    "message" => "Payment done! Successfully", 
                    'data'    =>  $result ,
                );
            }
        

        } catch (\Exception $e) {

            $response = array(
                "status"  => false , 
                "message" => $e->getMessage(), 
           );
        }

        return response()->json($response, 200);
    }

}
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\SubscriptionPlan;
use App\CurrencySetting;
use App\Subscription;
use App\PaymentSetting;
use App\HomeSetting;
use App\SiteTheme;
use App\EmailTemplate;
use App\ModeratorsUser;
use App\VideoCommission;
use App\PpvPurchase;
use App\LivePurchase;
use App\LiveStream;
use App\Setting;
use App\SeriesSeason;
use App\Series;
use App\Currency;
use Carbon\Carbon;
use App\User;
use App\Video;
use Theme;
use Auth;
use URL;
use Mail;

class PaydunyaPaymentController extends Controller
{
    public function __construct()
    {
        $PaymentSetting =  PaymentSetting::where('payment_type','=','Paydunya')->where('paydunya_status',1)->first();

        if($PaymentSetting != null){

            $this->paydunya_masterkey = $PaymentSetting->paydunya_masterkey;

            if($PaymentSetting->live_mode == 0){
                $this->Paydunya_publish_key = $PaymentSetting->paydunya_test_PublicKey;
                $this->Paydunya_private_key = $PaymentSetting->paydunya_test_PrivateKey;
                $this->Paydunya_token_key   = $PaymentSetting->paydunya_test_token;
                $this->Paydunya_set_mode    = "test";
            }else{
                $this->Paydunya_publish_key = $PaymentSetting->paydunya_live_PublicKey;
                $this->Paydunya_private_key = $PaymentSetting->paydunya_live_PrivateKey;
                $this->Paydunya_token_key   = $PaymentSetting->paydunya_live_token;
                $this->Paydunya_set_mode    = "live";
            }
        }else{
            $Error_msg = "Paydunya Key is Missing";
            $url = URL::to('/home');
            echo "<script type='text/javascript'>alert('$Error_msg'); window.location.href = '$url' </script>";
        }

        $this->Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses($this->Theme);
    }

    // subscription

    public function Paydunya_checkout(Request $request)
    {
        try {
         
            \Paydunya\Checkout\Store::setName( GetWebsiteName() ); 
            \Paydunya\Checkout\Store::setWebsiteUrl( URL::to('/') );
            \Paydunya\Checkout\Store::setLogoUrl(  front_end_logo() );
            \Paydunya\Checkout\Store::setReturnUrl( URL::to('Paydunya-verify-request?plan='.$request->Paydunya_plan_id) );

            \Paydunya\Setup::setMasterKey($this->paydunya_masterkey);
            \Paydunya\Setup::setPublicKey( $this->Paydunya_publish_key );
            \Paydunya\Setup::setPrivateKey($this->Paydunya_private_key);
            \Paydunya\Setup::setToken($this->Paydunya_token_key);
            \Paydunya\Setup::setMode( $this->Paydunya_set_mode  ); 
            
                // users Details 

            $users_details =Auth::User();

            if( $users_details != null ){
                $user_email = User::where('id',Auth::user()->id)->pluck('email')->first();

                $redirect_url  = URL::to('becomesubscriber') ;
            }
            else{
                $userEmailId = $request->session()->get('register.email');
                $user_email   = User::where('email',$userEmailId)->pluck('email')->first();

                $redirect_url  = URL::to('home') ;
            }

                // SubscriptionPlan Details 

            $SubscriptionPlan =  SubscriptionPlan::where('type','Paydunya')->where('plan_id',$request->Paydunya_plan_id)->first();

            if(CurrencySetting::pluck('enable_multi_currency')->first() == 1 ){

                $To_Currency_symbol = 'XOF';

                $default_Currency = CurrencySetting::first();

                $From_Currency_symbol = Currency::where('country',@$default_Currency->country)->pluck('code')->first();

                $api_url = "https://open.er-api.com/v6/latest/{$From_Currency_symbol}";

                try {

                    $response = Http::get($api_url);
                
                    $exchangeRates = $response->json();
                
                    if (isset($exchangeRates['rates'])) {
                        $targetCurrency = $To_Currency_symbol;
                
                        if (isset($exchangeRates['rates'][$targetCurrency])) {
                            $conversionRate = $exchangeRates['rates'][$targetCurrency];
                            $convertedAmount = $SubscriptionPlan->price * $conversionRate;
                        } else {
                            $convertedAmount = null;

                            return response()->json( array(
                                "status"  => false ,
                                "message" => "Error on Currency Conversation, Pls connect admin" ,
                            ), 200);
                        }
                    } else {
                        $convertedAmount = null;

                        return response()->json( array(
                            "status"  => false ,
                            "message" => "Error on Currency Conversation, Pls connect admin" ,
                        ), 200);

                    }
                
                } catch (\Exception $e) {
                    $response = array(
                        "status"  => false ,
                        "message" => $e->getMessage() , 
                    );
                }

                $Plan_amount = $convertedAmount ;

            }else{

                $Plan_amount = $SubscriptionPlan->price ;

            }
            

                // Checkout Page Creation 

            $invoice = new \Paydunya\Checkout\CheckoutInvoice();
            $invoice->addItem("", 1, $Plan_amount , $Plan_amount );
            $invoice->setTotalAmount($Plan_amount);

            try {
                if($invoice->create()) {
                    $authorization_url =  $invoice->getInvoiceUrl() ;
                }else{
                    $response = array(
                        "status"  => false ,
                        "message" => $invoice->response_text , 
                    );
                    return response()->json($response, 200);

                }
            } catch (\Throwable $th) {
                $response = array(
                    "status"  => false ,
                    "message" => $th->getMessage() , 
                );
            }
            
            $response = array(
                'status'           => true ,
                'message'          => "Authorization url Successfully Created !" , 
                'authorization_url' => $authorization_url , 
                'email_id'          => $user_email,
                'amount'            => $Plan_amount ,
                'redirect_url'      => $redirect_url,
            );

        } catch (\Throwable $th) {
            
            $response = array(
                "status"  => false ,
                "message" => $th->getMessage() , 
            );
        }

        return response()->json($response, 200);
    }

    public function  Paydunya_verify_request ( Request $request )
    {
        try {
            
            \Paydunya\Setup::setMasterKey($this->paydunya_masterkey);
            \Paydunya\Setup::setPublicKey( $this->Paydunya_publish_key );
            \Paydunya\Setup::setPrivateKey($this->Paydunya_private_key);
            \Paydunya\Setup::setToken($this->Paydunya_token_key);
            \Paydunya\Setup::setMode( $this->Paydunya_set_mode  ); 

            $Plan_id = $request->plan;
            $token   = $request->token;

            $invoice = new \Paydunya\Checkout\CheckoutInvoice();

            if ($invoice->confirm($token)) {

                //  $invoice->getCustomerInfo('name');
                //  $invoice->getCustomerInfo('email');
                //  $invoice->getReceiptUrl();

                if( $invoice->getStatus() == "completed"){

                        // users Details 

                    $users_details =Auth::User();

                    if( $users_details != null ){
                        $users = User::where('id',Auth::user()->id)->first();
                        $user_id = Auth::user()->id;
                    }
                    else{
                        $userEmailId = $request->session()->get('register.email');
                        $users   = User::where('email',$userEmailId)->first();
                        $user_id = User::where('email',$userEmailId)->pluck('id')->first();
                    }
        
                            // Subscription Details

                    $SubscriptionPlan =  SubscriptionPlan::where('type','Paydunya')->where('plan_id',$Plan_id)->first();

                    $Sub_Startday  = Carbon::now()->setTimezone('UTC')->toDateTimeString(); 
                    $Sub_Endday    = Carbon::now()->addDays($SubscriptionPlan->days)->setTimezone('UTC')->toDateTimeString(); 
                    $trial_ends_at = Carbon::now()->addDays($SubscriptionPlan->days)->setTimezone('UTC')->toDateTimeString(); 

                    Subscription::create([
                        'user_id'        =>  $user_id,
                        'name'           =>  $SubscriptionPlan->plan_id,
                        'price'          =>  $invoice->getTotalAmount(), 
                        'stripe_id'      =>  $token ,
                        'stripe_status'  =>  $invoice->getStatus() ,
                        'quantity'       =>  null,
                        'countryname'    =>  Country_name(),
                        'regionname'     =>  Region_name(),
                        'cityname'       =>  city_name(),
                        'PaymentGateway' =>  'Paydunya',
                        'days'           =>  $SubscriptionPlan->days,
                        'trial_ends_at'  =>  $trial_ends_at,
                        'ends_at'        =>  $trial_ends_at,
                        'stripe_plan'    =>  $SubscriptionPlan->plan_id,
                        'platform'       => 'WebSite',
                    ]);

                    User::where('id',$user_id)->update([
                        'role'            =>  'subscriber',
                        'stripe_id'       =>    $token,
                        'subscription_start'    =>  $Sub_Startday,
                        'subscription_ends_at'  =>  $Sub_Endday,
                        'payment_gateway'       =>  'Paydunya',
                    ]);
                }


                try {

                    $email_subject = EmailTemplate::where('id',23)->pluck('heading')->first() ;
      
                    $nextPaymentAttemptDate =  Carbon::now()->addDays($SubscriptionPlan->days)->format('F jS, Y')  ;
      
                    \Mail::send('emails.subscriptionmail', array(
      
                        'name'          => ucwords($users->username),
                        'paymentMethod' => $SubscriptionPlan->payment_type,
                        'plan'          => ucfirst( $SubscriptionPlan->subscription_plan_name),
                        'price'         => $invoice->getTotalAmount(), 
                        'plan_id'       => $SubscriptionPlan->plan_id,
                        'billing_interval'  =>  $SubscriptionPlan->billing_interval ,
                        'next_billing'      => $nextPaymentAttemptDate,
                        'subscription_type' => 'recurring',
                      ), 
      
                      function($message) use ($request,$users,$email_subject){
                        $message->from(AdminMail(),GetWebsiteName());
                        $message->to($users->email, $users->username)->subject($email_subject);
                      });
      
                    $email_log      = 'Mail Sent Successfully from Become Subscription';
                    $email_template = "23";
                    $user_id = $users->id;
        
                    Email_sent_log($user_id,$email_log,$email_template);
      
                } catch (\Throwable $th) {
      
                    $email_log      = $th->getMessage();
                    $email_template = "23";
                    $user_id = $users->id;
        
                    Email_notsent_log($user_id,$email_log,$email_template);
                }
                    
                $respond = array(
                    'status'  => 'true',
                    'redirect_url' => URL::to('/home'),
                    'message'   => 'Your Subscriber Payment done Successfully' ,
                );

                return Theme::view('paydunya.Message',compact('respond'),$respond);
            }

        } catch (\Throwable $th) {

            $respond = array(
                'status'  => 'false',
                'redirect_url' => URL::to('/becomesubscriber'),
                'message'   => $th->getMessage() ,
            );

            return Theme::view('paydunya.Message',compact('respond'),$respond);
        }
    }

    public function PaydunyaCancelSubscriptions(Request $request)
    {
        try {

            $subscriptionId = User::where('id',Auth::user()->id)->where('payment_gateway','Paydunya')->pluck('stripe_id')->first();

            Subscription::where('stripe_id',$subscriptionId)->update([
                'stripe_status' =>  'Cancelled',
            ]);

            User::where('id',Auth::user()->id )->update([
                'payment_gateway' =>  null ,
                'role'            => 'registered',
                'stripe_id'       => null ,  
            ]);

            $msg = 'Subscription Cancelled Successfully' ;
            $url = URL::to('myprofile/');
            echo "<script type='text/javascript'>alert('$msg'); window.location.href = '$url' </script>";
            
        } catch (\Throwable $th) {

            $msg = 'Some Error occuring while Cancelling the Subscription, Please check this query with admin..';
            $url = URL::to('myprofile/');
            echo "<script type='text/javascript'>alert('$msg'); window.location.href = '$url' </script>";
        }
    }

    // PPV Live

    public function Paydunya_live_checkout_Rent_payment(Request $request,$live_id,$amount)
    {
        try {

            $video = LiveStream::where('id',$live_id)->first();

            \Paydunya\Checkout\Store::setName( GetWebsiteName() ); 
            \Paydunya\Checkout\Store::setWebsiteUrl( URL::to('/') );
            \Paydunya\Checkout\Store::setLogoUrl(  front_end_logo() );
            \Paydunya\Checkout\Store::setReturnUrl( URL::to('Paydunya_live_Rent_payment_verify?live_id='.$live_id) );

            \Paydunya\Setup::setMasterKey($this->paydunya_masterkey);
            \Paydunya\Setup::setPublicKey( $this->Paydunya_publish_key );
            \Paydunya\Setup::setPrivateKey($this->Paydunya_private_key);
            \Paydunya\Setup::setToken($this->Paydunya_token_key);
            \Paydunya\Setup::setMode( $this->Paydunya_set_mode  ); 

                // Checkout Page Creation 
                
            if(CurrencySetting::pluck('enable_multi_currency')->first() == 1 ){

                $To_Currency_symbol = 'XOF';

                $default_Currency = CurrencySetting::first();

                $From_Currency_symbol = Currency::where('country',@$default_Currency->country)->pluck('code')->first();

                $api_url = "https://open.er-api.com/v6/latest/{$From_Currency_symbol}";

                try {

                    $response = Http::get($api_url);
                
                    $exchangeRates = $response->json();
                
                    if (isset($exchangeRates['rates'])) {
                        $targetCurrency = $To_Currency_symbol;
                
                        if (isset($exchangeRates['rates'][$targetCurrency])) {
                            $conversionRate = $exchangeRates['rates'][$targetCurrency];
                            $convertedAmount = $amount * $conversionRate;
                        } else {
                            $convertedAmount = null;

                            return response()->json( array(
                                "status"  => false ,
                                "message" => "Error on Currency Conversation, Pls connect admin" ,
                            ), 200);
                        }
                    } else {
                        $convertedAmount = null;

                        $video = LiveStream::where('id',$live_id)->first();

                        $Error_msg = 'Error on Currency Conversation, Pls connect admin' ;
                        $url = URL::to('live/'. $video->slug);
                        echo "<script type='text/javascript'>alert('$Error_msg'); window.location.href = '$url' </script>";
                    }
                
                } catch (\Exception $e) {
                        $video = LiveStream::where('id',$live_id)->first();

                        $Error_msg = $e->getMessage();
                        $url = URL::to('live/'. $video->slug);
                        echo "<script type='text/javascript'>alert('$Error_msg'); window.location.href = '$url' </script>";
                }

                $payment_amount = $convertedAmount ;

            }else{

                $payment_amount = $amount ;

            }

            $invoice = new \Paydunya\Checkout\CheckoutInvoice();
            $invoice->addItem("", 1, $payment_amount , $payment_amount );
            $invoice->setTotalAmount($payment_amount);
            
            if($invoice->create()) {
                $authorization_url =  $invoice->getInvoiceUrl() ;
                return Redirect::to($authorization_url);
            }
            else{
                $Error_msg = $invoice->response_text ;
                $url = URL::to('live/'. $video->slug);
                echo "<script type='text/javascript'>alert('$Error_msg'); window.location.href = '$url' </script>";
            }

        } catch (\Throwable $th) {

            $video = LiveStream::where('id',$live_id)->first();

            $Error_msg = $invoice->response_text ;
            $url = URL::to('live/'. $video->slug);
            echo "<script type='text/javascript'>alert('$Error_msg'); window.location.href = '$url' </script>";
        }

    }

    public function Paydunya_live_Rent_payment_verify(Request $request)
    {
        try {

            \Paydunya\Setup::setMasterKey($this->paydunya_masterkey);
            \Paydunya\Setup::setPublicKey( $this->Paydunya_publish_key );
            \Paydunya\Setup::setPrivateKey($this->Paydunya_private_key);
            \Paydunya\Setup::setToken($this->Paydunya_token_key);
            \Paydunya\Setup::setMode( $this->Paydunya_set_mode  ); 

            $token   = $request->token;

            $invoice = new \Paydunya\Checkout\CheckoutInvoice();

            if ($invoice->confirm($token)) {
        
                $video = LiveStream::where('id',$request->live_id)->first();

                $setting = Setting::first();  
                $ppv_hours = $setting->ppv_hours;
    
                $to_time = ppv_expirytime_started(); 

                if(!empty($video)){
                    $moderators_id = $video->user_id;
                }

                if(!empty($moderators_id)){
                    $moderator           =  ModeratorsUser::where('id',$moderators_id)->first();  
                    $total_amount        =  $invoice->getTotalAmount();
                    $title               =  $video->title;
                    $commssion           =  VideoCommission::first();
                    $percentage          =  $commssion->percentage; 
                    $ppv_price           =  $video->ppv_price;
                    $admin_commssion     =  ($percentage/100) * $ppv_price ;
                    $moderator_commssion =  $ppv_price - $percentage;
                    $moderator_id        =  $moderators_id;
                }else{
                    $total_amount       =   $invoice->getTotalAmount();
                    $title              =   $video->title;
                    $commssion          =   VideoCommission::first();
                    $ppv_price          =   $video->ppv_price;
                    $percentage         =   null; 
                    $admin_commssion    =   null;
                    $moderator_commssion =  null;
                    $moderator_id        =  null;
                }
            
                PpvPurchase::create([
                    'user_id'       =>  Auth::user()->id ,
                    'live_id'       => $request->live_id ,
                    'total_amount'  => $invoice->getTotalAmount() , 
                    'admin_commssion'     => $admin_commssion,
                    'moderator_commssion' => $moderator_commssion,
                    'status'     => 'active',
                    'to_time'    => $to_time,
                    'from_time'  => Carbon::now()->format('Y-m-d H:i:s'),
                    'moderator_id' => $moderator_id,
                    'payment_gateway'  => 'Paydunya',
                    'payment_in'       => 'website',
                ]);
 
                LivePurchase::create([
                    'user_id' =>  Auth::user()->id ,
                    'video_id' => $request->live_id,
                    'to_time' => $to_time,
                    'expired_date' => $to_time,
                    'amount' =>  $invoice->getTotalAmount() ,
                    'from_time' => Carbon::now()->format('Y-m-d H:i:s'),
                    'unseen_expiry_date' => ppv_expirytime_notstarted(),
                    'status' => 1,
                    'payment_gateway'  => 'Paydunya',
                    'payment_in'       => 'website',
                ]);

                $respond = array(
                    'status'  => 'true',
                    'redirect_url' => URL::to('live/'. $video->slug) ,
                    'message'   => 'Live Payment Purchase Successfully !!' ,
                );
            }

        } catch (\Exception $e) {

            $video = LiveStream::where('id',$request->live_id)->first();

            $respond = array(
                'status'  => 'false',
                'redirect_url' => URL::to('live/'. $video->slug) ,
                'message'   => $e->getMessage() ,
            );
        }

        return Theme::view('paydunya.Message',compact('respond'),$respond);
    }

    // PPV Video

    public function Paydunya_video_checkout_Rent_payment(Request $request,$video_id,$amount)
    {
        try {

            $video = Video::where('id',$video_id)->first();

            \Paydunya\Checkout\Store::setName( GetWebsiteName() ); 
            \Paydunya\Checkout\Store::setWebsiteUrl( URL::to('/') );
            \Paydunya\Checkout\Store::setLogoUrl(  front_end_logo() );
            \Paydunya\Checkout\Store::setReturnUrl( URL::to('Paydunya_video_Rent_payment_verify?video_id='.$video_id) );

            \Paydunya\Setup::setMasterKey($this->paydunya_masterkey);
            \Paydunya\Setup::setPublicKey( $this->Paydunya_publish_key );
            \Paydunya\Setup::setPrivateKey($this->Paydunya_private_key);
            \Paydunya\Setup::setToken($this->Paydunya_token_key);
            \Paydunya\Setup::setMode( $this->Paydunya_set_mode  ); 

               // Currency Conversation 
                
            if(CurrencySetting::pluck('enable_multi_currency')->first() == 1 ){

                $To_Currency_symbol = 'XOF';

                $default_Currency = CurrencySetting::first();

                $From_Currency_symbol = Currency::where('country',@$default_Currency->country)->pluck('code')->first();

                $api_url = "https://open.er-api.com/v6/latest/{$From_Currency_symbol}";

                try {

                    $response = Http::get($api_url);
                
                    $exchangeRates = $response->json();
                
                    if (isset($exchangeRates['rates'])) {
                        $targetCurrency = $To_Currency_symbol;
                
                        if (isset($exchangeRates['rates'][$targetCurrency])) {
                            $conversionRate = $exchangeRates['rates'][$targetCurrency];
                            $convertedAmount = $amount * $conversionRate;
                        } else {
                            $convertedAmount = null;

                            return response()->json( array(
                                "status"  => false ,
                                "message" => "Error on Currency Conversation, Pls connect admin" ,
                            ), 200);
                        }
                    } else {
                        $convertedAmount = null;

                        $video = Video::where('id',$live_id)->first();

                        $Error_msg = 'Error on Currency Conversation, Pls connect admin' ;
                        $url = URL::to('live/'. $video->slug);
                        echo "<script type='text/javascript'>alert('$Error_msg'); window.location.href = '$url' </script>";
                    }
                
                } catch (\Exception $e) {
                        $video = Video::where('id',$live_id)->first();

                        $Error_msg = $e->getMessage();
                        $url = URL::to('live/'. $video->slug);
                        echo "<script type='text/javascript'>alert('$Error_msg'); window.location.href = '$url' </script>";
                }

                $payment_amount = (float)$convertedAmount ;

            }else{

                $payment_amount = (float) $amount ;

            }

                // Checkout Page Creation 

            $invoice = new \Paydunya\Checkout\CheckoutInvoice();
            $invoice->addItem("", 1, $payment_amount , $payment_amount );
            $invoice->setTotalAmount($payment_amount);

            if($invoice->create()) {
                $authorization_url =  $invoice->getInvoiceUrl() ;
                return Redirect::to($authorization_url);
            }else{
                
                $Error_msg = $invoice->response_text ;
                $url = URL::to('category/videos/'. $video->slug);
                echo "<script type='text/javascript'>alert('$Error_msg'); window.location.href = '$url' </script>";
            }

        } catch (\Throwable $th) {

            $video = Video::where('id',$video_id)->first();

            $Error_msg = $th->getMessage() ; 
            $url = URL::to('category/videos/'. $video->slug);
            echo "<script type='text/javascript'>alert('$Error_msg'); window.location.href = '$url' </script>";
        }
    }

    public function Paydunya_video_Rent_payment_verify(Request $request)
    {
        try {

            \Paydunya\Setup::setMasterKey($this->paydunya_masterkey);
            \Paydunya\Setup::setPublicKey( $this->Paydunya_publish_key );
            \Paydunya\Setup::setPrivateKey($this->Paydunya_private_key);
            \Paydunya\Setup::setToken($this->Paydunya_token_key);
            \Paydunya\Setup::setMode( $this->Paydunya_set_mode  ); 

            $token   = $request->token;

            $invoice = new \Paydunya\Checkout\CheckoutInvoice();

            if ($invoice->confirm($token)) {
        
                $video = Video::where('id',$request->video_id)->first();

                $ppv_expirytime_started = Setting::pluck('ppv_hours')->first();
                $to_time = $ppv_expirytime_started != null  ? Carbon::now()->addHours($ppv_expirytime_started)->format('Y-m-d h:i:s a') : Carbon::now()->addHours(3)->format('Y-m-d h:i:s a');
    
                if(!empty($video)){
                    $moderators_id = $video->user_id;
                }

                if(!empty($moderators_id)){
                    $moderator           =  ModeratorsUser::where('id',$moderators_id)->first();  
                    $total_amount        =  $video->ppv_price;
                    $title               =  $video->title;
                    $commssion           =  VideoCommission::first();
                    $percentage          =  $commssion->percentage; 
                    $ppv_price           =  $video->ppv_price;
                    $admin_commssion     =  ($percentage/100) * $ppv_price ;
                    $moderator_commssion =  $ppv_price - $percentage;
                    $moderator_id        =  $moderators_id;
                }else{
                    $total_amount       =   $video->ppv_price;
                    $title              =   $video->title;
                    $commssion          =   VideoCommission::first();
                    $ppv_price          =   $video->ppv_price;
                    $percentage         =   null; 
                    $admin_commssion    =   null;
                    $moderator_commssion =  null;
                    $moderator_id        =  null;
                }
            
                PpvPurchase::create([
                    'user_id'       =>  Auth::user()->id ,
                    'video_id'       => $request->video_id ,
                    'total_amount'  => $invoice->getTotalAmount() , 
                    'admin_commssion'     => $admin_commssion,
                    'moderator_commssion' => $moderator_commssion,
                    'status'     => 'active',
                    'from_time'  => Carbon::now()->format('Y-m-d H:i:s a'),
                    'to_time'    => $to_time,
                    'moderator_id' => $moderator_id,
                    'payment_gateway'  => 'Paydunya',
                    'payment_in'       => 'website',
                ]);


                $respond = array(
                    'status'  => 'true',
                    'redirect_url' => URL::to('category/videos/'. $video->slug) ,
                    'message'   => 'Video Payment Purchase Successfully !!' ,
                );
            }

        } catch (\Exception $e) {

            $video = Video::where('id','=',$request->video_id)->first();

            $respond = array(
                'status'  => 'false',
                'redirect_url' => URL::to('category/videos/'. $video->slug) ,
                'message'   => $e->getMessage() ,
            );
        }

        return Theme::view('paydunya.Message',compact('respond'),$respond);
    }

    // PPV Series Season
    
    public function Paydunya_SeriesSeason_checkout_Rent_payment(Request $request,$SeriesSeason_id,$amount)
    {
        try {

            $SeriesSeason = SeriesSeason::where('id',$SeriesSeason_id)->first();
            $series_id = $SeriesSeason->series_id;
            $series = Series::find($series_id);

            \Paydunya\Checkout\Store::setName( GetWebsiteName() ); 
            \Paydunya\Checkout\Store::setWebsiteUrl( URL::to('/') );
            \Paydunya\Checkout\Store::setLogoUrl(  front_end_logo() );
            \Paydunya\Checkout\Store::setReturnUrl( URL::to('Paydunya_SeriesSeason_Rent_payment_verify?SeriesSeason_id='.$SeriesSeason_id) );

            \Paydunya\Setup::setMasterKey($this->paydunya_masterkey);
            \Paydunya\Setup::setPublicKey( $this->Paydunya_publish_key );
            \Paydunya\Setup::setPrivateKey($this->Paydunya_private_key);
            \Paydunya\Setup::setToken($this->Paydunya_token_key);
            \Paydunya\Setup::setMode( $this->Paydunya_set_mode  ); 

              // Currency Conversation 
                
            if(CurrencySetting::pluck('enable_multi_currency')->first() == 1 ){

                $To_Currency_symbol = 'XOF';

                $default_Currency = CurrencySetting::first();

                $From_Currency_symbol = Currency::where('country',@$default_Currency->country)->pluck('code')->first();

                $api_url = "https://open.er-api.com/v6/latest/{$From_Currency_symbol}";

                try {

                    $response = Http::get($api_url);
                
                    $exchangeRates = $response->json();
                
                    if (isset($exchangeRates['rates'])) {
                        $targetCurrency = $To_Currency_symbol;
                
                        if (isset($exchangeRates['rates'][$targetCurrency])) {
                            $conversionRate = $exchangeRates['rates'][$targetCurrency];
                            $convertedAmount = $amount * $conversionRate;
                        } else {
                            $convertedAmount = null;

                            return response()->json( array(
                                "status"  => false ,
                                "message" => "Error on Currency Conversation, Pls connect admin" ,
                            ), 200);
                        }
                    } else {
                        $convertedAmount = null;

                        $Error_msg = 'Error on Currency Conversation, Pls connect admin' ;
                        $url = URL::to('play_series/'.$series->slug);
                        echo "<script type='text/javascript'>alert('$Error_msg'); window.location.href = '$url' </script>";
                    }
                
                } catch (\Exception $e) {

                        $Error_msg = $e->getMessage();
                        $url = URL::to('play_series/'.$series->slug);
                        echo "<script type='text/javascript'>alert('$Error_msg'); window.location.href = '$url' </script>";
                }

                $payment_amount = (float)$convertedAmount ;

            }else{

                $payment_amount = (float) $amount ;

            }

                // Checkout Page Creation 

            $invoice = new \Paydunya\Checkout\CheckoutInvoice();
            $invoice->addItem("", 1, $payment_amount , $payment_amount );
            $invoice->setTotalAmount($payment_amount);

            if($invoice->create()) {
                $authorization_url =  $invoice->getInvoiceUrl() ;
                return Redirect::to($authorization_url);
            }else{
                
                $Error_msg = $invoice->response_text ;
                $url = URL::to('play_series/'.$series->slug);
                echo "<script type='text/javascript'>alert('$Error_msg'); window.location.reload(); </script>";
            }

        } catch (\Throwable $th) {

            $Error_msg = $th->getMessage() ; 
            $url = URL::to('play_series/'.$series->slug);
            echo "<script type='text/javascript'>alert('$Error_msg'); window.location.reload(); </script>";
        }
    }

    public function Paydunya_SeriesSeason_Rent_payment_verify(Request $request)
    {
        try {

            \Paydunya\Setup::setMasterKey($this->paydunya_masterkey);
            \Paydunya\Setup::setPublicKey( $this->Paydunya_publish_key );
            \Paydunya\Setup::setPrivateKey($this->Paydunya_private_key);
            \Paydunya\Setup::setToken($this->Paydunya_token_key);
            \Paydunya\Setup::setMode( $this->Paydunya_set_mode  ); 
            
            $SeriesSeason = SeriesSeason::where('id',$request->SeriesSeason_id)->first();
            $series_id = $SeriesSeason->series_id;
            $series = Series::find($series_id);

            $token   = $request->token;

            $invoice = new \Paydunya\Checkout\CheckoutInvoice();

            if ($invoice->confirm($token)) {
        
                $ppv_expirytime_started = Setting::pluck('ppv_hours')->first();
                $to_time = $ppv_expirytime_started != null  ? Carbon::now()->addHours($ppv_expirytime_started)->format('Y-m-d h:i:s a') : Carbon::now()->addHours(3)->format('Y-m-d h:i:s a');
                
                if(!empty($request->SeriesSeason_id)){
                    $moderators_id = $SeriesSeason->user_id;
                }


                if(!empty($moderators_id)){
                    $moderator           =  ModeratorsUser::where('id',$moderators_id)->first();  
                    $total_amount        =  $SeriesSeason->ppv_price;
                    $title               =  $SeriesSeason->series_seasons_name;
                    $commssion           =  VideoCommission::first();
                    $percentage          =  $commssion->percentage; 
                    $ppv_price           =  $SeriesSeason->ppv_price;
                    $admin_commssion     =  ($percentage/100) * $ppv_price ;
                    $moderator_commssion =  $ppv_price - $percentage;
                    $moderator_id        =  $moderators_id;
                }else{
                    $total_amount       =   $SeriesSeason->ppv_price;
                    $title              =   $SeriesSeason->series_seasons_name;
                    $commssion          =   VideoCommission::first();
                    $ppv_price          =   $SeriesSeason->ppv_price;
                    $percentage         =   null; 
                    $admin_commssion    =   null;
                    $moderator_commssion =  null;
                    $moderator_id        =  null;
                }

                PpvPurchase::create([
                    'user_id'         =>  Auth::user()->id ,
                    'season_id'       => $request->SeriesSeason_id ,
                    'series_id'       => $series_id ,
                    'total_amount'    => $invoice->getTotalAmount() , 
                    'admin_commssion'     => $admin_commssion,
                    'moderator_commssion' => $moderator_commssion,
                    'status'     => 'active',
                    'from_time'  => Carbon::now()->format('Y-m-d H:i:s a'),
                    'to_time'    => $to_time,
                    'moderator_id' => $moderator_id,
                    'payment_gateway'  => 'Paydunya',
                    'payment_in'       => 'website',
                ]);


                $respond = array(
                    'status'  => 'true',
                    'redirect_url' => URL::to('play_series/'.$series->slug),
                    'message'   => 'Series Season Payment Purchase Successfully !!' ,
                );
            }

        } catch (\Exception $e) {

            $respond = array(
                'status'  => 'false',
                'redirect_url' => URL::to('play_series/'.$series->slug),
                'message'   => $e->getMessage() ,
            );

        }

        return Theme::view('paydunya.Message',compact('respond'),$respond);
    }
}
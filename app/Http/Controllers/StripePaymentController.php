<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\PayRequestTranscation;
use App\Subscription;
use App\SubscriptionPlan;
use App\PaymentSetting;
use App\EmailTemplate;
use App\CurrencySetting;
use App\HomeSetting;
use App\ModeratorsUser;
use App\VideoCommission;
use App\PpvPurchase;
use App\LivePurchase;
use App\LiveStream;
use App\Setting;
use App\Currency;
use App\SeriesSeason;
use App\Video;
use App\Series;
use App\User;
use Theme;

class StripePaymentController extends Controller
{
    public function __construct()
    {
        $this->Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses($this->Theme);

        $this->stripe_payment = PaymentSetting::where('payment_type','Stripe')->where('status',1)->first();
    }

    // Subscription

    public function Stripe_authorization_url(Request $request)
    {
        try {

            PayRequestTranscation::create([
                'user_id'     => Auth::user()->id,
                'source_name' => null,
                'source_id'   => null,
                'source_type' => 'subscription',
                'platform'    => "Stripe",
                'transform_form' => "subscription",
                'amount' => $amount,
                'date' => Carbon::now()->toDateString(),
                'status' => 'hold' ,
            ]);
            
            $stripe = new \Stripe\StripeClient( env('STRIPE_SECRET') );
        
            $success_url = URL::to('Stripe_payment_success?stripe_payment_session_id={CHECKOUT_SESSION_ID}') ;
            
            $Plan_id = $request->Stripe_Plan_id;

            if( Auth::User()  != null){
                $user_details =Auth::User();
                $redirection_back = URL::to('/becomesubscriber'); 
            }else{
                $userEmailId  = $request->session()->get('register.email');
                $user_details = User::where('email',$userEmailId)->first();
                $redirection_back = URL::to('/register2'); 
            }

            $Subscription_Plan = SubscriptionPlan::where('plan_id',$Plan_id)->latest()->first();
           
            // Stripe Checkout

            $Checkout_details = array(
                'success_url' => $success_url,
                
                'line_items' => [
                    [
                        'price' => $Plan_id,
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'subscription',
                'customer_email' => $user_details->email, 
            );
            
                // Trail days

            if (subscription_trails_status() == 1) {

                $Trail_days = PaymentSetting::where('payment_type','=','Stripe')->pluck('subscription_trail_days')->first();

                $Checkout_details['subscription_data'] = [
                    'trial_period_days' => $Trail_days,
                ];
            }

                // Stripe Promo Code auto

            try {

                if ( $Subscription_Plan->auto_stripe_promo_code_status == 1) {

                    $stripe->promotionCodes->retrieve($Subscription_Plan->auto_stripe_promo_code, []);            // Verify Promo Code 

                    $Checkout_details['discounts'] = [['promotion_code' => $Subscription_Plan->auto_stripe_promo_code ]];
                }
                else{
    
                    $Checkout_details['allow_promotion_codes'] = true ;
                }

            } catch (\Throwable $th) {

                $Checkout_details['allow_promotion_codes'] = true ;
            }

            $stripe_checkout = $stripe->checkout->sessions->create($Checkout_details);

            $response = array(
                'status'           => true ,
                'message'          => "Authorization url Successfully Created !" , 
                'Plan_id'          => $request->Stripe_Plan_id ,
                'authorization_url' => $stripe_checkout->url,
            );  

        } catch (\Throwable $th) {
            $response = array(
                "status"  => false ,
                "message" => $th->getMessage() , 
            );
        }

        return response()->json($response, 200);
    }
  
    public function Stripe_payment_success(Request $request)
    {
        try {
         
            $stripe = new \Stripe\StripeClient( env('STRIPE_SECRET') );

                            // Retrieve Payment Session
            $stripe_payment_session_id = $request->stripe_payment_session_id ;
            $stripe_payment_session = $stripe->checkout->sessions->retrieve( $stripe_payment_session_id );

            if( $stripe_payment_session->status == "complete"){

                                // Retrieve Subscriptions
                $subscription = $stripe->subscriptions->retrieve(  $stripe_payment_session->subscription );

                $latest_invoice = $stripe->invoices->retrieve($subscription->latest_invoice);

                $stripe_payment_id = $latest_invoice->payment_intent;
              
                                // User & Subscription data storing
                $user = User::where('email',$stripe_payment_session->customer_email )->first();

                if( subscription_trails_status() == 1 ){

                    $subscription_days_count = $subscription['plan']['interval_count'];
            
                    switch ($subscription['plan']['interval']) {
          
                      case 'day':
                        break;
  
                      case 'week':
                        $subscription_days_count *= 7;
                      break;
  
                      case 'month':
                        $subscription_days_count *= 30;
                      break;
  
                      case 'year':
                        $subscription_days_count *= 365;
                      break;
                    }
          
                    $Sub_Startday  = Carbon::createFromTimestamp($subscription['current_period_start'])->toDateTimeString(); 
                    $Sub_Endday    = Carbon::createFromTimestamp($subscription['current_period_end'])->addDays($subscription_days_count)->toDateTimeString(); 
                    $trial_ends_at = Carbon::createFromTimestamp($subscription['current_period_end'])->addDays($subscription_days_count)->toDateTimeString(); 
  
                }else{

                    $Sub_Startday  = Carbon::createFromTimestamp($subscription['current_period_start'])->toDateTimeString(); 
                    $Sub_Endday    = Carbon::createFromTimestamp($subscription['current_period_end'])->toDateTimeString(); 
                    $trial_ends_at = Carbon::createFromTimestamp($subscription['current_period_end'])->toDateTimeString(); 
                
                }

                Subscription::create([
                    'user_id'        =>  $user->id,
                    'name'           =>  $subscription->plan['product'],
                    'price'          =>  $subscription->plan['amount_decimal'] / 100,   // Amount Paise to Rupees
                    'stripe_id'      =>  $subscription['id'],
                    'stripe_status'  =>  $subscription['status'],
                    'stripe_plan'    =>  $subscription->plan['id'],
                    'quantity'       =>  $subscription['quantity'],
                    'countryname'    =>  Country_name(),
                    'regionname'     =>  Region_name(),
                    'cityname'       =>  city_name(),
                    'PaymentGateway' =>  'Stripe',
                    'trial_ends_at'  =>  $trial_ends_at,
                    'ends_at'        =>  $trial_ends_at,
                    'coupon_used'    =>  !is_null($subscription['discount'] ) ?  $subscription['discount']->promotion_code : null,
                    'platform'       => 'WebSite',
                    'payment_id'     => $stripe_payment_id,
                ]);

                $user_data = array(
                    'role'                  =>  'subscriber',
                    'stripe_id'             =>  $subscription['id'],
                    'subscription_start'    =>  $Sub_Startday,
                    'subscription_ends_at'  =>  $Sub_Endday,
                    'payment_type'          => 'recurring',
                    'payment_status'        => $subscription['status'],
                    'payment_gateway'       =>  'Stripe',
                    'coupon_used'           =>  !is_null($subscription['discount']) ?  $subscription['discount']->promotion_code : null ,
                );

                if( subscription_trails_status()  == 1 ){
                    $user_data +=  ['Subscription_trail_status' => 1 ];
                    $user_data +=  ['Subscription_trail_tilldate' => subscription_trails_day() ];
                }

                User::where('id',$user->id)->update( $user_data );
             
                                // Mail
                try {

                    $email_subject = EmailTemplate::where('id',23)->pluck('heading')->first() ;
                    $plandetail = SubscriptionPlan::where('plan_id','=',$subscription->plan['id'])->first();

                    $nextPaymentAttemptDate =  Carbon::createFromTimeStamp( $subscription['current_period_end'] )->format('F jS, Y')  ;

                    \Mail::send('emails.subscriptionmail', array(

                        'name'          => ucwords($user->username),
                        'paymentMethod' => ucwords('recurring'),
                        'plan'          => ucfirst($plandetail->plans_name),
                        'price'         => $subscription->plan['amount_decimal'] / 100 ,
                        'plan_id'       => $subscription['plan']['id'] ,
                        'billing_interval'  => $subscription['plan']['interval'] ,
                        'next_billing'      => $nextPaymentAttemptDate,
                        'subscription_type' => 'recurring',
                    ), 

                    function($message) use ($request,$user,$email_subject){
                        $message->from(AdminMail(),GetWebsiteName());
                        $message->to($user->email, $user->username)->subject($email_subject);
                    });

                    $email_log      = 'Mail Sent Successfully from Become Subscription';
                    $email_template = "23";
                    $user_id = $user->id;

                    Email_sent_log($user_id,$email_log,$email_template);

                } catch (\Throwable $th) {

                    $email_log      = $th->getMessage();
                    $email_template = "23";
                    $user_id = $user->id;

                    Email_notsent_log($user_id,$email_log,$email_template);
                }

                $respond = array(
                    'status'  => 'true',
                    'redirect_url' => URL::to('/home'),
                    'message'   => 'Your Subscriber Payment done Successfully' ,
                );
    
            }else{
                $respond = array(
                    'status'   => "false",
                    'redirect_url' => URL::to('/becomesubscriber'),
                    'message'  => "Some errors occurred while subscribing. Please connect, Admin!",
                );
            }

        } catch (\Throwable $th) {
        
            $respond = array(
                'status'   => "false",
                'redirect_url' => URL::to('/becomesubscriber'),
                'message'  => "Some errors occurred while subscribing. Please connect, Admin!",
            );
        }

        return Theme::view('stripe_payment.message',compact('respond'),$respond);
    }

    public function Stripe_payment_fails(Request $request)
    {
      return redirect()->back();
    }

    // PPV Live

    public function Stripe_payment_live_PPV_Purchase( $live_id,$amount)
    {
        try {

            if( Auth::guest()){
                return redirect('login');
            }

            PayRequestTranscation::create([
                'user_id'     => Auth::user()->id,
                'source_name' => $live_id,
                'source_id'   => $live_id,
                'source_type' => 'livestream',
                'platform'    => "Stripe",
                'transform_form' => "PPV",
                'amount' => $amount,
                'date' => Carbon::now()->format('Y-m-d H:i:s a'),
                'status' => 'hold' ,
            ]);

            $rokuTvCode = request()->get('roku_tvcode');
            session(['roku_tvcode' => $rokuTvCode]);
            
            $stripe = new \Stripe\StripeClient( env('STRIPE_SECRET') );
            $success_url = URL::to('Stripe_payment_live_PPV_Purchase_verify/{CHECKOUT_SESSION_ID}/'.$live_id ) ;

            $default_Currency = CurrencySetting::first();

               // Checkout Page Creation 
                
            if(CurrencySetting::pluck('enable_multi_currency')->first() == 1 ){

                $To_Currency_symbol = Currency::where('country',Country_name())->pluck('code')->first();

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
                $To_Currency_symbol = CurrencySetting::query()->join('currencies','currencies.country','=','currency_settings.country') 
                                                            ->pluck('code')->first();
            }

                // p24 Payment Mode

            $payment_method_types = ['card'];

            if( $this->stripe_payment->stripe_p24_mode == 1 ){

                $To_Currency_symbol = 'pln';
                $payment_method_types =  ['card', 'p24'];
                
            }

            // Stripe Checkout

            $Checkout_details = array(
                'success_url' => $success_url,
                
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => $To_Currency_symbol ,
                            'product_data' => [
                                'name' => GetWebsiteName(),
                            ],
                            'unit_amount' =>  $payment_amount * 100, 
                        ],
                        'quantity' => 1,
                    ],
                ],
                'payment_method_types' => $payment_method_types,
                'mode' => 'payment', 
                'customer_email' => Auth::user()->email, 
            );
            
            $stripe_checkout = $stripe->checkout->sessions->create($Checkout_details);

            $url = $stripe_checkout->url;
            echo "<script type='text/javascript'> window.location.href = '$url' </script>";

        } catch (\Throwable $th) {

            // return $th->getMessage();

            $video = LiveStream::where('id',$live_id)->first();

            $Error_msg = "Error on Payment, Pls Connect admin" ;
            $url = URL::to('live/'. $video->slug);

            echo "<script type='text/javascript'>alert('$Error_msg'); window.location.href = '$url' </script>";
        }
    }

    public function Stripe_payment_live_PPV_Purchase_verify($stripe_payment_session_id,$live_id)
    {
        try {

            $stripe = new \Stripe\StripeClient( env('STRIPE_SECRET') );

                            // Retrieve Payment Session
            $stripe_payment_session_id = $stripe_payment_session_id ;
            $stripe_payment_session = $stripe->checkout->sessions->retrieve( $stripe_payment_session_id );
            $stripe_payment_id = $stripe_payment_session->payment_intent;
            $paymentIntent = $stripe->paymentIntents->retrieve($stripe_payment_id);

            $rokuTvCode = session('roku_tvcode');

            // dd($rokuTvCode);
                $video = LiveStream::where('id',$live_id)->first();

                $setting = Setting::first();  
                $ppv_hours = $setting->ppv_hours;
    
                $to_time = ppv_expirytime_started(); 

                if(!empty($video)){
                    $moderators_id = $video->user_id;
                }

                if(!empty($moderators_id)){
                    $moderator           =  ModeratorsUser::where('id',$moderators_id)->first();
                    $percentage = $moderator ? $moderator->commission_percentage : 0; 
                    $total_amount        =   (integer) $stripe_payment_session->amount_total / 100;
                    $title               =  $video->title;
                    $commssion           =  VideoCommission::where('type','CPP')->first();
                    // $percentage          =  $moderator->commission_percentage; 
                    $ppv_price           =  $video->ppv_price;
                    $moderator_commssion =  ($percentage/100) * $ppv_price ;
                    $admin_commssion     =  $ppv_price - $moderator_commssion;
                    $moderator_id        =  $moderators_id;
                }else{
                    $total_amount       =    (integer) $stripe_payment_session->amount_total / 100;
                    $title              =   $video->title;
                    $commssion          =  VideoCommission::where('type','CPP')->first();
                    $ppv_price          =   $video->ppv_price;
                    $percentage         =   null; 
                    $admin_commssion    =   null;
                    $moderator_commssion =  null;
                    $moderator_id        =  null;
                }
            
                PpvPurchase::create([
                    'user_id'       =>  Auth::user()->id ,
                    'live_id'       => $live_id ,
                    'total_amount'  =>  (integer) $stripe_payment_session->amount_total / 100 , 
                    'admin_commssion'     => $admin_commssion,
                    'moderator_commssion' => $moderator_commssion,
                    'status'     => $paymentIntent->status,
                    'to_time'    => $to_time,
                    'from_time'  => Carbon::now()->format('Y-m-d H:i:s'),
                    'moderator_id' => $moderator_id,
                    'payment_gateway'  => 'Stripe',
                    'payment_in'       => 'website',
                    'platform'       => 'website',
                    'payment_id' => $stripe_payment_id ,
                    'roku_tvcode'    =>  $rokuTvCode,
                ]);
 
                LivePurchase::create([
                    'user_id' =>  Auth::user()->id ,
                    'video_id' => $live_id,
                    'to_time' => $to_time,
                    'expired_date' => $to_time,
                    'amount' =>   (integer) $stripe_payment_session->amount_total / 100 ,
                    'from_time' => Carbon::now()->format('Y-m-d H:i:s'),
                    'unseen_expiry_date' => ppv_expirytime_notstarted(),
                    'status' => 1,
                    'payment_gateway'  => 'Stripe',
                    'payment_in'       => 'website',
                    'platform'       => 'website',
                    'payment_id' => $stripe_payment_id ,
                    'payment_status' => $paymentIntent->status,
                    // 'roku_tvcode'    =>  $rokuTvCode,
                ]);

                $respond = array(
                    'status'  => 'true',
                    'redirect_url' => URL::to('live/'. $video->slug) ,
                    'message'   => 'Live Payment Purchase Successfully !!' ,
                );

        } catch (\Exception $e) {

            $video = LiveStream::where('id',$live_id)->first();
            // return $e->getMessage();
            $respond = array(
                'status'  => 'false',
                'redirect_url' => URL::to('live/'. $video->slug) ,
                'message'   => $e->getMessage() ,
            );
        }

        return Theme::view('stripe_payment.message',compact('respond'),$respond);
    }

    // PPV Video

    public function Stripe_payment_video_PPV_Purchase( $video_id,$amount)
    {
        try {

            if( Auth::guest()){
                return redirect('login');
            }

            PayRequestTranscation::create([
                'user_id'     => Auth::user()->id,
                'source_name' => $video_id,
                'source_id'   => $video_id,
                'source_type' => 'videos',
                'platform'    => "Stripe",
                'transform_form' => "PPV",
                'amount' => $amount,
                'date' => Carbon::now()->format('Y-m-d H:i:s a'),
                'status' => 'hold' ,
            ]);

            $stripe = new \Stripe\StripeClient( env('STRIPE_SECRET') );
            $success_url = URL::to('Stripe_payment_video_PPV_Purchase_verify/{CHECKOUT_SESSION_ID}/'.$video_id ) ;
            $default_Currency = CurrencySetting::first();

               // Checkout Page Creation 
                
            if(CurrencySetting::pluck('enable_multi_currency')->first() == 1 ){

                $To_Currency_symbol = Currency::where('country',Country_name())->pluck('code')->first();

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

                        $video = Video::where('id',$video_id)->first();

                        $Error_msg = 'Error on Currency Conversation, Pls connect admin' ;
                        $url = URL::to('category/videos/'. $video->slug);
                        echo "<script type='text/javascript'>alert('$Error_msg'); window.location.href = '$url' </script>";
                    }
                
                } catch (\Exception $e) {
                        $video = Video::where('id',$video_id)->first();

                        $Error_msg = $e->getMessage();
                        $url = URL::to('category/videos/'. $video->slug);
                        echo "<script type='text/javascript'>alert('$Error_msg'); window.location.href = '$url' </script>";
                }

                $payment_amount = $convertedAmount ;

            }else{

                $payment_amount = $amount ;
                $To_Currency_symbol = CurrencySetting::query()->join('currencies','currencies.country','=','currency_settings.country') 
                                                            ->pluck('code')->first();
            }

            // p24 Payment Mode

            $payment_method_types = ['card'];

            if( $this->stripe_payment->stripe_p24_mode == 1 ){

                $To_Currency_symbol = 'pln';
                $payment_method_types =  ['card', 'p24'];

            }

            $Checkout_details = array(
                'success_url' => $success_url,
                
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => $To_Currency_symbol ,
                            'product_data' => [
                                'name' => GetWebsiteName(),
                            ],
                            'unit_amount' =>  $payment_amount * 100, 
                        ],
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'payment', 
                'payment_method_types' => $payment_method_types,
                'customer_email' => Auth::user()->email, 
            );
            $stripe_checkout = $stripe->checkout->sessions->create($Checkout_details);

            $url = $stripe_checkout->url;
            echo "<script type='text/javascript'> window.location.href = '$url' </script>";

        } catch (\Throwable $th) {

            $video = Video::where('id',$video_id)->first();

            $Error_msg = "Error on Payment, Pls Connect admin" ;
            $url = URL::to('category/videos/'. $video->slug);

            echo "<script type='text/javascript'>alert('$Error_msg'); window.location.href = '$url' </script>";
        }
    }

    public function Stripe_payment_video_PPV_Purchase_verify($stripe_payment_session_id,$video_id)
    {
        try {

            $stripe = new \Stripe\StripeClient( env('STRIPE_SECRET') );

            // Retrieve Payment Session
            $stripe_payment_session_id = $stripe_payment_session_id ;
            $stripe_payment_session = $stripe->checkout->sessions->retrieve( $stripe_payment_session_id );
            $stripe_payment_id = $stripe_payment_session->payment_intent;
            $paymentIntent = $stripe->paymentIntents->retrieve($stripe_payment_id);

            $video = Video::where('id',$video_id)->first();

    
            $setting = Setting::first();  
            $ppv_hours = $setting->ppv_hours;
            $ppv_expirytime_started = Setting::pluck('ppv_hours')->first();
            $to_time = $ppv_expirytime_started != null  ? Carbon::now()->addHours($ppv_expirytime_started)->format('Y-m-d h:i:s a') : Carbon::now()->addHours(3)->format('Y-m-d h:i:s a');

            if(!empty($video)){
                $moderators_id = $video->user_id;
            }

            if(!empty($moderators_id)){
                $moderator           =  ModeratorsUser::where('id',$moderators_id)->first();  
                $percentage = $moderator ? $moderator->commission_percentage : 0; 
                $total_amount        =   (integer) $stripe_payment_session->amount_total / 100;
                $title               =  $video->title;
                $commssion           =  VideoCommission::where('type','CPP')->first();
                $ppv_price           =  $video->ppv_price;
                $moderator_commssion =  ($percentage/100) * $ppv_price ;
                $admin_commssion     =  $ppv_price - $moderator_commssion;
                $moderator_id        =  $moderators_id;
            }else{
                $total_amount       =    (integer) $stripe_payment_session->amount_total / 100;
                $title              =   $video->title;
                $commssion          =  VideoCommission::where('type','CPP')->first();
                $ppv_price          =   $video->ppv_price;
                $percentage         =   null; 
                $admin_commssion    =   null;
                $moderator_commssion =  null;
                $moderator_id        =  null;
            }



            PpvPurchase::create([
                'user_id'       =>  Auth::user()->id ,
                'video_id'       => $video->id ,
                'total_amount'  =>  (integer) $stripe_payment_session->amount_total / 100 , 
                'admin_commssion'     => $admin_commssion,
                'moderator_commssion' => $moderator_commssion,
                'status'     => $paymentIntent->status,
                'to_time'    => $to_time,
                'from_time'  => Carbon::now()->format('Y-m-d H:i:s a'),
                'moderator_id' => $moderator_id,
                'payment_gateway'  => 'Stripe',
                'payment_in'       => 'website',
                'platform'       => 'website',
                'payment_id' => $stripe_payment_id,
            ]);


            $respond = array(
                'status'  => 'true',
                'redirect_url' => URL::to('category/videos/'. $video->slug) ,
                'message'   => 'Video Payment Purchase Successfully !!' ,
            );

        } catch (\Exception $e) {

            $respond = array(
                'status'  => 'false',
                'redirect_url' => URL::to('category/videos/'. $video->slug) ,
                'message'   => $e->getMessage() ,
            );
        }

        return Theme::view('stripe_payment.message',compact('respond'),$respond);
    }

    // PPV Series Season

    public function Stripe_payment_series_season_PPV_Purchase( $SeriesSeason_id,$amount)
    {
        try {
            
            if( Auth::guest()){
                return redirect('login');
            }

            PayRequestTranscation::create([
                'user_id'     => Auth::user()->id,
                'source_name' => $SeriesSeason_id,
                'source_id'   => $SeriesSeason_id,
                'source_type' => 'series season',
                'platform'    => "Stripe",
                'transform_form' => "PPV",
                'amount' => $amount,
                'date' => Carbon::now()->format('Y-m-d H:i:s a'),
                'status' => 'hold' ,
            ]);

            $rokuTvCode = request()->get('roku_tvcode');
            session(['roku_tvcode' => $rokuTvCode]);
            
            $stripe = new \Stripe\StripeClient( env('STRIPE_SECRET') );
            $success_url = URL::to('Stripe_payment_series_season_PPV_Purchase_verify/{CHECKOUT_SESSION_ID}/'.$SeriesSeason_id ) ;

            // dd($SeriesSeason_id);
            $SeriesSeason = SeriesSeason::where('id',$SeriesSeason_id)->first();
            $series_id = $SeriesSeason->series_id;
            $series = Series::find($series_id);

            $default_Currency = CurrencySetting::first();

               // Checkout Page Creation 
                
            if(CurrencySetting::pluck('enable_multi_currency')->first() == 1 ){

                $To_Currency_symbol = Currency::where('country',Country_name())->pluck('code')->first();

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

                $payment_amount = $convertedAmount ;

            }else{

                $payment_amount = $amount ;
                $To_Currency_symbol = CurrencySetting::query()->join('currencies','currencies.country','=','currency_settings.country') 
                                                            ->pluck('code')->first();
            }

             // p24 Payment Mode

            $payment_method_types = ['card'];

            if( $this->stripe_payment->stripe_p24_mode == 1 ){

                $To_Currency_symbol = 'pln';
                $payment_method_types =  ['card', 'p24'];
                
            }
            
            // Stripe Checkout

            $Checkout_details = array(
                'success_url' => $success_url,
                
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => $To_Currency_symbol ,
                            'product_data' => [
                                'name' => GetWebsiteName(),
                            ],
                            'unit_amount' =>  $payment_amount * 100, 
                        ],
                        'quantity' => 1,
                    ],
                ],
                'payment_method_types' => $payment_method_types,
                'mode' => 'payment', 
                'customer_email' => Auth::user()->email, 
            );
            
            $stripe_checkout = $stripe->checkout->sessions->create($Checkout_details);

            $url = $stripe_checkout->url;
            echo "<script type='text/javascript'> window.location.href = '$url' </script>";

        } catch (\Throwable $th) {
            // return $th->getMessage();
            $Error_msg = "Error on Payment, Pls Connect admin" ;
            $url = URL::to('play_series/'.$series->slug);

            echo "<script type='text/javascript'>alert('$Error_msg'); window.location.href = '$url' </script>";
        }
    }

    public function Stripe_payment_series_season_PPV_Purchase_verify( $stripe_payment_session_id, $SeriesSeason_id)
    {
        try{

            $stripe = new \Stripe\StripeClient( env('STRIPE_SECRET') );

                            // Retrieve Payment Session
            $stripe_payment_session_id = $stripe_payment_session_id ;
            $stripe_payment_session = $stripe->checkout->sessions->retrieve( $stripe_payment_session_id );
            $stripe_payment_id = $stripe_payment_session->payment_intent;
            $paymentIntent = $stripe->paymentIntents->retrieve($stripe_payment_id);

            $SeriesSeason = SeriesSeason::where('id',$SeriesSeason_id)->first();
            $series_id = $SeriesSeason->series_id;
            $series = Series::find($series_id);

            $rokuTvCode = session('roku_tvcode');
            
            // dd($rokuTvCode);

            if( $stripe_payment_session->status == "complete"){
        
                $ppv_expirytime_started = Setting::pluck('ppv_hours')->first();
                $to_time = $ppv_expirytime_started != null  ? Carbon::now()->addHours($ppv_expirytime_started)->format('Y-m-d h:i:s a') : Carbon::now()->addHours(3)->format('Y-m-d h:i:s a');
                
                if(!empty($request->SeriesSeason_id)){
                    $moderators_id = $SeriesSeason->user_id;
                }

                if(!empty($moderators_id)){
                    $moderator           =  ModeratorsUser::where('id',$moderators_id)->first();  
                    $percentage = $moderator ? $moderator->commission_percentage : 0; 
                    $total_amount        =   (integer) $stripe_payment_session->amount_total / 100;
                    $title               =  $video->title;
                    $commssion           =  VideoCommission::where('type','CPP')->first();
                    $ppv_price           =  $video->ppv_price;
                    $moderator_commssion =  ($percentage/100) * $ppv_price ;
                    $admin_commssion     =  $ppv_price - $moderator_commssion;
                    $moderator_id        =  $moderators_id;
                }else{
                    $total_amount       =   $SeriesSeason->ppv_price;
                    $title              =   $SeriesSeason->series_seasons_name;
                    $commssion          =  VideoCommission::where('type','CPP')->first();
                    $ppv_price          =   $SeriesSeason->ppv_price;
                    $percentage         =   null; 
                    $admin_commssion    =   null;
                    $moderator_commssion =  null;
                    $moderator_id        =  null;
                }

                PpvPurchase::create([
                    'user_id'         =>  Auth::user()->id ,
                    'season_id'       => $SeriesSeason_id ,
                    'series_id'       => $series_id ,
                    'total_amount'        =>   (integer) $stripe_payment_session->amount_total / 100,
                    'admin_commssion'     => $admin_commssion,
                    'moderator_commssion' => $moderator_commssion,
                    'status'     =>  $paymentIntent->status,
                    'from_time'  => Carbon::now()->format('Y-m-d H:i:s a'),
                    'to_time'    => $to_time,
                    'moderator_id' => $moderator_id,
                    'payment_gateway'  => 'Stripe',
                    'payment_in'       => 'website',
                    'platform'       => 'website',
                    'roku_tvcode'    =>  $rokuTvCode,
                    'payment_id' =>   $stripe_payment_id,
                ]);

                $respond = array(
                    'status'  => 'true',
                    'redirect_url' => URL::to('play_series/'. $series->slug) ,
                    'message'   => 'Video Payment Purchase Successfully !!' ,
                );
            }

        } catch (\Exception $e) {

            $respond = array(
                'status'  => 'false',
                'redirect_url' => URL::to('play_series/'. $series->slug) ,
                'message'   => $e->getMessage() ,
            );
        }

        return Theme::view('stripe_payment.message',compact('respond'),$respond);
    }
    
    // PPV Series

    public function Stripe_payment_series_PPV_Purchase( $Series_id,$amount)
    {
        try {

            if( Auth::guest()){
                return redirect('login');
            }

            PayRequestTranscation::create([
                'user_id'     => Auth::user()->id,
                'source_name' => $Series_id,
                'source_id'   => $Series_id,
                'source_type' => 'series',
                'platform'    => "Stripe",
                'transform_form' => "PPV",
                'amount' => $amount,
                'date'   => Carbon::now()->format('Y-m-d H:i:s a'),
                'status' => 'hold' ,
            ]);

            // $amount = 100 ;

            $stripe = new \Stripe\StripeClient( env('STRIPE_SECRET') );
            $success_url = URL::to('Stripe_payment_series_PPV_Purchase_verify/{CHECKOUT_SESSION_ID}/'.$Series_id ) ;

            $Series = Series::where('id',$Series_id)->first();

            $default_Currency = CurrencySetting::first();

               // Checkout Page Creation 
                
            if(CurrencySetting::pluck('enable_multi_currency')->first() == 1 ){

                $To_Currency_symbol = Currency::where('country',Country_name())->pluck('code')->first();

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
                        $url = URL::to('play_series/'.$Series->slug);
                        echo "<script type='text/javascript'>alert('$Error_msg'); window.location.href = '$url' </script>";
                    }
                
                } catch (\Exception $e) {

                        $Error_msg = $e->getMessage();
                        $url = URL::to('play_series/'.$Series->slug);
                        echo "<script type='text/javascript'>alert('$Error_msg'); window.location.href = '$url' </script>";
                }

                $payment_amount = $convertedAmount ;

            }else{

                $payment_amount = $amount ;
                $To_Currency_symbol = CurrencySetting::query()->join('currencies','currencies.country','=','currency_settings.country') 
                                                            ->pluck('code')->first();
            }

            // p24 Payment Mode

            $payment_method_types = ['card'];

            if( $this->stripe_payment->stripe_p24_mode == 1 ){

                $To_Currency_symbol = 'pln';
                $payment_method_types =  ['card', 'p24'];
                
            }

            // Stripe Checkout

            $Checkout_details = array(
                'success_url' => $success_url,
                
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => $To_Currency_symbol ,
                            'product_data' => [
                                'name' => GetWebsiteName(),
                            ],
                            'unit_amount' =>  $payment_amount * 100, 
                        ],
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'payment', 
                'payment_method_types' => $payment_method_types,
                'customer_email' => Auth::user()->email, 
            );
            
            $stripe_checkout = $stripe->checkout->sessions->create($Checkout_details);

            $url = $stripe_checkout->url;
            echo "<script type='text/javascript'> window.location.href = '$url' </script>";

        } catch (\Throwable $th) {

            $Error_msg = "Error on Payment, Pls Connect admin" ;
            $url = URL::to('play_series/'.$Series->slug);

            echo "<script type='text/javascript'>alert('$Error_msg'); window.location.href = '$url' </script>";
        }
    }

    public function Stripe_payment_series_PPV_Purchase_verify( $stripe_payment_session_id, $Series_id)
    {
        try{

            $stripe = new \Stripe\StripeClient( env('STRIPE_SECRET') );

                            // Retrieve Payment Session
            $stripe_payment_session_id = $stripe_payment_session_id ;
            $stripe_payment_session = $stripe->checkout->sessions->retrieve( $stripe_payment_session_id );
            $stripe_payment_id = $stripe_payment_session->payment_intent;
            $paymentIntent = $stripe->paymentIntents->retrieve($stripe_payment_id);
            $Series = Series::where('id',$Series_id)->first();

            if( $stripe_payment_session->status == "complete"){
        
                $ppv_expirytime_started = Setting::pluck('ppv_hours')->first();
                $to_time = $ppv_expirytime_started != null  ? Carbon::now()->addHours($ppv_expirytime_started)->format('Y-m-d h:i:s a') : Carbon::now()->addHours(3)->format('Y-m-d h:i:s a');
                
                if(!empty($request->SeriesSeason_id)){
                    $moderators_id = $SeriesSeason->user_id;
                }

                if(!empty($moderators_id)){
                    $moderator           =  ModeratorsUser::where('id',$moderators_id)->first();  
                    $percentage = $moderator ? $moderator->commission_percentage : 0; 
                    $total_amount        =   (integer) $stripe_payment_session->amount_total / 100;
                    $title               =  $video->title;
                    $commssion           =  VideoCommission::where('type','CPP')->first();
                    $ppv_price           =  $video->ppv_price;
                    $moderator_commssion =  ($percentage/100) * $ppv_price ;
                    $admin_commssion     =  $ppv_price - $moderator_commssion;
                    $moderator_id        =  $moderators_id;
                }else{
                    $total_amount       =   $Series->ppv_price;
                    $title              =   $Series->title;
                    $commssion          =  VideoCommission::where('type','CPP')->first();
                    $ppv_price          =   $Series->ppv_price;
                    $percentage         =   null; 
                    $admin_commssion    =   null;
                    $moderator_commssion =  null;
                    $moderator_id        =  null;
                }

                PpvPurchase::create([
                    'user_id'         =>  Auth::user()->id ,
                    'series_id'       => $Series_id ,
                    'total_amount'        =>   (integer) $stripe_payment_session->amount_total / 100,
                    'admin_commssion'     => $admin_commssion,
                    'moderator_commssion' => $moderator_commssion,
                    'status'     => $paymentIntent->status,
                    'from_time'  => Carbon::now()->format('Y-m-d H:i:s a'),
                    'to_time'    => $to_time,
                    'moderator_id' => $moderator_id,
                    'payment_gateway'  => 'Stripe',
                    'payment_in'       => 'website',
                    'platform'       => 'website',
                    'payment_id' => $stripe_payment_id ,
                ]);

                $respond = array(
                    'status'  => 'true',
                    'redirect_url' => URL::to('play_series/'. $Series->slug) ,
                    'message'   => 'Video Payment Purchase Successfully !!' ,
                );
            }

        } catch (\Exception $e) {

            $respond = array(
                'status'  => 'false',
                'redirect_url' => URL::to('play_series/'. $Series->slug) ,
                'message'   => $e->getMessage() ,
            );
        }

        return Theme::view('stripe_payment.message',compact('respond'),$respond);
    }
    
    // PPV Video

    public function Stripe_payment_video_PPV_Plan_Purchase( $ppv_plan,$video_id,$amount)
    {
        try {

            if( Auth::guest()){
                return redirect('login');
            }
            
            PayRequestTranscation::create([
                'user_id'     => Auth::user()->id,
                'ppv_plan'    => $ppv_plan,
                'source_name' => $video_id,
                'source_id'   => $video_id,
                'source_type' => 'videos',
                'platform'    => "Stripe",
                'transform_form' => "PPV",
                'amount' => $amount,
                'date' => Carbon::now()->toDateString(),
                'status' => 'hold' ,
            ]);

            $stripe = new \Stripe\StripeClient( env('STRIPE_SECRET') );
            $success_url = URL::to('Stripe_payment_video_PPV_Plan_Purchase_verify/{CHECKOUT_SESSION_ID}/'.$video_id.'/'. $ppv_plan) ;

            $default_Currency = CurrencySetting::first();

               // Checkout Page Creation 
                
            if(CurrencySetting::pluck('enable_multi_currency')->first() == 1 ){

                $To_Currency_symbol = Currency::where('country',Country_name())->pluck('code')->first();

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

                        $video = Video::where('id',$video_id)->first();

                        $Error_msg = 'Error on Currency Conversation, Pls connect admin' ;
                        $url = URL::to('category/videos/'. $video->slug);
                        echo "<script type='text/javascript'>alert('$Error_msg'); window.location.href = '$url' </script>";
                    }
                
                } catch (\Exception $e) {
                        $video = Video::where('id',$video_id)->first();

                        $Error_msg = $e->getMessage();
                        $url = URL::to('category/videos/'. $video->slug);
                        echo "<script type='text/javascript'>alert('$Error_msg'); window.location.href = '$url' </script>";
                }

                $payment_amount = $convertedAmount ;

            }else{

                $payment_amount = $amount ;
                $To_Currency_symbol = CurrencySetting::query()->join('currencies','currencies.country','=','currency_settings.country') 
                                                            ->pluck('code')->first();
            }

            // Stripe Checkout 
            // 'unit_amount' => (integer) $payment_amount * 100, 

             // p24 Payment Mode

             $payment_method_types = ['card'];

             if( $this->stripe_payment->stripe_p24_mode == 1 ){
 
                 $To_Currency_symbol = 'pln';
                 $payment_method_types =  ['card', 'p24'];
                 
             }
             
            $Checkout_details = array(
                'success_url' => $success_url,
                
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => $To_Currency_symbol ,
                            'product_data' => [
                                'name' => GetWebsiteName(),
                            ],
                            'unit_amount' =>  $payment_amount * 100, 
                        ],
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'payment', 
                'payment_method_types' => $payment_method_types,
                'customer_email' => Auth::user()->email, 
            );
            
            $stripe_checkout = $stripe->checkout->sessions->create($Checkout_details);

            $url = $stripe_checkout->url;
            echo "<script type='text/javascript'> window.location.href = '$url' </script>";

        } catch (\Throwable $th) {

            $video = Video::where('id',$video_id)->first();

            $Error_msg = "Error on Payment, Pls Connect admin" ;
            $url = URL::to('category/videos/'. $video->slug);

            echo "<script type='text/javascript'>alert('$Error_msg'); window.location.href = '$url' </script>";
        }
    }

    public function Stripe_payment_video_PPV_Plan_Purchase_verify($stripe_payment_session_id,$video_id,$ppv_plan)
    {
        try {

            $stripe = new \Stripe\StripeClient( env('STRIPE_SECRET') );

                            // Retrieve Payment Session
            $stripe_payment_session_id = $stripe_payment_session_id ;
            $stripe_payment_session = $stripe->checkout->sessions->retrieve( $stripe_payment_session_id );
            $stripe_payment_id = $stripe_payment_session->payment_intent;
            $paymentIntent = $stripe->paymentIntents->retrieve($stripe_payment_id);
            $video = Video::where('id',$video_id)->first();

            if( $stripe_payment_session->status == "complete"){
        
                $setting = Setting::first();  
                $ppv_hours = $setting->ppv_hours;
    
                $ppv_expirytime_started = Setting::pluck('ppv_hours')->first();
                $to_time = $ppv_expirytime_started != null  ? Carbon::now()->addHours($ppv_expirytime_started)->format('Y-m-d h:i:s a') : Carbon::now()->addHours(3)->format('Y-m-d h:i:s a');

                if(!empty($video)){
                    $moderators_id = $video->user_id;
                }

                $ppv_price = $ppv_plan == '480p' ? $video->ppv_price_480p :
                            ($ppv_plan == '720p' ? $video->ppv_price_720p :
                            ($ppv_plan == '1080p' ? $video->ppv_price_1080p : $video->ppv_price));


                if(!empty($moderators_id)){
                    $moderator           =  ModeratorsUser::where('id',$moderators_id)->first();  
                    $percentage = $moderator ? $moderator->commission_percentage : 0; 
                    $total_amount        =   (integer) $stripe_payment_session->amount_total / 100;
                    $title               =  $video->title;
                    $commssion           =  VideoCommission::where('type','CPP')->first();
                    $ppv_price           =  $ppv_price;
                    $moderator_commssion =  ($percentage/100) * $ppv_price ;
                    $admin_commssion     =  $ppv_price - $moderator_commssion;
                    $moderator_id        =  $moderators_id;
                }else{
                    $total_amount       =    (integer) $stripe_payment_session->amount_total / 100;
                    $title              =   $video->title;
                    $commssion           =  VideoCommission::where('type','CPP')->first();
                    $ppv_price          =   $ppv_price;
                    $percentage         =   null; 
                    $admin_commssion    =   null;
                    $moderator_commssion =  null;
                    $moderator_id        =  null;
                }
            
                PpvPurchase::create([
                    'user_id'       =>  Auth::user()->id ,
                    'video_id'       => $video->id ,
                    'total_amount'  =>  (integer) $stripe_payment_session->amount_total / 100 , 
                    'admin_commssion'     => $admin_commssion,
                    'moderator_commssion' => $moderator_commssion,
                    'status'     => $paymentIntent->status,
                    'to_time'    => $to_time,
                    'from_time'  => Carbon::now()->format('Y-m-d H:i:s a'),
                    'moderator_id' => $moderator_id,
                    'payment_gateway'  => 'Stripe',
                    'payment_in'       => 'website',
                    'platform'       => 'website',
                    'ppv_plan'       => $ppv_plan,
                    'payment_id' =>   $stripe_payment_id,
                ]);


                $respond = array(
                    'status'  => 'true',
                    'redirect_url' => URL::to('category/videos/'. $video->slug) ,
                    'message'   => 'Video Payment Purchase Successfully !!' ,
                );
            }

        } catch (\Exception $e) {

            $video = Video::where('id',$video_id)->first();

            $respond = array(
                'status'  => 'false',
                'redirect_url' => URL::to('category/videos/'. $video->slug) ,
                'message'   => $e->getMessage() ,
            );
        }

        return Theme::view('stripe_payment.message',compact('respond'),$respond);
    }


        // PPV Series Season

        public function Stripe_payment_series_season_PPV_Plan_Purchase( $ppv_plan,$SeriesSeason_id,$amount)
        {
            try {
                
                if( Auth::guest()){
                    return redirect('login');
                }

                PayRequestTranscation::create([
                    'user_id'     => Auth::user()->id,
                    'ppv_plan'    => $ppv_plan,
                    'source_name' => $SeriesSeason_id,
                    'source_id'   => $SeriesSeason_id,
                    'source_type' => 'series season',
                    'platform'    => "Stripe",
                    'transform_form' => "PPV",
                    'amount' => $amount,
                    'date' => Carbon::now()->toDateString(),
                    'status' => 'hold' ,
                ]);
                
                $stripe = new \Stripe\StripeClient( env('STRIPE_SECRET') );
                $success_url = URL::to('Stripe_payment_series_season_PPV_Plan_Purchase_verify/{CHECKOUT_SESSION_ID}/'.$SeriesSeason_id ,$ppv_plan) ;
    
                $SeriesSeason = SeriesSeason::where('id',$SeriesSeason_id)->first();
                $series_id = $SeriesSeason->series_id;
                $series = Series::find($series_id);
    
                $default_Currency = CurrencySetting::first();
    
                   // Checkout Page Creation 
                    
                if(CurrencySetting::pluck('enable_multi_currency')->first() == 1 ){
    
                    $To_Currency_symbol = Currency::where('country',Country_name())->pluck('code')->first();
    
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
    
                    $payment_amount = $convertedAmount ;
    
                }else{
    
                    $payment_amount = $amount ;
                    $To_Currency_symbol = CurrencySetting::query()->join('currencies','currencies.country','=','currency_settings.country') 
                                                                ->pluck('code')->first();
                }

                  // p24 Payment Mode

             $payment_method_types = ['card'];

             if( $this->stripe_payment->stripe_p24_mode == 1 ){
 
                 $To_Currency_symbol = 'pln';
                 $payment_method_types =  ['card', 'p24'];
                 
             }
    
                // Stripe Checkout
    
                $Checkout_details = array(
                    'success_url' => $success_url,
                    
                    'line_items' => [
                        [
                            'price_data' => [
                                'currency' => $To_Currency_symbol ,
                                'product_data' => [
                                    'name' => GetWebsiteName(),
                                ],
                                'unit_amount' =>  $payment_amount * 100, 
                            ],
                            'quantity' => 1,
                        ],
                    ],
                    'mode' => 'payment', 
                    'payment_method_types' => $payment_method_types,
                    'customer_email' => Auth::user()->email, 
                );
                
                $stripe_checkout = $stripe->checkout->sessions->create($Checkout_details);
    
                $url = $stripe_checkout->url;
                echo "<script type='text/javascript'> window.location.href = '$url' </script>";
    
            } catch (\Throwable $th) {
    
                $Error_msg = "Error on Payment, Pls Connect admin" ;
                $url = URL::to('play_series/'.$series->slug);
    
                echo "<script type='text/javascript'>alert('$Error_msg'); window.location.href = '$url' </script>";
            }
        }
    
        public function Stripe_payment_series_season_PPV_Plan_Purchase_verify( $stripe_payment_session_id, $SeriesSeason_id,$ppv_plan)
        {
            try{
    
                $stripe = new \Stripe\StripeClient( env('STRIPE_SECRET') );
    
                                // Retrieve Payment Session
                $stripe_payment_session_id = $stripe_payment_session_id ;
                $stripe_payment_session = $stripe->checkout->sessions->retrieve( $stripe_payment_session_id );
                $stripe_payment_id = $stripe_payment_session->payment_intent;
                $paymentIntent = $stripe->paymentIntents->retrieve($stripe_payment_id);
                $SeriesSeason = SeriesSeason::where('id',$SeriesSeason_id)->first();
                $series_id = $SeriesSeason->series_id;
                $series = Series::find($series_id);
    
                if( $stripe_payment_session->status == "complete"){
            
                    $ppv_expirytime_started = Setting::pluck('ppv_hours')->first();
                    $to_time = $ppv_expirytime_started != null  ? Carbon::now()->addHours($ppv_expirytime_started)->format('Y-m-d h:i:s a') : Carbon::now()->addHours(3)->format('Y-m-d h:i:s a');
                    
                    if(!empty($request->SeriesSeason_id)){
                        $moderators_id = $SeriesSeason->user_id;
                    }

                    $ppv_price = $ppv_plan == '480p' ? $SeriesSeason->ppv_price_480p :
                    ($ppv_plan == '720p' ? $SeriesSeason->ppv_price_720p :
                    ($ppv_plan == '1080p' ? $SeriesSeason->ppv_price_1080p : $SeriesSeason->ppv_price));
    
                    if(!empty($moderators_id)){
                        $moderator           =  ModeratorsUser::where('id',$moderators_id)->first();  
                        $percentage = $moderator ? $moderator->commission_percentage : 0; 
                        $total_amount        =   (integer) $stripe_payment_session->amount_total / 100;
                        $title               =  $video->title;
                        $commssion           =  VideoCommission::where('type','CPP')->first();
                        $ppv_price           =  $ppv_price;
                        $moderator_commssion =  ($percentage/100) * $ppv_price ;
                        $admin_commssion     =  $ppv_price - $moderator_commssion;
                        $moderator_id        =  $moderators_id;
                    }else{
                        $total_amount       =   $SeriesSeason->ppv_price;
                        $title              =   $SeriesSeason->series_seasons_name;
                        $commssion          =  VideoCommission::where('type','CPP')->first();
                        $ppv_price          =   $SeriesSeason->ppv_price;
                        $percentage         =   null; 
                        $admin_commssion    =   null;
                        $moderator_commssion =  null;
                        $moderator_id        =  null;
                    }
    
                    PpvPurchase::create([
                        'user_id'         =>  Auth::user()->id ,
                        'season_id'       => $SeriesSeason_id ,
                        'series_id'       => $series_id ,
                        'total_amount'        =>   (integer) $stripe_payment_session->amount_total / 100,
                        'admin_commssion'     => $admin_commssion,
                        'moderator_commssion' => $moderator_commssion,
                        'status'     => $paymentIntent->status,
                        'from_time'  => Carbon::now()->format('Y-m-d H:i:s a'),
                        'to_time'    => $to_time,
                        'moderator_id' => $moderator_id,
                        'payment_gateway'  => 'Stripe',
                        'payment_in'       => 'website',
                        'platform'       => 'website',
                        'ppv_plan' => $ppv_plan,
                        'payment_id' =>   $stripe_payment_id,
                    ]);
    
                    $respond = array(
                        'status'  => 'true',
                        'redirect_url' => URL::to('play_series/'. $series->slug) ,
                        'message'   => 'Video Payment Purchase Successfully !!' ,
                    );
                }
    
            } catch (\Exception $e) {
    
                $respond = array(
                    'status'  => 'false',
                    'redirect_url' => URL::to('play_series/'. $series->slug) ,
                    'message'   => $e->getMessage() ,
                );
            }
    
            return Theme::view('stripe_payment.message',compact('respond'),$respond);
        }
}
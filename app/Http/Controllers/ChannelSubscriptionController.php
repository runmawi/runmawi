<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\ChannelSubscriptionPlan;
use App\ChannelSubscription;
use App\CurrencySetting;
use App\ChannelSignupMenu;
use App\HomeSetting;
use App\SiteTheme;
use App\PaymentSetting;
use App\Channel;
use App\EmailTemplate;
use Session;
use URL;
use Hash;
use Image;
use Auth;
use Theme;
use Mail;

class ChannelSubscriptionController extends Controller
{

    public function __construct()
    {
        $this->Theme = HomeSetting::first();
        Theme::uses($this->Theme->theme_choosen);
    }

    public function Channel_subscriptions_plans(Request $request)
    {

        $Stripe_payment_settings = PaymentSetting::where('payment_type', 'Stripe')->first();
        $subscriptions_plans     = ChannelSubscriptionPlan::where('type','Stripe')->groupBy('plans_name')->get();
        $CurrencySetting         = CurrencySetting::pluck('enable_multi_currency')->first();
        $SiteTheme               = SiteTheme::first();
        $stripe_lable            = PaymentSetting::where('payment_type', 'Stripe')->pluck('stripe_lable')->first() ? PaymentSetting::where('payment_type', 'Stripe')->pluck('stripe_lable')->first() : 'Stripe';
        $footer_url              = "themes/{$this->Theme->theme_choosen}/views/footer.blade.php";

        $data = array(
            'CurrencySetting'  => $CurrencySetting,
            'SiteTheme'        => $SiteTheme,
            'Stripe_payment_settings' => $Stripe_payment_settings ,
            'subscriptions_plans' => $subscriptions_plans,
            'stripe_lable' => $stripe_lable ,
            'footer_url'   => $footer_url ,
            'button_bg_color' => button_bg_color() ,
            'currency_symbol' => currency_symbol(),
        );

        return Theme::view('Channel.subscriptions_plans', $data );
    }

    public function Channel_Stripe_authorization_url(Request $request)
    {
        try {

            $email = Session::get('email_id');

            $stripe = new \Stripe\StripeClient( env('STRIPE_SECRET') );

            $success_url = URL::to('channel-stripe-payment-verify?stripe_payment_session_id={CHECKOUT_SESSION_ID}') ;

            $Channel_Subscription_Plan = ChannelSubscriptionPlan::where('type','Stripe')->where('recurring_subscription_plan_id',$request->Stripe_Plan_id)->latest()->first();

            $payment_exists = Channel::where('email',$email)->first();

            if( is_null($payment_exists->stripe_id) ){

                $Subscription_Plan_item = [
                    [
                        'price' => $Channel_Subscription_Plan->recurring_subscription_plan_id,
                        'quantity' => 1,
                    ],
        
                    [
                        'price' => $Channel_Subscription_Plan->one_time_subscription_plan_id,
                        'quantity' => 1,
                    ],
                ];
            }else{

                $Subscription_Plan_item = [
                    [
                        'price' => $Channel_Subscription_Plan->recurring_subscription_plan_id,
                        'quantity' => 1,
                    ],
                ];

            }
                // Stripe Checkout
            
            $Checkout_details = array(
                'success_url' => $success_url,
                'mode'        => 'subscription',
                'line_items'  => $Subscription_Plan_item ,
                'customer_email' => $email, 
            );

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

    public function Channel_Stripe_payment_verify(Request $request)
    {
        $stripe = new \Stripe\StripeClient( env('STRIPE_SECRET') );

            // Retrieve Payment Session
        $stripe_payment_session_id = $request->stripe_payment_session_id ;
        $stripe_payment_session = $stripe->checkout->sessions->retrieve( $stripe_payment_session_id );


        if( $stripe_payment_session->status == "complete"){

                            // Retrieve Subscriptions
            $subscription = $stripe->subscriptions->retrieve(  $stripe_payment_session->subscription );
            
                            // User & Subscription data storing
            $user = Channel::where('email',$stripe_payment_session->customer_email )->first();
            $Channel_Subscription_Plan = ChannelSubscriptionPlan::where('type','Stripe')->where('recurring_subscription_plan_id',$subscription->plan['id'])->latest()->first();

            $Sub_Startday  = Carbon::createFromTimestamp($subscription['current_period_start'])->toDateTimeString(); 
            $Sub_Endday    = Carbon::createFromTimestamp($subscription['current_period_end'])->toDateTimeString(); 
            $trial_ends_at = Carbon::createFromTimestamp($subscription['current_period_end'])->toDateTimeString(); 

            $ChannelSubscription_array = array(
                'user_id'        =>  $user->id,
                'name'           =>  $subscription->plan['product'],
                'price'          =>  $subscription->plan['amount_decimal'] / 100,   // Amount Paise to Rupees
                'stripe_id'      =>  $subscription['id'],
                'stripe_status'  =>  $subscription['status'],
                'stripe_plan'    =>  $subscription->plan['id'],
                'recurring_subscription_plan_id'    =>  $subscription->plan['id'],
                'quantity'       =>  $subscription['quantity'],
                'countryname'    =>  Country_name(),
                'regionname'     =>  Region_name(),
                'cityname'       =>  city_name(),
                'PaymentGateway' =>  'Stripe',
                'trial_ends_at'  =>  $trial_ends_at,
                'ends_at'        =>  $trial_ends_at,
            );

            if( is_null($user->stripe_id) ){

               $ChannelSubscription_array += [ 'one_time_subscription_plan_id' =>  !is_null($Channel_Subscription_Plan) && !is_null($Channel_Subscription_Plan->one_time_subscription_plan_id) ? $Channel_Subscription_Plan->one_time_subscription_plan_id : null ] ;

            }

            ChannelSubscription::create( $ChannelSubscription_array );

            $user_data = array(
                'role'                  =>  'subscriber',
                'stripe_id'             =>  $subscription['id'],
                'subscription_start'    =>  $Sub_Startday,
                'subscription_ends_at'  =>  $Sub_Endday,
                'payment_type'          => 'recurring',
                'payment_status'        => $subscription['status'],
                'payment_gateway'       =>  'Stripe',
                'recurring_subscription_plan_id'    =>  $subscription->plan['id'],
            );

            if( is_null($user->stripe_id) ){

                $user_data += [ 'one_time_subscription_plan_id' =>  !is_null($Channel_Subscription_Plan) && !is_null($Channel_Subscription_Plan->one_time_subscription_plan_id) ? $Channel_Subscription_Plan->one_time_subscription_plan_id : null ] ;
 
             }

            Channel::where('id',$user->id)->update( $user_data );
            
                            // Mail
            try {

                $email_subject = EmailTemplate::where('id',23)->pluck('heading')->first() ;
                $plandetail = ChannelSubscriptionPlan::where('plan_id',$subscription->plan['id'])->first();

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

                $email_log      = 'Mail Sent Successfully from CPP Subscription';
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
                'redirect_url' => URL::to('channel/dashboard'),
                'message'   => 'Your Subscriber Payment done Successfully' ,
            );

        }else{
            $respond = array(
                'status'   => "false",
                'redirect_url' => URL::to('channel-subscriptions-plans'),
                'message'  => "Some errors occurred while subscribing. Please connect, Admin!",
            );
        }

        return Theme::view('stripe_payment.message',compact('respond'),$respond);
    }
}
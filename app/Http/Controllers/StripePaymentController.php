<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Subscription;
use App\SubscriptionPlan;
use App\PaymentSetting;
use App\AppEmailTemplate;
use App\HomeSetting;
use App\User;
use Theme;

class StripePaymentController extends Controller
{
    public function __construct()
    {
        $this->Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses($this->Theme);
    }

    public function Stripe_authorization_url(Request $request)
    {
        try {
            
            $stripe = new \Stripe\StripeClient( env('STRIPE_SECRET') );
        
            $success_url = URL::to('Stripe_payment_success?true&stripe_payment_session_id={CHECKOUT_SESSION_ID}') ;
            $cancel_url = URL::to('Stripe_payment_failure?true&stripe_payment_session_id={CHECKOUT_SESSION_ID}');
            
            $apply_coupon = $request->get('coupon_code') ?  $request->get('coupon_code') : null ;

            $Plan_id = $request->Stripe_Plan_id;

            if( Auth::User()  != null){
                $user_details =Auth::User();
                $redirection_back = URL::to('/becomesubscriber'); 
            }else{
                $userEmailId  = $request->session()->get('register.email');
                $user_details = User::where('email',$userEmailId)->first();
                $redirection_back = URL::to('/register2'); 
            }

            // Stripe Checkout

            $Checkout_details = array(
                'success_url' => $success_url,
                'cancel_url'  => $cancel_url,
                
                'line_items' => [
                    [
                        'price' => $Plan_id,
                        'quantity' => 1,
                    ],
                ],
                'allow_promotion_codes' => true,
                'mode' => 'subscription',
                'customer_email' => $user_details->email, 
            );

            if (subscription_trails_status() == 1) {

                $Trail_days = PaymentSetting::where('payment_type','=','Stripe')->pluck('subscription_trail_days')->first();

                $Checkout_details['subscription_data'] = [
                    'trial_period_days' => $Trail_days,
                ];
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
                ]);

                $user_data = array(
                    'role'                  =>  'subscriber',
                    'stripe_id'             =>  $subscription['customer'],
                    'subscription_start'    =>  $Sub_Startday,
                    'subscription_ends_at'  =>  $Sub_Endday,
                    'payment_type'          => 'recurring',
                    'payment_status'        => $subscription['status'],
                    'coupon_used'    =>  !is_null($subscription['discount']) ?  $subscription['discount']->promotion_code : null ,
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
                        'paymentMethod' => $paymentMethod,
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
      # code...
    }
}

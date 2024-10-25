<?php

namespace Webnexs\Avod;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\AdvertiserSubscription;
use App\PaymentSetting;
use App\Advertiser;
use App\Adsplan;
use Theme;

class StripePaymentController extends Controller
{

   // Subscription

  public function Stripe_authorization_url(Request $request)
  {
      try {
          
        $stripe = new \Stripe\StripeClient( env('STRIPE_SECRET') );
    
        $success_url = URL::to('advertiser/Stripe_payment_success?stripe_payment_session_id={CHECKOUT_SESSION_ID}') ;
        
        $Plan_id = $request->Stripe_Plan_id;
      
        $Advertiser = Advertiser::where('id', session('advertiser_id'))->where('status', 1)->first();
      
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
            'customer_email' => $Advertiser->email_id, 
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
            $Advertiser = Advertiser::where('email_id',$stripe_payment_session->customer_email )->first();
           
            $Sub_Startday  = Carbon::createFromTimestamp($subscription['current_period_start'])->toDateTimeString(); 
            $Sub_Endday    = Carbon::createFromTimestamp($subscription['current_period_end'])->toDateTimeString(); 
            $trial_ends_at = Carbon::createFromTimestamp($subscription['current_period_end'])->toDateTimeString(); 
           
            AdvertiserSubscription::create([
                'adverister_id'   => $Advertiser->id,
                'platform'        => 'WebSite',
                'PaymentGateway'  => 'Stripe',
                'subscription_id' => $subscription['id'],
                'status'          => $subscription['status'] ,
                'plan_name'       => $subscription->plan['product'],
                'plan_price'      => $subscription->plan['amount_decimal'] / 100,
                'plan_id'         => $subscription->plan['id'],
                'quantity'        =>  $subscription['quantity'],
                'subscription_start'    =>  $Sub_Startday,
                'subscription_ends_at'  =>  $Sub_Endday,
                'payment_type'          => 'recurring',
                'countryname'     =>  Country_name(),
                'regionname'      =>  Region_name(),
                'cityname'        =>  city_name(),
                'trial_ends_at'  => $trial_ends_at,
                'ends_at'        => $trial_ends_at,
                'coupon_used'    => null,
            ]);

            $Advertiser_data = array(
                'role'                =>  'subscriber',
                'plan_id'             =>   $subscription->plan['id'],
                'subscription_id'     =>   $subscription['id'],
                'subscription_start'    =>  $Sub_Startday,
                'subscription_ends_at'  =>  $Sub_Endday,
                'payment_type'          => 'recurring',
                'payment_status'        =>  1,
                'payment_gateway'       =>  'Stripe',
                'ads_upload_count_limit'=>  Adsplan::where('plan_id',$subscription->plan['id'])->pluck('no_of_ads')->first(),
                'coupon_used'           =>  null ,
            );

            Advertiser::where('id',$Advertiser->id)->update( $Advertiser_data );

            $respond = array(
                'status'  => 'true',
                'redirect_url' => URL::to('/advertiser'),
                'message'   => 'Your Subscriber Payment done Successfully' ,
            );

        }else{

            $respond = array(
                'status'   => "false",
                'redirect_url' => URL::to('advertiser/payment'),
                'message'  => "Some errors occurred while subscribing. Please connect, Admin!",
            );
        }

    } catch (\Throwable $th) {
    
        $respond = array(
            'status'   => "false",
            'redirect_url' => URL::to('advertiser/payment'),
            'message'  => "Some errors occurred while subscribing. Please connect, Admin!",
            'error_msg' => $th->getMessage(),
        );
    }

    return view('avod::Payment.message',compact('respond'),$respond);
  }
}
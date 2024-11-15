<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Recurly\Client as RecurlyClient ;
use Carbon\Carbon;
use App\UserChannelSubscription;
use App\PaymentSetting;
use App\SubscriptionPlan;
use App\Subscription;
use App\HomeSetting ;
use App\EmailTemplate;
use App\User;
use Theme;

class RecurlyPaymentChannelController extends Controller
{
  
    protected $HomeSetting;

    public function __construct()
    {
        $PaymentSetting = PaymentSetting::where('payment_type','Recurly')->where('recurly_status',1)->first();

        if($PaymentSetting != null){

            if($PaymentSetting->live_mode == 0){
                $this->recurly_public_key = $PaymentSetting->recurly_test_public_key;
                $this->recurly_private_key = $PaymentSetting->recurly_test_private_key;
            }else{
                $this->recurly_public_key = $PaymentSetting->recurly_live_public_key;
                $this->recurly_private_key = $PaymentSetting->recurly_live_private_key;
            }
        }else{
            $Error_msg = "Recurly Key is Missing";
            $url = URL::to('/home');
            echo "<script type='text/javascript'>alert('$Error_msg'); window.location.href = '$url' </script>";
        }

        $this->client = new RecurlyClient('140398c74d97455189eceae276344558');
        
        $this->HomeSetting = HomeSetting::first();
        Theme::uses($this->HomeSetting->theme_choosen);
    }

    public function channel_checkout_page(Request $request)
    {
        try {
            
            $plan_name = $request->recurly_plan_id;

            $plan_details =  $this->client->getPlan("code-$plan_name");

            // users details

            $user_details = Auth::User();

            $data = array(
                'current_theme' => $this->HomeSetting->theme_choosen,
                'recurly_public_key' => $this->recurly_public_key ,
                'payment_current_route_uri'  => $request->payment_current_route_uri,
                'user_details'  => $user_details ,
                'plan_details'  => $plan_details,
                'Country_code'  => Country_Code(),
                'channel_id'    => $request->channel_id,
            );

            return Theme::view('Recurly-Channel.checkout_page', $data);

        } catch (\Throwable $th) {

            $respond = array(
                'status'   => "false",
                'current_theme' => $this->HomeSetting->theme_choosen,
                'redirect_url' => route('channel.payment',$request->channel_id),
                'message'  => "Some errors occurred while subscribing. Please connect, Admin!",
            );

            return Theme::view('Recurly-Channel.message',compact('respond'),$respond);
        }
    }

    public function channelcreateSubscription(Request $request)
    {
        try {

             $user_details = Auth::User();

            // Purchase create array

            $purchase_create = [
                "currency" => $request->getCurrencies,
                "account" => [
                    "code"        =>  $user_details->email,
                    "first_name"  =>  $request->first_name,
                    "last_name"   =>  $request->last_name,
                    "billing_info" => [
                        "first_name" =>  $request->first_name,
                        "last_name"  =>  $request->last_name,
                        'number'     =>  str_replace('-', '', $request->card_number),
                        'month'      =>  explode('/', $request->exp_month)[0],
                        'year'       =>  explode('/', $request->exp_month)[1],
                        'cvv'        => $request->cvc ,
                        'address' => array(
                            'postal_code' =>  $request->postal_code,
                        ),
                    ],
                ],
                "subscriptions" => [
                    [
                        "plan_code" => $request->plan_code,
                    ]
                ]
            ];

            // createPurchase & subscription

            $invoice_collection = $this->client->createPurchase($purchase_create);   

            $subscription_id = $invoice_collection->getchargeinvoice()->getsubscriptionids()[0];

            $subscription = $this->client->getSubscription($subscription_id);

            $plan_details =  $this->client->getPlan("code-".$subscription->getplan()->getcode());

            $Sub_Startday  = Carbon::parse($subscription->getcurrentperiodstartedat())->format('Y-m-d H:i:s');
            $Sub_Endday    = Carbon::parse($subscription->getcurrentperiodendsat())->format('Y-m-d H:i:s');
            $trial_ends_at = Carbon::parse($subscription->getcurrentperiodendsat())->format('Y-m-d H:i:s');
           
            UserChannelSubscription::create([
                'user_id'         => $user_details->id,
                'channel_id'      => $request->channel_id,
                'platform'        => 'Recurly',
                'PaymentGateway'  => 'Recurly',
                'subscription_id' => $subscription_id,
                'status'          => $subscription->getState(),
                'plan_name'       => $subscription->getplan()->getcode(),
                'plan_price'      => $subscription->getunitamount(),
                'plan_id'         => $subscription->getplan()->getcode(),
                'quantity'        => $subscription->getQuantity(),
                'payment_type'    => 'recurring',
                'subscription_start'   => $Sub_Startday,
                'subscription_ends_at' => $Sub_Endday,
                'countryname'    => $request->country,
                'regionname'     => Region_name(),
                'cityname'       => city_name(),
            ]);

            $user_data = array(
                'channel_role'                 =>  'subscriber',
                'channel_subscription_id'      =>  $subscription_id,
                'channel_subscription_start'   =>  $Sub_Startday,
                'channel_subscription_ends_at' =>  $Sub_Endday,
                'channel_payment_status'       =>  $subscription->getState(),
                'channel_payment_gateway'      =>  'Recurly',
            );

            User::where('id',$user_details->id)->update( $user_data );

            $respond = array(
                'current_theme' => $this->HomeSetting->theme_choosen,
                'status'  => 'true',
                'redirect_url' => route('channel.all_Channel_home'),
                'message'   => 'Your Subscriber Payment done Successfully' ,
            );

        } catch (\Throwable $th) {

            $respond = array(
                'current_theme' => $this->HomeSetting->theme_choosen,
                'status'   => "false",
                'redirect_url' => route('channel.payment',$request->channel_id),
                'message'  => $th->getMessage(),
            );
        }

        return Theme::view('Recurly-Channel.message',compact('respond'),$respond);
    }

    public function channelUpgradeSubscription(Request $request)
    {
        try {

            $subscription_id = Auth::user()->channel_subscription_id;
            
            $change_create = [
                "plan_code" => $request->plan_code,
                "timeframe" => "now"
            ];

            $change = $this->client->createSubscriptionChange($subscription_id, $change_create);

            $subscription = $this->client->getSubscription($change->getsubscriptionid());

            $plan_details =  $this->client->getPlan("code-".$subscription->getplan()->getcode());

            $Sub_Startday  = Carbon::parse($subscription->getcurrentperiodstartedat())->format('Y-m-d H:i:s');
            $Sub_Endday    = Carbon::parse($subscription->getcurrentperiodendsat())->format('Y-m-d H:i:s');
            $trial_ends_at = Carbon::parse($subscription->getcurrentperiodendsat())->format('Y-m-d H:i:s');

            UserChannelSubscription::create([
                'user_id'         => $user_details->id,
                'channel_id'      => $request->channel_id,
                'platform'        => 'Recurly',
                'PaymentGateway'  => 'Recurly',
                'subscription_id' => $subscription_id,
                'status'          => $subscription->getState(),
                'plan_name'       => $subscription->getplan()->getcode(),
                'plan_price'      => $subscription->getunitamount(),
                'plan_id'         => $subscription->getplan()->getcode(),
                'quantity'        => $subscription->getQuantity(),
                'payment_type'    => 'recurring',
                'subscription_start'   => $Sub_Startday,
                'subscription_ends_at' => $Sub_Endday,
                'countryname'    => $request->country,
                'regionname'     => Region_name(),
                'cityname'       => city_name(),
            ]);

            $user_data = array(
                'channel_role'                 =>  'subscriber',
                'channel_subscription_id'      =>  $subscription_id,
                'channel_subscription_start'   =>  $Sub_Startday,
                'channel_subscription_ends_at' =>  $Sub_Endday,
                'channel_payment_status'       =>  $subscription->getState(),
                'channel_payment_gateway'      =>  'Recurly',
            );

            User::where('id',$user_details->id)->update( $user_data );  
            
            $respond = array(
                'current_theme' => $this->HomeSetting->theme_choosen,
                'status'  => 'true',
                'redirect_url' => route('channel.all_Channel_home'),
                'message'   => 'Your Subscriber Payment done Successfully' ,
            );
        } catch (\Throwable $th) {

            $respond = array(
                'current_theme' => $this->HomeSetting->theme_choosen,
                'status'   => "false",
                'redirect_url' => URL::to('/channel-payment'),
                'message'  => $th->getMessage(),
            );
        }

        return Theme::view('Recurly-Channel.message',compact('respond'),$respond);
    }

    public function channelCancelSubscription($subscription_id)
    {
        try {
      
            $subscription = $this->client->cancelSubscription($subscription_id);

            $subscriptionId = User::where('id',Auth::user()->id)->where('channel_payment_gateway','Recurly')->pluck('channel_subscription_id')->first();

            Subscription::where('channel_subscription_id',$subscriptionId)->update([
                'channel_payment_status' =>  'Cancelled',
            ]);

            User::where('id',Auth::user()->id )->update([
                'channel_role'                 =>  null,
                'channel_subscription_id'      =>  null,
                'channel_payment_status'       =>  'Cancel' ,
                'channel_payment_gateway'      =>  'Recurly',
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
}
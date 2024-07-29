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
use App\PaymentSetting;
use App\SubscriptionPlan;
use App\Subscription;
use App\HomeSetting ;
use App\EmailTemplate;
use App\User;
use Theme;


class RecurlyPaymentController extends Controller
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

        $this->client = new RecurlyClient($this->recurly_private_key);
        
        $this->HomeSetting = HomeSetting::first();
        Theme::uses($this->HomeSetting->theme_choosen);
    }

    public function checkout_page(Request $request)
    {
        try {
            
            $plan_name = $request->plan_name;
            $plan_details =  $this->client->getPlan("code-$plan_name");

            // users details

            if( Auth::User()  != null){
                $user_details = Auth::User();
            }else{
                $userEmailId  = $request->session()->get('register.email');
                $user_details = User::where('email',$userEmailId)->first();
            }

            $data = array(
                'current_theme' => $this->HomeSetting->theme_choosen,
                'user_details'  => $user_details ,
                'plan_details'  => $plan_details,
                'Country_code'  => Country_Code(),
            );

            return Theme::view('Recurly.checkout_page', $data);

        } catch (\Throwable $th) {

            $Error_msg = "Some errors occurred while subscribing. Please connect, Admin!";
            $url = URL::to('/becomesubscriber');
            echo "<script type='text/javascript'>alert('$Error_msg'); window.location.href = '$url' </script>";
        }
    }

    public function createSubscription(Request $request)
    {
        try {

            // users details
                
            if( Auth::User()  != null){
                $user_details = Auth::User();
            }else{
                $userEmailId  = $request->session()->get('register.email');
                $user_details = User::where('email',$userEmailId)->first();
            }
            
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
                        'number'     => $request->card_number,
                        'month'      => '05',
                        'year'       =>  '2025',
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

            $Sub_Startday  = Carbon::createFromTimestamp($subscription->getcurrentperiodstartedat())->toDateTimeString(); 
            $Sub_Endday    = Carbon::createFromTimestamp($subscription->getcurrentperiodendsat())->toDateTimeString(); 
            $trial_ends_at = Carbon::createFromTimestamp($subscription->getcurrentperiodendsat())->toDateTimeString(); 

            Subscription::create([
                'user_id'        =>  $user_details->id,
                'name'           =>  $subscription->getplan()->getcode(),
                'price'          =>  $subscription->getunitamount(), 
                'stripe_id'      =>  $subscription_id,
                'stripe_status'  =>  $subscription->getState(),
                'stripe_plan'    =>  $subscription->getplan()->getcode(),
                'quantity'       =>  $subscription->getQuantity(),
                'countryname'    =>  $request->country,
                'regionname'     =>  Region_name(),
                'cityname'       =>  city_name(),
                'PaymentGateway' =>  'Recurly',
                'trial_ends_at'  =>  $trial_ends_at,
                'ends_at'        =>  $trial_ends_at,
                'coupon_used'    =>  null,
                'platform'       => 'WebSite',
            ]);

            $user_data = array(
                'role'                  =>  'subscriber',
                'stripe_id'             =>  $subscription_id,
                'subscription_start'    =>  $Sub_Startday,
                'subscription_ends_at'  =>  $Sub_Endday,
                'payment_type'          =>  'recurring',
                'payment_status'        =>  $subscription->getState(),
                'payment_gateway'       =>  'Recurly',
                'coupon_used'           =>   null ,
            );

            User::where('id',$user_details->id)->update( $user_data );
    
                // Mail
            try {

                $email_subject = EmailTemplate::where('id',23)->pluck('heading')->first() ;
                $plandetail = SubscriptionPlan::where('plan_id',$subscription->getplan()->getcode())->first();

                $nextPaymentAttemptDate =  Carbon::createFromTimeStamp( $subscription->getcurrentperiodendsat() )->format('F jS, Y')  ;

                \Mail::send('emails.subscriptionmail', array(

                    'name'          => ucwords($user_details->username),
                    'paymentMethod' => ucwords('recurring'),
                    'plan'          => ucfirst($plandetail->plans_name),
                    'price'         => $subscription->getunitamount(),
                    'plan_id'       => $subscription->getplan()->getcode() ,
                    // 'billing_interval'  => $subscription['plan']['interval'] ,
                    'next_billing'      => $nextPaymentAttemptDate,
                    'subscription_type' => 'recurring',
                ), 

                function($message) use ($request,$user_details,$email_subject){
                    $message->from(AdminMail(),GetWebsiteName());
                    $message->to($user_details->email, $user_details->username)->subject($email_subject);
                });

                $email_log      = 'Mail Sent Successfully from Become Subscription';
                $email_template = "23";
                $user_id = $user_details->id;

                Email_sent_log($user_id,$email_log,$email_template);

            } catch (\Throwable $th) {

                $email_log      = $th->getMessage();
                $email_template = "23";
                $user_id = $user_details->id;

                Email_notsent_log($user_id,$email_log,$email_template);
            }
            
            $respond = array(
                'status'  => 'true',
                'redirect_url' => URL::to('/home'),
                'message'   => 'Your Subscriber Payment done Successfully' ,
            );

        } catch (\Throwable $th) {

            $respond = array(
                'status'   => "false",
                'redirect_url' => URL::to('/becomesubscriber'),
                'message'  => "Some errors occurred while subscribing. Please connect, Admin!",
            );
        }

        return Theme::view('stripe_payment.message',compact('respond'),$respond);
    }

    public function UpgradeSubscription(Request $request)
    {
        # code...
    }

    public function CancelSubscription(Request $request)
    {
        # code...
    }
}
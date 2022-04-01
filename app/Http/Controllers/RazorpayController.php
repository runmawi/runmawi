<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Notification;
use \Redirect as Redirect;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Session;
use Theme;
use Auth;
use Carbon\Carbon;
use App\Subscription;
use Razorpay\Api\Api;
use App\User;
use App\ThemeIntegration;
use App\PaymentSetting;
use URL;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use AmrShawky\LaravelCurrency\Facade\Currency as PaymentCurreny;


class RazorpayController extends Controller
{

    public function __construct()
    {
        $PaymentSetting = PaymentSetting::where('payment_type','Razorpay')->first();

        if($PaymentSetting != null){
            if($PaymentSetting->live_mode == 0){
                $this->razorpaykeyId = $PaymentSetting->test_publishable_key;
                $this->razorpaykeysecret = $PaymentSetting->test_secret_key;
            }else{
                $this->razorpaykeyId = $PaymentSetting->live_publishable_key;
                $this->razorpaykeysecret = $PaymentSetting->live_secret_key;
            }
        }else{
            $Error_msg = "Razorpay Key is Missing";
            $url = URL::to('/home');
            echo "<script type='text/javascript'>alert('$Error_msg'); window.location.href = '$url' </script>";
        }
    }

    public function Razorpay(Request $request)
    {
        return view('Razorpay.create');
    }

    public function RazorpayIntegration(Request $request,$Plan_Id)
    {

        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
        $countryName = $geoip->getCountry();
        $regionName = $geoip->getregion();
        $cityName = $geoip->getcity();

        $users_details =Auth::User();

        if($users_details != null){
            $user_details =Auth::User();
        }else{
            $userEmailId = $request->session()->get('register.email');
            $user_details =User::where('email',$userEmailId)->first();
        }

        $plan_Id =Crypt::decryptString($Plan_Id);
        
        $api    = new Api($this->razorpaykeyId, $this->razorpaykeysecret);
        $planId = $api->plan->fetch($plan_Id);

        $subscription = $api->subscription->create(array(
        'plan_id' =>  $planId->id, 
        'customer_notify' => 1,
        'total_count' => 6, 
        ));

        $respond=array(
            'razorpaykeyId'  =>  $this->razorpaykeyId,
            'name'           =>  $planId['item']->name,
            'subscriptionId' =>  $subscription->id ,
            'short_url'      =>  $subscription->short_url,
            'currency'       =>  'INR',
            'email'          =>  $user_details['email'],
            'contactNumber'  =>  $user_details['mobile'],
            'user_id'        =>  $user_details->id,
            'user_name'      =>  $user_details->name,
            'address'        =>  $cityName,
            'description'    =>  null,
            'countryName'    =>  $countryName,
            'regionName'     =>  $regionName,
            'cityName'       =>  $cityName,
            'PaymentGateway' =>  'razorpay',
        );

        return view('Razorpay.checkout',compact('respond'),$respond);
    }

    public function RazorpayCompleted(Request $request)
    {
        $SignatureStatus = $this->RazorpaySignatureVerfiy(
                $request->razorpay_payment_id,
                $request->razorpay_subscription_id,
                $request->razorpay_signature
        );

        if($SignatureStatus == true){
            $userId = $request->user_id;
            $RazorpaySubscription = $request->razorpay_subscription_id;
          
            return Redirect::route('RazorpaySubscriptionStore',['RazorpaySubscription' => $RazorpaySubscription,'userId' => $userId]);
        }
        else{
            echo 'fails';
        }
    }

    private function RazorpaySignatureVerfiy($razorpay_payment_id,$razorpay_subscription_id,$razorpay_signature)
    {
        try {
            $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);
            $attributes  = array('razorpay_signature'  => $razorpay_signature,  'razorpay_payment_id'  => $razorpay_payment_id ,  'razorpay_subscription_id' => $razorpay_subscription_id);
            $order  = $api->utility->verifyPaymentSignature($attributes);
            return true;

        } catch (\Exception $e) {
            return false;
        }
    }

    public function RazorpayUpgrade(Request $request){

        $subscriptionId = "sub_IzpuMPU38PntuD";
        $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);
        $subscription = $api->subscription->fetch($subscriptionId);
        $plan_id      = $api->plan->fetch($subscription['plan_id']);

        $Sub_Startday = date('d/m/Y H:i:s', $subscription['current_start']); 
        $Sub_Endday = date('d/m/Y H:i:s', $subscription['current_end']); 
        $carbon = Carbon::createFromTimestamp($subscription['current_end'])->toDateTimeString(); 


        ThemeIntegration::where('id',1)->update([
            'created_at'    =>  $carbon ,
    ]);

dd($carbon);
        $testing =   $api->subscription->fetch($subscriptionId)->update($attributes);

    }
    
    public function RazorpaySubscriptionStore(Request $request){

        $razorpay_subscription_id = $request->RazorpaySubscription;

        $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);
        $subscription = $api->subscription->fetch($razorpay_subscription_id);
        $plan_id      = $api->plan->fetch($subscription['plan_id']);

        $Sub_Startday = date('d/m/Y H:i:s', $subscription['current_start']); 
        $Sub_Endday = date('d/m/Y H:i:s', $subscription['current_end']); 
        $trial_ends_at = Carbon::createFromTimestamp($subscription['current_end'])->toDateTimeString(); 

            Subscription::create([
            'user_id'        =>  $request->userId,
            'name'           =>  $plan_id['item']->name,
            // 'days'        =>  $fileName_zip,
            'price'          =>  $plan_id['item']->amount / 100,   // Amount Paise to Rupees
            'stripe_id'      =>  $subscription['id'],
            'stripe_status'  =>  $subscription['status'],
            'stripe_plan'    =>  $subscription['plan_id'],
            'quantity'       =>  $subscription['quantity'],
            'countryname'    =>  $request->countryName,
            'regionname'     =>  $request->cityName,
            'cityname'       =>  $request->regionName,
            'PaymentGateway' =>  'Razorpay',
            'trial_ends_at'  =>  $trial_ends_at,
            'ends_at'        =>  $trial_ends_at,
        ]);

        User::where('id',$request->userId)->update([
            'role'                  =>  'subscriber',
            'stripe_id'             =>  $subscription['id'] ,
            'subscription_start'    =>  $Sub_Startday,
            'subscription_ends_at'  =>  $Sub_Endday,
        ]);

        return Redirect::route('home');
    }
    public function RazorpaySubscriptionUpdate(Request $request,$planId){

        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
        $countryName = $geoip->getCountry();
        $regionName = $geoip->getregion();
        $cityName = $geoip->getcity();

        $api    = new Api($this->razorpaykeyId, $this->razorpaykeysecret);
        $plan_Id = $api->plan->fetch($planId);
        $user_id =Auth::User()->id;

        $subscriptionId  = Subscription::where('user_id',$user_id)->latest()->pluck('stripe_id')->first();

        $subscription = $api->subscription->fetch($subscriptionId);
        $remaining_count  =  $subscription['remaining_count'] ;

        $trial_ends_at = Carbon::createFromTimestamp($subscription['current_end'])->toDateTimeString(); 
        $Sub_Startday = date('d/m/Y H:i:s', $subscription['current_start']); 
        $Sub_Endday = date('d/m/Y H:i:s', $subscription['current_end']); 

        if($subscription->payment_method != "upi"){
            
            $options  = array('plan_id'  =>$plan_Id['id'], 'remaining_count' => $remaining_count );
            $api->subscription->fetch($subscriptionId)->update($options);

            $UpdatedSubscription = $api->subscription->fetch($subscriptionId);
            $updatedPlan         = $api->plan->fetch($UpdatedSubscription['plan_id']);
            if (is_null($subscriptionId)) {
                return false;
            }
            else{
                Subscription::where('user_id',$user_id)->latest()->update([
                    'price'          =>  $updatedPlan['item']->amount,
                    'stripe_id'      =>  $UpdatedSubscription['id'],
                    'stripe_status' =>  $UpdatedSubscription['status'],
                    'stripe_plan'    =>  $UpdatedSubscription['plan_id'],
                    'quantity'       =>  $UpdatedSubscription['quantity'],
                    'countryname'    =>  $countryName,
                    'regionname'     =>  $regionName,
                    'cityname'       =>  $cityName,
                    'trial_ends_at'  =>  $trial_ends_at,
                    'ends_at'        =>  $trial_ends_at,
                ]);

                User::where('id',$user_id)->update([
                    'subscription_start'    =>  $Sub_Startday,
                    'subscription_ends_at'  =>  $Sub_Endday,
                ]);
            }
            return Redirect::route('home');
        }
        else{
            return view('Razorpay.UPI'); 
        }
    }

    public function RazorpayCancelSubscriptions(Request $request)
    {
        $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);

        $subscriptionId = User::where('id',Auth::user()->id)->pluck('stripe_id')->first();
        
        $options  = array('cancel_at_cycle_end'  => 0);

        $api->subscription->fetch($subscriptionId)->cancel($options);

        Subscription::where('stripe_id',$subscriptionId)->update([
            'stripe_status' =>  'Cancelled',
        ]);

        return Redirect::route('home')->with('message', 'Invalid Activation.');
    }

 
}

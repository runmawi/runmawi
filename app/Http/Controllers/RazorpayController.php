<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\Authenticatable;
use \Redirect as Redirect;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Session;
use Theme;
use Auth;
use App\Subscription;
use Razorpay\Api\Api;
use AmrShawky\LaravelCurrency\Facade\Currency as PaymentCurreny;


class RazorpayController extends Controller
{
    private $razorpaykeyId = 'rzp_test_008H40SUs59YLK';
    private $razorpaykeysecret = '32tTF7snfEyXZj0z5tEiGdzm';

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

        $user_details =Auth::User();
        $api    = new Api($this->razorpaykeyId, $this->razorpaykeysecret);
        $planId = $api->plan->fetch($Plan_Id);

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
                    $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);
           $subscription = $api->subscription->fetch($request->razorpay_subscription_id);
           $plan_id      = $api->plan->fetch($subscription['plan_id']);

           Subscription::create([
            'user_id'       =>  $request->user_id,
            'name'          =>  $plan_id['item']->name,
            // 'days'          =>  $fileName_zip,
            'price'         =>  $plan_id['item']->amount,
            'stripe_id'     =>  $subscription['id'],
            'stripe_status' =>  $subscription['status'],
            'stripe_plan'   =>  $subscription['plan_id'],
            'quantity'      =>  $subscription['quantity'],
            'countryname'   =>  $request->countryName,
            'regionname'    =>  $request->cityName,
            'cityname'      =>  $request->regionName,
          ]);

          return Redirect::route('home');

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
        $attributes  = array('plan_id'  => 'plan_Izr2tFN32PpNq1', 'remaining_count' => 5 );

        $testing =   $api->subscription->fetch($subscriptionId)->update($attributes);

    }
    
    public function RazorpayCancelSubscriptions(Request $request)
    {
        $subscriptionId = "sub_IzpuMPU38PntuD";

        $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);
        $options  = array('cancel_at_cycle_end'  => 0);
        $CancelSubscriptions = $api->subscription->fetch($subscriptionId)->cancel($options);
        
        return Redirect::route('home');
    }
}

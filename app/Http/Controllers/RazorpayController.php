<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Session;
use Theme;
use Auth;
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

    public function RazorpayIntegration(Request $request,$plan_amount)
    {
        $user_details =Auth::User();

        $plan_id= 'plan_Izlh4Evtfv9lRd';

        $api    = new Api($this->razorpaykeyId, $this->razorpaykeysecret);
        $planId = $api->plan->fetch($plan_id);

        $subscription = $api->subscription->create(array(
        'plan_id' =>  $planId->id, 
        'customer_notify' => 1,
        'total_count' => 6, 
        'addons' => array(array('item' => array('name' => $planId['item']->name , 'amount' => $planId['item']->amount, 'currency' => 'INR')))));

        $respond=array(
            'razorpaykeyId'  =>  $this->razorpaykeyId,
            'name'           =>   $planId['item']->name,
            'subscriptionId' =>  $subscription->id ,
            'short_url'      =>  $subscription->short_url,
            'currency'       =>  'INR',
            'email'          =>  $user_details['email'],
            'contactNumber'  =>  $user_details['mobile'],
            'user_name'      =>  $user_details->name,
            'address'        =>  'India',
            'description'    =>   null,
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
            $data = array(
             'razorpay_payment_id'  =>   $request->razorpay_payment_id,
             'razorpay_subscription_id'  =>   $request->razorpay_subscription_id,
             'razorpay_signature'   =>   $request->razorpay_signature
            );

            return $data;
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

    public function RazorpayPaymentDetails(Request $request){

        // for testing purpose 
        $subscriptionId = "sub_Izmhyzu5n2cCsO";

        $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);

        $data = 
$api->subscription->fetch($subscriptionId);

        dd ($data) ;

    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Session;
use Theme;
use Razorpay\Api\Api;

class RazorpayController extends Controller
{
    private $razorpaykeyId = 'rzp_test_008H40SUs59YLK';
    private $razorpaykeysecret = '32tTF7snfEyXZj0z5tEiGdzm';

    public function Razorpay(Request $request)
    {
        return view('Razorpay.create');
    }

    public function RazorpayIntegration(Request $request)
    {
        $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);

        $user_details = $request->all();

        $orderData = [
            'receipt'         => 'rcptid_11',
            'amount'          => $user_details['amount'] * 100, //  rupees in paise
            'currency'        => 'INR'
        ];
        
        $razorpayOrder = $api->order->create($orderData);

        $respond=array(
            'orderId'        =>  $razorpayOrder['id'],
            'razorpaykeyId'  =>  $this->razorpaykeyId,
            'amount'         =>  $razorpayOrder['amount'],
            'name'           =>  $user_details['name'],
            'currency'       =>  'INR',
            'email'          =>  $user_details['Email'],
            'contactNumber'  =>  '7092748422',
            'address'        =>   'perambur',
            'description'    =>    'null',
        );

        return view('Razorpay.checkout',compact('respond'),$respond);
    }

    public function RazorpayCompleted(Request $request)
    {
        $SignatureStatus = $this->RazorpaySignatureVerfiy(
                $request->razorpay_payment_id,
                $request->razorpay_order_id,
                $request->razorpay_signature
        );

        if($SignatureStatus == true){
            $data = array(
             'razorpay_payment_id'  =>   $request->razorpay_payment_id,
             'razorpay_order_id'  =>   $request->razorpay_order_id,
             'razorpay_signature'   =>   $request->razorpay_signature
            );

            return $data;
        }
        else{
            echo 'fails';
        }
    }

    private function RazorpaySignatureVerfiy($razorpay_payment_id,$razorpay_order_id,$razorpay_signature)
    {
        try {
            $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);
            $attributes  = array('razorpay_signature'  => $razorpay_signature,  'razorpay_payment_id'  => $razorpay_payment_id ,  'razorpay_order_id' => $razorpay_order_id);
            $order  = $api->utility->verifyPaymentSignature($attributes);
            return true;

        } catch (\Exception $e) {
            return false;
        }
    }

    public function RazorpayPaymentDetails(Request $request){

        $paymentId = "pay_IzOaUGUHSGju4j";
        $orderId   = "order_IzOZdhUbVfWExo";
        $amount    = '10000';

        $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);

        $payment =$api->payment->fetch($paymentId);

        $order = $api->order->fetch($orderId)->payments();
        // $otp   = $api->payment->fetch($paymentId)->otpSubmit(array('otp'=> '12345'));

        $data =array(
            $payment,
            $order,
            // $otp,
        );


        dd ($data) ;

    }
}

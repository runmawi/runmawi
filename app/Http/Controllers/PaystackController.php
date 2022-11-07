<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\PaymentSetting;
use App\User;
use Auth;
use Paystack;
use URL;

class PaystackController extends Controller
{
    public function __construct()
    {
        $this->url = "https://api.paystack.co/transaction/initialize";

        $PaymentSetting = PaymentSetting::where('payment_type','Paystack')->first();

        if( $PaymentSetting != null ){

            if( $PaymentSetting->live_mode == 0 ){

                $this->paystack_keyId = $PaymentSetting->paystack_test_publishable_key;
                $this->paystack_keysecret = $PaymentSetting->paystack_test_secret_key;

            }else{

                $this->paystack_keyId = $PaymentSetting->paystack_live_publishable_key;
                $this->paystack_keysecret = $PaymentSetting->paystack_live_secret_key;
            }

            $this->SecretKey_array =  array(
                "Authorization: Bearer $this->paystack_keysecret",
                "Cache-Control: no-cache",
            );
        }else{
            
            $Error_msg = "Paystack Key is Missing";
            $url = URL::to('/home');
            echo "<script type='text/javascript'>alert('$Error_msg'); window.location.href = '$url' </script>";
        }
    }


    public function Paystack_CreateSubscription( Request $request )
    {
        $user_email = User::where('id',Auth::user()->id)->pluck('email')->first();

                    // Plan Details 

        $Plan_details = Paystack::fetchPlan( $request->paystack_plan_id );

        $Plan_amount = $Plan_details['data']['amount'] ;
        $plan_id     = $request->paystack_plan_id ;

        $fields_string = http_build_query( array(
            'email'  => $user_email , 
            'amount' => $Plan_amount, 
            'plan'   => $plan_id, 
        ));
      
        $ch = curl_init();
        
        curl_setopt($ch,CURLOPT_URL, $this->url );
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER,  $this->SecretKey_array);
        
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
        
        $result = json_decode(curl_exec($ch));

        $response = array(
            'authorization_url' => $result->data->authorization_url ,
            'access_code'       => $result->data->access_code ,
            'reference'         => $result->data->reference,
            'email_id'          => $user_email,
            'amount'            => $Plan_amount ,
            'publish_key'       => $this->paystack_keyId,
            'redirect_url'      => URL::to('becomesubscriber'),
        );

        return view('Paystack.checkout',compact('response'),$response);
    }

    public function paystack_verify_request ( Request $request )
    {
        # code...
    }

}

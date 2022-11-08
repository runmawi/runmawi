<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Config;
use Unicodeveloper\Paystack\Exceptions\IsNullException;
use Unicodeveloper\Paystack\Exceptions\PaymentVerificationFailedException;
use GuzzleHttp\Client;
use Carbon\Carbon;
use App\PaymentSetting;
use App\Subscription;
use App\User;
use Auth;
use Paystack;
use URL;

class PaystackController extends Controller
{
    public function __construct()
    {
        $this->customer_create_api_url = "https://api.paystack.co/customer";
        $this->Subscription_create_api_url = "https://api.paystack.co/transaction/initialize";
        $this->Subscription_cancel_api_url = "https://api.paystack.co/subscription/disable";


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

        try {
            $user_email = User::where('id',Auth::user()->id)->pluck('email')->first();

                    // Plan Details 

            $Plan_details = Paystack::fetchPlan( $request->paystack_plan_id );
 
            $Plan_amount = $Plan_details['data']['amount'] ;
            $plan_id     = $request->paystack_plan_id ;

                // Create Customer
        
            $customer_details = http_build_query( array(
                "email" => $user_email , 
                "first_name" => null,
                "last_name" => null,
                "phone" => null
            ));
        
            $ch = curl_init();
            
            curl_setopt($ch,CURLOPT_URL, $this->customer_create_api_url);
            curl_setopt($ch,CURLOPT_POST, true);
            curl_setopt($ch,CURLOPT_POSTFIELDS, $customer_details );
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->SecretKey_array);
            
            curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
            
            $customer = (curl_exec($ch));

            $customer_respond = json_decode($customer, true);

            $customer_id = $customer_respond['data']['customer_code'] ;

            session(['paystack_customer_id' => $customer_id ]);

                 // Create Subscription 

            $Subscription_details = http_build_query( array(
                'email'  => $user_email , 
                'amount' => $Plan_amount, 
                'plan'   => $plan_id, 
            ));
      
            $sub = curl_init();
            
            curl_setopt($sub,CURLOPT_URL, $this->Subscription_create_api_url );
            curl_setopt($sub,CURLOPT_POST, true);
            curl_setopt($sub,CURLOPT_POSTFIELDS, $Subscription_details);
            curl_setopt($sub, CURLOPT_HTTPHEADER,  $this->SecretKey_array);
            
            curl_setopt($sub,CURLOPT_RETURNTRANSFER, true); 
        
            $subscription = (curl_exec($sub));

            $result = json_decode($subscription, true);

            $response = array(
                'status'           => true ,
                'message'          => "Customer & Authorization url Successfully Created !" , 
                'authorization_url' => $result['data']['authorization_url'] , 
                'access_code'       => $result['data']['access_code'] , 
                'reference'         => $result['data']['reference'], 
                'email_id'          => $user_email,
                'amount'            => $Plan_amount ,
                'publish_key'       => $this->paystack_keyId,
                'redirect_url'      => URL::to('becomesubscriber'),
            );
        } 
        catch (\Throwable $th) {

           $response = array(
                "status"  => false ,
                "message" => $th->getMessage() , 
            );
        }
        
        return response()->json($response, 200);
    }

    public function paystack_verify_request ( Request $request )
    {

        if( $request->trxref != null && $request->reference != null ){

                // Customer Details
            $paystack_customer_id = session('paystack_customer_id');

            $customer_details = Paystack::fetchCustomer( $paystack_customer_id );

                // Subscription Details
            $subcription_id = $customer_details['data']['subscriptions'][0]['subscription_code'] ;

            $subcription_details = Paystack::fetchSubscription($subcription_id) ;

            $Sub_Startday =Carbon::parse($subcription_details['data']['createdAt'])->setTimezone('UTC')->format('d/m/Y H:i:s'); 
            $Sub_Endday = Carbon::parse($subcription_details['data']['next_payment_date'] )->setTimezone('UTC')->format('d/m/Y H:i:s'); 
            $trial_ends_at = Carbon::parse($subcription_details['data']['next_payment_date'] )->setTimezone('UTC')->toDateTimeString(); 

                // Subscription Details
            $user_id = Auth::user()->id;

            Subscription::create([
                'user_id'        =>  $user_id,
                'name'           =>  $subcription_details['data']['plan']['name'],
                'price'          =>  $subcription_details['data']['amount'] ,   // Amount Paise to Rupees
                'stripe_id'      =>  $subcription_details['data']['subscription_code'] ,
                'stripe_status'  =>  $subcription_details['data']['status'] ,
                'stripe_plan'    =>  $subcription_details['data']['plan']['plan_code'],
                'quantity'       =>  null,
                'countryname'    =>  Country_name(),
                'regionname'     =>  Region_name(),
                'cityname'       =>  city_name(),
                'PaymentGateway' =>  'Paystack',
                'trial_ends_at'  =>  $trial_ends_at,
                'ends_at'        =>  $trial_ends_at,
            ]);

            User::where('id',$user_id)->update([
                'role'                  =>  'subscriber',
                'stripe_id'             =>  $subcription_details['data']['subscription_code'] ,
                'subscription_start'    =>  $Sub_Startday,
                'subscription_ends_at'  =>  $Sub_Endday,
                'payment_gateway'       =>  'Paystack',
            ]);

            $request->session()->forget('paystack_customer_id');

            return redirect()->route('home');
        }
    }

    public function paystack_Subscription_update( Request $request )
    {
        
    }

    public function Paystack_Subscription_cancel( Request $request , $subscription_id )
    {
        $subcription_details = Paystack::fetchSubscription( $subscription_id ) ;

        $fields_string = http_build_query(array(
            'code'  =>  $subcription_details['data']['subscription_code'] ,
            'token' =>  $subcription_details['data']['email_token'] ,
        ));
      
        $ch = curl_init();
        
        curl_setopt($ch,CURLOPT_URL, $this->Subscription_cancel_api_url);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->SecretKey_array);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
        
        $Paystack_Subscription_cancel = curl_exec($ch);
        $result = json_decode($Paystack_Subscription_cancel, true);

        // dd( $result['message'] );

        Subscription::where('stripe_id',$subscription_id )->update([
            'stripe_status' =>  'Cancelled',
        ]);

        User::where('id',Auth::user()->id )->update([
            'payment_gateway' =>  null ,
        ]);

        return redirect()->route('home');
    }
}
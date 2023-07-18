<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User as User;
use \Redirect as Redirect;
//use Request;
use URL;
use Auth;
use App\Setting as Setting;
use App\PaymentSetting as PaymentSetting;
use Hash;
use Illuminate\Support\Facades\Cache;
use Image;
use View;
use App\PaypalPaymentSetting as PaypalPaymentSetting;
use App\SubscriptionPlan as SubscriptionPlan;



class AdminPaymentSettingsController extends Controller
{
    public function index()
	{

		$data = array(
			'admin_user' => Auth::user(),
			'settings' => Setting::first(),
			'payment_settings' => PaymentSetting::where('payment_type','=','Stripe')->first(),
			'paypal_payment_settings' => PaymentSetting::where('payment_type','=','PayPal')->first(),
			'Razorpay_payment_setting' =>  PaymentSetting::where('payment_type','=','Razorpay')->first(),
			'paystack_payment_setting' =>  PaymentSetting::where('payment_type','=','Paystack')->first(),
			'Cinet_payment_setting' =>  PaymentSetting::where('payment_type','=','CinetPay')->first(),
			);

		return View::make('admin.paymentsettings.index', $data);
	}
    
    public function save_payment_settings(Request $request){

		$input = $request->all();

        $payment_settings = PaymentSetting::where('payment_type','=','Stripe')->first();

		$stripe_status = empty($input['stripe_status']) ? 0 : 1 ;

		$live_mode = empty($input['live_mode']) ? 0 : 1 ;
		// dd($live_mode);
		$Env_path = realpath(('.env'));

		if($live_mode == 0){
			$Replace_data =array(
				'STRIPE_KEY'         	=>  $request['test_secret_key'],
				'STRIPE_SECRET'         =>  $request['test_publishable_key'],
			);
		}else if($live_mode == 1){
			$Replace_data =array(
				'STRIPE_KEY'         	=>  $request['live_secret_key'],
				'STRIPE_SECRET'         =>  $request['live_publishable_key'],
			);
		}else{
			$Replace_data =array(
				'STRIPE_KEY'         	=>  '',
				'STRIPE_SECRET'         =>  '',
			);
		}

		file_put_contents($Env_path, implode('', 
		array_map(function($Env_path) use ($Replace_data) {
			return   stristr($Env_path,'STRIPE_KEY') ? "STRIPE_KEY=".$Replace_data['STRIPE_KEY']."\n" : $Env_path;
		}, file($Env_path))
		));

		file_put_contents($Env_path, implode('', 
				array_map(function($Env_path) use ($Replace_data) {
					return   stristr($Env_path,'STRIPE_SECRET') ? "STRIPE_SECRET=".$Replace_data['STRIPE_SECRET']."\n" : $Env_path;
				}, file($Env_path))
		));

		$payment_settings->live_mode = $live_mode;
		$payment_settings->stripe_status = $stripe_status;
		$payment_settings->status = $stripe_status;
		$payment_settings->test_secret_key = $request['test_secret_key'];
		$payment_settings->test_publishable_key = $request['test_publishable_key'];
		$payment_settings->live_secret_key = $request['live_secret_key'];
		$payment_settings->live_publishable_key = $request['live_publishable_key'];
		$payment_settings->plan_name = $request['plan_name'];
		$payment_settings->stripe_lable = $request['stripe_lable'];
		$payment_settings->payment_type = "Stripe";
		$payment_settings->subscription_trail_days = $request["subscription_trail_days"] ;
		$payment_settings->subscription_trail_status = empty($input['subscription_trail_status']) ? 0 : 1 ;


		if(empty($payment_settings->stripe_lable)){
			$payment_settings->stripe_lable   = '';
		} else {
            $payment_settings->stripe_lable   = $input['stripe_lable'];
        }

		// if(empty($payment_settings->live_mode) || $payment_settings->live_mode == ''){
            
		// 	$payment_settings->live_mode = 0;
		// }
		// if(empty($payment_settings->stripe_status) || $payment_settings->stripe_status == ''){
            
		// 	$payment_settings->stripe_status = 0;
		// }
        
        if(empty($payment_settings->test_secret_key)){
            
			$payment_settings->test_secret_key = '';
		}

        
		if(empty($payment_settings->test_publishable_key )){
            
			$payment_settings->test_publishable_key  = '';
		}
	   
        if(empty($payment_settings->live_secret_key)){
			$payment_settings->live_secret_key  = '';
		}   
        
        if(empty($payment_settings->plan_name)){
			$payment_settings->plan_name   = '';
		} else {
            $payment_settings->plan_name   = $input['plan_name'];
        }
        
        if(empty($payment_settings->live_publishable_key)){
            
			$payment_settings->live_publishable_key  = '';
		}
		$Env_path = realpath(('.env'));



        $payment_settings->save();


        $payment_settings = PaymentSetting::where('payment_type','=','PayPal')->first();

		if( $payment_settings != null){
			
		if(empty($input['paypal_live_mode'])){
			$paypal_live_mode = 0;
		}else{
			$paypal_live_mode = 1;
		}
		if(empty($input['paypal_status'])){
			$paypal_status = 0;
		}else{
			$paypal_status = 1;
		}
		$payment_settings->paypal_live_mode = $paypal_live_mode;
		$payment_settings->paypal_status = $paypal_status;
		$payment_settings->status = $paypal_status;
		$payment_settings->test_paypal_username = $request['test_paypal_username'];
		$payment_settings->test_paypal_password = $request['test_paypal_password'];
		$payment_settings->test_paypal_signature = $request['test_paypal_signature'];
		$payment_settings->live_paypal_username = $request['live_paypal_username'];
		$payment_settings->live_paypal_password = $request['live_paypal_password'];
		$payment_settings->live_paypal_signature = $request['live_paypal_signature'];
		$payment_settings->paypal_plan_name = $request['paypal_plan_name'];
		$payment_settings->paypal_lable = $request['paypal_lable'];
		$payment_settings->payment_type = "PayPal";


        
		if(empty($payment_settings->paypal_lable)){
			$payment_settings->paypal_lable   = '';
		} else {
            $payment_settings->paypal_lable   = $input['paypal_lable'];
        }
		// if(empty($payment_settings->paypal_live_mode) || $payment_settings->paypal_live_mode == ''){
            
		// 	$payment_settings->paypal_live_mode = 0;
		// }
		// if(empty($payment_settings->paypal_status) || $payment_settings->paypal_status == ''){
            
		// 	$payment_settings->paypal_status = 0;
		// }
        
        if(empty($payment_settings->test_paypal_username)){
            
			$payment_settings->test_paypal_username = '';
		}

        
		if(empty($payment_settings->test_paypal_password )){
            
			$payment_settings->test_paypal_password  = '';
		}
	   
        if(empty($payment_settings->test_paypal_signature)){
			$payment_settings->test_paypal_signature  = '';
		}   
        
        if(empty($payment_settings->paypal_plan_name)){
			$payment_settings->paypal_plan_name   = '';
		} else {
            $payment_settings->paypal_plan_name   = $input['paypal_plan_name'];
        }
        
        if(empty($payment_settings->live_paypal_username)){
            
			$payment_settings->live_paypal_username  = '';
		}

        if(empty($payment_settings->live_paypal_password)){
            
			$payment_settings->live_paypal_password = '';
		}

        
		if(empty($payment_settings->live_paypal_signature )){
            
			$payment_settings->live_paypal_signature  = '';
		}
	   
        $payment_settings->save();
	}

// Razorpay 


	$Razorpay_payment_setting =  PaymentSetting::where('payment_type','=','Razorpay')->first();


	if($Razorpay_payment_setting != null){

		if(empty($request['Razorpay_live_mode'])){
			$Razorpay_live_mode = 0;
		}else{
			$Razorpay_live_mode = 1;
		}

		if(empty($request['Razorpay_status'])){
			$Razorpay_status = 0;
		}else{
			$Razorpay_status = 1;
		}


		$Razorpay_payment_setting->live_mode         =    $Razorpay_live_mode;
		$Razorpay_payment_setting->status            =    $Razorpay_status;
		$Razorpay_payment_setting->test_secret_key   =    $request['Razorpay_test_secret_key'] ?  $request['Razorpay_test_secret_key'] : null;
		$Razorpay_payment_setting->test_publishable_key = $request['Razorpay_test_publishable_key'] ?  $request['Razorpay_test_publishable_key'] : null;
		$Razorpay_payment_setting->live_secret_key 		= $request['Razorpay_live_secret_key'] ?  $request['Razorpay_live_secret_key'] : null;
		$Razorpay_payment_setting->live_publishable_key = $request['Razorpay_live_publishable_key'] ?  $request['Razorpay_live_publishable_key'] :null;
		$Razorpay_payment_setting->plan_name 			= $request['Razorpay_plan_name'] ?  $request['Razorpay_plan_name'] : null;
		$Razorpay_payment_setting->payment_type 		= "Razorpay";
		$Razorpay_payment_setting->Razorpay_lable 		= $request['Razorpay_lable'] ;
        $Razorpay_payment_setting->save();
	}


	// Paystack

	$paystack_payment_setting =  PaymentSetting::where('payment_type','=','Paystack')->first();

	$Env_path = realpath(('.env'));

	if($paystack_payment_setting != null){

		if(empty($request['paystack_live_mode'])){
			$paystack_live_mode = 0;
		}else{
			$paystack_live_mode = 1;
		}

		if(empty($request['paystack_status'])){
			$paystack_status = 0;
		}else{
			$paystack_status = 1;
		}

		$paystack_payment_setting->paystack_live_mode            =    $paystack_live_mode;
		$paystack_payment_setting->status                        =    $paystack_status;
		$paystack_payment_setting->paystack_status               =    $paystack_status;
		$paystack_payment_setting->paystack_test_secret_key      =    $request['paystack_test_secret_key'] ?  $request['paystack_test_secret_key'] : null;
		$paystack_payment_setting->paystack_test_publishable_key = 	  $request['paystack_test_publishable_key'] ?  $request['paystack_test_publishable_key'] : null;
		$paystack_payment_setting->paystack_live_secret_key      = 	  $request['paystack_live_secret_key'] ?  $request['paystack_live_secret_key'] : null;
		$paystack_payment_setting->paystack_live_publishable_key = 	  $request['paystack_live_publishable_key'] ?  $request['paystack_live_publishable_key'] :null;
		$paystack_payment_setting->paystack_lable 			 	 = 	  $request['paystack_lable'] ?  $request['paystack_lable'] : null;
		$paystack_payment_setting->payment_type 				 =    "Paystack";
		$paystack_payment_setting->paystack_callback_url 	     =    URL::to('/paystack-verify-request');
        $paystack_payment_setting->save();
	}


	
	// CinetPay

	$CinetPay_payment_setting =  PaymentSetting::where('payment_type','=','CinetPay')->first();

	$Env_path = realpath(('.env'));

	if($CinetPay_payment_setting != null){

		$CinetPay_payment_setting->status                        	=     !empty($request->CinetPay_Status) ? 1 : 0;
		$CinetPay_payment_setting->CinetPay_Status               	=     !empty($request->CinetPay_Status) ? 1 : 0;
		$CinetPay_payment_setting->CinetPay_Lable      				=     $request['CinetPay_Lable'] ?  $request['CinetPay_Lable'] : null;
		$CinetPay_payment_setting->CinetPay_APIKEY 					= 	  $request['CinetPay_APIKEY'] ?  $request['CinetPay_APIKEY'] : null;
		$CinetPay_payment_setting->CinetPay_SecretKey      			= 	  $request['CinetPay_SecretKey'] ?  $request['CinetPay_SecretKey'] : null;
		$CinetPay_payment_setting->CinetPay_SITE_ID 				= 	  $request['CinetPay_SITE_ID'] ?  $request['CinetPay_SITE_ID'] :null;
		$CinetPay_payment_setting->paystack_lable 			 	 	= 	  $request['paystack_lable'] ?  $request['paystack_lable'] : null;
		$CinetPay_payment_setting->payment_type 				 	=    "CinetPay";
        $CinetPay_payment_setting->save();
	}

        return Redirect::to('admin/payment_settings')->with(array('note' => 'Successfully Updated Payment Settings!', 'note_type' => 'success') );
	}	
}

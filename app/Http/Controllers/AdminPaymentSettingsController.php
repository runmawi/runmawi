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
			'payment_settings' => PaymentSetting::first(),
			'paypal_payment_settings' => PaymentSetting::where('id','=',2)->first(),
			);
		return View::make('admin.paymentsettings.index', $data);
	}
    
    public function save_payment_settings(Request $request){

		$input = $request->all();
        
        $payment_settings = PaymentSetting::first();
      

		$payment_settings->live_mode = $request['live_mode'];
		$payment_settings->test_secret_key = $request['test_secret_key'];
		$payment_settings->test_publishable_key = $request['test_publishable_key'];
		$payment_settings->live_secret_key = $request['live_secret_key'];
		$payment_settings->live_publishable_key = $request['live_publishable_key'];
		$payment_settings->plan_name = $request['plan_name'];
		$payment_settings->payment_type = "Stripe";

		

		if(empty($payment_settings->live_mode) || $payment_settings->live_mode == ''){
            
			$payment_settings->live_mode = 0;
		}
        
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
        
        $payment_settings->save();


        $payment_settings = PaymentSetting::where('id','=',2)->first();

		$payment_settings->paypal_live_mode = $request['paypal_live_mode'];
		$payment_settings->test_paypal_username = $request['test_paypal_username'];
		$payment_settings->test_paypal_password = $request['test_paypal_password'];
		$payment_settings->test_paypal_signature = $request['test_paypal_signature'];
		$payment_settings->live_paypal_username = $request['live_paypal_username'];
		$payment_settings->live_paypal_password = $request['live_paypal_password'];
		$payment_settings->live_paypal_signature = $request['live_paypal_signature'];
		$payment_settings->paypal_plan_name = $request['paypal_plan_name'];
		$payment_settings->payment_type = "PayPal";


        
		if(empty($payment_settings->paypal_live_mode) || $payment_settings->paypal_live_mode == ''){
            
			$payment_settings->paypal_live_mode = 0;
		}
        
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

        
        return Redirect::to('admin/payment_settings')->with(array('note' => 'Successfully Updated Payment Settings!', 'note_type' => 'success') );

	}	
	


}

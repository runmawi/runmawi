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


class AdminPaymentSettingsController extends Controller
{
    public function index()
	{

		$data = array(
			'admin_user' => Auth::user(),
			'settings' => Setting::first(),
			'payment_settings' => PaymentSetting::first(),
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
        
        return Redirect::to('admin/payment_settings')->with(array('note' => 'Successfully Updated Payment Settings!', 'note_type' => 'success') );

	}	

}

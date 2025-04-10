<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\AdminOTPCredentials;
use App\OTPLog;
use App\User;

class AdminOTPCredentialsController extends Controller
{
    public function index()
    {
        $OTP_Logs =  OTPLog::get()->map(function($item){
            $item['name'] = User::where('id', $item->User_id)->pluck('username')->first();
            $item['created_at_format'] = Carbon::parse($item->created_at)->isoFormat('Do MMM YYYY hh:mm A');
            return $item ;
        });

        $data = array(
            'AdminOTPCredentials' => AdminOTPCredentials::first(),
            'OTP_Logs' => $OTP_Logs,
        );

        return view('admin.OTP.index',$data);
    }

    public function update(Request $request)
    {
        $AdminOTPCredentials = AdminOTPCredentials::first();

        $inputs = array(
            'otp_vai' => $request->otp_vai ,
            'otp_fast2sms_api_key'   => $request->otp_fast2sms_api_key ,
            'otp_24x7sms_api_key'    => $request->otp_24x7sms_api_key ,
            'otp_24x7sms_sender_id'  => $request->otp_24x7sms_sender_id ,
            'otp_24x7sms_sevicename' => $request->otp_24x7sms_sevicename ,
            'DLTTemplateID'    => $request->DLTTemplateID ,
            'template_message' => $request->template_message ,
            'INTL_template_message' => $request->INTL_template_message ,
            'otp_24x7sms_INTL_sender_id' => $request->otp_24x7sms_INTL_sender_id ,
            'status' => !empty($request->status) && $request->status == "on" ? 1 : 0  ,
        );

        !is_null($AdminOTPCredentials) ? AdminOTPCredentials::first()->update($inputs) : AdminOTPCredentials::create($inputs) ;

        return redirect()->route('admin.OTP-Credentials-index');
    }
}
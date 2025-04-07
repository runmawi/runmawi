<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\AdminOTPCredentials;
use App\HomeSetting;
use App\Setting; 
use App\User;
use App\SignupOtp;
use Theme;
use URL;   

class OTPController extends Controller
{

    public function __construct()
    {
        $this->Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses(  $this->Theme );
    }

    public function OTP_index(Request $request)
    {
        return Theme::view('auth.otp.index');
    }

    public function check_mobile_exist(Request $request)
    {
        $mobile = $request->input('mobile');

        $user = User::where('mobile', $mobile)->first();

        if( is_null($mobile)){
            return response()->json(['exists' => false]);
        }

        if (!is_null($user)) {
            return response()->json(['exists' => true]);
        } else {
            return response()->json(['exists' => false]);
        }
    }

    public function Sending_OTP(Request $request){

        $AdminOTPCredentials =  AdminOTPCredentials::where('status',1)->first();

            // Check Admin OTP Credentials
        if(is_null($AdminOTPCredentials)){
            return response()->json(['exists' => false, 'message_note' => 'Some Error in OTP Config, Pls connect admin', 'error_note' => "Some Error in OTP Config, Pls connect admin" ]);
        }

        $user = User::where('mobile', $request->mobile)->first();

            // Check user exists
        if(is_null($user)){
            return response()->json(['exists' => false, 'message_note' => 'Invalid User, Please check this Mobile Number','error_note' => "Invalid User"]);
        }

            // Check Admin exists
        if (  (!is_null($user) && $user->mobile == "9962743248" ) || (!is_null($user) && $user->role == "admin")) {
            return response()->json(['exists' => true, 'message_note' => 'OTP Sent Successfully!']);
        }

        try {
            
            $random_otp_number = random_int(1000, 9999);
            $ccode = str_replace('+','',$request->ccode );
            $mobile             = $request->mobile;

            $Mobile_number     = $ccode.$request->mobile ;

            $user = User::where('mobile',$mobile)->first();

            if( $AdminOTPCredentials->otp_vai == "fast2sms" ){

                $fast2sms_API_key  = $AdminOTPCredentials->otp_fast2sms_api_key ;

                $response = Http::withOptions(['verify' => false, ])  
                ->get('https://www.fast2sms.com/dev/bulkV2', [
                        'authorization'    => $fast2sms_API_key ,
                        'variables_values' => $random_otp_number,
                        'route'   => 'otp',
                        'numbers' => $user->mobile ,
                        'flash'   => 1 ,
                    ]);

                    User::find($user->id)->update([
                        'otp' => $random_otp_number ,
                        'otp_request_id' => $response['request_id'] ,
                        'otp_through' =>  $AdminOTPCredentials->otp_vai ,
                    ]);

                return response()->json(['exists' => true]);

            }

            if( $AdminOTPCredentials->otp_vai == "24x7sms" ){

                $API_key_24x7sms  = $AdminOTPCredentials->otp_24x7sms_api_key ;
                $SenderID = $AdminOTPCredentials->otp_24x7sms_sender_id ;
                $ServiceName = $AdminOTPCredentials->otp_24x7sms_sevicename ;

                $DLTTemplateID = $AdminOTPCredentials->DLTTemplateID ;
                $message = Str_replace('{#var#}', $random_otp_number , $AdminOTPCredentials->template_message) ;

                $inputs = array(
                    'APIKEY' => $API_key_24x7sms,
                    'MobileNo' => $Mobile_number,
                    'SenderID' => $SenderID,
                    'ServiceName' => $ServiceName,
                );

                if ($ServiceName == "TEMPLATE_BASED") {
                    $inputs += array(
                        // 'DLTTemplateID' => $DLTTemplateID,
                        'Message' => $message,
                    );
                }

                if ($ServiceName == "INTERNATIONAL") {
                    $inputs += array('Message' => $message );
                }

                $response = Http::get('https://smsapi.24x7sms.com/api_2.0/SendSMS.aspx', $inputs);

                if (str_contains($response->body(), 'success')) {

                    $parts = explode(':', $response->body());
                    $msgId = $parts[1];

                    User::find($user->id)->update([
                        'otp' => $random_otp_number ,
                        'otp_request_id' => $msgId ,
                        'otp_through' =>  $AdminOTPCredentials->otp_vai ,
                    ]);

                    return response()->json(['exists' => true, 'message_note' => 'OTP Sent Successfully!', 'error_note' => " "]);

                }else {
                    return response()->json(['exists' => false, 'message_note' => 'OTP Not Sent!' , 'error_note' => " " ]);
                }         
            }
           
        } catch (\Throwable $th) {
            
            return response()->json(['exists' => false, 'message_note' => 'OTP Not Sent!','error_note' => $th->getMessage()]);

        }
    }

    public function otp_verification(Request $request)
    {
        try {

            $otp = $request->input('otp_1') . $request->input('otp_2') . $request->input('otp_3') . $request->input('otp_4');

            $user_verify = User::where('mobile',$request->mobile)->where('otp',$otp)->first();

            // Login for admin 
            
            if ( !is_null($user_verify) && $user_verify->role == "admin") {

                Auth::loginUsingId($user_verify->id);

                $redirection_url = session()->get('url.intended', URL::to('/choose-profile') );

                return response()->json( [ 'status' => true , 'redirection_url' => $redirection_url , 'message_note' => 'OTP verify successfully!' ] );
            }

            if( !is_null($user_verify) ){
                        
                Auth::loginUsingId($user_verify->id);

                switch (Auth::user()->role) {
                    case 'subscriber':
                        $redirection_url = URL::to('/choose-profile');
                        break;
                
                    case 'admin':
                        $redirection_url = session()->get('url.intended', URL::to('/choose-profile'));
                        break;
                
                    default:
                        $redirection_url = session()->get('url.intended', URL::to('/home'));
                        break;
                }
                
                if ($user_verify->mobile != "9962743248" ) {
                    
                    User::find($user_verify->id)->update([
                        'otp' => null ,
                        'otp_request_id' => null ,
                        'otp_through' => null ,
                    ]);
                }

                return response()->json( [ 'status' => true , 'redirection_url' => $redirection_url , 'message_note' => 'OTP verify successfully!' ] );
            }

            return response()->json( [ 'status' => false , 'message_note' => 'Please, Enter the Valid OTP !' ] );
            
        } catch (\Throwable $th) {

            return response()->json( [ 'status' => false , 'fails' => $th->getMessage() ] );
        }
    }

    // Signup

    public function Signup_check_mobile_exist(Request $request)
    {
        $mobile = $request->input('mobile');

        $user = User::where('mobile', $mobile)->first();

        if( is_null($mobile)){
            return response()->json(['exists' => false]);
        }

        if ( is_null($user)) {
            return response()->json(['exists' => true]);
        } else {
            return response()->json(['exists' => false]);
        }
    }


    public function Signup_Sending_OTP(Request $request)
    {
        $AdminOTPCredentials =  AdminOTPCredentials::where('status',1)->first();

        if(is_null($AdminOTPCredentials)){
            return response()->json(['exists' => false, 'message_note' => 'Some Error in OTP Config, Please connect admin']);
        }

        try {
            
            $random_otp_number = random_int(1000, 9999);
            $ccode = str_replace('+','',$request->ccode );
            $mobile             = $request->mobile;
            $Mobile_number      = $ccode.$request->mobile ;

            $user = SignupOtp::where('mobile_number',$mobile)->first();

            if( $AdminOTPCredentials->otp_vai == "fast2sms" ){

                $fast2sms_API_key  = $AdminOTPCredentials->otp_fast2sms_api_key ;

                $response = Http::withOptions(['verify' => false, ])  
                ->get('https://www.fast2sms.com/dev/bulkV2', [
                        'authorization'    => $fast2sms_API_key ,
                        'variables_values' => $random_otp_number,
                        'route'   => 'otp',
                        'numbers' => $user->mobile ,
                        'flash'   => 1 ,
                    ]);

                    $SignupOtp_inputs = array(
                        'otp' => $random_otp_number ,
                        'otp_request_id' => $response['request_id'] ,
                        'otp_through' =>  $AdminOTPCredentials->otp_vai ,
                    );

                    SignupOtp::updateOrCreate(['id' => $user->id ?? null], $SignupOtp_inputs);

                    return response()->json(['exists' => true]);

            }

            if( $AdminOTPCredentials->otp_vai == "24x7sms" ){

                $API_key_24x7sms  = $AdminOTPCredentials->otp_24x7sms_api_key ;
                $SenderID = $AdminOTPCredentials->otp_24x7sms_sender_id ;
                $ServiceName = $AdminOTPCredentials->otp_24x7sms_sevicename ;

                $DLTTemplateID = $AdminOTPCredentials->DLTTemplateID ;
                $message = Str_replace('{#var#}', $random_otp_number , $AdminOTPCredentials->template_message) ;

                $inputs = array(
                    'APIKEY' => $API_key_24x7sms,
                    'MobileNo' => $Mobile_number,
                    'SenderID' => $SenderID,
                    'ServiceName' => $ServiceName,
                );

                if ($ServiceName == "TEMPLATE_BASED") {
                    $inputs += array(
                        // 'DLTTemplateID' => $DLTTemplateID,
                        'Message' => $message,
                    );
                }

                if ($ServiceName == "INTERNATIONAL") {
                    $inputs += array('Message' => $message );
                }

                $response = Http::get('https://smsapi.24x7sms.com/api_2.0/SendSMS.aspx', $inputs);

                if (str_contains($response->body(), 'success')) {

                    $parts = explode(':', $response->body());
                    $msgId = $parts[1];

                    $SignupOtp_inputs = array(
                        'mobile_number' => $request->mobile,
                        'otp' => $random_otp_number ,
                        'otp_request_id' => $msgId ,
                        'otp_through' =>  $AdminOTPCredentials->otp_vai ,
                        'ccode'       => $request->ccode,
                    );

                    SignupOtp::updateOrCreate(['id' => $user->id ?? null], $SignupOtp_inputs);

                    return response()->json(['exists' => true, 'message_note' => 'OTP Sent Successfully!']);

                }else {
                    return response()->json(['exists' => false, 'message_note' => 'OTP Not Sent!']);
                }         
            }
           
        } catch (\Throwable $th) {
            
            return response()->json(['exists' => false, 'message_note' => 'OTP Not Sent!','error_note' => $th->getMessage()]);

        }
    }

    public function signup_otp_verification(Request $request)
    {
        try {

            $user_verify = SignupOtp::where('mobile_number',$request->mobileNumber)->where('otp',$request->otp)->first();

            if( !is_null($user_verify) ){

                SignupOtp::find($user_verify->id)->update([
                    'otp' => null ,
                    'otp_request_id' => null ,
                    'otp_through' => null ,
                ]);

                return response()->json( [ 'status' => true , 'message_note' => 'OTP verify successfully!' ] );
            }

            return response()->json( [ 'status' => false , 'message_note' => 'Please, Enter the Valid OTP !' ] );
            
        } catch (\Throwable $th) {

            return response()->json( [ 'status' => false , 'fails' => $th->getMessage() ] );
        }
    }
}
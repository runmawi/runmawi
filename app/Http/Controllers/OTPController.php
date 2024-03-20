<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\AdminOTPCredentials;
use App\HomeSetting;
use App\Setting;
use Theme;
use URL;    
use App\User;

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

        $AdminOTPCredentials =  AdminOTPCredentials::where('otp_vai','fast2sms')->where('status',1)->first();

        if(is_null($AdminOTPCredentials)){

            $Error_msg = "Admin OTP Credentials Key is Missing";
            $url = URL::to('/login');
            echo "<script type='text/javascript'>alert('$Error_msg'); window.location.href = '$url' </script>";
        }

        try {
            
            $random_otp_number = random_int(1000, 9999);
            $fast2sms_API_key  = $AdminOTPCredentials->otp_fast2sms_api_key ;
            $Mobile_number     = $request->mobile ;

            $user = User::where('mobile',$Mobile_number)->first();

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
                'otp_through' => 'fast2sms' ,
            ]);

            return redirect()->route('auth.otp.verify-otp', ['id'=> $user->id ] );

        } catch (\Throwable $th) {
            
            return abort(404);
        }
    }
    
    public function Verify_OTP(Request $request)
    {
        $data = array(
            'user' => User::find($request->id),
        );
        
        return Theme::view('auth.otp.verify-page',$data);
    }

    public function otp_verification(Request $request)
    {
        try {
            
            $otp = $request->input('otp_1') . $request->input('otp_2') . $request->input('otp_3') . $request->input('otp_4');

            $user_verify = User::where('id',$request->user_id)->where('otp',$otp)->first();

            if( !is_null($user_verify) ){
                        
                Auth::loginUsingId($request->user_id);

                if( (Auth::user()->role == 'subscriber') || ( Auth::user()->role == 'admin') ){

                    $redirection_url = URL::to('/choose-profile') ;

                }else{
                    $redirection_url = URL::to('/home') ;
                }

                User::find($request->user_id)->update([
                    'otp' => null ,
                    'otp_request_id' => null ,
                    'otp_through' => null ,
                ]);

                return response()->json( [ 'status' => true , 'redirection_url' => $redirection_url , 'message_note' => 'OTP verify successfully!' ] );
            }

            return response()->json( [ 'status' => false , 'message_note' => 'Pls, Enter the Valid OTP !' ] );
            
        } catch (\Throwable $th) {

            return response()->json( [ 'status' => false , 'fails' => $th->getMessage() ] );
        }
    }
}
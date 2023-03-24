<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Config;
use Unicodeveloper\Paystack\Exceptions\IsNullException;
use Unicodeveloper\Paystack\Exceptions\PaymentVerificationFailedException;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use Carbon\Carbon;
use App\PaymentSetting;
use App\Subscription;
use App\PpvPurchase;
use App\Paystack_Andriod_UserId;
use App\VideoCommission;
use App\ModeratorsUser;
use App\Video;
use App\LivePurchase;
use App\LiveStream;
use App\User;
use App\Setting;
use Auth;
use Paystack;
use URL;

class CinetPayController extends Controller
{
    public function __construct()
    {
        $PaymentSetting = PaymentSetting::where('payment_type','CinetPay')->first();
    }



    public function CinetPay_Video_Rent_Payment(Request $request)
    {
        $data = $request->all();
        $email = User::where('id',Auth::user()->id)->pluck('email')->first();
        
        try{
            $to_time = ppv_expirytime_started(); 

        $video = Video::where('id','=',$request->video_id)->first();
        if(!empty($video)){
        $moderators_id = $video->user_id;
        }

        if(!empty($moderators_id)){
            $moderator        = ModeratorsUser::where('id','=',$moderators_id)->first();  
            $total_amount     = $video->ppv_price;
            $title            =  $video->title;
            $commssion        = VideoCommission::first();
            $percentage       = $commssion->percentage; 
            $ppv_price        = $video->ppv_price;
            $admin_commssion  = ($percentage/100) * $ppv_price ;
            $moderator_commssion = $ppv_price - $percentage;
            $moderator_id = $moderators_id;
        }
        else
        {
            $total_amount   = $video->ppv_price;
            $title          =  $video->title;
            $commssion      = VideoCommission::first();
            $percentage     = null; 
            $ppv_price       = $video->ppv_price;
            $admin_commssion =  null;
            $moderator_commssion = null;
            $moderator_id = null;
        }

        $purchase = new PpvPurchase;
        $purchase->user_id       =  Auth::user()->id ;
        $purchase->video_id       = $request->video_id ;
        $purchase->total_amount  = $video->ppv_price ; 
        $purchase->admin_commssion = $admin_commssion;
        $purchase->moderator_commssion = $moderator_commssion;
        $purchase->status = 'active';
        $purchase->to_time = $to_time;
        $purchase->moderator_id = $moderator_id;
        $purchase->save();

        if ($err) {                 // Error 
            $response = array( 
                "status"  => false , 
                "message" => $err  
            );
        } 
        else {                      // Success 
            $response = array(
                "status"  => true ,
                "message" => "Payment done! Successfully", 
                'data'    =>  $result ,
            );
        }
    

    } catch (\Exception $e) {

        $response = array(
            "status"  => false , 
            "message" => $e->getMessage(), 
       );
    }

    return response()->json($response, 200);

    }

    
    
}
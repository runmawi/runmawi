<?php

namespace App\Http\Controllers;

use URL;
use Auth;
use Theme;
use Session;
use App\User;
use App\Video;
use App\Series;
use App\Channel;
use App\Setting;
use App\SiteLogs;
use Carbon\Carbon;
use App\LiveStream;
use App\HomeSetting;
use App\PpvPurchase;
use App\LivePurchase;
use App\SeriesSeason;
use App\Subscription;
use Razorpay\Api\Api;
use App\ChannelPayout;
use App\ModeratorsUser;
use App\PaymentSetting;
use App\ModeratorPayout;
use App\VideoCommission;
use App\ThemeIntegration;
use \Redirect as Redirect;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Notification;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Encryption\DecryptException;
use AmrShawky\LaravelCurrency\Facade\Currency as PaymentCurreny;

class RazorpayController extends Controller
{

    public function __construct()
    {
        $PaymentSetting = PaymentSetting::where('payment_type','Razorpay')->first();

        if($PaymentSetting != null){

            if($PaymentSetting->live_mode == 0){
                $this->razorpaykeyId = $PaymentSetting->test_publishable_key;
                $this->razorpaykeysecret = $PaymentSetting->test_secret_key;
            }else{
                $this->razorpaykeyId = $PaymentSetting->live_publishable_key;
                $this->razorpaykeysecret = $PaymentSetting->live_secret_key;
            }
        }else{
            $Error_msg = "Razorpay Key is Missing";
            $url = URL::to('/home');
            echo "<script type='text/javascript'>alert('$Error_msg'); window.location.href = '$url' </script>";
        }

        $this->Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses($this->Theme);
    }

    public function Razorpay(Request $request)
    {
        return Theme::view('Razorpay.create');
    }

    public function Razorpay_authorization_url(Request $request){

        try{

            $Crypt_Razorpay_plan_id = Crypt::encryptString($request->Razorpay_plan_id);
            $authorization_url =  URL::to('RazorpayIntegration/'.$Crypt_Razorpay_plan_id);

            $response = array(
                    'status'           => true ,
                    'message'          => "Authorization url Successfully Created !" , 
                    'Razorpay_plan_id' => $request->Razorpay_plan_id ,
                    'authorization_url' => $authorization_url,
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

    public function RazorpayIntegration(Request $request,$Plan_Id)
    {
        try {

        $Subscription = Subscription::create([
            'user_id'        =>  Auth::user()->id,
            'stripe_plan'    =>  $Plan_Id,   
            'PaymentGateway' =>  'Razorpay',
            'platform'       => 'WebSite',
            'stripe_status'  => 'hold',
        ]);

        $Subscription_primary_id = $Subscription->id;

        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
        $countryName = $geoip->getCountry();
        $regionName = $geoip->getregion();
        $cityName = $geoip->getcity();

        $users_details =Auth::User();

        if($users_details != null){
            $user_details =Auth::User();
            $redirection_back = URL::to('/becomesubscriber'); 
        }else{
            $userEmailId = $request->session()->get('register.email');
            $user_details =User::where('email',$userEmailId)->first();
            $redirection_back = URL::to('/register2'); 
        }

        $plan_Id =Crypt::decryptString($Plan_Id);
        $api    = new Api($this->razorpaykeyId, $this->razorpaykeysecret);
        $planId = $api->plan->fetch($plan_Id);

        $subscription = $api->subscription->create(array(
            'plan_id' =>  $planId->id, 
            'customer_notify' => 1,
            'total_count' => 6, 
        ));

        $respond=array(
            'razorpaykeyId'  =>  $this->razorpaykeyId,
            'name'           =>  $planId['item']->name,
            'subscriptionId' =>  $subscription->id ,
            'short_url'      =>  $subscription->short_url,
            'currency'       =>  'INR',
            'email'          =>  $user_details['email'],
            'contactNumber'  =>  $user_details['mobile'],
            'user_id'        =>  $user_details->id,
            'user_name'      =>  $user_details->name,
            'address'        =>  $cityName,
            'description'    =>  null,
            'countryName'    =>  $countryName,
            'regionName'     =>  $regionName,
            'cityName'       =>  $cityName,
            'PaymentGateway' =>  'razorpay',
            'redirection_back' => $redirection_back ,
            'Subscription_primary_id'  => $Subscription_primary_id
        );

        return Theme::view('Razorpay.checkout',compact('respond'),$respond);

        } catch (\Throwable $th) {
            // dd($th->getMessage());

            return abort(404);
        }
    }

    public function RazorpayCompleted(Request $request)
    {
        $SignatureStatus = $this->RazorpaySignatureVerfiy(
                $request->razorpay_payment_id,
                $request->razorpay_subscription_id,
                $request->razorpay_signature
        );

        if($SignatureStatus == true){
            $userId = $request->user_id;
            $RazorpaySubscription = $request->razorpay_subscription_id;
            $RazorpayPayment_ID = $request->razorpay_payment_id;
            $Subscription_primary_id = $request->Subscription_primary_id;
            return Redirect::route('RazorpaySubscriptionStore',['RazorpaySubscription' => $RazorpaySubscription,'userId' => $userId, 'RazorpayPayment_ID' => $RazorpayPayment_ID, 'Subscription_primary_id' => $Subscription_primary_id ]);     
        }
        else{
            echo 'fails';
        }
    }

    private function RazorpaySignatureVerfiy($razorpay_payment_id,$razorpay_subscription_id,$razorpay_signature)
    {
        try {
            $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);
            $attributes  = array('razorpay_signature'  => $razorpay_signature,  'razorpay_payment_id'  => $razorpay_payment_id ,  'razorpay_subscription_id' => $razorpay_subscription_id);
            $order  = $api->utility->verifyPaymentSignature($attributes);
            return true;

        } catch (\Exception $e) {
            return false;
        }
    }
    
    public function RazorpaySubscriptionStore(Request $request){

        $razorpay_subscription_id = $request->RazorpaySubscription;
        $razorpaypayment_id = $request->RazorpayPayment_ID;

        $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);
        $subscription = $api->subscription->fetch($razorpay_subscription_id);
        $plan_id      = $api->plan->fetch($subscription['plan_id']);
        
        $Sub_Startday  = Carbon::createFromTimestamp($subscription['current_start'])->toDateTimeString(); 
        $Sub_Endday    = Carbon::createFromTimestamp($subscription['current_end'])->toDateTimeString(); 
        $trial_ends_at = Carbon::createFromTimestamp($subscription['current_end'])->toDateTimeString(); 
    
        Subscription::find($request->Subscription_primary_id)->update([
            'user_id'        =>  $request->userId,
            'name'           =>  $plan_id['item']->name,
            // 'days'        =>  $fileName_zip,
            'price'          =>  $plan_id['item']->amount / 100,   // Amount Paise to Rupees
            'stripe_id'      =>  $subscription['id'],
            'stripe_status'  =>  $subscription['status'],
            'stripe_plan'    =>  $subscription['plan_id'],
            'quantity'       =>  $subscription['quantity'],
            'countryname'    =>  $request->countryName,
            'regionname'     =>  $request->cityName,
            'cityname'       =>  $request->regionName,
            'PaymentGateway' =>  'Razorpay',
            'trial_ends_at'  =>  $trial_ends_at,
            'ends_at'        =>  $trial_ends_at,
            'platform'       => 'WebSite',
            'payment_id'     =>  $razorpaypayment_id,
        ]);

        User::where('id',$request->userId)->update([
            'role'                  =>  'subscriber',
            'stripe_id'             =>  $subscription['id'] ,
            'subscription_start'    =>  $Sub_Startday,
            'subscription_ends_at'  =>  $Sub_Endday,
            'payment_gateway'       =>  'Razorpay',
            'payment_type'          =>  'recurring',
            'payment_status'        =>  'active',
        ]);

        return Redirect::route('home');
    }

    public function RazorpaySubscriptionUpdate(Request $request,$planId){

        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
        $countryName = $geoip->getCountry();
        $regionName = $geoip->getregion();
        $cityName = $geoip->getcity();

        $api    = new Api($this->razorpaykeyId, $this->razorpaykeysecret);
        $plan_Id = $api->plan->fetch($planId);
        $user_id =Auth::User()->id;

        $subscriptionId  = Subscription::where('user_id',$user_id)->latest()->pluck('stripe_id')->first();

        $subscription = $api->subscription->fetch($subscriptionId);
        $remaining_count  =  $subscription['remaining_count'] ;

        $Sub_Startday  = Carbon::createFromTimestamp($subscription['current_start'])->toDateTimeString(); 
        $Sub_Endday    = Carbon::createFromTimestamp($subscription['current_end'])->toDateTimeString(); 
        $trial_ends_at = Carbon::createFromTimestamp($subscription['current_end'])->toDateTimeString(); 

        if($subscription->payment_method != "upi"){
            
            $options  = array('plan_id'  =>$plan_Id['id'], 'remaining_count' => $remaining_count );
            $api->subscription->fetch($subscriptionId)->update($options);

            $UpdatedSubscription = $api->subscription->fetch($subscriptionId);
            $updatedPlan         = $api->plan->fetch($UpdatedSubscription['plan_id']);
            if (is_null($subscriptionId)) {
                return false;
            }
            else{
                Subscription::where('user_id',$user_id)->latest()->update([
                    'price'          =>  $updatedPlan['item']->amount,
                    'stripe_id'      =>  $UpdatedSubscription['id'],
                    'stripe_status' =>   $UpdatedSubscription['status'],
                    'stripe_plan'    =>  $UpdatedSubscription['plan_id'],
                    'quantity'       =>  $UpdatedSubscription['quantity'],
                    'countryname'    =>  $countryName,
                    'regionname'     =>  $regionName,
                    'cityname'       =>  $cityName,
                    'trial_ends_at'  =>  $trial_ends_at,
                    'ends_at'        =>  $trial_ends_at,
                    'PaymentGateway' =>  'Razorpay',
                ]);

                User::where('id',$user_id)->update([
                    'role'                  =>  'subscriber',
                    'stripe_id'             =>  $UpdatedSubscription['id'] ,
                    'subscription_start'    =>  $Sub_Startday,
                    'subscription_ends_at'  =>  $Sub_Endday,
                    'payment_gateway'       =>  'Razorpay',
                    'payment_type'          =>  'recurring',
                    'payment_status'        =>  'active',
                ]);
            }
            return Redirect::route('home');
        }
        else{
            return Theme::view('Razorpay.UPI'); 
        }
    }

    public function RazorpayCancelSubscriptions(Request $request)
    {
        try {

            $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);

            $subscriptionId = User::where('id',Auth::user()->id)->where('payment_gateway','Razorpay')->pluck('stripe_id')->first();
            
            $options  = array('cancel_at_cycle_end'  => 0);

            $api->subscription->fetch($subscriptionId)->cancel($options);

            Subscription::where('stripe_id',$subscriptionId)->update([
                'stripe_status' =>  'Cancelled',
            ]);

            User::where('id',Auth::user()->id )->update([
                'payment_status' =>   'Cancel' ,
                'role'            =>  'registered',
            ]);

            $Error_msg = "Subscription has been Cancel Successfully";
            $url = URL::to('/myprofile');
            echo "<script type='text/javascript'>alert('$Error_msg'); window.location.href = '$url' </script>";


        } catch (\Throwable $th) {
            $msg = 'Some Error occuring while Cancelling the Subscription, Please check this query with admin..';
            $url = URL::to('myprofile/');
            echo "<script type='text/javascript'>alert('$msg'); window.location.href = '$url' </script>";
        }
        
    }

    public function RazorpayVideoRent(Request $request,$video_id){

        
        $video = Video::where('id','=',$video_id)->first();
        $amount = $video->ppv_price;

        $setting = Setting::first();    
        $PpvPurchase = PpvPurchase::create([
            'user_id'      => Auth::user()->id,
            'video_id'     => $video_id,
            'total_amount' => $amount ,
            'platform'     =>'website',
            'payment_gateway' => 'razoray',
            'status' => 'hold' ,
        ]);

        $PpvPurchase_id = $PpvPurchase->id;

        if(!empty($video)){
            $moderators_id = $video->user_id;
        }
        $commission_btn = $setting->CPP_Commission_Status;
        $CppUser_details = ModeratorsUser::where('id',$moderators_id)->first();
        $video_commission_percentage = VideoCommission::where('type','Cpp')->pluck('percentage')->first();
        $commission_percentage_value = $video->CPP_commission_percentage;
        if($commission_btn === 0){
            $commission_percentage_value = !empty($CppUser_details->commission_percentage) ? $CppUser_details->commission_percentage : $video_commission_percentage;
        }
        if(!empty($moderators_id)){
            $moderator           =  ModeratorsUser::where('id',$moderators_id)->first();  
            if ($moderator) {
                $percentage = $moderator->commission_percentage ? $moderator->commission_percentage : 0;
            } else {
                $percentage = 0;
            }
            $total_amount        = $video->ppv_price;
            $title               =  $video->title;
            $commssion           =  VideoCommission::where('type','CPP')->first();
            $ppv_price           =  $amount;
            $moderator_commssion =  ($ppv_price * $commission_percentage_value) / 100;
            $admin_commssion     =  $ppv_price - $moderator_commssion;
            $moderator_id        =  $moderators_id;
        }
        else
        {
            $total_amount = $video->ppv_price;
            $title =  $video->title;
            $commssion  =  VideoCommission::where('type','CPP')->first();
            $percentage = null; 
            $ppv_price = $video->ppv_price;
            $admin_commssion =  null;
            $moderator_commssion = null;
            $moderator_id = null;
        }
        $purchase = PpvPurchase::find($PpvPurchase_id );
        $purchase->total_amount = $amount;
        $purchase->moderator_id = $moderators_id;
        $purchase->admin_commssion = $admin_commssion;
        $purchase->moderator_commssion = $moderator_commssion;
        $purchase->ppv_plan = $request->ppv_plan;
        $purchase->save();

        $recept_id = Str::random(10);
        $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);

        $orderData = [
            'receipt'         => $recept_id,
            'amount'          => $amount * 100, 
            'currency'        => 'INR',
            'payment_capture' => 1 ,
            'notes'           => [
                'video_id' => $request->video_id,
                'ppv_plan' => $request->ppv_plan,
                'PpvPurchase_id' => $request->PpvPurchase_id,
                'user_id'  => Auth::user()->id,
            ],
        ];
        
        $razorpayOrder = $api->order->create($orderData);

        $response=array(
            'razorpaykeyId'  =>   $this->razorpaykeyId,
            'name'           =>   Auth::user()->name ? Auth::user()->name : null,
            'user_id'           =>   Auth::user()->id ? Auth::user()->id : null,
            'currency'       =>  'INR',
            'amount'         =>  $amount * 100 ,
            'orderId'        =>  $razorpayOrder['id'],
            'video_id'       =>  $request->video_id,
            'user_id'        =>  Auth::user()->id ,
            'description'    =>   null,
            'address'        =>   null ,
            'Video_slug'     =>  $video->slug ,
            'address'        =>   null ,
            'ppv_plan'       =>   null ,
            'PpvPurchase_id' => $PpvPurchase_id ,
        );

        return Theme::view('Razorpay.video_rent_checkout',compact('response'),$response);
    }

    public function RazorpayVideoRent_Payment(Request $request)
    {
        
       $setting = Setting::first();  
       $ppv_hours = $setting->ppv_hours;
       $d = new \DateTime('now');
       $d->setTimezone(new \DateTimeZone('Asia/Kolkata'));
       $now = $d->format('Y-m-d h:i:s a');
       $time = date('h:i:s', strtotime($now));
       $to_time = date('Y-m-d h:i:s a',strtotime('+'.$ppv_hours.' hour',strtotime($now))); 

        try {
            $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);
            
            $attributes  = array(
                'razorpay_signature'   => $request->rzp_signature,  
                'razorpay_payment_id'  => $request->rzp_paymentid ,  
                'razorpay_order_id'    => $request->rzp_orderid
            );
            $order  = $api->utility->verifyPaymentSignature($attributes);

            $payment = $api->payment->fetch($request->rzp_paymentid);

            if ($payment->status !== 'captured') {
                $payment->capture(['amount' => $payment->amount]);
            } 
            $payment_status = $payment->status; 

            // $video = Video::where('id','=',$request->video_id)->first();

            // if(!empty($video)){
            // $moderators_id = $video->user_id;
            // }

            // $commission_btn = $setting->CPP_Commission_Status;
            // $CppUser_details = ModeratorsUser::where('id',$moderators_id)->first();
            // $video_commission_percentage = VideoCommission::where('type','Cpp')->pluck('percentage')->first();
            // $commission_percentage_value = $video->CPP_commission_percentage;
            
            // if($commission_btn === 0){
            //     $commission_percentage_value = !empty($CppUser_details->commission_percentage) ? $CppUser_details->commission_percentage : $video_commission_percentage;
            // }
            // if(!empty($moderators_id)){
            //     $moderator           =  ModeratorsUser::where('id',$moderators_id)->first();  
            //     if ($moderator) {
            //         $percentage = $moderator->commission_percentage ? $moderator->commission_percentage : 0;
            //     } else {
            //         $percentage = 0;
            //     }
            //     $total_amount        = $video->ppv_price;
            //     $title               =  $video->title;
            //     $commssion           =  VideoCommission::where('type','CPP')->first();
            //     $ppv_price           =  $request->amount/100;
            //     $moderator_commssion =  ($ppv_price * $commission_percentage_value) / 100;
            //     $admin_commssion     =  $ppv_price - $moderator_commssion;
            //     $moderator_id        =  $moderators_id;
            // }
            // else
            // {
            //     $total_amount = $video->ppv_price;
            //     $title =  $video->title;
            //     $commssion  =  VideoCommission::where('type','CPP')->first();
            //     $percentage = null; 
            //     $ppv_price = $video->ppv_price;
            //     $admin_commssion =  null;
            //     $moderator_commssion = null;
            //     $moderator_id = null;
            // }
            
            $purchase = PpvPurchase::find($request->PpvPurchase_id);
            $purchase->user_id = $request->user_id;
            $purchase->video_id = $request->video_id;
            $purchase->total_amount = $request->amount / 100;
            // $purchase->admin_commssion = $admin_commssion;
            // $purchase->moderator_commssion = $moderator_commssion;
            // $purchase->moderator_id = $moderator_id;
            // $purchase->ppv_plan = $request->ppv_plan;
            $purchase->status = $payment_status;
            $purchase->to_time = $to_time;
            $purchase->platform = 'website';
            $purchase->payment_id = $request->rzp_paymentid;
            $purchase->payment_gateway = 'razorpay';
            $purchase->save();

            $respond=array(
                'status'  => 'true',
            );
            SiteLogs::create([
                'level' => 'success,'. $purchase->status,
                'message' => 'Razorpay video rent payment stored successfully!',
                'context' => 'RazorpayVideoRent_Payment'
            ]);
            return view('Razorpay.Rent_message',compact('respond'),$respond);

        } catch (\Exception $e) {

            // dd($e->getMessage());
            $respond=array(
                'status'  => 'false',
            );

            SiteLogs::create([
                'level' => 'fails',
                'message' => $e->getMessage(),
                'context' => 'RazorpayVideoRent_Payment'
            ]);

            return Theme::view('Razorpay.Rent_message',compact('respond'),$respond); 
        }
    }

    public function RazorpayVideoRent_Paymentfailure(Request $request)
    {

        try {
        $validatedData = $request->validate([
            'payment_id' => 'nullable|string',
            'order_id' => 'nullable|string',
            'video_id' => 'nullable|integer',
            'user_id' => 'nullable|integer',
            'amount' => 'nullable|numeric',
            'error_description' => 'nullable|string',
        ]);

        $setting = Setting::first();  
        $ppv_hours = $setting->ppv_hours;
 
        $d = new \DateTime('now');
        $d->setTimezone(new \DateTimeZone('Asia/Kolkata'));
        $now = $d->format('Y-m-d h:i:s a');
        $time = date('h:i:s', strtotime($now));
        $to_time = date('Y-m-d h:i:s a',strtotime('+'.$ppv_hours.' hour',strtotime($now))); 

        $paymentId = $validatedData['payment_id'] ?? $validatedData['order_id'];

        $existingPurchase = PpvPurchase::where('payment_id',  $paymentId)->first();

        if ($existingPurchase) {
            return response()->json(['status' => 'already_logged']);
        }

        $video = Video::where('id','=', $validatedData['video_id'] )->first();

        if(!empty($video)){
        $moderators_id = $video->user_id;
        }

        $commission_btn = $setting->CPP_Commission_Status;
        $CppUser_details = ModeratorsUser::where('id',$moderators_id)->first();
        $video_commission_percentage = VideoCommission::where('type','Cpp')->pluck('percentage')->first();
        $commission_percentage_value = $video->CPP_commission_percentage;

        if($commission_btn === 0){
            $commission_percentage_value = !empty($CppUser_details->commission_percentage) ? $CppUser_details->commission_percentage : $video_commission_percentage;
        }
        if(!empty($moderators_id)){
            $moderator           =  ModeratorsUser::where('id',$moderators_id)->first();  
            if ($moderator) {
                $percentage = $moderator->commission_percentage ? $moderator->commission_percentage : 0;
            } else {
                $percentage = 0;
            }
            $total_amount        = $video->ppv_price;
            $title               =  $video->title;
            $commssion           =  VideoCommission::where('type','CPP')->first();
            $ppv_price           =  $request->amount/100;
            $moderator_commssion =  ($ppv_price * $commission_percentage_value) / 100;
            $admin_commssion     =  $ppv_price - $moderator_commssion;
            $moderator_id        =  $moderators_id;
        }
        else
        {
            $total_amount = $video->ppv_price;
            $title =  $video->title;
            $commssion  =  VideoCommission::where('type','CPP')->first();
            $percentage = null; 
            $ppv_price = $video->ppv_price;
            $admin_commssion =  null;
            $moderator_commssion = null;
            $moderator_id = null;
        }

        $purchase = PpvPurchase::find($request->PpvPurchase_id);
        $purchase->user_id = $validatedData['user_id'];
        $purchase->video_id = $validatedData['video_id'];
        $purchase->total_amount = $validatedData['amount'] / 100;
        $purchase->admin_commssion = $admin_commssion;
        $purchase->moderator_commssion = $moderator_commssion;
        $purchase->status = 'failed';
        $purchase->payment_failure_reason = $validatedData['error_description'] ?? 'Unknown error';
        $purchase->platform = 'website';
        $purchase->to_time = $to_time;
        $purchase->payment_id = $paymentId; 
        $purchase->payment_gateway = 'razorpay';
        $purchase->save();

        SiteLogs::create([
            'level' => 'success',
            'message' => 'Razorpay video rent payment failure stored successfully! '. $paymentId ,
            'context' => 'RazorpayVideoRent_Paymentfailure'
        ]);

        return response()->json(['status' => 'failure_logged']);
    }catch (\Exception $e) {
        SiteLogs::create([
            'level' => 'fails',
            'message' => $e->getMessage(),
            'context' => 'RazorpayVideoRent_Paymentfailure'
        ]);

        return response()->json(['status' => 'error', 'message' => 'An error occurred while processing the payment failure.']);
    }
    }

    public function RazorpayLiveRent(Request $request,$live_id,$amount){

        $PpvPurchase = PpvPurchase::create([
            'user_id'      => Auth::user()->id,
            'live_id'      => $live_id,
            'total_amount' => $amount ,
            'platform'     =>'website',
            'payment_gateway' => 'razoray',
            'status' => 'hold' ,
        ]);

        $livepurchase = LivePurchase::create([
            'user_id'   => Auth::user()->id,
            'video_id'  => $live_id,
            'amount'    => $amount ,
            'platform'  =>'website',
            'payment_gateway' => 'razoray',
            'status' => 0 ,
            'payment_status' => 'hold',
        ]);

        $PpvPurchase_id = $PpvPurchase->id;
        $livepurchase_id = $livepurchase->id;

        $video = LiveStream::where('id','=',$live_id)->first();
        if(!empty($video)){
        $moderators_id = $video->user_id;
        }

        if(!empty($moderators_id)){
            $moderator           =  ModeratorsUser::where('id',$moderators_id)->first();  
            if ($moderator) {
                $percentage = $moderator->commission_percentage ? $moderator->commission_percentage : 0;
            } else {
                $percentage = 0;
            }
            $total_amount        =  $video->ppv_price;
            $title               =  $video->title;
            $commssion           =  VideoCommission::where('type','CPP')->first();
            $ppv_price           =  $video->ppv_price;
            $moderator_commssion =  ($percentage/100) * $ppv_price ;
            $admin_commssion     =  $ppv_price - $moderator_commssion;
            $moderator_id        =  $moderators_id;
        }
        else
        {
            $total_amount   = $video->ppv_price;
            $title          =  $video->title;
            $commssion      =  VideoCommission::where('type','CPP')->first();
            $percentage     = null; 
            $ppv_price       = $video->ppv_price;
            $admin_commssion =  null;
            $moderator_commssion = null;
            $moderator_id = null;
        }
        $purchase = PpvPurchase::find($PpvPurchase_id );
        $purchase->total_amount = $amount;
        $purchase->moderator_id = $moderators_id;
        $purchase->admin_commssion = $admin_commssion;
        $purchase->moderator_commssion = $moderator_commssion;
        $purchase->save();
        $recept_id = Str::random(10);

        $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);

        $orderData = [
            'receipt'         => $recept_id,
            'amount'          => $request->amount * 100, 
            'currency'        => 'INR',
            'payment_capture' => 1 ,
            'notes'           => [
                'live_id' => $request->live_id,
                'user_id'  => Auth::user()->id,
                'ppv_plan' => $request->ppv_plan,
                'PpvPurchase_id' => $PpvPurchase_id,
                'livepurchase_id' => $livepurchase_id,
            ],
        ];

        $live_slug = LiveStream::where('id',$request->live_id)->pluck('slug')->first();
        
        $razorpayOrder = $api->order->create($orderData);   

        $response=array(
            'razorpaykeyId'  =>   $this->razorpaykeyId,
            'name'           =>   Auth::user()->name ? Auth::user()->name : null,
            'currency'       =>  'INR',
            'amount'         =>  $request->amount * 100 ,
            'orderId'        =>  $razorpayOrder['id'],
            'live_id'        =>  $request->live_id,
            'user_id'        =>  Auth::user()->id ,
            'description'    =>   null,
            'address'        =>   null ,
            'live_slug'      =>  $live_slug,
            'PpvPurchase_id' => $PpvPurchase_id,
            'livepurchase_id'   => $livepurchase_id,
        );

        return Theme::view('Razorpay.Live_rent_checkout',compact('response'),$response);
    }

    public function RazorpayLiveRent_Payment(Request $request)
    {

       $setting = Setting::first();  
       $ppv_hours = $setting->ppv_hours;

       $d = new \DateTime('now');
       $d->setTimezone(new \DateTimeZone('Asia/Kolkata'));
       $now = $d->format('Y-m-d h:i:s a');
       $time = date('h:i:s', strtotime($now));
       $to_time = date('Y-m-d h:i:s a',strtotime('+'.$ppv_hours.' hour',strtotime($now)));           

        try {
            $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);
            
            $attributes  = array(
                'razorpay_signature'   => $request->rzp_signature,  
                'razorpay_payment_id'  => $request->rzp_paymentid ,  
                'razorpay_order_id'    => $request->rzp_orderid
            );
            $order  = $api->utility->verifyPaymentSignature($attributes);

            $payment = $api->payment->fetch($request->rzp_paymentid);

            if ($payment->status !== 'captured') {
                $payment->capture(['amount' => $payment->amount]);
            } 
            $payment_status = $payment->status; 

            // $video = LiveStream::where('id','=',$request->live_id)->first();

            // if(!empty($video)){
            // $moderators_id = $video->user_id;
            // }

            // if(!empty($moderators_id)){
            //     $moderator           =  ModeratorsUser::where('id',$moderators_id)->first();  
            //     if ($moderator) {
            //         $percentage = $moderator->commission_percentage ? $moderator->commission_percentage : 0;
            //     } else {
            //         $percentage = 0;
            //     }
            //     $total_amount        =  $video->ppv_price;
            //     $title               =  $video->title;
            //     $commssion           =  VideoCommission::where('type','CPP')->first();
            //     $ppv_price           =  $video->ppv_price;
            //     $moderator_commssion =  ($percentage/100) * $ppv_price ;
            //     $admin_commssion     =  $ppv_price - $moderator_commssion;
            //     $moderator_id        =  $moderators_id;
            // }
            // else
            // {
            //     $total_amount   = $video->ppv_price;
            //     $title          =  $video->title;
            //     $commssion      =  VideoCommission::where('type','CPP')->first();
            //     $percentage     = null; 
            //     $ppv_price       = $video->ppv_price;
            //     $admin_commssion =  null;
            //     $moderator_commssion = null;
            //     $moderator_id = null;
            // }

            $purchase = PpvPurchase::find($request->PpvPurchase_id);
            $purchase->user_id      = $request->user_id ;
            $purchase->live_id     = $request->live_id ;
            $purchase->total_amount = $request->get('amount')/100 ;
            // $purchase->admin_commssion = $admin_commssion;
            // $purchase->moderator_commssion = $moderator_commssion;
            // $purchase->moderator_id = $moderator_id;
            $purchase->status = $payment_status;
            $purchase->to_time = $to_time;
            $purchase->platform = 'website';
            $purchase->payment_id = $request->rzp_paymentid;
            $purchase->payment_gateway= 'razorpay';
            $purchase->save();


            $livepurchase = LivePurchase::find($request->livepurchase_id);
            $livepurchase->user_id = $request->user_id;
            $livepurchase->video_id = $request->live_id;
            $livepurchase->to_time = $to_time;
            $livepurchase->expired_date = $to_time;
            $livepurchase->amount = $request->get('amount')/100 ;
            $livepurchase->status = 1;
            $livepurchase->platform = 'website';
            $livepurchase->payment_gateway = 'razorpay';
            $livepurchase->payment_status = $payment_status;
            $livepurchase->payment_id = $request->rzp_paymentid;
            $livepurchase->save();

            $respond=array(
                'status'  => 'true',
            );
            SiteLogs::create([
                'level' => 'success,'. $purchase->status,
                'message' => 'Razorpay live rent payment stored successfully!',
                'context' => 'RazorpayLiveRent_Payment'
            ]);
        
            return Theme::view('Razorpay.Rent_message',compact('respond'),$respond);

        } catch (\Exception $e) {

            $respond=array(
                'status'  => 'false',
            );

            SiteLogs::create([
                'level' => 'fails',
                'message' => $e->getMessage(),
                'context' => 'RazorpayLiveRent_Payment'
            ]);
            return Theme::view('Razorpay.Rent_message',compact('respond'),$respond); 
        }
    }

    public function RazorpayLiveRent_Paymentfailure(Request $request)
    {
        try {
        $validatedData = $request->validate([
            'payment_id' => 'nullable|string',
            'order_id' => 'nullable|string',
            'live_id' => 'nullable|integer',
            'user_id' => 'nullable|integer',
            'amount' => 'nullable|numeric',
            'error_description' => 'required|string',
        ]);
        $setting = Setting::first();  
        $ppv_hours = $setting->ppv_hours;
 
        $d = new \DateTime('now');
        $d->setTimezone(new \DateTimeZone('Asia/Kolkata'));
        $now = $d->format('Y-m-d h:i:s a');
        $time = date('h:i:s', strtotime($now));
        $to_time = date('Y-m-d h:i:s a',strtotime('+'.$ppv_hours.' hour',strtotime($now)));           
        $paymentId = $validatedData['payment_id'] ?? $validatedData['order_id'];
        $existingPurchase = PpvPurchase::where('payment_id',$paymentId)->first();

        if ($existingPurchase) {
            return response()->json(['status' => 'already_logged']);
        }

        $video = LiveStream::where('id','=', $validatedData['live_id'] )->first();

        if(!empty($video)){
        $moderators_id = $video->user_id;
        }

        $commission_btn = $setting->CPP_Commission_Status;
        $CppUser_details = ModeratorsUser::where('id',$moderators_id)->first();
        $video_commission_percentage = VideoCommission::where('type','Cpp')->pluck('percentage')->first();
        $commission_percentage_value = $video->CPP_commission_percentage;

        if($commission_btn === 0){
            $commission_percentage_value = !empty($CppUser_details->commission_percentage) ? $CppUser_details->commission_percentage : $video_commission_percentage;
        }
        if(!empty($moderators_id)){
            $moderator           =  ModeratorsUser::where('id',$moderators_id)->first();  
            if ($moderator) {
                $percentage = $moderator->commission_percentage ? $moderator->commission_percentage : 0;
            } else {
                $percentage = 0;
            }
            $total_amount        = $video->ppv_price;
            $title               =  $video->title;
            $commssion           =  VideoCommission::where('type','CPP')->first();
            $ppv_price           =  $request->amount/100;
            $moderator_commssion =  ($ppv_price * $commission_percentage_value) / 100;
            $admin_commssion     =  $ppv_price - $moderator_commssion;
            $moderator_id        =  $moderators_id;
        }
        else
        {
            $total_amount = $video->ppv_price;
            $title =  $video->title;
            $commssion  =  VideoCommission::where('type','CPP')->first();
            $percentage = null; 
            $ppv_price = $video->ppv_price;
            $admin_commssion =  null;
            $moderator_commssion = null;
            $moderator_id = null;
        }

        $purchase = PpvPurchase::find($request->PpvPurchase_id);
        $purchase->user_id = $validatedData['user_id'];
        $purchase->live_id = $validatedData['live_id'];
        $purchase->total_amount = $validatedData['amount'] / 100;
        $purchase->admin_commssion = $admin_commssion;
        $purchase->moderator_commssion = $moderator_commssion;
        $purchase->moderator_id = $moderators_id;
        $purchase->status = 'failed';
        $purchase->payment_failure_reason = $validatedData['error_description'];
        $purchase->platform = 'website';
        $purchase->to_time = $to_time;
        $purchase->payment_id = $paymentId;
        $purchase->payment_gateway = 'razorpay';
        $purchase->save();

        SiteLogs::create([
            'level' => 'success',
            'message' => 'Razorpay live rent payment failure stored successfully! '. $paymentId ,
            'context' => 'RazorpayLiveRent_Paymentfailure'
        ]);

        return response()->json(['status' => 'failure_logged']);
    } catch (\Exception $e) {

        
        SiteLogs::create([
            'level' => 'fails',
            'message' => $e->getMessage(),
            'context' => 'RazorpayLiveRent_Paymentfailure'
        ]);
      
        return response()->json(['status' => 'error', 'message' => 'An error occurred while processing the payment failure.']);
    }
    }


    public function RazorpayModeratorPayouts(Request $request){

        $data = $request->all();
        $recept_id = Str::random(10);
        $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);

        $orderData = [
            'receipt'         => $recept_id,
            'amount'          => $request->commission_paid * 100, 
            'currency'        => 'INR',
            'payment_capture' => 1 ,
        ];
        
        $razorpayOrder = $api->order->create($orderData);

        if(!empty($data['id'])){
        $user = ModeratorsUser::where('id',$data['id'])->first();
        $name  = $user->username ;
        }
        $response=array(
            'razorpaykeyId'  =>   $this->razorpaykeyId,
            'name'           =>   $name,
            'currency'       =>  'INR',
            'amount'         =>  $request->commission_paid * 100 ,
            'orderId'        =>  $razorpayOrder['id'],
            'user_id'        =>  $data['id'] ? $data['id'] : null ,
            'phone_number'   =>  $user['upi_mobile_number'] ? $user['upi_mobile_number'] : null ,
            'upi_id'         =>  $user['upi_id'] ? $user['upi_id'] : null ,
            'email'          =>  $user['email'] ? $user['email'] : null ,
            'user'           =>  $user ? $user : null ,
            'name'           =>  $user['username'] ? $user['username'] : null ,
            'description'    =>   null,
            'address'        =>   null ,
            'commission'     =>  $data['commission'] ? $data['commission'] : null ,
            'payment_type'     =>  $data['payment_type'] ? $data['payment_type'] : null ,


        );

        return Theme::view('Razorpay.moderator_payouts',compact('response'),$response);

    }

    public function RazorpayModeratorPayouts_Payment(Request $request)
    {
        $data = $request->all();


       $setting = Setting::first();  

        try {
            $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);
            
            $attributes  = array(
                'razorpay_signature'   => $request->rzp_signature,  
                'razorpay_payment_id'  => $request->rzp_paymentid ,  
                'razorpay_order_id'    => $request->rzp_orderid
            );
            $order  = $api->utility->verifyPaymentSignature($attributes);

            $commission_paid = $data['amount']/100;

            $last_paid_amount = ModeratorPayout::where('user_id',$data['user_id'])->get([
                DB::raw(
                    "sum(moderator_payouts.commission_paid) as commission_paid"
                ) 
            ]);
            if(count($last_paid_amount) > 0){ $last_paid = intval($last_paid_amount[0]->commission_paid) ; }else{ $last_paid = 0; }

        if (
            !empty($data["payment_type"]) &&
            $data["payment_type"] == "Partial_amount"
        ) {

            if ( $data["commission"] != $commission_paid) {

                $paid_amount =   $data["commission"] - $commission_paid - $last_paid ;
            } else {
                $paid_amount = $commission_paid;
            }
        } elseif (
            !empty($data["payment_type"]) &&
            $data["payment_type"] == "full_amount"
        ) {
            if ($commission_paid == $data["commission"]) {
                $paid_amount = $commission_paid;
            } else {
                $paid_amount =  $data["commission"] - $commission_paid - $last_paid;
            }
        }

            // dd($paid_amount);

            $respond=array(
                'status'  => 'true',
            );
        
            $ModeratorPayout = new ModeratorPayout();
            $ModeratorPayout->user_id = $data["user_id"];
            $ModeratorPayout->commission_paid = $commission_paid;
            $ModeratorPayout->commission_pending = $paid_amount;
            $ModeratorPayout->payment_type = $data["payment_type"];
            $ModeratorPayout->save();

            return Theme::view('Razorpay.Payout_message',compact('respond'),$respond);

        } catch (\Exception $e) {

            $respond=array(
                'status'  => 'false',
            );

            return Theme::view('Razorpay.Payout_message',compact('respond'),$respond);
        }
    }


    
    public function RazorpayChannelPayouts(Request $request){

        $data = $request->all();
        // dd($data);
        $recept_id = Str::random(10);
        $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);

        $orderData = [
            'receipt'         => $recept_id,
            'amount'          => $request->commission_paid * 100, 
            'currency'        => 'INR',
            'payment_capture' => 1 ,
        ];
        
        $razorpayOrder = $api->order->create($orderData);

        if(!empty($data['id'])){
        $user = Channel::where('id',$data['id'])->first();
        $name  = $user->channel_name ;
        }
        $response=array(
            'razorpaykeyId'  =>   $this->razorpaykeyId,
            'name'           =>   $name,
            'currency'       =>  'INR',
            'amount'         =>  $request->commission_paid * 100 ,
            'orderId'        =>  $razorpayOrder['id'],
            'user_id'        =>  $data['id'] ? $data['id'] : null ,
            'phone_number'   =>  $user['upi_mobile_number'] ? $user['upi_mobile_number'] : null ,
            'upi_id'         =>  $user['upi_id'] ? $user['upi_id'] : null ,
            'email'          =>  $user['email'] ? $user['email'] : null ,
            'user'           =>  $user ? $user : null ,
            'name'           =>  $user['username'] ? $user['username'] : null ,
            'description'    =>   null,
            'address'        =>   null ,
            'commission'     =>  $data['commission'] ? $data['commission'] : null ,
            'payment_type'     =>  $data['payment_type'] ? $data['payment_type'] : null ,


        );

        return view('Razorpay.channel_payouts',compact('response'),$response);

    }

    public function RazorpayChannelPayouts_Payment(Request $request)
    {
        $data = $request->all();


       $setting = Setting::first();  

        try {
            $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);
            
            $attributes  = array(
                'razorpay_signature'   => $request->rzp_signature,  
                'razorpay_payment_id'  => $request->rzp_paymentid ,  
                'razorpay_order_id'    => $request->rzp_orderid
            );
            $order  = $api->utility->verifyPaymentSignature($attributes);

            $commission_paid = $data['amount']/100;

            $last_paid_amount = ChannelPayout::where('user_id',$data['user_id'])->get([
                DB::raw(
                    "sum(channel_payouts.commission_paid) as commission_paid"
                ) 
            ]);
            if(count($last_paid_amount) > 0){ $last_paid = intval($last_paid_amount[0]->commission_paid) ; }else{ $last_paid = 0; }

        if (
            !empty($data["payment_type"]) &&
            $data["payment_type"] == "Partial_amount"
        ) {

            if ( $data["commission"] != $commission_paid) {

                $paid_amount =   $data["commission"] - $commission_paid - $last_paid ;
            } else {
                $paid_amount = $commission_paid;
            }
        } elseif (
            !empty($data["payment_type"]) &&
            $data["payment_type"] == "full_amount"
        ) {
            if ($commission_paid == $data["commission"]) {
                $paid_amount = $commission_paid;
            } else {
                $paid_amount =  $data["commission"] - $commission_paid - $last_paid;
            }
        }

            // dd($paid_amount);

            $respond=array(
                'status'  => 'true',
            );
        
            $ChannelPayout = new ChannelPayout();
            $ChannelPayout->user_id = $data["user_id"];
            $ChannelPayout->commission_paid = $commission_paid;
            $ChannelPayout->commission_pending = $paid_amount;
            $ChannelPayout->payment_type = $data["payment_type"];
            $ChannelPayout->save();

            return view('Razorpay.Channel_Payout_message',compact('respond'),$respond);

        } catch (\Exception $e) {

            $respond=array(
                'status'  => 'false',
            );

            return view('Razorpay.Channel_Payout_message',compact('respond'),$respond);
        }
    }


    
    public function RazorpayVideoRent_PPV(Request $request,$ppv_plan,$video_id){
        $video = Video::where('id','=',$video_id)->first();
        switch ($ppv_plan) {
            case '240p':
                $amount = $video->ppv_price_240p;
                break;
            case '360p':
                $amount = $video->ppv_price_360p;
                break;
            case '480p':
                $amount = $video->ppv_price_480p;
                break;
            case '720p':
                $amount = $video->ppv_price_720p;
                break;
            case '1080p':
                $amount = $video->ppv_price_1080p;
                break;
            default:
                $amount = $video->ppv_price;
        }
        $PpvPurchase = PpvPurchase::create([
            'user_id'      => Auth::user()->id,
            'video_id'     => $video_id,
            'total_amount' => $amount ,
            'platform'     =>'website',
            'ppv_plan'     => $ppv_plan,
            'payment_gateway' => 'razoray',
            'status' => 'hold' ,
        ]);

        $setting = Setting::first();  
        $PpvPurchase_id = $PpvPurchase->id;

        if(!empty($video)){
            $moderators_id = $video->user_id;
        }
        $commission_btn = $setting->CPP_Commission_Status;
        $CppUser_details = ModeratorsUser::where('id',$moderators_id)->first();
        $video_commission_percentage = VideoCommission::where('type','Cpp')->pluck('percentage')->first();
        $commission_percentage_value = $video->CPP_commission_percentage;
        if($commission_btn === 0){
            $commission_percentage_value = !empty($CppUser_details->commission_percentage) ? $CppUser_details->commission_percentage : $video_commission_percentage;
        }
        if(!empty($moderators_id)){
            $moderator           =  ModeratorsUser::where('id',$moderators_id)->first();  
            if ($moderator) {
                $percentage = $moderator->commission_percentage ? $moderator->commission_percentage : 0;
            } else {
                $percentage = 0;
            }
            $total_amount        = $video->ppv_price;
            $title               =  $video->title;
            $commssion           =  VideoCommission::where('type','CPP')->first();
            $ppv_price           =  $amount;
            $moderator_commssion =  ($ppv_price * $commission_percentage_value) / 100;
            $admin_commssion     =  $ppv_price - $moderator_commssion;
            $moderator_id        =  $moderators_id;
        }
        else
        {
            $total_amount = $video->ppv_price;
            $title =  $video->title;
            $commssion  =  VideoCommission::where('type','CPP')->first();
            $percentage = null; 
            $ppv_price = $video->ppv_price;
            $admin_commssion =  null;
            $moderator_commssion = null;
            $moderator_id = null;
        }

        $purchase = PpvPurchase::find($PpvPurchase_id );
        $purchase->total_amount = $amount;
        $purchase->moderator_id = $moderators_id;
        $purchase->admin_commssion = $admin_commssion;
        $purchase->moderator_commssion = $moderator_commssion;
        $purchase->ppv_plan = $request->ppv_plan;
        $purchase->save();

        $recept_id = Str::random(10);

        $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);

        $orderData = [
            'receipt'         => $recept_id,
            'amount'          => $amount * 100, 
            'currency'        => 'INR',
            'payment_capture' => 1 ,
        ];
        
        $razorpayOrder = $api->order->create($orderData);

        $response=array(
            'razorpaykeyId'  =>   $this->razorpaykeyId,
            'name'           =>   Auth::user()->name ? Auth::user()->name : null,
            'currency'       =>  'INR',
            'amount'         =>  $amount * 100 ,
            'orderId'        =>  $razorpayOrder['id'],
            'video_id'       =>  $request->video_id,
            'user_id'        =>  Auth::user()->id ,
            'description'    =>   null,
            'address'        =>   null ,
            'Video_slug'     =>  $video->slug ,
            'ppv_plan'       => $ppv_plan ,
            'PpvPurchase_id' => $PpvPurchase_id ,
        );

        return Theme::view('Razorpay.video_rent_checkout',compact('response'),$response);
    }


    
    public function RazorpaySeriesSeasonRent(Request $request,$SeriesSeason_id,$amount){

        $PpvPurchase = PpvPurchase::create([
            'user_id'      => Auth::user()->id,
            'season_id'   => $SeriesSeason_id,
            'series_id'   => null,
            'total_amount' => $amount ,
            'platform'     =>'website',
            'ppv_plan'     => null,
            'payment_gateway' => 'razoray',
            'status' => 'hold' ,
        ]);

        $PpvPurchase_id = $PpvPurchase->id;

        $SeriesSeason = SeriesSeason::where('id',$request->SeriesSeason_id)->first();
        $series_id = SeriesSeason::where('id',$request->SeriesSeason_id)->pluck('series_id')->first();
        $Series_slug = Series::where('id',$series_id)->pluck('slug')->first();
        // if(!empty($SeriesSeason)){
        // $moderators_id = Auth::User()->id;
        // }

        $Series = Series::where('id',$series_id)->first();
        if(!empty($Series)){
            $moderators_id = $Series->user_id;
        }
        
        if(!empty($moderators_id)){
            $moderator           =  ModeratorsUser::where('id',$moderators_id)->first();  
            if ($moderator) {
                $percentage = $moderator->commission_percentage ? $moderator->commission_percentage : 0;
            } else {
                $percentage = 0;
            }
            $total_amount        =  $SeriesSeason->ppv_price;
            $title               =  $SeriesSeason->series_seasons_name;
            $commssion           =  VideoCommission::where('type','CPP')->first();
            $ppv_price           =  $SeriesSeason->ppv_price;
            $moderator_commssion =  ($percentage/100) * $ppv_price ;
            $admin_commssion     =  $ppv_price - $moderator_commssion;
            $moderator_id        =  $moderators_id;
        }
        else
        {
            $total_amount = $amount;
            $title =  $SeriesSeason->title;
            $commssion  =  VideoCommission::where('type','CPP')->first();
            $percentage = null; 
            $ppv_price = $amount;
            $admin_commssion =  null;
            $moderator_commssion = null;
            $moderator_id = null;
        }

        $purchase = PpvPurchase::find($PpvPurchase_id );
        $purchase->total_amount = $amount;
        $purchase->moderator_id = $moderators_id;
        $purchase->admin_commssion = $admin_commssion;
        $purchase->moderator_commssion = $moderator_commssion;
        $purchase->save();
        $recept_id = Str::random(10);

        $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);

        $orderData = [
            'receipt'         => $recept_id,
            'amount'          => $request->amount * 100, 
            'currency'        => 'INR',
            'notes'           => [
                'series_id' => $SeriesSeason_id,
                'user_id'  => Auth::user()->id,
                'ppv_plan' => $request->ppv_plan,
            ],
        ];
        
        $razorpayOrder = $api->order->create($orderData);

        $SeriesSeason = SeriesSeason::where('id',$SeriesSeason_id)->first();
        $series_id = SeriesSeason::where('id',$SeriesSeason_id)->pluck('series_id')->first();
        $Series_slug = Series::where('id',$series_id)->pluck('slug')->first();


        $response=array(
            'razorpaykeyId'  =>   $this->razorpaykeyId,
            'name'           =>   Auth::user()->name ? Auth::user()->name : null,
            'currency'       =>  'INR',
            'amount'         =>  $request->amount * 100 ,
            'orderId'        =>  $razorpayOrder['id'],
            'SeriesSeason_id'=>  $request->SeriesSeason_id,
            'user_id'        =>  Auth::user()->id ,
            'description'    =>   null,
            'address'        =>   null ,
            'Series_slug'     => $Series_slug ,
            'address'        =>   null ,
            'ppv_plan'       =>   null ,
            'PpvPurchase_id' => $PpvPurchase_id,
        );

        return Theme::view('Razorpay.SeriesSeason_rent_checkout',compact('response'),$response);
    }

    public function RazorpaySeriesSeasonRent_Payment(Request $request)
    {
       $setting = Setting::first();  
       $ppv_hours = $setting->ppv_hours;

       $d = new \DateTime('now');
       $d->setTimezone(new \DateTimeZone('Asia/Kolkata'));
       $now = $d->format('Y-m-d h:i:s a');
       $time = date('h:i:s', strtotime($now));
       $to_time = date('Y-m-d h:i:s a',strtotime('+'.$ppv_hours.' hour',strtotime($now)));           

        try {
            $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);
            
            $attributes  = array(
                'razorpay_signature'   => $request->rzp_signature,  
                'razorpay_payment_id'  => $request->rzp_paymentid ,  
                'razorpay_order_id'    => $request->rzp_orderid
            );
            $order  = $api->utility->verifyPaymentSignature($attributes);


            $payment = $api->payment->fetch($request->rzp_paymentid);

            if ($payment->status !== 'captured') {
                $payment->capture(['amount' => $payment->amount]);
            } 
            $payment_status = $payment->status; 


            $SeriesSeason = SeriesSeason::where('id',$request->SeriesSeason_id)->first();

            $series_id = SeriesSeason::where('id',$request->SeriesSeason_id)->pluck('series_id')->first();
            $Series_slug = Series::where('id',$series_id)->pluck('slug')->first();

            // if(!empty($SeriesSeason)){
            // $moderators_id = Auth::User()->id;
            // }

            $Series = Series::where('id',$series_id)->first();

            // if(!empty($Series) && $Series->uploaded_by == 'CPP'){
            //     $moderators_id = $Series->user_id;
            // }
            
            // if(!empty($moderators_id)){
            //     $moderator           =  ModeratorsUser::where('id',$moderators_id)->first();  
            //     if ($moderator) {
            //         $percentage = $moderator->commission_percentage ? $moderator->commission_percentage : 0;
            //     } else {
            //         $percentage = 0;
            //     }
            //     $total_amount        =  $SeriesSeason->ppv_price;
            //     $title               =  $SeriesSeason->series_seasons_name;
            //     $commssion           =  VideoCommission::where('type','CPP')->first();
            //     $ppv_price           =  $SeriesSeason->ppv_price;
            //     $moderator_commssion =  ($percentage/100) * $ppv_price ;
            //     $admin_commssion     =  $ppv_price - $moderator_commssion;
            //     $moderator_id        =  $moderators_id;
            // }
            // else
            // {
            //     $total_amount = $request->amount;
            //     $title =  $SeriesSeason->title;
            //     $commssion  =  VideoCommission::where('type','CPP')->first();
            //     $percentage = null; 
            //     $ppv_price = $request->amount;
            //     $admin_commssion =  null;
            //     $moderator_commssion = null;
            //     $moderator_id = null;
            // }

            $purchase = new PpvPurchase;
            $purchase->user_id      = $request->user_id ;
            $purchase->season_id     = $request->SeriesSeason_id ;
            $purchase->series_id    = $series_id ;
            $purchase->total_amount = $request->amount /100 ;
            // $purchase->admin_commssion = $admin_commssion;
            // $purchase->moderator_commssion = $moderator_commssion;
            $purchase->status =  $payment_status;
            $purchase->to_time = $to_time;
            // $purchase->moderator_id = $moderator_id;
            $purchase->platform = 'website';
            $purchase->ppv_plan = $request->ppv_plan;
            $purchase->payment_id = $request->rzp_paymentid;
            $purchase->payment_gateway= 'razorpay';
            $purchase->save();

            $respond=array(
                'status'  => 'true',
            );

            SiteLogs::create([
                'level' => 'success,'. $purchase->status,
                'message' => 'Razorpay SeriesSeason rent payment stored successfully!',
                'context' => 'RazorpaySeriesSeasonRent_Payment'
            ]);
        
        
            return view('Razorpay.Rent_message',compact('respond'),$respond);

        } catch (\Exception $e) {

            $respond=array(
                'status'  => 'false',
            );

            SiteLogs::create([
                'level' => 'fails',
                'message' => $e->getMessage(),
                'context' => 'RazorpaySeriesSeasonRent_Payment'
            ]);
        

            return Theme::view('Razorpay.Rent_message',compact('respond'),$respond); 
        }
    }

    
    public function RazorpaySeriesSeasonRent_Paymentfailure(Request $request)
    {

        try{
        $validatedData = $request->validate([
            'payment_id' => 'nullable|string',
            'order_id' => 'nullable|string',
            'SeriesSeason_id' => 'nullable|integer',
            'season_id' => 'nullable|integer',
            'user_id' => 'nullable|integer',
            'amount' => 'nullable|numeric',
            'error_description' => 'nullable|string',
        ]);

        $setting = Setting::first();  
        $ppv_hours = $setting->ppv_hours;
 
        $d = new \DateTime('now');
        $d->setTimezone(new \DateTimeZone('Asia/Kolkata'));
        $now = $d->format('Y-m-d h:i:s a');
        $time = date('h:i:s', strtotime($now));
        $to_time = date('Y-m-d h:i:s a',strtotime('+'.$ppv_hours.' hour',strtotime($now)));           
        $paymentId = $validatedData['payment_id'] ?? $validatedData['order_id'];

        $existingPurchase = PpvPurchase::where('payment_id', $paymentId)->first();

        if ($existingPurchase) {
            return response()->json(['status' => 'already_logged']);
        }


        $SeriesSeason = SeriesSeason::where('id',$validatedData['SeriesSeason_id'])->first();
        $series_id = SeriesSeason::where('id', $validatedData['SeriesSeason_id'])->pluck('series_id')->first();
        $Series = Series::where('id',$series_id)->first();


        if(!empty($Series && $Series->uploaded_by == 'CPP' )){
        $moderators_id = $Series->user_id;
        }

        $commission_btn = $setting->CPP_Commission_Status;
        $CppUser_details = ModeratorsUser::where('id',$moderators_id)->first();
        $video_commission_percentage = VideoCommission::where('type','Cpp')->pluck('percentage')->first();
        $commission_percentage_value = $video->CPP_commission_percentage;

        if($commission_btn === 0){
            $commission_percentage_value = !empty($CppUser_details->commission_percentage) ? $CppUser_details->commission_percentage : $video_commission_percentage;
        }
        if(!empty($moderators_id)){
            $moderator           =  ModeratorsUser::where('id',$moderators_id)->first();  
            if ($moderator) {
                $percentage = $moderator->commission_percentage ? $moderator->commission_percentage : 0;
            } else {
                $percentage = 0;
            }
            $total_amount        = $SeriesSeason->ppv_price;
            $title               =  $SeriesSeason->series_seasons_name;
            $commssion           =  VideoCommission::where('type','CPP')->first();
            $ppv_price           =  $request->amount/100;
            $moderator_commssion =  ($ppv_price * $commission_percentage_value) / 100;
            $admin_commssion     =  $ppv_price - $moderator_commssion;
            $moderator_id        =  $moderators_id;
        }
        else
        {
            $total_amount        =  $SeriesSeason->ppv_price;
            $title               =  $SeriesSeason->series_seasons_name;
            $commssion           =  VideoCommission::where('type','CPP')->first();
            $percentage          =  null; 
            $ppv_price           =  $SeriesSeason->ppv_price;
            $admin_commssion     =  null;
            $moderator_commssion =  null;
            $moderator_id        =  null;
        }

        $purchase = new PpvPurchase;
        $purchase->user_id = $validatedData['user_id'];
        $purchase->season_id     = $validatedData['SeriesSeason_id'] ;
        $purchase->series_id    = $series_id ;
        $purchase->total_amount = $validatedData['amount'] / 100;
        $purchase->admin_commssion = $admin_commssion;
        $purchase->moderator_commssion = $moderator_commssion;
        $purchase->status = 'failed';
        $purchase->payment_failure_reason = $validatedData['error_description'];
        $purchase->platform = 'website';
        $purchase->to_time = $to_time;
        $purchase->payment_id = $paymentId;
        $purchase->payment_gateway = 'razorpay';
        $purchase->save();

        SiteLogs::create([
            'level' => 'success',
            'message' => 'Razorpay SeriesSeason rent payment failure stored successfully! '. $paymentId ,
            'context' => 'RazorpaySeriesSeasonRent_Paymentfailure'
        ]);


        return response()->json(['status' => 'failure_logged']);

        } catch (\Exception $e) {

        SiteLogs::create([
            'level' => 'fails',
            'message' => $e->getMessage(),
            'context' => 'RazorpaySeriesSeasonRent_Paymentfailure'
        ]);
    
        return response()->json(['status' => 'error', 'message' => 'An error occurred while processing the payment failure.']);
    }

    }

    public function RazorpaySeriesSeasonRent_PPV(Request $request,$ppv_plan,$SeriesSeason_id,$amount){

        PayRequestTransaction::create([
            'user_id'     => Auth::user()->id,
            'ppv_plan'    => $ppv_plan,
            'source_name' => $SeriesSeason_id,
            'source_id'   => $SeriesSeason_id,
            'source_type' => 'series season',
            'platform'    => "razorpay",
            'transform_form' => "PPV",
            'amount' => $amount,
            'date' => Carbon::now()->format('Y-m-d H:i:s a'),
            'status' => 'hold' ,
        ]);

        $recept_id = Str::random(10);

        $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);

        $orderData = [
            'receipt'         => $recept_id,
            'amount'          => $request->amount * 100, 
            'currency'        => 'INR',
            'payment_capture' => 1 ,
        ];
        
        $razorpayOrder = $api->order->create($orderData);

        $SeriesSeason = SeriesSeason::where('id',$SeriesSeason_id)->first();
        $series_id = SeriesSeason::where('id',$SeriesSeason_id)->pluck('series_id')->first();
        $Series_slug = Series::where('id',$series_id)->pluck('slug')->first();


        $response=array(
            'razorpaykeyId'  =>   $this->razorpaykeyId,
            'name'           =>   Auth::user()->name ? Auth::user()->name : null,
            'currency'       =>  'INR',
            'amount'         =>  $request->amount * 100 ,
            'orderId'        =>  $razorpayOrder['id'],
            'SeriesSeason_id'=>  $request->SeriesSeason_id,
            'user_id'        =>  Auth::user()->id ,
            'description'    =>   null,
            'address'        =>   null ,
            'Series_slug'     => $Series_slug ,
            'address'        =>   null ,
            'ppv_plan'       =>   $ppv_plan ,
        );

        return Theme::view('Razorpay.SeriesSeason_rent_checkout',compact('response'),$response);
    }

    public function Razorpay_Missingtransaction()
    {
        $setting = Setting::first();  
        $ppv_hours = $setting->ppv_hours;
        $d = new \DateTime('now');
        $d->setTimezone(new \DateTimeZone('Asia/Kolkata'));
        $now = $d->format('Y-m-d h:i:s a');
        $time = date('h:i:s', strtotime($now));
        $to_time = date('Y-m-d h:i:s a', strtotime('+' . $ppv_hours . ' hour', strtotime($now))); 

        try {
            $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);
            $totalTransactions = 200;
            $transactionsPerRequest = 100;
            $skip = 0; 
            $fetchedTransactions = 0;

            while ($fetchedTransactions < $totalTransactions) {
                $options = [
                    'count' => $transactionsPerRequest,
                    'skip' => $skip,
                ];
                $payments = $api->payment->all($options);
                if (empty($payments['items'])) {
                    break;
                }

                foreach ($payments['items'] as $payment) {
                    $paymentId = $payment['id'];
                    $existingPayment = PpvPurchase::where('payment_id', $paymentId)->first();

                   
                    if (!$existingPayment) {
                        $amount = $payment['amount'] / 100;
                        $status = $payment['status'];
                        $userId = $payment['notes']['user_id'] ?? null;
                        $Ppv_plan = $payment['notes']['ppv_plan'] ?? null;

                        $videoId = $payment['notes']['video_id'] ?? null;
                        $liveId = $payment['notes']['live_id'] ?? null;
                        $audioId = $payment['notes']['audio_id'] ?? null;
                        $movieId = $payment['notes']['movie_id'] ?? null;
                        $seriesId = $payment['notes']['series_id'] ?? null;
                        $seasonId = $payment['notes']['season_id'] ?? null;
                        $episodeId = $payment['notes']['episode_id'] ?? null;

                        $mediaType = null;
                        $mediaId = null;
                       

                        if ($liveId) {
                            $mediaType = 'live';
                            $mediaId = $liveId;
                        } elseif ($videoId) {
                            $mediaType = 'video';
                            $mediaId = $videoId;
                        } elseif ($audioId) {
                            $mediaType = 'audio';
                            $mediaId = $audioId;
                        } elseif ($movieId) {
                            $mediaType = 'movie';
                            $mediaId = $movieId;
                        } elseif ($seriesId) {
                            $mediaType = 'series';
                            $mediaId = $seriesId;
                        } elseif ($seasonId) {
                            $mediaType = 'season';
                            $mediaId = $seasonId;
                        } elseif ($episodeId) {
                            $mediaType = 'episode';
                            $mediaId = $episodeId;
                        }

                        if ($mediaId && $userId) {
                            
                            $purchase = new PpvPurchase();
                            $purchase->user_id = $userId;
                            $purchase->total_amount = $amount;
                            $purchase->status = $status;
                            $purchase->to_time = $to_time;
                            $purchase->platform = 'website';
                            $purchase->payment_id = $paymentId;
                            $purchase->payment_gateway = 'razorpay';
                            $purchase->ppv_plan = $Ppv_plan;
                            if ($mediaType === 'video') {
                                $purchase->video_id = $mediaId;
                            } elseif ($mediaType === 'live') {
                                $purchase->live_id = $mediaId;
                            } elseif ($mediaType === 'audio') {
                                $purchase->audio_id = $mediaId;
                            } elseif ($mediaType === 'movie') {
                                $purchase->movie_id = $mediaId;
                            } elseif ($mediaType === 'series') {
                                $purchase->series_id = $mediaId;
                            } elseif ($mediaType === 'season') {
                                $purchase->season_id = $mediaId;
                            } elseif ($mediaType === 'episode') {
                                $purchase->episode_id = $mediaId;
                            }
                            $moderators_id = null;
                            $moderator_commssion = 0;
                            $admin_commssion = 0;
                            if ($mediaType === 'video' || $mediaType === 'live' || $mediaType === 'series') {
                              
                                if ($mediaType === 'video') {
                                    $video = Video::where('id', $mediaId)->first();
                                    if(!empty($video)){
                                        $moderators_id = $video->user_id;
                                    }
                        
                                    $commission_btn = $setting->CPP_Commission_Status;
                                    $CppUser_details = ModeratorsUser::where('id',$moderators_id)->first();
                                    $video_commission_percentage = VideoCommission::where('type','Cpp')->pluck('percentage')->first();
                                    $commission_percentage_value = $video->CPP_commission_percentage ?? 0;
                                    if($commission_btn === 0){
                                        $commission_percentage_value = !empty($CppUser_details->commission_percentage) ? $CppUser_details->commission_percentage : $video_commission_percentage;
                                    }
                                
                                    if(!empty($moderators_id)){
                                       
                                        $moderator           =  ModeratorsUser::where('id',$moderators_id)->first();  
                                        if ($moderator) {
                                            $percentage = $moderator->commission_percentage ? $moderator->commission_percentage : 0;
                                        } else {
                                            $percentage = 0;
                                        }
                                        $total_amount        = $video->ppv_price ?? 0;
                                        $title               =  $video->title ?? 'unknown title';
                                        $commssion           =  VideoCommission::where('type','CPP')->first();
                                        $ppv_price           =  $amount;
                                        $moderator_commssion =  ($ppv_price * $commission_percentage_value) / 100;
                                        $admin_commssion     =  $ppv_price - $moderator_commssion;
                                        $moderator_id        =  $moderators_id;
                                    }
                                    else
                                    {
                                        $total_amount = $video->ppv_price ?? 0;
                                        $title =  $video->title ?? 'unknown title';
                                        $commssion  =  VideoCommission::where('type','CPP')->first();
                                        $percentage = null; 
                                        $ppv_price = $video->ppv_price ?? 0;
                                        $admin_commssion =  null;
                                        $moderator_commssion = null;
                                        $moderator_id = null;
                                    }
                                    // dd('clear');
                                    $purchase->moderator_id = $moderator_id;
                                    $purchase->admin_commssion = $admin_commssion;
                                    $purchase->moderator_commssion = $moderator_commssion;
                                    $purchase->save();

                                } elseif ($mediaType === 'live') {
                                    $liveStream = LiveStream::where('id', $mediaId)->first();
                                    if(!empty($video)){
                                        $moderators_id = $liveStream->user_id;
                                    }

                                    if(!empty($moderators_id)){
                                        $moderator           =  ModeratorsUser::where('id',$moderators_id)->first();  
                                        if ($moderator) {
                                            $percentage = $moderator->commission_percentage ? $moderator->commission_percentage : 0;
                                        } else {
                                            $percentage = 0;
                                        }
                                        $total_amount        =  $liveStream->ppv_price ?? 0;
                                        $title               =  $liveStream->title ?? 'unknown title';
                                        $commssion           =  VideoCommission::where('type','CPP')->first();
                                        $ppv_price           =  $liveStream->ppv_price ?? 0;
                                        $moderator_commssion =  ($percentage/100) * $ppv_price ;
                                        $admin_commssion     =  $ppv_price - $moderator_commssion;
                                        $moderator_id        =  $moderators_id;
                                    }
                                    else
                                    {
                                        $total_amount   = $liveStream->ppv_price;
                                        $title          =  $liveStream->title;
                                        $commssion      =  VideoCommission::where('type','CPP')->first();
                                        $percentage     = null; 
                                        $ppv_price       = $liveStream->ppv_price;
                                        $admin_commssion =  null;
                                        $moderator_commssion = null;
                                        $moderator_id = null;
                                    }

                                    $purchase->moderator_id = $moderator_id;
                                    $purchase->admin_commssion = $admin_commssion;
                                    $purchase->moderator_commssion = $moderator_commssion;
                                    $purchase->save();

                                } elseif ($mediaType === 'series') {
                                    $SeriesSeason = SeriesSeason::where('id',$mediaId)->first();

                                    $series_id = SeriesSeason::where('id',$mediaId)->pluck('series_id')->first();
                                    $Series_slug = Series::where('id',$series_id)->pluck('slug')->first();
                                    $Series = Series::where('id',$series_id)->first();

                                    if(!empty($Series) && $Series->uploaded_by == 'CPP'){
                                        $moderators_id = $Series->user_id;
                                    }
                                    if(!empty($moderators_id)){
                                        $moderator           =  ModeratorsUser::where('id',$moderators_id)->first();  
                                        if ($moderator) {
                                            $percentage = $moderator->commission_percentage ? $moderator->commission_percentage : 0;
                                        } else {
                                            $percentage = 0;
                                        }
                                        $total_amount        =  $video->ppv_price ?? 0;
                                        $title               =  $video->title ?? 'unknown title';
                                        $commssion           =  VideoCommission::where('type','CPP')->first();
                                        $ppv_price           =  $video->ppv_price?? 0;
                                        $moderator_commssion =  ($percentage/100) * $ppv_price ;
                                        $admin_commssion     =  $ppv_price - $moderator_commssion;
                                        $moderator_id        =  $moderators_id;
                                    }
                                    else
                                    {
                                        $total_amount = $request->amount;
                                        $title =  $SeriesSeason->title;
                                        $commssion  =  VideoCommission::where('type','CPP')->first();
                                        $percentage = null; 
                                        $ppv_price = $amount;
                                        $admin_commssion =  null;
                                        $moderator_commssion = null;
                                        $moderator_id = null;
                                    }
                                    $purchase->moderator_id = $moderator_id;
                                    $purchase->admin_commssion = $admin_commssion;
                                    $purchase->moderator_commssion = $moderator_commssion;
                                    $purchase->save();
                                }
                            } else {
                                \Log::warning("No valid media ID or user ID found for payment ID: " . $paymentId);
                            }
                        } elseif ($existingPayment && $existingPayment->status === 'failed') {
                            $existingPayment->status = $payment['status'];
                            $existingPayment->payment_failure_reason = $payment['error']['description'] ?? 'Unknown error';
                            $existingPayment->save();
                        }
                        $fetchedTransactions++;
                        if ($fetchedTransactions >= $totalTransactions) {
                            break;
                        }
                    }
                    $skip += $transactionsPerRequest;
                }
            }

            return redirect()->route('admin.transaction-details.index');

        } catch (\Exception $e) {
        //    dd($e->getMessage());
            return redirect()->route('admin.transaction-details.index')->with('error', 'An error occurred while processing the transactions.');
        }
    }

}

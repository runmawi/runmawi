<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Notification;
use \Redirect as Redirect;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Session;
use Theme;
use Auth;
use Carbon\Carbon;
use App\Subscription;
use Razorpay\Api\Api;
use App\User;
use App\ThemeIntegration;
use App\PaymentSetting;
use URL;
use App\ModeratorsUser;
use App\VideoCommission;
use App\PpvPurchase;
use App\Video;
use App\Setting;
use App\LivePurchase;
use App\LiveStream;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use AmrShawky\LaravelCurrency\Facade\Currency as PaymentCurreny;
use App\ModeratorPayout;
use App\ChannelPayout;
use App\Channel;
use App\HomeSetting;
use App\SeriesSeason;
use App\Series;


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
        );

        return Theme::view('Razorpay.checkout',compact('respond'),$respond);

        } catch (\Throwable $th) {

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
            return Redirect::route('RazorpaySubscriptionStore',['RazorpaySubscription' => $RazorpaySubscription,'userId' => $userId, 'RazorpayPayment_ID' => $RazorpayPayment_ID, ]);     
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
    
        Subscription::create([
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

    public function RazorpayVideoRent(Request $request,$video_id,$amount){

        $recept_id = Str::random(10);

        $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);

        $orderData = [
            'receipt'         => $recept_id,
            'amount'          => $request->amount * 100, 
            'currency'        => 'INR',
            'payment_capture' => 1 ,
        ];
        
        $razorpayOrder = $api->order->create($orderData);

        $Video_slug = Video::where('id',$request->video_id)->pluck('slug')->first();

        $response=array(
            'razorpaykeyId'  =>   $this->razorpaykeyId,
            'name'           =>   Auth::user()->name ? Auth::user()->name : null,
            'currency'       =>  'INR',
            'amount'         =>  $request->amount * 100 ,
            'orderId'        =>  $razorpayOrder['id'],
            'video_id'       =>  $request->video_id,
            'user_id'        =>  Auth::user()->id ,
            'description'    =>   null,
            'address'        =>   null ,
            'Video_slug'     => $Video_slug ,
            'address'        =>   null ,
            'ppv_plan'       =>   null ,
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


            $video = Video::where('id','=',$request->video_id)->first();

            if(!empty($video)){
            $moderators_id = $video->user_id;
            }

            $commission_btn = $setting->CPP_Commission_Status;
            $CppUser_details = ModeratorsUser::where('id',$moderators_id)->first();
            $video_commission_percentage = VideoCommission::where('type','Cpp')->pluck('percentage')->first();
            $commission_percentage_value = $video->CPP_commission_percentage;
            // dd((600 * $commission_percentage_value)/100);
            
            if($commission_btn === 0){
                $commission_percentage_value = !empty($CppUser_details->commission_percentage) ? $CppUser_details->commission_percentage : $video_commission_percentage;
            }
            if(!empty($moderators_id)){
                $moderator           =  ModeratorsUser::where('id',$moderators_id)->first();  
                $total_amount        = $video->ppv_price;
                $title               =  $video->title;
                $commssion           =  VideoCommission::where('type','CPP')->first();
                $percentage          =  $moderator->commission_percentage; 
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
            // dd($ppv_price);

            $purchase = new PpvPurchase;
            $purchase->user_id      = $request->user_id ;
            $purchase->video_id     = $request->video_id ;
            $purchase->total_amount = $request->amount /100 ;
            $purchase->admin_commssion = $admin_commssion;
            $purchase->moderator_commssion = $moderator_commssion;
            $purchase->status = 'active';
            $purchase->to_time = $to_time;
            $purchase->moderator_id = $moderator_id;
            $purchase->platform = 'website';
            $purchase->ppv_plan = $request->ppv_plan;
            $purchase->payment_id = $request->rzp_paymentid;
            $purchase->payment_gateway= 'Razorpay';
            $purchase->save();

            $respond=array(
                'status'  => 'true',
            );
        
            return view('Razorpay.Rent_message',compact('respond'),$respond);

        } catch (\Exception $e) {

            $respond=array(
                'status'  => 'false',
            );

            return Theme::view('Razorpay.Rent_message',compact('respond'),$respond); 
        }
    }

    public function RazorpayLiveRent(Request $request,$live_id,$amount){

        $recept_id = Str::random(10);

        $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);

        $orderData = [
            'receipt'         => $recept_id,
            'amount'          => $request->amount * 100, 
            'currency'        => 'INR',
            'payment_capture' => 1 ,
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


            $video = LiveStream::where('id','=',$request->live_id)->first();

            if(!empty($video)){
            $moderators_id = $video->user_id;
            }

            if(!empty($moderators_id)){
                $moderator           =  ModeratorsUser::where('id',$moderators_id)->first();  
                $total_amount        =  $video->ppv_price;
                $title               =  $video->title;
                $commssion           =  VideoCommission::where('type','CPP')->first();
                $percentage          =  $moderator->commission_percentage; 
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

            $purchase = new PpvPurchase;
            $purchase->user_id      = $request->user_id ;
            $purchase->live_id     = $request->live_id ;
            $purchase->total_amount = $request->get('amount')/100 ;
            $purchase->admin_commssion = $admin_commssion;
            $purchase->moderator_commssion = $moderator_commssion;
            $purchase->status = 'active';
            $purchase->to_time = $to_time;
            $purchase->moderator_id = $moderator_id;
            $purchase->platform = 'website';
            $purchase->payment_id = $request->rzp_paymentid;
            $purchase->payment_gateway= 'Razorpay';
            $purchase->save();


            $livepurchase = new LivePurchase;
            $livepurchase->user_id = $request->user_id;
            $livepurchase->video_id = $request->live_id;
            $livepurchase->to_time = $to_time;
            $livepurchase->expired_date = $to_time;
            $livepurchase->amount = $request->get('amount')/100 ;
            $livepurchase->status = 1;
            $livepurchase->platform = 'website';
            $livepurchase->save();

            $respond=array(
                'status'  => 'true',
            );
        
            return Theme::view('Razorpay.Rent_message',compact('respond'),$respond);

        } catch (\Exception $e) {

            $respond=array(
                'status'  => 'false',
            );

            return Theme::view('Razorpay.Rent_message',compact('respond'),$respond); 
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


    
    public function RazorpayVideoRent_PPV(Request $request,$ppv_plan,$video_id,$amount){

        $recept_id = Str::random(10);

        $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);

        $orderData = [
            'receipt'         => $recept_id,
            'amount'          => $request->amount * 100, 
            'currency'        => 'INR',
            'payment_capture' => 1 ,
        ];
        
        $razorpayOrder = $api->order->create($orderData);

        $Video_slug = Video::where('id',$request->video_id)->pluck('slug')->first();

        $response=array(
            'razorpaykeyId'  =>   $this->razorpaykeyId,
            'name'           =>   Auth::user()->name ? Auth::user()->name : null,
            'currency'       =>  'INR',
            'amount'         =>  $request->amount * 100 ,
            'orderId'        =>  $razorpayOrder['id'],
            'video_id'       =>  $request->video_id,
            'user_id'        =>  Auth::user()->id ,
            'description'    =>   null,
            'address'        =>   null ,
            'Video_slug'     => $Video_slug ,
            'ppv_plan'       => $ppv_plan ,
        );

        return Theme::view('Razorpay.video_rent_checkout',compact('response'),$response);
    }


    
    public function RazorpaySeriesSeasonRent(Request $request,$SeriesSeason_id,$amount){

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
            'ppv_plan'       =>   null ,
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

            $SeriesSeason = SeriesSeason::where('id',$request->SeriesSeason_id)->first();

            $series_id = SeriesSeason::where('id',$request->SeriesSeason_id)->pluck('series_id')->first();
            $Series_slug = Series::where('id',$series_id)->pluck('slug')->first();

            // if(!empty($SeriesSeason)){
            // $moderators_id = Auth::User()->id;
            // }

            $Series = Series::where('id',$series_id)->first();

            if(!empty($Series) && $Series->uploaded_by == 'CPP'){
                $moderators_id = $Series->user_id;
            }
            
            if(!empty($moderators_id)){
                $moderator           =  ModeratorsUser::where('id',$moderators_id)->first();  
                $total_amount        =  $video->ppv_price;
                $title               =  $video->title;
                $commssion           =  VideoCommission::where('type','CPP')->first();
                $percentage          =  $moderator->commission_percentage; 
                $ppv_price           =  $video->ppv_price;
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
                $ppv_price = $request->amount;
                $admin_commssion =  null;
                $moderator_commssion = null;
                $moderator_id = null;
            }

            $purchase = new PpvPurchase;
            $purchase->user_id      = $request->user_id ;
            $purchase->season_id     = $request->SeriesSeason_id ;
            $purchase->series_id    = $series_id ;
            $purchase->total_amount = $request->amount /100 ;
            $purchase->admin_commssion = $admin_commssion;
            $purchase->moderator_commssion = $moderator_commssion;
            $purchase->status = 'active';
            $purchase->to_time = $to_time;
            $purchase->moderator_id = $moderator_id;
            $purchase->platform = 'website';
            $purchase->ppv_plan = $request->ppv_plan;
            $purchase->payment_id = $request->rzp_paymentid;
            $purchase->payment_gateway= 'Razorpay';
            $purchase->save();

            $respond=array(
                'status'  => 'true',
            );
        
            return view('Razorpay.Rent_message',compact('respond'),$respond);

        } catch (\Exception $e) {

            $respond=array(
                'status'  => 'false',
            );

            return Theme::view('Razorpay.Rent_message',compact('respond'),$respond); 
        }
    }

    public function RazorpaySeriesSeasonRent_PPV(Request $request,$ppv_plan,$SeriesSeason_id,$amount){

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


    
}

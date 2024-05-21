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

class PaystackController extends Controller
{
    public function __construct()
    {
        $this->customer_create_api_url = "https://api.paystack.co/customer";
        $this->Subscription_create_api_url = "https://api.paystack.co/transaction/initialize";
        $this->Subscription_cancel_api_url = "https://api.paystack.co/subscription/disable";


        $PaymentSetting = PaymentSetting::where('payment_type','Paystack')->first();

        if( $PaymentSetting != null ){

            if( $PaymentSetting->paystack_live_mode == 0 ){

                $this->paystack_keyId = getenv('PAYSTACK_PUBLIC_KEY');
                $this->paystack_keysecret =   getenv('PAYSTACK_SECRET_KEY') ;

            }else{

                $this->paystack_keyId = getenv('PAYSTACK_PUBLIC_KEY');
                $this->paystack_keysecret =   getenv('PAYSTACK_SECRET_KEY') ;
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

            $users_details =Auth::User();

            if( $users_details != null ){
                $user_email = User::where('id',Auth::user()->id)->pluck('email')->first();
            }
            else{
                $userEmailId = $request->session()->get('register.email');
                $user_email   = User::where('email',$userEmailId)->pluck('email')->first();
            }
            
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
            session(['paystack_payment_source' => "web" ]);

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
        try {
            
            $Login_agent = new \Jenssegers\Agent\Agent;
            $Check_desktop_login = $Login_agent->isDesktop();
            
            $reference_code = $request->reference ;

                    // Verify Payments API

            $curl = curl_init();
        
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.paystack.co/transaction/verify/".$reference_code,
                CURLOPT_RETURNTRANSFER => true, CURLOPT_ENCODING => "",  CURLOPT_MAXREDIRS => 10, CURLOPT_TIMEOUT => 30, CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET", CURLOPT_HTTPHEADER => $this->SecretKey_array,
            ));

            $reference_respond = curl_exec($curl);
            $reference_error = curl_error($curl);
            curl_close($curl);

            $verify_reference = $reference_error ?  json_decode($reference_respond, true) : json_decode($reference_respond, true) ;

                // Verify Payments Status (false)

            if( $verify_reference['status'] == false ){

                $response = array(
                    'status'=>'false',
                    'message'=> $verify_reference['message'] ,
                );  

                return response()->json($response, 200);
            }

                // Customer Details

            $paystack_customer_id = $verify_reference['data']['customer']['customer_code']  ;
            $customer_details = Paystack::fetchCustomer( $paystack_customer_id );

                // Subscription Details

            $subcription_id = $customer_details['data']['subscriptions'][0]['subscription_code'] ;
            $subcription_details = Paystack::fetchSubscription($subcription_id) ;

            $Sub_Startday  = Carbon::parse($subcription_details['data']['createdAt'])->setTimezone('UTC')->format('d/m/Y H:i:s'); 
            $Sub_Endday    = Carbon::parse($subcription_details['data']['next_payment_date'] )->setTimezone('UTC')->format('d/m/Y H:i:s'); 
            $trial_ends_at = Carbon::parse($subcription_details['data']['next_payment_date'] )->setTimezone('UTC')->toDateTimeString(); 

                // User Id 

            if( $Check_desktop_login == true ){

                $users_details = Auth::User() ;

                if( $users_details != null ){
                    $user_id = Auth::user()->id;
                }
                else{
                    $userEmailId = $request->session()->get('register.email');
                    $user_id   = User::where('email',$userEmailId)->pluck('id')->first();
                }

            }else{
                $user_id = Paystack_Andriod_UserId::pluck('user_id')->first();
            }

                 // Subscription Details - Storing

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
                'platform'       => 'WebSite',
            ]);

            User::where('id',$user_id)->update([
                'role'            =>  'subscriber',
                'stripe_id'       =>  $subcription_details['data']['subscription_code'] ,
                'subscription_start'    =>  $Sub_Startday,
                'subscription_ends_at'  =>  $Sub_Endday,
                'payment_gateway'       =>  'Paystack',
            ]);

            $request->session()->forget('paystack_customer_id');
            $request->session()->forget('paystack_payment_source');
            $request->session()->forget('paystack_Andriod_user_id');

            $response = array(
                'status'=>'true',
                'message'=> $verify_reference['message']  ,
            );  

            
            if( $Check_desktop_login == true ){

                return redirect()->route('home');
            }
            else{
                Paystack_Andriod_UserId::truncate();
                return response()->json( $response, 200 );
            }

        } catch (\Throwable $th) {
            
            $response = array(
                'status'=>'false',
                'message'=> $th->getMessage() ,
            );  

            if( $Check_desktop_login == true ){

                return redirect()->route('home');
            }else{

                Paystack_Andriod_UserId::truncate();
                return response()->json( $response, 200 );
            }
        }
    }

    public function paystack_Andriod_verify_request ( Request $request )
    {
        try {
                // Customer Details

                $paystack_customer_id = $request->paystack_customer_id;
                $customer_details = Paystack::fetchCustomer( $paystack_customer_id );
    
                    // Subscription Details
    
                $subcription_id = $customer_details['data']['subscriptions'][0]['subscription_code'] ;
                $subcription_details = Paystack::fetchSubscription($subcription_id) ;
    
                $Sub_Startday  = Carbon::parse($subcription_details['data']['createdAt'])->setTimezone('UTC')->format('d/m/Y H:i:s'); 
                $Sub_Endday    = Carbon::parse($subcription_details['data']['next_payment_date'] )->setTimezone('UTC')->format('d/m/Y H:i:s'); 
                $trial_ends_at = Carbon::parse($subcription_details['data']['next_payment_date'] )->setTimezone('UTC')->toDateTimeString(); 
    
                    // Subscription Details - Storing
    
                $user_id = $request->user_id;

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
                    'platform'       => 'WebSite',
                ]);
    
                User::where('id',$user_id)->update([
                    'role'                 =>  'subscriber',
                    'stripe_id'            =>  $subcription_details['data']['subscription_code'] ,
                    'subscription_start'   =>  $Sub_Startday,
                    'subscription_ends_at' =>  $Sub_Endday,
                    'payment_gateway'      =>  'Paystack',
                ]);

                $response = array(
                    'status'=>'true',
                    'message'=>'Paystack Payment ! Verify & Subscription data stored Sucessfully '
                );  

        } catch (\Throwable $th) {

                $response = array(
                    'status'=>'false',
                    'message'=> $th
                );  
        }

        return response()->json($response, 200);
    }

    public function paystack_Subscription_update( Request $request )
    {
        //
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

    public function Paystack_Video_Rent(Request $request,$video_id,$amount)
    {
        $email = User::where('id',Auth::user()->id)->pluck('email')->first();

        $access_code = Str::random(15);

        $video_slug = Video::where('id',$video_id)->pluck('slug')->first();

        $data = array(
                'amount' => $amount * 100 ,
                'email'  => $email ,
                'publish_key'  =>  $this->paystack_keyId,
                'access_code'  => $access_code ,
                'redirect_url' => URL::to('category/videos'.'/'.$video_slug),
                'Video_id'     =>  $video_id ,
        );
        return view('Paystack.video_rent_checkout',$data);
    }

    public function Paystack_Video_Rent_Paymentverify ( Request $request )
    {
        // try {

            $setting = Setting::first();  
            $ppv_hours = $setting->ppv_hours;
     
            $d = new \DateTime('now');
            $now = $d->format('Y-m-d h:i:s a');
            $time = date('h:i:s', strtotime($now));
            $to_time = date('Y-m-d h:i:s a',strtotime('+'.$ppv_hours.' hour',strtotime($now)));       

                 // Verify Payment

            $reference_code = $request->reference_code;

            $curl = curl_init();
            
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.paystack.co/transaction/verify/$reference_code",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => $this->SecretKey_array,
            ));
            
            $result = curl_exec($curl);
            $payment_result = json_decode($result, true);
            $err = curl_error($curl);
            curl_close($curl);

                                // Store data

            $video = Video::where('id','=',$request->video_id)->first();

            if(!empty($video)){
                 $moderators_id = $video->user_id;
            }

            if(!empty($moderators_id)){
                $moderator = ModeratorsUser::where('id','=',$moderators_id)->first();  
                $total_amount = $video->ppv_price;
                $title =  $video->title;
                $commssion = VideoCommission::first();
                $percentage = $commssion->percentage; 
                $ppv_price = $video->ppv_price;
                $admin_commssion = ($percentage/100) * $ppv_price ;
                $moderator_commssion = $ppv_price - $percentage;
                $moderator_id = $moderators_id;
            }
            else
            {
                $total_amount = $video->ppv_price;
                $title =  $video->title;
                $commssion = VideoCommission::first();
                $percentage = null; 
                $ppv_price = $video->ppv_price;
                $admin_commssion =  null;
                $moderator_commssion = null;
                $moderator_id = null;
            }

            $purchase = new PpvPurchase;
            $purchase->user_id      = Auth::user()->id ;
            $purchase->video_id     = $request->video_id ;
            $purchase->total_amount = $payment_result['data']['amount'] ;
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

        // } catch (\Exception $e) {

        //     $response = array(
        //          "status"  => false , 
        //          "message" => $e->getMessage(), 
        //     );

        // }

        return response()->json($response, 200);
    }

    public function Paystack_live_Rent(Request $request,$live_id,$amount)
    {
        $email = User::where('id',Auth::user()->id)->pluck('email')->first();

        $access_code = Str::random(15);

        $data = array(
                'amount' => $amount * 100 ,
                'email'  => $email ,
                'publish_key'  =>  $this->paystack_keyId,
                'access_code'  => $access_code ,
                'redirect_url' => URL::to('live/Rent_Payment_Live'),
                'live_id'     =>  $live_id ,
        );

        return view('Paystack.live_rent_checkout',$data);
    }

    public function Paystack_live_Rent_Paymentverify( Request $request )
    {
        try {

            $setting = Setting::first();  
            $ppv_hours = $setting->ppv_hours;

            $to_time = ppv_expirytime_started(); 
            
                 // Verify Payment

            $reference_code = $request->reference_code;

            $curl = curl_init();
            
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.paystack.co/transaction/verify/$reference_code",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => $this->SecretKey_array,
            ));
            
            $result = curl_exec($curl);
            $payment_result = json_decode($result, true);
            $err = curl_error($curl);
            curl_close($curl);

            $video = LiveStream::where('id','=',$request->live_id)->first();

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
            $purchase->live_id       = $request->live_id ;
            $purchase->total_amount  = $payment_result['data']['amount'] ; 
            $purchase->admin_commssion = $admin_commssion;
            $purchase->moderator_commssion = $moderator_commssion;
            $purchase->status = 'active';
            $purchase->to_time = $to_time;
            $purchase->moderator_id = $moderator_id;
            $purchase->save();

            $livepurchase = new LivePurchase;
            $livepurchase->user_id =  Auth::user()->id ;
            $livepurchase->video_id = $request->live_id;
            $livepurchase->to_time = $to_time;
            $livepurchase->expired_date = $to_time;
            $livepurchase->amount =  $payment_result['data']['amount'] ;
            $livepurchase->from_time = Carbon::now()->format('Y-m-d H:i:s');
            $livepurchase->unseen_expiry_date = ppv_expirytime_notstarted();
            $livepurchase->status = 1;
            $livepurchase->save();

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
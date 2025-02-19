<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect,Response,Stripe;
use App\Setting as Setting;
use App\PpvPurchase as PpvPurchase;
use App\Plan as Plan;
use App\PaypalPlan as PaypalPlan;
use Carbon\Carbon;
use Auth;
use DB;
use Mail;
use Crypt;
use URL;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Image;
use Illuminate\Support\Facades\Notification;
use Laravel\Cashier\Exceptions\IncompletePayment;
use App\EmailTemplate;
use App\PaymentSetting;
use App\Subscription;
use App\SubscriptionPlan;
use App\HomeSetting;
use Session;
use Theme;
use App\SiteTheme;
use App\AdminOTPCredentials;

class SignupController extends Controller
{
    
    use RegistersUsers;
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    public function index1()
    {
        $user = Auth::user();
        if (Auth::user()->stripe_id == NULL)
        {
          $stripeCustomer = $user->createAsStripeCustomer();

      }
      return view('stripe', [
        'intent' => $user->createSetupIntent()
    ]);

  }
   /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upgrade(Request $request) {
        
        $uid = Auth::user();
        $user = User::where('id',$uid)->first();
        if ($user->stripe_id == NULL)
        {
            $stripeCustomer = $user->createAsStripeCustomer();
        }

        return view('register.upgrade', [
            'intent' => $user->createSetupIntent()
            ,compact('register')
        ]);
    }

    public function EmailValidation(Request $request) {
      $email = $request->get('email');
        
        $user = User::where('email',$email)->first();

        if( $user == null){
              $message = "true";
        }
        else{
          $message = "false";
        }
        return $message;

    }

    public function UsernameValidation(Request $request)
    {
        $username = $request->get('username');
        
        $user = User::where('username',$username)->first();

        if( $user == null){
              $message = "true";
        }
        else{
          $message = "false";
        }
        return $message;
    }
    
    
    
         public function saveSubscription(Request $request) {
        
               $user_email = Auth::user()->email;
                $user = User::where('email',$user_email)->first();

                $paymentMethod = $request->get('py_id');
                $plan = $request->get('plan');
                $plandetail = SubscriptionPlan::where('plans_name',$plan)->first();
                $stripe_plan = SubscriptionPlan();
                $paymentMethods = $user->paymentMethods();

                $user->newSubscription($stripe_plan, $plan)->create($paymentMethod);

                $input['role'] = 'subscriber';
                $user->update($input);    
                $response = array(
                    'status' => 'success'
                );
                return response()->json($response);
    }
    
    
    public function store123(Request $request)
    {
       
        $setting = Setting::first();   
        $user = Auth::user();
        $user_id = Auth::user()->id;
        $paymentMethod = $request->get('py_id');
        $paymentMethods = $user->paymentMethods();
        //print_r($paymentMethod);exit;
        $user->newSubscription('default', 'monthly')->create($paymentMethod);
    }
    
    public function index(Request $request)
    {
        $request->session()->forget('register');

        $products = \App\Register::all();

        return view('register.index',compact('products'));
    }

    public function createStep1(Request $request)
    {
        $Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses($Theme);
      
            $Artists = \App\Artist::get();
            $SiteTheme = SiteTheme::first();
            $City = \App\City::get();
            $State = \App\State::get();
            $AllCountry = \App\AllCountry::get();
            $AllCity = \App\AllCities::get();
            $AllState = \App\AllStates::get();
            // dd($SiteTheme->signup_theme);
            $signup_status = FreeRegistration();
//            if ( $signup_status == 1 ) {
//                return redirect('/signup');
//            }

        $request->validate([
            'honeypot' => 'max:0', // Ensure the honeypot field is empty
        ]);

            if ($request->has('ref')) {
                session(['referrer' => $request->query('ref')]);
            }
            $register = $request->session()->get('register');
            $settings = \App\Setting::first();
            if($SiteTheme->signup_theme == 0){
                if($settings->free_registration == 1) {
                    return Theme::view('register.step1',compact('register','Artists','State','City','AllCountry','AllCity','AllState'));
                } else {
                    return Theme::view('register.step1',compact('register','Artists','State','City','AllCountry','AllCity','AllState'));
                }
        }elseif($SiteTheme->signup_theme == 1){

            $SignupMenu = \App\SignupMenu::first();
            $data = array(
                'SignupMenu' => $SignupMenu,
                'register' => $register,
                'admin_user' => Auth::user(),
                'Artists' => $Artists,
                'City' => \App\City::get(),
                'State' => \App\State::orderBy('name', 'asc')->get(),
                'AllCountry' => \App\AllCountry::get(),
                'AllCity' => \App\AllCities::get(),
                'AllState' => \App\AllStates::get(),
                'AllState' => \App\AllStates::get(),
                'AdminOTPCredentials' =>  AdminOTPCredentials::where('status',1)->first(),
            );

            if($settings->free_registration == 1) {
                return Theme::view('register.signup_step1',$data);
            } else {
                return Theme::view('register.signup_step1',$data);
            }

        }
    }
    
    public function directVerify(Request $request){
      $activation_code = $request->post('activation_code');
      $mobile = $request->post('mobile');
      $user = User::where('mobile',"=", $mobile)
                      ->update(['otp' => "1234"]);
      $fetch_user = User::where('mobile',"=", $mobile)->first();
        // $user = User::where('activation_code', '=', $activation_code)->first();
        // $fetch_user = User::where('activation_code', '=', $activation_code)->first();
      if (!empty($user)) {
        if($activation_code == $fetch_user->otp){
            $mobile = $fetch_user->mobile;
            $email = $fetch_user->email;
            $password = $fetch_user->password;            
              if (Auth::attempt(['email' => $email, 'otp' => $activation_code])) {
                  return redirect('/home');
              }
          } else {
             return redirect('/mobileLogin')->with('message', 'Invalid OTP.');
        }
      } else {
        return redirect('/mobileLogin')->with('message', 'Invalid mobile number.');
      }
       
    }
    
    public function Verify($activation_code){
        $user = User::where('activation_code', '=', $activation_code)->first();
        $fetch_user = User::where('activation_code', '=', $activation_code)->first();
        if($user){
            $user = User::where('activation_code', $activation_code)
                      ->update(['activation_code' => null,'active' => 1]);

            $mobile = $fetch_user->mobile;
            session()->put('register.email',$fetch_user->email);
              return redirect('/register2')->with('message', 'You have successfully verified your account. Please login below.');
          } else {
            // print_r('expression');
            // exit;
             return redirect('/')->with('message', 'Invalid Activation.');
        }
       
    }

    public function PostcreateStep1(Request $request)
    {
//        echo "asd";
//        exit;
        
        if ($request->has('ref')) {
            session(['referrer' => $request->query('ref')]);
        }
        
        $ref = Request::get('ref');

        $validatedData = $request->validate([
            'username' =>  ['required', 'string'],
            'email' =>  ['required', 'string', 'email', 'unique:users'],
            'password' => 'required|string|min:6|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'mobile' => ['required', 'numeric', 'min:8', 'unique:users'],
            'password_confirmation' => 'required',
        ]);
        
    $free_registration = FreeRegistration();
    $email = $request->session()->get('register.email');
    $name = $request->session()->get('register.username');
    $ccode_session = $request->get('ccode');
    $ccode = $request->session()->put('ccode', $ccode_session);
    $mobile_session = $request->get('mobile');
    $mobiles = $request->session()->put('mobile',$mobile_session); 
    $get_mobile = $request->session()->get('mobile');
    
    $get_password = $request->get('password');
    $password = $request->session()->put('password', $get_password);
    $get_password = $request->session()->get('password');
    $path = public_path().'/uploads/avatars/';    
    $logo = $request->file('avatar');
    
    if($logo != '') {   
                  //code for remove old file
      if($logo != ''  && $logo != null){
       $file_old = $path.$logo;
       if (file_exists($file_old)){
           unlink($file_old);
       }
   }
                  //upload new file
   $file = $logo;
   $avatar  = $file->getClientOriginalName();
   $file->move($path, $avatar);

} else {
 $avatar  = 'default.png';
} 


if(empty($request->session()->get('register'))){
    
    $register = new \App\User();
    $register->fill($validatedData);
    $request->session()->put('register', $register);
    $email = $request->session()->get('register.email');
    $name = $request->session()->get('register.username');
    $password = $request->session()->get('register.password');
    $avatars = $request->session()->put('avatar',$avatar);
    
    $ccode_session = $request->get('ccode');
    $ccode = $request->session()->put('ccode', $ccode_session);
    $get_ccode = $request->session()->get('ccode');
    $mobile_session = $request->get('mobile');
    $mobiles = $request->session()->put('mobile',$mobile_session); 
    $get_mobile = $get_ccode.$request->session()->get('mobile');
    $avatars = $request->session()->put('avatar',$avatar);
    
    
    
} else {

         $register = $request->session()->get('register');
         $register->fill($validatedData);
         $request->session()->put('register', $register);
         $email = $request->session()->get('register.email');
         $name = $request->session()->get('register.username');
         $password = $request->session()->get('password');
         $avatars = $request->session()->put('avatar',$avatar);
         $ccode_session = $request->get('ccode');
         $ccode = $request->session()->put('ccode', $ccode_session);
         $get_ccode = $request->session()->get('ccode');
         $mobile_session = $request->get('mobile');
         $mobiles = $request->session()->put('mobile',$mobile_session); 
         $get_mobile = $request->session()->get('mobile');
         $ccode = $get_ccode;
         $user_email = User::where('email',$email)->count();
                    //$epass = Hash::make($password2); 

     if ($user_email == 0) {
      User::create([
        'name' => $name,
        'username' => $name,
        'mobile' => $get_mobile,
        'ccode' => $ccode,
        'avatar' => $avatars,
        'role' => 'registered',
        'email' => $email,
        'password' => $get_password,
    ]);
    }
    }

if ($free_registration == 1) {
    if (Auth::attempt(['email' => $email, 'password' => $password])) {
        return redirect('/');
    }
} 

else {
 if ($request->has('ref')) {
                           //session(['referrer' => $request->query('ref')]);
  return redirect('/register2?ref='.$request->query('ref').'&coupon='.$request->query('coupon'));
}
else {
                        // return redirect('/register2');
 return redirect('/register2');
}

}
}


    public function SaveAsRegisterUser(Request $request)
            {
             $register = session()->get('register');
             $email = session()->get('register.email');
              $user_email = User::where('email',$email)->count();
              $user = User::where('email',$email)->first();
              $password2 = $user->password;
        
                if (Auth::attempt(['email' => $email, 'password' => $password2])) {
                    return redirect('/login');
                }
                return redirect('/login');
            }





public function createStep2(Request $request)
    {
        $Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses($Theme);

        $signup_checkout = SiteTheme::pluck('signup_theme')->first();

        $profile_checkout = SiteTheme::pluck('profile_checkout')->first();  // Note - for Nemisha

        $free_registration = Setting::pluck('free_registration')->first();  // Note - Free Registration 
        
        $website_name = Setting::pluck('website_name')->first();  // Note - Free Registration 

        if(@$free_registration == 1) {

            session()->put('message',"You have successfully registered for $website_name. Welcome to a world of endless entertainment.");

            $user_mail = session()->get('register.email');

            $user = User::where("email",$user_mail)->pluck('id')->first();

            Auth::loginUsingId($user);

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

            return redirect( $redirection_url );
          
            // return Theme::view('auth.login');
        }

            if ($request->has('ref')) {
                session(['referrer' => $request->query('ref')]);
            }
    
            // $plans = DB::table('subscription_plans')->select('plans_name')->distinct()->get();
            // $plans = SubscriptionPlan::distinct('plans_name')->get();
            $plans = SubscriptionPlan::get();
            $plans_data = $plans->groupBy('plans_name');
            // dd($data);
            $user_mail = session()->get('register.email');
            $user_count = User::where("email","=",$user_mail)->where("active","=",1)->count();

            $plans_data_signup_checkout = SubscriptionPlan::where('type','Stripe')->groupBy('plans_name')->get();


            if ($user_count == 0 ) {
                  return redirect('/')->with('message', 'You have successfully verified your account. Please login below.');
            }elseif(!isset($user_mail)){
                 return redirect('/')->with('message', 'You have successfully verified your account. Please login below.');
            }else{
                $register = $request->session()->get('register');

                if($profile_checkout == 1 ){                    // Note - for Nemisha

                    $user = User::where("email","=",$user_mail)->pluck('id')->first();

                    Auth::loginUsingId($user);

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

                    return redirect( $redirection_url );
                }
                elseif($signup_checkout == 1){

                    $intent_stripe = User::where("email","=",$user_mail)->first();
                    $intent_key =  $intent_stripe->createSetupIntent()->client_secret ;
                    session()->put('intent_stripe_key',$intent_key);
                    session()->put('message',"You have successfully registered for $website_name. Welcome to a world of endless entertainment. 🎉");


                    return Theme::view('register.step2_payment', compact(['register', 'plans_data', 'plans_data_signup_checkout','user_mail','intent_stripe']));

                }
                
                else{
                    return Theme::view('register.step2', compact(['register', 'plans_data']));
                }
            }
    }

    // public function PostcardcreateStep2(Request $request)
    // {
    //    $validatedData = $request->validate([
    //     'modal_plan_name' => 'required',
    //     'modal_plan_name' => 'required'
    //     ]);
    //     // print_r($request['plan_name']);
    //     // exit();
    
    //        $request->session()->put('planname', $request['plan_name']);
    //        $register = $request->session()->get('register');
    //                //$register->fill($validatedData);
    //        $plan_name = $request->get('register.email');
    //        if ($request->has('ref')) {
    //         session(['referrer' => $request->query('ref')]);
    //     }
    //     $data = array(
    //         'plan_name' => $request['plan_name'], 
    // );
    
    // return \View::make('register.card-step', $data);
    //     if ($request->has('ref')) {
    //                                //session(['referrer' => $request->query('ref')]);
    //       return redirect('/register3?ref='.$request->query('ref').'&coupon='.$request->query('coupon'));
    //     }
    //     else {
    //      return redirect('/register3');
    //     }
    // }

public function PostcreateStep2(Request $request)
{

   $validatedData = $request->validate([
    // 'modal_plan_name' => 'required',

    ]);
    // SELECT * FROM `subscription_plans` WHERE plans_name = 'Monthly' AND type = 'Stripe';

    // print_r($request['plan_name']);

    if($request->payment_method == "Stripe"){
    $plans = SubscriptionPlan::where('plans_name','=',$request->modal_plan_name)->where('type','=',$request->payment_method)->first();

       $request->session()->put('planname', $request->modal_plan_name);
       $request->session()->put('plan_id', $plans->plan_id);
       $request->session()->put('payment_type', $plans->payment_type);
       $register = $request->session()->get('register');
               //$register->fill($validatedData);
       $plan_name = $request->get('register.email');
       if ($request->has('ref')) {
        session(['referrer' => $request->query('ref')]);
    }

    if ($request->has('ref')) {
                               //session(['referrer' => $request->query('ref')]);
      return redirect('/register3?ref='.$request->query('ref').'&coupon='.$request->query('coupon'));
    }
    else {
     return redirect('/register3');
    }
}elseif($request->payment_method == "PayPal"){
    $plans = SubscriptionPlan::where('plans_name','=',$request->modal_plan_name)->where('type','=',$request->payment_method)->first();
    
    $request->session()->put('planname', $request->modal_plan_name);
    $request->session()->put('plan_id', $plans->plan_id);
    $request->session()->put('payment_type', $plans->payment_type);
    $request->session()->put('days', $plans->days);
    $request->session()->put('price', $plans->price);
    $request->session()->put('user_id', $plans->user_id);

    $register = $request->session()->get('register');
            //$register->fill($validatedData);
    $plan_name = $request->get('register.email');
    if ($request->has('ref')) {
     session(['referrer' => $request->query('ref')]);
 }
 $data = array(
    'plans' => $plans,
 );

 if ($request->has('ref')) {
                            //session(['referrer' => $request->query('ref')]);
//    return redirect('/register3?ref='.$request->query('ref').'&coupon='.$request->query('coupon'));
return redirect('/subscribe/paypal');

 }
 else {
        return redirect('/subscribe/paypal');
 }
}
elseif($request->payment_method == "Razorpay"){

            $plans = SubscriptionPlan::where('plans_name', '=', $request->modal_plan_name)
                ->where('type', '=', $request->payment_method)
                ->first();

            $PlanId =Crypt::encryptString($plans->plan_id);

            return Redirect::route('RazorpayIntegration',$PlanId);
}
}
    
    


public function createStep3(Request $request)
{  
    
    if ($request->has('ref')) {
        session(['referrer' => $request->query('ref')]);
    }
    
    $uemail = $request->session()->get('register.email');
    $uname = $request->session()->get('register.username');
    $upassword = $request->session()->get('password');
    $avatars = $request->session()->get('avatar');
    $ccode = $request->session()->get('ccode');

    if ($avatars!=='') {
        $avatar = $request->session()->get('avatar');
    } else {
        $avatar  = 'default.png'; 
    }
    
             //$mobiles = $request->session()->put('mobile',$mobile_session); 
    $get_mobile = $request->session()->get('mobile');
              //  $ccode = $get_ccode;
             $user = User::where('email',$uemail)->first();
             if ($user->stripe_id == NULL)
             {
              $stripeCustomer = $user->createAsStripeCustomer();

            }
           return view('register.step3', [
                        'intent' => $user->createSetupIntent()
                        
                    ]);
            }


    public function PaymentFailed(Request $request)
    {
        $user_email = $request->session()->get('register.email');
        $user = User::where("email","=",$user_email)->first();
        $plans = SubscriptionPlan::where("plan_id","=",$request->plan_data)->first();
        $user_id = $user->id;
        $name = $user->username; 
        $price = $plans->price;
        $plan = $plans->plans_name;
        $error = $request->error;
        $error_message = $error['message'];

        $template = EmailTemplate::where('id','=',6)->first(); 
        $heading =$template->heading; 

        try {
            Mail::send('emails.paymentfailed', array(
                /* 'activation_code', $user->activation_code,*/
                'name'=>$user->username,
                'price' => $price,
                'plan' => $plan,
                'heading'=> $template->heading,
                'error'=> $error,
                ), function($message) use ($request,$user,$heading) {
                $message->from(AdminMail(),GetWebsiteName());
                $message->to($request->session()->get('register.email'), $user->username)->subject($heading);
                 });
        } catch (\Throwable $th) {
            //throw $th;
        }
       
         $response = array(
            'status' => 'success'
            );
            return response()->json($response);   
    }  

public function PostcreateStep3(Request $request)
{
    try {
           
        
        if ($request->has('ref')) {
            session(['referrer' => $request->query('ref')]);
        }

        $avatars = $request->session()->get('avatar');

        $avatar = $avatars!=='' ?  $request->session()->get('avatar') : 'default.png' ;

        $settings = $settings = \App\Setting::first();
       
        $email_subject = EmailTemplate::where('id',23)->pluck('heading')->first() ;

        $current_date = date('Y-m-d h:i:s');    
      
        $user_email = $request->session()->get('register.email');
        $user = User::where('email',$user_email)->first();
        $paymentMethod = $request->get('py_id');
        $plan = $request->get('plan');
        $paymentMethods = $user->paymentMethods();
        $apply_coupon = $request->get('coupon_code') ?  $request->get('coupon_code') : null ;
        $stripe_plan = SubscriptionPlan();
        $plandetail = SubscriptionPlan::where('plan_id','=',$plan)->first();
        $payment_type = $plandetail->payment_type;


        if ( $payment_type == "recurring") {

            $user_email = $request->session()->get('register.email');
            $user = User::where('email',$user_email)->first();
            $paymentMethod = $request->get('py_id');
            $plan = $request->get('plan');
            $paymentMethods = $user->paymentMethods();
            $apply_coupon = $request->get('coupon_code') ?  $request->get('coupon_code') : null ;
            $stripe_plan = SubscriptionPlan();
            $plandetail = SubscriptionPlan::where('plan_id',$plan)->first();
            
            if ( NewSubscriptionCoupon() == 1 ) {     

                try {

                    if( subscription_trails_status() == 1 ){
                        $subscription_details =  $user->newSubscription( $stripe_plan, $plan )->trialUntil( subscription_trails_day() )->withCoupon( $apply_coupon )->create( $paymentMethod );
                    }
                    else{
                        $subscription_details = $user->newSubscription( $stripe_plan, $plan )->withCoupon( $apply_coupon )->create( $paymentMethod );
                    }

                    $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
                    $customer_data = $stripe->invoices->upcoming([
                                    'customer' => $user->stripe_id ,
                    ]);

                    $subscription = $stripe->subscriptions->retrieve( $subscription_details->stripe_id );

                    if(subscription_trails_status() == 1 ){

                        $subscription_days_count = $subscription['plan']['interval_count'];
                
                        switch ($subscription['plan']['interval']) {
              
                          case 'day':
                            break;
      
                          case 'week':
                            $subscription_days_count *= 7;
                          break;
      
                          case 'month':
                            $subscription_days_count *= 30;
                          break;
      
                          case 'year':
                            $subscription_days_count *= 365;
                          break;
                        }
              
                        $nextPaymentAttemptDate =  Carbon::createFromTimeStamp($subscription['current_period_end'])->addDays($subscription_days_count)->toDateTimeString()  ;

                    }else{

                        $nextPaymentAttemptDate =  Carbon::createFromTimeStamp($subscription['current_period_end'])->toDateTimeString()  ;
                      
                    }
                    
                    $user->role = 'subscriber';
                    $user->payment_type = 'recurring';
                    $user->card_type = 'stripe';
                    $user->active = 1;
                    $user->subscription_start = Carbon::now(); 
                    $user->subscription_ends_at = $nextPaymentAttemptDate; 
                    $user->payment_status = 'active'; 

                    if( subscription_trails_status()  == 1 ){
                        $user->Subscription_trail_status =  1 ; 
                        $user->Subscription_trail_tilldate   = subscription_trails_day(); 
                    }

                    $user->save();

                } catch (IncompletePayment $exception) {
                    
                    return redirect()->route(
                        'cashier.payment',
                        [$exception->payment->id, 'redirect' => route('home')]
                    );
                }

                try {

                    \Mail::send('emails.subscriptionmail', array(
                        'name' => ucwords($user->username),
                        'uname' => $user->username,
                        'paymentMethod' => $paymentMethod,
                        'plan' => ucfirst($plandetail->plans_name),
                        'price' => $plandetail->price,
                        'plan_id' => $plandetail->plan_id,
                        'billing_interval' => $plandetail->billing_interval,
                        'next_billing' => $nextPaymentAttemptDate,
                        'subscription_type' => 'recurring',

                    ), function($message) use ($request,$user,$email_subject){
                        $message->from(AdminMail(),GetWebsiteName());
                        $message->to($request->session()->get('register.email'), $user->username)->subject($email_subject);
                    });

                    $email_log      = 'Mail Sent Successfully from Register Subscription';
                    $email_template = "23";
                    $user_id = $user->id;
        
                    Email_sent_log($user_id,$email_log,$email_template);

                } catch (\Throwable $th) {

                    $email_log      = $th->getMessage();
                    $email_template = "23";
                    $user_id = $user->id;
       
                    Email_notsent_log($user_id,$email_log,$email_template);
                }
            } 
            else {
                    
                    try {

                        if( subscription_trails_status() == 1 ){
                            
                            $user->newSubscription( $stripe_plan, $plan )->trialUntil( subscription_trails_day() )->withCoupon( $apply_coupon )->create( $paymentMethod );
                        }
                        else{
                            $user->newSubscription( $stripe_plan, $plan )->withCoupon( $apply_coupon )->create( $paymentMethod );
                        }

                        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
                        $customer_data = $stripe->invoices->upcoming([
                                       'customer' => $user->stripe_id ,
                        ]);

                        $subscription = $stripe->subscriptions->retrieve( $subscription_details->stripe_id );

                        if( subscription_trails_status() == 1 ){
    
                            $subscription_days_count = $subscription['plan']['interval_count'];
                    
                            switch ($subscription['plan']['interval']) {
                  
                              case 'day':
                                break;
          
                              case 'week':
                                $subscription_days_count *= 7;
                              break;
          
                              case 'month':
                                $subscription_days_count *= 30;
                              break;
          
                              case 'year':
                                $subscription_days_count *= 365;
                              break;
                            }
                  
                            $nextPaymentAttemptDate =  Carbon::createFromTimeStamp($subscription['current_period_end'])->addDays($subscription_days_count)->toDateTimeString()  ;
    
                        }else{
    
                            $nextPaymentAttemptDate =  Carbon::createFromTimeStamp($subscription['current_period_end'])->toDateTimeString()  ;
                          
                        }

                    } catch (IncompletePayment $exception) {
                        return redirect()->route(
                            'cashier.payment',
                            [$exception->payment->id, 'redirect' => route('home')]
                        );
                    }

                    try {


                        \Mail::send('emails.subscriptionmail', array(
                            'name' => ucwords($user->username),
                            'uname' => $user->username,
                            'paymentMethod' => $paymentMethod,
                            'plan' => ucfirst($plandetail->plans_name),
                            'price' => $plandetail->price,
                            'plan_id' => $plandetail->plan_id,
                            'billing_interval' => $plandetail->billing_interval,
                            'next_billing' => $nextPaymentAttemptDate,
                            'subscription_type' => 'recurring',

                        ), function($message) use ($request,$user,$email_subject){
                            $message->from(AdminMail(),GetWebsiteName());
                            $message->to($request->session()->get('register.email'), $user->username)->subject($email_subject);
                        });

                        $email_log      = 'Mail Sent Successfully from Register Subscription-23';
                        $email_template = "23";
                        $user_id = $user->id;
            
                        Email_sent_log($user_id,$email_log,$email_template);

                    } catch (\Throwable $th) {

                         $email_log      = $th->getMessage();
                         $email_template = "23";
                         $user_id = $user->id;
            
                         Email_notsent_log($user_id,$email_log,$email_template);
                    }
                    
                    
                    $user->role = "subscriber";
                    $user->payment_type = "recurring";
                    $user->card_type = "stripe";
                    $user->active = 1;
                    $user->avatar = $avatar;
                    $user->subscription_start = Carbon::now(); 
                    $user->subscription_ends_at = $nextPaymentAttemptDate; 
                    $user->payment_status = 'active'; 

                    if( subscription_trails_status()  == 1 ){
                        $user->Subscription_trail_status =  1 ; 
                        $user->Subscription_trail_tilldate   = subscription_trails_day(); 
                    }

                    $user->save();

                    $next_date = $plandetail->days;
                    $date = Carbon::parse($current_date)->addDays($next_date);

                    $subscription = Subscription::where('user_id',$user->id)->first();
                    $subscription->price = $plandetail->price;
                    $subscription->name = $user->username;
                    $subscription->days = $plandetail->days;
                    $subscription->regionname = Region_name();
                    $subscription->countryname = Country_name();
                    $subscription->cityname = city_name();
                    $subscription->PaymentGateway =  'Stripe';
                    $subscription->ends_at = $nextPaymentAttemptDate;
                    $subscription->platform = 'WebSite';
                    $subscription->save();

                    $data = Session::all();
            }
        } 
        elseif( $payment_type == "one_time" ) {

                $current_date = date('Y-m-d h:i:s');    
                $setting = Setting::first();
                $ppv_hours = $setting->ppv_hours;
                $user_email = $request->session()->get('register.email');
                $user = User::where("email","=",$user_email)->first();
                $user_id = $user->id;
                $price = $request->amount;
                $plan = $request->plan;              
                $plan_details = SubscriptionPlan::where("plan_id","=",$plan)->first();
                $next_date = $plan_details->days;
                $date = Carbon::parse($current_date)->addDays($next_date);
                $sub_price = $plan_details->price;
                $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
                $sub_total = $sub_price - DiscountPercentage();
                    if ( NewSubscriptionCoupon() == 1 ) {
                            $stripe->charges->create([
                                'amount' =>  $sub_total * 100,
                                'currency' => 'USD',
                                'source' => $request->stripToken,
                                'description' => 'New Subscription using One Time subscription method',
                                ]);    
                            $user = User::find($user_id);
                            $user->role = "subscriber";
                            $user->payment_type = "one_time";
                            $user->card_type = "stripe";
                            $user->payment_status = 'active'; 
                            $user->save();
                            DB::table('single_subscriptions')->insert([
                                    ['user_id' => $user_id, 'plan_id' => $plan, 'days' => $plan_details->days, 'price' => $plan_details->price, 'to_date' => $date,'from_date' => $current_date,'status' => 'active']
                                ]);
                } else {
                    $stripe->charges->create([
                            'amount' =>  $sub_price * 100,
                            'currency' => 'USD',
                            'source' => $request->stripToken,
                            'description' => 'New Subscription using One Time subscription method',
                            ]);    
                            $user = User::find($user_id);
                            $user->role = "subscriber";
                            $user->payment_type = "one_time";
                            $user->card_type ="stripe";
                            $user->payment_status = 'active'; 
                            $user->save();
                            DB::table('single_subscriptions')->insert([
                                ['user_id' => $user_id, 'plan_id' => $plan, 'days' => $plan_details->days, 'price' => $plan_details->price, 'to_date' => $date,'from_date' => $current_date,'status' => 'active']
                            ]);
            }

        }
                $response = array(
                    'status' => 'success',
                    "message" => 'Your Payment done Successfully!',
                );

    } catch (\Throwable $th) {
                  $response = array(
                    'status' => 'false',
                    "message" => $th->getMessage(),
                );
    }

    return response()->json($response);

    }

    protected function registered(Request $request, $user)
    {
        if ($user->referrer !== null) {
            Notification::send($user->referrer, new ReferrerBonus($user));
        }

        return redirect($this->redirectPath());
    }  

    public function PayWithPapal(Request $request)
        {
        
            $plan_id = $request->get('name');
                $plan_details = SubscriptionPlan::where('plan_id','=',$plan_id)->first();
                $data = array(
                        'plan_name' => $plan_details->name,
                        'plan_price' => $plan_details->price,
                        'plan_id' => $plan_details->plan_id
                    );
            
            return view('register.paypal',$data);
        }
    
    public function submitpaypal(Request $request)
        {
            $register = $request->session()->get('register');
            $email = $request->session()->get('register.email');
            $user_email = User::where('email','=',$email)->count();
            $user_first = User::where('email','=',$email)->first();
            $id = $user_first->id;  
            $plandetail = SubscriptionPlan::where('plan_id','=',$request->plan_id)->first();
            $payment_type = $plandetail->payment_type;

            if ( $user_email > 0 ) {
            // $subIds = $request->get('subId'); 
            $current_date = date('Y-m-d h:i:s');
            $next_date = $plandetail->days;
            $date = Carbon::parse($current_date)->addDays($next_date);

            $subscription = Subscription::where('user_id',$user_first->id)->first();
            
            $subscription = new Subscription;
            $subscription->price = $plandetail->price;
            $subscription->name = $user_first->username;
            $subscription->days = $plandetail->days;
            $subscription->user_id =  $id;
            $subscription->stripe_id = $request->plan_id;
            $subscription->stripe_status  = 'active';
            $subscription->stripe_plan = $request->plan_id;
            $subscription->regionname = Region_name();
            $subscription->countryname = Country_name();
            $subscription->cityname = city_name();
            $subscription->PaymentGateway =  'paypal';
            $subscription->ends_at = $date;
            $subscription->platform = 'WebSite';
            $subscription->save();

                $subId = $request->subId;        
                $new_user = User::find($id);
                $new_user->role = 'subscriber';
                $new_user->paypal_id = $subId;
                $new_user->payment_type ='paypal';
                $new_user->save();
                $response = array(
                    'status' => 'success'
                );
            } else {
                $response = array(
                    'status' => 'failed'
                );
            }
        return response()->json($response);
    }   
    public function subscribepaypal(Request $request)
        {
                $user_email = Auth::user()->email;
                $subId = $request->get('subId');
                $user = User::where('email',$user_email)->first();
                $user->role = 'subscriber';
                $user->active = 1;
                $user->paypal_id = $subId;
                $user->save();
                $response = array(
                      'status' => 'success'
                );
                return response()->json($response);
        }
    
    

    public function stripesubscription(Request $request){
            //$user = Auth::User();
    
            print_r("asdasd");
            exit;
             if ($user->stripe_id == NULL)
             {
              $stripeCustomer = $user->createAsStripeCustomer();

             }
            $data = array(
                "plan_name" => "plan"
            );
            return view('register.become', [
                                'intent' => $user->createSetupIntent()
                                ,$data
            ]);
}
    
    
    public function CancelSubscription()
        {
              echo "kljl";  
        }

    public function SignupMobile_val(Request $request)
        {
            $mobile_No = User::where('mobile',$request->mobile)->first();

            if( $mobile_No == null){
                  $message = "true";
            }
            else{
              $message = "false";
            }
            return $message;
        }

        // old saveSubscription function for first time

// public function PostcreateStep3old(Request $request)
//     {
//       if ($request->has('ref')) {
//             session(['referrer' => $request->query('ref')]);
//         }
//         $avatars = $request->session()->get('avatar');
//         if ($avatars!=='') {
//             $avatar = $request->session()->get('avatar');
//         } else {
//             $avatar  = 'default.png'; 
//         }
//          $settings = $settings = \App\Setting::first();/*Setting::first()*/
//        /* if (!$settings->free_registration && $skip == 0) {
//             $user_data['role'] = 'subscriber';
//             $user_data['active'] = '1';
//         } else {
//                 if($settings->activation_email):
//                     $user_data['activation_code'] = Str::random(60);
//                     $user_data['active'] = 0;
//                 endif;
//             $user_data['role'] = 'registered';
//         }*/
//                 $current_date = date('Y-m-d h:i:s');    
       
//         $payment_type = $request->payment_type;
//         $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
//         $userIp = $geoip->getip();    
//         $countryName = $geoip->getCountry();
//         $regionName = $geoip->getregion();
//         $cityName = $geoip->getcity();

//     // print_r($payment_type);exit();
//         if ( $payment_type == "one_time") {
//                         $user_email = $request->session()->get('register.email');
//                         $user = User::where('email',$user_email)->first();
//                         $paymentMethod = $request->get('py_id');
//                         $plan = $request->get('plan');
//                         $paymentMethods = $user->paymentMethods();
//                         $apply_coupon = NewSubscriptionCouponCode();
//                         $stripe_plan = SubscriptionPlan();
//                         $plandetail = SubscriptionPlan::where('plan_id',$plan)->first();
//                         if ( NewSubscriptionCoupon() == 1 ) {                      
//                             try {
//                                  $user->newSubscription($stripe_plan, $plan)->withCoupon($apply_coupon)->create($paymentMethod);
//                                  $user->role = 'subscriber';
//                                  $user->payment_type = 'recurring';
//                                  $user->card_type = 'stripe';
//                                  $user->active = 1;
//                                  $user->save();

//                             } catch (IncompletePayment $exception) {
                                
//                                 return redirect()->route(
//                                     'cashier.payment',
//                                     [$exception->payment->id, 'redirect' => route('home')]
//                                 );
//                             }

                           
//                         \Mail::send('emails.subscriptionmail', array(
//                           /*'activation_code', $user->activation_code,*/
//                             'name' => $user->username,
//                             'paymentMethod' => $paymentMethod,
//                             'plan' => ucfirst($plandetail->plans_name),
//                             'price' => $plandetail->price,
//                             'billing_interval' => $plandetail->billing_interval,
//                             /*'next_billing' => $nextPaymentAttemptDate,*/
//                         ), function($message) use ($request,$user){
//                             $message->from(AdminMail(),'Flicknexs');
//                             $message->to($request->session()->get('register.email'), $user->username)->subject($request->get('subject'));
//                         });
                         

//                     } else {
                       
//                         try {
//                             $user->newSubscription($stripe_plan, $plan)->create($paymentMethod);
//                         } catch (IncompletePayment $exception) {
//                             return redirect()->route(
//                                 'cashier.payment',
//                                 [$exception->payment->id, 'redirect' => route('home')]
//                             );
//                         }
//                         \Mail::send('emails.subscriptionmail', array(
//                            /* 'activation_code', $user->activation_code,*/
//                             'name' => $user->username,
//                             'paymentMethod' => $paymentMethod,
//                             'plan' => ucfirst($plandetail->plans_name),
//                             'price' => $plandetail->price,
//                             'billing_interval' => $plandetail->billing_interval,
//                                                 //    'next_billing' => $nextPaymentAttemptDate,
//                         ), function($message) use ($request,$user){
//                             $message->from(AdminMail(),'Flicknexs');
//                             $message->to($request->session()->get('register.email'), $user->username)->subject($request->get('subject'));
//                         });
//                         $user->role = "subscriber";
//                         $user->payment_type = "recurring";
//                         $user->card_type = "stripe";
//                         $user->active = 1;
//                         $user->avatar = $avatar;
//                         $user->save();
//                     }
//              } else {
//                         $user_email = $request->session()->get('register.email');
//                         $user = User::where('email',$user_email)->first();
//                         $paymentMethod = $request->get('py_id');
//                         $plan = $request->get('plan');
//                         $paymentMethods = $user->paymentMethods();
//                         $apply_coupon = NewSubscriptionCouponCode();
//                         $stripe_plan = SubscriptionPlan();
//                         $plandetail = SubscriptionPlan::where('plan_id','=',$plan)->first();
//                         // $plandetail = Plan::where('plan_id',$plan)->first();
//                 try {
//                     $user->newSubscription($stripe_plan, $plan)->withCoupon($apply_coupon)->create($paymentMethod);
//                     $user->role = 'subscriber';
//                     $user->payment_type = 'recurring';
//                     $user->card_type = 'stripe';
//                     $user->active = 1;
//                     $user->save();
//                     $next_date = $plandetail->days;
//                     $date = Carbon::parse($current_date)->addDays($next_date);
//                     $subscription = Subscription::where('user_id',$user->id)->first();
//                     $subscription->price = $plandetail->price;
//                     $subscription->name = $user->username;
//                     $subscription->days = $plandetail->days;
//                     $subscription->regionname = $regionName;
//                     $subscription->countryname = $countryName;
//                     $subscription->cityname = $cityName;
//                     $subscription->ends_at = $date;
//                     $subscription->save();
//                     $data = Session::all();
//                     // if (empty($data['password_hash'])) {
//                     // }else{
//                     //     if(Auth::user()->role == 'subscriber'){
//                     //     $subscription = Subscription::where('user_id',Auth::user()->id)->first();
//                     //     $subscription->price = $plandetail->price;
//                     //     $subscription->save();
//                     //     }else{

//                     //     }
//                     // }

//                } catch (IncompletePayment $exception) {
                   
//                    return redirect()->route(
//                        'cashier.payment',
//                        [$exception->payment->id, 'redirect' => route('home')]
//                    );
//                }

              
//            \Mail::send('emails.subscriptionmail', array(
//              /*'activation_code', $user->activation_code,*/
//                'name' => $user->username,
//                'uname' => $user->username,
//                'paymentMethod' => $paymentMethod,
//                'plan' => ucfirst($plandetail->plans_name),
//                'price' => $plandetail->price,
//                'plan_id' => $plandetail->plan_id,
//                'billing_interval' => $plandetail->billing_interval,
//                /*'next_billing' => $nextPaymentAttemptDate,*/
//            ), function($message) use ($request,$user){
//                $message->from(AdminMail(),'Flicknexs');
//                $message->to($request->session()->get('register.email'), $user->username)->subject($request->get('subject'));
//            });
                
//         //         $length = 10;
//         // $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
//         // $ref_token = substr(str_shuffle(str_repeat($pool, 5)), 0, $length);  
//         // $token = substr(str_shuffle(str_repeat($pool, 5)), 0, $length); 
//         // if (!empty($request->token)){
//         //     $user_data['token'] =  $request->token;
//         // } else {
//         // $user_data['token'] =  '';
//         // }
//         //         $current_date = date('Y-m-d h:i:s');    
//         //         $setting = Setting::first();
//         //         $ppv_hours = $setting->ppv_hours;
//         //         $user_email = $request->session()->get('register.email');
//         //         $user = User::where("email","=",$user_email)->first();
//         //         $user_id = $user->id;
//         //         $price = $request->amount;
//         //         $paymentMethod = $request->get('py_id');
//         //         $plan = $request->get('plan');
//         //         $paymentMethods = $user->paymentMethods();
//         //         $apply_coupon = NewSubscriptionCouponCode();
//         //         $stripe_plan = SubscriptionPlan();
//         //         $plandetail = Plan::where('plan_id',"=",$plan)->first();          
//         //         $plan_details = Plan::where("plan_id","=",$plan)->first();
//         //         $next_date = $plan_details->days;
//         //         $date = Carbon::parse($current_date)->addDays($next_date);
//         //         $sub_price = $plan_details->price;
//         //         //$stripe = new \Stripe\StripeClient('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');
//         //         $payment_settings = PaymentSetting::first();
//         //         $mode = $payment_settings->live_mode ;
//         //         if($mode == 0){
//         //             $test_secret_key = $payment_settings->test_secret_key ;
//         //             $test_publishable_key = $payment_settings->test_publishable_key ;
//         //         }elseif($mode == 1){
//         //             $live_secret_key = $payment_settings->live_secret_key ;
//         //             $live_publishable_key = $payment_settings->live_publishable_key ;
//         //         }else{
//         //             $test_secret_key= null;
//         //             $test_publishable_key= null;
//         //             $live_secret_key= null;
//         //             $live_publishable_key= null;
//         //         }
//         //         $stripe = new \Stripe\StripeClient($test_publishable_key);
//         //         $sub_total = $sub_price - DiscountPercentage();
//         //             if ( NewSubscriptionCoupon() == 1 ) {
//         //                     $stripe->charges->create([
//         //                           'amount' =>  $sub_total * 100,
//         //                           'currency' => 'USD',
//         //                           'source' => $request->stripToken,
//         //                           /*'source' => 'tok_visa',*/
//         //                           'description' => 'New Subscription using One Time subscription method'
//         //                         ]);    
//         //                     $user = User::find($user_id);
//         //                     $user->role = "subscriber";
//         //                     $user->payment_type = "one_time";
//         //                     $user->card_type = "stripe";
//         //                     $user->save();
//         //                     $email = $user_email;
//         //                     $uname = $user->username;
//         //                         DB::table('subscriptions')->insert([
//         //                         ['user_id' => $user_id, 'stripe_id'=>$user->stripe_id, 'stripe_plan'=>$plan,'name'=>$user->username, 'days' => $plan_details->days, 'price' => $plan_details->price, 'ends_at' => $date,'created_at' => $current_date,'stripe_status' => 'active']
//         //                     ]);

                            

//         //                   Mail::send('emails.subscriptionmail', array(
//         //                   /* 'activation_code', $user->activation_code,*/
//         //                     'name'=>$user->username, 
//         //                   'days' => $plan_details->days, 
//         //                   'price' => $plan_details->price, 
//         //                   'ends_at' => $date,
//         //                   'uname' => $uname,
//         //                   'created_at' => $current_date), function($message) use ($request,$user) {
//         //                                         $message->from(AdminMail(),'Flicknexs');
//         //                                          $message->to($request->session()->get('register.email'), $user->username)->subject($request->get('subject'));
//         //                                     });

//         //                                    }     else {
//         //              $stripe->charges->create([
//         //                       'amount' =>  $sub_price * 100,
//         //                       'currency' => 'USD',
//         //                       'source' => $request->stripToken,
//         //                      /* 'source' => 'tok_visa',*/
//         //                       'description' => 'New Subscription using One Time subscription method',
//         //                     ]);    
//         //                     $user = User::find($user_id);
//         //                     $user->role = "subscriber";
//         //                     $user->payment_type = "one_time";
//         //                     $user->card_type ="stripe";
//         //                     $user->save();
//         //                     $email = $user_email;
//         //                     $uname = $user->username;
//         //                     DB::table('subscriptions')->insert([
//         //                         ['user_id' => $user_id, 'stripe_id'=>$user->stripe_id, 'stripe_plan'=>$plan,'name'=>$user->username, 'days' => $plan_details->days, 'price' => $plan_details->price, 'ends_at' => $date,'created_at' => $current_date,'stripe_status' => 'active']
//         //                     ]);
//         //                       Mail::send('emails.subscriptionmail', array(
//         //                        /* 'activation_code', $user->activation_code,*/
//         //                         'name'=>$user->username, 
//         //                   'days' => $plan_details->days, 
//         //                   'price' => $plan_details->price, 
//         //                   'ends_at' => $date,
//         //                   'uname' => $uname,

//         //                   'created_at' => $current_date), function($message) use ($request,$user) {
//         //                                         $message->from(AdminMail(),'Flicknexs');
//         //                                          $message->to($request->session()->get('register.email'), $user->username)->subject($request->get('subject'));
//         //                                     });
//         //      }
            
//              }
//                 $response = array(
//                   'status' => 'success'
//                 );
//                 return response()->json($response);
//        /* if ($request->has('ref')) {
//             session(['referrer' => $request->query('ref')]);
//         }
//         $avatars = $request->session()->get('avatar');
//         if ($avatars!=='') {
//             $avatar = $request->session()->get('avatar');
//         } else {
//             $avatar  = 'default.png'; 
//         }
        
//         $user_email = $request->session()->get('register.email');
//         $user = User::where('email',$user_email)->first();
//         $paymentMethod = $request->get('py_id');
//         $plan = $request->get('plans_name');
//         $paymentMethods = $user->paymentMethods();
//         $apply_coupon = NewSubscriptionCouponCode();
//         $stripe_plan = SubscriptionPlan();
//         $plandetail = Plan::where('plan_id',$plan)->first();
//         if ( NewSubscriptionCoupon() == 1 ) {*/
//                     // $user->newSubscription($stripe_plan, $plan)->withCoupon($apply_coupon)->create($paymentMethod);
//            /* try {*/
//                             //$subscription = $user->newSubscription('default', $planId) //                                                    ->create($paymentMethod);
//                 /* $user->newSubscription($stripe_plan, $plan)->withCoupon($apply_coupon)->create($paymentMethod);
//             } catch (IncompletePayment $exception) {
//                 return redirect()->route(
//                     'cashier.payment',
//                     [$exception->payment->id, 'redirect' => route('home')]
//                 );
//             }*/
//                 //     $customerId = $user->asStripeCustomer()->id;
//                 //     $upcomingInvoice = \Stripe\Invoice::upcoming(["customer" => $customerId]);
//                 //     $nextPaymentAttemptTimestamp = $upcomingInvoice->next_payment_attempt;
//                 //     $nextPaymentAttemptDate = Carbon::createFromTimeStamp($nextPaymentAttemptTimestamp)->format('F jS, Y');

//        /* Mail::send('emails.subscriptionmail', array(
//             'name' => $user->username,
//             'paymentMethod' => $paymentMethod,
//             'plan' => ucfirst($plandetail->plans),
//             'price' => $plandetail->price,
//             'billing_interval' => $plandetail->billing_interval,*/
//             /*'next_billing' => $nextPaymentAttemptDate,*/
//        /* ), function($message) use ($request,$user){
//             $message->from(AdminMail(),'Flicknexs');
//             $message->to($request->session()->get('register.email'), $user->username)->subject($request->get('subject'));
//         });
//             $user->role = 'subscriber';
//             $user->active = 1;
//             $user->save();
//              DB::table('subscriptions')->insert([
//                                     ['user_id' => $user_id, 'plan_id' => $plan, 'days' => $plan_details->days, 'price' => $plan_details->price, 'ends_at' => $date,'created_at' => $current_date,'stripe_plan' => $plan, 'stripe_status' => 'active']
//                                 ]);

//     } else {

//         try {
//             $user->newSubscription($stripe_plan, $plan)->create($paymentMethod);
//         } catch (IncompletePayment $exception) {
//             return redirect()->route(
//                 'cashier.payment',
//                 [$exception->payment->id, 'redirect' => route('home')]
//             );
//         }
// */
//                      //$user->newSubscription($stripe_plan, $plan)->create($paymentMethod);
//     //                 $customerId = $user->asStripeCustomer()->id;
//     //                        $upcomingInvoice = \Stripe\Invoice::upcoming(["customer" => $customerId]);
//     //                        $nextPaymentAttemptTimestamp = $upcomingInvoice->next_payment_attempt;
//     //                        $nextPaymentAttemptDate = Carbon::createFromTimeStamp($nextPaymentAttemptTimestamp)->format('F jS, Y');

//         /*Mail::send('emails.subscriptionmail', array(
//             'name' => $user->username,
//             'paymentMethod' => $paymentMethod,
//             'plan' => ucfirst($plandetail->plans),
//             'price' => $plandetail->price,
//             'billing_interval' => $plandetail->billing_interval,*/
//     //                                'next_billing' => $nextPaymentAttemptDate,
//         /*), function($message) use ($request,$user){
//             $message->from(AdminMail(),'Flicknexs');
//             $message->to($request->session()->get('register.email'), $user->username)->subject($request->get('subject'));
//         });
//         $user->role = 'subscriber';
//         $user->active = 1;
//         $user->avatar = $avatar;
//         $user->save();
//          DB::table('subscriptions')->insert([
//                                     ['user_id' => $user_id, 'plan_id' => $plan, 'days' => $plan_details->days, 'price' => $plan_details->price, 'ends_at' => $date,'created_at' => $current_date,'stripe_plan' => $plan, 'stripe_status' => 'active']
//                                 ]);
//     }
//     $response = array(
//       'status' => 'success'
//     );
//         if ($response)
//             {   $referrer = User::whereUsername(session()->pull('referrer'))->first();
//         $data = array(
//           'referrer_id' => $referrer ? $referrer->id : null,
//         );
//         $user->update($data);
//         }
     
//         return response()->json($response);

//     } */
//   }

public function GetState(Request $request)
{
    
    $country_id = \App\AllCountry::where('name',$request->country_id)->pluck('id')->first();

    $data['states'] = \App\AllStates::where("country_id", $country_id)->orderBy('name','asc')
        ->get(["name", "id"]);
    return response()
        ->json($data);
}

public function GetCity(Request $request)
{

    $state_id = \App\AllStates::where('name',$request->state_id)->pluck('id')->first();

    $data['cities'] = \App\AllCities::where("state_id", $state_id)
        ->get(["name", "id"]);
    return response()
        ->json($data);
}


        public function upgradepaypalsubscription(Request $request)
        {
                $register = $request->session()->get('register');
                $email = $request->email;
                $user_email = User::where('email','=',$email)->count();
                $user_first = User::where('email','=',$email)->first();
                $id = $user_first->id;  
                $plandetail = SubscriptionPlan::where('plan_id','=',$request->plan_id)->first();
                $payment_type = $plandetail->payment_type;

                if ( $user_email > 0 ) {
                // $subIds = $request->get('subId'); 
                $current_date = date('Y-m-d h:i:s');
                $next_date = $plandetail->days;
                $date = Carbon::parse($current_date)->addDays($next_date);
    
                $subscription = Subscription::where('user_id',$user_first->id)->first();
                
                $subscription = new Subscription;
                $subscription->price = $plandetail->price;
                $subscription->name = $user_first->username;
                $subscription->days = $plandetail->days;
                $subscription->user_id =  Auth::user()->id;
                $subscription->stripe_id = $request->plan_id;
                $subscription->stripe_status  = 'active';
                $subscription->stripe_plan = $request->plan_id;
                $subscription->regionname = Region_name();
                $subscription->countryname = Country_name();
                $subscription->cityname = city_name();
                $subscription->PaymentGateway =  'paypal';
                $subscription->ends_at = $date;
                $subscription->platform = 'WebSite';
                $subscription->save();

                    $subId = $request->subId;        
                    $new_user = User::find($id);
                    $new_user->role = 'subscriber';
                    $new_user->paypal_id = $subId;
                    $new_user->payment_type ='paypal';
                    $new_user->save();
                    $response = array(
                        'status' => 'success'
                    );
                } else {
                    $response = array(
                        'status' => 'failed'
                    );
                }
            return response()->json($response);
            
        }   

        public function checkMobile(Request $request)
        {
            $mobile = $request->input('mobile');
            $exists = User::where('mobile', $mobile)->exists();

            return response()->json(['exists' => $exists]);
        }

}
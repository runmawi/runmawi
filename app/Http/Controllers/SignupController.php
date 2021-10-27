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
    
    
    
         public function saveSubscription(Request $request) {
        
               $user_email = Auth::user()->email;
                $user = User::where('email',$user_email)->first();

                $paymentMethod = $request->get('py_id');
                $plan = $request->get('plan');
                $plandetail = Plan::where('plans_name',$plan)->first();
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
            $signup_status = FreeRegistration();
//            if ( $signup_status == 1 ) {
//                return redirect('/signup');
//            }
            if ($request->has('ref')) {
                session(['referrer' => $request->query('ref')]);
            }
            $register = $request->session()->get('register');
            $settings = \App\Setting::first();
            if($settings->free_registration == 1) {
                return view('register.step1',compact('register'));
            } else {
                return view('register.step1',compact('register'));
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
                    return redirect('/');
                }
                return redirect('/');
            }





public function createStep2(Request $request)
    {
            if ($request->has('ref')) {
                session(['referrer' => $request->query('ref')]);
            }
    

            

            $user_mail = session()->get('register.email');
            $user_count = User::where("email","=",$user_mail)->where("active","=",1)->count();

            if ($user_count == 0 ) {
                  return redirect('/')->with('message', 'You have successfully verified your account. Please login below.');
            }elseif(!isset($user_mail)){
                 return redirect('/')->with('message', 'You have successfully verified your account. Please login below.');
            }else{
                $register = $request->session()->get('register');
                return view('register.step2',compact('register'));
            }

    }


public function PostcreateStep2(Request $request)
{
   $validatedData = $request->validate([
    'plan_name' => 'required'
    ]);
    

       $request->session()->put('planname', $request['plan_name']);
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
        $plans = Plan::where("plan_id","=",$request->plan_data)->first();
        $user_id = $user->id;
        $name = $user->username; 
        $price = $plans->price;
        $plan = $plans->plans_name;
        $error = $request->error;
        $error_message = $error['message'];

        // echo "<pre>";print_r($error['message']);exit();

        $template = EmailTemplate::where('id','=',6)->first(); 
        Mail::send('emails.paymentfailed', array(
            /* 'activation_code', $user->activation_code,*/
            'name'=>$user->username, 
            'price' => $price, 
            'plan' => $plan, 
            'heading'=> $template->heading,
            'error'=> $error,
            ), function($message) use ($request,$user) {
            $message->from(AdminMail(),'Flicknexs');
            $message->to($request->session()->get('register.email'), $user->username)->subject('Payment failed');
             });

         $response = array(
            'status' => 'success'
            );
            return response()->json($response);   
    }  

    public function PostcreateStep3(Request $request)
    {
      if ($request->has('ref')) {
            session(['referrer' => $request->query('ref')]);
        }
        $avatars = $request->session()->get('avatar');
        if ($avatars!=='') {
            $avatar = $request->session()->get('avatar');
        } else {
            $avatar  = 'default.png'; 
        }
         $settings = $settings = \App\Setting::first();/*Setting::first()*/
       /* if (!$settings->free_registration && $skip == 0) {
            $user_data['role'] = 'subscriber';
            $user_data['active'] = '1';
        } else {
                if($settings->activation_email):
                    $user_data['activation_code'] = Str::random(60);
                    $user_data['active'] = 0;
                endif;
            $user_data['role'] = 'registered';
        }*/
       
        $payment_type = $request->payment_type;
    // print_r($payment_type);exit();
        if ( $payment_type == "one_time") {
                        $user_email = $request->session()->get('register.email');
                        $user = User::where('email',$user_email)->first();
                        $paymentMethod = $request->get('py_id');
                        $plan = $request->get('plan');
                        $paymentMethods = $user->paymentMethods();
                        $apply_coupon = NewSubscriptionCouponCode();
                        $stripe_plan = SubscriptionPlan();
                        $plandetail = Plan::where('plan_id',$plan)->first();
                        if ( NewSubscriptionCoupon() == 1 ) {                      
                            try {
                                 $user->newSubscription($stripe_plan, $plan)->withCoupon($apply_coupon)->create($paymentMethod);
                                 $user->role = 'subscriber';
                                 $user->payment_type = 'recurring';
                                 $user->card_type = 'stripe';
                                 $user->active = 1;
                                 $user->save();

                            } catch (IncompletePayment $exception) {
                                
                                return redirect()->route(
                                    'cashier.payment',
                                    [$exception->payment->id, 'redirect' => route('home')]
                                );
                            }

                           
                        \Mail::send('emails.subscriptionmail', array(
                          /*'activation_code', $user->activation_code,*/
                            'name' => $user->username,
                            'paymentMethod' => $paymentMethod,
                            'plan' => ucfirst($plandetail->plans_name),
                            'price' => $plandetail->price,
                            'billing_interval' => $plandetail->billing_interval,
                            /*'next_billing' => $nextPaymentAttemptDate,*/
                        ), function($message) use ($request,$user){
                            $message->from(AdminMail(),'Eliteclub');
                            $message->to($request->session()->get('register.email'), $user->username)->subject($request->get('subject'));
                        });
                         

                    } else {
                           
                        try {
                            $user->newSubscription($stripe_plan, $plan)->create($paymentMethod);
                        } catch (IncompletePayment $exception) {
                            return redirect()->route(
                                'cashier.payment',
                                [$exception->payment->id, 'redirect' => route('home')]
                            );
                        }
                        \Mail::send('emails.subscriptionmail', array(
                           /* 'activation_code', $user->activation_code,*/
                            'name' => $user->username,
                            'paymentMethod' => $paymentMethod,
                            'plan' => ucfirst($plandetail->plans_name),
                            'price' => $plandetail->price,
                            'billing_interval' => $plandetail->billing_interval,
                                                //    'next_billing' => $nextPaymentAttemptDate,
                        ), function($message) use ($request,$user){
                            $message->from(AdminMail(),'Flicknexs');
                            $message->to($request->session()->get('register.email'), $user->username)->subject($request->get('subject'));
                        });
                        $user->role = "subscriber";
                        $user->payment_type = "recurring";
                        $user->card_type = "stripe";
                        $user->active = 1;
                        $user->avatar = $avatar;
                        $user->save();
                    }
             } else {

                $length = 10;
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $ref_token = substr(str_shuffle(str_repeat($pool, 5)), 0, $length);  
        $token = substr(str_shuffle(str_repeat($pool, 5)), 0, $length); 
    if (!empty($request->token)){
        $user_data['token'] =  $request->token;
    } else {
      $user_data['token'] =  '';
    }
                $current_date = date('Y-m-d h:i:s');    
                $setting = Setting::first();
                $ppv_hours = $setting->ppv_hours;
                $user_email = $request->session()->get('register.email');
                $user = User::where("email","=",$user_email)->first();
                $user_id = $user->id;
                $price = $request->amount;
                $paymentMethod = $request->get('py_id');
                $plan = $request->get('plan');
                $paymentMethods = $user->paymentMethods();
                $apply_coupon = NewSubscriptionCouponCode();
                $stripe_plan = SubscriptionPlan();
                $plandetail = Plan::where('plan_id',"=",$plan)->first();          
                $plan_details = Plan::where("plan_id","=",$plan)->first();
                $next_date = $plan_details->days;
                $date = Carbon::parse($current_date)->addDays($next_date);
                $sub_price = $plan_details->price;
                //$stripe = new \Stripe\StripeClient('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');
                $stripe = new \Stripe\StripeClient('sk_test_FIoIgIO9hnpVUiWCVj5ZZ96o005Yf8ncUt');
                $sub_total = $sub_price - DiscountPercentage();
                    if ( NewSubscriptionCoupon() == 1 ) {
                            $stripe->charges->create([
                                  'amount' =>  $sub_total * 100,
                                  'currency' => 'USD',
                                  'source' => $request->stripToken,
                                  /*'source' => 'tok_visa',*/
                                  'description' => 'New Subscription using One Time subscription method'
                                ]);    
                            $user = User::find($user_id);
                            $user->role = "subscriber";
                            $user->payment_type = "one_time";
                            $user->card_type = "stripe";
                            $user->save();
                            $email = $user_email;
                            $uname = $user->username;
                                DB::table('subscriptions')->insert([
                                ['user_id' => $user_id, 'stripe_id'=>$user->stripe_id, 'stripe_plan'=>$plan,'name'=>$user->username, 'days' => $plan_details->days, 'price' => $plan_details->price, 'ends_at' => $date,'created_at' => $current_date,'stripe_status' => 'active']
                            ]);

                            

                          Mail::send('emails.subscriptionmail', array(
                          /* 'activation_code', $user->activation_code,*/
                            'name'=>$user->username, 
                          'days' => $plan_details->days, 
                          'price' => $plan_details->price, 
                          'ends_at' => $date,
                          'uname' => $uname,
                          'created_at' => $current_date), function($message) use ($request,$user) {
                                                $message->from(AdminMail(),'Flicknexs');
                                                 $message->to($request->session()->get('register.email'), $user->username)->subject($request->get('subject'));
                                            });

                                           }     else {
                     $stripe->charges->create([
                              'amount' =>  $sub_price * 100,
                              'currency' => 'USD',
                              'source' => $request->stripToken,
                             /* 'source' => 'tok_visa',*/
                              'description' => 'New Subscription using One Time subscription method',
                            ]);    
                            $user = User::find($user_id);
                            $user->role = "subscriber";
                            $user->payment_type = "one_time";
                            $user->card_type ="stripe";
                            $user->save();
                            $email = $user_email;
                            $uname = $user->username;
                            DB::table('subscriptions')->insert([
                                ['user_id' => $user_id, 'stripe_id'=>$user->stripe_id, 'stripe_plan'=>$plan,'name'=>$user->username, 'days' => $plan_details->days, 'price' => $plan_details->price, 'ends_at' => $date,'created_at' => $current_date,'stripe_status' => 'active']
                            ]);
                              Mail::send('emails.subscriptionmail', array(
                               /* 'activation_code', $user->activation_code,*/
                                'name'=>$user->username, 
                          'days' => $plan_details->days, 
                          'price' => $plan_details->price, 
                          'ends_at' => $date,
                          'uname' => $uname,

                          'created_at' => $current_date), function($message) use ($request,$user) {
                                                $message->from(AdminMail(),'Flicknexs');
                                                 $message->to($request->session()->get('register.email'), $user->username)->subject($request->get('subject'));
                                            });
             }
            
             }
                $response = array(
                  'status' => 'success'
                );
                return response()->json($response);
       /* if ($request->has('ref')) {
            session(['referrer' => $request->query('ref')]);
        }
        $avatars = $request->session()->get('avatar');
        if ($avatars!=='') {
            $avatar = $request->session()->get('avatar');
        } else {
            $avatar  = 'default.png'; 
        }
        
        $user_email = $request->session()->get('register.email');
        $user = User::where('email',$user_email)->first();
        $paymentMethod = $request->get('py_id');
        $plan = $request->get('plans_name');
        $paymentMethods = $user->paymentMethods();
        $apply_coupon = NewSubscriptionCouponCode();
        $stripe_plan = SubscriptionPlan();
        $plandetail = Plan::where('plan_id',$plan)->first();
        if ( NewSubscriptionCoupon() == 1 ) {*/
                    // $user->newSubscription($stripe_plan, $plan)->withCoupon($apply_coupon)->create($paymentMethod);
           /* try {*/
                            //$subscription = $user->newSubscription('default', $planId) //                                                    ->create($paymentMethod);
                /* $user->newSubscription($stripe_plan, $plan)->withCoupon($apply_coupon)->create($paymentMethod);
            } catch (IncompletePayment $exception) {
                return redirect()->route(
                    'cashier.payment',
                    [$exception->payment->id, 'redirect' => route('home')]
                );
            }*/
                //     $customerId = $user->asStripeCustomer()->id;
                //     $upcomingInvoice = \Stripe\Invoice::upcoming(["customer" => $customerId]);
                //     $nextPaymentAttemptTimestamp = $upcomingInvoice->next_payment_attempt;
                //     $nextPaymentAttemptDate = Carbon::createFromTimeStamp($nextPaymentAttemptTimestamp)->format('F jS, Y');

       /* Mail::send('emails.subscriptionmail', array(
            'name' => $user->username,
            'paymentMethod' => $paymentMethod,
            'plan' => ucfirst($plandetail->plans),
            'price' => $plandetail->price,
            'billing_interval' => $plandetail->billing_interval,*/
            /*'next_billing' => $nextPaymentAttemptDate,*/
       /* ), function($message) use ($request,$user){
            $message->from(AdminMail(),'Flicknexs');
            $message->to($request->session()->get('register.email'), $user->username)->subject($request->get('subject'));
        });
            $user->role = 'subscriber';
            $user->active = 1;
            $user->save();
             DB::table('subscriptions')->insert([
                                    ['user_id' => $user_id, 'plan_id' => $plan, 'days' => $plan_details->days, 'price' => $plan_details->price, 'ends_at' => $date,'created_at' => $current_date,'stripe_plan' => $plan, 'stripe_status' => 'active']
                                ]);

    } else {

        try {
            $user->newSubscription($stripe_plan, $plan)->create($paymentMethod);
        } catch (IncompletePayment $exception) {
            return redirect()->route(
                'cashier.payment',
                [$exception->payment->id, 'redirect' => route('home')]
            );
        }
*/
                     //$user->newSubscription($stripe_plan, $plan)->create($paymentMethod);
    //                 $customerId = $user->asStripeCustomer()->id;
    //                        $upcomingInvoice = \Stripe\Invoice::upcoming(["customer" => $customerId]);
    //                        $nextPaymentAttemptTimestamp = $upcomingInvoice->next_payment_attempt;
    //                        $nextPaymentAttemptDate = Carbon::createFromTimeStamp($nextPaymentAttemptTimestamp)->format('F jS, Y');

        /*Mail::send('emails.subscriptionmail', array(
            'name' => $user->username,
            'paymentMethod' => $paymentMethod,
            'plan' => ucfirst($plandetail->plans),
            'price' => $plandetail->price,
            'billing_interval' => $plandetail->billing_interval,*/
    //                                'next_billing' => $nextPaymentAttemptDate,
        /*), function($message) use ($request,$user){
            $message->from(AdminMail(),'Flicknexs');
            $message->to($request->session()->get('register.email'), $user->username)->subject($request->get('subject'));
        });
        $user->role = 'subscriber';
        $user->active = 1;
        $user->avatar = $avatar;
        $user->save();
         DB::table('subscriptions')->insert([
                                    ['user_id' => $user_id, 'plan_id' => $plan, 'days' => $plan_details->days, 'price' => $plan_details->price, 'ends_at' => $date,'created_at' => $current_date,'stripe_plan' => $plan, 'stripe_status' => 'active']
                                ]);
    }
    $response = array(
      'status' => 'success'
    );
        if ($response)
            {   $referrer = User::whereUsername(session()->pull('referrer'))->first();
        $data = array(
          'referrer_id' => $referrer ? $referrer->id : null,
        );
        $user->update($data);
        }
     
        return response()->json($response);

    } */
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
                $plan_details = PaypalPlan::where('plan_id','=',$plan_id)->first();
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
                $email = $request->email;
                $user_email = User::where('email','=',$email)->count();
                $user_first = User::where('email','=',$email)->first();
                $id = $user_first->id;  
            
                if ( $user_email > 0 ) {
                   // $subIds = $request->get('subId');           
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

}
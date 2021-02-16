<?php
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Redirect,Response,Stripe;
use App\Setting as Setting;
use App\PpvPurchase as PpvPurchase;
use App\Plan as Plan;
use Carbon\Carbon;
use Auth;
use DB;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Image;
use Illuminate\Support\Facades\Notification;

class StripeController extends Controller
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
            
//            print_r('$uid');
//            exit;

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
             if ($request->has('ref')) {
                session(['referrer' => $request->query('ref')]);
              }
            
            $register = $request->session()->get('register');
            
            $settings = \App\Setting::first();
            if($settings->free_registration == 1) {
                return view('auth.register',compact('register'));
            } else {
                return view('register.step1',compact('register'));
            }
            // return view('register.step1',compact('register'));
        }

        public function PostcreateStep1(Request $request)
        {
            if ($request->has('ref')) {
                session(['referrer' => $request->query('ref')]);
            }
            
            $validatedData = $request->validate([
                'username' => ['required', 'string'],
                'email' =>  ['required', 'string', 'email', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'mobile' => ['required', 'numeric'],
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
            
              $hash_pass = Hash::make('admin123!@#');
        
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
        
            $pwd = 'admin123!@#';
               
                    if ($user_email == 0) {
                          User::create([
                                    'name' => $name,
                                    'username' => $name,
                                    'mobile' => $get_mobile,
                                    'ccode' => $ccode,
                                    'active' => 1,
                                    'avatar' => $avatars,
                                    'role' => 'registered',
                                    'email' => $email,
                                    'password' => Hash::make($pwd),
                          ]);
                    }
                }
           

            exit;
        
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
                         return redirect('/register2');
                     }
                          
                 }
        }
    
    public function SaveAsRegisterUser(Request $request)
    {
       
         $register = $request->session()->get('register');
           
             $email = $request->session()->get('register.email');
             $name = $request->session()->get('register.username');
             $password2 = $request->session()->get('password');
            $hash = Hash::make('admin123!@#');
       
             $avatars = $request->session()->get('avatar');
        
                 if ($avatars!=='') {
                        $avatar = $request->session()->get('avatar');

                 } else {

                    $avatar  = 'default.png'; 
                 }

                $ccode_session = $request->get('ccode');
                $ccode = $request->session()->put('ccode', $ccode_session);
                $get_ccode = $request->session()->get('ccode');
                $mobile_session = $request->get('mobile');
                $mobiles = $request->session()->put('mobile',$mobile_session); 
                $get_mobile = $request->session()->get('mobile');
                $ccode = $get_ccode;
       
        
             $user_email = User::where('email',$email)->count();
        
             if ($user_email == 0) {
                     User::create([
                        'name' => $name,
                        'username' => $name,
                        'email' => $email,
                        'role' => 'registered',
                        'active' => 1,
                        'mobile' => $get_mobile,
                        'ccode' => $ccode,
                        'avatar' => $avatar,
                        'password' => $hash
                    ]);
                }
        
        //   if (Hash::check('admin123!@#', $hash)) {
        //     echo "match";
        // } else {
        //     echo "not matched";
        // }
        //  print_r($hash);
        // exit;
        
      
//        exit;
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
            $register = $request->session()->get('register');

            return view('register.step2',compact('register'));
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
             $avatars = $request->session()->get('avatar');
             if ($avatars!=='') {
                        $avatar = $request->session()->get('avatar');

             } else {
               $avatar  = 'default.png'; 
            }
            if(empty($request->session()->get('register'))){
                $register = new \App\User();
                $register->fill($validatedData);
                $request->session()->put('register', $register);
            }else{
                $register = $request->session()->get('register');
                $register->fill($validatedData);
                $request->session()->put('register', $register);
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
                if ($avatars!=='') {
                        $avatar = $request->session()->get('avatar');

                 } else {

                    $avatar  = 'default.png'; 
                 }
            
             //$mobiles = $request->session()->put('mobile',$mobile_session); 
                $get_mobile = $request->session()->get('mobile');
              //  $ccode = $get_ccode;
            
              $user_email = User::where('email',$uemail)->count();
                if ($user_email == 0) {
                         User::create([
                            'name' => $uname,
                            'username' => $uname,
                            'active' => 1,
                            'mobile' => $get_mobile,
                            'email' => $uemail,
                            'avatar' => $avatar,
                            'active' => 1,
                            'password' => Hash::make($upassword),
                       ]);
                } 
            
             $user = User::where('email',$uemail)->first();
             if ($user->stripe_id == NULL)
                {
                      $stripeCustomer = $user->createAsStripeCustomer();

                }
            
               return view('register.step3', [
                'intent' => $user->createSetupIntent()
                  ,compact('register')
               ]);

            
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
            
            $user_email = $request->session()->get('register.email');
            $user = User::where('email',$user_email)->first();
            $paymentMethod = $request->get('py_id');
            $plan = $request->get('plan');
            $paymentMethods = $user->paymentMethods();
            $apply_coupon = NewSubscriptionCouponCode();
            $stripe_plan = SubscriptionPlan();
           
            $plandetail = Plan::where('plans_name',$plan)->first();
            if ( NewSubscriptionCoupon() == 1 ) {
                 $user->newSubscription($stripe_plan, $plan)->withCoupon($apply_coupon)->create($paymentMethod);
                        $customerId = $user->asStripeCustomer()->id;
//                        $upcomingInvoice = \Stripe\Invoice::upcoming(["customer" => $customerId]);
//                        $nextPaymentAttemptTimestamp = $upcomingInvoice->next_payment_attempt;
//                        $nextPaymentAttemptDate = Carbon::createFromTimeStamp($nextPaymentAttemptTimestamp)->format('F jS, Y');

//                         \Mail::send('emails.subscriptionmail', array(
//                                'name' => $user->username,
//                                'paymentMethod' => $paymentMethod,
//                                'plan' => ucfirst($plan),
//                                'price' => $plandetail->price,
//                                'billing_interval' => $plandetail->billing_interval,
//                                'next_billing' => $nextPaymentAttemptDate,
//                            ), function($message) use ($request,$user){
//                                $message->from('info@elightclubco.com','Eliteclub');
//                                $message->to($request->session()->get('register.email'), $user->username)->subject($request->get('subject'));
//                            });
                $user->role = 'subscriber';
                $user->active = 1;
                $user->avatar = $avatar;
                $user->save();
                
            } else {
                 $user->newSubscription($stripe_plan, $plan)->create($paymentMethod);
                 $customerId = $user->asStripeCustomer()->id;
//                        $upcomingInvoice = \Stripe\Invoice::upcoming(["customer" => $customerId]);
//                        $nextPaymentAttemptTimestamp = $upcomingInvoice->next_payment_attempt;
//                        $nextPaymentAttemptDate = Carbon::createFromTimeStamp($nextPaymentAttemptTimestamp)->format('F jS, Y');

//                         \Mail::send('emails.subscriptionmail', array(
//                                'name' => $user->username,
//                                'paymentMethod' => $paymentMethod,
//                                'plan' => ucfirst($plan),
//                                'price' => $plandetail->price,
//                                'billing_interval' => $plandetail->billing_interval,
//                                'next_billing' => $nextPaymentAttemptDate,
//                            ), function($message) use ($request,$user){
//                                $message->from('info@elightclubco.com','Eliteclub');
//                                $message->to($request->session()->get('register.email'), $user->username)->subject($request->get('subject'));
//                            });
                $user->role = 'subscriber';
                $user->active = 1;
                $user->avatar = $avatar;
                $user->save();
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
           
         } 
    
        protected function registered(Request $request, $user)
        {
            if ($user->referrer !== null) {
                Notification::send($user->referrer, new ReferrerBonus($user));
            }

            return redirect($this->redirectPath());
        }
    
        public function CancelSubscription()
        {
              echo "kljl";  
        }

    
    
}
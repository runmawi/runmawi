<?php

namespace Webnexs\Avod;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator,Redirect,Response;
Use App\Advertiser;
Use App\Adsplan;
Use App\Advertisement;
Use App\Advertiserplanhistory;
Use App\Adscategory;
Use App\Setting;
use App\FeaturedadHistory;
use App\Advertiserwallet;
use App\Adcampaign;
use App\Adviews;
use App\Adrevenue;
Use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;
use DB;
use Stripe;
use Razorpay\Api\Api;
use Exception;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use Laravel\Cashier\Exceptions\IncompletePayment;
use Carbon\Carbon;
use Mail; 
use Illuminate\Support\Str;


class AuthController extends Controller
{
    public function index()
    {
        $data = array('settings'=>Setting::first());
        return view('avod::login',$data);
    }  

    public function register()
    {
        $data = array('settings'=>Setting::first());
        return view('avod::register',$data);
    }

    public function postLogin(Request $request)
    {
        request()->validate([
            'email_id' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        
        if ($data = Advertiser::where('email_id', $request->email_id)->first()) {
            $pass = Hash::check($request->password, $data->password);
            if ($pass && $data->status == 1) {
                session(['advertiser_id' => $data->id]);
                return redirect()->intended('/advertiser');
            }elseif ($pass && $data->status == 0) {
                return Redirect::to("advertiser/login")->withError('Opps! Your account is under verification.Please wait for admin approval.');
            } elseif ($pass && $data->status == 2) {
                return Redirect::to("advertiser/login")->withError('Opps! Admin has disapproved your account.Please contact administrator.');
            }
        }
        return Redirect::to("advertiser/login")->withError('Opps! You have entered invalid credentials');
    }

    public function postRegister(Request $request)
    {  
        request()->validate([
            'company_name' => 'required',
            'email_id' => 'required|email|unique:advertisers',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();
        $advertiser = new Advertiser();
        $advertiser->password = Hash::make($data['password']);
        $advertiser->email_id = $data['email_id'];
        $advertiser->company_name = $data['company_name'];
        $advertiser->license_number = $data['license_number'];
        $advertiser->address = $data['address'];
        $advertiser->mobile_number = $data['mobile_number'];
        $advertiser->save();

        $advertiser_emailid = $data['email_id'];
        $customerName = $data['company_name'];
        $adminemail = User::where('role','=','admin')->first()->email;
        $details = [
            'title' => "Dear " .$customerName,
            'body' => "We are happy to have you on board.\n
            Thank you for registering as an Advertiser at ".$customerName.".\n 
            If you have any questions, please write to us at ".$adminemail." for queries and suggestions."
        ];

        \Mail::to($advertiser_emailid)->send(new \App\Mail\MyTestMail($details));


        return Redirect::to("advertiser/login")->withSuccess('Great! You have Successfully registered');
    }

    public function dashboard()
    {
        $data = [];
        $data['settings'] = Setting::first();
        $activeplan = Advertiserplanhistory::where('advertiser_id',session('advertiser_id'))->where('status','active')->count();
        if(!empty(session('advertiser_id')) && $activeplan == 0){
            $data['plans'] = Adsplan::all();
            return view('avod::chooseplan',$data);

        }elseif(!empty(session('advertiser_id')) && $activeplan > 0){
            $adslist = Advertisement::where('advertiser_id',session('advertiser_id'))->pluck('id')->toArray();
            $cpc = [];
            $ads = [];
            foreach ($adslist as $key => $ad_id) {
                $cpc[] = Adrevenue::where('ad_id',$ad_id)->sum('advertiser_share');
                $ads[] = Advertisement::where('id',$ad_id)->first()->ads_name;
            }

            $ads1 = $cpv = [];
            foreach ($adslist as $key => $ad_id) {
                $cpv[] = Adviews::where('ad_id',$ad_id)->sum('advertiser_share');
                $ads1[] = Advertisement::where('id',$ad_id)->first()->ads_name;
            }
            return view('avod::dashboard')->with('ads',json_encode($ads,JSON_NUMERIC_CHECK))->with('cpc',json_encode($cpc,JSON_NUMERIC_CHECK))->with('ads1',json_encode($ads1,JSON_NUMERIC_CHECK))->with('cpv',json_encode($cpv,JSON_NUMERIC_CHECK));

        }
        return Redirect::to("advertiser/login")->withError('Opps! You do not have access');
    }


    public function logout() {
        Session::flush();
        return Redirect('advertiser/login');
    }

    public function buyplan(Request $request) {
        $data = [];
        $data['settings'] = Setting::first();
        if(!empty(session('advertiser_id'))){
            
                $user_id = session('advertiser_id');
                $user = Advertiser::find($user_id);
                $paymentMethod = $request->get('py_id');
                $plan_id = $request->get('plan');
                $plan_amount = Adsplan::where('id',$plan_id)->first()->plan_amount;
                try {

                    $user->createOrGetStripeCustomer();
                    $user->updateDefaultPaymentMethod($paymentMethod);
                    $charge = $user->charge($plan_amount * 100, $paymentMethod);  
                    
                    $ads_limit = Adsplan::where('id',$plan_id)->first()->no_of_ads;
                    $planhistory = new Advertiserplanhistory();
                    $planhistory->plan_id = $plan_id;
                    $planhistory->advertiser_id = session('advertiser_id');
                    $planhistory->ads_limit = $ads_limit;
                    $planhistory->no_of_uploads = 0;
                    $planhistory->status = 'active';
                    $planhistory->payment_mode = 'stripe';
                    $planhistory->transaction_id = $charge->id;
                    $planhistory->save();

                    $plan_name = Adsplan::where('id',$plan_id)->first()->plan_name;
                    $plan_amount = Adsplan::where('id',$plan_id)->first()->plan_amount;
                    $date = date('Y-m-d');
                    $customerName = Advertiser::find(session('advertiser_id'))->company_name;
                    $adminemail = User::where('role','=','admin')->first()->email;
                    $advertiser_emailid = Advertiser::find(session('advertiser_id'))->email_id;

                    $details = [
                        'title' => "Dear " .$customerName,
                        'body' => "Welcome to Flicknexs.
                        Thank you for purchasing to Ad plan. \n
                        Your Plan Name :".$plan_name."\n
                        Date of Purchase: ".$date."\n
                        Plan Amount : ".$plan_amount."\n
                        Log in to the Ad panel to explore more!\n
                        Please write to us at ".$adminemail." for queries and suggestions."
                    ];

                    \Mail::to($advertiser_emailid)->send(new \App\Mail\MyTestMail($details));
                    echo "success";  exit;    
                } catch (IncompletePayment $exception) {

                    return redirect()->route(
                        'cashier.payment',
                        [$exception->payment->id, 'redirect' => route('advertiser')]
                    );
                }
            
        }
        echo "error";exit; 
    }

    
    public function plan_history() {
        $data = [];
        $data['settings'] = Setting::first();
        $activeplan = Advertiserplanhistory::where('advertiser_id',session('advertiser_id'))->where('status','active')->count();

        if(!empty(session('advertiser_id')) && $activeplan == 0){
            return Redirect::to("/advertiser")->withError('Opps! You do not have access');
        }elseif(!empty(session('advertiser_id')) && $activeplan > 0){
            $data['plans'] = DB::table('advertiser_plan_history')
            ->select('advertiser_plan_history.*','ads_plans.plan_name','ads_plans.plan_amount','ads_plans.no_of_ads' )
            ->join('ads_plans', 'ads_plans.id', '=', 'advertiser_plan_history.plan_id')
            ->where('advertiser_plan_history.advertiser_id',session('advertiser_id'))
            ->get();
            return view('avod::plan_history',$data);
        }
        return Redirect::to("advertiser/login")->withError('Opps! You do not have access');
    }

    public function upload_ads() {
        $data = [];
        $data['settings'] = Setting::first();
        $activeplan = Advertiserplanhistory::where('advertiser_id',session('advertiser_id'))->where('status','active')->count();
        $getdata = Advertiserplanhistory::where('advertiser_id','=',session('advertiser_id'))->where('status','active')->first();
        $upload_ads_cnt = $getdata->ads_limit - $getdata->no_of_uploads;
        if(!empty(session('advertiser_id')) && $activeplan == 0 || $upload_ads_cnt == 0){
            $getdata->status = 'deactive';
            $getdata->save();

            $plan_name = Adsplan::where('id',$getdata->plan_id)->first()->plan_name;
            $customerName = Advertiser::find(session('advertiser_id'))->company_name;
            $advertiser_emailid = Advertiser::find(session('advertiser_id'))->email_id;
            $details = [
                'title' => "Dear " .$customerName,
                'body' => "Your ".$plan_name." limit for the plan has been reached, to add more ads please login to your account to upgrade plan."
            ];

            \Mail::to($advertiser_emailid)->send(new \App\Mail\MyTestMail($details));

            return Redirect::to("/advertiser")->withError('Opps! Your limit has completed.Please update your plan');
        }elseif(!empty(session('advertiser_id')) && $activeplan > 0 && $getdata->ads_limit > $getdata->no_of_uploads ){
            $data['ads_category'] = Adscategory::all();
            return view('avod::upload_ads',$data);
        }
        return Redirect::to("advertiser/login")->withError('Opps! You do not have access');
    }

    public function store_ads(Request $request) {
        $data = $request->all();

        $Ads = new Advertisement;
        $Ads->advertiser_id = session('advertiser_id');
        $Ads->ads_name = $request->ads_name;
        $Ads->ads_category = $request->ads_category;
        $Ads->ads_position = $request->ads_position;
        $Ads->ads_path = $request->ads_path;
        // $Ads->age = $request->age;
        // $Ads->gender = $request->gender;
        $Ads->household_income = $request->household_income;
        $Ads->location = $request->location;
        if (!empty($data['age']))
        {
            $Ads->age = json_encode($data['age']);
        }

        if (!empty($data['gender']))
        {
            $Ads->gender = json_encode($data['gender']);
        }
        if($request->ads_video != null ){
            $Ads_video = time().'_'.$request->ads_video->getClientOriginalName();  
            $ads = $request->ads_video->move(public_path('uploads/AdsVideos'), $Ads_video);
            $Ads->ads_video = $Ads_video;
        }

        $Ads->save();

        $getdata = Advertiserplanhistory::where('advertiser_id',session('advertiser_id'))->where('status','active')->first();
        $getdata->no_of_uploads += 1;
        $getdata->save();

        return Redirect::to('advertiser/ads-list');
    }

    public function ads_list() {
        $data = [];
        $data['settings'] = Setting::first();
        if(!empty(session('advertiser_id')) ){
            $data['advertisements'] = Advertisement::where('advertiser_id',session('advertiser_id'))->get();
            return view('avod::ads_list',$data);
        }
        return Redirect::to("advertiser/login")->withError('Opps! You do not have access');
    }

    public function paymentgateway($plan_id){
        $data['plan_id'] = $plan_id;
        $data['plan_amount'] = (Adsplan::where('id',$plan_id)->first()->plan_amount)*100;
        $data['plan_value'] = (Adsplan::where('id',$plan_id)->first()->plan_amount);
        $data['plan_name'] = (Adsplan::where('id',$plan_id)->first()->plan_name);
        $data['no_of_ads'] = (Adsplan::where('id',$plan_id)->first()->no_of_ads);
        $data['settings'] = Setting::first();
        $user_id = session('advertiser_id');
        $user = Advertiser::find($user_id);
        $data['intent'] = $user->createSetupIntent();
        $data['user'] = $user;
        return view('avod::stripegateway',$data);
    }

    public function buyplanrazorpay(Request $request) {
        $input = $request->all();
  
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
  
        $payment = $api->payment->fetch($input['razorpay_payment_id']);
  
        if(count($input)  && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount'])); 


                $plan_id = $input['plan_id'];
                $ads_limit = Adsplan::where('id',$plan_id)->first()->no_of_ads;
                $planhistory = new Advertiserplanhistory();
                $planhistory->plan_id = $plan_id;
                $planhistory->advertiser_id = session('advertiser_id');
                $planhistory->ads_limit = $ads_limit;
                $planhistory->no_of_uploads = 0;
                $planhistory->status = 'active';
                $planhistory->payment_mode = 'razorpay';
                $planhistory->transaction_id = $input['razorpay_payment_id'];
                $planhistory->save();

                $plan_name = Adsplan::where('id',$plan_id)->first()->plan_name;
                $plan_amount = Adsplan::where('id',$plan_id)->first()->plan_amount;
                $date = date('Y-m-d');
                $customerName = Advertiser::find(session('advertiser_id'))->company_name;
                $adminemail = User::where('role','=','admin')->first()->email;
                $advertiser_emailid = Advertiser::find(session('advertiser_id'))->email_id;
                $details = [
                    'title' => "Dear " .$customerName,
                    'body' => "Welcome to Flicknexs.
                    Thank you for purchasing to Ad plan. \n
                    Your Plan Name :".$plan_name."\n
                    Date of Purchase: ".$date."\n
                    Plan Amount : ".$plan_amount."\n
                    Log in to the Ad panel to explore more!\n
                    Please write to us at ".$adminemail." for queries and suggestions."
                ];

                \Mail::to($advertiser_emailid)->send(new \App\Mail\MyTestMail($details));

                return Redirect::to("advertiser/")->withSuccess('success','Payment Successful');
                
            } catch (Exception $e) {
                return  $e->getMessage();
                return redirect()->back()->withError('error',$e->getMessage());
            }
        }
          
        return Redirect::to("advertiser/billing_details")->withError('error','Please try again');

    }


    
    public function billing_details(){
        $data['planhistory'] = Advertiserplanhistory::where('advertiser_id',session('advertiser_id'))->where('status','active')->first();
        $data['plan'] = Adsplan::where('id',$data['planhistory']->plan_id)->first();
        $data['settings'] = Setting::first();

        return view('avod::billing_details',$data);

    }

    public function showForgetPasswordForm()
      {
         return view('avod::forgetPassword');
      }
  
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitForgetPasswordForm(Request $request)
      {
          $request->validate([
              'email_id' => 'required|email|exists:advertisers',
          ]);
  
          $token = Str::random(64);
          DB::table('advertiser_password_reset')->insert([
              'email' => $request->email_id, 
              'token' => $token, 
              'created_at' => Carbon::now()
            ]);
  
          \Mail::send('avod::forgetPasswordemail', ['token' => $token], function($message) use($request){
              $message->to($request->email_id);
              $message->subject('Reset Password');
          });
  
          return Redirect::to("advertiser/login")->withSuccess('We have e-mailed your password reset link!');
      }
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function showResetPasswordForm($token) { 
         return view('avod::forgetPasswordLink', ['token' => $token]);
      }
  
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitResetPasswordForm(Request $request)
      {
          $request->validate([
              'email_id' => 'required|email|exists:advertisers',
              'password' => 'required|string|min:6|confirmed',
              'password_confirmation' => 'required'
          ]);
  
          $updatePassword = DB::table('advertiser_password_reset')
                              ->where([
                                'email' => $request->email_id, 
                                'token' => $request->token
                              ])
                              ->first();
  
          if(!$updatePassword){
              return back()->withInput()->with('error', 'Invalid token!');
          }
  
          $user = Advertiser::where('email_id', $request->email_id)
                      ->update(['password' => Hash::make($request->password)]);
 
          DB::table('advertiser_password_reset')->where(['email'=> $request->email_id])->delete();
  
          return redirect('advertiser/login')->with('success', 'Your password has been changed!');
      }

      public function FeaturedAds()
      {
        $data = [];
        $data['settings'] = Setting::first();
        $data['advertisements'] = Advertisement::where('advertiser_id',session('advertiser_id'))->where('featured',1)->get();
        $data['activeplan'] = Advertiserplanhistory::where('advertiser_id',session('advertiser_id'))->where('status','active')->count();

        return view('avod::featured_ads',$data);
      }

      public function UploadFeaturedAd() {
        $data = [];
        $data['settings'] = Setting::first();
        $data['ads_category'] = Adscategory::all();
        $user_id = session('advertiser_id');
        $user = Advertiser::find($user_id);
        $data['intent'] = $user->createSetupIntent();
        $data['user'] = $user;
        $data['activeplan'] = Advertiserplanhistory::where('advertiser_id',session('advertiser_id'))->where('status','active')->count();

        return view('avod::upload_featured_ad',$data);
    }

    public function buyfeaturedad_stripe(Request $request) {
        $data = [];
        $data['settings'] = Setting::first();
        if(!empty(session('advertiser_id'))){
            
                $user_id = session('advertiser_id');
                $user = Advertiser::find($user_id);
                $paymentMethod = $request->get('py_id');
                $plan_amount = $request->get('price');
                try {

                    $user->createOrGetStripeCustomer();
                    $user->updateDefaultPaymentMethod($paymentMethod);
                    $charge = $user->charge($plan_amount * 100, $paymentMethod);  
                    
                    $planhistory = new FeaturedadHistory();
                    $planhistory->advertiser_id = session('advertiser_id');
                    $planhistory->payment_mode = 'stripe';
                    $planhistory->transaction_id = $charge->id;
                    $planhistory->cost = $plan_amount;
                    $planhistory->save();

                    $Ads = new Advertisement;
                    $Ads->advertiser_id = session('advertiser_id');
                    $Ads->ads_name = $request->ads_name;
                    $Ads->ads_category = $request->ads_category;
                    $Ads->featured = 1;
                    $Ads->ads_position = $request->ads_position;
                    $Ads->ads_path = $request->ads_path;
                    $Ads->age = json_encode($request->age);
                    $Ads->gender = json_encode($request->gender);
                    $Ads->household_income = $request->household_income;
                    $Ads->location = $request->location;
                    $Ads->save();

                    echo "success";  exit;    
                } catch (IncompletePayment $exception) {
                    return redirect()->route(
                        'cashier.payment',
                        [$exception->payment->id, 'redirect' => route('advertiser')]
                    );
                }
            
        }
        echo "error";exit; 
    }


    public function featured_ad_history() {
        $data = [];
        $data['settings'] = Setting::first();
        $data['activeplan'] = Advertiserplanhistory::where('advertiser_id',session('advertiser_id'))->where('status','active')->count();
        $data['list'] = FeaturedadHistory::where('advertiser_id',session('advertiser_id'))->get();
        return view('avod::featured_ad_history',$data);
    }


    public function list_total_cpc() {
        $data = [];
        $data['settings'] = Setting::first();
        $data['activeplan'] = Advertiserplanhistory::where('advertiser_id',session('advertiser_id'))->where('status','active')->count();
        if(!empty(session('advertiser_id')) ){
            $data['cpc_lists'] = Adrevenue::where('advertiser_id',session('advertiser_id'))->get();
            return view('avod::total_cpc',$data);
        }
        return Redirect::to("advertiser/login")->withError('Opps! You do not have access');
    }

    public function list_total_cpv() {
        $data = [];
        $data['settings'] = Setting::first();
        $data['activeplan'] = Advertiserplanhistory::where('advertiser_id',session('advertiser_id'))->where('status','active')->count();
        if(!empty(session('advertiser_id')) ){
            $data['cpv_lists'] = Adviews::where('advertiser_id',session('advertiser_id'))->get();
            return view('avod::total_cpv',$data);
        }
        return Redirect::to("advertiser/login")->withError('Opps! You do not have access');
    }

    public function ads_campaign() {
        $data = [];
        $data['settings'] = Setting::first();
        $data['campaigns'] = Adcampaign::all();
        $user_id = session('advertiser_id');
        $user = Advertiser::find($user_id);
        $data['intent'] = $user->createSetupIntent();
        $data['user'] = $user;
        $data['activeplan'] = Advertiserplanhistory::where('advertiser_id',session('advertiser_id'))->where('status','active')->count();

        return view('avod::advertiser_wallet',$data);
    }

    public function buycampaign_stripe(Request $request) {
        $data = [];
        $data['settings'] = Setting::first();
        if(!empty(session('advertiser_id'))){
            
                $user_id = session('advertiser_id');
                $user = Advertiser::find($user_id);
                $paymentMethod = $request->get('py_id');
                $amount = $request->get('amount');
                $campaign_id = $request->get('campaign_id');
                try {

                    $user->createOrGetStripeCustomer();
                    $user->updateDefaultPaymentMethod($paymentMethod);
                    $charge = $user->charge($amount * 100, $paymentMethod);  
                    
                    $walletdata = new Advertiserwallet();
                    $walletdata->advertiser_id = session('advertiser_id');
                    $walletdata->payment_mode = 'stripe';
                    $walletdata->status = 1;
                    $walletdata->transaction_id = $charge->id;
                    $walletdata->amount = $amount;
                    $walletdata->campaign_id = $campaign_id;
                    $walletdata->save();

                    echo "success";  exit;    
                } catch (IncompletePayment $exception) {
                    return redirect()->route(
                        'cashier.payment',
                        [$exception->payment->id, 'redirect' => route('ads_campaign')]
                    );
                }
            
        }
        echo "error";exit; 
    }


    public function buyrz_adcampaign(Request $request) {
        $input = $request->all();
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $payment = $api->payment->fetch($input['razorpay_payment_id']);
  
        if(count($input)  && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount'])); 
                $walletdata = new Advertiserwallet();
                $walletdata->advertiser_id = session('advertiser_id');
                $walletdata->payment_mode = 'razorpay';
                $walletdata->status = 1;
                $walletdata->transaction_id = $input['razorpay_payment_id'];
                $walletdata->amount = $payment['amount'];
                $walletdata->campaign_id = $campaign_id;
                $walletdata->save();

                return Redirect::to("advertiser/ads_campaign/")->withSuccess('success','Payment Successful');
                
            } catch (Exception $e) {
                return  $e->getMessage();
                return redirect()->back()->withError('error',$e->getMessage());
            }
        }
          
        return Redirect::to("advertiser/ads_campaign/")->withError('error','Please try again');

    }

    public function buyrz_ad(Request $request) {
        $input = $request->all();
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $payment = $api->payment->fetch($input['razorpay_payment_id']);

        if(count($input)  && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount'])); 
                
                $planhistory = new FeaturedadHistory();
                $planhistory->advertiser_id = session('advertiser_id');
                $planhistory->payment_mode = 'razorpay';
                $planhistory->transaction_id = $input['razorpay_payment_id'];
                $planhistory->cost = $payment['amount']/100;
                $planhistory->save();

                $Ads = new Advertisement;
                $Ads->advertiser_id = session('advertiser_id');
                $Ads->ads_name = $request->ads_name;
                $Ads->ads_category = $request->ads_category;
                $Ads->featured = 1;
                $Ads->ads_position = $request->ads_position;
                $Ads->ads_path = $request->ads_path;
                // $Ads->age = $request->age;
                // $Ads->gender = $request->gender;
                $Ads->household_income = $request->household_income;
                $Ads->age = json_encode($input['age']);
                $Ads->gender = json_encode($input['gender']);
                $Ads->location = $request->location;
                $Ads->save();
                return Redirect::to("advertiser/featured_ads/")->withSuccess('success','Payment Successful'); 
                
            } catch (Exception $e) {
               return redirect()->route(
                'cashier.payment',
                [$e->payment->id, 'redirect' => route('advertiser')]
            );
           }
       }

       echo "error";exit; 
   }

   public function AdsList(Request $request)
   {
        $data = [
             'ads' => 'ss',
        ];
       return view('avod::Adslist',$data);
   }

}
?>
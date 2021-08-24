<?php

namespace App\Http\Controllers;
use \App\User as User;
use \Redirect as Redirect;
//use Request;
use App\Setting as Setting;
use App\Video as Video;
use App\Slider as Slider;
use App\PpvVideo as PpvVideo;
use App\PpvCategory as PpvCategory;
use App\VerifyNumber as VerifyNumber;
use App\Subscription as Subscription;
use App\PaypalPlan as PaypalPlan;
use App\ContinueWatching as ContinueWatching;
use App\Genre;
use App\Audio;
use App\Page as Page;
use App\HomeSetting as HomeSetting;
use App\Movie;
use App\Episode;
use App\LikeDislike as Likedislike;
use App\VideoCategory;
use URL;
use Auth;
use View;
use Hash;
use Mail;
use Nexmo;
use Illuminate\Support\Facades\Cache;
//use Image;
use Intervention\Image\ImageManagerStatic as Image;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\Authenticatable;
use GeoIPLocation;
use Stevebauman\Location\Facades\Location;
use Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $construct_name;
    
    public function __construct()
    {
        //$this->middleware('auth');
        $settings = Setting::first();
        $this->videos_per_page = $settings->videos_per_page;
    }

    public function FirstLanging(){
        return View::make('first_landing');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
    
       $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();        
       $settings = Setting::first();
      
       $genre = Genre::all();
       $genre_video_display = VideoCategory::all();
        
        $trending_videos = Video::where('active', '=', '1')->where('status', '=', '1')->where('views', '>', '5')->orderBy('created_at', 'DESC')->get();
        $latest_videos = Video::where('status', '=', '1')->take(10)->orderBy('created_at', 'DESC')->get();
        $suggested_videos = Video::where('active', '=', '1')->where('views', '>', '5')->orderBy('created_at', 'DESC')->get();
		$trending_movies = Movie::where('active', '=', '1')->where('status', '=', '1')->where('views', '>', '5')->orderBy('created_at', 'DESC')->get();
		$ppv_movies = PpvVideo::where('active', '=', '1')->where('status', '=', '1')->orderBy('created_at', 'DESC')->get();
		$latest_movies = Movie::where('active', '=', '1')->where('status', '=', '1')->take(10)->orderBy('created_at', 'DESC')->get();
        $trending_audios = Audio::where('active', '=', '1')->where('status', '=', '1')->where('views', '>', '5')->orderBy('created_at', 'DESC')->get();
        $latest_audios = Audio::where('active', '=', '1')->where('status', '=', '1')->take(10)->orderBy('created_at', 'DESC')->get();
		$trending_episodes = Episode::where('active', '=', '1')->where('views', '>', '0')->orderBy('created_at', 'DESC')->get();		
		$trendings = new \Illuminate\Database\Eloquent\Collection; //Create empty collection which we know has the merge() method
		$trendings = $trendings->merge($trending_videos);
		$trendings = $trendings->merge($trending_movies);
		$trendings = $trendings->merge($trending_episodes);
        $featured_videos = Video::where('active', '=', '1')->where('featured', '=', '1')->orderBy('created_at', 'DESC')->get();
		$featured_episodes = Episode::where('active', '=', '1')->where('featured', '=', '1')->orderBy('views', 'DESC')->get();
       
        $pages = Page::all();
        if(!Auth::guest()){
            $getcnt_watching = ContinueWatching::where('user_id',Auth::user()->id)->pluck('videoid')->toArray();
            $cnt_watching = Video::with('cnt_watch')->whereIn('id',$getcnt_watching)->get();
        }else{
            $cnt_watching = '';
        }
        //echo "<pre>";print_r($cnt_watching);exit();
        $data = array(
            'videos' => Video::where('active', '=', '1')->where('status', '=', '1')->orderBy('created_at', 'DESC')->simplePaginate($this->videos_per_page),
            'banner' => Video::where('active', '=', '1')->where('status', '=', '1')->orderBy('created_at', 'DESC')->simplePaginate(3),
            'sliders' => Slider::where('active', '=', '1')->orderBy('order_position', 'ASC')->get(),
            'cnt_watching' => $cnt_watching,
			'trendings' => $trending_movies,
			'latest_videos' => $latest_videos,
			'movies' => $trending_movies,
			'latest_movies' => $latest_movies,
			'ppv_movies' => $ppv_movies,
            'trending_audios' => $trending_audios,
            'latest_audios' => $latest_audios,
			'featured_videos' => $featured_videos,
			'featured_episodes' => $featured_episodes,
			'current_page' => 1,
			'genre_video_display'=> $genre_video_display,
 			'genres' => VideoCategory::all(),
			'pagination_url' => '/videos',
             'settings'=>$settings,
             'pages'=>$pages,
            'trending_videos' => $trending_videos,
            'suggested_videos' => $suggested_videos,
      'video_categories' => VideoCategory::all(),
			'home_settings' => HomeSetting::first()
        );
        //echo "<pre>";print_r($data['latest_videos']);exit;
        return View::make('home', $data);
    }
    public function social()
    {
        return View::make('social');
    }
    public function ViewStripe(Request $request){
    
        $stripe = new \Stripe\StripeClient(
                  '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'
                );
                 $stirpe_details = $stripe->subscriptions->retrieve(
                  'sub_Hzo5niEpDFNKMs',
                  []
                );
                $stirpe_details = array(
                        'stirpe_details' => $stirpe_details
                );
         return View::make('stripe_billing',$stirpe_details);     
    }
    
     public function promotions()
        {
         $promotion = Page::where('slug','=','promotion')->first();
         $data = array(
             "promotion"=>$promotion
         );
         return View::make('promotions',$data);
        
        }   
      
      public function VerifyRequest(Request $request)
        {
        
         return View::make('verify_request');
        
        }
    
        public function PostcreateStep1(Request $request)
             {
       
                if ($request->has('ref')) {
                    session(['referrer' => $request->query('ref')]);
                }

                $validatedData = $request->validate([
                    'username' =>  ['required', 'string'],
                    'email' =>  ['required', 'string', 'email', 'unique:users'],
                    'password' => 'required|string|min:6|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
                    'mobile' => ['required', 'numeric', 'min:8', 'unique:users'],
                    'password_confirmation' => 'required',
                ]);

                    $free_registration = FreeRegistration();
                    $length = 10;
                    $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $ref_token = substr(str_shuffle(str_repeat($pool, 5)), 0, $length);  

                    $email = $request->get('email');
                    $name = $request->get('username');
                    $ccode = $request->get('ccode');
                    $mobile = $request->get('mobile');
                    $get_password = $request->get('password');
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

                   $file = $logo;
                   $avatar  = $file->getClientOriginalName();
                   $file->move($path, $avatar);

                    } else {
                     $avatar  = 'default.png';
                    } 
                    
                    
                    $referrer_code = $request->get('referrer_code');
                    $ExpireDate = Date('d-m-Y', strtotime('+3 days'));
           
                if ( isset($referrer_code) && !empty($referrer_code) ) { 
                            $referred_user = User::where('referral_token','=',$referrer_code)->first();
                            $referred_user_id = $referred_user->id;
                            $coupon_expired = $ExpireDate;
                        } else {
                             $referred_user_id =0;
                             $coupon_expired ='';
                    }
            
            $email_count = User::where('email','=',$email)->count();            
            $string = Str::random(60); 
              if ($email_count == 0) {
                  $new_user = new User();
                  $new_user->name= $name;
                  $new_user->username =$name;
                  $new_user->mobile = $mobile;
                  $new_user->ccode = $ccode;
                  $new_user->avatar = $avatar;
                  $new_user->role = 'registered';
                  $new_user->referral_token = $ref_token;
                  $new_user->referrer_id = $referred_user_id;
                  $new_user->coupon_expired = $coupon_expired;
                  $new_user->email = $email;
                  $new_user->password = $get_password;
                  $new_user->activation_code = $string;
                  $new_user->save();
                  $settings = Setting::first();
                  \Mail::send('emails.verify', array('activation_code' => $string, 'website_name' => $settings->website_name), function($message)  use ($request) {
                        $message->to($request->email,$request->name)->subject('Verify your email address');
                     });
                   return redirect('/verify-request');
                }
    } 
             

        public function SignUpVerify()
        {
            return view('register.verify',compact('register'));
        }

        public function ViewReferral(Request  $request) {
               return view('view_referrer');
        }
    
    public function search(Request $request){
        
        if($request->ajax()) {
          
            $data = Video::where('title', 'LIKE','%'. $request->country.'%')->limit('10')
                ->get();
            
            $channeldata = VideoCategory::where('name', 'LIKE', '%'.$request->country.'%')->limit('10')
                ->get();
            
            $ppvdata = PpvVideo::where('title', 'LIKE', '%'.$request->country.'%')->limit('10')
                ->get();
           
            $output = '';
           
            if (count($data)>0 || count($ppvdata)>0 || count($channeldata)>0 && !empty($request->country)) {
              
                $output = '<ul class="list-group" style="display: block; position: relative; z-index: 999999;;margin-bottom: 0;border-radius: 0;">';
                $output .="<h3 style='margin: 0;text-align: center;padding: 10px;'> Videos</h3>";
                foreach ($data as $row){
                    $output .= '<li class="list-group-item">
                    <img width="35px" height="35px" src="'. URL::to('/').'/public/uploads/images/'.$row->image.'"><a href="'.URL::to('/').'/category/videos/'.$row->slug.'" style="font-color: #c61f1f00;color: #000;text-decoration: none;">'.$row->title.'</a></li>';
                }
              
            }
            else {
             
                $output .= '<li class="list-group-item">'.'No results'.'</li>';
            }
           
            return $output;
        }
    }
    
    
    public function searchResult(Request $request)
        {
        
             $search_value =  $request['search'];

             $videos_count = Video::where('title', 'LIKE', '%'.$search_value.'%')->count();
        
             $ppv_videos_count = PpvVideo::where('title', 'LIKE', '%'.$search_value.'%')->count();
        
             $video_category_count = VideoCategory::where('name', 'LIKE', '%'.$search_value.'%')->count();
        
             $ppv_category_count = PpvCategory::where('name', 'LIKE', '%'.$search_value.'%')->count();

            if ($videos_count > 0) {

              $videos = Video::where('title', 'LIKE', '%'.$search_value.'%')->orderBy('created_at', 'desc')->paginate(9);

             } else {
                $videos = 0;
            } 
        
            if ($ppv_videos_count > 0) {

              $ppv_videos = Video::where('title', 'LIKE', '%'.$search_value.'%')->orderBy('created_at', 'desc')->paginate(9);

             } else {
                $ppv_videos = 0;
            } 
        
            if ($video_category_count > 0) {

              $video_category = VideoCategory::where('name', 'LIKE', '%'.$search_value.'%')->orderBy('created_at', 'desc')->paginate(9);

             } else {
                $video_category = 0;
            }
       
            if ($ppv_category_count > 0) {
                
                $ppv_category = PpvCategory::where('name', 'LIKE', '%'.$search_value.'%')->orderBy('created_at', 'desc')->paginate(9);

             } else {
                $ppv_category = 0;
            }
       

             $data = array(
                'videos' => $videos,
                'ppv_videos' => $ppv_videos,
                'video_category' => $video_category,
                'ppv_category' => $ppv_category,
                'search_value' => $search_value
                );

            return View('search', $data);

        }
    
    public function SendOTP(Request $request, \Nexmo\Client $nexmo)
    {
        $mobile = $request->get('mobile');
        $request->session()->put('mobile',$mobile);
        $rcode = $request->get('ccode');
        $request->session()->put('mobile_ccode',$rcode);
        $request->session()->put('mobile_number',$mobile);
        
        $guest_email = $request->session()->get('register.email');
        
        $ccode = $rcode;
        $pin = mt_rand(100000, 999999);
        $string = str_shuffle($pin);
        $mobile_number = $ccode.$mobile;
        $user_count = VerifyNumber::where('number','=',$mobile_number)->count(); 
        $user_mobile_exist = User::where('email','!=',$email)->where('mobile','=',$mobile)->count();
        $user_id= VerifyNumber::where('number','=',$mobile_number)->first();   
        
        $basic  = new \Nexmo\Client\Credentials\Basic('8c2c8892', '05D2vuG2VbYw2tQZ');
        $client = new \Nexmo\Client($basic);
        
        if ($user_mobile_exist > 0 ){
             
              return response()->json([ 'status' => false, 'message' => 'This number already Exist, try with another number']
                );
             
        }
        elseif ( $user_count > 0  ) {
                        $user = VerifyNumber::find($user_id->id);
                        $user->otp = $string;
                        $user->number = $ccode.$mobile;
                        $user->save();
        //                        $nexmo->message()->send([
        //                                        'to' => $ccode.$mobile,
        //                                        'from' => '916381673242',
        //                                        'text' => 'Your Login OTP is'.$string
        //                        ]);
            
                    $verification = $client->verify()->start([ 
                                      'number' =>  $ccode.$mobile,
                                      'brand'  => 'Flicknexs ',
                                      'code_length'  => '4']);

                    $verification_id =$verification->getRequestId();
            
            
        //                $mails =  $guest_email;
        //                \Mail::send('emails.sms', array(
        //                            'otp' => $string
        //                ), function($message) use ($mails){
        //                            $message->from(AdminMail(),'Flicknexs');
        //                            $message->to($mails, "User")->subject('Verification OTP');
        //                        });

              return response()->json( ['status' => true,'verify'=>$verification_id,'message' => 'OTP has been sent to your number and Your Mail','mobile' => $mobile_number
            ]);
        
            
        } else {
                        $user = new VerifyNumber;
                        $user->otp = $string;
                        $user->number = $ccode.$mobile;
                        $user->save();
//                        $nexmo->message()->send([
//                                        'to' => $ccode.$mobile,
//                                        'from' => '916381673242',
//                                        'text' => 'Your Login OTP is'.$string
//                        ]);
                 $verification = $client->verify()->start([ 
                                  'number' =>  $ccode.$mobile,
                                  'brand'  => 'Flicknexs ',
                                  'code_length'  => '4']);

                 $verification_id =$verification->getRequestId();
            
             return response()->json(['status' => true,'verify'=>$verification_id,'message' => 'OTP has been sent to your number and Your Mail','mobile' => $mobile_number
            ]);
            
        }           
        } 
        
    
//    public function SendOTP(Request $request, \Nexmo\Client $nexmo)
//    {
//        $mobile = $request->get('mobile');
//        $pin = mt_rand(100000, 999999);
//        
//        $string = str_shuffle($pin);
//        $user_count = User::where('mobile','=',$mobile)->count();       
//        if ( $user_count > 0 ){ 
//            
//            $user = User::where('mobile','=',$mobile)->first();
//            $user->otp = $string;
//            $user->save();
//            
//            $response = $nexmo->message()->send([
//                    'to' => "91".$mobile,
//                    'from' => '916381673242',
//                    'text' => 'Your Login OTP is'.$string
//                ]);
//            
//            
//           
//        
//            $data = array(
//                'mobile'=>$mobile
//            );
//            
//            return View('auth.otp',$data);
//            
//        } else {
//            
//             return Redirect::back()->withErrors('Invalid Number');
//        }
//        
//     }
    
    public function mobileLogin()
    {
        
         return View('auth.mobile-login');
    }
    
    
    public function LatestVideos()
    {
        $date = \Carbon\Carbon::today()->subDays(25);
//            'videos' => Video::where('created_at', '>=', $date)->orderBy('created_at', 'DESC')->simplePaginate(10),
//        
        $latest_videos = Video::where('active', '=', '1')->where('created_at','>=',$date)->get();
        $data = array(
            'latest_videos'=>$latest_videos
        );
        
        return View('latestvideo',$data);
    }
    public function LanguageVideo($lanid ,$lan){
        $language_videos = Video::where('language', '=', $lanid)->get();
        $data = array(
            'lang_videos'=>$language_videos
        );
        
        return View('languagevideo',$data);
    }
    
    
    public function StripeSubscription(Request $request){
        $user = Auth::user();
        $plan_name = $request->get('plan_name');
        $request->session()->put('become_plan', $plan_name);
            $data = array(
                'plan_name'=>$plan_name
            );
        
            return view('register.become_subscription', [
                                'intent' => $user->createSetupIntent()
            ]);
        
    }
    
    public function verifyOtp(Request $request)
    {
        
        $otp = $request->get('otp');
        $mobile = $request->get('number');
        $verify_id = $request->get('verify_id');
        $user_count = VerifyNumber::where('number','=',$mobile)->where('otp','=',$otp)->count();
        $basic  = new \Nexmo\Client\Credentials\Basic('8c2c8892', '05D2vuG2VbYw2tQZ');
        $client = new \Nexmo\Client($basic);
        
        $request_id = $verify_id;
        $verification = new \Nexmo\Verify\Verification($request_id);
        $result = $client->verify()->check($verification, $otp);
    
        return response()->json(
                [
                    'status' => true,
                    'message' => 'Your Mobile number Verification is Success',
                ]
            );        
      
    }   
    public function stripes(Request $request)
        {
                $user = Auth::User();

                 if ($user->stripe_id == NULL)
                 {
                  $stripeCustomer = $user->createAsStripeCustomer();

                 }
               $plan_name = $request->get('plan_name');
               $request->session()->put('become_plan', $plan_name);
                return view('register.become', [
                                    'intent' => $user->createSetupIntent()
                                    ,compact('data')
                ]);

        }
    
        public function PaypalSubscription(Request $request){
                $plan_id = $request->get('plan_id');
                $plan_details = PaypalPlan::where('plan_id','=',$plan_id)->first();
         
                $data = array(
                        'plan_name' => $plan_details->name,
                        'plan_price' => $plan_details->price,
                        'plan_id' => $plan_details->plan_id
                    );
                return view('register.paypal_subscription',$data);
        }
    
          public function ViewTrasaction(){   

             return view('paypal_billing');
          }  
    
          public function ViewStripeTrasaction(){   

             return view('stripe_transactions');
          }
    
    public function CancelPaypal(Request $request){
        
            $subscription_id = Auth::user()->paypal_id;
            $user = Auth::user();
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://api.paypal.com/v1/billing/subscriptions/'.$subscription_id.'/cancel');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = GetAccessToken();
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
            \Mail::send('emails.paypal_cancel', array(
                        'name' => $user->username
            ), function($message) use ($user){
                $message->from(AdminMail(),'Flicknexs');
                $message->to($user->email, $user->username)->subject('Subscription Renewal');
            });
        return redirect('/paypal/billings-details');
        
    }
    
    public function ViewPaypal(){   
            $subscription_id = Auth::user()->paypal_id;
            $url = "https://api.paypal.com/v1/billing/subscriptions/".$subscription_id;
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $headers = array(
               "Content-Type: application/json",
               GetAccessToken(),
            );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            //for debug only!
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $resp = curl_exec($curl);
            curl_close($curl);
            $json = json_decode($resp);
            $status = $json->status;
               
            //            echo "<pre>"; print_r($json);
            //            exit;

        if ($status == 'ACTIVE'){ 
                $date1 = gmdate('c');
                $date2 = $json->billing_info->next_billing_time;
                $diff = abs(strtotime($date2) - strtotime($date1));
                $years = floor($diff / (365*60*60*24));
                $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
        
                $data = array(
                        'status'=>$status,
                        'start_time'=>$json->start_time,
                        'next_billing_date'=>$json->billing_info->next_billing_time,
                        'remaining_days'=>$days,
                        'response'=>$json,
                        'plan_id'=>$json->plan_id
                );
              
        } else {
               $data = array(
                        'status'=>$status,
                        'start_time'=>$json->start_time,
                        'next_billing_date'=>0,
                        'response'=>$json,
                        'remaining_days'=>0,
                        'plan_id'=>0
                );
        }
                return view('current_billing',$data);
    }
    
    public function Restrict(){
     
        return view('blocked');
    }

    public function StoreWatching(Request $request){
               $data = $request->all();
               if (Auth::user()){
                $user_id = Auth::user()->id;
                $video_id = $request->video_id;
                $duration = $request->duration;
                $currentTime = $request->currentTime;
                $watch_percentage = ($currentTime * 100 / $duration);
                $cnt = ContinueWatching::where("videoid",$video_id)->where("user_id",$user_id)->count();
                $get_cnt = ContinueWatching::where("videoid",$video_id)->where("user_id",$user_id)->first();
                if($cnt > 0 && $get_cnt->watch_percentage >= "99"){
                     ContinueWatching::where("videoid",$video_id)->where("user_id",$user_id)->delete();
                }
                if ($cnt == 0){
                    $video = new ContinueWatching;
                    $video->videoid = $request->video_id;
                    $video->user_id = $user_id;
                    $video->currentTime = $request->currentTime;
                    $video->watch_percentage = $watch_percentage;
                    $video->save();
                }else{
                    $cnt_watch = ContinueWatching::where("videoid",$video_id)->where("user_id",$user_id)->first();
                    $cnt_watch->currentTime = $request->currentTime;
                    $cnt_watch->watch_percentage = $watch_percentage;
                    $cnt_watch->save(); 
                }
            }
    }

    public function LikeVideo(Request $request){
       $video_id = $request->videoid;
       $like = $request->like;
       $user_id = $request->user_id;
       $video = LikeDisLike::where("video_id","=",$video_id)->where("user_id","=",$user_id)->get();
       $video_count = LikeDisLike::where("video_id","=",$video_id)->where("user_id","=",$user_id)->count();
       if ($video_count >0 ) {
          $video_new = LikeDisLike::where("video_id","=",$video_id)->where("user_id","=",$user_id)->first();
          $video_new->liked = $like;
          $video_new->video_id = $video_id;
          $video_new->save();
          $response = array(
            'status'   =>true
        );
      } else {
          $video_new = new LikeDisLike;
          $video_new->video_id = $video_id;
          $video_new->user_id = $user_id;
          $video_new->liked = $like;
          $video_new->save();
          $response = array(
            'status'   =>true
        );
      }  
             
    }

    public function DisLikeVideo(Request $request){
       $user_id = $request->user_id;
      $video_id = $request->videoid;
      $dislike = $request->dislike;
      $d_like = Likedislike::where("video_id",$video_id)->where("user_id",$user_id)->count();

      if($d_like > 0){
        $new_vide_dislike = Likedislike::where("video_id",$video_id)->where("user_id",$user_id)->first();
        if($dislike == 1){
          $new_vide_dislike->user_id = $request->user_id;
          $new_vide_dislike->video_id = $video_id;
          $new_vide_dislike->liked = 0;
          $new_vide_dislike->disliked = 1; 
          $new_vide_dislike->save(); 
        }else{
          $new_vide_dislike->user_id = $request->user_id;
          $new_vide_dislike->video_id = $video_id;
          $new_vide_dislike->disliked = 0;
          $new_vide_dislike->save(); 
        }
      }else{
        $new_vide_dislike = new Likedislike;
        $new_vide_dislike->user_id = $request->user_id;
        $new_vide_dislike->video_id = $video_id;
        $new_vide_dislike->liked = 0;
        $new_vide_dislike->disliked = 1;
        $new_vide_dislike->save(); 
      } 
             
    }
    
}

<?php

namespace App\Http\Controllers;
use \App\User as User;
use \Redirect as Redirect;
use Illuminate\Http\Request;
use URL;
use App\Test as Test;
use App\RecentView as RecentView;
use App\Setting as Setting;
use App\Series as Series;
use App\SeriesSeason as SeriesSeason;
use App\Plan as Plan;
use App\Page as Page;
use App\Cast as Cast;
use App\Slider as Slider;
use App\Wishlist as Wishlist;
use App\Favorite as Favorite;
use App\Watchlater as Watchlater;
use App\PpvVideo as PpvVideo;
use App\PpvPurchase as PpvPurchase;
use App\MobileSlider as MobileSlider;
use App\PpvCategory as PpvCategory;
use App\LiveStream as LiveStream;
use App\LiveCategory as LiveCategory;
use App\LivePurchase as LivePurchase;
use App\Subscription as Subscription;
use App\VerifyNumber as VerifyNumber;
use App\PaypalPlan as PaypalPlan;
use App\PaymentSetting as PaymentSetting;
use App\Episode as Episode;
use App\Video as Video;
use App\Country as Country;
use App\State as State;
use App\City as City;
use Nexmo;
use App\VideoCategory as VideoCategory;
use App\MoviesSubtitles as MoviesSubtitles;
use App\VideoResolution as VideoResolution;
use App\VideosSubtitle as VideosSubtitle;
use App\Language as Language;
use App\Subtitle as Subtitle;
use App\CouponPurchase as CouponPurchase;
use App\Coupon as Coupon;
use App\Tag as Tag;
use App\LikeDislike as Likedislike;
use App\Comment as Comment;
use Auth;
use Hash;
use DB;
use Illuminate\Support\Facades\Cache;
use Image;
use View;
use Validator;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg as FFMpeg;
use ProtoneMedia\LaravelFFMpeg\Support\FFProbe as FFProbe;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;
use FFMpeg\Coordinate\TimeCode;
use App\Http\Requests\StoreVideoRequest;
use App\Jobs\ConvertVideoForStreaming;
use Illuminate\Contracts\Filesystem\Filesystem;
use FFMpeg\Filters\Video\VideoFilters;
use Illuminate\Support\Str;
use Mail;
use Carbon\Carbon as Carbon;
use App\Playerui as Playerui;
use App\Audio as Audio;
use App\Artist as Artist;
use App\AudioCategory as AudioCategory;
use App\Audioartist as Audioartist;
use App\ContinueWatching as ContinueWatching;
use App\AudioAlbums as AudioAlbums;
use App\EmailTemplate;	
use App\SubscriptionPlan;
use App\Multiprofile;
use App\LanguageVideo;
use App\CategoryAudio;
use Session;
use Victorybiz\GeoIPLocation\GeoIPLocation;
use App\Geofencing;
use App\BlockVideo;
use App\BlockAudio;
use App\HomeSetting;
use App\Videoartist;
use App\Seriesartist;
use App\WelcomeScreen;
use App\CategoryVideo;
use App\MobileApp;
use App\SeriesCategory;
use App\SeriesLanguage;
use CPANEL;
use App\Deploy;
use App\LoggedDevice;
use Razorpay\Api\Api;
use App\AdsVideo;
use App\AdvertisementView;

class ApiAuthController extends Controller
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
      }
  }

  public function signup(Request $request)
  {
   
    $input = $request->all();
    $user_data = array('username' => $request->get('username'), 'email' => $request->get('email'), 'password' => $request->get('password'),'ccode' => $request->get('ccode'),'mobile' => $request->get('mobile') );

    $stripe_plan = SubscriptionPlan();
    $settings = Setting::first();
    if (isset($input['ccode']) && !empty($input['ccode'])) {
      $user_data['ccode'] = $input['ccode'];
    } else {
      $user_data['ccode'] = '';
    } 
        if (isset($input['mobile']) && !empty($input['mobile'])) {
      $user_data['mobile'] = $input['mobile'];
    } else {
      $user_data['mobile'] = '';
    } 
        if (isset($input['skip'])) {

      $skip = $input['skip'];
    } else {
      $skip = 0;
    } 

        if (!empty($input['referrer_code'])){
            $referrer_code = $input['referrer_code'];
        }
        
        if ( isset($referrer_code) && !empty($referrer_code) ) { 
            $referred_user = User::where('referral_token','=',$referrer_code)->first();
            $referred_user_id = $referred_user->id;
        } else {
            $referred_user_id =0;
        }

    $length = 10;
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $ref_token = substr(str_shuffle(str_repeat($pool, 5)), 0, $length);  
        $token = substr(str_shuffle(str_repeat($pool, 5)), 0, $length); 
    if (!empty($request->token)){
        $user_data['token'] =  $request->token;
    } else {
      $user_data['token'] =  '';
    }
        $path = URL::to('/').'/public/uploads/avatars/';
      $logo = $request->file('avatar');
            if($logo != '') {   
                  if($logo != ''  && $logo != null){
                   $file_old = $path.$logo;
                   if (file_exists($file_old)){
                       unlink($file_old);
                   }
               }
               $file = $logo;
               $avatar  = $file->getClientOriginalName();
               $file->move(public_path()."/uploads/avatars/", $file->getClientOriginalName());
            } else {
                $avatar  = 'default.png';
            }      
    if (!$settings->free_registration && $skip == 0) {
      $user_data['role'] = 'subscriber';
      $user_data['active'] = '1';
    } else {
                if($settings->activation_email):
                    $user_data['activation_code'] = Str::random(60);
                    $user_data['active'] = 0;
                endif;
      $user_data['role'] = 'registered';
    }
            if (isset($input['subscrip_plan'])) {
                $plan = $input['subscrip_plan'];
            }    
      $user = User::where('email', '=', $request->get('email'))->first();
      $username = User::where('username', '=', $request->get('username'))->first();
    if ($user === null && $username === null) {
      $user = new User($user_data);
      $user->ccode = $user_data['ccode'];
      $user->mobile = $user_data['mobile'];
      $user->avatar = $avatar;
      $user->password = Hash::make($request->get('password'));
            $user->referrer_id = $referred_user_id;
            $user->token = $input['token'];
      $user->referral_token = $ref_token;
      $user->active = 1;
      $user->save();
      $userdata = User::where('email', '=', $request->get('email'))->first();
      $userid = $userdata->id;
        send_password_notification('Notification From FLICKNEXS','Your Account  has been Created Successfully','Your Account  has been Created Successfully','',$userid);
            
    } else {
      if($user != null){
        $response = array('status'=>'false','message' => 'Email id Already Exists');
        return response()->json($response, 200);
      }else{
        $response = array('status'=>'false','message' => 'Username Already Exists');
        return response()->json($response, 200);
      }

    }
    try {
      if($settings->free_registration && $settings->activation_email == 1){
        $email = $input['email'];
        $uname = $input['username'];
        Mail::send('emails.verify', array('activation_code' => $user->activation_code, 'website_name' => $settings->website_name), function($message) use ($email,$uname) {
          $message->to($email,$uname)->subject('Verify your email address');
        });
        $response = array('status'=>'true','message' => 'Registered Successfully.');
      } else {
                
        if(!$settings->free_registration  && $skip == 0){

          $paymentMode = $request->payment_mode;

            if($paymentMode == "Razorpay"){
                
            try{
              $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
              $countryName = $geoip->getCountry();
              $regionName = $geoip->getregion();
              $cityName = $geoip->getcity();
              
                                                                                // Store the Razorpay subscription detials
              $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);
              $subscription = $api->subscription->fetch($request->razorpay_subscription_id);
              $plan_id      = $api->plan->fetch($subscription['plan_id']);
          
              $Sub_Startday = date('d/m/Y H:i:s', $subscription['current_start']); 
              $Sub_Endday = date('d/m/Y H:i:s', $subscription['current_end']); 
              $trial_ends_at = Carbon::createFromTimestamp($subscription['current_end'])->toDateTimeString(); 

                  Subscription::create([
                  'user_id'        =>  $userid,
                  'name'           =>  $plan_id['item']->name,
                  'price'          =>  $plan_id['item']->amount / 100,   // Amount Paise to Rupees
                  'stripe_id'      =>  $subscription['id'],
                  'stripe_status'  =>  $subscription['status'],
                  'stripe_plan'    =>  $subscription['plan_id'],
                  'quantity'       =>  $subscription['quantity'],
                  'countryname'    =>  $countryName,
                  'regionname'     =>  $regionName,
                  'cityname'       =>  $cityName,
                  'PaymentGateway' =>  'Razorpay',
                  'trial_ends_at'  =>  $trial_ends_at,
                  'ends_at'        =>  $trial_ends_at,
              ]);
          
              User::where('id',$userid)->update([
                  'role'                  =>  'subscriber',
                  'stripe_id'             =>  $subscription['id'] ,
                  'subscription_start'    =>  $Sub_Startday,
                  'subscription_ends_at'  =>  $Sub_Endday,
              ]);
          
                return $response = array('status'=>'true',
                'message' => 'Registered Successfully.');
            }
          catch (\Exception $e){
            return response()->json([
              'status'  => 'false',
              'Message' => 'Error,While Storing the data on Serve Error'], 200);
          }
            }
            else{
                     $payment_type = $input['payment_type'];
                     $paymentMethod = $input['py_id'];

                    if ( $payment_type == "recurring") {
                             $plan = $input['plan']; 
                            $user->newSubscription($stripe_plan, $plan)->create($paymentMethod);
                                        $user = User::find($user->id);
                                        $user->role = 'subscriber';
                                        $user->payment_type = 'recurring';
                                        $user->card_type = 'stripe';
                                        $user->save();
                            $email = $input['email'];
                            $uname = $input['username'];

                            Mail::send('emails.verify', array('activation_code' => $user->activation_code, 'website_name' => $settings->website_name), function($message) use ($email,$uname) {
                                $message->to($email,$uname)->subject('Verify your email address');
                            });
                                $response = array(
                                'status' => 'true',
                                'message' => 'Registered Successfully.',
                                'user_id' =>  $userid
                            );
                        
                    } else  {
                            $price = $input['amount'];
                            $plan = $input['plan'];              
                            $plan_details = SubscriptionPlan::where("plan_id","=",$plan)->first();
                            $next_date = $plan_details->days;
                            $current_date = date('Y-m-d h:i:s');
                            $date = Carbon::parse($current_date)->addDays($next_date);
                            $sub_price = $plan_details->price;
                            $sub_total =  $sub_price - DiscountPercentage();
                            $user = User::find($user->id);
                            if ( NewSubscriptionCoupon() == 1 ) {
                                     $charge = $user->charge( $sub_total * 100, $input['py_id']); 
                                    if($charge->id != ''){
                                           $user->role = 'subscriber';
                                            $user->payment_type = 'one_time';
                                            $user->card_type = 'stripe';
                                            $user->save();
                                             DB::table('subscriptions')->insert([
                                                    ['user_id' => $user->id,'name' =>$input['username'],
                                                      'days' => $plan_details->days, 'price' => $plan_details->price,'stripe_id'=>$user->card_type,
                                                     'stripe_status' => 'active',
                                                     'stripe_plan' => $plan, 
                                                    'ends_at' => $date,'created_at' => $current_date]
                                                ]);
                                        $email = $input['email'];
                                        $uname = $input['username'];
                                        Mail::send('emails.verify', array('activation_code' => $user->activation_code, 'website_name' => $settings->website_name), function($message) use ($email,$uname) {
                                            $message->to($email,$uname)->subject('Verify your email address');
                                        });
                                          $response = array(
                                                'status' => 'true',
                                                'message' => 'Registered Successfully.'
                                        );
                                     } else {
                                          $response = array(
                                                'status' => 'false'
                                            );
                                    }
                                 } else {
                                        $charge = $user->charge( $sub_price * 100, $input['py_id']); 
                                        if($charge->id != ''){
                                               $user->role = 'subscriber';
                                                $user->payment_type = 'one_time';
                                                $user->card_type = 'stripe';
                                                $user->save();
                                                DB::table('subscriptions')->insert([
                                                    ['user_id' => $user->id,'name' =>$input['username'],
                                                       'days' => $plan_details->days, 'price' => $plan_details->price,'stripe_id'=>$user_details->stripe_id,
                                                     'stripe_status' => 'active',
                                                     'stripe_plan' => $plan, 
                                                    'ends_at' => $date,'created_at' => $current_date,'updated_at' => $current_date]
                                                ]);

                                            $email = $input['email'];
                                            $uname = $input['username'];
                                            Mail::send('emails.verify', array('activation_code' => $user->activation_code, 'website_name' => $settings->website_name), function($message) use ($email,$uname) {
                                                $message->to($email,$uname)->subject('Verify your email address');
                                            });
                                              $response = array(
                                                    'status' => 'true',
                                          'message' => 'Registered Successfully.'
                                            );
                                         } else {
                                              $response = array(
                                                    'status' => 'false'
                                                );
                                        }
                                     }
                       }
                       $plan_details = SubscriptionPlan::where("plan_id","=",$plan)->first();
                       $next_date = $plan_details->days;
                       $current_date = date('Y-m-d h:i:s');
                       $date = Carbon::parse($current_date)->addDays($next_date);
                      Mail::send('emails.subscriptionmail', array(
                               /* 'activation_code', $user->activation_code,*/
                                'name'=>$user->username, 
                          'days' => $plan_details->days, 
                          'price' => $plan_details->price,
                          'plan_id' => $plan_details->plan_id, 
                          'ends_at' => $date,
                          'created_at' => $current_date), function($message) use ($request,$user) {
                                                $message->from(AdminMail(),'Flicknexs');
                                                //  $message->to($request->session()->get('register.email'), $user->username)->subject($request->get('subject'));
                                                $message->to($user->email, $user->username)->subject($request->get('subject'));
                                            });



                        send_password_notification('Notification From FLICKNEXS','Your Payment has been done Successfully','Your Your Payment has been done Successfully','',$user->id);
        }
      }
      else{
             $response = array('status'=>'true',
                                'message' => 'Registered Successfully.');
        }
      }
            
          
            
    } catch(Exception $e){
      $user->delete();
      $response = array('status'=>'false');
    }
        return response()->json($response, 200);
}



  /**
  * Login user and create token
  *
  * @param  [string] email
  * @param  [string] password
  * @param  [boolean] remember_me
  * @return [string] access_token
  * @return [string] token_type
  * @return [string] expires_at
  */
  public function login(Request $request)
  {

    $settings = Setting::first();
    $userIp = $request->user_ip;
    $device_name = $request->device_name;
    $email = $request->email;
    $token = $request->token;
    $users = User::where('email',$email)->first();
   
    
    $email_login = array(
      'email' => $request->get('email'),
      'password' => $request->get('password')
    );
    $username_login = array(
      'username' => $request->get('username'),
      'password' => $request->get('password')
    );
    $mobile_login = array(
      'mobile' => $request->get('mobile'),
      'otp' => $request->get('otp')
    );

    if(!empty($users)){

    $user_id = $users->id;
    $adddevice = new LoggedDevice;
    $adddevice->user_id = $user_id;
    $adddevice->user_ip = $userIp;
    $adddevice->device_name = $device_name;
    $adddevice->save();

    }
  
    if ( Auth::attempt($email_login) || Auth::attempt($username_login) || Auth::attempt($mobile_login)  ){

      if($settings->free_registration && !Auth::user()->stripe_active){
        // Auth::user()->role = 'registered';
        // print_r(Auth::user()->role); exit();
        if(Auth::user()->role == 'registered'){
        $user = User::find(Auth::user()->id);
        $user->role = 'registered';
        $user->token = $token;
        $user->save();
        }else if(Auth::user()->role == 'admin'){
        // print_r(Auth::user()->role); exit();

        $user = User::find(Auth::user()->id);
        $user->role = 'admin';
        $user->token = $token;
        $user->save();
        }else if(Auth::user()->role == 'subscriber'){
          // print_r(Auth::user()->role); exit();
          $user = User::find(Auth::user()->id);
          $user->role = 'subscriber';
          $user->token = $token;
          $user->save();
        }
      }

      if(Auth::user()->role == 'subscriber' || (Auth::user()->role == 'admin' || Auth::user()->role == 'demo') || (Auth::user()->role == 'registered') ):
        $id = Auth::user()->id;
        $role = Auth::user()->role;
        $username = Auth::user()->username;
        $password = Auth::user()->password;
        $email = Auth::user()->email;
        $mobile = Auth::user()->mobile;
        $avatar = Auth::user()->avatar;
        $user_details = array([
          'user_id'=>$id,
          'role'=>$role,
          'username'=>$username,
          'email'=>$email,
          'mobile'=>$mobile,
          'avatar'=>URL::to('/').'/public/uploads/avatars/'.$avatar
        ] );

      $redirect = ($request->get('redirect', 'false')) ? $request->get('redirect') : '/';
      if(Auth::user()->role == 'demo' && Setting::first()->demo_mode != 1){
        Auth::logout();

        $response = array('message' => 'Sorry, demo mode has been disabled', 'note_type' => 'error');
        return response()->json($response, 200);
      } elseif($settings->free_registration && $settings->activation_email && Auth::user()->active == 0) {
        Auth::logout();

        $response = array('message' => 'Please make sure to activate your account in your email before logging in.', 'note_type' => 'error','status'=>'verifyemail');
        return response()->json($response, 200);
      } else {

        $response = array('message' => 'You have been successfully logged in.', 'note_type' => 'success','status'=>'true','user_details'=> $user_details);
        return response()->json($response, 200);
      }
    else:
      $username = Auth::user()->username;

      $response = array('message' => 'Uh oh, looks like you don\'t have an active subscription, please renew to gain access to all content', 'note_type' => 'error');
      return response()->json($response, 200);
    endif;

  } else {
    $count = User::where('email', '=', $request->get('email'))->count();
    if($count > 0){
      $response = array('message' => 'Password Mismatch.', 'note_type' => 'error','status'=>'mismatch');
      return response()->json($response, 200);
    }else{
      $response = array('message' => 'Invalid Email, please try again.', 'note_type' => 'error','status'=>'false');
      return response()->json($response, 200);
    }
  }  
  }

  public function resetpassword(Request $request)
  {
    $user_email = $request->email;
    $user = User::where('email', $user_email)->count();

       
    if($user > 0){
      
      $verification_code = mt_rand(100000, 999999);
      $email = $user_email;
      Mail::send('emails.resetpassword', array('verification_code' => $verification_code), function($message) use ($email) {
        $message->to($email)->subject('Verify your email address');
      });
      
            
                $data = DB::table('password_resets')->where('email', $user_email)->first();
                
                if(empty($data)){
                    DB::table('password_resets')->insert(['email' => $user_email, 'verification_code' => $verification_code]);
                  
                }else{
                    DB::table('password_resets')->where('email', $user_email)->update(['verification_code' => $verification_code]);
                }
                $response = array(
                    'status'=>'true',
                    'email' => $user_email,
                    'verification_code'=>$verification_code
                );
            }else{
                $response = array(
                    'status'=>'false',
                    'message'=>'Invalid email'
                );
    }
    return response()->json($response, 200);

  }
    
    
     public function ViewStripe(Request $request){
         
            $user_id = $request->user_id;
            /*$user_details = Subscription::where("user_id","=",$user_id)->orderby("created_at","desc")->first();*/
             $subscriptions = Subscription::where('user_id',$user_id)->get();
            $stripe_id =  $user_details->stripe_id;
            $stripe_status =  $user_details->stripe_status;
            $stripe_Plan =  $user_details->stripe_plan;
        
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
                 
            $stirpe_subscription = $stripe->subscriptions->retrieve(
                  $stripe_id,
                  []
                );
             $response = array(
                        'stirpe_details' => $stirpe_subscription,
                        //'stripe_status' => $user_details->stripe_status,
                        'stripe_Plan' => $stripe_Plan,
                        'stripe_status' => $stripe_status
                );
         
            return response()->json($response, 200);
    }

  public function updatepassword(Request $request)
  {
    $user_email = $request->email;       
    $verification_code = $request->verification_code;
    if (DB::table('password_resets')->where('email', '=', $user_email)->where('verification_code', '=', $verification_code)->exists()) {

      $user_id = User::where('email', '=', $user_email)->first();
      $user = User::find($user_id->id);
      $user->password = Hash::make($request->password);
      $user->save();
          send_password_notification('Notification From Flicknexs','Password has been Updated Successfully','Password Update Done','',$user_id->id);
      $response = array(
        'status'=>'true',
        'message'=>'Password changed successfully.'
      );
    }else{
      $response = array(
        'status'=>'false',
        'message'=>'Invalid Verification code.'
      );    
    }
    return response()->json($response, 200);
  }


  public function categoryvideos(Request $request)
  {

    $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
    $countryName =  $geoip->getCountry();
    $getfeching = Geofencing::first();

    $block_videos=BlockVideo::where('country_id',$countryName)->get();

        if(!$block_videos->isEmpty()){
          foreach($block_videos as $block_video){
              $blockvideos[]=$block_video->video_id;
          }
      }                        
      $blockvideos[]='';

    //$channelid = $request->channelid;
       
    $videocategories = VideoCategory::select('id','image')->get()->toArray();
    $myData = array();
    foreach ($videocategories as $key => $videocategory) {
      $videocategoryid = $videocategory['id'];
      $genre_image = $videocategory['image'];

      // $videos= Video::where('video_category_id',$videocategoryid)->where('active','=',1)->orderBy('created_at', 'desc');
      //     if($getfeching !=null && $getfeching->geofencing == 'ON'){
      //         $videos = $videos->whereNotIn('id',$blockvideos);
      //       }
      $videos= Video::Join('categoryvideos','categoryvideos.video_id','=','videos.id')->where('categoryvideos.category_id',$videocategoryid)
      ->where('active','=',1)->where('status','=',1)->where('draft','=',1)->orderBy('videos.created_at', 'desc')->get()->map(function ($item) {
        $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
        $item['video_url'] = URL::to('/').'/storage/app/public/';
        $item['category_name'] = VideoCategory::where('id',$item->category_id)->pluck('slug')->first();

        return $item;
      });
      // $videos = $videos->get()->map(function ($item) {
      //     $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
      //     $item['video_url'] = URL::to('/').'/storage/app/public/'.$item->video_url;
      //     return $item;
      //   });

      // $categorydetails = VideoCategory::where('id','=',$videocategoryid)->first();

      // if(count($videos) > 0){
      //   $msg = 'success';
      // }else{
      //   $msg = 'nodata';
      $main_genre = CategoryVideo::Join('video_categories','video_categories.id','=','categoryvideos.category_id')
      ->get('name');
      foreach($main_genre as $value){
        $category[] = $value['name']; 
      }
      if(!empty($category)){
      $main_genre = implode(",",$category);
      }else{
        $main_genre = "";
      }
      if(count($videos) > 0){
        $msg = 'success';
      }else{
        $msg = 'nodata';
      }
      $myData[] = array(
        // "genre_name"   => $categorydetails->name,
        // "genre_id"   => $videocategoryid,
        // "genre_image"   => URL::to('/').'/public/uploads/videocategory/'.$genre_image,
        "message" => $msg,
        'gener_name' =>  VideoCategory::where('id',$videocategoryid)->pluck('name')->first(),
        'gener_id' =>  VideoCategory::where('id',$videocategoryid)->pluck('id')->first(),
        "videos" => $videos
      );
    }

      // $videos = Video::select('videos.*','video_categories.name as categories_name')
      // ->Join('categoryvideos','categoryvideos.video_id','=','videos.id')
      // ->Join('video_categories','video_categories.id','=','categoryvideos.category_id')
      // // ->where('categoryvideos.category_id',$videocategoryid)
      // ->where('active','=',1)->where('status','=',1)->where('draft','=',1)->orderBy('videos.created_at', 'desc')->get()->map(function ($item) {
      //   $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
      //   $item['video_url'] = URL::to('/').'/storage/app/public/';
      //   return $item;
      // });
      // if(count($videos) > 0){
      //   $msg = 'success';
      // }else{
      //   $msg = 'nodata';
      // }

    $response = array(
      'status' => 'true',
      'genre_movies' => $myData,
      'main_genre' => $msg,
      'main_genre' => $main_genre,

    );
    return response()->json($response, 200);
  }


  public function changepassword(Request $request)
  {
    $user_email = $request->email;    
    $user_id = $request->user_id;

    $user = User::where('email', $user_email)->where('id', $user_id)->count();

    if($user > 0){

      $verification_code = mt_rand(100000, 999999);


      Mail::send('resetpassword', array('verification_code' => $verification_code), function($message) use ($request)  {
        $message->to($request->get('email'))->subject('Verify your email address');
      });

      $data = DB::table('password_resets')->where('email', $user_email)->first();
      if(empty($data)){
        DB::table('password_resets')->insert(['email' => $user_email, 'verification_code' => $verification_code]);
      }else{
        DB::table('password_resets')->where('email', $user_email)->update(['verification_code' => $verification_code]);
      }
      $response = array(
        'status'=>'true',
        'email' => $user_email,
        'verification_code'=>$verification_code
      );
    }else{
      $response = array(
        'status'=>'false',
        'message'=>'Invalid email'
      );
    }
    return response()->json($response, 200);
  }


public function verifyandupdatepassword(Request $request)
  {
    $user_email = $request->email;       
    $old_password = $request->old_password;

    $user = User::where('email', $user_email)->count();

    if($user > 0){
      $userdata = User::where('email', $user_email)->first();
      $userhashpassword = $userdata->password;
      if ( Hash::check($old_password, $userhashpassword) ) {

        $userdetail = User::where('email', '=',$user_email)->first();
        $user_id = $userdetail->id;
        $user = User::find($user_id);

        $user->password = $request->password;
        $user->save();

        $response = array(
          'status'=>'true',
          'message'=>'Password changed successfully.'
        );
                  send_password_notification('Notification From Flicknexs','Password has been Updated Successfully','Password Update Done','',$user_id);

      } else {
        $response = array(
          'status'=>'false',
          'message'=>'Check your old password.'
        ); 
      }
    }
    else {
      $response = array(
        'status'=>'false',
        'message'=>'User Email Not exists.'
      ); 
    }
    return response()->json($response, 200);
  }

  public function latestvideos()
  {
    $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
    $countryName =  $geoip->getCountry();
    $getfeching = Geofencing::first();

    $block_videos=BlockVideo::where('country_id',$countryName)->get();

        if(!$block_videos->isEmpty()){
          foreach($block_videos as $block_video){
              $blockvideos[]=$block_video->video_id;
          }
      }                        
      $blockvideos[]='';

    $latestvideos = Video::where('active','=',1)->where('status','=', 1)->orderBy('created_at', 'desc');
          if($getfeching !=null && $getfeching->geofencing == 'ON'){
            $latestvideos = $latestvideos->whereNotIn('id',$blockvideos);
            }
    $latestvideos =$latestvideos->get()->map(function ($item) {
        $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
        $item['video_url'] = URL::to('/').'/storage/app/public/';
        return $item;
      });

      $response = array(
        'status'=>'true',
        'latestvideos' => $latestvideos
      ); 
      return response()->json($response, 200);
    
  }


  public function categorylist()
  {
    $channellist = VideoCategory::get()->map(function ($item) {
        $item['image_url'] = URL::to('/').'/public/uploads/videocategory/'.$item->image;
        return $item;
      });
    if(count($channellist) > 0){
      $response = array(
        'status'=>'true',
        'categorylist' => $channellist
      ); 
      return response()->json($response, 200);
    }else{
      $response = array(
        'status'=>'true',
        'categorylist' => []
      ); 
      return response()->json($response, 200);
    }
  }
    
  public function channelvideos(Request $request)
  {
    $channelid = $request->channelid;


    $videocategories = VideoCategory::select('id','image')->where('id','=',$channelid)->get()->toArray();
    $myData = array();

    $videos_category= Video::Join('categoryvideos','categoryvideos.video_id','=','videos.id')
    // ->Join('video_categories','video_categories.id','=',$channelid)
    ->where('categoryvideos.category_id',$channelid)
    ->where('active','=',1)->where('status','=',1)->orderBy('videos.created_at', 'desc')->get()->map(function ($item) {
      $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
      $item['video_url'] = URL::to('/').'/storage/app/public/';
      return $item;
    });
    // 
    
    foreach ($videocategories as $key => $videocategory) {
      $videocategoryid = $videocategory['id'];
      $genre_image = $videocategory['image'];
      $videos= Video::Join('categoryvideos','categoryvideos.video_id','=','videos.id')->where('categoryvideos.category_id',$videocategoryid)
      ->where('active','=',1)->where('status','=',1)->orderBy('videos.created_at', 'desc')->get()->map(function ($item) {
        $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
        $item['video_url'] = URL::to('/').'/storage/app/public/';
        return $item;
      });
      $categorydetails = VideoCategory::where('id','=',$videocategoryid)->first();

      if(count($videos_category) > 0){
        $msg = 'success';
        $status = 'True';
      }else{
        $msg = 'nodata';
        $status = 'False';
      }
      if(count($videos) > 0){
        $msg = 'success';
        $status = 'True';
      }else{
        $msg = 'nodata';
        $status = 'False';
      }
      $myData[] = array(
        "genre_name"   => $categorydetails->name,
        "genre_id"   => $videocategoryid,
        "genre_image"   => URL::to('/').'/public/uploads/videocategory/'.$genre_image,
        "message" => $msg,
        "videos" => $videos,
        "videos_category"   => $videos_category,
      );

    }

    $videos_cat = VideoCategory::where('id','=',$channelid)->get();

    $response = array(
      'status' => $status ,
      'main_genre' => $videos_cat[0]->name,
      'categoryVideos' => $videos
    );
    return response()->json($response, 200);
  }

  public function videodetail(Request $request)
  {
    $videoid = $request->videoid;

      
    $current_date = date('Y-m-d h:i:s a', time()); 
    $videodetail = Video::where('id',$videoid)->get()->map(function ($item) {
        $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
        $item['video_url'] = URL::to('/').'/storage/app/public/';
        $item['reelvideo_url'] = URL::to('/').'/public/uploads/reelsVideos/'.$item->reelvideo;
        $item['pdf_files_url'] = URL::to('/').'/public/uploads/videoPdf/'.$item->pdf_files;
        $item['mobile_image_url'] = URL::to('/').'/public/uploads/images/'.$item->mobile_image;
        $item['tablet_image_url'] = URL::to('/').'/public/uploads/images/'.$item->tablet_image;

        $ads_videos = AdsVideo::where('ads_videos.video_id',$item->id)
            ->join('advertisements', 'ads_videos.ads_id', '=', 'advertisements.id')
            ->first();

        $ads_mid_time  =  gmdate("H:i:s", $item->duration/2) ;
        $ads_Post_time  = "00:00:00" ;
        $ads_pre_time   =  gmdate("H:i:s", $item->duration - 1) ;

        $item['ads_url'] = $ads_videos ? URL::to('/').'/public/uploads/AdsVideos/'.$ads_videos->ads_video :  " " ;
        $item['ads_position'] = $ads_videos ? $ads_videos->ads_position : " ";

        $item['pre_position_time'] = $ads_videos != null && $ads_videos->ads_position == 'pre' ? $ads_pre_time  : "0";
        $item['mid_position_time'] = $ads_videos != null  && $ads_videos->ads_position == 'mid'  ? $ads_mid_time  : "0";
        $item['post_position_time'] =$ads_videos != null  && $ads_videos->ads_position == 'post' ? $ads_Post_time  : "0";
        $item['ads_seen_status'] = $item->ads_status;
        return $item;
      });
      // $skip_time = ContinueWatching::where('user_id',$request->user_id)->where('videoid','=',$videoid)->pluck('skip_time')->max();
      $skip_time = ContinueWatching::orderBy('created_at', 'DESC')->where('user_id',$request->user_id)->where('videoid','=',$videoid)->first();
// print_r($skip_time->skip_time);exit();
      if(!empty($skip_time)){
        $skip_time = $skip_time->skip_time;
      // if(!empty($skiptime[0])){
        // $skip_time = $skiptime[0];
      }else{
        $skip_time = 0;
      }
      // }
      if ( isset($request->user_id) && $request->user_id != '' ) { 
            $user_id = $request->user_id;
            $ppv_exist = PpvPurchase::where('video_id',$videoid)->where('user_id',$user_id)->where('to_time','>',$current_date)->count();
      //Wishlilst
      $cnt = Wishlist::select('video_id')->where('user_id','=',$user_id)->where('video_id','=',$videoid)->count();
      $wishliststatus =  ($cnt == 1) ? "true" : "false";
      //Watchlater
      $cnt1 = Watchlater::select('video_id')->where('user_id','=',$user_id)->where('video_id','=',$videoid)->count();
      $watchlaterstatus =  ($cnt1 == 1) ? "true" : "false";

       //Favorite
      $cnt2 = Favorite::select('video_id')->where('user_id','=',$user_id)->where('video_id','=',$videoid)->count();
      $favoritestatus =  ($cnt2 == 1) ? "true" : "false";

      //Continue Watchings
      $cnt4 = ContinueWatching::select('currentTime')->where('user_id','=',$user_id)->where('videoid','=',$videoid)->count();
      if($cnt4 == 1){
      $get_time = ContinueWatching::select('currentTime')->where('user_id','=',$user_id)->where('videoid','=',$videoid)->get();
      $curr_time = $get_time[0]->currentTime;
    }else{
        $curr_time = '00';
    }

      $userrole = User::where('id','=',$user_id)->first()->role;
      $status = 'true';

      $like_data = LikeDisLike::where("video_id","=",$videoid)->where("user_id","=",$user_id)->where("liked","=",1)->count();
      $dislike_data = LikeDisLike::where("video_id","=",$videoid)->where("user_id","=",$user_id)->where("disliked","=",1)->count();
      $favoritestatus = Favorite::where("video_id","=",$videoid)->where("user_id","=",$user_id)->count();
      $like = ($like_data == 1) ? "true" : "false";
      $dislike = ($dislike_data == 1) ? "true" : "false";
      $favorite = ($favoritestatus > 0) ? "true" : "false";
    } else{
      $wishliststatus = 'false';
      $watchlaterstatus = 'false';
      $favorite = 'false';
      $ppv_exist = 0;
      $curr_time = '00';
      $userrole = '';
      $status = 'true';
      $like = "false";
      $dislike = "false";
    }
        
    if ($ppv_exist > 0) {

          $ppv_time_expire = PpvPurchase::where('user_id','=',$user_id)->where('video_id','=',$videoid)->pluck('to_time');

          if ( $ppv_time_expire > $current_date ) {

              $ppv_video_status = "can_view";

          } else {
                $ppv_video_status = "expired";
          }

    } else {
          $ppv_video_status = "pay_now";
    }


         $videos_cat_id = Video::where('id','=',$videoid)->pluck('video_category_id');
        //  $videos_cat = VideoCategory::where('id','=',$videos_cat_id)->get();
         $moviesubtitles = MoviesSubtitles::where('movie_id',$videoid)->get();
        $main_genre = CategoryVideo::Join('video_categories','video_categories.id','=','categoryvideos.category_id')
          ->where('video_id',$videoid)->get('name');
          foreach($main_genre as $value){
            $category[] = $value['name']; 
          }
          if(!empty($category)){
          $main_genre = implode(",",$category);
          }else{
            $main_genre = "";
          }
        // $main_genre = CategoryVideo::Join('video_categories','video_categories.id','=','categoryvideos.category_id')
          $languages = LanguageVideo::Join('languages','languages.id','=','languagevideos.language_id')
          ->where('languagevideos.video_id',$videoid)->get('name');
          // echo "<pre>"; print_r($languages);exit;

          foreach($languages as $value){
            $language[] = $value['name']; 
          }
          if(!empty($language)){
          $languages = implode(",",$language);
          }else{
            $languages = "";
          }


    if(\App\AdsVideo::where('video_id',$videoid)->exists()){
        $ads_id = \App\AdsVideo::where('video_id',$videoid)->first()->ads_id;
        $videoads = \App\Advertisement::find($ads_id)->ads_path;
    }else{
        $videoads = '';
    }

    $response = array(
      'status' => $status,
      'wishlist' => $wishliststatus,
      'curr_time' => $curr_time,
      'ppv_video_status' => $ppv_video_status,
      'watchlater' => $watchlaterstatus,
      'favorite' => $favorite                                 ,
      'ppv_exist' => $ppv_exist,
      'userrole' => $userrole,
      'like' => $like,
      'dislike' => $dislike,
      'skiptime' => $skip_time,
      // 'shareurl' => URL::to('channelVideos/play_videos').'/'.$videoid,
      'shareurl' => URL::to('category/videos').'/'.$videodetail[0]->slug,
      'videodetail' => $videodetail,
      'videossubtitles' => $moviesubtitles,
      'main_genre' => $main_genre,
      'languages' => $languages,
      'videoads' => $videoads
    );

    return response()->json($response, 200);
  }

  public function livestreams()
  {
    // $livecategories = LiveCategory::select('id','image')->get()->toArray();
    
    // $videos_cat_id = Video::where('id','=',$videoid)->pluck('video_category_id');
    //  $videos_cat = VideoCategory::where('id','=',$videos_cat_id)->get();
    //  $moviesubtitles = MoviesSubtitles::where('movie_id',$videoid)->get();
    // $main_genre = CategoryVideo::Join('video_categories','video_categories.id','=','categoryvideos.category_id')
    //   ->where('video_id',$videoid)->get('name');
    //   foreach($main_genre as $value){
    //     $category[] = $value['name']; 
    //   }
    //   if(!empty($category)){
    //   $main_genre = implode(",",$category);
    //   }else{
    //     $main_genre = "";
    //   }
    //   $languages = LanguageVideo::Join('languages','languages.id','=','languagevideos.language_id')
    //   ->where('languagevideos.video_id',$videoid)->get('name');
    //   foreach($languages as $value){
    //     $language[] = $value['name']; 
    //   }
    //   if(!empty($language)){
    //   $languages = implode(",",$language);
    //   }else{
    //     $languages = "";
    //   }

    // echo "<pre>"; print_r($livecategories);exit();
    $myData = array();

      $videos= LiveStream::where('active','=',1)->orderBy('created_at', 'desc')->get()->map(function ($item) {
        $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
        return $item;
      });

      if(count($videos) > 0){
        $msg = 'success';
      }else{
        $msg = 'nodata';
      }
      $myData[] = array(
        // "genre_id"   => $livecategoryid,
        // "genre_image"   => URL::to('/').'/public/uploads/livecategory/'.$genre_image,
        // "message" => $msg,
        "videos" => $videos
      );

    

    $response = array(
      'status' => 'true',
      'live_streams' => $myData
    );
    return response()->json($response, 200);
  
  }

  public function livestreamdetail(Request $request)
  {
    $liveid = $request->liveid;
    $livedetail = LiveStream::where('id',$liveid)->get()->map(function ($item) {
        $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
        return $item;
      });
    $response = array(
      'status' => 'true',
      'shareurl' => URL::to('live').'/'.$liveid,
      'livedetail' => $livedetail
    );
    return response()->json($response, 200);
  }

  public function cmspages()
     {
        
      $pages = Page::where('active', '=', 1)->get()->map(function ($item) {
        $item['page_url'] = URL::to('page').'/'.$item->slug;
        return $item;
      });
      $response = array(
        'status' => 'true',
        'pages' => $pages
      );
      return response()->json($response, 200);
     }

     public function sliders()
     {
      $sliders = Slider::where('active', '=', 1)->get()->map(function ($item) {
        $item['slider'] = URL::to('/').'/public/uploads/videocategory/'.$item->slider;
        return $item;
      });
      $banners = Video::where('active','=',1)->where('status','=',1)->where('banner', '=', 1)->get()->map(function ($item) {
        $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
        $item['video_url'] = URL::to('/').'/storage/app/public/';
        return $item;
      });
      $response = array(
        'status' => 'true',
        'sliders' => $sliders,
        'banners' => $banners
      );
      return response()->json($response, 200);
     } 
       
     public function coupons(Request $request)
      {
            $user_id = $request->user_id;
           // $myrefferals = User::find($user_id)->referrals;
            $coupons = Coupon::first();
            // $myrefferals = User::with('referrals')->where("id",$user_id)->where("coupon_used",$user_id)->get();
            $myrefferals = User::where("referrer_id","=",$user_id)->get()->map(function ($item) {
                $item['coupon_code'] = Coupon::first()->coupon_code;
                return $item;
            });
            $response = array(
                'status' => 'true',
                'myrefferals' => $myrefferals
            );
            return response()->json($response, 200);
      } 
//    
//    public function coupons(Request $request)
//     {
//            $user_id = $request->user_id;
//            $myrefferals = User::find($user_id)->referrals;
//            $coupons = Coupon::first();
//        
//          // $myrefferals = User::with('referrals')->where("id",$user_id)->where("coupon_used",$user_id)->get();
//        
//            $myrefferals = User::with('referrals')->where("id","=",$user_id)->get()->map(function ($item) {
//                $item['coupon_code'] = Coupon::first()->coupon_code;
//                return $item;
//            });
//            $response = array(
//                'status' => 'true',
//                'myrefferals' => $myrefferals
//            );
//            return response()->json($response, 200);
//      }  
    
    public function MobileSliders()
     {
      $sliders = MobileSlider::where('active', '=', 1)->get()->map(function ($item) {
        $item['slider'] = URL::to('/').'/public/uploads/videocategory/'.$item->slider;
        return $item;
      });
      $response = array(
        'status' => 'true',
        'sliders' => $sliders
      );
      return response()->json($response, 200);
     }

     public function ppvvideos()
  {
    $ppvcategories = PpvCategory::select('id','image')->get()->toArray();
    $myData = array();
    foreach ($ppvcategories as $key => $ppvcategory) {
      $ppvcategoryid = $ppvcategory['id'];
      $genre_image = $ppvcategory['image'];
      $videos= PpvVideo::where('video_category_id',$ppvcategoryid)->where('active','=',1)->where('status','=',1)->orderBy('created_at', 'desc')->get()->map(function ($item) {
        $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
        return $item;
      });
      $categorydetails = PpvCategory::where('id','=',$ppvcategoryid)->first();

      if(count($videos) > 0){
        $msg = 'success';
      }else{
        $msg = 'nodata';
      }
      $myData[] = array(
        "genre_name"   => $categorydetails->name,
        "genre_id"   => $ppvcategoryid,
        "genre_image"   => URL::to('/').'/public/uploads/ppvcategory/'.$genre_image,
        "message" => $msg,
        "videos" => $videos
      );

    }

    $response = array(
      'status' => 'true',
      'genre_movies' => $myData
    );
    return response()->json($response, 200);
  }

  public function ppvvideodetail(Request $request)
  {
    $ppvvideoid = $request->ppvvideoid;
    $user_id = $request->user_id;
    $ppvvideodetail = PpvVideo::where('id',$ppvvideoid)->get()->map(function ($item) {
        $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
        return $item;
      });
      $ppv_status = PpvPurchase::join('ppv_videos', 'ppv_videos.id', '=', 'ppv_purchases.video_id')->where('ppv_purchases.user_id', '=', $user_id)->where('ppv_purchases.video_id', '=', $ppvvideoid)->get()->map(function ($item) {
        $item['ppv_videos_status'] = ($item->to_time > Carbon::now() )?"Can View":"Expired";
        return $item;
      });
      if(!$ppv_status->isEmpty()){
        $ppvstatus = $ppv_status[0]->ppv_videos_status;
      }else{
        $ppvstatus = 'Purchase';
      }

      if ( $request->user_id != '' ) { 
      $user_id = $request->user_id;
      //Wishlilst
      $cnt = Wishlist::select('video_id')->where('user_id','=',$user_id)->where('video_id','=',$ppvvideoid)->count();
      $wishliststatus =  ($cnt == 1) ? "true" : "false";
      //Watchlater
      $cnt1 = Watchlater::select('video_id')->where('user_id','=',$user_id)->where('video_id','=',$ppvvideoid)->count();
      $watchlaterstatus =  ($cnt1 == 1) ? "true" : "false";
      $userrole = User::where('id','=',$user_id)->first()->role;
      $status = 'true';
    } else{
      $wishliststatus = 'false';
      $watchlaterstatus = 'false';
      $userrole = '';
      $status = 'false';
    }
    $response = array(
      'status' => $status,
      'wishlist' => $wishliststatus,
      'watchlater' => $watchlaterstatus,
      'ppvstatus' => $ppvstatus,
      'userrole' => $userrole,
      'shareurl' => URL::to('ppvVideos/play_videos').'/'.$ppvvideoid,
      'ppvvideodetail' => $ppvvideodetail
    );
    return response()->json($response, 200);
  }

  public function directVerify(Request $request){
    if (!empty($request->post('activation_code')) && !empty($request->post('mobile'))) {
      $activation_code = $request->post('activation_code');
      $ccode = $request->post('ccode');
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
                $response = array(
                    'status' =>'true',
                    'message' =>'Your account is verified and login successfully'
                  );
                 return response()->json($response, 200);
              }
          } else {
              $response = array(
                    'status' =>'false',
                    'message' =>'Invalid OTP number'
                  );
                 return response()->json($response, 400);
        }
      } else {
        $response = array(
                    'status' =>'false',
                    'message' =>'Invalid mobile number'
                  );
                 return response()->json($response, 400);
      }
    } else {
      if (empty($request->post('activation_code')) && !empty($request->post('mobile'))) {
        $msg = "Please enter the OTP";
      } else if(!empty($request->post('activation_code')) && empty($request->post('mobile'))) {
        $msg = "Please enter the mobile number";
      } else {
        $msg = "Please enter the OTP and Mobile number";
      }
        $response = array(
                    'status' =>'false',
                    'message' => $msg
                  );
        return response()->json($response, 400);
    }
       
    }

  public function updateProfile(Request $request) {

        $id = $request->user_id;
        $user = User::find($id);
        $path = URL::to('/').'/public/uploads/avatars/';
        $logo = $request->file('avatar');
        if($logo != '' && $logo != null) {

            $file_old = $path.$logo;
            if (file_exists($file_old)){
              unlink($file_old);
            }
          $file = $logo;
          $avatar = $file->getClientOriginalName();
          $file->move(public_path()."/uploads/avatars/", $file->getClientOriginalName());

        }elseif(!empty($user->avatar)){
          $avatar = $user->avatar;
        } else {
          $avatar = 'default.png';
        }
        if(!empty($request->user_password)){
          $user_password = Hash::make($request->user_password); 
          // print_r($user_password);exit;
        }else{
          $user_password = $user->password;
        }
        $user = User::find($id);
        $user->email = $request->user_email;
        $user->username = $request->user_username;
        $user->name = $request->user_name;
        $user->ccode = $request->user_ccode;
        $user->mobile = $request->user_mobile;
        $user->password = $user_password;
        $user->avatar = $avatar;
        $user->save();
        $response = array(
        'status'=>'true',
        'message'=>'Your Profile detail has been updated'
      );
    // send_password_notification('Notification From Flicknexs','Your Profile  has been Updated Successfully','Your Account  has been Created Successfully','',$id);
        return response()->json($response, 200);
   }

   public function addwishlist(Request $request) {

    $user_id = $request->user_id;
    //$type = $request->type;//channel,ppv
    $video_id = $request->video_id;
    if($request->video_id != ''){
      $count = Wishlist::where('user_id', '=', $user_id)->where('video_id', '=', $video_id)->count();
      if ( $count > 0 ) {
        Wishlist::where('user_id', '=', $user_id)->where('video_id', '=', $video_id)->delete();
        $response = array(
          'status'=>'false',
          'message'=>'Removed From Your Wishlist List'
        );
      } else {
        $data = array('user_id' => $user_id, 'video_id' => $video_id );
        Wishlist::insert($data);
        $response = array(
          'status'=>'true',
          'message'=>'Added  to  Your Wishlist List'
        );

      }
    }

    return response()->json($response, 200);

  }

  public function addfavorite(Request $request) {

    $user_id = $request->user_id;
    //$type = $request->type;//channel,ppv
    $video_id = $request->video_id;
    if($request->video_id != ''){
      $count = Favorite::where('user_id', '=', $user_id)->where('video_id', '=', $video_id)->count();
      if ( $count > 0 ) {
        Favorite::where('user_id', '=', $user_id)->where('video_id', '=', $video_id)->delete();
        $response = array(
          'status'=>'false',
          'message'=>'Removed From Your Favorite List'
        );
      } else {
        $data = array('user_id' => $user_id, 'video_id' => $video_id );
        Favorite::insert($data);
        $response = array(
          'status'=>'true',
          'message'=>'Added  to  Your Favorite List'
        );

      }
    }

    return response()->json($response, 200);

  }
  public function addwishlistaudio(Request $request) {

    $user_id = $request->user_id;
    //$type = $request->type;//channel,ppv
    $audio_id = $request->audio_id;
    if($request->audio_id != ''){
      $count = Wishlist::where('user_id', '=', $user_id)->where('audio_id', '=', $audio_id)->count();
      if ( $count > 0 ) {
        Wishlist::where('user_id', '=', $user_id)->where('audio_id', '=', $audio_id)->delete();
        $response = array(
          'status'=>'false',
          'message'=>'Removed From Your Wishlist List'
        );
      } else {
        $data = array('user_id' => $user_id, 'audio_id' => $audio_id );
        Wishlist::insert($data);
        $response = array(
          'status'=>'true',
          'message'=>'Added  to  Your Wishlist List'
        );

      }
    }

    return response()->json($response, 200);

  }

  public function addfavoriteaudio(Request $request) {

    $user_id = $request->user_id;
    //$type = $request->type;//channel,ppv
    $audio_id = $request->audios_id;
    if($request->audios_id != ''){
      $count = Favorite::where('user_id', '=', $user_id)->where('audio_id', '=', $audio_id)->count();
      if ( $count > 0 ) {
        Favorite::where('user_id', '=', $user_id)->where('audio_id', '=', $audio_id)->delete();
        $response = array(
          'status'=>'false',
          'message'=>'Removed From Your Favorite List'
        );
      } else {
        $data = array('user_id' => $user_id, 'audio_id' => $audio_id );
        Favorite::insert($data);
        $response = array(
          'status'=>'true',
          'message'=>'Added  to  Your Favorite List'
        );

      }
    }

    return response()->json($response, 200);

  }


  public function addwatchlater(Request $request) {

    $user_id = $request->user_id;
    $video_id = $request->video_id;
    if($request->video_id != ''){
      $count = Watchlater::where('user_id', '=', $user_id)->where('video_id', '=', $video_id)->count();
      if ( $count > 0 ) {
        Watchlater::where('user_id', '=', $user_id)->where('video_id', '=', $video_id)->delete();
        $response = array(
          'status'=>'false',
          'message'=>'Removed From Your Watch Later List'
        );
      } else {
        $data = array('user_id' => $user_id, 'video_id' => $video_id );
        Watchlater::insert($data);
        $response = array(
          'status'=>'true',
          'message'=>'Added  to  Your Watch Later List'
        );

      }
    }

    return response()->json($response, 200);

  }

  public function addwatchlateraudio(Request $request) {

    $user_id = $request->user_id;
    $audio_id = $request->audios_id;
    if($request->audios_id != ''){
      $count = Watchlater::where('user_id', '=', $user_id)->where('audio_id', '=', $audio_id)->count();
      if ( $count > 0 ) {
        Watchlater::where('user_id', '=', $user_id)->where('audio_id', '=', $audio_id)->delete();
        $response = array(
          'status'=>'false',
          'message'=>'Removed From Your Watch Later List'
        );
      } else {
        $data = array('user_id' => $user_id, 'audio_id' => $audio_id );
        Watchlater::insert($data);
        $response = array(
          'status'=>'true',
          'message'=>'Added  to  Your Watch Later List'
        );

      }
    }

    return response()->json($response, 200);

  }

  public function myWishlists(Request $request) {

    $user_id = $request->user_id;

    /*channel videos*/
    $video_ids = Wishlist::select('video_id')->where('user_id','=',$user_id)->get();
    $video_ids_count = Wishlist::select('video_id')->where('user_id','=',$user_id)->count();

    if ( $video_ids_count  > 0) {

      foreach ($video_ids as $key => $value1) {
        $k2[] = $value1->video_id;
      }
      $channel_videos = Video::whereIn('id', $k2)->get()->map(function ($item) {
        $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
        $item['video_url'] = URL::to('/').'/storage/app/public/';
        return $item;
      });
      $status = "true";
    }else{
            $status = "false";
      $channel_videos = [];
    }

  
    $response = array(
        'status'=>$status,
        'channel_videos'=> $channel_videos
      );
    return response()->json($response, 200);

  }

  public function myfavorites(Request $request) {

    $user_id = $request->user_id;

    /*channel videos*/
    $video_ids = Favorite::select('video_id')->where('user_id',$user_id)->get();
    $video_ids_count = Favorite::select('video_id')->where('user_id',$user_id)->count();

    if ( $video_ids_count  > 0) {

      foreach ($video_ids as $key => $value) {
        $k2[] = $value->video_id;
      }
      $channel_videos = Video::whereIn('id', $k2)->get()->map(function ($item) {
        $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
        $item['video_url'] = URL::to('/').'/storage/app/public/';
        return $item;
      });
      $status = "true";
    }else{
            $status = "false";
      $channel_videos = [];
    }

  
    $response = array(
        'status'=>$status,
        'channel_videos'=> $channel_videos
      );
    return response()->json($response, 200);

  }

  public function mywatchlaters(Request $request) {

    $user_id = $request->user_id;

    /*channel videos*/
    $video_ids = Watchlater::select('video_id')->where('user_id','=',$user_id)->get();
    $video_ids_count = Watchlater::select('video_id')->where('user_id','=',$user_id)->count();

    if ( $video_ids_count  > 0) {

      foreach ($video_ids as $key => $value1) {
        $k2[] = $value1->video_id;
      }
      $channel_videos = Video::whereIn('id', $k2)->get()->map(function ($item) {
        $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
        $item['video_url'] = URL::to('/').'/storage/app/public/';
        return $item;
      });
      $status = "true";
    }else{
             $status = "false";
      $channel_videos = [];
    }
    
    $response = array(
        'status'=>$status,
        'channel_videos'=> $channel_videos
      );
    return response()->json($response, 200);

  }


  public function showWishlist(Request $request) {

    $user_id = $request->user_id;
    $type = $request->type;
    $video_id = $request->video_id;
      if($video_id != ''){ 
          $wish_video_count = Wishlist::select('video_id')->where('user_id','=',$user_id)->where('video_id','=',$video_id)->where('type','=',$type)->count();
      }

      $response = array(
        'status'=>'true',
        'wish_count'=>$wish_video_count,
      );
    
    return response()->json($response, 200);

  }

  public function showfavorites(Request $request) {

    $user_id = $request->user_id;
    $type = $request->type;
    $video_id = $request->video_id;
      if($video_id != ''){ 
          $fav_video_count = Favorite::select('video_id')->where('user_id','=',$user_id)->where('video_id','=',$video_id)->where('type','=',$type)->count();
      }

      $response = array(
        'status'=>'true',
        'fav_count'=>$fav_video_count,
      );
    
    return response()->json($response, 200);

  }

  public function showWatchlater(Request $request) {

    $user_id = $request->user_id;
    $type = $request->type;
    $video_id = $request->video_id;
      if($video_id != ''){ 
          $watchlater_count = Watchlater::select('video_id')->where('user_id','=',$user_id)->where('video_id','=',$video_id)->where('type','=',$type)->count();
      }

      $response = array(
        'status'=>'true',
        'watch_count'=>$watchlater_count,
      );
    
    return response()->json($response, 200);

  }

  public function getPPV(Request $request)
  {

    $user_id = $request->user_id;

    $daten = date('Y-m-d h:i:s a', time());

    $payperview_video = PpvPurchase::join('videos', 'videos.id', '=', 'ppv_purchases.video_id')->where('ppv_purchases.user_id', '=', $user_id)->where('ppv_purchases.video_id', '!=', 0)->get()->map(function ($item) {
        $item['ppv_videos_status'] = ($item->to_time > Carbon::now() )?"Can View":"Expired";
        $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
        return $item;
      });

    $response = array(
      'status' => 'true',
      'payperview_video' => $payperview_video
    );

    return response()->json($response, 200);

  }
    
    public function payment_settings() {

      $payment_settings = PaymentSetting::get();
      $active_payment_settings = PaymentSetting::where('status',1)->get();
      $stripe_payment_settings = PaymentSetting::where('payment_type','=','Stripe')->get();
      $paypal_payment_settings = PaymentSetting::where('payment_type','=','PayPal')->get();
  
      $response = array(
        'status'=>'true',
        'payment_settings'=> $payment_settings,
        'active_payment_settings' => $active_payment_settings,
        'stripe_payment_settings'=> $stripe_payment_settings,
        'paypal_payment_settings'=> $paypal_payment_settings,
      );

    return response()->json($response, 200);
    }

  public function getLivepurchased(Request $request)
  {

    $user_id = $request->user_id;

    $daten = date('Y-m-d h:i:s a', time());

    $payperview_video = LivePurchase::join('live_streams', 'live_streams.id', '=', 'live_purchases.video_id')->where('live_purchases.user_id', '=', $user_id)->where('live_purchases.video_id', '!=', 0)->get()->map(function ($item) {
        $item['live_streams_status'] = ($item->to_time > Carbon::now() )?"Can View":"Expired";
        $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
        return $item;
      });

    $response = array(
      'status' => 'true',
      'livevideos' => $payperview_video
    );

    return response()->json($response, 200);

  }

  public function settings()
  {
    $settings = Setting::all()->map(function ($item) {
        $item['image_url'] = URL::to('/').'/public/uploads/settings/'.$item->logo;
        return $item;
      });
    $response = array(
      'settings' => $settings
    );
    return response()->json($response, 200);
  }

  public function upgradesubscription(Request $request)
     {
         $user_id = $request->user_id;
         $user = User::find($user_id);
         $upgrade_plan = $request->get('plan_name');
         $coupon_code = $request->get('coupon_code');
         $ref_id = $request->get('ref_id');
         $stripe_plan = SubscriptionPlan();
         $subscription = $user->subscription($stripe_plan);
         if (isset($coupon_code) && !empty($coupon_code))
            {
              $user->subscription($stripe_plan)->swapAndInvoice($upgrade_plan, ['coupon' => $coupon_code]);
              $coupon = new CouponPurchase;
              $coupon->coupon_id = $coupon_code;
              $coupon->user_id = $user_id;
              $coupon->ref_id = $ref_id;
              $coupon->save();
              $update_user = User::find($ref_id);
              $update_user->coupon_used = 1;
              $update_user->save();   
            } else {
              $user->subscription($stripe_plan)->swapAndInvoice($upgrade_plan);
            }
              $plan = $request->get('plan_name');
              $plandetail = SubscriptionPlan::where('plan_id',$upgrade_plan)->first();
              \Mail::send('emails.changeplansubscriptionmail', array(
                            'name' => $user->username,
                            'plan' => ucfirst($plandetail->plans_name),
                        ), function($message) use ($request,$user){
                            $message->from(AdminMail(),'Flicknexs');
                            $message->to($user->email, $user->username)->subject('Subscription Plan Changed');
                });
                return response()->json(['success'=>'Your plan has been changed.']);
        }
    
  public function cancelsubscription(Request $request)
  {
    $user_id = $request->user_id;
    $user = User::find($user_id);
    $stripe_plan = SubscriptionPlan();
    $user->subscription($stripe_plan)->cancel();
    $plan_name =  CurrentSubPlanName($user_id);
    $start_date =  SubStartDate($user_id);
    $ends_at =  SubEndDate($user_id);

    \Mail::send('emails.cancel', array(
      'name' => $user->username,
      'plan_name' => $plan_name,
      'start_date' => $start_date,
      'ends_at' => $ends_at,
    ), function($message) use ($user){
      $message->from(AdminMail(),'Flicknexs');
      $message->to($user->email, $user->username)->subject('Subscription Renewal');
    });

    if ($user->subscription($stripe_plan)->cancel()){
      $response = array(
        'status' => 'true',
        'message' => 'Cancelled Successfuly '
      );
    } else {
      $response = array(
        'status' => 'false',
        'message' => 'Failed Cancellation '
      );
    }
    return response()->json($response, 200);

  }

  public function renewsubscription(Request $request)
  {

    $user_id = $request->user_id;
    $user = User::find($user_id);
        $stripe_plan = SubscriptionPlan();
           if ($user->subscription($stripe_plan)->resume()) {
            $planvalue = $user->subscriptions;
            $plan = $planvalue[0]->stripe_plan;
            $plandetail = SubscriptionPlan::where('plan_id',$plan)->first();
          
            \Mail::send('emails.renewsubscriptionemail', array(
                'name' => $user->username,
                'plan' => ucfirst($plandetail->plans_name),
               // 'price' => $plandetail->price,
            ), function($message) use ($user){
                $message->from(AdminMail(),'Flicknexs');
                $message->to($user->email, $user->username)->subject('Subscription Renewal');
            });
        
    
    
      $response = array(
        'status' => 'true',
        'msg' => 'Renewed successfully'
      );
    }else{
      $response = array(
        'status' => 'false',
        'msg' => 'Check Again'
      );
    }
    return response()->json($response, 200);
  }


  public function add_payperview(Request $request)
  {
    $payment_type = $request->payment_type;
    $video_id = $request->video_id;
    $episode_id = $request->episode_id;
    $season_id = $request->season_id;
    $series_id = $request->series_id;
    $user_id = $request->user_id;
    $daten = date('Y-m-d h:i:s a', time());
    $setting = Setting::first();
    $ppv_hours = $setting->ppv_hours;
    $date = Carbon::parse($daten)->addHour($ppv_hours);
    $user = User::find($user_id);
    if($payment_type == 'stripe'){
    
    $paymentMethod = $request->get('py_id');
    $payment_settings = PaymentSetting::first();
    
    $pay_amount = PvvPrice();
    $pay_amount = $pay_amount*100;
    $charge = $user->charge($pay_amount, $paymentMethod);
    if($charge->id != ''){
      $ppv_count = DB::table('ppv_purchases')->where('video_id', '=', $video_id)->where('user_id', '=', $user_id)->count();
      if ( $ppv_count == 0 ) { 
        DB::table('ppv_purchases')->insert(
          ['user_id' => $user_id ,'video_id' => $video_id,'to_time' => $date ]
        );
        send_password_notification('Notification From Flicknexs','You have rented a video','You have rented a video','',$user_id);
      } else {
        DB::table('ppv_purchases')->where('video_id', $video_id)->where('user_id', $user_id)->update(['to_time' => $date]);
      }

      $response = array(
        'status' => 'true',
        'message' => "video has been added"
      );
    }else{
      $response = array(
        'status' => 'false',
        'message' => "Payment Failed"
      );
    }
    }elseif ($payment_type == 'razorpay' || $payment_type == 'paypal'|| $payment_type == 'Applepay'|| $payment_type == 'recurring') {
      $ppv_count = DB::table('ppv_purchases')->where('video_id', '=', $video_id)->where('user_id', '=', $user_id)->count();
      $serie_ppv_count = DB::table('ppv_purchases')->where('series_id', '=', $series_id)->where('user_id', '=', $user_id)->count();
      $season_ppv_count = DB::table('ppv_purchases')->where('series_id', '=', $series_id)->where('season_id', '=', $season_id)->where('user_id', '=', $user_id)->count();

      if ( $ppv_count == 0 ) { 
        DB::table('ppv_purchases')->insert(
          ['user_id' => $user_id ,'video_id' => $video_id,'to_time' => $date ]
        );
      } else {
        DB::table('ppv_purchases')->where('video_id', $video_id)->where('user_id', $user_id)->update(['to_time' => $date]);
      }
      
      if ( $serie_ppv_count == 0 ) { 
        DB::table('ppv_purchases')->insert(
          ['user_id' => $user_id ,'series_id' => $series_id,'to_time' => $date ]
        );
      } else {
        DB::table('ppv_purchases')
        ->where('series_id', $series_id)
        ->where('user_id', $user_id)
        ->update(['to_time' => $date]);
      }
      
      if ( $season_ppv_count == 0 ) { 
        DB::table('ppv_purchases')->insert(
          ['user_id' => $user_id ,'series_id' => $series_id,'season_id' => $season_id,'to_time' => $date ]
        );
      } else {
        DB::table('ppv_purchases')
        ->where('series_id', $series_id)
        ->where('season_id', $season_id)
        ->where('user_id', $user_id)
        ->update(['to_time' => $date]);
      }
      $response = array(
        'status' => 'true',
        'message' => "video has been added"
      );
    }
    
    return response()->json($response, 200);

  } 
    
    public function AddPpvPaypal(Request $request)
  {

    $daten = date('Y-m-d h:i:s a', time());
    $setting = Setting::first();
    $ppv_hours = $setting->ppv_hours;
    $date = Carbon::parse($daten)->addHour($ppv_hours);
    $video_id = $request->video_id;
    $user_id = $request->user_id;
    $paymentStatus = $request->get('status');
    $payment_settings = PaymentSetting::first();
    $user = User::find($user_id);
    
    if($paymentStatus == 'true'){
      $ppv_count = DB::table('ppv_purchases')->where('video_id', '=', $video_id)->where('user_id', '=', $user_id)->count();
      if ( $ppv_count == 0 ) { 
        DB::table('ppv_purchases')->insert(
          ['user_id' => $user_id ,'video_id' => $video_id,'to_time' => $date ]
        );
      } else {
        DB::table('ppv_purchases')->where('video_id', $video_id)->where('user_id', $user_id)->update(['to_time' => $date]);
      }

      $response = array(
        'status' => 'true',
        'message' => "video has been added"
      );
    } else {
      $response = array(
        'status' => 'false',
        'message' => "Payment Failed"
      );
    }
    return response()->json($response, 200);

  }

  public function splash(){

        $mobile_settings = MobileApp::get('splash_image')->map(function ($item) {
          $item['splash_url'] = URL::to('/').'/public/uploads/settings/'.$item->splash_image;
          return $item;
      });

      $Splash_Screen_first = MobileApp::first();

      $first_Splash_Screen[] =[
        'Splash_Screen'=> $Splash_Screen_first->splash_image,
        'splash_url'  => URL::to('/').'/public/uploads/settings/'.$Splash_Screen_first->splash_image,
      ];


    $response = array(
      'status'=>'true',
      'message'=>'success',
      'Splash_Screen'=> $mobile_settings,
      'first_Splash_Screen' => $first_Splash_Screen,
    );
    return response()->json($response, 200);
  }  
    

        public function ViewProfile(Request $request) {

            $user_id = $request->user_id;
            $stripe_plan = SubscriptionPlan();

            $user_details = User::where('id', '=', $user_id)->get()->map(function ($item) {
                $item['profile_url'] = URL::to('/').'/public/uploads/avatars/'.$item->avatar;
                return $item;
            });
            $userdata = User::where('id', '=', $user_id)->first();
            $paymode_type =  Subscription::where('user_id',$user_id)->latest()->pluck('PaymentGateway')->first();


          if($paymode_type != null && $paymode_type == "Razorpay" &&  !empty($userdata) && $userdata->role == "subscriber"){

            $subscription_id = User::where('id', '=', $user_id)->pluck('stripe_id')->first();
            $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);

              if($subscription_id != null){
                $subscription = $api->subscription->fetch($subscription_id);
                $nextPaymentAttemptDate = Carbon::createFromTimeStamp($subscription->current_end)->toFormattedDateString();
              }else{
                $nextPaymentAttemptDate = '';
              }
           
            } 
          else{
            if ($userdata->subscription($stripe_plan)) {
                  $timestamp = $userdata->asStripeCustomer()["subscriptions"]->data[0]["current_period_end"];
                  $nextPaymentAttemptDate = Carbon::createFromTimeStamp($timestamp)->toFormattedDateString();
              }else{
                   $nextPaymentAttemptDate = '';
              } 
          } 

          
            $user = User::find($user_id);

            // if ($user->subscription($stripe_plan) && $user->subscription($stripe_plan)->onGracePeriod()) {
            //     $ends_at = $user->subscription($stripe_plan)->ends_at->format('dS M Y');
            // }else{
            //     $ends_at = "";
            // }
           
            $stripe_plan = SubscriptionPlan();
           
            if ( !empty($userdata) && $userdata->role == "subscriber" || $userdata->subscribed($stripe_plan) && $userdata->role == "subscriber") 
            {
             
                $paymode_type =  Subscription::where('user_id',$user_id)->latest()->pluck('PaymentGateway')->first();
              
                if( $paymode_type != null && $paymode_type == "Razorpay"){
                  $curren_stripe_plan = CurrentSubPlanName($user_id);
                  $ends_ats = Subscription::where('user_id',$user_id)->latest()->pluck('ends_at');
                    if(!empty($ends_ats[0])){
                        $ends_at = $ends_ats[0];
                    }else{
                      $ends_at = "";
                    }

                }
                else{
                  $curren_stripe_plan = CurrentSubPlanName($user_id);
                  $ends_ats = Subscription::where('user_id',$user_id)->pluck('ends_at');
                    if(!empty($ends_ats[0])){
                        $ends_at = $ends_ats[0];
                    }else{
                      $ends_at = "";
                    }
                } 
            } 
            else{
                $curren_stripe_plan = "No Plan Found";
                $ends_at = "";
            }

            $response = array(
                'status'=>'true',
                'message'=>'success',
                'curren_stripe_plan'=>$curren_stripe_plan,
                'user_details' => $user_details,
                'next_billing' => $nextPaymentAttemptDate,
                'ends_at' => $ends_at,
            );
            return response()->json($response, 200);
        }

   //For fetching Countries
    public function getCountries()
    {
        $country = Country::get()->map(function ($item) {
        $item['country_id'] = $item->id;
        return $item;
      });
        $response = array(
      'status'=>'true',
      'country' => $country
    );
    return response()->json($response, 200);
    }

   //For fetching states
    public function getStates(Request $request)
    {
      $id = $request->country_id;
        $states = State::where("country_id",$id)
        ->get()->map(function ($item) {
        $item['state_id'] = $item->id;
        return $item;
      });
        $response = array(
      'status'=>'true',
      'states' => $states
    );
    return response()->json($response, 200);
    }

    //For fetching cities
    public function getCities(Request $request)
    {
      $id = $request->state_id;
        $cities= City::where("state_id",$id)
        ->get()->map(function ($item) {
        $item['city_id'] = $item->id;
        return $item;
      });
        $response = array(
      'status'=>'true',
      'cities' => $cities
    );
    return response()->json($response, 200);
    }


    public function StripeOnlyTimePlan() {
        $plans = SubscriptionPlan::where("payment_type","=","one_time")->get();
      $response = array(
        'status'=>'true',
        'plans' => $plans
      ); 
      return response()->json($response, 200);
    }  
    
    public function StripeRecurringPlan() {
      
        // $plans = Plan::where("payment_type","=","recurring")->get();
        // $plans = SubscriptionPlan::where("payment_type","=","recurring")->where('type','=','Stripe')->get();

      $plans = SubscriptionPlan::where("payment_type","=","recurring")->groupby('plans_name') ->orderBy('id', 'asc')->get();

      $response = array(
        'status'=>'true',
        'plans' => $plans
      ); 
      return response()->json($response, 200);
    } 
    
    public function PaypalOnlyTimePlan() {
      
      // $plans = Plan::where("payment_type","=","one_time")->where('type','=','PayPal')->get()->map(function ($item) {
        $plans = SubscriptionPlan::where("payment_type","=","one_time")->where('type','=','PayPal')->get()->map(function ($item) {
        $item['billing_interval'] = $item->name;
        $item['plans_name'] = $item->name;
        return $item;
      });
      $response = array(
        'status'=>'true',
        'plans' => $plans
      ); 
      return response()->json($response, 200);
    }  
    
    public function PaypalRecurringPlan() {

      $plans = SubscriptionPlan::where("payment_type","=","recurring")->get()->map(function ($item) {
        // $plans = SubscriptionPlan::where("payment_type","=","recurring")->where('type','=','PayPal')->get()->map(function ($item) {
        $item['billing_interval'] = $item->name;
            $item['plans_name'] = $item->name;
        return $item;
      });
        
      $response = array(
        'status'=>'true',
        'plans' => $plans
      ); 
      return response()->json($response, 200);
    }


    public function relatedchannelvideos(Request $request) {
      $videoid = $request->videoid;
      $categoryVideos = Video::where('id',$videoid)->first();
        $category_id = Video::where('id',$videoid)->pluck('video_category_id');
        $recomended = Video::where('video_category_id','=',$category_id)->where('id','!=',$videoid)->where('status','=',1)->where('active','=',1)->get()->map(function ($item) {
        $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
        return $item;
      });
        $response = array(
        'status'=>'true',
        'channelrecomended' => $recomended
      ); 
      return response()->json($response, 200);
    }

    public function relatedppvvideos(Request $request) {
      $ppvvideoid = $request->ppvvideoid;
      $recomended = PpvVideo::where('id','!=',$ppvvideoid)->where('status',1)->where('active','=',1)->get()->map(function ($item) {
        $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
        return $item;
      });
        $response = array(
        'status'=>'true',
        'ppvrecomended' => $recomended
      ); 
      return response()->json($response, 200);
    }


    public function search(Request $request)
    {

      $search_value =  $request['search'];
      $video_category_id =  $request['category_id'];
      $video_artist_id =  $request['artist_id'];


     
      $videos_count = Video::where('title', 'LIKE', '%'.$search_value.'%')->count();
      $ppv_videos_count = PpvVideo::where('title', 'LIKE', '%'.$search_value.'%')->count();
      $video_category_count = VideoCategory::where('name', 'LIKE', '%'.$search_value.'%')->count();
      $ppv_category_count = PpvCategory::where('name', 'LIKE', '%'.$search_value.'%')->count();
      $albums_count = AudioAlbums::where('albumname', 'LIKE', '%'.$search_value.'%')->count();
      $audio_categories_count = AudioCategory::where('name', 'LIKE', '%'.$search_value.'%')->count();
      $audios_count = Audio::where('title', 'LIKE', '%'.$search_value.'%')->count();
      $artist_count = Artist::where('artist_name', 'LIKE', '%'.$search_value.'%')->count();
      $video_categories_count =  DB::table('video_categories')
      ->join('videos', 'videos.video_category_id', '=', 'video_categories.id')
      ->select('videos.*')
      ->where('title', 'LIKE', '%'.$search_value.'%')
      ->where('video_category_id', '=', $video_category_id )
      ->count();
      $video_artist_count =  DB::table('video_artists')
      ->join('videos', 'videos.id', '=', 'video_artists.video_id')
      ->select('videos.*')
      ->where('title', 'LIKE', '%'.$search_value.'%')
      ->where('video_artists.artist_id', '=', $video_artist_id )
      ->count();

      if ($audios_count > 0) {
        $audios = Audio::where('title', 'LIKE', '%'.$search_value.'%')->where('status','=',1)->where('active','=',1)->orderBy('created_at', 'desc')->get()->map(function ($item) {
          $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
          return $item;
        });

        } else {
          $audios = [];
        } 
        if ($audio_categories_count > 0) {
          $audio_categories = AudioCategory::where('name', 'LIKE', '%'.$search_value.'%')->orderBy('created_at', 'desc')->get()->map(function ($item) {
      $item['image_url'] = URL::to('/').'/public/uploads/audios/'.$item->image;
      return $item;
      });

      } else {
      $audio_categories = [];
      } 
      if ($albums_count > 0) {
        $albums = AudioAlbums::where('albumname', 'LIKE', '%'.$search_value.'%')->orderBy('created_at', 'desc')->get()->map(function ($item) {
      $item['image_url'] = URL::to('/').'/public/uploads/albums/'.$item->album;
      return $item;
      });

      } else {
      $albums = [];
      } 

      if ($videos_count > 0) {
            $videos = Video::where('title', 'LIKE', '%'.$search_value.'%')->where('status','=',1)->where('active','=',1)->orderBy('created_at', 'desc')->get()->map(function ($item) {
        $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
        return $item;
      });

      } else {
        $videos = [];
      } 
      if ($ppv_videos_count > 0) {
        $ppv_videos = PpvVideo::where('title', 'LIKE', '%'.$search_value.'%')->where('status','=',1)->where('active','=',1)->orderBy('created_at', 'desc')->get()->map(function ($item) {
        $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
        return $item;
      });

      } else {
        $ppv_videos = [];
      } 

      if ($video_category_count > 0) {

        $video_category = VideoCategory::where('name', 'LIKE', '%'.$search_value.'%')->orderBy('created_at', 'desc')->get();

      } else {
        $video_category = [];
      }

      if ($ppv_category_count > 0) {

        $ppv_category = PpvCategory::where('name', 'LIKE', '%'.$search_value.'%')->orderBy('created_at', 'desc')->get();

      } else {
        $ppv_category = [];
      }

      if ($artist_count > 0) {

        $artist =  DB::table('artists')
        ->join('video_artists', 'artists.id', '=', 'video_artists.artist_id')
        ->join('videos', 'video_artists.video_id', '=', 'videos.id')
        ->select('videos.*')
        ->where('artist_name', 'LIKE', '%'.$search_value.'%')
        ->get();
    
        // $artist = Artist::where('artist_name', 'LIKE', '%'.$search_value.'%')->orderBy('created_at', 'desc')->get();

      } else {
        $artist = [];
      }
      if ($video_categories_count > 0) {

        $video_categories =  DB::table('video_categories')
        ->join('videos', 'videos.video_category_id', '=', 'video_categories.id')
        ->select('videos.*')
        ->where('title', 'LIKE', '%'.$search_value.'%')
        ->where('video_category_id', '=', $video_category_id )
        ->get();
      } else {
        $video_categories = [];
      }
      $url_image = URL::to('/').'/public/uploads/images/' ;

      if ($video_artist_count > 0) {

        $video_artist =  DB::table('video_artists')
        ->join('videos', 'videos.id', '=', 'video_artists.video_id')
        ->select('videos.*')
        ->where('title', 'LIKE', '%'.$search_value.'%')
        ->where('video_artists.artist_id', '=', $video_artist_id )
        ->get();
      } else {
        $video_artist = [];
      }


      $response = array(
        'channelvideos' => $videos,
        'channel_category' => $video_category,
        'search_value' => $search_value,
        'audios' => $audios,
        'albums' => $albums,
        'cast ' => $artist,
        'audio_categories' => $audio_categories,
        'video_categories' => $video_categories,
        'url_image' => $url_image,
        'video_artist' => $video_artist,

      );

      return response()->json($response, 200);
    }
    public function isPaymentEnable()
  {
    $settings = Setting::first();
    $response = array(
      'status' => 'true',
      'is_payment' => $settings->free_registration
    );
    return response()->json($response, 200);
  }

  public function searchapi(Request $request)
    {

      $search_value =  $request['search'];
      $type =  $request['type'];

      if($type == 'channelvideo'){
        $videos_count = Video::where('title', 'LIKE', '%'.$search_value.'%')->count();
        if ($videos_count > 0) {

          $videos = Video::where('title', 'LIKE', '%'.$search_value.'%')->where('status','=',1)->where('active','=',1)->orderBy('created_at', 'desc')->get()->map(function ($item) {
            $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
            return $item;
          });

        } else {
          $videos = [];
        } 

        $response = array(
        'channelvideos' => $videos,
        'search_value' => $search_value
        );
      }

      if($type == 'ppvvideo'){
        $ppv_videos_count = PpvVideo::where('title', 'LIKE', '%'.$search_value.'%')->count();
        if ($ppv_videos_count > 0) {

          $ppv_videos = PpvVideo::where('title', 'LIKE', '%'.$search_value.'%')->where('status','=',1)->where('active','=',1)->orderBy('created_at', 'desc')->get()->map(function ($item) {
            $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
            return $item;
          });

        } else {
          $ppv_videos = [];
        } 
        $response = array(
        'ppv_videos' => $ppv_videos,
        'search_value' => $search_value
        );
      }

      if($type == 'channelcategory'){
        $video_category_count = VideoCategory::where('name', 'LIKE', '%'.$search_value.'%')->where('parent_id','=',0)->count();
        if ($video_category_count > 0) {

          $video_category = VideoCategory::where('name', 'LIKE', '%'.$search_value.'%')->where('parent_id','=',0)->orderBy('created_at', 'desc')->get()->map(function ($item) {
            $item['image_url'] = URL::to('/').'/public/uploads/videocategory/'.$item->image;
            return $item;
          });

        } else {
          $video_category = [];
        }
        $response = array(
        'channel_category' => $video_category,
        'search_value' => $search_value
        );
      }


      if($type == 'ppvcategory'){
        $ppv_category_count = PpvCategory::where('name', 'LIKE', '%'.$search_value.'%')->where('parent_id','=',0)->count();
        if ($ppv_category_count > 0) {

          $ppv_category = PpvCategory::where('name', 'LIKE', '%'.$search_value.'%')->where('parent_id','=',0)->orderBy('created_at', 'desc')->get()->map(function ($item) {
            $item['image_url'] = URL::to('/').'/public/uploads/videocategory/'.$item->image;
            return $item;
          });

        } else {
          $ppv_category = [];
        }
        $response = array(
        'ppv_category' => $ppv_category,
        'search_value' => $search_value
        );
      }
      
      return response()->json($response, 200);
    }
    
    
    public function refferal(Request $request){
        
        $user_id = $request->user_id;
        $user_details = User::find($user_id);
        $referrer_count = ReferrerCount($user_id);
        $used_coupon = GetCouponPurchase($user_id);
        $available_coupon = ReferrerCount($user_id)  - GetCouponPurchase($user_id)  ?? '0';
        
        $user_detail =   User::where("id","=",$user_id)->first();
        
        $referrer_details = User::where("id","=",$user_detail->referrer_id)->first();
        $referrer_name = $referrer_details->username  ?? 'Not Specified';
        
        $response = array(
            'referral_token' => $user_details->referral_token,
            'referrer_count' => $referrer_count,
            'earned_coupon' => $referrer_count,
            'referrer_name' => $referrer_name,
            'used_coupon' => $used_coupon,
            'available_coupon' => $available_coupon
        );
            
    return response()->json($response, 200);
    }
    
    public function becomesubscriber(Request $request)
     {
        
        $stripe_plan = SubscriptionPlan();
      $user_id = $request->get('userid');
      $plan = $request->get('subscrip_plan');
      $user = User::find($user_id);
      $paymentMethod = $request->get('py_id');
    $user->newSubscription('test', $plan)->create($paymentMethod);
       if ( $user->subscribed('test') ) { 
      $user = User::find($userid);
      $user->role = 'subscriber';
      $user->active = 1;
      $user->save();
      $users = User::find($userid);
      $id = $users->id;
      $role = $users->role;
      $username = $users->username;
      $password = $users->password;
      $email = $users->email;
      $avatar = $users->avatar;

      $user_details = array([
        'user_id'=>$id,
        'role'=>$role,
        'username'=>$username,
        'email'=>$email,
        'avatar'=>URL::to('/').'/public/uploads/avatars/'.$avatar
      ] );

      $response = array(
          'status' => 'true',
          'next-billing' => '',
          'user_details'=> $user_details
        );
            }else{
                $response = array(
                    'status' => 'false'
                );
            }

    return response()->json($response, 200);
    }
    
    
public function checkEmailExists(Request $request)
    {
      $email = $request->get('email');
      $username = $request->get('username');
       
       if ( isset($email) && !isset($username)  )
       {
           if (User::where('email', '=', $email)->exists()) {
          $response = array(
                    'status' =>  'false',
                    'message' =>  'Email Already Exists'
                );
            } else {
                   $response = array(
                        'status' =>  'true',
                        'message' =>  ''
                    );
           }
           
       } elseif( !isset($email) && isset($username)){
           
               if (User::where('username', '=', $username)->exists()) {
                    $response = array(
                        'status' =>  'false',
                        'message' =>  'Username Already Exists'
                    );
                   } else {
                           $response = array(
                                'status' =>  'true',
                                'message' =>  ''
                            );
                   }
        }
       
       elseif( isset($email) && isset($username)){
           
               if (User::where('username', '=', $username)->exists() && User::where('email', '=', $email)->exists()) {
                     $response = array(
                        'status' =>  'false',
                        'message' =>  'Username or Email Already Exists'
                    );
                 } elseif (User::where('username', '=', $username)->exists()){
                    $response = array(
                        'status' =>  'false',
                        'message' =>  'Username  Already Exists'
                    );
                 }elseif(User::where('email', '=', $email)->exists()){
                    $response = array(
                        'status' =>  'false',
                        'message' =>  'Email  Already Exists'
                    );
                }
                else {
                    $response = array(
                                'status' =>  'true',
                                'message' =>  ''
                            );
                   }
           } else {
                    $response = array(
                                'status' =>  'true',
                                'message' =>  ''
                            );
       }
      return response()->json($response, 200);
    }

    public function subscriptiondetail(Request $request)
    {
      $userid = $request->user_id;
        $stripe_plan = SubscriptionPlan();
      $user = User::where('id', '=', $userid)->first();
      if ( $user->subscribed($stripe_plan) ) { 
        if ($user->subscription($stripe_plan)->onGracePeriod()) { 
          $status = 'Renew Subscription';
        }
        else { 
          $status = 'Cancel Subscription';
        } 
      } 
      else { 
        $status = 'Become Subscriber';
      } 
      $response = array(
        'status' => $status

      );
      return response()->json($response, 200);
    }
    
        
    public function SendOtp(Request $request) {
       /* $mobile = $request->get('mobile');
        $rcode = $request->get('ccode');
        $ccode = $rcode;
        $mobile_number = $ccode.$mobile;
        $user_count = VerifyNumber::where('number','=',$mobile_number)->count(); 
        $user_mobile_exist = User::where('mobile','=',$mobile)->count();
        $user_id= VerifyNumber::where('number','=',$mobile_number)->first();   
        $basic  = new \Nexmo\Client\Credentials\Basic('8c2c8892', '05D2vuG2VbYw2tQZ');
        $client = new \Nexmo\Client($basic);
        
        
        if ($user_mobile_exist > 0 ){
                $response = array(
                    'status' => false,
                    'message' => 'This number already Exist, try with another number'
               );
         return response()->json($response, 200);             
        }
        elseif ( $user_count > 0  ) {
          
       
            try {
                 $verification = $client->verify()->start([ 
                                      'number' =>  $ccode.$mobile,
                                      'brand'  => 'Flicknexs ',
                                      'code_length'  => '4']);
                    $verification_id =$verification->getRequestId();
                    $response = array(
                        'status' => true,
                        'message' => 'OTP has been sent to your number',
                        'verify'=>$verification_id,
                        'mobile' => $mobile_number
                    );
                  return response()->json($response, 200);
                }catch(\Vonage\Client\Exception\Request $e){
                    $response = array(
                                    'status' => false,
                                    'message' => 'Invalid number or Try after 5mins'
                                );
                    return response()->json($response, 200);
                }    
                                
        } else {
              try {
                     $verification = $client->verify()->start([ 
                        'number' =>  $ccode.$mobile,
                        'brand'  => 'Flicknexs ',
                        'code_length'  => '4']);
                  
                        $verification_id =$verification->getRequestId();
                        $response = array(
                            'status' => true,
                            'message' => 'OTP has been sent to your number',
                            'verify'=>$verification_id,
                            'mobile' => $mobile_number
                        );
                      return response()->json($response, 200);
                    }catch(\Vonage\Client\Exception\Request $e){
                        $response = array(
                                        'status' => false,
                                        'message' => 'Invalid number or Try after 5mins'
                                    );
                        return response()->json($response, 200);
                    }    
        }   */
        $response = array(
          'status' => true
        );
        return response()->json($response, 200);   
        } 
    
    public function VerifyOtp(Request $request){
            /*$otp = $request->get('otp');
            $verify_id = $request->get('verify_id');

                $basic  = new \Nexmo\Client\Credentials\Basic('8c2c8892', '05D2vuG2VbYw2tQZ');
                $client = new \Nexmo\Client($basic);
                $request_id = $verify_id;
            
               try{
                $verification = new \Nexmo\Verify\Verification($request_id);
                $result = $client->verify()->check($verification, $otp);     
        
            
                    $response = array(
                                    'status' => true,
                                    'message' => 'OTP has been verified'
                    );
                
                    return response()->json($response, 200);
                } catch(\Vonage\Client\Exception\Request $e){
                    $response = array(
                                    'status' => false,
                                    'message' => 'Invalid Code'
                                );
                    return response()->json($response, 200);
                }  */
                 $response = array(
                                    'status' => true,
                                    'message' => 'OTP has been verified'
                    );
                
                    return response()->json($response, 200);
    }
    
  public function CheckBlockList(Request $request){
        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
        $mycountry = $geoip->getCountry();

        $allCountries = Country::all()->pluck('country_name');
        $user_country = Country::where('country_name', '=', $mycountry)->first();
        if ($user_country !== null) {
            $response = array('status' => true,
                              'message' => 'Blocked'
            );
        } else {
            $response = array('status' => false,
                              'message' => 'Can Access'
            );
        }
        return response()->json($response, 200);
    }
    
    public function SocialUser(Request $request) {
    /*Parameters*/
    $input = $request->all();
    $username = $input['username'];
    $email = $input['email'];
    $user_url = $input['user_url'];
    $login_type = $input['login_type'];//Facebook or Google
    /*Parameters*/
    /*Profile image move to avatar folder*/
    if($user_url != ''){
      $name = $username.".jpg";
      //local site
      //$path = $_SERVER['DOCUMENT_ROOT'].'/flicknexs/public/uploads/avatars'.$name;
      //live site
      $path = $_SERVER['DOCUMENT_ROOT'].'/public/uploads/avatars/'.$name;
          $arrContextOptions=array(
        "ssl"=>array(
          "verify_peer"=>false,
          "verify_peer_name"=>false,
        ),
      );  
      $contents = file_get_contents($user_url, false, stream_context_create($arrContextOptions));
         file_put_contents($path, $contents);

    }else{
      $name = '';
    }

    if($login_type == 'facebook'){ //Facebook
      $check_exists = User::where('email', '=', $email)->where('user_type', '=', $login_type)->count();
      if($check_exists > 0){//Login
        $user_details = User::where('email', '=', $email)->get();
        $response = array(
          'status'      =>'true',
          'message'     =>'Login Success',
          'user_details'=>$user_details
        );
      }else{//Signup
        $data = array(
          'username' =>$username,  
          'email'    =>$email,
          'user_type'=>$login_type,
          'avatar'   =>$name,
          'role'     =>'registered',
          'password' =>'null'
        );

        $user = new User;
        $user->insert($data);
        $user_details = User::where('username', '=', $username)->get();
        $response = array(
          'status'       =>'true',
          'message'      =>'Account Created ',
          'user_details' => $user_details
        );
      }
    }
    if($login_type == 'google'){ //Google
      $check_exists = User::where('email', '=', $email)->where('user_type', '=', $login_type)->count();
      if($check_exists > 0) {//Login
        $user_details = User::where('email', '=', $email)->get();
        $response = array(
          'status'      =>'true',
          'message'     =>'Login Success',
          'user_details'=>$user_details
        );
      }else{//Signup
        $data = array(
          'username' =>$username,  
          'email'    =>$email,
          'user_type'=>$login_type,
          'avatar'   =>$name,
          'role'     =>'registered',
          'password' =>'null'
        );

        $user = new User;
        $user->insert($data);
        $user_details = User::where('username', '=', $username)->get();
        $response = array(
          'status'       =>'true',
          'message'      =>'Account Created ',
          'user_details' => $user_details
        );
      }
    }

    if($username == null || $login_type == null){
      $response = array(
          'status'       =>'false',
          'message'      =>'Empty Request'
        );
    }

    return response()->json($response, 200);
  }

  public function SkipTime(){

    $response = array(
      'skip_time'   =>'5',
      'intro_time' =>'10'
    );
    return response()->json($response, 200);
  }

  public function LikeDisLike(Request $request)
  {
    $video_id = $request->video_id;
    $like = $request->like;
    $user_id = $request->user_id;
    $video = LikeDisLike::where("video_id","=",$video_id)->where("user_id","=",$user_id)->get();
    $video_count = LikeDisLike::where("video_id","=",$video_id)->where("user_id","=",$user_id)->count();
    if ($video_count >0 ) {
      $video_new = LikeDisLike::where("video_id","=",$video_id)->where("user_id","=",$user_id)->first();
      $video_new->status = $like;
      $video_new->video_id = $video_id;
      $video_new->save();
      $response = array(
        'status'   =>true
      );
    } else {
      $video_new = new LikeDisLike;
      $video_new->video_id = $video_id;
      $video_new->user_id = $user_id;
      $video_new->status = $like;
      $video_new->save();
      $response = array(
        'status'   =>true
      );
    }
    return response()->json($response, 200);
  }

    public function serieslist()
    {
      $series = Series::where('active', '=', '1')->get()->map(function ($item) {
        $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
        $item['mp4_url'] = URL::to('/').'/storage/app/public/'.$item->mp4_url;
        return $item;
      });
      
      $settings = Setting::first();
      $response = array(
        'series' => $series,
        "settings"   => $settings,

        );
      return response()->json($response, 200);
    }

    public function PurchaseSeries(Request $request)
    {
      $seriesid = $request->seriesid;
      $user_id = $request->user_id;

      $series = Series::where('id', '=', $seriesid)->where('active', '=', '1')->get()->map(function ($item) {
        $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
        $item['mp4_url'] = URL::to('/').'/storage/app/public/'.$item->mp4_url;
        return $item;
      });
      if (!empty($seriesid)) {
        $ppv_exist = PpvPurchase::where('user_id',$user_id)
        ->where('series_id',$seriesid)
        ->count();
      } else {
        $ppv_exist = 0;
      }
        if ($ppv_exist > 0) {
    
              $ppv_video_status = "can_view";
    
          } else {
                $ppv_video_status = "pay_now";
          }
      $seasonfirst = SeriesSeason::where('series_id','=',$seriesid)->first();
      $settings = Setting::first();
      $response = array(
        'series' => $series,
        'seasonfirst' => $seasonfirst,
        'ppv_video_status' => $ppv_video_status,
        "settings"   => $settings,

        );
      return response()->json($response, 200);
    }

  public function seasonlist(Request $request){
      $seriesid = $request->seriesid;
      $season = SeriesSeason::where('series_id','=',$seriesid)->get();
      $seasonfirst = SeriesSeason::where('series_id','=',$seriesid)->first();
      $first_season_id = $seasonfirst->id;
      $response = array(
        'status'=>'true',
        'message'=>'success',
        'first_season_id'=> $first_season_id,
        'season' => $season
      );
      return response()->json($response, 200);
    }
    public function seriesepisodes(Request $request){
    
      $season_id = $request->seasonid;
      
      $episodes = Episode::where('season_id','=',$season_id)->get()->map(function ($item) {
         $item['image'] = URL::to('/').'/public/uploads/images/'.$item->image;
         return $item;
       });
      
      $response = array(
        'status'=>'true',
        'message'=>'success',
        'episodes' => $episodes
      );
      
      return response()->json($response, 200);
      
    }
    
    
    public function episodedetails(Request $request){
      
      $episodeid = $request->episodeid;

      $episode = Episode::where('id',$episodeid)->get()->map(function ($item) {
         $item['image'] = URL::to('/').'/public/uploads/images/'.$item->image;
         return $item;
       });
      //  print_r($episode);exit;
       
      if($request->user_id != ''){
        $user_id = $request->user_id;
        $cnt = Wishlist::select('episode_id')->where('user_id','=',$user_id)->where('episode_id','=',$request->episodeid)->count();
        $wishliststatus =  ($cnt == 1) ? "true" : "false";
        // $userrole = User::find($user_id)->pluck('role');
      }else{
        $wishliststatus = 'false';
        // $userrole = '';
      } 
      if(!empty($request->user_id)){
        $user_id = $request->user_id;
        $cnt = Watchlater::select('episode_id')->where('user_id','=',$user_id)->where('episode_id','=',$request->episodeid)->count();
        $watchlaterstatus =  ($cnt == 1) ? "true" : "false";
        // $userrole = User::find($user_id)->pluck('role');
      }else{
        $watchlaterstatus = 'false';
        // $userrole = '';
      }
      if($request->user_id != ''){
      $like_data = LikeDisLike::where("episode_id","=",$episodeid)->where("user_id","=",$user_id)->where("liked","=",1)->count();
      $dislike_data = LikeDisLike::where("episode_id","=",$episodeid)->where("user_id","=",$user_id)->where("disliked","=",1)->count();
      $favoritestatus = Favorite::where("episode_id","=",$episodeid)->where("user_id","=",$user_id)->count();
      $like = ($like_data == 1) ? "true" : "false";
      $dislike = ($dislike_data == 1) ? "true" : "false";
      $favorite = ($favoritestatus > 0) ? "true" : "false";
      // $userrole = User::find($user_id)->pluck('role');

    }else{
      $like = 'false';
      $dislike = 'false';
      $favorite = 'false';
      // $userrole = '';
    }
    if(!empty($request->user_id)){
      $user_id = $request->user_id;
      $users = User::where('id','=',$user_id)->first();
      $userrole = $users->role;
    }else{
      $userrole = '';
    }

    $series_id = Episode::where('id','=',$episodeid)->pluck('series_id');

    if(!empty($series_id)){
      $series_id = $series_id[0];
      
    $main_genre = SeriesCategory::Join('genres','genres.id','=','series_categories.category_id')
    ->where('series_categories.series_id',$series_id)->get('name');

    $languages = SeriesLanguage::Join('languages','languages.id','=','series_languages.language_id')
    ->where('series_languages.series_id',$series_id)->get('name');
    }

    if(!empty($series_id) && !empty($main_genre)){
    foreach($main_genre as $value){
      $category[] = $value['name']; 
    }
  }else{
    $category = [];
  }
  // echo "<pre>";print_r($category);exit;

    if(!empty($category)){
    $main_genre = implode(",",$category);
    }else{
      $main_genre = "";
    }

    // echo "<pre>"; print_r($languages);exit;
    if(!empty($series_id) && !empty($languages)){
    foreach($languages as $value){
      $language[] = $value['name']; 
    }
  }else{
    $language = "";
  }
    if(!empty($language)){
    $languages = implode(",",$language);
    }else{
      $languages = "";
    }
    if (!empty($episode)) {
    $season = SeriesSeason::where('id',$episode[0]->season_id)->first();
    // print_r();exit;
    $ppv_exist = PpvPurchase::where('user_id',$user_id)
    ->where('season_id',$episode[0]->season_id)
    ->where('series_id',$episode[0]->series_id)
    ->count();
  } else {
    $ppv_exist = 0;
  }
    if ($ppv_exist > 0) {

          $ppv_video_status = "can_view";

      } else if (!empty($season) && $season->access != "ppv" || $season->access == "free") {
        $ppv_video_status = "can_view";
      }
      else {
            $ppv_video_status = "pay_now";
      }






      $response = array(
        'status'=>'true',
        'message'=>'success',
        'episode' => $episode,
        'ppv_video_status' => $ppv_video_status,
        'wishlist' => $wishliststatus,
        'watchlater' => $watchlaterstatus,
        'userrole' => $userrole,
        'favorite' => $favorite,                               
        'like' => $like,
        'dislike' => $dislike,
        'main_genre' =>preg_replace( "/\r|\n/", "", $main_genre ),
        'languages' => $languages,

      );
      return response()->json($response, 200);
    } 
    
    
    public function relatedepisodes(Request $request){
      
      $episodeid = $request->episodeid;
      $episode_count = Episode::where('id','=',$episodeid)->count();
      if($episode_count > 0){
      $season_id = Episode::where('id','=',$episodeid)->pluck('season_id');
      $episode = Episode::where('id','!=',$episodeid)->where('season_id','=',$season_id)->get()->map(function ($item) {
         $item['image'] = URL::to('/').'/public/uploads/images/'.$item->image;
         return $item;
       });
        $status = true;
       }else{
         $episode = [];
        $status = false;
       }
      
      $response = array(
        'status'=>$status,
        'message'=>'success',
        'related_episode' => $episode
      );
      return response()->json($response, 200);
    }


    public function LikeVideo(Request $request)
    {
      $user_id = $request->user_id;
      $video_id = $request->video_id;
      $like = $request->like;
      $d_like = Likedislike::where("video_id",$video_id)->where("user_id",$user_id)->count();

      if($d_like > 0){
        $new_vide_like = Likedislike::where("video_id",$video_id)->where("user_id",$user_id)->first();
        if($like == 1){
          $new_vide_like->user_id = $request->user_id;
          $new_vide_like->video_id = $request->video_id;
          $new_vide_like->liked = 1;
          $new_vide_like->disliked = 0; 
          $new_vide_like->save(); 
        }else{
          $new_vide_like->user_id = $request->user_id;
          $new_vide_like->video_id = $request->video_id;
          $new_vide_like->liked = 0;
          $new_vide_like->save(); 
        }
      }else{
        $new_vide_like = new Likedislike;
        $new_vide_like->user_id = $request->user_id;
        $new_vide_like->video_id = $request->video_id;
        $new_vide_like->liked = 1;
        $new_vide_like->disliked = 0;
        $new_vide_like->save(); 
      }

       $response = array(
        'status'=>'true',
        'liked' => $new_vide_like->liked,
        'disliked' => $new_vide_like->disliked,
        'message'=>'success'
      );
      
       return response()->json($response, 200); 

    }

    public function LikeAudio(Request $request)
    {
      $user_id = $request->user_id;
      $audio_id = $request->audios_id;
      $like = $request->like;
      $d_like = Likedislike::where("audio_id",$audio_id)->where("user_id",$user_id)->count();

      if($d_like > 0){
        $new_vide_like = Likedislike::where("audio_id",$audio_id)->where("user_id",$user_id)->first();
        if($like == 1){
          $new_vide_like->user_id = $request->user_id;
          $new_vide_like->audio_id = $request->audios_id;
          $new_vide_like->liked = 1;
          $new_vide_like->disliked = 0; 
          $new_vide_like->save(); 
        }else{
          $new_vide_like->user_id = $request->user_id;
          $new_vide_like->audio_id = $request->audios_id;
          $new_vide_like->liked = 0;
          $new_vide_like->save(); 
        }
      }else{
        $new_vide_like = new Likedislike;
        $new_vide_like->user_id = $request->user_id;
        $new_vide_like->audio_id = $request->audios_id;
        $new_vide_like->liked = 1;
        $new_vide_like->disliked = 0;
        $new_vide_like->save(); 
      }

       $response = array(
        'status'=>'true',
        'liked' => $new_vide_like->liked,
        'disliked' => $new_vide_like->disliked,
        'message'=>'success'
      );
      
       return response()->json($response, 200); 

    }

    public function DisLikeVideo(Request $request)
    {
      $user_id = $request->user_id;
      $video_id = $request->video_id;
      $dislike = $request->dislike;
      $d_like = Likedislike::where("video_id",$video_id)->where("user_id",$user_id)->count();

      if($d_like > 0){
        $new_vide_dislike = Likedislike::where("video_id",$video_id)->where("user_id",$user_id)->first();
        if($dislike == 1){
          $new_vide_dislike->user_id = $request->user_id;
          $new_vide_dislike->video_id = $request->video_id;
          $new_vide_dislike->liked = 0;
          $new_vide_dislike->disliked = 1; 
          $new_vide_dislike->save(); 
        }else{
          $new_vide_dislike->user_id = $request->user_id;
          $new_vide_dislike->video_id = $request->video_id;
          $new_vide_dislike->disliked = 0;
          $new_vide_dislike->save(); 
        }
      }else{
        $new_vide_dislike = new Likedislike;
        $new_vide_dislike->user_id = $request->user_id;
        $new_vide_dislike->video_id = $request->video_id;
        $new_vide_dislike->liked = 0;
        $new_vide_dislike->disliked = 1;
        $new_vide_dislike->save(); 
      }

       $response = array(
        'status'=>'true',
        'liked' => $new_vide_dislike->liked,
        'disliked' => $new_vide_dislike->disliked,
        'message'=>'success'
      );
      
       return response()->json($response, 200); 
    }

    public function DisLikeAudio(Request $request)
    {
      $user_id = $request->user_id;
      $audio_id = $request->audios_id;
      $dislike = $request->dislike;
      $d_like = Likedislike::where("audio_id",$audio_id)->where("user_id",$user_id)->count();

      if($d_like > 0){
        $new_vide_dislike = Likedislike::where("audio_id",$audio_id)->where("user_id",$user_id)->first();
        if($dislike == 1){
          $new_vide_dislike->user_id = $request->user_id;
          $new_vide_dislike->audio_id = $request->audios_id;
          $new_vide_dislike->liked = 0;
          $new_vide_dislike->disliked = 1; 
          $new_vide_dislike->save(); 
        }else{
          $new_vide_dislike->user_id = $request->user_id;
          $new_vide_dislike->audio_id = $request->audios_id;
          $new_vide_dislike->disliked = 0;
          $new_vide_dislike->save(); 
        }
      }else{
        $new_vide_dislike = new Likedislike;
        $new_vide_dislike->user_id = $request->user_id;
        $new_vide_dislike->audio_id = $request->audios_id;
        $new_vide_dislike->liked = 0;
        $new_vide_dislike->disliked = 1;
        $new_vide_dislike->save(); 
      }

       $response = array(
        'status'=>'true',
        'liked' => $new_vide_dislike->liked,
        'disliked' => $new_vide_dislike->disliked,
        'message'=>'success'
      );
      
       return response()->json($response, 200); 
    }
    
    public function MobileSignup(Request $request)
      {
        $username = $request->username;
        $email = $request->email;
        $mobile = $request->mobile;
        $existing_user = User::where("email","=",$email)->count();
        if ( $existing_user > 0 ) {
          
          $response = array(
            'status'=>'false',
            'message'=>'success'
          );
        } else {
            $user = new User;
            $user->mobile =$mobile;
            $user->email = $email;
            $user->username = $username;
            $user->active = 1;
            $user->user_type = 'firebase';
            $user->save();
            $response = array(
                'status'=>'true',
                'user_details' => array($user),
                'message'=>'success'
            );
        }

         return response()->json($response, 200); 
      }
  
  public function CastList() {

      $casts = Cast::all()->map(function ($item) {
        $item['cast_image'] = URL::to('/').'/public/uploads/avatars/casts/'.$item->cast;
        return $item;
      });

      $response = array(
        'status'=>'true',
        'casts' => $casts,
        'message'=>'success'
      );

       return response()->json($response, 200);
  }
  public function SeriesTitle(){
    $mobile_settings = DB::table('mobile_apps')->first();
    $response = array(
      'status'=>'true',
      'message'=>'success',
      'series_status'=> $mobile_settings->series_title
    );
    return response()->json($response, 200);
  }

  public function VideoCast(Request $request) {
      $video_id = $request->video_id;
      $video = Video::where("id","=",$video_id)->first();
      $cast_count = Video::where("id","=",$video_id)->count();
      if ($cast_count > 0 ) {
      $array_cast = explode(", ",$video->cast);     
      foreach ($array_cast as $cast_id) {
          $cast_details[] = Cast::where("id","=",$cast_id)->first() ;
      }
      $response = array(
        'status'=>'true',
        'message'=>'success',
        'image_path'=> URL::to('/public/uploads/images/casts/'),
        'cast_details'=> $cast_details
      );
    } else{
      $response = array(
        'status'=>'false'
      );
    }
      return response()->json($response, 200);

    }
    public function UserComments(Request $request){
                     
          $comments =  Comment::where("video_id","=",$request->video_id)
         ->where('user_id',$request->user_id)->get()->map(function ($item) {
            $i = 0;
            while ($i<= $item->count()) {
              $user =  User::where("id","=",$item->user_id)->get()->first();
              if (!empty($user->avatar)) {
                $item['user_profile'] = URL::to('/').'/public/uploads/avatars/'.$user->avatar;
              } else {
                $item['user_profile'] = null;
              }

              if (!empty($user->username)) {
                $item['username'] = $user->username;
              } else {
                $item['username'] = null;
              }
              $i++;
            }           
            return $item;
          });

          $video_comments = Comment::join("users","users.id", "=", "comments.user_id")
          ->select('comments.*','users.username','users.avatar')
          ->where("comments.video_id", "=", $request->video_id)
          ->get()
          ->map(function ($item) {
            $item['image_url'] = URL::to('/').'/public/uploads/artists/'.$item->avatar;
            return $item;
          });
          $response = array(
            'status'=>'true',
            'video_comments'=>$comments,
            'user_comments'=>$video_comments,
          );

          return response()->json($response, 200);
    }

    public function AddComment(Request $request){
      
      $video_id = $request->video_id;
      $user_id = $request->user_id;
      $body = $request->body;
      $comment = new Comment;
      $comment->user_id = $user_id;
      $comment->video_id = $video_id;
      $comment->body = $body;
      $comment->save();
      $response = array(
        'status'=>'true',
        'message'=> "Comment Has been added"
      );

      return response()->json($response, 200);

    }
    public function NextVideo(Request $request) {

      $currentvideo_id = $request->id;

      $next_videoid = Video::where('id', '>', $currentvideo_id)->where('status','=','1')->where('active','=','1')->min('id');

      if($next_videoid){
        $video= Video::where('id','=',$next_videoid)->where('status','=','1')->where('active','=','1')->get();
        $response = array(
          'status' => true,
          'next_videoid' => $next_videoid,
          'video' => $video
        );
      }else{
        $response = array(
          'status' => false,
          'video' => 'No Data Found'
        );
      }
      return response()->json($response, 200);
  }

  public function PrevVideo(Request $request){

    // $user_id = $request->user_id;
    $currentvideo_id = $request->id;
    $prev_videoid = Video::where('id', '<', $currentvideo_id)->where('status','=','1')->where('active','=','1')->orderBy('created_at', 'desc')->max('id');
    if($prev_videoid){
        $video= Video::where('id','=',$prev_videoid)->where('status','=','1')->where('active','=','1')->get();
        $response = array(
          'status' => true,
          'prev_videoid' => $prev_videoid,
          'video' => $video
        );
      }else{
        $response = array(
          'status' => false,
          'video' => 'No Data Found'
        );
      }
      return response()->json($response, 200);
  }
    

public function upnextAudio(Request $request){
        
         
        $audio_id = $request->audio_id;
        $album_id  = CategoryAudio::where('audio_id',$audio_id)->pluck('category_id')->first();
        $upnext_audios =  Audio::join('category_audios', 'audio.id', '=', 'category_audios.audio_id')
        ->select('audio.*')
        ->where('category_id', $album_id)
        ->count();
        // $album_id = \Audio::where('id','=',$audio_id)->where('active','=','1')->where('status','=','1')->pluck('album_id');
        
        //$album_id = $request->album_id;
    // $album_first = \Audio::where('album_id','=',$album_id)->where('active','=','1')->where('status','=','1')->limit(1)->get();
        
    // $album_all_audios = \Audio::where('album_id','=',$album_id)->where('id','!=',$audio_id)->where('active','=','1')->where('status','=','1')->orderBy('created_at', 'desc')->get();
if($upnext_audios > 0){
  $album_all_audios =  Audio::join('category_audios', 'audio.id', '=', 'category_audios.audio_id')
  ->select('audio.*')
  ->where('category_id', $album_id)
  ->get();
    $response = array(
      'status'=>'true',
      'message'=>'success',
      'audio_albums' =>$album_all_audios
    );
  }else{
    $response = array(
      'status'=>'false',
      'message'=>'success',
      'audio_albums' =>'No Upnext Audios Added'
    );
  }
    return response()->json($response, 200);
  }   


  public function similarAudio(Request $request){
        
         
    $audio_id = $request->audio_id;
    $album_id  = CategoryAudio::where('audio_id',$audio_id)->pluck('category_id')->first();
    $similarAudio =  Audio::join('category_audios', 'audio.id', '=', 'category_audios.audio_id')
    ->select('audio.*')
    ->where('category_id','!=', $album_id)
    ->count();

if($similarAudio > 0){
$similar_Audio =  Audio::join('category_audios', 'audio.id', '=', 'category_audios.audio_id')
->select('audio.*')
->where('category_id','!=', $album_id)
->get();
$response = array(
  'status'=>'true',
  'message'=>'success',
  'similar_audio' =>$similar_Audio
);
}else{
$response = array(
  'status'=>'false',
  'message'=>'success',
  'similar_audio' =>'No Similar Audios Added'
);
}
return response()->json($response, 200);
}   
  //Login with Mobile number
  public function MobileLogin(Request $request)
  {
    $mobile = $request->mobile;
    $existing_user = User::where("mobile","=",$mobile)->count();
    if ( $existing_user > 0 ) {
      $user_data = User::where("mobile","=",$mobile)->get();
      $response = array(
        'status'=>'true',
        'user_data'=>$user_data,
        'otp' => rand(1000,9999),
        'message'=>'success'
      );
    } else {
      $response = array(
        'status'=>'false',
        'message'=>'Mobile Number not exist. Please Register.'
      );
    }

    //return Response::json($response, 200);
      return response()->json($response, 200);
  }   


  /* Season and Episode details*/
  public function SeasonsEpisodes(Request $request)
  {
    $seriesid = $request->seriesid;
    $myData = array();
    $seasonlist = SeriesSeason::where('series_id',$seriesid)->get()->toArray();
    // print_r($seasonlist);exit();

    foreach ($seasonlist as $key => $season) {
      $seasonid = $season['id'];
      $episodes= Episode::where('season_id',$seasonid)->where('active','=',1)->get()->map(function ($item)  {
        $item['image'] = URL::to('/').'/public/uploads/images/'.$item->image;
        return $item;
      });;

      if(count($episodes) > 0){
        $msg = 'success';
      }else{
        $msg = 'nodata';
      }
      $season_name = 'Season '.($key+1);
      $settings = Setting::first();

      $myData[] = array(
        "season_name"   => $season_name,
        "settings"   => $settings,
        "season_id"   => $seasonid,
        "message" => $msg,
        "episodes" => $episodes
      );
    }

    
    $response = array(
      'status' => 'true',
      'SeasonsEpisodes' => $myData
    );

    return response()->json($response, 200);
  } 

  public function SeasonsPPV(Request $request)
  {
    $season_id = $request->season_id;
    $episode_id = $request->episode_id;

    $episode = Episode::where('id','=',$episode_id)->orderBy('id', 'DESC')->first();    
    // $season = SeriesSeason::where('series_id','=',$episode->series_id)->with('episodes')->get();
    $season = SeriesSeason::where('series_id','=',$episode->series_id)->where('id','=',$season_id)
    ->with('episodes')->get();
    if(!empty($season)){
      $ppv_price = $season[0]->ppv_price;
      $ppv_interval = $season[0]->ppv_interval;
      $season_id = $season[0]->id;
  }
  // Free Interval Episodes   

  if(!empty($ppv_price) && !empty($ppv_interval)){
      foreach($season as $key => $seasons):  
          foreach($seasons->episodes as $key => $episodes):
                  if($seasons->ppv_interval > $key):
                      $free_episode[$episodes->id] = Episode::where('id','=',$episode_id)->count();    
                  else :
                      $paid_episode[] = Episode::where('slug','=',$episodes->slug)->orderBy('id', 'DESC')->count();  
                  endif;
          endforeach; 
      endforeach;
      if (array_key_exists($episode_id,$free_episode)){ 
        $free_episode = 'Free';  
      }else{ 
        $free_episode = 'PPV'; 
      }
      if(empty($free_episode)){

        $free_episode = 'PPV'; 
      }
  }else{
    $free_episode = 'PPV'; 
  }

    $response = array(
      'status' => 'true',
      'access' => $free_episode,
      'episode' => $episode,
      'season' => $season,
    );

    return response()->json($response, 200);
  } 


  public function nextwishlistvideo(Request $request)
  {
    $user_id = $request->user_id;
    $video_id = $request->video_id;
    $next_videoid = Wishlist::where('video_id', '>', $video_id)->where('user_id', '=', $user_id)->min('video_id');

    if($next_videoid){
      $video= Video::where('id','=',$next_videoid)->where('status','=','1')->where('active','=','1')->get();
      $response = array(
        'status' => true,
        'next_videoid' => $next_videoid,
        'video' => $video
      );
    }else{
      $response = array(
        'status' => false,
        'video' => 'No Data Found'
      );
    }
    return response()->json($response, 200);
  }

  public function prevwishlistvideo(Request $request)
  {
    $user_id = $request->user_id;
    $video_id = $request->video_id;
  
    $prev_videoid = Wishlist::where('video_id', '<', $request->video_id)->where('user_id', '=', $user_id)->max('video_id');
    if($prev_videoid){
      $video= Video::where('id','=',$prev_videoid)->where('status','=','1')->where('active','=','1')->get();
      $response = array(
        'status' => true,
        'prev_videoid' => $prev_videoid,
        'video' => $video
      );
    }else{
      $response = array(
        'status' => false,
        'video' => 'No Data Found'
      );
    }
    return response()->json($response, 200);
  }


  public function nextwatchlatervideo(Request $request)
  {
    $user_id = $request->user_id;
    $video_id = $request->video_id;
    $next_videoid = Watchlater::where('video_id', '>', $video_id)->where('user_id', '=', $user_id)->min('video_id');
    if($next_videoid){
      $video= Video::where('id','=',$next_videoid)->where('status','=','1')->where('active','=','1')->get();
      $response = array(
        'status' => true,
        'next_videoid' => $next_videoid,
        'video' => $video
      );
    }else{
      $response = array(
        'status' => false,
        'video' => 'No Data Found'
      );
    }
    return response()->json($response, 200);
  }

  public function prevwatchlatervideo(Request $request)
  {
    $user_id = $request->user_id;
    $video_id = $request->video_id;

    $prev_videoid = Watchlater::where('video_id', '<', $video_id)->where('user_id', '=', $user_id)->max('video_id');
    if($prev_videoid){
      $video= Video::where('id','=',$prev_videoid)->where('status','=','1')->where('active','=','1')->get();
      $response = array(
        'status' => true,
        'prev_videoid' => $prev_videoid,
        'video' => $video
      );
    }else{
      $response = array(
        'status' => false,
        'video' => 'No Data Found'
      );
    }
    return response()->json($response, 200);
  }

  public function nextfavouritevideo(Request $request)
  {
    $user_id = $request->user_id;
    $video_id = $request->video_id;
    $next_videoid = Favorite::where('video_id', '>', $video_id)->where('user_id', '=', $user_id)->min('video_id');
    if($next_videoid){
      $video= Video::where('id','=',$next_videoid)->where('status','=','1')->where('active','=','1')->get();
      $response = array(
        'status' => true,
        'next_videoid' => $next_videoid,
        'video' => $video
      );
    }else{
      $response = array(
        'status' => false,
        'video' => 'No Data Found'
      );
    }
    return response()->json($response, 200);
  }

  public function prevfavouritevideo(Request $request)
  {
    $user_id = $request->user_id;
    $video_id = $request->video_id;
    $prev_videoid = Favorite::where('video_id', '<', $video_id)->where('user_id', '=', $user_id)->max('video_id');
    if($prev_videoid){
      $video= Video::where('id','=',$prev_videoid)->where('status','=','1')->where('active','=','1')->get();
      $response = array(
        'status' => true,
        'prev_videoid' => $prev_videoid,
        'video' => $video
      );
    }else{
      $response = array(
        'status' => false,
        'video' => 'No Data Found'
      );
    }
    return response()->json($response, 200);
  }


   public function NextEpisode(Request $request) {

      $seasonid = $request->seasonid;
      $episode_id = $request->episode_id;

      $next_episodeid = Episode::where('id', '>', $episode_id)->where('season_id','=',$seasonid)->where('active','=','1')->where('status','=','1')->min('id');

      if($next_episodeid){
        $episode= Episode::where('id','=',$next_episodeid)->where('status','=','1')->where('active','=','1')->get();
        $response = array(
          'status' => true,
          'next_episodeid' => $next_episodeid,
          'episode' => $episode
        );
      }else{
        $response = array(
          'status' => false,
          'episode' => 'No Data Found'
        );
      }
      return response()->json($response, 200);
  }

  public function PrevEpisode(Request $request){

    $seasonid = $request->seasonid;
    $episode_id = $request->episode_id;

    $prev_episodeid = Episode::where('id', '<', $episode_id)->where('season_id','=',$seasonid)->where('status','=','1')->where('active','=','1')->orderBy('created_at', 'desc')->max('id');
    if($prev_episodeid){
        $episode= Episode::where('id','=',$prev_episodeid)->where('status','=','1')->where('active','=','1')->get();
        $response = array(
          'status' => true,
          'prev_episodeid' => $prev_episodeid,
          'episode' => $episode
        );
      }else{
        $response = array(
          'status' => false,
          'episode' => 'No Data Found'
        );
      }
      return response()->json($response, 200);
  }


  public function nextwatchlaterEpisode(Request $request)
  {
    $user_id = $request->user_id;
    $episode_id = $request->episode_id;
    $next_episodeid = Watchlater::where('episode_id', '>', $episode_id)->where('user_id', '=', $user_id)->min('episode_id');
    if($next_episodeid){
      $episodes= Episode::where('id','=',$next_episodeid)->where('status','=','1')->where('active','=','1')->get();
      $response = array(
        'status' => true,
        'next_episodeid' => $next_episodeid,
        'episodes' => $episodes
      );
    }else{
      $response = array(
        'status' => false,
        'episodes' => 'No Episodes Found'
      );
    }
    return response()->json($response, 200);
  }

  public function prevwatchlaterEpisode(Request $request)
  {
    $user_id = $request->user_id;
    $episode_id = $request->episode_id;

    $prev_episodeid = Watchlater::where('episode_id', '<', $episode_id)->where('user_id', '=', $user_id)->max('episode_id');
    if($prev_episodeid){
      $episodes= Episode::where('id','=',$prev_episodeid)->where('status','=','1')->where('active','=','1')->get();
      $response = array(
        'status' => true,
        'prev_episodeid' => $prev_episodeid,
        'episodes' => $episodes
      );
    }else{
      $response = array(
        'status' => false,
        'episodes' => 'No Episodes Found'
      );
    }
    return response()->json($response, 200);
  }

  public function nextfavouriteEpisode(Request $request)
  {
    $user_id = $request->user_id;
    $episode_id = $request->episode_id;
    $next_episodeid = Favorite::where('episode_id', '>', $episode_id)->where('user_id', '=', $user_id)->min('episode_id');
    if($next_episodeid){
      $episodes= Episode::where('id','=',$next_episodeid)->where('status','=','1')->where('active','=','1')->get();
      $response = array(
        'status' => true,
        'next_episodeid' => $next_episodeid,
        'episodes' => $episodes
      );
    }else{
      $response = array(
        'status' => false,
        'episodes' => 'No Episodes Found'
      );
    }
    return response()->json($response, 200);
  }

  public function prevfavouriteEpisode(Request $request)
  {
    $user_id = $request->user_id;
    $episode_id = $request->episode_id;
    $prev_episodeid = Favorite::where('episode_id', '<', $episode_id)->where('user_id', '=', $user_id)->max('episode_id');
    if($prev_episodeid){
      $episodes= Episode::where('id','=',$prev_episodeid)->where('status','=','1')->where('active','=','1')->get();
      $response = array(
        'status' => true,
        'prev_episodeid' => $prev_episodeid,
        'episodes' => $episodes
      );
    }else{
      $response = array(
        'status' => false,
        'episodes' => 'No Episodes Found'
      );
    }
    return response()->json($response, 200);
  }
  public function nextwishlistEpisode(Request $request)
  {
    $user_id = $request->user_id;
    $episode_id = $request->episode_id;
    $next_episodeid = Wishlist::where('episode_id', '>', $episode_id)->where('user_id', '=', $user_id)->min('episode_id');

    if($next_episodeid){
      $episodes= Episode::where('id','=',$next_episodeid)->where('status','=','1')->where('active','=','1')->get();
      $response = array(
        'status' => true,
        'next_episodeid' => $next_episodeid,
        'episodes' => $episodes
      );
    }else{
      $response = array(
        'status' => false,
        'episodes' => 'No Episodes Found'
      );
    }
    return response()->json($response, 200);
  }

  public function prevwishlistEpisode(Request $request)
  {
    $user_id = $request->user_id;
    $episode_id = $request->episode_id;
  
    $prev_episodeid = Wishlist::where('episode_id', '<', $request->episode_id)->where('user_id', '=', $episode_id)->max('video_id');
    if($prev_episodeid){
      $episodes= Episode::where('id','=',$prev_episodeid)->where('status','=','1')->where('active','=','1')->get();
      $response = array(
        'status' => true,
        'prev_episodeid' => $prev_episodeid,
        'episodes' => $episodes
      );
    }else{
      $response = array(
        'status' => false,
        'episodes' => 'No Episodes Found'
      );
    }
    return response()->json($response, 200);
  }
  public function Playerui(Request $request){
    $playerui = Playerui::find(1);
    if($playerui){
      $response = array(
        'status' => true,
        'playerui' => $playerui
      );
    }else{
      $response = array(
        'status' => false,
        'playerui' => 'No Data Found'
      );
    }
    // $response = $playerui;
      return response()->json($response, 200);
  }

  
  public function addtocontinuewatching(Request $request)
  {
      $user_id = $request->user_id;
      $current_duration = $request->current_duration;
      $watch_percentage = $request->watch_percentage;
      if(!empty($request->skip_time)){
      $skip_time = $request->skip_time;
      }else{
        $skip_time = 0;
      }
      if($request->video_id){
          $video_id = $request->video_id;
          $count = ContinueWatching::where('user_id', '=', $user_id)->where('videoid', '=', $video_id)->count();
          if ( $count > 0 ) {
            ContinueWatching::where('user_id', '=', $user_id)->where('videoid', '=', $video_id)->update(['currentTime' => $current_duration,'watch_percentage' => $watch_percentage,'skip_time' => $skip_time]);
            $response = array(
              'status'=>'true',
              'message'=>'Current Time updated'
          );
        } else {
            $data = array('user_id' => $user_id, 'videoid' => $video_id,'currentTime' => $current_duration,'watch_percentage' => $watch_percentage,'skip_time' => $skip_time );
            ContinueWatching::insert($data);
            $response = array(
              'status'=>'true',
              'message'=>'Added  to  Continue Watching List'
          );

        }
      }
      

      return response()->json($response, 200);
  }

  public function listcontinuewatchings(Request $request)
  {

      $user_id = $request->user_id;
    /*channel videos*/
    $video_ids = ContinueWatching::where('videoid','!=',NULL)->where('user_id','=',$user_id)->get();
    $video_ids_count = ContinueWatching::where('videoid','!=',NULL)->where('user_id','=',$user_id)->count();

    if ( $video_ids_count  > 0) {

      foreach ($video_ids as $key => $value1) {
        $k2[] = $value1->videoid;
      }
      $videos = Video::whereIn('id', $k2)->get()->map(function ($item) use ($user_id) {
        $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
        $item['watch_percentage'] = ContinueWatching::where('videoid','=',$item->id)->where('user_id','=',$user_id)->pluck('watch_percentage')->min();
        $item['skip_time'] = ContinueWatching::where('videoid','=',$item->id)->where('user_id','=',$user_id)->pluck('skip_time')->min();
        return $item;
      });
      $status = "true";
    }else{
            $status = "false";
            $videos = [];
    }

  
    $response = array(
        'status'=>$status,
        'videos'=> $videos
      );
    return response()->json($response, 200);


  
  }

  public function remove_continue_watchingvideo(Request $request)
  {
      $user_id = $request->user_id;
      if($request->video_id){
          $video_id = $request->video_id;
          $count = ContinueWatching::where('user_id', '=', $user_id)->where('videoid', '=', $video_id)->count();
          if ( $count > 0 ) {
            ContinueWatching::where('user_id', '=', $user_id)->where('videoid', '=', $video_id)->delete();
            $response = array(
              'status'=>'true',
              'message'=>'Removed From ContinueWatching List'
          );
        } 
      }
      return response()->json($response, 200);

  }

  public function remove_continue_watchingepisode(Request $request)
  {
      $user_id = $request->user_id;
      if($request->episode_id){
          $episode_id = $request->episode_id;
          $count = ContinueWatching::where('user_id', '=', $user_id)->where('episodeid', '=', $episode_id)->count();
          if ( $count > 0 ) {
            ContinueWatching::where('user_id', '=', $user_id)->where('episodeid', '=', $episode_id)->delete();
            $response = array(
              'status'=>'true',
              'message'=>'Removed From ContinueWatching List'
          );
        } 
      }
      return response()->json($response, 200);

  }

  public function EpisodeContinuewatching(Request $request)
  {
    $user_id = $request->user_id;
      $current_duration = $request->current_duration;
      $watch_percentage = $request->watch_percentage;
      if($request->episode_id){
          $episode_id = $request->episode_id;
          $count = ContinueWatching::where('user_id', '=', $user_id)->where('episodeid', '=', $episode_id)->count();
          if ( $count > 0 ) {
            ContinueWatching::where('user_id', '=', $user_id)->where('episodeid', '=', $episode_id)->update(['currentTime' => $current_duration,'watch_percentage' => $watch_percentage]);
            $response = array(
              'status'=>'true',
              'message'=>'Current Time updated'
          );
        } else {
            $data = array('user_id' => $user_id, 'episodeid' => $episode_id,'currentTime' => $current_duration,'watch_percentage' => $watch_percentage );
            ContinueWatching::insert($data);
            $response = array(
              'status'=>'true',
              'message'=>'Added  to  Continue Watching List'
          );

        }
      }
      return response()->json($response, 200);
  }


  public function listcontinuewatchingsepisode(Request $request)
  {
      
    $user_id = $request->user_id;
    /*channel videos*/
    $episode_ids = ContinueWatching::where('episodeid','!=',NULL)->where('user_id','=',$user_id)->get();
    $episode_ids_count = ContinueWatching::where('episodeid','!=',NULL)->where('user_id','=',$user_id)->count();

    if ( $episode_ids_count  > 0) {

      foreach ($episode_ids as $key => $value1) {
        $k2[] = $value1->episodeid;
      }
      $episodes = Episode::whereIn('id', $k2)->get()->map(function ($item) use ($user_id) {
        $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
        $item['watch_percentage'] = ContinueWatching::where('episodeid','=',$item->id)->where('user_id','=',$user_id)->pluck('watch_percentage')->min();
        return $item;
      });
      $status = "true";
    }else{
            $status = "false";
            $episodes = [];
    }

  
    $response = array(
        'status'=>$status,
        'episodes'=> $episodes
      );
    return response()->json($response, 200);


  }

    /*Create new user account from existing user profile*/
    public function addchilduserprofile(Request $request)
    {
        $parent_id = $request->parent_id;
        $user_name = $request->user_name;
        $user_type = $request->user_type;
        $path = URL::to('/').'/public/uploads/avatars/';
        $logo = $request->file('avatar');
        if($logo != '' && $logo != null) {
            $file_old = $path.$logo;
            if (file_exists($file_old)){
              unlink($file_old);
          }
          $file = $logo;
          $avatar = $file->getClientOriginalName();
          $file->move(public_path()."/uploads/avatars/", $file->getClientOriginalName());

      } else {
          $avatar = 'default.png';
      }
        if(DB::table('sub_users')->insert(['parent_id' => $parent_id, 'user_name' => $user_name, 'user_type' => $user_type, 'avatar' => $avatar])){
            $response = array(
                'status'=>'true',
                'message'=> 'New profile created Successfully'
            );
        }else{
            $response = array(
                'status'=>'false',
                'message'=> 'Error in Saving profile data'
            );
        }

        return response()->json($response, 200);
    }

    public function updatechildprofile(Request $request)
    {
        $child_id = $request->child_id;
       
        $path = URL::to('/').'/public/uploads/avatars/';
        $logo = $request->file('avatar');
        if($logo != '' && $logo != null) {
            $file_old = $path.$logo;
            if (file_exists($file_old)){
              unlink($file_old);
          }
          $file = $logo;
          $avatar = $file->getClientOriginalName();
          $file->move(public_path()."/uploads/avatars/", $file->getClientOriginalName());

      } else {
          $avatar = 'default.png';
      }
        if(DB::table('sub_users')->where('id',$child_id)->update([ 'avatar' => $avatar])){
            $response = array(
                'status'=>'true',
                'message'=> 'Profile updated Successfully'
            );
        }else{
            $response = array(
                'status'=>'false',
                'message'=> 'Error in Saving profile data'
            );
        }

        return response()->json($response, 200);
    }

    /*View Child profile*/
    public function viewchildprofile(Request $request)
    {
        $parent_id = $request->parent_id;
        $sub_users = DB::table('sub_users')->where('parent_id', $parent_id)->get();
        if(!empty($sub_users)){
            $response = array(
                'status'=>'true',
                'sub_users'=> $sub_users,
                'image_url' => URL::to('/').'/public/uploads/avatars/'
            );
        }else{
            $response = array(
                'status'=>'false',
                'sub_users'=> '',
                'image_url' => '',
            );
        }

        return response()->json($response, 200);
    }

    public function savefavouritecategory(Request $request)
    {
        $user_id = $request->user_id;
        $fav_category = $request->fav_category;

        $user = User::find($user_id);
        $user->fav_category = $fav_category;
        $user->save();

        $response = array(
            'status'=>'true',
            'message'=> 'Favorite Category stored successfully'
        );
        
        return response()->json($response, 200);
    }

    public function getRecentAudios() {

        $date = date('Y-m-d', strtotime('-10 days'));

        $recent_audios =  DB::table('audio')
        ->join('audio_categories', 'audio.audio_category_id', '=', 'audio_categories.id')
        ->select('audio_categories.name as audio_cat_name ', 'audio.*')
        ->where('audio.created_at', '>=', $date)
        ->get();

        $recent_audios_count = Audio::where('created_at', '>=', $date)->count();

        if ( $recent_audios_count > 0) {

            $response = array(
                'status'=>'true',
                'message'=>'success',
                'recent_audios'=> $recent_audios
            );
        } else {

            $response = array(
                'status'=>'false',
                'message'=>'No recent Audios Found'
            );
        }

        return response()->json($response, 200);

    }

    public function AllAudios() {

      $date = date('Y-m-d', strtotime('-10 days'));


      // $recent_audios_count = Audio::where('created_at', '>=', $date)->count();
      $recent_audios_count = Audio::get()->count();
      // $image_path = public_path().'/uploads/images/';


      if ( $recent_audios_count > 0) {

        // $allaudios =  Audio::get();
        $allaudios = Audio::get()->map(function ($item) {
          $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
          return $item;
      });
          $response = array(
              'status'=>'true',
              'message'=>'success',
              'allaudios'=> $allaudios
          );
      } else {

          $response = array(
              'status'=>'false',
              'message'=>'No recent Audios Found'
          );
      }

      return response()->json($response, 200);

  }

    public function audiodetail(Request $request)
    {

        $audio_id = $request->audio_id;

        $current_date = date('Y-m-d h:i:s a', time()); 
        $audiodetail = Audio::where('id',$audio_id)->get()->map(function ($item) {
            $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
            return $item;
        });

        if ( isset($request->user_id) && $request->user_id != '' ) { 
            $user_id = $request->user_id;
      //Wishlilst
            $cnt = Wishlist::select('audio_id')->where('user_id','=',$user_id)->where('audio_id','=',$audio_id)->count();
            $wishliststatus =  ($cnt == 1) ? "true" : "false";
      //Watchlater
            $cnt1 = Watchlater::select('audio_id')->where('user_id','=',$user_id)->where('audio_id','=',$audio_id)->count();
            $watchlaterstatus =  ($cnt1 == 1) ? "true" : "false";

       //Favorite
            $cnt2 = Favorite::select('audio_id')->where('user_id','=',$user_id)->where('audio_id','=',$audio_id)->count();
            $favoritestatus =  ($cnt2 == 1) ? "true" : "false";

            $userrole = User::where('id','=',$user_id)->first()->role;
            $status = 'true';

            $like_data = LikeDisLike::where("audio_id","=",$audio_id)->where("user_id","=",$user_id)->where("liked","=",1)->count();
            $dislike_data = LikeDisLike::where("audio_id","=",$audio_id)->where("user_id","=",$user_id)->where("disliked","=",1)->count();
            $like = ($like_data == 1) ? "true" : "false";
            $dislike = ($dislike_data == 1) ? "true" : "false";
        } else{
            $wishliststatus = 'false';
            $watchlaterstatus = 'false';
            $favoritestatus = 'false';
            $ppv_exist = 0;
            $userrole = '';
            $status = 'true';
            $like = "false";
            $dislike = "false";
        }

        

        $audio_cat_id = Audio::where('id','=',$audio_id)->pluck('audio_category_id');

        $audio_cat = AudioCategory::where('id','=',$audio_cat_id)->get();

        $response = array(
            'status' => $status,
            'wishlist' => $wishliststatus,
            'main_genre' => $audio_cat[0]->name,
            'watchlater' => $watchlaterstatus,
            'favorite' => $favoritestatus,
            'userrole' => $userrole,
            'like' => $like,
            'dislike' => $dislike,
            'shareurl' => URL::to('channelVideos/play_videos').'/'.$audio_id,
            'audiodetail' => $audiodetail,
        );
        return response()->json($response, 200);

    }

    public function categoryaudios(Request $request)
    {
       
        $audiocategories = AudioCategory::select('id','image')->get()->toArray();
        $myData = array();
        foreach ($audiocategories as $key => $audiocategory) {
            $audiocategoryid = $audiocategory['id'];
            $genre_image = $audiocategory['image'];
            $audios= Audio::where('audio_category_id',$audiocategoryid)->where('active','=',1)->orderBy('created_at', 'desc')->get()->map(function ($item) {
            $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
            $item['video_url'] = URL::to('/').'/storage/app/public/'.$item->mp4_url;
            return $item;
        });
            $categorydetails = AudioCategory::where('id','=',$audiocategoryid)->first();

            if(count($audios) > 0){
                $msg = 'success';
            }else{
                $msg = 'nodata';
            }
            $myData[] = array(
                "genre_name"   => $categorydetails->name,
                "genre_id"   => $audiocategoryid,
                "genre_image"   => URL::to('/').'/public/uploads/audiocategory/'.$genre_image,
                "message" => $msg,
                "audios" => $audios
            );

        }

        $response = array(
            'status' => 'true',
            'genre_audios' => $myData
        );
        return response()->json($response, 200);
    }

    public function artistlist()
    {
        $artistlist = Artist::all()->map(function ($item) {
            $item['image_url'] = URL::to('/').'/public/uploads/artists/'.$item->image;
            return $item;
        });
        if($artistlist){
            $response = array(
                'status' => 'true',
                'artistlist' => $artistlist
            );
        }else{
            $response = array(
                'status' => 'false',
                'message' => 'No data Found'
            );
        }

        return response()->json($response, 200);
        
    }

    public function artistfavorites(Request $request)
    {
        $user_id = $request->user_id;



        // $favoriteslist = 
        // Artist::join('artist_favourites', 'artists.id', '=', 'artist_favourites.artist_id')
        // ->where('artist_favourites.user_id',$user_id)
        // ->where('artist_favourites.favourites',1)
        // ->get(['artists.*']);
        $favoriteslist = Artist::join('artist_favourites', 'artists.id', '=', 'artist_favourites.artist_id')->get()
          ->map(function ($item) {
          $item['image_url'] = URL::to('/').'/public/uploads/artists/'.$item->image;
          return $item;
        });
        if($favoriteslist){
            $response = array(
                'status' => 'true',
                'favoriteslist' => $favoriteslist
            );
        }else{
            $response = array(
                'status' => 'false',
                'message' => 'No data Found'
            );
        }
        return response()->json($response, 200);
    }

    public function artistfollowings(Request $request)
    {
        $user_id = $request->user_id;
        $followinglist = Artist::join('artist_favourites', 'artists.id', '=', 'artist_favourites.artist_id')->where('artist_favourites.user_id',$user_id)->where('artist_favourites.following',1)->get(['artists.*']);
        if($followinglist){
            $response = array(
                'status' => 'true',
                'followinglist' => $followinglist
            );
        }else{
            $response = array(
                'status' => 'false',
                'message' => 'No data Found'
            );
        }
        return response()->json($response, 200);
    }

    public function artistaddremovefav(Request $request)
    {

        $user_id = $request->user_id;
        $artist_id = $request->artist_id;
        $favourites = $request->favourites;
        $count = DB::table('artist_favourites')->where('user_id', '=',
        $user_id)->where('artist_id', '=', $artist_id)->count();
        if ( $count > 0 ) {

            DB::table('artist_favourites')->where('user_id', '=',
                $user_id)->where('artist_id', '=', $artist_id)->update(['favourites'=>$favourites]);
            if($favourites == 1){
                $response = array(
                    'status'=>'false',
                    'message'=>'Artist Added From Your Favorite List'
                );
            }else{
                $response = array(
                    'status'=>'false',
                    'message'=>'Artist Removed From Your Favorite List'
                );
            }


        } else {
                $data = array('user_id' => $user_id, 'artist_id' => $artist_id );
                DB::table('artist_favourites')->insert($data);
                $response = array(
                    'status'=>'true',
                    'message'=>'Artist Added  to  Your Favorite List'
                );

            }
    return response()->json($response, 200);
    }

    public function artistaddremovefollow(Request $request)
    {
        $user_id = $request->user_id;
        $artist_id = $request->artist_id;
        $following = $request->following;
        $count = DB::table('artist_favourites')->where('user_id', '=',
        $user_id)->where('artist_id', '=', $artist_id)->count();
            if ( $count > 0 ) {
                DB::table('artist_favourites')->where('user_id', '=',
                $user_id)->where('artist_id', '=', $artist_id)->update(['following'=>$following]);
                    if($following == 1){
                        $response = array(
                            'status'=>'false',
                            'message'=>'Artist Added From Your Following List'
                        );
                    }else{
                        $response = array(
                            'status'=>'false',
                            'message'=>'Artist Removed From Your Following List'
                        );
                    }
                
                
            } else {
                $data = array('user_id' => $user_id, 'artist_id' => $artist_id );
                DB::table('artist_favourites')->insert($data);
                $response = array(
                    'status'=>'true',
                    'message'=>'Artist Added  to  Your Favorite List'
                );

            }
            return response()->json($response, 200);
    }

    public function artistdetail(Request $request)
    {
        $artist_id = $request->artist_id;
        $user_id = $request->user_id;
        $artist = Artist::where('id',$artist_id)->get()->map(function ($item) {
            $item['image_url'] = URL::to('/').'/public/uploads/artists/'.$item->image;
            return $item;
        });
        $fav_count = DB::table('artist_favourites')->where('user_id', '=',
        $user_id)->where('artist_id', '=', $artist_id)->where('favourites', '=',1)->count();
        $fav = ($fav_count > 0)?'true':'false';
        $follow_count = DB::table('artist_favourites')->where('user_id', '=',
        $user_id)->where('artist_id', '=', $artist_id)->where('following', '=',1)->count();
        $follow = ($follow_count > 0)?'true':'false'; 
        $artist_audios = Audioartist::join('audio', 'audio.id', '=', 'audio_artists.audio_id')->where('artist_id',$artist_id)->get();
        $response = array(
            'status'=>'true',
            'artist'=>$artist,
            'favourites'=>$fav,
            'following' => $follow,
            'artist_audios' => $artist_audios
        );
        return response()->json($response, 200);
    }

    public function trendingaudio(Request $request)
    {

      $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
      $countryName =  $geoip->getCountry();
      $getfeching = Geofencing::first();
  
      $block_audios=BlockAudio::where('country',$countryName)->get();
          if(!$block_audios->isEmpty()){
            foreach($block_audios as $block_audio){
                $blockaudios[]=$block_audio->video_id;
            }
        }                        
        $blockaudios[]='';
        
        $trending_audios = Audio::where('active', '=', '1')->where('status', '=', '1')->where('views', '>', '5')->orderBy('created_at', 'DESC');
      
        if($getfeching !=null && $getfeching->geofencing == 'ON'){
          $trending_audios =   $trending_audios->whereNotIn('id',$blockaudios);
        }
        $trending_audios =$trending_audios->get()->map(function ($item) {
          $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
          return $item;
        });
        $response = array(
            'status'=>'true',
            'trending_audios'=>$trending_audios
        );
        return response()->json($response, 200);
    }

    public function albumlist(Request $request)
    {
        $audiocategories_count = AudioCategory::get()->count();
        if($audiocategories_count > 0){
        $audiocategories = AudioCategory::all();
        $response = array(
            'status'=>'true',
            'audiocategories'=>$audiocategories
        );
      }else{
        $response = array(
          'status'=>'false',
          'audiocategories'=> 'No Categories Added'
      );
      }
        return response()->json($response, 200);
    }

    public function albumaudios(Request $request)
    {
        $album_id = $request->album_id;

        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
        $countryName =  $geoip->getCountry();
        $getfeching = Geofencing::first();

        $block_audios=BlockAudio::where('country',$countryName)->get();
            if(!$block_audios->isEmpty()){
              foreach($block_audios as $block_audio){
                  $blockaudios[]=$block_audio->video_id;
              }
          }                        
          $blockaudios[]='';
    
        $audioalbum = Audio::where('audio_category_id',$album_id)->where('active','=',1)->orderBy('created_at', 'desc');
        if($getfeching !=null && $getfeching->geofencing == 'ON'){
          $audioalbum =   $audioalbum->whereNotIn('id',$blockaudios);
        }
        $audioalbum = $audioalbum->get()->map(function ($item) {
            $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
            $item['video_url'] = URL::to('/').'/storage/app/public/'.$item->mp4_url;
            return $item;
        });
    $categoryauido =  Audio::join('category_audios', 'audio.id', '=', 'category_audios.audio_id')
    ->select('audio.*')
    ->where('category_id', $album_id)
    ->count();
    
    if($categoryauido > 0){
    $albumcategoryauido =  Audio::join('category_audios', 'audio.id', '=', 'category_audios.audio_id')
    ->select('audio.*')
    ->where('category_id', $album_id)
    ->get();
    }else{
      $albumcategoryauido =  'No Audio Found';
    }
        $response = array(
            'status'=>'true',
            // 'albumname'=>AudioCategory::where('id',$album_id)->first()->name,
            'audioalbum'=>$audioalbum,
            'albumcategoryauido' => $albumcategoryauido , 
        );
        return response()->json($response, 200);
    }

    public function next_audio(Request $request) {

      $currentaudio_id = $request->audio_id;

      $next_audio_id = Audio::where('id', '>', $currentaudio_id)->where('status','=','1')->where('active','=','1')->min('id');

      if($next_audio_id){
        $audio= Audio::where('id','=',$next_audio_id)->where('status','=','1')->where('active','=','1')->get()->map(function ($item) {
          $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
           return $item;
      });
        $response = array(
          'status' => true,
          'next_audio_id' => $next_audio_id,
          'audio' => $audio
        );
      }else{
        $response = array(
          'status' => false,
          'message' => 'No Data Found'
        );
      }
      return response()->json($response, 200);
    }


    public function prev_audio(Request $request){

    $currentaudio_id = $request->audio_id;
    $prev_audio_id = Audio::where('id', '<', $currentaudio_id)->where('status','=','1')->where('active','=','1')->orderBy('id','desc')->first();

    if($prev_audio_id){
        $prev_audio_id = $prev_audio_id->id;
        $audio= Audio::where('id','=',$prev_audio_id)->where('status','=','1')->where('active','=','1')->get()->map(function ($item) {
            $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
             return $item;
        });
        $response = array(
          'status' => "true",
          'prev_audio_id' => $prev_audio_id,
          'audio' => $audio
        );
      }else{
        $response = array(
          'status' => "false",
          'message' => 'No Data Found'
        );
      }
      return response()->json($response, 200);
  
    }

    public function relatedaudios(Request $request) {
        $audio_id = $request->audio_id;
        $categoryAudios = Audio::where('id',$audio_id)->first();
        $category_id = Audio::where('id',$audio_id)->pluck('audio_category_id');
        $recomended = Audio::where('audio_category_id','=',$category_id)->where('id','!=',$audio_id)->where('status','=',1)->where('active','=',1)->get()->map(function ($item) {
                $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
                $item['mp4_url'] = URL::to('/').'/public/uploads/videos/'.$item->mp4_url;
                return $item;
            });
        $response = array(
            'status'=>'true',
            'recomendedaudios' => $recomended
        ); 
        return response()->json($response, 200);
    }
    
     public function mywatchlatersaudio(Request $request) {

      $user_id = $request->user_id;
  
      /*channel videos*/
      $audio_ids = Watchlater::select('audio_id')->where('user_id','=',$user_id)->get();
      $audio_ids_count = Watchlater::select('audio_id')->where('user_id','=',$user_id)->count();
  
      if ( $audio_ids_count  > 0) {
  
        foreach ($audio_ids as $key => $value1) {
          $k2[] = $value1->audio_id;
        }
        $channel_videos = Audio::whereIn('id', $k2)->get()->map(function ($item) {
          $item['image_url'] = URL::to('/').'/uploads/images/'.$item->image;
          $item['mp3_url'] = $item->mp3_url;
          return $item;
        });
        $status = "true";
      }else{
               $status = "false";
        $channel_videos = [];
      }
      
      $response = array(
          'status'=>$status,
          'channel_videos'=> $channel_videos
        );
      return response()->json($response, 200);
  
    }
    
    public function myFavoriteaudio(Request $request) {

      $user_id = $request->user_id;
  
      /*channel videos*/
      $audio_ids = Favorite::select('audio_id')->where('user_id','=',$user_id)->get();
      $audio_ids_count = Favorite::select('audio_id')->where('user_id','=',$user_id)->count();
  
      if ( $audio_ids_count  > 0) {
  
        foreach ($audio_ids as $key => $value1) {
          $k2[] = $value1->audio_id;
        }
        $channel_videos = Audio::whereIn('id', $k2)->get()->map(function ($item) {
          $item['image_url'] = URL::to('/').'/uploads/images/'.$item->image;
          $item['mp3_url'] = $item->mp3_url;
          return $item;
        });
        $status = "true";
      }else{
               $status = "false";
        $channel_videos = [];
      }
      
      $response = array(
          'status'=>$status,
          'channel_videos'=> $channel_videos
        );
      return response()->json($response, 200);
  
    }

    public function Alllanguage(Request $request) {

      $all_languages = Language::all();
      $count_all_languages = count($all_languages);
      $response = array(
          'status'=>'true',
          'all_languages' => $all_languages,
          'count_all_languages' => $count_all_languages

      ); 
      return response()->json($response, 200);
  }

  public function VideoLanguage(Request $request) {

    $user_id = $request->user_id;
    $lanid = $request->language_id;


    /*channel videos*/
    $language_videos = Video::where('language', '=', $lanid)->get();
    $count_language_videos = Video::where('language', '=', $lanid)->count();

    $response = array(
        'language_videos'=> $language_videos,
        'count_language_videos'=> $count_language_videos,

      );
    return response()->json($response, 200);

  }
  public function FeaturedVideo() {

    $featured_videos = Video::where('active', '=', '1')->where('featured', '=', '1')->orderBy('created_at', 'DESC')->get();
    $count_featured_videos = Video::where('active', '=', '1')->where('featured', '=', '1')->orderBy('created_at', 'DESC')->count();
    $response = array(
        'featured_videos' => $featured_videos,
        'count_featured_videos' => $count_featured_videos

    ); 
    return response()->json($response, 200);
}
public function RecentViews(Request $request) {

  $user_id = $request->user_id;

  $recent_videos = RecentView::where('user_id', '=',$user_id )->orderBy('id', 'desc')->take(10)->get();

  $count_recent_videos = count($recent_videos);

  $response = array(
      'recent_videos' => $recent_videos,
      'count_recent_videos' => $count_recent_videos

  ); 
  return response()->json($response, 200);
}

public function RecentlyViewedVideos(){
        
    $recent_videos = RecentView::orderBy('id', 'desc')->take(10)->get();
    foreach($recent_videos as $key => $value){
    $videos[] = Video::Where('id', '=',$value->video_id)->take(10)->get();
    }
    $videocategory = VideoCategory::all();
    $video = array_unique($videos);
    $response = array(
      'videos' => $video,
      'videocategory' => $videocategory,

  ); 
  return response()->json($response, 200);
}
public function AddRecentAudio(Request $request){
        
  $user_id = $request->user_id;
  $audio_id = $request->audio_id;
  if($request->audio_id != ''){
      $view = new RecentView;
            $view->audio_id = $audio_id;
            $view->user_id = $user_id;
            $view->visited_at = date('Y-m-d');
            $view->save();

            $message = "Added  to  Audio to Recent Views";
      $response = array(

        "status" => "true",
        'message'=> $message,
      );
     
    } else {
      $message = "Not Added  to  Audio to Recent Views Need Audio ID";

      $response = array(
        'status'=>'false',
         'message'=> $message

      );

    }
  return response()->json($response, 200);

  }

  public function SubscriptionEndNotification() {

    $stripe_plan = SubscriptionPlan();

    $users = User::all();
    foreach($users as $user){

    if ($user->subscription($stripe_plan) && $user->subscription($stripe_plan)->onGracePeriod()) {
        $ends_at = $user->subscription($stripe_plan)->ends_at->format('dS M Y');
        $end_date= date('d-m-Y', strtotime($ends_at. ' - ' ."7 days")); 
        if(!empty($end_date)){
          send_password_notification('Notification From FLICKNEXS','Your Subscription Auto Renewal Before 7 days','',$user->id);
        }else{
        }
    }else{
        $ends_at = "";
    }
  }
  
    $response = array(
        'status'=>'true',
        'message'=>'success',
    );
    return response()->json($response, 200);
}




public function SubscriptionPayment(Request $request){
        

  // $request['user_id'];
  $user_id = $request->user_id;
  $name = $request->name;
  $days = $request->days;
  $price = $request->price;
  $stripe_id = $request->stripe_id;
  $stripe_status = $request->stripe_status;
  $stripe_plan = $request->stripe_plan;
  $created_at = $request->created_at;
  $countryname = $request->countryname;
  $regionname = $request->regionname;
  $cityname = $request->cityname;

  if($request->stripe_plan != ''){
            $next_date = $days;
            $current_date = date('Y-m-d h:i:s');    
            $date = Carbon::parse($current_date)->addDays($next_date);
            $subscription = new Subscription;	
            $subscription->user_id  =  $user_id ;	
            $subscription->name  =  $name ;	
            $subscription->days  =  $days ;	
            $subscription->price  =  $price ;	
            $subscription->stripe_id  =  $stripe_id ;	
            $subscription->stripe_status   =  $stripe_status ;	
            $subscription->stripe_plan =  $stripe_plan;	
            $subscription->created_at =  $created_at;	
            $subscription->countryname = $countryname;	
            $subscription->regionname = $regionname;	
            $subscription->cityname = $cityname;	
            $subscription->ends_at = $date;	
            $subscription->save();	
            $user =  User::findOrFail($user_id);	
            $user->role = "subscriber";	
            $user->save();	
            $user_email = $user->email;	
          $plan_details = SubscriptionPlan::where('plan_id','=',$stripe_plan)->first(); 	
          // echo "<pre>"; print_r($template->template_type);exit();	
	          $template = EmailTemplate::where('id','=',23)->first(); 	
            $subject = $template->template_type;	
            Mail::send('emails.subscriptionpaymentmail', array(	
              /* 'activation_code', $user->activation_code,*/	
        'name'=>$name, 	
         'days' => $days, 	
         'price' => $price, 	
         'ends_at' => $date,	
          'plan_names' => $plan_details->plans_name,	
         'created_at' => $current_date), function($message) use ($request,$user_id,$name,$subject,$user_email) {	
                               $message->from(AdminMail(),'Flicknexs');	
                                $message->to($user_email, $name)->subject($subject);	
                           });	
      //  send_password_notification('Notification From FLICKNEXS','Your Payment has been done Successfully','Your Your Payment has been done Successfully','',$user_id);
            $message = "Added  to  Subscription";
            $response = array(
              "status" => "true",
              'message'=> $message,
            );
    } else {
      $message = "Not Added  to  Subscription";

      $response = array(
        'status'=>'false',
         'message'=> $message

      );

    }
  return response()->json($response, 200);

  }                                                                   



  public function SubscriberedUsers() {

    $stripe_plan = SubscriptionPlan();

    $subscription_count = Subscription::all()->count();
    if ($subscription_count > 0 ) {
      $subscription = Subscription::all();
        }else{
    $subscription = [];
    }
    $response = array(
        'status'=>'true',
        'subscription'=> $subscription,
    );
    return response()->json($response, 200);
}


public function LocationCheck(Request $request){
        
  $country_name = $request->country_name;

  $blocked_count = Country::where('country_name', '=', $country_name)->count();

        if ($blocked_count > 0) {
          $response = array('status' => true,
                            'message' => 'Blocked'
          );
      } else {
          $response = array('status' => false,
                            'message' => 'Can Access'
          );
      }
      return response()->json($response, 200);

  }

  public function myWishlistsEpisode(Request $request) {

    $user_id = $request->user_id;

    /*channel videos*/
    $episode_id_ids = Wishlist::select('episode_id')->where('user_id','=',$user_id)->get();
    $episode_id_ids_count = Wishlist::select('episode_id')->where('user_id','=',$user_id)->count();

    if ( $episode_id_ids_count  > 0) {

      foreach ($episode_id_ids as $key => $value1) {
        $k2[] = $value1->video_id;
      }
      $channel_videos = Episode::whereIn('id', $k2)->get()->map(function ($item) {
        $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
        $item['video_url'] = URL::to('/').'/storage/app/public/';
        return $item;
      });
      $status = "true";
    }else{
            $status = "false";
      $channel_videos = [];
    }

  
    $response = array(
        'status'=>$status,
        'channel_videos'=> $channel_videos
      );
    return response()->json($response, 200);

  }

  public function mywatchlatersEpisode(Request $request) {

    $user_id = $request->user_id;

    /*channel videos*/
    $episode_ids = Watchlater::select('episode_id')->where('user_id','=',$user_id)->get();
    $episode_ids_count = Watchlater::select('episode_id')->where('user_id','=',$user_id)->count();

    if ( $episode_ids_count  > 0) {

      foreach ($episode_ids as $key => $value1) {
        $k2[] = $value1->video_id;
      }
      $channel_videos = Episode::whereIn('id', $k2)->get()->map(function ($item) {
        $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
        $item['video_url'] = URL::to('/').'/storage/app/public/';
        return $item;
      });
      $status = "true";
    }else{
             $status = "false";
      $channel_videos = [];
    }
    
    $response = array(
        'status'=>$status,
        'channel_videos'=> $channel_videos
      );
    return response()->json($response, 200);

  }
  public function myFavoritesEpisode(Request $request) {

    $user_id = $request->user_id;
    /*channel videos*/
    $episode_ids = Favorite::select('episode_id')->where('user_id',$user_id)->get();
    $episode_ids_count = Favorite::select('episode_id')->where('user_id',$user_id)->count();

    if ( $episode_ids_count  > 0) {

      foreach ($episode_ids as $key => $value) {
        $k2[] = $value->video_id;
      }
      $channel_videos = Episode::whereIn('id', $k2)->get()->map(function ($item) {
        $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
        $item['video_url'] = URL::to('/').'/storage/app/public/';
        return $item;
      });
      $status = "true";
    }else{
            $status = "false";
      $channel_videos = [];
    }

  
    $response = array(
        'status'=>$status,
        'channel_videos'=> $channel_videos
      );
    return response()->json($response, 200);

  }
  public function addwatchlaterEpisode(Request $request) {

    $user_id = $request->user_id;
    $episode_id = $request->episode_id;
    if($request->episode_id != ''){
      $count = Watchlater::where('user_id', '=', $user_id)->where('episode_id', '=', $episode_id)->count();
      if ( $count > 0 ) {
        Watchlater::where('user_id', '=', $user_id)->where('episode_id', '=', $episode_id)->delete();
        $response = array(
          'status'=>'false',
          'message'=>'Removed From Your Watch Later List'
        );
      } else {
        $data = array('user_id' => $user_id, 'episode_id' => $episode_id );
        Watchlater::insert($data);
        $response = array(
          'status'=>'true',
          'message'=>'Added  to  Your Watch Later List'
        );

      }
    }

    return response()->json($response, 200);

  }

  public function addwishlistEpisode(Request $request) {

    $user_id = $request->user_id;
    //$type = $request->type;//channel,ppv
    $episode_id = $request->episode_id;
    if($request->episode_id != ''){
      $count = Wishlist::where('user_id', '=', $user_id)->where('episode_id', '=', $episode_id)->count();
      if ( $count > 0 ) {
        Wishlist::where('user_id', '=', $user_id)->where('episode_id', '=', $episode_id)->delete();
        $response = array(
          'status'=>'false',
          'message'=>'Removed From Your Wishlist List'
        );
      } else {
        $data = array('user_id' => $user_id, 'episode_id' => $episode_id );
        Wishlist::insert($data);
        $response = array(
          'status'=>'true',
          'message'=>'Added  to  Your Wishlist List'
        );

      }
    }

    return response()->json($response, 200);

  }


  public function addfavoriteEpisode(Request $request) {

    $user_id = $request->user_id;
    //$type = $request->type;//channel,ppv
    $episode_id = $request->episode_id;
    if($request->episode_id != ''){
      $count = Favorite::where('user_id', '=', $user_id)->where('episode_id', '=', $episode_id)->count();
      if ( $count > 0 ) {
        Favorite::where('user_id', '=', $user_id)->where('episode_id', '=', $episode_id)->delete();
        $response = array(
          'status'=>'false',
          'message'=>'Removed From Your Favorite List'
        );
      } else {
        $data = array('user_id' => $user_id, 'episode_id' => $episode_id );
        Favorite::insert($data);
        $response = array(
          'status'=>'true',
          'message'=>'Added  to  Your Favorite List'
        );

      }
    }

    return response()->json($response, 200);

  }

  public function Multiprofile(){

    $parent_id =  Session::get('login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d');
    
    $subcriber_user = User::where('id',$parent_id)->first();

    $users= Multiprofile::where('parent_id', $parent_id)->get();

    $response = array(
      'user'=>$subcriber_user,
      'sub_users'=> $users
    );
  return response()->json($response, 200);

}

  public function Multiprofile_create(Request $request){

          if($request->user_type != ''){
              $user_type = 'Kids';
          }else{
              $user_type = 'Normal';
          }         
          if($request->image != ''){
            $files = $request->image;
            $filename =uniqid(). time(). '.' . $files->getClientOriginalExtension();
            Image::make($files)->resize(300, 300)->save(base_path().'/public/multiprofile/'.$filename );
          }
          $parent_id =  Session::get('login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d');

          $Multiprofile = Multiprofile::create([
              'parent_id'       => $parent_id,
              'user_name'       => $request->input('name'),
              'user_type'       => $user_type,
              'Profile_Image'   => $filename,
          ]);

          return response()->json([
            'message' => 'Multiprofile data Saved successfully'
        ], 200);
  

    }

    public function Multiprofile_update(Request $request,$id){

        $Multiprofile = Multiprofile::find($id);  
        if($request->user_type != ''){
            $user_type = 'Kids';
        }
        else{
            $user_type = 'Normal';
        }

        if($request->image != ''){  
            $files = $request->image;
            $filename =uniqid(). time(). '.' . $files->getClientOriginalExtension();
            Image::make($files)->resize(300, 300)->save(base_path().'/public/multiprofile/'.$filename );
            $Multiprofile->Profile_Image = $filename;
        }
        $Multiprofile->user_name =  $request->get('name');  
        $Multiprofile->user_type = $user_type;  
        $Multiprofile->save();  

         return response()->json([
          'message' => 'Multiprofile Data Updated successfully'
      ], 200);

      }

    public function freecontent_episodes(){

      $user_id= Session::get('login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d');
      $user_details = user::where('id',$user_id)->pluck('role')->first();

      $freecontent = Episode::where('status',1)->where('active',1);
      if($user_details == null){
        $freecontent = $freecontent->where('access','guest');
      }
      $freecontent = $freecontent->orderBy('id', 'DESC')->get();

      $response = array(
        'freecontent'=>$freecontent,
      );
      return response()->json($response, 200);
  
    }

    public function MostwatchedVideos(){

      $Recomended = HomeSetting::first();

      $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
      $countryName =  $geoip->getCountry();
      $getfeching = Geofencing::first();

      if( $getfeching->geofencing == 'ON'){

          $block_videos=BlockVideo::where('country_id',$countryName)->get();
            if(!$block_videos->isEmpty()){
                foreach($block_videos as $block_video){
                    $blockvideos[]=$block_video->video_id;
                }
            }  else{  $blockvideos=[];  } }
            else {  $blockvideos=[];  }

      if( $Recomended->Recommendation == 1 ){

        $Mostwatchedvideos = RecentView::select('video_id','videos.*',DB::raw('COUNT(video_id) AS count')) 
              ->join('videos', 'videos.id', '=', 'recent_views.video_id')->whereNotIn('videos.id',$blockvideos)->groupBy('video_id')
              ->orderByRaw('count DESC' )->limit(20)->get();
      } else{   $Mostwatchedvideos =[];
       }
        return response()->json([
          'message' => 'Most watched videos  Retrieve successfully',
          'Mostwatchedvideos' => $Mostwatchedvideos ], 200);
    }

    public function MostwatchedVideosUser(){

      $Sub_user ='';
      $user_id= Session::get('login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d');
      $Recomended = HomeSetting::first();
      

      if( $Recomended->Recommendation == 1 ){
        $Mostwatched = RecentView::select('video_id','videos.*',DB::raw('COUNT(video_id) AS count')) 
              ->join('videos', 'videos.id', '=', 'recent_views.video_id')
              ->groupBy('video_id');

              if($Sub_user != null){
                  $Mostwatched = $Mostwatched->where('recent_views.sub_user',$Sub_user);
              }else{
                  $Mostwatched = $Mostwatched->where('recent_views.user_id',$user_id);
              }
              $Mostwatched = $Mostwatched->orderByRaw('count DESC' )->limit(20)->get();
      }else{
        $Mostwatched=[];
      }
            return response()->json([
              'message' => 'Most watched videos by User data Retrieve successfully',
              'Mostwatched' => $Mostwatched], 200);
    }

    public function Country_MostwatchedVideos(){

      $Recomended = HomeSetting::first();

      $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
      $countryName =  $geoip->getCountry();
      $getfeching = Geofencing::first();

      if( $getfeching->geofencing == 'ON'){
          $block_videos=BlockVideo::where('country_id', $countryName)->get();
            if(!$block_videos->isEmpty()){
                foreach($block_videos as $block_video){
                    $blockvideos[]=$block_video->video_id;
                }
            }  else{  $blockvideos=[];  }}
      else{
        $blockvideos=[]; 
      }
      
      if( $Recomended->Recommendation == 1 ){

        $Most_watched_country =RecentView::select('video_id','videos.*',DB::raw('COUNT(video_id) AS count')) 
              ->join('videos', 'videos.id', '=', 'recent_views.video_id')->groupBy('video_id')->orderByRaw('count DESC' )
              ->where('country', $countryName)->limit(20)->get();
      }else{
        $Most_watched_country =[];
      }
  
      return response()->json([
        'message' => 'Country Most watched videos Retrieve successfully',
        'Mostwatched' => $Most_watched_country], 200);
  }

  public function ComingSoon() {

        $videos = Video::orderBy('created_at', 'DESC')->whereDate('publish_time', '>', \Carbon\Carbon::now()->today())->get();
        if(!empty($videos)){
          $status = 'true';
          $comingsoon = $videos;

        }else{
          $status = 'false';
          $comingsoon = [];
        }
        $response = array(
          'status'=> $status,
          'comingsoon'=> $comingsoon,
        );

    return response()->json($response, 200);

  }


  public function video_cast(Request $request)
  {
    $video_id = $request->video_id;
    $video_cast_count = Videoartist::join("artists","video_artists.artist_id", "=", "artists.id")
    ->select("artists.*")
    ->where("video_artists.video_id", "=", $video_id)
    ->count();

    if ($video_cast_count > 0) {
      $status = "true";

      $video_cast = Videoartist::join("artists","video_artists.artist_id", "=", "artists.id")
      ->select("artists.*")
      ->where("video_artists.video_id", "=", $video_id)
      ->get()
      ->map(function ($item) {
        $item['image_url'] = URL::to('/').'/public/uploads/artists/'.$item->image;
        return $item;
      });

    } else {
      $video_cast = [];
      $status = "false";
    }    
    $response = array(
      'status' => $status,
      'video_cast' => $video_cast
    );
    return response()->json($response, 200);
  }
  public function series_cast(Request $request)
  {
    $seriesid = $request->seriesid;
    $series_cast_count = Seriesartist::join("artists","series_artists.artist_id", "=", "artists.id")
    ->select("artists.*")
    ->where("series_artists.series_id", "=", $seriesid)
    ->count();

    if ($series_cast_count > 0) {
      $status = "true";

      $series_cast = Seriesartist::join("artists","series_artists.artist_id", "=", "artists.id")
      ->select("artists.*")
      ->where("series_artists.series_id", "=", $seriesid)
      ->get()
      ->map(function ($item) {
        $item['image_url'] = URL::to('/').'/public/uploads/artists/'.$item->image;
        return $item;
      });

    } else {
      $series_cast = [];
      $status = "false";
    }    
    $response = array(
      'status' => $status,
      'series_cast' => $series_cast
    );
    return response()->json($response, 200);
  }
  
  public function Preference_genres()
  {
      $Recomended = HomeSetting::first();
      $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
      $countryName =  $geoip->getCountry();
      $getfeching = Geofencing::first();

      $block_videos=BlockVideo::where('country_id', $countryName)->get();
        if(!$block_videos->isEmpty()){
            foreach($block_videos as $block_video){
                $blockvideos[]=$block_video->video_id;
            }
        }  else{  $blockvideos=[];  }

      if( $Recomended->Recommendation == 1 ){

          $user_id= Session::get('login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d');
          $preference_genres = User::where('id',$user_id)->pluck('preference_genres')->first();

          if($preference_genres !=null ){
              $video_genres = json_decode($preference_genres);
              $preference_gen = Video::whereIn('video_category_id',$video_genres)->whereNotIn('videos.id',$blockvideos)->get();
          }
          else{
              $preference_gen =[];
          }
        }else{
          $preference_gen =[];
        }

          return response()->json([
            'message' => 'preference Genres videos Retrieve successfully',
            'Preference_genres' => $preference_gen], 200);
    }

    public function Preference_Language(){

      $user_id= Session::get('login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d');

      $Recomended = HomeSetting::first();
      $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
      $countryName =  $geoip->getCountry();
      $getfeching = Geofencing::first();

      $block_videos=BlockVideo::where('country_id', $countryName)->get();
        if(!$block_videos->isEmpty()){
            foreach($block_videos as $block_video){
                $blockvideos[]=$block_video->video_id;
            }
        }  else{  $blockvideos=[];  }


      if( $Recomended->Recommendation == 1 ){

      $preference_language = User::where('id',$user_id)->pluck('preference_language')->first();
            if($preference_language !=null ){
              $video_language =json_decode($preference_language);
              $preference_Lan = Video::whereIn('language',$video_language)->whereNotIn('videos.id',$blockvideos)->get();
            }else{
                  $preference_Lan =[];
              }
        }else{
          $preference_Lan =[];
        }
          return response()->json([
            'message' => 'preference language videos Retrieve successfully',
            'Preference_language' => $preference_Lan], 200);

    }

    public function category_Mostwatchedvideos(){

      $Recomended = HomeSetting::first();
      $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
      $countryName =  $geoip->getCountry();
      $getfeching = Geofencing::first();

    if( $getfeching->geofencing == 'ON'){
          $block_videos=BlockVideo::where('country_id', $countryName)->get();
            if(!$block_videos->isEmpty()){
                foreach($block_videos as $block_video){
                    $blockvideos[]=$block_video->video_id;
                } } else{  $blockvideos=[];  } }
      else{  $blockvideos=[];  }

      if( $Recomended->Recommendation == 1 ){

          $parentCategories = VideoCategory::where('in_home','=',1)->orderBy('order','ASC')->get();

          foreach($parentCategories as $category) {

          $videos = Video::Join('video_categories','video_categories.id','=','videos.video_category_id')->where('video_category_id','=',$category->id)->where('active', '=', '1')->get();

          foreach($videos as $key => $category_video){

            $top_category_videos[$category_video->name ] = RecentView::select('video_id','videos.*',DB::raw('COUNT(video_id) AS count')) 
                ->join('videos', 'videos.id', '=', 'recent_views.video_id')->groupBy('video_id')->orderByRaw('count DESC' )
                ->where('video_category_id',$category_video->video_category_id)->whereNotIn('videos.id',$blockvideos)->limit(20)->get(); 
          }  
        }
      } else{ 
      $top_category_videos =[];
    }

      return response()->json([
        'Top_category_videos' => $top_category_videos], 200);
  }

  public function Welcome_Screen()
  {
     $Screen =WelcomeScreen::all()->map(function ($item) {
      $item['welcome_images_link'] = URL::to('/').'/public/uploads/settings/'.$item->welcome_images;
      return $item;
    });

     return response()->json([
      'WelcomeScreen' => $Screen], 200);
  }


  public function Episode_like(Request $request)
  {

    $user_id = $request->user_id;
    $Episode_id = $request->Episode_id;
    $like = $request->like;
    $d_like = Likedislike::where("Episode_id",$Episode_id)->where("user_id",$user_id)->count();

    if($d_like > 0){
      $new_episode_like = Likedislike::where("Episode_id",$Episode_id)->where("user_id",$user_id)->first();
      if($like == 1){
        $new_episode_like->user_id = $request->user_id;
        $new_episode_like->Episode_id = $request->Episode_id;
        $new_episode_like->liked = 1;
        $new_episode_like->disliked = 0; 
        $new_episode_like->save(); 
      }else{
        $new_episode_like->user_id = $request->user_id;
        $new_episode_like->Episode_id = $request->Episode_id;
        $new_episode_like->liked = 0;
        $new_episode_like->save(); 
      }
    }else{
      $new_episode_like = new Likedislike;
      $new_episode_like->user_id = $request->user_id;
      $new_episode_like->Episode_id = $request->Episode_id;
      $new_episode_like->liked = 1;
      $new_episode_like->disliked = 0;
      $new_episode_like->save(); 
    }

     $response = array(
      'status'=>'true',
      'liked' => $new_episode_like->liked,
      'disliked' => $new_episode_like->disliked,
      'message'=>'success'
    );
    
     return response()->json($response, 200); 
   
  }

  public function Episode_dislike(Request $request)
  {

    $user_id = $request->user_id;
    $Episode_id = $request->Episode_id;
    $dislike = $request->dislike;
    $d_like = Likedislike::where("Episode_id",$Episode_id)->where("user_id",$user_id)->count();

    if($d_like > 0){
      $new_Episode_dislike = Likedislike::where("Episode_id",$Episode_id)->where("user_id",$user_id)->first();
      if($dislike == 1){
        $new_Episode_dislike->user_id = $request->user_id;
        $new_Episode_dislike->Episode_id = $request->Episode_id;
        $new_Episode_dislike->liked = 0;
        $new_Episode_dislike->disliked = 1; 
        $new_Episode_dislike->save(); 
      }else{
        $new_Episode_dislike->user_id = $request->user_id;
        $new_Episode_dislike->Episode_id = $request->Episode_id;
        $new_Episode_dislike->disliked = 0;
        $new_Episode_dislike->save(); 
      }
    }else{
      $new_Episode_dislike = new Likedislike;
      $new_Episode_dislike->user_id = $request->user_id;
      $new_Episode_dislike->Episode_id = $request->Episode_id;
      $new_Episode_dislike->liked = 0;
      $new_Episode_dislike->disliked = 1;
      $new_Episode_dislike->save(); 
    }

     $response = array(
      'status'=>'true',
      'liked' => $new_Episode_dislike->liked,
      'disliked' => $new_Episode_dislike->disliked,
      'message'=>'success'
    );
    
     return response()->json($response, 200); 
  }

  public function Episode_addfavorite(Request $request){

    $user_id = $request->user_id;
    $Episode_id = $request->Episode_id;

    if($request->Episode_id != ''){
      $count = Favorite::where('user_id', '=', $user_id)->where('Episode_id', '=', $Episode_id)->count();
      if ( $count > 0 ) {
        Favorite::where('user_id', '=', $user_id)->where('Episode_id', '=', $Episode_id)->delete();
        $response = array(
          'status'=>'false',
          'message'=>'Removed From Your Favorite List'
        );
      } else {
        $data = array('user_id' => $user_id, 'Episode_id' => $Episode_id );
        Favorite::insert($data);
        $response = array(
          'status'=>'true',
          'message'=>'Added  to  Your Favorite List'
        );

      }
    }

    return response()->json($response, 200);
  }
  
  public function Episode_addwishlist(Request $request)
  {

    $user_id = $request->user_id;
    $episodeid = $request->episodeid;

    if($request->episodeid){
      $count = Wishlist::where('user_id', '=', $user_id)->where('episode_id', '=', $episodeid)->count();
      if ( $count > 0 ) {
        Wishlist::where('user_id', '=', $user_id)->where('episode_id', '=', $episodeid)->delete();
        $response = array(
          'status'=>'false',
          'message'=>'Removed From Your Wishlist List'
        );
      } else {
        $data = array('user_id' => $user_id, 'episode_id' => $episodeid );
        Wishlist::insert($data);
        $response = array(
          'status'=>'true',
          'message'=>'Added  to  Your Wishlist List'
        );

      }
    }else{

    }

    return response()->json($response, 200);

  }

  public function Episode_addwatchlater(Request $request)
  {

    $user_id = $request->user_id;
    $Episode_id = $request->Episode_id;

    if($request->Episode_id != ''){
      $count = Watchlater::where('user_id', '=', $user_id)->where('Episode_id', '=', $Episode_id)->count();
      if ( $count > 0 ) {
        Watchlater::where('user_id', '=', $user_id)->where('Episode_id', '=', $Episode_id)->delete();
        $response = array(
          'status'=>'false',
          'message'=>'Removed From Your Watch Later List'
        );
      } else {
        $data = array('user_id' => $user_id, 'Episode_id' => $Episode_id );
        Watchlater::insert($data);
        $response = array(
          'status'=>'true',
          'message'=>'Added  to  Your Watch Later List'
        );

      }
    }

    return response()->json($response, 200);

  }


  public function PaymentPlan(Request $request)
  {
    $plan_name = $request->plan_name;
    $payment_type = $request->payment_type;

    $plans = SubscriptionPlan::where('plans_name',$plan_name)->where('type',$payment_type)->count();

    if ($plans > 0) {
      $status = "true";
      $plan_id = SubscriptionPlan::where('plans_name',$plan_name)->where('type',$payment_type)->get();
      // $plan_id = SubscriptionPlan::where('plans_name',$plan_name)->where('type',$payment_type)->pluck('plan_id');
    } else {
      $plan_id = [];
      $status = "false";
    }    
    $response = array(
      'status' => $status,
      'plan' => $plan_id
    );
    return response()->json($response, 200);
  }


  public function RazorpaySubscription(Request $request){

        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
        $countryName = $geoip->getCountry();
        $regionName = $geoip->getregion();
        $cityName = $geoip->getcity();
        
        $Plan_Id = $request->plan_id;
        $api    = new Api($this->razorpaykeyId, $this->razorpaykeysecret);

        $planId = $api->plan->fetch($Plan_Id);

        $subscription = $api->subscription->create(array(
        'plan_id' =>  $planId->id, 
        'customer_notify' => 1,
        'total_count' => 6, 
        ));


        $respond[]=array(
            'razorpaykeyId'  =>  $this->razorpaykeyId,
            'name'           =>  $planId['item']->name,
            'subscriptionId' =>  $subscription->id ,
            'short_url'      =>  $subscription->short_url,
            'currency'       =>  'INR',
            'address'        =>  $cityName,
            'description'    =>  null,
            'countryName'    =>  $countryName,
            'regionName'     =>  $regionName,
            'cityName'       =>  $cityName,
            'PaymentGateway' =>  'razorpay',
        );

        return response()->json([
          'respond' => $respond], 200);
  }

  public function RazorpayStore(Request $request)
  {
          $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
          $countryName = $geoip->getCountry();
          $regionName = $geoip->getregion();
          $cityName = $geoip->getcity();
    
      try{                                                        
            $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);
            $subscription = $api->subscription->fetch($request->razorpay_subscription_id);
            $plan_id      = $api->plan->fetch($subscription['plan_id']);

            $Sub_Startday = date('d/m/Y H:i:s', $subscription['current_start']); 
            $Sub_Endday = date('d/m/Y H:i:s', $subscription['current_end']); 

                Subscription::create([
                'user_id'        =>  $request->userId,
                'name'           =>  $plan_id['item']->name,
                'price'          =>  $plan_id['item']->amount / 100,   // Amount Paise to Rupees
                'stripe_id'      =>  $subscription['id'],
                'stripe_status'  =>  $subscription['status'],
                'stripe_plan'    =>  $subscription['plan_id'],
                'quantity'       =>  $subscription['quantity'],
                'countryname'    =>  $countryName,
                'regionname'     =>  $regionName,
                'cityname'       =>  $cityName,
                'PaymentGateway' =>  'Razorpay',
            ]);

            User::where('id',$request->userId)->update([
                'role'                  =>  'subscriber',
                'stripe_id'             =>  $subscription['id'] ,
                'subscription_start'    =>  $Sub_Startday,
                'subscription_ends_at'  =>  $Sub_Endday,
            ]);

              return response()->json([
                'status'  => 'true',
                'Message' => 'Payment Done Successfully'], 200);
          }
        catch (\Exception $e){
          return response()->json([
            'status'  => 'false',
            'Message' => 'While Storing the value on Serve Error'], 200);
      }
  }

  public function RazorpaySubscriptionCancel(Request $request)
  {
    $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);

    $subscriptionId = User::where('id',$request->user_id)->pluck('stripe_id')->first();
    
    $options  = array('cancel_at_cycle_end'  => 0);

    try{
        $api->subscription->fetch($subscriptionId)->cancel($options);
        
        Subscription::where('stripe_id',$subscriptionId)->update([
            'stripe_status' =>  'Cancelled',
        ]);

        return response()->json([
          'status'  => 'true',
          'Message' => 'Subscription Cancel Successfully'], 200);
      }
      catch (\Exception $e){
        return response()->json([
          'status'  => 'false',
          'Message' => 'Subscription cannot be cancel'], 200);
    }
  }

  public function RazorpaySubscriptionUpdate(Request $request){

    $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
    $countryName = $geoip->getCountry();
    $regionName = $geoip->getregion();
    $cityName = $geoip->getcity();

    $api    = new Api($this->razorpaykeyId, $this->razorpaykeysecret);
    $plan_Id = $api->plan->fetch($request->plan_id);
    $user_id =$request->user_id;

    $subscriptionId  = Subscription::where('user_id',$user_id)->latest()->pluck('stripe_id')->first();

    $subscription = $api->subscription->fetch($subscriptionId);
    $remaining_count  =  $subscription['remaining_count'] ;


    if($subscription->payment_method != "upi"){
      
      try{
        $options  = array('plan_id'  =>$plan_Id['id'], 'remaining_count' => $remaining_count );
        $api->subscription->fetch($subscriptionId)->update($options);

        $UpdatedSubscription = $api->subscription->fetch($subscriptionId);
        $updatedPlan         = $api->plan->fetch($UpdatedSubscription['plan_id']);

        $Sub_Startday = date('d/m/Y H:i:s', $UpdatedSubscription['current_start']); 
        $Sub_Endday = date('d/m/Y H:i:s', $UpdatedSubscription['current_end']); 
        $trial_ends_at = Carbon::createFromTimestamp($UpdatedSubscription['current_end'])->toDateTimeString(); 

        if (is_null($subscriptionId)) {
            return false;
        }
        else{
            Subscription::where('user_id',$user_id)->latest()->update([
                'price'         =>  $updatedPlan['item']->amount,
                'stripe_id'     =>  $UpdatedSubscription['id'],
                'stripe_status' =>  $UpdatedSubscription['status'],
                'stripe_plan'   =>  $UpdatedSubscription['plan_id'],
                'quantity'      =>  $UpdatedSubscription['quantity'],
                'countryname'   =>  $countryName,
                'regionname'    =>  $regionName,
                'cityname'      =>  $cityName,
                'trial_ends_at' => $trial_ends_at,
                'ends_at'       => $trial_ends_at,
        ]);

            User::where('id',$user_id)->update([
                'subscription_start'    =>  $Sub_Startday,
                'subscription_ends_at'  =>  $Sub_Endday,
          ]);
        }
        return response()->json([
          'status'  => 'true',
          'Message' => 'Subscription Updated Successfully'], 200);    

        }
          catch (\Exception $e){
            return response()->json([
              'status'  => 'false',
              'Message' => 'upgrade Subscription is fails'], 200);
        }
    }
    else{
      return response()->json([
        'status'  => 'fails',
        'Message' => 'Subscription Updated cannot done for UPI payment'], 200);}
}

public function AdsView(Request $request)
{
    $ads_videos = AdsVideo::where('ads_videos.video_id',$request->videoid)
    ->join('advertisements', 'ads_videos.ads_id', '=', 'advertisements.id')
    ->first();

    AdvertisementView::create([
      'user_id'  => $request->user_id,
      'video_id' => $request->videoid,
      'ads_id' => $ads_videos->ads_id,
    ]);

      if($request->status == "seen"){

        $Video = Video::find($request->videoid);
        $Video->ads_status = '1';
        $Video->update();

        $message = 1;

      }else{
        $message = 0;
      }

    return response()->json([
      'status'  => $message ,
      'Message' => 'Ads video'], 200);
  
}

public function Adstatus_upate(Request $request)
{
    $Video = Video::find($request->videoid);
    $Video->ads_status = '0';
    $Video->update();

    return response()->json([
      'status'  => 'true',
      'Message' => 'Ads status changed Successfully'], 200);
   }

  public function homesetting()
  {
      $homesetting = HomeSetting::first();

      return $homesetting;
  }

}

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
use Unicodeveloper\Paystack\Exceptions\IsNullException;
use Unicodeveloper\Paystack\Exceptions\PaymentVerificationFailedException;
use Illuminate\Pagination\LengthAwarePaginator;
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
use App\LiveLanguage;
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
use App\OrderHomeSetting;
use App\MobileHomeSetting;
use App\SiteTheme;
use App\PlayerAnalytic;
use App\SystemSetting;
use App\CurrencySetting;
use App\MobileSideMenu;
use App\CategoryLive;
use App\TVLoginCode;
use Paystack;
use App\VideoCommission;
use App\ModeratorsUser;
use App\Paystack_Andriod_UserId;
use App\AdsEvent;
use App\VideoSchedules as VideoSchedules;
use App\ScheduleVideos as ScheduleVideos;
use App\ReSchedule as ReSchedule;
use App\WebComment;
use App\Channel;
use App\ThumbnailSetting;
use App\Menu;
use App\SeriesGenre;
use App\M3UFileParser;
use File;

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

          // Paystack

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
            $response = array(
              "status"  => 'false' ,
              "message" => "Paystack Key Missing",
            );
        }

      //Adveristment plays 24hrs 
        $this->adveristment_plays_24hrs = Setting::pluck('ads_play_unlimited_period')->first();

      // pagination
        $this->settings = Setting::first();
        $this->settings->videos_per_page;

      // Gobal PPV Price   
        $PPV_settings = Setting::where('ppv_status', '=', 1)->first();
        $this->ppv_gobal_price = !empty($PPV_settings) ? $PPV_settings->ppv_price : null;
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
        }
        else {
          $user_data['mobile'] = '';
        }

        if (isset($input['skip'])) {
          $skip = $input['skip'];
        }
        else {
          $skip = 0;
        }

        if (!empty($input['referrer_code'])){
          $referrer_code = $input['referrer_code'];
        }

        if ( isset($referrer_code) && !empty($referrer_code) ) {
              $referred_user = User::where('referral_token','=',$referrer_code)->first();
              $referred_user_id = $referred_user->id;
        } else {
              $referred_user_id =null;
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

        if(!$settings->free_registration && $skip == 0) {
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
              $user->token = $user_data['token'];
              $user->referral_token = $ref_token;
              $user->active = 1;
              $user->save();
              $userdata = User::where('email', '=', $request->get('email'))->first();
              $userid = $userdata->id;

              send_password_notification('Notification From '.GetWebsiteName() ,'Your Account  has been Created Successfully','Your Account  has been Created Successfully','',$userid);

        }
        else {
              if($user != null){
                $response = array('status'=>'false','message' => 'Email id Already Exists');
                return response()->json($response, 200);
              }else{
                $response = array('status'=>'false','message' => 'Username Already Exists');
                return response()->json($response, 200);
              }
        }
        if(!empty($userdata)){
          $userid = $user->id;
        }else{
          $userid = '';
        }
    try {
      if($settings->free_registration && $settings->activation_email == 1){

        try {
          $email = $input['email'];
          $uname = $input['username'];
          Mail::send('emails.verify', array('activation_code' => $user->activation_code, 'website_name' => $settings->website_name), function($message) use ($email,$uname) {
          $message->to($email,$uname)->subject('Verify your email address');
        });

        } catch (\Throwable $th) {
          //throw $th;
        }

        $response = array('status'=>'true','message' => 'Registered Successfully.');
      }
      else {
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
            }elseif( $paymentMode == "Paystack" ){

              $paystack_subcription_id = '124v';

              // $subcription_details = Paystack::fetchSubscription($paystack_subcription_id) ;

              // $paystack_Sub_Startday  = Carbon::parse($subcription_details['data']['createdAt'])->setTimezone('UTC')->format('d/m/Y H:i:s');
              // $paystack_Sub_Endday    = Carbon::parse($subcription_details['data']['next_payment_date'] )->setTimezone('UTC')->format('d/m/Y H:i:s');
              // $paystack_trial_ends_at = Carbon::parse($subcription_details['data']['next_payment_date'] )->setTimezone('UTC')->toDateTimeString();

            //   Subscription::create([
            //     'user_id'        =>  $userid,
            //     'name'           =>  $subcription_details['data']['plan']['name'],
            //     'price'          =>  $subcription_details['data']['amount'] ,   // Amount Paise to Rupees
            //     'stripe_id'      =>  $subcription_details['data']['subscription_code'] ,
            //     'stripe_status'  =>  $subcription_details['data']['status'] ,
            //     'stripe_plan'    =>  $subcription_details['data']['plan']['plan_code'],
            //     'quantity'       =>  null,
            //     'countryname'    =>  Country_name(),
            //     'regionname'     =>  Region_name(),
            //     'cityname'       =>  city_name(),
            //     'PaymentGateway' =>  'Paystack',
            //     'trial_ends_at'  =>  $paystack_trial_ends_at,
            //     'ends_at'        =>  $paystack_trial_ends_at,
            // ]);
            $next_date = $request->days;
            $current_date = date('Y-m-d h:i:s');
            $date = Carbon::parse($current_date)->addDays($next_date);

            Subscription::create([
              'user_id'        =>  $userid,
              'name'           =>  $request->plan_name,
              'price'          =>  $request->amount,   // Amount Paise to Rupees
              'stripe_id'      =>  $request->subscription_code ,
              'stripe_status'  =>  $request->status,
              'stripe_plan'    =>  $request->plan_code,
              'quantity'       =>  null,
              'countryname'    =>  Country_name(),
              'regionname'     =>  Region_name(),
              'cityname'       =>  city_name(),
              'PaymentGateway' =>  'Paystack',
              'trial_ends_at'  =>  $date,
              'ends_at'        =>  $date,
          ]);

            User::where('id',$userid)->update([
                'role'                  =>  'subscriber',
                'stripe_id'             =>  $request->subscription_code ,
                'subscription_start'    =>  $current_date,
                'subscription_ends_at'  =>  $date,
                'payment_gateway'       =>  'Paystack',
                'payment_type'          => 'recurring',
                'payment_status'        => 'active',
            ]);

              return $response = array('status'=>'true',
              'message' => 'Registered Successfully.');

            }
            else{
                     $payment_type = $input['payment_type'];
                     $paymentMethod = $input['py_id'];

                    if ( $payment_type == "recurring") {
                             $plan = $input['plan'];

                           try {
                              $stripe_payment = $user->newSubscription($stripe_plan, $plan)->create($paymentMethod);

                              $user = User::find($user->id);
                              $user->role = 'subscriber';
                              $user->payment_type = 'recurring';
                              $user->card_type = 'stripe';
                              $user->save();
                              $email = $input['email'];
                              $uname = $input['username'];

                              $response = array(
                                'status' => 'true',
                                'message' => 'Subscription Done & user Registered Successfully.',
                                'user_id' =>  $userid
                            );

                           } catch (\Throwable $th) {

                              $response = array(
                                'status' => 'false',
                                'message' => 'Subscription Not done',
                                'error_message' =>   $th,
                                'user_id' =>  $userid
                            );

                           }

                            // try {
                            //     Mail::send('emails.verify', array('activation_code' => $user->activation_code, 'website_name' => $settings->website_name), function($message) use ($email,$uname) {
                            //       $message->to($email,$uname)->subject('Verify your email address');
                            //   });
                            // } catch (\Throwable $th) {
                            //   //throw $th;
                            // }



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

                                        try {
                                            Mail::send('emails.verify', array('activation_code' => $user->activation_code, 'website_name' => $settings->website_name), function($message) use ($email,$uname) {
                                              $message->to($email,$uname)->subject('Verify your email address');
                                            });
                                        } catch (\Throwable $th) {
                                          //throw $th;
                                        }

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

                                            try {
                                              Mail::send('emails.verify', array('activation_code' => $user->activation_code, 'website_name' => $settings->website_name), function($message) use ($email,$uname) {
                                                $message->to($email,$uname)->subject('Verify your email address');
                                              });
                                            } catch (\Throwable $th) {
                                              //throw $th;
                                            }

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
                      //  $plan_details = SubscriptionPlan::where("plan_id","=",$plan)->first();
                      //  $next_date = $plan_details->days;
                      //  $current_date = date('Y-m-d h:i:s');
                      //  $date = Carbon::parse($current_date)->addDays($next_date);

                      // Mail::send('emails.subscriptionmail', array(
                      //          /* 'activation_code', $user->activation_code,*/
                      //           'name'=>$user->username,
                      //     'days' => $plan_details->days,
                      //     'price' => $plan_details->price,
                      //     'plan_id' => $plan_details->plan_id,
                      //     'ends_at' => $date,
                      //     'created_at' => $current_date), function($message) use ($request,$user) {
                      //                           $message->from(AdminMail(),'Flicknexs');
                      //                           $message->to($user->email, $user->username)->subject($request->get('subject'));
                      //                       });

            // send_password_notification('Notification From '. GetWebsiteName(),'Your Payment has been done Successfully','Your Your Payment has been done Successfully','',$user->id);
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
      'otp' => $request->get('otp'),
      'password' => $request->get('password')
    );


    if(!empty($users)){
      $user_id = $users->id;
      $adddevice = new LoggedDevice;
      $adddevice->user_id = $user_id;
      $adddevice->user_ip = $userIp;
      $adddevice->device_name = $device_name;
      $adddevice->save();
    }

    if ( !empty($users) && Auth::attempt($email_login) || !empty($users) && Auth::attempt($username_login) || !empty($users) && Auth::attempt($mobile_login)  ){

      Paystack_Andriod_UserId::truncate();
      Paystack_Andriod_UserId::create([ 'user_id' => Auth::user()->id ]);

      if($settings->free_registration && !Auth::user()->stripe_active){

        if(Auth::user()->role == 'registered'){
          $user = User::find(Auth::user()->id);
          $user->role = 'registered';
          $user->token = $token;
          $user->save();

        }else if(Auth::user()->role == 'admin'){

          $user = User::find(Auth::user()->id);
          $user->role = 'admin';
          $user->token = $token;
          $user->save();

        }else if(Auth::user()->role == 'subscriber'){
          $user = User::find(Auth::user()->id);
          $user->role = 'subscriber';
          $user->token = $token;
          $user->save();
        }
      }

      if(Auth::user()->role == 'subscriber' || (Auth::user()->role == 'admin' || Auth::user()->role == 'demo') || (Auth::user()->role == 'registered') ):

        $id   = Auth::user()->id;
        $role = Auth::user()->role;
        $username = Auth::user()->username;
        $password = Auth::user()->password;
        $email  = Auth::user()->email;
        $mobile = Auth::user()->mobile;
        $avatar = Auth::user()->avatar;

        if(Auth::user()->role == 'subscriber'){

          $Subscription = Subscription::where('user_id',Auth::user()->id)->orderBy('created_at', 'DESC')->first();
          $Subscription = Subscription::Join('subscription_plans','subscription_plans.plan_id','=','subscriptions.stripe_plan')
          ->where('subscriptions.user_id',Auth::user()->id)
          ->orderBy('subscriptions.created_at', 'desc')->first();

          $plans_name = $Subscription->plans_name;
          $plan_ends_at = $Subscription->ends_at;

        }else{
          $plans_name = '';
          $plan_ends_at = '';
        }
        $user_details = array([
          'user_id'=>$id,
          'role'=>$role,
          'username'=>$username,
          'email'=>$email,
          'mobile'=>$mobile,
          'plans_name'=>$plans_name,
          'plan_ends_at'=>$plan_ends_at,
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

      try {
        Mail::send('emails.resetpassword', array('verification_code' => $verification_code), function($message) use ($email) {
          $message->to($email)->subject('Verify your email address');
        });

      } catch (\Throwable $th) {
        //throw $th;
      }

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
          send_password_notification('Notification From '. GetWebsiteName(),'Password has been Updated Successfully','Password Update Done','',$user_id->id);
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
        'home_genre' =>  VideoCategory::where('id',$videocategoryid)->pluck('home_genre')->first(),
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

  public function categoryvideosIOS(Request $request)
  {

    $videocategories = VideoCategory::select('id','image')->get()->toArray();

    $myData = array();

    foreach ($videocategories as $key => $videocategory) {

        $videocategoryid = $videocategory['id'];
        $genre_image = $videocategory['image'];

        $videos= Video::Join('categoryvideos','categoryvideos.video_id','=','videos.id')
          ->where('categoryvideos.category_id',$videocategoryid)
          ->where('active','=',1)->where('status','=',1)
          ->where('draft','=',1)->latest('videos.created_at')->limit(12);

          if(Geofencing() !=null && Geofencing()->geofencing == 'ON')
          {
            $videos = $videos->whereNotIn('videos.id',Block_videos());
          }

          $videos = $videos->get()->map(function ($item) {
            $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
            $item['video_url'] = URL::to('/').'/storage/app/public/';
            $item['category_name'] = VideoCategory::where('id',$item->category_id)->pluck('slug')->first();
            return $item;
        });
     
        $main_genre = CategoryVideo::Join('video_categories','video_categories.id','=','categoryvideos.category_id')->get('name');

        foreach($main_genre as $value){
          $category[] = $value['name'];
        }

        $main_genre =  !empty($category) ? implode(",",$category) : " ";

        $msg = count($videos) > 0 ?  'success' : "";

        $myData[] = array(
          "message" => $msg,
          'gener_name' =>  VideoCategory::where('id',$videocategoryid)->pluck('name')->first(),
          'home_genre' =>  VideoCategory::where('id',$videocategoryid)->pluck('home_genre')->first(),
          'gener_id' =>  VideoCategory::where('id',$videocategoryid)->pluck('id')->first(),
          "videos" => $videos
        );
    }

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

      try {
        Mail::send('resetpassword', array('verification_code' => $verification_code), function($message) use ($request)  {
          $message->to($request->get('email'))->subject('Verify your email address');
        });
      } catch (\Throwable $th) {
        //throw $th;
      }

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

        // $user->password = $request->password;
        $user->password = Hash::make($request->password);
        $user->save();

        $response = array(
          'status'=>'true',
          'message'=>'Password changed successfully.'
        );
                  send_password_notification('Notification From '. GetWebsiteName(),'Password has been Updated Successfully','Password Update Done','',$user_id);

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
    try {

        $check_Kidmode = 0 ;

        $data = Video::where('active',1)->where('status', 1)->where('draft',1);

              if( Geofencing() !=null && Geofencing()->geofencing == 'ON')
              {
                $data = $data->whereNotIn('videos.id',Block_videos());
              }

              if( $check_Kidmode == 1 )
              {
                $data = $data->whereBetween('age_restrict', [ 0, 12 ]);
              }

          $data = $data->latest()->limit(30)->get()->map(function ($item) {
            $item['image_url'] = URL::to('/public/uploads/images/'.$item->image);
            $item['source']    = "Videos";
            return $item;
          });

        $response = array(
          'status'  => 'true',
          'Message' => 'Latest videos Retrieved successfully',
          'latestvideos' => $data
        );

    } catch (\Throwable $th) {

      $response = array(
        'status'  => 'false',
        'Message' => $th->getMessage(),
      );
      
    }

    
        
        return response()->json($response, 200);
  }


  public function categorylist()
  {
    $channellist = VideoCategory::orderBy('order')->get()->map(function ($item) {
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
        ->where('categoryvideos.category_id',$channelid)
        ->where('active','=',1)->where('status','=',1)->orderBy('videos.created_at', 'desc')->get()->map(function ($item) {
          $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
          $item['video_url'] = URL::to('/').'/storage/app/public/';
          return $item;
    });

    foreach ($videocategories as $key => $videocategory) {

        $videocategoryid = $videocategory['id'];
        $genre_image = $videocategory['image'];

        $videos= Video::Join('categoryvideos','categoryvideos.video_id','=','videos.id')
                ->where('categoryvideos.category_id',$videocategoryid)
                ->where('active','=',1)->where('status','=',1)
                ->orderBy('videos.created_at', 'desc')->get()->map(function ($item) {
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
        "genre_id"     => $videocategoryid,
        "genre_image"  => URL::to('/').'/public/uploads/videocategory/'.$genre_image,
        "message" => $msg,
        "videos"  => $videos,
        "videos_category" => $videos_category,
      );

    }

    $videos_cat = VideoCategory::where('id','=',$channelid)->get();

    $response = array(
      'status'     => $status ,
      'main_genre' => $videos_cat[0]->name,
      'categoryVideos' => $videos
    );

    return response()->json($response, 200);
  }

  public function channelvideosIOS(Request $request)
  {
    try {
      $channelid       = $request->channelid ;
      $current_page_no = $request->current_page_no ;
      $per_page_no     = $request->per_page_no ;

      $videos= Video::Join('categoryvideos','categoryvideos.video_id','=','videos.id')
              ->where('categoryvideos.category_id',$channelid )
              ->where('active','=',1)->where('status','=',1)->where('draft',1) ;
  
              if(Geofencing() !=null && Geofencing()->geofencing == 'ON')
              {
                $videos = $videos  ->whereNotIn('videos.id',Block_videos());
              }
  
      $videos = $videos->latest('videos.created_at')->paginate( $per_page_no , ['*'], 'page', $current_page_no );
     
      $videos->getCollection()->transform(function ($value) {
          $value['player_image']   = $value['player_image'] == null ? 'null' : $value['player_image'];
          $value['video_tv_image'] = $value['video_tv_image'] == null ? 'null' : $value['video_tv_image'];
          $value['duration'] = $value['duration'] == null ? 0 : $value['duration'];
          $value['views']    = $value['views'] == null ? 0 : $value['views'];
          return $value;
      }); 

      $VideoCategory_name = VideoCategory::where('id','=',$channelid)->pluck('name')->first();
  
      $response = array(
        'status'     => 'True' ,
        "message"    => 'Successfully Retrieved Videos' ,
        'main_genre' => $VideoCategory_name,
        'categoryVideos' => $videos
      );
  
    } catch (\Throwable $th) {
      
      $response = array(
        'status'     => 'False' ,
        "message"    => $th->getMessage() ,
      );
    }
    
    return response()->json($response, 200);
  }

  private static function plans_ads_enable($user_id){

      $user_role = User::where('id',$user_id)->pluck('role')->first();

      if( $user_role == " " ){
        return 0 ;
      }

      if( $user_role == "registered" ){
          return 1 ;
      }

      if( $user_role == "admin" ){
          return 0 ;
      }

      $Subscription_ads_status = Subscription::Join('subscription_plans','subscription_plans.plan_id','=','subscriptions.stripe_plan')
                      ->where('subscriptions.user_id',$user_id)
                      ->latest('subscriptions.created_at')
                      ->pluck('ads_status')
                      ->first();

      if( $Subscription_ads_status != null && $Subscription_ads_status == 1 ){
          return $Subscription_ads_status ;
      }
      elseif(  $Subscription_ads_status == null ){
          return 1 ;
      }else{
          return 1 ;
      }
  }

  public function videodetail(Request $request)
  {

    try {
      $videoid = $request->videoid;

      $current_date = date('Y-m-d h:i:s a', time());
  
      $videodetail = Video::where('id',$videoid)->orderBy('created_at', 'desc')->get()->map(function ($item) {
          $item['details'] = strip_tags($item->details);
          $item['description'] = strip_tags($item->description);
          $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
          $item['player_image'] = URL::to('/').'/public/uploads/images/'.$item->player_image;
          $item['video_url'] = URL::to('/').'/storage/app/public/';
          $item['reelvideo_url'] = URL::to('/').'/public/uploads/reelsVideos/'.$item->reelvideo;
          $item['pdf_files_url'] = URL::to('/').'/public/uploads/videoPdf/'.$item->pdf_files;
          $item['mobile_image_url'] = URL::to('/').'/public/uploads/images/'.$item->mobile_image;
          $item['tablet_image_url'] = URL::to('/').'/public/uploads/images/'.$item->tablet_image;
          $item['video_tv_image'] = URL::to('/').'/public/uploads/images/'.$item->video_tv_image;
          $item['transcoded_url'] = URL::to('/storage/app/public/').'/'.$item->path . '.m3u8';
          $item['description']    = strip_tags(html_entity_decode($item->description));
          $item['movie_duration']    = gmdate('H:i:s', $item->duration);
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
          $item['ios_publish_time']    = Carbon::parse($item->publish_time)->format('Y-m-d H:i:s');

          // Videos URL 
          if( $item['type'] == "mp4_url"){

            $item['videos_url'] =  $item->mp4_url ;
          }
          elseif( $item['type'] == "m3u8_url" ){

            $item['videos_url']    = $item->m3u8_url ;
          }
          elseif( $item['type'] == "embed" ){

            $item['videos_url']    = $item->embed_code ;
          }
          elseif( $item['type'] == null &&   pathinfo($item['mp4_url'], PATHINFO_EXTENSION) == "mp4" ){

            $item['videos_url']    = URL::to('/storage/app/public/'.$item->path.'.m3u8');
          }
          else{

            $item['videos_url']    = null ;
          }

          return $item;
        });
  
        $skip_time = ContinueWatching::orderBy('created_at', 'DESC')->where('user_id',$request->user_id)->where('videoid','=',$videoid)->first();
        
        if(!empty($skip_time)){
          $skip_time = $skip_time->skip_time;
  
        }else{
          $skip_time = 0;
        }
  
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
            $ppv_video_status = "can_view";
      }
  
  
           $videos_cat_id = Video::where('id','=',$videoid)->pluck('video_category_id');
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

      $video = Video::find( $request->videoid);

      $AdsVideosPre = AdsEvent::Join('advertisements','advertisements.id','=','ads_events.ads_id')
              ->Join('videos','advertisements.ads_category','=','videos.pre_ads_category')
              ->where('ads_events.status',1)
              ->where('advertisements.status',1)
              ->where('advertisements.ads_category',$video->pre_ads_category)
              ->where('ads_position','pre')
              ->where('advertisements.id',$video->pre_ads)
              ->groupBy('advertisements.id')
              ->get()->map->only('ads_path','ads_video')->map(function ($item) {
                  $item['ads_type'] = $item['ads_video'] == null ? "Google_tag" : "upload_ads";
                  $item['ads_videos_url'] = URL::to('public/uploads/AdsVideos/'.$item['ads_video']);
                  return $item;
              });
  
  
      $AdsVideosMid = AdsEvent::Join('advertisements','advertisements.id','=','ads_events.ads_id')
              ->Join('videos','advertisements.ads_category','=','videos.mid_ads_category')
              ->where('ads_events.status',1)
              ->where('advertisements.status',1)
              ->where('advertisements.ads_category',$video->mid_ads_category)
              ->where('videos.id',$video->id)
              ->where('ads_position','mid')
              ->where('advertisements.id',$video->mid_ads)
              ->groupBy('advertisements.id')
              ->get()->map->only('ads_path','ads_video')->map(function ($item) {
                  $item['ads_type'] = $item['ads_video'] == null ? "Google_tag" : "upload_ads";
                  $item['ads_videos_url'] = URL::to('public/uploads/AdsVideos/'.$item['ads_video']);
                  return $item;
              });
  
  
      $AdsVideosPost = AdsEvent::Join('advertisements','advertisements.id','=','ads_events.ads_id')
              ->Join('videos','advertisements.ads_category','=','videos.post_ads_category')
              ->where('ads_events.status',1)->where('advertisements.status',1)
              ->where('advertisements.ads_category',$video->post_ads_category)
              ->where('videos.id',$video->id)
              ->where('ads_position','post')
              ->where('advertisements.id',$video->post_ads)
              ->groupBy('advertisements.id')
              ->get()->map->only('ads_path','ads_video')->map(function ($item) {
                  $item['ads_type'] = $item['ads_video'] == null ? "Google_tag" : "upload_ads";
                  $item['ads_videos_url'] = URL::to('public/uploads/AdsVideos/'.$item['ads_video']);
                  return $item;
              });

        $plans_ads_enable = $this->plans_ads_enable($request->user_id);
       

        if($plans_ads_enable == 1){

          $current_time = Carbon::now()->format('H:i:s');

          $video_ads_tag_url = AdsEvent::select('videos.ads_tag_url_id','videos.id as video_id','advertisements.*','ads_events.ads_id','ads_events.status','ads_events.end','ads_events.start')
              ->Join('advertisements','advertisements.id','=','ads_events.ads_id')
              ->Join('videos', 'advertisements.id', '=', 'videos.ads_tag_url_id');
              // ->whereDate('start', '=', Carbon\Carbon::now()->format('Y-m-d'))

              if($this->adveristment_plays_24hrs == 0){
                  $video_ads_tag_url =  $video_ads_tag_url->whereTime('ads_events.start', '<=', $current_time)->whereTime('ads_events.end', '>=', $current_time);
              }

              $video_ads_tag_url =  $video_ads_tag_url->where('ads_events.status',1)
                    ->where('advertisements.status',1)
                    ->where('advertisements.ads_upload_type','tag_url')
                    ->where('advertisements.id',$video->ads_tag_url_id)
                    ->where('videos.id', $video->id)
                    ->groupBy('advertisements.id')
                    ->pluck('ads_path')
                    ->first();

        }else{
            $video_ads_tag_url = null ;
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
        'shareurl' => URL::to('category/videos').'/'.$videodetail[0]->slug,
        'videodetail' => $videodetail,
        'videossubtitles' => $moviesubtitles,
        'main_genre' => $main_genre,
        'languages' => $languages,
        'videoads' => $videoads,
        'Ads_videos_Pre' => $AdsVideosPre,
        'Ads_videos_Mid' => $AdsVideosMid,
        'Ads_videos_post' => $AdsVideosPost,
        'video_ads_tag_url' => $video_ads_tag_url ,
      );
    } catch (\Throwable $th) {
        $response = array(
          'status'=>'false',
          'message'=>$th->getMessage(),
        );
    }
   
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
        "message" => $msg,
        "videos" => $videos
      );



    $response = array(
      'status' => 'true',
      'live_streams' => $myData,
    );
    return response()->json($response, 200);

  }

  public function livestreamdetail(Request $request)
  {
    try {
        $liveid = $request->liveid;
        $user_id = $request->user_id;

      // Live Language

        $languages = LiveLanguage::Join('languages','languages.id','=','live_languages.language_id')->where('live_languages.live_id',$liveid)->get('name');

        foreach($languages as $value){
          $language[] = $value['name'];
        }

        $languages = !empty($language) ? implode(",",$language) : " ";
        
      // Category Live

        $categorys = CategoryLive::join('live_categories','live_categories.id','=','livecategories.category_id')->where('live_id',$liveid)->get('name');

        foreach($categorys as $value){
          $category[] = $value['name'];
        }

        $categories = !empty($category) ? implode(",",$category) : ' ' ;

      // PPV 

        $current_date = date('Y-m-d h:i:s a', time());

        $ppv_exist = LivePurchase::where('video_id',$liveid)->where('user_id',$user_id)->count();

        if ($ppv_exist > 0) {

              $ppv_time_expire = LivePurchase::where('user_id','=',$user_id)->where('video_id','=',$liveid)->pluck('to_time')->first();

              $ppv_video_status = $ppv_time_expire > $current_date ? "can_view" :  "expired" ;

        } else {
              $ppv_video_status = "pay_now";
        }

        //  Like & Dislike

        if($request->user_id != ''){

          $like_data = LikeDisLike::where("live_id","=",$liveid)->where("user_id","=",$user_id)->where("liked","=",1)->count();
          $dislike_data = LikeDisLike::where("live_id","=",$liveid)->where("user_id","=",$user_id)->where("disliked","=",1)->count();
          $like = ($like_data == 1) ? "true" : "false";
          $dislike = ($dislike_data == 1) ? "true" : "false";
        }
        else{

          $like = 'false';
          $dislike = 'false';
        }

        $livestream_details = LiveStream::findorfail($request->liveid)->where('id',$request->liveid)->where('active',1)
                      ->where('status',1)->get()->map(function ($item) use ($user_id) {
                          $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
                          $item['player_image'] = URL::to('/').'/public/uploads/images/'.$item->player_image;
                          $item['live_description'] = $item->description ? $item->description : "" ;
                          $item['trailer'] = null ;
                          $item['livestream_format'] =  $item->url_type ;

                          if( $item['livestream_format'] == "mp4"){
                            $item['livestream_url'] =  $item->mp4_url ;
                          }

                          elseif( $item['livestream_format'] == "embed"){
                            $item['livestream_url'] =  $item->embed_url ;
                          }

                          elseif( $item['livestream_format'] == "live_stream_video"){
                            $item['livestream_url'] =  $item->live_stream_video ;
                          }

                          elseif( $item['livestream_format'] == "acc_audio_url"){
                            $item['livestream_url'] =  $item->acc_audio_url ;
                          }

                          elseif( $item['livestream_format'] == "acc_audio_file"){
                            $item['livestream_url'] =  $item->acc_audio_file ;
                          }

                          elseif( $item['livestream_format'] == "Encode_video"){
                            $item['livestream_url'] =  $item->hls_url ;
                          }

                          else{
                            $item['livestream_url'] =  null ;
                          }

                        // M3U_channels
                        $parser       = new M3UFileParser( $item->m3u_url);
                        $item['M3U_channel'] =   $parser->getGroup()  ;

          $plans_ads_enable = $this->plans_ads_enable($user_id);

          if( $plans_ads_enable == 1){

            $item['live_ads_url'] =  AdsEvent::Join('advertisements','advertisements.id','=','ads_events.ads_id')
                                      // ->whereDate('start', '=', Carbon\Carbon::now()->format('Y-m-d'))
                                      // ->whereTime('start', '<=', $current_time)
                                      // ->whereTime('end', '>=', $current_time)
                                      ->where('ads_events.status',1)
                                      ->where('advertisements.status',1)
                                      ->where('advertisements.id',$item->live_ads)
                                      ->pluck('ads_path')->first();
                            
          }else{
            $item['live_ads_url'] = null;
          }
         
          return $item;
        });

      $response = array(
        'status' => 'true',
        'shareurl' => URL::to('live').'/'.$liveid,
        'livedetail' => $livestream_details,
        'like' => $like,
        'dislike' => $dislike,
        'ppv_video_status' => $ppv_video_status,
        'languages' => $languages,
        'categories' => $categories,
      );

      
    } catch (\Throwable $th) {

        $response = array(
          'status' => 'false',
          'message' => $th->getMessage() ,
        );
    }
    return response()->json($response, 200);
  }

  public function M3u_channel_videos(Request $request)
  {
    try {
      
        $M3u_category = $request->m3u_url_category;
        $m3u_url = $request->m3u_url;

        $parser = new M3UFileParser($m3u_url);
        $parser_list = $parser->list();


        $M3u_url_array = collect($parser_list[$M3u_category])->map(function ($item) {

            $mp3 = preg_match_all('/(?P<tag>#EXTINF:-1)|(?:(?P<prop_key>[-a-z]+)=\"(?P<prop_val>[^"]+)")|(?<something>,[^\r\n]+)|(?<url>http[^\s]+)/', $item, $match );
            $count = count( $match[0] );
            $tag_name = '1' ;
            $url      = '4' ;

            for( $i =0; $i < $count; $i++ ){
                $M3u_videos = array(
                    'M3u_Networl_url' => $match[0][1],
                    'M3u_video_image' => $match[0][2],
                    'M3u_video_title' => $match[0][3],
                    'M3u_video_Network' => $match[0][4],
                    'M3u_video_url' => $match[0][5],
                  );
            } 

            return $M3u_videos;
        });

        $respond = array(
          'status' => 'true' ,
          'message' => 'M3 urls Retrieved Successfully !' ,
          'M3u_category' => $M3u_category ,
          'M3u_url_array' => $M3u_url_array ,
        );

    } catch (\Throwable $th) {
      
      $respond = array(
        'status' => 'false' ,
        'message' => $th->getMessage() ,
      );
    }
  
    return response()->json($respond, 200);

  }

  public function cmspages()
     {
      try {
          $pages = Page::where('active', '=', 1)->get()->map(function ($item) {
            $item['page_url'] = URL::to('page/'.$item->slug);
            return $item;
          });

          $response=array(
            'status' => 'true',
            'pages' => $pages
          );

      } catch (\Throwable $th) {

          $response=array(
            'status' => 'false',
            'pages' => $th->getMessage()
          );
      }
     
      return response()->json($response, 200);
     }

     public function sliders()
     {

        $sliders = Slider::where('active', '=', 1)->orderBy('created_at', 'desc')->get()->map(function ($item) {
                  $item['slider'] = URL::to('/').'/public/uploads/videocategory/'.$item->slider;
                  $item['slider_source'] = "slider";
                  return $item;
        });

        $video_banners = Video::where('active','=',1)->where('status','=',1)
                  ->where('banner', '=', 1)->orderBy('created_at', 'desc')->get()->map(function ($item) {
                  $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
                  $item['video_url'] = URL::to('/').'/storage/app/public/';
                  $item['player_image'] = URL::to('/').'/public/uploads/images/'.$item->player_image;
                  $item['slider_source'] = "videos";
                  return $item;
        });

        $live_banner = LiveStream::where('active','=',1)
                  ->where('banner', '=', 1)->orderBy('created_at', 'desc')->get()->map(function ($item) {
                  $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
                  $item['player_image'] = URL::to('/').'/public/uploads/images/'.$item->player_image;
                  $item['slider_source'] = "livestream";
                  return $item;
        });

        $series_banner = Series::where('active','=',1)->where('banner', '=', 1)->orderBy('created_at', 'desc')->get()->map(function ($item) {
              $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
              $item['player_image'] = URL::to('/').'/public/uploads/images/'.$item->player_image;
              $item['slider_source'] = "series";
              return $item;
        });

        $slider_array  =  array ( 'sliders'       => $sliders);
        $videos_array  =  array ( 'video_banners' => $video_banners);
        $live_array    =  array ( 'live_banner'   => $live_banner);
        $series_array  =  array ( 'series_banner' => $series_banner);

        $combine_sliders[] =  array_merge($slider_array,$videos_array,$live_array,$series_array);

        $response = array(
          'status' => 'true',
          'banners' => $combine_sliders,
        );

        return response()->json($response, 200);
     }

     public function coupons(Request $request)
      {
            $user_id = $request->user_id;
           // $myrefferals = User::find($user_id)->referrals;
            $coupons = Coupon::first();
            // $myrefferals = User::with('referrals')->where("id",$user_id)->where("coupon_used",$user_id)->get();
            $myrefferals = User::where("referrer_id","=",$user_id)->orderBy('created_at', 'desc')->get()->map(function ($item) {
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
      $sliders = MobileSlider::where('active', '=', 1)->orderBy('created_at', 'desc')->get()->map(function ($item) {
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
    $ppvvideodetail = PpvVideo::where('id',$ppvvideoid)->orderBy('created_at', 'desc')->get()->map(function ($item) {
        $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
        return $item;
      });
      $ppv_status = PpvPurchase::join('ppv_videos', 'ppv_videos.id', '=', 'ppv_purchases.video_id')
      ->where('ppv_purchases.user_id', '=', $user_id)
      ->where('ppv_purchases.video_id', '=', $ppvvideoid)->orderBy('ppv_purchases.created_at', 'desc')->get()->map(function ($item) {
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

      try {

          $user = User::find($request->user_id);

          $input = array(
            'email'    => $request->user_email,
            'username' => $request->user_username,
            'name'     => $request->user_name,
            'ccode'    => $request->user_ccode,
            'mobile'   => $request->user_mobile,
            'gender'   => $request->gender,
            'DOB'      => $request->DOB,
          );

          if($request->hasFile('avatar')){

            $file = $request->avatar;

            if (File::exists(base_path('public/uploads/avatars/'.$user->avatar))) {
                File::delete(base_path('public/uploads/avatars/'.$user->avatar));
            }

            $filename   = 'user-avatar-'.time().'.'.$file->getClientOriginalExtension();
            Image::make($file)->save(base_path().'/public/uploads/avatars/'.$filename );

            $input+= [ 'avatar' => $filename ] ;

          }
        
          if(!empty($request->user_password)){
            $input+= [ 'password' => Hash::make($request->user_password) ] ;
          }

          $user->update($input);
          
          $response = array(
            'status'=>'true',
            'message'=>'Your Profile detail has been updated'
          );

      } catch (\Throwable $th) {
        
        $response = [
          'status' => 'false',
          'message' => $th->getMessage(),
        ];

      }

      return response()->json($response, 200);
   }

   public function addwishlist(Request $request) {

    $user_id = $request->user_id;
    $video_id = $request->video_id;

    if (!empty($video_id)) {
        $count = Wishlist::where('user_id', $user_id)->where('video_id', $video_id)->count();

        if ($count > 0) {
            Wishlist::where('user_id', $user_id)->where('video_id', $video_id)->delete();

            $response = [
                'status' => 'false',
                'message' => 'Removed From Your Wishlist'
            ];
        } else {
            $data = ['user_id' => $user_id, 'video_id' => $video_id];
            Wishlist::insert($data);

            $response = [
                'status' => 'true',
                'message' => 'Added to Your Wishlist'
            ];
        }
    }
    return response()->json($response, 200);

  }

  public function addfavorite(Request $request) {

    try {
      
      $user_id = $request->user_id;
      $video_id = $request->video_id;

      if (!empty($video_id)) {
          $count = Favorite::where('user_id', $user_id)->where('video_id', $video_id)->count();

          if ($count > 0) {
              Favorite::where('user_id', $user_id)->where('video_id', $video_id)->delete();

              $response = [
                  'status' => 'false',
                  'message' => 'Removed From Your Favorite'
              ];
          } else {
              $data = ['user_id' => $user_id, 'video_id' => $video_id];
              Favorite::insert($data);

              $response = [
                    'status' => 'true',
                    'message' => 'Added to Your Favorite'
                ];
            }
      }
    } catch (\Throwable $th) {
        $response = [
          'status' => 'false',
          'message' => $th->getMessage(),
        ];
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
          'message'=>'Removed From Your Wishlist'
        );
      } else {
        $data = array('user_id' => $user_id, 'audio_id' => $audio_id );
        Wishlist::insert($data);
        $response = array(
          'status'=>'true',
          'message'=>'Added to Your Wishlist'
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
          'message'=>'Removed From Your Favorite'
        );
      } else {
        $data = array('user_id' => $user_id, 'audio_id' => $audio_id );
        Favorite::insert($data);
        $response = array(
          'status'=>'true',
          'message'=>'Added  to  Your Favorite'
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
          'message'=>'Removed From Your Watch Later'
        );
      } else {
        $data = array('user_id' => $user_id, 'video_id' => $video_id );
        Watchlater::insert($data);
        $response = array(
          'status'=>'true',
          'message'=>'Added to Your Watch Later'
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
          'message'=>'Removed From Your Watch Later'
        );
      } else {
        $data = array('user_id' => $user_id, 'audio_id' => $audio_id );
        Watchlater::insert($data);
        $response = array(
          'status'=>'true',
          'message'=>'Added  to  Your Watch Later'
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
      $channel_videos = Video::whereIn('id', $k2)->orderBy('created_at', 'desc')->get()->map(function ($item) {
        $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
        $item['video_url'] = URL::to('/').'/storage/app/public/';
        return $item;
      });
      if(count($channel_videos) > 0){
        $status = "true";
      }else{
        $status = "false";
      }
    }else{
            $status = "false";
      $channel_videos = [];
    }

    // Episode

    $episode_id = Wishlist::where('user_id','=',$user_id)->whereNotNull('episode_id')->pluck('episode_id');

    if(count($episode_id) > 0 ){

        $episode = Episode::whereIn('id',$episode_id)->orderBy('episode_order')->get()->map(function ($item) {
          $item['image'] = URL::to('/').'/public/uploads/images/'.$item->image;
          $item['series_name'] = Series::where('id',$item->series_id)->pluck('title')->first();
          $item['source'] = 'episode';
          return $item;
        });

    }else{
      $episode = [];
    }

    // Audios

    $audio_id = Wishlist::where('user_id','=',$user_id)->whereNotNull('audio_id')->pluck('audio_id');

    if(count($audio_id) > 0 ){

        $audios = Audio::whereIn('id',$audio_id)->get()->map(function ($item) {
          $item['image'] = URL::to('/').'/public/uploads/images/'.$item->image;
          $item['source'] = 'audio';
          return $item;
        });

    }else{
      $audios = [];
    }

    $response = array(
        'status'=>$status,
        'channel_videos' => $channel_videos,
        'episode_videos' => $episode,
        'audios' => $audios
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
      $channel_videos = Video::whereIn('id', $k2)->orderBy('created_at', 'desc')->get()->map(function ($item) {
        $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
        $item['video_url'] = URL::to('/').'/storage/app/public/';
        $item['source'] = 'videos';
        return $item;
      });

      if(count($channel_videos) > 0){
        $status = "true";
      }else{
        $status = "false";
      }
    }else{
            $status = "false";
      $channel_videos = [];
    }

    // Episode

    $episode_id = Favorite::where('user_id','=',$user_id)->whereNotNull('episode_id')->pluck('episode_id');

    if(count($episode_id) > 0 ){

        $episode = Episode::whereIn('id',$episode_id)->orderBy('episode_order')->get()->map(function ($item) {
          $item['image'] = URL::to('/').'/public/uploads/images/'.$item->image;
          $item['series_name'] = Series::where('id',$item->series_id)->pluck('title')->first();
          $item['source'] = 'episode';
          return $item;
        });

    }else{
      $episode = [];
    }

    // Audios

    $audio_id = Favorite::where('user_id','=',$user_id)->whereNotNull('audio_id')->pluck('audio_id');

    if(count($audio_id) > 0 ){

        $audios = Audio::whereIn('id',$audio_id)->get()->map(function ($item) {
          $item['image'] = URL::to('/').'/public/uploads/images/'.$item->image;
          $item['source'] = 'audio';
          return $item;
        });

    }else{
      $audios = [];
    }

    $response = array(
        'status'=>$status,
        'channel_videos'  => $channel_videos,
        'episode_videos'  => $episode,
        'audios'          => $audios,
      );
    return response()->json($response, 200);

  }

  public function mywatchlaters(Request $request) {

    $user_id = $request->user_id;

    /* videos*/
    $video_ids = Watchlater::select('video_id')->where('user_id','=',$user_id)->get();
    $video_ids_count = Watchlater::select('video_id')->where('user_id','=',$user_id)->count();

    if ( $video_ids_count  > 0) {

      foreach ($video_ids as $key => $value1) {
        $k2[] = $value1->video_id;
      }
      $channel_videos = Video::whereIn('id', $k2)->orderBy('created_at', 'desc')->get()->map(function ($item) {
        $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
        $item['video_url'] = URL::to('/').'/storage/app/public/';
        $item['source'] = 'videos';
        return $item;
      });
      if(count($channel_videos) > 0){
        $status = "true";
      }else{
        $status = "false";
      }
    }else{
             $status = "false";
              $channel_videos = [];
    }

    // live videos

    $live_videos_id = Watchlater::where('user_id','=',$user_id)->whereNotNull('live_id')->pluck('live_id');

    if(count($live_videos_id) > 0){

        $livestream_videos = LiveStream::whereIn('id',$live_videos_id)->orderBy('created_at', 'desc')->get()->map(function ($item) {
            $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
            $item['player_image'] = URL::to('/').'/public/uploads/images/'.$item->player_image;
            $item['live_description'] = $item->description ? $item->description : "" ;
            $item['source'] = 'live_stream';
            return $item;
        });

    }else{
      $livestream_videos = [];
    }

    // Episode

    $episode_id = Watchlater::where('user_id','=',$user_id)->whereNotNull('episode_id')->pluck('episode_id');


    if(count($episode_id) > 0 ){

        $episode = Episode::whereIn('id',$episode_id)->orderBy('episode_order')->get()->map(function ($item) {
          $item['image'] = URL::to('/').'/public/uploads/images/'.$item->image;
          $item['series_name'] = Series::where('id',$item->series_id)->pluck('title')->first();
          $item['source'] = 'episode';
          return $item;
        });

    }else{
      $episode = [];
    }

    $audio_id = Watchlater::where('user_id','=',$user_id)->whereNotNull('audio_id')->pluck('audio_id');

    if(count($audio_id) > 0 ){

        $audios = Audio::whereIn('id',$audio_id)->get()->map(function ($item) {
          $item['image'] = URL::to('/').'/public/uploads/images/'.$item->image;
          $item['source'] = 'audio';
          return $item;
        });

    }else{
      $audios = [];
    }

    $response = array(
        'status'         => $status,
        'channel_videos' => $channel_videos,
        'livestream_videos'=> $livestream_videos,
        'episode' => $episode,
        'audios'  => $audios,
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

    $payperview_video = PpvPurchase::join('videos', 'videos.id', '=', 'ppv_purchases.video_id')
    ->where('ppv_purchases.user_id', '=', $user_id)->where('ppv_purchases.video_id', '!=', 0)
    ->orderBy('ppv_purchases.created_at', 'desc')->get()->map(function ($item) {
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

    $payperview_video = LivePurchase::join('live_streams', 'live_streams.id', '=', 'live_purchases.video_id')
    ->where('live_purchases.user_id', '=', $user_id)->where('live_purchases.video_id', '!=', 0)
    ->orderBy('live_purchases.created_at', 'desc')->get()->map(function ($item) {
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

              try {
                \Mail::send('emails.changeplansubscriptionmail', array(
                  'name' => $user->username,
                  'plan' => ucfirst($plandetail->plans_name),
                    ), function($message) use ($request,$user){
                  $message->from(AdminMail(),GetWebsiteName());
                  $message->to($user->email, $user->username)->subject('Subscription Plan Changed');
                });
              } catch (\Throwable $th) {
                //throw $th;
              }

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

    try {
      \Mail::send('emails.cancel', array(
        'name' => $user->username,
        'plan_name' => $plan_name,
        'start_date' => $start_date,
        'ends_at' => $ends_at,
      ), function($message) use ($user){
        $message->from(AdminMail(),GetWebsiteName());
        $message->to($user->email, $user->username)->subject('Subscription Renewal');
      });
    } catch (\Throwable $th) {
      //throw $th;
    }


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

            try {
                  \Mail::send('emails.renewsubscriptionemail', array(
                    'name' => $user->username,
                    'plan' => ucfirst($plandetail->plans_name),
                  // 'price' => $plandetail->price,
                ), function($message) use ($user){
                    $message->from(AdminMail(),GetWebsiteName());
                    $message->to($user->email, $user->username)->subject('Subscription Renewal');
                });
            } catch (\Throwable $th) {
              //throw $th;
            }

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
        send_password_notification('Notification From '. GetWebsiteName(),'You have rented a video','You have rented a video','',$user_id);
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

      $Splash_Screen_first = MobileApp::pluck('andriod_splash_image')->first();

      $first_Splash_Screen[] =[
        'Splash_Screen'=> $Splash_Screen_first,
        'splash_url'  => URL::to('/').'/public/uploads/settings/'.$Splash_Screen_first,
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

      if($user_id == 1){

          $user_details = User::where('id', '=', $user_id)->orderBy('created_at', 'desc')->get()->map(function ($item) {
                $item['profile_url'] = URL::to('/').'/public/uploads/avatars/'.$item->avatar;
                return $item;
          });
          
          $response = array(
              'status'=>'true',
              'message'=>'success',
              'curren_stripe_plan'=> '',
              'user_details' => $user_details,
              'next_billing' => '',
              'ends_at' => '',
          );

      }else{

            $stripe_plan = SubscriptionPlan();

            $user_details = User::where('id', '=', $user_id)->orderBy('created_at', 'desc')->get()->map(function ($item) {
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
          }
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

      $plans = SubscriptionPlan::where("payment_type","=","recurring")->groupby('plans_name')->orderBy('id', 'asc')->get()->map(function ($item) {
        return $item;
      });
      
      $response = array(
        'status'=>'true',
        'Currency_Symbol'=> CurrencySetting::pluck('symbol')->first() ,
        'plans' => $plans ,
        'Currency_Setting' => CurrencySetting::all() ,
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
      // $categoryVideos = Video::where('id',$videoid)->first();
      //   $category_id = Video::where('id',$videoid)->pluck('video_category_id');
      //   $recomended = Video::where('video_category_id','=',$category_id)->where('id','!=',$videoid)
      //   ->orderBy('created_at', 'desc')->where('status','=',1)->where('active','=',1)->get()->map(function ($item) {
      //   $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
      //   return $item;
      // });
    $myData = array();

      $category_id = CategoryVideo::where('video_id', $videoid)->get();
        // Recomendeds
        foreach ($category_id as $key => $value)
        {
            $recomendeds = Video::select('videos.*', 'video_categories.name as categories_name', 'categoryvideos.category_id as categories_id')
                ->Join('categoryvideos', 'videos.id', '=', 'categoryvideos.video_id')
                ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
                ->where('videos.id', '!=', $videoid)
                ->where('categoryvideos.category_id', '=', $value->category_id)
                ->limit(10)
                ->get()->map(function ($item) {
                    $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
                    return $item;
                  });
                  $myData[] = array(
                    "recomendeds" => $recomendeds
                  );
        }

        $response = array(
        'status'=>'true',
        'channelrecomended' => $myData
      );
      return response()->json($response, 200);
    }

    public function relatedppvvideos(Request $request) {
      $ppvvideoid = $request->ppvvideoid;
      $recomended = PpvVideo::where('id','!=',$ppvvideoid)->where('status',1)->where('active','=',1)->orderBy('created_at', 'desc')->get()->map(function ($item) {
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
      $audio_artist_id =  $request['audio_artist_id'];

      $artistlist_count = Artist::get()->count();
      if($artistlist_count > 0){
      $artist_categories = Artist::orderBy('created_at', 'desc')->get()->map(function ($item) {
        $item['image_url'] = URL::to('/').'/public/uploads/artists/'.$item->image;
        return $item;
    });

  }else{
    $artist_categories = 'false';
  }

      $audio_artist_count = Artist::where('id',$audio_artist_id)->count();
      if($audio_artist_count > 0){
      $Audioartist = Audioartist::select('audio_id','artist_id')->where('artist_id',$audio_artist_id)->get()->toArray();
      if(count($Audioartist) > 0){
        $audio_artist = Artist::where('id',$audio_artist_id)->orderBy('created_at', 'desc')
        ->get()->map(function ($item) {
          $item['image_url'] = URL::to('/').'/public/uploads/artists/'.$item->image;
          return $item;
        });


      foreach ($Audioartist as $key => $Audio_artist) {
        $audioartist_idid = $Audio_artist['artist_id'];

        $audio = Audio::where('title', 'LIKE', '%'.$search_value.'%')
        ->orderBy('audio.created_at', 'desc')
        ->get()->map(function ($item) {
          $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
          return $item;
        });

        if(count($audio) > 0){
          $msg = 'success';
        }else{
          $msg = 'nodata';
        }
        $Audio_artist_detail= array(
          "message" => $msg,
          "audio" => $audio,
          "audio_artist" => $audio_artist,
        );
      }
    }else{
      $Audio_artist_detail= array(
        "message" => 'No Audio',
        "audio" => '',
        "audio_artist" => '',
      );
    }
      }else{
        $Audio_artist_detail= array(
          "message" => 'No Artist',
          "audio" => '',
        "audio_artist" => '',
        );
      }
      // print_r();exit;

      $videos_count = Video::where('title', 'LIKE', '%'.$search_value.'%')->count();
      $ppv_videos_count = PpvVideo::where('title', 'LIKE', '%'.$search_value.'%')->count();
      $video_category_count = VideoCategory::where('name', 'LIKE', '%'.$search_value.'%')->count();
      $ppv_category_count = PpvCategory::where('name', 'LIKE', '%'.$search_value.'%')->count();
      $albums_count = AudioAlbums::where('albumname', 'LIKE', '%'.$search_value.'%')->count();
      $audio_categories_count = AudioCategory::where('name', 'LIKE', '%'.$search_value.'%')->count();
      $audios_count = Audio::where('title', 'LIKE', '%'.$search_value.'%')->count();
      $artist_count = Artist::where('artist_name', 'LIKE', '%'.$search_value.'%')->count();
      $series_count = Series::where('title', 'LIKE', '%'.$search_value.'%')->count();
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

      if ($series_count > 0) {
        $series = Series::where('title', 'LIKE', '%'.$search_value.'%')->where('active','=',1)->orderBy('created_at', 'desc')->get()->map(function ($item) {
        $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
        return $item;
      });

      } else {
        $series = [];
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
        'artist_categories' => $artist_categories,
        'Audio_artist_detail' => $Audio_artist_detail,
        'series' => $series,
      );

      return response()->json($response, 200);
    }

    public function search_andriod(Request $request)
    {

      try {

          $search_value = $request->search_value;

          $videos = Video::Select('videos.id', 'videos.title', 'videos.slug', 'videos.year', 'videos.rating', 'videos.access', 'videos.publish_type', 'videos.global_ppv', 'videos.publish_time', 'videos.ppv_price', 'videos.duration', 'videos.rating', 'videos.image', 'videos.featured', 'videos.age_restrict','categoryvideos.category_id','categoryvideos.video_id','video_categories.name as category_name')
            ->Join('categoryvideos','categoryvideos.video_id','=','videos.id')
            ->Join('video_categories','video_categories.id','=','categoryvideos.category_id')
            ->orwhere('videos.search_tags', 'LIKE', '%' . $search_value . '%')
            ->orwhere('videos.title', 'LIKE', '%' . $search_value . '%')
            ->orwhere('video_categories.name', 'LIKE', '%' . $search_value . '%')
            ->where('active', '=', '1')
            ->where('status', '=', '1')
            ->where('draft', '=', '1')
            ->latest('videos.created_at')
            ->groupBy('videos.id')
            ->limit('10');

            if(Geofencing() !=null && Geofencing()->geofencing == 'ON'){
                $videos = $videos  ->whereNotIn('videos.id',Block_videos());
            }

            $videos = $videos->get()->map(function ($item) {
              $item['image_url'] = URL::to('public/uploads/images/'.$item->image); ;
              $item['source']    = "videos";
              return $item;
            });
          

          $livestreams = LiveStream::select('live_streams.id','live_streams.title','live_streams.slug','live_streams.year','live_streams.rating','live_streams.access','live_streams.ppv_price','live_streams.publish_type','live_streams.publish_status','live_streams.publish_time','live_streams.duration','live_streams.rating','live_streams.image','live_streams.featured','livecategories.live_id','live_categories.name')
                                ->Join('livecategories','livecategories.live_id','=','live_streams.id')
                                ->Join('live_categories','live_categories.id','=','livecategories.category_id')
                                ->orwhere('live_streams.search_tags', 'LIKE', '%' . $search_value . '%')
                                ->orwhere('live_streams.title', 'LIKE', '%' . $search_value . '%')
                                ->orwhere('live_categories.name', 'LIKE', '%' . $search_value . '%')           
                                ->where('live_streams.active', '=', '1')
                                // ->where('status', '=', '1')
                                ->limit('10')
                                ->groupBy('live_streams.id')
                                ->get()->map(function ($item) {
                                  $item['image_url'] = URL::to('public/uploads/images/'.$item->image);
                                  $item['source'] = "Livestream";
                                  return $item;
                                });

          $audio = Audio::select('id','title','slug','year','rating','access','ppv_price','duration','rating','image','featured')
                                ->orwhere('search_tags', 'LIKE', '%' . $search_value . '%')
                                ->orwhere('audio.title', 'LIKE', '%' .$search_value . '%')
                                ->where('active', '=', '1')
                                ->where('status', '=', '1')
                                ->limit('10')
                                ->get()->map(function ($item) {
                                  $item['image_url'] = URL::to('public/uploads/audios/'.$item->image);
                                  $item['source']    = "Audios";
                                  return $item;
                                });
                               

          $episodes = Episode::Select('episodes.id','episodes.title','episodes.slug','episodes.rating','episodes.access','episodes.ppv_price','episodes.duration','episodes.rating','episodes.image','episodes.featured','series.id','series_categories.category_id','video_categories.name as Category_name')
                                ->Join('series','series.id','=','episodes.series_id')
                                ->Join('series_categories','series_categories.series_id','=','series.id')
                                ->Join('video_categories','video_categories.id','=','series_categories.category_id')
                                ->orwhere('episodes.search_tags', 'LIKE', '%' . $search_value . '%')
                                ->orwhere('episodes.title', 'LIKE', '%' . $search_value . '%')
                                ->orwhere('video_categories.name', 'LIKE', '%' . $search_value . '%')           
                                ->where('episodes.active', '=', '1')
                                ->where('episodes.status', '=', '1')
                                ->groupBy('episodes.id')
                                ->limit('10')
                                ->get()->map(function ($item) {
                                  $item['image_url'] = URL::to('/public/uploads/image/'.$item->image);
                                  $item['season_count'] = SeriesSeason::where('series_id',$item->id)->count();
                                  $item['episode_count'] = Episode::where('series_id',$item->id)->count();
                                  $item['source']    = "Episode";
                                  return $item;
                                }); 


          $series = Series::Select('series.id','series.title','series.slug','series.access','series.active','series.ppv_status','series.featured','series.duration','series.image','series.embed_code','series.mp4_url','series.webm_url','series.ogg_url','series.url','series_categories.category_id','video_categories.name as Category_name')
                                ->Join('series_categories','series_categories.series_id','=','series.id')
                                ->Join('video_categories','video_categories.id','=','series_categories.category_id')
                                ->orwhere('series.search_tag', 'LIKE', '%' . $search_value . '%')
                                ->orwhere('series.title', 'LIKE', '%' . $search_value . '%')
                                ->orwhere('video_categories.name', 'LIKE', '%' . $search_value . '%')           
                                ->where('series.active', '=', '1')
                                ->groupBy('series.id')
                                ->limit('10')
                                ->get()->map(function ($item) {
                                  $item['image_url'] = URL::to('/public/uploads/images/'.$item->image);
                                  $item['season_count'] = SeriesSeason::where('series_id',$item->id)->count();
                                  $item['episode_count'] = Episode::where('series_id',$item->id)->count();
                                  $item['source']    = "Series";
                                  return $item;
                                });   

          $mergedData = $videos->concat($livestreams)->concat($audio)->concat($episodes)->concat($series);

          return response()->json([
            'status'  => 'true',
            'Message' => 'Search Videos,Livestreams,audio,episodes,series Retrieved Successfully',
            'data'    => $mergedData,
          ], 200);

      } catch (\Throwable $th) {
          return response()->json([
            'status'  => 'false',
            'Message' => $th->getMessage(),
        ], 200);
      }
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

        $user = User::find($user_id);
        $user->role = 'subscriber';
        $user->active = 1;
        $user->save();

        $users = User::find($user_id);
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
        }
        else{
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
      // $check_exists = User::where('email', '=', $email)->where('user_type', '=', $login_type)->count();
      $check_exists = User::where('email', '=', $email)->count();
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
          'active'   => 1 ,
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
      // $check_exists = User::where('email', '=', $email)->where('user_type', '=', $login_type)->count();
      $check_exists = User::where('email', '=', $email)->count();
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
          'active'   => 1 ,
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
      $series = Series::where('active', '=', '1')->orderBy('created_at', 'desc')->get()->map(function ($item) {
        $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
        $item['mp4_url'] = URL::to('/').'/storage/app/public/'.$item->mp4_url;
        return $item;
      });

      $settings = Setting::first();
      $response = array(
        'series' => $series,
        // "settings"   => $settings,

        );
      return response()->json($response, 200);
    }

    public function PurchaseSeries(Request $request)
    {
      $seriesid = $request->seriesid;
      $user_id = $request->user_id;

      $series = Series::where('id', '=', $seriesid)->where('active', '=', '1')->orderBy('created_at', 'desc')->get()->map(function ($item) {
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

          }elseif(!empty($series) && $series[0]->ppv_status == 0 ) {
            $ppv_video_status = "can_view";
          }
          else {
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
      $season = SeriesSeason::where('series_id','=',$seriesid)->orderBy('created_at', 'desc')->get();
      $seasonfirst = SeriesSeason::where('series_id','=',$seriesid)->first();
      $first_season_id = $seasonfirst =! " " ? $seasonfirst->id : null;

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

      $episodes = Episode::where('season_id','=',$season_id)->orderBy('created_at', 'desc')->get()->map(function ($item) {
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

      $episode = Episode::where('id',$episodeid)->orderBy('episode_order')->get()->map(function ($item) {
         $item['image'] = URL::to('/').'/public/uploads/images/'.$item->image;
         $item['series_name'] = Series::where('id',$item->series_id)->pluck('title')->first();
         return $item;
       });
       if(count($episode) > 0){
       $series_id =  $episode[0]->series_id;
       $season_id = $episode[0]->season_id;

       $Season = SeriesSeason::where('series_id',$series_id)->where('id',$season_id)->first();

       $AllSeason = SeriesSeason::where('series_id',$series_id)->get();
                if(count($AllSeason) > 0){


                    foreach($AllSeason as $key => $Season){

                        if($season_id ==  $Season->id){

                          $name = $key+1;
                          $Season_Name = 'Season '. $name;
                        }
                    }

                  }else{
                    $Season_Name = '';

                  }

       }else{
        $Season = '';
       }
      //  print_r($Season->id);exit;


      $languages = SeriesLanguage::Join('languages','languages.id','=','series_languages.series_id')
      ->where('series_languages.series_id',$series_id)->get('name');
      // echo "<pre>"; print_r($languages);exit;

      foreach($languages as $value){
        $language[] = $value['name'];
      }
      if(!empty($language)){
      $languages = implode(",",$language);
      }else{
        $languages = "";
      }


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
    // ->where('season_id',$episode[0]->season_id)
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
        'shareurl' => URL::to('episode').'/'.$episode[0]->series_name.'/'.$episode[0]->slug,
        'episode' => $episode,
        'Season_Name' => $Season_Name,
        'season' => $Season,
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
      $episode = Episode::where('id','!=',$episodeid)->where('season_id','=',$season_id)->orderBy('created_at', 'desc')->get()->map(function ($item) {
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

      $casts = Cast::orderBy('created_at', 'desc')->get()->map(function ($item) {
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
         ->where('user_id',$request->user_id)->orderBy('created_at', 'desc')->get()->map(function ($item) {
            $i = 0;
            while ($i<= $item->count()) {
              $user =  User::where("id","=",$item->user_id)->orderBy('created_at', 'desc')->get()->first();
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
  ->orderBy('audio.created_at', 'desc')
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
    ->orderBy('audio.created_at', 'desc')
    ->count();

if($similarAudio > 0){
$similar_Audio =  Audio::join('category_audios', 'audio.id', '=', 'category_audios.audio_id')
->select('audio.*')
->where('category_id','!=', $album_id)
->orderBy('audio.created_at', 'desc')
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
      $episodes= Episode::where('season_id',$seasonid)->where('active','=',1)->orderBy('episode_order')->get()->map(function ($item)  {
        $item['image'] = URL::to('/').'/public/uploads/images/'.$item->image;
        $item['episode_id'] =$item->id;

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
        // "settings"   => $settings,
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

    $episode = Episode::where('id','=',$episode_id)->first();
    // $season = SeriesSeason::where('series_id','=',$episode->series_id)->with('episodes')->get();
    $season = SeriesSeason::where('series_id','=',$episode->series_id)->where('id','=',$season_id)
    ->with('episodes')->orderBy('created_at', 'desc')->get();
    if(!empty($season)){
      $ppv_price = $season[0]->ppv_price;
      $ppv_interval = $season[0]->ppv_interval;
      $season_id = $season[0]->id;
  }
  // echo "<pre>";
  // print_r($season);exit;
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
        $free_episode = 'guest';
      }else{
        $free_episode = 'PPV';
      }
      if(empty($free_episode)){

        $free_episode = 'PPV';
      }
  }else{
    $free_episode = 'guest';
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
      $video= Video::where('id','=',$next_videoid)->where('status','=','1')->where('active','=','1')->orderBy('created_at', 'desc')->get();
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
      $video= Video::where('id','=',$prev_videoid)->where('status','=','1')->where('active','=','1')->orderBy('created_at', 'desc')->get();
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
      $video= Video::where('id','=',$next_videoid)->where('status','=','1')->where('active','=','1')->orderBy('created_at', 'desc')->get();
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
      $video= Video::where('id','=',$prev_videoid)->where('status','=','1')->where('active','=','1')->orderBy('created_at', 'desc')->get();
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
      $video= Video::where('id','=',$next_videoid)->where('status','=','1')->where('active','=','1')->orderBy('created_at', 'desc')->get();
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

      $next_episodeid = Episode::where('id','>',$episode_id)->where('season_id','=',$seasonid)
      ->where('active','=','1')->where('status','=','1')->orderBy('episode_order')->min('id');
      
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

    $prev_episodeid = Episode::where('episode_order', '<', $episode_id)->where('season_id','=',$seasonid)->where('status','=','1')->where('active','=','1')->pluck('id')->first();

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
      $videos = Video::whereIn('id', $k2)->orderBy('created_at', 'desc')->get()->map(function ($item) use ($user_id) {
        $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
        $item['watch_percentage'] = ContinueWatching::where('videoid','=',$item->id)->where('user_id','=',$user_id)->pluck('watch_percentage')->min();
        $item['skip_time'] = ContinueWatching::where('videoid','=',$item->id)->where('user_id','=',$user_id)->pluck('skip_time')->min();
        return $item;
      });
      $response = array(
        'status' => "true",
        'videos'=> $videos,
      );
    }else{
      $response = array(
        'status' => "false",
        'videos'=> [],
      );
    }


    // $response = array(
    //     'status'=>$status,
    //     'videos'=> $videos
    //   );
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
      $episodes = Episode::whereIn('id', $k2)->orderBy('created_at', 'desc')->get()->map(function ($item) use ($user_id) {
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
        $sub_users = DB::table('sub_users')->where('parent_id', $parent_id)->orderBy('created_at', 'desc')->get();
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
        ->orderBy('audio.created_at', 'desc')
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
        $allaudios = Audio::orderBy('created_at', 'desc')->get()->map(function ($item) {
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
        $audiodetail = Audio::where('id',$audio_id)->orderBy('created_at', 'desc')->get()->map(function ($item) {
            $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
            $item['player_image'] = URL::to('/').'/public/uploads/images/'.$item->player_image;
            $item['audio_duration'] = $item->duration >= "3600" ?  gmdate('H:i:s', $item->duration  ) :  gmdate('i:s', $item->duration  ) ;

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



        $audio_cat_id = Audio::where('id','=',$audio_id)->pluck('audio_category_id')->first();


        $audio_cat = AudioCategory::where('id','=',$audio_cat_id)->get();

        if(count($audio_cat) > 0){
         $main_genre = $audio_cat[0]->name;
        }else{
          $main_genre = '';
        }

        $response = array(
            'status' => $status,
            'wishlist' => $wishliststatus,
            'main_genre' => $main_genre,
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
            $audios= Audio::where('audio_category_id',$audiocategoryid)
            ->where('active','=',1)->orderBy('created_at', 'desc')->get()->map(function ($item) {
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
        $artistlist = Artist::orderBy('created_at', 'desc')->get()->map(function ($item) {
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
        $favoriteslist = Artist::join('artist_favourites', 'artists.id', '=', 'artist_favourites.artist_id')
          ->orderBy('artists.created_at', 'desc')->get()
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
        $followinglist = Artist::join('artist_favourites', 'artists.id', '=', 'artist_favourites.artist_id')
        ->where('artist_favourites.user_id',$user_id)->where('artist_favourites.following',1)
        ->orderBy('artists.created_at', 'desc')->get(['artists.*']);

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
        $artist = Artist::where('id',$artist_id)->orderBy('created_at', 'desc')->get()->map(function ($item) {
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
         $item['player_image'] = URL::to('/').'/public/uploads/images/'.$item->player_image;
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
      $audioalbums_count = AudioAlbums::get()->count();

        if($audioalbums_count > 0){
          $audioalbums = AudioAlbums::orderBy('created_at', 'desc')->get();
          $audioalbums = AudioAlbums::orderBy('created_at', 'desc')->get()->map(function ($item) {
            $item['image_url'] = URL::to('/').'/public/uploads/albums/'.$item->album;
            return $item;
          });
          foreach($audioalbums as $val){
            // $audio[$val->albumname] = Audio::where('album_id',$val->id)->get();
            // $audioalbums= $val->albumname;

            $audio[$val->albumname] = Audio::where('album_id',$val->id)
            ->orderBy('created_at', 'desc')
            ->get()->map(function ($item) {
              $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
              $item['player_image'] = URL::to('/').'/public/uploads/images/'.$item->player_image;
              return $item;
            });

              $response = array(
            'status'=>'true',
            'audioalbums'=>$audioalbums,
            // 'audio'=>$audio,
        );
      }
      }else{
        $response = array(
          'status'=>'false',
          'audioalbums'=> array(),
          'audio'=>array(),
      );
      }
        return response()->json($response, 200);
    }

    public function album_audios(Request $request)
    {

      $album_id = $request->album_id ;
      $audioalbums_count = AudioAlbums::where('id' , $album_id)->orderBy('created_at', 'desc')->get()->count();
      if($audioalbums_count > 0){

        $audioalbums = AudioAlbums::where('id' , $album_id)->first();
        $genre_name = $audioalbums->albumname;
        // print_r($audioalbums->albumname);exit;
          $audio = Audio::where('album_id',$album_id)
          ->orderBy('created_at', 'desc')->get()->map(function ($item) {
            $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
            $item['player_image'] = URL::to('/').'/public/uploads/images/'.$item->player_image;
            return $item;
          });

            $response = array(
          'genre_name'=>$genre_name,
          'status'=>'true',
          // 'audioalbums'=>$audioalbums,
          'audio'=>$audio,
      );
    }else{
      $response = array(
        'status'=>'false',
        'audioalbums'=> 'No Albums Added',
        'audio'=>'No Audio Albums Added',
    );
    }
    return response()->json($response, 200);

    }
    public function AudioCategory(Request $request)
    {
        $audiocategories_count = AudioCategory::orderBy('created_at', 'desc')->get()->count();


        $audiocategories = AudioCategory::select('id','image')->orderBy('created_at', 'desc')->get()->toArray();
        $myData = array();
        foreach ($audiocategories as $key => $audiocategory) {
          $audiocategoryid = $audiocategory['id'];
          $genre_image = $audiocategory['image'];
          // $categoryauido =  Audio::join('category_audios', 'audio.id', '=', 'category_audios.audio_id')

          $audio = Audio::Join('category_audios','category_audios.audio_id','=','audio.id')
          ->where('category_audios.category_id',$audiocategoryid)
          ->orderBy('audio.created_at', 'desc')
          ->get()->map(function ($item) {
            $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
            // $item['auido_url'] = URL::to('/').'/storage/app/public/';
            $item['category_name'] = AudioCategory::where('id',$item->category_id)->pluck('slug')->first();

            return $item;
          });

          $main_genre = CategoryAudio::Join('audio_categories','audio_categories.id','=','category_audios.category_id')
          ->get('name');
          foreach($main_genre as $value){
            $category[] = $value['name'];
          }
          if(!empty($category)){
          $main_genre = implode(",",$category);
          }else{
            $main_genre = "";
          }
          if(count($audio) > 0){
            $msg = 'success';
          }else{
            $msg = 'nodata';
          }
          $myData[] = array(
            "message" => $msg,
            'gener_name' =>  AudioCategory::where('id',$audiocategoryid)->pluck('name')->first(),
            'gener_id' =>  AudioCategory::where('id',$audiocategoryid)->pluck('id')->first(),
            "audio" => $audio
          );
        }


        $response = array(
          'status' => 'true',
          'genre_movies' => $myData,
          // 'main_genre' => $msg,
          // 'main_genre' => $main_genre,

        );
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

        $audioalbum = Audio::where('audio_category_id',$album_id)->where('active','=',1)
        ->orderBy('created_at', 'desc');
        if($getfeching !=null && $getfeching->geofencing == 'ON'){
          $audioalbum =   $audioalbum->whereNotIn('id',$blockaudios);
        }
        $audioalbum = $audioalbum->orderBy('created_at', 'desc')
        ->get()->map(function ($item) {
            $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
            $item['video_url'] = URL::to('/').'/storage/app/public/'.$item->mp4_url;
            return $item;
        });
    $categoryauido =  Audio::join('category_audios', 'audio.id', '=', 'category_audios.audio_id')
    ->select('audio.*')
    ->where('category_id', $album_id)
    ->orderBy('audio.created_at', 'desc')
    ->count();

    if($categoryauido > 0){
    $albumcategoryauido =  Audio::join('category_audios', 'audio.id', '=', 'category_audios.audio_id')
    ->select('audio.*')
    ->where('category_id', $album_id)
    ->orderBy('audio.created_at', 'desc')
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

        if( $next_audio_id != null ){

              $audio= Audio::where('id','=',$next_audio_id)->where('status','=','1')->where('active','=','1')->get()->map(function ($item) {
                $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
                return $item;
              });

        }else{

            $next_audio_id = Audio::where('status','=','1')->where('active','=','1')->pluck('id')->first();

            $audio= Audio::where('id','=',$next_audio_id)->where('status','=','1')->where('active','=','1')->get()->map(function ($item) {
              $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
              return $item;
            });
        }

        $response = array(
          'status' => true,
          'next_audio_id' => $next_audio_id,
          'audio' => $audio
        );
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

          }else{

              $prev_audio_id = Audio::where('status','=','1')->where('active','=','1')->latest()->pluck('id')->first();

              $audio= Audio::where('id','=',$prev_audio_id)->where('status','=','1')->where('active','=','1')->get()->map(function ($item) {
                $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
                return $item;
            });
          }

          $response = array(
            'status' => "true",
            'prev_audio_id' => $prev_audio_id,
            'audio' => $audio
          );

          return response()->json($response, 200);
    }

    public function relatedaudios(Request $request) {
        $audio_id = $request->audio_id;
        $categoryAudios = Audio::where('id',$audio_id)->first();
        $category_id = Audio::where('id',$audio_id)->pluck('audio_category_id');
        $recomended = Audio::where('audio_category_id','=',$category_id)
        ->where('id','!=',$audio_id)->where('status','=',1)->where('active','=',1)->orderBy('created_at', 'desc')->get()->map(function ($item) {
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
        $channel_videos = Audio::whereIn('id', $k2)->orderBy('created_at', 'desc')->get()->map(function ($item) {
          $item['image_url'] = URL::to('/').'/uploads/images/'.$item->image;
          $item['mp3_url'] = $item->mp3_url;
          return $item;
        });
        if(count($channel_videos) > 0){
          $status = "true";
        }else{
          $status = "false";
        }
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
        $channel_videos = Audio::whereIn('id', $k2)->orderBy('created_at', 'desc')->get()->map(function ($item) {
          $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
          $item['mp3_url'] = $item->mp3_url;
          return $item;
        });
        if(count($channel_videos) > 0){
          $status = "true";
        }else{
          $status = "false";
        }
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

      $all_languages = Language::latest('created_at')->get()->map(function ($item) {
        $item['image_url'] = $item->language_image ? URL::to('/').'/public/uploads/Language/'.$item->language_image : null ;
        return $item;
      });

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
          send_password_notification('Notification From'. GetWebsiteName(),'Your Subscription Auto Renewal Before 7 days','',$user->id);
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
            $subscription->ios_product_id = $request->product_id;
            $subscription->save();
            $user =  User::findOrFail($user_id);
            $user->role = "subscriber";
            $user->save();
            $user_email = $user->email;
          $plan_details = SubscriptionPlan::where('plan_id','=',$stripe_plan)->first();
	          $template = EmailTemplate::where('id','=',23)->first();
            $subject = $template->template_type;

            try {
              Mail::send('emails.subscriptionpaymentmail', array(
                'name'=>$name,
                'days' => $days,
                'price' => $price,
                'ends_at' => $date,
                'plan_names' => $plan_details->plans_name,
                'created_at' => $current_date), function($message) use ($request,$user_id,$name,$subject,$user_email) {
                                      $message->from(AdminMail(),GetWebsiteName());
                                        $message->to($user_email, $name)->subject($subject);
                });

                $mail_message = 'Mail send Sucessfully' ;

            } catch (\Throwable $th) {

              $mail_message = 'Mail Not Send!' ;

            }

            $message = "Added  to  Subscription";
            $response = array(
              "status" => "true",
              'message'=> $message,
              'Mail_message' => $mail_message ,
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
    $episode_id_ids = Wishlist::select('episode_id')->where('user_id','=',$user_id)->orderBy('created_at', 'desc')->get();
    $episode_id_ids_count = Wishlist::select('episode_id')->where('user_id','=',$user_id)->count();

    if ( $episode_id_ids_count  > 0) {

      foreach ($episode_id_ids as $key => $value1) {
        $k2[] = $value1->video_id;
      }
      $channel_videos = Episode::whereIn('id', $k2)->orderBy('created_at', 'desc')->get()->map(function ($item) {
        $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
        $item['video_url'] = URL::to('/').'/storage/app/public/';
        return $item;
      });
      if(count($channel_videos) > 0){
        $status = "true";
      }else{
        $status = "false";
      }
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
    $episode_ids = Watchlater::select('episode_id')->where('user_id','=',$user_id)->orderBy('created_at', 'desc')->get();
    $episode_ids_count = Watchlater::select('episode_id')->where('user_id','=',$user_id)->count();

    if ( $episode_ids_count  > 0) {

      foreach ($episode_ids as $key => $value1) {
        $k2[] = $value1->video_id;
      }
      $channel_videos = Episode::whereIn('id', $k2)->orderBy('created_at', 'desc')->get()->map(function ($item) {
        $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
        $item['video_url'] = URL::to('/').'/storage/app/public/';
        return $item;
      });
      if(count($channel_videos) > 0){
        $status = "true";
      }else{
        $status = "false";
      }
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
    $episode_ids = Favorite::select('episode_id')->where('user_id',$user_id)->orderBy('created_at', 'desc')->get();
    $episode_ids_count = Favorite::select('episode_id')->where('user_id',$user_id)->count();

    if ( $episode_ids_count  > 0) {

      foreach ($episode_ids as $key => $value) {
        $k2[] = $value->video_id;
      }
      $channel_videos = Episode::whereIn('id', $k2)->orderBy('created_at', 'desc')->get()->map(function ($item) {
        $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
        $item['video_url'] = URL::to('/').'/storage/app/public/';
        return $item;
      });
      if(count($channel_videos) > 0){
        $status = "true";
      }else{
        $status = "false";
      }
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
          'message'=>'Removed From Your Watch Later'
        );
      } else {
        $data = array('user_id' => $user_id, 'episode_id' => $episode_id );
        Watchlater::insert($data);
        $response = array(
          'status'=>'true',
          'message'=>'Added  to  Your Watch Later'
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
          'message'=>'Removed From Your Wishlist'
        );
      } else {
        $data = array('user_id' => $user_id, 'episode_id' => $episode_id );
        Wishlist::insert($data);
        $response = array(
          'status'=>'true',
          'message'=>'Added  to  Your Wishlist'
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
          'message'=>'Removed From Your Favorite'
        );
      } else {
        $data = array('user_id' => $user_id, 'episode_id' => $episode_id );
        Favorite::insert($data);
        $response = array(
          'status'=>'true',
          'message'=>'Added  to  Your Favorite'
        );

      }
    }

    return response()->json($response, 200);

  }

  public function Multiprofile( Request $request ){

      try {

        $parent_id =  $request->user_id ;

        $subcriber_user= User::where('id', $parent_id)->get()->map(function ($item, $key)  {
          $item['image_url'] = $item['avatar'] != ' ' ? URL::to('public/uploads/avatars/'.$item->avatar) : URL::to('public/multiprofile/multi-user-default-image-'.('1').'.png') ;
          return $item;
        });

        $muti_users= Multiprofile::where('parent_id', $parent_id)->get()->map(function ($item, $key)  {
          $item['image_url'] = $item['Profile_Image'] != 'chooseimage.jpg' ? URL::to('public/multiprofile/'.$item->Profile_Image) : URL::to('public/multiprofile/multi-user-default-image-'.($key+2).'.png') ;
          return $item;
        });

        $response = array(
          'status'  => 'true',
          'message' => 'Multiprofile Retrieved  successfully' ,
          'user'    => $subcriber_user->first(),
          'sub_users'=> $muti_users,
          'multi_users'=> $muti_users
        );

      } catch (\Throwable $th) {

        $data = array(
          'status' => 'false',
          'message' => $th->getMessage() ,
        );

      }

      return response()->json($response, 200);
  }

  public function Multiprofile_create(Request $request){

      try {

        $input = array(
          'parent_id'       => $request->user_id,
          'user_name'       => $request->input('name'),
          'user_type'       => ucwords($request->user_type),   // Kids or  Normal
        );

        if($request->image != ''){

          $files = $request->image;
          $filename =uniqid(). time(). '.' . $files->getClientOriginalExtension();
          Image::make($files)->resize(300, 300)->save(base_path().'/public/multiprofile/'.$filename );
          $input  += ['Profile_Image'   => $filename, ];
        }

        $Multiprofile = Multiprofile::create( $input );

        $data = array(
          'status' => 'true',
          'message' => 'Multiprofile data Saved successfully' ,
          'Multiprofile' => Multiprofile::findOrFail($Multiprofile->id),
        );

      } catch (\Throwable $th) {

        $data = array(
          'status' => 'false',
          'message' => $th->getMessage() ,
        );

      }
        return response()->json($data, 200);

    }

    public function Multiprofile_edit(Request $request)

    {
      try {

        $Multiprofile = Multiprofile::findOrFail($request->sub_user_id);

        $data = array(
          'status' => 'true',
          'message' => 'Multiprofile data Retrived successfully' ,
          'Multiprofile' => $Multiprofile ,
        );

      } catch (\Throwable $th) {

        $data = array(
          'status' => 'false',
          'message' => $th->getMessage() ,
        );

      }
        return response()->json($data, 200);
    }

    public function Multiprofile_update(Request $request){

      try{

        $input = array(
          'parent_id'       => $request->user_id,
          'user_name'       => $request->input('name'),
          'user_type'       => ucwords($request->user_type),   // Kids or  Normal
        );

        if($request->image != ''){

          $files = $request->image;
          $filename =uniqid(). time(). '.' . $files->getClientOriginalExtension();
          Image::make($files)->resize(300, 300)->save(base_path().'/public/multiprofile/'.$filename );
          $input  += ['Profile_Image'   => $filename, ];
        }

        $Multiprofile = Multiprofile::find( $request->sub_user_id )->update( $input );

        $data = array(
          'status' => 'true',
          'message' => 'Multiprofile data updated successfully' ,
          'Multiprofile' => Multiprofile::findOrFail( $request->sub_user_id),
        );

      } catch (\Throwable $th) {

        $data = array(
          'status' => 'false',
          'message' => $th->getMessage() ,
        );
      }

      return response()->json($data, 200);

    }

    public function Multiprofile_delete( Request $request)
    {
      try {
          Multiprofile::find( $request->sub_user_id )->delete();

            $data = array(
              'status' => 'true',
              'message' => 'Multiprofile deleted Successfully'  ,
            );

      } catch (\Throwable $th) {

          $data = array(
            'status' => 'false',
            'message' => $th->getMessage() ,
          );
      }

      return response()->json($data, 200);

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

        $Recommendation = HomeSetting::pluck('Recommendation')->first();


        if( $Recommendation == 1 ){

          $check_Kidmode = 0 ;

          $Mostwatchedvideos = RecentView::select('video_id','videos.*',DB::raw('COUNT(video_id) AS count'))
                ->join('videos', 'videos.id', '=', 'recent_views.video_id');
               
                if(Geofencing() !=null && Geofencing()->geofencing == 'ON')
                {
                  $Mostwatchedvideos = $Mostwatchedvideos->whereNotIn('videos.id',Block_videos());
                }
    
                if( $check_Kidmode == 1 )
                {
                  $Mostwatchedvideos = $Mostwatchedvideos->whereBetween('videos.age_restrict', [ 0, 12 ]);
                }
          $Mostwatchedvideos =$Mostwatchedvideos->groupBy('video_id')
                ->orderByRaw('count DESC' )->limit(20)->get()->map(function ($item) {
                  $item['Thumbnail'] = URL::to('/').'/public/uploads/images/'.$item->image ;
                  $item['Player_thumbnail'] = URL::to('/').'/public/uploads/images/'.$item->player_image ;
                  $item['TV_Thumbnail'] = URL::to('/').'/public/uploads/images/'.$item->video_tv_image ;
                  $item['Video_Title_Thumbnail'] = URL::to('/').'/public/uploads/images/'.$item->video_title_image ;
                  return $item;
            });
        }
        

        $response = array(
          'status'  => 'true',
          'message' => 'Most watched videos  Retrieve successfully',
          'Mostwatchedvideos' => !empty($Mostwatchedvideos) ? $Mostwatchedvideos  : [] ,
        );

        return response()->json($response, 200);
    }

    public function MostwatchedVideosUser(Request $request){

      try {
      
        $Sub_user = '';
        $user_id  = $request->user_id ;
        $Recomended = HomeSetting::first();


        if( $Recomended->Recommendation == 1 ){

          $check_Kidmode = 0 ;

          $mostWatchedUserVideos = RecentView::select('video_id','videos.*',DB::raw('COUNT(video_id) AS count'))
                ->join('videos', 'videos.id', '=', 'recent_views.video_id')
                ->groupBy('video_id');

                if(Geofencing() !=null && Geofencing()->geofencing == 'ON')
                {
                  $mostWatchedUserVideos = $mostWatchedUserVideos->whereNotIn('videos.id',Block_videos());
                }
    
                if( $check_Kidmode == 1 )
                {
                  $mostWatchedUserVideos = $mostWatchedUserVideos->whereBetween('videos.age_restrict', [ 0, 12 ]);
                }

                if($Sub_user != null){
                    $mostWatchedUserVideos = $mostWatchedUserVideos->where('recent_views.sub_user',$Sub_user);
                }else{
                    $mostWatchedUserVideos = $mostWatchedUserVideos->where('recent_views.user_id',$user_id);
                }
                $mostWatchedUserVideos = $mostWatchedUserVideos->orderByRaw('count DESC' )->limit(20)->get();
          }
            return response()->json([
              'status'  => 'true',
              'message' => 'Most watched videos by User data Retrieve successfully',
              'mostWatchedUserVideos' => !empty($mostWatchedUserVideos) ? $mostWatchedUserVideos  : [] ], 200);
      
    } catch (\Throwable $th) {
      
        return response()->json([
          'status'  => 'false',
          'Message' => $th->getMessage(),
      ], 200);
    }
  }


    public function Country_MostwatchedVideos(){

      $Recomended = HomeSetting::first();

      if( $Recomended->Recommendation == 1 ){

        $check_Kidmode = 0 ;

        $data = RecentView::select('video_id','videos.*',DB::raw('COUNT(video_id) AS count'))
                  ->join('videos', 'videos.id', '=', 'recent_views.video_id')->groupBy('video_id')->orderByRaw('count DESC' )
                  ->where('country_name', '=',Country_name());
                  
                  if(Geofencing() !=null && Geofencing()->geofencing == 'ON')
                  {
                    $data = $data->whereNotIn('videos.id',Block_videos());
                  }
      
                  if( $check_Kidmode == 1 )
                  {
                    $data = $data->whereBetween('age_restrict', [ 0, 12 ]);
                  }

                  $data = $data->limit(30)->get()->map(function ($item) {
                      $item['image_url'] = URL::to('public/uploads/images'.$item->image) ;
                  return $item;
        });

      }

      return response()->json([
        'message' => 'Country Most watched videos Retrieve successfully',
        'country_Name' => Country_name(),
        'Mostwatched' => !empty($data) ? $data : [] ], 200);
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
      ->orderBy('created_at', 'desc')
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
      ->orderBy('created_at', 'desc')
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
              $preference_gen = Video::whereIn('video_category_id',$video_genres)->whereNotIn('videos.id',$blockvideos)->orderBy('created_at', 'desc')->get();
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
              $preference_Lan = Video::whereIn('language',$video_language)->whereNotIn('videos.id',$blockvideos)->orderBy('created_at', 'desc')->get();
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
     $Screen =WelcomeScreen::orderBy('created_at', 'desc')->get()->map(function ($item) {
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
    $episode_id = $request->episode_id;

    if (!empty($episode_id)) {
        $count = Favorite::where('user_id', $user_id)->where('episode_id', $episode_id)->count();

        if ($count > 0) {
            Favorite::where('user_id', $user_id)->where('episode_id', $episode_id)->delete();

            $response = [
                'status' => 'false',
                'message' => 'Removed From Your Favorite'
            ];

        } else {
            $data = ['user_id' => $user_id, 'episode_id' => $episode_id];
            Favorite::insert($data);

            $response = [
                'status' => 'true',
                'message' => 'Added to Your Favorite'
            ];
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
          'message'=>'Removed From Your Wishlist'
        );
      } else {
        $data = array('user_id' => $user_id, 'episode_id' => $episodeid );
        Wishlist::insert($data);
        $response = array(
          'status'=>'true',
          'message'=>'Added to Your Wishlist'
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
          'message'=>'Removed From Your Watch Later'
        );
      } else {
        $data = array('user_id' => $user_id, 'Episode_id' => $Episode_id );
        Watchlater::insert($data);
        $response = array(
          'status'=>'true',
          'message'=>'Added  to  Your Watch Later'
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
    ->orderBy('created_at', 'desc')
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

   public function profileimage_default()
{
    $image_default = URL::to('/public/uploads/avatars/defaultprofile.png');

    return response()->json([
      'status'  => 'true',
      'Message' =>  $image_default], 200);
   }

  public function homesetting()
  {
      // $homesetting = HomeSetting::first();
      $homesetting = MobileHomeSetting::first();

      return $homesetting;
  }

  public function PPVVideodetails(Request $request){

    $ppv_videos = PpvPurchase::Join('videos','videos.id','=','ppv_purchases.video_id')
                  ->where('ppv_purchases.user_id',$request->user_id)->orderBy('ppv_purchases.created_at', 'desc')->get()->map(function ($item) {
                        $item['video_image'] = URL::to('/').'/public/uploads/images/'.$item->image;
                        $item['videoExpired_date'] = Carbon::parse($item->to_time)->format('d-m-Y');
                        $item['videoExpired_time'] = Carbon::parse($item->to_time)->format('g:i:s A');
                        $video_exp = Carbon::now()->diffForHumans($item->to_time);
                        $Exp = Str::contains($video_exp, 'after');
                        if($Exp != 'true'){
                          $videoExpired= Carbon::now()->diffForHumans($item->to_time);
                          $item['videoExpired'] = "Expires in " . str_replace('before', '',  $videoExpired);
                        }
                        else{
                          $item['videoExpired'] = 'Expired';
                        }
                      return $item;
                  });


      return response()->json([
        'status'  => 'true',
        'PPVvideo' =>  $ppv_videos], 200);
    }


    public function PPVVideocount(Request $request){

      $videoid =  $request->videoid;
      $userid = $request->userid;
      $purchase =  PpvPurchase::where('video_id',$videoid)->where('user_id',$userid)->first();
      if($purchase->view_count == null || $purchase->view_count < 0){
          // print_r('1');exit;
          $purchase->view_count = 1;
           $purchase->save();
          $response = array(
            'status'=>'false',
            'video'=> 'Added',
        );
      }elseif($purchase->view_count > 0){
          $response = array(
            'status'=>'false',
            'video'=> 'exit already',
        );
      }else{
          $response = array(
            'status'=>'false',
            'video'=> 'exit already',
        );
      }

        return response()->json([
          'status'  => 'true',
          'response' =>  $response], 200);
        return response()->json($response, 200);

      }


      public function PPVVideorent(Request $request){

        $current_date = date('Y-m-d h:i:s a', time());

        $videoid =  $request->videoid;
        $userid = $request->userid;
        $ppvexist = PpvPurchase::where('video_id',$videoid)
        ->orderBy('created_at', 'DESC')
        ->where('user_id',$userid)
        ->count();
        $ppv_video = PpvPurchase::where('video_id',$videoid)
        ->orderBy('created_at', 'DESC')
        ->where('user_id',$userid)
        ->first();
        if($ppvexist > 0 && $ppv_video->view_count > 0 && $ppv_video->view_count != null){
          $ppv_exist = PpvPurchase::where('video_id',$videoid)
          ->where('user_id',$userid)
          ->where('status','active')
          ->where('to_time','>',$current_date)
          ->count();

                if($ppv_exist > 0){
                  $ppv_data = PpvPurchase::where('video_id',$videoid)
                  ->where('user_id',$userid)
                    ->orderBy('created_at', 'DESC')
                  ->first();
                $to_time = $ppv_data->to_time;

                $stop_date = date('Y-m-d', strtotime($to_time));
                $currentdate = date('Y-m-d');
                $days = (strtotime($stop_date) - strtotime($currentdate)) / (60 * 60 * 24);
                if(!empty($days)){
                $remaining_count =  $days.' '.'days remaining';
                }else{
                  $remaining_count = '';
                }
                $response = array(
                  'status'=> true,
                  'ppv_exist_status'=> $ppv_data,
                  'days'=> $days,
                  'remaining_count'=> $remaining_count,
                  'can_view'=> 'can_view',

              );
              }else{
                $response = array(
                  'status'=> true,
                  'ppv_exist_status'=> $ppv_exist,
                  'days'=> $days,
                  'can_view'=> 'can_view',

              );
              }
        }elseif($ppvexist > 0 && $ppv_video->view_count == null){
          $ppv_exist = PpvPurchase::where('video_id',$videoid)
          ->where('user_id',$userid)
            // ->where('status','active')
            // ->where('to_time','>',$current_date)
            ->orderBy('created_at', 'DESC')
          ->first();
          $createdat = $ppv_exist->created_at;
          $date1 = date('Y-m-d',strtotime($createdat));
          $to_time = $ppv_exist->to_time;
          $stop_date = date('Y-m-d', strtotime($date1. ' + 7 day'));
          $currentdate = date('Y-m-d');
          $days = (strtotime($stop_date) - strtotime($currentdate)) / (60 * 60 * 24);
          if(!empty($days)){
            $remaining_count =  $days.' '.'days remaining';
            }else{
              $remaining_count = '';
            }
            $response = array(
            'status'=> true,
            'ppv_exist_status'=> $ppv_exist,
            'days'=> $days,
            'remaining_count'=> $remaining_count,
            'can_view'=> 'can_view',
        );
        }
        else{
          $ppv_exist = 0;
          $response = array(
            'status'=>'false',
            'ppv_exist_status'=> 'Pay Now',
            'pay_now'=> 'pay_now',

        );
        }

         return response()->json($response, 200);

        }


        public function HomepageOrder(Request $request){
          // HomepageOrder

        $homepage_order = OrderHomeSetting::select('id','header_name')->get()->toArray();
        $mobile_homepage = MobileHomeSetting::first();
        $homesetting = HomeSetting::first();
        // dd($homesetting );
        $response = array(
          'status'  => 'true',
          'homesetting'=> $homesetting,
          'mobile_homepage' =>  $mobile_homepage,
          'homepage_order' =>  $homepage_order,
      );
      return $response;


          }

          public function audioscategory(Request $request){

            $audiocategoryid =  $request->audiocategoryid;
            $userid = $request->userid;

    $audiocategories = AudioCategory::select('id','image')->where('id','=',$audiocategoryid)->get()->toArray();
    $myData = array();

    $audio_category= Audio::Join('category_audios','category_audios.audio_id','=','audio.id')
    ->where('category_audios.category_id',$audiocategoryid)
    // ->where('active','=',1)->where('status','=',1)
    ->orderBy('audio.created_at', 'desc')->get()->map(function ($item) {
      $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
      return $item;
    });

    foreach ($audiocategories as $key => $audiocategory) {
      $audiocategoryid = $audiocategory['id'];
      $genre_image = $audiocategory['image'];
      $audio = Audio::Join('category_audios','category_audios.audio_id','=','audio.id')
      ->where('category_audios.category_id',$audiocategoryid)
      // ->where('active','=',1)->where('status','=',1)
      ->orderBy('audio.created_at', 'desc')->get()->map(function ($item) {
        $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
        return $item;
      });
      $categorydetails = AudioCategory::where('id','=',$audiocategoryid)->first();

      if(count($audio_category) > 0){
        $msg = 'success';
        $status = 'True';
      }else{
        $msg = 'nodata';
        $status = 'False';
      }
      if(count($audio) > 0){
        $msg = 'success';
        $status = 'True';
      }else{
        $msg = 'nodata';
        $status = 'False';
      }
      $myData[] = array(
        "genre_name"   => $categorydetails->name,
        "genre_id"   => $audiocategoryid,
        "genre_image"   => URL::to('/').'/public/uploads/audios/'.$genre_image,
        "message" => $msg,
        "audio" => $audio,
        "audio_category"   => $audio_category,
      );

    }

    $AudioCategory = AudioCategory::where('id','=',$audiocategoryid)->first();

    $response = array(
      'status' => $status ,
      'main_genre' => $AudioCategory->name,
      'categoryaudio' => $audio
    );
    return response()->json($response, 200);

            }


        public function LiveCategorylist(Request $request)
        {
          $LiveCategory_count = LiveCategory::get()->count();

            if($LiveCategory_count > 0){
              $LiveCategory = LiveCategory::all();
              $LiveCategory = LiveCategory::get()->map(function ($item) {
                $item['image_url'] = URL::to('/').'/public/uploads/livecategory/'.$item->image;
                return $item;
              });
              foreach($LiveCategory as $val){

                $livestream[$val->name] = LiveStream::Join('livecategories','livecategories.live_id','=','live_streams.id')
                ->where('livecategories.category_id',$val->id)
                // ->where('active','=',1)->where('status','=',1)
                ->orderBy('live_streams.created_at', 'desc')->get()->map(function ($item) {
                  $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
                  $item['player_image'] = URL::to('/').'/public/uploads/images/'.$item->player_image;
                  return $item;
                });

                  $response = array(
                'status'=>'true',
                'LiveCategory'=>$LiveCategory,
                'livestream'=>$livestream,
            );
          }
          }else{
            $response = array(
              'status'=>'false',
              'LiveCategory'=> 'No Live Category Added',
              'livestream'=>'No Live Stream Added',
          );
          }
            return response()->json($response, 200);
        }

  public function livecategory(Request $request){

      $live_category_id =  $request->live_category_id;
      $userid = $request->userid;

      $livecategories = LiveCategory::select('id','image')->where('id','=',$live_category_id)->get()->toArray();
      $myData = array();

      $live_category= LiveStream::Join('livecategories','livecategories.live_id','=','live_streams.id')
      ->where('livecategories.category_id',$live_category_id)
      // ->where('active','=',1)->where('status','=',1)
      ->orderBy('live_streams.created_at', 'desc')->get()->map(function ($item) {
        $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
        return $item;
      });
    //  count($live_category)

      foreach ($livecategories as $key => $livecategory) {
        $livecategoryid = $livecategory['id'];
        $genre_image = $livecategory['image'];
        $livestream = LiveStream::Join('livecategories','livecategories.live_id','=','live_streams.id')
        ->where('livecategories.category_id',$livecategoryid)
        // ->where('active','=',1)->where('status','=',1)
        ->orderBy('live_streams.created_at', 'desc')->get()->map(function ($item) {
          $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
          return $item;
        });
        $categorydetails = LiveCategory::where('id','=',$livecategoryid)->first();

        if(count($live_category) > 0){
          $msg = 'success';
          $status = 'True';
        }else{
          $msg = 'nodata';
          $status = 'False';
        }
        if(count($livestream) > 0){
          $msg = 'success';
          $status = 'True';
        }else{
          $msg = 'nodata';
          $status = 'False';
        }
        $myData[] = array(
          "genre_name"   => $categorydetails->name,
          "genre_id"   => $live_category_id,
          "genre_image"   => URL::to('/').'/public/uploads/audios/'.$genre_image,
          "message" => $msg,
          "livestream" => $livestream,
          "live_category"   => $live_category,
        );

      }

      $LiveCategory = LiveCategory::where('id','=',$live_category_id)->first();

      $response = array(
        'status' => $status ,
        'main_genre' => $LiveCategory->name,
        'categorylivestream' => $livestream
      );
      return response()->json($response, 200);

  }

  public function andriod_slider()
  {
    $sliders = Slider::where('active', '=', 1)->orderBy('created_at', 'desc')->get()->map(function ($item) {
      $item['slider'] = URL::to('/').'/public/uploads/videocategory/'.$item->slider;
      return $item;
    });
    $banners = Video::where('active','=',1)->where('status','=',1)->where('banner', '=', 1)->orderBy('created_at', 'desc')->get()->map(function ($item) {
      $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
      $item['video_url'] = URL::to('/').'/storage/app/public/';
      return $item;
    });
    $live_banner = LiveStream::where('active','=',1)->where('banner', '=', 1)->orderBy('created_at', 'desc')->get()->map(function ($item) {
      $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
      $item['player_image'] = URL::to('/').'/public/uploads/images/'.$item->player_image;
      return $item;
    });
    $series_banner = Series::where('active','=',1)->orderBy('created_at', 'desc')->get()->map(function ($item) {
      $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
      $item['player_image'] = URL::to('/').'/public/uploads/images/'.$item->player_image;
      return $item;
    });

    $response = array(
      'status' => 'true',
      'sliders' => $sliders,
      'video_banner' => $banners,
      'live_banner' => $live_banner,
      'series_banner' => $series_banner,
    );
    return response()->json($response, 200);
  }

  public function theme_primary_color(Request $request)
  {

    $button_color = SiteTheme::pluck('button_bg_color')->first();

    if($button_color != null){
        $button_bg_color =  $button_color ;
    }else{
        $button_bg_color =  '#006AFF' ;
    }
    $response = array(
      'status' => 'true' ,
      'theme_primary_color' => $button_bg_color,

    );

    return response()->json($response, 200);
  }



  public function PlayerAnalytics(Request $request)
  {

    $user_id = $request->user_id;
    $videoid =  $request->videoid;
    $duration =  $request->duration;
    $currentTime = $request->currentTime;
    $bufferedTime = $request->bufferedTime;
    $seekTime = $request->seekTime;
    $countryName = $request->country_name;
    $state_name = $request->state_name;
    $city_name = $request->city_name;
    $watch_percentage = ($currentTime * 100 / $duration);


    if($currentTime != 0){

      $player = new PlayerAnalytic;
      $player->videoid = $videoid;
      $player->user_id = $user_id;
      $player->duration = $duration;
      $player->currentTime = $currentTime;
      $player->watch_percentage = $watch_percentage;
      $player->seekTime = $seekTime;
      $player->bufferedTime = $bufferedTime;
      $player->country_name = $countryName;
      $player->state_name = $state_name;
      $player->city_name = $city_name;
      $player->save();

    $response = array(
      'status' => 'true' ,
      'message' => 'Added to Analytics',

    );
  }else{

    $response = array(
      'status' => 'false' ,
      'message' => 'not added',

    );
  }


    return response()->json($response, 200);
  }

  public function SocialSetting(Request $request)
  {

    $socialsetting = SystemSetting::first();

    if($socialsetting != null){
        $socialsetting =  SystemSetting::get() ;
    }else{
        $socialsetting =  'No data' ;
    }
    $response = array(
      'status' => 'true' ,
      'socialsetting' => $socialsetting,

    );

    return response()->json($response, 200);
  }


  public function add_livepayperview(Request $request)
  {
    $payment_type = $request->payment_type;
    $video_id = $request->video_id;
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
        send_password_notification('Notification From ' . GetWebsiteName(),'You have rented a video','You have rented a video','',$user_id);
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
      $ppv_count = DB::table('live_purchases')->where('video_id', '=', $video_id)->where('user_id', '=', $user_id)->count();
      if ( $ppv_count == 0 ) {
        DB::table('live_purchases')->insert(
          ['user_id' => $user_id ,'video_id' => $video_id,'to_time' => $date ,'expired_date' => $date]
        );
      } else {
        DB::table('live_purchases')->where('video_id', $video_id)->where('user_id', $user_id)->update(['to_time' => $date,'expired_date' => $date]);
      }

      $response = array(
        'status' => 'true',
        'message' => "video has been added"
      );
    }

    return response()->json($response, 200);

  }

  public function ContinueWatchingExits(Request $request)
  {
    $video_id = $request->video_id;
    $user_id = $request->user_id;
    $ContinueWatching = ContinueWatching::where('videoid',$video_id)->where('user_id',$user_id)->count();
    if($ContinueWatching > 0 ){
      $ContinueWatching = ContinueWatching::where('videoid',$video_id)->where('user_id',$user_id)->get();
      $response = array(
        'status' => 'true',
        'ContinueWatching' => $ContinueWatching,
      );
    }else{
      $response = array(
        'status' => 'false',
        // 'ContinueWatching' => "video has been added"
      );
    }
    return response()->json($response, 200);

  }

  public function audio_like(Request $request)
  {
      $user_id = $request->user_id;
      $audio_id = $request->audio_id;
      $like = $request->like;
      $d_like = Likedislike::where("audio_id",$audio_id)->where("user_id",$user_id)->count();


      if($d_like > 0){
        $new_audio_like = Likedislike::where("audio_id",$audio_id)->where("user_id",$user_id)->first();
        if($like == 1){
          $new_audio_like->user_id = $request->user_id;
          $new_audio_like->audio_id = $request->audio_id;
          $new_audio_like->liked = 1;
          $new_audio_like->disliked = 0;
          $new_audio_like->save();
        }else{
          $new_audio_like->user_id = $request->user_id;
          $new_audio_like->audio_id = $request->audio_id;
          $new_audio_like->liked = 0;
          $new_audio_like->save();
        }
      }else{
        $new_audio_like = new Likedislike;
        $new_audio_like->user_id = $request->user_id;
        $new_audio_like->audio_id = $request->audio_id;
        $new_audio_like->liked = 1;
        $new_audio_like->disliked = 0;
        $new_audio_like->save();
      }

      $response = array(
        'status'=>'true',
        'liked' => $new_audio_like->liked,
        'disliked' => $new_audio_like->disliked,
        'message'=>'success'
      );

      return response()->json($response, 200);
  }

  public function audio_dislike(Request $request)
  {

    $user_id = $request->user_id;
    $audio_id = $request->audio_id;
    $dislike = $request->dislike;
    $d_like = Likedislike::where("audio_id",$audio_id)->where("user_id",$user_id)->count();

    if($d_like > 0){
      $new_audio_dislike = Likedislike::where("audio_id",$audio_id)->where("user_id",$user_id)->first();
      if($dislike == 1){
        $new_audio_dislike->user_id = $request->user_id;
        $new_audio_dislike->audio_id = $request->audio_id;
        $new_audio_dislike->liked = 0;
        $new_audio_dislike->disliked = 1;
        $new_audio_dislike->save();
      }else{
        $new_audio_dislike->user_id = $request->user_id;
        $new_audio_dislike->audio_id = $request->audio_id;
        $new_audio_dislike->disliked = 0;
        $new_audio_dislike->save();
      }
    }else{
      $new_audio_dislike = new Likedislike;
      $new_audio_dislike->user_id = $request->user_id;
      $new_audio_dislike->audio_id = $request->audio_id;
      $new_audio_dislike->liked = 0;
      $new_audio_dislike->disliked = 1;
      $new_audio_dislike->save();
    }

     $response = array(
      'status'=>'true',
      'liked' => $new_audio_dislike->liked,
      'disliked' => $new_audio_dislike->disliked,
      'message'=>'success'
    );

     return response()->json($response, 200);

  }

  public function audio_shufffle(Request $request)
  {

    try {

      $album_id = $request->album_id;

      $audios_count = Audio::where('album_id',$album_id)->get();

      $audio_album_id = Audio::Select('audio_albums.*')
                      ->Join('audio_albums','audio_albums.id','=','audio.album_id')
                      ->groupBy('id')->inRandomOrder()->pluck('id')->first();


        if(count($audios_count) > 0 ){

          $audios = Audio::where('album_id',$album_id)->inRandomOrder()->get();

        }
        else{
          $audios = Audio::where('album_id',$audio_album_id)->inRandomOrder()->get();
        }

      $status = "true";

    }
    catch (\Throwable $th) {
       $status = "fail";
    }

    $response = array(
      'status'=> $status,
      'audio_shufffle' => $audios,
    );

     return response()->json($response, 200);
  }

  public function Audiolike_ios(Request $request)
  {
    $user_id = $request->user_id;
    $audio_id = $request->audio_id;

    $like_count = Likedislike::where("audio_id",$audio_id)->where("user_id",$user_id)->count();
    $like_counts = Likedislike::where("audio_id",$audio_id)->where("user_id",$user_id)->where('liked','=' ,'1')->count();
    $unlike_count = Likedislike::where("audio_id",$audio_id)->where("user_id",$user_id)->where('liked', 0)->count();

    if($like_count > 0){

      if($like_counts > 0){
        Likedislike::where("audio_id",$audio_id)->where("user_id",$user_id)->where('liked','=' ,'1')
        ->update([
                'user_id'  => $user_id ,
                'audio_id' => $audio_id ,
                'liked'    => '0' ,
                'disliked'    => '0',
              ]);

      }elseif( $unlike_count > 0){
          Likedislike::where("audio_id",$audio_id)->where("user_id",$user_id)->where('liked',0)
          ->update([
                  'user_id'  => $user_id ,
                  'audio_id' => $audio_id ,
                  'liked'    => '1' ,
                  'disliked'    => '0',
                ]);
      }

    }
    else{
        Likedislike::create([
          'user_id'  => $user_id ,
          'audio_id' => $audio_id ,
          'liked'    => '1' ,
          'disliked'    => '0' ,
        ]);
    }

    $response = array(
      'status'=>'true',
      'like'  =>  Likedislike::where("audio_id",$audio_id)->where("user_id",$user_id)->pluck('liked')->first(),
      'dislike'  =>   Likedislike::where("audio_id",$audio_id)->where("user_id",$user_id)->pluck('disliked')->first(),
    );

    return response()->json($response, 200);

  }

  public function Audiodislike_ios(Request $request)
  {
      $user_id = $request->user_id;
      $audio_id = $request->audio_id;

      $dislike_count = Likedislike::where("audio_id",$audio_id)->where("user_id",$user_id)->count();
      $dislike_counts = Likedislike::where("audio_id",$audio_id)->where("user_id",$user_id)->where('disliked',1)->count();
      $undislike_count = Likedislike::where("audio_id",$audio_id)->where("user_id",$user_id)->where('disliked', 0)->count();

      if($dislike_count > 0){

        if($dislike_counts > 0){
          Likedislike::where("audio_id",$audio_id)->where("user_id",$user_id)->where('disliked','=' ,'1')
          ->update([
                  'user_id'  => $user_id ,
                  'audio_id' => $audio_id ,
                  'liked'    => '0' ,
                  'disliked'    => '0',
                ]);

        }elseif( $undislike_count > 0){
            Likedislike::where("audio_id",$audio_id)->where("user_id",$user_id)->where('disliked',0)
            ->update([
                    'user_id'  => $user_id ,
                    'audio_id' => $audio_id ,
                    'liked'    => '0' ,
                    'disliked'    => '1',
                  ]);
        }


      }else{
          Likedislike::create([
            'user_id'  => $user_id ,
            'audio_id' => $audio_id ,
            'liked'    => '0',
            'disliked'    => '1',
          ]);
      }

      $response = array(
        'status'=>'true',
        'like'  =>  Likedislike::where("audio_id",$audio_id)->where("user_id",$user_id)->pluck('liked')->first(),
        'dislike'  =>   Likedislike::where("audio_id",$audio_id)->where("user_id",$user_id)->pluck('disliked')->first(),
      );

      return response()->json($response, 200);
  }

  public function ReelsVideo(){

    $reel_videos = Video::Join('reelsvideo','reelsvideo.video_id','=','videos.id')
    ->get()->map(function ($item) {
      $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
      $item['video_url'] = URL::to('/').'/storage/app/public/';
      $item['reelvideo_url'] = URL::to('/').'/public/uploads/reelsVideos/'.$item->reelvideo;
      $item['pdf_files_url'] = URL::to('/').'/public/uploads/videoPdf/'.$item->pdf_files;
      $item['mobile_image_url'] = URL::to('/').'/public/uploads/images/'.$item->mobile_image;
      $item['tablet_image_url'] = URL::to('/').'/public/uploads/images/'.$item->tablet_image;
      $item['reel_videos'] =  URL::to('public/uploads/reelsVideos').'/'.$item->reels_videos;
      return $item;
    });


    $response = array(
      'status'=>'true',
      'Reel_videos'  =>  $reel_videos,
    );

    return response()->json($response, 200);
  }

  public function Videolike_ios(Request $request)
  {
    $user_id = $request->user_id;
    $video_id = $request->video_id;

    $like_count = Likedislike::where("video_id",$video_id)->where("user_id",$user_id)->count();
    $like_counts = Likedislike::where("video_id",$video_id)->where("user_id",$user_id)->where('liked','=' ,'1')->count();
    $unlike_count = Likedislike::where("video_id",$video_id)->where("user_id",$user_id)->where('liked', 0)->count();

    if($like_count > 0){

      if($like_counts > 0){
        Likedislike::where("video_id",$video_id)->where("user_id",$user_id)->where('liked','=' ,'1')
        ->update([
                'user_id'  => $user_id ,
                'video_id' => $video_id ,
                'liked'    => '0' ,
                'disliked'    => '0',
              ]);

      }elseif( $unlike_count > 0){
          Likedislike::where("video_id",$video_id)->where("user_id",$user_id)->where('liked',0)
          ->update([
                  'user_id'  => $user_id ,
                  'video_id' => $video_id ,
                  'liked'    => '1' ,
                  'disliked'    => '0',
                ]);
      }

    }
    else{
        Likedislike::create([
          'user_id'  => $user_id ,
          'video_id' => $video_id ,
          'liked'    => '1' ,
          'disliked'    => '0' ,
        ]);
    }

    $response = array(
      'status'=>'true',
      'like'  =>  Likedislike::where("video_id",$video_id)->where("user_id",$user_id)->pluck('liked')->first(),
      'dislike'  =>   Likedislike::where("video_id",$video_id)->where("user_id",$user_id)->pluck('disliked')->first(),
    );

    return response()->json($response, 200);

  }

  public function Videodislike_ios(Request $request)
  {
      $user_id = $request->user_id;
      $video_id = $request->video_id;

      $dislike_count = Likedislike::where("video_id",$video_id)->where("user_id",$user_id)->count();
      $dislike_counts = Likedislike::where("video_id",$video_id)->where("user_id",$user_id)->where('disliked',1)->count();
      $undislike_count = Likedislike::where("video_id",$video_id)->where("user_id",$user_id)->where('disliked', 0)->count();

      if($dislike_count > 0){

        if($dislike_counts > 0){
          Likedislike::where("video_id",$video_id)->where("user_id",$user_id)->where('disliked','=' ,'1')
          ->update([
                  'user_id'  => $user_id ,
                  'video_id' => $video_id ,
                  'liked'    => '0' ,
                  'disliked'    => '0',
                ]);

        }elseif( $undislike_count > 0){
            Likedislike::where("video_id",$video_id)->where("user_id",$user_id)->where('disliked',0)
            ->update([
                    'user_id'  => $user_id ,
                    'video_id' => $video_id ,
                    'liked'    => '0' ,
                    'disliked'    => '1',
                  ]);
        }


      }else{
          Likedislike::create([
            'user_id'  => $user_id ,
            'video_id' => $video_id ,
            'liked'    => '0',
            'disliked'    => '1',
          ]);
      }

      $response = array(
        'status'=>'true',
        'like'  =>  Likedislike::where("video_id",$video_id)->where("user_id",$user_id)->pluck('liked')->first(),
        'dislike'  =>   Likedislike::where("video_id",$video_id)->where("user_id",$user_id)->pluck('disliked')->first(),
      );

      return response()->json($response, 200);
  }




  public function Episodelike_ios(Request $request)
  {
    $user_id = $request->user_id;
    $episode_id = $request->episode_id;

    $like_count = Likedislike::where("episode_id",$episode_id)->where("user_id",$user_id)->count();
    $like_counts = Likedislike::where("episode_id",$episode_id)->where("user_id",$user_id)->where('liked','=' ,'1')->count();
    $unlike_count = Likedislike::where("episode_id",$episode_id)->where("user_id",$user_id)->where('liked', 0)->count();

    if($like_count > 0){

      if($like_counts > 0){
        Likedislike::where("episode_id",$episode_id)->where("user_id",$user_id)->where('liked','=' ,'1')
        ->update([
                'user_id'  => $user_id ,
                'episode_id' => $episode_id ,
                'liked'    => '0' ,
                'disliked'    => '0',
              ]);

      }elseif( $unlike_count > 0){
          Likedislike::where("episode_id",$episode_id)->where("user_id",$user_id)->where('liked',0)
          ->update([
                  'user_id'  => $user_id ,
                  'episode_id' => $episode_id ,
                  'liked'    => '1' ,
                  'disliked'    => '0',
                ]);
      }

    }
    else{
        Likedislike::create([
          'user_id'  => $user_id ,
          'episode_id' => $episode_id ,
          'liked'    => '1' ,
          'disliked'    => '0' ,
        ]);
    }

    $response = array(
      'status'=>'true',
      'like'  =>  Likedislike::where("episode_id",$episode_id)->where("user_id",$user_id)->pluck('liked')->first(),
      'dislike'  =>   Likedislike::where("episode_id",$episode_id)->where("user_id",$user_id)->pluck('disliked')->first(),
    );

    return response()->json($response, 200);

  }

  public function Episodedislike_ios(Request $request)
  {
      $user_id = $request->user_id;
      $episode_id = $request->episode_id;

      $dislike_count = Likedislike::where("episode_id",$episode_id)->where("user_id",$user_id)->count();
      $dislike_counts = Likedislike::where("episode_id",$episode_id)->where("user_id",$user_id)->where('disliked',1)->count();
      $undislike_count = Likedislike::where("episode_id",$episode_id)->where("user_id",$user_id)->where('disliked', 0)->count();

      if($dislike_count > 0){

        if($dislike_counts > 0){
          Likedislike::where("episode_id",$episode_id)->where("user_id",$user_id)->where('disliked','=' ,'1')
          ->update([
                  'user_id'  => $user_id ,
                  'episode_id' => $episode_id ,
                  'liked'    => '0' ,
                  'disliked'    => '0',
                ]);

        }elseif( $undislike_count > 0){
            Likedislike::where("episode_id",$episode_id)->where("user_id",$user_id)->where('disliked',0)
            ->update([
                    'user_id'  => $user_id ,
                    'episode_id' => $episode_id ,
                    'liked'    => '0' ,
                    'disliked'    => '1',
                  ]);
        }


      }else{
          Likedislike::create([
            'user_id'  => $user_id ,
            'episode_id' => $episode_id ,
            'liked'    => '0',
            'disliked'    => '1',
          ]);
      }

      $response = array(
        'status'=>'true',
        'like'  =>  Likedislike::where("episode_id",$episode_id)->where("user_id",$user_id)->pluck('liked')->first(),
        'dislike'  =>   Likedislike::where("episode_id",$episode_id)->where("user_id",$user_id)->pluck('disliked')->first(),
      );

      return response()->json($response, 200);
  }

  public function live_like_ios(Request $request)
  {
      $user_id = $request->user_id;
      $live_id = $request->live_id;

      $like_count = Likedislike::where("live_id",$live_id)->where("user_id",$user_id)->count();
      $like_counts = Likedislike::where("live_id",$live_id)->where("user_id",$user_id)->where('liked','=' ,'1')->count();
      $unlike_count = Likedislike::where("live_id",$live_id)->where("user_id",$user_id)->where('liked', 0)->count();

      if($like_count > 0){

        if($like_counts > 0){
          Likedislike::where("live_id",$live_id)->where("user_id",$user_id)->where('liked','=' ,'1')
          ->update([
                  'user_id'  => $user_id ,
                  'live_id' => $live_id ,
                  'liked'    => '0' ,
                  'disliked'    => '0',
                ]);

        }elseif( $unlike_count > 0){
            Likedislike::where("live_id",$live_id)->where("user_id",$user_id)->where('liked',0)
            ->update([
                    'user_id'  => $user_id ,
                    'live_id' => $live_id ,
                    'liked'    => '1' ,
                    'disliked'    => '0',
                  ]);
        }

      }
      else{
          Likedislike::create([
            'user_id'  => $user_id ,
            'live_id' => $live_id ,
            'liked'    => '1' ,
            'disliked'    => '0' ,
          ]);
      }

      $response = array(
        'status'=>'true',
        'like'  =>  Likedislike::where("live_id",$live_id)->where("user_id",$user_id)->pluck('liked')->first(),
        'dislike'  =>   Likedislike::where("live_id",$live_id)->where("user_id",$user_id)->pluck('disliked')->first(),
      );

      return response()->json($response, 200);
  }

  public function live_dislike_ios(Request $request)

  {
      $user_id = $request->user_id;
      $live_id = $request->live_id;

      $dislike_count = Likedislike::where("live_id",$live_id)->where("user_id",$user_id)->count();
      $dislike_counts = Likedislike::where("live_id",$live_id)->where("user_id",$user_id)->where('disliked',1)->count();
      $undislike_count = Likedislike::where("live_id",$live_id)->where("user_id",$user_id)->where('disliked', 0)->count();

      if($dislike_count > 0){

        if($dislike_counts > 0){
          Likedislike::where("live_id",$live_id)->where("user_id",$user_id)->where('disliked','=' ,'1')
          ->update([
                  'user_id'  => $user_id ,
                  'live_id' => $live_id ,
                  'liked'    => '0' ,
                  'disliked'    => '0',
                ]);

        }elseif( $undislike_count > 0){
            Likedislike::where("live_id",$live_id)->where("user_id",$user_id)->where('disliked',0)
            ->update([
                    'user_id'  => $user_id ,
                    'live_id' => $live_id ,
                    'liked'    => '0' ,
                    'disliked'    => '1',
                  ]);
        }


      }else{
          Likedislike::create([
            'user_id'  => $user_id ,
            'live_id' => $live_id ,
            'liked'    => '0',
            'disliked'    => '1',
          ]);
      }

      $response = array(
        'status'=>'true',
        'like'  =>  Likedislike::where("live_id",$live_id)->where("user_id",$user_id)->pluck('liked')->first(),
        'dislike'  =>   Likedislike::where("live_id",$live_id)->where("user_id",$user_id)->pluck('disliked')->first(),
      );

      return response()->json($response, 200);
  }

  public function live_addwatchalter(Request $request)
    {
        $user_id = $request->user_id;
        $live_id = $request->live_id;

        try {
            if($live_id != ''){
              $count = Watchlater::where('user_id', '=', $user_id)->where('live_id', '=', $live_id)->count();

            if( $count > 0 ) {

                Watchlater::where('user_id', '=', $user_id)->where('live_id', '=', $live_id)->delete();
                $status = "true";
                $message = "Removed live video From Your Watch Later List";
            }
            else {

                $data = array('user_id' => $user_id, 'live_id' => $live_id );
                Watchlater::Create($data);
                $status = "true";
                $message = "Added live video to Your Watch Later List";
            }
          }
        }
        catch (\Throwable $th) {
            $status = "false";
            $message = $th->getMessage();
        }

        $response = array(
          'status' => $status ,
          'message'=> $message,
        );

        return response()->json($response, 200);
    }

  public function home_categorylist(Request $request)
  {

    // $videocategories = VideoCategory::select('id','image')->where('in_home',1)->get()->toArray();
    $videocategories = VideoCategory::join('categoryvideos','video_categories.id', '=' ,'categoryvideos.category_id')->distinct()->select('video_categories.id','video_categories.image','video_categories.order')
    ->where('video_categories.in_home',1)->get()->toArray();

    $myData = array();

    foreach ($videocategories as $key => $videocategory) {
      $videocategoryid = $videocategory['id'];
      $genre_image = $videocategory['image'];

      $videos= Video::Join('categoryvideos','categoryvideos.video_id','=','videos.id')->where('categoryvideos.category_id',$videocategoryid)
                  ->where('active','=',1)->where('status','=',1)->where('draft','=',1);
                  if(Geofencing() !=null && Geofencing()->geofencing == 'ON')
                  {
                    $videos = $videos  ->whereNotIn('videos.id',Block_videos());
                  }
                  $videos =$videos->orderBy('videos.created_at', 'desc')->get()->map(function ($item) {
                    $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
                    $item['video_url'] = URL::to('/').'/storage/app/public/';
                    $item['category_name'] = VideoCategory::where('id',$item->category_id)->pluck('slug')->first();
                    return $item;
        });

      $main_genre = CategoryVideo::Join('video_categories','video_categories.id','=','categoryvideos.category_id')->get('name');

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
        "message" => $msg,
        'gener_name' =>  VideoCategory::where('id',$videocategoryid)->pluck('name')->first(),
        'home_genre' =>  VideoCategory::where('id',$videocategoryid)->pluck('home_genre')->first(),
        'gener_id' =>  VideoCategory::where('id',$videocategoryid)->pluck('id')->first(),
        "videos" => $videos
      );
    }

    $response = array(
      'status' => 'true',
      'genre_movies' => $myData,
      'main_genre' => $msg,
      'main_genre' => $main_genre,
    );

    return response()->json($response, 200);
  }

  public function Currency_setting()
  {

    $response = array(
      'status' => 'true',
      'Currency_Setting' => CurrencySetting::all() ,
    );

    return response()->json($response, 200);
  }

  public function MobileSideMenu()
  {

    $response = array(
      'status' => 'true',
      'MobileSideMenu' => MobileSideMenu::orderBy('order')->get() ,
    );

    return response()->json($response, 200);
  }


  public function Series_SeasonsEpisodes(Request $request)
  {


    $series_id = $request->series_id;
    $season_id = $request->season_id;

    $episodes = Episode::where('series_id',$series_id)->where('season_id',$season_id)
    ->orderBy('episode_order')->get()->map(function ($item) {
      $item['image'] = URL::to('/').'/public/uploads/images/'.$item->image;
      $item['episode_order'] = 'Episode '.$item->episode_order;
      return $item;
    });
    $response = array(
      'status' => 'true',
      'episodes' => $episodes,
    );

    return response()->json($response, 200);
  }


  public function relatedseries(Request $request)
  {

    try {
      
          $series_id = $request->series_id;

          $series = Series::where('id','!=', $series_id)->inRandomOrder()->get()->map(function ($item) {
            $item['image'] = URL::to('public/uploads/images/'.$item->image);
            return $item;
          });

          $response = array(
            'status' => 'true',
            'message' => 'Retreive the Related Series Successfully' ,
            'series' => $series,
          );

    } catch (\Throwable $th) {

          $response = array(
            'status' => 'false',
            'message' => $th->getMessage() ,
          );
    }

    

    return response()->json($response, 200);
  }


  public function relatedlive(Request $request)
  {

    $live_id = $request->live_id;

    $livestream = LiveStream::where('id','!=', $live_id)
      ->get()->map(function ($item) {
      $item['image'] = URL::to('/').'/public/uploads/images/'.$item->image;
      return $item;
    });
    $response = array(
      'status' => 'true',
      'livestream' => $livestream,
    );

    return response()->json($response, 200);
  }

  public function cpanelstorage(Request $request)
  {


    $Domain_Name = "domain";
    $username    = 'manoj';
    $password    = 't94d24w32F8W';
    $host    = '75.119.145.126';
    $port = '2083';

    $user = "user";
    $domain = "domain.com";
   // Instantiate the CPANEL object.
  //  require_once "/usr/local/cpanel/php/cpanel.php";

   require('cpanel/cpanel/cPanel.php');

    // establish connection to CPanel
    $cpanel = new CPANEL();
    // get email account informations
    $response = $cpanel->uapi(
        'Email',
       'get_disk_usage',
           array (
              //  'user' => $user,
              //  'domain' => $domain,
               'name'       => 'manoj_'.$Domain_Name,
               'password'   => 'CHennai@01',
           )
       );

// Handle the response
if ($response['cpanelresult']['result']['status']) {
    $data = $response['cpanelresult']['result']['data'];
    // Do something with the $data
}
else {
    // Report errors and do things
}
// Disconnect from cPanel - only do this once.
$cpanel->end();

  }


  public function episodedetailsAndriod(Request $request){

    $episodeid = $request->episodeid;


    $episode = Episode::where('id',$episodeid)->orderBy('episode_order')->get()->map(function ($item) use ($request){
       $item['image'] = URL::to('/').'/public/uploads/images/'.$item->image;
       $item['series_name'] = Series::where('id',$item->series_id)->pluck('title')->first();
       $item['shareurl'] = URL::to('/episode/') . '/' . Series::where('id',$item->series_id)->pluck('slug')->first() . '/' . $item->slug;
       $item['m3u8url'] = URL::to('/storage/app/public/') . '/' . $item->path . '.m3u8';
       
       $plans_ads_enable = $this->plans_ads_enable($request->user_id);

       if($plans_ads_enable == 1){

        $item['episode_ads_url'] =  AdsEvent::Join('advertisements','advertisements.id','=','ads_events.ads_id')
                                  // ->whereDate('start', '=', Carbon\Carbon::now()->format('Y-m-d'))
                                  // ->whereTime('start', '<=', $current_time)
                                  // ->whereTime('end', '>=', $current_time)
                                  ->where('ads_events.status',1)
                                  ->where('advertisements.status',1)
                                  ->where('advertisements.id',$item->episode_ads)
                                  ->pluck('ads_path')->first();
                        
      }else{
        $item['episode_ads_url'] = " ";
      }
      return $item;
      
     });

    //  if(count($episode) > 0){
    //  $series_id =  $episode[0]->series_id;
    //  $season_id = $episode[0]->season_id;

    //  $Season = SeriesSeason::where('series_id',$series_id)->where('id',$season_id)->first();

    //  $AllSeason = SeriesSeason::where('series_id',$series_id)->get();
    //           if(count($AllSeason) > 0){


    //               foreach($AllSeason as $key => $Season){

    //                   if($season_id ==  $Season->id){

    //                     $name = $key+1;
    //                     $Season_Name = 'Season '. $name;
    //                   }
    //               }

    //             }else{
    //               $Season_Name = '';

    //             }

    //  }else{
    //   $Season = '';
    //  }
    //  print_r($Season->id);exit;


    if($request->user_id != ''){
      $user_id = $request->user_id;
      $cnt = Wishlist::select('episode_id')->where('user_id','=',$user_id)->where('episode_id','=',$request->episodeid)->count();
      $wishliststatus =  ($cnt == 1) ? "true" : "false";
      // $userrole = User::find($user_id)->pluck('role');
    }else{
      $wishliststatus = 'false';
      // $userrole = '';
    }
    if(!empty($request->user_id) && $request->user_id != '' ){
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

  $season_id = Episode::where('id','=',$episodeid)->pluck('season_id');



  if(!empty($series_id) && count($series_id) > 0){
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
  if(!empty($category)){
  $main_genre = implode(",",$category);
  }else{
    $main_genre = "";
  }

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
    if (!empty($episode) && count($episode) > 0) {
        $season = SeriesSeason::where('id',$episode[0]->season_id)->first();
        $ppv_exist = PpvPurchase::where('user_id',$user_id)
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

    if(!empty($season_id) ){
      $Season = SeriesSeason::where('series_id',$series_id)->where('id',$season_id)->get();
    }


    $response = array(
      'status'=>'true',
      'message'=>'success',
      'episode' => $episode,
      // 'Season_Name' => $Season_Name,
      'season' => $Season,
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

  public function albumlist_ios(Request $request)

  {
      $audioalbums_count = AudioAlbums::get()->count();

        if($audioalbums_count > 0){
          $audioalbums = AudioAlbums::orderBy('created_at', 'desc')->get();
          $audioalbums = AudioAlbums::orderBy('created_at', 'desc')->get()->map(function ($item) {
            $item['image_url'] = URL::to('/').'/public/uploads/albums/'.$item->album;
            return $item;
          });

          foreach($audioalbums as $val){

            $audio[$val->albumname] = Audio::where('album_id',$val->id)
            ->orderBy('created_at', 'desc')
            ->get()->map(function ($item) {
              $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
              $item['player_image'] = URL::to('/').'/public/uploads/images/'.$item->player_image;
              return $item;
            });

              $response = array(
                'status'=>'true',
                'audioalbums'=>$audioalbums,
              );
      }
      }
      else{
        $response = array(
          'status'=>'false',
          'audioalbums'=> array(),
          'audio'=>array(),
      );
      }
        return response()->json($response, 200);
    }

    public function account_delete(Request $request){

        try {

          User::find($request->user_id)->delete();
          ContinueWatching::where('user_id',$request->user_id)->delete();
          Watchlater::where('user_id',$request->user_id)->delete();
          Wishlist::where('user_id',$request->user_id)->delete();
          Multiprofile::where('parent_id',$request->user_id)->delete();

          $status = "true";
          $message = "Your ". GetWebsiteName() ." user account was successfully deleted" ;

        } catch (\Throwable $th) {
            $status = "false";
            $message =  $th->getMessage();
        }

        $response = array(
          'status'=> $status,
          'message'=> $message,
        );

        return response()->json($response, 200);
    }

    public function remaining_Episode(Request $request)
    {

      $season_id = $request->seasonid;
      $episode_id = $request->episodeid;

      try {
          $episodes = Episode::where('season_id','=',$season_id)->where('id','!=',$episode_id)->orderBy('episode_order')->get()->map(function ($item) {
            $item['image'] = URL::to('/').'/public/uploads/images/'.$item->image;
            $item['series_name'] = Series::where('id',$item->series_id)->pluck('title')->first();
            return $item;
          });

        $response = array(
          'status'=>'true',
          'message'=>'success',
          'episodes' => $episodes
        );

      } catch (\Throwable $th) {
          $response = array(
            'status'=>'false',
            'message'=>$th->getMessage(),
            'episodes' => [],
          );
      }

      return response()->json($response, 200);

    }

    public function related_series(Request $request)
    {

      $series_id = $request->series_id ;

      $Series_category = Series::Join('series_categories','series_categories.series_id','=','series.id')
                        ->where('series.id',$series_id)->pluck('category_id');

      $Series_list = Series::Join('series_categories','series_categories.series_id','=','series.id')
          ->whereIn('series_categories.category_id',$Series_category)
          ->where('series.id',"!=",$series_id)
          ->where('active','=',1)->orderBy('series.created_at', 'desc')
          ->groupBy('series.id')
          ->get();

        if(count($Series_list) > 0){
          $Series_list = $Series_list->random();
        }

      $response = array(
        'status'=>'true',
        'message'=>'success',
        'Series_list' =>$Series_list,
      );

      return response()->json($response, 200);
    }

    public function PageHome(Request $request)
    {

      try{

        $HomeSetting = MobileHomeSetting::first();
        $OrderHomeSetting = OrderHomeSetting::first();
        $OrderSetting = array();

        $videocategories = VideoCategory::select('id','image','order')->get()->toArray();
        $order_video_categories = VideoCategory::select('id','name','order')->get()->toArray();
        $movies = array();

        foreach ($videocategories as $key => $videocategory) {

            $videocategoryid = $videocategory['id'];
            $genre_image = $videocategory['image'];

            $videos= Video::Join('categoryvideos','categoryvideos.video_id','=','videos.id')
              ->where('categoryvideos.category_id',$videocategoryid) ->where('active','=',1)
              ->where('status','=',1)->where('draft','=',1)->orderBy('videos.created_at', 'desc')
              ->get()->map(function ($item) {
                $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
                $item['video_url'] = URL::to('/').'/storage/app/public/';
                $item['player_image_url'] = URL::to('/').'/public/uploads/images/'.$item->player_image;
                $item['Tv_image_url'] = URL::to('/').'/public/uploads/images/'.$item->video_tv_image;

                $item['category_name'] = VideoCategory::where('id',$item->category_id)->pluck('slug')->first();
                $item['category_order'] = VideoCategory::where('id',$item->category_id)->pluck('order')->first();
                return $item;
            });

            $main_genre = CategoryVideo::Join('video_categories','video_categories.id','=','categoryvideos.category_id')->get('name');
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

            $movies[] = array(
              "message" => $msg,
              'gener_name' =>  VideoCategory::where('id',$videocategoryid)->pluck('name')->first(),
              'home_genre' =>  VideoCategory::where('id',$videocategoryid)->pluck('home_genre')->first(),
              'gener_id' =>  VideoCategory::where('id',$videocategoryid)->pluck('id')->first(),
              "video" => $videos,
              "order_video_categories" => $order_video_categories,
            );
        }


        if($HomeSetting->featured_videos == 1){

          $featured_videos = Video::where('active', '=', '1')->where('featured', '=', '1')->where('status', '=', '1')
              ->where('draft', '=', '1')->orderBy('created_at', 'DESC')->get();

          $featured_videos =  Video::where('active', '=', '1')->where('featured', '=', '1')->where('status', '=', '1')
             ->where('draft', '=', '1')->orderBy('created_at', 'DESC')->get()->map(function ($item) {
                $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
                $item['player_image_url'] = URL::to('/').'/public/uploads/images/'.$item->player_image;
                $item['Tv_image_url'] = URL::to('/').'/public/uploads/images/'.$item->video_tv_image;

                $item['video_url'] = URL::to('/').'/storage/app/public/';
                return $item;
            });

        }else{

          $featured_videos = [];
        }

        if($HomeSetting->latest_videos == 1){

          $latest_videos =  Video::where('status', '=', '1')->take(10)->where('active', '=', '1')->where('draft', '=', '1')
          ->orderBy('created_at', 'DESC')->get()->map(function ($item) {
              $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
              $item['player_image_url'] = URL::to('/').'/public/uploads/images/'.$item->player_image;
              $item['Tv_image_url'] = URL::to('/').'/public/uploads/images/'.$item->video_tv_image;

              $item['video_url'] = URL::to('/').'/storage/app/public/';
              return $item;
            });

        }else{

          $latest_videos = [];
        }

        if( $HomeSetting->category_videos == 1 ){

          $oldvideocategories = VideoCategory::select('id','image','order')->get()->toArray();
          $videocategories = VideoCategory::join('categoryvideos','video_categories.id', '=' ,'categoryvideos.category_id')->distinct()->select('video_categories.id','video_categories.image','video_categories.order')->get()->toArray();
          $order_video_categories = VideoCategory::select('id','name','order')->get()->toArray();
          $myData = array();

          foreach ($videocategories as $key => $videocategory) {
            $videocategoryid = $videocategory['id'];
            $genre_image = $videocategory['image'];

            $videos= Video::Join('categoryvideos','categoryvideos.video_id','=','videos.id')
              ->where('categoryvideos.category_id',$videocategoryid)->where('active','=',1)->where('status','=',1)->where('draft','=',1)
              ->orderBy('videos.created_at', 'desc')->get()->map(function ($item) {

                $item['video_url'] = URL::to('/').'/storage/app/public/';
                $item['category_name'] = VideoCategory::where('id',$item->category_id)->pluck('slug')->first();
                $item['category_order'] = VideoCategory::where('id',$item->category_id)->pluck('order')->first();

                $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
                $item['player_image_url'] = URL::to('/').'/public/uploads/images/'.$item->player_image;
                $item['Tv_image_url'] = URL::to('/').'/public/uploads/images/'.$item->video_tv_image;

                $item['artist_name'] = Videoartist::join('artists','artists.id','=','video_artists.artist_id')
                                        ->where('video_artists.video_id', $item->video_id)->pluck('artist_name') ;

              return $item;
            });

            $main_genre = CategoryVideo::Join('video_categories','video_categories.id','=','categoryvideos.category_id')->get('name');

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
              "message" => $msg,
              'gener_name' =>  VideoCategory::where('id',$videocategoryid)->pluck('name')->first(),
              'home_genre' =>  VideoCategory::where('id',$videocategoryid)->pluck('home_genre')->first(),
              'gener_id' =>  VideoCategory::where('id',$videocategoryid)->pluck('id')->first(),
              "videos" => $videos,
              "order_video_categories" => $order_video_categories,
            );
          }
        }
        else{
          $myData = [];

        }
        if( $HomeSetting->live_videos == 1 ){

            $live_videos = LiveStream::where('active', '=', '1')->orderBy('id', 'DESC')->get()->map(function ($item) {
              $item['image'] = URL::to('/').'/public/uploads/images/'.$item->image;
              $item['player_image_url'] = URL::to('/').'/public/uploads/images/'.$item->player_image;
              $item['Tv_image_url'] = URL::to('/').'/public/uploads/images/'.$item->Tv_live_image;

              return $item;
            });
        }
        else{
          $live_videos = [];
        }

        if($HomeSetting->series == 1){

          $series = Series::where('active','=',1)->orderBy('created_at', 'desc')->get()->map(function ($item) {
              $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
              $item['player_image_url'] = URL::to('/').'/public/uploads/images/'.$item->player_image;
              $item['Tv_image_url'] = URL::to('/').'/public/uploads/images/'.$item->tv_image;
              $item['artist_name'] = Series::where('series_artists.series_id',$item->id)
                                      ->join('series_artists', 'series_artists.series_id', '=', 'series.id')
                                      ->join('artists', 'artists.id', '=', 'series_artists.artist_id')
                                      ->pluck('artist_name');
              return $item;
            });
        }else{

          $series = [];
        }

        if($HomeSetting->audios == 1){

          $audios = Audio::orderBy('created_at', 'desc')->get()->map(function ($item) {
            $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
            $item['player_image'] = URL::to('/').'/public/uploads/images/'.$item->player_image;
            return $item;
          });

        }else{

          $audios = [];
        }

        if($HomeSetting->albums == 1){

          $albums = AudioAlbums::orderBy('created_at', 'desc')->get()->map(function ($item) {
            $item['image_url'] = URL::to('/').'/public/uploads/albums/'.$item->album;
            return $item;
          });

        }else{
          $albums = [];
        }

        if($HomeSetting->live_category == 1){

          $livecategories = LiveCategory::select('id','image','order')->groupBy('name')->get()->toArray();
          $order_live_categories = LiveCategory::select('id','name','order')->groupBy('name')->get()->toArray();
          $LiveCategory = array();

          foreach ($livecategories as $key => $livecategory) {

            $livecategoryid = $livecategory['id'];
            $genre_image = $livecategory['image'];

            $live_category= LiveStream::Join('livecategories','livecategories.live_id','=','live_streams.id')
                          ->where('livecategories.category_id',$livecategoryid)
                          ->where('active','=',1)->where('status','=',1)
                          ->orderBy('live_streams.created_at', 'desc')->get()->map(function ($item) {

                            $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
                            $item['player_image_url'] = URL::to('/').'/public/uploads/images/'.$item->player_image;
                            $item['Tv_image_url'] = URL::to('/').'/public/uploads/images/'.$item->Tv_live_image;

                            $item['category_name'] = LiveCategory::where('id',$item->category_id)->pluck('slug')->first();
                            $item['category_order'] = LiveCategory::where('id',$item->category_id)->pluck('order')->first();

                            return $item;
                          });

            $main_genre = CategoryLive::Join('live_categories','live_categories.id','=','livecategories.category_id')->get('name');

            foreach($main_genre as $value){
              $category[] = $value['name'];
            }

            if(!empty($category)){
              $main_genre = implode(",",$category);
            }else{
              $main_genre = "";
            }

            if(count($live_category) > 0){
              $msg = 'success';
            }else{
              $msg = 'nodata';
            }

            $LiveCategory[] = array(
              "message" => $msg,
              'gener_name' =>  LiveCategory::where('id',$livecategoryid)->pluck('name')->first(),
              'gener_id' =>  LiveCategory::where('id',$livecategoryid)->pluck('id')->first(),
              "live_category" => $live_category,
              "order_video_categories" => $order_video_categories,
            );

          }
        }else{
          $LiveCategory = [];
        }

        $Alllanguage   = Language::latest('created_at')->get()->map(function ($item) {
            $item['image_url'] =$item->language_image ?  URL::to('/').'/public/uploads/Language/'.$item->language_image : null ;
            return $item;
        });


        if(!empty($request->language_id)){
        $Language = Language::where('id', $request->language_id)->first();

        if(!empty($Language)){
          $VideoLanguage   = Video::Join('languagevideos','languagevideos.video_id','=','videos.id')
          ->where('languagevideos.language_id',$request->language_id)->get();
        }
        if(!empty($Language)){
          $languagesSeries = Series::Join('series_languages','series_languages.series_id','=','series.id')
          ->where('series_languages.language_id',$request->language_id)->get();
          }

        if(!empty($Language)){
          $languagesLive = LiveStream::Join('live_languages','live_languages.live_id','=','live_streams.id')
          ->where('live_languages.language_id',$request->language_id)->get();
          }

        if(!empty($Language)){

          $LanguagesAudio = Audio::Join('audio_languages','audio_languages.audio_id','=','audios.id')
          ->where('audio_languages.language_id',$request->language_id)->get();
        }

      }else{
        $VideoLanguage = [];
        $languagesSeries = [];
        $LanguagesAudio = [];
        $languagesLive = [];
      }
        $response = array(
          'status'=>'true',
          'HomeSetting' => $HomeSetting,
          'OrderHomeSetting' => $OrderHomeSetting,
          'featured_videos' => $featured_videos,
          'latest_videos' => $latest_videos,
          'category_videos' => $myData,
          'live_videos' => $live_videos,
          'series' => $series,
          'audios' => $audios,
          'albums' => $albums,
          'movies' => $movies,
          'LiveCategory' => $LiveCategory,
          'Alllanguage' => $Alllanguage  ,
          'VideoLanguage' => $VideoLanguage  ,
          'languagesSeries' => $languagesSeries  ,
          'languagesLive' => $languagesLive  ,
          'LanguagesAudio' => $LanguagesAudio  ,
        );


      } catch (\Throwable $th) {
        $response = array(
          'status'=>'false',
          'message'=>$th->getMessage(),
          'nodata' => [],
        );
    }

    return response()->json($response, 200);

    }

    public function LanguageVideo(Request $request){

      $langid = $request->langid;
      $Language = Language::where('id', $langid)->first();
      try{

        if(!empty($Language)){
          $languagesVideo = Video::Join('languagevideos','languagevideos.video_id','=','videos.id')
          ->where('languagevideos.language_id',$langid)->get();

          if(count($languagesVideo) > 0){
            $status = 'true';
          }else{
            $status = 'false';
          }

          $response = array(
              'status'=>$status,
              'Language_name' => $Language->name,
              'Language' => $Language,
              'languagesVideo' => $languagesVideo,
          );
        }

      } catch (\Throwable $th) {
        $response = array(
          'status'=>'false',
          'message'=>$th->getMessage(),
          'nodata' => [],
        );
    }
    return response()->json($response, 200);

    }


    public function LanguageSeries(Request $request){

      $langid = $request->langid;
      $Language = Language::where('id', $langid)->first();
      try{

        if(!empty($Language)){
          $languagesSeries = Series::Join('series_languages','series_languages.series_id','=','series.id')
          ->where('series_languages.language_id',$langid)->get();

          if(count($languagesSeries) > 0){
            $status = 'true';
          }else{
            $status = 'false';
          }

          $response = array(
              'status'=>$status,
              'Language_name' => $Language->name,
              'Language' => $Language,
              'languagesSeries' => $languagesSeries,
          );
        }

      } catch (\Throwable $th) {
        $response = array(
          'status'=>'false',
          'message'=>$th->getMessage(),
          'nodata' => [],
        );
    }
    return response()->json($response, 200);

    }


    public function LanguageLive(Request $request){

      $langid = $request->langid;
      $Language = Language::where('id', $langid)->first();
      try{

        if(!empty($Language)){
          $languagesLive = LiveStream::Join('live_languages','live_languages.live_id','=','live_streams.id')
          ->where('live_languages.language_id',$langid)->get();
          if(count($languagesLive) > 0){
            $status = 'true';
          }else{
            $status = 'false';
          }
          $response = array(
              'status'=> $status,
              'Language_name' => $Language->name,
              'Language' => $Language,
              'languagesLive' => $languagesLive,
          );
        }

      } catch (\Throwable $th) {
        $response = array(
          'status'=>'false',
          'message'=>$th->getMessage(),
          'nodata' => [],
        );
    }
    return response()->json($response, 200);

    }



    public function LanguageAudio(Request $request){

      $langid = $request->langid;
      $Language = Language::where('id', $langid)->first();
      try{

        if(!empty($Language)){

          $LanguagesAudio = Audio::Join('audio_languages','audio_languages.audio_id','=','audios.id')
          ->where('audio_languages.language_id',$langid)->get();

          if(count($LanguagesAudio) > 0){
            $status = 'true';
          }else{
            $status = 'false';
          }
          $response = array(
              'status'=> $status,
              'Language_name' => $Language->name,
              'Language' => $Language,
              'languagesLive' => $languagesLive,
          );
        }

      } catch (\Throwable $th) {
        $response = array(
          'status'=>'false',
          'message'=>$th->getMessage(),
          'nodata' => [],
        );
    }
    return response()->json($response, 200);

    }

    public function TV_Language(Request $request)
    {

      $Language_id = $request->Language_id;

      $Language = Language::where('id', $Language_id)->first();

        try{

            $languagesVideo = Video::Join('languagevideos','languagevideos.video_id','=','videos.id')
                              ->where('languagevideos.language_id',$Language_id)->get();

            $languagesLive = LiveStream::Join('live_languages','live_languages.live_id','=','live_streams.id')
                                  ->where('live_languages.language_id',$Language_id)->get();

            $languagesSeries = Series::Join('series_languages','series_languages.series_id','=','series.id')
                                ->where('series_languages.language_id',$Language_id)->get();

            $LanguagesAudio = Audio::Join('audio_languages','audio_languages.audio_id','=','audio.id')
                                ->where('audio_languages.language_id',$Language_id)->get();

            $response = array(
                'status'=> 'true',
                'language_name'    => $Language ? $Language->name : "No data found",
                'Language'         => $Language ,
                'languages_Video'  => $languagesVideo ,
                'languages_Live'   => $languagesLive,
                'languages_Series' => $languagesSeries,
                'Languages_Audio'  => $LanguagesAudio ,
            );

        }
        catch (\Throwable $th) {

            $response = array(
              'status'=>'false',
              'message'=>$th->getMessage(),
            );

        }

      return response()->json($response, 200);

    }

    public function Page(Request $request)
    {
      $page_id = $request->page_id;
     $pages = Page::where('id', '=', $page_id)->where('active', '=', 1)->get()->map(function ($item) {
       $item['page_url'] = URL::to('page').'/'.$item->slug;
       return $item;
     });
     $response = array(
       'status' => 'true',
       'pages' => $pages
     );
     return response()->json($response, 200);
    }
    public function TV_Search(Request $request)
    {

      $search_value =  $request['search'];


      try{

        $videos_count = Video::where('title', 'LIKE', '%'.$search_value.'%')->count();
        $videocategorie_count = VideoCategory::where('name', 'LIKE', '%'.$search_value.'%')->count();
        $videolanguage_count = Language::where('name', 'LIKE', '%'.$search_value.'%')->count();
        $videoartist_count = Artist::where('artist_name', 'LIKE', '%'.$search_value.'%')->count();

        $albums_count = AudioAlbums::where('albumname', 'LIKE', '%'.$search_value.'%')->count();

        $audios_count = Audio::where('title', 'LIKE', '%'.$search_value.'%')->count();
        $audiocategories_count = AudioCategory::where('name', 'LIKE', '%'.$search_value.'%')->count();
        $audiolanguages_count = Language::where('name', 'LIKE', '%'.$search_value.'%')->count();
        $audioartists_count = Artist::where('artist_name', 'LIKE', '%'.$search_value.'%')->count();


        $liveStream_count = LiveStream::where('title', 'LIKE', '%'.$search_value.'%')->count();
        $LiveCategory_count = LiveCategory::where('name', 'LIKE', '%'.$search_value.'%')->count();
        $LiveLanguage_count = Language::where('name', 'LIKE', '%'.$search_value.'%')->count();

        $series_count = Series::where('title', 'LIKE', '%'.$search_value.'%')->count();
        $seriescategorie_count = VideoCategory::where('name', 'LIKE', '%'.$search_value.'%')->count();
        $serieslanguage_count = Language::where('name', 'LIKE', '%'.$search_value.'%')->count();
        $seriesartist_count = Artist::where('artist_name', 'LIKE', '%'.$search_value.'%')->count();

        if ($liveStream_count > 0) {
          $LiveStream = LiveStream::where('title', 'LIKE', '%'.$search_value.'%')->where('status','=',1)->where('active','=',1)->orderBy('created_at', 'desc')->get()->map(function ($item) {
            $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
            $item['player_image_url'] = URL::to('/').'/public/uploads/images/'.$item->player_image;
            return $item;
          });

          } else {
            $LiveStream = [];
          }
        if ($audios_count > 0) {
          $audios = Audio::where('title', 'LIKE', '%'.$search_value.'%')->where('status','=',1)->where('active','=',1)->orderBy('created_at', 'desc')->get()->map(function ($item) {
            $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
            $item['player_image_url'] = URL::to('/').'/public/uploads/images/'.$item->player_image;
            return $item;
          });

          } else {
            $audios = [];
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
          $item['player_image_url'] = URL::to('/').'/public/uploads/images/'.$item->player_image;
          return $item;
        });

        } else {
          $videos = [];
        }

        if ($series_count > 0) {
          $series = Series::where('title', 'LIKE', '%'.$search_value.'%')->where('active','=',1)->orderBy('created_at', 'desc')->get()->map(function ($item) {
          $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
          $item['player_image_url'] = URL::to('/').'/public/uploads/images/'.$item->player_image;

          return $item;
        });

        } else {
          $series = [];
        }
// video management
        $videoData = array();

        $videocategories = VideoCategory::where('name', 'LIKE', '%'.$search_value.'%')->get()->toArray();
        $videolanguages = Language::where('name', 'LIKE', '%'.$search_value.'%')->get()->toArray();
        $videoartists = Artist::where('artist_name', 'LIKE', '%'.$search_value.'%')->get()->toArray();

        if ($videocategorie_count > 0 || $videolanguage_count > 0 || $videoartist_count > 0) {

        foreach ($videocategories as $key => $videocategory) {
          $videocategoryid = $videocategory['id'];
          $genre_image = $videocategory['image'];
          $videocategories= Video::Join('categoryvideos','categoryvideos.video_id','=','videos.id')
          ->where('categoryvideos.category_id',$videocategoryid)
          ->where('active','=',1)->where('status','=',1)->where('draft','=',1)->orderBy('videos.created_at', 'desc')->get()->map(function ($item) {
            $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
            $item['video_url'] = URL::to('/').'/storage/app/public/';
            $item['category_name'] = VideoCategory::where('id',$item->category_id)->pluck('slug')->first();
            return $item;
          });
          $videoData[] = array(
            'gener_name' =>  VideoCategory::where('id',$videocategoryid)->pluck('name')->first(),
            'home_genre' =>  VideoCategory::where('id',$videocategoryid)->pluck('home_genre')->first(),
            'gener_id' =>  VideoCategory::where('id',$videocategoryid)->pluck('id')->first(),
            "videocategories" => $videocategories
          );
        }
        foreach ($videolanguages as $key => $videolanguage) {
          $videolanguageid = $videolanguage['id'];
          $genre_image = $videolanguage['language_image'];
          $videolanguages= Video::Join('languagevideos','languagevideos.video_id','=','videos.id')
          ->where('languagevideos.language_id',$videolanguageid)
          ->where('active','=',1)->where('status','=',1)->where('draft','=',1)->orderBy('videos.created_at', 'desc')->get()->map(function ($item) {
            $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
            $item['video_url'] = URL::to('/').'/storage/app/public/';
            return $item;
          });
          $videoData[] = array(
            'gener_name' =>  Language::where('id',$videolanguageid)->pluck('name')->first(),
            'gener_id' =>  Language::where('id',$videolanguageid)->pluck('id')->first(),
            "videolanguages" => $videolanguages
          );
        }

        foreach ($videoartists as $key => $videoartist) {
          $videoartistid = $videoartist['id'];
          $genre_image = $videoartist['image'];
          $videoartists= Video::join('video_artists', 'video_artists.video_id', '=', 'videos.id')
          ->where('video_artists.artist_id',$videoartistid)
          ->where('active','=',1)->where('status','=',1)->where('draft','=',1)->orderBy('videos.created_at', 'desc')->get()->map(function ($item) {
            $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
            $item['video_url'] = URL::to('/').'/storage/app/public/';
            return $item;
          });
          $videoData[] = array(
            'gener_name' =>  Artist::where('id',$videoartistid)->pluck('artist_name')->first(),
            'gener_id' =>  Artist::where('id',$videoartistid)->pluck('id')->first(),
            "videoartists" => $videoartists
          );
        }

      }

  //  Audio Management

      $audioData = array();

      $audiocategories = AudioCategory::where('name', 'LIKE', '%'.$search_value.'%')->get()->toArray();
      $audiolanguages = Language::where('name', 'LIKE', '%'.$search_value.'%')->get()->toArray();
      $audioartists = Artist::where('artist_name', 'LIKE', '%'.$search_value.'%')->get()->toArray();

      if ($audiocategories_count > 0 || $audiolanguages_count > 0 || $audioartists_count > 0) {

        foreach ($audiocategories as $key => $audiocategory) {
          $audiocategoryid = $audiocategory['id'];
          $genre_image = $audiocategory['image'];

          $audiocategories = Audio::Join('category_audios','category_audios.audio_id','=','audio.id')
          ->where('category_audios.category_id',$audiocategoryid)
          ->orderBy('audio.created_at', 'desc')
          ->get()->map(function ($item) {
            $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
            // $item['auido_url'] = URL::to('/').'/storage/app/public/';
            $item['category_name'] = AudioCategory::where('id',$item->category_id)->pluck('slug')->first();

            return $item;
          });
        $audioData[] = array(
          'gener_name' =>  AudioCategory::where('id',$audiocategoryid)->pluck('name')->first(),
          'gener_id' =>  AudioCategory::where('id',$audiocategoryid)->pluck('id')->first(),
          "audiocategories" => $audiocategories
        );
      }
      foreach ($audiolanguages as $key => $audiolanguage) {
        $audiolanguageid = $audiolanguage['id'];
        $genre_image = $audiolanguage['language_image'];
        $audiolanguages= Audio::Join('audio_languages','audio_languages.audio_id','=','audio.id')
        ->where('audio_languages.language_id',$audiolanguageid)
        ->where('active','=',1)->where('status','=',1)->orderBy('audio.created_at', 'desc')->get()->map(function ($item) {
          $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
          return $item;
        });
        $audioData[] = array(
          'gener_name' =>  Language::where('id',$audiolanguageid)->pluck('name')->first(),
          'gener_id' =>  Language::where('id',$audiolanguageid)->pluck('id')->first(),
          "audiolanguages" => $audiolanguages
        );
      }

      foreach ($audioartists as $key => $audioartist) {
        $audioartistid = $audioartist['id'];
        $genre_image = $audioartist['image'];
        $audioartists= Audio::join('audio_artists', 'audio_artists.audio_id', '=', 'audio.id')
        ->where('audio_artists.artist_id',$audioartistid)
        ->where('active','=',1)->where('status','=',1)->orderBy('audio.created_at', 'desc')->get()->map(function ($item) {
          $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
          return $item;
        });
        $audioData[] = array(
          'gener_name' =>  Artist::where('id',$audioartistid)->pluck('artist_name')->first(),
          'gener_id' =>  Artist::where('id',$audioartistid)->pluck('id')->first(),
          "audioartists" => $audioartists
        );
      }

    }



  //  Series Management

  $seriesData = array();

  $seriescategories = VideoCategory::where('name', 'LIKE', '%'.$search_value.'%')->get()->toArray();
  $serieslanguages = Language::where('name', 'LIKE', '%'.$search_value.'%')->get()->toArray();
  $seriesartists = Artist::where('artist_name', 'LIKE', '%'.$search_value.'%')->get()->toArray();

  if ($seriescategorie_count > 0 || $serieslanguage_count > 0 || $seriesartist_count > 0) {

    foreach ($seriescategories as $key => $seriescategorie) {
      $seriescategorieid = $seriescategorie['id'];
      $genre_image = $seriescategorie['image'];

      $seriescategories = Series::Join('series_categories','series_categories.series_id','=','series.id')
      ->where('series_categories.category_id',$seriescategorieid)
      ->where('active','=',1)
      ->orderBy('series.created_at', 'desc')
      ->get()->map(function ($item) {
        $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
        // $item['auido_url'] = URL::to('/').'/storage/app/public/';
        $item['category_name'] = VideoCategory::where('id',$item->category_id)->pluck('slug')->first();

        return $item;
      });
    $seriesData[] = array(
      'gener_name' =>  VideoCategory::where('id',$seriescategorieid)->pluck('name')->first(),
      'gener_id' =>  VideoCategory::where('id',$seriescategorieid)->pluck('id')->first(),
      "seriescategories" => $seriescategories
    );
  }
  foreach ($serieslanguages as $key => $serieslanguage) {
    $serieslanguageid = $serieslanguage['id'];
    $genre_image = $serieslanguage['language_image'];
    $serieslanguage= Series::Join('series_languages','series_languages.series_id','=','series.id')
    ->where('series_languages.language_id',$serieslanguageid)
    ->where('active','=',1)->orderBy('series.created_at', 'desc')->get()->map(function ($item) {
      $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
      return $item;
    });
    $seriesData[] = array(
      'gener_name' =>  Language::where('id',$serieslanguageid)->pluck('name')->first(),
      'gener_id' =>  Language::where('id',$serieslanguageid)->pluck('id')->first(),
      "serieslanguage" => $serieslanguage
    );
  }

  foreach ($seriesartists as $key => $seriesartist) {
    $seriesartistid = $seriesartist['id'];
    $genre_image = $seriesartist['image'];
    $seriesartists= Series::join('series_artists', 'series_artists.series_id', '=', 'series.id')
    ->where('series_artists.artist_id',$seriesartistid)
    ->where('active','=',1)->orderBy('series.created_at', 'desc')->get()->map(function ($item) {
      $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
      return $item;
    });
    $seriesData[] = array(
      'gener_name' =>  Artist::where('id',$seriesartistid)->pluck('artist_name')->first(),
      'gener_id' =>  Artist::where('id',$seriesartistid)->pluck('id')->first(),
      "seriesartists" => $seriesartists
    );
  }

}

// Live Management
$liveData = array();
$livecategories = LiveCategory::where('name', 'LIKE', '%'.$search_value.'%')->get()->toArray();
$livelanguages = Language::where('name', 'LIKE', '%'.$search_value.'%')->get()->toArray();


if($LiveCategory_count > 0 || $LiveLanguage_count > 0){


  foreach ($livecategories as $key => $livecategory) {

    $livecategoryid = $livecategory['id'];
    $genre_image = $livecategory['image'];
    $live_category= LiveStream::Join('livecategories','livecategories.live_id','=','live_streams.id')
      ->where('livecategories.category_id',$livecategoryid)
      ->where('active','=',1)->where('status','=',1)
      ->orderBy('live_streams.created_at', 'desc')->get()->map(function ($item) {

        $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
        $item['player_image_url'] = URL::to('/').'/public/uploads/images/'.$item->player_image;
        $item['Tv_image_url'] = URL::to('/').'/public/uploads/images/'.$item->Tv_live_image;

        $item['category_name'] = LiveCategory::where('id',$item->category_id)->pluck('slug')->first();
        $item['category_order'] = LiveCategory::where('id',$item->category_id)->pluck('order')->first();

        return $item;
      });
      $liveData[] = array(
        'gener_name' =>  LiveCategory::where('id',$livecategoryid)->pluck('name')->first(),
        'gener_id' =>  LiveCategory::where('id',$livecategoryid)->pluck('id')->first(),
        "live_category" => $live_category,
      );
      }

      foreach ($livelanguages as $key => $livelanguage) {
      $livelanguageid = $livelanguage['id'];
      $genre_image = $livelanguage['language_image'];
      $livelanguages= LiveStream::Join('live_languages','live_languages.live_id','=','live_streams.id')
      ->where('live_languages.language_id',$livelanguageid)
      ->where('active','=',1)->orderBy('live_streams.created_at', 'desc')->get()->map(function ($item) {
        $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
        return $item;
      });
      $liveData[] = array(
        'gener_name' =>  Language::where('id',$livelanguage)->pluck('name')->first(),
        'gener_id' =>  Language::where('id',$livelanguage)->pluck('id')->first(),
        "livelanguages" => $livelanguages,
      );

      }
    }

            $response = array(
                'status'=> 'true',
                'audios'         => $audios ,
                'albums'  => $albums ,
                'videos'   => $videos,
                'series' => $series,
                'livestream'  => $LiveStream ,
                'videoData'  => $videoData ,
                'audioData'  => $audioData ,
                'seriesData'  => $seriesData ,
                'liveData'  => $liveData ,


            );

        }
        catch (\Throwable $th) {

            $response = array(
              'status'=>'false',
              'message'=>$th->getMessage(),
            );

        }

      return response()->json($response, 200);
    }

    public function TVQRLogin(Request $request)
    {

      $email =  $request['email'];
      $password =  $request['password'];

      try{

        $user = User::where('email',$email)->first();

        if($user->role == 'subscriber'){

          $Subscription = Subscription::where('user_id',$user->id)->orderBy('created_at', 'DESC')->first();
          $Subscription = Subscription::Join('subscription_plans','subscription_plans.plan_id','=','subscriptions.stripe_plan')
          ->where('subscriptions.user_id',$user->id)
          ->orderBy('subscriptions.created_at', 'desc')->first();

          $plans_name = $Subscription->plans_name;
          $plan_ends_at = $Subscription->ends_at;

        }else{
          $plans_name = '';
          $plan_ends_at = '';
        }
            $response = array(
                'status'=> 'true',
                'message' => 'Logged In Successfully',
                'user_details'=> $user,
                'plans_name'=>$plans_name,
                'plan_ends_at'=>$plan_ends_at,
                'avatar'=>URL::to('/').'/public/uploads/avatars/'.$user->avatar
            );

        }
        catch (\Throwable $th) {

            $response = array(
              'status'=>'false',
              'message'=>$th->getMessage(),
            );

        }

      return response()->json($response, 200);
    }

    public function TVCodeVerification(Request $request)
    {

      try{

        TVLoginCode::create([
          'email'    => $request->email,
          'tv_code'  => $request->tv_code,
          'status'   => 0,
       ]);

        $response = array(
            'status'=> 'true',
            'message' => 'Added verfication code',
            'tv_code' => $request->tv_code,
        );

        }
        catch (\Throwable $th) {

            $response = array(
              'status'=>'false',
              'message'=>$th->getMessage(),
            );

        }

      return response()->json($response, 200);
    }

    public function TVCodeLogin(Request $request)
    {

      $tv_code =  $request['tv_code'];
      $uniqueId =  $request['uniqueId'];

      try{
        $TVLoginCodecount = TVLoginCode::where('email',$request->email)->count();
        if($TVLoginCodecount < 5){

        
        TVLoginCode::where('tv_code',$tv_code)->orderBy('created_at', 'DESC')->first()
        ->update([
           'status'  => 1,
           'tv_name'  => $request->tv_name,
            'uniqueId' =>  $request['uniqueId'],
        ]);
        $TVLoginCode = TVLoginCode::where('tv_code',$tv_code)->where('status',1)->orderBy('created_at', 'DESC')->first();

        if(!empty($TVLoginCode)){

        $user = User::where('email',$TVLoginCode->email)->first();
        if($user->role == 'subscriber'){

          $Subscription = Subscription::where('user_id',$user->id)->orderBy('created_at', 'DESC')->first();
          $Subscription = Subscription::Join('subscription_plans','subscription_plans.plan_id','=','subscriptions.stripe_plan')
          ->where('subscriptions.user_id',$user->id)
          ->orderBy('subscriptions.created_at', 'desc')->first();

          $plans_name = $Subscription->plans_name;
          $plan_ends_at = $Subscription->ends_at;

        }else{
          $plans_name = '';
          $plan_ends_at = '';
        }

      }
          $response = array(
              'status'=> 'true',
              'message' => 'Logged In Successfully',
              'user_details'=> $user,
              'plans_name'=>$plans_name,
              'plan_ends_at'=>$plan_ends_at,
              'tv_code'=>$tv_code,
              'uniqueId'=>$request['uniqueId'],
              'avatar'=>URL::to('/').'/public/uploads/avatars/'.$user->avatar,
              'Count_User' => $TVLoginCodecount,

          );
         } else{

            $response = array(
              'status'=> 'false',
              'message' => 'User Count Exited',
              'Count_User' => $TVLoginCodecount,
          );
          }
        }
        catch (\Throwable $th) {

            $response = array(
              'status'=>'false',
              'message'=>$th->getMessage(),
            );

        }

      return response()->json($response, 200);
    }

    public function TVLogout(Request $request)
    {

      try{

        $TVLoginCode = TVLoginCode::where('email',$request->email)->where('status',1)->orderBy('created_at', 'DESC')->first();

        $TVLoginCode=TVLoginCode::where('email',$request->email)->where('status',1)->orderBy('created_at', 'DESC')->delete();

        // TVLoginCode::where('email',$request->email)->where('status',1)->orderBy('created_at', 'DESC')->first()
        // ->update([
        //    'status'  => 0,
        // ]);

        $response = array(
            'status'=> 'true',
            'message' => 'Logged Out Successfully',
        );

        }
        catch (\Throwable $th) {

            $response = array(
              'status'=>'false',
              'message'=>$th->getMessage(),
            );

        }

      return response()->json($response, 200);
    }

  public function TVAlphaNumeric(Request $request)
  {

    try{
      $length = 2;
      $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';

      $unique_symbols = substr(str_shuffle($data), 0, $length);
      // $unique_symbols = substr(str_shuffle($data), 0, 8);
          $response = array(
            'status'=> 'true',
            'unique_symbols' => $unique_symbols,
        );
    }
      catch (\Throwable $th) {

      $response = array(
        'status'=>'false',
        'message'=>$th->getMessage(),
      );

  }

return response()->json($response, 200);


}


public function TvUniqueCodeLogin(Request $request)
{

  $uniqueId =  $request['uniqueId'];

  try{

    $TVLoginCode = TVLoginCode::where('uniqueId',$uniqueId)->where('status',1)->first();

    if(!empty($TVLoginCode)){

    $user = User::where('email',$TVLoginCode->email)->first();
    if($user->role == 'subscriber'){

      $Subscription = Subscription::where('user_id',$user->id)->orderBy('created_at', 'DESC')->first();
      $Subscription = Subscription::Join('subscription_plans','subscription_plans.plan_id','=','subscriptions.stripe_plan')
      ->where('subscriptions.user_id',$user->id)
      ->orderBy('subscriptions.created_at', 'desc')->first();

      $plans_name = $Subscription->plans_name;
      $plan_ends_at = $Subscription->ends_at;

    }else{
      $plans_name = '';
      $plan_ends_at = '';
    }

  }
      $response = array(
          'status'=> 'true',
          'message' => 'Logged In Successfully',
          'user_details'=> $user,
          'plans_name'=>$plans_name,
          'plan_ends_at'=>$plan_ends_at,
          'uniqueId'=>$request['uniqueId'],
          'avatar'=>URL::to('/').'/public/uploads/avatars/'.$user->avatar
      );

    }
    catch (\Throwable $th) {

        $response = array(
          'status'=>'false',
          'message'=>$th->getMessage(),
        );
    }

  return response()->json($response, 200);
}

public function Paystack_VideoRent_Paymentverify ( Request $request )
  {
      try {

          $setting = Setting::first();
          $ppv_hours = $setting->ppv_hours;

          $d = new \DateTime('now');
          $now = $d->format('Y-m-d h:i:s a');
          $time = date('h:i:s', strtotime($now));
          $to_time = date('Y-m-d h:i:s a',strtotime('+'.$ppv_hours.' hour',strtotime($now)));

              // Verify Payment

          $reference_code = $request->reference_id;

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
          $purchase->user_id      = $request->user_id ;
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
                  "status"  => 'false' ,
                  "message" => $err
              );
          }
          else {                      // Success
              $response = array(
                  "status"  => 'true' ,
                  "message" => "Payment done! Successfully for PPV video-id = " .$request->video_id ,
              );
          }

      } catch (\Exception $e) {

          $response = array(
              "status"  => 'false' ,
              "message" => $e->getMessage(),
          );
      }

      return response()->json($response, 200);
  }

  public function Paystack_liveRent_Paymentverify( Request $request )
  {
      try {

          $setting = Setting::first();
          $ppv_hours = $setting->ppv_hours;

          $to_time = ppv_expirytime_started();

               // Verify Payment

          $reference_code = $request->reference_id;

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
          $purchase->user_id       =  $request->user_id ;
          $purchase->live_id       =  $request->live_id ;
          $purchase->total_amount  =  $payment_result['data']['amount'] ;
          $purchase->admin_commssion = $admin_commssion;
          $purchase->moderator_commssion = $moderator_commssion;
          $purchase->status = 'active';
          $purchase->to_time = $to_time;
          $purchase->moderator_id = $moderator_id;
          $purchase->save();

          $livepurchase = new LivePurchase;
          $livepurchase->user_id  =  $request->user_id ;
          $livepurchase->video_id = $request->live_id;
          $livepurchase->to_time = $to_time;
          $livepurchase->expired_date = $to_time;
          $livepurchase->amount = $payment_result['data']['amount'] ;
          $livepurchase->from_time = Carbon::now()->format('Y-m-d H:i:s');
          $livepurchase->unseen_expiry_date = ppv_expirytime_notstarted();
          $livepurchase->status = 1;
          $livepurchase->save();

          if ($err) {                 // Error
              $response = array(
                  "status"  => 'false' ,
                  "message" => $err
              );
          }
          else {                      // Success
              $response = array(
                  "status"  => 'true' ,
                  "message" => "Payment done! Successfully for PPV Live-id = " .$request->live_id ,
              );
          }

      } catch (\Exception $e) {

          $response = array(
              "status"  => 'false' ,
              "message" => $e->getMessage(),
         );
      }
      return response()->json($response, 200);
  }



public function CheckBecomeSubscription(Request $request)
{

  $user_id =  $request['user_id'];

  try{

    $Subscription = Subscription::where('user_id',$user_id)->whereDate('created_at','=',\Carbon\Carbon::now()->today())->first();

    if(!empty($Subscription)){

    $user = User::where('id',$Subscription->user_id)->first();

    if($user->role == 'subscriber'){
      $role = $user->role;
    }else{
      $role = $user->role;
    }

    $response = array(
      'status'=> 'true',
      'message' => 'Verfied Become Subscription',
      'user_role'=> $role,
      'user_details'=> $user,
  );

  }else{

      $response = array(
        'status'=> 'true',
        'message' => 'Verfied Become Subscription',
        'user_role'=> '',
        'user_details'=> '',
    );
  }


    }
    catch (\Throwable $th) {

        $response = array(
          'status'=>'false',
          'message'=>$th->getMessage(),
        );

    }

  return response()->json($response, 200);
}
 
public function test( $page_no)
{

  $getCategories = Video::Paginate( 20, ['*'], 'page', $page_no );

  return response()->json($getCategories,200);

}


public function VideoSchedules(Request $request)
{

  try{

    $video_schedules = VideoSchedules::get();

    $response = array(
      'status'=> 'true',
      'message' => 'Video Schedules Retrived Data',
      'video_schedules'=> $video_schedules,
  );


    }
    catch (\Throwable $th) {

        $response = array(
          'status'=>'false',
          'message'=>$th->getMessage(),
        );

    }

  return response()->json($response, 200);
}



public function ScheduledVideos(Request $request)
{

  try{

    $scheduled_videos = ScheduleVideos::get();

    $response = array(
      'status'=> 'true',
      'message' => 'Scheduled Videos Retrived Data',
      'scheduled_videos'=> $scheduled_videos,
  );


    }
    catch (\Throwable $th) {

        $response = array(
          'status'=>'false',
          'message'=>$th->getMessage(),
        );

    }

  return response()->json($response, 200);
}


public function ReScheduledVideos(Request $request)
{

  try{

    $rescheduled_videos = ReSchedule::get();

    $response = array(
      'status'=> 'true',
      'message' => 'ReScheduled Videos Retrived Data',
      'rescheduled_videos'=> $rescheduled_videos,
  );


    }
    catch (\Throwable $th) {

        $response = array(
          'status'=>'false',
          'message'=>$th->getMessage(),
        );

    }

  return response()->json($response, 200);
}

public function Video_Schedules(Request $request)
{

  try{

    $Schedule_id =  $request['schedule_id'];

    $VideoSchedules = VideoSchedules::where("id", "=", $Schedule_id)
    ->first(); 

    $response = array(
      'status'=> 'true',
      'message' => 'Video Schedules Retrived Data',
      'VideoSchedules'=> $VideoSchedules,
  );


    }
    catch (\Throwable $th) {

        $response = array(
          'status'=>'false',
          'message'=>$th->getMessage(),
        );

    }

  return response()->json($response, 200);
}


public function Scheduled_Videos(Request $request)
{

  try{

    $Schedule_id =  $request['schedule_id'];
    $shedule_date =  $request['shedule_date'];

    $VideoSchedules = VideoSchedules::where("id", "=", $Schedule_id)
    ->first(); 
    $scheduled_videos = ScheduleVideos::where('schedule_id',$Schedule_id)->where('shedule_date',$shedule_date)->get();

    $response = array(
      'status'=> 'true',
      'message' => 'Schedule Videos Videos Retrived Data',
      'VideoSchedules'=> $VideoSchedules,
      'scheduled_videos'=> $scheduled_videos,

  );


    }
    catch (\Throwable $th) {

        $response = array(
          'status'=>'false',
          'message'=>$th->getMessage(),
        );

    }

  return response()->json($response, 200);
}


public function ReScheduled_Videos(Request $request)
{

  try{

    $Schedule_id =  $request['schedule_id'];
    $reschedule_date =  $request['reschedule_date'];

    $VideoSchedules = VideoSchedules::where("id", "=", $Schedule_id)
    ->first(); 
    $scheduled_videos = ReScheduled::where('schedule_id',$Schedule_id)->where('reschedule_date',$reschedule_date)->get();

    $response = array(
      'status'=> 'true',
      'message' => 'ReScheduled Videos Retrived Data',
      'VideoSchedules'=> $VideoSchedules,
  );


    }
    catch (\Throwable $th) {

        $response = array(
          'status'=>'false',
          'message'=>$th->getMessage(),
        );

    }

  return response()->json($response, 200);
}


public function TvQRCodeLogin(Request $request)
{

  $tv_code =  $request['tv_qrcode'];
  $uniqueId =  $request['uniqueId'];
  $email =  $request['email'];

  try{
    
    $TVLoginCode = TVLoginCode::where('tv_code',$tv_code)->where('status',1)->first();
    $TVLoginCodecount = TVLoginCode::where('email',$email)->where('status',1)->count();

    if($TVLoginCodecount < 5){
    TVLoginCode::create([
      'email'    => $request->email,
      'tv_code'  => $request->tv_qrcode,
      'uniqueId'  => $request->uniqueId,
      'tv_name'  => $request->tv_name,
      'type'  => 'QRScan',
      'status'   => 1,
   ]);
 

    $TVLoginCode = TVLoginCode::where('tv_code',$tv_code)->where('status',1)->first();

    if(!empty($TVLoginCode)){

    $user = User::where('email',$TVLoginCode->email)->first();
    if($user->role == 'subscriber'){

      $Subscription = Subscription::where('user_id',$user->id)->orderBy('created_at', 'DESC')->first();
      $Subscription = Subscription::Join('subscription_plans','subscription_plans.plan_id','=','subscriptions.stripe_plan')
      ->where('subscriptions.user_id',$user->id)
      ->orderBy('subscriptions.created_at', 'desc')->first();

      $plans_name = $Subscription->plans_name;
      $plan_ends_at = $Subscription->ends_at;

    }else{
      $plans_name = '';
      $plan_ends_at = '';
    }

  }
      $response = array(
          'status'=> 'true',
          'message' => 'Logged In Successfully',
          'user_details'=> $user,
          'plans_name'=>$plans_name,
          'plan_ends_at'=>$plan_ends_at,
          'tv_code'=>$tv_code,
          'uniqueId'=>$request['uniqueId'],
          'avatar'=>URL::to('/').'/public/uploads/avatars/'.$user->avatar,
          'Count_User' => $TVLoginCodecount,

      );
    }else{

      $response = array(
        'status'=> 'false',
        'message' => 'User Count Exited',
        'Count_User' => $TVLoginCodecount,
    );
    }
  }

    catch (\Throwable $th) {

        $response = array(
          'status'=>'false',
          'message'=>$th->getMessage(),
        );

    }

  return response()->json($response, 200);
}


public function TVQRCodeLogout(Request $request)
{

  try{

    $TVLoginCode = TVLoginCode::where('email',$request->email)->where('status',1)->orderBy('created_at', 'DESC')->first();

    $TVLoginCode=TVLoginCode::where('email',$request->email)->where('status',1)->orderBy('created_at', 'DESC')->delete();

    $response = array(
        'status'=> 'true',
        'message' => 'Logged Out Successfully',
    );

    }
    catch (\Throwable $th) {

        $response = array(
          'status'=>'false',
          'message'=>$th->getMessage(),
        );

    }

  return response()->json($response, 200);
}
 
  public function site_theme_setting()
  {
      try {

          $Site_theme_setting = SiteTheme::get()->map(function ($item) {
            $item['dark_mode_logo_url'] = URL::to('/public/uploads/settings/'.$item->dark_mode_logo);
            $item['light_mode_logo_url'] = URL::to('/public/uploads/settings/'.$item->light_mode_logo);
            return $item;
          });;

        $response = array(
          'status'=> 'true',
          'message' => 'Retrieved Logo Site theme setting Successfully !!',
          'Site_theme_setting'=> $Site_theme_setting,
        );

      } 
      catch (\Throwable $th) {

        $response = array(
          'status'=>'false',
          'message'=>$th->getMessage(),
        );

      }

      return response()->json($response, 200);
  }

  public function TVLoggedDetails(Request $request)
  {
    try{

      $TVLoginDetails = TVLoginCode::where('email',$request->email)->where('status',1)->get();

      $response = array(
          'status'=> 'true',
          'message' => 'Existing Users',
          'TVLoginDetails' => $TVLoginDetails
      );

      }
      catch (\Throwable $th) {

          $response = array(
            'status'=>'false',
            'message'=>$th->getMessage(),
          );

      }
    return response()->json($response, 200);
  }


  
public function QRCodeMobileLogin(Request $request)
{

  $tv_code =  $request['tv_code'];
  $uniqueId =  $request['uniqueId'];
  $email =  $request['email'];

  try{
    
    $TVLoginCodecount = TVLoginCode::where('email',$email)->where('status',1)->count();

    if($TVLoginCodecount < 5){

    TVLoginCode::create([
      'email'    => $request->email,
      'tv_code'  => $request->tv_code,
      'uniqueId'  => $request->uniqueId,
      'type'  => 'QRScan',
      'status'   => 1,
   ]);
 

    $TVLoginCode = TVLoginCode::where('tv_code',$request->tv_code)->where('status',1)->orderBy('created_at', 'DESC')->first();

    if(!empty($TVLoginCode)){

    $user = User::where('email',$TVLoginCode->email)->first();
    if($user->role == 'subscriber'){

      $Subscription = Subscription::where('user_id',$user->id)->orderBy('created_at', 'DESC')->first();
      $Subscription = Subscription::Join('subscription_plans','subscription_plans.plan_id','=','subscriptions.stripe_plan')
      ->where('subscriptions.user_id',$user->id)
      ->orderBy('subscriptions.created_at', 'desc')->first();

      $plans_name = $Subscription->plans_name;
      $plan_ends_at = $Subscription->ends_at;

    }else{
      $plans_name = '';
      $plan_ends_at = '';
    }

  }
      $response = array(
          'status'=> 'true',
          'message' => 'Logged In Successfully',
          'user_details'=> $user,
          'plans_name'=>$plans_name,
          'plan_ends_at'=>$plan_ends_at,
          'tv_code'=>$tv_code,
          'uniqueId'=>$request['uniqueId'],
          'avatar'=>URL::to('/').'/public/uploads/avatars/'.$user->avatar,
          'Count_User' => $TVLoginCodecount,

      );
    }else{

      $response = array(
        'status'=> 'false',
        'message' => 'User Count Exited',
        'Count_User' => $TVLoginCodecount,
    );
    }
  }

    catch (\Throwable $th) {

        $response = array(
          'status'=>'false',
          'message'=>$th->getMessage(),
        );

    }

  return response()->json($response, 200);
}


public function QRCodeMobileLogout(Request $request)
{

  try{

    $TVLoginCode = TVLoginCode::where('email',$request->email)->where('tv_code',$request->tv_code)->where('status',1)->orderBy('created_at', 'DESC')->first();

    $TVLoginCode=TVLoginCode::where('email',$request->email)->where('tv_code',$request->tv_code)->where('status',1)->orderBy('created_at', 'DESC')->delete();

    $response = array(
        'status'=> 'true',
        'message' => 'Logged Out Successfully',
    );

    }
    catch (\Throwable $th) {

        $response = array(
          'status'=>'false',
          'message'=>$th->getMessage(),
        );

    }

  return response()->json($response, 200);
}


  public function comment_store(Request $request)
  {
    try {

        if( $request->source == 'LiveStream_play' ){
          $source = "App\LiveStream";
        }
        elseif( $request->source == 'play_videos' ){
            $source = "App\Video";
        }
        elseif( $request->source == 'play_episode' ){
            $source = "App\Episode";
        }
        elseif( $request->source == 'play_audios' ){
            $source = "App\Audio";
        }
    
        $inputs = array(
            'user_id'   => $request->user_id ,
            'user_role' => User::where('id',$request->user_id)->pluck('role')->first() ,
            'user_name' => User::where('id',$request->user_id)->pluck('username')->first() ,
            'first_letter' => User::where('id',$request->user_id)->pluck('username')->first()  != null ? User::where('id',$request->user_id)->pluck('username')->first() : 'No Name',
            'commenter_type'   => 'App\User' ,
            'commentable_type' => $request->source ,
            'source'      => $source ,
            'source_id'   => $request->source_id ,
            'comment'  => $request->message ,
            'approved' => 1 ,
        );
        
        WebComment::create($inputs);

        $response = array(
          'status'=> 'true',
          'message'  => ucwords('Comment added Successfully !!'),
          'user_id'  => $request->user_id,
          'source_id'=> $request->source_id, 
          'source'   => $source,
        );

    } catch (\Throwable $th) {

        $response = array(
          'status'=>'false',
          'message'=>$th->getMessage(),
        );
    }

    return response()->json($response, 200);
  }

  public function comment_edit(Request $request)
  {
    try {

        $comment_id = $request->comment_id ;

        $comment = WebComment::where($comment_id)->get();

        $response = array(
          'status'=> 'true',
          'message' => ucwords('Comment Message Retrieved Successfully !!'),
          'comment' => $comment ,
        );

    } catch (\Throwable $th) {
      
        $response = array(
          'status'=>'false',
          'message'=>$th->getMessage(),
        );
    }
    return response()->json($response, 200);
  }

  public function comment_update(Request $request)
  {
    try {

      $comment_id = $request->comment_id ;

      if( $request->source == 'LiveStream_play' ){
          $source = "App\LiveStream";
      }
      elseif( $request->source == 'play_videos' ){
          $source = "App\Video";
      }
      elseif( $request->source == 'play_episode' ){
          $source = "App\Episode";
      }
      elseif( $request->source == 'play_audios' ){
          $source = "App\Audio";
      }

      $inputs = array(
          'user_id'   => $request->user_id ,
          'user_role' => User::where('id',$request->user_id)->pluck('role')->first() ,
          'user_name' => User::where('id',$request->user_id)->pluck('username')->first() ,
          'first_letter' => User::where('id',$request->user_id)->pluck('username')->first()  != null ? User::where('id',$request->user_id)->pluck('username')->first() : 'No Name',
          'commenter_type'   => 'App\User' ,
          'commentable_type' => $request->source ,
          'source'      => $source ,
          'source_id'   => $request->source_id ,
          'comment'     => $request->message ,
          'approved'    => 1 ,
      );

      WebComment::findorfail($comment_id)->update($inputs);

      $response = array(
        'status'=> 'true',
        'message' => ucwords('Comment Message Updated Successfully !!'),
        'user_id'  => $request->user_id,
        'source_id'=> $request->source_id, 
        'source'   => $source,
      );

    } catch (\Throwable $th) {
      
        $response = array(
          'status'=>'false',
          'message'=>$th->getMessage(),
        );
    }

    return response()->json($response, 200);

  }

  public function comment_destroy(Request $request)
  {
    try {

        $comment_id = $request->comment_id ;

        WebComment::where('id',$comment_id)->delete();

        $response = array(
          'status'=> 'true',
          'message' => ucwords('comment essage destroy successfully !!'),
        );

    } catch (\Throwable $th) {

        $response = array(
          'status'=>'false',
          'message'=>$th->getMessage(),
        );
    }

    return response()->json($response, 200);

  }

  public function comment_reply(Request $request)
  {
    try {

        $comment_id = $request->comment_id ;

        if( $request->source == 'LiveStream_play' ){
          $source = "App\LiveStream";
        }
        elseif( $request->source == 'play_videos' ){
            $source = "App\Video";
        }
        elseif( $request->source == 'play_episode' ){
            $source = "App\Episode";
        }
        elseif( $request->source == 'play_audios' ){
            $source = "App\Audio";
        }
    
        $inputs = array(
            'user_id'   => $request->user_id ,
            'user_role' => User::where('id',$request->user_id)->pluck('role')->first() ,
            'user_name' => User::where('id',$request->user_id)->pluck('username')->first() ,
            'first_letter' => User::where('id',$request->user_id)->pluck('username')->first()  != null ? User::where('id',$request->user_id)->pluck('username')->first() : 'No Name',
            'commenter_type'   => 'App\User' ,
            'commentable_type' => $request->source ,
            'source'      =>  $source   ,
            'source_id'   => $request->source_id ,
            'comment'   => $request->message ,
            'child_id'  => $comment_id ,
            'approved' => 1 ,
        );
    
        WebComment::create($inputs);

        $response = array(
          'status'=> 'true',
          'message' => ucwords('Comment Reply Message added Successfully !!'),
          'user_id'  => $request->user_id,
          'source_id'=> $request->source_id, 
          'source'   => $source,
          'child_id'  => $comment_id 
        );

    } catch (\Throwable $th) {

        $response = array(
          'status'=>'false',
          'message'=>$th->getMessage(),
        );
    }
    return response()->json($response, 200);
  }

  public function comment_message(Request $request)
  {

    try {

     $comment = WebComment::with('child_comment')->where('source_id',$request->source_id)
                  ->where('commentable_type',$request->commentable_type)
                  ->whereNull('child_id')->get()
                  ->map(function ($item) {
                    $item['user_image']     = User::where('id',$item->user_id)->pluck('avatar')->first() ;
                    $item['user_image_url'] = URL::to('public/uploads/avatars/'.$item->user_image);
                    $item['user_name'] = User::where('id',$item->user_id)->pluck('username')->first();
                    return $item;
                });

      $response = array(
        'status'=> 'true',
        'message'  => ucwords('Comment Section Message Retrieved Successfully !!'),
        'comment'   => $comment,
      );

    } catch (\Throwable $th) {

          $response = array(
            'status'=>'false',
            'message'=>$th->getMessage(),
          );
    }

    return response()->json($response, 200);
  }

  public function channel_partner(Request $request)
    {
        try {

            $channel_partner = Channel::select('id','channel_name','status','channel_image','channel_slug')
                    ->where('status',1)->latest()->limit(30)->get()->map(function ($item) {
                    $item['image_url'] = URL::to('/public/uploads/albums/'.$item->channel_image);
                    return $item;
                });

            $data = [
                "status" => true,
                "message" => 'Retrieved Channel Partner Section data Successfully' ,
                "channel_partner_count" => count($channel_partner),
                "channel_partner" => $channel_partner,
            ];

        } catch (\Throwable $th) {
            
            $data = array(
                'status' => false,
                'message' => $th->getMessage() ,
            );
        }

        return response()->json($data, 200);
    }

  
  public function ChannelHome(Request $request)
  {
    try{

      $settings = Setting::first();
      $slug = $request->slug;
      $channel = Channel::where('channel_slug',$slug)->first(); 
      $channels = Channel::where('channel_slug',$slug)->get()->map(function ($item) {
        $settings = Setting::first();
  
          if(!empty($item['channel_banner']) && $item['channel_banner'] != null){
            $item['channel_banner'] = $item->channel_banner;
          }else{
            $item['channel_banner'] = URL::to('/public/uploads/images/'.$settings->default_horizontal_image);
          }
                
          if(!empty($item['channel_image']) && $item['channel_image'] != null){
            $item['channel_image'] = $item->channel_image;
          }else{
            $item['channel_image'] = URL::to('/public/uploads/images/'.$settings->default_video_image);
          }
          if(!empty($item['channel_logo']) && $item['channel_logo'] != null){
            $item['channel_logo'] = $item->channel_logo;
          }else{
            $item['channel_logo'] = URL::to('/public/uploads/images/'.$settings->default_video_image);
          }
          return $item;
      });

      $currency = CurrencySetting::first();
          
              $livetreams = LiveStream::where('active', '=', '1')->where('user_id', '=', $channel->id)
              ->where('uploaded_by', '=', 'Channel')->orderBy('created_at', 'DESC')
              ->get();

              $audios = Audio::where('active', '=', '1')->where('user_id', '=', $channel->id)
              ->where('uploaded_by', '=', 'Channel')
              ->orderBy('created_at', 'DESC')
              ->get() ;

              $latest_series = Series::where('active', '=', '1')->where('user_id', '=', $channel->id)
              ->where('uploaded_by', '=', 'Channel')->orderBy('created_at', 'DESC')
              ->get();

              $latest_videos = Video::where('active', '=', '1')->where('status', '=', '1')->where('user_id', '=', $channel->id)
              ->where('uploaded_by', '=', 'Channel')->where('draft', '=', '1')
              ->get();
          $ThumbnailSetting = ThumbnailSetting::first();

          $media_url = URL::to('/channel') . '/' . $slug;
          $facebook_url = 'https://www.facebook.com/sharer/sharer.php?u=' . $media_url;
          $twitter_url = 'https://twitter.com/intent/tweet?text=' . $media_url;

          $response = array(
              'status'=> 'true',
              'latest_video' => $latest_videos,
              'latest_series' => $latest_series,
              'audios' => $audios,
              'livetream' => $livetreams,
              'currency' => $currency,
              'ThumbnailSetting' => $ThumbnailSetting,
              'LiveCategory' => LiveCategory::get(),
              'VideoCategory' => VideoCategory::get(),
              'AudioCategory' => AudioCategory::get(),
              'channel' => $channels,
              'media_url' => $media_url,
              'facebook_url' => $facebook_url,
              'twitter_url' => $twitter_url,

          );
          
              } catch (\Throwable $th) {

                $response = array(
                  'status'=>'false',
                  'message'=>$th->getMessage(),
                );
          }

          return response()->json($response, 200);
      }


      public function ChannelList()
      {
        try{

          $settings = Setting::first();
          $channels = Channel::get(); 

          $channels = Channel::where('status',1)->get()->map(function ($item) {
            $settings = Setting::first();
      
              if(!empty($item['channel_banner']) && $item['channel_banner'] != null){
                $item['channel_banner'] = $item->channel_banner;
              }else{
                $item['channel_banner'] = URL::to('/public/uploads/images/'.$settings->default_horizontal_image);
              }
                    
              if(!empty($item['channel_image']) && $item['channel_image'] != null){
                $item['channel_image'] = $item->channel_image;
              }else{
                $item['channel_image'] = URL::to('/public/uploads/images/'.$settings->default_video_image);
              }
              if(!empty($item['channel_logo']) && $item['channel_logo'] != null){
                $item['channel_logo'] = $item->channel_logo;
              }else{
                $item['channel_logo'] = URL::to('/public/uploads/images/'.$settings->default_video_image);
              }
              return $item;
          });

          $currency = CurrencySetting::first();
          $ThumbnailSetting = ThumbnailSetting::first();
            
              $response = array(
                  'status'=> 'true',
                  'channels' => $channels,
                  'ThumbnailSetting' => $ThumbnailSetting,
                  'currency' => $currency,
              );
              
            } catch (\Throwable $th) {

              $response = array(
                'status'=>'false',
                'message'=>$th->getMessage(),
              );
        }

        return response()->json($response, 200);
          
      }
  

      
    public function channel_category_videos(Request $request)
    {
      try{

        $videosCategory = VideoCategory::find($request->category_id) != null ? VideoCategory::find($request->category_id)->specific_category_videos : array();
         
        $videos_Category = $videosCategory->where('user_id', $request->user_id)->where('uploaded_by' ,'Channel')->all();

        $response = array( 'status'=> 'true','videosCategory' => $videos_Category );
 
      } catch (\Throwable $th) {

        $response = array(
          'status'=>'false',
          'message'=>$th->getMessage(),
        );
    }

    return response()->json($response, 200);
    }

    public function channel_category_series(Request $request)
    {
      try{
        $SeriesCategory = SeriesGenre::find($request->category_id) != null ? SeriesGenre::find($request->category_id)->specific_category_series : array();
        
        $Series_Category = $SeriesCategory->where('user_id', $request->user_id)->where('uploaded_by' ,'Channel')->all();

        $response = array( 'status'=> 'true','SeriesCategory' => $Series_Category );
      } catch (\Throwable $th) {

        $response = array(
          'status'=>'false',
          'message'=>$th->getMessage(),
        );
    }

    return response()->json($response, 200);
    }

    public function channel_category_live(Request $request)
    {
      try{
        $LiveCategory = LiveCategory::find($request->category_id) != null ? LiveCategory::find($request->category_id)->specific_category_live : array();
        
        $Live_Category = $LiveCategory->where('user_id', $request->user_id)->where('uploaded_by' ,'Channel')->all();

        $response = array( 'status'=> 'true','LiveCategory' => $Live_Category );

      } catch (\Throwable $th) {

        $response = array(
          'status'=>'false',
          'message'=>$th->getMessage(),
        );
    }

    return response()->json($response, 200);
    }

    public function channel_category_audios(Request $request)
    {
      try{
        $AudioCategory = AudioCategory::find($request->category_id) != null ? AudioCategory::find($request->category_id)->specific_category_audio : array();

        $Audio_Category = $AudioCategory->where('user_id', $request->user_id)->where('uploaded_by' ,'Channel')->all();

        $response = array('status'=> 'true', 'AudioCategory' => $Audio_Category );

        } catch (\Throwable $th) {

          $response = array(
            'status'=>'false',
            'message'=>$th->getMessage(),
          );
      }

      return response()->json($response, 200);
    }

    
  public function HomeContentPartner(Request $request)
  {

    try {
      $ContentPartner = ModeratorsUser::where('status',1)->get()->map(function ($item) {
      $item['banner'] = URL::to('/public/uploads/moderator_albums/'.$item->banner);
      $item['picture'] = URL::to('/public/uploads/moderator_albums/'.$item->picture);
      return $item;
  });
      $response = array(
        'status'=> 'true',
        'message'  => 'Content Partner section Retrieved Successfully !!',
        'ContentPartner' => $ContentPartner, 
        'order_settings' => OrderHomeSetting::orderBy('order_id', 'asc')->get(), 
        'order_settings_list' => OrderHomeSetting::get(), 
  
      );

    } catch (\Throwable $th) {

          $response = array(
            'status'=>'false',
            'message'=>$th->getMessage(),
          );
    }

    return response()->json($response, 200);
  }


  public function ContentPartnerHome(Request $request)
  {
    try{
      $settings = Setting::first();
      $slug = $request->slug;
      $ModeratorsUserid = ModeratorsUser::where('slug',$slug)->first(); 

      $ModeratorsUser = ModeratorsUser::where('slug',$slug)->get()->map(function ($item) {
      $settings = Setting::first();

        if(!empty($item['banner']) && $item['banner'] != null){
          $item['banner'] = URL::to('/public/uploads/moderator_albums/'.$item->banner);
        }else{
          $item['banner'] = URL::to('/public/uploads/images/'.$settings->default_horizontal_image);
        }
        if(!empty($item['picture']) && $item['picture'] != null){
          $item['picture'] = URL::to('/public/uploads/moderator_albums/'.$item->picture);
        }else{
          $item['picture'] = URL::to('/public/uploads/images/'.$settings->default_video_image);
        }
        return $item;
    });

      $currency = CurrencySetting::first();

              $livetreams = LiveStream::where('active', '=', '1')->where('user_id', '=', $ModeratorsUserid->id)
              ->where('uploaded_by', '=', 'CPP')->orderBy('created_at', 'DESC')
              ->get();

              $audios = Audio::where('active', '=', '1')->where('user_id', '=', $ModeratorsUserid->id)
              ->where('uploaded_by', '=', 'CPP')
              ->orderBy('created_at', 'DESC')
              ->get() ;

              $latest_series = Series::where('active', '=', '1')->where('user_id', '=', $ModeratorsUserid->id)
              ->where('uploaded_by', '=', 'CPP')->orderBy('created_at', 'DESC')
              ->get();

              $latest_videos = Video::where('active', '=', '1')->where('status', '=', '1')->where('user_id', '=', $ModeratorsUserid->id)
              ->where('uploaded_by', '=', 'CPP')->where('draft', '=', '1')
              ->get();
  
          $ThumbnailSetting = ThumbnailSetting::first();

          $media_url = URL::to('/contentpartner') . '/' . $slug;
          $facebook_url = 'https://www.facebook.com/sharer/sharer.php?u=' . $media_url;
          $twitter_url = 'https://twitter.com/intent/tweet?text=' . $media_url;

          $response = array(
              'status'=> 'true',
              'Content_Partner' => $ModeratorsUser,
              'currency' => $currency,
              'latest_video' => $latest_videos,
              'latest_series' => $latest_series,
              'audios' => $audios,
              'livetream' => $livetreams,
              'ThumbnailSetting' => $ThumbnailSetting,
              'LiveCategory' => LiveCategory::get(),
              'VideoCategory' => VideoCategory::get(),
              'AudioCategory' => AudioCategory::get(),
              'media_url' => $media_url,
              'facebook_url' => $facebook_url,
              'twitter_url' => $twitter_url,
          );
          
          } catch (\Throwable $th) {

            $response = array(
              'status'=>'false',
              'message'=>$th->getMessage(),
            );
      }

      return response()->json($response, 200);
      
  }


  
  public function ContentList()
  {

    try{ 
      $settings = Setting::first();
      $ModeratorsUser = ModeratorsUser::get(); 
      $ModeratorsUser = ModeratorsUser::where('status',1)->get()->map(function ($item) {
      $settings = Setting::first();
        if(!empty($item['banner']) && $item['banner'] != null){
          $item['banner'] = URL::to('/public/uploads/moderator_albums/'.$item->banner);
        }else{
          $item['banner'] = URL::to('/public/uploads/images/'.$settings->default_horizontal_image);
        }
        if(!empty($item['picture']) && $item['picture'] != null){
          $item['picture'] = URL::to('/public/uploads/moderator_albums/'.$item->picture);
        }else{
          $item['picture'] = URL::to('/public/uploads/images/'.$settings->default_video_image);
        }
        return $item;
    });
      $currency = CurrencySetting::first();
      $ThumbnailSetting = ThumbnailSetting::first();
        
          $response = array(
              'status'=> 'true',
              'currency' => $currency,
              'ModeratorsUser' => $ModeratorsUser,
              'ThumbnailSetting' => $ThumbnailSetting,
              'Content_Partner' => ModeratorsUser::get(),

          );
          
        } catch (\Throwable $th) {

          $response = array(
            'status'=>'false',
            'message'=>$th->getMessage(),
          );
    }

    return response()->json($response, 200);
      
  }

  public function Content_category_videos(Request $request)
  {
    try{
      $videosCategory = VideoCategory::find($request->category_id) != null ? VideoCategory::find($request->category_id)->specific_category_videos : array();
       
      $videos_Category = $videosCategory->where('user_id', $request->user_id)->where('uploaded_by' ,'CPP')->all();

      $response = array( 'status'=> 'true','videosCategory' => $videos_Category );

    } catch (\Throwable $th) {

            $response = array(
              'status'=>'false',
              'message'=>$th->getMessage(),
            );
      }

      return response()->json($response, 200);
  }

  public function Content_category_series(Request $request)
  {
    try{
      $SeriesCategory = SeriesGenre::find($request->category_id) != null ? SeriesGenre::find($request->category_id)->specific_category_series : array();
      
      $Series_Category = $SeriesCategory->where('user_id', $request->user_id)->where('uploaded_by' ,'CPP')->all();

      $response = array( 'status'=> 'true','SeriesCategory' => $Series_Category );


        } catch (\Throwable $th) {

          $response = array(
            'status'=>'false',
            'message'=>$th->getMessage(),
          );
    }

    return response()->json($response, 200);
  }

  public function Content_category_live(Request $request)
  {
    try{
      $LiveCategory = LiveCategory::find($request->category_id) != null ? LiveCategory::find($request->category_id)->specific_category_live : array();
      
      $Live_Category = $LiveCategory->where('user_id', $request->user_id)->where('uploaded_by' ,'CPP')->all();
      $response = array('status'=> 'true', 'LiveCategory' => $Live_Category );


    } catch (\Throwable $th) {

          $response = array(
            'status'=>'false',
            'message'=>$th->getMessage(),
          );
    }

    return response()->json($response, 200);
  }

  public function Content_category_audios(Request $request)
  {
    try{

      $AudioCategory = AudioCategory::find($request->category_id) != null ? AudioCategory::find($request->category_id)->specific_category_audio : array();
      
      $Audio_Category = $AudioCategory->where('user_id', $request->user_id)->where('uploaded_by' ,'CPP')->all();

      $response = array( 'status'=> 'true','AudioCategory' => $Audio_Category );

        } catch (\Throwable $th) {

          $response = array(
            'status'=>'false',
            'message'=>$th->getMessage(),
          );
    }

    return response()->json($response, 200);
  }

  public function all_videos()
  {
    try {
          // Video Category 

                $VideoCategory = VideoCategory::select('id','slug','in_home')->where('in_home','=',1)
                                ->get()->map(function ($item) {
                                    $item['redirect_url']  = URL::to('videos/category/'.$item->slug);
                                    $item['source_data']   = 'video_category';
                                    return $item;
                                });

            // Series Genres

                $SeriesGenre = SeriesGenre::select('id','slug','in_home')
                                ->get()->map(function ($item) {
                                    $item['redirect_url']  = URL::to('series/category/'.$item->slug);
                                    $item['source_data']  = 'SeriesGenre';
                                    return $item;
                                });
                                

            // Fetch all OrderHomeSetting list

                $OrderHomeSetting = OrderHomeSetting::get(); 

            // Fetch all videos list
                $videos = Video::select('active','status','draft','age_restrict','id','created_at','slug','image','title','rating','duration','featured','year')
                        ->where('active', '1')->where('status', '1')->where('draft', '1');

                    if (Geofencing() != null && Geofencing()->geofencing == 'ON') {
                        $videos = $videos->whereNotIn('videos.id', Block_videos());
                    }
                    if (check_Kidmode() == 1) {
                        $videos = $videos->whereBetween('videos.age_restrict', [0, 12]);
                    }
                    
                $videos = $videos->latest()->get()->map(function ($item) {
                    $item['source']       = 'videos';
                    $item['source_data']  = 'videos';
                    $item['redirect_url'] = URL::to('category/videos/'.$item->slug) ;
                    $item['image_url']    = URL::to('public/uploads/images/' . $item->image);
                    $item['title']    = $item->title;
                    $item['rating']   = $item->rating;
                    $item['duration'] = $item->duration;
                    $item['featured'] = $item->featured;
                    $item['year']     = $item->year;
                    $item['age_restrict'] = $item->age_restrict;
                    return $item;
                });

            // Fetch all series list

                $Series = Series::select('active','id','created_at','slug','image','title','rating','duration','featured','year')
                                    ->where('active', '=', '1')->orderBy('created_at', 'DESC')->latest()->get()
                                    ->map(function ($item) use($OrderHomeSetting) {
                    $item['source']       = $OrderHomeSetting->where('id',5)->pluck('header_name')->first() != null ? $OrderHomeSetting->where('id',5)->pluck('header_name')->first() : "Series" ;
                    $item['source_data']  = 'series';
                    $item['redirect_url'] = URL::to('play_series/'.$item->slug) ;
                    $item['image_url']    = URL::to('public/uploads/images/'.$item->image);
                    $item['title']    = $item->title;
                    $item['rating']   = $item->rating;
                    $item['duration'] = $item->duration;
                    $item['featured'] = $item->featured;
                    $item['year']     = $item->year;
                    $item['age_restrict'] = null ;
                    return $item;
                });

            // Fetch all audio albums list

                $AudioAlbums = AudioAlbums::orderBy('created_at', 'desc')->get()->map(function ($item) use($OrderHomeSetting) {
                    $item['source']       = $OrderHomeSetting->where('id',7)->pluck('header_name')->first() != null ? $OrderHomeSetting->where('id',7)->pluck('header_name')->first() : "Podcast";
                    $item['source_data']  = 'AudioAlbums';
                    $item['redirect_url'] = URL::to('album/'.$item->slug) ;
                    $item['image_url']    = URL::to('public/uploads/albums/' . $item->album);
                    $item['title']        = $item->albumname;
                    $item['age_restrict'] = null ;
                    $item['rating']       = null;
                    $item['duration']     = null;
                    $item['featured']     = null;
                    $item['year']         = null;
                    return $item;
                  });

            // Merge the results of the video, series, and audio album queries

                $mergedResults = $videos->merge($Series)->merge($AudioAlbums);

            // Paginate the merged results using LengthAwarePaginator

                $currentPage = request()->get('page') ?: 1;
                $pagedData = $mergedResults->forPage($currentPage, $this->settings->videos_per_page);

                $mergedResults = new LengthAwarePaginator(
                    $pagedData,
                    $mergedResults->count(),
                    $this->settings->videos_per_page,
                    $currentPage,
                    ['path' => request()->url()]
                );


            $videos_data[] = $mergedResults ;

            return response()->json([
              'status'  => 'true',
              'Message' => 'All videos Retrieved  Successfully',
              'videos'    => $mergedResults,
              'ppv_gobal_price'  => $this->ppv_gobal_price,
              'SeriesGenre'      => $SeriesGenre ,
              'VideoCategory'    => $VideoCategory ,
              'video_andriod'    => $videos_data ,
              'currency'         => CurrencySetting::first(),
              'ThumbnailSetting' => ThumbnailSetting::first(),
           ], 200);

    } catch (\Throwable $th) {
        return response()->json([
                'status'  => 'false',
                'Message' => $th->getMessage(),
            ], 200);
    }
  }

  public function all_videos_IOS()
  {
    try {
          // Video Category 

                $VideoCategory = VideoCategory::select('id','slug','in_home')->where('in_home','=',1)
                                ->get()->map(function ($item) {
                                    $item['redirect_url']  = URL::to('videos/category/'.$item->slug);
                                    $item['source_data']   = 'video_category';
                                    return $item;
                                });

            // Series Genres

                $SeriesGenre = SeriesGenre::select('id','slug','in_home')
                                ->get()->map(function ($item) {
                                    $item['redirect_url']  = URL::to('series/category/'.$item->slug);
                                    $item['source_data']  = 'SeriesGenre';
                                    return $item;
                                });
                                

            // Fetch all OrderHomeSetting list

                $OrderHomeSetting = OrderHomeSetting::get(); 

            // Fetch all videos list
                $videos = Video::select('active','status','draft','age_restrict','id','created_at','slug','image','title','rating','duration','featured','year')
                        ->where('active', '1')->where('status', '1')->where('draft', '1');

                    if (Geofencing() != null && Geofencing()->geofencing == 'ON') {
                        $videos = $videos->whereNotIn('videos.id', Block_videos());
                    }
                    if (check_Kidmode() == 1) {
                        $videos = $videos->whereBetween('videos.age_restrict', [0, 12]);
                    }
                    
                $videos = $videos->latest()->get()->map(function ($item) {
                    $item['source']       = 'videos';
                    $item['source_data']  = 'videos';
                    $item['redirect_url'] = URL::to('category/videos/'.$item->slug) ;
                    $item['image_url']    = URL::to('public/uploads/images/' . $item->image);
                    $item['title']    = $item->title;
                    $item['rating']   = $item->rating;
                    $item['duration'] = $item->duration;
                    $item['featured'] = $item->featured;
                    $item['year']     = $item->year;
                    $item['age_restrict'] = $item->age_restrict;
                    return $item;
                });

            // Fetch all series list

                $Series = Series::select('active','id','created_at','slug','image','title','rating','duration','featured','year')
                                    ->where('active', '=', '1')->orderBy('created_at', 'DESC')->latest()->get()
                                    ->map(function ($item) use($OrderHomeSetting) {
                    $item['source']       = $OrderHomeSetting->where('id',5)->pluck('header_name')->first() != null ? $OrderHomeSetting->where('id',5)->pluck('header_name')->first() : "Series" ;
                    $item['source_data']  = 'series';
                    $item['redirect_url'] = URL::to('play_series/'.$item->slug) ;
                    $item['image_url']    = URL::to('public/uploads/images/'.$item->image);
                    $item['title']    = $item->title;
                    $item['rating']   = $item->rating;
                    $item['duration'] = $item->duration;
                    $item['featured'] = $item->featured;
                    $item['year']     = $item->year;
                    $item['age_restrict'] = null ;
                    return $item;
                });

            // Fetch all audio albums list

                $AudioAlbums = AudioAlbums::orderBy('created_at', 'desc')->get()->map(function ($item) use($OrderHomeSetting) {
                    $item['source']       = $OrderHomeSetting->where('id',7)->pluck('header_name')->first() != null ? $OrderHomeSetting->where('id',7)->pluck('header_name')->first() : "Podcast";
                    $item['source_data']  = 'AudioAlbums';
                    $item['redirect_url'] = URL::to('album/'.$item->slug) ;
                    $item['image_url']    = URL::to('public/uploads/albums/' . $item->album);
                    $item['title']        = $item->albumname;
                    $item['age_restrict'] = null ;
                    $item['rating']       = null;
                    $item['duration']     = null;
                    $item['featured']     = null;
                    $item['year']         = null;
                    return $item;
                  });

            // Merge the results of the video, series, and audio album queries

                $mergedResults = $videos->merge($Series)->merge($AudioAlbums);

            // Paginate the merged results using LengthAwarePaginator

                $currentPage = request()->get('page') ?: 1;
                $pagedData = $mergedResults->forPage($currentPage, $this->settings->videos_per_page);

                $mergedResults = new LengthAwarePaginator(
                    $pagedData,
                    $mergedResults->count(),
                    $this->settings->videos_per_page,
                    $currentPage,
                    ['path' => request()->url()]
                );


            $videos_data[] = $mergedResults ;

            return response()->json([
              'status'  => 'true',
              'Message' => 'All videos Retrieved  Successfully',
              'videos'    => $mergedResults,
              'ppv_gobal_price'  => $this->ppv_gobal_price,
              'SeriesGenre'      => $SeriesGenre ,
              'VideoCategory'    => $VideoCategory ,
              'video_andriod'    => $videos_data ,
              'currency'         => CurrencySetting::first(),
              'ThumbnailSetting' => ThumbnailSetting::first(),
           ], 200);

    } catch (\Throwable $th) {
        return response()->json([
                'status'  => 'false',
                'Message' => $th->getMessage(),
            ], 200);
    }
  }

  public function all_videos_tv()
  {
    try {
          // Video Category 

                $VideoCategory = VideoCategory::select('id','slug','in_home')->where('in_home','=',1)
                                ->get()->map(function ($item) {
                                    $item['redirect_url']  = URL::to('videos/category/'.$item->slug);
                                    $item['source_data']   = 'video_category';
                                    return $item;
                                });

            // Series Genres

                $SeriesGenre = SeriesGenre::select('id','slug','in_home')
                                ->get()->map(function ($item) {
                                    $item['redirect_url']  = URL::to('series/category/'.$item->slug);
                                    $item['source_data']  = 'SeriesGenre';
                                    return $item;
                                });
                                

            // Fetch all OrderHomeSetting list

                $OrderHomeSetting = OrderHomeSetting::get(); 

            // Fetch all videos list
                $videos = Video::select('active','status','draft','age_restrict','id','created_at','slug','image','title','rating','duration','featured','year')
                        ->where('active', '1')->where('status', '1')->where('draft', '1');

                    if (Geofencing() != null && Geofencing()->geofencing == 'ON') {
                        $videos = $videos->whereNotIn('videos.id', Block_videos());
                    }
                    if (check_Kidmode() == 1) {
                        $videos = $videos->whereBetween('videos.age_restrict', [0, 12]);
                    }
                    
                $videos = $videos->latest()->get()->map(function ($item) {
                    $item['source']       = 'videos';
                    $item['source_data']  = 'videos';
                    $item['redirect_url'] = URL::to('category/videos/'.$item->slug) ;
                    $item['image_url']    = URL::to('public/uploads/images/' . $item->image);
                    $item['title']    = $item->title;
                    $item['rating']   = $item->rating;
                    $item['duration'] = $item->duration;
                    $item['featured'] = $item->featured;
                    $item['year']     = $item->year;
                    $item['age_restrict'] = $item->age_restrict;
                    return $item;
                });

            // Fetch all series list

                $Series = Series::select('active','id','created_at','slug','image','title','rating','duration','featured','year')
                                    ->where('active', '=', '1')->orderBy('created_at', 'DESC')->latest()->get()
                                    ->map(function ($item) use($OrderHomeSetting) {
                    $item['source']       = $OrderHomeSetting->where('id',5)->pluck('header_name')->first() != null ? $OrderHomeSetting->where('id',5)->pluck('header_name')->first() : "Series" ;
                    $item['source_data']  = 'series';
                    $item['redirect_url'] = URL::to('play_series/'.$item->slug) ;
                    $item['image_url']    = URL::to('public/uploads/images/'.$item->image);
                    $item['title']    = $item->title;
                    $item['rating']   = $item->rating;
                    $item['duration'] = $item->duration;
                    $item['featured'] = $item->featured;
                    $item['year']     = $item->year;
                    $item['age_restrict'] = null ;
                    return $item;
                });

            // Fetch all audio albums list

                $AudioAlbums = AudioAlbums::orderBy('created_at', 'desc')->get()->map(function ($item) use($OrderHomeSetting) {
                    $item['source']       = $OrderHomeSetting->where('id',7)->pluck('header_name')->first() != null ? $OrderHomeSetting->where('id',7)->pluck('header_name')->first() : "Podcast";
                    $item['source_data']  = 'AudioAlbums';
                    $item['redirect_url'] = URL::to('album/'.$item->slug) ;
                    $item['image_url']    = URL::to('public/uploads/albums/' . $item->album);
                    $item['title']        = $item->albumname;
                    $item['age_restrict'] = null ;
                    $item['rating']       = null;
                    $item['duration']     = null;
                    $item['featured']     = null;
                    $item['year']         = null;
                    return $item;
                  });

            // Merge the results of the video, series, and audio album queries

            $mergedResults = $videos->merge($Series)->merge($AudioAlbums);

            $videos_data[] = $mergedResults ;

            return response()->json([
              'status'  => 'true',
              'Message' => 'All videos Retrieved  Successfully',
              'videos'    => $mergedResults,
              'ppv_gobal_price'  => $this->ppv_gobal_price,
              'SeriesGenre'      => $SeriesGenre ,
              'VideoCategory'    => $VideoCategory ,
              'video_andriod'    => $videos_data ,
              'currency'         => CurrencySetting::first(),
              'ThumbnailSetting' => ThumbnailSetting::first(),
           ], 200);

    } catch (\Throwable $th) {
        return response()->json([
                'status'  => 'false',
                'Message' => $th->getMessage(),
            ], 200);
    }
  }



  // Menus API 

  public function Menus()
  {
    try{
          $settings = Setting::get();
          $Menus = Menu::orderBy('order', 'asc')->get(); 
          $VideoCategory = VideoCategory::where('in_home','=',1)->get();
          $LiveCategory = LiveCategory::get();
          $AudioCategory = AudioCategory::get();
          $SeriesGenre = SeriesGenre::where('in_home','=',1)->get();
          
          $response = array(
            'status'=> 'true',
            'Menus' => $Menus,
            'VideoCategory' => $VideoCategory,
            'LiveCategory' => $LiveCategory,
            'AudioCategory' => $AudioCategory,
            'SeriesGenre' => $SeriesGenre,
            'settings' => $settings,
          );
              
      }catch (\Throwable $th) {

          $response = array(
              'status'=>'false',
              'message'=>$th->getMessage(),
          );
      }
      
      return response()->json($response, 200);
  }
      
  public function DataFree()
  {
    try{
      $HomeSetting = MobileHomeSetting::first();
      
      if($HomeSetting->latest_videos == 1){
      $settings = Setting::get();
        // Data Free Video Based on Category 
         
        $DataFreeCategories = VideoCategory::where('slug','datafree')->where('in_home','=',1)->first();
          $countDataFreeCategories = VideoCategory::where('slug','datafree')->where('in_home','=',1)->count();
          if ($countDataFreeCategories > 0 ) {   

                $videos = Video::join('categoryvideos', 'categoryvideos.video_id', '=', 'videos.id')
                            ->where('category_id','=',@$DataFreeCategories->id)->where('active', '=', '1')
                            ->where('status', '=', '1')->where('draft', '=', '1');
                $videos = $videos->latest('videos.created_at')->get();
          
          }else{
            $videos = [];
          }

        // Data Free Series Based on Category 

          $DataFreeseriesCategories = SeriesGenre::where('slug','datafree')->where('in_menu','=',1)->first();
          $countDataFreeseriesCategories = SeriesGenre::where('slug','datafree')->where('in_menu','=',1)->count();
          if ($countDataFreeseriesCategories > 0 ) {   

                $series = Series::join('series_categories', 'series_categories.series_id', '=', 'series.id')
                            ->where('category_id','=',@$DataFreeseriesCategories->id)->where('active', '=', '1')
                            ->where('active', '=', '1');
                $series = $series->latest('series.created_at')->get();
          
          }else{
             $series = [];
          }

        // Data Free Live Stream Based on Category 

          $DataFreeliveCategories = LiveCategory::where('slug','datafree')->first();
          $countDataFreeliveCategories = LiveCategory::where('slug','datafree')->count();
          if ($countDataFreeliveCategories > 0 ) {   

                $live_streams = LiveStream::join('livecategories', 'livecategories.live_id', '=', 'live_streams.id')
                            ->where('category_id','=',@$DataFreeliveCategories->id)->where('active', '=', '1')
                            ->where('status', '=', '1');
                $live_streams = $live_streams->latest('live_streams.created_at')->get();
          
          }else{
             $live_streams = [];
          }

        // Data Free Audio Based on Category 

          $DataFreeAudioCategories = AudioCategory::where('slug','datafree')->first();
          $countDataFreeAudioCategories = AudioCategory::where('slug','datafree')->count();
          if ($countDataFreeAudioCategories > 0 ) {   

                $audio = Audio::join('category_audios', 'category_audios.audio_id', '=', 'audio.id')
                            ->where('category_id','=',@$DataFreeAudioCategories->id)->where('active', '=', '1')
                            ->where('status', '=', '1');
                $audio = $audio->latest('audio.created_at')->get();
          
          }else{
             $audio = [];
          } 
        
          $response = array(
              'status'=> 'true',
              'videos' => $videos,
              'series' => $series,
              'live_streams' => $live_streams,
              'audio' => $audio,
              'settings' => $settings,
          );
      }else{

          $response = array(
            'status'=> 'true',
            'Message' => 'Please Trun On Latest Video on Home Page Settings',
            'videos' => [],
            'series' =>[],
            'live_streams' => [],
            'audio' => [],
            'settings' => [],
        );
      }
          
        } catch (\Throwable $th) {

          $response = array(
            'status'=>'false',
            'message'=>$th->getMessage(),
          );
    }

    return response()->json($response, 200);
      
  }
  public function categoryLive(Request $request)
  {
      try{
        $LiveCategory = LiveCategory::find($request->category_id) != null ? LiveCategory::find($request->category_id)->specific_category_live : array();
        
        $Live_Category = $LiveCategory->all();

        $response = array( 'status'=> 'true','LiveCategory' => $Live_Category );

      } catch (\Throwable $th) {

        $response = array(
          'status'=>'false',
          'message'=>$th->getMessage(),
        );
    }

    return response()->json($response, 200);
  }
  
  //  All Homepage

  public function All_Homepage(Request $request)
  {
      $user_id = $request->user_id;

      $All_Homepage_homesetting =  $this->All_Homepage_homesetting( $user_id );

      $OrderHomeSettings =  OrderHomeSetting::whereIn('video_name', $All_Homepage_homesetting )->orderBy('order_id')->get()->toArray();

      $result = array();

      foreach ($OrderHomeSettings as $key => $OrderHomeSetting) {
                 
        if($OrderHomeSetting['video_name'] == "latest_videos"){      // Latest Videos
          
          $data = $this->All_Homepage_latestvideos();
          $source = $OrderHomeSetting['video_name'] ;
          $header_name = $OrderHomeSetting['header_name'] ;
          $header_name_IOS = $OrderHomeSetting['header_name'] ;
          $source_type = "videos" ;

        }

        if( $OrderHomeSetting['video_name'] == "featured_videos" ){     // Featured videos
          
          $data = $this->All_Homepage_featured_videos();
          $source = $OrderHomeSetting['video_name'] ;
          $header_name = $OrderHomeSetting['header_name'] ;
          $header_name_IOS = $OrderHomeSetting['header_name'] ;
          $source_type = "videos" ;

        }

        if( $OrderHomeSetting['video_name'] == "live_videos" ){       // Live videos
          
          $data = $this->All_Homepage_live_videos();
          $source = $OrderHomeSetting['video_name'] ;
          $header_name = $OrderHomeSetting['header_name'] ;
          $header_name_IOS = $OrderHomeSetting['header_name'] ;
          $source_type = "livestream" ;

        }

        if( $OrderHomeSetting['video_name'] == "series" ){          // Series
          
          $data = $this->All_Homepage_series_videos();
          $source = $OrderHomeSetting['video_name'] ;
          $header_name = $OrderHomeSetting['header_name'] ;
          $header_name_IOS = $OrderHomeSetting['header_name'] ;
          $source_type = "series" ;

        }

        if( $OrderHomeSetting['video_name'] == "audios" ){          // Audios
          
          $data = $this->All_Homepage_audios();
          $source = $OrderHomeSetting['video_name'] ;
          $header_name = $OrderHomeSetting['header_name'] ;
          $header_name_IOS = $OrderHomeSetting['header_name'] ;
          $source_type = "audios" ;

        }

        if( $OrderHomeSetting['video_name'] == "albums" ){          // Albums
          
          $data = $this->All_Homepage_albums();
          $source = $OrderHomeSetting['video_name'] ;
          $header_name = $OrderHomeSetting['header_name'] ;
          $header_name_IOS = $OrderHomeSetting['header_name'] ;
          $source_type = "audios_albums" ;

        }


        // if( $OrderHomeSetting['video_name'] == "artist" ){          // Artist
          
        //   $data = $this->All_Homepage_artist();
        //   $source = $OrderHomeSetting['video_name'] ;
        //   $header_name = $OrderHomeSetting['header_name'] ;
        // $source_type = "artist" ;

        // }

        if( $OrderHomeSetting['video_name'] == "video_schedule" ){    // video_schedule
          
          $data = $this->All_Homepage_video_schedule();
          $source = $OrderHomeSetting['video_name'] ;
          $header_name = $OrderHomeSetting['header_name'] ;
          $header_name_IOS = $OrderHomeSetting['header_name'] ;
          $source_type = "videos" ;

        }

        if( $OrderHomeSetting['video_name'] == "ChannelPartner" ){    // ChannelPartner
          
          $data = $this->All_Homepage_ChannelPartner();
          $source = $OrderHomeSetting['video_name'] ;
          $header_name = $OrderHomeSetting['header_name'] ;
          $header_name_IOS = $OrderHomeSetting['header_name'] ;
          $source_type = "ChannelPartner" ;

        }

        if( $OrderHomeSetting['video_name'] == "ContentPartner" ){    // ContentPartner
          
          $data = $this->All_Homepage_ContentPartner();
          $source = $OrderHomeSetting['video_name'] ;
          $header_name = $OrderHomeSetting['header_name'] ;
          $header_name_IOS = $OrderHomeSetting['header_name'] ;
          $source_type = "ContentPartner" ;

        }

        
        if( $OrderHomeSetting['video_name'] == "latest_viewed_Videos" ){    // Latest viewed videos
          
          $data = $this->All_Homepage_latest_viewed_Videos( $user_id );
          $source = $OrderHomeSetting['video_name'] ;
          $header_name = $OrderHomeSetting['header_name'] ;
          $header_name_IOS = $OrderHomeSetting['header_name'] ;
          $source_type = "videos" ;

        }

        if( $OrderHomeSetting['video_name'] == "latest_viewed_Livestream" ){    // Latest viewed Livestream
          
          $data = $this->All_Homepage_latest_viewed_Livestream( $user_id );
          $source = $OrderHomeSetting['video_name'] ;
          $header_name = $OrderHomeSetting['header_name'] ;
          $header_name_IOS = $OrderHomeSetting['header_name'] ;
          $source_type = "livestream" ;

        }

        if( $OrderHomeSetting['video_name'] == "latest_viewed_Audios" ){    // Latest viewed Audios
          
          $data = $this->All_Homepage_latest_viewed_Audios( $user_id );
          $source = $OrderHomeSetting['video_name'] ;
          $header_name = $OrderHomeSetting['header_name'] ;
          $header_name_IOS = $OrderHomeSetting['header_name'] ;
          $source_type = "audios" ;

        }

        if( $OrderHomeSetting['video_name'] == "latest_viewed_Episode" ){    // Latest viewed Episode
          
          $data = $this->All_Homepage_latest_viewed_Episode( $user_id );
          $source = $OrderHomeSetting['video_name'] ;
          $header_name = $OrderHomeSetting['header_name'] ;
          $header_name_IOS = $OrderHomeSetting['header_name'] ;
          $source_type = "episode" ;

        }


        if( $OrderHomeSetting['video_name'] == "category_videos" ){          // Videos based on Categories
          
          $data = $this->All_Homepage_category_videos();
          $source = $OrderHomeSetting['video_name'] ;
          $header_name = $OrderHomeSetting['header_name'] ;
          $header_name_IOS = null ;
          $source_type = "videos" ;

        }

        if( $OrderHomeSetting['video_name'] == "live_category" ){          // livestream Videos based on category 
          
          $data = $this->All_Homepage_category_livestream();
          $source = $OrderHomeSetting['video_name'] ;
          $header_name = $OrderHomeSetting['header_name'] ;
          $header_name_IOS = null ;
          $source_type = "livestreams" ;

        }

        if( $OrderHomeSetting['video_name'] == "Recommended_videos_site" ){          // Recommendation - Mostwatched Videos
          
          $data = $this->All_Homepage_Recommended_videos_site();
          $source = $OrderHomeSetting['video_name'] ;
          $header_name = $OrderHomeSetting['header_name'] ;
          $header_name_IOS = $OrderHomeSetting['header_name'] ;
          $source_type = "videos" ;

        }

        if( $OrderHomeSetting['video_name'] == "Recommended_videos_users" ){          // Recommendation - Mostwatched Videos User
          
          $data = $this->All_Homepage_Recommended_videos_users($user_id);
          $source = $OrderHomeSetting['video_name'] ;
          $header_name = $OrderHomeSetting['header_name'] ;
          $header_name_IOS = $OrderHomeSetting['header_name'] ;
          $source_type = "videos" ;

        }

        if( $OrderHomeSetting['video_name'] == "Recommended_videos_Country" ){          // Recommendation - Country Mostwatched Videos
         
          $data = $this->All_Homepage_Recommended_videos_Country();
          $source = $OrderHomeSetting['video_name'] ;
          $header_name = $OrderHomeSetting['header_name'] ;
          $header_name_IOS = $OrderHomeSetting['header_name'] ;
          $source_type = "videos" ;

        }

        if( $OrderHomeSetting['video_name'] == "liveCategories" ){          // live Categories
         
          $data = $this->All_Homepage_liveCategories();
          $source = $OrderHomeSetting['video_name'] ;
          $header_name = $OrderHomeSetting['header_name'] ;
          $header_name_IOS = $OrderHomeSetting['header_name'] ;
          $source_type = "liveCategories" ;

        }

        if( $OrderHomeSetting['video_name'] == "videoCategories" ){          // Video Categories
         
          $data = $this->All_Homepage_videoCategories();
          $source = $OrderHomeSetting['video_name'] ;
          $header_name = $OrderHomeSetting['header_name'] ;
          $header_name_IOS = $OrderHomeSetting['header_name'] ;
          $source_type = "videoCategories" ;

        }

        if( $OrderHomeSetting['video_name'] == "Audio_Genre" ){          // Audio Genre
         
          $data = $this->All_Homepage_Audio_Genre();
          $source = $OrderHomeSetting['video_name'] ;
          $header_name = $OrderHomeSetting['header_name'] ;
          $header_name_IOS = $OrderHomeSetting['header_name'] ;
          $source_type = "Audio_Genre" ;

        }

        if( $OrderHomeSetting['video_name'] == "Audio_Genre_audios" ){   // Audio Genre based on audios
         
          $data = $this->All_Homepage_Audio_Genre_audios();
          $source = $OrderHomeSetting['video_name'] ;
          $header_name = $OrderHomeSetting['header_name'] ;
          $header_name_IOS = null ;
          $source_type = "Audios" ;

        }

        $result[] = array(
          "source"      => $source,
          "header_name" => $header_name,
          "header_name_IOS" => $header_name_IOS,
          "source_type" => $source_type,
          "data"        => $data,
        );

      }

      $response = array(
        'status' => 'true',
        'Home_page' => $result,
      );
  
      return response()->json($response, 200);
  }

  private  function All_Homepage_homesetting( $user_id ){

     $Homesetting = MobileHomeSetting::first();

     $input = array();

     if($Homesetting->featured_videos == 1 && $this->All_Homepage_featured_videos()->isNotEmpty() ){
        array_push($input,'featured_videos');
     }

     if($Homesetting->latest_videos == 1 && $this->All_Homepage_latestvideos()->isNotEmpty() ){
       array_push($input,'latest_videos');
    }

     if($Homesetting->category_videos == 1 && $this->All_Homepage_category_videos()->isNotEmpty() ){
        array_push($input,'category_videos');
     }

     if($Homesetting->live_category == 1 && $this->All_Homepage_category_livestream()->isNotEmpty() ){
        array_push($input,'live_category');
     }

    if($Homesetting->videoCategories == 1 && $this->All_Homepage_videoCategories()->isNotEmpty() ){
        array_push($input,'videoCategories');
    }

    if($Homesetting->liveCategories == 1 && $this->All_Homepage_liveCategories()->isNotEmpty() ){
      array_push($input,'liveCategories');
    }

    if($Homesetting->live_videos == 1 && $this->All_Homepage_live_videos()->isNotEmpty() ){
      array_push($input,'live_videos');
    }

    if($Homesetting->series == 1 && $this->All_Homepage_series_videos()->isNotEmpty() ){
      array_push($input,'series');
    }

    if($Homesetting->audios == 1 && $this->All_Homepage_audios()->isNotEmpty() ){
      array_push($input,'audios');
    }

    if($Homesetting->albums == 1  && $this->All_Homepage_albums()->isNotEmpty() ){
      array_push($input,'albums');
    }

    if($Homesetting->video_schedule == 1 && $this->All_Homepage_video_schedule()->isNotEmpty() ){
      array_push($input,'video_schedule');
    }

    if($Homesetting->channel_partner == 1 && $this->All_Homepage_ChannelPartner()->isNotEmpty() ){
      array_push($input,'ChannelPartner');
    }

    if($Homesetting->content_partner == 1 && $this->All_Homepage_ContentPartner()->isNotEmpty() ){
      array_push($input,'ContentPartner');
    }

    if($Homesetting->AudioGenre == 1 && $this->All_Homepage_Audio_Genre()->isNotEmpty() ){
      array_push($input,'Audio_Genre');
    }
    
    if($Homesetting->AudioGenre_audios == 1 && $this->All_Homepage_Audio_Genre_audios()->isNotEmpty() ){
      array_push($input,'Audio_Genre_audios');
    }

    if($Homesetting->latest_viewed_Videos == 1 && $this->All_Homepage_latest_viewed_Videos( $user_id )->isNotEmpty() ){
      array_push($input,'latest_viewed_Videos');
    }

    if($Homesetting->latest_viewed_Livestream == 1 && ($this->All_Homepage_latest_viewed_Livestream( $user_id ))->isNotEmpty() ){
      array_push($input,'latest_viewed_Livestream');
    }

    if($Homesetting->latest_viewed_Episode == 1 && $this->All_Homepage_latest_viewed_Episode( $user_id )->isNotEmpty() ){
      array_push($input,'latest_viewed_Episode');
    }

    if($Homesetting->latest_viewed_Audios == 1 && $this->All_Homepage_latest_viewed_Audios( $user_id )->isNotEmpty() ){
      array_push($input,'latest_viewed_Audios');
    }

    if($Homesetting->Recommended_videos_site == 1 && $this->All_Homepage_Recommended_videos_site()->isNotEmpty()  ){
      array_push($input,'Recommended_videos_site');
    }

    if($Homesetting->Recommended_videos_users == 1 && $this->All_Homepage_Recommended_videos_users( $user_id )->isNotEmpty()  ){
      array_push($input,'Recommended_videos_users');
    }

    if($Homesetting->Recommended_videos_Country == 1 && $this->All_Homepage_Recommended_videos_Country()->isNotEmpty()  ){
      array_push($input,'Recommended_videos_Country');
    }

    if($Homesetting->continue_watching == 1 ){
      array_push($input,'continue_watching');
    }

    // if($Homesetting->artist == 1){
    //   array_push($input,'artist');
    // }

    return $input;

  }


  private static function All_Homepage_latestvideos(){

    $latest_videos_status = MobileHomeSetting::pluck('latest_videos')->first();
    $check_Kidmode        = 0 ;

    if( $latest_videos_status == null || $latest_videos_status == 0 ):

      $data = array();       // Note - if the home-setting (latest_videos) is turned off in the admin panel

    else:

      $data = Video::select('id','title','slug','year','rating','access','publish_type','global_ppv','publish_time','ppv_price','duration','rating','image','featured','age_restrict','player_image')
        ->where('active',1)->where('status', 1)->where('draft',1);

          if( Geofencing() !=null && Geofencing()->geofencing == 'ON')
          {
            $data = $data->whereNotIn('videos.id',Block_videos());
          }

          if( $check_Kidmode == 1 )
          {
            $data = $data->whereBetween('age_restrict', [ 0, 12 ]);
          }

      $data = $data->latest()->limit(30)->get()->map(function ($item) {
        $item['image_url'] = URL::to('/public/uploads/images/'.$item->image);
        $item['Player_image_url'] = URL::to('/public/uploads/images/'.$item->player_image);
        $item['source']    = "Videos";
        return $item;
      });

    endif;

    return $data ;

  }

  private static function All_Homepage_featured_videos(){

    $featured_videos_status = MobileHomeSetting::pluck('featured_videos')->first();

    $check_Kidmode        = 0 ;

      if( $featured_videos_status == null || $featured_videos_status == 0 ):

          $data = array();        // Note - if the home-setting (featured_videos) is turned off in the admin panel
      
      else:

        $data = Video::select('id','player_image','title','slug','year','rating','access','publish_type','global_ppv','publish_time','ppv_price','duration','rating','image','featured','age_restrict')
          ->where('active',1)->where('status', 1)->where('draft',1)->where('featured',1);

            if( Geofencing() !=null && Geofencing()->geofencing == 'ON')
            {
                $data = $data->whereNotIn('videos.id',Block_videos());
            }

            if( $check_Kidmode == 1 )
            {
                $data = $data->whereBetween('age_restrict', [ 0, 12 ]);
            }
        
        $data = $data->latest()->limit(30)->get()->map(function ($item) {
            $item['image_url'] = URL::to('public/uploads/images/'.$item->image);
            $item['Player_image_url'] = URL::to('/public/uploads/images/'.$item->player_image);
            $item['source']    = "Videos";
            return $item;
        });

      endif;

    return $data ;

  }

  private static function All_Homepage_live_videos(){
  
      $live_stream_videos_status = MobileHomeSetting::pluck('live_videos')->first();

      if( $live_stream_videos_status == null || $live_stream_videos_status == 0 ):   

          $data = array();      // Note - if the home-setting (live_videos) is turned off in the admin panel

      else:

        $data = LiveStream::select('id','title','slug','year','rating','access','ppv_price','publish_type','publish_status','publish_time','duration','rating','image','player_image','featured')
                              ->where('active',1)->where('status', 1)->latest()->limit(30)->get()
                              ->map(function ($item) {
                                  $item['image_url'] = URL::to('/public/uploads/images/'.$item->image);
                                  $item['Player_image_url'] = URL::to('/public/uploads/images/'.$item->player_image);
                                  $item['source']    = "Livestream";
                                  return $item;
                              });
      endif;

      return $data ;
  }

  private static function All_Homepage_series_videos(){

    $series_status = MobileHomeSetting::pluck('series')->first();

      if( $series_status != null && $series_status == 0 ):

          $data = array();        // Note - if the home-setting (series) is turned off in the admin panel
      
      else:

        $data = Series::select('id','title','slug','access','active','ppv_status','featured','duration','image','embed_code','mp4_url','webm_url','ogg_url','url','player_image')
            ->where('active', '=', '1')->get()->map(function ($item) {
                $item['image_url'] = URL::to('/public/uploads/images/'.$item->image);
                $item['Player_image_url'] = URL::to('/public/uploads/images/'.$item->player_image);
                $item['season_count'] = SeriesSeason::where('series_id',$item->id)->count();
                $item['episode_count'] = Episode::where('series_id',$item->id)->count();
                $item['source']    = "Series";
                return $item;
        });
      
      endif;

      return $data ;
  }

  private static function All_Homepage_audios(){

    $audios_status = MobileHomeSetting::pluck('audios')->first();

      if( $audios_status == null || $audios_status == 0 ):    

          $data = array();      // Note - if the home-setting (audios) is turned off in the admin panel

      else:

        $data = Audio::select('id','title','slug','year','rating','access','ppv_price','duration','rating','image','player_image','featured')
          ->where('active',1)->where('status', 1)->latest();

            if( Geofencing() !=null && Geofencing()->geofencing == 'ON')
            {
              $data = $data->whereNotIn('audio.id',Block_audios());
            }

        $data = $data->limit(30)->get()->map(function ($item) {
            $item['image_url'] = URL::to('/public/uploads/audios/'.$item->image);
            $item['Player_image_url'] = URL::to('/public/uploads/images/'.$item->player_image);
            $item['redirect_url'] = URL::to('album/'.$item->slug);
            $item['source']    = "Audios";
            return $item;
        }); 

      endif;

      return $data;
  }

  private static function All_Homepage_albums(){

    $albums_status = MobileHomeSetting::pluck('albums')->first();

      if(  $albums_status == null || $albums_status == 0 ):    

          $data = array();      // Note - if the home-setting (albums) is turned off in the admin panel

      else:

          $data = AudioAlbums::latest()->limit(30)->get()->map(function ($item) {
              $item['image_url'] = URL::to('/public/uploads/albums/'.$item->album);
              $item['Player_image_url'] = URL::to('/public/uploads/albums/'.$item->album); // Note - No Player Image for Albums
              $item['redirect_url'] = URL::to('audio/'.$item->slug);
              $item['source']    = "Audios_album";
              return $item;
          });

      endif;

    return $data ;
  }

  // private static function All_Homepage_artist(){

  //   $artist_status = MobileHomeSetting::pluck('artist')->first();

  //     if( $artist_status == null ||  $artist_status == 0 ):  

  //         $data = array();      // Note - if the home-setting (artist) is turned off in the admin panel

  //     else:

  //       $data = Artist::latest()->limit(30)->get()->map(function ($item) {
  //           $item['image_url'] = URL::to('/public/uploads/albums/'.$item->image);
  //           $item['redirect_url'] = URL::to('artist/'.$item->slug);
  //           return $item;
  //       });

  //     endif;

  //   return $data ;
  // }

  private static function All_Homepage_video_schedule(){

    $video_schedule_status = MobileHomeSetting::pluck('video_schedule')->first();

      if( $video_schedule_status == null || $video_schedule_status == 0 ):    

          $data = array();      // Note - if the home-setting (video_schedule) is turned off in the admin panel

      else:

        $data = VideoSchedules::where('in_home',1)->latest()->limit(30)->get()->map(function ($item) {
            $item['image_url'] = $item->image;
            $item['Player_image_url'] = $item->player_image; 
            $item['source']    = "Videos";
            return $item;
        });
      
      endif;

    return $data ;
  }

  private static function All_Homepage_ChannelPartner(){

    $channel_partner_status = MobileHomeSetting::pluck('channel_partner')->first();

       if( $channel_partner_status == null || $channel_partner_status == 0 ):   

           $data = array();      // Note - if the home-setting (channel_partner) is turned off in the admin panel
      
       else:

         $data = Channel::select('id','channel_name','status','channel_image','channel_slug')
                ->where('status',1)->latest()->limit(30)->get()->map(function ($item) {
                    $item['image_url'] = URL::to('/public/uploads/channel/'.$item->channel_image);
                    $item['Player_image_url'] = URL::to('/public/uploads/channel/'.$item->channel_image); // Note - No Player Image for Channel
                    $item['redirect_url'] = URL::to('channel/'.$item->channel_slug);
                    $item['source']    = "Channel_Partner";
                        return $item;
                    });
       endif;
   
    return $data;
  }

  private static function All_Homepage_ContentPartner(){

    $content_partner_status = MobileHomeSetting::pluck('content_partner')->first();

      if( $content_partner_status == null || $content_partner_status == 0 ): 

          $data = array();      // Note - if the home-setting (content_partner) is turned off in the admin panel
      else:

          $data = ModeratorsUser::select('id','username','status','picture','slug')
                  ->where('status',1)->latest()->limit(30)->get()->map(function ($item) {
                    $item['image_url'] = $item->picture ;
                    $item['Player_image_url'] = $item->picture; // Note - No Player Image for Moderators User
                    $item['source']    = "Content_Partner";
                  return $item;
              });

      endif;

    return $data;
  }

  private static function All_Homepage_latest_viewed_Videos( $user_id ){

    $latest_viewed_Videos_status = MobileHomeSetting::pluck('latest_viewed_Videos')->first();

      if( $latest_viewed_Videos_status == null || $latest_viewed_Videos_status == 0 ): 

          $data = array();      // Note - if the home-setting (latest_viewed_Videos_status) is turned off in the admin panel
      else:

        $data = RecentView::join('videos', 'videos.id', '=', 'recent_views.video_id')
              ->where('recent_views.user_id',$user_id)
              ->groupBy('recent_views.video_id');

              if(Geofencing() !=null && Geofencing()->geofencing == 'ON'){
                  $data = $data  ->whereNotIn('videos.id',Block_videos());
              }
              
        $data = $data->get()->map(function ($item) {
          $item['image_url'] = URL::to('/public/uploads/images/'.$item->image);
          $item['Player_image_url'] = URL::to('/public/uploads/images/'.$item->player_image); 
          $item['source']    = "Videos";
              return $item;
          });
      endif;

    return $data;

  }

  private static function All_Homepage_latest_viewed_Livestream( $user_id ){

    $latest_viewed_Livestream_status = MobileHomeSetting::pluck('latest_viewed_Livestream')->first();

      if( $latest_viewed_Livestream_status == null || $latest_viewed_Livestream_status == 0 ): 

          $data = array();      // Note - if the home-setting (latest_viewed_Livestream_status) is turned off in the admin panel
      else:

          $data = RecentView::join('live_streams', 'live_streams.id', '=', 'recent_views.live_id')
                  ->where('recent_views.user_id',$user_id)
                  ->groupBy('recent_views.live_id')
                  ->get()->map(function ($item) {
                    $item['image_url'] = URL::to('/public/uploads/images/'.$item->image);
                    $item['Player_image_url'] = URL::to('/public/uploads/images/'.$item->player_image);
                    $item['source']    = "Livestream";
                        return $item;
                    });
              
      endif;

    return $data;

  }

  private static function All_Homepage_latest_viewed_Episode( $user_id ){

    $latest_viewed_Episode_status = MobileHomeSetting::pluck('latest_viewed_Episode')->first();

      if( $latest_viewed_Episode_status == null || $latest_viewed_Episode_status == 0 ): 

          $data = array();      // Note - if the home-setting (latest_viewed_Episode_status) is turned off in the admin panel
      else:

          $data = RecentView::Select('episodes.*', 'episodes.slug as episode_slug', 'series.id', 'series.slug as series_slug', 'recent_views.episode_id', 'recent_views.user_id')
                    ->join('episodes', 'episodes.id', '=', 'recent_views.episode_id')
                    ->join('series', 'series.id', '=', 'episodes.series_id')
                    ->where('recent_views.user_id', $user_id)
                    ->groupBy('recent_views.episode_id')
                    ->get()->map(function ($item) {
                      $item['image_url'] = URL::to('/public/uploads/image/'.$item->image);
                      $item['Player_image_url'] = URL::to('/public/uploads/images/'.$item->player_image);
                      $item['source']    = "Episode";
                          return $item;
                      });

      endif;

    return $data;

  }


  private static function All_Homepage_latest_viewed_Audios($user_id){

    $latest_viewed_Audios_status = MobileHomeSetting::pluck('latest_viewed_Audios')->first();

      if( $latest_viewed_Audios_status == null || $latest_viewed_Audios_status == 0 ): 

          $data = array();      // Note - if the home-setting (latest_viewed_Audios_status) is turned off in the admin panel
      else:

          $data =  RecentView::join('audio', 'audio.id', '=', 'recent_views.audio_id')
            ->where('recent_views.user_id',$user_id)
            ->groupBy('recent_views.audio_id');

            if(Geofencing() !=null && Geofencing()->geofencing == 'ON'){
                $data = $data  ->whereNotIn('audio.id',Block_audios());
            }

            $data = $data->get()->map(function ($item) {
              $item['image_url'] = URL::to('/public/uploads/audios/'.$item->image);
              $item['Player_image_url'] = URL::to('/public/uploads/audios/'.$item->player_image);
              $item['source']    = "Audios";
                  return $item;
              });
              
      endif;

    return $data;

  }


  private static function All_Homepage_liveCategories(){

    $livestreamcategory_status = MobileHomeSetting::pluck('liveCategories')->first();

      if( $livestreamcategory_status == null || $livestreamcategory_status == 0 ): 

          $data = array();      // Note - if the home-setting (Livestream category status) is turned off in the admin panel
      else:

        $data =  LiveCategory::where('in_menu',1)->limit(30)->orderBy('order')->get()->map(function ($item) {
                              $item['image_url'] = URL::to('public/uploads/livecategory/'.$item->image);
                              $item['Player_image_url'] = URL::to('public/uploads/livecategory/'.$item->image); // Note - No Player Image for LiveCategory
                              $item['source']    = "LiveCategory";
                              return $item;
                            });
      endif;
   
    return $data;
  }

  private static function All_Homepage_videoCategories(){

    $videoCategories_status = MobileHomeSetting::pluck('videoCategories')->first();

      if( $videoCategories_status == null || $videoCategories_status == 0 ): 

          $data = array();      // Note - if the home-setting (video Categories status) is turned off in the admin panel
      else:

          $data =  VideoCategory::where('in_home',1)->limit(30)->orderBy('order')->get()->map(function ($item) {
                          $item['image_url'] = URL::to('public/uploads/videocategory/'.$item->image);
                          $item['Player_image_url'] = URL::to('public/uploads/videocategory/'.$item->banner_image);
                          $item['source']    = "VideoCategory"; 
                          return $item;
                        });

      endif;
   
    return $data;
  }

  private static function All_Homepage_Recommended_videos_site(){

    $Recommendation_status = MobileHomeSetting::pluck('Recommended_videos_site')->first();

      if( $Recommendation_status == null || $Recommendation_status == 0 ): 

          $data = array();      // Note - if the home-setting (Recommendation_status) is turned off in the admin panel
      else:

        $check_Kidmode = 0 ;

        $data = RecentView::select('video_id','videos.id', 'videos.title', 'videos.slug', 'videos.year', 'videos.rating', 'videos.access', 'videos.publish_type', 'videos.global_ppv', 'videos.publish_time', 'videos.ppv_price', 'videos.duration', 'videos.rating', 'videos.image', 'videos.featured', 'videos.age_restrict','videos.player_image',DB::raw('COUNT(video_id) AS count'))
              ->join('videos', 'videos.id', '=', 'recent_views.video_id');

            if(Geofencing() !=null && Geofencing()->geofencing == 'ON')
            {
              $data = $data->whereNotIn('videos.id',Block_videos());
            }

            if( $check_Kidmode == 1 )
            {
              $data = $data->whereBetween('videos.age_restrict', [ 0, 12 ]);
            }

            $data = $data->groupBy('video_id')
                  ->orderByRaw('count DESC' )->limit(30)->get()->map(function ($item) {
                    $item['image_url'] = URL::to('public/uploads/images/'.$item->image) ;
                    $item['Player_image_url'] = URL::to('public/uploads/images/'.$item->player_image);
                    $item['source']    = "Videos";
                    return $item;
            });

      endif;
   
    return $data;

  }

  private static function All_Homepage_Recommended_videos_users($user_id)
  {

    $Recommendation_status = MobileHomeSetting::pluck('Recommended_videos_users')->first();

      if( $Recommendation_status == null || $Recommendation_status == 0 ): 

          $data = array();      // Note - if the home-setting (Recommendation_status) is turned off in the admin panel
      else:

        $check_Kidmode = 0 ;

        $data = RecentView::select('video_id','videos.id', 'videos.title', 'videos.slug', 'videos.year', 'videos.rating', 'videos.access', 'videos.publish_type', 'videos.global_ppv', 'videos.publish_time', 'videos.ppv_price', 'videos.duration', 'videos.rating', 'videos.image', 'videos.featured', 'videos.age_restrict','videos.player_image',DB::raw('COUNT(video_id) AS count'))
                  ->join('videos', 'videos.id', '=', 'recent_views.video_id')
                  ->groupBy('video_id')->where('recent_views.sub_user',$user_id)
                  ->orderByRaw('count DESC' );
                  
                  if(Geofencing() !=null && Geofencing()->geofencing == 'ON')
                  {
                    $data = $data->whereNotIn('videos.id',Block_videos());
                  }
      
                  if( $check_Kidmode == 1 )
                  {
                    $data = $data->whereBetween('videos.age_restrict', [ 0, 12 ]);
                  }

                  $data = $data->limit(30)->get()->map(function ($item) {
                      $item['image_url'] = URL::to('public/uploads/images/'.$item->image) ;
                      $item['Player_image_url'] = URL::to('/public/uploads/images/'.$item->player_image);
                      $item['source']    = "Videos";
                  return $item;
            });
      endif;
   
     return $data;
  }

  private static function All_Homepage_Recommended_videos_Country()
  {

    $Recommendation_status = MobileHomeSetting::pluck('Recommended_videos_Country')->first();

    if( $Recommendation_status == null || $Recommendation_status == 0 ): 

        $data = array();      // Note - if the home-setting (Recommendation_status) is turned off in the admin panel
    else:
      
        $check_Kidmode = 0 ;

        $data = RecentView::select('video_id','videos.id', 'videos.title', 'videos.slug', 'videos.year', 'videos.rating', 'videos.access', 'videos.publish_type', 'videos.global_ppv', 'videos.publish_time', 'videos.ppv_price', 'videos.duration', 'videos.rating', 'videos.image', 'videos.featured', 'videos.age_restrict','videos.player_image',DB::raw('COUNT(video_id) AS count'))
                  ->join('videos', 'videos.id', '=', 'recent_views.video_id')->groupBy('video_id')->orderByRaw('count DESC' )
                  ->where('country_name', Country_name());
                  
                  if(Geofencing() !=null && Geofencing()->geofencing == 'ON')
                  {
                    $data = $data->whereNotIn('videos.id',Block_videos());
                  }
      
                  if( $check_Kidmode == 1 )
                  {
                    $data = $data->whereBetween('videos.age_restrict', [ 0, 12 ]);
                  }

                  $data = $data->limit(30)->get()->map(function ($item) {
                      $item['image_url'] = URL::to('public/uploads/images/'.$item->image) ;
                      $item['Player_image_url'] = URL::to('/public/uploads/images/'.$item->player_image);
                      $item['source']    = "Videos"; 
                  return $item;
            });
    endif;
 
   return $data;

  }

  private static function All_Homepage_category_videos(){

    $category_videos_status = MobileHomeSetting::pluck('category_videos')->first();

    if( $category_videos_status == null || $category_videos_status == 0 ): 

        $data = array();      // Note - if the home-setting (category_videos_status) is turned off in the admin panel
    else:

        $check_Kidmode = 0 ;

        $data = VideoCategory::query()
        ->whereHas('category_videos', function ($query) use ($check_Kidmode) {
            $query->where('videos.active', 1)->where('videos.status', 1)->where('videos.draft', 1);
    
            if (Geofencing() != null && Geofencing()->geofencing == 'ON') {
              $query->whereNotIn('videos.id', Block_videos());
            }
    
            if ($check_Kidmode == 1) {
              $query->whereBetween('videos.age_restrict', [0, 12]);
            }
        })

        ->with(['category_videos' => function ($videos) use ($check_Kidmode) {
            $videos->select('videos.id', 'title', 'slug', 'year', 'rating', 'access', 'publish_type', 'global_ppv', 'publish_time', 'ppv_price', 'duration', 'rating', 'image', 'featured', 'age_restrict','player_image')
                ->where('videos.active', 1)
                ->where('videos.status', 1)
                ->where('videos.draft', 1);
    
            if (Geofencing() != null && Geofencing()->geofencing == 'ON') {
                $videos->whereNotIn('videos.id', Block_videos());
            }
    
            if ($check_Kidmode == 1) {
                $videos->whereBetween('videos.age_restrict', [0, 12]);
            }
    
            $videos->latest('videos.created_at')->get();
        }])
        ->select('video_categories.id', 'video_categories.name', 'video_categories.slug', 'video_categories.in_home', 'video_categories.order')
        ->where('video_categories.in_home', 1)
        ->whereHas('category_videos', function ($query) use ($check_Kidmode) {
            $query->where('videos.active', 1)->where('videos.status', 1)->where('videos.draft', 1);
    
            if (Geofencing() != null && Geofencing()->geofencing == 'ON') {
                $query->whereNotIn('videos.id', Block_videos());
            }
    
            if ($check_Kidmode == 1) {
                $query->whereBetween('videos.age_restrict', [0, 12]);
            }
        })
        ->orderBy('video_categories.order')
        ->get()
        ->map(function ($category) {
            $category->category_videos->map(function ($video) {
                $video->image_url = URL::to('/public/uploads/images/'.$video->image);
                $video->Player_image_url = URL::to('/public/uploads/images/'.$video->player_image);
                $video->source    = "Videos";
                return $video;
            });
            return $category;
        });
    
    endif;

    return $data;
  }

  private static function All_Homepage_category_livestream(){

    $live_category_status = MobileHomeSetting::pluck('live_category')->first();

      if( $live_category_status == null || $live_category_status == 0 ): 

          $data = array();      // Note - if the home-setting (Live category status) is turned off in the admin panel
      else:

          $data = LiveCategory::query()->whereHas('category_livestream', function ($query) {
                        $query->where('live_streams.active',1)->where('live_streams.status', 1);
                      })

          ->with(['category_livestream' => function ($live_stream_videos) {
              $live_stream_videos
                  ->select('live_streams.id','live_streams.title','live_streams.slug','live_streams.year','live_streams.rating','live_streams.access','live_streams.ppv_price','live_streams.publish_type','live_streams.publish_status','live_streams.publish_time','live_streams.duration','live_streams.rating','live_streams.image','live_streams.featured','live_streams.player_image')
                  ->where('live_streams.active',1)->where('live_streams.status', 1)
                  ->latest('live_streams.created_at');
          }])
          ->select('live_categories.id','live_categories.name', 'live_categories.slug', 'live_categories.order')
          ->orderBy('live_categories.order')
          ->get();
      
          $data->each(function ($category) {
              $category->category_livestream->transform(function ($item) {
                  $item['image_url'] = URL::to('public/uploads/images/'.$item->image);
                  $item['Player_image_url'] = URL::to('public/uploads/images/'.$item->player_image);
                  $item['source'] = "Livestream";
                  return $item;
              });
        });

      endif;

    return $data;
  }

  private static function All_Homepage_Audio_Genre(){

    $Audio_Genre_status = MobileHomeSetting::pluck('AudioGenre')->first();

      if( $Audio_Genre_status == null || $Audio_Genre_status == 0 ): 

          $data = array();      // Note - if the home-setting (Audio Genre status) is turned off in the admin panel
      else:

        $data = AudioCategory::query()->latest()->limit(30)->get()->map(function ($item) {
              $item['image_url'] = URL::to('public/uploads/audios/'.$item->image) ;
              $item['Player_image_url'] = URL::to('public/uploads/audios/'.$item->player_image) ;
              $item['source']    = "Audios";
            return $item;
        });

      endif;

    return $data;

  }

  private static function All_Homepage_Audio_Genre_audios(){

    $Audio_Genre_audios_status = MobileHomeSetting::pluck('AudioGenre_audios')->first();

      if( $Audio_Genre_audios_status == null || $Audio_Genre_audios_status == 0 ): 

          $data = array();      // Note - if the home-setting (Audio Genre Audios status) is turned off in the admin panel
      else:
          
        $data = AudioCategory::query()->whereHas('category_audios', function ($query) {
            $query->where('audio.active', 1);
          })
          ->with(['category_audios' => function ($audios_videos) {
              $audios_videos
                  ->select('audio.id','audio.title','audio.slug','audio.year','audio.rating','audio.access','audio.ppv_price','audio.duration','audio.rating','audio.image','audio.featured','audio.player_image')
                  ->where('audio.active', 1)
                  ->latest('audio.created_at');
          }])
          ->select('audio_categories.id', 'audio_categories.name', 'audio_categories.slug', 'audio_categories.order')
          ->orderBy('audio_categories.order')
          ->get();
      
          $data->each(function ($category) {
              $category->category_audios->transform(function ($item) {
                  $item['image_url'] = URL::to('public/uploads/audios/'.$item->image);
                  $item['Player_image_url'] = URL::to('public/uploads/audios/'.$item->player_image) ;
                  $item['source']    = "Audios";
                  return $item;
              });
        });
    
      endif;

    return $data;
  }

          // Only for Nemisha - Learn function
  public function learn()
  {
    try {

          $series_categories = SeriesGenre::where('category_list_active',1)->pluck('id');

          $series = SeriesGenre::query()->with(['category_series' => function ($series) {
                    $series->select('series.id','series.slug', 'series.image', 'series.title', 'series.duration', 'series.rating', 'series.featured')
                        ->where('series.active', '1')
                        ->latest('series.created_at');
                }])
                ->select('series_genre.id', 'series_genre.name', 'series_genre.in_home', 'series_genre.slug', 'series_genre.order')
                ->orderBy('series_genre.order')
                ->whereIn('series_genre.id', $series_categories)
                ->get();
            
          $series = $series->map(function ($genre) {
                $genre->category_series = $genre->category_series->map(function ($item) {
                    $item->image_url     = URL::to('/public/uploads/images/'.$item->image);
                    $item->redirect_url  = URL::to('play_series/'. $item->slug);
                    $item->season_count  = SeriesSeason::where('series_id',$item->id)->count();
                    $item->Episode_count = Episode::where('series_id',$item->id)->count();
                    return $item;
                });
                return $genre;
          });

          $series_sliders = Series::join('series_categories', 'series_categories.series_id', '=', 'series.id')
                                ->whereIn('series_categories.category_id', $series_categories)
                                ->where('series.active', 1 )
                                ->where('banner',1)
                                ->get();


            $Series_videos_data[] = $series ;

            return response()->json([
              'status'  => 'true',
              'Message' => 'Learn videos Retrieved Successfully',
              'series'    => $series,
              'series_sliders' => $series_sliders,
              'series_categories' => $series_categories ,
              'ppv_gobal_price'  => $this->ppv_gobal_price,
              'Series_videos_andriod' => $Series_videos_data ,
              'currency'         => CurrencySetting::first(),
              'ThumbnailSetting' => ThumbnailSetting::first(),
            ], 200);

    } catch (\Throwable $th) {

            return response()->json([
              'status'  => 'false',
              'Message' => $th->getMessage(),
          ], 200);

    }
  }

  public function series_image_details(Request $request)
  {
    try {

        $series = Series::select('id','image','player_image','tv_image')->findOrFail($request->series_id);

        $series['image_url'] = URL::to('public/uploads/images/' . $series->image);
        $series['banner_image_url'] = URL::to('public/uploads/images/' . $series->player_image);
        $series['Tv_image_url'] = URL::to('public/uploads/images/' . $series->tv_image);
        $series['source'] = "Series";

       return response()->json([
        'status'  => 'true',
        'Message' => 'series Image Retrieved Successfully',
        'Series_image' => $series,
      ], 200);

    } catch (\Throwable $th) {

        return response()->json([
          'status'  => 'false',
          'Message' => $th->getMessage(),
        ], 200);
    }

  }
  

  public function Category_Videos(Request $request)
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

    $videocategories = VideoCategory::select('id','image')->orderBy('order', 'ASC')->get()->toArray();
    $myData = array();
    foreach ($videocategories as $key => $videocategory) {
      $videocategoryid = $videocategory['id'];
      $genre_image = $videocategory['image'];

      $videos= Video::Join('categoryvideos','categoryvideos.video_id','=','videos.id')->where('categoryvideos.category_id',$videocategoryid)
      ->where('active','=',1)->where('status','=',1)->where('draft','=',1)->orderBy('videos.created_at', 'desc')->get()->map(function ($item) {
        $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
        $item['video_url'] = URL::to('/').'/storage/app/public/';
        $item['category_name'] = VideoCategory::where('id',$item->category_id)->pluck('slug')->first();

        return $item;
      });

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

        "message" => $msg,
        'gener_name' =>  VideoCategory::where('id',$videocategoryid)->pluck('name')->first(),
        'home_genre' =>  VideoCategory::where('id',$videocategoryid)->pluck('home_genre')->first(),
        'gener_id' =>  VideoCategory::where('id',$videocategoryid)->pluck('id')->first(),
        "videos" => $videos
      );
    }


    $response = array(
      'status' => 'true',
      'genre_movies' => $myData,
      'main_genre' => $msg,
      'main_genre' => $main_genre,

    );
    return response()->json($response, 200);
  }

  
  public function relatedtvvideos(Request $request) {
    
    $videoid = $request->videoid;
   
      // Recomendeds
                
      $recomendeds = Video::select('videos.*', 'video_categories.name as categories_name', 'categoryvideos.category_id as categories_id')
      ->Join('categoryvideos', 'videos.id', '=', 'categoryvideos.video_id')
      ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
      ->where('videos.id', '!=', $videoid)
      ->where('videos.active',  1)
      ->where('videos.status',  1)
      ->where('videos.draft',  1)
      ->limit(10)
      ->get()->map(function ($item) {
        $item['image_url'] = URL::to('/').'/public/uploads/images/'.$item->image;
        return $item;
      });
      $response = array(
      'status'=>'true',
      'channelrecomended' => $recomendeds
    );
    return response()->json($response, 200);
  }

  public function LoggedUserDeviceDelete (Request $request)
  {
      
    LoggedDevice::where("id",  $request->user_id)->delete();
      $response = array(
        'status'=>'true',
        'message' => 'Deleted User successfully'
      );
    return response()->json($response, 200);

  }

}
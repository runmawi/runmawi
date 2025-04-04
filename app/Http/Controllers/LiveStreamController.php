<?php

namespace App\Http\Controllers;
use DB;
use URL;
use Auth;
use Hash;
use View;
use Theme;
use Session;
use App\Genre;
use App\User ;
use \Redirect ;
use App\Channel;
use App\Setting;
use App\Favorite;
use App\Language;
use App\TimeZone;
use App\Wishlist;
use App\SiteTheme;
use Carbon\Carbon;
use App\ButtonText;
use App\Geofencing;
use App\LiveStream;
use App\RecentView;
use App\Watchlater;
use App\HomeSetting;
use App\LikeDislike;
use App\Adsvariables;
use App\CategoryLive;
use App\LiveCategory;
use App\LivePurchase;
use App\M3UFileParser;
use App\SystemSetting;
use App\ModeratorsUser;
use App\PaymentSetting;
use App\BlockLiveStream;
use App\CurrencySetting;
use App\AdminLandingPage;
use App\ThumbnailSetting;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use App\PartnerMonetization;
use Illuminate\Http\Request;
use App\AdminAccessPermission;
use App\UserChannelSubscription;
use App\PartnerMonetizationSetting;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\ImageManagerStatic as Image;

class LiveStreamController extends Controller
{

  public function __construct()
  {

      $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
      $userIp = $geoip->getip();
      $countryName = $geoip->getCountry();
      $regionName = $geoip->getregion();
      $cityName = $geoip->getcity();

      $this->countryName = $countryName;

      $settings = Setting::first();
      $this->videos_per_page = $settings->videos_per_page;

      $this->Theme = HomeSetting::pluck('theme_choosen')->first();
      Theme::uses($this->Theme);

  }

    public function Index()
    {

      try {

          $current_timezone = current_timezone();

          $settings = Setting::first();

          if($settings->enable_landing_page == 1 && Auth::guest()){

              $landing_page_slug = AdminLandingPage::where('status',1)->pluck('slug')->first() ? AdminLandingPage::where('status',1)->pluck('slug')->first() : "landing-page" ;

              return redirect()->route('landing_page', $landing_page_slug );
          }

          $live = LiveStream::where('active', '1')->where('status', 1)->latest()->get();

          $livestreams_data = LiveStream::select('id', 'title', 'slug', 'year', 'rating', 'access', 'publish_type', 'publish_time', 'publish_status', 'ppv_price',
                                                'duration', 'rating', 'image', 'featured', 'Tv_live_image', 'player_image', 'details', 'description', 'free_duration',
                                                'recurring_program', 'program_start_time', 'program_end_time', 'custom_start_program_time', 'custom_end_program_time',
                                                'recurring_timezone', 'recurring_program_week_day', 'recurring_program_month_day')
                                        ->where('active', 1)
                                        ->where('status', 1)
                                       ->latest()
                                        ->get();


          $livestreams_data = $livestreams_data->filter(function ($livestream) use ($current_timezone) {

            if ($livestream->publish_type === 'recurring_program') {

                $Current_time = Carbon::now($current_timezone);
                $recurring_timezone = TimeZone::where('id', $livestream->recurring_timezone)->value('time_zone');
                $convert_time = $Current_time->copy()->timezone($recurring_timezone);
                $midnight = $convert_time->copy()->startOfDay();

                switch ($livestream->recurring_program) {
                    case 'custom':
                        $recurring_program_Status = $convert_time->greaterThanOrEqualTo($midnight) && $livestream->custom_end_program_time >=  Carbon::parse($convert_time)->format('Y-m-d\TH:i') ;
                    break;

                    case 'daily':
                        $recurring_program_Status = $convert_time->greaterThanOrEqualTo($midnight) && $livestream->program_end_time >= $convert_time->format('H:i');
                    break;
                    case 'weekly':
                        $recurring_program_Status =  ( $livestream->recurring_program_week_day == $convert_time->format('N') ) && $convert_time->greaterThanOrEqualTo($midnight)  && ( $livestream->program_end_time >= $convert_time->format('H:i') );
                    break;

                    case 'monthly':
                        $recurring_program_Status = $livestream->recurring_program_month_day == $convert_time->format('d') && $convert_time->greaterThanOrEqualTo($midnight) && $livestream->program_end_time >= $convert_time->format('H:i');
                    break;

                    default:
                        $recurring_program_Status = false;
                    break;
                }

                switch ($livestream->recurring_program) {
                    case 'custom':
                        $recurring_program_live_animation = $livestream->custom_start_program_time <= $convert_time && $livestream->custom_end_program_time >= $convert_time;
                        break;
                    case 'daily':
                        $recurring_program_live_animation = $livestream->program_start_time <= $convert_time->format('H:i') && $livestream->program_end_time >= $convert_time->format('H:i');
                        break;
                    case 'weekly':
                        $recurring_program_live_animation = $livestream->recurring_program_week_day == $convert_time->format('N') && $livestream->program_start_time <= $convert_time->format('H:i') && $livestream->program_end_time >= $convert_time->format('H:i');
                        break;
                    case 'monthly':
                        $recurring_program_live_animation = $livestream->recurring_program_month_day == $convert_time->format('d') && $livestream->program_start_time <= $convert_time->format('H:i') && $livestream->program_end_time >= $convert_time->format('H:i');
                        break;

                    default:
                        $recurring_program_live_animation = false;
                    break;
                }

                $livestream->recurring_program_live_animation = $recurring_program_live_animation ;

                return $recurring_program_Status;
            }

            if( $livestream->publish_type === 'publish_later' ){

                $Current_time = Carbon::now($current_timezone);

                $publish_later_Status = Carbon::parse($livestream->publish_time)->format('Y-m-d\TH:i')  <=  $Current_time->format('Y-m-d\TH:i') ;

                return $publish_later_Status;
            }
            return true;
          });

          $data = array(
                        'videos' => $live,
                        'ThumbnailSetting' => ThumbnailSetting::first(),
                        'videos_expiry_date_status' => videos_expiry_date_status(),
                        'default_vertical_image_url' => default_vertical_image_url() ,
                        'default_horizontal_image_url' => default_horizontal_image_url() ,
                        'livestreams_data' => $livestreams_data ,
                      );


          return Theme::view('liveCategoryVideos',$data);

      } catch (\Throwable $th) {

        // return $th->getMessage();
        return abort(404);
      }
    }

    public function Play(Request $request,$vid)
    {
      try {
        
        $currentUrl = url()->current();
        if (strpos($currentUrl, '/app/') !== false){
            if (!auth()->check()) {
                $modifiedUrl = preg_replace('/\/app/', '', $currentUrl);
                session(['url.intended' => $modifiedUrl]);
                return redirect()->route('login');
            }else{
                if (strpos($currentUrl, '/app') !== false) {
                    $modifiedUrl = str_replace('/app', '', $currentUrl);
                    return redirect($modifiedUrl);
                }
            }
        }

      $Theme = HomeSetting::pluck('theme_choosen')->first();
      Theme::uses( $Theme );

      $ThumbnailSetting = ThumbnailSetting::first();
      $button_text = ButtonText::first();

      $button_sub_pur_status = SiteTheme::select('purchase_btn', 'subscribe_btn')->first();
      $purchase_btn = $button_sub_pur_status->purchase_btn;
      $subscribe_btn = $button_sub_pur_status->subscribe_btn;

      $enable_ppv_rent_live = Setting::pluck('enable_ppv_rent_live')->first();
      $ppv_live_description = Setting::pluck('live')->first();

      $settings = Setting::first();

      $data = session()->all();

      $categoryVideos = LiveStream::where('slug',$vid)->first();
      $source_id = LiveStream::where('slug',$vid)->pluck('id')->first();
        
       // Check Channel Purchase 
       
       $UserChannelSubscription = true ;

       if ( $settings->user_channel_plans_page_status == 1 && $this->Theme == "theme6") {

            $UserChannelSubscription = false ;

            $channel_id = LiveStream::where('id',$source_id)->where('uploaded_by','channel')->pluck('user_id')->first();

            if (is_null($channel_id)) {
                $UserChannelSubscription = true ;
            }

            if (!Auth::guest() && !is_null($channel_id) ) {

                $UserChannelSubscription = UserChannelSubscription::where('user_id',auth()->user()->id)
                                                ->where('channel_id',$channel_id)->where('status','active')
                                                ->where('subscription_start', '<=', Carbon::now())
                                                ->where('subscription_ends_at', '>=', Carbon::now())
                                                ->latest()->exists();

                if (Auth::user()->role == "admin") {
                    $UserChannelSubscription = true ;
                }
            }
        }

         // Channel Livestream videos

      if(@$categoryVideos->uploaded_by == 'Channel'){
          $user_id = $categoryVideos->user_id;

          $user = Channel::where("channels.id", "=", $user_id )
          ->join("users","channels.email","=","users.email")
          ->select("users.id as user_id")
          ->first();

          if(!Auth::guest() &&  $user->user_id == Auth::user()->id){
              $video_access = 'free';
          }else{
              $video_access = 'pay';
          }

          // CPP Livestream videos

      }else if(@$categoryVideos->uploaded_by == 'CPP'){

          $user_id = $categoryVideos->user_id;

          $user = ModeratorsUser::where("moderators_users.id", "=", $user_id )
              ->join("users","moderators_users.email","=","users.email")
              ->select("users.id as user_id")
              ->first();

          $video_access = !Auth::guest() &&  $user->user_id == Auth::user()->id ? 'free' :  'pay' ;

          // Admin Livestream videos
      }else{
          if(!Auth::guest() &&  @$categoryVideos->access  == 'ppv' ||  @$categoryVideos->access  == 'subscriber' &&  !Auth::guest() && Auth::user()->role != 'admin' ){
              $video_access = 'pay';
          }else{
              $video_access = 'free';
          }
      }

      $vid =  $categoryVideos->id;

      if(!Auth::guest()){
        $user_id = Auth::user()->id;
      }

        

          if(!Auth::guest()){
              //$ppv_exist = LivePurchase::where('video_id',$vid)->where('user_id',$user_id)->where('status',1)->latest()->count();
              $current_date = Carbon::now()->format('Y-m-d H:i:s a');
              $ppv_exist = LivePurchase::where('video_id',$vid)
                                        ->where('user_id', $user_id)
                                        ->where('to_time','>',$current_date)
                                        ->where('status', 1)
                                        ->orderBy('created_at', 'desc')
                                        ->get()->map(function ($item){
                                            $payment_status = payment_status($item);
                                            if ($payment_status === null || $item->payment_status === $payment_status) {
                                                return $item;
                                            }
                                                return null;
                                        })->first();

              $ppv_exist = !empty($ppv_exist) ? 1 : 0;

              //$ppv_exists = LivePurchase::where('video_id',$vid)->where('user_id',$user_id)->where('status',1)->latest()->count();
              $ppv_exists = LivePurchase::where('video_id',$vid)
                                        ->where('user_id', $user_id)
                                        ->where('to_time','>',$current_date)
                                        ->where('status', 1)
                                        ->orderBy('created_at', 'desc')
                                        ->get()->map(function ($item){
                                            $payment_status = payment_status($item);
                                            if ($payment_status === null || $item->payment_status === $payment_status) {
                                                return $item;
                                            }
                                                return null;
                                        })->first();
                $ppv_exists = !empty($ppv_exists) ? 1 : 0;
          }
          else{
              $ppv_exist = [];
              $ppv_exists = 0;
          }

            $wishlisted = false;

            if(!Auth::guest()):
                    $wishlisted = Wishlist::where('user_id', '=', Auth::user()->id)->where('video_id', '=', $vid)->where('type', '=', 'live')->first();
            endif;

            $watchlater = false;

             if(!Auth::guest()):
                    $watchlater = Watchlater::where('user_id', '=', Auth::user()->id)->where('video_id', '=', $vid)->where('type', '=', 'live')->first();
             endif;
             $session = Session::all();

             if(!empty($session['password_hash'])){
              $password_hash = $session['password_hash'];
             }else{
              $password_hash = "";
             }

             $payment_settings = PaymentSetting::first();
              $mode = $payment_settings->live_mode ;
                if($mode == 0){
                    $secret_key = $payment_settings->test_secret_key ;
                    $publishable_key = $payment_settings->test_publishable_key ;
                }elseif($mode == 1){
                    $secret_key = $payment_settings->live_secret_key ;
                    $publishable_key = $payment_settings->live_publishable_key ;
                }else{
                    $secret_key= null;
                    $publishable_key= null;
                }

             $currency = CurrencySetting::first();
             if (!empty($categoryVideos->publish_time))
             {
                 $new_date = Carbon::parse($categoryVideos->publish_time)
                     ->format('M d ,y H:i:s');
                 $currentdate = date("M d , y H:i:s");
                 date_default_timezone_set('Asia/Kolkata');
                 $current_date = Date("M d , y H:i:s");
                 $date = date_create($current_date);
                 $currentdate = date_format($date, "M d ,y H:i:s");
               
                 if ($currentdate < $new_date)
                 {

                     $new_date = Carbon::parse($categoryVideos->publish_time)
                         ->format('M d , y H:i:s');

                 }
                 else
                 {

                     $new_date = null;
                 }
             }
             else
             {
                 $new_date = null;
             }

             $payment_setting = PaymentSetting::where('status',1)->where('live_mode',1)->get();

             $Razorpay_payment_setting = PaymentSetting::where('payment_type','Razorpay')->where('status',1)->first();

             $Paystack_payment_setting = PaymentSetting::where('payment_type','Paystack')->where('status',1)->first();

             $stripe_payment_setting = PaymentSetting::where('payment_type','Stripe')->where('stripe_status',1)->first();

             $paydunya_payment_setting = PaymentSetting::where('payment_type','Paydunya')->where('status',1)->first();

             $view = new RecentView;
             $view->user_id      = Auth::User() ? Auth::User()->id : null ;
             $view->country_name = $this->countryName ? $this->countryName : null ;
             $view->sub_user     = null ;
             $view->visited_at   = Carbon::now()->year;
             $view->live_id      = $vid ;
             $view->save();

            //  M3U
             $M3U_files =  $categoryVideos->m3u_url;
             $parser = new M3UFileParser($M3U_files);
             $M3U_channels = $parser->list() ;

             $category_name = CategoryLive::select('live_categories.name as categories_name','live_categories.slug as categories_slug','livecategories.live_id')
                                ->Join('live_categories', 'livecategories.category_id', '=', 'live_categories.id')
                                ->where('livecategories.live_id', $vid)
                                ->get();

                    // Free duration PPV purchase - Note(If PPV purchase - 0 , otherwise 1)

            if ($categoryVideos->access == "ppv" && !Auth::guest()) {

                // $live_purchase_exists = LivePurchase::where('video_id', $vid)->where('user_id', Auth::user()->id)
                //     ->where('status', 1)->latest()->first();

                $current_date = Carbon::now()->format('Y-m-d H:i:s a');
                $live_purchase_exists = LivePurchase::where('video_id',$vid)
                                        ->where('user_id',$user_id)
                                        ->where('to_time','>',$current_date)
                                        ->where('status', 1)
                                        ->orderBy('created_at', 'desc')
                                        ->get()->map(function ($item){
                                            $payment_status = payment_status($item);
                                            if ($payment_status === null || $item->payment_status === $payment_status) {
                                                return $item;
                                            }
                                                return null;
                                        })->first();

                $live_purchase_status = !empty($live_purchase_exists) ? 1 : 0;

            } elseif ($categoryVideos->access == "guest") {

                $live_purchase_status = 1;
            } else {

                $live_purchase_status = 0;
            }

            $free_duration_condition = $live_purchase_status == 0 && ( ( $categoryVideos->access == "ppv" && Auth::check() == true && Auth::user()->role != "admin" ) || ( $categoryVideos->access == "subscriber" && ( Auth::guest() || Auth::user()->role == "registered"))) && $categoryVideos->free_duration_status == 1 && $categoryVideos->free_duration !== null ? 1 : 0;

            // video Js

            $currency = CurrencySetting::first();
            $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
            $getfeching = Geofencing::first();

            // Adsvariables

            $adsvariable_url = '';

            if ($settings->ads_variable_status == 1) {
                $adsvariables = Adsvariables::whereNotNull('website')->get();

                foreach ($adsvariables as $key => $ads_variable ) {
                    if ($key === 0) {
                        $adsvariable_url .= "?" . $ads_variable->name . "=" . $ads_variable->website;
                    } else {
                        $adsvariable_url .= "&" . $ads_variable->name . "=" . $ads_variable->website;
                    }
                }

                $adsvariable_url .= "&ads.content_cat=".$categoryVideos->ads_content_category
                                            ."&ads.content_genre=".$categoryVideos->ads_content_genre
                                            ."&ads.content_id=".$categoryVideos->ads_content_id
                                            ."&ads.content_language=".$categoryVideos->ads_content_language
                                            ."&ads.content_title=".$categoryVideos->ads_content_title
                                            ."&ads.channel_name=".$categoryVideos->title
                                            ."&ads.network_name=".$categoryVideos->title;
            }

            $Livestream_details = LiveStream::where('id',$vid)->where('status',1)
                                            ->get()
                                            ->map( function ($item)  use (  $adsvariable_url, $geoip , $settings , $currency , $getfeching)  {
                                            
                if( Auth::check() &&  Auth::user()->role == 'admin'){
                    $item['users_video_visibility_status']         = true ;
                    $item['access']         = 'guest' ;
                }

                $item['users_video_visibility_status']         = true ;
                $item['users_video_visibility_redirect_url']   = route('LiveStream_play',[ optional($item)->slug ]);
                $item['users_video_visibility_free_duration_status']  = 0 ;

                  // Check for guest user

                if( Auth::guest()  && $item->access != "guest"  ){
                    $button_text = ButtonText::first();

                    $item['users_video_visibility_status'] = false ;
                    $item['users_video_visibility_status_message'] = !empty($button_text->live_visible_text) ? $button_text->live_visible_text : (($item->access == "ppv") ? 'This Livestream is only for PPV users' : 'This Livestream is only for Subscribed users');
                    $item['users_video_visibility_redirect_url'] =  URL::to('/login')  ;
                    $item['users_video_visibility_Rent_button']      = false ;
                    $item['users_video_visibility_becomesubscriber'] = false ;
                    $item['users_video_visibility_register_button']  = true ;

                    $Rent_ppv_price = ($item->access == "ppv" && $currency->enable_multi_currency == 1) ? Currency_Convert($item->ppv_price) : currency_symbol().$item->ppv_price;
                    $item['users_video_visibility_status_button'] = ($item->access == "ppv") ? (!empty($button_text->purchase_text) ? ($button_text->purchase_text. ' ' .$Rent_ppv_price) : ' Purchase Now for '.$Rent_ppv_price) : (!empty($button_text->subscribe_text) ? $button_text->subscribe_text : $item->access.' Now');

                        // Free duration
                    if(  $item->free_duration_status ==  1 && !is_null($item->free_duration) ){
                        $item['users_video_visibility_status'] = true ;
                        $item['users_video_visibility_free_duration_status']  = 1;
                    }
                }

                  // Check for Login user - Register , Subscriber ,PPV

                if ( Auth::guest() || Auth::user()->role != 'admin') {

                    if( !Auth::guest() ){

                        // $ppv_exists_check_query = LivePurchase::where('video_id',$item['id'])->where('user_id', Auth::user()->id)->where('status',1)->latest()->count();

                        // $PPV_exists = !empty($ppv_exists_check_query) ? true : false ;
                        // dd( Auth::user()->id);

                        $current_date = Carbon::now()->format('Y-m-d H:i:s a');
                        $ppv_exists_check_query = LivePurchase::where('video_id',$item['id'])
                                                                ->where('user_id', Auth::user()->id)
                                                                ->where('to_time','>',$current_date)
                                                                ->where('status', 1)
                                                                ->orderBy('created_at', 'desc')
                                                                ->get()->map(function ($item){
                                                                    $payment_status = payment_status($item);
                                                                    if ($payment_status === null || $item->payment_status === $payment_status) {
                                                                        return $item;
                                                                    }
                                                                        return null;
                                                                })->first();

                        // dd($ppv_exists_check_query);
                       
                        $PPV_exists = !empty($ppv_exists_check_query) ? true : false ;





                        if( $item->access == "ppv" && Auth::user()->role == 'subscriber' && $settings->enable_ppv_rent_live == 1 ) {
                            $PPV_exists = true ;
                        }

                              // free PPV access for subscriber status Condition

                    //   if( $settings->enable_ppv_rent_live == 1 && Auth::user()->role != 'subscriber' ){

                    //       $PPV_exists = false ;
                    //   }

                        if( ( $item->access == "subscriber" && Auth::user()->role == 'registered' ) ||  ( $item->access == "ppv" && $PPV_exists == false ) ) {
                            
                            $item['users_video_visibility_status'] = false ;
                            $item['users_video_visibility_status_message'] = Str::title( 'this video only for '. ( $item->access == "subscriber" ? "subscriber" : "PPV " )  .' users' )  ;
                            $item['users_video_visibility_Rent_button']      =  $item->access == "ppv" ? true : false ;
                            $item['users_video_visibility_becomesubscriber_button'] =  Auth::user()->role == "registered" ? true : false ;
                            $item['users_video_visibility_register_button']  = false ;

                            $Rent_ppv_price = ($item->access == "ppv" && $currency->enable_multi_currency == 1) ? Currency_Convert($item->ppv_price) : currency_symbol().$item->ppv_price;
                            $item['users_video_visibility_status_button'] = ($item->access == "ppv") ? ' Purchase Now for '.$Rent_ppv_price : $item->access.' Now';

                            if ($item->access == "ppv") {

                                $item['users_video_visibility_redirect_url'] =  'live-purchase-now-button' ;

                            } elseif( Auth::user()->role == 'registered') {

                                $item['users_video_visibility_redirect_url'] =  URL::to('/becomesubscriber') ;
                            }

                                // Free duration

                            if(  $item->free_duration_status ==  1 && !is_null($item->free_duration) ){
                                $item['users_video_visibility_status'] = true ;
                                $item['users_video_visibility_free_duration_status']  = 1;
                            }
                        }

                        if ( $settings->enable_ppv_rent_live == 1 && $item->access == "ppv" && !Auth::guest() &&  Auth::user()->role == 'subscriber' ) {
                            if(  $item->free_duration_status ==  1 && !is_null($item->free_duration) ){
                                $item['users_video_visibility_status'] = true ;
                                $item['users_video_visibility_free_duration_status']  = 0;
                            }
                        }
                    }
                      // Block Countries

                    if(  $getfeching !=null && $getfeching->geofencing == 'ON'){

                        // $block_videos_exists = $item->whereIn('videos.id', Block_LiveStreams())->exists();
                        $block_videos_exists = null;

                        if ($block_videos_exists) {

                            $item['users_video_visibility_status'] = false;
                            $item['users_video_visibility_status_message'] = Str::title( 'this Livestream only Not available in this country')  ;
                            $item['users_video_visibility_Rent_button']    = false ;
                            $item['users_video_visibility_becomesubscriber_button'] = false ;
                            $item['users_video_visibility_register_button']  = false ;
                            $item['users_video_visibility_redirect_url'] = URL::to('/blocked');

                        }
                    }
                }

              $item['Thumbnail']        = !is_null($item->image)  ? URL::to('public/uploads/images/'.$item->image) : default_vertical_image_url() ;
              $item['Player_thumbnail'] = !is_null($item->player_image)  ? URL::to('public/uploads/images/'.$item->player_image ) : default_horizontal_image_url() ;
              $item['TV_Thumbnail']     = !is_null($item->video_tv_image)  ? URL::to('public/uploads/images/'.$item->video_tv_image)  : default_horizontal_image_url() ;
              $item['public_current_time'] = !empty($item->publish_time) ? \Carbon\Carbon::parse($item->publish_time)->format('d F Y') : \Carbon\Carbon::parse($item->created_at)->format('d F Y') ;

                  //  Livestream URL

                switch (true) {

                    case $item['url_type'] == "mp4" &&  pathinfo($item['mp4_url'], PATHINFO_EXTENSION) == "mp4" :
                        $item['livestream_URL'] =  $item->mp4_url ;
                        $item['livestream_player_type'] =  'video/mp4' ;
                    break;

                    case $item['url_type'] == "mp4" &&  pathinfo($item['mp4_url'], PATHINFO_EXTENSION) == "m3u8" :
                    $item['livestream_URL'] =  $item->mp4_url.$adsvariable_url; ;
                    $item['livestream_player_type'] =  'application/x-mpegURL' ;
                    break;

                    case $item['url_type'] == "embed":
                        $item['livestream_URL'] =  $item->embed_url ;
                        $item['livestream_player_type'] =  'video/mp4' ;
                    break;

                    case $item['url_type'] == "live_stream_video":
                        $item['livestream_URL'] = $item->live_stream_video.$adsvariable_url; ;
                        $item['livestream_player_type'] =  'application/x-mpegURL' ;
                    break;

                    case $item['url_type'] == "m3u_url":
                        $item['livestream_URL'] =  $item->m3u_url ;
                        $item['livestream_player_type'] =  'application/x-mpegURL' ;
                    break;

                    case $item['url_type'] == "Encode_video":
                        $item['livestream_URL'] =  $item->hls_url.$adsvariable_url; ;
                        $item['livestream_player_type'] =  'application/x-mpegURL'  ;
                    break;

                    case $item['url_type'] == "acc_audio_url":
                    $item['livestream_URL'] =  $item->acc_audio_url ;
                    $item['livestream_player_type'] =  'audio/aac' ;
                    break;

                    case $item['url_type'] == "acc_audio_file":
                        $item['livestream_URL'] =  $item->acc_audio_file ;
                        $item['livestream_player_type'] =  'audio/aac' ;
                    break;

                    case $item['url_type'] == "aws_m3u8":
                    $item['livestream_URL'] =  $item->hls_url.$adsvariable_url; ;
                    $item['livestream_player_type'] =  'application/x-mpegURL' ;
                    break;

                    default:
                        $item['livestream_URL'] =  null ;
                        $item['livestream_player_type'] =  null ;
                    break;
                }

                //   Livestream schedule epg

                switch ($item->publish_type) {
                    
                    case 'publish_now':

                        $item['epg_program_title'] = $item->title;
                        $item['epg_program_start_time'] = null;
                        $item['epg_program_end_time']   = null;
                        $item['epg_program_timeloop_parse']   = Carbon::today();
                    break;

                    case 'publish_later':

                        $item['epg_program_title'] = $item->title;
                        $item['epg_program_start_time'] = $item->publish_time;
                        $item['epg_program_end_time']   = null;
                        $item['epg_program_timeloop_parse']   = Carbon::today();
                    break;
                    
                    case 'recurring':

                        $item['epg_program_title'] = $item->title;
                        $item['epg_program_start_time'] = json_decode($item->scheduler_program_start_time);
                        $item['epg_program_end_time'] = json_decode($item->scheduler_program_end_time);
                        $item['epg_program_timeloop_parse']   = Carbon::today();
                    break;

                    case 'schedule_program':

                        $item['epg_program_title'] = json_decode($item->scheduler_program_title);
                        $item['epg_program_start_time'] = json_decode($item->scheduler_program_start_time);
                        $item['epg_program_end_time'] = json_decode($item->scheduler_program_end_time);
                        $item['epg_program_timeloop_parse']   = Carbon::today();
                        break;

                    default:
                        $item['epg_program_title']      = null;
                        $item['epg_program_start_time'] = null;
                        $item['epg_program_end_time']   = null;
                        $item['epg_program_timeloop_parse']   = null;
                        break;
                }

            $item['watchlater_exist'] = Watchlater::where('live_id', $item->id)->where('type', 'live')
                                            ->where(function ($query) use ($geoip) {
                                                if (!Auth::guest()) {
                                                    $query->where('user_id', Auth::user()->id);
                                                } else {
                                                    $query->where('users_ip_address', $geoip->getIP());
                                                }
                                            })->first();


            $item['Like_exist'] = LikeDislike::where('live_id', $item->id)->where('liked',1)
                                                ->where(function ($query) use ($geoip) {
                                                    if (!Auth::guest()) {
                                                        $query->where('user_id', Auth::user()->id);
                                                    } else {
                                                        $query->where('users_ip_address', $geoip->getIP());
                                                    }
                                                })->latest()->first();

            $item['dislike_exist'] = LikeDislike::where('live_id',  $item->id)->where('disliked',1)
                                            ->where(function ($query) use ($geoip) {
                                                if (!Auth::guest()) {
                                                    $query->where('user_id', Auth::user()->id);
                                                } else {
                                                    $query->where('users_ip_address', $geoip->getIP());
                                                }
                                            })->latest()->first();


              return $item;

            })->first();

            // Payment Gateway Paypal

            $PayPalpayment = PaymentSetting::where('payment_type', 'PayPal')->where('status',1)->first();

            $PayPalmode = !is_null($PayPalpayment) ? $PayPalpayment->paypal_live_mode : null;

            $paypal_password = null;
            $paypal_signature = null;

            if (!is_null($PayPalpayment)) {

                switch ($PayPalpayment->paypal_live_mode ) {
                    case 0:
                        $paypal_password = $PayPalpayment->test_paypal_password;
                        $paypal_signature = $PayPalpayment->test_paypal_signature;
                        break;

                    case 1:
                        $paypal_password = $PayPalpayment->live_paypal_password;
                        $paypal_signature = $PayPalpayment->live_paypal_signature;
                        break;

                    default:
                        $paypal_password = null;
                        $paypal_signature = null;
                        break;
                }
            }
            
            $RadioStation = LiveStream::where('stream_upload_via','radio_station')->get()->map(function ($item) {
                switch (true) {
                    case $item['url_type'] == "embed":
                        $item['livestream_URL'] = $item->embed_url;
                        $item['livestream_player_type'] = 'video/mp4';
                        break;
            
                    case $item['url_type'] == "m3u_url":
                        $item['livestream_URL'] = $item->m3u_url;
                        $item['livestream_player_type'] = 'application/x-mpegURL';
                        break;
            
                    case $item['url_type'] == "acc_audio_url":
                        $item['livestream_URL'] = $item->acc_audio_url;
                        $item['livestream_player_type'] = 'audio/aac';
                        break;
            
                    case $item['url_type'] == "acc_audio_file":
                        $item['livestream_URL'] = $item->acc_audio_file;
                        $item['livestream_player_type'] = 'audio/aac';
                        break;
            
                    default:
                        $item['livestream_URL'] = null;
                        $item['livestream_player_type'] = null;
                        break;
                }
            
                return $item; // Important: return the modified item
            });

            $related_radiostation = LiveStream::where('stream_upload_via','radio_station')->whereNotIn('id',[$vid])->inRandomOrder()->get();
            $default_vertical_image_url = default_vertical_image_url();

            if($Livestream_details->active == 1 || ($Livestream_details->active == 0 && Auth::user()->role == 'admin')){
                $data = array(
                    'currency'     => $currency,
                    'video_access' => $video_access,
                    'video'        => $categoryVideos,
                    'password_hash' => $password_hash,
                    'publishable_key' => $publishable_key,
                    'ppv_exist'  => $ppv_exist,
                    'ppv_exists' => $ppv_exists ,
                    'ppv_price'  => $categoryVideos->ppv_price,
                    'watchlatered' => $watchlater,
                    'mywishlisted' => $wishlisted,
                    'new_date'     => $new_date,
                    'payment_setting' => $payment_setting,
                    'Razorpay_payment_setting' => $Razorpay_payment_setting,
                    'Paystack_payment_setting' => $Paystack_payment_setting ,
                    'stripe_payment_setting'   => $stripe_payment_setting ,
                    'paydunya_payment_setting' => $paydunya_payment_setting ,
                    'Related_videos' => LiveStream::whereNotIn('id',[$vid])->where('active','1')->inRandomOrder()->get(),
                    'Paystack_payment_settings' => PaymentSetting::where('payment_type','Paystack')->first() ,
                    'M3U_channels' => $M3U_channels ,
                    'M3U_files'    => $M3U_files ,
                    'source_id'    => $source_id,
                    'commentable_type' => "LiveStream_play" ,
                    'CinetPay_payment_settings' => PaymentSetting::where('payment_type','CinetPay')->first() ,
                    'category_name'   => $category_name ,
                    'live_purchase_status' => $live_purchase_status ,
                    'free_duration_condition' => $free_duration_condition ,
                    'Livestream_details'      => $Livestream_details ,
                    'Radio_station_lists'      => $RadioStation ,
                    'Related_radiostation' => $related_radiostation,
                    'media_url' => URL::to('/').'/radio-station/',
                    'video_viewcount_limit' => PartnerMonetizationSetting::pluck('video_viewcount_limit')->first(),
                    'user_role'               => Auth::check() ? Auth::user()->role : 'guest',
                    'setting'                => $settings,
                    'current_theme'          => $this->Theme,
                    'enable_ppv_rent_live'  => $enable_ppv_rent_live,
                    'ppv_live_description'   => $ppv_live_description,
                    'ThumbnailSetting'      => $ThumbnailSetting,
                    'button_text'          => $button_text,
                    'purchase_btn'                    => $purchase_btn,
                    'subscribe_btn'                    => $subscribe_btn,
                    'default_vertical_image_url'                    => $default_vertical_image_url,
                    'play_btn_svg'  => '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="80px" height="80px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                                            <polygon class="triangle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="73.5,62.5 148.5,105.8 73.5,149.1 " style="stroke: white !important;"></polygon>
                                            <circle class="circle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" style="stroke: white !important;"></circle>
                                        </svg>',
                    'paypal_payment_setting' => $PayPalpayment,
                    'paypal_signature' => $paypal_signature,
                    'AdminAccessPermission' => AdminAccessPermission::first(),
                    'UserChannelSubscription' => $UserChannelSubscription,
                );   
                // dd($data);        

                if(  $Theme == "default" || $Theme == "theme3" || $Theme == "theme6" || $Theme == "theme4" ){
                    // dd($data['default_vertical_image_url ']);
                    return Theme::view('video-js-Player.Livestream.live', $data);
                }else{
                    return Theme::view('livevideo', $data);
                }
            } else {
                return abort(404);
            }
            
        } catch (\Throwable $th) {
            // return $th->getMessage();
            return abort(404);
        }
        }

        public function getEpgContent(Request $request)
        {
            $liveId = $request->query('live_id');
    
            $LivestreamDetails = Livestream::find($liveId);
            $current_theme = $this->Theme;
            
            if (!$LivestreamDetails) {
                return response('No details found', 404);
            }
    
            return Theme::uses("{$current_theme}")->load("public/themes/{$current_theme}/views/livevideo-schedule-epg", [
                'Livestream_details' => $LivestreamDetails,
                'current_theme' => $current_theme,
            ])->content();
        }

        public function videojs_live_watchlater(Request $request)
        {
            try {

                $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();

                $inputs = [
                    'live_id' => $request->live_id,
                    'type' => 'live',
                    'user_id' => !Auth::guest() ? Auth::user()->id : null,
                    'users_ip_address' => Auth::guest() ? $geoip->getIP() : null,
                ];

                $watchlater_exist = Watchlater::where('live_id', $request->live_id)->where('type', 'live')
                                            ->where(function ($query) use ($geoip) {
                                                if (!Auth::guest()) {
                                                    $query->where('user_id', Auth::user()->id);
                                                } else {
                                                    $query->where('users_ip_address', $geoip->getIP());
                                                }
                                            })->first();


                !is_null($watchlater_exist) ? $watchlater_exist->delete() : Watchlater::create( $inputs ) ;

                $response = array(
                    'status'=> true,
                    'watchlater_status' => is_null($watchlater_exist) ? "Add" : "Remove "  ,
                    'message'=> is_null($watchlater_exist) ? "This video was successfully added to Watchlater's list" : "This video was successfully remove from Watchlater's list"  ,
                );

            } catch (\Throwable $th) {

                $response = array(
                    'status'=> false,
                    'message'=> $th->getMessage(),
                  );
            }

            return response()->json(['data' => $response]);
        }

        public function videojs_live_wishlist(Request $request)
        {
            try {

                $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();

                $inputs = [
                    'live_id' => $request->live_id,
                    'type' => 'live',
                    'user_id' => !Auth::guest() ? Auth::user()->id : null,
                    'users_ip_address' => Auth::guest() ? $geoip->getIP() : null,
                ];

                $wishlist_exist = Wishlist::where('live_id', $request->live_id)->where('type', 'live')
                                            ->where(function ($query) use ($geoip) {
                                                if (!Auth::guest()) {
                                                    $query->where('user_id', Auth::user()->id);
                                                } else {
                                                    $query->where('users_ip_address', $geoip->getIP());
                                                }
                                            })->first();


                !is_null($wishlist_exist) ? $wishlist_exist->delete() : Wishlist::create( $inputs ) ;

                $response = array(
                    'status'=> true,
                    'wishlist_status' => is_null($wishlist_exist) ? "Add" : "Remove "  ,
                    'message'=> is_null($wishlist_exist) ? "This video was successfully added to wishlist's list" : "This video was successfully remove from wishlist's list"  ,
                );

            } catch (\Throwable $th) {

                $response = array(
                    'status'=> false,
                    'message'=> $th->getMessage(),
                  );
            }

            return response()->json(['data' => $response]);
        }

        public function videojs_live_Like(Request $request)
        {
            try {

                $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();

                $inputs = [
                    'live_id' => $request->live_id,
                    'user_id' => !Auth::guest() ? Auth::user()->id : null,
                    'users_ip_address' => Auth::guest() ? $geoip->getIP() : null,
                    'disliked'   => 0 ,
                ];

                $check_Like_exist = LikeDislike::where('live_id', $request->live_id)->where('liked',1)
                                            ->where(function ($query) use ($geoip) {
                                                if (!Auth::guest()) {
                                                    $query->where('user_id', Auth::user()->id);
                                                } else {
                                                    $query->where('users_ip_address', $geoip->getIP());
                                                }
                                            })->first();

                $inputs += [ 'liked'  => is_null($check_Like_exist) ? 1 : 0 , ];


                $Like_exist = LikeDislike::where('live_id', $request->live_id)
                                            ->where(function ($query) use ($geoip) {
                                                if (!Auth::guest()) {
                                                    $query->where('user_id', Auth::user()->id);
                                                } else {
                                                    $query->where('users_ip_address', $geoip->getIP());
                                                }
                                            })->first();

                !is_null($Like_exist) ? $Like_exist->find($Like_exist->id)->update($inputs) : LikeDislike::create( $inputs ) ;

                $response = array(
                    'status'=> true,
                    'like_status' => is_null($check_Like_exist) ? "Add" : "Remove "  ,
                    'message'=> is_null($check_Like_exist) ? "You liked this video." : "You removed from liked this video."  ,
                );

            } catch (\Throwable $th) {

                $response = array(
                    'status'=> false,
                    'message'=> $th->getMessage(),
                  );
            }

            return response()->json(['data' => $response]);
        }

        public function videojs_live_disLike(Request $request)
        {
            try {

                $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();

                $inputs = [
                    'live_id' => $request->live_id,
                    'user_id' => !Auth::guest() ? Auth::user()->id : null,
                    'users_ip_address' => Auth::guest() ? $geoip->getIP() : null,
                    'liked'      => 0 ,
                ];

                $check_dislike_exist = LikeDislike::where('live_id', $request->live_id)->where('disliked',1)
                                            ->where(function ($query) use ($geoip) {
                                                if (!Auth::guest()) {
                                                    $query->where('user_id', Auth::user()->id);
                                                } else {
                                                    $query->where('users_ip_address', $geoip->getIP());
                                                }
                                            })->first();

                $inputs += [ 'disliked'  => is_null($check_dislike_exist) ? 1 : 0 , ];


                $dislike_exists = LikeDislike::where('live_id', $request->live_id)
                                            ->where(function ($query) use ($geoip) {
                                                if (!Auth::guest()) {
                                                    $query->where('user_id', Auth::user()->id);
                                                } else {
                                                    $query->where('users_ip_address', $geoip->getIP());
                                                }
                                            })->first();


                !is_null($dislike_exists) ? $dislike_exists->find($dislike_exists->id)->update($inputs) : LikeDislike::create( $inputs ) ;

                $response = array(
                    'status'=> true,
                    'dislike_status' => is_null($check_dislike_exist) ? "Add" : "Remove "  ,
                    'message'=> is_null($check_dislike_exist) ? "You disliked this video" : "You removed from disliked this video."  ,
                );

            } catch (\Throwable $th) {

                $response = array(
                    'status'=> false,
                    'message'=> $th->getMessage(),
                  );
            }

            return response()->json(['data' => $response]);
        }

        public function channelVideos($cid)
        {

          $getfeching = Geofencing::first();
          $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
          $userIp = $geoip->getip();
          $countryName = $geoip->getCountry();
          $ThumbnailSetting = ThumbnailSetting::first();
          $parentCategories = LiveCategory::where('slug',$cid)->first();

          if(!empty($parentCategories)){
            $parentCategories_id = $parentCategories->id;
            $parentCategories_name = $parentCategories->name;
            $live_videos = LiveStream::join('livecategories', 'livecategories.live_id', '=', 'live_streams.id')
               ->where('livecategories.category_id','=',$parentCategories_id)
               ->where('active', '=', '1');

               if(Geofencing() !=null && Geofencing()->geofencing == 'ON'){

                $BlockLiveStream = BlockLiveStream::where('country',$countryName)->get();

                if(!$BlockLiveStream->isEmpty()){
                   foreach($BlockLiveStream as $block_LiveStream){
                      $blockLiveStreams[]=$block_LiveStream->live_id;
                   }
                }else{
                   $blockLiveStreams[]='';
                }
                $live_videos =   $live_videos->whereNotIn('live_streams.id',$blockLiveStreams);
            }
            $live_videos = $live_videos->orderBy('live_streams.created_at', 'desc')->paginate($this->videos_per_page);

          }else{
            $parentCategories_id = '';
            $parentCategories_name = '';
            $live_videos = [];
          }
          // dd($live_videos);

            $settings = Setting::first();

             $currency = CurrencySetting::first();

            $data = array(
                'currency'              => $currency,
                'ThumbnailSetting'      => $ThumbnailSetting,
                'live_videos'           => $live_videos,
                'parentCategories_name' => $parentCategories_name,
                'parentCategories'      => $parentCategories,
            );
           return Theme::view('livecategoryvids',$data);

        }


        public function EmbedLivePlay($vid)
        {

          $Theme = HomeSetting::pluck('theme_choosen')->first();
          Theme::uses( $Theme );

          // dd($Theme );
          $categoryVideos = LiveStream::where('slug',$vid)->first();
          $vid =  !empty($categoryVideos) ? $categoryVideos->id : null;
           $settings = Setting::first();


            $wishlisted = false;
            $watchlater = false;
             $session = Session::all();


             $currency = CurrencySetting::first();
             if(!empty($categoryVideos->publish_time)){
             $new_date = Carbon::parse($categoryVideos->publish_time)->format('M d , y H:i:s');
             $currentdate = date("M d , y H:i:s");

             if($currentdate < $new_date){
              $new_date = Carbon::parse($categoryVideos->publish_time)->format('M d , y h:i:s');

             }else{
              $new_date = null;
            }
             }else{
              $new_date = null;
             }

           $data = array(
                 'currency' => $currency,
                 'video' => $categoryVideos,
                 'ppv_price' => $categoryVideos->ppv_price,
                 'watchlatered' => $watchlater,
                 'mywishlisted' => $wishlisted,
                 'settings' => $settings,
           );

           return Theme::view('embedlivevideo', $data);

        }

        public function PPV_live_PurchaseUpdate( Request $request)
        {

          try {
              $current_time = Carbon::now()->format('Y-m-d H:i:s');
              $live_id      = $request->live_id;

            //   $live_purchase = LivePurchase::where('video_id',$live_id)->where('user_id',Auth::user()->id)->first();

              $live_purchase = LivePurchase::where('video_id', $live_id)->where('user_id', Auth::user()->id)
                                            ->get()->map(function ($item){
                                                $payment_status = payment_status($item);
                                                if ($payment_status === null || $item->payment_status === $payment_status) {
                                                    return $item;
                                                }
                                                    return null;
                                            })->first();

              LivePurchase::where('video_id',$live_id)->where('user_id',Auth::user()->id)->update([
                'livestream_view_count' => 1 ,
              ]);

              if( $live_purchase != null &&  $live_purchase->expired_date <= $current_time ){

                  LivePurchase::where('video_id',$live_id)->where('user_id',Auth::user()->id)->update([
                    'status' => 0 ,
                    'payment_status' => 'inactive',
                  ]);

                    $data = array(
                      'status' => true,
                      'message' => 'Live Purchase status updated' ,
                    );
              }
              else{
                  $data = array(
                    'status' => false,
                    'message' => 'Live Purchase status No changes done' ,
                  );
              }
          }
          catch (\Throwable $th) {

              $data = array(
                'status' => false,
                'message' => $th->getMessage(),
              );
          }

          return response()->json($data, 200);
        }

        public function unseen_expirydate_checking( Request $request )
        {
          try {
              $current_time = Carbon::now()->format('Y-m-d H:i:s');

            //   $unseen_expiry_date = LivePurchase::where('video_id',$request->live_id)->where('user_id',Auth::user()->id)->pluck('unseen_expiry_date')->first();

              $unseen_expiry_date = LivePurchase::where('video_id', $request->live_id)->where('user_id', Auth::user()->id)
                                            ->get()->map(function ($item){
                                                $payment_status = payment_status($item);
                                                if ($payment_status === null || $item->payment_status === $payment_status) {
                                                    return $item;
                                                }
                                                    return null;
                                            })->pluck('unseen_expiry_date')->first();


              if(  $unseen_expiry_date != null && $unseen_expiry_date <= $current_time ){

                LivePurchase::where('video_id',$request->live_id)->where('user_id',Auth::user()->id)->update([
                  'status' => 0 ,
                  'payment_status' =>'inactive',
                ]);

                $data = array(
                  'status' => true,
                  'message' => 'Unseen Expiry-date cheacking PPV purchase updated Sucessfully' ,
                );
              }
              else{
                $data = array(
                  'status' => false,
                  'message' => 'Unseen Expiry-date cheacking PPV purchase- No changes done' ,
                );
              }
          }
          catch (\Throwable $th) {

              $data = array(
                'status' => false,
                'message' => $th->getMessage() ,
              );
          }
          return response()->json($data, 200);
      }

      public function m3u_file_m3u8url( Request $request )
      {

        try {

          $M3u_category = $request->m3u_url_category;

          $m3u = $request->m3u_url;

          $parser = new M3UFileParser($m3u);
          $parser_list = $parser->list() ;

          $M3u_url_array = collect($parser_list[$M3u_category])->map(function ($item) {

              $mp3 = preg_match_all('/(?P<tag>#EXTINF:-1)|(?:(?P<prop_key>[-a-z]+)=\"(?P<prop_val>[^"]+)")|(?<something>,[^\r\n]+)|(?<url>http[^\s]+)/', $item, $match );
              $count = count( $match[0] );
              $tag_name = '1' ;
              $url      = '5' ;

              for( $i =0; $i < $count; $i++ ){
                  $M3u_videos = array(
                      'M3u_video_url' => $match[0][$url] ,
                      'M3u_video_name' => $match[0][$tag_name],
                    );
              }

              return $M3u_videos;
          });

          $respond = array(
            'status' => true ,
            'message' => 'Data Retrieved Successfully !' ,
            'M3u_url_array' => $M3u_url_array ,
            'M3u_category' => $M3u_category ,
          );

        } catch (\Throwable $th) {

          $respond = array(
            'status' => false ,
            'message' => $th->getMessage() ,
            'M3u_category' => $M3u_category ,
          );

        }

        return response()->json($respond, 200);


                  // Reference codes - Don't Remove

        // $count = count( $match[0] );
        // $result = [];
        // $index = -1;
        //   for( $i =0; $i < $count; $i++ ){
        //     $item = $match[0][$i];
        //     if( !empty($match['tag'][$i])){
        //         ++$index;
        //     }elseif( !empty($match['prop_key'][$i])){
        //         $result[$index][$match['prop_key'][$i]] = $match['prop_val'][$i];
        //     }elseif( !empty($match['something'][$i])){
        //         $result[$index]['something'] = $item;
        //     }elseif( !empty($match['url'][$i])){
        //           $result[$index]['url'] = $item ;
        //     }
        // }

      }

      public function M3U_video_url( Request $request)
      {
        try {

          $data_m3u_urls = $request->data_m3u_urls ;

          $request->session()->forget('m3u_url_link');

          session(['m3u_url_link' => $data_m3u_urls ]);

          $respond = array(
            'status' => true ,
            'message' => 'Data Retrieved Successfully !' ,
            'data_m3u_urls' => $data_m3u_urls ,
          );

        } catch (\Throwable $th) {
            $respond = array(
              'status' => false ,
              'message' => $th->getMessage() ,
            );
        }

        return response()->json($respond, 200);

      }

      public function fetchTimeline(Request $request)
      
      {
        $selectedDay = $request->get('day');
        $selectedDate = $request->get('date');

        $Livestream_id = $request->get('Livestream_id');
        $publish_type  = $request->get('publish_type');

        $Livestream_details = LiveStream::where('id', $Livestream_id)
                                ->where('active', '1')
                                ->where('status', '1');
                            
                            $livestream = $Livestream_details->when($selectedDay && $publish_type == 'schedule_program', function ($query) use ($selectedDay) {
                                return $query->where('scheduler_program_days', 'LIKE', '%"'.$selectedDay.'"%');
                            });

                            $livestream = $Livestream_details->when($selectedDate && $publish_type == 'publish_later', function ($query)use ($selectedDate)  {
                                return $query->where('publish_time','<=',$selectedDate);
                            })

                            ->get()->map(function ($item) use ($selectedDate) {

                                // Livestream schedule epg

                                switch ($item->publish_type) {

                                    case 'publish_now':
                                        $item['epg_program_title'] = $item->title;
                                        $item['epg_program_start_time'] = null;
                                        $item['epg_program_end_time']   = null;
                                        $item['epg_program_timeloop_parse']   = Str::before($selectedDate, 'T');
                                        break;
                            
                                    case 'publish_later':
                                        $item['epg_program_title'] = $item->title;
                                        $item['epg_program_start_time'] = $item->publish_time;
                                        $item['epg_program_end_time']   = null;
                                        $item['epg_program_timeloop_parse']   = Str::before($selectedDate, 'T');
                                        break;
                                    
                                    case 'recurring':
                                        $item['epg_program_title'] = $item->title;
                                        $item['epg_program_start_time'] = json_decode($item->scheduler_program_start_time);
                                        $item['epg_program_end_time'] = json_decode($item->scheduler_program_end_time);
                                        $item['epg_program_timeloop_parse']   = Str::before($selectedDate, 'T');
                                        break;
                            
                                    case 'schedule_program':
                                        $item['epg_program_title'] = json_decode($item->scheduler_program_title);
                                        $item['epg_program_start_time'] = json_decode($item->scheduler_program_start_time);
                                        $item['epg_program_end_time'] = json_decode($item->scheduler_program_end_time);
                                        $item['epg_program_timeloop_parse']   = Str::before($selectedDate, 'T');
                                        break;
                            
                                    default:
                                        $item['epg_program_title']      = null;
                                        $item['epg_program_start_time'] = null;
                                        $item['epg_program_end_time']   = null;
                                        $item['epg_program_timeloop_parse'] = null;
                                        break;
                                }
                            
                                return $item;
                            })->first();

        $data =[ 'Livestream_details' => $livestream ];

        return Theme::load("public/themes/{$this->Theme}/views/livevideo-schedule-epg-partial", $data)->render();
    }


    public function LivestreamPartnerMonetization(Request $request)
    {
        try {
            $video_id = $request->video_id;
            $video = LiveStream::where('id', $video_id)->first();
            if ($video) {
                $video->played_views += 1;
                $video->save(); 

                if ($video->uploaded_by === 'Channel') {
                $monetizationSettings = PartnerMonetizationSetting::select('viewcount_limit', 'views_amount')->first();
              
                if ($monetizationSettings) {
              
                $monetization_view_limit = $monetizationSettings->viewcount_limit;
                $monetization_view_amount = $monetizationSettings->views_amount;

                if ($video->played_views > $monetization_view_limit) {
                    $previously_monetized_views = $video->monetized_views ?? 0;
                    $new_monetizable_views = $video->played_views - $monetization_view_limit - $previously_monetized_views;

                    if ($new_monetizable_views > 0) {
                        
                        $additional_amount = $new_monetizable_views * $monetization_view_amount;
                        $video->monetization_amount += $additional_amount;
                        $video->monetized_views += $new_monetizable_views;
                        $video->save(); 

        
                        $channeluser_commission = (float) $video->channeluser->commission;
                        $channel_commission = ($channeluser_commission / 100) * $video->monetization_amount;
                        
                        $partner_monetization = PartnerMonetization::where('user_id', $video->user_id)
                            ->where('type_id', $video->id)
                            ->where('type', 'livestream')->first();

                        $monetization_data = [
                            'total_views' => $video->played_views,
                            'title' => $video->title,
                            'monetization_amount' => $video->monetization_amount,
                            'admin_commission' => $video->monetization_amount - $channel_commission,
                            'partner_commission' => $channel_commission,
                        ];

                        if ($partner_monetization) {
                            $partner_monetization->update($monetization_data);
                        } else {
                            PartnerMonetization::create(array_merge($monetization_data, [
                                'user_id' => $video->user_id,
                                'type_id' => $video->id,
                                'type' => 'livestream',
                            ]));
                        }
                    }
                }
            }
                return response()->json(['message' => 'View count incremented and monetization updated', 'played_view' => $video->played_views, 'monetization_amount' => $video->monetization_amount], 200);
            }
         } else {
                return response()->json(['error' => 'Video not found'], 404);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function RadioStationList(){
        try{

            $currency = CurrencySetting::first();
            $ThumbnailSetting = ThumbnailSetting::first();
            $station = LiveStream::where('stream_upload_via','radio_station')->get();

            $data=[
                "station"             => $station,
                "currency"            => $currency,
                "ThumbnailSetting"    => $ThumbnailSetting,
            ];

            return Theme::view('RadioStationList',$data);

        }catch (\Throwable $th) {
            // return $th->getMessage();
            return abort(404);
        }   
    }

    public function toggleFavorite(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'unauthenticated'], 401);
        }

        $userId = Auth::id();
        $liveId = $request->input('live_id');

        $favorite = Favorite::where('user_id', $userId)->where('live_id', $liveId)->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json(['status' => 'removed']);
        } else {
            Favorite::create([
                'user_id' => $userId,
                'live_id' => $liveId,
            ]);
            return response()->json(['status' => 'added']);
        }
    }

}
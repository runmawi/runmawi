<?php

namespace App\Http\Controllers;
use \App\User as User;
use \Redirect as Redirect;
use Illuminate\Http\Request;
use App\Setting;
use App\LiveStream as LiveStream;
use App\LivePurchase as LivePurchase;
use App\Watchlater as Watchlater;
use App\Wishlist as Wishlist;
use App\Genre;
use App\LiveCategory;
use URL;
use Auth;
use View;
use Hash;
use DB;
use Session;
use App\Language;
use App\PaymentSetting;
use App\CurrencySetting as CurrencySetting;
use App\HomeSetting;
use App\ThumbnailSetting;
use App\RecentView;
use Theme;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
//use Image;
use App\SystemSetting as SystemSetting;
use Intervention\Image\ImageManagerStatic as Image;
use App\Channel;
use App\ModeratorsUser;
use App\M3UFileParser;
use App\AdminLandingPage;

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

      $this->Theme = HomeSetting::pluck('theme_choosen')
          ->first();
      Theme::uses($this->Theme);
     
  }

    public function Index()
    {
        
      $settings = Setting::first();

      if($settings->enable_landing_page == 1 && Auth::guest()){

          $landing_page_slug = AdminLandingPage::where('status',1)->pluck('slug')->first() ? AdminLandingPage::where('status',1)->pluck('slug')->first() : "landing-page" ;

          return redirect()->route('landing_page', $landing_page_slug );
      }
      
        $Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses( $Theme );

        $live = LiveStream::where('active', '=', '1')->orderBy('id', 'DESC')->get();
        
        $vpp = VideoPerPage();
        $ThumbnailSetting = ThumbnailSetting::first();

        $data = array(
                     'videos' => $live,
                    'ThumbnailSetting' => $ThumbnailSetting,

         );

                    // dd($live_videos);
       return Theme::view('liveCategoryVideos',$data);

       return Theme::view('liveVideos',$data);
    }
    
    public function Play($vid)
        {
          

          $Theme = HomeSetting::pluck('theme_choosen')->first();
          Theme::uses( $Theme );

          $data = session()->all();

          $categoryVideos = LiveStream::where('slug',$vid)->first();
          $source_id = LiveStream::where('slug',$vid)->pluck('id')->first();
          

        if(@$categoryVideos->uploaded_by == 'Channel'){
          $user_id = $categoryVideos->user_id;

          $user = Channel::where("channels.id", "=", $user_id )
          ->join(
              "users",
              "channels.email",
              "=",
              "users.email"
          )
          ->select(
              "users.id as user_id"
          )
          ->first();
          if(!Auth::guest() &&  $user->user_id == Auth::user()->id){
              $video_access = 'free';
          }else{ 
              $video_access = 'pay';
          }
      }else if(@$categoryVideos->uploaded_by == 'CPP'){
          $user_id = $categoryVideos->user_id;

          $user = ModeratorsUser::where("moderators_users.id", "=", $user_id )
          ->join(
              "users",
              "moderators_users.email",
              "=",
              "users.email"
          )
          ->select(
              "users.id as user_id"
          )
          ->first();
          if(!Auth::guest() &&  $user->user_id == Auth::user()->id){
              $video_access = 'free';
          }else{ 
              $video_access = 'pay';
          }
      }else{
          if(!Auth::guest() &&  @$categoryVideos->access  == 'ppv' ||  @$categoryVideos->access  == 'subscriber' && Auth::user()->role != 'admin' ){
              $video_access = 'pay';
          }else{
              $video_access = 'free';
          }
      }

          $vid =  $categoryVideos->id;
          //  $categoryVideos = LiveStream::where('id',$vid)->first();
        if(!Auth::guest()){
           $user_id = Auth::user()->id;
          }

           $settings = Setting::first(); 

        if(!Auth::guest()){
            $ppv_exist = LivePurchase::where('video_id',$vid)->where('user_id',$user_id)->where('status',1)->latest()->count();
            $ppv_exists = LivePurchase::where('video_id',$vid)->where('user_id',$user_id)->where('status',1)->latest()->count();

          }else{
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
            //  dd($session['password_hash']);
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
                //  "Dec 14 ,22 14:58:00" "Dec 14 ,22 14:58:00" "Dec 14 ,22 15:04:53"
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
            //  dd($new_date);
             $payment_setting = PaymentSetting::where('status',1)->where('live_mode',1)->get();

             $Razorpay_payment_setting = PaymentSetting::where('payment_type','Razorpay')->where('status',1)->first();

             $Paystack_payment_setting = PaymentSetting::where('payment_type','Paystack')->where('status',1)->first();

             $stripe_payment_setting = PaymentSetting::where('payment_type','Stripe')->where('stripe_status',1)->first();

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

           $data = array(
                 'currency' => $currency,
                 'video_access' => $video_access,
                 'video' => $categoryVideos,
                 'password_hash' => $password_hash,
                 'publishable_key' => $publishable_key,
                 'ppv_exist' => $ppv_exist,
                 'ppv_exists' => $ppv_exists ,
                 'ppv_price' => $categoryVideos->ppv_price,
                 'watchlatered' => $watchlater,
                 'mywishlisted' => $wishlisted,
                 'new_date' => $new_date,
                 'payment_setting' => $payment_setting,
                 'Razorpay_payment_setting' => $Razorpay_payment_setting,
                 'Paystack_payment_setting' => $Paystack_payment_setting ,
                 'stripe_payment_setting'   => $stripe_payment_setting ,
                 'Related_videos' => LiveStream::whereNotIn('id',[$vid])->inRandomOrder()->get(),
                 'Paystack_payment_settings' => PaymentSetting::where('payment_type','Paystack')->first() ,
                 'M3U_channels' => $M3U_channels ,
                 'M3U_files'    => $M3U_files ,
                 'source_id'        => $source_id,
                 'commentable_type' => "LiveStream_play" ,
                 'CinetPay_payment_settings' => PaymentSetting::where('payment_type','CinetPay')->first() ,

           );

           return Theme::view('livevideo', $data);
          // }else{
          //   $system_settings = SystemSetting::first();

          //   return view('auth.login',compact('system_settings'));
          // }
        }


        public function channelVideos($cid)
        {
    
          $getfeching = \App\Geofencing::first();
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
               ->where('active', '=', '1')->get();
          }else{
            $parentCategories_id = '';
            $parentCategories_name = '';
            $live_videos = [];
          }
          // dd($live_videos);

            $settings = Setting::first();

             $currency = CurrencySetting::first();
            
            $data = array(
                    'currency'=> $currency,
                    'ThumbnailSetting' => $ThumbnailSetting,
                    'live_videos' => $live_videos,
                    'parentCategories_name' => $parentCategories_name,
                );
           return Theme::view('livecategoryvids',$data);
            
        } 




        public function EmbedLivePlay($vid)
        {

          $Theme = HomeSetting::pluck('theme_choosen')->first();
          Theme::uses( $Theme );

          // dd($Theme );
          $categoryVideos = LiveStream::where('slug',$vid)->first();
          $vid =  $categoryVideos->id;
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

              $live_purchase = LivePurchase::where('video_id',$live_id)->where('user_id',Auth::user()->id)->first();

              LivePurchase::where('video_id',$live_id)->where('user_id',Auth::user()->id)->update([
                'livestream_view_count' => 1 ,
              ]);

              if( $live_purchase != null &&  $live_purchase->expired_date <= $current_time ){

                  LivePurchase::where('video_id',$live_id)->where('user_id',Auth::user()->id)->update([
                    'status' => 0 ,
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

              $unseen_expiry_date = LivePurchase::where('video_id',$request->live_id)->where('livestream_view_count',0)->where('user_id',Auth::user()->id)->pluck('unseen_expiry_date')->first();

              if(  $unseen_expiry_date != null && $unseen_expiry_date <= $current_time ){

                LivePurchase::where('video_id',$request->live_id)->where('user_id',Auth::user()->id)->update([
                  'status' => 0 ,
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
}

<?php

namespace App\Http\Controllers;
use \App\User as User;
use \Redirect as Redirect;
use Request;
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
use Theme;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
//use Image;
use App\SystemSetting as SystemSetting;
use Intervention\Image\ImageManagerStatic as Image;

class LiveStreamController extends Controller
{
    public function Index()
    {
        
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

          // $category=null,
          $data = session()->all();

          $categoryVideos = LiveStream::where('slug',$vid)->first();
          $vid =  $categoryVideos->id;
          //  $categoryVideos = LiveStream::where('id',$vid)->first();
        if(!empty($data['password_hash'])){
           $user_id = Auth::user()->id;
          }

           $settings = Setting::first(); 

        if(!empty($data['password_hash'])){

           $ppv_exist = LivePurchase::where('video_id',$vid)->where('user_id',$user_id)->count();
          }else{
            $ppv_exist = [];
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
                 'password_hash' => $password_hash,
                 'publishable_key' => $publishable_key,
                 'ppv_exist' => $ppv_exist,
                 'ppv_price' => $categoryVideos->ppv_price,
                 'watchlatered' => $watchlater,
                 'mywishlisted' => $wishlisted,
                 'new_date' => $new_date

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
          $parentCategories = LiveCategory::where('name',$cid)->first();
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
}

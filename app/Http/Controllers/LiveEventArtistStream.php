<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Video;
use App\CurrencySetting;
use App\ThumbnailSetting;
use App\Setting;
use App\HomeSetting;
use App\LiveEventArtist;
use App\LivePurchase;
use App\Wishlist;
use App\Watchlater;
use App\PaymentSetting;
use App\RecentView;
use Carbon\Carbon;
use App\LiveStream;
use Theme;
use URL;
use Auth;
use View;
use Hash;
use DB;
use Session;

class LiveEventArtistStream extends Controller
{

    public function __construct()
    {
        $settings = Setting::first();
        $this->videos_per_page = $settings->videos_per_page;

        $this->Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses($this->Theme);

        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
        $userIp = $geoip->getip();    
        $countryName = $geoip->getCountry();
        $regionName = $geoip->getregion();
        $cityName = $geoip->getcity();
  
        $this->countryName = $countryName;
    }

    public function index()
    {

        $artist_live_event = LiveEventArtist::where("active","=","1")
                ->orderBy('created_at', 'DESC')
                ->get();

        $PPV_settings = Setting::where('ppv_status', '=', 1)->first();

        $ppv_gobal_price = !empty($PPV_settings) ? $PPV_settings->ppv_price :  null ;
        
        $data = array(
            'artist_live_event' => $artist_live_event,
            'ppv_gobal_price' => $ppv_gobal_price,
            'currency' =>CurrencySetting::first(),
            'ThumbnailSetting' => ThumbnailSetting::first(),
        );

        return Theme::view('live_artist_event.index',['artist_live_event'=>$data]);
    }

    public function live_event_play(Request $request,$slug)
    {
        $data = session()->all();
        $session = Session::all();

        $live_event_artist = LiveEventArtist::where('slug',$slug)->first();

        $vid =  $live_event_artist->id;

        if(!empty($data['password_hash'])){
            $user_id = Auth::user()->id;
        }

        $settings = Setting::first(); 

        $ppv_exist = !empty($data['password_hash']) ? LivePurchase::where('video_id',$vid)->where('user_id',$user_id)->count() : [];
      
        $wishlisted = false;

        if(!Auth::guest()):
            $wishlisted = Wishlist::where('user_id', '=', Auth::user()->id)->where('video_id', '=', $vid)->where('type', '=', 'live')->first();
        endif;

        $watchlater = false;

        if(!Auth::guest()):
            $watchlater = Watchlater::where('user_id', '=', Auth::user()->id)->where('video_id', '=', $vid)->where('type', '=', 'live')->first();
        endif;

        $password_hash = !empty($session['password_hash']) ? $session['password_hash'] : "" ;

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

        if(!empty($live_event_artist->publish_time)){
            $new_date = Carbon::parse($live_event_artist->publish_time)->format('M d , y H:i:s');
            $currentdate = date("M d , y H:i:s");
            $new_date = $currentdate < $new_date ?  Carbon::parse($live_event_artist->publish_time)->format('M d , y h:i:s') : null;
        }
        else{
            $new_date = null;
        }

        $payment_setting = PaymentSetting::where('status',1)->where('live_mode',1)->get();
        $Razorpay_payment_setting = PaymentSetting::where('status',1)->first();

        $view = new RecentView;
        $view->user_id      = Auth::User() ? Auth::User()->id : null ;
        $view->country_name = $this->countryName ? $this->countryName : null ;
        $view->sub_user     = null ;
        $view->visited_at   = Carbon::now()->year;
        $view->live_event_artist_id = $vid ;
        $view->save();

         $data = array(
               'currency'    => CurrencySetting::first(),
               'video'       => $live_event_artist,
               'password_hash' => $password_hash,
               'publishable_key' => $publishable_key,
               'ppv_exist' => $ppv_exist,
               'ppv_price' => $live_event_artist->ppv_price,
               'watchlatered' => $watchlater,
               'mywishlisted' => $wishlisted,
               'new_date' => $new_date,
               'payment_setting' => $payment_setting,
               'Razorpay_payment_setting' => $Razorpay_payment_setting,
               'Related_videos' => LiveEventArtist::whereNotIn('id',[$vid])->inRandomOrder()->get(),
         );

         return Theme::view('live_artist_event.live_event_videos', $data);
    }
}

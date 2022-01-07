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


use Illuminate\Support\Facades\Cache;
//use Image;
use App\SystemSetting as SystemSetting;
use Intervention\Image\ImageManagerStatic as Image;

class LiveStreamController extends Controller
{
    public function Index()
    {
        $live = LiveStream::where('active', '=', '1')->orderBy('id', 'DESC')->get();
        
        $vpp = VideoPerPage();
        $data = array(
                     'videos' => $live,
         );
       return view('liveVideos',$data);
    }
    
    public function Play($vid)
        {
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

           $data = array(
                 'currency' => $currency,
                 'video' => $categoryVideos,
                 'password_hash' => $password_hash,
                 'publishable_key' => $publishable_key,
                 'ppv_exist' => $ppv_exist,
                 'ppv_price' => $categoryVideos->ppv_price,
                 'watchlatered' => $watchlater,
                 'mywishlisted' => $wishlisted
           );

           return view('livevideo', $data);
          // }else{
          //   $system_settings = SystemSetting::first();

          //   return view('auth.login',compact('system_settings'));
          // }
        }
}

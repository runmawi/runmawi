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
use Illuminate\Support\Facades\Cache;
//use Image;
use Intervention\Image\ImageManagerStatic as Image;

class LiveStreamController extends Controller
{
    public function Index()
    {
        $live = LiveStream::all();
        
        $vpp = VideoPerPage();
        $data = array(
                     'videos' => $live,
         );
       return view('liveVideos',$data);
    }
    
    public function Play($vid)
        {
        
       
           $categoryVideos = LiveStream::where('id',$vid)->first();
           $user_id = Auth::user()->id;
           $settings = Setting::first(); 
           $ppv_exist = LivePurchase::where('video_id',$vid)->where('user_id',$user_id)->count();

            $wishlisted = false;
            if(!Auth::guest()):
                    $wishlisted = Wishlist::where('user_id', '=', Auth::user()->id)->where('video_id', '=', $vid)->where('type', '=', 'live')->first();
            endif;

            $watchlater = false;

             if(!Auth::guest()):
                    $watchlater = Watchlater::where('user_id', '=', Auth::user()->id)->where('video_id', '=', $vid)->where('type', '=', 'live')->first();
             endif;

           $data = array(
                 'video' => $categoryVideos,
                 'ppv_exist' => $ppv_exist,
                 'ppv_price' => $settings->ppv_price,
                 'watchlatered' => $watchlater,
                 'mywishlisted' => $wishlisted
           );

           return view('livevideo', $data);

        }
}

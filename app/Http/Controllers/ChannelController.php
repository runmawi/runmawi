<?php

namespace App\Http\Controllers;
use \App\User as User;
use \Redirect as Redirect;
use Request;
use App\Setting;
use App\Video;
use App\Genre;
use App\Audio;
use App\Page as Page;
use App\Watchlater as Watchlater;
use App\Wishlist as Wishlist;
use App\PpvVideo as PpvVideo;
use App\PpvPurchase as PpvPurchase;
use App\Movie;
use App\Episode;
use App\ContinueWatching as ContinueWatching;
use App\LikeDislike as LikeDislike;
use App\VideoCategory;
use URL;
use Auth;
use View;
use Hash;
use Illuminate\Support\Facades\Cache;
//use Image;
use Intervention\Image\ImageManagerStatic as Image;
use Session;

class ChannelController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        $settings = Setting::first();
        $this->videos_per_page = $settings->videos_per_page;
    }
    
    public function index()
    {
       $settings = Setting::first();
       $parentCategories = \App\VideoCategory::where('parent_id',0)->get();
        
       return view('channels', compact('parentCategories'));
        
    } 
    
    public function channelVideos($cid)
    {
        $vpp = VideoPerPage();
        $category_id = \App\VideoCategory::where('slug',$cid)->pluck('id');
        $categoryVideos = \App\Video::where('video_category_id',$category_id)->paginate($vpp);
        $category_title = \App\VideoCategory::where('id',$category_id)->pluck('name');
            
        $data = array(
                'category_title'=>$category_title[0],
                'categoryVideos'=>$categoryVideos
            );
        
       return view('categoryvids',['data'=>$data]);
        
    } 
    
    public function play_videos($slug)
    {
        echo "Adas";exit;
        $get_video_id = \App\Video::where('slug',$slug)->first(); 
        $vid = $get_video_id->id;
        $current_date = date('Y-m-d h:i:s a', time());     
        
         $view_increment = $this->handleViewCount_movies($vid);
        if ( !Auth::guest() ) {
           $user_id = Auth::user()->id;
           $watch_id = ContinueWatching::where('user_id','=',$user_id)->where('videoid','=',$vid)->orderby('created_at','desc')->first();
           $watch_count = ContinueWatching::where('user_id','=',$user_id)->where('videoid','=',$vid)->orderby('created_at','desc')->count();
          if ($watch_count >0 ){
              $watchtime = $watch_id->currentTime;
          }else {
            $watchtime = 0;
          }
           $ppv_exist = PpvPurchase::where('video_id',$vid)->where('user_id',$user_id)->where('to_time','>',$current_date)->count();
           $user_id = Auth::user()->id;

           $categoryVideos = \App\Video::where('id',$vid)->first();
           $category_id = \App\Video::where('id',$vid)->pluck('video_category_id');
           $recomended = \App\Video::where('video_category_id','=',$category_id)->where('id','!=',$vid)->limit(10)->get();

                $wishlisted = false;
                if(!Auth::guest()):
                        $wishlisted = Wishlist::where('user_id', '=', Auth::user()->id)->where('video_id', '=', $vid)->where('type', '=', 'channel')->first();
                endif;
                    $watchlater = false;
                 if(!Auth::guest()):
                        $watchlater = Watchlater::where('user_id', '=', Auth::user()->id)->where('video_id', '=', $vid)->where('type', '=', 'channel')->first();
                        $like_dislike = LikeDislike::where('user_id', '=', Auth::user()->id)->where('video_id', '=', $vid)->get();
                    endif;
                 $data = array(
                     'video' => $categoryVideos,
                     'recomended' => $recomended,
                     'ppv_exist' => $ppv_exist,
                     'ppv_price' => 100,
                     'watchlatered' => $watchlater,
                     'mywishlisted' => $wishlisted,
                     'watched_time' => $watchtime,
                     'like_dislike' =>$like_dislike
                 );
            
        } else {

           
            $categoryVideos = \App\Video::where('id',$vid)->first();
            $category_id = \App\Video::where('id',$vid)->pluck('video_category_id');
            $recomended = \App\Video::where('video_category_id','=',$category_id)->where('id','!=',$vid)->limit(10)->get();
               $data = array(
                 'video' => $categoryVideos,
                 'recomended' => $recomended,
                
            );
            }
       return view('video', $data);
        
    }   
    
    
    public function PlayPpv($vid)
    {
       
       $categoryVideos = \App\PpvVideo::where('id',$vid)->first();
       $user_id = Auth::user()->id;
       $settings = Setting::first(); 
       $ppv_exist = PpvPurchase::where('video_id',$vid)->where('user_id',$user_id)->count();
        
        $wishlisted = false;
        if(!Auth::guest()):
                $wishlisted = Wishlist::where('user_id', '=', Auth::user()->id)->where('video_id', '=', $vid)->where('type', '=', 'ppv')->first();
        endif;

        $watchlater = false;
        
         if(!Auth::guest()):
                $watchlater = Watchlater::where('user_id', '=', Auth::user()->id)->where('video_id', '=', $vid)->where('type', '=', 'ppv')->first();
         endif;
      
       $data = array(
             'video' => $categoryVideos,
             'ppv_exist' => $ppv_exist,
             'ppv_price' => $settings->ppv_price,
             'watchlatered' => $watchlater,
             'mywishlisted' => $wishlisted
       );
        
       return view('ppvvideo', $data);
        
    }
    
    public function ppvVideos()
    {
        $vpp = VideoPerPage();
        $data = PpvVideo::where('status',1)->paginate($vpp);
        //       $data = array(
        //             'ppvVideos' => $ppvVideos,
        // );
       return view('ppvVideos',['data'=>$data]);
        
    }
    
    public function Myppv(){
        
        if(!Auth::user()){
            
           return Redirect::to('/')->with(array('note' => 'Successfully Updated Site Settings!', 'note_type' => 'success') );
        }
        
        $user_id = Auth::user()->id;
        
        $ppvVideos = PpvPurchase::where('user_id',$user_id)->get();
        
        $data = array(
             'videos' => $ppvVideos,
           );
           return view('ppv-list', $data);
        
    }
    
    public function handleViewCount_movies($vid){
        $movie = Video::find($vid);
        $movie->views = $movie->views + 1;
        $movie->save();
        Session::put('viewed_movie.'.$vid, time());
    }
    

}

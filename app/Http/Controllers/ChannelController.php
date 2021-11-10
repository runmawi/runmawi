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
use App\RecentView as RecentView;
use App\Movie;
use App\Episode;
use App\ContinueWatching as ContinueWatching;
use App\LikeDislike as LikeDislike;
use App\VideoCategory;
use App\RegionView;
use App\UserLogs;
use App\Videoartist;
use App\Artist;
use URL;
use Auth;
use View;
use Hash;
use Illuminate\Support\Facades\Cache;
//use Image;
use Intervention\Image\ImageManagerStatic as Image;
use Session;
use App\Playerui as Playerui;
use App\MoviesSubtitles as MoviesSubtitles;
// use App\Video as Video;
use Carbon\Carbon;
use DateTime;



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
        $categoryVideos = \App\Video::where('video_category_id',$category_id)->paginate();
        $category_title = \App\VideoCategory::where('id',$category_id)->pluck('name');
        $settings = Setting::first();
        $PPV_settings = Setting::where('ppv_status','=',1)->first();
        if(!empty($PPV_settings)){
            $ppv_gobal_price =  $PPV_settings->ppv_price;
            //  echo "<pre>";print_r($PPV_settings->ppv_hours);exit();

         }else{
            //  echo "<pre>";print_r('ppv_status');exit();
             $ppv_gobal_price = null ;

         }
        $data = array(
                'category_title'=>$category_title[0],
                'categoryVideos'=>$categoryVideos,
                'ppv_gobal_price' => $ppv_gobal_price,
            );
        
       return view('categoryvids',['data'=>$data]);
        
    } 
    
      public function play_videos($slug)
    {

        $data['password_hash'] = "";
        $data = session()->all();
       
        if(!empty($data['password_hash'])){


        $get_video_id = \App\Video::where('slug',$slug)->first(); 
        $vid = $get_video_id->id;
        // echo "<pre>"; 
        $cast = Videoartist::where('video_id','=',$vid)->get();
          foreach($cast as $key => $artist){
            $artists[] = Artist::where('id','=',$artist->artist_id)->get();

          }
          // print_r();
          // exit();
  

        $PPV_settings = Setting::where('ppv_status','=',1)->first();
        if(!empty($PPV_settings)){
           $ppv_rent_price =  $PPV_settings->ppv_price;
            // echo "<pre>";print_r($PPV_settings);exit();
        }else{
          $Video_ppv = Video::where('id','=',$vid)->first();
            $ppv_rent_price = null ;
            if($Video_ppv->ppv_price != ""){
              // echo "<pre>";print_r('$Video_ppv');exit();
              $ppv_rent_price = $Video_ppv->ppv_price;
            }else{
            // echo "<pre>";print_r($Video_ppv);exit();
            $ppv_rent_price = $Video_ppv->ppv_price;
          }

        }

        $current_date = date('Y-m-d h:i:s a', time()); 
         $view_increment = $this->handleViewCount_movies($vid);
        if ( !Auth::guest() ) {


          $ip = getenv('HTTP_CLIENT_IP');    
          $data = \Location::get($ip);
          $userIp = $data->ip;
          $countryName = $data->countryName;
          $regionName = $data->regionName;
          $cityName = $data->cityName;
          // dd($data);
          $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();    
            $view = new RecentView;
            $view->video_id = $vid;
            $view->user_id = Auth::user()->id;
            $view->visited_at = date('Y-m-d');
            $view->save();



            $regionview = RegionView::where('user_id','=',Auth::User()->id)->where('video_id','=',$vid)->orderBy('created_at', 'DESC')->whereDate('created_at', '>=', \Carbon\Carbon::now()->today())->first();
            if(!empty($regionview)){
                // dd($logged);
                $regionview = RegionView::where('user_id','=',Auth::User()->id)->where('video_id','=',$vid)->orderBy('created_at', 'DESC')->whereDate('created_at', '>=', \Carbon\Carbon::now()->today())->delete();
                // dd($data);
                $region = new RegionView;
                $region->user_id = Auth::User()->id;
                $region->user_ip = $userIp;
                $region->video_id = $vid;
                $region->countryname = $countryName;
                $region->save();
            }else{
                $region = new RegionView;
                $region->user_id = Auth::User()->id;
                $region->user_ip = $userIp;
                $region->video_id = $vid;
                $region->countryname = $countryName;
                $region->save();
            }

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
           $videocategory = \App\VideoCategory::where('id',$category_id)->pluck('name');
          $videocategory = $videocategory[0];
           $recomended = \App\Video::where('video_category_id','=',$category_id)->where('id','!=',$vid)->limit(10)->get();
           $playerui = Playerui::first();
           $subtitle = MoviesSubtitles::where('movie_id','=',$vid)->get();

                $wishlisted = false;
                if(!Auth::guest()):
                        $wishlisted = Wishlist::where('user_id', '=', Auth::user()->id)->where('video_id', '=', $vid)->where('type', '=', 'channel')->first();
                endif;
                    $watchlater = false;
                 if(!Auth::guest()):
                        $watchlater = Watchlater::where('user_id', '=', Auth::user()->id)->where('video_id', '=', $vid)->where('type', '=', 'channel')->first();
                        $like_dislike = LikeDislike::where('user_id', '=', Auth::user()->id)->where('video_id', '=', $vid)->get();
                    endif;


                    $ppv_video_play = [];

                    $ppv_video = \DB::table('ppv_purchases')->where('user_id',Auth::user()->id)->where('status','active')->get();
                    $ppv_setting = \DB::table('settings')->first();
                    $ppv_setting_hours= $ppv_setting->ppv_hours;
                      // dd($ppv_hours);
            
                    if(!empty($ppv_video)){
                    foreach($ppv_video as $key => $value){
                      $to_time = $value->to_time;
                    
                      // $time = date('h:i:s', strtotime($date));
                      // $ppv_hours = date('Y-m-d h:i:s a',strtotime('+'.$ppv_setting_hours.' hour',strtotime($date)));                        
                     
                        $d = new \DateTime('now');
                        $d->setTimezone(new \DateTimeZone('Asia/Kolkata'));
                        $now = $d->format('Y-m-d h:i:s a');

                      if($to_time >=  $now){
                        if($vid == $value->video_id){
                          $ppv_video_play = $value;
                        // dd($ppv_video_play);    

    
                        }else{
                          $ppv_video_play = null;
                        }                 
                    }else{
                        // dd('$now');                     
                        PpvPurchase::where('video_id', $vid)
                                ->update([
                                    'status' => 'inactive'
                                    ]);
                    }
                    $purchased_video = \DB::table('videos')->where('id',$value->video_id)->get();

                    }
                    }
            
            


                 $data = array(
                     'video' => $categoryVideos,
                     'videocategory' => $videocategory,
                     'recomended' => $recomended,
                     'ppv_exist' => $ppv_exist,
                     'ppv_price' => 100,
                     'watchlatered' => $watchlater,
                     'mywishlisted' => $wishlisted,
                     'watched_time' => $watchtime,
                     'like_dislike' =>$like_dislike,
                     'ppv_rent_price' =>$ppv_rent_price,
                 'playerui_settings' => $playerui,
                 'subtitles' => $subtitle,
                 'artists' => $artists,
    		'ppv_video_play' => $ppv_video_play,


                 );
             
        } else {

          $ip = getenv('HTTP_CLIENT_IP');    
          $data = \Location::get($ip);
          $userIp = $data->ip;
          $countryName = $data->countryName;
          $regionName = $data->regionName;
          $cityName = $data->cityName;
          // dd($data);

            $regionview = RegionView::where('user_id','=',Auth::User()->id)->where('video_id','=',$vid)->orderBy('created_at', 'DESC')->whereDate('created_at', '>=', \Carbon\Carbon::now()->today())->first();
            if(!empty($regionview)){
                // dd($logged);
                $regionview = RegionView::where('user_id','=',Auth::User()->id)->where('video_id','=',$vid)->orderBy('created_at', 'DESC')->whereDate('created_at', '>=', \Carbon\Carbon::now()->today())->delete();
                // dd($data);
                $region = new RegionView;
                $region->user_id = Auth::User()->id;
                $region->user_ip = $userIp;
                $region->video_id = $vid;
                $region->countryname = $countryName;
                $region->save();
            }else{
                $region = new RegionView;
                $region->user_id = Auth::User()->id;
                $region->user_ip = $userIp;
                $region->video_id = $vid;
                $region->countryname = $countryName;
                $region->save();
            }
            $categoryVideos = \App\Video::where('id',$vid)->first();
            $category_id = \App\Video::where('id',$vid)->pluck('video_category_id');
            $recomended = \App\Video::where('video_category_id','=',$category_id)->where('id','!=',$vid)->limit(10)->get();
    $playerui = Playerui::first();
    $subtitle = MoviesSubtitles::where('movie_id','=',$vid)->get();

            $data = array(
                 'video' => $categoryVideos,
                 'recomended' => $recomended,
                 'playerui_settings' => $playerui,
                 'subtitles' => $subtitle,
                 'artists' => $artists,
                 'watched_time' => 0,

            );

            }
 
       return view('video', $data);
    }else{
    
        $get_video_id = \App\Video::where('slug',$slug)->first(); 
        $vid = $get_video_id->id;
        $current_date = date('Y-m-d h:i:s a', time()); 

            
        
         $view_increment = $this->handleViewCount_movies($vid);
        if ( !Auth::guest() ) {
          $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();    
            $view = new RecentView;
            $view->video_id = $vid;
            $view->user_id = Auth::user()->id;
            $view->visited_at = date('Y-m-d');
            $view->save();
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
           $videocategory = \App\VideoCategory::where('id',$category_id)->pluck('name');
          $videocategory = $videocategory[0];
           $recomended = \App\Video::where('video_category_id','=',$category_id)->where('id','!=',$vid)->limit(10)->get();
           $playerui = Playerui::first();
           $subtitle = MoviesSubtitles::where('movie_id','=',82)->get();

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
                     'videocategory' => $videocategory,
                     'recomended' => $recomended,
                     'ppv_exist' => $ppv_exist,
                     'ppv_price' => 100,
                     'watchlatered' => $watchlater,
                     'mywishlisted' => $wishlisted,
                     'watched_time' => $watchtime,
                     'like_dislike' =>$like_dislike,
                 'playerui_settings' => $playerui,
                 'subtitles' => $subtitle,

                 );
             
        } else {

           
            $categoryVideos = \App\Video::where('id',$vid)->first();
            $category_id = \App\Video::where('id',$vid)->pluck('video_category_id');
            $recomended = \App\Video::where('video_category_id','=',$category_id)->where('id','!=',$vid)->limit(10)->get();
    $playerui = Playerui::first();
    $subtitle = MoviesSubtitles::where('movie_id','=',$vid)->get();

            $data = array(
                 'video' => $categoryVideos,
                 'recomended' => $recomended,
                 'playerui_settings' => $playerui,
                 'subtitles' => $subtitle,
                 'watched_time' => 0,

            );

            }
 
       return view('video_before_login', $data);
    }
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
    






    public function Wishlist_play_videos($slug)
    {

        $data['password_hash'] = "";
        $data = session()->all();
       
        if(!empty($data['password_hash'])){


        $get_video_id = \App\Video::where('slug',$slug)->first(); 
        $vid = $get_video_id->id;
        $wishlist = new Wishlist;
        $wishlist->video_id = $vid;
        $wishlist->user_id = Auth::User()->id;
        $wishlist->save();

        $PPV_settings = Setting::where('ppv_status','=',1)->first();
        if(!empty($PPV_settings)){
           $ppv_rent_price =  $PPV_settings->ppv_price;
            // echo "<pre>";print_r($PPV_settings);exit();
        }else{
          $Video_ppv = Video::where('id','=',$vid)->first();
            $ppv_rent_price = null ;
            if($Video_ppv->ppv_price != ""){
              // echo "<pre>";print_r('$Video_ppv');exit();
              $ppv_rent_price = $Video_ppv->ppv_price;
            }else{
            // echo "<pre>";print_r($Video_ppv);exit();
            $ppv_rent_price = $Video_ppv->ppv_price;
          }

        }




        $current_date = date('Y-m-d h:i:s a', time()); 

            
        
         $view_increment = $this->handleViewCount_movies($vid);
        if ( !Auth::guest() ) {
          $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();    
            $view = new RecentView;
            $view->video_id = $vid;
            $view->user_id = Auth::user()->id;
            $view->visited_at = date('Y-m-d');
            $view->save();
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
           $videocategory = \App\VideoCategory::where('id',$category_id)->pluck('name');
          $videocategory = $videocategory[0];
           $recomended = \App\Video::where('video_category_id','=',$category_id)->where('id','!=',$vid)->limit(10)->get();
           $playerui = Playerui::first();
           $subtitle = MoviesSubtitles::where('movie_id','=',$vid)->get();

                $wishlisted = false;
                if(!Auth::guest()):
                        $wishlisted = Wishlist::where('user_id', '=', Auth::user()->id)->where('video_id', '=', $vid)->where('type', '=', 'channel')->first();
                endif;
                    $watchlater = false;
                 if(!Auth::guest()):
                        $watchlater = Watchlater::where('user_id', '=', Auth::user()->id)->where('video_id', '=', $vid)->where('type', '=', 'channel')->first();
                        $like_dislike = LikeDislike::where('user_id', '=', Auth::user()->id)->where('video_id', '=', $vid)->get();
                    endif;


                    $ppv_video_play = [];

                    $ppv_video = \DB::table('ppv_purchases')->where('user_id',Auth::user()->id)->where('status','active')->get();
                    $ppv_setting = \DB::table('settings')->first();
                    $ppv_setting_hours= $ppv_setting->ppv_hours;
                      // dd($ppv_hours);
            
                    if(!empty($ppv_video)){
                    foreach($ppv_video as $key => $value){
                      $to_time = $value->to_time;
                    
                      // $time = date('h:i:s', strtotime($date));
                      // $ppv_hours = date('Y-m-d h:i:s a',strtotime('+'.$ppv_setting_hours.' hour',strtotime($date)));                        
                     
                        $d = new \DateTime('now');
                        $d->setTimezone(new \DateTimeZone('Asia/Kolkata'));
                        $now = $d->format('Y-m-d h:i:s a');
                        // dd($to_time);                     
                        // "2021-10-28 03:19:38 pm"
                        // "2021-10-28 05:14:25 pm"
                      if($to_time >=  $now){
                        if($vid == $value->video_id){
                          $ppv_video_play = $value;
                        // dd($ppv_video_play);    

    
                        }else{
                          $ppv_video_play = null;
                        }                 
                    }else{
                        // dd('$now');                     
                        PpvPurchase::where('video_id', $vid)
                                ->update([
                                    'status' => 'inactive'
                                    ]);
                    }
                    $purchased_video = \DB::table('videos')->where('id',$value->video_id)->get();

                    // if($now == $ppv_hours){

                    //   if($vid == $value->video_id){
                    //     $ppv_video_play = $value;

                    //   }else{
                    //     $ppv_video_play = null;
                    //   }
                    // }else{
                    //     // dd($now);                     
                    //     PpvPurchase::where('video_id', $vid)
                    //             ->update([
                    //                 'status' => 'inactive'
                    //                 ]);
                    // }
                    // $purchased_video = \DB::table('videos')->where('id',$value->video_id)->get();
                    }
                    }
            

                 $data = array(
                     'video' => $categoryVideos,
                     'videocategory' => $videocategory,
                     'recomended' => $recomended,
                     'ppv_exist' => $ppv_exist,
                     'ppv_price' => 100,
                     'watchlatered' => $watchlater,
                     'mywishlisted' => $wishlisted,
                     'watched_time' => $watchtime,
                     'like_dislike' =>$like_dislike,
                     'ppv_rent_price' =>$ppv_rent_price,
                 'playerui_settings' => $playerui,
                 'subtitles' => $subtitle,
    		'ppv_video_play' => $ppv_video_play,


                 );
             
        } else {

           
            $categoryVideos = \App\Video::where('id',$vid)->first();
            $category_id = \App\Video::where('id',$vid)->pluck('video_category_id');
            $recomended = \App\Video::where('video_category_id','=',$category_id)->where('id','!=',$vid)->limit(10)->get();
    $playerui = Playerui::first();
    $subtitle = MoviesSubtitles::where('movie_id','=',$vid)->get();

            $data = array(
                 'video' => $categoryVideos,
                 'recomended' => $recomended,
                 'playerui_settings' => $playerui,
                 'subtitles' => $subtitle,
                 'watched_time' => 0,

            );

            }
 
       return view('video', $data);
    }else{
    
        $get_video_id = \App\Video::where('slug',$slug)->first(); 
        $vid = $get_video_id->id;
        $current_date = date('Y-m-d h:i:s a', time()); 

            
        
         $view_increment = $this->handleViewCount_movies($vid);
        if ( !Auth::guest() ) {
          $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();    
            $view = new RecentView;
            $view->video_id = $vid;
            $view->user_id = Auth::user()->id;
            $view->visited_at = date('Y-m-d');
            $view->save();
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
           $videocategory = \App\VideoCategory::where('id',$category_id)->pluck('name');
          $videocategory = $videocategory[0];
           $recomended = \App\Video::where('video_category_id','=',$category_id)->where('id','!=',$vid)->limit(10)->get();
           $playerui = Playerui::first();
           $subtitle = MoviesSubtitles::where('movie_id','=',82)->get();

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
                     'videocategory' => $videocategory,
                     'recomended' => $recomended,
                     'ppv_exist' => $ppv_exist,
                     'ppv_price' => 100,
                     'watchlatered' => $watchlater,
                     'mywishlisted' => $wishlisted,
                     'watched_time' => $watchtime,
                     'like_dislike' =>$like_dislike,
                 'playerui_settings' => $playerui,
                 'subtitles' => $subtitle,

                 );
             
        } else {

           
            $categoryVideos = \App\Video::where('id',$vid)->first();
            $category_id = \App\Video::where('id',$vid)->pluck('video_category_id');
            $recomended = \App\Video::where('video_category_id','=',$category_id)->where('id','!=',$vid)->limit(10)->get();
    $playerui = Playerui::first();
    $subtitle = MoviesSubtitles::where('movie_id','=',$vid)->get();

            $data = array(
                 'video' => $categoryVideos,
                 'recomended' => $recomended,
                 'playerui_settings' => $playerui,
                 'subtitles' => $subtitle,
                 'watched_time' => 0,

            );

            }
 
       return view('video_before_login', $data);
    }
        }
    
}

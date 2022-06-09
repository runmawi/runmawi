<?php

namespace App\Http\Controllers;
use \App\User as User;
use \Redirect as Redirect;
use Request;
use App\Setting;
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
use App\PaymentSetting;
use App\Language;
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
use App\Video as Video;
use Carbon\Carbon;
use DateTime;
use App\CurrencySetting as CurrencySetting;
use App\HomeSetting as HomeSetting;
use App\BlockVideo as BlockVideo;
use App\CategoryVideo as CategoryVideo;
use App\LanguageVideo;
use App\AdsVideo;
use Theme;
use App\ThumbnailSetting;


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

        $this->Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses(  $this->Theme );
    }
    
    public function index()
    {
       $settings = Setting::first();
       $parentCategories = \App\VideoCategory::where('parent_id',0)->get();
        
       return view('channels', compact('parentCategories'));
        
    } 
    
    public function channelVideos($cid)
    {

      $getfeching = \App\Geofencing::first();
      $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
      $userIp = $geoip->getip();    
      $countryName = $geoip->getCountry();
      $ThumbnailSetting = ThumbnailSetting::first();


        $vpp = VideoPerPage();
        $category_id = \App\VideoCategory::where('slug',$cid)->pluck('id');
        $categoryVideos_count = Video::join('categoryvideos', 'categoryvideos.video_id', '=', 'videos.id')
                              ->where('category_id','=',$category_id)->where('active', '=', '1')->count();

        if ($categoryVideos_count > 0) {
    // blocked videos
              $block_videos= \App\BlockVideo::where('country_id',$countryName)->get();
              if(!$block_videos->isEmpty()){
                foreach($block_videos as $block_video){
                    $blockvideos[]=$block_video->video_id;
                }
              }    
              $blockvideos[]='';
              $categoryVideos = Video::join('categoryvideos', 'categoryvideos.video_id', '=', 'videos.id')
                                ->where('category_id','=',$category_id)->where('active', '=', '1');

              if($getfeching !=null && $getfeching->geofencing == 'ON'){
                 $categoryVideos = $categoryVideos  ->whereNotIn('videos.id',$blockvideos);
                 }
               $categoryVideos = $categoryVideos ->paginate();
              
          } else {
                $categoryVideos = [];
        }
        // $categoryVideos = \App\Video::where('video_category_id',$category_id)->paginate();
        $category_title = \App\VideoCategory::where('id',$category_id)->pluck('name');
        $settings = Setting::first();
        $PPV_settings = Setting::where('ppv_status','=',1)->first();
        if(!empty($PPV_settings)){

            $ppv_gobal_price =  $PPV_settings->ppv_price;

         }else{

             $ppv_gobal_price = null ;
         }
         $currency = CurrencySetting::first();
        
        $data = array(
                'currency'=> $currency,
                'category_title'=>$category_title[0],
                'categoryVideos'=>$categoryVideos,
                'ppv_gobal_price' => $ppv_gobal_price,
                'ThumbnailSetting' => $ThumbnailSetting,

            );
       return Theme::view('categoryvids',['data'=>$data]);
        
    } 
    
      public function play_videos($slug)
    {


        $data['password_hash'] = "";
        $data = session()->all();
       
        if(!empty($data['password_hash'])){

        $get_video_id = \App\Video::where('slug',$slug)->first(); 

        $vid = $get_video_id->id;

        // echo "<pre>"; 
        $artistscount = Videoartist::join("artists","video_artists.artist_id", "=", "artists.id")
        ->select("artists.*")
        ->where("video_artists.video_id", "=", $vid)
        ->count();
        if($artistscount > 0){
        $artists = Videoartist::join("artists","video_artists.artist_id", "=", "artists.id")
        ->select("artists.*")
        ->where("video_artists.video_id", "=", $vid)
        ->get();
        // dd($artists);

      }else{
        $artists = [];
      }

        // $cast = Videoartist::where('video_id','=',$vid)->get();
        //   foreach($cast as $key => $artist){
        //     $artists[] = Artist::where('id','=',$artist->artist_id)->get();

        //   }
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

          $sub_user = Session::get('subuser_id');

          $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
          $userIp = $geoip->getip();    
          $countryName = $geoip->getCountry();
          $regionName = $geoip->getregion();
          $cityName = $geoip->getcity();

            $view = new RecentView;
            $view->video_id  = $vid;
            $view->user_id  = Auth::user()->id;
            $view->country_name  = $countryName;
            // $view->videos_category_id = $get_video_id->video_category_id;
            if($sub_user != null){
              $view->sub_user  = $sub_user;
            }
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

          $ppvexist = PpvPurchase::where('video_id',$vid)
          ->where('user_id',$user_id)
          // ->where('status','active')
          // ->where('to_time','>',$current_date)
          ->count();
          $ppv_video = PpvPurchase::where('video_id',$vid)
          ->where('user_id',$user_id)
          ->first();
           $user_id = Auth::user()->id;
          if($ppvexist > 0 && $ppv_video->view_count > 0 && $ppv_video->view_count != null){
            $ppv_exist = PpvPurchase::where('video_id',$vid)
            ->where('user_id',$user_id)
            ->where('status','active')
            ->where('to_time','>',$current_date)->count();
            // $ppv_exist = 1;
          }elseif($ppvexist > 0 && $ppv_video->view_count == null){
            $ppv_exist = PpvPurchase::where('video_id',$vid)
            ->where('user_id',$user_id)
            // ->where('status','active')
            // ->where('to_time','>',$current_date)
            ->count();
            // $ppv_exist = 1;
          }
          else{
            $ppv_exist = 0;
          }
          // dd($get_video_id->views);



           $categoryVideos = Video::with('category.categoryname')->where('id',$vid)->first();
           $category_name = CategoryVideo::select('video_categories.name as categories_name')
           ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
           ->where('categoryvideos.video_id',$vid)
           ->get();
           if(count($category_name) > 0){
            foreach($category_name as $value){
              $vals[]  = $value->categories_name;  
            }
              $genres_name = implode(', ', $vals);
           }else{
            $genres_name = "No Genres Added";
           }

           $lang_name = LanguageVideo::select('languages.name as name')
           ->Join('languages', 'languagevideos.language_id', '=', 'languages.id')
           ->where('languagevideos.video_id',$vid)
           ->get();

           if(count($lang_name) > 0){

            foreach($lang_name as $value){
              $languagesvals[]  = $value->name;  
            }
              $lang_name = implode(',', $languagesvals);
           }else{
            $lang_name = "No Languages Added";
           }

           $artists_name = Videoartist::select('artists.artist_name as name')
           ->Join('artists', 'video_artists.artist_id', '=', 'artists.id')
           ->where('video_artists.video_id',$vid)
           ->get();
           
           if(count($artists_name) > 0){

            foreach($artists_name as $value){
              $artistsvals[]  = $value->name;  
            }
              $artistsname = implode(',', $artistsvals);
           }else{
            $artistsname = "No Languages Added";
           }


           $subtitles_name = MoviesSubtitles::select('subtitles.language as language')
           ->Join('subtitles', 'movies_subtitles.shortcode', '=', 'subtitles.short_code')
           ->where('movies_subtitles.movie_id',$vid)
           ->get();
          //  if(!empty($subtitles_name)){
           if(count($subtitles_name) > 0){
            foreach($subtitles_name as $value){
              $subtitlesname[]  = $value->language;  
            }
              $subtitles = implode(', ', $subtitlesname);
           }else{
            $subtitles = "No Genres Added";
           }
          //  dd($subtitles);

           $category_id = CategoryVideo::where('video_id', $vid)->get();
           $categoryvideo = CategoryVideo::where('video_id', $vid)->pluck('category_id')->toArray();
           $languages_id = LanguageVideo::where('video_id', $vid)->pluck('language_id')->toArray();
           foreach($category_id as $key => $value){
           $recomendeds = Video::select('videos.*','video_categories.name as categories_name','categoryvideos.category_id as categories_id')
           ->Join('categoryvideos', 'videos.id', '=', 'categoryvideos.video_id')
           ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
           ->where('videos.id','!=',$vid)
           ->limit(10)->get();
           }
           if(!empty($recomendeds)){
            foreach($recomendeds as $category){
              if(in_array($category->categories_id, $categoryvideo)){
               $recomended[] = $category;
             }            
             }
           }else{
             $recomended = [];
           }
           if(!empty($recomended)){
            $recomended = $recomended;
           }else{
            $recomended =[] ;
           }
           
          $videocategory = [];

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

                    $ppv_video = PpvPurchase::where('user_id',Auth::user()->id)->where('status','active')->get();
                    $ppv_setting = Setting::first();
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

    
                        }else{
                          $ppv_video_play = null;
                        }                 
                    }else{
                        PpvPurchase::where('video_id', $vid)
                                ->update([
                                    'status' => 'inactive'
                                    ]);
                    }
                    $purchased_video = Video::where('id',$value->video_id)->get();

                    }
                    }
            
                $ads = AdsVideo::select('advertisements.*')
                ->Join('advertisements', 'advertisements.id', '=', 'ads_videos.ads_id')
                ->where('ads_videos.video_id','=',$vid)
                ->get();
                // $ads = AdsVideo::where('video_id',126)->get();
                if(!empty($ads) && (count($ads)) > 0){
                  $ads_path = $ads[0]->ads_path;
                }else{
                  $ads_path = "";
                }
                // $artists = [];
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
            $category_name = CategoryVideo::select('video_categories.name as categories_name')
                  ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
                  ->where('categoryvideos.video_id',$vid)
                  ->get();
                     

            $langague_Name = Language::join("languagevideos","languages.id", "=", "languagevideos.language_id")
            ->where('video_id',$vid)->get();

            $release_year = Video::where('id',$vid)->pluck('year')->first(); 

            $Reels_videos = Video::Join('reelsvideo','reelsvideo.video_id','=','videos.id')->where('videos.id',$vid)->get();

            if(!empty($categoryVideos->publish_time)){
            $new_date = Carbon::parse($categoryVideos->publish_time)->format('M d , y H:i:s');
            $currentdate = date("M d , y H:i:s");
            date_default_timezone_set('Asia/Kolkata');
            $current_date = Date("M d , y H:i:s");
            // $current_date = date("Y-m-d");
            $date=date_create($current_date);
            $currentdate = date_format($date,"M d ,y H:i:s");
             if($currentdate < $new_date){
              // echo "<pre>";
              // print_r($new_date);
              // echo "<pre>";

              // print_r($currentdate);exit;

              $new_date = Carbon::parse($categoryVideos->publish_time)->format('M d , y h:i:s');

             }else{
            //  print_r($currentdate);exit;

              $new_date = null;
            }
             }else{
              $new_date = null;
             }
            //  print_r($new_date);exit;
             $currency = CurrencySetting::first();
                 $data = array(
                      'currency' => $currency,
                     'video' => $categoryVideos,
                     'videocategory' => $videocategory,
                     'recomended' => $recomended,
                     'ads_path' => $ads_path,
                     'ppv_exist' => $ppv_exist,
                     'ppv_price' => 100,
                    'publishable_key' => $publishable_key,
                     'watchlatered' => $watchlater,
                     'mywishlisted' => $wishlisted,
                     'watched_time' => $watchtime,
                     'like_dislike' =>$like_dislike,
                     'ppv_rent_price' =>$ppv_rent_price,
                     'new_date' =>$new_date,
                 'playerui_settings' => $playerui,
                 'subtitles' => $subtitle,
                 'artists' => $artists,
    		'ppv_video_play' => $ppv_video_play,
            'ads' => \App\AdsVideo::where('video_id',$vid)->first(),
            'category_name'=> $category_name,
            'langague_Name' => $langague_Name,
            'release_year'  => $release_year,
            'Reels_videos'  => $Reels_videos,
            'genres_name'  => $genres_name,
            'artistsname'  => $artistsname,
            'lang_name'  => $lang_name,
            'subtitles_name'  => $subtitles,



                 );
             
        } else {

          $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
          $userIp = $geoip->getip();    
          $countryName = $geoip->getCountry();
          $regionName = $geoip->getregion();
          $cityName = $geoip->getcity();
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
    $currency = CurrencySetting::first();

    $category_name = CategoryVideo::select('video_categories.name as categories_name')
    ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
    ->where('categoryvideos.video_id',$vid)
    ->get();
 

    $langague_Name = Language::join("languagevideos","languages.id", "=", "languagevideos.language_id")
    ->where('video_id',$vid)->get();

    $release_year = Video::where('id',$vid)->pluck('year')->first(); 

    $Reels_videos = Video::where('id',$vid)->whereNotNull('reelvideo')->get();

            $data = array(
                 'currency' => $currency,
                 'video' => $categoryVideos,
                 'recomended' => $recomended,
                 'playerui_settings' => $playerui,
                 'subtitles' => $subtitle,
                 'artists' => $artists,
                 'watched_time' => 0,
                 'ads' => \App\AdsVideo::where('video_id',$vid)->first(),
                 'category_name'=> $category_name,
                 'langague_Name' => $langague_Name,
                 'release_year'  => $release_year,
                 'Reels_videos'  => $Reels_videos,
     
            );

            }
 
       return Theme::view('video', $data); 
    }else{
    
        $get_video_id = \App\Video::where('slug',$slug)->first(); 
        $vid = $get_video_id->id;
        $current_date = date('Y-m-d h:i:s a', time()); 
        $currency = CurrencySetting::first();

            
        
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
             $currency = CurrencySetting::first();
             $langague_Name = Language::join("languagevideos","languages.id", "=", "languagevideos.language_id")
                                      ->where('video_id',$vid)->get();
 
             $release_year = Video::where('id',$vid)->pluck('year')->first(); 
 
             $Reels_videos = Video::where('id',$vid)->whereNotNull('reelvideo')->get();

             $category_name = CategoryVideo::select('video_categories.name as categories_name')
             ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
             ->where('categoryvideos.video_id',$vid)
             ->get();
          

                 $data = array(
                    'currency' => $currency,
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
                 'ads' => \App\AdsVideo::where('video_id',$vid)->first(),
                 'category_name'=> $category_name,
                 'langague_Name' => $langague_Name,
                 'release_year'  => $release_year,
                 'Reels_videos'  => $Reels_videos,
     
                 );
             
        } else {

           
            $categoryVideos = \App\Video::where('id',$vid)->first();
            $category_id = \App\Video::where('id',$vid)->pluck('video_category_id');
            $recomended = \App\Video::where('video_category_id','=',$category_id)->where('id','!=',$vid)->limit(10)->get();
    $playerui = Playerui::first();
    $subtitle = MoviesSubtitles::where('movie_id','=',$vid)->get();
    $currency = CurrencySetting::first();
    $langague_Name = Language::join("languagevideos","languages.id", "=", "languagevideos.language_id")
    ->where('video_id',$vid)->get();

    $release_year = Video::where('id',$vid)->pluck('year')->first(); 

    $Reels_videos = Video::where('id',$vid)->whereNotNull('reelvideo')->get();
    $category_name = CategoryVideo::select('video_categories.name as categories_name')
    ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
    ->where('categoryvideos.video_id',$vid)
    ->get();
 

            $data = array(
                 'currency' => $currency,
                 'video' => $categoryVideos,
                 'recomended' => $recomended,
                 'playerui_settings' => $playerui,
                 'subtitles' => $subtitle,
                 'watched_time' => 0,
                 'ads' => \App\AdsVideo::where('video_id',$vid)->first(),
                 'category_name'=> $category_name,
                 'langague_Name' => $langague_Name,
                 'release_year'  => $release_year,
                 'Reels_videos'  => $Reels_videos,
     
            );

            }
            return Theme::view('video_before_login', $data); 
 
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
    
    public function Watchlist($slug)
    {
        $video = Video::where('slug', '=', $slug)->first();
        $video_id = $video->id;
         $count = Wishlist::where('user_id', '=', Auth::User()->id)->where('video_id', '=', $video_id)->count();
        if ( $count > 0 ) {
          Wishlist::where('user_id', '=', Auth::User()->id)->where('video_id', '=', $video_id)->delete();
        } else {
          $data = array('user_id' => Auth::User()->id, 'video_id' => $video_id );
          Wishlist::insert($data);  
        }
        return Redirect::back();
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

                    $ppv_video = PpvPurchase::where('user_id',Auth::user()->id)->where('status','active')->get();
                    $ppv_setting = Setting::first();
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
                    $purchased_video = Video::where('id',$value->video_id)->get();

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
            
                    $currency = CurrencySetting::first();

                 $data = array(
                      'currency' => $currency,
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
    $currency = CurrencySetting::first();

            $data = array(
              'currency' => $currency,
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
        $currency = CurrencySetting::first();

            
        
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
           $currency = CurrencySetting::first();

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
                  'currency' => $currency,
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
    $currency = CurrencySetting::first();

            $data = array(
              'currency' => $currency,
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


        public function Embed_play_videos($slug)
        {
    
            $data['password_hash'] = "";
            $data = session()->all();
           
            if(!empty($data['password_hash'])){
    
            $get_video_id = \App\Video::where('slug',$slug)->first(); 
    
            $vid = $get_video_id->id;
    
            // echo "<pre>"; 
            $artistscount = Videoartist::join("artists","video_artists.artist_id", "=", "artists.id")
            ->select("artists.*")
            ->where("video_artists.video_id", "=", $vid)
            ->count();
            if($artistscount > 0){
            $artists = Videoartist::join("artists","video_artists.artist_id", "=", "artists.id")
            ->select("artists.*")
            ->where("video_artists.video_id", "=", $vid)
            ->get();
            // dd($artists);
    
          }else{
            $artists = [];
          }
    
            // $cast = Videoartist::where('video_id','=',$vid)->get();
            //   foreach($cast as $key => $artist){
            //     $artists[] = Artist::where('id','=',$artist->artist_id)->get();
    
            //   }
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
    
              $sub_user = Session::get('subuser_id');
    
              $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
              $userIp = $geoip->getip();    
              $countryName = $geoip->getCountry();
              $regionName = $geoip->getregion();
              $cityName = $geoip->getcity();
    
                $view = new RecentView;
                $view->video_id  = $vid;
                $view->user_id  = Auth::user()->id;
                $view->country_name  = $countryName;
                // $view->videos_category_id = $get_video_id->video_category_id;
                if($sub_user != null){
                  $view->sub_user  = $sub_user;
                }
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
    
               $categoryVideos = Video::with('category.categoryname')->where('id',$vid)->first();
               $category_name = CategoryVideo::select('video_categories.name as categories_name')
               ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
               ->where('categoryvideos.video_id',$vid)
               ->get();
              //  dd($category_name);
               $category_id = CategoryVideo::where('video_id', $vid)->get();
               $categoryvideo = CategoryVideo::where('video_id', $vid)->pluck('category_id')->toArray();
               $languages_id = LanguageVideo::where('video_id', $vid)->pluck('language_id')->toArray();
               foreach($category_id as $key => $value){
               $recomendeds = Video::select('videos.*','video_categories.name as categories_name','categoryvideos.category_id as categories_id')
               ->Join('categoryvideos', 'videos.id', '=', 'categoryvideos.video_id')
               ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
               ->where('videos.id','!=',$vid)
               ->limit(10)->get();
               }
               if(!empty($recomendeds)){
                foreach($recomendeds as $category){
                  if(in_array($category->categories_id, $categoryvideo)){
                   $recomended[] = $category;
                 }            
                 }
               }else{
                 $recomended = [];
               }
               if(!empty($recomended)){
                $recomended = $recomended;
               }else{
                $recomended =[] ;
               }
               
              $videocategory = [];
    
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
    
                        $ppv_video = PpvPurchase::where('user_id',Auth::user()->id)->where('status','active')->get();
                        $ppv_setting = Setting::first();
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
                        $purchased_video = Video::where('id',$value->video_id)->get();
    
                        }
                        }
                
                    $ads = AdsVideo::select('advertisements.*')
                    ->Join('advertisements', 'advertisements.id', '=', 'ads_videos.ads_id')
                    ->where('ads_videos.video_id','=',$vid)
                    ->get();
                    // $ads = AdsVideo::where('video_id',126)->get();
                    if(!empty($ads) && (count($ads)) > 0){
                      $ads_path = $ads[0]->ads_path;
                    }else{
                      $ads_path = "";
                    }
                    // $artists = [];
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
                         'videocategory' => $videocategory,
                         'recomended' => $recomended,
                         'ads_path' => $ads_path,
                         'ppv_exist' => $ppv_exist,
                         'ppv_price' => 100,
                        'publishable_key' => $publishable_key,
                         'watchlatered' => $watchlater,
                         'mywishlisted' => $wishlisted,
                         'watched_time' => $watchtime,
                         'like_dislike' =>$like_dislike,
                         'ppv_rent_price' =>$ppv_rent_price,
                     'playerui_settings' => $playerui,
                     'subtitles' => $subtitle,
                     'artists' => $artists,
            'ppv_video_play' => $ppv_video_play,
                'ads' => \App\AdsVideo::where('video_id',$vid)->first(),
                'category_name'=> $category_name,
    
                     );
                 
            } else {
    
              $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
              $userIp = $geoip->getip();    
              $countryName = $geoip->getCountry();
              $regionName = $geoip->getregion();
              $cityName = $geoip->getcity();
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
        $currency = CurrencySetting::first();
    
                $data = array(
                     'currency' => $currency,
                     'video' => $categoryVideos,
                     'recomended' => $recomended,
                     'playerui_settings' => $playerui,
                     'subtitles' => $subtitle,
                     'artists' => $artists,
                     'watched_time' => 0,
                     'ads' => \App\AdsVideo::where('video_id',$vid)->first(),
                );
    
                }
     
           return Theme::view('embedvideo', $data); 
        }
            }

      public function Reals_videos(Request $request,$slug)
      {
        $video_id = \App\Video::where('slug',$slug)->pluck('id')->first(); 

        $Reels_videos= Video::where('id',$video_id)->first();

        $data = array(
          'video' => $Reels_videos,
        );

        return Theme::view('Reelvideos',$data); 

      }
    
}

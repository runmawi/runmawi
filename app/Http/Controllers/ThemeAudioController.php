<?php

namespace App\Http\Controllers;

use \App\User as User;
use App\Setting as Setting;
use \Redirect as Redirect;
use App\Slider as Slider;
use App\PpvVideo as PpvVideo;
use App\RecentView as RecentView;
use App\PpvCategory as PpvCategory;
use App\VerifyNumber as VerifyNumber;
use App\Subscription as Subscription;
use App\PaypalPlan as PaypalPlan;
use App\ContinueWatching as ContinueWatching;
use App\PpvPurchase as PpvPurchase;
use App\Watchlater as Watchlater;
use App\Wishlist as Wishlist;
use App\Page as Page;
use App\Audio as Audio;
use App\AudioAlbums as AudioAlbums;
use App\Artist as Artist;
use App\AudioCategory as AudioCategory;
use App\LikeDislike as Likedislike;
use App\Favorite as Favorite;
use App\Genre;
use App\Audioartist;
use App\Seriesartist;
use App\Videoartist;
use URL;
use Auth;
use View;
use Hash;
use Mail;
use Nexmo;
use App\Menu as Menu;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\ImageManagerStatic as Image;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\Authenticatable;
use GeoIPLocation;
use Stevebauman\Location\Facades\Location;
use Carbon\Carbon as Carbon;
use Session;
use App\BlockAudio;
use App\Geofencing;
use Theme;
Use App\HomeSetting;
Use App\CategoryAudio;


class ThemeAudioController extends Controller{

    private $audios_per_page = 12;

    public function __construct()
    {
        $settings = Setting::first();
        $this->audios_per_page = $settings->audios_per_page;
        $this->movies_per_page = $settings->audios_per_page;
        $this->series_per_page = $settings->audios_per_page;

        $this->Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses(  $this->Theme );
    }

    /**
     * Display the specified audio.
     *
     * @param  int  $id
     * @return Response
     */
    public function index($slug,$name = '')
      {

        if(Auth::guest()):
            return Redirect::to('/login');
        endif;
        //$audio = Audio::findOrFail($albumID);
        $getfeching= Geofencing::first();
        $getfeching= Geofencing::first();
        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
        $userIp = $geoip->getip();    
        $countryName = $geoip->getCountry();
        
        if (!empty($name)) {
          
             $audio = Audio::select('id')->where('slug','=',$name)->where('status','=',1)->first();
             $audio = $audio->id;
             $albumID = Audio::select('album_id')->where('slug','=',$name)->where('status','=',1)->first();
        
             $check_audio_details = Audio::where('slug','=',$name)->where('status','=',1)->first();
            
            
              if (!empty($check_audio_details)) {
                  $audio_details = Audio::where('slug','=',$name)->where('status','=',1)->first();
                } else {
                     $audio_details = Audio::where('id','=',$albumID)->where('status','=',1)->first();
                }
            
                $audio_cat_id  = Audio::select('audio_category_id')->where('album_id','=',$albumID)->where('status','=',1)->first();
        

                $audionext = Audio::select('slug')->where('id', '>', $audio)->where('album_id', '=', $albumID)->where('status','=',1)->first();

                $audioprev = Audio::where('id', '<', $audio)->where('album_id', '=', $albumID)->where('status','=',1)->first();


                  // blocked Audio
                  $block_Audio=BlockAudio::where('country',$countryName)->get();
                  if(!$block_Audio->isEmpty()){
                     foreach($block_Audio as $blocked_Audios){
                        $blocked_Audio[]=$blocked_Audios->audio_id;
                     }
                  }    
                  $blocked_Audio[]='';
                
                  $related_audio  = Audio::where('album_id','=',$albumID)->where('id','!=',$audio)->where('status','=',1);
                    if($getfeching !=null && $getfeching->geofencing == 'ON'){
                         $related_audio = $related_audio  ->whereNotIn('id',$blocked_Audio);
                  }
                   $related_audio = $related_audio ->get();

            
                $favorited = false;
                if(!Auth::guest()):
                    $favorited = Favorite::where('user_id', '=', Auth::user()->id)->where('audio_id', '=', $audio)->first();
                endif;
                $wishlisted = false;
                if(!Auth::guest()):
                    $wishlisted = Wishlist::where('user_id', '=', Auth::user()->id)->where('audio_id', '=', $audio)->first();
                endif;
                $watchlater = false;
                if(!Auth::guest()):
                    $watchlater = Watchlater::where('user_id', '=', Auth::user()->id)->where('audio_id', '=', $audio)->first();
                endif;
            
            
        } else {
           
            $audio = Audio::where('slug','=',$slug)->where('status','=',1)->first();
            if(!empty($audio)){
            $audio = $audio->id;
            }else{
            $audio = "";
            }

            $view = new RecentView;
            $view->audio_id = $audio;
            $view->user_id = Auth::user()->id;
            $view->visited_at = date('Y-m-d');
            $view->save();
             if (!empty($audio)) {
              $check_audio_details = Audio::where('id','=',$audio)->where('status','=',1)->first();
              $albumID = $check_audio_details->album_id;
                
              if (!empty($check_audio_details) && empty($name)) {
            //   echo "<pre>";print_r($albumID);exit();

                  $audio_details = Audio::where('slug','=',$slug)->where('status','=',1)->first();
                   
                } else {
                     $audio_details = Audio::where('album_id','=',$albumID)->where('status','=',1)->first();
        
                }
                $audio_cat_id  = Audio::select('audio_category_id')->where('album_id','=',$albumID)->where('status','=',1)->first();
        
                $audiocurrent = Audio::select('id')->where('album_id', '=', $albumID)->where('status','=',1)->first();

                $audionext = Audio::select('slug')->where('id', '>', $audiocurrent)->where('album_id', '=', $albumID)->where('status','=',1)->first();

                $audioprev = Audio::where('id', '<', $audiocurrent)->where('album_id', '=', $albumID)->where('status','=',1)->first();

                   // blocked Audio
                   $block_Audio=BlockAudio::where('country',$countryName)->get();
                   if(!$block_Audio->isEmpty()){
                      foreach($block_Audio as $blocked_Audios){
                         $blocked_Audio[]=$blocked_Audios->audio_id;
                      }
                   }    
                   $blocked_Audio[]='';
                 
                   $related_audio  = Audio::where('album_id','=',$albumID)->where('id','!=',$audio)->where('status','=',1);
                     if($getfeching !=null && $getfeching->geofencing == 'ON'){
                          $related_audio = $related_audio  ->whereNotIn('id',$blocked_Audio);
                   }
                    $related_audio = $related_audio ->get();
 
                 
                $favorited = false;
                if(!Auth::guest()):
                    $favorited = Favorite::where('user_id', '=', Auth::user()->id)->where('audio_id', '=', $audio)->first();
                endif;
                $wishlisted = false;
                if(!Auth::guest()):
                    $wishlisted = Wishlist::where('user_id', '=', Auth::user()->id)->where('audio_id', '=', $audio)->first();
                endif;
                $watchlater = false;
                if(!Auth::guest()):
                    $watchlater = Watchlater::where('user_id', '=', Auth::user()->id)->where('audio_id', '=', $audio)->first();
                endif;
                 
             } else {
                  $data = array(
                'message' => 'No Audio Found',
                'error' =>'error'
                );

                return Theme::view('audio', $data);
            }
            
            
        }
      
            if (!empty($audio_details)) {
                $ppv_status = PpvPurchase::with('audio')->where('audio_id','=',$audio)->where('user_id','=',Auth::user()->id)->where('to_time', '>', Carbon::now())->count();
                $view_increment = $this->handleViewCount($audio); 

            $json = array('title' => $audio_details->title,'mp3'=>$audio_details->mp3_url);  
            $data = array(
                'audio' => Audio::findOrFail($audio),
                'json_list' => json_encode($json),
                'album_name' => AudioAlbums::findOrFail($albumID)->albumname,
                'album_slug' => AudioAlbums::findOrFail($albumID)->slug,
                'other_albums' => AudioAlbums::where('id','!=', $albumID)->get(),
                'audio_details' => $audio_details,
                'related_audio' => $related_audio,
                'audionext' => $audionext,
                'audioprev' => $audioprev,
                'current_slug' =>$slug,
                'url' => 'audio',
                'ppv_status' => $ppv_status,
                'view_increment' => $view_increment,
                'menu' => Menu::orderBy('order', 'ASC')->get(),
                'favorited' => $favorited,
                'media_url' => URL::to('/').'/audio/'.$slug,
                'mywishlisted' => $wishlisted,
                'watchlatered' => $watchlater,
                'audio_categories' => AudioCategory::all(),
                'pages' => Page::where('active', '=', 1)->get(),
                );
            } else {
                $data = array(
                'messge' => 'No Audio Found'
                );
                
            }
        //     echo '<pre>';
        // print_r($data);
        // exit();
           
            return Theme::view('audio', $data);

        
    }

    /*
     * Page That shows the latest audio list
     *
     */
    public function audios(Request $request)
    {   

        if(Auth::guest()):
            return Redirect::to('/login');
        endif;
        $getfeching= Geofencing::first();
        $getfeching= Geofencing::first();
        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
        $userIp = $geoip->getip();    
        $countryName = $geoip->getCountry();

        $page =$request->get('page');
        if( !empty($page) ){
            $page = $request->get('page');
        } else {
            $page = 1;
        }
        $audios_count = Audio::where('active', '=', '1')->orderBy('created_at', 'DESC')->count();

        // dd($audios_count);
        if ($audios_count > 0) {
               // blocked Audio
               $block_Audio=BlockAudio::where('country',$countryName)->get();
               if(!$block_Audio->isEmpty()){
                  foreach($block_Audio as $blocked_Audios){
                     $blocked_Audio[]=$blocked_Audios->audio_id;
                  }
               }    
               $blocked_Audio[]='';
               $audios  =  Audio::where('active', '=', '1')->orderBy('created_at', 'DESC');
                 if($getfeching !=null && $getfeching->geofencing == 'ON'){
                      $audios = $audios  ->whereNotIn('id',$blocked_Audio);
               }
                $audios = $audios ->simplePaginate($this->audios_per_page);   
            } else {
              $audios = [];
            } 
            
        $data = array(
            'audios' => $audios,
            'audios_count' => $audios_count,
            'albums' => AudioAlbums::orderBy('created_at', 'DESC')->get(),
            'artists' => Artist::orderBy('created_at', 'DESC')->get(),
            'page_title' => 'All Audios',
            'page_description' => 'Page ' . $page,
            'current_page' => $page,
            'menu' => Menu::orderBy('order', 'ASC')->get(),
            'pagination_url' => '/audios',
            'audio_categories' => AudioCategory::all(),
            'pages' => Page::where('active', '=', 1)->get(),
            );

        return Theme::view('audio-list', $data);
    }


   

    public function category($slug,Request $request)
    {
        if(Auth::guest()):
            return Redirect::to('/login');
        endif;
        
        $page = $request->get('page');
        if( !empty($page) ){
            $page = $request->get('page');
        } else {
            $page = 1;
        }
        $getID = AudioCategory::select('id')->where('slug', '=', $slug)->first();
        $categoryAudio = CategoryAudio::where('category_id', $getID->id)->pluck('audio_id')->toArray();
            if(!empty($getID)){    
           $audios_count = Audio::select('audio.*','audio_categories.name as categories_name','category_audios.category_id as categories_id')
           ->Join('category_audios', 'audio.id', '=', 'category_audios.audio_id')
           ->Join('audio_categories', 'category_audios.category_id', '=', 'audio_categories.id')
           ->where('audio_categories.id','=',$getID->id)
           ->count();
           $audios = Audio::select('audio.*','audio_categories.name as categories_name','category_audios.category_id as categories_id')
           ->Join('category_audios', 'audio.id', '=', 'category_audios.audio_id')
           ->Join('audio_categories', 'category_audios.category_id', '=', 'audio_categories.id')
           ->where('audio_categories.id','=',$getID->id)
           ->get();

        }else{
            $audios_count = 0;
        }
        //    dd($audios);

    //     $getID = AudioCategory::select('id')->where('slug', '=', $slug)->first();
    //     $cat = AudioCategory::where('id', '=', $getID->id)->first();
        
    //     $parent_cat = AudioCategory::where('id', '=', $cat->id)->first();
       
    //     $albums = AudioAlbums::where('parent_id','=',$getID->id)->orderBy('created_at', 'DESC')->get();
        
    //     if(!empty($albums)){

    //   $audios_count = AudioAlbums::join('audios', 'audios.album_id', '=', 'audio_albums.id')
    //   ->where('audio_albums.parent_id','=',$getID->id)
    //   ->select('audios.*')
    //   ->count();
    //   $audios = AudioAlbums::join('audios', 'audios.album_id', '=', 'audio_albums.id')
    //   ->where('audio_albums.parent_id','=',$getID->id)
    //   ->select('audios.*')
    //   ->get();
    //     }else{
    //         $audios_count = 0;
    //     }

    // dd($audios_count);
        
        // if(!empty($parent_cat->id)){

        //     $parent_cat2 = AudioCategory::where('parent_id', '=', $parent_cat->id)->first();
        //     if(!empty($parent_cat2->id)){
        //         $audios_count  = Audio::where('active', '=', '1')->where('audio_category_id', '=', $cat->id)->orWhere('audio_category_id', '=', $parent_cat->id)->orWhere('audio_category_id', '=', $parent_cat2->id)->orderBy('created_at', 'DESC')->count();
        //         $audios = Audio::where('active', '=', '1')->where('audio_category_id', '=', $cat->id)->orWhere('audio_category_id', '=', $parent_cat->id)->orWhere('audio_category_id', '=', $parent_cat2->id)->orderBy('created_at', 'DESC')->simplePaginate(9);
        //     } else {

        //         $audios_count  = Audio::where('active', '=', '1')->where('audio_category_id', '=', $cat->id)->orWhere('audio_category_id', '=', $parent_cat->id)->orderBy('created_at', 'DESC')->count();
        //         $audios = Audio::where('active', '=', '1')->where('audio_category_id', '=', $cat->id)->orWhere('audio_category_id', '=', $parent_cat->id)->orderBy('created_at', 'DESC')->simplePaginate(9);
        //     }
        // } else {
        //         $audios_count  = Audio::where('active', '=', '1')->where('audio_category_id', '=', $cat->id)->orderBy('created_at', 'DESC')->count();
        //     $audios = Audio::where('active', '=', '1')->where('audio_category_id', '=', $cat->id)->orderBy('created_at', 'DESC')->simplePaginate(9);
        // }


        $data = array(
            'audios_category' => $audios,
            // 'current_page' => $page,
            // 'albums'=>$albums,
            // 'category' => $cat,
            // 'page_title' => 'Audios - ' . $cat->name,
            // 'page_description' => 'Page ' . $page,
            // 'pagination_url' => '/audios/category/' . $slug,
            // 'menu' => Menu::orderBy('order', 'ASC')->get(),
            // 'audio_categories' => AudioCategory::all(),
            // 'theme_settings' => ThemeHelper::getThemeSettings(),
            // 'pages' => Page::where('active', '=', 1)->get(),
            'audios_count' => $audios_count,

        );
        return Theme::view('audiocategory', $data);

        // return View::make('audio-list', $data);
    }

    public function handleViewCount($id){
        
        if(Auth::guest()):
            return Redirect::to('/login');
        endif;
        // check if this key already exists in the view_media session
        $blank_array = array();
        if (! array_key_exists($id, Session::get('viewed_audio', $blank_array) ) ) {
            
            try{
                // increment view
                $audio = Audio::find($id);
                $audio->views = $audio->views + 1;
                $audio->save();
                // Add key to the view_media session
                Session::put('viewed_audio.'.$id, time());
                return true;
            } catch (Exception $e){
                return false;
            }
        } else {
            return false;
        }
    }

   
    public function categoryaudios($audio_id)
    {
       if(Auth::guest()):
            return Redirect::to('/login');
        endif;
        
        $audio = Audio::findOrFail($audio_id);
        $audionext = Audio::where('id', '>', $audio_id)->where('audio_category_id', '=', $audio->audio_category_id)->first();
        $audioprev = Audio::where('id', '<', $audio_id)->where('audio_category_id', '=', $audio->audio_category_id)->first();
        $audioresolution = Audio::findOrFail($audio_id)->audioresolutions;
        $audiosubtitles = Audio::findOrFail($audio_id)->audiosubtitles;

        //Make sure audio is active
        if((!Auth::guest() && Auth::user()->role == 'admin') || $audio->active){

            $favorited = false;
            if(!Auth::guest()):
                $favorited = Favorite::where('user_id', '=', Auth::user()->audio_id)->where('audio_id', '=', $audio->audio_id)->first();
            endif;

            $view_increment = $this->handleViewCount($audio_id);

            $data = array(
                'audio' => $audio,
                'media_url' => URL::to('/').'/audio/'.$audio->slug,
                'audios_category_next' => $audionext,
                'audios_category_prev' => $audioprev,
                'audioresolution' => $audioresolution,
                'audiosubtitles' => $audiosubtitles,
                'menu' => Menu::orderBy('order', 'ASC')->get(),
                'view_increment' => $view_increment,
                'favorited' => $favorited,
                'audio_categories' => AudioCategory::all(),
                'theme_settings' => ThemeHelper::getThemeSettings(),
                'pages' => Page::where('active', '=', 1)->get(),
                );
            return View::make('Theme::audio', $data);

        } else {
            return Redirect::to('audios')->with(array('note' => 'Sorry, this audio is no longer active.', 'note_type' => 'error'));
        }
    }
    
    public function album($album_slug) {
       
        if(Auth::guest()):
            return Redirect::to('/login');
        endif;
        $getfeching= Geofencing::first();
        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
        $userIp = $geoip->getip();    
        $countryName = $geoip->getCountry();
        
            $album_id = AudioAlbums::where('slug', $album_slug)->first()->id;
            $album = AudioAlbums::where('id', $album_id)->first();
         
               // blocked Audio
               $block_Audio=BlockAudio::where('country',$countryName)->get();
               if(!$block_Audio->isEmpty()){
                  foreach($block_Audio as $blocked_Audios){
                     $blocked_Audio[]=$blocked_Audios->audio_id;
                  }
               }    
               $blocked_Audio[]='';
               $album_audios  =  Audio::where('album_id', $album_id);
                 if($getfeching !=null && $getfeching->geofencing == 'ON'){
                      $album_audios = $album_audios  ->whereNotIn('id',$blocked_Audio);
               }
                $album_audios = $album_audios ->get();

            $other_albums = AudioAlbums::where('id','!=', $album_id)->get();
            foreach ($album_audios as $key => $album_audio) {
                $json[] = array('title' => $album_audio->title,'mp3'=>$album_audio->mp3_url);
            }

            $data = array(
                'album' => $album,
                'json_list' => json_encode($json),
                'media_url' => URL::to('/').'/album/'.$album_slug,
                'album_audios' => $album_audios,
                'other_albums' => $other_albums,
            );
        return Theme::view('albums', $data);
    }

    public function add_favorite(Request $request)
    {
        $audio_id = $request->get('audio_id');
        if($audio_id){
            $favorite = Favorite::where('user_id', '=', Auth::user()->id)->where('audio_id', '=', $audio_id)->first();
            if(isset($favorite->id)){ 
                $favorite->delete();
            } else {
                $favorite = new Favorite;
                $favorite->user_id = Auth::user()->id;
                $favorite->audio_id = $audio_id;
                $favorite->save();
                echo $favorite;
            }
        }
    }

    public function albumfavorite(Request $request)
    {
        $album_id = $request->get('album_id');
        if($album_id){
            $favorite = Favorite::where('user_id', '=', Auth::user()->id)->where('album_id', '=', $album_id)->first();
            if(isset($favorite->id)){ 
                $favorite->delete();
            } else {
                $favorite = new Favorite;
                $favorite->user_id = Auth::user()->id;
                $favorite->album_id = $album_id;
                $favorite->save();
                echo $favorite;
            }
        }
    }

    /*public function artist($artist_id) {
       
         if(Auth::guest()):
            return Redirect::to('/login');
        endif;
        $audios = $album_ids = array();
        $latest_audios = DB::table('audio_artists')->select('audio_id')->where('artist_id',$artist_id)->get()->toArray();
        foreach ($latest_audios as $key => $latest_audio) {
            $audio_id = $latest_audio->audio_id;
            if(Audio::where('id',$audio_id)->where('active','=',1)->orderBy('created_at', 'desc')->exists()){
                $audios[] = Audio::where('id',$audio_id)->where('active','=',1)->orderBy('created_at', 'desc')->get();
                $getdata = Audio::where('id',$audio_id)->where('active','=',1)->orderBy('created_at', 'desc')->first();
                $album_ids[] = $getdata->album_id;
            }
        }
        $albums = AudioAlbums::whereIn('id', $album_ids)->get();
        $data = array(
            'artist' => Artist::where('id',$artist_id)->first(),
            'latest_audios' => $audios,
            'albums' => $albums,
        );
        return View::make('artist', $data);
    }*/
    
     public function artist($artist_id) {
       
         if(Auth::guest()):
            return Redirect::to('/login');
        endif;
        $audios = $album_ids = array();
       
        $latest_audios = Audioartist::select('audio_id')->where('artist_id',$artist_id)->get()->toArray();

        foreach ($latest_audios as $key => $latest_audio) {
            $audio_id = $latest_audio->audio_id;
            if(Audio::where('id',$audio_id)->where('active','=',1)->orderBy('created_at', 'desc')->exists()){
                $audios[] = Audio::where('id',$audio_id)->where('active','=',1)->orderBy('created_at', 'desc')->get();
                $getdata = Audio::where('id',$audio_id)->where('active','=',1)->orderBy('created_at', 'desc')->first();
                $album_ids[] = $getdata->album_id;
            } 
        }
        $albums = AudioAlbums::whereIn('id', $album_ids)->get();
        $artist_audios = Audioartist::select('audio.*')
                ->join('audio', 'audio.id', '=', 'audio_artists.audio_id')
                ->where('audio_artists.artist_id', $artist_id)
                ->orderBy('audio.created_at', 'desc')
                ->get();
    $artist_series = Seriesartist::select('series.*')
    ->join('series', 'series.id', '=', 'series_artists.series_id')
    ->where('series_artists.artist_id', $artist_id)
    ->orderBy('series.created_at', 'desc')
    ->get();
    $artist_videos = Videoartist::select('videos.*')
    ->join('videos', 'videos.id', '=', 'video_artists.video_id')
    ->where('video_artists.artist_id', $artist_id)
    ->orderBy('videos.created_at', 'desc')
    ->get();
        // $artist_audios = DB::table('audio_artists')->select('audio_id')->where('artist_id',$artist_id)->get()->toArray();
        // $audios[] = Audioartist::where('artist_id',$artist_id)->orderBy('created_at', 'desc')->get();
        // echo "<pre>";
        // print_r($artist_series);
        // exit();
        $data = array(
            'artist' => Artist::where('id',$artist_id)->first(),
            'latest_audios' => $audios,
            'artist_audios' => $artist_audios,
            'artist_series' => $artist_series,
            'artist_videos' => $artist_videos,
            'albums' => $albums,
        );
        return Theme::view('artist', $data);
    }

}
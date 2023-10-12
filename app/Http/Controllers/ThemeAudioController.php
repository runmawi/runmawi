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
use App\ThumbnailSetting;
use App\AdminLandingPage;
use App\PaymentSetting;
use App\CategoryAudio;
use App\SiteTheme;

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

        $getfeching= Geofencing::first();
        $getfeching= Geofencing::first();
        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
        $userIp = $geoip->getip();    
        $countryName = $geoip->getCountry();

        $source_id = Audio::where('slug',$slug)->pluck('id')->first();

        $category_name = CategoryAudio::select('audio_categories.name as categories_name','audio_categories.slug as categories_slug','category_audios.audio_id')
        ->Join('audio_categories', 'category_audios.category_id', '=', 'audio_categories.id')
        ->where('category_audios.audio_id', $source_id)
        ->get();


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
            //   echo "<pre>";dd($albumID);exit();

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
                'error' =>'error',
                'json_list' => null ,
                'audios'  => null ,
                'ablum_audios' =>  null,
                'source_id'   => $source_id,    
                'commentable_type' => "play_audios" ,
                'category_name'    => $category_name ,
                'ThumbnailSetting' => ThumbnailSetting::first(),

                );

                return Theme::view('audio', $data);
            }
            
            
        }
      
            if (!empty($audio_details)) {
                // $ppv_status = PpvPurchase::with('audio')->where('audio_id','=',$audio)->where('user_id','=',Auth::user()->id)->where('to_time', '>', Carbon::now())->count();

                $ppv_status = PpvPurchase::with('audio')->where('audio_id','=',$audio)->where('user_id','=',Auth::user()->id)->count();

                // dd($ppv_status);

                $view_increment = $this->handleViewCount($audio); 

                $current_audio   = Audio::where('album_id',$albumID)->where('id',$audio)->get();
                $all_album_audios = Audio::where('album_id',$albumID)->get();

                $merged_audios = $current_audio->merge($all_album_audios)->all();

                $current_audio_lyrics   = Audio::where('album_id',$albumID)->where('id',$audio)->get()->map(function ($item) {
                    $item['author']      = $item->slug ;
                    $item['song']      = $item->title ;
                    $item['audio']      = $item->mp3_url ;
                    $item['json']      =   $item->lyrics_json ;
                    $item['albumart']      = URL::to('public/uploads/images/'.$item->image );
                    $item['image_url']      = URL::to('public/uploads/images/'.$item->image );
                    $item['player_image']   = URL::to('public/uploads/images/'.$item->player_image );
                    $LikeDislike            = LikeDislike::where('audio_id',$item->id)->first();
                    if(!Auth::guest()){
                        $item['PpvPurchase_Status'] = PpvPurchase::where('audio_id','=',$item->id)->where('user_id','=',Auth::user()->id)->count();
                        $item['role'] = Auth::user()->role;
                    }else{
                        $item['PpvPurchase_Status'] = 0;
                        $item['role'] = '';
                    }
                    if(!empty($LikeDislike) && $LikeDislike->liked == 1){
                        $item['liked'] = 1;
                        $item['disliked'] = 0;
                    }else if(!empty($LikeDislike) && $LikeDislike->disliked == 1){
                        $item['liked'] = 0;
                        $item['disliked'] = 1;
                    }else{
                        $item['liked'] = 0;
                        $item['disliked'] = 0;
                    }

                    $castcrew = Audioartist::where('audio_id',@$item->id)
                    ->Join('artists','artists.id','=','audio_artists.artist_id')->pluck('artists.artist_name');
                        $item['castcrew']   =   $castcrew;
                        if(count($castcrew) > 0){
                            foreach($castcrew as $cast_crew){
                                $item['cast_crew']   =   $cast_crew. ' ' ;
                            }
                        }else{
                            $item['cast_crew']   = '';
                        }
                    if($item->lyrics_json == null){
                        $item['countjson']      =  0 ;
                    }else{
                        $item['countjson']      =   1 ;
                    }
                return $item;
                });
                // dd($current_audio_lyrics);

                $all_album_audio_lyrics = Audio::where('album_id',$albumID)->where('id','!=',$audio)->get()->map(function ($item) {
                    $item['author']      = $item->slug ;
                    $item['song']      = $item->title ;
                    $item['audio']      = $item->mp3_url ;
                    $item['json']      =   $item->lyrics_json ;
                    $item['albumart']      = URL::to('public/uploads/images/'.$item->image );
                    $item['image_url']      = URL::to('public/uploads/images/'.$item->image );
                    $item['player_image']   = URL::to('public/uploads/images/'.$item->player_image );

                    if(!Auth::guest()){
                        $item['PpvPurchase_Status'] = PpvPurchase::where('audio_id','=',$item->id)->where('user_id','=',Auth::user()->id)->count();
                        $item['role'] = Auth::user()->role;
                    }else{
                        $item['PpvPurchase_Status'] = 0;
                        $item['role'] = '';
                    }

                    if(!empty($LikeDislike) && $LikeDislike->liked == 1){
                        $item['liked'] = 1;
                        $item['disliked'] = 0;
                    }else if(!empty($LikeDislike) && $LikeDislike->disliked == 1){
                        $item['liked'] = 0;
                        $item['disliked'] = 1;
                    }else{
                        $item['liked'] = 0;
                        $item['disliked'] = 0;
                    }

                    $castcrew = Audioartist::where('audio_id',@$item->id)
                    ->Join('artists','artists.id','=','audio_artists.artist_id')->pluck('artists.artist_name');
                        $item['castcrew']   =   $castcrew;
                        if(count($castcrew) > 0){
                            foreach($castcrew as $cast_crew){
                                $item['cast_crew']   =   $cast_crew. ' ' ;
                            }
                        }else{
                            $item['cast_crew']   = '';
                        }
                    if($item->lyrics_json == null){
                        $item['countjson']      =  0 ;
                    }else{
                        $item['countjson']      =   1 ;
                    }
                    return $item;
                  });
                  $merged_audios_lyrics = $current_audio_lyrics->merge($all_album_audio_lyrics)->all();
            $json = array('title' => $audio_details->title,'mp3'=>$audio_details->mp3_url);  
                //   dd($merged_audios_lyrics);
            $data = array(
                'audios' => Audio::findOrFail($audio),
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
                'ablum_audios' =>  $merged_audios,
                'source_id'   => $source_id,
                'commentable_type' => "play_audios" ,
                'category_name'    => $category_name ,
                'ThumbnailSetting' => ThumbnailSetting::first(),
                'songs' => (array("songs" => $merged_audios_lyrics)),
                'playlist_name' => 'Related Songs',
                'OtherMusicStation' => [],
            );
            } else {
                $data = array(
                'messge' => 'No Audio Found'
                );
                
            }

            $theme_settings = SiteTheme::pluck('audio_page_checkout')->first();
            
            if($theme_settings == 1){
                return Theme::view('MusicAudioPlayer',$data);
            }else{
                return Theme::view('audio', $data);
            }
    }

    /*
     * Page That shows the latest audio list
     *
     */
    public function audios(Request $request)
    {   

        $settings = Setting::first();

        if($settings->enable_landing_page == 1 && Auth::guest()){
  
            $landing_page_slug = AdminLandingPage::where('status',1)->pluck('slug')->first() ? AdminLandingPage::where('status',1)->pluck('slug')->first() : "landing-page" ;
  
            return redirect()->route('landing_page', $landing_page_slug );
        }
        
        if(Auth::guest()):
            return Redirect::to('/login');
        endif;

        $page =$request->get('page');

        if( !empty($page) ){
            $page = $request->get('page');
        } else {
            $page = 1;
        }
        $audios_count = Audio::where('active', '=', '1')->orderBy('created_at', 'DESC')->count();

        if ($audios_count > 0) {
               // blocked Audio
               $block_Audio=BlockAudio::where('country',Country_name())->get();

               if(!$block_Audio->isEmpty()){
                  foreach($block_Audio as $blocked_Audios){
                     $blocked_Audio[]=$blocked_Audios->audio_id;
                  }
               }    
               $blocked_Audio[]='';

               $audios  =  Audio::join('audio_albums', 'audio.album_id', '=', 'audio_albums.id')
               ->where('audio.active', '=', '1')->orderBy('audio.created_at', 'DESC')
               ->select('audio_albums.slug as albumslug' , 'audio.*');

                if(Geofencing() !=null && Geofencing()->geofencing == 'ON'){
                      $audios = $audios->whereNotIn('audio.id',$blocked_Audio);
                }

                $audios = $audios->get();      
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
        $cat = AudioCategory::where('id', '=', $getID)->first();
        
        $parent_cat = AudioCategory::where('parent_id', '=', $cat->id)->first();
       
        $albums = AudioAlbums::where('parent_id','=',$getID)->orderBy('created_at', 'DESC')->get();
        
        
        
        
        if(!empty($parent_cat->id)){
            $parent_cat2 = AudioCategory::where('parent_id', '=', $parent_cat->id)->first();
            if(!empty($parent_cat2->id)){
                $audios = Audio::where('active', '=', '1')->where('audio_category_id', '=', $cat->id)->orWhere('audio_category_id', '=', $parent_cat->id)->orWhere('audio_category_id', '=', $parent_cat2->id)->orderBy('created_at', 'DESC')->simplePaginate(9);
            } else {
                $audios = Audio::where('active', '=', '1')->where('audio_category_id', '=', $cat->id)->orWhere('audio_category_id', '=', $parent_cat->id)->orderBy('created_at', 'DESC')->simplePaginate(9);
            }
        } else {
            $audios = Audio::where('active', '=', '1')->where('audio_category_id', '=', $cat->id)->orderBy('created_at', 'DESC')->simplePaginate(9);
        }


        $data = array(
            'audios_category' => $audios,
            'current_page' => $page,
            'albums'=>$albums,
            'category' => $cat,
            'page_title' => 'Audios - ' . $cat->name,
            'page_description' => 'Page ' . $page,
            'pagination_url' => '/audios/category/' . $slug,
            'menu' => Menu::orderBy('order', 'ASC')->get(),
            'audio_categories' => AudioCategory::all(),
            'theme_settings' => ThemeHelper::getThemeSettings(),
            'pages' => Page::where('active', '=', 1)->get(),
        );

        return View::make('audio-list', $data);
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
            return View::view('Theme::audio', $data);

        } else {
            return Redirect::to('audios')->with(array('note' => 'Sorry, this audio is no longer active.', 'note_type' => 'error'));
        }
    }
    
    public function album($album_slug) {
        
       
        if(Auth::guest()):
            return Redirect::to('/login');
        endif;

          $audioppv = PpvPurchase::where('user_id',Auth::user()->id)->where('status','active')
            ->groupby("audio_id")
            ->orderBy('created_at', 'desc')->get();
        // dd($countaudioppv);
        $getfeching= Geofencing::first();
        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
        $userIp = $geoip->getip();    
        $countryName = $geoip->getCountry();

        try {
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

                
                $current_audio_lyrics   = Audio::where('album_id',$album_id);
                
                if($getfeching !=null && $getfeching->geofencing == 'ON'){
                     $current_audio_lyrics = $current_audio_lyrics->whereNotIn('id',$blocked_Audio);
              }

              $current_audio_lyrics = $current_audio_lyrics->get()->map(function ($item) {
                    $item['author']      = $item->slug ;
                    $item['song']      = $item->title ;
                    $item['audio']      = $item->mp3_url ;
                    $item['json']      =   $item->lyrics_json ;
                    $item['albumart']      = URL::to('public/uploads/images/'.$item->image );
                    $item['image_url']      = URL::to('public/uploads/images/'.$item->image );
                    $item['player_image']   = URL::to('public/uploads/images/'.$item->player_image );
                    if(!Auth::guest()){
                        $item['PpvPurchase_Status'] = PpvPurchase::where('audio_id','=',$item->id)->where('user_id','=',Auth::user()->id)->count();
                        $item['role'] = Auth::user()->role;
                    }else{
                        $item['PpvPurchase_Status'] = 0;
                        $item['role'] = '';
                    }
                    $castcrew = Audioartist::where('audio_id',@$item->id)
                    ->Join('artists','artists.id','=','audio_artists.artist_id')->pluck('artists.artist_name');
                        $item['castcrew']   =   $castcrew;
                        if(count($castcrew) > 0){
                            foreach($castcrew as $cast_crew){
                                $item['cast_crew']   =   $cast_crew. ' ' ;
                            }
                        }else{
                            $item['cast_crew']   = '';
                        }
                    if($item->lyrics_json == null){
                        $item['countjson']      =  0 ;
                    }else{
                        $item['countjson']      =   1 ;
                    }
                return $item;
                });


                $all_album_audio_lyrics = Audio::where('album_id',$album_id);
                
                if($getfeching !=null && $getfeching->geofencing == 'ON'){
                    $all_album_audio_lyrics = $all_album_audio_lyrics->whereNotIn('id',$blocked_Audio);
                }

                $all_album_audio_lyrics = $all_album_audio_lyrics->get()->map(function ($item) {
                    $item['author']      = $item->slug ;
                    $item['song']      = $item->title ;
                    $item['audio']      = $item->mp3_url ;
                    $item['json']      =   $item->lyrics_json ;
                    $item['albumart']      = URL::to('public/uploads/images/'.$item->image );
                    $item['image_url']      = URL::to('public/uploads/images/'.$item->image );
                    $item['player_image']   = URL::to('public/uploads/images/'.$item->player_image );
                    if(!Auth::guest()){
                        $item['PpvPurchase_Status'] = PpvPurchase::where('audio_id','=',$item->id)->where('user_id','=',Auth::user()->id)->count();
                        $item['role'] = Auth::user()->role;
                    }else{
                        $item['PpvPurchase_Status'] = 0;
                        $item['role'] = '';
                    }
                    $castcrew = Audioartist::where('audio_id',@$item->id)
                    ->Join('artists','artists.id','=','audio_artists.artist_id')->pluck('artists.artist_name');
                        $item['castcrew']   =   $castcrew;
                        if(count($castcrew) > 0){
                            foreach($castcrew as $cast_crew){
                                $item['cast_crew']   =   $cast_crew. ' ' ;
                            }
                        }else{
                            $item['cast_crew']   = '';
                        }
                    if($item->lyrics_json == null){
                        $item['countjson']      =  0 ;
                    }else{
                        $item['countjson']      =   1 ;
                    }
                    return $item;
                  });
                  $merged_audios_lyrics = $all_album_audio_lyrics->merge($current_audio_lyrics)->all();

            $other_albums = AudioAlbums::where('id','!=', $album_id)->get();

            if( count($album_audios) > 0 ){
                foreach ($album_audios as $key => $album_audio) {
                    $json[] = array('title' => $album_audio->title,'mp3'=>$album_audio->mp3_url);
                }
            }else{
                $json[] = array('title' => null, 'mp3'   => null);
            }
            $first_album_access = $album_audios->first() ? $album_audios->first()->access : null ;

            // dd($first_album_access);
            if(!Auth::guest()){
                if($first_album_access == 'ppv' ){
                    $ppv_status = PpvPurchase::where('user_id',Auth::user()->id)->where('audio_id',$album_audios->first() ? $album_audios->first()->id : null)->count() ;
                }else{
                    $ppv_status = 0 ;
                }
            }else{
                $ppv_status = 0 ;
            }
            // dd($ppv_status);
            $data = array(
                'audioppv' => $audioppv,
                'album' => $album,
                'json_list' => json_encode($json),
                'media_url' => URL::to('/').'/album/'.$album_slug,
                'album_audios' => $album_audios,
                'other_albums' => $other_albums,
                'first_album_mp3_url' => $album_audios->first() ? $album_audios->first()->mp3_url : null ,
                'first_album_title' => $album_audios->first() ? $album_audios->first()->title : null ,
                'first_audio_image' => $album_audios->first() ? $album_audios->first()->image : null ,
                'first_album_access' => $album_audios->first() ? $album_audios->first()->access : null ,
                'ppv_status' => $ppv_status ,
                'first_album_id' => $album_audios->first() ? $album_audios->first()->id : null ,
                'first_album_ppv_price' => $album_audios->first() ? $album_audios->first()->ppv_price : null ,
                'Paystack_payment_settings' => PaymentSetting::where('payment_type', 'Paystack')->first(),
                'Razorpay_payment_settings' => PaymentSetting::where('payment_type', 'Razorpay')->first(),
                'CinetPay_payment_settings' => PaymentSetting::where('payment_type', 'CinetPay')->first(),
                'role' =>  (!Auth::guest()) ?  Auth::User()->role : null ,
                'songs' => (array("songs" => $merged_audios_lyrics)),
                'playlist_name' => 'Related Album Songs',
                'OtherMusicStation' => [],
            );
            
            // dd( $data);
            $theme_settings = SiteTheme::pluck('audio_page_checkout')->first();
            
            if($theme_settings == 1){
                return Theme::view('MusicAudioPlayer',$data);
            }else{
                return Theme::view('albums', $data);
            }
            // return Theme::view('albums', $data);

        } catch (\Throwable $th) {
            return $th->getMessage();
                return  abort(404);;       
        }
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
    
     public function artist($artist_slug) {
       
        //  if(Auth::guest()):
        //     return Redirect::to('/login');
        // endif;

        try {
            $artist_id = Artist::where('artist_slug',$artist_slug)->pluck('id')->first();

            $audios = $album_ids = array();
           
            $latest_audios = Audioartist::select('audio_id')->where('artist_id',$artist_id)->get()->toArray();
    
            foreach ($latest_audios as $key => $latest_audio) {
                
                $audio_id = $latest_audio['audio_id'];
               
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
          
            if(Auth::User() != null ){
                $artist_following = DB::table('artist_favourites')->where('artist_id',$artist_id)->where('user_id',Auth::User()->id)->where('following',1)->count();

            }else{
                $artist_following = 0;

            }
           
            $data = array(
                'artist' => Artist::where('id',$artist_id)->first(),
                'latest_audios' => $audios,
                'artist_audios' => $artist_audios,
                'artist_series' => $artist_series,
                'artist_videos' => $artist_videos,
                'albums' => $albums,
                'artist_following' => $artist_following,
            );
            return Theme::view('artist', $data);

        } catch (\Throwable $th) {
           
            return abort(404);
        }
      
    }

    public function ArtistFollow(Request $request) {
       
        try {
            $data = $request->all();
            $artist_id = $data['artist_id'];
            $user_id = Auth::user()->id;
            $following = $data['following'];
            $count = DB::table('artist_favourites')->where('user_id', '=',
            $user_id)->where('artist_id', '=', $artist_id)->count();
            
            if ( $count > 0 ) {
                if($following == 1){
                    DB::table('artist_favourites')->where('user_id', '=',
                    $user_id)->where('artist_id', '=', $artist_id)->update(['following'=>$following]);

                    $response = array(
                        'status'=>'false',
                        'message'=>'Artist Added From Your Favorite List'
                    );
                }else{
                    DB::table('artist_favourites')->where('user_id', '=',
                    $user_id)->where('artist_id', '=', $artist_id)->delete();
                    $response = array(
                        'status'=>'false',
                        'message'=>'Artist Removed From Your Favorite List'
                    );
                }
    
            } else {
                    if($following == 1){
                        $data = array('user_id' => $user_id,'following' => $following, 'artist_id' => $artist_id );
                        DB::table('artist_favourites')->insert($data);
                        $response = array(
                            'status'=>'false',
                            'message'=>'Artist Added From Your Favorite List'
                        );
                    }
                }
        return response()->json($response, 200);

        } catch (\Throwable $th) {
           
            return abort(404);
        }
      
    }

    public function albums_list()
    {

        // if(Auth::guest()):
        //     return Redirect::to('/login');
        // endif;

        $data = array(
            'albums_list' => AudioAlbums::get(),
            'page_name'    => ucwords('albums'),
            'ThumbnailSetting' => ThumbnailSetting::first(),
        );
        
        return Theme::view('albums_list', $data);
    }

    public function album_audio_ppv(Request $request)
    {

        if(!Auth::guest()){  
            $countaudioppv = App\PpvPurchase::where('audio_id',$request->id)->where('user_id',Auth::user()->id)->count();

            return $countaudioppv;
          }else {
            return 0;
          }     
    }

    public function Audios_list()
    {
        try {
           
            $audios = Audio::where('active',1)->where('status', 1)->latest();
  
              if( Geofencing() !=null && Geofencing()->geofencing == 'ON')
              {
                $audios = $audios->whereNotIn('audio.id',Block_audios());
              }
  
            $audios = $audios->Paginate($this->audios_per_page);

            $data = [
                'audios' => $audios ,
                'ThumbnailSetting' => ThumbnailSetting ::first(),
            ];

            return Theme::view('audios_list',$data);

        } catch (\Throwable $th) {
            // return abort(404);
            return $th->getMessage();
        }
    }

    public function newplaylist($slug,$name = '')
    {

      if(Auth::guest()):
          return Redirect::to('/login');
      endif;

      $getfeching= Geofencing::first();
      $getfeching= Geofencing::first();
      $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
      $userIp = $geoip->getip();    
      $countryName = $geoip->getCountry();

      $source_id = Audio::where('slug',$slug)->pluck('id')->first();
      $category_name = CategoryAudio::select('audio_categories.id as category_id','audio_categories.name as categories_name','audio_categories.slug as categories_slug','category_audios.audio_id')
      ->Join('audio_categories', 'category_audios.category_id', '=', 'audio_categories.id')
      ->where('category_audios.audio_id', $source_id)
      ->get();

      if(count($category_name) > 0){
        foreach($category_name as $category){

            $CategoryAudio = CategoryAudio::Join('audio_categories', 'category_audios.category_id', '=', 'audio_categories.id')
                ->where('category_audios.category_id', @$category->category_id)
                ->pluck('category_audios.audio_id');
        }

      }else{
        $CategoryAudio = [];        
      }
      $related_category_Audios = Audio::whereIn('id', $CategoryAudio)->get();

      if(!Auth::guest()){
        $user_id = Auth::user()->id ;
        if(Auth::user()->support_username != null){
            $artist_id = Artist::where('artist_name',Auth::user()->support_username)->pluck('id')->first();
            
        }else{
            $artist_id = null;
        }
        if($artist_id != null ){
            $Audioartist = Audioartist::where('artist_id' ,$artist_id)->pluck('audio_id');
            if(count($Audioartist) > 0){
                    $related_Audioartist = Audio::whereIn('id', $Audioartist)->get();
              }else{
                $related_Audioartist = [];        
              }
        }else{
            $related_Audioartist = [];        
        }

      }else{
        $Audioartist = [];
        $related_Audioartist = [];
      }

      $merged_related_Audioartist = $related_category_Audios->merge($related_Audioartist)->all();


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
          //   echo "<pre>";dd($albumID);exit();

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
              'error' =>'error',
              'json_list' => null ,
              'audios'  => null ,
              'ablum_audios' =>  null,
              'source_id'   => $source_id,    
              'commentable_type' => "play_audios" ,
              'category_name'    => $category_name ,
              'ThumbnailSetting' => ThumbnailSetting::first(),

              );

              return Theme::view('audio', $data);
          }
          
          
      }
    
          if (!empty($audio_details)) {
              // $ppv_status = PpvPurchase::with('audio')->where('audio_id','=',$audio)->where('user_id','=',Auth::user()->id)->where('to_time', '>', Carbon::now())->count();

              $ppv_status = PpvPurchase::with('audio')->where('audio_id','=',$audio)->where('user_id','=',Auth::user()->id)->count();

              // dd($ppv_status);

              $view_increment = $this->handleViewCount($audio); 

              $current_audio   = Audio::where('album_id',$albumID)->where('id',$audio)->get();
              $all_album_audios = Audio::where('album_id',$albumID)->get();

            $merged_audios = $current_audio->merge($all_album_audios)->all();
            if(count($merged_related_Audioartist) > 0 ){
                foreach($merged_related_Audioartist as $value){
                    $liked_related_Audioartist = Audio::Join('like_dislikes', 'audio.id', '=', 'like_dislikes.audio_id')
                    ->where('like_dislikes.liked',1)->get();
                    $dislikes_related_Audio = Likedislike::where('audio_id','!=',null)->where('disliked',1)->pluck('audio_id');
                }
            }else{
                $liked_related_Audioartist = [];
                $dislikes_related_Audio = [];
            }

        if(count($dislikes_related_Audio) > 0 ){
            foreach($merged_related_Audioartist as $value){  
                foreach($dislikes_related_Audio as $value_id){
                    // $liked_related_Audioartist = Audio::where('like_dislikes.liked',1)->get();
                    if($value->id == $value_id){
                        // $mergedArrayAudios[] = '';
                    }else{
                        $mergedArrayAudios[] =  $value;
                    }
                }              
            }
        }else{
            $mergedArrayAudios = $merged_related_Audioartist;
        }
        
            // dd($mergedArrayAudios);

          $json = array('title' => $audio_details->title,'mp3'=>$audio_details->mp3_url);  
          $data = array(
              'audios' => Audio::findOrFail($audio),
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
              'ablum_audios' =>  $mergedArrayAudios,
              'source_id'   => $source_id,
              'commentable_type' => "play_audios" ,
              'category_name'    => $category_name ,
              'ThumbnailSetting' => ThumbnailSetting::first(),
              );
          } else {
              $data = array(
              'messge' => 'No Audio Found'
              );
              
          }

          return Theme::view('audio', $data);
  }

  public function MusicAudioPlayer($slug,$name = '',Request $request)
  {

    if(Auth::guest()):
        return Redirect::to('/login');
    endif;

    $getfeching= Geofencing::first();
    $getfeching= Geofencing::first();
    $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
    $userIp = $geoip->getip();    
    $countryName = $geoip->getCountry();

    $source_id = Audio::where('slug',$slug)->pluck('id')->first();

    $category_name = CategoryAudio::select('audio_categories.name as categories_name','audio_categories.slug as categories_slug','category_audios.audio_id')
    ->Join('audio_categories', 'category_audios.category_id', '=', 'audio_categories.id')
    ->where('category_audios.audio_id', $source_id)
    ->get();


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
        //   echo "<pre>";dd($albumID);exit();

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
            'error' =>'error',
            'json_list' => null ,
            'audios'  => null ,
            'ablum_audios' =>  null,
            'source_id'   => $source_id,    
            'commentable_type' => "play_audios" ,
            'category_name'    => $category_name ,
            'ThumbnailSetting' => ThumbnailSetting::first(),

            );

            return Theme::view('MusicAudioPlayer');
        }
        
        
    }
  
        if (!empty($audio_details)) {
            // $ppv_status = PpvPurchase::with('audio')->where('audio_id','=',$audio)->where('user_id','=',Auth::user()->id)->where('to_time', '>', Carbon::now())->count();

            $ppv_status = PpvPurchase::with('audio')->where('audio_id','=',$audio)->where('user_id','=',Auth::user()->id)->count();

            // dd($ppv_status);

            $view_increment = $this->handleViewCount($audio); 

            $current_audio   = Audio::where('album_id',$albumID)->get()->map(function ($item) {
                $item['image_url']      = URL::to('public/uploads/images/'.$item->image );
                $item['player_image']   = URL::to('public/uploads/images/'.$item->player_image );
            return $item;
            });
            $all_album_audios = Audio::where('album_id',$albumID)->get()->map(function ($item) {
                $item['image_url']      = URL::to('public/uploads/images/'.$item->image );
                $item['player_image']   = URL::to('public/uploads/images/'.$item->player_image );
                return $item;
              });

            $merged_audios = $current_audio->merge($all_album_audios)->all();

        $json = array('title' => $audio_details->title,'mp3'=>$audio_details->mp3_url);  
        // dd(json_encode(array("songs" => $merged_audios)));
        // dd($current_audio);
        $data = array(
            'audios' => Audio::findOrFail($audio),
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
            'ablum_audios' =>  $merged_audios,
            'source_id'   => $source_id,
            'commentable_type' => "play_audios" ,
            'category_name'    => $category_name ,
            'ThumbnailSetting' => ThumbnailSetting::first(),
            'songs' => (array("songs" => $merged_audios)),
            'OtherMusicStation' => [],
            );
        } else {
            $data = array(
            'messge' => 'No Audio Found'
            );
            
        }
        
    return Theme::view('MusicAudioPlayer',$data);
    }

}
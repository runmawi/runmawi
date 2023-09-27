<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use \Redirect as Redirect;
use App\Setting;
use App\User as User;
use App\MyPlaylist;
use App\AudioUserPlaylist;
use App\Audio as Audio;
use App\AudioAlbums as AudioAlbums;
use App\Artist as Artist;
use App\HomeSetting as HomeSetting;
use App\AudioCategory as AudioCategory;
use App\PpvPurchase as PpvPurchase;
use App\MusicStation as MusicStation;
use App\UserMusicStation as UserMusicStation;
use App\Audioartist as Audioartist;
use App\CategoryAudio as CategoryAudio;
use App\Slider as Slider;
use App\PpvVideo as PpvVideo;
use App\RecentView as RecentView;
use App\PpvCategory as PpvCategory;
use App\VerifyNumber as VerifyNumber;
use App\Subscription as Subscription;
use App\PaypalPlan as PaypalPlan;
use App\ContinueWatching as ContinueWatching;
use App\Watchlater as Watchlater;
use App\Wishlist as Wishlist;
use App\Page as Page;
use App\LikeDislike as Likedislike;
use App\Favorite as Favorite;
use App\Genre;
use App\Seriesartist;
use App\Videoartist;
use GeoIPLocation;
use Stevebauman\Location\Facades\Location;
use Carbon\Carbon as Carbon;
use Session;
use App\BlockAudio;
use App\Geofencing;
use App\ThumbnailSetting;
use App\AdminLandingPage;
use App\PaymentSetting;
use App\SiteTheme;
use Auth;
use View;
use Theme;
use URL;

class MusicStationController extends Controller
{


    public function MusicStation(Request $request){
        try {
            //code...
            if (Auth::guest())
            {
                return Redirect::to('/');

            }
          $MusicStation = MusicStation::get();
          $data = [
            'MusicStation' => $MusicStation,
        ];

        } catch (\Throwable $th) {
            throw $th;
        }
        return Theme::view('ListMusicStation', $data);
    }

    public function CreateStation(Request $request){

        try {

            $Theme = HomeSetting::pluck('theme_choosen')->first();

            Theme::uses($Theme);

            $settings = Setting::first();

            $Artist = Artist::get();

            $data = [
                'settings' => $settings,
                'Artists' => $Artist,
                'AudioCategory' => AudioCategory::get(),

            ];

        return Theme::view('CreateStation', $data);

        } catch (\Throwable $th) {
            throw $th;
        }

        return Theme::view('MyPlaylist', $data);
    }

    public function StoreStation(Request $request){

        try {

        $Setting = Setting::first();
            
        $path = URL::to('/').'/public/uploads/images/';

        $image = $request->image;

        if($image != '') {
            if($image != ''  && $image != null){
                $file_old = $path.$image;
                if (file_exists($file_old)){
                      unlink($file_old);
                }
            }
            $file = $image;
            $file->move(public_path()."/uploads/images/", $file->getClientOriginalName());
            $image  = URL::to('/').'/public/uploads/images/'.$file->getClientOriginalName();

        } else {
            $image  = URL::to('/').'/public/uploads/images/'.$Setting->default_video_image;
        }

        $station_based_artists = json_encode($request->station_based_artists);

        $artist_audios = [];

        if(!empty($request->station_based_artists) && count($request->station_based_artists) > 0){

            foreach($request->station_based_artists as $value){

                $artist_audios = Audioartist::select('audio.id')->join('audio', 'audio.id', '=', 'audio_artists.audio_id')
                ->where('artist_id',$value)->groupBy('audio_artists.audio_id')->get();

            }
            
        }

        $category_audios = [];

        if(!empty($request->station_based_keywords) && count($request->station_based_keywords) > 0){

            foreach($request->station_based_keywords as $value){

                $category_audios = CategoryAudio::select('audio.id')->join('audio', 'audio.id', '=', 'category_audios.audio_id')
                ->where('category_id',$value)->groupBy('category_audios.audio_id')->get();

            }

        }

            $MusicStation = new MusicStation();
            $MusicStation->station_name = $request->station_name;
            $MusicStation->station_slug = str_replace(" ", "-", $request->station_name);
            $MusicStation->station_type = $request->station_type;
            $MusicStation->station_based_artists = json_encode($request->station_based_artists);
            $MusicStation->station_based_keywords = json_encode($request->station_based_keywords);
            $MusicStation->image = $image;
            $MusicStation->user_id = Auth::User()->id;
            $MusicStation->save();

            $station_id = $MusicStation->id;

             if(count($artist_audios) > 0){

                foreach($artist_audios as $value){
    
                    $UserMusicStation = new UserMusicStation();
                    $UserMusicStation->user_id = Auth::User()->id;
                    $UserMusicStation->station_id = $station_id;
                    $UserMusicStation->audio_id = $value->id;
                    $UserMusicStation->save();

                }

            }

            if(count($category_audios) > 0){

                foreach($category_audios as $value){
    
                    $UserMusicStation = new UserMusicStation();
                    $UserMusicStation->user_id = Auth::User()->id;
                    $UserMusicStation->station_id = $station_id;
                    $UserMusicStation->audio_id = $value->id;
                    $UserMusicStation->save();

                }

            }

        // dd(json_decode($station_based_artists));
            
        } catch (\Throwable $th) {
            throw $th;
        }

        
        return Redirect::to('music-station/'.$MusicStation->station_slug)->with([
            "message" => "Successfully Updated Station!",
            "note_type" => "success",
        ]);
        
    }

   
    public function PlayerMusicStation($station_slug) {
        
       
        if(Auth::guest()):
            return Redirect::to('/login');
        endif;

            $audioppv = PpvPurchase::where('user_id',Auth::user()->id)->where('status','active')
                ->groupby("audio_id")
                ->orderBy('created_at', 'desc')->get();

            $getfeching= Geofencing::first();
            $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
            $userIp = $geoip->getip();    
            $countryName = $geoip->getCountry();

        try {

            $MusicStation_id = MusicStation::where('station_slug', $station_slug)->first()->id;
            $MusicStation = MusicStation::where('id', $MusicStation_id)->first();
            $UserMusicStation = UserMusicStation::where('station_id', $MusicStation_id)->pluck('audio_id');

        // blocked Audio
               $block_Audio=BlockAudio::where('country',$countryName)->get();
               if(!$block_Audio->isEmpty()){
                  foreach($block_Audio as $blocked_Audios){
                     $blocked_Audio[]=$blocked_Audios->audio_id;
                  }
               }    
               $blocked_Audio[]='';

               $album_audios  =  Audio::whereIn('id', $UserMusicStation);
                 if($getfeching !=null && $getfeching->geofencing == 'ON'){
                      $album_audios = $album_audios  ->whereNotIn('id',$blocked_Audio);
               }
                $album_audios = $album_audios ->get();
                // dd($album_audios);

                $current_audio_lyrics   = Audio::whereIn('id', $UserMusicStation);
                
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

                $merged_audios_lyrics = $current_audio_lyrics;

            $other_albums = [];

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
                'album' => $MusicStation,
                'json_list' => json_encode($json),
                'media_url' => URL::to('/'),
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
                'playlist_name' => 'Related Station Songs',
            );
            
            // dd( $data);

            $theme_settings = SiteTheme::pluck('audio_page_checkout')->first();
            
            if($theme_settings == 1){
                return Theme::view('MusicAudioPlayer',$data);
            }else{
                return Theme::view('MusicStation', $data);
            }

            // return Theme::view('MusicStation', $data);

        } catch (\Throwable $th) {
                return $th->getMessage();
                return  abort(404);;       
        }
    }

    public function DeleteStation($id){
        try {
            // dd($id);
           MusicStation::where('id',$id)->delete();
           UserMusicStation::where('station_id',$id)->delete();

        } catch (\Throwable $th) {
            throw $th;
        }
        return redirect::to('/list-music-station');
    }

    public function MY_MusicStation(Request $request){
        try {


            if (Auth::guest())
            {
                return Redirect::to('/');
            }

          $MusicStation = MusicStation::where('user_id',Auth::user()->id)->get();

            $data = [
                'MusicStation' => $MusicStation,
            ];

        } catch (\Throwable $th) {
            throw $th;
        }
        return Theme::view('ListMusicStation', $data);
    }

    
    public function AutoStoreStation(Request $request){

        try {

            $audio_id = $request->audio_id ;

            $station_based_artists = Audioartist::where('audio_id',$audio_id)->pluck('artist_id')->toArray();
            $station_based_keywords = CategoryAudio::where('audio_id',$audio_id)->pluck('category_id')->toArray();

            $Setting = Setting::first();
            
            $image  = URL::to('/').'/public/uploads/images/'.$Setting->default_video_image;


            $artist_audios = [];

        if(count($station_based_artists) > 0){

            foreach($station_based_artists as $value){

                $artist_audios = Audioartist::select('audio.id')->join('audio', 'audio.id', '=', 'audio_artists.audio_id')
                ->where('artist_id',$value)->groupBy('audio_artists.audio_id')->get();

            }
            
        }

        $category_audios = [];

        if(count($station_based_keywords) > 0){

            foreach($station_based_keywords as $value){

                $category_audios = CategoryAudio::select('audio.id')->join('audio', 'audio.id', '=', 'category_audios.audio_id')
                ->where('category_id',$value)->groupBy('category_audios.audio_id')->get();

            }

        }
        $station_name = Audio::where('id',$audio_id)->pluck('title')->first();

            $MusicStation = new MusicStation();
            $MusicStation->station_name = $request->station_name;
            $MusicStation->station_slug = str_replace(" ", "-", $request->station_name);
            $MusicStation->station_type = 'both';
            $MusicStation->station_based_artists = json_encode($station_based_artists);
            $MusicStation->station_based_keywords = json_encode($station_based_keywords);
            $MusicStation->image = $image;
            $MusicStation->user_id = Auth::User()->id;
            $MusicStation->save();

            $station_id = $MusicStation->id;

             if(count($artist_audios) > 0){

                foreach($artist_audios as $value){
    
                    $UserMusicStation = new UserMusicStation();
                    $UserMusicStation->user_id = Auth::User()->id;
                    $UserMusicStation->station_id = $station_id;
                    $UserMusicStation->audio_id = $value->id;
                    $UserMusicStation->save();

                }

            }

            if(count($category_audios) > 0){

                foreach($category_audios as $value){
    
                    $UserMusicStation = new UserMusicStation();
                    $UserMusicStation->user_id = Auth::User()->id;
                    $UserMusicStation->station_id = $station_id;
                    $UserMusicStation->audio_id = $value->id;
                    $UserMusicStation->save();

                }

            }

            return 1;

        } catch (\Throwable $th) {
            // throw $th;
            return 0 ;
        }
        
    }

   

}
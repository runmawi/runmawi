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
use App\Audioartist as Audioartist;
use App\SiteTheme as SiteTheme;
use Auth;
use View;
use Theme;
use URL;

class MyPlaylistController extends Controller
{

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

    
    public function CreatePlaylist(Request $request){

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

        return Theme::view('CreatePlaylist', $data);

        } catch (\Throwable $th) {
            throw $th;
        }

        return Theme::view('CreatePlaylist', $data);
    }

    public function MyPlaylist(Request $request){
        try {
            //code...
          $MyPlaylist = MyPlaylist::where('user_id',Auth::user()->id)->get();
          $data = [
            'MyPlaylist' => $MyPlaylist,
        ];

        } catch (\Throwable $th) {
            //throw $th;
            $data = [];
        }
        return Theme::view('MyPlaylist', $data);
    }

    public function StorePlaylist(Request $request){

        try {
            //code...
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


             $MyPlaylist = new MyPlaylist();
             $MyPlaylist->title = $request->title;
             $MyPlaylist->slug = str_replace(" ", "-", $request->title);
             $MyPlaylist->image = $image;
             $MyPlaylist->user_id = Auth::User()->id;
             $MyPlaylist->save();
        } catch (\Throwable $th) {
            //throw $th;
        }

        return Redirect::to('playlist/'.$MyPlaylist->slug)->with([
            "message" => "Successfully Updated Video!",
            "note_type" => "success",
        ]);
        
    }

    public function Audio_Playlist($slug){
        try {
            //code...
            if (Auth::guest()) {
                return redirect("/login");
            }
          $MyPlaylist = MyPlaylist::where('user_id',Auth::user()->id)->get();
          $MyPlaylist_id = MyPlaylist::where('slug', $slug)->first()->id;
          $MyPlaylist = MyPlaylist::where('id', $MyPlaylist_id)->first();
          $AudioUserPlaylist = AudioUserPlaylist::where('user_id',Auth::user()->id)->where('playlist_id',$MyPlaylist_id)->get();
          $excludedAudioIds = AudioUserPlaylist::where('user_id', Auth::user()->id)
            ->where('playlist_id', $MyPlaylist_id)
            ->pluck('audio_id');


        if(count($AudioUserPlaylist) > 0 ){

            $All_Audios = Audio::select('audio.*', 'audio_albums.albumname')
            ->join('audio_albums', 'audio_albums.id', '=', 'audio.album_id')
            ->whereNotIn('audio.id', $excludedAudioIds)
            ->orderBy('audio.created_at', 'desc')
            ->get();

        }else{

            $All_Audios = Audio::Select('audio.*','audio_albums.albumname')->Join('audio_albums','audio_albums.id','=','audio.album_id')
            ->orderBy('audio.created_at', 'desc')->get();
        }

          $playlist_audio =
           Audio::Join('audio_user_playlist','audio_user_playlist.audio_id','=','audio.id')
          ->where('audio_user_playlist.user_id',Auth::user()->id)
          ->orderBy('audio_user_playlist.created_at', 'desc')->get() ;
        //   dd($All_Audios);

        $audioppv = PpvPurchase::where('user_id',Auth::user()->id)->where('status','active')
        ->groupby("audio_id")
        ->orderBy('created_at', 'desc')->get();
        
          $data = [
            'audioppv' => $audioppv,
            'MyPlaylist' => $MyPlaylist,
            'All_Audios' => $All_Audios,
            'playlist_audio' => $playlist_audio,
            'media_url' => URL::to('/').'/playlist/'.$slug,
            'role' =>  (!Auth::guest()) ?  Auth::User()->role : null ,
            'first_album_mp3_url' => $MyPlaylist->first() ? $MyPlaylist->first()->mp3_url : null ,
            'first_album_title' => $MyPlaylist->first() ? $MyPlaylist->first()->title : null ,
            'OtherMusicStation' => [],
        ];
    
        // dd($data);

        } catch (\Throwable $th) {
            throw $th;
            $data = [];
        }
        // dd($data);

        return Theme::view('Playlist', $data);
    }

    public function Add_Audio_Playlist(Request $request) {
        try {
            $AudioUserPlaylist = AudioUserPlaylist::where('audio_id', $request->audioid)
                ->where('playlist_id', $request->playlistid)
                ->where('user_id', Auth::user()->id)
                ->first();
    
            if (empty($AudioUserPlaylist)) {
                $AudioUserPlaylist = new AudioUserPlaylist();
                $AudioUserPlaylist->audio_id = $request->audioid;
                $AudioUserPlaylist->playlist_id = $request->playlistid;
                $AudioUserPlaylist->user_id = Auth::user()->id;
                $AudioUserPlaylist->save();
                $data = 1; 
            } else {
                AudioUserPlaylist::where('audio_id', $request->audioid)
                    ->where('playlist_id', $request->playlistid)
                    ->where('user_id', Auth::user()->id)
                    ->delete();
                $data = 0;
            }
        } catch (\Throwable $th) {
            \Log::error('Error in Add_Audio_Playlist: ' . $th->getMessage()); 
            $data = 0;
        }
    
        return response()->json(['status' => $data]); 
    }
    

    
    public function GetMY_Audio_Playlist($slug){
        try {

          $playlist_audio = Audio::Join('audio_user_playlist','audio_user_playlist.audio_id','=','audio.id')
          ->where('audio_user_playlist.user_id',Auth::user()->id)
          ->orderBy('audio_user_playlist.created_at', 'desc')->get() ;

        } catch (\Throwable $th) {
            //throw $th;
            $data = [];
        }
        return $playlist_audio;
    }
    
    public function Play_Playlist($slug){
        try {
            //code...
          $MyPlaylist = MyPlaylist::where('user_id',Auth::user()->id)->get();
          $MyPlaylist_id = MyPlaylist::where('slug', $slug)->first()->id;
          $MyPlaylist = MyPlaylist::where('id', $MyPlaylist_id)->first();
          $All_Audios = Audio::get();
          $playlist_audio = Audio::Select('audio.title as name','audio.mp3_url as file','audio.*')->Join('audio_user_playlist','audio_user_playlist.audio_id','=','audio.id')
          ->where('audio_user_playlist.user_id',Auth::user()->id)
          ->where('audio_user_playlist.playlist_id',$MyPlaylist_id)
          ->orderBy('audio_user_playlist.created_at', 'desc')->get() ;

          $merged_audios_lyrics = Audio::Join('audio_user_playlist','audio_user_playlist.audio_id','=','audio.id')
          ->where('audio_user_playlist.user_id',Auth::user()->id)
          ->where('audio_user_playlist.playlist_id',$MyPlaylist_id)
          ->orderBy('audio_user_playlist.created_at', 'desc')->get()->map(function ($item) {
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
            
            $artistscrew[] = Audioartist::where('audio_id',@$item->id)
            ->Join('artists','artists.id','=','audio_artists.artist_id')->get();
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
            $item['artistscrew']   =   $artistscrew;
            return $item;
          }) ;

        //   dd($merged_audios_lyrics);

        $audioppv = PpvPurchase::where('user_id',Auth::user()->id)->where('status','active')
        ->groupby("audio_id")
        ->orderBy('created_at', 'desc')->get();

            $AudioUserPlaylist = AudioUserPlaylist::where('user_id',Auth::user()->id)->where('playlist_id',$MyPlaylist_id)->get();
            $playlistAudioIds = AudioUserPlaylist::where('user_id', Auth::user()->id)
            ->where('playlist_id', $MyPlaylist_id)
            ->pluck('audio_id');


            if(count($AudioUserPlaylist) > 0 ){

                $All_Playlist_Audios = Audio::select('audio.*', 'audio_albums.albumname')
                ->join('audio_albums', 'audio_albums.id', '=', 'audio.album_id')
                ->whereIn('audio.id', $playlistAudioIds)
                ->orderBy('audio.created_at', 'desc')
                ->get();
            }else{
                $All_Playlist_Audios = [];
            }

            if(count($merged_audios_lyrics) > 0){
                $first_album_image = @$merged_audios_lyrics[0]->image;
            }else{
                $first_album_image = null;
            }

            // dd($All_Playlist_Audios);
          $data = [
            'audioppv' => $audioppv,
            'MyPlaylist' => $MyPlaylist,
            'All_Playlist_Audios' => $All_Playlist_Audios,
            'All_Audios' => $All_Audios,
            'playlist_audio' => $playlist_audio,
            'media_url' => URL::to('/').'/playlist/'.$slug,
            'role' =>  (!Auth::guest()) ?  Auth::User()->role : null ,
            'first_album_mp3_url' => $MyPlaylist->first() ? $MyPlaylist->first()->mp3_url : null ,
            'first_album_title' => $MyPlaylist->first() ? $MyPlaylist->first()->title : null ,
            'songs' => (array("songs" => $merged_audios_lyrics)),
            'playlist_name' => 'Related Songs From PlayList',
            'OtherMusicStation' => [],
            'first_album_image' => $first_album_image ,
            'recommended_audios' => [] ,
            'OtherMusicStation' => [] ,
            'Otheralbum'        => [],
            'Otherplaylist'        => MyPlaylist::where('id','!=', $MyPlaylist_id)->get(),
        ];

        } catch (\Throwable $th) {
            throw $th;
            $data = [];
        }
        // return Theme::view('PlayPlayList', $data);
        $theme_settings = SiteTheme::pluck('audio_page_checkout')->first();
            
        if($theme_settings == 1){
            return Theme::view('MusicAudioPlayer',$data);
        }else{
            return Theme::view('PlayPlayList', $data);
        }
    }
    public function Delete_Playlist($id){
        try {
            // dd($id);
            $MyPlaylist = MyPlaylist::where('user_id',Auth::user()->id)->get();
            AudioUserPlaylist::where('user_id',Auth::user()->id)->where('playlist_id',$id)->delete();
            $MyPlaylist = MyPlaylist::where('user_id',Auth::user()->id)->where('id', $id)->delete();
        } catch (\Throwable $th) {
            throw $th;
            $data = [];
        }
        return Redirect::to('/home')->with([
            "message" => "Successfully Updated Video!",
            "note_type" => "success",
        ]);
    }

}
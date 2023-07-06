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
          $All_Audios = Audio::Select('audio.*','audio_albums.albumname')
          ->Join('audio_albums','audio_albums.id','=','audio.album_id')
          ->Join('audio_user_playlist','audio_user_playlist.audio_id','=','audio.id')
          ->where('audio_user_playlist.audio_id', '=','audio.id')
          ->where('audio_user_playlist.playlist_id', $MyPlaylist_id)
          ->orderBy('audio.created_at', 'desc')->get();
          dd($All_Audios);

          $playlist_audio = Audio::Join('audio_user_playlist','audio_user_playlist.audio_id','=','audio.id')
          ->where('audio_user_playlist.user_id',Auth::user()->id)
          ->orderBy('audio_user_playlist.created_at', 'desc')->get() ;

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
        ];
    
        // dd($data);

        } catch (\Throwable $th) {
            throw $th;
            $data = [];
        }
        // dd($data);

        return Theme::view('Playlist', $data);
    }

    public function Add_Audio_Playlist(Request $request){
        try {
            //code...
          $AudioUserPlaylist = AudioUserPlaylist::where('audio_id',$request->audioid)->where('playlist_id',$request->playlistid)->where('user_id',Auth::user()->id)->first();
            if(empty($AudioUserPlaylist)){
                $AudioUserPlaylist = new AudioUserPlaylist();
                $AudioUserPlaylist->audio_id = $request->audioid;
                $AudioUserPlaylist->playlist_id = $request->playlistid;
                $AudioUserPlaylist->user_id = Auth::user()->id;
                $AudioUserPlaylist->save();
            }else{
                AudioUserPlaylist::where('audio_id',$request->audioid)->where('playlist_id',$request->playlistid)
                ->where('user_id',Auth::user()->id)->delete();
                // print_r('test');exit;

            }
            $data = 1;
    
        } catch (\Throwable $th) {
            //throw $th;
            AudioUserPlaylist::where('audio_id',$request->audioid)->where('playlist_id',$request->playlistid)
            ->where('user_id',Auth::user()->id)->delete();
            $data = 0;
        }
        return $data;
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
          ->orderBy('audio_user_playlist.created_at', 'desc')->get() ;
        //   dd($playlist_audio);

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
        ];

        } catch (\Throwable $th) {
            throw $th;
            $data = [];
        }
        return Theme::view('PlayPlayList', $data);
    }

}
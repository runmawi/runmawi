<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User as User;
use \Redirect as Redirect;
use URL;
use App\Video as Video;
use App\Setting as Setting;
use App\VideoCategory as VideoCategory;
use Auth;
use Hash;
use Illuminate\Support\Facades\Cache;
use Image;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use App\AdminVideoPlaylist as AdminVideoPlaylist;
use App\VideoPlaylist as VideoPlaylist;
use App\HomeSetting;
use View;
use Theme;
use App\Playerui;
use App\MoviesSubtitles;

class VideoPlaylistController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth');
        $settings = Setting::first();
        $this->videos_per_page = $settings->videos_per_page;

        $this->Theme = HomeSetting::pluck('theme_choosen')
            ->first();
        Theme::uses($this->Theme);
    }

    public function MyVideoPlaylist(){

        if(Auth::guest() ){
            return redirect('/login');
        }

          $settings = Setting::first();
          $VideoPlaylist = AdminVideoPlaylist::where('user_id',Auth::user()->id)->get();

          $data = array(
              'settings' => $settings,
              'VideoPlaylist' => $VideoPlaylist,
          );
          return Theme::view('MYVideoPlayList', $data);
      
      }
    
      public function VideoPlaylist($slug){

        if(Auth::guest() ){

            return redirect('/login');
        }
        try {

            $Theme = HomeSetting::pluck('theme_choosen')->first();
            
            Theme::uses($Theme);
    
                $settings = Setting::first();

                $AdminVideoPlaylist = AdminVideoPlaylist::where('user_id',Auth::user()->id)->where('slug',$slug)->first();

                if(!empty($AdminVideoPlaylist)){

                    $VideoPlaylist = VideoPlaylist::where("playlist_id", $AdminVideoPlaylist->id)->pluck("video_id")->toArray();
                    $subtitleVideoPlaylist = VideoPlaylist::where("playlist_id", $AdminVideoPlaylist->id)->pluck("video_id")->first();
                    // dd($AdminVideoPlaylist->id); 

                }else{

                    $VideoPlaylist = [];
                    $subtitleVideoPlaylist = [];
                }
                if(count($VideoPlaylist) > 0 ){

                    $videos = Video::whereIn("id", $VideoPlaylist)->get();
                    $first_videos = Video::whereIn("id", $VideoPlaylist)->first();

                    $subtitles_name = MoviesSubtitles::select('subtitles.language as language')
                    ->Join('subtitles', 'movies_subtitles.shortcode', '=', 'subtitles.short_code')
                    ->where('movies_subtitles.movie_id', @$first_videos->id)
                    ->get();
                    // dd($subtitles_name);

                if (count($subtitles_name) > 0) {
                    foreach ($subtitles_name as $value) {
                        $subtitlesname[] = $value->language;
                    }
                    $subtitles = implode(', ', $subtitlesname);
                } else {
                    $subtitles = [];
                    $subtitlesname = [];
                }
                $subtitle = MoviesSubtitles::where('movie_id', '=', @$subtitleVideoPlaylist)->get();

                }else{
                    $videos = [];
                    $first_videos = [];
                    $subtitles = [];

                }

                $playerui = Playerui::first();
                $data = array(
                    'settings' => $settings,
                    'all_play_list_videos' => $videos,
                    'first_videos' => $first_videos,
                    'VideoPlaylist' => $VideoPlaylist,
                    'AdminVideoPlaylist' => $AdminVideoPlaylist,
                    'playerui_settings' => $playerui,
                    'subtitles' => $subtitles,
                );
            if(!empty($first_videos)){

                return Theme::view('VideoPlayList', $data);
            }else{
                return \Redirect('/home');
            }

        } catch (\Throwable $th) {
            throw $th;
        }
       

      
      }


      public function video_playlist_play(Request $request){

        if(Auth::guest() ){

            return redirect('/login');
        }

        $first_videos = Video::where('id',$request->video_id)->first();
        
       
        $subtitle = MoviesSubtitles::where('movie_id', '=', @$subtitleVideoPlaylist)->get();

        $playerui = Playerui::first();
       
        $data = array( 'first_videos' => $first_videos ,'subtitle' => $subtitle,'playerui_settings' => $playerui);

        $theme = Theme::uses($this->Theme);

        return $theme->load('public/themes/default/views/partials/home/video_playlist', $data)->render();


    }

}

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
            $image  = $Setting->default_video_image;
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

        return Redirect::back()->with([
            "message" => "Successfully Updated Video!",
            "note_type" => "success",
        ]);
        
    }
}
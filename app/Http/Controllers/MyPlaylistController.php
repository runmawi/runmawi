<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Redirect as Redirect;
use App\Setting;
use App\User as User;
use App\MyPlaylist;
use App\AudioUserPlaylist;
use App\Audio as Audio;
use App\AudioAlbums as AudioAlbums;
use App\Artist as Artist;
use App\AudioCategory as AudioCategory;
use Auth;
use View;
use Theme;

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
}
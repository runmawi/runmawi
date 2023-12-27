<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use App\AdminEPGChannel;
use App\HomeSetting;
use App\User;
use View;
use Theme;

class EPGChannelController extends Controller
{
    public function __construct()
    {
        $this->Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses($this->Theme);
    }

    public function index(Request $request)
    {
        return Theme::view('video-js-Player.EPG.Channel-videos');
    }
}
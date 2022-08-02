<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Theme;
use App\HomeSetting;

class LandingpageController extends Controller
{

    public function __construct()
    {
        $this->Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses($this->Theme);
    }

   public function landing_page()
   {
    return Theme::view('landing.index');
   }
}

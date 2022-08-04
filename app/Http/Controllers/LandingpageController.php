<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Theme;
use App\HomeSetting;
use App\AdminLandingPage;

class LandingpageController extends Controller
{

    public function __construct()
    {
        $this->Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses($this->Theme);
    }

   public function landing_page( $landing_page_slug )
   {
        $data = [
            'title' => AdminLandingPage::where('status',1)->pluck('title')->first(),
            'sections_1' => AdminLandingPage::where('status',1)->where('section',1)->pluck('content'),
            'sections_2' => AdminLandingPage::where('status',1)->where('section',2)->pluck('content'),
            'sections_3' => AdminLandingPage::where('status',1)->where('section',3)->pluck('content'),
            'sections_4' => AdminLandingPage::where('status',1)->where('section',4)->pluck('content'),
        ];

        return Theme::view('landing.index',$data);
   }
}

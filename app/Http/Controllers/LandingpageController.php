<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Theme;
use App\HomeSetting;
use App\AdminLandingPage;
use App\SeriesCategory;
use App\VideoCategory;
use App\Video; 
use App\SeriesGenre; 

class LandingpageController extends Controller
{

    public function __construct()
    {
        $this->Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses($this->Theme);
    }

   public function landing_page( $landing_page_slug )
   {
        $first_videos_categories_id = SeriesGenre::orderBy('order')->pluck('id')->first();

        $data = [
            'title' => AdminLandingPage::where('status',1)->pluck('title')->first(),
            'sections_1' => AdminLandingPage::where('status',1)->where('section',1)->pluck('content'),
            'sections_2' => AdminLandingPage::where('status',1)->where('section',2)->pluck('content'),
            'sections_3' => AdminLandingPage::where('status',1)->where('section',3)->pluck('content'),
            'sections_4' => AdminLandingPage::where('status',1)->where('section',4)->pluck('content'),
            'custom_css' => AdminLandingPage::where('status',1)->orderBy('id','desc')->pluck('custom_css')->first(),
            'bootstrap_link'  => AdminLandingPage::where('status',1)->orderBy('id', 'desc')->pluck('bootstrap_link')->first(),
            'script_content'  => AdminLandingPage::where('status',1)->orderBy('id', 'desc')->pluck('script_content')->first(),
            'footer'  => AdminLandingPage::where('status',1)->orderBy('id', 'desc')->pluck('footer')->first(),
            'header'  => AdminLandingPage::where('status',1)->orderBy('id', 'desc')->pluck('header')->first(),
            'SeriesGenre' => SeriesGenre::orderBy('order')->get(),
            'SeriesCategory'    => SeriesGenre::find($first_videos_categories_id) != null ? SeriesGenre::find($first_videos_categories_id)->specific_category_series : array(),
            'meta_title'      => AdminLandingPage::where('status',1)->pluck('meta_title')->first(),
            'meta_keywords'      => AdminLandingPage::where('status',1)->pluck('meta_keywords')->first(),
            'meta_description'      => AdminLandingPage::where('status',1)->pluck('meta_description')->first(),

        ];
        return Theme::view('landing.index', $data);
   }

   public function landing_category_series(Request $request)
   {
        $SeriesCategory = SeriesGenre::find($request->category_id) != null ? SeriesGenre::find($request->category_id)->specific_category_series : array();

        $data = array( 'SeriesCategory' => $SeriesCategory );

        $theme = Theme::uses($this->Theme);

        return $theme->load('public/themes/theme5-nemisha/partials/landing_category_series', $data)->render();
   }
}

<?php

namespace App\Http\Controllers;
 
use App\Image;
use App\Jobs\ProcessImageThumbnails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Validator;
use App\Audio as Audio;
use App\AudioCategory as AudioCategory;
use App\AudioAlbums as AudioAlbums;
use DB;
use Session;
use \App\User as User;
use URL;
use App\Setting as Setting;
use App\HomeSetting as HomeSetting;
use Theme;
use Auth;

class HomePageAudioController extends Controller
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

    public function index(Request $request)
    {

    }

    public function AudioCategory($slug){

        $CategoryAudio =  AudioCategory::where('slug',$slug)->first();

        $AudioCategory = $CategoryAudio != null ? $CategoryAudio->specific_category_audio : array();
        
        $Audio_Category = $AudioCategory->all();

        $data = array( 'AudioCategory' => $Audio_Category , 'CategoryAudio' => $CategoryAudio);


        return Theme::view('partials.home.AudioCategory',$data);

    }

    
    public function AudiocategoryList(Request $request)
    {
        try {
            $settings = Setting::first();

            if ($settings->enable_landing_page == 1 && Auth::guest()) {
                $landing_page_slug = AdminLandingPage::where('status', 1)->pluck('slug')->first() ? AdminLandingPage::where('status', 1)->pluck('slug')->first(): 'landing-page';

                return redirect()->route('landing_page', $landing_page_slug);
            }

            $data = [
                'category_list' => AudioCategory::all(),
            ];

            return Theme::view('AudiocategoryList', $data);
        } catch (\Throwable $th) {
            return $th->getMessage();
            return abort(404);
        }
    }

}
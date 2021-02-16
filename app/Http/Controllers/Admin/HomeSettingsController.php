<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\HomeSetting as HomeSetting;
use \Redirect as Redirect;
use URL;
use Auth;
use App\Setting as Setting;
use Hash;
use Illuminate\Support\Facades\Cache;
use Image;

class HomeSettingsController extends Controller
{
    public function index(){
        $settings = HomeSetting::first();   
        $data = array(
            "settings" =>$settings 
        );
        return view('admin.settings.homepage',$data);
    }
    public function save_settings(Request $request){
        
        $settings = HomeSetting::first();
		$settings->featured_videos = $request['featured_videos'];
		$settings->latest_videos = $request['latest_videos'];
		$settings->category_videos = $request['category_videos'];
        $settings->save();
        return redirect::to('/admin/home-settings');
    }
}

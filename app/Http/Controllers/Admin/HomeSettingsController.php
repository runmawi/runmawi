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
        if(!empty($request['featured_videos'])){
            $settings->featured_videos = 1;
        } 
        if(empty($request['featured_videos'])){
            $settings->featured_videos = 0;
        } 

        if(!empty($request['latest_videos'])){
            $settings->latest_videos = 1;
        } 
        if(empty($request['latest_videos'])){
            $settings->latest_videos = 0;
        } 

        if(!empty($request['category_videos'])){
            $settings->category_videos = 1;
        } 
        if(empty($request['category_videos'])){
            $settings->category_videos = 0;
        } 
        if(!empty($request['live_videos'])){
            $settings->live_videos = 1;
        } 
        if(empty($request['live_videos'])){
            $settings->live_videos = 0;
        } 
        if(!empty($request['audios'])){
            $settings->audios = 1;
        } 
        if(empty($request['audios'])){
            $settings->audios = 0;
        } 
        if(!empty($request['albums'])){
            $settings->albums = 1;
        } 
        if(empty($request['albums'])){
            $settings->albums = 0;
        } 
        if($request->Recommendation !=null){
            $settings->Recommendation = 1;
        }else{
            $settings->Recommendation = 0;
        }

        if($request->AutoIntro_skip !=null){
            $settings->AutoIntro_skip = 1;
        }else{
            $settings->AutoIntro_skip = 0;
        }

        $settings->save();
        return redirect::to('/admin/home-settings');
    }
}

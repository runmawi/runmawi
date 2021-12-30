<?php

namespace App\Http\Controllers;

use App\ModeratorsPermission;
use App\ModeratorsRole;
use App\ModeratorsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use URL;
use App\UserAccess;
use Hash;
use Illuminate\Support\Facades\DB;
use App\Video as Video;
use App\VideoCategory as VideoCategory;
use Image;
use App\Menu as Menu;
use App\Country as Country;
use App\Slider as Slider;
use App\MoviesSubtitles as MoviesSubtitles;
use App\VideoResolution as VideoResolution;
use App\VideosSubtitle as VideosSubtitle;
use App\Language as Language;
use App\VideoLanguage as VideoLanguage;
use App\Subtitle as Subtitle;
use App\Setting as Setting;
use App\PaymentSetting as PaymentSetting;
use App\SystemSetting as SystemSetting;
use App\HomeSetting as HomeSetting;
use Illuminate\Support\Str;
use \App\MobileApp as MobileApp;
use \App\MobileSlider as MobileSlider;
use App\ThemeSetting as ThemeSetting;
use App\SiteTheme as SiteTheme;
use App\Page as Page;
use App\LiveStream as LiveStream;
use App\LiveCategory as LiveCategory;
use \App\User as User;
use Auth;
use App\Role as Role;
use App\Playerui as Playerui;
use App\Plan as Plan;
use App\PaypalPlan as PaypalPlan;
use App\Coupon as Coupon;
use App\Series as Series;
use \App\Genre as Genre;
use App\Episode as Episode;
use \App\SeriesSeason as SeriesSeason;
use App\Artist;
use App\Seriesartist;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg as FFMpeg;
use ffmpeg\FFProbe;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;
use App\Http\Requests\StoreVideoRequest;
use App\Jobs\ConvertVideoForStreaming;
use Illuminate\Contracts\Filesystem\Filesystem;
use FFMpeg\Filters\Video\VideoFilters;
use App\Videoartist;
use App\AudioCategory as AudioCategory;
use App\AudioAlbums as AudioAlbums;
use Illuminate\Support\Facades\Cache;
use App\Audio as Audio;
use File;
use App\VideoCommission as VideoCommission;
use Mail;
use App\EmailTemplate;
use App\RevenueSetting;
use Session;
use Redirect;
use App\AppSetting;

class AdminAppSettings extends Controller
{   

      public function Index()
      {
          
        // $app_settings = AppSetting::get();
        // $data = array(
        // 'app_settings' => $app_settings  ,
        // );
        // return view('admin.app_setting.index',$data);
        $app_settings = AppSetting::where('id','=',1)->first();          
           $data = array(
                     'app_settings' => $app_settings ,   
           );
          return view('admin.app_setting.edit',$data);

      }
  
  
      public function Store(Request $request)
      {
        $input = $request->all();
        // dd($input);
        if(!empty($input['status'])){
            $status = 1;
        }else{
            $status = 0;
        }
        $app_setting = new AppSetting;
        $app_setting->android_url = $input['android_url'];
        $app_setting->ios_url = $input['ios_url'];
        $app_setting->status = $status;
        $app_setting->user_id = Auth::User()->id;
        $app_setting->save();
        return Redirect::back();
   
      }
  
      public function Update(Request $request)
      {
        $input = $request->all();
        if(!empty($input['status'])){
            $status = 1;
        }else{
            $status = 0;
        }
        $id = $input['id'];
        $app_setting = AppSetting::find($id);      
        // dd($app_setting);
        $app_setting->android_url = $input['android_url'];
        $app_setting->ios_url = $input['ios_url'];
        $app_setting->status = $status;
        $app_setting->user_id = Auth::User()->id;
        $app_setting->save();
        return Redirect::back();
      }
  
  
      public function Edit($id)
      {
          
          $app_settings = AppSetting::where('id','=',$id)->first();          
           $data = array(
                     'app_settings' => $app_settings ,   
           );
          return view('admin.app_setting.edit',$data);
      }
  
  
      public function Delete($id)
      {
          
        AppSetting::destroy($id);
          
           return Redirect::back();
      }
  

}
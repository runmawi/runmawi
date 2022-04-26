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
use View;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;

class AdminRevenueSettings extends Controller
{   

      public function Index()
      {
        $user =  User::where('id',1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');
        if ($current_date > $duedate)
        {
          $client = new Client();
          $url = "https://flicknexs.com/userapi/allplans";
          $params = [
              'userid' => 0,
          ];
  
          $headers = [
              'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ'
          ];
          $response = $client->request('post', $url, [
              'json' => $params,
              'headers' => $headers,
              'verify'  => false,
          ]);
  
          $responseBody = json_decode($response->getBody());
         $settings = Setting::first();
         $data = array(
          'settings' => $settings,
          'responseBody' => $responseBody,
  );
            return View::make('admin.expired_dashboard', $data);
        }else{
        // $revenue_settings = RevenueSetting::get();
        // $data = array(
        //             'revenue_settings' => $revenue_settings  ,
        // );
        // return view('admin.revenuesettings.index',$data);
        $revenue_settings = RevenueSetting::where('id','=',1)->first();          
           $data = array(
                     'revenue_settings' => $revenue_settings ,   
           );
          return view('admin.revenuesettings.edit',$data);
        }
      }
  
  
      public function Store(Request $request)
      {
        $input = $request->all();
        $revenue_settings = new RevenueSetting;
        $revenue_settings->admin_commission = $input['admin_commission'];
        $revenue_settings->user_commission = $input['user_commission'];
        $revenue_settings->vod_admin_commission = $input['vod_admin_commission'];
        $revenue_settings->vod_user_commission = $input['vod_user_commission'];
        $revenue_settings->user_id = Auth::User()->id;
        $revenue_settings->save();
        return Redirect::back();
   
      }
  
      public function Update(Request $request)
      {
        $input = $request->all();
        $id = $input['id'];
        $revenue_settings = RevenueSetting::find($id);        
        if(empty($revenue_settings)){
          // dd($revenue_settings);
          $revenue_settings = new RevenueSetting;        
        }
        $revenue_settings->admin_commission = $input['admin_commission'];
        $revenue_settings->user_commission = $input['user_commission'];
        $revenue_settings->vod_admin_commission = $input['vod_admin_commission'];
        $revenue_settings->vod_user_commission = $input['vod_user_commission'];
        $revenue_settings->user_id = Auth::User()->id;
        $revenue_settings->save();
        return Redirect::back();
      }
  
  
      public function Edit($id)
      {
        $user =  User::where('id',1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');
        if ($current_date > $duedate)
        {
          $client = new Client();
          $url = "https://flicknexs.com/userapi/allplans";
          $params = [
              'userid' => 0,
          ];
  
          $headers = [
              'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ'
          ];
          $response = $client->request('post', $url, [
              'json' => $params,
              'headers' => $headers,
              'verify'  => false,
          ]);
  
          $responseBody = json_decode($response->getBody());
         $settings = Setting::first();
         $data = array(
          'settings' => $settings,
          'responseBody' => $responseBody,
  );
            return View::make('admin.expired_dashboard', $data);
        }else{
          $revenue_settings = RevenueSetting::where('id','=',$id)->first();          
           $data = array(
                     'revenue_settings' => $revenue_settings ,   
           );
          return view('admin.revenuesettings.edit',$data);
        }
      }
  
  
      public function Delete($id)
      {
          
        RevenueSetting::destroy($id);
          
           return Redirect::back();
      }
  

}
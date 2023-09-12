<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User as User;
use \Redirect as Redirect;
//use Request;
use URL;
use Auth;
use App\Setting as Setting;
use App\Slider as Slider;
use App\MobileSlider as MobileSlider;
use App\Language as Language;
use App\VideoLanguage as VideoLanguage;
use App\ThemeSetting as ThemeSetting;
use App\SiteTheme as SiteTheme;
use Hash;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use Intervention\Image\Filters\DemoFilter;
use View;
use DB;
use App\SystemSetting as SystemSetting;
use Session;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use Illuminate\Support\Facades\File;
use Str;
use App\TVSetting as TVSetting;
use App\Page as Page;

class AdminTvSettingsController extends Controller
{
    public function index(Request $request)
    {
        try {

            $settings = Setting::first();

            $data = array(
                'TVSetting' => TVSetting::get(),
                'Page'      => Page::get(),
                'settings'  => Setting::first(),
            );

            return View::make('admin.tv_setting.index', $data);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit(Request $request,$id)
    {
        try {

            $settings = Setting::first();

            $data = array(
                'TVSetting' => TVSetting::where('id',$id)->first(),
                'Pages'      => Page::get(),
                'settings'  => Setting::first(),
            );

            return View::make('admin.tv_setting.edit', $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function update(Request $request)
    {
        try {
       
            $settings = Setting::first();

            $input = $request->all();

            $id = $request->id;
            $TVSetting = TVSetting::find($id);

            $TVSetting->name = $request->name;
            $TVSetting->enable_id = !empty($request->enable_id) ?  1 : 0 ;
            $TVSetting->page_id = $request->page_id;
            $TVSetting->save();

            return Redirect::back()->with(['note' => 'successfully Updated', 'note_type' => 'success']);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
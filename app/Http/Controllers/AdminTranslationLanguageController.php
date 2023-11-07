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
use App\TranslationLanguage as TranslationLanguage;

class AdminTranslationLanguageController extends Controller
{
    public function index(Request $request)
    {
        try {

            $settings = Setting::first();

            $data = array(
                'TranslationLanguage' => TranslationLanguage::get(),
            );

            return View::make('admin.languages.translation.index', $data);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit(Request $request,$id)
    {
        try {

            $settings = Setting::first();

            $data = array(
                'TranslationLanguage' => TranslationLanguage::where('id',$id)->first(),
            );

            return View::make('admin.languages.translation.edit', $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

  
    public function store(Request $request)
    {
      $input = $request->all();
      $TranslationLanguage = new TranslationLanguage;
      $TranslationLanguage->name = $input['name'];
      $TranslationLanguage->code = $input['code'];
      $TranslationLanguage->status = !empty($request->status) ?  1 : 0 ;
      $TranslationLanguage->save();

      return Redirect::back();
 
    }

    public function update(Request $request)
    {
        try {
       
            $settings = Setting::first();

            $input = $request->all();
            
            $id = $request->language_id;

            $TranslationLanguage = TranslationLanguage::find($id);

            $TranslationLanguage->name = $request->name;
            $TranslationLanguage->status = !empty($request->status) ?  1 : 0 ;
            $TranslationLanguage->code = $request->code;
            $TranslationLanguage->save();

            return Redirect::back()->with(['note' => 'successfully Updated', 'note_type' => 'success']);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy($id)
    {
        
        TranslationLanguage::destroy($id);
        
         return Redirect::back();
    }

}
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Redirect;
use App\ThemeIntegration;
use App\HomeSetting;
use App\Setting;
use App\User;
use Session;
use Auth;
use DB;


class ThemeIntegrationController extends Controller
{
    public function index(){

        $Themes = ThemeIntegration::all();
        return view ('admin.Theme_Integration.index')->with('Themes', $Themes);;
    }

    public function create(Request $request){

        $Themes = $request->all();

         $theme_css = $request->css_file->getClientOriginalName();  
         $request->css_file->move(public_path('themes'), $theme_css);
  
        $files = $Themes['theme_image'];
        $format=$files->getClientOriginalExtension();
        $filename =uniqid(). time(). '.' .  $format;
        Image::make($files)->resize(300, 300)->save(base_path().'/public/uploads/settings/'.$filename );

        ThemeIntegration::create([
            'theme_images'  => $filename,
            'theme_name' => $request->theme_name,
            'theme_css'=> $theme_css,
          ]);

        return Redirect::to('admin/ThemeIntegration')->with(array('message' => 'Successfully Updated  Settings!', 'note_type' => 'success') );
    }

    public function set_theme(Request $request){

        HomeSetting::first()
       ->update([
           'theme_choosen' => $request->id,
        ]);

        return 'success';
    }
}

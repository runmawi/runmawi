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
use ZanySoft\Zip\Zip;

class ThemeIntegrationController extends Controller
{
    public function index(){

        $Themes = ThemeIntegration::all();
        return view ('admin.Theme_Integration.index')->with('Themes', $Themes);;
    }

    public function create(Request $request){

        $Themes = $request->all();

        $files_zip = $Themes['theme_zip'];

        $zip_format = $files_zip->getClientOriginalExtension();
        $zip_filename =$Themes['theme_name'].'_'.'viewfile' .'.';
        $fileName_zip = $zip_filename . $request->theme_zip->getClientOriginalExtension();  
        $request->theme_zip->move(public_path('uploads/settings/'), $fileName_zip);


        $files = $Themes['theme_image'];
        $format=$files->getClientOriginalExtension();
        $filename =$Themes['theme_name'].'_'.'theme' .'.' .  $format;
        Image::make($files)->resize(300, 300)->save(base_path().'/public/uploads/settings/'.$filename );

        ThemeIntegration::create([
            'theme_images'  => $filename,
            'theme_name' => $request->theme_name,
            'theme_css' => $fileName_zip,
          ]);

     
   // Extract a file

          $zip_folder = ThemeIntegration::latest()->first();
        
          $zip_path=base_path().'/public/uploads/settings/'.$zip_folder->theme_css;

          $zip = Zip::open($zip_path);

          $zip->extract(public_path('themes/'.$zip_folder->theme_name),$zip );


        return Redirect::to('admin/ThemeIntegration')->with(array('message' => 'Successfully Updated  Settings!', 'note_type' => 'success') );
    }

    public function set_theme(Request $request){

        $theme_name = ThemeIntegration:: where('id',$request->id)->pluck('theme_name')->first();

        HomeSetting::first()
        ->update([
           'theme_choosen' => $theme_name,
        ]);

        return 'success';
    }

    public function uniquevalidation(Request $request){

    $unique_name = ThemeIntegration::where('theme_name',$request->themename)->first();

      if( $unique_name == null){
            $message = "true";
      }
      else{
        $message = "false";
      }
      return $message;
    }

    
}

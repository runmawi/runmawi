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
use View;

class ThemeIntegrationController extends Controller
{
    public function index(){
      $user =  User::where('id',1)->first();
      $duedate = $user->package_ends;
      $current_date = date('Y-m-d');
      if ($current_date > $duedate)
      {
          $settings = Setting::first();
          $data = array(
              'settings' => $settings,    
      );
          return View::make('admin.expired_dashboard', $data);
      }else{
        $Themes = ThemeIntegration::all();
        $active_Status = HomeSetting::first();

        $data=array(
            'Themes' => $Themes,
            'active_Status' => $active_Status,
        );
        return view ('admin.Theme_Integration.index',$data);
      }
    }

    public function create(Request $request){
      $user =  User::where('id',1)->first();
      $duedate = $user->package_ends;
      $current_date = date('Y-m-d');
      if ($current_date > $duedate)
      {
          $settings = Setting::first();
          $data = array(
              'settings' => $settings,    
      );
          return View::make('admin.expired_dashboard', $data);
      }else{
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

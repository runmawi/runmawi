<?php

namespace App\Http\Controllers;

use App\Multiprofile;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\WelcomeScreen;
use App\Setting;
use App\User;
use Session;
use Auth;
use Illuminate\Support\Facades\Redirect;
use DB;

class WelcomeScreenController extends Controller
{
    public function Screen_store(Request $request)
    {
        $Welcome_Picture=$request->all();

        for($i=0;$i<count($Welcome_Picture['welcome_image']);$i++){

            $files = $Welcome_Picture['welcome_image'][$i];
            $format=$files->getClientOriginalExtension();
            $filename =uniqid(). time(). '.' .  $format;
            Image::make($files)->resize(300, 300)->save(base_path().'/public/uploads/settings/'.$filename );

            WelcomeScreen::create([
                'welcome_images'  => $filename,
              ]);
         }
         return Redirect::to('admin/mobileapp')->with(array('message' => 'Successfully Updated  Settings!', 'note_type' => 'success') );
    }
}

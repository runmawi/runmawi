<?php

namespace App\Http\Controllers;

use App\Multiprofile;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\WelcomeScreen;
use App\Setting;
use App\User;
use App\ChooseProfileScene;
use Session;
use Auth;
use Illuminate\Support\Facades\Redirect;
use DB;
use App\MobileSlider;

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
         return Redirect::to('admin/mobileapp')->with(array('message' => 'Successfully Saved Welcome Screen!', 'note_type' => 'success') );
    }

    public function edit(Request $request,$id)
    {
       
        $welcome_screen=WelcomeScreen::where('id',$id)->first();
        $allCategories = MobileSlider::all();

        $data = array(
            'admin_user' => Auth::user(),
            'welcome_screen' => $welcome_screen,
            'allCategories'=>$allCategories
          );

        return view('admin.welcome_screen.welcome_edit', $data);
    }

    public function update(Request $request,$id)
    {

        $input = $request->all();
        $welcomescreen = WelcomeScreen::find($id);  

         if($request->file('welcome_image') )
         {
            $path = public_path().'/uploads/settings/';
            $welcomescreen_image = $request['welcome_image'];
            $file = $welcomescreen_image;
            $input['welcome_image']  = $file->getClientOriginalName();
            $file->move($path, $input['welcome_image']);

            $welcomescreen->welcome_images =  $input['welcome_image'];  
         }
         $welcomescreen->save();  

       return Redirect::to('admin/mobileapp')->with(array('message' => 'Successfully updated Welcome Screen!', 'note_type' => 'success') );
    }

    public function destroy(Request $request,$id)
    {
        $Screen=WelcomeScreen::find($id)->delete();
        return Redirect::to('admin/mobileapp')->with(array('message' => 'Successfully deleted Welcome Screen!', 'note_type' => 'success') );
    }
    

    public function ChooseProfileScreen(){

        $screen=ChooseProfileScene::get();

        return view ('multiprofile.screen',compact('screen',$screen));
    }

    public function ChooseProfileScreen_store(Request $request){

        $files = $request->screen_image;
        $format=$files->getClientOriginalExtension();
        $filename =uniqid(). time(). '.' .  $format;
        Image::make($files)->resize(300, 300)->save(base_path().'/public/uploads/avatars/'.$filename );


  
        $screen=ChooseProfileScene::first();

        if($screen ==null){
            ChooseProfileScene::create([
                'choosenprofile_screen'  => $filename,
                'profile_name'  => $request->screen_name,
              ]);
        }else{
        $screen=ChooseProfileScene::first()
        ->update([
            'choosenprofile_screen' => $filename,
            'profile_name'  => $request->screen_name,
         ]);
        }
        
        return redirect('admin/ChooseProfileScreen');
    }
}

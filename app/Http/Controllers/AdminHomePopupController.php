<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Redirect;
use App\AdminHomePopup;

class AdminHomePopupController extends Controller
{
   public function index()
   {
      $data= array(
        'pop_up_content' => AdminHomePopup::first(),
      );

      return view('admin.home_popup.index',$data);
   }

   public function create(Request $request){

      $popup = AdminHomePopup::first();

         if( $popup == null){

                     // image upload
            if( $request->popup_image != null ){
               $files    = $request->popup_image ;
               $filename = time() .'_'.'pop-up' .'.' . $files->getClientOriginalExtension() ;
               Image::make($files)->save(base_path().'/public/images/'.$filename );
            }
            else{
               $filename = null;
            }

            AdminHomePopup::create([
               'popup_header'  => $request->popup_header,
               'popup_footer'  => $request->popup_footer,
               'popup_image'   => $filename,
               'popup_content' => strip_tags($request->popup_content),
            ]);
         }
         else{
                      // image upload
            if( $request->popup_image != null ){
               $files    = $request->popup_image ;
               $filename = time() .'_'.'pop-up' .'.' . $files->getClientOriginalExtension() ;
               Image::make($files)->save(base_path().'/public/images/'.$filename );
            }
            else{
               $filename = AdminHomePopup::pluck('popup_image')->first();
            }

            AdminHomePopup::first()
            ->update([
               'popup_header'  => $request->popup_header,
               'popup_footer'  => $request->popup_footer,
               'popup_image'   => $filename,
               'popup_content' => strip_tags($request->popup_content),
            ]);
         }

      return Redirect::route('homepage_popup')->with('message', 'Successfully! Updated Pop-up Page');
   }
}

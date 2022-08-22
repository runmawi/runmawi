<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Redirect as Redirect;
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

            AdminHomePopup::create([
               'popup_header'  => $request->popup_header,
               'popup_footer'  => $request->popup_footer,
               'popup_content' => $request->popup_content,
            ]);
         }
         else{

            AdminHomePopup::first()
            ->update([
               'popup_header'  => $request->popup_header,
               'popup_footer'  => $request->popup_footer,
               'popup_content' => $request->popup_content,
            ]);
         }

      return Redirect::route('homepage_popup')->with('message', 'Successfully! Updated Pop-up Page');
   }

}

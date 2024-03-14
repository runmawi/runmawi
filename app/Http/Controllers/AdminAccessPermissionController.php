<?php

namespace App\Http\Controllers;

use \Redirect as Redirect;
use Illuminate\Http\Request;
use URL;
use Auth;
use Hash;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use View;
use Validator;
use DB;
use App\AdminAccessPermission as AdminAccessPermission;



class AdminAccessPermissionController extends Controller
{

    public function Index(Request $request)
    {
        try {
            
            if (Auth::guest()){
                return Redirect::to('/');
            }

            if(!Auth::guest() && Auth::user()->plan_name == 'SuperAdmin' ){
                $AdminAccessPermission = AdminAccessPermission::first();
                return view('admin.access_permission.index',compact('AdminAccessPermission'));
            }else{
                return redirect::to('/admin');
            }
            
        } catch (\Throwable $th) {
            throw $th;
        }
       
    }

    public function Store(Request $request)
    {
        try {
            
            // dd($request->all());
            $AdminAccessPermission = AdminAccessPermission::first();
            if(empty($AdminAccessPermission)){

                AdminAccessPermission::create([
                    'Video_Channel_checkout'                    => !empty($request->Video_Channel_checkout) ? 1 : 0 ,
                    'Video_Channel_Video_Scheduler_checkout'    => !empty($request->Video_Channel_Video_Scheduler_checkout) ? 1 : 0 ,
                    'Video_Manage_Video_Playlist_checkout'      => !empty($request->Video_Manage_Video_Playlist_checkout) ? 1 : 0 ,
                    'Manage_Translate_Languages_checkout'       => !empty($request->Manage_Translate_Languages_checkout) ? 1 : 0 ,
                    'Manage_Translations_checkout'              => !empty($request->Manage_Translations_checkout) ? 1 : 0 ,
                    'Audio_Page_checkout'                       => !empty($request->Audio_Page_checkout) ? 1 : 0 ,
                    'Content_Partner_Page_checkout'             => !empty($request->Content_Partner_Page_checkout) ? 1 : 0 ,
                    'Header_Top_Position_checkout'              => !empty($request->Header_Top_Position_checkout) ? 1 : 0 ,
                    'Header_Side_Position_checkout'             => !empty($request->Header_Side_Position_checkout) ? 1 : 0 ,
                    'Extract_Images_checkout'                   => !empty($request->Extract_Images_checkout) ? 1 : 0 ,
                    'Page_Permission_checkout'                  => !empty($request->Page_Permission_checkout) ? 1 : 0 ,
                    'document_category_checkout'                => !empty($request->document_category_checkout) ? 1 : 0 ,
                    'document_upload_checkout'                  => !empty($request->document_upload_checkout) ? 1 : 0 ,
                    'document_list_checkout'                    => !empty($request->document_list_checkout) ? 1 : 0 ,
                 ]);
            }else{
                
                AdminAccessPermission::first()->update([
                    'Video_Channel_checkout'                    => !empty($request->Video_Channel_checkout) ? 1 : 0 ,
                    'Video_Channel_Video_Scheduler_checkout'    => !empty($request->Video_Channel_Video_Scheduler_checkout) ? 1 : 0 ,
                    'Video_Manage_Video_Playlist_checkout'      => !empty($request->Video_Manage_Video_Playlist_checkout) ? 1 : 0 ,
                    'Manage_Translate_Languages_checkout'       => !empty($request->Manage_Translate_Languages_checkout) ? 1 : 0 ,
                    'Manage_Translations_checkout'              => !empty($request->Manage_Translations_checkout) ? 1 : 0 ,
                    'Audio_Page_checkout'                       => !empty($request->Audio_Page_checkout) ? 1 : 0 ,
                    'Content_Partner_Page_checkout'             => !empty($request->Content_Partner_Page_checkout) ? 1 : 0 ,
                    'Header_Top_Position_checkout'              => !empty($request->Header_Top_Position_checkout) ? 1 : 0 ,
                    'Header_Side_Position_checkout'             => !empty($request->Header_Side_Position_checkout) ? 1 : 0 ,
                    'Extract_Images_checkout'                   => !empty($request->Extract_Images_checkout) ? 1 : 0 ,
                    'Page_Permission_checkout'                  => !empty($request->Page_Permission_checkout) ? 1 : 0 ,
                    'document_category_checkout'                => !empty($request->document_category_checkout) ? 1 : 0 ,
                    'document_upload_checkout'                  => !empty($request->document_upload_checkout) ? 1 : 0 ,
                    'document_list_checkout'                    => !empty($request->document_list_checkout) ? 1 : 0 ,
                ]);
            }


            return redirect::to('/admin/access-premission');

        } catch (\Throwable $th) {
            throw $th;
        }
       
    }

}
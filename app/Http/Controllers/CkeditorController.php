<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CkeditorController extends Controller
{
    public function upload(Request $request)
    {
        if($request->hasFile('upload')) {
            
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = 'Pages-'.time().'.'.$extension;
           
            $request->file('upload')->move(public_path('uploads/Pages'), $fileName);
      
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('public/uploads/Pages/'.$fileName); 
            $msg = 'Image uploaded successfully'; 
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
                  
            @header('Content-type: text/html; charset=utf-8'); 
            echo $response;
        }
    }
    
}

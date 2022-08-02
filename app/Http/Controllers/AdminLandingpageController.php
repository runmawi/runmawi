<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AdminLandingPage;
use \Redirect as Redirect;


class AdminLandingpageController extends Controller
{

    public function create_edit(Request $request)
    {

        $data = [
            'section_1' =>  AdminLandingPage::where('section',1)->get(),
            'section_2' =>  AdminLandingPage::where('section',2)->get(),
            'section_3' =>  AdminLandingPage::where('section',3)->get(),
            'section_4' =>  AdminLandingPage::where('section',4)->get(),
        ];

        return view('admin.Landing_page.create_edit',$data);
    }

    public function store(Request $request)
    {
        AdminLandingPage::truncate();


        if($request->section_1  != null ){

            $section_1 = count($request['section_1']);
    
            for ($i=0; $i<$section_1; $i++){
                    $AdminLandingPage = new AdminLandingPage;
                    $AdminLandingPage->content = $request['section_1'][$i];
                    $AdminLandingPage->section = "1";
                    $AdminLandingPage->save();
            }
          }
    
          if($request->section_2  != null  ){
    
            $section_2 = count($request['section_2']);
    
            for ($i=0; $i<$section_2; $i++){
                    $AdminLandingPage = new AdminLandingPage;
                    $AdminLandingPage->content = $request['section_2'][$i];
                    $AdminLandingPage->section = "2";
                    $AdminLandingPage->save();
            }
          }
    
          if($request->section_3  != null ){
    
            $section_3 = count($request['section_3']);
    
            for ($i=0; $i<$section_3; $i++){
                    $AdminLandingPage = new AdminLandingPage;
                    $AdminLandingPage->content = $request['section_3'][$i];
                    $AdminLandingPage->section = "3";
                    $AdminLandingPage->save();
            }
          }

          if($request->section_4  != null ){
    
            $section_4 = count($request['section_4']);
    
            for ($i=0; $i<$section_4; $i++){
                    $AdminLandingPage = new AdminLandingPage;
                    $AdminLandingPage->content = $request['section_4'][$i];
                    $AdminLandingPage->section = "4";
                    $AdminLandingPage->save();
            }
          }

        return Redirect::back()->with('message', 'Successfully! Created Landing Page');
    }

    public function update(Request $request)
    {
        AdminLandingPage::first()->update([
            'content_1' => $request->content_1 ,
            'content_2' => $request->content_2 ,
            'content_3' => $request->content_3 ,
            'content_4' => $request->content_4 ,
        ]);


        return Redirect::back()->with('message', 'Successfully! Updated Landing Page');
    }
}

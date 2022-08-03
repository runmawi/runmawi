<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AdminLandingPage;
use \Redirect as Redirect;


class AdminLandingpageController extends Controller
{

    public function index(Request $request)
    {

      $data= array(
        'landing_pages' => AdminLandingPage::groupBy('landing_page_id')->get(),
      );
      return view('admin.Landing_page.index',$data);
    }

    public function create(Request $request)
    {
      return view('admin.Landing_page.create');
    }
  
    public function store(Request $request)
    {

        $landing_page_id = AdminLandingPage::max('landing_page_id') + 1 ;

        if($request->section_1  != null ){

            $section_1 = count($request['section_1']);
    
            for ($i=0; $i<$section_1; $i++){
                    $AdminLandingPage = new AdminLandingPage;
                    $AdminLandingPage->content = $request['section_1'][$i];
                    $AdminLandingPage->section = "1";
                    $AdminLandingPage->landing_page_id = $landing_page_id;
                    $AdminLandingPage->title = $request->title;
                    $AdminLandingPage->slug =  $request->slug;
                    $AdminLandingPage->save();
            }
          }
    
          if($request->section_2  != null  ){
    
            $section_2 = count($request['section_2']);
    
            for ($i=0; $i<$section_2; $i++){
                    $AdminLandingPage = new AdminLandingPage;
                    $AdminLandingPage->content = $request['section_2'][$i];
                    $AdminLandingPage->section = "2";
                    $AdminLandingPage->landing_page_id = $landing_page_id;
                    $AdminLandingPage->title = $request->title;
                    $AdminLandingPage->slug =  $request->slug;
                    $AdminLandingPage->save();
            }
          }
    
          if($request->section_3  != null ){
    
            $section_3 = count($request['section_3']);
    
            for ($i=0; $i<$section_3; $i++){
                    $AdminLandingPage = new AdminLandingPage;
                    $AdminLandingPage->content = $request['section_3'][$i];
                    $AdminLandingPage->section = "3";
                    $AdminLandingPage->landing_page_id = $landing_page_id;
                    $AdminLandingPage->title = $request->title;
                    $AdminLandingPage->slug =  $request->slug;
                    $AdminLandingPage->save();
            }
          }

          if($request->section_4  != null ){
    
            $section_4 = count($request['section_4']);
    
            for ($i=0; $i<$section_4; $i++){
                    $AdminLandingPage = new AdminLandingPage;
                    $AdminLandingPage->content = $request['section_4'][$i];
                    $AdminLandingPage->section = "4";
                    $AdminLandingPage->landing_page_id = $landing_page_id;
                    $AdminLandingPage->title = $request->title;
                    $AdminLandingPage->slug =  $request->slug;
                    $AdminLandingPage->save();
            }
          }

        return Redirect::route('landing_page_index')->with('message', 'Successfully! Created Landing Page');
    }

    public function edit(Request $request,$id)
    {
        $data = [
            'section_1' =>  AdminLandingPage::where('landing_page_id',$id)->where('section',1)->get(),
            'section_2' =>  AdminLandingPage::where('landing_page_id',$id)->where('section',2)->get(),
            'section_3' =>  AdminLandingPage::where('landing_page_id',$id)->where('section',3)->get(),
            'section_4' =>  AdminLandingPage::where('landing_page_id',$id)->where('section',4)->get(),
            'landing_page_id' => $id ,
            'title' => AdminLandingPage::where('landing_page_id',$id)->pluck('title')->first(),
            'slug'  => AdminLandingPage::where('landing_page_id',$id)->pluck('slug')->first(),
        ];

        return view('admin.Landing_page.edit',$data);
    }

    public function update(Request $request)
    {

      AdminLandingPage::where('landing_page_id',$request->landing_page_id)->delete();

      if($request->section_1  != null ){

        $section_1 = count($request['section_1']);

        for ($i=0; $i<$section_1; $i++){
                $AdminLandingPage = new AdminLandingPage;
                $AdminLandingPage->content = $request['section_1'][$i];
                $AdminLandingPage->section = "1";
                $AdminLandingPage->landing_page_id = $request->landing_page_id;
                $AdminLandingPage->title = $request->title;
                $AdminLandingPage->slug =  $request->slug;
                $AdminLandingPage->save();
        }
      }

      if($request->section_2  != null  ){

        $section_2 = count($request['section_2']);

        for ($i=0; $i<$section_2; $i++){
                $AdminLandingPage = new AdminLandingPage;
                $AdminLandingPage->content = $request['section_2'][$i];
                $AdminLandingPage->section = "2";
                $AdminLandingPage->landing_page_id = $request->landing_page_id;
                $AdminLandingPage->title = $request->title;
                $AdminLandingPage->slug =  $request->slug;
                $AdminLandingPage->save();
        }
      }

      if($request->section_3  != null ){

        $section_3 = count($request['section_3']);

        for ($i=0; $i<$section_3; $i++){
                $AdminLandingPage = new AdminLandingPage;
                $AdminLandingPage->content = $request['section_3'][$i];
                $AdminLandingPage->section = "3";
                $AdminLandingPage->landing_page_id = $request->landing_page_id;
                $AdminLandingPage->title = $request->title;
                $AdminLandingPage->slug =  $request->slug;
                $AdminLandingPage->save();
        }
      }

      if($request->section_4  != null ){

        $section_4 = count($request['section_4']);

        for ($i=0; $i<$section_4; $i++){
                $AdminLandingPage = new AdminLandingPage;
                $AdminLandingPage->content = $request['section_4'][$i];
                $AdminLandingPage->section = "4";
                $AdminLandingPage->landing_page_id = $request->landing_page_id;
                $AdminLandingPage->title = $request->title;
                $AdminLandingPage->slug =  $request->slug;
                $AdminLandingPage->save();
        }
      }

      return Redirect::route('landing_page_index')->with('message', 'Successfully! Updated Landing Page');

    }

    public function delete(Request $request,$id)
    {
        AdminLandingPage::where('landing_page_id',$id)->delete();
        return Redirect::back()->with('message', 'Successfully Landing Page Removed');
    }

    public function update_status(Request $request)
    {
      try {
        
        AdminLandingPage::query()->update(['status' => 0]);

        $landing_page = AdminLandingPage::where('landing_page_id',$request->landing_page_id)
          ->update([
            'status' => $request->status,
        ]);

        return response()->json(['message'=>"true"]);

      } catch (\Throwable $th) {
          return response()->json(['message'=>"false"]);
      }

    }
}

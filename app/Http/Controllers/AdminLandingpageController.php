<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AdminLandingPage;
use Illuminate\Support\Str;
use \Redirect ;
use Illuminate\Support\Facades\Validator;


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
      try {

          $validator = Validator::make($request->all(), [
            'title'   => 'required',
            'section.*' => 'required',
            'date.*'    => 'required',
          ]);
          
          if ($validator->fails()) {
            return Redirect::back()->with('error-message', "Please! Fill the title and section Field");
          }

        $landing_page_id = AdminLandingPage::max('landing_page_id') + 1 ;

          if($request->section_1  != null ){

            $section_1 = count($request['section_1']);
    
            for ($i=0; $i<$section_1; $i++){
                    $AdminLandingPage = new AdminLandingPage;
                    $AdminLandingPage->content = $request['section_1'][$i];
                    $AdminLandingPage->section = "1";
                    $AdminLandingPage->landing_page_id = $landing_page_id;
                    $AdminLandingPage->title = $request->title;
                    $AdminLandingPage->slug =  $request->slug != null ? Str::slug($request->slug) : Str::slug($request->title) ;
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
                    $AdminLandingPage->slug =  $request->slug != null ? Str::slug($request->slug) : Str::slug($request->title) ;
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
                    $AdminLandingPage->slug =  $request->slug != null ? Str::slug($request->slug) : Str::slug($request->title) ;
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
                    $AdminLandingPage->slug =  $request->slug != null ? Str::slug($request->slug) : Str::slug($request->title) ;
                    $AdminLandingPage->save();
            }
          }

          $last_id = $AdminLandingPage->id;

          $custom_css = AdminLandingPage::where('id',$last_id)->update([
            'custom_css' => $request->custom_css ,
          ]);

          $bootstrap_link = AdminLandingPage::where('id',$last_id)->update([
            'bootstrap_link' => $request->bootstrap_link ,
          ]);
    
          $script_content = AdminLandingPage::where('id',$last_id)->update([
            'script_content' => $request->script_content ,
          ]);

          $Header_footer = AdminLandingPage::where('id',$last_id)->update([
            'footer' => !empty( $request->footer &&  $request->footer == "on" ) ? 1 : 0 ,
            'header' => !empty( $request->header &&  $request->header == "on" ) ? 1 : 0 ,
          ]);

        return Redirect::route('landing_page_index')->with('message', 'Successfully! Created Landing Page');
      } 
        catch (\Throwable $th) {
          return Redirect::back()->with('error-message', $th->getMessage());
      }
    }

    public function edit(Request $request,$id)
    {
        $data = [
            'section_1' =>  AdminLandingPage::where('landing_page_id',$id)->where('section',1)->get(),
            'section_2' =>  AdminLandingPage::where('landing_page_id',$id)->where('section',2)->get(),
            'section_3' =>  AdminLandingPage::where('landing_page_id',$id)->where('section',3)->get(),
            'section_4' =>  AdminLandingPage::where('landing_page_id',$id)->where('section',4)->get(),
            'title'     => AdminLandingPage::where('landing_page_id',$id)->pluck('title')->first(),
            'slug'      => AdminLandingPage::where('landing_page_id',$id)->pluck('slug')->first(),
            'custom_css'  => AdminLandingPage::where('landing_page_id',$id)->orderBy('id', 'desc')->pluck('custom_css')->first(),
            'bootstrap_link'  => AdminLandingPage::where('landing_page_id',$id)->orderBy('id', 'desc')->pluck('bootstrap_link')->first(),
            'stript_content'  => AdminLandingPage::where('landing_page_id',$id)->orderBy('id', 'desc')->pluck('script_content')->first(),
            'footer'  => AdminLandingPage::where('landing_page_id',$id)->orderBy('id', 'desc')->pluck('footer')->first(),
            'header'  => AdminLandingPage::where('landing_page_id',$id)->orderBy('id', 'desc')->pluck('header')->first(),
            'landing_page_id' => $id ,
        ];
        
        return view('admin.Landing_page.edit',$data);
    }

    public function update(Request $request)
    {

      if(  !empty($request->date) ){

          AdminLandingPage::where('landing_page_id',$request->landing_page_id)->delete();

          if( !empty($request->date) && in_array ('section_1',$request->date) == true && $request->section_1  != null ){
    
            $section_1 = count($request['section_1']);
    
            for ($i=0; $i<$section_1; $i++){
                    $AdminLandingPage = new AdminLandingPage;
                    $AdminLandingPage->content = $request['section_1'][$i];
                    $AdminLandingPage->section = "1";
                    $AdminLandingPage->landing_page_id = $request->landing_page_id;
                    $AdminLandingPage->title = $request->title;
                    $AdminLandingPage->slug =  $request->slug != null ? Str::slug($request->slug) : Str::slug($request->title) ;
                    $AdminLandingPage->save();
            }
          }
    
          if(  !empty($request->date) && in_array ('section_2',$request->date) == true && $request->section_2  != null  ){
    
            $section_2 = count($request['section_2']);
    
            for ($i=0; $i<$section_2; $i++){
                    $AdminLandingPage = new AdminLandingPage;
                    $AdminLandingPage->content = $request['section_2'][$i];
                    $AdminLandingPage->section = "2";
                    $AdminLandingPage->landing_page_id = $request->landing_page_id;
                    $AdminLandingPage->title = $request->title;
                    $AdminLandingPage->slug =  $request->slug != null ? Str::slug($request->slug) : Str::slug($request->title) ;
                    $AdminLandingPage->save();
            }
          }
    
          if(  !empty($request->date) && in_array ('section_3',$request->date) == true && $request->section_3  != null ){
    
            $section_3 = count($request['section_3']);
    
            for ($i=0; $i<$section_3; $i++){
                    $AdminLandingPage = new AdminLandingPage;
                    $AdminLandingPage->content = $request['section_3'][$i];
                    $AdminLandingPage->section = "3";
                    $AdminLandingPage->landing_page_id = $request->landing_page_id;
                    $AdminLandingPage->title = $request->title;
                    $AdminLandingPage->slug =  $request->slug != null ? Str::slug($request->slug) : Str::slug($request->title) ;
                    $AdminLandingPage->save();
            }
          }
    
          if(  !empty($request->date) && in_array ('section_4',$request->date) == true && $request->section_4  != null ){
    
            $section_4 = count($request['section_4']);
    
            for ($i=0; $i<$section_4; $i++){
                    $AdminLandingPage = new AdminLandingPage;
                    $AdminLandingPage->content = $request['section_4'][$i];
                    $AdminLandingPage->section = "4";
                    $AdminLandingPage->landing_page_id = $request->landing_page_id;
                    $AdminLandingPage->title = $request->title;
                    $AdminLandingPage->slug =  $request->slug != null ? Str::slug($request->slug) : Str::slug($request->title) ;
                    $AdminLandingPage->save();
            }
          }
      }
      
      $last_id =  !empty($request->date) ? $AdminLandingPage->id : $request->landing_page_id ;

      $custom_css = AdminLandingPage::where('id',$last_id)->update([
        'custom_css' => $request->custom_css ,
      ]);

      $bootstrap_link = AdminLandingPage::where('id',$last_id)->update([
        'bootstrap_link' => $request->bootstrap_link ,
      ]);

      $script_content = AdminLandingPage::where('id',$last_id)->update([
        'script_content' => $request->script_content ,
      ]);

      $Header_footer = AdminLandingPage::where('id',$last_id)->update([
        'footer' => !empty( $request->footer &&  $request->footer == "on" ) ? 1 : 0 ,
        'header' => !empty( $request->header &&  $request->header == "on" ) ? 1 : 0 ,
      ]);

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

    public function preview(Request $request,$landing_page_id)
    {
      $data = [
        'title' => AdminLandingPage::where('landing_page_id',$landing_page_id)->pluck('title')->first(),
        'sections_1' => AdminLandingPage::where('landing_page_id',$landing_page_id)->where('section',1)->pluck('content'),
        'sections_2' => AdminLandingPage::where('landing_page_id',$landing_page_id)->where('section',2)->pluck('content'),
        'sections_3' => AdminLandingPage::where('landing_page_id',$landing_page_id)->where('section',3)->pluck('content'),
        'sections_4' => AdminLandingPage::where('landing_page_id',$landing_page_id)->where('section',4)->pluck('content'),
        'custom_css' => AdminLandingPage::where('landing_page_id',$landing_page_id)->orderBy('id','desc')->pluck('custom_css')->first(),
        'bootstrap_link'  => AdminLandingPage::where('landing_page_id',$landing_page_id)->orderBy('id', 'desc')->pluck('bootstrap_link')->first(),
        'script_content'  => AdminLandingPage::where('landing_page_id',$landing_page_id)->orderBy('id', 'desc')->pluck('script_content')->first(),
      ];

      return view('admin.Landing_page.preview',$data);
    }
}

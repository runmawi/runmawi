<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use \App\User as User;
use \Redirect as Redirect;
use URL;
use App\Video as Video;
use App\Page as Page;
use App\Plan as Plan;
use App\VideoCategory as VideoCategory;
use App\VideoResolution as VideoResolution;
use App\VideosSubtitle as VideosSubtitle;
use App\Language as Language;
use App\Subtitle as Subtitle;
use App\Tag as Tag;
use Auth;
use Hash;
use Illuminate\Support\Facades\Cache;
use Image;
use View;
use Response;
use Session;


class CPPAdminPageController extends Controller
{
  
    /**
     * Display a listing of videos
     *
     * @return Response
     */
    public function CPPindex()
    {
        $user = Session::get('user'); 
        $user_id = $user->id;
        $pages = Page::where('user_id','=',$user_id)->orderBy('created_at', 'DESC')->paginate(10);
        // $user = Auth::user();

        $data = array(
            'pages' => $pages,
            'user' => $user,
            // 'admin_user' => Auth::user()
            );

        return View::make('moderator.cpp.pages.index', $data);
    }

    /**
     * Show the form for creating a new video
     *
     * @return Response
     */
    public function CPPcreate()
    {
        $user = Session::get('user'); 
        $user_id = $user->id;
        $data = array(
            'post_route' => URL::to('cpp/pages/store'),
            'button_text' => 'Add New Page',
            // 'admin_user' => Auth::user()
            );
        return View::make('moderator.cpp.pages.create_edit', $data);
    }

    /**
     * Store a newly created video in storage.
     *
     * @return Response
     */
    public function CPPstore(Request $request)
    {
        $user = Session::get('user'); 
        $user_id = $user->id;
        $validator = Validator::make($data = $request->all(), Page::$rules);
        
         $validatedData = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|max:255',
            'body' => 'required'
        ]);
        
        
             $path = public_path().'/uploads/settings/';
        
            $logo = $request['banner'];
        
                /* logo upload */

             if($logo != '') {   
                  //code for remove old file
                  if($logo != ''  && $logo != null){
                       $file_old = $path.$logo;
                      if (file_exists($file_old)){
                       unlink($file_old);
                      }
                  }
                  //upload new file
                  $file = $logo;
                  $data['banner']  = $file->getClientOriginalName();
                  $file->move($path, $data['banner']);

             }
             $data['user_id']  = $user_id;


        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withRequest();
        }

        $page = Page::create($data);

        return Redirect::to('/cpp/pages')->with(array('note' => 'New Page Successfully Added!', 'note_type' => 'success') );
    }

    /**
     * Show the form for editing the specified video.
     *
     * @param  int  $id
     * @return Response
     */
    public function CPPedit($id)
    {
        $user = Session::get('user'); 
        $user_id = $user->id;
        $page = Page::find($id);

        $data = array(
            'headline' => '<i class="fa fa-edit"></i> Edit Page',
            'page' => $page,
            'post_route' => URL::to('cpp/pages/update'),
            'button_text' => 'Update Page',
            'admin_user' => Auth::user()
            );

        return View::make('moderator.cpp.pages.create_edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function CPPupdate(Request $request)
    {
        $user = Session::get('user'); 
        $user_id = $user->id;
        $data = $request->all();
        
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|max:255',
            'body' => 'required'
        ]);
        
             $data['user_id']  = $user_id;
        
        $id = $data['id'];
        $page = Page::findOrFail($id);

        $validator = Validator::make($data, Page::$rules);
        
        
         $path = public_path().'/uploads/settings/';
        
         $logo = $request['banner'];
        
        /* logo upload */
          
     if($logo != '') {   
          //code for remove old file
          if($logo != ''  && $logo != null){
               $file_old = $path.$logo;
              if (file_exists($file_old)){
               unlink($file_old);
              }
          }
          //upload new file
          $file = $logo;
          $data['banner']  = $file->getClientOriginalName();
          $file->move($path, $data['banner']);
          $data['user_id']  = $user_id;
         
     }

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withRequest();
        }

        if(!isset($data['active']) || $data['active'] == ''){
            $data['active'] = 0;
        }

        $page->update($data);

        return Redirect::back()->with(array('note' => 'Successfully Updated Page!', 'note_type' => 'success') );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function CPPdestroy($id)
    {
        $page = Page::find($id);

        Page::destroy($id);

        return Redirect::back()->with(array('note' => 'Successfully Deleted Page', 'note_type' => 'success') );
    }

     public function CPPupload(Request $request)
    {
        if($request->hasFile('upload')) {
            //get filename with extension
            $filenamewithextension = $request->file('upload')->getClientOriginalName();
      
            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
      
            //get file extension
            $extension = $request->file('upload')->getClientOriginalExtension();
      
            //filename to store
            $filenametostore = $filename.'_'.time().'.'.$extension;
      
            //Upload File
            $request->file('upload')->storeAs('public/uploads', $filenametostore);
 
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('storage/uploads/'.$filenametostore);
            $msg = 'Image successfully uploaded';
            $re = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
             
            // Render HTML output
            @header('Content-type: text/html; charset=utf-8');
            echo $re;
        }
    }
    
    
}

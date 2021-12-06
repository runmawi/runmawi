<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User as User;
use \Redirect as Redirect;
use URL;
use App\Video as Video;
use App\VideoCategory as VideoCategory;
use Auth;
use Hash;
use Illuminate\Support\Facades\Cache;
use Image;
use Session;


class CPPAdminVideoCategoriesController extends Controller
{
      
      public function CPPindex(){
        $user_package =    User::where('id', 1)->first();
        $package = $user_package->package;
        if(!empty($package) && $package== "Pro" || !empty($package) && $package == "Business" ){
        $user = Session::get('user'); 
        $id = $user->id;
        // dd($id);
        $allCategories = VideoCategory::where('user_id','=',$id)->get();
          
          $data = array (
            'allCategories'=>$allCategories
          );
          

        return view('moderator.cpp.videos.categories.index',$data);
      }else{
        return Redirect::to('/blocked');
      }
      }
    
      public function CPPstore(Request $request){
        $user_package =    User::where('id', 1)->first();
        $package = $user_package->package;
        if(!empty($package) && $package== "Pro" || !empty($package) && $package == "Business" ){
          
            $input = $request->all();
          
          $validatedData = $request->validate([
            'name' => 'required|max:255',
        ]);
        $user = Session::get('user'); 
        $id = $user->id;
          
            $s = new VideoCategory();
           
            $input['parent_id'] = empty($input['parent_id']) ? 0 : $input['parent_id'];
            $input['user_id'] = !empty($id) ? $id : "";


            $path = public_path().'/uploads/videocategory/';
        
            $image = $request['image']; 
          
            $slug = $request['slug']; 
          
            $in_home = $request['in_home']; 
          
          if ( $slug != '') {
              $input['slug']  = $request['slug'];
          } else {
               $input['slug']  = $request['name'];
          } 
          if ( $in_home != '') {
              $input['in_home']  = $request['in_home'];
          } else {
               $input['in_home']  = $request['in_home'];
          }
          
           if($image != '') {   
          //code for remove old file
              if($image != ''  && $image != null){
                   $file_old = $path.$image;
                  if (file_exists($file_old)){
                   unlink($file_old);
                  }
              }
              //upload new file
              $file = $image;
              $input['image']  = $file->getClientOriginalName();
              $file->move($path, $input['image']);

          } else {
               $input['image']  = 'default.jpg';
           }
          
            

            VideoCategory::create($input);
            return back()->with('message', 'New Category added successfully.');
          }else{
            return Redirect::to('/blocked');
          }
    }
    
      public function CPPedit($id){
        $user_package =    User::where('id', 1)->first();
        $package = $user_package->package;
        if(!empty($package) && $package== "Pro" || !empty($package) && $package == "Business" ){
         
            $categories = VideoCategory::where('id', '=', $id)->get();

            $allCategories = VideoCategory::all();
            return view('moderator.cpp.videos.categories.edit',compact('categories','allCategories'));
          }else{
            return Redirect::to('/blocked');
          }
        }
    
    
     public function CPPupdate(Request $request){
      $user_package =    User::where('id', 1)->first();
      $package = $user_package->package;
      if(!empty($package) && $package== "Pro" || !empty($package) && $package == "Business" ){
           
        $input = $request->all();
        $path = public_path().'/uploads/videocategory/';
           
        $id = $request['id'];
        $in_home = $request['in_home']; 
        $category = VideoCategory::find($id);
         
             if (isset($request['image']) && !empty($request['image'])){
                    $image = $request['image']; 
                 } else {
                     $request['image'] = $category->image;
              }

              $slug = $request['slug']; 
              if ( $in_home != '') {
                  $input['in_home']  = $request['in_home'];
              } else {
                   $input['in_home']  = $request['in_home'];
              }

          
            if( isset($image) && $image!= '') {   
            //code for remove old file
            if ($image != ''  && $image != null) {
                $file_old = $path.$image;
                if (file_exists($file_old)){
                       unlink($file_old);
                }
            }
                  //upload new file
                  $file = $image;
                  $category->image  = $file->getClientOriginalName();
                  $file->move($path,$category->image);

              } 
         
            $category->name = $request['name'];
            $category->slug = $request['slug'];
            $category->parent_id = $request['parent_id'];
            $category->in_home = $request['in_home'];

            if ( $category->slug != '') {
              $category->slug  = $request['slug'];
            } else {
               $category->slug  = $request['name'];
            }
           
            $category->save();
            
            return Redirect::back()->with(array('message' => 'Successfully Updated Category', 'note_type' => 'success') );
          }else{
            return Redirect::to('/blocked');
          }
            
    }
    
    
    public function CPPdestroy($id){
      $user_package =    User::where('id', 1)->first();
      $package = $user_package->package;
      if(!empty($package) && $package== "Pro" || !empty($package) && $package == "Business" ){
        VideoCategory::destroy($id);
        $child_cats = VideoCategory::where('parent_id', '=', $id)->get();
        foreach($child_cats as $cats){
            $cats->parent_id = 0;
            $cats->save();
        }
        return Redirect::back()->with(array('message' => 'Successfully Deleted Category', 'note_type' => 'success') );
      }else{
        return Redirect::to('/blocked');
      }
    }
    
    
    
public function CPPcategory_order(Request $request){
  $user_package =    User::where('id', 1)->first();
  $package = $user_package->package;
  if(!empty($package) && $package== "Pro" || !empty($package) && $package == "Business" ){
      $input = $request->all();
      $position = $_POST['position'];
      $i=1;
      foreach($position as $k=>$v){
        $videocategory = VideoCategory::find($v);
        $videocategory->order = $i;
        $videocategory->save();
        $i++;
      }
      return 1;
    }else{
      return Redirect::to('/blocked');
    }

    }
    
    
    
}

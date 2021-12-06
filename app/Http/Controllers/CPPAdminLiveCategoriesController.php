<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use \App\User as User;
use \Redirect as Redirect;
use URL;
use App\Video as Video;
use App\VideoCategory as VideoCategory;
use App\LiveCategory as LiveCategory;
use Auth;
use Hash;
use Illuminate\Support\Facades\Cache;
use Image;
use DB;
use Session;


class CPPAdminLiveCategoriesController extends Controller
{
      public function CPPindex(){
        $user_package =    User::where('id', 1)->first();
        $package = $user_package->package;
        if(!empty($package) && $package== "Pro" || !empty($package) && $package == "Business" ){
        $user = Session::get('user'); 
        $user_id = $user->id;
        $categories = LiveCategory::where('user_id','=',$user_id)->where('parent_id', '=', 0)->get();

        $allCategories = LiveCategory::where('user_id','=',$user_id)->get();
          
          
          
        $data = array (
            'allCategories'=>$allCategories
          );
         
        return view('moderator.cpp.livestream.categories.index',$data);
      }else{
        return Redirect::to('/blocked');
      }
         
  }
    
    
     public function CPPstore(Request $request){
      $user_package =    User::where('id', 1)->first();
      $package = $user_package->package;
      if(!empty($package) && $package== "Pro" || !empty($package) && $package == "Business" ){
         
        $user = Session::get('user'); 
        $user_id = $user->id;
            $input = $request->all();
            
              $validatedData = $request->validate([
                   'name' => 'required|max:255',
             ]);
          
            $s = new LiveCategory();
           
            $input['parent_id'] = empty($input['parent_id']) ? 0 : $input['parent_id'];

            $path = public_path().'/uploads/livecategory/';
        
            $image = $request['image'];
            
            $slug = $request['slug']; 
          
              if ( $slug != '') {
                  $input['slug']  = $request['slug'];
              } else {
                   $input['slug']  = $request['name'];
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

           $input['user_id']  = $user_id;

            LiveCategory::create($input);
            return back()->with('message', 'New Category added successfully.');
          }else{
            return Redirect::to('/blocked');
          }

       }
    
    public function CPPedit($id){
      $user_package =    User::where('id', 1)->first();
      $package = $user_package->package;
      if(!empty($package) && $package== "Pro" || !empty($package) && $package == "Business" ){
        $user = Session::get('user'); 
        $user_id = $user->id;
            $categories = LiveCategory::where('id', '=', $id)->get();

            $allCategories = LiveCategory::all();
            return view('moderator.cpp.livestream.categories.edit',compact('categories','allCategories'));
          }else{
            return Redirect::to('/blocked');
          }

      }
    
    
        public function CPPupdate(Request $request){
          $user_package =    User::where('id', 1)->first();
          $package = $user_package->package;
          if(!empty($package) && $package== "Pro" || !empty($package) && $package == "Business" ){
            $user = Session::get('user'); 
            $user_id = $user->id;
            $input = $request->all();
            
             $validatedData = $request->validate([
                   'name' => 'required|max:255',
             ]);
            
            
            $path = public_path().'/uploads/livecategory/';

            $id = $request['id'];
            $category = LiveCategory::find($id);

             if (isset($request['image']) && !empty($request['image'])){
                $image = $request['image']; 
             } else {
                 $request['image'] = $category->image;
             }

             if( isset($image) && $image!= '') {   
              //code for remove old file
                  if($image != ''  && $image != null){
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
            
             if ( $category->slug != '') {
              $category->slug  = $request['slug'];
              } else {
                   $category->slug  = $request['name'];
              }

              $category->user_id = $user_id;
            
            $category->save();

            return Redirect::to('cpp/livestream/categories')->with(array('message' => 'Successfully Updated Category', 'note_type' => 'success') );
          }else{
            return Redirect::to('/blocked');
          }

      }
    
        
    
        public function CPPdestroy($id){
          $user_package =    User::where('id', 1)->first();
          $package = $user_package->package;
          if(!empty($package) && $package== "Pro" || !empty($package) && $package == "Business" ){
            $user = Session::get('user'); 
            $user_id = $user->id;
            LiveCategory::destroy($id);
            
            $child_cats = LiveCategory::where('parent_id', '=', $id)->get();
            
            foreach($child_cats as $cats){
                $cats->parent_id = 0;
                $cats->save();
            }
            return Redirect::back()->with(array('message' => 'Successfully Deleted Category', 'note_type' => 'success') );
          }else{
            return Redirect::to('/blocked');
          }
      }
    
    
    
}

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

class AdminLiveCategoriesController extends Controller
{
      public function index(){
          
        $categories = LiveCategory::where('parent_id', '=', 0)->get();

        $allCategories = LiveCategory::all();
          
          
          
        $data = array (
            'allCategories'=>$allCategories
          );
         
        return view('admin.livestream.categories.index',$data);
         
      }
    
    
     public function store(Request $request){
          
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
          
            LiveCategory::create($input);
            return back()->with('success', 'New Category added successfully.');
       }
    
    public function edit($id){
         
            $categories = LiveCategory::where('id', '=', $id)->get();

            $allCategories = LiveCategory::all();
            return view('admin.livestream.categories.edit',compact('categories','allCategories'));
        }
    
    
        public function update(Request $request){
           
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
            
            
            $category->save();

            return Redirect::to('admin/livestream/categories')->with(array('note' => 'Successfully Updated Category', 'note_type' => 'success') );
            
            }
    
        
    
        public function destroy($id){
            
            LiveCategory::destroy($id);
            
            $child_cats = LiveCategory::where('parent_id', '=', $id)->get();
            
            foreach($child_cats as $cats){
                $cats->parent_id = 0;
                $cats->save();
            }
            return Redirect::to('admin/livestream/categories')->with(array('note' => 'Successfully Deleted Category', 'note_type' => 'success') );
        }
    
    
    
}

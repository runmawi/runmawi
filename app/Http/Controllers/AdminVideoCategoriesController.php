<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User as User;
use \Redirect as Redirect;
use URL;
use App\Video as Video;
use App\Setting as Setting;
use App\VideoCategory as VideoCategory;
use Auth;
use Hash;
use Illuminate\Support\Facades\Cache;
use Image;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;

class AdminVideoCategoriesController extends Controller
{
      
      public function index(){

        $user =  User::where('id',1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');
        if ($current_date > $duedate)
        {
          $client = new Client();
          $url = "https://flicknexs.com/userapi/allplans";
          $params = [
              'userid' => 0,
          ];
  
          $headers = [
              'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ'
          ];
          $response = $client->request('post', $url, [
              'json' => $params,
              'headers' => $headers,
              'verify'  => false,
          ]);
  
          $responseBody = json_decode($response->getBody());
         $settings = Setting::first();
         $data = array(
          'settings' => $settings,
          'responseBody' => $responseBody,
  );
            return view('admin.expired_dashboard', $data);
        }else{
        $allCategories = VideoCategory::orderBy('order')->get();
          
          $data = array (
            'allCategories'=>$allCategories
          );
          

        return view('admin.videos.categories.index',$data);
        }
      }
    
      public function store(Request $request){
          
            $input = $request->all();
          
          $validatedData = $request->validate([
            'name' => 'required|max:255',
        ]);
          
            $s = new VideoCategory();
           
            $input['parent_id'] = empty($input['parent_id']) ? 0 : $input['parent_id'];

            $path = public_path().'/uploads/videocategory/';
        
            $image = $request['image']; 
          
            $slug = $request['slug']; 

            $in_menu = $request['in_menu']; 

          
            $in_home = $request['in_home']; 

            $banner = $request['banner']; 

            
            $footer = $request['footer']; 
          
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
          if ( $footer != '') {
            $input['footer']  = $request['footer'];
        } else {
             $input['footer']  = $request['footer'];
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
           $banner_image = $request['banner_image']; 
          
           if($banner_image != '') {   
            //code for remove old file
                if($banner_image != ''  && $banner_image != null){
                     $file_old = $path.$banner_image;
                    if (file_exists($file_old)){
                     unlink($file_old);
                    }
                }
                //upload new file
                $file = $banner_image;
                $input['banner_image']  = $file->getClientOriginalName();
                $file->move($path, $input['banner_image']);
  
            } else {
                 $input['banner_image']  = 'default.jpg';
             }
            

            VideoCategory::create($input);
            return back()->with('message', 'New Category added successfully.');
    }
    
      public function edit($id){
         
            $categories = VideoCategory::where('id', '=', $id)->get();

            $allCategories = VideoCategory::all();
            return view('admin.videos.categories.edit',compact('categories','allCategories'));
        }
    
    
     public function update(Request $request){
           
        $input = $request->all();
        $path = public_path().'/uploads/videocategory/';
           
        $id = $request['id'];
        $in_home = $request['in_home']; 
        $footer = $request['footer']; 
        $in_menu = $request['in_menu']; 
        $category = VideoCategory::find($id);
         
             if (isset($request['image']) && !empty($request['image'])){
                    $image = $request['image']; 
                 } else {
                     $request['image'] = $category->image;
              }


              if (isset($request['banner_image']) && !empty($request['banner_image'])){
                $banner_image = $request['banner_image']; 
             } else {
                 $request['banner_image'] = $category->banner_image;
          }

              $slug = $request['slug']; 
              if ( $in_home != '') {
                  $input['in_home']  = $request['in_home'];
              } else {
                   $input['in_home']  = $request['in_home'];
              }

              if ( $footer != '') {
                $input['footer']  = $request['footer'];
            } else {
                 $input['footer']  = $request['footer'];
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
              if( isset($banner_image) && $banner_image!= '') {   
                //code for remove old file
                if ($banner_image != ''  && $banner_image != null) {
                    $file_old = $path.$banner_image;
                    if (file_exists($file_old)){
                           unlink($file_old);
                    }
                }
                      //upload new file
                      $file = $banner_image;
                      $category->banner_image  = $file->getClientOriginalName();
                      $file->move($path,$category->banner_image);
    
                  } 
            $category->name = $request['name'];
            $category->slug = $request['slug'];
            $category->parent_id = $request['parent_id'];
            $category->in_home = $request['in_home'];
            $category->footer = $request['footer'];
            $category->in_menu = $request['in_menu'];
            $category->banner = $request['banner'];

            if ( $category->slug != '') {
              $category->slug  = $request['slug'];
            } else {
               $category->slug  = $request['name'];
            }
           
            $category->save();
            
            return Redirect::to('admin/videos/categories')->with(array('message' => 'Successfully Updated Category', 'note_type' => 'success') );
            
    }
    
    
    public function destroy($id){
        VideoCategory::destroy($id);
        $child_cats = VideoCategory::where('parent_id', '=', $id)->get();
        foreach($child_cats as $cats){
            $cats->parent_id = 0;
            $cats->save();
        }
        return Redirect::to('admin/videos/categories')->with(array('message' => 'Successfully Deleted Category', 'note_type' => 'success') );
    }
    
    
    
public function category_order(Request $request){

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

    }
    
    
    
}

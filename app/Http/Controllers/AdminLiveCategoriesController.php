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
use App\SystemSetting as SystemSetting;
use Session;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;

class AdminLiveCategoriesController extends Controller
{
      public function index(){
        $data = Session::all();
        if (!empty($data['password_hash'])) {
        $package_id = auth()->user()->id;
        // dd('test');
        $user_package =    User::where('id', $package_id)->first();
        $package = $user_package->package;
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
            return view('admin.expired_dashboard');
        }else{
        if($package == "Pro" || $package == "Business" || $package == "" && Auth::User()->role =="admin" ){
        $categories = LiveCategory::where('parent_id', '=', 0)->get();

        $allCategories = LiveCategory::all();
          
          
          
        $data = array (
            'allCategories'=>$allCategories
          );
         
        return view('admin.livestream.categories.index',$data);
         
      }else if($package == "Basic"){

        return view('blocked');

    }
  }
  }else{
    $system_settings = SystemSetting::first();
    $user = User::where('id','=',1)->first();
    return view('auth.login',compact('system_settings','user'));

  }
  }
    
    
     public function store(Request $request){
      $data = Session::all();
      if (!empty($data['password_hash'])) {
      $package_id = auth()->user()->id;
      $user_package =    User::where('id', $package_id)->first();
      $package = $user_package->package;
      if($package == "Pro" || $package == "Business" || $package == "" && Auth::User()->role =="admin"){
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
              if ($input['in_menu'] == 1) {
                $in_menu  = 1;
            } else {
              $in_menu  = 0;
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
            $order = LiveCategory::orderBy('id', 'DESC')->first();
            // $last2 = DB::table('items')->orderBy('id', 'DESC')->first();

          //  dd($order);
           if(!empty($order)){
            $orderno = $order->order;
            $order = $orderno + 1 ;
           }else{
            $order = 1;
           }
            // LiveCategory::create($input);

          $LiveCategory  = new LiveCategory;
          
          $LiveCategory->name = $input['name'];
          $LiveCategory->user_id = Auth::User()->id;
          $LiveCategory->order = $order;
          $LiveCategory->slug = $input['slug'];
          $LiveCategory->parent_id = $input['parent_id'];
          $LiveCategory->image = $input['image'];
          $LiveCategory->in_menu = $in_menu;
          $LiveCategory->save();
            return back()->with('message', 'New Category added successfully.');
          }else if($package == "Basic"){

            return view('blocked');
    
        }
      }else{
        $system_settings = SystemSetting::first();
        $user = User::where('id','=',1)->first();
        return view('auth.login',compact('system_settings','user'));
    
      }
       }
    
    public function edit($id){
      $data = Session::all();
        if (!empty($data['password_hash'])) {
      $package_id = auth()->user()->id;
      $user_package =    User::where('id', $package_id)->first();
      $package = $user_package->package;
      if($package == "Pro" || $package == "Business" || $package == "" && Auth::User()->role =="admin"){
            $categories = LiveCategory::where('id', '=', $id)->get();

            $allCategories = LiveCategory::all();
            return view('admin.livestream.categories.edit',compact('categories','allCategories'));
          }else if($package == "Basic"){

            return view('blocked');
    
        }
      }else{
        $system_settings = SystemSetting::first();
        $user = User::where('id','=',1)->first();
        return view('auth.login',compact('system_settings','user'));
    
      }
      }
    
    
        public function update(Request $request){
          $data = Session::all();
        if (!empty($data['password_hash'])) {
          $package_id = auth()->user()->id;
          $user_package =    User::where('id', $package_id)->first();
          $package = $user_package->package;
          if($package == "Pro" || $package == "Business" || $package == "" && Auth::User()->role =="admin"){
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
            $category->in_menu = $request['in_home'];
            $category->slug = $request['slug'];
            $category->parent_id = $request['parent_id'];
            
             if ( $category->slug != '') {
              $category->slug  = $request['slug'];
              } else {
                   $category->slug  = $request['name'];
              }
            
            
            $category->save();

            return Redirect::to('admin/livestream/categories')->with(array('message' => 'Successfully Updated Category', 'note_type' => 'success') );
            
          }else if($package == "Basic"){

            return view('blocked');
    
        }
      }else{
        $system_settings = SystemSetting::first();
        $user = User::where('id','=',1)->first();
        return view('auth.login',compact('system_settings','user'));
    
      }
      }
    
        
    
        public function destroy($id){
          $data = Session::all();
        if (!empty($data['password_hash'])) {
          $package_id = auth()->user()->id;
          $user_package =    User::where('id', $package_id)->first();
          $package = $user_package->package;
          if($package == "Pro" || $package == "Business" || $package == "" && Auth::User()->role =="admin"){
            LiveCategory::destroy($id);
            
            $child_cats = LiveCategory::where('parent_id', '=', $id)->get();
            
            foreach($child_cats as $cats){
                $cats->parent_id = 0;
                $cats->save();
            }
            return Redirect::to('admin/livestream/categories')->with(array('message' => 'Successfully Deleted Category', 'note_type' => 'success') );
          }else if($package == "Basic"){

            return view('blocked');
    
        }
      }else{
        $system_settings = SystemSetting::first();
        $user = User::where('id','=',1)->first();
        return view('auth.login',compact('system_settings','user'));
    
      }
      }
    
    
    
}

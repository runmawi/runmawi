<?php
namespace App\Http\Controllers;

use \App\User as User;
use \Redirect as Redirect;
use Illuminate\Http\Request;
use \App\MobileApp as MobileApp;
use \App\MobileSlider as MobileSlider;
use URL;
use Auth;
use Hash;
use Illuminate\Support\Facades\Cache;
use Image;
use View;
use Flash;

class AdminUsersController extends Controller
{
    
    
   public function index(Request $request)
	{
       
        $user = $request->user();
        //dd($user->hasRole('admin','editor')); // and so on
       
      // dd($user->can('permission-slug'));
       
       //dd($user->hasRole('developer')); //will return true, if user has role
       //dd($user->givePermissionsTo('create-tasks'));// will return permission, if not null
       //dd($user->can('create-tasks')); // will return true, if user has permission

        //exit;
       
        $search_value = '';
        
        if(!empty($search_value)):
            $users = User::where('username', 'LIKE', '%'.$search_value.'%')->orWhere('email', 'LIKE', '%'.$search_value.'%')->orderBy('created_at', 'desc')->get();
        else:
            $users = User::all();
        endif;

		$data = array(
			'users' => $users
			);
		return \View::make('admin.users.index', $data);
	}
    
    public function create(){
        
        $data = array(
            'post_route' => URL::to('admin/user/store'),
            'admin_user' => Auth::user(),
            'button_text' => 'Create User',
            );
        
        return \View::make('admin.users.create_edit', $data);
    }
    
    public function store(Request $request){
        
       
         $validatedData = $request->validate([
                'email' => 'required|max:255',
                'username' => 'required|max:255',
            ]);
        
        $input = $request->all();
        
        $user = Auth::user();
        
        
        $path = public_path().'/uploads/avatars/'; 
        
        $input['email'] = $request['email'];
        
        $path = public_path().'/uploads/avatars/';
        
        $logo = $request['avatar'];
        
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
          $input['avatar']  = $file->getClientOriginalName();
          $file->move($path, $input['avatar']);
         
     }
      
        if ( $input['role'] =='subadmin' ){
            
                $request['role'] ='admin';
                $request['sub_admin'] = 1;
                $request['stripe_active'] = 1;
            
        } else {
            
             $request['role'] = $request['role'];
        }
        
        if ( empty($request['email'])){
            return Redirect::to('admin/user/create')->with(array('note' => 'Successfully Created New User', 'note_type' => 'failed') );
            
        } else {
            
             $request['email'] = $request['email'];
        }
        
        $input['terms'] = 0;
        
          if($request['password'] == ''){
        	$request['password'] = $user->password;
        } else{ $request['password'] = $request['password']; }
//        
        $user = User::create($input);
        return Redirect::to('admin/users')->with(array('note' => 'Successfully Created New User', 'note_type' => 'success') );
    }
    
    
    public function update(Request $request){
        
       
        $input = $request->all();
        
         $validatedData = $request->validate([
                'email' => 'required|max:255',
                'id' => 'required|max:255',
                'username' => 'required|max:255',
         ]);
        
        $id = $request['id'];
        
		$user = User::find($id);        
        $input = $request->all();        
       // $user = Auth::user();       
        
        $path = public_path().'/uploads/avatars/';         
        $input['email'] = $request['email'];  
        
        $path = public_path().'/uploads/avatars/';        
        $logo = $request['avatar'];        
        
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
          $input['avatar']  = $file->getClientOriginalName();
          $file->move($path, $input['avatar']);
         
     }
      
        if ( $input['role'] =='subadmin' ){
            
                $request['role'] ='admin';
                $request['sub_admin'] = 1;
                $request['stripe_active'] = 1;
            
        } else {
            
             $request['role'] = $request['role'];
        }
        
        if ( empty($request['email'])){
            return Redirect::to('admin/user/create')->with(array('note' => 'Successfully Created New User', 'note_type' => 'failed') );
            
        } else {
            
             $request['email'] = $request['email'];
        }
        
        $input['terms'] = 1;
        $input['stripe_active'] = 0;


        if(empty($request['passwords'])) {
        	$input['passwords'] = $user->password;
        } 
        else { 
                $input['passwords'] = $request['passwords']; 
            }
       
        $user_update = User::find($id);
        $user_update->email = $input['email'];
        $user_update->password = $input['passwords'];
        $user_update->role = $input['role'];
        $user_update->terms = $input['terms'];
        $user_update->stripe_active = $input['stripe_active'];
        $user_update->username = $input['username'];
        $user_update->save();
        
        return Redirect::to('admin/users')->with(array('note' => 'Successfully Created New User', 'note_type' => 'success') );
    }
    
    
    public function edit($id){
        
    	$user = User::find($id);
    	$data = array(
    		'user' => $user,
    		'post_route' => URL::to('admin/user/update'),
    		'admin_user' => Auth::user(),
    		'button_text' => 'Update User',
    		);
    	return View::make('admin.users.create_edit', $data);
    } 
    
    public function myprofile(){
        
    	$user_id = Auth::user()->id;
    	$user_details = User::find($user_id);
        
    	$data = array(
    		'user' => $user_details,
    		'post_route' => URL::to('/profile/update')
    		);
    	return View::make('myprofile', $data);
    }
    
    public function refferal() {
    	return View::make('refferal');
    }
    
    
    
    public function profileUpdate(User $user,Request $request)
    {
//         $data = $request->validate([
//            'name' => 'required',
//             'email' => 'required|email|unique:users',
//         ]);

//        $user->fill($data);
//        $user->save();
      
         $user = User::find(Auth::user()->id);
         $user->username = $request->get('name');
         $user->mobile = $request->get('mobile');
         $user->email = $request->get('email');
         $user->ccode = $request->get('ccode');
            if (!empty($request->get('password'))) {
               $user->password = $request->get('password');
            }
             $path = public_path().'/uploads/avatars/';
            $image_path = public_path().'/uploads/avatars/';
        
            $image_req = $request['avatar'];
      
           $image = (isset($image_req)) ? $image_req : '';
          
             if($image != '') {   
                  //code for remove old file
                  if($image != ''  && $image != null){
                       $file_old = $image_path.$image;
                      if (file_exists($file_old)){
                       unlink($file_old);
                      }
                  }
                  //upload new file
                  $file = $image;
                  $user->avatar  = $file->getClientOriginalName();
                  $file->move($image_path, $user->avatar);

             }
        
        
        
         $user->save();
        
        
        //Flash::message('Your account has been updated!');
        return back();
    }
    
    
    public function mobileapp() {
          $mobile_settings = MobileApp::first();
          $allCategories = MobileSlider::all();
          $data = array(
            'admin_user' => Auth::user(),
            'mobile_settings' => $mobile_settings,
            'allCategories'=>$allCategories
          );
          return View::make('admin.mobile.index', $data);

    }


    public function mobileappupdate(Request $request) {
        $input = $request->all();
          $settings = MobileApp::first();
          $path = public_path().'/uploads/settings/';
          $splash_image = $request['splash_image'];

          if($splash_image != '') {   
            //code for remove old file
            if($splash_image != ''  && $splash_image != null){
              $file_old = $path.$splash_image;
              if (file_exists($file_old)){
                unlink($file_old);
              }
            }
            //upload new file
            $file = $splash_image;
            $input['splash_image']  = $file->getClientOriginalName();
            $file->move($path, $input['splash_image']);
          }
          $settings->update($input);
          return Redirect::to('admin/mobileapp')->with(array('note' => 'Successfully Updated  Settings!', 'note_type' => 'success') );
    }  

    
    
    
    
    
    
    public function logout()
    {
        Auth::logout();
        
        return Redirect::to('/')->with(array('note' => 'You are logged out done', 'note_type' => 'success') );
    }
    
    public function destroy($id)
        {

            User::destroy($id);
            return Redirect::to('admin/users')->with(array('note' => 'Successfully Deleted User', 'note_type' => 'success') );
        }
    
}

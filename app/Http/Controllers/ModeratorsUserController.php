<?php

namespace App\Http\Controllers;

use App\ModeratorsPermission;
use App\ModeratorsRole;
use App\ModeratorsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use URL;
use App\UserAccess;
use Hash;
class ModeratorsUserController extends Controller
{   

  public function index()
  {
      $moderatorsrole = ModeratorsRole::all();
      $moderatorspermission = ModeratorsPermission::all();
      $moderatorsuser = ModeratorsUser::all();
// echo "<pre>";
// print_r($moderatorsuser );
// exit();
      

      $data = array(
   
          'roles' => $moderatorsrole,
          'permission' => $moderatorspermission,

        );

  
       return view('moderator.index',$data);
  }

  public function store(Request $request)
  {

    $input = $request->all();
    // echo "<pre>";  
    // print_r($input);
    // exit();
    $user_permission = $request->user_permission;
 $permission = implode(",",$user_permission);
  

$request->validate([
      'email_id' => 'required|email|unique:moderators_users,email',
      'password' => 'min:6',
      'confirm_password' => 'required_with:password|same:password|min:6'
  ]);
    $moderatorsuser = new ModeratorsUser;
    $moderatorsuser->username = $request->username;
    $moderatorsuser->email = $request->email_id;
    $moderatorsuser->mobile_number = $request->mobile_number;
    $moderatorsuser->password = $request->password;
    $password = Hash::make($moderatorsuser->password);
    $moderatorsuser->hashedpassword = $password;
    $moderatorsuser->confirm_password = $request->confirm_password;
    $moderatorsuser->description = $request->description;
    // $moderatorsuser->hashedpassword = $request->picture;
    $moderatorsuser->role = $request->user_role;
    $moderatorsuser->user_permission = $permission;
    


    $logopath = URL::to('/public/uploads/picture/');
    $path = public_path().'/uploads/picture/';
    $picture = $request['picture'];
if($picture != '') {   
     //code for remove old file
     if($picture != ''  && $picture != null){
          $file_old = $path.$picture;
         if (file_exists($file_old)){
          unlink($file_old);
         }
     }
     //upload new file
     
     $file = $picture;
     $moderatorsuser->picture  = $logopath.'/'.$file->getClientOriginalName();
     $file->move($path, $moderatorsuser->picture);
    
}

    $moderatorsuser->save();
    $user_id = $moderatorsuser->id;

    foreach($request->user_permission as $value){
    $userrolepermissiom = new UserAccess;
    $userrolepermissiom->user_id = $user_id;
    $userrolepermissiom->role_id = $request->user_role;
    $userrolepermissiom->permissions_id = $value;
    $userrolepermissiom->save();

    }
   
  return redirect('/moderator')->with('success', 'Users saved!');
  }
}


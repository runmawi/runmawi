<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminPushNotificationController extends Controller
{
    public function index()
    {
        // if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
        //     return redirect('/admin/restrict');
        // }
        
        // $user =  User::where('id',1)->first();
        // $duedate = $user->package_ends;
        // $current_date = date('Y-m-d');
        // if ($current_date > $duedate)
        // {
        //     $client = new Client();
        //     $url = "https://flicknexs.com/userapi/allplans";
        //     $params = [
        //         'userid' => 0,
        //     ];
    
        //     $headers = [
        //         'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ'
        //     ];
        //     $response = $client->request('post', $url, [
        //         'json' => $params,
        //         'headers' => $headers,
        //         'verify'  => false,
        //     ]);
    
        //     $responseBody = json_decode($response->getBody());
        //    $settings = Setting::first();
        //    $data = array(
        //     'settings' => $settings,
        //     'responseBody' => $responseBody,
        //     );
        //     return View::make('admin.expired_dashboard', $data);
        //     }else if(check_storage_exist() == 0){
        //     $settings = Setting::first();

        //     $data = array(
        //         'settings' => $settings,
        //     );

        //     return View::make('admin.expired_storage', $data);
        // }else{
        // // $menu = json_decode(Menu::orderBy('order', 'ASC')->get()->toJson());
        // $menu = Menu::orderBy('order', 'asc')->get();
        // // dd($menu);
        // $user = Auth::user();

        // $data = array(
        //     'menu' => $menu,
        //     'user' => $user,
        //     'admin_user' => Auth::user()
        //     );

        return View::make('admin.push-notification.index');
        
    }

    // public function store(Request $request){

    //     $input = $request->all();
        
    //     $validatedData = $request->validate([
    //         'name' => 'required|max:255',
    //     ]);
        
    //     $image = isset($input["image"]) ? $input["image"] : "";
        
    //     $path = public_path() . "/uploads/videos/";
    //     $image_path = public_path() . "/uploads/images/";
    //     $image_url = URL::to('public/uploads/images');
        
    //     if ($image != "") {
    //         //code for remove old file
    //         if ($image != "" && $image != null) {
    //             $file_old = $image_path . $image;
    //             if (file_exists($file_old)) {
    //                 unlink($file_old);
    //             }
    //         }
    //         //upload new file
    //         $file = $image;

    //         $imageurl = $image_url.'/'.str_replace(" ","_",$file->getClientOriginalName());

    //         $file->move($image_path, $imageurl);
    //         $input['image'] =   $imageurl;
    //     }

    //     // $input['in_home'] = $request->in_home  == "on"  ? 1 : 0 ;
    //     // $input['in_side_menu'] = $request->in_side_menu  == "on"  ? 1 : 0 ;
    //     // $input['in_menu'] = $request->type  ;
    //     // dd($input);
    //     $menu= Menu::create($input);
    //     if(isset($menu->id)){
    //         return Redirect::to('admin/menu')->with(array('note' => 'Successfully Added New Menu Item', 'note_type' => 'success') );
    //     }
    // }


}

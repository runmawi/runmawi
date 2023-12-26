<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use App\AdminEGPChannel;
use App\User;
use View;

class AdminEGPChannelController extends Controller
{

    public function index()
    {
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

            return View::make('admin.expired_dashboard', $data);

        }else if(check_storage_exist() == 0){

            $settings = Setting::first();

            $data = array(
                'settings' => $settings,
            );

            return View::make('admin.expired_storage', $data);

        }else{

            $Admin_EGP_Channel =  AdminEGPChannel::get()->map(function ($item) {
                $item['image_url'] = $item->image != null ? URL::to('public/uploads/EGP-Channel/'.$item->image ) : default_vertical_image_url() ;
                $item['Player_image_url'] = $item->player_image != null ?  URL::to('public/uploads/EGP-Channel/'.$item->player_image ) : default_horizontal_image_url();
                $item['Logo_url'] = $item->logo != null ?  URL::to('public/uploads/EGP-Channel/'.$item->logo ) : default_vertical_image_url();
                return $item;
            });
    
            $data = array ( 'Admin_EGP_Channel'=> $Admin_EGP_Channel );
    
            return View::make('admin.EGP_Channels.index',$data);
        }
    }

    public function create()
    {
        try {

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

                return View::make('admin.expired_dashboard', $data);

            }else if(check_storage_exist() == 0){

                $settings = Setting::first();

                $data = array(
                    'settings' => $settings,
                );

                return View::make('admin.expired_storage', $data);

            }else{

                $data = array(
                    'button_text' => 'Add New' ,
                );

                return View::make('admin.EGP_Channels.create',$data);
            }

        } catch (\Throwable $th) {

            return abort(404);
        }
    }

    public function store(Request $request)
    {
        $inputs = array( 
            'name'          =>  $request->name ,
            "slug"          =>  $request->slug == null  ? Str::slug($request->name)  : Str::slug($request->slug)  ,
            'description'   =>  $request->description ,
        );
        
        if($request->hasFile('image')){

            $file = $request->image;

            if(compress_image_enable() == 1){

                $filename   = 'EGP-Channel-Image-'.time().'.'. compress_image_format();
                Image::make($file)->save(base_path().'/public/uploads/EGP-Channel/'.$filename , compress_image_resolution() );

            }else{

                $filename   = 'EGP-Channel-Image-'.time().'.'.$file->getClientOriginalExtension();
                Image::make($file)->save(base_path().'/public/uploads/EGP-Channel/'.$filename );
            }

            $inputs +=  ['image' => $filename ];
        }

        if($request->hasFile('player_image')){

            $file = $request->player_image;

            if(compress_image_enable() == 1){

                $filename   = 'EGP-Channel-Player-Image-'.time().'.'. compress_image_format();
                Image::make($file)->save(base_path().'/public/uploads/EGP-Channel/'.$filename , compress_image_resolution() );

            }else{

                $filename   = 'EGP-Channel-Player-Image-'.time().'.'.$file->getClientOriginalExtension();
                Image::make($file)->save(base_path().'/public/uploads/EGP-Channel/'.$filename );
            }

            $inputs +=  ['player_image' => $filename ];
        }

        if($request->hasFile('logo')){

            $file = $request->logo;

            if(compress_image_enable() == 1){

                $filename   = 'EGP-Channel-logo-'.time().'.'. compress_image_format();
                Image::make($file)->save(base_path().'/public/uploads/EGP-Channel/'.$filename , compress_image_resolution() );

            }else{

                $filename   = 'EGP-Channel-logo-'.time().'.'.$file->getClientOriginalExtension();
                Image::make($file)->save(base_path().'/public/uploads/EGP-Channel/'.$filename );
            }

            $inputs +=  ['logo' => $filename ];
        }

        if($request->hasFile('intro_video')){

            $file = $request->intro_video;

            $filename = 'EGP-Channel-intro-video-'.time().'.'. $file->getClientOriginalName();
            $path = public_path().'/uploads/EGP-Channel/';

            $file->move($path, $filename);

            $inputs +=  ['intro_video' => $filename ];
        }

        AdminEGPChannel::create($inputs) ;

        return redirect()->route('admin.EGP-Channel.index')->with('message', 'New  EGP Channel successfully.');
    }

    public function edit(Request $request,$id)
    {
        try {

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

                return View::make('admin.expired_dashboard', $data);

            }else if(check_storage_exist() == 0){

                $settings = Setting::first();

                $data = array(
                    'settings' => $settings,
                );

                return View::make('admin.expired_storage', $data);

            }else{

                $Admin_EGP_Channel =  AdminEGPChannel::where('id',$id)->get()->map(function ($item) {
                    $item['image_url'] = $item->image != null ? URL::to('public/uploads/EGP-Channel/'.$item->image ) : default_vertical_image_url() ;
                    $item['Player_image_url'] = $item->player_image != null ?  URL::to('public/uploads/EGP-Channel/'.$item->player_image ) : default_horizontal_image_url();
                    $item['Logo_url'] = $item->logo != null ?  URL::to('public/uploads/EGP-Channel/'.$item->logo ) : default_vertical_image_url();
                    $item['Intro_videos_url'] = $item->logo != null ?  URL::to('public/uploads/EGP-Channel/'.$item->intro_video ) : null ;
                    return $item;
                })->first();

                $data = array(
                    'button_text' => 'Update' ,
                    'Admin_EGP_Channel' => $Admin_EGP_Channel ,
                );

                return View::make('admin.EGP_Channels.edit',$data);
            }

        } catch (\Throwable $th) {

            return abort(404);
        }
    }

    public function update(Request $request,$id)
    {
        $inputs = array( 
            'name'          =>  $request->name ,
            "slug"          =>  $request->slug == null  ? Str::slug($request->name)  : Str::slug($request->slug)  ,
            'description'   =>  $request->description ,
        );
        
        if($request->hasFile('image')){

            $file = $request->image;

            if(compress_image_enable() == 1){

                $filename   = 'EGP-Channel-Image-'.time().'.'. compress_image_format();
                Image::make($file)->save(base_path().'/public/uploads/EGP-Channel/'.$filename , compress_image_resolution() );

            }else{

                $filename   = 'EGP-Channel-Image-'.time().'.'.$file->getClientOriginalExtension();
                Image::make($file)->save(base_path().'/public/uploads/EGP-Channel/'.$filename );
            }

            $inputs +=  ['image' => $filename ];
        }

        if($request->hasFile('player_image')){

            $file = $request->player_image;

            if(compress_image_enable() == 1){

                $filename   = 'EGP-Channel-Player-Image-'.time().'.'. compress_image_format();
                Image::make($file)->save(base_path().'/public/uploads/EGP-Channel/'.$filename , compress_image_resolution() );

            }else{

                $filename   = 'EGP-Channel-Player-Image-'.time().'.'.$file->getClientOriginalExtension();
                Image::make($file)->save(base_path().'/public/uploads/EGP-Channel/'.$filename );
            }

            $inputs +=  ['player_image' => $filename ];
        }

        if($request->hasFile('logo')){

            $file = $request->logo;

            if(compress_image_enable() == 1){

                $filename   = 'EGP-Channel-logo-'.time().'.'. compress_image_format();
                Image::make($file)->save(base_path().'/public/uploads/EGP-Channel/'.$filename , compress_image_resolution() );

            }else{

                $filename   = 'EGP-Channel-logo-'.time().'.'.$file->getClientOriginalExtension();
                Image::make($file)->save(base_path().'/public/uploads/EGP-Channel/'.$filename );
            }

            $inputs +=  ['logo' => $filename ];
        }

        if($request->hasFile('intro_video')){

            $file = $request->intro_video;

            $filename = 'EGP-Channel-intro-video-'.time().'.'. $file->getClientOriginalName();
            $path     = public_path().'/uploads/EGP-Channel/';
            $file->move($path, $filename);

            $inputs +=  ['intro_video' => $filename ];
        }

        AdminEGPChannel::find($id)->update($inputs) ;
        
        return back()->with('message', 'Updated EGP Channel successfully.');

    }

    public function destroy(Request $request,$id)
    {
        try {

            AdminEGPChannel::delete($id);
            
        } catch (\Throwable $th) {

            return abort(404);
        }
    }

    public function slug_validation(Request $request)
    {
            $slug = $request->get('slug');

            $button_type = $request->get('button_type');

            if($button_type == "Update"){

                $slug = AdminEGPChannel::where('slug',$slug)->get();

                $message = (count($slug) < 2) ?  "true" : "false";

            }elseif($button_type == "Add New"){

                $slug = AdminEGPChannel::where('slug',$slug)->first();
                $message = ($slug == null) ?  "true" : "false";
            }
            
            return $message;
    }
}

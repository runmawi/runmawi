<?php

namespace App\Http\Controllers;

use \Redirect as Redirect;
use Illuminate\Http\Request;
use URL;
use Auth;
use Hash;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use View;
use Validator;
use App\Artist as Artist;
use DB;
use App\SystemSetting as SystemSetting;
use App\User as User;
use Session;
use App\Setting as Setting;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;

class ChannelArtistsController extends Controller
{
    public function index(Request $request)
    {
        $data = Session::all();
        if (!empty($data['password_hash'])) {
        $package_id = auth()->user()->id;
        $user_package =     User::where('id', $package_id)->first();
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
            return View::make('admin.expired_dashboard', $data);
        }else{
            dd('index');
        if($package == "Pro" || $package == "Business" || $package == "" && Auth::User()->role =="admin"){

            $user = Session::get('channel'); 
            $user_id = $user->id;

      $search_value = $request->get('s');
        
        if(!empty($search_value)):
            $artists = Artist::where('artist_name', 'LIKE', '%'.$search_value.'%')->orderBy('created_at', 'desc')->paginate(9);
        else:
            $artists = Artist::orderBy('created_at', 'DESC')->paginate(9);
        endif;
        

        $data = array(
            'artists' => $artists,
            'user' => $user,
            );

        return View::make('admin.artist.index', $data);
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

    public function create()
    {
        $data = Session::all();
        if (!empty($data['password_hash'])) {
        $package_id = auth()->user()->id;
        $user_package =     User::where('id', $package_id)->first();
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
            return View::make('admin.expired_dashboard', $data);
        }else{
        if($package == "Pro" || $package == "Business" || $package == "" && Auth::User()->role =="admin"){

            $user = Session::get('channel'); 
            $user_id = $user->id;

        $data = array(
            'headline' => '<i class="fa fa-plus-circle"></i> New Artist',
            'post_route' => URL::to('channel/artists/store'),
            'button_text' => 'Add New Artist',
            );
        return View::make('channel.artist.create_edit', $data);
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

     public function store(Request $request)
    {
        $data = Session::all();

        if (!empty($data['password_hash'])) {

            $package_id = auth()->user()->id;
            $user_package =     User::where('id', $package_id)->first();
            $package = $user_package->package;

            if($package == "Pro" || $package == "Business" || $package == "" && Auth::User()->role =="admin"){
                    $data = $request->all();

                    $user = Session::get('channel'); 
                    $user_id = $user->id;

                    $image_path = public_path().'/uploads/artists/';
                    $image = (isset($data['image'])) ? $data['image'] : '';

                    if(!empty($image)){  
                        if($image != ''  && $image != null){
                            $file_old = $image_path.$image;
                            if (file_exists($file_old)){
                                unlink($file_old);
                            }
                        }
                        //upload new file
                        $file = $image;
                        $data['image'] = str_replace(' ', '_', $file->getClientOriginalName());
                        $file->move($image_path, $data['image']);

            } else {
                $data['image']  = 'default.jpg';
            } 
        

            if($data['artist_slug'] == null ){

                $artist_slug = preg_replace('/\s+/', '_', $data['artist_name']);
            }else{
                $artist_slug = preg_replace('/\s+/', '_', $data['artist_slug']);
            }

            $artist = Artist::create([
                "artist_name" => $data['artist_name'] ,
                "description" => $data['description'] ,
                "image"       => $data['image'] ,
                "artist_slug" => $artist_slug ,
            ]);

            $artist_id = $artist->id;

        return Redirect::to('channel/artists')->with(array('message' => 'New Artist Successfully Added!', 'note_type' => 'success') );
       
        }else if($package == "Basic"){
            return view('blocked');
        }
        }
        else{
            $system_settings = SystemSetting::first();
            $user = User::where('id','=',1)->first();
            return view('auth.login',compact('system_settings','user'));

        }
    }

    public function edit($id)
    {
        $data = Session::all();
        if (!empty($data['password_hash'])) {
        $package_id = auth()->user()->id;
        $user_package =     User::where('id', $package_id)->first();
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
            return View::make('admin.expired_dashboard', $data);
        }else{
        if($package == "Pro" || $package == "Business" || $package == "" && Auth::User()->role =="admin"){

            $user = Session::get('channel'); 
            $user_id = $user->id;

        $artist = Artist::find($id);

        $data = array(
            'headline' => '<i class="fa fa-edit"></i> Edit Artist',
            'artist' => $artist,
            'post_route' => URL::to('channel/artists/update'),
            'button_text' => 'Update Artist',
            );

        return View::make('channel.artist.create_edit', $data);
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

    public function update(Request $request)
    {
        $data = Session::all();

        if (!empty($data['password_hash'])) {

            $package_id = auth()->user()->id;
            $user_package =     User::where('id', $package_id)->first();
            $package = $user_package->package;

            if($package == "Pro" || $package == "Business" || $package == "" && Auth::User()->role =="admin"){

                $user = Session::get('channel'); 
                $user_id = $user->id;

                $data = $request->all();
                $id = $request->id;
                $artist = Artist::findOrFail($id);
                $image_path = public_path().'/uploads/artists/';
                $image = (isset($data['image'])) ? $data['image'] : '';

                if(empty($data['image'])){
                    unset($data['image']);
                }
                else {
                    if($image != ''  && $image != null){
                        $file_old = $image_path.$image;
                        if (file_exists($file_old)){
                            unlink($file_old);
                        }
                    }
                    $file = $image;
                    $data['image'] = str_replace(' ', '_', $file->getClientOriginalName());
                    $file->move($image_path, $data['image']);
                }

            if($data['artist_slug'] == null ){

                $artist_slug = preg_replace('/\s+/', '_', $data['artist_name']);
            }else{
                $artist_slug = preg_replace('/\s+/', '_', $data['artist_slug']);
            }
            
           
                $artist->update([
                    "artist_name" => $data['artist_name'] ,
                    "description" => $data['description'] ,
                    "artist_slug" => $artist_slug ,
                ]);

                if(!empty($data['image'])){
                    $artist->update([
                        "image"   =>  $data['image']  ,
                    ]);
                }

            return Redirect::to('channel/artists/edit' . '/' . $id)->with(array('message' => 'Successfully Updated Artist!', 'note_type' => 'success') );
        
            }else if($package == "Basic"){
                return view('blocked');
            }
        }else{
            $system_settings = SystemSetting::first();
            $user = User::where('id','=',1)->first();
            return view('auth.login',compact('system_settings','user'));
        }
    }

    public function destroy($id)
    {
        $data = Session::all();
        if (!empty($data['password_hash'])) {
        $package_id = auth()->user()->id;
        $user_package =     User::where('id', $package_id)->first();
        $package = $user_package->package;

        if($package == "Pro" || $package == "Business" || $package == "" && Auth::User()->role =="admin"){

            $user = Session::get('channel'); 
            $user_id = $user->id;

        $artist = Artist::find($id);

        $this->deleteArtistImages($artist);

        Artist::destroy($id);

        return Redirect::to('admin/artists')->with(array('message' => 'Successfully Deleted Artist', 'note_type' => 'success') );
    }else if($package == "Basic"){

        return view('blocked');

    }
}else{
    $system_settings = SystemSetting::first();
    $user = User::where('id','=',1)->first();
    return view('auth.login',compact('system_settings','user'));

  }
}

    private function deleteArtistImages($artist){
        $ext = pathinfo($artist->image, PATHINFO_EXTENSION);
        if(file_exists(public_path().'/uploads/artists/' . $artist->image) && $artist->image != 'placeholder.jpg'){
            @unlink(public_path().'/uploads/artists/' . $artist->image);
        }
    }

    public function artist_slug_validation(Request $request)
    {
            $artist_slug = $request->get('artist_slug');

            $button_type = $request->get('button_type');


            if($button_type == "Update Artist"){

                $artist_slug = Artist::where('artist_slug',$artist_slug)->get();

                $message = (count($artist_slug) < 2) ?  "true" : "false";

            }elseif($button_type == "Add New Artist"){

                $artist_slug = Artist::where('artist_slug',$artist_slug)->first();
                $message = ($artist_slug == null) ?  "true" : "false";
            }
            
            return $message;
    }
}

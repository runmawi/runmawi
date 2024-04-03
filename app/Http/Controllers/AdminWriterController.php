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

class AdminWriterController extends Controller
{
    public function index(Request $request)
    {
        if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
            return redirect('/admin/restrict');
    }
        $data = Session::all();
        if (!Auth::guest()) {
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
        }else if(check_storage_exist() == 0){
            $settings = Setting::first();

            $data = array(
                'settings' => $settings,
            );

            return View::make('admin.expired_storage', $data);
        }else{
        if($package == "Pro" || $package == "Business" || $package == "" && Auth::User()->role =="admin"){

      $search_value = $request->get('s');
        
        if(!empty($search_value)):
            $artists = Artist::where('artist_type','Writer')->where('artist_name', 'LIKE', '%'.$search_value.'%')->orderBy('created_at', 'desc')->paginate(9);
        else:
            $artists = Artist::where('artist_type','Writer')->orderBy('created_at', 'DESC')->paginate(9);
        endif;
        
        $user = Auth::user();

        $data = array(
            'artists' => $artists,
            'user' => $user,
            'admin_user' => Auth::user()
            );

        return View::make('admin.artist.writer.index', $data);
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
        if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
            return redirect('/admin/restrict');
    }
        $data = Session::all();
        if (!Auth::guest()) {
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
        }else if(check_storage_exist() == 0){
            $settings = Setting::first();

            $data = array(
                'settings' => $settings,
            );

            return View::make('admin.expired_storage', $data);
        }else{
        if($package == "Pro" || $package == "Business" || $package == "" && Auth::User()->role =="admin"){
        $data = array(
            'headline' => '<i class="fa fa-plus-circle"></i> New Artist',
            'post_route' => URL::to('admin/Writer/store'),
            'button_text' => 'Add New Writer',
            'admin_user' => Auth::user(),
            );
        return View::make('admin.artist.writer.create_edit', $data);
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

        if (!Auth::guest()) {

            $package_id = auth()->user()->id;
            $user_package =     User::where('id', $package_id)->first();
            $package = $user_package->package;

            if($package == "Pro" || $package == "Business" || $package == "" && Auth::User()->role =="admin"){
                    $data = $request->all();
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

                        if(compress_image_enable() == 1){
    
                            $artist_filename  = time().'.'.compress_image_format();
                            $artist_image     =  'Artist_'.$artist_filename ;
                            Image::make($file)->save(base_path().'/public/uploads/artists/'.$artist_image,compress_image_resolution() );
                        }else{
        
                            $artist_filename  = time().'.'.$image->getClientOriginalExtension();
                            $artist_image     =  'Artist_'.$artist_filename ;
                            Image::make($file)->save(base_path().'/public/uploads/artists/'.$artist_image );
                        }  

                        $data['image'] = $artist_image ;

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
                "artist_type" => $request->artist_type,
                "artist_slug" => $artist_slug ,
            ]);

            $artist_id = $artist->id;

        return Redirect::to('admin/Writer')->with(array('message' => 'New Writer Successfully Added!', 'note_type' => 'success') );
       
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
        if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
            return redirect('/admin/restrict');
    }
        $data = Session::all();
        if (!Auth::guest()) {
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
        }else if(check_storage_exist() == 0){
            $settings = Setting::first();

            $data = array(
                'settings' => $settings,
            );

            return View::make('admin.expired_storage', $data);
        }else{
        if($package == "Pro" || $package == "Business" || $package == "" && Auth::User()->role =="admin"){
        $artist = Artist::find($id);

        $data = array(
            'headline' => '<i class="fa fa-edit"></i> Edit Artist',
            'artist' => $artist,
            'post_route' => URL::to('admin/Writer/update'),
            'button_text' => 'Update Writer',
            'admin_user' => Auth::user(),
            );

        return View::make('admin.artist.writer.create_edit', $data);
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

        if (!Auth::guest()) {

            $package_id = auth()->user()->id;
            $user_package =     User::where('id', $package_id)->first();
            $package = $user_package->package;

            if($package == "Pro" || $package == "Business" || $package == "" && Auth::User()->role =="admin"){

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

                    if(compress_image_enable() == 1){
    
                        $artist_filename  = time().'.'.compress_image_format();
                        $artist_image     =  'Artist_'.$artist_filename ;
                        Image::make($file)->save(base_path().'/public/uploads/artists/'.$artist_image,compress_image_resolution() );
                    }else{
    
                        $artist_filename  = time().'.'.$artist_image->getClientOriginalExtension();
                        $artist_image     =  'Artist_'.$artist_filename ;
                        Image::make($file)->save(base_path().'/public/uploads/artists/'.$artist_image );
                    }  

                    $data['image'] = $artist_image ;
                }

            if($data['artist_slug'] == null ){

                $artist_slug = preg_replace('/\s+/', '_', $data['artist_name']);
            }else{
                $artist_slug = preg_replace('/\s+/', '_', $data['artist_slug']);
            }
            
           
                $artist->update([
                    "artist_name" => $data['artist_name'] ,
                    "description" => $data['description'] ,
                    "artist_type" => $data['artist_type'] ,
                    "artist_slug" => $artist_slug ,
                ]);

                if(!empty($data['image'])){
                    $artist->update([
                        "image"   =>  $data['image']  ,
                    ]);
                }

            return Redirect::to('admin/Writer/edit' . '/' . $id)->with(array('message' => 'Successfully Updated Writer!', 'note_type' => 'success') );
        
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
        if (!Auth::guest()) {
        $package_id = auth()->user()->id;
        $user_package =     User::where('id', $package_id)->first();
        $package = $user_package->package;

        if($package == "Pro" || $package == "Business" || $package == "" && Auth::User()->role =="admin"){
        $artist = Artist::find($id);

        $this->deleteArtistImages($artist);

        Artist::destroy($id);

        return Redirect::to('admin/Writer')->with(array('message' => 'Successfully Deleted Writer', 'note_type' => 'success') );
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

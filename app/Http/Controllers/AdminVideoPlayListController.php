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
use App\AdminVideoPlaylist as AdminVideoPlaylist;
use App\VideoPlaylist as VideoPlaylist;

class AdminVideoPlayListController extends Controller
{
      
      public function index(){

        if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
          return redirect('/admin/restrict');
      }
      
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
        }else if(check_storage_exist() == 0){
          $settings = Setting::first();

          $data = array(
              'settings' => $settings,
          );

          return View::make('admin.expired_storage', $data);
      }else{
        $AdminVideoPlaylist = AdminVideoPlaylist::get();
          
          $data = array (
            'AdminVideoPlaylist'=>$AdminVideoPlaylist
          );
          

        return view('admin.videos.playlist.index',$data);
        }
      }
    
      public function store(Request $request){
          
            $input = $request->all();
          
          $validatedData = $request->validate([
            'title' => 'required|max:255',
            ]);
          
            $s = new AdminVideoPlaylist();
           
            $path = public_path().'/uploads/images/';
        
            $image = $request['image']; 
          
            $slug = $request['slug']; 

            $input['user_id'] = Auth::user()->id; 
                      
          if ( $slug != '') {
              $input['slug']  =  str_replace(' ', '_',  $request['slug']);
          } else {
               $input['slug']  = str_replace(' ', '_', $request['title']);
          } 

          $input['title'] = $request['title']; 

          
           if($image != '') {   
          //code for remove old file
              if($image != ''  && $image != null){
                   $file_old = $path.$image;
                  if (file_exists($file_old)){
                   unlink($file_old);
                  }
              }

              $file = $image;

              if(compress_image_enable() == 1){

                $video_playlist_filename  = time().'.'.compress_image_format();
                $video_playlist_image     =  'video_playlist_'.$video_playlist_filename ;
                Image::make($file)->save(base_path().'/public/uploads/images/'.$video_playlist_image,compress_image_resolution() );
  
              }else{
  
                $video_playlist_filename  = time().'.'.compress_image_format();
                $video_playlist_image     =  'video_playlist_'.$video_playlist_filename ;
                Image::make($file)->save(base_path().'/public/uploads/images/'.$video_playlist_image );
              }  
                   
              $input['image'] = $video_playlist_image ;
  
            } else {
               $input['image']  = 'default.jpg';
           }

           $input['description'] = $request['description'];

           AdminVideoPlaylist::create($input);

            return back()->with('message', 'New Video PlayList added successfully.');
    }
    
      public function edit($id){
         
            $Playlist = AdminVideoPlaylist::where('id', '=', $id)->first();

            $AdminVideoPlaylist = AdminVideoPlaylist::all();

            return view('admin.videos.playlist.edit',compact('Playlist','AdminVideoPlaylist'));
        }
    
    
     public function update(Request $request){
           
        $input = $request->all();

        $path = public_path().'/uploads/images/';
           
        $id = $request['id'];
        $AdminVideoPlaylist = AdminVideoPlaylist::find($id);

        $slug = $request['slug']; 

          $image = $request->image;

          if( isset($image) && $image!= '' && !empty($request['image'])) {   
            
            if ($image != ''  && $image != null) {   //code for remove old file
                $file_old = $path.$image;
                if (file_exists($file_old)){
                  unlink($file_old);
                }
            }

            $file = $image;

            if(compress_image_enable() == 1){

              $video_playlist_filename  = time().'.'.compress_image_format();
              $video_playlist_image     =  'video_playlist_'.$video_playlist_filename ;
              Image::make($file)->save(base_path().'/public/uploads/images/'.$video_playlist_image,compress_image_resolution() );

            }else{

              $video_playlist_filename  = time().'.'.compress_image_format();
              $video_playlist_image     =  'video_playlist_'.$video_playlist_filename ;
              Image::make($file)->save(base_path().'/public/uploads/images/'.$video_playlist_image );
            }  
                 
            $AdminVideoPlaylist->image = $video_playlist_image ;

          }
          

            $AdminVideoPlaylist->title = $request['title'];
            $AdminVideoPlaylist->slug = $request['slug'];
            $AdminVideoPlaylist->description = $request['description'];
            $AdminVideoPlaylist->user_id  = Auth::user()->id; 

            if ( $AdminVideoPlaylist->slug != '') {
              $AdminVideoPlaylist->slug  =str_replace(' ', '_',  $request['slug']);
            } else {
               $AdminVideoPlaylist->slug  = str_replace(' ', '_', $request['title']);
            }

            $AdminVideoPlaylist->save();
            
            return Redirect::to('admin/videos/playlist')->with(array('message' => 'Successfully Updated Playlist', 'note_type' => 'success') );
            
    }
    
    
    public function destroy($id){
        
        AdminVideoPlaylist::destroy($id);
        VideoPlaylist::where("playlist_id", $id)->delete();

        return Redirect::to('admin/videos/playlist')->with(array('message' => 'Successfully Deleted Playlist', 'note_type' => 'success') );
    }
    
    
    
    
    
}

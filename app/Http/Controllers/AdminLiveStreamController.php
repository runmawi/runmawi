<?php

namespace App\Http\Controllers;
use \App\User as User;
use \Redirect as Redirect;
use Illuminate\Http\Request;
use URL;
use App\LiveStream as LiveStream;
use App\LiveCategory as LiveCategory;
use App\VideoResolution as VideoResolution;
use App\VideosSubtitle as VideosSubtitle;
use App\Language as Language;
use App\Subtitle as Subtitle;
use App\Setting as Setting;
use App\Tag as Tag;
use Auth;
use Hash;
use Illuminate\Support\Facades\Cache;
use Image;
use View;


class AdminLiveStreamController extends Controller
{
    
    public function index()
        {
           
            // exit();
            // dd();
            

            if(!empty($search_value)):
                $videos = LiveStream::where('title', 'LIKE', '%'.$search_value.'%')->orderBy('created_at', 'desc')->paginate(9);
            else:
                $videos = LiveStream::orderBy('created_at', 'DESC')->paginate(9);
            endif;
        
            $user = Auth::user();

            $data = array(
                'videos' => $videos,
                'user' => $user,
                'admin_user' => Auth::user()
                );

            return View('admin.livestream.index', $data);
        }
    /**
     * Show the form for creating a new video
     *
     * @return Response
     */
       public function create()
        {
            $data = array(
                'headline' => '<i class="fa fa-plus-circle"></i> New Video',
                'post_route' => URL::to('admin/livestream/store'),
                'button_text' => 'Add New Video',
                'admin_user' => Auth::user(),
                'video_categories' => LiveCategory::all(),
                'languages' => Language::all(),
                );
            return View::make('admin.livestream.create_edit', $data);
        }
    
       /**
     * Store a newly created video in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        
        
        
        $data = $request->all();
        
        // dd($data);
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|max:255',
            'description' => 'required',
            'details' => 'required|max:255',
            'year' => 'required'
        ]);
       
        $image = (isset($data['image'])) ? $data['image'] : '';
        $mp4_url = (isset($data['mp4_url'])) ? $data['mp4_url'] : '';
        
        $data['mp4_url']  = $request->get('mp4_url');
        
        $path = public_path().'/uploads/livecategory/';
        
        $image_path = public_path().'/uploads/images/';
          
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
              $data['image']  = $file->getClientOriginalName();
              $file->move($image_path, $data['image']);

         } 
        
       
        $data['user_id'] = Auth::user()->id;
        
//        unset($data['tags']);
        
        if(empty($data['active'])){
            $data['active'] = 0;
        }  
        
        if(empty($data['mp4_url'])){
            $data['mp4_url'] = 0;
        }   else {
            $data['mp4_url'] =  $data['mp4_url'];
        }
        
        if(empty($data['year'])){
            $data['year'] = 0;
        }  else {
            $data['year'] =  $data['year'];
        } 
        
        if(empty($data['id'])){
            $data['id'] = 0;
        }  
        
       

        if(empty($data['featured'])){
            $data['featured'] = 0;
        }  
        
        if(empty($data['status'])){
            $data['status'] = 0;
        }  
        if(empty($data['banner'])){
            $data['banner'] = 0;
        }  
        if(empty($data['ppv_price'])){
            $data['ppv_price'] = null;
        }  
        if(empty($data['access'])){
            $data['access'] = 0;
        }  
        if(isset($data['duration'])){
                //$str_time = $data
                $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $data['duration']);
                sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                $data['duration'] = $time_seconds;
        }
        // $settings = Setting::first();
        // if(!empty($data['ppv_price'])){
        //     $ppv_price = $data['ppv_price'] ;
        // }elseif($settings->ppv_status == 1){
        //     $ppv_price = $settings->ppv_price;
        // }else{
        //     $ppv_price = null;
        // }

        if(empty($data['ppv_price'])){
            $settings = Setting::where('ppv_status','=',1)->first();
            if(!empty($settings)){
                $ppv_price = $settings->ppv_price;
            }
            }  else {
                $ppv_price = $data['ppv_price'];
            }  
        $movie = new LiveStream;

        $movie->title =$data['title'];
        $movie->details =$data['details'];
        $movie->video_category_id =$data['video_category_id'];
        $movie->description =$data['description'];
        $movie->featured =$data['featured'];
        $movie->language =$data['language'];
        $movie->banner =$data['banner'];
        $movie->duration =$data['duration'];
        $movie->ppv_price =$ppv_price;
        $movie->access =$data['access'];
        // $movie->footer =$data['footer'];
        $movie->slug =$data['slug'];
        $movie->publish_type =$data['publish_type'];
        $movie->publish_time =$data['publish_time'];
        $movie->image =$file->getClientOriginalName();
        $movie->mp4_url =$data['mp4_url'];
        $movie->year =$data['year'];
        $movie->active = 1 ;
        $movie->user_id =Auth::User()->id;
        $movie->save();

        // $movie = LiveStream::create($data);
      
        $shortcodes = $request['short_code'];
        $languages = $request['language'];

     
        
         return Redirect::to('admin/livestream')->with(array('message' => 'New PPV Video Successfully Added!', 'note_type' => 'success') );
    }
    
    
    public function edit($id)
    {
       $video = LiveStream::find($id);
        
        

        $data = array(
            'headline' => '<i class="fa fa-edit"></i> Edit Video',
            'video' => $video,
            'post_route' => URL::to('admin/livestream/update'),
            'button_text' => 'Update Video',
            'admin_user' => Auth::user(),
            'video_categories' => LiveCategory::all(),
            'languages' => Language::all(),
            );

        return View::make('admin.livestream.edit', $data); 
    }
    
    public function destroy($id)
    {
    //  LiveStream::destroy($id);
     LiveStream::destroy($id);

        return Redirect::back(); 
    }
     public function update(Request $request)
    {
        $data = $request->all();       
        $id = $data['id'];
        $video = LiveStream::findOrFail($id);  
        
         $validatedData = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|max:255',
            'description' => 'required',
            'details' => 'required|max:255',
            'year' => 'required'
        ]);
        
           $image = ($request->file('image')) ? $request->file('image') : '';
           $mp4_url = (isset($data['mp4_url'])) ? $data['mp4_url'] : '';
        
        if(empty($data['active'])){
            $data['active'] = 0;
        } 
       
        if(empty($data['ppv_status'])){
            $data['ppv_status'] = 0;
        }
        if(empty($data['slug'])){
            $data['slug'] = 0;
        }
        
        if(empty($data['rating'])){
            $data['rating'] = 0;
        }
        
        if(empty($data['year'])){
            $data['year'] = 0;
        }

        if(empty($data['featured'])){
            $data['featured'] = 0;
        }  
        
         if(empty($data['status'])){
            $data['status'] = 0;
        }  
        
        if(empty($data['type'])){
            $data['type'] = '';
        }
        


        
        $path = public_path().'/uploads/livecategory/';
        $image_path = public_path().'/uploads/images/';
          
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
              $data['image']  = $file->getClientOriginalName();
              $file->move($image_path, $data['image']);

         } 
       
         $data['mp4_url']  = $request->get('mp4_url');

         if(isset($data['duration'])){
                //$str_time = $data
                $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $data['duration']);
                sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                $data['duration'] = $time_seconds;
        }

       
         $shortcodes = $request['short_code'];
         $languages = $request['language'];

         $data['ppv_price'] = $request['ppv_price'];
         $data['access'] = $request['access'];
         $data['active'] = 1 ;


        $video->update($data);
        
        $video->publish_status = $request['publish_status'];
        $video->publish_type = $request['publish_type'];
        $video->publish_time = $request['publish_time'];
        $video->save();
        // dd($request['publish_time']);
        return Redirect::to('admin/livestream/edit' . '/' . $id)->with(array('message' => 'Successfully Updated Video!', 'note_type' => 'success') );
    }
    
    public function CPPLiveVideosIndex()
    {

        // $videos = LiveStream::orderBy('created_at', 'DESC')->paginate(9);
        $videos =    LiveStream::where('active', '=',0)
            ->join('moderators_users', 'moderators_users.id','=','live_streams.user_id')
            ->select('moderators_users.username', 'live_streams.*')
            ->orderBy('live_streams.created_at', 'DESC')->paginate(9);
            // dd($videos);
            $data = array(
                'videos' => $videos,
                );

            return View('admin.livestream.livevideoapproval.live_video_approval', $data);
       }
       public function CPPLiveVideosApproval($id)
       {
           $video = LiveStream::findOrFail($id);
           $video->active = 1;
           $video->save();
           return Redirect::back()->with('message','Your video will be available shortly after we process it');

          }

          public function CPPLiveVideosReject($id)
          {
            $video = LiveStream::findOrFail($id);
            $video->active = 2;
            $video->save();            
            return Redirect::back()->with('message','Your video will be available shortly after we process it');
 
             }
    
}

<?php

namespace App\Http\Controllers;
use \App\User as User;
use \Redirect as Redirect;
use Illuminate\Http\Request;
use URL;
use App\PpvVideo as PpvVideo;
use App\PpvCategory as PpvCategory;
use App\VideoResolution as VideoResolution;
use App\VideosSubtitle as VideosSubtitle;
use App\Language as Language;
use App\Subtitle as Subtitle;
use App\Tag as Tag;
use Auth;
use Hash;
use Illuminate\Support\Facades\Cache;
use Image;
use View;

class AdminPpvController extends Controller
{
    public function index()
        {

          // $search_value = Request::get('s');

        $all = PpvVideo::all();
            if(!empty($search_value)):
                $videos = PpvVideo::where('title', 'LIKE', '%'.$search_value.'%')->orderBy('created_at', 'desc')->paginate(9);
            else:
                $videos = PpvVideo::orderBy('created_at', 'DESC')->paginate(9);
            endif;
        
            $user = Auth::user();

            $data = array(
                'videos' => $videos,
                'user' => $user,
                'admin_user' => Auth::user()
                );

            return View('admin.ppv.index', $data);
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
                'post_route' => URL::to('admin/ppv/store'),
                'button_text' => 'Add New Video',
                'admin_user' => Auth::user(),
                'video_categories' => PpvCategory::all(),
                'video_subtitle' => VideosSubtitle::all(),
                'languages' => Language::all(),
                'subtitles' => Subtitle::all(),
                );
            return View::make('admin.ppv.create_edit', $data);
        }
    
    
           /**
     * Store a newly created video in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        
        
        $data = $request->all();
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|max:255',
            'description' => 'required',
            'details' => 'required|max:255',
            'year' => 'required'
        ]);
       
        $image = (isset($data['image'])) ? $data['image'] : '';
        $trailer = (isset($data['trailer'])) ? $data['trailer'] : '';
        $mp4_url = (isset($data['video_upload'])) ? $data['video_upload'] : '';
        $files = (isset($data['subtitle_upload'])) ? $data['subtitle_upload'] : '';
              /* logo upload */
        
        $path = public_path().'/uploads/videos/';
        
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
        
        
        if($trailer != '') {   
              //code for remove old file
              if($trailer != ''  && $trailer != null){
                   $file_old = $path.$trailer;
                  if (file_exists($file_old)){
                   unlink($file_old);
                  }
              }
              //upload new file
              $file = $trailer;
              $trailer_vids  = $file->getClientOriginalName();
              $file->move($path, $trailer_vids);
            
              $data['trailer']  = URL::to('/').'/public/uploads/ppv/'.$file->getClientOriginalName();

         } 
        
        if($mp4_url != '') {   
              //code for remove old file
              if($mp4_url != ''  && $mp4_url != null){
                   $file_old = $path.$mp4_url;
                  if (file_exists($file_old)){
                   unlink($file_old);
                  }
              }
              //upload new file
              $file = $mp4_url;
             $video_upload  = $file->getClientOriginalName();
              $file->move($path,$video_upload);
            
              $data['mp4_url']  = URL::to('/').'/public/uploads/ppv/'.$file->getClientOriginalName();

         }
        
         
      
//        $tags = $data['tags'];
        
        $data['user_id'] = Auth::user()->id;
        
//        unset($data['tags']);
        
        if(empty($data['active'])){
            $data['active'] = 0;
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
        
        if(empty($data['type'])){
            $data['type'] = '';
        }
        
        if(Auth::user()->role =='admin' && Auth::user()->sub_admin == 0 ){
                $data['status'] = 1;    
            }
        
        if( Auth::user()->role =='admin' && Auth::user()->sub_admin == 1 ){
                $data['status'] = 0;    
        }
        

        if(isset($data['duration'])){
                //$str_time = $data
                $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $data['duration']);
                sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                $data['duration'] = $time_seconds;
        }

    
        $movie = PpvVideo::create($data);
      
        $shortcodes = $request['short_code'];
        $languages = $request['language'];

        if(!empty( $files != ''  && $files != null))
            {
                foreach ($files as $key => $val) {
                    if(!empty($files[$key])){

                        $destinationPath ='public/uploads/subtitles/';
                        $filename = $movie->id. '-'.$shortcodes[$key].'.vtt';
                        $files[$key]->move($destinationPath, $filename);
                        $subtitle_data['sub_language'] = $languages[$key]; 
                        $subtitle_data['shortcode'] = $shortcodes[$key]; 
                        $subtitle_data['url'] = URL::to('/').'/public/uploads/subtitles/'.$filename; 
                        $movie_subtitle = VideosSubtitle::create($subtitle_data);
                    }
                }
            }
        
         return Redirect::to('admin/ppv')->with(array('note' => 'New PPV Video Successfully Added!', 'note_type' => 'success') );
    }
    
     public function destroy($id)
    {
        $video = PpvVideo::find($id);

       

        PpvVideo::destroy($id);
//        VideoResolution::where('video_id', '=', $id)->delete();
//        VideoSubtitle::where('video_id', '=', $id)->delete();

        return Redirect::to('admin/ppv')->with(array('note' => 'Successfully Deleted Video', 'note_type' => 'success') );
    }
    
    
    public function edit($id)
    {
       $video = PpvVideo::find($id);
        
        

        $data = array(
            'headline' => '<i class="fa fa-edit"></i> Edit Video',
            'video' => $video,
            'post_route' => URL::to('admin/ppv/update'),
            'button_text' => 'Update Video',
            'admin_user' => Auth::user(),
            'video_categories' => PpvCategory::all(),
            'video_subtitle' => VideosSubtitle::all(),
            'subtitles' => Subtitle::all(),
            'languages' => Language::all(),
            );

        return View::make('admin.ppv.create_edit', $data); 
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request)
    {
        $data = $request->all();       
        $id = $data['id'];
        $video = PpvVideo::findOrFail($id);  
        
         $validatedData = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|max:255',
            'description' => 'required',
            'details' => 'required|max:255',
            'year' => 'required'
        ]);
        
           $image = ($request->file('image')) ? $request->file('image') : '';
           $trailer = (isset($data['trailer'])) ? $data['trailer'] : '';
           $mp4_url = (isset($data['video_upload'])) ? $data['video_upload'] : '';
           $files = (isset($data['subtitle_upload'])) ? $data['subtitle_upload'] : '';
        
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
        
        if(Auth::user()->role =='admin' && Auth::user()->sub_admin == 0 ){
                $data['status'] = 1;    
            }
        
        if( Auth::user()->role =='admin' && Auth::user()->sub_admin == 1 ){
                $data['status'] = 0;    
        }


        
        $path = public_path().'/uploads/ppv/';
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
        
        
        if($trailer != '') {   
              //code for remove old file
              if($trailer != ''  && $trailer != null){
                   $file_old = $path.$trailer;
                  if (file_exists($file_old)){
                   unlink($file_old);
                  }
              }
              //upload new file
              $file = $trailer;
              $trailer_vids  = $file->getClientOriginalName();
              $file->move($path, $trailer_vids);
              $data['trailer']  = URL::to('/').'/public/uploads/ppv/'.$file->getClientOriginalName();

         } 
        
         if($mp4_url != '') {   
              //code for remove old file
              if($mp4_url != ''  && $mp4_url != null){
                   $file_old = $path.$mp4_url;
                  if (file_exists($file_old)){
                   unlink($file_old);
                  }
              }
              //upload new file
              $file = $mp4_url;
             $video_upload  = $file->getClientOriginalName();
              $file->move($path,$video_upload);
            
              $data['mp4_url']  = URL::to('/').'/public/uploads/ppv/'.$file->getClientOriginalName();

         }
        
          
      
        if(isset($data['duration'])){
                //$str_time = $data
                $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $data['duration']);
                sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                $data['duration'] = $time_seconds;
        }

       
         $shortcodes = $request['short_code'];
         $languages = $request['language'];


        $video->update($data);
        
        if(!empty( $files != ''  && $files != null))
        {
            foreach ($files as $key => $val) {
                if(!empty($files[$key])){
                    
                    $destinationPath ='public/uploads/subtitles/';
                    $filename = $movie->id. '-'.$shortcodes[$key].'.vtt';
                    $files[$key]->move($destinationPath, $filename);
                    $subtitle_data['sub_language'] = $languages[$key]; 
                    $subtitle_data['shortcode'] = $shortcodes[$key]; 
                    $subtitle_data['url'] = URL::to('/').'/public/uploads/subtitles/'.$filename; 
                    $video_subtitle = VideoSubtitle::updateOrCreate(array('shortcode' => 'en','video_id' => $id), $subtitle_data);
                }
            }
        }

        return Redirect::to('admin/ppv/edit' . '/' . $id)->with(array('note' => 'Successfully Updated Video!', 'note_type' => 'success') );
    }

    
    
    
    
}

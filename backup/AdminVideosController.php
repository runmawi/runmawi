<?php

namespace App\Http\Controllers;
use \App\User as User;
use \Redirect as Redirect;
use Illuminate\Http\Request;
use URL;
use App\Test as Test;
use App\Video as Video;
use App\VideoCategory as VideoCategory;
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
use Validator;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg as FFMpeg;
use FFMpeg\FFProbe;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;
use App\Jobs\ConvertVideoForStreaming;
use Illuminate\Contracts\Filesystem\Filesystem;
use FFMpeg\Filters\Video\VideoFilters;
use Illuminate\Support\Str;

class AdminVideosController extends Controller
{
    public function index()
    {
       
      // $search_value = Request::get('s');
        
        if(!empty($search_value)):
            $videos = Video::where('title', 'LIKE', '%'.$search_value.'%')->orderBy('created_at', 'desc')->paginate(9);
        else:
            $videos = Video::orderBy('created_at', 'DESC')->paginate(9);
        endif;
        
        $user = Auth::user();

        $data = array(
            'videos' => $videos,
            'user' => $user,
            'admin_user' => Auth::user()
            );

        return View('admin.videos.index', $data);
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
            'post_route' => URL::to('admin/videos/store'),
            'button_text' => 'Add New Video',
            'admin_user' => Auth::user(),
            'video_categories' => VideoCategory::all(),
            'video_subtitle' => VideosSubtitle::all(),
            'languages' => Language::all(),
            'subtitles' => Subtitle::all(),
            );
        return View::make('admin.videos.create_edit', $data);
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
                'title' => 'required',
                'slug' => 'required',
                'description' => 'required',
                'details' => 'required',
                'year' => 'required',
                'image' => 'required'
            ]);
        
        
           $image = (isset($data['image'])) ? $data['image'] : '';
           $trailer = (isset($data['trailer'])) ? $data['trailer'] : '';
           $mp4_url = (isset($data['video'])) ? $data['video'] : '';
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
              $randval = Str::random(16);
              $file = $trailer;
              $trailer_vid  = $randval.'.'.$request->file('trailer')->extension();
              $file->move($path, $trailer_vid);
              $data['trailer']  = URL::to('/').'/public/uploads/videos/'.$trailer_vid;

         }else {
            $data['trailer'] = '';
        }
        
        if($mp4_url != '') {
            
              $rand = Str::random(16);
        
                $path = $rand . '.' . $request->video->getClientOriginalExtension();
                $request->video->storeAs('public', $path);

                $lowBitrateFormat = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(500);
                $midBitrateFormat  =(new X264('libmp3lame', 'libx264'))->setKiloBitrate(1500);
                $highBitrateFormat = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(3000);

                $converted_name = $this->getCleanFileName($path);

                // open the uploaded video from the right disk...
                FFMpeg::fromDisk("public")
                    ->open($path)
                    ->addFilter(function ($filters) {
                        $filters->resize(new Dimension(960, 540));
                    })
                    ->export()
                    ->toDisk('local')
                    ->inFormat($lowBitrateFormat)
                    ->save($converted_name);
                    $data['mp4_url']  = 'hhh';

         }
        
    //        print_r($data['mp4_url']);
    //        exit;
      
       // $tags = $data['tags'];
        
        $data['user_id'] = Auth::user()->id;
        
        //unset($data['tags']);
        
        if(empty($data['active'])){
            $data['active'] = 0;
        } 
        
        
        if(empty($data['year'])){
            $data['year'] = 0;
        }  else {
            $data['year'] =  $data['year'];
        } 
        
       
        
        if(empty($data['slug'])){
            $data['slug'] = 0;
        }

        if(empty($data['featured'])){
            $data['featured'] = 0;
        }  
        
        if(empty($data['type'])){
            $data['type'] = '';
        }
        
         if(empty($data['status'])){
            $data['status'] = 0;
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

    
        $movie = Video::create($data);
      
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
                    $movie_subtitle = MovieSubtitle::create($subtitle_data);
                }
            }
        }
        
          return redirect('admin/videos')
            ->with(
                'message',
                'Your video will be available shortly after we process it'
            );
        
         //return Redirect::to('admin/videos')->with(array('note' => 'New Video Successfully Added!', 'note_type' => 'success') );
    }
    
    public function destroy($id)
    {
        $video = Video::find($id);

       

        Video::destroy($id);
//        VideoResolution::where('video_id', '=', $id)->delete();
//        VideoSubtitle::where('video_id', '=', $id)->delete();

        return Redirect::to('admin/videos')->with(array('note' => 'Successfully Deleted Video', 'note_type' => 'success') );
    }
    
    
    public function edit($id)
    {
       $video = Video::find($id);
        
        

        $data = array(
            'headline' => '<i class="fa fa-edit"></i> Edit Video',
            'video' => $video,
            'post_route' => URL::to('admin/videos/update'),
            'button_text' => 'Update Video',
            'admin_user' => Auth::user(),
            'video_categories' => VideoCategory::all(),
            'video_subtitle' => VideosSubtitle::all(),
            'subtitles' => Subtitle::all(),
            'languages' => Language::all(),
            );

        return View::make('admin.videos.create_edit', $data); 
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
        
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|max:255',
            'description' => 'required',
            'details' => 'required|max:255',
            'year' => 'required'
        ]);
        
       
        $id = $data['id'];
        
        $video = Video::findOrFail($id);

        
           $image = (isset($data['image'])) ? $data['image'] : '';
           $trailer = (isset($data['trailer'])) ? $data['trailer'] : '';
           $mp4_url2 = (isset($data['video'])) ? $data['video'] : '';
           $files = (isset($data['subtitle_upload'])) ? $data['subtitle_upload'] : '';
            
        if(empty($data['active'])){
            $data['active'] = 0;
        }  
        
        if(empty($data['slug'])){
            $data['slug'] = 0;
        } 
        


        if(empty($data['featured'])){
            $data['featured'] = 0;
        }  
        
        if(empty($data['rating'])){
            $data['rating'] = 0;
        }  
        
        
        
        if(empty($data['year'])){
            $data['year'] = 0;
        }  
        
        if(empty($data['type'])){
            $data['type'] = '';
        }
        
         if(empty($data['status'])){
            $data['status'] = 0;
        }  
        
        if(Auth::user()->role =='admin' && Auth::user()->sub_admin == 0 ){
                $data['status'] = 1;    
            }
        
        if( Auth::user()->role =='admin' && Auth::user()->sub_admin == 1 ){
                $data['status'] = 0;    
        }


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
              $randval = Str::random(16);
              $file = $trailer;
              $trailer_vid  = $randval.'.'.$request->file('trailer')->extension();
              $file->move($path, $trailer_vid);
              $data['trailer']  = URL::to('/').'/public/uploads/videos/'.$trailer_vid;

         } else {
             $data['trailer'] = $video->trailer;
         } 
        
        if(!empty($mp4_url2) && $mp4_url2 != '') {   
              //code for remove old file
              if($mp4_url2 != ''  && $mp4_url2 != null){
                   $file_old3 = $path.$mp4_url2;
                  if (file_exists($file_old3)){
                   unlink($file_old3);
                  }
              }
              //upload new file
              $file3 = $mp4_url2;
              $mp4_url1  = $file3->getClientOriginalName();
              $file3->move($path, $mp4_url1);
              $data['mp4_url']  = URL::to('/').'/public/uploads/videos/'.$file3->getClientOriginalName();

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

        return Redirect::to('admin/videos/edit' . '/' . $id)->with(array('note' => 'Successfully Updated Video!', 'note_type' => 'success') );
    }

    private function getCleanFileName($filename){
        return preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename) . '.mp4';
    }
    
    
}

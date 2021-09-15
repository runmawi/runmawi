<?php

namespace App\Http\Controllers;
use \App\User as User;
use \Redirect as Redirect;
use Illuminate\Http\Request;
use URL;
use File;
use App\Test as Test;
use App\Video as Video;
use App\MoviesSubtitles as MoviesSubtitles;
use App\VideoCategory as VideoCategory;
use App\VideoResolution as VideoResolution;
use App\VideosSubtitle as VideosSubtitle;
use App\Language as Language;
use App\VideoLanguage as VideoLanguage;
use App\Subtitle as Subtitle;
use App\Tag as Tag;
use Auth;
use Hash;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use View;
use Validator;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use FFMpeg\FFProbe;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\Format\Video\X264;
use App\Http\Requests\StoreVideoRequest;
use App\Jobs\ConvertVideoForStreaming;
use Illuminate\Contracts\Filesystem\Filesystem;
use FFMpeg\Filters\Video\VideoFilters;
use Illuminate\Support\Str;
use App\Artist;
use App\Videoartist;
use GifCreator\GifCreator;


class AdminVideosController extends Controller
{
    public function index()
    {
           if (!Auth::user()->role == 'admin')
            {
                return redirect('/home');
            }
       
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
    public function uploadFile(Request $request){

        $value = array();
        $data = $request->all();

        $validator = Validator::make($request->all(), [
           'file' => 'required|mimes:video/mp4,video/x-m4v,video/*'
           
        ]);
        $mp4_url = (isset($data['file'])) ? $data['file'] : '';
        
        $path = public_path().'/uploads/videos/';
        
        
        $file = $request->file->getClientOriginalName();
        $newfile = explode(".mp4",$file);
        $file_folder_name = $newfile[0];
   
        
        
        $mp4_url = $data['file'];
        
        if($mp4_url != '') {
        $ffprobe = \FFMpeg\FFProbe::create();
        $disk = 'public';
        $data['duration'] = $ffprobe->streams($request->file)
        ->videos()
        ->first()                  
        ->get('duration'); 
        
        $rand = Str::random(16);
        $path = $rand . '.' . $request->file->getClientOriginalExtension();
        $request->file->storeAs('public', $path);
        $thumb_path = 'public';
        
        // $this->build_video_thumbnail($request->file,$path, $data['slug']);
        
         $original_name = ($request->file->getClientOriginalName()) ? $request->file->getClientOriginalName() : '';
         $storepath  = URL::to('/storage/app/public/'.$file_folder_name.'/'.$original_name);
        
         $video = new Video();
         $video->disk = 'public';
         $video->title = $file_folder_name;
         $video->original_name = 'public';
         $video->path = $storepath;
         $video->draft = 0;
         $video->save(); 
        
         $video_id = $video->id;
       $video_title = Video::find($video_id);
       $title =$video_title->title; 


        $value['success'] = 1;
        $value['message'] = 'Uploaded Successfully!';
        $value['video_id'] = $video_id;
        $value['video_title'] = $title;

        
        return $value;
        
        }
        
        else {
         $value['success'] = 2;
         $value['message'] = 'File not uploaded.'; 
            // $video = Video::create($data);
        return response()->json($value);
        
        }

        // return response()->json($value);
        }
        
  
     /**
     * Show the form for creating a new video
     *
     * @return Response
     */
    public function create()
    {
         if (!Auth::user()->role == 'admin')
            {
                return redirect('/home');
            }
        $data = array(
            'headline' => '<i class="fa fa-plus-circle"></i> New Video',
            'post_route' => URL::to('admin/videos/fileupdate'),
            'button_text' => 'Add New Video',
            'admin_user' => Auth::user(),
            'video_categories' => VideoCategory::all(),
            'video_subtitle' => VideosSubtitle::all(),
            'languages' => Language::all(),
            'subtitles' => Subtitle::all(),
            'artists' => Artist::all(),
            'video_artist' => [],
            );
        return View::make('admin.videos.fileupload', $data);
                    // 'post_route' => URL::to('admin/videos/store'),


        // return View::make('admin.videos.create_edit', $data);
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
            ]);
           $image = (isset($data['image'])) ? $data['image'] : '';
           $trailer = (isset($data['trailer'])) ? $data['trailer'] : '';
           $mp4_url = (isset($data['video'])) ? $data['video'] : '';
           $files = (isset($data['subtitle_upload'])) ? $data['subtitle_upload'] : '';
              /* logo upload */
        
           $path = public_path().'/uploads/videos/';
           $image_path = public_path().'/uploads/images/';
          
           $image = (isset($data['image'])) ? $data['image'] : '';
           $trailer = (isset($data['trailer'])) ? $data['trailer'] : '';
           $mp4_url = (isset($data['video'])) ? $data['video'] : '';
           $files = (isset($data['subtitle_upload'])) ? $data['subtitle_upload'] : '';
              /* logo upload */
        
          $path = public_path().'/uploads/videos/';
          $image_path = public_path().'/uploads/images/';
          if(!empty($data['artists'])){
            $artistsdata = $data['artists'];
            unset($data['artists']);
        }
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

         } else {
             $data['image']  = 'default.jpg';
         } 
        
          if ($request->slug != '') {
                    $data['slug'] = $this->createSlug($request->slug);
            }

            if($request->slug == ''){
                    $data['slug'] = $this->createSlug($data['title']);    
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
            $data['trailer'] = '';
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
        
        if(empty($data['access'])){
            $data['access'] = 0;
        }  else {
            $data['access'] =  $data['access'];
        }  
        
        
        if(empty($data['language'])){
            $data['language'] = 0;
        }  else {
            $data['language'] =  $data['language'];
        } 
        
         if(!empty($data['embed_code'])){
            $data['embed_code'] = $data['embed_code'];
        } else {
            $data['embed_code'] = '';
        }
        
            if ($request->slug != '') {
                    $data['slug'] = $this->createSlug($request->slug);
            }

            if($request->slug == ''){
                    $data['slug'] = $this->createSlug($data['title']);    
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
        
        if(empty($data['path'])){
            $data['path'] = 0;
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


        if(!empty($data['embed_code'])) {
             
             $video = new Video();
             $video->disk = 'public';
             $video->original_name = 'public';
             $video->path = $path;
             $video->title = $data['title'];
             $video->slug = $data['slug'];
             $video->language = $data['language'];
             $video->image = $data['image'];
             $video->trailer = $data['trailer'];
             $video->mp4_url = $path;
             $video->type = $data['type'];
             $video->access = $data['access'];
             $video->embed_code = $data['embed_code'];
             $video->video_category_id = $data['video_category_id'];
             $video->details = $request->details;
             $video->description = strip_tags($request->description);
             $video->user_id = Auth::user()->id;
             $video->save();

        }

        
        
         if($mp4_url != '') {
            $ffprobe = \FFMpeg\FFProbe::create();
            $disk = 'public';
            $data['duration'] = $ffprobe->streams($request->video)
            ->videos()
            ->first()                  
            ->get('duration'); 




            $rand = Str::random(16);
            $path = $rand . '.' . $request->video->getClientOriginalExtension();
            $request->video->storeAs('public', $path);
            $thumb_path = 'public';

            $this->build_video_thumbnail($request->video,$path, $data['slug']);
            
             $original_name = ($request->video->getClientOriginalName()) ? $request->video->getClientOriginalName() : '';

             
             $video = new Video();
             $video->disk = 'public';
             $video->original_name = 'public';
             $video->path = $rand;
             $video->title = $data['title'];
             $video->slug = $data['slug'];
             $video->language = $data['language'];
             $video->image = $data['image'];
             $video->trailer = $data['trailer'];
             $video->mp4_url = $path;
             $video->type = $data['type'];
             $video->access = $data['access'];
             $video->video_category_id = $data['video_category_id'];
             $video->details = $data['details'];
             $video->duration = $data['duration'];
             $video->description = strip_tags($data['description']);
             $video->user_id = Auth::user()->id;
             $video->save(); 
            
             $lowBitrateFormat = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(500);
             $midBitrateFormat  =(new X264('libmp3lame', 'libx264'))->setKiloBitrate(1500);
             $highBitrateFormat = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(3000);
             $converted_name = ConvertVideoForStreaming::handle($path);

             ConvertVideoForStreaming::dispatch($video);

         } else {
              
               $video = Video::create($data);
         }
        
        $shortcodes = $request['short_code'];
        $languages=$request['sub_language'];
       /* $languages =$request['language'];*/
       /* $languages = $subtitle->language;*/
        if(!empty( $files != ''  && $files != null)){
       /* if($request->hasFile('subtitle_upload'))
        {
            $vid = $movie->id;
            $files = $request->file('subtitle_upload');
*/
    
            foreach ($files as $key => $val) {
                if(!empty($files[$key])){
                    // $movie_sub = new MovieSubtitle;
                    // $destinationPath ='public/uploads/subtitles/';
                    // $filename = $movie->id. '-'.$shortcodes[$key].'.vtt';
                    // $files[$key]->move($destinationPath, $filename);
                    // $movie_sub->sub_language = $destinationPath.$filename; 
                    // $movie_sub->movie_id = $vid; 
                    // $movie_sub->shortcode = $shortcodes[$key]; 
                    // $movie_sub->url = URL::to('/').'/public/uploads/subtitles/'.$filename; 
                    //  $subtitle_data['sub_language'] = $languages[$key]; 
                    // $subtitle_data['shortcode'] = $shortcodes[$key]; 
                    // $subtitle_data['url'] = URL::to('/').'/public/uploads/subtitles/'.$filename; 
                    //  $video_subtitle = VideoSubtitle::updateOrCreate(array('shortcode' => 'en','video_id' => $id), $subtitle_data);
                    // $movie_subtitle = MovieSubtitle::create($subtitle_data);
                    // $movie_sub->save();
                    $destinationPath ='public/uploads/subtitles/';
                    $filename = $video->id. '-'.$shortcodes[$key].'.srt';
                    $files[$key]->move($destinationPath, $filename);
                    $subtitle_data['video_id'] = $video->id;

                    $subtitle_data['sub_language']=$languages[$key];
                    $subtitle_data['shortcode'] = $shortcodes[$key]; 
                    $subtitle_data['url'] = URL::to('/').'/public/uploads/subtitles/'.$filename; 
                    $video_subtitle = VideosSubtitle::create($subtitle_data);
                }
            }
        }
    
if(!empty($artistsdata)){
            foreach ($artistsdata as $key => $value) {
                $artist = new Videoartist;
                $artist->video_id = $video->id;
                $artist->artist_id = $value;
                $artist->save();
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
        Videoartist::where('video_id',$id)->delete();
        return Redirect::to('admin/videos')->with(array('note' => 'Successfully Deleted Video', 'note_type' => 'success') );
    }
    
    
    public function edit($id)
    {
        if (!Auth::user()->role == 'admin')
        {
            return redirect('/home');
        }
        
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
            'artists' => Artist::all(),
            'video_artist' => Videoartist::where('video_id', $id)->pluck('artist_id')->toArray(),
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
         if (!Auth::user()->role == 'admin')
        {
            return redirect('/home');
        }
        
        $data = $request->all();
        
        $validatedData = $request->validate([
            'title' => 'required|max:255'
        ]);
        
       
            $id = $data['id'];
            $video = Video::findOrFail($id);
            if($request->slug == ''){
                $data['slug'] = $this->createSlug($data['title']);    
            }
        
           $image = (isset($data['image'])) ? $data['image'] : '';
           $trailer = (isset($data['trailer'])) ? $data['trailer'] : '';
           $mp4_url2 = (isset($data['video'])) ? $data['video'] : '';
           $files = (isset($data['subtitle_upload'])) ? $data['subtitle_upload'] : '';
        
           $update_mp4 = $request->get('video');
            if(empty($data['active'])){
            $data['active'] = 0;
            } 
        

         if(empty($data['webm_url'])){
            $data['webm_url'] = 0;
            }  else {
                $data['webm_url'] =  $data['webm_url'];
            }  

            if(empty($data['ogg_url'])){
                $data['ogg_url'] = 0;
            }  else {
                $data['ogg_url'] =  $data['ogg_url'];
            }  

            if(empty($data['year'])){
                $data['year'] = 0;
            }  else {
                $data['year'] =  $data['year'];
            }   
        
            if(empty($data['language'])){
                $data['language'] = 0;
            }  else {
                $data['language'] = $data['language'];
            } 
        
    
//        if(empty($data['featured'])){
//            $data['featured'] = 0;
//        }  
            if(empty($data['featured'])){
                $data['featured'] = 0;
            } 
             if(!empty($data['embed_code'])){
                $data['embed_code'] = $data['embed_code'];
            } 


            if(empty($data['active'])){
                $data['active'] = 0;
            } 
              if(empty($data['video_gif'])){
                $data['video_gif'] = '';
            }
           
            if(empty($data['type'])){
                $data['type'] = '';
            }

             if(empty($data['status'])){
                $data['status'] = 0;
            }   

//            if(empty($data['path'])){
//                $data['path'] = 0;
//            }  

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

         } else {
             $data['image'] = $video->image;
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
        
         if(isset($data['duration'])){
                //$str_time = $data
                $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $data['duration']);
                sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                $data['duration'] = $time_seconds;
        }

        if( $mp4_url2 != ''){   

            $ffprobe = \FFMpeg\FFProbe::create();
            $disk = 'public';
            $data['duration'] = $ffprobe->streams($request->video)
            ->videos()
            ->first()                  
            ->get('duration'); 



              //code for remove old file
                $rand = Str::random(16);
                $path = $rand . '.' . $request->video->getClientOriginalExtension();
                $request->video->storeAs('public', $path);
                $data['mp4_url'] = $path;
                $data['path'] = $rand;

                $thumb_path = 'public';
                $this->build_video_thumbnail($request->video,$path, $data['slug']);
             
            // $original_name = ($request->video->getClientOriginalName()) ? $request->video->getClientOriginalName() : '';
                $original_name = URL::to('/').'/storage/app/public/'.$path;
                $lowBitrateFormat = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(500);
                $midBitrateFormat  =(new X264('libmp3lame', 'libx264'))->setKiloBitrate(1500);
                $highBitrateFormat = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(3000);
                $converted_name = ConvertVideoForStreaming::handle($path);

                ConvertVideoForStreaming::dispatch($video);
               

         }
        
      
       
          if(!empty($data['embed_code'])) {
             $video->embed_code = $data['embed_code'];
        }else {
            $video->embed_code = '';
        }

         $shortcodes = $request['short_code'];        
         $languages=$request['sub_language'];
         $video->description = strip_tags($data['description']);
         $video->update($data);

         if(!empty($data['artists'])){
            $artistsdata = $data['artists'];
            unset($data['artists']);
            /*save artist*/
            if(!empty($artistsdata)){
                Videoartist::where('video_id', $video->id)->delete();
                foreach ($artistsdata as $key => $value) {
                    $artist = new Videoartist;
                    $artist->video_id = $video->id;
                    $artist->artist_id = $value;
                    $artist->save();
                }

            }
        }

         if(!empty( $files != ''  && $files != null)){
        /*if($request->hasFile('subtitle_upload'))
        {
            $files = $request->file('subtitle_upload');*/
       
            foreach ($files as $key => $val) {
                if(!empty($files[$key])){
                    
                    $destinationPath ='public/uploads/subtitles/';
                    $filename = $video->id. '-'.$shortcodes[$key].'.srt';
                    $files[$key]->move($destinationPath, $filename);
                    $subtitle_data['sub_language'] =$languages[$key]; /*URL::to('/').$destinationPath.$filename; */
                    $subtitle_data['shortcode'] = $shortcodes[$key]; 
                    $subtitle_data['movie_id'] = $id;
                    $subtitle_data['url'] = URL::to('/').'/public/uploads/subtitles/'.$filename; 
                    $video_subtitle = MoviesSubtitles::updateOrCreate(array('shortcode' => 'en','movie_id' => $id), $subtitle_data);
                }
            }
        }


        return Redirect::to('admin/videos/edit' . '/' . $id)->with(array('note' => 'Successfully Updated Video!', 'note_type' => 'success') );
    }

    private function getCleanFileName($filename){
        return preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename) . '.mp4';
    }
    
    
               /* slug function for Video categoty */
    
     public function createSlug($title, $id = 0)
            {
                
                $slug = Str::slug($title);

                $allSlugs = $this->getRelatedSlugs($slug, $id);

                // If we haven't used it before then we are all good.
                if (! $allSlugs->contains('slug', $slug)){
                    return $slug;
                }

                // Just append numbers like a savage until we find not used.
                for ($i = 1; $i <= 10; $i++) {
                    $newSlug = $slug.'-'.$i;
                    if (! $allSlugs->contains('slug', $newSlug)) {
                        return $newSlug;
                    }
                }

                throw new \Exception('Can not create a unique slug');
            }

      protected function getRelatedSlugs($slug, $id = 0)
        {
            return Video::select('slug')->where('slug', 'like', $slug.'%')
                ->where('id', '<>', $id)
                ->get();
        }  



        public function build_video_thumbnail($video_path,$movie, $thumb_path) {

    // Create a temp directory for building.
            $temp = storage_path('app/public'). "/build";
            if (!file_exists($temp)) {
                File::makeDirectory($temp);
            }

    // Use FFProbe to get the duration of the video.
            $ffprobe = \FFMpeg\FFProbe::create();
            $duration = $ffprobe->streams($video_path)
            ->videos()
            ->first()                  
            ->get('duration'); 
    // If we couldn't get the direction or it was zero, exit.
            if (empty($duration)) {
                return;
            }

    // Create an FFMpeg instance and open the video.

    // This array holds our "points" that we are going to extract from the
    // video. Each one represents a percentage into the video we will go in
    // extracitng a frame. 0%, 10%, 20% ..
            $points = range(0, 100, 10);

    // This will hold our finished frames.
            $frames = [];

            foreach ($points as $point) {
            $video = FFMpeg::fromDisk('public')->open($movie);

        // Point is a percent, so get the actual seconds into the video.
                $time_secs = floor($duration * ($point / 100));

        // Created a var to hold the point filename.
                $point_file = "$temp/$point.jpg";
        // Extract the frame.
                $frame = $video->frame(TimeCode::fromSeconds($time_secs));
                $frame->save($point_file);

        // If the frame was successfully extracted, resize it down to
        // 320x200 keeping aspect ratio.
                if (file_exists($point_file)) {
                    $img = Image::make($point_file)->resize(150, 150, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $img->save($point_file, 40);
                    $img->destroy();
                }
        // If the resize was successful, add it to the frames array.
                if (file_exists($point_file)) {
                    $frames[] = $point_file;
                }
            }
    // If we have frames that were successfully extracted.
            if (!empty($frames)) {

        // We show each frame for 100 ms.
                $durations = array_fill(0, count($frames), 100);
        // Create a new GIF and save it.
                $gc = new GifCreator();
                $gc->create($frames, $durations, 0);
                file_put_contents(storage_path('app/public').'/'.$thumb_path.'.gif', $gc->getGif());

        // Remove all the temporary frames.
                foreach ($frames as $file) {
                    unlink($file);
                }
            }
        }
    





        public function fileupdate(Request $request)
        {
             if (!Auth::user()->role == 'admin')
            {
                return redirect('/home');
            }
            
            $data = $request->all();
            //    echo "<pre>";
        // print_r($data['age_restrict']);
        // exit();
            $validatedData = $request->validate([
                'title' => 'required|max:255'
            ]);
            
           
                $id = $data['video_id'];
                // echo "<pre>";
            
                $video = Video::findOrFail($id);
                // print_r($video);
        
                // exit();
                if($request->slug == ''){
                    $data['slug'] = $this->createSlug($data['title']);    
                }
            
               $image = (isset($data['image'])) ? $data['image'] : '';
               $trailer = (isset($data['trailer'])) ? $data['trailer'] : '';
               $files = (isset($data['subtitle_upload'])) ? $data['subtitle_upload'] : '';
            
                if(empty($data['active'])){
                $data['active'] = 0;
                } 
            
    
             if(empty($data['webm_url'])){
                $data['webm_url'] = 0;
                }  else {
                    $data['webm_url'] =  $data['webm_url'];
                }  
    
                if(empty($data['ogg_url'])){
                    $data['ogg_url'] = 0;
                }  else {
                    $data['ogg_url'] =  $data['ogg_url'];
                }  
    
                if(empty($data['year'])){
                    $data['year'] = 0;
                }  else {
                    $data['year'] =  $data['year'];
                }   
            
                if(empty($data['language'])){
                    $data['language'] = 0;
                }  else {
                    $data['language'] = $data['language'];
                } 
            
        
    //        if(empty($data['featured'])){
    //            $data['featured'] = 0;
    //        }  
                if(empty($data['featured'])){
                    $data['featured'] = 0;
                } 
                 if(!empty($data['embed_code'])){
                    $data['embed_code'] = $data['embed_code'];
                } 
    
    
                if(empty($data['active'])){
                    $data['active'] = 0;
                } 
                  if(empty($data['video_gif'])){
                    $data['video_gif'] = '';
                }
               
                if(empty($data['type'])){
                    $data['type'] = '';
                }
    
                 if(empty($data['status'])){
                    $data['status'] = 0;
                }   
    
    //            if(empty($data['path'])){
    //                $data['path'] = 0;
    //            }  
    
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
    
             } else {
                 $data['image'] = $video->image;
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
            
             if(isset($data['duration'])){
                    //$str_time = $data
                    $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $data['duration']);
                    sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                    $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                    $data['duration'] = $time_seconds;
            }
    

          
           
              if(!empty($data['embed_code'])) {
                 $video->embed_code = $data['embed_code'];
            }else {
                $video->embed_code = '';
            }
    
             $shortcodes = $request['short_code'];        
             $languages=$request['sub_language'];
             $video->description = strip_tags($data['description']);
             $video->draft = 1;
             $video->age_restrict =  $data['age_restrict'];
             $video->update($data);
    
             if(!empty($data['artists'])){
                $artistsdata = $data['artists'];
                unset($data['artists']);
                /*save artist*/
                if(!empty($artistsdata)){
                    Videoartist::where('video_id', $video->id)->delete();
                    foreach ($artistsdata as $key => $value) {
                        $artist = new Videoartist;
                        $artist->video_id = $video->id;
                        $artist->artist_id = $value;
                        $artist->save();
                    }
    
                }
            }
    
             if(!empty( $files != ''  && $files != null)){
            /*if($request->hasFile('subtitle_upload'))
            {
                $files = $request->file('subtitle_upload');*/
           
                foreach ($files as $key => $val) {
                    if(!empty($files[$key])){
                        
                        $destinationPath ='public/uploads/subtitles/';
                        $filename = $video->id. '-'.$shortcodes[$key].'.srt';
                        $files[$key]->move($destinationPath, $filename);
                        $subtitle_data['sub_language'] =$languages[$key]; /*URL::to('/').$destinationPath.$filename; */
                        $subtitle_data['shortcode'] = $shortcodes[$key]; 
                        $subtitle_data['movie_id'] = $id;
                        $subtitle_data['url'] = URL::to('/').'/public/uploads/subtitles/'.$filename; 
                        $video_subtitle = MoviesSubtitles::updateOrCreate(array('shortcode' => 'en','movie_id' => $id), $subtitle_data);
                    }
                }
            }
    
    
            return Redirect::back();
        }
    
}

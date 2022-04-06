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
use Session;
use Illuminate\Support\Str;
use App\Users as Users;
use App\LiveLanguage as LiveLanguage;
use App\CategoryLive as CategoryLive;
use App\RTMP;



class AdminLiveStreamController extends Controller
{
    
    public function index()
        {
            $Stream_key = Session::get('Stream_key');
            $Stream_error =Session::get('Stream_error');
            $Rtmp_url = Session::get('Rtmp_url');
            $title = Session::get('title');


            if(!empty($search_value)):
                $videos = LiveStream::where('title', 'LIKE', '%'.$search_value.'%')->orderBy('created_at', 'desc')->paginate(9);
            else:
                $videos = LiveStream::orderBy('created_at', 'DESC')->paginate(9);
            endif;
        
            $user = Auth::user();

            $data = array(
                'videos' => $videos,
                'user' => $user,
                'admin_user' => Auth::user(),
                'Settings'  => Setting::first(),
                'Video_encoder_Status' => '0',
                'Stream_key' => $Stream_key,
                'Stream_error' => $Stream_error ? $Stream_error : 0 ,
                'Rtmp_url'  => $Rtmp_url ? $Rtmp_url : null ,
                'title' => $title ? $title : null,
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
                'category_id' => [],
                'languages_id' => [],
                'liveStreamVideo_error' => '0',
                'Rtmp_urls' => RTMP::all(),
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

        $validatedData = $request->validate([
            // 'title' => 'required|max:255',
            // // 'slug' => 'required|max:255',
            // 'description' => 'required',
            // 'details' => 'required|max:255',
            // 'year' => 'required'
        ]);
       
        if(!empty($data['video_category_id'])){
            $category_id = $data['video_category_id'];
            unset($data['video_category_id']);
        }
        if(!empty($data['language'])){
            $languagedata = $data['language'];
            unset($data['language']);
        }

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
              $image = $file->getClientOriginalName();
         }else{
            $image = "Defualt.jpg";
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
            $status = 0;
        } else{
            $status = 1;
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
                // $ppv_price = $settings->ppv_price;
                $ppv_price = null;
            }else{
                $ppv_price = null;
            }
            } elseif(!empty($data['ppv_price'])) {
                $ppv_price = $data['ppv_price'];
            }  else{
                $ppv_price = null;                
            }
            if ( !empty($data['rating'])) {
                $rating  = $data['rating'];
            } else {
                $rating  = null;
            }

            if ($request->slug != '') {
                $data['slug'] = $this->createSlug($request->slug);
                }
    
        if($request->slug == ''){
                $data['slug'] = $this->createSlug($data['title']);    
        }
        if(empty($data['embed_url'])){
            $embed_url = null;
        }else{
            $embed_url = $data['embed_url'];
        }     
        if(empty($data['url_type'])){
            $url_type = null;
        }else{
            $url_type = $data['url_type'];
        }    
        if(empty($data['mp4_url'])){
            $mp4_url = null;
        }else{
            $mp4_url = $data['mp4_url'];
        }    

        $movie = new LiveStream;

// live stream video
        if(!empty($data['live_stream_video'])){
            $live_stream_video = $data['live_stream_video'];
            $live_stream_videopath  = URL::to('public/uploads/LiveStream/');
            $LiveStream_Video = $live_stream_video->getClientOriginalName();  
            $live_stream_video->move(public_path('uploads/LiveStream/'), $LiveStream_Video);


            // converting to RTMP URL
              try {
                $Stream_key = random_int(1000000000, 9999999999);

                $video_name = $LiveStream_Video;
                $live_stream_videopath  = URL::to('public/uploads/LiveStream/'.$video_name);
                $rtmp_url = "rtmp://176.223.138.157:1935/hls/".$Stream_key;

                $FFmeg_command = "ffmpeg -re -i ".$live_stream_videopath." -c:v libx264 -c:a aac -f flv ".$rtmp_url." 2>&1";
                $command = exec($FFmeg_command);

                if(strpos($command, "Qavg") !== false){
                    $movie->live_stream_video = $live_stream_videopath;
                    $movie->Stream_key = $Stream_key;
                } else{
                    $data = array(
                        'headline' => '<i class="fa fa-plus-circle"></i> New Video',
                        'post_route' => URL::to('admin/livestream/store'),
                        'button_text' => 'Add New Video',
                        'admin_user' => Auth::user(),
                        'video_categories' => LiveCategory::all(),
                        'languages' => Language::all(),
                        'category_id' => [],
                        'languages_id' => [],
                        'liveStreamVideo_error' => '1',
                        );
                    return View::make('admin.livestream.create_edit', $data);
                }
            } 
            catch (\Exception $e) {
                $data = array(
                    'headline' => '<i class="fa fa-plus-circle"></i> New Video',
                    'post_route' => URL::to('admin/livestream/store'),
                    'button_text' => 'Add New Video',
                    'admin_user' => Auth::user(),
                    'video_categories' => LiveCategory::all(),
                    'languages' => Language::all(),
                    'category_id' => [],
                    'languages_id' => [],
                    'liveStreamVideo_error' => '1',
                    );
                return View::make('admin.livestream.create_edit', $data);
            }
        }

        if(!empty($data['url_type']) && $data['url_type'] == "Encode_video" ){
            $Stream_key = random_int(1000000000, 9999999999);
            $movie->Stream_key = $Stream_key;
            $movie->Rtmp_url = $data['Rtmp_url'];
        }

        $movie->title =$data['title'];
        $movie->embed_url =$embed_url;
        $movie->url_type =$url_type;

        $movie->details =$data['details'];
        $movie->rating =$rating;
        // $movie->video_category_id =$data['video_category_id'];
        $movie->description =$data['description'];
        $movie->featured =$data['featured'];
        // $movie->language =$data['language'];
        $movie->banner =$data['banner'];
        $movie->duration =$data['duration'];
        $movie->ppv_price = $ppv_price;
        $movie->access =$data['access'];
        // $movie->footer =$data['footer'];
        $movie->slug =$data['slug'];
        $movie->publish_type =$data['publish_type'];
        $movie->publish_time =$data['publish_time'];
        $movie->image = $image;
        $movie->mp4_url =$mp4_url;
        $movie->status =$status;
        $movie->year =$data['year'];
        $movie->active = 1 ;
        $movie->user_id =Auth::User()->id;
        $movie->save();

        // $movie = LiveStream::create($data);
      
        $shortcodes = $request['short_code'];
        $languages = $request['language'];


            /*save CategoryLive*/
            if(!empty($category_id)){
                CategoryLive::where('live_id', $movie->id)->delete();
                foreach ($category_id as $key => $value) {
                    $category = new CategoryLive;
                    $category->live_id = $movie->id;
                    $category->category_id = $value;
                    $category->save();
                }

            }
        

            /*save LiveLanguage*/
            if(!empty($language_id)){
                LiveLanguage::where('live_id', $movie->id)->delete();
                foreach ($language_id as $key => $value) {
                    $serieslanguage = new LiveLanguage;
                    $serieslanguage->live_id = $movie->id;
                    $serieslanguage->language_id = $value;
                    $serieslanguage->save();
                }

            }

            if( $data['url_type'] == "Encode_video" ){
                return Redirect::to('admin/livestream') ->with([
                                                            'Stream_key' => $Stream_key,
                                                            'Stream_error' => '1' ,
                                                            'Rtmp_url' => $data['Rtmp_url'],
                                                            'title' => $data['title']
                                                        ]);
               
            }
            else{
                return Redirect::to('admin/livestream')->with(array('message' => 'New PPV Video Successfully Added!', 'note_type' => 'success') );
            }
        
    }
    
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
            return LiveStream::select('slug')->where('slug', 'like', $slug.'%')
                ->where('id', '<>', $id)
                ->get();
        }  

    public function edit($id)
    {
        $video = LiveStream::find($id);

        $Stream_key = Session::get('Stream_key');
        $Stream_error =Session::get('Stream_error');
        $Rtmp_url = Session::get('Rtmp_url');
        $title = Session::get('title');

        $data = array(
            'headline' => '<i class="fa fa-edit"></i> Edit Video',
            'video' => $video,
            'post_route' => URL::to('admin/livestream/update'),
            'button_text' => 'Update Video',
            'admin_user' => Auth::user(),
            'video_categories' => LiveCategory::all(),
            'languages' => Language::all(),
            'category_id' => CategoryLive::where('live_id', $id)->pluck('category_id')->toArray(),
            'languages_id' => LiveLanguage::where('live_id', $id)->pluck('language_id')->toArray(),
            'settings' => Setting::first(),
            'liveStreamVideo_error' => '0',
            'Rtmp_urls' => RTMP::all(),
            'Stream_key' => $Stream_key,
            'Stream_error' => $Stream_error ? $Stream_error : 0 ,
            'Rtmp_url'  => $Rtmp_url ? $Rtmp_url : null ,
            'title' => $title ? $title : null,
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
        if($data['access'] == "ppv"){
            $ppv_price = $data['ppv_price'];
        }else{
        // dd($data);

            $ppv_price = null;
        }
        $video = LiveStream::findOrFail($id);  

         $validatedData = $request->validate([
            'title' => 'required|max:255',
            // 'slug' => 'required|max:255',
            // 'description' => 'required',
            // 'details' => 'required|max:255',
            // 'year' => 'required'
        ]);
// Live Stream Video
        if(!empty($data['live_stream_video'])){
            $live_stream_video = $data['live_stream_video'];
            $live_stream_videopath  = URL::to('public/uploads/LiveStream/');
            $LiveStream_Video = $live_stream_video->getClientOriginalName();  
            $live_stream_video->move(public_path('uploads/LiveStream/'), $LiveStream_Video);
           

            // converting to RTMP URL
            try {
               

                $video_name = $LiveStream_Video;
                $live_stream_videopath  = URL::to('public/uploads/LiveStream/'.$video_name);
                $rtmp_url = "rtmp://176.223.138.157:1935/hls/".$Stream_key;

                $FFmeg_command = "ffmpeg -re -i ".$live_stream_videopath." -c:v libx264 -c:a aac -f flv ".$rtmp_url." 2>&1";
                $command = exec($FFmeg_command);

                if(strpos($command, "Qavg") !== false){
                    $video->live_stream_video =$live_stream_videopath;
                } else{
                    $data = array(
                        'headline' => '<i class="fa fa-edit"></i> Edit Video',
                        'video' => $video,
                        'post_route' => URL::to('admin/livestream/update'),
                        'button_text' => 'Update Video',
                        'admin_user' => Auth::user(),
                        'video_categories' => LiveCategory::all(),
                        'languages' => Language::all(),
                        'category_id' => CategoryLive::where('live_id', $id)->pluck('category_id')->toArray(),
                        'languages_id' => LiveLanguage::where('live_id', $id)->pluck('language_id')->toArray(),
                        'liveStreamVideo_error' => '1'
                        );
                    return View::make('admin.livestream.edit', $data); 
                }
            } 
            catch (\Exception $e) {
                $data = array(
                    'headline' => '<i class="fa fa-edit"></i> Edit Video',
                    'video' => $video,
                    'post_route' => URL::to('admin/livestream/update'),
                    'button_text' => 'Update Video',
                    'admin_user' => Auth::user(),
                    'video_categories' => LiveCategory::all(),
                    'languages' => Language::all(),
                    'category_id' => CategoryLive::where('live_id', $id)->pluck('category_id')->toArray(),
                    'languages_id' => LiveLanguage::where('live_id', $id)->pluck('language_id')->toArray(),
                    'liveStreamVideo_error' => '1'
                    );
                return View::make('admin.livestream.edit', $data); 
            }
        }

    // Video Encoder

            if(!empty($data['url_type']) && $video['url_type'] != "Encode_video" && $data['url_type'] == "Encode_video" ){
                $Stream_key = random_int(1000000000, 9999999999);
                $video->Stream_key = $Stream_key;
            }

            if(!empty($data['url_type']) && $data['url_type'] == "Encode_video" ){
                if($data['Rtmp_url'] !=null){
                    $video->Rtmp_url =  $data['Rtmp_url'];
                }
            }
        
           $image = ($request->file('image')) ? $request->file('image') : '';
           $mp4_url = (isset($data['mp4_url'])) ? $data['mp4_url'] : '';
        
        if(empty($data['active']) && $video->active == null){
            $data['active'] = 0;
        }else{
            $data['active'] = $video->active;
        } 
       
        if(empty($data['ppv_status'])){
            $data['ppv_status'] = 0;
        }
        if(empty($data['embed_url'])){
            $embed_url = null;
        }else{
            $embed_url = $data['embed_url'];
        }
        if ($request->slug != '') {
            $slug = str_replace(' ', '_', $request->slug);
            $data['slug'] =$slug;
            }

        if($request->slug == ''){
                $slug = str_replace(' ', '_', $request->title);
                $data['slug'] = $slug;    
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

        //  $data['ppv_price'] = $ppv_price;
         $data['access'] = $request['access'];
         $data['active'] = 1 ;


        $video->update($data);
        if ( !empty($request['rating'])) {
            $rating  = $request['rating'];
          } else {
               $rating  = null;
          }
          if(empty($data['url_type'])){
            $url_type = null;
        }else{
            $url_type = $data['url_type'];
        }   
        $video->rating = $rating;
        $video->url_type = $url_type;
        $video->ppv_price = $ppv_price;
        $video->publish_status = $request['publish_status'];
        $video->publish_type = $request['publish_type'];
        $video->publish_time = $request['publish_time'];
        $video->embed_url =     $embed_url;
        $video->save();

        if(!empty($data['video_category_id'])){
            $category_id = $data['video_category_id'];
            unset($data['video_category_id']);
            /*save artist*/
            if(!empty($category_id)){
                CategoryLive::where('live_id', $video->id)->delete();
                foreach ($category_id as $key => $value) {
                    $category = new CategoryLive;
                    $category->live_id = $video->id;
                    $category->category_id = $value;
                    $category->save();
                }

            }
        }
        if(!empty($data['language'])){
            $language_id = $data['language'];
            unset($data['language']);
            /*save artist*/
            if(!empty($language_id)){
                LiveLanguage::where('live_id', $video->id)->delete();
                foreach ($language_id as $key => $value) {
                    $serieslanguage = new LiveLanguage;
                    $serieslanguage->live_id = $video->id;
                    $serieslanguage->language_id = $value;
                    $serieslanguage->save();
                }

            }
        }
        // dd($request['publish_time']);

        if(!empty($data['url_type']) && $video['url_type'] == "Encode_video" &&  $data['url_type'] == "Encode_video"   ){

            return Redirect::to('admin/livestream/edit' . '/' . $id)->with(
                                                    [ 'Stream_key' => $video['Stream_key'],
                                                      'Stream_error' => '1',
                                                      'Rtmp_url' => $data['Rtmp_url'] ? $data['Rtmp_url'] : $video['rtmp_url']  ,
                                                      'title' => $data['title']
                                                    ]);
        }else{

            return Redirect::to('admin/livestream/edit' . '/' . $id)->with(array('message' => 'Successfully Updated Video!', 'note_type' => 'success') );
        }

    }
    
    public function CPPLiveVideosIndex()
    {

        // $videos = LiveStream::orderBy('created_at', 'DESC')->paginate(9);
        $videos =    LiveStream::where('active', '=',0)
            // ->join('moderators_users', 'moderators_users.id','=','live_streams.user_id')
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

<?php

namespace App\Http\Controllers;
use \App\User as User;
use \Redirect as Redirect;
use Illuminate\Http\Request;
use URL;
use Auth;
use Hash;
use View;
use Session;
use App\LiveStream as LiveStream;
use App\LiveCategory as LiveCategory;
use App\VideoResolution as VideoResolution;
use App\VideosSubtitle as VideosSubtitle;
use App\Language as Language;
use App\Subtitle as Subtitle;
use App\Setting as Setting;
use App\Tag as Tag;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use App\Users as Users;
use App\LiveEventArtist;
use App\LiveLanguage as LiveLanguage;
use App\CategoryLive as CategoryLive;
use App\RTMP;
use Streaming\Representation;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use App\InappPurchase;
use Intervention\Image\Facades\Image;
use Intervention\Image\Filters\DemoFilter;


class ChannelLiveEventArtist extends Controller
{

    public function __construct()
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
        }

    }
    

    public function index()
    {
        
        $Stream_key = Session::get('Stream_key');
        $Stream_error =Session::get('Stream_error');
        $Rtmp_url = Session::get('Rtmp_url');
        $title = Session::get('title');
        $hls_url = Session::get('hls_url');
       
        if(!empty($search_value)):
            $videos = LiveEventArtist::where('title', 'LIKE', '%'.$search_value.'%')->orderBy('created_at', 'desc')->paginate(9);
        else:
            $videos = LiveEventArtist::orderBy('created_at', 'DESC')->paginate(9);
        endif;
    
        $user = Session::get('channel'); 
        $id = $user->id;

        $data = array(
            'videos' => $videos,
            'user' => $user,
            'admin_user' => $user,
            'Settings'  => Setting::first(),
            'Video_encoder_Status' => '0',
            'Stream_key' => $Stream_key,
            'Stream_error' => $Stream_error ? $Stream_error : 0 ,
            'Rtmp_url'  => $Rtmp_url ? $Rtmp_url : null ,
            'title' => $title ? $title : null,
            'hls_url' => $hls_url ? $hls_url : null,
            );
            return View('channel.live_event_artist.index', $data);

    }

    public function create(Request $request){

        $user =  User::where('id',1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');

        if ($current_date > $duedate)
        {
            $client = new Client();
            $url = "https://flicknexs.com/userapi/allplans";
            $params = [ 'userid' => 0 ];
    
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
        }
        else{

            $user = Session::get('channel'); 
            $userid = $user->id;

            $data = array(
                'headline' => '<i class="fa fa-plus-circle"></i> New Video',
                'post_route' => URL::to('channel/live-event-store'),
                'button_text' => 'Add New Video',
                'admin_user' => $user,
                'video_categories' => LiveCategory::all(),
                'languages' => Language::all(),
                'category_id' => [],
                'languages_id' => [],
                'liveStreamVideo_error' => '0',
                'Rtmp_urls' => RTMP::all(),
                'InappPurchase' => InappPurchase::all(),
                'userid' => $userid,
                );
            return View('channel.live_event_artist.create', $data);
        }
    }

    public function store(Request $request)
    {
        $data = $request->all();

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
        

                            //  Image Upload
        $data['mp4_url']  = $request->get('mp4_url');
        
        $path = public_path().'/uploads/livecategory/';
        
        $image_path = public_path().'/uploads/images/';
          
         if($image != '') {   
             
                if($image != ''  && $image != null){
                    $file_old = $image_path.$image;  //code for remove old file
                    if (file_exists($file_old)){
                        unlink($file_old);
                    }
                }
              
                $file = $image;

                if(compress_image_enable() == 1){ 

                    $filename  = time().'.'.compress_image_format();    //upload new file
                    $PC_image     =  'live_'.$filename ;     

                    Image::make($file)->save(base_path().'/public/uploads/images/'.$PC_image,compress_image_resolution() );
                }else{

                    $filename  = time().'.'.$file->getClientOriginalExtension();
                    $PC_image     =  'live_'.$filename ;
                    Image::make($file)->save(base_path().'/public/uploads/images/'.$PC_image );
                }
         }else{
            $image = "Defualt.jpg";
         } 

                                //  Player Image
         $player_image = ($request->file('player_image')) ? $request->file('player_image') : '';

         $path = public_path().'/uploads/livecategory/';
         $image_path = public_path().'/uploads/images/';
           
          if($player_image != '') {   
               if($player_image != ''  && $player_image != null){
                    $file_old = $image_path.$player_image;
                   if (file_exists($file_old)){
                    unlink($file_old);
                   }
               }
               
                $player_image = $player_image;

                if(compress_image_enable() == 1){   //upload new file

                    $player_filename  = time().'.'.compress_image_format();
                    $player_PC_image     =  'live_'.$player_filename ;

                    Image::make($player_image)->save(base_path().'/public/uploads/images/'.$player_PC_image,compress_image_resolution() );
                }else{

                    $player_filename  = time().'.'.$player_image->getClientOriginalExtension();
                    $player_PC_image     =  'live_'.$player_filename ;
                    Image::make($player_image)->save(base_path().'/public/uploads/images/'.$player_PC_image );
                }

            } else{
                $player_image = "default_horizontal_image.jpg";
            }


        $user = Session::get('channel'); 
        $id = $user->id;
            
        $data['user_id'] = $user->id;
        
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
                $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $data['duration']);
                sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                $data['duration'] = $time_seconds;
        }

        if(empty($data['ppv_price'])){
            $settings = Setting::where('ppv_status','=',1)->first();
            if(!empty($settings)){
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

            if (!empty($data['searchtags'])) {
                $searchtags  = $data['searchtags'];
            } else {
                $searchtags  = null;
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

        $movie = new LiveEventArtist;

                                   //  TV Image
            $tv_image = ($request->file('tv_image')) ? $request->file('tv_image') : '';

            if($tv_image != '') {   
              
                $tv_image = $tv_image;

                if(compress_image_enable() == 1){   //upload new file

                    $tv_image_filename  = time().'.'.compress_image_format();
                    $tv_image_PC_image     =  'TV-live-'.$tv_image_filename ;
                    Image::make($tv_image)->save(base_path().'/public/uploads/images/'.$tv_image_PC_image,compress_image_resolution() );
                }else{

                    $tv_image_filename  = time().'.'.$tv_image->getClientOriginalExtension();
                    $tv_image_PC_image     =  'TV-live-'.$player_filename ;
                    Image::make($tv_image)->save(base_path().'/public/uploads/images/'.$tv_image_PC_image );
                }
                $movie->tv_image = $tv_image_PC_image;
            } 

        // live stream video
        if(!empty($data['live_stream_video'])){

            $live_stream_video = $data['live_stream_video'];
            $live_stream_videopath  = URL::to('public/uploads/LiveStream/');
            $LiveStream_Video =  time().'_'.$live_stream_video->getClientOriginalName();  
            $live_stream_video->move(public_path('uploads/LiveStream/'), $LiveStream_Video);
            $live_video_name = strtok($LiveStream_Video, '.');
            $M3u8_save_path = $live_stream_videopath.'/'.$live_video_name.'.m3u8';

            $ffmpeg = \Streaming\FFMpeg::create();
            $videos = $ffmpeg->open('public/uploads/LiveStream'.'/'.$LiveStream_Video);

            $r_144p  = (new Representation)->setKiloBitrate(95)->setResize(256, 144);
            $r_240p  = (new Representation)->setKiloBitrate(150)->setResize(426, 240);
            $r_360p  = (new Representation)->setKiloBitrate(276)->setResize(640, 360);
            $r_480p  = (new Representation)->setKiloBitrate(750)->setResize(854, 480);
            $r_720p  = (new Representation)->setKiloBitrate(2048)->setResize(1280, 720);
            $r_1080p = (new Representation)->setKiloBitrate(4096)->setResize(1920, 1080);

            $videos->hls()
                    ->x264()
                    ->addRepresentations([$r_144p,$r_360p,$r_720p])
                    ->save('public/uploads/LiveStream'.'/'.$live_video_name.'.m3u8');

            $movie->live_stream_video = $M3u8_save_path;
        }

        if(!empty($data['url_type']) && $data['url_type'] == "Encode_video" ){
            $Stream_key = random_int(1000000000, 9999999999);
            $movie->Stream_key = $Stream_key;
            $movie->Rtmp_url = $data['Rtmp_url'];
            $movie->hls_url = str_replace( "streamkey",$Stream_key,$data['hls_url']);
        }

             
        if(empty($data['active'])){
            $active = 0;
        } else{
            $active = 1;
        }

        $last_id = LiveEventArtist::latest()->pluck('id')->first() + 1;

        if(  $data['slug']  == ''){

            $slug = LiveEventArtist::where('slug',$data['title'])->first();
            $data['slug']  = $slug == null ?  str_replace(' ', '_', $data['title']) : str_replace(' ', '_', $data['title'].'-'.$last_id) ;
        }else{

            $slug = LiveEventArtist::where('slug',$data['slug'])->first();
            $data['slug'] = $slug == null ?  str_replace(' ', '_', $data['slug']) : str_replace(' ', '_', $data['slug'].'-'.$last_id) ;
        }

            // Restearm
        if(!empty($data['enable_restream'])){
            $movie->fb_restream_url      = $data['fb_restream_url'];
            $movie->youtube_restream_url = $data['youtube_restream_url'];
            $movie->twitter_restream_url = $data['twitter_restream_url'];
            $movie->fb_streamkey         = $data['fb_streamkey'];
            $movie->youtube_streamkey    = $data['youtube_streamkey'];
            $movie->twitter_streamkey    = $data['twitter_streamkey'];
            $movie->enable_restream      = $data['enable_restream'] ? '1' : '0' ;
        }

        $user = Session::get('channel'); 
        $id = $user->id;

        $movie->title =$data['title'];
        $movie->embed_url =$embed_url;
        $movie->url_type =$url_type;

        $movie->details =$data['details'];
        $movie->rating =$rating;
        $movie->description =$data['description'];
        $movie->featured =$data['featured'];
        $movie->banner =$data['banner'];
        $movie->duration =$data['duration'];
        $movie->ppv_price = $ppv_price;
        $movie->access =$data['access'];
        $movie->slug =$data['slug'];
        $movie->publish_type =$data['publish_type'];
        $movie->publish_time =$data['publish_time'];
        $movie->image = $PC_image;
        $movie->mp4_url =$mp4_url;
        $movie->status =$status;
        $movie->year =$data['year'];
        $movie->active = $active ;
        $movie->search_tags = $searchtags;
        $movie->player_image = $player_PC_image;
        $movie->user_id = $user->id;
        $movie->ios_ppv_price =$request->ios_ppv_price;
        $movie->donations_label =$request->donations_label;
        $movie->tips = !empty($request->tips) ?  1 : 0 ;
        $movie->chats = !empty($request->chats) ? 1 : 0 ;
        $movie->uploaded_by = 'Channel' ;
        $movie->save();

        $shortcodes = $request['short_code'];
        $languages = $request['language'];

            if(!empty($category_id)){
                CategoryLive::where('artist_live_id', $movie->id)->delete();
                foreach ($category_id as $key => $value) {
                    $category = new CategoryLive;
                    $category->artist_live_id = $movie->id;
                    $category->category_id = $value;
                    $category->save();
                }
            }
        
            if(!empty($languages)){
                LiveLanguage::where('artist_live_id', $movie->id)->delete();
                foreach ($languages as $key => $value) {
                    $serieslanguage = new LiveLanguage;
                    $serieslanguage->artist_live_id = $movie->id;
                    $serieslanguage->language_id = $value;
                    $serieslanguage->save();
                }
            }

            if( $data['url_type'] == "Encode_video" ){
                return Redirect::to('channel/live-event-artist')->with([
                                                            'Stream_key' => $Stream_key,
                                                            'Stream_error' => '1' ,
                                                            'Rtmp_url' => $data['Rtmp_url'],
                                                            'title' => $data['title'],
                                                            'hls_url' => $data['hls_url'],
                                                        ]);
               
            }
            else{
                return Redirect::to('channel/live-event-artist')->with(array('message' => 'New PPV Video Successfully Added!', 'note_type' => 'success') );
            }
    }

    public function edit($id)
    {
        $video = LiveEventArtist::find($id);

        $Stream_key = Session::get('Stream_key');
        $Stream_error =Session::get('Stream_error');
        $hls_url  = Session::get('hls_url');
        $Rtmp_url = Session::get('Rtmp_url');
        $title = Session::get('title');

        $user = Session::get('channel'); 
        $userid = $user->id;

        $data = array(
            'headline' => '<i class="fa fa-edit"></i> Edit Video',
            'video' => $video,
            'post_route' => URL::to('channel/live-event-update').'/'.$id,
            'button_text' => 'Update Video',
            'admin_user' => $user,
            'video_categories' => LiveCategory::all(),
            'languages' => Language::all(),
            'category_id' => CategoryLive::where('artist_live_id', $id)->pluck('category_id')->toArray(),
            'languages_id' => LiveLanguage::where('artist_live_id', $id)->pluck('language_id')->toArray(),
            'settings' => Setting::first(),
            'liveStreamVideo_error' => '0',
            'Rtmp_urls' => RTMP::all(),
            'Stream_key' => $Stream_key,
            'Stream_error' => $Stream_error ? $Stream_error : 0 ,
            'Rtmp_url'  => $Rtmp_url ? $Rtmp_url : null ,
            'title' => $title ? $title : null,
            'hls_url' => $hls_url ? $hls_url : null,
            'InappPurchase' => InappPurchase::all(),
            );

        return View('channel.live_event_artist.edit', $data);

    }

    public function update(Request $request)
    {

        $data = $request->all();       

        $id = $data['id'];

        if($data['access'] == "ppv"){
            $ppv_price = $data['ppv_price'];
        }else{
            $ppv_price = null;
        }
        $video = LiveEventArtist::findOrFail($id);  

         $validatedData = $request->validate([
            'title' => 'required|max:255',
        ]);

        // Live Stream Video

        if( !empty($data['url_type']) && $data['url_type'] == "live_stream_video" && !empty($data['live_stream_video'] ) ){

            $live_stream_video = $data['live_stream_video'];
            $live_stream_videopath  = URL::to('public/uploads/LiveStream/');
            $LiveStream_Video =  time().'_'.$live_stream_video->getClientOriginalName();  
            $live_stream_video->move(public_path('uploads/LiveStream/'), $LiveStream_Video);
            $live_video_name = strtok($LiveStream_Video, '.');
            $M3u8_save_path = $live_stream_videopath.'/'.$live_video_name.'.m3u8';

            $ffmpeg = \Streaming\FFMpeg::create();
            $videos = $ffmpeg->open('public/uploads/LiveStream'.'/'.$LiveStream_Video);

            $r_144p  = (new Representation)->setKiloBitrate(95)->setResize(256, 144);
            $r_240p  = (new Representation)->setKiloBitrate(150)->setResize(426, 240);
            $r_360p  = (new Representation)->setKiloBitrate(276)->setResize(640, 360);
            $r_480p  = (new Representation)->setKiloBitrate(750)->setResize(854, 480);
            $r_720p  = (new Representation)->setKiloBitrate(2048)->setResize(1280, 720);
            $r_1080p = (new Representation)->setKiloBitrate(4096)->setResize(1920, 1080);

            $videos->hls()
                    ->x264()
                    ->addRepresentations([$r_144p,$r_360p,$r_720p])
                    ->save('public/uploads/LiveStream'.'/'.$live_video_name.'.m3u8');

            $video->live_stream_video = $M3u8_save_path;
           
        }

            // Video Encoder

            if(!empty($data['url_type']) && $video['url_type'] != "Encode_video" && $data['url_type'] == "Encode_video" ){
                $Stream_key = random_int(1000000000, 9999999999);
                $video->Stream_key = $Stream_key;
                $video->hls_url = str_replace( "streamkey",$Stream_key,$data['hls_url']);
            }

            if(!empty($data['url_type']) && $data['url_type'] == "Encode_video" ){
                if($data['Rtmp_url'] !=null){
                    $video->Rtmp_url =  $data['Rtmp_url'];
                    $Stream_key = random_int(1000000000, 9999999999);
                    $video->Stream_key = $Stream_key;
                    $video->hls_url = str_replace( "streamkey",$Stream_key,$data['hls_url']);
                }
            }

           $image = ($request->file('image')) ? $request->file('image') : '';
           $mp4_url = (isset($data['mp4_url'])) ? $data['mp4_url'] : '';
        
            if(empty($data['ppv_status'])){
                $data['ppv_status'] = 0;
            }
            if(empty($data['embed_url'])){
                $embed_url = null;
            }else{
                $embed_url = $data['embed_url'];
            }

        if(  $data['slug']  == '' ){

            $slug = LiveEventArtist::whereNotIn('id',[$id])->where('slug',$data['title'])->first();

            $data['slug']  = $slug == null ?  str_replace(' ', '_', $data['title']) : str_replace(' ', '_', $data['title'].'-'.$id) ;
        }else{

            $slug = LiveEventArtist::whereNotIn('id',[$id])->where('slug',$data['slug'])->first();

            $data['slug'] = $slug == null ?  str_replace(' ', '_', $data['slug']) : str_replace(' ', '_', $data['slug'].'-'.$id) ;
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
        
                        // Image upload
        $path = public_path().'/uploads/livecategory/';
        $image_path = public_path().'/uploads/images/';
          
        if($image != '') {   
              
              if($image != ''  && $image != null){          //code for remove old file
                   $file_old = $image_path.$image;
                    if (file_exists($file_old)){
                        unlink($file_old);
                    }
              }

              //upload new file
              $file = $image;

            if(compress_image_enable() == 1){

                $filename  = time().'.'.compress_image_format();
                $PC_image     =  'live_'.$filename ;
               Image::make($file)->save(base_path().'/public/uploads/images/'.$PC_image,compress_image_resolution() );
            }
            else{
                $filename  = time().'.'.$file->getClientOriginalExtension();
                $PC_image     =  'live_'.$filename ;
                Image::make($file)->save(base_path().'/public/uploads/images/'.$PC_image );
            }
           
        }else
        {
            $PC_image = $video->image;
        }
       
         $player_image = ($request->file('player_image')) ? $request->file('player_image') : '';

         $path = public_path().'/uploads/livecategory/';
         $image_path = public_path().'/uploads/images/';
           
          if($player_image != '') {   
              
               if($player_image != ''  && $player_image != null){
                    $file_old = $image_path.$player_image;   //code for remove old file
                   if (file_exists($file_old)){
                    unlink($file_old);
                   }
               }

               $player_image = $player_image;

               if(compress_image_enable() == 1){   

                   $player_filename  = time().'.'.compress_image_format();  //upload new file
                   $player_PC_image     =  'live_'.$player_filename ;
                   Image::make($player_image)->save(base_path().'/public/uploads/images/'.$player_PC_image,compress_image_resolution() );
               }
               else
               {
                   $player_filename  = time().'.'.$player_image->getClientOriginalExtension();
                   $player_PC_image     =  'live_'.$player_filename ;
                   Image::make($player_image)->save(base_path().'/public/uploads/images/'.$player_PC_image );
               }
            
          } else{
              $player_PC_image = $video->player_image;
          }

                                   //  TV Image
            $live_tv_image = ($request->file('tv_image')) ? $request->file('tv_image') : '';

            if($live_tv_image != '') {   
              
                $live_tv_image = $live_tv_image;

                if(compress_image_enable() == 1){   //upload new file

                    $live_tv_image_image_filename  = time().'.'.compress_image_format();
                    $live_tv_image_image_PC_image     =  'TV-live-'.$live_tv_image_image_filename ;
                    Image::make($live_tv_image)->save(base_path().'/public/uploads/images/'.$live_tv_image_image_PC_image,compress_image_resolution() );
                }else{

                    $live_tv_image_image_filename  = time().'.'.$live_tv_image->getClientOriginalExtension();
                    $live_tv_image_image_PC_image     =  'TV-live-'.$live_tv_image_image_filename ;
                    Image::make($live_tv_image)->save(base_path().'/public/uploads/images/'.$live_tv_image_image_PC_image );
                }
            } else{
                $live_tv_image_image_PC_image = $video->tv_image;
            }
        
         $data['mp4_url']  = $request->get('mp4_url');

         if(isset($data['duration'])){
                $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $data['duration']);
                sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                $data['duration'] = $time_seconds;
        }

       
         $shortcodes = $request['short_code'];
         $languages = $request['language'];
         $data['access'] = $request['access'];

        $video->update($data);

        if ( !empty($request['rating'])) {
            $rating  = $request['rating'];
        }else {
               $rating  = null;
        }

        if(empty($data['url_type'])){
            $url_type = null;
        }else{
            $url_type = $data['url_type'];
        }   

        if(empty($data['active'])){
            $active = 0;
        }else{
            $active = 1;
        } 

        if(empty($data['banner'])){
            $banner = 0;
        }else{
            $banner = 1;
        } 

        if(empty($data['searchtags'])){
            $searchtags = null;
        }else{
            $searchtags = $request['searchtags'];
        } 

        $video->rating = $rating;
        $video->banner = $banner;
        $video->url_type = $url_type;
        $video->ppv_price = $ppv_price;
        $video->player_image = $player_PC_image;
        $video->tv_image = $live_tv_image_image_PC_image;
        $video->image = $PC_image;
        $video->publish_status = $request['publish_status'];
        $video->publish_type = $request['publish_type'];
        $video->publish_time = $request['publish_time'];
        $video->embed_url = $embed_url;
        $video->active = $active;
        $video->search_tags = $searchtags;
        $video->access = $request->access;
        $video->ios_ppv_price = $request->ios_ppv_price;
        $video->tips = !empty($request->tips) ?  1 : 0 ;
        $video->chats = !empty($request->chats) ? 1 : 0 ;
        $video->enable_restream = !empty($request->enable_restream) ? 1 : 0 ;
        $video->uploaded_by = 'Channel' ;
        $video->save();

        if(!empty($data['video_category_id'])){
            $category_id = $data['video_category_id'];
            unset($data['video_category_id']);
            if(!empty($category_id)){
                CategoryLive::where('artist_live_id', $video->id)->delete();
                foreach ($category_id as $key => $value) {
                    $category = new CategoryLive;
                    $category->artist_live_id = $video->id;
                    $category->category_id = $value;
                    $category->save();
                }
            }
        }
        if(!empty($data['language'])){
            $language_id = $data['language'];
            unset($data['language']);
            if(!empty($language_id)){
                LiveLanguage::where('artist_live_id', $video->id)->delete();
                foreach ($language_id as $key => $value) {
                    $serieslanguage = new LiveLanguage;
                    $serieslanguage->artist_live_id = $video->id;
                    $serieslanguage->language_id = $value;
                    $serieslanguage->save();
                }
            }
        }

        if(!empty($data['url_type']) && $video['url_type'] == "Encode_video" &&  $data['url_type'] == "Encode_video"   ){

            
            return Redirect::back()->with(
                                                    [ 'Stream_key' => $video['Stream_key'],
                                                      'Stream_error' => '1',
                                                      'Rtmp_url' => $data['Rtmp_url'] ? $data['Rtmp_url'] : $video['rtmp_url']  ,
                                                      'title' => $data['title'],
                                                      'hls_url' =>  $data['hls_url'] ? $data['hls_url'] : $video['hls_url']  ,

                                                    ]);
        }else{

            return Redirect::back()->with(array('message' => 'Successfully Updated Video!', 'note_type' => 'success') );
        }

    }
    

    public function destroy($id)
    {
        LiveEventArtist::destroy($id);

        return Redirect::back()->with(array('message' => 'Live Event Artist Deleted Sucessfully!', 'note_type' => 'success') );; 
    }
    
}

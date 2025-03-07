<?php

namespace App\Http\Controllers;
use URL;
use Auth;
use Hash;
use View;
use Session;
use App\RTMP;
use App\Channel;
use App\TimeZone;
use Carbon\Carbon;
use App\Tag as Tag;
use App\Adscategory;
use App\CountryCode;
use App\PpvPurchase;
use App\LivePurchase;
use App\User as User;
use App\Advertisement;
use App\CompressImage;
use App\InappPurchase;
use App\ModeratorsUser;
use App\Users as Users;
use App\BlockLiveStream;
use App\CurrencySetting;
use \Redirect as Redirect;
use App\Setting as Setting;
use Illuminate\Support\Str;
use App\PartnerMonetization;
use App\PPVFreeDurationLogs;
use Illuminate\Http\Request;
use App\Language as Language;
use App\Subtitle as Subtitle;
use Streaming\Representation;
use GuzzleHttp\Message\Response;
use App\LiveStream as LiveStream;
use App\CategoryLive as CategoryLive;
use App\LiveCategory as LiveCategory;
use App\LiveLanguage as LiveLanguage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Route;
use Intervention\Image\Facades\Image;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Storage;
use App\StorageSetting as StorageSetting;
use App\VideosSubtitle as VideosSubtitle;
use Intervention\Image\Filters\DemoFilter;
use App\VideoResolution as VideoResolution;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\SiteTheme;

class AdminLiveStreamController extends Controller
{

    public function __construct()
    {
        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
        $this->userIp = $geoip->getip();
    }

    public function index()
    {
        if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
            return redirect('/admin/restrict');
        }

        $Stream_key = Session::get('Stream_key');
        $Stream_error =Session::get('Stream_error');
        $Rtmp_url = Session::get('Rtmp_url');
        $title = Session::get('title');
        $hls_url = Session::get('hls_url');

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

            $currentRouteName = Route::currentRouteName() ;

            // Common Query

            $query = LiveStream::query();
            
            if ($currentRouteName == "admin.livestream.index") {

                $query->whereNull('stream_upload_via')->orwhere('stream_upload_via','live_stream');
            }
            else{
                $query->orWhere('stream_upload_via', 'radio_station');
            }
            
            $videos = $query->orderBy('created_at', 'desc')->paginate(10);

            if( $currentRouteName == "admin.radio-station.index" ){

                $inputs_details_array = array(
                    'create_route'   => "admin.radio-station.create",
                    'view_route'     => "Radio_station_play",
                    'edit_route'     => "admin.radio-station.edit",
                    'delete_route'   => "admin.radio-station.delete",
                    'all_list_route' => "admin.radio-station.index",
                    'text_main_name' => "Radio Station",
                    'stream_upload_via' => "radio_station",
                );

            }else{

                $inputs_details_array = array(
                    'create_route'   => "admin.livestream.create",
                    'view_route'     => "LiveStream_play",
                    'edit_route'     => "admin.livestream.edit",
                    'delete_route'   => "admin.livestream.delete",
                    'all_list_route' => "admin.livestream.index",
                    'text_main_name' => "Live Stream",
                    'stream_upload_via' => "live_stream",
                );
            }

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
                'hls_url' => $hls_url ? $hls_url : null,
                'inputs_details_array' => $inputs_details_array ,
                'currentRouteName'     => $currentRouteName ,
            );

            return View('admin.livestream.index', $data);
            }
    }

    public function create()
    {

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

            $params = [  'userid' => 0,];
            $headers = [ 'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ' ];

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
        }
        else{

            $settings = Setting::first();
            $compress_image_settings = CompressImage::first();
            $currentRouteName = Route::currentRouteName() ;

            if( $currentRouteName == "admin.radio-station.create" ){

                $inputs_details_array = array(
                    'post_route'     => "admin.radio-station.store",
                    'text_main_name' => "Radio Station",
                    'stream_upload_via' => "radio_station",
                    'create_route'   => "admin.radio-station.create",
                    'all_list_route' => "admin.radio-station.index",
                );

            }else{

                $inputs_details_array = array(
                    'post_route'     => "admin.livestream.store",
                    'text_main_name' => "Live Stream",
                    'stream_upload_via' => null,
                    'create_route'   => "admin.livestream.create",
                    'all_list_route' => "admin.livestream.index",
                );
            }

            $data = array(
                'headline' => '<i class="fa fa-plus-circle"></i> New Video',
                'inputs_details_array' => $inputs_details_array,
                'button_text' => 'Add New ' . $inputs_details_array['text_main_name'],
                'admin_user' => Auth::user(),
                'video_categories' => LiveCategory::all(),
                'languages' => Language::all(),
                'category_id' => [],
                'languages_id' => [],
                'liveStreamVideo_error' => '0',
                'Rtmp_urls' => RTMP::all(),
                'InappPurchase' => InappPurchase::all(),
                'pre_ads' => Advertisement::where('ads_position','pre')->where('status',1)->get(),
                'mid_ads' => Advertisement::where('ads_position','mid')->where('status',1)->get(),
                'post_ads' => Advertisement::where('ads_position','post')->where('status',1)->get(),
                'ppv_gobal_price' => $settings->ppv_price != null ?  $settings->ppv_price : " ",
                'video_js_Advertisements'  => Advertisement::where('status',1)->get() ,
                'ads_category' => Adscategory::all(),
                "countries" => CountryCode::all(),
                "Timezone"  => TimeZone::where('time_zone',$settings->default_time_zone)->get(),
                'compress_image_settings' => $compress_image_settings,
                'currentRouteName'  => $currentRouteName ,
            );

            return View::make('admin.livestream.create_edit', $data);
        }
    }
    
       /**
     * Store a newly created video in storage.
     *
     * @return Response
     */
    
       /**
     * Store a newly created video in storage.
     *
     * @return Response
     */

    public function store(Request $request)
    {
        $data = $request->all();

        $randomString = Str::random(3);

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
              if($image != ''  && $image != null){
                   $file_old = $image_path.$image;
                  if (file_exists($file_old)){
                   unlink($file_old);
                  }
              }
                $file = $image;

                if(compress_image_enable() == 1){

                    $filename  = time().'.'.compress_image_format();
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
               
                //upload new file
                $player_image = $player_image;

                if(compress_image_enable() == 1){

                    $player_filename  = time().'.'.compress_image_format();
                    $player_PC_image     =  'player_live_'.$player_filename ;

                    Image::make($player_image)->save(base_path().'/public/uploads/images/'.$player_PC_image,compress_image_resolution() );
                }else{

                    $player_filename  = time().'.'.$player_image->getClientOriginalExtension();
                    $player_PC_image     =  'player_live_'.$player_filename ;
                    Image::make($player_image)->save(base_path().'/public/uploads/images/'.$player_PC_image );
                }

 
            } else{
                $player_image = "default_horizontal_image.jpg";
            }

                            // live_stream_tv_image

            $live_stream_tv_image = ($request->file('live_stream_tv_image')) ? $request->file('live_stream_tv_image') : '';

            if($live_stream_tv_image != '') {   
                
                                        //upload new file
                    $live_stream_tv_image = $live_stream_tv_image;

                    if(compress_image_enable() == 1){

                        $Tv_image_filename  = time().'.'.compress_image_format();
                        $Tv_live_image     =  'tv-live-image-'.$Tv_image_filename ;

                        Image::make($live_stream_tv_image)->save(base_path().'/public/uploads/images/'.$Tv_live_image,compress_image_resolution() );
                    }else{

                        $Tv_image_filename  = time().'.'.$live_stream_tv_image->getClientOriginalExtension();
                        $Tv_live_image     =  'tv-live-image-'.$Tv_image_filename ;
                        Image::make($live_stream_tv_image)->save(base_path().'/public/uploads/images/'.$Tv_live_image );
                    }
    
                } else{
                    $Tv_live_image = "default_horizontal_image.jpg";
                }
            
        $data['user_id'] = Auth::user()->id;
        
        
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


        $rating     = !empty($data['rating']) ? $data['rating'] : null ;
        $searchtags = !empty($data['searchtags']) ? $data['searchtags'] : null ;
        $embed_url  = !empty($data['embed_url']) ? $data['embed_url'] : null ;
        $url_type   = !empty($data['url_type']) ? $data['url_type'] : null ;
        $mp4_url    = !empty($data['mp4_url']) ? $data['mp4_url'] : null ;

        // $programs = [];

        // if (is_array($request->scheduler_program_title) && !empty($request->scheduler_program_title)) {
        //     foreach ($request->scheduler_program_title as $index => $title) {
               
        //         if (!empty($title) && isset($request->scheduler_start_time[$index]) && isset($request->scheduler_end_time[$index])) {
        //             $programs[] = [
        //                 'title' => $title, 
        //                 'start_time' => $request->scheduler_start_time[$index],
        //                 'end_time' => $request->scheduler_end_time[$index] 
        //             ];
        //         }
        //     }
        // }

        $movie = new LiveStream;

        $StorageSetting = StorageSetting::first();
        $settings = Setting::first();

        // $movie->scheduler_program_title = json_encode(array_column($programs, 'title'));
        // $movie->scheduler_program_days = json_encode($request->scheduler_program_days);
        // $movie->scheduler_start_time = json_encode(array_column($programs, 'start_time')); 
        // $movie->scheduler_end_time = json_encode(array_column($programs, 'end_time')); 

        // live stream video
        if($StorageSetting->site_storage == 1){

            if(!empty($data['live_stream_video'])){

                $live_stream_video = $data['live_stream_video'];
                $live_stream_videopath  = URL::to('public/uploads/LiveStream/');
                $LiveStream_Video =  time().$randomString.'-livestream-video';  
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
        }
        elseif($StorageSetting->aws_storage == 1 && !empty($data['live_stream_video'])){

            if($settings->transcoding_access  == 0 ) {

                $file = $data['live_stream_video'];
                $name = $file->getClientOriginalName() == null ? str_replace(' ', '_', 'S3'.$file->getClientOriginalName()) : str_replace(' ', '_', 'S3'.$file->getClientOriginalName()) ;        

                $filePath = $StorageSetting->aws_live_path.'/'. $name;
                
                Storage::disk('s3')    ->put($filePath, file_get_contents($file));
                $path = 'https://' . env('AWS_BUCKET').'.s3.'. env('AWS_DEFAULT_REGION') . '.amazonaws.com' ;
                $filePath = $path.$filePath;
                
                $movie->live_stream_video = $filePath ; 
            }
            elseif($settings->transcoding_access  == 1 ) 
            {

                $file = $data['live_stream_video'];
                $file_folder_name =  $file->getClientOriginalName();
                $name_mp4 =  $file->getClientOriginalName();
                $name_mp4 = null ? str_replace(' ', '_', 'S3'.$name_mp4) : str_replace(' ', '_', 'S3'.$name_mp4) ;        

                $newfile = explode(".mp4",$name_mp4);
                $namem3u8 = $newfile[0].'.m3u8';   
                $namem3u8 = null ? str_replace(' ', '_',$namem3u8) : str_replace(' ', '_',$namem3u8) ;        

                $transcode_path = $StorageSetting->aws_transcode_path.'/'. $namem3u8;
                $transcode_path_mp4 = $StorageSetting->aws_live_path.'/'. $name_mp4;
                
                Storage::disk('s3')->put($transcode_path_mp4, file_get_contents($file));
                $path = 'https://' . env('AWS_BUCKET').'.s3.'. env('AWS_DEFAULT_REGION') . '.amazonaws.com' ;
                $filePath = $path.$transcode_path_mp4;
                $transcode_path = $path.$transcode_path;

                
                if($data['url_type'] == 'live_stream_video' ){
                    $movie->live_stream_video = $filePath ; 
                    $movie->hls_url = $transcode_path ; 
                    $url_type = 'aws_m3u8' ; 
                }
            }
            else
            {
                $file = $data['live_stream_video'];
                $name = $file->getClientOriginalName() == null ? str_replace(' ', '_', 'S3'.$file->getClientOriginalName()) : str_replace(' ', '_', 'S3'.$file->getClientOriginalName()) ;        
                $filePath = $StorageSetting->aws_live_path.'/'. $name;
                
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                $path = 'https://' . env('AWS_BUCKET').'.s3.'. env('AWS_DEFAULT_REGION') . '.amazonaws.com' ;
                $filePath = $path.$filePath;
                
                $movie->live_stream_video = $filePath ; 
            }
        }
        else
        { 
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
        }

                // Encode - RTMP

            if(!empty($data['url_type']) && $data['url_type'] == "Encode_video" ){
                $Stream_key = random_int(1000000000, 9999999999);
                $movie->Stream_key = $Stream_key;
                $movie->Rtmp_url = $data['Rtmp_url'];
                $movie->hls_url = str_replace( "streamkey",$Stream_key,$data['hls_url']);
            }

                            // Audio upload

            if($request->hasFile('acc_audio_file')){

                $audio_file =    time().'-live-stream-audio.'.$request->file('acc_audio_file')->getClientOriginalExtension();
                $request->file('acc_audio_file')->move(public_path('uploads/LiveStream'), $audio_file);

                $movie->acc_audio_file = URL::to('public/uploads/LiveStream/'.$audio_file) ;

            }

             
        if(empty($data['active'])){
            $active = 0;
            $status = 0;
        } else{
            $active = 1;
            $status = 1;
        }

        $last_id = LiveStream::latest()->pluck('id')->first() + 1;

        if(  $data['slug']  == ''){

            $slug = LiveStream::where('slug',$data['title'])->first();
            $data['slug']  = $slug == null ?  str_replace(' ', '_', $data['title']) : str_replace(' ', '_', $data['title'].'-'.$last_id) ;
        }else{

            $slug = LiveStream::where('slug',$data['slug'])->first();
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

        if (isset($request->free_duration)) {
            $time_seconds = Carbon::createFromFormat('H:i:s', $request->free_duration)->diffInSeconds(Carbon::createFromTime(0, 0, 0));
            $movie->free_duration = $time_seconds;
        }

        $movie->title =$data['title'];
        $movie->stream_upload_via = $data['stream_upload_via'];
        $movie->embed_url =$embed_url;
        $movie->m3u_url =$data['m3u_url'];
        $movie->url_type =$url_type;
        $movie->details =$data['details'];
        $movie->rating =$rating;
        $movie->description =$data['description'];
        $movie->featured =$data['featured'];
        $movie->banner =$data['banner'];
        $movie->duration =  !empty($data['duration']) ? $data['duration'] : NULL;
        $movie->ppv_price = $ppv_price;
        $movie->access =$data['access'];
        $movie->slug =$data['slug'];
        $movie->publish_type =$data['publish_type'];
        $movie->publish_time = $request['publish_type'] == "publish_later" && !empty($request['publish_time']) ? $request['publish_time'] : null ;
        $movie->image = $PC_image;
        $movie->mp4_url =$mp4_url;
        $movie->status =$status;
        $movie->year =$data['year'];
        $movie->active = $active ;
        $movie->search_tags = $searchtags;
        $movie->player_image = $player_PC_image;
        $movie->Tv_live_image = $Tv_live_image;
        $movie->user_id =Auth::User()->id;

        $movie->recurring_timezone  =  $request->publish_type == "recurring_program"  && ( !is_null($request->recurring_timezone)  ) ? $request->recurring_timezone : null ;
        $movie->recurring_program   =  $request->publish_type == "recurring_program"  && !is_null($request->recurring_program) ? $request->recurring_program : null ;
        $movie->program_start_time        =  $request->publish_type == "recurring_program"  && ( !is_null($request->program_start_time) && $request->recurring_program != "custom" ) ? $request->program_start_time : null ;
        $movie->program_end_time          =  $request->publish_type == "recurring_program"  && ( !is_null($request->program_end_time) && $request->recurring_program != "custom" ) ? $request->program_end_time : null ;
        $movie->custom_start_program_time =  $request->publish_type == "recurring_program"  && ( !is_null($request->custom_start_program_time) && $request->recurring_program == "custom" ) ? $request->custom_start_program_time : null ;
        $movie->custom_end_program_time   =  $request->publish_type == "recurring_program"  && ( !is_null($request->custom_end_program_time) && $request->recurring_program == "custom" ) ? $request->custom_end_program_time : null ;
        $movie->recurring_program_week_day   =  $request->publish_type == "recurring_program"  && ( !is_null($request->recurring_program_week_day) && $request->recurring_program == "weekly" ) ? $request->recurring_program_week_day : null ;
        $movie->recurring_program_month_day   =  $request->publish_type == "recurring_program"  && ( !is_null($request->recurring_program_month_day) && $request->recurring_program == "monthly" ) ? $request->recurring_program_month_day : null ;

        $movie->scheduler_program_days    =  $request->publish_type == "schedule_program"  ? json_encode($request->scheduler_program_days) : null ;
        $movie->scheduler_program_title   =  $request->publish_type == "schedule_program"  ? json_encode($request->scheduler_program_title) : null ;
        $movie->scheduler_program_start_time  =  $request->publish_type == "schedule_program"  ? json_encode($request->scheduler_program_start_time) : null ;
        $movie->scheduler_program_end_time    =  $request->publish_type == "schedule_program"  ? json_encode($request->scheduler_program_end_time) : null ;

        // Ads

        if( choosen_player() == 1  && ads_theme_status() == 1){

            if( admin_ads_pre_post_position() == 1){
                
                $movie->pre_post_ads =  $request->pre_post_ads;
                $movie->post_ads     =  $request->pre_post_ads;
                $movie->pre_ads      =  $request->pre_post_ads;
            }
            else{
                
                $movie->pre_ads      =  $request->pre_ads;
                $movie->post_ads     =  $request->post_ads;
                $movie->mid_ads      =  $request->mid_ads;
                $movie->pre_post_ads =  null ;
            }

            $movie->video_js_mid_advertisement_sequence_time   =  $request->video_js_mid_advertisement_sequence_time;
        }
        else{

            $movie->ads_position = $request->ads_position;
            $movie->live_ads = $request->live_ads;

        }
        
        $movie->acc_audio_url   = $request->acc_audio_url;
        $movie->ads_content_id  = $request->ads_content_id ;
        $movie->ads_content_title     = $request->ads_content_title ;
        $movie->ads_content_category  = $request->ads_content_category ;
        $movie->ads_content_genre     = $request->ads_content_genre ;
        $movie->ads_content_language  = $request->ads_content_language ;
        $movie->save();

        $shortcodes = $request['short_code'];
        $languages = $request['language'];

        if(!empty($data['country'])){
            $country = $data['country'];
            unset($data['country']);
            /*save country*/
            if(!empty($country)){
                BlockLiveStream::where('live_id',$movie->id)->delete();
                foreach ($country as $key => $value) {
                    $country = new BlockLiveStream;
                    $country->live_id = $movie->id;
                    $country->country = $value;
                    $country->save();
                }

            }
        }

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
            if(!empty($languages)){
                LiveLanguage::where('live_id', $movie->id)->delete();
                foreach ($languages as $key => $value) {
                    $serieslanguage = new LiveLanguage;
                    $serieslanguage->live_id = $movie->id;
                    $serieslanguage->language_id = $value;
                    $serieslanguage->save();
                }
            }

            if ( $data['stream_upload_via'] == "radio_station" ) {

                $redirection_route = "admin.radio-station.index" ;
                $text_main_name    = "Radio Station";

            }else{

                $redirection_route =  "admin.livestream.index"  ;
                $text_main_name    = "Live Stream";
            }


            if( $data['url_type'] == "Encode_video" ){

                return Redirect::route( $redirection_route ) ->with([ 'Stream_key' => $Stream_key, 'Stream_error' => '1' ,
                                                                'Rtmp_url' => $data['Rtmp_url'],'title' => $data['title'],
                                                                'hls_url' => $data['hls_url'],
                                                            ]);
               
            }
            else{
                return Redirect::route( $redirection_route )->with(array('message' => "New {$text_main_name} Successfully Added!", 'note_type' => 'success') );
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
        $hls_url  = Session::get('hls_url');
        $Rtmp_url = Session::get('Rtmp_url');
        $title = Session::get('title');
        $settings = Setting::first();
        $compress_image_settings = CompressImage::first();

        $access_password = "ZUrtSvrah3E7fj2";
        $access_btn_staus = SiteTheme::pluck('access_change_pass')->first();


        if(  $video->stream_upload_via == "radio_station" ){
           
            $inputs_details_array = array(
                'post_route'     => "admin.radio-station.update",
                'edit_route'     => "admin.radio-station.edit",
                'all_list_route' => "admin.radio-station.index",
                'create_route'   => "admin.radio-station.create",
                'view_route'     => "Radio_station_play",
                'text_main_name' => "Radio Station",
                'stream_upload_via' => "radio_station",
            );

            $scheduler_program = array(
                'scheduler_program_days'       => !empty($video->scheduler_program_days) ? json_decode($video->scheduler_program_days) : [] ,
                'scheduler_program_title'      => !empty($video->scheduler_program_title) ? json_decode($video->scheduler_program_title): [] ,
                'scheduler_program_start_time' => !empty($video->scheduler_program_start_time) ? json_decode($video->scheduler_program_start_time): [] ,
                'scheduler_program_end_time'   => !empty($video->scheduler_program_end_time) ? json_decode($video->scheduler_program_end_time): [] ,
                'scheduler_program_count'      => !empty($video->scheduler_program_title) ? count(json_decode($video->scheduler_program_title,true) ) : 0 ,
            );

        }else{

            $inputs_details_array = array(
                'post_route'     => "admin.livestream.update",
                'edit_route'     => "admin.livestream.edit",
                'all_list_route' => "admin.livestream.index",
                'create_route'   => "admin.livestream.create",
                'view_route'     => "LiveStream_play",
                'text_main_name' => "Live Stream",
                'stream_upload_via' => "live_stream",
            );

            $scheduler_program = array(
                'scheduler_program_days'       =>  [] ,
                'scheduler_program_title'      =>  [] ,
                'scheduler_program_start_time' =>  [] ,
                'scheduler_program_end_time'   =>  [] ,
            );
        }

        $data = array(
            'headline' => '<i class="fa fa-edit"></i> Edit Video',
            'video' => $video,
            'button_text' => 'Update Video',
            'admin_user' => Auth::user(),
            'video_categories' => LiveCategory::all(),
            'languages' => Language::all(),
            'category_id' => CategoryLive::where('live_id', $id)->pluck('category_id')->toArray(),
            'languages_id' => LiveLanguage::where('live_id', $id)->pluck('language_id')->toArray(),
            'settings' => $settings,
            'liveStreamVideo_error' => '0',
            'Rtmp_urls' => RTMP::all(),
            'Stream_key' => $Stream_key,
            'Stream_error' => $Stream_error ? $Stream_error : 0 ,
            'Rtmp_url'  => $Rtmp_url ? $Rtmp_url : null ,
            'title' => $title ? $title : null,
            'hls_url' => $hls_url ? $hls_url : null,
            'InappPurchase' => InappPurchase::all(),
            'pre_ads' => Advertisement::where('ads_position','pre')->where('status',1)->get(),
            'mid_ads' => Advertisement::where('ads_position','mid')->where('status',1)->get(),
            'post_ads' => Advertisement::where('ads_position','post')->where('status',1)->get(),
            'video_js_Advertisements'  => Advertisement::where('status',1)->get() ,
            'ads_category' => Adscategory::all(),
            "countries" => CountryCode::all(),
            "block_countries" => BlockLiveStream::where("live_id", $id)->pluck("country")->toArray(),
            "Timezone"  => TimeZone::where('time_zone',$settings->default_time_zone)->get(),
            'compress_image_settings' => $compress_image_settings,
            'currentRouteName' => Route::currentRouteName() ,
            'inputs_details_array' => $inputs_details_array ,
            'scheduler_program'    => $scheduler_program,
            'access_password'  => $access_password,
            'access_btn_staus'  => $access_btn_staus
        );

        return View::make('admin.livestream.edit', $data); 
    }

    public function update(Request $request)
    {

        $data = $request->all();   

        $randomString = Str::random(3);

        $id = $data['id'];
        $ppv_price  =  $data['access'] == "ppv" ? $data['ppv_price'] : null ;
     
        $video = LiveStream::findOrFail($id);  
        
        if(empty($data['url_type'])){
            $url_type = null;
        }else{
            $url_type = $data['url_type'];
        }  

        if(!empty($video) &&  $url_type == null){
            $url_type = $video->url_type;
        }else{
            $url_type = $data['url_type'];
        } 

        $StorageSetting = StorageSetting::first();
        $settings = Setting::first();

    // live stream video
    if($StorageSetting->site_storage == 1 && !empty($data['live_stream_video']) ){

        if( !empty($data['url_type']) && $data['url_type'] == "live_stream_video" && !empty($data['live_stream_video'] ) ){

            $live_stream_videopath  = URL::to('public/uploads/LiveStream/');

            $live_stream_video = $data['live_stream_video'];
            $LiveStream_Video =  time().$randomString.'-livestream-video';  
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
    }
    elseif($StorageSetting->aws_storage == 1 && !empty($data['live_stream_video'])){

        if($settings->transcoding_access  == 0 ) {

            $file = $data['live_stream_video'];
            $name = $file->getClientOriginalName() == null ? str_replace(' ', '_', 'S3'.$file->getClientOriginalName()) : str_replace(' ', '_', 'S3'.$file->getClientOriginalName()) ;        
            $filePath = $StorageSetting->aws_live_path.'/'. $name;
            
            Storage::disk('s3')->put($filePath, file_get_contents($file));
            $path = 'https://' . env('AWS_BUCKET').'.s3.'. env('AWS_DEFAULT_REGION') . '.amazonaws.com' ;
            $filePath = $path.$filePath;
            
            $video->live_stream_video = $filePath ; 
        }
        elseif($settings->transcoding_access  == 1 && !empty($data['live_stream_video']) ) {

            $file = $data['live_stream_video'];
            $file_folder_name =  $file->getClientOriginalName();
            $name_mp4 =  $file->getClientOriginalName();
            $name_mp4 = null ? str_replace(' ', '_', 'S3'.$name_mp4) : str_replace(' ', '_', 'S3'.$name_mp4) ;        

            $newfile = explode(".mp4",$name_mp4);
            $namem3u8 = $newfile[0].'.m3u8';   
            $namem3u8 = null ? str_replace(' ', '_',$namem3u8) : str_replace(' ', '_',$namem3u8) ;        

            $transcode_path = @$StorageSetting->aws_transcode_path.'/'. $namem3u8;
            $transcode_path_mp4 = @$StorageSetting->aws_live_path.'/'. $name_mp4;
            
            Storage::disk('s3')->put($transcode_path_mp4, file_get_contents($file));
            $path = 'https://' . env('AWS_BUCKET').'.s3.'. env('AWS_DEFAULT_REGION') . '.amazonaws.com' ;
            $filePath = $path.$transcode_path_mp4;
            $transcode_path = $path.$transcode_path;

            
            if($data['url_type'] == 'live_stream_video' ){
                $video->live_stream_video= $filePath ; 
                $video->hls_url = $transcode_path ; 
                $url_type = 'aws_m3u8' ; 
            }

        }else{
            $file = $data['live_stream_video'];
            $name = $file->getClientOriginalName() == null ? str_replace(' ', '_', 'S3'.$file->getClientOriginalName()) : str_replace(' ', '_', 'S3'.$file->getClientOriginalName()) ;        
            $filePath = $StorageSetting->aws_live_path.'/'. $name;
            
            Storage::disk('s3')->put($filePath, file_get_contents($file));
            $path = 'https://' . env('AWS_BUCKET').'.s3.'. env('AWS_DEFAULT_REGION') . '.amazonaws.com' ;
            $filePath = $path.$filePath;
            
            $movie->live_stream_video = $filePath ; 
        }
    }else{ 

        if( !empty($data['url_type']) && $data['url_type'] == "live_stream_video" && !empty($data['live_stream_video'] ) ){

            $live_stream_videopath  = URL::to('public/uploads/LiveStream/');
            $live_stream_video = $data['live_stream_video'];
            $LiveStream_Video =  time().$randomString.'-livestream-video';  
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

                            // Audio upload

            if($request->hasFile('acc_audio_file')){

                if (File::exists(base_path('public/uploads/LiveStream/'.$video['acc_audio_file']))) 
                {
                    File::delete(base_path('public/uploads/LiveStream/'.$video['acc_audio_file']));
                }

                $audio_file =    time().'-live-stream-audio.'.$request->file('acc_audio_file')->getClientOriginalExtension();
                $request->file('acc_audio_file')->move(public_path('uploads/LiveStream'), $audio_file);

                $video->acc_audio_file = URL::to('public/uploads/LiveStream/'.$audio_file) ;

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

            $slug = LiveStream::whereNotIn('id',[$id])->where('slug',$data['title'])->first();

            $data['slug']  = $slug == null ?  str_replace(' ', '_', $data['title']) : str_replace(' ', '_', $data['title'].'-'.$id) ;
        }else{

            $slug = LiveStream::whereNotIn('id',[$id])->where('slug',$data['slug'])->first();

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

            if(compress_image_enable() == 1){

                $filename  = time().'.'.compress_image_format();
                $PC_image     =  'live_'.$filename ;
               Image::make($file)->save(base_path().'/public/uploads/images/'.$PC_image,compress_image_resolution() );
            }else{
    
                $filename  = time().'.'.$file->getClientOriginalExtension();
                $PC_image     =  'live_'.$filename ;
                Image::make($file)->save(base_path().'/public/uploads/images/'.$PC_image );
            }
           
         }  else{
            $PC_image = $video->image;
        }
       
         $player_image = ($request->file('player_image')) ? $request->file('player_image') : '';

         $path = public_path().'/uploads/livecategory/';
         $image_path = public_path().'/uploads/images/';
           
          if($player_image != '') {   
               //code for remove old file
               if($player_image != ''  && $player_image != null){
                    $file_old = $image_path.$player_image;
                   if (file_exists($file_old)){
                    unlink($file_old);
                   }
               }
               //upload new file

               $player_image = $player_image;

               if(compress_image_enable() == 1){

                   $player_filename  = time().'.'.compress_image_format();
                   $player_PC_image     =  'player_live_'.$player_filename ;

                   Image::make($player_image)->save(base_path().'/public/uploads/images/'.$player_PC_image,compress_image_resolution() );
               }else{

                   $player_filename  = time().'.'.$player_image->getClientOriginalExtension();
                   $player_PC_image     =  'player_live_'.$player_filename ;
                   Image::make($player_image)->save(base_path().'/public/uploads/images/'.$player_PC_image );
               }
            
          } else{
              $player_PC_image = $video->player_image;
          }

                 // live_stream_tv_image

            $live_stream_tv_image = ($request->file('live_stream_tv_image')) ? $request->file('live_stream_tv_image') : '';

            if($live_stream_tv_image != '') {   
                
                                        //upload new file
                    $live_stream_tv_image = $live_stream_tv_image;

                    if (File::exists(base_path('public/uploads/images/'.$video->Tv_live_image))) {
                        File::delete(base_path('public/uploads/images/'.$video->Tv_live_image));
                    }

                    if(compress_image_enable() == 1){

                        $Tv_image_filename  = time().'.'.compress_image_format();
                        $Tv_live_image     =  'tv-live-image-'.$Tv_image_filename ;

                        Image::make($live_stream_tv_image)->save(base_path().'/public/uploads/images/'.$Tv_live_image,compress_image_resolution() );
                    }else{

                        $Tv_image_filename  = time().'.'.$live_stream_tv_image->getClientOriginalExtension();
                        $Tv_live_image     =  'tv-live-image-'.$Tv_image_filename ;
                        Image::make($live_stream_tv_image)->save(base_path().'/public/uploads/images/'.$Tv_live_image );
                    }
    
                } else{
                    $Tv_live_image = $video->Tv_live_image ? $video->Tv_live_image : "default_horizontal_image.jpg";
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


        $video->update($data);
        if ( !empty($request['rating'])) {
            $rating  = $request['rating'];
          } else {
               $rating  = null;
          }
 

        if(empty($data['active'])){
            $active = 0;
            $status = 0;

        }else{
            $active = 1;
            $status = 1;
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

            // Restearm
        if(!empty($data['enable_restream'])){
            $video->fb_restream_url      = $data['fb_restream_url'];
            $video->youtube_restream_url = $data['youtube_restream_url'];
            $video->twitter_restream_url = $data['twitter_restream_url'];
            $video->fb_streamkey         = $data['fb_streamkey'];
            $video->youtube_streamkey    = $data['youtube_streamkey'];
            $video->twitter_streamkey    = $data['twitter_streamkey'];
            $video->enable_restream      = $data['enable_restream'] ? '1' : '0' ;
        }

        if (isset($request->free_duration)) {
            $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $request->free_duration);
            sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
        
            $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
            $video->free_duration = $time_seconds;
        }
        

        
        // if (isset($request->free_duration)) {
        //     $time_seconds = Carbon::createFromFormat('H:i:s', $request->free_duration)->diffInSeconds(Carbon::createFromTime(0, 0, 0));
        //     $video->free_duration = $time_seconds;
        // }

        $video->rating = $rating;
        $video->banner = $banner;
        $video->status = $status;
        $video->url_type = $url_type;
        $video->ppv_price = $ppv_price;
        $video->player_image = $player_PC_image;
        $video->Tv_live_image = $Tv_live_image;
        $video->image = $PC_image;
        $video->publish_status = $request['publish_status'];
        $video->publish_type = $request['publish_type'];
        $video->publish_time = $request['publish_type'] == "publish_later" && !empty($request['publish_time']) ? $request['publish_time'] : null ;
        $video->embed_url =     $embed_url;
        $video->active = $active;
        $video->search_tags = $searchtags;
        $video->access = $request->access;
        $video->ios_ppv_price = $request->ios_ppv_price;
        $video->updated_by = Auth::user()->id;
        
        $video->recurring_timezone  =  $request->publish_type == "recurring_program"  && ( !is_null($request->recurring_timezone)  ) ? $request->recurring_timezone : null ;
        $video->recurring_program   =  $request->publish_type == "recurring_program"  && !is_null($request->recurring_program) ? $request->recurring_program : null ;
        $video->program_start_time  =  $request->publish_type == "recurring_program"  && ( !is_null($request->program_start_time) && $request->recurring_program != "custom" ) ? $request->program_start_time : null ;
        $video->program_end_time    =  $request->publish_type == "recurring_program"  && ( !is_null($request->program_end_time) && $request->recurring_program != "custom" ) ? $request->program_end_time : null ;
        $video->custom_start_program_time =  $request->publish_type == "recurring_program"  && ( !is_null($request->custom_start_program_time) && $request->recurring_program == "custom" ) ? $request->custom_start_program_time : null ;
        $video->custom_end_program_time   =  $request->publish_type == "recurring_program"  && ( !is_null($request->custom_end_program_time) && $request->recurring_program == "custom" ) ? $request->custom_end_program_time : null ;
        $video->recurring_program_week_day   =  $request->publish_type == "recurring_program"  && ( !is_null($request->recurring_program_week_day) && $request->recurring_program == "weekly" ) ? $request->recurring_program_week_day : null ;
        $video->recurring_program_month_day   =  $request->publish_type == "recurring_program"  && ( !is_null($request->recurring_program_month_day) && $request->recurring_program == "monthly" ) ? $request->recurring_program_month_day : null ;

        $video->scheduler_program_days    =  $request->publish_type == "schedule_program"  &&  !empty($request->scheduler_program_days)  ?  json_encode($request->scheduler_program_days) : null ;
        $video->scheduler_program_title   =  $request->publish_type == "schedule_program"   &&  !empty($request->scheduler_program_title) ? json_encode($request->scheduler_program_title) : null ;
        $video->scheduler_program_start_time  =  $request->publish_type == "schedule_program"  &&  !empty($request->scheduler_program_start_time) ? json_encode($request->scheduler_program_start_time) : null ;
        $video->scheduler_program_end_time    =  $request->publish_type == "schedule_program"  &&  !empty($request->scheduler_program_end_time)   ? json_encode($request->scheduler_program_end_time) : null ;

        // Ads

        if( choosen_player() == 1  && ads_theme_status() == 1){

            if( admin_ads_pre_post_position() == 1){
                
                $video->pre_post_ads =  $request->pre_post_ads;
                $video->post_ads     =  $request->pre_post_ads;
                $video->pre_ads      =  $request->pre_post_ads;
            }
            else{
                
                $video->pre_ads      =  $request->pre_ads;
                $video->post_ads     =  $request->post_ads;
                $video->mid_ads      =  $request->mid_ads;
                $video->pre_post_ads =  null ;
            }

            if (!empty($request->video_js_mid_advertisement_sequence_time)) {
                $time = $request->video_js_mid_advertisement_sequence_time;
                sscanf($time, "%d:%d:%d", $hours, $minutes, $seconds);
        
                // Default missing values to 0
                $hours = $hours ?? 0;
                $minutes = $minutes ?? 0;
                $seconds = $seconds ?? 0;
        
                // Format to HH:MM:SS
                $formattedTime = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
                $video->video_js_mid_advertisement_sequence_time = $formattedTime;
            }
            // $video->video_js_mid_advertisement_sequence_time   =  $request->video_js_mid_advertisement_sequence_time;
        }
        else{
            $video->ads_position = $request->ads_position;
            $video->live_ads     = $request->live_ads;
        }

        $video->acc_audio_url  = $request->acc_audio_url;
        $video->ads_content_id  = $request->ads_content_id ;
        $video->ads_content_title     = $request->ads_content_title ;
        $video->ads_content_category  = $request->ads_content_category ;
        $video->ads_content_genre     = $request->ads_content_genre ;
        $video->ads_content_language  = $request->ads_content_language ;
        $video->free_duration_status  = !empty($request->free_duration_status) ? 1 : 0 ;
        $video->save();

        if(!empty($data['country'])){
            $country = $data['country'];
            unset($data['country']);
            /*save country*/
            if(!empty($country)){
                BlockLiveStream::where('live_id',$video->id)->delete();
                foreach ($country as $key => $value) {
                    $country = new BlockLiveStream;
                    $country->live_id = $video->id;
                    $country->country = $value;
                    $country->save();
                }

            }
        }

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

        if ( $video->stream_upload_via == "radio_station" ) {

            $redirection_route = "admin.radio-station.edit" ;
            $text_main_name    = "Radio Station";
        }else{
            
            $redirection_route =  "admin.livestream.edit"  ;
            $text_main_name    = "Live Stream";
        }


        if(!empty($data['url_type']) && $video['url_type'] == "Encode_video" &&  $data['url_type'] == "Encode_video"   ){

            return Redirect::route( $redirection_route,$id )->with(
                                                    [ 'Stream_key' => $video['Stream_key'],
                                                        'Stream_error' => '1',
                                                        'Rtmp_url' => $data['Rtmp_url'] ? $data['Rtmp_url'] : $video['rtmp_url']  ,
                                                        'title' => $data['title'],
                                                        'hls_url' =>  $data['hls_url'] ? $data['hls_url'] : $video['hls_url']  ,

                                                    ]);
        }else{

            return Redirect::route( $redirection_route, $id  )->with(array('message' => 'Successfully Updated Video!', 'note_type' => 'success') );
        }
    }
    
    public function CPPLiveVideosIndex()
    {
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
            return View::make('admin.expired_dashboard', $data);
        }else if(check_storage_exist() == 0){
            $settings = Setting::first();

            $data = array(
                'settings' => $settings,
            );

            return View::make('admin.expired_storage', $data);
        }else{
        // $videos = LiveStream::orderBy('created_at', 'DESC')->paginate(9);
        $videos =    LiveStream::where('active', '=',0)
            ->join('moderators_users', 'moderators_users.id','=','live_streams.user_id')
            ->select('moderators_users.username', 'live_streams.*')
            ->where("live_streams.uploaded_by", "CPP")
            ->orderBy('live_streams.created_at', 'DESC')->paginate(9);
            // dd($videos);
            $data = array(
                'videos' => $videos,
                );

            return View('admin.livestream.livevideoapproval.live_video_approval', $data);
        }
       }
       public function CPPLiveVideosApproval($id)
       {
           $video = LiveStream::findOrFail($id);
           $video->active = 1;
           $video->status = 1;
           $video->save();
           $settings = Setting::first();
        $user_id = $video->user_id;
        $ModeratorsUser = ModeratorsUser::findOrFail($video->user_id);
        try {
            \Mail::send('emails.admin_cpp_approved', array(
                'website_name' => $settings->website_name,
                'ModeratorsUser' => $ModeratorsUser
            ) , function ($message) use ($ModeratorsUser)
            {
                $message->from(AdminMail() , GetWebsiteName());
                $message->to($ModeratorsUser->email, $ModeratorsUser->username)
                    ->subject('Content has been Submitted for Approved By Admin');
            });
            
            $email_log      = 'Mail Sent Successfully Approved Content';
            $email_template = "Approved";
            $user_id = $user_id;

            Email_sent_log($user_id,$email_log,$email_template);

       } catch (\Throwable $th) {

            $email_log      = $th->getMessage();
            $email_template = "Approved";
            $user_id = $user_id;

            Email_notsent_log($user_id,$email_log,$email_template);
       }
           return Redirect::back()->with('message','Your video will be available shortly after we process it');

          }

          public function CPPLiveVideosReject($id)
          {
            $video = LiveStream::findOrFail($id);
            $video->active = 2;
            $video->save();           
            
            
        $settings = Setting::first();
        $user_id = $video->user_id;
        $ModeratorsUser = ModeratorsUser::findOrFail($video->user_id);
        try {
            \Mail::send('emails.admin_cpp_rejected', array(
                'website_name' => $settings->website_name,
                'ModeratorsUser' => $ModeratorsUser
            ) , function ($message) use ($ModeratorsUser)
            {
                $message->from(AdminMail() , GetWebsiteName());
                $message->to($ModeratorsUser->email, $ModeratorsUser->username)
                    ->subject('Content has been Submitted for Rejected By Admin');
            });
            
            $email_log      = 'Mail Sent Successfully Rejected Content';
            $email_template = "Rejected";
            $user_id = $user_id;

            Email_sent_log($user_id,$email_log,$email_template);

       } catch (\Throwable $th) {

            $email_log      = $th->getMessage();
            $email_template = "Rejected";
            $user_id = $user_id;

            Email_notsent_log($user_id,$email_log,$email_template);
       }

            return Redirect::back()->with('message','Your video will be available shortly after we process it');
 
             }

        public function livevideo_slider_update(Request $request)
        {
            try {
                $video = LiveStream::where('id',$request->video_id)->update([
                    'banner' => $request->banner_status,
                ]);
    
                return response()->json(['message'=>"true"]);
    
            } catch (\Throwable $th) {
                return response()->json(['message'=>"false"]);
            }
        }
        public function ChannelLiveVideosIndex()
    {
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
            return View::make('admin.expired_dashboard', $data);
        }else if(check_storage_exist() == 0){
            $settings = Setting::first();

            $data = array(
                'settings' => $settings,
            );

            return View::make('admin.expired_storage', $data);
        }else{
        // $videos = LiveStream::orderBy('created_at', 'DESC')->paginate(9);

            $videos =    LiveStream::where('active', '=',0)
            ->join('channels', 'channels.id','=','live_streams.user_id')
            ->select( 'live_streams.*','channels.channel_name as username')
            ->where("live_streams.uploaded_by", "Channel")
            ->orderBy('live_streams.created_at', 'DESC')->paginate(9);

            // dd($videos);
            $data = array(
                'videos' => $videos,
                // 'channelvideos' => $channelvideos,
                );

            return View('admin.livestream.livevideoapproval.channel_live_approval', $data);
        }
       }
       public function ChannelLiveVideosApproval($id)
       {
           $video = LiveStream::findOrFail($id);
           $video->active = 1;
           $video->status = 1;
           $video->save();
           $settings = Setting::first();
           $user_id = $video->user_id;
           $Channel = Channel::findOrFail($video->user_id);
           try {
               \Mail::send('emails.admin_channel_approved', array(
                   'website_name' => $settings->website_name,
                   'Channel' => $Channel
               ) , function ($message) use ($Channel)
               {
                   $message->from(AdminMail() , GetWebsiteName());
                   $message->to($Channel->email, $Channel->channel_name)
                       ->subject('Content has been Submitted for Approved By Admin');
               });
               
               $email_log      = 'Mail Sent Successfully Approved Content';
               $email_template = "Approved";
               $user_id = $user_id;
   
               Email_sent_log($user_id,$email_log,$email_template);
   
          } catch (\Throwable $th) {
   
               $email_log      = $th->getMessage();
               $email_template = "Approved";
               $user_id = $user_id;
   
               Email_notsent_log($user_id,$email_log,$email_template);
          }
   
           return Redirect::back()->with('message','Your video will be available shortly after we process it');

          }

          public function ChannelLiveVideosReject($id)
          {
            $video = LiveStream::findOrFail($id);
            $video->active = 2;
            $video->save();      
            
            $settings = Setting::first();
            $user_id = $video->user_id;
            $Channel = Channel::findOrFail($video->user_id);
            try {
                \Mail::send('emails.admin_channel_approved', array(
                    'website_name' => $settings->website_name,
                    'Channel' => $Channel
                ) , function ($message) use ($Channel)
                {
                    $message->from(AdminMail() , GetWebsiteName());
                    $message->to($Channel->email, $Channel->channel_name)
                        ->subject('Content has been Submitted for Approved By Admin');
                });
                
                $email_log      = 'Mail Sent Successfully Approved Content';
                $email_template = "Approved";
                $user_id = $user_id;
    
                Email_sent_log($user_id,$email_log,$email_template);
    
           } catch (\Throwable $th) {
    
                $email_log      = $th->getMessage();
                $email_template = "Approved";
                $user_id = $user_id;
    
                Email_notsent_log($user_id,$email_log,$email_template);
           }
            return Redirect::back()->with('message','Your video will be available shortly after we process it');
 
             }


             
    public function VideoAnalytics()
    {
        if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
            return redirect('/admin/restrict');
        }

        $user = User::where("id", 1)->first();
        $duedate = $user->package_ends;
        $current_date = date("Y-m-d");
        if ($current_date > $duedate) {
            $client = new Client();
            $url = "https://flicknexs.com/userapi/allplans";
            $params = [
                "userid" => 0,
            ];

            $headers = [
                "api-key" => "k3Hy5qr73QhXrmHLXhpEh6CQ",
            ];
            $response = $client->request("post", $url, [
                "json" => $params,
                "headers" => $headers,
                "verify" => false,
            ]);

            $responseBody = json_decode($response->getBody());
            $settings = Setting::first();
            $data = [
                "settings" => $settings,
                "responseBody" => $responseBody,
            ];
            return View::make("admin.expired_dashboard", $data);
        }else if(check_storage_exist() == 0){
            $settings = Setting::first();

            $data = array(
                'settings' => $settings,
            );

            return View::make('admin.expired_storage', $data);
        } else {
            $settings = Setting::first();
            $total_content = ModeratorsUser::join(
                "videos",
                "videos.user_id",
                "=",
                "moderators_users.id"
            )
                ->groupBy("videos.id")
                ->get([
                    \DB::raw("COUNT(*) as count"),
                    \DB::raw("MONTHNAME(videos.created_at) as month_name"),
                    \DB::raw("videos.*"),
                    \DB::raw("moderators_users.username as cppusername"),
                    \DB::raw("moderators_users.email as cppemail"),
                ]);
            $total_contents = Video::join(
                "moderators_users",
                "moderators_users.id",
                "=",
                "videos.user_id"
            )
                ->groupBy("videos.id")
                ->get([
                    "videos.*",
                    \DB::raw("moderators_users.username as cppusername"),
                    \DB::raw("moderators_users.email as cppemail"),
                    \DB::raw("COUNT(*) as count"),
                    \DB::raw("MONTHNAME(videos.created_at) as month_name"),
                    \DB::raw("MONTHNAME(videos.created_at) as month_name"),
                ]);

            $total_contentss = $total_contents->groupBy("month_name");


            $ppv_purchases = PpvPurchase::join(
                "videos",
                "videos.id",
                "=",
                "ppv_purchases.video_id"
            )
            ->join("moderators_users", "moderators_users.id", "=", "videos.user_id")
            ->where("videos.uploaded_by", "CPP")
            ->get([
                    "ppv_purchases.created_at as purchases_created_at" ,
                    "ppv_purchases.user_id as ",
                    "ppv_purchases.admin_commssion","ppv_purchases.moderator_commssion","ppv_purchases.total_amount",
                    "ppv_purchases.created_at as purchases_created_at" ,
                    "videos.*",
                    \DB::raw("moderators_users.username as cppusername"),
                    \DB::raw("MONTHNAME(ppv_purchases.created_at) as month_name"),
                ]);
                
            $ModeratorsUser = ModeratorsUser::get();
            // dd($payouts);
            $data = [
                "settings" => $settings,
                "total_content" => $total_content,
                "total_video_count" => count($total_content),
                "total_contentss" => $total_contentss,
                "ppv_purchases" => $ppv_purchases,
                "ModeratorsUser" => $ModeratorsUser,
            ];
            return view("admin.analytics.cpp_video_analytics", $data);
        }
    }

    public function CPPVideoStartDateAnalytics(Request $request)
    {
        $data = $request->all();

        $start_time = $data["start_time"];
        $end_time = $data["end_time"];
        if (!empty($start_time) && empty($end_time)) {
            $settings = Setting::first();
            $total_content = ModeratorsUser::join(
                "videos",
                "videos.user_id",
                "=",
                "moderators_users.id"
            )
                ->whereDate("videos.created_at", ">=", $start_time)
                ->groupBy("videos.id")

                ->get([
                    \DB::raw("COUNT(*) as count"),
                    \DB::raw("MONTHNAME(videos.created_at) as month_name"),
                    \DB::raw("videos.*"),
                    \DB::raw("moderators_users.username as cppusername"),
                    \DB::raw("moderators_users.email as cppemail"),
                ]);
                $ppv_purchases = PpvPurchase::join(
                    "videos",
                    "videos.id",
                    "=",
                    "ppv_purchases.video_id"
                )
                ->whereDate("ppv_purchases.created_at", ">=", $start_time)
                ->join("moderators_users", "moderators_users.id", "=", "videos.user_id")
                ->where("videos.uploaded_by", "CPP")
                    ->get([
                        "ppv_purchases.created_at as purchases_created_at" ,
                        "ppv_purchases.user_id as ",
                        "ppv_purchases.admin_commssion","ppv_purchases.moderator_commssion","ppv_purchases.total_amount",
                        "ppv_purchases.created_at as purchases_created_at" ,
                        "videos.*",
                        \DB::raw("moderators_users.username as cppusername"),
                        \DB::raw("MONTHNAME(ppv_purchases.created_at) as month_name"),
                    ]);
                    
        } else {
            $ppv_purchases = [];
        }

        $output = "";
        $i = 1;
        if (count($ppv_purchases) > 0) {
            $total_row = $total_content->count();
            if (!empty($ppv_purchases)) {
                foreach ($ppv_purchases as $key => $row) {
                    $output .=
                        '
              <tr>
              <td>' .
                        $i++ .
                        '</td>
              <td>' .
                        $row->title .
                        '</td>
              <td>' .
                        $row->cppusername .
                        '</td>    
              <td>' .
                        $row->total_amount .
                        '</td>    
              <td>' .
                        $row->admin_commssion .
                        '</td>    
                <td>' .
                        $row->moderator_commssion .
                        '</td>   
                <td>' .
                        $row->views .
                        '</td>   
                <td>' .
                        $row->purchases_created_at .
                        '</td>    
              </tr>
              ';
                }
            } else {
                $output = '
          <tr>
           <td align="center" colspan="5">No Data Found</td>
          </tr>
          ';
            }
            $value = [
                "table_data" => $output,
                "total_data" => $total_row,
                "total_content" => $total_content,
            ];

            return $value;
        }
    }

    public function CPPVideoEndDateAnalytics(Request $request)
    {
        $data = $request->all();

        $start_time = $data["start_time"];
        $end_time = $data["end_time"];

        if (!empty($start_time) && !empty($end_time)) {
            $total_content = ModeratorsUser::join(
                "videos",
                "videos.user_id",
                "=",
                "moderators_users.id"
            )
                // ->whereDate("videos.created_at", ">=", $start_time)
                ->whereBetween("videos.created_at", [$start_time, $end_time])
                ->groupBy("videos.id")
                ->get([
                    \DB::raw("COUNT(*) as count"),
                    \DB::raw("MONTHNAME(videos.created_at) as month_name"),
                    \DB::raw("videos.*"),
                    \DB::raw("moderators_users.username as cppusername"),
                    \DB::raw("moderators_users.email as cppemail"),
                ]);
                $ppv_purchases = PpvPurchase::join(
                    "videos",
                    "videos.id",
                    "=",
                    "ppv_purchases.video_id"
                )
                ->whereBetween("ppv_purchases.created_at", [$start_time, $end_time])
                ->join("moderators_users", "moderators_users.id", "=", "videos.user_id")
                ->where("videos.uploaded_by", "CPP")
                    ->get([
                        "ppv_purchases.created_at as purchases_created_at" ,
                        "ppv_purchases.user_id as ",
                        "ppv_purchases.admin_commssion","ppv_purchases.moderator_commssion","ppv_purchases.total_amount",
                        "ppv_purchases.created_at as purchases_created_at" ,
                        "videos.*",
                        \DB::raw("moderators_users.username as cppusername"),
                        \DB::raw("MONTHNAME(ppv_purchases.created_at) as month_name"),
                    ]);
        } else {
            $total_content = [];
            $ppv_purchases = [];

        }

        $output = "";
        $i = 1;
        if (count($ppv_purchases) > 0) {
            $total_row = $total_content->count();
            if (!empty($ppv_purchases)) {
                foreach ($ppv_purchases as $key => $row) {
                    $output .=
                        '
              <tr>
              <td>' .
                        $i++ .
                        '</td>
              <td>' .
                        $row->title .
                        '</td>
              <td>' .
                        $row->cppusername .
                        '</td>    
              <td>' .
                        $row->total_amount .
                        '</td>    
              <td>' .
                        $row->admin_commssion .
                        '</td>    
                <td>' .
                        $row->moderator_commssion .
                        '</td>   
                <td>' .
                        $row->views .
                        '</td>   
                <td>' .
                        $row->purchases_created_at .
                        '</td>   
              </tr>
              ';
                }
            } else {
                $output = '
          <tr>
           <td align="center" colspan="5">No Data Found</td>
          </tr>
          ';
            }
            $value = [
                "table_data" => $output,
                "total_data" => $total_row,
                "total_content" => $total_content,
            ];

            return $value;
        }
    }

    public function CPPVideoExportCsv(Request $request)
    {
        $data = $request->all();
        // dd($data);exit;
        // if(!empty($data['start_time']) && empty($data['end_time']
        // || empty($data['start_time']) && !empty($data['end_time'])
        // || !empty($data['start_time']) && !empty($data['end_time'])) ){
        $start_time = $data["start_time"];
        $end_time = $data["end_time"];
        // }
        if (!empty($start_time) && empty($end_time)) {
            $total_content = ModeratorsUser::join(
                "videos",
                "videos.user_id",
                "=",
                "moderators_users.id"
            )
                ->whereDate("videos.created_at", ">=", $start_time)
                ->groupBy("videos.id")
                ->get([
                    \DB::raw("COUNT(*) as count"),
                    \DB::raw("MONTHNAME(videos.created_at) as month_name"),
                    \DB::raw("videos.*"),
                    \DB::raw("moderators_users.username as cppusername"),
                    \DB::raw("moderators_users.email as cppemail"),
                ]);
                $ppv_purchases = PpvPurchase::join(
                    "videos",
                    "videos.id",
                    "=",
                    "ppv_purchases.video_id"
                )
                ->whereDate("ppv_purchases.created_at", ">=", $start_time)
                ->join("moderators_users", "moderators_users.id", "=", "videos.user_id")
                ->where("videos.uploaded_by", "CPP")
                ->get([
                        "ppv_purchases.created_at as purchases_created_at" ,
                        "ppv_purchases.user_id as ",
                        "ppv_purchases.admin_commssion","ppv_purchases.moderator_commssion","ppv_purchases.total_amount",
                        "ppv_purchases.created_at as purchases_created_at" ,
                        "videos.*",
                        \DB::raw("moderators_users.username as cppusername"),
                        \DB::raw("MONTHNAME(ppv_purchases.created_at) as month_name"),
                    ]);
        } elseif (!empty($start_time) && !empty($end_time)) {
            $total_content = ModeratorsUser::join(
                "videos",
                "videos.user_id",
                "=",
                "moderators_users.id"
            )
                // ->whereDate("videos.created_at", ">=", $start_time)
                ->whereBetween("videos.created_at", [$start_time, $end_time])
                ->groupBy("videos.id")
                ->get([
                    \DB::raw("COUNT(*) as count"),
                    \DB::raw("MONTHNAME(videos.created_at) as month_name"),
                    \DB::raw("videos.*"),
                    \DB::raw("moderators_users.username as cppusername"),
                    \DB::raw("moderators_users.email as cppemail"),
                ]);
                $ppv_purchases = PpvPurchase::join(
                    "videos",
                    "videos.id",
                    "=",
                    "ppv_purchases.video_id"
                )
                ->whereBetween("ppv_purchases.created_at", [$start_time, $end_time])
                ->join("moderators_users", "moderators_users.id", "=", "videos.user_id")
                ->where("videos.uploaded_by", "CPP")
                ->get([
                        "ppv_purchases.created_at as purchases_created_at" ,
                        "ppv_purchases.user_id as ",
                        "ppv_purchases.admin_commssion","ppv_purchases.moderator_commssion","ppv_purchases.total_amount",
                        "ppv_purchases.created_at as purchases_created_at" ,
                        "videos.*",
                        \DB::raw("moderators_users.username as cppusername"),
                        \DB::raw("MONTHNAME(ppv_purchases.created_at) as month_name"),
                    ]);
                
        } else {
            $total_content = ModeratorsUser::join(
                "videos",
                "videos.user_id",
                "=",
                "moderators_users.id"
            )
                ->groupBy("videos.id")
                ->get([
                    \DB::raw("COUNT(*) as count"),
                    \DB::raw("MONTHNAME(videos.created_at) as month_name"),
                    \DB::raw("videos.*"),
                    \DB::raw("moderators_users.username as cppusername"),
                    \DB::raw("moderators_users.email as cppemail"),
                ]);
                $ppv_purchases = PpvPurchase::join(
                    "videos",
                    "videos.id",
                    "=",
                    "ppv_purchases.video_id"
                )
                ->join("moderators_users", "moderators_users.id", "=", "videos.user_id")
                ->where("videos.uploaded_by", "CPP")
                ->get([
                        "ppv_purchases.created_at as purchases_created_at" ,
                        "ppv_purchases.user_id as ",
                        "ppv_purchases.admin_commssion","ppv_purchases.moderator_commssion","ppv_purchases.total_amount",
                        "ppv_purchases.created_at as purchases_created_at" ,
                        "videos.*",
                        \DB::raw("moderators_users.username as cppusername"),
                        \DB::raw("MONTHNAME(ppv_purchases.created_at) as month_name"),
                    ]);
        }
        //  $file = 'CPPRevenue_' . rand(10, 100000) . '.csv';
        $file = "CPPLiveAnalytics.csv";

        $headers = [
            "Content-Type" => "application/vnd.ms-excel; charset=utf-8",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Content-Disposition" => "attachment; filename=download.csv",
            "Expires" => "0",
            "Pragma" => "public",
        ];
        if (!File::exists(public_path() . "/uploads/csv")) {
            File::makeDirectory(public_path() . "/uploads/csv");
        }
        $filename = public_path("/uploads/csv/" . $file);
        $handle = fopen($filename, "w");
        fputcsv($handle, [
            "Video Name",
            "Uploader Name",
            "Total Commission",
            "Admin Commission",
            "Moderator Commission",
            "Total Views",
            "Purchased Date",
        ]);
        if (count($ppv_purchases) > 0) {
            foreach ($ppv_purchases as $each_user) {
                fputcsv($handle, [
                    $each_user->title,
                    $each_user->cppusername,
                    $each_user->total_amount,
                    $each_user->admin_commssion,
                    $each_user->moderator_commssion,
                    $each_user->views,
                    $each_user->purchases_created_at,
                ]);
            }
        }

        fclose($handle);

        \Response::download($filename, "download.csv", $headers);

        return $file;
    }

    public function liveStream(Request $request)
    {

        $ffmpeg = \Streaming\FFMpeg::create();
        $videos = $ffmpeg->open('public/uploads/LiveStream'.'/'.'12.mp4');

        $hls = $videos->hls()
            ->x264()
            ->autoGenerateRepresentations();
        $hls->save();

        $hls->setMasterPlaylist('public/uploads/LiveStream'.'/'.'12.m3u8')
        ->live('rtmp://a.rtmp.youtube.com/live2/vp9u-yadb-x43r-bwgz-4hh4');
        
        
    }

    public function PurchasedLiveAnalytics()
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
        }
        
        $user_package = User::where("id", 1)->first();
        $package = $user_package->package;
        if (
            (!empty($package) && $package == "Pro") ||
            (!empty($package) && $package == "Business")
        ) {
            $settings = Setting::first();
            
            $total_content = LiveStream::join("ppv_purchases", "ppv_purchases.live_id","=","live_streams.id")
                ->join("users", "users.id", "=", "ppv_purchases.user_id")
                ->groupBy("ppv_purchases.id")

                ->get([
                    \DB::raw("live_streams.*"),
                    \DB::raw("users.username"),
                    \DB::raw("users.email"),
                    \DB::raw("ppv_purchases.total_amount"),
                    \DB::raw("ppv_purchases.created_at as ppvcreated_at"),
                    \DB::raw("COUNT(*) as count"),
                    \DB::raw(
                        "MONTHNAME(ppv_purchases.created_at) as month_name"
                    ),
                ]);
       
            $total_contentss = $total_content->groupBy("month_name");

            $Livestream_purchase = LiveStream::join("live_purchases", "live_purchases.video_id","=","live_streams.id")
                                                ->join("users", "users.id", "=", "live_purchases.user_id")
                                                ->groupBy("live_purchases.id")
                                                ->get();


            $data = [
                "settings" => $settings,
                "total_content" => $total_content,
                "total_video_count" => count($total_content),
                "total_contentss" => $total_contentss,
                "currency" => CurrencySetting::first(),
                "Livestream_purchase" => $Livestream_purchase ,
            ];
            return view("admin.analytics.live_purchased_analytics", $data);
        } else {
            return Redirect::to("/blocked");
        }
    }

    public function PurchasedLiveStartDateRevenue(Request $request)
    {
        $user_package = User::where("id", 1)->first();
        $package = $user_package->package;
        if (
            (!empty($package) && $package == "Pro") ||
            (!empty($package) && $package == "Business")
        ) {
            $data = $request->all();

            $start_time = $data["start_time"];
            $end_time = $data["end_time"];
            if (!empty($start_time) && empty($end_time)) {
                $settings = Setting::first();

                $total_content = LiveStream::join(
                    "ppv_purchases",
                    "ppv_purchases.live_id",
                    "=",
                    "live_streams.id"
                )
                    ->join("users", "users.id", "=", "ppv_purchases.user_id")
                    ->groupBy("ppv_purchases.id")
                    ->whereDate("ppv_purchases.created_at", ">=", $start_time)

                    ->get([
                        \DB::raw("live_streams.*"),
                        \DB::raw("users.username"),
                        \DB::raw("users.email"),
                        \DB::raw("ppv_purchases.total_amount"),
                        \DB::raw("ppv_purchases.created_at as ppvcreated_at"),
                        // DB::raw(
                        //     "sum(ppv_purchases.total_amount) as total_amount"
                        // ),
                        \DB::raw("COUNT(*) as count"),
                        \DB::raw(
                            "MONTHNAME(ppv_purchases.created_at) as month_name"
                        ),
                    ]);

                // echo "<pre>";print_r($total_content);exit;
            } else {
            }

            $output = "";
            $i = 1;
            if (count($total_content) > 0) {
                $total_row = $total_content->count();
                if (!empty($total_content)) {
                    $currency = CurrencySetting::first();

                    foreach ($total_content as $key => $row) {
                        $video_url =
                            URL::to("/category/videos") . "/" . $row->slug;
                        $date = date_create($row->ppvcreated_at);
                        $newDate = date_format($date, "d M Y");

                        $output .=
                            '
                      <tr>
                      <td>' .
                            $i++ .
                            '</td>
                      <td>' .
                            $row->username .
                            '</td>
                      <td>' .
                            $row->email .
                            '</td>    
                      <td><a href="' .
                            $video_url .
                            '">' .
                            $row->title .
                            '</a></td>    
                      <td>' .
                            $currency->symbol .
                            " " .
                            $row->total_amount .
                            '</td>    
                      <td>' .
                            $newDate .
                            '</td>    
                      </tr>
                      ';
                    }
                } else {
                    $output = '
                  <tr>
                   <td align="center" colspan="5">No Data Found</td>
                  </tr>
                  ';
                }
                $value = [
                    "table_data" => $output,
                    "total_data" => $total_row,
                    "total_content" => $total_content,
                ];

                return $value;
            }
        } else {
            return Redirect::to("/blocked");
        }
    }

    public function PurchasedLiveEndDateRevenue(Request $request)
    {
        $user_package = User::where("id", 1)->first();
        $package = $user_package->package;
        if (
            (!empty($package) && $package == "Pro") ||
            (!empty($package) && $package == "Business")
        ) {
            $data = $request->all();

            $start_time = $data["start_time"];
            $end_time = $data["end_time"];

            if (!empty($start_time) && !empty($end_time)) {
                $total_content = LiveStream::join(
                    "ppv_purchases",
                    "ppv_purchases.live_id",
                    "=",
                    "live_streams.id"
                )
                    ->join("users", "users.id", "=", "ppv_purchases.user_id")
                    ->groupBy("ppv_purchases.id")
                    ->whereBetween("ppv_purchases.created_at", [
                        $start_time,
                        $end_time,
                    ])
                    ->get([
                        \DB::raw("live_streams.*"),
                        \DB::raw("users.username"),
                        \DB::raw("users.email"),
                        \DB::raw("ppv_purchases.total_amount"),
                        \DB::raw("ppv_purchases.created_at as ppvcreated_at"),
                        \DB::raw("COUNT(*) as count"),
                        \DB::raw(
                            "MONTHNAME(ppv_purchases.created_at) as month_name"
                        ),
                    ]);
            } else {
                $total_content = [];
            }

            $output = "";
            $i = 1;
            if (count($total_content) > 0) {
                $total_row = $total_content->count();
                if (!empty($total_content)) {
                    $currency = CurrencySetting::first();

                    foreach ($total_content as $key => $row) {
                        $video_url =
                            URL::to("/category/videos") . "/" . $row->slug;
                        $date = date_create($row->ppvcreated_at);
                        $newDate = date_format($date, "d M Y");

                        $output .=
                            '
                      <tr>
                      <td>' .
                            $i++ .
                            '</td>
                      <td>' .
                            $row->username .
                            '</td>
                      <td>' .
                            $row->email .
                            '</td>    
                      <td>
                      <a href="' .
                            $video_url .
                            '">' .
                            $row->title .
                            '</a>
                                    </td>       
                      <td>' .
                            $currency->symbol .
                            " " .
                            $row->total_amount .
                            '</td>    
                      <td>' .
                            $newDate .
                            '</td>    
                      </tr>
                      ';
                    }
                } else {
                    $output = '
                  <tr>
                   <td align="center" colspan="5">No Data Found</td>
                  </tr>
                  ';
                }
                $value = [
                    "table_data" => $output,
                    "total_data" => $total_row,
                    "total_content" => $total_content,
                ];

                return $value;
            }
        } else {
            return Redirect::to("/blocked");
        }
    }

    public function PurchasedLiveExportCsv(Request $request)
    {
        $user_package = User::where("id", 1)->first();
        $package = $user_package->package;
        if (
            (!empty($package) && $package == "Pro") ||
            (!empty($package) && $package == "Business")
        ) {
            $data = $request->all();

            $start_time = $data["start_time"];
            $end_time = $data["end_time"];

            if (!empty($start_time) && empty($end_time)) {
                $total_content = LiveStream::join(
                    "ppv_purchases",
                    "ppv_purchases.live_id",
                    "=",
                    "live_streams.id"
                )
                    ->join("users", "users.id", "=", "ppv_purchases.user_id")
                    ->groupBy("ppv_purchases.id")
                    ->whereDate("ppv_purchases.created_at", ">=", $start_time)
                    ->get([
                        \DB::raw("live_streams.*"),
                        \DB::raw("users.username"),
                        \DB::raw("users.email"),
                        \DB::raw("ppv_purchases.total_amount"),
                        \DB::raw("ppv_purchases.created_at as ppvcreated_at"),
                        \DB::raw("COUNT(*) as count"),
                        \DB::raw(
                            "MONTHNAME(ppv_purchases.created_at) as month_name"
                        ),
                    ]);
            } elseif (!empty($start_time) && !empty($end_time)) {
                $total_content = LiveStream::join(
                    "ppv_purchases",
                    "ppv_purchases.live_id",
                    "=",
                    "live_streams.id"
                )
                    ->join("users", "users.id", "=", "ppv_purchases.user_id")
                    ->groupBy("ppv_purchases.id")
                    ->whereBetween("ppv_purchases.created_at", [
                        $start_time,
                        $end_time,
                    ])
                    ->get([
                        \DB::raw("live_streams.*"),
                        \DB::raw("users.username"),
                        \DB::raw("users.email"),
                        \DB::raw("ppv_purchases.total_amount"),
                        \DB::raw("ppv_purchases.created_at as ppvcreated_at"),
                        \DB::raw("COUNT(*) as count"),
                        \DB::raw(
                            "MONTHNAME(ppv_purchases.created_at) as month_name"
                        ),
                    ]);
            } else {
                $total_content = LiveStream::join(
                    "ppv_purchases",
                    "ppv_purchases.live_id",
                    "=",
                    "live_streams.id"
                )
                    ->join("users", "users.id", "=", "ppv_purchases.user_id")
                    ->groupBy("ppv_purchases.id")
                    ->get([
                        \DB::raw("live_streams.*"),
                        \DB::raw("users.username"),
                        \DB::raw("users.email"),
                        \DB::raw("ppv_purchases.total_amount"),
                        \DB::raw("ppv_purchases.created_at as ppvcreated_at"),
                        \DB::raw("COUNT(*) as count"),
                        \DB::raw(
                            "MONTHNAME(ppv_purchases.created_at) as month_name"
                        ),
                    ]);
            }
            $file = "PurchasedLiveAnalytics.csv";

            $headers = [
                "Content-Type" => "application/vnd.ms-excel; charset=utf-8",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Content-Disposition" => "attachment; filename=download.csv",
                "Expires" => "0",
                "Pragma" => "public",
            ];
            if (!File::exists(public_path() . "/uploads/csv")) {
                File::makeDirectory(public_path() . "/uploads/csv");
            }
            $filename = public_path("/uploads/csv/" . $file);
            $handle = fopen($filename, "w");
            fputcsv($handle, [
                "UserName",
                "Email",
                "Live Name",
                "Amount",
                "Purchased ON",
            ]);
            if (count($total_content) > 0) {
                foreach ($total_content as $each_user) {
                    $video_url =
                        URL::to("/category/videos") . "/" . $each_user->slug;
                    $date = date_create($each_user->ppvcreated_at);
                    $newDate = date_format($date, "d M Y");

                    fputcsv($handle, [
                        $each_user->username,
                        $each_user->email,
                        $each_user->title,
                        $each_user->total_amount,
                        $newDate,
                    ]);
                }
            }

            fclose($handle);

            \Response::download($filename, "download.csv", $headers);

            return $file;
        } else {
            return Redirect::to("/blocked");
        }
    }

    // Restream - Testing  
    public function youtube_start_restream_test(Request $request){

        $hlsUrl = $request->hls_url ;
        $streamingUrl = $request->streaming_url ;

        $command_line = "ffmpeg -re -i ".$hlsUrl." -c:v libx264 -c:a aac -f flv ".$streamingUrl;

        $process = Process::fromShellCommandline( $command_line);

        $process->setTimeout(0);
        $process->mustRun();

        return response()->stream(function() use ($process) {
            echo $process->getOutput();
        });
            
    }

        // Restream

    public function youtube_start_restream(Request $request){

        $hls_url       = $request->hls_url ;
        $streaming_url = $request->streaming_url ;

        $command_line = "ffmpeg -re -i ".$hls_url." -c:v libx264 -c:a aac -f flv ".$streaming_url;

        $process = Process::fromShellCommandline( $command_line);

        try {
            $process->setTimeout(0);
            $process->mustRun();

        } catch (ProcessFailedException $exception) {

            $response = array(
                'status'   => false,
                'message'  => "Error! while Re-stream video on YouTube." ,
                'Error_message'  => $exception->getMessage() ,
            );
        
            return response()->json($response, 200);
        }
    }

    public function fb_start_restream(Request $request){

        $hls_url       = $request->hls_url ;    
        $streaming_url = $request->streaming_url ;

        $command_line = "ffmpeg -re -i ".$hls_url." -c:v libx264 -c:a aac -f flv ".$streaming_url;

        $process = Process::fromShellCommandline( $command_line);

        try {
            $process->setTimeout(0);
            $process->mustRun();

        } catch (ProcessFailedException $exception) {

            $response = array(
                'status'   => false,
                'message'  => "Error! while Re-stream video on FaceBook" ,
                'Error_message'  => $exception->getMessage() ,
            );
        
            return response()->json($response, 200);
        }
    }

    public function twitter_start_restream(Request $request){

        $hls_url       = $request->hls_url ;
        $streaming_url = $request->streaming_url ;

        $command_line = "ffmpeg -re -i ".$hls_url." -c:v libx264 -c:a aac -f flv ".$streaming_url;

        $process = Process::fromShellCommandline( $command_line);

        try {
            $process->setTimeout(0);
            $process->mustRun();

        } catch (ProcessFailedException $exception) {

            $response = array(
                'status'   => false,
                'message'  => "Error! while Re-stream video on Twitter" ,
                'Error_message'  => $exception->getMessage() ,
            );
        
            return response()->json($response, 200);
        }
    }

    public function linkedin_start_restream(Request $request){

        $hls_url       = $request->hls_url ;
        $streaming_url = $request->streaming_url ;

        $command_line = "ffmpeg -re -i ".$hls_url." -c:v libx264 -c:a aac -f flv ".$streaming_url;

        $process = Process::fromShellCommandline( $command_line);

        try {
            $process->setTimeout(0);
            $process->mustRun();

        } catch (ProcessFailedException $exception) {

            $response = array(
                'status'   => false,
                'message'  => "Error! while Re-stream video on Linkedin" ,
                'Error_message'  => $exception->getMessage() ,
            );
        
            return response()->json($response, 200);
        }
    }

    public function youtube_stop_restream( Request $request )
    {
        $hls_url       = $request->hls_url ;
        $streaming_url = $request->streaming_url ;

        $command_line = "ffmpeg -re -i ".$hls_url." -c:v libx264 -c:a aac -f flv ".$streaming_url;

        $process = Process::fromShellCommandline( $command_line);

        try {
            $process->setTimeout(0);
            $process->stop();

        } catch (ProcessFailedException $exception) {

            $response = array(
                'status'   => false,
                'message'  => "Error! while Stop Re-stream video on YouTube." ,
                'Error_message'  => $exception->getMessage() ,
            );
        
            return response()->json($response, 200);
        }

       
    }

    public function Livestream_bulk_delete( Request $request )
    {
         try {
            $LiveStream_Video = $request->live_stream_video_id;

            LiveStream::whereIn("id", explode(",", $LiveStream_Video))->delete();

            return response()->json(["message" => "true"]);
        } 
        catch (\Throwable $th) {
            return response()->json(["message" => "false"]);
        }
    }

    public function live_ads_position(Request $request)
    {
        try {

            $Advertisement = Advertisement::whereNotNull('ads_path')->where('ads_position',$request->ads_position)
            ->where('status',1)->get();

            $response = array(
                'status'  => true,
                'message' => 'Successfully Retrieve Pre Advertisement Livestream',
                'live_ads'    => $Advertisement ,
            );

        } catch (\Throwable $th) {

            $response = array(
                'status' => false,
                'message' =>  $th->getMessage()
            );
        }
        return response()->json($response, 200);
    }

    public function destroy($id)
    {
        try {

            $livestream_details =LiveStream::findOrFail( $id )->first();

                // Image
            if (File::exists(base_path('public/uploads/images/'.$livestream_details->image))) {
                File::delete(base_path('public/uploads/images/'.$livestream_details->image));
            }

                // Player Image
            if (File::exists(base_path('public/uploads/images/'.$livestream_details->player_image))) {
                File::delete(base_path('public/uploads/images/'.$livestream_details->player_image));
            }

                // Tv Live Image
            if (File::exists(base_path('public/uploads/images/'.$livestream_details->Tv_live_image))) {
                File::delete(base_path('public/uploads/images/'.$livestream_details->Tv_live_image));
            }

                // Acc Audio File
            if (File::exists(base_path('public/uploads/LiveStream/'.$livestream_details->acc_audio_file))) 
            {
                File::delete(base_path('public/uploads/LiveStream/'.$livestream_details->acc_audio_file));
            }

                // Live Stream Video
            $live_stream_video = basename(substr($livestream_details->live_stream_video, 0, strrpos($livestream_details->live_stream_video, '.')));

            if (File::exists(base_path('public/uploads/LiveStream/'.$live_stream_video))) 
            {
                $directory = base_path('public/uploads/LiveStream/');
                   
                $pattern =  $live_stream_video.'*';

                $files = glob($directory . $pattern);

                foreach ($files as $file) {
                    File::delete($file);
                }
            }

            LiveStream::destroy($id);
            LiveLanguage::where("live_id", $id)->delete();
            CategoryLive::where("live_id", $id )->delete();

            return Redirect::back(); 

        } catch (\Throwable $th) {
            // return $th->getMessage();
           return abort(404);
        }
    }

    public function PPV_Free_Duration_Logs(Request $request)
    {

        $data = PPVFreeDurationLogs::where('source_id',$request->source_id)->where('source_type',$request->source_type);
        
                                if( !Auth::guest()  ){
                                    $data = $data->where('user_id',Auth::user()->id) ;
                                }
                                else{
                                    $data =  $data->where('IP_address', $this->userIp ) ;
                                }

        $result = $data->first();

        $inputs = array(
            "user_id"     => !Auth::guest() ? Auth::user()->id : null ,
            "IP_address"  => Auth::guest() ? $this->userIp : null ,
            "source_id"   => $request->source_id ,
            "source_type" => $request->source_type ,
            "duration"    => $result == null ?  $request->duration : $result->duration + $request->duration ,

        );

        $result == null ? PPVFreeDurationLogs::create($inputs) : PPVFreeDurationLogs::where('id',$result->id)->update($inputs) ;

        return response()->json($inputs['duration'], 200);
    }

    public function livestream_calendar(Request $request)
    {
        $current_timezone = current_timezone();
        $carbon_now = Carbon::now($current_timezone);

        $livestreams = LiveStream::where('active', 1)->where('status', 1)->get()->map(function($item){

            if ( $item->publish_type === 'publish_now' ) {

                $return = [
                    'title' => $item->title,
                    'start' =>  Carbon::parse($item->created_at)->format('Y-m-d'),
                    'end'   => Carbon::parse($item->created_at)->addMonths(3)->format('Y-m-d'),  
                    'color' => 'green',
                ];
            }

            if ( $item->publish_type === 'publish_later' ) {

                $return = [
                    'title' => $item->title,
                    'start' => Carbon::parse($item->publish_time)->format('Y-m-d'),
                    'end'   => Carbon::parse($item->publish_time)->addMonths(3)->format('Y-m-d'),  
                ];
            }

            if ( $item->publish_type === 'recurring_program' ) {

                switch ($item->recurring_program) {
                    
                    case 'custom':

                        $return = [
                            'title' => $item->title,
                            'start' => Carbon::parse($item->custom_start_program_time)->format('Y-m-d H:i:s'),
                            'end' => Carbon::parse($item->custom_end_program_time)->format('Y-m-d H:i:s'),  
                            'color' => 'purple', 
                        ];
                        break;

                        case 'daily':
                         
                    case 'weekly':

                        $return = [
                            'title' => $item->title,
                            'start' => Carbon::parse($item->program_start_time)->format('Y-m-d'),
                            'end'   => Carbon::parse($item->program_end_time)->format('Y-m-d'),  
                            'color' => 'red',
                        ];

                        // $livestream->recurring_program_week_day->format('N') && $livestream->program_start_time && $livestream->program_end_time ;
                        break;

                    case 'monthly':
                        // $recurring_program_live_animation = $livestream->recurring_program_month_day == $convert_time->format('d') && $livestream->program_start_time <= $convert_time->format('H:i') && $livestream->program_end_time >= $convert_time->format('H:i');
                        break;
                }
            }

            return $return; 
        });
        
        $data = array(
            'Current_date'  => $carbon_now->toDateString() ,
            'events'   => $livestreams ,
        );

        return View('admin.livestream.calendar',$data);
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $currentRouteName = Route::currentRouteName();
    
        if ($currentRouteName == "admin.radio-station.index") {
            $inputs_details_array = [
                'view_route' => "Radio_station_play",
                'edit_route' => "admin.radio-station.edit",
                'delete_route' => "admin.radio-station.delete",
                'all_list_route' => "admin.radio-station.index",
                'text_main_name' => "Radio Station",
                'stream_upload_via' => "radio_station",
            ];
        } else {
            $inputs_details_array = [
                'view_route' => "LiveStream_play",
                'edit_route' => "admin.livestream.edit",
                'delete_route' => "admin.livestream.delete",
                'all_list_route' => "admin.livestream.index",
                'text_main_name' => "Live Stream",
                'stream_upload_via' => "live_stream",
            ];
        }
    
        if (empty($search)) {
            return redirect()->route($inputs_details_array['all_list_route']);
        }
    
        $videos = LiveStream::where('title', 'like', "%{$search}%")
            ->orWhereHas('cppuser', function ($query) use ($search) {
                $query->where('username', 'like', "%{$search}%");
            })
            ->orWhereHas('usernames', function ($query) use ($search) {
                $query->where('username', 'like', "%{$search}%");
            })
            ->when($currentRouteName == "admin.livestream.index", function ($query) {
                return $query->where('stream_upload_via', '!=', 'radio_station');
            })
            ->orderBy('created_at', 'desc')
            ->get();
    
        return view('admin.livestream.search', compact('videos', 'inputs_details_array'))->render();
    }
}
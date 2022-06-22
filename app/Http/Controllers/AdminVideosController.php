<?php

namespace App\Http\Controllers;
use \App\User as User;
use \Redirect as Redirect;
use Illuminate\Http\Request;
use URL;
use File;
use App\Test as Test;
use App\Video as Video;
use App\CountryCode;
use App\MoviesSubtitles as MoviesSubtitles;
use App\VideoCategory as VideoCategory;
use App\VideoResolution as VideoResolution;
use App\VideosSubtitle as VideosSubtitle;
use App\Language as Language;
use App\AdsVideo as AdsVideo;
use App\Advertisement as Advertisement;
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
use App\ModeratorsUser;
use GifCreator\GifCreator;
use App\AgeCategory as AgeCategory;
use App\Setting as Setting;
use DB;
use App\BlockVideo;
use App\LanguageVideo;
use App\CategoryVideo;
use Exception;
use getID3;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use App\ReelsVideo;
use App\PpvPurchase as PpvPurchase;
use App\Adscategory;
use App\VideoSearchTag;
use App\RelatedVideo;



class AdminVideosController extends Controller
{
    public function index()
    {

           if (!Auth::user()->role == 'admin')
            {
                return redirect('/home');
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
            }else{
      // $search_value = Request::get('s');
        if(!empty($search_value)):
            $videos = Video::where('title', 'LIKE', '%'.$search_value.'%')->orderBy('created_at', 'desc')->paginate(9);
        else:
            // $videos = Video::orderBy('created_at', 'DESC')->paginate(9);
        $videos = Video::with('category.categoryname')->orderBy('created_at', 'DESC')->paginate(9);

        endif;
        // $video = Video::with('category.categoryname')->orderBy('created_at', 'DESC')->paginate(9);
        // echo "<pre>";
        // foreach($videos as $key => $value){
        //     print_r(@$value->category[$key]->categoryname->name);

        // }
        // exit();
    // $video = Video::with('category.categoryname')->where('id',156)->get();
        $user = Auth::user();

        $data = array(
            'videos' => $videos,
            'user' => $user,
            'admin_user' => Auth::user()
            );

        return View('admin.videos.index', $data);
            }
    }

    public function live_search(Request $request)
    {
        if($request->ajax())
     {

      $output = '';
      $query = $request->get('query');

         $slug = URL::to('/category/videos');
         $edit = URL::to('admin/videos/edit');
         $delete = URL::to('admin/videos/delete');
      if($query != '')
      {
        $data = Video::where('title', 'LIKE', '%'.$query.'%')->orderBy('created_at', 'desc')->paginate(9);

        //  $data = Video::select('videos.*','moderators_users.id','video_languages.name as languages_name','video_categories.name as categories_name')
        //  ->leftJoin('moderators_users', 'moderators_users.id', '=', 'videos.user_id')
        //  ->leftJoin('video_languages', 'video_languages.id', '=', 'videos.language')
        //  ->leftJoin('video_categories', 'video_categories.id', '=', 'videos.video_category_id')
        //  ->where('videos.title', 'like', '%'.$query.'%')
        //  ->paginate(9);

      }
      else
      {

      }

      $total_row = $data->count();
      if($total_row > 0)
      {
       foreach($data as $row)
       {
        if($row->active == 0){ $active = "Pending" ;$class="bg-warning"; }elseif($row->active == 1){ $active = "Approved" ;$class="bg-success"; } else{ $active = "Rejected" ;$class="bg-danger";}
        $username = @$row->cppuser->username ? 'Upload By'.' '.@$row->cppuser->username : "Upload By Admin";
        $output .= '
        <tr>
        <td>'.$row->title.'</td>
        <td>'.$row->rating.'</td>
        <td>'.$row->categories->name.'</td>
        <td>'.$username.'</td>
        <td class="'.$class.'" style="font-weight:bold;">'. $active.'</td>
        <td>'.$row->type.'</td>
         <td>'.$row->access.'</td>
        <td>'.@$row->languages->name.'</td>
         <td>'.$row->views.'</td>
         <td> '."<a class='iq-bg-warning' data-toggle='tooltip' data-placement='top' title='' data-original-title='View' href=' $slug/$row->slug'><i class='lar la-eye'></i>
        </a>".'
        '."<a class='iq-bg-success' data-toggle='tooltip' data-placement='top' title='' data-original-title='Edit' href=' $edit/$row->id'><i class='ri-pencil-line'></i>
        </a>".'
        '."<a class='iq-bg-danger' data-toggle='tooltip' data-placement='top' title='' data-original-title='Delete'  href=' $delete/$row->id'><i class='ri-delete-bin-line'></i>
        </a>".'
        </td>
        </tr>
        ';
       }
      }
      else
      {
       $output = '
       <tr>
        <td align="center" colspan="5">No Data Found</td>
       </tr>
       ';
      }
      $data = array(
       'table_data'  => $output,
       'total_data'  => $total_row
      );

      echo json_encode($data);
     }
    }

    public function CPPVideos(Request $request)
    {
        if($request->ajax())
     {

      $output = '';
      $query = $request->get('query');

         $slug = URL::to('/category/videos');
         $edit = URL::to('admin/videos/edit');
         $delete = URL::to('admin/videos/delete');
      if($query != '')
      {
            $data = Video::select('videos.*','moderators_users.username','video_languages.name as languages_name','video_categories.name as categories_name')
            ->leftJoin('video_languages', 'video_languages.id', '=', 'videos.language')
            ->leftJoin('video_categories', 'video_categories.id', '=', 'videos.video_category_id')
            ->Join('moderators_users', 'moderators_users.id', '=', 'videos.user_id')
            ->paginate(9);
 
      }
      else
      {

      }
   
      $total_row = $data->count();
      if($total_row > 0)
      {
       foreach($data as $row)
       {
if($row->active == 0){ $active = "Pending" ;$class="bg-warning"; }elseif($row->active == 1){ $active = "Approved" ;$class="bg-success"; } else{ $active = "Rejected" ;$class="bg-danger";}
        $output .= '
        <tr>
        <td>'.$row->title.'</td>
        <td>'.$row->rating.'</td>
        <td>'.$row->categories_name.'</td>
        <td>'.$row->username.'</td>
         <td class="'.$class.'" style="font-weight:bold;">'. $active.'</td>
         <td>'.$row->type.'</td>
         <td>'.$row->access.'</td>
        <td>'.$row->languages_name.'</td>
         <td>'.$row->views.'</td>
         <td> '."<a class='iq-bg-warning' data-toggle='tooltip' data-placement='top' title='' data-original-title='View' href=' $slug/$row->slug'><i class='lar la-eye'></i>
        </a>".'
        '."<a class='iq-bg-success' data-toggle='tooltip' data-placement='top' title='' data-original-title='Edit' href=' $edit/$row->id'><i class='ri-pencil-line'></i>
        </a>".'
        '."<a class='iq-bg-danger' data-toggle='tooltip' data-placement='top' title='' data-original-title='Delete'  href=' $delete/$row->id'><i class='ri-delete-bin-line'></i>
        </a>".'
        </td>
        </tr>
        ';
       }
      }
      else
      {
       $output = '
       <tr>
        <td align="center" colspan="5">No Data Found</td>
       </tr>
       ';
      }
      $data = array(
       'table_data'  => $output,
       'total_data'  => $total_row
      );

      echo json_encode($data);
     }
    }

    public function uploadFile(Request $request)
    {

        $value = array();
        $data = $request->all();

        $validator = Validator::make($request->all(), [
           'file' => 'required|mimes:video/mp4,video/x-m4v,video/*',
           
        ]);
        $mp4_url = (isset($data['file'])) ? $data['file'] : '';
        
        $path = public_path().'/uploads/videos/';
        
        
        $file = $request->file->getClientOriginalName();
        $newfile = explode(".mp4",$file);
        $file_folder_name = $newfile[0];
   
        $package = User::where('id',1)->first();
        $pack = $package->package;
        $mp4_url = $data['file'];
        $settings = Setting::first();

        if($mp4_url != '' && $pack != "Business" ) {
            // $ffprobe = \FFMpeg\FFProbe::create();
            // $disk = 'public';
            // $data['duration'] = $ffprobe->streams($request->file)
            // ->videos()
            // ->first()                  
            // ->get('duration'); 
            
            $rand = Str::random(16);
            $path = $rand . '.' . $request->file->getClientOriginalExtension();
        
            $request->file->storeAs('public', $path);
            $thumb_path = 'public';
            
            
            // $this->build_video_thumbnail($request->file,$path, $data['slug']);
            
            $original_name = ($request->file->getClientOriginalName()) ? $request->file->getClientOriginalName() : '';
            //  $storepath  = URL::to('/storage/app/public/'.$file_folder_name.'/'.$original_name);
            //  $str = explode(".mp4",$path);
            //  $path =$str[0];
            $storepath  = URL::to('/storage/app/public/'.$path);


            //  Video duration 
            $getID3 = new getID3;
            $Video_storepath  = storage_path('app/public/'.$path);       
            $VideoInfo = $getID3->analyze($Video_storepath);
            $Video_duration = $VideoInfo['playtime_seconds'];

            $video = new Video();
            $video->disk = 'public';
            $video->title = $file_folder_name;
            $video->original_name = 'public';
            $video->path = $path;
            $video->mp4_url = $storepath;
            $video->type = 'mp4_url';
            $video->draft = 0;
            $video->image = 'default_image.jpg';

            $PC_image_path = public_path('/uploads/images/default_image.jpg');

            if( file_exists($PC_image_path)){
                    $Mobile_image =  'Mobile-default_image.jpg' ;
                    $Tablet_image =  'Tablet-default_image.jpg' ;
                                
                    Image::make($PC_image_path)->save(base_path().'/public/uploads/images/'.$Mobile_image );
                    Image::make($PC_image_path)->save(base_path().'/public/uploads/images/'.$Tablet_image );
                
                    $video->mobile_image  = $Mobile_image;
                    $video->tablet_image  = $Tablet_image;
            }
            else{
                    $video->mobile_image  = 'default_image.jpg';
                    $video->tablet_image  = 'default_image.jpg';
            }

            $video->duration  = $Video_duration;
            $video->save(); 
            
        
            $video_id = $video->id;
            $video_title = Video::find($video_id);
            $title =$video_title->title; 

            $value['success'] = 1;
            $value['message'] = 'Uploaded Successfully!';
            $value['video_id'] = $video_id;
            $value['video_title'] = $title;

            return $value;
        
        }elseif($mp4_url != '' && $pack == "Business" && $settings->transcoding_access  == 1) {

            $rand = Str::random(16);
            $path = $rand . '.' . $request->file->getClientOriginalExtension();
            $request->file->storeAs('public', $path);
             
             $original_name = ($request->file->getClientOriginalName()) ? $request->file->getClientOriginalName() : '';
             
            $storepath  = URL::to('/storage/app/public/'.$path);


            //  Video duration 
            $getID3 = new getID3;
            $Video_storepath  = storage_path('app/public/'.$path);       
            $VideoInfo = $getID3->analyze($Video_storepath);
            $Video_duration = $VideoInfo['playtime_seconds'];
             
             $video = new Video();
             $video->disk = 'public';
             $video->status = 0;
             $video->original_name = 'public';
             $video->path = $path;
             $video->title = $file_folder_name;
             $video->mp4_url = $storepath;
             $video->draft = 0;
             $video->image = 'default_image.jpg';

             $PC_image_path = public_path('/uploads/images/default_image.jpg');

             if( file_exists($PC_image_path)){
                     $Mobile_image =  'Mobile-default_image.jpg' ;
                     $Tablet_image =  'Tablet-default_image.jpg' ;
                                 
                     Image::make($PC_image_path)->save(base_path().'/public/uploads/images/'.$Mobile_image );
                     Image::make($PC_image_path)->save(base_path().'/public/uploads/images/'.$Tablet_image );
                 
                     $video->mobile_image  = $Mobile_image;
                     $video->tablet_image  = $Tablet_image;
             }
             else{
                     $video->mobile_image  = 'default_image.jpg';
                     $video->tablet_image  = 'default_image.jpg';
             }

             $video->duration  = $Video_duration;
             $video->user_id = Auth::user()->id;
             $video->save();

             ConvertVideoForStreaming::dispatch($video);
             $video_id = $video->id;
             $video_title = Video::find($video_id);
             $title =$video_title->title; 
      
              $value['success'] = 1;
              $value['message'] = 'Uploaded Successfully!';
              $value['video_id'] = $video_id;
              $value['video_title'] = $title;
              
              return $value;
        }elseif($mp4_url != '' && $pack == "Business"  && $settings->transcoding_access  == 0 ) {

            $rand = Str::random(16);
            $path = $rand . '.' . $request->file->getClientOriginalExtension();
        
            $request->file->storeAs('public', $path);
            $thumb_path = 'public';
                        
            $original_name = ($request->file->getClientOriginalName()) ? $request->file->getClientOriginalName() : '';

            $storepath  = URL::to('/storage/app/public/'.$path);


            //  Video duration 
            $getID3 = new getID3;
            $Video_storepath  = storage_path('app/public/'.$path);       
            $VideoInfo = $getID3->analyze($Video_storepath);
            $Video_duration = $VideoInfo['playtime_seconds'];

            $video = new Video();
            $video->disk = 'public';
            $video->title = $file_folder_name;
            $video->original_name = 'public';
            $video->path = $path;
            $video->mp4_url = $storepath;
            $video->type = 'mp4_url';
            $video->draft = 0;
            $video->image = 'default_image.jpg';

            $PC_image_path = public_path('/uploads/images/default_image.jpg');

            if( file_exists($PC_image_path)){
                    $Mobile_image =  'Mobile-default_image.jpg' ;
                    $Tablet_image =  'Tablet-default_image.jpg' ;
                                
                    Image::make($PC_image_path)->save(base_path().'/public/uploads/images/'.$Mobile_image );
                    Image::make($PC_image_path)->save(base_path().'/public/uploads/images/'.$Tablet_image );
                
                    $video->mobile_image  = $Mobile_image;
                    $video->tablet_image  = $Tablet_image;
            }
            else{
                    $video->mobile_image  = 'default_image.jpg';
                    $video->tablet_image  = 'default_image.jpg';
            }

            $video->duration  = $Video_duration;
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
            $settings = Setting::first();
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

        $data = array(
            'headline' => '<i class="fa fa-plus-circle"></i> New Video',
            'post_route' => URL::to('admin/videos/fileupdate'),
            'button_text' => 'Add New Video',
            'admin_user' => Auth::user(),
            'related_videos' => Video::get(),
            'video_categories' => VideoCategory::all(),
            'ads' => Advertisement::where('status','=',1)->get(),
            'video_subtitle' => VideosSubtitle::all(),
            'languages' => Language::all(),
            'subtitles' => Subtitle::all(),
            'artists' => Artist::all(),
            'age_categories' => AgeCategory::all(),
            'settings' => $settings,
            'countries' => CountryCode::all(),
            'video_artist' => [],
            'page' => 'Creates',
            'ads_category' => Adscategory::all(),
            );


        return View::make('admin.videos.fileupload', $data);
                    // 'post_route' => URL::to('admin/videos/store'),


        // return View::make('admin.videos.create_edit', $data);
            }
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
            //   $data['image']  = $file->getClientOriginalName();
            $data['image'] = str_replace(' ', '_', $file->getClientOriginalName());

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
         /*Advertisement Video update starts*/
            // if($data['ads_id'] != 0){
            //         $ad_video = new AdsVideo;
            //         $ad_video->video_id = $video->id;
            //         $ad_video->ads_id = $data['ads_id'];
            //         $ad_video->ad_roll = null;
            //         $ad_video->save();
            // }
            /*Advertisement Video update ends*/ 
        
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
        return Redirect::to('admin/videos')->with(array('message' => 'Successfully Deleted Video', 'note_type' => 'success') );
    }
    
    
    public function edit($id)
    {


        if (!Auth::user()->role == 'admin')
        {
            return redirect('/home');
        }
        $settings = Setting::first();
        
       $video = Video::find($id);

       $ads_details = AdsVideo::join('advertisements','advertisements.id','ads_videos.ads_id') 
            ->where('ads_videos.video_id', $id)->pluck('ads_id')->first(); 

        $ads_rolls = AdsVideo::join('advertisements','advertisements.id','ads_videos.ads_id') 
            ->where('ads_videos.video_id', $id)->pluck('ad_roll')->first(); 

        $ads_category = Adscategory::get();

        $Reels_videos = Video::Join('reelsvideo','reelsvideo.video_id','=','videos.id')->where('videos.id',$id)->get();
        $related_videos = Video::get();

        $all_related_videos = RelatedVideo::where('video_id', $id)->pluck('related_videos_id')->toArray();
        // dd($all_related_videos);
        $data = array(
            'headline' => '<i class="fa fa-edit"></i> Edit Video',
            'video' => $video,
            'post_route' => URL::to('admin/videos/update'),
            'button_text' => 'Update Video',
            'admin_user' => Auth::user(),
            'video_categories' => VideoCategory::all(),
            'ads' => Advertisement::where('status','=',1)->get(),
            'video_subtitle' => VideosSubtitle::all(),
            'subtitles' => Subtitle::all(),
            'languages' => Language::all(),
            'artists' => Artist::all(),
            'settings' => $settings,
            'related_videos' => Video::get(),
            'all_related_videos' => RelatedVideo::where('video_id', $id)->pluck('related_videos_id')->toArray(),
            'age_categories' => AgeCategory::get(),
            'countries' => CountryCode::all(),
            'video_artist' => Videoartist::where('video_id', $id)->pluck('artist_id')->toArray(),
            'category_id' => CategoryVideo::where('video_id', $id)->pluck('category_id')->toArray(),
            'languages_id' => LanguageVideo::where('video_id', $id)->pluck('language_id')->toArray(),
            'block_countries' => BlockVideo::where('video_id', $id)->pluck('country_id')->toArray(),
            'page' => 'Edit',
            'Reels_videos' => $Reels_videos,
            'ads_paths' => $ads_details ? $ads_details : 0 ,
            'ads_rolls' => $ads_rolls ? $ads_rolls : 0 ,
            'ads_category' => $ads_category,
            'block_countries' => BlockVideo::where('video_id', $id)->pluck('country_id')->toArray(),
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
            'title' => 'required|max:255',
        ]);

            $id = $request->videos_id;


            /*Advertisement Video update starts*/
            // if($data['ads_id'] != 0){
            //         $ad_video = AdsVideo::where('video_id',$id)->first();

            //         if($ad_video == null){
            //             $ad_video = new AdsVideo;
            //         }
            //         $ad_video->video_id = $id;
            //         $ad_video->ads_id = $data['ads_id'];
            //         $ad_video->ad_roll = null;
            //         $ad_video->save();
            //     }
            /*Advertisement Video update ends*/ 

            $video = Video::findOrFail($id);

            if($request->slug == ''){
                $data['slug'] = $this->createSlug($data['title']);    
            }else{
                $data['slug'] = $request->slug;    
            }
        
           $image         =  (isset($data['image'])) ? $data['image'] : '';
           $trailer       =  (isset($data['trailer'])) ? $data['trailer'] : '';
           $mp4_url2      =  (isset($data['video'])) ? $data['video'] : '';
           $files         =  (isset($data['subtitle_upload'])) ? $data['subtitle_upload'] : '';
           $player_image  =  (isset($data['player_image'])) ? $data['player_image'] : '';
           $image_path    =   public_path().'/uploads/images/';
          
            if($player_image != '') {     
                if($player_image != ''  && $player_image != null){   //code for remove old file
                        $file_old = $image_path.$player_image;

                    if (file_exists($file_old)){
                        unlink($file_old);
                    }
                }
                
                                //upload new file

                $player_image = $player_image;   
                // $data['player_image']  = $player_image->getClientOriginalName();
                $data['player_image'] = str_replace(' ', '_', $player_image->getClientOriginalName());

                $player_image->move($image_path, $data['player_image']);
                // $player_image = $file->getClientOriginalName();
               $player_image = str_replace(' ', '_', $player_image->getClientOriginalName());
  
            } 
            else {
               $player_image = $video->image;
            }

                            // Trailer Update

            $video->trailer_type = $data['trailer_type'];

            if($data['trailer_type'] == 'video_mp4'){

               if(!empty($trailer)) {   
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
                      $video->trailer = URL::to('/').'/public/uploads/videos/'.$trailer_vid;
                   } 
                   else 
                   {
                       $data['trailer'] = $video->trailer;
                   }  
   
            }elseif($data['trailer_type'] == 'm3u8_url'){

                $video->trailer = $data['m3u8_trailer'];
            }
            elseif($data['trailer_type'] == 'mp4_url'){

                $video->trailer = $data['mp4_trailer'];
            }
            elseif($data['trailer_type'] == 'embed_url'){

                $video->trailer = $data['embed_trailer'];
            }
                   
           
           $update_mp4 = $request->get('video');

           if(empty($data['active'])){
                $active = 0;
                $status = 0;
            }  
            else{
                $active = 1;
                $status = 1;
            }
        
            if(empty($data['webm_url'])){
                $data['webm_url'] = 0;
            }  
            else {
                $data['webm_url'] =  $data['webm_url'];
            }  

            if(empty($data['ogg_url'])){
                $data['ogg_url'] = 0;
            }  
            else {
                $data['ogg_url'] =  $data['ogg_url'];
            }  

            if(empty($data['year'])){
                $year = 0;
            }
            else {
                $year =  $data['year'];
            }   
        
            if(empty($data['language'])){
                $data['language'] = 0;
            }  
            else {
                $data['language'] = $data['language'];
            } 

            if(!empty($video->mp4_url)){
                $data['mp4_url'] = $video->mp4_url;
            } 
            else {
                $data['mp4_url'] = null;
            } 

            if(!empty($video->embed_code)){
                $data['embed_code'] = $video->embed_code;
            }  
            else {
                $data['embed_code'] = null;
            } 
            
            if(empty($data['age_restrict'])){
                $data['age_restrict'] = 0;
            }  
            else {
                $data['age_restrict'] = $data['age_restrict'];
            } 
    
            if(empty($data['featured'])){
                $featured = 0;
            }
            else{
                $featured = 1;
            }  

            if(empty($data['active'])){
                    $active = 0;
                    $status = 0;
                    $draft = 1;
            }else{
                    $active = 1;
                    $status = 1;
                    $draft = 1;
            }  
           
            if(!empty($data['embed_code'])){
                $data['embed_code'] = $data['embed_code'];
            } 

            if(!empty($data['m3u8_url'])){
                $data['m3u8_url'] = $data['m3u8_url'];
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
            if(empty($data['publish_status'])){
                $data['publish_status'] = 0;
            }   

            if(empty($data['publish_status'])){
                $data['publish_status'] = 0;
            }   
            
            if(Auth::user()->role =='admin' && Auth::user()->sub_admin == 0 ){
                    $data['status'] = 1;    
            }

            if( Auth::user()->role =='admin' && Auth::user()->sub_admin == 1 ){
                    $data['status'] = 0;    
            }

        
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
              $filename  = time().'.webp';

              $PC_image     =  'PC'.$filename ;
              $Mobile_image =  'Mobile'.$filename ;
              $Tablet_image =  'Tablet'.$filename ;
              
              Image::make($file)->save(base_path().'/public/uploads/images/'.$PC_image,80 );
              Image::make($file)->save(base_path().'/public/uploads/images/'.$Mobile_image,80 );
              Image::make($file)->save(base_path().'/public/uploads/images/'.$Tablet_image,80 );

             $video->image  = $PC_image;
             $video->mobile_image  = $Mobile_image;
             $video->tablet_image  = $Tablet_image;

        } else {
             $data['image'] = $video->image;
         }
        
        if(isset($data['duration'])){
                //$str_time = $data
                $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $data['duration']);
                sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                $data['duration'] = $time_seconds;
        }

        if( $mp4_url2 != ''){  
            $data['status'] = 0; 
            $data['processed_low'] = 0; 
              //code for remove old file
               $rand = Str::random(16);
                $path = $rand . '.' . $request->video->getClientOriginalExtension();
                $request->video->storeAs('public', $path);
                $data['mp4_url'] = $path;
                $data['path'] = $path;
                $data['status'] = 0;
                $data['processed_low'] = 0; 
                $video->update($data);
                
                // $original_name = ($request->video->getClientOriginalName()) ? $request->video->getClientOriginalName() : '';
                $original_name = URL::to('/').'/storage/app/public/'.$path;
                ConvertVideoForStreaming::dispatch($video);
        }

       
        if(!empty($data['embed_code'])) {
             $video->embed_code = $data['embed_code'];
        }else {
            $video->embed_code = '';
        }

        if(!empty($data['global_ppv'])){
             $video->global_ppv =$data['global_ppv'];
        }
        else{
            $video->global_ppv = null;
        }  

        if(!empty($data['enable'])){
             $enable =$data['enable'];
        }else{
             $enable = 0;
        }   

        if(!empty($data['banner'])){
            $banner =$data['banner'];
        }else{
            $banner = 0;
        }   

        if(!empty($data['embed_code'])){    
            $embed_code =$data['embed_code'];
        }else{
            $embed_code = null;
        }   

        if(!empty($data['mp4_url'])){
            $mp4_url =$data['mp4_url'];
        }else{
            $mp4_url = null;
        }   

        if(!empty($data['m3u8_url'])){
            $m3u8_url =$data['m3u8_url'];
        }
        else{
            $m3u8_url = null;
        } 

        if(!empty($data['title'])){
            $video->title =$data['title'];
        }else{ }  

        if(!empty($data['slug'])){
            $video->slug =$data['slug'];
        }else{ }  

        if(empty($data['publish_type'])){
            $publish_type = 0;
        }else{
             $publish_type =   $data['publish_type'];
        }  

        if(empty($data['publish_time'])){
            $publish_time =0;
        }else{
            $publish_time =   $data['publish_time'];
        }

        if(!empty($data['Recommendation'])){
            $video->Recommendation =  $data['Recommendation'];
        } 

        if(empty($data['age_restrict'])){
            $video->age_restrict=$data['age_restrict'];
        } 

        if(!empty($data['details'])){
            $video->details = $data['details'];
        }
              if(!empty($data['details'])){
            $video->details = $data['details'];
        }

        if($request->pdf_file != null){
            $pdf_files = time().'.'.$request->pdf_file->extension();  
            $request->pdf_file->move(public_path('uploads/videoPdf'), $pdf_files);
            $video->pdf_files =  $pdf_files;
        }

                 // Reels videos
        $reels_videos= $request->reels_videos;
            

        if($reels_videos != null){

            ReelsVideo::where('video_id', $video->id)->delete();

            foreach($reels_videos as $Reel_Videos)
            {
                $reelvideo_name = time().rand(1,50).".".$Reel_Videos->extension();  
                $reel_videos_slug = substr($Reel_Videos->getClientOriginalName() , 0, strpos($Reel_Videos->getClientOriginalName() , '.'));
                
                $reelvideo_names = 'reels'.$reelvideo_name;
                $reelvideo = $Reel_Videos->move(public_path('uploads/reelsVideos'), $reelvideo_name);

                $ffmpeg = \FFMpeg\FFMpeg::create();
                $videos = $ffmpeg->open('public/uploads/reelsVideos'.'/'.$reelvideo_name);
                $videos->filters()->clip(TimeCode::fromSeconds(1), TimeCode::fromSeconds(60));
                $videos->save(new \FFMpeg\Format\Video\X264('libmp3lame'), 'public/uploads/reelsVideos'.'/'.$reelvideo_names);

                unlink($reelvideo);

                    $Reels_videos = new ReelsVideo;
                    $Reels_videos->video_id = $video->id;
                    $Reels_videos->reels_videos = $reelvideo_names;
                    $Reels_videos->reels_videos_slug = $reel_videos_slug;
                    $Reels_videos->save();

                $video->reels_thumbnail =  'default.jpg' ;

            }
        }

                // Reels Thumbnail

        if(!empty($request->reels_thumbnail)){

            $Reels_thumbnail = 'reels_'.time().'.'.$request->reels_thumbnail->extension();  
            $request->reels_thumbnail->move(public_path('uploads/images'), $Reels_thumbnail);

            $video->reels_thumbnail =  $Reels_thumbnail ;
        }



                     //URL Link
        $url_link = $request->url_link;

        if($url_link != null){
            $video->url_link =  $url_link;
        }

        $url_linktym = $request->url_linktym;

        if($url_linktym != null){
              $StartParse = date_parse($request->url_linktym);
              $startSec = $StartParse['hour'] * 60 *60 + $StartParse['minute'] * 60 + $StartParse['second'];
              $video->url_linktym =  $url_linktym;
              $video->url_linksec =  $startSec ;
              $video->urlEnd_linksec =  $startSec + 60 ;
        }

        if(!empty($data['default_ads'])){
            $video->default_ads = $data['default_ads'];
        }else{
            $video->default_ads = 0;
        }

        if(!empty($data['searchtags'])){
            $searchtags = $data['searchtags'];
        }else{
            $searchtags = $video->searchtags;
        }

        $video->ads_category =  $data['ads_category'];   
        $shortcodes = $request['short_code'];        
        $languages=$request['sub_language'];
        $video->mp4_url =  $data['mp4_url'];
        $video->duration = $data['duration'];
        $video->language=$request['language'];
        $video->skip_recap =  $request['skip_recap'];
        $video->recap_start_time =  $request['recap_start_time'];
        $video->recap_end_time =  $request['recap_end_time'];
        $video->skip_intro =  $request['skip_intro'];
        $video->intro_start_time =  $request['intro_start_time'];
        $video->intro_end_time =  $request['intro_end_time'];
        $video->country =  $request['video_country'];
        $video->publish_status = $request['publish_status'];
        $video->publish_type = $publish_type;
        $video->publish_time = $publish_time;
        $video->age_restrict=$data['age_restrict'];
        $video->access=$data['access'];
        //  $video->active=1;
        $video->player_image = $player_image ;
        $video->year = $year ;
        $video->m3u8_url=$m3u8_url ;
        $video->mp4_url=$mp4_url ;
        $video->embed_code=$embed_code ;
        $video->featured=$featured ;
        $video->active=$active ;
        $video->status=$status ;
        $video->draft=$draft ;
        $video->banner=$banner ;
        $video->ppv_price =$data['ppv_price'];
        $video->type =$data['type'];
        $video->description = strip_tags($data['description']);
        $video->trailer_description = strip_tags($data['trailer_description']);
        $video->banner =  $banner;
        $video->enable =  $enable;
        $video->rating =  $request->rating;
        $video->search_tags =  $searchtags;        
        $video->save();


                        // Related Video 
        if(!empty($data['related_videos'])){

            RelatedVideo::where('video_id', $video->id)->delete();

            $related_videos = $data['related_videos'];
           
            if(!empty($related_videos)){
                foreach ($related_videos as $key => $vid) {
                    // RelatedVideo::where('video_id', $video->id)->delete();
                    $videos = Video::where('id',$vid)->get();
                    foreach ($videos as $key => $val) {
                    $RelatedVideo = new RelatedVideo;
                    $RelatedVideo->video_id = $video->id;
                    $RelatedVideo->user_id = Auth::user()->id;
                    $RelatedVideo->related_videos_id = $val->id;
                    $RelatedVideo->related_videos_title = $val->title;
                    $RelatedVideo->save();
                    }
                }                    
            }
        }

        if(!empty($data['artists'])){
            $artistsdata = $data['artists'];
            unset($data['artists']);
                if(!empty($artistsdata)){
                    Videoartist::where('video_id', $video->id)->delete();

                    foreach ($artistsdata as $key => $value) {
                        $artist = new Videoartist;
                        $artist->video_id = $video->id;
                        $artist->artist_id = $value;
                        $artist->save();
                    }
                }
        }else{
            Videoartist::where('video_id', $video->id)->delete();
        }

        if(!empty($data['searchtags'])){
            $searchtags = explode(',',$data['searchtags']);
            VideoSearchTag::where('video_id', $video->id)->delete();

                foreach ($searchtags as $key => $value) {
                    $videosearchtags = new VideoSearchTag;
                    $videosearchtags->user_id = Auth::User()->id;
                    $videosearchtags->video_id = $video->id;
                    $videosearchtags->search_tag = $value;
                    $videosearchtags->save();
                }
        }else{
            // $searchtags = null;
        }

                // Category Video

        if(!empty($data['video_category_id'])){
            $category_id = $data['video_category_id'];
            // unset($data['video_category_id']);
            if(!empty($category_id)){
                CategoryVideo::where('video_id', $video->id)->delete();
                foreach ($category_id as $key => $value) {
                    $category = new CategoryVideo;
                    $category->video_id = $video->id;
                    $category->category_id = $value;
                    $category->save();
                }
            }
        }else{
            CategoryVideo::where('video_id', $video->id)->delete();

            $other_category = VideoCategory::where('slug','other_category')->first();

                if($other_category == null){

                    VideoCategory::create([
                        'user_id'   => null ,
                        'parent_id' => null ,
                        'order'     => '1' ,
                        'name'      => 'Other category' ,
                        'image'     => 'default.jpg' ,
                        'slug'      => 'other_category' ,
                        'in_home'   => '1' ,
                        'footer'    => null ,
                        'banner'    => '0' ,
                        'in_menu'   => null ,
                        'banner_image' => 'default.jpg' ,
                    ]);
                }

                $other_category_id = VideoCategory::where('slug','other_category')->pluck('id')->first();

                $category = new CategoryVideo;
                $category->video_id = $video->id;
                $category->category_id = $other_category_id;
                $category->save();
        }

                    // language
        if(!empty($data['language'])){
            $language_id = $data['language'];
            unset($data['language']);

            if(!empty($language_id)){
                LanguageVideo::where('video_id', $video->id)->delete();

                foreach ($language_id as $key => $value) {
                    $languagevideo = new LanguageVideo;
                    $languagevideo->video_id = $video->id;
                    $languagevideo->language_id = $value;
                    $languagevideo->save();
                }
            }
        }
        
                    // Block country 
        if(!empty($data['country'])){
            $country = $data['country'];
            unset($data['country']);

            if(!empty($country)){
                BlockVideo::where('video_id', $video->id)->delete();

                foreach ($country as $key => $value) {
                    $country = new BlockVideo;
                    $country->video_id = $video->id;
                    $country->country_id = $value;
                    $country->save();
                }
            }
        }
      
        if(!empty( $files != ''  && $files != null)){

            foreach ($files as $key => $val) {

                if(!empty($files[$key])){
                    
                    $destinationPath ='public/uploads/subtitles/';
                    $filename = $video->id. '-'.$shortcodes[$key].'.srt';
                    $files[$key]->move($destinationPath, $filename);
                    $subtitle_data['sub_language'] =$languages[$key]; /*URL::to('/').$destinationPath.$filename; */
                    $subtitle_data['shortcode'] = $shortcodes[$key]; 
                    $subtitle_data['movie_id'] = $id;
                    $subtitle_data['url'] = URL::to('/').'/public/uploads/subtitles/'.$filename; 
                    $video_subtitle = new MoviesSubtitles;
                    $video_subtitle->movie_id =  443 ;
                    $video_subtitle->shortcode =   $shortcodes[$key];
                    $video_subtitle->sub_language =  $languages[$key] ;
                    $video_subtitle->url =   URL::to('/').'/public/uploads/subtitles/'.$filename;
                    $video_subtitle->save();
                }
            }
        }


        return Redirect::to('admin/videos/edit' . '/' . $id)->with(array('message' => 'Successfully Updated Video!', 'note_type' => 'success') );
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
             $user_package = User::where('id',1)->first();
            $data = $request->all();
           
            $validatedData = $request->validate([
                'title' => 'required|max:255',
                // 'video_country' =>'required',
            ]);

            $id = $data['video_id'];
            $video = Video::findOrFail($id);
            // RelatedVideo

            // dd($videos);
            if(!empty($video->embed_code)) {
                $embed_code = $video->embed_code;
            }else{
                $embed_code = '';
            }

                // if(!empty($data['global_ppv'])){
                //     $settings = Setting::where('ppv_status','=',1)->first();
                //     if(!empty($settings)){
                   
                //         $data['ppv_price'] = $settings->ppv_price;
                //         $video->global_ppv = 1 ;
                //     }
                //     }  else {
                //     $video->global_ppv = null ;
                //     }  

            if(!empty($data['ppv_price']) && $data['ppv_price'] > 0){
                $video->global_ppv = 1 ;
            } 
            else{
                 $video->global_ppv = null ;
            }  

            $settings = Setting::where('ppv_status','=',1)->first();

            if(!empty($data['global_ppv'])){
                $data['ppv_price'] = $settings->ppv_price;
                $video->global_ppv = $data['global_ppv'] ;
            }else 
            {
                $video->global_ppv = null ;
            }  

            if($request->slug == ''){
                $data['slug'] = $this->createSlug($data['title']);    
            }else{
                $data['slug'] = $this->createSlug($data['slug']);    
            }
                        
            $image = (isset($data['image'])) ? $data['image'] : '';
            $trailer = (isset($data['trailer'])) ? $data['trailer'] : '';
            $files = (isset($data['subtitle_upload'])) ? $data['subtitle_upload'] : '';
            $player_image = (isset($data['player_image'])) ? $data['player_image'] : '';
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
                // $data['player_image']  = $file->getClientOriginalName();
            $data['player_image'] = str_replace(' ', '_', $player_image->getClientOriginalName());
                // dd($file->getClientOriginalName());
                $player_image->move($image_path, $data['player_image']);
                // $player_image = $file->getClientOriginalName();
               $player_image = str_replace(' ', '_', $player_image->getClientOriginalName());

  
  
           } else {
               $player_image = $video->image;
           }

            if(empty($data['active'])){
                $data['active'] = 0;
            } 
            
    
             if(empty($data['webm_url'])){
                $data['webm_url'] = 0;
            } else {
                $data['webm_url'] =  $data['webm_url'];
            }  
    
            if(empty($data['ogg_url'])){
                $data['ogg_url'] = 0;
            } else {
                $data['ogg_url'] =  $data['ogg_url'];
            }  
    
            if(empty($data['year'])){
                $data['year'] = 0;
            } else {
                $data['year'] =  $data['year'];
            }   
            if(empty($data['searchtags'])){
                $searchtags = null;
            } else {
                $searchtags =  $data['searchtags'];
            }   

            if(empty($data['language'])){
                $data['language'] = 0;
            }  else {
                $data['language'] = $data['language'];
            } 
            
            if(empty($data['featured'])){
               $featured = 0;
            }  else{
               $featured = 1;
            }

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
               
            // if(empty($data['type'])){
            //     $data['type'] = '';
            // }

            // if(empty($data['path'])){
            //     $data['path'] = 0;
            // } 
    
            if(empty($data['status'])){
                $data['status'] = 0;
            }   
    
            $package = User::where('id',1)->first();
            $pack = $package->package;

            if(Auth::user()->role =='admin' ){
                $data['status'] = 1;    
            }

                if(Auth::user()->role =='admin' &&  $pack != "Business"  ){
                        $data['status'] = 1;    
                    }elseif(Auth::user()->role =='admin' &&  $pack == "Business" && $settings->transcoding_access == 1 ){
                        $data['status'] = 0;    
                    }elseif(Auth::user()->role =='admin'&&  $pack == "Business" && $settings->transcoding_access == 0 ){
                        $data['status'] = 1;    
                    }else{
                        $data['status'] = 1;    
                    }
    
                if( Auth::user()->role =='admin' && Auth::user()->sub_admin == 1 ){
                        $data['status'] = 0;    
                }

                if(!empty($data['Recommendation'])) {
                    $video->Recommendation = $data['Recommendation'];
               }
               if(empty($data['publish_type'])){
                $publish_type = 0;
                }else{
                    $publish_type =   $data['publish_type'];
                }  
                // dd($publish_type);
                
            if(empty($data['publish_time'])){
                $publish_time =0;
                }else{
                    $publish_time =   $data['publish_time'];
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
                  $files = $data['image'];

                  $filename  = time().'.webp';

                  $PC_image     =  'PC'.$filename ;
                  $Mobile_image =  'Mobile'.$filename ;
                  $Tablet_image =  'Tablet'.$filename ;

                  
                  Image::make($files)->save(base_path().'/public/uploads/images/'.$PC_image,80 );
                  Image::make($files)->save(base_path().'/public/uploads/images/'.$Mobile_image,80 );
                  Image::make($files)->save(base_path().'/public/uploads/images/'.$Tablet_image,80 );

                 $video->mobile_image  = $Mobile_image;
                 $video->tablet_image  = $Tablet_image;
                 $data['image']        = $PC_image;

             } else {
                 $data['image'] = $video->image;
             }
            
            
             $video->trailer_type = $data['trailer_type'];

             if($data['trailer_type'] == 'video_mp4'){
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
 
             }elseif($data['trailer_type'] == 'm3u8_url'){
                 $data['trailer'] = $data['m3u8_trailer'];
             }
             elseif($data['trailer_type'] == 'mp4_url'){
                 $data['trailer'] = $data['mp4_trailer'];
             }
             elseif($data['trailer_type'] == 'embed_url'){
                 $data['trailer'] = $data['embed_trailer'];
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
            if(!empty($data['age_restrict'])) {
                $video->age_restrict =  $data['age_restrict'];
           }
           if(!empty($data['banner'])) {
            $banner =  1 ;
       }else{
        $banner =  0 ;

       }

           if(!empty($data['video_category_id'])){
            $video_category_id = implode(',',$request->video_category_id);

            $category_id = $video_category_id;
            }

            if($request->pdf_file != null){
                $pdf_files = time().'.'.$request->pdf_file->extension();  
                $request->pdf_file->move(public_path('uploads/videoPdf'), $pdf_files);
                $video->pdf_files =  $pdf_files;
            }

    // Reels videos
    $reels_videos= $request->reels_videos;
            

    if($reels_videos != null){

        foreach($reels_videos as $Reel_Videos)
        {
            $reelvideo_name = time().rand(1,50).".".$Reel_Videos->extension();  
            $reel_videos_slug = substr($Reel_Videos->getClientOriginalName() , 0, strpos($Reel_Videos->getClientOriginalName() , '.'));
            $reelvideo_names = 'reels'.$reelvideo_name;
            
            $reelvideo = $Reel_Videos->move(public_path('uploads/reelsVideos'), $reelvideo_name);

            $ffmpeg = \FFMpeg\FFMpeg::create();
            $videos = $ffmpeg->open('public/uploads/reelsVideos'.'/'.$reelvideo_name);
            $videos->filters()->clip(TimeCode::fromSeconds(1), TimeCode::fromSeconds(60));
            $videos->save(new \FFMpeg\Format\Video\X264('libmp3lame'), 'public/uploads/reelsVideos'.'/'.$reelvideo_names);

            unlink($reelvideo);

                $Reels_videos = new ReelsVideo;
                $Reels_videos->video_id = $video->id;
                $Reels_videos->reels_videos = $reelvideo_names;
                $Reels_videos->reels_videos_slug = $reel_videos_slug;
                $Reels_videos->save();

                $video->reels_thumbnail =  'default.jpg' ;
        }
    }

    // Reels Thumbnail

    if(!empty($request->reels_thumbnail)){

        $Reels_thumbnail = 'reels_'.time().'.'.$request->reels_thumbnail->extension();  
        $request->reels_thumbnail->move(public_path('uploads/images'), $Reels_thumbnail);

        $video->reels_thumbnail =  $Reels_thumbnail ;
    }

    //URL Link
            $url_link = $request->url_link;

            if($url_link != null){
                $video->url_link =  $url_link;
            }

            $url_linktym = $request->url_linktym;

            if($url_linktym != null){
                $StartParse = date_parse($request->url_linktym);
                $startSec = $StartParse['hour'] * 60 *60 + $StartParse['minute'] * 60 + $StartParse['second'];
                $video->url_linktym =  $url_linktym;
                $video->url_linksec =  $startSec ;
                $video->urlEnd_linksec =  $startSec + 60 ;
            }

            // Ads category

            $shortcodes = $request['short_code'];        
            $languages=$request['sub_language'];
            $video->video_category_id = null;
            $video->skip_recap =  $data['skip_recap'];
            $video->recap_start_time =  $data['recap_start_time'];
            $video->recap_end_time =  $data['recap_end_time'];
            $video->skip_intro =  $data['skip_intro'];
            $video->intro_start_time =  $data['intro_start_time'];
            $video->intro_end_time =  $data['intro_end_time'];   
            $video->ads_category =  $data['ads_category'];   

            $video->description = strip_tags($data['description']);
            $video->trailer_description = strip_tags($data['trailer_description']);

            $video->draft = 1;
            $video->active = 1 ;
            $video->embed_code =  $embed_code ;
            $video->player_image =   $player_image ;
            $video->publish_type = $publish_type;
            $video->publish_time = $publish_time;
             $video->age_restrict =  $data['age_restrict'];
            $video->ppv_price =$data['ppv_price'];
             $video->access =  $data['access'];
             $video->banner =  $banner;
             $video->featured =  $featured;
             $video->country =  $data['video_country'];
            $video->enable =  1;
            $video->search_tags =  $searchtags;

            if(!empty($data['default_ads'])){
                $video->default_ads = $data['default_ads'];
            }else{
                $video->default_ads = 0;
            }
           
             $video->update($data);
            //  dd($video);

             $video = Video::findOrFail($id);
            //  $users = User::all();
            //  if($video['draft'] == 1){
            //  foreach ($users as $key => $user) {
            //     //  $userid[]= $user->id;
            //     if(!empty($user->token)){
            // send_password_notification('Notification From FLICKNEXS','New Videp Added','',$user->id);
            //     }
            //  }
        //      foreach ($userid as $key => $user_id) {
        //    send_password_notification('Notification From FLICKNEXS','New Video Added','',$user_id);
        //     }
         
            // }
            if(!empty($data['video_category_id'])){
                $category_id = $data['video_category_id'];
                unset($data['video_category_id']);
                /*save artist*/
                if(!empty($category_id)){
                    CategoryVideo::where('video_id', $video->id)->delete();
                    foreach ($category_id as $key => $value) {
                        $category = new CategoryVideo;
                        $category->video_id = $video->id;
                        $category->category_id = $value;
                        $category->save();
                    }
    
                }
            }
            else{

                CategoryVideo::where('video_id', $video->id)->delete();
    
                $other_category = VideoCategory::where('slug','other_category')->first();
    
                    if($other_category == null){
    
                        VideoCategory::create([
                            'user_id'   => null ,
                            'parent_id' => null ,
                            'order'     => '1' ,
                            'name'      => 'Other category' ,
                            'image'     => 'default.jpg' ,
                            'slug'      => 'other_category' ,
                            'in_home'   => '1' ,
                            'footer'    => null ,
                            'banner'    => '0' ,
                            'in_menu'   => null ,
                            'banner_image' => 'default.jpg' ,
                        ]);
                    }
    
                    $other_category_id = VideoCategory::where('slug','other_category')->pluck('id')->first();
    
                    $category = new CategoryVideo;
                    $category->video_id = $video->id;
                    $category->category_id = $other_category_id;
                    $category->save();
            }


            if(!empty($data['related_videos'])){
                $related_videos = $data['related_videos'];
                // unset($data['related_videos']);
                /*save artist*/
                if(!empty($related_videos)){
                    
                    foreach ($related_videos as $key => $vid) {
                        $videos = Video::where('id',$vid)->get();
                        foreach ($videos as $key => $val) {
                         $RelatedVideo = new RelatedVideo;
                        $RelatedVideo->video_id = $id;
                        $RelatedVideo->user_id = Auth::user()->id;
                        $RelatedVideo->related_videos_id = $val->id;
                        $RelatedVideo->related_videos_title = $val->title;
                        $RelatedVideo->save();
                        }
           
                    }                    
                }
            }

            if(!empty($data['language'])){
                $language_id = $data['language'];
                unset($data['language']);
                /*save artist*/
                if(!empty($language_id)){
                    LanguageVideo::where('video_id', $video->id)->delete();
                    foreach ($language_id as $key => $value) {
                        $languagevideo = new LanguageVideo;
                        $languagevideo->video_id = $video->id;
                        $languagevideo->language_id = $value;
                        $languagevideo->save();
                    }
    
                }
            }
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

            if(!empty($data['searchtags'])){
                $searchtags = explode(',',$data['searchtags']);
                VideoSearchTag::where('video_id', $video->id)->delete();
                foreach ($searchtags as $key => $value) {
                    $videosearchtags = new VideoSearchTag;
                    $videosearchtags->user_id = Auth::User()->id;
                    $videosearchtags->video_id = $video->id;
                    $videosearchtags->search_tag = $value;
                    $videosearchtags->save();
                }
            }
    
            if(!empty($data['country'])){
                $country = $data['country'];
                unset($data['country']);
                /*save country*/
                if(!empty($country)){
                    BlockVideo::where('video_id', $video->id)->delete();
                    foreach ($country as $key => $value) {
                        $country = new BlockVideo;
                        $country->video_id = $video->id;
                        $country->country_id = $value;
                        $country->save();
                    }
    
                }
            }
          
    
            //  if(!empty( $files != ''  && $files != null)){
            // /*if($request->hasFile('subtitle_upload'))
            // {
            //     $files = $request->file('subtitle_upload');*/
           
            //     foreach ($files as $key => $val) {
            //         if(!empty($files[$key])){
                        
            //             $destinationPath ='public/uploads/subtitles/';
            //             $filename = $video->id. '-'.$shortcodes[$key].'.srt';
            //             $files[$key]->move($destinationPath, $filename);
            //             $subtitle_data['sub_language'] =$languages[$key]; /*URL::to('/').$destinationPath.$filename; */
            //             $subtitle_data['shortcode'] = $shortcodes[$key]; 
            //             $subtitle_data['movie_id'] = $id;
            //             $subtitle_data['url'] = URL::to('/').'/public/uploads/subtitles/'.$filename; 
            //             $video_subtitle = MoviesSubtitles::updateOrCreate(array('shortcode' => 'en','movie_id' => $id), $subtitle_data);
            //         }
            //     }
            // }
             if(!empty( $files != ''  && $files != null)){

            foreach ($files as $key => $val) {

                if(!empty($files[$key])){
                    
                    $destinationPath ='public/uploads/subtitles/';
                    $filename = $video->id. '-'.$shortcodes[$key].'.srt';
                    $files[$key]->move($destinationPath, $filename);
                    $subtitle_data['sub_language'] =$languages[$key]; /*URL::to('/').$destinationPath.$filename; */
                    $subtitle_data['shortcode'] = $shortcodes[$key]; 
                    $subtitle_data['movie_id'] = $id;
                    $subtitle_data['url'] = URL::to('/').'/public/uploads/subtitles/'.$filename; 
                    $video_subtitle = new MoviesSubtitles;
                    $video_subtitle->movie_id =  443 ;
                    $video_subtitle->shortcode =   $shortcodes[$key];
                    $video_subtitle->sub_language =  $languages[$key] ;
                    $video_subtitle->url =   URL::to('/').'/public/uploads/subtitles/'.$filename;
                    $video_subtitle->save();
                }
            }
        }
     /*Advertisement Video update starts*/
            //  if($data['ads_id'] != 0){
                  
            //         $ad_video = new AdsVideo;
            //         $ad_video->video_id = $video->id;
            //         $ad_video->ads_id = $data['ads_id'];
            //         $ad_video->ad_roll = null;
            //         $ad_video->save();
            // }
     /*Advertisement Video update End*/
    
    
            return Redirect::back()->with('message','Your video will be available shortly after we process it');
        }
    public function Mp4url(Request $request)
    {
        $data = $request->all();
        $value = array();
        
        if(!empty($data['mp4_url'])) {
             
            $video = new Video();
            $video->disk = 'public';
            $video->original_name = 'public';
            $video->title = $data['mp4_url'];
            $video->mp4_url = $data['mp4_url'];
            $video->type = 'mp4_url';
            $video->draft = 0;
            $video->active = 1 ;
            $video->image = 'default_image.jpg';
            
            $PC_image_path = public_path('/uploads/images/default_image.jpg');
            
            if( file_exists($PC_image_path)){
                $Mobile_image =  'Mobile-default_image.jpg' ;
                $Tablet_image =  'Tablet-default_image.jpg' ;
                                            
                Image::make($PC_image_path)->save(base_path().'/public/uploads/images/'.$Mobile_image );
                Image::make($PC_image_path)->save(base_path().'/public/uploads/images/'.$Tablet_image );
                            
                $video->mobile_image  = $Mobile_image;
                $video->tablet_image  = $Tablet_image;
            }
            else{
                $video->mobile_image  = 'default_image.jpg';
                $video->tablet_image  = 'default_image.jpg';
            }
            $video->user_id = Auth::user()->id;
            $video->save();
            
            $video_id = $video->id;

            $value['success'] = 1;
            $value['message'] = 'Uploaded Successfully!';
            $value['video_id'] = $video_id;

            return $value;  
       }
   

    }
    public function m3u8url(Request $request)
    {
        $data = $request->all();
        $value = array();
        
        if(!empty($data['m3u8_url'])) {
             
            $video = new Video();
            $video->disk = 'public';
            $video->original_name = 'public';
            $video->title = $data['m3u8_url'];
            $video->m3u8_url = $data['m3u8_url'];
            $video->type = 'm3u8_url';
            $video->draft = 0;
            $video->active = 1 ;
            $video->image = 'default_image.jpg';
            
            $PC_image_path = public_path('/uploads/images/default_image.jpg');
            
            if( file_exists($PC_image_path)){
                $Mobile_image =  'Mobile-default_image.jpg' ;
                $Tablet_image =  'Tablet-default_image.jpg' ;
                                            
                Image::make($PC_image_path)->save(base_path().'/public/uploads/images/'.$Mobile_image );
                Image::make($PC_image_path)->save(base_path().'/public/uploads/images/'.$Tablet_image );
                            
                $video->mobile_image  = $Mobile_image;
                $video->tablet_image  = $Tablet_image;
            }
            else{
                $video->mobile_image  = 'default_image.jpg';
                $video->tablet_image  = 'default_image.jpg';
            }

            $video->user_id = Auth::user()->id;
            $video->save();
            
            $video_id = $video->id;

            $value['success'] = 1;
            $value['message'] = 'Uploaded Successfully!';
            $value['video_id'] = $video_id;

            return $value;  
       }
   

    }
    public function Embededcode(Request $request)
    {
        $data = $request->all();
        $value = array();

        // echo "<pre>";
        // print_r($data);
        // exit();
        
        if(!empty($data['embed'])) {
             
            $video = new Video();
            $video->disk = 'public';
            $video->original_name = 'public';
            $video->title = $data['embed'];
            $video->embed_code = $data['embed'];
            $video->type = 'embed';
            $video->draft = 0;
            $video->active = 1 ;
            $video->image = 'default_image.jpg';
            
            $PC_image_path = public_path('/uploads/images/default_image.jpg');
            
            if( file_exists($PC_image_path)){
                $Mobile_image =  'Mobile-default_image.jpg' ;
                $Tablet_image =  'Tablet-default_image.jpg' ;
                                            
                Image::make($PC_image_path)->save(base_path().'/public/uploads/images/'.$Mobile_image );
                Image::make($PC_image_path)->save(base_path().'/public/uploads/images/'.$Tablet_image );
                            
                $video->mobile_image  = $Mobile_image;
                $video->tablet_image  = $Tablet_image;
            }
            else{
                $video->mobile_image  = 'default_image.jpg';
                $video->tablet_image  = 'default_image.jpg';
            }
            $video->user_id = Auth::user()->id;
            $video->save();
            
            $video_id = $video->id;

            $value['success'] = 1;
            $value['message'] = 'Uploaded Successfully!';
            $value['video_id'] = $video_id;
            return $value;  
       }
   

    }

    public function CPPVideosIndex()
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
        }else{

        $videos = Video::where('active', '=',1)->orderBy('created_at', 'DESC')->paginate(9);

        $videocategories = VideoCategory::select('id','image')->get()->toArray();
        $myData = array();
        foreach ($videocategories as $key => $videocategory) {
          $videocategoryid = $videocategory['id'];
        $videos = Video::where('active', '=',0)
            ->join('moderators_users', 'videos.user_id', '=', 'moderators_users.id')
            ->join('categoryvideos', 'categoryvideos.video_id', '=', 'videos.id')
            ->join('video_categories', 'video_categories.id', '=', 'categoryvideos.category_id')
            ->select('moderators_users.username', 'videos.*','video_categories.name')
            ->groupby('videos.id')
            ->orderBy('videos.created_at', 'DESC')->paginate(9);
        }
            $data = array(
                'videos' => $videos,
                );
    // dd($videos);
            return View('admin.videos.videoapproval.approval_index', $data);
        }
       }
       public function CPPVideosApproval($id)
       {
   
        //    echo "<pre>";
        //    print_r($id);
        //    exit();

           $video = Video::findOrFail($id);
           $video->active = 1;
           $video->save();
           

           return Redirect::back()->with('message','Your video will be available shortly after we process it');


          }

          public function CPPVideosReject($id)
          {
      
            $video = Video::findOrFail($id);
            $video->active = 2;
            $video->save();            
 
            return Redirect::back()->with('message','Your video will be available shortly after we process it');
 
   
             }
             function get_processed_percentage($id)
             {
                 return Video::where('id', '=', $id)->first();
             } 
             public function purchaseVideocount(Request $request)
             {
                $data = $request->all();
                $user_id = Auth::user()->id;
                $video_id = $data['video_id'];
                // view_count
                $purchase =  PpvPurchase::where('video_id',$video_id)->where('user_id',$user_id)->first();
                if($purchase->view_count == null || $purchase->view_count < 0){
                    // print_r('1');exit;
                    $purchase->view_count = 1;
                     $purchase->save();
                    return 1;
                }elseif($purchase->view_count > 0){
                    // print_r('2');exit;
                    return 2;
                }else{
                    return 3;
                }
             }


    public function editvideo($id)
        {

            if (!Auth::user()->role == 'admin')
            {
                return redirect('/home');
            }
            $settings = Setting::first();
            
        $video = Video::find($id);

        $ads_details = AdsVideo::join('advertisements','advertisements.id','ads_videos.ads_id') 
                ->where('ads_videos.video_id', $id)->pluck('ads_id')->first(); 

            $ads_rolls = AdsVideo::join('advertisements','advertisements.id','ads_videos.ads_id') 
                ->where('ads_videos.video_id', $id)->pluck('ad_roll')->first(); 

            $ads_category = Adscategory::get();

            $Reels_videos = Video::Join('reelsvideo','reelsvideo.video_id','=','videos.id')->where('videos.id',$id)->get();

            $data = array(
                'headline' => '<i class="fa fa-edit"></i> Edit Video',
                'video' => $video,
                'post_route' => URL::to('admin/videos/update'),
                'button_text' => 'Update Video',
                'admin_user' => Auth::user(),
                'video_categories' => VideoCategory::all(),
                'ads' => Advertisement::where('status','=',1)->get(),
                'video_subtitle' => VideosSubtitle::all(),
                'subtitles' => Subtitle::all(),
                'languages' => Language::all(),
                'artists' => Artist::all(),
                'settings' => $settings,
                'age_categories' => AgeCategory::all(),
                'countries' => CountryCode::all(),
                'video_artist' => Videoartist::where('video_id', $id)->pluck('artist_id')->toArray(),
                'category_id' => CategoryVideo::where('video_id', $id)->pluck('category_id')->toArray(),
                'languages_id' => LanguageVideo::where('video_id', $id)->pluck('language_id')->toArray(),
                'page' => 'Edit',
                'Reels_videos' => $Reels_videos,
                'ads_paths' => $ads_details ? $ads_details : 0 ,
                'ads_rolls' => $ads_rolls ? $ads_rolls : 0 ,
                'ads_category' => $ads_category,
                );


            return View::make('admin.videos.edit_video', $data); 
        }


        public function uploadEditVideo(Request $request)
        {
    
            $value = array();
            $data = $request->all();
            $id = $data['videoid'];
            $video = Video::findOrFail($id);

            // echo "<pre>";
            // print_r($video);exit();
            $validator = Validator::make($request->all(), [
               'file' => 'required|mimes:video/mp4,video/x-m4v,video/*',
               
            ]);
            $mp4_url = (isset($data['file'])) ? $data['file'] : '';
            
            $path = public_path().'/uploads/videos/';
            
            
            $file = $request->file->getClientOriginalName();
            $newfile = explode(".mp4",$file);
            $file_folder_name = $newfile[0];
       
            $package = User::where('id',1)->first();
            $pack = $package->package;
            $mp4_url = $data['file'];
            $settings = Setting::first();
    
            if($mp4_url != '' && $pack != "Business" ) {
                // $ffprobe = \FFMpeg\FFProbe::create();
                // $disk = 'public';
                // $data['duration'] = $ffprobe->streams($request->file)
                // ->videos()
                // ->first()                  
                // ->get('duration'); 
                
                $rand = Str::random(16);
                $path = $rand . '.' . $request->file->getClientOriginalExtension();
            
                $request->file->storeAs('public', $path);
                $thumb_path = 'public';
                
                
                // $this->build_video_thumbnail($request->file,$path, $data['slug']);
                
                $original_name = ($request->file->getClientOriginalName()) ? $request->file->getClientOriginalName() : '';
                //  $storepath  = URL::to('/storage/app/public/'.$file_folder_name.'/'.$original_name);
                //  $str = explode(".mp4",$path);
                //  $path =$str[0];
                $storepath  = URL::to('/storage/app/public/'.$path);
    
    
                //  Video duration 
                $getID3 = new getID3;
                $Video_storepath  = storage_path('app/public/'.$path);       
                $VideoInfo = $getID3->analyze($Video_storepath);
                $Video_duration = $VideoInfo['playtime_seconds'];
    
                // $video = new Video();
                $video->disk = 'public';
                $video->title = $file_folder_name;
                $video->original_name = 'public';
                $video->path = $path;
                $video->mp4_url = $storepath;
                $video->type = 'mp4_url';
                // $video->draft = 0;
                // $video->image = 'default_image.jpg';
    
                
    
                $video->duration  = $Video_duration;
                $video->save(); 
                
            
                $video_id = $video->id;
                $video_title = Video::find($video_id);
                $title =$video_title->title; 
    
                $value['success'] = 1;
                $value['message'] = 'Uploaded Successfully!';
                $value['video_id'] = $video_id;
                $value['video_title'] = $title;
    
                return $value;
            
            }elseif($mp4_url != '' && $pack == "Business" && $settings->transcoding_access  == 1) {
    
            // echo "<pre>";
            // print_r($mp4_url);exit();
                $rand = Str::random(16);
                $path = $rand . '.' . $request->file->getClientOriginalExtension();
                $request->file->storeAs('public', $path);
                 
                 $original_name = ($request->file->getClientOriginalName()) ? $request->file->getClientOriginalName() : '';
                 
                $storepath  = URL::to('/storage/app/public/'.$path);
    
    
                //  Video duration 
                $getID3 = new getID3;
                $Video_storepath  = storage_path('app/public/'.$path);       
                $VideoInfo = $getID3->analyze($Video_storepath);
                $Video_duration = $VideoInfo['playtime_seconds'];
                 
                //  $video = new Video();
                 $video->disk = 'public';
                 $video->status = 0;
                 $video->original_name = 'public';
                 $video->path = $path;
                 $video->title = $file_folder_name;
                 $video->mp4_url = $storepath;
                //  $video->draft = 0;
                $video->type = '';
                //  $video->image = 'default_image.jpg';
                 $video->duration  = $Video_duration;
                 $video->user_id = Auth::user()->id;
                 $video->save();
    
                 ConvertVideoForStreaming::dispatch($video);
                 $video_id = $video->id;
                 $video_title = Video::find($video_id);
                 $title =$video_title->title; 
          
                  $value['success'] = 1;
                  $value['message'] = 'Uploaded Successfully!';
                  $value['video_id'] = $video_id;
                  $value['video_title'] = $title;
                  
                  return $value;
            }elseif($mp4_url != '' && $pack == "Business"  && $settings->transcoding_access  == 0 ) {
    
                $rand = Str::random(16);
                $path = $rand . '.' . $request->file->getClientOriginalExtension();
            
                $request->file->storeAs('public', $path);
                $thumb_path = 'public';
                            
                $original_name = ($request->file->getClientOriginalName()) ? $request->file->getClientOriginalName() : '';
    
                $storepath  = URL::to('/storage/app/public/'.$path);
    
    
                //  Video duration 
                $getID3 = new getID3;
                $Video_storepath  = storage_path('app/public/'.$path);       
                $VideoInfo = $getID3->analyze($Video_storepath);
                $Video_duration = $VideoInfo['playtime_seconds'];
    
                // $video = new Video();
                $video->disk = 'public';
                $video->title = $file_folder_name;
                $video->original_name = 'public';
                $video->path = $path;
                $video->mp4_url = $storepath;
                $video->type = 'mp4_url';
                // $video->draft = 0;
                $video->image = 'default_image.jpg'; 
                $video->duration  = $Video_duration;
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
                return response()->json($value);
            }
    
            // return response()->json($value);
        }
            
    public function VideoBulk_delete(Request $request)
    {
        try {
            $video_id = $request->video_id;
            Video::whereIn('id',explode(",",$video_id))->delete();

            return response()->json(['message'=>"true"]);
          

        } catch (\Throwable $th) {
            return response()->json(['message'=>"false"]);
        }
      
    }



    public function Updatemp4url(Request $request)
    {
        $value = array();
        $data = $request->all();

        $id = $data['videoid'];
        $video = Video::findOrFail($id);
        // echo"<pre>";print_r($data);exit;
        if(!empty($data['mp4_url'])) {
             
            $video->disk = 'public';
            $video->original_name = 'public';
            // $video->title = $data['mp4_url'];
            $video->mp4_url = $data['mp4_url'];
            $video->type = 'mp4_url';
            // $video->draft = 0;
            $video->active = 1 ;
            $video->image = 'default_image.jpg';
            
            $video->user_id = Auth::user()->id;
            $video->save();
            
            $video_id = $video->id;

            $value['success'] = 1;
            $value['message'] = 'Uploaded Successfully!';
            $value['video_id'] = $video_id;

            return $value;  
       }
   

    }
    public function Updatem3u8url(Request $request)
    {
        $data = $request->all();
        $value = array();

        $id = $data['videoid'];
        $video = Video::findOrFail($id);
        if(!empty($data['m3u8_url'])) {
             
            // $video = new Video();
            $video->disk = 'public';
            $video->original_name = 'public';
            // $video->title = $data['m3u8_url'];
            $video->m3u8_url = $data['m3u8_url'];
            $video->type = 'm3u8_url';
            // $video->draft = 0;
            $video->active = 1 ;
            $video->image = 'default_image.jpg';
            
            $video->user_id = Auth::user()->id;
            $video->save();
            
            $video_id = $video->id;

            $value['success'] = 1;
            $value['message'] = 'Uploaded Successfully!';
            $value['video_id'] = $video_id;

            return $value;  
       }
   

    }
    public function UpdateEmbededcode(Request $request)
    {
        $data = $request->all();
        $value = array();

        // echo "<pre>";
        // print_r($data);
        // exit();
        $id = $data['videoid'];
        $video = Video::findOrFail($id);
        
        if(!empty($data['embed'])) {
             
            // $video = new Video();
            $video->disk = 'public';
            $video->original_name = 'public';
            // $video->title = $data['embed'];
            $video->embed_code = $data['embed'];
            $video->type = 'embed';
            $video->draft = 0;
            $video->active = 1 ;
            $video->image = 'default_image.jpg';
            
            $video->user_id = Auth::user()->id;
            $video->save();
            
            $video_id = $video->id;

            $value['success'] = 1;
            $value['message'] = 'Uploaded Successfully!';
            $value['video_id'] = $video_id;
            return $value;  
       }
   

    }

    public function video_slider_update(Request $request)
    {
        try {
            $video = Video::where('id',$request->video_id)->update([
                'banner' => $request->banner_status,
            ]);

            return response()->json(['message'=>"true"]);

        } catch (\Throwable $th) {
            return response()->json(['message'=>"false"]);
        }
    }

    public function video_slug_validate(Request $request)
    {
       $video_slug_validate = Video::where('slug',$request->slug)->count();

       $validate_status =  $video_slug_validate > 0 ? "true" : "false" ;

       return response()->json(['message'=>$validate_status]);
    }

}

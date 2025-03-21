<?php

namespace App\Http\Controllers;
use App\User as User;
use \Redirect as Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
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
use App\Jobs\Convert4kVideoForStreaming;
use App\Jobs\TranscodeVideo;
use App\Jobs\VideoSchedule;
use App\Jobs\VideoClip;
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
use Streaming\Representation;
use App\Jobs\ConvertVideoTrailer;
use App\InappPurchase;
use App\CurrencySetting as CurrencySetting;
use App\VideoSchedules as VideoSchedules;
use App\ScheduleVideos as ScheduleVideos;
use App\TestServerUploadVideo as TestServerUploadVideo;
use App\Channel as Channel;
use App\ReSchedule as ReSchedule;
use App\TimeZone as TimeZone;
use App\StorageSetting as StorageSetting;
use App\TimeFormat as TimeFormat;
use Aws\Common\Exception\MultipartUploadException;
use Aws\S3\MultipartUploader;
use Aws\S3\S3Client;
use Aws\S3\S3MultiRegionClient;
use App\EmailTemplate;
use Mail;
use App\PlayerAnalytic;
use Carbon\Carbon;
use ProtoneMedia\LaravelFFMpeg\Filters\WatermarkFactory;
use ParseM3U8;
use App\Playerui;
use App\PlayerSeekTimeAnalytic;
use App\AdminVideoPlaylist as AdminVideoPlaylist;
use App\VideoPlaylist as VideoPlaylist;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\VideoExtractedImages;
use FFMpeg\Filters\Video\VideoResizeFilter;
use FFMpeg\Filters\Video\Resizer;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\SiteTheme;
use App\AdminVideoAds;
use App\AdminEPGChannel;
use App\Episode;
use App\LiveStream;
use App\SiteVideoScheduler;
use App\DefaultSchedulerData;
use App\CompressImage;
use App\EPGSchedulerData;
use App\Jobs\VideoCompression;
use App\Jobs\ConvertEpisodeVideo;
use App\Jobs\ConvertSerieTrailer;
use App\UploadErrorLog;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\DeleteLog;

class AdminVideosController extends Controller
{

    private $apiKey;
    private $client ;


    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = videocipher_Key(); 

        $this->Enable_Flussonic_Upload = Enable_Flussonic_Upload();
        $this->Enable_Flussonic_Upload_Details = Enable_Flussonic_Upload_Details();
        $this->Flussonic_Auth_Key  = @$this->Enable_Flussonic_Upload_Details->flussonic_storage_Auth_Key;
        $this->Flussonic_Server_Base_URL  = @$this->Enable_Flussonic_Upload_Details->flussonic_storage_site_base_url;
        $this->Flussonic_Storage_Tag  = @$this->Enable_Flussonic_Upload_Details->flussonic_storage_tag;

    }

    public function index()
    {

        if (!Auth::user()->role == "admin") {
            return redirect("/home");
        }
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
            // $search_value = Request::get('s');
            if (!empty($search_value)):
                $videos = Video::where(
                    "title",
                    "LIKE",
                    "%" . $search_value . "%"
                )
                    ->orderBy("created_at", "desc")
                    ->paginate(9);
                // $videos = Video::orderBy('created_at', 'DESC')->paginate(9);
            else:
                $videos = Video::with("category.categoryname")
                    ->orderBy("created_at", "DESC")
                    ->paginate(9);

                    $videossss = Video::with("category.categoryname")
                    ->orderBy("created_at", "DESC")
                    ->get();
            endif;
            // $videossss = Video::with('category.categoryname')->orderBy('created_at', 'DESC')->paginate(9);
            // echo "<pre>";
            // foreach($videossss as $key => $value){
            //     print_r(@$value->category[$key]->categoryname->name);

            // }
            // exit();
            // $video = Video::with('category.categoryname')->where('id',156)->get();
            // $GoogleTranslate_array_values = GoogleTranslate_array_values($videos);

            // $videoCollection = new Collection();

            //     foreach ($GoogleTranslate_array_values as $item) {
            //         $video = new Video($item);
            //         $videoCollection->push($video);
            //     }

        
            $user = Auth::user();
            $data = [
                "videos" => $videos,
                "user" => $user,
                "admin_user" => Auth::user(),
            ];

            return View("admin.videos.index", $data);
        }
    }

    public function live_search(Request $request)
    {
        if ($request->ajax()) {
            $output = "";
            $query = $request->get("query");

            $slug = URL::to("/category/videos");
            $edit = URL::to("admin/videos/edit");
            $editvideo = URL::to("admin/videos/editvideo");
            $delete = URL::to("admin/videos/delete");
            if ($query != "") {
                $data = Video::where("title", "LIKE", "%" . $query . "%")
                    ->orderBy("created_at", "desc")
                    ->paginate(9);

                //  $data = Video::select('videos.*','moderators_users.id','video_languages.name as languages_name','video_categories.name as categories_name')
                //  ->leftJoin('moderators_users', 'moderators_users.id', '=', 'videos.user_id')
                //  ->leftJoin('video_languages', 'video_languages.id', '=', 'videos.language')
                //  ->leftJoin('video_categories', 'video_categories.id', '=', 'videos.video_category_id')
                //  ->where('videos.title', 'like', '%'.$query.'%')
                //  ->paginate(9);
            } else {
                // $data = Video::orderBy("created_at", "desc")
                // ->paginate(9);
                $data = [];
            }
            if (count($data) > 0) {
                $total_row = $data->count();
                if ($total_row > 0) {
                    foreach ($data as $row) {

                        if(isset($row->type) && $row->type == "") { $type = 'M3u8 Converted Video' ; }
                        elseif(isset($row->type) && $row->type == "mp4_url"){ $type = 'MP4 Video' ; }
                        elseif(isset($row->type) && $row->type == "m3u8_url"){ $type = 'M3u8 URL Video' ; }
                        elseif(isset($row->type) && $row->type == "embed"){ $type = 'Embed Video'; }
                        else{ $type = ''; }

                        if ($row->draft == null ) {
                            $active = "Draft";
                            $class = "bg-warning video_active";
                        } elseif ( $row->draft == 1 && $row->status == 1 && $row->active == 1 ) {
                            $active = "Published";
                            $class = "bg-success video_active";
                        } else {
                            $active = "Draft";
                            $class = "bg-warning video_active";
                        }
                        if($row->draft != null && $row->draft == 1 && $row->status != null && $row->status == 1 && $row->active != null && $row->active == 1){ 
                            $style = "";
                        } else{
                                $style = "opacity: 0.6; cursor: not-allowed;";
                        }
                        $username = @$row->cppuser->username
                            ? "Upload By" . " " . @$row->cppuser->username
                            : "Upload By Admin";
                        $output .=
                            '
        <tr>
        <td>' . '<input type="checkbox" id="Sub_chck" class="sub_chk" data-id='.$row->id .'>'
                 .
                '</td>
        <td>' .
                            $row->title .
                            '</td>
        <td>' .
                            $row->rating .
                            '</td>
        <td>' .
                            $username .
                            '</td>
        <td>' .
                            $type .
                            '</td>
        <td>' .
                            $row->access .
                            '</td>
        <td class="' .
                            $class .
                            '" style="font-weight:bold;">' .
                            $active .
                            '</td>
         <td>' .
                            $row->views .
                            '</td>

         <td>' .
                '<label class="switch">'.
                '<input name="video_status" class="video_status" id='.$row->id .' type="checkbox" if( '.$row->banner .' == "1") checked  @endif data-video-id='.$row->id .'  data-type="video" onchange="update_video_banner(this)" >'.
                '<span class="slider round"></span>'.
                '</label>'.
                    '</td>
         <td> ' .
                            "<a class='iq-bg-warning' data-toggle='tooltip' style = .$style . data-placement='top' title='' data-original-title='View' href=' $slug/$row->slug'><i class='lar la-eye'></i>
        </a>" .
                            '
        ' .
                            "<a class='iq-bg-success' data-toggle='tooltip' data-placement='top' title='' data-original-title='Edit' href=' $edit/$row->id'><i class='ri-pencil-line'></i>
        </a>" .
                            '
                            ' .
                            "<a class='iq-bg-success' data-toggle='tooltip' data-placement='top' title='' data-original-title='Edit' href=' $editvideo/$row->id'><i class='ri-pencil-line'></i>
        </a>" .
                            '
        ' .
                            "<a class='iq-bg-danger' data-toggle='tooltip' data-placement='top' title='' data-original-title='Delete'  href=' $delete/$row->id'><i class='ri-delete-bin-line'></i>
        </a>" .
                            '
        </td>
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
                $data = [
                    "table_data" => $output,
                    "total_data" => $total_row,
                ];
                echo json_encode($data);
            }
        }
    }

    public function CPPVideos(Request $request)
    {
        if ($request->ajax()) {
            $output = "";
            $query = $request->get("query");

            $slug = URL::to("/category/videos");
            $edit = URL::to("admin/videos/edit");
            $delete = URL::to("admin/videos/delete");
            if ($query != "") {
                $data = Video::select(
                    "videos.*",
                    "moderators_users.username",
                    "video_languages.name as languages_name",
                    "video_categories.name as categories_name"
                )
                    ->leftJoin(
                        "video_languages",
                        "video_languages.id",
                        "=",
                        "videos.language"
                    )
                    ->leftJoin(
                        "video_categories",
                        "video_categories.id",
                        "=",
                        "videos.video_category_id"
                    )
                    ->Join(
                        "moderators_users",
                        "moderators_users.id",
                        "=",
                        "videos.user_id"
                    )
                    ->paginate(9);
            } else {
                $data = [];
            }
            if (count($data) > 0) {
                $total_row = $data->count();
                if ($total_row > 0) {
                    foreach ($data as $row) {

                        if(isset($row->type) && $row->type == "") { $type = 'M3u8 Converted Video' ; }
                        elseif(isset($row->type) && $row->type == "mp4_url"){ $type = 'MP4 Video' ; }
                        elseif(isset($row->type) && $row->type == "m3u8_url"){ $type = 'M3u8 URL Video' ; }
                        elseif(isset($row->type) && $row->type == "embed"){ $type = 'Embed Video'; }


                        if ($row->active == 0) {
                            $active = "Pending";
                            $class = "bg-warning";
                        } elseif ($row->active == 1) {
                            $active = "Approved";
                            $class = "bg-success";
                        } else {
                            $active = "Rejected";
                            $class = "bg-danger";
                        }
                        $output .=
                            '
        <tr>
        <td>' . '<input type="checkbox" id="Sub_chck" class="sub_chk" data-id='.$row->id .'>'
        .
       '</td>
        <td>' .
                            $row->title .
                            '</td>
        <td>' .
                            $row->rating .
                            '</td>

        <td>' .
                            $row->username .
                            '</td>
            <td>' .
                $type .
                    '</td>
            <td>' .
                    $row->access .
                    '</td>
         <td class="' .
                            $class .
                            '" style="font-weight:bold;">' .
                            $active .
                            '</td>

         <td>' .
                            $row->views .
                            '</td>
        <td>' .
            '<label class="switch">'.
                '<input name="video_status" class="video_status" id='.$row->id .' type="checkbox" if( '.$row->banner .' == "1") checked  @endif data-video-id='.$row->id .'  data-type="video" onchange="update_video_banner(this)" >'.
                '<span class="slider round"></span>'.
            '</label>'.
                    '</td>
         <td> ' .
                            "<a class='iq-bg-warning' data-toggle='tooltip' data-placement='top' title='' data-original-title='View' href=' $slug/$row->slug'><i class='lar la-eye'></i>
        </a>" .
                            '
        ' .
                            "<a class='iq-bg-success' data-toggle='tooltip' data-placement='top' title='' data-original-title='Edit' href=' $edit/$row->id'><i class='ri-pencil-line'></i>
        </a>" .
                            '
        ' .
                            "<a class='iq-bg-danger' data-toggle='tooltip' data-placement='top' title='' data-original-title='Delete'  href=' $delete/$row->id'><i class='ri-delete-bin-line'></i>
        </a>" .
                            '
        </td>
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
                $data = [
                    "table_data" => $output,
                    "total_data" => $total_row,
                ];

                echo json_encode($data);
            }
        }
    }
    // Image extraction function
        private function extractImageFromVideo($videoPath, $outputPath, $timeInSeconds = 5)
        {
            // Open the video file
            $video = \FFMpeg\FFMpeg::fromDisk('local')->open($videoPath);

            // Set the time to capture the frame (in seconds)
            // $video->frame(\FFMpeg\Coordinate\TimeCode::fromSeconds($timeInSeconds))
            $video->filters()->clip(TimeCode::fromSeconds($timeInSeconds))
            // $video->frame(TimeCode::fromSeconds($timeInSeconds))
            ->export()
            ->toDisk('local')
            ->inFormat(new X264)
            ->save($outputPath);
        }
    public function uploadFile(Request $request)
    {
        // $enable_bunny_cdn = SiteTheme::pluck('enable_bunny_cdn')->first();

        $site_theme = SiteTheme::first();
        
        $today = Carbon::now() ;

        // // Video Upload Limit (3 Limits)

        // $videos_uplaod_limit = Video::where('user_id', Auth::user()->id )
        //                             ->whereYear('created_at',  $today->year)
        //                             ->whereMonth('created_at', $today->month)
        //                             ->count();
    
        // if ( $site_theme->admin_videoupload_limit_status == 1 && $videos_uplaod_limit >= $site_theme->admin_videoupload_limit_count) {
        //     return response()->json( ["success" => 'video_upload_limit_exist'],200);
        // }
        
        $value = [];
        $data = $request->all();

        $validator = Validator::make($request->all(), [
            "file" => "required|mimes:video/mp4,video/x-m4v,video/*",
        ]);
           

        $mp4_url = isset($data["file"]) ? $data["file"] : "";

        $path = public_path() . "/uploads/videos/";

        $file = $request->file->getClientOriginalName();
        $newfile = explode(".mp4", $file);
        $file_folder_name = $newfile[0];

        $package = User::where("id", 1)->first();
        $pack = $package->package;
        $mp4_url = $data["file"];
        $settings = Setting::first();
        $libraryid = $data['UploadlibraryID'];
        $FlussonicUploadlibraryID = $data['FlussonicUploadlibraryID'];
        $client = new Client();
        
        // print_r(!is_null($FlussonicUploadlibraryID));exit;

        $storage_settings = StorageSetting::first();   

        if($site_theme->enable_bunny_cdn == 1){
            if(!empty($storage_settings) && $storage_settings->bunny_cdn_storage == 1 && !empty($libraryid) && !empty($mp4_url)){
                return $this->UploadVideoBunnyCDNStream( $storage_settings,$libraryid,$mp4_url);
            }elseif(!empty($storage_settings) && $storage_settings->bunny_cdn_storage == 1 && empty($libraryid)){
                $value["error"] = 3;
                return $value ;
            }
        }elseif($storage_settings->flussonic_storage == 1){
            if(!empty($storage_settings) && $storage_settings->flussonic_storage == 1 && !is_null($FlussonicUploadlibraryID) && !empty($mp4_url)){
                return $this->UploadVideoFlussonicStorage( $storage_settings,$FlussonicUploadlibraryID,$mp4_url);
            }elseif(!empty($storage_settings) && $storage_settings->flussonic_storage == 1 && empty($FlussonicUploadlibraryID)){
                $value["error"] = 3;
                return $value ;
            }
        }               


        if ($mp4_url != "" && $pack != "Business") {
            // $ffprobe = \FFMpeg\FFProbe::create();
            // $disk = 'public';
            // $data['duration'] = $ffprobe->streams($request->file)
            // ->videos()
            // ->first()
            // ->get('duration');

            $rand = Str::random(16);
            $path = $rand . "." . $request->file->getClientOriginalExtension();

            $request->file->storeAs("public", $path);
            $thumb_path = "public";

            // $this->build_video_thumbnail($request->file,$path, $data['slug']);

            $original_name = $request->file->getClientOriginalName()
                ? $request->file->getClientOriginalName()
                : "";
            //  $storepath  = URL::to('/storage/app/public/'.$file_folder_name.'/'.$original_name);
            //  $str = explode(".mp4",$path);
            //  $path =$str[0];
            $storepath = URL::to("/storage/app/public/" . $path);

            //  Video duration
            $getID3 = new getID3();
            $Video_storepath = storage_path("app/public/" . $path);
            $VideoInfo = $getID3->analyze($Video_storepath);
            $Video_duration = $VideoInfo["playtime_seconds"];

            $video = new Video();
            $video->disk = "public";
            $video->title = $file_folder_name;
            $video->original_name = "public";
            $video->path = $path;
            $video->mp4_url = $storepath;
            $video->type = "mp4_url";
            $video->draft = 0;
            $video->user_id = Auth::user()->id;
            $video->image = default_vertical_image();
            $video->video_tv_image = default_horizontal_image();
            $video->player_image = default_horizontal_image();
            $video->duration = $Video_duration;
            $video->save();

            $video_id = $video->id;
            $video_title = Video::find($video_id);
            $title = $video_title->title;

            $value["success"] = 1;
            $value["message"] = "Uploaded Successfully!";
            $value["video_id"] = $video_id;
            $value["video_title"] = $title;

            \LogActivity::addVideoLog("Added Uploaded MP4  Video.", $video_id);

            return $value;
        } elseif (
            $mp4_url != "" &&
            $pack == "Business" &&
            $settings->transcoding_access == 1
        ) {
            try {
                $rand = Str::random(16);
                $path =
                    $rand . "." . $request->file->getClientOriginalExtension();
                $request->file->storeAs("public", $path);

                $original_name = $request->file->getClientOriginalName()
                    ? $request->file->getClientOriginalName()
                    : "";

                $storepath = URL::to("/storage/app/public/" . $path);

                //  Video duration
                $getID3 = new getID3();
                $Video_storepath = storage_path("app/public/" . $path);
                $VideoInfo = $getID3->analyze($Video_storepath);
                $Video_duration = $VideoInfo["playtime_seconds"];

                // $outputFolder = storage_path('app/public/frames');

                // if (!is_dir($outputFolder)) {
                //     mkdir($outputFolder, 0755, true);
                // }
                                    
                $video = new Video();
                $video->disk = "public";
                $video->status = 0;
                $video->original_name = "public";
                $video->path = $path;
                $video->old_path_mp4 = $path;   
                $video->title = $file_folder_name;
                $video->mp4_url = $storepath;
                $video->draft = 0;
                $video->image = default_vertical_image();
                $video->video_tv_image = default_horizontal_image();
                $video->player_image = default_horizontal_image();
                $video->user_id = Auth::user()->id;
                $video->duration = $Video_duration;
                $video->user_id = Auth::user()->id;
                $video->save();
                
            if(Enable_Extract_Image() == 1){
                // extractImageFromVideo
            
                $ffmpeg = \FFMpeg\FFMpeg::create();
                $videoFrame = $ffmpeg->open($Video_storepath);
                
                // Define the dimensions for the frame (16:9 aspect ratio)
                $frameWidth = 1280;
                $frameHeight = 720;
                
                // Define the dimensions for the frame (9:16 aspect ratio)
                $frameWidthPortrait = 1080;  // Set the desired width of the frame
                $frameHeightPortrait = 1920; // Calculate height to maintain 9:16 aspect ratio
                
                $randportrait = 'portrait_' . $rand;
                
                $interval = 5; // Interval for extracting frames in seconds
                $totalDuration = round($videoFrame->getStreams()->videos()->first()->get('duration'));
                $totalDuration = intval($totalDuration);


                if ( 600 < $totalDuration) { 
                    $timecodes = [5, 120, 240, 360, 480]; 
                } else { 
                    $timecodes = [5, 10, 15, 20, 25]; 
                }

                
                foreach ($timecodes as $index => $time) {
                    $imagePortraitPath = public_path("uploads/images/{$video->id}_{$randportrait}_{$index}.jpg");
                    $imagePath = public_path("uploads/images/{$video->id}_{$rand}_{$index}.jpg");
            
                    try {
                        $videoFrame
                            ->frame(TimeCode::fromSeconds($time))
                            ->save($imagePath, new X264('libmp3lame', 'libx264'), null, new Dimension($frameWidth, $frameHeight));
            
                        $videoFrame
                            ->frame(TimeCode::fromSeconds($time))
                            ->save($imagePortraitPath, new X264('libmp3lame', 'libx264'), null, new Dimension($frameWidthPortrait, $frameHeightPortrait));
            
                        $VideoExtractedImage = new VideoExtractedImages();
                        $VideoExtractedImage->user_id = Auth::user()->id;
                        $VideoExtractedImage->socure_type = 'Video';
                        $VideoExtractedImage->video_id = $video->id;
                        $VideoExtractedImage->image_path = URL::to("/public/uploads/images/" . $video->id . '_' . $rand . '_' . $index . '.jpg');
                        $VideoExtractedImage->portrait_image = URL::to("/public/uploads/images/" . $video->id . '_' . $randportrait . '_' . $index . '.jpg');
                        $VideoExtractedImage->image_original_name = $video->id . '_' . $rand . '_' . $index . '.jpg';
                        $VideoExtractedImage->save();
                    } catch (\Exception $e) {
                        dd($e->getMessage());
                    }
                }
            
            }
                
                $Playerui = Playerui::first();
                if(@$Playerui->video_watermark_enable == 1 && !empty($Playerui->video_watermark)){

                    $video = Video::find($video->id);
                    $video->watermark_transcoding_progress = 1;
                    $video->save();
                    TranscodeVideo::dispatch($video);
                }
                // else if(@$settings->video_clip_enable == 1 && !empty($settings->video_clip)){
                //     VideoClip::dispatch($video);
                // }
                else{
                    if(Enable_4k_Conversion() == 1){
                        Convert4kVideoForStreaming::dispatch($video);
                    }elseif(Enable_Video_Compression() == 1){
                        VideoCompression::dispatch($video);
                    }else{
                        ConvertVideoForStreaming::dispatch($video);
                    }
                }           
                $video_id = $video->id;
                $video_title = Video::find($video_id);
                $title = $video_title->title;

                $value["success"] = 1;
                $value["message"] = "Uploaded Successfully!";
                $value["video_id"] = $video_id;
                $value["video_title"] = $title;

                \LogActivity::addVideoLog(
                    "Added Uploaded M3U8  Video.",
                    $video_id
                );

                return $value;
            } catch (\Exception $e) {
                return response()->json(
                    [
                        "status" => "false",
                        "Message" => "fails to upload ",
                    ],
                    200
                );
            }
        } elseif (
            $mp4_url != "" &&
            $pack == "Business" &&
            $settings->transcoding_access == 0
        ) {
            $rand = Str::random(16);
            $path = $rand . "." . $request->file->getClientOriginalExtension();

            $request->file->storeAs("public", $path);
            $thumb_path = "public";

            $original_name = $request->file->getClientOriginalName()
                ? $request->file->getClientOriginalName()
                : "";

            $storepath = URL::to("/storage/app/public/" . $path);
   
            //  Video duration
            $getID3 = new getID3();
            $Video_storepath = storage_path("app/public/" . $path);
            $VideoInfo = $getID3->analyze($Video_storepath);
            $Video_duration = $VideoInfo["playtime_seconds"];

            $video = new Video();
            $video->disk = "public";
            $video->title = $file_folder_name;
            $video->original_name = "public";
            $video->path = $path;
            $video->mp4_url = $storepath;
            $video->type = "mp4_url";
            $video->draft = 0;
            $video->image = default_vertical_image();
            $video->video_tv_image = default_horizontal_image();
            $video->player_image = default_horizontal_image();
            $video->user_id = Auth::user()->id;
            $video->duration = $Video_duration;
            $video->save();

            if(Enable_Video_Compression() == 1){
                VideoCompression::dispatch($video);
            }

            // if(Enable_Extract_Image() == 1){
            //     // extractImageFromVideo

            //     $ffmpeg = \FFMpeg\FFMpeg::create();
            //     $videoFrame = $ffmpeg->open($Video_storepath);
                
            //     // Define the dimensions for the frame (16:9 aspect ratio)
            //     $frameWidth = 1280;
            //     $frameHeight = 720;
                
            //     // Define the dimensions for the frame (9:16 aspect ratio)
            //     $frameWidthPortrait = 1080;  // Set the desired width of the frame
            //     $frameHeightPortrait = 1920; // Calculate height to maintain 9:16 aspect ratio
                
            //     $randportrait = 'portrait_' . $rand;
                
            //     for ($i = 1; $i <= 5; $i++) {
            //         // $imagePortraitPath = storage_path("app/public/frames/{$video->id}_{$randportrait}_{$i}.jpg");
            //         // $imagePath = storage_path("app/public/frames/{$video->id}_{$rand}_{$i}.jpg");
                
                    
            //         $imagePortraitPath = public_path("uploads/images/{$video->id}_{$randportrait}_{$i}.jpg");
            //         $imagePath = public_path("uploads/images/{$video->id}_{$rand}_{$i}.jpg");

                    
            //         try {
            //             $videoFrame
            //                 ->frame(TimeCode::fromSeconds($i * 5))
            //                 ->save($imagePath, new X264('libmp3lame', 'libx264'), null, new Dimension($frameWidth, $frameHeight));
                
            //             $videoFrame
            //                 ->frame(TimeCode::fromSeconds($i * 5))
            //                 ->save($imagePortraitPath, new X264('libmp3lame', 'libx264'), null, new Dimension($frameWidthPortrait, $frameHeightPortrait));
                
            //             $VideoExtractedImage = new VideoExtractedImages();
            //             $VideoExtractedImage->user_id = Auth::user()->id;
            //             $VideoExtractedImage->socure_type = 'Video';
            //             $VideoExtractedImage->video_id = $video->id;
            //             $VideoExtractedImage->image_path = URL::to("/public/uploads/images/" . $video->id . '_' . $rand . '_' . $i . '.jpg');
            //             $VideoExtractedImage->portrait_image = URL::to("/public/uploads/images/" . $video->id . '_' . $randportrait . '_' . $i . '.jpg');
            //             $VideoExtractedImage->image_original_name = $video->id . '_' . $rand . '_' . $i . '.jpg';
            //             $VideoExtractedImage->save();
             
                
            //             } catch (\Exception $e) {
            //                 dd($e->getMessage());
            //             }
            //         }
            //     }

            if(Enable_Extract_Image() == 1){
                // extractImageFromVideo
            
                $ffmpeg = \FFMpeg\FFMpeg::create();
                $videoFrame = $ffmpeg->open($Video_storepath);
                
                // Define the dimensions for the frame (16:9 aspect ratio)
                $frameWidth = 1280;
                $frameHeight = 720;
                
                // Define the dimensions for the frame (9:16 aspect ratio)
                $frameWidthPortrait = 1080;  // Set the desired width of the frame
                $frameHeightPortrait = 1920; // Calculate height to maintain 9:16 aspect ratio
                
                $randportrait = 'portrait_' . $rand;
                
                $interval = 5; // Interval for extracting frames in seconds
                $totalDuration = round($videoFrame->getStreams()->videos()->first()->get('duration'));
                $totalDuration = intval($totalDuration);


                if ( 600 < $totalDuration) { 
                    $timecodes = [5, 120, 240, 360, 480]; 
                } else { 
                    $timecodes = [5, 10, 15, 20, 25]; 
                }

                
                foreach ($timecodes as $index => $time) {
                    $imagePortraitPath = public_path("uploads/images/{$video->id}_{$randportrait}_{$index}.jpg");
                    $imagePath = public_path("uploads/images/{$video->id}_{$rand}_{$index}.jpg");
            
                    try {
                        $videoFrame
                            ->frame(TimeCode::fromSeconds($time))
                            ->save($imagePath, new X264('libmp3lame', 'libx264'), null, new Dimension($frameWidth, $frameHeight));
            
                        $videoFrame
                            ->frame(TimeCode::fromSeconds($time))
                            ->save($imagePortraitPath, new X264('libmp3lame', 'libx264'), null, new Dimension($frameWidthPortrait, $frameHeightPortrait));
            
                        $VideoExtractedImage = new VideoExtractedImages();
                        $VideoExtractedImage->user_id = Auth::user()->id;
                        $VideoExtractedImage->socure_type = 'Video';
                        $VideoExtractedImage->video_id = $video->id;
                        $VideoExtractedImage->image_path = URL::to("/public/uploads/images/" . $video->id . '_' . $rand . '_' . $index . '.jpg');
                        $VideoExtractedImage->portrait_image = URL::to("/public/uploads/images/" . $video->id . '_' . $randportrait . '_' . $index . '.jpg');
                        $VideoExtractedImage->image_original_name = $video->id . '_' . $rand . '_' . $index . '.jpg';
                        $VideoExtractedImage->save();
                    } catch (\Exception $e) {
                        dd($e->getMessage());
                    }
                }
            
            }
            

            $video_id = $video->id;
            $video_title = Video::find($video_id);
            $title = $video_title->title;

            $value["success"] = 1;
            $value["message"] = "Uploaded Successfully!";
            $value["video_id"] = $video_id;
            $value["video_title"] = $title;

            \LogActivity::addVideoLog("Added Uploaded MP4  Video.", $video_id);

            return $value;
        }
        else {
            $value["success"] = 2;
            $value["message"] = "File not uploaded.";
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
        if (!Auth::user()->role == "admin") {
            return redirect("/home");
        }
        if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
            return redirect('/admin/restrict');
        }
        $settings = Setting::first();
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

                $StorageSetting = StorageSetting::first();
                // dd($StorageSetting);
                if($StorageSetting->site_storage == 1){
                    $dropzone_url =  URL::to('admin/uploadFile');
                }elseif($StorageSetting->aws_storage == 1){
                    $dropzone_url =  URL::to('admin/AWSUploadFile');
                }else{ 
                    $dropzone_url =  URL::to('admin/uploadFile');
                }

                $video_js_Advertisements = Advertisement::where('status',1)->get() ;

                // Bunny Cdn get Videos 
                
                $storage_settings = StorageSetting::first();

                if(!empty($storage_settings) && $storage_settings->bunny_cdn_storage == 1 
                && !empty($storage_settings->bunny_cdn_hostname) && !empty($storage_settings->bunny_cdn_storage_zone_name) 
                && !empty($storage_settings->bunny_cdn_ftp_access_key)  ){

                    $url = "https://api.bunny.net/videolibrary?page=0&perPage=1000&includeAccessKey=false/";
                    
                    $ch = curl_init();
                    
                    $options = array(
                        CURLOPT_URL => $url,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_HTTPHEADER => array(
                            "AccessKey: {$storage_settings->bunny_cdn_access_key}",
                            'Content-Type: application/json',
                        ),
                    );
                    
                    curl_setopt_array($ch, $options);
                    
                    $response = curl_exec($ch);
                    
                    if (!$response) {
                        die("Error: " . curl_error($ch));
                    } else {
                        $decodedResponse = json_decode($response, true);
                    
                        if ($decodedResponse === null) {
                            die("Error decoding JSON response: " . json_last_error_msg());
                        }
                
                    }
                    curl_close($ch);
                    // dd($decodedResponse);

                    
                    $videolibraryurl = "https://api.bunny.net/videolibrary?page=0&perPage=1000&includeAccessKey=false/";
                    
                    $ch = curl_init();
                    
                    $options = array(
                        CURLOPT_URL => $videolibraryurl,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_HTTPHEADER => array(
                            "AccessKey: {$storage_settings->bunny_cdn_access_key}",
                            'Content-Type: application/json',
                        ),
                    );
                    
                    curl_setopt_array($ch, $options);
                    
                    $response = curl_exec($ch);
                    $videolibrary = json_decode($response, true);
                    curl_close($ch);
                    // dd($videolibrary); ApiKey

                }else{
                    $decodedResponse = [];
                    $videolibrary = [];

                }
          
                // $response->getBody();

                if(!empty($storage_settings) && !empty($storage_settings->bunny_cdn_file_linkend_hostname) ){
                    $streamUrl = $storage_settings->bunny_cdn_file_linkend_hostname;
                }else{
                    $streamUrl = '';
                }
                $theme_settings = SiteTheme::first();

                $compress_image_settings = CompressImage::first();

                if($this->Enable_Flussonic_Upload == 1){
           
                    try {
                        $client = new \GuzzleHttp\Client();

                        $response = $client->request('GET', "{$this->Flussonic_Server_Base_URL}streamer/api/v3/vods/{$this->Flussonic_Storage_Tag}", [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $this->Flussonic_Auth_Key, 
                            'Content-Type' => 'application/json', 
                        ]
                    ]);
                
                    $responseData = json_decode($response->getBody(), true);
                    $FlussonicUploadlibrary =  $responseData['storages'];
                       
                    } catch (RequestException $e) {
                        $FlussonicUploadlibrary = [];
                    }
                }else{
                    $FlussonicUploadlibrary = [];
                }
                
                if($theme_settings->enable_video_cipher_upload == 1){
                    $post_route = URL::to("admin/videos/VideoCipherFileUpload");
                }else{
                    $post_route = URL::to('admin/videos/fileupdate');
                }

                
            $data = [
                "headline" => '<i class="fa fa-plus-circle"></i> New Video',
                "post_route" => $post_route,
                "button_text" => "Add New Video",
                "admin_user" => Auth::user(),
                "related_videos" => Video::get(),
                "video_categories" => VideoCategory::all(),
                "ads" => Advertisement::where("status", "=", 1)->get(),
                "video_subtitle" => VideosSubtitle::all(),
                "languages" => Language::all(),
                "subtitles" => Subtitle::all(),
                "artists" => Artist::all(),
                "age_categories" => AgeCategory::all(),
                "settings" => $settings,
                "countries" => CountryCode::all(),
                "video_artist" => [],
                "page" => "Creates",
                "ads_category" => Adscategory::all(),
                "InappPurchase" => InappPurchase::all(),
                "post_dropzone_url" => $dropzone_url,
                "ads_tag_urls" => Advertisement::where('status',1)->get(),
                "AdminVideoPlaylist" => AdminVideoPlaylist::get(),
                'video_js_Advertisements' => $video_js_Advertisements ,
                'Bunny_Cdn_Videos' => $decodedResponse ,
                'storage_settings' => $storage_settings ,
                'videolibrary' => $videolibrary ,
                'streamUrl' => $streamUrl ,
                'theme_settings' => $theme_settings ,
                'advertisements_category' => Adscategory::get(),
                'compress_image_settings' => $compress_image_settings,
                'FlussonicUploadlibrary' => $FlussonicUploadlibrary,
            ];

            if($theme_settings->enable_video_cipher_upload == 1){
                return View::make("admin.videos.VideoCipherFileUpload", $data);
            }else{
                return View::make("admin.videos.fileupload", $data);
            }
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
            "title" => "required",
        ]);
        $image = isset($data["image"]) ? $data["image"] : "";
        $trailer = isset($data["trailer"]) ? $data["trailer"] : "";
        $mp4_url = isset($data["video"]) ? $data["video"] : "";
        $files = isset($data["subtitle_upload"])
            ? $data["subtitle_upload"]
            : "";
        /* logo upload */

        $path = public_path() . "/uploads/videos/";
        $image_path = public_path() . "/uploads/images/";

        $image = isset($data["image"]) ? $data["image"] : "";
        $trailer = isset($data["trailer"]) ? $data["trailer"] : "";
        $mp4_url = isset($data["video"]) ? $data["video"] : "";
        $files = isset($data["subtitle_upload"])
            ? $data["subtitle_upload"]
            : "";
        /* logo upload */

        $path = public_path() . "/uploads/videos/";
        $image_path = public_path() . "/uploads/images/";
        if (!empty($data["artists"])) {
            $artistsdata = $data["artists"];
            unset($data["artists"]);
        }
        if ($image != "") {
            //code for remove old file
            if ($image != "" && $image != null) {
                $file_old = $image_path . $image;
                if (file_exists($file_old)) {
                    unlink($file_old);
                }
            }
            //upload new file
            $file = $image;
            //   $data['image']  = $file->getClientOriginalName();
            $data["image"] = str_replace(
                " ",
                "_",
                $file->getClientOriginalName()
            );

            $file->move($image_path, $data["image"]);
        } else {
            $data["image"] = "default.jpg";
        }

        if ($request->slug != "") {
            $data["slug"] = $this->createSlug($request->slug);
        }

        if ($request->slug == "") {
            $data["slug"] = $this->createSlug($data["title"]);
        }

        if ($trailer != "") {
            //code for remove old file
            if ($trailer != "" && $trailer != null) {
                $file_old = $path . $trailer;
                if (file_exists($file_old)) {
                    unlink($file_old);
                }
            }
            //upload new file
            $randval = Str::random(16);
            $file = $trailer;
            $trailer_vid =
                $randval . "." . $request->file("trailer")->extension();
            $file->move($path, $trailer_vid);
            $data["trailer"] =
                URL::to("/") . "/public/uploads/videos/" . $trailer_vid;
        } else {
            $data["trailer"] = "";
        }

        //        print_r($data['mp4_url']);
        //        exit;

        // $tags = $data['tags'];

        $data["user_id"] = Auth::user()->id;

        //unset($data['tags']);

        if (empty($data["active"])) {
            $data["active"] = 0;
        }

        if (empty($data["year"])) {
            $data["year"] = 0;
        } else {
            $data["year"] = $data["year"];
        }

        if (empty($data["access"])) {
            $data["access"] = 0;
        } else {
            $data["access"] = $data["access"];
        }

        if (empty($data["language"])) {
            $data["language"] = 0;
        } else {
            $data["language"] = $data["language"];
        }

        if (!empty($data["embed_code"])) {
            $data["embed_code"] = $data["embed_code"];
        } else {
            $data["embed_code"] = "";
        }

        if ($request->slug != "") {
            $data["slug"] = $this->createSlug($request->slug);
        }

        if ($request->slug == "") {
            $data["slug"] = $this->createSlug($data["title"]);
        }

        if (empty($data["featured"])) {
            $data["featured"] = 0;
        }

        if (empty($data["type"])) {
            $data["type"] = "";
        }

        if (empty($data["status"])) {
            $data["status"] = 0;
        }

        if (empty($data["path"])) {
            $data["path"] = 0;
        }

        if (Auth::user()->role == "admin" && Auth::user()->sub_admin == 0) {
            $data["status"] = 1;
        }

        if (Auth::user()->role == "admin" && Auth::user()->sub_admin == 1) {
            $data["status"] = 0;
        }

        if (isset($data["duration"])) {
            //$str_time = $data
            $str_time = preg_replace(
                "/^([\d]{1,2})\:([\d]{2})$/",
                "00:$1:$2",
                $data["duration"]
            );
            sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
            $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
            $data["duration"] = $time_seconds;
        }

        $data['video_js_pre_position_ads'] = $request->video_js_pre_position_ads ;
        $data['video_js_post_position_ads'] = $request->video_js_pre_position_ads ;
        $data['video_js_mid_position_ads_category'] = $request->video_js_mid_position_ads_category ;
        $data['video_js_mid_advertisement_sequence_time'] = $request->video_js_mid_advertisement_sequence_time ;
        $data['expiry_date'] = $request->expiry_date ;

        if (!empty($data["embed_code"])) {
            $video = new Video();
            $video->disk = "public";
            $video->original_name = "public";
            $video->path = $path;
            $video->title = $data["title"];
            $video->slug = $data["slug"];
            $video->language = $data["language"];
            $video->image = $data["image"];
            $video->trailer = $data["trailer"];
            $video->mp4_url = $path;
            $video->type = $data["type"];
            $video->access = $data["access"];
            $video->embed_code = $data["embed_code"];
            $video->video_category_id = $data["video_category_id"];
            $video->details = $request->details;
            $video->description = $request->description;
            $video->user_id = Auth::user()->id;
            $video->save();
        }

        if ($mp4_url != "") {
            $ffprobe = \FFMpeg\FFProbe::create();
            $disk = "public";
            $data["duration"] = $ffprobe
                ->streams($request->video)
                ->videos()
                ->first()
                ->get("duration");

            $rand = Str::random(16);
            $path = $rand . "." . $request->video->getClientOriginalExtension();
            $request->video->storeAs("public", $path);
            $thumb_path = "public";

            $this->build_video_thumbnail($request->video, $path, $data["slug"]);

            $original_name = $request->video->getClientOriginalName()
                ? $request->video->getClientOriginalName()
                : "";

            $video = new Video();
            $video->disk = "public";
            $video->original_name = "public";
            $video->path = $rand;
            $video->title = $data["title"];
            $video->slug = $data["slug"];
            $video->language = $data["language"];
            $video->image = $data["image"];
            $video->trailer = $data["trailer"];
            $video->mp4_url = $path;
            $video->type = $data["type"];
            $video->access = $data["access"];
            $video->video_category_id = $data["video_category_id"];
            $video->details = $data["details"];
            $video->duration = $data["duration"];
            $video->description = $data["description"];
            $video->user_id = Auth::user()->id;
            $video->save();

            $lowBitrateFormat = (new X264(
                "libmp3lame",
                "libx264"
            ))->setKiloBitrate(500);
            $midBitrateFormat = (new X264(
                "libmp3lame",
                "libx264"
            ))->setKiloBitrate(1500);
            $highBitrateFormat = (new X264(
                "libmp3lame",
                "libx264"
            ))->setKiloBitrate(3000);
            $converted_name = ConvertVideoForStreaming::handle($path);

            $Playerui = Playerui::first();
            if(@$Playerui->video_watermark_enable == 1 && !empty($Playerui->video_watermark)){

                $video = Video::find($video->id);
                    $video->watermark_transcoding_progress = 1;
                    $video->save();

                TranscodeVideo::dispatch($video);
            }
            // else if(@$settings->video_clip_enable == 1 && !empty($settings->video_clip)){
            //     VideoClip::dispatch($video);
            // }
            else{
                if(Enable_4k_Conversion() == 1){
                    Convert4kVideoForStreaming::dispatch($video);
                }else{
                    ConvertVideoForStreaming::dispatch($video);
                }
            }             
        } else {
            $video = Video::create($data);
        }

        $shortcodes = $request["short_code"];
        $languages = $request["sub_language"];
        /* $languages =$request['language'];*/
        /* $languages = $subtitle->language;*/
        if (!empty($files != "" && $files != null)) {
            /* if($request->hasFile('subtitle_upload'))
        {
            $vid = $movie->id;
            $files = $request->file('subtitle_upload');
*/

            foreach ($files as $key => $val) {
                if (!empty($files[$key])) {
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
                    $destinationPath = "public/uploads/subtitles/";
                    $filename = $video->id . "-" . $shortcodes[$key] . ".srt";
                    $files[$key]->move($destinationPath, $filename);
                    $subtitle_data["video_id"] = $video->id;

                    $subtitle_data["sub_language"] = $languages[$key];
                    $subtitle_data["shortcode"] = $shortcodes[$key];
                    $subtitle_data["url"] =
                        URL::to("/") . "/public/uploads/subtitles/" . $filename;
                    $video_subtitle = VideosSubtitle::create($subtitle_data);
                }
            }
        }

        if (!empty($artistsdata)) {
            foreach ($artistsdata as $key => $value) {
                $artist = new Videoartist();
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

        return redirect("admin/videos")->with(
            "message",
            "Your video will be available shortly after we process it"
        );

        //return Redirect::to('admin/videos')->with(array('note' => 'New Video Successfully Added!', 'note_type' => 'success') );
    }

    public function destroy($id)
    {
        try {
        
            $videos = Video::find($id);

            

            $image_name_WithoutExtension     = substr($videos->image, 0, strrpos($videos->image, '.'));
            $ply_image_name_WithoutExtension = substr($videos->player_image, 0, strrpos($videos->player_image, '.'));
            $tv_image_name_WithoutExtension  = substr($videos->video_tv_image, 0, strrpos($videos->video_tv_image, '.'));


                    //  Delete Existing Image (PC-Image, Mobile-Image, Tablet-Image )
            if( $image_name_WithoutExtension != null && $image_name_WithoutExtension != "default_image"){
                if (File::exists(base_path('public/uploads/images/'.$videos->image))) {
                    File::delete(base_path('public/uploads/images/'.$videos->image));
                }
    
                if (File::exists(base_path('public/uploads/images/'.$videos->mobile_image))) {
                    File::delete(base_path('public/uploads/images/'.$videos->mobile_image));
                }
    
                if (File::exists(base_path('public/uploads/images/'.$videos->tablet_image))) {
                    File::delete(base_path('public/uploads/images/'.$videos->tablet_image));
                }
            }
            

                    //  Delete Existing Player Image
            if($ply_image_name_WithoutExtension != null && $ply_image_name_WithoutExtension != "default_horizontal_image"){
                if (File::exists(base_path('public/uploads/images/'.$videos->player_image))) {
                    File::delete(base_path('public/uploads/images/'.$videos->player_image));
                }
            }        
           
                    //  Delete Existing Video Tv Image
            if($tv_image_name_WithoutExtension != null && $tv_image_name_WithoutExtension != "default_horizontal_image"){
                if (File::exists(base_path('public/uploads/images/'.$videos->video_tv_image))) {
                    File::delete(base_path('public/uploads/images/'.$videos->video_tv_image));
                }
            }

                    //  Delete Existing Video Title Image
            if (File::exists(base_path('public/uploads/images/'.$videos->video_title_image))) {
                File::delete(base_path('public/uploads/images/'.$videos->video_title_image));
            }

                    //  Delete Existing PDF Image
            if (File::exists(base_path('public/uploads/videoPdf/'.$videos->pdf_files))) {
                File::delete(base_path('public/uploads/videoPdf/'.$videos->pdf_files));
            }

                    //  Delete Existing Reels Thumbnail Image
            if (File::exists(base_path('public/uploads/images/'.$videos->reels_thumbnail))) {
                File::delete(base_path('public/uploads/images/'.$videos->reels_thumbnail));
            }

                    //  Delete Existing Reels Video
            $ReelsVideo_retrieve =  ReelsVideo::where("video_id", $id)->get();

            foreach ($ReelsVideo_retrieve as $Reels_videos){
                if (File::exists(base_path('public/uploads/reelsVideos/'.$Reels_videos->reels_videos))) {
                    File::delete(base_path('public/uploads/reelsVideos/'.$Reels_videos->reels_videos));
                }
            }

                    //  Delete Existing Trailer Video - M3u8 Format

            if (!is_null($videos->trailer)) {

                $video_trailer_m3u8 = pathinfo($videos->trailer)['filename'];

                $directory = base_path('public/uploads/trailer/');
                        
                $pattern =  $video_trailer_m3u8.'*';

                $files = glob($directory . $pattern);

                foreach ($files as $file) {
                    File::delete($file);
                }
            }

                     //  Delete Existing Trailer Video - MP4 Format
            $video_trailer_mp4 = basename($videos->trailer);

            if (File::exists(base_path('public/uploads/videos/'.$video_trailer_mp4))) {
                File::delete(base_path('public/uploads/videos/'.$video_trailer_mp4));
            }

                    //  Delete Existing  Video
            $directory = storage_path('app/public');
                    
            if (!is_null($videos->path)) {

                $info = pathinfo($videos->path);

                $pattern =  $videos->path ? $info['filename'] . '*' : " ";
    
                $files = glob($directory . '/' . $pattern);
    
                foreach ($files as $file) {
    
                    if(file_exists( $file )){
                        unlink($file);
                    }
                }   
            }

                    // Video uploaded by CPP user while deleting Mail
            try {
                if($videos->uploaded_by != null && $videos->uploaded_by == "CPP"){

                    $Moderators_user_email = ModeratorsUser::where('id',$videos->user_id)->pluck('email')->first();
        
                    try {
        
                        $email_template_subject =  EmailTemplate::where('id',15)->pluck('heading')->first() ;
                        $email_subject  = str_replace("{ContentName}", "$videos->title", $email_template_subject);
            
                        $data = array(
                            'email_subject' => $email_subject,
                        );
            
                        Mail::send('emails.CPP_Partner_Content_delete', array(
                            'Name'         => Auth::user() != null && Auth::user()->name ? Auth::user()->name : Auth::user()->username ,
                            'ContentName'  =>  $videos->title,
                            'website_name' =>  GetWebsiteName(),
                        ), 
                        function($message) use ($data,$Moderators_user_email) {
                            $message->from(AdminMail(),GetWebsiteName());
                            $message->to($Moderators_user_email)->subject($data['email_subject']);
                        });
            
                        $email_log      = 'Mail Sent Successfully from Partner Content Delete';
                        $email_template = "15";
                        $user_id = $id;
            
                        Email_sent_log($user_id,$email_log,$email_template);
            
                    } catch (\Throwable $th) {
            
                        $email_log = $th->getMessage();
                        $email_template = "15";
                        $user_id = $user_id;
            
                        Email_notsent_log($user_id, $email_log, $email_template);
                    }
                }
            } catch (\Throwable $th) {
                
            }

            //log
            $options = new Options();
            $options->set('defaultFont', 'Courier');
            $dompdf = new Dompdf($options);
            $html = view('pdf.video_details', ['video' => $videos, 'user' => Auth::user()])->render();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            $pdfFileName = "video_{$id}.pdf";
            $pdfPath = public_path("deletedPDF/{$pdfFileName}");

            if (!file_exists(public_path('deletedPDF'))) {
                mkdir(public_path('deletedPDF'), 0777, true);
            }

            file_put_contents($pdfPath, $dompdf->output());

            // dd(Auth::user()->id);

            DeleteLog::create([
                'video_id'      => $id,
                'user_id'         => Auth::user()->id,
                'deleted_item'    => 'video',
                'created_at'      => now(),
                'updated_at'      => now(),
                'pdf_path'        => $pdfFileName,
            ]);

                    // Video Destroy
            \LogActivity::addVideodeleteLog("Deleted Video.", $id);

            Videoartist::where('video_id', $id)->delete();
            RelatedVideo::where('video_id', $id)->delete();
            LanguageVideo::where('video_id', $id)->delete();
            Blockvideo::where('video_id', $id)->delete();
            ReelsVideo::where("video_id", $id)->delete();
            PlayerAnalytic::where("videoid", $id)->delete();
            CategoryVideo::where("video_id", $id)->delete();
            PlayerSeekTimeAnalytic::where("video_id", $id)->delete();
            VideoPlaylist::where("video_id", $id)->delete();
            Video::destroy($id);

            // VideoResolution::where('video_id', '=', $id)->delete();
            // VideoSubtitle::where('video_id', '=', $id)->delete();

            return Redirect::to("admin/videos")->with([
                "message" => "Successfully Deleted Video",
                "note_type" => "success",
            ]);
        } catch (\Throwable $th) {
            return $th->getMessage();
            return abort(404) ;
        }
    }

    public function edit($id)
    {
        try {

            if (!Auth::user()->role == "admin") {
                return redirect("/home");
            }
            
            $settings = Setting::first();
            $video = Video::find($id);
            
            $ads_details = AdsVideo::join("advertisements", "advertisements.id", "ads_videos.ads_id")
                ->where("ads_videos.video_id", $id)
                ->pluck("ads_id")
                ->first();
            
            $ads_rolls = AdsVideo::join("advertisements", "advertisements.id", "ads_videos.ads_id")
                ->where("ads_videos.video_id", $id)
                ->pluck("ad_roll")
                ->first();
            
            $MoviesSubtitles = MoviesSubtitles::where('movie_id', $id)->get();
            
            $ads_category = Adscategory::get();
            
            $Reels_videos = Video::Join("reelsvideo", "reelsvideo.video_id", "=", "videos.id")
                ->where("videos.id", $id)
                ->get();
            
            $related_videos = Video::get();
            $all_related_videos = RelatedVideo::where("video_id", $id)->pluck("related_videos_id")->toArray();
            $subtitlescount = Subtitle::join('movies_subtitles', 'movies_subtitles.sub_language', '=', 'subtitles.language')
                ->where(['movie_id' => $id])
                ->count();
            
            if ($subtitlescount > 0) {
                $subtitles = Subtitle::join('movies_subtitles', 'movies_subtitles.sub_language', '=', 'subtitles.language')
                    ->where(['movie_id' => $id])
                    ->get(["subtitles.*", "movies_subtitles.url", "movies_subtitles.id as movies_subtitles_id"]);
            } else {
                $subtitles = Subtitle::all();
            }

            // Video Js Ads-data

            $video_js_Advertisements = Advertisement::where('status',1)->get() ;


            $admin_videos_ads = AdminVideoAds::where('video_id',$id)->first();

            $compress_image_settings = CompressImage::first();

            $data = [
                "headline" => '<i class="fa fa-edit"></i> Edit Video',
                "page"     => "Edit",
                "video"    => $video,
                "post_route"  => URL::to("admin/videos/update"),
                "button_text" => "Update Video",
                "admin_user"  => Auth::user(),
                "video_categories" => VideoCategory::all(),
                "ads" => Advertisement::where("status", "=", 1)->get(),
                "video_subtitle" => VideosSubtitle::all(),
                "subtitles" => Subtitle::all(),
                "languages" => Language::all(),
                "artists" => Artist::all(),
                "settings" => $settings,
                "related_videos" => Video::get(),
                "all_related_videos" => RelatedVideo::where("video_id", $id)->pluck("related_videos_id")->toArray(),
                "age_categories" => AgeCategory::get(),
                "countries" => CountryCode::all(),
                "video_artist" => Videoartist::where("video_id", $id)->pluck("artist_id")->toArray(),
                "category_id"  => CategoryVideo::where("video_id", $id)->pluck("category_id")->toArray(),
                "languages_id" => LanguageVideo::where("video_id", $id)->pluck("language_id")->toArray(),
                "block_countries" => BlockVideo::where("video_id", $id)->pluck("country_id")->toArray(),
                "Reels_videos" => $Reels_videos,
                "ads_paths" => $ads_details ? $ads_details : 0,
                "ads_rolls" => $ads_rolls ? $ads_rolls : 0,
                "ads_category" => $ads_category,
                "block_countries" => BlockVideo::where("video_id", $id)->pluck("country_id")->toArray(),
                "InappPurchase" => InappPurchase::all(),

                'pre_ads'  => Video::select('advertisements.*')->join('advertisements','advertisements.id','=','videos.pre_ads')
                                ->where('ads_upload_type','ads_video_upload')->where('advertisements.status',1)
                                ->where('videos.id',$id)->first(),
    
                'mid_ads'  => Video::select('advertisements.*')->join('advertisements','advertisements.id','=','videos.mid_ads')
                                ->where('ads_upload_type','ads_video_upload')->where('advertisements.status',1)
                                ->where('videos.id',$id)->first(),
    
                'post_ads' => Video::select('advertisements.*')->join('advertisements','advertisements.id','=','videos.post_ads')
                                ->where('ads_upload_type','ads_video_upload')->where('advertisements.status',1)
                                ->where('videos.id',$id)->first(),
    
                "ads_tag_urls" => Advertisement::where('status',1)->where('id',$video->ads_tag_url_id)->first(),
                "MoviesSubtitles" => $MoviesSubtitles ,
                "subtitlescount" => $subtitlescount,
                "AdminVideoPlaylist" => AdminVideoPlaylist::get(),
                "Playlist_id"  => VideoPlaylist::where("video_id", $id)->pluck("playlist_id")->toArray(),
                'video_js_Advertisements' => $video_js_Advertisements ,
                'admin_videos_ads'        => $admin_videos_ads ,
                'advertisements_category' => Adscategory::get(),
                'compress_image_settings' => $compress_image_settings,
                'theme_settings' => SiteTheme::first(),
            ];

            $theme_settings = SiteTheme::first();

            if($theme_settings->enable_video_cipher_upload == 1){
                return View::make("admin.videos.VideoCipher_create_edit", $data);
            }else{
                return View::make("admin.videos.create_edit", $data);
            }
            
        } catch (\Throwable $th) {

            return abort(404);  
        }
    }
    
    public function subtitledestroy($id)
    {
        MoviesSubtitles::destroy($id);

        return Redirect::back()->with([
            "message" => "Successfully Updated Video!",
            "note_type" => "success",
        ]);

    }
    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request)
    {

        if (!Auth::user()->role == "admin") {
            return redirect("/home");
        }

        $data = $request->all();
      

        $validatedData = $request->validate([
            "title" => "required|max:255",
        ]);

        $id = $request->videos_id;
        $package = User::where("id", 1)->first();
        $pack = $package->package;
        $settings = Setting::first();

        $video = Video::findOrFail($id);
        Video::query()->where('id','!=', $id)->update(['today_top_video' => 0]);

        if(!empty($data['slug'])){
            $slug = str_replace('#', '', $data['slug']);

            $slug = Str::slug($slug, '-');
        }else{
            $slug = Str::slug($data['title'], '-');
        }
        // dd(!empty($data['slug']));

    if (compress_responsive_image_enable() == 1) {

         $mobileimages = public_path('/uploads/mobileimages');
         $Tabletimages = public_path('/uploads/Tabletimages');
         $PCimages = public_path('/uploads/PCimages');

        if (!file_exists($mobileimages)) {
            mkdir($mobileimages, 0755, true);
        }

        if (!file_exists($Tabletimages)) {
            mkdir($Tabletimages, 0755, true);
        }

        if (!file_exists($PCimages)) {
            mkdir($PCimages, 0755, true);
        }

        if ($request->hasFile('image')) {

            $image = $request->file('image');

                $image_filename = 'video_' .time() . '_image.' . $image->getClientOriginalExtension();
                $image_filename = $image_filename;

                Image::make($image)->resize(568,320)->save(base_path() . '/public/uploads/mobileimages/' . $image_filename, compress_image_resolution());
                Image::make($image)->resize(480,853)->save(base_path() . '/public/uploads/Tabletimages/' . $image_filename, compress_image_resolution());
                Image::make($image)->resize(675,1200)->save(base_path() . '/public/uploads/PCimages/' . $image_filename, compress_image_resolution());
                
                $responsive_image = $image_filename;

        }else{

            $responsive_image = $video->responsive_image; 
        }

        if ($request->hasFile('player_image')) {

            $player_image = $request->file('player_image');

                $player_image_filename = 'video_' .time() . '_player_image.' . $player_image->getClientOriginalExtension();

                Image::make($player_image)->resize(568,320)->save(base_path() . '/public/uploads/mobileimages/' . $player_image_filename, compress_image_resolution());
                Image::make($player_image)->resize(480,853)->save(base_path() . '/public/uploads/Tabletimages/' . $player_image_filename, compress_image_resolution());
                Image::make($player_image)->resize(675,1200)->save(base_path() . '/public/uploads/PCimages/' . $player_image_filename, compress_image_resolution());
                
                $responsive_player_image = $player_image_filename;

        }else{

            $responsive_player_image = $video->responsive_player_image; 
        }


        
        if ($request->hasFile('video_tv_image')) {

            $video_tv_image = $request->file('video_tv_image');

                $video_tv_image_filename = 'video_' .time() . '_tv_image.' . $video_tv_image->getClientOriginalExtension();

                Image::make($video_tv_image)->resize(568,320)->save(base_path() . '/public/uploads/mobileimages/' . $video_tv_image_filename, compress_image_resolution());
                Image::make($video_tv_image)->resize(480,853)->save(base_path() . '/public/uploads/Tabletimages/' . $video_tv_image_filename, compress_image_resolution());
                Image::make($video_tv_image)->resize(675,1200)->save(base_path() . '/public/uploads/PCimages/' . $video_tv_image_filename, compress_image_resolution());
                
                $responsive_tv_image = $video_tv_image_filename;

        }else{

            $responsive_tv_image = $video->responsive_tv_image; 
        }


        }else{
            $responsive_image = $video->responsive_image; 
            $responsive_player_image = $video->responsive_player_image; 
            $responsive_tv_image = $video->responsive_tv_image; 
        }

        if ($request->hasFile('image')) {
            $tinyimage = $request->file('image');
            if (compress_image_enable() == 1) {
                $image_filename = time() . '.' . compress_image_format();
                $tiny_video_image = 'tiny-image-' . $image_filename;
                Image::make($tinyimage)->resize(450,320)->save(base_path() . '/public/uploads/images/' . $tiny_video_image, compress_image_resolution());
            } else {
                $image_filename = time() . '.' . $tinyimage->getClientOriginalExtension();
                $tiny_video_image = 'tiny-image-' . $image_filename;
                Image::make($tinyimage)->resize(450,320)->save(base_path() . '/public/uploads/images/' . $tiny_video_image, compress_image_resolution());
            }
            $tiny_video_image = $tiny_video_image;

        }else{
            $tiny_video_image = $video->tiny_video_image; 
        }
        if ($request->hasFile('player_image')) {

            $tinyplayer_image = $request->file('player_image');

            if (compress_image_enable() == 1) {
                $image_filename = time() . '.' . compress_image_format();
                $tiny_player_image = 'tiny-player_image-' . $image_filename;
                Image::make($tinyplayer_image)->resize(450,320)->save(base_path() . '/public/uploads/images/' . $tiny_player_image, compress_image_resolution());
            } else {
                $image_filename = time() . '.' . $tinyplayer_image->getClientOriginalExtension();
                $tiny_player_image = 'tiny-player_image-' . $image_filename;
                Image::make($tinyplayer_image)->resize(450,320)->save(base_path() . '/public/uploads/images/' . $tiny_player_image, compress_image_resolution());

            }
            $tiny_player_image = $tiny_player_image;
        }else{
            $tiny_player_image = $video->tiny_player_image; 
        }
        if ($request->hasFile('video_title_image')) {

            $tinyvideo_title_image = $request->file('video_title_image');

            if (compress_image_enable() == 1) {
                $image_filename = time() . '.' . compress_image_format();
                $tiny_video_title_image = 'tiny-video_title_image-' . $image_filename;
                Image::make($tinyvideo_title_image)->resize(450,320)->save(base_path() . '/public/uploads/images/' . $tiny_video_title_image, compress_image_resolution());
            } else {
                $image_filename = time() . '.' . $tinyvideo_title_image->getClientOriginalExtension();
                $tiny_video_title_image = 'tiny-video_title_image-' . $image_filename;
                Image::make($tinyvideo_title_image)->resize(450,320)->save(base_path() . '/public/uploads/images/' . $tiny_video_title_image, compress_image_resolution());

            }
            $tiny_video_title_image = $tiny_video_title_image;

        }else{
            $tiny_video_title_image = $video->tiny_video_title_image; 
        }

        $image = isset($data["image"]) ? $data["image"] : "";
        $trailer = isset($data["trailer"]) ? $data["trailer"] : "";
        $mp4_url2 = isset($data["video"]) ? $data["video"] : "";
        $files = isset($data["subtitle_upload"])? $data["subtitle_upload"] : "";
        $player_image = isset($data["player_image"]) ? $data["player_image"]: "";
        $video_title_image = isset($data["video_title_image"])? $data["video_title_image"]: "";
        $image_path = public_path() . "/uploads/images/";
    

        // Enable Video Title Thumbnail

        $video->enable_video_title_image = $request->enable_video_title_image  ? "1" : "0";

        // Trailer Update

        $path = public_path() . "/uploads/videos/";
        if($trailer != ""){
            $video->trailer_type = $data["trailer_type"];
        }

        $StorageSetting = StorageSetting::first();

        if($StorageSetting->site_storage == 1){
            if (
                $trailer != "" &&
                $pack == "Business" &&
                $settings->transcoding_access == 1 &&
                $data["trailer_type"] == "video_mp4"
            ) {

                if ($settings->transcoding_resolution != null) {
                    $convertresolution = [];
                    $resolution = explode(",", $settings->transcoding_resolution);
                    foreach ($resolution as $value) {
                        if ($value == "240p") {
                            $r_240p = (new Representation())->setKiloBitrate(150)->setResize(426, 240);
                            array_push($convertresolution, $r_240p);
                        }
                        if ($value == "360p") {
                            $r_360p = (new Representation())
                                ->setKiloBitrate(276)
                                ->setResize(640, 360);
                            array_push($convertresolution, $r_360p);
                        }
                        if ($value == "480p") {
                            $r_480p = (new Representation())
                                ->setKiloBitrate(750)
                                ->setResize(854, 480);
                            array_push($convertresolution, $r_480p);
                        }
                        if ($value == "720p") {
                            $r_720p = (new Representation())
                                ->setKiloBitrate(2048)
                                ->setResize(1280, 720);
                            array_push($convertresolution, $r_720p);
                        }
                        if ($value == "1080p") {
                            $r_1080p = (new Representation())
                                ->setKiloBitrate(4096)
                                ->setResize(1920, 1080);
                            array_push($convertresolution, $r_1080p);
                        }
                    }
                }
                $trailer = $data["trailer"];
                $trailer_path = URL::to("storage/app/trailer/");
                $trailer_Videoname =  Str::lower($trailer->getClientOriginalName());
                $trailer_Video = time() . "_" . str_replace(" ","_",$trailer_Videoname);
                $trailer->move(storage_path("app/trailer/"), $trailer_Video);
                $trailer_video_name = strtok($trailer_Video, ".");
                $M3u8_save_path =
                    $trailer_path . "/" . $trailer_video_name . ".m3u8";
                $storepath = URL::to("storage/app/trailer/");
    
                $data["trailer"] = $M3u8_save_path;
                $video->trailer_type = "m3u8";
                $data["trailer_type"] = "m3u8";
            } else {
                
                if ($trailer != "" && $data["trailer_type"] == "video_mp4") {
                    if (!empty($trailer)) {
                        if ($trailer != "" && $trailer != null) {
                            $file_old = $path . $trailer;
    
                            if (file_exists($file_old)) {
                                unlink($file_old);
                            }
                        }
                        //upload new file
                        $randval = Str::random(16);
                        $file = $trailer;
                        $trailer_vid =
                            $randval . "." . $request->file("trailer")->extension();
                        $file->move($path, $trailer_vid);
    
                        $data["trailer"] =
                            URL::to("/") . "/public/uploads/videos/" . $trailer_vid;
                        $video->trailer =
                            URL::to("/") . "/public/uploads/videos/" . $trailer_vid;
                    } else {
                        $data["trailer"] = $video->trailer;
                        $data["trailer_type"] = $video->trailer_type;
                    }
                } elseif ($data["trailer_type"] == "m3u8_url") {
                    $video->trailer = $data["m3u8_trailer"];
                    $data["trailer"] = $data["m3u8_trailer"];
                } elseif ($data["trailer_type"] == "mp4_url") {
                    $video->trailer = $data["mp4_trailer"];
                    $data["trailer"] = $data["mp4_trailer"];
                } elseif ($data["trailer_type"] == "embed_url") {
                    $video->trailer = $data["embed_trailer"];
                    $data["trailer"] = $data["embed_trailer"];
                } else {
                    $data["trailer"] = $video->trailer;
                    $data["trailer_type"] = $video->trailer_type;
                    // dd('test'.$video);

                }
                // $data['trailer'] = "";
            }
    
        }elseif($StorageSetting->aws_storage == 1 && !empty($data["trailer"])){
            if (
                $trailer != "" &&
                $pack == "Business" &&
                $settings->transcoding_access == 1 &&
                $data["trailer_type"] == "video_mp4"
            ) {

                $file = $request->file('trailer');
                $file_folder_name =  $file->getClientOriginalName();
                $name_mp4 =  $file->getClientOriginalName();
                $newfile = explode(".mp4",$name_mp4);
                // $name = $newfile[0].'.m3u8';   
                $name = $namem3u8 == null ? str_replace(' ', '_', 'S3'.$namem3u8) : str_replace(' ', '_', 'S3'.$namem3u8) ;        
                $filePath = $StorageSetting->aws_video_trailer_path.'/'. $name;
                $transcode_path = @$StorageSetting->aws_transcode_path.'/'. $name;
                Storage::disk('s3')->put($transcode_path, file_get_contents($file));
                $path = 'https://' . env('AWS_BUCKET').'.s3.'. env('AWS_DEFAULT_REGION') . '.amazonaws.com' ;
                $M3u8_path = $path.$filePath;
                $M3u8_save_path = $path.$transcode_path;
                $data["trailer"] = $M3u8_save_path;
                $video->trailer_type = "m3u8";
                $data["trailer_type"] = "m3u8";

            }else{

                $file = $request->file('trailer');
                $file_folder_name =  $file->getClientOriginalName();
                $name = time() . $file->getClientOriginalName();
                $filePath = $StorageSetting->aws_video_trailer_path.'/'. $name;
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                $path = 'https://' . env('AWS_BUCKET').'.s3.'. env('AWS_DEFAULT_REGION') . '.amazonaws.com' ;
                $trailer = $path.$filePath;
                $data["trailer"] = $trailer;
                $data["trailer_type"] = 'video_mp4';
            }
        }else{ 
            if (
                $trailer != "" &&
                $pack == "Business" &&
                $settings->transcoding_access == 1 &&
                $data["trailer_type"] == "video_mp4"
            ) {
                if ($settings->transcoding_resolution != null) {
                    $convertresolution = [];
                    $resolution = explode(",", $settings->transcoding_resolution);
                    foreach ($resolution as $value) {
                        if ($value == "240p") {
                            $r_240p = (new Representation())
                                ->setKiloBitrate(150)
                                ->setResize(426, 240);
                            array_push($convertresolution, $r_240p);
                        }
                        if ($value == "360p") {
                            $r_360p = (new Representation())
                                ->setKiloBitrate(276)
                                ->setResize(640, 360);
                            array_push($convertresolution, $r_360p);
                        }
                        if ($value == "480p") {
                            $r_480p = (new Representation())
                                ->setKiloBitrate(750)
                                ->setResize(854, 480);
                            array_push($convertresolution, $r_480p);
                        }
                        if ($value == "720p") {
                            $r_720p = (new Representation())
                                ->setKiloBitrate(2048)
                                ->setResize(1280, 720);
                            array_push($convertresolution, $r_720p);
                        }
                        if ($value == "1080p") {
                            $r_1080p = (new Representation())
                                ->setKiloBitrate(4096)
                                ->setResize(1920, 1080);
                            array_push($convertresolution, $r_1080p);
                        }
                    }
                }
                $trailer = $data["trailer"];
                $trailer_path = URL::to("storage/app/trailer/");
                $trailer_Videoname =  Str::lower($trailer->getClientOriginalName());
                $trailer_Video = time() . "_" . str_replace(" ","_",$trailer_Videoname);
                $trailer->move(storage_path("app/trailer/"), $trailer_Video);
                $trailer_video_name = strtok($trailer_Video, ".");
                $M3u8_save_path =
                    $trailer_path . "/" . $trailer_video_name . ".m3u8";
                $storepath = URL::to("storage/app/trailer/");
    
                $data["trailer"] = $M3u8_save_path;
                $video->trailer_type = "m3u8";
                $data["trailer_type"] = "m3u8";
            } else {
                if ( $trailer != "" && $data["trailer_type"] == "video_mp4") {
                    if (!empty($trailer)) {
                        if ($trailer != "" && $trailer != null) {
                            $file_old = $path . $trailer;
    
                            if (file_exists($file_old)) {
                                unlink($file_old);
                            }
                        }
                        //upload new file
                        $randval = Str::random(16);
                        $file = $trailer;
                        $trailer_vid =
                            $randval . "." . $request->file("trailer")->extension();
                        $file->move($path, $trailer_vid);
    
                        $data["trailer"] =
                            URL::to("/") . "/public/uploads/videos/" . $trailer_vid;
                        $video->trailer =
                            URL::to("/") . "/public/uploads/videos/" . $trailer_vid;
                    } else {
                        $data["trailer"] = $video->trailer;
                        $data["trailer_type"] = $video->trailer_type;

                    }
                } elseif ($data["trailer_type"] == "m3u8_url") {
                    $video->trailer = $data["m3u8_trailer"];
                    $data["trailer"] = $data["m3u8_trailer"];
                } elseif ($data["trailer_type"] == "mp4_url") {
                    $video->trailer = $data["mp4_trailer"];
                    $data["trailer"] = $data["mp4_trailer"];
                } elseif ($data["trailer_type"] == "embed_url") {
                    $video->trailer = $data["embed_trailer"];
                    $data["trailer"] = $data["embed_trailer"];
                } else {
                    $data["trailer"] = $video->trailer;
                    $data["trailer_type"] = $video->trailer_type;
                }
                }
            }



        $update_mp4 = $request->get("video");

        if (empty($data["active"])) {
            $active = 0;
            $status = 0;
        } else {
            $active = 1;
            // $status = 1;
        }

        if (empty($data["webm_url"])) {
            $data["webm_url"] = 0;
        } else {
            $data["webm_url"] = $data["webm_url"];
        }

        if (empty($data["ogg_url"])) {
            $data["ogg_url"] = 0;
        } else {
            $data["ogg_url"] = $data["ogg_url"];
        }

        if (empty($data["year"])) {
            $year = 0;
        } else {
            $year = $data["year"];
        }

        if (empty($data["language"])) {
            $data["language"] = 0;
        } else {
            $data["language"] = $data["language"];
        }

        if (!empty($video->mp4_url)) {
            $data["mp4_url"] = $video->mp4_url;
        } else {
            $data["mp4_url"] = null;
        }

        if (!empty($video->m3u8_url)) {
            $data["m3u8_url"] = $video->m3u8_url;
        } else {
            $data["m3u8_url"] = null;
        }

        if (!empty($video->embed_code)) {
            $data["embed_code"] = $video->embed_code;
        } else {
            $data["embed_code"] = null;
        }

        if (empty($data["age_restrict"])) {
            $data["age_restrict"] = 0;
        } else {
            $data["age_restrict"] = $data["age_restrict"];
        }

        if (empty($data["featured"])) {
            $featured = 0;
        } else {
            $featured = 1;
        }

        if (empty($data["active"])) {
            $active = 0;
            $status = 0;
            $draft = 1;
        } else {
            $active = 1;
            $draft = 1;
            if (
                ($video->type == "" && $video->processed_low != 100) && $StorageSetting->site_storage == 1 ||
                ($video->type == "" && $video->processed_low == null) && $StorageSetting->site_storage == 1
            ) {
                $status = 0;
            } else {
                $status = 1;
            }
        }

        if (!empty($data["embed_code"])) {
            $data["embed_code"] = $data["embed_code"];
        }

        if (!empty($data["m3u8_url"])) {
            $data["m3u8_url"] = $data["m3u8_url"];
        }

        if (empty($data["video_gif"])) {
            $data["video_gif"] = "";
        }

        if (empty($data["type"])) {
            $data["type"] = "";
        }

        if (empty($data["status"])) {
            $data["status"] = 0;
        }
        if (empty($data["publish_status"])) {
            $data["publish_status"] = 0;
        }

        if (empty($data["publish_status"])) {
            $data["publish_status"] = 0;
        }

        // if(Auth::user()->role =='admin' && Auth::user()->sub_admin == 0 ){
        //         $data['status'] = 1;
        // }

        // if( Auth::user()->role =='admin' && Auth::user()->sub_admin == 1 ){
        //         $data['status'] = 0;
        // }

        $image_path = public_path() . "/uploads/images/";

        if ($image != "") {
            if ($image != "" && $image != null) {
                $file_old = $image_path . $image;
                if (file_exists($file_old)) {
                    unlink($file_old);
                }
            }

            $file = $image;

            if(compress_image_enable() == 1){

                $image_filename  = time().'.'.compress_image_format();
                $video_image     =  'pc-image-'.$image_filename ;
                $Mobile_image    =  'Mobile-image-'.$image_filename ;
                $Tablet_image    =  'Tablet-image-'.$image_filename ;

                Image::make($file)->save( base_path() . "/public/uploads/images/" . $video_image,compress_image_resolution());
                Image::make($file)->save( base_path() . "/public/uploads/images/" . $Mobile_image,compress_image_resolution());
                Image::make($file)->save(base_path() . "/public/uploads/images/" . $Tablet_image, compress_image_resolution());

                $video->image = $video_image;
                $video->mobile_image = $Mobile_image;
                $video->tablet_image = $Tablet_image;
                $data["image"] = $video_image;

            }
            else{
                $image_filename  = time().'.'.$file->getClientOriginalExtension();

                $video_image     =  'pc-image-'.$image_filename ;
                $Mobile_image    =  'Mobile-image-'.$image_filename ;
                $Tablet_image    =  'Tablet-image-'.$image_filename ;

                Image::make($file)->save( base_path() . "/public/uploads/images/" . $video_image);
                Image::make($file)->save( base_path() . "/public/uploads/images/" . $Mobile_image);
                Image::make($file)->save(base_path() . "/public/uploads/images/" . $Tablet_image);

                $video->image = $video_image;
                $video->mobile_image = $Mobile_image;
                $video->tablet_image = $Tablet_image;
                $data["image"] = $video_image;
            }
          
        }else if (!empty($request->selected_image_url)) {
            $data["image"] = $request->selected_image_url;
        } else {
            $data["image"] = $video->image;
        }

        if ($player_image != "") {
            if ($player_image != "" && $player_image != null) {
               
                $file_old = $image_path . $player_image;
                if (file_exists($file_old)) {
                    unlink($file_old);
                }
            }
            
            $player_image = $player_image;

            if(compress_image_enable() == 1){

                $player_filename  = time().'.'.compress_image_format();
                $players_image     =  'player-image-'.$player_filename ;
                Image::make($player_image)->save(base_path().'/public/uploads/images/'.$players_image,compress_image_resolution() );

            }
            else{
                $player_filename  = time().'.'.$player_image->getClientOriginalExtension();
                $players_image     =  'player-image-'.$player_filename ;
                Image::make($player_image)->save(base_path().'/public/uploads/images/'.$players_image );
            }

        }else if (!empty($request->video_image_url)) {
            $players_image = $request->video_image_url;
        } else {
            $players_image = $video->player_image;
        }
        
       

        if (isset($data["duration"])) {
            //$str_time = $data
            $str_time = preg_replace(
                "/^([\d]{1,2})\:([\d]{2})$/",
                "00:$1:$2",
                $data["duration"]
            );
            sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
            $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
            $data["duration"] = $time_seconds;
        }

        if ($mp4_url2 != "") {
            $data["status"] = 0;
            $data["processed_low"] = 0;
            //code for remove old file
            $rand = Str::random(16);
            $path = $rand . "." . $request->video->getClientOriginalExtension();
            $request->video->storeAs("public", $path);
            $data["mp4_url"] = $path;
            $data["path"] = $path;
            $data["status"] = 0;
            $data["processed_low"] = 0;
            $video->update($data);

            // $original_name = ($request->video->getClientOriginalName()) ? $request->video->getClientOriginalName() : '';
            $original_name = URL::to("/") . "/storage/app/public/" . $path;

            $Playerui = Playerui::first();
            if(@$Playerui->video_watermark_enable == 1 && !empty($Playerui->video_watermark)){

                $video = Video::find($video->id);
                $video->watermark_transcoding_progress = 1;
                $video->save();

                TranscodeVideo::dispatch($video);
            }
            // else if(@$settings->video_clip_enable == 1 && !empty($settings->video_clip)){
            //     VideoClip::dispatch($video);
            // }
            else{
                if(Enable_4k_Conversion() == 1){
                    Convert4kVideoForStreaming::dispatch($video);
                }else{
                    ConvertVideoForStreaming::dispatch($video);
                }
            }           
             // ConvertVideoForStreaming::dispatch($video);
        }

        if (!empty($data["embed_code"])) {
            $video->embed_code = $data["embed_code"];
        } else {
            $video->embed_code = "";
        }


        if($request->ppv_price == null && empty($data["global_ppv"]) ){
            $video->global_ppv = null;
            $data["ppv_price"] = null;

        }else if($request->ppv_price == null && empty($data["global_ppv"]) ){
            $video->global_ppv = null;
            $data["ppv_price"] = null;
        }else{

            if (!empty($data["global_ppv"]) && !empty($data["set_gobal_ppv_price"]) && $request->ppv_option == 1) {
                $video->global_ppv = $data["global_ppv"];
                $data["ppv_price"] = $data["set_gobal_ppv_price"];
            } else if(!empty($data["global_ppv"])  && $request->ppv_option == 2) {
                $video->global_ppv = $data["global_ppv"];
                $data["ppv_price"] = $settings->ppv_price;
            } else if(!empty($data["global_ppv"])  && !empty($data["set_gobal_ppv_price"])) {
                $video->global_ppv = $data["global_ppv"];
                $data["ppv_price"] = $data["set_gobal_ppv_price"];
            }  else if(!empty($data["global_ppv"])) {
                $video->global_ppv = $data["global_ppv"];
                $data["ppv_price"] = $settings->ppv_price;
            }else if(empty($data["global_ppv"]) && !empty($data["ppv_price"])  && $request->ppv_price != null) {
                $data["ppv_price"] = $request->ppv_price;
                $video->global_ppv = null;
            }  else {
                $video->global_ppv = null;
                $data["ppv_price"] = null;
            }
        }
        // if (!empty($data["global_ppv"])) {
        //     $video->global_ppv = $data["global_ppv"];
        // } else {
        //     $video->global_ppv = null;
        // }

        if (!empty($data["enable"])) {
            $enable = $data["enable"];
        } else {
            $enable = 0;
        }

        if (!empty($data["banner"])) {
            $banner = $data["banner"];
        } else {
            $banner = 0;
        }

        if (!empty($data["embed_code"])) {
            $embed_code = $data["embed_code"];
        } else {
            $embed_code = null;
        }

        if (!empty($data["mp4_url"])) {
            $mp4_url = $data["mp4_url"];
        } else {
            $mp4_url = null;
        }

        if (!empty($data["m3u8_url"])) {
            $m3u8_url = $data["m3u8_url"];
        } else {
            $m3u8_url = null;
        }

        if (!empty($data["title"])) {
            $video->title = $data["title"];
        } else {
        }

        if (!empty($slug)) {
            $video->slug = $slug;
        } 

        if (empty($data["publish_type"])) {
            $publish_type = 0;
        } else {
            $publish_type = $data["publish_type"];
        }

        if (empty($data["publish_time"])) {
            $publish_time = 0;
        } else {
            $publish_time = $data["publish_time"];
        }

        if (!empty($data["Recommendation"])) {
            $video->Recommendation = $data["Recommendation"];
        }

        if (empty($data["age_restrict"])) {
            $video->age_restrict = $data["age_restrict"];
        }

        if (!empty($data["details"])) {
            $video->details = $data["details"];
        }
        if (!empty($data["details"])) {
            $details = $data["details"];
        } else {
            $details = null;
        }

        if ($request->pdf_file != null) {
            $pdf_files = time() . "." . $request->pdf_file->extension();
            $request->pdf_file->move( public_path("uploads/videoPdf"), $pdf_files);
            $video->pdf_files = $pdf_files;
        }

        // Reels videos
        $reels_videos = $request->reels_videos;

        if ($request->enable_reel_conversion == 1 && $reels_videos != null) {
            ReelsVideo::where("video_id", $video->id)->delete();

            foreach ($reels_videos as $Reel_Videos) {
                $reelvideo_name =
                    time() . rand(1, 50) . "." . $Reel_Videos->extension();
                $reel_videos_slug = substr(
                    $Reel_Videos->getClientOriginalName(),
                    0,
                    strpos($Reel_Videos->getClientOriginalName(), ".")
                );

                $reelvideo_names = "reels" . $reelvideo_name;

            
                $reelvideo = $Reel_Videos->move(public_path('uploads/reelsVideos'), $reelvideo_name);

                $videoPath = public_path("uploads/reelsVideos/{$reelvideo_name}");
                $shorts_name = 'shorts_'.$reelvideo_name; 
                $videoPath = str_replace('\\', '/', $videoPath);
                $outputPath = public_path("uploads/reelsVideos/shorts/{$shorts_name}");
                // Ensure the output directory exists
                File::ensureDirectoryExists(dirname($outputPath));
                // FFmpeg command to resize to 9:16 aspect ratio
                $command = [
                    'ffmpeg',
                    '-y', // Add this option to force overwrite
                    '-i', $videoPath,
                    '-vf', 'scale=-1:720,crop=400:720', // Adjusted crop filter values
                    '-c:a', 'copy',
                    $outputPath,
                ];

                $process = new Process($command);

                try {
                    $process->mustRun();
                    // return 'Video resized successfully!';
                } catch (ProcessFailedException $exception) {
                    // Error message
                    throw new \Exception('Error resizing video: ' . $exception->getMessage());
                }

                $Reels_videos = new ReelsVideo();
                $Reels_videos->video_id = $video->id;
                // $Reels_videos->reels_videos = $reelvideo_name;
                $Reels_videos->reels_videos = $shorts_name;
                $Reels_videos->reels_videos_slug = $reel_videos_slug;
                $Reels_videos->save();

                $video->reels_thumbnail = "default.jpg";
            }
        }else if($reels_videos != null){
            ReelsVideo::where("video_id", $video->id)->delete();

            foreach ($reels_videos as $Reel_Videos) {
                $reelvideo_name =
                    time() . rand(1, 50) . "." . $Reel_Videos->extension();
                $reel_videos_slug = substr(
                    $Reel_Videos->getClientOriginalName(),
                    0,
                    strpos($Reel_Videos->getClientOriginalName(), ".")
                );

                $reelvideo_names = "reels" . $reelvideo_name;
                $reelvideo = $Reel_Videos->move(
                    public_path("uploads/reelsVideos/shorts"),
                    $reelvideo_name
                );

                $Reels_videos = new ReelsVideo();
                $Reels_videos->video_id = $video->id;
                $Reels_videos->reels_videos = $reelvideo_name;
                // $Reels_videos->reels_videos = $shorts_name;
                $Reels_videos->reels_videos_slug = $reel_videos_slug;
                $Reels_videos->save();

                $video->reels_thumbnail = "default.jpg";
            }
        }
        // dd($reelvideo_name);
        // Reels Thumbnail
        if (!empty($request->reels_thumbnail)) {
            $Reels_thumbnail ="reels_" .time() . "." .$request->reels_thumbnail->extension();
            $request->reels_thumbnail->move(public_path("uploads/images"), $Reels_thumbnail);

            $video->reels_thumbnail = $Reels_thumbnail;
        }

        //URL Link
        $url_link = $request->url_link;

        if ($url_link != null) {
            $video->url_link = $url_link;
        }

        $url_linktym = $request->url_linktym;

        if ($url_linktym != null) {
            $StartParse = date_parse($request->url_linktym);
            $startSec =
                $StartParse["hour"] * 60 * 60 +
                $StartParse["minute"] * 60 +
                $StartParse["second"];
            $video->url_linktym = $url_linktym;
            $video->url_linksec = $startSec;
            $video->urlEnd_linksec = $startSec + 60;
        }

        if (!empty($data["default_ads"])) {
            $video->default_ads = $data["default_ads"];
        } else {
            $video->default_ads = 0;
        }

        if (!empty($data["searchtags"])) {
            $searchtags = $data["searchtags"];
        } else {
            $searchtags = $video->searchtags;
        }
        if (!empty($video->uploaded_by)) {
            $uploaded_by = $video->uploaded_by;
        } else {
            $uploaded_by = Auth::user()->role;
        }

                     // Tv video Image 

        if($request->hasFile('video_tv_image')){

            if (File::exists(base_path('public/uploads/images/'.$video_title_image))) {
                File::delete(base_path('public/uploads/images/'.$video_title_image));
            }
        
            $video_tv_image = $request->video_tv_image;

            if(compress_image_enable() == 1){

                $Tv_image_format  = time().'.'.compress_image_format();
                $Tv_image_filename     =  'tv-live-image-'.$Tv_image_format ;
                Image::make($video_tv_image)->save(base_path().'/public/uploads/images/'.$Tv_image_filename,compress_image_resolution() );

            }else{

                $Tv_image_format  = time().'.'.$video_tv_image->getClientOriginalExtension();
                $Tv_image_filename     =  'tv-live-image-'.$Tv_image_format ;
                Image::make($video_tv_image)->save(base_path().'/public/uploads/images/'.$Tv_image_filename );
            }
            $video->video_tv_image = $Tv_image_filename;
        }else if (!empty($request->selected_tv_image_url)) {
            $video->video_tv_image = $request->selected_tv_image_url;
        } 

                    // Video Title Thumbnail
        // dd($request->all());
        if($request->hasFile('video_title_image')){

            if (File::exists(base_path('public/uploads/images/'.$video_title_image))) {
                File::delete(base_path('public/uploads/images/'.$video_title_image));
            }
        
            $video_title_image = $request->video_title_image;

            if(compress_image_enable() == 1){

                $video_title_image_format   = time().'.'.compress_image_format();
                $video_title_image_filename =  'video-title-'.$video_title_image_format ;
                Image::make($video_title_image)->save(base_path().'/public/uploads/images/'.$video_title_image_filename,compress_image_resolution() );
            }else{

                $video_title_image_format  = time().'.'.$video_title_image->getClientOriginalExtension();
                $video_title_image_filename     =  'video-title-'.$video_title_image_format ;
                Image::make($video_title_image)->save(base_path().'/public/uploads/images/'.$video_title_image_filename );
            }

            $video->video_title_image = $video_title_image_filename;
        }
                // Ads videos
        if(!empty($data["ads_tag_url_id"]) == null ){
            $video->ads_tag_url_id = null;
            $video->tag_url_ads_position = null;
        }
        
        if(!empty($data["ads_tag_url_id"]) != null){
            $video->ads_tag_url_id = $data["ads_tag_url_id"];
            $video->tag_url_ads_position = $data["tag_url_ads_position"];
        }

        if (isset($request->free_duration)) {
            $time_seconds = Carbon::createFromFormat('H:i:s', $request->free_duration)->diffInSeconds(Carbon::createFromTime(0, 0, 0));
            $video->free_duration = $time_seconds;
        }

        $video->free_duration_status  = !empty($request->free_duration_status) ? 1 : 0 ;

        if ($data['access'] == "ppv") {
            $video->ppv_price = $data["ppv_price"];
        }else if($data['access'] != "ppv"){
            $data['ppv_price_480p'] = null ;
            $data['ppv_price_720p'] = null ;
            $data['ppv_price_1080p'] = null ;
            $data['ios_ppv_price_480p'] = null ;
            $data['ios_ppv_price_720p'] = null ;
            $data['ios_ppv_price_1080p'] = null ;
            $data["ppv_price"] = null;
            $video->ppv_price =  null;
        } else {
            $video->ppv_price = !empty($data["ppv_price"]) ? $data["ppv_price"] : null;
        }

        // dd($request["trailer_type"] );
        $shortcodes = $request["short_code"];
        $languages = $request["sub_language"];
        $video->mp4_url = $data["mp4_url"];
        $video->trailer = ($request["trailer_type"] == "null") ? null : $data["trailer"];
        $video->trailer_type = ($request["trailer_type"] == "null") ? null : $data["trailer_type"];
        $video->duration = $data["duration"];
        $video->language = $request["language"];
        $video->skip_recap = $request["skip_recap"];
        $video->recap_start_time = $request["recap_start_time"];
        $video->recap_end_time = $request["recap_end_time"];
        $video->skip_intro = $request["skip_intro"];
        $video->intro_start_time = $request["intro_start_time"];
        $video->intro_end_time = $request["intro_end_time"];
        $video->country = !empty(($request["video_country"])) ? json_encode($request["video_country"]) : ["All"] ;
        $video->publish_status = $request["publish_status"];
        $video->publish_type = $publish_type;
        $video->publish_time = $publish_time;
        $video->age_restrict = $data["age_restrict"];
        $video->access = $data["access"];
        //  $video->active=1;
        $video->uploaded_by = $uploaded_by;
        $video->image = $data["image"];
        $video->player_image = $players_image;
        $video->year = $year;
        $video->details = $details;
        $video->m3u8_url = $m3u8_url;
        $video->mp4_url = $mp4_url;
        $video->embed_code = $embed_code;
        $video->featured = $featured;
        $video->active = $active;
        $video->status = $status;
        $video->draft = $draft;
        $video->banner = $banner;
        $video->ppv_price = ($data['access'] == "ppv" || !empty($data["ppv_price"])) ? $data["ppv_price"] : null;
        $video->type = $data["type"];
        $video->description = $data["description"];
        $video->trailer_description = $data["trailer_description"];
        $video->banner = $banner;
        $video->enable = $enable;
        $video->rating = $request->rating;
        $video->search_tags = $searchtags;
        $video->ios_ppv_price = $request->ios_ppv_price;
        $video->video_js_pre_position_ads = $request->video_js_pre_position_ads;
        $video->video_js_post_position_ads = $request->video_js_pre_position_ads;
        $video->video_js_mid_position_ads_category = $request->video_js_mid_position_ads_category;
        $video->video_js_mid_advertisement_sequence_time = $request->video_js_mid_advertisement_sequence_time;
        $video->expiry_date = $request->expiry_date;
        $video->today_top_video = $request->today_top_video;
        $video->tiny_video_image = $tiny_video_image;
        $video->tiny_player_image = $tiny_player_image;
        $video->tiny_video_title_image = $tiny_video_title_image;
        $video->responsive_image = $responsive_image;
        $video->responsive_player_image = $responsive_player_image;
        $video->responsive_tv_image = $responsive_tv_image;
        $video->ppv_option = $request->ppv_option;
        // $video->ppv_price_240p = $data['ppv_price_240p'];
        // $video->ppv_price_360p = $data['ppv_price_360p'];
        $video->ppv_price_480p = $data['ppv_price_480p'];
        $video->ppv_price_720p = $data['ppv_price_720p'];
        $video->ppv_price_1080p = $data['ppv_price_1080p'];
        // $video->ios_ppv_price_240p = $data['ios_ppv_price_240p'];
        // $video->ios_ppv_price_360p = $data['ios_ppv_price_360p'];
        $video->ios_ppv_price_480p = $data['ios_ppv_price_480p'];
        $video->ios_ppv_price_720p = $data['ios_ppv_price_720p'];
        $video->ios_ppv_price_1080p = $data['ios_ppv_price_1080p'];
        $video->video_id_480p = ( !empty($data["video_id_480p"])) ? $data["video_id_480p"] : null;
        $video->video_id_720p = (!empty($data["video_id_720p"])) ? $data["video_id_720p"] : null;
        $video->video_id_1080p =( !empty($data["video_id_1080p"])) ? $data["video_id_1080p"] : null;

        $video->save();

        if (
            $trailer != "" &&
            $pack == "Business" &&
            $settings->transcoding_access == 1 && $StorageSetting->site_storage == 1
        ) {
            ConvertVideoTrailer::dispatch(
                $video,
                $storepath,
                $convertresolution,
                $trailer_video_name,
                $trailer_Video
            );
        }

        // Related Video
        if (!empty($data["related_videos"])) {
            RelatedVideo::where("video_id", $video->id)->delete();

            $related_videos = $data["related_videos"];

            if (!empty($related_videos)) {
                foreach ($related_videos as $key => $vid) {
                    // RelatedVideo::where('video_id', $video->id)->delete();
                    $videos = Video::where("id", $vid)->get();
                    foreach ($videos as $key => $val) {
                        $RelatedVideo = new RelatedVideo();
                        $RelatedVideo->video_id = $video->id;
                        $RelatedVideo->user_id = Auth::user()->id;
                        $RelatedVideo->related_videos_id = $val->id;
                        $RelatedVideo->related_videos_title = $val->title;
                        $RelatedVideo->save();
                    }
                }
            }
        }

        if (!empty($data["artists"])) {
            $artistsdata = $data["artists"];
            unset($data["artists"]);
            if (!empty($artistsdata)) {
                Videoartist::where("video_id", $video->id)->delete();

                foreach ($artistsdata as $key => $value) {
                    $artist = new Videoartist();
                    $artist->video_id = $video->id;
                    $artist->artist_id = $value;
                    $artist->save();
                    \LogActivity::addVideoArtistLog(
                        "Updated Artist for Video.",
                        $video->id,
                        $value
                    );
                }
            }
        } else {
            Videoartist::where("video_id", $video->id)->delete();
        }

        if (!empty($data["searchtags"])) {
            $searchtags = explode(",", $data["searchtags"]);
            VideoSearchTag::where("video_id", $video->id)->delete();

            foreach ($searchtags as $key => $value) {
                $videosearchtags = new VideoSearchTag();
                $videosearchtags->user_id = Auth::User()->id;
                $videosearchtags->video_id = $video->id;
                $videosearchtags->search_tag = $value;
                $videosearchtags->save();
            }
        } else {
            // $searchtags = null;
        }

        // Category Video

        if (!empty($data["video_category_id"])) {
            $category_id = $data["video_category_id"];
            // unset($data['video_category_id']);
            if (!empty($category_id)) {
                CategoryVideo::where("video_id", $video->id)->delete();
                foreach ($category_id as $key => $value) {
                    $category = new CategoryVideo();
                    $category->video_id = $video->id;
                    $category->category_id = $value;
                    $category->save();

                    \LogActivity::addVideoCategoryLog(
                        "Updated Category for Video.",
                        $video->id,
                        $value
                    );
                }
            }
        } else {
            CategoryVideo::where("video_id", $video->id)->delete();

            $other_category = VideoCategory::where(
                "slug",
                "other_category"
            )->first();

            if ($other_category == null) {
                VideoCategory::create([
                    "user_id" => null,
                    "parent_id" => null,
                    "order" => "1",
                    "name" => "Other category",
                    "image" => "default.jpg",
                    "slug" => "other_category",
                    "in_home" => "1",
                    "footer" => null,
                    "banner" => "0",
                    "in_menu" => null,
                    "banner_image" => "default.jpg",
                ]);
            }

            $other_category_id = VideoCategory::where("slug", "other_category")
                ->pluck("id")
                ->first();

            $category = new CategoryVideo();
            $category->video_id = $video->id;
            $category->category_id = $other_category_id;
            $category->save();
        }

        // language
        if (!empty($data["language"])) {
            $language_id = $data["language"];
            unset($data["language"]);

            if (!empty($language_id)) {
                LanguageVideo::where("video_id", $video->id)->delete();

                foreach ($language_id as $key => $value) {
                    $languagevideo = new LanguageVideo();
                    $languagevideo->video_id = $video->id;
                    $languagevideo->language_id = $value;
                    $languagevideo->save();

                    \LogActivity::addVideoLanguageLog(
                        "Updated Language for Video.",
                        $video->id,
                        $value
                    );
                }
            }
        }

        // playlist
        if (empty($data["playlist"])) {

            VideoPlaylist::where("video_id", $video->id)->delete();

        }else if (!empty($data["playlist"])) {
            $playlist_id = $data["playlist"];
            unset($data["playlist"]);
            // dd($playlist_id);

            if (!empty($playlist_id)) {
                VideoPlaylist::where("video_id", $video->id)->delete();

                foreach ($playlist_id as $key => $value) {
                    $VideoPlaylist = new VideoPlaylist();
                    $VideoPlaylist->user_id = Auth::user()->id;
                    $VideoPlaylist->video_id = $video->id;
                    $VideoPlaylist->playlist_id = $value;
                    $VideoPlaylist->save();
                }
            }
        }
        // Block country
        if (!empty($data["country"])) {
            $country = $data["country"];

            if (!empty($country)) {
                BlockVideo::where("video_id", $video->id)->delete();

                foreach ($country as $key => $value) {
                    $country = new BlockVideo();
                    $country->video_id = $video->id;
                    $country->country_id = $value;
                    $country->save();
                }
            }
        }else{
            BlockVideo::where("video_id", $video->id)->delete();
        }

        // if (!empty($files != "" && $files != null)) {
        //     foreach ($files as $key => $val) {
        //         if (!empty($files[$key])) {
        //             $destinationPath = "public/uploads/subtitles/";
        //             $filename = $video->id . "-" . $shortcodes[$key] . ".srt";
        //             $files[$key]->move($destinationPath, $filename);
        //             $subtitle_data["sub_language"] =
        //                 $languages[
        //                     $key
        //                 ]; /*URL::to('/').$destinationPath.$filename; */
        //             $subtitle_data["shortcode"] = $shortcodes[$key];
        //             $subtitle_data["movie_id"] = $id;
        //             $subtitle_data["url"] =
        //                 URL::to("/") . "/public/uploads/subtitles/" . $filename;
        //             $video_subtitle = new MoviesSubtitles();
        //             $video_subtitle->movie_id = $video->id;
        //             $video_subtitle->shortcode = $shortcodes[$key];
        //             $video_subtitle->sub_language = $languages[$key];
        //             $video_subtitle->url =
        //                 URL::to("/") . "/public/uploads/subtitles/" . $filename;
        //             $video_subtitle->save();
        //         }
        //     }
        // }
            // // Define the convertTimeFormat function globally
            // function convertTimeFormat($hours, $minutes, $milliseconds) {
            //     $totalSeconds = $hours * 3600 + $minutes * 60 + $milliseconds / 1000;
            //     $formattedTime = gmdate("H:i:s", $totalSeconds);
            //     $formattedMilliseconds = str_pad($milliseconds, 3, '0', STR_PAD_LEFT);
            //     return "{$formattedTime},{$formattedMilliseconds}";
            // }

            // if (!empty($files != "" && $files != null)) {
            //     foreach ($files as $key => $val) {
            //         if (!empty($files[$key])) {
            //             $destinationPath = "public/uploads/subtitles/";

            //             if (!file_exists($destinationPath)) {
            //                 mkdir($destinationPath, 0755, true);
            //             }

            //             $filename = $video->id . "-" . $shortcodes[$key] . ".srt";

            //             MoviesSubtitles::where('movie_id', $video->id)->where('shortcode', $shortcodes[$key])->delete();

            //             // Move uploaded file to destination path
            //             move_uploaded_file($val->getPathname(), $destinationPath . $filename);

            //             // Read contents of the uploaded file
            //             $contents = file_get_contents($destinationPath . $filename);

            //             // Convert time format and add line numbers
            //             $lineNumber = 0;
            //             $convertedContents = preg_replace_callback(
            //                 '/(\d{2}):(\d{2})\.(\d{3}) --> (\d{2}):(\d{2})\.(\d{3})/',
            //                 function ($matches) use (&$lineNumber) {
            //                     // Increment line number for each match
            //                     $lineNumber++;
            //                     // Convert time format and return with the line number
            //                     return "{$lineNumber}\n" . convertTimeFormat($matches[1], $matches[2], $matches[3]) . " --> " . convertTimeFormat($matches[4], $matches[5], $matches[6]);
            //                 },
            //                 $contents
            //             );

            //             // Store converted contents to a new file
            //             $newDestinationPath = "public/uploads/convertedsubtitles/";
            //             if (!file_exists($newDestinationPath)) {
            //                 mkdir($newDestinationPath, 0755, true);
            //             }
            //             file_put_contents($newDestinationPath . $filename, $convertedContents);

            //             // Save subtitle data to database
            //             $subtitle_data = [
            //                 "movie_id" => $video->id,
            //                 "shortcode" => $shortcodes[$key],
            //                 "sub_language" => $languages[$key],
            //                 "url" => URL::to("/") . "/public/uploads/subtitles/" . $filename,
            //                 "Converted_Url" => URL::to("/") . "/public/uploads/convertedsubtitles/" . $filename
            //             ];
            //             $video_subtitle = MoviesSubtitles::create($subtitle_data);
            //         }
            //     }
            // }

            function convertTimeFormat($hours, $minutes, $seconds, $milliseconds) {
                $totalSeconds = $hours * 3600 + $minutes * 60 + $seconds + $milliseconds / 1000;
                $formattedTime = gmdate("H:i:s", $totalSeconds);
                $formattedMilliseconds = str_pad($milliseconds, 3, '0', STR_PAD_LEFT);
                return "{$formattedTime},{$formattedMilliseconds}";
            }
            
            if (!empty($files != "" && $files != null)) {
                foreach ($files as $key => $val) {
                    if (!empty($files[$key])) {
                        $destinationPath = "public/uploads/subtitles/";
            
                        if (!file_exists($destinationPath)) {
                            mkdir($destinationPath, 0755, true);
                        }
            
                        $filename = $video->id . "-" . $shortcodes[$key] . ".srt";
            
                        MoviesSubtitles::where('movie_id', $video->id)->where('shortcode', $shortcodes[$key])->delete();
            
                        // Move uploaded file to destination path
                        move_uploaded_file($val->getPathname(), $destinationPath . $filename);
            
                        // Read contents of the uploaded file
                        $contents = file_get_contents($destinationPath . $filename);
            
                        // Convert time format and add line numbers
                        $lineNumber = 0;
                        $convertedContents = preg_replace_callback(
                            '/(\d{2}):(\d{2}).(\d{3}) --> (\d{2}):(\d{2}).(\d{3})/',
                            function ($matches) use (&$lineNumber) {
                                // Increment line number for each match
                                $lineNumber++;
                                // Convert time format and return with the line number
                                return "{$lineNumber}\n" . convertTimeFormat(0, $matches[1], $matches[2], $matches[3]) . " --> " . convertTimeFormat(0, $matches[4], $matches[5], $matches[6]);
                            },
                            $contents
                        );
            
                        // Store converted contents to a new file
                        $newDestinationPath = "public/uploads/convertedsubtitles/";
                        if (!file_exists($newDestinationPath)) {
                            mkdir($newDestinationPath, 0755, true);
                        }
                        file_put_contents($newDestinationPath . $filename, $convertedContents);
            
                        // Save subtitle data to database
                        $subtitle_data = [
                            "movie_id" => $video->id,
                            "shortcode" => $shortcodes[$key],
                            "sub_language" => $languages[$key],
                            "url" => URL::to("/") . "/public/uploads/subtitles/" . $filename,
                            "Converted_Url" => URL::to("/") . "/public/uploads/convertedsubtitles/" . $filename
                        ];
                        $video_subtitle = MoviesSubtitles::create($subtitle_data);
                    }
                }
            }

            // Admin Video Ads inputs

        if( !empty($request->ads_devices)){

            $Admin_Video_Ads_inputs = array(

                'video_id' => $video->id ,
                'website_vj_pre_postion_ads'   =>  in_array("website", $request->ads_devices) ?  $request->website_vj_pre_postion_ads : null ,
                'website_vj_mid_ads_category'  =>  in_array("website", $request->ads_devices) ? $request->website_vj_mid_ads_category : null ,
                'website_vj_post_position_ads' =>  in_array("website", $request->ads_devices) ? $request->website_vj_post_position_ads : null,
                'website_vj_pre_postion_ads'   =>  in_array("website", $request->ads_devices) ? $request->website_vj_pre_postion_ads : null,

                'andriod_vj_pre_postion_ads'   => in_array("android", $request->ads_devices) ? $request->andriod_vj_pre_postion_ads : null,
                'andriod_vj_mid_ads_category'  => in_array("android", $request->ads_devices) ? $request->andriod_vj_mid_ads_category : null,
                'andriod_vj_post_position_ads' => in_array("android", $request->ads_devices) ? $request->andriod_vj_post_position_ads : null,
                'andriod_mid_sequence_time'    => in_array("android", $request->ads_devices) ? $request->andriod_mid_sequence_time : null,

                'ios_vj_pre_postion_ads'   => in_array("IOS", $request->ads_devices) ? $request->ios_vj_pre_postion_ads : null,
                'ios_vj_mid_ads_category'  => in_array("IOS", $request->ads_devices) ? $request->ios_vj_mid_ads_category : null,
                'ios_vj_post_position_ads'  => in_array("IOS", $request->ads_devices) ? $request->ios_vj_post_position_ads : null,
                'ios_mid_sequence_time'    => in_array("IOS", $request->ads_devices) ? $request->ios_mid_sequence_time : null,

                'tv_vj_pre_postion_ads'   => in_array("TV", $request->ads_devices) ? $request->tv_vj_pre_postion_ads : null,
                'tv_vj_mid_ads_category'  => in_array("TV", $request->ads_devices) ? $request->tv_vj_mid_ads_category : null,
                'tv_vj_post_position_ads' => in_array("TV", $request->ads_devices) ? $request->tv_vj_post_position_ads : null,
                'tv_mid_sequence_time'    => in_array("TV", $request->ads_devices) ? $request->tv_mid_sequence_time : null,

                'roku_vj_pre_postion_ads'   => in_array("roku", $request->ads_devices) ? $request->roku_vj_pre_postion_ads : null,
                'roku_vj_mid_ads_category'  => in_array("roku", $request->ads_devices) ? $request->roku_vj_mid_ads_category : null,
                'roku_vj_post_position_ads' => in_array("roku", $request->ads_devices) ? $request->roku_vj_post_position_ads : null,
                'roku_mid_sequence_time'    => in_array("roku", $request->ads_devices) ? $request->roku_mid_sequence_time : null,

                'lg_vj_pre_postion_ads'   => in_array("lg", $request->ads_devices) ? $request->lg_vj_pre_postion_ads : null,
                'lg_vj_mid_ads_category'  => in_array("lg", $request->ads_devices) ? $request->lg_vj_mid_ads_category : null,
                'lg_vj_post_position_ads' => in_array("lg", $request->ads_devices) ? $request->lg_vj_post_position_ads : null,
                'lg_mid_sequence_time'    => in_array("lg", $request->ads_devices) ? $request->lg_mid_sequence_time : null,

                'samsung_vj_pre_postion_ads'   => in_array("samsung", $request->ads_devices) ?$request->samsung_vj_pre_postion_ads : null,
                'samsung_vj_mid_ads_category'  => in_array("samsung", $request->ads_devices) ?$request->samsung_vj_mid_ads_category : null,
                'samsung_vj_post_position_ads' => in_array("samsung", $request->ads_devices) ?$request->samsung_vj_post_position_ads : null,
                'samsung_mid_sequence_time'    => in_array("samsung", $request->ads_devices) ?$request->samsung_mid_sequence_time : null,

                // plyr.io

                'website_plyr_tag_url_ads_position' => $request->website_plyr_tag_url_ads_position,
                'website_plyr_ads_tag_url_id'       => $request->website_plyr_ads_tag_url_id,
                
                'andriod_plyr_tag_url_ads_position' => $request->andriod_plyr_tag_url_ads_position,
                'andriod_plyr_ads_tag_url_id'       => $request->andriod_plyr_ads_tag_url_id,

                'ios_plyr_tag_url_ads_position' => $request->ios_plyr_tag_url_ads_position,
                'ios_plyr_ads_tag_url_id'       => $request->ios_plyr_ads_tag_url_id,

                'tv_plyr_tag_url_ads_position' => $request->tv_plyr_tag_url_ads_position,
                'tv_plyr_ads_tag_url_id'       => $request->tv_plyr_ads_tag_url_id,

                'roku_plyr_tag_url_ads_position' => $request->roku_plyr_tag_url_ads_position,
                'roku_plyr_ads_tag_url_id'       => $request->roku_plyr_ads_tag_url_id,

                'lg_plyr_tag_url_ads_position' => $request->lg_plyr_tag_url_ads_position,
                'lg_plyr_ads_tag_url_id'       => $request->lg_plyr_ads_tag_url_id,
                
                'samsung_plyr_tag_url_ads_position' => $request->samsung_plyr_tag_url_ads_position,
                'samsung_plyr_ads_tag_url_id'       => $request->samsung_plyr_ads_tag_url_id,

                'ads_devices' => !empty($request->ads_devices) ? json_encode($request->ads_devices) : null,
            );

            $AdminVideoAds = AdminVideoAds::where('video_id', $video->id )->first();


            is_null($AdminVideoAds) ? AdminVideoAds::create( $Admin_Video_Ads_inputs ) : AdminVideoAds::where('video_id',$video->id)->update( $Admin_Video_Ads_inputs) ;
           
        }else{

            AdminVideoAds::where('video_id',$video->id)->delete();
        }

        \LogActivity::addVideoUpdateLog("Update Video.", $video->id);

        return Redirect::to("admin/videos/edit" . "/" . $id)->with([
            "message" => "Successfully Updated Video!",
            "note_type" => "success",
        ]);
    }

    private function getCleanFileName($filename)
    {
        return preg_replace('/\\.[^.\\s]{3,4}$/', "", $filename) . ".mp4";
    }

    /* slug function for Video categoty */

    public function createSlug($title, $id = 0)
    {
        $slug = Str::slug($title);

        $allSlugs = $this->getRelatedSlugs($slug, $id);

        // If we haven't used it before then we are all good.
        if (!$allSlugs->contains("slug", $slug)) {
            return $slug;
        }

        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 10; $i++) {
            $newSlug = $slug . "-" . $i;
            if (!$allSlugs->contains("slug", $newSlug)) {
                return $newSlug;
            }
        }

        throw new \Exception("Can not create a unique slug");
    }

    protected function getRelatedSlugs($slug, $id = 0)
    {
        return Video::select("slug")
            ->where("slug", "like", $slug . "%")
            ->where("id", "<>", $id)
            ->get();
    }

    public function build_video_thumbnail($video_path, $movie, $thumb_path)
    {
        // Create a temp directory for building.
        $temp = storage_path("app/public") . "/build";
        if (!file_exists($temp)) {
            File::makeDirectory($temp);
        }

        // Use FFProbe to get the duration of the video.
        $ffprobe = \FFMpeg\FFProbe::create();
        $duration = $ffprobe
            ->streams($video_path)
            ->videos()
            ->first()
            ->get("duration");
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
            $video = FFMpeg::fromDisk("public")->open($movie);

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
                $img = Image::make($point_file)->resize(150, 150, function (
                    $constraint
                ) {
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
            file_put_contents(
                storage_path("app/public") . "/" . $thumb_path . ".gif",
                $gc->getGif()
            );

            // Remove all the temporary frames.
            foreach ($frames as $file) {
                unlink($file);
            }
        }
    }

    public function fileupdate(Request $request)
    {
        if (!Auth::user()->role == 'admin') {
            return redirect('/home');
        }

    
        $user_package = User::where('id', 1)->first();
        $data = $request->all();
        // dd($data);
        $validatedData = $request->validate([
            'title' => 'required|max:255',
        ]);
        
        $id = $data['video_id'];
        $video = Video::findOrFail($id);
        Video::query()->where('id','!=', $id)->update(['today_top_video' => 0]);

        if (!empty($video->embed_code)) {
            $embed_code = $video->embed_code;
        } else {
            $embed_code = '';
        }

        if (!empty($data['ppv_price']) && $data['ppv_price'] > 0) {
            $video->global_ppv = 1;
        } else {
            $video->global_ppv = null;
        }

        $settings = Setting::where('ppv_status', '=', 1)->first();

        // if (!empty($data['global_ppv'])) {
        //     $data['ppv_price'] = $settings->ppv_price;
        //     $video->global_ppv = $data['global_ppv'];
        // } else {
        //     $video->global_ppv = null;
        // }

        if($request->ppv_price == null && empty($data["global_ppv"]) ){
            $video->global_ppv = null;
            $data["ppv_price"] = null;
        }else if(empty($data["global_ppv"]) ){
            $video->global_ppv = null;
            $data["ppv_price"] = null;
        }else{

            if (!empty($data["global_ppv"]) && !empty($data["set_gobal_ppv_price"]) && $request->ppv_option == 1) {
                $video->global_ppv = $data["global_ppv"];
                $data["ppv_price"] = $data["set_gobal_ppv_price"];
            } else if(!empty($data["global_ppv"])  && $request->ppv_option == 2) {
                $video->global_ppv = $data["global_ppv"];
                $data["ppv_price"] = $settings->ppv_price;
            } else if(!empty($data["global_ppv"])  && !empty($data["set_gobal_ppv_price"])) {
                $video->global_ppv = $data["global_ppv"];
                $data["ppv_price"] = $data["set_gobal_ppv_price"];
            }  else if(!empty($data["global_ppv"])) {
                $video->global_ppv = $data["global_ppv"];
                $data["ppv_price"] = $settings->ppv_price;
            }else if(empty($data["global_ppv"]) && !empty($data["ppv_price"])  && $request->ppv_price != null) {
                $data["ppv_price"] = $request->ppv_price;
                $video->global_ppv = null;
            } else {
                $video->global_ppv = null;
                $data["ppv_price"] = null;
            }
        }

        if ($request->slug == '') {
            $data['slug'] = $this->createSlug($data['title']);
        } else {
            $data['slug'] = $this->createSlug($data['slug']);
        }

        $video->free_duration_status  = !empty($request->free_duration_status) ? 1 : 0 ;

        if (isset($request->free_duration)) {
            $time_seconds = Carbon::createFromFormat('H:i:s', $request->free_duration)->diffInSeconds(Carbon::createFromTime(0, 0, 0));
            $video->free_duration = $time_seconds;
        }

        $trailer = isset($data['trailer']) ? $data['trailer'] : '';
        $files = isset($data['subtitle_upload']) ? $data['subtitle_upload'] : '';
        $image_path = public_path() . '/uploads/images/';

        // Image
        if ($request->hasFile('image')) {
                $tinyimage = $request->file('image');
            if (compress_image_enable() == 1) {
                $image_filename = time() . '.' . compress_image_format();
                $tiny_video_image = 'tiny-image-' . $image_filename;
                Image::make($tinyimage)->resize(450,320)->save(base_path() . '/public/uploads/images/' . $tiny_video_image, compress_image_resolution());
            } else {
                $image_filename = time() . '.' . $tinyimage->getClientOriginalExtension();
                $tiny_video_image = 'tiny-image-' . $image_filename;
                Image::make($tinyimage)->resize(450,320)->save(base_path() . '/public/uploads/images/' . $tiny_video_image, compress_image_resolution());

            }
        }else{
            $tiny_video_image = null;

        }
        if ($request->hasFile('player_image')) {

            $tinyplayer_image = $request->file('player_image');

            if (compress_image_enable() == 1) {
                $player_image_filename = time() . '.' . compress_image_format();
                $tiny_player_image = 'tiny-player_image-' . $image_filename;
                Image::make($tinyplayer_image)->resize(450,320)->save(base_path() . '/public/uploads/images/' . $tiny_player_image, compress_image_resolution());
            } else {
                $image_filename = time() . '.' . $tinyplayer_image->getClientOriginalExtension();
                $tiny_player_image = 'tiny-player_image-' . $image_filename;
                Image::make($tinyplayer_image)->resize(450,320)->save(base_path() . '/public/uploads/images/' . $tiny_player_image, compress_image_resolution());

            }
        }else{
            $tiny_player_image = null;

        }
        if ($request->hasFile('video_title_image')) {

            $tinyvideo_title_image = $request->file('video_title_image');

            if (compress_image_enable() == 1) {
                $image_filename = time() . '.' . compress_image_format();
                $tiny_video_title_image = 'tiny-video_title_image-' . $image_filename;
                Image::make($tinyvideo_title_image)->resize(450,320)->save(base_path() . '/public/uploads/images/' . $tiny_video_title_image, compress_image_resolution());
            } else {
                $image_filename = time() . '.' . $tinyvideo_title_image->getClientOriginalExtension();
                $tiny_video_title_image = 'tiny-video_title_image-' . $image_filename;
                Image::make($tinyvideo_title_image)->resize(450,320)->save(base_path() . '/public/uploads/images/' . $tiny_video_title_image, compress_image_resolution());

            }
        }else{
            $tiny_video_title_image = null;

        }

        $data["tiny_video_image"] = $tiny_video_image;
        $data["tiny_player_image"] = $tiny_player_image;
        $data["tiny_video_title_image"] = $tiny_video_title_image;

        if ($request->hasFile('image')) {
            $file = $request->image;
            if (compress_image_enable() == 1) {
                $image_filename = time() . '.' . compress_image_format();
                $video_image = 'pc-image-' . $image_filename;
                $Mobile_image = 'Mobile-image-' . $image_filename;
                $Tablet_image = 'Tablet-image-' . $image_filename;

                Image::make($file)->save(base_path() . '/public/uploads/images/' . $video_image, compress_image_resolution());
                Image::make($file)->save(base_path() . '/public/uploads/images/' . $Mobile_image, compress_image_resolution());
                Image::make($file)->save(base_path() . '/public/uploads/images/' . $Tablet_image, compress_image_resolution());
            } else {
                $image_filename = time() . '.' . $file->getClientOriginalExtension();

                $video_image = 'pc-image-' . $image_filename;
                $Mobile_image = 'Mobile-image-' . $image_filename;
                $Tablet_image = 'Tablet-image-' . $image_filename;

                Image::make($file)->save(base_path() . '/public/uploads/images/' . $video_image);
                Image::make($file)->save(base_path() . '/public/uploads/images/' . $Mobile_image);
                Image::make($file)->save(base_path() . '/public/uploads/images/' . $Tablet_image);
            }

            $data["image"] = $video_image;
            $data["mobile_image"] = $Mobile_image;
            $data["tablet_image"] = $Tablet_image;

        }else if (!empty($request->video_image_url)) {
            $data["image"] = $request->video_image_url;
        } else {
            // Default Image

            $data["image"]  = default_vertical_image() ;
            $data["mobile_image"] = default_vertical_image();
            $data["tablet_image"] = default_vertical_image();

        }

        // Player Image
        // $request->selected_image_url = '';
        if ($request->hasFile('player_image')) {
            $player_image = $request->player_image;

            if (compress_image_enable() == 1) {
                $player_filename = time() . '.' . compress_image_format();
                $players_image = 'player-image-' . $player_filename;
                Image::make($player_image)->save(base_path() . '/public/uploads/images/' . $players_image, compress_image_resolution());
            } else {
                $player_filename = time() . '.' . $player_image->getClientOriginalExtension();
                $players_image = 'player-image-' . $player_filename;
                Image::make($player_image)->save(base_path() . '/public/uploads/images/' . $players_image);
            }

            $data["player_image"] = $players_image;

        }else if (!empty($request->selected_image_url)) {
            $data["player_image"] = $request->selected_image_url;
        } else {
            $data["player_image"] = default_horizontal_image();
        }
        // dd($data["player_image"]);
        // Tv video Image

        if ($request->hasFile('video_tv_image')) {
            $video_tv_image = $request->video_tv_image;

            if (compress_image_enable() == 1) {
                $Tv_image_format = time() . '.' . compress_image_format();
                $Tv_image_filename = 'tv-live-image-' . $Tv_image_format;
                Image::make($video_tv_image)->save(base_path() . '/public/uploads/images/' . $Tv_image_filename, compress_image_resolution());
            } else {
                $Tv_image_format = time() . '.' . $video_tv_image->getClientOriginalExtension();
                $Tv_image_filename = 'tv-live-image-' . $Tv_image_format;
                Image::make($video_tv_image)->save(base_path() . '/public/uploads/images/' . $Tv_image_filename);
            }

            $data["video_tv_image"] = $Tv_image_filename;

        }else if (!empty($request->selected_tv_image_url)) {
            $data["video_tv_image"] = $request->selected_tv_image_url;
        } else {
            $data["video_tv_image"] = default_horizontal_image();
        }

        // Video Title Thumbnail

        if ($request->hasFile('video_title_image')) {
            $video_title_image = $request->video_title_image;

            if (compress_image_enable() == 1) {
                $video_title_image_format = time() . '.' . compress_image_format();
                $video_title_image_filename = 'video-title-' . $video_title_image_format;
                Image::make($video_title_image)->save(base_path() . '/public/uploads/images/' . $video_title_image_filename, compress_image_resolution());
            } else {
                $video_title_image_format = time() . '.' . $video_title_image->getClientOriginalExtension();
                $video_title_image_filename = 'video-title-' . $video_title_image_format;
                Image::make($video_title_image)->save(base_path() . '/public/uploads/images/' . $video_title_image_filename);
            }

            $video->video_title_image = $video_title_image_filename;
        }

        if (empty($data['active'])) {
            $data['active'] = 0;
        }

        if (empty($data['webm_url'])) {
            $data['webm_url'] = 0;
        } else {
            $data['webm_url'] = $data['webm_url'];
        }

        if (empty($data['ogg_url'])) {
            $data['ogg_url'] = 0;
        } else {
            $data['ogg_url'] = $data['ogg_url'];
        }

        if (empty($data['year'])) {
            $data['year'] = 0;
        } else {
            $data['year'] = $data['year'];
        }
        if (empty($data['searchtags'])) {
            $searchtags = null;
        } else {
            $searchtags = $data['searchtags'];
        }

        if (empty($data['language'])) {
            $data['language'] = 0;
        } else {
            $data['language'] = $data['language'];
        }

        if (empty($data['featured'])) {
            $featured = 0;
        } else {
            $featured = 1;
        }

        if (empty($data['featured'])) {
            $data['featured'] = 0;
        }

        if (!empty($data['embed_code'])) {
            $data['embed_code'] = $data['embed_code'];
        }

        if (empty($data['active'])) {
            $data['active'] = 0;
        }

        if (empty($data['video_gif'])) {
            $data['video_gif'] = '';
        }

        if (empty($data['status'])) {
            $data['status'] = 0;
        }

        $package = User::where('id', 1)->first();
        $pack = $package->package;

        if (Auth::user()->role == 'admin') {
            $data['status'] = 1;
        }
        $settings = Setting::first();

        if (Auth::user()->role == 'admin' && $pack != 'Business') {
            $data['status'] = 1;
        } elseif (Auth::user()->role == 'admin' && $pack == 'Business' && $settings->transcoding_access == 1 && $video->type != "embed"  && $video->type != "mp4_url" && $video->type != "m3u8_url"  ) {
            if ($video->processed_low < 100) {
                $data['status'] = 0;
            } else {
                $data['status'] = 1;
            }
        } elseif (Auth::user()->role == 'admin' && $pack == 'Business' && $settings->transcoding_access == 0) {
            $data['status'] = 1;
        } else {
            $data['status'] = 1;
        }

        if (Auth::user()->role == 'admin' && Auth::user()->sub_admin == 1) {
            $data['status'] = 0;
        }

        if (!empty($data['Recommendation'])) {
            $video->Recommendation = $data['Recommendation'];
        }
        if (empty($data['publish_type'])) {
            $publish_type = 0;
        } else {
            $publish_type = $data['publish_type'];
        }

        if (empty($data['publish_time'])) {
            $publish_time = 0;
        } else {
            $publish_time = $data['publish_time'];
        }

        $path = public_path() . '/uploads/videos/';
        $image_path = public_path() . '/uploads/images/';

        // Enable Video Title Thumbnail

        $video->enable_video_title_image = $request->enable_video_title_image ? '1' : '0';

        $video->trailer_type = $data['trailer_type'];
        $StorageSetting = StorageSetting::first();
        // dd($StorageSetting);
        if ($StorageSetting->site_storage == 1) {
            if ($data['trailer_type'] == 'video_mp4') {
                $settings = Setting::first();

                if ($trailer != '' && $pack == 'Business' && $settings->transcoding_access == 1 && $data['trailer_type'] == 'video_mp4') {
                    $settings = Setting::first();
                    // $resolution = explode(",",$settings->transcoding_resolution);
                    if ($settings->transcoding_resolution != null) {
                        $convertresolution = [];
                        $resolution = explode(',', $settings->transcoding_resolution);

                        foreach ($resolution as $value) {
                            if ($value == '240p') {
                                $r_240p = (new Representation())->setKiloBitrate(150)->setResize(426, 240);
                                array_push($convertresolution, $r_240p);
                            }
                            if ($value == '360p') {
                                $r_360p = (new Representation())->setKiloBitrate(276)->setResize(640, 360);
                                array_push($convertresolution, $r_360p);
                            }
                            if ($value == '480p') {
                                $r_480p = (new Representation())->setKiloBitrate(750)->setResize(854, 480);
                                array_push($convertresolution, $r_480p);
                            }
                            if ($value == '720p') {
                                $r_720p = (new Representation())->setKiloBitrate(2048)->setResize(1280, 720);
                                array_push($convertresolution, $r_720p);
                            }
                            if ($value == '1080p') {
                                $r_1080p = (new Representation())->setKiloBitrate(4096)->setResize(1920, 1080);
                                array_push($convertresolution, $r_1080p);
                            }
                        }
                    }
                    $trailer = $data['trailer'];
                    $trailer_path = URL::to('storage/app/trailer/');
                    $trailer_Videoname = Str::lower($trailer->getClientOriginalName());
                    $trailer_Video = time() . '_' . str_replace(' ', '_', $trailer_Videoname);

                    // $trailer_Video =
                    //     time() . "_" . $trailer->getClientOriginalName();
                    $trailer->move(storage_path('app/trailer/'), $trailer_Video);
                    $trailer_video_name = strtok($trailer_Video, '.');
                    $M3u8_save_path = $trailer_path . '/' . $trailer_video_name . '.m3u8';
                    $storepath = URL::to('storage/app/trailer/');

                    $data['trailer'] = $M3u8_save_path;
                    $data['trailer_type'] = 'm3u8';
                } else {
                    if ($trailer != '') {
                        //code for remove old file
                        if ($trailer != '' && $trailer != null) {
                            $file_old = $path . $trailer;
                            if (file_exists($file_old)) {
                                unlink($file_old);
                            }
                        }
                        //upload new file
                        $randval = Str::random(16);
                        $file = $trailer;
                        $trailer_vid = $randval . '.' . $request->file('trailer')->extension();
                        $file->move($path, $trailer_vid);
                        $data['trailer'] = URL::to('/') . '/public/uploads/videos/' . $trailer_vid;
                    } else {
                        $data['trailer'] = $video->trailer;
                    }
                }
            } elseif ($data['trailer_type'] == 'm3u8_url') {
                $data['trailer'] = $data['m3u8_trailer'];
            } elseif ($data['trailer_type'] == 'mp4_url') {
                $data['trailer'] = $data['mp4_trailer'];
            } elseif ($data['trailer_type'] == 'embed_url') {
                $data['trailer'] = $data['embed_trailer'];
            }
        } elseif ($StorageSetting->aws_storage == 1 && !empty($data['trailer'])) {
            if ($trailer != '' && $pack == 'Business' && $settings->transcoding_access == 1 && $data['trailer_type'] == 'video_mp4') {
                $file = $request->file('trailer');
                $file_folder_name = $file->getClientOriginalName();
                $name_mp4 = $file->getClientOriginalName();
                $newfile = explode('.mp4', $name_mp4);
                // $name = $newfile[0].'.m3u8';
                $name = $namem3u8 == null ? str_replace(' ', '_', 'S3' . $namem3u8) : str_replace(' ', '_', 'S3' . $namem3u8);
                $filePath = $StorageSetting->aws_video_trailer_path . '/' . $name;
                $transcode_path = @$StorageSetting->aws_transcode_path . '/' . $name;
                Storage::disk('s3')->put($transcode_path, file_get_contents($file));
                $path = 'https://' . env('AWS_BUCKET') . '.s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com';
                $M3u8_path = $path . $filePath;
                $M3u8_save_path = $path . $transcode_path;

                $data['trailer'] = $M3u8_save_path;
                $video->trailer_type = 'm3u8';
                $data['trailer_type'] = 'm3u8';
            } else {
                $file = $request->file('trailer');
                $file_folder_name = $file->getClientOriginalName();
                $name = time() . $file->getClientOriginalName();
                $filePath = $StorageSetting->aws_video_trailer_path . '/' . $name;
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                $path = 'https://' . env('AWS_BUCKET') . '.s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com';
                $trailer = $path . $filePath;
                $data['trailer'] = $trailer;
                $data['trailer_type'] = 'video_mp4';
            }
        } else {
            if ($data['trailer_type'] == 'video_mp4') {
                $settings = Setting::first();

                if ($trailer != '' && $pack == 'Business' && $settings->transcoding_access == 1 && $data['trailer_type'] == 'video_mp4') {
                    $settings = Setting::first();
                    // $resolution = explode(",",$settings->transcoding_resolution);
                    if ($settings->transcoding_resolution != null) {
                        $convertresolution = [];
                        $resolution = explode(',', $settings->transcoding_resolution);
                        foreach ($resolution as $value) {
                            if ($value == '240p') {
                                $r_240p = (new Representation())->setKiloBitrate(150)->setResize(426, 240);
                                array_push($convertresolution, $r_240p);
                            }
                            if ($value == '360p') {
                                $r_360p = (new Representation())->setKiloBitrate(276)->setResize(640, 360);
                                array_push($convertresolution, $r_360p);
                            }
                            if ($value == '480p') {
                                $r_480p = (new Representation())->setKiloBitrate(750)->setResize(854, 480);
                                array_push($convertresolution, $r_480p);
                            }
                            if ($value == '720p') {
                                $r_720p = (new Representation())->setKiloBitrate(2048)->setResize(1280, 720);
                                array_push($convertresolution, $r_720p);
                            }
                            if ($value == '1080p') {
                                $r_1080p = (new Representation())->setKiloBitrate(4096)->setResize(1920, 1080);
                                array_push($convertresolution, $r_1080p);
                            }
                        }
                    }
                    $trailer = $data['trailer'];
                    $trailer_path = URL::to('storage/app/trailer/');
                    $trailer_Videoname = Str::lower($trailer->getClientOriginalName());
                    $trailer_Video = time() . '_' . str_replace(' ', '_', $trailer_Videoname);
                    // $trailer_Video =
                    //     time() . "_" . $trailer->getClientOriginalName();
                    $trailer->move(storage_path('app/trailer/'), $trailer_Video);
                    $trailer_video_name = strtok($trailer_Video, '.');
                    $M3u8_save_path = $trailer_path . '/' . $trailer_video_name . '.m3u8';
                    $storepath = URL::to('storage/app/trailer/');

                    $data['trailer'] = $M3u8_save_path;
                    $data['trailer_type'] = 'm3u8';
                } else {
                    if ($trailer != '') {
                        //code for remove old file
                        if ($trailer != '' && $trailer != null) {
                            $file_old = $path . $trailer;
                            if (file_exists($file_old)) {
                                unlink($file_old);
                            }
                        }
                        //upload new file
                        $randval = Str::random(16);
                        $file = $trailer;
                        $trailer_vid = $randval . '.' . $request->file('trailer')->extension();
                        $file->move($path, $trailer_vid);
                        $data['trailer'] = URL::to('/') . '/public/uploads/videos/' . $trailer_vid;
                    } else {
                        $data['trailer'] = $video->trailer;
                    }
                }
            } elseif ($data['trailer_type'] == 'm3u8_url') {
                $data['trailer'] = $data['m3u8_trailer'];
            } elseif ($data['trailer_type'] == 'mp4_url') {
                $data['trailer'] = $data['mp4_trailer'];
            } elseif ($data['trailer_type'] == 'embed_url') {
                $data['trailer'] = $data['embed_trailer'];
            }
        }

        if (isset($data['duration'])) {
            //$str_time = $data
            $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $data['duration']);
            sscanf($str_time, '%d:%d:%d', $hours, $minutes, $seconds);
            $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
            $data['duration'] = $time_seconds;
        }

        if (!empty($data['embed_code'])) {
            $video->embed_code = $data['embed_code'];
        } else {
            $video->embed_code = '';
        }
        if (!empty($data['age_restrict'])) {
            $video->age_restrict = $data['age_restrict'];
        }
        if (!empty($data['banner'])) {
            $banner = 1;
        } else {
            $banner = 0;
        }

        if (!empty($data['video_category_id'])) {
            $video_category_id = implode(',', $request->video_category_id);

            $category_id = $video_category_id;
        }

        if ($request->pdf_file != null) {
            $pdf_files = time() . '.' . $request->pdf_file->extension();
            $request->pdf_file->move(public_path('uploads/videoPdf'), $pdf_files);
            $video->pdf_files = $pdf_files;
        }

        // Reels videos
        $reels_videos = $request->reels_videos;
        if ($request->enable_reel_conversion == 1 && $reels_videos != null) {
            ReelsVideo::where("video_id", $video->id)->delete();

            foreach ($reels_videos as $Reel_Videos) {
                $reelvideo_name =
                    time() . rand(1, 50) . "." . $Reel_Videos->extension();
                $reel_videos_slug = substr(
                    $Reel_Videos->getClientOriginalName(),
                    0,
                    strpos($Reel_Videos->getClientOriginalName(), ".")
                );

                $reelvideo_names = "reels" . $reelvideo_name;

            
                $reelvideo = $Reel_Videos->move(public_path('uploads/reelsVideos'), $reelvideo_name);

                $videoPath = public_path("uploads/reelsVideos/{$reelvideo_name}");
                $shorts_name = 'shorts_'.$reelvideo_name; 
                $videoPath = str_replace('\\', '/', $videoPath);
                $outputPath = public_path("uploads/reelsVideos/shorts/{$shorts_name}");
                // Ensure the output directory exists
                File::ensureDirectoryExists(dirname($outputPath));
                // FFmpeg command to resize to 9:16 aspect ratio
                $command = [
                    'ffmpeg',
                    '-y', // Add this option to force overwrite
                    '-i', $videoPath,
                    '-vf', 'scale=-1:720,crop=400:720', // Adjusted crop filter values
                    '-c:a', 'copy',
                    $outputPath,
                ];

                $process = new Process($command);

                try {
                    $process->mustRun();
                    // return 'Video resized successfully!';
                } catch (ProcessFailedException $exception) {
                    // Error message
                    throw new \Exception('Error resizing video: ' . $exception->getMessage());
                }

                $Reels_videos = new ReelsVideo();
                $Reels_videos->video_id = $video->id;
                // $Reels_videos->reels_videos = $reelvideo_name;
                $Reels_videos->reels_videos = $shorts_name;
                $Reels_videos->reels_videos_slug = $reel_videos_slug;
                $Reels_videos->save();

                $video->reels_thumbnail = "default.jpg";
            }
        }else if($reels_videos != null){
            ReelsVideo::where("video_id", $video->id)->delete();

            foreach ($reels_videos as $Reel_Videos) {
                $reelvideo_name =
                    time() . rand(1, 50) . "." . $Reel_Videos->extension();
                $reel_videos_slug = substr(
                    $Reel_Videos->getClientOriginalName(),
                    0,
                    strpos($Reel_Videos->getClientOriginalName(), ".")
                );

                $reelvideo_names = "reels" . $reelvideo_name;
                $reelvideo = $Reel_Videos->move(
                    public_path("uploads/reelsVideos/shorts"),
                    $reelvideo_name
                );

                $Reels_videos = new ReelsVideo();
                $Reels_videos->video_id = $video->id;
                $Reels_videos->reels_videos = $reelvideo_name;
                // $Reels_videos->reels_videos = $shorts_name;
                $Reels_videos->reels_videos_slug = $reel_videos_slug;
                $Reels_videos->save();

                $video->reels_thumbnail = "default.jpg";
            }
        }
        // if ($reels_videos != null) {
        //     foreach ($reels_videos as $Reel_Videos) {
        //         $reelvideo_name = time() . rand(1, 50) . '.' . $Reel_Videos->extension();
        //         $reel_videos_slug = substr($Reel_Videos->getClientOriginalName(), 0, strpos($Reel_Videos->getClientOriginalName(), '.'));
        //         $reelvideo_names = 'reels' . $reelvideo_name;

        //         $reelvideo = $Reel_Videos->move(public_path('uploads/reelsVideos'), $reelvideo_name);

        //         $videoPath = public_path("uploads/reelsVideos/{$reelvideo_name}");
        //         $shorts_name = 'shorts_'.$reelvideo_name; 
        //         $videoPath = str_replace('\\', '/', $videoPath);
        //         $outputPath = public_path("uploads/reelsVideos/shorts/{$shorts_name}");
        //         // Ensure the output directory exists
        //         File::ensureDirectoryExists(dirname($outputPath));
        //         // FFmpeg command to resize to 9:16 aspect ratio
        //         $command = [
        //             'ffmpeg',
        //             '-y', // Add this option to force overwrite
        //             '-i', $videoPath,
        //             '-vf', 'scale=-1:720,crop=400:720', // Adjusted crop filter values
        //             '-c:a', 'copy',
        //             $outputPath,
        //         ];
        //         $process = new Process($command);

        //         try {
        //             $process->mustRun();
        //             // return 'Video resized successfully!';
        //         } catch (ProcessFailedException $exception) {
        //             throw new \Exception('Error resizing video: ' . $exception->getMessage());
        //         }


        //         $ffmpeg = \FFMpeg\FFMpeg::create();
        //         $videos = $ffmpeg->open('public/uploads/reelsVideos' . '/' . $reelvideo_name);
        //         $videos->filters()->clip(TimeCode::fromSeconds(1), TimeCode::fromSeconds(60));
        //         $videos->save(new \FFMpeg\Format\Video\X264('libmp3lame'), 'public/uploads/reelsVideos' . '/' . $reelvideo_names);

        //         unlink($reelvideo);

        //         $Reels_videos = new ReelsVideo();
        //         $Reels_videos->video_id = $video->id;
        //         $Reels_videos->reels_videos = $shorts_name;
        //         $Reels_videos->reels_videos_slug = $reel_videos_slug;
        //         $Reels_videos->save();

        //         $video->reels_thumbnail = default_vertical_image();
        //     }
        // }

        // Reels Thumbnail

        if (!empty($request->reels_thumbnail)) {
            $Reels_thumbnail = 'reels_' . time() . '.' . $request->reels_thumbnail->extension();
            $request->reels_thumbnail->move(public_path('uploads/images'), $Reels_thumbnail);

            $video->reels_thumbnail = $Reels_thumbnail;
        }

        //URL Link
        $url_link = $request->url_link;

        if ($url_link != null) {
            $video->url_link = $url_link;
        }

        $url_linktym = $request->url_linktym;

        if ($url_linktym != null) {
            $StartParse = date_parse($request->url_linktym);
            $startSec = $StartParse['hour'] * 60 * 60 + $StartParse['minute'] * 60 + $StartParse['second'];
            $video->url_linktym = $url_linktym;
            $video->url_linksec = $startSec;
            $video->urlEnd_linksec = $startSec + 60;
        }

        if (compress_responsive_image_enable() == 1){

                $mobileimages = public_path('/uploads/mobileimages');
                $Tabletimages = public_path('/uploads/Tabletimages');
                $PCimages = public_path('/uploads/PCimages');

            if (!file_exists($mobileimages)) {
                mkdir($mobileimages, 0755, true);
            }

            if (!file_exists($Tabletimages)) {
                mkdir($Tabletimages, 0755, true);
            }

            if (!file_exists($PCimages)) {
                mkdir($PCimages, 0755, true);
            }

            if ($request->hasFile('image')) {

                $image = $request->file('image');

                    // $image_filename = 'video_' .time() . '_image.' . $image->getClientOriginalExtension();
                    // $image_filename = $image_filename;
                    // Image::make($image)->resize(568,320)->save(base_path() . '/public/uploads/mobileimages/' . $image_filename, compress_image_resolution());
                    // Image::make($image)->resize(480,853)->save(base_path() . '/public/uploads/Tabletimages/' . $image_filename, compress_image_resolution());
                    // Image::make($image)->resize(675,1200)->save(base_path() . '/public/uploads/PCimages/' . $image_filename, compress_image_resolution());
                    // $responsive_image = $image_filename;

                    $local_image_path = public_path('/uploads/images/' . basename($image));
                    if (file_exists($local_image_path)) {
                        $image = Image::make($local_image_path);
                        $image_filename = 'video_' .time() . '_image.' . $image->getClientOriginalExtension();
                    } 
                    Image::make($image)->resize(187,332)->save(base_path() . '/public/uploads/mobileimages/' . $image_filename, compress_image_resolution());
                    Image::make($image)->resize(244,435)->save(base_path() . '/public/uploads/Tabletimages/' . $image_filename, compress_image_resolution());
                    Image::make($image)->resize(198,351)->save(base_path() . '/public/uploads/PCimages/' . $image_filename, compress_image_resolution());
                    
                    $responsive_image = $image_filename;         

            }else{

                $responsive_image = default_vertical_image(); 
            }

            if ($request->hasFile('player_image')) {

                $player_image = $request->file('player_image');

                    $player_image_filename = 'video_' .time() . '_player_image.' . $player_image->getClientOriginalExtension();

                    Image::make($player_image)->resize(568,320)->save(base_path() . '/public/uploads/mobileimages/' . $player_image_filename, compress_image_resolution());
                    Image::make($player_image)->resize(480,853)->save(base_path() . '/public/uploads/Tabletimages/' . $player_image_filename, compress_image_resolution());
                    Image::make($player_image)->resize(675,1200)->save(base_path() . '/public/uploads/PCimages/' . $player_image_filename, compress_image_resolution());
                    
                    $responsive_player_image = $player_image_filename;

            }else{
                $responsive_player_image = default_horizontal_image(); 
            }


            
            if ($request->hasFile('video_tv_image')) {

                $video_tv_image = $request->file('video_tv_image');

                    $video_tv_image_filename = 'video_' .time() . '_tv_image.' . $video_tv_image->getClientOriginalExtension();

                    Image::make($video_tv_image)->resize(568,320)->save(base_path() . '/public/uploads/mobileimages/' . $video_tv_image_filename, compress_image_resolution());
                    Image::make($video_tv_image)->resize(480,853)->save(base_path() . '/public/uploads/Tabletimages/' . $video_tv_image_filename, compress_image_resolution());
                    Image::make($video_tv_image)->resize(675,1200)->save(base_path() . '/public/uploads/PCimages/' . $video_tv_image_filename, compress_image_resolution());
                    
                    $responsive_tv_image = $video_tv_image_filename;

            }else{

                $responsive_tv_image = default_horizontal_image(); 
            }

        }else{
            $responsive_image = null;
            $responsive_player_image = null;
            $responsive_tv_image = null;
        }
        
        $storage_settings = StorageSetting::first();   


        if ($video->type == "embed") {
            $status = 1;
        }elseif($storage_settings->flussonic_storage == 1){
            $status = 1;
         } else {
            $status = 0;
        }

        $shortcodes = $request['short_code'];
        $languages = $request['sub_language'];
        $video->video_category_id = null;
        $video->skip_recap = $data['skip_recap'];
        $video->recap_start_time = $data['recap_start_time'];
        $video->recap_end_time = $data['recap_end_time'];
        $video->skip_intro = $data['skip_intro'];
        $video->intro_start_time = $data['intro_start_time'];
        $video->intro_end_time = $data['intro_end_time'];
        $video->description = $data['description'];
        $video->trailer_description = $data['trailer_description'];
        $video->uploaded_by = Auth::user()->role;
        $video->draft = 1;
        $video->active = 1;
        $video->status = $status;
        $video->embed_code = $embed_code;
        $video->publish_type = $publish_type;
        $video->publish_time = $publish_time;
        $video->age_restrict = $data['age_restrict'];
        $video->ppv_price = $data['ppv_price'];
        $video->access = $data['access'];
        $video->banner = $banner;
        $video->featured = $featured;
        $video->country = !empty($request['video_country']) ? json_encode($request['video_country']) : ['All'];
        $video->enable = 1;
        $video->search_tags = $searchtags;
        $video->ios_ppv_price = $data['ios_ppv_price'];
        $video->player_image = $data["player_image"] ;
        $video->video_tv_image = $data["video_tv_image"] ;
        $video->today_top_video = !empty($data["today_top_video"]) ? $data["today_top_video"] : 0 ;
        $video->tiny_video_image = $data["tiny_video_image"] ;
        $video->tiny_player_image = $data["tiny_player_image"] ;
        $video->tiny_video_title_image = $data["tiny_video_title_image"] ;
        $video->responsive_image = $responsive_image;
        $video->responsive_player_image = $responsive_player_image;
        $video->responsive_tv_image = $responsive_tv_image;
        $video->ppv_option = $request->ppv_option;
        // $video->ppv_price_240p = $data['ppv_price_240p'];
        // $video->ppv_price_360p = $data['ppv_price_360p'];
        $video->ppv_price_480p = $data['ppv_price_480p'];
        $video->ppv_price_720p = $data['ppv_price_720p'];
        $video->ppv_price_1080p = $data['ppv_price_1080p'];
        // $video->ios_ppv_price_240p = $data['ios_ppv_price_240p'];
        // $video->ios_ppv_price_360p = $data['ios_ppv_price_360p'];
        $video->ios_ppv_price_480p = $data['ios_ppv_price_480p'];
        $video->ios_ppv_price_720p = $data['ios_ppv_price_720p'];
        $video->ios_ppv_price_1080p = $data['ios_ppv_price_1080p'];

        // Ads videos
        if (!empty($data['ads_tag_url_id']) == null) {
            $video->ads_tag_url_id = null;
            $video->tag_url_ads_position = null;
        }

        if (!empty($data['ads_tag_url_id']) != null) {
            $video->ads_tag_url_id = $data['ads_tag_url_id'];
            $video->tag_url_ads_position = $data['tag_url_ads_position'];
        }

        if (!empty($data['default_ads'])) {
            $video->default_ads = $data['default_ads'];
        } else {
            $video->default_ads = 0;
        }

        $video->update($data);
        if ($trailer != '' && $pack == 'Business' && $settings->transcoding_access == 1 && $StorageSetting->site_storage == 1) {
            ConvertVideoTrailer::dispatch($video, $storepath, $convertresolution, $trailer_video_name, $trailer_Video);
        }
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
        if (!empty($data['video_category_id'])) {
            $category_id = $data['video_category_id'];
            unset($data['video_category_id']);
            /*save artist*/
            if (!empty($category_id)) {
                CategoryVideo::where('video_id', $video->id)->delete();
                foreach ($category_id as $key => $value) {
                    $category = new CategoryVideo();
                    $category->video_id = $video->id;
                    $category->category_id = $value;
                    $category->save();

                    \LogActivity::addVideoCategoryLog('Added Category for Video.', $video->id, $value);
                }
            }
        } else {
            CategoryVideo::where('video_id', $video->id)->delete();

            $other_category = VideoCategory::where('slug', 'other_category')->first();

            if ($other_category == null) {
                VideoCategory::create([
                    'user_id' => null,
                    'parent_id' => null,
                    'order' => '1',
                    'name' => 'Other category',
                    'image' => 'default.jpg',
                    'slug' => 'other_category',
                    'in_home' => '1',
                    'footer' => null,
                    'banner' => '0',
                    'in_menu' => null,
                    'banner_image' => 'default.jpg',
                ]);
            }

            $other_category_id = VideoCategory::where('slug', 'other_category')
                ->pluck('id')
                ->first();

            $category = new CategoryVideo();
            $category->video_id = $video->id;
            $category->category_id = $other_category_id;
            $category->save();
        }

        if (!empty($data['related_videos'])) {
            $related_videos = $data['related_videos'];
            // unset($data['related_videos']);
            /*save artist*/
            if (!empty($related_videos)) {
                foreach ($related_videos as $key => $vid) {
                    $videos = Video::where('id', $vid)->get();
                    foreach ($videos as $key => $val) {
                        $RelatedVideo = new RelatedVideo();
                        $RelatedVideo->video_id = $id;
                        $RelatedVideo->user_id = Auth::user()->id;
                        $RelatedVideo->related_videos_id = $val->id;
                        $RelatedVideo->related_videos_title = $val->title;
                        $RelatedVideo->save();
                    }
                }
            }
        }

        if (!empty($data['language'])) {
            $language_id = $data['language'];
            unset($data['language']);
            /*save artist*/
            if (!empty($language_id)) {
                LanguageVideo::where('video_id', $video->id)->delete();
                foreach ($language_id as $key => $value) {
                    $languagevideo = new LanguageVideo();
                    $languagevideo->video_id = $video->id;
                    $languagevideo->language_id = $value;
                    $languagevideo->save();
                    \LogActivity::addVideoLanguageLog('Added Language for Video.', $video->id, $value);
                }
            }
        }
        if (!empty($data['artists'])) {
            $artistsdata = $data['artists'];
            unset($data['artists']);
            /*save artist*/
            if (!empty($artistsdata)) {
                Videoartist::where('video_id', $video->id)->delete();
                foreach ($artistsdata as $key => $value) {
                    $artist = new Videoartist();
                    $artist->video_id = $video->id;
                    $artist->artist_id = $value;
                    $artist->save();
                    \LogActivity::addVideoArtistLog('Added Artist for Video.', $video->id, $value);
                }
            }
        }

        if (!empty($data['searchtags'])) {
            $searchtags = explode(',', $data['searchtags']);
            VideoSearchTag::where('video_id', $video->id)->delete();
            foreach ($searchtags as $key => $value) {
                $videosearchtags = new VideoSearchTag();
                $videosearchtags->user_id = Auth::User()->id;
                $videosearchtags->video_id = $video->id;
                $videosearchtags->search_tag = $value;
                $videosearchtags->save();
            }
        }

        // playlist
        if (!empty($data["playlist"])) {
            $playlist_id = $data["playlist"];
            unset($data["playlist"]);
            if (!empty($playlist_id)) {
                VideoPlaylist::where("video_id", $video->id)->delete();

                foreach ($playlist_id as $key => $value) {
                    $VideoPlaylist = new VideoPlaylist();
                    $VideoPlaylist->user_id = Auth::user()->id;
                    $VideoPlaylist->video_id = $video->id;
                    $VideoPlaylist->playlist_id = $value;
                    $VideoPlaylist->save();
                }
            }
        }

        if (!empty($data['country'])) {
            $country = $data['country'];
            unset($data['country']);
            /*save country*/
            if (!empty($country)) {
                BlockVideo::where('video_id', $video->id)->delete();
                foreach ($country as $key => $value) {
                    $country = new BlockVideo();
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
        // if (!empty($files != '' && $files != null)) {
        //     foreach ($files as $key => $val) {
        //         if (!empty($files[$key])) {
        //             $destinationPath = 'public/uploads/subtitles/';
        //             $filename = $video->id . '-' . $shortcodes[$key] . '.srt';
        //             $files[$key]->move($destinationPath, $filename);
        //             $subtitle_data['sub_language'] = $languages[$key]; /*URL::to('/').$destinationPath.$filename; */
        //             $subtitle_data['shortcode'] = $shortcodes[$key];
        //             $subtitle_data['movie_id'] = $id;
        //             $subtitle_data['url'] = URL::to('/') . '/public/uploads/subtitles/' . $filename;
        //             $video_subtitle = new MoviesSubtitles();
        //             $video_subtitle->movie_id = $video->id;
        //             $video_subtitle->shortcode = $shortcodes[$key];
        //             $video_subtitle->sub_language = $languages[$key];
        //             $video_subtitle->url = URL::to('/') . '/public/uploads/subtitles/' . $filename;
        //             $video_subtitle->save();
        //         }
        //     }
        // }

            // Define the convertTimeFormat function globally

            function convertTimeFormat($hours, $minutes, $seconds, $milliseconds) {
                $totalSeconds = $hours * 3600 + $minutes * 60 + $seconds + $milliseconds / 1000;
                $formattedTime = gmdate("H:i:s", $totalSeconds);
                $formattedMilliseconds = str_pad($milliseconds, 3, '0', STR_PAD_LEFT);
                return "{$formattedTime},{$formattedMilliseconds}";
            }

            if (!empty($files != "" && $files != null)) {
                foreach ($files as $key => $val) {
                    if (!empty($files[$key])) {
                        $destinationPath = "public/uploads/subtitles/";

                        if (!file_exists($destinationPath)) {
                            mkdir($destinationPath, 0755, true);
                        }

                        $filename = $video->id . "-" . $shortcodes[$key] . ".srt";

                        MoviesSubtitles::where('movie_id', $video->id)->where('shortcode', $shortcodes[$key])->delete();

                        // Move uploaded file to destination path
                        move_uploaded_file($val->getPathname(), $destinationPath . $filename);

                        // Read contents of the uploaded file
                        $contents = file_get_contents($destinationPath . $filename);

                        // Convert time format and add line numbers
                        $lineNumber = 0;
                        $convertedContents = preg_replace_callback(
                            '/(\d{2}):(\d{2}).(\d{3}) --> (\d{2}):(\d{2}).(\d{3})/',
                            function ($matches) use (&$lineNumber) {
                                // Increment line number for each match
                                $lineNumber++;
                                // Convert time format and return with the line number
                                return "{$lineNumber}\n" . convertTimeFormat(0, $matches[1], $matches[2], $matches[3]) . " --> " . convertTimeFormat(0, $matches[4], $matches[5], $matches[6]);
                            },
                            $contents
                        );

                        // Store converted contents to a new file
                        $newDestinationPath = "public/uploads/convertedsubtitles/";
                        if (!file_exists($newDestinationPath)) {
                            mkdir($newDestinationPath, 0755, true);
                        }
                        file_put_contents($newDestinationPath . $filename, $convertedContents);

                        // Save subtitle data to database
                        $subtitle_data = [
                            "movie_id" => $video->id,
                            "shortcode" => $shortcodes[$key],
                            "sub_language" => $languages[$key],
                            "url" => URL::to("/") . "/public/uploads/subtitles/" . $filename,
                            "Converted_Url" => URL::to("/") . "/public/uploads/convertedsubtitles/" . $filename
                        ];
                        $video_subtitle = MoviesSubtitles::create($subtitle_data);
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

                // Admin Video Ads inputs

        if( !empty($request->ads_devices)){

            $Admin_Video_Ads_inputs = array(

                'video_id' => $video->id ,
                'website_vj_pre_postion_ads'   =>  in_array("website", $request->ads_devices) ?  $request->website_vj_pre_postion_ads : null ,
                'website_vj_mid_ads_category'  =>  in_array("website", $request->ads_devices) ? $request->website_vj_mid_ads_category : null ,
                'website_vj_post_position_ads' =>  in_array("website", $request->ads_devices) ? $request->website_vj_post_position_ads : null,
                'website_vj_pre_postion_ads'   =>  in_array("website", $request->ads_devices) ? $request->website_vj_pre_postion_ads : null,

                'andriod_vj_pre_postion_ads'   => in_array("android", $request->ads_devices) ? $request->andriod_vj_pre_postion_ads : null,
                'andriod_vj_mid_ads_category'  => in_array("android", $request->ads_devices) ? $request->andriod_vj_mid_ads_category : null,
                'andriod_vj_post_position_ads' => in_array("android", $request->ads_devices) ? $request->andriod_vj_post_position_ads : null,
                'andriod_mid_sequence_time'    => in_array("android", $request->ads_devices) ? $request->andriod_mid_sequence_time : null,

                'ios_vj_pre_postion_ads'   => in_array("IOS", $request->ads_devices) ? $request->ios_vj_pre_postion_ads : null,
                'ios_vj_mid_ads_category'  => in_array("IOS", $request->ads_devices) ? $request->ios_vj_mid_ads_category : null,
                'ios_vj_post_position_ads' => in_array("IOS", $request->ads_devices) ? $request->ios_vj_post_position_ads : null,
                'ios_mid_sequence_time'    => in_array("IOS", $request->ads_devices) ? $request->ios_mid_sequence_time : null,

                'tv_vj_pre_postion_ads'   => in_array("TV", $request->ads_devices) ? $request->tv_vj_pre_postion_ads : null,
                'tv_vj_mid_ads_category'  => in_array("TV", $request->ads_devices) ? $request->tv_vj_mid_ads_category : null,
                'tv_vj_post_position_ads' => in_array("TV", $request->ads_devices) ? $request->tv_vj_post_position_ads : null,
                'tv_mid_sequence_time'    => in_array("TV", $request->ads_devices) ? $request->tv_mid_sequence_time : null,

                'roku_vj_pre_postion_ads'   => in_array("roku", $request->ads_devices) ? $request->roku_vj_pre_postion_ads : null,
                'roku_vj_mid_ads_category'  => in_array("roku", $request->ads_devices) ? $request->roku_vj_mid_ads_category : null,
                'roku_vj_post_position_ads' => in_array("roku", $request->ads_devices) ? $request->roku_vj_post_position_ads : null,
                'roku_mid_sequence_time'    => in_array("roku", $request->ads_devices) ? $request->roku_mid_sequence_time : null,

                'lg_vj_pre_postion_ads'   => in_array("lg", $request->ads_devices) ? $request->lg_vj_pre_postion_ads : null,
                'lg_vj_mid_ads_category'  => in_array("lg", $request->ads_devices) ? $request->lg_vj_mid_ads_category : null,
                'lg_vj_post_position_ads' => in_array("lg", $request->ads_devices) ? $request->lg_vj_post_position_ads : null,
                'lg_mid_sequence_time'    => in_array("lg", $request->ads_devices) ? $request->lg_mid_sequence_time : null,

                'samsung_vj_pre_postion_ads'   => in_array("samsung", $request->ads_devices) ?$request->samsung_vj_pre_postion_ads : null,
                'samsung_vj_mid_ads_category'  => in_array("samsung", $request->ads_devices) ?$request->samsung_vj_mid_ads_category : null,
                'samsung_vj_post_position_ads' => in_array("samsung", $request->ads_devices) ?$request->samsung_vj_post_position_ads : null,
                'samsung_mid_sequence_time'    => in_array("samsung", $request->ads_devices) ?$request->samsung_mid_sequence_time : null,

                // plyr.io

                'website_plyr_tag_url_ads_position' => $request->website_plyr_tag_url_ads_position,
                'website_plyr_ads_tag_url_id'       => $request->website_plyr_ads_tag_url_id,
                
                'andriod_plyr_tag_url_ads_position' => $request->andriod_plyr_tag_url_ads_position,
                'andriod_plyr_ads_tag_url_id'       => $request->andriod_plyr_ads_tag_url_id,

                'ios_plyr_tag_url_ads_position' => $request->ios_plyr_tag_url_ads_position,
                'ios_plyr_ads_tag_url_id'       => $request->ios_plyr_ads_tag_url_id,

                'tv_plyr_tag_url_ads_position' => $request->tv_plyr_tag_url_ads_position,
                'tv_plyr_ads_tag_url_id'       => $request->tv_plyr_ads_tag_url_id,

                'roku_plyr_tag_url_ads_position' => $request->roku_plyr_tag_url_ads_position,
                'roku_plyr_ads_tag_url_id'       => $request->roku_plyr_ads_tag_url_id,

                'lg_plyr_tag_url_ads_position' => $request->lg_plyr_tag_url_ads_position,
                'lg_plyr_ads_tag_url_id'       => $request->lg_plyr_ads_tag_url_id,
                
                'samsung_plyr_tag_url_ads_position' => $request->samsung_plyr_tag_url_ads_position,
                'samsung_plyr_ads_tag_url_id'       => $request->samsung_plyr_ads_tag_url_id,

                'ads_devices' => !empty($request->ads_devices) ? json_encode($request->ads_devices) : null,
            );

            AdminVideoAds::create( $Admin_Video_Ads_inputs )  ;
            
        }
        if($storage_settings->flussonic_storage == 1){ Video::where('id',$id)->update(['status'=>1]); }

        \LogActivity::addVideoUpdateLog('Update Meta Data for Video.', $video->id);

        return Redirect::back()->with('message', 'Your video will be available shortly after we process it');
    }   
    public function Mp4url(Request $request)
    {
        $data = $request->all();
        $value = [];

        if (!empty($data["mp4_url"])) {
            $video = new Video();
            $video->disk = "public";
            $video->original_name = "public";
            $video->title = $data["mp4_url"];
            $video->mp4_url = $data["mp4_url"];
            $video->type = "mp4_url";
            $video->draft = 0;
            $video->active = 1;
            $video->image = default_vertical_image();
            $video->video_tv_image = default_horizontal_image();
            $video->player_image = default_horizontal_image();
            $video->user_id = Auth::user()->id;
            $video->save();

            $video_id = $video->id;

            $value["success"] = 1;
            $value["message"] = "Uploaded Successfully!";
            $value["video_id"] = $video_id;
            \LogActivity::addVideoLog("Added Mp4 URl Video.", $video_id);

            return $value;
        }
    }
    public function m3u8url(Request $request)
    {
        $data = $request->all();
        $value = [];

        if (!empty($data["m3u8_url"])) {
            $video = new Video();
            $video->disk = "public";
            $video->original_name = "public";
            $video->title = $data["m3u8_url"];
            $video->m3u8_url = $data["m3u8_url"];
            $video->type = "m3u8_url";
            $video->draft = 0;
            $video->active = 1;
            $video->image = default_vertical_image();
            $video->video_tv_image = default_horizontal_image();
            $video->player_image = default_horizontal_image();
            $video->user_id = Auth::user()->id;
            $video->save();

            $video_id = $video->id;

            $value["success"] = 1;
            $value["message"] = "Uploaded Successfully!";
            $value["video_id"] = $video_id;

            \LogActivity::addVideoLog("Added M3U8 URl Video.", $video_id);

            return $value;
        }
    }
    public function Embededcode(Request $request)
    {
        $data = $request->all();
        $value = [];


        if (!empty($data["embed"])) {
            $video = new Video();
            $video->disk = "public";
            $video->original_name = "public";
            $video->title = $data["embed"];
            $video->embed_code = $data["embed"];
            $video->type = "embed";
            $video->draft = 1;
            $video->status = 1;
            $video->active = 1;
            $video->image = default_vertical_image();
            $video->video_tv_image = default_horizontal_image();
            $video->player_image = default_horizontal_image();
            $video->user_id = Auth::user()->id;
            $video->save();

            $video_id = $video->id;

            $value["success"] = 1;
            $value["message"] = "Uploaded Successfully!";
            $value["video_id"] = $video_id;

            \LogActivity::addVideoLog("Added Embeded URl Video.", $video_id);

            return $value;
        }
    }


    public function UploadBunnyCDNVideo(Request $request)
    {
        $data = $request->all();
        $value = [];

        if (!empty($data["bunny_cdn_linked_video"])) {

            $filenameWithExtension = basename($data["bunny_cdn_linked_video"]);
            $pathInfo = pathinfo($filenameWithExtension);
            $extension = $pathInfo['extension'];

            if($extension == 'mp4'){

            $video = new Video();
            $video->disk = "public";
            $video->original_name = "public";
            $video->title = $data["bunny_cdn_linked_video"];
            $video->mp4_url = $data["bunny_cdn_linked_video"];
            $video->type = "mp4_url";
            $video->draft = 0;
            $video->active = 1;
            $video->image = default_vertical_image();
            $video->video_tv_image = default_horizontal_image();
            $video->player_image = default_horizontal_image();
            $video->user_id = Auth::user()->id;
            $video->save();

            $video_id = $video->id;

            $value["success"] = 1;
            $value["message"] = "Uploaded Successfully!";
            $value["video_id"] = $video_id;

            \LogActivity::addVideoLog("Added Bunny CDN VIDEO URl Video.", $video_id);


        }elseif($extension == 'm3u8'){


            $video = new Video();
            $video->disk = "public";
            $video->original_name = "public";
            $video->title = $data["bunny_cdn_linked_video"];
            $video->m3u8_url = $data["bunny_cdn_linked_video"];
            $video->type = "m3u8_url";
            $video->draft = 0;
            $video->active = 1;
            $video->image = default_vertical_image();
            $video->video_tv_image = default_horizontal_image();
            $video->player_image = default_horizontal_image();
            $video->user_id = Auth::user()->id;
            $video->save();

            $video_id = $video->id;

            $value["success"] = 1;
            $value["message"] = "Uploaded Successfully!";
            $value["video_id"] = $video_id;

            \LogActivity::addVideoLog("Added Bunny CDN VIDEO URl Video.", $video_id);


        }else{

            \LogActivity::addVideoLog("Not Added Bunny CDN VIDEO URl Video.", 0);

        }


            return $value;
        }
    }

    public function CPPVideosIndex()
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
            
            $videos = Video::where('status',0)->where('uploaded_by','CPP')->latest()->get();

            $data = [ "videos" => $videos, ];

            return View("admin.videos.videoapproval.approval_index", $data);
        }
    }
    public function CPPVideosApproval($id)
    {
        $video = Video::findOrFail($id);
        $video->status = 1;
        $video->active = 1;
        $video->draft = 1;
        $video->save();

        $settings = Setting::first();
        $user_id = $video->user_id;
        $ModeratorsUser = ModeratorsUser::findOrFail($video->user_id);
        try {

            $email_template_subject =  EmailTemplate::where('id',12)->pluck('heading')->first() ;
            $email_subject  = str_replace("{ContentName}", "$video->title", $email_template_subject);

            $data = array(
                'email_subject' => $email_subject,
            );

            // 
            Mail::send('emails.CPP_Partner_Content_Approval', array(
                'Name'         => $ModeratorsUser->username,
                'ContentName'  =>  $video->title,
                'ContentPermalink' =>  URL::to('/category/videos/'.$video->slug),
                'website_name'     =>  GetWebsiteName(),
            ), 
            function($message) use ($data,$ModeratorsUser) {
                $message->from(AdminMail(),GetWebsiteName());
                $message->to($ModeratorsUser->email, $ModeratorsUser->username)->subject($data['email_subject']);
            });

            $email_log      = 'Mail Sent Successfully from Partner Content Approval Congratulations! {ContentName} is published Successfully!';
            $email_template = "12";
            $user_id = $id;

            Email_sent_log($user_id,$email_log,$email_template);

        } catch (\Throwable $th) {

            $email_log = $th->getMessage();
            $email_template = "12";
            $user_id = $user_id;

            Email_notsent_log($user_id, $email_log, $email_template);
        }

        return Redirect::back()->with("message","Your video will be available shortly after we process it");
    }

    public function CPPVideosReject($id)
    {
        $video = Video::findOrFail($id);
        $video->active = 2;
        $video->save();

        $settings = Setting::first();
        $user_id = $video->user_id;
        $ModeratorsUser = ModeratorsUser::findOrFail($video->user_id);

        try {

            $email_template_subject =  EmailTemplate::where('id',13)->pluck('heading')->first() ;
            $email_subject  = str_replace("{ContentName}", "$video->title", $email_template_subject);

            $data = array(
                'email_subject' => $email_subject,
            );

            Mail::send('emails.CPP_Partner_Content_Reject', array(
                'Name'     => $ModeratorsUser->username,
                'ContentName'  =>  $video->title,
                'website_name' =>  GetWebsiteName(),
            ), 
            function($message) use ($data,$ModeratorsUser) {
                $message->from(AdminMail(),GetWebsiteName());
                $message->to($ModeratorsUser->email, $ModeratorsUser->username)->subject($data['email_subject']);
            });

            $email_log      = 'Mail Sent Successfully from Partner content Reject!';
            $email_template = "13";
            $user_id = $id;

            Email_sent_log($user_id,$email_log,$email_template);

        } catch (\Throwable $th) {

            $email_log = $th->getMessage();
            $email_template = "13";
            $user_id = $user_id;

            Email_notsent_log($user_id, $email_log, $email_template);
        }

        return Redirect::back()->with("message","Your video will be available shortly after we process it");
    }
    function get_processed_percentage($id)
    {
        return Video::where("id", "=", $id)->first();
    }

    function get_compression_processed_percentage($id)
    {
        return Video::where("id", "=", $id)->first();
    }
    
    public function purchaseVideocount(Request $request)
    {
        $data = $request->all();
        $user_id = Auth::user()->id;
        $video_id = $data["video_id"];
        // view_count
        $purchase = PpvPurchase::where("video_id", $video_id)
            ->where("user_id", $user_id)
            ->first();
        if ($purchase->view_count == null || $purchase->view_count < 0) {
            // print_r('1');exit;
            $purchase->view_count = 1;
            $purchase->save();
            return 1;
        } elseif ($purchase->view_count > 0) {
            // print_r('2');exit;
            return 2;
        } else {
            return 3;
        }
    }

    public function editvideo($id)
    {

        if (!Auth::user()->role == "admin") {
            return redirect("/home");
        }
        $settings = Setting::first();

        $video = Video::find($id);

        $ads_details = AdsVideo::join(
            "advertisements",
            "advertisements.id",
            "ads_videos.ads_id"
        )
            ->where("ads_videos.video_id", $id)
            ->pluck("ads_id")
            ->first();

        $ads_rolls = AdsVideo::join(
            "advertisements",
            "advertisements.id",
            "ads_videos.ads_id"
        )
            ->where("ads_videos.video_id", $id)
            ->pluck("ad_roll")
            ->first();

        $ads_category = Adscategory::get();

        $Reels_videos = Video::Join(
            "reelsvideo",
            "reelsvideo.video_id",
            "=",
            "videos.id"
        )
            ->where("videos.id", $id)
            ->get();

            $StorageSetting = StorageSetting::first();
            if($StorageSetting->site_storage == 1){
                $dropzone_url =  URL::to('admin/uploadEditVideo');
            }elseif($StorageSetting->aws_storage == 1){
                $dropzone_url =  URL::to('admin/AWSuploadEditVideo');
            }else{ 
                $dropzone_url =  URL::to('admin/uploadEditVideo');
            }

            $theme_settings = SiteTheme::first();
 
        $data = [
            "headline" => '<i class="fa fa-edit"></i> Edit Video',
            "video" => $video,
            "post_route" => URL::to("admin/videos/update"),
            "button_text" => "Update Video",
            "admin_user" => Auth::user(),
            "video_categories" => VideoCategory::all(),
            "ads" => Advertisement::where("status", "=", 1)->get(),
            "video_subtitle" => VideosSubtitle::all(),
            "subtitles" => Subtitle::all(),
            "languages" => Language::all(),
            "artists" => Artist::all(),
            "settings" => $settings,
            "age_categories" => AgeCategory::all(),
            "countries" => CountryCode::all(),
            "video_artist" => Videoartist::where("video_id", $id)
                ->pluck("artist_id")
                ->toArray(),
            "category_id" => CategoryVideo::where("video_id", $id)
                ->pluck("category_id")
                ->toArray(),
            "languages_id" => LanguageVideo::where("video_id", $id)
                ->pluck("language_id")
                ->toArray(),
            "page" => "Edit",
            "Reels_videos" => $Reels_videos,
            "ads_paths" => $ads_details ? $ads_details : 0,
            "ads_rolls" => $ads_rolls ? $ads_rolls : 0,
            "ads_category" => $ads_category,
            "dropzone_url" => $dropzone_url,

        ];
           
        if($theme_settings->enable_video_cipher_upload == 1){
            return View::make("admin.videos.VideoCipherEditVideo", $data);
        }else{
            return View::make("admin.videos.edit_video", $data);
        }
        
    }

    public function uploadEditVideo(Request $request)
    {
        $value = [];
        $data = $request->all();
        $id = $data["videoid"];
        $video = Video::findOrFail($id);

        // echo "<pre>";
        // print_r($video);exit();
        $validator = Validator::make($request->all(), [
            "file" => "required|mimes:video/mp4,video/x-m4v,video/*",
        ]);
        $mp4_url = isset($data["file"]) ? $data["file"] : "";

        $path = public_path() . "/uploads/videos/";

        $file = $request->file->getClientOriginalName();
        $newfile = explode(".mp4", $file);
        $file_folder_name = $newfile[0];

        $package = User::where("id", 1)->first();
        $pack = $package->package;
        $mp4_url = $data["file"];
        $settings = Setting::first();

        if (
            $mp4_url != "" &&
            $pack != "Business" &&
            $settings->transcoding_access == 0
        ) {
            // $ffprobe = \FFMpeg\FFProbe::create();
            // $disk = 'public';
            // $data['duration'] = $ffprobe->streams($request->file)
            // ->videos()
            // ->first()
            // ->get('duration');

            $rand = Str::random(16);
            $path = $rand . "." . $request->file->getClientOriginalExtension();

            $request->file->storeAs("public", $path);
            $thumb_path = "public";

            // $this->build_video_thumbnail($request->file,$path, $data['slug']);

            $original_name = $request->file->getClientOriginalName()
                ? $request->file->getClientOriginalName()
                : "";
            //  $storepath  = URL::to('/storage/app/public/'.$file_folder_name.'/'.$original_name);
            //  $str = explode(".mp4",$path);
            //  $path =$str[0];
            $storepath = URL::to("/storage/app/public/" . $path);

            //  Video duration
            $getID3 = new getID3();
            $Video_storepath = storage_path("app/public/" . $path);
            $VideoInfo = $getID3->analyze($Video_storepath);
            $Video_duration = $VideoInfo["playtime_seconds"];

            // $video = new Video();
            $video->disk = "public";
            $video->title = $file_folder_name;
            $video->original_name = "public";
            $video->path = $path;
            $video->mp4_url = $storepath;
            $video->type = "mp4_url";
            // $video->draft = 0;
            $video->duration = $Video_duration;
            $video->save();

            $video_id = $video->id;
            $video_title = Video::find($video_id);
            $title = $video_title->title;

            $value["success"] = 1;
            $value["message"] = "Uploaded Successfully!";
            $value["video_id"] = $video_id;
            $value["video_title"] = $title;

            // return $value;
            return redirect("/admin/videos");

        } elseif (
            $mp4_url != "" &&
            $pack == "Business" &&
            $settings->transcoding_access == 1
        ) {
            
            $rand = Str::random(16);
            $path = $rand . "." . $request->file->getClientOriginalExtension();
            $request->file->storeAs("public", $path);

            $original_name = $request->file->getClientOriginalName()
                ? $request->file->getClientOriginalName()
                : "";

            $storepath = URL::to("/storage/app/public/" . $path);

            //  Video duration
            $getID3 = new getID3();
            $Video_storepath = storage_path("app/public/" . $path);
            $VideoInfo = $getID3->analyze($Video_storepath);
            $Video_duration = $VideoInfo["playtime_seconds"];

            //  $video = new Video();
            $video->disk = "public";
            $video->status = 0;
            $video->original_name = "public";
            $video->path = $path;
            $video->old_path_mp4 = $path;
            $video->title = $file_folder_name;
            $video->mp4_url = $storepath;
            $video->processed_low = 0;
            //  $video->draft = 0;
            $video->type = "";
            //  $video->image = 'default_image.jpg';
            $video->duration = $Video_duration;
            $video->user_id = Auth::user()->id;
            $video->save();

            $video_id = $video->id;

            $Playerui = Playerui::first();
            if(@$Playerui->video_watermark_enable == 1 && !empty($Playerui->video_watermark)){

                $video = Video::find($video_id);
                $video->watermark_transcoding_progress = 1;
                $video->save();
                TranscodeVideo::dispatch($video);
            }
            // else if(@$settings->video_clip_enable == 1 && !empty($settings->video_clip)){
            //     VideoClip::dispatch($video);
            // }
            else{
                if(Enable_4k_Conversion() == 1){
                    Convert4kVideoForStreaming::dispatch($video);
                }else{
                    ConvertVideoForStreaming::dispatch($video);
                }
            }          
            $video_id = $video->id;
            $video_title = Video::find($video_id);
            $title = $video_title->title;

            $value["success"] = 1;
            $value["message"] = "Uploaded Successfully!";
            $value["video_id"] = $video_id;
            $value["video_title"] = $title;

            return $value;
            // return redirect("/admin/videos");

        } elseif (
            $mp4_url != "" &&
            $pack == "Business" &&
            $settings->transcoding_access == 0
        ) {
            $rand = Str::random(16);
            $path = $rand . "." . $request->file->getClientOriginalExtension();

            $request->file->storeAs("public", $path);
            $thumb_path = "public";

            $original_name = $request->file->getClientOriginalName()
                ? $request->file->getClientOriginalName()
                : "";

            $storepath = URL::to("/storage/app/public/" . $path);

            //  Video duration
            $getID3 = new getID3();
            $Video_storepath = storage_path("app/public/" . $path);
            $VideoInfo = $getID3->analyze($Video_storepath);
            $Video_duration = $VideoInfo["playtime_seconds"];

            // $video = new Video();
            $video->disk = "public";
            $video->title = $file_folder_name;
            $video->original_name = "public";
            $video->path = $path;
            $video->mp4_url = $storepath;
            $video->type = "mp4_url";
            // $video->draft = 0;
            $video->duration = $Video_duration;
            $video->save();

            $video_id = $video->id;
            $video_title = Video::find($video_id);
            $title = $video_title->title;

            $value["success"] = 1;
            $value["message"] = "Uploaded Successfully!";
            $value["video_id"] = $video_id;
            $value["video_title"] = $title;

            return $value;
        } else {
            $value["success"] = 2;
            $value["message"] = "File not uploaded.";
            return response()->json($value);
            // return redirect("/admin/videos");

        }

        // return response()->json($value);
    }

    public function VideoBulk_delete(Request $request)
    {
        try {
            $video_id = $request->video_id;
            Video::whereIn("id", explode(",", $video_id))->delete();
            PlayerAnalytic::whereIn("videoid", explode(",", $video_id))->delete();
            CategoryVideo::whereIn("video_id", explode(",", $video_id))->delete();
            PlayerSeekTimeAnalytic::whereIn("video_id", explode(",", $video_id))->delete();
            VideoPlaylist::where("video_id", $id)->delete();

            return response()->json(["message" => "true"]);
        } catch (\Throwable $th) {
            return response()->json(["message" => "false"]);
        }
    }

    public function Updatemp4url(Request $request)
    {
        $value = [];
        $data = $request->all();

        $id = $data["videoid"];
        $video = Video::findOrFail($id);
        if(!empty($video) && $video->mp4_url == $data["mp4_url"]){
            $value["success"] = 1;
            $value["message"] = "Already Exits";
            $value["video_id"] = $id;

            return $value;
        }else{
        // echo"<pre>";print_r($data);exit;
        if (!empty($data["mp4_url"])) {
            $video->disk = "public";
            $video->original_name = "public";
            // $video->title = $data['mp4_url'];
            $video->mp4_url = $data["mp4_url"];
            $video->type = "mp4_url";
            // $video->draft = 0;
            $video->active = 1;
            $video->user_id = Auth::user()->id;
            $video->save();

            $video_id = $video->id;

            $value["success"] = 1;
            $value["message"] = "URL Updated Successfully!";
            $value["video_id"] = $video_id;

            // return $value;
            return redirect("/admin/videos");

        }
    }
    }
    public function Updatem3u8url(Request $request)
    {
        $data = $request->all();
        $value = [];

        $id = $data["videoid"];

        $video = Video::findOrFail($id);
        if(!empty($video) && $video->m3u8_url == $data["m3u8_url"]){
            $value["success"] = 1;
            $value["message"] = "Already Exits";
            $value["video_id"] = $id;

            return $value;
        }else{

        if (!empty($data["m3u8_url"])) {
            // $video = new Video();
            $video->disk = "public";
            $video->original_name = "public";
            // $video->title = $data['m3u8_url'];
            $video->m3u8_url = $data["m3u8_url"];
            $video->type = "m3u8_url";
            // $video->draft = 0;
            $video->active = 1;
            $video->user_id = Auth::user()->id;
            $video->save();

            $video_id = $video->id;

            $value["success"] = 1;
            $value["message"] = "URL Updated Successfully!";
            $value["video_id"] = $video_id;

            // return $value;
            return redirect("/admin/videos");

        }
    }

    }
    public function UpdateEmbededcode(Request $request)
    {
        $data = $request->all();
        $value = [];

       
        $id = $data["videoid"];
        $video = Video::findOrFail($id);
        if(!empty($video) && $video->embed_code == $data["embed"]){
            $value["success"] = 1;
            $value["message"] = "Already Exits";
            $value["video_id"] = $id;

            return $value;
        }else{
        if (!empty($data["embed"])) {
            // $video = new Video();
            $video->disk = "public";
            $video->original_name = "public";
            // $video->title = $data['embed'];
            $video->embed_code = $data["embed"];
            $video->type = "embed";
            $video->draft = 0;
            $video->active = 1;
            $video->user_id = Auth::user()->id;
            $video->save();

            $video_id = $video->id;

            $value["success"] = 1;
            $value["message"] = "URL Updated Successfully!";
            $value["video_id"] = $video_id;
            // return $value;
            return redirect("/admin/videos");

        }
    }
    }

    public function video_slider_update(Request $request)
    {
        try {
            $video = Video::where("id", $request->video_id)->update([
                "banner" => $request->banner_status,
            ]);

            return response()->json(["message" => "true"]);
        } catch (\Throwable $th) {
            return response()->json(["message" => "false"]);
        }
    }

    public function video_slug_validate(Request $request)
    {
        $video_slug_validate = Video::where("slug", $request->slug)->count();

        if ($request->type == "create") {
            $validate_status = $video_slug_validate > 0 ? "true" : "false";
        } elseif ($request->type == "edit") {
            $video_slug_count = Video::where("id", $request->video_id)
                ->where("slug", $request->slug)
                ->count();

            if ($video_slug_count == 1) {
                $validate_status = $video_slug_validate > 1 ? "true" : "false";
            } else {
                $validate_status = $video_slug_validate > 0 ? "true" : "false";
            }
        }
        return response()->json(["message" => $validate_status]);
    }

    public function ChannelVideosIndex()
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
            $videos = Video::where("active", "=", 1)
                ->orderBy("created_at", "DESC")
                ->paginate(9);

            $videocategories = VideoCategory::select("id", "image")
                ->get()
                ->toArray();
            $myData = [];
            foreach ($videocategories as $key => $videocategory) {
                $videocategoryid = $videocategory["id"];
                $videos = Video::where("videos.active", "=", 0)
                    ->join("channels", "videos.user_id", "=", "channels.id")
                    ->select("channels.channel_name", "videos.*")
                    // ->groupby("videos.id")
                    ->where("videos.uploaded_by", "Channel")
                    ->orderBy("videos.created_at", "DESC")
                    ->paginate(9);
            }
            $data = [
                "videos" => $videos,
            ];
            // dd($data);
            return View(
                "admin.videos.videoapproval.approval_channel_video",
                $data
            );
        }
    }
    public function ChannelVideosApproval($id)
    {
        //    echo "<pre>";
        //    print_r($id);
        //    exit();

        $video = Video::findOrFail($id);
        $video->status = 1;
        $video->active = 1;
        $video->draft = 1;
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

        return Redirect::back()->with(
            "message",
            "Your video will be available shortly after we process it"
        );
    }

    public function ChannelVideosReject($id)
    {
        $video = Video::findOrFail($id);
        $video->active = 2;
        $video->save();

        $settings = Setting::first();
        $user_id = $video->user_id;
        $Channel = Channel::findOrFail($video->user_id);
        try {
            \Mail::send('emails.admin_channel_rejected', array(
                'website_name' => $settings->website_name,
                'Channel' => $Channel
            ) , function ($message) use ($Channel)
            {
                $message->from(AdminMail() , GetWebsiteName());
                $message->to($Channel->email, $Channel->channel_name)
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


        return Redirect::back()->with(
            "message",
            "Your video will be available shortly after we process it"
        );
    }

    public function filedelete($id)
    {
        $video = Video::findOrFail($id);
        $filename = $video->path . ".mp4";
        $path = storage_path("app/public/" . $filename);

        if (file_exists($path)) {
            unlink($path);
        } else {
        }
        return Redirect::back()->with(
            "message",
            "Your video will be available shortly after we process it"
        );
    }

    public function PurchasedVideoAnalytics()
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
            return view('admin.expired_dashboard', $data);
        }else if(check_storage_exist() == 0){
          $settings = Setting::first();

          $data = array(
              'settings' => $settings,
          );

          return View::make('admin.expired_storage', $data);
      }else{
            $user_package = User::where("id", 1)->first();
            $package = $user_package->package;
            if (
                (!empty($package) && $package == "Pro") ||
                (!empty($package) && $package == "Business")
            ) {
                $settings = Setting::first();
                $total_content = Video::join(
                    "ppv_purchases",
                    "ppv_purchases.video_id",
                    "=",
                    "videos.id"
                )
                    ->join("users", "users.id", "=", "ppv_purchases.user_id")
                    ->groupBy("ppv_purchases.id")

                    ->get([
                        \DB::raw("videos.*"),
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
                // dd($total_content);
                $total_contentss = $total_content->groupBy("month_name");
                $total_content = Video::join('ppv_purchases', 'ppv_purchases.video_id', '=', 'videos.id')
                ->join('users', 'users.id', '=', 'ppv_purchases.user_id')
                ->select(
                    DB::raw('videos.*'),
                    DB::raw('users.username'),
                    DB::raw('users.email'),
                    DB::raw('SUM(ppv_purchases.total_amount) as total_amount'),  
                    DB::raw('COUNT(ppv_purchases.id) as purchase_count'),       
                    DB::raw('ppv_purchases.created_at as ppvcreated_at'),
                    DB::raw('MONTHNAME(ppv_purchases.created_at) as month_name')
                )
                ->groupBy('videos.id', 'users.id', 'month_name') 
                ->orderBy('purchase_count', 'desc')
                ->get();
            
            // Output the result
            // dd($total_content);
                // dd($total_content);

                $data = [
                    "settings" => $settings,
                    "total_content" => $total_content,
                    "total_video_count" => count($total_content),
                    "total_contentss" => $total_contentss,
                    "currency" => CurrencySetting::first(),
                ];
                return view("admin.analytics.purchased_video_analytics", $data);
            } else {
                return Redirect::to("/blocked");
            }
        }
    }

    public function PurchasedVideoStartDateRevenue(Request $request)
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

                $total_content = Video::join('ppv_purchases', 'ppv_purchases.video_id', '=', 'videos.id')
                ->join('users', 'users.id', '=', 'ppv_purchases.user_id')
                ->select(
                    DB::raw('videos.*'),
                    DB::raw('users.username'),
                    DB::raw('users.email'),
                    DB::raw('SUM(ppv_purchases.total_amount) as total_amount'),  
                    DB::raw('COUNT(ppv_purchases.id) as purchase_count'),       
                    DB::raw('ppv_purchases.created_at as ppvcreated_at'),
                    DB::raw('MONTHNAME(ppv_purchases.created_at) as month_name')
                )
                ->groupBy('videos.id', 'users.id', 'month_name') 
                ->orderBy('purchase_count', 'desc')
                ->whereDate("ppv_purchases.created_at", ">=", $start_time)
                ->get();

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
                            $row->slug .
                            '</td>     
                      <td>' .
                            $currency->symbol .
                            " " .
                            $row->total_amount .
                            '</td>    
                    <td>' .
                            $row->purchase_count .
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

    public function PurchasedVideoEndDateRevenue(Request $request)
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
                $total_content = Video::join('ppv_purchases', 'ppv_purchases.video_id', '=', 'videos.id')
                ->join('users', 'users.id', '=', 'ppv_purchases.user_id')
                ->select(
                    DB::raw('videos.*'),
                    DB::raw('users.username'),
                    DB::raw('users.email'),
                    DB::raw('SUM(ppv_purchases.total_amount) as total_amount'),  
                    DB::raw('COUNT(ppv_purchases.id) as purchase_count'),       
                    DB::raw('ppv_purchases.created_at as ppvcreated_at'),
                    DB::raw('MONTHNAME(ppv_purchases.created_at) as month_name')
                )
                ->groupBy('videos.id', 'users.id', 'month_name') 
                ->orderBy('purchase_count', 'desc')
                ->whereBetween("ppv_purchases.created_at", [
                  $start_time,
                  $end_time,
                ])
                ->get();
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
                            $row->slug .
                            '</td>           
                      <td>' .
                            $currency->symbol .
                            " " .
                            $row->total_amount .
                            '</td>    
                    <td>' .
                            $row->purchase_count .
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

    public function PurchasedVideoExportCsv(Request $request)
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
                    $total_content = Video::join('ppv_purchases', 'ppv_purchases.video_id', '=', 'videos.id')
                        ->join('users', 'users.id', '=', 'ppv_purchases.user_id')
                        ->select(
                            DB::raw('videos.*'),
                            DB::raw('users.username'),
                            DB::raw('users.email'),
                            DB::raw('SUM(ppv_purchases.total_amount) as total_amount'),  
                            DB::raw('COUNT(ppv_purchases.id) as purchase_count'),       
                            DB::raw('ppv_purchases.created_at as ppvcreated_at'),
                            DB::raw('MONTHNAME(ppv_purchases.created_at) as month_name')
                        )
                        ->groupBy('videos.id', 'users.id', 'month_name') 
                        ->orderBy('purchase_count', 'desc')
                        ->whereDate("videos.created_at", ">=", $start_time)

                        ->get();

            } elseif (!empty($start_time) && !empty($end_time)) {
                $total_content = Video::join('ppv_purchases', 'ppv_purchases.video_id', '=', 'videos.id')
                ->join('users', 'users.id', '=', 'ppv_purchases.user_id')
                ->select(
                    DB::raw('videos.*'),
                    DB::raw('users.username'),
                    DB::raw('users.email'),
                    DB::raw('SUM(ppv_purchases.total_amount) as total_amount'),  
                    DB::raw('COUNT(ppv_purchases.id) as purchase_count'),       
                    DB::raw('ppv_purchases.created_at as ppvcreated_at'),
                    DB::raw('MONTHNAME(ppv_purchases.created_at) as month_name')
                )
                ->groupBy('videos.id', 'users.id', 'month_name') 
                ->orderBy('purchase_count', 'desc')
                ->whereBetween("ppv_purchases.created_at", [
                  $start_time,
                  $end_time,
                ])
                ->get();
            } else {
                $total_content = Video::join('ppv_purchases', 'ppv_purchases.video_id', '=', 'videos.id')
                ->join('users', 'users.id', '=', 'ppv_purchases.user_id')
                ->select(
                    DB::raw('videos.*'),
                    DB::raw('users.username'),
                    DB::raw('users.email'),
                    DB::raw('SUM(ppv_purchases.total_amount) as total_amount'),  
                    DB::raw('COUNT(ppv_purchases.id) as purchase_count'),       
                    DB::raw('ppv_purchases.created_at as ppvcreated_at'),
                    DB::raw('MONTHNAME(ppv_purchases.created_at) as month_name')
                )
                ->groupBy('videos.id', 'users.id', 'month_name') 
                ->orderBy('purchase_count', 'desc')
                ->get();
            }
            $file = "PurchasedVideoAnalytics.csv";

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
                "Video Name",
                "Video Slug",
                "Amount",
                "Purchased Count",
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
                        $each_user->slug,
                        $each_user->total_amount,
                        $each_user->purchase_count,
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

    public function ScheduleVideo(Request $request)
    {
        $VideoSchedules = VideoSchedules::get();
        $settings = Setting::first();
        $TimeZone = TimeZone::get();

        $data = [
            "settings" => $settings,
            "VideoSchedules" => $VideoSchedules,
            "TimeZone" => $TimeZone,

        ];
        return view("admin.schedule.video_schedule", $data);
    }

    public function ScheduleStore(Request $request)
    {
        $data = $request->all();
        

        $image = isset($data["image"]) ? $data["image"] : "";
        $player_image = isset($data["player_image"]) ? $data["player_image"] : "";

        $path = public_path() . "/uploads/videos/";
        $image_path = public_path() . "/uploads/images/";
        $image_url = URL::to('public/uploads/images');

        if ($image != "") {
            //code for remove old file
            if ($image != "" && $image != null) {
                $file_old = $image_path . $image;
                if (file_exists($file_old)) {
                    unlink($file_old);
                }
            }
            //upload new file
            $file = $image;
            $image = $image_url.'/'.str_replace(" ","_",$file->getClientOriginalName());

            $file->move($image_path, $image);
        } else {
            $image = "default.jpg";
        }


        if ($player_image != "") {
            //code for remove old file
            if ($player_image != "" && $player_image != null) {
                $file_old = $image_path . $player_image;
                if (file_exists($file_old)) {
                    unlink($file_old);
                }
            }
            //upload new file
            $file = $player_image;
            $player_image = $image_url.'/'.str_replace(" ","_",$file->getClientOriginalName());

            $file->move($image_path, $player_image);
        } else {
            $player_image = "default.jpg";
        }
        if(!empty($data['in_home'])){
            $in_home = 1;
        }else{
            $in_home = 0;
        }
        if ( $request["name"] != '') {
            $slug =  str_replace(' ', '_',  $request['name']);
        } else {
            $slug  = str_replace(' ', '_', $request['name']);
        }
        $Schedules = new VideoSchedules();
        $Schedules->name = $request["name"];
        $Schedules->slug = str_replace(' ', '_', $request['name']);
        $Schedules->description = $request["description"];
        $Schedules->image = $image;
        $Schedules->player_image = $player_image;
        $Schedules->in_home = $in_home;
        $Schedules->user_id = Auth::user()->id;
        $Schedules->save();

        return Redirect::back()->with([
            "note" => "You have been successfully Added New Schedules",
            "note_type" => "success",
        ]);
    }

    public function ScheduleEdit($id)
    {
        $VideoSchedules = VideoSchedules::get();
        $settings = Setting::first();

        $VideoSchedules = VideoSchedules::where("id", "=", $id)->first();

        $data = [
            "schedule" => $VideoSchedules,
        ];
        //    dd($VideoSchedules);
        return view("admin.schedule.videoEdit_schedule", $data);
    }

    public function ScheduleDelete($id)
    {

        SiteVideoScheduler::where('channe_id', $id)->delete();
        DefaultSchedulerData::where('channe_id', $id)->delete();
        VideoSchedules::where("id", $id)->delete();

        return Redirect::back()->with([
            "note" => "You have been successfully Added New Coupon",
            "note_type" => "success",
        ]);
    }

    public function ScheduleUpdate(Request $request)
    {
        $input = $request->all();
        $id = $request["id"];
        $Schedules = VideoSchedules::find($id);
        if(!empty($input['in_home'])){
            $in_home = 1;
        }else{
            $in_home = 0;
        }
        // dd();

        $image = isset($input["image"]) ? $input["image"] : "";
        $player_image = isset($input["player_image"]) ? $input["player_image"] : "";

        $path = public_path() . "/uploads/videos/";
        $image_path = public_path() . "/uploads/images/";
        $image_url = URL::to('public/uploads/images');

        if ($image != "") {
            //code for remove old file
            if ($image != "" && $image != null) {
                $file_old = $image_path . $image;
                if (file_exists($file_old)) {
                    unlink($file_old);
                }
            }
            //upload new file
            $file = $image;
            $image = $image_url.'/'.str_replace(" ","_",$file->getClientOriginalName());

            $file->move($image_path, $image);

        // dd( $image);

        } else {
            $image = $Schedules->image;
        }
        if ($player_image != "") {
            //code for remove old file
            if ($player_image != "" && $player_image != null) {
                $file_old = $image_path . $player_image;
                if (file_exists($file_old)) {
                    unlink($file_old);
                }
            }
            //upload new file
            $file = $player_image;
            $player_image = $image_url.'/'.str_replace(" ","_",$file->getClientOriginalName());

            $file->move($image_path, $player_image);
        } else {
            $player_image = $Schedules->player_image;
        }
        if ( $request["name"] != '') {
            $slug =  str_replace(' ', '_',  $request['name']);
        } else {
            $slug  = str_replace(' ', '_', $request['name']);
        }
        $Schedules->name = $request["name"];
        $Schedules->slug = $slug;
        $Schedules->description = $request["description"];
        $Schedules->image = $image;
        $Schedules->player_image = $player_image;
        $Schedules->in_home = $in_home;
        $Schedules->user_id = Auth::user()->id;
        $Schedules->save();

        return Redirect::back()->with([
            "note" => "You have been successfully Added New Coupon",
            "note_type" => "success",
        ]);
    }

    public function ManageSchedule($id)
    {

        $enable_default_timezone = SiteTheme::pluck('enable_default_timezone')->first();

            if($enable_default_timezone == 1){

                
                $Channels =  VideoSchedules::where('id',$id)->Select('id','name','slug')->get();

                // $TimeZone = TimeZone::whereIn('id',[8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25])->get();
                $TimeZone = TimeZone::get();

                $default_time_zone = Setting::pluck('default_time_zone')->first();
                
                $enable_default_timezone = SiteTheme::pluck('enable_default_timezone')->first();
                
                $utc_difference = $enable_default_timezone == 1 ? TimeZone::where('time_zone',$default_time_zone)->pluck('utc_difference')->first()  : '' ;
                
                $time_zoneid = $enable_default_timezone == 1 ? TimeZone::where('time_zone',$default_time_zone)->pluck('id')->first()  : '' ;
            
                $videos = Video::where('active',1)->where('status',1)->orderBy('created_at', 'DESC')->get()->map(function ($item) {
                    $item['socure_type'] = 'Video';
                    return $item;
                });
                $episodes = Episode::where('active',1)->where('status',1)->orderBy('created_at', 'DESC')->get()->map(function ($item) {
                    $item['socure_type'] = 'Episode';
                    return $item;
                });
                $livestreams = LiveStream::where('active',1)->where('status',1)->orderBy('created_at', 'DESC')->get()->map(function ($item) {
                    $item['socure_type'] = 'LiveStream';
                    return $item;
                });

                $mergedCollection = $videos
                ->concat($episodes)
                ->concat($livestreams)
                ->values();
                //   dd($mergedCollection);
                
                $perPage = 3; // Adjust the number based on your requirement
                $currentPage = request()->get('page', 1); // Get the current page from the request or default to 1
                $paginator = new LengthAwarePaginator(
                    $mergedCollection->forPage($currentPage, $perPage),
                    $mergedCollection->count(),
                    $perPage,
                    $currentPage
                );
                
                $VideoSchedules = VideoSchedules::get();
                $settings = Setting::first();
    
                $VideoSchedules = VideoSchedules::where("id", "=", $id)->first();

                $data = array(
                
                    'Channels' => $Channels  ,
                    'TimeZone' => $TimeZone  ,
                    'default_time_zone' => $default_time_zone  ,
                    'enable_default_timezone' => $enable_default_timezone  ,
                    'utc_difference' => $utc_difference  ,
                    // 'VideoCollection' => $paginator  ,
                    'time_zoneid' => $time_zoneid  ,
                    'VideoCollection' => $mergedCollection  ,
                    'VideoSchedules' => $VideoSchedules  ,
                );            

            return view("admin.schedule.VideoSchedulerEpg", $data);

        }else{

            $VideoSchedules = VideoSchedules::get();
            $settings = Setting::first();

            $VideoSchedules = VideoSchedules::where("id", "=", $id)->first();
            $TimeZone = TimeZone::get();

            $data = [
                "schedule" => $VideoSchedules,
                "settings" => $settings,
                "TimeZone" => $TimeZone,
            ];
            //    dd($VideoSchedules);
            return view("admin.schedule.manage_schedule", $data);
        }

    }

    public function CalendarSchedule(Request $request)
    {
        $data = $request->all();
        $id = $data["schedule_id"];
        // dd($data);
        $VideoSchedules = VideoSchedules::where("id", "=", $id)->first();
        $Video = ScheduleVideos::get();
        $Videos = [];
        foreach($Video as $value){
            $Videos = Video::where("title",'!=',$value->title)->get();
        }

        if(count($Videos) > 0){
           $Videos_list = $Videos ;
        }else{
            $Videos_list = Video::get(); 
        }

        $settings = Setting::first();
        // dd($Videos);

        $choosed_date =
            $data["year"] . "-" . $data["month"] . "-" . $data["date"];

        $date = date_create($choosed_date);
        $date_choose = date_format($date, "Y/m");
        $date_choosed = $date_choose . "/" . str_pad($data["date"], 2, '0', STR_PAD_LEFT);
        
        $d = new \DateTime("now");
        $d->setTimezone(new \DateTimeZone("Asia/Kolkata"));
        $now = $d->format("Y-m-d h:i:s a");
        $current_time = date("A", strtotime($now));

        date_default_timezone_set($settings->default_time_zone);
        $now = date("Y-m-d h:i:s a", time());
        $current_time = date("A", time());

        // dd($date_choosed);
        $ScheduledVideo = ScheduleVideos::where(
            "shedule_date",
            "=",
            $date_choosed
        )
            ->orderBy("id", "desc")
            ->get();

        $TimeZone = TimeZone::get();


        $data = [
            "schedule" => $VideoSchedules,
            "settings" => $settings,
            "Calendar" => $data,
            "Video" => $Videos_list,
            "ScheduledVideo" => $ScheduledVideo,
            "current_time" => $current_time,
            "TimeZone" => $TimeZone,
        ];
        //    dd($current_time);
        return view("admin.schedule.schedule_videos", $data);
    }

    public function ScheduleUploadFile(Request $request)
    {
        $value = [];
        $data = $request->all();
        // echo "<pre>";
        // print_r($data);exit();
        $validator = Validator::make($request->all(), [
            "file" => "required|mimes:video/mp4,video/x-m4v,video/*",
        ]);
        $mp4_url = isset($data["file"]) ? $data["file"] : "";

        $path = public_path() . "/uploads/videos/";

        $file = $request->file->getClientOriginalName();
        $newfile = explode(".mp4", $file);
        $file_folder_name = $newfile[0];

        $package = User::where("id", 1)->first();
        $pack = $package->package;
        $mp4_url = $data["file"];
        $settings = Setting::first();

        $date = $data["date"];
        $month = $data["month"];
        $year = $data["year"];
        $schedule_time = $data["schedule_time"];
        $schedule_id = $data["schedule_id"];
        $time_zone = $data["time_zone"];


        if (!empty($schedule_time)) {
            $choose_time = explode("to", $schedule_time);
            if (count($choose_time) > 0) {
                $choose_start_time = $choose_time[0];
                $choose_end_time = $choose_time[1];
            } else {
                $choose_start_time = "";
                $choose_end_time = "";
            }
            
            // $d = new \DateTime("now");
            // $d->setTimezone(new \DateTimeZone("Asia/Kolkata"));
            // $now = $d->format("Y-m-d h:i:s a");
            // $current_time = date("h:i A", strtotime($now));

            // date_default_timezone_set('Asia/Kolkata');
            date_default_timezone_set($time_zone);
            $now = date("Y-m-d h:i:s a", time());
            $current_time = date("h:i A ", time());

            $Schedule_current_date = date("Y-m-d");

            $schedule_id = $data["schedule_id"];
            $choosed_date = $year . "-" . $month . "-" . $date;

            $date = date_create($choosed_date);
            $date_choose = date_format($date, "Y/m");
            $date_choosed = $date_choose . "/" . str_pad($data["date"], 2, '0', STR_PAD_LEFT);

            
            $now = date("Y-m-d h:i:s a");
            $current_time = date("h:i A");

            $currentDate = date("Y/m/d");

    //    echo "<pre>";
    //     print_r($current_time);exit();
            if($current_time < $choose_start_time && $currentDate == $date_choosed){
                $choose_current_time =  explode(":", date("h:i", strtotime($now)));
            }else {
                $choose_current_time =  explode(":", date("h:i", strtotime($choose_start_time)));
            }
            // dd($choose_current_time);
            if($current_time < $choose_start_time && $currentDate == $date_choosed){
                $store_current_time =  date("h:i", strtotime($now));
            }else {
                $store_current_time =  date("h:i", strtotime($choose_start_time));
            }
        }
        // $choosed_date =
        // $data["year"] . "-" . $data["month"] . "-" . $data["date"];

        // $date = date_create($choosed_date);
        // $date_choose = date_format($date, "Y/m");
        // $date_choosed = $date_choose . "/" . $data["date"];


        if ($mp4_url != "" && $pack != "Business") {
            // print_r('1');exit();
            $date = $data["date"];
            $month = $data["month"];
            $year = $data["year"];
            $schedule_time = $data["schedule_time"];
            // $choose_start_time = $data['choose_start_time'];
            // $choose_end_time = $data['choose_end_time'];
            if (!empty($schedule_time)) {
                $choose_time = explode("to", $schedule_time);
                // echo "<pre>";print_r($choose_time);exit;
                if (count($choose_time) > 0) {
                    $choose_start_time = $choose_time[0];
                    $choose_end_time = $choose_time[1];
                } else {
                    $choose_start_time = "";
                    $choose_end_time = "";
                }

                $Schedule_current_date = date("Y-m-d");
                $time_zone = $data["time_zone"];

                $schedule_id = $data["schedule_id"];
                $choosed_date = $year . "-" . $month . "-" . $date;

                $date = date_create($choosed_date);
                $date_choose = date_format($date, "Y/m");
                $date_choosed = $date_choose . "/" . str_pad($data["date"], 2, '0', STR_PAD_LEFT);
                // echo "<pre>";print_r($date_choosed);exit;

                $choosedtime_exitvideos = ScheduleVideos::selectRaw("*")
                    ->where("shedule_date", "=", $date_choosed)
                    ->whereBetween("choose_start_time", [
                        $choose_start_time,
                        $choose_end_time,
                    ])
                    ->orderBy("id", "desc")
                    ->first();

                $ScheduleVideos = ScheduleVideos::where(
                    "shedule_date",
                    "=",
                    $date_choosed
                )
                    ->orderBy("id", "desc")
                    ->first();

                $rand = Str::random(16);
                $path =
                    $rand . "." . $request->file->getClientOriginalExtension();

                $request->file->storeAs("public", $path);
                $thumb_path = "public";
                $original_name = $request->file->getClientOriginalName()
                    ? $request->file->getClientOriginalName()
                    : "";
                $storepath = URL::to("/storage/app/public/" . $path);
                //  Video duration
                $getID3 = new getID3();
                $Video_storepath = storage_path("app/public/" . $path);
                $VideoInfo = $getID3->analyze($Video_storepath);
                $Video_duration = $VideoInfo["playtime_seconds"];

                // DateTime();
                $current_date = $current_date = date("Y-m-d h:i:s a", time());
                $current_date = date("Y-m-d h:i:s");
                $daten = date("Y-m-d h:i:s ", time());

                date_default_timezone_set($time_zone);
                $now = date("Y-m-d h:i:s a", time());
                $current_time = date("h:i A", time());
                // print_r($choosedtime_exitvideos);exit;

                if (!empty($ScheduleVideos) && empty($choosedtime_exitvideos)) {
                    // print_r('ScheduleVideos');exit;

                    $last_shedule_endtime = $ScheduleVideos->shedule_endtime;
                    $last_current_time = $ScheduleVideos->current_time;
                    $last_sheduled_endtime = $ScheduleVideos->sheduled_endtime;

                    if ($last_shedule_endtime < $current_time) {
                        $time = $choose_current_time;
                        $minutes = $time[0] * 60.0 + $time[1] * 1.0;
                        $totalSecs = $minutes * 60;
                        $sec = $totalSecs + $Video_duration;
                        $hour = floor($sec / 3600);
                        $minute = floor(($sec / 60) % 60);
                        $hours = str_pad($hour, 2, "0", STR_PAD_LEFT);
                        $minutes = str_pad($minute, 2, "0", STR_PAD_LEFT);

                        $shedule_endtime =
                            $hours .
                            ":" .
                            $minutes .
                            " " .
                            date("A", strtotime($now));
                        $sheduled_endtime = $hours . ":" . $minutes;

                        // print_r($last_shedule_endtime);exit;
                        $starttime = date("h:i ", strtotime($store_current_time));
                        $sheduled_starttime = date("h:i A", strtotime($store_current_time));
                    } else {
                        $time = explode(":", $last_sheduled_endtime);
                        $minutes = $time[0] * 60.0 + $time[1] * 1.0;
                        $totalSecs = $minutes * 60;
                        $sec = $totalSecs + $Video_duration;
                        // $sec = 45784.249244444;
                        $hour = floor($sec / 3600);
                        $minute = floor(($sec / 60) % 60);
                        $hours = str_pad($hour, 2, "0", STR_PAD_LEFT);
                        $minutes = str_pad($minute, 2, "0", STR_PAD_LEFT);

                        $shedule_endtime =
                            $hours .
                            ":" .
                            $minutes .
                            " " .
                            date("A", strtotime($now));
                        $sheduled_endtime = $hours . ":" . $minutes;

                        $starttime = $last_sheduled_endtime;
                        $sheduled_starttime = $last_shedule_endtime;
                    }
                    $time_zone = $data["time_zone"];

                    $video = new ScheduleVideos();
                    $video->title = $file_folder_name;
                    $video->type = "mp4_url";
                    $video->active = 1;
                    $video->original_name = "public";
                    $video->disk = "public";
                    $video->mp4_url = $storepath;
                    $video->path = $path;
                    $video->shedule_date = $date_choosed;
                    $video->shedule_time = $schedule_time;
                    $video->shedule_endtime = $shedule_endtime;
                    $video->sheduled_endtime = $sheduled_endtime;
                    $video->current_time = date("h:i A", strtotime($now));
                    $video->video_order = 1;
                    $video->schedule_id = $schedule_id;
                    $video->starttime = $starttime;
                    $video->sheduled_starttime = $sheduled_starttime;
                    $video->starttime = $last_sheduled_endtime;
                    $video->choose_start_time = $choose_start_time;
                    $video->choose_end_time = $choose_end_time;
                    $video->time_zone  = $time_zone ;
                    $video->status = 1;
                    $video->save();

                    $video_id = $video->id;
                    $video_title = ScheduleVideos::find($video_id);
                    $title = $video_title->title;

                    $choosed_date =
                        $data["year"] .
                        "-" .
                        $data["month"] .
                        "-" .
                        $data["date"];

                    $date = date_create($choosed_date);
                    $date_choose = date_format($date, "Y/m");
                    $date_choosed = $date_choose . "/" . str_pad($data["date"], 2, '0', STR_PAD_LEFT);

                    // print_r($date_choosed);exit;
                    $total_content = ScheduleVideos::where(
                        "shedule_date",
                        "=",
                        $date_choosed
                    )
                        ->orderBy("id", "desc")
                        ->get();

                    $output = "";
                    $i = 1;
                    if (count($total_content) > 0) {
                        $total_row = $total_content->count();
                        if (!empty($total_content)) {
                            $currency = CurrencySetting::first();

                            foreach ($total_content as $key => $row) {
                                $output .=
                                    '
                  <tr>
                  <td>' . '#' .'</td>

                  <td>' .
                                    $i++ .
                                    '</td>
                  <td>' .
                                    $row->title .
                                    '</td>
                  <td>' .
                                    $row->type .
                                    '</td>  
                  <td>' .
                                    $row->shedule_date .
                                    '</td>       
                  <td>' .
                                    $row->sheduled_starttime .
                                    '</td>    

                  <td>' .
                                    $row->shedule_endtime .
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
                    }

                    $value["success"] = 1;
                    $value["message"] = "Uploaded Successfully!";
                    $value["video_id"] = $video_id;
                    $value["video_title"] = $title;
                    $value["table_data"] = $output;
                    $value["total_data"] = $total_row;
                    $value["total_content"] = $total_content;

                    return $value;
                } elseif (
                    !empty($ScheduleVideos) &&
                    !empty($choosedtime_exitvideos)
                ) {
                    // print_r($ScheduleVideos);exit;
                    $last_shedule_endtime =
                        $choosedtime_exitvideos->shedule_endtime;
                    $last_current_time = $choosedtime_exitvideos->current_time;
                    $last_sheduled_endtime =
                        $choosedtime_exitvideos->sheduled_endtime;

                    if ($last_shedule_endtime < $current_time) {
                        $time = $choose_current_time;
                        $minutes = $time[0] * 60.0 + $time[1] * 1.0;
                        $totalSecs = $minutes * 60;
                        $sec = $totalSecs + $Video_duration;
                        $hour = floor($sec / 3600);
                        $minute = floor(($sec / 60) % 60);
                        $hours = str_pad($hour, 2, "0", STR_PAD_LEFT);
                        $minutes = str_pad($minute, 2, "0", STR_PAD_LEFT);

                        $shedule_endtime =
                            $hours .
                            ":" .
                            $minutes .
                            " " .
                            date("A", strtotime($now));
                        $sheduled_endtime = $hours . ":" . $minutes;

                        // print_r($last_shedule_endtime);exit;
                        $starttime = date("h:i ", strtotime($store_current_time));
                        $sheduled_starttime = date("h:i A", strtotime($store_current_time));
                    } else {
                        $time = explode(":", $last_sheduled_endtime);
                        $minutes = $time[0] * 60.0 + $time[1] * 1.0;
                        $totalSecs = $minutes * 60;
                        $sec = $totalSecs + $Video_duration;
                        // $sec = 45784.249244444;
                        $hour = floor($sec / 3600);
                        $minute = floor(($sec / 60) % 60);
                        $hours = str_pad($hour, 2, "0", STR_PAD_LEFT);
                        $minutes = str_pad($minute, 2, "0", STR_PAD_LEFT);

                        $shedule_endtime =
                            $hours .
                            ":" .
                            $minutes .
                            " " .
                            date("A", strtotime($now));
                        $sheduled_endtime = $hours . ":" . $minutes;
                        // print_r($sheduled_endtime);exit;
                        $starttime = $last_sheduled_endtime;
                        $sheduled_starttime = $last_shedule_endtime;
                    }
                    $time_zone = $data["time_zone"];

                    $video = new ScheduleVideos();
                    $video->title = $file_folder_name;
                    $video->type = "mp4_url";
                    $video->active = 1;
                    $video->original_name = "public";
                    $video->disk = "public";
                    $video->mp4_url = $storepath;
                    $video->path = $path;
                    $video->shedule_date = $date_choosed;
                    $video->shedule_time = $schedule_time;
                    $video->shedule_endtime = $shedule_endtime;
                    $video->sheduled_endtime = $sheduled_endtime;
                    $video->current_time = date("h:i A", strtotime($now));
                    $video->video_order = 1;
                    $video->schedule_id = $schedule_id;
                    $video->starttime = $starttime;
                    $video->sheduled_starttime = $sheduled_starttime;
                    $video->duration = $Video_duration;
                    $video->choose_start_time = $choose_start_time;
                    $video->choose_end_time = $choose_end_time;
                    $video->status = 1;
                    $video->time_zone  = $time_zone ;
                    $video->save();

                    $video_id = $video->id;
                    $video_title = ScheduleVideos::find($video_id);
                    $title = $video_title->title;

                    $choosed_date =
                        $data["year"] .
                        "-" .
                        $data["month"] .
                        "-" .
                        $data["date"];

                    $date = date_create($choosed_date);
                    $date_choose = date_format($date, "Y/m");
                    $date_choosed = $date_choose . "/" . str_pad($data["date"], 2, '0', STR_PAD_LEFT);

                    // print_r($date_choosed);exit;
                    $total_content = ScheduleVideos::where(
                        "shedule_date",
                        "=",
                        $date_choosed
                    )
                        ->orderBy("id", "desc")
                        ->get();

                    $output = "";
                    $i = 1;
                    if (count($total_content) > 0) {
                        $total_row = $total_content->count();
                        if (!empty($total_content)) {
                            $currency = CurrencySetting::first();

                            foreach ($total_content as $key => $row) {
                                $output .=
                                    '
                  <tr>
                  <td>' . '#' .'</td>

                  <td>' .
                                    $i++ .
                                    '</td>
                  <td>' .
                                    $row->title .
                                    '</td>
                  <td>' .
                                    $row->type .
                                    '</td>  
                  <td>' .
                                    $row->shedule_date .
                                    '</td>       
                  <td>' .
                                    $row->sheduled_starttime .
                                    '</td>    

                  <td>' .
                                    $row->shedule_endtime .
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
                    }

                    $value["success"] = 1;
                    $value["message"] = "Uploaded Successfully!";
                    $value["video_id"] = $video_id;
                    $value["video_title"] = $title;
                    $value["table_data"] = $output;
                    $value["total_data"] = $total_row;
                    $value["total_content"] = $total_content;

                    return $value;
                } else {
                    $time = $choose_current_time;
                    $minutes = $time[0] * 60.0 + $time[1] * 1.0;
                    $totalSecs = $minutes * 60;
                    $sec = $totalSecs + $Video_duration;

                    $hour = floor($sec / 3600);
                    $minute = floor(($sec / 60) % 60);
                    $hours = str_pad($hour, 2, "0", STR_PAD_LEFT);
                    $minutes = str_pad($minute, 2, "0", STR_PAD_LEFT);

                    $shedule_endtime =
                        $hours .
                        ":" .
                        $minutes .
                        " " .
                        date("A", strtotime($now));
                    $sheduled_endtime = $hours . ":" . $minutes;
                    $starttime = date("h:i A", strtotime($store_current_time));
                    $sheduled_starttime = date("h:i ", strtotime($store_current_time));
                    $time_zone = $data["time_zone"];

                    $video = new ScheduleVideos();
                    $video->title = $file_folder_name;
                    $video->type = "mp4_url";
                    $video->active = 1;
                    $video->original_name = "public";
                    $video->disk = "public";
                    $video->mp4_url = $storepath;
                    $video->path = $path;
                    $video->shedule_date = $date_choosed;
                    $video->shedule_time = $schedule_time;
                    $video->shedule_endtime = $shedule_endtime;
                    $video->sheduled_endtime = $sheduled_endtime;
                    $video->current_time = date("h:i A", strtotime($now));
                    $video->starttime = $starttime;
                    $video->sheduled_starttime = $sheduled_starttime;
                    $video->video_order = 1;
                    $video->schedule_id = $schedule_id;
                    $video->duration = $Video_duration;
                    $video->choose_start_time = $choose_start_time;
                    $video->choose_end_time = $choose_end_time;
                    $video->status = 1;
                    $video->time_zone  = $time_zone ;
                    $video->save();

                    $video_id = $video->id;
                    $video_title = ScheduleVideos::find($video_id);
                    $title = $video_title->title;

                    $choosed_date =
                        $data["year"] .
                        "-" .
                        $data["month"] .
                        "-" .
                        $data["date"];

                    $date = date_create($choosed_date);
                    $date_choose = date_format($date, "Y/m");
                    $date_choosed = $date_choose . "/" . str_pad($data["date"], 2, '0', STR_PAD_LEFT);

                    // print_r($date_choosed);exit;
                    $total_content = ScheduleVideos::where(
                        "shedule_date",
                        "=",
                        $date_choosed
                    )
                        ->orderBy("id", "desc")
                        ->get();

                    $output = "";
                    $i = 1;
                    if (count($total_content) > 0) {
                        $total_row = $total_content->count();
                        if (!empty($total_content)) {
                            $currency = CurrencySetting::first();

                            foreach ($total_content as $key => $row) {
                                $output .=
                                    '
                  <tr>
                  <td>' . '#' .'</td>

                  <td>' .
                                    $i++ .
                                    '</td>
                  <td>' .
                                    $row->title .
                                    '</td>
                  <td>' .
                                    $row->type .
                                    '</td>  
                  <td>' .
                                    $row->shedule_date .
                                    '</td>       
                  <td>' .
                                    $row->sheduled_starttime .
                                    '</td>    

                  <td>' .
                                    $row->shedule_endtime .
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
                    }

                    $value["success"] = 1;
                    $value["message"] = "Uploaded Successfully!";
                    $value["video_id"] = $video_id;
                    $value["video_title"] = $title;
                    $value["table_data"] = $output;
                    $value["total_data"] = $total_row;
                    $value["total_content"] = $total_content;

                    return $value;
                }
            } else {
                return "Please Choose Time";
            }
            
        } elseif (
            $mp4_url != "" &&
            $pack == "Business" &&
            $settings->transcoding_access == 1
        ) {
            $date = $data["date"];
            $month = $data["month"];
            $year = $data["year"];
            $schedule_time = $data["schedule_time"];

            if (!empty($schedule_time)) {
                $choose_time = explode("to", $schedule_time);
                if (count($choose_time) > 0) {
                    $choose_start_time = $choose_time[0];
                    $choose_end_time = $choose_time[1];
                } else {
                    $choose_start_time = "";
                    $choose_end_time = "";
                }
                
                // $d = new \DateTime("now");
                // $d->setTimezone(new \DateTimeZone("Asia/Kolkata"));
                // $now = $d->format("Y-m-d h:i:s a");
                // $current_time = date("h:i A", strtotime($now));
                $time_zone = $data["time_zone"];

                date_default_timezone_set($time_zone);
                $now = date("Y-m-d h:i:s a", time());
                $current_time = date("h:i A", time());

                $Schedule_current_date = date("Y-m-d");

                $schedule_id = $data["schedule_id"];
                $choosed_date = $year . "-" . $month . "-" . $date;
    
                $date = date_create($choosed_date);
                $date_choose = date_format($date, "Y/m");
                $date_choosed = $date_choose . "/" . str_pad($data["date"], 2, '0', STR_PAD_LEFT);
    
                
                $now = date("Y-m-d h:i:s a");
                $current_time = date("h:i A");
    
                $currentDate = date("Y/m/d");

                if($current_time < $choose_start_time && $currentDate == $date_choosed){
                    $choose_current_time =  explode(":", date("h:i", strtotime($now)));
                }else {
                    $choose_current_time =  explode(":", date("h:i", strtotime($choose_start_time)));
                }

                if($current_time < $choose_start_time && $currentDate == $date_choosed){
                    $store_current_time =  date("h:i", strtotime($now));
                }else {
                    $store_current_time =  date("h:i", strtotime($choose_start_time));
                }

                // $Schedule_current_date = date("Y-m-d");

                // $schedule_id = $data["schedule_id"];
                // $choosed_date = $year . "-" . $month . "-" . $date;

                // $date = date_create($choosed_date);
                // $date_choose = date_format($date, "Y/m");
                // $date_choosed = $date_choose . "/" . $data["date"];
                // echo "<pre>";print_r($date_choosed);exit;

                $choosedtime_exitvideos = ScheduleVideos::selectRaw("*")
                    ->where("shedule_date", "=", $date_choosed)
                    ->where("shedule_time", "=", $schedule_time)
                    // ->whereBetween('choose_start_time',[$choose_start_time, $choose_end_time])
                    ->orderBy("id", "desc")
                    ->first();
                // echo "<pre>";print_r($choosedtime_exitvideos);exit;

                $ScheduleVideos = ScheduleVideos::where(
                    "shedule_date",
                    "=",
                    $date_choosed
                )
                    ->orderBy("id", "desc")
                    ->first();

                $rand = Str::random(16);
                $path =
                    $rand . "." . $request->file->getClientOriginalExtension();

                $request->file->storeAs("public", $path);
                $thumb_path = "public";
                $original_name = $request->file->getClientOriginalName()
                    ? $request->file->getClientOriginalName()
                    : "";
                $storepath = URL::to("/storage/app/public/" . $path);
                //  Video duration
                $getID3 = new getID3();
                $Video_storepath = storage_path("app/public/" . $path);
                $VideoInfo = $getID3->analyze($Video_storepath);
                $Video_duration = $VideoInfo["playtime_seconds"];

                // DateTime();
                $current_date = $current_date = date("Y-m-d h:i:s a", time());
                $current_date = date("Y-m-d h:i:s");
                $daten = date("Y-m-d h:i:s ", time());
                // $d = new \DateTime("now");
                // $d->setTimezone(new \DateTimeZone("Asia/Kolkata"));
                // $now = $d->format("Y-m-d h:i:s a");
                // $current_time = date("h:i A", strtotime($now));
                $time_zone = $data["time_zone"];

                date_default_timezone_set($time_zone);
                $now = date("Y-m-d h:i:s a", time());
                $current_time = date("h:i A", time());

                // print_r($choosedtime_exitvideos);exit;

                if (!empty($ScheduleVideos) && empty($choosedtime_exitvideos)) {
                    // print_r('ScheduleVideos');exit;

                    $last_shedule_endtime = $ScheduleVideos->shedule_endtime;
                    $last_current_time = $ScheduleVideos->current_time;
                    $last_sheduled_endtime = $ScheduleVideos->sheduled_endtime;

                    if ($last_shedule_endtime < $current_time) {
                        $time = $choose_current_time;
                        $minutes = $time[0] * 60.0 + $time[1] * 1.0;
                        $totalSecs = $minutes * 60;
                        $sec = $totalSecs + $Video_duration;
                        $hour = floor($sec / 3600);
                        $minute = floor(($sec / 60) % 60);
                        $hours = str_pad($hour, 2, "0", STR_PAD_LEFT);
                        $minutes = str_pad($minute, 2, "0", STR_PAD_LEFT);

                        $shedule_endtime =
                            $hours .
                            ":" .
                            $minutes .
                            " " .
                            date("A", strtotime($now));
                        $sheduled_endtime = $hours . ":" . $minutes;

                        $starttime = date("h:i ", strtotime($store_current_time));
                        $sheduled_starttime = date("h:i A", strtotime($store_current_time));
                        // print_r($last_shedule_endtime);exit;
                    } else {
                        $time = explode(":", $last_sheduled_endtime);
                        $minutes = $time[0] * 60.0 + $time[1] * 1.0;
                        $totalSecs = $minutes * 60;
                        $sec = $totalSecs + $Video_duration;
                        // $sec = 45784.249244444;
                        $hour = floor($sec / 3600);
                        $minute = floor(($sec / 60) % 60);
                        $hours = str_pad($hour, 2, "0", STR_PAD_LEFT);
                        $minutes = str_pad($minute, 2, "0", STR_PAD_LEFT);

                        $shedule_endtime =
                            $hours .
                            ":" .
                            $minutes .
                            " " .
                            date("A", strtotime($now));
                        $sheduled_endtime = $hours . ":" . $minutes;

                        $starttime = $last_sheduled_endtime;
                        $sheduled_starttime = $last_shedule_endtime;
                    }
                    $time_zone = $data["time_zone"];

                    $video = new ScheduleVideos();
                    $video->title = $file_folder_name;
                    $video->type = "mp4_url";
                    $video->active = 1;
                    $video->original_name = "public";
                    $video->disk = "public";
                    $video->mp4_url = $storepath;
                    $video->path = $path;
                    $video->shedule_date = $date_choosed;
                    $video->shedule_time = $schedule_time;
                    $video->shedule_endtime = $shedule_endtime;
                    $video->sheduled_endtime = $sheduled_endtime;
                    $video->current_time = date("h:i A", strtotime($now));
                    $video->video_order = 1;
                    $video->schedule_id = $schedule_id;
                    $video->starttime = $starttime;
                    $video->sheduled_starttime = $sheduled_starttime;
                    $video->starttime = $last_sheduled_endtime;
                    $video->choose_start_time = $choose_start_time;
                    $video->choose_end_time = $choose_end_time;
                    $video->status = 1;
                    $video->time_zone  = $time_zone ;
                    $video->save();

                    VideoSchedule::dispatch($video);

                    $video_id = $video->id;
                    $video_title = ScheduleVideos::find($video_id);
                    $title = $video_title->title;

                    $choosed_date =
                        $data["year"] .
                        "-" .
                        $data["month"] .
                        "-" .
                        $data["date"];

                    $date = date_create($choosed_date);
                    $date_choose = date_format($date, "Y/m");
                    $date_choosed = $date_choose . "/" . str_pad($data["date"], 2, '0', STR_PAD_LEFT);

                    // print_r($date_choosed);exit;
                    $total_content = ScheduleVideos::where(
                        "shedule_date",
                        "=",
                        $date_choosed
                    )
                        ->orderBy("id", "desc")
                        ->get();

                    $output = "";
                    $i = 1;
                    if (count($total_content) > 0) {
                        $total_row = $total_content->count();
                        if (!empty($total_content)) {
                            $currency = CurrencySetting::first();

                            foreach ($total_content as $key => $row) {
                                $output .=
                                    '
                  <tr>
                  <td>' . '#' .'</td>

                  <td>' .
                                    $i++ .
                                    '</td>
                  <td>' .
                                    $row->title .
                                    '</td>
                  <td>' .
                                    $row->type .
                                    '</td>  
                  <td>' .
                                    $row->shedule_date .
                                    '</td>       
                  <td>' .
                                    $row->sheduled_starttime .
                                    '</td>    

                  <td>' .
                                    $row->shedule_endtime .
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
                    }

                    $value["success"] = 1;
                    $value["message"] = "Uploaded Successfully!";
                    $value["video_id"] = $video_id;
                    $value["video_title"] = $title;
                    $value["table_data"] = $output;
                    $value["total_data"] = $total_row;
                    $value["total_content"] = $total_content;

                    return $value;
                } elseif (
                    !empty($ScheduleVideos) &&
                    !empty($choosedtime_exitvideos)
                ) {
                    // print_r('$ScheduleVideos');exit;
                    $last_shedule_endtime =
                        $choosedtime_exitvideos->shedule_endtime;
                    $last_current_time = $choosedtime_exitvideos->current_time;
                    $last_sheduled_endtime =
                        $choosedtime_exitvideos->sheduled_endtime;

                    if ($last_shedule_endtime < $current_time) {
                        // print_r('$ScheduleVideos');exit;

                        $time = $choose_current_time;
                        $minutes = $time[0] * 60.0 + $time[1] * 1.0;
                        $totalSecs = $minutes * 60;
                        $sec = $totalSecs + $Video_duration;
                        $hour = floor($sec / 3600);
                        $minute = floor(($sec / 60) % 60);
                        $hours = str_pad($hour, 2, "0", STR_PAD_LEFT);
                        $minutes = str_pad($minute, 2, "0", STR_PAD_LEFT);

                        $shedule_endtime =
                            $hours .
                            ":" .
                            $minutes .
                            " " .
                            date("A", strtotime($now));
                        $sheduled_endtime = $hours . ":" . $minutes;

                        $starttime = date("h:i ", strtotime($store_current_time));
                        $sheduled_starttime = date("h:i A", strtotime($store_current_time));

                        // print_r($last_shedule_endtime);exit;
                    } else {
                        // print_r('$last_sheduled_endtime');exit;
                        $time = explode(":", $last_sheduled_endtime);
                        $minutes = $time[0] * 60.0 + $time[1] * 1.0;
                        $totalSecs = $minutes * 60;
                        $sec = $totalSecs + $Video_duration;
                        // $sec = 45784.249244444;
                        $hour = floor($sec / 3600);
                        $minute = floor(($sec / 60) % 60);
                        $hours = str_pad($hour, 2, "0", STR_PAD_LEFT);
                        $minutes = str_pad($minute, 2, "0", STR_PAD_LEFT);

                        $shedule_endtime =
                            $hours .
                            ":" .
                            $minutes .
                            " " .
                            date("A", strtotime($now));
                        $sheduled_endtime = $hours . ":" . $minutes;
                        // print_r($sheduled_endtime);exit;

                        $starttime = $last_sheduled_endtime;
                        $sheduled_starttime = $last_shedule_endtime;
                    }
                    $time_zone = $data["time_zone"];

                    $video = new ScheduleVideos();
                    $video->title = $file_folder_name;
                    $video->type = "";
                    $video->active = 1;
                    $video->original_name = "public";
                    $video->disk = "public";
                    $video->mp4_url = $storepath;
                    $video->path = $path;
                    $video->shedule_date = $date_choosed;
                    $video->shedule_time = $schedule_time;
                    $video->shedule_endtime = $shedule_endtime;
                    $video->sheduled_endtime = $sheduled_endtime;
                    $video->current_time = date("h:i A", strtotime($now));
                    $video->video_order = 1;
                    $video->schedule_id = $schedule_id;
                    $video->starttime = $starttime;
                    $video->sheduled_starttime = $sheduled_starttime;
                    $video->duration = $Video_duration;
                    $video->choose_start_time = $choose_start_time;
                    $video->choose_end_time = $choose_end_time;
                    $video->status = 1;
                    $video->time_zone  = $time_zone ;
                    $video->save();

                    VideoSchedule::dispatch($video);

                    $video_id = $video->id;
                    $video_title = ScheduleVideos::find($video_id);
                    $title = $video_title->title;

                    $choosed_date =
                        $data["year"] .
                        "-" .
                        $data["month"] .
                        "-" .
                        $data["date"];

                    $date = date_create($choosed_date);
                    $date_choose = date_format($date, "Y/m");
                    $date_choosed = $date_choose . "/" . str_pad($data["date"], 2, '0', STR_PAD_LEFT);

                    // print_r($date_choosed);exit;
                    $total_content = ScheduleVideos::where(
                        "shedule_date",
                        "=",
                        $date_choosed
                    )
                        ->orderBy("id", "desc")
                        ->get();

                    $output = "";
                    $i = 1;
                    if (count($total_content) > 0) {
                        $total_row = $total_content->count();
                        if (!empty($total_content)) {
                            $currency = CurrencySetting::first();

                            foreach ($total_content as $key => $row) {
                                $output .=
                                    '
                  <tr>
                  <td>' . '#' .'</td>

                  <td>' .
                                    $i++ .
                                    '</td>
                  <td>' .
                                    $row->title .
                                    '</td>
                  <td>' .
                                    $row->type .
                                    '</td>  
                  <td>' .
                                    $row->shedule_date .
                                    '</td>       
                  <td>' .
                                    $row->sheduled_starttime .
                                    '</td>    

                  <td>' .
                                    $row->shedule_endtime .
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
                    }

                    $value["success"] = 1;
                    $value["message"] = "Uploaded Successfully!";
                    $value["video_id"] = $video_id;
                    $value["video_title"] = $title;
                    $value["table_data"] = $output;
                    $value["total_data"] = $total_row;
                    $value["total_content"] = $total_content;

                    return $value;
                } else {

                    // print_r('$else');exit;

                    $time = explode(":", date("h:i", strtotime($now)));
                    $minutes = $time[0] * 60.0 + $time[1] * 1.0;
                    $totalSecs = $minutes * 60;
                    $sec = $totalSecs + $Video_duration;

                    $hour = floor($sec / 3600);
                    $minute = floor(($sec / 60) % 60);
                    $hours = str_pad($hour, 2, "0", STR_PAD_LEFT);
                    $minutes = str_pad($minute, 2, "0", STR_PAD_LEFT);

                    $shedule_endtime =
                        $hours .
                        ":" .
                        $minutes .
                        " " .
                        date("A", strtotime($now));
                    $sheduled_endtime = $hours . ":" . $minutes;
                    $time_zone = $data["time_zone"];

                    $video = new ScheduleVideos();
                    $video->title = $file_folder_name;
                    $video->type = "";
                    $video->active = 1;
                    $video->original_name = "public";
                    $video->disk = "public";
                    $video->mp4_url = $storepath;
                    $video->path = $path;
                    $video->shedule_date = $date_choosed;
                    $video->shedule_time = $schedule_time;
                    $video->shedule_endtime = $shedule_endtime;
                    $video->sheduled_endtime = $sheduled_endtime;
                    $video->current_time = date("h:i A", strtotime($now));
                    $video->starttime = date("h:i", strtotime($now));
                    $video->sheduled_starttime = date("h:i A", strtotime($now));
                    $video->video_order = 1;
                    $video->schedule_id = $schedule_id;
                    $video->duration = $Video_duration;
                    $video->choose_start_time = $choose_start_time;
                    $video->choose_end_time = $choose_end_time;
                    $video->time_zone  = $time_zone ;
                    $video->status = 1;
                    $video->save();

                    VideoSchedule::dispatch($video);

                    $video_id = $video->id;
                    $video_title = ScheduleVideos::find($video_id);
                    $title = $video_title->title;

                    $choosed_date =
                        $data["year"] .
                        "-" .
                        $data["month"] .
                        "-" .
                        $data["date"];

                    $date = date_create($choosed_date);
                    $date_choose = date_format($date, "Y/m");
                    $date_choosed = $date_choose . "/" . str_pad($data["date"], 2, '0', STR_PAD_LEFT);

                    // print_r($date_choosed);exit;
                    $total_content = ScheduleVideos::where(
                        "shedule_date",
                        "=",
                        $date_choosed
                    )
                        ->orderBy("id", "desc")
                        ->get();

                    $output = "";
                    $i = 1;
                    if (count($total_content) > 0) {
                        $total_row = $total_content->count();
                        if (!empty($total_content)) {
                            $currency = CurrencySetting::first();

                            foreach ($total_content as $key => $row) {
                                $output .=
                                    '
                  <tr>
                  <td>' . '#' .'</td>

                  <td>' .
                                    $i++ .
                                    '</td>
                  <td>' .
                                    $row->title .
                                    '</td>
                  <td>' .
                                    $row->type .
                                    '</td>  
                  <td>' .
                                    $row->shedule_date .
                                    '</td>       
                  <td>' .
                                    $row->sheduled_starttime .
                                    '</td>    

                  <td>' .
                                    $row->shedule_endtime .
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
                    }

                    $value["success"] = 1;
                    $value["message"] = "Uploaded Successfully!";
                    $value["video_id"] = $video_id;
                    $value["video_title"] = $title;
                    $value["table_data"] = $output;
                    $value["total_data"] = $total_row;
                    $value["total_content"] = $total_content;

                    return $value;
                }
            } else {
                return "Please Choose Time";
            }
        } elseif (
            $mp4_url != "" &&
            $pack == "Business" &&
            $settings->transcoding_access == 0
        ) {

                // echo "<pre>";print_r($choose_time);exit;

            $date = $data["date"];
            $month = $data["month"];
            $year = $data["year"];
            $schedule_time = $data["schedule_time"];
            // $choose_start_time = $data['choose_start_time'];
            // $choose_end_time = $data['choose_end_time'];
            if (!empty($schedule_time)) {
                $choose_time = explode("to", $schedule_time);
                // echo "<pre>";print_r($choose_time);exit;
                if (count($choose_time) > 0) {
                    $choose_start_time = $choose_time[0];
                    $choose_end_time = $choose_time[1];
                } else {
                    $choose_start_time = "";
                    $choose_end_time = "";
                }

                $Schedule_current_date = date("Y-m-d");

                $schedule_id = $data["schedule_id"];
                $choosed_date = $year . "-" . $month . "-" . $date;

                $date = date_create($choosed_date);
                $date_choose = date_format($date, "Y/m");
                $date_choosed = $date_choose . "/" . str_pad($data["date"], 2, '0', STR_PAD_LEFT);
                // echo "<pre>";print_r($date_choosed);exit;

                $choosedtime_exitvideos = ScheduleVideos::selectRaw("*")
                    ->where("shedule_date", "=", $date_choosed)
                    ->whereBetween("choose_start_time", [
                        $choose_start_time,
                        $choose_end_time,
                    ])
                    ->orderBy("id", "desc")
                    ->first();
                // SELECT * FROM schedule_videos WHERE choose_start_time BETWEEN '01:30 PM' AND '02:30 PM';

                // $ScheduleVideos = DB::table('schedule_videos')
                // ->select('*')
                // ->whereBetween('choose_start_time',['01:30 PM','02:30 PM'])
                // ->orderBy('id', 'desc')->first();

                // echo "<pre>";print_r($choosedtime_exitvideos);exit;

                $ScheduleVideos = ScheduleVideos::where(
                    "shedule_date",
                    "=",
                    $date_choosed
                )
                    ->orderBy("id", "desc")
                    ->first();

                $rand = Str::random(16);
                $path =
                    $rand . "." . $request->file->getClientOriginalExtension();

                $request->file->storeAs("public", $path);
                $thumb_path = "public";
                $original_name = $request->file->getClientOriginalName()
                    ? $request->file->getClientOriginalName()
                    : "";
                $storepath = URL::to("/storage/app/public/" . $path);
                //  Video duration
                $getID3 = new getID3();
                $Video_storepath = storage_path("app/public/" . $path);
                $VideoInfo = $getID3->analyze($Video_storepath);
                $Video_duration = $VideoInfo["playtime_seconds"];

                // DateTime();
                $current_date = $current_date = date("Y-m-d h:i:s a", time());
                $current_date = date("Y-m-d h:i:s");
                $daten = date("Y-m-d h:i:s ", time());
                // $d = new \DateTime("now");
                // $d->setTimezone(new \DateTimeZone("Asia/Kolkata"));
                // $now = $d->format("Y-m-d h:i:s a");
                // $current_time = date("h:i A", strtotime($now));
                $time_zone = $data["time_zone"];

                date_default_timezone_set($time_zone);
                $now = date("Y-m-d h:i:s a", time());
                $current_time = date("h:i A", time());
                // print_r($choosedtime_exitvideos);exit;

                if (!empty($ScheduleVideos) && empty($choosedtime_exitvideos)) {
                    // print_r('ScheduleVideos');exit;

                    $last_shedule_endtime = $ScheduleVideos->shedule_endtime;
                    $last_current_time = $ScheduleVideos->current_time;
                    $last_sheduled_endtime = $ScheduleVideos->sheduled_endtime;

                    if ($last_shedule_endtime < $current_time) {
                        $time = $choose_current_time;
                        $minutes = $time[0] * 60.0 + $time[1] * 1.0;
                        $totalSecs = $minutes * 60;
                        $sec = $totalSecs + $Video_duration;
                        $hour = floor($sec / 3600);
                        $minute = floor(($sec / 60) % 60);
                        $hours = str_pad($hour, 2, "0", STR_PAD_LEFT);
                        $minutes = str_pad($minute, 2, "0", STR_PAD_LEFT);

                        $shedule_endtime =
                            $hours .
                            ":" .
                            $minutes .
                            " " .
                            date("A", strtotime($now));
                        $sheduled_endtime = $hours . ":" . $minutes;

                        // print_r($last_shedule_endtime);exit;
                        $starttime = date("h:i ", strtotime($store_current_time));
                        $sheduled_starttime = date("h:i A", strtotime($store_current_time));
                    } else {
                        $time = explode(":", $last_sheduled_endtime);
                        $minutes = $time[0] * 60.0 + $time[1] * 1.0;
                        $totalSecs = $minutes * 60;
                        $sec = $totalSecs + $Video_duration;
                        // $sec = 45784.249244444;
                        $hour = floor($sec / 3600);
                        $minute = floor(($sec / 60) % 60);
                        $hours = str_pad($hour, 2, "0", STR_PAD_LEFT);
                        $minutes = str_pad($minute, 2, "0", STR_PAD_LEFT);

                        $shedule_endtime =
                            $hours .
                            ":" .
                            $minutes .
                            " " .
                            date("A", strtotime($now));
                        $sheduled_endtime = $hours . ":" . $minutes;

                        $starttime = $last_sheduled_endtime;
                        $sheduled_starttime = $last_shedule_endtime;
                    }
                    $time_zone = $data["time_zone"];

                    $video = new ScheduleVideos();
                    $video->title = $file_folder_name;
                    $video->type = "mp4_url";
                    $video->active = 1;
                    $video->original_name = "public";
                    $video->disk = "public";
                    $video->mp4_url = $storepath;
                    $video->path = $path;
                    $video->shedule_date = $date_choosed;
                    $video->shedule_time = $schedule_time;
                    $video->shedule_endtime = $shedule_endtime;
                    $video->sheduled_endtime = $sheduled_endtime;
                    $video->current_time = date("h:i A", strtotime($now));
                    $video->video_order = 1;
                    $video->schedule_id = $schedule_id;
                    $video->starttime = $starttime;
                    $video->sheduled_starttime = $sheduled_starttime;
                    $video->starttime = $last_sheduled_endtime;
                    $video->choose_start_time = $choose_start_time;
                    $video->choose_end_time = $choose_end_time;
                    $video->time_zone  = $time_zone ;
                    $video->status = 1;
                    $video->save();

                    $video_id = $video->id;
                    $video_title = ScheduleVideos::find($video_id);
                    $title = $video_title->title;

                    $choosed_date =
                        $data["year"] .
                        "-" .
                        $data["month"] .
                        "-" .
                        $data["date"];

                    $date = date_create($choosed_date);
                    $date_choose = date_format($date, "Y/m");
                    $date_choosed = $date_choose . "/" . str_pad($data["date"], 2, '0', STR_PAD_LEFT);

                    // print_r($date_choosed);exit;
                    $total_content = ScheduleVideos::where(
                        "shedule_date",
                        "=",
                        $date_choosed
                    )
                        ->orderBy("id", "desc")
                        ->get();

                    $output = "";
                    $i = 1;
                    if (count($total_content) > 0) {
                        $total_row = $total_content->count();
                        if (!empty($total_content)) {
                            $currency = CurrencySetting::first();

                            foreach ($total_content as $key => $row) {
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
                                    $row->type .
                                    '</td>  
                  <td>' .
                                    $row->shedule_date .
                                    '</td>       
                  <td>' .
                                    $row->sheduled_starttime .
                                    '</td>    

                  <td>' .
                                    $row->shedule_endtime .
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
                    }

                    $value["success"] = 1;
                    $value["message"] = "Uploaded Successfully!";
                    $value["video_id"] = $video_id;
                    $value["video_title"] = $title;
                    $value["table_data"] = $output;
                    $value["total_data"] = $total_row;
                    $value["total_content"] = $total_content;

                    return $value;
                } elseif (
                    !empty($ScheduleVideos) &&
                    !empty($choosedtime_exitvideos)
                ) {
                    // print_r($ScheduleVideos);exit;
                    $last_shedule_endtime =
                        $choosedtime_exitvideos->shedule_endtime;
                    $last_current_time = $choosedtime_exitvideos->current_time;
                    $last_sheduled_endtime =
                        $choosedtime_exitvideos->sheduled_endtime;

                    if ($last_shedule_endtime < $current_time) {
                        $time = $choose_current_time;
                        $minutes = $time[0] * 60.0 + $time[1] * 1.0;
                        $totalSecs = $minutes * 60;
                        $sec = $totalSecs + $Video_duration;
                        $hour = floor($sec / 3600);
                        $minute = floor(($sec / 60) % 60);
                        $hours = str_pad($hour, 2, "0", STR_PAD_LEFT);
                        $minutes = str_pad($minute, 2, "0", STR_PAD_LEFT);

                        $shedule_endtime =
                            $hours .
                            ":" .
                            $minutes .
                            " " .
                            date("A", strtotime($now));
                        $sheduled_endtime = $hours . ":" . $minutes;

                        // print_r($last_shedule_endtime);exit;
                        $starttime = date("h:i ", strtotime($store_current_time));
                        $sheduled_starttime = date("h:i A", strtotime($store_current_time));
                    } else {
                        $time = explode(":", $last_sheduled_endtime);
                        $minutes = $time[0] * 60.0 + $time[1] * 1.0;
                        $totalSecs = $minutes * 60;
                        $sec = $totalSecs + $Video_duration;
                        // $sec = 45784.249244444;
                        $hour = floor($sec / 3600);
                        $minute = floor(($sec / 60) % 60);
                        $hours = str_pad($hour, 2, "0", STR_PAD_LEFT);
                        $minutes = str_pad($minute, 2, "0", STR_PAD_LEFT);

                        $shedule_endtime =
                            $hours .
                            ":" .
                            $minutes .
                            " " .
                            date("A", strtotime($now));
                        $sheduled_endtime = $hours . ":" . $minutes;
                        // print_r($sheduled_endtime);exit;
                        $starttime = $last_sheduled_endtime;
                        $sheduled_starttime = $last_shedule_endtime;
                    }
                    $time_zone = $data["time_zone"];

                    $video = new ScheduleVideos();
                    $video->title = $file_folder_name;
                    $video->type = "mp4_url";
                    $video->active = 1;
                    $video->original_name = "public";
                    $video->disk = "public";
                    $video->mp4_url = $storepath;
                    $video->path = $path;
                    $video->shedule_date = $date_choosed;
                    $video->shedule_time = $schedule_time;
                    $video->shedule_endtime = $shedule_endtime;
                    $video->sheduled_endtime = $sheduled_endtime;
                    $video->current_time = date("h:i A", strtotime($now));
                    $video->video_order = 1;
                    $video->schedule_id = $schedule_id;
                    $video->starttime = $starttime;
                    $video->sheduled_starttime = $sheduled_starttime;
                    $video->duration = $Video_duration;
                    $video->choose_start_time = $choose_start_time;
                    $video->choose_end_time = $choose_end_time;
                    $video->time_zone  = $time_zone ;
                    $video->status = 1;
                    $video->save();

                    $video_id = $video->id;
                    $video_title = ScheduleVideos::find($video_id);
                    $title = $video_title->title;

                    $choosed_date =
                        $data["year"] .
                        "-" .
                        $data["month"] .
                        "-" .
                        $data["date"];

                    $date = date_create($choosed_date);
                    $date_choose = date_format($date, "Y/m");
                    $date_choosed = $date_choose . "/" . str_pad($data["date"], 2, '0', STR_PAD_LEFT);

                    // print_r($date_choosed);exit;
                    $total_content = ScheduleVideos::where(
                        "shedule_date",
                        "=",
                        $date_choosed
                    )
                        ->orderBy("id", "desc")
                        ->get();

                    $output = "";
                    $i = 1;
                    if (count($total_content) > 0) {
                        $total_row = $total_content->count();
                        if (!empty($total_content)) {
                            $currency = CurrencySetting::first();

                            foreach ($total_content as $key => $row) {
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
                                    $row->type .
                                    '</td>  
                  <td>' .
                                    $row->shedule_date .
                                    '</td>       
                  <td>' .
                                    $row->sheduled_starttime .
                                    '</td>    

                  <td>' .
                                    $row->shedule_endtime .
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
                    }

                    $value["success"] = 1;
                    $value["message"] = "Uploaded Successfully!";
                    $value["video_id"] = $video_id;
                    $value["video_title"] = $title;
                    $value["table_data"] = $output;
                    $value["total_data"] = $total_row;
                    $value["total_content"] = $total_content;

                    return $value;
                } else {
                    $time = $choose_current_time;
                    $minutes = $time[0] * 60.0 + $time[1] * 1.0;
                    $totalSecs = $minutes * 60;
                    $sec = $totalSecs + $Video_duration;

                    $hour = floor($sec / 3600);
                    $minute = floor(($sec / 60) % 60);
                    $hours = str_pad($hour, 2, "0", STR_PAD_LEFT);
                    $minutes = str_pad($minute, 2, "0", STR_PAD_LEFT);

                    $shedule_endtime =
                        $hours .
                        ":" .
                        $minutes .
                        " " .
                        date("A", strtotime($now));
                    $sheduled_endtime = $hours . ":" . $minutes;
                    $starttime = date("h:i A", strtotime($store_current_time));
                    $sheduled_starttime = date("h:i ", strtotime($store_current_time));
                    $time_zone = $data["time_zone"];

                    $video = new ScheduleVideos();
                    $video->title = $file_folder_name;
                    $video->type = "mp4_url";
                    $video->active = 1;
                    $video->original_name = "public";
                    $video->disk = "public";
                    $video->mp4_url = $storepath;
                    $video->path = $path;
                    $video->shedule_date = $date_choosed;
                    $video->shedule_time = $schedule_time;
                    $video->shedule_endtime = $shedule_endtime;
                    $video->sheduled_endtime = $sheduled_endtime;
                    $video->current_time = date("h:i A", strtotime($now));
                    $video->starttime = $starttime;
                    $video->sheduled_starttime = $sheduled_starttime;
                    $video->video_order = 1;
                    $video->schedule_id = $schedule_id;
                    $video->duration = $Video_duration;
                    $video->choose_start_time = $choose_start_time;
                    $video->choose_end_time = $choose_end_time;
                    $video->time_zone  = $time_zone ;
                    $video->status = 1;
                    $video->save();

                    $video_id = $video->id;
                    $video_title = ScheduleVideos::find($video_id);
                    $title = $video_title->title;

                    $choosed_date =
                        $data["year"] .
                        "-" .
                        $data["month"] .
                        "-" .
                        $data["date"];

                    $date = date_create($choosed_date);
                    $date_choose = date_format($date, "Y/m");
                    $date_choosed = $date_choose . "/" . str_pad($data["date"], 2, '0', STR_PAD_LEFT);

                    // print_r($date_choosed);exit;
                    $total_content = ScheduleVideos::where(
                        "shedule_date",
                        "=",
                        $date_choosed
                    )
                        ->orderBy("id", "desc")
                        ->get();

                    $output = "";
                    $i = 1;
                    if (count($total_content) > 0) {
                        $total_row = $total_content->count();
                        if (!empty($total_content)) {
                            $currency = CurrencySetting::first();

                            foreach ($total_content as $key => $row) {
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
                                    $row->type .
                                    '</td>  
                  <td>' .
                                    $row->shedule_date .
                                    '</td>       
                  <td>' .
                                    $row->sheduled_starttime .
                                    '</td>    

                  <td>' .
                                    $row->shedule_endtime .
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
                    }

                    $value["success"] = 1;
                    $value["message"] = "Uploaded Successfully!";
                    $value["video_id"] = $video_id;
                    $value["video_title"] = $title;
                    $value["table_data"] = $output;
                    $value["total_data"] = $total_row;
                    $value["total_content"] = $total_content;

                    return $value;
                }
            } else {
                return "Please Choose Time";
            }
        } else {
            $value["success"] = 2;
            $value["message"] = "File not uploaded.";
            return response()->json($value);
        }

        // return response()->json($value);
    }
    public function IndexScheduledVideoss(Request $request)
    {
        if ($request->ajax()) {
            $ScheduleVideos = ScheduleVideos::All();
            return datatables()
                ->of($ScheduleVideos)
                ->addColumn("action", function ($row) {
                    $html =
                        '<a href="#" class="btn btn-xs btn-secondary btn-edit">Edit</a> ';
                    $html .=
                        '<button data-rowid="' .
                        $row->id .
                        '" class="btn btn-xs btn-danger btn-delete">Del</button>';
                    return $html;
                })
                ->toJson();
        }

        return view("admin.schedule.schedule_videos");
    }

    public function IndexScheduledVideos(Request $request)
    {
        $ScheduleVideos = ScheduleVideos::orderBy("id", "desc")->get();

        $output = "";
        $i = 1;
        if (count($ScheduleVideos) > 0) {
            $total_row = $ScheduleVideos->count();
            if (!empty($ScheduleVideos)) {
                $currency = CurrencySetting::first();

                foreach ($ScheduleVideos as $key => $row) {
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
                        $row->type .
                        '</td>  
                      <td>' .
                        $row->shedule_date .
                        '</td>       
                      <td>' .
                        $row->sheduled_starttime .
                        '</td>    
 
                      <td>' .
                        $row->shedule_endtime .
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
                "total_content" => $ScheduleVideos,
            ];

            return $value;
        }
    }

    public function calendarEvent(Request $request)
    {
        if ($request->ajax()) {
            $data = VideoEvents::whereDate("start", ">=", $request->start)
                ->whereDate("end", "<=", $request->end)
                ->get(["id", "title", "start", "end"]);
            return response()->json($data);
        }
        return view("admin.videos.video_calendar");
    }

    public function calendarEventsAjax(Request $request)
    {
        switch ($request->type) {
            case "create":
                $event = VideoEvents::create([
                    "title" => $request->title,
                    "start" => $request->start,
                    "end" => $request->end,
                ]);

                return response()->json($event);
                break;

            case "edit":
                $event = VideoEvents::find($request->id)->update([
                    "title" => $request->title,
                    "start" => $request->start,
                    "end" => $request->end,
                ]);

                return response()->json($event);
                break;

            case "delete":
                $event = VideoEvents::find($request->id)->delete();

                return response()->json($event);
                break;

            default:
                # ...
                break;
        }
    }

    public function TestServerUpload(Request $request)
    {
        return view("admin.test_server_videos.index");
    }

    public function TestServerFileUploads(Request $request)
    {
        $value = [];
        $data = $request->all();

        $validator = Validator::make($request->all(), [
            "file" => "required|mimes:video/mp4,video/x-m4v,video/*",
        ]);
        $mp4_url = isset($data["file"]) ? $data["file"] : "";

        $path = public_path() . "/uploads/videos/";

        $file = $request->file->getClientOriginalName();
        $newfile = explode(".mp4", $file);
        $file_folder_name = $newfile[0];

        $package = User::where("id", 1)->first();
        $pack = $package->package;
        $mp4_url = $data["file"];
        $settings = Setting::first();

        if ($mp4_url != "") {
            $rand = Str::random(16);
            $path = $rand . "." . $request->file->getClientOriginalExtension();

            $request->file->storeAs("public", $path);
            $thumb_path = "public";

            $original_name = $request->file->getClientOriginalName()
                ? $request->file->getClientOriginalName()
                : "";

            $storepath = URL::to("/storage/app/public/" . $path);

            $video = new TestServerUploadVideo();
            $video->title = $file_folder_name;
            $video->video_url = $storepath;
            $video->user_id = Auth::User()->id;
            $video->save();

            $video_id = $video->id;
            $video_title = TestServerUploadVideo::find($video_id);
            $title = $video_title->title;

            $value["success"] = 1;
            $value["message"] = "Uploaded Successfully!";
            $value["video_id"] = $video_id;
            $value["video_title"] = $title;

            return $value;
        } else {
            $value["success"] = 2;
            $value["message"] = "File not uploaded.";
            return response()->json($value);
        }
    }

    public function indexCPPPartner(Request $request)
    {
        try {
         
        $ModeratorsUser = ModeratorsUser::get();

        $video = Video::where("uploaded_by", "!=", "CPP")
            ->orWhere("uploaded_by", null)
            ->get();

        $data = [
            'setting' => Setting::first(),
            "ModeratorsUser" => $ModeratorsUser,
            "video" => $video,
        ];

        return view("admin.videos.move_videos.move_cpp_index", $data);
          
        } catch (\Throwable $th) {
            
            return abort(404);
        }
    }

    public function MoveCPPPartner(Request $request)
    {
        $data = $request->all();

        $vid = $data["video_data"];
        $cpp_id = $data["cpp_users"];

        $ModeratorsUser = ModeratorsUser::get();
        $video = Video::where("id", $vid)->first();
        $video->user_id = $cpp_id;
        $video->uploaded_by = "CPP";
        $video->CPP_commission_percentage = $request->CPP_commission_percentage;
        $video->save();

        // CPP

        return Redirect::back()->with(
            "message",
            "Your video moved to selected partner"
        );
    }

    public function indexChannelPartner(Request $request)
    {
        $channel = Channel::get();
        $video = Video::where("uploaded_by", "!=", "Channel")
            ->orWhere("uploaded_by", null)
            ->get();

        $data = [
            "channel" => $channel,
            "video" => $video,
        ];

        return view("admin.videos.move_videos.move_channel_video", $data);
    }

    public function MoveChannelPartner(Request $request)
    {
        $data = $request->all();

        $vid = $data["video_data"];
        $channel_id = $data["channel_users"];

        $Channel = Channel::get();
        $video = Video::where("id", $vid)->first();
        $video->user_id = $channel_id;
        $video->uploaded_by = "Channel";
        $video->save();

        return Redirect::back()->with(
            "message",
            "Your video moved to selected partner"
        );
    }

    public function TestServerFileUpload(Request $request)
    {
        $value = [];
        $data = $request->all();

        $validator = Validator::make($request->all(), [
            "file" => "required|mimes:video/mp4,video/x-m4v,video/*",
        ]);
        $mp4_url = isset($data["file"]) ? $data["file"] : "";
        // dd($mp4_url );
        $path = public_path() . "/uploads/videos/";

        $file = $request->file->getClientOriginalName();
        $newfile = explode(".mp4", $file);
        $file_folder_name = $newfile[0];

        $package = User::where("id", 1)->first();
        $pack = $package->package;
        $mp4_url = $data["file"];
        $settings = Setting::first();

        if ($mp4_url != "") {
            $rand = Str::random(16);
            $path = $rand . "." . $request->file->getClientOriginalExtension();

            $request->file->storeAs("public", $path);
            $thumb_path = "public";

            $original_name = $request->file->getClientOriginalName()
                ? $request->file->getClientOriginalName()
                : "";

            $storepath = URL::to("/storage/app/public/" . $path);

            $video = new TestServerUploadVideo();
            $video->title = $file_folder_name;
            $video->video_url = $storepath;
            $video->user_id = Auth::User()->id;
            $video->save();

            $video_id = $video->id;
            $video_title = TestServerUploadVideo::find($video_id);
            $title = $video_title->title;

            $value["success"] = 1;
            $value["message"] = "Uploaded Successfully!";
            $value["video_id"] = $video_id;
            $value["video_title"] = $title;

            return Redirect::back()->with("message", "Uploaded Successfully!");
        } else {
            $value["success"] = 2;
            $value["message"] = "File not uploaded.";
            return Redirect::back()->with("message", "File not uploaded");
        }
    }

    public function ReScheduleOneDay(Request $request)
    {
        $data = $request->all();

        $schedule_id = $data["schedule_id"];
        $date = $data["date"];
        $month = $data["month"];
        $year = $data["year"];

        $choosed_date = $data["year"] . "-" . $data["month"] . "-" . $data["date"];

        $date = date_create($choosed_date);
        $date_choose = date_format($date, "Y/m");
        $date_choosed = $date_choose . "/" . str_pad($data["date"], 2, '0', STR_PAD_LEFT);
    
        $stop_date = date('Y-m-d', strtotime("+1 day", strtotime($date_choosed)));
        $time_zone = $data["time_zone"];

        date_default_timezone_set($time_zone);
        $now = date("Y-m-d h:i:s a", time());
        $current_time = date("h:i A", time());
        $schedulevideo = ScheduleVideos::where("shedule_date",$date_choosed)->where("schedule_id", $schedule_id)->get();
        $reschedulevideo = ScheduleVideos::where("shedule_date",$stop_date)->where("schedule_id", $schedule_id)->get();
  

        if(count($reschedulevideo) > 0){
            if(count($schedulevideo) == count($reschedulevideo)){
                $value["success"] = 2;
                $value["message"] = "Already Added";
                return $value;
            }else{
                $aleady_reschedule =  DB::table('schedule_videos')                 
                ->where("shedule_date",$stop_date)
                ->where("schedule_id", $schedule_id)
                ->where("reschedule", 'one_day')
                ->get();
                foreach($aleady_reschedule as $schedule){ 
                    ScheduleVideos::where("id", $schedule->id)->delete();
                }
                
                $time_zone = $data["time_zone"];

                foreach($schedulevideo as $schedule){ 

                    $video = new ScheduleVideos();

                    $video->title = $schedule->title;
                    $video->type = $schedule->type;
                    $video->active = $schedule->active;
                    $video->original_name = $schedule->original_name;
                    $video->disk = $schedule->disk;
                    $video->mp4_url = $schedule->mp4_url;
                    $video->path = $schedule->path;
                    $video->shedule_date = $stop_date;
                    $video->shedule_time = $schedule->shedule_time;
                    $video->shedule_endtime = $schedule->shedule_endtime;
                    $video->sheduled_endtime = $schedule->sheduled_endtime;
                    $video->current_time = $schedule->current_time;
                    $video->starttime = $schedule->starttime;
                    $video->sheduled_starttime = $schedule->sheduled_starttime;
                    $video->video_order = $schedule->video_order;
                    $video->schedule_id = $schedule->schedule_id;
                    $video->duration = $schedule->duration;
                    $video->choose_start_time = $schedule->choose_start_time;
                    $video->choose_end_time = $schedule->choose_end_time;
                    $video->time_zone  = $time_zone ;
                    $video->status = $schedule->status;
                    $video->reschedule = 'one_day';
                    $video->save();
                }

                $value["success"] = 1;
                $value["message"] = "Added Successfully";
                return $value;
            }
        }else{

            if(count($schedulevideo) > 0){

                $ReSchedule = new ReSchedule();
                $ReSchedule->schedule_id = $schedule_id;
                $ReSchedule->reschedule_date = $stop_date;
                $ReSchedule->scheduled_date = $date_choosed;
                $ReSchedule->scheduled_enddate = $stop_date;
                $ReSchedule->type = 'one_day';
                $ReSchedule->save();
                $time_zone = $data["time_zone"];

                foreach($schedulevideo as $schedule){ 

                    $video = new ScheduleVideos();

                    $video->title = $schedule->title;
                    $video->type = $schedule->type;
                    $video->active = $schedule->active;
                    $video->original_name = $schedule->original_name;
                    $video->disk = $schedule->disk;
                    $video->mp4_url = $schedule->mp4_url;
                    $video->path = $schedule->path;
                    $video->shedule_date = $stop_date;
                    $video->shedule_time = $schedule->shedule_time;
                    $video->shedule_endtime = $schedule->shedule_endtime;
                    $video->sheduled_endtime = $schedule->sheduled_endtime;
                    $video->current_time = $schedule->current_time;
                    $video->starttime = $schedule->starttime;
                    $video->sheduled_starttime = $schedule->sheduled_starttime;
                    $video->video_order = $schedule->video_order;
                    $video->schedule_id = $schedule->schedule_id;
                    $video->duration = $schedule->duration;
                    $video->choose_start_time = $schedule->choose_start_time;
                    $video->choose_end_time = $schedule->choose_end_time;
                    $video->time_zone  = $time_zone ;
                    $video->status = $schedule->status;
                    $video->reschedule = 'one_day';
                    $video->save();
                }

                $value["success"] = 1;
                $value["message"] = "Added Successfully";
                return $value;
            }
            
            $value["success"] = 1;
            $value["message"] = "No Video";
            return $value;

        }

        
    }

    public function ReScheduleWeek(Request $request)
    {
        $data = $request->all();

        $video_id = $data["video_id"];
        $videochooed = Video::where("id", $video_id)->first();
        $date = $data["date"];
        $month = $data["month"];
        $year = $data["year"];
        $schedule_time = $data["schedule_time"];
        $time_zone = $data["time_zone"];


        date_default_timezone_set($time_zone);
        $now = date("Y-m-d h:i:s a", time());
        $current_time = date("h:i A", time());

        
    }

    public function DragDropScheduledVideos(Request $request)
{
    $data = $request->all();

    // Post Data By method 

    $video_id = $data["video_id"];            
    $date = $data["date"];
    $month = $data["month"];
    $year = $data["year"];
    $time_zone = $data["time_zone"];

    // Video Data and Video Duration

    $Video_data = Video::where("id", $video_id)->first();
    if(!empty($Video_data) && $Video_data->type == "mp4_url" && empty($Video_data->duration)){
        $ffprobe = \FFMpeg\FFProbe::create();
        $duration = $ffprobe->format($Video_data->mp4_url)->get('duration');
        $video_duration = explode(".", $duration)[0];
    }elseif(!empty($Video_data) && $Video_data->type == "m3u8_url"){

        $m3u8_url = $Video_data->m3u8_url;
            $command = ['ffprobe', '-v', 'error','-show_entries','format=duration','-of','default=noprint_wrappers=1:nokey=1', $m3u8_url, ];
            $process = new Process($command);
                $process->mustRun();
                $duration = trim($process->getOutput());
                $video_duration = round($duration);

            if($duration == 'N/A'){
                $duration = 3600;
                $video_duration  = 3600;
            }

    }else{
        $video_duration = $Video_data->duration;
    }

    // Default Time By Time Zone Based 

    date_default_timezone_set($time_zone);
    $now = date("Y-m-d h:i:s a", time());
    $current_time = date("h:i A", time());
    // Date Choosed By user  Calendar

    $Schedule_current_date = date("Y-m-d");
    $schedule_id = $data["schedule_id"];
    $choosed_date = $year . "-" . $month . "-" . $date;
    $date = date_create($choosed_date);
    $date_choose = date_format($date, "Y/m");
    $date_choosed = $date_choose . "/" . str_pad($data["date"], 2, '0', STR_PAD_LEFT);
// print_r($date_choosed);


    // schedule time Choosed By user

    $schedule_time = $data["schedule_time"];

    if (!empty($schedule_time)) {
        $choose_time = explode("to", $schedule_time);
        if (count($choose_time) > 0) {
            $choose_start_time = $choose_time[0];
            $choose_end_time = $choose_time[1];
        }else {
            $choose_start_time = "";
            $choose_end_time = "";
        }
    }

    $currentDate = date("Y/m/d");
    $current_time = date("h:i A", time());

    if($current_time < $choose_start_time  && $currentDate == $date_choosed ){
        $choose_current_time =  explode(":", date("h:i", strtotime($now)));
    }else {
        $choose_current_time =  explode(":", date("h:i", strtotime($choose_start_time)));
    }

    if($current_time < $choose_start_time  && $currentDate == $date_choosed ){
        $store_current_time =  date("h:i A", strtotime($now));
    }else {
        $store_current_time =  date("h:i A", strtotime($choose_start_time));
    }


    $total_content = ScheduleVideos::where(
        "shedule_date",
        "=",
        $date_choosed
    )
        ->orderBy("id", "desc")
        ->get();
// print_r($total_content);exit;
        // Scheduled Video Exits Check 

    $choosedtime_Scheduledvideo = ScheduleVideos::selectRaw("*")
        ->where("shedule_date", "=", $date_choosed)
        ->where("shedule_time", "=", $schedule_time)
        ->orderBy("id", "desc")
        ->first();

    $ScheduleVideos = ScheduleVideos::where(
        "shedule_date",
        "=",
        $date_choosed
    )
    ->orderBy("id", "desc")
    ->first();
    // print_r($schedule_time);exit;

    if($schedule_time == '12:00 PM to 12:00 AM' && @$ScheduleVideos->shedule_endtime > '12:00 PM' && $currentDate == $date_choosed ){
        
        $value["schedule_time"] = 'Today Slot Are Full';

    }else if($currentDate == $date_choosed){

    if (!empty($ScheduleVideos) && !empty($choosedtime_Scheduledvideo)) {
        
        $last_shedule_endtime = $ScheduleVideos->shedule_endtime;  // AM or PM
        $last_sheduled_endtime = $ScheduleVideos->sheduled_endtime; // Just Time

        // print_r($current_time);
        // print_r($last_shedule_endtime);exit;

         if($current_time > $last_shedule_endtime){
            // echo'<pre>'; print_r('testnew');exit;     

            $time = explode(":", $last_sheduled_endtime);
            $minutes = $time[0] * 60.0 + $time[1] * 1.0;
            $totalSecs = $minutes * 60;
            $sec = $totalSecs + $video_duration;
            // $sec = 45784.249244444;
            $hour = floor($sec / 3600);
            $minute = floor(($sec / 60) % 60);
            $hours = str_pad($hour, 2, "0", STR_PAD_LEFT);
            $minutes = str_pad($minute, 2, "0", STR_PAD_LEFT);

            $shedule_endtime = $hours .":" .$minutes ." " .date("A", strtotime($now));
            $sheduled_endtime = $hours . ":" . $minutes;

            $starttime = $last_sheduled_endtime;
            $sheduled_starttime = $last_shedule_endtime;
    //   print_r($last_shedule_endtime);
    // //   print_r(date("A", strtotime($now)));
    //     print_r($last_sheduled_endtime);exit;

            if($sheduled_endtime < '12:00 AM' && $last_shedule_endtime < '12:00 AM' 
            && date("A", strtotime($now)) == 'AM'){
                $TimeFormat = TimeFormat::where('hours_format',$hours)->where('format','PM')->first();
                $TimeFormatformat = TimeFormat::where('hours_format',$hours)->where('format','PM')->first();

                $current_zone_time = date("A", time());
                $sheduled_starttime_zone_time = date("A", strtotime($sheduled_starttime));
                if($current_zone_time == "AM" && $shedule_endtime <= "12:00" && $sheduled_starttime_zone_time == "AM"){
                $shedule_endtime = $TimeFormatformat->hours_format .":" .$minutes ." " ."PM";
                    $sheduled_endtime = $TimeFormatformat->hours_format . ":" . $minutes;
                    $starttime = $last_sheduled_endtime;
                    $sheduled_starttime = $last_shedule_endtime;
                }elseif($shedule_endtime <= "12:00" && $sheduled_starttime_zone_time == "PM"){
                                   
                        $shedule_endtime = $TimeFormat->hours_format .":" .$minutes ." " ."PM";

                        $sheduled_endtime = $TimeFormat->hours_format . ":" . $minutes;
                        $starttime = $last_sheduled_endtime;
                        $sheduled_starttime = $last_shedule_endtime;
                }else{
                                                       
                    $shedule_endtime = $TimeFormat->hours_format .":" .$minutes ." " ."PM";

                    $sheduled_endtime = $TimeFormat->hours_format . ":" . $minutes;
                    $starttime = $last_sheduled_endtime;
                    $sheduled_starttime = $last_shedule_endtime;
                }
                // print_r($shedule_endtime);exit;
                
                // $shedule_endtime =
                //     $hours .
                //     ":" .
                //     $minutes .
                //     " " .
                //     date("A", strtotime($now));
                // $sheduled_endtime = $hours . ":" . $minutes;
    
                // $starttime = date("h:i ", strtotime($store_current_time));
                // $sheduled_starttime = date("h:i A", strtotime($store_current_time));
    
                }
                else{
    
                    $TimeFormat = TimeFormat::where('hours',$hours)->where('format','PM')->first();
                    $TimeFormatformat = TimeFormat::where('hours_format',$hours)->where('format','PM')->first();

                    if(!empty($TimeFormat)){
        
                        $shedule_endtime = $TimeFormat->hours_format .":" .$minutes ." " .$TimeFormat->format;
        
                        $sheduled_endtime = $TimeFormat->hours_format . ":" . $minutes;
                        $starttime = $last_sheduled_endtime;
                        $sheduled_starttime = $last_shedule_endtime;
                    }else{
                        $shedule_endtime = $hours .":" .$minutes ." " .date("A", strtotime($now));
        
                        $sheduled_endtime = $hours . ":" . $minutes;
        
                        $starttime = date("h:i", strtotime($store_current_time));
                        $sheduled_starttime = date("h:i A", strtotime($store_current_time));
    
                    }
        
                }
    
         }elseif($current_time < $last_shedule_endtime){

            $time = explode(":", $last_sheduled_endtime);
            $minutes = $time[0] * 60.0 + $time[1] * 1.0;
            $totalSecs = $minutes * 60;
            $sec = $totalSecs + $video_duration;
            // $sec = 45784.249244444;
            $hour = floor($sec / 3600);
            $minute = floor(($sec / 60) % 60);
            $hours = str_pad($hour, 2, "0", STR_PAD_LEFT);
            $minutes = str_pad($minute, 2, "0", STR_PAD_LEFT);

            $shedule_endtime = $hours .":" .$minutes ." " .date("A", strtotime($now));
            $sheduled_endtime = $hours . ":" . $minutes;

            $starttime = $last_sheduled_endtime;
            $sheduled_starttime = $last_shedule_endtime;

            $TimeFormat = TimeFormat::where('hours',$hours)->where('format','PM')->first();
            $TimeFormatformat = TimeFormat::where('hours_format',$hours)->where('format','PM')->first();
            // $time = explode(":", $sheduled_starttime);
            // $sheduled_starttime = "03:00 PM";


 
            if(!empty($TimeFormat)){

                
                $current_zone_time = date("A", time());
                $sheduled_starttime_zone_time = date("A", strtotime($sheduled_starttime));
                if($current_zone_time == "AM" && $shedule_endtime <= "12:00" && $sheduled_starttime_zone_time == "AM"){
                $shedule_endtime = $TimeFormatformat->hours_format .":" .$minutes ." " ."PM";
                    $sheduled_endtime = $TimeFormatformat->hours_format . ":" . $minutes;
                    $starttime = $last_sheduled_endtime;
                    $sheduled_starttime = $last_shedule_endtime;
                }elseif($shedule_endtime <= "12:00" && $sheduled_starttime_zone_time == "PM"){
                                   
                        $shedule_endtime = $TimeFormat->hours_format .":" .$minutes ." " ."PM";

                        $sheduled_endtime = $TimeFormat->hours_format . ":" . $minutes;
                        $starttime = $last_sheduled_endtime;
                        $sheduled_starttime = $last_shedule_endtime;
                }else{
                                                       
                    $shedule_endtime = $TimeFormat->hours_format .":" .$minutes ." " ."PM";

                    $sheduled_endtime = $TimeFormat->hours_format . ":" . $minutes;
                    $starttime = $last_sheduled_endtime;
                    $sheduled_starttime = $last_shedule_endtime;
                }
                


            }elseif(!empty($TimeFormatformat)){
      
                $current_zone_time = date("A", time());
                $sheduled_starttime_zone_time = date("A", strtotime($sheduled_starttime));
                if($current_zone_time == "AM" && $shedule_endtime <= "12:00" && $sheduled_starttime_zone_time == "AM"){
                    $shedule_endtime = $TimeFormatformat->hours_format .":" .$minutes ." " ."AM";
                    $sheduled_endtime = $TimeFormatformat->hours_format . ":" . $minutes;
                    $starttime = $last_sheduled_endtime;
                    $sheduled_starttime = $last_shedule_endtime;
                }elseif($shedule_endtime <= "12:00" && $sheduled_starttime_zone_time == "PM"){
                    $shedule_endtime = $TimeFormatformat->hours_format .":" .$minutes ." " ."PM";
                    $sheduled_endtime = $TimeFormatformat->hours_format . ":" . $minutes;
                    $starttime = $last_sheduled_endtime;
                    $sheduled_starttime = $last_shedule_endtime;
                }
                

                $total_content = ScheduleVideos::where(
                    "shedule_date",
                    "=",
                    $date_choosed
                )
                    ->orderBy("id", "desc")
                    ->get();
                    
            }else{
               
                
                $current_zone_time = date("A", time());
                $sheduled_starttime_zone_time = date("A", strtotime($sheduled_starttime));
                
                        $shedule_endtime = $TimeFormatformat->hours_format .":" .$minutes ." " .$TimeFormatformat->format;

                        $sheduled_endtime = $TimeFormatformat->hours_format . ":" . $minutes;
                        $starttime = $last_sheduled_endtime;
                        $sheduled_starttime = $last_shedule_endtime;
                }



    
            $startTime = Carbon::createFromFormat('H:i a', '12:00 PM');
            $endTime = Carbon::createFromFormat('H:i a', '12:59 PM');
            $checkshedule_endtime = Carbon::createFromFormat('H:i a', $shedule_endtime);

            $sheduled_starttime_zone_time = date("A", strtotime($sheduled_starttime));
            $check = $checkshedule_endtime->between($startTime, $endTime);
            // echo'<pre>'; print_r($check);    exit;
            if(empty($check) && $check == null){
                
            }elseif($sheduled_starttime >= "11:00 PM" && $shedule_endtime >= "12:00 PM"  ||  $sheduled_starttime_zone_time == "PM" && $shedule_endtime >= "12:00 PM" ){
                // echo'<pre>'; print_r($shedule_endtime);    exit;
    
                    $value["schedule_time"] = 'Video End Time Exceeded today Please Change the Calendar Date to Add Schedule';
                    return $value;    
            }
            // elseif(!empty($check) && $check == 1 ){
            // // echo'<pre>'; print_r($shedule_endtime);    exit;

            //     $value["schedule_time"] = 'Video End Time Exceeded today Please Change the Calendar Date to Add Schedule';
            //     return $value;    
            // }
            // echo'<pre>'; print_r('$check');    exit;


            
        //     if($shedule_endtime->between($start, $end) ){

        //     echo'<pre>'; print_r($shedule_endtime);    
        // }else{
        //     echo'<pre>'; print_r('$shedule_endtime');    
        //     echo'<pre>'; print_r($shedule_endtime);    

        // }
        //     exit; 
         }else{
            $last_shedule_endtime = @$ScheduleVideos->shedule_endtime;  // AM or PM
            $last_sheduled_endtime = @$ScheduleVideos->sheduled_endtime; // Just Time
            $lastsheduleendtime =  explode(" ", $last_shedule_endtime);
            if(count($lastsheduleendtime) > 0 && @$lastsheduleendtime[1] == 'PM'){
                $time = explode(":", $last_sheduled_endtime);
                $minutes = $time[0] * 60.0 + $time[1] * 1.0;
                $totalSecs = $minutes * 60;
                $sec = $totalSecs + $video_duration;
                $hour = floor($sec / 3600);
                $minute = floor(($sec / 60) % 60);
                $hours = str_pad($hour, 2, "0", STR_PAD_LEFT);
                $minutes = str_pad($minute, 2, "0", STR_PAD_LEFT);
    
                $shedule_endtime =
                    $hours .
                    ":" .
                    $minutes .
                    " " .
                    $lastsheduleendtime[1];
                $sheduled_endtime = $hours . ":" . $minutes;
                $starttime = $last_sheduled_endtime;
                $sheduled_starttime = $last_shedule_endtime;
                if($last_shedule_endtime < $shedule_endtime){
                    $value["schedule_time"] = 'Change the Slot time';
                    return $value;
                }else{

                }
            // echo'<pre>'; print_r($last_shedule_endtime);exit;     

             }else{
                    $time = $choose_current_time;
                    $minutes = $time[0] * 60.0 + $time[1] * 1.0;
                    $totalSecs = $minutes * 60;
                    $sec = $totalSecs + $video_duration;
                    $hour = floor($sec / 3600);
                    $minute = floor(($sec / 60) % 60);
                    $hours = str_pad($hour, 2, "0", STR_PAD_LEFT);
                    $minutes = str_pad($minute, 2, "0", STR_PAD_LEFT);

                    $shedule_endtime =
                        $hours .
                        ":" .
                        $minutes .
                        " " .
                        date("A", strtotime($now));
                    $sheduled_endtime = $hours . ":" . $minutes;

                    $starttime = date("h:i ", strtotime($store_current_time));
                    $sheduled_starttime = date("h:i A", strtotime($store_current_time));
                }

            // echo'<pre>'; print_r($sheduled_starttime);exit;     

            if($shedule_endtime < '12:00 AM' && $last_sheduled_endtime < '12:00 AM' && date("A", strtotime($now)) == 'AM'){

            $shedule_endtime =
                $hours .
                ":" .
                $minutes .
                " " .
                date("A", strtotime($now));
            $sheduled_endtime = $hours . ":" . $minutes;

            $starttime = date("h:i ", strtotime($store_current_time));
            $sheduled_starttime = date("h:i A", strtotime($store_current_time));

            }else{

                $TimeFormat = TimeFormat::where('hours',$hours)->where('format','PM')->first();
                if(!empty($TimeFormat)){
    
                    $shedule_endtime = $TimeFormat->hours_format .":" .$minutes ." " .$TimeFormat->format;
    
                    $sheduled_endtime = $TimeFormat->hours_format . ":" . $minutes;
                    $starttime = $last_sheduled_endtime;
                    $sheduled_starttime = $last_shedule_endtime;
                }else{
                    $shedule_endtime = $hours .":" .$minutes ." " .date("A", strtotime($now));
    
                    $sheduled_endtime = $hours . ":" . $minutes;
    
                    $starttime = date("h:i", strtotime($store_current_time));
                    $sheduled_starttime = date("h:i A", strtotime($store_current_time));

                }
    
            }
         }
            $video = new ScheduleVideos();
            $video->title = $Video_data->title;
            $video->type = $Video_data->type;
            $video->active = 1;
            $video->original_name = "public";
            $video->disk = "public";
            $video->mp4_url = $Video_data->mp4_url;
            $video->path = $Video_data->path;
            $video->shedule_date = $date_choosed;
            $video->shedule_time = $schedule_time;
            $video->shedule_endtime = $shedule_endtime;
            $video->sheduled_endtime = $sheduled_endtime;
            $video->current_time = date("h:i A", strtotime($now));
            $video->starttime = $starttime;
            $video->sheduled_starttime = $sheduled_starttime;
            $video->video_order = 1;
            $video->schedule_id = $schedule_id;
            $video->duration = $video_duration;
            $video->choose_start_time = $choose_start_time;
            $video->choose_end_time = $choose_end_time;
            $video->time_zone  = $time_zone ;
            $video->status = 1;
            $video->save();

            $video_id = $video->id;
            $video_title = ScheduleVideos::find($video_id);
            $title = $video_title->title;

            $choosed_date =
                $data["year"] . "-" . $data["month"] . "-" . $data["date"];

            $date = date_create($choosed_date);
            $date_choose = date_format($date, "Y/m");
            $date_choosed = $date_choose . "/" . str_pad($data["date"], 2, '0', STR_PAD_LEFT);
            

            $total_content = ScheduleVideos::where(
                "shedule_date",
                "=",
                $date_choosed
            )
                ->orderBy("id", "desc")
                ->get();

    }else{

        // Time Format Calculation For video AM and PM Format 

            $time = $choose_current_time;
            $minutes = $time[0] * 60.0 + $time[1] * 1.0;
            $totalSecs = $minutes * 60;
            $sec = $totalSecs + $video_duration;

            $hour = floor($sec / 3600);
            $minute = floor(($sec / 60) % 60);
            $hours = str_pad($hour, 2, "0", STR_PAD_LEFT);
            $minutes = str_pad($minute, 2, "0", STR_PAD_LEFT);

            $TimeFormat = TimeFormat::where('hours',$hours)->first();
            if(!empty($TimeFormat)){

                $shedule_endtime = $TimeFormat->hours_format .":" .$minutes ." " .date("A", strtotime($now));

                $sheduled_endtime = $TimeFormat->hours_format . ":" . $minutes;
                $starttime = date("h:i", strtotime($store_current_time));
                $sheduled_starttime = date("h:i A", strtotime($store_current_time));

            }else{
                $shedule_endtime = $hours .":" .$minutes ." " .date("A", strtotime($now));

                $sheduled_endtime = $hours . ":" . $minutes;

                $starttime = date("h:i", strtotime($store_current_time));
                $sheduled_starttime = date("h:i A", strtotime($store_current_time));
            }
                $time_zone = $data["time_zone"];
                    
                $video = new ScheduleVideos();
                $video->title = $Video_data->title;
                $video->type = $Video_data->type;
                $video->active = 1;
                $video->original_name = "public";
                $video->disk = "public";
                $video->mp4_url = $Video_data->mp4_url;
                $video->path = $Video_data->path;
                $video->shedule_date = $date_choosed;
                $video->shedule_time = $schedule_time;
                $video->shedule_endtime = $shedule_endtime;
                $video->sheduled_endtime = $sheduled_endtime;
                $video->current_time = date("h:i A", strtotime($now));
                $video->starttime = $starttime;
                $video->sheduled_starttime = $sheduled_starttime;
                $video->video_order = 1;
                $video->schedule_id = $schedule_id;
                $video->duration = $video_duration;
                $video->choose_start_time = $choose_start_time;
                $video->choose_end_time = $choose_end_time;
                $video->time_zone  = $time_zone ;
                $video->status = 1;
                $video->save();

                $video_id = $video->id;
                $video_title = ScheduleVideos::find($video_id);
                $title = $video_title->title;

                $choosed_date =
                    $data["year"] . "-" . $data["month"] . "-" . $data["date"];

                $date = date_create($choosed_date);
                $date_choose = date_format($date, "Y/m");
                $date_choosed = $date_choose . "/" . str_pad($data["date"], 2, '0', STR_PAD_LEFT);

                $total_content = ScheduleVideos::where(
                    "shedule_date",
                    "=",
                    $date_choosed
                )
                    ->orderBy("id", "desc")
                    ->get();
        }

    }else if($currentDate < $date_choosed){

        // choose_end_time
        $time = $choose_current_time;

        $minutes = $time[0] * 60.0 + $time[1] * 1.0;
        $totalSecs = $minutes * 60;
        $sec = $totalSecs + $video_duration;

        $hour = floor($sec / 3600);
        $minute = floor(($sec / 60) % 60);
        $hours = str_pad($hour, 2, "0", STR_PAD_LEFT);
        $minutes = str_pad($minute, 2, "0", STR_PAD_LEFT);

        $TimeFormat = TimeFormat::where('hours',$hours)->first();
        if($schedule_time == '12:00 PM to 12:00 AM' && empty($ScheduleVideos)  ){
        // echo "<pre>" ; print_r($currentDate);
        // echo "<pre>" ; print_r($date_choosed);

        // exit;
            
        if(!empty($TimeFormat)){

            $shedule_endtime = $TimeFormat->hours_format .":" .$minutes ." " .date("A", strtotime($choose_end_time));

            $sheduled_endtime = $TimeFormat->hours_format . ":" . $minutes;
            $starttime = date("h:i", strtotime($choose_end_time));
            $sheduled_starttime = date("h:i A", strtotime($choose_end_time));

        }else{
            $shedule_endtime = $hours .":" .$minutes ." " .date("A", strtotime($choose_end_time));

            $sheduled_endtime = $hours . ":" . $minutes;

            $starttime = date("h:i", strtotime($choose_end_time));
            $sheduled_starttime = date("h:i A", strtotime($choose_end_time));
        }
                $video = new ScheduleVideos();
                $video->title = $Video_data->title;
                $video->type = $Video_data->type;
                $video->active = 1;
                $video->original_name = "public";
                $video->disk = "public";
                $video->mp4_url = $Video_data->mp4_url;
                $video->path = $Video_data->path;
                $video->shedule_date = $date_choosed;
                $video->shedule_time = $schedule_time;
                $video->shedule_endtime = $shedule_endtime;
                $video->sheduled_endtime = $sheduled_endtime;
                $video->current_time = date("h:i A", strtotime($now));
                $video->starttime = $starttime;
                $video->sheduled_starttime = $sheduled_starttime;
                $video->video_order = 1;
                $video->schedule_id = $schedule_id;
                $video->duration = $video_duration;
                $video->choose_start_time = $choose_start_time;
                $video->choose_end_time = $choose_end_time;
                $video->time_zone  = $time_zone ;
                $video->status = 1;
                $video->save();

                $video_id = $video->id;
                $video_title = ScheduleVideos::find($video_id);
                $title = $video_title->title;

                $choosed_date =
                    $data["year"] . "-" . $data["month"] . "-" . $data["date"];

                $date = date_create($choosed_date);
                $date_choose = date_format($date, "Y/m");
                $date_choosed = $date_choose . "/" . str_pad($data["date"], 2, '0', STR_PAD_LEFT);

                $total_content = ScheduleVideos::where(
                    "shedule_date",
                    "=",
                    $date_choosed
                )
                    ->orderBy("id", "desc")
                    ->get();
        }elseif($schedule_time == '12:00 PM to 12:00 AM' && empty($ScheduleVideos)  ){
            // echo "<pre>" ; print_r($ScheduleVideos);exit;
                
            if(!empty($TimeFormat)){
    
                $shedule_endtime = $TimeFormat->hours_format .":" .$minutes ." " .date("A", strtotime($choose_end_time));
    
                $sheduled_endtime = $TimeFormat->hours_format . ":" . $minutes;
                $starttime = date("h:i", strtotime($choose_end_time));
                $sheduled_starttime = date("h:i A", strtotime($choose_end_time));
    
            }else{
                $shedule_endtime = $hours .":" .$minutes ." " .date("A", strtotime($choose_end_time));
    
                $sheduled_endtime = $hours . ":" . $minutes;
    
                $starttime = date("h:i", strtotime($choose_end_time));
                $sheduled_starttime = date("h:i A", strtotime($choose_end_time));
            }
            // print_r('testaa'); exit();
    
                    $video = new ScheduleVideos();
                    $video->title = $Video_data->title;
                    $video->type = $Video_data->type;
                    $video->active = 1;
                    $video->original_name = "public";
                    $video->disk = "public";
                    $video->mp4_url = $Video_data->mp4_url;
                    $video->path = $Video_data->path;
                    $video->shedule_date = $date_choosed;
                    $video->shedule_time = $schedule_time;
                    $video->shedule_endtime = $shedule_endtime;
                    $video->sheduled_endtime = $sheduled_endtime;
                    $video->current_time = date("h:i A", strtotime($now));
                    $video->starttime = $starttime;
                    $video->sheduled_starttime = $sheduled_starttime;
                    $video->video_order = 1;
                    $video->schedule_id = $schedule_id;
                    $video->duration = $video_duration;
                    $video->choose_start_time = $choose_start_time;
                    $video->choose_end_time = $choose_end_time;
                    $video->time_zone  = $time_zone ;
                    $video->status = 1;
                    $video->save();
    
                    $video_id = $video->id;
                    $video_title = ScheduleVideos::find($video_id);
                    $title = $video_title->title;
    
                    $choosed_date =
                        $data["year"] . "-" . $data["month"] . "-" . $data["date"];
    
                    $date = date_create($choosed_date);
                    $date_choose = date_format($date, "Y/m");
                    $date_choosed = $date_choose . "/" . str_pad($data["date"], 2, '0', STR_PAD_LEFT);
                    
    
                    $total_content = ScheduleVideos::where(
                        "shedule_date",
                        "=",
                        $date_choosed
                    )
                        ->orderBy("id", "desc")
                        ->get();
            }else{
            // print_r('test'); exit();
                $last_shedule_endtime = $ScheduleVideos->shedule_endtime;  // AM or PM
                $last_sheduled_endtime = $ScheduleVideos->sheduled_endtime; // Just Time
                if($schedule_time == '12:00 PM to 12:00 AM' && $last_shedule_endtime < '12:00 AM' ){
                    $time = explode(":", $last_sheduled_endtime);
                    $minutes = $time[0] * 60.0 + $time[1] * 1.0;
                    $totalSecs = $minutes * 60;
                    $sec = $totalSecs + $video_duration;
                    // $sec = 45784.249244444;
                    $hour = floor($sec / 3600);
                    $minute = floor(($sec / 60) % 60);
                    $hours = str_pad($hour, 2, "0", STR_PAD_LEFT);
                    $minutes = str_pad($minute, 2, "0", STR_PAD_LEFT);

                    $shedule_endtime = $hours .":" .$minutes ." " .date("A", strtotime($choose_end_time));
                    $sheduled_endtime = $hours . ":" . $minutes;

                    $starttime = $last_sheduled_endtime;
                    $sheduled_starttime = $last_shedule_endtime;

                    $video = new ScheduleVideos();
                    $video->title = $Video_data->title;
                    $video->type = $Video_data->type;
                    $video->active = 1;
                    $video->original_name = "public";
                    $video->disk = "public";
                    $video->mp4_url = $Video_data->mp4_url;
                    $video->path = $Video_data->path;
                    $video->shedule_date = $date_choosed;
                    $video->shedule_time = $schedule_time;
                    $video->shedule_endtime = $shedule_endtime;
                    $video->sheduled_endtime = $sheduled_endtime;
                    $video->current_time = date("h:i A", strtotime($now));
                    $video->starttime = $starttime;
                    $video->sheduled_starttime = $sheduled_starttime;
                    $video->video_order = 1;
                    $video->schedule_id = $schedule_id;
                    $video->duration = $video_duration;
                    $video->choose_start_time = $choose_start_time;
                    $video->choose_end_time = $choose_end_time;
                    $video->time_zone  = $time_zone ;
                    $video->status = 1;
                    $video->save();

                    $video_id = $video->id;
                    $video_title = ScheduleVideos::find($video_id);
                    $title = $video_title->title;

                    $choosed_date =
                        $data["year"] . "-" . $data["month"] . "-" . $data["date"];

                    $date = date_create($choosed_date);
                    $date_choose = date_format($date, "Y/m");
                    $date_choosed = $date_choose . "/" . str_pad($data["date"], 2, '0', STR_PAD_LEFT);


                    $total_content = ScheduleVideos::where(
                        "shedule_date",
                        "=",
                        $date_choosed
                    )
                        ->orderBy("id", "desc")
                        ->get();
                    }else{

        $value["schedule_time"] = 'Change the Slot time';

                    }
            
                // print_r($shedule_endtime);
                // echo "<pre>";
                // print_r($sheduled_starttime);

                // exit;
            }
        }
        $total_content = ScheduleVideos::where(
            "shedule_date",
            "=",
            $date_choosed
        )->where('schedule_id', $schedule_id)
            ->orderBy("id", "desc")
            ->get();
    $output = "";
        $i = 1;
        $delete = URL::to("admin/schedule/delete");

        if (count($total_content) > 0) {
            $total_row = $total_content->count();
            if (!empty($total_content)) {
                $currency = CurrencySetting::first();

                foreach ($total_content as $key => $row) {
                    $output .=
                            '
                            <tr>
                            <td>' . '#' .'</td>

                            <td>' .
                                            $i++ .
                                            '</td>
                            <td>' .
                                            $row->title .
                                            '</td>
                            <td>' .
                                            $row->type .
                                            '</td>  
                            <td>' .
                                            $row->shedule_date .
                                            '</td>       
                            <td>' .
                                            $row->sheduled_starttime .
                                            '</td>    

                            <td>' .
                                            $row->shedule_endtime .
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
        }



        $value["success"] = 1;
        $value["message"] = "Uploaded Successfully!";
        $value["video_id"] = @$video_id;
        $value["video_title"] = @$title;
        $value["table_data"] = $output;
        $value["total_data"] = @$total_row;
        $value["total_content"] = $total_content;

        return $value;
    

}
    public function DragDropScheduledVideosOLD(Request $request)
    {
        $data = $request->all();

        $video_id = $data["video_id"];
        $videochooed = Video::where("id", $video_id)->first();
        $date = $data["date"];
        $month = $data["month"];
        $year = $data["year"];
        $schedule_time = $data["schedule_time"];
        $time_zone = $data["time_zone"];

        date_default_timezone_set($time_zone);
        $now = date("Y-m-d h:i:s a", time());
        $current_time = date("h:i A", time());
        // $date = date('m/d/Y h:i:s a', time());
        // echo"<pre>";print_r($date);
        // echo"<pre>";print_r($current_time );exit;
        
        if (!empty($schedule_time)) {
            $choose_time = explode("to", $schedule_time);
            if (count($choose_time) > 0) {
                $choose_start_time = $choose_time[0];
                $choose_end_time = $choose_time[1];
            } else {
                $choose_start_time = "";
                $choose_end_time = "";
            }
            // $d = new \DateTime("now");
            // $d->setTimezone(new \DateTimeZone("Asia/Kolkata"));
            // $now = $d->format("Y-m-d h:i:s a");
            // $current_time = date("h:i A", strtotime($now));
            // date_default_timezone_set('Asia/Kolkata');
            date_default_timezone_set($time_zone);
            $now = date("Y-m-d h:i:s a", time());
            $current_time = date("h:i A", time());


            $Schedule_current_date = date("Y-m-d");

            $schedule_id = $data["schedule_id"];
            $choosed_date = $year . "-" . $month . "-" . $date;

            $date = date_create($choosed_date);
            $date_choose = date_format($date, "Y/m");
            $date_choosed = $date_choose . "/" . str_pad($data["date"], 2, '0', STR_PAD_LEFT);


            
            $now = date("Y-m-d h:i:s a");
            $current_time = date("h:i A");

            $currentDate = date("Y/m/d");

            if($current_time < $choose_start_time  && $currentDate == $date_choosed ){
                $choose_current_time =  explode(":", date("h:i", strtotime($now)));
            }else {
                $choose_current_time =  explode(":", date("h:i", strtotime($choose_start_time)));
            }

            if($current_time < $choose_start_time  && $currentDate == $date_choosed ){
                $store_current_time =  date("h:i A", strtotime($now));
            }else {
                $store_current_time =  date("h:i A", strtotime($choose_start_time));
            }

            // echo "<pre>";
            // print_r($choose_start_time);

            // echo "<pre>";
            // print_r($store_current_time);

            // exit;

            $Schedule_current_date = date("Y-m-d");

            // $schedule_id = $data["schedule_id"];
            // $choosed_date = $year . "-" . $month . "-" . $date;

            // $date = date_create($choosed_date);
            // $date_choose = date_format($date, "Y/m");
            // $date_choosed = $date_choose . "/" . $data["date"];

            $choosedtime_exitvideos = ScheduleVideos::selectRaw("*")
                ->where("shedule_date", "=", $date_choosed)
                ->where("shedule_time", "=", $schedule_time)
                ->orderBy("id", "desc")
                ->first();

            $ScheduleVideos = ScheduleVideos::where(
                "shedule_date",
                "=",
                $date_choosed
            )
                ->orderBy("id", "desc")
                ->first();

            
            if(!empty($videochooed) && $videochooed->type == "mp4_url" && empty($videochooed->duration)){
                $ffprobe = \FFMpeg\FFProbe::create();
                $duration = $ffprobe->format($videochooed->mp4_url)->get('duration');
                $video_duration = explode(".", $duration)[0];
            }else{
                $video_duration = $videochooed->duration;
            }


            // DateTime();
            $current_date =  date("Y-m-d h:i:s a", time());
            $current_date = date("Y-m-d h:i:s");
            $daten = date("Y-m-d h:i:s ", time());
            // $d = new \DateTime("now");
            // $d->setTimezone(new \DateTimeZone("Asia/Kolkata"));
            // $now = $d->format("Y-m-d h:i:s a");
            // $current_time = date("h:i A", strtotime($now));
            $time_zone = $data["time_zone"];

            // date_default_timezone_set('Asia/Kolkata');
            date_default_timezone_set($time_zone);
            $now = date("Y-m-d h:i:s a", time());
            $current_time = date("h:i A", time());

            // print_r($choose_current_time);exit;

            if (!empty($ScheduleVideos) && empty($choosedtime_exitvideos)) {
                // print_r('ScheduleVideos');exit;

                $last_shedule_endtime = $ScheduleVideos->shedule_endtime;
                $last_current_time = $ScheduleVideos->current_time;
                $last_sheduled_endtime = $ScheduleVideos->sheduled_endtime;

                if ($last_shedule_endtime < $current_time) {
                    $time = $choose_current_time;
                    $minutes = $time[0] * 60.0 + $time[1] * 1.0;
                    $totalSecs = $minutes * 60;
                    $sec = $totalSecs + $video_duration;
                    $hour = floor($sec / 3600);
                    $minute = floor(($sec / 60) % 60);
                    $hours = str_pad($hour, 2, "0", STR_PAD_LEFT);
                    $minutes = str_pad($minute, 2, "0", STR_PAD_LEFT);

                    $shedule_endtime =
                        $hours .
                        ":" .
                        $minutes .
                        " " .
                        date("A", strtotime($now));
                    $sheduled_endtime = $hours . ":" . $minutes;

                    $starttime = date("h:i ", strtotime($store_current_time));
                    $sheduled_starttime = date("h:i A", strtotime($store_current_time));
                } else {
                    $time = explode(":", $last_sheduled_endtime);
                    $minutes = $time[0] * 60.0 + $time[1] * 1.0;
                    $totalSecs = $minutes * 60;
                    $sec = $totalSecs + $video_duration;
                    // $sec = 45784.249244444;
                    $hour = floor($sec / 3600);
                    $minute = floor(($sec / 60) % 60);
                    $hours = str_pad($hour, 2, "0", STR_PAD_LEFT);
                    $minutes = str_pad($minute, 2, "0", STR_PAD_LEFT);

                    $shedule_endtime = $hours .":" .$minutes ." " .date("A", strtotime($now));
                    $sheduled_endtime = $hours . ":" . $minutes;

                    $starttime = $last_sheduled_endtime;
                    $sheduled_starttime = $last_shedule_endtime;
                }
                $time_zone = $data["time_zone"];

                $video = new ScheduleVideos();
                $video->title = $videochooed->title;
                $video->type = $videochooed->type;
                $video->active = 1;
                $video->original_name = "public";
                $video->disk = "public";
                $video->mp4_url = $videochooed->mp4_url;
                // $video->m3u8_url = $videochooed->m3u8_url;
                $video->path = $videochooed->path;
                $video->shedule_date = $date_choosed;
                $video->shedule_time = $schedule_time;
                $video->shedule_endtime = $shedule_endtime;
                $video->sheduled_endtime = $sheduled_endtime;
                $video->current_time = date("h:i A", strtotime($now));
                $video->video_order = 1;
                $video->schedule_id = $schedule_id;
                $video->starttime = $starttime;
                $video->sheduled_starttime = $sheduled_starttime;
                $video->starttime = $last_sheduled_endtime;
                $video->choose_start_time = $choose_start_time;
                $video->choose_end_time = $choose_end_time;
                $video->time_zone  = $time_zone ;
                $video->status = 1;
                $video->save();

                $video_id = $video->id;
                $video_title = ScheduleVideos::find($video_id);
                $title = $video_title->title;

                $choosed_date =
                    $data["year"] . "-" . $data["month"] . "-" . $data["date"];

                $date = date_create($choosed_date);
                $date_choose = date_format($date, "Y/m");
                $date_choosed = $date_choose . "/" . $data["date"];

                // print_r($date_choosed);exit;
                $total_content = ScheduleVideos::where(
                    "shedule_date",
                    "=",
                    $date_choosed
                )
                    ->orderBy("id", "desc")
                    ->get();

                $output = "";
                $i = 1;

                $delete = URL::to("admin/schedule/delete");

                if (count($total_content) > 0) {
                    $total_row = $total_content->count();
                    if (!empty($total_content)) {
                        $currency = CurrencySetting::first();

                        foreach ($total_content as $key => $row) {
                            $output .=
                                '
                  <tr>
                  <td>' . '#' .'</td>
                  <td>' .
                                $i++ .
                                '</td>
                  <td>' .
                                $row->title .
                                '</td>
                  <td>' .
                                $row->type .
                                '</td>  
                  <td>' .
                                $row->shedule_date .
                                '</td>       
                  <td>' .
                                $row->sheduled_starttime .
                                '</td>    

                  <td>' .
                                $row->shedule_endtime .
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
                }

                $value["success"] = 1;
                $value["message"] = "Uploaded Successfully!";
                $value["video_id"] = $video_id;
                $value["video_title"] = $title;
                $value["table_data"] = $output;
                $value["total_data"] = $total_row;
                $value["total_content"] = $total_content;

                return $value;
            } elseif (
                !empty($ScheduleVideos) &&
                !empty($choosedtime_exitvideos)
            ) {
                // print_r('$ScheduleVideos');exit;
                if(!empty($videochooed) && $videochooed->type == "mp4_url" && empty($videochooed->duration)){
                    $ffprobe = \FFMpeg\FFProbe::create();
                    $duration = $ffprobe->format($videochooed->mp4_url)->get('duration');
                    $Video_duration = explode(".", $duration)[0];
                }else{
                    $Video_duration = $videochooed->duration;
                }

                // $Video_duration = $videochooed->duration;
                $last_shedule_endtime =
                    $choosedtime_exitvideos->shedule_endtime;
                $last_current_time = $choosedtime_exitvideos->current_time;
                $last_sheduled_endtime =
                    $choosedtime_exitvideos->sheduled_endtime;
                    // print_r($last_shedule_endtime);
                    // print_r($last_sheduled_endtime);exit;

                if ($last_shedule_endtime < $current_time) {
                    $time = $choose_current_time;
                    $minutes = $time[0] * 60.0 + $time[1] * 1.0;
                    $totalSecs = $minutes * 60;
                    $sec = $totalSecs + $Video_duration;
                    $hour = floor($sec / 3600);
                    $minute = floor(($sec / 60) % 60);
                    $hours = str_pad($hour, 2, "0", STR_PAD_LEFT);
                    $minutes = str_pad($minute, 2, "0", STR_PAD_LEFT);

                    $shedule_endtime = $hours .":" .$minutes ." " .date("A", strtotime($now));

                    $sheduled_endtime = $hours . ":" . $minutes;

                    $starttime = date("h:i ", strtotime($store_current_time));
                    $sheduled_starttime = date("h:i A", strtotime($store_current_time));
                } else {
                    
                    $time = explode(":", $last_sheduled_endtime);
                    $minutes = $time[0] * 60.0 + $time[1] * 1.0;
                    $totalSecs = $minutes * 60;
                    $sec = $totalSecs + $Video_duration;
                    $hour = floor($sec / 3600);
                    $minute = floor(($sec / 60) % 60);
                    $hours = str_pad($hour, 2, "0", STR_PAD_LEFT);
                    $minutes = str_pad($minute, 2, "0", STR_PAD_LEFT);
                    $TimeFormat = TimeFormat::where('hours',$hours)->first();
                    if(!empty($TimeFormat)){
                // print_r('$ScheduleVideos');exit;

                        $shedule_endtime = $TimeFormat->hours_format .":" .$minutes ." " .$TimeFormat->format;

                        $sheduled_endtime = $TimeFormat->hours_format . ":" . $minutes;
    
                        $starttime = $last_sheduled_endtime;
                        $sheduled_starttime = $last_shedule_endtime;

                    }else{
                    $shedule_endtime = $hours .":" .$minutes ." " .date("A", strtotime($now));

                    $sheduled_endtime = $hours . ":" . $minutes;

                    $starttime = $last_sheduled_endtime;
                    $sheduled_starttime = $last_shedule_endtime;

                    }
                }
                $time_zone = $data["time_zone"];

                $video = new ScheduleVideos();
                $video->title = $videochooed->title;
                $video->type = $videochooed->type;
                $video->active = 1;
                $video->original_name = "public";
                $video->disk = "public";
                $video->mp4_url = $videochooed->mp4_url;
                // $video->m3u8_url = $videochooed->m3u8_url;
                $video->path = $videochooed->path;
                $video->shedule_date = $date_choosed;
                $video->shedule_time = $schedule_time;
                $video->shedule_endtime = $shedule_endtime;
                $video->sheduled_endtime = $sheduled_endtime;
                $video->current_time = date("h:i A", strtotime($now));
                $video->video_order = 1;
                $video->schedule_id = $schedule_id;
                $video->starttime = $starttime;
                $video->sheduled_starttime = $sheduled_starttime;
                $video->duration = $Video_duration;
                $video->choose_start_time = $choose_start_time;
                $video->choose_end_time = $choose_end_time;
                $video->time_zone  = $time_zone ;
                $video->status = 1;
                $video->save();

                $video_id = $video->id;
                $video_title = ScheduleVideos::find($video_id);
                $title = $video_title->title;

                $choosed_date =
                    $data["year"] . "-" . $data["month"] . "-" . $data["date"];

                $date = date_create($choosed_date);
                $date_choose = date_format($date, "Y/m");
                $date_choosed = $date_choose . "/" . $data["date"];

                // print_r($date_choosed);exit;
                $total_content = ScheduleVideos::where(
                    "shedule_date",
                    "=",
                    $date_choosed
                )
                    ->orderBy("id", "desc")
                    ->get();

                $output = "";
                $i = 1;
                $delete = URL::to("admin/schedule/delete");

                if (count($total_content) > 0) {
                    $total_row = $total_content->count();
                    if (!empty($total_content)) {
                        $currency = CurrencySetting::first();

                        foreach ($total_content as $key => $row) {
                            $output .=
                                '
                  <tr>
                  <td>' . '#' .'</td>

                  <td>' .
                                $i++ .
                                '</td>
                  <td>' .
                                $row->title .
                                '</td>
                  <td>' .
                                $row->type .
                                '</td>  
                  <td>' .
                                $row->shedule_date .
                                '</td>       
                  <td>' .
                                $row->sheduled_starttime .
                                '</td>    

                  <td>' .
                                $row->shedule_endtime .
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
                }

                $value["success"] = 1;
                $value["message"] = "Uploaded Successfully!";
                $value["video_id"] = $video_id;
                $value["video_title"] = $title;
                $value["table_data"] = $output;
                $value["total_data"] = $total_row;
                $value["total_content"] = $total_content;

                return $value;
            } else {

            if(!empty($videochooed) && $videochooed->type == "mp4_url" && empty($videochooed->duration)){
                $ffprobe = \FFMpeg\FFProbe::create();
                $duration = $ffprobe->format($videochooed->mp4_url)->get('duration');
                $Video_duration = explode(".", $duration)[0];
            }else{
                $Video_duration = $videochooed->duration;
            }
            if($current_time > $store_current_time){

                $choose_current_time =  explode(":", date("h:i", strtotime($current_time)));

                $time = $choose_current_time;
                // echo "<pre>"; print_r($choose_current_time);

                $minutes = $time[0] * 60.0 + $time[1] * 1.0;
                $totalSecs = $minutes * 60;
                $sec = $totalSecs + $Video_duration;

                $hour = floor($sec / 3600);
                $minute = floor(($sec / 60) % 60);
                $hours = str_pad($hour, 2, "0", STR_PAD_LEFT);
                $minutes = str_pad($minute, 2, "0", STR_PAD_LEFT);

                $TimeFormat = TimeFormat::where('hours',$hours)->first();
                if(!empty($TimeFormat)){

                    $shedule_endtime = $TimeFormat->hours_format .":" .$minutes ." " .date("A", strtotime($now));

                    $sheduled_endtime = $TimeFormat->hours_format . ":" . $minutes;
                    $starttime = date("h:i", strtotime($current_time));
                    $sheduled_starttime = date("h:i A", strtotime($current_time));

                }else{
                    $shedule_endtime = $hours .":" .$minutes ." " .date("A", strtotime($now));

                    $sheduled_endtime = $hours . ":" . $minutes;

                    $starttime = date("h:i", strtotime($current_time));
                    $sheduled_starttime = date("h:i A", strtotime($current_time));
                }
            }elseif($current_time < $store_current_time){

                    $choose_current_time =  explode(":", date("h:i", strtotime($current_time)));
    
                    $time = $choose_current_time;
                    // echo "<pre>"; print_r($choose_current_time);
    
                    $minutes = $time[0] * 60.0 + $time[1] * 1.0;
                    $totalSecs = $minutes * 60;
                    $sec = $totalSecs + $Video_duration;
    
                    $hour = floor($sec / 3600);
                    $minute = floor(($sec / 60) % 60);
                    $hours = str_pad($hour, 2, "0", STR_PAD_LEFT);
                    $minutes = str_pad($minute, 2, "0", STR_PAD_LEFT);
    
                    $TimeFormat = TimeFormat::where('hours',$hours)->first();
                    if(!empty($TimeFormat)){
    
                        $shedule_endtime = $TimeFormat->hours_format .":" .$minutes ." " .date("A", strtotime($now));
    
                        $sheduled_endtime = $TimeFormat->hours_format . ":" . $minutes;
                        $starttime = date("h:i", strtotime($current_time));
                        $sheduled_starttime = date("h:i A", strtotime($current_time));
    
                    }else{
                        $shedule_endtime = $hours .":" .$minutes ." " .date("A", strtotime($now));
    
                        $sheduled_endtime = $hours . ":" . $minutes;
    
                        $starttime = date("h:i", strtotime($current_time));
                        $sheduled_starttime = date("h:i A", strtotime($current_time));
                    }
   
                }
            else{

                // $Video_duration = $videochooed->duration;
                $time = $choose_current_time;
                $minutes = $time[0] * 60.0 + $time[1] * 1.0;
                $totalSecs = $minutes * 60;
                $sec = $totalSecs + $Video_duration;

                $hour = floor($sec / 3600);
                $minute = floor(($sec / 60) % 60);
                $hours = str_pad($hour, 2, "0", STR_PAD_LEFT);
                $minutes = str_pad($minute, 2, "0", STR_PAD_LEFT);

                $TimeFormat = TimeFormat::where('hours',$hours)->first();
                if(!empty($TimeFormat)){

                    $shedule_endtime = $TimeFormat->hours_format .":" .$minutes ." " .date("A", strtotime($now));

                    $sheduled_endtime = $TimeFormat->hours_format . ":" . $minutes;
                    $starttime = date("h:i", strtotime($store_current_time));
                    $sheduled_starttime = date("h:i A", strtotime($store_current_time));

                }else{
                    $shedule_endtime = $hours .":" .$minutes ." " .date("A", strtotime($now));

                    $sheduled_endtime = $hours . ":" . $minutes;

                    $starttime = date("h:i", strtotime($store_current_time));
                    $sheduled_starttime = date("h:i A", strtotime($store_current_time));
                }
                // echo "<pre>"; print_r($store_current_time);
                
            }
            // exit();
                $time_zone = $data["time_zone"];
         
                $video = new ScheduleVideos();
                $video->title = $videochooed->title;
                $video->type = $videochooed->type;
                $video->active = 1;
                $video->original_name = "public";
                $video->disk = "public";
                $video->mp4_url = $videochooed->mp4_url;
                // $video->m3u8_url = $videochooed->m3u8_url;
                $video->path = $videochooed->path;
                $video->shedule_date = $date_choosed;
                $video->shedule_time = $schedule_time;
                $video->shedule_endtime = $shedule_endtime;
                $video->sheduled_endtime = $sheduled_endtime;
                $video->current_time = date("h:i A", strtotime($now));
                $video->starttime = $starttime;
                $video->sheduled_starttime = $sheduled_starttime;
                $video->video_order = 1;
                $video->schedule_id = $schedule_id;
                $video->duration = $Video_duration;
                $video->choose_start_time = $choose_start_time;
                $video->choose_end_time = $choose_end_time;
                $video->time_zone  = $time_zone ;
                $video->status = 1;
                $video->save();

                $video_id = $video->id;
                $video_title = ScheduleVideos::find($video_id);
                $title = $video_title->title;

                $choosed_date =
                    $data["year"] . "-" . $data["month"] . "-" . $data["date"];

                $date = date_create($choosed_date);
                $date_choose = date_format($date, "Y/m");
                $date_choosed = $date_choose . "/" . $data["date"];

                // print_r($date_choosed);exit;
                $total_content = ScheduleVideos::where(
                    "shedule_date",
                    "=",
                    $date_choosed
                )
                    ->orderBy("id", "desc")
                    ->get();

                $output = "";
                $i = 1;
                $delete = URL::to("admin/schedule/delete");

                if (count($total_content) > 0) {
                    $total_row = $total_content->count();
                    if (!empty($total_content)) {
                        $currency = CurrencySetting::first();

                        foreach ($total_content as $key => $row) {
                            $output .=
                                '
                  <tr>
                  <td>' . '#' .'</td>

                  <td>' .
                                $i++ .
                                '</td>
                  <td>' .
                                $row->title .
                                '</td>
                  <td>' .
                                $row->type .
                                '</td>  
                  <td>' .
                                $row->shedule_date .
                                '</td>       
                  <td>' .
                                $row->sheduled_starttime .
                                '</td>    

                  <td>' .
                                $row->shedule_endtime .
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
                }

                $choosed_date =
                    $data["year"] . "-" . $data["month"] . "-" . $data["date"];

                $date = date_create($choosed_date);
                $date_choose = date_format($date, "Y/m");
                $date_choosed = $date_choose . "/" . $data["date"];

                // print_r($date_choosed);exit;
                $total_content = ScheduleVideos::where(
                    "shedule_date",
                    "=",
                    $date_choosed
                )
                    ->orderBy("id", "desc")
                    ->get();

                $output = "";
                $i = 1;
                $delete = URL::to("admin/schedule/delete");

                if (count($total_content) > 0) {
                    $total_row = $total_content->count();
                    if (!empty($total_content)) {
                        $currency = CurrencySetting::first();

                        foreach ($total_content as $key => $row) {
                            $output .=
                                '
                      <tr>
                  <td>' . '#' .'</td>

                      <td>' .
                                $i++ .
                                '</td>
                      <td>' .
                                $row->title .
                                '</td>
                      <td>' .
                                $row->type .
                                '</td>  
                      <td>' .
                                $row->shedule_date .
                                '</td>       
                      <td>' .
                                $row->sheduled_starttime .
                                '</td>    
    
                      <td>' .
                                $row->shedule_endtime .
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
                }

                $value["success"] = 1;
                $value["message"] = "Uploaded Successfully!";
                $value["video_id"] = $video_id;
                $value["video_title"] = $title;
                $value["table_data"] = $output;
                $value["total_data"] = $total_row;
                $value["total_content"] = $total_content;

                return $value;
            }
        }
    }

    public function pre_videos_ads( Request $request )
    {
        try {

            $Advertisement = Advertisement::where('ads_category',$request->ads_category_id)
                            ->where('ads_upload_type','ads_video_upload')->where('ads_position','pre')
                            ->where('status',1)->get();

            $response = array(
                'status'  => true,
                'message' => 'Successfully Retrieve Pre Advertisement videos',
                'ads_videos'    => $Advertisement ,
            );

        } catch (\Throwable $th) {

            $response = array(
                'status' => false,
                'message' =>  $th->getMessage()
            );
        }
        return response()->json($response, 200);
    }

    public function mid_videos_ads( Request $request )
    {
        try {

            $Advertisement = Advertisement::where('ads_category',$request->ads_category_id)
                                    ->where('ads_upload_type','ads_video_upload')
                                    ->where('ads_position','mid')->where('status',1)
                                    ->get();

            $response = array(
                'status'  => true,
                'message' => 'Successfully Retrieve Mid Advertisement videos',
                'ads_videos'    => $Advertisement ,
            );

        } catch (\Throwable $th) {

            $response = array(
                'status' => false,
                'message' =>  $th->getMessage()
            );
        }
        return response()->json($response, 200);
    }

    public function post_videos_ads( Request $request )
    {
        try {

            $Advertisement = Advertisement::where('ads_category',$request->ads_category_id)
                                        ->where('ads_upload_type','ads_video_upload')
                                        ->where('ads_position','post')->where('status',1)
                                        ->get();

            $response = array(
                'status'  => true,
                'message' => 'Successfully Retrieve Post Advertisement videos',
                'ads_videos'    => $Advertisement ,
            );

        } catch (\Throwable $th) {

            $response = array(
                'status' => false,
                'message' =>  $th->getMessage()
            );
        }
        return response()->json($response, 200);
    }

    public function tag_url_ads(Request $request)
    {
        try {

            $Advertisement = Advertisement::where('status',1)
                                        ->where('ads_position',$request->position)
                                        ->get();

            $response = array(
                'status'  => true,
                'message' => 'Successfully Retrieve Post Advertisement videos',
                'ads_videos'    => $Advertisement ,
            );

        } catch (\Throwable $th) {

            $response = array(
                'status' => false,
                'message' =>  $th->getMessage()
            );
        }
        return response()->json($response, 200);
    }

    public function AWSUploadFileNEw(Request $request)
    {
        $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';
        

        $StorageSetting = StorageSetting::first();

        $file = $request->file('file');
        $file_folder_name =  $file->getClientOriginalName();
        $name = $file->getClientOriginalName() == null ? str_replace(' ', '_', 'S3'.$file->getClientOriginalName()) : str_replace(' ', '_', 'S3'.$file->getClientOriginalName()) ;        
        $filePath = $StorageSetting->aws_storage_path.'/'. $name;
        // Storage::disk('s3')->put($filePath, file_get_contents($file));
        $path = 'https://' . env('AWS_BUCKET').'.s3.'. env('AWS_DEFAULT_REGION') . '.amazonaws.com' ;
        $storepath = $path.$filePath;

        $s3 = new S3Client(['region' => 'ap-south-1', 'version' => 'latest']);

        $path = $_FILES['file']['name'];
        $file_name = "s3_" .pathinfo($path, PATHINFO_EXTENSION);
        $file_temp = $_FILES['file']['tmp_name'];
        $file_type = $_FILES['file']['type'];
        $upload_path = 'public/'.$name;
        $bucket_name = 'inthesky';
        $value = [];
        $data = $request->all();

        $validator = Validator::make($request->all(), [
            "file" => "required|mimes:video/mp4,video/x-m4v,video/*",
        ]);
        $mp4_url = isset($data["file"]) ? $data["file"] : "";

        $path = public_path() . "/uploads/videos/";

        $file = $request->file->getClientOriginalName();
        $newfile = explode(".mp4", $file);
        $file_folder_name = $newfile[0];

        $package = User::where("id", 1)->first();
        $pack = $package->package;
        $mp4_url = $data["file"];
        $settings = Setting::first();
        $StorageSetting = StorageSetting::first();
        if ($mp4_url != "" && $pack != "Business") {
            
            $file = $request->file('file');
            $file_folder_name =  $file->getClientOriginalName();
            $name = $file->getClientOriginalName() == null ? str_replace(' ', '_', 'S3'.$file->getClientOriginalName()) : str_replace(' ', '_', 'S3'.$file->getClientOriginalName()) ;        
            $filePath = '/public'.'/'. $name;
            // Storage::disk('s3')->put($filePath, file_get_contents($file));
            try {
                $s3->putObject(
                    array(
                        'Bucket' => 'inthesky',
                        'Key' => $upload_path,
                        'SourceFile' => $file_temp,
                        'ContentType' => $file_type,
                        'StorageClass' => 'STANDARD'
                    )
                );
                echo "Uploaded $file_name to $bucket_name.\n";
            } catch (Exception $exception) {
                echo "Failed to upload $file_name with error: " . $exception->getMessage();
            }
            
            $path = 'https://' . env('AWS_BUCKET').'.s3.'. env('AWS_DEFAULT_REGION') . '.amazonaws.com' ;
            $storepath = $path.$filePath;

            // $getID3 = new getID3();
            // $Video_storepath = $file;
            // $VideoInfo = $getID3->analyze($Video_storepath);
            // $Video_duration = $VideoInfo["playtime_seconds"];

            $video = new Video();
            $video->disk = "public";
            $video->title = $file_folder_name;
            $video->original_name = "public";
            $video->path = $path;
            $video->mp4_url = $storepath;
            $video->type = "mp4_url";
            $video->draft = 1;
            $video->status = 1;
            $video->image = default_vertical_image();

            $PC_image_path = public_path("/uploads/images/default_image.jpg");

            if (file_exists($PC_image_path)) {
                $Mobile_image = "Mobile-default_image.jpg";
                $Tablet_image = "Tablet-default_image.jpg";

                Image::make($PC_image_path)->save(
                    base_path() . "/public/uploads/images/" . $Mobile_image
                );
                Image::make($PC_image_path)->save(
                    base_path() . "/public/uploads/images/" . $Tablet_image
                );

                $video->mobile_image = $Mobile_image;
                $video->tablet_image = $Tablet_image;
            } else {
                $video->mobile_image = default_vertical_image();
                $video->tablet_image = default_vertical_image();
            }

            // $video->duration = $Video_duration;
            $video->save();

            $video_id = $video->id;
            $video_title = Video::find($video_id);
            $title = $video_title->title;

            $value["success"] = 1;
            $value["message"] = "Uploaded Successfully!";
            $value["video_id"] = $video_id;
            $value["video_title"] = $title;

            \LogActivity::addVideoLog("Added Uploaded MP4  Video.", $video_id);

            return $value;
        } elseif (
            $mp4_url != "" &&
            $pack == "Business" &&
            $settings->transcoding_access == 1
        ) {
            try {
                $file = $request->file('file');
                $file_folder_name =  $file->getClientOriginalName();
                $name_mp4 = $file->getClientOriginalName();
                $newfile = explode(".mp4",$name_mp4);
                $namem3u8 = $newfile[0].'.m3u8';   
                $name = $namem3u8 == null ? str_replace(' ', '_', 'S3'.$namem3u8) : str_replace(' ', '_', 'S3'.$namem3u8) ;        

                $transcode_path = '/public '.'/'. $name;
                $filePath = $StorageSetting->aws_storage_path.'/'. $name;
                $filePath_mp4 = $StorageSetting->aws_storage_path.'/'. $name_mp4;
                // Storage::disk('s3')->put($transcode_path, file_get_contents($file));
                // print_r($name);exit;

                    $s3->putObject(
                        array(
                            'Bucket' => 'inthesky',
                            'Key' => $upload_path,
                            'SourceFile' => $file_temp,
                            'ContentType' => $file_type,
                            'StorageClass' => 'STANDARD'
                        )
                    );


                $path = 'https://' . env('AWS_BUCKET').'.s3.'. env('AWS_DEFAULT_REGION') . '.amazonaws.com' ;
                $storepath = $path.$filePath_mp4;
                $m3u8_path = $path.$filePath;
                $transcode_path = $path.$transcode_path;
  
                // $getID3 = new getID3();
                // $Video_storepath = $file;
                // $VideoInfo = $getID3->analyze($Video_storepath);
                // $Video_duration = $VideoInfo["playtime_seconds"];

                $video = new Video();
                $video->disk = "public";
                $video->status = 0;
                $video->original_name = "public";
                $video->path = $path;
                $video->title = $file_folder_name;
                $video->mp4_url = $storepath;
                $video->m3u8_url = $transcode_path;
                $video->type = "aws_m3u8";
                $video->draft = 1;
                $video->status = 1;
                $video->image = default_vertical_image();

                $PC_image_path = public_path(
                    "/uploads/images/default_image.jpg"
                );

                if (file_exists($PC_image_path)) {
                    $Mobile_image = "Mobile-default_image.jpg";
                    $Tablet_image = "Tablet-default_image.jpg";

                    Image::make($PC_image_path)->save(
                        base_path() . "/public/uploads/images/" . $Mobile_image
                    );
                    Image::make($PC_image_path)->save(
                        base_path() . "/public/uploads/images/" . $Tablet_image
                    );

                    $video->mobile_image = $Mobile_image;
                    $video->tablet_image = $Tablet_image;
                } else {
                    $video->mobile_image = default_vertical_image();
                    $video->tablet_image = default_vertical_image();
                }

                // $video->duration = $Video_duration;
                $video->user_id = Auth::user()->id;
                $video->save();

                $video_id = $video->id;
                $video_title = Video::find($video_id);
                $title = $video_title->title;

                $value["success"] = 1;
                $value["message"] = "Uploaded Successfully!";
                $value["video_id"] = $video_id;
                $value["video_title"] = $title;

                \LogActivity::addVideoLog(
                    "Added Uploaded M3U8  Video.",
                    $video_id
                );

                return $value;
            } catch (\Exception $e) {
                return response()->json(
                    [
                        "status" => "false",
                        "Message" => "fails to upload ",
                    ],
                    200
                );
            }
        } elseif (
            $mp4_url != "" &&
            $pack == "Business" &&
            $settings->transcoding_access == 0
        ) {
            $file = $request->file('file');
            $file_folder_name =  $file->getClientOriginalName();
            // $name = time() . $file->getClientOriginalName();
            $name = $file->getClientOriginalName() == null ? str_replace(' ', '_', 'S3'.$file->getClientOriginalName()) : str_replace(' ', '_', 'S3'.$file->getClientOriginalName()) ;        
            $filePath = '/public/'. $name;

            // Storage::disk('s3')->put($filePath, file_get_contents($file));
            $s3->putObject(
                array(
                    'Bucket' => 'inthesky',
                    'Key' => $upload_path,
                    'SourceFile' => $file_temp,
                    'ContentType' => $file_type,
                    'StorageClass' => 'STANDARD'
                )
            );

            $path = 'https://' . env('AWS_BUCKET').'.s3.'. env('AWS_DEFAULT_REGION') . '.amazonaws.com' ;
            $storepath = $path.$filePath;

            // $getID3 = new getID3();
            // $Video_storepath = $file;
            // $VideoInfo = $getID3->analyze($Video_storepath);
            // $Video_duration = $VideoInfo["playtime_seconds"];

            $video = new Video();
            $video->disk = "public";
            $video->title = $file_folder_name;
            $video->original_name = "public";
            $video->path = $path;
            $video->mp4_url = $storepath;
            $video->type = "mp4_url";
            $video->draft = 1;
            $video->status = 1;
            $video->image = default_vertical_image();

            $PC_image_path = public_path("/uploads/images/default_image.jpg");

            if (file_exists($PC_image_path)) {
                $Mobile_image = "Mobile-default_image.jpg";
                $Tablet_image = "Tablet-default_image.jpg";

                Image::make($PC_image_path)->save(
                    base_path() . "/public/uploads/images/" . $Mobile_image
                );
                Image::make($PC_image_path)->save(
                    base_path() . "/public/uploads/images/" . $Tablet_image
                );

                $video->mobile_image = $Mobile_image;
                $video->tablet_image = $Tablet_image;
            } else {
                $video->mobile_image = default_vertical_image();
                $video->tablet_image = default_vertical_image();
            }

            // $video->duration = $Video_duration;
            $video->save();

            $video_id = $video->id;
            $video_title = Video::find($video_id);
            $title = $video_title->title;

            $value["success"] = 1;
            $value["message"] = "Uploaded Successfully!";
            $value["video_id"] = $video_id;
            $value["video_title"] = $title;

            \LogActivity::addVideoLog("Added Uploaded MP4  Video.", $video_id);

            return $value;
        } else {
            $value["success"] = 2;
            $value["message"] = "File not uploaded.";
            return response()->json($value);
        }

        // return response()->json($value);
    }


    public function AWSUploadFile(Request $request)
    {
        $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';
        

        $StorageSetting = StorageSetting::first();

        // $file = $request->file('file');
        // $file_folder_name =  $file->getClientOriginalName();
        // $name = $file->getClientOriginalName() == null ? str_replace(' ', '_', 'S3'.$file->getClientOriginalName()) : str_replace(' ', '_', 'S3'.$file->getClientOriginalName()) ;        
        // $filePath = $StorageSetting->aws_storage_path.'/'. $name;
        // // Storage::disk('s3')->put($filePath, file_get_contents($file));
        // $path = 'https://' . env('AWS_BUCKET').'.s3.'. env('AWS_DEFAULT_REGION') . '.amazonaws.com' ;
        // $storepath = $path.$filePath;

        // $s3 = new S3Client(['region' => 'ap-south-1', 'version' => 'latest']);

        // $path = $_FILES['file']['name'];
        // $file_name = "s3_" .pathinfo($path, PATHINFO_EXTENSION);
        // $file_temp = $_FILES['file']['tmp_name'];
        // $file_type = $_FILES['file']['type'];
        // $upload_path = $name;
        // $bucket_name = 'inthesky';
        // try {
        //     $s3->putObject(
        //         array(
        //             'Bucket' => 'inthesky',
        //             'Key' => $upload_path,
        //             'SourceFile' => $file_temp,
        //             'ContentType' => $file_type,
        //             'StorageClass' => 'STANDARD'
        //         )
        //     );
        //     echo "Uploaded $file_name to $bucket_name.\n";
        // } catch (Exception $exception) {
        //     echo "Failed to upload $file_name with error: " . $exception->getMessage();
        //     exit("Please fix error with file upload before continuing.");
        // }
        

        // $bucket = 'inthesky';
        // $keyname = $name;
                                
        // $s3 = new S3Client([
        //     'version' => 'latest',
        //     'region'  => 'ap-south-1'
        // ]);
         
        // // Prepare the upload parameters.
        // $uploader = new MultipartUploader($s3, $storepath, [
        //     'bucket' => $bucket,
        //     'key'    => $keyname
        // ]);
        
        // // Perform the upload.
        // try {
        //     $result = $uploader->upload();
        //     echo "Upload complete: {$result['ObjectURL']}\n";
        //     } catch (MultipartUploadException $e) {
        //     echo $e->getMessage() . "\n";
        // }
        // exit;
        $value = [];
        $data = $request->all();

        $validator = Validator::make($request->all(), [
            "file" => "required|mimes:video/mp4,video/x-m4v,video/*",
        ]);
        $mp4_url = isset($data["file"]) ? $data["file"] : "";

        $ffprobe =  \FFMpeg\FFProbe::create();
        $duration = $ffprobe->format($mp4_url)->get('duration');
        $Video_duration = explode(".", $duration)[0];

        $path = public_path() . "/uploads/videos/";

        $file = $request->file->getClientOriginalName();
        $newfile = explode(".mp4", $file);
        $file_folder_name = $newfile[0];

        $package = User::where("id", 1)->first();
        $pack = $package->package;
        $mp4_url = $data["file"];
        $settings = Setting::first();
        $StorageSetting = StorageSetting::first();
        if ($mp4_url != "" && $pack != "Business") {
            
            $file = $request->file('file');
            $file_folder_name =  $file->getClientOriginalName();
            $name = $file->getClientOriginalName() == null ? str_replace(' ', '_', 'S3'.$file->getClientOriginalName()) : str_replace(' ', '_', 'S3'.$file->getClientOriginalName()) ;        
            $filePath = $StorageSetting->aws_storage_path.'/'. $name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
            $path = 'https://' . env('AWS_BUCKET').'.s3.'. env('AWS_DEFAULT_REGION') . '.amazonaws.com' ;
            $storepath = $path.$filePath;

            // $getID3 = new getID3();
            // $Video_storepath = $file;
            // $VideoInfo = $getID3->analyze($Video_storepath);
            // $Video_duration = $VideoInfo["playtime_seconds"];

            $video = new Video();
            $video->disk = "public";
            $video->title = $file_folder_name;
            $video->original_name = "public";
            $video->path = $path;
            $video->mp4_url = $storepath;
            $video->duration = $Video_duration;
            $video->type = "mp4_url";
            $video->draft = 1;
            $video->status = 1;
            $video->image = default_vertical_image();

            $PC_image_path = public_path("/uploads/images/default_image.jpg");

            if (file_exists($PC_image_path)) {
                $Mobile_image = "Mobile-default_image.jpg";
                $Tablet_image = "Tablet-default_image.jpg";

                Image::make($PC_image_path)->save(
                    base_path() . "/public/uploads/images/" . $Mobile_image
                );
                Image::make($PC_image_path)->save(
                    base_path() . "/public/uploads/images/" . $Tablet_image
                );

                $video->mobile_image = $Mobile_image;
                $video->tablet_image = $Tablet_image;
            } else {
                $video->mobile_image = default_vertical_image();
                $video->tablet_image = default_vertical_image();
            }

            // $video->duration = $Video_duration;
            $video->save();

            $video_id = $video->id;
            $video_title = Video::find($video_id);
            $title = $video_title->title;

            $value["success"] = 1;
            $value["message"] = "Uploaded Successfully!";
            $value["video_id"] = $video_id;
            $value["video_title"] = $title;

            \LogActivity::addVideoLog("Added Uploaded MP4  Video.", $video_id);

            return $value;
        } elseif (
            $mp4_url != "" &&
            $pack == "Business" &&
            $settings->transcoding_access == 1
        ) {
            try {
                $file = $request->file('file');
                $file_folder_name =  $file->getClientOriginalName();
                $name_mp4 = $file->getClientOriginalName();
                $name_mp4 = $name_mp4 == null ? str_replace(' ', '_', 'S3'.$name_mp4) : str_replace(' ', '_', 'S3'.$name_mp4) ;        
                $newfile = explode(".mp4",$name_mp4);
                $namem3u8 = $newfile[0].'.m3u8';   
                $name = $namem3u8 == null ? str_replace(' ', '_',$namem3u8) : str_replace(' ', '_',$namem3u8) ;        

                $transcode_path = @$StorageSetting->aws_transcode_path.'/'. $name;
                $transcode_path_mp4 = @$StorageSetting->aws_storage_path.'/'. $name_mp4;
                $filePath = $StorageSetting->aws_storage_path.'/'. $name;
                $filePath_mp4 = $StorageSetting->aws_storage_path.'/'. $name_mp4;
                Storage::disk('s3')->put($transcode_path_mp4, file_get_contents($file));
                // print_r($name);exit;
                $path = 'https://' . env('AWS_BUCKET').'.s3.'. env('AWS_DEFAULT_REGION') . '.amazonaws.com' ;
                $storepath = $path.$filePath_mp4;
                $m3u8_path = $path.$filePath;
                $transcode_path = $path.$transcode_path;
  
                // $getID3 = new getID3();
                // $Video_storepath = $file;
                // $VideoInfo = $getID3->analyze($Video_storepath);
                // $Video_duration = $VideoInfo["playtime_seconds"];

                $video = new Video();
                $video->disk = "public";
                $video->status = 0;
                $video->original_name = "public";
                $video->path = $path;
                $video->duration = $Video_duration;
                $video->title = $file_folder_name;
                $video->mp4_url = $storepath;
                $video->m3u8_url = $transcode_path;
                $video->type = "aws_m3u8";
                $video->draft = 1;
                $video->status = 1;
                $video->image = default_vertical_image();

                $PC_image_path = public_path(
                    "/uploads/images/default_image.jpg"
                );

                if (file_exists($PC_image_path)) {
                    $Mobile_image = "Mobile-default_image.jpg";
                    $Tablet_image = "Tablet-default_image.jpg";

                    Image::make($PC_image_path)->save(
                        base_path() . "/public/uploads/images/" . $Mobile_image
                    );
                    Image::make($PC_image_path)->save(
                        base_path() . "/public/uploads/images/" . $Tablet_image
                    );

                    $video->mobile_image = $Mobile_image;
                    $video->tablet_image = $Tablet_image;
                } else {
                    $video->mobile_image = default_vertical_image();
                    $video->tablet_image = default_vertical_image();
                }

                // $video->duration = $Video_duration;
                $video->user_id = Auth::user()->id;
                $video->save();

                $video_id = $video->id;
                $video_title = Video::find($video_id);
                $title = $video_title->title;

                $value["success"] = 1;
                $value["message"] = "Uploaded Successfully!";
                $value["video_id"] = $video_id;
                $value["video_title"] = $title;

                \LogActivity::addVideoLog(
                    "Added Uploaded M3U8  Video.",
                    $video_id
                );

                return $value;
            } catch (\Exception $e) {
                return response()->json(
                    [
                        "status" => "false",
                        "Message" => "fails to upload ",
                    ],
                    200
                );
            }
        } elseif (
            $mp4_url != "" &&
            $pack == "Business" &&
            $settings->transcoding_access == 0
        ) {
            $file = $request->file('file');
            $file_folder_name =  $file->getClientOriginalName();
            // $name = time() . $file->getClientOriginalName();
            $name = $file->getClientOriginalName() == null ? str_replace(' ', '_', 'S3'.$file->getClientOriginalName()) : str_replace(' ', '_', 'S3'.$file->getClientOriginalName()) ;        
            $filePath = $StorageSetting->aws_storage_path.'/'. $name;

            Storage::disk('s3')->put($filePath, file_get_contents($file));
            $path = 'https://' . env('AWS_BUCKET').'.s3.'. env('AWS_DEFAULT_REGION') . '.amazonaws.com' ;
            $storepath = $path.$filePath;

            // $getID3 = new getID3();
            // $Video_storepath = $file;
            // $VideoInfo = $getID3->analyze($Video_storepath);
            // $Video_duration = $VideoInfo["playtime_seconds"];

            $video = new Video();
            $video->disk = "public";
            $video->title = $file_folder_name;
            $video->original_name = "public";
            $video->path = $path;
            $video->duration = $Video_duration;
            $video->mp4_url = $storepath;
            $video->type = "mp4_url";
            $video->draft = 1;
            $video->status = 1;
            $video->image = default_vertical_image();

            $PC_image_path = public_path("/uploads/images/default_image.jpg");

            if (file_exists($PC_image_path)) {
                $Mobile_image = "Mobile-default_image.jpg";
                $Tablet_image = "Tablet-default_image.jpg";

                Image::make($PC_image_path)->save(
                    base_path() . "/public/uploads/images/" . $Mobile_image
                );
                Image::make($PC_image_path)->save(
                    base_path() . "/public/uploads/images/" . $Tablet_image
                );

                $video->mobile_image = $Mobile_image;
                $video->tablet_image = $Tablet_image;
            } else {
                $video->mobile_image = default_vertical_image();
                $video->tablet_image = default_vertical_image();
            }

            // $video->duration = $Video_duration;
            $video->save();

            $video_id = $video->id;
            $video_title = Video::find($video_id);
            $title = $video_title->title;

            $value["success"] = 1;
            $value["message"] = "Uploaded Successfully!";
            $value["video_id"] = $video_id;
            $value["video_title"] = $title;

            \LogActivity::addVideoLog("Added Uploaded MP4  Video.", $video_id);

            return $value;
        } else {
            $value["success"] = 2;
            $value["message"] = "File not uploaded.";
            return response()->json($value);
        }

        // return response()->json($value);
    }

    public function AWSuploadEditVideo(Request $request)
    {
        $value = [];
        $data = $request->all();
        $id = $data["videoid"];
        $video = Video::findOrFail($id);
        $StorageSetting = StorageSetting::first();

        // echo "<pre>";
        // print_r($video);exit();
        $validator = Validator::make($request->all(), [
            "file" => "required|mimes:video/mp4,video/x-m4v,video/*",
        ]);
        $mp4_url = isset($data["file"]) ? $data["file"] : "";

        $ffprobe =  \FFMpeg\FFProbe::create();
        $duration = $ffprobe->format($mp4_url)->get('duration');
        $Video_duration = explode(".", $duration)[0];
        
        $path = public_path() . "/uploads/videos/";

        $file = $request->file->getClientOriginalName();
        $newfile = explode(".mp4", $file);
        $file_folder_name = $newfile[0];

        $package = User::where("id", 1)->first();
        $pack = $package->package;
        $mp4_url = $data["file"];
        $settings = Setting::first();

        if (
            $mp4_url != "" &&
            $pack != "Business" &&
            $settings->transcoding_access == 0
        ) {

            
            $file = $request->file('file');
            $file_folder_name =  $file->getClientOriginalName();
            // $name = time() . $file->getClientOriginalName();
            $name = $file->getClientOriginalName() == null ? str_replace(' ', '_', 'S3'.$file->getClientOriginalName()) : str_replace(' ', '_', 'S3'.$file->getClientOriginalName()) ;        
            $filePath = $StorageSetting->aws_storage_path.'/'. $name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
            $path = 'https://' . env('AWS_BUCKET').'.s3.'. env('AWS_DEFAULT_REGION') . '.amazonaws.com' ;
            $storepath = $path.$filePath;

            $file = $request->file->getClientOriginalName();
            $newfile = explode(".mp4",$file);
            $file_folder_name = $newfile[0];   
            $file = $request->file('file');

             //  Video duration 
            //  $getID3 = new getID3();
            //  $Video_storepath = $file;
            //  $VideoInfo = $getID3->analyze($Video_storepath);
            //  $Video_duration = $VideoInfo["playtime_seconds"];

            // $video = new Video();
            $video->disk = "public";
            $video->title = $file_folder_name;
            $video->original_name = "public";
            $video->path = $path;
            $video->duration = $Video_duration;
            $video->mp4_url = $storepath;
            $video->type = "mp4_url";
            // $video->draft = 0;
            // $video->image = 'default_image.jpg';

            // $video->duration = $Video_duration;
            $video->save();

            $video_id = $video->id;
            $video_title = Video::find($video_id);
            $title = $video_title->title;

            $value["success"] = 1;
            $value["message"] = "Uploaded Successfully!";
            $value["video_id"] = $video_id;
            $value["video_title"] = $title;

            // return $value;
            return redirect("/admin/videos");

        } elseif (
            $mp4_url != "" &&
            $pack == "Business" &&
            $settings->transcoding_access == 1
        ) {
            $file = $request->file('file');
            $file_folder_name =  $file->getClientOriginalName();
            $name_mp4 = $file->getClientOriginalName();
            $name_mp4 = $name_mp4 == null ? str_replace(' ', '_', 'S3'.$name_mp4) : str_replace(' ', '_', 'S3'.$name_mp4) ;        
            $newfile = explode(".mp4",$name_mp4);
            $namem3u8 = $newfile[0].'.m3u8';   
            $name = $namem3u8 == null ? str_replace(' ', '_',$namem3u8) : str_replace(' ', '_',$namem3u8) ;        

            $transcode_path = @$StorageSetting->aws_transcode_path.'/'. $name;
            $transcode_path_mp4 = @$StorageSetting->aws_storage_path.'/'. $name_mp4;
            $filePath = $StorageSetting->aws_storage_path.'/'. $name;
            $filePath_mp4 = $StorageSetting->aws_storage_path.'/'. $name_mp4;
            Storage::disk('s3')->put($transcode_path_mp4, file_get_contents($file));
            // print_r($name);exit;
            $path = 'https://' . env('AWS_BUCKET').'.s3.'. env('AWS_DEFAULT_REGION') . '.amazonaws.com' ;
            $storepath = $path.$filePath_mp4;
            $m3u8_path = $path.$filePath;
            $transcode_path = $path.$transcode_path;

            $file = $request->file->getClientOriginalName();
            $newfile = explode(".mp4",$file);
            $file_folder_name = $newfile[0];   
            $file = $request->file('file');

             //  Video duration 
            //  $getID3 = new getID3();
            //  $Video_storepath = $file;
            //  $VideoInfo = $getID3->analyze($Video_storepath);
            //  $Video_duration = $VideoInfo["playtime_seconds"];

            //  $video = new Video();
            $video->disk = "public";
            $video->status = 0;
            $video->original_name = "public";
            $video->path = $path;
            $video->duration = $Video_duration;
            $video->title = $file_folder_name;
            $video->mp4_url = $storepath;
            //  $video->draft = 0;
            // $video->type = "";
            $video->m3u8_url = $transcode_path;
            $video->type = "aws_m3u8";
            //  $video->image = 'default_image.jpg';
            // $video->duration = $Video_duration;
            $video->user_id = Auth::user()->id;
            $video->save();

            $video_id = $video->id;
            $video_title = Video::find($video_id);
            $title = $video_title->title;

            $value["success"] = 1;
            $value["message"] = "Uploaded Successfully!";
            $value["video_id"] = $video_id;
            $value["video_title"] = $title;

            // return $value;
            return redirect("/admin/videos");

        } elseif (
            $mp4_url != "" &&
            $pack == "Business" &&
            $settings->transcoding_access == 0
        ) {
            $file = $request->file('file');
            $file_folder_name =  $file->getClientOriginalName();
            // $name = time() . $file->getClientOriginalName();
            $name = $file->getClientOriginalName() == null ? str_replace(' ', '_', 'S3'.$file->getClientOriginalName()) : str_replace(' ', '_', 'S3'.$file->getClientOriginalName()) ;        
            $filePath = $StorageSetting->aws_storage_path.'/'. $name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
            $path = 'https://' . env('AWS_BUCKET').'.s3.'. env('AWS_DEFAULT_REGION') . '.amazonaws.com' ;
            $storepath = $path.$filePath;

            $file = $request->file->getClientOriginalName();
            $newfile = explode(".mp4",$file);
            $file_folder_name = $newfile[0];   
            $file = $request->file('file');

             //  Video duration 
            //  $getID3 = new getID3();
            //  $Video_storepath = $file;
            //  $VideoInfo = $getID3->analyze($Video_storepath);
            //  $Video_duration = $VideoInfo["playtime_seconds"];

            // $video = new Video();
            $video->disk = "public";
            $video->title = $file_folder_name;
            $video->original_name = "public";
            $video->path = $path;
            $video->duration = $Video_duration;
            $video->mp4_url = $storepath;
            $video->type = "mp4_url";
            // $video->draft = 0;
            $video->image = default_vertical_image();
            // $video->duration = $Video_duration;
            $video->save();

            $video_id = $video->id;
            $video_title = Video::find($video_id);
            $title = $video_title->title;

            $value["success"] = 1;
            $value["message"] = "Uploaded Successfully!";
            $value["video_id"] = $video_id;
            $value["video_title"] = $title;

            // return $value;
            return redirect("/admin/videos");

        } else {
            $value["success"] = 2;
            $value["message"] = "File not uploaded.";
            return response()->json($value);
        }

        // return response()->json($value);
    }

    public function ScheduledVideoDelete($id)
    {
        // dd($id);
        ScheduleVideos::where("id", $id)->delete();
        $value["message"] = "File Deleted .";
        return response()->json($value);
        // return redirect::back();

    }

    public function ScheduleVideoBulk_delete(Request $request)
    {
        try {
            $data = $request->all();
            $video_id = $request->video_id;
            ScheduleVideos::whereIn("id", explode(",", $video_id))->delete();

            $date = $data["date"];
            $month = $data["month"];
            $year = $data["year"];
            $choosed_date = $year . "-" . $month . "-" . $date;
            $date = date_create($choosed_date);
            $date_choose = date_format($date, "Y/m");
            $date_choosed = $date_choose . "/" . str_pad($data["date"], 2, '0', STR_PAD_LEFT);


            $total_content = ScheduleVideos::where(
                "shedule_date",
                "=",
                $date_choosed
            )
                ->orderBy("id", "desc")
                ->get();

            $output = "";
            $i = 1;

            $delete = URL::to("admin/schedule/delete");

            if (count($total_content) > 0) {
                $total_row = $total_content->count();
                if (!empty($total_content)) {
                    $currency = CurrencySetting::first();

                    foreach ($total_content as $key => $row) {
                        $output .=
                            '
              <tr>
              <td>' . '#' .'</td>
              <td>' .
                            $i++ .
                            '</td>
              <td>' .
                            $row->title .
                            '</td>
              <td>' .
                            $row->type .
                            '</td>  
              <td>' .
                            $row->shedule_date .
                            '</td>       
              <td>' .
                            $row->sheduled_starttime .
                            '</td>    

              <td>' .
                            $row->shedule_endtime .
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
            }

            $value["success"] = 1;
            $value["message"] = "Uploaded Successfully!";
            $value["table_data"] = $output;
            // $value["total_data"] = $total_row;
            $value["total_content"] = $total_content;

            return $value;


            return response()->json(["message" => "true"]);
        } catch (\Throwable $th) {
            return response()->json(["message" => "false"]);
        }
    }


    // public function combineM3U8toHLS() {

    //     $playlistUrls = Video::where('type','=','')->orWhere('type', '=', null)->where('active',1)->where('status',1)->pluck('path');
    //     $playlistUrls= Video::where('type','=','')->orWhere('type', '=', null)->where('active',1)->where('status',1)->get()->map(function ($item) {       
    //            $item['path'] = URL::to('/storage/app/public/') . '/' . $item->path . '.m3u8';
    //       return $item;
    //     });


    //     // Array to store all the video URLs
    //     $videoUrls = [];
        
    //     // Loop through all the playlist URLs
    //     foreach ($playlistUrls as $playlistUrl) {


    //         // $response = Http::get($playlistUrl->path);
    //         // $playlist = \ParseM3U8::fromString($response->body());
    //         // $videoUrls = $playlist->getMediaUrls();

    //         // Fetch the M3U8 playlist
    //         // $response = Http::get($playlistUrl->path);
            
    //         // // Parse the M3U8 playlist to get the video URLs
    //         // $videoUrls = array_merge($videoUrls, parseM3U8($response->body()));
    //     // dd($response);

    //     }
        
    //     // Create a new M3U8 playlist and add all the video URLs to it
    //     // $newPlaylist = "#EXTM3U\n";
    //     // foreach ($playlistUrls as $videoUrl) {
    //     //     $newPlaylist .= "#EXTINF:-1,$videoUrl\n";
    //     //     $newPlaylist .= "$videoUrl\n";
    //     // }
        
    //     // // Serve the new M3U8 playlist as a single URL
    //     // return response($newPlaylist, 200, [
    //     //     'Content-Type' => 'application/vnd.apple.mpegurl',
    //     // ]);

    //     // dd($combinedM3U8);
        
    //     $combinedM3U8 = "";
    //     foreach($videos as $url) {

    //         $m3u8 = file_get_contents($url->path);
    //         $combinedM3U8 .= $m3u8;
    //     }
    //         $hlsOutput = URL::to('/storage/app/public/output.m3u8');
        
    // //    touch(public_path() . "/uploads/videos/outputone.m3u8");
    //    touch(storage_path('app/public/output.m3u8'));
    //         //open file abc.txt
    //         // $myfile = fopen("output.m3u8", "w");
    //         $myfile =  fopen(storage_path('app/public/output.m3u8'), "w");

    //         fwrite($myfile, $combinedM3U8);;

    //         fclose($myfile);


    //     $file = $hlsOutput;

    //     return $hlsOutput;

    // }

    public function combineM3U8(Request $request)
    {
        // Get the list of M3U8 URLs from the request
        $m3u8Urls = $request->input('m3u8_urls');

        $playlistUrls= Video::where('type','=','')->orWhere('type', '=', null)->where('active',1)->where('status',1)->get()->map(function ($item) {       
            $item['path'] = URL::to('/storage/app/public/') . '/' . $item->path . '.m3u8';
       return $item;
     });

        // Create a new Guzzle HTTP client
        $client = new Client();

        // Initialize an empty array to store the contents of the M3U8 files
        $m3u8Files = [];

        foreach ($playlistUrls as $url) {
            $response = $client->get($url->path);
        // dd($response->getBody()->getContents());

            $m3u8Files[] = $response->getBody()->getContents();
        }

        // Combine the contents of the M3U8 files into a single string
        $combinedM3U8 = implode("\n", $m3u8Files);


        touch(storage_path('app/public/M3U8Test.m3u8'));

        $myfile =  fopen(storage_path('app/public/M3U8Test.m3u8'), "w");

        fwrite($myfile, $combinedM3U8);;

        fclose($myfile);


        // Return the combined M3U8 file as a response
        return response($combinedM3U8, 200, [
            'Content-Type' => 'application/vnd.apple.mpegurl',
        ]);

        
    }

    public function combineM3U8new(Request $request)
    {
        $playlistUrls= Video::where('type','=','')->orWhere('type', '=', null)->where('active',1)->where('status',1)->get()->map(function ($item) {       
            $item['path'] = URL::to('/storage/app/public/') . '/' . $item->path . '.m3u8';
       return $item;
     });
            
            // Define the output file name
            $outputFile = 'mergedPlaylist.m3u8';
            
            // Create a new FFmpeg instance
            $ffmpeg = \FFMpeg\FFMpeg::create([
                'ffmpeg.binaries'  => 'H:/ffmpegtest/bin/ffmpeg.exe', // the path to the FFMpeg binary
                'ffprobe.binaries' => 'H:/ffmpegtest/bin/ffprobe.exe', // the path to the FFProbe binary
                'timeout'          => 0, // the timeout for the underlying process
                'ffmpeg.threads'   => 1,   // the number of threads that FFMpeg should use
            ]);
            // Loop through the URLs and load each M3U8 file into FFmpeg
            $inputFiles = [];
            foreach ($playlistUrls as $url) {
                // Download the M3U8 file from the URL and save it to a temporary file
                $tempFile = tempnam(storage_path('app/public/'), 'm3u8');
                file_put_contents($tempFile, file_get_contents($url->path));
            
                // Load the M3U8 file into FFmpeg and add it to the input files array
                $inputFiles[] = $ffmpeg->formatFrom($tempFile)->fromFile($tempFile);
            }
            
            // Merge the input files into a single output file
            $concat = $ffmpeg->getFFMpegDriver()->newConcat();
            foreach ($inputFiles as $inputFile) {
                $concat->addFile($inputFile->getPath());
            }
            $mergedFile = $concat->saveToFile($outputFile);
            
            // Output the contents of the merged M3U8 file
            echo file_get_contents($outputFile);
        }


        
    public function BunnycdnVideolibrary(Request $request)
    {
        $data = $request->all();
        $value = [];

           // Bunny Cdn get Videos 
                
           $storage_settings = StorageSetting::first();

           if(!empty($storage_settings) && $storage_settings->bunny_cdn_storage == 1 
           && !empty($storage_settings->bunny_cdn_hostname) && !empty($storage_settings->bunny_cdn_storage_zone_name) 
           && !empty($storage_settings->bunny_cdn_ftp_access_key)  ){
               
               $videolibraryurl = "https://api.bunny.net/videolibrary?page=0&perPage=1000&includeAccessKey=false/";
               
               $ch = curl_init();
               
               $options = array(
                   CURLOPT_URL => $videolibraryurl,
                   CURLOPT_RETURNTRANSFER => true,
                   CURLOPT_HTTPHEADER => array(
                       "AccessKey: {$storage_settings->bunny_cdn_access_key}",
                       'Content-Type: application/json',
                   ),
               );
               
               curl_setopt_array($ch, $options);
               
               $response = curl_exec($ch);
               $videolibrary = json_decode($response, true);
               curl_close($ch);
               // dd($videolibrary); ApiKey

           }else{
               $decodedResponse = [];
               $videolibrary = [];

           }

           if(count($videolibrary) > 0){

                foreach($videolibrary as $key => $value){



                    if( $value['Id'] == $request->videolibrary_id){



                        $videolibrary_id = $value['Id'];
                        $videolibrary_ApiKey = $value['ApiKey']; 
                        $videolibrary_PullZoneId = $value['PullZoneId']; 
                        break;
                    }else{
                        $videolibrary_id = null;
                        $videolibrary_ApiKey = null; 
                        $videolibrary_PullZoneId = null; 
                    }
                }
         

           }else{
                $videolibrary_id = null;
                $videolibrary_ApiKey = null; 
                $videolibrary_PullZoneId = null; 
            }

        
            if($videolibrary_id != null && $videolibrary_ApiKey != null){

                $client = new \GuzzleHttp\Client();
                // $videolibrary_PullZoneId
                $client = new \GuzzleHttp\Client();
                
                $PullZone = $client->request('GET', 'https://api.bunny.net/pullzone/' . $videolibrary_PullZoneId . '?includeCertificate=false', [
                    'headers' => [
                        'AccessKey' => $storage_settings->bunny_cdn_access_key,
                        'accept' => 'application/json',
                    ],
                ]);

                $PullZoneData = json_decode($PullZone->getBody()->getContents());

                    if(!empty($PullZoneData) && !empty($PullZoneData->Name)){
                        // vz-2117a0a6-f55  https://vz-5c4af3d1-257.b-cdn.net
                        $PullZoneURl = 'https://'. $PullZoneData->Name. '.b-cdn.net';
                    }else{
                        $PullZoneURl = null;
                    }
                    // dd($PullZoneURl);

                $response = $client->request('GET', 'https://video.bunnycdn.com/library/' . $videolibrary_id . '/videos?page=1&itemsPerPage=100&orderBy=date', [
                        'headers' => [
                        'AccessKey' => $videolibrary_ApiKey,
                        'accept' => 'application/json',
                    ],
                ]);
                $streamvideos = $response->getBody()->getContents();
                // echo $response->getBody();
                // exit;
           
            }else{
                $streamvideos = [];
            }

        // print_r($response);exit;
            // return $streamvideos;
            $responseData = [
                'streamvideos' => $streamvideos,
                'PullZoneURl' => $PullZoneURl,
            ];
        
            return $responseData;
        
    }

    
    public function StreamBunnyCdnVideo(Request $request)
    {
        $data = $request->all();
        $value = [];

        if (!empty($data["bunny_cdn_linked_video"])) {


            $video = new Video();
            $video->disk = "public";
            $video->original_name = "public";
            $video->title = $data["bunny_cdn_linked_video"];
            $video->m3u8_url = $data["bunny_cdn_linked_video"];
            $video->type = "m3u8_url";
            $video->draft = 0;
            $video->active = 1;
            $video->image = default_vertical_image();
            $video->video_tv_image = default_horizontal_image();
            $video->player_image = default_horizontal_image();
            $video->user_id = Auth::user()->id;
            $video->save();

            $video_id = $video->id;

            $value["success"] = 1;
            $value["message"] = "Uploaded Successfully!";
            $value["video_id"] = $video_id;

            \LogActivity::addVideoLog("Added Bunny CDN VIDEO URl Video.", $video_id);

            return $value;
        }
    }

    
    
    public function ExtractedImage(Request $request)
    {
        try {
            // print_r($request->all());exit;
            $value = [];

            $ExtractedImage =  VideoExtractedImages::where('video_id',$request->video_id)->where('socure_type','Video')->get();
           
            $value["success"] = 1;
            $value["message"] = "Uploaded Successfully!";
            $value["video_id"] = $request->video_id;
            $value["ExtractedImage"] = $ExtractedImage;


            return $value;

        } catch (\Throwable $th) {
            throw $th;
        }

    }

    public function combinevideo(Request $request){
        try {
            // Array of video URLs
                $m3u8Urls = [
                    'https://localhost/flicknexs/storage/app/public/Gs6LJZ0PTl3ynjn3.m3u8',
                    'https://localhost/flicknexs/storage/app/public/B5Lh9CdVSPoe5QTN.m3u8',
                ];
                // 'https://localhost/flicknexs/storage/app/public/GOM8pKrjNNCLGACc.mp4',
                // 'https://localhost/flicknexs/storage/app/public/CnKjtQWUQHjDKXEA.mp4',

    // Create a master playlist file (M3U8)
    $masterPlaylistPath = 'master_playlist.m3u8';

    // Generate the content for the master playlist
    $masterPlaylistContent = "#EXTM3U\n";

    // Add each M3U8 URL to the master playlist
    foreach ($m3u8Urls as $index => $m3u8Url) {
        $masterPlaylistContent .= "#EXT-X-STREAM-INF:BANDWIDTH=1000000,RESOLUTION=640x360,CODECS=\"mp4a.40.2,avc1.64001f\"\n";
        $masterPlaylistContent .= $m3u8Url . "\n";
    }

    // Save the master playlist file
    Storage::disk('local')->put($masterPlaylistPath, $masterPlaylistContent);

    // Optionally, serve the master playlist using Laravel
    return response()->file(storage_path("app/{$masterPlaylistPath}"));

                    // Save the master playlist file
                    // file_put_contents($masterPlaylistPath, $masterPlaylistContent);

                    // // Optionally, serve the master playlist using Laravel
                    // return response()->file($masterPlaylistPath);
                
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    private  function UploadVideoBunnyCDNStream(  $storage_settings,$libraryid,$mp4_url){
    // Bunny Cdn get Videos 

    $storage_settings = StorageSetting::first();

    if(!empty($storage_settings) && $storage_settings->bunny_cdn_storage == 1 
    && !empty($storage_settings->bunny_cdn_access_key) ){
        
        $libraryurl = "https://api.bunny.net/videolibrary?page=0&perPage=1000&includeAccessKey=false/";
        
        $ch = curl_init();
        
        $options = array(
            CURLOPT_URL => $libraryurl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                "AccessKey: {$storage_settings->bunny_cdn_access_key}",
                'Content-Type: application/json',
            ),
        );
        
        curl_setopt_array($ch, $options);
        
        $response = curl_exec($ch);
        $librarys = json_decode($response, true);
        curl_close($ch);

    }else{
        $librarys = [];

    }
    if(count($librarys) > 0){
        foreach($librarys as $key => $value){
            if( $value['Id'] == $libraryid){
                $library_id = $value['Id'];
                $library_ApiKey = $value['ApiKey']; 
                $library_PullZoneId = $value['PullZoneId']; 
                break;
            }else{
                $library_id = null;
                $library_ApiKey = null; 
                $library_PullZoneId = null; 
            }
        }
    }else{
        $library_id = null;
        $library_ApiKey = null; 
        $library_PullZoneId = null; 
    }
    
    if($library_id != null && $library_ApiKey != null){

        $client = new \GuzzleHttp\Client();
        
        $PullZone = $client->request('GET', 'https://api.bunny.net/pullzone/' . $library_PullZoneId . '?includeCertificate=false', [
            'headers' => [
                'AccessKey' => $storage_settings->bunny_cdn_access_key,
                'accept' => 'application/json',
            ],
        ]);

        $PullZoneData = json_decode($PullZone->getBody()->getContents());

            if(!empty($PullZoneData) && !empty($PullZoneData->Name)){
                $PullZoneURl = 'https://'. $PullZoneData->Name. '.b-cdn.net';
            }else{
                $PullZoneURl = null;
            }    
        }
        
        $file_name = pathinfo($mp4_url->getClientOriginalName(), PATHINFO_FILENAME);
        $filename =  str_replace(' ', '_',$file_name);

        // Step 1: Create the video entry in the library
        try {
            $response = $client->request('POST', "https://video.bunnycdn.com/library/{$libraryid}/videos", [
                'json' => ['title' => $filename], // Use 'json' directly to set headers and body
                'headers' => [
                    'AccessKey' => $library_ApiKey,
                    'Accept' => 'application/json',
                ]
            ]);
        
            $responseData = json_decode($response->getBody(), true);
            $guid = $responseData['guid'];
        } catch (RequestException $e) {
            echo "Error creating video entry: " . $e->getMessage();
            exit;
        }
        
        // Step 2: Upload the video file

        try {

            $context = stream_context_create([
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ],
            ]);
            // Fetch video file content using file_get_contents with SSL context
            $videoData = file_get_contents($mp4_url, false, $context);
            
            $response = $client->request('PUT', "https://video.bunnycdn.com/library/{$libraryid}/videos/{$guid}", [
                'headers' => [
                    'AccessKey' => $library_ApiKey,
                    'Content-Type' => 'video/mp4' 
                ],
                'body' => $videoData 
            ]);

            $videoUrl = $PullZoneURl . '/' . $guid . '/playlist.m3u8';
            // echo "<pre>";
            // echo "Video uploaded successfully: " . $videoUrl;
            // echo "<pre>";
            // echo "Video uploaded successfully: " . $guid;
            // echo "<pre>";  echo "Video uploaded successfully: " . $response->getBody();

            $responseuploaded = json_decode($response->getBody(), true);
            $statusCode = $responseuploaded['statusCode'];

        } catch (RequestException $e) {
            echo "Error uploading video: " . $e->getMessage();
            exit;
        }
        $value = [];
        if($statusCode == 200){

            $video = new Video();
            $video->disk = "public";
            $video->original_name = "public";
            $video->title = $file_name;
            $video->m3u8_url = $videoUrl;
            $video->type = "m3u8_url";
            $video->draft = 1;
            $video->active = 0;
            $video->image = default_vertical_image();
            $video->video_tv_image = default_horizontal_image();
            $video->player_image = default_horizontal_image();
            $video->user_id = Auth::user()->id;
            $video->save();

            $video_id = $video->id;

            if(Enable_Extract_Image() == 1){
                // extractImageFromVideo
            
                $rand = Str::random(16);

                $ffmpeg = \FFMpeg\FFMpeg::create();
                $videoFrame = $ffmpeg->open($mp4_url);
                
                // Define the dimensions for the frame (16:9 aspect ratio)
                $frameWidth = 1280;
                $frameHeight = 720;
                
                // Define the dimensions for the frame (9:16 aspect ratio)
                $frameWidthPortrait = 1080;  // Set the desired width of the frame
                $frameHeightPortrait = 1920; // Calculate height to maintain 9:16 aspect ratio
                
                $randportrait = 'portrait_' . $rand;
                
                $interval = 5; // Interval for extracting frames in seconds
                $totalDuration = round($videoFrame->getStreams()->videos()->first()->get('duration'));
                $totalDuration = intval($totalDuration);


                if ( 600 < $totalDuration) { 
                    $timecodes = [5, 120, 240, 360, 480]; 
                } else { 
                    $timecodes = [5, 10, 15, 20, 25]; 
                }

                
                foreach ($timecodes as $index => $time) {
                    $imagePortraitPath = public_path("uploads/images/{$video_id}_{$randportrait}_{$index}.jpg");
                    $imagePath = public_path("uploads/images/{$video_id}_{$rand}_{$index}.jpg");
            
                    try {
                        $videoFrame
                            ->frame(TimeCode::fromSeconds($time))
                            ->save($imagePath, new X264('libmp3lame', 'libx264'), null, new Dimension($frameWidth, $frameHeight));
            
                        $videoFrame
                            ->frame(TimeCode::fromSeconds($time))
                            ->save($imagePortraitPath, new X264('libmp3lame', 'libx264'), null, new Dimension($frameWidthPortrait, $frameHeightPortrait));
            
                        $VideoExtractedImage = new VideoExtractedImages();
                        $VideoExtractedImage->user_id = Auth::user()->id;
                        $VideoExtractedImage->socure_type = 'Video';
                        $VideoExtractedImage->video_id = $video_id;
                        $VideoExtractedImage->image_path = URL::to("/public/uploads/images/" . $video_id . '_' . $rand . '_' . $index . '.jpg');
                        $VideoExtractedImage->portrait_image = URL::to("/public/uploads/images/" . $video_id . '_' . $randportrait . '_' . $index . '.jpg');
                        $VideoExtractedImage->image_original_name = $video_id . '_' . $rand . '_' . $index . '.jpg';
                        $VideoExtractedImage->save();
                    } catch (\Exception $e) {
                        dd($e->getMessage());
                    }
                }
            
            }


            $value["success"] = 1;
            $value["message"] = "Uploaded Successfully!";
            $value["video_id"] = $video_id;
            $value["video_title"] = $file_name;

            \LogActivity::addVideoLog("Added Bunny CDN VIDEO Upload.", $video_id);
            return $value ;
        }else{
            $value["success"] = 2;
            \LogActivity::addVideoLog("Failed Bunny CDN VIDEO Upload.", $video_id);
            return $value ;
        }
    }


    private  function UploadVideoStreamVideoCipher(  $storage_settings,$mp4_url){
      
            
         try {
            // 008fb53adbd94e11889bfd3994899bf5



            $curl = curl_init();

                curl_setopt_array($curl, array(
                CURLOPT_URL => "https://dev.vdocipher.com/api/videos/008fb53adbd94e11889bfd3994899bf5/12345678",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode([
                    "ttl" => 300,
                ]),
                CURLOPT_HTTPHEADER => array(
                    "Accept: application/json",
                    "Authorization: Apisecret 008fb53adbd94e11889bfd3994899bf5",
                    "Content-Type: application/json"
                ),
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                if ($err) {
                echo "cURL Error #:" . $err;
                } else {
                echo $response;
                }

                exit;

            // $response = $this->client->request('POST', "https://dev.vdocipher.com/api/videos/008fb53adbd94e11889bfd3994899bf5/12345678", [
            //     'headers' => [
            //         'Authorization' => "Apisecret {$this->apiKey}",
            //     ],
            //         'json' => [
            //             'title' => $title,
            //             'folderId' => 'YOUR_FOLDER_ID', 
            //         ],
            // ]);

                // $response = $this->client->request('POST', 'https://dev.vdocipher.com/api/videos', [
                //     'headers' => [
                //         'Authorization' => "Apisecret {$this->apiKey}",
                //     ],
                //     'json' => [
                //         'title' => $title,
                //         'folderId' => 'YOUR_FOLDER_ID', 
                //     ],
                // ]);

                return json_decode($response->getBody());
             } catch (\Exception $e) {
                    return response()->json(['message' => 'Video upload failed!', 'error' => $e->getMessage()], 500);
            }


        
                // $curl = curl_init();

                // curl_setopt_array($curl, array(
                // CURLOPT_URL => "https://dev.vdocipher.com/api/videos?title=$mp4_url&folderId=633c60bd04514ebd8af551c77274c974",
                // CURLOPT_RETURNTRANSFER => true,
                // CURLOPT_ENCODING => "",
                // CURLOPT_MAXREDIRS => 10,
                // CURLOPT_TIMEOUT => 30,
                // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                // CURLOPT_CUSTOMREQUEST => "PUT",
                // CURLOPT_HTTPHEADER => array(
                //     "Authorization: Apisecret 9HPQ8xwdeSLL4ATNAIbqNk8ynOSsxMMoeWpE1p268Y5wuMYkBpNMGjrbAN0AdEnE"
                // ),
                // ));

                // $response = curl_exec($curl);
                // $err = curl_error($curl);

                // curl_close($curl);

                // if ($err) {
                // echo "cURL Error #:" . $err;
                // } else {
                //     echo "<pre>";
                // echo $response;
                // }
                // exit;
                // $video = $mp4_url;
                // $videoPath = $video->getPathname();
        
                // try {
                //     $response = $this->client->request('POST', 'https://dev.vdocipher.com/api/v3/upload', [
                //         'headers' => [
                //             'Authorization' => "Apisecret {$this->apiKey}",
                //         ],
                //         'multipart' => [
                //             [
                //                 'name' => 'file',
                //                 'contents' => fopen($videoPath, 'r'),
                //                 'filename' => $video->getClientOriginalName(),
                //             ]
                //         ]
                //     ]);
        
                //     $data = json_decode($response->getBody(), true);
        
                //     return response()->json(['message' => 'Video uploaded successfully!', 'data' => $data]);
                // } catch (\Exception $e) {
                //     return response()->json(['message' => 'Video upload failed!', 'error' => $e->getMessage()], 500);
                // }
            }

            public function getvideocihperdata(){



                $videoId = "597244970fe8487ab2b6d026719397ac"; 
                $apiKey = videocipher_Key();

                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://dev.vdocipher.com/api/videos/$videoId/otp",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => json_encode([
                        "ttl" => 300, // 5 minutes TTL
                        // "whitelisthref" => "https://localhost/flicknexs"
                    ]),
                    CURLOPT_HTTPHEADER => array(
                        "Accept: application/json",
                        "Authorization: Apisecret $apiKey",
                        "Content-Type: application/json"
                    ),
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                if ($err) {
                    echo "cURL Error #:" . $err;
                } else {
                    $responseObj = json_decode($response, true);
                    dd($responseObj);
                    // if (isset($responseObj['otp'])) {
                    //     // Use the OTP in your embed code
                    //     echo "responseObj OTP: " . $responseObj;
                        
                    // } else {
                    //     echo "Error: " . $responseObj['error']['message'];
                    // }
                }

                // $curl = curl_init();

                // curl_setopt_array($curl, array(
                // CURLOPT_URL => "https://dev.vdocipher.com/api/videos/597244970fe8487ab2b6d026719397ac/otp",
                // CURLOPT_RETURNTRANSFER => true,
                // CURLOPT_ENCODING => "",
                // CURLOPT_MAXREDIRS => 10,
                // CURLOPT_TIMEOUT => 30,
                // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                // CURLOPT_CUSTOMREQUEST => "POST",
                // CURLOPT_POSTFIELDS => json_encode([
                //     "ttl" => 300,
                //     // "whitelisthref" => "https://localhost/flicknexs"
                // ]),
                // CURLOPT_HTTPHEADER => array(
                //     "Accept: application/json",
                //     "Authorization: Apisecret 9HPQ8xwdeSLL4ATNAIbqNk8ynOSsxMMoeWpE1p268Y5wuMYkBpNMGjrbAN0AdEnE",
                //     "Content-Type: application/json"
                // ),
                // ));

                // $response = curl_exec($curl);
                // $err = curl_error($curl);

                // curl_close($curl);
                // echo "<pre>";
                // if ($err) {
                // echo "cURL Error #:" . $err;
                // } else {
                    
                // echo $response;
                // }

                exit;

            //     $curl = curl_init();

            //     curl_setopt_array($curl, array(
            //     CURLOPT_URL => "https://dev.vdocipher.com/api/videos?title=title&folderId=633c60bd04514ebd8af551c77274c974",
            //     CURLOPT_RETURNTRANSFER => true,
            //     CURLOPT_ENCODING => "",
            //     CURLOPT_MAXREDIRS => 10,
            //     CURLOPT_TIMEOUT => 30,
            //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //     CURLOPT_CUSTOMREQUEST => "PUT",
            //     CURLOPT_HTTPHEADER => array(
            //         "Authorization: Apisecret 9HPQ8xwdeSLL4ATNAIbqNk8ynOSsxMMoeWpE1p268Y5wuMYkBpNMGjrbAN0AdEnE"
            //     ),
            //     ));

            //     $response = curl_exec($curl);
            //     $err = curl_error($curl);

            //     curl_close($curl);

            //     if ($err) {
            //     echo "cURL Error #:" . $err;
            //     } else {
            //         echo "<pre>";
            //     echo $response;
            //     }

            }

        public function videocihperplayer(){

            $videoId = "b69110c2cfc54e09b015aa07739311a4"; 
            $apiKey = videocipher_Key();

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://dev.vdocipher.com/api/videos/$videoId/otp",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode([
                    "ttl" => 30000, 
                ]),
                CURLOPT_HTTPHEADER => array(
                    "Accept: application/json",
                    "Authorization: Apisecret $apiKey",
                    "Content-Type: application/json"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $responseObj = json_decode($response, true);

            }


            $data = [
                'otp' =>  $responseObj['otp'],
                'playbackInfo' =>  $responseObj['playbackInfo'],
            ];
            
            return View("admin.videos.videocipher", $data);

        }


        
        public function shakaplayer(){

            return View("admin.videos.shakaplayer");

        }


        public function VideoCipherFileUpload(Request $request)
        {
            if (!Auth::user()->role == 'admin') {
                return redirect('/home');
            }
    


            $user_package = User::where('id', 1)->first();
            $data = $request->all();
    
            $validatedData = $request->validate([
                'title' => 'required|max:255',
            ]);
            
            // $createdVideo = Video::create([
            //                 'title' => $request->title,
            //             ]);

            $id = $data['video_upload_id'];
            $video = Video::findOrFail($id);

            Video::query()->where('id','!=', $id)->update(['today_top_video' => 0]);
    
            if (!empty($video->embed_code)) {
                $embed_code = $video->embed_code;
            } else {
                $embed_code = '';
            }
    
            if (!empty($data['ppv_price']) && $data['ppv_price'] > 0) {
                $video->global_ppv = 1;
            } else {
                $video->global_ppv = null;
            }
    
            $settings = Setting::where('ppv_status', '=', 1)->first();
    
            // if (!empty($data['global_ppv'])) {
            //     $data['ppv_price'] = $settings->ppv_price;
            //     $video->global_ppv = $data['global_ppv'];
            // } else {
            //     $video->global_ppv = null;
            // }
    
            if($request->ppv_price == null && empty($data["global_ppv"]) ){
                $video->global_ppv = null;
                $data["ppv_price"] = null;
            }else if(empty($data["global_ppv"]) && empty($data["ppv_price"]) ){
                $video->global_ppv = null;
                $data["ppv_price"] = null;
            }else{
    
                if (!empty($data["global_ppv"]) && !empty($data["set_gobal_ppv_price"]) && $request->ppv_option == 1) {
                    $video->global_ppv = $data["global_ppv"];
                    $data["ppv_price"] = $data["set_gobal_ppv_price"];
                } else if(!empty($data["global_ppv"])  && $request->ppv_option == 2) {
                    $video->global_ppv = $data["global_ppv"];
                    $data["ppv_price"] = $settings->ppv_price;
                } else if(!empty($data["global_ppv"])  && !empty($data["set_gobal_ppv_price"])) {
                    $video->global_ppv = $data["global_ppv"];
                    $data["ppv_price"] = $data["set_gobal_ppv_price"];
                }  else if(!empty($data["global_ppv"])) {
                    $video->global_ppv = $data["global_ppv"];
                    $data["ppv_price"] = $settings->ppv_price;
                }else if(empty($data["global_ppv"]) && !empty($data["ppv_price"])  && $request->ppv_price != null) {
                    $data["ppv_price"] = $request->ppv_price;
                    $video->global_ppv = null;
                }elseif(!empty($data["ppv_price"])) {
                    $video->global_ppv = null;
                    $data["ppv_price"] = $data["ppv_price"];
                } else {
                    $video->global_ppv = null;
                    $data["ppv_price"] = null;
                }
            }

            if ($request->slug == '') {
                $data['slug'] = $this->createSlug($data['title']);
            } else {
                $data['slug'] = $this->createSlug($data['slug']);
            }
    
            $video->free_duration_status  = !empty($request->free_duration_status) ? 1 : 0 ;
    
            if (isset($request->free_duration)) {
                $time_seconds = Carbon::createFromFormat('H:i:s', $request->free_duration)->diffInSeconds(Carbon::createFromTime(0, 0, 0));
                $video->free_duration = $time_seconds;
            }
    
            $trailer = isset($data['trailer']) ? $data['trailer'] : '';
            $files = isset($data['subtitle_upload']) ? $data['subtitle_upload'] : '';
            $image_path = public_path() . '/uploads/images/';
    
            // Image
            if ($request->hasFile('image')) {
                    $tinyimage = $request->file('image');
                if (compress_image_enable() == 1) {
                    $image_filename = time() . '.' . compress_image_format();
                    $tiny_video_image = 'tiny-image-' . $image_filename;
                    Image::make($tinyimage)->resize(450,320)->save(base_path() . '/public/uploads/images/' . $tiny_video_image, compress_image_resolution());
                } else {
                    $image_filename = time() . '.' . $tinyimage->getClientOriginalExtension();
                    $tiny_video_image = 'tiny-image-' . $image_filename;
                    Image::make($tinyimage)->resize(450,320)->save(base_path() . '/public/uploads/images/' . $tiny_video_image, compress_image_resolution());
    
                }
            }else{
                $tiny_video_image = null;
    
            }
            if ($request->hasFile('player_image')) {
    
                $tinyplayer_image = $request->file('player_image');
    
                if (compress_image_enable() == 1) {
                    $player_image_filename = time() . '.' . compress_image_format();
                    $tiny_player_image = 'tiny-player_image-' . $image_filename;
                    Image::make($tinyplayer_image)->resize(450,320)->save(base_path() . '/public/uploads/images/' . $tiny_player_image, compress_image_resolution());
                } else {
                    $image_filename = time() . '.' . $tinyplayer_image->getClientOriginalExtension();
                    $tiny_player_image = 'tiny-player_image-' . $image_filename;
                    Image::make($tinyplayer_image)->resize(450,320)->save(base_path() . '/public/uploads/images/' . $tiny_player_image, compress_image_resolution());
    
                }
            }else{
                $tiny_player_image = null;
    
            }
            if ($request->hasFile('video_title_image')) {
    
                $tinyvideo_title_image = $request->file('video_title_image');
    
                if (compress_image_enable() == 1) {
                    $image_filename = time() . '.' . compress_image_format();
                    $tiny_video_title_image = 'tiny-video_title_image-' . $image_filename;
                    Image::make($tinyvideo_title_image)->resize(450,320)->save(base_path() . '/public/uploads/images/' . $tiny_video_title_image, compress_image_resolution());
                } else {
                    $image_filename = time() . '.' . $tinyvideo_title_image->getClientOriginalExtension();
                    $tiny_video_title_image = 'tiny-video_title_image-' . $image_filename;
                    Image::make($tinyvideo_title_image)->resize(450,320)->save(base_path() . '/public/uploads/images/' . $tiny_video_title_image, compress_image_resolution());
    
                }
            }else{
                $tiny_video_title_image = null;
    
            }
    
            $data["tiny_video_image"] = $tiny_video_image;
            $data["tiny_player_image"] = $tiny_player_image;
            $data["tiny_video_title_image"] = $tiny_video_title_image;
    
            if ($request->hasFile('image')) {
                $file = $request->image;
                if (compress_image_enable() == 1) {
                    $image_filename = time() . '.' . compress_image_format();
                    $video_image = 'pc-image-' . $image_filename;
                    $Mobile_image = 'Mobile-image-' . $image_filename;
                    $Tablet_image = 'Tablet-image-' . $image_filename;
    
                    Image::make($file)->save(base_path() . '/public/uploads/images/' . $video_image, compress_image_resolution());
                    Image::make($file)->save(base_path() . '/public/uploads/images/' . $Mobile_image, compress_image_resolution());
                    Image::make($file)->save(base_path() . '/public/uploads/images/' . $Tablet_image, compress_image_resolution());
                } else {
                    $image_filename = time() . '.' . $file->getClientOriginalExtension();
    
                    $video_image = 'pc-image-' . $image_filename;
                    $Mobile_image = 'Mobile-image-' . $image_filename;
                    $Tablet_image = 'Tablet-image-' . $image_filename;
    
                    Image::make($file)->save(base_path() . '/public/uploads/images/' . $video_image);
                    Image::make($file)->save(base_path() . '/public/uploads/images/' . $Mobile_image);
                    Image::make($file)->save(base_path() . '/public/uploads/images/' . $Tablet_image);
                }
    
                $data["image"] = $video_image;
                $data["mobile_image"] = $Mobile_image;
                $data["tablet_image"] = $Tablet_image;
    
            }else if (!empty($request->video_image_url)) {
                $data["image"] = $request->video_image_url;
            } else {
                // Default Image
    
                $data["image"]  = default_vertical_image() ;
                $data["mobile_image"] = default_vertical_image();
                $data["tablet_image"] = default_vertical_image();
    
            }
    
            // Player Image
            // $request->selected_image_url = '';
            if ($request->hasFile('player_image')) {
                $player_image = $request->player_image;
    
                if (compress_image_enable() == 1) {
                    $player_filename = time() . '.' . compress_image_format();
                    $players_image = 'player-image-' . $player_filename;
                    Image::make($player_image)->save(base_path() . '/public/uploads/images/' . $players_image, compress_image_resolution());
                } else {
                    $player_filename = time() . '.' . $player_image->getClientOriginalExtension();
                    $players_image = 'player-image-' . $player_filename;
                    Image::make($player_image)->save(base_path() . '/public/uploads/images/' . $players_image);
                }
    
                $data["player_image"] = $players_image;
    
            }else if (!empty($request->selected_image_url)) {
                $data["player_image"] = $request->selected_image_url;
            } else {
                $data["player_image"] = default_horizontal_image();
            }
            // dd($data["player_image"]);
            // Tv video Image
    
            if ($request->hasFile('video_tv_image')) {
                $video_tv_image = $request->video_tv_image;
    
                if (compress_image_enable() == 1) {
                    $Tv_image_format = time() . '.' . compress_image_format();
                    $Tv_image_filename = 'tv-live-image-' . $Tv_image_format;
                    Image::make($video_tv_image)->save(base_path() . '/public/uploads/images/' . $Tv_image_filename, compress_image_resolution());
                } else {
                    $Tv_image_format = time() . '.' . $video_tv_image->getClientOriginalExtension();
                    $Tv_image_filename = 'tv-live-image-' . $Tv_image_format;
                    Image::make($video_tv_image)->save(base_path() . '/public/uploads/images/' . $Tv_image_filename);
                }
    
                $data["video_tv_image"] = $Tv_image_filename;
    
            }else if (!empty($request->selected_tv_image_url)) {
                $data["video_tv_image"] = $request->selected_tv_image_url;
            } else {
                $data["video_tv_image"] = default_horizontal_image();
            }
    
            // Video Title Thumbnail
    
            if ($request->hasFile('video_title_image')) {
                $video_title_image = $request->video_title_image;
    
                if (compress_image_enable() == 1) {
                    $video_title_image_format = time() . '.' . compress_image_format();
                    $video_title_image_filename = 'video-title-' . $video_title_image_format;
                    Image::make($video_title_image)->save(base_path() . '/public/uploads/images/' . $video_title_image_filename, compress_image_resolution());
                } else {
                    $video_title_image_format = time() . '.' . $video_title_image->getClientOriginalExtension();
                    $video_title_image_filename = 'video-title-' . $video_title_image_format;
                    Image::make($video_title_image)->save(base_path() . '/public/uploads/images/' . $video_title_image_filename);
                }
    
                $video->video_title_image = $video_title_image_filename;
            }
    
            if (empty($data['active'])) {
                $data['active'] = 0;
            }
    
            if (empty($data['webm_url'])) {
                $data['webm_url'] = 0;
            } else {
                $data['webm_url'] = $data['webm_url'];
            }
    
            if (empty($data['ogg_url'])) {
                $data['ogg_url'] = 0;
            } else {
                $data['ogg_url'] = $data['ogg_url'];
            }
    
            if (empty($data['year'])) {
                $data['year'] = 0;
            } else {
                $data['year'] = $data['year'];
            }
            if (empty($data['searchtags'])) {
                $searchtags = null;
            } else {
                $searchtags = $data['searchtags'];
            }
    
            if (empty($data['language'])) {
                $data['language'] = 0;
            } else {
                $data['language'] = $data['language'];
            }
    
            if (empty($data['featured'])) {
                $featured = 0;
            } else {
                $featured = 1;
            }
    
            if (empty($data['featured'])) {
                $data['featured'] = 0;
            }
    
            if (!empty($data['embed_code'])) {
                $data['embed_code'] = $data['embed_code'];
            }
    
            if (empty($data['active'])) {
                $data['active'] = 0;
            }
    
            if (empty($data['video_gif'])) {
                $data['video_gif'] = '';
            }
    
            if (empty($data['status'])) {
                $data['status'] = 0;
            }
    
            $package = User::where('id', 1)->first();
            $pack = $package->package;
    
            if (Auth::user()->role == 'admin') {
                $data['status'] = 1;
            }
            $settings = Setting::first();
    
            if (Auth::user()->role == 'admin' && $pack != 'Business') {
                $data['status'] = 1;
            } elseif (Auth::user()->role == 'admin' && $pack == 'Business' && $settings->transcoding_access == 1) {
                if ($video->processed_low < 100) {
                    $data['status'] = 0;
                } else {
                    $data['status'] = 1;
                }
            } elseif (Auth::user()->role == 'admin' && $pack == 'Business' && $settings->transcoding_access == 0) {
                $data['status'] = 1;
            } else {
                $data['status'] = 1;
            }
    
            if (Auth::user()->role == 'admin' && Auth::user()->sub_admin == 1) {
                $data['status'] = 0;
            }
    
            if (!empty($data['Recommendation'])) {
                $video->Recommendation = $data['Recommendation'];
            }
            if (empty($data['publish_type'])) {
                $publish_type = 0;
            } else {
                $publish_type = $data['publish_type'];
            }
    
            if (empty($data['publish_time'])) {
                $publish_time = 0;
            } else {
                $publish_time = $data['publish_time'];
            }
    
            $path = public_path() . '/uploads/videos/';
            $image_path = public_path() . '/uploads/images/';
    
            // Enable Video Title Thumbnail
    
            $video->enable_video_title_image = $request->enable_video_title_image ? '1' : '0';
    
            $video->trailer_type = $data['trailer_type'];
            $StorageSetting = StorageSetting::first();
            // dd($StorageSetting);
            if ($StorageSetting->site_storage == 1) {
                if ($data['trailer_type'] == 'video_mp4') {
                    $settings = Setting::first();
    
                    if ($trailer != '' && $pack == 'Business' && $settings->transcoding_access == 1 && $data['trailer_type'] == 'video_mp4') {
                        $settings = Setting::first();
                        // $resolution = explode(",",$settings->transcoding_resolution);
                        if ($settings->transcoding_resolution != null) {
                            $convertresolution = [];
                            $resolution = explode(',', $settings->transcoding_resolution);
    
                            foreach ($resolution as $value) {
                                if ($value == '240p') {
                                    $r_240p = (new Representation())->setKiloBitrate(150)->setResize(426, 240);
                                    array_push($convertresolution, $r_240p);
                                }
                                if ($value == '360p') {
                                    $r_360p = (new Representation())->setKiloBitrate(276)->setResize(640, 360);
                                    array_push($convertresolution, $r_360p);
                                }
                                if ($value == '480p') {
                                    $r_480p = (new Representation())->setKiloBitrate(750)->setResize(854, 480);
                                    array_push($convertresolution, $r_480p);
                                }
                                if ($value == '720p') {
                                    $r_720p = (new Representation())->setKiloBitrate(2048)->setResize(1280, 720);
                                    array_push($convertresolution, $r_720p);
                                }
                                if ($value == '1080p') {
                                    $r_1080p = (new Representation())->setKiloBitrate(4096)->setResize(1920, 1080);
                                    array_push($convertresolution, $r_1080p);
                                }
                            }
                        }
                        $trailer = $data['trailer'];
                        $trailer_path = URL::to('storage/app/trailer/');
                        $trailer_Videoname = Str::lower($trailer->getClientOriginalName());
                        $trailer_Video = time() . '_' . str_replace(' ', '_', $trailer_Videoname);
    
                        // $trailer_Video =
                        //     time() . "_" . $trailer->getClientOriginalName();
                        $trailer->move(storage_path('app/trailer/'), $trailer_Video);
                        $trailer_video_name = strtok($trailer_Video, '.');
                        $M3u8_save_path = $trailer_path . '/' . $trailer_video_name . '.m3u8';
                        $storepath = URL::to('storage/app/trailer/');
    
                        $data['trailer'] = $M3u8_save_path;
                        $data['trailer_type'] = 'm3u8';
                    } else {
                        if ($trailer != '') {
                            //code for remove old file
                            if ($trailer != '' && $trailer != null) {
                                $file_old = $path . $trailer;
                                if (file_exists($file_old)) {
                                    unlink($file_old);
                                }
                            }
                            //upload new file
                            $randval = Str::random(16);
                            $file = $trailer;
                            $trailer_vid = $randval . '.' . $request->file('trailer')->extension();
                            $file->move($path, $trailer_vid);
                            $data['trailer'] = URL::to('/') . '/public/uploads/videos/' . $trailer_vid;
                        } else {
                            $data['trailer'] = $video->trailer;
                        }
                    }
                } elseif ($data['trailer_type'] == 'm3u8_url') {
                    $data['trailer'] = $data['m3u8_trailer'];
                } elseif ($data['trailer_type'] == 'mp4_url') {
                    $data['trailer'] = $data['mp4_trailer'];
                } elseif ($data['trailer_type'] == 'embed_url') {
                    $data['trailer'] = $data['embed_trailer'];
                }
            } elseif ($StorageSetting->aws_storage == 1 && !empty($data['trailer'])) {
                if ($trailer != '' && $pack == 'Business' && $settings->transcoding_access == 1 && $data['trailer_type'] == 'video_mp4') {
                    $file = $request->file('trailer');
                    $file_folder_name = $file->getClientOriginalName();
                    $name_mp4 = $file->getClientOriginalName();
                    $newfile = explode('.mp4', $name_mp4);
                    // $name = $newfile[0].'.m3u8';
                    $name = $namem3u8 == null ? str_replace(' ', '_', 'S3' . $namem3u8) : str_replace(' ', '_', 'S3' . $namem3u8);
                    $filePath = $StorageSetting->aws_video_trailer_path . '/' . $name;
                    $transcode_path = @$StorageSetting->aws_transcode_path . '/' . $name;
                    Storage::disk('s3')->put($transcode_path, file_get_contents($file));
                    $path = 'https://' . env('AWS_BUCKET') . '.s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com';
                    $M3u8_path = $path . $filePath;
                    $M3u8_save_path = $path . $transcode_path;
    
                    $data['trailer'] = $M3u8_save_path;
                    $video->trailer_type = 'm3u8';
                    $data['trailer_type'] = 'm3u8';
                } else {
                    $file = $request->file('trailer');
                    $file_folder_name = $file->getClientOriginalName();
                    $name = time() . $file->getClientOriginalName();
                    $filePath = $StorageSetting->aws_video_trailer_path . '/' . $name;
                    Storage::disk('s3')->put($filePath, file_get_contents($file));
                    $path = 'https://' . env('AWS_BUCKET') . '.s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com';
                    $trailer = $path . $filePath;
                    $data['trailer'] = $trailer;
                    $data['trailer_type'] = 'video_mp4';
                }
            } else {
                if ($data['trailer_type'] == 'video_mp4') {
                    $settings = Setting::first();
    
                    if ($trailer != '' && $pack == 'Business' && $settings->transcoding_access == 1 && $data['trailer_type'] == 'video_mp4') {
                        $settings = Setting::first();
                        // $resolution = explode(",",$settings->transcoding_resolution);
                        if ($settings->transcoding_resolution != null) {
                            $convertresolution = [];
                            $resolution = explode(',', $settings->transcoding_resolution);
                            foreach ($resolution as $value) {
                                if ($value == '240p') {
                                    $r_240p = (new Representation())->setKiloBitrate(150)->setResize(426, 240);
                                    array_push($convertresolution, $r_240p);
                                }
                                if ($value == '360p') {
                                    $r_360p = (new Representation())->setKiloBitrate(276)->setResize(640, 360);
                                    array_push($convertresolution, $r_360p);
                                }
                                if ($value == '480p') {
                                    $r_480p = (new Representation())->setKiloBitrate(750)->setResize(854, 480);
                                    array_push($convertresolution, $r_480p);
                                }
                                if ($value == '720p') {
                                    $r_720p = (new Representation())->setKiloBitrate(2048)->setResize(1280, 720);
                                    array_push($convertresolution, $r_720p);
                                }
                                if ($value == '1080p') {
                                    $r_1080p = (new Representation())->setKiloBitrate(4096)->setResize(1920, 1080);
                                    array_push($convertresolution, $r_1080p);
                                }
                            }
                        }
                        $trailer = $data['trailer'];
                        $trailer_path = URL::to('storage/app/trailer/');
                        $trailer_Videoname = Str::lower($trailer->getClientOriginalName());
                        $trailer_Video = time() . '_' . str_replace(' ', '_', $trailer_Videoname);
                        // $trailer_Video =
                        //     time() . "_" . $trailer->getClientOriginalName();
                        $trailer->move(storage_path('app/trailer/'), $trailer_Video);
                        $trailer_video_name = strtok($trailer_Video, '.');
                        $M3u8_save_path = $trailer_path . '/' . $trailer_video_name . '.m3u8';
                        $storepath = URL::to('storage/app/trailer/');
    
                        $data['trailer'] = $M3u8_save_path;
                        $data['trailer_type'] = 'm3u8';
                    } else {
                        if ($trailer != '') {
                            //code for remove old file
                            if ($trailer != '' && $trailer != null) {
                                $file_old = $path . $trailer;
                                if (file_exists($file_old)) {
                                    unlink($file_old);
                                }
                            }
                            //upload new file
                            $randval = Str::random(16);
                            $file = $trailer;
                            $trailer_vid = $randval . '.' . $request->file('trailer')->extension();
                            $file->move($path, $trailer_vid);
                            $data['trailer'] = URL::to('/') . '/public/uploads/videos/' . $trailer_vid;
                        } else {
                            $data['trailer'] = $video->trailer;
                        }
                    }
                } elseif ($data['trailer_type'] == 'm3u8_url') {
                    $data['trailer'] = $data['m3u8_trailer'];
                } elseif ($data['trailer_type'] == 'mp4_url') {
                    $data['trailer'] = $data['mp4_trailer'];
                } elseif ($data['trailer_type'] == 'embed_url') {
                    $data['trailer'] = $data['embed_trailer'];
                }
            }
    
            if (isset($data['duration'])) {
                //$str_time = $data
                $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $data['duration']);
                sscanf($str_time, '%d:%d:%d', $hours, $minutes, $seconds);
                $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                $data['duration'] = $time_seconds;
            }
    
            if (!empty($data['embed_code'])) {
                $video->embed_code = $data['embed_code'];
            } else {
                $video->embed_code = '';
            }
            if (!empty($data['age_restrict'])) {
                $video->age_restrict = $data['age_restrict'];
            }
            if (!empty($data['banner'])) {
                $banner = 1;
            } else {
                $banner = 0;
            }
    
            if (!empty($data['video_category_id'])) {
                $video_category_id = implode(',', $request->video_category_id);
    
                $category_id = $video_category_id;
            }
    
            if ($request->pdf_file != null) {
                $pdf_files = time() . '.' . $request->pdf_file->extension();
                $request->pdf_file->move(public_path('uploads/videoPdf'), $pdf_files);
                $video->pdf_files = $pdf_files;
            }
    
            // Reels videos
            $reels_videos = $request->reels_videos;
            if ($request->enable_reel_conversion == 1 && $reels_videos != null) {
                ReelsVideo::where("video_id", $video->id)->delete();
    
                foreach ($reels_videos as $Reel_Videos) {
                    $reelvideo_name =
                        time() . rand(1, 50) . "." . $Reel_Videos->extension();
                    $reel_videos_slug = substr(
                        $Reel_Videos->getClientOriginalName(),
                        0,
                        strpos($Reel_Videos->getClientOriginalName(), ".")
                    );
    
                    $reelvideo_names = "reels" . $reelvideo_name;
    
                
                    $reelvideo = $Reel_Videos->move(public_path('uploads/reelsVideos'), $reelvideo_name);
    
                    $videoPath = public_path("uploads/reelsVideos/{$reelvideo_name}");
                    $shorts_name = 'shorts_'.$reelvideo_name; 
                    $videoPath = str_replace('\\', '/', $videoPath);
                    $outputPath = public_path("uploads/reelsVideos/shorts/{$shorts_name}");
                    // Ensure the output directory exists
                    File::ensureDirectoryExists(dirname($outputPath));
                    // FFmpeg command to resize to 9:16 aspect ratio
                    $command = [
                        'ffmpeg',
                        '-y', // Add this option to force overwrite
                        '-i', $videoPath,
                        '-vf', 'scale=-1:720,crop=400:720', // Adjusted crop filter values
                        '-c:a', 'copy',
                        $outputPath,
                    ];
    
                    $process = new Process($command);
    
                    try {
                        $process->mustRun();
                        // return 'Video resized successfully!';
                    } catch (ProcessFailedException $exception) {
                        // Error message
                        throw new \Exception('Error resizing video: ' . $exception->getMessage());
                    }
    
                    $Reels_videos = new ReelsVideo();
                    $Reels_videos->video_id = $video->id;
                    // $Reels_videos->reels_videos = $reelvideo_name;
                    $Reels_videos->reels_videos = $shorts_name;
                    $Reels_videos->reels_videos_slug = $reel_videos_slug;
                    $Reels_videos->save();
    
                    $video->reels_thumbnail = "default.jpg";
                }
            }else if($reels_videos != null){
                ReelsVideo::where("video_id", $video->id)->delete();
    
                foreach ($reels_videos as $Reel_Videos) {
                    $reelvideo_name =
                        time() . rand(1, 50) . "." . $Reel_Videos->extension();
                    $reel_videos_slug = substr(
                        $Reel_Videos->getClientOriginalName(),
                        0,
                        strpos($Reel_Videos->getClientOriginalName(), ".")
                    );
    
                    $reelvideo_names = "reels" . $reelvideo_name;
                    $reelvideo = $Reel_Videos->move(
                        public_path("uploads/reelsVideos/shorts"),
                        $reelvideo_name
                    );
    
                    $Reels_videos = new ReelsVideo();
                    $Reels_videos->video_id = $video->id;
                    $Reels_videos->reels_videos = $reelvideo_name;
                    // $Reels_videos->reels_videos = $shorts_name;
                    $Reels_videos->reels_videos_slug = $reel_videos_slug;
                    $Reels_videos->save();
    
                    $video->reels_thumbnail = "default.jpg";
                }
            }
     
            if (!empty($request->reels_thumbnail)) {
                $Reels_thumbnail = 'reels_' . time() . '.' . $request->reels_thumbnail->extension();
                $request->reels_thumbnail->move(public_path('uploads/images'), $Reels_thumbnail);
    
                $video->reels_thumbnail = $Reels_thumbnail;
            }
    
            //URL Link
            $url_link = $request->url_link;
    
            if ($url_link != null) {
                $video->url_link = $url_link;
            }
    
            $url_linktym = $request->url_linktym;
    
            if ($url_linktym != null) {
                $StartParse = date_parse($request->url_linktym);
                $startSec = $StartParse['hour'] * 60 * 60 + $StartParse['minute'] * 60 + $StartParse['second'];
                $video->url_linktym = $url_linktym;
                $video->url_linksec = $startSec;
                $video->urlEnd_linksec = $startSec + 60;
            }
    
            if (compress_responsive_image_enable() == 1){
    
                    $mobileimages = public_path('/uploads/mobileimages');
                    $Tabletimages = public_path('/uploads/Tabletimages');
                    $PCimages = public_path('/uploads/PCimages');
    
                if (!file_exists($mobileimages)) {
                    mkdir($mobileimages, 0755, true);
                }
    
                if (!file_exists($Tabletimages)) {
                    mkdir($Tabletimages, 0755, true);
                }
    
                if (!file_exists($PCimages)) {
                    mkdir($PCimages, 0755, true);
                }
    
                if ($request->hasFile('image')) {
    
                    $image = $request->file('image');
    
                        $image_filename = 'video_' .time() . '_image.' . $image->getClientOriginalExtension();
                        $image_filename = $image_filename;
    
                        Image::make($image)->resize(568,320)->save(base_path() . '/public/uploads/mobileimages/' . $image_filename, compress_image_resolution());
                        Image::make($image)->resize(480,853)->save(base_path() . '/public/uploads/Tabletimages/' . $image_filename, compress_image_resolution());
                        Image::make($image)->resize(675,1200)->save(base_path() . '/public/uploads/PCimages/' . $image_filename, compress_image_resolution());
                        
                        $responsive_image = $image_filename;
    
                }else{
    
                    $responsive_image = default_vertical_image(); 
                }
    
                if ($request->hasFile('player_image')) {
    
                    $player_image = $request->file('player_image');
    
                        $player_image_filename = 'video_' .time() . '_player_image.' . $player_image->getClientOriginalExtension();
    
                        Image::make($player_image)->resize(568,320)->save(base_path() . '/public/uploads/mobileimages/' . $player_image_filename, compress_image_resolution());
                        Image::make($player_image)->resize(480,853)->save(base_path() . '/public/uploads/Tabletimages/' . $player_image_filename, compress_image_resolution());
                        Image::make($player_image)->resize(675,1200)->save(base_path() . '/public/uploads/PCimages/' . $player_image_filename, compress_image_resolution());
                        
                        $responsive_player_image = $player_image_filename;
    
                }else{
                    $responsive_player_image = default_horizontal_image(); 
                }
    
    
                
                if ($request->hasFile('video_tv_image')) {
    
                    $video_tv_image = $request->file('video_tv_image');
    
                        $video_tv_image_filename = 'video_' .time() . '_tv_image.' . $video_tv_image->getClientOriginalExtension();
    
                        Image::make($video_tv_image)->resize(568,320)->save(base_path() . '/public/uploads/mobileimages/' . $video_tv_image_filename, compress_image_resolution());
                        Image::make($video_tv_image)->resize(480,853)->save(base_path() . '/public/uploads/Tabletimages/' . $video_tv_image_filename, compress_image_resolution());
                        Image::make($video_tv_image)->resize(675,1200)->save(base_path() . '/public/uploads/PCimages/' . $video_tv_image_filename, compress_image_resolution());
                        
                        $responsive_tv_image = $video_tv_image_filename;
    
                }else{
    
                    $responsive_tv_image = default_horizontal_image(); 
                }
    
            }else{
                $responsive_image = null;
                $responsive_player_image = null;
                $responsive_tv_image = null;
            }
            
            if ($video->type == "VideoCipher") {
                $status = 1;
            } else {
                $status = 1;
            }
    
            $shortcodes = $request['short_code'];
            $languages = $request['sub_language'];
            $video->video_category_id = null;
            $video->skip_recap = $data['skip_recap'];
            $video->recap_start_time = $data['recap_start_time'];
            $video->recap_end_time = $data['recap_end_time'];
            $video->skip_intro = $data['skip_intro'];
            $video->intro_start_time = $data['intro_start_time'];
            $video->intro_end_time = $data['intro_end_time'];
            $video->description = $data['description'];
            $video->trailer_description = $data['trailer_description'];
            $video->uploaded_by = Auth::user()->role;
            $video->draft = 1;
            $video->active = 1;
            $video->status = 1;
            $video->embed_code = $embed_code;
            $video->publish_type = $publish_type;
            $video->publish_time = $publish_time;
            $video->age_restrict = $data['age_restrict'];
            $video->ppv_price = $data['ppv_price'];
            $video->access = $data['access'];
            $video->banner = $banner;
            $video->featured = $featured;
            $video->country = !empty($request['video_country']) ? json_encode($request['video_country']) : ['All'];
            $video->enable = 1;
            $video->search_tags = $searchtags;
            $video->ios_ppv_price = $data['ios_ppv_price'];
            $video->player_image = $data["player_image"] ;
            $video->video_tv_image = $data["video_tv_image"] ;
            $video->today_top_video = !empty($data["today_top_video"]) ? $data["today_top_video"] : 0 ;
            $video->tiny_video_image = $data["tiny_video_image"] ;
            $video->tiny_player_image = $data["tiny_player_image"] ;
            $video->tiny_video_title_image = $data["tiny_video_title_image"] ;
            $video->responsive_image = $responsive_image;
            $video->responsive_player_image = $responsive_player_image;
            $video->responsive_tv_image = $responsive_tv_image;
            $video->ppv_option = $request->ppv_option;
            // $video->ppv_price_240p = $data['ppv_price_240p'];
            // $video->ppv_price_360p = $data['ppv_price_360p'];
            $video->ppv_price_480p = $data['ppv_price_480p'];
            $video->ppv_price_720p = $data['ppv_price_720p'];
            $video->ppv_price_1080p = $data['ppv_price_1080p'];
            // $video->ios_ppv_price_240p = $data['ios_ppv_price_240p'];
            // $video->ios_ppv_price_360p = $data['ios_ppv_price_360p'];
            $video->ios_ppv_price_480p = $data['ios_ppv_price_480p'];
            $video->ios_ppv_price_720p = $data['ios_ppv_price_720p'];
            $video->ios_ppv_price_1080p = $data['ios_ppv_price_1080p'];
            $video->video_id_480p = ( !empty($data["video_id_480p"])) ? $data["video_id_480p"] : null;
            $video->video_id_720p = (!empty($data["video_id_720p"])) ? $data["video_id_720p"] : null;
            $video->video_id_1080p =( !empty($data["video_id_1080p"])) ? $data["video_id_1080p"] : null;
            // $video->type = 'VideoCipher';
            $video->status = 1;
            // Ads videos
            if (!empty($data['ads_tag_url_id']) == null) {
                $video->ads_tag_url_id = null;
                $video->tag_url_ads_position = null;
            }
    
            if (!empty($data['ads_tag_url_id']) != null) {
                $video->ads_tag_url_id = $data['ads_tag_url_id'];
                $video->tag_url_ads_position = $data['tag_url_ads_position'];
            }
    
            if (!empty($data['default_ads'])) {
                $video->default_ads = $data['default_ads'];
            } else {
                $video->default_ads = 0;
            }
    
            $video->update($data);
    
            if ($trailer != '' && $pack == 'Business' && $settings->transcoding_access == 1 && $StorageSetting->site_storage == 1) {
                ConvertVideoTrailer::dispatch($video, $storepath, $convertresolution, $trailer_video_name, $trailer_Video);
            }
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
            if (!empty($data['video_category_id'])) {
                $category_id = $data['video_category_id'];
                unset($data['video_category_id']);
                /*save artist*/
                if (!empty($category_id)) {
                    CategoryVideo::where('video_id', $video->id)->delete();
                    foreach ($category_id as $key => $value) {
                        $category = new CategoryVideo();
                        $category->video_id = $video->id;
                        $category->category_id = $value;
                        $category->save();
    
                        \LogActivity::addVideoCategoryLog('Added Category for Video.', $video->id, $value);
                    }
                }
            } else {
                CategoryVideo::where('video_id', $video->id)->delete();
    
                $other_category = VideoCategory::where('slug', 'other_category')->first();
    
                if ($other_category == null) {
                    VideoCategory::create([
                        'user_id' => null,
                        'parent_id' => null,
                        'order' => '1',
                        'name' => 'Other category',
                        'image' => 'default.jpg',
                        'slug' => 'other_category',
                        'in_home' => '1',
                        'footer' => null,
                        'banner' => '0',
                        'in_menu' => null,
                        'banner_image' => 'default.jpg',
                    ]);
                }
    
                $other_category_id = VideoCategory::where('slug', 'other_category')
                    ->pluck('id')
                    ->first();
    
                $category = new CategoryVideo();
                $category->video_id = $video->id;
                $category->category_id = $other_category_id;
                $category->save();
            }
    
            if (!empty($data['related_videos'])) {
                $related_videos = $data['related_videos'];
                // unset($data['related_videos']);
                /*save artist*/
                if (!empty($related_videos)) {
                    foreach ($related_videos as $key => $vid) {
                        $videos = Video::where('id', $vid)->get();
                        foreach ($videos as $key => $val) {
                            $RelatedVideo = new RelatedVideo();
                            $RelatedVideo->video_id = $id;
                            $RelatedVideo->user_id = Auth::user()->id;
                            $RelatedVideo->related_videos_id = $val->id;
                            $RelatedVideo->related_videos_title = $val->title;
                            $RelatedVideo->save();
                        }
                    }
                }
            }
    
            if (!empty($data['language'])) {
                $language_id = $data['language'];
                unset($data['language']);
                /*save artist*/
                if (!empty($language_id)) {
                    LanguageVideo::where('video_id', $video->id)->delete();
                    foreach ($language_id as $key => $value) {
                        $languagevideo = new LanguageVideo();
                        $languagevideo->video_id = $video->id;
                        $languagevideo->language_id = $value;
                        $languagevideo->save();
                        \LogActivity::addVideoLanguageLog('Added Language for Video.', $video->id, $value);
                    }
                }
            }
            if (!empty($data['artists'])) {
                $artistsdata = $data['artists'];
                unset($data['artists']);
                /*save artist*/
                if (!empty($artistsdata)) {
                    Videoartist::where('video_id', $video->id)->delete();
                    foreach ($artistsdata as $key => $value) {
                        $artist = new Videoartist();
                        $artist->video_id = $video->id;
                        $artist->artist_id = $value;
                        $artist->save();
                        \LogActivity::addVideoArtistLog('Added Artist for Video.', $video->id, $value);
                    }
                }
            }
    
            if (!empty($data['searchtags'])) {
                $searchtags = explode(',', $data['searchtags']);
                VideoSearchTag::where('video_id', $video->id)->delete();
                foreach ($searchtags as $key => $value) {
                    $videosearchtags = new VideoSearchTag();
                    $videosearchtags->user_id = Auth::User()->id;
                    $videosearchtags->video_id = $video->id;
                    $videosearchtags->search_tag = $value;
                    $videosearchtags->save();
                }
            }
    
            // playlist
            if (!empty($data["playlist"])) {
                $playlist_id = $data["playlist"];
                unset($data["playlist"]);
                if (!empty($playlist_id)) {
                    VideoPlaylist::where("video_id", $video->id)->delete();
    
                    foreach ($playlist_id as $key => $value) {
                        $VideoPlaylist = new VideoPlaylist();
                        $VideoPlaylist->user_id = Auth::user()->id;
                        $VideoPlaylist->video_id = $video->id;
                        $VideoPlaylist->playlist_id = $value;
                        $VideoPlaylist->save();
                    }
                }
            }
    
            if (!empty($data['country'])) {
                $country = $data['country'];
                unset($data['country']);
                /*save country*/
                if (!empty($country)) {
                    BlockVideo::where('video_id', $video->id)->delete();
                    foreach ($country as $key => $value) {
                        $country = new BlockVideo();
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
            // if (!empty($files != '' && $files != null)) {
            //     foreach ($files as $key => $val) {
            //         if (!empty($files[$key])) {
            //             $destinationPath = 'public/uploads/subtitles/';
            //             $filename = $video->id . '-' . $shortcodes[$key] . '.srt';
            //             $files[$key]->move($destinationPath, $filename);
            //             $subtitle_data['sub_language'] = $languages[$key]; /*URL::to('/').$destinationPath.$filename; */
            //             $subtitle_data['shortcode'] = $shortcodes[$key];
            //             $subtitle_data['movie_id'] = $id;
            //             $subtitle_data['url'] = URL::to('/') . '/public/uploads/subtitles/' . $filename;
            //             $video_subtitle = new MoviesSubtitles();
            //             $video_subtitle->movie_id = $video->id;
            //             $video_subtitle->shortcode = $shortcodes[$key];
            //             $video_subtitle->sub_language = $languages[$key];
            //             $video_subtitle->url = URL::to('/') . '/public/uploads/subtitles/' . $filename;
            //             $video_subtitle->save();
            //         }
            //     }
            // }
    
                // Define the convertTimeFormat function globally
    
                function convertTimeFormat($hours, $minutes, $seconds, $milliseconds) {
                    $totalSeconds = $hours * 3600 + $minutes * 60 + $seconds + $milliseconds / 1000;
                    $formattedTime = gmdate("H:i:s", $totalSeconds);
                    $formattedMilliseconds = str_pad($milliseconds, 3, '0', STR_PAD_LEFT);
                    return "{$formattedTime},{$formattedMilliseconds}";
                }
    
                if (!empty($files != "" && $files != null)) {
                    foreach ($files as $key => $val) {
                        if (!empty($files[$key])) {
                            $destinationPath = "public/uploads/subtitles/";
    
                            if (!file_exists($destinationPath)) {
                                mkdir($destinationPath, 0755, true);
                            }
    
                            $filename = $video->id . "-" . $shortcodes[$key] . ".srt";
    
                            MoviesSubtitles::where('movie_id', $video->id)->where('shortcode', $shortcodes[$key])->delete();
    
                            // Move uploaded file to destination path
                            move_uploaded_file($val->getPathname(), $destinationPath . $filename);
    
                            // Read contents of the uploaded file
                            $contents = file_get_contents($destinationPath . $filename);
    
                            // Convert time format and add line numbers
                            $lineNumber = 0;
                            $convertedContents = preg_replace_callback(
                                '/(\d{2}):(\d{2}).(\d{3}) --> (\d{2}):(\d{2}).(\d{3})/',
                                function ($matches) use (&$lineNumber) {
                                    // Increment line number for each match
                                    $lineNumber++;
                                    // Convert time format and return with the line number
                                    return "{$lineNumber}\n" . convertTimeFormat(0, $matches[1], $matches[2], $matches[3]) . " --> " . convertTimeFormat(0, $matches[4], $matches[5], $matches[6]);
                                },
                                $contents
                            );
    
                            // Store converted contents to a new file
                            $newDestinationPath = "public/uploads/convertedsubtitles/";
                            if (!file_exists($newDestinationPath)) {
                                mkdir($newDestinationPath, 0755, true);
                            }
                            file_put_contents($newDestinationPath . $filename, $convertedContents);
    
                            // Save subtitle data to database
                            $subtitle_data = [
                                "movie_id" => $video->id,
                                "shortcode" => $shortcodes[$key],
                                "sub_language" => $languages[$key],
                                "url" => URL::to("/") . "/public/uploads/subtitles/" . $filename,
                                "Converted_Url" => URL::to("/") . "/public/uploads/convertedsubtitles/" . $filename
                            ];
                            $video_subtitle = MoviesSubtitles::create($subtitle_data);
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
    
                    // Admin Video Ads inputs
    
            if( !empty($request->ads_devices)){
    
                $Admin_Video_Ads_inputs = array(
    
                    'video_id' => $video->id ,
                    'website_vj_pre_postion_ads'   =>  in_array("website", $request->ads_devices) ?  $request->website_vj_pre_postion_ads : null ,
                    'website_vj_mid_ads_category'  =>  in_array("website", $request->ads_devices) ? $request->website_vj_mid_ads_category : null ,
                    'website_vj_post_position_ads' =>  in_array("website", $request->ads_devices) ? $request->website_vj_post_position_ads : null,
                    'website_vj_pre_postion_ads'   =>  in_array("website", $request->ads_devices) ? $request->website_vj_pre_postion_ads : null,
    
                    'andriod_vj_pre_postion_ads'   => in_array("android", $request->ads_devices) ? $request->andriod_vj_pre_postion_ads : null,
                    'andriod_vj_mid_ads_category'  => in_array("android", $request->ads_devices) ? $request->andriod_vj_mid_ads_category : null,
                    'andriod_vj_post_position_ads' => in_array("android", $request->ads_devices) ? $request->andriod_vj_post_position_ads : null,
                    'andriod_mid_sequence_time'    => in_array("android", $request->ads_devices) ? $request->andriod_mid_sequence_time : null,
    
                    'ios_vj_pre_postion_ads'   => in_array("IOS", $request->ads_devices) ? $request->ios_vj_pre_postion_ads : null,
                    'ios_vj_mid_ads_category'  => in_array("IOS", $request->ads_devices) ? $request->ios_vj_mid_ads_category : null,
                    'ios_vj_post_position_ads' => in_array("IOS", $request->ads_devices) ? $request->ios_vj_post_position_ads : null,
                    'ios_mid_sequence_time'    => in_array("IOS", $request->ads_devices) ? $request->ios_mid_sequence_time : null,
    
                    'tv_vj_pre_postion_ads'   => in_array("TV", $request->ads_devices) ? $request->tv_vj_pre_postion_ads : null,
                    'tv_vj_mid_ads_category'  => in_array("TV", $request->ads_devices) ? $request->tv_vj_mid_ads_category : null,
                    'tv_vj_post_position_ads' => in_array("TV", $request->ads_devices) ? $request->tv_vj_post_position_ads : null,
                    'tv_mid_sequence_time'    => in_array("TV", $request->ads_devices) ? $request->tv_mid_sequence_time : null,
    
                    'roku_vj_pre_postion_ads'   => in_array("roku", $request->ads_devices) ? $request->roku_vj_pre_postion_ads : null,
                    'roku_vj_mid_ads_category'  => in_array("roku", $request->ads_devices) ? $request->roku_vj_mid_ads_category : null,
                    'roku_vj_post_position_ads' => in_array("roku", $request->ads_devices) ? $request->roku_vj_post_position_ads : null,
                    'roku_mid_sequence_time'    => in_array("roku", $request->ads_devices) ? $request->roku_mid_sequence_time : null,
    
                    'lg_vj_pre_postion_ads'   => in_array("lg", $request->ads_devices) ? $request->lg_vj_pre_postion_ads : null,
                    'lg_vj_mid_ads_category'  => in_array("lg", $request->ads_devices) ? $request->lg_vj_mid_ads_category : null,
                    'lg_vj_post_position_ads' => in_array("lg", $request->ads_devices) ? $request->lg_vj_post_position_ads : null,
                    'lg_mid_sequence_time'    => in_array("lg", $request->ads_devices) ? $request->lg_mid_sequence_time : null,
    
                    'samsung_vj_pre_postion_ads'   => in_array("samsung", $request->ads_devices) ?$request->samsung_vj_pre_postion_ads : null,
                    'samsung_vj_mid_ads_category'  => in_array("samsung", $request->ads_devices) ?$request->samsung_vj_mid_ads_category : null,
                    'samsung_vj_post_position_ads' => in_array("samsung", $request->ads_devices) ?$request->samsung_vj_post_position_ads : null,
                    'samsung_mid_sequence_time'    => in_array("samsung", $request->ads_devices) ?$request->samsung_mid_sequence_time : null,
    
                    // plyr.io
    
                    'website_plyr_tag_url_ads_position' => $request->website_plyr_tag_url_ads_position,
                    'website_plyr_ads_tag_url_id'       => $request->website_plyr_ads_tag_url_id,
                    
                    'andriod_plyr_tag_url_ads_position' => $request->andriod_plyr_tag_url_ads_position,
                    'andriod_plyr_ads_tag_url_id'       => $request->andriod_plyr_ads_tag_url_id,
    
                    'ios_plyr_tag_url_ads_position' => $request->ios_plyr_tag_url_ads_position,
                    'ios_plyr_ads_tag_url_id'       => $request->ios_plyr_ads_tag_url_id,
    
                    'tv_plyr_tag_url_ads_position' => $request->tv_plyr_tag_url_ads_position,
                    'tv_plyr_ads_tag_url_id'       => $request->tv_plyr_ads_tag_url_id,
    
                    'roku_plyr_tag_url_ads_position' => $request->roku_plyr_tag_url_ads_position,
                    'roku_plyr_ads_tag_url_id'       => $request->roku_plyr_ads_tag_url_id,
    
                    'lg_plyr_tag_url_ads_position' => $request->lg_plyr_tag_url_ads_position,
                    'lg_plyr_ads_tag_url_id'       => $request->lg_plyr_ads_tag_url_id,
                    
                    'samsung_plyr_tag_url_ads_position' => $request->samsung_plyr_tag_url_ads_position,
                    'samsung_plyr_ads_tag_url_id'       => $request->samsung_plyr_ads_tag_url_id,
    
                    'ads_devices' => !empty($request->ads_devices) ? json_encode($request->ads_devices) : null,
                );
    
                AdminVideoAds::create( $Admin_Video_Ads_inputs )  ;
                
            }
    
            \LogActivity::addVideoUpdateLog('Update Meta Data for Video.', $video->id);
    
            return Redirect::back()->with('message', 'Your video will be available shortly after we process it');
        }   


        public function UploadVideoFlussonicStorage($storage_settings,$FlussonicUploadlibraryID,$mp4_url)
        {

            $FileName = str_replace(' ', '-', $mp4_url->getClientOriginalName());
            if($this->Enable_Flussonic_Upload == 1){
           
                try {
                    $client = new \GuzzleHttp\Client();

                    $response = $client->request('PUT', "{$this->Flussonic_Server_Base_URL}streamer/api/v3/vods/{$this->Flussonic_Storage_Tag}/storages/{$FlussonicUploadlibraryID}/files/{$FileName}", [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->Flussonic_Auth_Key, 
                        'Content-Type' => 'application/json', 
                    ],
                    'body' => fopen($mp4_url, 'r'), 
                ]);
            
                $responseData = json_decode($response->getBody(), true);
                    
                $url = "{$this->Flussonic_Server_Base_URL}{$responseData['name']}/index.m3u8";
                $videoUrl = str_replace('http://', 'https://', $url);

                $video = new Video();
                $video->disk = "public";
                $video->original_name = "public";
                $video->title = $FileName;
                $video->m3u8_url = $videoUrl;
                $video->type = "m3u8_url";
                $video->draft = 1;
                $video->status = 1;
                $video->active = 0;
                $video->image = default_vertical_image();
                $video->video_tv_image = default_horizontal_image();
                $video->player_image = default_horizontal_image();
                $video->user_id = Auth::user()->id;
                $video->save();
    
                $video_id = $video->id;


                if(Enable_Extract_Image() == 1){
                    // extractImageFromVideo
                
                    $rand = Str::random(16);
    
                    $ffmpeg = \FFMpeg\FFMpeg::create();
                    $videoFrame = $ffmpeg->open($mp4_url);
                    
                    // Define the dimensions for the frame (16:9 aspect ratio)
                    $frameWidth = 1280;
                    $frameHeight = 720;
                    
                    // Define the dimensions for the frame (9:16 aspect ratio)
                    $frameWidthPortrait = 1080;  // Set the desired width of the frame
                    $frameHeightPortrait = 1920; // Calculate height to maintain 9:16 aspect ratio
                    
                    $randportrait = 'portrait_' . $rand;
                    
                    $interval = 5; // Interval for extracting frames in seconds
                    $totalDuration = round($videoFrame->getStreams()->videos()->first()->get('duration'));
                    $totalDuration = intval($totalDuration);
    
    
                    if ( 600 < $totalDuration) { 
                        $timecodes = [5, 120, 240, 360, 480]; 
                    } else { 
                        $timecodes = [5, 10, 15, 20, 25]; 
                    }
    
                    
                    foreach ($timecodes as $index => $time) {
                        $imagePortraitPath = public_path("uploads/images/{$video_id}_{$randportrait}_{$index}.jpg");
                        $imagePath = public_path("uploads/images/{$video_id}_{$rand}_{$index}.jpg");
                
                        try {
                            $videoFrame
                                ->frame(TimeCode::fromSeconds($time))
                                ->save($imagePath, new X264('libmp3lame', 'libx264'), null, new Dimension($frameWidth, $frameHeight));
                
                            $videoFrame
                                ->frame(TimeCode::fromSeconds($time))
                                ->save($imagePortraitPath, new X264('libmp3lame', 'libx264'), null, new Dimension($frameWidthPortrait, $frameHeightPortrait));
                
                            $VideoExtractedImage = new VideoExtractedImages();
                            $VideoExtractedImage->user_id = Auth::user()->id;
                            $VideoExtractedImage->socure_type = 'Video';
                            $VideoExtractedImage->video_id = $video_id;
                            $VideoExtractedImage->image_path = URL::to("/public/uploads/images/" . $video_id . '_' . $rand . '_' . $index . '.jpg');
                            $VideoExtractedImage->portrait_image = URL::to("/public/uploads/images/" . $video_id . '_' . $randportrait . '_' . $index . '.jpg');
                            $VideoExtractedImage->image_original_name = $video_id . '_' . $rand . '_' . $index . '.jpg';
                            $VideoExtractedImage->save();
                        } catch (\Exception $e) {
                            // dd($e->getMessage());
                        }
                    }
                    
                    $value["success"] = 1;
                    $value["message"] = "Uploaded Successfully!";
                    $value["video_id"] = $video_id;
                    $value["video_title"] = $FileName;
                    return $value ;

                }else{

                    $value["success"] = 1;
                    $value["message"] = "Uploaded Successfully!";
                    $value["video_id"] = $video_id;
                    $value["video_title"] = $FileName;
                    return $value ;

                }

                } catch (RequestException $e) {
                    $value["success"] = 2;
                    \LogActivity::addVideoLog("Failed Flussonic VIDEO Upload.", $video_id);
                    return $value ;
                }
            }else{
                $value["success"] = 2;
                \LogActivity::addVideoLog("Failed Flussonic VIDEO Upload.", $video_id);
                return $value ;
            }

        }


        
        public function FlussonicUploadlibrary(Request $request)
        {

            if($this->Enable_Flussonic_Upload == 1){
           
                try {
                    $client = new \GuzzleHttp\Client();
                    // http://localhost:8080/streamer/api/v3/vods/{prefix}/storages/{storage_index}/files

                    
                    $response = $client->request('GET', "{$this->Flussonic_Server_Base_URL}streamer/api/v3/vods/{$this->Flussonic_Storage_Tag}/storages/{$request->FlussonicUploadlibraryID}/files", [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $this->Flussonic_Auth_Key, 
                            'Content-Type' => 'application/json', 
                        ]
                    ]);
                  
            
                $response = json_decode($response->getBody(), true);
                $url = "{$this->Flussonic_Server_Base_URL}";
                $StreamURL = str_replace('http://', 'https://', $url);

                $responseData = [
                    'streamvideos' => $response,
                    'StreamURL' => $StreamURL,
                ];
            
                return $responseData;

            }catch (RequestException $e) {
                $value["success"] = 2;
                // echo"<pre>";
                // print_r($e->getMessage());exit;
                \LogActivity::addVideoLog("Failed Flussonic VIDEO Upload.", $video_id);
                return $value ;
            }
        }
    }


    
        
    public function Flussonic_Storage_UploadURL(Request $request)
    {



        $data = $request->all();
        $value = [];

        if (!empty($data["Flussonic_linked_video"])) {


            $video = new Video();
            $video->disk = "public";
            $video->original_name = "public";
            $video->title = $data["Flussonic_linked_video"];
            $video->m3u8_url = $data["Flussonic_linked_video"];
            $video->type = "m3u8_url";
            $video->status = 1;
            $video->draft = 1;
            $video->active = 0;
            $video->image = default_vertical_image();
            $video->video_tv_image = default_horizontal_image();
            $video->player_image = default_horizontal_image();
            $video->user_id = Auth::user()->id;
            $video->save();

            $video_id = $video->id;

            $value["success"] = 1;
            $value["message"] = "Uploaded Successfully!";
            $value["video_id"] = $video_id;

            \LogActivity::addVideoLog("Added Flussonic VIDEO URl Video.", $video_id);

            return $value;
            
        }
    }

    
    public function PurchasedContentAnalytics()
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
            return view('admin.expired_dashboard', $data);
        }else if(check_storage_exist() == 0){
          $settings = Setting::first();

          $data = array(
              'settings' => $settings,
          );

          return View::make('admin.expired_storage', $data);
      }else{
            $user_package = User::where("id", 1)->first();
            $package = $user_package->package;
            if (
                (!empty($package) && $package == "Pro") ||
                (!empty($package) && $package == "Business")
            ) {
                $settings = Setting::first();

                $purchases = PpvPurchase::leftJoin('users', 'ppv_purchases.user_id', '=', 'users.id')
                ->leftJoin('videos', 'ppv_purchases.video_id', '=', 'videos.id')
                ->leftJoin('series', 'ppv_purchases.series_id', '=', 'series.id')
                ->leftJoin('audio', 'ppv_purchases.audio_id', '=', 'audio.id')
                ->leftJoin('live_streams', 'ppv_purchases.live_id', '=', 'live_streams.id')
                ->select(
                    DB::raw('COALESCE(videos.id, series.id, audio.id, live_streams.id) as content_title'), 
                    DB::raw('users.username as user_name'),
                    DB::raw('users.id as user_id'),
                    DB::raw('users.email'),
                    DB::raw('users.mobile'),
                    DB::raw('SUM(ppv_purchases.total_amount) as total_amount'),
                    DB::raw('COUNT(ppv_purchases.id) as purchase_count'),
                    DB::raw('MAX(ppv_purchases.to_time) as last_purchase_time'),
                    DB::raw('MONTHNAME(ppv_purchases.created_at) as month_name')
                )
                ->groupBy('users.id', 'month_name', 'videos.id', 'series.id', 'audio.id', 'live_streams.id') 
                ->orderBy('purchase_count', 'desc')
                ->get();
            

                $data = [
                    "settings" => $settings,
                    "total_content" => $purchases,
                    "total_video_count" => count($purchases),
                    "currency" => CurrencySetting::first(),
                    "Total_PPV_Amount" => PpvPurchase::sum('total_amount'),
                ];
                return view("admin.analytics.purchased_content_analytics", $data);
            } else {
                return Redirect::to("/blocked");
            }
        }
    }

    public function PurchasedContentStartDateRevenue(Request $request)
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

                $total_content = PpvPurchase::leftJoin('users', 'ppv_purchases.user_id', '=', 'users.id')
                    ->leftJoin('videos', 'ppv_purchases.video_id', '=', 'videos.id')
                    ->leftJoin('series', 'ppv_purchases.series_id', '=', 'series.id')
                    ->leftJoin('audio', 'ppv_purchases.audio_id', '=', 'audio.id')
                    ->leftJoin('live_streams', 'ppv_purchases.live_id', '=', 'live_streams.id')
                    ->select(
                        DB::raw('COALESCE(videos.id, series.id, audio.id, live_streams.id) as content_title'), 
                        DB::raw('users.username as user_name'),
                        DB::raw('users.id as user_id'),
                        DB::raw('users.email'),
                        DB::raw('users.mobile'),
                        DB::raw('SUM(ppv_purchases.total_amount) as total_amount'),
                        DB::raw('COUNT(ppv_purchases.id) as purchase_count'),
                        DB::raw('MAX(ppv_purchases.to_time) as last_purchase_time'),
                        DB::raw('MONTHNAME(ppv_purchases.created_at) as month_name')
                    )
                    ->groupBy('users.id', 'month_name', 'videos.id', 'series.id', 'audio.id', 'live_streams.id') 
                    ->orderBy('purchase_count', 'desc')
                    ->whereDate("ppv_purchases.created_at", ">=", $start_time)
                    ->get();
                
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
                            $row->user_id .
                            '</td>  
                      <td>' .
                            $row->user_name .
                            '</td>
                      <td>' .
                            $row->email .
                            '</td>    

                      <td>' .
                            $row->mobile .
                            '</td>     
                      <td>' .
                            $currency->symbol .
                            " " .
                            $row->total_amount .
                            '</td>    
                    <td>' .
                            $row->purchase_count .
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

    public function PurchasedContentEndDateRevenue(Request $request)
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


                $total_content = PpvPurchase::leftJoin('users', 'ppv_purchases.user_id', '=', 'users.id')
                ->leftJoin('videos', 'ppv_purchases.video_id', '=', 'videos.id')
                ->leftJoin('series', 'ppv_purchases.series_id', '=', 'series.id')
                ->leftJoin('audio', 'ppv_purchases.audio_id', '=', 'audio.id')
                ->leftJoin('live_streams', 'ppv_purchases.live_id', '=', 'live_streams.id')
                ->select(
                    DB::raw('COALESCE(videos.id, series.id, audio.id, live_streams.id) as content_title'), 
                    DB::raw('users.username as user_name'),
                    DB::raw('users.id as user_id'),
                    DB::raw('users.email'),
                    DB::raw('users.mobile'),
                    DB::raw('SUM(ppv_purchases.total_amount) as total_amount'),
                    DB::raw('COUNT(ppv_purchases.id) as purchase_count'),
                    DB::raw('MAX(ppv_purchases.to_time) as last_purchase_time'),
                    DB::raw('MONTHNAME(ppv_purchases.created_at) as month_name')
                )
                ->groupBy('users.id', 'month_name', 'videos.id', 'series.id', 'audio.id', 'live_streams.id') 
                ->orderBy('purchase_count', 'desc')
                ->whereBetween("ppv_purchases.created_at", [$start_time,$end_time,])
                ->get();

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
                            $row->user_id .
                            '</td>
                      <td>' .
                            $row->user_name .
                            '</td>
                      <td>' .
                            $row->email .
                            '</td>    
            
                      <td>' .
                            $row->mobile .
                            '</td>           
                      <td>' .
                            $currency->symbol .
                            " " .
                            $row->total_amount .
                            '</td>    
                    <td>' .
                            $row->purchase_count .
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

    public function PurchasedContentExportCsv(Request $request)
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
         
                    $total_content = PpvPurchase::leftJoin('users', 'ppv_purchases.user_id', '=', 'users.id')
                    ->leftJoin('videos', 'ppv_purchases.video_id', '=', 'videos.id')
                    ->leftJoin('series', 'ppv_purchases.series_id', '=', 'series.id')
                    ->leftJoin('audio', 'ppv_purchases.audio_id', '=', 'audio.id')
                    ->leftJoin('live_streams', 'ppv_purchases.live_id', '=', 'live_streams.id')
                    ->select(
                        DB::raw('COALESCE(videos.id, series.id, audio.id, live_streams.id) as content_title'), 
                        DB::raw('users.username as user_name'),
                        DB::raw('users.id as user_id'),
                        DB::raw('users.email'),
                        DB::raw('users.mobile'),
                        DB::raw('SUM(ppv_purchases.total_amount) as total_amount'),
                        DB::raw('COUNT(ppv_purchases.id) as purchase_count'),
                        DB::raw('MAX(ppv_purchases.to_time) as last_purchase_time'),
                        DB::raw('MONTHNAME(ppv_purchases.created_at) as month_name')
                    )
                    ->groupBy('users.id', 'month_name', 'videos.id', 'series.id', 'audio.id', 'live_streams.id') 
                    ->orderBy('purchase_count', 'desc')
                    ->whereDate("ppv_purchases.created_at", ">=", $start_time)
                    ->get();

            } elseif (!empty($start_time) && !empty($end_time)) {

            $total_content = PpvPurchase::leftJoin('users', 'ppv_purchases.user_id', '=', 'users.id')
                ->leftJoin('videos', 'ppv_purchases.video_id', '=', 'videos.id')
                ->leftJoin('series', 'ppv_purchases.series_id', '=', 'series.id')
                ->leftJoin('audio', 'ppv_purchases.audio_id', '=', 'audio.id')
                ->leftJoin('live_streams', 'ppv_purchases.live_id', '=', 'live_streams.id')
                ->select(
                    DB::raw('COALESCE(videos.id, series.id, audio.id, live_streams.id) as content_title'), 
                    DB::raw('users.username as user_name'),
                    DB::raw('users.id as user_id'),
                    DB::raw('users.email'),
                    DB::raw('users.mobile'),
                    DB::raw('SUM(ppv_purchases.total_amount) as total_amount'),
                    DB::raw('COUNT(ppv_purchases.id) as purchase_count'),
                    DB::raw('MAX(ppv_purchases.to_time) as last_purchase_time'),
                    DB::raw('MONTHNAME(ppv_purchases.created_at) as month_name')
                )
                ->groupBy('users.id', 'month_name', 'videos.id', 'series.id', 'audio.id', 'live_streams.id') 
                ->orderBy('purchase_count', 'desc')
                ->whereBetween("ppv_purchases.created_at", [$start_time,$end_time,])
                ->get();
            } else {
                $total_content = PpvPurchase::leftJoin('users', 'ppv_purchases.user_id', '=', 'users.id')
                ->leftJoin('videos', 'ppv_purchases.video_id', '=', 'videos.id')
                ->leftJoin('series', 'ppv_purchases.series_id', '=', 'series.id')
                ->leftJoin('audio', 'ppv_purchases.audio_id', '=', 'audio.id')
                ->leftJoin('live_streams', 'ppv_purchases.live_id', '=', 'live_streams.id')
                ->select(
                    DB::raw('COALESCE(videos.id, series.id, audio.id, live_streams.id) as content_title'), 
                    DB::raw('users.username as user_name'),
                    DB::raw('users.id as user_id'),
                    DB::raw('users.email'),
                    DB::raw('users.mobile'),
                    DB::raw('SUM(ppv_purchases.total_amount) as total_amount'),
                    DB::raw('COUNT(ppv_purchases.id) as purchase_count'),
                    DB::raw('MAX(ppv_purchases.to_time) as last_purchase_time'),
                    DB::raw('MONTHNAME(ppv_purchases.created_at) as month_name')
                )
                ->groupBy('users.id', 'month_name', 'videos.id', 'series.id', 'audio.id', 'live_streams.id') 
                ->orderBy('purchase_count', 'desc')
                ->get();
            }
            $file = "PurchasedVideoAnalytics.csv";

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
                "User ID",
                "UserName",
                "Email",
                "Phone Number",
                "Total Spent",
                "Purchased Count",
                "Purchased ON",
            ]);
            if (count($total_content) > 0) {
                foreach ($total_content as $each_user) {
                    $video_url =
                        URL::to("/category/videos") . "/" . $each_user->slug;
                    $date = date_create($each_user->ppvcreated_at);
                    $newDate = date_format($date, "d M Y");

                    fputcsv($handle, [
                        $each_user->user_id,
                        $each_user->user_name,
                        $each_user->email,
                        $each_user->mobile,
                        $each_user->total_amount,
                        $each_user->purchase_count,
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

    public function TranscodingManagement()
    {
        try{
            $jobs = DB::table('jobs')->get();
            $failedJobs = DB::table('failed_jobs')->get();

            $videoCommands = [];
            $episodeCommands = [];
            $serieTrailerCommands = [];
            $failedVideoCommands = [];
            $failedEpisodeCommands = [];
            $failedSerieTrailerCommands = [];

            // Process queued jobs
            foreach ($jobs as $job) {
                $payload = json_decode($job->payload);
    
                if (isset($payload->data->command)) {
                    $command = unserialize($payload->data->command);
    
                    // Separate based on the command class
                    if ($command instanceof ConvertVideoForStreaming) {
                        $videoCommands[] = $command;
                    }  elseif ($command instanceof ConvertEpisodeVideo) {
                        $episodeCommands[] = $command;
                    } elseif ($command instanceof ConvertSerieTrailer) {
                        $serieTrailerCommands[] = $command;
                    }
                }
            }

            // Process failed jobs
            foreach ($failedJobs as $failedJob) {
                $payload = json_decode($failedJob->payload);
            
                if (isset($payload->data->command)) {
                    try {
                        $command = unserialize($payload->data->command);
            
                        if ($command instanceof ConvertVideoForStreaming) {
                            $failedVideoCommands[] = $command;
                        } elseif ($command instanceof ConvertEpisodeVideo) {
                            if (App\Episode::find($command->episode_id)) {
                                $failedEpisodeCommands[] = $command;
                            } else {
                                \Log::warning("Episode not found for command", ['episode_id' => $command->episode_id]);
                                continue; // Skip this job
                            }
                        } elseif ($command instanceof ConvertSerieTrailer) {
                            $failedSerieTrailerCommands[] = $command;
                        }
            
                        // Re-dispatch the failed command to restart transcoding
                        dispatch($command);
                    } catch (\Exception $e) {
                        // Log errors during unserialization or processing
                        \Log::error("Failed to process job command", ['error' => $e->getMessage()]);
                    }
                }
            }
            
            $data = [
                'video'              => $videoCommands,
                'episode'            => $episodeCommands,
                'serieTrailer'       => $serieTrailerCommands,
                'failed_video'       => $failedVideoCommands,
                'failed_episode'     => $failedEpisodeCommands,
                'failed_serieTrailer'=> $failedSerieTrailerCommands,
            ];
                // dd($data);
            return View("admin.videos.Transcoding-management", $data);
        }
        catch (\Throwable $th) {
            return $th->getMessage();
            return abort(404) ;
        }
    }


    public function videocipher_type(Request $request)
    {
        $data = $request->all();
        $value = [];


            $video = new Video();
            $video->disk = "public";
            $video->original_name = "public";
            $video->type = "VideoCipher";
            $video->draft = 1;
            $video->status = 1;
            $video->active = 0;
            $video->image = default_vertical_image();
            $video->video_tv_image = default_horizontal_image();
            $video->player_image = default_horizontal_image();
            $video->user_id = Auth::user()->id;
            $video->save();

            $video_id = $video->id;

            $value["success"] = 1;
            $value["message"] = "Uploaded Successfully!";
            $value["video_id"] = $video_id;

            \LogActivity::addVideoLog("Added Embeded URl Video.", $video_id);

            return $value;
    }


    
    public function video_upload_type(Request $request)
    {
        $value = [];
        $video_upload_type = Video::where('id',$request->video_id)->pluck('type')->first();
        $video_upload_id = Video::where('id',$request->video_id)->pluck('id')->first();
        $value["success"] = 1;
        $value["message"] = "Uploaded Successfully!";
        $value["video_upload_type"] = $video_upload_type;
        $value["video_upload_id"] = $video_upload_id;
        return $value;
    }


    public function UploadErrorLog(Request $request)
    {
        // try {

            $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
            $userIp = $geoip->getip();

            UploadErrorLog::create([
                'user_id' => 1,
                'user_ip' => $userIp,
                'socure_title' => $request->filename,
                // 'socure_type' => 'Video',
                'socure_type' => $request->socure_type,
                'error_message' => $request->error,
            ]);

            return response()->json(['status' => 'success'], 200);

        // } catch (\Throwable $th) {
        //     return response()->json(['status' => 'failed'], 501);

        // }
    }
    

}
    
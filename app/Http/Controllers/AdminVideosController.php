<?php

namespace App\Http\Controllers;
use App\User as User;
use \Redirect as Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
use App\Jobs\VideoSchedule;
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

class AdminVideosController extends Controller
{
    public function index()
    {
        if (!Auth::user()->role == "admin") {
            return redirect("/home");
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
            endif;
            // $video = Video::with('category.categoryname')->orderBy('created_at', 'DESC')->paginate(9);
            // echo "<pre>";
            // foreach($videos as $key => $value){
            //     print_r(@$value->category[$key]->categoryname->name);

            // }
            // exit();
            // $video = Video::with('category.categoryname')->where('id',156)->get();
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
                $data = [];
            }
            if (count($data) > 0) {
                $total_row = $data->count();
                if ($total_row > 0) {
                    foreach ($data as $row) {
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
                        $username = @$row->cppuser->username
                            ? "Upload By" . " " . @$row->cppuser->username
                            : "Upload By Admin";
                        $output .=
                            '
        <tr>
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
                            $row->type .
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
        <td>' .
                            $row->title .
                            '</td>
        <td>' .
                            $row->rating .
                            '</td>
        <td>' .
                            $row->categories_name .
                            '</td>
        <td>' .
                            $row->username .
                            '</td>
         <td class="' .
                            $class .
                            '" style="font-weight:bold;">' .
                            $active .
                            '</td>
         <td>' .
                            $row->type .
                            '</td>
         <td>' .
                            $row->access .
                            '</td>
        <td>' .
                            $row->languages_name .
                            '</td>
         <td>' .
                            $row->views .
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

    public function uploadFile(Request $request)
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
            $video->image = "default_image.jpg";

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
                $video->mobile_image = "default_image.jpg";
                $video->tablet_image = "default_image.jpg";
            }

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

                $video = new Video();
                $video->disk = "public";
                $video->status = 0;
                $video->original_name = "public";
                $video->path = $path;
                $video->title = $file_folder_name;
                $video->mp4_url = $storepath;
                $video->draft = 0;
                $video->image = "default_image.jpg";

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
                    $video->mobile_image = "default_image.jpg";
                    $video->tablet_image = "default_image.jpg";
                }

                $video->duration = $Video_duration;
                $video->user_id = Auth::user()->id;
                $video->save();

                ConvertVideoForStreaming::dispatch($video);
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
            $video->image = "default_image.jpg";

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
                $video->mobile_image = "default_image.jpg";
                $video->tablet_image = "default_image.jpg";
            }

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
        } else {
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

            $data = [
                "headline" => '<i class="fa fa-plus-circle"></i> New Video',
                "post_route" => URL::to("admin/videos/fileupdate"),
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
            ];

            return View::make("admin.videos.fileupload", $data);
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

            ConvertVideoForStreaming::dispatch($video);
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
        $video = Video::find($id);

        \LogActivity::addVideodeleteLog("Deleted Video.", $id);
        // dd('log insert successfully.');

        Video::destroy($id);
        //        VideoResolution::where('video_id', '=', $id)->delete();
        //        VideoSubtitle::where('video_id', '=', $id)->delete();
        Videoartist::where("video_id", $id)->delete();
        return Redirect::to("admin/videos")->with([
            "message" => "Successfully Deleted Video",
            "note_type" => "success",
        ]);
    }

    public function edit($id)
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
        $related_videos = Video::get();

        $all_related_videos = RelatedVideo::where("video_id", $id)
            ->pluck("related_videos_id")
            ->toArray();

       

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
            "related_videos" => Video::get(),
            "all_related_videos" => RelatedVideo::where("video_id", $id)
                ->pluck("related_videos_id")
                ->toArray(),
            "age_categories" => AgeCategory::get(),
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
            "block_countries" => BlockVideo::where("video_id", $id)
                ->pluck("country_id")
                ->toArray(),
            "page" => "Edit",
            "Reels_videos" => $Reels_videos,
            "ads_paths" => $ads_details ? $ads_details : 0,
            "ads_rolls" => $ads_rolls ? $ads_rolls : 0,
            "ads_category" => $ads_category,
            "block_countries" => BlockVideo::where("video_id", $id)
                ->pluck("country_id")
                ->toArray(),
            "InappPurchase" => InappPurchase::all(),

            'pre_ads'  => Video::select('advertisements.*')->join('advertisements','advertisements.id','=','videos.pre_ads')
                            ->where('videos.id',$id)->first(),

            'mid_ads'  => Video::select('advertisements.*')->join('advertisements','advertisements.id','=','videos.mid_ads')
                            ->where('videos.id',$id)->first(),

            'post_ads' => Video::select('advertisements.*')->join('advertisements','advertisements.id','=','videos.post_ads')
                            ->where('videos.id',$id)->first(),
        ];

        return View::make("admin.videos.create_edit", $data);
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
        // dd($data);
        $package = User::where("id", 1)->first();
        $pack = $package->package;
        $settings = Setting::first();

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

        if ($request->slug == "") {
            $data["slug"] = $this->createSlug($data["title"]);
        } else {
            $data["slug"] = str_replace(" ", "-", $request->slug);
        }

        $image = isset($data["image"]) ? $data["image"] : "";
        $trailer = isset($data["trailer"]) ? $data["trailer"] : "";
        $mp4_url2 = isset($data["video"]) ? $data["video"] : "";
        $files = isset($data["subtitle_upload"])? $data["subtitle_upload"] : "";
        $player_image = isset($data["player_image"]) ? $data["player_image"]: "";
        $video_title_image = isset($data["video_title_image"])? $data["video_title_image"]: "";
        $image_path = public_path() . "/uploads/images/";
    
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
                Image::make($player_filename)->save(base_path().'/public/uploads/images/'.$players_image );
            }

        } else {
            $players_image = $video->player_image;
        }
        
                    // live_stream_tv_image

        $video_tv_image = ($request->file('video_tv_image')) ? $request->file('video_tv_image') : '';

        if($video_tv_image != '') {   
                                        
        $video_tv_image = $video_tv_image;

        if(compress_image_enable() == 1){

            $Tv_image_filename  = time().'.'.compress_image_format();
            $Tv_image     =  'tv-live-image-'.$Tv_image_filename ;
            Image::make($video_tv_image)->save(base_path().'/public/uploads/images/'.$Tv_image,compress_image_resolution() );
        }else{

            $Tv_image_filename  = time().'.'.$live_stream_tv_image->getClientOriginalExtension();
            $Tv_image     =  'tv-live-image-'.$Tv_image_filename ;
            Image::make($video_tv_image)->save(base_path().'/public/uploads/images/'.$Tv_image );
        }
        } else{
            $Tv_image = "default_horizontal_image.jpg";
        }

        // Video Title Thumbnail

        if ($video_title_image != "") {
            if ($video_title_image != "" && $video_title_image != null) {
                //code for remove old file
                $video_title_image_file_old = $image_path . $video_title_image;
                if (file_exists($video_title_image_file_old)) {
                    unlink($video_title_image_file_old);
                }
            }
            //upload new file
            $video_title_images = "video_title_" . time() . ".webp";

            Image::make($data["video_title_image"])->save(
                base_path() . "/public/uploads/images/" . $video_title_images,
                80
            );

            $video->video_title_image = $video_title_images;
        } else {
            $data["video_title_image"] = $video->video_title_image;
        }

        // Enable Video Title Thumbnail

        $video->enable_video_title_image = $request->enable_video_title_image  ? "1" : "0";

        // Trailer Update

        $path = public_path() . "/uploads/videos/";
        $video->trailer_type = $data["trailer_type"];

        $StorageSetting = StorageSetting::first();
        // dd($StorageSetting);
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
                                ->setKiloBitrate(750)
                                ->setResize(854, 480);
                            array_push($convertresolution, $r_1080p);
                        }
                    }
                }
                $trailer = $data["trailer"];
                $trailer_path = URL::to("public/uploads/trailer/");
                $trailer_Videoname =  Str::lower($trailer->getClientOriginalName());
                $trailer_Video = time() . "_" . str_replace(" ","_",$trailer_Videoname);
                $trailer->move(public_path("uploads/trailer/"), $trailer_Video);
                $trailer_video_name = strtok($trailer_Video, ".");
                $M3u8_save_path =
                    $trailer_path . "/" . $trailer_video_name . ".m3u8";
                $storepath = URL::to("public/uploads/trailer/");
    
                $data["trailer"] = $M3u8_save_path;
                $video->trailer_type = "m3u8";
                $data["trailer_type"] = "m3u8";
            } else {
                if ($data["trailer_type"] == "video_mp4") {
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
                    }
                } elseif ($data["trailer_type"] == "m3u8_url") {
                    $video->trailer = $data["m3u8_trailer"];
                    $data["trailer"] = $data["m3u8_trailer"];
                    // http://localhost/flicknexs/storage/app/public/4XGJiKONAQfCe4eV.mp4
                } elseif ($data["trailer_type"] == "mp4_url") {
                    $video->trailer = $data["mp4_trailer"];
                    $data["trailer"] = $data["mp4_trailer"];
                } elseif ($data["trailer_type"] == "embed_url") {
                    $video->trailer = $data["embed_trailer"];
                    $data["trailer"] = $data["embed_trailer"];
                } else {
                    $data["trailer"] = $video->trailer;
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
                                ->setKiloBitrate(750)
                                ->setResize(854, 480);
                            array_push($convertresolution, $r_1080p);
                        }
                    }
                }
                $trailer = $data["trailer"];
                $trailer_path = URL::to("public/uploads/trailer/");
                $trailer_Videoname =  Str::lower($trailer->getClientOriginalName());
                $trailer_Video = time() . "_" . str_replace(" ","_",$trailer_Videoname);
                $trailer->move(public_path("uploads/trailer/"), $trailer_Video);
                $trailer_video_name = strtok($trailer_Video, ".");
                $M3u8_save_path =
                    $trailer_path . "/" . $trailer_video_name . ".m3u8";
                $storepath = URL::to("public/uploads/trailer/");
    
                $data["trailer"] = $M3u8_save_path;
                $video->trailer_type = "m3u8";
                $data["trailer_type"] = "m3u8";
            } else {
                if ($data["trailer_type"] == "video_mp4") {
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
                    }
                } elseif ($data["trailer_type"] == "m3u8_url") {
                    $video->trailer = $data["m3u8_trailer"];
                    $data["trailer"] = $data["m3u8_trailer"];
                    // http://localhost/flicknexs/storage/app/public/4XGJiKONAQfCe4eV.mp4
                } elseif ($data["trailer_type"] == "mp4_url") {
                    $video->trailer = $data["mp4_trailer"];
                    $data["trailer"] = $data["mp4_trailer"];
                } elseif ($data["trailer_type"] == "embed_url") {
                    $video->trailer = $data["embed_trailer"];
                    $data["trailer"] = $data["embed_trailer"];
                } else {
                    $data["trailer"] = $video->trailer;
                }
                // $data['trailer'] = "";
            }
            }


        // dd($video->trailer);

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
            }
          
        } else {
            $data["image"] = $video->image;
        }

        if ($player_image != "") {
           
            if(compress_image_enable() == 1){

                $player_filename  = time().'.'.compress_image_format();
                $players_image     =  'player-image-'.$player_filename ;
                Image::make($player_image)->save(base_path().'/public/uploads/images/'.$players_image,compress_image_resolution() );

            }
            else{
                $player_filename  = time().'.'.$player_image->getClientOriginalExtension();
                $players_image     =  'player-image-'.$player_filename ;
                Image::make($player_filename)->save(base_path().'/public/uploads/images/'.$players_image );
            }

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
            ConvertVideoForStreaming::dispatch($video);
        }

        if (!empty($data["embed_code"])) {
            $video->embed_code = $data["embed_code"];
        } else {
            $video->embed_code = "";
        }

        if (!empty($data["global_ppv"])) {
            $video->global_ppv = $data["global_ppv"];
        } else {
            $video->global_ppv = null;
        }

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

        if (!empty($data["slug"])) {
            $video->slug = $data["slug"];
        } else {
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
            $request->pdf_file->move(
                public_path("uploads/videoPdf"),
                $pdf_files
            );
            $video->pdf_files = $pdf_files;
        }

        // Reels videos
        $reels_videos = $request->reels_videos;

        if ($reels_videos != null) {
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
                    public_path("uploads/reelsVideos"),
                    $reelvideo_name
                );

                $ffmpeg = \FFMpeg\FFMpeg::create();
                $videos = $ffmpeg->open(
                    "public/uploads/reelsVideos" . "/" . $reelvideo_name
                );
                $videos
                    ->filters()
                    ->clip(TimeCode::fromSeconds(1), TimeCode::fromSeconds(60));
                $videos->save(
                    new \FFMpeg\Format\Video\X264("libmp3lame"),
                    "public/uploads/reelsVideos" . "/" . $reelvideo_names
                );

                unlink($reelvideo);

                $Reels_videos = new ReelsVideo();
                $Reels_videos->video_id = $video->id;
                $Reels_videos->reels_videos = $reelvideo_names;
                $Reels_videos->reels_videos_slug = $reel_videos_slug;
                $Reels_videos->save();

                $video->reels_thumbnail = "default.jpg";
            }
        }

        // Reels Thumbnail

        if (!empty($request->reels_thumbnail)) {
            $Reels_thumbnail =
                "reels_" .
                time() .
                "." .
                $request->reels_thumbnail->extension();
            $request->reels_thumbnail->move(
                public_path("uploads/images"),
                $Reels_thumbnail
            );

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

                // Ads videos
        $video->pre_ads_category = $data["pre_ads_category"];
        $video->mid_ads_category = $data["mid_ads_category"];
        $video->post_ads_category = $data["post_ads_category"];
        $video->pre_ads = $data["pre_ads"];
        $video->mid_ads = $data["mid_ads"];
        $video->post_ads = $data["post_ads"];

        $shortcodes = $request["short_code"];
        $languages = $request["sub_language"];
        $video->mp4_url = $data["mp4_url"];
        $video->trailer = $data["trailer"];
        $video->duration = $data["duration"];
        $video->language = $request["language"];
        $video->skip_recap = $request["skip_recap"];
        $video->recap_start_time = $request["recap_start_time"];
        $video->recap_end_time = $request["recap_end_time"];
        $video->skip_intro = $request["skip_intro"];
        $video->intro_start_time = $request["intro_start_time"];
        $video->intro_end_time = $request["intro_end_time"];
        $video->country = $request["video_country"];
        $video->publish_status = $request["publish_status"];
        $video->publish_type = $publish_type;
        $video->publish_time = $publish_time;
        $video->age_restrict = $data["age_restrict"];
        $video->access = $data["access"];
        //  $video->active=1;
        $video->uploaded_by = $uploaded_by;
        $video->player_image = $players_image;
        $video->video_tv_image = $Tv_image;       
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
        $video->ppv_price = $data["ppv_price"];
        $video->type = $data["type"];
        $video->description = $data["description"];
        $video->trailer_description = $data["trailer_description"];
        $video->banner = $banner;
        $video->enable = $enable;
        $video->rating = $request->rating;
        $video->search_tags = $searchtags;
        $video->ios_ppv_price = $request->ios_ppv_price;
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

        // Block country
        if (!empty($data["country"])) {
            $country = $data["country"];
            unset($data["country"]);

            if (!empty($country)) {
                BlockVideo::where("video_id", $video->id)->delete();

                foreach ($country as $key => $value) {
                    $country = new BlockVideo();
                    $country->video_id = $video->id;
                    $country->country_id = $value;
                    $country->save();
                }
            }
        }

        if (!empty($files != "" && $files != null)) {
            foreach ($files as $key => $val) {
                if (!empty($files[$key])) {
                    $destinationPath = "public/uploads/subtitles/";
                    $filename = $video->id . "-" . $shortcodes[$key] . ".srt";
                    $files[$key]->move($destinationPath, $filename);
                    $subtitle_data["sub_language"] =
                        $languages[
                            $key
                        ]; /*URL::to('/').$destinationPath.$filename; */
                    $subtitle_data["shortcode"] = $shortcodes[$key];
                    $subtitle_data["movie_id"] = $id;
                    $subtitle_data["url"] =
                        URL::to("/") . "/public/uploads/subtitles/" . $filename;
                    $video_subtitle = new MoviesSubtitles();
                    $video_subtitle->movie_id = $video->id;
                    $video_subtitle->shortcode = $shortcodes[$key];
                    $video_subtitle->sub_language = $languages[$key];
                    $video_subtitle->url =
                        URL::to("/") . "/public/uploads/subtitles/" . $filename;
                    $video_subtitle->save();
                }
            }
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
        if (!Auth::user()->role == "admin") {
            return redirect("/home");
        }
        // dd('test');
        $user_package = User::where("id", 1)->first();
        $data = $request->all();

        $validatedData = $request->validate([
            "title" => "required|max:255",
            // 'video_country' =>'required',
        ]);

        $id = $data["video_id"];
        $video = Video::findOrFail($id);
        // RelatedVideo

        // dd($videos);
        if (!empty($video->embed_code)) {
            $embed_code = $video->embed_code;
        } else {
            $embed_code = "";
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

        if (!empty($data["ppv_price"]) && $data["ppv_price"] > 0) {
            $video->global_ppv = 1;
        } else {
            $video->global_ppv = null;
        }

        $settings = Setting::where("ppv_status", "=", 1)->first();

        if (!empty($data["global_ppv"])) {
            $data["ppv_price"] = $settings->ppv_price;
            $video->global_ppv = $data["global_ppv"];
        } else {
            $video->global_ppv = null;
        }

        if ($request->slug == "") {
            $data["slug"] = $this->createSlug($data["title"]);
        } else {
            $data["slug"] = $this->createSlug($data["slug"]);
        }

        $image = isset($data["image"]) ? $data["image"] : "";
        $trailer = isset($data["trailer"]) ? $data["trailer"] : "";
        $files = isset($data["subtitle_upload"])? $data["subtitle_upload"] : "";
        $player_image = isset($data["player_image"]) ? $data["player_image"]: "";
        $video_title_image = isset($data["video_title_image"]) ? $data["video_title_image"]: "";
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

                $data["image"] = $video_image;
                $video->mobile_image = $Mobile_image;
                $video->tablet_image = $Tablet_image;

            }
            else{
                $image_filename  = time().'.'.$file->getClientOriginalExtension();

                $video_image     =  'pc-image-'.$image_filename ;
                $Mobile_image    =  'Mobile-image-'.$image_filename ;
                $Tablet_image    =  'Tablet-image-'.$image_filename ;

                Image::make($file)->save( base_path() . "/public/uploads/images/" . $video_image);
                Image::make($file)->save( base_path() . "/public/uploads/images/" . $Mobile_image);
                Image::make($file)->save(base_path() . "/public/uploads/images/" . $Tablet_image);

                $data["image"] = $video_image;
                $video->mobile_image = $Mobile_image;
                $video->tablet_image = $Tablet_image;
            }
          
        } else {
            $data["image"] = $video->image;
            $video_image = '';
        }


        
        if ($player_image != "") {
               
            $player_image = $player_image;

            if(compress_image_enable() == 1){

                $player_filename  = time().'.'.compress_image_format();
                $players_image     =  'player-image-'.$player_filename ;
                Image::make($player_image)->save(base_path().'/public/uploads/images/'.$players_image,compress_image_resolution() );

            }
            else{
                $player_filename  = time().'.'.$player_image->getClientOriginalExtension();
                $players_image     =  'player-image-'.$player_filename ;
                Image::make($player_filename)->save(base_path().'/public/uploads/images/'.$players_image );
            }

        } else {
            $players_image = $video->player_image;
        }


                               // live_stream_tv_image

        $video_tv_image = ($request->file('video_tv_image')) ? $request->file('video_tv_image') : '';

        if($video_tv_image != '') {   
                                        //upload new file
        $video_tv_image = $video_tv_image;

        if(compress_image_enable() == 1){

            $Tv_image_filename  = time().'.'.compress_image_format();
            $Tv_image     =  'tv-live-image-'.$Tv_image_filename ;

            Image::make($video_tv_image)->save(base_path().'/public/uploads/images/'.$Tv_image,compress_image_resolution() );
        }else{

            $Tv_image_filename  = time().'.'.$live_stream_tv_image->getClientOriginalExtension();
            $Tv_image     =  'tv-live-image-'.$Tv_image_filename ;
            Image::make($video_tv_image)->save(base_path().'/public/uploads/images/'.$Tv_image );
        }
        } else{
            $Tv_image = "default_horizontal_image.jpg";
        }

        if (empty($data["active"])) {
            $data["active"] = 0;
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
            $data["year"] = 0;
        } else {
            $data["year"] = $data["year"];
        }
        if (empty($data["searchtags"])) {
            $searchtags = null;
        } else {
            $searchtags = $data["searchtags"];
        }

        if (empty($data["language"])) {
            $data["language"] = 0;
        } else {
            $data["language"] = $data["language"];
        }

        if (empty($data["featured"])) {
            $featured = 0;
        } else {
            $featured = 1;
        }

        if (empty($data["featured"])) {
            $data["featured"] = 0;
        }

        if (!empty($data["embed_code"])) {
            $data["embed_code"] = $data["embed_code"];
        }

        if (empty($data["active"])) {
            $data["active"] = 0;
        }

        if (empty($data["video_gif"])) {
            $data["video_gif"] = "";
        }

        // if(empty($data['type'])){
        //     $data['type'] = '';
        // }

        // if(empty($data['path'])){
        //     $data['path'] = 0;
        // }

        if (empty($data["status"])) {
            $data["status"] = 0;
        }

        $package = User::where("id", 1)->first();
        $pack = $package->package;

        if (Auth::user()->role == "admin") {
            $data["status"] = 1;
        }
        $settings = Setting::first();

        if (Auth::user()->role == "admin" && $pack != "Business") {
            $data["status"] = 1;
        } elseif (
            Auth::user()->role == "admin" &&
            $pack == "Business" &&
            $settings->transcoding_access == 1
        ) {
           if($video->processed_low < 100){
            $data["status"] = 0;

           } else{
            $data["status"] = 1;
           }
        } elseif (
            Auth::user()->role == "admin" &&
            $pack == "Business" &&
            $settings->transcoding_access == 0
        ) {
            $data["status"] = 1;
        } else {
            $data["status"] = 1;
        }

        if (Auth::user()->role == "admin" && Auth::user()->sub_admin == 1) {
            $data["status"] = 0;
        }

        if (!empty($data["Recommendation"])) {
            $video->Recommendation = $data["Recommendation"];
        }
        if (empty($data["publish_type"])) {
            $publish_type = 0;
        } else {
            $publish_type = $data["publish_type"];
        }
        // dd($publish_type);

        if (empty($data["publish_time"])) {
            $publish_time = 0;
        } else {
            $publish_time = $data["publish_time"];
        }

        $path = public_path() . "/uploads/videos/";
        $image_path = public_path() . "/uploads/images/";



       

        // Video Title Thumbnail

        if ($video_title_image != "") {
            if ($video_title_image != "" && $video_title_image != null) {
                $video_title_image_file_old = $image_path . $video_title_image;
                if (file_exists($video_title_image_file_old)) {
                    unlink($video_title_image_file_old);
                }
            }
            //upload new file
            $video_title_images = "video_title_" . time() . ".webp";

            Image::make($data["video_title_image"])->save(
                base_path() . "/public/uploads/images/" . $video_title_images,
                80
            );

            $video->video_title_image = $video_title_images;
        } else {
            $data["video_title_image"] = $video->video_title_image;
        }

        // Enable Video Title Thumbnail

        $video->enable_video_title_image = $request->enable_video_title_image
            ? "1"
            : "0";

        $video->trailer_type = $data["trailer_type"];
        $StorageSetting = StorageSetting::first();
        // dd($StorageSetting);
        if($StorageSetting->site_storage == 1){
            if ($data["trailer_type"] == "video_mp4") {
                $settings = Setting::first();
    
                if (
                    $trailer != "" &&
                    $pack == "Business" &&
                    $settings->transcoding_access == 1 && $data["trailer_type"] == "video_mp4"
                ) {
                    $settings = Setting::first();
                    // $resolution = explode(",",$settings->transcoding_resolution);
                    if ($settings->transcoding_resolution != null) {
                        $convertresolution = [];
                        $resolution = explode(
                            ",",
                            $settings->transcoding_resolution
                        );
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
                                    ->setKiloBitrate(750)
                                    ->setResize(854, 480);
                                array_push($convertresolution, $r_1080p);
                            }
                        }
                    }
                    $trailer = $data["trailer"];
                    $trailer_path = URL::to("public/uploads/trailer/");
                    $trailer_Videoname =  Str::lower($trailer->getClientOriginalName());
                    $trailer_Video = time() . "_" . str_replace(" ","_",$trailer_Videoname);
                    // $trailer_Video =
                    //     time() . "_" . $trailer->getClientOriginalName();
                    $trailer->move(public_path("uploads/trailer/"), $trailer_Video);
                    $trailer_video_name = strtok($trailer_Video, ".");
                    $M3u8_save_path =
                        $trailer_path . "/" . $trailer_video_name . ".m3u8";
                    $storepath = URL::to("public/uploads/trailer/");
    
                    $data["trailer"] = $M3u8_save_path;
                    $data["trailer_type"] = "m3u8";
                } else {
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
                        $data["trailer"] = $video->trailer;
                    }
                }
            } elseif ($data["trailer_type"] == "m3u8_url") {
                $data["trailer"] = $data["m3u8_trailer"];
            } elseif ($data["trailer_type"] == "mp4_url") {
                $data["trailer"] = $data["mp4_trailer"];
            } elseif ($data["trailer_type"] == "embed_url") {
                $data["trailer"] = $data["embed_trailer"];
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
                $name_mp4 = $file->getClientOriginalName();
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

            if ($data["trailer_type"] == "video_mp4") {
                $settings = Setting::first();
    
                if (
                    $trailer != "" &&
                    $pack == "Business" &&
                    $settings->transcoding_access == 1 && $data["trailer_type"] == "video_mp4"
                ) {
                    $settings = Setting::first();
                    // $resolution = explode(",",$settings->transcoding_resolution);
                    if ($settings->transcoding_resolution != null) {
                        $convertresolution = [];
                        $resolution = explode(
                            ",",
                            $settings->transcoding_resolution
                        );
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
                                    ->setKiloBitrate(750)
                                    ->setResize(854, 480);
                                array_push($convertresolution, $r_1080p);
                            }
                        }
                    }
                    $trailer = $data["trailer"];
                    $trailer_path = URL::to("public/uploads/trailer/");
                    $trailer_Videoname =  Str::lower($trailer->getClientOriginalName());
                    $trailer_Video = time() . "_" . str_replace(" ","_",$trailer_Videoname);
                    // $trailer_Video =
                    //     time() . "_" . $trailer->getClientOriginalName();
                    $trailer->move(public_path("uploads/trailer/"), $trailer_Video);
                    $trailer_video_name = strtok($trailer_Video, ".");
                    $M3u8_save_path =
                        $trailer_path . "/" . $trailer_video_name . ".m3u8";
                    $storepath = URL::to("public/uploads/trailer/");

                    $data["trailer"] = $M3u8_save_path;
                    $data["trailer_type"] = "m3u8";
                } else {
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
                        $data["trailer"] = $video->trailer;
                    }
                }
            } elseif ($data["trailer_type"] == "m3u8_url") {
                $data["trailer"] = $data["m3u8_trailer"];
            } elseif ($data["trailer_type"] == "mp4_url") {
                $data["trailer"] = $data["mp4_trailer"];
            } elseif ($data["trailer_type"] == "embed_url") {
                $data["trailer"] = $data["embed_trailer"];
            }

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

        if (!empty($data["embed_code"])) {
            $video->embed_code = $data["embed_code"];
        } else {
            $video->embed_code = "";
        }
        if (!empty($data["age_restrict"])) {
            $video->age_restrict = $data["age_restrict"];
        }
        if (!empty($data["banner"])) {
            $banner = 1;
        } else {
            $banner = 0;
        }

        if (!empty($data["video_category_id"])) {
            $video_category_id = implode(",", $request->video_category_id);

            $category_id = $video_category_id;
        }

        if ($request->pdf_file != null) {
            $pdf_files = time() . "." . $request->pdf_file->extension();
            $request->pdf_file->move(
                public_path("uploads/videoPdf"),
                $pdf_files
            );
            $video->pdf_files = $pdf_files;
        }

        // Reels videos
        $reels_videos = $request->reels_videos;

        if ($reels_videos != null) {
            foreach ($reels_videos as $Reel_Videos) {
                $reelvideo_name = time() . rand(1, 50) . "." . $Reel_Videos->extension();
                $reel_videos_slug = substr(  $Reel_Videos->getClientOriginalName(), 0, strpos($Reel_Videos->getClientOriginalName(), "."));
                $reelvideo_names = "reels" . $reelvideo_name;

                $reelvideo = $Reel_Videos->move( public_path("uploads/reelsVideos"),  $reelvideo_name );

                $ffmpeg = \FFMpeg\FFMpeg::create();
                $videos = $ffmpeg->open(  "public/uploads/reelsVideos" . "/" . $reelvideo_name );
                $videos->filters()->clip(TimeCode::fromSeconds(1), TimeCode::fromSeconds(60));
                $videos->save( new \FFMpeg\Format\Video\X264("libmp3lame"),
                    "public/uploads/reelsVideos" . "/" . $reelvideo_names
                );

                unlink($reelvideo);

                $Reels_videos = new ReelsVideo();
                $Reels_videos->video_id = $video->id;
                $Reels_videos->reels_videos = $reelvideo_names;
                $Reels_videos->reels_videos_slug = $reel_videos_slug;
                $Reels_videos->save();

                $video->reels_thumbnail = "default.jpg";
            }
        }

        // Reels Thumbnail

        if (!empty($request->reels_thumbnail)) {
            $Reels_thumbnail = "reels_" . time() . "." . $request->reels_thumbnail->extension();
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
            $startSec = $StartParse["hour"] * 60 * 60 + $StartParse["minute"] * 60 +$StartParse["second"];
            $video->url_linktym = $url_linktym;
            $video->url_linksec = $startSec;
            $video->urlEnd_linksec = $startSec + 60;
        }


        $shortcodes = $request["short_code"];
        $languages = $request["sub_language"];
        $video->video_category_id = null;
        $video->skip_recap = $data["skip_recap"];
        $video->recap_start_time = $data["recap_start_time"];
        $video->recap_end_time = $data["recap_end_time"];
        $video->skip_intro = $data["skip_intro"];
        $video->intro_start_time = $data["intro_start_time"];
        $video->intro_end_time = $data["intro_end_time"];
        $video->description = $data["description"];
        $video->trailer_description = $data["trailer_description"];
        $video->uploaded_by = Auth::user()->role;
        $video->draft = 1;
        $video->active = 1;
        $video->embed_code = $embed_code;
        $video->player_image = $players_image;
        $video->video_tv_image = $Tv_image; 
        $video->image = $video_image; 
        $video->publish_type = $publish_type;
        $video->publish_time = $publish_time;
        $video->age_restrict = $data["age_restrict"];
        $video->ppv_price = $data["ppv_price"];
        $video->access = $data["access"];
        $video->banner = $banner;
        $video->featured = $featured;
        $video->country = $data["video_country"];
        $video->enable = 1;
        $video->search_tags = $searchtags;
        $video->ios_ppv_price = $data["ios_ppv_price"];

            // Ads videos
        $video->pre_ads_category = $data["pre_ads_category"];
        $video->mid_ads_category = $data["mid_ads_category"];
        $video->post_ads_category = $data["post_ads_category"];
        $video->pre_ads = $data["pre_ads"];
        $video->mid_ads = $data["mid_ads"];
        $video->post_ads = $data["post_ads"];

        if (!empty($data["default_ads"])) {
            $video->default_ads = $data["default_ads"];
        } else {
            $video->default_ads = 0;
        }

        $video->update($data);
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
        if (!empty($data["video_category_id"])) {
            $category_id = $data["video_category_id"];
            unset($data["video_category_id"]);
            /*save artist*/
            if (!empty($category_id)) {
                CategoryVideo::where("video_id", $video->id)->delete();
                foreach ($category_id as $key => $value) {
                    $category = new CategoryVideo();
                    $category->video_id = $video->id;
                    $category->category_id = $value;
                    $category->save();

                    \LogActivity::addVideoCategoryLog(
                        "Added Category for Video.",
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

        if (!empty($data["related_videos"])) {
            $related_videos = $data["related_videos"];
            // unset($data['related_videos']);
            /*save artist*/
            if (!empty($related_videos)) {
                foreach ($related_videos as $key => $vid) {
                    $videos = Video::where("id", $vid)->get();
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

        if (!empty($data["language"])) {
            $language_id = $data["language"];
            unset($data["language"]);
            /*save artist*/
            if (!empty($language_id)) {
                LanguageVideo::where("video_id", $video->id)->delete();
                foreach ($language_id as $key => $value) {
                    $languagevideo = new LanguageVideo();
                    $languagevideo->video_id = $video->id;
                    $languagevideo->language_id = $value;
                    $languagevideo->save();
                    \LogActivity::addVideoLanguageLog(
                        "Added Language for Video.",
                        $video->id,
                        $value
                    );
                }
            }
        }
        if (!empty($data["artists"])) {
            $artistsdata = $data["artists"];
            unset($data["artists"]);
            /*save artist*/
            if (!empty($artistsdata)) {
                Videoartist::where("video_id", $video->id)->delete();
                foreach ($artistsdata as $key => $value) {
                    $artist = new Videoartist();
                    $artist->video_id = $video->id;
                    $artist->artist_id = $value;
                    $artist->save();
                    \LogActivity::addVideoArtistLog(
                        "Added Artist for Video.",
                        $video->id,
                        $value
                    );
                }
            }
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
        }

        if (!empty($data["country"])) {
            $country = $data["country"];
            unset($data["country"]);
            /*save country*/
            if (!empty($country)) {
                BlockVideo::where("video_id", $video->id)->delete();
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
        if (!empty($files != "" && $files != null)) {
            foreach ($files as $key => $val) {
                if (!empty($files[$key])) {
                    $destinationPath = "public/uploads/subtitles/";
                    $filename = $video->id . "-" . $shortcodes[$key] . ".srt";
                    $files[$key]->move($destinationPath, $filename);
                    $subtitle_data["sub_language"] =
                        $languages[
                            $key
                        ]; /*URL::to('/').$destinationPath.$filename; */
                    $subtitle_data["shortcode"] = $shortcodes[$key];
                    $subtitle_data["movie_id"] = $id;
                    $subtitle_data["url"] =
                        URL::to("/") . "/public/uploads/subtitles/" . $filename;
                    $video_subtitle = new MoviesSubtitles();
                    $video_subtitle->movie_id = $video->id;
                    $video_subtitle->shortcode = $shortcodes[$key];
                    $video_subtitle->sub_language = $languages[$key];
                    $video_subtitle->url =
                        URL::to("/") . "/public/uploads/subtitles/" . $filename;
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

        \LogActivity::addVideoUpdateLog(
            "Update Meta Data for Video.",
            $video->id
        );

        return Redirect::back()->with(
            "message",
            "Your video will be available shortly after we process it"
        );
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
            $video->image = "default_image.jpg";

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
                $video->mobile_image = "default_image.jpg";
                $video->tablet_image = "default_image.jpg";
            }
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
            $video->image = "default_image.jpg";

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
                $video->mobile_image = "default_image.jpg";
                $video->tablet_image = "default_image.jpg";
            }

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

        // echo "<pre>";
        // print_r($data);
        // exit();

        if (!empty($data["embed"])) {
            $video = new Video();
            $video->disk = "public";
            $video->original_name = "public";
            $video->title = $data["embed"];
            $video->embed_code = $data["embed"];
            $video->type = "embed";
            $video->draft = 0;
            $video->active = 1;
            $video->image = "default_image.jpg";

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
                $video->mobile_image = "default_image.jpg";
                $video->tablet_image = "default_image.jpg";
            }
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

    public function CPPVideosIndex()
    {
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
                $videos = Video::where("videos.status", "=", 0)
                    ->join(
                        "moderators_users",
                        "videos.user_id",
                        "=",
                        "moderators_users.id"
                    )
                    ->join(
                        "categoryvideos",
                        "categoryvideos.video_id",
                        "=",
                        "videos.id"
                    )
                    ->join(
                        "video_categories",
                        "video_categories.id",
                        "=",
                        "categoryvideos.category_id"
                    )
                    ->select(
                        "moderators_users.username",
                        "videos.*",
                        "video_categories.name"
                    )
                    ->groupby("videos.id")
                    ->where("videos.uploaded_by", "CPP")
                    ->orderBy("videos.created_at", "DESC")
                    ->paginate(9);
            }
            // $videos = Video::join("moderators_users", "videos.user_id", "=", "moderators_users.id")
            // ->select("moderators_users.username", "videos.*")
            // // ->groupby("videos.id")
            // ->where("videos.status",0)
            // ->where("videos.uploaded_by", "CPP")
            // ->orderBy("videos.created_at", "DESC")
            // ->paginate(9);
            $data = [
                "videos" => $videos,
            ];
            // dd($videos);
            return View("admin.videos.videoapproval.approval_index", $data);
        }
    }
    public function CPPVideosApproval($id)
    {
        //    echo "<pre>";
        //    print_r($id);
        //    exit();

        $video = Video::findOrFail($id);
        $video->status = 1;
        $video->save();

        return Redirect::back()->with(
            "message",
            "Your video will be available shortly after we process it"
        );
    }

    public function CPPVideosReject($id)
    {
        $video = Video::findOrFail($id);
        $video->active = 2;
        $video->save();

        return Redirect::back()->with(
            "message",
            "Your video will be available shortly after we process it"
        );
    }
    function get_processed_percentage($id)
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

        return View::make("admin.videos.edit_video", $data);
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
            // $video->image = 'default_image.jpg';

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
            // echo "<pre>";
            // print_r($mp4_url);exit();
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
            $video->title = $file_folder_name;
            $video->mp4_url = $storepath;
            //  $video->draft = 0;
            $video->type = "";
            //  $video->image = 'default_image.jpg';
            $video->duration = $Video_duration;
            $video->user_id = Auth::user()->id;
            $video->save();

            ConvertVideoForStreaming::dispatch($video);
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
            $video->image = "default_image.jpg";
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
            $video->image = "default_image.jpg";

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
            $video->image = "default_image.jpg";

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

        // echo "<pre>";
        // print_r($data);
        // exit();
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
            $video->image = "default_image.jpg";

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
                $videos = Video::where("videos.status", "=", 0)
                    ->join("channels", "videos.user_id", "=", "channels.id")
                    ->select("channels.channel_name", "videos.*")
                    ->groupby("videos.id")
                    ->where("videos.uploaded_by", "Channel")
                    ->orderBy("videos.created_at", "DESC")
                    ->paginate(9);
            }
            $data = [
                "videos" => $videos,
            ];
            // dd($videos);
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
        $video->save();

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

                $total_content = Video::join(
                    "ppv_purchases",
                    "ppv_purchases.video_id",
                    "=",
                    "videos.id"
                )
                    ->join("users", "users.id", "=", "ppv_purchases.user_id")
                    ->groupBy("ppv_purchases.id")
                    ->whereDate("ppv_purchases.created_at", ">=", $start_time)

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
                $total_content = Video::join(
                    "ppv_purchases",
                    "ppv_purchases.video_id",
                    "=",
                    "videos.id"
                )
                    ->join("users", "users.id", "=", "ppv_purchases.user_id")
                    ->groupBy("ppv_purchases.id")
                    ->whereBetween("ppv_purchases.created_at", [
                        $start_time,
                        $end_time,
                    ])
                    ->get([
                        \DB::raw("videos.*"),
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
                $total_content = Video::join(
                    "ppv_purchases",
                    "ppv_purchases.video_id",
                    "=",
                    "videos.id"
                )
                    ->join("users", "users.id", "=", "ppv_purchases.user_id")
                    ->groupBy("ppv_purchases.id")
                    ->whereDate("videos.created_at", ">=", $start_time)
                    ->get([
                        \DB::raw("videos.*"),
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
                $total_content = Video::join(
                    "ppv_purchases",
                    "ppv_purchases.video_id",
                    "=",
                    "videos.id"
                )
                    ->join("users", "users.id", "=", "ppv_purchases.user_id")
                    ->groupBy("ppv_purchases.id")
                    ->whereBetween("ppv_purchases.created_at", [
                        $start_time,
                        $end_time,
                    ])
                    ->get([
                        \DB::raw("videos.*"),
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
                        \DB::raw("COUNT(*) as count"),
                        \DB::raw(
                            "MONTHNAME(ppv_purchases.created_at) as month_name"
                        ),
                    ]);
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

            $file->move($image_path, $data["image"]);
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
        $Schedules = new VideoSchedules();
        $Schedules->name = $request["name"];
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

        $Schedules->name = $request["name"];
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
        $date_choosed = $date_choose . "/" . $data["date"];
        
        $d = new \DateTime("now");
        $d->setTimezone(new \DateTimeZone("Asia/Kolkata"));
        $now = $d->format("Y-m-d h:i:s a");
        $current_time = date("A", strtotime($now));

        // date_default_timezone_set('Asia/Kolkata');
        // $now = date("Y-m-d h:i:s a", time());
        // $current_time = date("h:i A", time());

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
        //    dd($data );
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
            $date_choosed = $date_choose . "/" . $data["date"];

            
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
                $date_choosed = $date_choose . "/" . $data["date"];
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
                $date_choosed = $date_choose . "/" . $data["date"];
    
                
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
                $date_choosed = $date_choose . "/" . $data["date"];
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
        $ModeratorsUser = ModeratorsUser::get();
        $video = Video::where("uploaded_by", "!=", "CPP")
            ->orWhere("uploaded_by", null)
            ->get();
        // dd($video);

        $data = [
            "ModeratorsUser" => $ModeratorsUser,
            "video" => $video,
        ];

        return view("admin.videos.move_videos.move_cpp_index", $data);
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
        $date_choosed = $date_choose . "/" . $data["date"];
    
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
            $date_choosed = $date_choose . "/" . $data["date"];

            
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
                // $Video_duration = $videochooed->duration;
                $time = $choose_current_time;
                $minutes = $time[0] * 60.0 + $time[1] * 1.0;
                $totalSecs = $minutes * 60;
                $sec = $totalSecs + $Video_duration;

                $hour = floor($sec / 3600);
                $minute = floor(($sec / 60) % 60);
                $hours = str_pad($hour, 2, "0", STR_PAD_LEFT);
                $minutes = str_pad($minute, 2, "0", STR_PAD_LEFT);

                $shedule_endtime = $hours .":" .$minutes ." " .date("A", strtotime($now));
                // echo "<pre>"; print_r($Video_duration);exit();

                $sheduled_endtime = $hours . ":" . $minutes;
                $starttime = date("h:i", strtotime($store_current_time));
                $sheduled_starttime = date("h:i A", strtotime($store_current_time));
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

            $Advertisement = Advertisement::where('ads_category',$request->ads_category_id)->where('ads_position','pre')->where('status',1)->get();

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

            $Advertisement = Advertisement::where('ads_category',$request->ads_category_id)->where('ads_position','mid')->where('status',1)->get();

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
                            ->where('ads_position','post')->where('status',1)->get();

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



    public function AWSUploadFile(Request $request)
    {
        $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';

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
            $video->type = "mp4_url";
            $video->draft = 0;
            $video->image = "default_image.jpg";

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
                $video->mobile_image = "default_image.jpg";
                $video->tablet_image = "default_image.jpg";
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

                $transcode_path = @$StorageSetting->aws_transcode_path.'/'. $name;
                $filePath = $StorageSetting->aws_storage_path.'/'. $name;
                $filePath_mp4 = $StorageSetting->aws_storage_path.'/'. $name_mp4;
                Storage::disk('s3')->put($transcode_path, file_get_contents($file));
                print_r($name);exit;
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
                $video->draft = 0;
                $video->image = "default_image.jpg";

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
                    $video->mobile_image = "default_image.jpg";
                    $video->tablet_image = "default_image.jpg";
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
            $video->mp4_url = $storepath;
            $video->type = "mp4_url";
            $video->draft = 0;
            $video->image = "default_image.jpg";

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
                $video->mobile_image = "default_image.jpg";
                $video->tablet_image = "default_image.jpg";
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
            $name_mp4 =  $file->getClientOriginalName();
            $newfile = explode(".mp4",$name_mp4);
            $namem3u8 = $newfile[0].'.m3u8';   
            $name = $namem3u8 == null ? str_replace(' ', '_', 'S3'.$namem3u8) : str_replace(' ', '_', 'S3'.$namem3u8) ;        

            $transcode_path = @$StorageSetting->aws_transcode_path.'/'. $name;
            // print_r($filePath);exit;
            $filePath = $StorageSetting->aws_storage_path.'/'. $name;
            $filePath_mp4 = $StorageSetting->aws_storage_path.'/'. $name_mp4;
            Storage::disk('s3')->put($transcode_path, file_get_contents($file));
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
            $video->mp4_url = $storepath;
            $video->type = "mp4_url";
            // $video->draft = 0;
            $video->image = "default_image.jpg";
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
            $date_choosed = $date_choose . "/" . $data["date"];


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

}
    
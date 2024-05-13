<?php

namespace App\Http\Controllers;
use App\User as User;
use \Redirect as Redirect;
use Illuminate\Http\Request;
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
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
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
use Session;
use App\LanguageVideo;
use App\CategoryVideo;
use App\CountryCode;
use App\Advertisement;
use App\BlockVideo;
use Exception;
use getID3;
use App\AdsVideo;
use App\VideoSearchTag;
use App\RelatedVideo;
use App\InappPurchase;
use Auth;
use Hash;
use URL;
use File;
use View;
use Validator;
use App\EmailTemplate;
use Mail;
use App\Adscategory;
use App\StorageSetting;
use App\Playerui;
use App\Livestream;
use App\Episode;
use App\ModeratorSubscription;
use App\Audio;
use App\SiteTheme;

class CPPAdminVideosController extends Controller
{

    public function __construct()
    {
        $this->enable_moderator_Monetization = SiteTheme::pluck('enable_moderator_Monetization')->first();
    }

    public function CPPindex()
    {
        //    if (!Auth::user()->role == 'admin')
        //     {
        //         return redirect('/home');
        //     }

        // $search_value = Request::get('s');
        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;
        if ((!empty($package) && $package == 'Pro') || (!empty($package) && $package == 'Business')) {
            $user = Session::get('user');
            $id = $user->id;
            if (!empty($search_value)):
                $videos = Video::where('title', 'LIKE', '%' . $search_value . '%')
                    ->where('user_id', '=', $id)
                    ->orderBy('created_at', 'desc')
                    ->paginate(9);
            else:
                $videos = Video::where('user_id', '=', $id)
                    ->orderBy('created_at', 'DESC')
                    ->paginate(9);
            endif;

            // $user = Auth::user();

            $data = [
                'videos' => $videos,
                'user' => $user,
                // 'admin_user' => Auth::user()
            ];

            return View('moderator.cpp.videos.index', $data);
        } else {
            return Redirect::to('/blocked');
        }
    }

    public function CPPlive_search(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');

            $slug = URL::to('/category/videos');
            $edit = URL::to('admin/videos/edit');
            $delete = URL::to('admin/videos/delete');

            if ($query != '') {
                $data = Video::select('videos.*', 'moderators_users.id')
                    ->leftJoin('moderators_users', 'moderators_users.id', '=', 'videos.user_id')
                    //  ->leftJoin('video_languages', 'video_languages.id', '=', 'videos.language')
                    //  ->leftJoin('video_categories', 'video_categories.id', '=', 'videos.video_category_id')
                    ->where('videos.title', 'like', '%' . $query . '%')
                    ->paginate(9);

                //  $data = Video::select('videos.*','moderators_users.id','video_languages.name as languages_name','video_categories.name as categories_name')
                //  ->leftJoin('moderators_users', 'moderators_users.id', '=', 'videos.user_id')
                //  ->leftJoin('video_languages', 'video_languages.id', '=', 'videos.language')
                //  ->leftJoin('video_categories', 'video_categories.id', '=', 'videos.video_category_id')
                //  ->where('videos.title', 'like', '%'.$query.'%')
                //  ->paginate(9);
            } else {
            }

            $total_row = $data->count();
            if ($total_row > 0) {
                foreach ($data as $row) {
                    if ($row->active == 0) {
                        $active = 'Pending';
                        $class = 'bg-warning';
                    } elseif ($row->active == 1) {
                        $active = 'Approved';
                        $class = 'bg-success';
                    } else {
                        $active = 'Rejected';
                        $class = 'bg-danger';
                    }
                    $username = $row->username ? 'Upload By' . ' ' . $row->username : 'Upload By Admin';
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
                        $username .
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
                'table_data' => $output,
                'total_data' => $total_row,
            ];

            echo json_encode($data);
        }
    }

    public function CPPVideo(Request $request)
    {
        if ($request->ajax()) {

            $output = '';
            $query = $request->get('query');

            $slug = URL::to('/category/videos');
            $edit = URL::to('admin/videos/edit');
            $delete = URL::to('admin/videos/delete');

            if ($query != '') {
                $data = Video::select('videos.*', 'moderators_users.username', 'video_languages.name as languages_name', 'video_categories.name as categories_name')
                    ->leftJoin('video_languages', 'video_languages.id', '=', 'videos.language')
                    ->leftJoin('video_categories', 'video_categories.id', '=', 'videos.video_category_id')
                    ->Join('moderators_users', 'moderators_users.id', '=', 'videos.user_id')
                    ->paginate(9);
            } else {
            }

            $total_row = $data->count();
            if ($total_row > 0) {
                foreach ($data as $row) {
                    if ($row->active == 0) {
                        $active = 'Pending';
                        $class = 'bg-warning';
                    } elseif ($row->active == 1) {
                        $active = 'Approved';
                        $class = 'bg-success';
                    } else {
                        $active = 'Rejected';
                        $class = 'bg-danger';
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
                'table_data' => $output,
                'total_data' => $total_row,
            ];

            echo json_encode($data);
        }
    }

    public function CPPuploadFile(Request $request)
    {
        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;
        $user = Session::get('user');

        $user_id = $user->id;
        if($this->enable_moderator_Monetization == 1){

            $ModeratorSubscription = ModeratorSubscription::where('user_id', '=', $user_id)->count(); 

            if($ModeratorSubscription == 0 ){

                $value = [];
                $value['total_uploads'] = 0;
                return $value;

            }elseif($ModeratorSubscription > 0){

                $ModeratorSubscription = ModeratorSubscription::where('moderator_subscriptions.user_id', '=', $user_id)->orderBy('moderator_subscriptions.created_at', 'DESC')
                                        ->join('moderator_subscription_plans', 'moderator_subscription_plans.plan_id', '=', 'moderator_subscriptions.stripe_plan')
                                        ->first(); 

                if( !empty($ModeratorSubscription) ){

                    $upload_video_limit = $ModeratorSubscription->upload_video_limit;
                    $uploaded_videos = Video::where('uploaded_by','CPP')->where('user_id', '=', $user_id)->count();
                    
                    if($upload_video_limit != null){
                        if($upload_video_limit <= $uploaded_videos){
                            $value = [];
                            $value['total_uploads'] = 0;
                            return $value;
                        }
                    }

                }else{
                        $value = [];
                        $value['total_uploads'] = 0;
                        return $value;
                }
                
            }else{
                        $value = [];
                        $value['total_uploads'] = 0;
                        return $value;
            }
        }
        // if($ModeratorSubscription == 0 ){
        //     $uploaded_videos = Video::where('uploaded_by','CPP')->where('user_id', '=', $user_id)->count();
        //     $uploaded_Audios = Audio::where('uploaded_by','CPP')->where('user_id', '=', $user_id)->count();
        //     $uploaded_Livestreams = Livestream::where('uploaded_by','CPP')->where('user_id', '=', $user_id)->count();
        //     $uploaded_Episodes = Episode::where('uploaded_by','CPP')->where('user_id', '=', $user_id)->count();
        //     $total_uploads = $uploaded_videos + $uploaded_Audios + $uploaded_Livestreams + $uploaded_Episodes ;
        //     // $total_uploads = 31 ;
        //     if($total_uploads >= 30){
            
        //         $value = [];
        //         $value['total_uploads'] = 0;
        //         return $value;
        //     }
        // }
        // print_r($total_uploads);exit;
        if ((!empty($package) && $package == 'Pro') || (!empty($package) && $package == 'Business')) {
            $value = [];
            $data = $request->all();

            $validator = Validator::make($request->all(), [
                'file' => 'required|mimes:video/mp4,video/x-m4v,video/*',
            ]);
            $mp4_url = isset($data['file']) ? $data['file'] : '';

            $path = public_path() . '/uploads/videos/';

            $file = $request->file->getClientOriginalName();
            $newfile = explode('.mp4', $file);
            $file_folder_name = $newfile[0];

            $package = User::where('id', 1)->first();
            $pack = $package->package;
            $mp4_url = $data['file'];
            $settings = Setting::first();
            if ($mp4_url != '' && $pack != 'Business') {
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

                $original_name = $request->file->getClientOriginalName() ? $request->file->getClientOriginalName() : '';
                //  $storepath  = URL::to('/storage/app/public/'.$file_folder_name.'/'.$original_name);
                //  $str = explode(".mp4",$path);
                //  $path =$str[0];
                $storepath = URL::to('/storage/app/public/' . $path);

                //  Video duration
                $getID3 = new getID3();
                $Video_storepath = storage_path('app/public/' . $path);
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
                $video->user_id = $user->id;
                $video->uploaded_by = 'CPP';
                $video->image = 'default_image.jpg';

                $PC_image_path = public_path('/uploads/images/default_image.jpg');

                if (file_exists($PC_image_path)) {
                    $Mobile_image = 'Mobile-default_image.jpg';
                    $Tablet_image = 'Tablet-default_image.jpg';

                    Image::make($PC_image_path)
                        ->resize(244, 310)
                        ->save(base_path() . '/public/uploads/images/' . $Mobile_image);
                    Image::make($PC_image_path)
                        ->resize(120, 190)
                        ->save(base_path() . '/public/uploads/images/' . $Tablet_image);

                    $video->mobile_image = $Mobile_image;
                    $video->tablet_image = $Tablet_image;
                } else {
                    $video->mobile_image = 'default_image.jpg';
                    $video->tablet_image = 'default_image.jpg';
                }
                $video->duration = $Video_duration;
                $video->save();

                $video_id = $video->id;
                $video_title = Video::find($video_id);
                $title = $video_title->title;

                $value['success'] = 1;
                $value['message'] = 'Uploaded Successfully!';
                $value['video_id'] = $video_id;
                $value['video_title'] = $title;

                return $value;
            } elseif ($mp4_url != '' && $pack == 'Business' && $settings->transcoding_access == 1) {
                $rand = Str::random(16);
                $path = $rand . '.' . $request->file->getClientOriginalExtension();
                $request->file->storeAs('public', $path);

                $original_name = $request->file->getClientOriginalName() ? $request->file->getClientOriginalName() : '';

                $storepath = URL::to('/storage/app/public/' . $path);

                //  Video duration
                $getID3 = new getID3();
                $Video_storepath = storage_path('app/public/' . $path);
                $VideoInfo = $getID3->analyze($Video_storepath);
                $Video_duration = $VideoInfo['playtime_seconds'];
                $user = Session::get('user');

                $video = new Video();
                $video->disk = 'public';
                $video->status = 0;
                $video->original_name = 'public';
                $video->path = $path;
                $video->title = $file_folder_name;
                $video->mp4_url = $storepath;
                $video->draft = 0;
                $video->duration = $Video_duration;
                $video->uploaded_by = 'CPP';
                $video->user_id = $user->id;
                $video->image = 'default_image.jpg';

                $PC_image_path = public_path('/uploads/images/default_image.jpg');

                if (file_exists($PC_image_path)) {
                    $Mobile_image = 'Mobile-default_image.jpg';
                    $Tablet_image = 'Tablet-default_image.jpg';

                    Image::make($PC_image_path)
                        ->resize(244, 310)
                        ->save(base_path() . '/public/uploads/images/' . $Mobile_image);
                    Image::make($PC_image_path)
                        ->resize(120, 190)
                        ->save(base_path() . '/public/uploads/images/' . $Tablet_image);

                    $video->mobile_image = $Mobile_image;
                    $video->tablet_image = $Tablet_image;
                } else {
                    $video->mobile_image = 'default_image.jpg';
                    $video->tablet_image = 'default_image.jpg';
                }
                $video->save();

                ConvertVideoForStreaming::dispatch($video);
                $video_id = $video->id;
                $video_title = Video::find($video_id);
                $title = $video_title->title;

                $value['success'] = 1;
                $value['message'] = 'Uploaded Successfully!';
                $value['video_id'] = $video_id;
                $value['video_title'] = $title;

                return $value;
            } elseif ($mp4_url != '' && $pack == 'Business' && $settings->transcoding_access == 0) {
                $rand = Str::random(16);
                $path = $rand . '.' . $request->file->getClientOriginalExtension();

                $request->file->storeAs('public', $path);
                $thumb_path = 'public';

                $original_name = $request->file->getClientOriginalName() ? $request->file->getClientOriginalName() : '';

                $storepath = URL::to('/storage/app/public/' . $path);

                //  Video duration
                $getID3 = new getID3();
                $Video_storepath = storage_path('app/public/' . $path);
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
                $video->user_id = $user->id;
                $video->uploaded_by = 'CPP';
                $video->duration = $Video_duration;
                $video->image = 'default_image.jpg';

                $PC_image_path = public_path('/uploads/images/default_image.jpg');

                if (file_exists($PC_image_path)) {
                    $Mobile_image = 'Mobile-default_image.jpg';
                    $Tablet_image = 'Tablet-default_image.jpg';

                    Image::make($PC_image_path)
                        ->resize(244, 310)
                        ->save(base_path() . '/public/uploads/images/' . $Mobile_image);
                    Image::make($PC_image_path)
                        ->resize(120, 190)
                        ->save(base_path() . '/public/uploads/images/' . $Tablet_image);

                    $video->mobile_image = $Mobile_image;
                    $video->tablet_image = $Tablet_image;
                } else {
                    $video->mobile_image = 'default_image.jpg';
                    $video->tablet_image = 'default_image.jpg';
                }
                $video->save();

                $video_id = $video->id;
                $video_title = Video::find($video_id);
                $title = $video_title->title;

                $value['success'] = 1;
                $value['message'] = 'Uploaded Successfully!';
                $value['video_id'] = $video_id;
                $value['video_title'] = $title;

                return $value;
            } else {
                $value['success'] = 2;
                $value['message'] = 'File not uploaded.';
                return response()->json($value);
            }
        } else {
            return Redirect::to('/blocked');
        }
    }

    /**
     * Show the form for creating a new video
     *
     * @return Response
     */
    public function CPPcreate()
    {
        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;

        if ((!empty($package) && $package == 'Pro') || (!empty($package) && $package == 'Business')) {
            $settings = Setting::first();
            $user = Session::get('user'); 
            $user_id = $user->id;
            if($this->enable_moderator_Monetization == 1){

                $ModeratorSubscription = ModeratorSubscription::where('user_id', '=', $user_id)->count(); 
                if($ModeratorSubscription == 0 ){

                    return View::make('moderator.becomeSubscriber');

                }elseif($ModeratorSubscription > 0){

                    $ModeratorSubscription = ModeratorSubscription::where('moderator_subscriptions.user_id', '=', $user_id)->orderBy('moderator_subscriptions.created_at', 'DESC')
                                            ->join('moderator_subscription_plans', 'moderator_subscription_plans.plan_id', '=', 'moderator_subscriptions.stripe_plan')
                                            ->first(); 

                    if( !empty($ModeratorSubscription) ){

                        $upload_video_limit = $ModeratorSubscription->upload_video_limit;
                        $uploaded_videos = Video::where('uploaded_by','CPP')->where('user_id', '=', $user_id)->count();
                        // $uploaded_videos = 0;
                        if($upload_video_limit != null){
                            if($upload_video_limit <= $uploaded_videos){
                                return View::make('moderator.expired_upload');
                            }
                        }

                    }else{
                        return View::make('moderator.becomeSubscriber');
                    }
                }
                // $uploaded_Audios = Audio::where('uploaded_by','CPP')->where('user_id', '=', $user_id)->count();
                // $uploaded_Livestreams = Livestream::where('uploaded_by','CPP')->where('user_id', '=', $user_id)->count();
                // $uploaded_Episodes = Episode::where('uploaded_by','CPP')->where('user_id', '=', $user_id)->count();
                // $total_uploads = $uploaded_videos + $uploaded_Audios + $uploaded_Livestreams + $uploaded_Episodes ;
                // // $total_uploads = 31 ;

                // if($total_uploads >= 30){
                //     return View::make('moderator.expired_upload');
                // }
            }

            $data = [
                'headline' => '<i class="fa fa-plus-circle"></i> New Video',
                'post_route' => URL::to('cpp/videos/fileupdate'),
                'button_text' => 'Add New Video',
                'related_videos' => Video::get(),
                'video_categories' => VideoCategory::all(),
                'video_subtitle' => VideosSubtitle::all(),
                'languages' => Language::all(),
                'subtitles' => Subtitle::all(),
                'artists' => Artist::all(),
                'age_categories' => AgeCategory::all(),
                'settings' => $settings,
                'countries' => CountryCode::all(),
                'video_artist' => [],
                'ads' => Advertisement::where('status', '=', 1)->get(),
                'InappPurchase' => InappPurchase::all(),
            ];

            return View::make('moderator.cpp.videos.fileupload', $data);
        } else {
            return Redirect::to('/blocked');
        }
    }
    /**
     * Store a newly created video in storage.
     *
     * @return Response
     */
    public function CPPstore(Request $request)
    {
        $data = $request->all();

        $validatedData = $request->validate([
            'title' => 'required',
        ]);

        $image = isset($data['image']) ? $data['image'] : '';
        $trailer = isset($data['trailer']) ? $data['trailer'] : '';
        $mp4_url = isset($data['video']) ? $data['video'] : '';
        $files = isset($data['subtitle_upload']) ? $data['subtitle_upload'] : '';

        $path = public_path() . '/uploads/videos/';
        $image_path = public_path() . '/uploads/images/';

        $image = isset($data['image']) ? $data['image'] : '';
        $trailer = isset($data['trailer']) ? $data['trailer'] : '';
        $mp4_url = isset($data['video']) ? $data['video'] : '';
        $files = isset($data['subtitle_upload']) ? $data['subtitle_upload'] : '';
        /* logo upload */

        $path = public_path() . '/uploads/videos/';
        $image_path = public_path() . '/uploads/images/';
        if (!empty($data['artists'])) {
            $artistsdata = $data['artists'];
            unset($data['artists']);
        }
        if ($image != '') {
            //code for remove old file
            if ($image != '' && $image != null) {
                $file_old = $image_path . $image;
                if (file_exists($file_old)) {
                    unlink($file_old);
                }
            }
            //upload new file
            $file = $image;
            $data['image'] = str_replace(' ', '_', $file->getClientOriginalName());
            $file->move($image_path, $data['image']);
        } else {
            $data['image'] = 'default.jpg';
        }

        if ($request->slug != '') {
            $data['slug'] = $this->createSlug($request->slug);
        }

        if ($request->slug == '') {
            $data['slug'] = $this->createSlug($data['title']);
        }

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
            $data['trailer'] = '';
        }

        $user = Session::get('user');

        $data['user_id'] = $user->id;

        if (empty($data['active'])) {
            $data['active'] = 0;
        }

        if (empty($data['year'])) {
            $data['year'] = 0;
        } else {
            $data['year'] = $data['year'];
        }

        if (empty($data['access'])) {
            $data['access'] = 0;
        } else {
            $data['access'] = $data['access'];
        }

        if (empty($data['language'])) {
            $data['language'] = 0;
        } else {
            $data['language'] = $data['language'];
        }

        if (!empty($data['embed_code'])) {
            $data['embed_code'] = $data['embed_code'];
        } else {
            $data['embed_code'] = '';
        }

        if ($request->slug != '') {
            $data['slug'] = $this->createSlug($request->slug);
        }

        if ($request->slug == '') {
            $data['slug'] = $this->createSlug($data['title']);
        }

        if (empty($data['featured'])) {
            $data['featured'] = 0;
        }

        if (empty($data['type'])) {
            $data['type'] = '';
        }

        if (empty($data['status'])) {
            $data['status'] = 0;
        }

        if (empty($data['path'])) {
            $data['path'] = 0;
        }

        // if(Auth::user()->role =='admin' && Auth::user()->sub_admin == 0 ){
        //         $data['status'] = 1;
        //     }

        // if( Auth::user()->role =='admin' && Auth::user()->sub_admin == 1 ){
        //         $data['status'] = 0;
        // }

        if (isset($data['duration'])) {
            //$str_time = $data
            $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $data['duration']);
            sscanf($str_time, '%d:%d:%d', $hours, $minutes, $seconds);
            $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
            $data['duration'] = $time_seconds;
        }

        $user = Session::get('user');

        if (!empty($data['embed_code'])) {
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
            $video->user_id = $user->id;
            $video->save();
        }

        if ($mp4_url != '') {
            $ffprobe = \FFMpeg\FFProbe::create();
            $disk = 'public';
            $data['duration'] = $ffprobe
                ->streams($request->video)
                ->videos()
                ->first()
                ->get('duration');

            $rand = Str::random(16);
            $path = $rand . '.' . $request->video->getClientOriginalExtension();
            $request->video->storeAs('public', $path);
            $thumb_path = 'public';

            $this->build_video_thumbnail($request->video, $path, $data['slug']);

            $original_name = $request->video->getClientOriginalName() ? $request->video->getClientOriginalName() : '';

            $user = Session::get('user');

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
            $video->user_id = $user->id;
            $video->save();

            $lowBitrateFormat = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(500);
            $midBitrateFormat = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(1500);
            $highBitrateFormat = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(3000);
            $converted_name = ConvertVideoForStreaming::handle($path);

            ConvertVideoForStreaming::dispatch($video);
        } else {
            $video = Video::create($data);
        }

        $shortcodes = $request['short_code'];
        $languages = $request['sub_language'];
        /* $languages =$request['language'];*/
        /* $languages = $subtitle->language;*/
        if (!empty($files != '' && $files != null)) {
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
                    $destinationPath = 'public/uploads/subtitles/';
                    $filename = $video->id . '-' . $shortcodes[$key] . '.srt';
                    $files[$key]->move($destinationPath, $filename);
                    $subtitle_data['video_id'] = $video->id;

                    $subtitle_data['sub_language'] = $languages[$key];
                    $subtitle_data['shortcode'] = $shortcodes[$key];
                    $subtitle_data['url'] = URL::to('/') . '/public/uploads/subtitles/' . $filename;
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

        return redirect('admin/videos')->with('message', 'Your video will be available shortly after we process it');
    }

    public function CPPdestroy($id)
    {
        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;
        if ((!empty($package) && $package == 'Pro') || (!empty($package) && $package == 'Business')) {
            $video = Video::find($id);
            Video::destroy($id);
            //        VideoResolution::where('video_id', '=', $id)->delete();
            //        VideoSubtitle::where('video_id', '=', $id)->delete();
            Videoartist::where('video_id', $id)->delete();
            return Redirect::back()->with(['message' => 'Successfully Deleted Video', 'note_type' => 'success']);
        } else {
            return Redirect::to('/blocked');
        }
    }

    public function CPPedit($id)
    {
        // if (!Auth::user()->role == 'admin')
        // {
        //     return redirect('/home');
        // }

        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;

        if ((!empty($package) && $package == 'Pro') || (!empty($package) && $package == 'Business')) {
            $settings = Setting::first();

            $video = Video::find($id);

            $ads_details = AdsVideo::join('advertisements', 'advertisements.id', 'ads_videos.ads_id')
                ->where('ads_videos.video_id', $id)
                ->pluck('ads_id')
                ->first();

            $ads_rolls = AdsVideo::join('advertisements', 'advertisements.id', 'ads_videos.ads_id')
                ->where('ads_videos.video_id', $id)
                ->pluck('ad_roll')
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
                'headline' => '<i class="fa fa-edit"></i> Edit Video',
                'video' => $video,
                'post_route' => URL::to('/cpp/videos/update'),
                'button_text' => 'Update Video',
                // 'admin_user' => Auth::user(),
                'video_categories' => VideoCategory::all(),
                'video_subtitle' => VideosSubtitle::all(),
                'ads' => Advertisement::where('status', '=', 1)->get(),
                'subtitles' => Subtitle::all(),
                'languages' => Language::all(),
                'artists' => Artist::all(),
                'related_videos' => Video::get(),
                'all_related_videos' => RelatedVideo::where('video_id', $id)
                    ->pluck('related_videos_id')
                    ->toArray(),
                'settings' => $settings,
                'countries' => CountryCode::all(),
                'age_categories' => AgeCategory::all(),
                'video_artist' => Videoartist::where('video_id', $id)
                    ->pluck('artist_id')
                    ->toArray(),
                'category_id' => CategoryVideo::where('video_id', $id)
                    ->pluck('category_id')
                    ->toArray(),
                'languages_id' => LanguageVideo::where('video_id', $id)
                    ->pluck('language_id')
                    ->toArray(),
                'ads_paths' => $ads_details ? $ads_details : 0,
                'ads_rolls' => $ads_rolls ? $ads_rolls : 0,
                'InappPurchase' => InappPurchase::all(),
                "block_countries" => BlockVideo::where("video_id", $id)
                ->pluck("country_id")
                ->toArray(),
                'ads_paths' => $ads_details ? $ads_details : 0,
                'ads_rolls' => $ads_rolls ? $ads_rolls : 0,
                "Reels_videos" => $Reels_videos,
                "ads_category" => $ads_category,
                'InappPurchase' => InappPurchase::all() ,
                "block_countries" => BlockVideo::where("video_id", $id)
                ->pluck("country_id")
                ->toArray(),
                'pre_ads'  => Video::select('advertisements.*')->join('advertisements','advertisements.id','=','videos.pre_ads')
                ->where('videos.id',$id)->first(),

                'mid_ads'  => Video::select('advertisements.*')->join('advertisements','advertisements.id','=','videos.mid_ads')
                ->where('videos.id',$id)->first(),

                'post_ads' => Video::select('advertisements.*')->join('advertisements','advertisements.id','=','videos.post_ads')
                ->where('videos.id',$id)->first(),
            ];

            return View::make('moderator.cpp.videos.create_edit', $data);
        } else {
            return Redirect::to('/blocked');
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function CPPupdate(Request $request)
    {
        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;
        if ((!empty($package) && $package == 'Pro') || (!empty($package) && $package == 'Business')) {
            $data = $request->all();

            $validatedData = $request->validate([
                'title' => 'required|max:255',
            ]);

            $id = $data['id'];

            $video = Video::findOrFail($id);
            // if ($request->slug == '') {
            //     $data['slug'] = $this->createSlug($data['title']);
            // }

            $image = isset($data['image']) ? $data['image'] : '';
            $trailer = isset($data['trailer']) ? $data['trailer'] : '';
            $mp4_url2 = isset($data['video']) ? $data['video'] : '';
            $files = isset($data['subtitle_upload']) ? $data['subtitle_upload'] : '';

            $path = public_path() . '/uploads/videos/';

            if (!empty($trailer)) {
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
                $video->trailer = URL::to('/') . '/public/uploads/videos/' . $trailer_vid;
            } else {
                $data['trailer'] = $video->trailer;
            }

            $update_mp4 = $request->get('video');
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

            if (empty($data['language'])) {
                $data['language'] = 0;
            } else {
                $data['language'] = $data['language'];
            }

            if (empty($data['age_restrict'])) {
                $data['age_restrict'] = 0;
            } else {
                $data['age_restrict'] = $data['age_restrict'];
            }

            // $data['age_restrict'] =  $data['age_restrict'];;
            // $dd($data);

            //        if(empty($data['featured'])){
            //            $data['featured'] = 0;
            //        }
            if (empty($data['featured'])) {
                $data['featured'] = 0;
            }
            if (!empty($data['embed_code'])) {
                $data['embed_code'] = $data['embed_code'];
            }
            if (!empty($data['m3u8_url'])) {
                $data['m3u8_url'] = $data['m3u8_url'];
            }

            if (empty($data['active'])) {
                $data['active'] = 0;
            }
            if (empty($data['video_gif'])) {
                $data['video_gif'] = '';
            }

            if (empty($data['type'])) {
                $data['type'] = '';
            }

            if (empty($data['status'])) {
                $data['status'] = 0;
            }

            //            if(empty($data['path'])){
            //                $data['path'] = 0;
            //            }

            // if(Auth::user()->role =='admin' && Auth::user()->sub_admin == 0 ){
            //         $data['status'] = 1;
            //     }

            // if( Auth::user()->role =='admin' && Auth::user()->sub_admin == 1 ){
            //         $data['status'] = 0;
            // }

            $image_path = public_path() . '/uploads/images/';
            if (!empty($image))
            {
                if ($image != '' && $image != null)
                {
                    $file_old = $image_path . $image;
                    if (file_exists($file_old))
                    {
                        unlink($file_old);
                    }
                }
                //upload new file
                $file = $image;
                //   $data['image']  = $file->getClientOriginalName();
                $data['image'] = str_replace(' ', '_', $file->getClientOriginalName());

                $file->move($image_path, $data['image']);
            }
            else
            {
                $data['image'] = $video->image;
            }

            if (isset($data['duration'])) {
                //$str_time = $data
                $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $data['duration']);
                sscanf($str_time, '%d:%d:%d', $hours, $minutes, $seconds);
                $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                $data['duration'] = $time_seconds;
            }

            // if( $mp4_url2 != ''){

            //     $ffprobe = \FFMpeg\FFProbe::create();
            //     $disk = 'public';
            //     $data['duration'] = $ffprobe->streams($request->video)
            //     ->videos()
            //     ->first()
            //     ->get('duration');

            //       //code for remove old file
            //         $rand = Str::random(16);
            //         $path = $rand . '.' . $request->video->getClientOriginalExtension();
            //         $request->video->storeAs('public', $path);
            //         $data['mp4_url'] = $path;
            //         $data['path'] = $rand;

            //         $thumb_path = 'public';
            //         $this->build_video_thumbnail($request->video,$path, $data['slug']);

            //     // $original_name = ($request->video->getClientOriginalName()) ? $request->video->getClientOriginalName() : '';
            //         $original_name = URL::to('/').'/storage/app/public/'.$path;
            //         $lowBitrateFormat = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(500);
            //         $midBitrateFormat  =(new X264('libmp3lame', 'libx264'))->setKiloBitrate(1500);
            //         $highBitrateFormat = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(3000);
            //         $converted_name = ConvertVideoForStreaming::handle($path);

            //         ConvertVideoForStreaming::dispatch($video);

            //  }

            if (!empty($data['embed_code'])) {
                $video->embed_code = $data['embed_code'];
            } else {
                $video->embed_code = '';
            }
            if (!empty($data['global_ppv'])) {
                // dd($data['global_ppv']);

                $video->global_ppv = $data['global_ppv'];
            } else {
                $video->global_ppv = null;
            }
            if (!empty($data['enable'])) {
                // dd($data['global_ppv']);

                $enable = $data['enable'];
            } else {
                $enable = 0;
            }
            if (!empty($data['banner'])) {
                // dd($data['global_ppv']);

                $banner = $data['banner'];
            } else {
                $banner = 0;
            }
            if (!empty($data['embed_code'])) {
                // dd($data['global_ppv']);

                $embed_code = $data['embed_code'];
            } else {
                $embed_code = null;
            }
            if (!empty($data['mp4_url'])) {
                // dd($data['global_ppv']);

                $mp4_url = $data['mp4_url'];
            } else {
                $mp4_url = null;
            }
            if (!empty($data['m3u8_url'])) {
                // dd($data['global_ppv']);
                $m3u8_url = $data['m3u8_url'];
            } else {
                $m3u8_url = null;
            }
            if (!empty($data['title'])) {
                // dd($data['global_ppv']);
                $video->title = $data['title'];
            } else {
            }
            if (!empty($data['slug'])) {
                // dd($data['global_ppv']);
                $video->slug = $data['slug'];
            } else {
                $video->slug = $this->createSlug($data['slug']);
            }
            if (empty($data['publish_type'])) {
                // dd($data['global_ppv']);
                $publish_type = 'publish_now';
            }else{
                $publish_type = $data['publish_type'];
            }
            if (empty($data['publish_time'])) {
                // dd($data['global_ppv']);
                $video->publish_time = 0;
            }

            if (!empty($data['m3u8_url'])) {
                // dd($data['global_ppv']);
                $m3u8_url = $data['m3u8_url'];
            } else {
                $m3u8_url = null;
            }
            if (!empty($data['mp4_url'])) {
                $video->mp4_url = $data['mp4_url'];
            }

            if (!empty($data['searchtags'])) {
                $searchtags = $data['searchtags'];
            } else {
                $searchtags = $video->searchtags;
            }

            // E-Paper
            if ($request->pdf_file != null) {
                $pdf_files = time() . '.' . $request->pdf_file->extension();
                $request->pdf_file->move(public_path('uploads/videoPdf'), $pdf_files);
                $video->pdf_files = $pdf_files;
            }
            // Reels videos
            $reels_videos = $request->reels_videos;

            if ($reels_videos != null) {
                $reelvideo_name = time() . '.' . $request->reels_videos->extension();
                $reelvideo_names = 'reels' . $reelvideo_name;
                $reelvideo = $request->reels_videos->move(public_path('uploads/reelsVideos'), $reelvideo_name);

                $ffmpeg = \FFMpeg\FFMpeg::create();
                $videos = $ffmpeg->open('public/uploads/reelsVideos' . '/' . $reelvideo_name);
                $videos->filters()->clip(TimeCode::fromSeconds(1), TimeCode::fromSeconds(60));
                $videos->save(new \FFMpeg\Format\Video\X264('libmp3lame'), 'public/uploads/reelsVideos' . '/' . $reelvideo_names);
                $video->reelvideo = $reelvideo_names;
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
            if (!empty($video->uploaded_by)) {
                $uploaded_by = $video->uploaded_by;
            } else {
                $uploaded_by = 'CPP';
            }

            if (empty($data['active'])) {
                $active = 0;
                $status = 0;
                $draft = 1;
            } else {
                $active = 1;
                $draft = 1;
                if (($video->type == '' && $video->processed_low != 100) || ($video->type == '' && $video->processed_low == null)) {
                    $status = 0;
                } else {
                    $status = 1;
                    $draft = 0;
                }
            }

            $player_image = isset($data["player_image"])? $data["player_image"]: "";

            if($request->hasFile('player_image')){

                if (File::exists(base_path('public/uploads/images/'.$player_image))) {
                    File::delete(base_path('public/uploads/images/'.$player_image));
                }
            
                $player_image_upload = $request->player_image;
    
                if(compress_image_enable() == 1){
    
                    $Tv_image_format  = time().'.'.compress_image_format();
                    $Tv_image_filename     =  'player-image-'.$Tv_image_format ;
                    Image::make($player_image_upload)->save(base_path().'/public/uploads/images/'.$Tv_image_filename,compress_image_resolution() );
                    $player_image = $Tv_image_filename;
    
                }else{
    
                    $Tv_image_format  = time().'.'.$player_image->getClientOriginalExtension();
                    $Tv_image_filename     =  'player-image-'.$Tv_image_format ;
                    Image::make($player_image_upload)->save(base_path().'/public/uploads/images/'.$Tv_image_filename );
                    $player_image = $Tv_image_filename;
               
                }
                $player_image = $player_image;
            }else {
                $player_image = $video->player_image;
            }

            // DD($player_image);
                     // Tv video Image 
        $video_title_image = isset($data["video_title_image"])? $data["video_title_image"]: "";

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
        }else {
            $video->video_tv_image = $video->video_tv_image;
        }

                    // Video Title Thumbnail
        $video_title_image = isset($data["video_title_image"])? $data["video_title_image"]: "";

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
        }else {
            $video->video_title_image = $video->video_title_image;
        }

            $user = Session::get('user');
            $user_id = $user->id;
            $video->user_id = $user_id;
            $shortcodes = $request['short_code'];
            $languages = $request['sub_language'];
            $video->skip_recap = $data['skip_recap'];
            $video->skip_intro = $data['skip_intro'];
            $video->age_restrict = $data['age_restrict'];
            $video->access = $data['access'];
            $video->publish_status = $request['publish_status'];
            $video->publish_type = $publish_type;
            $video->publish_time = $data['publish_time'];
            $video->active = $active;
            $video->status = $status;
            $video->status = $status;
            $video->uploaded_by = $uploaded_by;
            $video->player_image = $player_image;
            $video->image = $data['image'];
            $video->m3u8_url = $m3u8_url;
            $video->mp4_url = $mp4_url;
            $video->embed_code = $embed_code;
            $video->ppv_price = $data['ppv_price'];
            $video->type = $data['type'];
            $video->description = strip_tags($data['description']);
            $video->banner = $banner;
            $video->enable = $enable;
            $video->search_tags = $searchtags;
            $video->ios_ppv_price = $data['ios_ppv_price'];
            $video->uploaded_by = 'CPP';

            $video->save();

            if (!empty($data['related_videos'])) {
                RelatedVideo::where('video_id', $video->id)->delete();
                $related_videos = $data['related_videos'];
                // unset($data['related_videos']);
                /*save artist*/
                if (!empty($related_videos)) {
                    foreach ($related_videos as $key => $vid) {
                        // RelatedVideo::where('video_id', $video->id)->delete();

                        $videos = Video::where('id', $vid)->get();
                        foreach ($videos as $key => $val) {
                            $RelatedVideo = new RelatedVideo();
                            $RelatedVideo->video_id = $video->id;
                            $RelatedVideo->user_id = $user_id;
                            $RelatedVideo->related_videos_id = $val->id;
                            $RelatedVideo->related_videos_title = $val->title;
                            $RelatedVideo->save();
                        }
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
                    }
                } else {
                    Videoartist::where('video_id', $video->id)->delete();
                }
            }

            if (!empty($data['searchtags'])) {
                $searchtags = explode(',', $data['searchtags']);
                VideoSearchTag::where('video_id', $video->id)->delete();
                foreach ($searchtags as $key => $value) {
                    $videosearchtags = new VideoSearchTag();
                    $videosearchtags->user_id = $user_id;
                    $videosearchtags->video_id = $video->id;
                    $videosearchtags->search_tag = $value;
                    $videosearchtags->save();
                }
            } else {
                VideoSearchTag::where('video_id', $video->id)->delete();
            }

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
                    }
                }
            }

            if (!empty($files != '' && $files != null)) {
                /*if($request->hasFile('subtitle_upload'))
        {
            $files = $request->file('subtitle_upload');*/

                foreach ($files as $key => $val) {
                    if (!empty($files[$key])) {
                        $destinationPath = 'public/uploads/subtitles/';
                        $filename = $video->id . '-' . $shortcodes[$key] . '.srt';
                        $files[$key]->move($destinationPath, $filename);
                        $subtitle_data['sub_language'] = $languages[$key]; /*URL::to('/').$destinationPath.$filename; */
                        $subtitle_data['shortcode'] = $shortcodes[$key];
                        $subtitle_data['movie_id'] = $id;
                        $subtitle_data['url'] = URL::to('/') . '/public/uploads/subtitles/' . $filename;
                        $video_subtitle = MoviesSubtitles::updateOrCreate(['shortcode' => 'en', 'movie_id' => $id], $subtitle_data);
                    }
                }
            }
            // dd($data);
            /*Advertisement Video update starts*/
            if (isset($data['ads_id']) && $data['ads_id'] != 0) {
                $ad_video = AdsVideo::where('video_id', $id)->first();

                if ($ad_video == null) {
                    $ad_video = new AdsVideo();
                }

                $ad_video->video_id = $id;
                $ad_video->ads_id = $data['ads_id'];
                $ad_video->ad_roll = null;
                $ad_video->save();
            }
            /*Advertisement Video update ends*/

            return Redirect::back()->with(['message' => 'Successfully Updated Video!', 'note_type' => 'success']);
        } else {
            return Redirect::to('/blocked');
        }
    }

    private function getCleanFileName($filename)
    {
        return preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename) . '.mp4';
    }

    /* slug function for Video categoty */

    public function createSlug($title, $id = 0)
    {
        $slug = Str::slug($title);

        $allSlugs = $this->getRelatedSlugs($slug, $id);

        // If we haven't used it before then we are all good.
        if (!$allSlugs->contains('slug', $slug)) {
            return $slug;
        }

        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 10; $i++) {
            $newSlug = $slug . '-' . $i;
            if (!$allSlugs->contains('slug', $newSlug)) {
                return $newSlug;
            }
        }

        throw new \Exception('Can not create a unique slug');
    }

    protected function getRelatedSlugs($slug, $id = 0)
    {
        return Video::select('slug')
            ->where('slug', 'like', $slug . '%')
            ->where('id', '<>', $id)
            ->get();
    }

    public function build_video_thumbnail($video_path, $movie, $thumb_path)
    {
        // Create a temp directory for building.
        $temp = storage_path('app/public') . '/build';
        if (!file_exists($temp)) {
            File::makeDirectory($temp);
        }

        // Use FFProbe to get the duration of the video.
        $ffprobe = \FFMpeg\FFProbe::create();
        $duration = $ffprobe
            ->streams($video_path)
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
            file_put_contents(storage_path('app/public') . '/' . $thumb_path . '.gif', $gc->getGif());

            // Remove all the temporary frames.
            foreach ($frames as $file) {
                unlink($file);
            }
        }
    }

    public function CPPfileupdate(Request $request)
    {
        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;
        if ((!empty($package) && $package == 'Pro') || (!empty($package) && $package == 'Business')) {
            $data = $request->all();
            $validatedData = $request->validate([
                'title' => 'required|max:255',
            ]);

            $id = $data['video_id'];

            $video = Video::findOrFail($id);

            // if(empty($data['ppv_price'])){
            //     $settings = Setting::where('ppv_status','=',1)->first();
            //     if(!empty($settings)){
            //     // dd($settings);
            //         $data['ppv_price'] = $settings->ppv_price;
            //         $video->global_ppv = 1 ;
            //     }
            //     }  else {
            //     }

            if (!empty($data['ppv_price']) && $data['ppv_price'] > 0) {
                $video->global_ppv = 1;
            } else {
                $video->global_ppv = null;
            }
            $image = (isset($data['image'])) ? $data['image'] : '';
            $trailer = (isset($data['trailer'])) ? $data['trailer'] : '';
            $files = (isset($data['subtitle_upload'])) ? $data['subtitle_upload'] : '';

            $player_image = isset($data["player_image"])? $data["player_image"]: "";

            if($request->hasFile('player_image')){

                if (File::exists(base_path('public/uploads/images/'.$player_image))) {
                    File::delete(base_path('public/uploads/images/'.$player_image));
                }
            
                $player_image_upload = $request->player_image;
    
                if(compress_image_enable() == 1){
    
                    $Tv_image_format  = time().'.'.compress_image_format();
                    $Tv_image_filename     =  'player-image-'.$Tv_image_format ;
                    Image::make($player_image_upload)->save(base_path().'/public/uploads/images/'.$Tv_image_filename,compress_image_resolution() );
                    $player_image = $Tv_image_filename;
    
                }else{
    
                    $Tv_image_format  = time().'.'.$player_image->getClientOriginalExtension();
                    $Tv_image_filename     =  'player-image-'.$Tv_image_format ;
                    Image::make($player_image_upload)->save(base_path().'/public/uploads/images/'.$Tv_image_filename );
                    $player_image = $Tv_image_filename;
               
                }
                $player_image = $player_image;
            }
            // DD($player_image);
                     // Tv video Image 
        $video_title_image = isset($data["video_title_image"])? $data["video_title_image"]: "";

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
        }

                    // Video Title Thumbnail
        $video_title_image = isset($data["video_title_image"])? $data["video_title_image"]: "";

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
            $settings = Setting::where('ppv_status', '=', 1)->first();

            if (!empty($data['global_ppv'])) {
                $data['ppv_price'] = $settings->ppv_price;
                $video->global_ppv = $data['global_ppv'];
            } else {
                $video->global_ppv = null;
            }
            if ($request->slug == '') {
                $data['slug'] = $this->createSlug($data['title']);
            } else {
                $data['slug'] = $this->createSlug($data['slug']);
            }

            $image = isset($data['image']) ? $data['image'] : '';
            $trailer = isset($data['trailer']) ? $data['trailer'] : '';
            $files = isset($data['subtitle_upload']) ? $data['subtitle_upload'] : '';


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

            if (empty($data['language'])) {
                $data['language'] = 0;
            } else {
                $data['language'] = $data['language'];
            }

            //        if(empty($data['featured'])){
            //            $data['featured'] = 0;
            //        }
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

            // if(empty($data['type'])){
            //     $data['type'] = '';
            // }

            if (empty($data['status'])) {
                $data['status'] = 0;
            }

            //            if(empty($data['path'])){
            //                $data['path'] = 0;
            //            }
            if ($package != 'Business') {
                $data['status'] = 1;
            } elseif ($package == 'Business' && $settings->transcoding_access == 1) {
                $data['status'] = 0;
            } elseif ($package == 'Business' && $settings->transcoding_access == 0) {
                $data['status'] = 1;
            } else {
                $data['status'] = 1;
            }

            $path = public_path() . '/uploads/videos/';
            $image_path = public_path() . '/uploads/images/';

            $image_path = public_path() . '/uploads/images/';
            if (!empty($image))
            {
                if ($image != '' && $image != null)
                {
                    $file_old = $image_path . $image;
                    if (file_exists($file_old))
                    {
                        unlink($file_old);
                    }
                }
                //upload new file
                $file = $image;
                //   $data['image']  = $file->getClientOriginalName();
                $data['image'] = str_replace(' ', '_', $file->getClientOriginalName());

                $file->move($image_path, $data['image']);
            }
            else
            {
                $data['image'] = $video->image;
            }


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
            if (!empty($data['banner'])) {
                $banner = $data['banner'];
            } else {
                $banner = 0;
            }

            if (!empty($data['age_restrict'])) {
                $video->age_restrict = $data['age_restrict'];
            }
            if (empty($data['searchtags'])) {
                $searchtags = null;
            } else {
                $searchtags = $data['searchtags'];
            }

            // E -Paper File
            if ($request->pdf_file != null) {
                $pdf_files = time() . '.' . $request->pdf_file->extension();
                $request->pdf_file->move(public_path('uploads/videoPdf'), $pdf_files);
                $video->pdf_files = $pdf_files;
            }

            //Reels videos
            $reels_videos = $request->reels_videos;

            if ($reels_videos != null) {
                $reelvideo_name = time() . '.' . $request->file('reels_videos')->extension();
                $reelvideo_names = 'reels' . $reelvideo_name;
                $reelvideo = $request->file('reels_videos')->move(public_path('uploads/reelsVideos'), $reelvideo_name);

                $ffmpeg = \FFMpeg\FFMpeg::create();
                $videos = $ffmpeg->open('public/uploads/reelsVideos' . '/' . $reelvideo_name);
                $videos->filters()->clip(TimeCode::fromSeconds(1), TimeCode::fromSeconds(60));
                $videos->save(new \FFMpeg\Format\Video\X264('libmp3lame'), 'public/uploads/reelsVideos' . '/' . $reelvideo_names);
                $video->reelvideo = $reelvideo_names;
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
  
            $user = Session::get('user');
            $user_id = $user->id;
            $ModeratorsUser = ModeratorsUser::where('id', $user_id)->first();
            $shortcodes = $request['short_code'];
            $languages = $request['sub_language'];
            $video->user_id = $user_id;
            $video->skip_recap = $data['skip_recap'];
            $video->skip_intro = $data['skip_intro'];
            $video->description = strip_tags($data['description']);
            $video->draft = 1;
            $video->active = 1;
            $video->publish_type = $data['publish_type'];
            $video->publish_time = $data['publish_time'];
            $video->image = $data['image'];
            $video->player_image = $player_image;
            $video->uploaded_by = 'CPP';
            $video->ppv_price = $data['ppv_price'];
            $video->access = $data['access'];
            $video->banner = $banner;
            $video->enable = 1;
            $video->search_tags = $searchtags;
            $video->ios_ppv_price = $data['ios_ppv_price'];
            $video->uploaded_by = 'CPP';

            $video->update($data);

            $video = Video::findOrFail($id);

            if (!empty($data['searchtags'])) {
                $searchtags = explode(',', $data['searchtags']);
                VideoSearchTag::where('video_id', $video->id)->delete();
                foreach ($searchtags as $key => $value) {
                    $videosearchtags = new VideoSearchTag();
                    $videosearchtags->user_id = $user_id;
                    $videosearchtags->video_id = $video->id;
                    $videosearchtags->search_tag = $value;
                    $videosearchtags->save();
                }
            }

            if (!empty($data['related_videos'])) {
                $related_videos = $data['related_videos'];
              
                if (!empty($related_videos)) {
                    foreach ($related_videos as $key => $vid) {
                        $videos = Video::where('id', $vid)->get();
                        foreach ($videos as $key => $val) {
                            $RelatedVideo = new RelatedVideo();
                            $RelatedVideo->video_id = $id;
                            $RelatedVideo->user_id = $user_id;
                            $RelatedVideo->related_videos_id = $val->id;
                            $RelatedVideo->related_videos_title = $val->title;
                            $RelatedVideo->save();
                        }
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
                    }
                }
            }
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
                    }
                }
            }
            if (!empty($files != '' && $files != null)) {

                foreach ($files as $key => $val) {
                    if (!empty($files[$key])) {
                        $destinationPath = 'public/uploads/subtitles/';
                        $filename = $video->id . '-' . $shortcodes[$key] . '.srt';
                        $files[$key]->move($destinationPath, $filename);
                        $subtitle_data['sub_language'] = $languages[$key]; /*URL::to('/').$destinationPath.$filename; */
                        $subtitle_data['shortcode'] = $shortcodes[$key];
                        $subtitle_data['movie_id'] = $id;
                        $subtitle_data['url'] = URL::to('/') . '/public/uploads/subtitles/' . $filename;
                        $video_subtitle = MoviesSubtitles::updateOrCreate(['shortcode' => 'en', 'movie_id' => $id], $subtitle_data);
                    }
                }
            }

            /*Advertisement Video update starts*/
            if ($data['ads_id'] != 0) {
                $ad_video = new AdsVideo();
                $ad_video->video_id = $video->id;
                $ad_video->ads_id = $data['ads_id'];
                $ad_video->ad_roll = null;
                $ad_video->save();
            }
            /*Advertisement Video update End*/
           
            $settings = Setting::first();
            $user = Session::get('user');

                    // Admin Mail
            try {
                    $email_template_subject =  EmailTemplate::where('id',11)->pluck('heading')->first() ;
                    $email_subject  = str_replace("{ContentName}", "$ModeratorsUser->username", $email_template_subject);

                    $data = array(
                        'email_subject' => $email_subject,
                    );

                    Mail::send('emails.CPP_Partner_Content_Pending', array(
                        'Name'         => "Admin",
                        'ContentName'  =>  $video->title,
                        'UploadMessage'  => 'Video has been submitted',
                        'AdminApprovalLink' => "Link - " . URL::to('/admin/CPPVideosIndex'),
                        'website_name' => GetWebsiteName(),
                    ), 
                    function($message) use ($data,$ModeratorsUser) {
                        $message->from(AdminMail(),GetWebsiteName());
                        $message->to(AdminMail())->subject($data['email_subject']);
                    });

                    $email_log      = 'Mail Sent Successfully from Partner Content Video Is Pending Admin Approval.';
                    $email_template = "11";
                    $user_id = $id;

                    Email_sent_log($user_id,$email_log,$email_template);

            } catch (\Throwable $th) {

                $email_log = $th->getMessage();
                $email_template = '11';
                $user_id = $user_id;

                Email_notsent_log($user_id, $email_log, $email_template);
            }

            try {

                    $email_template_subject =  EmailTemplate::where('id',11)->pluck('heading')->first() ;
                    $email_subject  = str_replace("{ContentName}", "$video->title", $email_template_subject);

                    $data = array(
                        'email_subject' => $email_subject,
                    );

                    Mail::send('emails.CPP_Partner_Content_Pending', array(
                        'Name'         => $ModeratorsUser->username,
                        'ContentName'  =>  $video->title,
                        'AdminApprovalLink' => "",
                        'website_name' => GetWebsiteName(),
                        'UploadMessage'  => 'A Video has been Uploaded into Portal',
                    ), 
                    function($message) use ($data,$ModeratorsUser) {
                        $message->from(AdminMail(),GetWebsiteName());
                        $message->to($ModeratorsUser->email, $ModeratorsUser->username)->subject($data['email_subject']);
                    });

                    $email_log      = 'Mail Sent Successfully from Partner Content Video Successfully Uploaded & Awaiting Approval !';
                    $email_template = "44";
                    $user_id = $id;

                    Email_sent_log($user_id,$email_log,$email_template);

            } catch (\Throwable $th) {

                $email_log = $th->getMessage();
                $email_template = "44";
                $user_id = $user_id;

                Email_notsent_log($user_id, $email_log, $email_template);
            }

            return Redirect::back()->with('message', 'Content has been Submitted for Approval ');

        } else {

            return Redirect::to('/blocked');
        }
    }
    public function CPPMp4url(Request $request)
    {
        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;



        if ((!empty($package) && $package == 'Pro') || (!empty($package) && $package == 'Business')) {
            $data = $request->all();
            $value = [];
            $user = Session::get('user');

            $user_id = $user->id;
            if($this->enable_moderator_Monetization == 1){

                $ModeratorSubscription = ModeratorSubscription::where('user_id', '=', $user_id)->count(); 
                
                    if($ModeratorSubscription == 0 ){

                        $value = [];
                        $value['total_uploads'] = 0;
                        return $value;

                    }elseif($ModeratorSubscription > 0){

                        $ModeratorSubscription = ModeratorSubscription::where('moderator_subscriptions.user_id', '=', $user_id)->orderBy('moderator_subscriptions.created_at', 'DESC')
                                                ->join('moderator_subscription_plans', 'moderator_subscription_plans.plan_id', '=', 'moderator_subscriptions.stripe_plan')
                                                ->first(); 

                        if( !empty($ModeratorSubscription) ){

                            $upload_video_limit = $ModeratorSubscription->upload_video_limit;
                            $uploaded_videos = Video::where('uploaded_by','CPP')->where('user_id', '=', $user_id)->count();
                            
                            if($upload_video_limit != null){
                                if($upload_video_limit <= $uploaded_videos){
                                    $value = [];
                                    $value['total_uploads'] = 0;
                                    return $value;
                                }
                            }

                        }else{
                                $value = [];
                                $value['total_uploads'] = 0;
                                return $value;
                        }
                        
                    }else{
                                $value = [];
                                $value['total_uploads'] = 0;
                                return $value;
                    }
                }
            if (!empty($data['mp4_url'])) {
                $video = new Video();
                $video->disk = 'public';
                $video->original_name = 'public';
                $video->title = $data['mp4_url'];
                $video->mp4_url = $data['mp4_url'];
                $video->type = 'mp4_url';
                $video->image = 'default_image.jpg';
                $video->draft = 0;
                $video->active = 1;
                $video->user_id = $user->id;
                $video->image = 'default_image.jpg';

                $PC_image_path = public_path('/uploads/images/default_image.jpg');

                if (file_exists($PC_image_path)) {
                    $Mobile_image = 'Mobile-default_image.jpg';
                    $Tablet_image = 'Tablet-default_image.jpg';

                    Image::make($PC_image_path)
                        ->resize(244, 310)
                        ->save(base_path() . '/public/uploads/images/' . $Mobile_image);
                    Image::make($PC_image_path)
                        ->resize(120, 190)
                        ->save(base_path() . '/public/uploads/images/' . $Tablet_image);

                    $video->mobile_image = $Mobile_image;
                    $video->tablet_image = $Tablet_image;
                } else {
                    $video->mobile_image = 'default_image.jpg';
                    $video->tablet_image = 'default_image.jpg';
                }
                $video->save();

                $video_id = $video->id;

                $value['success'] = 1;
                $value['message'] = 'Uploaded Successfully!';
                $value['video_id'] = $video_id;

                return $value;
            }
        } else {
            return Redirect::to('/blocked');
        }
    }
    public function CPPm3u8url(Request $request)
    {
        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;
        if ((!empty($package) && $package == 'Pro') || (!empty($package) && $package == 'Business')) {
            $data = $request->all();
            $value = [];
            $user = Session::get('user');

            $user_id = $user->id;

            if($this->enable_moderator_Monetization == 1){

                $ModeratorSubscription = ModeratorSubscription::where('user_id', '=', $user_id)->count(); 
                
                if($ModeratorSubscription == 0 ){

                    $value = [];
                    $value['total_uploads'] = 0;
                    return $value;

                }elseif($ModeratorSubscription > 0){

                    $ModeratorSubscription = ModeratorSubscription::where('moderator_subscriptions.user_id', '=', $user_id)->orderBy('moderator_subscriptions.created_at', 'DESC')
                                            ->join('moderator_subscription_plans', 'moderator_subscription_plans.plan_id', '=', 'moderator_subscriptions.stripe_plan')
                                            ->first(); 

                    if( !empty($ModeratorSubscription) ){

                        $upload_video_limit = $ModeratorSubscription->upload_video_limit;
                        $uploaded_videos = Video::where('uploaded_by','CPP')->where('user_id', '=', $user_id)->count();
                        
                        if($upload_video_limit != null){
                            if($upload_video_limit <= $uploaded_videos){
                                $value = [];
                                $value['total_uploads'] = 0;
                                return $value;
                            }
                        }

                    }else{
                            $value = [];
                            $value['total_uploads'] = 0;
                            return $value;
                    }
                    
                }else{
                            $value = [];
                            $value['total_uploads'] = 0;
                            return $value;
                }
            }
            if (!empty($data['m3u8_url'])) {
                $video = new Video();
                $video->disk = 'public';
                $video->original_name = 'public';
                $video->title = $data['m3u8_url'];
                $video->m3u8_url = $data['m3u8_url'];
                $video->type = 'm3u8_url';
                $video->image = 'default_image.jpg';
                $video->draft = 0;
                $video->active = 1;
                $video->user_id = $user->id;
                $video->image = 'default_image.jpg';

                $PC_image_path = public_path('/uploads/images/default_image.jpg');

                if (file_exists($PC_image_path)) {
                    $Mobile_image = 'Mobile-default_image.jpg';
                    $Tablet_image = 'Tablet-default_image.jpg';

                    Image::make($PC_image_path)
                        ->resize(244, 310)
                        ->save(base_path() . '/public/uploads/images/' . $Mobile_image);
                    Image::make($PC_image_path)
                        ->resize(120, 190)
                        ->save(base_path() . '/public/uploads/images/' . $Tablet_image);

                    $video->mobile_image = $Mobile_image;
                    $video->tablet_image = $Tablet_image;
                } else {
                    $video->mobile_image = 'default_image.jpg';
                    $video->tablet_image = 'default_image.jpg';
                }

                $video->save();

                $video_id = $video->id;

                $value['success'] = 1;
                $value['message'] = 'Uploaded Successfully!';
                $value['video_id'] = $video_id;

                return $value;
            }
        } else {
            return Redirect::to('/blocked');
        }
    }
    public function CPPEmbededcode(Request $request)
    {
        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;

        if ((!empty($package) && $package == 'Pro') || (!empty($package) && $package == 'Business')) {
            $data = $request->all();
            $value = [];

            // echo "<pre>";
            // print_r($data);
            // exit();
            $user = Session::get('user');

            $user_id = $user->id;
            if($this->enable_moderator_Monetization == 1){

                $ModeratorSubscription = ModeratorSubscription::where('user_id', '=', $user_id)->count(); 
                
                    if($ModeratorSubscription == 0 ){

                        $value = [];
                        $value['total_uploads'] = 0;
                        return $value;

                    }elseif($ModeratorSubscription > 0){

                        $ModeratorSubscription = ModeratorSubscription::where('moderator_subscriptions.user_id', '=', $user_id)->orderBy('moderator_subscriptions.created_at', 'DESC')
                                                ->join('moderator_subscription_plans', 'moderator_subscription_plans.plan_id', '=', 'moderator_subscriptions.stripe_plan')
                                                ->first(); 

                        if( !empty($ModeratorSubscription) ){

                            $upload_video_limit = $ModeratorSubscription->upload_video_limit;
                            $uploaded_videos = Video::where('uploaded_by','CPP')->where('user_id', '=', $user_id)->count();
                            
                            if($upload_video_limit != null){
                                if($upload_video_limit <= $uploaded_videos){
                                    $value = [];
                                    $value['total_uploads'] = 0;
                                    return $value;
                                }
                            }

                        }else{
                                $value = [];
                                $value['total_uploads'] = 0;
                                return $value;
                        }
                        
                    }else{
                                $value = [];
                                $value['total_uploads'] = 0;
                                return $value;
                    }
                }
            if (!empty($data['embed'])) {
                $video = new Video();
                $video->disk = 'public';
                $video->original_name = 'public';
                $video->title = $data['embed'];
                $video->embed_code = $data['embed'];
                $video->type = 'embed';
                $video->image = 'default_image.jpg';
                $video->draft = 0;
                $video->active = 1;
                $video->user_id = $user->id;

                $video->image = 'default_image.jpg';

                $PC_image_path = public_path('/uploads/images/default_image.jpg');

                if (file_exists($PC_image_path)) {
                    $Mobile_image = 'Mobile-default_image.jpg';
                    $Tablet_image = 'Tablet-default_image.jpg';

                    Image::make($PC_image_path)
                        ->resize(244, 310)
                        ->save(base_path() . '/public/uploads/images/' . $Mobile_image);
                    Image::make($PC_image_path)
                        ->resize(120, 190)
                        ->save(base_path() . '/public/uploads/images/' . $Tablet_image);

                    $video->mobile_image = $Mobile_image;
                    $video->tablet_image = $Tablet_image;
                } else {
                    $video->mobile_image = 'default_image.jpg';
                    $video->tablet_image = 'default_image.jpg';
                }

                $video->save();

                $video_id = $video->id;

                $value['success'] = 1;
                $value['message'] = 'Uploaded Successfully!';
                $value['video_id'] = $video_id;

                return $value;
            }
        } else {
            return Redirect::to('/blocked');
        }
    }

    
    public function CPPeditvideo($id)
    {

     
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
                $dropzone_url =  URL::to('cpp/uploadEditVideo');
            }elseif($StorageSetting->aws_storage == 1){
                $dropzone_url =  URL::to('cpp/AWSuploadEditVideo');
            }else{ 
                $dropzone_url =  URL::to('cpp/uploadEditVideo');
            }
            $user = Session::get('user');
            $id = $user->id;
            
        $data = [
            "headline" => '<i class="fa fa-edit"></i> Edit Video',
            "video" => $video,
            "post_route" => URL::to("cpp/videos/update"),
            "button_text" => "Update Video",
            "user" => $user,
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

        return View::make("moderator.cpp.videos.edit_video", $data);
    }
    public function Updatemp4url(Request $request)
    {
        $value = [];
        $data = $request->all();
        $user = Session::get('user');
        $userid = $user->id;
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

            $video->user_id = $userid;
            $video->save();

            $video_id = $video->id;

            $value["success"] = 1;
            $value["message"] = "URL Updated Successfully!";
            $value["video_id"] = $video_id;

            // return $value;
            return redirect("/cpp/videos");

        }
    }
    }
    public function Updatem3u8url(Request $request)
    {
        $data = $request->all();
        $value = [];
        $user = Session::get('user');
        $userid = $user->id;
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

            $video->user_id = $userid;
            $video->save();

            $video_id = $video->id;

            $value["success"] = 1;
            $value["message"] = "URL Updated Successfully!";
            $value["video_id"] = $video_id;

            // return $value;
            return redirect("/cpp/videos");

        }
    }

    }
    public function UpdateEmbededcode(Request $request)
    {
        $data = $request->all();
        $value = [];
        $user = Session::get('user');
        $userid = $user->id;
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

            $video->user_id = $userid;
            $video->save();

            $video_id = $video->id;

            $value["success"] = 1;
            $value["message"] = "URL Updated Successfully!";
            $value["video_id"] = $video_id;
            // return $value;
            return redirect("/cpp/videos");

        }
    }
    }

    
    public function uploadEditVideo(Request $request)
    {
        $value = [];
        $data = $request->all();
        $id = $data["videoid"];
        $video = Video::findOrFail($id);
        $user = Session::get('user');
        $userid = $user->id;
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
            return redirect("/cpp/videos");

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
            $video->old_path_mp4 = $path;
            $video->title = $file_folder_name;
            $video->mp4_url = $storepath;
            //  $video->draft = 0;
            $video->type = "";
            //  $video->image = 'default_image.jpg';
            $video->duration = $Video_duration;
            $video->user_id = $userid;
            $video->save();


            $Playerui = Playerui::first();
            if(@$Playerui->video_watermark_enable == 1 && !empty($Playerui->video_watermark)){
                TranscodeVideo::dispatch($video);
            }else{
                ConvertVideoForStreaming::dispatch($video);
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


}

<?php
namespace App\Http\Controllers;
use DB;
use URL;
use Auth;
use File;
use Hash;
use Mail;
use View;
use Theme;
use getID3;
use Session;
use Exception;
use ParseM3U8;
use Validator;
use App\Playerui;
use App\Subtitle;
use App\UGCVideo;
use App\Wishlist;
use App\SiteTheme;
use Carbon\Carbon;
use GeoIPLocation;
use App\Tag as Tag;
use App\Watchlater;
use FFMpeg\FFProbe;
use App\CountryCode;
use App\HomeSetting;
use App\LikeDislike;
use App\Test as Test;
use App\User as User;
use App\CompressImage;
use App\EmailTemplate;
use App\InappPurchase;
use App\UGCSubscriber;
use GuzzleHttp\Client;
use App\CommentSection;
use App\Jobs\VideoClip;
use App\ModeratorsUser;
use App\PlayerAnalytic;
use App\Video as Video;
use App\VideoSearchTag;
use \Redirect as Redirect;
use GifCreator\GifCreator;
use App\Channel as Channel;
use App\Setting as Setting;
use Illuminate\Support\Str;
use App\Jobs\TranscodeVideo;
use Illuminate\Http\Request;
use App\DefaultSchedulerData;
use App\Language as Language;
use App\TimeZone as TimeZone;
use App\VideoExtractedImages;
use FFMpeg\Format\Video\X264;
use Streaming\Representation;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\Coordinate\Dimension;
use GuzzleHttp\Message\Response;
use App\Jobs\ConvertVideoTrailer;
use App\ReSchedule as ReSchedule;
use App\TimeFormat as TimeFormat;
use FFMpeg\Filters\Video\Resizer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use Symfony\Component\Process\Process;
use App\VideoPlaylist as VideoPlaylist;
use Illuminate\Support\Facades\Storage;
use App\Jobs\Convert4kVideoForStreaming;
use App\Jobs\ConvertUGCVideoForStreaming;
use App\StorageSetting as StorageSetting;
use App\VideosSubtitle as VideosSubtitle;
use App\MoviesSubtitles as MoviesSubtitles;
use FFMpeg\Filters\Video\VideoResizeFilter;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Pagination\LengthAwarePaginator;
use App\AdminVideoPlaylist as AdminVideoPlaylist;
use ProtoneMedia\LaravelFFMpeg\Filters\WatermarkFactory;
use Symfony\Component\Process\Exception\ProcessFailedException;


class UGCController extends Controller
{

    public function __construct()
    {
        $settings = Setting::first();

        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
        $userIp = $geoip->getip();
        $countryName = $geoip->getCountry();
        $regionName = $geoip->getregion();
        $cityName = $geoip->getcity();

        $this->countryName = $countryName;

        $this->videos_per_page = $settings->videos_per_page;

        $this->Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses($this->Theme);
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
               
                $videos = UGCVideo::orderBy("created_at", "DESC")->paginate(9);
        
                $user = Auth::user();
                $data = [
                    "videos" => $videos,
                    "user" => $user,
                    "admin_user" => Auth::user(),
                ];
    
                return View("admin.ugc_videos.index", $data);
            }
    }

    public function UGCvideosIndex()
    {
        // if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
        //     return redirect('/admin/restrict');
        // }
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
            $videos = UGCVideo::with('user')->orderBy('created_at', 'desc')->paginate(9);

            $data = [
                "videos" => $videos,
            ];
           
            return View("admin.ugc_videos.ugc_videos_index",$data);
        }
    }

    public function UGCVideosApproval($id)
    {
        $video = UGCVideo::findOrFail($id);
        $video->status = 1;
        $video->active = 1;
        $video->draft = 1;
        $video->save();

        $settings = Setting::first();
        $user_id = $video->user_id;
        $UGCUser = User::findOrFail($user_id);
    //     try {
         
    //         \Mail::send('emails.ugc_video_approved', array(
    //             'website_name' => $settings->website_name,
    //             'UGCUser' => $UGCUser
    //         ) , function ($message) use ($UGCUser)
    //         {
    //             $message->from(AdminMail() , GetWebsiteName());
    //             $message->to($UGCUser->email, $UGCUser->username)
    //                 ->subject('Content has been Submitted for Approved By Admin');
    //         });
            
    //         $email_log      = 'Mail Sent Successfully Approved Content';
    //         $email_template = "Approved";
    //         $user_id = $user_id;

    //         Email_sent_log($user_id,$email_log,$email_template);
    //         Log::info("approved");

    //    } catch (\Throwable $th) {

    //         $email_log      = $th->getMessage();
    //         $email_template = "Approved";
    //         $user_id = $user_id;

    //         Email_notsent_log($user_id,$email_log,$email_template);
    //    }
       
        return Redirect::back()->with(
            "message",
            "Your video will be available shortly after we process it"
        );
    }

    public function UGCVideosReject($id)
    {
        $video = UGCVideo::findOrFail($id);
        $video->active = 2;
        $video->save();

        $settings = Setting::first();
        $user_id = $video->user_id;
        $UGCUser = User::findOrFail($user_id);
    //     try {
    //         \Mail::send('emails.ugc_video_approved', array(
    //             'website_name' => $settings->website_name,
    //             'UGCUser' => $UGCUser
    //         ) , function ($message) use ($UGCUser)
    //         {
    //             $message->from(AdminMail() , GetWebsiteName());
    //             $message->to($UGCUser->email, $UGCUser->username)
    //                 ->subject('Content has been Submitted for Rejected By Admin');
    //         });
            
    //         $email_log      = 'Mail Sent Successfully Rejected Content';
    //         $email_template = "Rejected";
    //         $user_id = $user_id;

    //         Email_sent_log($user_id,$email_log,$email_template);
    //         Log::info("rejected");

    //    } catch (\Throwable $th) {

    //         $email_log      = $th->getMessage();
    //         $email_template = "Rejected";
    //         $user_id = $user_id;

    //         Email_notsent_log($user_id,$email_log,$email_template);
    //    }


        return Redirect::back()->with(
            "message",
            "Your video will be available shortly after we process it"
        );
    }

    public function ugc_watchlater(Request $request)
    {
        try {
            
            $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();

            $inputs = [
                'ugc_video_id' => $request->video_id,
                'type' => 'User Genrated Content',
                'user_id' => !Auth::guest() ? Auth::user()->id : null,
                'users_ip_address' => Auth::guest() ? $geoip->getIP() : null,
            ];

            $watchlater_exist = Watchlater::where('ugc_video_id', $request->video_id)->where('type', 'User Genrated Content')
            ->where(function ($query) use ($geoip) {
                if (!Auth::guest()) {
                    $query->where('user_id', Auth::user()->id);
                } else {
                    $query->where('users_ip_address', $geoip->getIP());
                }
            })->first();

        
            !is_null($watchlater_exist) ? $watchlater_exist->delete() : Watchlater::create( $inputs ) ;

            $response = array(
                'status'=> true,
                'watchlater_status' => is_null($watchlater_exist) ? "Add" : "Remove "  ,
                'message'=> is_null($watchlater_exist) ? "This video was successfully added to Watchlater's list" : "This video was successfully remove from Watchlater's list"  ,
            );

        } catch (\Throwable $th) {

            $response = array(
                'status'=> false,
                'message'=> $th->getMessage(),
              );
        }

        return response()->json(['data' => $response]); 
    }

    public function ugc_wishlist(Request $request)
    {
        try {
            
            $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();

            $inputs = [
                'ugc_video_id' => $request->video_id,
                'type' => 'User Genrated Content',
                'user_id' => !Auth::guest() ? Auth::user()->id : null,
                'users_ip_address' => Auth::guest() ? $geoip->getIP() : null,
            ];

            $wishlist_exist = Wishlist::where('ugc_video_id', $request->video_id)->where('type', 'User Genrated Content')
                                        ->where(function ($query) use ($geoip) {
                                            if (!Auth::guest()) {
                                                $query->where('user_id', Auth::user()->id);
                                            } else {
                                                $query->where('users_ip_address', $geoip->getIP());
                                            }
                                        })->first();

        
            !is_null($wishlist_exist) ? $wishlist_exist->delete() : Wishlist::create( $inputs ) ;

            $response = array(
                'status'=> true,
                'wishlist_status' => is_null($wishlist_exist) ? "Add" : "Remove "  ,
                'message'=> is_null($wishlist_exist) ? "This video was successfully added to wishlist's list" : "This video was successfully remove from wishlist's list"  ,
            );

        } catch (\Throwable $th) {

            $response = array(
                'status'=> false,
                'message'=> $th->getMessage(),
              );
        }

        return response()->json(['data' => $response]); 
    }

    public function ugc_like(Request $request)
    {
        try {
            
            $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();

            $inputs = [
                'ugc_video_id' => $request->video_id,
                'user_id' => !Auth::guest() ? Auth::user()->id : null,
                'users_ip_address' => Auth::guest() ? $geoip->getIP() : null,
                'disliked'   => 0 ,
            ];

            $check_Like_exist = LikeDislike::where('ugc_video_id', $request->video_id)->where('liked',1)
                                        ->where(function ($query) use ($geoip) {
                                            if (!Auth::guest()) {
                                                $query->where('user_id', Auth::user()->id);
                                            } else {
                                                $query->where('users_ip_address', $geoip->getIP());
                                            }
                                        })->first();

            $inputs += [ 'liked'  => is_null($check_Like_exist) ? 1 : 0 , ];

            
            $Like_exist = LikeDislike::where('ugc_video_id', $request->video_id)
                                        ->where(function ($query) use ($geoip) {
                                            if (!Auth::guest()) {
                                                $query->where('user_id', Auth::user()->id);
                                            } else {
                                                $query->where('users_ip_address', $geoip->getIP());
                                            }
                                        })->first();

            !is_null($Like_exist) ? $Like_exist->find($Like_exist->id)->update($inputs) : LikeDislike::create( $inputs ) ;

            $response = array(
                'status'=> true,
                'like_status' => is_null($check_Like_exist) ? "Add" : "Remove "  ,
                'message'=> is_null($check_Like_exist) ? "You liked this video." : "You removed from liked this video."  ,
            );

        } catch (\Throwable $th) {

            $response = array(
                'status'=> false,
                'message'=> $th->getMessage(),
              );
        }

        return response()->json(['data' => $response]); 
    }

    public function ugc_dislike(Request $request)
    {
        try {
            
            $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();

            $inputs = [
                'ugc_video_id' => $request->video_id,
                'user_id' => !Auth::guest() ? Auth::user()->id : null,
                'users_ip_address' => Auth::guest() ? $geoip->getIP() : null,
                'liked'      => 0 ,
            ];

            $check_dislike_exist = LikeDislike::where('ugc_video_id', $request->video_id)->where('disliked',1)
                                        ->where(function ($query) use ($geoip) {
                                            if (!Auth::guest()) {
                                                $query->where('user_id', Auth::user()->id);
                                            } else {
                                                $query->where('users_ip_address', $geoip->getIP());
                                            }
                                        })->first();

            $inputs += [ 'disliked'  => is_null($check_dislike_exist) ? 1 : 0 , ];


            $dislike_exists = LikeDislike::where('ugc_video_id', $request->video_id)
                                        ->where(function ($query) use ($geoip) {
                                            if (!Auth::guest()) {
                                                $query->where('user_id', Auth::user()->id);
                                            } else {
                                                $query->where('users_ip_address', $geoip->getIP());
                                            }
                                        })->first();

        
            !is_null($dislike_exists) ? $dislike_exists->find($dislike_exists->id)->update($inputs) : LikeDislike::create( $inputs ) ;

            $response = array(
                'status'=> true,
                'dislike_status' => is_null($check_dislike_exist) ? "Add" : "Remove "  ,
                'message'=> is_null($check_dislike_exist) ? "You disliked this video" : "You removed from disliked this video."  ,
            );

        } catch (\Throwable $th) {

            $response = array(
                'status'=> false,
                'message'=> $th->getMessage(),
              );
        }

        return response()->json(['data' => $response]); 
    }

    public function ugc_subscribe()
    {
        $user = Auth::user();
        $user->subscribed = !$user->subscribed;
        $user->save();

        return response()->json(['subscribed' => $user->subscribed]);
    }


    public function handleViewCount_ugc($vid)
    {
        $ugcview = UGCVideo::find($vid);
    
        if (!$ugcview) {
            return null;
        }
    
        $ugcview->views = $ugcview->views + 1;
        $ugcview->save();
    
        Session::put('viewed_ugc_videos.' . $vid, time());
    
        return $ugcview;
    }


    private function handleViewCounts($ugcvideos)
    {
        $updatedVideos = [];
    
        foreach ($ugcvideos as $ugcvideo) {
            $updatedVideo = $this->handleViewCount_ugc($ugcvideo->id);
            if ($updatedVideo) {
                $updatedVideos[] = $updatedVideo;
            }
        }
    
        return $updatedVideos;
    }



    public function showugcprofile($username)
    {
        $user = User::where('username', $username)->withCount('subscribers')->firstOrFail();

        $ugcvideos = UGCVideo::where('user_id', $user->id)
            ->withCount([
            'likesDislikes as like_count' => function($query) {
                $query->where('liked', 1);
            }
            ])
            ->where('active', 1)
            ->orderBy('created_at', 'DESC')
            ->paginate(9);

        // $user_data = User::withCount('subscribers')->find($profileUser->id);
        
        $viewcount = $this->handleViewCounts($ugcvideos);
        $ugc_total = $user->ugcVideos();
        $totalViews = $ugc_total->sum('views');
        $totalVideos = $ugc_total->where('active',1)->count();
        $data = [
            'user' => $user,
            'ugcvideos' => $ugcvideos,
            'viewcount' => $viewcount,
            'totalViews' => $totalViews,
            'totalVideos' => $totalVideos,
        ];

        return Theme::view("UserGeneratedContent.showugcprofile", $data );
    }
    
    public function PlayUGCVideos( Request $request, $slug )
    {
        try {

            $setting = Setting::first();
            $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
            $video = UGCVideo::where('slug', $slug)->latest()->firstOrFail();
            $video_id = $video->id;
            $profileUser = User::find($video->user_id);
            $subtitle = MoviesSubtitles::where('movie_id', '=', $video_id)->get();
            $videodetail = UGCVideo::where('id',$video_id)->latest()
                                    ->get()->map(function ($item) use ( $video_id , $setting ,  $geoip )  {

                $item['users_video_visibility_status']         = true ;
                $item['users_video_visibility_redirect_url']   = route('play_ugc_videos',[ optional($item)->slug ]); 
        
                $item['image_url']        = $item->image ? URL::to('public/uploads/images/'.$item->image ) : default_vertical_image_url();
                $item['player_image_url'] = $item->player_image ?  URL::to('public/uploads/images/'.$item->player_image) : default_horizontal_image_url() ;
                $item['pdf_files_url']      = URL::to('public/uploads/videoPdf/'.$item->pdf_files) ;
                $item['transcoded_url']     = URL::to('/storage/app/public/').'/'.$item->path . '.m3u8';

                $item['video_skip_intro_seconds']        = $item->skip_intro  ? Carbon::parse($item->skip_intro)->secondsSinceMidnight() : null ;
                $item['video_intro_start_time_seconds']  = $item->intro_start_time ? Carbon::parse($item->intro_start_time)->secondsSinceMidnight() : null ;
                $item['video_intro_end_time_seconds']    = $item->intro_end_time ? Carbon::parse($item->intro_end_time)->secondsSinceMidnight() : null ;

                $item['video_skip_recap_seconds']        = $item->skip_recap ? Carbon::parse($item->skip_recap)->secondsSinceMidnight() : null ;
                $item['video_recap_start_time_seconds']  = $item->recap_start_time ? Carbon::parse($item->recap_start_time)->secondsSinceMidnight() : null ;
                $item['video_recap_end_time_seconds']    = $item->recap_end_time ? Carbon::parse($item->recap_end_time)->secondsSinceMidnight() : null ;
                
                $item['view_increment'] = $this->handleViewCount_ugc($video_id);
                // Videos URL 
                                        
                if ($item['users_video_visibility_status'] == true ) {

                    switch (true) {

                        case $item['type'] == "mp4_url":
                        $item['videos_url'] =  $item->mp4_url ;
                        $item['video_player_type'] =  'video/mp4' ;
                        break;

                        case $item['type'] == "m3u8_url":
                        $item['videos_url'] =  $item->m3u8_url ;
                        $item['video_player_type'] =  'application/x-mpegURL' ;
                        break;

                        case $item['type'] == "embed":
                        $item['videos_url'] =  $item->embed_code ;
                        break;
                        
                        case $item['type'] == null &&  pathinfo($item['mp4_url'], PATHINFO_EXTENSION) == "mp4" :
                        $item['videos_url']   = URL::to('/storage/app/public/'.$item->path.'.m3u8');
                        $item['video_player_type'] =  'application/x-mpegURL' ;
                        break;
                        
                        case $item['type'] == null &&  pathinfo($item['mp4_url'], PATHINFO_EXTENSION) == "mov" :
                        $item['videos_url']   = $item->mp4_url ;
                        $item['video_player_type'] =  'video/mp4' ;
                        break;

                        case $item['type'] == " " && !is_null($item->transcoded_url) :
                        $item['videos_url']   = $item->transcoded_url ;
                        $item['video_player_type'] =  'application/x-mpegURL' ;
                        break;
                        
                        case $item['type'] == null :
                        $item['videos_url']   = URL::to('/storage/app/public/'.$item->path.'.m3u8' ) ;
                        $item['video_player_type'] =  'application/x-mpegURL' ;
                        break;

                        default:
                        $item['videos_url']    = null ;
                        $item['video_player_type'] = null ;
                        break;
                    }
                } else {
                    $item['videos_url']    = null ;
                    $item['video_player_type'] = null ;
                }


                $item['watchlater_exist'] = Watchlater::where('ugc_video_id', $video_id)->where('type', 'User Generated Content')
                                                ->where(function ($query) use ($geoip) {
                                                    if (!Auth::guest()) {
                                                        $query->where('user_id', Auth::user()->id);
                                                    } else {
                                                        $query->where('users_ip_address', $geoip->getIP());
                                                    }
                                                })->first();


                 $item['wishlist_exist'] = Wishlist::where('ugc_video_id', $video_id)->where('type', 'User Generated Content')
                                                ->where(function ($query) use ($geoip) {
                                                    if (!Auth::guest()) {
                                                        $query->where('user_id', Auth::user()->id);
                                                    } else {
                                                        $query->where('users_ip_address', $geoip->getIP());
                                                    }
                                                })->first();

                $item['Like_exist'] = LikeDislike::where('ugc_video_id', $video_id)->where('liked',1)
                                                ->where(function ($query) use ($geoip) {
                                                    if (!Auth::guest()) {
                                                        $query->where('user_id', Auth::user()->id);
                                                    } else {
                                                        $query->where('users_ip_address', $geoip->getIP());
                                                    }
                                                })->latest()->first();

                $item['dislike_exist'] = LikeDislike::where('ugc_video_id', $video_id)->where('disliked',1)
                                                ->where(function ($query) use ($geoip) {
                                                    if (!Auth::guest()) {
                                                        $query->where('user_id', Auth::user()->id);
                                                    } else {
                                                        $query->where('users_ip_address', $geoip->getIP());
                                                    }
                                                })->latest()->first();

                $item['like_count'] = LikeDislike::where('ugc_video_id', $video_id)->where('liked', 1)->count();
                $item['dislike_count'] = LikeDislike::where('ugc_video_id', $video_id)->where('disliked', 1)->count();

                return $item;
            })->first();

            $user_id = Auth::user()->id;

            $user_data = User::withCount('subscribers')->find($profileUser->id);

            $user_details = User::find($user_id);

            $ugcvideo = UGCVideo::where('active', 1)
                ->withCount([
                    'likesDislikes as like_count' => function($query) {
                        $query->where('liked', 1);
                    }
                    ])->inRandomOrder()->get(); 
    
            $subscribe_button = UGCSubscriber::where('user_id', $profileUser->id)
                            ->where('subscriber_id', auth()->user()->id)
                            ->exists();

            $newvideo = UGCVideo::where('active', 1)->orderBy('created_at', 'DESC')->first(); 
            $currentVideo = UGCVideo::where('slug', $slug)->first();
            $keywords = explode(' ', $currentVideo->description);
            $relatedVideos = UGCVideo::where('id', '!=', $currentVideo->id) 
                             ->where(function($query) use ($keywords) {
                                foreach ($keywords as $word) {
                                    $query->orWhere('description', 'LIKE', '%' . $word . '%');
                                }
                             })
                             ->inRandomOrder()
                             ->limit(5)
                             ->get();

            $trendingVideos = UGCVideo::where('id', '!=', $currentVideo->id)->orderBy('views', 'DESC')->limit(5)->get();


            $data = array(
                'user' => $user_details,
                'ugcvideos' => $ugcvideo,
                'newvideo' => $newvideo,
                'currentVideo' => $currentVideo,
                'relatedVideos' => $relatedVideos,
                'trendingVideos' => $trendingVideos,
                'subtitles' => $subtitle ,
                'videodetail' => $videodetail ,
                'profileUser' =>  $profileUser,
                'subscribe_button' => $subscribe_button,
                'subscriber_count' => $user_data->subscribers_count ?? 0,
                'CommentSection' => CommentSection::first(),
                'source_id'      => $videodetail->id ,
                'commentable_type' => 'play_ugc_videos',
                'play_btn_svg'  => '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="80px" height="80px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                                        <polygon class="triangle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="73.5,62.5 148.5,105.8 73.5,149.1 " style="stroke: white !important;"></polygon>
                                        <circle class="circle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" style="stroke: white !important;"></circle>
                                    </svg>',
            );


            return Theme::view("UserGeneratedContent.videos", $data);

        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    
    public function subscribe(Request $request)
    {
        try {
            $user = User::find($request->user_id);
            $subscriber = User::find($request->subscriber_id);

            $exists = UGCSubscriber::where('user_id', $user->id)
                ->where('subscriber_id', $subscriber->id)
                ->exists();

            if (!$exists) {
                UGCSubscriber::create([
                    'user_id' => $user->id,
                    'subscriber_id' => $subscriber->id,
                ]);
            }

            $subscriberCount = UGCSubscriber::where('user_id', $user->id)->count();

            return response()->json([
                'success' => true,
                'count' => $subscriberCount
            ]);

        } catch (QueryException $e) {
            return response()->json(['error' => 'Database error occurred.'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred.'], 500);
        }
    }

    public function unsubscribe(Request $request)
    {
        try {
            $user = User::find($request->user_id);
            $subscriber = User::find($request->subscriber_id);


            $exists = UGCSubscriber::where('user_id', $user->id)
                ->where('subscriber_id', $subscriber->id)
                ->exists();

            if ($exists) {
                $deleted = UGCSubscriber::where('user_id', $user->id)
                    ->where('subscriber_id', $subscriber->id)
                    ->delete();
            }

            $subscriberCount = UGCSubscriber::where('user_id', $user->id)->count();

            if ($deleted) {
                return response()->json([
                    'success' => true,
                    'count' => $subscriberCount
                ]);
            }

            return response()->json(['error' => 'Subscription not found'], 404);

        } catch (QueryException $e) {
            return response()->json(['error' => 'Database error occurred.'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred.'], 500);
        }
    }
    

    public function viewallprofile(){

        $user_data = User::whereHas('ugcVideos', function ($query) {
            $query->where('active', true);
        })
        ->withCount('subscribers')
        ->get();
        $data = [
            'userdata' => $user_data,
        ];

        return Theme::view("UserGeneratedContent.viewallprofile", $data);
    }


    public function uploadFile(Request $request)
    {
            $site_theme = SiteTheme::first();
           
            $today = Carbon::now() ;
            
            // Video Upload Limit
    
            $videos_uplaod_limit = UGCVideo::where('user_id', Auth::user()->id )
                                        ->whereYear('created_at',  $today->year)
                                        ->whereMonth('created_at', $today->month)
                                        ->count();


            if ( $site_theme->admin_videoupload_limit_status == 1 && $videos_uplaod_limit >= $site_theme->admin_videoupload_limit_count) {
                return response()->json( ["success" => 'video_upload_limit_exist'],200);
            }
            
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
            $client = new Client();
    
            $storage_settings = StorageSetting::first();
            if ($mp4_url != "" && $pack != "Business") {
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
                if( $Video_duration < 180 ){
                $video = new UGCVideo();
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
                }
                else{
                return response()->json( ["success" => 'ugc_video_duration'],200);
                }
            
                $video_id = $video->id;
                $video_title = UGCVideo::find($video_id);
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
                    if( $Video_duration < 180 ){
                    $video = new UGCVideo();
                    $video->disk = "public";
                    $video->status = 0;
                    $video->original_name = "public";
                    $video->path = $path;
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
                    }
                    else{
                    return response()->json( ["success" => 'ugc_video_duration'],200);
                    }

                ConvertUGCVideoForStreaming::dispatch($video);
                    
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
                            $VideoExtractedImage->socure_type = 'UGC Video';
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
                    $video_title = UGCVideo::find($video_id);
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
                            'error' => $e->getMessage(),
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
                if( $Video_duration < 180 ){
                $video = new UGCVideo();
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
                }
                else{
                return response()->json( ["success" => 'ugc_video_duration'],200);
                }

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
                    
                    for ($i = 1; $i <= 5; $i++) {
                        
                        $imagePortraitPath = public_path("uploads/images/{$video->id}_{$randportrait}_{$i}.jpg");
                        $imagePath = public_path("uploads/images/{$video->id}_{$rand}_{$i}.jpg");
    
                        
                        try {
                            $videoFrame
                                ->frame(TimeCode::fromSeconds($i * 5))
                                ->save($imagePath, new X264('libmp3lame', 'libx264'), null, new Dimension($frameWidth, $frameHeight));
                    
                            $videoFrame
                                ->frame(TimeCode::fromSeconds($i * 5))
                                ->save($imagePortraitPath, new X264('libmp3lame', 'libx264'), null, new Dimension($frameWidthPortrait, $frameHeightPortrait));
                    
                            $VideoExtractedImage = new VideoExtractedImages();
                            $VideoExtractedImage->user_id = Auth::user()->id;
                            $VideoExtractedImage->socure_type = 'UGC Video';
                            $VideoExtractedImage->video_id = $video->id;
                            $VideoExtractedImage->image_path = URL::to("/public/uploads/images/" . $video->id . '_' . $rand . '_' . $i . '.jpg');
                            $VideoExtractedImage->portrait_image = URL::to("/public/uploads/images/" . $video->id . '_' . $randportrait . '_' . $i . '.jpg');
                            $VideoExtractedImage->image_original_name = $video->id . '_' . $rand . '_' . $i . '.jpg';
                            $VideoExtractedImage->save();
                 
                    
                            } catch (\Exception $e) {
                                dd($e->getMessage());
                            }
                        }
                    }
    
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
                            $VideoExtractedImage->socure_type = 'UGC Video';
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
                $video_title = UGCVideo::find($video_id);
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
                    if($StorageSetting->site_storage == 1){
                        $dropzone_url =  URL::to('ugc/uploadFile');
                    }else{
                        $dropzone_url =  URL::to('ugc/uploadFile');
                    }
                    $storage_settings = StorageSetting::first();
    
                    $theme_settings = SiteTheme::first();
    
                $data = [
                    "headline" => '<i class="fa fa-plus-circle"></i> New Video',
                    "post_route" => URL::to("ugc/fileupdate"),
                    "button_text" => "Add New Video",
                    "admin_user" => Auth::user(),
                    "related_videos" => UGCVideo::get(),
                    "subtitles" => Subtitle::all(),
                    "settings" => $settings,
                    "page" => "Creates",
                    "post_dropzone_url" => $dropzone_url,
                    'storage_settings' => $storage_settings ,
                    'theme_settings' => $theme_settings ,
                ];
    
                return Theme::view("UserGeneratedContent.ugc-create", $data);
            }
    }

    public function ugcfileupdate(Request $request)
    {
        if (!Auth::user()->role == 'admin') {
            return redirect('/home');
        }

    
        $user_package = User::where('id', 1)->first();
        $data = $request->all();

        $validatedData = $request->validate([
            'title' => 'required|max:255',
        ]);
        
        $id = $data['video_id'];
        $video = UGCVideo::findOrFail($id);

        if (!empty($video->embed_code)) {
            $embed_code = $video->embed_code;
        } else {
            $embed_code = '';
        }

        if ($request->slug == '') {
            $data['slug'] = $this->createSlug($data['title']);
        } else {
            $data['slug'] = $this->createSlug($data['slug']);
        }

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

        $path = public_path() . '/uploads/videos/';
        $image_path = public_path() . '/uploads/images/';

        if (!empty($data['embed_code'])) {
            $video->embed_code = $data['embed_code'];
        } else {
            $video->embed_code = '';
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
                    
                    // $responsive_image = $image_filename;

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
            // $responsive_image = null;
            $responsive_player_image = null;
            $responsive_tv_image = null;
        }


        $video->description = $data['description'];
        $shortcodes = $request['short_code'];
        $languages = $request['sub_language'];
        $video->uploaded_by = Auth::user()->role;
        $video->draft = 1;
        $video->active = 1;
        // $video->enable = 1;
       
        $video->update($data);

        $video = UGCVideo::findOrFail($id);


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

        \LogActivity::addVideoUpdateLog('Update Meta Data for Video.', $video->id);

        return Redirect::back()->with('message', 'Your video will be available shortly after we process it');
    }   
    
        public function destroy($id)
        {
            try {
            
                $videos = UGCVideo::find($id);
    
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
               
                        //  Delete Existing Video Title Image
                if (File::exists(base_path('public/uploads/images/'.$videos->video_title_image))) {
                    File::delete(base_path('public/uploads/images/'.$videos->video_title_image));
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
    
    
                // Video Destroy
                \LogActivity::addVideodeleteLog("Deleted Video.", $id);
    
                UGCVideo::destroy($id);
    
                return Redirect::to("myprofile")->with([
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
                $video = UGCVideo::find($id);
                $compress_image_settings = CompressImage::first();
                $MoviesSubtitles = MoviesSubtitles::where('movie_id', $id)->get();

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

    
                $data = [
                    "headline" => '<i class="fa fa-edit"></i> Edit Video',
                    "page"     => "Edit",
                    "video"    => $video,
                    "post_route"  => URL::to("ugc/update"),
                    "button_text" => "Update Video",
                    "admin_user"  => Auth::user(),
                    "MoviesSubtitles" => $MoviesSubtitles ,
                    "subtitlescount" => $subtitlescount,
                    "subtitles" => Subtitle::all(),
                    "settings" => $settings,
                    'compress_image_settings' => $compress_image_settings,
                ];
    
                return Theme::view("UserGeneratedContent.ugc-edit", $data);
                
            } catch (\Throwable $th) {
                return abort(404);  
            }

        }

        public function editvideo($id)
        {
    
            if (!Auth::user()->role == "admin") {
                return redirect("/home");
            }
            $settings = Setting::first();
    
            $video = UGCVideo::find($id);
                $StorageSetting = StorageSetting::first();
                if($StorageSetting->site_storage == 1){
                    $dropzone_url =  URL::to('ugc/uploadEditUGCVideo');
                }else{
                    $dropzone_url =  URL::to('ugc/uploadEditUGCVideo');
                }
                
            $data = [
                "headline" => '<i class="fa fa-edit"></i> Edit Video',
                "video" => $video,
                "post_route" => URL::to("ugc/update"),
                "button_text" => "Update Video",
                "admin_user" => Auth::user(),
                "settings" => $settings,
                "page" => "Edit",
                "dropzone_url" => $dropzone_url,
    
            ];
            return Theme::view("UserGeneratedContent.ugc-editvideo", $data);
        }

        public function uploadEditUGCVideo(Request $request)
        {
            $value = [];
            $data = $request->all();
            $id = $data["videoid"];
            $video = UGCVideo::findOrFail($id);
            $validator = Validator::make($request->all(), [
                "file" => "required|mimes:video/mp4,video/x-m4v,video/*",
            ]);
            $mp4_url = isset($data["file"]) ? $data["file"] : "";
    
            $path = public_path() . "/uploads/videos/";
    
            $file = $request->file->getClientOriginalName();
            // $newfile = explode(".mp4", $file);
            // $file_folder_name = $newfile[0];
    
            $package = User::where("id", 1)->first();
            $pack = $package->package;
            $mp4_url = $data["file"];
            $settings = Setting::first();
    
            if (
                $mp4_url != "" &&
                $pack != "Business" &&
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

               
                $video->disk = "public";
                $video->original_name = "public";
                $video->path = $path;
                $video->mp4_url = $storepath;
                $video->type = "mp4_url";
                $video->duration = $Video_duration;
                $video->save();
              
                $video_id = $video->id;
    
                $value["success"] = 1;
                $value["message"] = "Uploaded Successfully!";
                $value["video_id"] = $video_id;
    
                // return $value;
                return Redirect::back();
    
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
    
                $video->disk = "public";
                $video->status = 0;
                $video->original_name = "public";
                $video->path = $path;
                $video->mp4_url = $storepath;
                $video->type = "";
                $video->duration = $Video_duration;
                $video->user_id = Auth::user()->id;
                $video->save();
                ConvertUGCVideoForStreaming::dispatch($video);
                $video_id = $video->id;
             
                $value["success"] = 1;
                $value["message"] = "Uploaded Successfully!";
                $value["video_id"] = $video_id;
      
                return $value;
    
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
    
                // $video = new UGCVideo();
                $video->disk = "public";
                // $video->title = $file_folder_name;
                $video->original_name = "public";
                $video->path = $path;
                $video->mp4_url = $storepath;
                $video->type = "mp4_url";
                $video->duration = $Video_duration;
                $video->save();

                $video_id = $video->id;
                $value["success"] = 1;
                $value["message"] = "Uploaded Successfully!";
                $value["video_id"] = $video_id;
                return $value;
            } else {
                $value["success"] = 2;
                $value["message"] = "File not uploaded.";
                return response()->json($value);
            }
    
        }
        
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
    
            $video = UGCVideo::findOrFail($id);
            if ($request->slug == "") {
                $data["slug"] = $this->createSlug($data["title"]);
            } else {
                $data["slug"] = str_replace(" ", "-", $request->slug);
            }
    
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
              
            }else if (!empty($request->video_image_url)) {
                $data["image"] = $request->video_image_url;
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
    
            }else if (!empty($request->selected_image_url)) {
                $players_image = $request->selected_image_url;
            } else {
                $players_image = $video->player_image;
            }
            
           
    
            if (isset($data["duration"])) {
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
                ConvertUGCVideoForStreaming::dispatch($video);
            }
    
            if (!empty($data["embed_code"])) {
                $video->embed_code = $data["embed_code"];
            } else {
                $video->embed_code = "";
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
    
            if (isset($request->free_duration)) {
                $time_seconds = Carbon::createFromFormat('H:i:s', $request->free_duration)->diffInSeconds(Carbon::createFromTime(0, 0, 0));
                $video->free_duration = $time_seconds;
            }
    
            $video->mp4_url = $data["mp4_url"];
            $video->uploaded_by = $uploaded_by;
            $video->player_image = $players_image;
            $video->m3u8_url = $m3u8_url;
            $video->mp4_url = $mp4_url;
            $video->embed_code = $embed_code;
            $video->active = $active;
            $video->status = $status;
            $video->draft = $draft;
            $video->description = $data["description"];
            $video->search_tags = $searchtags;
            $video->save();
    
            $shortcodes = $request["short_code"];
            $languages = $request["sub_language"];
    
            if (!empty($files != "" && $files != null)) {
                foreach ($files as $key => $val) {
                    if (!empty($files[$key])) {
                        $destinationPath = "public/uploads/subtitles/";
                        $filename = $video->id . "-" . $shortcodes[$key] . ".srt";
                        $files[$key]->move($destinationPath, $filename);
                        $subtitle_data["sub_language"] =
                            $languages[
                                $key
                            ]; 
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
                // Define the convertTimeFormat function globally
                function convertTimeFormat($hours, $minutes, $milliseconds) {
                    $totalSeconds = $hours * 3600 + $minutes * 60 + $milliseconds / 1000;
                    $formattedTime = gmdate("H:i:s", $totalSeconds);
                    $formattedMilliseconds = str_pad($milliseconds, 3, '0', STR_PAD_LEFT);
                    return "{$formattedTime},{$formattedMilliseconds}";
                }

    
            \LogActivity::addVideoUpdateLog("Update Video.", $video->id);

            return Redirect::to("ugc-edit" . "/" . $id)->with([
                "message" => "Successfully Updated Video!",
                "note_type" => "success",
            ]);
        }

    
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
            return UGCVideo::select("slug")
                ->where("slug", "like", $slug . "%")
                ->where("id", "<>", $id)
                ->get();
        }
    
        public function Mp4url(Request $request)
        {
            $data = $request->all();
            $value = [];
    
            if (!empty($data["mp4_url"])) {
                $video = new UGCVideo();
                $video->disk = "public";
                $video->original_name = "public";
                $video->title = $data["mp4_url"];
                $video->mp4_url = $data["mp4_url"];
                $video->type = "mp4_url";
                $video->draft = 0;
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
                \LogActivity::addVideoLog("Added Mp4 URl Video.", $video_id);
    
                return $value;
            }
        }
        public function m3u8url(Request $request)
        {
            $data = $request->all();
            $value = [];
    
            if (!empty($data["m3u8_url"])) {
                $video = new UGCVideo();
                $video->disk = "public";
                $video->original_name = "public";
                $video->title = $data["m3u8_url"];
                $video->m3u8_url = $data["m3u8_url"];
                $video->type = "m3u8_url";
                $video->draft = 0;
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
    
                \LogActivity::addVideoLog("Added M3U8 URl Video.", $video_id);
    
                return $value;
            }
        }

        public function SubmitUGCAbout(Request $request)
        {

            try {

                $request->validate([
                    'user_id' => 'required|exists:users,id',
                    'ugc_about' => 'nullable|string|max:255', 
                ]);
                
                $user = User::find($request->user_id)->update(['ugc_about' => $request->ugc_about]);
                $response = [
                    'status' => true,
                    'status_code' => 200,
                    'message' => 'About detail detail Updated Successfully!',
                ];

            } catch (\Throwable $th) {

                $response = [
                    'status' => false,
                    'status_code' => 400,
                    'message' => $th->getMessage(),
                ];
            }

            return response()->json($response,$response['status_code']);
        }

        public function SubmitUGCFacebook(Request $request)
        {

            try {
            
                $request->validate([
                    'user_id' => 'required|exists:users,id',
                    'ugc_facebook' => 'nullable|string|max:255', 
                ]);
                
                $user = User::find($request->user_id)->update(['ugc_facebook' => $request->ugc_facebook]);

                $userdata = User::get();

                $response = [
                    'status' => true,
                    'status_code' => 200,
                    'message' => 'Facebook detail Updated Successfully!',
                ];

            } catch (\Throwable $th) {

                $response = [
                    'status' => false,
                    'status_code' => 400,
                    'message' => $th->getMessage(),
                ];
            }

            return response()->json($response,$response['status_code']);
        }

        public function SubmitUGCInstagram(Request $request)
        {

            try {
            
                $request->validate([
                    'user_id' => 'required|exists:users,id',
                    'ugc_instagram' => 'nullable|string|max:255', 
                ]);
                
                $user = User::find($request->user_id)->update(['ugc_instagram' => $request->ugc_instagram]);

                $response = [
                    'status' => true,
                    'status_code' => 200,
                    'message' => 'Instagram detail Updated Successfully!',
                ];

            } catch (\Throwable $th) {

                $response = [
                    'status' => false,
                    'status_code' => 400,
                    'message' => $th->getMessage(),
                ];
            }

            return response()->json($response,$response['status_code']);
        }

        public function SubmitUGCTwitter(Request $request)
        {

            try {
            
                $request->validate([
                    'user_id' => 'required|exists:users,id',
                    'ugc_twitter' => 'nullable|string|max:255', 
                ]);
                
                $user = User::find($request->user_id)->update(['ugc_twitter' => $request->ugc_twitter]);
                $response = [
                    'status' => true,
                    'status_code' => 200,
                    'message' => 'Twitter detail Updated Successfully!',
                ];

            } catch (\Throwable $th) {

                $response = [
                    'status' => false,
                    'status_code' => 400,
                    'message' => $th->getMessage(),
                ];
            }

            return response()->json($response,$response['status_code']);
        }

        public function Embededcode(Request $request)
        {
            $data = $request->all();
            $value = [];
    
    
            if (!empty($data["embed"])) {
                $video = new UGCVideo();
                $video->disk = "public";
                $video->original_name = "public";
                $video->title = $data["embed"];
                $video->embed_code = $data["embed"];
                $video->type = "embed";
                $video->draft = 0;
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
        }
    
    
        public function Updatemp4url(Request $request)
        {
            $value = [];
            $data = $request->all();
    
            $id = $data["videoid"];
            $video = UGCVideo::findOrFail($id);
            if(!empty($video) && $video->mp4_url == $data["mp4_url"]){
                $value["success"] = 1;
                $value["message"] = "Already Exits";
                $value["video_id"] = $id;
    
                return $value;
            }else{
            if (!empty($data["mp4_url"])) {
                $video->disk = "public";
                $video->original_name = "public";
                // $video->title = $data['mp4_url'];
                $video->mp4_url = $data["mp4_url"];
                $video->type = "mp4_url";
                // $video->draft = 0;
                $video->active = 0;
                $video->user_id = Auth::user()->id;
                $video->save();
    
                $video_id = $video->id;
    
                $value["success"] = 1;
                $value["message"] = "URL Updated Successfully!";
                $value["video_id"] = $video_id;
    
                // return $value;
                return Theme::view("UserGeneratedContent.ugc-create");
    
                }
            }
        }

        public function Updatem3u8url(Request $request)
        {
            $data = $request->all();
            $value = [];
    
            $id = $data["videoid"];
    
            $video = UGCVideo::findOrFail($id);
            if(!empty($video) && $video->m3u8_url == $data["m3u8_url"]){
                $value["success"] = 1;
                $value["message"] = "Already Exits";
                $value["video_id"] = $id;
    
                return $value;
            }else{
    
            if (!empty($data["m3u8_url"])) {
                $video = new UGCVideo();
                $video->disk = "public";
                $video->original_name = "public";
                $video->title = $data['m3u8_url'];
                $video->m3u8_url = $data["m3u8_url"];
                $video->type = "m3u8_url";
                // $video->draft = 0;
                $video->active = 0;
                $video->user_id = Auth::user()->id;
                $video->save();
    
                $video_id = $video->id;
    
                $value["success"] = 1;
                $value["message"] = "URL Updated Successfully!";
                $value["video_id"] = $video_id;
                return Theme::view("UserGeneratedContent.ugc-create", $data);
    
            }
        }
    
        }
        public function UpdateEmbededcode(Request $request)
        {
            $data = $request->all();
            $value = [];
    
           
            $id = $data["videoid"];
            $video = UGCVideo::findOrFail($id);
            if(!empty($video) && $video->embed_code == $data["embed"]){
                $value["success"] = 1;
                $value["message"] = "Already Exits";
                $value["video_id"] = $id;
    
                return $value;
            }else{
            if (!empty($data["embed"])) {
                // $video = new UGCVideo();
                $video->disk = "public";
                $video->original_name = "public";
                // $video->title = $data['embed'];
                $video->embed_code = $data["embed"];
                $video->type = "embed";
                $video->draft = 0;
                $video->active = 0;
                $video->user_id = Auth::user()->id;
                $video->save();
    
                $video_id = $video->id;
    
                $value["success"] = 1;
                $value["message"] = "URL Updated Successfully!";
                $value["video_id"] = $video_id;
                
                return Theme::view("UserGeneratedContent.ugc-create", $data);
                }
            }
        }

        public function video_slug_validate(Request $request)
        {
            $video_slug_validate = UGCVideo::where("slug", $request->slug)->count();

            if ($request->type == "create") {
                $validate_status = $video_slug_validate > 0 ? "true" : "false";
            } elseif ($request->type == "edit") {
                $video_slug_count = UGCVideo::where("id", $request->video_id)
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

         
    
        public function ExtractedImage(Request $request)
        {
            try {

                $value = [];

                $ExtractedImage =  VideoExtractedImages::where('ugc_video_id',$request->video_id)->where('socure_type','UGC Video')->get();
           
                $value["success"] = 1;
                $value["message"] = "Uploaded Successfully!";
                $value["video_id"] = $request->video_id;
                $value["ExtractedImage"] = $ExtractedImage;

                return $value;

            } catch (\Throwable $th) {
                throw $th;
            }

        }

    
}
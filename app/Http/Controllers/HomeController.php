<?php
namespace App\Http\Controllers;
use \App\User as User;
use \Redirect as Redirect;
//use Request;
use App\Setting as Setting;
use App\SystemSetting as SystemSetting;
use App\Video as Video;
use App\Slider as Slider;
use App\PpvVideo as PpvVideo;
use App\PpvCategory as PpvCategory;
use App\VerifyNumber as VerifyNumber;
use App\Subscription as Subscription;
use App\PaypalPlan as PaypalPlan;   
use App\ContinueWatching as ContinueWatching;
use App\Genre;
use App\Audio;
use App\Geofencing;
use App\Page as Page;
use App\HomeSetting as HomeSetting;
use App\Movie;
use App\BlockVideo;
use App\Episode;
use App\LikeDislike as Likedislike;
use App\VideoCategory;
use App\Multiprofile;
use URL;
use Auth;
use View;
use Hash;
use Mail;
use Nexmo;
use Crypt;
use Illuminate\Support\Facades\Cache;
//use Image;
use Intervention\Image\ImageManagerStatic as Image;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\Authenticatable;
use Stevebauman\Location\Facades\Location;
use Carbon;
use Session;
use App\LiveStream as LiveStream;
use App\AudioAlbums as AudioAlbums;
use App\UserLogs as UserLogs;
use App\CurrencySetting as CurrencySetting;
use App\SubscriptionPlan as SubscriptionPlan;
use Jenssegers\Agent\Agent;
use App\LoggedDevice;
use App\ApprovalMailDevice;
use Victorybiz\GeoIPLocation\GeoIPLocation;
use App\RecentView;
use App\ChooseProfileScene;
use App\ThumbnailSetting;
use App\SiteTheme;
use Theme;
use App\Series;
use App\Artist;
use App\Helpers\LogActivity;
use App\AdminLandingPage;
use App\EmailTemplate;
use App\VideoSchedules as VideoSchedules;
use App\ScheduleVideos as ScheduleVideos;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $construct_name;

    public function __construct()
    {
        //$this->middleware('auth');
        $settings = Setting::first();
        $this->videos_per_page = $settings->videos_per_page;

        $this->Theme = HomeSetting::pluck('theme_choosen')
            ->first();
        Theme::uses($this->Theme);
    }

    public function FirstLangingold()
    {
        //  echo "<pre>";print_r('$cnt_watching');exit();
        // return View::make('first_landing');
        $data = Session::all();
        $agent = new Agent();

        // $session_password = $data['password_hash'];
        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
        $userIp = $geoip->getip();
        $system_settings = SystemSetting::first();
        $user = User::where('id', '=', 1)->first();
        if (Auth::guest())
        {
            return view('auth.login', compact('system_settings', 'user'));
            // return View::make('auth.login', $data);
            
        }
        else
        {
            $user_check = LoggedDevice::where('user_id', '=', Auth::User()->id)
                ->count();
            $alldevices = LoggedDevice::where('user_id', '=', Auth::User()->id)
                ->get();
            if ($user_check >= 4)
            {
                return view('device_logged', compact('alldevices', 'system_settings', 'user'));
            }
            else
            {
                $device_name = '';
                if ($agent->isDesktop())
                {
                    $device_name = 'desktop';
                }
                elseif ($agent->isTablet())
                {
                    $device_name = 'tablet';
                }
                elseif ($agent->isMobile())
                {
                    $device_name = 'mobile';
                }
                elseif ($agent->isMobile())
                {
                    $device_name = 'mobile';
                }
                else
                {
                    $device_name = 'tv';
                }
                if (!empty($device_name))
                {
                    $devices_check = LoggedDevice::where('user_id', '=', Auth::User()->id)
                        ->where('device_name', '=', $device_name)->first();
                    if (empty($devices_check))
                    {
                        // dd($devices_check);
                        $adddevice = new LoggedDevice;
                        $adddevice->user_id = Auth::User()->id;
                        $adddevice->user_ip = $userIp;
                        $adddevice->device_name = $device_name;
                        $adddevice->save();
                    }
                }
                $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
                $settings = Setting::first();

                $genre = Genre::all();
                $genre_video_display = VideoCategory::all();

                $trending_videos = Video::where('active', '=', '1')->where('status', '=', '1')
                    ->where('draft', '=', '1')
                    ->where('views', '>', '5')
                    ->orderBy('created_at', 'DESC')
                    ->get();
                $latest_videos = Video::where('status', '=', '1')->take(10)
                ->where('active', '=', '1')
                ->where('draft', '=', '1')
                    ->orderBy('created_at', 'DESC')
                    ->get();
                $suggested_videos = Video::where('active', '=', '1')->where('views', '>', '5')
                ->where('status', '=', '1')
                ->where('draft', '=', '1')
                    ->orderBy('created_at', 'DESC')
                    ->get();
                $trending_movies = Movie::where('active', '=', '1')->where('status', '=', '1')
                    ->where('views', '>', '5')
                    ->orderBy('created_at', 'DESC')
                    ->get();
                $ppv_movies = PpvVideo::where('active', '=', '1')->where('status', '=', '1')
                    ->orderBy('created_at', 'DESC')
                    ->get();
                $latest_movies = Movie::where('active', '=', '1')->where('status', '=', '1')
                    ->take(10)
                    ->orderBy('created_at', 'DESC')
                    ->get();
                $trending_audios = Audio::where('active', '=', '1')->where('status', '=', '1')
                    ->where('views', '>', '5')
                    ->orderBy('created_at', 'DESC')
                    ->get();
                $latest_audios = Audio::where('active', '=', '1')->where('status', '=', '1')
                    ->take(10)
                    ->orderBy('created_at', 'DESC')
                    ->get();
                $trending_episodes = Episode::where('active', '=', '1')->where('views', '>', '0')
                    ->orderBy('id', 'DESC')
                    ->get();
                $trendings = new \Illuminate\Database\Eloquent\Collection; //Create empty collection which we know has the merge() method
                $trendings = $trendings->merge($trending_videos);
                $trendings = $trendings->merge($trending_movies);
                $trendings = $trendings->merge($trending_episodes);
                $featured_videos = Video::where('active', '=', '1')->where('featured', '=', '1')
                ->where('status', '=', '1')
                ->where('draft', '=', '1')
                    ->orderBy('created_at', 'DESC')
                    ->get();
                $featured_episodes = Episode::where('active', '=', '1')->where('featured', '=', '1')
                    ->orderBy('id', 'DESC')
                    ->get();
                $latest_series = Series::where('active', '=', '1')->orderBy('created_at', 'DESC')
                ->get();
                $pages = Page::all();
                if (!Auth::guest())
                {
                    $getcnt_watching = ContinueWatching::where('user_id', Auth::user()->id)
                        ->pluck('videoid')
                        ->toArray();
                    $cnt_watching = Video::with('cnt_watch')->whereIn('id', $getcnt_watching)->get();
                }
                else
                {
                    $cnt_watching = '';
                }
                $currency = CurrencySetting::first();
                $data = array(
                    'currency' => $currency,

                    'videos' => Video::where('active', '=', '1')->where('status', '=', '1')
                                        ->where('draft', '=', '1')
                                        ->orderBy('created_at', 'DESC')
                                        ->simplePaginate($this->videos_per_page) ,

                    'video_banners' => Video::where('active', '=', '1')
                                        ->where('draft', '=', '1')
                                        ->where('status', '=', '1')
                                        ->where('banner', '=', '1')
                                        ->orderBy('created_at', 'DESC')
                                        ->simplePaginate(130000) ,

                    'sliders' => Slider::where('active', '=', '1')
                                        ->orderBy('order_position', 'ASC')
                                        ->get() ,
                    
                    'series_sliders' => Series::where('active', '=', '1')
                                        ->where('banner','=','1')
                                        ->latest()
                                        ->get() ,
                    
                    
                    'latest_series' => $latest_series,
                    'cnt_watching' => $cnt_watching,
                    'trendings' => $trending_movies,
                    'latest_videos' => $latest_videos,
                    'movies' => $trending_movies,
                    'latest_movies' => $latest_movies,
                    'ppv_movies' => $ppv_movies,
                    'trending_audios' => $trending_audios,
                    'latest_audios' => $latest_audios,
                    'featured_videos' => $featured_videos,
                    'featured_episodes' => $featured_episodes,
                    'current_page' => 1,
                    'genre_video_display' => $genre_video_display,
                    'genres' => VideoCategory::all() ,
                    'pagination_url' => '/videos',
                    'settings' => $settings,
                    'pages' => $pages,
                    'trending_videos' => $trending_videos,
                    'suggested_videos' => $suggested_videos,
                    'video_categories' => VideoCategory::all() ,
                    'home_settings' => HomeSetting::first() ,

                );
                //echo "<pre>";print_r($data['latest_videos']);exit;
                return View::make('home', $data);

            }
        }
    }
    public function FirstLanging()
    {
        $data = Session::all();
        $settings = Setting::first();
        $multiuser = Session::get('subuser_id');
        $getfeching = Geofencing::first();
        $Recomended = HomeSetting::first();
        $ThumbnailSetting = ThumbnailSetting::first();

        if($settings->enable_landing_page == 1 && Auth::guest()){

            $landing_page_slug = AdminLandingPage::where('status',1)->pluck('slug')->first() ? AdminLandingPage::where('status',1)->pluck('slug')->first() : "landing-page" ;

            return redirect()->route('landing_page', $landing_page_slug );
        }

        if ($settings->access_free == 1 && Auth::guest() && !isset($data['user']))
        {
            $latest_series = Series::where('active', '=', '1')->orderBy('created_at', 'DESC')
            ->get(); 
            
            $settings = Setting::first();
            $genre = Genre::all();
            $genre_video_display = VideoCategory::all();

            $trending_videos = Video::where('active', '=', '1')->where('status', '=', '1')
            ->where('draft', '=', '1')
                ->where('views', '>', '5')
                ->orderBy('created_at', 'DESC')
                ->get();
            $latest_videos = Video::where('status', '=', '1')->take(10)
            ->where('active', '=', '1')
            ->where('draft', '=', '1')
                ->orderBy('created_at', 'DESC')
                ->get();
            $suggested_videos = Video::where('active', '=', '1')->where('views', '>', '5')
            ->where('status', '=', '1')
            ->where('draft', '=', '1')
                ->orderBy('created_at', 'DESC')
                ->get();
            $trending_movies = Movie::where('active', '=', '1')->where('status', '=', '1')
                ->where('views', '>', '5')
                ->orderBy('created_at', 'DESC')
                ->get();
            $ppv_movies = PpvVideo::where('active', '=', '1')->where('status', '=', '1')
                ->orderBy('created_at', 'DESC')
                ->get();
            $latest_movies = Movie::where('active', '=', '1')->where('status', '=', '1')
                ->take(10)
                ->orderBy('created_at', 'DESC')
                ->get();
            $trending_audios = Audio::where('active', '=', '1')->where('status', '=', '1')
                ->where('views', '>', '5')
                ->orderBy('created_at', 'DESC')
                ->get();
            $latest_audios = Audio::where('active', '=', '1')->where('status', '=', '1')
                ->take(10)
                ->orderBy('created_at', 'DESC')
                ->get();
            $trending_episodes = Episode::where('active', '=', '1')->where('views', '>', '0')
                ->orderBy('id', 'DESC')
                ->get();
            $latest_series = Series::where('active', '=', '1')->orderBy('created_at', 'DESC')
                ->get();            
            $trendings = new \Illuminate\Database\Eloquent\Collection; //Create empty collection which we know has the merge() method
            $trendings = $trendings->merge($trending_videos);
            $trendings = $trendings->merge($trending_movies);
            $trendings = $trendings->merge($trending_episodes);
            $featured_videos = Video::where('active', '=', '1')->where('featured', '=', '1')
            ->where('status', '=', '1')
            ->where('draft', '=', '1')
                ->orderBy('created_at', 'DESC')
                ->get();
            $featured_episodes = Episode::where('active', '=', '1')->where('featured', '=', '1')
                ->orderBy('id', 'DESC')
                ->get();

            $pages = Page::all();
            if (!Auth::guest())
            {
                $getcnt_watching = ContinueWatching::where('user_id', Auth::user()->id)
                    ->pluck('videoid')
                    ->toArray();
                $cnt_watching = Video::with('cnt_watch')->whereIn('id', $getcnt_watching)->get();
                
            }
            else
            {
                $cnt_watching = [];
                
            }

            $latest_series = Series::where('active', '=', '1')->orderBy('created_at', 'DESC')
            ->get();
            $currency = CurrencySetting::first();
            $data = array(
                'currency' => $currency,

                'videos' => Video::where('active', '=', '1')->where('status', '=', '1')
                                ->where('draft', '=', '1')
                                ->orderBy('created_at', 'DESC')
                                ->simplePaginate($this->videos_per_page) ,

                'video_banners' => Video::where('active', '=', '1')
                                    ->where('draft', '=', '1')
                                    ->where('status', '=', '1')
                                    ->where('banner', '=', '1')
                                    ->orderBy('created_at', 'DESC')
                                    ->simplePaginate(130000) ,

                'sliders' => Slider::where('active', '=', '1')
                    ->orderBy('order_position', 'ASC')
                    ->get() ,

                'series_sliders' => Series::where('active', '=', '1')
                                ->where('banner','=','1')
                                ->latest()
                                ->get() ,
                                
                'latest_series' => $latest_series,
                'cnt_watching' => $cnt_watching,
                'trendings' => $trending_movies,
                'latest_video' => $latest_videos,
                'latest_videos' => $latest_videos,
                'movies' => $trending_movies,
                'latest_movies' => $latest_movies,
                'ppv_movies' => $ppv_movies,
                'trending_audios' => $trending_audios,
                'latest_audios' => $latest_audios,
                'featured_videos' => $featured_videos,
                'featured_episodes' => $featured_episodes,
                'current_page' => 1,
                'genre_video_display' => $genre_video_display,
                'genres' => VideoCategory::all() ,
                'pagination_url' => '/videos',
                'settings' => $settings,
                'pages' => $pages,
                'trending_videos' => $trending_videos,
                'suggested_videos' => $suggested_videos,
                'video_categories' => VideoCategory::all() ,
                'home_settings' => HomeSetting::first() ,
                'livetream' => LiveStream::where('active', '=', '1')->orderBy('id', 'DESC')
                    ->get() ,
                'audios' => Audio::where('active', '=', '1')
                    ->orderBy('created_at', 'DESC')
                    ->get() ,
                'albums' => AudioAlbums::orderBy('created_at', 'DESC')
                    ->get() ,
                'top_most_watched' => $top_most_watched = [],
                'most_watch_user' => $most_watch_user = [],
                'Most_watched_country' => $Most_watched_country = [],
                'preference_genres' => $preference_genres = [],
                'preference_Language' => $preference_Language = [],
                'Family_Mode' => $Family_Mode = 2,
                'Kids_Mode' => $Kids_Mode = 2,
                'ThumbnailSetting' => $ThumbnailSetting,
                'artist' => Artist::all(),
                'VideoSchedules' => VideoSchedules::where('in_home',1)->get(),
            );
            return Theme::view('home', $data);
        }
        else
        {

            $agent = new Agent();
            // dd($agent);
            $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
            $userIp = $geoip->getip();
            $countryName = $geoip->getCountry();
            $regionName = $geoip->getregion();
            $cityName = $geoip->getcity();
            $system_settings = SystemSetting::first();
            $data = Session::all();
            $user = User::where('id', '=', 1)->first();
            // $session_password = $data['password_hash'];
            if (Auth::guest() && !isset($data['user']))
            {
                return Theme::view('auth.login');

            }
            else
            {

                $device_name = '';
                if ($agent->isDesktop())
                {
                    $device_name = 'desktop';
                }
                elseif ($agent->isTablet())
                {
                    $device_name = 'tablet';
                }
                elseif ($agent->isMobile())
                {
                    $device_name = 'mobile';
                }
                elseif ($agent->isMobile())
                {
                    $device_name = 'mobile';
                }
                else
                {
                    $device_name = 'tv';
                }
                $user_role = Auth::user()->role;
                $user_check = LoggedDevice::where('user_id', '=', Auth::User()->id)
                    ->count();

                $subuser_check = Multiprofile::where('parent_id', '=', Auth::User()->id)
                    ->count();
                $alldevices_register = LoggedDevice::where('user_id', '=', Auth::User()->id)
                    ->where('device_name', '!=', $device_name)
                    ->where('user_ip', '!=', $userIp)
                    ->get();
                $alldevices = LoggedDevice::where('user_id', '=', Auth::User()->id)
                ->get();
                $subscription_device_limit = Subscription::select('subscription_plans.devices')->join('subscription_plans', 'subscriptions.stripe_plan', '=', 'subscription_plans.plan_id')
                    ->where('subscriptions.user_id', Auth::User()
                    ->id)
                    ->get();
                if (count($subscription_device_limit) >= 1)
                {
                    $device_limit = $subscription_device_limit[0]->devices;
                    $limit = explode(",", $device_limit);
                    $device_limit = count($limit);
                }
                else
                {
                    $device_limit = 0;
                }
                $user_check = LoggedDevice::where('user_id', '=', Auth::User()->id)
                    ->count();
                $subuser_check = Multiprofile::where('parent_id', '=', Auth::User()->id)
                    ->count();
                $alldevices = LoggedDevice::where('user_id', '=', Auth::User()->id)
                    ->get();
                $devices_check = LoggedDevice::where('user_id', '=', Auth::User()->id)
                    ->where('device_name', '=', $device_name)->first();

                $latest_series = Series::where('active', '=', '1')->orderBy('created_at', 'DESC')
                ->get();


                $username = Auth::User()->username;
                $email = Auth::User()->email;
                $mail_check = ApprovalMailDevice::where('user_ip', '=', $userIp)->where('device_name', '=', $device_name)->first();
                $user_check = LoggedDevice::where('user_id', '=', Auth::User()->id)
                    ->count();
                $subuser_check = Multiprofile::where('parent_id', '=', Auth::User()->id)
                    ->count();
                    // dd(count($alldevices_register));

                if (count($alldevices_register) > 0  && $user_role == "registered" && Auth::User()->id != 1)
                {
                    // dd('test');
                    LoggedDevice::where('user_ip','=', $userIp)
                    ->where('user_id','=', Auth::User()->id)
                    ->where('device_name','=', $device_name)
                    ->delete();

                    Mail::send('emails.register_device_login', array(
                        'id' => Auth::User()->id,
                        'name' => Auth::User()->username,

                    ) , function ($message) use ($email, $username)
                    {
                        $message->from(AdminMail() , GetWebsiteName());
                        $message->to($email, $username)->subject('Buy Subscriptions Plan To Access Multiple Devices');
                    });
                    $message = 'Buy Subscriptions Plan To Access Multiple Devices.';
                    Auth::logout();
                    unset($data['password_hash']);
                    \Session::flush();
                    return Redirect::to('/')->with(array(
                        'message' => 'Buy Subscriptions Plan!',
                        'note_type' => 'success'
                    ));
                }

                // else if ($user_check >= 1 && $user_check < $device_limit  && $user_role == "subscriber" && Auth::User()->id != 1)
                // {

                //     // dd($mail_check);

                //     $url1 = $_SERVER['REQUEST_URI'];
                //     header("Refresh: 120; URL=$url1");
                //     $username = Auth::User()->username;
                //     $email = Auth::User()->email;
                //     $mail_check = ApprovalMailDevice::where('user_id', '=', Auth::user()->id)
                //     ->where('device_name', '=', $device_name)
                //     ->count();
                //     // dd($mail_check); 
                //     if ( empty($mail_check) )
                //     {
                //         // dd($mail_check); 

                //         Mail::send('emails.device_approval', array(
                //             /* 'activation_code', $user->activation_code,*/
                //             'device_name' => $device_name,
                //             'ip' => $userIp,
                //             'id' => Auth::User()->id,
                //             // 'id' => $id,
                            
                //         ) , function ($message) use ($email, $username)
                //         {
                //             $message->from(AdminMail() , 'Flicknexs');
                //             $message->to($email, $username)->subject('Request to Apporve New Device');
                //         });
                //         $maildevice = new ApprovalMailDevice;
                //         $maildevice->user_ip = $userIp;
                //         $maildevice->user_id = Auth::User()->id;
                //         $maildevice->device_name = $device_name;
                //         $maildevice->status = 0;
                //         $maildevice->save();
                //         $message = 'Mail Sent For Approval Login After Approved By' . ' ' . $username;
                //         return Redirect::to('/')->with(array(
                //             'message' => $message,
                //             'note_type' => 'success'
                //         ));
                        
                //     }
                //     elseif(!empty($mail_check) && $mail_check->status == 0)
                //     {
                //         $message = 'Please Wait to Approve Your Login Request By ' . ' ' . $username;
                //         return Redirect::to('/')->with(array(
                //             'message' => $message,
                //             'note_type' => 'success'
                //         ));
                //     }
                //     elseif(!empty($mail_check) && $mail_check->status == 2)
                //     {

                //         Auth::logout();
                //         unset($data['password_hash']);
                //         \Session::flush();
                //         $message = 'Login Access Rejected BY ' . ' ' . $username;
                //         return Redirect::to('/')->with(array(
                //             'message' => $message,
                //             'note_type' => 'success'
                //         ));
                //     }
                // }
                elseif ($user_check >= $device_limit && Auth::User()->role != "admin" && Auth::User()->role != "registered")
                {
                    // dd(Auth::User()->role);

                    $url1 = $_SERVER['REQUEST_URI'];
                    header("Refresh: 120; URL=$url1");
                    $message = 'Your Plan Device  Limit Is' . ' ' . $device_limit;
                    return view('device_logged', compact('alldevices', 'system_settings', 'user','userIp'))->with(array(
                        'message' => $message,
                        'note_type' => 'success'
                    ));
                }
                else
                {
                    // dd($device_name);
                    $device_name = '';
                    if ($agent->isDesktop())
                    {
                        $device_name = 'desktop';
                    }
                    elseif ($agent->isTablet())
                    {
                        $device_name = 'tablet';
                    }
                    elseif ($agent->isMobile())
                    {
                        $device_name = 'mobile';
                    }
                    elseif ($agent->isMobile())
                    {
                        $device_name = 'mobile';
                    }
                    else
                    {
                        $device_name = 'tv';
                    }

                    if (!empty($device_name))
                    {
                        
                        $devices_check = LoggedDevice::where('user_id', '=', Auth::User()->id)
                            ->where('device_name', '=', $device_name)->first();
                    //  dd('devices_check');

                        if (empty($devices_check))
                        {
                            $adddevice = new LoggedDevice;
                            $adddevice->user_id = Auth::User()->id;
                            $adddevice->user_ip = $userIp;
                            $adddevice->device_name = $device_name;
                            $adddevice->save();
                        }
                    }
 

                }

                // dd($user_role);
                $logged = UserLogs::where('user_id', '=', Auth::User()->id)
                    ->orderBy('created_at', 'DESC')
                    ->whereDate('created_at', '>=', \Carbon\Carbon::now()
                    ->today())
                    ->first();
                if (!empty($logged))
                {
                    $today_old_log = UserLogs::where('user_id', '=', Auth::User()->id)
                        ->orderBy('created_at', 'DESC')
                        ->whereDate('created_at', '>=', \Carbon\Carbon::now()
                        ->today())
                        ->delete();
                    $new_login = new UserLogs;
                    $new_login->user_id = Auth::User()->id;
                    $new_login->user_ip = $userIp;
                    $new_login->countryname = Country_name();
                    $new_login->regionname = Region_name();
                    $new_login->cityname = city_name();
                    $new_login->save();
                }
                else
                {
                    $new_login = new UserLogs;
                    $new_login->user_id = Auth::User()->id;
                    $new_login->user_ip = $userIp;
                    $new_login->countryname = Country_name();
                    $new_login->regionname = Region_name();
                    $new_login->cityname = city_name();
                    $new_login->save();
                }

                $users_logged_today = UserLogs::orderBy('created_at', 'DESC')->whereDate('created_at', '>=', \Carbon\Carbon::now()
                    ->today())
                    ->count();

                 
                    $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
                    $settings = Setting::first();
                    $PPV_settings = Setting::where('ppv_status', '=', 1)->first();
                    
                    $latest_series = Series::where('active', '=', '1')->orderBy('created_at', 'DESC')
                        ->get();

                    if (!empty($PPV_settings))
                    {
                        $ppv_gobal_price = $PPV_settings->ppv_price;
                        // echo "<pre>";print_r($PPV_settings->ppv_hours);exit();
                        
                    }
                    else
                    {
                        // echo "<pre>";print_r('ppv_status');exit();
                        $ppv_gobal_price = null;

                    }

                    $genre = Genre::all();
                    $genre_video_display = VideoCategory::all();

                    // blocked videos
                    $block_videos = BlockVideo::where('country_id', $countryName)->get();
                    if (!$block_videos->isEmpty())
                    {
                        foreach ($block_videos as $block_video)
                        {
                            $blockvideos[] = $block_video->video_id;
                        }
                    }
                    else
                    {
                        $blockvideos[] = '';
                    }

                    // Mode - Family & Kids
                    if ($multiuser != null)
                    {
                        $Mode = Multiprofile::where('id', $multiuser)->first();
                    }
                    else
                    {
                        $Mode = User::where('id', Auth::User()->id)
                            ->first();
                    }

                    $Family_Mode = $Mode['FamilyMode'];
                    $Kids_Mode = $Mode['Kidsmode'];

                    if ($multiuser != null)
                    {
                        $Multiuser = Multiprofile::where('id', $multiuser)->first();
                        // Latest Videos
                        if ($Multiuser->user_type == 'Normal')
                        {
                            $latest_videos_count = Video::where('active', '=', '1')->where('status', '=', '1')
                            ->where('draft', '=', '1')
                                ->take(10)
                                ->orderBy('created_at', 'DESC')
                                ->count();

                            $latest_series = Series::where('active', '=', '1')->orderBy('created_at', 'DESC')
                                ->get();

                            if ($latest_videos_count > 0)
                            {
                                $latest_videos = Video::where('active', '=', '1')->where('status', '=', '1')
                                ->where('draft', '=', '1')
                                    ->take(10)
                                    ->orderBy('created_at', 'DESC');
                                if ($Family_Mode == 1)
                                {
                                    $latest_videos = $latest_videos->where('age_restrict', '<', 18);
                                }
                                if ($Kids_Mode == 1)
                                {
                                    $latest_videos = $latest_videos->where('age_restrict', '<', 10);
                                }
                                if ($getfeching != null && $getfeching->geofencing == 'ON')
                                {
                                    $latest_videos = $latest_videos->whereNotIn('id', $blockvideos);
                                }
                                $latest_videos = $latest_videos->get();

                            }
                            else
                            {
                                $latest_videos = [];
                            }

                        }
                        else
                        {

                            $latest_series = Series::where('active', '=', '1')->orderBy('created_at', 'DESC')
                                ->get();

                            $latest_videos_count = Video::where('active', '=', '1')->where('status', '=', '1')
                            ->where('draft', '=', '1')
                                ->where('age_restrict', '<', 18)
                                ->take(10)
                                ->orderBy('created_at', 'DESC')
                                ->count();
                            if ($latest_videos_count > 0)
                            {
                                $latest_videos = Video::where('active', '=', '1')->where('status', '=', '1')
                                ->where('draft', '=', '1')
                                    ->take(10)
                                    ->orderBy('created_at', 'DESC');
                                if ($Family_Mode == 1)
                                {
                                    $latest_videos = $latest_videos->where('age_restrict', '<', 18);
                                }
                                if ($Kids_Mode == 1)
                                {
                                    $latest_videos = $latest_videos->where('age_restrict', '<', 10);
                                }
                                if ($getfeching != null && $getfeching->geofencing == 'ON')
                                {
                                    $latest_videos = $latest_videos->whereNotIn('id', $blockvideos);
                                }
                                $latest_videos = $latest_videos->get();
                            }
                            else
                            {
                                $latest_videos = [];
                            }
                        }
                    }
                    else
                    {
                        $latest_videos_count = Video::where('active', '=', '1')->where('status', '=', '1')
                        ->where('draft', '=', '1')
                            ->take(10)
                            ->orderBy('created_at', 'DESC')
                            ->count();
                        if ($latest_videos_count > 0)
                        {
                            $latest_videos = Video::where('active', '=', '1')->where('status', '=', '1')
                            ->where('draft', '=', '1')
                                ->take(10)
                                ->orderBy('created_at', 'DESC');
                            if ($Family_Mode == 1)
                            {
                                $latest_videos = $latest_videos->where('age_restrict', '<', 18);
                            }
                            if ($Kids_Mode == 1)
                            {
                                $latest_videos = $latest_videos->where('age_restrict', '<', 10);
                            }
                            if ($getfeching != null && $getfeching->geofencing == 'ON')
                            {
                                $latest_videos = $latest_videos->whereNotIn('id', $blockvideos);
                            }
                            $latest_videos = $latest_videos->get();

                        }
                        else
                        {
                            $latest_videos = [];
                        }
                    }

                    // featured_videos_count
                    if ($multiuser != null)
                    {
                        if ($Multiuser->user_type == 'Normal')
                        {

                            $featured_videos_count = Video::where('active', '=', '1')->where('featured', '=', '1')
                            ->where('status', '=', '1')
                            ->where('draft', '=', '1')
                                ->orderBy('created_at', 'DESC')
                                ->count();
                            if ($featured_videos_count > 0)
                            {
                                $featured_videos = Video::where('active', '=', '1')
                                ->where('status', '=', '1')
                                ->where('draft', '=', '1')
                                ->whereNotIn('id', $blockvideos)->where('featured', '=', '1')
                                    ->orderBy('created_at', 'DESC');
                                if ($Family_Mode == 1)
                                {
                                    $featured_videos = $featured_videos->where('age_restrict', '<', 18);
                                }
                                if ($Kids_Mode == 1)
                                {
                                    $featured_videos = $featured_videos->where('age_restrict', '<', 10);
                                }
                                if ($getfeching != null && $getfeching->geofencing == 'ON')
                                {
                                    $featured_videos = $featured_videos->whereNotIn('id', $blockvideos);
                                }
                                $featured_videos = $featured_videos->get();
                            }
                            else
                            {
                                $featured_videos = [];
                            }
                        }
                        else
                        {
                            $featured_videos_count = Video::where('active', '=', '1')->where('featured', '=', '1')
                            ->where('status', '=', '1')
                            ->where('draft', '=', '1')
                                ->where('age_restrict', '<', 18)
                                ->orderBy('created_at', 'DESC')
                                ->count();
                            if ($featured_videos_count > 0)
                            {
                                $featured_videos = Video::where('active', '=', '1')
                                ->where('status', '=', '1')
                                ->where('draft', '=', '1')
                                ->whereNotIn('id', $blockvideos)->where('featured', '=', '1')
                                    ->where('age_restrict', '<', 18)
                                    ->orderBy('created_at', 'DESC');
                                if ($Family_Mode == 1)
                                {
                                    $featured_videos = $featured_videos->where('age_restrict', '<', 18);
                                }
                                if ($Kids_Mode == 1)
                                {
                                    $featured_videos = $featured_videos->where('age_restrict', '<', 10);
                                }
                                if ($getfeching != null && $getfeching->geofencing == 'ON')
                                {
                                    $featured_videos = $featured_videos->whereNotIn('id', $blockvideos);
                                }
                                $featured_videos = $featured_videos->get();

                            }
                            else
                            {
                                $featured_videos = [];
                            }
                        }
                    }
                    else
                    {
                        $featured_videos_count = Video::where('active', '=', '1')->where('featured', '=', '1')
                        ->where('status', '=', '1')
                        ->where('draft', '=', '1')
                            ->orderBy('created_at', 'DESC')
                            ->count();
                        if ($featured_videos_count > 0)
                        {
                            $featured_videos = Video::where('active', '=', '1')
                            ->where('status', '=', '1')
                            ->where('draft', '=', '1')
                            ->whereNotIn('id', $blockvideos)->where('featured', '=', '1')
                                ->orderBy('created_at', 'DESC');
                            if ($Family_Mode == 1)
                            {
                                $featured_videos = $featured_videos->where('age_restrict', '<', 18);
                            }
                            if ($Kids_Mode == 1)
                            {
                                $featured_videos = $featured_videos->where('age_restrict', '<', 10);
                            }
                            if ($getfeching != null && $getfeching->geofencing == 'ON')
                            {
                                $featured_videos = $featured_videos->whereNotIn('id', $blockvideos);
                            }
                            $featured_videos = $featured_videos->get();
                        }
                        else
                        {
                            $featured_videos = [];
                        }
                    }

                    // Most watched videos By user
                    

                    if ($Recomended->Recommendation == 1)
                    {

                        $most_watch_user = RecentView::select('video_id', 'videos.*', DB::raw('COUNT(video_id) AS count'))->join('videos', 'videos.id', '=', 'recent_views.video_id')
                            ->groupBy('video_id');
                        if ($multiuser != null)
                        {
                            $most_watch_user = $most_watch_user->where('recent_views.sub_user', $multiuser);
                        }
                        else
                        {
                            $most_watch_user = $most_watch_user->where('recent_views.user_id', Auth::user()
                                ->id);
                        }
                        if ($Family_Mode == 1)
                        {
                            $most_watch_user = $most_watch_user->where('age_restrict', '<', 18);
                        }
                        if ($Kids_Mode == 1)
                        {
                            $most_watch_user = $most_watch_user->where('age_restrict', '<', 10);
                        }
                        $most_watch_user = $most_watch_user->orderByRaw('count DESC')
                            ->limit(20)
                            ->get();
                    }
                    else
                    {
                        $most_watch_user = [];
                    }

                    // Most watched videos In Flicknexs
                    if ($getfeching->geofencing == 'ON')
                    {

                        $Blocking_videos = BlockVideo::where('country_id', $countryName)->get();
                        if (!$Blocking_videos->isEmpty())
                        {
                            foreach ($Blocking_videos as $Blocking_video)
                            {
                                $blocking_videos[] = $Blocking_video->video_id;
                            }
                        }
                        else
                        {
                            $blocking_videos = [];
                        }
                    }
                    else
                    {
                        $blocking_videos = [];
                    }

                    if ($Recomended->Recommendation == 1)
                    {
                        $top_most_watched = RecentView::select('video_id', 'videos.*', DB::raw('COUNT(video_id) AS count'))->join('videos', 'videos.id', '=', 'recent_views.video_id')
                            ->groupBy('video_id')
                            ->whereNotIn('videos.id', $blocking_videos);
                        if ($Family_Mode == 1)
                        {
                            $top_most_watched = $top_most_watched->where('age_restrict', '<', 18);
                        }
                        if ($Kids_Mode == 1)
                        {
                            $top_most_watched = $top_most_watched->where('age_restrict', '<', 10);
                        }
                        $top_most_watched = $top_most_watched->orderByRaw('count DESC')
                            ->limit(20)
                            ->get();
                    }
                    else
                    {
                        $top_most_watched = [];
                    }

                    // Most Watched Videos in country
                    if ($Recomended->Recommendation == 1)
                    {

                        $Most_watched_country = RecentView::select('video_id', 'videos.*', DB::raw('COUNT(video_id) AS count'))->join('videos', 'videos.id', '=', 'recent_views.video_id')
                            ->groupBy('video_id')
                            ->orderByRaw('count DESC');
                        if ($Family_Mode == 1)
                        {
                            $Most_watched_country = $Most_watched_country->where('age_restrict', '<', 18);
                        }
                        if ($Kids_Mode == 1)
                        {
                            $Most_watched_country = $Most_watched_country->where('age_restrict', '<', 10);
                        }
                        $Most_watched_country = $Most_watched_country->where('country', $countryName)->whereNotIn('videos.id', $blocking_videos)->limit(20)
                            ->get();
                    }
                    else
                    {
                        $Most_watched_country = [];
                    }

                    // User Preferences
                    if ($Recomended->Recommendation == 1)
                    {
                        $preference_genres = User::where('id', Auth::user()->id)
                            ->pluck('preference_genres')
                            ->first();
                        $preference_language = User::where('id', Auth::user()->id)
                            ->pluck('preference_language')
                            ->first();

                        if ($preference_genres != null)
                        {
                            $video_genres = json_decode($preference_genres);
                            $preference_gen = Video::whereIn('video_category_id', $video_genres)
                            ->whereNotIn('videos.id', $blocking_videos) 
                            ->where('active', '=', '1')
                             ->where('status', '=', '1')
                            ->where('draft', '=', '1')
                            ;
                            if ($Family_Mode == 1)
                            {
                                $preference_gen = $preference_gen->where('age_restrict', '<', 18);
                            }
                            if ($Kids_Mode == 1)
                            {
                                $preference_gen = $preference_gen->where('age_restrict', '<', 10);
                            }
                            $preference_gen = $preference_gen->get();
                        }
                        else
                        {
                            $preference_gen = '';
                        }
                        if ($preference_language != null)
                        {
                            $video_language = json_decode($preference_language);
                            $preference_Lan = Video::whereIn('language', $video_language)
                            ->whereNotIn('videos.id', $blocking_videos)
                            ->where('status', '=', '1')
                            ->where('draft', '=', '1')
                            ->where('active', '=', '1');
                            if ($Family_Mode == 1)
                            {
                                $preference_Lan = $preference_Lan->where('age_restrict', '<', 18);
                            }
                            if ($Kids_Mode == 1)
                            {
                                $preference_Lan = $preference_Lan->where('age_restrict', '<', 10);
                            }
                            $preference_Lan = $preference_Lan->get();
                        }
                        else
                        {
                            $preference_Lan = '';
                        }
                    }
                    else
                    {
                        $preference_gen = '';
                        $preference_Lan = '';
                    }

                    // family & Kids Mode Restriction
                    $Subuser = Session::get('subuser_id');
                    if ($Subuser != null)
                    {
                        $Mode = Multiprofile::where('id', $Subuser)->first();
                    }
                    else
                    {
                        $Mode = User::where('id', Auth::user()->id)
                            ->first();
                    }

                    $trending_videos = Video::where('active', '=', '1')->where('status', '=', '1')
                    ->where('draft', '=', '1')
                        ->where('views', '>', '5')
                        ->orderBy('created_at', 'DESC')
                        ->get();
                    //  $latest_videos = Video::where('status', '=', '1')->take(10)->orderBy('created_at', 'DESC')->get();
                    $suggested_videos = Video::where('active', '=', '1')->where('views', '>', '5')
                    ->where('status', '=', '1')
                    ->where('draft', '=', '1')
                        ->orderBy('created_at', 'DESC')
                        ->get();
                    $trending_movies = Movie::where('active', '=', '1')->where('status', '=', '1')
                        ->where('views', '>', '5')
                        ->orderBy('created_at', 'DESC')
                        ->get();
                    $ppv_movies = PpvVideo::where('active', '=', '1')->where('status', '=', '1')
                        ->orderBy('created_at', 'DESC')
                        ->get();
                    $latest_movies = Movie::where('active', '=', '1')->where('status', '=', '1')
                        ->take(10)
                        ->orderBy('created_at', 'DESC')
                        ->get();
                    $trending_audios = Audio::where('active', '=', '1')->where('status', '=', '1')
                        ->where('views', '>', '5')
                        ->orderBy('created_at', 'DESC')
                        ->get();
                    $latest_audios = Audio::where('active', '=', '1')->where('status', '=', '1')
                        ->take(10)
                        ->orderBy('created_at', 'DESC')
                        ->get();
                    $trending_episodes = Episode::where('active', '=', '1')->where('views', '>', '0')
                        ->orderBy('created_at', 'DESC')
                        ->get();
                    $trendings = new \Illuminate\Database\Eloquent\Collection; //Create empty collection which we know has the merge() method
                    $trendings = $trendings->merge($trending_videos);
                    $trendings = $trendings->merge($trending_movies);
                    $trendings = $trendings->merge($trending_episodes);
                    //  $featured_videos = Video::where('active', '=', '1')->where('featured', '=', '1')->orderBy('created_at', 'DESC')->get();
                    $featured_episodes = Episode::where('active', '=', '1')->where('featured', '=', '1')
                        ->orderBy('views', 'DESC')
                        ->get();

                    $latest_series = Series::where('active', '=', '1')->orderBy('created_at', 'DESC')
                        ->get();
                        
                    $pages = Page::all();
                    if ($multiuser != null)
                    {
                        $getcnt_watching = ContinueWatching::where('multiuser', $multiuser)->pluck('videoid')
                            ->toArray();
                        $cnt_watching = Video::with('cnt_watch')->whereIn('id', $getcnt_watching)->get();
                    }
                    elseif (!Auth::guest())
                    {

                        $continue_watching = ContinueWatching::where('user_id', Auth::user()->id)
                            ->first();

                        if ($continue_watching != null && $continue_watching->multiuser == null)
                        {
                            $getcnt_watching = ContinueWatching::where('user_id', Auth::user()->id)
                                ->pluck('videoid')
                                ->toArray();
                            $cnt_watching = Video::with('cnt_watch')->whereIn('id', $getcnt_watching);
                            if ($getfeching != null && $getfeching->geofencing == 'ON')
                            {
                                $cnt_watching = $cnt_watching->whereNotIn('id', $blockvideos);
                            }
                            $cnt_watching = $cnt_watching->get();
                        }
                        else
                        {
                            $getcnt_watching = ContinueWatching::where('user_id', Auth::user()->id)
                                ->where('multiuser', 'data')
                                ->pluck('videoid')
                                ->toArray();
                            $cnt_watching = Video::with('cnt_watch')->whereIn('id', $getcnt_watching);
                            if ($getfeching != null && $getfeching->geofencing == 'ON')
                            {
                                $cnt_watching = $cnt_watching->whereNotIn('id', $blockvideos);
                            }
                            $cnt_watching = $cnt_watching->get();
                            //  $cnt_watching = Video::with('cnt_watch')->where('active', '=', '1')->whereIn('id',$getcnt_watching)->get();
                            
                        }

                    }
                    else
                    {
                        $cnt_watching = '';
                    }

                    $currency = CurrencySetting::first();
                    $livetreams_count = LiveStream::where('active', '=', '1')->orderBy('created_at', 'DESC')
                        ->count();
                    if ($livetreams_count > 0)
                    {
                        $livetreams = LiveStream::where('active', '=', '1')->orderBy('created_at', 'DESC')
                            ->get();
                    }
                    else
                    {
                        $livetreams = [];
                    }
                    $latest_series = Series::where('active', '=', '1')->orderBy('created_at', 'DESC')
                        ->get();
                    //  $currency->symbol
                    //  dd($latest_series);
                    $data = array(
                        'currency' => $currency,
                        'videos' => Video::where('active', '=', '1')->where('status', '=', '1')
                                            ->where('draft', '=', '1')
                                             ->orderBy('created_at', 'DESC')
                                            ->simplePaginate($this->videos_per_page) ,

                        //  'banner' => Video::where('active', '=', '1')->where('status', '=', '1')->orderBy('created_at', 'DESC')->simplePaginate(3),
                       
                        'video_banners' => Video::where('active', '=', '1')
                                            ->where('draft', '=', '1')
                                            ->where('status', '=', '1')
                                            ->where('banner', '=', '1')
                                            ->orderBy('created_at', 'DESC')
                                            ->simplePaginate(130000) ,

                        'sliders' => Slider::where('active', '=', '1')
                                            ->orderBy('order_position', 'ASC')
                                            ->get() ,
    

                        'live_banner' => LiveStream::where('banner', '=', '1')
                                        ->orderBy('created_at', 'DESC')
                                        ->simplePaginate(111111) ,

                        'series_sliders' => Series::where('active', '=', '1')
                                        ->where('banner','=','1')
                                        ->latest()
                                        ->get() ,
                        'latest_series' => $latest_series,
                        'cnt_watching' => $cnt_watching,
                        'trendings' => $trending_movies,
                        'latest_videos' => $latest_videos,
                        'latest_video' => $latest_videos,
                        'movies' => $trending_movies,
                        'latest_movies' => $latest_movies,
                        'ppv_movies' => $ppv_movies,
                        'trending_audios' => $trending_audios,
                        'latest_audios' => $latest_audios,
                        'featured_videos' => $featured_videos,
                        'featured_episodes' => $featured_episodes,
                        'current_page' => 1,
                        'genre_video_display' => $genre_video_display,
                        'genres' => VideoCategory::all() ,
                        'pagination_url' => '/videos',
                        'settings' => $settings,
                        'pages' => $pages,
                        'trending_videos' => $trending_videos,
                        'ppv_gobal_price' => $ppv_gobal_price,
                        'suggested_videos' => $suggested_videos,
                        'video_categories' => VideoCategory::all() ,
                        'home_settings' => HomeSetting::first() ,
                        'livetream' => LiveStream::where("active","=","1")->orderBy('created_at', 'DESC')->get() ,
                        'audios' => Audio::where('active', '=', '1')
                            ->orderBy('created_at', 'DESC')
                            ->get() ,
                        'albums' => AudioAlbums::orderBy('created_at', 'DESC')
                            ->get() ,
                        'most_watch_user' => $most_watch_user,
                        'top_most_watched' => $top_most_watched,
                        'Most_watched_country' => $Most_watched_country,
                        'countryName' => $countryName,
                        'preference_genres' => $preference_gen,
                        'preference_Language' => $preference_Lan,
                        'Family_Mode' => $Family_Mode,
                        'Kids_Mode' => $Kids_Mode,
                        'Mode' => $Mode,
                        'ThumbnailSetting' => $ThumbnailSetting,
                        'artist' => Artist::all(),
                        'VideoSchedules' => VideoSchedules::where('in_home',1)->get(),
                    );

                    return Theme::view('home', $data);
                }
            }
        
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {

        $data = Session::all();
        $ThumbnailSetting = ThumbnailSetting::first();

        $agent = new Agent();
        $settings = Setting::first();
        $multiuser = Session::get('subuser_id');
        $getfeching = Geofencing::first();
        $Recomended = HomeSetting::first();
        if($settings->enable_landing_page == 1 && Auth::guest()){

            $landing_page_slug = AdminLandingPage::where('status',1)->pluck('slug')->first() ? AdminLandingPage::where('status',1)->pluck('slug')->first() : "landing-page" ;

            return redirect()->route('landing_page', $landing_page_slug );
        }
        if ($settings->access_free == 1 && Auth::guest() && !isset($data['user']))
        {
            return Redirect::to('/');
        }
        else
        {

            $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
            $userIp = $geoip->getip();
            $countryName = $geoip->getCountry();
            $regionName = $geoip->getregion();
            $cityName = $geoip->getcity();
            $data = Session::all();
            $system_settings = SystemSetting::first();
            $user = User::where('id', '=', 1)->first();
            // $session_password = $data['password_hash'];
            if (Auth::guest() && !isset($data['user']))
            {
                return Theme::view('auth.login');
            }
            else
            {

                $device_name = '';
                if ($agent->isDesktop())
                {
                    $device_name = 'desktop';
                }
                elseif ($agent->isTablet())
                {
                    $device_name = 'tablet';
                }
                elseif ($agent->isMobile())
                {
                    $device_name = 'mobile';
                }
                else
                {
                    $device_name = 'tv';
                }
                $user_role = Auth::user()->role;
                $user_check = LoggedDevice::where('user_id', '=', Auth::User()->id)
                    ->count();

                $subuser_check = Multiprofile::where('parent_id', '=', Auth::User()->id)
                    ->count();
                $alldevices_register = LoggedDevice::where('user_id', '=', Auth::User()->id)
                    ->where('device_name', '!=', $device_name)
                    ->where('user_ip', '!=', $userIp)
                    ->get();
                $alldevices = LoggedDevice::where('user_id', '=', Auth::User()->id)
                ->get();
                $subscription_device_limit = Subscription::select('subscription_plans.devices')->join('subscription_plans', 'subscriptions.stripe_plan', '=', 'subscription_plans.plan_id')
                    ->where('subscriptions.user_id', Auth::User()
                    ->id)
                    ->get();
                if (count($subscription_device_limit) >= 1)
                {
                    $device_limit = $subscription_device_limit[0]->devices;
                    $limit = explode(",", $device_limit);
                    $device_limit = count($limit);
                }
                else
                {
                    $device_limit = 0;
                }

                $devices_check = LoggedDevice::where('user_id', '=', Auth::User()->id)
                    ->where('device_name', '=', $device_name)->first();
                // device  on(22022022 )
                $already_logged = LoggedDevice::where('user_id', '=', Auth::User()->id)
                ->where('user_ip', '=', $userIp)
                ->where('device_name', '=', $device_name)->count();
                if($already_logged > 0){
                    $already_logged = LoggedDevice::where('user_id', '=', Auth::User()->id)
                    ->where('user_ip', '=', $userIp)
                    ->where('device_name', '=', $device_name)->delete();
                }
                $username = Auth::User()->username;
                $email = Auth::User()->email;
                $mail_check = ApprovalMailDevice::where('user_ip', '=', $userIp)->where('device_name', '=', $device_name)->first();
                $user_check = LoggedDevice::where('user_id', '=', Auth::User()->id)
                    ->count();
                $subuser_check = Multiprofile::where('parent_id', '=', Auth::User()->id)
                    ->count();
                    // dd(count($alldevices_register));

                if (count($alldevices_register) > 0  && $user_role == "registered" && Auth::User()->id != 1)
                {
                    // dd('test');
                    LoggedDevice::where('user_ip','=', $userIp)
                    ->where('user_id','=', Auth::User()->id)
                    ->where('device_name','=', $device_name)
                    ->delete();

                    Mail::send('emails.register_device_login', array(
                        'id' => Auth::User()->id,
                        'name' => Auth::User()->username,

                    ) , function ($message) use ($email, $username)
                    {
                        $message->from(AdminMail() , GetWebsiteName());
                        $message->to($email, $username)->subject('Buy Subscriptions Plan To Access Multiple Devices');
                    });
                    $message = 'Buy Subscriptions Plan To Access Multiple Devices.';
                    Auth::logout();
                    unset($data['password_hash']);
                    \Session::flush();
                    return Redirect::to('/')->with(array(
                        'message' => 'Buy Subscriptions Plan!',
                        'note_type' => 'success'
                    ));
                }

                // else if ($user_check >= 1 && $user_check < $device_limit  && $user_role == "subscriber" && Auth::User()->id != 1)
                // {

                //     // dd($mail_check);

                //     $url1 = $_SERVER['REQUEST_URI'];
                //     header("Refresh: 120; URL=$url1");
                //     $username = Auth::User()->username;
                //     $email = Auth::User()->email;
                //     $mail_check = ApprovalMailDevice::where('user_id', '=', Auth::user()->id)
                //     ->where('device_name', '=', $device_name)
                //     ->count();
                //     // dd($mail_check); 
                //     if ( empty($mail_check) )
                //     {
                //         // dd($mail_check); 

                //         Mail::send('emails.device_approval', array(
                //             /* 'activation_code', $user->activation_code,*/
                //             'device_name' => $device_name,
                //             'ip' => $userIp,
                //             'id' => Auth::User()->id,
                //             // 'id' => $id,
                            
                //         ) , function ($message) use ($email, $username)
                //         {
                //             $message->from(AdminMail() , 'Flicknexs');
                //             $message->to($email, $username)->subject('Request to Apporve New Device');
                //         });
                //         $maildevice = new ApprovalMailDevice;
                //         $maildevice->user_ip = $userIp;
                //         $maildevice->user_id = Auth::User()->id;
                //         $maildevice->device_name = $device_name;
                //         $maildevice->status = 0;
                //         $maildevice->save();
                //         $message = 'Mail Sent For Approval Login After Approved By' . ' ' . $username;
                //         return Redirect::to('/')->with(array(
                //             'message' => $message,
                //             'note_type' => 'success'
                //         ));
                        
                //     }
                //     elseif(!empty($mail_check) && $mail_check->status == 0)
                //     {
                //         $message = 'Please Wait to Approve Your Login Request By ' . ' ' . $username;
                //         return Redirect::to('/')->with(array(
                //             'message' => $message,
                //             'note_type' => 'success'
                //         ));
                //     }
                //     elseif(!empty($mail_check) && $mail_check->status == 2)
                //     {

                //         Auth::logout();
                //         unset($data['password_hash']);
                //         \Session::flush();
                //         $message = 'Login Access Rejected BY ' . ' ' . $username;
                //         return Redirect::to('/')->with(array(
                //             'message' => $message,
                //             'note_type' => 'success'
                //         ));
                //     }
                // }
                elseif ($user_check >= $device_limit && Auth::User()->role != "admin" && Auth::User()->role != "registered")
                {
                    // dd(Auth::User()->role);

                    $url1 = $_SERVER['REQUEST_URI'];
                    header("Refresh: 120; URL=$url1");
                    $message = 'Your Plan Device  Limit Is' . ' ' . $device_limit;
                    return view('device_logged', compact('alldevices', 'system_settings', 'user','userIp'))->with(array(
                        'message' => $message,
                        'note_type' => 'success'
                    ));
                }
                else
                {
                    // dd($device_name);
                    $device_name = '';
                    if ($agent->isDesktop())
                    {
                        $device_name = 'desktop';
                    }
                    elseif ($agent->isTablet())
                    {
                        $device_name = 'tablet';
                    }
                    elseif ($agent->isMobile())
                    {
                        $device_name = 'mobile';
                    }
                    elseif ($agent->isMobile())
                    {
                        $device_name = 'mobile';
                    }
                    else
                    {
                        $device_name = 'tv';
                    }

                    if (!empty($device_name))
                    {
                        
                        $devices_check = LoggedDevice::where('user_id', '=', Auth::User()->id)
                            ->where('device_name', '=', $device_name)->first();
                    //  dd('devices_check');

                        if (empty($devices_check))
                        {
                            $adddevice = new LoggedDevice;
                            $adddevice->user_id = Auth::User()->id;
                            $adddevice->user_ip = $userIp;
                            $adddevice->device_name = $device_name;
                            $adddevice->save();
                        }
                    }
 

                }

                // dd($user_role);
                $logged = UserLogs::where('user_id', '=', Auth::User()->id)
                    ->orderBy('created_at', 'DESC')
                    ->whereDate('created_at', '>=', \Carbon\Carbon::now()
                    ->today())
                    ->first();
                if (!empty($logged))
                {
                    $today_old_log = UserLogs::where('user_id', '=', Auth::User()->id)
                        ->orderBy('created_at', 'DESC')
                        ->whereDate('created_at', '>=', \Carbon\Carbon::now()
                        ->today())
                        ->delete();
                    $new_login = new UserLogs;
                    $new_login->user_id = Auth::User()->id;
                    $new_login->user_ip = $userIp;
                    $new_login->countryname = Country_name();
                    $new_login->regionname = Region_name();
                    $new_login->cityname = city_name();
                    $new_login->save();
                }
                else
                {
                    $new_login = new UserLogs;
                    $new_login->user_id = Auth::User()->id;
                    $new_login->user_ip = $userIp;
                    $new_login->countryname = Country_name();
                    $new_login->regionname = Region_name();
                    $new_login->cityname = city_name();
                    $new_login->save();
                }

                $users_logged_today = UserLogs::orderBy('created_at', 'DESC')->whereDate('created_at', '>=', \Carbon\Carbon::now()
                    ->today())
                    ->count();
                $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();

                $settings = Setting::first();
                $PPV_settings = Setting::where('ppv_status', '=', 1)->first();
                if (!empty($PPV_settings))
                {
                    $ppv_gobal_price = $PPV_settings->ppv_price;
                }
                else
                {
                    $ppv_gobal_price = null;
                }

                $genre = Genre::all();
                $genre_video_display = VideoCategory::all();

                // blocked videos
                $block_videos = BlockVideo::where('country_id', $countryName)->get();
                if (!$block_videos->isEmpty())
                {
                    foreach ($block_videos as $block_video)
                    {
                        $blockvideos[] = $block_video->video_id;
                    }
                }
                else
                {
                    $blockvideos[] = '';
                }

                // Mode - Family & Kids
                if ($multiuser != null)
                {
                    $Mode = Multiprofile::where('id', $multiuser)->first();
                }
                else
                {
                    $Mode = User::where('id', Auth::User()->id)
                        ->first();
                }

                $Family_Mode = $Mode['FamilyMode'];
                $Kids_Mode = $Mode['Kidsmode'];

                if ($multiuser != null)
                {
                    $Multiuser = Multiprofile::where('id', $multiuser)->first();
                    // Latest Videos
                    if ($Multiuser->user_type == 'Normal')
                    {
                        $latest_videos_count = Video::where('active', '=', '1')->where('status', '=', '1')
                        ->where('draft', '=', '1')
                            ->take(10)
                            ->orderBy('created_at', 'DESC')
                            ->count();
                        if ($latest_videos_count > 0)
                        {
                            $latest_videos = Video::where('active', '=', '1')->where('status', '=', '1')
                            ->where('draft', '=', '1')
                                ->take(10)
                                ->orderBy('created_at', 'DESC');
                            if ($Family_Mode == 1)
                            {
                                $latest_videos = $latest_videos->where('age_restrict', '<', 18);
                            }
                            if ($Kids_Mode == 1)
                            {
                                $latest_videos = $latest_videos->where('age_restrict', '<', 10);
                            }
                            if ($getfeching != null && $getfeching->geofencing == 'ON')
                            {
                                $latest_videos = $latest_videos->whereNotIn('id', $blockvideos);
                            }
                            $latest_videos = $latest_videos->get();

                        }
                        else
                        {
                            $latest_videos = [];
                        }

                    }
                    else
                    {
                        $latest_videos_count = Video::where('active', '=', '1')->where('status', '=', '1')
                        ->where('draft', '=', '1')
                            ->where('age_restrict', '<', 18)
                            ->take(10)
                            ->orderBy('created_at', 'DESC')
                            ->count();
                        if ($latest_videos_count > 0)
                        {
                            $latest_videos = Video::where('active', '=', '1')->where('status', '=', '1')
                            ->where('draft', '=', '1')
                                ->take(10)
                                ->orderBy('created_at', 'DESC');
                            if ($Family_Mode == 1)
                            {
                                $latest_videos = $latest_videos->where('age_restrict', '<', 18);
                            }
                            if ($Kids_Mode == 1)
                            {
                                $latest_videos = $latest_videos->where('age_restrict', '<', 10);
                            }
                            if ($getfeching != null && $getfeching->geofencing == 'ON')
                            {
                                $latest_videos = $latest_videos->whereNotIn('id', $blockvideos);
                            }
                            $latest_videos = $latest_videos->get();
                        }
                        else
                        {
                            $latest_videos = [];
                        }
                    }
                }
                else
                {
                    $latest_videos_count = Video::where('active', '=', '1')->where('status', '=', '1')
                    ->where('draft', '=', '1')
                        ->take(10)
                        ->orderBy('created_at', 'DESC')
                        ->count();
                    if ($latest_videos_count > 0)
                    {
                        $latest_videos = Video::where('active', '=', '1')->where('status', '=', '1')
                        ->where('draft', '=', '1')
                            ->take(10)
                            ->orderBy('created_at', 'DESC');
                        if ($Family_Mode == 1)
                        {
                            $latest_videos = $latest_videos->where('age_restrict', '<', 18);
                        }
                        if ($Kids_Mode == 1)
                        {
                            $latest_videos = $latest_videos->where('age_restrict', '<', 10);
                        }
                        if ($getfeching != null && $getfeching->geofencing == 'ON')
                        {
                            $latest_videos = $latest_videos->whereNotIn('id', $blockvideos);
                        }
                        $latest_videos = $latest_videos->get();

                    }
                    else
                    {
                        $latest_videos = [];
                    }
                }

                // featured_videos_count
                if ($multiuser != null)
                {
                    if ($Multiuser->user_type == 'Normal')
                    {

                        $featured_videos_count = Video::where('active', '=', '1')->where('featured', '=', '1')
                        ->where('status', '=', '1')
                        ->where('draft', '=', '1')
                            ->orderBy('created_at', 'DESC')
                            ->count();
                        if ($featured_videos_count > 0)
                        {
                            $featured_videos = Video::where('active', '=', '1')
                            ->whereNotIn('id', $blockvideos)->where('featured', '=', '1')
                            ->where('status', '=', '1')
                            ->where('draft', '=', '1')
                                ->orderBy('created_at', 'DESC');
                            if ($Family_Mode == 1)
                            {
                                $featured_videos = $featured_videos->where('age_restrict', '<', 18);
                            }
                            if ($Kids_Mode == 1)
                            {
                                $featured_videos = $featured_videos->where('age_restrict', '<', 10);
                            }
                            if ($getfeching != null && $getfeching->geofencing == 'ON')
                            {
                                $featured_videos = $featured_videos->whereNotIn('id', $blockvideos);
                            }
                            $featured_videos = $featured_videos->get();
                        }
                        else
                        {
                            $featured_videos = [];
                        }
                    }
                    else
                    {
                        $featured_videos_count = Video::where('active', '=', '1')->where('featured', '=', '1')
                            ->where('status', '=', '1')
                            ->where('draft', '=', '1')
                            ->where('age_restrict', '<', 18)
                            ->orderBy('created_at', 'DESC')
                            ->count();
                        if ($featured_videos_count > 0)
                        {
                            $featured_videos = Video::where('active', '=', '1')->whereNotIn('id', $blockvideos)->where('featured', '=', '1')
                                ->where('age_restrict', '<', 18)
                                ->where('status', '=', '1')
                                ->where('draft', '=', '1')
                                ->orderBy('created_at', 'DESC');
                            if ($Family_Mode == 1)
                            {
                                $featured_videos = $featured_videos->where('age_restrict', '<', 18);
                            }
                            if ($Kids_Mode == 1)
                            {
                                $featured_videos = $featured_videos->where('age_restrict', '<', 10);
                            }
                            if ($getfeching != null && $getfeching->geofencing == 'ON')
                            {
                                $featured_videos = $featured_videos->whereNotIn('id', $blockvideos);
                            }
                            $featured_videos = $featured_videos->get();

                        }
                        else
                        {
                            $featured_videos = [];
                        }
                    }
                }
                else
                {
                    $featured_videos_count = Video::where('active', '=', '1')->where('featured', '=', '1')
                        ->where('status', '=', '1')
                        ->where('draft', '=', '1')
                        ->orderBy('created_at', 'DESC')
                        ->count();
                    if ($featured_videos_count > 0)
                    {
                        $featured_videos = Video::where('active', '=', '1')->whereNotIn('id', $blockvideos)->where('featured', '=', '1')
                            ->where('status', '=', '1')
                            ->where('draft', '=', '1')
                            ->orderBy('created_at', 'DESC');
                        if ($Family_Mode == 1)
                        {
                            $featured_videos = $featured_videos->where('age_restrict', '<', 18);
                        }
                        if ($Kids_Mode == 1)
                        {
                            $featured_videos = $featured_videos->where('age_restrict', '<', 10);
                        }
                        if ($getfeching != null && $getfeching->geofencing == 'ON')
                        {
                            $featured_videos = $featured_videos->whereNotIn('id', $blockvideos);
                        }
                        $featured_videos = $featured_videos->get();
                    }
                    else
                    {
                        $featured_videos = [];
                    }
                }

                // Most watched videos By user
                

                if ($Recomended->Recommendation == 1)
                {

                    $most_watch_user = RecentView::select('video_id', 'videos.*', DB::raw('COUNT(video_id) AS count'))->join('videos', 'videos.id', '=', 'recent_views.video_id')
                        ->groupBy('video_id');
                    if ($multiuser != null)
                    {
                        $most_watch_user = $most_watch_user->where('recent_views.sub_user', $multiuser);
                    }
                    else
                    {
                        $most_watch_user = $most_watch_user->where('recent_views.user_id', Auth::user()
                            ->id);
                    }
                    if ($Family_Mode == 1)
                    {
                        $most_watch_user = $most_watch_user->where('age_restrict', '<', 18);
                    }
                    if ($Kids_Mode == 1)
                    {
                        $most_watch_user = $most_watch_user->where('age_restrict', '<', 10);
                    }
                    $most_watch_user = $most_watch_user->orderByRaw('count DESC')
                        ->limit(20)
                        ->get();
                }
                else
                {
                    $most_watch_user = [];
                }

                // Most watched videos In website
                if ($getfeching->geofencing == 'ON')
                {

                    $Blocking_videos = BlockVideo::where('country_id', $countryName)->get();
                    if (!$Blocking_videos->isEmpty())
                    {
                        foreach ($Blocking_videos as $Blocking_video)
                        {
                            $blocking_videos[] = $Blocking_video->video_id;
                        }
                    }
                    else
                    {
                        $blocking_videos = [];
                    }
                }
                else
                {
                    $blocking_videos = [];
                }

                if ($Recomended->Recommendation == 1)
                {
                    $top_most_watched = RecentView::select('video_id', 'videos.*', DB::raw('COUNT(video_id) AS count'))->join('videos', 'videos.id', '=', 'recent_views.video_id')
                        ->groupBy('video_id')
                        ->whereNotIn('videos.id', $blocking_videos);
                    if ($Family_Mode == 1)
                    {
                        $top_most_watched = $top_most_watched->where('age_restrict', '<', 18);
                    }
                    if ($Kids_Mode == 1)
                    {
                        $top_most_watched = $top_most_watched->where('age_restrict', '<', 10);
                    }
                    $top_most_watched = $top_most_watched->orderByRaw('count DESC')
                        ->limit(20)
                        ->get();
                }
                else
                {
                    $top_most_watched = [];
                }

                // Most Watched Videos in country
                if ($Recomended->Recommendation == 1)
                {

                    $Most_watched_country = RecentView::select('video_id', 'videos.*', DB::raw('COUNT(video_id) AS count'))->join('videos', 'videos.id', '=', 'recent_views.video_id')
                        ->groupBy('video_id')
                        ->orderByRaw('count DESC');
                    if ($Family_Mode == 1)
                    {
                        $Most_watched_country = $Most_watched_country->where('age_restrict', '<', 18);
                    }
                    if ($Kids_Mode == 1)
                    {
                        $Most_watched_country = $Most_watched_country->where('age_restrict', '<', 10);
                    }
                    $Most_watched_country = $Most_watched_country->where('recent_views.country_name', $countryName)->whereNotIn('videos.id', $blocking_videos)->limit(20)
                        ->get();
                }
                else
                {
                    $Most_watched_country = [];
                }

                // User Preferences
                if ($Recomended->Recommendation == 1)
                {
                    $preference_genres = User::where('id', Auth::user()->id)
                        ->pluck('preference_genres')
                        ->first();
                    $preference_language = User::where('id', Auth::user()->id)
                        ->pluck('preference_language')
                        ->first();

                    if ($preference_genres != null)
                    {
                        $video_genres = json_decode($preference_genres);
                        $preference_gen = Video::join('categoryvideos', 'categoryvideos.video_id', '=', 'videos.id')->whereIn('category_id', $video_genres)->whereNotIn('videos.id', $blocking_videos)->groupBy('categoryvideos.video_id');
                        if ($Family_Mode == 1)
                        {
                            $preference_gen = $preference_gen->where('age_restrict', '<', 18);
                        }
                        if ($Kids_Mode == 1)
                        {
                            $preference_gen = $preference_gen->where('age_restrict', '<', 10);
                        }
                        $preference_gen = $preference_gen->get();
                    }
                    else
                    {
                        $preference_gen = '';
                    }
                    if ($preference_language != null)
                    {
                        $video_language = json_decode($preference_language);
                        $preference_Lan = Video::Select('videos.*','languagevideos.*','videos.id as pre_video_id')->join('languagevideos', 'languagevideos.video_id', '=', 'videos.id')
                                            ->whereIn('language_id', $video_language)
                                            ->whereNotIn('videos.id', $blocking_videos)
                                            ->where('status', '=', '1')
                                            ->where('draft', '=', '1')
                                            ->groupBy('languagevideos.video_id');
                        if ($Family_Mode == 1)
                        {
                            $preference_Lan = $preference_Lan->where('age_restrict', '<', 18);
                        }
                        if ($Kids_Mode == 1)
                        {
                            $preference_Lan = $preference_Lan->where('age_restrict', '<', 10);
                        }
                        $preference_Lan = $preference_Lan->get();
                    }
                    else
                    {
                        $preference_Lan = '';
                    }
                }
                else
                {
                    $preference_gen = '';
                    $preference_Lan = '';
                }

                // family & Kids Mode Restriction
                $Subuser = Session::get('subuser_id');
                if ($Subuser != null)
                {
                    $Mode = Multiprofile::where('id', $Subuser)->first();
                }
                else
                {
                    $Mode = User::where('id', Auth::user()->id)
                        ->first();
                }

                $trending_videos = Video::where('active', '=', '1')->where('status', '=', '1')
                ->where('draft', '=', '1')
                    ->where('views', '>', '5')
                    ->orderBy('created_at', 'DESC')
                    ->get();
                //  $latest_videos = Video::where('status', '=', '1')->take(10)->orderBy('created_at', 'DESC')->get();
                $suggested_videos = Video::where('active', '=', '1')->where('views', '>', '5')
                    ->where('status', '=', '1')
                    ->where('draft', '=', '1')
                    ->orderBy('created_at', 'DESC')
                    ->get();
                $trending_movies = Movie::where('active', '=', '1')->where('status', '=', '1')
                    ->where('views', '>', '5')
                    ->orderBy('created_at', 'DESC')
                    ->get();
                $ppv_movies = PpvVideo::where('active', '=', '1')->where('status', '=', '1')
                    ->orderBy('created_at', 'DESC')
                    ->get();
                $latest_movies = Movie::where('active', '=', '1')->where('status', '=', '1')
                    ->take(10)
                    ->orderBy('created_at', 'DESC')
                    ->get();
                $trending_audios = Audio::where('active', '=', '1')->where('status', '=', '1')
                    ->where('views', '>', '5')
                    ->orderBy('created_at', 'DESC')
                    ->get();
                $latest_audios = Audio::where('active', '=', '1')->where('status', '=', '1')
                    ->take(10)
                    ->orderBy('created_at', 'DESC')
                    ->get();
                $trending_episodes = Episode::where('active', '=', '1')->where('views', '>', '0')
                    ->orderBy('created_at', 'DESC')
                    ->get();
                $latest_series = Series::where('active', '=', '1')->orderBy('created_at', 'DESC')
                    ->get();
                $trendings = new \Illuminate\Database\Eloquent\Collection; //Create empty collection which we know has the merge() method
                $trendings = $trendings->merge($trending_videos);
                $trendings = $trendings->merge($trending_movies);
                $trendings = $trendings->merge($trending_episodes);
                //  $featured_videos = Video::where('active', '=', '1')->where('featured', '=', '1')->orderBy('created_at', 'DESC')->get();
                $featured_episodes = Episode::where('active', '=', '1')->where('featured', '=', '1')
                    ->orderBy('views', 'DESC')
                    ->get();

                $pages = Page::all();
                if ($multiuser != null)
                {
                    $getcnt_watching = ContinueWatching::where('multiuser', $multiuser)->pluck('videoid')
                        ->toArray();
                    $cnt_watching = Video::with('cnt_watch')->whereIn('id', $getcnt_watching)->get();
                }
                elseif (!Auth::guest())
                {

                    $continue_watching = ContinueWatching::where('user_id', Auth::user()->id)
                        ->first();

                    if ($continue_watching != null && $continue_watching->multiuser == null)
                    {
                        $getcnt_watching = ContinueWatching::where('user_id', Auth::user()->id)
                            ->pluck('videoid')
                            ->toArray();
                        $cnt_watching = Video::with('cnt_watch')->whereIn('id', $getcnt_watching);
                        if ($getfeching != null && $getfeching->geofencing == 'ON')
                        {
                            $cnt_watching = $cnt_watching->whereNotIn('id', $blockvideos);
                        }
                        $cnt_watching = $cnt_watching->get();
                    }
                    else
                    {
                        $getcnt_watching = ContinueWatching::where('user_id', Auth::user()->id)
                            ->where('multiuser', 'data')
                            ->pluck('videoid')
                            ->toArray();
                        $cnt_watching = Video::with('cnt_watch')->whereIn('id', $getcnt_watching);
                        if ($getfeching != null && $getfeching->geofencing == 'ON')
                        {
                            $cnt_watching = $cnt_watching->whereNotIn('id', $blockvideos);
                        }
                        $cnt_watching = $cnt_watching->get();
                        //  $cnt_watching = Video::with('cnt_watch')->where('active', '=', '1')->whereIn('id',$getcnt_watching)->get();
                        
                    }

                }
                else
                {
                    $cnt_watching = '';
                }

                $currency = CurrencySetting::first();
                $livetreams_count = LiveStream::where('active', '=', '1')->orderBy('created_at', 'DESC')
                    ->count();
                if ($livetreams_count > 0)
                {
                    $livetreams = LiveStream::where('active', '=', '1')->orderBy('created_at', 'DESC')
                        ->get();
                }
                else
                {
                    $livetreams = [];
                }

                //  $currency->symbol
                //  dd($currency);
                $data = array(
                    'currency' => $currency,

                    'videos' => Video::where('active', '=', '1')->where('status', '=', '1')
                                    ->where('draft', '=', '1')
                                    ->orderBy('created_at', 'DESC')
                                    ->simplePaginate($this->videos_per_page) ,

                    'video_banners' => Video::where('active', '=', '1')
                                        ->where('draft', '=', '1')
                                        ->where('status', '=', '1')
                                        ->where('banner', '=', '1')
                                        ->orderBy('created_at', 'DESC')
                                        ->simplePaginate(130000) ,

                    'series_sliders' => Series::where('active', '=', '1')
                                        ->where('banner','=','1')
                                        ->latest()
                                        ->get() ,
                    
                    'live_banner' => LiveStream::where('banner', '=', '1')
                                        ->orderBy('created_at', 'DESC')
                                        ->simplePaginate(111111) ,

                    'sliders' => Slider::where('active', '=', '1')
                                        ->orderBy('order_position', 'ASC')
                                        ->get() ,
                    'latest_series' => $latest_series,
                    'cnt_watching' => $cnt_watching,
                    'trendings' => $trending_movies,
                    'latest_video' => $latest_videos,
                    'latest_videos' => $latest_videos,
                    'movies' => $trending_movies,
                    'latest_movies' => $latest_movies,
                    'ppv_movies' => $ppv_movies,
                    'trending_audios' => $trending_audios,
                    'latest_audios' => $latest_audios,
                    'featured_videos' => $featured_videos,
                    'featured_episodes' => $featured_episodes,
                    'current_page' => 1,
                    'genre_video_display' => $genre_video_display,
                    'genres' => VideoCategory::all() ,
                    'pagination_url' => '/videos',
                    'settings' => $settings,
                    'pages' => $pages,
                    'trending_videos' => $trending_videos,
                    'ppv_gobal_price' => $ppv_gobal_price,
                    'suggested_videos' => $suggested_videos,
                    'video_categories' => VideoCategory::all() ,
                    'home_settings' => HomeSetting::first() ,
                    'livetream' => LiveStream::where('active','=','1')->orderBy('created_at', 'DESC')->get() ,
                    'audios' => Audio::where('active', '=', '1')
                        ->orderBy('created_at', 'DESC')
                        ->get() ,
                    'albums' => AudioAlbums::orderBy('created_at', 'DESC')
                        ->get() ,
                    'most_watch_user' => $most_watch_user,
                    'top_most_watched' => $top_most_watched,
                    'Most_watched_country' => $Most_watched_country,
                    'countryName' => $countryName,
                    'preference_genres' => $preference_gen,
                    'preference_Language' => $preference_Lan,
                    'Family_Mode' => $Family_Mode,
                    'Kids_Mode' => $Kids_Mode,
                    'Mode' => $Mode,
                    'ThumbnailSetting' => $ThumbnailSetting,
                    'latest_series' => $latest_series,
                    'artist' => Artist::all(),
                    'VideoSchedules' => VideoSchedules::where('in_home',1)->get(),
                );
               
                return Theme::view('home', $data);
            }
        }
    }
    public function social()
    {
        return View::make('social');
    }
    public function ViewStripe(Request $request)
    {

        $stripe = new \Stripe\StripeClient('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');
        $stirpe_details = $stripe
            ->subscriptions
            ->retrieve('sub_Hzo5niEpDFNKMs', []);
        $stirpe_details = array(
            'stirpe_details' => $stirpe_details
        );
        return View::make('stripe_billing', $stirpe_details);
    }

    public function promotions()
    {
        $promotion = Page::where('slug', '=', 'promotion')->first();
        $data = array(
            "promotion" => $promotion
        );
        return View::make('promotions', $data);

    }

    public function VerifyRequest(Request $request)
    {
        session()->put('message',"Thanks, Your Account has been Submitted for Approval.");

        return Theme::view('emails.verify_request');

    }

    public function VerifyRequestNotsent(){

        return Theme::view('emails.Not_sent_verify_request');

    }

    public function PostcreateStep1(Request $request)
    {

        if ($request->has('ref'))
        {
            session(['referrer' => $request->query('ref') ]);
        }
        
        $SiteTheme = SiteTheme::first();
        if($SiteTheme->signup_theme == 1){

            $SignupMenu = \App\SignupMenu::first();
            if($SignupMenu->username == 1){
                $validatedData = $request->validate([
                    'username' =>  ['required', 'string'],
                ]);
            }
            
            if($SignupMenu->email == 1){
                $validatedData = $request->validate([
                    'email' =>  ['required', 'string', 'email', 'unique:users'],
                ]);
            }
            if($SignupMenu->password == 1){
                $validatedData = $request->validate([
                    'password' => 'required|string|min:6|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
                ]);
            }
            if($SignupMenu->mobile == 1){
                $validatedData = $request->validate([
                    'mobile' => ['required', 'numeric', 'min:8', 'unique:users'],
                ]);
            }
            if($SignupMenu->password_confirm == 1){
                $validatedData = $request->validate([
                    'password_confirmation' => 'required',
                ]);
            }
        }else{
        // dd('testone');

            $validatedData = $request->validate(
                [   'username' => ['required', 'string'], 
                    'email' => ['required', 'string', 'email', 'unique:users'],
                    'password' => 'required|string|min:6|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
                    'mobile' => ['required', 'numeric', 'min:8', 'unique:users'],
                    'password_confirmation' => 'required',
                    'g-recaptcha-response' => get_enable_captcha() == 1 ? 'required|captcha' : '',
                 ]);
        }
        

        $free_registration = FreeRegistration();
        $length = 10;
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $ref_token = substr(str_shuffle(str_repeat($pool, 5)) , 0, $length);

        $email = $request->get('email');
        $name = $request->get('username');
        $ccode = $request->get('ccode');
        $mobile = $request->get('mobile');
        $get_password = $request->get('password');
        $path = public_path() . '/uploads/avatars/';
        $logo = $request->file('avatar');
        if ($logo != '')
        {
            //code for remove old file
            if ($logo != '' && $logo != null)
            {
                $file_old = $path . $logo;
                if (file_exists($file_old))
                {
                    unlink($file_old);
                }
            }

            $file = $logo;
            $avatar = $file->getClientOriginalName();
            $file->move($path, $avatar);

        }
        else
        {
            $avatar = 'default.png';
        }

        $referrer_code = $request->get('referrer_code');
        $ExpireDate = Date('d-m-Y', strtotime('+3 days'));

        if (isset($referrer_code) && !empty($referrer_code))
        {
            $referred_user = User::where('referral_token', '=', $referrer_code)->first();
            $referred_user_id = $referred_user->id;
            $coupon_expired = $ExpireDate;
        }
        else
        {
            $referred_user_id = null;
            $coupon_expired = '';
        }
        $settings = Setting::first();
        if($settings->activation_email == 1){
       

            $email_count = User::where('email', '=', $email)->count();
            $string = Str::random(60);
            if ($email_count == 0)
            {
                $new_user = new User();
                $new_user->name = $name;
                $new_user->username = $name;
                $new_user->mobile = $mobile;
                $new_user->ccode = $ccode;
                $new_user->avatar = $avatar;
                $new_user->role = 'registered';
                $new_user->referral_token = $ref_token;
                $new_user->referrer_id = $referred_user_id;
                $new_user->coupon_expired = $coupon_expired;
                $new_user->email = $email;
                //   $new_user->password = $get_password;
                $new_user->password = Hash::make($get_password);
                $new_user->activation_code = $string;
                $new_user->save();
                $settings = Setting::first();

                // verify email
                try {
                    \Mail::send('emails.verify', array(
                        'activation_code' => $string,
                        'website_name' => $settings->website_name
                    ) , function ($message) use ($request)
                    {
                        $message->to($request->email, $request->name)
                            ->subject('Verify your email address');
                    });
                    
                    $email_log      = 'Mail Sent Successfully from Verify';
                    $email_template = "verify";
                    $user_id = $new_user->id;
        
                    Email_sent_log($user_id,$email_log,$email_template);

                    return redirect('/verify-request');

               } catch (\Throwable $th) {
        
                    $email_log      = $th->getMessage();
                    $email_template = "verify";
                    $user_id = $new_user->id;
        
                    Email_notsent_log($user_id,$email_log,$email_template);

                    return redirect('/verify-request-sent');

               }

            
            // welcome Email

                try {

                    $data = array(
                        'email_subject' =>  EmailTemplate::where('id',1)->pluck('heading')->first() ,
                    );

                    Mail::send('emails.welcome', array(
                        'username' => $name,
                        'website_name' => GetWebsiteName(),
                        'url' => URL::to('/'),
                        'useremail' => $email,
                        'password' => $get_password,
                    ), 
                    function($message) use ($data,$request) {
                        $message->from(AdminMail(),GetWebsiteName());
                        $message->to($request->email, $request->name)->subject($data['email_subject']);
                    });
        
                    $email_log      = 'Mail Sent Successfully from Welcome E-Mail';
                    $email_template = "1";
                    $user_id = $new_user->id;
        
                    Email_sent_log($user_id,$email_log,$email_template);
        
                }catch (\Exception $e) {
        
                    $email_log      = $e->getMessage();
                    $email_template = "1";
                    $user_id = $new_user->id;
        
                    Email_notsent_log($user_id,$email_log,$email_template);
        
                }

            }
        }else{

            $email_count = User::where('email', '=', $email)->count();
      

            $string = Str::random(60);
            if ($email_count == 0)
            {
                $new_user = new User();
                $new_user->name = $name;
                $new_user->username = $name;
                $new_user->mobile = $mobile;
                $new_user->ccode = $ccode;
                $new_user->avatar = $avatar;
                $new_user->role = 'registered';
                $new_user->referral_token = $ref_token;
                $new_user->referrer_id = $referred_user_id;
                $new_user->coupon_expired = $coupon_expired;
                $new_user->email = $email;
                $new_user->password = Hash::make($get_password);
                $new_user->activation_code = null;
                $new_user->active = 1;
                $new_user->save();

                 // welcome Email
                
                try {

                    $data = array(
                        'email_subject' =>  EmailTemplate::where('id',1)->pluck('heading')->first() ,
                    );

                    Mail::send('emails.welcome', array(
                        'username' => $name,
                        'website_name' => GetWebsiteName(),
                        'url' => URL::to('/'),
                        'useremail' => $email,
                        'password' => $get_password,
                    ), 
                    function($message) use ($data,$request) {
                        $message->from(AdminMail(),GetWebsiteName());
                        $message->to($request->email, $request->name)->subject($data['email_subject']);
                    });
        
                    $email_log      = 'Mail Sent Successfully from Welcome E-Mail';
                    $email_template = "1";
                    $user_id = $new_user->id;
        
                    Email_sent_log($user_id,$email_log,$email_template);
        
                }catch (\Exception $e) {
        
                    $email_log      = $e->getMessage();
                    $email_template = "1";
                    $user_id = $new_user->id;
        
                    Email_notsent_log($user_id,$email_log,$email_template);
        
                }
                session()->put('register.email',$email);
                return redirect('/register2')->with('message', 'You have successfully verified your account. Please login below.');
            }
        }
    }

    public function SignUpVerify()
    {
        return view('register.verify', compact('register'));
    }

    public function ViewReferral(Request $request)
    {
        return view('view_referrer');
    }

    public function search(Request $request)
    {

        if ($request->ajax())
        {

            $videos = Video::Select('videos.*','categoryvideos.category_id','categoryvideos.video_id','video_categories.name as category_name')
                           ->Join('categoryvideos','categoryvideos.video_id','=','videos.id')
                           ->Join('video_categories','video_categories.id','=','categoryvideos.category_id')
                           ->orwhere('videos.search_tags', 'LIKE', '%' . $request->country . '%')
                           ->orwhere('videos.title', 'LIKE', '%' . $request->country . '%')
                           ->orwhere('video_categories.name', 'LIKE', '%' . $request->country . '%')
                           ->where('active', '=', '1')
                           ->where('status', '=', '1')
                           ->where('draft', '=', '1')
                           ->orderBy('created_at', 'desc')
                           ->groupBy('videos.id')
                           ->limit('10');

                           if(Geofencing() !=null && Geofencing()->geofencing == 'ON'){
                                $videos = $videos  ->whereNotIn('videos.id',Block_videos());
                            }

                           $videos = $videos->get();


            $livestream = LiveStream::Select('live_streams.*','livecategories.live_id','live_categories.name')
                            ->Join('livecategories','livecategories.live_id','=','live_streams.id')
                            ->Join('live_categories','live_categories.id','=','livecategories.category_id')
                            ->orwhere('live_streams.search_tags', 'LIKE', '%' . $request->country . '%')
                            ->orwhere('live_streams.title', 'LIKE', '%' . $request->country . '%')
                            ->orwhere('live_categories.name', 'LIKE', '%' . $request->country . '%')           
                            ->where('live_streams.active', '=', '1')
                            // ->where('status', '=', '1')
                            ->limit('10')
                            ->groupBy('live_streams.id')
                            ->get();

            $audio = Audio::orwhere('search_tags', 'LIKE', '%' . $request->country . '%')
                            ->orwhere('audio.title', 'LIKE', '%' .$request->country . '%')
                            ->where('active', '=', '1')
                            ->where('status', '=', '1')
                            ->limit('10')
                            ->get();

            $Episode = Episode::Select('episodes.*','series.id','series_categories.category_id','video_categories.name as Category_name')
                            ->Join('series','series.id','=','episodes.series_id')
                            ->Join('series_categories','series_categories.series_id','=','series.id')
                            ->Join('video_categories','video_categories.id','=','series_categories.category_id')
                            ->orwhere('episodes.search_tags', 'LIKE', '%' . $request->country . '%')
                            ->orwhere('episodes.title', 'LIKE', '%' . $request->country . '%')
                            ->orwhere('video_categories.name', 'LIKE', '%' . $request->country . '%')           
                            ->where('episodes.active', '=', '1')
                            ->where('episodes.status', '=', '1')
                            ->groupBy('episodes.id')
                            ->limit('10')
                            ->get(); 
                            
            $Series = Series::Select('series.*','series_categories.category_id','video_categories.name as Category_name')
                            ->Join('series_categories','series_categories.series_id','=','series.id')
                            ->Join('video_categories','video_categories.id','=','series_categories.category_id')
                            ->orwhere('series.search_tag', 'LIKE', '%' . $request->country . '%')
                            ->orwhere('series.title', 'LIKE', '%' . $request->country . '%')
                            ->orwhere('video_categories.name', 'LIKE', '%' . $request->country . '%')           
                            ->where('series.active', '=', '1')
                            ->groupBy('series.id')
                            ->limit('10')
                            ->get();  

            if (count($videos) > 0 || count($livestream) > 0 || count($Episode) > 0 || count($audio) > 0 || count($Series) > 0 && !empty($request->country) )
            {

                // videos Search
                    if(count($videos) > 0){
                        $output = '<ul class="list-group" style="display: block; position: relative; z-index: 999999;;margin-bottom: 0;border-radius: 0;background:#000;">';
                        $output .= "<h6 style='margin: 0;text-align: left;padding: 10px;'> Videos</h6>";
                        foreach ($videos as $row)
                        {
                            $output .= '<li class="list-group-item">
                            <img width="35px" height="35px" src="' . URL::to('/') . '/public/uploads/images/' . $row->image . '"><a href="' . URL::to('/') . '/category/videos/' . $row->slug . '" style="font-color: #c61f1f00;color: #000;text-decoration: none;">' . $row->title . '</a></li>';
                        }

                    }else{
                        $output  = null ;
                    }

                // livestream Search
                    if(count($livestream) > 0){

                        $livestreams = '<ul class="list-group" style="display: block; position: relative; z-index: 999999;;margin-bottom: 0;border-radius: 0;background: rgba(20, 20, 20, 0.5);">';
                        $livestreams .= "<h6 style='margin: 0;text-align: left;padding: 10px;'> Live Videos</h6>";
                        foreach ($livestream as $row)
                        {
                            $livestreams .= '<li class="list-group-item">
                            <img width="35px" height="35px" src="' . URL::to('/') . '/public/uploads/images/' . $row->image . '"><a href="' . URL::to('/') . '/live' .'/'. $row->slug . '" style="font-color: #c61f1f00;color: #000;text-decoration: none;">' . $row->title . '</a></li>';
                        }
                    }
                    else{
                        $livestreams = null ;
                    }

                // Audio Search

                    if(count($audio) > 0){
                        $audios = '<ul class="list-group" style="display: block; position: relative; z-index: 999999;;margin-bottom: 0;border-radius: 0;background: rgba(20, 20, 20, 0.8);">';
                        $audios .= "<h6 style='margin: 0;text-align: left;padding: 10px;'> Audio </h6>";
                        foreach ($audio as $row)
                        {
                            $audios .= '<li class="list-group-item">
                            <img width="35px" height="35px" src="' . URL::to('/') . '/public/uploads/images/' . $row->image . '"><a href="' . URL::to('/') . '/audio/' . $row->slug . '" style="font-color: #c61f1f00;color: #000;text-decoration: none;">' . $row->title . '</a></li>';
                        }
                    }
                    else{
                        $audios = null ;
                    }

                // Episode

                    if(count($Episode) > 0){
                        $Episodes = '<ul class="list-group" style="display: block; position: relative; z-index: 999999;;margin-bottom: 0;border-radius: 0;background: rgba(20, 20, 20, 0.8);">';
                        $Episodes .= "<h6 style='margin: 0;text-align: left;padding: 10px;'> Episode </h6>";
                        foreach ($Episode as $row)
                        {  
                            if( $row->slug != null ){

                                $series_slug = Series::where('id',$row->series_id)->pluck('slug')->first();
                                $Episodes .= '<li class="list-group-item">
                                <img width="35px" height="35px" src="' . URL::to('/') . '/public/uploads/images/' . $row->image . '"><a href="' . URL::to('/') . '/episode' .'/'. $series_slug . '/'. $row->slug . '" style="font-color: #c61f1f00;color: #000;text-decoration: none;">' . $row->title . '</a></li>';
                            }
                        }
                    }
                    else{
                        $Episodes = null ;
                    }

                // Series Search

                if(count($Series) > 0){

                    $Series_search = '<ul class="list-group" style="display: block; position: relative; z-index: 999999;;margin-bottom: 0;border-radius: 0;background: rgba(20, 20, 20, 0.8);">';
                    $Series_search .= "<h6 style='margin: 0;text-align: left;padding: 10px;'> Series Videos</h6>";
                    foreach ($Series as $row)
                    {
                        $Series_search .= '<li class="list-group-item">
                        <img width="35px" height="35px" src="' . URL::to('/') . '/public/uploads/images/' . $row->image . '"><a href="' . URL::to('/') . '/play_series' .'/'. $row->slug . '" style="font-color: #c61f1f00;color: #000;text-decoration: none;">' . $row->title . '</a></li>';
                    }
                }
                else{
                    $Series_search = null ;
                }

                return $output.$audios.$livestreams.$Episodes.$Series_search;
            }
            else
            {
                $output = '<li class="list-group-item">' . 'No results' . '</li>';

                return $output;
            }

        }
    }

    public function SendOTP(Request $request, \Nexmo\Client $nexmo)
    {
        $mobile = $request->get('mobile');
        $request->session()
            ->put('mobile', $mobile);
        $rcode = $request->get('ccode');
        $request->session()
            ->put('mobile_ccode', $rcode);
        $request->session()
            ->put('mobile_number', $mobile);

        $guest_email = $request->session()
            ->get('register.email');

        $ccode = $rcode;
        $pin = mt_rand(100000, 999999);
        $string = str_shuffle($pin);
        $mobile_number = $ccode . $mobile;
        $user_count = VerifyNumber::where('number', '=', $mobile_number)->count();
        $user_mobile_exist = User::where('email', '!=', $email)->where('mobile', '=', $mobile)->count();
        $user_id = VerifyNumber::where('number', '=', $mobile_number)->first();

        $basic = new \Nexmo\Client\Credentials\Basic('8c2c8892', '05D2vuG2VbYw2tQZ');
        $client = new \Nexmo\Client($basic);

        if ($user_mobile_exist > 0)
        {

            return response()->json(['status' => false, 'message' => 'This number already Exist, try with another number']);

        }
        elseif ($user_count > 0)
        {
            $user = VerifyNumber::find($user_id->id);
            $user->otp = $string;
            $user->number = $ccode . $mobile;
            $user->save();
            //                        $nexmo->message()->send([
            //                                        'to' => $ccode.$mobile,
            //                                        'from' => '916381673242',
            //                                        'text' => 'Your Login OTP is'.$string
            //                        ]);
            $verification = $client->verify()
                ->start(['number' => $ccode . $mobile, 'brand' => 'Flicknexs ', 'code_length' => '4']);

            $verification_id = $verification->getRequestId();

            //                $mails =  $guest_email;
            //                \Mail::send('emails.sms', array(
            //                            'otp' => $string
            //                ), function($message) use ($mails){
            //                            $message->from(AdminMail(),'Flicknexs');
            //                            $message->to($mails, "User")->subject('Verification OTP');
            //                        });
            return response()
                ->json(['status' => true, 'verify' => $verification_id, 'message' => 'OTP has been sent to your number and Your Mail', 'mobile' => $mobile_number]);

        }
        else
        {
            $user = new VerifyNumber;
            $user->otp = $string;
            $user->number = $ccode . $mobile;
            $user->save();
            //                        $nexmo->message()->send([
            //                                        'to' => $ccode.$mobile,
            //                                        'from' => '916381673242',
            //                                        'text' => 'Your Login OTP is'.$string
            //                        ]);
            $verification = $client->verify()
                ->start(['number' => $ccode . $mobile, 'brand' => 'Flicknexs ', 'code_length' => '4']);

            $verification_id = $verification->getRequestId();

            return response()
                ->json(['status' => true, 'verify' => $verification_id, 'message' => 'OTP has been sent to your number and Your Mail', 'mobile' => $mobile_number]);

        }
    }

    //    public function SendOTP(Request $request, \Nexmo\Client $nexmo)
    //    {
    //        $mobile = $request->get('mobile');
    //        $pin = mt_rand(100000, 999999);
    //
    //        $string = str_shuffle($pin);
    //        $user_count = User::where('mobile','=',$mobile)->count();
    //        if ( $user_count > 0 ){
    //
    //            $user = User::where('mobile','=',$mobile)->first();
    //            $user->otp = $string;
    //            $user->save();
    //
    //            $response = $nexmo->message()->send([
    //                    'to' => "91".$mobile,
    //                    'from' => '916381673242',
    //                    'text' => 'Your Login OTP is'.$string
    //                ]);
    //
    //
    //
    //
    //            $data = array(
    //                'mobile'=>$mobile
    //            );
    //
    //            return View('auth.otp',$data);
    //
    //        } else {
    //
    //             return Redirect::back()->withErrors('Invalid Number');
    //        }
    //
    //     }
    public function mobileLogin()
    {

        return View('auth.mobile-login');
    }

    public function Featured_videos(Request $request)
    {
        $ThumbnailSetting = ThumbnailSetting::first();
        $currency = CurrencySetting::first();
        $PPV_settings = Setting::where('ppv_status', '=', 1)->first();

        $ppv_gobal_price = !empty($PPV_settings ) ? $PPV_settings->ppv_price :  null;

        $multiuser = Session::get('subuser_id');
             
        $Mode = $multiuser != null ?  Multiprofile::where('id', $multiuser)->first() : User::where('id', Auth::User()->id)->first();
           
        $check_Kidmode = $Mode['user_type'] != null && $Mode['user_type'] == "Kids" ? 1 : 0 ;


        $featured_videos = Video::where('videos.active', '=', '1')->where('videos.status', '=', '1')
                             ->where('videos.draft', '=', '1')->where('videos.featured','=','1');

            if(Geofencing() !=null && Geofencing()->geofencing == 'ON'){
                $featured_videos = $featured_videos  ->whereNotIn('videos.id',Block_videos());
            }
            
            if( $check_Kidmode == 1 )
            {
                $featured_videos = $featured_videos->whereBetween('videos.age_restrict', [ 0, 12 ]);
            }

        $featured_videos = $featured_videos->orderBy('videos.created_at','desc')->limit(50)->paginate($this->videos_per_page);

        $data = array(
            'featured_videos' => $featured_videos,
            'ppv_gobal_price' => $ppv_gobal_price,
            'currency' => $currency,
            'ThumbnailSetting' => $ThumbnailSetting,
        );

        return Theme::view('featured', $data);
    }

    public function LatestVideos()
    {
        $settings = Setting::first();

        if($settings->enable_landing_page == 1 && Auth::guest()){

            $landing_page_slug = AdminLandingPage::where('status',1)->pluck('slug')->first() ? AdminLandingPage::where('status',1)->pluck('slug')->first() : "landing-page" ;

            return redirect()->route('landing_page', $landing_page_slug );
        }

        $multiuser = Session::get('subuser_id');

        if(!Auth::guest()):
             
            $Mode = $multiuser != null ?  Multiprofile::where('id', $multiuser)->first() : User::where('id', Auth::User()->id)->first();
        else:

            $Mode['user_type'] = null ;
        endif;

           
        $check_Kidmode = $Mode['user_type'] != null && $Mode['user_type'] == "Kids" ? 1 : 0 ;


        $latest_videos_count = Video::where('active', '=', '1')->where('status', '=', '1')
                                ->where('draft', '=', '1')->latest()->count();

        if ($latest_videos_count > 0)
        {
            $latest_videos = Video::where('active', '=', '1')->where('status', '=', '1')
                ->where('draft', '=', '1')->latest();

                if (Geofencing() != null && Geofencing()->geofencing == 'ON')
                {
                    $latest_videos = $latest_videos->whereNotIn('videos.id', Block_videos());
                }

                if( $check_Kidmode == 1 )
                {
                    $latest_videos = $latest_videos->whereBetween('videos.age_restrict', [ 0, 12 ]);
                }
                
            $latest_videos = $latest_videos->limit(50)->paginate($this->videos_per_page);
        }
        else
        {
            $latest_videos = array();
        }

        $settings = Setting::first();
        $PPV_settings = Setting::where('ppv_status', '=', 1)->first();
        $ppv_gobal_price = !empty($PPV_settings) ? $PPV_settings->ppv_price : null;
       
        $data = array(
            'latest_videos'    => $latest_videos,
            'ppv_gobal_price'  => $ppv_gobal_price,
            'currency'         => CurrencySetting::first(),
            'ThumbnailSetting' => ThumbnailSetting::first(),
        );

        return Theme::view('latestvideo',['latestvideo'=>$data]);
    }

    public function ScheduledVideo()
    {

        $ThumbnailSetting = ThumbnailSetting::first();

        $date = \Carbon\Carbon::today()->subDays(30);
      
        $settings = Setting::first();
    
        $currency = CurrencySetting::first();

        $data = array(
            'currency' => $currency,
            'ThumbnailSetting' => $ThumbnailSetting,
            'Video_Schedules' => VideoSchedules::where('in_home',1)->get(),
        );

        return Theme::view('VideoSchedule',$data);

    }

    public function LanguageVideo($lanid, $lan)
    {

        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
        $userIp = $geoip->getip();
        $countryName = $geoip->getCountry();
        $regionName = $geoip->getregion();
        $cityName = $geoip->getcity();
        $ThumbnailSetting = ThumbnailSetting::first();


        $getfeching = Geofencing::first();

        $block_videos = BlockVideo::where('country_id', $countryName)->get();
        if (!$block_videos->isEmpty())
        {
            foreach ($block_videos as $block_video)
            {
                $blockvideos[] = $block_video->video_id;
            }
        }
        else
        {
            $blockvideos[] = '';
        }

        $language_videos = Video::join('languagevideos', 'languagevideos.video_id', '=', 'videos.id')
        ->where('language_id', '=', $lanid)->where('active', '=', '1')->where('status', '=', '1')
        ->where('draft', '=', '1');

        if ($getfeching != null && $getfeching->geofencing == 'ON')
        {
            $language_videos = $language_videos->whereNotIn('videos.id', $blockvideos);
        }
        $language_videos = $language_videos->orderBy('videos.created_at','desc')->get();

        $currency = CurrencySetting::first();

        $data = array(
            'lang_videos' => $language_videos,
            'currency' => $currency,
            'ThumbnailSetting' => $ThumbnailSetting

        );


        return Theme::View('languagevideo', $data);
    }

    public function StripeSubscription(Request $request)
    {

        $user = Auth::user();
        $subscriptions = Subscription::where('user_id', $user->id)
            ->first();
        if ($subscriptions != null)
        {
            if ($request->payment_method == "Stripe")
            {
                // dd($request->payment_method);

                $plans = SubscriptionPlan::where('plans_name', '=', $request->modal_plan_name)
                    ->where('type', '=', $request->payment_method)
                    ->first();

                $request->session()
                    ->put('planname', $request->modal_plan_name);
                $request->session()
                    ->put('plan_id', $plans->plan_id);
                $request->session()
                    ->put('payment_type', $plans->payment_type);
                $register = $request->session()
                    ->get('register');
                $plan_name = $request->get('register.email');

                $user = Auth::user();
                $plan_name = $plans->plan_id;

                $request->session()
                    ->put('become_plan', $plans->plan_id);
                if (!empty($plans->plan_id))
                {
                    $plan_id = $plans->plan_id;
                }
                else
                {
                    $plan_id = $plans->plan_id;
                }
                $data = array(
                    'plan_name' => $plan_id
                );
                return Theme::view('register.become_subscription', ['intent' => $user->createSetupIntent() ]);

            }
            elseif ($request->payment_method == "PayPal")
            {

                $plans = SubscriptionPlan::where('plans_name', '=', $request->modal_plan_name)
                    ->where('type', '=', $request->payment_method)
                    ->first();
                $request->session()
                    ->put('planname', $request->modal_plan_name);
                $request->session()
                    ->put('plan_id', $plans->plan_id);
                $request->session()
                    ->put('payment_type', $plans->payment_type);
                $request->session()
                    ->put('days', $plans->days);
                $request->session()
                    ->put('price', $plans->price);
                $request->session()
                    ->put('user_id', $plans->user_id);

                $register = $request->session()
                    ->get('register');
                $plan_name = $request->get('register.email');

            }
            elseif($request->payment_method == "Razorpay"){

                $plans = SubscriptionPlan::where('plans_name', '=', $request->modal_plan_name)
                    ->where('type', '=', $request->payment_method)
                    ->first();

                    $PlanId =Crypt::encryptString($plans->plan_id);
                    return Redirect::route('RazorpayIntegration',$PlanId);
            }
        }
        else
        {
            //
            $plan_details = SubscriptionPlan::where('plans_name', '=', $request->modal_plan_name)
                ->where('type', '=', $request->payment_method)
                ->first();


            if($plan_details['type'] == "Razorpay"){
                $PlanId =Crypt::encryptString($plan_details->plan_id);
                return Redirect::route('RazorpayIntegration',$PlanId);
            }

            $request->session()
                ->put('planname', $request->modal_plan_name);
            $request->session()
                ->put('plan_id', $plan_details->plan_id);
            $request->session()
                ->put('payment_type', $plan_details->payment_type);
            $register = $request->session()
                ->get('register');
            $plan_name = $request->get('register.email');

            $user = Auth::user();
            $plan_name = $plan_details->plan_id;

            $request->session()
                ->put('become_plan', $plan_details->plan_id);
            //     if(!empty($plans->plan_id)){
            //        $plan_id = $plans->plan_id;
            //     }else{
            //         $plan_id = $plans->plan_id;
            //     }
            // $data = array(
            //     'plan_name' => $plan_id
            // );
            $plan_id = $plan_details->modal_plan_name;
            // $plan_details = Plan::where("plan_id","=",$plan_id)->first();
            $payment_type = $plan_details->payment_type;
            // dd($plan_id);
            $user = Auth::user();
            if ($plan_details->payment_type == "recurring")
            {
                if ($user->stripe_id == NULL)
                {
                    $stripeCustomer = $user->createAsStripeCustomer();
                }
                $response = array(
                    "plans_details" => $plan_details,
                    "plan_id" => $plan_id,
                    "payment_type" => $plan_details->payment_type
                );
                return view('register.upgrade.stripe_upgrade', ['intent' => $user->createSetupIntent() ], $response);
            }
            else
            {
                if ($user->stripe_id == NULL)
                {
                    $stripeCustomer = $user->createAsStripeCustomer();
                }
                $response = array(
                    "plans_details" => $plan_details,
                    "plan_id" => $plan_id,
                    "payment_type" => $plan_details->payment_type
                );
                return Theme::view('register.upgrade.stripe', ['intent' => $user->createSetupIntent() ], $response);
            }
            // dd($subscriptions->id);
            
        }

    }

    public function verifyOtp(Request $request)
    {

        $otp = $request->get('otp');
        $mobile = $request->get('number');
        $verify_id = $request->get('verify_id');
        $user_count = VerifyNumber::where('number', '=', $mobile)->where('otp', '=', $otp)->count();
        $basic = new \Nexmo\Client\Credentials\Basic('8c2c8892', '05D2vuG2VbYw2tQZ');
        $client = new \Nexmo\Client($basic);

        $request_id = $verify_id;
        $verification = new \Nexmo\Verify\Verification($request_id);
        $result = $client->verify()
            ->check($verification, $otp);

        return response()->json(['status' => true, 'message' => 'Your Mobile number Verification is Success', ]);

    }
    public function stripes(Request $request)
    {
        $user = Auth::User();

        if ($user->stripe_id == NULL)
        {
            $stripeCustomer = $user->createAsStripeCustomer();

        }
        $plan_name = $request->get('plan_name');
        $request->session()
            ->put('become_plan', $plan_name);
        return view('register.become', ['intent' => $user->createSetupIntent() , compact('data') ]);

    }

    public function PaypalSubscription(Request $request)
    {
        $plan_id = $request->get('plan_id');
        $plan_details = SubscriptionPlan::where('plan_id', '=', $plan_id)->first();

        $data = array(
            'plan_name' => $plan_details->name,
            'plan_price' => $plan_details->price,
            'plan_id' => $plan_details->plan_id
        );
        return view('register.paypal_subscription', $data);
    }

    public function ViewTrasaction()
    {

        return view('paypal_billing');
    }

    public function ViewStripeTrasaction()
    {

        return view('stripe_transactions');
    }

    public function CancelPaypal(Request $request)
    {

        $subscription_id = Auth::user()->paypal_id;
        $user = Auth::user();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.paypal.com/v1/billing/subscriptions/' . $subscription_id . '/cancel');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = GetAccessToken();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch))
        {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        \Mail::send('emails.paypal_cancel', array(
            'name' => $user->username
        ) , function ($message) use ($user)
        {
            $message->from(AdminMail() , GetWebsiteName());
            $message->to($user->email, $user->username)
                ->subject('Subscription Renewal');
        });
        return redirect('/paypal/billings-details');

    }

    public function ViewPaypal()
    {
        $subscription_id = Auth::user()->paypal_id;
        $url = "https://api.paypal.com/v1/billing/subscriptions/" . $subscription_id;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $headers = array(
            "Content-Type: application/json",
            GetAccessToken() ,
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $resp = curl_exec($curl);
        curl_close($curl);
        $json = json_decode($resp);
        $status = $json->status;

        //            echo "<pre>"; print_r($json);
        //            exit;
        if ($status == 'ACTIVE')
        {
            $date1 = gmdate('c');
            $date2 = $json
                ->billing_info->next_billing_time;
            $diff = abs(strtotime($date2) - strtotime($date1));
            $years = floor($diff / (365 * 60 * 60 * 24));
            $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
            $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

            $data = array(
                'status' => $status,
                'start_time' => $json->start_time,
                'next_billing_date' => $json
                    ->billing_info->next_billing_time,
                'remaining_days' => $days,
                'response' => $json,
                'plan_id' => $json->plan_id
            );

        }
        else
        {
            $data = array(
                'status' => $status,
                'start_time' => $json->start_time,
                'next_billing_date' => 0,
                'response' => $json,
                'remaining_days' => 0,
                'plan_id' => 0
            );
        }
        return view('current_billing', $data);
    }

    public function Restrict()
    {

        return view('blocked');
    }

    public function StoreWatching(Request $request)
    {
        $data = $request->all();
        if (Auth::user())
        {
            $user_id = Auth::user()->id;
            $video_id = $request->video_id;
            $duration = $request->duration;
            $currentTime = $request->currentTime;
            $watch_percentage = ($currentTime * 100 / $duration);
            $cnt = ContinueWatching::where("videoid", $video_id)->where("user_id", $user_id)->count();
            $get_cnt = ContinueWatching::where("videoid", $video_id)->where("user_id", $user_id)->first();
            if ($cnt > 0 && $get_cnt->watch_percentage >= "99")
            {
                ContinueWatching::where("videoid", $video_id)->where("user_id", $user_id)->delete();
            }
            if ($cnt == 0)
            {
                $video = new ContinueWatching;
                $video->videoid = $request->video_id;
                $video->user_id = $user_id;
                $video->currentTime = $request->currentTime;
                $video->watch_percentage = $watch_percentage;
                $video->save();
            }
            else
            {
                $cnt_watch = ContinueWatching::where("videoid", $video_id)->where("user_id", $user_id)->first();
                $cnt_watch->currentTime = $request->currentTime;
                $cnt_watch->watch_percentage = $watch_percentage;
                $cnt_watch->save();
            }
        }
    }

    public function LikeVideo(Request $request)
    {
        $video_id = $request->videoid;
        $like = $request->like;
        $user_id = $request->user_id;
        $video = LikeDisLike::where("video_id", "=", $video_id)->where("user_id", "=", $user_id)->get();
        $video_count = LikeDisLike::where("video_id", "=", $video_id)->where("user_id", "=", $user_id)->count();
        if ($video_count > 0)
        {
            $video_new = LikeDisLike::where("video_id", "=", $video_id)->where("user_id", "=", $user_id)->first();
            $video_new->liked = $like;
            $video_new->video_id = $video_id;
            $video_new->save();
            $response = array(
                'status' => true
            );
        }
        else
        {
            $video_new = new LikeDisLike;
            $video_new->video_id = $video_id;
            $video_new->user_id = $user_id;
            $video_new->liked = $like;
            $video_new->save();
            $response = array(
                'status' => true
            );
        }

    }

    public function DisLikeVideo(Request $request)
    {
        $user_id = $request->user_id;
        $video_id = $request->videoid;
        $dislike = $request->dislike;
        $d_like = Likedislike::where("video_id", $video_id)->where("user_id", $user_id)->count();

        if ($d_like > 0)
        {
            $new_vide_dislike = Likedislike::where("video_id", $video_id)->where("user_id", $user_id)->first();
            if ($dislike == 1)
            {
                $new_vide_dislike->user_id = $request->user_id;
                $new_vide_dislike->video_id = $video_id;
                $new_vide_dislike->liked = 0;
                $new_vide_dislike->disliked = 1;
                $new_vide_dislike->save();
                $response = array(
                    'status' => "disliked"
                );
            }
            else
            {
                $new_vide_dislike->user_id = $request->user_id;
                $new_vide_dislike->video_id = $video_id;
                $new_vide_dislike->disliked = 0;
                $new_vide_dislike->save();
                $response = array(
                    'status' => "liked"
                );
            }
        }
        else
        {
            $new_vide_dislike = new Likedislike;
            $new_vide_dislike->user_id = $request->user_id;
            $new_vide_dislike->video_id = $video_id;
            $new_vide_dislike->liked = 0;
            $new_vide_dislike->disliked = 1;
            $new_vide_dislike->save();
            $response = array(
                'status' => "disliked"
            );
        }
        return response()->json($response, 200);
    }

    public function Multipleprofile()
    {

        if(Auth::user() == null){
            return redirect::to('/login');
        }
        
        $enable_choose_profile =  Setting::pluck('enable_choose_profile')->first() ;

        if( $enable_choose_profile == 0 ){

            return redirect::to('/home');
        }

        $Website_name = Setting::first();
        $parent_id = Session::get('login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d');
        $subcriber_user = User::where('id', $parent_id)->first();

        $screen_image = ChooseProfileScene::pluck('choosenprofile_screen')->first();
        if (!empty($screen_image))
        {
            $screen = URL::to('public/uploads/avatars/' . $screen_image);
        }
        else
        {
            $screen = "";
        }
        $users = Multiprofile::where('parent_id', $parent_id)->get();

        $data = array(
            'users' => $users,
            'Website_name' => $Website_name,
            'screen' => $screen,
            'subcriber_user' => $subcriber_user,
            'multiuser_limit' => Setting::pluck('multiuser_limit')->first(),
            'sub_user_count'  => Multiprofile::where('parent_id', Auth::user()->id )->count(),
        );


        return Theme::view('Multipleprofile', $data);

    }

    public function subuser($id)
    {

        $session = Session::put('subuser_id', $id);
        return redirect::to('/home');

    }
    public function kidsMode(Request $request)
    {
        $Subuser = Session::get('subuser_id');

        if ($Subuser != null)
        {
            $User = Multiprofile::find($Subuser);
            $User->Kidsmode = $request->kids_mode;
            $User->FamilyMode = 0;
            $User->save();
        }
        else
        {
            $user_id = Auth::User()->id;
            $User = User::find($user_id);
            $User->Kidsmode = $request->kids_mode;
            $User->FamilyMode = 0;
            $User->save();
        }
        return $request->kids_mode;

    }

    public function FamilyMode(Request $request)
    {
        $Subuser = Session::get('subuser_id');

        if ($Subuser != null)
        {
            $User = Multiprofile::find($Subuser);
            $User->FamilyMode = $request->family_mode;
            $User->Kidsmode = 0;
            $User->save();
        }
        else
        {
            $user_id = Auth::User()->id;
            $User = User::find($user_id);
            $User->FamilyMode = $request->family_mode;
            $User->Kidsmode = 0;
            $User->save();

        }
        return $User;

    }

    public function FamilyModeOff(Request $request)
    {
        $Subuser = Session::get('subuser_id');

        if ($Subuser != null)
        {
            $User = Multiprofile::find($Subuser);
            $User->FamilyMode = $request->family_mode;
            $User->Kidsmode = 0;
            $User->save();
        }
        else
        {
            $user_id = Auth::User()->id;
            $User = User::find($user_id);
            $User->FamilyMode = $request->family_mode;
            $User->Kidsmode = 0;
            $User->save();

        }
        return $User;

    }
    public function KidsModeOff(Request $request)
    {
        $Subuser = Session::get('subuser_id');

        if ($Subuser != null)
        {
            $User = Multiprofile::find($Subuser);
            $User->Kidsmode = $request->kids_mode;
            $User->FamilyMode = 0;
            $User->save();
        }
        else
        {
            $user_id = Auth::User()->id;
            $User = User::find($user_id);
            $User->Kidsmode = $request->kids_mode;
            $User->FamilyMode = 0;
            $User->save();
        }
        return $request->kids_mode;

    }
    public function Movie_description()
    {

        $currency = CurrencySetting::first();
        $Recomended = HomeSetting::first();
        $home_settings = HomeSetting::first();

        $latest_videos = Video::where('status', '=', '1')->take(10)
        ->where('active', '=', '1')
        ->where('draft', '=', '1')
            ->orderBy('created_at', 'DESC')
            ->get();

        if (!Auth::guest())
        {
            $getcnt_watching = ContinueWatching::where('user_id', Auth::user()->id)
                ->pluck('videoid')
                ->toArray();
            $cnt_watching = Video::with('cnt_watch')->whereIn('id', $getcnt_watching)->get();
        }
        else
        {
            $cnt_watching = '';
        }

        $PPV_settings = Setting::where('ppv_status', '=', 1)->first();
        if (!empty($PPV_settings))
        {
            $ppv_gobal_price = $PPV_settings->ppv_price;
        }
        else
        {
            $ppv_gobal_price = null;
        }

        $data = array(
            'ppv_gobal_price' => $ppv_gobal_price,
            'currency' => $currency,
            'latest_videos' => $latest_videos,
            'home_settings' => $home_settings,
            'cnt_watching' => $cnt_watching,
        );

        return Theme::view('movie_description', $data);
    }

    public function ThemeModeSave(Request $request)
    {

        if($request->input('mode') == 'true'){
            $theme_modes = "light";
        }
        elseif($request->input('mode') == 'false'){
            $theme_modes = "dark";
        }

        $theme_mode = SiteTheme::first();
        $theme_mode->theme_mode =  $theme_modes;
        $theme_mode->update();

        return $theme_modes;
      
    }

    public function myTestAddToLog()
    {
        \LogActivity::addToLog('My Testing Add To Log.');
    }

    public function logActivity()
    {
        $logs = \LogActivity::logActivityLists();
        return view('admin.logActivity',compact('logs'));
    }

    public function searchResult(Request $request)
    {
        try {

            if($request->search != null  || $request->search != " " ){

                return redirect()->back()->withErrors("Please! Enter the valid search data")->withInput();
            }
            
            $search_value = $request['search'];

            $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
            $userIp = $geoip->getip();
            $countryName = $geoip->getCountry();
            $regionName = $geoip->getregion();
            $cityName = $geoip->getcity();
            
            $getfeching = Geofencing::first();

            $block_videos = BlockVideo::where('country_id', $countryName)->get();
            if (!$block_videos->isEmpty())
            {
                foreach ($block_videos as $block_video)
                {
                    $blockvideos[] = $block_video->video_id;
                }
            }
            else
            {
                $blockvideos[] = '';
            }


            // $ppv_videos_count = PpvVideo::where('title', 'LIKE', '%' . $search_value . '%')->count();

            // $video_category_count = VideoCategory::where('name', 'LIKE', '%' . $search_value . '%')->count();

            // $ppv_category_count = PpvCategory::where('name', 'LIKE', '%' . $search_value . '%')->count();

        

            // if ($ppv_videos_count > 0)
            // {

            //     $ppv_videos = Video::where('title', 'LIKE', '%' . $search_value . '%')->orderBy('created_at', 'desc')
            //         ->paginate(9);

            // }
            // else
            // {
            //     $ppv_videos = 0;
            // }

            // if ($video_category_count > 0)
            // {
            //     $video_category = Video::select("videos.*")
            //     ->join("categoryvideos", "categoryvideos.video_id", "=", "videos.id")
            //     ->join("video_categories", "video_categories.id", "=", "categoryvideos.category_id")
            //     ->where('video_categories.name', 'LIKE', '%' . $search_value . '%')
            //     ->orderBy('created_at', 'desc')
            //     ->paginate(9);
            // }
            // else
            // {
            //     $video_category = 0;
            // }

            // if ($ppv_category_count > 0)
            // {

            //     $ppv_category = PpvCategory::where('name', 'LIKE', '%' . $search_value . '%')->orderBy('created_at', 'desc')
            //         ->paginate(9);

            // }
            // else
            // {
            //     $ppv_category = 0;
            // }

            // Latest videos

            $latest_videos  = Video::Select('videos.*','categoryvideos.category_id','categoryvideos.video_id','video_categories.name as category_name')
                               ->Join('categoryvideos','categoryvideos.video_id','=','videos.id')
                               ->Join('video_categories','video_categories.id','=','categoryvideos.category_id')
                               ->orwhere('videos.search_tags', 'LIKE', '%' . $search_value . '%')
                               ->orwhere('videos.title', 'LIKE', '%' . $search_value . '%')
                               ->orwhere('video_categories.name', 'LIKE', '%' . $search_value . '%')
                               ->where('active', '=', '1')
                               ->where('status', '=', '1')
                               ->where('draft', '=', '1')
                               ->orderBy('created_at', 'desc')
                               ->limit('10');

                               if(Geofencing() !=null && Geofencing()->geofencing == 'ON'){
                                   $latest_videos = $latest_videos  ->whereNotIn('videos.id',Block_videos());
                               }

            $latest_videos = $latest_videos->get();


            $latest_livestreams = LiveStream::Select('live_streams.*','livecategories.live_id','live_categories.name')
                                   ->Join('livecategories','livecategories.live_id','=','live_streams.id')
                                   ->Join('live_categories','live_categories.id','=','livecategories.category_id')
                                   ->orwhere('live_streams.search_tags', 'LIKE', '%' . $search_value . '%')
                                   ->orwhere('live_streams.title', 'LIKE', '%' . $search_value . '%')
                                   ->orwhere('live_categories.name', 'LIKE', '%' . $search_value . '%')           
                                   ->where('live_streams.active', '=', '1')
                                   // ->where('status', '=', '1')
                                   ->limit('10')
                                   ->groupBy('live_streams.id')
                                   ->get();


            $latest_audio = Audio::orwhere('search_tags', 'LIKE', '%' . $search_value . '%')
                                ->orwhere('audio.title', 'LIKE', '%' .$search_value . '%')
                                ->where('active', '=', '1')
                                ->where('status', '=', '1')
                                ->limit('10')
                                ->get();

            $latest_Episode =  Episode::Select('episodes.*','series.id','series_categories.category_id','video_categories.name as Category_name')
                                ->Join('series','series.id','=','episodes.series_id')
                                ->Join('series_categories','series_categories.series_id','=','series.id')
                                ->Join('video_categories','video_categories.id','=','series_categories.category_id')
                                ->orwhere('episodes.search_tags', 'LIKE', '%' . $search_value . '%')
                                ->orwhere('episodes.title', 'LIKE', '%' . $search_value . '%')
                                ->orwhere('video_categories.name', 'LIKE', '%' . $search_value . '%')           
                                ->where('episodes.active', '=', '1')
                                ->where('episodes.status', '=', '1')
                                ->groupBy('episodes.id')
                                ->limit('10')
                                ->get();   

            $latest_Series = Series::Select('series.*','series_categories.category_id','video_categories.name as Category_name')
                                ->Join('series_categories','series_categories.series_id','=','series.id')
                                ->Join('video_categories','video_categories.id','=','series_categories.category_id')
                                ->orwhere('series.search_tag', 'LIKE', '%' . $search_value . '%')
                                ->orwhere('series.title', 'LIKE', '%' . $search_value . '%')
                                ->orwhere('video_categories.name', 'LIKE', '%' . $search_value . '%')           
                                ->where('series.active', '=', '1')
                                ->groupBy('series.id')
                                ->limit('10')
                                ->get();   
                                
        // Most watched videos - TOP VIDEOS 
                    //  Important Note - Most view Not used (If Most view want to Use , then Category Search Want to work )  

            $Most_view_videos = RecentView::Join('videos','videos.id','=','recent_views.video_id')
                                ->orwhere('videos.search_tags', 'LIKE', '%' . $search_value . '%')
                                ->orwhere('videos.title', 'LIKE', '%' . $search_value . '%')
                                ->where('videos.active', '=', '1')
                                ->where('videos.status', '=', '1')
                                ->where('videos.draft', '=', '1')
                                ->groupBy('video_id')
                                ->limit('10')
                                ->latest('videos.created_at');
                                if ($getfeching != null && $getfeching->geofencing == 'ON')
                                {
                                    $Most_view_videos = $Most_view_videos->whereNotIn('videos.id', $blockvideos);
                                }
                                $Most_view_videos = $Most_view_videos->get();
                            

            $Most_view_audios = RecentView::Join('audio','audio.id','=','recent_views.audio_id')
                                ->orwhere('audio.search_tags', 'LIKE', '%' . $search_value . '%')
                                ->orwhere('audio.title', 'LIKE', '%' . $search_value . '%')
                                ->where('audio.active', '=', '1')
                                ->where('audio.status', '=', '1')
                                ->limit('10')
                                ->latest('audio.created_at')
                                ->groupBy('audio_id')
                                ->get();

            $Most_view_live   = RecentView::Join('live_streams','live_streams.id','=','recent_views.live_id')
                                ->orwhere('live_streams.search_tags', 'LIKE', '%' . $search_value . '%')
                                ->orwhere('live_streams.title', 'LIKE', '%' . $search_value . '%')
                                ->where('live_streams.active', '=', '1')
                                ->limit('10')
                                ->latest('live_streams.created_at')
                                ->groupBy('live_id')
                                ->get();

            $Most_view_episode  = RecentView::Join('episodes','episodes.id','=','recent_views.episode_id')
                                ->orwhere('episodes.search_tags', 'LIKE', '%' . $search_value . '%')
                                ->orwhere('episodes.title', 'LIKE', '%' . $search_value . '%')
                                ->where('episodes.active', '=', '1')
                                ->where('episodes.status', '=', '1')
                                ->limit('10')
                                ->latest('episodes.created_at')
                                ->groupBy('episode_id')
                                ->get();

            $Most_view_Series  = RecentView::select('series.*')
                                ->Join('episodes','episodes.id','=','recent_views.episode_id')
                                ->Join('series','series.id','=','episodes.series_id')
                                ->orwhere('series.search_tag', 'LIKE', '%' . $search_value . '%')
                                ->orwhere('series.title', 'LIKE', '%' . $search_value . '%')
                                ->where('series.active', '=', '1')
                                ->limit('20')
                                ->latest('series.created_at')
                                ->groupBy('series.id')
                                ->get();

            //  All videos 

            $videos_count = Video::Select('videos.*','categoryvideos.category_id','categoryvideos.video_id','video_categories.name as category_name')
                            ->Join('categoryvideos','categoryvideos.video_id','=','videos.id')
                            ->Join('video_categories','video_categories.id','=','categoryvideos.category_id')
                            ->orwhere('videos.search_tags', 'LIKE', '%' . $search_value . '%')
                            ->orwhere('videos.title', 'LIKE', '%' . $search_value . '%')
                            ->orwhere('video_categories.name', 'LIKE', '%' . $search_value . '%')
                            ->where('active', '=', '1')
                            ->where('status', '=', '1')
                            ->where('draft', '=', '1')
                            ->groupBy('videos.id')
                            ->latest('videos.created_at')
                            ->limit('10');

                            if(Geofencing() !=null && Geofencing()->geofencing == 'ON'){
                                $videos_count = $videos_count  ->whereNotIn('videos.id',Block_videos());
                            }

                            $videos_count = $videos_count->count();

            if ($videos_count > 0)
            {
                $videos = Video::Select('videos.*','categoryvideos.category_id','categoryvideos.video_id','video_categories.name as category_name')
                                ->Join('categoryvideos','categoryvideos.video_id','=','videos.id')
                                ->Join('video_categories','video_categories.id','=','categoryvideos.category_id')
                                ->orwhere('videos.search_tags', 'LIKE', '%' . $search_value . '%')
                                ->orwhere('videos.title', 'LIKE', '%' . $search_value . '%')
                                ->orwhere('video_categories.name', 'LIKE', '%' . $search_value . '%')
                                ->where('active', '=', '1')
                                ->where('status', '=', '1')
                                ->where('draft', '=', '1')
                                ->orderBy('videos.created_at', 'desc')
                                ->groupBy('videos.id')
                                ->limit('10');

                                if(Geofencing() !=null && Geofencing()->geofencing == 'ON'){
                                    $videos = $videos  ->whereNotIn('videos.id',Block_videos());
                                }

                        $videos = $videos->get();
            }
            else
            {
                $videos = [];
            }
            

            $livestreams = LiveStream::Select('live_streams.*','livecategories.live_id','live_categories.name')
                                ->Join('livecategories','livecategories.live_id','=','live_streams.id')
                                ->Join('live_categories','live_categories.id','=','livecategories.category_id')
                                ->orwhere('live_streams.search_tags', 'LIKE', '%' . $search_value . '%')
                                ->orwhere('live_streams.title', 'LIKE', '%' . $search_value . '%')
                                ->orwhere('live_categories.name', 'LIKE', '%' . $search_value . '%')           
                                ->where('live_streams.active', '=', '1')
                                // ->where('status', '=', '1')
                                ->limit('10')
                                ->groupBy('live_streams.id')
                                ->get();

            $audio = Audio::orwhere('search_tags', 'LIKE', '%' . $search_value . '%')
                                ->orwhere('audio.title', 'LIKE', '%' .$search_value . '%')
                                ->where('active', '=', '1')
                                ->where('status', '=', '1')
                                ->limit('10')
                                ->get();

            $Episode = Episode::Select('episodes.*','series.id','series_categories.category_id','video_categories.name as Category_name')
                                ->Join('series','series.id','=','episodes.series_id')
                                ->Join('series_categories','series_categories.series_id','=','series.id')
                                ->Join('video_categories','video_categories.id','=','series_categories.category_id')
                                ->orwhere('episodes.search_tags', 'LIKE', '%' . $search_value . '%')
                                ->orwhere('episodes.title', 'LIKE', '%' . $search_value . '%')
                                ->orwhere('video_categories.name', 'LIKE', '%' . $search_value . '%')           
                                ->where('episodes.active', '=', '1')
                                ->where('episodes.status', '=', '1')
                                ->groupBy('episodes.id')
                                ->limit('10')
                                ->get(); 
                            
            $Series = Series::Select('series.*','series_categories.category_id','video_categories.name as Category_name')
                                ->Join('series_categories','series_categories.series_id','=','series.id')
                                ->Join('video_categories','video_categories.id','=','series_categories.category_id')
                                ->orwhere('series.search_tag', 'LIKE', '%' . $search_value . '%')
                                ->orwhere('series.title', 'LIKE', '%' . $search_value . '%')
                                ->orwhere('video_categories.name', 'LIKE', '%' . $search_value . '%')           
                                ->where('series.active', '=', '1')
                                ->groupBy('series.id')
                                ->limit('10')
                                ->get();  

            $data = array(
                'all_videos' => $videos,
                'search_value' => $search_value,
                'currency' => CurrencySetting::first() ,
                'latest_videos' => $latest_videos,
                'ThumbnailSetting' =>   ThumbnailSetting::first(),
                'Search_audio' => $audio,
                'Search_livestreams' => $livestreams,
                'Search_Episode' => $Episode,
                'Search_Series' => $Series,
                'latest_videos' => $latest_videos,
                'latest_livestreams' => $latest_livestreams,
                'latest_audio' => $latest_audio,
                'latest_Episode'=> $latest_Episode,
                'latest_Series'=> $latest_Series,
                'Most_view_videos' => $Most_view_videos,
                'Most_view_audios' => $Most_view_audios,
                'Most_view_live' => $Most_view_live,
                'Most_view_episode' => $Most_view_episode,
                'Most_view_Series' => $Most_view_Series,
            );

            return Theme::view('search', $data);

        } catch (\Exception $e) {
            return $e->getMessage();
           return abort (404);
        }
    }

    public function searchResult_videos(Request $request, $videos_search_value)
    {
        try {

            $videos = Video::Select('videos.*','categoryvideos.category_id','categoryvideos.video_id','video_categories.name as category_name')
                                ->Join('categoryvideos','categoryvideos.video_id','=','videos.id')
                                ->Join('video_categories','video_categories.id','=','categoryvideos.category_id')
                                ->orwhere('videos.search_tags', 'LIKE', '%' . $videos_search_value . '%')
                                ->orwhere('videos.title', 'LIKE', '%' . $videos_search_value . '%')
                                ->orwhere('video_categories.name', 'LIKE', '%' . $videos_search_value . '%')
                                ->where('active', '=', '1')
                                ->where('status', '=', '1')
                                ->where('draft', '=', '1')
                                ->groupBy('videos.id')
                                ->latest('videos.created_at');

            if(Geofencing() !=null && Geofencing()->geofencing == 'ON'){
                    $videos = $videos  ->whereNotIn('videos.id',Block_videos());
            }

            $videos = $videos->get();

            $data = array(
                'all_videos' => $videos,
                'ThumbnailSetting' =>   ThumbnailSetting::first(),
                'currency' => CurrencySetting::first() ,
                'search_value' => $videos_search_value,
            );

            return Theme::view('search_videos', $data);

        } catch (\Throwable $th) {

            return $th->getMessage();
            
            return abort (404);

        }
    }

    public function searchResult_livestream(Request $request, $livestreams_search_value)
    {
        try {

            $livestreams = LiveStream::Select('live_streams.*','livecategories.live_id','live_categories.name')
                                ->Join('livecategories','livecategories.live_id','=','live_streams.id')
                                ->Join('live_categories','live_categories.id','=','livecategories.category_id')
                                ->orwhere('live_streams.search_tags', 'LIKE', '%' . $livestreams_search_value . '%')
                                ->orwhere('live_streams.title', 'LIKE', '%' . $livestreams_search_value . '%')
                                ->orwhere('live_categories.name', 'LIKE', '%' . $livestreams_search_value . '%')           
                                ->where('live_streams.active', '=', '1')
                                ->groupBy('live_streams.id')
                                ->latest('live_streams.created_at')
                                ->get();


            $data = array(
                'search_value' => $livestreams_search_value,
                'ThumbnailSetting' =>   ThumbnailSetting::first(),
                'currency' => CurrencySetting::first() ,
                'Search_livestreams' => $livestreams,
            );

            return Theme::view('search_livestreams', $data);

        } catch (\Throwable $th) {
            
            return $th->getMessage();

            return abort (404);

        }
    }

    public function searchResult_series(Request $request, $series_search_value)
    {
        try {
                            
            $Series = Series::Select('series.*','series_categories.category_id','video_categories.name as Category_name')
                                ->Join('series_categories','series_categories.series_id','=','series.id')
                                ->Join('video_categories','video_categories.id','=','series_categories.category_id')
                                ->orwhere('series.search_tag', 'LIKE', '%' . $series_search_value . '%')
                                ->orwhere('series.title', 'LIKE', '%' . $series_search_value . '%')
                                ->orwhere('video_categories.name', 'LIKE', '%' . $series_search_value . '%')           
                                ->where('series.active', '=', '1')
                                ->groupBy('series.id')
                                ->latest('series.id')
                                ->get();  

            $data = array(
                'search_value' => $series_search_value,
                'ThumbnailSetting' =>   ThumbnailSetting::first(),
                'currency' => CurrencySetting::first() ,
                'Search_Series' => $Series,
            );
          
            return Theme::view('search_series', $data);

        } catch (\Throwable $th) {
            
            return $th->getMessage();

            return abort (404);

        }
    }

    public function searchResult_episode(Request $request, $Episode_search_value)
    {
        try {

            $Episode = Episode::Select('episodes.*','series.id','series_categories.category_id','video_categories.name as Category_name')
                                ->Join('series','series.id','=','episodes.series_id')
                                ->Join('series_categories','series_categories.series_id','=','series.id')
                                ->Join('video_categories','video_categories.id','=','series_categories.category_id')
                                ->orwhere('episodes.search_tags', 'LIKE', '%' . $Episode_search_value . '%')
                                ->orwhere('episodes.title', 'LIKE', '%' . $Episode_search_value . '%')
                                ->orwhere('video_categories.name', 'LIKE', '%' . $Episode_search_value . '%')           
                                ->where('episodes.active', '=', '1')
                                ->where('episodes.status', '=', '1')
                                ->groupBy('episodes.id')
                                ->latest('episodes.id')
                                ->get(); 

            $data = array(
                'search_value' => $Episode_search_value,
                'ThumbnailSetting' =>   ThumbnailSetting::first(),
                'currency' => CurrencySetting::first() ,
                'Search_Episode' => $Episode,
            );

            return Theme::view('search_episodes', $data);

        } catch (\Throwable $th) {

            return $th->getMessage();
            
            return abort (404);

        }
    }

    public function searchResult_audios(Request $request,$Audios_search_value)
    {
        try {

            $audio = Audio::orwhere('search_tags', 'LIKE', '%' . $Audios_search_value . '%')
                        ->orwhere('audio.title', 'LIKE', '%' .$Audios_search_value . '%')
                        ->where('active', '=', '1')
                        ->where('status', '=', '1')
                        ->latest()
                        ->get();

            $data = array(
                'search_value' => $Audios_search_value,
                'Search_audio' => $audio,
                'currency' => CurrencySetting::first() ,
                'ThumbnailSetting' =>  ThumbnailSetting::first(),
            );

            return Theme::view('search_audios', $data);

        } catch (\Throwable $th) {

            return $th->getMessage();

            return abort (404);
        }
    }
}
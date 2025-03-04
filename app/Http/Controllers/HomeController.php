<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\ImageManagerStatic as Image;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\Authenticatable;
use Stevebauman\Location\Facades\Location;
use Victorybiz\GeoIPLocation\GeoIPLocation;
use Maatwebsite\Excel\Facades\Excel;
use Carbon;
use Session;
use URL;
use Auth;
use View;
use Hash;
use Mail;
use Nexmo;
use Crypt;
use \Redirect  ;
use App\User  ;
use App\SystemSetting  ;
use App\Setting ;
use App\Video  ;
use App\Slider  ;
use App\PpvVideo  ;
use App\PpvCategory  ;
use App\VerifyNumber  ;
use App\Subscription  ;
use App\PaypalPlan  ;
use App\ContinueWatching  ;
use App\Genre;
use App\Audio;
use App\Geofencing;
use App\Page ;
use App\HomeSetting ;
use App\Movie;
use App\BlockVideo;
use App\Episode;
use App\LikeDislike ;
use App\VideoCategory;
use App\Multiprofile;
use App\LiveStream  ;
use App\AudioAlbums  ;
use App\UserLogs  ;
use App\CurrencySetting  ;
use App\SubscriptionPlan  ;
use Jenssegers\Agent\Agent;
use App\LoggedDevice;
use App\ApprovalMailDevice;
use App\RecentView;
use App\ChooseProfileScene;
use App\ThumbnailSetting;
use App\SiteTheme;
use App\Series;
use App\Artist;
use App\Helpers\LogActivity;
use App\AdminLandingPage;
use App\EmailTemplate;
use App\VideoSchedules ;
use App\ScheduleVideos ;
use App\Language ;
use App\MusicStation ;
use App\GuestLoggedDevice ;
use App\LanguageVideo;
use App\CategoryVideo;
use App\AppSetting  ;
use App\TVLoginCode;
use App\Watchlater ;
use App\OrderHomeSetting;
use App\ChannelVideoScheduler;
use App\AdminAdvertistmentBanners;
use App\AdminEPGChannel;
use App\Wishlist;
use App\TimeZone;
use App\Document;
use App\DocumentGenre;
use App\BlockLiveStream;
use App\CompressImage;
use App\LiveCategory;
use App\AudioCategory;
use App\SeriesNetwork;
use App\SeriesGenre;
use App\LiveEventArtist;
use Theme;
use App\ButtonText;
use App\StorageSetting;
use App\Menu;

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
        $this->settings = Setting::first();
        $this->videos_per_page = $this->settings->videos_per_page;

        $this->HomeSetting = HomeSetting::first();
        Theme::uses($this->HomeSetting->theme_choosen);

        $this->BunnyCDNEnable = StorageSetting::pluck('bunny_cdn_storage')->first();

        $this->BaseURL = $this->BunnyCDNEnable == 1 ? StorageSetting::pluck('bunny_cdn_base_url')->first() : URL::to('/public/uploads') ;

    }

    public function FirstLanging(Request $request)
    {
        $data = Session::all();
        $settings = $this->settings ;
        $multiuser = Session::get('subuser_id');
        $getfeching = Geofencing::first();
        $Recomended = $this->HomeSetting;
        $ThumbnailSetting = ThumbnailSetting::first();
        $videos_expiry_date_status = videos_expiry_date_status();
        $default_vertical_image_url = default_vertical_image_url();
        $default_horizontal_image_url = default_horizontal_image_url();
        $current_timezone = current_timezone();
        $FrontEndQueryController = new FrontEndQueryController();

                        // Order Setting
            $home_settings_on_value = collect($this->HomeSetting)->filter(function ($value, $key) {
                return $value === '1' || $value === 1;
            })->map(function ($value, $key) {
                switch ($key) {
                    case 'channel_partner':
                        return 'ChannelPartner';
                    case 'content_partner':
                        return 'ContentPartner';
                    case 'video_schedule':
                        return 'video_schedule';
                    case 'SeriesGenre':
                        return 'Series_Genre';
                    case 'SeriesGenre_videos':
                        return 'Series_Genre_videos';
                    case 'AudioGenre':
                        return 'Audio_Genre';
                    case 'AudioGenre_audios':
                        return 'Audio_Genre_audios';
                    case 'my_playlist':
                        return 'Audio_Genre_audios';
                    default:
                        return $key;
                }
            })->values()->toArray();

        $order_settings = OrderHomeSetting::select('video_name')->whereIn('video_name',$home_settings_on_value)->orderBy('order_id', 'asc');
        $pagination_value = HomeSetting::pluck('web_pagination_count')->first();

        if($this->HomeSetting->theme_choosen == "theme4" || $this->HomeSetting->theme_choosen == "default"){
            $order_settings = $order_settings->paginate($pagination_value);    // Pagination
        }else{
            $order_settings = $order_settings->get();
        }

        $check_Kidmode = 0;

        if($settings->enable_landing_page == 1 && Auth::guest()){

            $landing_page_slug = AdminLandingPage::where('status',1)->pluck('slug')->first() ? AdminLandingPage::where('status',1)->pluck('slug')->first() : "landing-page" ;

            return redirect()->route('landing_page', $landing_page_slug );
        }

        if ($settings->access_free == 1 && Auth::guest() && !isset($data['user']))
        {

            $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
            $userIp = $geoip->getip();
            $countryName = $geoip->getCountry();

            $guest_devices_check = GuestLoggedDevice::where('user_ip', '=',$userIp)->where('device_name', '=', 'desktop')->first();

                if (empty($guest_devices_check))
                {
                    $adddevice = new GuestLoggedDevice;
                    $adddevice->device_name = 'desktop';
                    $adddevice->user_ip = $userIp;
                    $adddevice->country_name = $countryName;
                    $adddevice->save();
                }

            $genre = Genre::all();
            $genre_video_display = VideoCategory::where('in_home',1)->orderBy('order','ASC')->limit(15)->get() ;

            $trending_videos = Video::select('id','title','slug','year','rating','access','publish_type','global_ppv','publish_time','publish_status','ppv_price','responsive_image','responsive_player_image','responsive_tv_image',
                                        'duration','rating','image','featured','age_restrict','video_tv_image','player_image','details','description')
                                        ->where('active', '1')->where('status', '1')->where('draft', '1')
                                        ->where('views', '>', '5')->latest()
                                        ->limit(15)->get();


            

            $trending_audios = Audio::select('id','title','slug','ppv_status','year','rating','access','ppv_price',
                'duration','rating','image','featured','player_image','details','description')
                ->where('active', '=', '1')->where('status', '=', '1')
                ->where('views', '>', '5')
                ->latest()->limit(15)
                ->get();

            $latest_audios = Audio::select('id','title','slug','ppv_status','year','rating','access','ppv_price',
                'duration','rating','image','featured','player_image','details','description')
                ->where('active', '1')->where('status', '1')
                ->latest()->limit(15)
                ->get();

            $trending_episodes = Episode::select('id','title','slug','rating','access','series_id','season_id','ppv_price','responsive_image','responsive_player_image','responsive_tv_image',
                'duration','rating','image','featured','tv_image','player_image')
                ->where('active', '=', '1')->where('views', '>', '0')
                ->orderBy('id', 'DESC')
                ->limit(15)
                ->get();

          
            

            $pages = Page::all();

            if (!Auth::guest())
            {
                $getcnt_watching = ContinueWatching::where('user_id', Auth::user()->id)->where('type','!=','embed')->pluck('videoid')->toArray();

                $cnt_watching = Video::select('id','title','slug','year','rating','access','publish_type','global_ppv','publish_time','publish_status','ppv_price','responsive_image','responsive_player_image','responsive_tv_image',
                                        'duration','rating','image','featured','age_restrict','video_tv_image','player_image','details','description')
                                        ->with('cnt_watch')
                                        ->where('active', '1')
                                        ->where('status', '1')
                                        ->where('draft', '1')
                                        ->whereIn('id', $getcnt_watching)->latest('videos.created_at')
                                        ->limit(15)
                                        ->get();

            }
            else
            {
                $cnt_watching = [];
            }


            $currency = CurrencySetting::first();

           

            

            $FrontEndQueryController = new FrontEndQueryController();
            $button_text = ButtonText::first();

            if($this->HomeSetting->theme_choosen == "theme4"){

                $data = array(
                    'currency' => $currency,
                    'current_theme'     => $this->HomeSetting->theme_choosen,
                    'Epg'                 => $FrontEndQueryController->Epg()->take(15),
                    'current_page'      => 1,
                    'pagination_url' => '/videos',
                    'latest_series'          => $FrontEndQueryController->latest_Series()->take(15),
                    'featured_episodes' => $FrontEndQueryController->featured_episodes(),
                    'settings'            => $settings,
                    'pages'               => $pages,
                    'home_settings'       => $this->HomeSetting ,
                    'livetream'              => $FrontEndQueryController->livestreams()->take(15),
                    'Family_Mode'           => $Family_Mode = 2,
                    'Kids_Mode'             => $Kids_Mode = 2,
                    'ThumbnailSetting'      => $ThumbnailSetting,
                    'Series_based_on_Networks' => $FrontEndQueryController->Series_based_on_Networks(),
                    'multiple_compress_image' => CompressImage::pluck('enable_multiple_compress_image')->first() ? CompressImage::pluck('enable_multiple_compress_image')->first() : 0,
                    'SeriesGenre' =>  SeriesGenre::orderBy('order','ASC')->limit(15)->get(),
                    'admin_advertistment_banners' => AdminAdvertistmentBanners::first(),
                    'order_settings_list' => OrderHomeSetting::get(),
                    'order_settings'  => $order_settings ,
                    'getfeching'      => $getfeching ,
                    'videos_expiry_date_status' => $videos_expiry_date_status,
                    'Series_Networks_Status' => Series_Networks_Status(),
                    'latest_episode'  => $FrontEndQueryController->latest_episodes() ,
                    'default_vertical_image_url' => $default_vertical_image_url,
                    'default_horizontal_image_url' => $default_horizontal_image_url,
                    'artist_live_event' => LiveEventArtist::where("active",1)->where('status',1)->latest()->get(),
                    'button_text'         => $button_text,
                    'VideoJsContinueWatching'             => $FrontEndQueryController->VideoJsContinueWatching(),
                    'VideoJsEpisodeContinueWatching'      => $FrontEndQueryController->VideoJsEpisodeContinueWatching(),
                    'BaseURL'                            => $this->BaseURL
                );
            }else{
                $data = array(
                    'currency' => $currency,
                    'videos'    =>$FrontEndQueryController->Latest_videos(),
                    'current_theme'     => $this->HomeSetting->theme_choosen,
                    'sliders'            => $FrontEndQueryController->sliders(),
                    'live_banner'        => $FrontEndQueryController->live_banners(),
                    'video_banners'      => $FrontEndQueryController->video_banners(),
                    'series_sliders'     => $FrontEndQueryController->series_sliders(),
                    'live_event_banners' => $FrontEndQueryController->live_event_banners(),
                    'Episode_sliders'    => $FrontEndQueryController->Episode_sliders(),
                    'VideoCategory_banner' => $FrontEndQueryController->VideoCategory_banner(),
                    'Video_Based_Category'    => $FrontEndQueryController->Video_Based_Category()->take(15) ,
                    'Epg'                 => $FrontEndQueryController->Epg()->take(15),
                    'current_page'      => 1,
                    'pagination_url' => '/videos',
                    'latest_series'          => $FrontEndQueryController->latest_Series()->take(15),
                    'cnt_watching'      => $cnt_watching,
                    'trendings'         => $trending_videos,
                    'latest_video'      => $FrontEndQueryController->Latest_videos()->take(15),
                    'latest_videos'     => $FrontEndQueryController->Latest_videos()->take(15),
                    'latestViewedVideos'     => $FrontEndQueryController->latestViewedVideos()->take(15),
                    'latest_movies'     => $FrontEndQueryController->Latest_videos(),
                    'trending_audios'   => $trending_audios,
                    'latest_audios'     => $latest_audios,
                    'featured_videos'   => $FrontEndQueryController->featured_videos()->take(15),
                    'featured_episodes' => $FrontEndQueryController->featured_episodes()->take(15),
                    'genre_video_display' => $genre_video_display,
                    'genres'              => $genre_video_display ,
                    'settings'            => $settings,
                    'pages'               => $pages,
                    'trending_videos'     => $trending_videos,
                    'suggested_videos'    => $trending_videos,
                    'video_categories'    => $genre_video_display ,
                    'home_settings'       => $this->HomeSetting ,
                    'livetream'              => $FrontEndQueryController->livestreams()->take(15),
                    'audios'              => $latest_audios ,
                    'albums'              => AudioAlbums::orderBy('created_at', 'DESC')->get()->take(15) ,
                    'most_watch_user'     => !empty($most_watch_user) ? $most_watch_user : [],
                    'top_most_watched'    => !empty($top_most_watched) ? $top_most_watched : [],
                    'Most_watched_country'   => !empty($Most_watched_country) ? $Most_watched_country : [],
                    'preference_genres'      => !empty($preference_gen) ? $preference_gen : [],
                    'preference_Language'    => !empty($preference_Lan) ? $preference_Lan : [],
                    'Family_Mode'           => $Family_Mode = 2,
                    'Kids_Mode'             => $Kids_Mode = 2,
                    'ThumbnailSetting'      => $ThumbnailSetting,
                    'artist'                => Artist::all(),
                    'Series_based_on_Networks' => $FrontEndQueryController->Series_based_on_Networks(),
                    'Series_based_on_category' => $FrontEndQueryController->Series_based_on_category(),
                    'VideoSchedules'        => VideoSchedules::where('in_home',1)->limit(15)->get(),
                    'LiveCategory'         => LiveCategory::orderBy('order','ASC')->limit(15)->get(),
                    'AudioCategory'         => AudioCategory::orderBy('order','ASC')->limit(15)->get(),
                    'multiple_compress_image' => CompressImage::pluck('enable_multiple_compress_image')->first() ? CompressImage::pluck('enable_multiple_compress_image')->first() : 0,
                    'SeriesGenre' =>  SeriesGenre::orderBy('order','ASC')->limit(15)->get(),
                    'admin_advertistment_banners' => AdminAdvertistmentBanners::first(),
                    'order_settings_list' => OrderHomeSetting::get(),
                    'order_settings'  => $order_settings ,
                    'getfeching'      => $getfeching ,
                    'videos_expiry_date_status' => $videos_expiry_date_status,
                    'Series_Networks_Status' => Series_Networks_Status(),
                    'latest_episode'  => $FrontEndQueryController->latest_episodes() ,
                    'default_vertical_image_url' => $default_vertical_image_url,
                    'default_horizontal_image_url' => $default_horizontal_image_url,
                    'artist_live_event' => LiveEventArtist::where("active",1)->where('status',1)->latest()->get(),
                    'ugc_videos'        => $FrontEndQueryController->UGCVideos(),
                    'ugc_shorts_minis'  => $FrontEndQueryController->UGCShortsMinis(),
                    'ugc_users'         => $FrontEndQueryController->UGCUsers(),
                    'button_text'         => $button_text,
                    'top_ten_videos'      => $FrontEndQueryController->TopTenVideos(),
                    'VideoJsContinueWatching'             => $FrontEndQueryController->VideoJsContinueWatching(),
                    'VideoJsEpisodeContinueWatching'      => $FrontEndQueryController->VideoJsEpisodeContinueWatching(),
                    'radiostations'            => $FrontEndQueryController->RadioStation()->take(15),
                );
            }

            if($this->HomeSetting->theme_choosen == "theme4" || $this->HomeSetting->theme_choosen == "default"){
                if($request->ajax()) {
                    return $data = [
                        "view" => Theme::watchPartial('home_sections', $data ),
                        'url' => $data['order_settings']->nextPageUrl()
                    ];
                }
            }

            return Theme::view('home', $data);
        }
        else
        {

            $agent = new Agent();

            $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
            $userIp = $geoip->getip();
            $countryName = $geoip->getCountry();
            $regionName = $geoip->getregion();
            $cityName = $geoip->getcity();
            $system_settings = SystemSetting::first();
            $data = Session::all();
            $user = User::where('id', 1)->first();

            if (Auth::guest() && !isset($data['user']))
            {
                return Theme::view('auth.login');
            }
            else
            {
                $device_name = '';
                switch (true) {
                    case $agent->isDesktop():
                        $device_name = 'desktop';
                        break;
                    case $agent->isTablet():
                        $device_name = 'tablet';
                        break;
                    case $agent->isMobile():
                        $device_name = 'mobile';
                        break;
                    case $agent->isTv():
                        $device_name = 'tv';
                        break;
                    default:
                        $device_name = 'unknown';
                        break;
                }

                $user_role = Auth::user()->role;

                $user_check = LoggedDevice::where('user_id', Auth::User()->id)->count();

                $subuser_check = Multiprofile::where('parent_id', Auth::User()->id)->count();

                $alldevices_register = LoggedDevice::where('user_id', Auth::User()->id)
                    ->where('device_name', '!=', $device_name)
                    ->where('user_ip', '!=', $userIp)
                    ->get();

                $alldevices = LoggedDevice::where('user_id', Auth::User()->id)->get();

                $subscription_device_limit = Subscription::select('subscription_plans.devices')->join('subscription_plans', 'subscriptions.stripe_plan', '=', 'subscription_plans.plan_id')
                    ->where('subscriptions.user_id', Auth::User()->id)
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

                $user_check = LoggedDevice::where('user_id', '=', Auth::User()->id)->count();
                $subuser_check = Multiprofile::where('parent_id', '=', Auth::User()->id)->count();
                $alldevices = LoggedDevice::where('user_id', '=', Auth::User()->id)->get();
                $devices_check = LoggedDevice::where('user_id', '=', Auth::User()->id)->where('device_name', '=', $device_name)->first();

                $latest_series = Series::select('id','title','slug','year','rating','access','duration','rating','image','featured','tv_image','player_image','details','description')
                ->where('active', '1')->orderBy('created_at', 'DESC')->limit(15)
                ->get();

                $username = Auth::User()->username;
                $email = Auth::User()->email;
                $mail_check = ApprovalMailDevice::where('user_ip', '=', $userIp)->where('device_name', '=', $device_name)->first();
                $user_check = LoggedDevice::where('user_id', '=', Auth::User()->id)->count();
                $subuser_check = Multiprofile::where('parent_id', '=', Auth::User()->id)->count();


                // if (count($alldevices_register) > 0  && $user_role == "registered" && Auth::User()->id != 1)
                // {

                //     LoggedDevice::where('user_ip','=', $userIp)
                //     ->where('user_id','=', Auth::User()->id)
                //     ->where('device_name','=', $device_name)
                //     ->delete();

                //     try {

                //         Mail::send('emails.register_device_login', array(
                //             'id' => Auth::User()->id,
                //             'name' => Auth::User()->username,

                //         ) , function ($message) use ($email, $username)
                //         {
                //             $message->from(AdminMail() , GetWebsiteName());
                //             $message->to($email, $username)->subject('Buy Subscriptions Plan To Access Multiple Devices');
                //         });

                //         $email_log      = 'Mail Sent Successfully from register device login ';
                //         $email_template = "0";
                //         $user_id = Auth::User()->id;

                //         Email_sent_log($user_id,$email_log,$email_template);

                //     } catch (\Throwable $th) {

                //         $email_log      = $th->getMessage();
                //         $email_template = "0";
                //         $user_id = Auth::User()->id;

                //         Email_notsent_log($user_id,$email_log,$email_template);
                //     }

                //     $message = 'Buy Subscriptions Plan To Access Multiple Devices.';
                //     Auth::logout();
                //     unset($data['password_hash']);
                //     \Session::flush();
                //     return Redirect::to('/')->with(array(
                //         'message' => 'Buy Subscriptions Plan!',
                //         'note_type' => 'success'
                //     ));
                // }

                // elseif ($user_check >= $device_limit && Auth::User()->role != "admin" && Auth::User()->role != "registered")
                // {

                //     $url1 = $_SERVER['REQUEST_URI'];
                //     header("Refresh: 120; URL=$url1");
                //     $message = 'Your Plan Device  Limit Is' . ' ' . $device_limit;
                //     return view('device_logged', compact('alldevices', 'system_settings', 'user','userIp'))->with(array(
                //         'message' => $message,
                //         'note_type' => 'success'
                //     ));
                // }
                // else
                // {

                    $device_name = '';
                    switch (true) {
                        case $agent->isDesktop():
                            $device_name = 'desktop';
                            break;
                        case $agent->isTablet():
                            $device_name = 'tablet';
                            break;
                        case $agent->isMobile():
                            $device_name = 'mobile';
                            break;
                        case $agent->isTv():
                            $device_name = 'tv';
                            break;
                        default:
                            $device_name = 'unknown';
                            break;
                    }


                    if (!empty($device_name))
                    {

                        $devices_check = LoggedDevice::where('user_id', Auth::User()->id)->where('device_name', '=', $device_name)->first();

                        if (empty($devices_check))
                        {
                            $adddevice = new LoggedDevice;
                            $adddevice->user_id = Auth::User()->id;
                            $adddevice->user_ip = $userIp;
                            $adddevice->device_name = $device_name;
                            $adddevice->save();
                        }
                    }
                // }

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
                    $settings = $this->settings ;
                    $PPV_settings = Setting::where('ppv_status', '=', 1)->first();

                    $latest_series = Series::select('id','title','slug','year','rating','access','duration','rating','image','featured','tv_image','player_image','details','description')
                        ->where('active', '1')->latest()->limit(15)->get();

                    $ppv_gobal_price = !empty($PPV_settings) ? $PPV_settings->ppv_price : null ;

                    $genre = Genre::all();

                    $genre_video_display = VideoCategory::where('in_home',1)->orderBy('order','ASC')->limit(15)->get();

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

                    $Mode = $multiuser != null ? Multiprofile::where('id', $multiuser)->first() : User::where('id', Auth::User()->id)->first();

                    $Family_Mode = $Mode['FamilyMode'];
                    $Kids_Mode = $Mode['Kidsmode'];

                    $check_Kidmode = 0 ;
                    // $Multiuser = Multiprofile::where('id', $multiuser)->first();

                   

                   

                    // Most watched videos By user


                    if ($Recomended->Recommendation == 1)
                    {

                        $most_watch_user = RecentView::select('video_id', 'videos.*', DB::raw('COUNT(video_id) AS count'))->join('videos', 'videos.id', '=', 'recent_views.video_id')
                            ->where('videos.status', '=', '1')
                            ->where('videos.draft', '=', '1')
                            ->where('videos.active', '=', '1')
                            ->groupBy('video_id');
                        if ($multiuser != null)
                        {
                            $most_watch_user = $most_watch_user->where('recent_views.sub_user', $multiuser);
                        }
                        else
                        {
                            $most_watch_user = $most_watch_user->where('recent_views.user_id', Auth::user()->id);
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
                            ->limit(15)
                            ->get();
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
                        $top_most_watched = RecentView::select('video_id', 'videos.*', DB::raw('COUNT(video_id) AS count'))
                            ->join('videos', 'videos.id', '=', 'recent_views.video_id')
                            ->where('videos.status', '=', '1')
                            ->where('videos.draft', '=', '1')
                            ->where('videos.active', '=', '1')
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
                            ->limit(15)
                            ->get();
                    }


                    // Most Watched Videos in country
                    if ($Recomended->Recommendation == 1)
                    {

                        $Most_watched_country = RecentView::select('video_id', 'videos.*', DB::raw('COUNT(video_id) AS count'))->join('videos', 'videos.id', '=', 'recent_views.video_id')
                            ->where('videos.status', '=', '1')
                            ->where('videos.draft', '=', '1')
                            ->where('videos.active', '=', '1')
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
                        $Most_watched_country = $Most_watched_country->where('country', $countryName)->whereNotIn('videos.id', $blocking_videos)->limit(15)
                            ->get();
                    }

                    // User Preferences
                    if ($Recomended->Recommendation == 1)
                    {
                        $preference_genres = User::where('id', Auth::user()->id)->pluck('preference_genres')->first();
                        $preference_language = User::where('id', Auth::user()->id)->pluck('preference_language')->first();

                        if ($preference_genres != null)
                        {
                            $video_genres = json_decode($preference_genres);
                            $preference_gen = Video::whereIn('video_category_id', $video_genres)
                            ->whereNotIn('videos.id', $blocking_videos)
                            ->where('active', '1')->where('status', '1')->where('draft', '1');

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

                        if ($preference_language != null)
                        {
                            $video_language = json_decode($preference_language);
                            $preference_Lan = Video::whereIn('language', $video_language)->whereNotIn('videos.id', $blocking_videos)
                                                    ->where('status', '1')
                                                    ->where('draft', '1')
                                                    ->where('active', '1');

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
                    }

                    // family & Kids Mode Restriction
                    $Subuser = Session::get('subuser_id');
                    if ($Subuser != null)
                    {
                        $Mode = Multiprofile::where('id', $Subuser)->first();
                    }
                    else
                    {
                        $Mode = User::where('id', Auth::user()->id)->first();
                    }



                    $latest_series = Series::select('id','title','slug','year','rating','access','duration','rating','image','featured','tv_image','player_image','details','description')
                                                    ->where('active', '1')->latest()->limit(15)
                                                    ->get();

                    $latest_audios = Audio::select('id','title','slug','ppv_status','year','rating','access','ppv_price','duration','rating','image','featured','player_image','details','description')
                                                    ->where('active', '1')->where('status', '1')
                                                    ->latest()->limit(15)->get();

                    $trending_videos = Video::select('id','title','slug','year','rating','access','publish_type','global_ppv','publish_time','publish_status','ppv_price','responsive_image','responsive_player_image','responsive_tv_image',
                                                        'duration','rating','image','featured','age_restrict','video_tv_image','player_image','details','description')->where('active', '=', '1')->where('status', '=', '1')
                                                    ->where('draft', '=', '1')->where('views', '>', '5')
                                                    ->latest()->limit(15)->get();

                    $trending_audios = Audio::select('id','title','slug','ppv_status','year','rating','access','ppv_price',
                                                    'duration','rating','image','featured','player_image','details','description')
                                                    ->where('active', '1')->where('status', '1')->where('views', '>', '5')
                                                    ->latest()->limit(15)->get();


                    $trending_episodes = Episode::select('id','title','slug','rating','access','series_id','season_id','ppv_price','responsive_image','responsive_player_image','responsive_tv_image','duration','rating','image','featured','tv_image','player_image','active')
                                                ->where('active', '1')->where('views', '>', '0')
                                                ->latest()->limit(15)->get();

                    $latest_episode = Episode::select('id','title','slug','rating','access','series_id','season_id','ppv_price','responsive_image','responsive_player_image','responsive_tv_image',
                                                'duration','rating','image','featured','tv_image','player_image')
                                                ->where('active', '1')->latest()->limit(15)
                                                ->get()->map(function($item){
                                                    $item['series'] = Series::where('id',$item->series_id)->first();
                                                    return $item ;
                                                });

                    $featured_episodes = Episode::select('id','title','slug','rating','access','series_id','season_id','ppv_price','responsive_image','responsive_player_image','responsive_tv_image',
                                                        'duration','rating','image','featured','tv_image','player_image','active')
                                                    ->where('active', '1')->where('featured', '1')
                                                    ->latest()->limit(15)
                                                    ->get();



                    if ($multiuser != null)
                    {
                        $getcnt_watching = ContinueWatching::where('multiuser', $multiuser)->pluck('videoid')->toArray();

                        $cnt_watching = Video::select('id','title','slug','year','rating','access','publish_type','global_ppv','publish_time','publish_status','ppv_price','responsive_image','responsive_player_image','responsive_tv_image',
                                                'duration','rating','image','featured','age_restrict','video_tv_image','player_image','details','description')->with('cnt_watch')
                                                ->where('active', '1')->where('status', '1')
                                                ->where('draft', '1')->where('type','!=','embed')
                                                ->whereIn('id', $getcnt_watching)
                                                ->limit(15)->get();
                    }
                    elseif (!Auth::guest())
                    {

                        $continue_watching = ContinueWatching::where('user_id', Auth::user()->id)->first();

                        if ($continue_watching != null && $continue_watching->multiuser == null)
                        {
                            $getcnt_watching = ContinueWatching::where('user_id', Auth::user()->id)->pluck('videoid')->toArray();

                            $cnt_watching = Video::select('id','title','slug','year','rating','access','publish_type','global_ppv','publish_time','publish_status','ppv_price','responsive_image','responsive_player_image','responsive_tv_image',
                            'duration','rating','image','featured','age_restrict','video_tv_image','player_image','details','description')->with('cnt_watch')->where('active', '=', '1')->where('status', '=', '1')
                            ->where('draft', '1')->where('type','!=','embed')->whereIn('id', $getcnt_watching);
                            if ($getfeching != null && $getfeching->geofencing == 'ON')
                            {
                                $cnt_watching = $cnt_watching->whereNotIn('id', $blockvideos);
                            }
                            $cnt_watching = $cnt_watching->limit(15)->get();
                        }
                        else
                        {
                            $getcnt_watching = ContinueWatching::where('user_id', Auth::user()->id)
                                ->where('multiuser', 'data')
                                ->pluck('videoid')
                                ->toArray();

                            $cnt_watching = Video::select('id','title','slug','year','rating','access','publish_type','global_ppv','publish_time','publish_status','ppv_price','responsive_image','responsive_player_image','responsive_tv_image',
                            'duration','rating','image','featured','age_restrict','video_tv_image','player_image','details','description')->with('cnt_watch')->where('active', '=', '1')->where('status', '=', '1')
                            ->where('draft', '=', '1')->where('type','!=','embed')->whereIn('id', $getcnt_watching);

                            if ($getfeching != null && $getfeching->geofencing == 'ON')
                            {
                                $cnt_watching = $cnt_watching->whereNotIn('id', $blockvideos);
                            }
                            $cnt_watching = $cnt_watching->limit(15)->get();
                        }

                    }
                    else
                    {
                        $cnt_watching = '';
                    }

                    $currency = CurrencySetting::first();

                    $livestreams = LiveStream::select('id', 'title', 'slug', 'year', 'rating', 'access', 'publish_type', 'publish_time', 'publish_status', 'ppv_price',
                                                    'duration', 'rating', 'image', 'featured', 'Tv_live_image', 'player_image', 'details', 'description', 'free_duration',
                                                    'recurring_program', 'program_start_time', 'program_end_time', 'custom_start_program_time', 'custom_end_program_time',
                                                    'recurring_timezone', 'recurring_program_week_day', 'recurring_program_month_day')
                                                ->where('active', 1)
                                                ->where('status', 1)
                                                ->latest()
                                                ->limit(15)
                                                ->get();

                    $livestreams = $livestreams->filter(function ($livestream) use ($current_timezone) {
                        if ($livestream->publish_type === 'recurring_program') {

                            $Current_time = Carbon\Carbon::now($current_timezone);
                            $recurring_timezone = TimeZone::where('id', $livestream->recurring_timezone)->value('time_zone');
                            $convert_time = $Current_time->copy()->timezone($recurring_timezone);
                            $midnight = $convert_time->copy()->startOfDay();

                            switch ($livestream->recurring_program) {
                                case 'custom':
                                    $recurring_program_Status = $convert_time->greaterThanOrEqualTo($midnight) && $livestream->custom_end_program_time >=  Carbon\Carbon::parse($convert_time)->format('Y-m-d\TH:i') ;
                                    break;
                                case 'daily':
                                    $recurring_program_Status = $convert_time->greaterThanOrEqualTo($midnight) && $livestream->program_end_time >= $convert_time->format('H:i');
                                    break;
                                case 'weekly':
                                    $recurring_program_Status =  ( $livestream->recurring_program_week_day == $convert_time->format('N') ) && $convert_time->greaterThanOrEqualTo($midnight)  && ( $livestream->program_end_time >= $convert_time->format('H:i') );
                                    break;
                                case 'monthly':
                                    $recurring_program_Status = $livestream->recurring_program_month_day == $convert_time->format('d') && $convert_time->greaterThanOrEqualTo($midnight) && $livestream->program_end_time >= $convert_time->format('H:i');
                                    break;
                                default:
                                    $recurring_program_Status = false;
                                    break;
                            }

                            switch ($livestream->recurring_program) {
                                case 'custom':
                                    $recurring_program_live_animation = $livestream->custom_start_program_time <= $convert_time && $livestream->custom_end_program_time >= $convert_time;
                                    break;
                                case 'daily':
                                    $recurring_program_live_animation = $livestream->program_start_time <= $convert_time->format('H:i') && $livestream->program_end_time >= $convert_time->format('H:i');
                                    break;
                                case 'weekly':
                                    $recurring_program_live_animation = $livestream->recurring_program_week_day == $convert_time->format('N') && $livestream->program_start_time <= $convert_time->format('H:i') && $livestream->program_end_time >= $convert_time->format('H:i');
                                    break;
                                case 'monthly':
                                    $recurring_program_live_animation = $livestream->recurring_program_month_day == $convert_time->format('d') && $livestream->program_start_time <= $convert_time->format('H:i') && $livestream->program_end_time >= $convert_time->format('H:i');
                                    break;
                                default:
                                    $recurring_program_live_animation = false;
                                    break;
                            }

                            $livestream->recurring_program_live_animation = $recurring_program_live_animation;

                            return $recurring_program_Status;
                        }
                        return true;
                    });

                    $latest_series = Series::select('id','title','slug','year','rating','access','duration','rating','image','featured','tv_image','player_image','details','description')
                                        ->where('active', '1')->latest()->limit(15)->get();

                        // Series_based_on_Networks

                    $Series_based_on_Networks = SeriesNetwork::where('in_home', 1)->orderBy('order')->get()->map(function ($item) {

                        $item['Series_depends_Networks'] = Series::where('series.active', 1)
                        ->where('network_id', 'LIKE', '%"'.$item->id.'"%')


                                    ->latest('series.created_at')->get()->map(function ($item) {

                            $item['image_url']        = !is_null($item->image)  ? $this->BaseURL.('/images/'.$item->image) : default_vertical_image() ;
                            $item['Player_image_url'] = !is_null($item->player_image)  ? $this->BaseURL.('/images/'.$item->player_image ) : default_horizontal_image_url() ;

                            $item['upload_on'] =  Carbon\Carbon::parse($item->created_at)->isoFormat('MMMM Do YYYY');

                            $item['duration_format'] =  !is_null($item->duration) ?  Carbon\Carbon::parse( $item->duration)->format('G\H i\M'): null ;

                            $item['Series_depends_episodes'] = Series::find($item->id)->Series_depends_episodes
                                                                    ->map(function ($item) {
                                                                    $item['image_url']  = !is_null($item->image) ? $this->BaseURL.('/images/'.$item->image) : default_vertical_image() ;
                                                                    return $item;
                                                                });
                            $item['has_more'] = count($item['Series_depends_episodes']) > 14;
                            $item['source'] = 'Series';
                            return $item;

                        });
                        return $item;
                    });

                    $Series_based_on_category = SeriesGenre::query()->whereHas('category_series', function ($query) {})
                        ->with([
                            'category_series' => function ($series) {
                                $series->select('series.*')->where('series.active', 1)->latest('series.created_at');
                            },
                        ])
                        ->select('series_genre.id', 'series_genre.name', 'series_genre.slug', 'series_genre.order')
                        ->orderBy('series_genre.order')
                        ->get();

                    $Series_based_on_category->each(function ($category) {
                        $category->category_series->transform(function ($item) {

                            $item['image_url']        = !is_null($item->image)  ? $this->BaseURL.('/images/'.$item->image) : default_vertical_image() ;
                            $item['Player_image_url'] = !is_null($item->player_image)  ? $this->BaseURL.('/images/'.$item->player_image ) : default_horizontal_image_url() ;

                            $item['upload_on'] =  Carbon\Carbon::parse($item->created_at)->isoFormat('MMMM Do YYYY');

                            $item['duration_format'] =  !is_null($item->duration) ?  Carbon\Carbon::parse( $item->duration)->format('G\H i\M'): null ;

                            $item['Series_depends_episodes'] = Series::find($item->id)->Series_depends_episodes
                                                                    ->map(function ($item) {
                                                                        $item['image_url']  = !is_null($item->image) ? $this->BaseURL.('/images/'.$item->image) : default_vertical_image() ;
                                                                        return $item;
                                                                });

                            $item['source'] = 'Series';
                            return $item;
                        });
                        $category->source = 'Series_Genre';
                        return $category;
                    });
                    
                    $button_text = ButtonText::first();

                    $data = array(
                        'currency' => $currency,
                        'videos' => $FrontEndQueryController->Latest_videos() ,
                        'current_theme'     => $this->HomeSetting->theme_choosen,
                        'sliders'            => $FrontEndQueryController->sliders(),
                        'live_banner'        => $FrontEndQueryController->live_banners(),
                        'video_banners'      => $FrontEndQueryController->video_banners(),
                        'series_sliders'     => $FrontEndQueryController->series_sliders(),
                        'live_event_banners' => $FrontEndQueryController->live_event_banners(),
                        'Episode_sliders'    => $FrontEndQueryController->Episode_sliders(),
                        'VideoCategory_banner' => $FrontEndQueryController->VideoCategory_banner(),
                        'Epg'                 => $FrontEndQueryController->Epg(),
                        'current_page'      => 1,
                        'latest_series'          => $FrontEndQueryController->latest_Series()->take(15),
                        'cnt_watching'      => $cnt_watching,
                        'latest_videos'     => $FrontEndQueryController->Latest_videos()->take(15),
                        'latest_video'      => $FrontEndQueryController->Latest_videos()->take(15),
                        'latestViewedVideos'     => $FrontEndQueryController->latestViewedVideos()->take(15),
                        'trending_audios'   => $trending_audios,
                        'latest_audios'     => $latest_audios,
                        'featured_videos'   => $FrontEndQueryController->featured_videos()->take(15),
                        'featured_episodes' => $featured_episodes,
                        'genre_video_display' => $genre_video_display,
                        'genres'              => $genre_video_display  ,
                        'pagination_url'      => '/videos',
                        'settings'            => $settings,
                        'pages'               => Page::all(),
                        'trending_videos'     => $trending_videos,
                        'ppv_gobal_price'     => $ppv_gobal_price,
                        'suggested_videos'      => $trending_videos,
                        'video_categories'      => $genre_video_display  ,
                        'Video_Based_Category'    => $FrontEndQueryController->Video_Based_Category()->take(15) ,
                        'home_settings'         => $this->HomeSetting ,
                        'livetream'              => $FrontEndQueryController->livestreams()->take(15),
                        'audios'                => $latest_audios ,
                        'albums'                => AudioAlbums::latest()->limit(15)->get() ,
                        'countryName'            => $countryName,
                        'most_watch_user'        => !empty($most_watch_user) ? $most_watch_user : [],
                        'top_most_watched'       => !empty($top_most_watched) ? $top_most_watched : [],
                        'Most_watched_country'   =>!empty($Most_watched_country) ? $Most_watched_country : [],
                        'preference_genres'      => !empty($preference_gen) ? $preference_gen : [],
                        'preference_Language'    => !empty($preference_Lan) ? $preference_Lan : [],
                        'Family_Mode'            => $Family_Mode,
                        'Kids_Mode'              => $Kids_Mode,
                        'Mode'                   => $Mode,
                        'ThumbnailSetting'       => $ThumbnailSetting,
                        'artist'                 => Artist::limit(15)->get(),
                        'VideoSchedules'         => VideoSchedules::where('in_home',1)->limit(15)->get(),
                        'LiveCategory'         => LiveCategory::orderBy('order','ASC')->limit(15)->get(),
                        'AudioCategory'         => AudioCategory::orderBy('order','ASC')->limit(15)->get(),
                        'Series_based_on_Networks' => $FrontEndQueryController->Series_based_on_Networks(),
                        'Series_based_on_category' => $Series_based_on_category ,
                        'multiple_compress_image' => CompressImage::pluck('enable_multiple_compress_image')->first() ? CompressImage::pluck('enable_multiple_compress_image')->first() : 0,
                        'SeriesGenre' =>  SeriesGenre::orderBy('order','ASC')->limit(15)->get(),
                        'admin_advertistment_banners' => AdminAdvertistmentBanners::first(),
                        'order_settings_list' => OrderHomeSetting::get(),
                        'order_settings'  => $order_settings ,
                        'getfeching'      => $getfeching ,
                        'videos_expiry_date_status' => $videos_expiry_date_status,
                        'Series_Networks_Status' => Series_Networks_Status(),
                        'latest_episode'  => $latest_episode ,
                        'default_vertical_image_url' => $default_vertical_image_url,
                        'default_horizontal_image_url' => $default_horizontal_image_url,
                        'artist_live_event' => LiveEventArtist::where("active",1)->where('status',1)->latest()->get(),
                        'ugc_videos'        => $FrontEndQueryController->UGCVideos()->take(15),
                        'ugc_shorts_minis'  => $FrontEndQueryController->UGCShortsMinis(),
                        'ugc_users'         => $FrontEndQueryController->UGCUsers(),  
                        'button_text'         => $button_text,
                        'top_ten_videos'      => $FrontEndQueryController->TopTenVideos(),
                        'VideoJsContinueWatching'             => $FrontEndQueryController->VideoJsContinueWatching(),
                        'VideoJsEpisodeContinueWatching'      => $FrontEndQueryController->VideoJsEpisodeContinueWatching(),
                        'radiostations'            => $FrontEndQueryController->RadioStation()->take(15),
                        'BaseURL'                            => $this->BaseURL
                    );
                    if($this->HomeSetting->theme_choosen == "theme4" || $this->HomeSetting->theme_choosen == "default"){
                        if($request->ajax()) {
                            return $data = [
                                "view" => Theme::watchPartial('home_sections', $data ),
                                'url' => $data['order_settings']->nextPageUrl()
                            ];
                        }
                    }
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
        $default_vertical_image_url = default_vertical_image_url();
        $default_horizontal_image_url = default_horizontal_image_url();

        $agent = new Agent();
        $settings = $this->settings;
        $multiuser = Session::get('subuser_id');
        $getfeching = Geofencing::first();
        $Recomended = $this->HomeSetting;

        $ppv_gobal_price = $settings->ppv_status == 1 ? $settings->ppv_price : null;

        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
        $userIp = $geoip->getip();
        $countryName = $geoip->getCountry();

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

        if($settings->activation_email == 1 && !Auth::guest() && Auth::user()->activation_code != null){

            unset($data['password_hash']);

            if(!empty($data['user'])){
                unset($data['expiresIn']);
                unset($data['providertoken']);
                unset($data['user']);
                Cache::flush();
            }

            $request->session()->flush();
            $request->session()->regenerate();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            \Session::flush();

            Auth::logout();

            return Redirect::to('/login')->with(
                "message",
                "Please Verify through your email account and Login"
            );

        }

        if($settings->enable_landing_page == 1 && Auth::guest()){

            $landing_page_slug = AdminLandingPage::where('status',1)->pluck('slug')->first() ? AdminLandingPage::where('status',1)->pluck('slug')->first() : "landing-page" ;

            return redirect()->route('landing_page', $landing_page_slug );
        }

        if ($settings->access_free == 1 && Auth::guest() && !isset($data['user'])){



            $guest_devices_check = GuestLoggedDevice::where('user_ip', '=',$userIp)->where('device_name', '=', 'desktop')->first();

            if (empty($guest_devices_check))
            {
                $adddevice = new GuestLoggedDevice;
                $adddevice->device_name = 'desktop';
                $adddevice->user_ip = $userIp;
                $adddevice->country_name = $countryName;
                $adddevice->save();
            }

            return Redirect::to('/');

        }else {

            $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
            $userIp = $geoip->getip();
            $countryName = $geoip->getCountry();
            $regionName = $geoip->getregion();
            $cityName = $geoip->getcity();
            $data = Session::all();
            $system_settings = SystemSetting::first();
            $user = User::where('id', 1)->first();

            if (Auth::guest() && !isset($data['user']))
            {
                return Theme::view('auth.login');
            }
            else
            {

                $device_name = '';

                switch (true) {
                    case $agent->isDesktop():
                        $device_name = 'desktop';
                        break;
                    case $agent->isTablet():
                        $device_name = 'tablet';
                        break;
                    case $agent->isMobile():
                        $device_name = 'mobile';
                        break;
                    case $agent->isTv():
                        $device_name = 'tv';
                        break;
                    default:
                        $device_name = 'unknown';
                        break;
                }

                $user_role = Auth::user()->role;

                $user_check = LoggedDevice::where('user_id', Auth::User()->id)->count();

                $subuser_check = Multiprofile::where('parent_id', Auth::User()->id)->count();

                $alldevices_register = LoggedDevice::where('user_id', '=', Auth::User()->id)
                    ->where('device_name', '!=', $device_name)
                    ->where('user_ip', '!=', $userIp)
                    ->get();

                $alldevices = LoggedDevice::where('user_id', '=', Auth::User()->id)->get();

                $subscription_device_limit = Subscription::select('subscription_plans.devices')->join('subscription_plans', 'subscriptions.stripe_plan', '=', 'subscription_plans.plan_id')
                    ->where('subscriptions.user_id', Auth::User()->id)
                    ->get();

                if (count($subscription_device_limit) >= 1){

                    $device_limit = $subscription_device_limit[0]->devices;
                    $limit = explode(",", $device_limit);
                    $device_limit = count($limit);

                }else{
                    $device_limit = 0;
                }

                $devices_check = LoggedDevice::where('user_id',Auth::User()->id)->where('device_name', $device_name)->first();

                $already_logged = LoggedDevice::where('user_id', '=', Auth::User()->id)
                ->where('user_ip',  $userIp)->where('device_name', $device_name)->count();

                if($already_logged > 0){
                    $already_logged = LoggedDevice::where('user_id', '=', Auth::User()->id)
                    ->where('user_ip', $userIp)
                    ->where('device_name', $device_name)->delete();
                }

                $username = Auth::User()->username;
                $email = Auth::User()->email;
                $mail_check = ApprovalMailDevice::where('user_ip', '=', $userIp)->where('device_name', $device_name)->first();
                $user_check = LoggedDevice::where('user_id', '=', Auth::User()->id)->count();

                // if (count($alldevices_register) > 0  && $user_role == "registered" && Auth::User()->id != 1)
                // {
                //     LoggedDevice::where('user_ip','=', $userIp)->where('user_id', Auth::User()->id)->where('device_name', $device_name)->delete();

                //     try {

                //         Mail::send('emails.register_device_login', array('id' => Auth::User()->id,'name' => Auth::User()->username,) , function ($message) use ($email, $username){
                //             $message->from(AdminMail() , GetWebsiteName());
                //             $message->to($email, $username)->subject('Buy Subscriptions Plan To Access Multiple Devices');
                //         });
                //         $email_log      = 'Mail Sent Successfully from register device login ';
                //         $email_template = "0";
                //         $user_id = Auth::User()->id;

                //         Email_sent_log($user_id,$email_log,$email_template);

                //     } catch (\Throwable $th) {

                //         $email_log      = $th->getMessage();
                //         $email_template = "0";
                //         $user_id = Auth::User()->id;

                //         Email_notsent_log($user_id,$email_log,$email_template);
                //     }

                //     $message = 'Buy Subscriptions Plan To Access Multiple Devices.';
                //     Auth::logout();
                //     unset($data['password_hash']);
                //     \Session::flush();

                //     $url1 = $_SERVER['REQUEST_URI'];
                //     header("Refresh: 120; URL=$url1");
                //     $message = 'Your Plan Device  Limit Is' . ' ' . $device_limit;

                //     return view('device_logged', compact('alldevices', 'system_settings', 'user','userIp'))->with(array(
                //         'message' => $message,
                //         'note_type' => 'success'
                //     ));

                // }elseif ($user_check >= $device_limit && Auth::User()->role != "admin" && Auth::User()->role != "registered"){

                //     $url1 = $_SERVER['REQUEST_URI'];
                //     header("Refresh: 120; URL=$url1");
                //     $message = 'Your Plan Device  Limit Is' . ' ' . $device_limit;
                //     return view('device_logged', compact('alldevices', 'system_settings', 'user','userIp'))->with(array(
                //         'message' => $message,
                //         'note_type' => 'success'
                //     ));

                // }else{

                    $device_name = '';

                    switch (true) {
                        case $agent->isDesktop():
                            $device_name = 'desktop';
                            break;
                        case $agent->isTablet():
                            $device_name = 'tablet';
                            break;
                        case $agent->isMobile():
                            $device_name = 'mobile';
                            break;
                        case $agent->isTv():
                            $device_name = 'tv';
                            break;
                        default:
                            $device_name = 'unknown';
                            break;
                    }

                    if (!empty($device_name))
                    {

                        $devices_check = LoggedDevice::where('user_id', Auth::User()->id)->where('device_name', '=', $device_name)->first();

                        if (empty($devices_check))
                        {
                            $adddevice = new LoggedDevice;
                            $adddevice->user_id = Auth::User()->id;
                            $adddevice->user_ip = $userIp;
                            $adddevice->device_name = $device_name;
                            $adddevice->save();
                        }
                    }
                // }

                $logged = UserLogs::where('user_id', Auth::User()->id)->latest()
                    ->whereDate('created_at', '>=', \Carbon\Carbon::now()->today())->first();

                if (!empty($logged))
                {
                    $today_old_log = UserLogs::where('user_id', '=', Auth::User()->id)
                        ->latest()->whereDate('created_at', '>=', \Carbon\Carbon::now()->today())
                        ->delete();

                    $new_login = new UserLogs;
                    $new_login->user_id = Auth::User()->id;
                    $new_login->user_ip = $userIp;
                    $new_login->countryname = Country_name();
                    $new_login->regionname = Region_name();
                    $new_login->cityname = city_name();
                    $new_login->save();

                }else{

                    $new_login = new UserLogs;
                    $new_login->user_id = Auth::User()->id;
                    $new_login->user_ip = $userIp;
                    $new_login->countryname = Country_name();
                    $new_login->regionname = Region_name();
                    $new_login->cityname = city_name();
                    $new_login->save();
                }

                $users_logged_today = UserLogs::latest()->whereDate('created_at', '>=', \Carbon\Carbon::now()->today())->count();

                $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();

                // Mode -  Kids

                $Mode = $multiuser != null ? Multiprofile::where('id', $multiuser)->first() : User::where('id', Auth::User()->id)->first();

                if ($multiuser != null)
                {
                    $getcnt_watching = ContinueWatching::where('multiuser', $multiuser)->pluck('videoid')->toArray();

                    $cnt_watching = Video::select('id','title','slug','year','rating','access','publish_type','global_ppv','publish_time','publish_status','ppv_price','responsive_image','responsive_player_image','responsive_tv_image',
                                                    'duration','rating','image','featured','age_restrict','video_tv_image','player_image','details','description')->with('cnt_watch')->where('active', '=', '1')->where('status', '=', '1')
                                            ->where('draft', '1')->where('type','!=','embed')
                                            ->whereIn('id', $getcnt_watching)->limit(15)->get();

                }elseif (!Auth::guest()){

                    $continue_watching = ContinueWatching::where('user_id', Auth::user()->id)->first();

                    if ($continue_watching != null && $continue_watching->multiuser == null)
                    {
                        $getcnt_watching = ContinueWatching::where('user_id', Auth::user()->id)->pluck('videoid')->toArray();

                        $cnt_watching = Video::select('id','title','slug','year','rating','access','publish_type','global_ppv','publish_time','publish_status','ppv_price','responsive_image','responsive_player_image','responsive_tv_image',
                                                        'duration','rating','image','featured','age_restrict','video_tv_image','player_image','details','description')->with('cnt_watch')->where('active', '=', '1')->where('status', '=', '1')
                                                 ->where('draft', '1')
                                                 ->where('type','!=','embed')
                                                 ->whereIn('id', $getcnt_watching);
                                                if ($getfeching != null && $getfeching->geofencing == 'ON')
                                                {
                                                    $cnt_watching = $cnt_watching->whereNotIn('id', $blockvideos);
                                                }
                                                $cnt_watching = $cnt_watching->limit(15)->get();
                    }
                    else
                    {
                        $getcnt_watching = ContinueWatching::where('user_id', Auth::user()->id)
                            ->where('multiuser', 'data')
                            ->pluck('videoid')
                            ->toArray();

                        $cnt_watching = Video::select('id','title','slug','year','rating','access','publish_type','global_ppv','publish_time','publish_status','ppv_price','responsive_image','responsive_player_image','responsive_tv_image',
                                                        'duration','rating','image','featured','age_restrict','video_tv_image','player_image','details','description')->with('cnt_watch')->where('active', '=', '1')->where('status', '=', '1')
                                                ->where('draft', '=', '1')->where('type','!=','embed')->whereIn('id', $getcnt_watching);
                                                if ($getfeching != null && $getfeching->geofencing == 'ON')
                                                {
                                                    $cnt_watching = $cnt_watching->whereNotIn('id', $blockvideos);
                                                }
                                                $cnt_watching = $cnt_watching->limit(15)->get();
                    }

                }else{
                    $cnt_watching = '';
                }

                $currency = CurrencySetting::first();

                // Order Setting


                $home_settings_on_value = collect($this->HomeSetting)->filter(function ($value, $key) {
                    return $value === '1' || $value === 1;
                })->map(function ($value, $key) {
                    switch ($key) {
                        case 'channel_partner':
                            return 'ChannelPartner';
                        case 'content_partner':
                            return 'ContentPartner';
                        case 'video_schedule':
                            return 'video_schedule';
                        case 'SeriesGenre':
                            return 'Series_Genre';
                        case 'SeriesGenre_videos':
                            return 'Series_Genre_videos';
                        case 'AudioGenre':
                            return 'Audio_Genre';
                        case 'AudioGenre_audios':
                            return 'Audio_Genre_audios';
                        case 'my_playlist':
                            return 'Audio_Genre_audios';
                        default:
                            return $key;
                    }
                })->values()->toArray();

                $order_settings = OrderHomeSetting::select('video_name')->whereIn('video_name',$home_settings_on_value)->orderBy('order_id', 'asc');
                $pagination_value = HomeSetting::pluck('web_pagination_count')->first();

                if($this->HomeSetting->theme_choosen == "theme4" || $this->HomeSetting->theme_choosen == "default"){
                    $order_settings = $order_settings->paginate($pagination_value);    // Pagination
                }else{
                    $order_settings = $order_settings->get();
                }

                $FrontEndQueryController = new FrontEndQueryController();
                $button_text = ButtonText::first();

                if($this->HomeSetting->theme_choosen == "theme4"){
                    $data = array(

                        'currency'          => $currency,
                        'current_theme'     => $this->HomeSetting->theme_choosen,
                        'settings'          => $settings,
                        'pages'             => Page::all(),
                        'current_page'      => 1,
                        'pagination_url'    => '/videos',
                        'cnt_watching'      => $cnt_watching,
                        'ppv_gobal_price'   => $ppv_gobal_price,
                        'countryName'       => $countryName,
                        'Family_Mode'       => 2,
                        'Kids_Mode'         => $Mode['Kids_Mode'],
                        'Mode'              => $Mode,
                        'ThumbnailSetting'  => $FrontEndQueryController->ThumbnailSetting(),
                        'order_settings_list' => OrderHomeSetting::get(),
                        'order_settings'      => $order_settings ,
                        'getfeching'          => $getfeching ,
                        'home_settings'       => $this->HomeSetting ,
                        'videos_expiry_date_status'    => videos_expiry_date_status(),
                        'Series_Networks_Status'       => Series_Networks_Status(),
                        'default_vertical_image_url'   => $default_vertical_image_url,
                        'default_horizontal_image_url' => $default_horizontal_image_url,
                        'multiple_compress_image'      => CompressImage::pluck('enable_multiple_compress_image')->first() ? CompressImage::pluck('enable_multiple_compress_image')->first() : 0,
                        'featured_episodes' => $FrontEndQueryController->featured_episodes()->take(15),
                        'latest_episode'      => $FrontEndQueryController->latest_episodes()->take(15),
                        'livetream'              => $FrontEndQueryController->livestreams()->take(15),
                        'latest_series'          => $FrontEndQueryController->latest_Series()->take(15),
                        'LiveCategory'           => $FrontEndQueryController->LiveCategory()->take(15),
                        'Series_based_on_Networks' => $FrontEndQueryController->Series_based_on_Networks(),
                        'Series_based_on_category' => $FrontEndQueryController->Series_based_on_category()->take(15),
                        'admin_advertistment_banners' => $FrontEndQueryController->admin_advertistment_banners(),
                        'Epg'                 => $FrontEndQueryController->Epg(),
                        'button_text'         => $button_text, 
                        'VideoJsContinueWatching'             => $FrontEndQueryController->VideoJsContinueWatching(),
                        'VideoJsEpisodeContinueWatching'      => $FrontEndQueryController->VideoJsEpisodeContinueWatching(),
                        'BaseURL'                            => $this->BaseURL
                    );
                }else{

                    $data = array(

                        'currency'          => $currency,
                        'current_theme'     => $this->HomeSetting->theme_choosen,
                        'settings'          => $settings,
                        'pages'             => Page::all(),
                        'current_page'      => 1,
                        'pagination_url'    => '/videos',
                        'cnt_watching'      => $cnt_watching,
                        'ppv_gobal_price'   => $ppv_gobal_price,
                        'countryName'       => $countryName,
                        'Family_Mode'       => 2,
                        'Kids_Mode'         => $Mode['Kids_Mode'],
                        'Mode'              => $Mode,
                        'ThumbnailSetting'  => $FrontEndQueryController->ThumbnailSetting(),
                        'order_settings_list' => OrderHomeSetting::get(),
                        'order_settings'      => $order_settings ,
                        'getfeching'          => $getfeching ,
                        'home_settings'       => $this->HomeSetting ,
                        'videos_expiry_date_status'    => videos_expiry_date_status(),
                        'Series_Networks_Status'       => Series_Networks_Status(),
                        'default_vertical_image_url'   => $default_vertical_image_url,
                        'default_horizontal_image_url' => $default_horizontal_image_url,
                        'multiple_compress_image'      => CompressImage::pluck('enable_multiple_compress_image')->first() ? CompressImage::pluck('enable_multiple_compress_image')->first() : 0,
                        'videos'            => $FrontEndQueryController->Latest_videos()->take(15),
                        'latest_video'      => $FrontEndQueryController->Latest_videos()->take(15),
                        'latest_videos'     => $FrontEndQueryController->Latest_videos()->take(15),
                        'latestViewedVideos'     => $FrontEndQueryController->latestViewedVideos()->take(15),
                        'trendings'         => $FrontEndQueryController->trending_videos()->take(15),
                        'trending_videos'   => $FrontEndQueryController->trending_videos()->take(15),
                        'suggested_videos'  => $FrontEndQueryController->trending_videos()->take(15),
                        'latest_audios'     => $FrontEndQueryController->latest_audios()->take(15),
                        'audios'            => $FrontEndQueryController->latest_audios()->take(15),
                        'featured_videos'   => $FrontEndQueryController->featured_videos()->take(15),
                        'featured_episodes' => $FrontEndQueryController->featured_episodes()->take(15),
                        'genre_video_display' => $FrontEndQueryController->genre_video_display()->take(15),
                        'genres'              => $FrontEndQueryController->genre_video_display()->take(15),
                        'video_categories'    => $FrontEndQueryController->genre_video_display()->take(15),
                        'Video_Based_Category'    => $FrontEndQueryController->Video_Based_Category()->take(15),
                        'albums'              => $FrontEndQueryController->AudioAlbums()->take(15),
                        'latest_episode'      => $FrontEndQueryController->latest_episodes()->take(15),
                        'livetream'              => $FrontEndQueryController->livestreams()->take(15),
                        'latest_series'          => $FrontEndQueryController->latest_Series()->take(15),
                        'artist'                 => $FrontEndQueryController->artist()->take(15),
                        'VideoSchedules'         => $FrontEndQueryController->VideoSchedules()->take(15),
                        'LiveCategory'           => $FrontEndQueryController->LiveCategory()->take(15),
                        'AudioCategory'          => $FrontEndQueryController->AudioCategory()->take(15),
                        'Series_based_on_Networks' => $FrontEndQueryController->Series_based_on_Networks(),
                        'Series_based_on_category' => $FrontEndQueryController->Series_based_on_category()->take(15),
                        'artist_live_event'         => $FrontEndQueryController->LiveEventArtist()->take(15),
                        'SeriesGenre'               =>  $FrontEndQueryController->SeriesGenre()->take(15),
                        'trending_audios'           => $FrontEndQueryController->trending_audios()->take(15),
                        'admin_advertistment_banners' => $FrontEndQueryController->admin_advertistment_banners(),
                        'sliders'            => $FrontEndQueryController->sliders(),
                        'live_banner'        => $FrontEndQueryController->live_banners(),
                        'video_banners'      => $FrontEndQueryController->video_banners(),
                        'series_sliders'     => $FrontEndQueryController->series_sliders(),
                        'live_event_banners' => $FrontEndQueryController->live_event_banners(),
                        'Episode_sliders'    => $FrontEndQueryController->Episode_sliders(),
                        'VideoCategory_banner' => $FrontEndQueryController->VideoCategory_banner(),
                        'most_watch_user'      => $FrontEndQueryController->Most_watched_videos_users(),
                        'top_most_watched'     => $FrontEndQueryController->Most_watched_videos_site(),
                        'Most_watched_country'   =>  $FrontEndQueryController->Most_watched_videos_country(),
                        'preference_genres'      => $FrontEndQueryController->preference_genres(),
                        'preference_Language'    => $FrontEndQueryController->preference_language(),
                        'Epg'                 => $FrontEndQueryController->Epg(),
                        'ugc_videos'        => $FrontEndQueryController->UGCVideos(),
                        'ugc_shorts_minis'  => $FrontEndQueryController->UGCShortsMinis(),
                        'ugc_users'         => $FrontEndQueryController->UGCUsers(),  
                        'button_text'         => $button_text, 
                        'top_ten_videos'      => $FrontEndQueryController->TopTenVideos(), 
                        'VideoJsContinueWatching'             => $FrontEndQueryController->VideoJsContinueWatching(),
                        'VideoJsEpisodeContinueWatching'      => $FrontEndQueryController->VideoJsEpisodeContinueWatching(),
                        'radiostations'            => $FrontEndQueryController->RadioStation()->take(15),
                    );
                }
                // dd($data['order_settings']->first()->video_name);
                if($this->HomeSetting->theme_choosen == "theme4" || $this->HomeSetting->theme_choosen == "default"){
                    if($request->ajax()) {
                        return $data = [
                            "view" => Theme::watchPartial('home_sections', $data ),
                            "section_name" => $data['order_settings']->first()->video_name,
                            'url' => $data['order_settings']->nextPageUrl()
                        ];
                    }
                }

                return Theme::view('home', $data);
            }
        }
    }

    // public function loadMore(Request $request)
    // {

    //     $theme = Theme::uses($this->HomeSetting->theme_choosen);

    //     $FrontEndQueryController = new FrontEndQueryController();
    //     $default_vertical_image_url = default_vertical_image_url();
    //     $default_horizontal_image_url = default_horizontal_image_url();
    //     $offset = $request->input('index', 0);
    //     $name = $FrontEndQueryController->Series_based_on_Networks()->skip($offset)->pluck('name');
    //     $count = ($offset == $FrontEndQueryController->Series_based_on_Networks()->count()) ? true : false;

    //     $data = [
    //             'data' => $FrontEndQueryController->Series_based_on_Networks()->skip($offset)->first(),
    //             'default_vertical_image_url'   => $default_vertical_image_url,
    //             'default_horizontal_image_url' => $default_horizontal_image_url,
    //             'multiple_compress_image'      => CompressImage::pluck('enable_multiple_compress_image')->first() ? CompressImage::pluck('enable_multiple_compress_image')->first() : 0,
    //     ];
    //     // dd($data['data']);

    //     $viewContent = $theme->load('public/themes/theme4/views/partials/home/Series-based-on-Networks', compact('data'))->content(); // or ->content()

    //     return response()->json([
    //         'view'        => $viewContent,
    //         'count'       => $count,
    //         'name'        => $name
    //     ]);

    // }


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
                    // 'password' => 'required|string|min:6|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
                    'password' => 'required',

                ]);
            }
            if($SignupMenu->mobile == 1){
                $validatedData = $request->validate([
                    'mobile' => ['required', 'numeric', 'min:8', 'unique:users'],
                ]);
            }
            if($SignupMenu->dob == 1){
                $validatedData = $request->validate([
                    'dob' =>  ['required', 'date'],
                ]);
            }

            if($SignupMenu->password_confirm == 1){
                $validatedData = $request->validate([
                    // 'password_confirmation' => 'required',
                    'password_confirmation' => 'required'
                ]);
            }
            if($SignupMenu->country == 1){
                $validatedData = $request->validate([
                    'country' =>  ['required'],
                ]);
            }
            if($SignupMenu->state == 1){
                $validatedData = $request->validate([
                    'state' =>  ['required'],
                ]);
            }
            if($SignupMenu->city == 1){
                $validatedData = $request->validate([
                    'city' =>  ['required'],
                ]);
            }
            if($SignupMenu->support_username == 1){
                $validatedData = $request->validate([
                    'support_username' =>  ['required'],
                ]);
            }

            $validatedData = $request->validate([
                'g-recaptcha-response' => get_enable_captcha_signup() == 1 ? 'required|captcha' : '',
            ]);
        }else{

            $validatedData = $request->validate(
                [   'username' => ['required', 'string'],
                    'email' => ['required', 'string', 'email', 'unique:users'],
                    // 'password' => 'required|string|min:6|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
                    // 'password_confirmation' => 'required',
                    'mobile' => ['required', 'numeric', 'min:8', 'unique:users'],
                    // 'password_confirmation' => 'required|confirmed',
                    'g-recaptcha-response' => get_enable_captcha_signup() == 1 ? 'required|captcha' : '',
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
        $DOB = $request->get('dob');
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
                $new_user->DOB = $DOB;
                //   $new_user->password = $get_password;
                $new_user->password = Hash::make($get_password);
                $new_user->activation_code = $string;
                $new_user->countryname = Country_name();
                $new_user->country = $request->get('country');
                $new_user->state = $request->get('state');
                $new_user->city = $request->get('city');
                $new_user->support_username = $request->get('support_username');
                $new_user->gender = $request->get('gender');
                $new_user->save();
                $settings = Setting::first();

                // verify email
                try {
                    \Mail::send('emails.verify', array(
                        'activation_code' => $string,
                        'website_name' => $settings->website_name
                    ) , 

                    function($message) use ($request) {
                        $message->from(AdminMail(),GetWebsiteName());
                        $message->to($request->email, $request->name)->subject('Verify your email address');
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
                $new_user->countryname = Country_name();
                $new_user->country = $request->get('country');
                $new_user->state = $request->get('state');
                $new_user->city = $request->get('city');
                $new_user->support_username = $request->get('support_username');
                $new_user->DOB = $DOB;
                $new_user->gender = $request->get('gender');
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

        $settings = Setting::first();

        if ($request->ajax())
        {
            $videos = Video::select('videos.*', 'categoryvideos.category_id', 'categoryvideos.video_id', 'video_categories.id', 'video_categories.name as category_name')
                            ->leftJoin('categoryvideos', 'categoryvideos.video_id', '=', 'videos.id')
                            ->leftJoin('video_categories', 'video_categories.id', '=', 'categoryvideos.category_id')
                            ->where('videos.active', 1)
                            ->where('videos.status', 1) 
                            ->where(function ($query) use ($settings, $request) {
                                // search filters start
                                if ($settings->search_tags_status) {
                                    $query->orWhere('videos.search_tags', 'LIKE', '%' . $request->country . '%');
                                }
                                if ($settings->search_title_status) {
                                    $query->orWhere('videos.title', 'LIKE', '%' . $request->country . '%');
                                }
                                if ($settings->search_category_status) {
                                    $query->orWhere('video_categories.name', 'LIKE', '%' . $request->country . '%');
                                }
                                if ($settings->search_description_status) {
                                    $query->orWhere('videos.description', 'LIKE', '%' . $request->country . '%');
                                }
                                if ($settings->search_details_status) {
                                    $query->orWhere('videos.details', 'LIKE', '%' . $request->country . '%');
                                }
                            })
                            ->when(Geofencing() != null && Geofencing()->geofencing == 'ON', function ($query) {
                                return $query->whereNotIn('videos.id', Block_videos());
                            })
                            ->orderBy('created_at', 'desc')
                            ->groupBy('videos.id')
                            ->limit(10)
                            ->get();

            $livestream = LiveStream::Select('live_streams.*','livecategories.live_id','live_categories.name','livecategories.category_id','live_categories.id')
                            ->leftJoin('livecategories','livecategories.live_id','=','live_streams.id')
                            ->leftJoin('live_categories','live_categories.id','=','livecategories.category_id')

                            ->when($settings->search_tags_status, function ($query) use ($request) {
                                return $query->orwhere('live_streams.search_tags', 'LIKE', '%' . $request->country . '%');
                            })

                            ->when($settings->search_title_status, function ($query) use ($request) {
                                return $query ->orwhere('live_streams.title', 'LIKE', '%' . $request->country . '%');
                            })

                            ->when($settings->search_description_status, function ($query) use ($request) {
                                return $query->orwhere('live_streams.description', 'LIKE', '%' . $request->country . '%');
                            })

                            ->when($settings->search_details_status, function ($query) use ($request) {
                                return $query->orwhere('live_streams.details', 'LIKE', '%' . $request->country . '%');
                            })

                            ->when($settings->search_category_status, function ($query) use ($request) {
                                return $query->orwhere('live_categories.name', 'LIKE', '%' . $request->country . '%');
                            })
                            ->where('live_streams.active', '=', '1')
                            // ->where('status', '=', '1')
                            ->limit('10')
                            ->groupBy('live_streams.id')
                            ->get();

            $audio = Audio::Select('audio.*','category_audios.audio_id','audio_categories.name','category_audios.category_id','audio_categories.id')
                            ->leftJoin('category_audios','category_audios.audio_id','=','audio.id')
                            ->leftJoin('audio_categories','audio_categories.id','=','category_audios.category_id')


                            ->when($settings->search_tags_status, function ($query) use ($request) {
                                return $query->orwhere('search_tags', 'LIKE', '%' . $request->country . '%');
                            })

                            ->when($settings->search_title_status, function ($query) use ($request) {
                                return $query ->orwhere('title', 'LIKE', '%' . $request->country . '%');
                            })

                            ->when($settings->search_description_status, function ($query) use ($request) {
                                return $query->orwhere('description', 'LIKE', '%' . $request->country . '%');
                            })

                            ->when($settings->search_details_status, function ($query) use ($request) {
                                return $query->orwhere('details', 'LIKE', '%' . $request->country . '%');
                            })

                            ->when($settings->search_category_status, function ($query) use ($request) {
                                return $query->orwhere('audio_categories.name', 'LIKE', '%' . $request->country . '%');
                            })

                            ->where('audio.active', '1')->where('audio.status', '1')

                        ->limit('10')
                        ->get();


            $Episode = Episode::Select('episodes.*','series.id','series_categories.category_id')
                            ->leftJoin('series','series.id','=','episodes.series_id')
                            ->leftJoin('series_categories','series_categories.series_id','=','series.id')
                            ->leftJoin('series_genre','series_genre.id','=','series_categories.category_id')

                            ->when($settings->search_tags_status, function ($query) use ($request) {
                                return $query->orwhere('episodes.search_tags', 'LIKE', '%' . $request->country . '%');
                            })

                            ->when($settings->search_title_status, function ($query) use ($request) {
                                return $query ->orwhere('episodes.title', 'LIKE', '%' . $request->country . '%');
                            })

                            ->when($settings->search_description_status, function ($query) use ($request) {
                                return $query->orwhere('episodes.episode_description', 'LIKE', '%' . $request->country . '%');
                            })

                            ->when($settings->search_category_status, function ($query) use ($request) {
                                return $query->orwhere('series_genre.name', 'LIKE', '%' . $request->country . '%');
                            })

                            ->where('episodes.active', '=', '1')
                            ->where('episodes.status', '=', '1')
                            ->groupBy('episodes.id')
                            ->limit('10')
                            ->get();

            $Series = Series::Select('series.*','series_categories.category_id')
                            ->leftJoin('series_categories','series_categories.series_id','=','series.id')
                            ->leftJoin('series_genre','series_genre.id','=','series_categories.category_id')


                            ->when($settings->search_tags_status, function ($query) use ($request) {
                                return $query->orwhere('series.search_tag', 'LIKE', '%' . $request->country . '%');
                            })

                            ->when($settings->search_title_status, function ($query) use ($request) {
                                return $query ->orwhere('series.title', 'LIKE', '%' . $request->country . '%');
                            })

                            ->when($settings->search_description_status, function ($query) use ($request) {
                                return $query->orwhere('series.description', 'LIKE', '%' . $request->country . '%');
                            })

                            ->when($settings->search_details_status, function ($query) use ($request) {
                                return $query->orwhere('series.details', 'LIKE', '%' . $request->country . '%');
                            })

                            ->when($settings->search_category_status, function ($query) use ($request) {
                                return $query->orwhere('series_genre.name', 'LIKE', '%' . $request->country . '%');
                            })

                            ->orwhere('.search_tag', 'LIKE', '%' . $request->country . '%')
                            ->orwhere('.title', 'LIKE', '%' . $request->country . '%')
                            ->orwhere('.name', 'LIKE', '%' . $request->country . '%')

                            ->where('series.active', '=', '1')
                            ->groupBy('series.id')
                            ->limit('10')
                            ->get();

            $station_audio = MusicStation::where('station_name', 'LIKE', '%' . $request->country . '%')
                            ->orwhere('station_slug', 'LIKE', '%' . $request->country . '%')
                            ->limit('10')
                            ->get();


            if (count($videos) > 0 || count($livestream) > 0 || count($Episode) > 0 || count($audio) > 0 || count($Series) > 0 && !empty($request->country) )
            {

                // videos Search
                    if(count($videos) > 0){
                        $output = '<ul class="list-group" style="display: block; position: relative; z-index: 999999;;margin-bottom: 0;border-radius: 0;">';
                        $output .= "<h6 style='margin: 0;text-align: left;padding: 10px;'> Videos</h6>";
                        foreach ($videos as $row)
                        {
                            $output .= '<li class="list-group-item">
                            <a href="' . URL::to('/') . '/category/videos/' . $row->slug . '" style="font-color: #c61f1f00;color: #000;text-decoration: none;"><div>' . $row->title . '</div></a></li>';
                        }

                    }else{
                        $output  = null ;
                    }

                // livestream Search
                    if(count($livestream) > 0){

                        $livestreams = '<ul class="list-group" style="display: block; position: relative; z-index: 999999;;margin-bottom: 0;border-radius: 0;">';
                        $livestreams .= "<h6 style='margin: 0;text-align: left;padding: 10px;'> Live Videos</h6>";
                        foreach ($livestream as $row)
                        {
                            $livestreams .= '<li class="list-group-item">
                            <a href="' . URL::to('/') . '/live' .'/'. $row->slug . '" style="font-color: #c61f1f00;color: #000;text-decoration: none;"><div><' . $row->title . '</div></a></li>';
                        }
                    }
                    else{
                        $livestreams = null ;
                    }

                // Audio Search

                    if(count($audio) > 0){
                        $audios = '<ul class="list-group" style="display: block; position: relative; z-index: 999999;;margin-bottom: 0;border-radius: 0;">';
                        $audios .= "<h6 style='margin: 0;text-align: left;padding: 10px;'> Audio </h6>";
                        foreach ($audio as $row)
                        {
                            $audios .= '<li class="list-group-item">
                            <a href="' . URL::to('/') . '/audio/' . $row->slug . '" style="font-color: #c61f1f00;color: #000;text-decoration: none;"><div>' . $row->title . '</div></a></li>';
                        }
                    }
                    else{
                        $audios = null ;
                    }

                // Episode

                    if(count($Episode) > 0){
                        $Episodes = '<ul class="list-group" style="display: block; position: relative; z-index: 999999;;margin-bottom: 0;border-radius: 0;">';
                        $Episodes .= "<h6 style='margin: 0;text-align: left;padding: 10px;'> Episode </h6>";
                        foreach ($Episode as $row)
                        {
                            if( $row->slug != null ){

                                $series_slug = Series::select('id','title','slug','year','rating','access',
                                                'duration','rating','image','featured','tv_image','player_image','details','description')
                                                ->where('id',$row->series_id)->pluck('slug')->first();
                                $Episodes .= '<li class="list-group-item">
                                <a href="' . URL::to('/') . '/episode' .'/'. $series_slug . '/'. $row->slug . '" style="font-color: #c61f1f00;color: #000;text-decoration: none;"><div>' . $row->title . '</div></a></li>';
                            }
                        }
                    }
                    else{
                        $Episodes = null ;
                    }

                // Series Search

                if(count($Series) > 0){

                    $Series_search = '<ul class="list-group" style="display: block; position: relative; z-index: 999999;;margin-bottom: 0;border-radius: 0;">';
                    $Series_search .= "<h6 style='margin: 0;text-align: left;padding: 10px;'> Series Videos</h6>";
                    foreach ($Series as $row)
                    {
                        $Series_search .= '<li class="list-group-item">
                        <a href="' . URL::to('/') . '/play_series' .'/'. $row->slug . '" style="font-color: #c61f1f00;color: #000;text-decoration: none;"><div>' . $row->title . '</div></a></li>';
                    }
                }
                else{
                    $Series_search = null ;
                }

                // station Search

                if(count($station_audio) > 0){

                    $station_search = '<ul class="list-group" style="display: block; position: relative; z-index: 999999;;margin-bottom: 0;border-radius: 0;">';
                    $station_search .= "<h6 style='margin: 0;text-align: left;padding: 10px;'> Music Station </h6>";
                    foreach ($station_audio as $row)
                    {
                        $station_search .= '<li class="list-group-item">
                        <a href="' . URL::to('/') . '/music-station' .'/'. $row->station_slug . '" style="font-color: #c61f1f00;color: #000;text-decoration: none;"><div>' . $row->station_name . '</div></a></li>';
                    }
                }
                else{
                    $station_search = null ;
                }

                return $output.$audios.$livestreams.$Episodes.$Series_search.$station_search;
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
        try {
            return redirect()->to('/Featured_videos');

            $ThumbnailSetting = ThumbnailSetting::first();
            $currency = CurrencySetting::first();
            $PPV_settings = Setting::where('ppv_status', 1)->first();

            $ppv_gobal_price = !empty($PPV_settings ) ? $PPV_settings->ppv_price :  null;

            if(!Auth::guest() ){

                $multiuser = Session::get('subuser_id');

                $Mode = $multiuser != null ?  Multiprofile::where('id', $multiuser)->first() : User::where('id', Auth::User()->id)->first();

                $check_Kidmode = $Mode['user_type'] != null && $Mode['user_type'] == "Kids" ? 1 : 0 ;
            }


            $featured_videos = Video::select('id','title','slug','year','rating','access','publish_type','global_ppv','publish_time','publish_status','ppv_price','responsive_image','responsive_player_image','responsive_tv_image',
                                'duration','rating','image','featured','age_restrict','video_tv_image','player_image','details','description')
                                    ->where('videos.active', '1')->where('videos.status', '1')
                                    ->where('videos.draft', '1')->where('videos.featured','1');

                if(Geofencing() !=null && Geofencing()->geofencing == 'ON'){
                    $featured_videos = $featured_videos  ->whereNotIn('videos.id',Block_videos());
                }

                if( !Auth::guest() && $check_Kidmode == 1 )
                {
                    $featured_videos = $featured_videos->whereBetween('videos.age_restrict', [ 0, 12 ]);
                }

                if (videos_expiry_date_status() == 1 ) {
                    $featured_videos = $featured_videos->whereNull('expiry_date')->orwhere('expiry_date', '>=', Carbon\Carbon::now()->format('Y-m-d\TH:i') );
                }

                $featured_videos = $featured_videos->orderBy('videos.created_at','desc')->limit(50)->paginate($this->videos_per_page);

            $data = array(
                'featured_videos' => $featured_videos,
                'ppv_gobal_price' => $ppv_gobal_price,
                'currency' => $currency,
                'ThumbnailSetting' => $ThumbnailSetting,
            );

            return Theme::view('featured', $data);

        } catch (\Throwable $th) {
            // return $th->getMessage();
            return abort(404);
        }

    }

    public function LatestVideos()
    {
        $settings = Setting::first();

        if($settings->enable_landing_page == 1 && Auth::guest()){

            $landing_page_slug = AdminLandingPage::where('status',1)->pluck('slug')->first() ? AdminLandingPage::where('status',1)->pluck('slug')->first() : "landing-page" ;

            return redirect()->route('landing_page', $landing_page_slug );
        }

        return redirect()->to('/Latest_videos');

        $multiuser = Session::get('subuser_id');

        if(!Auth::guest()):

            $Mode = $multiuser != null ?  Multiprofile::where('id', $multiuser)->first() : User::where('id', Auth::User()->id)->first();
        else:

            $Mode['user_type'] = null ;
        endif;


        $check_Kidmode = $Mode['user_type'] != null && $Mode['user_type'] == "Kids" ? 1 : 0 ;


        $latest_videos_count = Video::select('id')->where('active', '=', '1')->where('status', '=', '1')
                                ->where('draft', '=', '1')->latest()->count();

        if ($latest_videos_count > 0)
        {
            $latest_videos = Video::select('id','title','slug','year','rating','access','publish_type','global_ppv','publish_time','publish_status','ppv_price','responsive_image','responsive_player_image','responsive_tv_image',
            'duration','rating','image','featured','age_restrict','video_tv_image','player_image','details','description')
                ->where('active', '=', '1')->where('status', '=', '1')
                ->where('draft', '=', '1')->latest();

                if (Geofencing() != null && Geofencing()->geofencing == 'ON')
                {
                    $latest_videos = $latest_videos->whereNotIn('videos.id', Block_videos());
                }

                if( $check_Kidmode == 1 )
                {
                    $latest_videos = $latest_videos->whereBetween('videos.age_restrict', [ 0, 12 ]);
                }

                if (videos_expiry_date_status() == 1 ) {
                    $latest_videos = $latest_videos->whereNull('expiry_date')->orwhere('expiry_date', '>=', Carbon\Carbon::now()->format('Y-m-d\TH:i') );
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
        try {

            $FrontEndQueryController = new FrontEndQueryController();

            $LanguageVideo = LanguageVideo::where('language_id',$lanid)->groupBy('video_id')->pluck('video_id');

            $language_videos = Video::join('languagevideos', 'languagevideos.video_id', '=', 'videos.id')
                ->where('language_id', '=', $lanid)->where('active', '=', '1')->where('status', '=', '1')
                ->where('draft', '=', '1');

                if(Geofencing() !=null && Geofencing()->geofencing == 'ON'){
                    $categoryVideos = $categoryVideos->whereNotIn('videos.id', Block_videos());
                }

            $language_videos = $language_videos->latest('videos.created_at')->get();


            $Most_watched_country = RecentView::select('video_id', 'videos.*', DB::raw('COUNT(video_id) AS count'))
                        ->join('videos', 'videos.id', '=', 'recent_views.video_id')
                        ->where('videos.status', '=', '1')->where('videos.draft', '=', '1')
                        ->where('videos.active', '=', '1')->groupBy('video_id')
                        ->orderByRaw('count DESC');

                if(Geofencing() !=null && Geofencing()->geofencing == 'ON'){
                    $Most_watched_country = $Most_watched_country->whereNotIn('videos.id', Block_videos());
                }

            $Most_watched_country = $Most_watched_country->where('recent_views.country_name', Country_name())
                            ->whereNotIn('videos.id',Block_videos() )->whereIn('videos.id',$LanguageVideo)
                            ->limit(15)->get()->map(function ($item) {

                            $item['categories'] =  CategoryVideo::select('categoryvideos.*','category_id','video_id','video_categories.name as name','video_categories.slug')
                                                        ->join('video_categories','video_categories.id','=','categoryvideos.category_id')
                                                        ->where('video_id', $item->video_id )
                                                        ->pluck('name')
                                                        ->implode(',');

                                return $item;
            });

            $top_most_watched = RecentView::select('video_id', 'videos.*', DB::raw('COUNT(video_id) AS count'))
                            ->join('videos', 'videos.id', '=', 'recent_views.video_id')->where('videos.status', '=', '1')
                            ->where('videos.draft', '=', '1')->where('videos.active', '=', '1')
                            ->whereIn('videos.id',$LanguageVideo)
                            ->groupBy('video_id');

                            if(Geofencing() !=null && Geofencing()->geofencing == 'ON'){
                                $top_most_watched = $top_most_watched->whereNotIn('videos.id', Block_videos());
                            }

            $top_most_watched = $top_most_watched->orderByRaw('count DESC')->limit(15)->get();

            $video_banners = Video::select('id','title','slug','year','rating','access','publish_type','global_ppv','publish_time','publish_status','ppv_price','responsive_image','responsive_player_image','responsive_tv_image',
                                        'duration','rating','image','featured','age_restrict','video_tv_image','player_image','details','description','video_title_image','enable_video_title_image', 'trailer','trailer_type','video_title_image','enable_video_title_image')->where('active', '=', '1')->whereIn('videos.id',$LanguageVideo)
                                        ->where('draft', '1')->where('status', '1')
                                        ->where('banner', '1')->latest()
                                        ->get() ;

            $language_name = Language::where('id', $lanid)->pluck('name')->first();

            $data = array(
                'lang_videos' => $language_videos,
                'language_name' => $language_name,
                'Most_watched_country' => $Most_watched_country ,
                'top_most_watched'     => $top_most_watched ,
                'video_banners'        => $FrontEndQueryController->video_banners(),
                'currency'         => CurrencySetting::first(),
                'ThumbnailSetting' => ThumbnailSetting::first()
            );


        } catch (\Throwable $th) {
            // return $th->getMessage();
            return abort(404);
        }

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

        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();

        $video_id = $request->videoid ;
        $like     = $request->like ;

        // return $like ;

        $video_count = LikeDisLike::where("video_id", $video_id);

        if( !Auth::guest() ){
            $video_count = $video_count->where("user_id", Auth::User()->id);

        }else{
            $video_count = $video_count->where("users_ip_address",  $geoip->getIP() );
        }

        $video_count = $video_count->count();

        if ($video_count > 0)
        {

            $video_new = LikeDisLike::where("video_id", $video_id);

            if( !Auth::guest() ){
                $video_new = $video_new->where("user_id", Auth::User()->id);

            }else{
                $video_new = $video_new->where("users_ip_address",  $geoip->getIP() );
            }

            $video_new = $video_new->first();

            if ($like == 1)
            {
                if( !Auth::guest() ){
                    $video_new->user_id = Auth::user()->id;

                }else{
                    $video_new->users_ip_address = $geoip->getIP() ;
                }

                $video_new->video_id = $video_id;
                $video_new->liked = 1;
                $video_new->disliked = 0;
                $video_new->save();

                $response = array('status' => "liked" );
            }
            elseif( $like == 0 )
            {
                if( !Auth::guest() ){
                    $video_new->user_id = Auth::user()->id;

                }else{
                    $video_new->users_ip_address = $geoip->getIP() ;
                }
                $video_new->video_id = $video_id;
                $video_new->liked = 0;
                $video_new->save();

                $response = array(
                    'status' => "unliked"
                );
            }
        }
        else
        {
            $video_new = new LikeDisLike;
            $video_new->video_id = $video_id;

            if( !Auth::guest() ){
                $video_new->user_id = Auth::user()->id;

            }else{
                $video_new->users_ip_address = $geoip->getIP() ;
            }

            $video_new->liked = $like;
            $video_new->disliked = 0;
            $video_new->save();
            $response = array( 'status' => 'liked');
        }

        return response()->json($response, 200);

    }

    public function DisLikeVideo(Request $request)
    {
        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();

        $video_id = $request->videoid;
        $dislike = $request->dislike;

        $d_like = Likedislike::where("video_id", $video_id);

            if( !Auth::guest() ){
                $d_like = $d_like->where("user_id", Auth::User()->id);

            }else{
                $d_like = $d_like->where("users_ip_address",  $geoip->getIP() );
            }

        $d_like = $d_like->count();

        if ($d_like > 0)
        {
            $new_vide_dislike = Likedislike::where("video_id", $video_id);

                if( !Auth::guest() ){
                    $new_vide_dislike = $new_vide_dislike->where("user_id", Auth::User()->id);

                }else{
                    $new_vide_dislike = $new_vide_dislike->where("users_ip_address",  $geoip->getIP() );
                }

            $new_vide_dislike = $new_vide_dislike->first();

            if ($dislike == 1)
            {
                if( !Auth::guest() ){
                    $new_vide_dislike->user_id = Auth::user()->id;

                }else{
                    $new_vide_dislike->users_ip_address = $geoip->getIP() ;
                }

                $new_vide_dislike->video_id = $video_id;
                $new_vide_dislike->liked = 0;
                $new_vide_dislike->disliked = 1;
                $new_vide_dislike->save();

                $response = array('status' => "disliked" );
            }
            else
            {
                if( !Auth::guest() ){
                    $new_vide_dislike->user_id = Auth::user()->id;

                }else{
                    $new_vide_dislike->users_ip_address = $geoip->getIP() ;
                }
                $new_vide_dislike->video_id = $video_id;
                $new_vide_dislike->disliked = 0;
                // $new_vide_dislike->liked = 0;
                $new_vide_dislike->save();
                $response = array(
                    'status' => "undisliked"
                );
            }
        }
        else
        {
            $new_vide_dislike = new Likedislike;

            if( !Auth::guest() ){
                $new_vide_dislike->user_id = Auth::user()->id;

            }else{
                $new_vide_dislike->users_ip_address = $geoip->getIP() ;
            }
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

    public function Multipleprofile(Request $request)
    {

        $data = \Session::all();

        $settings = Setting::first();

        if(Auth::user() == null){
            return redirect::to('/login');
        }

        if($settings->activation_email == 1 && !Auth::guest() && Auth::user()->activation_code != null){


            unset($data['password_hash']);

            if(!empty($data['user'])){
                unset($data['expiresIn']);
                unset($data['providertoken']);
                unset($data['user']);
                Cache::flush();
            }

            $request->session()->flush();
            $request->session()->regenerate();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            \Session::flush();

            Auth::logout();

            return Redirect::to('/login')->with(
                "message",
                "Please Verify through your email account and Login"
            );

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

        $redirection_url = session()->get('url.intended', URL::to('/home') );

        $data = array(
            'users' => $users,
            'Website_name' => $Website_name,
            'screen' => $screen,
            'subcriber_user' => $subcriber_user,
            'multiuser_limit' => Setting::pluck('multiuser_limit')->first(),
            'sub_user_count'  => Multiprofile::where('parent_id', Auth::user()->id )->count(),
            'redirection_url' => $redirection_url ,
        );


        return Theme::view('Multipleprofile', $data);

    }

    public function subcriberuser($id){
        $session = Session::put('subuser_id', null);
        return redirect::to('/home');
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

        $latest_videos = Video::select('id','title','slug','year','rating','access','publish_type','global_ppv','publish_time','publish_status','ppv_price','responsive_image','responsive_player_image','responsive_tv_image',
        'duration','rating','image','featured','age_restrict','video_tv_image','player_image','details','description')->where('status', '=', '1')->take(10)
        ->where('active', '=', '1')
        ->where('draft', '=', '1')
            ->orderBy('created_at', 'DESC')
            ->get();

        if (!Auth::guest())
        {
            $getcnt_watching = ContinueWatching::where('user_id', Auth::user()->id)
                ->pluck('videoid')
                ->toArray();
            $cnt_watching = Video::select('id','title','slug','year','rating','access','publish_type','global_ppv','publish_time','publish_status','ppv_price','responsive_image','responsive_player_image','responsive_tv_image',
            'duration','rating','image','featured','age_restrict','video_tv_image','player_image','details','description')->with('cnt_watch')->where('active', '=', '1')->where('status', '=', '1')
            ->where('draft', '=', '1')->where('type','!=','embed')->whereIn('id', $getcnt_watching)->get();
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
            $logs = \LogActivity::logActivityLists();
            return view('admin.logActivity',compact('logs'));
        }


    }

    public function searchResult(Request $request)
    {
        try {

            if($request->search == null  || $request->search == " " ){

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
                                ->select('id','title','slug','ppv_status','year','rating','access','ppv_price',
                                'duration','rating','image','featured','player_image','details','description')
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
                                ->select('id','title','slug','ppv_status','year','rating','access','ppv_price',
                                'duration','rating','image','featured','player_image','details','description')
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

            // return $th->getMessage();

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

            // return $th->getMessage();

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

            // return $th->getMessage();

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

            // return $th->getMessage();

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
                        ->select('id','title','slug','ppv_status','year','rating','access','ppv_price',
                        'duration','rating','image','featured','video_tv_image','player_image','details','description')
                        ->get();

            $data = array(
                'search_value' => $Audios_search_value,
                'Search_audio' => $audio,
                'currency' => CurrencySetting::first() ,
                'ThumbnailSetting' =>  ThumbnailSetting::first(),
            );

            return Theme::view('search_audios', $data);

        } catch (\Throwable $th) {

            // return $th->getMessage();

            return abort (404);
        }
    }


    public function Language_Video($slug)
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

        $lanid = Language::where('slug', $slug)->pluck('id');

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


    public function Language_List()
    {

        try {
            $Language = Language::get();
            $data = array(
                'Languages' => $Language,
            );
        } catch (\Throwable $th) {


            return abort (404);
        }



        return Theme::View('LanguageList', $data);
    }


    public function AdminThemeModeSave(Request $request)
    {

        if($request->input('mode') == 'true'){
            $theme_modes = "light";
        }
        elseif($request->input('mode') == 'false'){
            $theme_modes = "dark";
        }

        $theme_mode = SiteTheme::first();
        $theme_mode->admin_theme_mode =  $theme_modes;
        $theme_mode->update();

        return $theme_modes;

    }


    public function CPPThemeModeSave(Request $request)
    {

        if($request->input('mode') == 'true'){
            $theme_modes = "light";
        }
        elseif($request->input('mode') == 'false'){
            $theme_modes = "dark";
        }
        // print_r('theme_modes');exit;
        $theme_mode = SiteTheme::first();
        $theme_mode->CPP_theme_mode =  $theme_modes;
        $theme_mode->update();

        return $theme_modes;

    }


    public function ChannelThemeModeSave(Request $request)
    {

        if($request->input('mode') == 'true'){
            $theme_modes = "light";
        }
        elseif($request->input('mode') == 'false'){
            $theme_modes = "dark";
        }

        $theme_mode = SiteTheme::first();
        $theme_mode->Channel_theme_mode =  $theme_modes;
        $theme_mode->update();

        return $theme_modes;

    }


    public function AdsThemeModeSave(Request $request)
    {

        if($request->input('mode') == 'true'){
            $theme_modes = "light";
        }
        elseif($request->input('mode') == 'false'){
            $theme_modes = "dark";
        }

        $theme_mode = SiteTheme::first();
        $theme_mode->Ads_theme_mode =  $theme_modes;
        $theme_mode->update();

        return $theme_modes;

    }


    public function LikeAudio(Request $request)
    {
        if(!Auth::guest()){
            $user_id = Auth::user()->id ;
        }else{
            $user_id = 0 ;
        }
        $audio_id = $request->audio_id;
        $like = $request->like;
        $user_id = $user_id;
        $audio = LikeDisLike::where("audio_id", "=", $audio_id)->where("user_id", "=", $user_id)->get();
        $audio_count = LikeDisLike::where("audio_id", "=", $audio_id)->where("user_id", "=", $user_id)->count();
        if ($audio_count > 0)
        {
            $audio_new = LikeDisLike::where("audio_id", "=", $audio_id)->where("user_id", "=", $user_id)->first();
            $audio_new->liked = $like;
            $audio_new->disliked = 0;
            $audio_new->audio_id = $audio_id;
            $audio_new->save();
            $response = array(
                'status' => true
            );
        }
        else
        {
            $audio_new = new LikeDisLike;
            $audio_new->audio_id = $audio_id;
            $audio_new->user_id = $user_id;
            $audio_new->disliked = 0;
            $audio_new->liked = $like;
            $audio_new->save();
            $response = array(
                'status' => true
            );
        }

    }

    public function DisLikeAudio(Request $request)
    {
        if(!Auth::guest()){
            $user_id = Auth::user()->id ;
        }else{
            $user_id = 0 ;
        }        $audio_id = $request->audio_id;
        $dislike = $request->dislike;
        $d_like = Likedislike::where("audio_id", $audio_id)->where("user_id", $user_id)->count();

        if ($d_like > 0)
        {
            $new_audio_dislike = Likedislike::where("audio_id", $audio_id)->where("user_id", $user_id)->first();
            if ($dislike == 1)
            {
                $new_audio_dislike->user_id = $user_id;
                $new_audio_dislike->audio_id = $audio_id;
                $new_audio_dislike->liked = 0;
                $new_audio_dislike->disliked = 1;
                $new_audio_dislike->save();
                $response = array(
                    'status' => "disliked"
                );
            }
            else
            {
                $new_audio_dislike->user_id = $user_id;
                $new_audio_dislike->audio_id = $audio_id;
                $new_audio_dislike->liked = 0;
                $new_audio_dislike->disliked = 1;
                $new_audio_dislike->save();
                $response = array(
                    'status' => "liked"
                );
            }
        }
        else
        {
            $new_audio_dislike = new Likedislike;
            $new_audio_dislike->user_id = $user_id;
            $new_audio_dislike->audio_id = $audio_id;
            $new_audio_dislike->liked = 0;
            $new_audio_dislike->disliked = 1;
            $new_audio_dislike->save();
            $response = array(
                'status' => "disliked"
            );
        }
        return response()->json($response, 200);
    }

    public function convertExcelToJson(){

        try {
            $filePath = 'https://localhost/flicknexs/public/uploads/Pages/testaudio.xlsx';
            $path = public_path() . "/uploads/Pages/testaudio.xlsx";


            if (file_exists($path)) {


                                // Read data from the Excel file and store it in an array
                    $data = Excel::toArray(null, $path)[0]; // Get the first sheet

                    // Extract the header row (A1 and B1) as keys
                    $keys = [
                        $data[0][0] => $data[0][0],
                        $data[0][1] => $data[0][1]
                    ];

                    // Initialize an empty array for the data rows
                    $jsonData = [];

                    // Loop through the data rows starting from the second row
                    for ($i = 1; $i < count($data); $i++) {
                        $rowData = $data[$i];
                        // print_r($rowData);exit;

                        $jsonData[] = [
                            $keys[$data[0][0]] => $rowData[0],
                            $keys[$data[0][1]] => $rowData[1],
                        ];
                    }

                    $result = [
                        'lyrics' => $jsonData
                    ];
                    // Convert the data to JSON
                    $json = json_encode($result);
                    dd($json);



                // $data = Excel::toCollection(null, $path)->first();

                // $json = $data->toJson();

                return response()->json($json);


            } else {
                // Handle the case where the file does not exist
                return response()->json(['error' => 'File not found.']);
            }
            dd(file_exists($path));

        } catch (\Throwable $th) {
            throw $th;
        }
    }

public function uploadExcel(Request $request)
{
    // Validate the uploaded Excel file
    // $request->validate([
    //     'excel_file' => 'required|file|mimes:xlsx',
    // ]);

    // // Get the uploaded Excel file from the request
    // $uploadedFile = $request->file('excel_file');
    $path = public_path() . "/uploads/Pages/testaudio.xlsx";

    // Ensure the file was uploaded successfully
    if ($path) {
        // Get the absolute path to the uploaded file on the server
        $filePath = $path;

        // Read data from the Excel file and store it in an array
        $data = Excel::toArray(null, $filePath)[0]; // Get the first sheet

        // Extract the header row (A1 and B1) as keys
        $keys = [
            $data[0][0] => $data[0][0],
            $data[0][1] => $data[0][1]
        ];

        // Initialize an empty array for the data rows
        $jsonData = [];

        // Loop through the data rows starting from the second row
        for ($i = 1; $i < count($data); $i++) {
            $rowData = $data[$i];

            // Validate that both "line" and "time" keys are not empty
            if (!empty($rowData[0]) && !empty($rowData[1])) {
                // Validate that "time" is numeric
                if (is_numeric($rowData[1]) && strpos($rowData[1], '.') === false) {
                    $jsonData[] = [
                        $keys[$data[0][0]] => $rowData[0],
                        $keys[$data[0][1]] => intval($rowData[1]),
                    ];
                } else {
                    // Handle the case where "time" is not numeric
                    return response()->json(['error' => 'Invalid data in "time" column.']);
                }
            } else {
                // Handle the case where "line" or "time" keys are empty
                return response()->json(['error' => 'Empty "line" or "time" key found.']);
            }
        }

        // Wrap the data in an object with a "lyrics" key
        $result = [
            'lyrics' => $jsonData
        ];

        // Convert the data to JSON
        $json = json_encode($result);

        // You can return the JSON or do any other processing as needed
        return response()->json($json);
    } else {
        // Handle the case where the file was not uploaded
        return response()->json(['error' => 'File not uploaded.']);
    }
}


    public function TvCodeQuickResponse($tvcode,$verifytoken){

        $agent = new Agent();

        // add verifytoken

        TVLoginCode::where('tv_code',$tvcode)->update([
            'verifytoken'  =>  $verifytoken,
        ]);

        $AppSetting = AppSetting::where('id','=',1)->first();
            if ($agent->is('iOS'))
            {
                try {
                    $ios_url = AppSetting::where('id','=',1)->pluck('ios_url')->first();
                    if(!empty($ios_url)){
                        return redirect()->away($ios_url);
                    }else{
                        return redirect('/login');
                    }
                } catch (\Throwable $th) {
                    throw $th;
                }
            }
            else
            {
                try {
                    $android_url = AppSetting::where('id','=',1)->pluck('android_url')->first();
                    if(!empty($android_url)){
                        return redirect()->away($android_url);
                    }else{
                        return redirect('/login');
                    }
                } catch (\Throwable $th) {
                    throw $th;
                }
            }

    }



    public function My_list()
    {
        $settings = Setting::first();

        if($settings->enable_landing_page == 1 && Auth::guest()){

            $landing_page_slug = AdminLandingPage::where('status',1)->pluck('slug')->first() ? AdminLandingPage::where('status',1)->pluck('slug')->first() : "landing-page" ;

            return redirect()->route('landing_page', $landing_page_slug );
        }

        $system_settings = SystemSetting::first();
        $user = User::where('id', '=', 1)->first();

        if (Auth::guest())
        {
            return view('auth.login', compact('system_settings', 'user'));

        }
        $multiuser = Session::get('subuser_id');

        if(!Auth::guest()):

            $Mode = $multiuser != null ?  Multiprofile::where('id', $multiuser)->first() : User::where('id', Auth::User()->id)->first();
        else:

            $Mode['user_type'] = null ;
        endif;


        $check_Kidmode = $Mode['user_type'] != null && $Mode['user_type'] == "Kids" ? 1 : 0 ;


        $watchlater_videos_count = Watchlater::where('user_id', '=', Auth::user()->id)->where('video_id', '!=','')->latest()->count();
        if ($watchlater_videos_count > 0)
        {
            $watchlater_videos_array = Watchlater::where('user_id', '=', Auth::user()->id)->where('video_id', '!=','')->pluck('video_id')->toarray();
            $Watchlater_videos = Watchlater::where('user_id', '=', Auth::user()->id)->latest();
            $Watchlater_videos = Video::whereIn('id',$watchlater_videos_array);

                if (Geofencing() != null && Geofencing()->geofencing == 'ON')
                {
                    $Watchlater_videos = $Watchlater_videos->whereNotIn('videos.id', Block_videos());
                }

                if( $check_Kidmode == 1 )
                {
                    $Watchlater_videos = $Watchlater_videos->whereBetween('videos.age_restrict', [ 0, 12 ]);
                }

            $Watchlater_videos = $Watchlater_videos->limit(50)->paginate($this->videos_per_page);
        }
        else
        {
            $Watchlater_videos = array();
        }

        $settings = Setting::first();
        $PPV_settings = Setting::where('ppv_status', '=', 1)->first();
        $ppv_gobal_price = !empty($PPV_settings) ? $PPV_settings->ppv_price : null;

        $data = array(
            'Watchlater_videos'    => $Watchlater_videos,
            'ppv_gobal_price'  => $ppv_gobal_price,
            'currency'         => CurrencySetting::first(),
            'ThumbnailSetting' => ThumbnailSetting::first(),
        );

        return Theme::view('MyList',['MyList'=>$data]);
    }

    public function EPG_date_filter(Request $request)
    {
        $theme = Theme::uses($this->HomeSetting->theme_choosen);

        $order_settings = OrderHomeSetting::orderBy('order_id', 'asc')->pluck('video_name')->toArray();
        $order_settings_list = OrderHomeSetting::get();

        $current_timezone = current_timezone();
        $default_vertical_image_url = default_vertical_image_url() ;
        $default_horizontal_image_url = default_horizontal_image_url();

        $epg_channel_data =  AdminEPGChannel::where('status',1)->where('id',$request->channel_id)->limit(15)->get()->map(function ($item )  use( $default_horizontal_image_url, $default_vertical_image_url ,$request , $current_timezone) {

            $item['image_url'] = $item->image != null ? $this->BaseURL.('/EPG-Channel/'.$item->image ) : $default_vertical_image_url ;
            $item['Player_image_url'] = $item->player_image != null ?  $this->BaseURL.('/EPG-Channel/'.$item->player_image ) : $default_horizontal_image_url ;
            $item['Logo_url'] = $item->logo != null ?  $this->BaseURL.('/EPG-Channel/'.$item->logo ) : $default_vertical_image_url;

            $item['ChannelVideoScheduler']  =  ChannelVideoScheduler::where('channe_id',$request->channel_id)

                                                ->when( !is_null($request->date), function ($query) use ($request) {
                                                    return $query->Where('choosed_date', $request->date);
                                                })

                                                ->orderBy('start_time','asc')->limit(30)->get()->map(function ($item) use ($current_timezone) {

                                                    $item['TimeZone']   = TimeZone::where('id',$item->time_zone)->first();

                                                    $item['converted_start_time'] = Carbon\Carbon::createFromFormat('m-d-Y H:i:s', $item->choosed_date . $item->start_time, $item['TimeZone']->time_zone )
                                                                                                    ->copy()->tz( $current_timezone )->format('h:i A');

                                                    $item['converted_end_time'] = Carbon\Carbon::createFromFormat('m-d-Y H:i:s', $item->choosed_date . $item->end_time, $item['TimeZone']->time_zone )
                                                                                                    ->copy()->tz( $current_timezone )->format('h:i A');

                                                    return $item;
                                                });
            return $item;
        })->first();


        $data =[
            'order_settings' => $order_settings ,
            'order_settings_list' => $order_settings_list ,
            'order_settings' => $order_settings ,
            'epg_channel_data' => $epg_channel_data ,
            'EPG_date_filter_status' => 1 ,
            'current_timezone'       => $current_timezone,
        ];

        return Theme::view('partials.home.channel-epg-partial', $data);
        // return $theme->load('public/themes/theme1/views/partials/home/channel-epg-partial', $data)->render();
    }

    public function Homepage_watchlater(Request $request)
    {
        try {

            $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();

            $inputs = [
                $request->where_column  => $request->source_id,
                'type' => $request->type,
                'user_id' => !Auth::guest() ? Auth::user()->id : null,
                'users_ip_address' => Auth::guest() ? $geoip->getIP() : null,
            ];

            $watchlater_exist = Watchlater::where($request->where_column, $request->source_id)

                                                ->when($request->where_column == "video_id", function ($query) use($request)  {
                                                    $query->where('type', $request->type);
                                                })

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

    public function Homepage_wishlist(Request $request)
    {
        try {

            $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();

            $inputs = [
                $request->where_column  => $request->source_id,
                'type' => $request->type,
                'user_id' => !Auth::guest() ? Auth::user()->id : null,
                'users_ip_address' => Auth::guest() ? $geoip->getIP() : null,
            ];


            $wishlist_exist = Wishlist::where($request->where_column, $request->source_id)

                                            ->when($request->where_column == "video_id", function ($query) use($request) {
                                                $query->where('type', $request->type);
                                            })

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



    public function DocumentList()
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


        $Document_count = Document::latest()->count();

        if ($Document_count > 0)
        {
            $latest_Documents = Document::limit(50)->paginate($this->videos_per_page);

        }
        else
        {
            $latest_Documents = array();
        }

        $settings = Setting::first();
        $PPV_settings = Setting::where('ppv_status', '=', 1)->first();
        $ppv_gobal_price = !empty($PPV_settings) ? $PPV_settings->ppv_price : null;

        $data = array(
            'latest_Documents' => $latest_Documents,
            'ppv_gobal_price'  => $ppv_gobal_price,
            'currency'         => CurrencySetting::first(),
            'ThumbnailSetting' => ThumbnailSetting::first(),
        );

        return Theme::view('DocumentList',['DocumentList'=>$data]);
    }


    public function DocumentCategoryList($slug)
    {
        $settings = Setting::first();

        $category_id = DocumentGenre::where('slug',$slug)->pluck('id')->first();

        $Documents =  Document::where('category','!=',null)->WhereJsonContains('category',(string) $category_id)->limit(50)->paginate($this->videos_per_page);
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


        $Document_count = Document::latest()->count();

        if ($Document_count > 0)
        {
            $latest_Documents = Document::limit(50)->paginate($this->videos_per_page);

        }
        else
        {
            $latest_Documents = array();
        }

        $settings = Setting::first();
        $PPV_settings = Setting::where('ppv_status', '=', 1)->first();
        $ppv_gobal_price = !empty($PPV_settings) ? $PPV_settings->ppv_price : null;

        $data = array(
            'latest_Documents' => $Documents,
            'ppv_gobal_price'  => $ppv_gobal_price,
            'currency'         => CurrencySetting::first(),
            'ThumbnailSetting' => ThumbnailSetting::first(),
            'DocumentGenre_Name' => DocumentGenre::where('slug',$slug)->pluck('name')->first(),
        );

        return Theme::view('DocumentCategoryListPage',['DocumentCategoryListPage'=>$data]);
    }

    // only for theme4
    public function home_livestream_section_auto_refresh()
    {
        $homepage_array_data = [
            'order_settings_list' => OrderHomeSetting::get(),
            'multiple_compress_image' => CompressImage::pluck('enable_multiple_compress_image')->first() ? CompressImage::pluck('enable_multiple_compress_image')->first() : 0,
            'videos_expiry_date_status' => videos_expiry_date_status(),
            'getfeching' => Geofencing::first(),
            'default_vertical_image_url' => default_vertical_image_url(),
            'default_horizontal_image_url' => default_horizontal_image_url(),
        ];

        $current_timezone = current_timezone();

        $livestreams = LiveStream::select('id', 'title', 'slug', 'year', 'rating', 'access', 'publish_type', 'publish_time', 'publish_status', 'ppv_price',
                                        'duration', 'rating', 'image', 'featured', 'Tv_live_image', 'player_image', 'details', 'description', 'free_duration',
                                        'recurring_program', 'program_start_time', 'program_end_time', 'custom_start_program_time', 'custom_end_program_time',
                                        'recurring_timezone', 'recurring_program_week_day', 'recurring_program_month_day')
                                ->where('active', 1)
                                ->where('status', 1)
                                ->latest()
                                ->limit(15)
                                ->get();

        $livestreams = $livestreams->filter(function ($livestream) use ($current_timezone) {
            if ($livestream->publish_type === 'recurring_program') {

                $Current_time = Carbon\Carbon::now($current_timezone);
                $recurring_timezone = TimeZone::where('id', $livestream->recurring_timezone)->value('time_zone');
                $convert_time = $Current_time->copy()->timezone($recurring_timezone);
                $midnight = $convert_time->copy()->startOfDay();

                switch ($livestream->recurring_program) {
                    case 'custom':
                        $recurring_program_Status = $convert_time->greaterThanOrEqualTo($midnight) && $livestream->custom_end_program_time >=  Carbon\Carbon::parse($convert_time)->format('Y-m-d\TH:i') ;
                        break;
                    case 'daily':
                        $recurring_program_Status = $convert_time->greaterThanOrEqualTo($midnight) && $livestream->program_end_time >= $convert_time->format('H:i');
                        break;
                    case 'weekly':
                        $recurring_program_Status =  ( $livestream->recurring_program_week_day == $convert_time->format('N') ) && $convert_time->greaterThanOrEqualTo($midnight)  && ( $livestream->program_end_time >= $convert_time->format('H:i') );
                        break;
                    case 'monthly':
                        $recurring_program_Status = $livestream->recurring_program_month_day == $convert_time->format('d') && $convert_time->greaterThanOrEqualTo($midnight) && $livestream->program_end_time >= $convert_time->format('H:i');
                        break;
                    default:
                        $recurring_program_Status = false;
                        break;
                }

                switch ($livestream->recurring_program) {
                    case 'custom':
                        $recurring_program_live_animation = $livestream->custom_start_program_time <= $convert_time && $livestream->custom_end_program_time >= $convert_time;
                        break;
                    case 'daily':
                        $recurring_program_live_animation = $livestream->program_start_time <= $convert_time->format('H:i') && $livestream->program_end_time >= $convert_time->format('H:i');
                        break;
                    case 'weekly':
                        $recurring_program_live_animation = $livestream->recurring_program_week_day == $convert_time->format('N') && $livestream->program_start_time <= $convert_time->format('H:i') && $livestream->program_end_time >= $convert_time->format('H:i');
                        break;
                    case 'monthly':
                        $recurring_program_live_animation = $livestream->recurring_program_month_day == $convert_time->format('d') && $livestream->program_start_time <= $convert_time->format('H:i') && $livestream->program_end_time >= $convert_time->format('H:i');
                        break;
                    default:
                        $recurring_program_live_animation = false;
                        break;
                }

                $livestream->recurring_program_live_animation = $recurring_program_live_animation;

                return $recurring_program_Status;
            }
            return true;
        });

        return Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/live-videos', array_merge($homepage_array_data, ['data' => $livestreams , 'livestreams_data' => $livestreams ]) )->render();
    }


    public function MyLoggedDevices()
    {
        try {

            if (Auth::guest())
            {
                return redirect('/login');
            }

            $alldevices_register = LoggedDevice::where('user_id', Auth::User()->id)
                                        ->get();
            $data = array(
                'alldevices_register' => $alldevices_register,
            );

            return Theme::view('MyLoggedDevices',['MyLoggedDevices'=>$data]);


        } catch (\Throwable $th) {
            throw $th;
        }
    }



    public function MyLoggedDevicesDelete($id)
    {
        try {

            if (Auth::guest())
            {
                return redirect('/login');
            }

            LoggedDevice::where('id',$id)->delete();

            return Redirect::back()->with(array('message' => 'Successfully Deleted Device','note_type' => 'success'));


        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function header_menus() {
        try{

            $header_top_position_menus = Menu::orderBy('order', 'asc')->where('in_home',1)->get();
                                                                              
            $Parent_video_category = VideoCategory::whereIn('id', function ($query) {
                
                $query->select('parent_id')->from('video_categories');

                    })->orwhere('parent_id',0)->orwhere('parent_id',null)->orderBy('order', 'asc')->where('in_menu',1)

                ->get()->map(function ($item) {

                $item['sub_video_category'] = VideoCategory::where('parent_id',$item->id)->orderBy('order', 'asc')->where('in_menu',1)->get();
                
                return $item;
            });

            $Parent_live_category = LiveCategory::whereIn('id', function ($query) {
                
                $query->select('parent_id')->from('live_categories');

                    })->orwhere('parent_id',0)->orwhere('parent_id',null)->orderBy('order', 'asc')

                ->get()->map(function ($item) {

                $item['sub_live_category'] = LiveCategory::where('parent_id',$item->id)->orderBy('order', 'asc')->get();
                
                return $item;
            });

            $Parent_audios_category = AudioCategory::whereIn('id', function ($query) {
                
                $query->select('parent_id')->from('audio_categories');

                    })->orwhere('parent_id',0)->orwhere('parent_id',null)->orderBy('order', 'asc')->where('active',1)

                ->get()->map(function ($item) {

                $item['sub_audios_category'] = AudioCategory::where('parent_id',$item->id)->orderBy('order', 'asc')->get();
                
                return $item;
            });

            $Parent_series_category = SeriesGenre::whereIn('id', function ($query) {
                
                $query->select('parent_id')->from('series_genre');

                    })->orwhere('parent_id',0)->orwhere('parent_id',null)->orderBy('order', 'asc')->where('in_menu',1)

                ->get()->map(function ($item) {

                $item['sub_series_category'] = SeriesGenre::where('parent_id',$item->id)->where('in_menu',1)->orderBy('order', 'asc')->get();
                
                return $item;
            });

            $Parent_Series_Networks = SeriesNetwork::whereIn('id', function ($query) {
                
                $query->select('parent_id')->from('series_networks');
            
                    })->orwhere('parent_id',0)->orwhere('parent_id',null)->orderBy('order', 'asc')->where('in_menu',1)
            
                ->get()->map(function ($item) {
            
                $item['Sub_Series_Networks'] = SeriesNetwork::where('parent_id',$item->id)->where('in_menu',1)->orderBy('order', 'asc')->get();
                
                return $item;
            });

            $tv_shows_series = Series::where('active',1)->get();

            $languages = Language::all();

            $data = [
                'languages'                   => $languages,
                'tv_shows_series'             => $tv_shows_series,
                'Parent_Series_Networks'      => $Parent_Series_Networks,
                'Parent_series_category'      => $Parent_series_category,
                'Parent_audios_category'      => $Parent_audios_category,
                'Parent_live_category'        => $Parent_live_category,
                'Parent_video_category'       => $Parent_video_category,
                'header_top_position_menus'   => $header_top_position_menus,

            ];
            // dd($data);
            return Theme::view('header_menus', $data);

        }catch(\Throwable $th){
            // return $th->getMessage();
            return abort(404);
        }
        
    }

    
    public function fetchMenus()
    {
        if (!Auth::guest() && Auth::user()->role != 'admin' || Auth::guest()) {
            $menus = Menu::orderBy('order', 'asc')
                        ->where('in_home', '!=', 0)
                        ->orWhereNull('in_home')
                        ->get();
        } else {
            $menus = Menu::orderBy('order', 'asc')->get();
        }

        $languages = Language::all();
        $liveCategories = LiveCategory::orderBy('order', 'asc')->get();
        $videoCategories = VideoCategory::orderBy('order', 'asc')->get();
        $audioCategories = AudioCategory::orderBy('order', 'asc')->get();
        $tvShows = SeriesGenre::get();

        return response()->json([
            'menus' => $menus,
            'languages' => $languages,
            'liveCategories' => $liveCategories,
            'videoCategories' => $videoCategories,
            'audioCategories' => $audioCategories,
            'tvShows' => $tvShows
        ]);
    }


}

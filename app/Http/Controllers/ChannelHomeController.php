<?php
namespace App\Http\Controllers;
use \App\User as User;
use \Redirect as Redirect;
use Illuminate\Http\Request;
use App\Setting;
use App\Genre;
use App\Audio;
use App\Page as Page;
use App\Watchlater as Watchlater;
use App\Wishlist as Wishlist;
use App\PpvVideo as PpvVideo;
use App\PpvPurchase as PpvPurchase;
use App\RecentView as RecentView;
use App\Movie;
use App\Episode;
use App\ContinueWatching as ContinueWatching;
use App\LikeDislike as LikeDislike;
use App\VideoCategory;
use App\RegionView;
use App\UserLogs;
use App\Videoartist;
use App\Artist;
use App\PaymentSetting;
use App\ScheduleVideos;
use App\Language;
use URL;
use Auth;
use View;
use Hash;
use Illuminate\Support\Facades\Cache;
//use Image;
use Intervention\Image\ImageManagerStatic as Image;
use Session;
use App\Playerui as Playerui;
use App\MoviesSubtitles as MoviesSubtitles;
use App\Video as Video;
use Carbon\Carbon;
use DateTime;
use App\CurrencySetting as CurrencySetting;
use App\HomeSetting as HomeSetting;
use App\BlockVideo as BlockVideo;
use App\CategoryVideo as CategoryVideo;
use App\LanguageVideo;
use App\AdsVideo;
use Theme;
use App\ThumbnailSetting;
use App\Geofencing;
use App\AgeCategory;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use FFMpeg\Filters\Video\VideoFilters;
use FFMpeg\FFProbe;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\Format\Video\X264;
use App\RelatedVideo;
use App\LiveCategory;
use App\SeriesGenre;
use App\Series;
use App\VideoSchedules as VideoSchedules;
use App\Channel;
use App\ModeratorsUser;
use App\StorageSetting;
use App\LiveStream;
use App\AudioCategory;


class ChannelHomeController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth');
        $settings = Setting::first();
        $this->videos_per_page = $settings->videos_per_page;

        $this->Theme = HomeSetting::pluck('theme_choosen')
            ->first();
        Theme::uses($this->Theme);
    }
    
    public function ChannelHome($slug)
    {
        $settings = Setting::first();
        $channel = Channel::where('channel_slug',$slug)->first(); 

        $currency = CurrencySetting::first();
            if(!empty($channel)){
                $livetreams = LiveStream::where('active', '=', '1')->where('user_id', '=', $channel->id)
                ->where('uploaded_by', '=', 'Channel')->orderBy('created_at', 'DESC')
                ->get();

                $audios = Audio::where('active', '=', '1')->where('user_id', '=', $channel->id)
                ->where('uploaded_by', '=', 'Channel')
                ->orderBy('created_at', 'DESC')
                ->get() ;

                $latest_series = Series::where('active', '=', '1')->where('user_id', '=', $channel->id)
                ->where('uploaded_by', '=', 'Channel')->orderBy('created_at', 'DESC')
                ->get();

                $latest_videos = Video::where('active', '=', '1')->where('status', '=', '1')->where('user_id', '=', $channel->id)
                ->where('uploaded_by', '=', 'Channel')->where('draft', '=', '1')
                ->get();
    
            $ThumbnailSetting = ThumbnailSetting::first();
            
            $data = array(
                'currency' => $currency,
                'latest_video' => $latest_videos,
                'latest_series' => $latest_series,
                'latest_audios' => $audios,
                'audios' => $audios,
                'livetream' => $livetreams,
                'ThumbnailSetting' => $ThumbnailSetting,
                'LiveCategory' => LiveCategory::get(),
                'VideoCategory' => VideoCategory::get(),
                'AudioCategory' => AudioCategory::get(),
                'channel_partner' => $channel,
            );
            
            return Theme::view('ChannelHome', $data);
        }
    }


    
    public function ChannelList()
    {
        // if (Auth::guest() && !isset($data['user']))
        // {
        //     return Theme::view('auth.login');
        // }
        $settings = Setting::first();
        $channels = Channel::get(); 
        $currency = CurrencySetting::first();
        $ThumbnailSetting = ThumbnailSetting::first();
          
            $data = array(
                'currency' => $currency,
                'channels' => $channels,
                'ThumbnailSetting' => $ThumbnailSetting,
            );
            
            return Theme::view('ChannelList', $data);
        
    }

    public function channel_category_videos(Request $request)
    {

        $videosCategory = VideoCategory::find($request->category_id) != null ? VideoCategory::find($request->category_id)->specific_category_videos : array();
         
        $videos_Category = $videosCategory->where('user_id', $request->user_id)->where('uploaded_by' ,'Channel')->all();

        $data = array( 'videosCategory' => $videos_Category );
 
            return Theme::view('partials.channel.channel_category_videos', $data);
            $theme = Theme::uses($this->Theme);

            return $theme->load('public/themes/default/views/partials/channel/channel_category_videos', $data)->render();
    }

    public function channel_category_series(Request $request)
    {

        $SeriesCategory = SeriesGenre::find($request->category_id) != null ? SeriesGenre::find($request->category_id)->specific_category_series : array();
        
        $Series_Category = $SeriesCategory->where('user_id', $request->user_id)->where('uploaded_by' ,'Channel')->all();

        $data = array( 'SeriesCategory' => $Series_Category );

        $theme = Theme::uses($this->Theme);

        return $theme->load('public/themes/default/views/partials/channel/channel_category_series', $data)->render();
    }

    public function channel_category_live(Request $request)
    {

        $LiveCategory = LiveCategory::find($request->category_id) != null ? LiveCategory::find($request->category_id)->specific_category_live : array();
        
        $Live_Category = $LiveCategory->where('user_id', $request->user_id)->where('uploaded_by' ,'Channel')->all();

        $data = array( 'LiveCategory' => $Live_Category );

        $theme = Theme::uses($this->Theme);

        return $theme->load('public/themes/default/views/partials/channel/channel_category_live', $data)->render();
    }

    public function channel_category_audios(Request $request)
    {
         
        $AudioCategory = AudioCategory::find($request->category_id) != null ? AudioCategory::find($request->category_id)->specific_category_audio : array();
        
        $Audio_Category = $AudioCategory->where('user_id', $request->user_id)->where('uploaded_by' ,'Channel')->all();

        $data = array( 'AudioCategory' => $Audio_Category );

        $theme = Theme::uses($this->Theme);

        return $theme->load('public/themes/default/views/partials/channel/channel_category_audios', $data)->render();
    }

    
    public function all_Channel_videos(Request $request)
    {
        $settings = Setting::first();
        $channel = Channel::where('channel_slug',$request->channel_slug)->first(); 

        $currency = CurrencySetting::first();
            if(!empty($channel)){
                $livetreams = LiveStream::where('active', '=', '1')->where('user_id', '=', $channel->id)
                ->where('uploaded_by', '=', 'Channel')->orderBy('created_at', 'DESC')
                ->limit(30)
                ->get();

                $audios = Audio::where('active', '=', '1')->where('user_id', '=', $channel->id)
                ->where('uploaded_by', '=', 'Channel')
                ->orderBy('created_at', 'DESC')
                ->limit(30)
                ->get() ;

                $latest_series = Series::where('active', '=', '1')->where('user_id', '=', $channel->id)
                ->where('uploaded_by', '=', 'Channel')->orderBy('created_at', 'DESC')
                ->limit(30)
                ->get();

                $latest_videos = Video::where('user_id', $channel->id)
                ->where('uploaded_by', 'Channel')->where('draft', '1')
                ->where('active', '1')->where('status', '1')
                ->limit(30)
                ->get();
    
            $ThumbnailSetting = ThumbnailSetting::first();
            
            $data = array(
                'currency' => $currency,
                'latest_video' => $latest_videos,
                'latest_series' => $latest_series,
                'audios' => $audios,
                'livetream' => $livetreams,
                'ThumbnailSetting' => $ThumbnailSetting,
                'LiveCategory' => LiveCategory::get(),
                'VideoCategory' => VideoCategory::get(),
                'AudioCategory' => AudioCategory::get(),
                'channel' => $channel,
            );
            $theme = Theme::uses($this->Theme);
            
            return $theme->load('public/themes/default/views/ChannelHome', $data)->render();

        }
    }

    public function Channel_Audios_list($channel_slug)
    {
        try {

            $channel = Channel::where('channel_slug',$channel_slug)->first(); 

            $data = Audio::where('active', '1')->where('user_id', $channel->id)
                    ->where('uploaded_by','Channel')
                    ->latest()
                    ->paginate() ;

            $respond = array(
                'settings' => Setting::first(),
                'currency' => CurrencySetting::first(),
                'ThumbnailSetting' => ThumbnailSetting::first(),
                'audios' => $data ,
            );

            return Theme::view('channel.Channel_Audios_list', $respond);

        } catch (\Throwable $th) {

            return abort(404);
        }
    }

    public function Channel_livevideos_list($channel_slug)
    {
        try {

            $channel = Channel::where('channel_slug',$channel_slug)->first(); 

            $data = LiveStream::where('active','1')->where('user_id',$channel->id)
                                ->where('uploaded_by','Channel')
                                ->latest()
                                ->get();

            $data = array(
                'settings' => Setting::first(),
                'currency' => CurrencySetting::first(),
                'ThumbnailSetting' => ThumbnailSetting::first(),
                'videos' => $data ,
                'channel_slug' => $channel_slug ,
            );

            return Theme::view('channel.Channel_livevideos_list', $data);

        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    public function Channel_series_list($channel_slug)
    {
        try {

            $channel = Channel::where('channel_slug',$channel_slug)->first(); 
           
            $data = Series::where('active','1')->where('user_id', $channel->id)
                            ->where('uploaded_by', 'Channel')
                            ->latest()
                            ->paginate();

            $respond_data = array(
                'settings' => Setting::first(),
                'currency' => CurrencySetting::first(),
                'ThumbnailSetting' => ThumbnailSetting::first(),
                'Series' => $data ,
                'channel_slug' => $channel_slug ,
            );

            return Theme::view('channel.Channel_series_list',  [ 'respond_data' => $respond_data]);

        } catch (\Throwable $th) {

            return abort(404);
        }
    }
    
    public function Channel_videos_list($channel_slug)
    {
        try {

            $channel = Channel::where('channel_slug',$channel_slug)->first(); 

            $data = Video::where('active', '=', '1')->where('status', '=', '1')
                            ->where('user_id', '=', $channel->id)
                            ->where('uploaded_by', '=', 'Channel')->where('draft', '=', '1')
                            ->paginate();

            $respond_data = array(
                'settings' => Setting::first(),
                'currency' => CurrencySetting::first(),
                'ThumbnailSetting' => ThumbnailSetting::first(),
                'videos' => $data ,
                'channel_slug' => $channel_slug ,
            );

            return Theme::view('Channel.Channel_videos_list', [ 'respond_data' => $respond_data]);

        } catch (\Throwable $th) {

            return abort(404);
        }

    }
}
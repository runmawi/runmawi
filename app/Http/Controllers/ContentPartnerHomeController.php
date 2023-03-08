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


class ContentPartnerHomeController extends Controller
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
    
    public function ContentPartnerHome($slug)
    {
        $settings = Setting::first();
        $ModeratorsUser = ModeratorsUser::where('slug',$slug)->first(); 

        $currency = CurrencySetting::first();
            if(!empty($ModeratorsUser)){
                $livetreams = LiveStream::where('active', '=', '1')->where('user_id', '=', $ModeratorsUser->id)
                ->where('uploaded_by', '=', 'CPP')->orderBy('created_at', 'DESC')
                ->get();

                $audios = Audio::where('active', '=', '1')->where('user_id', '=', $ModeratorsUser->id)
                ->where('uploaded_by', '=', 'CPP')
                ->orderBy('created_at', 'DESC')
                ->get() ;

                $latest_series = Series::where('active', '=', '1')->where('user_id', '=', $ModeratorsUser->id)
                ->where('uploaded_by', '=', 'CPP')->orderBy('created_at', 'DESC')
                ->get();

                $latest_videos = Video::where('active', '=', '1')->where('status', '=', '1')->where('user_id', '=', $ModeratorsUser->id)
                ->where('uploaded_by', '=', 'CPP')->where('draft', '=', '1')
                ->get();
    
            $ThumbnailSetting = ThumbnailSetting::first();
        //    dd($latest_videos); 
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
                'ModeratorsUser' => $ModeratorsUser,
            );
            
            return Theme::view('ContentPartnerHome', $data);
        }
    }


    
    public function ContentList()
    {

        $settings = Setting::first();
        $ModeratorsUser = ModeratorsUser::get(); 
        $currency = CurrencySetting::first();
        $ThumbnailSetting = ThumbnailSetting::first();
          
            $data = array(
                'currency' => $currency,
                'ModeratorsUser' => $ModeratorsUser,
                'ThumbnailSetting' => $ThumbnailSetting,
            );
            
            return Theme::view('ContentPartnerList', $data);
        
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

        $SeriesCategory = VideoCategory::find($request->category_id) != null ? VideoCategory::find($request->category_id)->specific_category_series : array();
        
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
         
        $AudioCategory = AudioCategory::find($request->category_id) != null ? AudioCategory::find($request->category_id)->specific_category_series : array();
        
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
}
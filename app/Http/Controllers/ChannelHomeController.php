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
        // dd($channel);
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
                'channel' => $channel,
            );
            
            return Theme::view('ChannelHome', $data);
        }
    }


    
    public function ChannelList()
    {
        if (Auth::guest() && !isset($data['user']))
        {
            return Theme::view('auth.login');
        }
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

}
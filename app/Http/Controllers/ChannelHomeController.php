<?php
namespace App\Http\Controllers;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use FFMpeg\Filters\Video\VideoFilters;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\Format\Video\X264;
use FFMpeg\FFProbe;
use Carbon\Carbon;
use URL;
use Auth;
use View;
use Hash;
use Session;
use Theme;
use \Redirect ;
use App\User ;
use App\Genre;
use App\Audio;
use App\Page ;
use App\Setting;
use App\Watchlater ;
use App\Wishlist;
use App\PpvVideo ;
use App\PpvPurchase ;
use App\RecentView;
use App\Movie;
use App\Episode;
use App\ContinueWatching;
use App\LikeDislike;
use App\VideoCategory;
use App\RegionView;
use App\UserLogs;
use App\Videoartist;
use App\Artist;
use App\PaymentSetting;
use App\ScheduleVideos;
use App\Language;
use App\Playerui;
use App\MoviesSubtitles;
use App\Video ;
use DateTime;
use App\CurrencySetting;
use App\HomeSetting ;
use App\BlockVideo ;
use App\CategoryVideo ;
use App\LanguageVideo;
use App\AdsVideo;
use App\ThumbnailSetting;
use App\Geofencing;
use App\AgeCategory;
use App\RelatedVideo;
use App\LiveCategory;
use App\SeriesGenre;
use App\Series;
use App\VideoSchedules;
use App\Channel;
use App\ModeratorsUser;
use App\StorageSetting;
use App\LiveStream;
use App\AudioCategory;
use App\OrderHomeSetting;
use App\CompressImage;

class ChannelHomeController extends Controller
{

    public function __construct()
    {
        $this->settings = Setting::first();

        $this->videos_per_page = $this->settings->videos_per_page;

        $this->HomeSetting = HomeSetting::first();
        Theme::uses($this->HomeSetting->theme_choosen);
    }
    
    public function ChannelHome($slug)
    {
        $settings = Setting::first();
        $channel_partner = Channel::where('channel_slug',$slug)->first(); 
        $currency = CurrencySetting::first();

        $FrontEndQueryController = new FrontEndQueryController();

        if(!empty($channel_partner)){

            // Videos

            $latest_videos = $FrontEndQueryController->latest_videos()->filter(function ($latest_videos) use ($channel_partner) {
                if ( $latest_videos->user_id == $channel_partner->id && $latest_videos->uploaded_by == "Channel" ) {
                    return $latest_videos;
                }
            });

            $featured_videos = $FrontEndQueryController->featured_videos()->filter(function ($featured_videos) use ($channel_partner) {
                if ( $featured_videos->user_id == $channel_partner->id && $featured_videos->uploaded_by == "Channel" ) {
                    return $featured_videos;
                }
            });

            $trending_videos = $FrontEndQueryController->trending_videos()->filter(function ($trending_videos) use ($channel_partner) {
                if ( $trending_videos->user_id == $channel_partner->id && $trending_videos->uploaded_by == "Channel" ) {
                    return $trending_videos;
                }
            });

            $genre_video_display = $FrontEndQueryController->genre_video_display()->filter(function ($genre_video_display) use ($channel_partner) {
                if ( $genre_video_display->user_id == $channel_partner->id && $genre_video_display->uploaded_by == "Channel" ) {
                    return $genre_video_display;
                }
            });

            // Series & Episode

            $latest_series = $FrontEndQueryController->latest_Series()->filter(function ($latest_Series) use ($channel_partner) {
                if ( $latest_Series->user_id == $channel_partner->id && $latest_Series->uploaded_by == "Channel" ) {
                    return $latest_Series;
                }
            });

            $latest_episodes = $FrontEndQueryController->latest_episodes()->filter(function ($latest_episodes) use ($channel_partner) {
                if ( $latest_episodes->user_id == $channel_partner->id && $latest_episodes->uploaded_by == "Channel" ) {
                    return $latest_episodes;
                }
            });

            $featured_episodes = $FrontEndQueryController->featured_episodes()->filter(function ($featured_episodes) use ($channel_partner) {
                if ( $featured_episodes->user_id == $channel_partner->id && $featured_episodes->uploaded_by == "Channel" ) {
                    return $featured_episodes;
                }
            });
            
            $artist = $FrontEndQueryController->artist()->filter(function ($artist) use ($channel_partner) {
                if ( $artist->user_id == $channel_partner->id && $artist->uploaded_by == "Channel" ) {
                    return $artist;
                }
            });


            // Live Stream 

            $livetreams = LiveStream::where('active', 1)->where('status',1)->where('user_id', $channel_partner->id)
                                            ->where('uploaded_by', 'Channel')->orderBy('created_at', 'DESC')
                                            ->get();

            $LiveCategory = $FrontEndQueryController->LiveCategory()->filter(function ($LiveCategory) use ($channel_partner) {
                if ( $LiveCategory->user_id == $channel_partner->id && $LiveCategory->uploaded_by == "Channel" ) {
                    return $LiveCategory;
                }
            });

            $LiveEventArtist = $FrontEndQueryController->LiveEventArtist()->filter(function ($LiveEventArtist) use ($channel_partner) {
                if ( $LiveEventArtist->user_id == $channel_partner->id && $LiveEventArtist->uploaded_by == "Channel" ) {
                    return $LiveEventArtist;
                }
            });


            // Audios

            $latest_audios = $FrontEndQueryController->latest_audios()->filter(function ($latest_audios) use ($channel_partner) {
                if ( $latest_audios->user_id == $channel_partner->id && $latest_audios->uploaded_by == "Channel" ) {
                    return $latest_audios;
                }
            });
           
            $albums = $FrontEndQueryController->AudioAlbums()->filter(function ($albums) use ($channel_partner) {
                if ( $albums->user_id == $channel_partner->id && $albums->uploaded_by == "Channel" ) {
                    return $albums;
                }
            });

            $trending_audios = $FrontEndQueryController->trending_audios()->filter(function ($trending_audios) use ($channel_partner) {
                if ( $trending_audios->user_id == $channel_partner->id && $trending_audios->uploaded_by == "Channel" ) {
                    return $trending_audios;
                }
            });

            $data = array(
                'settings'           => $this->settings ,
                'HomeSetting'        => $this->HomeSetting ,
                'current_theme'      => $this->HomeSetting->theme_choosen,
                'currency'           => $currency,

                'channel_partner'    => $channel_partner,
                'latest_video'       => $latest_videos,
                'featured_videos'    => $featured_videos,
                'trending_videos'    => $trending_videos,
                'genre_video_display'   => $genre_video_display,
                'latest_series'         => $latest_series,
                'latest_audios'         => $latest_audios,
                'audios'                => $latest_audios,
                'featured_episodes'     => $featured_episodes,
                'livetream'             => $livetreams ,
                'LiveCategory'          => $LiveCategory ,
                'latest_episode'        => $latest_episodes , 
                'artist'                => $artist ,
                'albums'                => $albums ,
                'trending_audios'       => $trending_audios,
                'artist_live_event'     => $LiveEventArtist ,
                'ThumbnailSetting'      => $FrontEndQueryController->ThumbnailSetting() ,
                'SeriesGenre'           => $FrontEndQueryController->SeriesGenre() ,
                'Series_based_on_Networks' => $FrontEndQueryController->Series_based_on_Networks(),
                'Series_based_on_category' => $FrontEndQueryController->Series_based_on_category() ,
                'multiple_compress_image'  => $FrontEndQueryController->multiple_compress_image() , 
                'videos_expiry_date_status'     => videos_expiry_date_status(),
                'default_vertical_image_url'    => default_vertical_image_url(),
                'default_horizontal_image_url'  => default_horizontal_image_url(),
                'order_settings_list'   => OrderHomeSetting::get(),
                'getfeching'            => Geofencing::first(),
            );

            return Theme::view('ChannelHome', $data);
        }else{
            return abort(404);
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

        return Theme::view('partials.channel.channel_category_series', $data);
        $theme = Theme::uses($this->Theme);

        return $theme->load('public/themes/default/views/partials/channel/channel_category_series', $data)->render();
    }

    public function channel_category_live(Request $request)
    {

        $LiveCategory = LiveCategory::find($request->category_id) != null ? LiveCategory::find($request->category_id)->specific_category_live : array();
        
        $Live_Category = $LiveCategory->where('user_id', $request->user_id)->where('uploaded_by' ,'Channel')->all();

        $data = array( 'LiveCategory' => $Live_Category );

        return Theme::view('partials.channel.channel_category_live', $data);
        $theme = Theme::uses($this->Theme);

        return $theme->load('public/themes/default/views/partials/channel/channel_category_live', $data)->render();
    }

    public function channel_category_audios(Request $request)
    {
         
        $AudioCategory = AudioCategory::find($request->category_id) != null ? AudioCategory::find($request->category_id)->specific_category_audio : array();
        
        $Audio_Category = $AudioCategory->where('user_id', $request->user_id)->where('uploaded_by' ,'Channel')->all();

        $data = array( 'AudioCategory' => $Audio_Category );

        return Theme::view('partials.channel.channel_category_audios', $data);
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

                $latest_videos = (new FrontEndQueryController)->latest_videos()->filter(function ($latest_videos) use ($channel) {
                    if ( $latest_videos->user_id == $channel->id && $latest_videos->uploaded_by == "Channel" ) {
                        return $latest_videos;
                    }
                });
    
                $latest_series = (new FrontEndQueryController)->latest_Series()->filter(function ($latest_Series) use ($channel) {
                    if ( $latest_Series->user_id == $channel->id && $latest_Series->uploaded_by == "Channel" ) {
                        return $latest_Series;
                    }
                });
    
                $latest_audios = (new FrontEndQueryController)->latest_audios()->filter(function ($latest_audios) use ($channel) {
                    if ( $latest_audios->user_id == $channel->id && $latest_audios->uploaded_by == "Channel" ) {
                        return $latest_audios;
                    }
                });
    
            $ThumbnailSetting = ThumbnailSetting::first();
            
            $data = array(
                'currency' => $currency,
                'latest_video' => $latest_videos,
                'latest_series' => $latest_series,
                'audios' => $latest_audios,
                'livetream' => $livetreams,
                'ThumbnailSetting'  => (new FrontEndQueryController)->ThumbnailSetting() ,
                'LiveCategory'  => (new FrontEndQueryController)->LiveCategory() ,
                'VideoCategory' => (new FrontEndQueryController)->genre_video_display() ,
                'SeriesGenre'   => (new FrontEndQueryController)->SeriesGenre() ,
                'AudioCategory' => (new FrontEndQueryController)->AudioCategory() ,
                'multiple_compress_image' => (new FrontEndQueryController)->multiple_compress_image() , 
                'order_settings_list' => OrderHomeSetting::get(),
                'getfeching'          => Geofencing::first(),
                
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
                'ThumbnailSetting'  => (new FrontEndQueryController)->ThumbnailSetting() ,
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
                'ThumbnailSetting'  => (new FrontEndQueryController)->ThumbnailSetting() ,
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
                'ThumbnailSetting'  => (new FrontEndQueryController)->ThumbnailSetting() ,
                'videos' => $data ,
                'channel_slug' => $channel_slug ,
            );

            return Theme::view('Channel.Channel_videos_list', [ 'respond_data' => $respond_data]);

        } catch (\Throwable $th) {

            return abort(404);
        }

    }
    
}
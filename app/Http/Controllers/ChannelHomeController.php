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
use App\OrderHomeSetting;
use App\CompressImage;

class ChannelHomeController extends Controller
{

    public function __construct()
    {
        $this->settings = Setting::first();

        $this->videos_per_page = $this->settings->videos_per_page;

        $this->Theme = HomeSetting::pluck('theme_choosen')->first();
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


            $featured_videos = (new FrontEndQueryController)->featured_videos()->filter(function ($featured_videos) use ($channel) {
                if ( $featured_videos->user_id == $channel->id && $featured_videos->uploaded_by == "Channel" ) {
                    return $featured_videos;
                }
            });


                     
            $trending_videos = (new FrontEndQueryController)->trending_videos()->filter(function ($trending_videos) use ($channel) {
                if ( $trending_videos->user_id == $channel->id && $trending_videos->uploaded_by == "Channel" ) {
                    return $trending_videos;
                }
            });

            $featured_episodes = (new FrontEndQueryController)->featured_episodes()->filter(function ($featured_episodes) use ($channel) {
                if ( $featured_episodes->user_id == $channel->id && $featured_episodes->uploaded_by == "Channel" ) {
                    return $featured_episodes;
                }
            });
            
            $genre_video_display = (new FrontEndQueryController)->genre_video_display()->filter(function ($genre_video_display) use ($channel) {
                if ( $genre_video_display->user_id == $channel->id && $genre_video_display->uploaded_by == "Channel" ) {
                    return $genre_video_display;
                }
            });

            $albums = (new FrontEndQueryController)->AudioAlbums()->filter(function ($albums) use ($channel) {
                if ( $albums->user_id == $channel->id && $albums->uploaded_by == "Channel" ) {
                    return $albums;
                }
            });

            $latest_episodes = (new FrontEndQueryController)->latest_episodes()->filter(function ($latest_episodes) use ($channel) {
                if ( $latest_episodes->user_id == $channel->id && $latest_episodes->uploaded_by == "Channel" ) {
                    return $latest_episodes;
                }
            });
            
            $artist = (new FrontEndQueryController)->artist()->filter(function ($artist) use ($channel) {
                if ( $artist->user_id == $channel->id && $artist->uploaded_by == "Channel" ) {
                    return $artist;
                }
            });

            $LiveCategory = (new FrontEndQueryController)->LiveCategory()->filter(function ($LiveCategory) use ($channel) {
                if ( $LiveCategory->user_id == $channel->id && $LiveCategory->uploaded_by == "Channel" ) {
                    return $LiveCategory;
                }
            });

            $LiveEventArtist = (new FrontEndQueryController)->LiveEventArtist()->filter(function ($LiveEventArtist) use ($channel) {
                if ( $LiveEventArtist->user_id == $channel->id && $LiveEventArtist->uploaded_by == "Channel" ) {
                    return $LiveEventArtist;
                }
            });

            $trending_audios = (new FrontEndQueryController)->trending_audios()->filter(function ($trending_audios) use ($channel) {
                if ( $trending_audios->user_id == $channel->id && $trending_audios->uploaded_by == "Channel" ) {
                    return $trending_audios;
                }
            });

            $live_banners = (new FrontEndQueryController)->live_banners()->filter(function ($live_banners) use ($channel) {
                if ( $live_banners->user_id == $channel->id && $live_banners->uploaded_by == "Channel" ) {
                    return $live_banners;
                }
            });

            $video_banners = (new FrontEndQueryController)->video_banners()->filter(function ($video_banners) use ($channel) {
                if ( $video_banners->user_id == $channel->id && $video_banners->uploaded_by == "Channel" ) {
                    return $video_banners;
                }
            });

            $series_sliders = (new FrontEndQueryController)->series_sliders()->filter(function ($series_sliders) use ($channel) {
                if ( $series_sliders->user_id == $channel->id && $series_sliders->uploaded_by == "Channel" ) {
                    return $series_sliders;
                }
            });

            $live_event_banners = (new FrontEndQueryController)->live_event_banners()->filter(function ($live_event_banners) use ($channel) {
                if ( $live_event_banners->user_id == $channel->id && $live_event_banners->uploaded_by == "Channel" ) {
                    return $live_event_banners;
                }
            });

            $Episode_sliders = (new FrontEndQueryController)->Episode_sliders()->filter(function ($Episode_sliders) use ($channel) {
                if ( $Episode_sliders->user_id == $channel->id && $Episode_sliders->uploaded_by == "Channel" ) {
                    return $Episode_sliders;
                }
            });

            
            $VideoCategory_banner = (new FrontEndQueryController)->VideoCategory_banner()->filter(function ($VideoCategory_banner) use ($channel) {
                if ( $VideoCategory_banner->user_id == $channel->id && $VideoCategory_banner->uploaded_by == "Channel" ) {
                    return $VideoCategory_banner;
                }
            });

            // $Most_watched_videos_users = (new FrontEndQueryController)->Most_watched_videos_users()->filter(function ($Most_watched_videos_users) use ($channel) {
            //     if ( $Most_watched_videos_users->user_id == $channel->id && $Most_watched_videos_users->uploaded_by == "Channel" ) {
            //         return $Most_watched_videos_users;
            //     }
            // });
            
            $Most_watched_videos_site = (new FrontEndQueryController)->Most_watched_videos_site()->filter(function ($Most_watched_videos_site) use ($channel) {
                if ( $Most_watched_videos_site->user_id == $channel->id && $Most_watched_videos_site->uploaded_by == "Channel" ) {
                    return $Most_watched_videos_site;
                }
            });

            $Most_watched_videos_country = (new FrontEndQueryController)->Most_watched_videos_country()->filter(function ($Most_watched_videos_country) use ($channel) {
                if ( $Most_watched_videos_country->user_id == $channel->id && $Most_watched_videos_country->uploaded_by == "Channel" ) {
                    return $Most_watched_videos_country;
                }
            });

            $AudioCategory = (new FrontEndQueryController)->AudioCategory()->filter(function ($AudioCategory) use ($channel) {
                if ( $AudioCategory->user_id == $channel->id && $AudioCategory->uploaded_by == "Channel" ) {
                    return $AudioCategory;
                }
            });
            
            // $preference_genres = (new FrontEndQueryController)->preference_genres()->filter(function ($preference_genres) use ($channel) {
            //     if ( $preference_genres->user_id == $channel->id && $preference_genres->uploaded_by == "Channel" ) {
            //         return $preference_genres;
            //     }
            // });

            // $preference_language = (new FrontEndQueryController)->preference_language()->filter(function ($preference_language) use ($channel) {
            //     if ( $preference_language->user_id == $channel->id && $preference_language->uploaded_by == "Channel" ) {
            //         return $preference_language;
            //     }
            // });
            // 
            // dd($Most_watched_videos_country);


            $data = array(
                'currency'              => $currency,
                'latest_video'          => $latest_videos,
                'latest_videos'         => $latest_videos,
                'videos'                => $latest_videos,
                'latest_series'         => $latest_series,
                'latest_audios'         => $latest_audios,
                'audios'                => $latest_audios,
                'trendings'             => $trending_videos,
                'trending_videos'       => $trending_videos,
                'suggested_videos'      => $trending_videos,
                'featured_episodes'     => $featured_episodes,
                
                'genre_video_display'   => $genre_video_display,
                'genres'                => $genre_video_display,
                'video_categories'      => $genre_video_display ,
                'VideoCategory'         => $genre_video_display ,
                
                'livetream'             => $livetreams,
                'channel_partner'       => $channel,

                'albums'                => $albums ,
                'latest_episode'        => $latest_episodes , 
                'artist'                => $artist ,
                'VideoSchedules'        => (new FrontEndQueryController)->VideoSchedules() ,

                'trending_audios'           => $trending_audios,

                'ThumbnailSetting'      => (new FrontEndQueryController)->ThumbnailSetting() ,
                'LiveCategory'          => $LiveCategory ,
                'SeriesGenre'           => (new FrontEndQueryController)->SeriesGenre() ,
                'AudioCategory'         => $AudioCategory ,
                'Series_based_on_Networks' => (new FrontEndQueryController)->Series_based_on_Networks(),
                'Series_based_on_category' => (new FrontEndQueryController)->Series_based_on_category() ,
                'artist_live_event'         => $LiveEventArtist ,
                'VideoCategory_banner' =>   $VideoCategory_banner, 
                // 'most_watch_user'      => $Most_watched_videos_users,
                'top_most_watched'     => $Most_watched_videos_site,
                'Most_watched_country'   =>  $Most_watched_videos_country, 
                // 'preference_genres'      => $preference_genres,
                // 'preference_Language'    => $preference_language, 
                'multiple_compress_image' => (new FrontEndQueryController)->multiple_compress_image() , 
                'order_settings_list' => OrderHomeSetting::get(),
                'getfeching'          => Geofencing::first(),
                'videos_expiry_date_status'     => videos_expiry_date_status(),
                'default_vertical_image_url'    => default_vertical_image_url(),
                'default_horizontal_image_url'  => default_horizontal_image_url(),
                'admin_advertistment_banners' => (new FrontEndQueryController)->admin_advertistment_banners(),
                'sliders'            => (new FrontEndQueryController)->sliders(), 
                'live_banner'        => $live_banners,  
                'video_banners'      => $video_banners, 
                'series_sliders'     => $series_sliders, 
                'live_event_banners' => $live_event_banners, 
                'Episode_sliders'    => $Episode_sliders,

                'settings' => $this->settings ,
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
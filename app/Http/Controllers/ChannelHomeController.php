<?php
namespace App\Http\Controllers;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
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

        $this->current_theme = $this->HomeSetting->theme_choosen ;
        Theme::uses($this->current_theme);

    }

    function paginateCollection(Collection $items, $perPage)
    {
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentPageItems = $items->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $paginatedItems = new LengthAwarePaginator($currentPageItems, $items->count(), $perPage);
        $paginatedItems->setPath(request()->url());

        return $paginatedItems;
    }
    
    public function ChannelHome($slug)
    {
        try {
        
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

            
            $check_Kidmode = 0 ;


            $genre_video_display = VideoCategory::query()->whereHas('category_videos', function ($query) use ($check_Kidmode,$channel_partner) {
                $query->where('videos.active', 1)->where('videos.status', 1)->where('videos.draft', 1)->where('videos.user_id', $channel_partner->id)->where('videos.uploaded_by','Channel');

                if (Geofencing() != null && Geofencing()->geofencing == 'ON') {
                    $query->whereNotIn('videos.id', Block_videos());
                }

                if ($check_Kidmode == 1) {
                    $query->whereBetween('videos.age_restrict', [0, 12]);
                }
            })

            ->with(['category_videos' => function ($videos) use ($check_Kidmode,$channel_partner) {
                $videos->select('videos.id', 'title', 'slug', 'year', 'rating', 'access', 'publish_type', 'global_ppv', 'publish_time', 'ppv_price', 'duration', 'rating', 'image', 'featured', 'age_restrict','player_image','description','videos.trailer','videos.trailer_type')
                    ->where('videos.active', 1)
                    ->where('videos.status', 1)
                    ->where('videos.draft', 1)
                    ->where('videos.user_id', $channel_partner->id)
                    ->where('videos.uploaded_by','Channel');

                if (Geofencing() != null && Geofencing()->geofencing == 'ON') {
                    $videos->whereNotIn('videos.id', Block_videos());
                }

                if ($check_Kidmode == 1) {
                    $videos->whereBetween('videos.age_restrict', [0, 12]);
                }

                $videos->latest('videos.created_at')->get();
            }])
            ->select('video_categories.id', 'video_categories.name', 'video_categories.slug', 'video_categories.in_home', 'video_categories.order')
            ->where('video_categories.in_home', 1)
            ->whereHas('category_videos', function ($query) use ($check_Kidmode,$channel_partner) {
                $query->where('videos.active', 1)->where('videos.status', 1)->where('videos.draft', 1)->where('videos.user_id', $channel_partner->id)->where('videos.uploaded_by','Channel');

                if (Geofencing() != null && Geofencing()->geofencing == 'ON') {
                    $query->whereNotIn('videos.id', Block_videos());
                }

                if ($check_Kidmode == 1) {
                    $query->whereBetween('videos.age_restrict', [0, 12]);
                }
            })
            ->orderBy('video_categories.order')
            ->get()
            ->map(function ($category) {
                $category->category_videos->map(function ($video) {
                    $video->image_url = URL::to('/public/uploads/images/'.$video->image);
                    $video->Player_image_url = URL::to('/public/uploads/images/'.$video->player_image);
                    return $video;
                });
                $category->source =  "category_videos" ;
                return $category;
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

            $livetreams = $FrontEndQueryController->livestreams()->filter(function ($livetreams) use ($channel_partner) {
                if ( $livetreams->user_id == $channel_partner->id && $livetreams->uploaded_by == "Channel" ) {
                    return $livetreams;
                }
            });

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

            $AudioCategory = $FrontEndQueryController->AudioCategory()->filter(function ($AudioCategory) use ($channel_partner) {
                if ( $AudioCategory->user_id == $channel_partner->id && $AudioCategory->uploaded_by == "Channel" ) {
                    return $AudioCategory;
                }
            });

            // Order Setting 

            $home_settings_on_value = collect($this->HomeSetting)->filter(function ($value) {
                return $value === '1' || $value === 1;  
            })->keys()->toArray(); 

            $order_settings = OrderHomeSetting::select('video_name')->whereIn('video_name',$home_settings_on_value)->orderBy('order_id', 'asc')->get();

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
                'VideoCategory'         => $genre_video_display,
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
                'AudioCategory'         => $AudioCategory ,
                'ThumbnailSetting'      => $FrontEndQueryController->ThumbnailSetting() ,
                'SeriesGenre'           => $FrontEndQueryController->SeriesGenre() ,
                'Series_based_on_Networks' => $FrontEndQueryController->Series_based_on_Networks(),
                'Series_based_on_category' => $FrontEndQueryController->Series_based_on_category() ,
                'multiple_compress_image'  => $FrontEndQueryController->multiple_compress_image() , 
                'videos_expiry_date_status'     => videos_expiry_date_status(),
                'default_vertical_image_url'    => default_vertical_image_url(),
                'default_horizontal_image_url'  => default_horizontal_image_url(),
                'order_settings_list'   => OrderHomeSetting::get(),
                'order_settings'        => $order_settings ,
                'home_settings'       => $this->HomeSetting ,
                'getfeching'            => Geofencing::first(),
            );

            return Theme::view('ChannelHome', $data);
        }else{
            return abort(404);
        }
            
        } catch (\Throwable $th) {
            // return $th->getMessage();
            return abort(404);
        }
    }

    public function ChannelList()
    {
        try{

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
                'default_vertical_image_url'    => default_vertical_image_url(),
                'default_horizontal_image_url'  => default_horizontal_image_url(),
                'home_settings'       => $this->HomeSetting ,
                'current_theme'      => $this->HomeSetting->theme_choosen,
            );
            
            return Theme::view('ChannelList', $data);
            
        } catch (\Throwable $th) {
            // return $th->getMessage();
            return abort(404);
        }
        
    }

    public function channel_category_videos(Request $request)
    {

        $request->category_id = 1;
        $VideoCategory = VideoCategory::find($request->category_id);
        if ($VideoCategory !== null) {
            $videosCategoryCollection = $VideoCategory->specific_category_videos;
        } else {
            $videosCategoryCollection = collect();
        }

        $videos_Category = $videosCategoryCollection->where('user_id', $request->user_id)->where('uploaded_by' ,'Channel')->all();

        $data = array( 'VideoCategory' => $videos_Category );
 
            return Theme::view('partials.channel.channel_category_videos', $data);
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
        $LiveCategory = LiveCategory::find($request->category_id);
        if ($LiveCategory !== null) {
            $LiveCategoryCollection = $LiveCategory->specific_category_live;
        } else {
            $LiveCategoryCollection = collect();
        }
        
    
        $Live_Category = $LiveCategoryCollection->where('user_id', $request->user_id)
                                                ->where('uploaded_by', 'Channel')
                                                ->all();
    
        $data = array('LiveCategory' => $Live_Category);
        return Theme::view('partials.channel.channel_category_live', $data);
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

            $Audio = Audio::where('active', '1')->where('user_id', $channel->id)
                    ->where('uploaded_by','Channel')
                    ->latest()
                    ->get() ;

            $Audio = $this->paginateCollection($Audio, $this->videos_per_page);


            $respond = array(
                'settings' => Setting::first(),
                'currency' => CurrencySetting::first(),
                'ThumbnailSetting'  => (new FrontEndQueryController)->ThumbnailSetting() ,
                'audios' => $Audio ,
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

            $live = LiveStream::where('active','1')->where('user_id',$channel->id)
                                ->where('uploaded_by','Channel')
                                ->latest()
                                ->get();

            $live = $this->paginateCollection($live, $this->videos_per_page);

                                
            // dd($live);
            $data = array(
                'settings' => Setting::first(),
                'currency' => CurrencySetting::first(),
                'ThumbnailSetting' => ThumbnailSetting::first(),
                'live' => $live ,
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
           
            $Series = Series::where('active','1')->where('user_id', $channel->id)
                            ->where('uploaded_by', 'Channel')
                            ->latest()
                            ->get();

            $Series = $this->paginateCollection($Series, $this->videos_per_page);

            $respond_data = array(
                'settings' => Setting::first(),
                'currency' => CurrencySetting::first(),
                'ThumbnailSetting'  => (new FrontEndQueryController)->ThumbnailSetting() ,
                'Series' => $Series ,
                'channel_slug' => $channel_slug ,
            );

            return Theme::view('channel.Channel_series_list',  [ 'respond_data' => $respond_data]);

        } catch (\Throwable $th) {
            // return $th->getMessage();
            return abort(404);
        }
    }
    
    public function Channel_videos_list($channel_slug)
    {
        try {

            $channel = Channel::where('channel_slug',$channel_slug)->first(); 

            $Video = Video::where('active', '=', '1')->where('status', '=', '1')
                            ->where('user_id', '=', $channel->id)
                            ->where('uploaded_by', '=', 'Channel')->where('draft', '=', '1')
                            ->get();

            $Video = $this->paginateCollection($Video, $this->videos_per_page);


            $respond_data = array(
                'settings' => Setting::first(),
                'currency' => CurrencySetting::first(),
                'ThumbnailSetting'  => (new FrontEndQueryController)->ThumbnailSetting() ,
                'videos' => $Video ,
                'channel_slug' => $channel_slug ,
            );

            return Theme::view('Channel.Channel_videos_list', [ 'respond_data' => $respond_data]);

        } catch (\Throwable $th) {

            return abort(404);
        }

    }
    
}
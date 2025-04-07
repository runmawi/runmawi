<?php

namespace App\Http\Controllers;

use DB;
use Theme;
use Session;
use App\User;
use App\Audio;
use App\Video;
use App\Artist;
use App\Series;
use App\Slider;
use App\Channel;
use App\Episode;
use App\Setting;
use App\TimeZone;
use App\UGCVideo;
use Carbon\Carbon;
use App\Geofencing;
use App\LiveStream;
use App\RecentView;
use App\AudioAlbums;
use App\HomeSetting;
use App\SeriesGenre;
use App\LiveCategory;
use App\Multiprofile;
use App\AudioCategory;
use App\CompressImage;
use App\SeriesNetwork;
use App\VideoCategory;
use App\ModeratorsUser;
use App\VideoSchedules;
use App\Watchlater;
use App\Wishlist;
use App\AdminEPGChannel;
use App\LiveEventArtist;
use App\ThumbnailSetting;
use Illuminate\Http\Request;
use App\ChannelVideoScheduler;
use App\AdminAdvertistmentBanners;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL; 
use Illuminate\Support\Facades\File; 
use App\CategoryVideo;
use App\Videoartist;
use App\ContinueWatching;
use App\CountryCode;
use App\SeriesSeason;
use App\StorageSetting;

class FrontEndQueryController extends Controller
{
    protected $default_vertical_image;
    protected $default_horizontal_image_url;
    protected $settings;
    protected $videos_per_page;
    protected $HomeSetting;
    protected $getfeching;
    protected $videos_expiry_date_status;
    protected $current_timezone;
    protected $blockVideos;
    protected $countryName;
    protected $multiuser_CheckExists;
    protected $Mode;
    protected $check_Kidmode;
    
    public function __construct()
    {
        $this->settings = Setting::first();
        $this->videos_per_page = $this->settings->videos_per_page;

        $this->HomeSetting = HomeSetting::first();
        Theme::uses($this->HomeSetting->theme_choosen);

        $this->getfeching = Geofencing::first();
        $this->videos_expiry_date_status = videos_expiry_date_status();

        $this->default_vertical_image_url = default_vertical_image_url();
        $this->default_horizontal_image_url = default_horizontal_image_url();
        $this->current_timezone = current_timezone();

        $this->blockVideos = Block_videos();
        $this->countryName = Country_name();

        // Verify check Kidmode
        $this->multiuser_CheckExists = Session::get('subuser_id');

        if (  $this->multiuser_CheckExists  != null && !Auth::guest() ) {

            $this->Mode = Multiprofile::where('id', $this->multiuser_CheckExists)->first() ;

        }elseif( !Auth::guest()) {
            $this->Mode =  User::where('id', Auth::User()->id)->first();
        }
                    
        $this->check_Kidmode = !Auth::guest() && $this->Mode['user_type'] != null && $this->Mode['user_type'] == "Kids" ? 1 : 0 ;

        $this->BunnyCDNEnable = StorageSetting::pluck('bunny_cdn_storage')->first();

        $this->BaseURL = $this->BunnyCDNEnable == 1 ? StorageSetting::pluck('bunny_cdn_base_url')->first() : URL::to('public/uploads') ;

        
    }

    public function Latest_videos()
    {
        $latest_videos = Video::select('id','title','slug','year','rating','access','publish_type','global_ppv','publish_time','ppv_price', 'duration','rating','image','featured','age_restrict','video_tv_image','description',
                                        'player_image','expiry_date','responsive_image','responsive_player_image','responsive_tv_image','user_id','uploaded_by')

                                ->where('active',1)->where('status', 1)->where('draft',1);

                                if( $this->getfeching !=null && $this->getfeching->geofencing == 'ON'){
                                    $latest_videos = $latest_videos->whereNotIn('videos.id',$this->blockVideos);
                                }

                                if ($this->videos_expiry_date_status == 1 ) {
                                    $latest_videos = $latest_videos->whereNull('expiry_date')->orwhere('expiry_date', '>=', Carbon::now()->format('Y-m-d\TH:i') );
                                }
                                
                                if ($this->check_Kidmode == 1) {
                                    $latest_videos = $latest_videos->whereBetween('videos.age_restrict', [0, 12]);
                                }


            $latest_videos = $latest_videos->latest()->get()->map(function ($item) {
                $item['image_url']  = (!is_null($item->image) && $item->image != 'default_image.jpg') ? $this->BaseURL.('/images/'.$item->image) : $this->default_vertical_image ;
                $item['player_image_url']  = (!is_null($item->player_image) && $item->player_image != 'default_image.jpg') ? $this->BaseURL.('/images/'.$item->player_image) : $this->default_horizontal_image_url ;
                return $item;
            });
        return $latest_videos ;
    }

    public function AllMovies()
    {
        $All_movies = Video::select('id','title','slug','year','rating','access','publish_type','global_ppv','publish_time','ppv_price', 'duration','rating','image','featured','age_restrict','video_tv_image','description',
                                        'player_image','expiry_date','responsive_image','responsive_player_image','responsive_tv_image','user_id','uploaded_by')

                                ->where('active',1)->where('status', 1)->where('draft',1)->orderBy('title');

                                if( $this->getfeching !=null && $this->getfeching->geofencing == 'ON'){
                                    $All_movies = $All_movies->whereNotIn('videos.id',$this->blockVideos);
                                }

                                if ($this->videos_expiry_date_status == 1 ) {
                                    $All_movies = $All_movies->whereNull('expiry_date')->orwhere('expiry_date', '>=', Carbon::now()->format('Y-m-d\TH:i') );
                                }
                                
                                if ($this->check_Kidmode == 1) {
                                    $All_movies = $All_movies->whereBetween('videos.age_restrict', [0, 12]);
                                }


            $All_movies = $All_movies->latest()->get()->map(function ($item) {
                $item['image_url']  = (!is_null($item->image) && $item->image != 'default_image.jpg') ? $this->BaseURL.('/images/'.$item->image) : $this->default_vertical_image ;
                $item['player_image_url']  = (!is_null($item->player_image) && $item->player_image != 'default_image.jpg') ? $this->BaseURL.('/images/'.$item->player_image) : $this->default_horizontal_image_url ;
                return $item;
            });
        return $All_movies ;
    }

    public function Order_Latest_videos()
    {
        $latest_videos = Video::select('id','title','slug','year','rating','access','publish_type','global_ppv','publish_time','ppv_price', 'duration','rating','image','featured','age_restrict','video_tv_image','description',
                                        'player_image','expiry_date','responsive_image','responsive_player_image','responsive_tv_image','user_id','uploaded_by')

                                ->where('active',1)->where('status', 1)->where('draft',1);

                                if( $this->getfeching !=null && $this->getfeching->geofencing == 'ON'){
                                    $latest_videos = $latest_videos->whereNotIn('videos.id',$this->blockVideos);
                                }

                                if ($this->videos_expiry_date_status == 1 ) {
                                    $latest_videos = $latest_videos->whereNull('expiry_date')->orwhere('expiry_date', '>=', Carbon::now()->format('Y-m-d\TH:i') );
                                }
                                
                                if ($this->check_Kidmode == 1) {
                                    $latest_videos = $latest_videos->whereBetween('videos.age_restrict', [0, 12]);
                                }


            $latest_videos = $latest_videos->orderBy('title')->get()->map(function ($item) {
                $item['image_url']  = (!is_null($item->image) && $item->image != 'default_image.jpg') ? $this->BaseURL.('/images/'.$item->image) : $this->default_vertical_image ;
                $item['player_image_url']  = (!is_null($item->player_image) && $item->player_image != 'default_image.jpg') ? $this->BaseURL.('/images/'.$item->player_image) : $this->default_horizontal_image_url ;
                return $item;
            });
        return $latest_videos ;
    }

    public function trending_videos()
    {
        $trending_videos = Video::select('id','title','slug','year','rating','access','publish_type','global_ppv','publish_time','ppv_price', 'duration','rating','image','featured','age_restrict','video_tv_image','description',
            'player_image','expiry_date','responsive_image','responsive_player_image','responsive_tv_image','uploaded_by','user_id')

        ->where('active',1)->where('status', 1)->where('draft',1)->where('views', '>', '5');

        if( $this->getfeching !=null && $this->getfeching->geofencing == 'ON'){
            $trending_videos = $trending_videos->whereNotIn('videos.id',$this->blockVideos);
        }

        if ($this->videos_expiry_date_status == 1 ) {
            $trending_videos = $trending_videos->whereNull('expiry_date')->orwhere('expiry_date', '>=', Carbon::now()->format('Y-m-d\TH:i') );
        }
        
        if ($this->check_Kidmode == 1) {
            $trending_videos = $trending_videos->whereBetween('videos.age_restrict', [0, 12]);
        }

        $trending_videos = $trending_videos->latest()->get();

        return $trending_videos;

    }

    public function featured_videos()
    {
        $featured_videos = Video::select('id','title','slug','year','rating','access','publish_type','global_ppv','publish_time','ppv_price', 'duration','rating','image','featured','age_restrict','video_tv_image','description',
                                        'player_image','expiry_date','responsive_image','responsive_player_image','responsive_tv_image','uploaded_by','user_id')

                                    ->where('active',1)->where('status', 1)->where('draft',1)->where('featured', '1');

                                    if( $this->getfeching !=null && $this->getfeching->geofencing == 'ON'){
                                        $featured_videos = $featured_videos->whereNotIn('videos.id',$this->blockVideos);
                                    }

                                    if ($this->videos_expiry_date_status == 1 ) {
                                       $featured_videos = $featured_videos->whereNull('expiry_date')->orwhere('expiry_date', '>=', Carbon::now()->format('Y-m-d\TH:i') );
                                    }
                                    
                                    if ($this->check_Kidmode == 1) {
                                        $featured_videos = $featured_videos->whereBetween('videos.age_restrict', [0, 12]);
                                    }

                                $featured_videos = $featured_videos->latest()->get();

        return $featured_videos;
    }

    public function VideoSchedules()
    {
        $VideoSchedules  = VideoSchedules::where('in_home',1)->get();

        return $VideoSchedules ;
    }
    
    public function genre_video_display()
    {
        $genre_video_display = VideoCategory::where('in_home',1)->orderBy('order','ASC')->get();

        return $genre_video_display ;
    }

    public function SeriesGenre()
    {
        $SeriesGenre =  SeriesGenre::orderBy('order','ASC')->get();
        return $SeriesGenre ;
    }

    public function latest_Series()
    {
        $countryList = CountryCode::pluck('country_name', 'id')->toArray();
      
            $latest_series = Series::select('id', 'title', 'slug', 'year', 'rating', 'access', 
                                             'duration', 'image', 'featured', 'tv_image', 'player_image', 
                                             'details', 'description', 'uploaded_by', 'user_id', 
                                             'available_countries', 'blocked_countries')
                ->where('active', '1')
                ->latest()
                ->get()
                ->map(function ($series) use ($countryList) {
                    $blockedCountries = json_decode($series->blocked_countries, true);
            
                    // Replace IDs with country names
                    $series->blocked_countries_names = array_map(function ($id) use ($countryList) {
                        return $countryList[$id] ?? null;
                    }, $blockedCountries ?: []);
                    $series['image_url']        = !is_null($series->image)  ? $this->BaseURL.('/images/'.$series->image) : $this->default_vertical_image_url ;
                    $series['Player_image_url'] = !is_null($series->player_image)  ? $this->BaseURL.('/images/'.$series->player_image ) : $this->default_horizontal_image_url ;

            
                    return $series;
                });
              
            return $latest_series;
        

            // $latest_series = Series::select('id','title','slug','year','rating','access','duration','rating','image','featured','tv_image','player_image','details','description','uploaded_by','user_id','available_countries','blocked_countries')
            //     ->where('active', '1')->latest()->get();
    
            // return $latest_series ;
    }

    public function Series_based_on_category()
    {
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

                $item['image_url']        = !is_null($item->image)  ? $this->BaseURL.('/images/'.$item->image) : $this->default_vertical_image_url ;
                $item['Player_image_url'] = !is_null($item->player_image)  ? $this->BaseURL.('/images/'.$item->player_image ) : $this->default_horizontal_image_url ;

                $item['upload_on'] =  Carbon::parse($item->created_at)->isoFormat('MMMM Do YYYY'); 

                $item['duration_format'] =  !is_null($item->duration) ?  Carbon::parse( $item->duration)->format('G\H i\M'): null ;

                $item['Series_depends_episodes'] = Series::find($item->id)->Series_depends_episodes
                                                        ->map(function ($item) {
                                                            $item['image_url']  = !is_null($item->image) ? $this->BaseURL.('/images/'.$item->image) : $this->default_vertical_image_url ;
                                                            return $item;
                                                    });

                $item['source'] = 'Series';
                return $item;
            });
            $category->source = 'Series_Genre';
            return $category;
        });

        return $Series_based_on_category ;
    }

    public function Series_based_on_Networks()
    {
        $Series_based_on_Networks = SeriesNetwork::where('in_home', 1)
        ->orderBy('order')
        ->get()
        ->map(function ($item) {
            $item['Series_depends_Networks'] = Series::join('series_network_order', 'series.id', '=', 'series_network_order.series_id')
                ->where('series.active', 1)
                ->where('series_network_order.network_id', $item->id)
                ->orderBy('series_network_order.order', 'asc')
                ->get()
                ->map(function ($series) {
                    $series->id = $series->series_id;
                    $series['image_url'] = (!is_null($series->image) && $series->image != 'default_image.jpg')
                        ? $this->BaseURL.('/images/' . $series->image)
                        : $this->default_vertical_image;
    
                    $series['Player_image_url'] = (!is_null($series->player_image) && $series->player_image != 'default_image.jpg')
                        ? $this->BaseURL.('/images/' . $series->player_image)
                        : $this->default_horizontal_image_url;
    
                    $series['upload_on'] = Carbon::parse($series->created_at)->isoFormat('MMMM Do YYYY');
                    $series['duration_format'] = !is_null($series->duration)
                        ? Carbon::parse($series->duration)->format('G\H i\M')
                        : null;
                    $season_ids = SeriesSeason::where('series_id',$series->id)->orderBy('order','desc')->pluck('id');
                    $first_season_id = $season_ids->first();
                    $season_epi_count = Episode::where('season_id',$first_season_id)->where('active','1')->count();
                    // dd($season_ids);

                    if ($season_ids->isNotEmpty()) {
                            $series['Series_depends_episodes'] = Episode::where('series_id', $series->id)
                                                                ->whereIn('season_id', $season_ids)
                                                                ->where('active', 1)
                                                                ->orderByRaw("FIELD(season_id, " . implode(',', $season_ids->toArray()) . ")") // Orders by given season order
                                                                ->orderBy('episode_order','desc')
                                                                ->take(15)
                                                                ->get()
                                ->map(function ($episode) {
                                    $episode['image_url'] = (!is_null($episode->image) && $episode->image != 'default_image.jpg')
                                        ? $this->BaseURL.('/images/' . $episode->image)
                                        : $this->default_vertical_image;
                                    $episode['player_image_url'] = (!is_null($episode->player_image) && $episode->player_image != 'default_horizontal_image.jpg') ? $this->BaseURL.('/images/' . $episode->player_image)  : $this->default_horizontal_image_url;
            
                                    $episode['season_name'] = SeriesSeason::where('id', $episode->season_id)
                                        ->pluck('series_seasons_name')
                                        ->first();
            
                                    return $episode;
                                });
                    } else {
                        $series['Series_depends_episodes'] = collect(); // Return empty collection if no seasons found
                    }
                        $totalEpisodes = Episode::where('series_id', $series->id)->where('active',1)->count();

                        $series['has_more'] = $totalEpisodes > 14;
                    $series['source'] = 'Series';
    
                    return $series;
                });
    
            return $item;
        });
    
        // dd(count($Series_based_on_Networks));
        return $Series_based_on_Networks;
    }

    public function latest_episodes()
    {
        $latest_episode = Episode::select('id','title','slug','rating','access','series_id','season_id','ppv_price','responsive_image','responsive_player_image','responsive_tv_image','episode_description',
                'duration','rating','image','featured','tv_image','player_image','uploaded_by','user_id')
                ->where('active', '1')->where('status', '1')->latest()
                ->get()->map(function($item){
                    $item['series'] = Series::where('id',$item->series_id)->first();
                    return $item ;
                });

        return $latest_episode;
    }

    public function featured_episodes(){

        $featured_episodes = Episode::select('id','title','slug','rating','access','series_id','season_id','ppv_price','responsive_image','responsive_player_image','responsive_tv_image','episode_description',
                                                 'duration','rating','image','featured','tv_image','player_image','uploaded_by','user_id')
                                            ->where('active', 1)->where('featured' ,1)->where('status', '1')
                                            ->latest()
                                            ->get()->map(function($item){
                                                $item['series'] = Series::where('id',$item->series_id)->first();
                                                return $item ;
                                            });

        return $featured_episodes;
    }

    public function trending_episodes(){

        $trending_episodes = Episode::select('id','title','slug','rating','access','series_id','season_id','ppv_price','responsive_image','responsive_player_image','responsive_tv_image',
                                                 'duration','rating','image','featured','tv_image','player_image','uploaded_by','user_id')
                                            ->where('status', '1')->where('active', 1)->where('views', '>', '5')
                                            ->latest()
                                            ->get()->map(function($item){
                                                $item['series'] = Series::where('id',$item->series_id)->first();
                                                return $item ;
                                            });

        return $trending_episodes;
    }

    public function free_episodes()
    {
        $free_episodes = Episode::select('id','title','slug','rating','access','series_id','season_id','ppv_price','responsive_image','responsive_player_image','responsive_tv_image',
                                                 'duration','rating','image','featured','tv_image','player_image','uploaded_by','user_id')
                                            ->where('status', 1)->where('active', 1)->where('access', 'guest')
                                            ->latest()
                                            ->get()->map(function($item){
                                                $item['series'] = Series::where('id',$item->series_id)->first();
                                                return $item ;
                                            });

        return $free_episodes;
    }

    public function free_series()
    {
        $free_series =  Series::select('id','title','slug','year','rating','access','duration','rating','image','featured','tv_image','player_image','details','description','uploaded_by','user_id')
                                ->where('active', '1')->where('access', 'guest')->latest()
                                ->get();

        return $free_series;
    }
    
    public function livestreams()
    {
        $current_timezone = current_timezone();

        $default_vertical_image_url = default_vertical_image_url();
        $default_horizontal_image_url = default_horizontal_image_url();

        $livestreams = LiveStream::select('id', 'title', 'slug', 'year', 'rating', 'access', 'publish_type', 'publish_time', 'publish_status', 'ppv_price',
                                            'duration', 'image', 'featured', 'Tv_live_image', 'player_image', 'details', 'description', 'free_duration',
                                            'recurring_program', 'program_start_time', 'program_end_time', 'custom_start_program_time', 'custom_end_program_time',
                                            'recurring_timezone', 'recurring_program_week_day', 'recurring_program_month_day','uploaded_by','user_id')
                                        ->where('active', '1')
                                        ->where('status', 1)
                                        ->orderBy('created_at', 'desc') 
                                        ->get()->map(function ($item) use ($default_vertical_image_url,$default_horizontal_image_url) {
                                            $item['image_url'] = !is_null($item->image) ? $this->BaseURL.('/images/'.$item->image) : $default_vertical_image_url ;
                                            $item['Player_image_url'] = !is_null($item->player_image) ?  $this->BaseURL.('/images/'.$item->player_image) : $default_horizontal_image_url ;
                                            $item['tv_image_url'] = !is_null($item->image) ? $this->BaseURL.('/images/'.$item->Tv_live_image) : $default_horizontal_image_url  ;
                                            $item['description'] = $item->description ;
                                            $item['source']    = "Livestream";
                                            return $item;
                                        });
    
        $livestreams_filter = $livestreams->filter(function ($livestream) use ($current_timezone) {
            if ($livestream->publish_type === 'recurring_program') {
        
                $Current_time = Carbon::now($current_timezone);
                $recurring_timezone = TimeZone::where('id', $livestream->recurring_timezone)->value('time_zone');
                $convert_time = $Current_time->copy()->timezone($recurring_timezone);
                $midnight = $convert_time->copy()->startOfDay();

                switch ($livestream->recurring_program) {
                    case 'custom':
                        $recurring_program_Status = $convert_time->greaterThanOrEqualTo($midnight) && $livestream->custom_end_program_time >=  Carbon::parse($convert_time)->format('Y-m-d\TH:i') ;
                        $recurring_program_live_animation = $livestream->custom_start_program_time <= $convert_time && $livestream->custom_end_program_time >= $convert_time;
                        break;
                    case 'daily':
                        $recurring_program_Status = $convert_time->greaterThanOrEqualTo($midnight) && $livestream->program_end_time >= $convert_time->format('H:i');
                        $recurring_program_live_animation = $livestream->program_start_time <= $convert_time->format('H:i') && $livestream->program_end_time >= $convert_time->format('H:i');
                        break;
                    case 'weekly':
                        $recurring_program_Status =  ( $livestream->recurring_program_week_day == $convert_time->format('N') ) && $convert_time->greaterThanOrEqualTo($midnight)  && ( $livestream->program_end_time >= $convert_time->format('H:i') );
                        $recurring_program_live_animation = $livestream->recurring_program_week_day == $convert_time->format('N') && $livestream->program_start_time <= $convert_time->format('H:i') && $livestream->program_end_time >= $convert_time->format('H:i');
                        break;
                    case 'monthly':
                        $recurring_program_Status = $livestream->recurring_program_month_day == $convert_time->format('d') && $convert_time->greaterThanOrEqualTo($midnight) && $livestream->program_end_time >= $convert_time->format('H:i');
                        $recurring_program_live_animation = $livestream->recurring_program_month_day == $convert_time->format('d') && $livestream->program_start_time <= $convert_time->format('H:i') && $livestream->program_end_time >= $convert_time->format('H:i');
                        break;
                    default:
                        $recurring_program_Status = false;
                        $recurring_program_live_animation = false;
                        break;
                }

                $livestream->recurring_program_live_animation = $recurring_program_live_animation;

                $livestream->recurring_program_live_animation_mobile = $recurring_program_live_animation == true ? 'true' : 'false' ;

                $livestream->live_animation = $recurring_program_live_animation == true ? 'true' : 'false' ;
        
                return $recurring_program_Status;
            }
        
            if ($livestream->publish_type === 'publish_later') {

                $Current_time = Carbon::now($current_timezone);
                
                $publish_later_Status = Carbon::parse($livestream->publish_time)->startOfDay()->format('Y-m-d\TH:i')  <=  $Current_time->format('Y-m-d\TH:i') ;
                $publish_later_live_animation = Carbon::parse($livestream->publish_time)->format('Y-m-d\TH:i')  <=  $Current_time->format('Y-m-d\TH:i') ;

                $livestream->publish_later_live_animation = $publish_later_live_animation;
                
                $livestream->recurring_program_live_animation_mobile = $publish_later_live_animation  == true ? 'true' : 'false' ;

                $livestream->live_animation = $publish_later_live_animation  == true ? 'true' : 'false' ;

                return $publish_later_Status;
            }
        
            return $livestream->publish_type === 'publish_now' || $livestream->publish_type === 'publish_later' && $livestream->publish_later_Status || ($livestream->publish_type === 'recurring_program' && $recurring_program_Status);
        });

        $livestreams_sort = $livestreams_filter->sortBy(function ($livestream) {

            if ($livestream->publish_type === 'publish_now') {

                return $livestream->created_at;

            } elseif ($livestream->publish_type === 'publish_later' ) {

                return $livestream->publish_time;

            } elseif ($livestream->publish_type === 'recurring_program') {
                
                $custom_start_time = !empty($livestream->custom_start_program_time) ?  Carbon::parse($livestream->custom_start_program_time)->format('H:i') : null;
                
                return $custom_start_time ?? $livestream->program_start_time;
            }

            return $livestream->publish_type;
        })
        ->values();  
        // dd($livestreams_sort);
        return $livestreams_sort;
    }


    public function LiveCategory()
    {
        $LiveCategory = LiveCategory::orderBy('order','ASC')->get();

        return $LiveCategory ;
    }

    public function LiveEventArtist()
    {
        $LiveEventArtist = LiveEventArtist::where("active",1)->where('status',1)->latest()->get();

        return $LiveEventArtist ;
    }

    public function live_event_banners()
    {
        $LiveEventArtist = LiveEventArtist::where('active', 1)->where('status',1)->where('banner', 1)->latest()->get();
        
        return $LiveEventArtist ;
    }

    public function sliders()
    {
        $sliders  = Slider::where('active', '1') ->orderBy('order_position', 'ASC')->get() ;
        return $sliders;
    }

    public function Episode_sliders()
    {
        $Episode = Episode::where('active', '1')->where('status', '1')->where('banner', '1')->orderBy('id')
        ->get()->map(function($item){
            $item['series'] = Series::where('id',$item->series_id)->first();
            return $item ;
        });
       
        return $Episode ;
    }

    public function series_sliders()
    {
        $series_sliders = Series::select('id','title','slug','year','rating','access','banner','active',
                                        'duration','rating','image','featured','tv_image','player_image','details','description','uploaded_by','user_id')
                                ->where('active', 1)->where('banner',1)
                                ->latest()
                                ->get() ;

        return $series_sliders ;
    }

    public function live_banners()
    {
        $live_banners = LiveStream::select('id','title','slug','year','rating','access','publish_type','publish_time','publish_status','ppv_price',
                                            'duration','rating','image','featured','Tv_live_image','player_image','details','description','free_duration','uploaded_by','user_id')
                                            ->where('active', '1')
                                            ->where('banner', '1')
                                            ->latest()
                                            ->get() ;
        return $live_banners ;
    }
 
    public function video_banners()
    {
        $video_banner = Video::where('banner', 1)->where('active', 1)->where('status', 1)->where('draft', 1);
    
        if ($this->getfeching != null && $this->getfeching->geofencing == 'ON') {
            $video_banner = $video_banner->whereNotIn('videos.id', $this->blockVideos);
        }
    
        if ($this->check_Kidmode == 1) {
            $video_banner = $video_banner->whereBetween('videos.age_restrict', [0, 12]);
        }
    
        if ($this->videos_expiry_date_status == 1) {
            $video_banner = $video_banner->where(function ($query) {
                $query->whereNull('expiry_date')->orWhere('expiry_date', '>=', now()->format('Y-m-d\TH:i'));
            });
        }
    
        $video_banner = $video_banner->latest()->get()->map(function ($item) {

            $item['categories'] =  CategoryVideo::select('categoryvideos.*','category_id','video_id','video_categories.name as name','video_categories.slug')
                                                        ->join('video_categories','video_categories.id','=','categoryvideos.category_id')
                                                        ->where('video_id', $item->id)->get() ;

            $item['artists']    =  Videoartist::select('video_id','artist_id','artists.*')
                                                    ->join('artists','artists.id','=','video_artists.artist_id')
                                                    ->where('video_id', $item->id)->get();
            return $item;
        });
        return $video_banner ;
    }
 
    public function VideoCategory_banner()
    {
                    // Video Category Banner
 
        $VideoCategory_id = VideoCategory::where('in_home',1)->where('banner', 1)->pluck('id')->toArray();
    
        $VideoCategory_banner = Video::join('categoryvideos', 'categoryvideos.video_id', '=', 'videos.id')
                                ->whereIn('category_id', $VideoCategory_id)->where('videos.active', 1)->where('videos.status', 1)
                                ->where('videos.draft', 1)->where('videos.banner', 0);   
    
                                if ($this->getfeching != null && $this->getfeching->geofencing == 'ON') {
                                    $VideoCategory_banner = $VideoCategory_banner->whereNotIn('videos.id', $this->blockVideos);
                                }
    
                                if ($this->check_Kidmode == 1) {
                                    $VideoCategory_banner = $VideoCategory_banner->whereBetween('videos.age_restrict', [0, 12]);
                                }
    
                                if ($this->videos_expiry_date_status == 1) {
                                    $VideoCategory_banner = $VideoCategory_banner->where(function ($query) {
                                        $query->whereNull('videos.expiry_date')->orWhere('videos.expiry_date', '>=', now()->format('Y-m-d\TH:i'));
                                    });
                                }
    
        $VideoCategory_banner = $VideoCategory_banner->latest('videos.created_at')->get();

        return $VideoCategory_banner ;
    }

    public function AudioAlbums()
    {
        $albums = AudioAlbums::latest() ->get() ;
        return $albums ;
    }

    public function latest_audios()
    {
        
        $latest_audios = Audio::select('id','title','slug','ppv_status','year','rating','access','ppv_price','duration','rating','image','featured','player_image','details','description','uploaded_by','user_id')
                                ->where('active', '1')->where('status', '1')
                                ->latest()->get();

        return $latest_audios ;
    }

    public function trending_audios()
    {
        
        $trending_audios = Audio::select('id','title','slug','ppv_status','year','rating','access','ppv_price','duration','rating','image','featured','player_image','details','description','uploaded_by','user_id')
                                    ->where('active', '1')->where('status', '1')
                                    ->where('views', '>', '5')
                                    ->latest()
                                    ->get();

        return $trending_audios ;
    }

    public function AudioCategory()
    {
        $AudioCategory  = AudioCategory::orderBy('order','ASC')->get();

        return $AudioCategory ;
    }

    public function artist()
    {
        $Artist = Artist::limit(15)->get();
        return $Artist ;
    }

    public function admin_advertistment_banners()
    {
        $admin_advertistment_banners = AdminAdvertistmentBanners::first();
        return $admin_advertistment_banners ;
    }

    public function ThumbnailSetting(){

        $ThumbnailSetting = ThumbnailSetting::first();
        return $ThumbnailSetting ;
    }

    public function multiple_compress_image()
    {
        $multiple_compress_image = CompressImage::pluck('enable_multiple_compress_image')->first() ? CompressImage::pluck('enable_multiple_compress_image')->first() : 0;
        return $multiple_compress_image ;
    }

    public function Most_watched_videos_country() {
        $Most_watched_videos_country = [];
        if (!Auth::guest() && $this->HomeSetting->Recommendation == 1) {  
            $Most_watched_videos_country = RecentView::select(
                    'video_id', 'videos.*', DB::raw('COUNT(video_id) AS count')
                )
                ->join('videos', 'videos.id', '=', 'recent_views.video_id')
                ->where([
                    ['videos.status', '=', 1],
                    ['videos.draft', '=', 1],
                    ['videos.active', '=', 1],
                    ['recent_views.country_name', '=', $this->countryName]
                ])
                ->groupBy('video_id', 'videos.id', 'videos.title', 'videos.age_restrict')
                ->orderByRaw('count DESC');
            if ($this->getfeching != null && $this->getfeching->geofencing == 'ON') {
                $Most_watched_videos_country->whereNotIn(DB::raw('videos.id'), $this->blockVideos); 
            }
            if ($this->videos_expiry_date_status == 1) {
                $Most_watched_videos_country->where(function ($query) {
                    $query->whereNull('videos.expiry_date')
                          ->orWhere('videos.expiry_date', '>=', Carbon::now()->format('Y-m-d\TH:i'));
                });
            }
            if ($this->check_Kidmode == 1) {
                $Most_watched_videos_country->whereBetween('videos.age_restrict', [0, 12]);
            }
            $Most_watched_videos_country = $Most_watched_videos_country->paginate($this->settings->videos_per_page ?? 10);
        }
        return $Most_watched_videos_country;
    }

    public function Most_watched_videos_users()
    {
        $userWatchedVideos = [];

        if (!Auth::guest() && $this->HomeSetting->Recommendation = 1 ) {
            
            $userWatchedVideos = RecentView::select('video_id', 'videos.*', DB::raw('COUNT(video_id) AS count'))
                ->join('videos', 'videos.id', '=', 'recent_views.video_id')
                ->where([
                    ['videos.status', '=', 1],
                    ['videos.draft', '=', 1],
                    ['videos.active', '=', 1]
                ])
                ->groupBy('video_id');
            
            if ($this->multiuser_CheckExists != null) {
                $userWatchedVideos->where('recent_views.sub_user', $this->multiuser_CheckExists);
            } else {
                $userWatchedVideos->where('recent_views.user_id', Auth::user()->id);
            }

            if ($this->getfeching != null && $this->getfeching->geofencing == 'ON') {
                $userWatchedVideos->whereNotIn('videos.id', $this->blockVideos);
            }

            if ($this->videos_expiry_date_status == 1) {
                $userWatchedVideos->where(function($query) {
                    $query->whereNull('videos.expiry_date')->orWhere('videos.expiry_date', '>=', Carbon::now()->format('Y-m-d\TH:i'));
                });
            }

            if ($this->check_Kidmode == 1) {
                $userWatchedVideos->whereBetween('videos.age_restrict', [0, 12]);
            }
            
            $userWatchedVideos = $userWatchedVideos->orderByRaw('count DESC')->get();
        }
        
        return $userWatchedVideos;
    }

    public function Most_watched_videos_site()
    {
        $Most_watched_videos_site = [];

        if (!Auth::guest() && $this->HomeSetting->Recommendation = 1 ) {

            $Most_watched_videos_site = RecentView::select('video_id', 'videos.*', DB::raw('COUNT(video_id) AS count'))->join('videos', 'videos.id', '=', 'recent_views.video_id')
                            ->where('videos.status', '=', '1')
                            ->where('videos.draft', '=', '1')
                            ->where('videos.active', '=', '1')
                            ->groupBy('video_id');

                            if ($this->getfeching != null && $this->getfeching->geofencing == 'ON') {
                                $Most_watched_videos_site->whereNotIn('videos.id', $this->blockVideos);
                            }
                
                            if ($this->videos_expiry_date_status == 1) {
                                $Most_watched_videos_site->where(function($query) {
                                    $query->whereNull('videos.expiry_date')->orWhere('videos.expiry_date', '>=', Carbon::now()->format('Y-m-d\TH:i'));
                                });
                            }
                
                            if ($this->check_Kidmode == 1) {
                                $Most_watched_videos_site->whereBetween('videos.age_restrict', [0, 12]);
                            }
                        
            $Most_watched_videos_site = $Most_watched_videos_site->orderByRaw('count DESC')
                            
                            ->get();
        }

        return $Most_watched_videos_site ;

    }

    public function preference_genres()
    {
        $preference_genres_query = [];

        if (!Auth::guest() && $this->HomeSetting->Recommendation = 1 ) {

            $preference_genres = User::where('id', Auth::user()->id)->pluck('preference_genres')->first();

            $videoGenres = json_decode($preference_genres);

            if (!is_null($videoGenres)) {

                $preference_genres_query = Video::join('categoryvideos', 'categoryvideos.video_id', '=', 'videos.id')
                ->where([
                    ['videos.status', 1],
                    ['videos.draft', 1],
                    ['videos.active', 1]
                ])
                ->whereIn('categoryvideos.category_id', $videoGenres)
                ->groupBy('categoryvideos.video_id');
    
                if ($this->getfeching != null && $this->getfeching->geofencing == 'ON') {
                    $preference_genres_query->whereNotIn('videos.id', $this->blockVideos);
                }
    
                if ($this->videos_expiry_date_status == 1) {
                    $preference_genres_query->where(function($query) {
                        $query->whereNull('videos.expiry_date')->orWhere('videos.expiry_date', '>=', Carbon::now()->format('Y-m-d\TH:i'));
                    });
                }
    
                if ($this->check_Kidmode == 1) {
                    $preference_genres_query->whereBetween('videos.age_restrict', [0, 12]);
                }
            
                $preference_genres_query = $preference_genres_query->get();
            }
        }
        return $preference_genres_query;
    }

    public function preference_language()
    {
        $preference_language_query = [];

        if (!Auth::guest() && $this->HomeSetting->Recommendation = 1 ) {

            $preference_language = User::where('id', Auth::user()->id)->pluck('preference_language')->first();

            $language = json_decode($preference_language);

            if (!is_null($language)) {
            
                $preference_language_query = Video::Select('videos.id','videos.title','videos.slug','videos.year','videos.rating','videos.access','videos.publish_type','videos.global_ppv','videos.publish_time','videos.publish_status','videos.ppv_price',
                                                            'duration','videos.rating','videos.image','videos.featured','videos.age_restrict','videos.video_tv_image','videos.player_image','videos.details','videos.description','videos.uploaded_by','videos.user_id'
                                                            ,'languagevideos.*','videos.id as pre_video_id')
                                                            ->join('languagevideos', 'languagevideos.video_id', '=', 'videos.id')
                                                            ->whereIn('language_id', $language)
                                                            ->where('videos.status', 1)
                                                            ->where('videos.draft', 1)
                                                            ->where('videos.active', 1)
                                                            ->groupBy('languagevideos.video_id');

                                        if ($this->getfeching != null && $this->getfeching->geofencing == 'ON') {
                                            $preference_language_query->whereNotIn('videos.id', $this->blockVideos);
                                        }
                            
                                        if ($this->videos_expiry_date_status == 1) {
                                            $preference_language_query->where(function($query) {
                                                $query->whereNull('videos.expiry_date')->orWhere('videos.expiry_date', '>=', Carbon::now()->format('Y-m-d\TH:i'));
                                            });
                                        }
                            
                                        if ($this->check_Kidmode == 1) {
                                            $preference_language_query->whereBetween('videos.age_restrict', [0, 12]);
                                        }

                $preference_language_query = $preference_language_query->get();
                    
            }
        }

        return $preference_language_query;
    }

    public function Video_Based_Category()
    {
        // Using the same properties as in the constructor
        $check_Kidmode = $this->check_Kidmode;
        $videos_expiry_date_status = $this->videos_expiry_date_status;
        $getfeching = $this->getfeching;

        $categories = VideoCategory::query()
            
            ->whereHas('category_videos', function ($query) use ($check_Kidmode, $videos_expiry_date_status, $getfeching) {
                $query->where('videos.active', 1)
                    ->where('videos.status', 1)
                    ->where('videos.draft', 1);

                if ($getfeching != null && $getfeching->geofencing == 'ON') {
                    $query->whereNotIn('videos.id', $this->blockVideos);
                }

                if ($videos_expiry_date_status == 1) {
                    $query->whereNull('expiry_date')
                        ->orWhere('expiry_date', '>=', Carbon::now()->format('Y-m-d\TH:i'));
                }

                if ($check_Kidmode == 1) {
                    $query->whereBetween('videos.age_restrict', [0, 12]);
                }
            })
            ->with(['category_videos' => function ($videos) use ($check_Kidmode, $videos_expiry_date_status, $getfeching) {
                $videos->select('videos.id', 'title', 'slug', 'year', 'rating', 'access', 'publish_type', 'global_ppv', 'publish_time', 'ppv_price', 'duration', 'rating', 'image', 'featured', 'age_restrict', 'player_image', 'description', 'videos.trailer', 'videos.trailer_type', 'videos.expiry_date', 'responsive_image', 'responsive_player_image', 'responsive_tv_image')
                    ->where('videos.active', 1)
                    ->where('videos.status', 1)
                    ->where('videos.draft', 1);

                if ($getfeching != null && $getfeching->geofencing == 'ON') {
                    $videos->whereNotIn('videos.id', $this->blockVideos);
                }

                if ($videos_expiry_date_status == 1) {
                    $videos->whereNull('expiry_date')
                        ->orWhere('expiry_date', '>=', Carbon::now()->format('Y-m-d\TH:i'));
                }

                if ($check_Kidmode == 1) {
                    $videos->whereBetween('videos.age_restrict', [0, 12]);
                }

                $videos->latest('videos.created_at')->get();
            }])
            ->select('video_categories.id', 'video_categories.name', 'video_categories.slug', 'video_categories.in_home', 'video_categories.order')
            ->where('video_categories.in_home', 1)
            ->whereHas('category_videos', function ($query) use ($check_Kidmode, $videos_expiry_date_status, $getfeching) {
                $query->where('videos.active', 1)
                    ->where('videos.status', 1)
                    ->where('videos.draft', 1);

                if ($getfeching != null && $getfeching->geofencing == 'ON') {
                    $query->whereNotIn('videos.id', $this->blockVideos);
                }

                if ($videos_expiry_date_status == 1) {
                    $query->whereNull('expiry_date')
                        ->orWhere('expiry_date', '>=', Carbon::now()->format('Y-m-d\TH:i'));
                }

                if ($check_Kidmode == 1) {
                    $query->whereBetween('videos.age_restrict', [0, 12]);
                }
            })
            ->orderBy('video_categories.order')
            ->get()
            ->map(function ($category) {
                $category->category_videos->map(function ($video) {
                    $video->image_url = $this->BaseURL.('s/images/' . $video->image);
                    $video->Player_image_url = $this->BaseURL.('s/images/' . $video->player_image);
                    return $video;
                });
                $category->source = "category_videos";
                return $category;
            });

        return $categories;
    }

    public function latestViewedVideos()
    {
        $check_Kidmode = $this->check_Kidmode;

        if (!Auth::guest()) {
            $data = RecentView::join('videos', 'videos.id', '=', 'recent_views.video_id')
                ->where('recent_views.user_id', Auth::user()->id)
                ->groupBy('recent_views.video_id');

            if ($this->getfeching != null && $this->getfeching->geofencing == 'ON') {
                $data = $data->whereNotIn('videos.id', $this->blockVideos);
            }

            if ($this->videos_expiry_date_status == 1) {
                $data = $data->whereNull('expiry_date')->orWhere('expiry_date', '>=', Carbon::now()->format('Y-m-d\TH:i'));
            }

            if ($check_Kidmode == 1) {
                $data = $data->whereNull('age_restrict')->orWhereNotBetween('age_restrict', [0, 12]);
            }

            $data = $data->get();

            return $data;
        } else {
            return collect(); // Return an empty collection if the user is not authenticated
        }
    }

    public function Epg(){

        $current_timezone = current_timezone();
        $carbon_now = Carbon::now($current_timezone);
        $carbon_current_time =  $carbon_now->format('H:i:s');
        $carbon_today =  $carbon_now->format('n-j-Y');
        $default_vertical_image_url = default_vertical_image_url() ;
        $default_horizontal_image_url = default_horizontal_image_url();

        $epg_data =  AdminEPGChannel::where('status',1)->get()->map(function ($item) use ($default_vertical_image_url ,$default_horizontal_image_url , $carbon_now , $carbon_today , $current_timezone) {
                    
                    $item['image_url'] = $item->image != null ? $this->BaseURL.('/EPG-Channel/'.$item->image ) : $default_vertical_image_url ;
                    $item['Player_image_url'] = $item->player_image != null ?  $this->BaseURL.('/EPG-Channel/'.$item->player_image ) : $default_horizontal_image_url;
                    $item['Logo_url'] = $item->logo != null ?  $this->BaseURL.('/EPG-Channel/'.$item->logo ) : $default_vertical_image_url;
                                                        
                    $item['ChannelVideoScheduler_current_video_details']  =  ChannelVideoScheduler::where('channe_id',$item->id)->where('choosed_date' , $carbon_today )
                                                                                ->get()->map(function ($item) use ($carbon_now , $current_timezone) {

                                                                                    $TimeZone   = TimeZone::where('id',$item->time_zone)->first();

                                                                                    $converted_start_time =Carbon::createFromFormat('m-d-Y H:i:s', $item->choosed_date . $item->start_time, $TimeZone->time_zone )
                                                                                                                                    ->copy()->tz( $current_timezone );

                                                                                    $converted_end_time =Carbon::createFromFormat('m-d-Y H:i:s', $item->choosed_date . $item->end_time, $TimeZone->time_zone )
                                                                                                                                    ->copy()->tz( $current_timezone );

                                                                                    if ($carbon_now->between($converted_start_time, $converted_end_time)) {
                                                                                        $item['video_image_url'] = $this->BaseURL.('/images/'.$item->image ) ;
                                                                                        $item['converted_start_time'] = $converted_start_time->format('h:i A');
                                                                                        $item['converted_end_time']   =   $converted_end_time->format('h:i A');
                                                                                        return $item ;
                                                                                    }

                                                                                })->filter()->first();


                    return $item;
        });
        return $epg_data;
    }

    public function Channel_Partner()
    {
        $Channel_Partner = Channel::where('status',1)->get();
        return $Channel_Partner ;
    }

    public function content_Partner()
    {
        $content_Partner = ModeratorsUser::where('status',1)->get();
        return $content_Partner ;
    }

    public function UGCVideos()
    {
        $ugcvideos = UGCVideo::where('active',1)
                    ->limit(15)
                    ->inRandomOrder()
                    ->get();
        return $ugcvideos ;
    }

    public function UGCShortsMinis()
    {
        $ugcshortsminis = UGCVideo::where('active',1)
        ->withCount([
            'likesDislikes as like_count' => function($query) {
                $query->where('liked', 1);
            }
        ])->latest()->get();
        return $ugcshortsminis ;
    }

    public function UGCUsers()
    {
        $users = User::has('ugcVideos')
            ->with(['ugcVideos' => function ($query) {
                $query->where('active', 1); // Load only active ugcVideos within the query
            }])
            ->limit(5)
            ->get();
         return $users;
    }

    public function watchLater() {
        if (!Auth::guest()) {
            $Watchlater_video = Watchlater::where('user_id', Auth::user()->id)->where('type', 'channel')->latest()->pluck('video_id')->toArray();
            $Watchlater_episode = Watchlater::where('user_id', Auth::user()->id)->where('type', 0)->pluck('episode_id');
            $Watchlater_live = Watchlater::where('user_id', Auth::user()->id)->where('type', 'live')->pluck('live_id');
            $check_Kidmode = 0;
    
            // Ensure $data is always initialized
            $data = collect([]);
    
            if (!empty($Watchlater_video)) {
                $ids = implode(',', array_filter($Watchlater_video));
                $data = Video::select('id', 'title', 'slug', 'year', 'rating', 'access', 'publish_type', 'global_ppv', 'publish_time', 'ppv_price',
                                        'duration', 'rating', 'image', 'featured', 'age_restrict', 'video_tv_image', 'player_image', 'details', 'description',
                                        'expiry_date', 'active', 'status', 'draft')
                            ->where('active', 1)
                            ->where('status', 1)
                            ->whereIn('id', $Watchlater_video);
    
                if (Geofencing() != null && Geofencing()->geofencing == 'ON') {
                    $data = $data->whereNotIn('videos.id', Block_videos());
                }
    
                if (!Auth::guest() && $check_Kidmode == 1) {
                    $data = $data->whereNull('age_restrict')->orWhereNotBetween('age_restrict', [0, 12]);
                }
    
                if (!empty($ids)) {
                    $data = $data->orderByRaw("FIELD(id, $ids)");
                }
    
                $data = $data->limit(30)->get()->map(function ($item) {
                    $item['image_url'] = $item->image != null ? $this->BaseURL . ('s/images/' . $item->image) : default_vertical_image_url();
                    $item['Player_image_url'] = $item->player_image != null ? $this->BaseURL . ('/images/' . $item->player_image) : default_horizontal_image_url();
                    $item['TV_image_url'] = $item->video_tv_image != null ? $this->BaseURL . ('/images/' . $item->video_tv_image) : default_horizontal_image_url();
                    $item['source_type'] = "Videos";
                    return $item;
                });
            }
    
            // Process episodes
            $episode_data = collect([]);
    
            if (!empty($Watchlater_episode)) {
                $episode_data = Episode::select('id', 'title', 'slug', 'rating', 'access', 'series_id', 'season_id', 'ppv_price', 'responsive_image', 'responsive_player_image', 'responsive_tv_image', 'episode_description',
                                                'duration', 'rating', 'image', 'featured', 'tv_image', 'player_image', 'uploaded_by', 'user_id')
                                    ->where('active', '1')
                                    ->where('status', '1')
                                    ->whereIn('id', $Watchlater_episode);
    
                if (!Auth::guest() && $check_Kidmode == 1) {
                    $episode_data = $episode_data->whereNull('age_restrict')->orWhereNotBetween('age_restrict', [0, 12]);
                }
    
                $episode_data = $episode_data->latest()->get()->map(function ($item) {
                    $item['series'] = Series::select('id', 'slug')->where('id', $item->series_id)->first(); // Select only necessary fields
                    return $item;
                });
            }
    
            // Process livestreams
            $livestreams_data = LiveStream::select('id', 'title', 'slug', 'year', 'rating', 'access', 'publish_type', 'publish_time', 'publish_status', 'ppv_price',
                                                    'duration', 'rating', 'image', 'featured', 'Tv_live_image', 'player_image', 'details', 'description', 'free_duration',
                                                    'recurring_program', 'program_start_time', 'program_end_time', 'custom_start_program_time', 'custom_end_program_time',
                                                    'recurring_timezone', 'recurring_program_week_day', 'recurring_program_month_day')
                                            ->where('active', '1')
                                            ->where('status', 1)
                                            ->whereIn('id', $Watchlater_live);
    
            if (!Auth::guest() && $check_Kidmode == 1) {
                $livestreams_data = $livestreams_data->whereNull('age_restrict')->orWhereNotBetween('age_restrict', [0, 12]);
            }
    
            $livestreams_data = $livestreams_data->latest()->limit(30)->get()->map(function ($item) {
                $item['image_url'] = $item->image != null ? $this->BaseURL . ('s/images/' . $item->image) : default_vertical_image_url();
                $item['Player_image_url'] = $item->player_image != null ? $this->BaseURL . ('s/images/' . $item->player_image) : default_horizontal_image_url();
                $item['tv_image_url'] = $item->video_tv_image != null ? $this->BaseURL . ('s/images/' . $item->Tv_live_image) : default_horizontal_image_url();
                $item['source'] = "Livestream";
                return $item;
            });
    
        } else {
            $data = collect([]);
            $episode_data = collect([]);
            $livestreams_data = collect([]);
        }
    
        return [
            'videos' => collect($data),
            'episodes' => collect($episode_data),
            'livestream' => collect($livestreams_data)
        ];
    }

    public function wishlist() {
        if (!Auth::guest()) {
            $Wishlist_video = Wishlist::where('user_id', Auth::user()->id)->where('type', 'channel')->latest()->pluck('video_id')->toArray();
            $Wishlist_episode = Wishlist::where('user_id', Auth::user()->id)->where('type', 0)->latest()->pluck('episode_id')->toArray();
    
            $check_Kidmode = 0;
            
            // Ensure $data is always initialized
            $data = collect([]);
    
            if (!empty($Wishlist_video)) {
                $ids = implode(',', array_filter($Wishlist_video));
                $data = Video::select('id', 'title', 'slug', 'year', 'rating', 'access', 'publish_type', 'global_ppv', 'publish_time', 'ppv_price',
                                        'rating', 'image', 'featured', 'age_restrict', 'video_tv_image', 'player_image', 'details', 'description',
                                        'expiry_date', 'active', 'status', 'draft')
                            ->where('active', 1)
                            ->where('status', 1)
                            ->whereIn('id', $Wishlist_video);
    
                if (Geofencing() != null && Geofencing()->geofencing == 'ON') {
                    $data = $data->whereNotIn('videos.id', Block_videos());
                }
    
                if (!Auth::guest() && $check_Kidmode == 1) {
                    $data = $data->whereNull('age_restrict')->orWhereNotBetween('age_restrict', [0, 12]);
                }
    
                if (!empty($ids)) {
                    $data = $data->orderByRaw("FIELD(id, $ids)");
                }
    
                $data = $data->latest()->limit(30)->get()->map(function ($item) {
                    $item['image_url'] = $item->image != null ? $this->BaseURL . ('s/images/' . $item->image) : default_vertical_image_url();
                    $item['Player_image_url'] = $item->player_image != null ? $this->BaseURL . ('/images/' . $item->player_image) : default_horizontal_image_url();
                    $item['TV_image_url'] = $item->video_tv_image != null ? $this->BaseURL . ('/images/' . $item->video_tv_image) : default_horizontal_image_url();
                    $item['source_type'] = "Videos";
                    return $item;
                });
            }
    
            // Ensure $episode_data is always initialized
            $episode_data = collect([]);
    
            if (!empty($Wishlist_episode)) {
                $episode_data = Episode::select('id', 'title', 'slug', 'rating', 'access', 'series_id', 'season_id', 'ppv_price', 'responsive_image', 'responsive_player_image', 'responsive_tv_image', 'episode_description',
                                                'duration', 'rating', 'image', 'featured', 'tv_image', 'player_image', 'uploaded_by', 'user_id')
                                    ->where('active', '1')
                                    ->where('status', '1')
                                    ->whereIn('id', $Wishlist_episode);
    
                if (!Auth::guest() && $check_Kidmode == 1) {
                    $episode_data = $episode_data->whereNull('age_restrict')->orWhereNotBetween('age_restrict', [0, 12]);
                }
    
                $episode_data = $episode_data->latest()->get()->map(function ($item) {
                    $item['series'] = Series::select('id', 'slug')->where('id', $item->series_id)->first(); // Select only necessary fields
                    return $item;
                });
            }
        } else {
            $data = collect([]);
            $episode_data = collect([]);
        }
    
        return [
            'videos' => collect($data),
            'episodes' => collect($episode_data),
        ];
    } 

    public function latestViewedEpisode() {
        if (Auth::guest() != true) {
            $data = RecentView::Select('episodes.*', 'episodes.slug as episode_slug', 'series.id', 'series.slug as series_slug', 'recent_views.episode_id', 'recent_views.user_id')
                ->join('episodes', 'episodes.id', '=', 'recent_views.episode_id')
                ->join('series', 'series.id', '=', 'episodes.series_id')
                ->where('recent_views.user_id', Auth::user()->id)
                ->groupBy('recent_views.episode_id')
                ->get();
        } else {
            $data = [];
        }
        return $data;
    }

    public function latestViewedAudio() {
        if(Auth::guest() != true ){

            $data =  RecentView::join('audio', 'audio.id', '=', 'recent_views.audio_id')
                ->where('recent_views.user_id',Auth::user()->id)
                ->groupBy('recent_views.audio_id');
    
                if(Geofencing() !=null && Geofencing()->geofencing == 'ON'){
                    $data = $data  ->whereNotIn('audio.id',Block_audios());
                }
                $data = $data->limit(15)->get();
       }
       else
       {
            $data = array() ;
       }
       return $data;
    }

    public function latestViewedLive() {
        if(Auth::guest() != true ){
            $data =  RecentView::join('live_streams', 'live_streams.id', '=', 'recent_views.live_id')
                    ->where('recent_views.user_id',Auth::user()->id)
                    ->groupBy('recent_views.live_id')
                    ->limit(15)
                    ->get();
        }
        else
        {
            $data = array() ;
        }
        return $data;
    }

    public function latestViewedVideo(){
        $check_Kidmode = 0 ;

        if(Auth::guest() != true ){

            $data =  RecentView::join('videos', 'videos.id', '=', 'recent_views.video_id')
                ->where('recent_views.user_id',Auth::user()->id)
                ->groupBy('recent_views.video_id');

                if(Geofencing() !=null && Geofencing()->geofencing == 'ON'){
                    $data = $data  ->whereNotIn('videos.id',Block_videos());
                }
                
                // if( $videos_expiry_date_status == 1 ){
                //     $data = $data->whereNull('expiry_date')->orwhere('expiry_date', '>=', Carbon\Carbon::now()->format('Y-m-d\TH:i') );
                // }

                if( !Auth::guest() && $check_Kidmode == 1 )
                {
                    $data = $data->whereNull('age_restrict')->orwhereNotBetween('age_restrict',  [ 0, 12 ] );
                }
                
                $data = $data->limit(15)->get();
        }
        else
        {
            $data = array() ;
        }
        return $data;
    }

    public function VideoJsContinueWatching(){

        $cnt_watching_videos = [];

        if(!Auth::guest()){
            $video_cnt = ContinueWatching::where('user_id', Auth::user()->id)
                                            ->pluck('videoid')
                                            ->toArray();

            $cnt_watching_videos = Video::select('id', 'title', 'slug', 'year', 'rating', 'access', 'publish_type', 'global_ppv', 'publish_time', 'publish_status', 'ppv_price', 'responsive_image', 'responsive_player_image', 'responsive_tv_image',
                                                'duration', 'rating', 'image', 'featured', 'age_restrict', 'video_tv_image', 'player_image', 'details', 'description')
                                        ->with('cnt_watch')
                                        ->where('active', '1')
                                        ->where('status', '1')
                                        ->where('draft', '1')
                                        ->where('type', '!=', 'embed')
                                        ->whereIn('id', $video_cnt)
                                        ->latest()
                                        ->get();

        }

        return $cnt_watching_videos;

    }

    public function VideoJsEpisodeContinueWatching(){

        $cnt_watching_episode = [];
        
        if(!Auth::guest()){
            $episode_cnt = ContinueWatching::where('user_id', Auth::user()->id)
                                            ->pluck('episodeid')
                                            ->toArray();

            $cnt_watching_episode = Episode::select('id','title','slug','rating','access','series_id','season_id','ppv_price','responsive_image','responsive_player_image','responsive_tv_image','episode_description',
                                                    'duration','rating','image','featured','tv_image','player_image','uploaded_by','user_id')
                                        ->where('active', '1')
                                        ->where('status', '1')
                                        ->where('type', '!=', 'embed')
                                        ->whereIn('id', $episode_cnt)
                                        ->latest()
                                        ->get()->map(function($item){
                                            $item['series'] = Series::select('id', 'slug')->where('id', $item->series_id)->first(); // Select only the necessary fields
                                            return $item;
                                        });

        }

        return $cnt_watching_episode;

    }

    public function TopTenVideos(){
        $top_ten_videos = Video::select('id','title','slug','year','rating','access','publish_type','global_ppv','publish_time','ppv_price', 'duration','rating','image','featured','age_restrict','video_tv_image','description',
                                        'player_image','expiry_date','responsive_image','responsive_player_image','responsive_tv_image','uploaded_by','user_id')
                                ->orderBy('views', 'desc')
                                ->limit(10)
                                ->get();

        return $top_ten_videos;
    }

    public function RadioStation()
    {
        $radiostations = LiveStream::where('stream_upload_via','radio_station')->limit(15)->get();
        return $radiostations ;
    }

    // public function continueWatching(){
    //     if ($multiuser != null)
    //     {
    //         $getcnt_watching = ContinueWatching::where('multiuser', $multiuser)->pluck('videoid')->toArray();
            
    //         $cnt_watching = Video::select('id','title','slug','year','rating','access','publish_type','global_ppv','publish_time','publish_status','ppv_price','responsive_image','responsive_player_image','responsive_tv_image',
    //                                 'duration','rating','image','featured','age_restrict','video_tv_image','player_image','details','description')->with('cnt_watch')
    //                                 ->where('active', '1')->where('status', '1')
    //                                 ->where('draft', '1')->where('type','!=','embed')
    //                                 ->whereIn('id', $getcnt_watching)
    //                                 ->limit(15)->get();
    //     }
    //     elseif (!Auth::guest())
    //     {

    //         $continue_watching = ContinueWatching::where('user_id', Auth::user()->id)->first();

    //         if ($continue_watching != null && $continue_watching->multiuser == null)
    //         {
    //             $getcnt_watching = ContinueWatching::where('user_id', Auth::user()->id)->pluck('videoid')->toArray();

    //             $cnt_watching = Video::select('id','title','slug','year','rating','access','publish_type','global_ppv','publish_time','publish_status','ppv_price','responsive_image','responsive_player_image','responsive_tv_image',
    //             'duration','rating','image','featured','age_restrict','video_tv_image','player_image','details','description')->with('cnt_watch')->where('active', '=', '1')->where('status', '=', '1')
    //             ->where('draft', '1')->where('type','!=','embed')->whereIn('id', $getcnt_watching);
    //             if ($getfeching != null && $getfeching->geofencing == 'ON')
    //             {
    //                 $cnt_watching = $cnt_watching->whereNotIn('id', $blockvideos);
    //             }
    //             $cnt_watching = $cnt_watching->limit(15)->get();
    //         }
    //         else
    //         {
    //             $getcnt_watching = ContinueWatching::where('user_id', Auth::user()->id)
    //                 ->where('multiuser', 'data')
    //                 ->pluck('videoid')
    //                 ->toArray();

    //             $cnt_watching = Video::select('id','title','slug','year','rating','access','publish_type','global_ppv','publish_time','publish_status','ppv_price','responsive_image','responsive_player_image','responsive_tv_image',
    //             'duration','rating','image','featured','age_restrict','video_tv_image','player_image','details','description')->with('cnt_watch')->where('active', '=', '1')->where('status', '=', '1')
    //             ->where('draft', '=', '1')->where('type','!=','embed')->whereIn('id', $getcnt_watching);

    //             if ($getfeching != null && $getfeching->geofencing == 'ON')
    //             {
    //                 $cnt_watching = $cnt_watching->whereNotIn('id', $blockvideos);
    //             }
    //             $cnt_watching = $cnt_watching->limit(15)->get();
    //         }

    //     }
    //     else
    //     {
    //         $cnt_watching = '';
    //     }

    //     return $cnt_watching;
    // }


    public function getSeriesEpisodeImg(Request $request)
    {
        $seriesId = $request->series_id;
        $image = Series::where('id', $seriesId)->pluck('player_image')->first();

        $image = (!is_null($image) && $image != 'default_image.jpg')
                        ? $this->BaseURL.('/images/' . $image)
                        : $this->default_vertical_image;

        $seasonIds = SeriesSeason::where('series_id', $seriesId)->pluck('id');

        $episodeImages = Episode::where('series_id', $seriesId)
                                    ->whereIn('season_id', $seasonIds)
                                    ->where('active', 1)
                                    ->orderBy('episode_order','desc')
                                    ->take(15)
                                    ->pluck('player_image') // Fetch only the player_image column
                                    ->map(function ($playerImage) {
                                        return (!is_null($playerImage) && $playerImage != 'default_horizontal_image.jpg') 
                                            ? $this->BaseURL . '/images/' . $playerImage 
                                            : $this->default_horizontal_image_url;
                                    });

        return response()->json([
            'series_image' => $image,
            'episode_images' => $episodeImages
        ]);
    }
    public function getLatestSeriesImg(Request $request)
    {
        $seriesId = $request->series_id;
        $image = Series::where('id', $seriesId)->pluck('player_image')->first();

        $image = (!is_null($image) && $image != 'default_image.jpg')
                        ? $this->BaseURL.('/images/' . $image)
                        : $this->default_vertical_image;

        $seasonIds = SeriesSeason::where('series_id', $seriesId)->pluck('id');

        $episodeImages = Episode::where('series_id', $seriesId)
                                    ->whereIn('season_id', $seasonIds)
                                    ->where('active', 1)
                                    ->orderBy('episode_order','desc')
                                    ->take(15)
                                    ->pluck('player_image') // Fetch only the player_image column
                                    ->map(function ($playerImage) {
                                        return (!is_null($playerImage) && $playerImage != 'default_horizontal_image.jpg') 
                                            ? $this->BaseURL . '/images/' . $playerImage 
                                            : $this->default_horizontal_image_url;
                                    });


            // dd($episodeImages);

        return response()->json([
            'series_image' => $image,
            'episode_images' => $episodeImages
        ]);
    }
    public function getnetworkSeriesImg(Request $request)
    {
        $networkId = $request->network_id;
        $image = SeriesNetwork::where('id', $networkId)->pluck('banner_image')->first();

        $image = (!is_null($image) && $image != 'default_image.jpg')
                        ? $this->BaseURL.('/seriesNetwork/' . $image)
                        : $this->default_vertical_image;

        $seriesImages = Series::where('network_id', 'LIKE', '%"'.$networkId.'"%')
                                    ->where('active', 1)
                                    ->latest()
                                    ->take(15)
                                    ->pluck('image')
                                    ->map(function ($Image) {
                                        return (!is_null($Image) && $Image != 'default_horizontal_image.jpg') 
                                            ? $this->BaseURL . '/images/' . $Image 
                                            : $this->default_horizontal_image_url;
                                    });


            // dd($episodeImages);

        return response()->json([
            'network_image' => $image,
            'series_images' => $seriesImages
        ]);
    }

    public function getModalEpisodeImg(Request $request)
    {
        $episodeId     = $request->episode_id;

        $episode = Episode::with('series')
                            ->select('id', 'series_id', 'title', 'slug', 'player_image', 'episode_description')
                            ->find($episodeId);
                            
        $description   = strip_tags(html_entity_decode($episode->episode_description));
        $slug          = URL::to('networks/episode/'.$episode->series->slug . '/' . $episode->slug);

        $image = (!is_null($episode->player_image) && $episode->player_image != 'default_image.jpg')
                        ? $this->BaseURL.('/images/' . $episode->player_image)
                        : $this->default_vertical_image;
            // dd($image);

        return response()->json([
            'image'       => $image,
            'title'       => $episode->title,
            'description' => $description,
            'slug'        => $slug
        ]);
    }

    public function getSeriesNetworkModalImg(Request $request)
    {
        $Id = $request->Series_id;

        $Series = Series::where('id',$Id)->select('id', 'title', 'slug', 'player_image', 'description')
                            ->first();
                            // dd($Series);

        $description   = strip_tags(html_entity_decode($Series->description));
        $slug          = URL::to('play_series/'.$Series->slug );

        $image = (!is_null($Series->player_image) && $Series->player_image != 'default_image.jpg')
                        ? $this->BaseURL.('/images/' . $Series->player_image)
                        : $this->default_vertical_image;
            // dd($image);

        return response()->json([
            'image'       => $image,
            'title'       => $Series->title,
            'description' => $description,
            'slug'        => $slug
        ]);
    }

    public function getLiveDropImg(Request $request)
    {
        $liveId = $request->live_id;
        // dd($liveId);
        $image = livestream::where('id', $liveId)->pluck('player_image')->first();

        $image = (!is_null($image) && $image != 'default_image.jpg')
                        ? $this->BaseURL.('/images/' . $image)
                        : $this->default_vertical_image;
            // dd($image);

        return response()->json([
            'live_images' => $image
        ]);
    }

    public function getLiveModal(Request $request)
    {
        $liveId = $request->live_id;
        // dd($liveId);
        $live       = livestream::where('id', $liveId)->select('player_image','title','description','slug')->first();
        $description =  !empty($live->description) ? strip_tags(html_entity_decode($live->description)) : '';
        $slug          = URL::to('live/'.$live->slug);

        $image = (!is_null($live->player_image) && $live->player_image != 'default_image.jpg')
                        ? $this->BaseURL.('/images/' . $live->player_image)
                        : $this->default_vertical_image;
            // dd($image);

        return response()->json([
            'image'       => $image,
            'title'       => $live->title,
            'description' => $description,
            'slug'        => $slug
        ]);
    }

    
}
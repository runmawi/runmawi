<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL; 
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Auth;
use App\AdminAdvertistmentBanners;
use App\LiveEventArtist;
use App\CompressImage;
use App\HomeSetting;
use App\VideoCategory;
use App\AudioAlbums;
use App\SeriesNetwork;
use App\ThumbnailSetting;
use App\AudioCategory;
use App\LiveCategory;
use App\VideoSchedules;
use App\SeriesGenre;
use App\Geofencing;
use App\LiveStream;
use App\Setting;
use App\Episode;
use App\Video;
use App\Series;
use App\Artist;
use App\Audio;
use App\TimeZone;
use App\Slider;
use Carbon\Carbon;
use Theme;

class FrontEndQueryController extends Controller
{
    public function __construct()
    {
        $this->settings = Setting::first();
        $this->videos_per_page = $this->settings->videos_per_page;

        $this->HomeSetting = HomeSetting::first();
        Theme::uses($this->HomeSetting->theme_choosen);

        $Recomended = $this->HomeSetting;

        $this->getfeching = Geofencing::first();
        $this->videos_expiry_date_status = videos_expiry_date_status();
        $this->check_Kidmode = 1 ;

        $this->default_vertical_image_url = default_vertical_image_url();
        $this->default_horizontal_image_url = default_horizontal_image_url();
        $this->current_timezone = current_timezone();
    }

    public function Latest_videos()
    {
        $latest_videos = Video::select('id','title','slug','year','rating','access','publish_type','global_ppv','publish_time','ppv_price', 'duration','rating','image','featured','age_restrict','video_tv_image','description',
                                        'player_image','expiry_date','responsive_image','responsive_player_image','responsive_tv_image')

                                ->where('active',1)->where('status', 1)->where('draft',1);

                                if( $this->getfeching !=null && $this->getfeching->geofencing == 'ON'){
                                    $latest_videos = $latest_videos->whereNotIn('videos.id',Block_videos());
                                }

                                if ($this->videos_expiry_date_status == 1 ) {
                                    $latest_videos = $latest_videos->whereNull('expiry_date')->orwhere('expiry_date', '>=', Carbon::now()->format('Y-m-d\TH:i') );
                                }
                                
                                if ($this->check_Kidmode == 1) {
                                    $latest_videos = $latest_videos->whereBetween('videos.age_restrict', [0, 12]);
                                }

        $latest_videos = $latest_videos->latest()->limit(15)->get();

        return $latest_videos ;
    }

    public function trending_videos()
    {
        $trending_videos = Video::select('id','title','slug','year','rating','access','publish_type','global_ppv','publish_time','ppv_price', 'duration','rating','image','featured','age_restrict','video_tv_image','description',
            'player_image','expiry_date','responsive_image','responsive_player_image','responsive_tv_image')

        ->where('active',1)->where('status', 1)->where('draft',1)->where('views', '>', '5');

        if( $this->getfeching !=null && $this->getfeching->geofencing == 'ON'){
            $trending_videos = $trending_videos->whereNotIn('videos.id',Block_videos());
        }

        if ($this->videos_expiry_date_status == 1 ) {
            $trending_videos = $trending_videos->whereNull('expiry_date')->orwhere('expiry_date', '>=', Carbon\Carbon::now()->format('Y-m-d\TH:i') );
        }
        
        if ($this->check_Kidmode == 1) {
            $trending_videos = $trending_videos->whereBetween('videos.age_restrict', [0, 12]);
        }

        $trending_videos = $trending_videos->latest()->limit(15)->get();

        return $trending_videos;

    }

    public function featured_videos()
    {
        $featured_videos = Video::select('id','title','slug','year','rating','access','publish_type','global_ppv','publish_time','ppv_price', 'duration','rating','image','featured','age_restrict','video_tv_image','description',
                                        'player_image','expiry_date','responsive_image','responsive_player_image','responsive_tv_image')

                                    ->where('active',1)->where('status', 1)->where('draft',1)->where('featured', '1');

                                    if( $this->getfeching !=null && $this->getfeching->geofencing == 'ON'){
                                        $featured_videos = $featured_videos->whereNotIn('videos.id',Block_videos());
                                    }

                                    if ($this->videos_expiry_date_status == 1 ) {
                                        $featured_videos = $featured_videos->whereNull('expiry_date')->orwhere('expiry_date', '>=', Carbon\Carbon::now()->format('Y-m-d\TH:i') );
                                    }
                                    
                                    if ($this->check_Kidmode == 1) {
                                        $featured_videos = $featured_videos->whereBetween('videos.age_restrict', [0, 12]);
                                    }

                                $featured_videos = $featured_videos->latest()->limit(15)->get();

        return $featured_videos;
    }

    public function VideoSchedules()
    {
        $VideoSchedules  = VideoSchedules::where('in_home',1)->limit(15)->get();

        return $VideoSchedules ;
    }
    
    public function genre_video_display()
    {
        $genre_video_display = VideoCategory::where('in_home',1)->orderBy('order','ASC')->limit(15)->get();

        return $genre_video_display ;
    }

    public function SeriesGenre()
    {
        $SeriesGenre =  SeriesGenre::orderBy('order','ASC')->limit(15)->get();
        return $SeriesGenre ;
    }

    public function latest_Series()
    {
        $latest_series = Series::select('id','title','slug','year','rating','access','duration','rating','image','featured','tv_image','player_image','details','description')
            ->where('active', '1')->latest()->limit(15)
            ->get();

        return $latest_series ;
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
        ->limit(15)
        ->get();

        $Series_based_on_category->each(function ($category) {
            $category->category_series->transform(function ($item) {

                $item['image_url']        = !is_null($item->image)  ? URL::to('public/uploads/images/'.$item->image) : $this->default_vertical_image_url ;
                $item['Player_image_url'] = !is_null($item->player_image)  ? URL::to('public/uploads/images/'.$item->player_image ) : $this->default_horizontal_image_url ;

                $item['upload_on'] =  Carbon::parse($item->created_at)->isoFormat('MMMM Do YYYY'); 

                $item['duration_format'] =  !is_null($item->duration) ?  Carbon::parse( $item->duration)->format('G\H i\M'): null ;

                $item['Series_depends_episodes'] = Series::find($item->id)->Series_depends_episodes
                                                        ->map(function ($item) {
                                                            $item['image_url']  = !is_null($item->image) ? URL::to('public/uploads/images/'.$item->image) : $this->default_vertical_image_url ;
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
        $Series_based_on_Networks = SeriesNetwork::where('in_home', 1)->orderBy('order')->limit(15)->get()->map(function ($item) {

            $item['Series_depends_Networks'] = Series::where('series.active', 1)
                        ->whereJsonContains('network_id', [(string)$item->id])
        
                        ->latest('series.created_at')->limit(15)->get()->map(function ($item) { 
                
                $item['image_url']        = (!is_null($item->image) && $item->image != 'default_image.jpg')  ? URL::to('public/uploads/images/'.$item->image) : $this->default_vertical_image ;
                $item['Player_image_url'] = (!is_null($item->player_image) && $item->player_image != 'default_image.jpg')  ? URL::to('public/uploads/images/'.$item->player_image )  :  $this->default_horizontal_image_url ;
        
                $item['upload_on'] = Carbon::parse($item->created_at)->isoFormat('MMMM Do YYYY'); 
        
                $item['duration_format'] =  !is_null($item->duration) ?  Carbon::parse( $item->duration)->format('G\H i\M'): null ;
        
                $item['Series_depends_episodes'] = Series::find($item->id)->Series_depends_episodes
                                                        ->map(function ($item) {
                                                        $item['image_url']  = (!is_null($item->image) && $item->image != 'default_image.jpg') ? URL::to('public/uploads/images/'.$item->image) : $this->default_vertical_image ;
                                                        return $item;
                                                    });
        
                $item['source'] = 'Series';
                return $item;
                                                                    
            });
            return $item;
        });
    }

    public function latest_episodes()
    {
        $latest_episode = Episode::select('id','title','slug','rating','access','series_id','season_id','ppv_price','responsive_image','responsive_player_image','responsive_tv_image',
                'duration','rating','image','featured','tv_image','player_image')
                ->where('active', '1')->latest()->limit(15)
                ->get()->map(function($item){
                    $item['series'] = Series::where('id',$item->series_id)->first();
                    return $item ;
                });

        return $latest_episode;
    }

    public function featured_episodes(){

        $featured_episodes = Episode::select('id','title','slug','rating','access','series_id','season_id','ppv_price','responsive_image','responsive_player_image','responsive_tv_image',
                                                 'duration','rating','image','featured','tv_image','player_image')
                                            ->where('active', 1)->where('featured' ,1)
                                            ->latest()->limit(15)
                                            ->get();

        return $featured_episodes;
    }
    
    public function livestreams()
    {
        $current_timezone = current_timezone();

        $livestreams = LiveStream::select('id', 'title', 'slug', 'year', 'rating', 'access', 'publish_type', 'publish_time', 'publish_status', 'ppv_price',
                                            'duration', 'rating', 'image', 'featured', 'Tv_live_image', 'player_image', 'details', 'description', 'free_duration',
                                            'recurring_program', 'program_start_time', 'program_end_time', 'custom_start_program_time', 'custom_end_program_time',
                                            'recurring_timezone', 'recurring_program_week_day', 'recurring_program_month_day')
                                        ->where('active', '1')
                                        ->where('status', 1)
                                        ->latest()
                                        ->limit(15)
                                        ->get();
    
        $livestreams = $livestreams->filter(function ($livestream) use ($current_timezone) {
            if ($livestream->publish_type === 'recurring_program') {
        
                $Current_time = Carbon::now($current_timezone);
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
    }

    public function LiveCategory()
    {
        $LiveCategory = LiveCategory::orderBy('order','ASC')->limit(15)->get();

        return $LiveCategory ;
    }

    public function LiveEventArtist()
    {
        $LiveEventArtist = LiveEventArtist::where("active",1)->where('status',1)->latest()->get();

        return $LiveEventArtist ;
    }

    public function live_event_banners()
    {
        $LiveEventArtist = LiveEventArtist::where('active', 1)->where('status',1)->where('banner', 1)->latest()->limit(15)->get();
        
        return $LiveEventArtist ;
    }

    public function sliders()
    {
        $sliders  = Slider::where('active', '1') ->orderBy('order_position', 'ASC')->limit(15)->get() ;
        return $sliders;
    }

    public function Episode_sliders()
    {
        $Episode = Episode::where('active', '1')->where('status', '1')->where('banner', '1')->latest()->limit(15)->get();
       
        return $Episode ;
    }

    public function series_sliders()
    {
        $series_sliders = Series::select('id','title','slug','year','rating','access',
                                            'duration','rating','image','featured','tv_image','player_image','details','description')
                                            ->where('active', '1')->where('banner','1')
                                            ->latest()->limit(15)
                                            ->get() ;
        $series_sliders ; 
    }

    public function live_banners()
    {
        $live_banners = LiveStream::select('id','title','slug','year','rating','access','publish_type','publish_time','publish_status','ppv_price',
                                            'duration','rating','image','featured','Tv_live_image','player_image','details','description','free_duration')
                                            ->where('active', '1')
                                            ->where('banner', '1')
                                            ->latest()->limit(15)
                                            ->get() ;
        return $live_banners ;
    }
 
    public function video_banners()
    {
        $video_banner = Video::where('banner', 1)->where('active', 1)->where('status', 1)->where('draft', 1);
    
        if ($this->getfeching != null && $this->getfeching->geofencing == 'ON') {
            $video_banner = $video_banner->whereNotIn('videos.id', Block_videos());
        }
    
        if ($this->check_Kidmode == 1) {
            $video_banner = $video_banner->whereBetween('videos.age_restrict', [0, 12]);
        }
    
        if ($this->videos_expiry_date_status == 1) {
            $video_banner = $video_banner->where(function ($query) {
                $query->whereNull('expiry_date')->orWhere('expiry_date', '>=', now()->format('Y-m-d\TH:i'));
            });
        }
    
        $video_banner = $video_banner->latest()->limit(15)->get();

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
                                    $VideoCategory_banner = $VideoCategory_banner->whereNotIn('videos.id', Block_videos());
                                }
    
                                if ($this->check_Kidmode == 1) {
                                    $VideoCategory_banner = $VideoCategory_banner->whereBetween('videos.age_restrict', [0, 12]);
                                }
    
                                if ($this->videos_expiry_date_status == 1) {
                                    $VideoCategory_banner = $VideoCategory_banner->where(function ($query) {
                                        $query->whereNull('videos.expiry_date')->orWhere('videos.expiry_date', '>=', now()->format('Y-m-d\TH:i'));
                                    });
                                }
    
        $VideoCategory_banner = $VideoCategory_banner->latest('videos.created_at')->limit(15)->get();

        return $VideoCategory_banner ;
    }

    public function AudioAlbums()
    {
        $albums = AudioAlbums::latest()->limit(15) ->get() ;
        return $albums ;
    }

    public function latest_audios()
    {
        
        $latest_audios = Audio::select('id','title','slug','ppv_status','year','rating','access','ppv_price','duration','rating','image','featured','player_image','details','description')
                                ->where('active', '1')->where('status', '1')
                                ->latest()->limit(15)
                                ->get();

        return $latest_audios ;
    }

    public function trending_audios()
    {
        
        $trending_audios = Audio::select('id','title','slug','ppv_status','year','rating','access','ppv_price','duration','rating','image','featured','player_image','details','description')
                                    ->where('active', '1')->where('status', '1')
                                    ->where('views', '>', '5')
                                    ->latest()->limit(15)
                                    ->get();

        return $trending_audios ;
    }

    public function AudioCategory()
    {
        $AudioCategory  = AudioCategory::orderBy('order','ASC')->limit(15)->get();

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
}
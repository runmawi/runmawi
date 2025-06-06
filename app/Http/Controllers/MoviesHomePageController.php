<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\OrderHomeSetting;
use App\VideoCategory;
use App\Multiprofile;
use App\HomeSetting;
use App\BlockVideo;
use App\Video;
use App\User;
use App\Geofencing;
use App\CompressImage;
use Theme;

class MoviesHomePageController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            if(!Auth::guest() ){

                $multiuser = Session::get('subuser_id');
                    
                $Mode = $multiuser != null ?  Multiprofile::where('id', $multiuser)->first() : User::where('id', Auth::User()->id)->first();
                
                $this->check_Kidmode = $Mode['user_type'] != null && $Mode['user_type'] == "Kids" ? 1 : 0 ;
            }else{
    
                $this->check_Kidmode = 0 ;
    
            }
             return $next($request);
        });

        $this->HomeSetting = HomeSetting::first();
        Theme::uses($this->HomeSetting->theme_choosen);

        // $this->Theme = HomeSetting::pluck('theme_choosen')->first();
        // Theme::uses($this->Theme);
        
    }

    public function index()
    {
        try {

            $default_vertical_image_url = default_vertical_image_url();
            $default_horizontal_image_url = default_horizontal_image_url();
            $getfeching = Geofencing::first();

            $FrontEndQueryController = new FrontEndQueryController();

            $all_latest_videos = $FrontEndQueryController->Latest_videos();

            $latest_videos_ppv = $all_latest_videos->filter(function ($video) {
                return $video->access == 'ppv';
            });

            $all_featured_videos = $FrontEndQueryController->featured_videos();
            $featured_videos_ppv = $all_featured_videos->filter(function ($video) {
                return $video->access == 'ppv';
            });

            $all_latestViewedVideos = $FrontEndQueryController->latestViewedVideos();
            $latestViewedVideos_ppv = $all_latestViewedVideos->filter(function ($video) {
                return $video->access == 'ppv';
            });

            $all_video_based_category = $FrontEndQueryController->Video_Based_Category();
            $all_video_based_category_ppv = $all_video_based_category->map(function ($category) {
                $category->category_videos = $category->category_videos->filter(function ($video) {
                    return $video->access == 'ppv';
                });
                return $category;
            });

            $home_settings_on_value = collect($this->HomeSetting)->filter(function ($value) {
                return $value === '1' || $value === 1;  
            })->keys()->toArray(); 
            $order_settings = OrderHomeSetting::select('video_name')->whereIn('video_name',$home_settings_on_value)->orderBy('order_id', 'asc')->get();

            $data = array(
                'latest_video'      => $latest_videos_ppv,
                'latestViewedVideos'      => $latestViewedVideos_ppv,
                'parentCategories'   => $this->VideoCategory(),
                'category_videos'    => $this->category_videos(),
                'featured_videos'    => $featured_videos_ppv,
                'video_based_category'    => $all_video_based_category_ppv,
                'video_categories'    => $FrontEndQueryController->genre_video_display() ,
                'order_settings_list' => OrderHomeSetting::get(), 
                'order_settings'      => $order_settings , 
                'default_vertical_image_url'   => $default_vertical_image_url,
                'default_horizontal_image_url' => $default_horizontal_image_url,
                'home_settings'       => $this->HomeSetting ,
                'current_theme'     => $this->HomeSetting->theme_choosen,
                'getfeching'          => $getfeching ,
                'videos_expiry_date_status'    => videos_expiry_date_status(),
                'multiple_compress_image'      => CompressImage::pluck('enable_multiple_compress_image')->first() ? CompressImage::pluck('enable_multiple_compress_image')->first() : 0,
                'Slider_array_data' => array( 
                                        'video_banners'   =>  Video::where('active',1)->where('status', 1)->where('draft',1)->where('banner',1)->latest()->get(),
                                       ),
            );
            // dd($order_settings);

            return Theme::view('Movies-Home-Page.index', $data);

        } catch (\Throwable $th) {

            return $th->getMessage();

            return abort(404);
        }
    }

    Private function latest_videos(){
        
        $latest_videos = Video::select('id','title','slug','year','rating','access','publish_type','global_ppv','publish_time','ppv_price',
                                        'duration','rating','image','featured','age_restrict','video_tv_image','player_image','details','description','expiry_date')

        ->where('active',1)->where('status', 1)->where('draft',1);

        if( Geofencing() !=null && Geofencing()->geofencing == 'ON')
        {
            $latest_videos = $latest_videos->whereNotIn('videos.id',Block_videos());
        }

        if( !Auth::guest() && $this->check_Kidmode == 1 )
        {
            $latest_videos = $latest_videos->whereNull('age_restrict')->orwhereNotBetween('age_restrict',  [ 0, 12 ] );
        }

        $latest_videos = $latest_videos->latest()->limit(30)->get()->map(function ($item) {
            $item['image_url']          =  $item->image != null ?  URL::to('/public/uploads/images/'.$item->image) :  default_vertical_image_url() ;
            $item['Player_image_url']   =  $item->player_image != null ?  URL::to('public/uploads/images/'.$item->player_image) :  default_horizontal_image_url() ;
            $item['TV_image_url']       =  $item->video_tv_image != null ?  URL::to('public/uploads/images/'.$item->video_tv_image) :  default_horizontal_image_url() ;
            $item['source_type']        = "Videos" ;
            return $item;
        });

        return  $latest_videos;

    }

    Private function VideoCategory()
    {
        
        $VideoCategory = VideoCategory::query()->where('in_home', 1)->orderBy('order')
                            ->limit(30)->get()->map(function ($item) {
                                $item['image_url']        = $item->image != null ?  URL::to('public/uploads/videocategory/'.$item->image) : default_vertical_image_url() ;
                                $item['Player_image_url'] = $item->banner_image != null ?  URL::to('public/uploads/videocategory/'.$item->banner_image) : default_horizontal_image_url() ;
                                $item['TV_image_url']     = $item->banner_image != null ?  URL::to('public/uploads/videocategory/'.$item->banner_image) : default_horizontal_image_url() ;       // Note - No TV Image for Video-Category
                                $item['source_type']      = "video_Categories" ;
                                return $item;
                            });
    }
    
    Private function category_videos()
    {
        
        $VideoCategory = VideoCategory::query()->whereHas('category_videos', function ($query)  {
            
            $query->where('videos.active', 1)->where('videos.status', 1)->where('videos.draft', 1);
    
            if( Geofencing() !=null && Geofencing()->geofencing == 'ON'){
                $query->whereNotIn('videos.id', Block_videos());
            }
    
            if( !Auth::guest() && $this->check_Kidmode == 1 )
            {
                $query = $query->whereNull('videos.age_restrict')->orwhereNotBetween('videos.age_restrict',  [ 0, 12 ] );
            }

        })
        ->with(['category_videos' => function ($videos) {
                $videos->select('videos.id', 'title', 'slug', 'year', 'rating', 'access', 'publish_type', 'global_ppv','publish_time',
                                    'ppv_price', 'duration', 'rating', 'image', 'featured', 'age_restrict','player_image','video_tv_image','details','description','expiry_date')
                    
                    ->where('videos.active', 1)
                    ->where('videos.status', 1)
                    ->where('videos.draft', 1);
        
                if( Geofencing() !=null && Geofencing()->geofencing == 'ON'){
                    $videos->whereNotIn('videos.id', Block_videos());
                }
                
                if( !Auth::guest() && $this->check_Kidmode == 1 )
                {
                    $videos = $videos->whereNull('videos.age_restrict')->orwhereNotBetween('videos.age_restrict',  [ 0, 12 ] );
                }
        
                $videos->latest('videos.created_at')->get();
            }])

        ->select('video_categories.id', 'video_categories.name', 'video_categories.slug', 'video_categories.in_home', 'video_categories.order')
        ->where('video_categories.in_home', 1)
        ->whereHas('category_videos', function ($query)  {
            $query->where('videos.active', 1)->where('videos.status', 1)->where('videos.draft', 1);
        
                if( Geofencing() !=null && Geofencing()->geofencing == 'ON'){
                    $query->whereNotIn('videos.id', Block_videos());
                }

                if( !Auth::guest() && $this->check_Kidmode == 1 )
                {
                    $query = $query->whereNull('videos.age_restrict')->orwhereNotBetween('videos.age_restrict',  [ 0, 12 ] );
                }

            })
        ->orderBy('video_categories.order')->get()
        ->map(function ($category) {
            $category->category_videos->map(function ($video) {
                $video->image_url = $video->image != null ?  URL::to('/public/uploads/images/'.$video->image) : default_vertical_image_url() ;
                $video->Player_image_url = $video->player_image != null ?URL::to('/public/uploads/images/'.$video->player_image) : default_horizontal_image_url() ;
                $video->TV_image_url     = $video->video_tv_image != null ? URL::to('/public/uploads/images/'.$video->video_tv_image): default_horizontal_image_url() ;
                $item['source_type']     = "Videos" ;
                return $video;
            });
            return $category;
        });

        return $VideoCategory ;
    }

    Private function Featured_videos()
    {
        $Featured_videos = Video::select('id','title','slug','year','rating','access','publish_type','global_ppv','publish_time','ppv_price',
                                        'duration','rating','image','featured','age_restrict','video_tv_image','player_image','details','description','expiry_date')

        ->where('active',1)->where('status', 1)->where('draft',1)->where('featured',1);

        if( Geofencing() !=null && Geofencing()->geofencing == 'ON')
        {
            $Featured_videos = $Featured_videos->whereNotIn('videos.id',Block_videos());
        }

        if( !Auth::guest() && $this->check_Kidmode == 1 )
        {
            $Featured_videos = $Featured_videos->whereNull('age_restrict')->orwhereNotBetween('age_restrict',  [ 0, 12 ] );
        }

        $Featured_videos = $Featured_videos->latest()->limit(30)->get()->map(function ($item) {
            $item['image_url']          =  $item->image != null ?  URL::to('/public/uploads/images/'.$item->image) :  default_vertical_image_url() ;
            $item['Player_image_url']   =  $item->player_image != null ?  URL::to('public/uploads/images/'.$item->player_image) :  default_horizontal_image_url() ;
            $item['TV_image_url']       =  $item->video_tv_image != null ?  URL::to('public/uploads/images/'.$item->video_tv_image) :  default_horizontal_image_url() ;
            $item['source_type']        = "Videos" ;
            return $item;
        });

        return  $Featured_videos;
    }
}
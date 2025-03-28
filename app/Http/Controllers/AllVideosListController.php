<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\AdminLandingPage;
use App\CurrencySetting;
use App\ThumbnailSetting;
use App\VideoCategory;
use App\HomeSetting;
use App\Multiprofile;
use App\RecentView;
use App\AudioAlbums;
use App\OrderHomeSetting;
use App\Setting;
use App\Video;
use App\User;
use App\Series;
use App\SeriesGenre;
use App\SeriesSeason;
use App\Episode;
use App\ContinueWatching as ContinueWatching;
use Session;
use Theme;
use Auth;
use URL;
use DB;

class AllVideosListController extends Controller
{
    public function __construct()
    {

        $PPV_settings = Setting::where('ppv_status', '=', 1)->first();
        $this->ppv_gobal_price = !empty($PPV_settings) ? $PPV_settings->ppv_price : null;

        $this->settings = Setting::first();

        $this->videos_per_page = $this->settings->videos_per_page;

        $this->Theme = HomeSetting::pluck('theme_choosen')->first();

        Theme::uses($this->Theme);

    }

    public function all_videos(Request $request)
    {
        try {

            // Video Category 

                $VideoCategory = VideoCategory::select('id','name','slug','in_home')->where('in_home','=',1)
                                ->orderBy('name', "asc")->get()->map(function ($item) {
                                    $item['redirect_url']  = URL::to('videos/category/'.$item->slug);
                                    $item['source_data']   = 'video_category';
                                    return $item;
                                });

            // Series Genres

                $SeriesGenre = SeriesGenre::select('id','name','slug','in_home')->where('in_home',1)
                                ->orderBy('name', "asc")->get()->map(function ($item) {
                                    $item['redirect_url']  = URL::to('series/category/'.$item->slug);
                                    $item['source_data']  = 'SeriesGenre';
                                    return $item;
                                });
                                

            // Fetch all OrderHomeSetting list

                $OrderHomeSetting = OrderHomeSetting::get(); 

            // Fetch all videos list
                $videos = Video::select('active','status','draft','age_restrict','id','created_at','slug','image','title','rating','duration','featured','year')
                        ->where('active', '1')->where('status', '1')->where('draft', '1');

                    if (Geofencing() != null && Geofencing()->geofencing == 'ON') {
                        $videos = $videos->whereNotIn('videos.id', Block_videos());
                    }
                    if (check_Kidmode() == 1) {
                        $videos = $videos->whereBetween('videos.age_restrict', [0, 12]);
                    }
                    
                $videos = $videos->latest()->get()->map(function ($item) {
                    $item['source']       = 'videos';
                    $item['source_data']  = 'videos';
                    $item['redirect_url'] = URL::to('category/videos/'.$item->slug) ;
                    $item['image_url']    = URL::to('public/uploads/images/' . $item->image);
                    $item['title']    = $item->title;
                    $item['rating']   = $item->rating;
                    $item['duration'] = $item->duration;
                    $item['featured'] = $item->featured;
                    $item['year']     = $item->year;
                    $item['age_restrict'] = $item->age_restrict;
                    return $item;
                });

            // Fetch all series list

                $Series = Series::select('active','id','created_at','slug','image','title','rating','duration','featured','year')
                                    ->where('active', '=', '1')->orderBy('created_at', 'DESC')->latest()->get()
                                    ->map(function ($item) use($OrderHomeSetting) {
                    $item['source']       = $OrderHomeSetting->where('id',5)->pluck('header_name')->first() != null ? $OrderHomeSetting->where('id',5)->pluck('header_name')->first() : "Series" ;
                    $item['source_data']  = 'series';
                    $item['redirect_url'] = URL::to('play_series/'.$item->slug) ;
                    $item['image_url']    = URL::to('public/uploads/images/'.$item->image);
                    $item['title']    = $item->title;
                    $item['rating']   = $item->rating;
                    $item['duration'] = $item->duration;
                    $item['featured'] = $item->featured;
                    $item['year']     = $item->year;
                    $item['age_restrict'] = null ;
                    return $item;
                });

            // Fetch all audio albums list

                $AudioAlbums = AudioAlbums::orderBy('created_at', 'desc')->get()->map(function ($item) use($OrderHomeSetting) {
                    $item['source']       = $OrderHomeSetting->where('id',7)->pluck('header_name')->first() != null ? $OrderHomeSetting->where('id',7)->pluck('header_name')->first() : "Podcast";
                    $item['source_data']  = 'AudioAlbums';
                    $item['redirect_url'] = URL::to('album/'.$item->slug) ;
                    $item['image_url']    = URL::to('public/uploads/albums/' . $item->album);
                    $item['title']        = $item->albumname;
                    $item['age_restrict'] = null ;
                    $item['rating']       = null;
                    $item['duration']     = null;
                    $item['featured']     = null;
                    $item['year']         = null;
                    return $item;
                  });

            // Merge the results of the video, series, and audio album queries

                $mergedResults = $videos->merge($Series)->merge($AudioAlbums);

            // Paginate the merged results using LengthAwarePaginator

                $currentPage = request()->get('page') ?: 1;
                $pagedData = $mergedResults->forPage($currentPage, $this->settings->videos_per_page);

                $mergedResults = new LengthAwarePaginator(
                    $pagedData,
                    $mergedResults->count(),
                    $this->settings->videos_per_page,
                    $currentPage,
                    ['path' => request()->url()]
                );

            $respond_data = array(
                'videos'    => $mergedResults,
                'ppv_gobal_price'  => $this->ppv_gobal_price,
                'SeriesGenre'      => $SeriesGenre ,
                'VideoCategory'    => $VideoCategory ,
                'currency'         => CurrencySetting::first(),
                'ThumbnailSetting' => ThumbnailSetting::first(),
            );
    
            return Theme::view('All-Videos.All_videos',['respond_data' => $respond_data]);

        } catch (\Throwable $th) {
            // return $th->getMessage();
            return abort(404);
        }
       
    }

    public function learn(Request $request)
    {
        try {

            if($this->settings->enable_landing_page == 1 && Auth::guest()){

                $landing_page_slug = AdminLandingPage::where('status',1)->pluck('slug')->first() ? AdminLandingPage::where('status',1)->pluck('slug')->first() : "landing-page" ;
    
                return redirect()->route('landing_page', $landing_page_slug );
            }

            $series_categories = SeriesGenre::where('category_list_active',1)->pluck('id');

            //  Catogery Series - only for Nemisha
             
            $series = SeriesGenre::query()->with(['category_series' => function ($series) {
                    $series->select('series.id','series.slug', 'series.image', 'series.title', 'series.duration', 'series.rating', 'series.featured')
                        ->where('series.active', '1')
                        ->latest('series.created_at');
                }])
                ->select('series_genre.id', 'series_genre.name', 'series_genre.in_home', 'series_genre.slug', 'series_genre.order')
                ->orderBy('series_genre.order')
                ->where('in_home','=',1)
                ->whereIn('series_genre.id', $series_categories)
                ->get();
            
            $series = $series->map(function ($genre) {
                $genre->category_series = $genre->category_series->map(function ($item) {
                    $item->image_url     = URL::to('/public/uploads/images/'.$item->image);
                    $item->redirect_url  = URL::to('play_series/'. $item->slug);
                    $item->season_count  = SeriesSeason::where('series_id',$item->id)->count();
                    $item->Episode_count = Episode::where('series_id',$item->id)->count();
                    return $item;
                });
                return $genre;
            });

            $series_sliders = Series::join('series_categories', 'series_categories.series_id', '=', 'series.id')
                                ->whereIn('series_categories.category_id', $series_categories)
                                ->where('series.active', 1 )
                                ->where('banner',1)
                                ->get();

            $respond_data = array(
                'series'    => $series,
                'series_sliders' => $series_sliders,
                'ppv_gobal_price'  => $this->ppv_gobal_price,
                'currency'         => CurrencySetting::first(),
                'ThumbnailSetting' => ThumbnailSetting::first(),
            );
    
           return Theme::view('All-Videos.learn',['respond_data' => $respond_data]);

        } catch (\Throwable $th) {
             return $th->getMessage();
            return abort(404);
        }
    }

    public function All_User_MostwatchedVideos()
    {
        try {
            
            if($this->settings->enable_landing_page == 1 && Auth::guest()){

                $landing_page_slug = AdminLandingPage::where('status',1)->pluck('slug')->first() ? AdminLandingPage::where('status',1)->pluck('slug')->first() : "landing-page" ;
    
                return redirect()->route('landing_page', $landing_page_slug );
            }

            if( Auth::guest())
            {
                $respond_data = array(
                    'videos'    => [],
                    'ppv_gobal_price'  => $this->ppv_gobal_price,
                    'currency'         => CurrencySetting::first(),
                    'ThumbnailSetting' => ThumbnailSetting::first(),
                );
    
                return Theme::view('All-Videos.All_User_MostwatchedVideos',['respond_data' => $respond_data]);
            }

            $multiuser = Session::get('subuser_id');
            
            $videos = RecentView::select('video_id', 'videos.*', DB::raw('COUNT(video_id) AS count'))
                                ->join('videos', 'videos.id', '=', 'recent_views.video_id')
                                ->where('active', '=', '1')->where('status', '=', '1')
                                ->where('draft', '=', '1')
                                ->groupBy('video_id');

            $videos = $multiuser != null ?  $videos->where('recent_views.sub_user', $multiuser) : $videos->where('recent_views.user_id', Auth::user()->id) ;

                    if (check_Kidmode() == 1)
                    {
                        $videos = $videos->whereBetween('videos.age_restrict', [ 0, 12 ]);
                    }

                    if( Geofencing() !=null && Geofencing()->geofencing == 'ON')
                    {
                        $videos = $videos->whereNotIn('videos.id',Block_videos());
                    }

            $videos = $videos->orderByRaw('count DESC')->Paginate($this->settings->videos_per_page);


            $respond_data = array(
                'videos'    => $videos,
                'ppv_gobal_price'  => $this->ppv_gobal_price,
                'currency'         => CurrencySetting::first(),
                'ThumbnailSetting' => ThumbnailSetting::first(),
            );

            return Theme::view('All-Videos.All_User_MostwatchedVideos',['respond_data' => $respond_data]);

        } catch (\Throwable $th) {
            // return $th->getMessage();
            return abort(404);
        }

    }

    public function All_Country_MostwatchedVideos(Request $request)
    {
        try {

            $FrontEndQueryController = new FrontEndQueryController();
            if($this->settings->enable_landing_page == 1 && Auth::guest()){

                $landing_page_slug = AdminLandingPage::where('status',1)->pluck('slug')->first() ? AdminLandingPage::where('status',1)->pluck('slug')->first() : "landing-page" ;
    
                return redirect()->route('landing_page', $landing_page_slug );
            }

            // $videos = RecentView::select('video_id', 'videos.*', DB::raw('COUNT(video_id) AS count'))
            //     ->join('videos', 'videos.id', '=', 'recent_views.video_id')
            //     ->where('active', '=', '1')->where('status', '=', '1')->where('draft', '=', '1')
            //     ->groupBy('video_id')
            //     ->orderByRaw('count DESC');

                $videos = $FrontEndQueryController->Most_watched_videos_country();

                if (check_Kidmode() == 1)
                {
                    $videos = $videos->whereBetween('videos.age_restrict', [ 0, 12 ]);
                }

                if( Geofencing() !=null && Geofencing()->geofencing == 'ON')
                {
                    $videos = $videos->whereNotIn('videos.id',Block_videos());
                }

            // $videos = $videos->where('country', Country_name())->Paginate($this->settings->videos_per_page);

            $respond_data = array(
                'videos'    => $videos,
                'ppv_gobal_price'  => $this->ppv_gobal_price,
                'currency'         => CurrencySetting::first(),
                'ThumbnailSetting' => ThumbnailSetting::first(),
            );

            return Theme::view('All-Videos.All_Country_MostwatchedVideos',['respond_data' => $respond_data]);

        } catch (\Throwable $th) {
            // return $th->getMessage();
            return abort(404);
        }
    }

    public function All_MostwatchedVideos(Request $request)
    {
        try {

            if($this->settings->enable_landing_page == 1 && Auth::guest()){

                $landing_page_slug = AdminLandingPage::where('status',1)->pluck('slug')->first() ? AdminLandingPage::where('status',1)->pluck('slug')->first() : "landing-page" ;
    
                return redirect()->route('landing_page', $landing_page_slug );
            }
           
            $videos = RecentView::select('video_id', 'videos.*', DB::raw('COUNT(video_id) AS count'))
                            ->join('videos', 'videos.id', '=', 'recent_views.video_id')
                            ->where('active', '=', '1')->where('status', '=', '1')->where('draft', '=', '1')
                            ->groupBy('video_id');
                            
                if (check_Kidmode() == 1)
                {
                    $videos = $videos->whereBetween('videos.age_restrict', [ 0, 12 ]);
                }
            
                if( Geofencing() !=null && Geofencing()->geofencing == 'ON')
                {
                    $videos = $videos->whereNotIn('videos.id',Block_videos());
                }

            $videos = $videos->orderByRaw('count DESC')->Paginate($this->settings->videos_per_page);
        
            $respond_data = array(
                'videos'    => $videos,
                'ppv_gobal_price'  => $this->ppv_gobal_price,
                'currency'         => CurrencySetting::first(),
                'ThumbnailSetting' => ThumbnailSetting::first(),
            );

            return Theme::view('All-Videos.All_MostwatchedVideos',['respond_data' => $respond_data]);

        } catch (\Throwable $th) {
            // return $th->getMessage();
            return abort(404);
        }
    }

    
    public function all_series(Request $request)
    {
        try {

            $OrderHomeSetting = OrderHomeSetting::get(); 

            // Fetch all series list

                $Series = Series::select('active','id','created_at','slug','image','title','rating','duration','featured','year')
                                    ->where('active', '=', '1')->orderBy('created_at', 'DESC')->latest()->get()
                                    ->map(function ($item) use($OrderHomeSetting) {
                    $item['source']       = $OrderHomeSetting->where('id',5)->pluck('header_name')->first() != null ? $OrderHomeSetting->where('id',5)->pluck('header_name')->first() : "Series" ;
                    $item['redirect_url'] = URL::to('play_series/'.$item->slug) ;
                    $item['image_url']    = URL::to('public/uploads/images/'.$item->image);

                    $item['title']    = $item->title;
                    $item['rating']   = $item->rating;
                    $item['duration'] = $item->duration;
                    $item['featured'] = $item->featured;
                    $item['year']     = $item->year;
                    $item['age_restrict'] = null ;

                    return $item;
                });

            // Paginate the merged results using LengthAwarePaginator

                $currentPage = request()->get('page') ?: 1;
                $pagedData = $Series->forPage($currentPage, $this->settings->videos_per_page);

                $Series = new LengthAwarePaginator(
                    $pagedData,
                    $Series->count(),
                    $this->settings->videos_per_page,
                    $currentPage,
                    ['path' => request()->url()]
                );

            $respond_data = array(
                'Series'    => $Series,
                'ppv_gobal_price'  => $this->ppv_gobal_price,
                'currency'         => CurrencySetting::first(),
                'ThumbnailSetting' => ThumbnailSetting::first(),
            );
    
            return Theme::view('All-Videos.All_series',['respond_data' => $respond_data]);

        } catch (\Throwable $th) {
            // return $th->getMessage();
            return abort(404);
        }
       
    }

    public function ContinueWatchingList(Request $request)
    {
        try {

            if($this->settings->enable_landing_page == 1 && Auth::guest()){

                $landing_page_slug = AdminLandingPage::where('status',1)->pluck('slug')->first() ? AdminLandingPage::where('status',1)->pluck('slug')->first() : "landing-page" ;
    
                return redirect()->route('landing_page', $landing_page_slug );
            }

            $OrderHomeSetting = OrderHomeSetting::get(); 

            $FrontEndQueryController = new FrontEndQueryController();


             // Fetch all ContinueWatching videos list
                
            $videos = ContinueWatching::join("videos", "continue_watchings.videoid", "=", "videos.id")
                ->select('videos.*')
                ->where('videos.active', '1')->where('videos.status', '1')->where('videos.draft', '1');

                    if (Geofencing() != null && Geofencing()->geofencing == 'ON') {
                        $videos = $videos->whereNotIn('videos.id', Block_videos());
                    }
                    if (check_Kidmode() == 1) {
                        $videos = $videos->whereBetween('videos.age_restrict', [0, 12]);
                    }
                    
                $videos = $videos->get()->map(function ($item) {
                    $item['source']       = 'videos';
                    $item['redirect_url'] = URL::to('category/videos/'.$item->slug) ;
                    $item['image_url']    = URL::to('public/uploads/images/' . $item->image);

                    $item['title']    = $item->title;
                    $item['rating']   = $item->rating;
                    $item['duration'] = $item->duration;
                    $item['featured'] = $item->featured;
                    $item['year']     = $item->year;
                    $item['age_restrict'] = $item->age_restrict;

                    return $item;
                });

            // Paginate the merged results using LengthAwarePaginator

                $currentPage = request()->get('page') ?: 1;
                $pagedData = $videos->forPage($currentPage, $this->settings->videos_per_page);

                $videos = new LengthAwarePaginator(
                    $pagedData,
                    $videos->count(),
                    $this->settings->videos_per_page,
                    $currentPage,
                    ['path' => request()->url()]
                );

                $Video_cnt         = $FrontEndQueryController->VideoJsContinueWatching();
                $episode_cnt         = $FrontEndQueryController->VideoJsEpisodeContinueWatching();

            $respond_data = array(
                'Video_cnt'             => $FrontEndQueryController->VideoJsContinueWatching(),
                'episode_cnt'           => $FrontEndQueryController->VideoJsEpisodeContinueWatching(),
                'ppv_gobal_price'       => $this->ppv_gobal_price,
                'currency'              => CurrencySetting::first(),
                'ThumbnailSetting'      => ThumbnailSetting::first(),
            );
            // dd($Video_cnt);
    
            return Theme::view('All-Videos.ContinueWatchingList', $respond_data);

        } catch (\Throwable $th) {
            // return $th->getMessage();
            return abort(404);
        }
    }

    public function Free_videos(Request $request)
    {
        try {

                $OrderHomeSetting = OrderHomeSetting::get(); 

               // Fetch all videos list

                $videos = Video::select('active','status','draft','age_restrict','id','created_at','slug','image','title','rating','duration','featured','year')
                        ->where('active', '1')->where('status', '1')->where('draft', '1')->where('access','guest');

                    if (Geofencing() != null && Geofencing()->geofencing == 'ON') {
                        $videos = $videos->whereNotIn('videos.id', Block_videos());
                    }
                    if (check_Kidmode() == 1) {
                        $videos = $videos->whereBetween('videos.age_restrict', [0, 12]);
                    }
                    
                $videos = $videos->latest()->get()->map(function ($item) {
                    $item['source']       = 'videos';
                    $item['source_data']  = 'videos';
                    $item['redirect_url'] = URL::to('category/videos/'.$item->slug) ;
                    $item['image_url']    = URL::to('public/uploads/images/' . $item->image);
                    $item['title']    = $item->title;
                    $item['rating']   = $item->rating;
                    $item['duration'] = $item->duration;
                    $item['featured'] = $item->featured;
                    $item['year']     = $item->year;
                    $item['age_restrict'] = $item->age_restrict;
                    return $item;
                });
            
            // Paginate the merged results using LengthAwarePaginator

                $currentPage = request()->get('page') ?: 1;
                $pagedData = $videos->forPage($currentPage, $this->settings->videos_per_page);

                $videos = new LengthAwarePaginator(
                    $pagedData,
                    $videos->count(),
                    $this->settings->videos_per_page,
                    $currentPage,
                    ['path' => request()->url()]
                );

                $respond_data = array(
                    'videos'    => $videos,
                    'ppv_gobal_price'  => $this->ppv_gobal_price,
                    'currency'         => CurrencySetting::first(),
                    'ThumbnailSetting' => ThumbnailSetting::first(),
                );

                return Theme::view('All-Videos.free_movies_list',['respond_data' => $respond_data]);

        } catch (\Throwable $th) {
            // return $th->getMessage();
            return abort(404);
        }
    }
}
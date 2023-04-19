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
use App\Setting;
use App\Video;
use App\User;
use App\Series;
use Session;
use Theme;
use Auth;
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

            if($this->settings->enable_landing_page == 1 && Auth::guest()){

                $landing_page_slug = AdminLandingPage::where('status',1)->pluck('slug')->first() ? AdminLandingPage::where('status',1)->pluck('slug')->first() : "landing-page" ;
    
                return redirect()->route('landing_page', $landing_page_slug );
            }
    
            // Fetch all videos list
                $videos = Video::where('active', '=', '1')->where('status', '=', '1')->where('draft', '=', '1');
                    if (Geofencing() != null && Geofencing()->geofencing == 'ON') {
                        $videos = $videos->whereNotIn('videos.id', Block_videos());
                    }
                    if (check_Kidmode() == 1) {
                        $videos = $videos->whereBetween('videos.age_restrict', [0, 12]);
                    }
                    
                $videos = $videos->latest('videos.created_at')->get();

            // Fetch all series list

                $Series = Series::where('active', '=', '1')->orderBy('created_at', 'DESC')->get();

            // Fetch all audio albums list

                $AudioAlbums = AudioAlbums::orderBy('created_at', 'desc')->get();

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
                'currency'         => CurrencySetting::first(),
                'ThumbnailSetting' => ThumbnailSetting::first(),
            );
    
            return Theme::view('All-Videos.All_videos',['respond_data' => $respond_data]);

        } catch (\Throwable $th) {
            return $th->getMessage();
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
    
                    // All Education Catogery videos - only for Nemisha
             
                $Episode_videos = Series::select('episodes.*', 'series.title as series_name','series.slug as series_slug','series.year')
                    ->join('series_categories', 'series_categories.series_id', '=', 'series.id')
                    ->join('episodes', 'episodes.series_id', '=', 'series.id')
                    ->where('series_categories.category_id', '=', 19)
                    ->where('episodes.active', '=', '1')
                    ->where('series.active', '=', '1')
                    ->groupBy('episodes.id')
                    ->latest('episodes.created_at')
                    ->get();


                $learn_series_sliders = Series::join('series_categories', 'series_categories.series_id', '=', 'series.id')
                                                ->whereIn('series_categories.category_id',['19'])
                                                ->where('series.active', 1 )
                                                ->where('banner',1)
                                                ->get();

                $respond_data = array(
                    'Episode_videos'    => $Episode_videos,
                    'learn_series_sliders' => $learn_series_sliders,
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

            if($this->settings->enable_landing_page == 1 && Auth::guest()){

                $landing_page_slug = AdminLandingPage::where('status',1)->pluck('slug')->first() ? AdminLandingPage::where('status',1)->pluck('slug')->first() : "landing-page" ;
    
                return redirect()->route('landing_page', $landing_page_slug );
            }

            $videos = RecentView::select('video_id', 'videos.*', DB::raw('COUNT(video_id) AS count'))
                ->join('videos', 'videos.id', '=', 'recent_views.video_id')
                ->where('active', '=', '1')->where('status', '=', '1')->where('draft', '=', '1')
                ->groupBy('video_id')
                ->orderByRaw('count DESC');

                if (check_Kidmode() == 1)
                {
                    $videos = $videos->whereBetween('videos.age_restrict', [ 0, 12 ]);
                }

                if( Geofencing() !=null && Geofencing()->geofencing == 'ON')
                {
                    $videos = $videos->whereNotIn('videos.id',Block_videos());
                }

            $videos = $videos->where('country', Country_name())->Paginate($this->settings->videos_per_page);

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
}

<?php
namespace App\Http\Controllers;
use App\User as User;
use \Redirect as Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
use App\AdminLandingPage;
use App\CommentSection;


class ChannelController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        $settings = Setting::first();
        $this->videos_per_page = $settings->videos_per_page;

        $this->Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses($this->Theme);
    }

    public function index()
    {
        $settings = Setting::first();
        $parentCategories = \App\VideoCategory::where('parent_id', 0)->get();

        return view('channels', compact('parentCategories'));
    }

    public function Parent_video_categories($category_slug)
    {
        // try {

            $VideoCategory           = VideoCategory::where('slug', $category_slug)->first();
            $Parent_video_categories = VideoCategory::query()->where('parent_id',$VideoCategory->id)->get();
            $Parent_video_categories_id = VideoCategory::query()->where('parent_id',$VideoCategory->id)->pluck('id')->toArray();

            $categories_id = ($Parent_video_categories_id);
            array_push($categories_id,$VideoCategory->id );

            $check_Kidmode = 0 ; 

            $video_categories = VideoCategory::query()->whereIn('id',$categories_id)->whereHas('category_videos', function ($query) use ($check_Kidmode) {
                    $query->where('videos.active', 1)->where('videos.status', 1)->where('videos.draft', 1);
            
                    if (Geofencing() != null && Geofencing()->geofencing == 'ON') {
                        $query->whereNotIn('videos.id', Block_videos());
                    }
            
                    if ($check_Kidmode == 1) {
                        $query->whereBetween('videos.age_restrict', [0, 12]);
                    }
                })->with(['category_videos' => function ($videos) use ($check_Kidmode) {
                    $videos->select('videos.id', 'title', 'slug', 'year', 'rating', 'access', 'publish_type', 'global_ppv', 'publish_time', 'ppv_price', 'duration', 'rating', 'image', 'featured', 'age_restrict','player_image','description','videos.trailer','videos.trailer_type')
                        ->where('videos.active', 1)->where('videos.status', 1)->where('videos.draft', 1);

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
                ->whereHas('category_videos', function ($query) use ($check_Kidmode) {
                    $query->where('videos.active', 1)->where('videos.status', 1)->where('videos.draft', 1);
            
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
                        $video->description  = $video->description ;
                        $video->source  = "Videos";
                        return $video;
                    });
                    $category->source =  "category_videos" ;
                    return $category;
                });
            
            $data = [
                'Parent_videos_categories'  => $Parent_video_categories ,
                'VideosCategory'            => $VideoCategory ,
                'video_categories'         => $video_categories ,
            ];

            return Theme::view('videos-Categories', $data);

        // } catch (\Throwable $th) {

        //     return abort(404);
        // }
    }

    public function channelVideos($cid)
    {
        try {

            $ThumbnailSetting = ThumbnailSetting::first();
            $PPV_settings = Setting::where('ppv_status', 1)->first();
            $ppv_gobal_price = !empty($PPV_settings) ? $PPV_settings->ppv_price : null ;
            $category_id     = VideoCategory::where('slug', $cid)->pluck('id');
            $category_title  = VideoCategory::where('id', $category_id)->pluck('name')->first();
            $categoryVideo = CategoryVideo::where('category_id',$category_id->first())->groupBy('video_id')->pluck('video_id');

            // categoryVideos

            $categoryVideos = Video::join('categoryvideos', 'categoryvideos.video_id', '=', 'videos.id')
                    ->whereIn('category_id', $category_id)->where('active', 1)
                    ->where('videos.status', 1)->where('videos.draft', 1);

                if(Geofencing() !=null && Geofencing()->geofencing == 'ON'){       
                    $categoryVideos = $categoryVideos->whereNotIn('videos.id', Block_videos());
                }

            $categoryVideos = $categoryVideos->latest('videos.created_at')->paginate($this->videos_per_page);
          
            // Most_watched_country

            $Most_watched_country = RecentView::select('video_id', 'videos.*', DB::raw('COUNT(video_id) AS count'))
                        ->join('videos', 'videos.id', '=', 'recent_views.video_id')
                        ->where('videos.status', '=', '1')->where('videos.draft', '=', '1')
                        ->where('videos.active', '=', '1')->groupBy('video_id')
                        ->orderByRaw('count DESC');

                if(Geofencing() !=null && Geofencing()->geofencing == 'ON'){       
                    $Most_watched_country = $Most_watched_country->whereNotIn('videos.id', Block_videos());
                }
            
            $Most_watched_country = $Most_watched_country->where('recent_views.country_name', Country_name())
                            ->whereNotIn('videos.id',Block_videos() )->whereIn('videos.id',$categoryVideo)->get()
                            ->map(function ($item) {

                                $item['categories'] =  CategoryVideo::select('categoryvideos.*','category_id','video_id','video_categories.name as name','video_categories.slug')
                                                            ->join('video_categories','video_categories.id','=','categoryvideos.category_id')
                                                            ->where('video_id', $item->video_id )
                                                            ->pluck('name') 
                                                            ->implode(' , ');
    
                                return $item;
                });


            $top_most_watched = RecentView::select('video_id', 'videos.*', DB::raw('COUNT(video_id) AS count'))
                            ->join('videos', 'videos.id', '=', 'recent_views.video_id')->where('videos.status', '=', '1')
                            ->where('videos.draft', '=', '1')->where('videos.active', '=', '1')
                            ->whereIn('videos.id',$categoryVideo)
                            ->groupBy('video_id');

                            if(Geofencing() !=null && Geofencing()->geofencing == 'ON'){       
                                $top_most_watched = $Most_watched_country->whereNotIn('videos.id', Block_videos());
                            }

            $top_most_watched = $top_most_watched->orderByRaw('count DESC')->limit(20)->get();

            $video_banners = Video::where('active', '=', '1')->whereIn('videos.id',$categoryVideo)
                                        ->where('draft', '1')->where('status', '1')
                                        ->where('banner', '1')->latest()
                                        ->get() ;

            $Episode_videos = Series::select('episodes.*', 'series.title as series_name','series.slug as series_slug')
                ->join('series_categories', 'series_categories.series_id', '=', 'series.id')
                ->join('episodes', 'episodes.series_id', '=', 'series.id')
                ->where('series_categories.category_id', '=', $category_id)
                ->where('episodes.active', '=', '1')
                ->where('series.active', '=', '1')
                ->groupBy('episodes.id')
                ->latest('episodes.created_at')
                ->paginate($this->videos_per_page);

                // for Theme4, theme6 , default

                $check_Kidmode = 0 ;

                $video_categories = VideoCategory::query()->whereIn('id',$category_id)->whereHas('category_videos', function ($query) use ($check_Kidmode) {
                    $query->where('videos.active', 1)->where('videos.status', 1)->where('videos.draft', 1);
            
                    if (Geofencing() != null && Geofencing()->geofencing == 'ON') {
                        $query->whereNotIn('videos.id', Block_videos());
                    }
            
                    if ($check_Kidmode == 1) {
                        $query->whereBetween('videos.age_restrict', [0, 12]);
                    }
                })->with(['category_videos' => function ($videos) use ($check_Kidmode) {
                    $videos->select('videos.id', 'title', 'slug', 'year', 'rating', 'access', 'publish_type', 'global_ppv', 'publish_time', 'ppv_price', 'duration', 'rating', 'image', 'featured', 'age_restrict','player_image','description','videos.trailer','videos.trailer_type')
                        ->where('videos.active', 1)->where('videos.status', 1)->where('videos.draft', 1);

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
                ->whereHas('category_videos', function ($query) use ($check_Kidmode) {
                    $query->where('videos.active', 1)->where('videos.status', 1)->where('videos.draft', 1);
            
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
                        $video->description  = $video->description ;
                        $video->source  = "Videos";
                        return $video;
                    });
                    $category->source =  "category_videos" ;
                    return $category;
                });

            $data = [
                'currency'          => CurrencySetting::first(),
                'category_title'    => $category_title,
                'categoryVideos'    =>  $categoryVideos,
                'ppv_gobal_price'   => $ppv_gobal_price,
                'ThumbnailSetting'  => $ThumbnailSetting,
                'age_categories'    => AgeCategory::get(),
                'Episode_videos'    => $Episode_videos,
                'Most_watched_country' => $Most_watched_country ,
                'top_most_watched'  => $top_most_watched ,
                'video_banners'     => $video_banners ,
                'video_categories'  => $video_categories ,
            ];

            return Theme::view('categoryvids', ['categoryVideos' => $data]);

        } catch (\Throwable $th) {
            // return $th->getMessage();
            return abort(404);
        }
    }

    public function play_videos($slug)
    {
        if ( choosen_player() == 1 ){

            return $this->videos_details_jsplayer($slug);
        }

        $settings = Setting::first();
        if ($settings->access_free == 0 && Auth::guest())
        {
            return Redirect::to('/');
        }
        $data['password_hash'] = '';
        $data = session()->all();
        $getfeching = \App\Geofencing::first();
        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
        $userIp = $geoip->getip();
        $countryName = $geoip->getCountry();
        $cityName = $geoip->getcity();
        $stateName = $geoip->getregion();
        $ThumbnailSetting = ThumbnailSetting::first();
        $StorageSetting = StorageSetting::first();

        $source_id = Video::where('slug', $slug)->pluck('id')->first();

        if (!Auth::guest()) {
            $get_video_id = \App\Video::where('slug', $slug)->first();
            try {
                $vid = $get_video_id->id;
            } catch (\Throwable $th) {
                return abort(404);
            }

            $artistscount = Videoartist::join('artists', 'video_artists.artist_id', '=', 'artists.id')
                ->select('artists.*')
                ->where('video_artists.video_id', '=', $vid)
                ->count();

            if ($artistscount > 0) {
                $artists = Videoartist::join('artists', 'video_artists.artist_id', '=', 'artists.id')
                    ->select('artists.*')
                    ->where('video_artists.video_id', '=', $vid)
                    ->get();
            } else {
                $artists = [];
            }

            // $cast = Videoartist::where('video_id','=',$vid)->get();
            // foreach($cast as $key => $artist){
            //   $artists[] = Artist::where('id','=',$artist->artist_id)->get();
            // }

            $PPV_settings = Setting::where('ppv_status', '=', 1)->first();

            if (!empty($PPV_settings)) {
                $ppv_rent_price = $PPV_settings->ppv_price;
            } else {
                $Video_ppv = Video::where('id', '=', $vid)->first();
                $ppv_rent_price = null;

                if ($Video_ppv->ppv_price != '') {
                    $ppv_rent_price = $Video_ppv->ppv_price;
                } else {
                    $ppv_rent_price = $Video_ppv->ppv_price;
                }
            }
            $current_date = date('Y-m-d h:i:s a', time());
            $view_increment = $this->handleViewCount_movies($vid);

            if (!Auth::guest()) {
                $sub_user = Session::get('subuser_id');

                $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
                $userIp = $geoip->getip();
                $countryName = $geoip->getCountry();
                $regionName = $geoip->getregion();
                $cityName = $geoip->getcity();

                $view = new RecentView();
                $view->video_id = $vid;
                $view->user_id = Auth::user()->id;
                $view->country_name = $countryName;
                if ($sub_user != null) {
                    $view->sub_user = $sub_user;
                }
                $view->visited_at = date('Y-m-d');
                $view->save();

                $regionview = RegionView::where('user_id', '=', Auth::User()->id)
                    ->where('video_id', '=', $vid)
                    ->orderBy('created_at', 'DESC')
                    ->whereDate('created_at', '>=', \Carbon\Carbon::now()->today())
                    ->first();

                if (!empty($regionview)) {
                    $regionview = RegionView::where('user_id', '=', Auth::User()->id)
                        ->where('video_id', '=', $vid)
                        ->orderBy('created_at', 'DESC')
                        ->whereDate('created_at', '>=', \Carbon\Carbon::now()->today())
                        ->delete();
                    $region = new RegionView();
                    $region->user_id = Auth::User()->id;
                    $region->user_ip = $userIp;
                    $region->video_id = $vid;
                    $region->countryname = $countryName;
                    $region->save();
                } else {
                    $region = new RegionView();
                    $region->user_id = Auth::User()->id;
                    $region->user_ip = $userIp;
                    $region->video_id = $vid;
                    $region->countryname = $countryName;
                    $region->save();
                }

                $user_id = Auth::user()->id;
                $watch_id = ContinueWatching::where('user_id', '=', $user_id)
                    ->where('videoid', '=', $vid)
                    ->orderby('created_at', 'desc')
                    ->first();
                $watch_count = ContinueWatching::where('user_id', '=', $user_id)
                    ->where('videoid', '=', $vid)
                    ->orderby('created_at', 'desc')
                    ->count();

                if ($watch_count > 0) {
                    $watchtime = $watch_id->currentTime;
                } else {
                    $watchtime = 0;
                }

                $ppvexist = PpvPurchase::where('video_id', $vid)
                    ->where('user_id', $user_id)
                    // ->where('status','active')
                    // ->where('to_time','>',$current_date)
                    ->count();

                $ppv_video = PpvPurchase::where('video_id', $vid)
                    ->where('user_id', $user_id)
                    ->first();

                $user_id = Auth::user()->id;

                if ($ppvexist > 0 && $ppv_video->view_count > 0 && $ppv_video->view_count != null) {
                    $ppv_exist = PpvPurchase::where('video_id', $vid)
                        ->where('user_id', $user_id)
                        ->where('status', 'active')
                        ->where('to_time', '>', $current_date)
                        ->count();
                } elseif ($ppvexist > 0 && $ppv_video->view_count == null) {
                    $ppv_exist = PpvPurchase::where('video_id', $vid)
                        ->where('user_id', $user_id)
                        // ->where('status','active')
                        // ->where('to_time','>',$current_date)
                        ->count();
                } else {
                    $ppv_exist = 0;
                }

                $categoryVideos = Video::with('category.categoryname')
                    ->where('id', $vid)
                    ->first();

                $category_name = CategoryVideo::select('video_categories.name as categories_name','video_categories.slug as categories_slug','categoryvideos.video_id')
                    ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
                    ->where('categoryvideos.video_id', $vid)
                    ->get();

                if (count($category_name) > 0) {
                    foreach ($category_name as $value) {
                        $vals[] = $value->categories_name;
                    }
                    $genres_name = implode(', ', $vals);
                } else {
                    $genres_name = 'No Genres Added';
                }


                $lang_name = LanguageVideo::select('languages.name as name')
                    ->Join('languages', 'languagevideos.language_id', '=', 'languages.id')
                    ->where('languagevideos.video_id', $vid)
                    ->get();

                if (count($lang_name) > 0) {
                    foreach ($lang_name as $value) {
                        $languagesvals[] = $value->name;
                    }
                    $lang_name = implode(',', $languagesvals);
                } else {
                    $lang_name = 'No Languages Added';
                }

                $artists_name = Videoartist::select('artists.artist_name as name')
                    ->Join('artists', 'video_artists.artist_id', '=', 'artists.id')
                    ->where('video_artists.video_id', $vid)
                    ->get();

                if (count($artists_name) > 0) {
                    foreach ($artists_name as $value) {
                        $artistsvals[] = $value->name;
                    }
                    $artistsname = implode(',', $artistsvals);
                } else {
                    $artistsname = 'No Starring  Added';
                }

                $subtitles_name = MoviesSubtitles::select('subtitles.language as language')
                    ->Join('subtitles', 'movies_subtitles.shortcode', '=', 'subtitles.short_code')
                    ->where('movies_subtitles.movie_id', $vid)
                    ->get();

                if (count($subtitles_name) > 0) {
                    foreach ($subtitles_name as $value) {
                        $subtitlesname[] = $value->language;
                    }
                    $subtitles = implode(', ', $subtitlesname);
                } else {
                    $subtitles = 'No Subtitles Added';
                }

                $category_id = CategoryVideo::where('video_id', $vid)->get();
                $categoryvideo = CategoryVideo::where('video_id', $vid)
                    ->pluck('category_id')
                    ->toArray();
                $languages_id = LanguageVideo::where('video_id', $vid)
                    ->pluck('language_id')
                    ->toArray();

                // Recomendeds And Endcard
                foreach ($category_id as $key => $value) {
                    $recomendeds = Video::select('videos.*', 'video_categories.name as categories_name', 'categoryvideos.category_id as categories_id')
                        ->Join('categoryvideos', 'videos.id', '=', 'categoryvideos.video_id')
                        ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
                        ->where('videos.id', '!=', $vid)
                        ->where('videos.active',  1)
                        ->where('videos.status',  1)
                        ->where('videos.draft',  1)
                        ->limit(10)
                        ->get();

                    $endcardvideo = Video::select('videos.*', 'video_categories.name as categories_name', 'categoryvideos.category_id as categories_id')
                        ->Join('categoryvideos', 'videos.id', '=', 'categoryvideos.video_id')
                        ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
                        ->where('videos.id', '!=', $vid)
                        ->limit(5)
                        ->get();
                }

                if (!Auth::guest()) {
                    $latestRecentView = RecentView::where('user_id', '!=', Auth::user()->id)
                        ->distinct()
                        ->limit(30)
                        ->pluck('video_id');
                    if (count($latestRecentView) > 10) {
                        $latestviews = [];
                    } else {
                        $latestviews = Video::select('videos.*', 'video_categories.name as categories_name', 'categoryvideos.category_id as categories_id')
                            ->Join('categoryvideos', 'videos.id', '=', 'categoryvideos.video_id')
                            ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
                            ->whereIn('videos.id', $latestRecentView)
                            ->groupBy('videos.id')
                            ->get();
                    }
                } else {
                    $latestRecentView = [];
                    $latestviews = [];
                    $recomendeds = $recomendeds;
                }

                $related_videos = Video::select('videos.*', 'related_videos.id as related_videos_id', 'related_videos.related_videos_title as related_videos_title')
                    ->Join('related_videos', 'videos.id', '=', 'related_videos.related_videos_id')
                    ->where('related_videos.video_id', '=', $vid)
                    ->limit(5)
                    ->get();

                if (count($related_videos) > 0) {
                    $endcardvideo = $related_videos;
                } elseif (!empty($endcardvideo)) {
                    $endcardvideo = $endcardvideo;
                } else {
                    $endcardvideo = [];
                }

                if ($get_video_id->type == 'mp4_url') {
                    // $ffprobe = FFProbe::create();
                    // $endtimevideos = $ffprobe->format($get_video_id->mp4_url) // extracts file informations
                    //    ->get('duration');
                    //    $endtimevideo = $endtimevideos - 5;
                    $endtimevideo = '';
                } elseif ($get_video_id->type == 'm3u8_url') {
                    // $ffprobe = FFProbe::create();
                    // $endtimevideos = $ffprobe->format($get_video_id->m3u8_url) // extracts file informations
                    //    ->get('duration');
                    //    $endtimevideo = $endtimevideos - 5;
                    $endtimevideo = '';
                } elseif ($get_video_id->type == '') {
                    // $ffprobe = FFProbe::create();
                    // $endtimevideos = $ffprobe->format($get_video_id->mp4_url) // extracts file informations
                    //    ->get('duration');
                    //    $endtimevideo = $endtimevideos - 5;
                    $endtimevideo = '';
                } else {
                    $endtimevideo = '';
                }

                if (count($latestviews) <= 15) {
                    if (!empty($recomendeds)) {
                        // foreach($recomendeds as $category){
                        // if(in_array($category->categories_id, $categoryvideo)){
                        //  $recomended[] = $category;
                        $recomended = Video::select('videos.*', 'video_categories.name as categories_name', 'categoryvideos.category_id as categories_id')
                            ->Join('categoryvideos', 'videos.id', '=', 'categoryvideos.video_id')
                            ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
                            ->where('videos.id', '!=', $vid)
                            ->where('videos.active',  1)
                            ->where('videos.status',  1)
                            ->where('videos.draft',  1)
                            ->groupBy('videos.id')
                            ->limit(10)
                            ->get();

                        //  $recomended = array_unique($recomended, SORT_REGULAR);
                        // $endcardvideo[] = $category;
                        // $recomended = array_map("unserialize", array_unique(array_map("serialize", $recomended)));
                        // }
                        // }
                    } else {
                        $recomended = [];
                        //  $endcardvideo = [];
                    }
                } else {
                    $recomended = $latestviews;
                }

                if (!empty($recomended)) {
                    $recomended = $recomended;
                } else {
                    $recomended = [];
                }
                //  dd($recomended);
                $videocategory = [];

                $playerui = Playerui::first();
                $subtitle = MoviesSubtitles::where('movie_id', '=', $vid)->get();

                $wishlisted = false;
                if (!Auth::guest()):
                    $wishlisted = Wishlist::where('user_id', '=', Auth::user()->id)
                        ->where('video_id', '=', $vid)
                        ->where('type', '=', 'channel')
                        ->first();
                endif;
                $watchlater = false;

                if (!Auth::guest()):

                    $watchlater = Watchlater::where('user_id', '=', Auth::user()->id)
                        ->where('video_id', '=', $vid)
                        ->where('type', '=', 'channel')
                        ->first();

                    $like_dislike = LikeDislike::where('user_id', '=', Auth::user()->id)
                        ->where('video_id', '=', $vid)
                        ->get();
                else:

                  $watchlater = Watchlater::where('users_ip_address', $geoip->getIP() )->where('video_id', '=', $vid)
                            ->where('type', '=', 'channel')->first();

                  $like_dislike = LikeDislike::where('users_ip_address', $geoip->getIP())
                      ->where('video_id', '=', $vid)
                      ->get();

                endif;

                $ppv_video_play = [];

                $ppv_video = PpvPurchase::where('user_id', Auth::user()->id)
                    ->where('status', 'active')
                    ->get();
                $ppv_setting = Setting::first();
                $ppv_setting_hours = $ppv_setting->ppv_hours;

                if (!empty($ppv_video)) {
                    foreach ($ppv_video as $key => $value) {
                        $to_time = $value->to_time;

                        // $time = date('h:i:s', strtotime($date));
                        // $ppv_hours = date('Y-m-d h:i:s a',strtotime('+'.$ppv_setting_hours.' hour',strtotime($date)));
                        $d = new \DateTime('now');
                        $d->setTimezone(new \DateTimeZone('Asia/Kolkata'));
                        $now = $d->format('Y-m-d h:i:s a');

                        if ($to_time >= $now) {
                            if ($vid == $value->video_id) {
                                $ppv_video_play = $value;
                            } else {
                                $ppv_video_play = null;
                            }
                        } else {
                            PpvPurchase::where('video_id', $vid)->update(['status' => 'inactive']);
                        }
                        $purchased_video = Video::where('id', $value->video_id)->get();
                    }
                }

                $ads = AdsVideo::select('advertisements.*')
                    ->Join('advertisements', 'advertisements.id', '=', 'ads_videos.ads_id')
                    ->where('ads_videos.video_id', '=', $vid)
                    ->get();

                if (!empty($ads) && count($ads) > 0) {
                    $ads_path = $ads[0]->ads_path;
                } else {
                    $ads_path = '';
                }

                $payment_settings = PaymentSetting::first();

                $mode = $payment_settings->live_mode;
                if ($mode == 0) {
                    $secret_key = $payment_settings->test_secret_key;
                    $publishable_key = $payment_settings->test_publishable_key;
                } elseif ($mode == 1) {
                    $secret_key = $payment_settings->live_secret_key;
                    $publishable_key = $payment_settings->live_publishable_key;
                } else {
                    $secret_key = null;
                    $publishable_key = null;
                }

                $category_name = CategoryVideo::select('video_categories.name as categories_name','video_categories.slug as categories_slug')
                    ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
                    ->where('categoryvideos.video_id', $vid)
                    ->get();

                $langague_Name = Language::join('languagevideos', 'languages.id', '=', 'languagevideos.language_id')
                    ->where('video_id', $vid)
                    ->get();

                $release_year = Video::where('id', $vid)
                    ->pluck('year')
                    ->first();

                $Reels_videos = Video::Join('reelsvideo', 'reelsvideo.video_id', '=', 'videos.id')
                    ->where('videos.id', $vid)
                    ->get();

                if (!empty($categoryVideos->publish_time)) {
                    $new_date = Carbon::parse($categoryVideos->publish_time)->format('M d ,y H:i:s');
                    $currentdate = date('M d , y H:i:s');
                    date_default_timezone_set('Asia/Kolkata');
                    $current_date = Date('M d , y H:i:s');
                    $date = date_create($current_date);
                    $currentdate = date_format($date, 'M d ,y H:i:s');

                    $newdate = Carbon::parse($categoryVideos->publish_time)->format('m/d/y');

                    $current_date = date_format($date, 'm/d/y');


                    if ($current_date < $newdate) {
                        $new_date = Carbon::parse($categoryVideos->publish_time)->format('M d , y h:i:s a');
                    } else {
                        $new_date = null;
                    }
                } else {
                    $new_date = null;
                }

                if (@$categoryVideos->uploaded_by == 'Channel' && @$categoryVideos->access != 'guest') {
                    $user_id = $categoryVideos->user_id;

                    $user = Channel::where('channels.id', '=', $user_id)
                        ->join('users', 'channels.email', '=', 'users.email')
                        ->select('users.id as user_id')
                        ->first();

                    if (!Auth::guest() && @$user_id == Auth::user()->id) {
                        $video_access = 'free';
                    } else {
                        $video_access = 'pay';
                    }
                    // dd($video_access);
                } elseif (@$categoryVideos->uploaded_by == 'CPP' && @$categoryVideos->access != 'guest') {
                    $user_id = $categoryVideos->user_id;

                    $user = ModeratorsUser::where('moderators_users.id', '=', $user_id)
                        ->join('users', 'moderators_users.email', '=', 'users.email')
                        ->select('users.id as user_id')
                        ->first();
                    if (!Auth::guest() && @$user_id == Auth::user()->id) {
                        $video_access = 'free';
                    } else {
                        $video_access = 'pay';
                    }
                } else {
                    if ((!Auth::guest() && @$categoryVideos->access == 'ppv') || (@$categoryVideos->access == 'subscriber' && Auth::user()->role != 'admin')) {
                        $video_access = 'pay';
                    } else {
                        $video_access = 'free';
                    }
                }
                //  dd($recomended);
                // dd($video_access);

                $currency = CurrencySetting::first();
                $data = [
                    'video_access' => $video_access,
                    'currency' => $currency,
                    'video' => $categoryVideos,
                    'videocategory' => $videocategory,
                    'recomended' => $recomended,
                    'endtimevideo' => $endtimevideo,
                    'ads_path' => $ads_path,
                    'ppv_exist' => $ppv_exist,
                    'endcardvideo' => $endcardvideo,
                    'ppv_price' => 100,
                    'publishable_key' => $publishable_key,
                    'watchlatered' => $watchlater,
                    'mywishlisted' => $wishlisted,
                    'watched_time' => $watchtime,
                    'like_dislike' => $like_dislike,
                    'ppv_rent_price' => $ppv_rent_price,
                    'new_date' => $new_date,
                    'playerui_settings' => $playerui,
                    'subtitles' => $subtitle,
                    'artists' => $artists,
                    'ppv_video_play' => $ppv_video_play,
                    'ads' => \App\AdsVideo::where('video_id', $vid)->first(),
                    'category_name' => $category_name,
                    'langague_Name' => $langague_Name,
                    'release_year' => $release_year,
                    'Reels_videos' => $Reels_videos,
                    'genres_name' => $genres_name,
                    'artistsname' => $artistsname,
                    'lang_name' => $lang_name,
                    'subtitles_name' => $subtitles,
                    'ThumbnailSetting' => $ThumbnailSetting,
                    // 'latestviews' => $latestviews,
                    'source_id' => $source_id,
                    'commentable_type' => 'play_videos',
                    'Paystack_payment_settings' => PaymentSetting::where('payment_type', 'Paystack')->first(),
                    'Razorpay_payment_settings' => PaymentSetting::where('payment_type', 'Razorpay')->first(),
                    'CinetPay_payment_settings' => PaymentSetting::where('payment_type', 'CinetPay')->first(),
                ];
            } else {
                $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
                $userIp = $geoip->getip();
                $countryName = $geoip->getCountry();
                $regionName = $geoip->getregion();
                $cityName = $geoip->getcity();

                $regionview = RegionView::where('user_id', '=', Auth::User()->id)
                    ->where('video_id', '=', $vid)
                    ->orderBy('created_at', 'DESC')
                    ->whereDate('created_at', '>=', \Carbon\Carbon::now()->today())
                    ->first();

                if (!empty($regionview)) {
                    $regionview = RegionView::where('user_id', '=', Auth::User()->id)
                        ->where('video_id', '=', $vid)
                        ->orderBy('created_at', 'DESC')
                        ->whereDate('created_at', '>=', \Carbon\Carbon::now()->today())
                        ->delete();
                    $region = new RegionView();
                    $region->user_id = Auth::User()->id;
                    $region->user_ip = $userIp;
                    $region->video_id = $vid;
                    $region->countryname = $countryName;
                    $region->save();
                } else {
                    $region = new RegionView();
                    $region->user_id = Auth::User()->id;
                    $region->user_ip = $userIp;
                    $region->video_id = $vid;
                    $region->countryname = $countryName;
                    $region->save();
                }

                $categoryVideos = Video::with('category.categoryname')
                    ->where('id', $vid)
                    ->first();

                $category_name = CategoryVideo::select('video_categories.name as categories_name','video_categories.slug as categories_slug','categoryvideos.video_id')
                    ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
                    ->where('categoryvideos.video_id', $vid)
                    ->get();

                if (count($category_name) > 0) {
                    foreach ($category_name as $value) {
                        $vals[] = $value->categories_name;
                    }
                    $genres_name = implode(', ', $vals);
                } else {
                    $genres_name = 'No Genres Added';
                }

                $lang_name = LanguageVideo::select('languages.name as name')
                    ->Join('languages', 'languagevideos.language_id', '=', 'languages.id')
                    ->where('languagevideos.video_id', $vid)
                    ->get();

                if (count($lang_name) > 0) {
                    foreach ($lang_name as $value) {
                        $languagesvals[] = $value->name;
                    }
                    $lang_name = implode(',', $languagesvals);
                } else {
                    $lang_name = 'No Languages Added';
                }

                $artists_name = Videoartist::select('artists.artist_name as name')
                    ->Join('artists', 'video_artists.artist_id', '=', 'artists.id')
                    ->where('video_artists.video_id', $vid)
                    ->get();

                if (count($artists_name) > 0) {
                    foreach ($artists_name as $value) {
                        $artistsvals[] = $value->name;
                    }
                    $artistsname = implode(',', $artistsvals);
                } else {
                    $artistsname = 'No Starring  Added';
                }

                $subtitles_name = MoviesSubtitles::select('subtitles.language as language')
                    ->Join('subtitles', 'movies_subtitles.shortcode', '=', 'subtitles.short_code')
                    ->where('movies_subtitles.movie_id', $vid)
                    ->get();

                //  if(!empty($subtitles_name)){
                if (count($subtitles_name) > 0) {
                    foreach ($subtitles_name as $value) {
                        $subtitlesname[] = $value->language;
                    }
                    $subtitles = implode(', ', $subtitlesname);
                } else {
                    $subtitles = 'No Subtitles Added';
                }

                $categoryVideos = \App\Video::where('id', $vid)->first();
                $category_id = \App\Video::where('id', $vid)->pluck('video_category_id');
                // $recomended = \App\Video::where('video_category_id','=',$category_id)->where('id','!=',$vid)->limit(10)->get();
                $playerui = Playerui::first();
                $subtitle = MoviesSubtitles::where('movie_id', '=', $vid)->get();
                $currency = CurrencySetting::first();
                $category_id = CategoryVideo::where('video_id', $vid)->get();
                $categoryvideo = CategoryVideo::where('video_id', $vid)
                    ->pluck('category_id')
                    ->toArray();
                $languages_id = LanguageVideo::where('video_id', $vid)
                    ->pluck('language_id')
                    ->toArray();

                // Recomendeds And Endcard
                foreach ($category_id as $key => $value) {
                    $recomendeds = Video::select('videos.*', 'video_categories.name as categories_name', 'categoryvideos.category_id as categories_id')
                        ->Join('categoryvideos', 'videos.id', '=', 'categoryvideos.video_id')
                        ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
                        ->where('videos.id', '!=', $vid)
                        ->where('videos.active',  1)
                        ->where('videos.status',  1)
                        ->where('videos.draft',  1)
                        ->groupBy('videos.id')
                        ->limit(10)
                        ->get();

                    $endcardvideo = Video::select('videos.*', 'video_categories.name as categories_name', 'categoryvideos.category_id as categories_id')
                        ->Join('categoryvideos', 'videos.id', '=', 'categoryvideos.video_id')
                        ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
                        ->groupBy('videos.id')
                        ->where('videos.id', '!=', $vid)
                        ->limit(5)
                        ->get();
                }

                if (!Auth::guest()) {
                    $latestRecentView = RecentView::where('user_id', '!=', Auth::user()->id)
                        ->distinct()
                        ->limit(30)
                        ->pluck('video_id');
                    if (count($latestRecentView) > 10) {
                        $latestviews = [];
                    } else {
                        $latestviews = Video::select('videos.*', 'video_categories.name as categories_name', 'categoryvideos.category_id as categories_id')
                            ->Join('categoryvideos', 'videos.id', '=', 'categoryvideos.video_id')
                            ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
                            ->whereIn('videos.id', $latestRecentView)
                            ->groupBy('videos.id')
                            ->get();
                    }
                } else {
                    $latestRecentView = [];
                    $latestviews = [];
                    $recomendeds = $recomendeds;
                }

                $related_videos = Video::select('videos.*', 'related_videos.id as related_videos_id', 'related_videos.related_videos_title as related_videos_title')
                    ->Join('related_videos', 'videos.id', '=', 'related_videos.related_videos_id')
                    ->where('related_videos.video_id', '=', $vid)
                    ->limit(5)
                    ->get();

                if (count($related_videos) > 0) {
                    $endcardvideo = $related_videos;
                } elseif (!empty($endcardvideo)) {
                    $endcardvideo = $endcardvideo;
                } else {
                    $endcardvideo = [];
                }

                if ($get_video_id->type == 'mp4_url') {
                    // $ffprobe = FFProbe::create();
                    // $endtimevideos = $ffprobe->format($get_video_id->mp4_url) // extracts file informations
                    //    ->get('duration');
                    //    $endtimevideo = $endtimevideos - 5;
                    $endtimevideo = '';
                } elseif ($get_video_id->type == 'm3u8_url') {
                    // $ffprobe = FFProbe::create();
                    // $endtimevideos = $ffprobe->format($get_video_id->m3u8_url) // extracts file informations
                    //    ->get('duration');
                    //    $endtimevideo = $endtimevideos - 5;
                    $endtimevideo = '';
                } elseif ($get_video_id->type == '') {
                    // $ffprobe = FFProbe::create();
                    // $endtimevideos = $ffprobe->format($get_video_id->mp4_url) // extracts file informations
                    //    ->get('duration');
                    //    $endtimevideo = $endtimevideos - 5;
                    $endtimevideo = '';
                } else {
                    $endtimevideo = '';
                }

                if (count($latestviews) <= 15) {
                    if (!empty($recomendeds)) {
                        // foreach($recomendeds as $category){
                        // if(in_array($category->categories_id, $categoryvideo)){
                        //  $recomended[] = $category;
                        $recomended = Video::select('videos.*', 'video_categories.name as categories_name', 'categoryvideos.category_id as categories_id')
                            ->Join('categoryvideos', 'videos.id', '=', 'categoryvideos.video_id')
                            ->where('videos.id', '!=', $vid)
                            ->where('videos.active',  1)
                            ->where('videos.status',  1)
                            ->where('videos.draft',  1)
                            ->groupBy('videos.id')
                            ->limit(10)
                            ->get();

                        //  $recomended = array_unique($recomended, SORT_REGULAR);
                        // $endcardvideo[] = $category;
                        // $recomended = array_map("unserialize", array_unique(array_map("serialize", $recomended)));
                        // }
                        // }
                    } else {
                        $recomended = [];
                        //  $endcardvideo = [];
                    }
                } else {
                    $recomended = $latestviews;
                }

                if (!empty($recomended)) {
                    $recomended = $recomended;
                } else {
                    $recomended = [];
                }
                $category_name = CategoryVideo::select('video_categories.name as categories_name','video_categories.slug as categories_slug','categoryvideos.video_id')
                    ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
                    ->where('categoryvideos.video_id', $vid)
                    ->get();

                $langague_Name = Language::join('languagevideos', 'languages.id', '=', 'languagevideos.language_id')
                    ->where('video_id', $vid)
                    ->get();

                $release_year = Video::where('id', $vid)
                    ->pluck('year')
                    ->first();

                $Reels_videos = Video::where('id', $vid)
                    ->whereNotNull('reelvideo')
                    ->get();
                if (@$categoryVideos->uploaded_by == 'Channel' && @$categoryVideos->access != 'guest') {
                    $user_id = $categoryVideos->user_id;

                    $user = Channel::where('channels.id', '=', $user_id)
                        ->join('users', 'channels.email', '=', 'users.email')
                        ->select('users.id as user_id')
                        ->first();
                    if (!Auth::guest() && @$user_id == Auth::user()->id) {
                        $video_access = 'free';
                    } else {
                        $video_access = 'pay';
                    }
                } elseif (@$categoryVideos->uploaded_by == 'CPP' && @$categoryVideos->access != 'guest') {
                    $user_id = $categoryVideos->user_id;

                    $user = ModeratorsUser::where('moderators_users.id', '=', $user_id)
                        ->join('users', 'moderators_users.email', '=', 'users.email')
                        ->select('users.id as user_id')
                        ->first();
                    if (!Auth::guest() && @$user_id == Auth::user()->id) {
                        $video_access = 'free';
                    } else {
                        $video_access = 'pay';
                    }
                } else {
                    if ((!Auth::guest() && @$categoryVideos->access == 'ppv') || (@$categoryVideos->access == 'subscriber' && Auth::user()->role != 'admin')) {
                        $video_access = 'pay';
                    } else {
                        $video_access = 'free';
                    }
                }
                $data = [
                    'video_access' => $video_access,
                    'StorageSetting' => $StorageSetting,
                    'currency' => $currency,
                    'video' => $categoryVideos,
                    'recomended' => $recomended,
                    'playerui_settings' => $playerui,
                    'subtitles' => $subtitle,
                    'artists' => $artists,
                    'watched_time' => 0,
                    'ads' => \App\AdsVideo::where('video_id', $vid)->first(),
                    'category_name' => $category_name,
                    'langague_Name' => $langague_Name,
                    'release_year' => $release_year,
                    'Reels_videos' => $Reels_videos,
                    'ThumbnailSetting' => $ThumbnailSetting,
                    'genres_name' => $genres_name,
                    'artistsname' => $artistsname,
                    'lang_name' => $lang_name,
                    'subtitles_name' => $subtitles,
                    'source_id' => $source_id,
                    'commentable_type' => 'play_videos',
                    'Paystack_payment_settings' => PaymentSetting::where('payment_type', 'Paystack')->first(),
                    'Razorpay_payment_settings' => PaymentSetting::where('payment_type', 'Razorpay')->first(),
                    'CinetPay_payment_settings' => PaymentSetting::where('payment_type', 'CinetPay')->first(),
                ];
            }

            return Theme::view('video', $data);
        } else {
            $get_video_id = \App\Video::where('slug', $slug)->first();
            $vid = $get_video_id->id;
            $current_date = date('Y-m-d h:i:s a', time());
            $currency = CurrencySetting::first();

            $view_increment = $this->handleViewCount_movies($vid);

            if (!Auth::guest()) {
                $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
                $view = new RecentView();
                $view->video_id = $vid;
                $view->user_id = Auth::user()->id;
                $view->visited_at = date('Y-m-d');
                $view->save();
                $user_id = Auth::user()->id;
                $watch_id = ContinueWatching::where('user_id', '=', $user_id)
                    ->where('videoid', '=', $vid)
                    ->orderby('created_at', 'desc')
                    ->first();
                $watch_count = ContinueWatching::where('user_id', '=', $user_id)
                    ->where('videoid', '=', $vid)
                    ->orderby('created_at', 'desc')
                    ->count();

                if ($watch_count > 0) {
                    $watchtime = $watch_id->currentTime;
                } else {
                    $watchtime = 0;
                }

                $ppv_exist = PpvPurchase::where('video_id', $vid)
                    ->where('user_id', $user_id)
                    ->where('to_time', '>', $current_date)
                    ->count();
                $user_id = Auth::user()->id;

                $categoryVideos = \App\Video::where('id', $vid)->first();
                $category_id = \App\Video::where('id', $vid)->pluck('video_category_id');
                $videocategory = \App\VideoCategory::where('id', $category_id)->pluck('name');
                $videocategory = $videocategory[0];
                $recomended = \App\Video::where('video_category_id', '=', $category_id)
                    ->where('id', '!=', $vid)
                    ->limit(10)
                    ->get();
                $playerui = Playerui::first();
                $subtitle = MoviesSubtitles::where('movie_id', '=', 82)->get();

                $wishlisted = false;
                if (!Auth::guest()):
                    $wishlisted = Wishlist::where('user_id', '=', Auth::user()->id)
                        ->where('video_id', '=', $vid)
                        ->where('type', '=', 'channel')
                        ->first();
                endif;
                $watchlater = false;

                if (!Auth::guest()):

                    $watchlater = Watchlater::where('user_id', '=', Auth::user()->id)
                        ->where('video_id', '=', $vid)
                        ->where('type', '=', 'channel')
                        ->first();

                    $like_dislike = LikeDislike::where('user_id', '=', Auth::user()->id)
                        ->where('video_id', '=', $vid)
                        ->get();

                else:

                  $watchlater = Watchlater::where('users_ip_address', $geoip->getIP() )
                      ->where('video_id',  $vid)
                      ->where('type',  'channel')
                      ->first();

                  $like_dislike = LikeDislike::where('users_ip_address', $geoip->getIP() )
                      ->where('video_id',  $vid)
                      ->get();

                endif;

                $currency = CurrencySetting::first();

                $langague_Name = Language::join('languagevideos', 'languages.id', '=', 'languagevideos.language_id')
                    ->where('video_id', $vid)
                    ->get();

                $release_year = Video::where('id', $vid)
                    ->pluck('year')
                    ->first();

                $Reels_videos = Video::where('id', $vid)
                    ->whereNotNull('reelvideo')
                    ->get();

                $category_name =CategoryVideo::select('video_categories.name as categories_name','video_categories.slug as categories_slug')
                    ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
                    ->where('categoryvideos.video_id', $vid)
                    ->get();

                $categoryVideos = Video::with('category.categoryname')
                    ->where('id', $vid)
                    ->first();

                $category_name = CategoryVideo::select('video_categories.name as categories_name','video_categories.slug as categories_slug','categoryvideos.video_id')
                    ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
                    ->where('categoryvideos.video_id', $vid)
                    ->get();

                if (count($category_name) > 0) {
                    foreach ($category_name as $value) {
                        $vals[] = $value->categories_name;
                    }
                    $genres_name = implode(', ', $vals);
                } else {
                    $genres_name = 'No Genres Added';
                }

                $lang_name = LanguageVideo::select('languages.name as name')
                    ->Join('languages', 'languagevideos.language_id', '=', 'languages.id')
                    ->where('languagevideos.video_id', $vid)
                    ->get();

                if (count($lang_name) > 0) {
                    foreach ($lang_name as $value) {
                        $languagesvals[] = $value->name;
                    }
                    $lang_name = implode(',', $languagesvals);
                } else {
                    $lang_name = 'No Languages Added';
                }

                $artists_name = Videoartist::select('artists.artist_name as name')
                    ->Join('artists', 'video_artists.artist_id', '=', 'artists.id')
                    ->where('video_artists.video_id', $vid)
                    ->get();

                if (count($artists_name) > 0) {
                    foreach ($artists_name as $value) {
                        $artistsvals[] = $value->name;
                    }
                    $artistsname = implode(',', $artistsvals);
                } else {
                    $artistsname = 'No Starring  Added';
                }

                $subtitles_name = MoviesSubtitles::select('subtitles.language as language')
                    ->Join('subtitles', 'movies_subtitles.shortcode', '=', 'subtitles.short_code')
                    ->where('movies_subtitles.movie_id', $vid)
                    ->get();

                if (count($subtitles_name) > 0) {
                    foreach ($subtitles_name as $value) {
                        $subtitlesname[] = $value->language;
                    }
                    $subtitles = implode(', ', $subtitlesname);
                } else {
                    $subtitles = 'No Subtitles Added';
                }
                if (@$categoryVideos->uploaded_by == 'Channel' && @$categoryVideos->access != 'guest') {
                    $user_id = $categoryVideos->user_id;

                    $user = Channel::where('channels.id', '=', $user_id)
                        ->join('users', 'channels.email', '=', 'users.email')
                        ->select('users.id as user_id')
                        ->first();
                    if (!Auth::guest() && @$user_id == Auth::user()->id) {
                        $video_access = 'free';
                    } else {
                        $video_access = 'pay';
                    }
                } elseif (@$categoryVideos->uploaded_by == 'CPP' && @$categoryVideos->access != 'guest') {
                    $user_id = $categoryVideos->user_id;

                    $user = ModeratorsUser::where('moderators_users.id', '=', $user_id)
                        ->join('users', 'moderators_users.email', '=', 'users.email')
                        ->select('users.id as user_id')
                        ->first();
                    if (!Auth::guest() && @$user_id == Auth::user()->id) {
                        $video_access = 'free';
                    } else {
                        $video_access = 'pay';
                    }
                } else {
                    if ((!Auth::guest() && @$categoryVideos->access == 'ppv') || (@$categoryVideos->access == 'subscriber' && Auth::user()->role != 'admin')) {
                        $video_access = 'pay';
                    } else {
                        $video_access = 'free';
                    }
                }
                $data = [
                    'video_access' => $video_access,
                    'StorageSetting' => $StorageSetting,
                    'currency' => $currency,
                    'video' => $categoryVideos,
                    'videocategory' => $videocategory,
                    'recomended' => $recomended,
                    'ppv_exist' => $ppv_exist,
                    'ppv_price' => 100,
                    'watchlatered' => $watchlater,
                    'mywishlisted' => $wishlisted,
                    'watched_time' => $watchtime,
                    'like_dislike' => $like_dislike,
                    'playerui_settings' => $playerui,
                    'subtitles' => $subtitle,
                    'ads' => \App\AdsVideo::where('video_id', $vid)->first(),
                    'category_name' => $category_name,
                    'langague_Name' => $langague_Name,
                    'release_year' => $release_year,
                    'Reels_videos' => $Reels_videos,
                    'ThumbnailSetting' => $ThumbnailSetting,
                    'genres_name' => $genres_name,
                    'artistsname' => $artistsname,
                    'lang_name' => $lang_name,
                    'subtitles_name' => $subtitles,
                    'source_id' => $source_id,
                    'commentable_type' => 'play_videos',
                    'Paystack_payment_settings' => PaymentSetting::where('payment_type', 'Paystack')->first(),
                    'Razorpay_payment_settings' => PaymentSetting::where('payment_type', 'Razorpay')->first(),
                    'CinetPay_payment_settings' => PaymentSetting::where('payment_type', 'CinetPay')->first(),
                ];
            } else {
                $categoryVideos = \App\Video::where('id', $vid)->first();
                $category_id = \App\Video::where('id', $vid)->pluck('video_category_id');
                $recomended = \App\Video::where('video_category_id', '=', $category_id)
                    ->where('id', '!=', $vid)
                    ->limit(10)
                    ->get();
                $playerui = Playerui::first();
                $subtitle = MoviesSubtitles::where('movie_id', '=', $vid)->get();
                $currency = CurrencySetting::first();

                $langague_Name = Language::join('languagevideos', 'languages.id', '=', 'languagevideos.language_id')
                    ->where('video_id', $vid)
                    ->get();

                $release_year = Video::where('id', $vid)
                    ->pluck('year')
                    ->first();

                $Reels_videos = Video::where('id', $vid)
                    ->whereNotNull('reelvideo')
                    ->get();

                $category_name =CategoryVideo::select('video_categories.name as categories_name','video_categories.slug as categories_slug')
                    ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
                    ->where('categoryvideos.video_id', $vid)
                    ->get();

                $categoryVideos = Video::with('category.categoryname')
                    ->where('id', $vid)
                    ->first();

                $category_name = CategoryVideo::select('video_categories.name as categories_name','video_categories.slug as categories_slug','categoryvideos.video_id')
                    ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
                    ->where('categoryvideos.video_id', $vid)
                    ->get();

                if (count($category_name) > 0) {
                    foreach ($category_name as $value) {
                        $vals[] = $value->categories_name;
                    }
                    $genres_name = implode(', ', $vals);
                } else {
                    $genres_name = 'No Genres Added';
                }

                $lang_name = LanguageVideo::select('languages.name as name')
                    ->Join('languages', 'languagevideos.language_id', '=', 'languages.id')
                    ->where('languagevideos.video_id', $vid)
                    ->get();

                if (count($lang_name) > 0) {
                    foreach ($lang_name as $value) {
                        $languagesvals[] = $value->name;
                    }
                    $lang_name = implode(',', $languagesvals);
                } else {
                    $lang_name = 'No Languages Added';
                }

                $artists_name = Videoartist::select('artists.artist_name as name')
                    ->Join('artists', 'video_artists.artist_id', '=', 'artists.id')
                    ->where('video_artists.video_id', $vid)
                    ->get();

                if (count($artists_name) > 0) {
                    foreach ($artists_name as $value) {
                        $artistsvals[] = $value->name;
                    }
                    $artistsname = implode(',', $artistsvals);
                } else {
                    $artistsname = 'No Starring  Added';
                }

                $subtitles_name = MoviesSubtitles::select('subtitles.language as language')
                    ->Join('subtitles', 'movies_subtitles.shortcode', '=', 'subtitles.short_code')
                    ->where('movies_subtitles.movie_id', $vid)
                    ->get();

                if (count($subtitles_name) > 0) {
                    foreach ($subtitles_name as $value) {
                        $subtitlesname[] = $value->language;
                    }
                    $subtitles = implode(', ', $subtitlesname);
                } else {
                    $subtitles = 'No Subtitles Added';
                }
                $categoryVideos = \App\Video::where('id', $vid)->first();
                $category_id = \App\Video::where('id', $vid)->pluck('video_category_id');
                // $recomended = \App\Video::where('video_category_id','=',$category_id)->where('id','!=',$vid)->limit(10)->get();
                $playerui = Playerui::first();
                $subtitle = MoviesSubtitles::where('movie_id', '=', $vid)->get();
                $currency = CurrencySetting::first();
                $category_id = CategoryVideo::where('video_id', $vid)->get();
                $categoryvideo = CategoryVideo::where('video_id', $vid)
                    ->pluck('category_id')
                    ->toArray();
                $languages_id = LanguageVideo::where('video_id', $vid)
                    ->pluck('language_id')
                    ->toArray();

                // Recomendeds And Endcard
                foreach ($category_id as $key => $value) {
                    $recomendeds = Video::select('videos.*', 'video_categories.name as categories_name', 'categoryvideos.category_id as categories_id')
                        ->Join('categoryvideos', 'videos.id', '=', 'categoryvideos.video_id')
                        ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
                        ->where('videos.id', '!=', $vid)
                        ->where('videos.active',  1)
                        ->where('videos.status',  1)
                        ->where('videos.draft',  1)
                        ->groupBy('videos.id')
                        ->limit(10)
                        ->get();

                    $endcardvideo = Video::select('videos.*', 'video_categories.name as categories_name', 'categoryvideos.category_id as categories_id')
                        ->Join('categoryvideos', 'videos.id', '=', 'categoryvideos.video_id')
                        ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
                        ->where('videos.id', '!=', $vid)
                        ->limit(5)
                        ->get();
                }

                if (!Auth::guest()) {
                    $latestRecentView = RecentView::where('user_id', '!=', Auth::user()->id)
                        ->distinct()
                        ->limit(30)
                        ->pluck('video_id');
                    if (count($latestRecentView) > 10) {
                        $latestviews = [];
                    } else {
                        $latestviews = Video::select('videos.*', 'video_categories.name as categories_name', 'categoryvideos.category_id as categories_id')
                            ->Join('categoryvideos', 'videos.id', '=', 'categoryvideos.video_id')
                            ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
                            ->whereIn('videos.id', $latestRecentView)
                            ->groupBy('videos.id')
                            ->get();
                    }
                } else {
                    $latestRecentView = [];
                    $latestviews = [];
                    $recomendeds = $recomendeds;
                }

                $related_videos = Video::select('videos.*', 'related_videos.id as related_videos_id', 'related_videos.related_videos_title as related_videos_title')
                    ->Join('related_videos', 'videos.id', '=', 'related_videos.related_videos_id')
                    ->where('related_videos.video_id', '=', $vid)
                    ->limit(5)
                    ->get();

                if (count($related_videos) > 0) {
                    $endcardvideo = $related_videos;
                } elseif (!empty($endcardvideo)) {
                    $endcardvideo = $endcardvideo;
                } else {
                    $endcardvideo = [];
                }

                if ($get_video_id->type == 'mp4_url') {
                    // $ffprobe = FFProbe::create();
                    // $endtimevideos = $ffprobe->format($get_video_id->mp4_url) // extracts file informations
                    //    ->get('duration');
                    //    $endtimevideo = $endtimevideos - 5;
                    $endtimevideo = '';
                } elseif ($get_video_id->type == 'm3u8_url') {
                    // $ffprobe = FFProbe::create();
                    // $endtimevideos = $ffprobe->format($get_video_id->m3u8_url) // extracts file informations
                    //    ->get('duration');
                    //    $endtimevideo = $endtimevideos - 5;
                    $endtimevideo = '';
                } elseif ($get_video_id->type == '') {
                    // $ffprobe = FFProbe::create();
                    // $endtimevideos = $ffprobe->format($get_video_id->mp4_url) // extracts file informations
                    //    ->get('duration');
                    //    $endtimevideo = $endtimevideos - 5;
                    $endtimevideo = '';
                } else {
                    $endtimevideo = '';
                }

                if (count($latestviews) <= 15) {
                    if (!empty($recomendeds)) {
                        // foreach($recomendeds as $category){
                        // if(in_array($category->categories_id, $categoryvideo)){
                        //  $recomended[] = $category;
                        $recomended = Video::select('videos.*', 'video_categories.name as categories_name', 'categoryvideos.category_id as categories_id')
                            ->Join('categoryvideos', 'videos.id', '=', 'categoryvideos.video_id')
                            ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
                            ->where('videos.id', '!=', $vid)
                            ->where('videos.active',  1)
                            ->where('videos.status',  1)
                            ->where('videos.draft',  1)
                            ->groupBy('videos.id')
                            ->limit(10)
                            ->get();

                        //  $recomended = array_unique($recomended, SORT_REGULAR);
                        // $endcardvideo[] = $category;
                        // $recomended = array_map("unserialize", array_unique(array_map("serialize", $recomended)));
                        // }
                        // }
                    } else {
                        $recomended = [];
                        //  $endcardvideo = [];
                    }
                } else {
                    $recomended = $latestviews;
                }

                if (!empty($recomended)) {
                    $recomended = $recomended;
                } else {
                    $recomended = [];
                }
                $artistscount = Videoartist::join('artists', 'video_artists.artist_id', '=', 'artists.id')
                    ->select('artists.*')
                    ->where('video_artists.video_id', '=', $vid)
                    ->count();

                if ($artistscount > 0) {
                    $artists = Videoartist::join('artists', 'video_artists.artist_id', '=', 'artists.id')
                        ->select('artists.*')
                        ->where('video_artists.video_id', '=', $vid)
                        ->get();
                } else {
                    $artists = [];
                }
                $Reels_videos = Video::Join('reelsvideo', 'reelsvideo.video_id', '=', 'videos.id')
                    ->where('videos.id', $vid)
                    ->get();
                if (@$categoryVideos->uploaded_by == 'Channel' && @$categoryVideos->access != 'guest') {
                    $user_id = $categoryVideos->user_id;

                    $user = Channel::where('channels.id', '=', $user_id)
                        ->join('users', 'channels.email', '=', 'users.email')
                        ->select('users.id as user_id')
                        ->first();
                    if (!Auth::guest() && @$user_id == Auth::user()->id) {
                        $video_access = 'free';
                    } else {
                        $video_access = 'pay';
                    }
                } elseif (@$categoryVideos->uploaded_by == 'CPP' && @$categoryVideos->access != 'guest') {
                    $user_id = $categoryVideos->user_id;

                    $user = ModeratorsUser::where('moderators_users.id', '=', $user_id)
                        ->join('users', 'moderators_users.email', '=', 'users.email')
                        ->select('users.id as user_id')
                        ->first();
                    if (!Auth::guest() && @$user_id == Auth::user()->id) {
                        $video_access = 'free';
                    } else {
                        $video_access = 'pay';
                    }
                } else {
                    if (!Auth::guest() && @$categoryVideos->access == 'ppv' && Auth::user()->role != 'admin') {
                        $video_access = 'pay';
                    } else {
                        $video_access = 'free';
                    }
                }

                if (!Auth::guest()):

                    $watchlater = Watchlater::where('user_id', '=', Auth::user()->id)
                        ->where('video_id', '=', $vid)
                        ->where('type', '=', 'channel')
                        ->first();
  
                    $like_dislike = LikeDislike::where('user_id', '=', Auth::user()->id)
                        ->where('video_id', '=', $vid)
                        ->get();
                  else:
  
                    $watchlater = Watchlater::where('users_ip_address', $geoip->getIP() )->where('video_id', '=', $vid)
                            ->where('type', '=', 'channel')->first();
  
                    $like_dislike = LikeDislike::where('users_ip_address', $geoip->getIP())
                      ->where('video_id', $vid)
                      ->get();
  
                  endif;

                $data = [
                    'video_access' => $video_access,
                    'StorageSetting' => $StorageSetting,
                    'currency' => $currency,
                    'video' => $categoryVideos,
                    'recomended' => $recomended,
                    'playerui_settings' => $playerui,
                    'subtitles' => $subtitle,
                    'watched_time' => 0,
                    'like_dislike'  => $like_dislike ,
                    'ads' => \App\AdsVideo::where('video_id', $vid)->first(),
                    'category_name' => $category_name,
                    'langague_Name' => $langague_Name,
                    'release_year' => $release_year,
                    'Reels_videos' => $Reels_videos,
                    'ThumbnailSetting' => $ThumbnailSetting,
                    'genres_name' => $genres_name,
                    'artistsname' => $artistsname,
                    'lang_name' => $lang_name,
                    'subtitles_name' => $subtitles,
                    'artists' => $artists,
                    'source_id' => $source_id,
                    'commentable_type' => 'play_videos',
                    'Paystack_payment_settings' => PaymentSetting::where('payment_type', 'Paystack')->first(),
                    'Razorpay_payment_settings' => PaymentSetting::where('payment_type', 'Razorpay')->first(),
                    'CinetPay_payment_settings' => PaymentSetting::where('payment_type', 'CinetPay')->first(),
                ];
            }
            return Theme::view('video_before_login', $data);
        }
    }

    public function fullplayer_videos($slug)
    {
        $data['password_hash'] = '';
        $data = session()->all();
        $getfeching = \App\Geofencing::first();
        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
        $userIp = $geoip->getip();
        $countryName = $geoip->getCountry();
        $cityName = $geoip->getcity();
        $stateName = $geoip->getregion();
        $ThumbnailSetting = ThumbnailSetting::first();

        if (!Auth::guest()) {
            $get_video_id = \App\Video::where('slug', $slug)->first();
            try {
                $vid = $get_video_id->id;
            } catch (\Throwable $th) {
                return abort(404);
            }

            $artistscount = Videoartist::join('artists', 'video_artists.artist_id', '=', 'artists.id')
                ->select('artists.*')
                ->where('video_artists.video_id', '=', $vid)
                ->count();

            if ($artistscount > 0) {
                $artists = Videoartist::join('artists', 'video_artists.artist_id', '=', 'artists.id')
                    ->select('artists.*')
                    ->where('video_artists.video_id', '=', $vid)
                    ->get();
            } else {
                $artists = [];
            }

            $PPV_settings = Setting::where('ppv_status', '=', 1)->first();

            if (!empty($PPV_settings)) {
                $ppv_rent_price = $PPV_settings->ppv_price;
            } else {
                $Video_ppv = Video::where('id', '=', $vid)->first();
                $ppv_rent_price = null;

                if ($Video_ppv->ppv_price != '') {
                    $ppv_rent_price = $Video_ppv->ppv_price;
                } else {
                    $ppv_rent_price = $Video_ppv->ppv_price;
                }
            }

            $current_date = date('Y-m-d h:i:s a', time());
            $view_increment = $this->handleViewCount_movies($vid);

            if (!Auth::guest()) {
                $sub_user = Session::get('subuser_id');

                $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
                $userIp = $geoip->getip();
                $countryName = $geoip->getCountry();
                $regionName = $geoip->getregion();
                $cityName = $geoip->getcity();

                $view = new RecentView();
                $view->video_id = $vid;
                $view->user_id = Auth::user()->id;
                $view->country_name = $countryName;
                if ($sub_user != null) {
                    $view->sub_user = $sub_user;
                }
                $view->visited_at = date('Y-m-d');
                $view->save();

                $regionview = RegionView::where('user_id', '=', Auth::User()->id)
                    ->where('video_id', '=', $vid)
                    ->orderBy('created_at', 'DESC')
                    ->whereDate('created_at', '>=', \Carbon\Carbon::now()->today())
                    ->first();

                if (!empty($regionview)) {
                    $regionview = RegionView::where('user_id', '=', Auth::User()->id)
                        ->where('video_id', '=', $vid)
                        ->orderBy('created_at', 'DESC')
                        ->whereDate('created_at', '>=', \Carbon\Carbon::now()->today())
                        ->delete();
                    $region = new RegionView();
                    $region->user_id = Auth::User()->id;
                    $region->user_ip = $userIp;
                    $region->video_id = $vid;
                    $region->countryname = $countryName;
                    $region->save();
                } else {
                    $region = new RegionView();
                    $region->user_id = Auth::User()->id;
                    $region->user_ip = $userIp;
                    $region->video_id = $vid;
                    $region->countryname = $countryName;
                    $region->save();
                }

                $user_id = Auth::user()->id;
                $watch_id = ContinueWatching::where('user_id', '=', $user_id)
                    ->where('videoid', '=', $vid)
                    ->orderby('created_at', 'desc')
                    ->first();
                $watch_count = ContinueWatching::where('user_id', '=', $user_id)
                    ->where('videoid', '=', $vid)
                    ->orderby('created_at', 'desc')
                    ->count();

                if ($watch_count > 0) {
                    $watchtime = $watch_id->currentTime;
                } else {
                    $watchtime = 0;
                }

                $ppvexist = PpvPurchase::where('video_id', $vid)
                    ->where('user_id', $user_id)
                    ->count();

                $ppv_video = PpvPurchase::where('video_id', $vid)
                    ->where('user_id', $user_id)
                    ->first();

                $user_id = Auth::user()->id;

                if ($ppvexist > 0 && $ppv_video->view_count > 0 && $ppv_video->view_count != null) {
                    $ppv_exist = PpvPurchase::where('video_id', $vid)
                        ->where('user_id', $user_id)
                        ->where('status', 'active')
                        ->where('to_time', '>', $current_date)
                        ->count();
                } elseif ($ppvexist > 0 && $ppv_video->view_count == null) {
                    $ppv_exist = PpvPurchase::where('video_id', $vid)
                        ->where('user_id', $user_id)
                        ->count();
                } else {
                    $ppv_exist = 0;
                }

                $categoryVideos = Video::with('category.categoryname')
                    ->where('id', $vid)
                    ->first();

                $category_name = CategoryVideo::select('video_categories.name as categories_name','video_categories.slug as categories_slug','categoryvideos.video_id')
                    ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
                    ->where('categoryvideos.video_id', $vid)
                    ->get();

                if (count($category_name) > 0) {
                    foreach ($category_name as $value) {
                        $vals[] = $value->categories_name;
                    }
                    $genres_name = implode(', ', $vals);
                } else {
                    $genres_name = 'No Genres Added';
                }

                $lang_name = LanguageVideo::select('languages.name as name')
                    ->Join('languages', 'languagevideos.language_id', '=', 'languages.id')
                    ->where('languagevideos.video_id', $vid)
                    ->get();

                if (count($lang_name) > 0) {
                    foreach ($lang_name as $value) {
                        $languagesvals[] = $value->name;
                    }
                    $lang_name = implode(',', $languagesvals);
                } else {
                    $lang_name = 'No Languages Added';
                }

                $artists_name = Videoartist::select('artists.artist_name as name')
                    ->Join('artists', 'video_artists.artist_id', '=', 'artists.id')
                    ->where('video_artists.video_id', $vid)
                    ->get();

                if (count($artists_name) > 0) {
                    foreach ($artists_name as $value) {
                        $artistsvals[] = $value->name;
                    }
                    $artistsname = implode(',', $artistsvals);
                } else {
                    $artistsname = 'No Starring  Added';
                }

                $subtitles_name = MoviesSubtitles::select('subtitles.language as language')
                    ->Join('subtitles', 'movies_subtitles.shortcode', '=', 'subtitles.short_code')
                    ->where('movies_subtitles.movie_id', $vid)
                    ->get();

                if (count($subtitles_name) > 0) {
                    foreach ($subtitles_name as $value) {
                        $subtitlesname[] = $value->language;
                    }
                    $subtitles = implode(', ', $subtitlesname);
                } else {
                    $subtitles = 'No Subtitles Added';
                }

                $category_id = CategoryVideo::where('video_id', $vid)->get();
                $categoryvideo = CategoryVideo::where('video_id', $vid)
                    ->pluck('category_id')
                    ->toArray();
                $languages_id = LanguageVideo::where('video_id', $vid)
                    ->pluck('language_id')
                    ->toArray();

                // Recomendeds And Endcard
                foreach ($category_id as $key => $value) {
                    $recomendeds = Video::select('videos.*', 'video_categories.name as categories_name', 'categoryvideos.category_id as categories_id')
                        ->Join('categoryvideos', 'videos.id', '=', 'categoryvideos.video_id')
                        ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
                        ->where('videos.id', '!=', $vid)
                        ->where('videos.active',  1)
                        ->where('videos.status',  1)
                        ->where('videos.draft',  1)
                        ->limit(10)
                        ->get();

                    $endcardvideo = Video::select('videos.*', 'video_categories.name as categories_name', 'categoryvideos.category_id as categories_id')
                        ->Join('categoryvideos', 'videos.id', '=', 'categoryvideos.video_id')
                        ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
                        ->where('videos.id', '!=', $vid)
                        ->limit(5)
                        ->get();
                }

                if (!Auth::guest()) {
                    $latestRecentView = RecentView::where('user_id', '!=', Auth::user()->id)
                        ->distinct()
                        ->limit(30)
                        ->pluck('video_id');
                    if (count($latestRecentView) > 10) {
                        $latestviews = [];
                    } else {
                        $latestviews = Video::select('videos.*', 'video_categories.name as categories_name', 'categoryvideos.category_id as categories_id')
                            ->Join('categoryvideos', 'videos.id', '=', 'categoryvideos.video_id')
                            ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
                            ->whereIn('videos.id', $latestRecentView)
                            ->groupBy('videos.id')
                            ->get();
                    }
                } else {
                    $latestRecentView = [];
                    $latestviews = [];
                    $recomendeds = $recomendeds;
                }

                $related_videos = Video::select('videos.*', 'related_videos.id as related_videos_id', 'related_videos.related_videos_title as related_videos_title')
                    ->Join('related_videos', 'videos.id', '=', 'related_videos.related_videos_id')
                    ->where('related_videos.video_id', '=', $vid)
                    ->limit(5)
                    ->get();

                if (count($related_videos) > 0) {
                    $endcardvideo = $related_videos;
                } elseif (!empty($endcardvideo)) {
                    $endcardvideo = $endcardvideo;
                } else {
                    $endcardvideo = [];
                }

                if ($get_video_id->type == 'mp4_url') {
                    $endtimevideo = '';
                } elseif ($get_video_id->type == 'm3u8_url') {
                    $endtimevideo = '';
                } elseif ($get_video_id->type == '') {
                    $endtimevideo = '';
                } else {
                    $endtimevideo = '';
                }

                if (count($latestviews) <= 15) {
                    if (!empty($recomendeds)) {
                        $recomended = Video::select('videos.*', 'video_categories.name as categories_name', 'categoryvideos.category_id as categories_id')
                            ->Join('categoryvideos', 'videos.id', '=', 'categoryvideos.video_id')
                            ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
                            ->where('videos.id', '!=', $vid)
                            ->where('videos.active',  1)
                            ->where('videos.status',  1)
                            ->where('videos.draft',  1)
                            ->groupBy('videos.id')
                            ->limit(10)
                            ->get();
                    } else {
                        $recomended = [];
                    }
                } else {
                    $recomended = $latestviews;
                }

                if (!empty($recomended)) {
                    $recomended = $recomended;
                } else {
                    $recomended = [];
                }

                $videocategory = [];

                $playerui = Playerui::first();
                $subtitle = MoviesSubtitles::where('movie_id', '=', $vid)->get();

                $wishlisted = false;
                if (!Auth::guest()):
                    $wishlisted = Wishlist::where('user_id', '=', Auth::user()->id)
                        ->where('video_id', '=', $vid)
                        ->where('type', '=', 'channel')
                        ->first();
                endif;
                $watchlater = false;
                if (!Auth::guest()):
                    $watchlater = Watchlater::where('user_id', '=', Auth::user()->id)
                        ->where('video_id', '=', $vid)
                        ->where('type', '=', 'channel')
                        ->first();
                    $like_dislike = LikeDislike::where('user_id', '=', Auth::user()->id)
                        ->where('video_id', '=', $vid)
                        ->get();
                endif;

                $ppv_video_play = [];

                $ppv_video = PpvPurchase::where('user_id', Auth::user()->id)
                    ->where('status', 'active')
                    ->get();
                $ppv_setting = Setting::first();
                $ppv_setting_hours = $ppv_setting->ppv_hours;

                if (!empty($ppv_video)) {
                    foreach ($ppv_video as $key => $value) {
                        $to_time = $value->to_time;

                        $d = new \DateTime('now');
                        $d->setTimezone(new \DateTimeZone('Asia/Kolkata'));
                        $now = $d->format('Y-m-d h:i:s a');

                        if ($to_time >= $now) {
                            if ($vid == $value->video_id) {
                                $ppv_video_play = $value;
                            } else {
                                $ppv_video_play = null;
                            }
                        } else {
                            PpvPurchase::where('video_id', $vid)->update(['status' => 'inactive']);
                        }
                        $purchased_video = Video::where('id', $value->video_id)->get();
                    }
                }

                $ads = AdsVideo::select('advertisements.*')
                    ->Join('advertisements', 'advertisements.id', '=', 'ads_videos.ads_id')
                    ->where('ads_videos.video_id', '=', $vid)
                    ->get();

                if (!empty($ads) && count($ads) > 0) {
                    $ads_path = $ads[0]->ads_path;
                } else {
                    $ads_path = '';
                }

                $payment_settings = PaymentSetting::first();

                $mode = $payment_settings->live_mode;
                if ($mode == 0) {
                    $secret_key = $payment_settings->test_secret_key;
                    $publishable_key = $payment_settings->test_publishable_key;
                } elseif ($mode == 1) {
                    $secret_key = $payment_settings->live_secret_key;
                    $publishable_key = $payment_settings->live_publishable_key;
                } else {
                    $secret_key = null;
                    $publishable_key = null;
                }

                $category_name = CategoryVideo::select('video_categories.name as categories_name','video_categories.slug as categories_slug','categoryvideos.video_id')
                    ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
                    ->where('categoryvideos.video_id', $vid)
                    ->get();

                $langague_Name = Language::join('languagevideos', 'languages.id', '=', 'languagevideos.language_id')
                    ->where('video_id', $vid)
                    ->get();

                $release_year = Video::where('id', $vid)
                    ->pluck('year')
                    ->first();

                $Reels_videos = Video::Join('reelsvideo', 'reelsvideo.video_id', '=', 'videos.id')
                    ->where('videos.id', $vid)
                    ->get();

                if (!empty($categoryVideos->publish_time)) {
                    $new_date = Carbon::parse($categoryVideos->publish_time)->format('M d ,y H:i:s');
                    $currentdate = date('M d , y H:i:s');
                    date_default_timezone_set('Asia/Kolkata');
                    $current_date = Date('M d , y H:i:s');
                    $date = date_create($current_date);
                    $currentdate = date_format($date, 'M d ,y H:i:s');
                    $newdate = Carbon::parse($categoryVideos->publish_time)->format('m/d/y');
                    $current_date = date_format($date, 'm/d/y');

                    if ($current_date < $newdate) {
                        $new_date = Carbon::parse($categoryVideos->publish_time)->format('M d , y h:i:s a');
                    } else {
                        $new_date = null;
                    }
                } else {
                    $new_date = null;
                }
                
                $currency = CurrencySetting::first();
                $data = [
                    'currency' => $currency,
                    'video' => $categoryVideos,
                    'videocategory' => $videocategory,
                    'recomended' => $recomended,
                    'endtimevideo' => $endtimevideo,
                    'ads_path' => $ads_path,
                    'ppv_exist' => $ppv_exist,
                    'endcardvideo' => $endcardvideo,
                    'ppv_price' => 100,
                    'publishable_key' => $publishable_key,
                    'watchlatered' => $watchlater,
                    'mywishlisted' => $wishlisted,
                    'watched_time' => $watchtime,
                    'like_dislike' => $like_dislike,
                    'ppv_rent_price' => $ppv_rent_price,
                    'new_date' => $new_date,
                    'playerui_settings' => $playerui,
                    'subtitles' => $subtitle,
                    'artists' => $artists,
                    'ppv_video_play' => $ppv_video_play,
                    'ads' => \App\AdsVideo::where('video_id', $vid)->first(),
                    'category_name' => $category_name,
                    'langague_Name' => $langague_Name,
                    'release_year' => $release_year,
                    'Reels_videos' => $Reels_videos,
                    'genres_name' => $genres_name,
                    'artistsname' => $artistsname,
                    'lang_name' => $lang_name,
                    'subtitles_name' => $subtitles,
                    'ThumbnailSetting' => $ThumbnailSetting,
                ];
            } else {
                $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
                $userIp = $geoip->getip();
                $countryName = $geoip->getCountry();
                $regionName = $geoip->getregion();
                $cityName = $geoip->getcity();

                $regionview = RegionView::where('user_id', '=', Auth::User()->id)
                    ->where('video_id', '=', $vid)
                    ->orderBy('created_at', 'DESC')
                    ->whereDate('created_at', '>=', \Carbon\Carbon::now()->today())
                    ->first();

                if (!empty($regionview)) {
                    $regionview = RegionView::where('user_id', '=', Auth::User()->id)
                        ->where('video_id', '=', $vid)
                        ->orderBy('created_at', 'DESC')
                        ->whereDate('created_at', '>=', \Carbon\Carbon::now()->today())
                        ->delete();
                    $region = new RegionView();
                    $region->user_id = Auth::User()->id;
                    $region->user_ip = $userIp;
                    $region->video_id = $vid;
                    $region->countryname = $countryName;
                    $region->save();
                } else {
                    $region = new RegionView();
                    $region->user_id = Auth::User()->id;
                    $region->user_ip = $userIp;
                    $region->video_id = $vid;
                    $region->countryname = $countryName;
                    $region->save();
                }

                $categoryVideos = Video::with('category.categoryname')
                    ->where('id', $vid)
                    ->first();

                $category_name = CategoryVideo::select('video_categories.name as categories_name','video_categories.slug as categories_slug','categoryvideos.video_id')
                    ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
                    ->where('categoryvideos.video_id', $vid)
                    ->get();

                if (count($category_name) > 0) {
                    foreach ($category_name as $value) {
                        $vals[] = $value->categories_name;
                    }
                    $genres_name = implode(', ', $vals);
                } else {
                    $genres_name = 'No Genres Added';
                }

                $lang_name = LanguageVideo::select('languages.name as name')
                    ->Join('languages', 'languagevideos.language_id', '=', 'languages.id')
                    ->where('languagevideos.video_id', $vid)
                    ->get();

                if (count($lang_name) > 0) {
                    foreach ($lang_name as $value) {
                        $languagesvals[] = $value->name;
                    }
                    $lang_name = implode(',', $languagesvals);
                } else {
                    $lang_name = 'No Languages Added';
                }

                $artists_name = Videoartist::select('artists.artist_name as name')
                    ->Join('artists', 'video_artists.artist_id', '=', 'artists.id')
                    ->where('video_artists.video_id', $vid)
                    ->get();

                if (count($artists_name) > 0) {
                    foreach ($artists_name as $value) {
                        $artistsvals[] = $value->name;
                    }
                    $artistsname = implode(',', $artistsvals);
                } else {
                    $artistsname = 'No Starring  Added';
                }

                $subtitles_name = MoviesSubtitles::select('subtitles.language as language')
                    ->Join('subtitles', 'movies_subtitles.shortcode', '=', 'subtitles.short_code')
                    ->where('movies_subtitles.movie_id', $vid)
                    ->get();

                if (count($subtitles_name) > 0) {
                    foreach ($subtitles_name as $value) {
                        $subtitlesname[] = $value->language;
                    }
                    $subtitles = implode(', ', $subtitlesname);
                } else {
                    $subtitles = 'No Subtitles Added';
                }

                $categoryVideos = \App\Video::where('id', $vid)->first();
                $category_id = \App\Video::where('id', $vid)->pluck('video_category_id');
                // $recomended = \App\Video::where('video_category_id','=',$category_id)->where('id','!=',$vid)->limit(10)->get();
                $playerui = Playerui::first();
                $subtitle = MoviesSubtitles::where('movie_id', '=', $vid)->get();
                $currency = CurrencySetting::first();
                $category_id = CategoryVideo::where('video_id', $vid)->get();
                $categoryvideo = CategoryVideo::where('video_id', $vid)
                    ->pluck('category_id')
                    ->toArray();
                $languages_id = LanguageVideo::where('video_id', $vid)
                    ->pluck('language_id')
                    ->toArray();

                // Recomendeds And Endcard
                foreach ($category_id as $key => $value) {
                    $recomendeds = Video::select('videos.*', 'video_categories.name as categories_name', 'categoryvideos.category_id as categories_id')
                        ->Join('categoryvideos', 'videos.id', '=', 'categoryvideos.video_id')
                        ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
                        ->where('videos.id', '!=', $vid)
                        ->where('videos.active',  1)
                        ->where('videos.status',  1)
                        ->where('videos.draft',  1)
                        ->groupBy('videos.id')
                        ->limit(10)
                        ->get();

                    $endcardvideo = Video::select('videos.*', 'video_categories.name as categories_name', 'categoryvideos.category_id as categories_id')
                        ->Join('categoryvideos', 'videos.id', '=', 'categoryvideos.video_id')
                        ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
                        ->groupBy('videos.id')
                        ->where('videos.id', '!=', $vid)
                        ->limit(5)
                        ->get();
                }

                if (!Auth::guest()) {
                    $latestRecentView = RecentView::where('user_id', '!=', Auth::user()->id)
                        ->distinct()
                        ->limit(30)
                        ->pluck('video_id');
                    if (count($latestRecentView) > 10) {
                        $latestviews = [];
                    } else {
                        $latestviews = Video::select('videos.*', 'video_categories.name as categories_name', 'categoryvideos.category_id as categories_id')
                            ->Join('categoryvideos', 'videos.id', '=', 'categoryvideos.video_id')
                            ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
                            ->whereIn('videos.id', $latestRecentView)
                            ->groupBy('videos.id')
                            ->get();
                    }
                } else {
                    $latestRecentView = [];
                    $latestviews = [];
                    $recomendeds = $recomendeds;
                }

                $related_videos = Video::select('videos.*', 'related_videos.id as related_videos_id', 'related_videos.related_videos_title as related_videos_title')
                    ->Join('related_videos', 'videos.id', '=', 'related_videos.related_videos_id')
                    ->where('related_videos.video_id', '=', $vid)
                    ->limit(5)
                    ->get();

                if (count($related_videos) > 0) {
                    $endcardvideo = $related_videos;
                } elseif (!empty($endcardvideo)) {
                    $endcardvideo = $endcardvideo;
                } else {
                    $endcardvideo = [];
                }

                if ($get_video_id->type == 'mp4_url') {
                    $endtimevideo = '';
                } elseif ($get_video_id->type == 'm3u8_url') {
                    $endtimevideo = '';
                } elseif ($get_video_id->type == '') {
                    $endtimevideo = '';
                } else {
                    $endtimevideo = '';
                }

                if (count($latestviews) <= 15) {
                    if (!empty($recomendeds)) {
                        $recomended = Video::select('videos.*', 'video_categories.name as categories_name', 'categoryvideos.category_id as categories_id')
                            ->Join('categoryvideos', 'videos.id', '=', 'categoryvideos.video_id')
                            ->where('videos.id', '!=', $vid)
                            ->where('videos.active',  1)
                            ->where('videos.status',  1)
                            ->where('videos.draft',  1)
                            ->groupBy('videos.id')
                            ->limit(10)
                            ->get();
                    } else {
                        $recomended = [];
                    }
                } else {
                    $recomended = $latestviews;
                }

                if (!empty($recomended)) {
                    $recomended = $recomended;
                } else {
                    $recomended = [];
                }

                $category_name = CategoryVideo::select('video_categories.name as categories_name','video_categories.slug as categories_slug','categoryvideos.video_id')
                    ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
                    ->where('categoryvideos.video_id', $vid)
                    ->get();

                $langague_Name = Language::join('languagevideos', 'languages.id', '=', 'languagevideos.language_id')
                    ->where('video_id', $vid)
                    ->get();

                $release_year = Video::where('id', $vid)
                    ->pluck('year')
                    ->first();

                $Reels_videos = Video::where('id', $vid)
                    ->whereNotNull('reelvideo')
                    ->get();

                $data = [
                    'currency' => $currency,
                    'video' => $categoryVideos,
                    'recomended' => $recomended,
                    'playerui_settings' => $playerui,
                    'subtitles' => $subtitle,
                    'artists' => $artists,
                    'watched_time' => 0,
                    'ads' => \App\AdsVideo::where('video_id', $vid)->first(),
                    'category_name' => $category_name,
                    'langague_Name' => $langague_Name,
                    'release_year' => $release_year,
                    'Reels_videos' => $Reels_videos,
                    'ThumbnailSetting' => $ThumbnailSetting,
                    'genres_name' => $genres_name,
                    'artistsname' => $artistsname,
                    'lang_name' => $lang_name,
                    'subtitles_name' => $subtitles,
                ];
            }

            return Theme::view('fullplayer_video', $data);
        } else {
            $get_video_id = \App\Video::where('slug', $slug)->first();
            $vid = $get_video_id->id;
            $current_date = date('Y-m-d h:i:s a', time());
            $currency = CurrencySetting::first();

            $view_increment = $this->handleViewCount_movies($vid);

            if (!Auth::guest()) {
                $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
                $view = new RecentView();
                $view->video_id = $vid;
                $view->user_id = Auth::user()->id;
                $view->visited_at = date('Y-m-d');
                $view->save();
                $user_id = Auth::user()->id;
                $watch_id = ContinueWatching::where('user_id', '=', $user_id)
                    ->where('videoid', '=', $vid)
                    ->orderby('created_at', 'desc')
                    ->first();
                $watch_count = ContinueWatching::where('user_id', '=', $user_id)
                    ->where('videoid', '=', $vid)
                    ->orderby('created_at', 'desc')
                    ->count();

                if ($watch_count > 0) {
                    $watchtime = $watch_id->currentTime;
                } else {
                    $watchtime = 0;
                }

                $ppv_exist = PpvPurchase::where('video_id', $vid)
                    ->where('user_id', $user_id)
                    ->where('to_time', '>', $current_date)
                    ->count();
                $user_id = Auth::user()->id;

                $categoryVideos = \App\Video::where('id', $vid)->first();
                $category_id = \App\Video::where('id', $vid)->pluck('video_category_id');
                $videocategory = \App\VideoCategory::where('id', $category_id)->pluck('name');
                $videocategory = $videocategory[0];
                $recomended = \App\Video::where('video_category_id', '=', $category_id)
                    ->where('id', '!=', $vid)
                    ->limit(10)
                    ->get();
                $playerui = Playerui::first();
                $subtitle = MoviesSubtitles::where('movie_id', '=', 82)->get();

                $wishlisted = false;
                if (!Auth::guest()):
                    $wishlisted = Wishlist::where('user_id', '=', Auth::user()->id)
                        ->where('video_id', '=', $vid)
                        ->where('type', '=', 'channel')
                        ->first();
                endif;
                $watchlater = false;
                if (!Auth::guest()):
                    $watchlater = Watchlater::where('user_id', '=', Auth::user()->id)
                        ->where('video_id', '=', $vid)
                        ->where('type', '=', 'channel')
                        ->first();
                    $like_dislike = LikeDislike::where('user_id', '=', Auth::user()->id)
                        ->where('video_id', '=', $vid)
                        ->get();
                endif;

                $currency = CurrencySetting::first();

                $langague_Name = Language::join('languagevideos', 'languages.id', '=', 'languagevideos.language_id')
                    ->where('video_id', $vid)
                    ->get();

                $release_year = Video::where('id', $vid)
                    ->pluck('year')
                    ->first();

                $Reels_videos = Video::where('id', $vid)
                    ->whereNotNull('reelvideo')
                    ->get();

                $category_name = CategoryVideo::select('video_categories.name as categories_name','video_categories.slug as categories_slug','categoryvideos.video_id')
                    ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
                    ->where('categoryvideos.video_id', $vid)
                    ->get();

                $categoryVideos = Video::with('category.categoryname')
                    ->where('id', $vid)
                    ->first();

                $category_name = CategoryVideo::select('video_categories.name as categories_name','video_categories.slug as categories_slug','categoryvideos.video_id')
                    ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
                    ->where('categoryvideos.video_id', $vid)
                    ->get();

                if (count($category_name) > 0) {
                    foreach ($category_name as $value) {
                        $vals[] = $value->categories_name;
                    }
                    $genres_name = implode(', ', $vals);
                } else {
                    $genres_name = 'No Genres Added';
                }

                $lang_name = LanguageVideo::select('languages.name as name')
                    ->Join('languages', 'languagevideos.language_id', '=', 'languages.id')
                    ->where('languagevideos.video_id', $vid)
                    ->get();

                if (count($lang_name) > 0) {
                    foreach ($lang_name as $value) {
                        $languagesvals[] = $value->name;
                    }
                    $lang_name = implode(',', $languagesvals);
                } else {
                    $lang_name = 'No Languages Added';
                }

                $artists_name = Videoartist::select('artists.artist_name as name')
                    ->Join('artists', 'video_artists.artist_id', '=', 'artists.id')
                    ->where('video_artists.video_id', $vid)
                    ->get();

                if (count($artists_name) > 0) {
                    foreach ($artists_name as $value) {
                        $artistsvals[] = $value->name;
                    }
                    $artistsname = implode(',', $artistsvals);
                } else {
                    $artistsname = 'No Starring  Added';
                }

                $subtitles_name = MoviesSubtitles::select('subtitles.language as language')
                    ->Join('subtitles', 'movies_subtitles.shortcode', '=', 'subtitles.short_code')
                    ->where('movies_subtitles.movie_id', $vid)
                    ->get();

                if (count($subtitles_name) > 0) {
                    foreach ($subtitles_name as $value) {
                        $subtitlesname[] = $value->language;
                    }
                    $subtitles = implode(', ', $subtitlesname);
                } else {
                    $subtitles = 'No Subtitles Added';
                }

                $data = [
                    'currency' => $currency,
                    'video' => $categoryVideos,
                    'videocategory' => $videocategory,
                    'recomended' => $recomended,
                    'ppv_exist' => $ppv_exist,
                    'ppv_price' => 100,
                    'watchlatered' => $watchlater,
                    'mywishlisted' => $wishlisted,
                    'watched_time' => $watchtime,
                    'like_dislike' => $like_dislike,
                    'playerui_settings' => $playerui,
                    'subtitles' => $subtitle,
                    'ads' => \App\AdsVideo::where('video_id', $vid)->first(),
                    'category_name' => $category_name,
                    'langague_Name' => $langague_Name,
                    'release_year' => $release_year,
                    'Reels_videos' => $Reels_videos,
                    'ThumbnailSetting' => $ThumbnailSetting,
                    'genres_name' => $genres_name,
                    'artistsname' => $artistsname,
                    'lang_name' => $lang_name,
                    'subtitles_name' => $subtitles,
                ];
            } else {
                $categoryVideos = \App\Video::where('id', $vid)->first();
                $category_id = \App\Video::where('id', $vid)->pluck('video_category_id');
                $recomended = \App\Video::where('video_category_id', '=', $category_id)
                    ->where('id', '!=', $vid)
                    ->limit(10)
                    ->get();
                $playerui = Playerui::first();
                $subtitle = MoviesSubtitles::where('movie_id', '=', $vid)->get();
                $currency = CurrencySetting::first();

                $langague_Name = Language::join('languagevideos', 'languages.id', '=', 'languagevideos.language_id')
                    ->where('video_id', $vid)
                    ->get();

                $release_year = Video::where('id', $vid)
                    ->pluck('year')
                    ->first();

                $Reels_videos = Video::where('id', $vid)
                    ->whereNotNull('reelvideo')
                    ->get();

                $category_name = CategoryVideo::select('video_categories.name as categories_name','video_categories.slug as categories_slug','categoryvideos.video_id')
                    ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
                    ->where('categoryvideos.video_id', $vid)
                    ->get();

                $categoryVideos = Video::with('category.categoryname')
                    ->where('id', $vid)
                    ->first();

                $category_name = CategoryVideo::select('video_categories.name as categories_name','video_categories.slug as categories_slug','categoryvideos.video_id')
                    ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
                    ->where('categoryvideos.video_id', $vid)
                    ->get();

                if (count($category_name) > 0) {
                    foreach ($category_name as $value) {
                        $vals[] = $value->categories_name;
                    }
                    $genres_name = implode(', ', $vals);
                } else {
                    $genres_name = 'No Genres Added';
                }

                $lang_name = LanguageVideo::select('languages.name as name')
                    ->Join('languages', 'languagevideos.language_id', '=', 'languages.id')
                    ->where('languagevideos.video_id', $vid)
                    ->get();

                if (count($lang_name) > 0) {
                    foreach ($lang_name as $value) {
                        $languagesvals[] = $value->name;
                    }
                    $lang_name = implode(',', $languagesvals);
                } else {
                    $lang_name = 'No Languages Added';
                }

                $artists_name = Videoartist::select('artists.artist_name as name')
                    ->Join('artists', 'video_artists.artist_id', '=', 'artists.id')
                    ->where('video_artists.video_id', $vid)
                    ->get();

                if (count($artists_name) > 0) {
                    foreach ($artists_name as $value) {
                        $artistsvals[] = $value->name;
                    }
                    $artistsname = implode(',', $artistsvals);
                } else {
                    $artistsname = 'No Starring  Added';
                }

                $subtitles_name = MoviesSubtitles::select('subtitles.language as language')
                    ->Join('subtitles', 'movies_subtitles.shortcode', '=', 'subtitles.short_code')
                    ->where('movies_subtitles.movie_id', $vid)
                    ->get();

                if (count($subtitles_name) > 0) {
                    foreach ($subtitles_name as $value) {
                        $subtitlesname[] = $value->language;
                    }
                    $subtitles = implode(', ', $subtitlesname);
                } else {
                    $subtitles = 'No Subtitles Added';
                }
                $categoryVideos = \App\Video::where('id', $vid)->first();
                $category_id = \App\Video::where('id', $vid)->pluck('video_category_id');
                // $recomended = \App\Video::where('video_category_id','=',$category_id)->where('id','!=',$vid)->limit(10)->get();
                $playerui = Playerui::first();
                $subtitle = MoviesSubtitles::where('movie_id', '=', $vid)->get();
                $currency = CurrencySetting::first();
                $category_id = CategoryVideo::where('video_id', $vid)->get();
                $categoryvideo = CategoryVideo::where('video_id', $vid)
                    ->pluck('category_id')
                    ->toArray();
                $languages_id = LanguageVideo::where('video_id', $vid)
                    ->pluck('language_id')
                    ->toArray();

                // Recomendeds And Endcard
                foreach ($category_id as $key => $value) {
                    $recomendeds = Video::select('videos.*', 'video_categories.name as categories_name', 'categoryvideos.category_id as categories_id')
                        ->Join('categoryvideos', 'videos.id', '=', 'categoryvideos.video_id')
                        ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
                        ->where('videos.id', '!=', $vid)
                        ->where('videos.active',  1)
                        ->where('videos.status',  1)
                        ->where('videos.draft',  1)
                        ->groupBy('videos.id')
                        ->limit(10)
                        ->get();

                    $endcardvideo = Video::select('videos.*', 'video_categories.name as categories_name', 'categoryvideos.category_id as categories_id')
                        ->Join('categoryvideos', 'videos.id', '=', 'categoryvideos.video_id')
                        ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
                        ->where('videos.id', '!=', $vid)
                        ->limit(5)
                        ->get();
                }

                if (!Auth::guest()) {
                    $latestRecentView = RecentView::where('user_id', '!=', Auth::user()->id)
                        ->distinct()
                        ->limit(30)
                        ->pluck('video_id');
                    if (count($latestRecentView) > 10) {
                        $latestviews = [];
                    } else {
                        $latestviews = Video::select('videos.*', 'video_categories.name as categories_name', 'categoryvideos.category_id as categories_id')
                            ->Join('categoryvideos', 'videos.id', '=', 'categoryvideos.video_id')
                            ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
                            ->whereIn('videos.id', $latestRecentView)
                            ->groupBy('videos.id')
                            ->get();
                    }
                } else {
                    $latestRecentView = [];
                    $latestviews = [];
                    $recomendeds = $recomendeds;
                }

                $related_videos = Video::select('videos.*', 'related_videos.id as related_videos_id', 'related_videos.related_videos_title as related_videos_title')
                    ->Join('related_videos', 'videos.id', '=', 'related_videos.related_videos_id')
                    ->where('related_videos.video_id', '=', $vid)
                    ->limit(5)
                    ->get();

                if (count($related_videos) > 0) {
                    $endcardvideo = $related_videos;
                } elseif (!empty($endcardvideo)) {
                    $endcardvideo = $endcardvideo;
                } else {
                    $endcardvideo = [];
                }

                if ($get_video_id->type == 'mp4_url') {
                    $endtimevideo = '';
                } elseif ($get_video_id->type == 'm3u8_url') {
                    $endtimevideo = '';
                } elseif ($get_video_id->type == '') {
                    $endtimevideo = '';
                } else {
                    $endtimevideo = '';
                }

                if (count($latestviews) <= 15) {
                    if (!empty($recomendeds)) {
                        $recomended = Video::select('videos.*', 'video_categories.name as categories_name', 'categoryvideos.category_id as categories_id')
                            ->Join('categoryvideos', 'videos.id', '=', 'categoryvideos.video_id')
                            ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
                            ->where('videos.id', '!=', $vid)
                            ->where('videos.active',  1)
                            ->where('videos.status',  1)
                            ->where('videos.draft',  1)
                            ->groupBy('videos.id')
                            ->limit(10)
                            ->get();
                    } else {
                        $recomended = [];
                    }
                } else {
                    $recomended = $latestviews;
                }

                if (!empty($recomended)) {
                    $recomended = $recomended;
                } else {
                    $recomended = [];
                }
                $artistscount = Videoartist::join('artists', 'video_artists.artist_id', '=', 'artists.id')
                    ->select('artists.*')
                    ->where('video_artists.video_id', '=', $vid)
                    ->count();

                if ($artistscount > 0) {
                    $artists = Videoartist::join('artists', 'video_artists.artist_id', '=', 'artists.id')
                        ->select('artists.*')
                        ->where('video_artists.video_id', '=', $vid)
                        ->get();
                } else {
                    $artists = [];
                }
                $Reels_videos = Video::Join('reelsvideo', 'reelsvideo.video_id', '=', 'videos.id')
                    ->where('videos.id', $vid)
                    ->get();

                $data = [
                    'currency' => $currency,
                    'video' => $categoryVideos,
                    'recomended' => $recomended,
                    'playerui_settings' => $playerui,
                    'subtitles' => $subtitle,
                    'watched_time' => 0,
                    'ads' => \App\AdsVideo::where('video_id', $vid)->first(),
                    'category_name' => $category_name,
                    'langague_Name' => $langague_Name,
                    'release_year' => $release_year,
                    'Reels_videos' => $Reels_videos,
                    'ThumbnailSetting' => $ThumbnailSetting,
                    'genres_name' => $genres_name,
                    'artistsname' => $artistsname,
                    'lang_name' => $lang_name,
                    'subtitles_name' => $subtitles,
                    'artists' => $artists,
                ];
            }
            return Theme::view('video_before_login', $data);
        }
    }

    public function PlayPpv($vid)
    {
        $categoryVideos = \App\PpvVideo::where('id', $vid)->first();
        $user_id = Auth::user()->id;
        $settings = Setting::first();
        $ppv_exist = PpvPurchase::where('video_id', $vid)
            ->where('user_id', $user_id)
            ->count();

        $wishlisted = false;
        if (!Auth::guest()):
            $wishlisted = Wishlist::where('user_id', '=', Auth::user()->id)
                ->where('video_id', '=', $vid)
                ->where('type', '=', 'ppv')
                ->first();
        endif;

        $watchlater = false;

        if (!Auth::guest()):
            $watchlater = Watchlater::where('user_id', '=', Auth::user()->id)
                ->where('video_id', '=', $vid)
                ->where('type', '=', 'ppv')
                ->first();
        endif;

        $data = [
            'video' => $categoryVideos,
            'ppv_exist' => $ppv_exist,
            'ppv_price' => $settings->ppv_price,
            'watchlatered' => $watchlater,
            'mywishlisted' => $wishlisted,
        ];

        return view('ppvvideo', $data);
    }

    public function ppvVideos()
    {
        $vpp = VideoPerPage();
        $data = PpvVideo::where('status', 1)->paginate($vpp);
        //       $data = array(
        //             'ppvVideos' => $ppvVideos,
        // );
        return view('ppvVideos', ['data' => $data]);
    }

    public function Myppv()
    {
        if (!Auth::user()) {
            return Redirect::to('/')->with([
                'note' => 'Successfully Updated Site Settings!',
                'note_type' => 'success',
            ]);
        }

        $user_id = Auth::user()->id;

        $ppvVideos = PpvPurchase::where('user_id', $user_id)->get();

        $data = [
            'videos' => $ppvVideos,
        ];
        return view('ppv-list', $data);
    }

    public function handleViewCount_movies($vid)
    {
        $movie = Video::find($vid);
        $movie->views = $movie->views + 1;
        $movie->save();
        Session::put('viewed_movie.' . $vid, time());
    }

    public function Watchlist($slug)
    {
        $video = Video::where('slug', '=', $slug)->first();
        $video_id = $video->id;
        $count = Wishlist::where('user_id', '=', Auth::User()->id)
            ->where('video_id', '=', $video_id)
            ->count();
        if ($count > 0) {
            Wishlist::where('user_id', '=', Auth::User()->id)
                ->where('video_id', '=', $video_id)
                ->delete();
        } else {
            $data = [
                'user_id' => Auth::User()->id,
                'video_id' => $video_id,
            ];
            Wishlist::insert($data);
        }
        return Redirect::back();
    }

    public function Wishlist_play_videos($slug)
    {
        $data['password_hash'] = '';
        $data = session()->all();

        if (!Auth::guest()) {
            $get_video_id = \App\Video::where('slug', $slug)->first();
            $vid = $get_video_id->id;
            $wishlist = new Wishlist();
            $wishlist->video_id = $vid;
            $wishlist->user_id = Auth::User()->id;
            $wishlist->save();

            $PPV_settings = Setting::where('ppv_status', '=', 1)->first();
            if (!empty($PPV_settings)) {
                $ppv_rent_price = $PPV_settings->ppv_price;
                // echo "<pre>";print_r($PPV_settings);exit();
            } else {
                $Video_ppv = Video::where('id', '=', $vid)->first();
                $ppv_rent_price = null;
                if ($Video_ppv->ppv_price != '') {
                    // echo "<pre>";print_r('$Video_ppv');exit();
                    $ppv_rent_price = $Video_ppv->ppv_price;
                } else {
                    // echo "<pre>";print_r($Video_ppv);exit();
                    $ppv_rent_price = $Video_ppv->ppv_price;
                }
            }

            $current_date = date('Y-m-d h:i:s a', time());

            $view_increment = $this->handleViewCount_movies($vid);
            if (!Auth::guest()) {
                $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
                $view = new RecentView();
                $view->video_id = $vid;
                $view->user_id = Auth::user()->id;
                $view->visited_at = date('Y-m-d');
                $view->save();
                $user_id = Auth::user()->id;
                $watch_id = ContinueWatching::where('user_id', '=', $user_id)
                    ->where('videoid', '=', $vid)
                    ->orderby('created_at', 'desc')
                    ->first();
                $watch_count = ContinueWatching::where('user_id', '=', $user_id)
                    ->where('videoid', '=', $vid)
                    ->orderby('created_at', 'desc')
                    ->count();
                if ($watch_count > 0) {
                    $watchtime = $watch_id->currentTime;
                } else {
                    $watchtime = 0;
                }
                $ppv_exist = PpvPurchase::where('video_id', $vid)
                    ->where('user_id', $user_id)
                    ->where('to_time', '>', $current_date)
                    ->count();
                $user_id = Auth::user()->id;

                $categoryVideos = \App\Video::where('id', $vid)->first();
                $category_id = \App\Video::where('id', $vid)->pluck('video_category_id');
                $videocategory = \App\VideoCategory::where('id', $category_id)->pluck('name');
                $videocategory = $videocategory[0];
                $recomended = \App\Video::where('video_category_id', '=', $category_id)
                    ->where('id', '!=', $vid)
                    ->limit(10)
                    ->get();
                $playerui = Playerui::first();
                $subtitle = MoviesSubtitles::where('movie_id', '=', $vid)->get();

                $wishlisted = false;
                if (!Auth::guest()):
                    $wishlisted = Wishlist::where('user_id', '=', Auth::user()->id)
                        ->where('video_id', '=', $vid)
                        ->where('type', '=', 'channel')
                        ->first();
                endif;
                $watchlater = false;
                if (!Auth::guest()):
                    $watchlater = Watchlater::where('user_id', '=', Auth::user()->id)
                        ->where('video_id', '=', $vid)
                        ->where('type', '=', 'channel')
                        ->first();
                    $like_dislike = LikeDislike::where('user_id', '=', Auth::user()->id)
                        ->where('video_id', '=', $vid)
                        ->get();
                endif;

                $ppv_video_play = [];

                $ppv_video = PpvPurchase::where('user_id', Auth::user()->id)
                    ->where('status', 'active')
                    ->get();
                $ppv_setting = Setting::first();
                $ppv_setting_hours = $ppv_setting->ppv_hours;
                // dd($ppv_hours);
                if (!empty($ppv_video)) {
                    foreach ($ppv_video as $key => $value) {
                        $to_time = $value->to_time;

                        // $time = date('h:i:s', strtotime($date));
                        // $ppv_hours = date('Y-m-d h:i:s a',strtotime('+'.$ppv_setting_hours.' hour',strtotime($date)));
                        $d = new \DateTime('now');
                        $d->setTimezone(new \DateTimeZone('Asia/Kolkata'));
                        $now = $d->format('Y-m-d h:i:s a');
                        // dd($to_time);
                        // "2021-10-28 03:19:38 pm"
                        // "2021-10-28 05:14:25 pm"
                        if ($to_time >= $now) {
                            if ($vid == $value->video_id) {
                                $ppv_video_play = $value;
                                // dd($ppv_video_play);
                            } else {
                                $ppv_video_play = null;
                            }
                        } else {
                            // dd('$now');
                            PpvPurchase::where('video_id', $vid)->update(['status' => 'inactive']);
                        }
                        $purchased_video = Video::where('id', $value->video_id)->get();

                        // if($now == $ppv_hours){
                        //   if($vid == $value->video_id){
                        //     $ppv_video_play = $value;
                        //   }else{
                        //     $ppv_video_play = null;
                        //   }
                        // }else{
                        //     // dd($now);
                        //     PpvPurchase::where('video_id', $vid)
                        //             ->update([
                        //                 'status' => 'inactive'
                        //                 ]);
                        // }
                        // $purchased_video = \DB::table('videos')->where('id',$value->video_id)->get();
                    }
                }

                $currency = CurrencySetting::first();

                $data = [
                    'currency' => $currency,
                    'video' => $categoryVideos,
                    'videocategory' => $videocategory,
                    'recomended' => $recomended,
                    'ppv_exist' => $ppv_exist,
                    'ppv_price' => 100,
                    'watchlatered' => $watchlater,
                    'mywishlisted' => $wishlisted,
                    'watched_time' => $watchtime,
                    'like_dislike' => $like_dislike,
                    'ppv_rent_price' => $ppv_rent_price,
                    'playerui_settings' => $playerui,
                    'subtitles' => $subtitle,
                    'ppv_video_play' => $ppv_video_play,
                ];
            } else {
                $categoryVideos = \App\Video::where('id', $vid)->first();
                $category_id = \App\Video::where('id', $vid)->pluck('video_category_id');
                $recomended = \App\Video::where('video_category_id', '=', $category_id)
                    ->where('id', '!=', $vid)
                    ->limit(10)
                    ->get();
                $playerui = Playerui::first();
                $subtitle = MoviesSubtitles::where('movie_id', '=', $vid)->get();
                $currency = CurrencySetting::first();

                $data = [
                    'currency' => $currency,
                    'video' => $categoryVideos,
                    'recomended' => $recomended,
                    'playerui_settings' => $playerui,
                    'subtitles' => $subtitle,
                    'watched_time' => 0,
                ];
            }

            return view('video', $data);
        } else {
            $get_video_id = \App\Video::where('slug', $slug)->first();
            $vid = $get_video_id->id;
            $current_date = date('Y-m-d h:i:s a', time());
            $currency = CurrencySetting::first();

            $view_increment = $this->handleViewCount_movies($vid);
            if (!Auth::guest()) {
                $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
                $view = new RecentView();
                $view->video_id = $vid;
                $view->user_id = Auth::user()->id;
                $view->visited_at = date('Y-m-d');
                $view->save();
                $user_id = Auth::user()->id;
                $watch_id = ContinueWatching::where('user_id', '=', $user_id)
                    ->where('videoid', '=', $vid)
                    ->orderby('created_at', 'desc')
                    ->first();
                $watch_count = ContinueWatching::where('user_id', '=', $user_id)
                    ->where('videoid', '=', $vid)
                    ->orderby('created_at', 'desc')
                    ->count();
                if ($watch_count > 0) {
                    $watchtime = $watch_id->currentTime;
                } else {
                    $watchtime = 0;
                }
                $ppv_exist = PpvPurchase::where('video_id', $vid)
                    ->where('user_id', $user_id)
                    ->where('to_time', '>', $current_date)
                    ->count();
                $user_id = Auth::user()->id;

                $categoryVideos = \App\Video::where('id', $vid)->first();
                $category_id = \App\Video::where('id', $vid)->pluck('video_category_id');
                $videocategory = \App\VideoCategory::where('id', $category_id)->pluck('name');
                $videocategory = $videocategory[0];
                $recomended = \App\Video::where('video_category_id', '=', $category_id)
                    ->where('id', '!=', $vid)
                    ->limit(10)
                    ->get();
                $playerui = Playerui::first();
                $subtitle = MoviesSubtitles::where('movie_id', '=', 82)->get();
                $currency = CurrencySetting::first();

                $wishlisted = false;
                if (!Auth::guest()):
                    $wishlisted = Wishlist::where('user_id', '=', Auth::user()->id)
                        ->where('video_id', '=', $vid)
                        ->where('type', '=', 'channel')
                        ->first();
                endif;
                $watchlater = false;
                if (!Auth::guest()):
                    $watchlater = Watchlater::where('user_id', '=', Auth::user()->id)
                        ->where('video_id', '=', $vid)
                        ->where('type', '=', 'channel')
                        ->first();
                    $like_dislike = LikeDislike::where('user_id', '=', Auth::user()->id)
                        ->where('video_id', '=', $vid)
                        ->get();
                endif;
                $data = [
                    'currency' => $currency,
                    'video' => $categoryVideos,
                    'videocategory' => $videocategory,
                    'recomended' => $recomended,
                    'ppv_exist' => $ppv_exist,
                    'ppv_price' => 100,
                    'watchlatered' => $watchlater,
                    'mywishlisted' => $wishlisted,
                    'watched_time' => $watchtime,
                    'like_dislike' => $like_dislike,
                    'playerui_settings' => $playerui,
                    'subtitles' => $subtitle,
                ];
            } else {
                $categoryVideos = \App\Video::where('id', $vid)->first();
                $category_id = \App\Video::where('id', $vid)->pluck('video_category_id');
                $recomended = \App\Video::where('video_category_id', '=', $category_id)
                    ->where('id', '!=', $vid)
                    ->limit(10)
                    ->get();
                $playerui = Playerui::first();
                $subtitle = MoviesSubtitles::where('movie_id', '=', $vid)->get();
                $currency = CurrencySetting::first();

                $data = [
                    'currency' => $currency,
                    'video' => $categoryVideos,
                    'recomended' => $recomended,
                    'playerui_settings' => $playerui,
                    'subtitles' => $subtitle,
                    'watched_time' => 0,
                ];
            }
            return view('video_before_login', $data);
        }
    }

    public function Embed_play_videos($slug)
    {
        $data['password_hash'] = '';
        $data = session()->all();

        if (!Auth::guest()) {
            $get_video_id = \App\Video::where('slug', $slug)->first();

            $vid = $get_video_id->id;

            // echo "<pre>";
            $artistscount = Videoartist::join('artists', 'video_artists.artist_id', '=', 'artists.id')
                ->select('artists.*')
                ->where('video_artists.video_id', '=', $vid)
                ->count();
            if ($artistscount > 0) {
                $artists = Videoartist::join('artists', 'video_artists.artist_id', '=', 'artists.id')
                    ->select('artists.*')
                    ->where('video_artists.video_id', '=', $vid)
                    ->get();
                // dd($artists);
            } else {
                $artists = [];
            }

            // $cast = Videoartist::where('video_id','=',$vid)->get();
            //   foreach($cast as $key => $artist){
            //     $artists[] = Artist::where('id','=',$artist->artist_id)->get();
            //   }
            // print_r();
            // exit();

            $PPV_settings = Setting::where('ppv_status', '=', 1)->first();
            if (!empty($PPV_settings)) {
                $ppv_rent_price = $PPV_settings->ppv_price;
                // echo "<pre>";print_r($PPV_settings);exit();
            } else {
                $Video_ppv = Video::where('id', '=', $vid)->first();
                $ppv_rent_price = null;
                if ($Video_ppv->ppv_price != '') {
                    // echo "<pre>";print_r('$Video_ppv');exit();
                    $ppv_rent_price = $Video_ppv->ppv_price;
                } else {
                    // echo "<pre>";print_r($Video_ppv);exit();
                    $ppv_rent_price = $Video_ppv->ppv_price;
                }
            }
            $current_date = date('Y-m-d h:i:s a', time());
            $view_increment = $this->handleViewCount_movies($vid);

            if (!Auth::guest()) {
                $sub_user = Session::get('subuser_id');

                $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
                $userIp = $geoip->getip();
                $countryName = $geoip->getCountry();
                $regionName = $geoip->getregion();
                $cityName = $geoip->getcity();

                $view = new RecentView();
                $view->video_id = $vid;
                $view->user_id = Auth::user()->id;
                $view->country_name = $countryName;
                // $view->videos_category_id = $get_video_id->video_category_id;
                if ($sub_user != null) {
                    $view->sub_user = $sub_user;
                }
                $view->visited_at = date('Y-m-d');
                $view->save();

                $regionview = RegionView::where('user_id', '=', Auth::User()->id)
                    ->where('video_id', '=', $vid)
                    ->orderBy('created_at', 'DESC')
                    ->whereDate('created_at', '>=', \Carbon\Carbon::now()->today())
                    ->first();
                if (!empty($regionview)) {
                    // dd($logged);
                    $regionview = RegionView::where('user_id', '=', Auth::User()->id)
                        ->where('video_id', '=', $vid)
                        ->orderBy('created_at', 'DESC')
                        ->whereDate('created_at', '>=', \Carbon\Carbon::now()->today())
                        ->delete();
                    // dd($data);
                    $region = new RegionView();
                    $region->user_id = Auth::User()->id;
                    $region->user_ip = $userIp;
                    $region->video_id = $vid;
                    $region->countryname = $countryName;
                    $region->save();
                } else {
                    $region = new RegionView();
                    $region->user_id = Auth::User()->id;
                    $region->user_ip = $userIp;
                    $region->video_id = $vid;
                    $region->countryname = $countryName;
                    $region->save();
                }

                $user_id = Auth::user()->id;
                $watch_id = ContinueWatching::where('user_id', '=', $user_id)
                    ->where('videoid', '=', $vid)
                    ->orderby('created_at', 'desc')
                    ->first();
                $watch_count = ContinueWatching::where('user_id', '=', $user_id)
                    ->where('videoid', '=', $vid)
                    ->orderby('created_at', 'desc')
                    ->count();
                if ($watch_count > 0) {
                    $watchtime = $watch_id->currentTime;
                } else {
                    $watchtime = 0;
                }

                $ppv_exist = PpvPurchase::where('video_id', $vid)
                    ->where('user_id', $user_id)
                    ->where('to_time', '>', $current_date)
                    ->count();
                $user_id = Auth::user()->id;

                $categoryVideos = Video::with('category.categoryname')
                    ->where('id', $vid)
                    ->first();

                $category_name = CategoryVideo::select('video_categories.name as categories_name','video_categories.slug as categories_slug','categoryvideos.video_id')
                    ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
                    ->where('categoryvideos.video_id', $vid)
                    ->get();
                //  dd($category_name);
                $category_id = CategoryVideo::where('video_id', $vid)->get();
                $categoryvideo = CategoryVideo::where('video_id', $vid)
                    ->pluck('category_id')
                    ->toArray();
                $languages_id = LanguageVideo::where('video_id', $vid)
                    ->pluck('language_id')
                    ->toArray();
                foreach ($category_id as $key => $value) {
                    $recomendeds = Video::select('videos.*', 'video_categories.name as categories_name', 'categoryvideos.category_id as categories_id')
                        ->Join('categoryvideos', 'videos.id', '=', 'categoryvideos.video_id')
                        ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
                        ->where('videos.id', '!=', $vid)
                        ->where('videos.active',  1)
                        ->where('videos.status',  1)
                        ->where('videos.draft',  1)
                        ->groupBy('videos.id')
                        ->limit(10)
                        ->get();
                }
                if (!empty($recomendeds)) {
                    foreach ($recomendeds as $category) {
                        if (in_array($category->categories_id, $categoryvideo)) {
                            $recomended[] = $category;
                        }
                    }
                } else {
                    $recomended = [];
                }
                if (!empty($recomended)) {
                    $recomended = $recomended;
                } else {
                    $recomended = [];
                }

                $videocategory = [];

                $playerui = Playerui::first();
                $subtitle = MoviesSubtitles::where('movie_id', '=', $vid)->get();

                $wishlisted = false;
                if (!Auth::guest()):
                    $wishlisted = Wishlist::where('user_id', '=', Auth::user()->id)
                        ->where('video_id', '=', $vid)
                        ->where('type', '=', 'channel')
                        ->first();
                endif;
                $watchlater = false;
                if (!Auth::guest()):
                    $watchlater = Watchlater::where('user_id', '=', Auth::user()->id)
                        ->where('video_id', '=', $vid)
                        ->where('type', '=', 'channel')
                        ->first();
                    $like_dislike = LikeDislike::where('user_id', '=', Auth::user()->id)
                        ->where('video_id', '=', $vid)
                        ->get();
                endif;

                $ppv_video_play = [];

                $ppv_video = PpvPurchase::where('user_id', Auth::user()->id)
                    ->where('status', 'active')
                    ->get();
                $ppv_setting = Setting::first();
                $ppv_setting_hours = $ppv_setting->ppv_hours;
                // dd($ppv_hours);
                if (!empty($ppv_video)) {
                    foreach ($ppv_video as $key => $value) {
                        $to_time = $value->to_time;

                        // $time = date('h:i:s', strtotime($date));
                        // $ppv_hours = date('Y-m-d h:i:s a',strtotime('+'.$ppv_setting_hours.' hour',strtotime($date)));
                        $d = new \DateTime('now');
                        $d->setTimezone(new \DateTimeZone('Asia/Kolkata'));
                        $now = $d->format('Y-m-d h:i:s a');

                        if ($to_time >= $now) {
                            if ($vid == $value->video_id) {
                                $ppv_video_play = $value;
                                // dd($ppv_video_play);
                            } else {
                                $ppv_video_play = null;
                            }
                        } else {
                            // dd('$now');
                            PpvPurchase::where('video_id', $vid)->update(['status' => 'inactive']);
                        }
                        $purchased_video = Video::where('id', $value->video_id)->get();
                    }
                }

                $ads = AdsVideo::select('advertisements.*')
                    ->Join('advertisements', 'advertisements.id', '=', 'ads_videos.ads_id')
                    ->where('ads_videos.video_id', '=', $vid)
                    ->get();
                // $ads = AdsVideo::where('video_id',126)->get();
                if (!empty($ads) && count($ads) > 0) {
                    $ads_path = $ads[0]->ads_path;
                } else {
                    $ads_path = '';
                }
                // $artists = [];
                $payment_settings = PaymentSetting::first();
                $mode = $payment_settings->live_mode;
                if ($mode == 0) {
                    $secret_key = $payment_settings->test_secret_key;
                    $publishable_key = $payment_settings->test_publishable_key;
                } elseif ($mode == 1) {
                    $secret_key = $payment_settings->live_secret_key;
                    $publishable_key = $payment_settings->live_publishable_key;
                } else {
                    $secret_key = null;
                    $publishable_key = null;
                }

                $currency = CurrencySetting::first();
                $data = [
                    'currency' => $currency,
                    'video' => $categoryVideos,
                    'videocategory' => $videocategory,
                    'recomended' => $recomended,
                    'ads_path' => $ads_path,
                    'ppv_exist' => $ppv_exist,
                    'ppv_price' => 100,
                    'publishable_key' => $publishable_key,
                    'watchlatered' => $watchlater,
                    'mywishlisted' => $wishlisted,
                    'watched_time' => $watchtime,
                    'like_dislike' => $like_dislike,
                    'ppv_rent_price' => $ppv_rent_price,
                    'playerui_settings' => $playerui,
                    'subtitles' => $subtitle,
                    'artists' => $artists,
                    'ppv_video_play' => $ppv_video_play,
                    'ads' => \App\AdsVideo::where('video_id', $vid)->first(),
                    'category_name' => $category_name,
                ];
            } else {
                $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
                $userIp = $geoip->getip();
                $countryName = $geoip->getCountry();
                $regionName = $geoip->getregion();
                $cityName = $geoip->getcity();
                // dd($data);
                $regionview = RegionView::where('user_id', '=', Auth::User()->id)
                    ->where('video_id', '=', $vid)
                    ->orderBy('created_at', 'DESC')
                    ->whereDate('created_at', '>=', \Carbon\Carbon::now()->today())
                    ->first();
                if (!empty($regionview)) {
                    // dd($logged);
                    $regionview = RegionView::where('user_id', '=', Auth::User()->id)
                        ->where('video_id', '=', $vid)
                        ->orderBy('created_at', 'DESC')
                        ->whereDate('created_at', '>=', \Carbon\Carbon::now()->today())
                        ->delete();
                    // dd($data);
                    $region = new RegionView();
                    $region->user_id = Auth::User()->id;
                    $region->user_ip = $userIp;
                    $region->video_id = $vid;
                    $region->countryname = $countryName;
                    $region->save();
                } else {
                    $region = new RegionView();
                    $region->user_id = Auth::User()->id;
                    $region->user_ip = $userIp;
                    $region->video_id = $vid;
                    $region->countryname = $countryName;
                    $region->save();
                }
                $categoryVideos = \App\Video::where('id', $vid)->first();
                $category_id = \App\Video::where('id', $vid)->pluck('video_category_id');
                $recomended = \App\Video::where('video_category_id', '=', $category_id)
                    ->where('id', '!=', $vid)
                    ->limit(10)
                    ->get();
                $playerui = Playerui::first();
                $subtitle = MoviesSubtitles::where('movie_id', '=', $vid)->get();
                $currency = CurrencySetting::first();

                $data = [
                    'currency' => $currency,
                    'video' => $categoryVideos,
                    'recomended' => $recomended,
                    'playerui_settings' => $playerui,
                    'subtitles' => $subtitle,
                    'artists' => $artists,
                    'watched_time' => 0,
                    'ads' => \App\AdsVideo::where('video_id', $vid)->first(),
                ];
            }

            return Theme::view('embedvideo', $data);
        } else {
            $data = [
                'video' => \App\Video::where('slug', $slug)->first(),
                'settings' => Setting::first(),
            ];
            return Theme::view('iframeembedvideo', $data);
        }
    }

    public function Reals_videos(Request $request, $slug)
    {
        $video_id = \App\Video::where('slug', $slug)
            ->pluck('id')
            ->first();

        $Reels_videos = Video::where('id', $video_id)->first();

        $data = [
            'video' => $Reels_videos,
        ];

        return Theme::view('Reelvideos', $data);
    }

    public function artist_videos(Request $request, $slug)
    {
        try {
            $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
            $countryName = $geoip->getCountry();
            $getfeching = Geofencing::first();

            $block_videos = BlockVideo::where('country_id', $countryName)->get();
            if (!$block_videos->isEmpty()) {
                foreach ($block_videos as $block_video) {
                    $blockvideos[] = $block_video->video_id;
                }
            } else {
                $blockvideos[] = '';
            }

            $artist_id = Artist::where('artist_name', $slug)
                ->pluck('id')
                ->first();

            $artist_videos = Video::Join('video_artists', 'video_artists.video_id', '=', 'videos.id')
                ->Join('artists', 'artists.id', '=', 'video_artists.artist_id')
                ->where('videos.active', '=', '1')
                ->where('videos.status', '=', '1')
                ->where('videos.draft', '=', '1')
                ->where('video_artists.artist_id', $artist_id);
            if ($getfeching != null && $getfeching->geofencing == 'ON') {
                $artist_videos = $artist_videos->whereNotIn('videos.id', $blockvideos);
            }
            $artist_videos = $artist_videos->get();

            $data = [
                'artist_videos' => $artist_videos,
                'ThumbnailSetting' => ThumbnailSetting::first(),
                'currency' => CurrencySetting::first(),
                'artist_name' => $slug,
            ];

            return Theme::view('artists', $data);
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    public function categoryList(Request $request)
    {
        try {
            $settings = Setting::first();

            if ($settings->enable_landing_page == 1 && Auth::guest()) {
                
                $landing_page_slug = AdminLandingPage::where('status', 1)->pluck('slug')->first() ? AdminLandingPage::where('status', 1)->pluck('slug')->first() : 'landing-page';

                return redirect()->route('landing_page', $landing_page_slug);
            }

            $data = [
                'category_list' => VideoCategory::all(),
            ];

            return Theme::view('categoryList', $data);
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    public function categoryfilter(Request $request)
    {

        $settings = Setting::first();
        $PPV_settings = Setting::where('ppv_status', '=', 1)->first();

        if (!empty($PPV_settings)) {
            $ppv_gobal_price = $PPV_settings->ppv_price;
        } else {
            $ppv_gobal_price = null;
        }

        $categoryVideos = Video::join('categoryvideos', 'categoryvideos.video_id', '=', 'videos.id')
            ->where('category_id', '=', $request->category_id)
            ->where('active', '=', '1');

        if (Geofencing() != null && Geofencing()->geofencing == 'ON') {
            $categoryVideos = $categoryVideos->whereNotIn('videos.id', Block_videos());
        }

        if (!empty($request->rating)) {
            $categoryVideos = $categoryVideos->WhereIn('videos.rating', $request->rating);
        }

        if (!empty($request->age)) {
            $categoryVideos = $categoryVideos->WhereIn('videos.age_restrict', $request->age);
        }

        if (!empty($request->sorting)) {
            $categoryVideos = $categoryVideos->orderBy('videos.created_at', 'DESC');
        }

        $categoryVideos = $categoryVideos->paginate($this->videos_per_page);

        $Episode_videos = Series::select('episodes.*', 'series.title as series_name')
            ->join('series_categories', 'series_categories.series_id', '=', 'series.id')
            ->join('episodes', 'episodes.series_id', '=', 'series.id')
            ->where('series_categories.category_id', '=', $request->category_id)
            ->where('episodes.active', '=', '1')
            ->where('series.active', '=', '1')
            ->groupBy('episodes.id')
            ->latest('episodes.created_at');

        if (!empty($request->rating)) {
            $Episode_videos = $Episode_videos->WhereIn('episodes.rating', $request->rating);
        }

        if (!empty($request->age)) {
            $Episode_videos = $Episode_videos->WhereIn('episodes.age_restrict', $request->age);
        }

        if (!empty($request->sorting)) {
            $Episode_videos = $Episode_videos->orderBy('episodes.created_at', 'DESC');
        }

        $Episode_videos = $Episode_videos->paginate($this->videos_per_page);

        $data = [
            'currency' => CurrencySetting::first(),
            'category_title' => VideoCategory::where('id', $request->category_id)
                ->pluck('name')
                ->first(),
            'ThumbnailSetting' => ThumbnailSetting::first(),
            'age_categories' => AgeCategory::get(),
            'categoryVideos' => $categoryVideos,
            'ppv_gobal_price' => $ppv_gobal_price,
            'Episode_videos' => $Episode_videos,
        ];

        $theme = Theme::uses($this->Theme);

        return $theme->load('public/themes/default/partials/categoryvids_section', ['categoryVideos' => $data])->render();
    }

    public function MovieList()
    {
        try {
            $countryName = Country_name();
            $ThumbnailSetting = ThumbnailSetting::first();

            $parentCategories = Language::get();

            // blocked videos
            $block_videos = BlockVideo::where('country_id', $countryName)->get();
            if (!$block_videos->isEmpty()) {
                foreach ($block_videos as $block_video) {
                    $blockvideos[] = $block_video->video_id;
                }
            } else {
                $blockvideos[] = '';
            }

            $data = [
                'ThumbnailSetting' => $ThumbnailSetting,
                'blockvideos' => $blockvideos,
                'parentCategories' => $parentCategories,
            ];

            return Theme::view('movie_list', $data);
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    public function liveList()
    {
        $parentCategories = LiveCategory::orderBy('order')
            ->where('in_menu', 1)
            ->get();

        $data = [
            'ThumbnailSetting' => ThumbnailSetting::first(),
            'currency' => CurrencySetting::first(),
            'parentCategories' => $parentCategories,
        ];

        return Theme::view('Live_list', $data);
    }

    public function Series_List(Request $request)
    {
        $ThumbnailSetting = ThumbnailSetting::first();

        $parentCategories = SeriesGenre::where('in_menu', 1)
            ->orderBy('order')
            ->get();

        $data = [
            'ThumbnailSetting' => $ThumbnailSetting,
            'parentCategories' => $parentCategories,
        ];

        return Theme::view('Series_list', $data);
    }

    public function Series_genre_list(Request $request, $id)
    {
        $ThumbnailSetting = ThumbnailSetting::first();

        $series = Series::join('series_categories', 'series_categories.series_id', '=', 'series.id')
            ->where('category_id', '=', $id)
            ->where('active', '=', '1')
            ->orderBy('series.created_at', 'desc')
            ->get();

        $Series_Genre_name = SeriesGenre::where('id', $id)
            ->pluck('name')
            ->first();

        $data = [
            'ThumbnailSetting' => $ThumbnailSetting,
            'Series_Genre_name' => $Series_Genre_name,
            'videos' => $series,
        ];

        return Theme::view('Series_genre_list', $data);
    }

    public function artist_list(Request $request)
    {
        try {
            $data = [
                'artist_list' => Artist::all(),
                'ThumbnailSetting' => ThumbnailSetting::first(),
            ];

            return Theme::view('artist-list', $data);
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    public function ScheduledVideos(Request $request)
    {
        $settings = Setting::first();
        // try
        // {
        $data = $request->all();
        $to_date = $data['date'];
        $length = 2;
        $date = substr(str_repeat(0, $length) . $to_date, -$length);
        $month = $data['month'];
        $year = $data['year'];
        $schedule_id = $data['schedule_id'];
        $choosedmonth = date('m', strtotime($month));
        $choosed_date = $year . '/' . $choosedmonth . '/' . $date;
        $shedule_date = $year . '/' . $choosedmonth . '/' . str_pad($data['date'], 2, '0', STR_PAD_LEFT);

        if (!empty($settings->default_time_zone)) {
            date_default_timezone_set($settings->default_time_zone);
        } else {
            date_default_timezone_set('Asia/Kolkata');
        }
        $now = date('Y-m-d h:i:s a', time());
        $current_time = date('h:i A', time());

        $current_time = date('h:i A', time());
        $current_date = date('Y/m/d', time());

        if ($current_date == $choosed_date) {
            $currenttime = explode(':', $current_time);
            if (count($currenttime) > 0) {
                if ($currenttime[0] == 12) {
                    $ScheduleVideos = ScheduleVideos::where('shedule_date', '=', $shedule_date)
                        ->where('schedule_id', '=', $schedule_id)
                        ->where('sheduled_starttime', '<=', $current_time)
                        // ->where("shedule_endtime", ">=", $current_time)
                        ->first();
                } else {
                    $ScheduleVideos = ScheduleVideos::where('shedule_date', '=', $shedule_date)
                        ->where('schedule_id', '=', $schedule_id)
                        ->where('sheduled_starttime', '<=', $current_time)
                        ->where('shedule_endtime', '>=', $current_time)
                        ->first();
                }
            }
            // $ScheduleVideos = ScheduleVideos::where("shedule_date", "=", $shedule_date)
            // ->where("schedule_id", "=", $schedule_id)
            // ->where("sheduled_starttime", "<=", $current_time)
            // // ->where("shedule_endtime", ">=", $current_time)
            // ->first();

            $nextVideos = ScheduleVideos::where('shedule_date', '=', $shedule_date)
                ->where('schedule_id', '=', $schedule_id)
                ->where('sheduled_starttime', '>=', $current_time)
                ->first();
            // dd($nextVideos);

            if (!empty($ScheduleVideos)) {
                $sheduled_starttime = explode(':', $ScheduleVideos->sheduled_starttime);
                if (count($sheduled_starttime) > 0) {
                    if ($sheduled_starttime[0] == 12) {
                        if (@$ScheduleVideos->sheduled_starttime >= $current_time && @$ScheduleVideos->shedule_endtime >= $current_time) {
                            $new_date = Carbon::parse($shedule_date . ' ' . @$ScheduleVideos->shedule_endtime)->format('M d , y h:i:s a');
                        } else {
                            $new_date = null;
                        }
                    } else {
                        if (@$ScheduleVideos->sheduled_starttime <= $current_time && @$ScheduleVideos->shedule_endtime >= $current_time) {
                            $new_date = Carbon::parse($shedule_date . ' ' . @$ScheduleVideos->shedule_endtime)->format('M d , y h:i:s a');
                        } else {
                            $new_date = null;
                        }
                    }
                } else {
                    if (@$ScheduleVideos->sheduled_starttime <= $current_time && @$ScheduleVideos->shedule_endtime >= $current_time) {
                        $new_date = Carbon::parse($shedule_date . ' ' . @$ScheduleVideos->shedule_endtime)->format('M d , y h:i:s a');
                    } else {
                        $new_date = null;
                    }
                }
            } else {
                $new_date = null;
            }

            if (!empty($new_date) && !empty($nextVideos) && $new_date != null) {
                $next_start = Carbon::parse($shedule_date . ' ' . @$nextVideos->sheduled_starttime)->format('M d , y h:i:s a');
            } else {
                $next_start = '';
            }
            if (!empty($next_start) || !empty($new_date)) {
                $data = [
                    'nextVideos' => $nextVideos,
                    'ScheduleVideos' => $ScheduleVideos,
                    'new_date' => $new_date,
                    'next_start' => $next_start,
                    'Choose_current_date' => '',
                ];
                return view('admin.schedule.video', $data);
            } else {
                $data = [
                    'new_date' => null,
                    'next_start' => null,
                    'Choose_current_date' => 'Choose current date',
                ];
                return view('admin.schedule.video', $data);
            }
        } else {
        }
        // }
        // catch(\Throwable $th)
        // {
        //     return abort(404);
        // }
    }

    public function EmbedScheduledVideos($slug)
    {
        $settings = Setting::first();
        // try
        // {

        // $d = new \DateTime("now");
        // $d->setTimezone(new \DateTimeZone("Asia/Kolkata"));
        // $now = $d->format("Y-m-d h:i:s a");
        // $current_time = date("h:i A", strtotime($now));
        // $current_date = date("Y/m/d", strtotime($now));

        // date_default_timezone_set('Asia/Kolkata');
        if (!empty($settings->default_time_zone)) {
            date_default_timezone_set($settings->default_time_zone);
        } else {
            date_default_timezone_set('Asia/Kolkata');
        }
        $now = date('Y-m-d h:i:s a', time());
        $current_time = date('h:i A', time());

        $current_time = date('h:i A', time());
        $current_date = date('Y/m/d', time());
        // $current_time  = '12:49 PM';
        $shedule_date = $current_date;
        // dd($current_date);
        $VideoSchedules = VideoSchedules::where('slug', '=', $slug)->first();
        if (!empty($VideoSchedules)) {
            $currenttime = explode(':', $current_time);
            if (count($currenttime) > 0) {
                if ($currenttime[0] == 12) {
                    $ScheduleVideos = ScheduleVideos::where('schedule_id', '=', @$VideoSchedules->id)
                        ->where('sheduled_starttime', '>=', $current_time)
                        // ->where("sheduled_starttime", "<=", $current_time)
                        // ->where("shedule_endtime", ">=", $current_time)
                        ->where('shedule_date', '=', $current_date)
                        ->first();
                } else {
                    $ScheduleVideos = ScheduleVideos::where('schedule_id', '=', @$VideoSchedules->id)
                        ->where('sheduled_starttime', '>=', $current_time)
                        // ->where("sheduled_starttime", "<=", $current_time)
                        ->where('shedule_endtime', '>=', $current_time)
                        ->where('shedule_date', '=', $current_date)
                        ->first();
                }
            }
            // $ScheduleVideos = ScheduleVideos::where("schedule_id", "=", @$VideoSchedules->id)
            // ->where("sheduled_starttime", ">=", $current_time)
            // // ->where("sheduled_starttime", "<=", $current_time)
            // ->where("shedule_endtime", ">=", $current_time)
            // ->where("shedule_date", "=", $current_date)
            // ->first();
            // dd($ScheduleVideos);
            $nextVideos = ScheduleVideos::where('schedule_id', '=', @$VideoSchedules->id)
                ->where('sheduled_starttime', '>=', $current_time)
                ->first();

            if (!empty($ScheduleVideos)) {
                $sheduled_starttime = explode(':', $ScheduleVideos->sheduled_starttime);

                if (count($sheduled_starttime) > 0) {
                    if ($sheduled_starttime[0] == 12) {
                        // dd($ScheduleVideos);

                        if (@$ScheduleVideos->sheduled_starttime >= $current_time && @$ScheduleVideos->shedule_endtime >= $current_time) {
                            $new_date = Carbon::parse($shedule_date . ' ' . @$ScheduleVideos->shedule_endtime)->format('M d , y h:i:s a');
                        } else {
                            $new_date = null;
                        }
                    } else {
                        // if(@$ScheduleVideos->sheduled_starttime <= $current_time && @$ScheduleVideos->shedule_endtime >= $current_time
                        // ){

                        $new_date = Carbon::parse($shedule_date . ' ' . @$ScheduleVideos->shedule_endtime)->format('M d , y h:i:s a');

                        // }else{
                        //     $new_date = null;
                        // }
                    }
                } else {
                    if (@$ScheduleVideos->sheduled_starttime <= $current_time && @$ScheduleVideos->shedule_endtime >= $current_time) {
                        $new_date = Carbon::parse($shedule_date . ' ' . @$ScheduleVideos->shedule_endtime)->format('M d , y h:i:s a');
                    } else {
                        $new_date = null;
                    }
                }
            } else {
                $new_date = null;
            }

            if (!empty($new_date) && !empty($nextVideos) && $new_date != null) {
                $next_start = Carbon::parse($shedule_date . ' ' . @$nextVideos->sheduled_starttime)->format('M d , y h:i:s a');
            } else {
                $next_start = '';
            }
            if (!empty($next_start) || !empty($new_date)) {
                $data = [
                    'nextVideos' => $nextVideos,
                    'ScheduleVideos' => $ScheduleVideos,
                    'new_date' => $new_date,
                    'next_start' => $next_start,
                    'Choose_current_date' => '',
                ];
                return view('admin.schedule.video', $data);
            } else {
                $data = [
                    'new_date' => null,
                    'next_start' => null,
                    'Choose_current_date' => 'Choose current date',
                ];
                return view('admin.schedule.video', $data);
            }
        } else {
        }
        // }
        // catch(\Throwable $th)
        // {
        //     return abort(404);
        // }
    }

    public function LiveCategory(Request $request, $slug)
    {
        try {

            $LiveCategoryData = LiveCategory::where('slug', $slug)->first();
            $Live_Category = LiveCategory::find($LiveCategoryData->id) != null ? LiveCategory::find($LiveCategoryData->id)->specific_category_live : [];
            $category_title = LiveCategory::where('id', $LiveCategoryData->id)->pluck('name')->first();


            $data = array(
                'Live_Category' => $Live_Category,
                'ThumbnailSetting' => ThumbnailSetting::first(),
                'category_title'   => $category_title,
            );
    
            return Theme::view('partials.home.Category_Live', $data);

        } catch (\Throwable $th) {

            // return $th->getMessage();

            return abort(404);
        }
       
    }

    public function CategoryLive(Request $request)
    {
        try {
            $settings = Setting::first();

            if ($settings->enable_landing_page == 1 && Auth::guest()) {
                $landing_page_slug = AdminLandingPage::where('status', 1)
                    ->pluck('slug')
                    ->first()
                    ? AdminLandingPage::where('status', 1)
                        ->pluck('slug')
                        ->first()
                    : 'landing-page';

                return redirect()->route('landing_page', $landing_page_slug);
            }

            $data = [
                'category_list' => LiveCategory::all(),
            ];
            // dd($data);

            return Theme::view('CategoryLive', $data);
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    public function live_location()
    {

        echo '<pre>';
        echo Country_name();

        echo '<pre>';
        echo city_name();
        echo '<pre>';
    
        echo Region_name();
        exit;
    }


    private function videos_details_jsplayer( $slug )
    {
        try {
           
            $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();

            $video_id = Video::where('slug',$slug)->pluck('id')->first();

            $videodetail = Video::where('id',$video_id)->latest()->get()->map(function ($item) use ( $video_id , $geoip)  {

                $item['image_url']          = $item->image ? URL::to('public/uploads/images/'.$item->image ) : default_vertical_image_url();
                $item['player_image_url']   = $item->player_image ?  URL::to('public/uploads/images/'.$item->player_image) : default_horizontal_image_url() ;
                $item['Title_Thumbnail'] =   $item->video_title_image != null ? URL::to('public/uploads/images/'.$item->video_title_image) : default_vertical_image_url();     
                $item['Reels_Thumbnail'] =   $item->reels_thumbnail != null ? URL::to('public/uploads/images/'.$item->reels_thumbnail) : default_vertical_image_url();     
                $item['pdf_files_url']  = URL::to('public/uploads/videoPdf/'.$item->pdf_files) ;
                $item['transcoded_url'] = URL::to('/storage/app/public/').'/'.$item->path . '.m3u8';

                $item['video_publish_status'] = ($item->publish_type == "publish_now" || ($item->publish_type == "publish_later" && Carbon::today()->now()->greaterThanOrEqualTo($item->publish_time)))? "Released": ($item->publish_type == "publish_later" ? 'Coming Soon On '. Carbon::parse($item->publish_time)->isoFormat('Do MMMM YYYY') : null);

                $item['categories'] =  CategoryVideo::select('categoryvideos.*','category_id','video_id','video_categories.name as name','video_categories.slug')
                                                        ->join('video_categories','video_categories.id','=','categoryvideos.category_id')
                                                        ->where('video_id', $video_id)->get() ;

                $item['Language']   =  LanguageVideo::select('languagevideos.*','language_id','video_id','name','languages.name')
                                                    ->join('languages','languages.id','=','languagevideos.language_id')
                                                    ->where('languagevideos.video_id', $video_id)->get() ;

                $item['artists']    =  Videoartist::select('video_id','artist_id','artists.*')
                                                    ->join('artists','artists.id','=','video_artists.artist_id')
                                                    ->where('video_id', $video_id)->get();

                $item['category_id'] = CategoryVideo::where('video_id',$video_id)->pluck('category_id');

                $item['recommended_videos'] = CategoryVideo::select('categoryvideos.video_id','categoryvideos.category_id','videos.*')
                                                ->join('videos','videos.id','=','categoryvideos.video_id')
                                                ->whereIn('categoryvideos.category_id', $item['category_id'])
                                                ->where('videos.id', '!=' ,$video_id)
                                                ->groupBy('videos.id')->limit(30)->get()->map(function( $item ){
                                                    $item['video_publish_status'] = ($item->publish_type == "publish_now" || ($item->publish_type == "publish_later" && Carbon::today()->now()->greaterThanOrEqualTo($item->publish_time)))? "Published": ($item->publish_type == "publish_later" ? Carbon::parse($item->publish_time)->isoFormat('Do MMMM YYYY') : null);
                                                    return $item;
                                                });

                $item['watchlater_exist'] = Watchlater::where('video_id', $video_id)->where('type', 'channel')
                                                ->where(function ($query) use ($geoip) {
                                                    if (!Auth::guest()) {
                                                        $query->where('user_id', Auth::user()->id);
                                                    } else {
                                                        $query->where('users_ip_address', $geoip->getIP());
                                                    }
                                                })->first();

                                                
                $item['watchlater_exist'] = Watchlater::where('video_id', $video_id)->where('type', 'channel')
                                                ->where(function ($query) use ($geoip) {
                                                    if (!Auth::guest()) {
                                                        $query->where('user_id', Auth::user()->id);
                                                    } else {
                                                        $query->where('users_ip_address', $geoip->getIP());
                                                    }
                                                })->first();

                $item['Like_exist'] = LikeDislike::where('video_id', $video_id)->where('liked',1)
                                                    ->where(function ($query) use ($geoip) {
                                                        if (!Auth::guest()) {
                                                            $query->where('user_id', Auth::user()->id);
                                                        } else {
                                                            $query->where('users_ip_address', $geoip->getIP());
                                                        }
                                                    })->latest()->first();

                $item['dislike_exist'] = LikeDislike::where('video_id', $video_id)->where('disliked',1)
                                                ->where(function ($query) use ($geoip) {
                                                    if (!Auth::guest()) {
                                                        $query->where('user_id', Auth::user()->id);
                                                    } else {
                                                        $query->where('users_ip_address', $geoip->getIP());
                                                    }
                                                })->latest()->first();

                    // Reels Videos

                $item['Reels_videos'] = Video::Join('reelsvideo', 'reelsvideo.video_id', '=', 'videos.id')
                                                ->where('videos.id', $video_id)->get();

                $item['view_increment'] = $this->handleViewCount_movies($video_id);

                // Rent Video Exits

                if($item['access'] == 'ppv' && !Auth::guest()){
                    $item['PPV_Exits'] = PpvPurchase::where('video_id', $item['id'])
                                            ->where('user_id', Auth::user()->id)->count();
                }else{
                    $item['PPV_Exits'] = 0 ;
                }


                    //  Video URL

                switch (true) {

                    case $item['type'] == "mp4_url":
                        $item['videos_url']  =  $item->mp4_url ;
                        $item['video_player_type'] =  'video/mp4' ;
                    break;

                    case $item['type'] == "m3u8_url":
                        $item['videos_url']  =  $item->m3u8_url ;
                        $item['video_player_type'] =  'application/x-mpegURL' ;
                    break;

                    case $item['type'] == "embed":
                        $item['videos_url']  =  $item->embed_code ;
                        $item['video_player_type'] =  'video/webm' ;
                    break;
                    
                    case $item['type'] == null &&  pathinfo($item['mp4_url'], PATHINFO_EXTENSION) == "mp4" :
                        $item['videos_url']    =   URL::to('/storage/app/public/'.$item->path.'.m3u8');
                        $item['video_player_type']   =  'application/x-mpegURL' ;
                    break;

                    default:
                        $item['videos_url']    = null ;
                        $item['video_player_type']   =  null ;
                    break;
                }

                    //  Video Trailer URL

                switch (true) {

                    case $item['trailer_type'] === "mp4_url":
                        $item['trailer_videos_url']  =  $item->trailer ;
                        $item['trailer_video_player_type'] =  'video/mp4' ;
                    break;

                    case $item['trailer_type'] === (("m3u8_url") || ("m3u8")) :
                        $item['trailer_videos_url']  =  $item->trailer ;
                        $item['trailer_video_player_type'] =  'application/x-mpegURL' ;
                    break;

                    case $item['trailer_type'] === "embed_url":
                        $item['trailer_videos_url']  =  $item->trailer ;
                        $item['trailer_video_player_type'] =  'video/mp4' ;
                    break;

                    case $item['trailer_type'] === "video_mp4":
                        $item['trailer_videos_url']  =  $item->trailer ;
                        $item['trailer_video_player_type'] =  'video/mp4' ;
                    break;

                    default:
                        $item['trailer_videos_url']    = null ;
                        $item['trailer_video_player_type']   =  null ;
                    break;
                }

                return $item;
            })->first();


            // Payment Gateway Stripe 

            $Stripepayment = PaymentSetting::where('payment_type', 'Stripe')->first();

            $mode = $Stripepayment->live_mode;

            if ($mode == 0) {

                $secret_key = $Stripepayment->test_secret_key;
                $publishable_key = $Stripepayment->test_publishable_key;

            } elseif ($mode == 1) {

                $secret_key = $Stripepayment->live_secret_key;
                $publishable_key = $Stripepayment->live_publishable_key;
                
            } else {
                $secret_key = null;
                $publishable_key = null;
            }

            $data = array(
                'videodetail'    => $videodetail ,
                'video'          => $videodetail ,   // Videos - Working Social Login
                'setting'        => Setting::first(),
                'CommentSection' => CommentSection::first(),
                'source_id'      => $videodetail->id ,
                'commentable_type' => 'play_videos',
                'ThumbnailSetting' => ThumbnailSetting::first() ,
                'currency'         => CurrencySetting::first(),
                'CurrencySetting'  => CurrencySetting::pluck('enable_multi_currency')->first(),
                'publishable_key'    => $publishable_key ,
            );

            return Theme::view('video-js-Player.video.videos-details', $data);

        } catch (\Throwable $th) {
            
            // return $th->getMessage();
            return abort(404);
        }
    }

    public function video_js_fullplayer( Request $request, $slug )
    {
        try {
            
            $video_id = Video::where('slug',$slug)->latest()->pluck('id')->first();

            $videodetail = Video::where('id',$video_id)->orderBy('created_at', 'desc')->get()->map(function ($item) {

                $item['image_url']          = URL::to('public/uploads/images/'.$item->image );
                $item['player_image_url']   = URL::to('public/uploads/images/'.$item->player_image );
                $item['pdf_files_url']      = URL::to('public/uploads/videoPdf/'.$item->pdf_files) ;
                $item['transcoded_url']     = URL::to('/storage/app/public/').'/'.$item->path . '.m3u8';

                // Videos URL 

                switch (true) {

                    case $item['type'] == "mp4_url":
                    $item['videos_url'] =  $item->mp4_url ;
                    break;

                    case $item['type'] == "m3u8_url":
                    $item['videos_url'] =  $item->m3u8_url ;
                    break;

                    case $item['type'] == "embed":
                    $item['videos_url'] =  $item->embed_code ;
                    break;
                    
                    case $item['type'] == null &&  pathinfo($item['mp4_url'], PATHINFO_EXTENSION) == "mp4" :
                    $item['videos_url']   = URL::to('/storage/app/public/'.$item->path.'.m3u8');
                    break;
                    
                    case $item['type'] == null &&  pathinfo($item['mp4_url'], PATHINFO_EXTENSION) == "mov" :
                    $item['videos_url']   = $item->mp4_url ;
                    break;

                    case $item['type'] == " " && !is_null($item->transcoded_url) :
                    $item['videos_url']   = $item->transcoded_url ;
                    break;
                    
                    case $item['type'] == null :
                    $item['videos_url']   = URL::to('/storage/app/public/'.$item->path.'.m3u8' ) ;
                    break;

                    default:
                    $item['videos_url']    = null ;
                    break;
                }

                return $item;
            })->first();

            $data = array(
                'videodetail' => $videodetail ,
            );

            return Theme::view('video-js-Player.video.videos', $data);

        } catch (\Throwable $th) {
            
            // return $th->getMessage();
            return abort(404);
        }
    }

    public function video_js_watchlater(Request $request)
    {
        try {
            
            $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();

            $inputs = [
                'video_id' => $request->video_id,
                'type' => 'channel',
                'user_id' => !Auth::guest() ? Auth::user()->id : null,
                'users_ip_address' => Auth::guest() ? $geoip->getIP() : null,
            ];

            $watchlater_exist = Watchlater::where('video_id', $request->video_id)->where('type', 'channel')
                                        ->where(function ($query) use ($geoip) {
                                            if (!Auth::guest()) {
                                                $query->where('user_id', Auth::user()->id);
                                            } else {
                                                $query->where('users_ip_address', $geoip->getIP());
                                            }
                                        })->first();

        
            !is_null($watchlater_exist) ? $watchlater_exist->delete() : Watchlater::create( $inputs ) ;

            $response = array(
                'status'=> true,
                'watchlater_status' => is_null($watchlater_exist) ? "Add" : "Remove "  ,
                'message'=> is_null($watchlater_exist) ? "This video was successfully added to Watchlater's list" : "This video was successfully remove from Watchlater's list"  ,
            );

        } catch (\Throwable $th) {

            $response = array(
                'status'=> false,
                'message'=> $th->getMessage(),
              );
        }

        return response()->json(['data' => $response]); 
    }

    public function video_js_wishlist(Request $request)
    {
        try {
            
            $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();

            $inputs = [
                'video_id' => $request->video_id,
                'type' => 'channel',
                'user_id' => !Auth::guest() ? Auth::user()->id : null,
                'users_ip_address' => Auth::guest() ? $geoip->getIP() : null,
            ];

            $wishlist_exist = Wishlist::where('video_id', $request->video_id)->where('type', 'channel')
                                        ->where(function ($query) use ($geoip) {
                                            if (!Auth::guest()) {
                                                $query->where('user_id', Auth::user()->id);
                                            } else {
                                                $query->where('users_ip_address', $geoip->getIP());
                                            }
                                        })->first();

        
            !is_null($wishlist_exist) ? $wishlist_exist->delete() : Wishlist::create( $inputs ) ;

            $response = array(
                'status'=> true,
                'watchlater_status' => is_null($wishlist_exist) ? "Add" : "Remove "  ,
                'message'=> is_null($wishlist_exist) ? "This video was successfully added to wishlist's list" : "This video was successfully remove from wishlist's list"  ,
            );

        } catch (\Throwable $th) {

            $response = array(
                'status'=> false,
                'message'=> $th->getMessage(),
              );
        }

        return response()->json(['data' => $response]); 
    }

    public function video_js_Like(Request $request)
    {
        try {
            
            $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();

            $inputs = [
                'video_id' => $request->video_id,
                'user_id' => !Auth::guest() ? Auth::user()->id : null,
                'users_ip_address' => Auth::guest() ? $geoip->getIP() : null,
                'disliked'   => 0 ,
            ];

            $check_Like_exist = LikeDislike::where('video_id', $request->video_id)->where('liked',1)
                                        ->where(function ($query) use ($geoip) {
                                            if (!Auth::guest()) {
                                                $query->where('user_id', Auth::user()->id);
                                            } else {
                                                $query->where('users_ip_address', $geoip->getIP());
                                            }
                                        })->first();

            $inputs += [ 'liked'  => is_null($check_Like_exist) ? 1 : 0 , ];

            
            $Like_exist = LikeDislike::where('video_id', $request->video_id)
                                        ->where(function ($query) use ($geoip) {
                                            if (!Auth::guest()) {
                                                $query->where('user_id', Auth::user()->id);
                                            } else {
                                                $query->where('users_ip_address', $geoip->getIP());
                                            }
                                        })->first();

            !is_null($Like_exist) ? $Like_exist->find($Like_exist->id)->update($inputs) : LikeDislike::create( $inputs ) ;

            $response = array(
                'status'=> true,
                'like_status' => is_null($check_Like_exist) ? "Add" : "Remove "  ,
                'message'=> is_null($check_Like_exist) ? "You liked this video." : "You removed from liked this video."  ,
            );

        } catch (\Throwable $th) {

            $response = array(
                'status'=> false,
                'message'=> $th->getMessage(),
              );
        }

        return response()->json(['data' => $response]); 
    }

    public function video_js_disLike(Request $request)
    {
        try {
            
            $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();

            $inputs = [
                'video_id' => $request->video_id,
                'user_id' => !Auth::guest() ? Auth::user()->id : null,
                'users_ip_address' => Auth::guest() ? $geoip->getIP() : null,
                'liked'      => 0 ,
            ];

            $check_dislike_exist = LikeDislike::where('video_id', $request->video_id)->where('disliked',1)
                                        ->where(function ($query) use ($geoip) {
                                            if (!Auth::guest()) {
                                                $query->where('user_id', Auth::user()->id);
                                            } else {
                                                $query->where('users_ip_address', $geoip->getIP());
                                            }
                                        })->first();

            $inputs += [ 'disliked'  => is_null($check_dislike_exist) ? 1 : 0 , ];


            $dislike_exists = LikeDislike::where('video_id', $request->video_id)
                                        ->where(function ($query) use ($geoip) {
                                            if (!Auth::guest()) {
                                                $query->where('user_id', Auth::user()->id);
                                            } else {
                                                $query->where('users_ip_address', $geoip->getIP());
                                            }
                                        })->first();

        
            !is_null($dislike_exists) ? $dislike_exists->find($dislike_exists->id)->update($inputs) : LikeDislike::create( $inputs ) ;

            $response = array(
                'status'=> true,
                'dislike_status' => is_null($check_dislike_exist) ? "Add" : "Remove "  ,
                'message'=> is_null($check_dislike_exist) ? "You disliked this video" : "You removed from disliked this video."  ,
            );

        } catch (\Throwable $th) {

            $response = array(
                'status'=> false,
                'message'=> $th->getMessage(),
              );
        }

        return response()->json(['data' => $response]); 
    }
}
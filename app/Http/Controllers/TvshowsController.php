<?php

namespace App\Http\Controllers;
use App\User as User;
use \Redirect as Redirect;
//use Request;
use App\Setting as Setting;
use App\PaymentSetting as PaymentSetting;
use App\Slider as Slider;
use App\PpvVideo as PpvVideo;
use App\PpvCategory as PpvCategory;
use App\VerifyNumber as VerifyNumber;
use App\Subscription as Subscription;
use App\PaypalPlan as PaypalPlan;
use App\ContinueWatching as ContinueWatching;
use App\PpvPurchase as PpvPurchase;
use App\Watchlater as Watchlater;
use App\Wishlist as Wishlist;
use App\Page as Page;
use App\Episode;
use App\Series;
use App\SeriesSeason;
use App\LikeDislike as Likedislike;
use App\Genre;
use URL;
use Auth;
use View;
use Hash;
use Mail;
use Nexmo;
use App\Menu as Menu;
use Illuminate\Support\Facades\Cache;
//use Image;
use Intervention\Image\ImageManagerStatic as Image;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\Authenticatable;
use GeoIPLocation;
use Stevebauman\Location\Facades\Location;
use Carbon\Carbon;
use Session;
use App\RecentView as RecentView;
use App\CurrencySetting as CurrencySetting;
use App\Playerui as Playerui;
use App\HomeSetting;
use Theme;
use App\Channel;
use App\ModeratorsUser;
use App\SeriesGenre;
use App\SeriesSubtitle as SeriesSubtitle;

class TvshowsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $construct_name;

    public function __construct()
    {
        $settings = Setting::first();

        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
        $userIp = $geoip->getip();
        $countryName = $geoip->getCountry();
        $regionName = $geoip->getregion();
        $cityName = $geoip->getcity();

        $this->countryName = $countryName;

        $this->videos_per_page = $settings->videos_per_page;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses($Theme);

        $settings = Setting::first();

        $genre = Genre::all();
        $trending_episodes_count = Episode::where('active', '=', '1')
            ->where('status', '=', '1')
            ->where('views', '>', '5')
            ->orderBy('id', 'DESC')
            ->count();
        if ($trending_episodes_count > 0) {
            $trending_episodes = Episode::where('active', '=', '1')
                ->where('status', '=', '1')
                ->where('views', '>', '5')
                ->orderBy('id', 'DESC')
                ->get();
        } else {
            $trending_episodes = [];
        }
        $featured_episodes_count = Episode::where('active', '=', '1')
            ->where('featured', '=', '1')
            ->orderBy('views', 'DESC')
            ->count();
        if ($featured_episodes_count > 0) {
            $featured_episodes = Episode::where('active', '=', '1')
                ->where('featured', '=', '1')
                ->orderBy('views', 'DESC')
                ->get();
        } else {
            $featured_episodes = [];
        }
        $latest_series_count = Series::where('active', '=', '1')
            ->orderBy('created_at', 'DESC')
            ->count();
        if ($latest_series_count > 0) {
            $latest_series = Series::where('active', '=', '1')
                ->take(30)
                ->orderBy('created_at', 'DESC')
                ->get();
        } else {
            $latest_series = [];
        }
        $latest_episodes_count = Episode::where('active', '=', '1')
            ->where('status', '=', '1')
            ->orderBy('id', 'DESC')
            ->count();
        if ($latest_episodes_count > 0) {
            $latest_episodes = Episode::where('active', '=', '1')
                ->where('status', '=', '1')
                ->take(30)
                ->orderBy('id', 'DESC')
                ->get();
        } else {
            $latest_episodes = [];
        }
        // $featured_episodes_count = Episode::where('active', '=', '1')->where('status', '=', '1')->where('featured', '=', '1')->orderBy('id', 'DESC')->count();
        // if ($featured_episodes_count > 0) {
        //     $featured_episodes = Episode::where('active', '=', '1')->where('status', '=', '1')->where('featured', '=', '1')->take(10)->orderBy('id', 'DESC')->get();
        // } else {
        //         $featured_episodes = [];
        // }

        // Free content videos
        $free_series_count = Series::where('active', '=', '1')
            ->orderBy('created_at', 'DESC')
            ->count();
        if ($free_series_count > 0) {
            $free_series = Series::where('active', '=', '1')
                ->orderBy('created_at', 'DESC')
                ->get();
        } else {
            $free_series = [];
        }
        $free_episodes_count = Episode::where('active', '=', '1')
            ->where('status', '=', '1')
            ->orderBy('id', 'DESC');
        if (Auth::guest()) {
            $free_episodes_count = $free_episodes_count->where('access', 'guest');
        }
        $free_episodes_count = $free_episodes_count->count();
        if ($free_episodes_count > 0) {
            $free_episodes = Episode::where('active', '=', '1')
                ->where('status', '=', '1')
                ->orderBy('id', 'DESC');
            if (Auth::guest()) {
                $free_episodes = $free_episodes->where('access', 'guest');
            }

            $free_episodes = $free_episodes->get();
        } else {
            $free_episodes = [];
        }

        //  $trending_episodes = Episode::where('active', '=', '1')->where('status', '=', '1')->where('views', '>', '5')->orderBy('created_at', 'DESC')->get();
        //  $latest_episodes = Episode::where('active', '=', '1')->where('status', '=', '1')->take(10)->orderBy('created_at', 'DESC')->get();
        //  $featured_episodes = Episode::where('active', '=', '1')->where('featured', '=', '1')->orderBy('views', 'DESC')->get();
        //  $latest_series = Series::where('active', '=', '1')->take(10)->orderBy('created_at', 'DESC')->get();
        $currency = CurrencySetting::first();

        $free_Contents = Episode::where('active', '=', '1')
            ->where('status', '=', '1')
            ->where('access', '=', 'guest')
            ->orderBy('created_at', 'DESC')
            ->get();
        
        $pages = Page::all();
        $data = [
            'episodes' => Episode::where('active', '=', '1')
                ->where('status', '=', '1')
                ->orderBy('id', 'DESC')
                ->simplePaginate(120000),
            'trendings' => $trending_episodes,
            'latest_episodes' => $latest_episodes,
            'featured_episodes' => $featured_episodes,
            'latest_series' => $latest_series,
            'current_page' => 1,
            'genres' => $genre,
            'pagination_url' => '/series',
            'settings' => $settings,
            'pages' => $pages,
            'free_series' => $free_series,
            'free_episodes' => $free_episodes,
            'currency' => $currency,
            'free_Contents' => $free_Contents,
            'banner' => Episode::where('active', '1')
                ->where('status', '1')
                ->where('banner', '1')
                ->orderBy('id', 'DESC')
                ->simplePaginate(120000),
        ];

        return Theme::view('tv-home', $data);
    }

    public function play_episode($series_name, $episode_name)
    {
        try {


        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
           
        $Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses($Theme);
        $settings = Setting::first();

        $auth_user = Auth::user();

        if ($auth_user == null) {
            $auth_user_id = null;
        } else {
            $auth_user_id = Auth::user()->id;
        }

        $episodess = Episode::where('slug', '=', $episode_name)
            ->orderBy('id', 'DESC')
            ->first();

        $source_id = Episode::where('slug', '=', $episode_name)
            ->pluck('id')
            ->first();

        $episode_watchlater = Watchlater::where('episode_id', $episodess->id)
            ->where('user_id', $auth_user_id)
            ->first();

        $episode_Wishlist = Wishlist::where('episode_id', $episodess->id);

        if(!Auth::guest()){
            $episode_Wishlist = $episode_Wishlist->where('user_id', $auth_user_id);

        }else{
            $episode_Wishlist = $episode_Wishlist->where('users_ip_address', $geoip->getIP());
            
        }
        $episode_Wishlist = $episode_Wishlist->first();

            // Subtitle Data 
            
        $playerui = Playerui::first();
        
        $subtitle = SeriesSubtitle::where('episode_id', '=', $episodess->id)->get();

        $subtitles_name = SeriesSubtitle::select('subtitles.language as language')
            ->Join('subtitles', 'series_subtitles.shortcode', '=', 'subtitles.short_code')
            ->where('series_subtitles.episode_id', $episodess->id)
            ->get();
            
        if (Auth::guest() && $settings->access_free == 0):
            return Redirect::to('/login');
        endif;

        $episode = Episode::where('slug', '=', $episode_name)
            ->orderBy('id', 'DESC')
            ->first();

        $id = $episode->id;

        $season = SeriesSeason::where('series_id', '=', $episode->series_id)
            ->with('episodes')
            ->get();

        $series = Series::find($episode->series_id);

        $episodenext = Episode::where('id', '>', $id)
            ->where('series_id', '=', $episode->series_id)
            ->first();
        $episodeprev = Episode::where('id', '<', $id)
            ->where('series_id', '=', $episode->series_id)
            ->first();

        $category_name = SeriesGenre::select('series_genre.name as categories_name','series_genre.slug as categories_slug')
            ->Join('series_categories', 'series_categories.category_id', '=', 'series_genre.id')
            ->where('series_categories.series_id', $episode->series_id)
            ->get();

        //Make sure series is active

        $view = new RecentView();
        $view->user_id = Auth::User() ? Auth::User()->id : null;
        $view->sub_user = null;
        $view->country_name = $this->countryName ? $this->countryName : null;
        $view->visited_at = Carbon::now()->year;
        $view->episode_id = $id;
        $view->save();

        $wishlisted = false;
        if (!Auth::guest()):
            $wishlisted = Wishlist::where('user_id', '=', Auth::user()->id)
                ->where('episode_id', '=', $id)
                ->first();
        endif;
        
        // use App\PpvPurchase as PpvPurchase;

        if (!empty($episode->ppv_price) && $settings->access_free == 0) {
            $ppv_exits = PpvPurchase::where('user_id', '=', Auth::user()->id)
                ->where('episode_id', '=', $id)
                ->count();
        } else {
            $ppv_exits = 0;
        }

        if ($series->ppv_status == 1 && $settings->access_free == 0) {
            $ppv_exits = PpvPurchase::where('user_id', '=', Auth::user()->id)
                ->where('series_id', '=', $series->id)
                ->count();
        } else {
            $ppv_exits = 0;
        }

        $watchlater = false;

        if (!Auth::guest()):
            $watchlater = Watchlater::where('user_id', '=', Auth::user()->id)
                ->where('episode_id', '=', $id)
                ->first();
        endif;

        if ((!Auth::guest() && Auth::user()->role == 'admin') || $series->active) {
            $view_increment = $this->handleViewCount($id);
            $currency = CurrencySetting::first();

            $playerui = Playerui::first();
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

            if (!empty($season)) {
                $ppv_price = $season[0]->ppv_price;
                $ppv_interval = $season[0]->ppv_interval;
                $season_id = $season[0]->id;
            }
            // Free Interval Episodes
            if (!empty($ppv_price) && !empty($ppv_interval)) {
                foreach ($season as $key => $seasons):
                    foreach ($seasons->episodes as $key => $episodes):
                        if ($seasons->ppv_interval > $key):
                            $free_episode[$episodes->slug] = Episode::where('slug', '=', $episodes->slug)->count();
                        else:
                            $paid_episode[] = Episode::where('slug', '=', $episodes->slug)
                                ->orderBy('id', 'DESC')
                                ->count();
                        endif;
                    endforeach;
                endforeach;
                if (array_key_exists($episode_name, $free_episode)) {
                    $free_episode = 1;
                } else {
                    $free_episode = 0;
                }
            }

            // Season Ppv Purchase exit check
            if (($ppv_price != 0 && !Auth::guest()) || ($ppv_price != null && !Auth::guest())) {
                $ppv_exits = PpvPurchase::where('user_id', '=', Auth::user()->id)
                    // ->where('season_id', '=', $season_id)
                    ->where('series_id', '=', $episode->series_id)
                    ->count();

                    $PpvPurchase = PpvPurchase::where('series_id', '=', $episode->series_id)
                    ->where('season_id', '=', $episode->season_id)
                    ->count();
                    // dd($PpvPurchase);
                    $checkseasonppv = SeriesSeason::where('series_id', '=', $episode->series_id)
                    ->first();
            
                    if ($checkseasonppv->access == "ppv" ) {
            
                        if($checkseasonppv->ppv_interval > 0 ){
            
                            $ppvepisode = Episode::where('id', '=', $id)
                            ->where('series_id', '=', $episode->series_id)
                            ->where('episode_order', '>', $checkseasonppv->ppv_interval)
                            ->count();
                                if($ppvepisode > 0 && $PpvPurchase == 0){
                                    $checkseasonppv_exits = 1;
                                }else{
                                    $checkseasonppv_exits = 0;
                                }            
                        }else{
                            
                            $checkseasonppv_exits = 1;
                        }
            
                    } else {
                        $ppv_exits = 0;
                    }
            } else {
                $checkseasonppv = SeriesSeason::where('series_id', '=', $episode->series_id)
                ->first();

                $PpvPurchase = PpvPurchase::where('series_id', '=', $episode->series_id)
                ->where('season_id', '=', $episode->season_id)
                ->count();
        
                if ($checkseasonppv->access == "ppv" ) {
        
                    if($checkseasonppv->ppv_interval > 0 ){
        
                        $ppvepisode = Episode::where('id', '=', $id)
                        ->where('series_id', '=', $episode->series_id)
                        ->where('episode_order', '>', $checkseasonppv->ppv_interval)
                        ->count();
                            if($ppvepisode > 0 && $PpvPurchase == 0){
                                $checkseasonppv_exits = 1;
                            }else{
                                $checkseasonppv_exits = 0;
                            }            
                    }else{
                        
                        $checkseasonppv_exits = 1;
                    }
        
                } else {
                    $checkseasonppv_exits = 0;
                }
                $ppv_exits = 0;
            }

            if (($series->ppv_status == 0 && $ppv_price == 0) || $ppv_price == null) {
                $series_ppv_status = 0;
                $free_episode = 1;
            } else {
                $series_ppv_status = 1;
            }

            if (!Auth::guest()) {
                if (Auth::user()->role == 'admin') {
                    $free_episode = 1;
                } elseif (Auth::user()->role == 'registered') {
                    $free_episode = 1;
                } elseif (Auth::user()->role == 'subscriber') {
                    $free_episode = 1;
                }
            }

            if (!Auth::guest()):
                $like_dislike = LikeDislike::where('user_id', '=', Auth::user()->id)
                    ->where('episode_id', '=', $id)
                    ->first();
            endif;
            if (Auth::guest()):
                $like_dislike = [];
            endif;

            if (@$episode->uploaded_by == 'Channel') {
                $user_id = $episode->user_id;

                $user = Channel::where('channels.id', '=', $user_id)
                    ->join('users', 'channels.email', '=', 'users.email')
                    ->select('users.id as user_id')
                    ->first();

                if (!Auth::guest() && $user_id == Auth::user()->id) {
                    $video_access = 'free';
                } else {
                    $video_access = 'pay';
                }
            } elseif (@$episode->uploaded_by == 'CPP') {
                $user_id = $episode->user_id;

                $user = ModeratorsUser::where('moderators_users.id', '=', $user_id)
                    ->join('users', 'moderators_users.email', '=', 'users.email')
                    ->select('users.id as user_id')
                    ->first();
                if (!Auth::guest() && $user_id == Auth::user()->id) {
                    $video_access = 'free';
                } else {
                    $video_access = 'pay';
                }
            } else {
                if (!Auth::guest() && @$episode->access == 'ppv' && Auth::user()->role != 'admin') {
                    $video_access = 'pay';
                } else {
                    $video_access = 'free';
                }
            }

            $series_categories = Series::join('series_categories', 'series.id', '=', 'series_categories.series_id')
                                    ->where('series.id',$series->id)->pluck('series_categories.category_id');

            $series_lists = Series::join('series_categories', 'series.id', '=', 'series_categories.series_id')
                ->whereIn('series_categories.category_id',$series_categories)
                ->where('series.id','!=',$series->id)
                ->where('series.active',1)
                ->groupBy('series.id')->get();


            if ((!Auth::guest() && Auth::user()->role == 'admin') || $series_ppv_status != 1 || $ppv_exits > 0 || $free_episode > 0) {
                $data = [
                    'currency' => $currency,
                    'video_access' => $video_access,
                    'free_episode' => $free_episode,
                    'ppv_exits' => $ppv_exits,
                    'checkseasonppv_exits' => $checkseasonppv_exits,
                    'publishable_key' => $publishable_key,
                    'episode' => $episode,
                    'season' => $season,
                    'series' => $series,
                    'playerui_settings' => $playerui,
                    'episodenext' => $episodenext,
                    'episodeprev' => $episodeprev,
                    'mywishlisted' => $wishlisted,
                    'watchlatered' => $watchlater,
                    'url' => 'episodes',
                    'settings' => $settings,
                    'menu' => Menu::orderBy('order', 'ASC')->get(),
                    'view_increment' => $view_increment,
                    'series_categories' => SeriesGenre::all(),
                    'pages' => Page::where('active', '=', 1)->get(),
                    'episode_watchlater' => $episode_watchlater,
                    'episode_Wishlist' => $episode_Wishlist,
                    'like_dislike' => $like_dislike,
                    'source_id' => $source_id,
                    'commentable_type' => 'play_episode',   
                    'series_lists' =>   $series_lists ,
                    'subtitles_name' =>   $subtitles_name ,
                    'playerui_settings' =>   $playerui ,
                    'episodesubtitles' =>   $subtitle ,
                    'Stripepayment' => PaymentSetting::where('payment_type', 'Stripe')->first(),
                    'PayPalpayment' => PaymentSetting::where('payment_type', 'PayPal')->first(),
                    'Paystack_payment_settings' => PaymentSetting::where('payment_type', 'Paystack')->first(),
                    'Razorpay_payment_settings' => PaymentSetting::where('payment_type', 'Razorpay')->first(),
                    'CinetPay_payment_settings' => PaymentSetting::where('payment_type', 'CinetPay')->first(),
                    'category_name'             => $category_name ,
                ];
                
                if (Auth::guest() && $settings->access_free == 1) {
                    return Theme::view('beforloginepisode', $data);
                } else {
                    return Theme::view('episode', $data);
                }
            } else {
                $data = [
                    'currency' => $currency,
                    'video_access' => $video_access,
                    'ppv_exits' => $ppv_exits,
                    'free_episode' => $free_episode,
                    'publishable_key' => $publishable_key,
                    'episode' => $episode,
                    'season' => $season,
                    'series' => $series,
                    'playerui_settings' => $playerui,
                    'episodenext' => $episodenext,
                    'episodeprev' => $episodeprev,
                    'mywishlisted' => $wishlisted,
                    'watchlatered' => $watchlater,
                    'url' => 'episodes',
                    'settings' => $settings,
                    'menu' => Menu::orderBy('order', 'ASC')->get(),
                    'view_increment' => $view_increment,
                    'series_categories' => SeriesGenre::all(),
                    'pages' => Page::where('active', '=', 1)->get(),
                    'episode_watchlater' => $episode_watchlater,
                    'episode_Wishlist' => $episode_Wishlist,
                    'like_dislike' => $like_dislike,
                    'source_id' => $source_id,
                    'commentable_type' => 'play_episode',
                    'series_lists' =>  $series_lists ,
                    'subtitles_name' =>   $subtitles_name ,
                    'playerui_settings' =>   $playerui ,
                    'episodesubtitles' =>   $subtitle ,
                    'category_name'             => $category_name ,
                ];

                if (Auth::guest() && $settings->access_free == 1) {
                    return Theme::view('beforloginepisode', $data);
                } else {
                    return Theme::view('episode', $data);
                }

                // return Redirect::to('/tv-shows')->with(array('message' => 'Sorry, To Watch series You have to purchase.', 'note_type' => 'error'));
            }
        } else {
            return Redirect::to('series-list')->with(['note' => 'Sorry, this series is no longer active.', 'note_type' => 'error']);
        }

        } catch (\Throwable $th) {

            // return $th->getMessage();
            return abort(404);
        }
    }

    public function handleViewCount($id)
    {
        if (Auth::guest()):
            return Redirect::to('/login');
        endif;
        // check if this key already exists in the view_media session
        $blank_array = [];
        if (!array_key_exists($id, Session::get('viewed_video', $blank_array))) {
            try {
                // increment view
                $video = Episode::find($id);
                $video->views = $video->views + 1;
                $video->save();
                // Add key to the view_media session
                Session::put('viewed_video.' . $id, time());
                return true;
            } catch (Exception $e) {
                return false;
            }
        } else {
            return false;
        }
    }

    public function play_series($name)
    {
        $Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses($Theme);

        $currency = CurrencySetting::first();

        $settings = Setting::first();
       
        if (Auth::guest() && $settings->access_free == 0):
            return Redirect::to('/login');
        endif;

        $series = Series::where('slug', '=', $name)->first();

        if (@$series->uploaded_by == 'Channel') {
            $user_id = $series->user_id;

            $user = Channel::where('channels.id', '=', $user_id)
                ->join('users', 'channels.email', '=', 'users.email')
                ->select('users.id as user_id')
                ->first();
            if (!Auth::guest() && $user_id == Auth::user()->id) {
                $video_access = 'free';
            } else {
                $video_access = 'pay';
            }
        } elseif (@$series->uploaded_by == 'CPP') {
            $user_id = $series->user_id;

            $user = ModeratorsUser::where('moderators_users.id', '=', $user_id)
                ->join('users', 'moderators_users.email', '=', 'users.email')
                ->select('users.id as user_id')
                ->first();
            if (!Auth::guest() && $user_id == Auth::user()->id) {
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
        $series = Series::where('slug', '=', $name)->first();

        $id = $series->id;

        if ($series->ppv_status == 1) {
            $ppv_exits = PpvPurchase::where('user_id', '=', Auth::user()->id)
                ->where('series_id', '=', $id)
                ->count();
        } else {
            $ppv_exits = 0;
        }

      
        $season = SeriesSeason::where('series_id', '=', $id)
            ->with('episodes')
            ->get();

        $season_trailer = SeriesSeason::where('series_id', '=', $id)->get();

        $episodefirst = Episode::where('series_id', '=', $id)
            ->orderBy('id', 'ASC')
            ->first();

          
        $category_name = SeriesGenre::select('series_genre.name as categories_name','series_genre.slug as categories_slug')
            ->Join('series_categories', 'series_categories.category_id', '=', 'series_genre.id')
            ->where('series_categories.series_id', $series->id)
            ->get();
            

        //Make sure series is active
        if ((!Auth::guest() && Auth::user()->role == 'admin') || $series->active || $ppv_exits > 0) {
            $view_increment = 5;
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
            $series = Series::where('slug', '=', $name)->first();
           
            $data = [
                'series_data' => $series,
                'currency' => $currency,
                'video_access' => $video_access,
                'ppv_exits' => $ppv_exits,
                'season' => $season,
                'season_trailer' => $season_trailer,
                'publishable_key' => $publishable_key,
                'settings' => $settings,
                'episodenext' => $episodefirst,
                'url' => 'episodes',
                'menu' => Menu::orderBy('order', 'ASC')->get(),
                'view_increment' => $view_increment,
                'series_categories' => SeriesGenre::all(),
                'category_name'     => $category_name ,
                'pages' => Page::where('active', '=', 1)->get(),
            ];

            return Theme::view('series', $data);
        } else {
            
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

            $data = [
                'series_data' => $series,
                'currency' => $currency,
                'video_access' => $video_access,
                'ppv_exits' => $ppv_exits,
                'season' => $season,
                'season_trailer' => $season_trailer,
                'publishable_key' => $publishable_key,
                'settings' => $settings,
                'episodenext' => $episodefirst,
                'url' => 'episodes',
                'menu' => Menu::orderBy('order', 'ASC')->get(),
                'view_increment' => 5 ,
                'series_categories' => SeriesGenre::all(),
                'category_name'     => $category_name ,
                'pages' => Page::where('active', '=', 1)->get(),
            ];
            return Redirect::to('series')->with(['note' => 'Sorry, this series is no longer active.', 'note_type' => 'error']);
        }
    }

    public function PlayEpisode($episode_name)
    {
        try{
            $settings = Setting::first();

            if (Auth::guest() && $settings->access_free == 0):
                return Redirect::to('/login');
            endif;
            
            $episode = Episode::where('slug', '=', $episode_name)->first();

            $id = $episode->id;

            $season = SeriesSeason::where('series_id', '=', $episode->series_id)
                ->with('episodes')
                ->get();
            
            $series = Series::find($episode->series_id);
            
            $wishlisted = false;
            if (!Auth::guest()):
                $wishlisted = Wishlist::where('user_id', '=', Auth::user()->id)
                    ->where('episode_id', '=', $id)
                    ->first();
            endif;
            
            $watchlater = false;
            if (!Auth::guest()):
                $watchlater = Watchlater::where('user_id', '=', Auth::user()->id)
                    ->where('episode_id', '=', $id)
                    ->first();
            endif;
            
            if ($series->ppv_status == 1 && $settings->access_free == 0) {
                $ppv_exits = PpvPurchase::where('user_id', '=', Auth::user()->id)
                    ->where('series_id', '=', $series->id)
                    ->count();
            } else {
                $ppv_exits = 0;
            }
            
            if ((!Auth::guest() && Auth::user()->role == 'admin') || $series->active) {
                if ($series->ppv_status != 1 || $ppv_exits > 0) {
                    $view_increment = $this->handleViewCount($id);
            
                    $playerui = Playerui::first();
                    $data = [
                        'episode' => $episode,
                        'season' => $season,
                        'series' => $series,
                        'playerui_settings' => $playerui,
                        'episodenext' => $episodenext,
                        'episodeprev' => $episodeprev,
                        'mywishlisted' => $wishlisted,
                        'watchlatered' => $watchlater,
                        'url' => 'episodes',
                        'settings' => $settings,
                        'menu' => Menu::orderBy('order', 'ASC')->get(),
                        'view_increment' => $view_increment,
                        'series_categories' => SeriesGenre::all(),
                        'pages' => Page::where('active', '=', 1)->get(),
                    ];
            
                    if (Auth::guest() && $settings->access_free == 1) {
                        return Theme::view('beforloginepisode', $data);
                    } else {
                        return Theme::view('episode', $data);
                    }
                } else {
                    return Redirect::to('/tv-shows')->with(['message' => 'Sorry, To Watch series You have to purchase.', 'note_type' => 'error']);
                }
            } else {
                return Redirect::to('series-list')->with(['note' => 'Sorry, this series is no longer active.', 'note_type' => 'error']);
            }
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    public function LikeEpisode(Request $request)
    {
        if (Auth::guest()) {
            $data = [
                'message' => 'guest',
            ];

            return $data;
        } else {
            $user_id = Auth::user()->id;

            $episode = LikeDisLike::where('episode_id', '=', $request->episode_id)
                ->where('user_id', '=', $user_id)
                ->get();
            $episode_count = LikeDisLike::where('episode_id', '=', $request->episode_id)
                ->where('user_id', '=', $user_id)
                ->count();

            if ($episode_count > 0) {
                $episode_new = LikeDisLike::where('episode_id', '=', $request->episode_id)
                    ->where('user_id', '=', $user_id)
                    ->first();
                $episode_new->liked = 1;
                $episode_new->episode_id = $request->episode_id;
                $episode_new->save();
                $data = [
                    'message' => 'Added to Like Episode',
                ];
            } else {
                $user_id = Auth::user()->id;

                $episode_new = new LikeDisLike();
                $episode_new->user_id = $user_id;
                $episode_new->liked = 1;
                $episode_new->episode_id = $request->episode_id;
                $episode_new->save();
                $episode_new->save();
                $data = [
                    'message' => 'Added to Like Episode',
                ];
            }
            return $data;
        }
    }

    public function RemoveLikeEpisode(Request $request)
    {
        $user_id = Auth::user()->id;

        $episode = LikeDisLike::where('episode_id', '=', $request->episode_id)
            ->where('user_id', '=', $user_id)
            ->get();
        $episode_count = LikeDisLike::where('episode_id', '=', $request->episode_id)
            ->where('user_id', '=', $user_id)
            ->count();
        if ($episode_count > 0) {
            $episode_new = LikeDisLike::where('episode_id', '=', $request->episode_id)
                ->where('user_id', '=', $user_id)
                ->first();
            $episode_new->liked = 0;
            $episode_new->episode_id = $request->episode_id;
            $episode_new->save();
            $data = [
                'message' => 'Removed from Liked Episode',
            ];
        } else {
            $data = [
                'message' => 'NO Data',
            ];
        }

        return $data;
    }

    public function DisLikeEpisode(Request $request)
    {
        if (Auth::guest()) {
            $data = [
                'message' => 'guest',
            ];

            return $data;
        } else {
            $user_id = Auth::user()->id;

            $episode = LikeDisLike::where('episode_id', '=', $request->episode_id)
                ->where('user_id', '=', $user_id)
                ->get();
            $episode_count = LikeDisLike::where('episode_id', '=', $request->episode_id)
                ->where('user_id', '=', $user_id)
                ->count();

            if ($episode_count > 0) {
                $episode_new = LikeDisLike::where('episode_id', '=', $request->episode_id)
                    ->where('user_id', '=', $user_id)
                    ->first();
                $episode_new->disliked = 1;
                $episode_new->episode_id = $request->episode_id;
                $episode_new->save();
                $data = [
                    'message' => 'Added to DisLike Episode',
                ];
            } else {
                $user_id = Auth::user()->id;

                $episode_new = new LikeDisLike();
                $episode_new->user_id = $user_id;
                $episode_new->disliked = 1;
                $episode_new->episode_id = $request->episode_id;
                $episode_new->save();
                $episode_new->save();
                $data = [
                    'message' => 'Added to DisLike Episode',
                ];
            }
            return $data;
        }
    }

    public function RemoveDisLikeEpisode(Request $request)
    {
        $user_id = Auth::user()->id;

        $episode = LikeDisLike::where('episode_id', '=', $request->episode_id)
            ->where('user_id', '=', $user_id)
            ->get();
        $episode_count = LikeDisLike::where('episode_id', '=', $request->episode_id)
            ->where('user_id', '=', $user_id)
            ->count();
        if ($episode_count > 0) {
            $episode_new = LikeDisLike::where('episode_id', '=', $request->episode_id)
                ->where('user_id', '=', $user_id)
                ->first();
            $episode_new->disliked = 0;
            $episode_new->episode_id = $request->episode_id;
            $episode_new->save();
            $data = [
                'message' => 'Removed from Liked Episode',
            ];
        } else {
            $data = [
                'message' => 'NO Data',
            ];
        }

        return $data;
    }

    public function Embedplay_episode($series_name, $episode_name)
    {
        //
        $Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses($Theme);
        $settings = Setting::first();

        $auth_user = Auth::user();

        if ($auth_user == null) {
            $auth_user_id = null;
        } else {
            $auth_user_id = Auth::user()->id;
        }

        $episodess = Episode::where('slug', '=', $episode_name)
            ->orderBy('id', 'DESC')
            ->first();

        $episode = Episode::where('slug', '=', $episode_name)
            ->orderBy('id', 'DESC')
            ->first();
        $id = $episode->id;
        $season = SeriesSeason::where('series_id', '=', $episode->series_id)
            ->with('episodes')
            ->get();

        $series = Series::find($episode->series_id);

        $data = [
            'episode' => $episode,
            'season' => $season,
            'series' => $series,
            'settings' => $settings,
        ];
        return Theme::view('iframeembedepisode', $data);
    }

    public function SeriesCategory($slug)
    {
        try {

            $Theme = HomeSetting::pluck('theme_choosen')->first();
            Theme::uses($Theme);

            $CategorySeries =  SeriesGenre::where('slug',$slug)->first();
            $SeriesGenre = $CategorySeries != null ? $CategorySeries->specific_category_series : array();
            
            $Series_Genre = $SeriesGenre->all();

            $data = array( 
                        'SeriesGenre' => $Series_Genre ,
                        'CategorySeries' => $CategorySeries
                    );

            return Theme::view('partials.home.SeriesCategory',$data);

        } catch (\Throwable $th) {
            // return $th->getMessage();
            return abort(404);
        }
    }

    
    public function SeriescategoryList(Request $request)
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
                'category_list' => SeriesGenre::all(),
            ];

            return Theme::view('SeriescategoryList', $data);
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

}

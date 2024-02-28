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
use App\SeriesNetwork;

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
                ->where('status', '=', '1')
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
        // try {

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
            $season_details = SeriesSeason::where('series_id', '=', $episode->series_id)
            ->first();

            if (!empty($season)) {
                $ppv_price = $season[0]->ppv_price;
                $ppv_interval = $season[0]->ppv_interval;
                $season_id = $season[0]->id;
            }

            if (!Auth::guest() ):

            $PpvPurchase = PpvPurchase::where('user_id',Auth::user()->id)
                            ->where('series_id', '=', $episode->series_id)
                            ->where('season_id', '=', $episode->season_id)
                            ->count();
            $SeriesPpvPurchase = PpvPurchase::where('user_id',Auth::user()->id)
                                ->where('series_id', '=', $episode->series_id)
                                ->count();
            else:
                $PpvPurchase = 0;
                $SeriesPpvPurchase =0;
            endif;
            
               // Free Interval Episodes
            if ( !Auth::guest() && $season_details->access == 'ppv' || !Auth::guest() &&  !empty($ppv_price) && !empty($ppv_interval) || !Auth::guest() && $ppv_price > 0 || !Auth::guest() &&  $ppv_price < 0 ) {
                foreach ($season as $key => $seasons):
                    foreach ($seasons->episodes as $key => $episodes):
                        if ($seasons->ppv_interval > $key ):
                              
                            $free_episode[$episodes->slug] = Episode::where('slug', '=', $episodes->slug)->count();
                        else:
                            $paid_episode[] = Episode::where('slug', '=', $episodes->slug)
                                ->orderBy('id', 'DESC')
                                ->count();
                        endif;
                    endforeach;
                endforeach;
                // exit;

                $PpvPurchase = PpvPurchase::where('user_id',Auth::user()->id)
                                ->where('series_id', '=', $episode->series_id)
                                ->where('season_id', '=', $episode->season_id)
                                ->count();
                $season_details = SeriesSeason::where('series_id', '=', $episode->series_id)
                    ->first();
                    if (!Auth::guest() && !empty($free_episode)):
                        if (array_key_exists($episode_name, $free_episode) && $series->access != 'subscriber' || Auth::user()->role == 'admin' ||  
                        $season_details->access == 'free' && $series->access != 'subscriber' && $series->access != 'registered' || 
                        $season_details->access == 'free' && $series->access == 'guest' && Auth::user()->role == 'subscriber'  || 
                        $season_details->access == 'free' && $series->access == 'registered' && Auth::user()->role == 'subscriber'  || 
                        $series->access == 'subscriber' && Auth::user()->role == 'subscriber'  || 
                        $series->access == 'guest' && $season_details->access == 'free' && Auth::user()->role == 'registered' ||
                        $season_details->access == 'free' && $series->access == 'registered' && Auth::user()->role == 'registered'  ||
                        Auth::user()->role == 'subscriber' &&  $season_details->access == 'free'  ) {
                    $free_episode = 1;
                    } elseif($series->access == 'registered' && $SeriesPpvPurchase > 0 || $series->access == 'guest' && $SeriesPpvPurchase > 0 || Auth::user()->role == 'admin'){
                        
                        $free_episode = 1;
                    } elseif($PpvPurchase > 0){
                    $free_episode = 1;
                    }elseif( $series->access == 'guest' && $season_details->access != 'ppv' || $season_details->access != 'ppv' && $series->access == 'registered' && Auth::user()->role == 'registered' 
                        || $season_details->access != 'ppv' && $series->access == 'registered' && Auth::user()->role == 'subscriber' || $season_details->access != 'ppv' 
                        && $series->access == 'subscriber' && Auth::user()->role == 'subscriber' || Auth::user()->role == 'admin'){
                        $free_episode = 1;
                    }else {

                        $free_episode = 0;
                    }
                elseif($series->access == 'guest' && $season_details->access == 'free'  && $season_details->access != 'ppv' || 
                       $series->access == 'registered' && Auth::user()->role == 'registered'   && $season_details->access != 'ppv' ||
                       $series->access == 'registered' && Auth::user()->role == 'subscriber'  && $season_details->access != 'ppv' || 
                       $series->access == 'subscriber' && Auth::user()->role == 'subscriber'  && $season_details->access != 'ppv'
                       || Auth::user()->role == 'admin' ):
                            $free_episode = 1;
                else:
                    $PpvPurchase = 0;
                    $SeriesPpvPurchase =0;
                endif;
                   // Free Interval Episodes
                if ( !Auth::guest() && $season_details->access == 'ppv'
                 || !Auth::guest() &&  !empty($ppv_price) && !empty($ppv_interval) && $season_details->access == 'ppv'
                 || !Auth::guest() && $ppv_price > 0 && $season_details->access == 'ppv' || !Auth::guest() &&  $ppv_price < 0 && $season_details->access == 'ppv' ) {
                    
                    foreach ($season as $key => $seasons):
                        foreach ($seasons->episodes as $key => $episodes):
                            if ($seasons->ppv_interval > $key ):
                                  
                                $free_episodes[$episodes->slug] = Episode::where('slug', '=', $episodes->slug)->count();
                            else:
                                $paid_episode[] = Episode::where('slug', '=', $episodes->slug)
                                    ->orderBy('id', 'DESC')
                                    ->count();
                            endif;
                        endforeach;
                    endforeach;
                    // exit;

                    $PpvPurchase = PpvPurchase::where('user_id',Auth::user()->id)
                                                ->where('series_id', '=', $episode->series_id)
                                                ->where('season_id', '=', $episode->season_id)
                                                ->count();
                    $SeriesPpvPurchase = PpvPurchase::where('user_id',Auth::user()->id)
                                    ->where('series_id', '=', $episode->series_id)
                                    ->count();
                    $season_details = SeriesSeason::where('series_id', '=', $episode->series_id)
                        ->first();
                        if (!Auth::guest() && !empty($free_episodes)):
                            if ($season_details->access != 'free' && array_key_exists($episode_name, $free_episodes) && $series->access != 'subscriber' || Auth::user()->role == 'admin' ||  
                            $season_details->access == 'free' && $series->access != 'subscriber' && $series->access != 'registered' || 
                            $season_details->access == 'free' && $series->access == 'guest' && Auth::user()->role == 'subscriber'  || 
                            $season_details->access == 'free' && $series->access == 'registered' && Auth::user()->role == 'subscriber'  || 
                            $series->access == 'subscriber' && Auth::user()->role == 'subscriber'  || 
                            $series->access == 'guest' && $season_details->access == 'free' && Auth::user()->role == 'registered' ||
                            $season_details->access == 'free' && $series->access == 'registered' && Auth::user()->role == 'registered'  ||
                            Auth::user()->role == 'subscriber' &&  $season_details->access == 'free' ) {
                        $free_episode = 1;
                        } elseif($series->access == 'registered' && $SeriesPpvPurchase > 0 || $series->access == 'guest' && $SeriesPpvPurchase > 0){
                            
                            $free_episode = 1;
                        } elseif($PpvPurchase > 0){
                        $free_episode = 1;
                        }elseif( $series->access == 'guest' && $season_details->access != 'ppv' || $season_details->access != 'ppv' && $series->access == 'registered' && Auth::user()->role == 'registered' 
                            || $season_details->access != 'ppv' && $series->access == 'registered' && Auth::user()->role == 'subscriber' || $season_details->access != 'ppv' && $series->access == 'subscriber' && Auth::user()->role == 'subscriber'){
                            $free_episode = 1;
                        }else {
    
                            $free_episode = 0;
                        }
                    elseif($series->access == 'guest' && $season_details->access == 'free'  && $season_details->access != 'ppv' || 
                           $series->access == 'registered' && Auth::user()->role == 'registered'   && $season_details->access != 'ppv' ||
                           $series->access == 'registered' && Auth::user()->role == 'subscriber'  && $season_details->access != 'ppv' || 
                           $series->access == 'subscriber' && Auth::user()->role == 'subscriber'  && $season_details->access != 'ppv'
                            ):
                                $free_episode = 1;
                    else:
                        if($series->access == 'registered' && $SeriesPpvPurchase > 0 || $series->access == 'guest' && $SeriesPpvPurchase > 0){
                            $free_episode = 1;
                        } elseif($series->access == 'registered' && $PpvPurchase > 0 || $series->access == 'guest' && $PpvPurchase > 0){
                        $free_episode = 1;
                        }elseif( $series->access == 'guest' && $season_details->access != 'ppv'  
                            || $season_details->access != 'ppv' && $series->access == 'registered' && Auth::user()->role == 'registered' 
                            || $season_details->access != 'ppv' && $series->access == 'registered' && Auth::user()->role == 'subscriber' 
                            || $season_details->access != 'ppv' && $series->access == 'subscriber' && Auth::user()->role == 'subscriber'
                            || $series->access == 'subscriber' && Auth::user()->role == 'subscriber' || $season_details->access == 'ppv'  && Auth::user()->role == 'subscriber'){
                            $free_episode = 1;
                        }else {
    
                            $free_episode = 0;
                        }
    
                    endif;
    
                    }elseif (!Auth::guest() && $series->access != 'subscriber' || !Auth::guest() && Auth::user()->role == 'admin'   
                        || !Auth::guest() && $season_details->access == 'free' && $series->access != 'registered'   && $series->access != 'subscriber'  
                        || $season_details->access == 'free' && $series->access == 'guest' && !Auth::guest() && Auth::user()->role == 'subscriber'  
                        || $season_details->access == 'free' && $series->access == 'registered' && !Auth::guest() && Auth::user()->role == 'subscriber'  
                        || $series->access == 'subscriber' && !Auth::guest() && Auth::user()->role == 'subscriber'   
                        || $series->access == 'guest' && $season_details->access == 'free' && !Auth::guest() && Auth::user()->role == 'registered' 
                        || $season_details->access == 'free' && $series->access == 'registered' && !Auth::guest() && Auth::user()->role == 'registered'  
                        || !Auth::guest() && Auth::user()->role == 'subscriber' &&  $season_details->access == 'free' ) {
                            $free_episode = 1;
                    }elseif (Auth::guest() && $series->access == 'subscriber' ||  $series->access == 'ppv' ||
                            $season_details->access != 'free' && $series->access == 'registered' || 
                             Auth::guest() && $series->access == 'registered' ) {
                        $free_episode = 0;
                    } elseif($series->access == 'registered' && $SeriesPpvPurchase > 0 || $series->access == 'guest' && $SeriesPpvPurchase > 0){
                    $free_episode = 1;
                    } elseif($series->access == 'registered' && $PpvPurchase > 0 || $series->access == 'guest' && $PpvPurchase > 0){
                    $free_episode = 1;
                    }elseif( $series->access == 'guest' && $season_details->access != 'ppv'  
                        || $season_details->access != 'ppv' && $series->access == 'registered' && Auth::user()->role == 'registered' 
                        || $season_details->access != 'ppv' && $series->access == 'registered' && Auth::user()->role == 'subscriber' 
                        || $season_details->access != 'ppv' && $series->access == 'subscriber' && Auth::user()->role == 'subscriber'
                        || $series->access == 'subscriber' && Auth::user()->role == 'subscriber' || $season_details->access == 'ppv'  && Auth::user()->role == 'subscriber'){
                        $free_episode = 1;
                    }else {

                        $free_episode = 0;
                    }

                // endif;

                }elseif (!Auth::guest() && $series->access != 'subscriber' || !Auth::guest() && Auth::user()->role == 'admin' ||  
                    !Auth::guest() && $season_details->access == 'free' && $series->access == 'subscriber' && Auth::user()->role != 'registered' || 
                    $season_details->access == 'free' && $series->access == 'guest' && !Auth::guest() && Auth::user()->role == 'subscriber'  || 
                    $season_details->access == 'free' && $series->access == 'registered' && !Auth::guest() && Auth::user()->role == 'subscriber'  || 
                    $series->access == 'subscriber' && !Auth::guest() && Auth::user()->role == 'subscriber'  || 
                    $series->access == 'guest' && $season_details->access == 'free' && !Auth::guest() && Auth::user()->role == 'registered' ||
                    $season_details->access == 'free' && $series->access == 'registered' && !Auth::guest() && Auth::user()->role == 'registered'  ||
                    !Auth::guest() && Auth::user()->role == 'subscriber' &&  $season_details->access == 'free' && Auth::user()->role != 'registered'  ) {
                        $free_episode = 1;
                }elseif (Auth::guest() && $series->access == 'subscriber' ||  $series->access == 'ppv' ||
                        $season_details->access != 'free' && $series->access == 'registered' || 
                         Auth::guest() && $series->access == 'registered' ) {
                    $free_episode = 0;
                } elseif($SeriesPpvPurchase > 0){
                $free_episode = 1;
                } elseif($PpvPurchase > 0){
                $free_episode = 1;
                }
                elseif (Auth::guest() && $series->access == 'guest' && $season_details->access == 'free') {
                $free_episode = 1;
                }
                else {
                    $free_episode = 0;
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
                $checkseasonppv_exits = 0;
            }
    
            if (($series->ppv_status == 0 && $ppv_price == 0) && @$seasons->access != 'ppv' || $ppv_price == null && @$seasons->access != 'ppv' ) {
                $series_ppv_status = 0;
                // $free_episode = 1;
            } else {
                $series_ppv_status = 1;
            }
            if (!Auth::guest() && Auth::user()->role == 'admin'){
                $free_episode = 1;
            }
            // if (!Auth::guest()) {
            //     if (Auth::user()->role == 'admin') {
            //         $free_episode = 1;
            //     } elseif (Auth::user()->role == 'registered') {
            //         $free_episode = 1;
            //     } elseif (Auth::user()->role == 'subscriber') {
            //         $free_episode = 1;
            //     }
            // }
    
            if (!Auth::guest()):
    
              $like_dislike = LikeDislike::where('user_id',  Auth::user()->id)
                    ->where('episode_id', $id)
                    ->first();
              
            else:
              
              $like_dislike = LikeDislike::where('users_ip_address', $geoip->getIP() )
                    ->where('episode_id', $id)
                    ->first();
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


                // video Js


            $episode_details = Episode::where('id',$source_id)->get()->map( function ($item)   {

                $item['Thumbnail']  =   !is_null($item->image)  ? URL::to('public/uploads/images/'.$item->image) : default_vertical_image_url() ;
                $item['Player_thumbnail'] = !is_null($item->player_image)  ? URL::to('public/uploads/images/'.$item->player_image ) : default_horizontal_image_url() ;
                $item['TV_Thumbnail'] = !is_null($item->tv_image)  ? URL::to('public/uploads/images/'.$item->tv_image)  : default_horizontal_image_url() ;
  

                $item['video_skip_intro_seconds']        = $item->skip_intro  ? Carbon::parse($item->skip_intro)->secondsSinceMidnight() : null ;
                $item['video_intro_start_time_seconds']  = $item->intro_start_time ? Carbon::parse($item->intro_start_time)->secondsSinceMidnight() : null ;
                $item['video_intro_end_time_seconds']    = $item->intro_end_time ? Carbon::parse($item->intro_end_time)->secondsSinceMidnight() : null ;

                $item['video_skip_recap_seconds']        = $item->skip_recap ? Carbon::parse($item->skip_recap)->secondsSinceMidnight() : null ;
                $item['video_recap_start_time_seconds']  = $item->recap_start_time ? Carbon::parse($item->recap_start_time)->secondsSinceMidnight() : null ;
                $item['video_recap_end_time_seconds']    = $item->recap_end_time ? Carbon::parse($item->recap_end_time)->secondsSinceMidnight() : null ;
                
                    //  Episode URL
            
                    switch (true) {

                        case $item['type'] == "file"  :
                            $item['Episode_url'] =  $item->mp4_url ;
                            $item['Episode_player_type'] =  'video/mp4' ;
                        break;
        
                        case $item['type'] == "upload"  :
                          $item['Episode_url'] =  $item->mp4_url ;
                          $item['Episode_player_type'] =   'video/mp4' ;
                        break;
        
                        case $item['type'] == "m3u8":
                            $item['Episode_url'] =  URL::to('/storage/app/public/'. $item->path .'.m3u8')   ;
                            $item['Episode_player_type'] =  'application/x-mpegURL' ;
                        break;
        
                        case $item['type'] == "aws_m3u8":
                          $item['Episode_url'] =  $item->path ;
                          $item['Episode_player_type'] =  'application/x-mpegURL' ;
                        break;

                        case $item['type'] == "embed":
                            $item['Episode_url'] =  $item->path ;
                            $item['Episode_player_type'] =  'application/x-mpegURL' ;
                        break;
        
                        default:
                            $item['Episode_url'] =  null ;
                            $item['Episode_player_type'] =  null ;
                        break;
                    }
  
                return $item;
  
            })->first();
            if(!Auth::guest()){
                $episode_PpvPurchase = PpvPurchase::where('user_id', '=', Auth::user()->id)
                                        ->where('series_id', '=', $episode->series_id)
                                        ->where('season_id', '=', $episode->season_id)
                                        ->where('episode_id', '=', $episode->id)
                                        ->count();

            }else{
                $episode_PpvPurchase = 0;
            }
            // dd($free_episode);

            if ((!Auth::guest() && Auth::user()->role == 'admin') || $series_ppv_status != 1 || $ppv_exits > 0 || $free_episode > 0) {
                $data = [
                    'currency' => $currency,
                    'video_access' => $video_access,
                    'free_episode' => $free_episode,
                    'ppv_exits' => $ppv_exits,
                    'checkseasonppv_exits' => 0,
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
                    'episode_details'           => $episode_details ,
                    'episode_PpvPurchase'  => $episode_PpvPurchase,
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
                    'episode_details'  => $episode_details ,
                    'episode_PpvPurchase'  => $episode_PpvPurchase,
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
    
        // } catch (\Throwable $th) {
    
        //     // return $th->getMessage();
        //     return abort(404);
        // }
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
        $theme = Theme::uses($Theme);

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

        }
        $series = Series::where('slug', '=', $name)->first();


        if((Auth::guest() && @$series->access == 'ppv') || (Auth::guest() && @$series->access == 'subscriber') || (Auth::guest() && @$series->access == 'registered') ){
            $video_access = 'pay';
        }else if ((!Auth::guest() && @$series->access == 'ppv') || (@$series->access == 'subscriber' && Auth::user()->role != 'admin')) {
            $video_access = 'pay';
        }  else {
            $video_access = 'free';
        }

        $id = $series->id;

        if (!Auth::guest() && $series->ppv_status == 1) {
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

            $series = Series::where('slug', $name)->first();

            // for theme5 , theme4, theme3

            $series_season_first = SeriesSeason::where('series_id',$id)->Pluck('id')->first();


            $season_depends_episode = Episode::where('active',1)->where('status',1)->where('series_id',$id)
                                            ->where('season_id',$series_season_first)->orderBy('episode_order')->get();

            $featured_season_depends_episode = Episode::where('active',1)->where('status',1)->where('featured',1)
                                             ->where('season_id',$series_season_first)->where('series_id',$id)->orderBy('episode_order')->get();
           
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
                'season_depends_episode' => $season_depends_episode ,
                'featured_season_depends_episode' => $featured_season_depends_episode ,
            ];

            // return Theme::view('series', $data);

            return $theme->load('public/themes/'.$Theme.'/views/series',  $data )->render();

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

    public function season_depends_episode_section(Request $request)
    {
        $Theme = HomeSetting::pluck('theme_choosen')->first();
        $theme = Theme::uses($Theme);

        $series = Series::where('id', $request->series_id)->first();

        $season_depends_episode = Episode::where('active',1)->where('status',1)->where('series_id',$request->series_id)
                                            ->where('season_id',$request->season_id)->orderBy('episode_order')->get();

        $featured_season_depends_episode = Episode::where('active',1)->where('status',1)->where('featured',1)
                                            ->where('series_id',$request->series_id)->where('season_id',$request->season_id)
                                            ->orderBy('episode_order')->get();

        $redirect_url = 'public/themes/' . $Theme . '/partials/season_depends_episode_section';

        $data = [
            'series_data' => $series,
            'season_depends_episode' => $season_depends_episode ,
            'featured_season_depends_episode' => $featured_season_depends_episode ,
        ];


        return $theme->load($redirect_url,  $data )->render();
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
        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();

        $episode = LikeDisLike::where('episode_id', '=', $request->episode_id)
            ->when(!Auth::guest(), function ($query) {
                return $query->where('user_id', Auth::user()->id);
            })
            ->unless(!Auth::guest(), function ($query) use ($geoip) {
                return $query->where('users_ip_address', $geoip->getIP());
            })->get();

        $episode_count = LikeDisLike::where('episode_id', '=', $request->episode_id)
            ->when(!Auth::guest(), function ($query) {
                return $query->where('user_id', Auth::user()->id);
            })
            ->unless(!Auth::guest(), function ($query) use ($geoip) {
                return $query->where('users_ip_address', $geoip->getIP());
            })->count();

        if ($episode_count > 0) {

            $episode_new = LikeDisLike::where('episode_id', '=', $request->episode_id)
                ->when(!Auth::guest(), function ($query) {
                    return $query->where('user_id', Auth::user()->id);
                })
                ->unless(!Auth::guest(), function ($query) use ($geoip) {
                    return $query->where('users_ip_address', $geoip->getIP());
                })->first();

            $episode_new->liked = 1;
            $episode_new->episode_id = $request->episode_id;
            $episode_new->save();

            $data = ['message' => 'Added to Like Episode', ];

        } else {

            $episode_new = new LikeDisLike();
            $episode_new->user_id = !Auth::guest() ? Auth::user()->id : null ;
            $episode_new->users_ip_address = Auth::guest() ?  $geoip->getIP() : null ;
            $episode_new->liked = 1;
            $episode_new->episode_id = $request->episode_id;
            $episode_new->save();

            $data = [
                'message' => 'Added to Like Episode',
            ];

        }
        return $data;
    }

    public function RemoveLikeEpisode(Request $request)
    {
        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();

        $episode = LikeDisLike::where('episode_id', '=', $request->episode_id)
            ->when(!Auth::guest(), function ($query) {
                return $query->where('user_id', Auth::user()->id);
            })
            ->unless(!Auth::guest(), function ($query) use ($geoip) {
                return $query->where('users_ip_address', $geoip->getIP());
            })->get();

        $episode_count = LikeDisLike::where('episode_id', '=', $request->episode_id)
            ->when(!Auth::guest(), function ($query) {
                return $query->where('user_id', Auth::user()->id);
            })
            ->unless(!Auth::guest(), function ($query) use ($geoip) {
                return $query->where('users_ip_address', $geoip->getIP());
            })->count();

        if ($episode_count > 0) {

            $episode_new = LikeDisLike::where('episode_id', '=', $request->episode_id)
                ->when(!Auth::guest(), function ($query) {
                    return $query->where('user_id', Auth::user()->id);
                })
                ->unless(!Auth::guest(), function ($query) use ($geoip) {
                    return $query->where('users_ip_address', $geoip->getIP());
                })->first();

            $episode_new->liked = 0;
            $episode_new->episode_id = $request->episode_id;
            $episode_new->save();

            $data = [ 'message' => 'Removed from Liked Episode', ];

        } else {
            
            $data = [ 'message' => 'NO Data', ];
        }

        return $data;
    }

    public function DisLikeEpisode(Request $request)
    {
        
        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
       
        $episode = LikeDisLike::where('episode_id', $request->episode_id)
                ->when(!Auth::guest(), function ($query) {
                    return $query->where('user_id', Auth::user()->id);
                })
                ->unless(!Auth::guest(), function ($query) use ($geoip) {
                    return $query->where('users_ip_address', $geoip->getIP());
            })->get();


        $episode_count = LikeDisLike::where('episode_id', $request->episode_id)
                ->when(!Auth::guest(), function ($query) {
                    return $query->where('user_id', Auth::user()->id);
                })
                ->unless(!Auth::guest(), function ($query) use ($geoip) {
                    return $query->where('users_ip_address', $geoip->getIP());
            })->count();

        if ($episode_count > 0) {
            
            $episode_new = LikeDisLike::where('episode_id', $request->episode_id)
                ->when(!Auth::guest(), function ($query) {
                    return $query->where('user_id', Auth::user()->id);
                })
                ->unless(!Auth::guest(), function ($query) use ($geoip) {
                    return $query->where('users_ip_address', $geoip->getIP());
            })->first();

            $episode_new->disliked = 1;
            $episode_new->episode_id = $request->episode_id;
            $episode_new->save();

            $data = [ 'message' => 'Added to DisLike Episode', ];

        } else {

            $episode_new = new LikeDisLike();
            $episode_new->user_id = !Auth::guest() ? Auth::user()->id : null ;
            $episode_new->users_ip_address = Auth::guest() ?  $geoip->getIP() : null ;
            $episode_new->disliked = 1;
            $episode_new->episode_id = $request->episode_id;
            $episode_new->save();

            $data = [ 'message' => 'Added to DisLike Episode', ];
        }

        return $data;
    }

    public function RemoveDisLikeEpisode(Request $request)
    {
        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();

        $episode = LikeDisLike::where('episode_id', $request->episode_id)
                ->when(!Auth::guest(), function ($query) {
                    return $query->where('user_id', Auth::user()->id);
                })
                ->unless(!Auth::guest(), function ($query) use ($geoip) {
                    return $query->where('users_ip_address', $geoip->getIP());
            })->get();


        $episode_count = LikeDisLike::where('episode_id', $request->episode_id)
                ->when(!Auth::guest(), function ($query) {
                    return $query->where('user_id', Auth::user()->id);
                })
                ->unless(!Auth::guest(), function ($query) use ($geoip) {
                    return $query->where('users_ip_address', $geoip->getIP());
            })->count();

        if ($episode_count > 0) {

            $episode_new = LikeDisLike::where('episode_id', $request->episode_id)
                ->when(!Auth::guest(), function ($query) {
                    return $query->where('user_id', Auth::user()->id);
                })
                ->unless(!Auth::guest(), function ($query) use ($geoip) {
                    return $query->where('users_ip_address', $geoip->getIP());
                })->first();


            $episode_new->disliked = 0;
            $episode_new->episode_id = $request->episode_id;
            $episode_new->save();

            $data = [  'message' => 'Removed from Liked Episode',];
        } 
        else {
            $data = [ 'message' => 'NO Data',];
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
            
            $Series_Genre = $SeriesGenre->map(function($item){

                $item['Series_depends_episodes'] = Series::find($item->id)->Series_depends_episodes
                                            ->map(function ($item) {
                                            $item['image_url']  = !is_null($item->image) ? URL::to('public/uploads/images/'.$item->image) : default_vertical_image() ;
                                            return $item;
                                        });
                return $item;
            });

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

            $Theme = HomeSetting::pluck('theme_choosen')->first();
            Theme::uses($Theme);

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

    public function Specific_Series_Networks(Request $request,$slug)
    {
        try {
         
            $Theme = HomeSetting::pluck('theme_choosen')->first();
            Theme::uses($Theme);

            $series_data = SeriesNetwork::where('slug',$slug)->orderBy('order')->get()->map(function ($item) {

                $item['Series_depends_Networks'] = Series::where('series.active', 1)
                            ->whereJsonContains('network_id', [(string)$item->id])

                            ->latest('series.created_at')->get()->map(function ($item) { 
                    
                    $item['image_url']        = !is_null($item->image)  ? URL::to('public/uploads/images/'.$item->image) : default_vertical_image() ;
                    $item['Player_image_url'] = !is_null($item->player_image)  ? URL::to('public/uploads/images/'.$item->player_image ) : default_horizontal_image_url() ;

                    $item['Series_depends_episodes'] = Series::find($item->id)->Series_depends_episodes
                                                            ->map(function ($item) {
                                                            $item['image_url']  = !is_null($item->image) ? URL::to('public/uploads/images/'.$item->image) : default_vertical_image() ;
                                                            return $item;
                                                        });

                    $item['source'] = 'Series';
                    return $item;
                                                                        
                });

                return $item;
            })->first();
            
            $data = array( 'series_data' => $series_data );

            return Theme::view('partials.home.SeriesNetworks',$data);

        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    public function Series_Networks_List()
    {
        
        $Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses($Theme);

        $series_data = SeriesNetwork::orderBy('order')->get()->map(function ($item) {
            $item['image_url'] = $item->image != null ? URL::to('public/uploads/seriesNetwork/'.$item->image ) : default_vertical_image_url() ;
            $item['banner_image_url'] = $item->banner_image != null ?  URL::to('public/uploads/seriesNetwork/'.$item->banner_image ) : default_horizontal_image_url();
            return $item;
        });

        $data = array( 'series_data' => $series_data );

        return Theme::view('partials.home.Series-Networks-List',$data);

    }
}
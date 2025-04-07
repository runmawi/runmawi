<?php

namespace App\Http\Controllers;
use URL;
use Auth;
//use Request;
use Hash;
use Mail;
use View;
use Nexmo;
use Theme;
use Session;
use App\Genre;
use App\Series;
use App\Channel;
use App\Episode;
use Carbon\Carbon;
use GeoIPLocation;
use App\ButtonText;
use App\HomeSetting;
use App\SeriesGenre;
use App\Menu as Menu;
use App\Page as Page;
use App\SeriesSeason;
use App\User as User;
use App\CompressImage;
use App\SeriesNetwork;
use http\Env\Response;
use App\ModeratorsUser;
use App\OrderHomeSetting;
use App\Slider as Slider;
use App\ThumbnailSetting;
//use Image;
use \Redirect as Redirect;
use App\Setting as Setting;
use Illuminate\Support\Str;
use App\PartnerMonetization;
use Illuminate\Http\Request;
use App\Playerui as Playerui;
use App\PpvVideo as PpvVideo;
use App\Wishlist as Wishlist;
use App\SiteTheme as SiteTheme;
use App\PaypalPlan as PaypalPlan;
use App\RecentView as RecentView;
use App\Watchlater as Watchlater;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\LikeDislike as Likedislike;
use App\PartnerMonetizationSetting;
use App\PpvCategory as PpvCategory;
use App\PpvPurchase as PpvPurchase;
use App\Subscription as Subscription;
use App\VerifyNumber as VerifyNumber;
use Illuminate\Support\Facades\Cache;
use App\PaymentSetting as PaymentSetting;
use App\SeriesSubtitle as SeriesSubtitle;
use Stevebauman\Location\Facades\Location;
use App\CurrencySetting as CurrencySetting;
use App\ContinueWatching as ContinueWatching;
use App\UserChannelSubscription;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Notifications\Messages\NexmoMessage;
use Intervention\Image\ImageManagerStatic as Image;
use App\CountryCode;
use App\StorageSetting;


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

        $this->Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses($this->Theme);

        $this->BunnyCDNEnable = StorageSetting::pluck('bunny_cdn_storage')->first();

        $this->BaseURL = $this->BunnyCDNEnable == 1 ? StorageSetting::pluck('bunny_cdn_base_url')->first() : URL::to('/public/uploads') ;

    }

    public function paginateCollection(Collection $collection, $perPage)
    {
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->values();

        return new LengthAwarePaginator(
            $currentPageItems,
            $collection->count(),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        try {

            $pages = Page::all();

            $OrderHomeSetting = OrderHomeSetting::whereIn('id',[20,21,30,32])->orderBy('id', 'asc')->get();
            $Slider_array_data = array(
                'Episode_sliders'    => (new FrontEndQueryController)->Episode_sliders(), 
                'series_sliders'     => (new FrontEndQueryController)->series_sliders(), 
            );   
            if($this->Theme == "default" || $this->Theme == "theme6"){
                $latest_series = Series::select('id','title','slug','year','rating','access','duration','rating','image','featured','tv_image','player_image','details','description','uploaded_by','user_id')
                                    ->where('active', '1')->latest()->get();

                $featured_episodes = Episode::select('id','title','slug','rating','access','series_id','season_id','ppv_price','responsive_image','responsive_player_image','responsive_tv_image','episode_description',
                                                    'duration','rating','image','featured','tv_image','player_image','uploaded_by','user_id')
                                                ->where('active', 1)->where('featured' ,1)->where('status', '1')
                                                ->latest()
                                                ->get()->map(function($item){
                                                    $item['series'] = Series::where('id',$item->series_id)->first();
                                                    return $item ;
                                                });

                $Series_based_on_Networks = SeriesNetwork::where('in_home', 1)->orderBy('order')->get()->map(function ($item) {

                    $item['Series_depends_Networks'] = Series::where('series.active', 1)
                                ->whereJsonContains('network_id', [(string)$item->id])

                                ->latest('series.created_at')->get()->map(function ($item) { 
                        
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

                    $SeriesGenre =  SeriesGenre::orderBy('order','ASC')->get();

                    $data = [
                        'current_page'   => 1,
                        'pagination_url' => '/series',
                        'settings'       => Setting::first(),
                        'currency'      => CurrencySetting::first(),
                        'pages'         => $pages,
                        'current_theme' => $this->Theme,
                        'featured_episodes' =>  $featured_episodes,
                        'latest_series'     =>  $latest_series,
                        'SeriesGenre'       =>  (new FrontEndQueryController)->SeriesGenre() ,
                        'multiple_compress_image' => (new FrontEndQueryController)->multiple_compress_image() ,
                        'Series_based_on_category' => $Series_based_on_category ,
                        'Series_based_on_Networks' => $Series_based_on_Networks ,
                        'ThumbnailSetting'  => ThumbnailSetting::first(),
                        'default_vertical_image_url' => default_vertical_image_url(),
                        'default_horizontal_image_url' => default_horizontal_image_url(),
                        'order_settings_list' => $OrderHomeSetting, 
                        'home_settings'  => HomeSetting::first() ,
                        'Slider_array_data' => $Slider_array_data ,
                        'BaseURL'                            => $this->BaseURL
                    ];
                    return Theme::view('tv-home', $data);

            }elseif($this->Theme == "theme4"){
                $data = [
                    'current_page'   => 1,
                    'pagination_url' => '/series',
                    'settings'       => Setting::first(),
                    'currency'      => CurrencySetting::first(),
                    'pages'         => $pages,
                    'current_theme' => $this->Theme,
                    'latest_episodes'   =>  (new FrontEndQueryController)->latest_episodes()->take(15) ,
                    'featured_episodes' =>  (new FrontEndQueryController)->featured_episodes()->take(15),
                    'latest_series'     =>  (new FrontEndQueryController)->latest_Series()->take(15),
                    'multiple_compress_image' => (new FrontEndQueryController)->multiple_compress_image(),
                    'Series_based_on_Networks' => (new FrontEndQueryController)->Series_based_on_Networks(),
                    'ThumbnailSetting'  => ThumbnailSetting::first(),
                    'default_vertical_image_url' => default_vertical_image_url(),
                    'default_horizontal_image_url' => default_horizontal_image_url(),
                    'order_settings_list' => $OrderHomeSetting, 
                    'home_settings'  => HomeSetting::first() ,
                    'BaseURL'                            => $this->BaseURL
                ];
    
                return Theme::view('tv-home', $data);
            }
            else{
                $data = [
                    'current_page'   => 1,
                    'pagination_url' => '/series',
                    'settings'       => Setting::first(),
                    'currency'      => CurrencySetting::first(),
                    'pages'         => $pages,
                    'current_theme' => $this->Theme,
                    'free_series'   => (new FrontEndQueryController)->free_series()->take(15) ,
                    'free_episodes' => (new FrontEndQueryController)->free_episodes()->take(15) ,
                    'free_Contents' => (new FrontEndQueryController)->free_episodes()->take(15) ,
                    'episodes'      => (new FrontEndQueryController)->latest_episodes()->take(15) ,
                    'trendings'     => (new FrontEndQueryController)->trending_episodes()->take(15) ,
                    'latest_episodes'   =>  (new FrontEndQueryController)->latest_episodes()->take(15) ,
                    'featured_episodes' =>  (new FrontEndQueryController)->featured_episodes()->take(15),
                    'latest_series'     =>  (new FrontEndQueryController)->latest_Series()->take(15),
                    'series_sliders'    =>  (new FrontEndQueryController)->series_sliders()->take(15),
                    'banner'            =>  (new FrontEndQueryController)->Episode_sliders()->take(15) ,
                    'SeriesGenre'       =>  (new FrontEndQueryController)->SeriesGenre()->take(15) ,
                    'multiple_compress_image' => (new FrontEndQueryController)->multiple_compress_image(),
                    'Series_based_on_category' => (new FrontEndQueryController)->Series_based_on_category(),
                    'Series_based_on_Networks' => (new FrontEndQueryController)->Series_based_on_Networks(),
                    'ThumbnailSetting'  => ThumbnailSetting::first(),
                    'default_vertical_image_url' => default_vertical_image_url(),
                    'default_horizontal_image_url' => default_horizontal_image_url(),
                    'order_settings_list' => $OrderHomeSetting, 
                    'home_settings'  => HomeSetting::first() ,
                    'Slider_array_data' => $Slider_array_data ,
                    'BaseURL'                            => $this->BaseURL
                ];
    
                return Theme::view('tv-home', $data);
            }

        } catch (\Throwable $th) {
            // return $th->getMessage();
            return abort(404);
            return Theme::view('tv-home-empty-data');
        }
    }

    public function play_episode($series_name, $episode_name,$plan = null)
    {
        try {

        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
        $ppv_series_description = Setting::pluck('series')->first();
        
        $Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses($Theme);

        $settings = Setting::first();

        $buttons_pay = SiteTheme::select('purchase_btn', 'subscribe_btn')->first();
        $purchase_btn = $buttons_pay->purchase_btn;
        $subscribe_btn = $buttons_pay->subscribe_btn;

        $series_id = Series::where('slug',$series_name)->pluck('id')->first();

        $episodess = Episode::where('slug', $episode_name)->where('series_id',$series_id)->orderBy('id', 'DESC')->first();
        $season_access = SeriesSeason::where('id', $episodess->season_id)->pluck('access')->first();
        $series_access = Series::where('id', $episodess->series_id)->pluck('access')->first();
    
        $series_seasons_type = SeriesSeason::where('id', $episodess->season_id)->pluck('series_seasons_type')->first();

        $source_id = Episode::where('slug', $episode_name)->where('series_id',$series_id)->pluck('id')->first();

        
       // Check Channel Purchase 
       
       $UserChannelSubscription = true ;

       if ( $settings->user_channel_plans_page_status == 1 && $this->Theme == "theme6") {

            $UserChannelSubscription = false ;

            $channel_id = Episode::where('id',$source_id)->where('uploaded_by','channel')->pluck('user_id')->first();

            if (is_null($channel_id)) {
                $UserChannelSubscription = true ;
            }

            if (!Auth::guest() && !is_null($channel_id) ) {

                $UserChannelSubscription = UserChannelSubscription::where('user_id',auth()->user()->id)
                                                ->where('channel_id',$channel_id)->where('status','active')
                                                ->where('subscription_start', '<=', Carbon::now())
                                                ->where('subscription_ends_at', '>=', Carbon::now())
                                                ->latest()->exists();

                if (Auth::user()->role == "admin") {
                    $UserChannelSubscription = true ;
                }
            }
        }

            // Enable videoCipher Upload

        if(Enable_videoCipher_Upload() == 1 && Enable_PPV_Plans() == 1 && $series_seasons_type == 'VideoCipher'){
            return $this->VideoCipher_Episode($series_name, $episode_name,$plan);
        }

        $auth_user = Auth::user();
    
        $auth_user_id = $auth_user == null ? null : Auth::user()->id ;
    
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
    
        $episode = Episode::where('slug', $episode_name)->where('series_id',$series_id)
            ->orderBy('id', 'DESC')
            ->first();
    
        $id = $episode->id;
    
        $season = SeriesSeason::where('series_id', '=', $episode->series_id)
            ->with('episodes')
            ->get();
    
        $series = Series::find($episode->series_id);
        // dd($series);
    
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
            // $ppv_exits = PpvPurchase::where('user_id', '=', Auth::user()->id)
            //     ->where('episode_id', '=', $id)
            //     ->count();

            $current_date = Carbon::now()->format('Y-m-d H:i:s a');
            $ppv_exits = PpvPurchase::where('episode_id',$id)
                                    ->where('user_id', Auth::user()->id)
                                    ->where('to_time','>',$current_date)
                                    ->orderBy('created_at', 'desc')
                                    ->get()->map(function ($item){
                                        $payment_status = payment_status($item);
                                        if ($payment_status === null || $item->status === $payment_status) {
                                            return $item;
                                        }
                                            return null;
                                    })->first();

            $ppv_exits = $ppv_exits ? 1 : 0; 
  


        } else {
            $ppv_exits = 0;
        }
    
        if ($series->ppv_status == 1 && $settings->access_free == 0) {
            // $ppv_exits = PpvPurchase::where('user_id', '=', Auth::user()->id)
            //     ->where('series_id', '=', $series->id)
            //     ->count();

            $current_date = Carbon::now()->format('Y-m-d H:i:s a');
            $ppv_exits = PpvPurchase::where('series_id',$series->id)
                                    ->where('user_id', Auth::user()->id)
                                    ->where('to_time','>',$current_date)
                                    ->orderBy('created_at', 'desc')
                                    ->get()->map(function ($item){
                                        $payment_status = payment_status($item);
                                        if ($payment_status === null || $item->status === $payment_status) {
                                            return $item;
                                        }
                                            return null;
                                    })->first();

            $ppv_exits = $ppv_exits ? 1 : 0; 


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

            $current_date = Carbon::now()->format('Y-m-d H:i:s a');

            // $PpvPurchase = PpvPurchase::where('user_id',Auth::user()->id)
            //                 ->where('series_id', '=', $episode->series_id)
            //                 ->where('season_id', '=', $episode->season_id)
            //                 ->count();


            $PpvPurchase = PpvPurchase::where('series_id',$episode->series_id)
                                        ->where('season_id', $episode->season_id)
                                        ->where('user_id', Auth::user()->id)
                                        ->where('to_time','>',$current_date)
                                        ->orderBy('created_at', 'desc')
                                        ->get()->map(function ($item){
                                            $payment_status = payment_status($item);
                                            if ($payment_status === null || $item->status === $payment_status) {
                                                return $item;
                                            }
                                                return null;
                                        })->first();

            $PpvPurchase = $PpvPurchase ? 1 : 0; 

            // $SeriesPpvPurchase = PpvPurchase::where('user_id',Auth::user()->id)
            //                     ->where('series_id', '=', $episode->series_id)
            //                     ->count();

            $SeriesPpvPurchase = PpvPurchase::where('series_id',$episode->series_id)
                                            ->where('user_id', Auth::user()->id)
                                            ->where('to_time','>',$current_date)
                                            ->orderBy('created_at', 'desc')
                                            ->get()->map(function ($item){
                                                $payment_status = payment_status($item);
                                                if ($payment_status === null || $item->status === $payment_status) {
                                                    return $item;
                                                }
                                                    return null;
                                            })->first();
    
            $SeriesPpvPurchase = $SeriesPpvPurchase ? 1 : 0; 
    


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

                $current_date = Carbon::now()->format('Y-m-d H:i:s a');

                // $PpvPurchase = PpvPurchase::where('user_id',Auth::user()->id)
                //                 ->where('series_id', '=', $episode->series_id)
                //                 ->where('season_id', '=', $episode->season_id)
                //                 ->count();

                $PpvPurchase = PpvPurchase::where('series_id',$episode->series_id)
                                            ->where('season_id', '=', $episode->season_id)
                                            ->where('user_id', Auth::user()->id)
                                            ->where('to_time','>',$current_date)
                                            ->orderBy('created_at', 'desc')
                                            ->get()->map(function ($item){
                                                $payment_status = payment_status($item);
                                                if ($payment_status === null || $item->status === $payment_status) {
                                                    return $item;
                                                }
                                                    return null;
                                            })->first();
    
                $PpvPurchase = $PpvPurchase ? 1 : 0; 



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

                    $current_date = Carbon::now()->format('Y-m-d H:i:s a');

                    // $PpvPurchase = PpvPurchase::where('user_id',Auth::user()->id)
                    //                             ->where('series_id', '=', $episode->series_id)
                    //                             ->where('season_id', '=', $episode->season_id)
                    //                             ->count();

                    $PpvPurchase = PpvPurchase::where('series_id',$episode->series_id)
                                                ->where('season_id', '=', $episode->season_id)
                                                ->where('user_id', Auth::user()->id)
                                                ->where('to_time','>',$current_date)
                                                ->orderBy('created_at', 'desc')
                                                ->get()->map(function ($item){
                                                    $payment_status = payment_status($item);
                                                    if ($payment_status === null || $item->status === $payment_status) {
                                                        return $item;
                                                    }
                                                        return null;
                                                })->first();
        
                    $PpvPurchase = $PpvPurchase ? 1 : 0; 


                    // $SeriesPpvPurchase = PpvPurchase::where('user_id',Auth::user()->id)
                    //                 ->where('series_id', '=', $episode->series_id)
                    //                 ->count();

                    $SeriesPpvPurchase = PpvPurchase::where('series_id',$episode->series_id)
                                                    ->where('user_id', Auth::user()->id)
                                                    ->where('to_time','>',$current_date)
                                                    ->orderBy('created_at', 'desc')
                                                    ->get()->map(function ($item){
                                                        $payment_status = payment_status($item);
                                                        if ($payment_status === null || $item->status === $payment_status) {
                                                            return $item;
                                                        }
                                                            return null;
                                                    })->first();

                    $SeriesPpvPurchase = $SeriesPpvPurchase ? 1 : 0; 


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
                            Auth::user()->role == 'subscriber' &&  $season_details->access == 'free'
                            || settings_enable_rent() == 1 && Auth::user()->role == 'subscriber'  && $season_details->access == 'ppv'  ) {
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
                           || settings_enable_rent() == 1 && Auth::user()->role == 'subscriber'  && $season_details->access == 'ppv' 
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
                }elseif (!Auth::guest() && $series->access == 'ppv' && $SeriesPpvPurchase == 0
                || !Auth::guest() && Auth::user()->role == 'subscriber' && $settings->enable_ppv_rent == 0 && $series->access == 'ppv'  && $SeriesPpvPurchase == 0
                 ) 
                {
                    $free_episode = 0;
                }elseif (!Auth::guest() && $series->access == 'ppv' && $SeriesPpvPurchase == 0
                    || !Auth::guest() && Auth::user()->role == 'subscriber' && $settings->enable_ppv_rent == 0 && $series->access == 'ppv'  && $SeriesPpvPurchase == 0
                 ) 
                {
                    $free_episode = 0;
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
                // dd($season_id);
                    // Season Ppv Purchase exit check
            if (($ppv_price != 0 && !Auth::guest()) || ($ppv_price != null && !Auth::guest())) {
                    // $ppv_exits = PpvPurchase::where('user_id', '=', Auth::user()->id)
                    // // ->where('season_id', '=', $season_id)
                    // ->where('series_id', '=', $episode->series_id)
                    // ->count();

                    $current_date = Carbon::now()->format('Y-m-d H:i:s a');
                    $ppv_exits = PpvPurchase::where('season_id',$season_id)
                                            ->where('series_id', '=', $episode->series_id)
                                            ->where('user_id', Auth::user()->id)
                                            ->where('to_time','>',$current_date)
                                            ->orderBy('created_at', 'desc')
                                            ->get()->map(function ($item){
                                                $payment_status = payment_status($item);
                                                if ($payment_status === null || $item->status === $payment_status) {
                                                    return $item;
                                                }
                                                    return null;
                                            })->first();

                    $ppv_exits = $ppv_exits ? 1 : 0; 

                    
                    // $PpvPurchase = PpvPurchase::where('series_id', '=', $episode->series_id)
                    // ->where('season_id', '=', $episode->season_id)
                    // ->count();

                    $current_date = Carbon::now()->format('Y-m-d H:i:s a');
                    $PpvPurchase = PpvPurchase::where('series_id',$episode->series_id)
                                                ->where('season_id', '=', $episode->season_id)
                                                ->where('to_time','>',$current_date)
                                                ->orderBy('created_at', 'desc')
                                                ->get()->map(function ($item){
                                                    $payment_status = payment_status($item);
                                                    if ($payment_status === null || $item->status === $payment_status) {
                                                        return $item;
                                                    }
                                                        return null;
                                                })->first();
    
                    $PpvPurchase = $PpvPurchase ? 1 : 0; 


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
    
                // $PpvPurchase = PpvPurchase::where('series_id', '=', $episode->series_id)
                // ->where('season_id', '=', $episode->season_id)
                // ->count();

                $current_date = Carbon::now()->format('Y-m-d H:i:s a');
                $PpvPurchase = PpvPurchase::where('series_id',$episode->series_id)
                                            ->where('season_id', '=', $episode->season_id)
                                            ->where('to_time','>',$current_date)
                                            ->orderBy('created_at', 'desc')
                                                ->get()->map(function ($item){
                                                    $payment_status = payment_status($item);
                                                    if ($payment_status === null || $item->status === $payment_status) {
                                                        return $item;
                                                    }
                                                        return null;
                                                })->first();
    
                $PpvPurchase = $PpvPurchase ? 1 : 0; 

                
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
                $item['Player_thumbnail'] = !is_null($item->player_image)  ? $this->BaseURL . '/images/' . $item->player_image  : default_horizontal_image_url() ;
                $item['TV_Thumbnail'] = !is_null($item->tv_image)  ? URL::to('public/uploads/images/'.$item->tv_image)  : default_horizontal_image_url() ;

                $item['video_skip_intro_seconds']        = $item->skip_intro  ? Carbon::parse($item->skip_intro)->secondsSinceMidnight() : null ;
                $item['video_intro_start_time_seconds']  = $item->intro_start_time ? Carbon::parse($item->intro_start_time)->secondsSinceMidnight() : null ;
                $item['video_intro_end_time_seconds']    = $item->intro_end_time ? Carbon::parse($item->intro_end_time)->secondsSinceMidnight() : null ;

                $item['video_skip_recap_seconds']        = $item->skip_recap ? Carbon::parse($item->skip_recap)->secondsSinceMidnight() : null ;
                $item['video_recap_start_time_seconds']  = $item->recap_start_time ? Carbon::parse($item->recap_start_time)->secondsSinceMidnight() : null ;
                $item['video_recap_end_time_seconds']    = $item->recap_end_time ? Carbon::parse($item->recap_end_time)->secondsSinceMidnight() : null ;
                
                    //  Episode URL

                    if($this->Theme == 'theme4'){
                        switch (true) {

                            case $item['type'] == "file"  :
                                $item['Episode_url'] =  URL::to('/storage/app/public-latest/'. $item->path .'.mp4') ;
                                $item['Episode_player_type'] =  'video/mp4' ;
                            break;
            
                            case $item['type'] == "upload"  :
                              $item['Episode_url'] =  URL::to('/storage/app/public-latest/'. $item->path .'.mp4') ;
                              $item['Episode_player_type'] =   'video/mp4' ;
                            break;
            
                            case $item['type'] == "m3u8":
                                $item['Episode_url'] =  URL::to('/storage/app/public-latest/'. $item->path .'.m3u8')   ;
                                $item['Episode_player_type'] =  'application/x-mpegURL' ;
                            break;
            
                            case $item['type'] == "bunny_cdn":
                                $item['Episode_url'] =  $item->url    ;
                                $item['Episode_player_type'] =  'application/x-mpegURL' ;
                            break;
    
                            case $item['type'] == "m3u8_url":
                                $item['Episode_url'] =  $item->url    ;
                                $item['Episode_player_type'] =  'application/x-mpegURL' ;
                            break;
                            
                            case $item['type'] == "embed_video_url":
                                $item['Episode_url'] =  $item->embed_video_url ;
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
                    } else{
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
            
                            case $item['type'] == "bunny_cdn":
                                $item['Episode_url'] =  $item->url    ;
                                $item['Episode_player_type'] =  'application/x-mpegURL' ;
                            break;
    
                            case $item['type'] == "m3u8_url":
                                $item['Episode_url'] =  $item->url    ;
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

                            case $item['type'] == "embed_video_url":
                                $item['Episode_url'] =  $item->embed_video_url ;
                                $item['Episode_player_type'] =  'application/x-mpegURL' ;
                              break;
            
                            default:
                                $item['Episode_url'] =  null ;
                                $item['Episode_player_type'] =  null ;
                            break;
                        }
                    }
  
                return $item;
  
            })->first();

            if(!Auth::guest()){
                // $episode_PpvPurchase = PpvPurchase::where('user_id', '=', Auth::user()->id)
                //                         ->where('series_id', '=', $episode->series_id)
                //                         ->where('season_id', '=', $episode->season_id)
                //                         ->where('episode_id', '=', $episode->id)
                //                         ->count();


                $current_date = Carbon::now()->format('Y-m-d H:i:s a');
                $episode_PpvPurchase = PpvPurchase::where('user_id', '=', Auth::user()->id)
                                            ->where('series_id',$episode->series_id)
                                            ->where('season_id', '=', $episode->season_id)
                                            ->where('episode_id', '=', $episode->id)
                                            ->where('to_time','>',$current_date)
                                            ->orderBy('created_at', 'desc')
                                            ->get()->map(function ($item){
                                                $payment_status = payment_status($item);
                                                if ($payment_status === null || $item->status === $payment_status) {
                                                    return $item;
                                                }
                                                    return null;
                                            })->first();

                $episode_PpvPurchase = $episode_PpvPurchase ? 1 : 0; 


            }else{
                $episode_PpvPurchase = 0;
            }

            // default episode play
            $season_ide = Episode::where('slug', $episode_name)->pluck('season_id')->first();
            $season_access_ppv = SeriesSeason::where('id', $season_ide)->pluck('access')->first();
            $setting_subscirbe_series_access = Setting::pluck('enable_ppv_rent_series')->first();

            if(!Auth::guest()){
                $ppv_purchase_user = PpvPurchase::where('season_id','=',$season_ide)
                                                ->where('user_id',Auth::user()->id)
                                                ->select('user_id','season_id')
                                                ->get()->map(function ($item){
                                                    $payment_status = payment_status($item);
                                                    if ($payment_status === null || $item->status === $payment_status) {
                                                        return $item;
                                                    }
                                                        return null;
                                                })->first();

                // dd($ppv_purchase_user);
                // $ppv_purchase = PpvPurchase::where('season_id','=',$season_ide)->orderBy('created_at', 'desc')
                // ->where('user_id', Auth::user()->id)
                // ->first();
        
                // if(!empty($ppv_purchase) && !empty($ppv_purchase->to_time)){
                //     $new_date = Carbon::parse($ppv_purchase->to_time)->format('M d , y H:i:s');
                //     $currentdate = date("M d , y H:i:s");
                //     $ppv_exists_check_query = $new_date > $currentdate ?  1 : 0;
                // }
                // else{
                //     $ppv_exists_check_query = 0;
                // }    

                $current_date = Carbon::now()->format('Y-m-d H:i:s a');
                $ppv_purchase = PpvPurchase::where('season_id',$season_ide)
                                            ->where('user_id', Auth::user()->id)
                                            ->where('to_time','>',$current_date)
                                            ->orderBy('created_at', 'desc')
                                            ->get()->map(function ($item){
                                                $payment_status = payment_status($item);
                                                if ($payment_status === null || $item->status === $payment_status) {
                                                    return $item;
                                                }
                                                    return null;
                                            })->first();

                $ppv_exists_check_query = !empty($ppv_purchase) ? 1 : 0;


                    // dd($ppv_purchase);
                if($season_access_ppv == "free" && $series->access == 'guest' || Auth::user()->role == "admin" || $season_access_ppv == "free" && $series->access == 'registered' && Auth::user()->role == 'registered' || $season_access_ppv == "free" && $series->access == 'registered' && Auth::user()->role == 'subscriber'){
                    $episode_play_access = 1;
                }else{
                    if(Auth::guest()){
                        $episode_play_access = 0;
                    }elseif(Auth::user()->role == "registered"){
                        if($ppv_purchase_user && $ppv_purchase_user->season_id == $season_ide || $ppv_exists_check_query > 0){
                            $episode_play_access = 1;
                        }else{
                            $episode_play_access = 0;
                        }
                    }elseif(Auth::user()->role == "subscriber" && $setting_subscirbe_series_access == 1){
                        $episode_play_access = 1;
                    }
                    elseif(Auth::user()->role == "subscriber" && $setting_subscirbe_series_access == 0){
                        if($ppv_purchase_user && $ppv_purchase_user->season_id == $season_ide || $ppv_exists_check_query > 0 ){
                            $episode_play_access = 1;
                        }else{
                            $episode_play_access = 0;
                        }
                    }
                }
            }else{
                if($season_access_ppv == "free" && $series->access == 'guest'){
                    $episode_play_access = 1;
                }else{
                    if(Auth::guest()){
                        $episode_play_access = 0;
                    }elseif(Auth::user()->role == "registered"){
                        if($ppv_purchase_user && $ppv_purchase_user->season_id == $season_ide || $ppv_exists_check_query > 0){
                            $episode_play_access = 1;
                        }else{
                            $episode_play_access = 0;
                        }
                    }elseif(Auth::user()->role == "subscriber" && $setting_subscirbe_series_access == 1){
                        $episode_play_access = 1;
                    }
                    elseif(Auth::user()->role == "subscriber" && $setting_subscirbe_series_access == 0){
                        if($ppv_purchase_user && $ppv_purchase_user->season_id == $season_ide || $ppv_exists_check_query > 0 ){
                            $episode_play_access = 1;
                        }else{
                            $episode_play_access = 0;
                        }
                    }
                }
            }

            $payment_setting = PaymentSetting::where('status',1)->where('live_mode',1)->get();

            $Razorpay_payment_setting = PaymentSetting::where('payment_type','Razorpay')->where('status',1)->first();

            $Paystack_payment_setting = PaymentSetting::where('payment_type','Paystack')->where('status',1)->first();

            $stripe_payment_setting = PaymentSetting::where('payment_type','Stripe')->where('stripe_status',1)->first();

            $paydunya_payment_setting = PaymentSetting::where('payment_type','Paydunya')->where('status',1)->first();
            
            // Payment Gateway Paypal

            $PayPalpayment = PaymentSetting::where('payment_type', 'PayPal')->where('status',1)->first();

            $PayPalmode = !is_null($PayPalpayment) ? $PayPalpayment->paypal_live_mode : null;

            $paypal_password = null;
            $paypal_signature = null;

            if (!is_null($PayPalpayment)) {

                switch ($PayPalpayment->paypal_live_mode) {
                    case 0:
                        $paypal_password = $PayPalpayment->test_paypal_password;
                        $paypal_signature = $PayPalpayment->test_paypal_signature;
                        break;

                    case 1:
                        $paypal_password = $PayPalpayment->live_paypal_password;
                        $paypal_signature = $PayPalpayment->live_paypal_signature;
                        break;

                    default:
                        $paypal_password = null;
                        $paypal_signature = null;
                        break;
                }
            }
            
            // $next_episode = Episode::select('title', 'slug')
            //                         ->where('season_id', $episode_details->season_id)
            //                         ->where('episode_order', '>', $episode_details->episode_order)
            //                         ->orderBy('episode_order', 'asc')
            //                         ->first();
            $next_episode = null;
            if($episode->active == 1 || ($episode->active == 0 && Auth::user()->role == 'admin')){
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
                        'paypal_payment_setting' => $PayPalpayment,
                        'Paystack_payment_settings' => PaymentSetting::where('payment_type', 'Paystack')->first(),
                        'Razorpay_payment_settings' => PaymentSetting::where('payment_type', 'Razorpay')->first(),
                        'CinetPay_payment_settings' => PaymentSetting::where('payment_type', 'CinetPay')->first(),
                        'category_name'             => $category_name ,
                        'episode_details'           => $episode_details ,
                        'video_viewcount_limit' => PartnerMonetizationSetting::pluck('video_viewcount_limit')->first(),
                        'user_role' => Auth::check() ? Auth::user()->role : 'guest',
                        'episode_PpvPurchase'  => $episode_PpvPurchase,
                        'episode_play_access'  => $episode_play_access,
                        'Razorpay_payment_setting' => $Razorpay_payment_setting,
                        'Paystack_payment_setting' => $Paystack_payment_setting ,
                        'stripe_payment_setting'   => $stripe_payment_setting ,
                        'paydunya_payment_setting' => $paydunya_payment_setting ,
                        'ppv_series_description'   => $ppv_series_description,
                        'paypal_signature' => $paypal_signature,
                        'purchase_btn'             => $purchase_btn,
                        'subscribe_btn'            => $subscribe_btn,
                        'next_episode'             => $next_episode,
                        'UserChannelSubscription'  => $UserChannelSubscription,
                        'Season_access'            => $season_access, 
                        'Series_access'            => $series_access, 
                    ];
                    // dd($data);
                    
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
                        'video_viewcount_limit' => PartnerMonetizationSetting::pluck('video_viewcount_limit')->first(),
                        'user_role' => Auth::check() ? Auth::user()->role : 'guest',
                        'episode_PpvPurchase'  => $episode_PpvPurchase,
                        'episode_play_access'  => $episode_play_access,
                        'Razorpay_payment_setting' => $Razorpay_payment_setting,
                        'Paystack_payment_setting' => $Paystack_payment_setting ,
                        'stripe_payment_setting'   => $stripe_payment_setting ,
                        'paydunya_payment_setting' => $paydunya_payment_setting ,
                        'ppv_series_description'   => $ppv_series_description,
                        'paypal_signature' => $paypal_signature,
                        'paypal_payment_setting' => $PayPalpayment,
                        'purchase_btn'             => $purchase_btn,
                        'subscribe_btn'            => $subscribe_btn,
                        'next_episode'             => $next_episode,
                        'UserChannelSubscription'  => $UserChannelSubscription,
                        'Season_access'            => $season_access, 
                        'Series_access'            => $series_access, 
                    ];
        
                    if (Auth::guest() && $settings->access_free == 1) {
                        return Theme::view('beforloginepisode', $data);
                    } else {
                        return Theme::view('episode', $data);
                    }
        
                    // return Redirect::to('/tv-shows')->with(array('message' => 'Sorry, To Watch series You have to purchase.', 'note_type' => 'error'));
                }
            } else {
            // return $th->getMessage();
            return abort(404);
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
        try {

            $currentUrl = url()->current();
            if (strpos($currentUrl, '/app/') !== false){
                if (!auth()->check()) {
                    $modifiedUrl = preg_replace('/\/app/', '', $currentUrl);
                    session(['url.intended' => $modifiedUrl]);
                    return redirect()->route('login');
                }else{
                    if (strpos($currentUrl, '/app') !== false) {
                        $modifiedUrl = str_replace('/app', '', $currentUrl);
                        return redirect($modifiedUrl);
                    }
                }
            }
            
            $Theme = HomeSetting::pluck('theme_choosen')->first();
            $theme = Theme::uses($Theme);
            $button_text = ButtonText::first();
            $buttons_pay = SiteTheme::select('purchase_btn', 'subscribe_btn')->first();
            $purchase_btn = $buttons_pay->purchase_btn;
            $subscribe_btn = $buttons_pay->subscribe_btn;

            $currency = CurrencySetting::first();

              // Payment Gateway Paypal

              $PayPalpayment = PaymentSetting::where('payment_type', 'PayPal')->where('status',1)->first();

              $PayPalmode = !is_null($PayPalpayment) ? $PayPalpayment->paypal_live_mode : null;
  
              $paypal_password = null;
              $paypal_signature = null;
  
              if (!is_null($PayPalpayment)) {
  
                  switch ($PayPalpayment->paypal_live_mode) {
                      case 0:
                          $paypal_password = $PayPalpayment->test_paypal_password;
                          $paypal_signature = $PayPalpayment->test_paypal_signature;
                          break;
  
                      case 1:
                          $paypal_password = $PayPalpayment->live_paypal_password;
                          $paypal_signature = $PayPalpayment->live_paypal_signature;
                          break;
  
                      default:
                          $paypal_password = null;
                          $paypal_signature = null;
                          break;
                  }
              }

            $settings = Setting::first();
           
            $ppv_series_description = Setting::pluck('series')->first();
        
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
                // $ppv_exits = PpvPurchase::where('user_id', '=', Auth::user()->id)
                //     ->where('series_id', '=', $id)
                //     ->count();

                $current_date = Carbon::now()->format('Y-m-d H:i:s a');
                $ppv_exits = PpvPurchase::where('series_id',$id)
                                        ->where('user_id', Auth::user()->id)
                                        ->where('to_time','>',$current_date)
                                        ->orderBy('created_at', 'desc')
                                        ->get()->map(function ($item){
                                            $payment_status = payment_status($item);
                                            if ($payment_status === null || $item->status === $payment_status) {
                                                return $item;
                                            }
                                                return null;
                                        })->first();

                $ppv_exits = $ppv_exits ? 1 : 0; 
            } else {
                $ppv_exits = 0;
            }
        
            $season = SeriesSeason::where('series_id', '=', $id)
                ->with('episodes')
                ->orderBy('order','desc')
                ->get();

            $season_trailer = SeriesSeason::where('series_id', '=', $id)->get();

            $episodefirst = Episode::where('series_id', '=', $id)
                ->orderBy('id', 'ASC')
                ->first();

            
            $category_name = SeriesGenre::select('series_genre.name as categories_name','series_genre.slug as categories_slug')
                ->Join('series_categories', 'series_categories.category_id', '=', 'series_genre.id')
                ->where('series_categories.series_id', $series->id)
                ->get();

            $payment_setting = PaymentSetting::where('status',1)->where('live_mode',1)->get();

            $Razorpay_payment_setting = PaymentSetting::where('payment_type','Razorpay')->where('status',1)->first();

            $Paystack_payment_setting = PaymentSetting::where('payment_type','Paystack')->where('status',1)->first();

            $stripe_payment_setting = PaymentSetting::where('payment_type','Stripe')->where('stripe_status',1)->first();

            $paydunya_payment_setting = PaymentSetting::where('payment_type','Paydunya')->where('status',1)->first();
                

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


                $season_depends_episode = Episode::where('active',1)->where('series_id',$id)
                                                ->where('season_id',$series_season_first)->orderBy('episode_order')->get();

                $featured_season_depends_episode = Episode::where('active',1)->where('featured',1)
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
                    'payment_setting' => $payment_setting,
                    'Razorpay_payment_setting' => $Razorpay_payment_setting,
                    'Paystack_payment_setting' => $Paystack_payment_setting ,
                    'stripe_payment_setting'   => $stripe_payment_setting ,
                    'paydunya_payment_setting' => $paydunya_payment_setting ,
                    'ppv_series_description'   => $ppv_series_description,
                    'button_text'              => $button_text,
                    'paypal_signature' => $paypal_signature,
                    'paypal_payment_setting' => $PayPalpayment,
                    'purchase_btn'           => $purchase_btn,
                    'subscribe_btn'          => $subscribe_btn,
                ];

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
                    'payment_setting' => $payment_setting,
                    'Razorpay_payment_setting' => $Razorpay_payment_setting,
                    'Paystack_payment_setting' => $Paystack_payment_setting ,
                    'stripe_payment_setting'   => $stripe_payment_setting ,
                    'paydunya_payment_setting' => $paydunya_payment_setting ,
                    'ppv_series_description'   => $ppv_series_description,
                    'button_text'              => $button_text,
                    'paypal_signature' => $paypal_signature,
                    'paypal_payment_setting' => $PayPalpayment,
                    'purchase_btn'             => $purchase_btn,
                    'subscribe_btn'            => $subscribe_btn,
                ];
                return Redirect::to('series')->with(['note' => 'Sorry, this series is no longer active.', 'note_type' => 'error']);
            }
        
        } catch (\Throwable $th) {
            // return $th->getMessage();
            return abort(404);
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
                // $ppv_exits = PpvPurchase::where('user_id', '=', Auth::user()->id)
                //     ->where('series_id', '=', $series->id)
                //     ->count();

                $current_date = Carbon::now()->format('Y-m-d H:i:s a');
                $ppv_exits = PpvPurchase::where('series_id',$series->id)
                                            ->where('user_id', Auth::user()->id)
                                            ->where('to_time','>',$current_date)
                                            ->orderBy('created_at', 'desc')
                                            ->get()->map(function ($item){
                                                $payment_status = payment_status($item);
                                                if ($payment_status === null || $item->status === $payment_status) {
                                                    return $item;
                                                }
                                                    return null;
                                            })->first();
    
                $ppv_exits = $ppv_exits ? 1 : 0; 
                                        
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
    public function video_js_Like_episode(Request $request)
    {
        try {

            $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();

            $inputs = [
                'episode_id' => $request->episode_id,
                'user_id' => !Auth::guest() ? Auth::user()->id : null,
                'users_ip_address' => Auth::guest() ? $geoip->getIP() : null,
                'disliked'   => 0 ,
            ];

            $check_Like_exist = LikeDislike::where('episode_id', $request->episode_id)->where('liked',1)
                                        ->where(function ($query) use ($geoip) {
                                            if (!Auth::guest()) {
                                                $query->where('user_id', Auth::user()->id);
                                            } else {
                                                $query->where('users_ip_address', $geoip->getIP());
                                            }
                                        })->first();

            $inputs += [ 'liked'  => is_null($check_Like_exist) ? 1 : 0 , ];


            $Like_exist = LikeDislike::where('episode_id', $request->episode_id)
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

    public function video_js_disLike_episode(Request $request)
    {
        try {

            $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();

            $inputs = [
                'episode_id' => $request->episode_id,
                'user_id' => !Auth::guest() ? Auth::user()->id : null,
                'users_ip_address' => Auth::guest() ? $geoip->getIP() : null,
                'liked'      => 0 ,
            ];

            $check_dislike_exist = LikeDislike::where('episode_id', $request->episode_id)->where('disliked',1)
                                        ->where(function ($query) use ($geoip) {
                                            if (!Auth::guest()) {
                                                $query->where('user_id', Auth::user()->id);
                                            } else {
                                                $query->where('users_ip_address', $geoip->getIP());
                                            }
                                        })->first();

            $inputs += [ 'disliked'  => is_null($check_dislike_exist) ? 1 : 0 , ];


            $dislike_exists = LikeDislike::where('episode_id', $request->episode_id)
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

    public function LikeEpisode(Request $request)
{
    $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();

    $episode = LikeDisLike::where('episode_id', '=', $request->episode_id)
        ->when(!Auth::guest(), function ($query) {
            return $query->where('user_id', Auth::user()->id);
        })
        ->unless(!Auth::guest(), function ($query) use ($geoip) {
            return $query->where('users_ip_address', $geoip->getIP());
        })
        ->first();

    if ($episode) {
        if ($episode->disliked) {
            $episode->disliked = 0;
        }
        $episode->liked = 1;
        $episode->save();

        $data = ['message' => 'Added to Like Episode, Dislike Removed if existed'];
    } else {
        $episode_new = new LikeDisLike();
        $episode_new->user_id = !Auth::guest() ? Auth::user()->id : null;
        $episode_new->users_ip_address = Auth::guest() ? $geoip->getIP() : null;
        $episode_new->liked = 1;
        $episode_new->episode_id = $request->episode_id;
        $episode_new->save();

        $data = ['message' => 'Added to Like Episode'];
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
        })
        ->first();

    if ($episode) {
        if ($episode->liked) {
            $episode->liked = 0;
        }
        $episode->save();

        $data = ['message' => 'Removed from Like Episode'];
    } else {
        $data = ['message' => 'NO Data'];
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
        })
        ->first();

    if ($episode) {
        if ($episode->liked) {
            $episode->liked = 0;
        }
        $episode->disliked = 1;
        $episode->save();

        $data = ['message' => 'Added to Dislike Episode, Like Removed if existed'];
    } else {
        $episode_new = new LikeDisLike();
        $episode_new->user_id = !Auth::guest() ? Auth::user()->id : null;
        $episode_new->users_ip_address = Auth::guest() ? $geoip->getIP() : null;
        $episode_new->disliked = 1;
        $episode_new->episode_id = $request->episode_id;
        $episode_new->save();

        $data = ['message' => 'Added to Dislike Episode'];
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
        })
        ->first();

    if ($episode) {
        if ($episode->disliked) {
            $episode->disliked = 0;
        }
        $episode->save();

        $data = ['message' => 'Removed from Dislike Episode'];
    } else {
        $data = ['message' => 'NO Data'];
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
        $id = !empty($episode->id) ? $episode->id : null;
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
            $settings = Setting::first();
            $category_list = SeriesGenre::orderBy('order')->get();
            $default_vertical_image_url = default_vertical_image_url();
           
            if ($settings->enable_landing_page == 1 && Auth::guest()) {

                $landing_page_slug = AdminLandingPage::where('status', 1)->pluck('slug')->first() ? AdminLandingPage::where('status', 1)->pluck('slug')->first() : 'landing-page';

                return redirect()->route('landing_page', $landing_page_slug);
            }

            $category_list = $this->paginateCollection($category_list, $this->videos_per_page);


            $data = [
                'category_list' => $category_list,
                'default_vertical_image_url' => $default_vertical_image_url,
            ];

            return Theme::view('SeriescategoryList', $data);
        } catch (\Throwable $th) {
            // return $th->getMessage();
            return abort(404);
        }
    }

    public function Specific_Series_Networks(Request $request,$slug)
    {
        try {
         
            $Theme = HomeSetting::pluck('theme_choosen')->first();
            Theme::uses($Theme);

            $series_data = SeriesNetwork::where('slug',$slug)->orderBy('order')->get()->map(function ($item) {

                $item['Series_depends_Networks'] = Series::join('series_network_order', 'series.id', '=', 'series_network_order.series_id')
                ->where('series.active', 1)
                ->where('series_network_order.network_id', $item->id)
                ->orderBy('series_network_order.order', 'asc')
                ->get()->map(function ($item) { 
                    
                    $item['image_url']        = !is_null($item->image)  ? URL::to('public/uploads/images/'.$item->image) : default_vertical_image() ;
                    $item['Player_image_url'] = !is_null($item->player_image)  ? URL::to('public/uploads/images/'.$item->player_image ) : default_horizontal_image_url() ;

                    $item['Series_depends_episodes'] = Episode::where('series_id', $item->id)->where('active',1)->get()
                                                            ->map(function ($item) {
                                                            $item['image_url']  = !is_null($item->image) ? URL::to('public/uploads/images/'.$item->image) : default_vertical_image() ;
                                                            return $item;
                                                        });

                    $item['source'] = 'Series';
                    return $item;
                                                                        
                });

                return $item;
            })->first();

            if ($series_data) {
                $series_data_collection = collect([$series_data]);
                $series_networks_paginate = $this->paginateCollection(collect($series_data['Series_depends_Networks']), $this->videos_per_page);
    
                $data = array(
                    'series_data' => $series_data,
                    'series_networks_pagelist' => $series_networks_paginate,
                );
    
                return Theme::view('partials.home.SeriesNetworks', $data);
            } else {
                throw new \Exception('Series data not found');
            }
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    public function Series_Networks_List()
    {
        
        $Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses($Theme);

        $series_data = SeriesNetwork::orderBy('order')->limit(15)->get()->map(function ($item) {
            $item['image_url'] = $item->image != null ? URL::to('public/uploads/seriesNetwork/'.$item->image ) : default_vertical_image_url() ;
            $item['banner_image_url'] = $item->banner_image != null ?  URL::to('public/uploads/seriesNetwork/'.$item->banner_image ) : default_horizontal_image_url();
            return $item;
        });

        $data = array(
             'series_data' => $series_data,
             'multiple_compress_image' => CompressImage::pluck('enable_multiple_compress_image')->first() ? CompressImage::pluck('enable_multiple_compress_image')->first() : 0,
            );

        return Theme::view('partials.home.Series-Networks-List',$data);

    }


    public function VideoCipher_Episode($series_name, $episode_name,$plan)
    {
        try {

        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
            
        $Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses($Theme);
        $settings = Setting::first();

        $buttons_pay = SiteTheme::select('purchase_btn', 'subscribe_btn')->first();
        $purchase_btn = $buttons_pay->purchase_btn;
        $subscribe_btn = $buttons_pay->subscribe_btn;

        $series_id = Series::where('slug',$series_name)->pluck('id')->first();

        $ppv_series_description = Setting::pluck('series')->first();

        $button_text = ButtonText::first();
    
        $auth_user = Auth::user();
    
        if ($auth_user == null) {
            $auth_user_id = null;
        } else {
            $auth_user_id = Auth::user()->id;
        }
    
        $episodess = Episode::where('slug', '=', $episode_name)->where('series_id',$series_id)
            ->orderBy('id', 'DESC')
            ->first();
    
        $source_id = Episode::where('slug', '=', $episode_name)->where('series_id',$series_id)
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
    
        $episode = Episode::where('slug', '=', $episode_name)->where('series_id',$series_id)
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
            // $ppv_exits = PpvPurchase::where('user_id', '=', Auth::user()->id)
            //     ->where('episode_id', '=', $id)
            //     ->count();

            $current_date = Carbon::now()->format('Y-m-d H:i:s a');
            $ppv_exits = PpvPurchase::where('episode_id',$id)
                                    ->where('user_id', Auth::user()->id)
                                    ->where('to_time','>',$current_date)
                                    ->orderBy('created_at', 'desc')
                                    ->get()->map(function ($item){
                                        $payment_status = payment_status($item);
                                        if ($payment_status === null || $item->status === $payment_status) {
                                            return $item;
                                        }
                                            return null;
                                    })->first();
    
            $ppv_exits = $ppv_exits ? 1 : 0; 

        } else {
            $ppv_exits = 0;
        }
    
        if ($series->ppv_status == 1 && $settings->access_free == 0) {
            // $ppv_exits = PpvPurchase::where('user_id', '=', Auth::user()->id)
            //     ->where('series_id', '=', $series->id)
            //     ->count();

            $current_date = Carbon::now()->format('Y-m-d H:i:s a');
            $ppv_exits = PpvPurchase::where('series_id', $series->id)
                                    ->where('user_id', Auth::user()->id)
                                    ->where('to_time','>',$current_date)
                                    ->orderBy('created_at', 'desc')
                                    ->get()->map(function ($item){
                                        $payment_status = payment_status($item);
                                        if ($payment_status === null || $item->status === $payment_status) {
                                            return $item;
                                        }
                                            return null;
                                    })->first();
    
            $ppv_exits = $ppv_exits ? 1 : 0; 


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
                
            $current_date = Carbon::now()->format('Y-m-d H:i:s a');
            // $PpvPurchase = PpvPurchase::where('user_id',Auth::user()->id)
            //                 ->where('series_id', '=', $episode->series_id)
            //                 ->where('season_id', '=', $episode->season_id)
            //                 ->count();

            $PpvPurchase = PpvPurchase::where('series_id', $episode->series_id)
                                    ->where('season_id', '=', $episode->season_id)
                                    ->where('user_id', Auth::user()->id)
                                    ->where('to_time','>',$current_date)
                                    ->orderBy('created_at', 'desc')
                                    ->get()->map(function ($item){
                                        $payment_status = payment_status($item);
                                        if ($payment_status === null || $item->status === $payment_status) {
                                            return $item;
                                        }
                                            return null;
                                    })->first();
    
            $PpvPurchase = $PpvPurchase ? 1 : 0; 


                                    
            // $SeriesPpvPurchase = PpvPurchase::where('user_id',Auth::user()->id)
            // ->where('series_id', '=', $episode->series_id)
            // ->count();

            $SeriesPpvPurchase = PpvPurchase::where('series_id', $episode->series_id)
                                            ->where('user_id', Auth::user()->id)
                                            ->where('to_time','>',$current_date)
                                            ->orderBy('created_at', 'desc')
                                            ->get()->map(function ($item){
                                                $payment_status = payment_status($item);
                                                if ($payment_status === null || $item->status === $payment_status) {
                                                    return $item;
                                                }
                                                    return null;
                                            })->first();
            
            $SeriesPpvPurchase = $SeriesPpvPurchase ? 1 : 0; 
        



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

                // $PpvPurchase = PpvPurchase::where('user_id',Auth::user()->id)
                //                 ->where('series_id', '=', $episode->series_id)
                //                 ->where('season_id', '=', $episode->season_id)
                //                 ->count();

                $current_date = Carbon::now()->format('Y-m-d H:i:s a');
                $PpvPurchase = PpvPurchase::where('series_id',  $episode->series_id)
                                            ->where('season_id', '=', $episode->season_id)
                                            ->where('user_id', Auth::user()->id)
                                            ->where('to_time','>',$current_date)
                                            ->orderBy('created_at', 'desc')
                                            ->get()->map(function ($item){
                                                $payment_status = payment_status($item);
                                                if ($payment_status === null || $item->status === $payment_status) {
                                                    return $item;
                                                }
                                                    return null;
                                            })->first();
            
                $PpvPurchase = $PpvPurchase ? 1 : 0; 
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

                    $current_date = Carbon::now()->format('Y-m-d H:i:s a');

                    // $PpvPurchase = PpvPurchase::where('user_id',Auth::user()->id)
                    //                             ->where('series_id', '=', $episode->series_id)
                    //                             ->where('season_id', '=', $episode->season_id)
                    //                             ->count();

                    $PpvPurchase = PpvPurchase::where('series_id', $episode->series_id)
                                                ->where('season_id', '=', $episode->season_id)
                                                ->where('user_id', Auth::user()->id)
                                                ->where('to_time','>',$current_date)
                                                ->orderBy('created_at', 'desc')
                                                ->get()->map(function ($item){
                                                    $payment_status = payment_status($item);
                                                    if ($payment_status === null || $item->status === $payment_status) {
                                                        return $item;
                                                    }
                                                        return null;
                                                })->first();
            
                    $PpvPurchase = $PpvPurchase ? 1 : 0; 


                    // $SeriesPpvPurchase = PpvPurchase::where('user_id',Auth::user()->id)
                    //                 ->where('series_id', '=', $episode->series_id)
                    //                 ->count();

                    $SeriesPpvPurchase = PpvPurchase::where('series_id', $episode->series_id)
                                                    ->where('user_id', Auth::user()->id)
                                                    ->where('to_time','>',$current_date)
                                                    ->orderBy('created_at', 'desc')
                                                    ->get()->map(function ($item){
                                                        $payment_status = payment_status($item);
                                                        if ($payment_status === null || $item->status === $payment_status) {
                                                            return $item;
                                                        }
                                                            return null;
                                                    })->first();
                    
                    $SeriesPpvPurchase = $SeriesPpvPurchase ? 1 : 0; 


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
                            Auth::user()->role == 'subscriber' &&  $season_details->access == 'free'
                            || settings_enable_rent() == 1 && Auth::user()->role == 'subscriber'  && $season_details->access == 'ppv'  ) {
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
                           || settings_enable_rent() == 1 && Auth::user()->role == 'subscriber'  && $season_details->access == 'ppv' 
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
                }elseif (!Auth::guest() && $series->access == 'ppv' && $SeriesPpvPurchase == 0
                || !Auth::guest() && Auth::user()->role == 'subscriber' && $settings->enable_ppv_rent == 0 && $series->access == 'ppv'  && $SeriesPpvPurchase == 0
                 ) 
                {
                    
                    $free_episode = 0;
                }elseif (!Auth::guest() && $series->access == 'ppv' && $SeriesPpvPurchase == 0
                    || !Auth::guest() && Auth::user()->role == 'subscriber' && $settings->enable_ppv_rent == 0 && $series->access == 'ppv'  && $SeriesPpvPurchase == 0
                 ) 
                {
                    $free_episode = 0;
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
                // $ppv_exits = PpvPurchase::where('user_id', '=', Auth::user()->id)
                //     // ->where('season_id', '=', $season_id)
                //     ->where('series_id', '=', $episode->series_id)
                //     ->count();

                    $current_date = Carbon::now()->format('Y-m-d H:i:s a');
                    $ppv_exits = PpvPurchase::where('season_id', $season_id)
                                            ->where('series_id', $episode->series_id)
                                            ->where('user_id', Auth::user()->id)
                                            ->where('to_time','>',$current_date)
                                            ->orderBy('created_at', 'desc')
                                            ->get()->map(function ($item){
                                                $payment_status = payment_status($item);
                                                if ($payment_status === null || $item->status === $payment_status) {
                                                    return $item;
                                                }
                                                    return null;
                                            })->first();
            
                    $ppv_exits = $ppv_exits ? 1 : 0; 
    
                    // $PpvPurchase = PpvPurchase::where('series_id', '=', $episode->series_id)
                    // ->where('season_id', '=', $episode->season_id)
                    // ->count();

                    $PpvPurchase = PpvPurchase::where('season_id', $episode->season_id)
                                            ->where('series_id', $episode->series_id)
                                            ->where('user_id', Auth::user()->id)
                                            ->where('to_time','>',$current_date)
                                            ->orderBy('created_at', 'desc')
                                            ->get()->map(function ($item){
                                                $payment_status = payment_status($item);
                                                if ($payment_status === null || $item->status === $payment_status) {
                                                    return $item;
                                                }
                                                    return null;
                                            })->first();
            
                    $PpvPurchase = $PpvPurchase ? 1 : 0; 



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
    
                // $PpvPurchase = PpvPurchase::where('series_id', '=', $episode->series_id)
                // ->where('season_id', '=', $episode->season_id)
                // ->count();
                
                $current_date = Carbon::now()->format('Y-m-d H:i:s a');
                $PpvPurchase =  PpvPurchase::where('season_id', $episode->season_id)
                                            ->where('series_id', $episode->series_id)
                                            ->where('to_time','>',$current_date)
                                            ->orderBy('created_at', 'desc')
                                            ->get()->map(function ($item){
                                                $payment_status = payment_status($item);
                                                if ($payment_status === null || $item->status === $payment_status) {
                                                    return $item;
                                                }
                                                    return null;
                                            })->first();
            
                $PpvPurchase = $PpvPurchase ? 1 : 0; 
                
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

                $seasons = SeriesSeason::where('series_id', '=', $episode->series_id)->first();

                $episode_details = Episode::where('id',$source_id)->get()->map( function ($item) use ($seasons,$series,$plan)  {

                $item['Thumbnail']  =   !is_null($item->image)  ? URL::to('public/uploads/images/'.$item->image) : default_vertical_image_url() ;
                $item['Player_thumbnail'] = !is_null($item->player_image)  ? URL::to('public/uploads/images/'.$item->player_image ) : default_horizontal_image_url() ;
                $item['TV_Thumbnail'] = !is_null($item->tv_image)  ? URL::to('public/uploads/images/'.$item->tv_image)  : default_horizontal_image_url() ;
  

                $item['video_skip_intro_seconds']        = $item->skip_intro  ? Carbon::parse($item->skip_intro)->secondsSinceMidnight() : null ;
                $item['video_intro_start_time_seconds']  = $item->intro_start_time ? Carbon::parse($item->intro_start_time)->secondsSinceMidnight() : null ;
                $item['video_intro_end_time_seconds']    = $item->intro_end_time ? Carbon::parse($item->intro_end_time)->secondsSinceMidnight() : null ;

                $item['video_skip_recap_seconds']        = $item->skip_recap ? Carbon::parse($item->skip_recap)->secondsSinceMidnight() : null ;
                $item['video_recap_start_time_seconds']  = $item->recap_start_time ? Carbon::parse($item->recap_start_time)->secondsSinceMidnight() : null ;
                $item['video_recap_end_time_seconds']    = $item->recap_end_time ? Carbon::parse($item->recap_end_time)->secondsSinceMidnight() : null ;
                $item['users_episode_visibility_redirect_url'] =  URL::to('/episode'.'/'.$series->title.'/'.$item['slug']) ;
                
                // !empty(@$plan) && @$plan != '' && $seasons->access == 'guest' || 
                if( !empty(@$plan) && @$plan != '' && !Auth::guest() && Auth::user()->role == "admin"){
                    
                    $item['Episode_url'] =  $item->episode_id_1080p ;

               }elseif(!empty(@$plan) && @$plan != '' && $series->access == 'guest'  && $seasons->access == 'free' ||  !empty(@$plan) && @$plan != '' && $series->access == 'registered'  && $seasons->access == 'free'){

                if($plan == '480p'){ $item['Episode_url'] =  $item->episode_id_480p ; }elseif($plan == '720p' ){$item['Episode_url'] =  $item->episode_id_720p ; }elseif($plan == '1080p'){ $item['Episode_url'] =  $item->episode_id_1080p ; }else{ $item['Episode_url'] =  '' ;}

                }elseif(!empty(@$plan) && @$plan != '' && $series->access == 'registered' && Auth::user()->role == 'registered' ){

                    if($plan == '480p'){ $item['Episode_url'] =  $item->episode_id_480p ; }elseif($plan == '720p' ){$item['Episode_url'] =  $item->episode_id_720p ; }elseif($plan == '1080p'){ $item['Episode_url'] =  $item->episode_id_1080p ; }else{ $item['Episode_url'] =  '' ;}

                }elseif(!Auth::guest() && Auth::user()->role == "registered" && $seasons->access == 'ppv'){


                    $item['PPV_Plan']   = PpvPurchase::where('user_id',Auth::user()->id)->where('series_id', '=', $item['series_id'])->where('season_id', '=', $item['season_id'])->orderBy('created_at', 'desc')->pluck('ppv_plan')->first();

                    if($item['PPV_Plan'] > 0){
                        if($item['PPV_Plan'] == '480p'){ $item['Episode_url'] =  $item->episode_id_480p ; }elseif($item['PPV_Plan'] == '720p' ){$item['Episode_url'] =  $item->episode_id_720p ; }elseif($item['PPV_Plan'] == '1080p'){ $item['Episode_url'] =  $item->episode_id_1080p ; }else{ $item['Episode_url'] =  '' ;}
                    }else{
                        $item['PPV_Plan']  = '';
                    }
               }
               elseif( $seasons->access == 'ppv' && !Auth::guest() && Auth::user()->role == "subscriber"){
                    $item['PPV_Plan']   = PpvPurchase::where('user_id',Auth::user()->id)->where('series_id', '=', $item['series_id'])->where('season_id', '=', $item['season_id'])->orderBy('created_at', 'desc')->pluck('ppv_plan')->first();
                    if($item['PPV_Plan'] > 0){
                            if($item['PPV_Plan'] == '480p'){ $item['Episode_url'] =  $item->episode_id_480p ; }elseif($item['PPV_Plan'] == '720p' ){$item['Episode_url'] =  $item->episode_id_720p ; }elseif($item['PPV_Plan'] == '1080p'){ $item['Episode_url'] =  $item->episode_id_1080p ; }else{ $item['Episode_url'] =  '' ;}
                        }else{
                            $item['PPV_Plan']  = '';
                        }
               }else{
                   $item['PPV_Plan']   = '';
               }

               
               $videoId = $item['Episode_url']; 
            //    dd($videoId);
               $apiKey = videocipher_Key();
               $curl = curl_init();
               $watermarkText = Auth::user()->mobile; 
               $annotateJson = json_encode([
                   [
                       "type" => "rtext",
                       "text" => $watermarkText,
                       "alpha" => "0.60",
                       "color" => "0xFF0000", 
                       "size" => "15",
                       "interval" => "5000",
                   ]
               ]);
               curl_setopt_array($curl, array(
                   CURLOPT_URL => "https://dev.vdocipher.com/api/videos/$videoId/otp",
                   CURLOPT_RETURNTRANSFER => true,
                   CURLOPT_ENCODING => "",
                   CURLOPT_MAXREDIRS => 10,
                   CURLOPT_TIMEOUT => 30,
                   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                   CURLOPT_CUSTOMREQUEST => "POST",
                   CURLOPT_POSTFIELDS => json_encode([
                       "ttl" => 30000, 
                       "annotate" => $annotateJson
                   ]),
                   CURLOPT_HTTPHEADER => array(
                       "Accept: application/json",
                       "Authorization: Apisecret $apiKey",
                       "Content-Type: application/json"
                   ),
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0),
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0),
               ));

               $response = curl_exec($curl);
               $err = curl_error($curl);

               curl_close($curl);

               if ($err) {
                   // echo "cURL Error #:" . $err;
                   $item['otp'] = null;
                   $item['playbackInfo'] = null;
                  
               } else {

                   $responseObj = json_decode($response, true);

                   if(!empty($responseObj['message']) && $responseObj['message'] == "No new update parameters" || !empty($responseObj['message']) && $responseObj['message'] == "video not found"){
                       $item['otp'] = null;
                       $item['playbackInfo'] = null;
                       $item['playbackmessage'] = $responseObj['message'];
                   }else{
                       $item['otp'] = $responseObj['otp'];
                       $item['playbackInfo'] = $responseObj['playbackInfo'];
                       $item['playbackmessage'] = null;
                   }

                  
               }

                return $item;
  
            })->first();
            // dd($episode_details);
            if(!Auth::guest()){
                // $episode_PpvPurchase = PpvPurchase::where('user_id', '=', Auth::user()->id)
                //                         ->where('series_id', '=', $episode->series_id)
                //                         ->where('season_id', '=', $episode->season_id)
                //                         ->where('episode_id', '=', $episode->id)
                //                         ->count();

                $current_date = Carbon::now()->format('Y-m-d H:i:s a');
                $episode_PpvPurchase = PpvPurchase::where('season_id', $episode->season_id)
                                            ->where('series_id', $episode->series_id)
                                            ->where('season_id', $episode->season_id)
                                            ->where('episode_id', $episode->id)
                                            ->where('to_time','>',$current_date)
                                            ->orderBy('created_at', 'desc')
                                            ->get()->map(function ($item){
                                                $payment_status = payment_status($item);
                                                if ($payment_status === null || $item->status === $payment_status) {
                                                    return $item;
                                                }
                                                    return null;
                                            })->first();
            
                $episode_PpvPurchase = $episode_PpvPurchase ? 1 : 0; 

            }else{
                $episode_PpvPurchase = 0;
            }
            if(!Auth::guest()){
                    // $SeasonSeriesPpvPurchaseCount = PpvPurchase::where('user_id',Auth::user()->id)
                    // ->where('series_id', '=', $episode->series_id)
                    // ->where('season_id', '=', $episode->season_id)->orderBy('created_at', 'desc')
                    // ->count();

                    $current_date = Carbon::now()->format('Y-m-d H:i:s a');
                    $SeasonSeriesPpvPurchaseCount = PpvPurchase::where('season_id', $episode->season_id)
                                                ->where('series_id', $episode->series_id)
                                                ->where('season_id', $episode->season_id)
                                                ->where('to_time','>',$current_date)
                                                ->orderBy('created_at', 'desc')
                                                ->get()->map(function ($item){
                                                    $payment_status = payment_status($item);
                                                    if ($payment_status === null || $item->status === $payment_status) {
                                                        return $item;
                                                    }
                                                        return null;
                                                })->first();
            
                    $SeasonSeriesPpvPurchaseCount = $SeasonSeriesPpvPurchaseCount ? 1 : 0; 
            }else{
                $SeasonSeriesPpvPurchaseCount = 0 ;
            }

            $season_access_ppv = SeriesSeason::where('id', $episode->season_id)->pluck('access')->first();
            
            if(!Auth::guest()){
                $ppv_purchase_user = PpvPurchase::where('user_id',Auth::user()->id)->select('user_id','season_id')
                                                ->get()->map(function ($item){
                                                    $payment_status = payment_status($item);
                                                    if ($payment_status === null || $item->status === $payment_status) {
                                                        return $item;
                                                    }
                                                        return null;
                                                })->first();

                // $ppv_purchase = PpvPurchase::where('season_id','=',$episode->season_id)->orderBy('created_at', 'desc')
                // ->where('user_id', Auth::user()->id)
                // ->first();
        
                // if(!empty($ppv_purchase) && !empty($ppv_purchase->to_time)){
                //     $new_date = Carbon::parse($ppv_purchase->to_time)->format('M d , y H:i:s');
                //     $currentdate = date("M d , y H:i:s");
                //     $ppv_exists_check_query = $new_date > $currentdate ?  1 : 0;
                // }
                // else{
                //     $ppv_exists_check_query = 0;
                // }    

                
                $current_date = Carbon::now()->format('Y-m-d H:i:s a');
                $ppv_purchase = PpvPurchase::where('season_id',$episode->season_id)
                                            ->where('user_id', Auth::user()->id)
                                            ->where('to_time','>',$current_date)
                                            ->orderBy('created_at', 'desc')
                                            ->get()->map(function ($item){
                                                $payment_status = payment_status($item);
                                                if ($payment_status === null || $item->status === $payment_status) {
                                                    return $item;
                                                }
                                                    return null;
                                            })->first();

                $ppv_exists_check_query = !empty($ppv_purchase) ? 1 : 0;


            if($season_access_ppv == "free" && $series->access == 'guest' || Auth::user()->role == "admin" || $season_access_ppv == "free" && $series->access == 'registered' && Auth::user()->role == 'registered' || $season_access_ppv == "free" && $series->access == 'registered' && Auth::user()->role == 'subscriber'){
                $episode_play_access = 1;
            }else{
                if(Auth::guest()){
                    $episode_play_access = 0;
                }elseif(Auth::user()->role == "registered"){
                    if($ppv_purchase_user && $ppv_purchase_user->season_id == $episode->season_id || $ppv_exists_check_query > 0){
                        $episode_play_access = 1;
                    }else{
                        $episode_play_access = 0;
                    }
                }elseif(Auth::user()->role == "subscriber" && $setting_subscirbe_series_access == 1){
                    $episode_play_access = 1;
                }
                elseif(Auth::user()->role == "subscriber" && $setting_subscirbe_series_access == 0){
                    if($ppv_purchase_user && $ppv_purchase_user->season_id == $episode->season_id || $ppv_exists_check_query > 0 ){
                        $episode_play_access = 1;
                    }else{
                        $episode_play_access = 0;
                    }
                }
            }
        }else{
            if($season_access_ppv == "free" && $series->access == 'guest'){
                $episode_play_access = 1;
            }else{
                if(Auth::guest()){
                    $episode_play_access = 0;
                }elseif(Auth::user()->role == "registered"){
                    if($ppv_purchase_user && $ppv_purchase_user->season_id == $episode->season_id || $ppv_exists_check_query > 0){
                        $episode_play_access = 1;
                    }else{
                        $episode_play_access = 0;
                    }
                }elseif(Auth::user()->role == "subscriber" && $setting_subscirbe_series_access == 1){
                    $episode_play_access = 1;
                }
                elseif(Auth::user()->role == "subscriber" && $setting_subscirbe_series_access == 0){
                    if($ppv_purchase_user && $ppv_purchase_user->season_id == $episode->season_id || $ppv_exists_check_query > 0 ){
                        $episode_play_access = 1;
                    }else{
                        $episode_play_access = 0;
                    }
                }
            }
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
                    'SeasonSeriesPpvPurchaseCount'  => $SeasonSeriesPpvPurchaseCount,
                    'ppv_series_description'        => $ppv_series_description,
                    'button_text'                    => $button_text,
                    'purchase_btn'                    => $purchase_btn,
                    'subscribe_btn'                    => $subscribe_btn,
                    'episode_play_access' => $episode_play_access,
                    'video_viewcount_limit' => PartnerMonetizationSetting::pluck('video_viewcount_limit')->first(),
                    'user_role'                  => Auth::check() ? Auth::user()->role : 'guest',

                ];
                
                if (Auth::guest() && $settings->access_free == 1) {
                    return Theme::view('beforloginepisode', $data);
                } else {
                    return Theme::view('videoCipherepisode', $data);
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
                    'ppv_series_description'        => $ppv_series_description,
                    'button_text'                    => $button_text,
                    'purchase_btn'                    => $purchase_btn,
                    'subscribe_btn'                    => $subscribe_btn,
                    'SeasonSeriesPpvPurchaseCount'  => $SeasonSeriesPpvPurchaseCount,
                    'video_viewcount_limit' => PartnerMonetizationSetting::pluck('video_viewcount_limit')->first(),
                    'user_role'                  => Auth::check() ? Auth::user()->role : 'guest',
                ];
                if (Auth::guest() && $settings->access_free == 1) {
                    return Theme::view('beforloginepisode', $data);
                } else {
                    return Theme::view('videoCipherepisode', $data);
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

    public function EpisodeContinueWatching(Request $request)
    {
        try {
            $data = $request->all();
            
            if (Auth::user()) {
                $user_id            = Auth::user()->id;
                $episode_id         = $request->episode_id;
                $duration           = $request->duration;
                $currentTime        = $request->currentTime;
                $watch_percentage   = $request->watch_percentage;
    
                if ($duration > 0) {
                    
                    $cnt = ContinueWatching::where("episodeid", $episode_id)
                                            ->where("user_id", $user_id)
                                            ->count();
    
                    // Get the first record if it exists
                    $get_cnt = ContinueWatching::where("episodeid", $episode_id)
                                                ->where("user_id", $user_id)
                                                ->first();
    
                    // If the user has completed watching (99% or more), remove the entry
                    if ($cnt > 0 && $watch_percentage >= "99") {
                        ContinueWatching::where("episodeid", $episode_id)
                                        ->where("user_id", $user_id)
                                        ->delete();
                    }
                    
                    // If no entry exists, create a new one
                    if ($cnt == 0) {
                        $episode = new ContinueWatching;
                        $episode->episodeId = $episode_id;
                        $episode->user_id = $user_id;
                        $episode->currentTime = $currentTime;
                        $episode->watch_percentage = $watch_percentage;
                        $episode->save();
                    }
                    // If the entry already exists, update the existing one
                    else {
                        $cnt_watch = ContinueWatching::where("episodeid", $episode_id)
                                                        ->where("user_id", $user_id)
                                                        ->first();
                        $cnt_watch->currentTime = $currentTime;
                        $cnt_watch->watch_percentage = $watch_percentage;
                        $cnt_watch->save();
                    }
    
                    return response()->json(['success' => true], 200);
                } else {
                    return response()->json(['error' => 'Invalid video duration'], 400);
                }
            }
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
 
    public function EpisodePartnerMonetization(Request $request)
    {
        try {
            $video_id = $request->video_id;
            $video = Episode::where('id', $video_id)->first();
            if ($video) {
                $video->played_views += 1;
                $video->save();
                $monetizationSettings = PartnerMonetizationSetting::select('viewcount_limit', 'views_amount')->first();

                if ($monetizationSettings) {
                    $monetization_view_limit = $monetizationSettings->viewcount_limit;
                    $monetization_view_amount = $monetizationSettings->views_amount;

                    if ($video->played_views > $monetization_view_limit) {
                        $previously_monetized_views = $video->monetized_views ?? 0;
                        $new_monetizable_views = $video->played_views - $monetization_view_limit - $previously_monetized_views;

                        if ($new_monetizable_views > 0) {

                            $additional_amount = $new_monetizable_views * $monetization_view_amount;
                            $video->monetization_amount += $additional_amount;
                            $video->monetized_views += $new_monetizable_views;
                            $video->save();

                            $channeluser_commission = (float) $video->channeluser->commission;
                            $channel_commission = ($channeluser_commission / 100) * $video->monetization_amount;

                            $partner_monetization = PartnerMonetization::where('user_id', $video->user_id)
                                ->where('type_id', $video->id)
                                ->where('type', 'episode')->first();

                            $monetization_data = [
                                'total_views' => $video->played_views,
                                'title' => $video->title,
                                'monetization_amount' => $video->monetization_amount,
                                'admin_commission' => $video->monetization_amount - $channel_commission,
                                'partner_commission' => $channel_commission,
                            ];

                            if ($partner_monetization) {
                                $partner_monetization->update($monetization_data);
                            } else {
                                PartnerMonetization::create(array_merge($monetization_data, [
                                    'user_id' => $video->user_id,
                                    'type_id' => $video->id,
                                    'type' => 'episode',
                                ]));
                            }
                        }
                    }

                    return response()->json(['message' => 'View count incremented and monetization updated', 'played_view' => $video->played_views, 'monetization_amount' => $video->monetization_amount], 200);
                } else {
                    return response()->json(['error' => 'Video not found'], 404);
                }
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function AllSeries_category(){
        try{
            return Theme::view('SeriesBasedCategories');

        }
        catch (\Throwable $th) {

            // return $th->getMessage();
            return abort(404);
        }
    }

}
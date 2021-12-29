<?php

namespace App\Http\Controllers;
use \App\User as User;
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
use Carbon;
use Session;
use App\RecentView as RecentView;
use App\CurrencySetting as CurrencySetting;
use App\Playerui as Playerui;

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
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {

     $settings = Setting::first();

     $genre = Genre::all();
     $trending_episodes_count = Episode::where('active', '=', '1')->where('status', '=', '1')->where('views', '>', '5')->orderBy('id', 'DESC')->count();
     if ($trending_episodes_count > 0) {
     $trending_episodes = Episode::where('active', '=', '1')->where('status', '=', '1')->where('views', '>', '5')->orderBy('id', 'DESC')->get();
    } else {
           $trending_episodes = [];
    } 
    $featured_episodes_count = Episode::where('active', '=', '1')->where('featured', '=', '1')->orderBy('views', 'DESC')->count();
    if ($featured_episodes_count > 0) {
     $featured_episodes = Episode::where('active', '=', '1')->where('featured', '=', '1')->orderBy('views', 'DESC')->get();
    } else {
        $featured_episodes = [];
    } 
    $latest_series_count = Series::where('active', '=', '1')->orderBy('created_at', 'DESC')->count();
    if ($latest_series_count > 0) {
        $latest_series = Series::where('active', '=', '1')->take(10)->orderBy('created_at', 'DESC')->get();
    } else {
            $latest_series = [];
    } 
    $latest_episodes_count = Episode::where('active', '=', '1')->where('status', '=', '1')->orderBy('id', 'DESC')->count();
    if ($latest_episodes_count > 0) {
        $latest_episodes = Episode::where('active', '=', '1')->where('status', '=', '1')->take(10)->orderBy('id', 'DESC')->get();
    } else {
            $latest_episodes = [];
    }
    //  $trending_episodes = Episode::where('active', '=', '1')->where('status', '=', '1')->where('views', '>', '5')->orderBy('created_at', 'DESC')->get();
    //  $latest_episodes = Episode::where('active', '=', '1')->where('status', '=', '1')->take(10)->orderBy('created_at', 'DESC')->get();
    //  $featured_episodes = Episode::where('active', '=', '1')->where('featured', '=', '1')->orderBy('views', 'DESC')->get();
    //  $latest_series = Series::where('active', '=', '1')->take(10)->orderBy('created_at', 'DESC')->get();
    $currency = CurrencySetting::first();
     
     $pages = Page::all();
     $data = array(
      'episodes' => Episode::where('active', '=', '1')->where('status', '=', '1')->orderBy('id', 'DESC')->simplePaginate(120000),
      'banner' => Episode::where('active', '=', '1')->where('status', '=', '1')->orderBy('id', 'DESC')->simplePaginate(120000),
      'trendings' => $trending_episodes,
      'latest_episodes' => $latest_episodes,
      'featured_episodes' => $featured_episodes,
      'latest_series' => $latest_series,
      'current_page' => 1,
      'genres' => $genre,
      'pagination_url' => '/series',
      'settings'=>$settings,
      'pages'=>$pages,
      'currency' => $currency,

    );
    //echo "<pre>";print_r($data);exit;
     return View::make('tv-home', $data);
   }

   public function play_episode($series_name,$episode_name)//
   {
        
   	$settings = Setting::first();
   	if(Auth::guest()):
            return Redirect::to('/login');
        endif;
        $episode = Episode::where('title','=',$episode_name)->orderBy('id', 'DESC')->first();    
        $id = $episode->id;
        // $episode = Episode::findOrFail($id);
        $season = SeriesSeason::where('series_id','=',$episode->series_id)->with('episodes')->get();
        $series = Series::find($episode->series_id);
        //$episoderesolutions = Episode::findOrFail($id)->episoderesolutions;
        $episodenext = Episode::where('id', '>', $id)->where('series_id','=',$episode->series_id)->first();
        $episodeprev = Episode::where('id', '<', $id)->where('series_id','=',$episode->series_id)->first();
        //Make sure series is active
        
        $wishlisted = false;
        if(!Auth::guest()):
                $wishlisted = Wishlist::where('user_id', '=', Auth::user()->id)->where('episode_id', '=', $id)->first();
        endif;
        // use App\PpvPurchase as PpvPurchase;

        if(!empty($episode->ppv_price)){
            // dd('test');
            $ppv_exits = PpvPurchase::where('user_id', '=', Auth::user()->id)->where('episode_id', '=', $id)->count();

        }else{
            $ppv_exits = 0 ;
        }
        
        if(($series->ppv_status == 1)){
            $ppv_exits = PpvPurchase::where('user_id', '=', Auth::user()->id)->where('series_id', '=', $series->id)->count();
        // dd($ppv_exits);

        }else{
            $ppv_exits = 0 ;
        dd($ppv_exits);

        }
       
        $watchlater = false;
        
         if(!Auth::guest()):
                $watchlater = Watchlater::where('user_id', '=', Auth::user()->id)->where('episode_id', '=', $id)->first();
         endif;
        
        if((!Auth::guest() && Auth::user()->role == 'admin') || $series->active){



            $view_increment = $this->handleViewCount($id);
            $currency = CurrencySetting::first();

            $playerui = Playerui::first();
            $payment_settings = PaymentSetting::first();  
            $mode = $payment_settings->live_mode ;
              if($mode == 0){
                  $secret_key = $payment_settings->test_secret_key ;
                  $publishable_key = $payment_settings->test_publishable_key ;
              }elseif($mode == 1){
                  $secret_key = $payment_settings->live_secret_key ;
                  $publishable_key = $payment_settings->live_publishable_key ;
              }else{
                  $secret_key= null;
                  $publishable_key= null;
              }    
         if($series->ppv_status != 1 || $ppv_exits > 0){

            $data = array(
             'currency' => $currency,
             'ppv_exits' => $ppv_exits,
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
                'series_categories' => Genre::all(),
                'pages' => Page::where('active', '=', 1)->get(),
                );
            return View::make('episode', $data);
            }else{
                return Redirect::to('/tv-shows')->with(array('message' => 'Sorry, To Watch series You have to purchase.', 'note_type' => 'error'));

            }
        } else {
            return Redirect::to('series-list')->with(array('note' => 'Sorry, this series is no longer active.', 'note_type' => 'error'));
        }
   }
    

     public function handleViewCount($id){
     	 if(Auth::guest()):
            return Redirect::to('/login');
        endif;
        // check if this key already exists in the view_media session
        $blank_array = array();
        if (! array_key_exists($id, Session::get('viewed_video', $blank_array) ) ) {
            
            try{
                // increment view
                $video = Episode::find($id);
                $video->views = $video->views + 1;
                $video->save();
                // Add key to the view_media session
                Session::put('viewed_video.'.$id, time());
                return true;
            } catch (Exception $e){
                return false;
            }
        } else {
            return false;
        }
     }

     public function play_series($name)
    {
    
    	$settings = Setting::first();
        if(Auth::guest()):
            return Redirect::to('/login');
        endif;
  
        
        $series = Series::where('title','=',$name)->first();    
        
        $id = $series->id;


        if(($series->ppv_status == 1)){
            $ppv_exits = PpvPurchase::where('user_id', '=', Auth::user()->id)->where('series_id', '=', $id)->count();
        // dd($ppv_exits);

        }else{
            $ppv_exits = 0 ;
        }
       
        // $series = Series::findOrFail($id);
        $season = SeriesSeason::where('series_id','=',$id)->with('episodes')->get();
        $episodefirst = Episode::where('series_id', '=', $id)->orderBy('id', 'ASC')->first();
        //Make sure series is active
        if((!Auth::guest() && Auth::user()->role == 'admin') || $series->active){

            $view_increment = 5;
    $currency = CurrencySetting::first();
    $payment_settings = PaymentSetting::first();  
    $mode = $payment_settings->live_mode ;
      if($mode == 0){
          $secret_key = $payment_settings->test_secret_key ;
          $publishable_key = $payment_settings->test_publishable_key ;
      }elseif($mode == 1){
          $secret_key = $payment_settings->live_secret_key ;
          $publishable_key = $payment_settings->live_publishable_key ;
      }else{
          $secret_key= null;
          $publishable_key= null;
      }    
            $data = array(
                'series' => $series,
                'currency' => $currency,
                'ppv_exits' => $ppv_exits,
                'season' => $season,
                'publishable_key' => $publishable_key,
                'settings' => $settings,
                'episodenext' => $episodefirst,
                'url' => "episodes",
                'menu' => Menu::orderBy('order', 'ASC')->get(),
                'view_increment' => $view_increment,
                'series_categories' => Genre::all(),
                'pages' => Page::where('active', '=', 1)->get(),
                );
            return View::make('series', $data);

        } else {
            return Redirect::to('series')->with(array('note' => 'Sorry, this series is no longer active.', 'note_type' => 'error'));
        }
    }

    public function PlayEpisode($episode_name)//
    {
         
        $settings = Setting::first();
        if(Auth::guest()):
             return Redirect::to('/login');
         endif;
         $episode = Episode::where('title','=',$episode_name)->first();    
         $id = $episode->id;
         // $episode = Episode::findOrFail($id);
         $season = SeriesSeason::where('series_id','=',$episode->series_id)->with('episodes')->get();
         $series = Series::find($episode->series_id);
        //  if(){}
         //$episoderesolutions = Episode::findOrFail($id)->episoderesolutions;
         $episodenext = Episode::where('id', '>', $id)->where('series_id','=',$episode->series_id)->first();
         $episodeprev = Episode::where('id', '<', $id)->where('series_id','=',$episode->series_id)->first();
         //Make sure series is active
         
         $wishlisted = false;
         if(!Auth::guest()):
                 $wishlisted = Wishlist::where('user_id', '=', Auth::user()->id)->where('episode_id', '=', $id)->first();
         endif;
         
         
         
         $watchlater = false;
         
          if(!Auth::guest()):
                 $watchlater = Watchlater::where('user_id', '=', Auth::user()->id)->where('episode_id', '=', $id)->first();
          endif;
          if(($series->ppv_status == 1)){
            $ppv_exits = PpvPurchase::where('user_id', '=', Auth::user()->id)->where('series_id', '=', $series->id)->count();
        // dd($ppv_exits);

        }else{
            $ppv_exits = 0 ;
        }
       
         if((!Auth::guest() && Auth::user()->role == 'admin') || $series->active){
 
            if($series->ppv_status != 1 || $ppv_exits > 0){
 
 
             $view_increment = $this->handleViewCount($id);
 
             $playerui = Playerui::first();
             $data = array(
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
                 'series_categories' => Genre::all(),
                 'pages' => Page::where('active', '=', 1)->get(),
                 );
             return View::make('episode', $data);
                }else{
                    // return Redirect::to('/login');
                    return Redirect::to('/tv-shows')->with(array('message' => 'Sorry, To Watch series You have to purchase.', 'note_type' => 'error'));

                }
         }
          else {
             return Redirect::to('series-list')->with(array('note' => 'Sorry, this series is no longer active.', 'note_type' => 'error'));
         }
    }
}

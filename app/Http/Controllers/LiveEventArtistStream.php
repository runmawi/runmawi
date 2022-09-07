<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Video;
use App\CurrencySetting;
use App\ThumbnailSetting;
use App\Setting;
use App\HomeSetting;
use App\LiveEventArtist;
use App\LivePurchase;
use App\Wishlist;
use App\Watchlater;
use App\PaymentSetting;
use App\RecentView;
use Carbon\Carbon;
use App\LiveStream;
use App\LiveEventPaymentDetails;
use Theme;
use URL;
use Auth;
use View;
use Hash;
use DB;
use Session;
use Cartalyst\Stripe\Stripe;
use Laravel\Cashier\Cashier;

class LiveEventArtistStream extends Controller
{

    public function __construct()
    {
        $settings = Setting::first();
        $this->videos_per_page = $settings->videos_per_page;

        $this->Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses($this->Theme);

        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
        $userIp = $geoip->getip();    
        $countryName = $geoip->getCountry();
        $regionName = $geoip->getregion();
        $cityName = $geoip->getcity();
  
        $this->countryName = $countryName;
    }

    public function index()
    {

        $artist_live_event = LiveEventArtist::where("active","=","1")
                ->orderBy('created_at', 'DESC')
                ->get();

        $PPV_settings = Setting::where('ppv_status', '=', 1)->first();

        $ppv_gobal_price = !empty($PPV_settings) ? $PPV_settings->ppv_price :  null ;
        
        $data = array(
            'artist_live_event' => $artist_live_event,
            'ppv_gobal_price' => $ppv_gobal_price,
            'currency' =>CurrencySetting::first(),
            'ThumbnailSetting' => ThumbnailSetting::first(),
        );

        return Theme::view('live_artist_event.index',['artist_live_event'=>$data]);
    }

    public function live_event_play(Request $request,$slug)
    {
        $data = session()->all();
        $session = Session::all();

        $live_event_artist = LiveEventArtist::where('slug',$slug)->first();

        $vid =  $live_event_artist->id;

        if(!empty($data['password_hash'])){
            $user_id = Auth::user()->id;
        }

        $settings = Setting::first(); 

        $ppv_exist = !empty($data['password_hash']) ? LivePurchase::where('video_id',$vid)->where('user_id',$user_id)->count() : [];
      
        $wishlisted = false;

        if(!Auth::guest()):
            $wishlisted = Wishlist::where('user_id', '=', Auth::user()->id)->where('video_id', '=', $vid)->where('type', '=', 'live')->first();
        endif;

        $watchlater = false;

        if(!Auth::guest()):
            $watchlater = Watchlater::where('user_id', '=', Auth::user()->id)->where('video_id', '=', $vid)->where('type', '=', 'live')->first();
        endif;

        $password_hash = !empty($session['password_hash']) ? $session['password_hash'] : "" ;

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

        if(!empty($live_event_artist->publish_time)){
            $new_date = Carbon::parse($live_event_artist->publish_time)->format('M d , y H:i:s');
            $currentdate = date("M d , y H:i:s");
            $new_date = $currentdate < $new_date ?  Carbon::parse($live_event_artist->publish_time)->format('M d , y h:i:s') : null;
        }
        else{
            $new_date = null;
        }

        $payment_setting = PaymentSetting::where('status',1)->where('live_mode',1)->get();
        $Razorpay_payment_setting = PaymentSetting::where('status',1)->first();

        $view = new RecentView;
        $view->user_id      = Auth::User() ? Auth::User()->id : null ;
        $view->country_name = $this->countryName ? $this->countryName : null ;
        $view->sub_user     = null ;
        $view->visited_at   = Carbon::now()->year;
        $view->live_event_artist_id = $vid ;
        $view->save();

         $data = array(
               'currency'    => CurrencySetting::first(),
               'video'       => $live_event_artist,
               'password_hash' => $password_hash,
               'publishable_key' => $publishable_key,
               'ppv_exist' => $ppv_exist,
               'ppv_price' => $live_event_artist->ppv_price,
               'watchlatered' => $watchlater,
               'mywishlisted' => $wishlisted,
               'new_date' => $new_date,
               'payment_setting' => $payment_setting,
               'Razorpay_payment_setting' => $Razorpay_payment_setting,
               'Related_videos' => LiveEventArtist::whereNotIn('id',[$vid])->inRandomOrder()->get(),
         );

         return Theme::view('live_artist_event.live_event_videos', $data);
    }

    
    public function live_event_tips(Request $request)
    {

        $data = [
            'publish_key' => env('STRIPE_KEY'),
            'amount'      => $request->live_event_amount ,
            'live_event_video_slug' => $request->live_event_video_slug ,
        ];
        return Theme::view('live_artist_event.live_event_stripe',$data);
    }

    public function stripePaymentTips(Request $request)
    {

        $secret_key = env('STRIPE_SECRET');

        $stripe = Stripe::make($secret_key, '2020-03-02');

        try {
            $charge = $stripe->charges()->create([
                'source' => $request->get('tokenId'),
                'currency' => 'USD',
                'amount' => $request->get('amount')
            ]);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Oops!! Payment issues']);
        }

       try {
         LiveEventPaymentDetails::create([
            'payment_mode'  => "Stripe",
            'user_id'       => Auth::user() ? Auth::user()->id : "guest",
            'charge_id'     => $charge['id'],
            'amount_tip'    => $charge['amount'] / 100,
            'currency_type' => $charge['currency'],
            'pay_type'      => $charge['payment_method_details']['type'],
            'name'          => $charge['billing_details']['name'],
            'email'         => $charge['billing_details']['email'],
            'last_card_no'  => $charge['payment_method_details']['card']['last4'],
            'card_band'     => $charge['payment_method_details']['card']['brand'],
            'card_type'     => $charge['payment_method_details']['card']['funding'],
        ]);

            return response()->json(['message' => 'Payment Done Successfully']);

       } catch (\Throwable $th) {

            return response()->json(['message' => 'Issues In updating Data ! Please contact Admin']);
       }
  
    }

    public function rent_live_artist_event(Request $request)
    {

        $daten = date('m-d-Y h:i:s ', time());    
        $setting = Setting::first();   
        $ppv_hours = $setting->ppv_hours;
        $d = new \DateTime('now');
        $d->setTimezone(new \DateTimeZone('Asia/Kolkata'));
        $now = $d->format('Y-m-d h:i:s a');
        $time = date('h:i:s', strtotime($now));
        $to_time = date('Y-m-d H:i:s',strtotime('+'.$ppv_hours.' hour',strtotime($now))); 
        $user_id = Auth::user()->id;
        $video_id = $request->get('video_id');
        $date = date('YYYY-MM-DD');
    
    
        $video = LiveEventArtist::where('id','=',$video_id)->first();
        if(!empty($video)){
            $moderators_id = $video->user_id;
        }
        
        if(!empty($moderators_id)){
            $moderator = ModeratorsUser::where('id','=',$moderators_id)->first();  
            $total_amount = $video->ppv_price;
            $title =  $video->title;
            $commssion = VideoCommission::first();
            $percentage = $commssion->percentage; 
            $ppv_price = $video->ppv_price;
            $admin_commssion = ($percentage/100) * $ppv_price ;
            $moderator_commssion = $ppv_price - $percentage;
            $moderator_id = $moderators_id;
        }else{
            $total_amount = $video->ppv_price;
            $title =  $video->title;
            $commssion = VideoCommission::first();
            $percentage = null; 
            $ppv_price = $video->ppv_price;
            $admin_commssion =  null;
            $moderator_commssion = null;
            $moderator_id = null;
        }

        $secret_key = env('STRIPE_SECRET');
        
            $stripe = Stripe::make($secret_key, '2020-03-02');

            $charge = $stripe->charges()->create([
            'source' => $request->get('tokenId'),
            'currency' => 'USD',
            'amount' => $request->get('amount')
            ]);
    
        $purchase = new PpvPurchase;
        $purchase->user_id = $user_id;
        $purchase->live_event_artist_id = $video_id;
        $purchase->to_time = $to_time;
        $purchase->expired_date = $to_time;
        $purchase->total_amount = $total_amount;
        $purchase->admin_commssion = $admin_commssion;
        $purchase->moderator_commssion = $moderator_commssion;
        $purchase->status = 'active';
        $purchase->to_time = $to_time;
        $purchase->moderator_id = $moderator_id;
        $purchase->save();
    
        $livepurchase = new LivePurchase;
        $livepurchase->user_id = $user_id;
        $livepurchase->live_event_artist_id = $video_id;
        $livepurchase->to_time = $to_time;
        $livepurchase->expired_date = $to_time;
        $livepurchase->amount = $request->get('amount');
        $livepurchase->status = 1;
        $livepurchase->save();
        
        return 1;
    }
}

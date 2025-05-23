<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AdminUserChannelSubscriptionPlans;
use App\HomeSetting;
use App\ModeratorsUser;
use App\PaymentSetting;
use App\CurrencySetting;
use App\SiteTheme;
use App\Channel;
use App\Video;
use App\LiveStream;
use App\Episode;
use App\VideoCategory;
use App\OrderHomeSetting;
use App\UserChannelSubscription;
use App\Setting;
use App\Series;
use App\Geofencing;
use URL;
use Theme;
use Razorpay\Api\Api;
use Carbon\Carbon;
use Auth;

class ChannelPartnerController extends Controller
{

    protected $settings;
    public function __construct()
    {
        $this->HomeSetting = HomeSetting::first();
        Theme::uses($this->HomeSetting->theme_choosen);
        $this->settings = Setting::first();
    }

    public function channelparnter(Request $request)
    {
        $channel_partner = array(
            'channel_partner_list' => ModeratorsUser::where('status',1)->get() ,
        );
       return Theme::view('ChannelPartner.Channelpartners',$channel_partner);
    }

    public function unique_channelparnter( Request $request,$username )
    {
        try {

            $content_partner_id = ModeratorsUser::where('username',$username)->pluck('id')->first();

            $content_partner = array(
                'ModeratorUsers_list' => ModeratorsUser::where('status',1)->where('id',$content_partner_id)->get() ,
            );

            return Theme::view('ContentPartner.content_partners',$content_partner);

        } catch (\Throwable $th) {

            return abort(404);
        }
    }

    public function all_Channel_home(Request $request)
    {
        try {
         
            $currency = CurrencySetting::first();
            $FrontEndQueryController = new FrontEndQueryController();

            $settings = $this->settings;

            $all_channels = Channel::where('status', 1)->get();

            $channel_data = $all_channels->map(function ($item) use ($FrontEndQueryController) {

                $channel_partner = $item->id;
                $channel_partner_name = $item->channel_name;

                $videos = $FrontEndQueryController->latest_videos()->filter(function ($videos)  use ($channel_partner,$channel_partner_name) {
                    if ( $videos->user_id == $channel_partner && $videos->uploaded_by == "Channel" ) {
                        $videos['channel_partner_name'] = $channel_partner_name;
                        $videos['source_model'] = 'App\Video'; 
                        return $videos;
                    }
                });

                $livestream = $FrontEndQueryController->livestreams()->filter(function ($livestream)  use ($channel_partner,$channel_partner_name) {
                    if ( $livestream->user_id == $channel_partner && $livestream->uploaded_by == "Channel" ) {
                        $livestream['channel_partner_name'] = $channel_partner_name;
                        $livestream['source_model'] = 'App\livestream'; 
                        return $livestream  ;
                    }
                });

                $episode = $FrontEndQueryController->latest_episodes()->filter(function ($episode)  use ($channel_partner,$channel_partner_name) {
                    if ( $episode->user_id == $channel_partner && $episode->uploaded_by == "Channel" ) {
                        $episode['channel_partner_name'] = $channel_partner_name;
                        $episode['source_model' ]= 'App\Episode'; 
                        return $episode;
                    }
                });

                $latest_series = $FrontEndQueryController->latest_Series()->filter(function ($latest_Series)  use ($channel_partner,$channel_partner_name) {
                    if ( $latest_Series->user_id == $channel_partner && $latest_Series->uploaded_by == "Channel" ) {
                        $latest_Series['channel_partner_name'] = $channel_partner_name;
                        $latest_Series['source_model'] = 'App\Series'; 
                        return $latest_Series;
                    }
                });


                $all_data = $videos->concat($livestream)->concat($episode)->concat($latest_series);
                $all_data = $all_data->take(15);

                $item->all_data = $all_data;

                return $item;

            });

            // Sliders

            $channel_slider = Channel::where('status', 1)->get()->map(function ($item) use ($FrontEndQueryController,$settings) {

                $channel_partner = $item->id;

                $default_vertical_image_url = default_vertical_image_url() ;
                $default_horizontal_image_url = default_horizontal_image_url() ;

                $video_banners = $FrontEndQueryController->video_banners()->filter(function ($video_banners)  use ($channel_partner,$default_vertical_image_url,$default_horizontal_image_url,$settings) {
                    if ( $video_banners->user_id == $channel_partner && $video_banners->uploaded_by == 'Channel' ) {



                        $video_banners['source_name']        = $video_banners->title;
                        $video_banners['source_description'] = $video_banners->description;
                        $video_banners['source_image_url']          =  $video_banners->image != null ?  URL::to('/public/uploads/images/'.$video_banners->image) : $default_vertical_image_url ;
                        $video_banners['source_Player_image_url']   =  $video_banners->player_image != null ?  URL::to('public/uploads/images/'.$video_banners->player_image) : $default_horizontal_image_url ;  

                        $video_banners['source_redirection_url']  =  URL::to('category/videos/'.$video_banners->slug)  ;  
                        $video_banners['source_button_name']  =  'Play Now';  

                        return $video_banners;
                    }
                });

                $live_banners = $FrontEndQueryController->live_banners()->filter(function ($live_banners)  use ($channel_partner,$default_vertical_image_url,$default_horizontal_image_url,$settings) {
                    if ( $live_banners->user_id == $channel_partner && $live_banners->uploaded_by == 'Channel' ) {

                        $live_banners['source_name']        = $live_banners->title;
                        $live_banners['source_description'] = $live_banners->description;
                        $live_banners['source_image_url']          =  $live_banners->image != null ?  URL::to('/public/uploads/images/'.$live_banners->image) : $default_vertical_image_url ;
                        $live_banners['source_Player_image_url']   =  $live_banners->player_image != null ?  URL::to('public/uploads/images/'.$live_banners->player_image) :  $default_horizontal_image_url ;
                        
                        $live_banners['source_redirection_url']  = URL::to('live/'.$live_banners->slug) ;  
                        $live_banners['source_button_name']  =  'Play Now';  

                        return $live_banners;
                    }
                });

                $series_sliders = $FrontEndQueryController->series_sliders()->filter(function ($series_sliders)  use ($channel_partner,$default_vertical_image_url,$default_horizontal_image_url,$settings) {
                    if ( $series_sliders->user_id == $channel_partner && $series_sliders->uploaded_by == 'Channel' ) {

                        $series_sliders['source_name']        = $series_sliders->title;
                        $series_sliders['source_description'] = $series_sliders->description;
                        $series_sliders['source_image_url']          =  $series_sliders->image != null ?  URL::to('/public/uploads/images/'.$series_sliders->image) :  $default_vertical_image_url ;
                        $series_sliders['source_Player_image_url']   =  $series_sliders->player_image != null ?  URL::to('public/uploads/images/'.$series_sliders->player_image) :  $default_horizontal_image_url ;

                        $series_sliders['source_redirection_url']  =  URL::to('play_series/'.$series_sliders->slug);  
                        $series_sliders['source_button_name']  =  'Play Now';  

                        return $series_sliders;
                    }
                });

                $Episode_sliders = $FrontEndQueryController->Episode_sliders()->filter(function ($Episode_sliders)  use ($channel_partner,$default_vertical_image_url,$default_horizontal_image_url,$settings) {
                    if ( $Episode_sliders->user_id == $channel_partner && $Episode_sliders->uploaded_by == 'Channel' ) {

                        $Episode_sliders['source_name']        = $Episode_sliders->title;
                        $Episode_sliders['source_description'] = $Episode_sliders->description;
                        $Episode_sliders['source_image_url']          =  $Episode_sliders->image != null ?  URL::to('/public/uploads/images/'.$Episode_sliders->image) :  $default_vertical_image_url ;
                        $Episode_sliders['source_Player_image_url']   =  $Episode_sliders->player_image != null ?  URL::to('public/uploads/images/'.$Episode_sliders->player_image) :  $default_horizontal_image_url ;
                        $series_slug = $Episode_sliders->series->slug;

                        $Episode_sliders['source_redirection_url']  =  URL::to("episode/{$series_slug}/{$Episode_sliders->slug}");  
                        $Episode_sliders['source_button_name']  =  'Play Now';  

                        return $Episode_sliders;
                    }
                });

                $all_data = $video_banners->merge($live_banners)->merge($Episode_sliders)->merge($series_sliders);
                $item->all_data = $all_data->take(15);

                return $item;
            });

            $data = array(
                'settings' => $this->settings,
                'current_theme' => $this->HomeSetting->theme_choosen,
                'all_channels'     => $all_channels,
                'channel_data'     => $channel_data,
                'channel_slider'   => $channel_slider,
                'ThumbnailSetting'      => $FrontEndQueryController->ThumbnailSetting() ,
                'multiple_compress_image'  => $FrontEndQueryController->multiple_compress_image() , 
                'videos_expiry_date_status'     => videos_expiry_date_status(),
                'default_vertical_image_url'    => default_vertical_image_url(),
                'default_horizontal_image_url'  => default_horizontal_image_url(),
                'home_settings' => $this->HomeSetting,
                'getfeching'    => Geofencing::first(),
                'current_theme' => $this->HomeSetting->theme_choosen,
            );
            
            return Theme::view('ChannelHomeList', $data);

        } catch (\Throwable $th) {
            // return $th->getMessage();
            return abort(404);
        }
    }

    public function channelparnterpayment(Request $request, $channel_id)
    {
        try {

            if ( Auth::guest() || Auth::user()->role == "admin") {
                session()->flash('error', 'Prohibited');
                return redirect()->route('channel.all_Channel_home');
            }

            $SiteTheme = SiteTheme::first();

            $Stripe_payment_settings = PaymentSetting::where('payment_type', 'Stripe')->where('stripe_status',1)->first();
            $recurly_payment_settings = PaymentSetting::where('payment_type','Recurly')->where('recurly_status',1)->first();
    
            $plans_data = [];
    
            $CurrencySetting = CurrencySetting::pluck('enable_multi_currency')->first();
    
            $data = array(
                'current_theme'  => $this->HomeSetting->theme_choosen,
                'Stripe_payment_settings'  => $Stripe_payment_settings ,
                'recurly_payment_settings' => $recurly_payment_settings,
                'plans_data' => $plans_data ,
                'SiteTheme'  => $SiteTheme ,
                'channel_id' => $channel_id,
            );
    
            return Theme::view('ChannelPartner.payment.payment-page',$data);

        } catch (\Throwable $th) {
            // return $th->getMessage();
            return abort(404);
        }
    }

    public function payment_gateway_depends_plans( Request $request)
    {
      try {

        $plans_data = AdminUserChannelSubscriptionPlans::where('status', 1)
        ->where('paymentGateway', $request->payment_gateway)
        ->whereJsonContains('channel_id', $request->channel_id)
        ->get();

        $response = array(
          'status'     => true ,
          'message'    => "Plans data for $request->payment_gateway retrieved Successfully  !" , 
          'plans_data' => $plans_data , 
        );

      } catch (\Throwable $th) {
        
          $response = array(
              "status"  => false ,
              "message" => $th->getMessage() , 
          );
      }

      return response()->json(['data' => $response]);
    }
}
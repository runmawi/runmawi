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
use App\Setting;
use App\Geofencing;
use URL;
use Theme;

class ChannelPartnerController extends Controller
{

    protected $settings;
    public function __construct()
    {
        $this->HomeSetting = HomeSetting::first();
        Theme::uses($this->HomeSetting->theme_choosen);
        $this->settings = Setting::first();$this->settings = Setting::first();$this->settings = Setting::first();
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
        $currency = CurrencySetting::first();
        $FrontEndQueryController = new FrontEndQueryController();

        $channel = Channel::where('status', 1)->get()->map(function ($item) {
            $videos = Video::select('id', 'title', 'slug', 'year', 'rating', 'access', 'publish_type', 'global_ppv', 'publish_time', 'ppv_price', 'duration', 'rating', 'image', 'featured', 'age_restrict', 'video_tv_image', 'description', 'player_image', 'expiry_date', 'responsive_image', 'responsive_player_image', 'responsive_tv_image', 'user_id', 'uploaded_by')
                        ->where('active', 1)->where('status', 1)->where('draft', 1)
                        ->where('uploaded_by', 'Channel')->where('user_id', $item->id)->get();
            $livestream = LiveStream::select('id', 'title', 'slug', 'year', 'rating', 'access', 'publish_type', 'publish_time', 'publish_status', 'ppv_price','duration', 'rating', 'image', 'featured', 'Tv_live_image', 'player_image', 'details', 'description', 'free_duration',
                                 'recurring_program', 'program_start_time', 'program_end_time', 'custom_start_program_time', 'custom_end_program_time','recurring_timezone', 'recurring_program_week_day', 'recurring_program_month_day')
                            ->where('active', 1)->where('status', 1)->where('uploaded_by', 'Channel')->where('user_id', $item->id)->get();
            $episode = Episode::select('id','title','slug','rating','access','series_id','season_id','ppv_price','responsive_image','responsive_player_image','responsive_tv_image','duration','rating','image','featured','tv_image','player_image')
                            ->where('active', '1')->where('status', 1)->where('uploaded_by', 'Channel')->where('user_id', $item->id)->get();

            $all_data = $videos->merge($livestream)->merge($episode);
            $all_data = $all_data->take(15);

            $item->all_data = $all_data;
            return $item;
        });

        $home_settings_on_value = collect($this->HomeSetting)->filter(function ($value) {
            return $value === '1' || $value === 1;
        })->keys()->toArray();

        $order_settings = OrderHomeSetting::select('video_name')->whereIn('video_name', $home_settings_on_value)->orderBy('order_id', 'asc')->get();

        $data = array(
            'settings' => $this->settings,
            'current_theme' => $this->HomeSetting->theme_choosen,
            'channel' => $channel,

            'order_settings' => $order_settings,
            'order_settings_list' => OrderHomeSetting::get(),
            'ThumbnailSetting'      => $FrontEndQueryController->ThumbnailSetting() ,
            'multiple_compress_image'  => $FrontEndQueryController->multiple_compress_image() , 
            'videos_expiry_date_status'     => videos_expiry_date_status(),
            'default_vertical_image_url'    => default_vertical_image_url(),
            'default_horizontal_image_url'  => default_horizontal_image_url(),
            'home_settings' => $this->HomeSetting,
            'getfeching' => Geofencing::first(),
        );
        // dd($data);
        
        return Theme::view('ChannelHomeList', $data);
    }

    public function channelparnterpayment(Request $request)
    {

        $SiteTheme = SiteTheme::first();

        $Stripe_payment_settings = PaymentSetting::where('payment_type', 'Stripe')->where('stripe_status',1)->first();
        $recurly_payment_settings = PaymentSetting::where('payment_type','Recurly')->where('recurly_status',1)->first();

        $plans_data = AdminUserChannelSubscriptionPlans::where('paymentGateway','Stripe')->where('status',1)->get();

        $CurrencySetting = CurrencySetting::pluck('enable_multi_currency')->first();

        $data = array(
            'current_theme'  => $this->HomeSetting->theme_choosen,
            'Stripe_payment_settings'  => $Stripe_payment_settings ,
            'recurly_payment_settings' => $recurly_payment_settings,
            'plans_data' => $plans_data ,
            'SiteTheme'  => $SiteTheme ,
        );

        return Theme::view('ChannelPartner.payment.payment-page',$data);
    }

    public function payment_gateway_depends_plans( Request $request)
    {
      try {

        $plans_data = AdminUserChannelSubscriptionPlans::where('paymentGateway',$request->payment_gateway)
                        ->where('status',1)->get()
                        ->map(function ($item){
                            $item['plan_content'] = $item->plan_content != null ? $item->plan_content : "Plan Description";
                            return $item;
                        });

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

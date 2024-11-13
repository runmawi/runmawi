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
        
            $item->videos = $videos;
            return $item;
        });

        $data = array(
            'channel' => $channel
        );
        // dd($data);
        
        // return Theme::view('ChannelHomeList', $data);
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

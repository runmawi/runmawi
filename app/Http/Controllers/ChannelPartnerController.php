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
use Theme;

class ChannelPartnerController extends Controller
{
    public function __construct()
    {
        $this->HomeSetting = HomeSetting::first();
        Theme::uses($this->HomeSetting->theme_choosen);
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
        # code...
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

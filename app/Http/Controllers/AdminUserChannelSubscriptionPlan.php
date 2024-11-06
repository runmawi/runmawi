<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AdminUserChannelSubscriptionPlans;
use App\PaymentSetting;
use App\Setting;
use App\Channel;
use \Redirect;
use Auth;


class AdminUserChannelSubscriptionPlan extends Controller
{
    public function index(Request $request)
    {
        try {
         
            $data = [
                'Channel' => Channel::where('status',1)->get(),
                'Channel_Subscription_Plans' => AdminUserChannelSubscriptionPlans::groupBY('plan_name')->paginate(9),
                'payment_settings' => PaymentSetting::where('status', 1)->get(),
                'setting' => setting::first(),
            ];

            return view('admin.Channel.User_Channel_Subscription_Plan.index', $data);

        } catch (\Throwable $th) {

            return abort(404);
        }
    }

    public function store(Request $request)
    {

        if (!empty($request->plan_id)) {
            
            foreach ($request->plan_id as $key => $plan_id) {

                $inputs = array(
                    'user_id'   => Auth::user()->id,
                    'plan_name' => $request->plan_name,
                    'plan_id'   => $plan_id,
                    'plan_content'     => $request->plan_content,
                    'billing_interval' => $request->billing_interval,
                    'billing_type'     => $request->billing_type,
                    'payment_type'     => 'Recurring',
                    'paymentGateway'   => $request->paymentGateway[$key], 
                    'days'             => $request->days,
                    'price'            => $request->price,
                    'status'           => empty($request->status) ? 0 : 1,
                    'ios_product_id'   => $request->ios_product_id,
                    'ios_plan_price'   => $request->ios_plan_price,
                    'channel_id'       => !empty($request->channel_id) ? json_encode($request->channel_id) : [] ,
                );

                AdminUserChannelSubscriptionPlans::create($inputs);
            }
        }
    
        return response()->json(['success' => true]);
        
    }

    public function edit($id)
    {
        $plan = AdminUserChannelSubscriptionPlans::find($id);
        $plan->channel_id = json_decode($plan->channel_id); 
    
        return response()->json([
            'data' => $plan,
        ]);
    

    }

    public function update(Request $request)
    {
        $inputs = array(
            'plan_name' => $request->plan_name,
            'plan_id'   => $request->plan_id,
            'plan_content'     => $request->plan_content,
            'billing_interval' => $request->billing_interval,
            'billing_type'     => $request->billing_type,
            'payment_type'     => 'Recurring',
            'paymentGateway'   => $request->paymentGateway,
            'days'             => $request->days,
            'price'            => $request->price,
            'status'           => empty($request->status) ? 0 : 1,
            'ios_product_id'   => $request->ios_product_id,
            'ios_plan_price'   => $request->ios_plan_price,
            'channel_id'       => !empty($request->channel_id) ? json_encode($request->channel_id) : [] ,
        );

        $Adsplan = AdminUserChannelSubscriptionPlans::find($request->id)->update( $inputs );

        return response()->json(['success' => true]);
    }

    public function delete($id)
    {
        try {

            AdminUserChannelSubscriptionPlans::find($id)->delete();
            return Redirect::back();

        } catch (\Throwable $th) {

            return abort(404);
        }
    }

    public function user_channel_plans_page_status(Request $request)
    {
        try {

            Setting::first()->update([
                "user_channel_plans_page_status" => $request->user_channel_plans_page_status,
            ]);

            return response()->json(["message" => "true"]);

        } catch (\Throwable $th) {

            return response()->json(["message" => "false"]);

        }
    }
}
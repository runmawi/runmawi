<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AdminUserChannelSubscriptionPlans;
use \Redirect;
use Auth;


class AdminUserChannelSubscriptionPlan extends Controller
{
    public function index(Request $request)
    {
        try {
         
            $data = [
                'Channel_Subscription_Plans' => AdminUserChannelSubscriptionPlans::paginate(9),
            ];

            return view('admin.Channel.User_Channel_Subscription_Plan.index', $data);

        } catch (\Throwable $th) {
            
            return abort(404);
        }
    }

    public function store(Request $request)
    {
        $inputs = array(
            'user_id'   => Auth::user()->id,
            'plan_name' => $request->plan_name,
            'plan_id'   => $request->plan_id,
            'plan_content'     => $request->plan_content,
            'billing_interval' => $request->billing_interval,
            'billing_type'     => $request->billing_type,
            'payment_type'     => $request->payment_type,
            'paymentGateway'   => $request->paymentGateway,
            'days'             => $request->days,
            'price'            => $request->price,
            'status'           => empty($request->status) ? 0 : 1,
            'ios_product_id'   => $request->ios_product_id,
            'ios_plan_price'   => $request->ios_plan_price,
        );

        AdminUserChannelSubscriptionPlans::create($inputs);
      
        return response()->json(['success' => true]);
        
    }

    public function edit($id)
    {
        return response()->json([
            'data' => AdminUserChannelSubscriptionPlans::find($id),
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
            'payment_type'     => $request->payment_type,
            'paymentGateway'   => $request->paymentGateway,
            'days'             => $request->days,
            'price'            => $request->price,
            'status'           => empty($request->status) ? 0 : 1,
            'ios_product_id'   => $request->ios_product_id,
            'ios_plan_price'   => $request->ios_plan_price,
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
}
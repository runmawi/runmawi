<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\User ;
use \Redirect ;
use URL;
use Auth;
use Hash;
use App\Video ;
use App\Plan ;
use App\VideoCategory ;
use App\VideoResolution ;
use App\VideosSubtitle ;
use App\Language ;
use App\Subtitle ;
use App\PaypalPlan ;
use App\Tag ;
use Illuminate\Support\Facades\Cache;
use Image;
use View;
use Response;
use App\PaylPlan;
use App\Devices;
use App\Setting;
use App\PaymentSetting  ;
use App\ModeratorSubscriptionPlan;
use GuzzleHttp\Client;
use App\Currency;
use App\CurrencySetting;

class AdminCPPPlansController extends Controller
{

    public function subscriptionindex()
    {
        if ((!Auth::guest() && Auth::user()->package == 'Channel') || Auth::user()->package == 'CPP') {
            return redirect('/admin/restrict');
        }

        $user = User::where('id', 1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');

        if ($current_date > $duedate) {
            $client = new Client();
            $url = 'https://flicknexs.com/userapi/allplans';
            $params = ['userid' => 0];

            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ',
            ];
            $response = $client->request('post', $url, [
                'json'    => $params,
                'headers' => $headers,
                'verify'  => false,
            ]);

            $responseBody = json_decode($response->getBody());
            $settings = Setting::first();

            $data = [
                'settings' => $settings,
                'responseBody' => $responseBody,
            ];

            return View::make('admin.expired_dashboard', $data);
        
        } elseif (check_storage_exist() == 0) {
            $settings = Setting::first();

            $data = [
                'settings' => $settings,
            ];

            return View::make('admin.expired_storage', $data);
        
        } else {
            $slug = Str::slug('Laravel 5 Framework', '-');

            $plans_data = ModeratorSubscriptionPlan::all();
            $plans = $plans_data->groupBy('plans_name');
            $payment_settings = PaymentSetting::where('status', 1)->get();
            $currency    = Currency::get();
            $allCurrency = CurrencySetting::first();

            $paystack_status = PaymentSetting::where('payment_type', 'Paystack')
                ->where('status', 1)
                ->where('paystack_status', 1)
                ->first();

            $devices = Devices::all();

            $data = [
                'plans' => $plans,
                'allplans' => $plans,
                'devices'  => $devices,
                'payment_settings' => $payment_settings,
                'allCurrency' => $allCurrency,
                'paystack_status' => $paystack_status,
                'setting'  => Setting::first() ,
            ];

            return view('admin.moderator_subscription_plans.index', $data);
        }
    }


    public function subscriptionedit($id)
    {
        if ((!Auth::guest() && Auth::user()->package == 'Channel') || Auth::user()->package == 'CPP') {
            return redirect('/admin/restrict');
        }

        $user = User::where('id', 1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');

        if ($current_date > $duedate) {

            $client = new Client();
            $url = 'https://flicknexs.com/userapi/allplans';
            $params = [
                'userid' => 0,
            ];

            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ',
            ];
            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify' => false,
            ]);

            $responseBody = json_decode($response->getBody());
            $settings = Setting::first();
            $data = [
                'settings' => $settings,
                'responseBody' => $responseBody,
            ];
            return View::make('admin.expired_dashboard', $data);
        
        } elseif (check_storage_exist() == 0) {
            $settings = Setting::first();

            $data = [
                'settings' => $settings,
            ];

            return View::make('admin.expired_storage', $data);
        
        } else {
            // $edit_plan = ModeratorSubscriptionPlan::find($id);
            $edit_plan = ModeratorSubscriptionPlan::where('id', $id)->get();
            if (!empty($edit_plan[0]->plans_name)) {
                $edit_plan = ModeratorSubscriptionPlan::where('plans_name', $edit_plan[0]->plans_name)->get();
            }
            $payment_settings = PaymentSetting::all();
            if (!empty($edit_plan[0]->devices)) {
                $permission = $edit_plan[0]['devices'];
                $user_devices = explode(',', $permission);
            } else {
                $user_devices = [];
            }


            $paystack_status = PaymentSetting::where('payment_type', 'Paystack')
                ->where('status', 1)
                ->where('paystack_status', 1)
                ->first();

            $devices = Devices::all();
            $currency = Currency::get();
            $allCurrency = CurrencySetting::first();
            $data = [
                'edit_plan' => $edit_plan,
                'user_devices' => $user_devices,
                'devices' => $devices,
                'payment_settings' => $payment_settings,
                'allCurrency' => $allCurrency,
                'paystack_status' => $paystack_status,
            ];
            return view('admin.moderator_subscription_plans.edit', $data);
        }
    }

    public function subscriptiondelete($id)
    {
        ModeratorSubscriptionPlan::where('id', $id)->delete();

        return Redirect::back()->with(['note' => 'You have been successfully Added New Country', 'note_type' => 'success']);
    }


    public function subscriptionstore(Request $request)
    {
        $input = $request->all();

        $validatedData = $request->validate([
            'plans_name' => 'required|max:255',
            'type' => 'required',
        ]);

        $devices = $request->devices;
        if (!empty($request->plan_id)) {
            
            foreach ($request->plan_id as $key => $value) {
                
                foreach ($request->type as $typekey => $types) {                    
                    if ($typekey == $key) {
                        $new_plan = new ModeratorSubscriptionPlan();
                        $new_plan->type = $types;
                        $new_plan->plans_name = $request->plans_name;
                        $new_plan->payment_type = $request->payment_type;
                        $new_plan->price = $request->price;
                        $new_plan->plan_id = $value;
                        $new_plan->recurring_subscription_plan_id = $value;
                        $new_plan->one_time_subscription_plan_id = $request->one_time_subscription_plan_id[$key];
                        $new_plan->billing_interval = $request->billing_interval;
                        $new_plan->billing_type = $request->billing_type;
                        $new_plan->days = $request->days;
                        $new_plan->video_quality = $request->video_quality;
                        $new_plan->resolution = $request->resolution;
                        $new_plan->devices = !empty($devices) ? implode(',', $devices) : null;
                        $new_plan->subscription_plan_name = $request->plans_name . $types;
                        $new_plan->user_id = Auth::User()->id;
                        $new_plan->ios_product_id = $request->ios_product_id;
                        $new_plan->ios_plan_price = $request->ios_plan_price;
                        $new_plan->plan_content = $request->plan_content;
                        $new_plan->auto_stripe_promo_code_status = !empty($input['auto_stripe_promo_code_status']) == true ? 1 : 0 ;
                        $new_plan->auto_stripe_promo_code        = $request->auto_stripe_promo_code ;
                        $new_plan->upload_video_limit = $request->upload_video_limit;
                        $new_plan->upload_live_limit = $request->upload_live_limit;
                        $new_plan->upload_episode_limit = $request->upload_episode_limit;
                        $new_plan->upload_audio_limit = $request->upload_audio_limit;
                        // $new_plan->andriod_paystack_url = $request->andriod_paystack_url;
                        $new_plan->ads_status = !empty($input['ads_status']) == true ? 1 : 0;
                        $new_plan->save();
                    }
                }
            }
        } else {
            return Redirect::back()->with(['message' => 'Please Enable Payment Systems to ADD PLAN ID and ADD Devices', 'note_type' => 'success']);
        }

        return Redirect::back()->with(['note' => 'You have been successfully Added New Country', 'note_type' => 'success']);
    }


    public function subscriptionupdate(Request $request)
    {
        $validatedData = $request->validate([
            'plans_name' => 'required|max:255',
            'plan_id' => 'required|max:255',
            'price' => 'required|max:255',
        ]);

        $input = $request->all();

        $devices = $request['devices'];

        if (!empty($devices)) {
            $plan_devices = implode(',', $devices);
        } else {
            $plan_devices = null;
        }

        if (!empty($input['subscription_plan_name'])) {
            $subscription_plan_name = $input['subscription_plan_name'];
        } else {
            $subscription_plan_name = [];
        }

        $planid = $input['plan_id'];

        foreach ($subscription_plan_name as $value) {
            $plans = ModeratorSubscriptionPlan::where('subscription_plan_name', $value)->first();
            $plans->plans_name = $request['plans_name'];
            $plans->price = $request['price'];
            $plans->payment_type = $request['payment_type'];
            $plans->video_quality = $input['video_quality'];
            $plans->resolution = $input['resolution'];
            $plans->devices = $plan_devices;
            $plans->ios_product_id = $request->ios_product_id;
            $plans->ios_plan_price = $request->ios_plan_price;
            $plans->plan_content = $request->plan_content;
            // $plans->andriod_paystack_url = $request->andriod_paystack_url;
            $plans->ads_status = !empty($input['ads_status']) == true ? 1 : 0;
            $plans->auto_stripe_promo_code_status = !empty($input['auto_stripe_promo_code_status']) == true ? 1 : 0 ;
            $plans->auto_stripe_promo_code        = $request->auto_stripe_promo_code ;
            $plans->upload_video_limit = $request->upload_video_limit;
            $plans->upload_live_limit = $request->upload_live_limit;
            $plans->upload_episode_limit = $request->upload_episode_limit;
            $plans->upload_audio_limit = $request->upload_audio_limit;
            foreach ($input['plan_id'] as $key => $values) {
                if ($key == $value) {
                    $plans->plan_id = $values;
                    $plans->recurring_subscription_plan_id = $values;
                }
            }
            foreach ($input['one_time_subscription_plan_id'] as $one_timekey => $one_timevalues) {
                if ($one_timekey == $value) {
                    $plans->one_time_subscription_plan_id = $one_timevalues;
                }
            }
            $plans->save();
        }
        return Redirect::to('admin/moderator-subscription-plans/')->with(['note' => 'You have been successfully Added New Plan', 'note_type' => 'success']);
    }

    public function Update_Multiple_Subscription_Plans(Request $request)
    {
        try {

            Setting::first()->update([
                "multiple_subscription_plan" => $request->Multiple_Subscription_Plan,
            ]);

            return response()->json(["message" => "true"]);

        } catch (\Throwable $th) {

            return response()->json(["message" => "false"]);

        }
    }
}
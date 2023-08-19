<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\User as User;
use \Redirect as Redirect;
use URL;
use App\Video as Video;
use App\Plan as Plan;
use App\VideoCategory as VideoCategory;
use App\VideoResolution as VideoResolution;
use App\VideosSubtitle as VideosSubtitle;
use App\Language as Language;
use App\Subtitle as Subtitle;
use App\PaypalPlan as PaypalPlan;
use App\Tag as Tag;
use Auth;
use Hash;
use Illuminate\Support\Facades\Cache;
use Image;
use View;
use Response;
use App\PaylPlan;
use App\Devices;
use App\Setting;
use App\PaymentSetting as PaymentSetting;
use App\SubscriptionPlan as SubscriptionPlan;
use GuzzleHttp\Client;
use App\Currency;
use App\CurrencySetting;

class AdminPlansController extends Controller
{
    public function index()
    {
        $slug = Str::slug('Laravel 5 Framework', '-');
        $plans = Plan::all();
        $devices = Devices::all();

        $data = [
            'plans' => $plans,
            'allplans' => $plans,
            'devices' => $devices,
        ];
        return view('admin.plans.index', $data);
    }

    public function PaypalIndex()
    {
        $slug = Str::slug('Laravel 5 Framework', '-');

        $plans = PaypalPlan::all();
        $devices = Devices::all();
        $data = [
            'plans' => $plans,
            'allplans' => $plans,
            'devices' => $devices,
        ];
        return view('admin.paypal.index', $data);
    }

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

            $plans_data = SubscriptionPlan::all();
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
            ];

            return view('admin.subscription_plans.index', $data);
        }
    }

    public function edit($id)
    {
        $edit_plan = Plan::find($id);
        $permission = $edit_plan['devices'];
        $user_devices = explode(',', $permission);
        $devices = Devices::all();
        $data = [
            'edit_plan' => $edit_plan,
            'user_devices' => $user_devices,
            'devices' => $devices,
        ];
        return view('admin.plans.edit', $data);
    }

    public function PaypalEdit($id)
    {
        $edit_plan = PaypalPlan::find($id);
        $permission = $edit_plan['devices'];
        $user_devices = explode(',', $permission);
        $devices = Devices::all();
        $data = [
            'edit_plan' => $edit_plan,
            'user_devices' => $user_devices,
            'devices' => $devices,
        ];
        return view('admin.paypal.edit', $data);
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
            // $edit_plan = SubscriptionPlan::find($id);
            $edit_plan = SubscriptionPlan::where('id', $id)->get();
            if (!empty($edit_plan[0]->plans_name)) {
                $edit_plan = SubscriptionPlan::where('plans_name', $edit_plan[0]->plans_name)->get();
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
            return view('admin.subscription_plans.edit', $data);
        }
    }

    public function delete($id)
    {
        Plan::where('id', $id)->delete();

        return Redirect::back()->with(['note' => 'You have been successfully Added New Country', 'note_type' => 'success']);
    }
    public function PaypalDelete($id)
    {
        PaypalPlan::where('id', $id)->delete();

        return Redirect::back()->with(['note' => 'You have been successfully Added New Country', 'note_type' => 'success']);
    }

    public function subscriptiondelete($id)
    {
        SubscriptionPlan::where('id', $id)->delete();

        return Redirect::back()->with(['note' => 'You have been successfully Added New Country', 'note_type' => 'success']);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validatedData = $request->validate([
            'plans_name' => 'required|max:255',
            'days' => 'required|max:255',
            'price' => 'required|max:255',
            'type' => 'required|max:255',
        ]);

        $devices = $request->devices;
        $plan_devices = implode(',', $devices);
        $new_plan = new Plan();
        $new_plan->plans_name = $request->plans_name;
        $new_plan->days = $request->days;
        $new_plan->payment_type = $request->payment_type;
        $new_plan->price = $request->price;
        $new_plan->plan_id = $request->plan_id;
        $new_plan->type = $request->type;
        $new_plan->video_quality = $request->video_quality;
        $new_plan->resolution = $request->resolution;
        $new_plan->devices = $plan_devices;
        $new_plan->billing_interval = $request->billing_interval;
        $c_count = Plan::where('plan_id', '=', $new_plan->plan_id)->count();
        if ($c_count == 0) {
            $new_plan->save();
            return Redirect::back()->with(['message' => 'You have been successfully Added New Country', 'note_type' => 'success']);
        } else {
            return Redirect::back()->with(['message' => 'The  Country you were entered is already Exist', 'note_type' => 'failure']);
        }
    }
    public function PaypalStore(Request $request)
    {
        $validatedData = $request->validate([
            'plans_name' => 'required|max:255',
        ]);

        $input = $request->all();

        $devices = $request->devices;
        $plan_devices = implode(',', $devices);

        $new_plan = new PaypalPlan();
        $new_plan->name = $request->plans_name;
        $new_plan->payment_type = $request->payment_type;
        $new_plan->price = $request->price;
        $new_plan->plan_id = $request->plan_id;
        $new_plan->video_quality = $request->video_quality;
        $new_plan->resolution = $request->resolution;
        $new_plan->devices = $plan_devices;

        $c_count = PaypalPlan::where('plan_id', '=', $new_plan->plan_id)->count();
        
        if ($c_count == 0) {
            $new_plan->save();
            return Redirect::back()->with(['note' => 'You have been successfully Added New Country', 'note_type' => 'success']);
        } else {
            return Redirect::back()->with(['note' => 'The  Country you were entered is already Exist', 'note_type' => 'failure']);
        }
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
                        $new_plan = new SubscriptionPlan();
                        $new_plan->type = $types;
                        $new_plan->plans_name = $request->plans_name;
                        $new_plan->payment_type = $request->payment_type;
                        $new_plan->price = $request->price;
                        $new_plan->plan_id = $value;
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
                        $new_plan->andriod_paystack_url = $request->andriod_paystack_url;
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

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'plans_name' => 'required|max:255',
            'days' => 'required|max:255',
            'price' => 'required|max:255',
            'type' => 'required|max:255',
        ]);

        $input = $request->all();

        if (!empty($request->video_quality)) {
            $video_quality = $request->video_quality;
        } else {
            $video_quality = null;
        }

        $devices = $input['devices'];
        $plan_devices = implode(',', $devices);

        $id = $request->id;
        $plans = Plan::find($id);

        $plans->plans_name = $request->plans_name;
        $plans->days = $request->days;
        $plans->payment_type = $request->payment_type;
        $plans->price = $request->price;
        $plans->plan_id = $request->plan_id;
        $plans->type = $request->type;
        $plans->video_quality = $input['video_quality'];
        $plans->resolution = $input['resolution'];
        $plans->devices = $plan_devices;
        $plans->billing_interval = $request->billing_interval;
        $plans_count = Plan::where('plans_name', '=', $plans->plans_name)->count();
        $plans->save();

        return Redirect::to('admin/plans/')->with(['note' => 'You have been successfully Added New Plan', 'note_type' => 'success']);
    }

    public function PaypalUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'plans_name' => 'required|max:255',
            'plan_id' => 'required|max:255',
            'price' => 'required|max:255',
        ]);

        $input = $request->all();

        $devices = $input['devices'];
        $plan_devices = implode(',', $devices);
        
        $id = $request['id'];
        $plans = PaypalPlan::find($id);
        $plans->name = $request['plans_name'];
        $plans->price = $request['price'];
        $plans->payment_type = $request['payment_type'];
        $plans->video_quality = $input['video_quality'];
        $plans->resolution = $input['resolution'];
        $plans->devices = $plan_devices;
        $plans->plan_id = $request['plan_id'];
        $plans->save();

        return Redirect::to('admin/paypalplans/')->with(['note' => 'You have been successfully Added New Plan', 'note_type' => 'success']);
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
            $plans = SubscriptionPlan::where('subscription_plan_name', $value)->first();
            $plans->plans_name = $request['plans_name'];
            $plans->price = $request['price'];
            $plans->payment_type = $request['payment_type'];
            $plans->video_quality = $input['video_quality'];
            $plans->resolution = $input['resolution'];
            $plans->devices = $plan_devices;
            $plans->ios_product_id = $request->ios_product_id;
            $plans->ios_plan_price = $request->ios_plan_price;
            $plans->plan_content = $request->plan_content;
            $plans->andriod_paystack_url = $request->andriod_paystack_url;
            $plans->ads_status = !empty($input['ads_status']) == true ? 1 : 0;

            foreach ($input['plan_id'] as $key => $values) {
                if ($key == $value) {
                    $plans->plan_id = $values;
                }
            }
            $plans->save();
        }
        return Redirect::to('admin/subscription-plans/')->with(['note' => 'You have been successfully Added New Plan', 'note_type' => 'success']);
    }

    // public function subscriptionupdate(Request $request) {
    //     $validatedData = $request->validate([
    //         'plans_name' => 'required|max:255',
    //         'plan_id' => 'required|max:255',
    //         'price' => 'required|max:255',
    //     ]);
    //     $input = $request->all();
    //     // dd($input);

    //     // $edit_plan = SubscriptionPlan::find($id);
    //     // $payment_settings = PaymentSetting::all();
    //     // $devices = $input['devices'];
    //     // $plan_devices = implode(",",$devices);
    //     $id = $request['id'];
    //     $plans = SubscriptionPlan::find($id);
    // 	$plans->plans_name = $request['plans_name'];
    // 	$plans->price = $request['price'];
    // 	$plans->payment_type = $request['payment_type'];
    //     $plans->video_quality = $input['video_quality'];
    //     $plans->resolution = $input['resolution'];
    //     // $plans->devices = $plan_devices;
    //     $plans->plan_id  = $request['plan_id'];
    //     $plans->save();

    //     return Redirect::to('admin/subscription-plans/')->with(array('note' => 'You have been successfully Added New Plan', 'note_type' => 'success'));
    // }

    public function DevicesIndex()
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
            $devices = Devices::all();

            $data = [
                'devices' => $devices,
            ];
            return view('admin.devices.index', compact('devices'));
        }
    }

    public function DevicesStore(Request $request)
    {
        $input = $request->all();
        $devices = new Devices();
        $devices->devices_name = $request['devices_name'];
        $devices->user_id = Auth::User()->id;
        $devices->save();

        return Redirect::back()->with(['note' => 'You have been successfully Added New Devices', 'note_type' => 'success']);
    }

    public function DevicesEdit($id)
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
            $edit_devices = Devices::where('id', '=', $id)->first();

            $data = [
                'devices' => $edit_devices,
            ];
            return view('admin.devices.edit', $data);
        }
    }

    public function DevicesDelete($id)
    {
        Devices::where('id', $id)->delete();

        return Redirect::back()->with(['note' => 'You have been successfully Added New Devices', 'note_type' => 'success']);
    }

    public function DevicesUpdate(Request $request)
    {
        $input = $request->all();
        $id = $request['id'];
        $devices = Devices::find($id);
        $devices->devices_name = $request['devices_name'];
        $devices->user_id = Auth::User()->id;
        $devices->save();

        return Redirect::back()->with(['note' => 'You have been successfully Added New Coupon', 'note_type' => 'success']);
    }
}

<?php

namespace Webnexs\Avod;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Laravel\Cashier\Exceptions\IncompletePayment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use Carbon\CarbonInterval;
use Illuminate\Support\Str;
use Razorpay\Api\Api;
use Validator, Redirect, Response;
use Exception;
use Carbon\Carbon;
use App\Advertiserplanhistory;
use App\Advertiser;
use App\Advertisement;
use App\Adscategory;
use App\FeaturedadHistory;
use App\Advertiserwallet;
use App\AdsTimeSlot;
use App\Adcampaign;
use App\Adviews;
use App\Adrevenue;
use App\Setting;
use App\Adsplan;
use App\AdsEvent;
use App\User;
use App\AdsViewCount;
use App\AdsRedirectionURLCount;
use App\Video;
use App\LiveStream;
use App\Episode;
use DatePeriod;
use Session;
use Stripe;
use Mail;
use DB;
use URL;
use File;

class AuthController extends Controller
{

    public function index()
    {
        $data = ['settings' => Setting::first()];
        return view('avod::login', $data);
    }

    public function register()
    {
        $data = ['settings' => Setting::first()];
        return view('avod::register', $data);
    }

    public function postLogin(Request $request)
    {
        request()->validate([
            'email_id' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if ($data = Advertiser::where('email_id', $request->email_id)->first()) {
            $pass = Hash::check($request->password, $data->password);
            if ($pass && $data->status == 1) {
                session(['advertiser_id' => $data->id]);
                return redirect()->intended('/advertiser');
            } elseif ($pass && $data->status == 0) {
                return Redirect::to('advertiser/login')->withError('Opps! Your account is under verification.Please wait for admin approval.');
            } elseif ($pass && $data->status == 2) {
                return Redirect::to('advertiser/login')->withError('Opps! Admin has disapproved your account.Please contact administrator.');
            }
        }
        return Redirect::to('advertiser/login')->withError('Opps! You have entered invalid credentials');
    }

    public function postRegister(Request $request)
    {
        request()->validate([
            'company_name' => 'required',
            'email_id' => 'required|email|unique:advertisers',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();
        $advertiser = new Advertiser();
        $advertiser->password = Hash::make($data['password']);
        $advertiser->email_id = $data['email_id'];
        $advertiser->company_name = $data['company_name'];
        $advertiser->license_number = $data['license_number'];
        $advertiser->address = $data['address'];
        $advertiser->mobile_number = $data['mobile_number'];
        $advertiser->save();

        $advertiser_emailid = $data['email_id'];
        $customerName = $data['company_name'];
        $adminemail = User::where('role', '=', 'admin')->first()->email;

        $details = [
            'title' => 'Dear ' . $customerName,
            'body' =>
                "We are happy to have you on board.\n
            Thank you for registering as an Advertiser at " .
                $customerName .
                ".\n 
            If you have any questions, please write to us at " .
                $adminemail .
                ' for queries and suggestions.',
        ];

        try {
            \Mail::to($advertiser_emailid)->send(new \App\Mail\MyTestMail($details));
        } catch (\Throwable $th) {
            //throw $th;
        }

        return Redirect::to('advertiser/login')->withSuccess('Great! You have Successfully registered');
    }

    public function dashboard()
    {
        $data = [];
        $data['settings'] = Setting::first();
        // $activeplan = Advertiserplanhistory::where('advertiser_id',session('advertiser_id'))->where('status','active')->count();

        $activeplan = 1; // stativ data given

        if (!empty(session('advertiser_id')) && $activeplan == 0) {
            $data['plans'] = Adsplan::all();
            return view('avod::chooseplan', $data);
        } elseif (!empty(session('advertiser_id')) && $activeplan > 0) {
            $adslist = Advertisement::where('advertiser_id', session('advertiser_id'))
                ->pluck('id')
                ->toArray();
            $cpc = [];
            $ads = [];
            foreach ($adslist as $key => $ad_id) {
                $cpc[] = Adrevenue::where('ad_id', $ad_id)->sum('advertiser_share');
                $ads[] = Advertisement::where('id', $ad_id)->first()->ads_name;
            }

            $ads1 = $cpv = [];
            foreach ($adslist as $key => $ad_id) {
                $cpv[] = Adviews::where('ad_id', $ad_id)->sum('advertiser_share');
                $ads1[] = Advertisement::where('id', $ad_id)->first()->ads_name;
            }
            return view('avod::dashboard')
                ->with('ads', json_encode($ads, JSON_NUMERIC_CHECK))
                ->with('cpc', json_encode($cpc, JSON_NUMERIC_CHECK))
                ->with('ads1', json_encode($ads1, JSON_NUMERIC_CHECK))
                ->with('cpv', json_encode($cpv, JSON_NUMERIC_CHECK));
        }
        return Redirect::to('advertiser/login')->withError('Opps! You do not have access');
    }

    public function logout()
    {
        Session::flush();
        return Redirect('advertiser/login');
    }

    public function buyplan(Request $request)
    {
        $data = [];
        $data['settings'] = Setting::first();
        if (!empty(session('advertiser_id'))) {
            $user_id = session('advertiser_id');
            $user = Advertiser::find($user_id);
            $paymentMethod = $request->get('py_id');
            $plan_id = $request->get('plan');
            $plan_amount = Adsplan::where('id', $plan_id)->first()->plan_amount;
            try {
                $user->createOrGetStripeCustomer();
                $user->updateDefaultPaymentMethod($paymentMethod);
                $charge = $user->charge($plan_amount * 100, $paymentMethod);

                $ads_limit = Adsplan::where('id', $plan_id)->first()->no_of_ads;
                $planhistory = new Advertiserplanhistory();
                $planhistory->plan_id = $plan_id;
                $planhistory->advertiser_id = session('advertiser_id');
                $planhistory->ads_limit = $ads_limit;
                $planhistory->no_of_uploads = 0;
                $planhistory->status = 'active';
                $planhistory->payment_mode = 'stripe';
                $planhistory->transaction_id = $charge->id;
                $planhistory->save();

                $plan_name = Adsplan::where('id', $plan_id)->first()->plan_name;
                $plan_amount = Adsplan::where('id', $plan_id)->first()->plan_amount;
                $date = date('Y-m-d');
                $customerName = Advertiser::find(session('advertiser_id'))->company_name;
                $adminemail = User::where('role', '=', 'admin')->first()->email;
                $advertiser_emailid = Advertiser::find(session('advertiser_id'))->email_id;

                $details = [
                    'title' => 'Dear ' . $customerName,
                    'body' =>
                        "Welcome to Flicknexs.
                        Thank you for purchasing to Ad plan. \n
                        Your Plan Name :" .
                        $plan_name .
                        "\n
                        Date of Purchase: " .
                        $date .
                        "\n
                        Plan Amount : " .
                        $plan_amount .
                        "\n
                        Log in to the Ad panel to explore more!\n
                        Please write to us at " .
                        $adminemail .
                        ' for queries and suggestions.',
                ];

                try {
                    \Mail::to($advertiser_emailid)->send(new \App\Mail\MyTestMail($details));
                } catch (\Throwable $th) {
                    //throw $th;
                }

                echo 'success';
                exit();
            } catch (IncompletePayment $exception) {
                return redirect()->route('cashier.payment', [$exception->payment->id, 'redirect' => route('advertiser')]);
            }
        }
        echo 'error';
        exit();
    }

    public function plan_history()
    {
        $data = [];
        $data['settings'] = Setting::first();
        // $activeplan = Advertiserplanhistory::where('advertiser_id',session('advertiser_id'))->where('status','active')->count();

        $activeplan = 1; // Static data

        if (!empty(session('advertiser_id')) && $activeplan == 0) {
            return Redirect::to('/advertiser')->withError('Opps! You do not have access');
        } elseif (!empty(session('advertiser_id')) && $activeplan > 0) {
            $data['plans'] = DB::table('advertiser_plan_history')
                ->select('advertiser_plan_history.*', 'ads_plans.plan_name', 'ads_plans.plan_amount', 'ads_plans.no_of_ads')
                ->join('ads_plans', 'ads_plans.id', '=', 'advertiser_plan_history.plan_id')
                ->where('advertiser_plan_history.advertiser_id', session('advertiser_id'))
                ->get();

            return view('avod::plan_history', $data);
        }

        return Redirect::to('advertiser/login')->withError('Opps! You do not have access');
    }

    public function upload_ads_old()
    {
        $data = [];
        $data['settings'] = Setting::first();
        $activeplan = Advertiserplanhistory::where('advertiser_id', session('advertiser_id'))
            ->where('status', 'active')
            ->count();
        $getdata = Advertiserplanhistory::where('advertiser_id', '=', session('advertiser_id'))
            ->where('status', 'active')
            ->first();
        $upload_ads_cnt = $getdata->ads_limit - $getdata->no_of_uploads;

        if ((!empty(session('advertiser_id')) && $activeplan == 0) || $upload_ads_cnt == 0) {
            $getdata->status = 'deactive';
            $getdata->save();

            $plan_name = Adsplan::where('id', $getdata->plan_id)->first()->plan_name;
            $customerName = Advertiser::find(session('advertiser_id'))->company_name;
            $advertiser_emailid = Advertiser::find(session('advertiser_id'))->email_id;
            $details = [
                'title' => 'Dear ' . $customerName,
                'body' => 'Your ' . $plan_name . ' limit for the plan has been reached, to add more ads please login to your account to upgrade plan.',
            ];

            try {
                \Mail::to($advertiser_emailid)->send(new \App\Mail\MyTestMail($details));
            } catch (\Throwable $th) {
                //throw $th;
            }

            return Redirect::to('/advertiser')->withError('Opps! Your limit has completed.Please update your plan');
        } elseif (!empty(session('advertiser_id')) && $activeplan > 0 && $getdata->ads_limit > $getdata->no_of_uploads) {
            // Ads scheduling

            $now = Carbon::now();

            $data = [
                'Monday_time' => AdsTimeSlot::where('day', 'Monday')->get(),
                'Tuesday_time' => AdsTimeSlot::where('day', 'Tuesday')->get(),
                'Wednesday_time' => AdsTimeSlot::where('day', 'Wednesday')->get(),
                'Thursday_time' => AdsTimeSlot::where('day', 'Thrusday')->get(),
                'Friday_time' => AdsTimeSlot::where('day', 'Friday')->get(),
                'Saturday_time' => AdsTimeSlot::where('day', 'Saturday')->get(),
                'Sunday_time' => AdsTimeSlot::where('day', 'Sunday')->get(),
                'Monday' => $now->startOfWeek(Carbon::MONDAY)->format('Y-m-d'),
                'Tuesday' => $now->endOfWeek(Carbon::TUESDAY)->format('Y-m-d'),
                'Wednesday' => $now->endOfWeek(Carbon::WEDNESDAY)->format('Y-m-d'),
                'Thrusday' => $now->endOfWeek(Carbon::THURSDAY)->format('Y-m-d'),
                'Friday' => $now->endOfWeek(Carbon::FRIDAY)->format('Y-m-d'),
                'Saturday' => $now->endOfWeek(Carbon::SATURDAY)->format('Y-m-d'),
                'Sunday' => $now->endOfWeek(Carbon::SUNDAY)->format('Y-m-d'),
            ];

            //  End Scheduling

            $data['ads_category'] = Adscategory::all();
            return view('avod::upload_ads', $data);
        }
        return Redirect::to('advertiser/login')->withError('Opps! You do not have access');
    }

    public function upload_ads(Request $request)
    {
        $data = [];
        $data['settings'] = Setting::first();

        // $activeplan = Advertiserplanhistory::where('advertiser_id',session('advertiser_id'))->where('status','active')->count();

        $activeplan = 1; // stativ data given

        if (!empty(session('advertiser_id')) && $activeplan == 0) {
            return Redirect::to('/advertiser')->withError('Opps! Please update your plan for uploading ads');
        } elseif (!empty(session('advertiser_id')) && $activeplan > 0) {
            // Ads scheduling

            $now = Carbon::now();

            $data = [
                'Monday_time' => AdsTimeSlot::where('day', 'Monday')->get(),
                'Tuesday_time' => AdsTimeSlot::where('day', 'Tuesday')->get(),
                'Wednesday_time' => AdsTimeSlot::where('day', 'Wednesday')->get(),
                'Thursday_time' => AdsTimeSlot::where('day', 'Thrusday')->get(),
                'Friday_time' => AdsTimeSlot::where('day', 'Friday')->get(),
                'Saturday_time' => AdsTimeSlot::where('day', 'Saturday')->get(),
                'Sunday_time' => AdsTimeSlot::where('day', 'Sunday')->get(),
                'Monday' => $now->startOfWeek(Carbon::MONDAY)->format('Y-m-d'),
                'Tuesday' => $now->endOfWeek(Carbon::TUESDAY)->format('Y-m-d'),
                'Wednesday' => $now->endOfWeek(Carbon::WEDNESDAY)->format('Y-m-d'),
                'Thrusday' => $now->endOfWeek(Carbon::THURSDAY)->format('Y-m-d'),
                'Friday' => $now->endOfWeek(Carbon::FRIDAY)->format('Y-m-d'),
                'Saturday' => $now->endOfWeek(Carbon::SATURDAY)->format('Y-m-d'),
                'Sunday' => $now->endOfWeek(Carbon::SUNDAY)->format('Y-m-d'),
            ];

            //  End Scheduling

            $data['ads_category'] = Adscategory::all();
            return view('avod::upload_ads', $data);
        }
        return Redirect::to('advertiser/login')->withError('Opps! You do not have access');
    }

    public function paymentgateway($plan_id)
    {
        $data['plan_id'] = $plan_id;
        $data['plan_amount'] = Adsplan::where('id', $plan_id)->first()->plan_amount * 100;
        $data['plan_value'] = Adsplan::where('id', $plan_id)->first()->plan_amount;
        $data['plan_name'] = Adsplan::where('id', $plan_id)->first()->plan_name;
        $data['no_of_ads'] = Adsplan::where('id', $plan_id)->first()->no_of_ads;
        $data['settings'] = Setting::first();
        $user_id = session('advertiser_id');
        $user = Advertiser::find($user_id);
        $data['intent'] = $user->createSetupIntent();
        $data['user'] = $user;
        $data['website_logo'] = Setting::pluck('logo')->first();
        $data['website_name'] = Setting::pluck('website_name')->first();

        return view('avod::stripegateway', $data);
    }

    public function buyplanrazorpay(Request $request)
    {
        $input = $request->all();

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $payment = $api->payment->fetch($input['razorpay_payment_id']);

        if (count($input) && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(['amount' => $payment['amount']]);

                $plan_id = $input['plan_id'];
                $ads_limit = Adsplan::where('id', $plan_id)->first()->no_of_ads;
                $planhistory = new Advertiserplanhistory();
                $planhistory->plan_id = $plan_id;
                $planhistory->advertiser_id = session('advertiser_id');
                $planhistory->ads_limit = $ads_limit;
                $planhistory->no_of_uploads = 0;
                $planhistory->status = 'active';
                $planhistory->payment_mode = 'razorpay';
                $planhistory->transaction_id = $input['razorpay_payment_id'];
                $planhistory->save();

                $plan_name = Adsplan::where('id', $plan_id)->first()->plan_name;
                $plan_amount = Adsplan::where('id', $plan_id)->first()->plan_amount;
                $date = date('Y-m-d');
                $customerName = Advertiser::find(session('advertiser_id'))->company_name;
                $adminemail = User::where('role', '=', 'admin')->first()->email;
                $advertiser_emailid = Advertiser::find(session('advertiser_id'))->email_id;
                $details = [
                    'title' => 'Dear ' . $customerName,
                    'body' =>
                        "Welcome to Flicknexs.
                    Thank you for purchasing to Ad plan. \n
                    Your Plan Name :" .
                        $plan_name .
                        "\n
                    Date of Purchase: " .
                        $date .
                        "\n
                    Plan Amount : " .
                        $plan_amount .
                        "\n
                    Log in to the Ad panel to explore more!\n
                    Please write to us at " .
                        $adminemail .
                        ' for queries and suggestions.',
                ];

                try {
                    \Mail::to($advertiser_emailid)->send(new \App\Mail\MyTestMail($details));
                } catch (\Throwable $th) {
                    //throw $th;
                }

                return Redirect::to('advertiser/')->withSuccess('success', 'Payment Successful');
            } catch (Exception $e) {
                return $e->getMessage();
                return redirect()
                    ->back()
                    ->withError('error', $e->getMessage());
            }
        }

        return Redirect::to('advertiser/billing_details')->withError('error', 'Please try again');
    }

    public function billing_details()
    {
        $data['planhistory'] = Advertiserplanhistory::where('advertiser_id', session('advertiser_id'))
            ->where('status', 'active')
            ->first();

        $data['plan'] = Adsplan::where('id', $data['planhistory']->plan_id)->first();
        $data['settings'] = Setting::first();

        return view('avod::billing_details', $data);
    }

    public function showForgetPasswordForm()
    {
        return view('avod::forgetPassword');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email_id' => 'required|email|exists:advertisers',
        ]);

        $token = Str::random(64);
        DB::table('advertiser_password_reset')->insert([
            'email' => $request->email_id,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        try {
            \Mail::send('avod::forgetPasswordemail', ['token' => $token], function ($message) use ($request) {
                $message->to($request->email_id);
                $message->subject('Reset Password');
            });
        } catch (\Throwable $th) {
            //throw $th;
        }

        return Redirect::to('advertiser/login')->withSuccess('We have e-mailed your password reset link!');
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function showResetPasswordForm($token)
    {
        return view('avod::forgetPasswordLink', ['token' => $token]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'email_id' => 'required|email|exists:advertisers',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);

        $updatePassword = DB::table('advertiser_password_reset')
            ->where([
                'email' => $request->email_id,
                'token' => $request->token,
            ])
            ->first();

        if (!$updatePassword) {
            return back()
                ->withInput()
                ->with('error', 'Invalid token!');
        }

        $user = Advertiser::where('email_id', $request->email_id)->update(['password' => Hash::make($request->password)]);

        DB::table('advertiser_password_reset')
            ->where(['email' => $request->email_id])
            ->delete();

        return redirect('advertiser/login')->with('success', 'Your password has been changed!');
    }

    public function FeaturedAds()
    {
        $data = [];
        $data['settings'] = Setting::first();
        $data['advertisements'] = Advertisement::where('advertiser_id', session('advertiser_id'))
            ->where('featured', 1)
            ->get();
        $data['activeplan'] = Advertiserplanhistory::where('advertiser_id', session('advertiser_id'))
            ->where('status', 'active')
            ->count();

        return view('avod::featured_ads', $data);
    }

    public function UploadFeaturedAd()
    {
        $data = [];
        $data['settings'] = Setting::first();
        $data['ads_category'] = Adscategory::all();
        $user_id = session('advertiser_id');
        $user = Advertiser::find($user_id);
        $data['intent'] = $user->createSetupIntent();
        $data['user'] = $user;

        // Ads scheduling

        $now = Carbon::now();

        $data['Monday_time'] = AdsTimeSlot::where('day', 'Monday')->get();
        $data['Tuesday_time'] = AdsTimeSlot::where('day', 'Tuesday')->get();
        $data['Wednesday_time'] = AdsTimeSlot::where('day', 'Wednesday')->get();
        $data['Thursday_time'] = AdsTimeSlot::where('day', 'Thrusday')->get();
        $data['Friday_time'] = AdsTimeSlot::where('day', 'Friday')->get();
        $data['Saturday_time'] = AdsTimeSlot::where('day', 'Saturday')->get();
        $data['Sunday_time'] = AdsTimeSlot::where('day', 'Sunday')->get();
        $data['Monday'] = $now->startOfWeek(Carbon::MONDAY)->format('Y-m-d');
        $data['Tuesday'] = $now->endOfWeek(Carbon::TUESDAY)->format('Y-m-d');
        $data['Wednesday'] = $now->endOfWeek(Carbon::WEDNESDAY)->format('Y-m-d');
        $data['Thrusday'] = $now->endOfWeek(Carbon::THURSDAY)->format('Y-m-d');
        $data['Friday'] = $now->endOfWeek(Carbon::FRIDAY)->format('Y-m-d');
        $data['Saturday'] = $now->endOfWeek(Carbon::SATURDAY)->format('Y-m-d');
        $data['Sunday'] = $now->endOfWeek(Carbon::SUNDAY)->format('Y-m-d');

        $data['activeplan'] = Advertiserplanhistory::where('advertiser_id', session('advertiser_id'))
            ->where('status', 'active')
            ->count();

        return view('avod::upload_featured_ad', $data);
    }

    public function buyfeaturedad_stripe(Request $request)
    {
        $data = [];
        $data['settings'] = Setting::first();
        if (!empty(session('advertiser_id'))) {
            $user_id = session('advertiser_id');
            $user = Advertiser::find($user_id);
            $paymentMethod = $request->get('py_id');
            $plan_amount = $request->get('price');
            try {
                $user->createOrGetStripeCustomer();
                $user->updateDefaultPaymentMethod($paymentMethod);
                $charge = $user->charge($plan_amount * 100, $paymentMethod);

                $planhistory = new FeaturedadHistory();
                $planhistory->advertiser_id = session('advertiser_id');
                $planhistory->payment_mode = 'stripe';
                $planhistory->transaction_id = $charge->id;
                $planhistory->cost = $plan_amount;
                $planhistory->save();

                $Ads = new Advertisement();
                $Ads->advertiser_id = session('advertiser_id');
                $Ads->ads_name = $request->ads_name;
                $Ads->ads_category = $request->ads_category;
                $Ads->featured = 1;
                $Ads->ads_position = $request->ads_position;
                $Ads->ads_path = $request->ads_path;
                $Ads->ads_upload_type = $request->ads_upload_type;
                $Ads->age = json_encode($request->age);
                $Ads->gender = json_encode($request->gender);
                $Ads->household_income = $request->household_income;
                $Ads->location = $request->location;
                $Ads->save();

                echo 'success';
                exit();
            } catch (IncompletePayment $exception) {
                return redirect()->route('cashier.payment', [$exception->payment->id, 'redirect' => route('advertiser')]);
            }
        }
        echo 'error';
        exit();
    }

    public function featured_ad_history()
    {
        $data = [];
        $data['settings'] = Setting::first();
        $data['activeplan'] = Advertiserplanhistory::where('advertiser_id', session('advertiser_id'))
            ->where('status', 'active')
            ->count();
        $data['list'] = FeaturedadHistory::where('advertiser_id', session('advertiser_id'))->get();
        return view('avod::featured_ad_history', $data);
    }

    public function ads_campaign()
    {
        $data = [];
        $data['settings'] = Setting::first();
        $data['campaigns'] = Adcampaign::all();
        $user_id = session('advertiser_id');
        $user = Advertiser::find($user_id);
        $data['intent'] = $user->createSetupIntent();
        $data['user'] = $user;
        $data['activeplan'] = Advertiserplanhistory::where('advertiser_id', session('advertiser_id'))
            ->where('status', 'active')
            ->count();

        return view('avod::advertiser_wallet', $data);
    }

    public function buycampaign_stripe(Request $request)
    {
        $data = [];
        $data['settings'] = Setting::first();
        if (!empty(session('advertiser_id'))) {
            $user_id = session('advertiser_id');
            $user = Advertiser::find($user_id);
            $paymentMethod = $request->get('py_id');
            $amount = $request->get('amount');
            $campaign_id = $request->get('campaign_id');
            try {
                $user->createOrGetStripeCustomer();
                $user->updateDefaultPaymentMethod($paymentMethod);
                $charge = $user->charge($amount * 100, $paymentMethod);

                $walletdata = new Advertiserwallet();
                $walletdata->advertiser_id = session('advertiser_id');
                $walletdata->payment_mode = 'stripe';
                $walletdata->status = 1;
                $walletdata->transaction_id = $charge->id;
                $walletdata->amount = $amount;
                $walletdata->campaign_id = $campaign_id;
                $walletdata->save();

                echo 'success';
                exit();
            } catch (IncompletePayment $exception) {
                return redirect()->route('cashier.payment', [$exception->payment->id, 'redirect' => route('ads_campaign')]);
            }
        }
        echo 'error';
        exit();
    }

    public function buyrz_adcampaign(Request $request)
    {
        $input = $request->all();
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $payment = $api->payment->fetch($input['razorpay_payment_id']);

        if (count($input) && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(['amount' => $payment['amount']]);
                $walletdata = new Advertiserwallet();
                $walletdata->advertiser_id = session('advertiser_id');
                $walletdata->payment_mode = 'razorpay';
                $walletdata->status = 1;
                $walletdata->transaction_id = $input['razorpay_payment_id'];
                $walletdata->amount = $payment['amount'];
                $walletdata->campaign_id = $campaign_id;
                $walletdata->save();

                return Redirect::to('advertiser/ads_campaign/')->withSuccess('success', 'Payment Successful');
            } catch (Exception $e) {
                return $e->getMessage();
                return redirect()
                    ->back()
                    ->withError('error', $e->getMessage());
            }
        }

        return Redirect::to('advertiser/ads_campaign/')->withError('error', 'Please try again');
    }

    public function buyrz_ad(Request $request)
    {
        $input = $request->all();
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $payment = $api->payment->fetch($input['razorpay_payment_id']);

        if (count($input) && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(['amount' => $payment['amount']]);

                $planhistory = new FeaturedadHistory();
                $planhistory->advertiser_id = session('advertiser_id');
                $planhistory->payment_mode = 'razorpay';
                $planhistory->transaction_id = $input['razorpay_payment_id'];
                $planhistory->cost = $payment['amount'] / 100;
                $planhistory->save();

                $Ads = new Advertisement();
                $Ads->advertiser_id = session('advertiser_id');
                $Ads->ads_name = $request->ads_name;
                $Ads->ads_category = $request->ads_category;
                $Ads->featured = 1;
                $Ads->ads_position = $request->ads_position;
                $Ads->ads_path = $request->ads_path;
                $Ads->ads_upload_type = $request->ads_upload_type;
                // $Ads->age = $request->age;
                // $Ads->gender = $request->gender;
                $Ads->household_income = $request->household_income;
                $Ads->age = json_encode($input['age']);
                $Ads->gender = json_encode($input['gender']);
                $Ads->location = $request->location;
                $Ads->save();
                return Redirect::to('advertiser/featured_ads/')->withSuccess('success', 'Payment Successful');
            } catch (Exception $e) {
                return redirect()->route('cashier.payment', [$e->payment->id, 'redirect' => route('advertiser')]);
            }
        }

        echo 'error';
        exit();
    }

    public function Ads_Scheduled(Request $request)
    {
        if ($request->ajax()) {
            $data = AdsEvent::where('advertiser_id', session('advertiser_id'))
                ->whereDate('start', '>=', $request->start)
                ->whereDate('end', '<=', $request->end)
                ->get(['id', 'title', 'start', 'end', 'ads_category_id', 'color']);

            return response()->json($data);
        }

        return view('avod::Ads_Scheduled');
    }

    public function AdsScheduleStore(Request $request)
    {
        switch ($request->type) {
            case 'add':
                $event = AdsEvent::create([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end,
                    'ads_category_id' => $request->ads_category,
                    'color' => $request->color ? $request->color : null,
                ]);

                return redirect('advertiser/Ads_Scheduled');
                break;

            case 'update':
                $event = AdsEvent::find($request->id)->update([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end,
                ]);

                return response()->json($event);
                break;

            case 'delete':
                $event = AdsEvent::find($request->id)->delete();

                return response()->json($event);
                break;

            default:
                # code...
                break;
        }
    }

    public function AdsEvents(Request $request)
    {
        $data = [
            'ads_category' => Adscategory::all(),
        ];

        return view('avod::Ads_events', $data);
    }

    public function ads_list()
    {
        try {

            if (empty(session('advertiser_id' ) || session('advertiser_id') == 'null' )) {
                return Redirect::to('advertiser/login')->withError('Opps! You do not have access');
            }

            $data = [
                'settings' => Setting::first(),
                'advertisements' => Advertisement::where('advertiser_id', session('advertiser_id'))
                    ->get()->map(function ($item) {
                        $item['ads_category'] = Adscategory::where('id', $item->ads_category)->pluck('name')->first();
                        return $item;
                    }),
            ];

            return view('avod::ads_list', $data);
        } catch (\Throwable $th) {
            // return $th->getMessage();
            return abort(404);
        }
    }

    public function store_ads(Request $request)
    {

        if( empty(session('advertiser_id') ||  session('advertiser_id') == 'null' ) ){
            return Redirect::to('advertiser/login')->withError('Opps! You do not have access');
        }
        
        $data = $request->all();

        $Ads = new Advertisement();
        $Ads->advertiser_id = session('advertiser_id');
        $Ads->ads_name = $request->ads_name;
        $Ads->ads_category = $request->ads_category;
        $Ads->ads_position = $request->ads_position;
        $Ads->ads_path = $request->ads_path;
        $Ads->ads_upload_type =  $request->ads_upload_type;
        // $Ads->age = $request->age;
        // $Ads->gender = $request->gender;
        $Ads->household_income = $request->household_income;

        if ($request->location == 'all_countries' || $request->location == 'India') {
            $Ads->location = $request->location;
        } else {
            $Ads->location = $request->locations;
        }

        if (!empty($data['age'])) {
            $Ads->age = json_encode($data['age']);
        }

        if (!empty($data['gender'])) {
            $Ads->gender = json_encode($data['gender']);
        }

        if ($request->ads_video != null) {

            $data = array (
                "ads_videos" => $request->ads_video ,
                "ads_redirection_url" => $request->ads_redirection_url ,
            );

            $Ads_xml_file = $this->Ads_xml_file( $data );
            $Ads->ads_video =  $Ads_xml_file['Ads_upload_url'] ;
            $Ads->ads_path =  $Ads_xml_file['Ads_xml_url'] ;
            $Ads->ads_redirection_url =  $request->ads_redirection_url ;
        }

        $Ads->save();

        $last_ads_id = $Ads->id;
        $last_ads_name = $Ads->ads_name ? $Ads->ads_name : 'Ads';

        // Events

        $mondays = new DatePeriod(Carbon::now()->startOfWeek(Carbon::MONDAY), CarbonInterval::week(), Carbon::now(Carbon::MONDAY)->addMonths(6));
        $tuesday = new DatePeriod(Carbon::now()->startOfWeek(Carbon::TUESDAY), CarbonInterval::week(), Carbon::now(Carbon::TUESDAY)->addMonths(6));
        $wednesday = new DatePeriod(Carbon::now()->startOfWeek(Carbon::WEDNESDAY), CarbonInterval::week(), Carbon::now(Carbon::WEDNESDAY)->addMonths(6));
        $thursday = new DatePeriod(Carbon::now()->startOfWeek(Carbon::THURSDAY), CarbonInterval::week(), Carbon::now(Carbon::THURSDAY)->addMonths(6));
        $friday = new DatePeriod(Carbon::now()->startOfWeek(Carbon::FRIDAY), CarbonInterval::week(), Carbon::now(Carbon::FRIDAY)->addMonths(6));
        $saturday = new DatePeriod(Carbon::now()->startOfWeek(Carbon::SATURDAY), CarbonInterval::week(), Carbon::now(Carbon::SATURDAY)->addMonths(6));
        $sunday = new DatePeriod(Carbon::now()->startOfWeek(Carbon::SUNDAY), CarbonInterval::week(), Carbon::now(Carbon::SUNDAY)->addMonths(6));

        if ($request->Monday_Start_time != null && $request->Monday_end_time != null) {
            foreach ($mondays as $date) {
                $Monday_start_time = count($request['Monday_Start_time']);

                for ($i = 0; $i < $Monday_start_time; $i++) {
                    $AdsTimeSlot = new AdsEvent();
                    $AdsTimeSlot->start = $date->format('Y-m-d') . ' ' . $request['Monday_Start_time'][$i];
                    $AdsTimeSlot->end = $date->format('Y-m-d') . ' ' . $request['Monday_end_time'][$i];
                    $AdsTimeSlot->ads_category_id = $request->ads_category;
                    $AdsTimeSlot->ads_id = $last_ads_id;
                    $AdsTimeSlot->title = $last_ads_name;
                    $AdsTimeSlot->status = '1';
                    $AdsTimeSlot->day = 'Monday';
                    $AdsTimeSlot->advertiser_id = session('advertiser_id');
                    $AdsTimeSlot->save();
                }
            }
        }

        if ($request->tuesday_start_time != null && $request->Tuesday_end_time != null) {
            $tuesday_start_time = count($request['tuesday_start_time']);

            foreach ($tuesday as $date) {
                for ($i = 0; $i < $tuesday_start_time; $i++) {
                    $AdsTimeSlot = new AdsEvent();
                    $AdsTimeSlot->start = $date->format('Y-m-d') . ' ' . $request['tuesday_start_time'][$i];
                    $AdsTimeSlot->end = $date->format('Y-m-d') . ' ' . $request['Tuesday_end_time'][$i];
                    $AdsTimeSlot->ads_category_id = $request->ads_category;
                    $AdsTimeSlot->ads_id = $last_ads_id;
                    $AdsTimeSlot->title = $last_ads_name;
                    $AdsTimeSlot->day = 'Tuesday';
                    $AdsTimeSlot->status = '1';
                    $AdsTimeSlot->advertiser_id = session('advertiser_id');
                    $AdsTimeSlot->save();
                }
            }
        }

        if ($request->wednesday_start_time != null && $request->wednesday_end_time != null) {
            $wednesday_start_time = count($request['wednesday_start_time']);

            foreach ($wednesday as $date) {
                for ($i = 0; $i < $wednesday_start_time; $i++) {
                    $AdsTimeSlot = new AdsEvent();
                    $AdsTimeSlot->start = $date->format('Y-m-d') . ' ' . $request['wednesday_start_time'][$i];
                    $AdsTimeSlot->end = $date->format('Y-m-d') . ' ' . $request['wednesday_end_time'][$i];
                    $AdsTimeSlot->ads_category_id = $request->ads_category;
                    $AdsTimeSlot->ads_id = $last_ads_id;
                    $AdsTimeSlot->title = $last_ads_name;
                    $AdsTimeSlot->status = '1';
                    $AdsTimeSlot->day = 'Wednesday';
                    $AdsTimeSlot->advertiser_id = session('advertiser_id');
                    $AdsTimeSlot->save();
                }
            }
        }

        if ($request->thursday_start_time != null && $request->thursday_end_time != null) {
            $thursday_start_time = count($request['thursday_start_time']);

            foreach ($thursday as $date) {
                for ($i = 0; $i < $thursday_start_time; $i++) {
                    $AdsTimeSlot = new AdsEvent();
                    $AdsTimeSlot->start = $date->format('Y-m-d') . ' ' . $request['thursday_start_time'][$i];
                    $AdsTimeSlot->end = $date->format('Y-m-d') . ' ' . $request['thursday_end_time'][$i];
                    $AdsTimeSlot->ads_category_id = $request->ads_category;
                    $AdsTimeSlot->ads_id = $last_ads_id;
                    $AdsTimeSlot->status = '1';
                    $AdsTimeSlot->day = 'Thursday';
                    $AdsTimeSlot->title = $last_ads_name;
                    $AdsTimeSlot->advertiser_id = session('advertiser_id');
                    $AdsTimeSlot->save();
                }
            }
        }

        if ($request->friday_start_time != null && $request->friday_end_time != null) {
            $friday_start_time = count($request['friday_start_time']);

            foreach ($friday as $date) {
                for ($i = 0; $i < $friday_start_time; $i++) {
                    $AdsTimeSlot = new AdsEvent();
                    $AdsTimeSlot->start = $date->format('Y-m-d') . ' ' . $request['friday_start_time'][$i];
                    $AdsTimeSlot->end = $date->format('Y-m-d') . ' ' . $request['friday_end_time'][$i];
                    $AdsTimeSlot->ads_category_id = $request->ads_category;
                    $AdsTimeSlot->ads_id = $last_ads_id;
                    $AdsTimeSlot->status = '1';
                    $AdsTimeSlot->title = $last_ads_name;
                    $AdsTimeSlot->day = 'Friday';
                    $AdsTimeSlot->advertiser_id = session('advertiser_id');
                    $AdsTimeSlot->save();
                }
            }
        }

        if ($request->saturday_start_time != null && $request->saturday_end_time != null) {
            $saturday_start_time = count($request['saturday_start_time']);

            foreach ($saturday as $date) {
                for ($i = 0; $i < $saturday_start_time; $i++) {
                    $AdsTimeSlot = new AdsEvent();
                    $AdsTimeSlot->start = $date->format('Y-m-d') . ' ' . $request['saturday_start_time'][$i];
                    $AdsTimeSlot->end = $date->format('Y-m-d') . ' ' . $request['saturday_end_time'][$i];
                    $AdsTimeSlot->ads_category_id = $request->ads_category;
                    $AdsTimeSlot->ads_id = $last_ads_id;
                    $AdsTimeSlot->title = $last_ads_name;
                    $AdsTimeSlot->status = '1';
                    $AdsTimeSlot->day = 'Saturday';
                    $AdsTimeSlot->advertiser_id = session('advertiser_id');
                    $AdsTimeSlot->save();
                }
            }
        }

        if ($request->sunday_start_time != null && $request->sunday_end_time != null) {
            $sunday_start_time = count($request['sunday_start_time']);

            foreach ($sunday as $date) {
                for ($i = 0; $i < $sunday_start_time; $i++) {
                    $AdsTimeSlot = new AdsEvent();
                    $AdsTimeSlot->start = $date->format('Y-m-d') . ' ' . $request['sunday_start_time'][$i];
                    $AdsTimeSlot->end = $date->format('Y-m-d') . ' ' . $request['sunday_end_time'][$i];
                    $AdsTimeSlot->ads_category_id = $request->ads_category;
                    $AdsTimeSlot->ads_id = $last_ads_id;
                    $AdsTimeSlot->title = $last_ads_name;
                    $AdsTimeSlot->status = '1';
                    $AdsTimeSlot->day = 'Sunday';
                    $AdsTimeSlot->advertiser_id = session('advertiser_id');
                    $AdsTimeSlot->save();
                }
            }
        }

        // $getdata = Advertiserplanhistory::where('advertiser_id',session('advertiser_id'))->where('status','active')->first();
        // $getdata->no_of_uploads += 1;
        // $getdata->save();

        return Redirect::to('advertiser/ads-list');
    }

    private function Ads_xml_file($data)
    {

        $Ads_videos = $data["ads_videos"] ;
        $ads_redirection_url = $data["ads_redirection_url"];
        
        $Ads_video_slug  =  Str::slug(pathinfo($Ads_videos->getClientOriginalName(), PATHINFO_FILENAME));
        $Ads_video_ext   = $Ads_videos->extension();

        $Ads_xml_filename = time() . '-' . $Ads_video_slug .'.xml';

        $Ads_upload_filename = time() . '-' . $Ads_video_slug .'.'. $Ads_video_ext;
        $Ads_videos->move( public_path('uploads/AdsVideos'), $Ads_upload_filename  );

        $Ads_upload_url = URL::to('public/uploads/AdsVideos/'.$Ads_upload_filename);

        $factory = new \Sokil\Vast\Factory();
        $document = $factory->create('4.1');

        $ad1 = $document
            ->createInLineAdSection()
            ->setId( Str::random(23) )
            ->setAdSystem( $Ads_upload_filename )
            ->setAdTitle(  $Ads_upload_filename );

        $linearCreative = $ad1
            ->createLinearCreative()
            ->setDuration(128)
            ->setId( Str::random(23) );
            // ->setAdId('pre-'.Str::random(23));

            if( $ads_redirection_url != null ){

                $linearCreative->setVideoClicksClickThrough($ads_redirection_url)
                                ->addVideoClicksClickTracking( $ads_redirection_url )
                                ->addVideoClicksCustomClick( $ads_redirection_url );
            }
          
            // ->addTrackingEvent('start', 'http://ad.server.com/trackingevent/start')
            // ->addTrackingEvent('pause', 'http://ad.server.com/trackingevent/stop');

        $linearCreative
            ->createMediaFile()
            ->setProgressiveDelivery()
            ->setType('video/mp4')
            ->setHeight(200)
            ->setWidth(200)
            ->setBitrate(2500)
            ->setUrl( $Ads_upload_url );

        $domDocument = $document->toDomDocument();
        $xml_file_url = URL::to('public/uploads/AdsVideos/'.$Ads_xml_filename) ;
        $xml_file    = public_path('uploads/AdsVideos/' . $Ads_xml_filename ) ;
        $domDocument->save($xml_file);

        $data = array(
            'Ads_xml_url' => $xml_file_url ,
            'Ads_upload_url' => $Ads_upload_url ,
        );

        return $data ;
    }

    public function Ads_edit(Request $request, $Ads_id)
    {
        try {

            if( empty(session('advertiser_id') ||  session('advertiser_id') == 'null' ) ){
                return Redirect::to('advertiser/login')->withError('Opps! You do not have access');
            }

            $Advertisement = Advertisement::where('id', $Ads_id)->first();

            $data = [
                'Advertisement' => $Advertisement,
                'post_route' => route('Ads_update', [$Ads_id]),
                'ads_category' => Adscategory::all(),
                'button_text'  => 'update',
                'AdsEvent'     => AdsEvent::where('ads_id',$Ads_id)->get(['start', 'end', 'day']),
            ];

            return view('avod::ads_edit', $data);

        } catch (\Throwable $th) {

            return abort(404);

        }
    }

    public function Ads_update(Request $request, $advertisement_id)
    {

        if( empty(session('advertiser_id') ||  session('advertiser_id') == 'null' ) ){
            return Redirect::to('advertiser/login')->withError('Opps! You do not have access');
        }

        $inputs = [
            'advertiser_id' => $advertisement_id,
            'ads_name' => $request->ads_name,
            'ads_category' => $request->ads_category,
            'ads_position' => $request->ads_position,
            'ads_upload_type' => $request->ads_upload_type,
            'age' => !empty($request->age) ? json_encode($request['age']) : ' ',
            'gender' => !empty($request['gender']) ? json_encode($request['gender']) : ' ',
            'status' => 0,
        ];

        if ($request->location == 'all_countries' || $request->location == 'India') {
            $inputs += ['location' => $request->location];
        } else {
            $inputs += ['location' => $request->locations];
        }

        if ( $request->ads_video != null && $request->ads_upload_type == "ads_video_upload" ) {
         
            $data = array (
                "ads_videos"            => $request->ads_video ,
                "ads_redirection_url"   => $request->ads_redirection_url ,
                "advertisement_id"      => $advertisement_id ,
            );

            $Ads_xml_file = $this->Ads_xml_file_update( $data );

            $inputs += ['ads_video' => $Ads_xml_file['Ads_upload_url'] ];
            $inputs += ['ads_path' => $Ads_xml_file['Ads_xml_url'] ];
            $inputs += ['ads_redirection_url' => $request->ads_redirection_url];
        }

        if ( $request->ads_upload_type == "tag_url" ) {
            $inputs += ['ads_video' => null ];
            $inputs += ['ads_path' => $request->ads_path ];
        }

        $Advertisement = Advertisement::find($advertisement_id)->update($inputs);

        return redirect()->back();
    }

    private function Ads_xml_file_update( $data )
    {
        
            $Ads_videos = $data["ads_videos"] ;
            $ads_redirection_url = $data["ads_redirection_url"];
            $advertisement_id = $data["advertisement_id"];

            $Advertisement = Advertisement::find($advertisement_id);

            $filename = pathinfo(parse_url($Advertisement->ads_video, PHP_URL_PATH), PATHINFO_FILENAME);

            if (File::exists(base_path('public/uploads/AdsVideos/'. $filename."xml"  ))) {
                File::delete(base_path('public/uploads/AdsVideos/'. $filename."xml"  ));
            }

            if (File::exists(base_path('public/uploads/AdsVideos/'. $filename."mp4"  ))) {
                File::delete(base_path('public/uploads/AdsVideos/'. $filename."mp4"  ));
            }

        
        $Ads_video_slug  =  Str::slug(pathinfo($Ads_videos->getClientOriginalName(), PATHINFO_FILENAME));
        $Ads_video_ext   = $Ads_videos->extension();

        $Ads_xml_filename = time() . '-' . $Ads_video_slug .'.xml';

        $Ads_upload_filename = time() . '-' . $Ads_video_slug .'.'. $Ads_video_ext;
        $Ads_videos->move( public_path('uploads/AdsVideos'), $Ads_upload_filename  );

        $Ads_upload_url = URL::to('public/uploads/AdsVideos/'.$Ads_upload_filename);


        $factory = new \Sokil\Vast\Factory();
        $document = $factory->create('4.1');

        $ad1 = $document
            ->createInLineAdSection()
            ->setId( Str::random(23) )
            ->setAdSystem( $Ads_upload_filename )
            ->setAdTitle(  $Ads_upload_filename );

        $linearCreative = $ad1
            ->createLinearCreative()
            ->setDuration(128)
            ->setId( Str::random(23) );
            // ->setAdId('pre-'.Str::random(23))

            if( $ads_redirection_url != null ){

                $linearCreative->setVideoClicksClickThrough($ads_redirection_url)
                                ->addVideoClicksClickTracking( $ads_redirection_url )
                                ->addVideoClicksCustomClick( $ads_redirection_url );
            }

            // ->addTrackingEvent('start', 'http://ad.server.com/trackingevent/start')
            // ->addTrackingEvent('pause', 'http://ad.server.com/trackingevent/stop');

        $linearCreative
            ->createMediaFile()
            ->setProgressiveDelivery()
            ->setType('video/mp4')
            ->setHeight(200)
            ->setWidth(200)
            ->setBitrate(2500)
            ->setUrl( $Ads_upload_url );

        $domDocument = $document->toDomDocument();
        $xml_file_url = URL::to('public/uploads/AdsVideos/'.$Ads_xml_filename) ;
        $xml_file    = public_path('uploads/AdsVideos/' . $Ads_xml_filename ) ;
        $domDocument->save($xml_file);

        $data = array(
            'Ads_xml_url' => $xml_file_url ,
            'Ads_upload_url' => $Ads_upload_url ,
        );

        return $data ;
    }

    public function Ads_delete($Ads_id)
    {
        try {

            if( empty(session('advertiser_id') ||  session('advertiser_id') == 'null' ) ){
                return Redirect::to('advertiser/login')->withError('Opps! You do not have access');
            }

            $Advertisement = Advertisement::find($Ads_id);

            $filename = pathinfo(parse_url($Advertisement->ads_video, PHP_URL_PATH), PATHINFO_FILENAME);

            if (File::exists(base_path('public/uploads/AdsVideos/'. $filename."xml"  ))) {
                File::delete(base_path('public/uploads/AdsVideos/'. $filename."xml"  ));
            }

            if (File::exists(base_path('public/uploads/AdsVideos/'. $filename."mp4"  ))) {
                File::delete(base_path('public/uploads/AdsVideos/'. $filename."mp4"  ));
            }

            $Advertisement->delete();

            AdsEvent::where('id', $Ads_id)->delete();

            return redirect()->back();

        } catch (\Throwable $th) {
            
            return abort(404);
        }
    }

    public function Cost_Per_View_Analysis()
    {
        try {

            if( empty(session('advertiser_id') ||  session('advertiser_id') == 'null' ) ){
                return Redirect::to('advertiser/login')->withError('Opps! You do not have access');
            }

            $data = AdsViewCount::select('ads_views_count.*', DB::raw('count(*) as view_count'))
                            ->where('adverister_id', session('advertiser_id') )->groupBy('adveristment_id')
                            ->whereNotNull('adveristment_id')->latest()
                            ->get();

            $response = array(
                'settings'  =>  Setting::first() ,
                'CPV_lists' =>  $data ,
            );

            return view('avod::CPV_Analysis', $response );

        } catch (\Throwable $th) {

            // return $th->getMessage();
            return abort(404);
        }
    }

    public function Cost_Per_Click_Analysis()
    {
        try {

            if( empty(session('advertiser_id') ||  session('advertiser_id') == 'null' ) ){
                return Redirect::to('advertiser/login')->withError('Opps! You do not have access');
            }

            $data = AdsRedirectionURLCount::select('ads_redirection_url_count.*', DB::raw('count(*) as view_count'))
                            ->where('adverister_id', session('advertiser_id') )->groupBy('adveristment_id')
                            ->whereNotNull('adveristment_id')->latest()
                            ->get();

            $response = array(
                'settings'  =>  Setting::first() ,
                'CPC_lists' =>  $data ,
            );

            return view('avod::CPC_Analysis', $response);
    
        } catch (\Throwable $th) {

            // return $th->getMessage();
            return abort(404);
        }
    }

    public function Specific_Ads_Cost_Per_Click_Analysis(Request $request,$Ads_id)
    {
        try {

            if( empty(session('advertiser_id') ||  session('advertiser_id') == 'null' ) ){
                return Redirect::to('advertiser/login')->withError('Opps! You do not have access');
            }

            $data = AdsRedirectionURLCount::where('adveristment_id',$Ads_id)->where('adverister_id', session('advertiser_id') )
                            ->whereNotNull('adveristment_id')->latest()
                            ->get()->map(function ($item) {
                                $item['user_name'] = User::where('id', $item->user)->pluck('name')->first();
                               
                                if( $item->source_type == "videos" ) {
                                    $item['source_name'] = Video::where('id', $item->source_id )->pluck('title')->first();
                                }elseif(  $item->source_type == "livestream"  ){
                                    $item['source_name'] = LiveStream::where('id', $item->source_id )->pluck('title')->first();
                                }elseif(  $item->source_type == "Episode"  ){
                                    $item['source_name'] = Episode::where('id', $item->source_id )->pluck('title')->first();
                                }else{
                                    $item['source_name'] = "-";
                                }

                                return $item;
                            });


            $response = array(
                'settings'  =>  Setting::first() ,
                'CPC_lists' =>  $data ,
            );

            return view('avod::Specific_Ads_CPC_Analysis', $response);
    
        } catch (\Throwable $th) {

            return $th->getMessage();
            return abort(404);
        }
    }

    public function Specific_Ads_Cost_Per_View_Analysis(Request $request,$Ads_id)
    {
        try {

            if( empty(session('advertiser_id') ||  session('advertiser_id') == 'null' ) ){
                return Redirect::to('advertiser/login')->withError('Opps! You do not have access');
            }
                            
            $data = AdsViewCount::where('adveristment_id',$Ads_id)->where('adverister_id', session('advertiser_id') )
                                ->whereNotNull('adveristment_id')->latest()
                                ->get()->map(function ($item) {
                                    $item['user_name'] = User::where('id', $item->user)->pluck('name')->first();
                                   
                                    if( $item->source_type == "videos" ) {
                                        $item['source_name'] = Video::where('id', $item->source_id )->pluck('title')->first();
                                    }elseif(  $item->source_type == "livestream"  ){
                                        $item['source_name'] = LiveStream::where('id', $item->source_id )->pluck('title')->first();
                                    }elseif(  $item->source_type == "Episode"  ){
                                        $item['source_name'] = Episode::where('id', $item->source_id )->pluck('title')->first();
                                    }else{
                                        $item['source_name'] = "-";
                                    }
                                    return $item;
                                });


            $response = array(
                'settings'  =>  Setting::first() ,
                'CPV_lists' =>  $data ,
            );

            return view('avod::Specific_Ads_CPV_Analysis', $response);
    
        } catch (\Throwable $th) {

            return $th->getMessage();
            return abort(404);
        }
    }
}
?>
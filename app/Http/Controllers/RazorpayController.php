<?php

namespace App\Http\Controllers;

use URL;
use Auth;
use Theme;
use App\User;
use App\Video;
use App\Series;
use App\Channel;
use App\Setting;
use App\SiteLogs;
use Carbon\Carbon;
use Log;
use App\LiveStream;
use App\HomeSetting;
use App\PpvPurchase;
use App\LivePurchase;
use App\SeriesSeason;
use App\Subscription;
use Razorpay\Api\Api;
use App\ChannelPayout;
use App\ModeratorsUser;
use App\PaymentSetting;
use App\ModeratorPayout;
use App\VideoCommission;
use App\ThemeIntegration;
use \Redirect as Redirect;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Notification;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Encryption\DecryptException;
use AmrShawky\LaravelCurrency\Facade\Currency as PaymentCurreny;

class RazorpayController extends Controller
{
    protected $razorpaykeyId;
    protected $razorpaykeysecret;
    protected $Theme;

    public function __construct()
    {
        $PaymentSetting = PaymentSetting::where('payment_type', 'Razorpay')->first();

        if ($PaymentSetting != null) {

            if ($PaymentSetting->live_mode == 0) {
                $this->razorpaykeyId = $PaymentSetting->test_publishable_key;
                $this->razorpaykeysecret = $PaymentSetting->test_secret_key;
            } else {
                $this->razorpaykeyId = $PaymentSetting->live_publishable_key;
                $this->razorpaykeysecret = $PaymentSetting->live_secret_key;
            }
        } else {
            $Error_msg = "Razorpay Key is Missing";
            $url = URL::to('/home');
            echo "<script type='text/javascript'>alert('$Error_msg'); window.location.href = '$url' </script>";
        }

        $this->Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses($this->Theme);
    }

    public function Razorpay(Request $request)
    {
        return Theme::view('Razorpay.create');
    }

    public function Razorpay_authorization_url(Request $request)
    {

        try {

            $Crypt_Razorpay_plan_id = Crypt::encryptString($request->Razorpay_plan_id);
            $authorization_url = URL::to('RazorpayIntegration/' . $Crypt_Razorpay_plan_id);

            $response = array(
                'status' => true,
                'message' => "Authorization url Successfully Created !",
                'Razorpay_plan_id' => $request->Razorpay_plan_id,
                'authorization_url' => $authorization_url,
            );
        } catch (\Throwable $th) {

            $response = array(
                "status" => false,
                "message" => $th->getMessage(),
            );
        }

        return response()->json($response, 200);
    }

    public function RazorpayIntegration(Request $request, $Plan_Id)
    {
        try {

            $Subscription = Subscription::create([
                'user_id' => Auth::user()->id,
                'stripe_plan' => $Plan_Id,
                'PaymentGateway' => 'Razorpay',
                'platform' => 'WebSite',
                'stripe_status' => 'hold',
            ]);

            $Subscription_primary_id = $Subscription->id;

            $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
            $countryName = $geoip->getCountry();
            $regionName = $geoip->getregion();
            $cityName = $geoip->getcity();

            $users_details = Auth::User();

            if ($users_details != null) {
                $user_details = Auth::User();
                $redirection_back = URL::to('/becomesubscriber');
            } else {
                $userEmailId = $request->session()->get('register.email');
                $user_details = User::where('email', $userEmailId)->first();
                $redirection_back = URL::to('/register2');
            }

            $plan_Id = Crypt::decryptString($Plan_Id);
            $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);
            $planId = $api->plan->fetch($plan_Id);

            $subscription = $api->subscription->create(array(
                'plan_id' => $planId->id,
                'customer_notify' => 1,
                'total_count' => 6,
            ));

            $respond = array(
                'razorpaykeyId' => $this->razorpaykeyId,
                'name' => $planId['item']->name,
                'subscriptionId' => $subscription->id,
                'short_url' => $subscription->short_url,
                'currency' => 'INR',
                'email' => $user_details['email'],
                'contactNumber' => $user_details['mobile'],
                'user_id' => $user_details->id,
                'user_name' => $user_details->name,
                'address' => $cityName,
                'description' => null,
                'countryName' => $countryName,
                'regionName' => $regionName,
                'cityName' => $cityName,
                'PaymentGateway' => 'razorpay',
                'redirection_back' => $redirection_back,
                'Subscription_primary_id' => $Subscription_primary_id
            );

            return Theme::view('Razorpay.checkout', compact('respond'), $respond);

        } catch (\Throwable $th) {
            // dd($th->getMessage());

            return abort(404);
        }
    }

    public function RazorpayCompleted(Request $request)
    {
        $SignatureStatus = $this->RazorpaySignatureVerfiy(
            $request->razorpay_payment_id,
            $request->razorpay_subscription_id,
            $request->razorpay_signature
        );

        if ($SignatureStatus == true) {
            $userId = $request->user_id;
            $RazorpaySubscription = $request->razorpay_subscription_id;
            $RazorpayPayment_ID = $request->razorpay_payment_id;
            $Subscription_primary_id = $request->Subscription_primary_id;
            return Redirect::route('RazorpaySubscriptionStore', ['RazorpaySubscription' => $RazorpaySubscription, 'userId' => $userId, 'RazorpayPayment_ID' => $RazorpayPayment_ID, 'Subscription_primary_id' => $Subscription_primary_id]);
        } else {
            echo 'fails';
        }
    }

    private function RazorpaySignatureVerfiy($razorpay_payment_id, $razorpay_subscription_id, $razorpay_signature)
    {
        try {
            $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);
            $attributes = array('razorpay_signature' => $razorpay_signature, 'razorpay_payment_id' => $razorpay_payment_id, 'razorpay_subscription_id' => $razorpay_subscription_id);
            $order = $api->utility->verifyPaymentSignature($attributes);
            return true;

        } catch (\Exception $e) {
            return false;
        }
    }

    public function RazorpaySubscriptionStore(Request $request)
    {

        $razorpay_subscription_id = $request->RazorpaySubscription;
        $razorpaypayment_id = $request->RazorpayPayment_ID;

        $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);
        $subscription = $api->subscription->fetch($razorpay_subscription_id);
        $plan_id = $api->plan->fetch($subscription['plan_id']);

        $Sub_Startday = Carbon::createFromTimestamp($subscription['current_start'])->toDateTimeString();
        $Sub_Endday = Carbon::createFromTimestamp($subscription['current_end'])->toDateTimeString();
        $trial_ends_at = Carbon::createFromTimestamp($subscription['current_end'])->toDateTimeString();

        Subscription::find($request->Subscription_primary_id)->update([
            'user_id' => $request->userId,
            'name' => $plan_id['item']->name,
            // 'days'        =>  $fileName_zip,
            'price' => $plan_id['item']->amount / 100,   // Amount Paise to Rupees
            'stripe_id' => $subscription['id'],
            'stripe_status' => $subscription['status'],
            'stripe_plan' => $subscription['plan_id'],
            'quantity' => $subscription['quantity'],
            'countryname' => $request->countryName,
            'regionname' => $request->cityName,
            'cityname' => $request->regionName,
            'PaymentGateway' => 'Razorpay',
            'trial_ends_at' => $trial_ends_at,
            'ends_at' => $trial_ends_at,
            'platform' => 'WebSite',
            'payment_id' => $razorpaypayment_id,
        ]);

        User::where('id', $request->userId)->update([
            'role' => 'subscriber',
            'stripe_id' => $subscription['id'],
            'subscription_start' => $Sub_Startday,
            'subscription_ends_at' => $Sub_Endday,
            'payment_gateway' => 'Razorpay',
            'payment_type' => 'recurring',
            'payment_status' => 'active',
        ]);

        return Redirect::route('home');
    }

    public function RazorpaySubscriptionUpdate(Request $request, $planId)
    {

        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
        $countryName = $geoip->getCountry();
        $regionName = $geoip->getregion();
        $cityName = $geoip->getcity();

        $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);
        $plan_Id = $api->plan->fetch($planId);
        $user_id = Auth::User()->id;

        $subscriptionId = Subscription::where('user_id', $user_id)->latest()->pluck('stripe_id')->first();

        $subscription = $api->subscription->fetch($subscriptionId);
        $remaining_count = $subscription['remaining_count'];

        $Sub_Startday = Carbon::createFromTimestamp($subscription['current_start'])->toDateTimeString();
        $Sub_Endday = Carbon::createFromTimestamp($subscription['current_end'])->toDateTimeString();
        $trial_ends_at = Carbon::createFromTimestamp($subscription['current_end'])->toDateTimeString();

        if ($subscription->payment_method != "upi") {

            $options = array('plan_id' => $plan_Id['id'], 'remaining_count' => $remaining_count);
            $api->subscription->fetch($subscriptionId)->update($options);

            $UpdatedSubscription = $api->subscription->fetch($subscriptionId);
            $updatedPlan = $api->plan->fetch($UpdatedSubscription['plan_id']);
            if (is_null($subscriptionId)) {
                return false;
            } else {
                Subscription::where('user_id', $user_id)->latest()->update([
                    'price' => $updatedPlan['item']->amount,
                    'stripe_id' => $UpdatedSubscription['id'],
                    'stripe_status' => $UpdatedSubscription['status'],
                    'stripe_plan' => $UpdatedSubscription['plan_id'],
                    'quantity' => $UpdatedSubscription['quantity'],
                    'countryname' => $countryName,
                    'regionname' => $regionName,
                    'cityname' => $cityName,
                    'trial_ends_at' => $trial_ends_at,
                    'ends_at' => $trial_ends_at,
                    'PaymentGateway' => 'Razorpay',
                ]);

                User::where('id', $user_id)->update([
                    'role' => 'subscriber',
                    'stripe_id' => $UpdatedSubscription['id'],
                    'subscription_start' => $Sub_Startday,
                    'subscription_ends_at' => $Sub_Endday,
                    'payment_gateway' => 'Razorpay',
                    'payment_type' => 'recurring',
                    'payment_status' => 'active',
                ]);
            }
            return Redirect::route('home');
        } else {
            return Theme::view('Razorpay.UPI');
        }
    }

    public function RazorpayCancelSubscriptions(Request $request)
    {
        try {

            $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);

            $subscriptionId = User::where('id', Auth::user()->id)->where('payment_gateway', 'Razorpay')->pluck('stripe_id')->first();

            $options = array('cancel_at_cycle_end' => 0);

            $api->subscription->fetch($subscriptionId)->cancel($options);

            Subscription::where('stripe_id', $subscriptionId)->update([
                'stripe_status' => 'Cancelled',
            ]);

            User::where('id', Auth::user()->id)->update([
                'payment_status' => 'Cancel',
                'role' => 'registered',
            ]);

            $Error_msg = "Subscription has been Cancel Successfully";
            $url = URL::to('/myprofile');
            echo "<script type='text/javascript'>alert('$Error_msg'); window.location.href = '$url' </script>";


        } catch (\Throwable $th) {
            $msg = 'Some Error occuring while Cancelling the Subscription, Please check this query with admin..';
            $url = URL::to('myprofile/');
            echo "<script type='text/javascript'>alert('$msg'); window.location.href = '$url' </script>";
        }

    }

    public function RazorpayVideoRent(Request $request, $video_id)
    {
        $video = Video::where('id', '=', $video_id)->first();
        $amount = $video->ppv_price;

        $setting = Setting::first();

        if (!empty($video)) {
            $moderators_id = $video->user_id;
        }
        $commission_btn = $setting->CPP_Commission_Status;
        $CppUser_details = ModeratorsUser::where('id', $moderators_id)->first();
        $video_commission_percentage = VideoCommission::where('type', 'Cpp')->pluck('percentage')->first();
        $commission_percentage_value = $video->CPP_commission_percentage;
        if ($commission_btn === 0) {
            $commission_percentage_value = !empty($CppUser_details->commission_percentage) ? $CppUser_details->commission_percentage : $video_commission_percentage;
        }

        // Commission calculation for display purposes only - not saved yet
        if (!empty($moderators_id)) {
            $moderator = ModeratorsUser::where('id', $moderators_id)->first();
            if ($moderator) {
                $percentage = $moderator->commission_percentage ? $moderator->commission_percentage : 0;
            } else {
                $percentage = 0;
            }
            $total_amount = $video->ppv_price;
            $title = $video->title;
            $commssion = VideoCommission::where('type', 'CPP')->first();
            $ppv_price = $amount;
            $moderator_commssion = ($ppv_price * $commission_percentage_value) / 100;
            $admin_commssion = $ppv_price - $moderator_commssion;
            $moderator_id = $moderators_id;
        } else {
            $total_amount = $video->ppv_price;
            $title = $video->title;
            $commssion = VideoCommission::where('type', 'CPP')->first();
            $percentage = null;
            $ppv_price = $video->ppv_price;
            $admin_commssion = null;
            $moderator_commssion = null;
            $moderator_id = null;
        }

        // REMOVED: Premature database record creation
        // Database entries should only be created after payment completion

        $recept_id = Str::random(10);
        $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);

        $orderData = [
            'receipt' => $recept_id,
            'amount' => $amount * 100,
            'currency' => 'INR',
            'payment_capture' => 1,
            'notes' => [
                'video_id' => $request->video_id,
                'ppv_plan' => $request->ppv_plan,
                'user_id' => Auth::user()->id,
                'platform' => 'website'
            ],
        ];

        $razorpayOrder = $api->order->create($orderData);
        $plainAmount = $amount * 100;
        $encryptedAmount = encrypt($plainAmount);

        $response = array(
            'razorpaykeyId' => $this->razorpaykeyId,
            'name' => Auth::user()->name ? Auth::user()->name : null,
            'user_id' => Auth::user()->id ? Auth::user()->id : null,
            'currency' => 'INR',
            'amount' => $plainAmount,
            'encrypted_amount' => $encryptedAmount,
            'orderId' => $razorpayOrder['id'],
            'video_id' => $request->video_id,
            'description' => null,
            'address' => null,
            'Video_slug' => $video->slug,
            'ppv_plan' => $request->ppv_plan
        );

        return Theme::view('Razorpay.video_rent_checkout', compact('response'), $response);
    }

    public function RazorpayLiveRent(Request $request, $live_id)
    {
        $live_stream = LiveStream::findOrFail($live_id);
        $amount = (float) $live_stream->ppv_price;

        Log::info('Attempting to create Razorpay order for live_event_id: ' . $live_id . ' with amount: ' . $amount);
        Log::info('Razorpay Key ID: ' . $this->razorpaykeyId);
        Log::info('Razorpay Key Secret: ' . substr($this->razorpaykeysecret, 0, 10) . '...');

        // Check if keys are valid
        if (empty($this->razorpaykeyId) || empty($this->razorpaykeysecret)) {
            Log::error('Razorpay keys are empty or invalid');
            abort(500, 'Payment gateway configuration error. Please contact support.');
        }

        if ($amount < 1) {
            Log::error('Live event purchase failed: Amount ' . $amount . ' is less than the minimum required amount of 1.');
            abort(400, 'The price for this item is invalid. It must be at least ₹1.00.');
        }

        $setting = Setting::first();
        $moderator_id = $live_stream->user_id;

        // Commission calculation logic adapted for live events
        if (!empty($moderator_id)) {
            $moderator = ModeratorsUser::find($moderator_id);
            $commission_percentage = $moderator->commission_percentage ?? 0;
            $moderator_commssion = ($amount * $commission_percentage) / 100;
            $admin_commssion = $amount - $moderator_commssion;
        } else {
            $moderator_commssion = null;
            $admin_commssion = null;
        }

        $recept_id = Str::random(10);
        $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);

        $orderData = [
            'receipt' => $recept_id,
            'amount' => $amount * 100,
            'currency' => 'INR',
            'payment_capture' => 1,
            'notes' => [
                'live_event_id' => $live_id,
                'purchase_type' => 'live_event',
                'ppv_plan' => $request->ppv_plan, // Assuming this might be passed
                'user_id' => Auth::user()->id,
                'platform' => 'website'
            ],
        ];

        $razorpayOrder = $api->order->create($orderData);
        $plainAmount = $amount * 100;

        $response = array(
            'razorpaykeyId' => $this->razorpaykeyId,
            'name' => Auth::user()->name ?? null,
            'user_id' => Auth::user()->id ?? null,
            'currency' => 'INR',
            'amount' => $plainAmount,
            'orderId' => $razorpayOrder['id'],
            'live_event_id' => $live_id,
            'description' => $live_stream->title,
            'address' => null,
            'Video_slug' => $live_stream->slug, // Assuming LiveStream has a slug
            'ppv_plan' => $request->ppv_plan
        );

        // Use the dedicated checkout view for live events
        return Theme::view('Razorpay.live_event_rent_checkout', compact('response'), $response);
    }

    /**
     * Check if a status transition is valid
     * 
     * @param string|null $currentStatus Current payment status
     * @param string $newStatus New payment status
     * @return bool Whether the transition is valid
     */
    private function isValidStatusTransition($currentStatus, $newStatus)
    {
        $validTransitions = [
            null => ['captured', 'failed'],
            'captured' => ['refunded', 'failed'], 
            'failed' => [] // Terminal state
        ];

        return isset($validTransitions[$currentStatus]) &&
            in_array($newStatus, $validTransitions[$currentStatus]);
    }

    /**
     * Retry failed payment capture with exponential backoff
     * 
     * @param string $paymentId Razorpay payment ID
     * @param int $attempt Current attempt number
     * @param int $maxAttempts Maximum number of attempts
     * @return bool Success status
     */
    private function retryPaymentCapture($paymentId, $attempt = 1, $maxAttempts = 3)
    {
        if ($attempt > $maxAttempts) {
            \Log::error("Razorpay: Max capture retry attempts reached for payment {$paymentId}");
            return false;
        }

        try {
            // Exponential backoff - wait longer between each retry
            $backoffSeconds = pow(2, $attempt - 1);
            if ($attempt > 1) {
                sleep($backoffSeconds);
            }

            $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);
            $payment = $api->payment->fetch($paymentId);

            // Only attempt capture if not already captured
            if ($payment->status !== 'captured') {
                $payment->capture(['amount' => $payment->amount]);
                \Log::info("Razorpay: Successfully captured payment {$paymentId} on attempt {$attempt}");
                return true;
            }

            \Log::info("Razorpay: Payment {$paymentId} already captured");
            return true;
        } catch (\Exception $e) {
            \Log::warning("Razorpay: Capture retry attempt {$attempt} failed for payment {$paymentId}: {$e->getMessage()}");

            // Retry with incrementing attempt counter
            return $this->retryPaymentCapture($paymentId, $attempt + 1, $maxAttempts);
        }
    }

    public function RazorpayVideoRent_Payment(Request $request)
    {
        DB::beginTransaction();
        try {
            $decryptedAmount = decrypt($request->amount);
            $setting = Setting::first();
            $ppv_hours = $setting->ppv_hours;
            $d = new \DateTime('now');
            $d->setTimezone(new \DateTimeZone('Asia/Kolkata'));
            $now = $d->format('Y-m-d h:i:s a');
            $to_time = date('Y-m-d h:i:s a', strtotime('+' . $ppv_hours . ' hour', strtotime($now)));

            // Verify payment with Razorpay
            $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);

            $attributes = [
                'razorpay_signature' => $request->rzp_signature,
                'razorpay_payment_id' => $request->rzp_paymentid,
                'razorpay_order_id' => $request->rzp_orderid
            ];

            // This will throw an exception if signature verification fails
            $order = $api->utility->verifyPaymentSignature($attributes);

            // Fetch payment details
            $payment = $api->payment->fetch($request->rzp_paymentid);

            // Attempt to capture if not already captured with retry mechanism
            if ($payment->status !== 'captured') {
                $captureSuccess = false;
                try {
                    $captureSuccess = $this->retryPaymentCapture($request->rzp_paymentid);
                    if (!$captureSuccess) {
                        throw new \Exception("Failed to capture payment after multiple attempts");
                    }
                    // Refresh payment data after capture
                    $payment = $api->payment->fetch($request->rzp_paymentid);
                } catch (\Exception $captureError) {
                    \Log::error('Razorpay capture failed after retries: ' . $captureError->getMessage(), [
                        'payment_id' => $request->rzp_paymentid
                    ]);
                    throw $captureError;
                }
            }

            $payment_status = $payment->status;

            // Find existing purchase record using multiple criteria with locking
            $purchase = null;

            // 1. Try by payment_id
            $purchase = \App\PpvPurchase::where('payment_id', $request->rzp_paymentid)
                ->lockForUpdate()
                ->first();

            // 2. Try by order_id
            if (!$purchase) {
                $purchase = \App\PpvPurchase::where('payment_id', $request->rzp_orderid)
                    ->lockForUpdate()
                    ->first();
            }

            // 3. Try by video_id and user_id with recent timestamp
            if (!$purchase && $request->video_id && $request->user_id) {
                $purchase = \App\PpvPurchase::where([
                    ['video_id', '=', $request->video_id],
                    ['user_id', '=', $request->user_id]
                ])
                    ->where('created_at', '>=', now()->subMinutes(15))
                    ->orderBy('created_at', 'desc')
                    ->lockForUpdate()
                    ->first();
            }

            // Create new record if none found
            if (!$purchase) {
                $purchase = new \App\PpvPurchase();
            } else if (!$this->isValidStatusTransition($purchase->status, $payment_status)) {
                \Log::warning("Invalid status transition from {$purchase->status} to {$payment_status}", [
                    'payment_id' => $request->rzp_paymentid,
                    'purchase_id' => $purchase->id
                ]);
                // Continue anyway since this is frontend callback and user is waiting
            }

            // Update purchase record
            //     $title               =  $video->title;
            //     $commssion           =  VideoCommission::where('type','CPP')->first();
            //     $ppv_price           =  $request->amount/100;
            //     $moderator_commssion =  ($ppv_price * $commission_percentage_value) / 100;
            //     $admin_commssion     =  $ppv_price - $moderator_commssion;
            //     $moderator_id        =  $moderators_id;
            // }
            // else
            // {
            //     $total_amount = $video->ppv_price;
            //     $title =  $video->title;
            $purchase->user_id = $request->user_id;
            $purchase->video_id = $request->video_id;
            $purchase->total_amount = $decryptedAmount / 100;
            $purchase->status = $payment_status;
            $purchase->to_time = $to_time;
            $purchase->platform = 'website';
            $purchase->payment_id = $request->rzp_paymentid;
            $purchase->payment_gateway = 'razorpay';
            $purchase->save();

            // Log successful payment
            \Log::info('Razorpay payment successful', [
                'payment_id' => $request->rzp_paymentid,
                'purchase_id' => $purchase->id,
                'status' => $payment_status
            ]);

            SiteLogs::create([
                'level' => 'success,' . $purchase->status,
                'message' => 'Razorpay video rent payment stored successfully!',
                'context' => 'RazorpayVideoRent_Payment'
            ]);

            DB::commit();

            $video = Video::find($request->video_id);
            $video_slug = $video ? $video->slug : null;

            \Log::info('RazorpayVideoRent_Payment redirect debug:', [
                'video_id' => $request->video_id,
                'video_found' => $video ? 'yes' : 'no',
                'video_slug' => $video_slug,
                'video_title' => $video ? $video->title : 'N/A'
            ]);

            $redirect_url = $video_slug ? URL::to('category/videos/' . $video_slug) : URL::to('home');

            \Log::info('Final redirect URL:', [
                'redirect_url' => $redirect_url
            ]);

            return view('Razorpay.Rent_message', [
                'respond' => [
                    'status' => 'true',
                    'redirect_url' => $redirect_url
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollback();

            // Log the error
            \Log::error('Razorpay payment error: ' . $e->getMessage(), [
                'payment_id' => $request->rzp_paymentid ?? null,
                'trace' => $e->getTraceAsString()
            ]);

            SiteLogs::create([
                'level' => 'fails',
                'message' => 'Payment failed: ' . $e->getMessage(),
                'context' => 'RazorpayVideoRent_Payment'
            ]);

            return Theme::view('Razorpay.Rent_message', [
                'respond' => ['status' => 'false']
            ]);
        }
    }

    public function RazorpayVideoRent_Paymentfailure(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'payment_id' => 'nullable|string',
                'order_id' => 'nullable|string',
                'video_id' => 'nullable|integer',
                'user_id' => 'nullable|integer',
                'amount' => 'nullable|numeric',
                'error_description' => 'nullable|string',
            ]);

            $setting = Setting::first();
            $ppv_hours = $setting->ppv_hours;

            $d = new \DateTime('now');
            $d->setTimezone(new \DateTimeZone('Asia/Kolkata'));
            $now = $d->format('Y-m-d h:i:s a');
            $time = date('h:i:s', strtotime($now));
            $to_time = date('Y-m-d h:i:s a', strtotime('+' . $ppv_hours . ' hour', strtotime($now)));

            $paymentId = $validatedData['payment_id'] ?? $validatedData['order_id'];

            $existingPurchase = PpvPurchase::where('payment_id', $paymentId)->first();

            if ($existingPurchase) {
                return response()->json(['status' => 'already_logged']);
            }

            $video = Video::where('id', '=', $validatedData['video_id'])->first();
            $moderators_id = null;

            if (!empty($video)) {
                $moderators_id = $video->user_id;
            }

            $commission_btn = $setting->CPP_Commission_Status;
            $CppUser_details = ModeratorsUser::where('id', $moderators_id)->first();
            $video_commission_percentage = VideoCommission::where('type', 'Cpp')->pluck('percentage')->first();
            $commission_percentage_value = $video->CPP_commission_percentage;

            if ($commission_btn === 0) {
                $commission_percentage_value = !empty($CppUser_details->commission_percentage) ? $CppUser_details->commission_percentage : $video_commission_percentage;
            }
            if (!empty($moderators_id)) {
                $moderator = ModeratorsUser::where('id', $moderators_id)->first();
                if ($moderator) {
                    $percentage = $moderator->commission_percentage ? $moderator->commission_percentage : 0;
                } else {
                    $percentage = 0;
                }
                $total_amount = $video->ppv_price;
                $title = $video->title;
                $commssion = VideoCommission::where('type', 'CPP')->first();
                $ppv_price = $validatedData['amount'] / 100;
                $moderator_commssion = ($ppv_price * $commission_percentage_value) / 100;
                $admin_commssion = $ppv_price - $moderator_commssion;
                $moderator_id = $moderators_id;
            } else {
                $total_amount = $video->ppv_price;
                $title = $video->title;
                $commssion = VideoCommission::where('type', 'CPP')->first();
                $percentage = null;
                $ppv_price = $video->ppv_price;
                $admin_commssion = null;
                $moderator_commssion = null;
                $moderator_id = null;
            }

            // Create new failed purchase record instead of trying to find existing one
            $purchase = new PpvPurchase();
            $purchase->user_id = $validatedData['user_id'];
            $purchase->video_id = $validatedData['video_id'];
            $purchase->total_amount = $validatedData['amount'] / 100;
            $purchase->admin_commssion = null; // Don't set commission for failed payments
            $purchase->moderator_commssion = null; // Don't set commission for failed payments
            $purchase->status = 'failed';
            $purchase->payment_failure_reason = $validatedData['error_description'] ?? 'Unknown error';
            $purchase->platform = 'website';
            $purchase->to_time = null; // No access time for failed payments
            $purchase->payment_id = $paymentId;
            $purchase->payment_gateway = 'razorpay';
            $purchase->save();

            SiteLogs::create([
                'level' => 'success',
                'message' => 'Razorpay video rent payment failure stored successfully! ' . $paymentId,
                'context' => 'RazorpayVideoRent_Paymentfailure'
            ]);

            return response()->json(['status' => 'failure_logged']);
        } catch (\Exception $e) {
            SiteLogs::create([
                'level' => 'fails',
                'message' => $e->getMessage(),
                'context' => 'RazorpayVideoRent_Paymentfailure'
            ]);

            return response()->json(['status' => 'error', 'message' => 'An error occurred while processing the payment failure.']);
        }
    }


    public function RazorpayLiveRent_Payment(Request $request)
    {
        try {
            Log::info('Razorpay payment received', [
                'platform' => $request->platform ?? 'unknown',
                'user_id' => $request->user_id,
                'video_id' => $request->video_id,
                'amount' => $request->amount,
                'payment_id' => $request->rzp_paymentid
            ]);

            $setting = Setting::first();
            $ppv_hours = $setting->ppv_hours;

            $d = new \DateTime('now');
            $d->setTimezone(new \DateTimeZone('Asia/Kolkata'));
            $now = $d->format('Y-m-d h:i:s a');
            $time = date('h:i:s', strtotime($now));
            $to_time = date('Y-m-d h:i:s a', strtotime('+' . $ppv_hours . ' hour', strtotime($now)));

            $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);

            $attributes = array(
                'razorpay_signature' => $request->rzp_signature,
                'razorpay_payment_id' => $request->rzp_paymentid,
                'razorpay_order_id' => $request->rzp_orderid
            );
            $order = $api->utility->verifyPaymentSignature($attributes);

            $payment = $api->payment->fetch($request->rzp_paymentid);

            if ($payment->status !== 'captured') {
                $payment->capture(['amount' => $payment->amount]);
            }
            $payment_status = $payment->status;

            Log::info('Payment verified successfully', ['payment_status' => $payment_status]);

            // Use the correct table: live_purchases
            $purchase = LivePurchase::updateOrCreate(
                [
                    'payment_id' => $request->rzp_orderid, // Razorpay Order ID
                    'user_id' => $request->user_id,
                    'video_id' => $request->video_id, // live_purchases uses video_id
                ],
                [
                    'ppv_plan' => $request->ppv_plan ?? 'default',
                    'total_amount' => $request->get('amount') / 100,
                    'payment_gateway' => 'razorpay',
                    'payment_status' => $payment_status, // 'captured' or 'failed'
                    'platform' => $request->platform ?? 'website',
                    'status' => 1, // live_purchases uses integer status
                    'amount' => $request->get('amount') / 100,
                    'to_time' => $to_time,
                    'expired_date' => $to_time,
                ]
            );

            Log::info('LivePurchase record created/updated', ['purchase_id' => $purchase->id]);

            $respond = array(
                'status' => 'true',
                'redirect_url' => URL::to('/live/' . ($request->video_slug ?? $request->video_id))
            );
            
            SiteLogs::create([
                'level' => 'success',
                'message' => 'Razorpay live rent payment stored successfully! User: ' . $request->user_id . ', Live: ' . $request->video_id,
                'context' => 'RazorpayLiveRent_Payment'
            ]);

            Log::info('Payment process completed successfully');

            return Theme::view('Razorpay.Rent_message', compact('respond'), $respond);

        } catch (\Exception $e) {
            Log::error('Razorpay payment error: ' . $e->getMessage(), [
                'user_id' => $request->user_id ?? 'unknown',
                'video_id' => $request->video_id ?? 'unknown',
                'trace' => $e->getTraceAsString()
            ]);
            
            $respond = array(
                'status' => 'false',
                'redirect_url' => URL::to('/live/' . ($request->video_slug ?? $request->video_id ?? 'home'))
            );

            SiteLogs::create([
                'level' => 'error',
                'message' => 'Razorpay payment failed: ' . $e->getMessage(),
                'context' => 'RazorpayLiveRent_Payment'
            ]);
            
            return Theme::view('Razorpay.Rent_message', compact('respond'), $respond);
        }
    }

    public function RazorpayLiveRent_Paymentfailure(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'payment_id' => 'nullable|string',
                'order_id' => 'nullable|string',
                'live_id' => 'nullable|integer',
                'user_id' => 'nullable|integer',
                'amount' => 'nullable|numeric',
                'error_description' => 'required|string',
            ]);
            $setting = Setting::first();
            $ppv_hours = $setting->ppv_hours;

            $d = new \DateTime('now');
            $d->setTimezone(new \DateTimeZone('Asia/Kolkata'));
            $now = $d->format('Y-m-d h:i:s a');
            $time = date('h:i:s', strtotime($now));
            $to_time = date('Y-m-d h:i:s a', strtotime('+' . $ppv_hours . ' hour', strtotime($now)));
            $paymentId = $validatedData['payment_id'] ?? $validatedData['order_id'];
            $existingPurchase = PpvPurchase::where('payment_id', $paymentId)->first();

            if ($existingPurchase) {
                return response()->json(['status' => 'already_logged']);
            }

            $video = LiveStream::where('id', '=', $validatedData['live_id'])->first();
            $moderators_id = null;

            if (!empty($video)) {
                $moderators_id = $video->user_id;
            }

            $commission_btn = $setting->CPP_Commission_Status;
            $CppUser_details = ModeratorsUser::where('id', $moderators_id)->first();
            $video_commission_percentage = VideoCommission::where('type', 'Cpp')->pluck('percentage')->first();
            $commission_percentage_value = $video->CPP_commission_percentage;

            if ($commission_btn === 0) {
                $commission_percentage_value = !empty($CppUser_details->commission_percentage) ? $CppUser_details->commission_percentage : $video_commission_percentage;
            }
            if (!empty($moderators_id)) {
                $moderator = ModeratorsUser::where('id', $moderators_id)->first();
                if ($moderator) {
                    $percentage = $moderator->commission_percentage ? $moderator->commission_percentage : 0;
                } else {
                    $percentage = 0;
                }
                $total_amount = $video->ppv_price;
                $title = $video->title;
                $commssion = VideoCommission::where('type', 'CPP')->first();
                $ppv_price = $validatedData['amount'] / 100;
                $moderator_commssion = ($ppv_price * $commission_percentage_value) / 100;
                $admin_commssion = $ppv_price - $moderator_commssion;
                $moderator_id = $moderators_id;
            } else {
                $total_amount = $video->ppv_price;
                $title = $video->title;
                $commssion = VideoCommission::where('type', 'CPP')->first();
                $percentage = null;
                $ppv_price = $video->ppv_price;
                $admin_commssion = null;
                $moderator_commssion = null;
                $moderator_id = null;
            }

            // Create new failed purchase record instead of trying to find existing one
            $purchase = new PpvPurchase();
            $purchase->user_id = $validatedData['user_id'];
            $purchase->live_id = $validatedData['live_id'];
            $purchase->total_amount = $validatedData['amount'] / 100;
            $purchase->admin_commssion = null; // Don't set commission for failed payments
            $purchase->moderator_commssion = null; // Don't set commission for failed payments
            $purchase->moderator_id = $moderators_id;
            $purchase->status = 'failed';
            $purchase->payment_failure_reason = $validatedData['error_description'];
            $purchase->platform = 'website';
            $purchase->to_time = null; // No access time for failed payments
            $purchase->payment_id = $paymentId;
            $purchase->payment_gateway = 'razorpay';
            $purchase->save();

            SiteLogs::create([
                'level' => 'success',
                'message' => 'Razorpay live rent payment failure stored successfully! ' . $paymentId,
                'context' => 'RazorpayLiveRent_Paymentfailure'
            ]);

            return response()->json(['status' => 'failure_logged']);
        } catch (\Exception $e) {
            SiteLogs::create([
                'level' => 'fails',
                'message' => $e->getMessage(),
                'context' => 'RazorpayLiveRent_Paymentfailure'
            ]);

            return response()->json(['status' => 'error', 'message' => 'An error occurred while processing the payment failure.']);
        }
    }


    public function RazorpayModeratorPayouts(Request $request)
    {

        $data = $request->all();
        $recept_id = Str::random(10);
        $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);

        $orderData = [
            'receipt' => $recept_id,
            'amount' => $request->commission_paid * 100,
            'currency' => 'INR',
            'payment_capture' => 1,
        ];

        $razorpayOrder = $api->order->create($orderData);

        if (!empty($data['id'])) {
            $user = ModeratorsUser::where('id', $data['id'])->first();
            $name = $user->username;
        }
        $response = array(
            'razorpaykeyId' => $this->razorpaykeyId,
            'name' => $name,
            'currency' => 'INR',
            'amount' => $request->commission_paid * 100,
            'orderId' => $razorpayOrder['id'],
            'user_id' => $data['id'] ? $data['id'] : null,
            'phone_number' => $user['upi_mobile_number'] ? $user['upi_mobile_number'] : null,
            'upi_id' => $user['upi_id'] ? $user['upi_id'] : null,
            'email' => $user['email'] ? $user['email'] : null,
            'user' => $user ? $user : null,
            'name' => $user['username'] ? $user['username'] : null,
            'description' => null,
            'address' => null,
            'commission' => $data['commission'] ? $data['commission'] : null,
            'payment_type' => $data['payment_type'] ? $data['payment_type'] : null,


        );

        return Theme::view('Razorpay.moderator_payouts', compact('response'), $response);

    }

    public function RazorpayModeratorPayouts_Payment(Request $request)
    {
        $data = $request->all();


        $setting = Setting::first();

        try {
            $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);

            $attributes = array(
                'razorpay_signature' => $request->rzp_signature,
                'razorpay_payment_id' => $request->rzp_paymentid,
                'razorpay_order_id' => $request->rzp_orderid
            );
            $order = $api->utility->verifyPaymentSignature($attributes);

            $commission_paid = $data['amount'] / 100;

            $last_paid_amount = ModeratorPayout::where('user_id', $data['user_id'])->get([
                DB::raw(
                    "sum(moderator_payouts.commission_paid) as commission_paid"
                )
            ]);
            if (count($last_paid_amount) > 0) {
                $last_paid = intval($last_paid_amount[0]->commission_paid);
            } else {
                $last_paid = 0;
            }

            if (
                !empty($data["payment_type"]) &&
                $data["payment_type"] == "Partial_amount"
            ) {

                if ($data["commission"] != $commission_paid) {

                    $paid_amount = $data["commission"] - $commission_paid - $last_paid;
                } else {
                    $paid_amount = $commission_paid;
                }
            } elseif (
                !empty($data["payment_type"]) &&
                $data["payment_type"] == "full_amount"
            ) {
                if ($commission_paid == $data["commission"]) {
                    $paid_amount = $commission_paid;
                } else {
                    $paid_amount = $data["commission"] - $commission_paid - $last_paid;
                }
            }

            // dd($paid_amount);

            $respond = array(
                'status' => 'true',
            );

            $ModeratorPayout = new ModeratorPayout();
            $ModeratorPayout->user_id = $data["user_id"];
            $ModeratorPayout->commission_paid = $commission_paid;
            $ModeratorPayout->commission_pending = $paid_amount;
            $ModeratorPayout->payment_type = $data["payment_type"];
            $ModeratorPayout->save();

            return Theme::view('Razorpay.Payout_message', compact('respond'), $respond);

        } catch (\Exception $e) {

            $respond = array(
                'status' => 'false',
            );

            return Theme::view('Razorpay.Payout_message', compact('respond'), $respond);
        }
    }



    public function RazorpayChannelPayouts(Request $request)
    {

        $data = $request->all();
        // dd($data);
        $recept_id = Str::random(10);
        $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);

        $orderData = [
            'receipt' => $recept_id,
            'amount' => $request->commission_paid * 100,
            'currency' => 'INR',
            'payment_capture' => 1,
        ];

        $razorpayOrder = $api->order->create($orderData);

        if (!empty($data['id'])) {
            $user = Channel::where('id', $data['id'])->first();
            $name = $user->channel_name;
        }
        $response = array(
            'razorpaykeyId' => $this->razorpaykeyId,
            'name' => $name,
            'currency' => 'INR',
            'amount' => $request->commission_paid * 100,
            'orderId' => $razorpayOrder['id'],
            'user_id' => $data['id'] ? $data['id'] : null,
            'phone_number' => $user['upi_mobile_number'] ? $user['upi_mobile_number'] : null,
            'upi_id' => $user['upi_id'] ? $user['upi_id'] : null,
            'email' => $user['email'] ? $user['email'] : null,
            'user' => $user ? $user : null,
            'name' => $user['username'] ? $user['username'] : null,
            'description' => null,
            'address' => null,
            'commission' => $data['commission'] ? $data['commission'] : null,
            'payment_type' => $data['payment_type'] ? $data['payment_type'] : null,


        );

        return view('Razorpay.channel_payouts', compact('response'), $response);

    }

    public function RazorpayChannelPayouts_Payment(Request $request)
    {
        $data = $request->all();


        $setting = Setting::first();

        try {
            $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);

            $attributes = array(
                'razorpay_signature' => $request->rzp_signature,
                'razorpay_payment_id' => $request->rzp_paymentid,
                'razorpay_order_id' => $request->rzp_orderid
            );
            $order = $api->utility->verifyPaymentSignature($attributes);

            $commission_paid = $data['amount'] / 100;

            $last_paid_amount = ChannelPayout::where('user_id', $data['user_id'])->get([
                DB::raw(
                    "sum(channel_payouts.commission_paid) as commission_paid"
                )
            ]);
            if (count($last_paid_amount) > 0) {
                $last_paid = intval($last_paid_amount[0]->commission_paid);
            } else {
                $last_paid = 0;
            }

            if (
                !empty($data["payment_type"]) &&
                $data["payment_type"] == "Partial_amount"
            ) {

                if ($data["commission"] != $commission_paid) {

                    $paid_amount = $data["commission"] - $commission_paid - $last_paid;
                } else {
                    $paid_amount = $commission_paid;
                }
            } elseif (
                !empty($data["payment_type"]) &&
                $data["payment_type"] == "full_amount"
            ) {
                if ($commission_paid == $data["commission"]) {
                    $paid_amount = $commission_paid;
                } else {
                    $paid_amount = $data["commission"] - $commission_paid - $last_paid;
                }
            }

            // dd($paid_amount);

            $respond = array(
                'status' => 'true',
            );

            $ChannelPayout = new ChannelPayout();
            $ChannelPayout->user_id = $data["user_id"];
            $ChannelPayout->commission_paid = $commission_paid;
            $ChannelPayout->commission_pending = $paid_amount;
            $ChannelPayout->payment_type = $data["payment_type"];
            $ChannelPayout->save();

            return view('Razorpay.Channel_Payout_message', compact('respond'), $respond);

        } catch (\Exception $e) {

            $respond = array(
                'status' => 'false',
            );

            return view('Razorpay.Channel_Payout_message', compact('respond'), $respond);
        }
    }



    public function RazorpayVideoRent_PPV(Request $request, $ppv_plan, $video_id)
    {
        $video = Video::where('id', '=', $video_id)->first();
        $setting = Setting::first();

        switch ($ppv_plan) {
            case '480p':
                $amount = $video->ppv_price_480p;
                break;
            case '720p':
                $amount = $video->ppv_price_720p;
                break;
            case '1080p':
                $amount = $video->ppv_price_1080p;
                break;
            default:
                $amount = $video->ppv_price;
        }

        $moderators_id = $video->user_id;
        $commission_btn = $setting->CPP_Commission_Status;
        $recept_id = Str::random(10);
        $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);

        // // Create initial purchase record
        // $purchase = new PpvPurchase();
        // $purchase->user_id = Auth::user()->id;
        // $purchase->video_id = $video_id;
        // $purchase->total_amount = $amount;
        // $purchase->status = 'hold';
        // $purchase->platform = 'website';
        // $purchase->payment_gateway = 'razorpay';
        // $purchase->save();
        // $PpvPurchase_id = $purchase->id;


        $recept_id = Str::random(10);
        $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);

        $orderData = [
            'receipt' => $recept_id,
            'amount' => $amount * 100,
            'currency' => 'INR',
            'payment_capture' => 1,
        ];

        $razorpayOrder = $api->order->create($orderData);

        $plainAmount = $amount * 100;
        $encryptedAmount = encrypt($plainAmount);
        $response = array(
            'razorpaykeyId' => $this->razorpaykeyId,
            'name' => Auth::user()->name ? Auth::user()->name : null,
            'currency' => 'INR',
            'amount' => $plainAmount,// for Razorpay JS
            'encrypted_amount' => $encryptedAmount, // for form/backend
            'orderId' => $razorpayOrder['id'],
            'video_id' => $request->video_id,
            'user_id' => Auth::user()->id,
            'description' => null,
            'address' => null,
            'Video_slug' => $video->slug,
            'ppv_plan' => $ppv_plan,
        );

        return Theme::view('Razorpay.video_rent_checkout', compact('response'), $response);
    }



    public function RazorpaySeriesSeasonRent(Request $request, $SeriesSeason_id)
    {
        // }

        $SeriesSeason = SeriesSeason::where('id', $SeriesSeason_id)->first();
        $series_id = SeriesSeason::where('id', $SeriesSeason_id)->pluck('series_id')->first();
        $Series = Series::where('id', $series_id)->first();
        if (!empty($Series) && $Series->uploaded_by == 'CPP') {
            $moderators_id = $Series->user_id;
        }
        $moderators_user_id = Series::where('id', $series_id)->pluck('user_id')->first();
        $CPP_commission_percentage = Series::where('id', $series_id)->pluck('CPP_commission_percentage')->first();

        $moderators_id = null;
        if (!empty($moderators_user_id)) {
            $moderators_id = $moderators_user_id;
        }

        $commission_btn = $Series->CPP_Commission_Status;
        $CppUser_details = ModeratorsUser::where('id', $moderators_id)->first();
        $video_commission_percentage = VideoCommission::where('type', 'Cpp')->pluck('percentage')->first();
        $commission_percentage_value = $CPP_commission_percentage;
        // dd((600 * $commission_percentage_value)/100);

        if ($commission_btn === 0) {
            $commission_percentage_value = !empty($CppUser_details->commission_percentage) ? $CppUser_details->commission_percentage : $video_commission_percentage;
        }

        if (!empty($moderators_id)) {
            $moderator = ModeratorsUser::where('id', $moderators_id)->first();
            if ($moderator) {
                $percentage = $moderator->commission_percentage ? $moderator->commission_percentage : 0;
            } else {
                $percentage = 0;
            }
            $total_amount = $SeriesSeason->ppv_price;
            $title = $SeriesSeason->series_seasons_name;
            $commssion = VideoCommission::where('type', 'CPP')->first();
            $ppv_price = $SeriesSeason->ppv_price;
            $moderator_commssion = ($ppv_price * $commission_percentage_value) / 100;
            $admin_commssion = $ppv_price - $moderator_commssion;
            $moderator_id = $moderators_id;
        } else {
            $total_amount = $SeriesSeason->ppv_price;
            $title = $SeriesSeason->series_seasons_name;
            $commssion = VideoCommission::where('type', 'CPP')->first();
            $percentage = null;
            $ppv_price = $SeriesSeason->ppv_price;
            $admin_commssion = null;
            $moderator_commssion = null;
            $moderator_id = null;
        }

        // $purchase = PpvPurchase::find($PpvPurchase_id);
        // $purchase->total_amount = $SeriesSeason->ppv_price;
        // $purchase->moderator_id = $moderators_id;
        // $purchase->admin_commssion = $admin_commssion;
        // $purchase->moderator_commssion = $moderator_commssion;
        // $purchase->save();
        // $recept_id = Str::random(10);

        $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);

        $orderData = [
            'receipt' => $recept_id,
            'amount' => $SeriesSeason->ppv_price * 100,
            'currency' => 'INR',
            'notes' => [
                'series_id' => $SeriesSeason_id,
                'user_id' => Auth::user()->id,
                'ppv_plan' => $request->ppv_plan,
            ],
        ];

        $razorpayOrder = $api->order->create($orderData);

        $SeriesSeason = SeriesSeason::where('id', $SeriesSeason_id)->first();
        $series_id = SeriesSeason::where('id', $SeriesSeason_id)->pluck('series_id')->first();
        $Series_slug = Series::where('id', $series_id)->pluck('slug')->first();


        $response = array(
            'razorpaykeyId' => $this->razorpaykeyId,
            'name' => Auth::user()->name ? Auth::user()->name : null,
            'currency' => 'INR',
            'amount' => $SeriesSeason->ppv_price * 100,
            'orderId' => $razorpayOrder['id'],
            'SeriesSeason_id' => $request->SeriesSeason_id,
            'user_id' => Auth::user()->id,
            'description' => null,
            'address' => null,
            'Series_slug' => $Series_slug,
            'address' => null,
            'ppv_plan' => null,
        );

        return Theme::view('Razorpay.SeriesSeason_rent_checkout', compact('response'), $response);
    }

    public function RazorpaySeriesSeasonRent_Payment(Request $request)
    {
        $setting = Setting::first();
        $ppv_hours = $setting->ppv_hours;

        $d = new \DateTime('now');
        $d->setTimezone(new \DateTimeZone('Asia/Kolkata'));
        $now = $d->format('Y-m-d h:i:s a');
        $time = date('h:i:s', strtotime($now));
        $to_time = date('Y-m-d h:i:s a', strtotime('+' . $ppv_hours . ' hour', strtotime($now)));

        try {
            $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);

            $attributes = array(
                'razorpay_signature' => $request->rzp_signature,
                'razorpay_payment_id' => $request->rzp_paymentid,
                'razorpay_order_id' => $request->rzp_orderid
            );
            $order = $api->utility->verifyPaymentSignature($attributes);
            // dd($api->utility);


            $payment = $api->payment->fetch($request->rzp_paymentid);

            if ($payment->status !== 'captured') {
                $payment->capture(['amount' => $payment->amount]);
            }
            $payment_status = $payment->status;


            $SeriesSeason = SeriesSeason::where('id', $request->SeriesSeason_id)->first();

            $series_id = SeriesSeason::where('id', $request->SeriesSeason_id)->pluck('series_id')->first();
            $Series_slug = Series::where('id', $series_id)->pluck('slug')->first();

            // if(!empty($SeriesSeason)){
            // $moderators_id = Auth::User()->id;
            // }

            // $Series = Series::where('id',$series_id)->first();

            // if(!empty($Series) && $Series->uploaded_by == 'CPP'){
            //     $moderators_id = $Series->user_id;
            // }

            // $moderators_user_id = Series::where('id',$series_id)->pluck('user_id')->first();
            // $CPP_commission_percentage = Series::where('id',$series_id)->pluck('CPP_commission_percentage')->first();

            // $moderators_id = null;
            // if(!empty($moderators_user_id)){
            //     $moderators_id = $moderators_user_id;
            // }

            // $commission_btn = $setting->CPP_Commission_Status;
            // $CppUser_details = ModeratorsUser::where('id',$moderators_id)->first();
            // $video_commission_percentage = VideoCommission::where('type','Cpp')->pluck('percentage')->first();
            // $commission_percentage_value = $CPP_commission_percentage;
            // // dd((600 * $commission_percentage_value)/100);

            // if($commission_btn === 0){
            //     $commission_percentage_value = !empty($CppUser_details->commission_percentage) ? $CppUser_details->commission_percentage : $video_commission_percentage;
            // }


            // if(!empty($moderators_id)){
            //     $moderator           =  ModeratorsUser::where('id',$moderators_id)->first();  
            //     if ($moderator) {
            //         $percentage = $moderator->commission_percentage ? $moderator->commission_percentage : 0;
            //     } else {
            //         $percentage = 0;
            //     }
            //     $total_amount        =  $video->ppv_price;
            //     $title               =  $video->title;
            //     $commssion           =  VideoCommission::where('type','CPP')->first();
            //     $ppv_price           =  $request->amount/100;
            //     $moderator_commssion =  ($ppv_price * $commission_percentage_value) / 100;
            //     $admin_commssion     =  $ppv_price - $moderator_commssion;
            //     $moderator_id        =  $moderators_id;
            // }
            // else
            // {
            //     $total_amount = $request->amount;
            //     $title =  $SeriesSeason->title;
            //     $commssion  =  VideoCommission::where('type','CPP')->first();
            //     $percentage = null; 
            //     $ppv_price = $request->amount;
            //     $admin_commssion =  null;
            //     $moderator_commssion = null;
            //     $moderator_id = null;
            // }
// dd($moderator_commssion);
            $purchase = new PpvPurchase; // Simplified from find()
            $purchase->user_id = $request->user_id;
            $purchase->season_id = $request->SeriesSeason_id;
            $purchase->series_id = $series_id;
            $purchase->total_amount = $request->amount / 100;
            // $purchase->admin_commssion = $admin_commssion;
            // $purchase->moderator_commssion = $moderator_commssion;
            $purchase->status = $payment_status;
            $purchase->to_time = $to_time;
            // $purchase->moderator_id = $moderator_id;
            $purchase->platform = 'website';
            $purchase->ppv_plan = $request->ppv_plan;
            $purchase->payment_id = $request->rzp_paymentid;
            $purchase->payment_gateway = 'razorpay';
            $purchase->save();

            $respond = array(
                'status' => 'true',
            );

            SiteLogs::create([
                'level' => 'success,' . $purchase->status,
                'message' => 'Razorpay SeriesSeason rent payment stored successfully!',
                'context' => 'RazorpaySeriesSeasonRent_Payment'
            ]);


            return view('Razorpay.Rent_message', compact('respond'), $respond);

        } catch (\Exception $e) {
            // dd($e->getMessage());
            // $e->getMessage();
            $respond = array(
                'status' => 'false',
            );

            SiteLogs::create([
                'level' => 'fails',
                'message' => $e->getMessage(),
                'context' => 'RazorpaySeriesSeasonRent_Payment'
            ]);


            return Theme::view('Razorpay.Rent_message', compact('respond'), $respond);
        }
    }


    public function RazorpaySeriesSeasonRent_Paymentfailure(Request $request)
    {



        try {
            $validatedData = $request->validate([
                'payment_id' => 'nullable|string',
                'order_id' => 'nullable|string',
                'SeriesSeason_id' => 'nullable|integer',
                'season_id' => 'nullable|integer',
                'user_id' => 'nullable|integer',
                'amount' => 'nullable|numeric',
                'error_description' => 'nullable|string',
            ]);

            $setting = Setting::first();
            $ppv_hours = $setting->ppv_hours;

            $d = new \DateTime('now');
            $d->setTimezone(new \DateTimeZone('Asia/Kolkata'));
            $now = $d->format('Y-m-d h:i:s a');
            $time = date('h:i:s', strtotime($now));
            $to_time = date('Y-m-d h:i:s a', strtotime('+' . $ppv_hours . ' hour', strtotime($now)));
            $paymentId = $validatedData['payment_id'] ?? $validatedData['order_id'];

            $existingPurchase = PpvPurchase::where('payment_id', $paymentId)->first();

            if ($existingPurchase) {
                return response()->json(['status' => 'already_logged']);
            }


            $SeriesSeason = SeriesSeason::where('id', $validatedData['SeriesSeason_id'])->first();
            $series_id = SeriesSeason::where('id', $validatedData['SeriesSeason_id'])->pluck('series_id')->first();
            $Series = Series::where('id', $series_id)->first();


            if (!empty($Series && $Series->uploaded_by == 'CPP')) {
                $moderators_id = $Series->user_id;
            }

            $commission_btn = $setting->CPP_Commission_Status;
            $CppUser_details = ModeratorsUser::where('id', $moderators_id)->first();
            $video_commission_percentage = VideoCommission::where('type', 'Cpp')->pluck('percentage')->first();
            $commission_percentage_value = $setting->CPP_commission_percentage;

            if ($commission_btn === 0) {
                $commission_percentage_value = !empty($CppUser_details->commission_percentage) ? $CppUser_details->commission_percentage : $video_commission_percentage;
            }
            if (!empty($moderators_id)) {
                $moderator = ModeratorsUser::where('id', $moderators_id)->first();
                if ($moderator) {
                    $percentage = $moderator->commission_percentage ? $moderator->commission_percentage : 0;
                } else {
                    $percentage = 0;
                }
                $total_amount = $SeriesSeason->ppv_price;
                $title = $SeriesSeason->series_seasons_name;
                $commssion = VideoCommission::where('type', 'CPP')->first();
                $ppv_price = $request->amount / 100;
                $moderator_commssion = ($ppv_price * $commission_percentage_value) / 100;
                $admin_commssion = $ppv_price - $moderator_commssion;
                $moderator_id = $moderators_id;
            } else {
                $total_amount = $SeriesSeason->ppv_price;
                $title = $SeriesSeason->series_seasons_name;
                $commssion = VideoCommission::where('type', 'CPP')->first();
                $percentage = null;
                $ppv_price = $SeriesSeason->ppv_price;
                $admin_commssion = null;
                $moderator_commssion = null;
                $moderator_id = null;
            }

            // Create new failed purchase record instead of trying to find existing one
            $purchase = new PpvPurchase();
            $purchase->user_id = $validatedData['user_id'];
            $purchase->season_id = $validatedData['SeriesSeason_id'];
            $purchase->series_id = $series_id;
            $purchase->total_amount = $validatedData['amount'] / 100;
            // Don't set commission values for failed payments
            $purchase->admin_commssion = null;
            $purchase->moderator_commssion = null;
            $purchase->status = 'failed';
            $purchase->payment_failure_reason = $validatedData['error_description'];
            $purchase->platform = 'website';
            // Don't set to_time for failed payments
            $purchase->to_time = null;
            $purchase->payment_id = $paymentId;
            $purchase->payment_gateway = 'razorpay';
            $purchase->save();

            SiteLogs::create([
                'level' => 'success',
                'message' => 'Razorpay SeriesSeason rent payment failure stored successfully! ' . $paymentId,
                'context' => 'RazorpaySeriesSeasonRent_Paymentfailure'
            ]);

            return response()->json(['status' => 'failure_logged']);

        } catch (\Exception $e) {

            SiteLogs::create([
                'level' => 'fails',
                'message' => $e->getMessage(),
                'context' => 'RazorpaySeriesSeasonRent_Paymentfailure'
            ]);

            return response()->json(['status' => 'error', 'message' => 'An error occurred while processing the payment failure.']);
        }

    }

    public function RazorpaySeriesSeasonRent_PPV(Request $request, $ppv_plan, $SeriesSeason_id)
    {

        $recept_id = Str::random(10);
        $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);
        $SeriesSeason = SeriesSeason::where('id', $SeriesSeason_id)->first();

        switch ($ppv_plan) {
            case '240p':
                $amount = $SeriesSeason->ppv_price_240p;
                break;
            case '360p':
                $amount = $SeriesSeason->ppv_price_360p;
                break;
            case '480p':
                $amount = $SeriesSeason->ppv_price_480p;
                break;
            case '720p':
                $amount = $SeriesSeason->ppv_price_720p;
                break;
            case '1080p':
                $amount = $SeriesSeason->ppv_price_1080p;
                break;
            default:
                $amount = $SeriesSeason->ppv_price;
        }
        $orderData = [
            'receipt' => $recept_id,
            'amount' => $amount * 100,
            'currency' => 'INR',
            'payment_capture' => 1,
        ];
        $razorpayOrder = $api->order->create($orderData);

        $series_id = SeriesSeason::where('id', $SeriesSeason_id)->pluck('series_id')->first();
        $Series_slug = Series::where('id', $series_id)->pluck('slug')->first();


        $response = array(
            'razorpaykeyId' => $this->razorpaykeyId,
            'name' => Auth::user()->name ? Auth::user()->name : null,
            'currency' => 'INR',
            'amount' => $amount * 100,
            'orderId' => $razorpayOrder['id'],
            'SeriesSeason_id' => $request->SeriesSeason_id,
            'user_id' => Auth::user()->id,
            'description' => null,
            'address' => null,
            'Series_slug' => $Series_slug,
            'address' => null,
            'ppv_plan' => $ppv_plan,
        );

        return Theme::view('Razorpay.SeriesSeason_rent_checkout', compact('response'), $response);
    }

    public function Razorpay_Missingtransaction()
    {
        $setting = Setting::first();
        $ppv_hours = $setting->ppv_hours;
        $d = new \DateTime('now');
        $d->setTimezone(new \DateTimeZone('Asia/Kolkata'));
        $now = $d->format('Y-m-d h:i:s a');
        $time = date('h:i:s', strtotime($now));
        $to_time = date('Y-m-d h:i:s a', strtotime('+' . $ppv_hours . ' hour', strtotime($now)));

        try {
            $api = new Api($this->razorpaykeyId, $this->razorpaykeysecret);
            $totalTransactions = 200;
            $transactionsPerRequest = 100;
            $skip = 0;
            $fetchedTransactions = 0;

            while ($fetchedTransactions < $totalTransactions) {
                $options = [
                    'count' => $transactionsPerRequest,
                    'skip' => $skip,
                ];
                $payments = $api->payment->all($options);
                if (empty($payments['items'])) {
                    break;
                }

                foreach ($payments['items'] as $payment) {
                    $paymentId = $payment['id'];
                    $existingPayment = PpvPurchase::where('payment_id', $paymentId)->first();


                    if (!$existingPayment) {
                        $amount = $payment['amount'] / 100;
                        $status = $payment['status'];
                        $userId = $payment['notes']['user_id'] ?? null;
                        $Ppv_plan = $payment['notes']['ppv_plan'] ?? null;

                        $videoId = $payment['notes']['video_id'] ?? null;
                        $liveId = $payment['notes']['live_id'] ?? null;
                        $audioId = $payment['notes']['audio_id'] ?? null;
                        $movieId = $payment['notes']['movie_id'] ?? null;
                        $seriesId = $payment['notes']['series_id'] ?? null;
                        $seasonId = $payment['notes']['season_id'] ?? null;
                        $episodeId = $payment['notes']['episode_id'] ?? null;

                        $mediaType = null;
                        $mediaId = null;


                        if ($liveId) {
                            $mediaType = 'live';
                            $mediaId = $liveId;
                        } elseif ($videoId) {
                            $mediaType = 'video';
                            $mediaId = $videoId;
                        } elseif ($audioId) {
                            $mediaType = 'audio';
                            $mediaId = $audioId;
                        } elseif ($movieId) {
                            $mediaType = 'movie';
                            $mediaId = $movieId;
                        } elseif ($seriesId) {
                            $mediaType = 'series';
                            $mediaId = $seriesId;
                        } elseif ($seasonId) {
                            $mediaType = 'season';
                            $mediaId = $seasonId;
                        } elseif ($episodeId) {
                            $mediaType = 'episode';
                            $mediaId = $episodeId;
                        }

                        if ($mediaId && $userId) {

                            $purchase = new PpvPurchase();
                            $purchase->user_id = $userId;
                            $purchase->total_amount = $amount;
                            $purchase->status = $status;
                            $purchase->to_time = $to_time;
                            $purchase->platform = 'website';
                            $purchase->payment_id = $paymentId;
                            $purchase->payment_gateway = 'razorpay';
                            $purchase->ppv_plan = $Ppv_plan;
                            if ($mediaType === 'video') {
                                $purchase->video_id = $mediaId;
                            } elseif ($mediaType === 'live') {
                                $purchase->live_id = $mediaId;
                            } elseif ($mediaType === 'audio') {
                                $purchase->audio_id = $mediaId;
                            } elseif ($mediaType === 'movie') {
                                $purchase->movie_id = $mediaId;
                            } elseif ($mediaType === 'series') {
                                $purchase->series_id = $mediaId;
                            } elseif ($mediaType === 'season') {
                                $purchase->season_id = $mediaId;
                            } elseif ($mediaType === 'episode') {
                                $purchase->episode_id = $mediaId;
                            }
                            $moderators_id = null;
                            $moderator_commssion = 0;
                            $admin_commssion = 0;
                            if ($mediaType === 'video' || $mediaType === 'live' || $mediaType === 'series') {

                                if ($mediaType === 'video') {
                                    $video = Video::where('id', $mediaId)->first();
                                    if (!empty($video)) {
                                        $moderators_id = $video->user_id;
                                    }

                                    $commission_btn = $setting->CPP_Commission_Status;
                                    $CppUser_details = ModeratorsUser::where('id', $moderators_id)->first();
                                    $video_commission_percentage = VideoCommission::where('type', 'Cpp')->pluck('percentage')->first();
                                    $commission_percentage_value = $video->CPP_commission_percentage ?? 0;
                                    if ($commission_btn === 0) {
                                        $commission_percentage_value = !empty($CppUser_details->commission_percentage) ? $CppUser_details->commission_percentage : $video_commission_percentage;
                                    }

                                    if (!empty($moderators_id)) {

                                        $moderator = ModeratorsUser::where('id', $moderators_id)->first();
                                        if ($moderator) {
                                            $percentage = $moderator->commission_percentage ? $moderator->commission_percentage : 0;
                                        } else {
                                            $percentage = 0;
                                        }
                                        $total_amount = $video->ppv_price ?? 0;
                                        $title = $video->title ?? 'unknown title';
                                        $commssion = VideoCommission::where('type', 'CPP')->first();
                                        $ppv_price = $amount;
                                        $moderator_commssion = ($ppv_price * $commission_percentage_value) / 100;
                                        $admin_commssion = $ppv_price - $moderator_commssion;
                                        $moderator_id = $moderators_id;
                                    } else {
                                        $total_amount = $video->ppv_price ?? 0;
                                        $title = $video->title ?? 'unknown title';
                                        $commssion = VideoCommission::where('type', 'CPP')->first();
                                        $percentage = null;
                                        $ppv_price = $video->ppv_price ?? 0;
                                        $admin_commssion = null;
                                        $moderator_commssion = null;
                                        $moderator_id = null;
                                    }
                                    // dd('clear');
                                    $purchase->moderator_id = $moderator_id;
                                    $purchase->admin_commssion = $admin_commssion;
                                    $purchase->moderator_commssion = $moderator_commssion;
                                    $purchase->save();

                                } elseif ($mediaType === 'live') {
                                    $liveStream = LiveStream::where('id', $mediaId)->first();
                                    if (!empty($liveStream)) {
                                        $moderators_id = $liveStream->user_id;
                                    }

                                    if (!empty($moderators_id)) {
                                        $moderator = ModeratorsUser::where('id', $moderators_id)->first();
                                        if ($moderator) {
                                            $percentage = $moderator->commission_percentage ? $moderator->commission_percentage : 0;
                                        } else {
                                            $percentage = 0;
                                        }
                                        $total_amount = $liveStream->ppv_price ?? 0;
                                        $title = $liveStream->title ?? 'unknown title';
                                        $commssion = VideoCommission::where('type', 'CPP')->first();
                                        $ppv_price = $liveStream->ppv_price ?? 0;
                                        $moderator_commssion = ($percentage / 100) * $ppv_price;
                                        $admin_commssion = $ppv_price - $moderator_commssion;
                                        $moderator_id = $moderators_id;
                                    } else {
                                        $total_amount = $liveStream->ppv_price;
                                        $title = $liveStream->title;
                                        $commssion = VideoCommission::where('type', 'CPP')->first();
                                        $percentage = null;
                                        $ppv_price = $liveStream->ppv_price;
                                        $admin_commssion = null;
                                        $moderator_commssion = null;
                                        $moderator_id = null;
                                    }

                                    $purchase->moderator_id = $moderator_id;
                                    $purchase->admin_commssion = $admin_commssion;
                                    $purchase->moderator_commssion = $moderator_commssion;
                                    $purchase->save();

                                } elseif ($mediaType === 'series') {
                                    $SeriesSeason = SeriesSeason::where('id', $mediaId)->first();

                                    $series_id = SeriesSeason::where('id', $mediaId)->pluck('series_id')->first();
                                    $Series_slug = Series::where('id', $series_id)->pluck('slug')->first();
                                    $Series = Series::where('id', $series_id)->first();

                                    if (!empty($Series) && $Series->uploaded_by == 'CPP') {
                                        $moderators_id = $Series->user_id;
                                    }
                                    if (!empty($moderators_id)) {
                                        $moderator = ModeratorsUser::where('id', $moderators_id)->first();
                                        if ($moderator) {
                                            $percentage = $moderator->commission_percentage ? $moderator->commission_percentage : 0;
                                        } else {
                                            $percentage = 0;
                                        }
                                        $total_amount = $video->ppv_price ?? 0;
                                        $title = $video->title ?? 'unknown title';
                                        $commssion = VideoCommission::where('type', 'CPP')->first();
                                        $ppv_price = $video->ppv_price ?? 0;
                                        $moderator_commssion = ($percentage / 100) * $ppv_price;
                                        $admin_commssion = $ppv_price - $moderator_commssion;
                                        $moderator_id = $moderators_id;
                                    } else {
                                        $total_amount = $SeriesSeason->amount;
                                        $title = $SeriesSeason->title;
                                        $commssion = VideoCommission::where('type', 'CPP')->first();
                                        $percentage = null;
                                        $ppv_price = $amount;
                                        $admin_commssion = null;
                                        $moderator_commssion = null;
                                        $moderator_id = null;
                                    }
                                    $purchase->moderator_id = $moderator_id;
                                    $purchase->admin_commssion = $admin_commssion;
                                    $purchase->moderator_commssion = $moderator_commssion;
                                    $purchase->save();
                                }
                            } else {
                                \Log::warning("No valid media ID or user ID found for payment ID: " . $paymentId);
                            }
                        } elseif ($existingPayment && $existingPayment->status === 'failed') {
                            $existingPayment->status = $payment['status'];
                            $existingPayment->payment_failure_reason = $payment['error']['description'] ?? 'Unknown error';
                            $existingPayment->save();
                        }
                        $fetchedTransactions++;
                        if ($fetchedTransactions >= $totalTransactions) {
                            break;
                        }
                    }
                    $skip += $transactionsPerRequest;
                }
            }

            return redirect()->route('admin.transaction-details.index');

        } catch (\Exception $e) {
            //    dd($e->getMessage());
            return redirect()->route('admin.transaction-details.index')->with('error', 'An error occurred while processing the transactions.');
        }
    }

    /**
     * Handle Razorpay webhook events
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function handleWebhook(Request $request)
    {
        // Enhanced logging - Log ALL webhook requests
        \Log::info('🚀 === RAZORPAY WEBHOOK ENTRY POINT === 🚀', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'headers' => $request->headers->all(),
            'raw_payload_size' => strlen($request->getContent()),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'timestamp' => now(),
            'request_id' => uniqid('webhook_', true)
        ]);

        // Log the full raw payload for debugging
        $rawPayload = $request->getContent();
        \Log::info('📦 Razorpay Webhook Raw Payload', [
            'raw_content' => $rawPayload,
            'content_length' => strlen($rawPayload),
            'is_empty' => empty($rawPayload),
            'is_json' => json_decode($rawPayload) !== null
        ]);

        // Enhanced signature verification logging
        $webhookSignature = $request->header('X-Razorpay-Signature');
        $webhookBody = $request->getContent();
        
        \Log::info('🔐 Webhook Signature Verification', [
            'signature_provided' => !empty($webhookSignature),
            'signature_length' => strlen($webhookSignature ?? ''),
            'body_length' => strlen($webhookBody),
            'body_hash' => hash('sha256', $webhookBody)
        ]);

        if (!$this->verifyWebhookSignature($webhookBody, $webhookSignature)) {
            \Log::error('❌ Razorpay Webhook: Invalid signature - REJECTING REQUEST', [
                'provided_signature' => $webhookSignature,
                'body_sample' => substr($webhookBody, 0, 200) . '...'
            ]);
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        \Log::info('✅ Signature verification passed');

        // Enhanced payload parsing
        $payload = json_decode($webhookBody, true);
        $jsonError = json_last_error();
        
        if ($jsonError !== JSON_ERROR_NONE) {
            \Log::error('❌ JSON decode error', [
                'error' => json_last_error_msg(),
                'error_code' => $jsonError,
                'raw_payload' => $rawPayload
            ]);
            return response()->json(['error' => 'Invalid JSON payload'], 400);
        }

        $event = $payload['event'] ?? null;
        
        \Log::info('📋 Parsed Webhook Payload', [
            'event' => $event,
            'payload_keys' => array_keys($payload),
            'has_payment_data' => isset($payload['payload']['payment']['entity']),
            'full_payload' => $payload
        ]);

        if (!$event) {
            \Log::error('❌ Razorpay Webhook: No event specified in payload');
            return response()->json(['error' => 'No event specified'], 400);
        }

        \Log::info('🎯 Processing Webhook Event', [
            'event' => $event,
            'event_type' => gettype($event),
            'supported_events' => ['payment.captured', 'payment.failed', 'subscription.authenticated', 'subscription.activated', 'subscription.charged', 'subscription.cancelled']
        ]);

        try {
            // Handle different event types
            switch ($event) {
                // case 'payment.authorized':
                //     $this->handlePaymentAuthorized($payload);
                //     break;
                case 'payment.captured':
                    \Log::info('💳 Processing payment.captured event');
                    $this->handlePaymentCaptured($payload);
                    break;
                case 'payment.failed':
                    \Log::info('❌ Processing payment.failed event');
                    $this->handlePaymentFailed($payload);
                    break;
                case 'subscription.authenticated':
                    \Log::info('🔐 Processing subscription.authenticated event');
                    $this->handleSubscriptionAuthenticated($payload);
                    break;
                case 'subscription.activated':
                    \Log::info('✅ Processing subscription.activated event');
                    $this->handleSubscriptionActivated($payload);
                    break;
                case 'subscription.charged':
                    \Log::info('💰 Processing subscription.charged event');
                    $this->handleSubscriptionCharged($payload);
                    break;
                case 'subscription.cancelled':
                    \Log::info('🚫 Processing subscription.cancelled event');
                    $this->handleSubscriptionCancelled($payload);
                    break;
                default:
                    \Log::info('❓ Unhandled webhook event', [
                        'event' => $event,
                        'available_handlers' => ['payment.captured', 'payment.failed', 'subscription.authenticated', 'subscription.activated', 'subscription.charged', 'subscription.cancelled']
                    ]);
                    break;
            }

            \Log::info('✅ Webhook processing completed successfully', [
                'event' => $event,
                'response' => 'success'
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error('💥 Fatal error processing webhook', [
                'event' => $event,
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'stack_trace' => $e->getTraceAsString(),
                'payload_sample' => json_encode($payload, JSON_PRETTY_PRINT)
            ]);
            return response()->json(['error' => 'Error processing webhook'], 500);
        }
    }

    /**
     * Verify webhook signature
     *
     * @param string $webhookBody
     * @param string $webhookSignature
     * @return bool
     */
    private function verifyWebhookSignature($webhookBody, $webhookSignature)
    {
        \Log::info('🔍 Starting signature verification', [
            'signature_empty' => empty($webhookSignature),
            'body_length' => strlen($webhookBody)
        ]);

        if (empty($webhookSignature)) {
            \Log::error('❌ Signature verification failed: No signature provided');
            return false;
        }

        $PaymentSetting = PaymentSetting::where('payment_type', 'Razorpay')->first();
        $webhookSecret = $PaymentSetting->webhook_secret ?? env('RAZORPAY_WEBHOOK_SECRET');

        \Log::info('🔑 Webhook secret configuration', [
            'payment_setting_found' => $PaymentSetting !== null,
            'webhook_secret_configured' => !empty($webhookSecret),
            'webhook_secret_length' => strlen($webhookSecret ?? ''),
            'using_env_fallback' => empty($PaymentSetting->webhook_secret ?? null)
        ]);

        if (empty($webhookSecret)) {
            \Log::error('❌ Signature verification failed: Webhook secret not configured');
            return false;
        }

        $expectedSignature = hash_hmac('sha256', $webhookBody, $webhookSecret);
        $signatureMatch = hash_equals($expectedSignature, $webhookSignature);
        
        \Log::info('🔐 Signature comparison', [
            'expected_signature' => $expectedSignature,
            'provided_signature' => $webhookSignature,
            'signatures_match' => $signatureMatch,
            'body_hash' => hash('sha256', $webhookBody),
            'secret_hash' => hash('sha256', $webhookSecret)
        ]);

        return $signatureMatch;
    }

    private function handlePaymentAuthorized($payload)
    {
        // Simply log the authorization event but don't create any records
        $payment = $payload['payload']['payment']['entity'] ?? null;
        if (!$payment) {
            \Log::error('Razorpay Webhook: Invalid payment data in payload');
            return;
        }

        // Log the webhook event for tracking
        DB::table('payment_webhook')->insert([
            'order_id' => $payment['order_id'] ?? null,
            'payment_id' => $payment['id'] ?? null,
            'amount' => ($payment['amount'] ?? 0) / 100,
            'status' => 'TXN_AUTHORIZED',
            'event_type' => 'payment.authorized',
            'payload' => json_encode($payload),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        \Log::info('Razorpay Webhook: Payment authorized (no action taken)', [
            'payment_id' => $payment['id']
        ]);

        return response()->json(['success' => true]);
    }

    private function handlePaymentCaptured($payload)
    {
        \Log::info('💳 === PAYMENT CAPTURED HANDLER START ===');
        
        $payment = $payload['payload']['payment']['entity'] ?? null;
        if (!$payment) {
            \Log::error('❌ Invalid payment data in payload', [
                'payload_keys' => array_keys($payload),
                'has_payload' => isset($payload['payload']),
                'has_payment' => isset($payload['payload']['payment']) 
            ]);
            return;
        }

        // Enhanced payment data logging
        \Log::info('💰 Payment captured data extraction', [
            'payment_id' => $payment['id'] ?? null,
            'order_id' => $payment['order_id'] ?? null,
            'amount' => $payment['amount'] ?? null,
            'amount_formatted' => ($payment['amount'] ?? 0) / 100,
            'currency' => $payment['currency'] ?? null,
            'status' => $payment['status'] ?? null,
            'method' => $payment['method'] ?? null,
            'notes' => $payment['notes'] ?? [],
            'created_at' => $payment['created_at'] ?? null,
            'captured_at' => $payment['captured_at'] ?? null,
            'payment_keys' => array_keys($payment)
        ]);

        DB::beginTransaction();
        try {
            \Log::info('🔍 Checking for duplicate webhook events');
            
            // Check for duplicate webhook event
            $existingWebhookRecord = DB::table('payment_webhook')
                ->where('payment_id', $payment['id'])
                ->where('event_type', 'payment.captured')
                ->lockForUpdate()
                ->first();

            if ($existingWebhookRecord) {
                DB::commit();
                \Log::info('⚠️ Duplicate payment.captured event detected, skipping processing', [
                    'payment_id' => $payment['id'],
                    'existing_record_id' => $existingWebhookRecord->id ?? null,
                    'existing_created_at' => $existingWebhookRecord->created_at ?? null
                ]);
                return response()->json(['success' => true, 'message' => 'Duplicate event']);
            }

            \Log::info('📝 Inserting webhook event record');
            
            // Log the webhook event
            $webhookInsertData = [
                'order_id' => $payment['order_id'] ?? null,
                'payment_id' => $payment['id'] ?? null,
                'amount' => ($payment['amount'] ?? 0) / 100,
                'status' => 'TXN_SUCCESS',
                'event_type' => 'payment.captured',
                'payload' => json_encode($payload),
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            \Log::info('💾 Webhook record data', $webhookInsertData);
            
            DB::table('payment_webhook')->insert($webhookInsertData);

            $notes = $payment['notes'] ?? [];
            \Log::info('📋 Extracted notes for processing', [
                'notes' => $notes,
                'notes_keys' => array_keys($notes),
                'payment_id' => $payment['id'],
                'has_user_id' => isset($notes['user_id']),
                'has_video_id' => isset($notes['video_id']),
                'has_order_id' => isset($notes['order_id'])
            ]);

            // Special logging for video 39 and user 201673 debugging
            if (isset($notes['video_id']) && $notes['video_id'] == '39') {
                \Log::info('🎯🎯🎯 VIDEO 39 WEBHOOK DETECTED - SPECIAL LOGGING 🎯🎯🎯', [
                    'payment_id' => $payment['id'],
                    'order_id' => $payment['order_id'],
                    'user_id' => $notes['user_id'] ?? 'not_set',
                    'amount' => $payment['amount'] ?? 'not_set',
                    'notes' => $notes,
                    'full_payment_entity' => $payment,
                    'timestamp' => now(),
                    'special_flag' => 'VIDEO_39_WEBHOOK_RECEIVED'
                ]);
            }
            
            if (isset($notes['user_id']) && $notes['user_id'] == '201673') {
                \Log::info('👤👤👤 USER 201673 WEBHOOK DETECTED - SPECIAL LOGGING 👤👤👤', [
                    'payment_id' => $payment['id'],
                    'order_id' => $payment['order_id'],
                    'user_id' => $notes['user_id'],
                    'video_id' => $notes['video_id'] ?? 'not_set',
                    'amount' => $payment['amount'] ?? 'not_set',
                    'notes' => $notes,
                    'timestamp' => now(),
                    'special_flag' => 'USER_201673_WEBHOOK_RECEIVED'
                ]);
            }

            // Calculate to_time for successful payments
            $setting = Setting::first();
            $ppv_hours = $setting->ppv_hours;
            $d = new \DateTime('now');
            $d->setTimezone(new \DateTimeZone('Asia/Kolkata'));
            $now = $d->format('Y-m-d h:i:s a');
            $from_time = $now; // Start time (when payment is captured)
            $to_time = date('Y-m-d h:i:s a', strtotime('+' . $ppv_hours . ' hour', strtotime($now)));

            // Extract data from notes
            $purchase_type = $notes['purchase_type'] ?? null;
            $order_id_from_payment = $payment['order_id'] ?? null;
            $razorpay_payment_id = $payment['id'];
            $user_id_from_notes = $notes['user_id'] ?? null;

            \Log::info('Razorpay Webhook: Extracted key data', [
                'purchase_type' => $purchase_type,
                'order_id' => $order_id_from_payment,
                'user_id' => $user_id_from_notes,
                'payment_id' => $razorpay_payment_id,
                'from_time' => $from_time,
                'to_time' => $to_time
            ]);

            if (!$order_id_from_payment || !$user_id_from_notes) {
                \Log::error('Razorpay Webhook: Missing required data for purchase creation', [
                    'order_id' => $order_id_from_payment,
                    'user_id' => $user_id_from_notes,
                    'payment_id' => $razorpay_payment_id,
                    'notes' => $notes
                ]);
                DB::commit();
                return response()->json(['success' => false, 'error' => 'Missing required data']);
            }

            // Check if purchase already exists
            $existingPurchase = PpvPurchase::where('payment_id', $order_id_from_payment)->first();

            if ($existingPurchase) {
                if ($existingPurchase->status === 'captured') {
                    \Log::info('Razorpay Webhook: Purchase already exists with captured status', [
                        'purchase_id' => $existingPurchase->id,
                        'order_id' => $order_id_from_payment
                    ]);
                    DB::commit();
                    return response()->json(['success' => true, 'message' => 'Purchase already captured']);
                } elseif ($existingPurchase->status === 'pending') {
                    // Update existing pending purchase to captured
                    \Log::info('Razorpay Webhook: Updating pending purchase to captured', [
                        'purchase_id' => $existingPurchase->id,
                        'order_id' => $order_id_from_payment,
                        'user_id' => $existingPurchase->user_id,
                        'video_id' => $existingPurchase->video_id
                    ]);

                    // Special logging for video 39
                    if ($existingPurchase->video_id == 39) {
                        \Log::info('🎯 VIDEO 39 PENDING PURCHASE UPDATE', [
                            'purchase_id' => $existingPurchase->id,
                            'order_id' => $order_id_from_payment,
                            'user_id' => $existingPurchase->user_id,
                            'video_id' => $existingPurchase->video_id,
                            'current_status' => $existingPurchase->status,
                            'about_to_update_to' => 'captured',
                            'razorpay_payment_id' => $razorpay_payment_id,
                            'timestamp' => now()
                        ]);
                    }

                    $existingPurchase->update([
                        'status' => 'captured',
                        'razorpay_payment_id' => $razorpay_payment_id,
                        'from_time' => $from_time,
                        'to_time' => $to_time,
                        'updated_at' => now()
                    ]);

                    // Update live_purchases table if applicable
                    if ($purchase_type === 'live_event' && isset($notes['live_id'])) {
                        DB::table('live_purchases')
                            ->where('payment_id', $order_id_from_payment)
                            ->update([
                                'status' => 1,
                                'payment_status' => 'captured',
                                'razorpay_payment_id' => $razorpay_payment_id,
                                'updated_at' => now()
                            ]);
                    }

                    \Log::info('Razorpay Webhook: Successfully updated pending purchase to captured', [
                        'purchase_id' => $existingPurchase->id,
                        'order_id' => $order_id_from_payment,
                        'razorpay_payment_id' => $razorpay_payment_id
                    ]);

                    DB::commit();
                    return response()->json(['success' => true, 'message' => 'Purchase updated to captured']);
                } else {
                    \Log::warning('Razorpay Webhook: Purchase exists with unexpected status', [
                        'purchase_id' => $existingPurchase->id,
                        'order_id' => $order_id_from_payment,
                        'existing_status' => $existingPurchase->status
                    ]);
                }
            }

            // Comprehensive commission calculation for all content types
            $moderator_commssion = 0;
            $admin_commssion = 0;
            $moderator_id = null;
            $amount = ($payment['amount'] ?? 0) / 100;

            \Log::info('Razorpay Webhook: Starting commission calculation', [
                'amount' => $amount,
                'notes_video_id' => $notes['video_id'] ?? 'not_set',
                'notes_live_id' => $notes['live_id'] ?? 'not_set',
                'notes_season_id' => $notes['season_id'] ?? 'not_set'
            ]);

            // Video commission calculation
            if (isset($notes['video_id']) && !empty($notes['video_id'])) {
                \Log::info('Razorpay Webhook: Processing video commission', ['video_id' => $notes['video_id']]);
                
                $video = Video::find($notes['video_id']);
                if ($video) {
                    \Log::info('Razorpay Webhook: Video found', [
                        'video_id' => $video->id,
                        'video_title' => $video->title,
                        'user_id' => $video->user_id,
                        'cpp_commission_percentage' => $video->CPP_commission_percentage
                    ]);

                    $moderators_id = $video->user_id;
                    $CppUser_details = ModeratorsUser::find($moderators_id);
                    $commssion = VideoCommission::where('type', 'Cpp')->first();
                    $default_percentage = $commssion->percentage ?? 0;
                    $commission_percentage_value = $video->CPP_commission_percentage;

                    $commission_btn = $setting->CPP_Commission_Status;
                    if ($commission_btn === 0) {
                        $commission_percentage_value = $CppUser_details->commission_percentage ?? $default_percentage;
                    }

                    $moderator_commssion = ($amount * $commission_percentage_value) / 100;
                    $admin_commssion = $amount - $moderator_commssion;
                    $moderator_id = $moderators_id;

                    \Log::info('Razorpay Webhook: Video commission calculated', [
                        'commission_percentage' => $commission_percentage_value,
                        'moderator_commission' => $moderator_commssion,
                        'admin_commission' => $admin_commssion,
                        'moderator_id' => $moderator_id
                    ]);
                } else {
                    \Log::warning('Razorpay Webhook: Video not found', ['video_id' => $notes['video_id']]);
                }
            }
            // Live stream commission calculation
            elseif (isset($notes['live_id']) && !empty($notes['live_id'])) {
                \Log::info('Razorpay Webhook: Processing live stream commission', ['live_id' => $notes['live_id']]);
                
                $video = LiveStream::find($notes['live_id']);
                if ($video) {
                    $moderators_id = $video->user_id;
                    $moderator = ModeratorsUser::find($moderators_id);
                    $percentage = $moderator->commission_percentage ?? 0;
                    $moderator_commssion = ($percentage / 100) * $video->ppv_price;
                    $admin_commssion = $video->ppv_price - $moderator_commssion;
                    $moderator_id = $moderators_id;

                    \Log::info('Razorpay Webhook: Live stream commission calculated', [
                        'commission_percentage' => $percentage,
                        'moderator_commission' => $moderator_commssion,
                        'admin_commission' => $admin_commssion,
                        'moderator_id' => $moderator_id
                    ]);
                } else {
                    \Log::warning('Razorpay Webhook: Live stream not found', ['live_id' => $notes['live_id']]);
                }
            }
            // Series season commission calculation
            elseif (isset($notes['season_id']) && !empty($notes['season_id'])) {
                \Log::info('Razorpay Webhook: Processing season commission', ['season_id' => $notes['season_id']]);
                
                $SeriesSeason = SeriesSeason::find($notes['season_id']);
                if ($SeriesSeason) {
                    $series_id = $SeriesSeason->series_id;
                    $Series = Series::find($series_id);

                    if ($Series) {
                        $moderators_id = $Series->user_id;
                        $moderator = ModeratorsUser::find($moderators_id);
                        $percentage = $moderator->commission_percentage ?? 0;
                        $moderator_commssion = ($percentage / 100) * $SeriesSeason->ppv_price;
                        $admin_commssion = $SeriesSeason->ppv_price - $moderator_commssion;
                        $moderator_id = $moderators_id;

                        \Log::info('Razorpay Webhook: Season commission calculated', [
                            'commission_percentage' => $percentage,
                            'moderator_commission' => $moderator_commssion,
                            'admin_commission' => $admin_commssion,
                            'moderator_id' => $moderator_id
                        ]);
                    } else {
                        \Log::warning('Razorpay Webhook: Series not found for season', ['season_id' => $notes['season_id'], 'series_id' => $series_id]);
                    }
                } else {
                    \Log::warning('Razorpay Webhook: Season not found', ['season_id' => $notes['season_id']]);
                }
            } else {
                \Log::warning('Razorpay Webhook: No valid content ID found in notes for commission calculation', [
                    'notes' => $notes
                ]);
            }

            // ====================================================================
            //  Purchase Type-Specific Logic
            // ====================================================================
            switch ($purchase_type) {

                case 'live_event':
                                            Log::info('🎬 Processing live_event purchase using live_purchases table.', ['order_id' => $order_id_from_payment]);
                    $live_event_id = $notes['live_event_id'] ?? $notes['video_id'] ?? $notes['live_id'] ?? null;

                    if (!$live_event_id) {
                        Log::error('❌ Critical: live_event_id not found in notes for live_event purchase.', ['notes' => $notes]);
                        DB::rollBack();
                        return response()->json(['success' => false, 'error' => 'Missing live_event_id'], 400);
                    }

                    $purchase = \App\LivePurchase::where('payment_id', $order_id_from_payment)->first();

                    if ($purchase) {
                        Log::info('Found existing LivePurchase record.', ['id' => $purchase->id]);
                        if ($this->isValidStatusTransition($purchase->payment_status, 'captured')) {
                            $purchase->payment_status = 'captured';
                            $purchase->payment_id = $order_id_from_payment;
                            $purchase->from_time = $from_time;
                            $purchase->to_time = $to_time;
                            $purchase->save();
                            Log::info('✅ LivePurchase record updated to captured.', ['id' => $purchase->id]);
                        } else {
                            Log::warning('⚠️ Invalid status transition for LivePurchase.', ['id' => $purchase->id, 'from' => $purchase->payment_status, 'to' => 'captured']);
                        }
                    } else {
                        Log::warning('❓ LivePurchase record not found by order_id. Creating a new one from webhook data.', ['order_id' => $order_id_from_payment]);
                        if (!$user_id_from_notes) {
                                Log::error('❌ Critical: user_id not found in notes for new live purchase.', ['notes' => $notes]);
                                DB::rollBack();
                                return response()->json(['success' => false, 'error' => 'Missing user_id'], 400);
                        }
                        
                        \App\LivePurchase::create([
                            'user_id' => $user_id_from_notes,
                            'video_id' => $live_event_id, // live_purchases uses video_id for live events
                            'payment_id' => $order_id_from_payment,
                            'payment_status' => 'captured',
                            'total_amount' => $amount,
                            'payment_gateway' => 'razorpay',
                            'platform' => $notes['platform'] ?? 'unknown',
                            'ppv_plan' => $notes['ppv_plan'] ?? 'default',
                            'amount' => $amount,
                            'from_time' => $from_time,
                            'to_time' => $to_time,
                            'status' => 1, // live_purchases uses integer status
                        ]);
                        Log::info('✅ New LivePurchase record created from webhook.', ['order_id' => $order_id_from_payment]);
                    }
                    break;

                case 'ppv':
                case 'series_season':
                default:
                    // This block handles standard PPV and can be expanded for other types.
                    Log::info('🎥 Processing standard PPV or other purchase type.', ['type' => $purchase_type, 'order_id' => $order_id_from_payment]);
                    $purchase = PpvPurchase::where('payment_id', $order_id_from_payment)->first();

                    if ($purchase) {
                        if ($this->isValidStatusTransition($purchase->status, 'captured')) {
                            $purchase->status = 'captured';
                            $purchase->razorpay_payment_id = $razorpay_payment_id;
                            $purchase->save();
                            Log::info('✅ PPV record updated to captured.', ['id' => $purchase->id]);
                        } else {
                            Log::warning('⚠️ Invalid status transition for PPV.', ['id' => $purchase->id, 'from' => $purchase->status, 'to' => 'captured']);
                        }
                    } else {
                        Log::warning('❓ PPV record not found by order_id. Creating a new one from webhook data.', ['order_id' => $order_id_from_payment]);
                        $purchaseData = [
                            'user_id' => $user_id_from_notes,
                            'payment_id' => $order_id_from_payment,
                            'razorpay_payment_id' => $razorpay_payment_id,
                            'total_amount' => $amount,
                            'status' => 'captured',
                            'payment_gateway' => 'razorpay',
                            'platform' => $notes['platform'] ?? 'Android',
                            'from_time' => $from_time,
                            'to_time' => $to_time,
                            'ppv_plan' => $notes['ppv_plan'] ?? null,
                            'moderator_commssion' => $moderator_commssion,
                            'admin_commssion' => $admin_commssion,
                            'moderator_id' => $moderator_id,
                        ];
                        if (isset($notes['video_id'])) $purchaseData['video_id'] = $notes['video_id'];
                        if (isset($notes['season_id'])) $purchaseData['season_id'] = $notes['season_id'];
                        PpvPurchase::create($purchaseData);
                        Log::info('✅ New PPV record created from webhook.', ['order_id' => $order_id_from_payment]);
                    }
                    break;
            }

            DB::commit();
            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Razorpay Webhook: Error processing captured payment', [
                'error' => $e->getMessage(),
                'payment_id' => $payment['id'] ?? null,
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['success' => false, 'error' => 'Webhook processing failed'], 500);
        }
    }

    private function handlePaymentFailed($payload)
    {
        $payment = $payload['payload']['payment']['entity'] ?? null;
        if (!$payment) {
            \Log::error('Razorpay Webhook: Invalid payment data in payload');
            return;
        }

        DB::beginTransaction();
        try {
            // Check for duplicate webhook event with locking
            $existingWebhookRecord = DB::table('payment_webhook')
                ->where('payment_id', $payment['id'])
                ->where('event_type', 'payment.failed')
                ->lockForUpdate()
                ->first();

            if ($existingWebhookRecord) {
                DB::commit();
                \Log::info('Razorpay Webhook: Duplicate payment.failed event, skipping', [
                    'payment_id' => $payment['id']
                ]);
                return response()->json(['success' => true, 'message' => 'Duplicate event']);
            }

            // Log the webhook event
            DB::table('payment_webhook')->insert([
                'order_id' => $payment['order_id'] ?? null,
                'payment_id' => $payment['id'] ?? null,
                'amount' => ($payment['amount'] ?? 0) / 100, // Convert from paisa to rupees
                'status' => 'TXN_FAILURE',
                'event_type' => 'payment.failed',
                'payload' => json_encode($payload),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Check if there's already a purchase record with locking
            $purchase = \App\PpvPurchase::where('payment_id', $payment['id'])
                ->orWhere('payment_id', $payment['order_id'])
                ->lockForUpdate()
                ->first();

            if ($purchase) {
                // Verify valid status transition
                if (!$this->isValidStatusTransition($purchase->status, 'failed')) {
                    \Log::warning("Razorpay Webhook: Invalid status transition from {$purchase->status} to failed", [
                        'payment_id' => $payment['id'],
                        'purchase_id' => $purchase->id,
                        'current_status' => $purchase->status
                    ]);
                    DB::commit();
                    return response()->json(['success' => false, 'error' => 'Invalid status transition']);
                }

                // Update the existing purchase to 'failed'
                $purchase->status = 'failed';
                $purchase->payment_failure_reason = $payment['error_description'] ?? $payment['error_code'] ?? 'Unknown error';
                $purchase->save();

                \Log::info('Razorpay Webhook: Purchase marked as failed', [
                    'payment_id' => $payment['id'],
                    'purchase_id' => $purchase->id,
                    'reason' => $purchase->payment_failure_reason
                ]);
            } else {
                // If no purchase record exists yet, check if we need to create one based on notes
                $notes = $payment['notes'] ?? [];

                if (isset($notes['video_id']) && isset($notes['user_id'])) {
                    // Create a failed purchase record for tracking purposes
                    \App\PpvPurchase::create([
                        'user_id' => $notes['user_id'],
                        'video_id' => $notes['video_id'],
                        'payment_id' => $payment['id'],
                        'total_amount' => ($payment['amount'] ?? 0) / 100,
                        'status' => 'failed',
                        'payment_failure_reason' => $payment['error_description'] ?? $payment['error_code'] ?? 'Unknown error',
                        'payment_gateway' => 'razorpay',
                        'platform' => $request->platform ?? 'website',
                        'to_time' => null,
                        'admin_commssion' => null,
                        'moderator_commssion' => null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    \Log::info('Razorpay Webhook: Created failed purchase record', [
                        'payment_id' => $payment['id'],
                        'user_id' => $notes['user_id'],
                        'video_id' => $notes['video_id'],
                        'reason' => $payment['error_description'] ?? $payment['error_code'] ?? 'Unknown error'
                    ]);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Razorpay Webhook: Error processing failed payment', [
                'error' => $e->getMessage(),
                'payment_id' => $payment['id'] ?? null,
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Handle subscription.authenticated event
     *
     * @param array $payload
     * @return void
     */
    private function handleSubscriptionAuthenticated($payload)
    {
        $subscription = $payload['payload']['subscription']['entity'] ?? null;
        if (!$subscription) {
            \Log::error('Razorpay Webhook: Invalid subscription data in payload');
            return;
        }

        DB::table('payment_webhook')->insert([
            'order_id' => null,
            'payment_id' => null,
            'subscription_id' => $subscription['id'],
            'amount' => 0,
            'status' => 'SUBSCRIPTION_AUTHENTICATED',
            'event_type' => 'subscription.authenticated',
            'payload' => json_encode($payload),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        \Log::info('Razorpay Webhook: Subscription authenticated', [
            'subscription_id' => $subscription['id'],
        ]);
    }


    /**
     * Handle subscription.activated event
     *
     * @param array $payload
     * @return void
     */
    private function handleSubscriptionActivated($payload)
    {
        $subscription = $payload['payload']['subscription']['entity'] ?? null;
        if (!$subscription) {
            \Log::error('Razorpay Webhook: Invalid subscription data in payload');
            return;
        }

        // Log the webhook
        DB::table('payment_webhook')->insert([
            'order_id' => null,
            'payment_id' => null,
            'subscription_id' => $subscription['id'],
            'amount' => 0,
            'status' => 'SUBSCRIPTION_ACTIVATED',
            'event_type' => 'subscription.activated',
            'payload' => json_encode($payload),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Convert Unix timestamps to Carbon dates
        $startDate = isset($subscription['current_start']) ? Carbon::createFromTimestamp($subscription['current_start']) : null;
        $endDate = isset($subscription['current_end']) ? Carbon::createFromTimestamp($subscription['current_end']) : null;

        // Update subscriber table
        DB::table('subscriber')
            ->where('gateway_subscription_id', $subscription['id'])
            ->update([
                'payment_status' => 'active',
                'start_date' => $startDate,
                'end_date' => $endDate,
                'updated_at' => now(),
            ]);

        // Update user role to 'subscriber'
        $subscriber = DB::table('subscriber')
            ->where('gateway_subscription_id', $subscription['id'])
            ->first();

        if ($subscriber && $subscriber->user_id) {
            DB::table('users')
                ->where('id', $subscriber->user_id)
                ->update([
                    'role' => 'subscriber',
                    'updated_at' => now(),
                ]);
        }

        \Log::info('Razorpay Webhook: Subscription activated', [
            'subscription_id' => $subscription['id'],
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);
    }




    /**
     * Handle subscription.charged event
     *
     * @param array $payload
     * @return void
     */
    private function handleSubscriptionCharged($payload)
    {
        $subscription = $payload['payload']['subscription']['entity'] ?? null;
        $payment = $payload['payload']['payment']['entity'] ?? null;

        if (!$subscription || !$payment) {
            \Log::error('Razorpay Webhook: Invalid subscription or payment data in payload');
            return;
        }

        // Log the webhook
        DB::table('payment_webhook')->insert([
            'order_id' => null,
            'payment_id' => $payment['id'],
            'subscription_id' => $subscription['id'],
            'amount' => ($payment['amount'] ?? 0) / 100,
            'status' => 'TXN_SUCCESS',
            'event_type' => 'subscription.charged',
            'payload' => json_encode($payload),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $startDate = isset($subscription['current_start']) ? Carbon::createFromTimestamp($subscription['current_start']) : null;
        $endDate = isset($subscription['current_end']) ? Carbon::createFromTimestamp($subscription['current_end']) : null;

        // Update subscriber table
        DB::table('subscriber')
            ->where('gateway_subscription_id', $subscription['id'])
            ->update([
                'amount' => ($payment['amount'] ?? 0) / 100,
                'payment_status' => 'active',
                'start_date' => $startDate,
                'end_date' => $endDate,
                'updated_at' => now(),
            ]);

        // Update user role to 'subscriber'
        $subscriber = DB::table('subscriber')
            ->where('gateway_subscription_id', $subscription['id'])
            ->first();

        if ($subscriber && $subscriber->user_id) {
            DB::table('users')
                ->where('id', $subscriber->user_id)
                ->update([
                    'role' => 'subscriber',
                    'updated_at' => now(),
                ]);
        }

        \Log::info('Razorpay Webhook: Subscription charged', [
            'subscription_id' => $subscription['id'],
            'payment_id' => $payment['id'],
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);
    }



    /**
     * Handle subscription.cancelled event
     *
     * @param array $payload
     * @return void
     */
    private function handleSubscriptionCancelled($payload)
    {
        $subscription = $payload['payload']['subscription']['entity'] ?? null;
        if (!$subscription) {
            \Log::error('Razorpay Webhook: Invalid subscription data in payload');
            return;
        }

        // Insert into webhook log table
        DB::table('payment_webhook')->insert([
            'order_id' => null,
            'payment_id' => null,
            'subscription_id' => $subscription['id'],
            'amount' => 0,
            'status' => 'SUBSCRIPTION_CANCELLED',
            'event_type' => 'subscription.cancelled',
            'payload' => json_encode($payload),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Update subscriber table
        DB::table('subscriber')
            ->where('gateway_subscription_id', $subscription['id'])
            ->update([
                'payment_status' => 'cancelled',
                'updated_at' => now(),
            ]);

        // Update User role to 'registered'
        $subscriber = DB::table('subscriber')
            ->where('gateway_subscription_id', $subscription['id'])
            ->first();

        if ($subscriber && $subscriber->user_id) {
            DB::table('users')
                ->where('id', $subscriber->user_id)
                ->update([
                    'role' => 'registered',
                    'updated_at' => now(),
                ]);
        }

        \Log::info('Razorpay Webhook: Subscription cancelled', [
            'subscription_id' => $subscription['id'],
        ]);
    }


}

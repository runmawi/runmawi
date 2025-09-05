<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\AdminOTPCredentials;
use App\VideoCommission;
use App\ModeratorsUser;
use App\SeriesSeason;
use App\PpvPurchase;
use App\LiveStream;
use App\LivePurchase;
use App\UserAccess;
use App\Video;
use App\Series;
use App\Audio;
use Theme;
use App\Setting;
use App\ModeratorsRole;

class ProducerController extends Controller
{
    protected $current_time;
    public function __construct()
    {
        $current_timezone = 'Asia/Kolkata';
        $this->current_time = Carbon::now($current_timezone);
    }

    // Login Module

    public function login(Request $request)
    {
        try {

            $current_timezone = 'Asia/Kolkata';
            $current_time = Carbon::now($current_timezone);

            $jsonString = file_get_contents(base_path('assets/country_code.json'));
            $jsondata = json_decode($jsonString, true);

            $data = array(
                'current_timezone' => $current_timezone,
                'current_time' => $current_time,
                'jsonString' => $jsonString,
                'jsondata' => $jsondata,
            );

            return view('producer.login', $data);

        } catch (\Throwable $th) {
            Log::error('ProducerController.stats exception', [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                'cpp_user_id' => session()->get('cpp_user_id'),
                'source' => isset($source) ? $source : null,
                'source_id' => isset($source_id) ? $source_id : null,
                'route' => 'producer.stats',
            ]);
            return abort(404);
        }
    }

    public function verify_login(Request $request)
    {
        try {

            $request->validate([
                'mobile_number' => 'required',
                'otp' => 'required'
            ]);

            $ModeratorsUser = ModeratorsUser::where([['mobile_number', $request->mobile_number], ['status', 1]])->first();

            if (!$ModeratorsUser) {
                return back()->withErrors(['mobile_number' => 'Invalid Mobile Number.']);
            }

            if ($ModeratorsUser->otp != $request->otp) {
                return back()->withErrors(['Password' => 'Invalid Password.']);
            }

            if (!empty($ModeratorsUser->parent_moderator_id) || $ModeratorsUser->parent_moderator_id != null) {
                $ModeratorsUser->id = $ModeratorsUser->parent_moderator_id;
            }

            $request->session()->put('cpp_user_id', $ModeratorsUser->id);

            return redirect()->route('producer.home');

        } catch (\Throwable $th) {

            return abort(404);
        }
    }

    // Signup Module

    public function signup(Request $request)
    {
        try {

            $current_timezone = 'Asia/Kolkata';
            $current_time = Carbon::now($current_timezone);

            $jsonString = file_get_contents(base_path('assets/country_code.json'));
            $jsondata = json_decode($jsonString, true);

            $data = array(
                'current_timezone' => $current_timezone,
                'current_time' => $current_time,
                'jsonString' => $jsonString,
                'jsondata' => $jsondata,
            );

            return view('producer.signup', $data);

        } catch (\Throwable $th) {

            return abort(404);
        }
    }

    public function Signup_check_mobile_exist(Request $request)
    {
        $mobile_number = $request->input('mobile_number');

        if (is_null($mobile_number)) {
            return response()->json(['exists' => false]);
        }

        $user = ModeratorsUser::where('mobile_number', $mobile_number)->where('ccode', $request->ccode)->first();

        if (is_null($user)) {

            ModeratorsUser::updateOrCreate([
                'ccode' => $request->ccode,
                'mobile_number' => $request->mobile_number,
            ]);

            return response()->json(['exists' => true]);
        } else {

            if ($user->signup_exits_status == 1) {
                return response()->json(['exists' => false]);
            } else {

                return response()->json(['exists' => true]);
            }
        }
    }

    public function Signup_Sending_OTP(Request $request)
    {
        $AdminOTPCredentials = AdminOTPCredentials::where('status', 1)->first();

        if (is_null($AdminOTPCredentials)) {
            return response()->json(['exists' => false, 'message_note' => 'Some Error in OTP Config, Please connect admin']);
        }

        try {

            $random_otp_number = random_int(1000, 9999);
            $ccode = str_replace('+', '', $request->ccode);
            $mobile = $request->mobile_number;
            $Mobile_number = $ccode . $request->mobile;

            $user = ModeratorsUser::where('mobile_number', $mobile)->where('ccode', $ccode)->where('signup_exits_status', 0)->first();

            if ($AdminOTPCredentials->otp_vai == "24x7sms") {

                $API_key_24x7sms = $AdminOTPCredentials->otp_24x7sms_api_key;
                $SenderID = $AdminOTPCredentials->otp_24x7sms_sender_id;
                $ServiceName = $AdminOTPCredentials->otp_24x7sms_sevicename;

                $DLTTemplateID = $AdminOTPCredentials->DLTTemplateID;
                $message = Str_replace('{#var#}', $random_otp_number, $AdminOTPCredentials->template_message);

                $inputs = array(
                    'APIKEY' => $API_key_24x7sms,
                    'MobileNo' => $Mobile_number,
                    'SenderID' => $SenderID,
                    'ServiceName' => $ServiceName,
                );

                if ($ServiceName == "TEMPLATE_BASED") {
                    $inputs += array(
                        // 'DLTTemplateID' => $DLTTemplateID,
                        'Message' => $message,
                    );
                }

                $response = Http::withoutVerifying()->get('https://smsapi.24x7sms.com/api_2.0/SendSMS.aspx', $inputs);

                if (str_contains($response->body(), 'success')) {

                    $parts = explode(':', $response->body());
                    $msgId = $parts[1];

                    ModeratorsUser::find($user->id)->update(
                        [
                            'otp' => $random_otp_number,
                            'otp_request_id' => $msgId,
                            'otp_through' => $AdminOTPCredentials->otp_vai,
                        ]
                    );

                    return response()->json(['exists' => true, 'message_note' => 'OTP Sent Successfully!']);

                } else {

                    $errorMessage = $response->body() ?? 'An unknown error occurred';

                    return response()->json(['exists' => false, 'message_note' => 'OTP Not Sent!', 'error_details' => $errorMessage]);

                }
            }

        } catch (\Throwable $th) {

            return response()->json(['exists' => false, 'message_note' => 'OTP Not Sent!', 'error_note' => $th->getMessage()]);
        }
    }

    public function signup_otp_verification(Request $request)
    {
        try {

            $ccode = str_replace('+', '', $request->ccode);
            $mobileNumber = $request->mobileNumber;

            $user_verify = ModeratorsUser::where('mobile_number', $mobileNumber)->where('ccode', $ccode)->where('otp', $request->otp)
                ->where('signup_exits_status', 0)->first();

            if (!is_null($user_verify)) {

                $commission_percentage = VideoCommission::where('type', 'CPP')->pluck('percentage')->first();
                $CPP_commission_percentage = $commission_percentage ? 100 - $commission_percentage : null;

                ModeratorsUser::find($user_verify->id)->update([
                    'username' => $request->username,
                    'signup_exits_status' => 1,
                    'password' => Hash::make($request->otp),
                    'commission_percentage' => $CPP_commission_percentage,
                    'user_permission' => '1,2',
                    'status' => 0,
                    'user_role' => 3,
                ]);

                UserAccess::updateOrCreate([
                    'user_id' => $user_verify->id,
                    'role_id' => 3,
                    'permissions_id' => 2,
                ]);

                session()->flash('Regiter_successfully', 'Producer Registered Successfully, Waiting for Admin Approval.');

                return response()->json([
                    'status' => true,
                    'message_note' => 'OTP verify successfully &  wait a few seconds to register !',
                ]);
            }

            return response()->json(['status' => false, 'message_note' => 'Please, Enter the Valid OTP !']);

        } catch (\Throwable $th) {

            return response()->json(['status' => false, 'fails' => $th->getMessage()]);
        }
    }

    // Dashboard Module

    public function home(Request $request)
    {
        try {

            $current_time = $this->current_time;
            $cpp_user_id = session()->get('cpp_user_id');

            $commission_btn = Setting::pluck('CPP_Commission_Status')->first();
            $CppUser_details = ModeratorsUser::where('id', $cpp_user_id)->first();
            $role_name = $CppUser_details ? ModeratorsRole::where('id', $CppUser_details->user_role)->pluck('role_name')->first() : null;
            $normalizedRole = $role_name !== null ? strtolower(trim($role_name)) : null;
            $isAdminProducer = $normalizedRole !== null && (in_array($normalizedRole, ['admin','administrator','super admin','superadmin']) || stripos($role_name, 'admin') !== false);
            $video_commission_percentage = VideoCommission::where('type', 'Cpp')->pluck('percentage')->first();
            $commission_percentage_value = null;

            if ($commission_btn == 0) {
                $commission_percentage_value = !empty($CppUser_details->commission_percentage) ? $CppUser_details->commission_percentage : $video_commission_percentage;
            }

            // filter date
            $filter_date = '2024-12-15';

            // Current Time
            $today = $current_time->toDateString();
            $current_month = $current_time->month;
            $current_year = $current_time->year;

            // Previous Time
            $last_year = $current_time->copy()->subYear()->year;

            $last_month_year = $current_time->copy()->subMonths(1);
            $last2nd_month_year = $current_time->copy()->subMonths(2);
            $last3nd_month_year = $current_time->copy()->subMonths(3);

            // PPV metrics (exclude live to avoid double counting with live_purchases)
            $ppv_base = PpvPurchase::query()
                ->when(!$isAdminProducer, function ($q) use ($cpp_user_id) {
                    return $q->where('moderator_id', $cpp_user_id);
                })
                ->whereNull('live_id')
                ->where('created_at', '>=', $filter_date)
                ->where(function ($query) {
                    $query->where('status', 'captured')->orWhere('status', 1);
                });

            $ppv_purchases_today = (clone $ppv_base)
                ->whereDate('created_at', $today)
                ->get();

            $ppv_purchases_current_month = (clone $ppv_base)
                ->whereYear('created_at', $current_year)
                ->whereMonth('created_at', $current_month)
                ->get();

            $ppv_purchases_last_month = (clone $ppv_base)
                ->whereYear('created_at', $last_month_year->year)
                ->whereMonth('created_at', $last_month_year->month)
                ->get();

            $ppv_purchases_last2ndmonth = (clone $ppv_base)
                ->whereYear('created_at', $last2nd_month_year->year)
                ->whereMonth('created_at', $last2nd_month_year->month)
                ->get();

            $ppv_purchases_last3rdmonth = (clone $ppv_base)
                ->whereYear('created_at', $last3nd_month_year->year)
                ->whereMonth('created_at', $last3nd_month_year->month)
                ->get();

            $ppv_purchases_current_year = (clone $ppv_base)
                ->whereYear('created_at', $current_year)
                ->get();

            $ppv_purchases_last_year = (clone $ppv_base)
                ->whereYear('created_at', $last_year)
                ->get();

            $ppv_purchases_total = (clone $ppv_base)->get();

            // Live purchases metrics from live_purchases joined to producer-owned streams
            $live_base = LivePurchase::query()
                ->join('live_streams', 'live_streams.id', '=', 'live_purchases.video_id')
                ->when(!$isAdminProducer, function ($q) use ($cpp_user_id) {
                    return $q->where('live_streams.user_id', $cpp_user_id);
                })
                ->where(function ($q) {
                    $q->where('live_purchases.status', 1);
                })
                ->where('live_purchases.created_at', '>=', $filter_date)
                ->select('live_purchases.*');

            $live_today = (clone $live_base)->whereDate('live_purchases.created_at', $today)->get();
            $live_current_month = (clone $live_base)->whereYear('live_purchases.created_at', $current_year)
                ->whereMonth('live_purchases.created_at', $current_month)->get();
            $live_last_month = (clone $live_base)->whereYear('live_purchases.created_at', $last_month_year->year)
                ->whereMonth('live_purchases.created_at', $last_month_year->month)->get();
            $live_last2ndmonth = (clone $live_base)->whereYear('live_purchases.created_at', $last2nd_month_year->year)
                ->whereMonth('live_purchases.created_at', $last2nd_month_year->month)->get();
            $live_last3rdmonth = (clone $live_base)->whereYear('live_purchases.created_at', $last3nd_month_year->year)
                ->whereMonth('live_purchases.created_at', $last3nd_month_year->month)->get();
            $live_current_year = (clone $live_base)->whereYear('live_purchases.created_at', $current_year)->get();
            $live_last_year = (clone $live_base)->whereYear('live_purchases.created_at', $last_year)->get();
            $live_total = (clone $live_base)->get();

            // Sales summary from PPV (excluding live) and LIVE
            $Sales_Summary = PpvPurchase::query()
                ->when(!$isAdminProducer, function($q) use ($cpp_user_id){
                    return $q->where('moderator_id', $cpp_user_id);
                })
                ->whereNull('live_id')
                ->where('created_at', '>=', $filter_date)
                ->where(function ($query) {
                    $query->where('status', 'captured')->orWhere('status', '1');
                })
                ->select([
                    'video_id',
                    DB::raw('NULL as live_id'),
                    'audio_id',
                    'series_id',
                    'season_id',
                    DB::raw('SUM(total_amount) as total_amount_without_gst'),  // Original total amount with GST
                    DB::raw('SUM(total_amount * 0.18) as total_amount_with_gst'),  // Amount without GST
                    DB::raw('SUM(total_amount) - SUM(total_amount * 0.18) as gst_value'),  // Exact GST value (18%)
                    DB::raw('SUM(admin_commssion) - (SUM(admin_commssion * 0.18)) as admin_commission_sum'),
                    DB::raw('SUM(moderator_commssion) - (SUM(moderator_commssion * 0.18)) as moderator_commission_sum'),
                    DB::raw('((SUM(admin_commssion) - (SUM(admin_commssion * 0.18))) / NULLIF(( SUM(total_amount) - SUM(total_amount * 0.18)), 0)) * 100 as admin_commission_percentage'),  // Admin commission percentage
                    DB::raw('((SUM(moderator_commssion) - (SUM(moderator_commssion * 0.18))) / NULLIF(( SUM(total_amount) - SUM(total_amount * 0.18)), 0)) * 100 as moderator_commission_percentage'),  // Moderator commission percentage
                    // DB::raw('((SUM(moderator_commssion) - (SUM(moderator_commssion) * 0.18)) / SUM(total_amount * 0.18)) * 100 as moderator_commission_percentage'),  // Moderator commission percentage
                    DB::raw('CASE 
                                                            WHEN video_id IS NOT NULL THEN video_id
                                                            WHEN audio_id IS NOT NULL THEN audio_id
                                                            WHEN series_id IS NOT NULL THEN series_id
                                                            WHEN season_id IS NOT NULL THEN season_id
                                                            ELSE NULL
                                                        END as source_id'),
                    DB::raw('CASE 
                                                            WHEN video_id IS NOT NULL THEN "Video"
                                                            WHEN audio_id IS NOT NULL THEN "Audio"
                                                            WHEN series_id IS NOT NULL THEN "Series"
                                                            WHEN season_id IS NOT NULL THEN "SeriesSeason"
                                                            ELSE NULL
                                                        END as source')
                ])
                ->groupBy('video_id', 'audio_id', 'series_id', 'season_id')

                ->get()->map(function ($item) use ($isAdminProducer) {

                    switch ($item->source) {

                        case 'Video':
                            $q = Video::query()->where('id', $item->source_id);
                            if(!$isAdminProducer){ $q->where('uploaded_by','CPP'); }
                            $item['source_name'] = $q->pluck('title')->first();
                            break;

                        case 'Audio':
                            $q = Audio::query()->where('id', $item->source_id);
                            if(!$isAdminProducer){ $q->where('uploaded_by','CPP'); }
                            $item['source_name'] = $q->pluck('title')->first();
                            break;

                        case 'Series':
                            $q = Series::query()->where('id', $item->source_id);
                            if(!$isAdminProducer){ $q->where('uploaded_by','CPP'); }
                            $item['source_name'] = $q->pluck('title')->first();
                            break;

                        case 'SeriesSeason':
                            $q = SeriesSeason::query()->where('id', $item->source_id);
                            if(!$isAdminProducer){ $q->where('uploaded_by','CPP'); }
                            $item['source_name'] = $q->pluck('title')->first();
                            break;

                        default:
                            $item['source_name'] = null;
                            break;
                    }
                    return $item;
                });

            // Live part of Sales Summary from live_purchases
            $Sales_Summary_Live = LivePurchase::join('live_streams', 'live_streams.id', '=', 'live_purchases.video_id')
                ->when(!$isAdminProducer, function($q) use ($cpp_user_id){
                    return $q->where('live_streams.user_id', $cpp_user_id);
                })
                ->where('live_purchases.created_at', '>=', $filter_date)
                ->whereIn('live_purchases.payment_status', ['captured','completed'])
                ->select([
                    DB::raw('live_purchases.video_id as source_id'),
                    DB::raw('"LiveStream" as source'),
                    // Base gross amount collected
                    DB::raw('SUM(live_purchases.amount) as amount_gross'),
                    // GST amount @18%
                    DB::raw('SUM(live_purchases.amount * 0.18) as gst_amount'),
                    // Net after GST
                    DB::raw('(SUM(live_purchases.amount) - SUM(live_purchases.amount * 0.18)) as amount_net')
                ])
                ->groupBy('live_purchases.video_id')
                ->get()
                ->map(function ($item) use ($cpp_user_id, $isAdminProducer) {
                    $stream = LiveStream::query()
                        ->when(!$isAdminProducer, function($q) use ($cpp_user_id){
                            return $q->where('user_id', $cpp_user_id);
                        })
                        ->where('id', $item->source_id)
                        ->first();
                    $producer_pct = $stream && isset($stream->CPP_commission_percentage)
                        ? (float) $stream->CPP_commission_percentage
                        : 0.0;
                    $net = (float) ($item->amount_net ?? 0);
                    $producer_sum = $net * ($producer_pct / 100.0);
                    $admin_sum = max($net - $producer_sum, 0);

                    $item['source_name'] = $stream ? $stream->title : null;
                    // Backwards-compatible keys expected by the view
                    $item['total_amount_without_gst'] = (float) ($item->amount_gross ?? 0); // shown as "Amount"
                    $item['total_amount_with_gst'] = (float) ($item->gst_amount ?? 0);      // shown as GST 18%
                    $item['gst_value'] = $net;                                             // shown as Total (Amount - GST)
                    $item['moderator_commission_percentage'] = $producer_pct;               // Producer %
                    $item['admin_commission_percentage'] = 100 - $producer_pct;             // Runmawi %
                    $item['moderator_commission_sum'] = $producer_sum;                      // Producer amount
                    $item['admin_commission_sum'] = $admin_sum;                              // Runmawi amount
                    return $item;
                });

            $Sales_Summary = $Sales_Summary->merge($Sales_Summary_Live);


            // Monthly summary for Videos only (non-live), sorted by latest video IDs
            $monthly_Summary = PpvPurchase::query()
                ->when(!$isAdminProducer, function($q) use ($cpp_user_id){
                    return $q->where('moderator_id', $cpp_user_id);
                })
                ->whereNull('live_id')
                ->whereNotNull('video_id')
                ->where('created_at', '>=', $filter_date)
                ->where(function ($query) {
                    $query->where('status', 'captured')->orWhere('status', '1');
                })
                ->select([
                    'video_id',
                    DB::raw('SUM(total_amount) as total_amount_with_gst'),  // Original total amount with GST
                    DB::raw('SUM(total_amount * 0.18) as total_amount_without_gst'),  // Amount without GST
                    DB::raw('SUM(total_amount) - SUM(total_amount * 0.18) as gst_value'),  // Exact GST value (18%)
                    DB::raw('SUM(admin_commssion) as admin_commission_sum'),
                    DB::raw('SUM(moderator_commssion) - (SUM(moderator_commssion * 0.18)) as moderator_commission_sum'),
                    DB::raw('((SUM(admin_commssion) - (SUM(admin_commssion * 0.18))) / NULLIF(( SUM(total_amount) - SUM(total_amount * 0.18)), 0)) * 100 as admin_commission_percentage'),
                    DB::raw('((SUM(moderator_commssion) - (SUM(moderator_commssion * 0.18))) / NULLIF(( SUM(total_amount) - SUM(total_amount * 0.18)), 0)) * 100 as moderator_commission_percentage'),
                    DB::raw('video_id as source_id'),
                    DB::raw('"Video" as source')
                ])
                ->groupBy('video_id')
                ->orderBy('video_id', 'DESC')
                ->get()->map(function ($item) use ($cpp_user_id, $filter_date, $isAdminProducer) {

                    $item['monthly_Summary'] = PpvPurchase::query()
                        ->when(!$isAdminProducer, function($q) use ($cpp_user_id){
                            return $q->where('moderator_id', $cpp_user_id);
                        })
                        ->whereNull('live_id')
                        ->whereBetween('created_at', [Carbon::now()->subMonths(6), Carbon::now()])
                        ->where('created_at', '>=', $filter_date)
                        ->where(function ($query) {
                            $query->where('status', 'captured')->orWhere('status', '1');
                        })
                        ->select([
                            DB::raw('DATE_FORMAT(created_at, "%M, %Y") as month_year'),
                            DB::raw('COUNT(*) as units_sold'),
                            DB::raw('SUM(total_amount) - SUM(total_amount * 0.18) as total_amount'),
                            DB::raw('SUM(admin_commssion) as admin_commission_sum'),
                            DB::raw('((SUM(moderator_commssion) - (SUM(moderator_commssion) * 0.18)) / NULLIF(SUM(total_amount), 0)) * 100 as moderator_commission_percentage'),
                            DB::raw('SUM(moderator_commssion) - (SUM(moderator_commssion * 0.18)) as moderator_commission_sum'),
                        ])
                        ->groupBy(DB::raw('DATE_FORMAT(created_at, "%M, %Y")'))
                        ->orderBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'), 'desc')
                        ->where('video_id', $item->source_id)
                        ->get();

                    // Set source_name and commission from content tables (admin-aware)
                    switch ($item->source) {

                        case 'Video':
                            $vQ = Video::query()->where('id', $item->source_id);
                            if(!$isAdminProducer){ $vQ->where('uploaded_by','CPP'); }
                            $item['source_name'] = $vQ->pluck('title')->first();
                            $item['moderator_commission_percentage'] = (float) (Video::where('id',$item->source_id)->pluck('CPP_commission_percentage')->first() ?? $item['moderator_commission_percentage']);
                            break;

                        default:
                            $item['source_name'] = null;
                            break;
                    }
                    return $item;
                });

            $ppv_purchases_count = [
                'ppv_purchases_today_count' => $ppv_purchases_today->count() + $live_today->count(),
                'ppv_purchases_current_month_count' => $ppv_purchases_current_month->count() + $live_current_month->count(),
                'ppv_purchases_current_year_count' => $ppv_purchases_current_year->count() + $live_current_year->count(),

                'ppv_purchases_last_month_count' => $ppv_purchases_last_month->count() + $live_last_month->count(),
                'ppv_purchases_last2ndmonth_count' => $ppv_purchases_last2ndmonth->count() + $live_last2ndmonth->count(),
                'ppv_purchases_last3rdmonth_count' => $ppv_purchases_last3rdmonth->count() + $live_last3rdmonth->count(),

                'ppv_purchases_last_year_count' => $ppv_purchases_last_year->count() + $live_last_year->count(),

                'ppv_purchases_total_count' => $ppv_purchases_total->count() + $live_total->count(),
                'Free_access_with_promotions' => 0,
            ];

            $sumLive = function ($c) {
                return $c->sum(function ($x) {
                    $val = $x->total_amount ?? $x->amount ?? 0;
                    if (is_string($val)) {
                        $val = preg_replace('/[^\d.\-]/', '', $val);
                    }
                    return (float) $val;
                });
            };
            $ppv_purchases_amount = [
                'ppv_purchases_today_total_amount' => $ppv_purchases_today->sum('total_amount') + $sumLive($live_today),
                'ppv_purchases_current_month_total_amount' => $ppv_purchases_current_month->sum('total_amount') + $sumLive($live_current_month),
                'ppv_purchases_current_year_total_amount' => $ppv_purchases_current_year->sum('total_amount') + $sumLive($live_current_year),

                'ppv_purchases_last_month_total_amount' => $ppv_purchases_last_month->sum('total_amount') + $sumLive($live_last_month),
                'ppv_purchases_last2ndmonth_total_amount' => $ppv_purchases_last2ndmonth->sum('total_amount') + $sumLive($live_last2ndmonth),
                'ppv_purchases_last3rdmonth_total_amount' => $ppv_purchases_last3rdmonth->sum('total_amount') + $sumLive($live_last3rdmonth),

                'ppv_purchases_last_year_total_amount' => $ppv_purchases_last_year->sum('total_amount') + $sumLive($live_last_year),

                'ppv_purchases_total_amount' => $ppv_purchases_total->sum('total_amount') + $sumLive($live_total),
                'ppv_purchases_admin_commission_sum' => $ppv_purchases_total->sum('admin_commssion'),
                'ppv_purchases_cpp_commission_sum' => $ppv_purchases_total->sum('moderator_commssion'),

                'Free_access_with_promotions' => 0,
            ];

            // Unified totals for presentation: Gross, GST, Net, and split shares (excluding GST)
            $gross_ppv = (float) $ppv_purchases_total->sum('total_amount');
            $gross_live = (float) $sumLive($live_total);
            $gross_total = $gross_ppv + $gross_live;

            $gst_total = round($gross_total * 0.18, 2);
            $net_total = max($gross_total - $gst_total, 0);

            // PPV producer share (net of GST) using existing storage convention
            $ppv_producer_sum_net = 0.0;
            if ($ppv_purchases_total->count() > 0) {
                $ppv_comm_sum = (float) $ppv_purchases_total->sum('moderator_commssion');
                // historic convention in this project subtracts 18% on commission while presenting net
                $ppv_producer_sum_net = $ppv_comm_sum - ($ppv_comm_sum * 0.18);
            }

            // LIVE producer share (net of GST) using stream-specific commission percentage
            $live_producer_sum_net = 0.0;
            if ($live_total->count() > 0) {
                $liveStreamPercents = LiveStream::whereIn('id', $live_total->pluck('video_id')->unique())
                    ->pluck('CPP_commission_percentage', 'id');
                foreach ($live_total as $row) {
                    $amt = (float) ($row->amount ?? 0);
                    $netAmt = $amt - ($amt * 0.18);
                    $pct = (float) ($liveStreamPercents[$row->video_id] ?? 0);
                    $live_producer_sum_net += ($netAmt * ($pct / 100.0));
                }
            }

            $producer_share_net_total = $ppv_producer_sum_net + $live_producer_sum_net;
            $runmawi_share_net_total = max($net_total - $producer_share_net_total, 0);

            // If you later add gateway fee tracking, compute and replace this value.
            $transaction_fees_total = 0.0;

            $effective_producer_pct = $net_total > 0 ? round(($producer_share_net_total / $net_total) * 100, 2) : 0.0;
            $effective_admin_pct = $net_total > 0 ? round(($runmawi_share_net_total / $net_total) * 100, 2) : 0.0;

            // Expose unified totals to the view while keeping previous keys for backward compatibility
            $ppv_purchases_amount['gross_total'] = $gross_total;
            $ppv_purchases_amount['gst_total'] = $gst_total;
            $ppv_purchases_amount['net_total'] = $net_total;
            $ppv_purchases_amount['producer_share_net_total'] = $producer_share_net_total;
            $ppv_purchases_amount['runmawi_share_net_total'] = $runmawi_share_net_total;
            $ppv_purchases_amount['transaction_fees_total'] = $transaction_fees_total;
            $ppv_purchases_amount['effective_producer_pct'] = $effective_producer_pct;
            $ppv_purchases_amount['effective_admin_pct'] = $effective_admin_pct;


            $sources_data = [
                'livestream' => LiveStream::query()
                    ->when(!$isAdminProducer, function($q) use ($cpp_user_id){
                        return $q->where('user_id', $cpp_user_id);
                    })
                    ->where('access', 'ppv')
                    ->orderBy('created_at', 'DESC')
                    ->get(),
                'video' => Video::query()
                    ->when(!$isAdminProducer, function($q) use ($cpp_user_id){
                        return $q->where('user_id', $cpp_user_id)
                                 ->where('uploaded_by', 'CPP');
                    })
                    ->when($isAdminProducer, function($q){
                        return $q; // no restriction for admin
                    })
                    ->orderBy('created_at', 'DESC')
                    ->get(),
                'series' => Series::query()
                    ->when(!$isAdminProducer, function($q) use ($cpp_user_id){
                        return $q->where('user_id', $cpp_user_id)
                                 ->where('uploaded_by', 'CPP');
                    })
                    ->when($isAdminProducer, function($q){
                        return $q; // no restriction for admin
                    })
                    ->orderBy('created_at', 'DESC')
                    ->get(),
                'series_season' => SeriesSeason::query()
                    ->when(!$isAdminProducer, function($q) use ($cpp_user_id){
                        // original code filtered by series_id = user_id which seems off, keeping behavior for non-admin to avoid breaking deps
                        return $q->where('series_id', $cpp_user_id)
                                 ->where('uploaded_by', 'CPP');
                    })
                    ->when($isAdminProducer, function($q){
                        return $q; // no restriction for admin
                    })
                    ->orderBy('created_at', 'DESC')
                    ->get(),
                'audios' => Audio::query()
                    ->when(!$isAdminProducer, function($q) use ($cpp_user_id){
                        return $q->where('user_id', $cpp_user_id)
                                 ->where('uploaded_by', 'CPP');
                    })
                    ->when($isAdminProducer, function($q){
                        return $q; // no restriction for admin
                    })
                    ->orderBy('created_at', 'DESC')
                    ->get(),
            ];

            // Improved Line Chart Data - Single optimized query
            $chart_data = PpvPurchase::query()
                ->when(!$isAdminProducer, function($q) use ($cpp_user_id){
                    return $q->where('moderator_id', $cpp_user_id);
                })
                ->whereNull('live_id')
                ->where('created_at', '>=', $filter_date)
                ->where('created_at', '>=', Carbon::now()->subDays(14)->startOfDay())
                ->where(function ($query) {
                    $query->where('status', 'captured')->orWhere('status', '1');
                })
                ->selectRaw('DATE(created_at) as purchase_date, COUNT(*) as daily_count, SUM(total_amount) as daily_amount')
                ->groupBy('purchase_date')
                ->orderBy('purchase_date', 'asc')
                ->get()
                ->keyBy('purchase_date');

            $chart_data_live = LivePurchase::query()
                ->join('live_streams', 'live_streams.id', '=', 'live_purchases.video_id')
                ->when(!$isAdminProducer, function($q) use ($cpp_user_id){
                    return $q->where('live_streams.user_id', $cpp_user_id);
                })
                ->where('live_purchases.created_at', '>=', $filter_date)
                ->where('live_purchases.created_at', '>=', Carbon::now()->subDays(14)->startOfDay())
                ->whereIn('live_purchases.payment_status', ['captured', 'completed'])
                ->selectRaw('DATE(live_purchases.created_at) as purchase_date, COUNT(*) as daily_count, SUM(live_purchases.amount) as daily_amount')
                ->groupBy('purchase_date')
                ->orderBy('purchase_date', 'asc')
                ->get()
                ->keyBy('purchase_date');

            // Generate consistent 15-day labels and data
            $ppv_purchases_count_labels = [];
            $ppv_purchases_count_data = [];
            $ppv_purchases_amount_data = [];

            for ($i = 14; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i)->toDateString();
                $ppv_purchases_count_labels[] = $date;

                // Use data from optimized queries or default to 0
                $daily_data_ppv = $chart_data->get($date);
                $daily_data_live = $chart_data_live->get($date);

                $count_ppv = $daily_data_ppv->daily_count ?? 0;
                $count_live = $daily_data_live->daily_count ?? 0;
                $amount_ppv = $daily_data_ppv->daily_amount ?? 0;
                $amount_live = $daily_data_live->daily_amount ?? 0;

                $ppv_purchases_count_data[] = $count_ppv + $count_live;
                $ppv_purchases_amount_data[] = $amount_ppv + $amount_live;
            }

            $data = array(
                'ppv_purchases_count' => $ppv_purchases_count,
                'ppv_purchases_amount' => $ppv_purchases_amount,
                'sources_data' => $sources_data,
                'currency_symbol' => currency_symbol(),
                'cpp_user_id' => $cpp_user_id,
                'Sales_Summary' => $Sales_Summary,
                'monthly_Summary' => $monthly_Summary,
                // Add chart data to pass to view
                'chart_labels' => json_encode($ppv_purchases_count_labels),
                'chart_count_data' => json_encode($ppv_purchases_count_data),
                'chart_amount_data' => json_encode($ppv_purchases_amount_data)

            );

            return view('producer.home', $data);

        } catch (\Throwable $th) {
            Log::error('ProducerController.home exception', [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                'cpp_user_id' => session()->get('cpp_user_id'),
                'route' => 'producer.home',
            ]);
            return abort(404);
        }
    }

    public function stats(Request $request, $source, $source_id)
    {
        try {

            $current_time = $this->current_time;
            $cpp_user_id = session()->get('cpp_user_id');
            $CppUser_details = ModeratorsUser::where('id', $cpp_user_id)->first();
            $role_name = $CppUser_details ? ModeratorsRole::where('id', $CppUser_details->user_role)->pluck('role_name')->first() : null;
            $normalizedRole = $role_name !== null ? strtolower(trim($role_name)) : null;
            $isAdminProducer = $normalizedRole !== null && (in_array($normalizedRole, ['admin','administrator','super admin','superadmin']) || stripos($role_name, 'admin') !== false);

            // filter date
            $filter_date = '2024-12-15';

            // Current Time
            $today = $current_time->toDateString();
            $current_month = $current_time->month;
            $current_year = $current_time->year;

            // Previous Time
            $last_year = $current_time->copy()->subYear()->year;

            $last_month = $current_time->copy()->subMonths(1);
            $last2ndmonth = $current_time->copy()->subMonths(2);
            $last3ndmonth = $current_time->copy()->subMonths(3);

            // If source is livestream, use live_purchases directly and return early
            if ($source === 'livestream') {
                $live_base = LivePurchase::query()
                    ->join('live_streams', 'live_streams.id', '=', 'live_purchases.video_id')
                    ->when(!$isAdminProducer, function($q) use ($cpp_user_id){
                        return $q->where('live_streams.user_id', $cpp_user_id);
                    })
                    ->where('live_purchases.video_id', $source_id)
                    ->where('live_purchases.created_at', '>=', $filter_date)
                    ->whereIn('live_purchases.payment_status', ['captured', 'completed'])
                    ->where(function ($q) {
                        $q->where('live_purchases.total_amount', '>', 0)
                            ->orWhere('live_purchases.amount', '>', 0);
                    })
                    ->select('live_purchases.*');

                $lp_today = (clone $live_base)->whereDate('live_purchases.created_at', $today)->get();
                $lp_current_month = (clone $live_base)->whereYear('live_purchases.created_at', $current_year)
                    ->whereMonth('live_purchases.created_at', $current_month)->get();
                $lp_last_month = (clone $live_base)->whereYear('live_purchases.created_at', $current_year)
                    ->whereMonth('live_purchases.created_at', $last_month->month)->get();
                $lp_last2ndmonth = (clone $live_base)->whereYear('live_purchases.created_at', $current_year)
                    ->whereMonth('live_purchases.created_at', $last2ndmonth->month)->get();
                $lp_last3rdmonth = (clone $live_base)->whereYear('live_purchases.created_at', $current_year)
                    ->whereMonth('live_purchases.created_at', $last3ndmonth->month)->get();
                $lp_current_year = (clone $live_base)->whereYear('live_purchases.created_at', $current_year)->get();
                $lp_last_year = (clone $live_base)->whereYear('live_purchases.created_at', $last_year)->get();
                $lp_total = (clone $live_base)->get();

                $sumLive = function ($c) {
                    return $c->sum(function ($x) {
                        $val = $x->total_amount ?? $x->amount ?? 0;
                        if (is_string($val)) {
                            $val = preg_replace('/[^\d.\-]/', '', $val);
                        }
                        return (float) $val;
                    });
                };

                $ppv_purchases_count = [
                    'ppv_purchases_today_count' => $lp_today->count(),
                    'ppv_purchases_current_month_count' => $lp_current_month->count(),
                    'ppv_purchases_current_year_count' => $lp_current_year->count(),
                    'ppv_purchases_last_month_count' => $lp_last_month->count(),
                    'ppv_purchases_last2ndmonth_count' => $lp_last2ndmonth->count(),
                    'ppv_purchases_last3rdmonth_count' => $lp_last3rdmonth->count(),
                    'ppv_purchases_last_year_count' => $lp_last_year->count(),
                    'ppv_purchases_total_count' => $lp_total->count(),
                    'Free_access_with_promotions' => 0,
                ];

                // Compute producer share for LIVE using CPP_commission_percentage from the stream
                $stream_for_pct = LiveStream::query()
                    ->when(!$isAdminProducer, function($q) use ($cpp_user_id){
                        return $q->where('user_id', $cpp_user_id);
                    })
                    ->where('id', $source_id)
                    ->first();
                $producer_pct = $stream_for_pct && isset($stream_for_pct->CPP_commission_percentage)
                    ? ((float) $stream_for_pct->CPP_commission_percentage) / 100
                    : 0.0;

                $ppv_purchases_cpp_commission_sum = $sumLive($lp_total) * $producer_pct;

                $ppv_purchases_amount = [
                    'ppv_purchases_today_total_amount' => $sumLive($lp_today),
                    'ppv_purchases_current_month_total_amount' => $sumLive($lp_current_month),
                    'ppv_purchases_current_year_total_amount' => $sumLive($lp_current_year),
                    'ppv_purchases_last_month_total_amount' => $sumLive($lp_last_month),
                    'ppv_purchases_last2ndmonth_total_amount' => $sumLive($lp_last2ndmonth),
                    'ppv_purchases_last3rdmonth_total_amount' => $sumLive($lp_last3rdmonth),
                    'ppv_purchases_last_year_total_amount' => $sumLive($lp_last_year),
                    'ppv_purchases_total_amount' => $sumLive($lp_total),
                    'ppv_purchases_admin_commission_sum' => max($sumLive($lp_total) - $ppv_purchases_cpp_commission_sum, 0),
                    'ppv_purchases_cpp_commission_sum' => $ppv_purchases_cpp_commission_sum,
                    'Free_access_with_promotions' => 0,
                ];

                // Unified totals for livestream: compute Gross, GST, Net and split shares (excluding GST)
                $gross_total = (float) $sumLive($lp_total);
                $gst_total = round($gross_total * 0.18, 2);
                $net_total = max($gross_total - $gst_total, 0);

                $producer_share_net_total = round($net_total * $producer_pct, 2);
                $runmawi_share_net_total = max($net_total - $producer_share_net_total, 0);
                $transaction_fees_total = 0.0;

                // Show the exact configured percentage for livestreams
                $effective_producer_pct = round($producer_pct * 100.0, 2);
                $effective_admin_pct = round(100.0 - $effective_producer_pct, 2);

                $ppv_purchases_amount['gross_total'] = $gross_total;
                $ppv_purchases_amount['gst_total'] = $gst_total;
                $ppv_purchases_amount['net_total'] = $net_total;
                $ppv_purchases_amount['producer_share_net_total'] = $producer_share_net_total;
                $ppv_purchases_amount['runmawi_share_net_total'] = $runmawi_share_net_total;
                $ppv_purchases_amount['transaction_fees_total'] = $transaction_fees_total;
                $ppv_purchases_amount['effective_producer_pct'] = $effective_producer_pct;
                $ppv_purchases_amount['effective_admin_pct'] = $effective_admin_pct;

                $stats_sources = LiveStream::query()
                    ->when(!$isAdminProducer, function($q) use ($cpp_user_id){
                        return $q->where('user_id', $cpp_user_id);
                    })
                    ->where('id', $source_id)
                    ->orderBy('created_at', 'DESC')->first();

                $sources_data = [
                    'livestream' => LiveStream::query()
                        ->when(!$isAdminProducer, function($q) use ($cpp_user_id){
                            return $q->where('user_id', $cpp_user_id);
                        })
                        ->orderBy('created_at', 'DESC')
                        ->get(),
                    'video' => Video::query()
                        ->when(!$isAdminProducer, function($q) use ($cpp_user_id){
                            return $q->where('user_id', $cpp_user_id)->where('uploaded_by', 'CPP');
                        })
                        ->orderBy('created_at', 'DESC')
                        ->get(),
                    'series' => Series::query()
                        ->when(!$isAdminProducer, function($q) use ($cpp_user_id){
                            return $q->where('user_id', $cpp_user_id)->where('uploaded_by', 'CPP');
                        })
                        ->orderBy('created_at', 'DESC')
                        ->get(),
                    'series_season' => SeriesSeason::query()
                        ->when(!$isAdminProducer, function($q) use ($cpp_user_id){
                            return $q->where('series_id', $cpp_user_id)->where('uploaded_by', 'CPP');
                        })
                        ->orderBy('created_at', 'DESC')
                        ->get(),
                    'audios' => Audio::query()
                        ->when(!$isAdminProducer, function($q) use ($cpp_user_id){
                            return $q->where('user_id', $cpp_user_id)->where('uploaded_by', 'CPP');
                        })
                        ->orderBy('created_at', 'DESC')
                        ->get(),
                ];

                $data = array(
                    'ppv_purchases_count' => $ppv_purchases_count,
                    'ppv_purchases_amount' => $ppv_purchases_amount,
                    'sources_data' => $sources_data,
                    'stats_sources' => $stats_sources,
                    'currency_symbol' => currency_symbol(),
                    'cpp_user_id' => $cpp_user_id,
                    'source' => $source,
                    'producer_share_percentage' => $stream_for_pct ? (float) $stream_for_pct->CPP_commission_percentage : 0.0,
                    // 15-day chart data for this livestream only
                    'chart_labels' => json_encode(
                        (function () {
                            $labels = [];
                            for ($i = 14; $i >= 0; $i--) {
                                $labels[] = Carbon::now()->subDays($i)->toDateString();
                            }
                            return $labels;
                        })()
                    ),
                    'chart_count_data' => json_encode(
                        (function () use ($source_id, $cpp_user_id, $isAdminProducer) {
                            $map = LivePurchase::query()
                                ->join('live_streams', 'live_streams.id', '=', 'live_purchases.video_id')
                                ->when(!$isAdminProducer, function($q) use ($cpp_user_id){
                                    return $q->where('live_streams.user_id', $cpp_user_id);
                                })
                                ->where('live_purchases.video_id', $source_id)
                                ->where('live_purchases.created_at', '>=', Carbon::now()->subDays(14)->startOfDay())
                                ->whereIn('live_purchases.payment_status', ['captured', 'completed'])
                                ->selectRaw('DATE(live_purchases.created_at) as d, COUNT(*) as c')
                                ->groupBy('d')->pluck('c', 'd');
                            $series = [];
                            for ($i = 14; $i >= 0; $i--) {
                                $date = Carbon::now()->subDays($i)->toDateString();
                                $series[] = (int) ($map[$date] ?? 0);
                            }
                            return $series;
                        })()
                    ),
                    'chart_amount_data' => json_encode(
                        (function () use ($source_id, $cpp_user_id, $isAdminProducer) {
                            $map = LivePurchase::query()
                                ->join('live_streams', 'live_streams.id', '=', 'live_purchases.video_id')
                                ->when(!$isAdminProducer, function($q) use ($cpp_user_id){
                                    return $q->where('live_streams.user_id', $cpp_user_id);
                                })
                                ->where('live_purchases.video_id', $source_id)
                                ->where('live_purchases.created_at', '>=', Carbon::now()->subDays(14)->startOfDay())
                                ->whereIn('live_purchases.payment_status', ['captured', 'completed'])
                                ->selectRaw('DATE(live_purchases.created_at) as d, SUM(live_purchases.amount) as s')
                                ->groupBy('d')->pluck('s', 'd');
                            $series = [];
                            for ($i = 14; $i >= 0; $i--) {
                                $date = Carbon::now()->subDays($i)->toDateString();
                                $val = $map[$date] ?? 0;
                                $series[] = (float) $val;
                            }
                            return $series;
                        })()
                    ),
                );

                return view('producer.stats', $data);
            }

            // Build a common PPV base that is admin-aware
            $ppv_base = PpvPurchase::query()
                ->when(!$isAdminProducer, function($q) use ($cpp_user_id){
                    return $q->where('moderator_id', $cpp_user_id);
                })
                ->whereNull('live_id')
                ->where('created_at', '>=', $filter_date)
                ->where(function ($query) {
                    $query->where('status', 'captured')->orWhere('status', '1');
                })
                ->when($source === 'video', function ($query) use ($source_id) {
                    return $query->where('video_id', $source_id);
                })
                ->when($source === 'livestream', function ($query) use ($source_id) {
                    return $query->where('live_id', $source_id);
                })
                ->when($source === 'audio', function ($query) use ($source_id) {
                    return $query->where('audio_id', $source_id);
                })
                ->when($source === 'series', function ($query) use ($source_id) {
                    return $query->where('series_id', $source_id);
                })
                ->when($source === 'series_season', function ($query) use ($source_id) {
                    return $query->where('season_id', $source_id);
                });

            $ppv_purchases_today = (clone $ppv_base)
                ->whereDate('created_at', $today)
                ->get();

            $ppv_purchases_current_month = (clone $ppv_base)
                ->whereYear('created_at', $current_year)
                ->whereMonth('created_at', $current_month)
                ->get();

            // Use explicit month ranges for reliability
            $ppv_purchases_last_month = (clone $ppv_base)
                ->whereBetween('created_at', [$last_month->copy()->startOfMonth(), $last_month->copy()->endOfMonth()])
                ->get();

            $ppv_purchases_last2ndmonth = (clone $ppv_base)
                ->whereBetween('created_at', [$last2ndmonth->copy()->startOfMonth(), $last2ndmonth->copy()->endOfMonth()])
                ->get();

            $ppv_purchases_last3rdmonth = (clone $ppv_base)
                ->whereBetween('created_at', [$last3ndmonth->copy()->startOfMonth(), $last3ndmonth->copy()->endOfMonth()])
                ->get();

            $ppv_purchases_current_year = (clone $ppv_base)
                ->whereYear('created_at', $current_year)
                ->get();

            $ppv_purchases_last_year = (clone $ppv_base)
                ->whereYear('created_at', $last_year)
                ->get();

            $ppv_purchases_total = (clone $ppv_base)->get();

            $ppv_purchases_count = [
                'ppv_purchases_today_count' => $ppv_purchases_today->count(),
                'ppv_purchases_current_month_count' => $ppv_purchases_current_month->count(),
                'ppv_purchases_current_year_count' => $ppv_purchases_current_year->count(),
                'ppv_purchases_last_month_count' => $ppv_purchases_last_month->count(),
                'ppv_purchases_last2ndmonth_count' => $ppv_purchases_last2ndmonth->count(),
                'ppv_purchases_last3rdmonth_count' => $ppv_purchases_last3rdmonth->count(),
                'ppv_purchases_last_year_count' => $ppv_purchases_last_year->count(),
                'ppv_purchases_total_count' => $ppv_purchases_total->count(),
                'Free_access_with_promotions' => 0,
            ];

            $ppv_purchases_cpp_commission_sum = $ppv_purchases_total->sum('moderator_commssion') - ($ppv_purchases_total->sum('moderator_commssion') * 0.18);
            $producer_share_percentage_gross = null;
            $total_amount_sum = (float) $ppv_purchases_total->sum('total_amount');
            $moderator_comm_sum = (float) $ppv_purchases_total->sum('moderator_commssion');
            if ($total_amount_sum > 0) {
                $producer_share_percentage_gross = ($moderator_comm_sum / $total_amount_sum) * 100.0;
            }
            $ppv_purchases_amount = [
                'ppv_purchases_today_total_amount' => $ppv_purchases_today->sum('total_amount'),
                'ppv_purchases_current_month_total_amount' => $ppv_purchases_current_month->sum('total_amount'),
                'ppv_purchases_current_year_total_amount' => $ppv_purchases_current_year->sum('total_amount'),
                'ppv_purchases_last_month_total_amount' => $ppv_purchases_last_month->sum('total_amount'),
                'ppv_purchases_last2ndmonth_total_amount' => $ppv_purchases_last2ndmonth->sum('total_amount'),
                'ppv_purchases_last3rdmonth_total_amount' => $ppv_purchases_last3rdmonth->sum('total_amount'),
                'ppv_purchases_last_year_total_amount' => $ppv_purchases_last_year->sum('total_amount'),
                'ppv_purchases_total_amount' => $ppv_purchases_total->sum('total_amount'),
                'ppv_purchases_cpp_commission_sum' => $ppv_purchases_cpp_commission_sum,
                'ppv_purchases_admin_commission_sum' => $ppv_purchases_total->sum('total_amount') - $ppv_purchases_cpp_commission_sum,
                'Free_access_with_promotions' => 0,
            ];

            // Unified totals for non-livestream: compute Gross, GST, Net and split shares (excluding GST)
            $gross_total = (float) $ppv_purchases_total->sum('total_amount');
            $gst_total = round($gross_total * 0.18, 2);
            $net_total = max($gross_total - $gst_total, 0);

            switch ($source) {
                case 'video':
                    $stats_sources = Video::query()
                        ->when(!$isAdminProducer, function($q) use ($cpp_user_id){
                            return $q->where('user_id', $cpp_user_id)->where('uploaded_by', 'CPP');
                        })
                        ->where('id', $source_id)
                        ->orderBy('created_at', 'DESC')->first();
                    $producer_share_percentage_gross = $stats_sources && isset($stats_sources->CPP_commission_percentage)
                        ? (float) $stats_sources->CPP_commission_percentage
                        : $producer_share_percentage_gross;
                    break;

                case 'livestream':
                    $stats_sources = LiveStream::query()
                        ->when(!$isAdminProducer, function($q) use ($cpp_user_id){
                            return $q->where('user_id', $cpp_user_id);
                        })
                        ->where('id', $source_id)
                        ->orderBy('created_at', 'DESC')->first();
                    $producer_share_percentage_gross = $stats_sources && isset($stats_sources->CPP_commission_percentage)
                        ? (float) $stats_sources->CPP_commission_percentage
                        : $producer_share_percentage_gross;
                    break;

                case 'series':
                    $stats_sources = Series::query()
                        ->when(!$isAdminProducer, function($q) use ($cpp_user_id){
                            return $q->where('user_id', $cpp_user_id)->where('uploaded_by', 'CPP');
                        })
                        ->where('id', $source_id)
                        ->orderBy('created_at', 'DESC')->get()
                        ->map(function ($item) use ($isAdminProducer) {
                            $seasonQuery = SeriesSeason::query()->where('series_id', $item->id);
                            if (!$isAdminProducer) {
                                $seasonQuery->where('uploaded_by', 'CPP');
                            }
                            $item['access'] = $seasonQuery->where('access', 'ppv')->pluck('access')->first();
                            return $item;
                        })
                        ->first();
                    if ($stats_sources && isset($stats_sources->CPP_commission_percentage)) {
                        $producer_share_percentage_gross = (float) $stats_sources->CPP_commission_percentage;
                    } else {
                        $season_pct = SeriesSeason::where('series_id', $source_id)->pluck('CPP_commission_percentage')->first();
                        if (!empty($season_pct)) {
                            $producer_share_percentage_gross = (float) $season_pct;
                        }
                    }
                    break;

                case 'series_season':
                    $stats_sources = SeriesSeason::query()
                        ->when(!$isAdminProducer, function($q) use ($cpp_user_id){
                            return $q->where('series_id', $cpp_user_id)->where('uploaded_by', 'CPP');
                        })
                        ->where('id', $source_id)
                        ->orderBy('created_at', 'DESC')->first();
                    if ($stats_sources && isset($stats_sources->CPP_commission_percentage)) {
                        $producer_share_percentage_gross = (float) $stats_sources->CPP_commission_percentage;
                    }
                    break;

                case 'audio':
                    $stats_sources = Audio::query()
                        ->when(!$isAdminProducer, function($q) use ($cpp_user_id){
                            return $q->where('user_id', $cpp_user_id)->where('uploaded_by', 'CPP');
                        })
                        ->where('id', $source_id)
                        ->orderBy('created_at', 'DESC')->first();
                    break;

                default:
                    $stats_sources = null;
                    break;
            }

            // Compute shares DIRECTLY from content percentage for accuracy
            $pct = (float) ($producer_share_percentage_gross ?? 0);
            $producer_share_net_total = round($net_total * ($pct / 100.0), 2);
            $runmawi_share_net_total = max($net_total - $producer_share_net_total, 0);
            $transaction_fees_total = 0.0;

            // Effective pcts shown in the UI should equal the configured percentages
            $effective_producer_pct = round($pct, 2);
            $effective_admin_pct = round(100 - $pct, 2);

            $ppv_purchases_amount['gross_total'] = $gross_total;
            $ppv_purchases_amount['gst_total'] = $gst_total;
            $ppv_purchases_amount['net_total'] = $net_total;
            $ppv_purchases_amount['producer_share_net_total'] = $producer_share_net_total;
            $ppv_purchases_amount['runmawi_share_net_total'] = $runmawi_share_net_total;
            $ppv_purchases_amount['transaction_fees_total'] = $transaction_fees_total;
            $ppv_purchases_amount['effective_producer_pct'] = $effective_producer_pct;
            $ppv_purchases_amount['effective_admin_pct'] = $effective_admin_pct;

            $sources_data = [
                'livestream' => LiveStream::query()
                    ->when(!$isAdminProducer, function($q) use ($cpp_user_id){
                        return $q->where('user_id', $cpp_user_id);
                    })
                    ->where('access', 'ppv')
                    ->orderBy('created_at', 'DESC')->get(),
                'video' => Video::query()
                    ->when(!$isAdminProducer, function($q) use ($cpp_user_id){
                        return $q->where('user_id', $cpp_user_id)->where('uploaded_by', 'CPP');
                    })
                    ->orderBy('created_at', 'DESC')->get(),
                'series' => Series::query()
                    ->when(!$isAdminProducer, function($q) use ($cpp_user_id){
                        return $q->where('user_id', $cpp_user_id)->where('uploaded_by', 'CPP');
                    })
                    ->orderBy('created_at', 'DESC')->get(),
                'series_season' => SeriesSeason::query()
                    ->when(!$isAdminProducer, function($q) use ($cpp_user_id){
                        return $q->where('series_id', $cpp_user_id)->where('uploaded_by', 'CPP');
                    })
                    ->orderBy('created_at', 'DESC')->get(),
                'audios' => Audio::query()
                    ->when(!$isAdminProducer, function($q) use ($cpp_user_id){
                        return $q->where('user_id', $cpp_user_id)->where('uploaded_by', 'CPP');
                    })
                    ->orderBy('created_at', 'DESC')->get(),
            ];

            // Build 15-day chart data for PPV purchases limited to the selected source
            $ppvChartBase = PpvPurchase::query()
                ->when(!$isAdminProducer, function($q) use ($cpp_user_id){
                    return $q->where('moderator_id', $cpp_user_id);
                })
                ->whereNull('live_id')
                ->where('created_at', '>=', Carbon::now()->subDays(14)->startOfDay())
                ->where(function ($query) {
                    $query->where('status', 'captured')->orWhere('status', '1');
                })
                ->when($source === 'video', function ($query) use ($source_id) {
                    return $query->where('video_id', $source_id);
                })
                ->when($source === 'livestream', function ($query) use ($source_id) {
                    return $query->where('live_id', $source_id);
                })
                ->when($source === 'audio', function ($query) use ($source_id) {
                    return $query->where('audio_id', $source_id);
                })
                ->when($source === 'series', function ($query) use ($source_id) {
                    return $query->where('series_id', $source_id);
                })
                ->when($source === 'series_season', function ($query) use ($source_id) {
                    return $query->where('season_id', $source_id);
                });

            $ppvCountMap = (clone $ppvChartBase)
                ->selectRaw('DATE(created_at) as d, COUNT(*) as c')
                ->groupBy('d')->pluck('c', 'd');

            $ppvAmountMap = (clone $ppvChartBase)
                ->selectRaw('DATE(created_at) as d, SUM(total_amount) as s')
                ->groupBy('d')->pluck('s', 'd');

            $chart_labels = [];
            $chart_count_data = [];
            $chart_amount_data = [];
            for ($i = 14; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i)->toDateString();
                $chart_labels[] = $date;
                $chart_count_data[] = (int) ($ppvCountMap[$date] ?? 0);
                $chart_amount_data[] = (float) ($ppvAmountMap[$date] ?? 0);
            }

            $data = array(
                'ppv_purchases_count' => $ppv_purchases_count,
                'ppv_purchases_amount' => $ppv_purchases_amount,
                'sources_data' => $sources_data,
                'stats_sources' => $stats_sources,
                'currency_symbol' => currency_symbol(),
                'cpp_user_id' => $cpp_user_id,
                'source' => $source,
                'chart_labels' => json_encode($chart_labels),
                'chart_count_data' => json_encode($chart_count_data),
                'chart_amount_data' => json_encode($chart_amount_data),
                'producer_share_percentage' => $producer_share_percentage_gross,
            );

            return view('producer.stats', $data);

        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    // Logout Module

    public function logout(Request $request)
    {
        try {

            $request->session()->flush();

            $request->session()->regenerate();

            return redirect()->route('producer.login');

        } catch (\Throwable $th) {

            return abort(404);
        }
    }
}
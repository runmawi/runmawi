<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\AdminOTPCredentials;
use App\VideoCommission;
use App\ModeratorsUser;
use App\SeriesSeason;
use App\PpvPurchase;
use App\LiveStream;
use App\UserAccess;
use App\Video;
use App\Series;
use App\Audio;
use Theme;
use App\Setting;

class ProducerController extends Controller
{
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
                'jsonString'   => $jsonString,
                'jsondata'     => $jsondata,
            );

            return view('producer.login',$data);

        } catch (\Throwable $th) {
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

            $ModeratorsUser = ModeratorsUser::where([['mobile_number', $request->mobile_number],['status', 1]])->first();
        
            if (!$ModeratorsUser) {
                return back()->withErrors(['mobile_number' => 'Invalid Mobile Number.']);
            }
        
            if ($ModeratorsUser->otp != $request->otp) {
                return back()->withErrors(['Password' => 'Invalid Password.']);
            }

            if(!empty($ModeratorsUser->parent_moderator_id) || $ModeratorsUser->parent_moderator_id != null){
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
                'jsonString'   => $jsonString,
                'jsondata'     => $jsondata,
            );

            return view('producer.signup',$data);

        } catch (\Throwable $th) {

            return abort(404);
        }
    }

    public function Signup_check_mobile_exist(Request $request)
    {
        $mobile_number = $request->input('mobile_number');

        if( is_null($mobile_number)){
            return response()->json(['exists' => false]);
        }

        $user = ModeratorsUser::where('mobile_number', $mobile_number)->where('ccode',$request->ccode)->first();

        if ( is_null($user)) {

            ModeratorsUser::updateOrCreate([
                'ccode'    => $request->ccode,
                'mobile_number' => $request->mobile_number ,
            ]);

            return response()->json(['exists' => true]);
        } else {

            if( $user->signup_exits_status == 1 ){
                return response()->json(['exists' => false]);
            }else{

                return response()->json(['exists' => true]);
            }
        }
    }

    public function Signup_Sending_OTP(Request $request)
    {
        $AdminOTPCredentials =  AdminOTPCredentials::where('status',1)->first();

        if(is_null($AdminOTPCredentials)){
            return response()->json(['exists' => false, 'message_note' => 'Some Error in OTP Config, Please connect admin']);
        }

        try {
            
            $random_otp_number = random_int(1000, 9999);
            $ccode = str_replace('+','',$request->ccode );
            $mobile             = $request->mobile_number;
            $Mobile_number      = $ccode.$request->mobile ;

            $user = ModeratorsUser::where('mobile_number',$mobile)->where('ccode',$ccode)->where('signup_exits_status',0)->first();

            if( $AdminOTPCredentials->otp_vai == "24x7sms" ){

                $API_key_24x7sms  = $AdminOTPCredentials->otp_24x7sms_api_key ;
                $SenderID = $AdminOTPCredentials->otp_24x7sms_sender_id ;
                $ServiceName = $AdminOTPCredentials->otp_24x7sms_sevicename ;

                $DLTTemplateID = $AdminOTPCredentials->DLTTemplateID ;
                $message = Str_replace('{#var#}', $random_otp_number , $AdminOTPCredentials->template_message) ;

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
                        ['otp' => $random_otp_number ,
                        'otp_request_id' => $msgId ,
                        'otp_through' =>  $AdminOTPCredentials->otp_vai ,
                    ]);

                    return response()->json(['exists' => true, 'message_note' => 'OTP Sent Successfully!']);

                }else {

                    $errorMessage = $response->body() ?? 'An unknown error occurred'; 
                    
                    return response()->json(['exists' => false,'message_note' => 'OTP Not Sent!','error_details' => $errorMessage ]);
                    
                }         
            }
           
        } catch (\Throwable $th) {
            
            return response()->json(['exists' => false, 'message_note' => 'OTP Not Sent!','error_note' => $th->getMessage()]);
        }
    }

    public function signup_otp_verification(Request $request)
    {
        try {

            $ccode = str_replace('+','',$request->ccode );
            $mobileNumber             = $request->mobileNumber;

            $user_verify = ModeratorsUser::where('mobile_number',$mobileNumber)->where('ccode',$ccode)->where('otp', $request->otp)
                                            ->where('signup_exits_status',0)->first();

            if( !is_null($user_verify) ){

                $commission_percentage = VideoCommission::where('type','CPP')->pluck('percentage')->first();
                $CPP_commission_percentage = $commission_percentage ? 100 - $commission_percentage  : null;

                ModeratorsUser::find($user_verify->id)->update([
                    'username'=> $request->username,
                    'signup_exits_status' => 1 ,
                    'password' =>  Hash::make($request->otp),
                    'commission_percentage'  => $CPP_commission_percentage,
                    'user_permission' => '1,2',
                    'status'   => 0,
                    'user_role'=> 3,
                ]);

                UserAccess::updateOrCreate([
                    'user_id' => $user_verify->id ,
                    'role_id' => 3 ,
                    'permissions_id' => 2,
                ]);

                session()->flash('Regiter_successfully', 'Producer Registered Successfully, Waiting for Admin Approval.');

                return response()->json([
                    'status' => true,
                    'message_note' => 'OTP verify successfully &  wait a few seconds to register !',
                ]);
            }

            return response()->json( [ 'status' => false , 'message_note' => 'Please, Enter the Valid OTP !' ] );
            
        } catch (\Throwable $th) {

            return response()->json( [ 'status' => false , 'fails' => $th->getMessage() ] );
        }
    }
   
    // Dashboard Module

    public function home(Request $request)
    {
        try {
         
            $current_time = $this->current_time;
            $cpp_user_id  = session()->get('cpp_user_id');

            $commission_btn = Setting::pluck('CPP_Commission_Status')->first();
            $CppUser_details = ModeratorsUser::where('id',$cpp_user_id)->first();
            $video_commission_percentage = VideoCommission::where('type','Cpp')->pluck('percentage')->first();
            $commission_percentage_value = null;
            
            if($commission_btn == 0){
                $commission_percentage_value = !empty($CppUser_details->commission_percentage) ? $CppUser_details->commission_percentage : $video_commission_percentage;
            }

            // filter date
            $filter_date = '2024-12-15';

            // Current Time
            $today         = $current_time->toDateString();
            $current_month = $current_time->month;
            $current_year  = $current_time->year;

            // Previous Time
            $last_year = $current_time->copy()->subYear()->year;

            $last_month_year    = $current_time->copy()->subMonth(1);
            $last2nd_month_year =  $current_time->copy()->subMonth(2);
            $last3nd_month_year =  $current_time->copy()->subMonth(3);

            $ppv_purchases_today = PpvPurchase::query()
                                                    ->where('moderator_id', $cpp_user_id)
                                                    ->where('created_at', '>=', $filter_date) 
                                                    ->whereDate('created_at', $today)
                                                    ->where(function ($query) {
                                                        $query->where('status', 'captured')->orWhere('status', 1);
                                                    })    
                                                    ->get();

            $ppv_purchases_current_month = PpvPurchase::where('moderator_id', $cpp_user_id)
                                                     ->where('created_at', '>=', $filter_date) 
                                                    ->whereYear('created_at', $current_year)
                                                    ->whereMonth('created_at', $current_month)
                                                    ->where(function ($query) {
                                                        $query->where('status', 'captured')->orWhere('status', 1);
                                                    })    
                                                    ->get();

            $ppv_purchases_last_month = PpvPurchase::where('moderator_id', $cpp_user_id)
                                                ->where('created_at', '>=', $filter_date) 
                                                ->whereYear('created_at', $last_month_year->year)
                                                ->whereMonth('created_at', $last_month_year->month)
                                                ->where(function ($query) {
                                                    $query->where('status', 'captured')->orWhere('status', 1);
                                                })    
                                                ->get();

                                                
            $ppv_purchases_last2ndmonth = PpvPurchase::where('moderator_id', $cpp_user_id)
                                                ->where('created_at', '>=', $filter_date) 
                                                ->whereYear('created_at', $last2nd_month_year->year)
                                                ->whereMonth('created_at', $last2nd_month_year->month)
                                                ->where(function ($query) {
                                                    $query->where('status', 'captured')->orWhere('status', 1);
                                                })    
                                                ->get();

                                                
            $ppv_purchases_last3rdmonth = PpvPurchase::where('moderator_id', $cpp_user_id)
                                                ->where('created_at', '>=', $filter_date) 
                                                ->whereYear('created_at', $last3nd_month_year->year)
                                                ->whereMonth('created_at', $last3nd_month_year->month)
                                                ->where(function ($query) {
                                                    $query->where('status', 'captured')->orWhere('status', '1');
                                                })                                                   
                                                ->get();

            $ppv_purchases_current_year = PpvPurchase::where('moderator_id', $cpp_user_id)
                                                    ->where('created_at', '>=', $filter_date) 
                                                    ->whereYear('created_at', $current_year)
                                                    ->where(function ($query) {
                                                        $query->where('status', 'captured')->orWhere('status',1);
                                                    })                                                   
                                                    ->get();

            $ppv_purchases_last_year = PpvPurchase::where('moderator_id', $cpp_user_id)
                                                ->where('created_at', '>=', $filter_date) 
                                                ->whereYear('created_at', $last_year)
                                                ->where(function ($query) {
                                                    $query->where('status', 'captured')->orWhere('status',1);
                                                })
                                                ->get();

            $ppv_purchases_total = PpvPurchase::where('moderator_id', $cpp_user_id)
                                                ->where('created_at', '>=', $filter_date) 
                                                ->where(function ($query) {
                                                    $query->where('status', 'captured')->orWhere('status', '1');
                                                })
                                                ->get();

            $Sales_Summary = PpvPurchase::where('moderator_id', $cpp_user_id)
                                            ->where('created_at', '>=', $filter_date) 
                                            ->where(function ($query) {
                                                $query->where('status', 'captured')->orWhere('status', '1');
                                            })
                                            ->select([
                                                'video_id', 
                                                'live_id', 
                                                'audio_id', 
                                                'series_id', 
                                                'season_id',
                                                DB::raw('SUM(total_amount) as total_amount_without_gst'),  // Original total amount with GST
                                                DB::raw('SUM(total_amount * 0.18) as total_amount_with_gst'),  // Amount without GST
                                                DB::raw('SUM(total_amount) - SUM(total_amount * 0.18) as gst_value'),  // Exact GST value (18%)
                                                DB::raw('SUM(admin_commssion) - (SUM(admin_commssion * 0.18)) as admin_commission_sum'),
                                                DB::raw('SUM(moderator_commssion) - (SUM(moderator_commssion * 0.18)) as moderator_commission_sum'),
                                                DB::raw('((SUM(admin_commssion) - (SUM(admin_commssion * 0.18))) / ( SUM(total_amount) - SUM(total_amount * 0.18))) * 100 as admin_commission_percentage'),  // Admin commission percentage
                                                DB::raw('((SUM(moderator_commssion) - (SUM(moderator_commssion * 0.18))) / ( SUM(total_amount) - SUM(total_amount * 0.18))) * 100 as moderator_commission_percentage'),  // Admin commission percentage
                                                // DB::raw('((SUM(moderator_commssion) - (SUM(moderator_commssion) * 0.18)) / SUM(total_amount * 0.18)) * 100 as moderator_commission_percentage'),  // Moderator commission percentage
                                                DB::raw('CASE 
                                                            WHEN live_id IS NOT NULL THEN live_id
                                                            WHEN video_id IS NOT NULL THEN video_id
                                                            WHEN audio_id IS NOT NULL THEN audio_id
                                                            WHEN series_id IS NOT NULL THEN series_id
                                                            WHEN season_id IS NOT NULL THEN season_id
                                                            ELSE NULL
                                                        END as source_id'),
                                                DB::raw('CASE 
                                                            WHEN live_id IS NOT NULL THEN "LiveStream"
                                                            WHEN video_id IS NOT NULL THEN "Video"
                                                            WHEN audio_id IS NOT NULL THEN "Audio"
                                                            WHEN series_id IS NOT NULL THEN "Series"
                                                            WHEN season_id IS NOT NULL THEN "SeriesSeason"
                                                            ELSE NULL
                                                        END as source')  
                                            ])
                                            ->groupBy('video_id', 'live_id', 'audio_id', 'series_id', 'season_id')

                                            ->get()->map(function($item) {

                                                switch ($item->source) {

                                                    case 'LiveStream':
                                                        $item['source_name'] = LiveStream::where('uploaded_by','CPP')->where('id',$item->source_id)->pluck('title')->first();
                                                    break;

                                                    case 'Video':
                                                        $item['source_name'] = Video::where('uploaded_by','CPP')->where('id',$item->source_id)->pluck('title')->first();
                                                    break;

                                                    case 'Audio':
                                                        $item['source_name'] = Audio::where('uploaded_by','CPP')->where('id',$item->source_id)->pluck('title')->first();
                                                    break;

                                                    case 'Series':
                                                        $item['source_name'] = Series::where('uploaded_by','CPP')->where('id',$item->source_id)->pluck('title')->first();
                                                    break;
                                                    
                                                    case 'SeriesSeason':
                                                        $item['source_name'] = SeriesSeason::where('uploaded_by','CPP')->where('id',$item->source_id)->pluck('title')->first();
                                                    break;
                                                    
                                                    default:
                                                        $item['source_name'] = null;
                                                    break;
                                                }
                                                return $item;
                                            });

                                            
            $monthly_Summary  = PpvPurchase::where('moderator_id', $cpp_user_id)
                                                ->where('created_at', '>=', $filter_date) 
                                                ->where(function ($query) {
                                                    $query->where('status', 'captured')->orWhere('status', '1');
                                                })
                                                ->select([
                                                'video_id', 
                                                'live_id', 
                                                'audio_id', 
                                                'series_id', 
                                                'season_id',
                                                DB::raw('SUM(total_amount) as total_amount_with_gst'),  // Original total amount with GST
                                                DB::raw('SUM(total_amount * 0.18) as total_amount_without_gst'),  // Amount without GST
                                                DB::raw('SUM(total_amount) - SUM(total_amount * 0.18) as gst_value'),  // Exact GST value (18%)
                                                DB::raw('SUM(admin_commssion) as admin_commission_sum'), 
                                                DB::raw('SUM(moderator_commssion) - (SUM(moderator_commssion * 0.18)) as moderator_commission_sum'),
                                                DB::raw('((SUM(admin_commssion) - (SUM(admin_commssion * 0.18))) / ( SUM(total_amount) - SUM(total_amount * 0.18))) * 100 as admin_commission_percentage'),  // Admin commission percentage
                                                DB::raw('((SUM(moderator_commssion) - (SUM(moderator_commssion * 0.18))) / ( SUM(total_amount) - SUM(total_amount * 0.18))) * 100 as moderator_commission_percentage'),  // Moderator commission percentage
                                                DB::raw('CASE 
                                                            WHEN live_id IS NOT NULL THEN live_id
                                                            WHEN video_id IS NOT NULL THEN video_id
                                                            WHEN audio_id IS NOT NULL THEN audio_id
                                                            WHEN series_id IS NOT NULL THEN series_id
                                                            WHEN season_id IS NOT NULL THEN season_id
                                                            ELSE NULL
                                                        END as source_id'),
                                                DB::raw('CASE 
                                                            WHEN live_id IS NOT NULL THEN "LiveStream"
                                                            WHEN video_id IS NOT NULL THEN "Video"
                                                            WHEN audio_id IS NOT NULL THEN "Audio"
                                                            WHEN series_id IS NOT NULL THEN "Series"
                                                            WHEN season_id IS NOT NULL THEN "SeriesSeason"
                                                            ELSE NULL
                                                        END as source')  
                                            ])
                                            ->groupBy('video_id', 'live_id', 'audio_id', 'series_id', 'season_id')

                                            ->get()->map(function($item) use ( $cpp_user_id)  {

                                                $item['monthly_Summary'] = PpvPurchase::where('moderator_id', $cpp_user_id)
                                                            ->whereBetween('created_at', [Carbon::now()->subMonths(6), Carbon::now()]) 
                                                            ->where(function ($query) {
                                                                $query->where('status', 'captured')->orWhere('status', '1');
                                                            })
                                                            ->select([
                                                                DB::raw('DATE_FORMAT(created_at, "%M, %Y") as month_year'),  
                                                                DB::raw('COUNT(*) as units_sold'), 
                                                                DB::raw('SUM(total_amount) - SUM(total_amount * 0.18) as total_amount'),  
                                                                DB::raw('SUM(admin_commssion) as admin_commission_sum'), 
                                                                DB::raw('((SUM(moderator_commssion) - (SUM(moderator_commssion) * 0.18)) / SUM(total_amount)) * 100 as moderator_commission_percentage'),
                                                                DB::raw('SUM(moderator_commssion) - (SUM(moderator_commssion * 0.18)) as moderator_commission_sum'),
                                                            ])
                                                            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%M, %Y")'))  
                                                            ->orderBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'), 'desc')  
                                            
                                                                ->when($item->source == 'LiveStream', function ($query) use ($item) {
                                                                    return $query->where('live_id',$item->source_id);
                                                                })
                                                                ->when($item->source == 'Video', function ($query)  use ($item){
                                                                    return $query->where('video_id',$item->source_id);
                                                                })
                                                                ->when($item->source == 'Audio', function ($query)  use ($item){
                                                                    return $query->where('audio_id',$item->source_id);
                                                                })
                                                                ->when($item->source == 'Series', function ($query) use ($item) {
                                                                    return $query->where('series_id',$item->source_id);
                                                                })
                                                                ->when($item->source == 'SeriesSeason', function ($query) use ($item) {
                                                                    return $query->where('season_id',$item->source_id);
                                                                })
                                                            ->get();

                                                switch ($item->source) {

                                                    case 'LiveStream':
                                                        $item['source_name'] = LiveStream::where('uploaded_by','CPP')->where('id',$item->source_id)->pluck('title')->first();
                                                    break;

                                                    case 'Video':
                                                        $item['source_name'] = Video::where('uploaded_by','CPP')->where('id',$item->source_id)->pluck('title')->first();
                                                    break;

                                                    case 'Audio':
                                                        $item['source_name'] = Audio::where('uploaded_by','CPP')->where('id',$item->source_id)->pluck('title')->first();
                                                    break;

                                                    case 'Series':
                                                        $item['source_name'] = Series::where('uploaded_by','CPP')->where('id',$item->source_id)->pluck('title')->first();
                                                    break;
                                                    
                                                    case 'SeriesSeason':
                                                        $item['source_name'] = SeriesSeason::where('uploaded_by','CPP')->where('id',$item->source_id)->pluck('title')->first();
                                                    break;
                                                    
                                                    default:
                                                        $item['source_name'] = null;
                                                    break;
                                                }
                                                return $item;
                                            });

            $ppv_purchases_count = [
                'ppv_purchases_today_count'         => $ppv_purchases_today->count(),
                'ppv_purchases_current_month_count' => $ppv_purchases_current_month->count(),
                'ppv_purchases_current_year_count'  => $ppv_purchases_current_year->count(),

                'ppv_purchases_last_month_count'    => $ppv_purchases_last_month->count(),
                'ppv_purchases_last2ndmonth_count'  => $ppv_purchases_last2ndmonth->count(),
                'ppv_purchases_last3rdmonth_count'  => $ppv_purchases_last3rdmonth->count(),

                'ppv_purchases_last_year_count'     => $ppv_purchases_last_year->count(),

                'ppv_purchases_total_count'     => $ppv_purchases_total->count(),
                'Free_access_with_promotions'   => 0,
            ];

            $ppv_purchases_amount = [
                'ppv_purchases_today_total_amount'         => $ppv_purchases_today->sum('total_amount'),
                'ppv_purchases_current_month_total_amount' => $ppv_purchases_current_month->sum('total_amount'),
                'ppv_purchases_current_year_total_amount' => $ppv_purchases_current_year->sum('total_amount'),

                'ppv_purchases_last_month_total_amount'    => $ppv_purchases_last_month->sum('total_amount'),
                'ppv_purchases_last2ndmonth_total_amount'  => $ppv_purchases_last2ndmonth->count(),
                'ppv_purchases_last3rdmonth_total_amount'  => $ppv_purchases_last3rdmonth->count(),

                'ppv_purchases_last_year_total_amount'    => $ppv_purchases_last_year->sum('total_amount'),
                
                'ppv_purchases_total_amount'  => $ppv_purchases_total->sum('total_amount'),
                'ppv_purchases_admin_commission_sum' => $ppv_purchases_total->sum('admin_commssion'),
                'ppv_purchases_cpp_commission_sum'  => $ppv_purchases_total->sum('moderator_commssion'),

                'Free_access_with_promotions' =>  0,
            ];


            $sources_data = [
                'livestream' => LiveStream::where('user_id',$cpp_user_id)->where('uploaded_by','CPP')->orderBy('created_at', 'DESC')->get(),
                'video'      => Video::where('user_id',$cpp_user_id)->where('uploaded_by','CPP')->orderBy("created_at", "DESC")->get(),
                'series'     => Series::where('user_id', $cpp_user_id)->where('uploaded_by', 'CPP')->orderBy('created_at', 'DESC')->get(),
                'series_season' => SeriesSeason::where('series_id', $cpp_user_id)->where('uploaded_by', 'CPP')->get(),
                'audios' => Audio::where('user_id', $cpp_user_id)->where('uploaded_by','CPP')->get(),
            ];

            $data = array(
                'ppv_purchases_count' => $ppv_purchases_count ,
                'ppv_purchases_amount' => $ppv_purchases_amount ,
                'sources_data'     => $sources_data,
                'currency_symbol'  => currency_symbol(),
                'cpp_user_id'   => $cpp_user_id,
                'Sales_Summary' => $Sales_Summary,
                'monthly_Summary' => $monthly_Summary

            );

            return view('producer.home', $data);

        } catch (\Throwable $th) {
            // return $th->getMessage();
            return abort(404);
        }
    }

    public function stats(Request $request,$source,$source_id)
    {
        try {
         
            $current_time = $this->current_time;
            $cpp_user_id  = session()->get('cpp_user_id');

            // Current Time
            $today         = $current_time->toDateString();
            $current_month = $current_time->month;
            $current_year  = $current_time->year;

            // Previous Time
            $last_year = $current_time->copy()->subMonth()->year;
            $last_year = $current_time->copy()->subYear()->year;

            $last_month    = $current_time->copy()->subMonth(1);
            $last2ndmonth =$current_time->copy()->subMonth(2);
            $last3ndmonth = $current_time->copy()->subMonth(3);

            $ppv_purchases_today = PpvPurchase::where('moderator_id', $cpp_user_id)
                                                    ->where('created_at', '>=', $filter_date) 
                                                    ->whereDate('created_at', $today)
                                                    ->where(function ($query) {
                                                        $query->where('status', 'captured')->orWhere('status', '1');
                                                    })
                                                    ->when($source === 'video', function($query) use ($source_id) {
                                                        return $query->where('video_id', $source_id);
                                                    })
                                                    ->when($source === 'livestream', function($query) use ($source_id) {
                                                        return $query->where('live_id', $source_id);
                                                    })
                                                    ->when($source === 'audio', function($query) use ($source_id) {
                                                        return $query->where('audio_id', $source_id);
                                                    })
                                                    ->when($source === 'series', function($query) use ($source_id) {
                                                        return $query->where('series_id', $source_id);
                                                    })
                                                    ->when($source === 'series_season', function($query) use ($source_id) {
                                                        return $query->where('season_id', $source_id);
                                                    })
                                                    ->get();

                $ppv_purchases_current_month = PpvPurchase::where('moderator_id', $cpp_user_id)
                                                        ->where('created_at', '>=', $filter_date)   
                                                        ->whereYear('created_at', $current_year)
                                                        ->whereMonth('created_at', $current_month)
                                                        ->where(function ($query) {
                                                            $query->where('status', 'captured')->orWhere('status', '1');
                                                        })
                                                        ->when($source === 'video', function($query) use ($source_id) {
                                                            return $query->where('video_id', $source_id);
                                                        })
                                                        ->when($source === 'livestream', function($query) use ($source_id) {
                                                            return $query->where('live_id', $source_id);
                                                        })
                                                        ->when($source === 'audio', function($query) use ($source_id) {
                                                            return $query->where('audio_id', $source_id);
                                                        })
                                                        ->when($source === 'series', function($query) use ($source_id) {
                                                            return $query->where('series_id', $source_id);
                                                        })
                                                        ->when($source === 'series_season', function($query) use ($source_id) {
                                                            return $query->where('season_id', $source_id);
                                                        })
                                                        ->get();

                $ppv_purchases_last_month = PpvPurchase::where('moderator_id', $cpp_user_id)
                                                    ->where('created_at', '>=', $filter_date) 
                                                    ->whereYear('created_at', $current_year)
                                                    ->whereMonth('created_at', $last_month->month)
                                                    ->where(function ($query) {
                                                        $query->where('status', 'captured')->orWhere('status', '1');
                                                    })                                                
                                                    ->when($source === 'video', function($query) use ($source_id) {
                                                        return $query->where('video_id', $source_id);
                                                    })
                                                    ->when($source === 'livestream', function($query) use ($source_id) {
                                                        return $query->where('live_id', $source_id);
                                                    })
                                                    ->when($source === 'audio', function($query) use ($source_id) {
                                                        return $query->where('audio_id', $source_id);
                                                    })
                                                    ->when($source === 'series', function($query) use ($source_id) {
                                                        return $query->where('series_id', $source_id);
                                                    })
                                                    ->when($source === 'series_season', function($query) use ($source_id) {
                                                        return $query->where('season_id', $source_id);
                                                    })
                                                    ->get();

                                                    
                $ppv_purchases_last2ndmonth = PpvPurchase::where('moderator_id', $cpp_user_id)
                                                    ->where('created_at', '>=', $filter_date) 
                                                    ->whereYear('created_at', $current_year)
                                                    ->whereMonth('created_at', $last2ndmonth->month)
                                                    ->where(function ($query) {
                                                        $query->where('status', 'captured')->orWhere('status', '1');
                                                    })
                                                    ->when($source === 'video', function($query) use ($source_id) {
                                                        return $query->where('video_id', $source_id);
                                                    })
                                                    ->when($source === 'livestream', function($query) use ($source_id) {
                                                        return $query->where('live_id', $source_id);
                                                    })
                                                    ->when($source === 'audio', function($query) use ($source_id) {
                                                        return $query->where('audio_id', $source_id);
                                                    })
                                                    ->when($source === 'series', function($query) use ($source_id) {
                                                        return $query->where('series_id', $source_id);
                                                    })
                                                    ->when($source === 'series_season', function($query) use ($source_id) {
                                                        return $query->where('season_id', $source_id);
                                                    })
                                                    ->get();

                                                    
                $ppv_purchases_last3rdmonth = PpvPurchase::where('moderator_id', $cpp_user_id)
                                                    ->where('created_at', '>=', $filter_date) 
                                                    ->whereYear('created_at', $current_year)
                                                    ->whereMonth('created_at', $last3ndmonth->month)
                                                    ->where(function ($query) {
                                                        $query->where('status', 'captured')->orWhere('status', '1');
                                                    })
                                                    ->when($source === 'video', function($query) use ($source_id) {
                                                        return $query->where('video_id', $source_id);
                                                    })
                                                    ->when($source === 'livestream', function($query) use ($source_id) {
                                                        return $query->where('live_id', $source_id);
                                                    })
                                                    ->when($source === 'audio', function($query) use ($source_id) {
                                                        return $query->where('audio_id', $source_id);
                                                    })
                                                    ->when($source === 'series', function($query) use ($source_id) {
                                                        return $query->where('series_id', $source_id);
                                                    })
                                                    ->when($source === 'series_season', function($query) use ($source_id) {
                                                        return $query->where('season_id', $source_id);
                                                    })
                                                    ->get();

            $ppv_purchases_current_year = PpvPurchase::where('moderator_id', $cpp_user_id)
                                                    ->where('created_at', '>=', $filter_date) 
                                                    ->whereYear('created_at', $current_year)
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
                                                    })
                                                    ->get();
                                                

                $ppv_purchases_last_year = PpvPurchase::where('moderator_id', $cpp_user_id)
                                                    ->where('created_at', '>=', $filter_date) 
                                                    ->whereYear('created_at', $last_year)
                                                    ->where(function ($query) {
                                                        $query->where('status', 'captured')->orWhere('status', '1');
                                                    })
                                                    ->when($source === 'video', function($query) use ($source_id) {
                                                        return $query->where('video_id', $source_id);
                                                    })
                                                    ->when($source === 'livestream', function($query) use ($source_id) {
                                                        return $query->where('live_id', $source_id);
                                                    })
                                                    ->when($source === 'audio', function($query) use ($source_id) {
                                                        return $query->where('audio_id', $source_id);
                                                    })
                                                    ->when($source === 'series', function($query) use ($source_id) {
                                                        return $query->where('series_id', $source_id);
                                                    })
                                                    ->when($source === 'series_season', function($query) use ($source_id) {
                                                        return $query->where('season_id', $source_id);
                                                    })
                                                    ->get();

                $ppv_purchases_total = PpvPurchase::where('moderator_id', $cpp_user_id)
                                                            ->where('created_at', '>=', $filter_date) 
                                                            ->where('status','captured')
                                                            ->when($source === 'video', function($query) use ($source_id) {
                                                                return $query->where('video_id', $source_id);
                                                            })
                                                            ->when($source === 'livestream', function($query) use ($source_id) {
                                                                return $query->where('live_id', $source_id);
                                                            })
                                                            ->when($source === 'audio', function($query) use ($source_id) {
                                                                return $query->where('audio_id', $source_id);
                                                            })
                                                            ->when($source === 'series', function($query) use ($source_id) {
                                                                return $query->where('series_id', $source_id);
                                                            })
                                                            ->when($source === 'series_season', function($query) use ($source_id) {
                                                                return $query->where('season_id', $source_id);
                                                            })
                                                            ->get();

            // dd($ppv_purchases_total);
            $ppv_purchases_count = [
                'ppv_purchases_today_count'         => $ppv_purchases_today->count(),
                'ppv_purchases_current_month_count' => $ppv_purchases_current_month->count(),
                'ppv_purchases_current_year_count'  => $ppv_purchases_current_year->count(),

                'ppv_purchases_last_month_count'    => $ppv_purchases_last_month->count(),
                'ppv_purchases_last2ndmonth_count'  => $ppv_purchases_last2ndmonth->count(),
                'ppv_purchases_last3rdmonth_count'  => $ppv_purchases_last3rdmonth->count(),

                'ppv_purchases_last_year_count'     => $ppv_purchases_last_year->count(),

                'ppv_purchases_total_count'     => $ppv_purchases_total->count(),
                'Free_access_with_promotions'   => 0,
            ];

            $ppv_purchases_cpp_commission_sum = $ppv_purchases_total->sum('moderator_commssion') - ($ppv_purchases_total->sum('moderator_commssion') * 0.18);
            $ppv_purchases_amount = [
                'ppv_purchases_today_total_amount'         => $ppv_purchases_today->sum('total_amount'),
                'ppv_purchases_current_month_total_amount' => $ppv_purchases_current_month->sum('total_amount'),
                'ppv_purchases_current_year_total_amount' => $ppv_purchases_current_year->sum('total_amount'),

                'ppv_purchases_last_month_total_amount'    => $ppv_purchases_last_month->sum('total_amount'),
                'ppv_purchases_last2ndmonth_total_amount'  => $ppv_purchases_last2ndmonth->count(),
                'ppv_purchases_last3rdmonth_total_amount'  => $ppv_purchases_last3rdmonth->count(),

                'ppv_purchases_last_year_total_amount'    => $ppv_purchases_last_year->sum('total_amount'),
                
                'ppv_purchases_total_amount'  => $ppv_purchases_total->sum('total_amount'),
                'ppv_purchases_admin_commission_sum' => $ppv_purchases_total->sum('admin_commssion'),
                'ppv_purchases_cpp_commission_sum' => $ppv_purchases_cpp_commission_sum,
                'ppv_purchases_admin_commission_sum' => $ppv_purchases_total->sum('total_amount') - $ppv_purchases_cpp_commission_sum,
                // 'ppv_purchases_cpp_commission_sum'  => $ppv_purchases_total->sum('moderator_commssion') -  sum('moderator_commssion') * 0.18,

                'Free_access_with_promotions' => 0,
            ];

            switch ($source) {
                case 'video':
                    $stats_sources = Video::where('user_id', $cpp_user_id)
                                    ->where('uploaded_by', 'CPP')->where('id', $source_id)
                                    ->orderBy('created_at', 'DESC')->first();
                    break;
            
                case 'livestream': 
                    $stats_sources = LiveStream::where('user_id', $cpp_user_id)
                                        ->where('uploaded_by', 'CPP')->where('id', $source_id)
                                        ->orderBy('created_at', 'DESC')->first();
                    break;

                case 'series': 
                    $stats_sources = Series::where('user_id', $cpp_user_id)
                                        ->where('uploaded_by', 'CPP')->where('id', $source_id)->orderBy('created_at', 'DESC')->get()
                                        ->map(function($item){
                                            $item['access'] = SeriesSeason::where('uploaded_by', 'CPP')->where('series_id', $item->id)->where('access','ppv')->pluck('access')->first();
                                            return $item;
                                        })
                                        ->first();
                    break;

                case 'series_season': 
                    $stats_sources =  SeriesSeason::where('series_id', $cpp_user_id)
                                            ->where('uploaded_by', 'CPP')->where('id', $source_id)
                                            ->orderBy('created_at', 'DESC')->first();

                    break;

                case 'audio': 
                    $stats_sources =   Audio::where('user_id', $cpp_user_id)
                                    ->where('uploaded_by', 'CPP')->where('id', $source_id)
                                    ->orderBy('created_at', 'DESC')->first();
                    break;
            
                default:
                    $stats_sources = null; 
                    break;
            }

            $sources_data = [
                'livestream' => LiveStream::where('user_id',$cpp_user_id)->where('uploaded_by','CPP')->orderBy('created_at', 'DESC')->get(),
                'video'      => Video::where('user_id',$cpp_user_id)->where('uploaded_by','CPP')->orderBy("created_at", "DESC")->get(),
                'series'     => Series::where('user_id', $cpp_user_id)->where('uploaded_by', 'CPP')->orderBy('created_at', 'DESC')->get(),
                'series_season' => SeriesSeason::where('series_id', $cpp_user_id)->where('uploaded_by', 'CPP')->get(),
                'audios' => Audio::where('user_id', $cpp_user_id)->where('uploaded_by','CPP')->get(),
            ];

            $data = array(
                'ppv_purchases_count' => $ppv_purchases_count ,
                'ppv_purchases_amount' => $ppv_purchases_amount ,
                'sources_data'     => $sources_data,
                'stats_sources'    => $stats_sources,
                'currency_symbol'  => currency_symbol(),
                'cpp_user_id' => $cpp_user_id,
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
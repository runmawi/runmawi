<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\ModeratorsUser;
use App\SeriesSeason;
use App\PpvPurchase;
use App\LiveStream;
use App\Video;
use App\Series;
use App\Audio;
use Theme;

class ProducerController extends Controller
{
    public function __construct()
    {
        $current_timezone = 'Asia/Kolkata';
        $this->current_time = Carbon::now($current_timezone);
    }

    public function login(Request $request)
    {
        try {
            return view('producer.login');

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
        
            $request->session()->put('cpp_user_id', $ModeratorsUser->id);

            return redirect()->intended(route('producer.home'));

        } catch (\Throwable $th) {

            return abort(404);
        }
    }

    public function home(Request $request)
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

            $last_month    = $current_time->copy()->subMonth(1)->month;
            $last2ndmonth =$current_time->copy()->subMonth(2)->month;
            $last3ndmonth = $current_time->copy()->subMonth(3)->month;

            $ppv_purchases_today = PpvPurchase::where('moderator_id', $cpp_user_id)
                                                    ->whereDate('created_at', $today)
                                                    ->get();

            $ppv_purchases_current_month = PpvPurchase::where('moderator_id', $cpp_user_id)
                                                    ->whereYear('created_at', $current_year)
                                                    ->whereMonth('created_at', $current_month)
                                                    ->get();

            $ppv_purchases_last_month = PpvPurchase::where('moderator_id', $cpp_user_id)
                                                ->whereYear('created_at', $current_year)
                                                ->whereMonth('created_at', $last_month)
                                                ->get();

                                                
            $ppv_purchases_last2ndmonth = PpvPurchase::where('moderator_id', $cpp_user_id)
                                                ->whereYear('created_at', $current_year)
                                                ->whereMonth('created_at', $last2ndmonth)
                                                ->get();

                                                
            $ppv_purchases_last3rdmonth = PpvPurchase::where('moderator_id', $cpp_user_id)
                                                ->whereYear('created_at', $current_year)
                                                ->whereMonth('created_at', $last3ndmonth)
                                                ->get();

            $ppv_purchases_current_year = PpvPurchase::where('moderator_id', $cpp_user_id)
                                                    ->whereYear('created_at', $current_year)
                                                    ->get();

            $ppv_purchases_last_year = PpvPurchase::where('moderator_id', $cpp_user_id)
                                                ->whereYear('created_at', $last_year)
                                                ->get();

            $ppv_purchases_total = PpvPurchase::where('moderator_id', $cpp_user_id)->get();

            $Sales_Summary = PpvPurchase::where('moderator_id', $cpp_user_id)
                                            ->select([
                                                'video_id', 
                                                'live_id', 
                                                'audio_id', 
                                                'series_id', 
                                                'season_id',
                                                DB::raw('SUM(total_amount) as total_amount_with_gst'),  // Original total amount with GST
                                                DB::raw('SUM(total_amount / 1.18) as total_amount_without_gst'),  // Amount without GST
                                                DB::raw('SUM(total_amount) - SUM(total_amount / 1.18) as gst_value'),  // Exact GST value (18%)
                                                DB::raw('SUM(admin_commssion) as admin_commission_sum'), 
                                                DB::raw('SUM(moderator_commssion) as moderator_commission_sum'),
                                                DB::raw('((SUM(admin_commssion) / SUM(total_amount)) * 100) as admin_commission_percentage'),  // Admin commission percentage
                                                DB::raw('((SUM(moderator_commssion) / SUM(total_amount)) * 100) as moderator_commission_percentage'),  // Moderator commission percentage
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
                                            ->select([
                                                'video_id', 
                                                'live_id', 
                                                'audio_id', 
                                                'series_id', 
                                                'season_id',
                                                DB::raw('SUM(total_amount) as total_amount_with_gst'),  // Original total amount with GST
                                                DB::raw('SUM(total_amount / 1.18) as total_amount_without_gst'),  // Amount without GST
                                                DB::raw('SUM(total_amount) - SUM(total_amount / 1.18) as gst_value'),  // Exact GST value (18%)
                                                DB::raw('SUM(admin_commssion) as admin_commission_sum'), 
                                                DB::raw('SUM(moderator_commssion) as moderator_commission_sum'),
                                                DB::raw('((SUM(admin_commssion) / SUM(total_amount)) * 100) as admin_commission_percentage'),  // Admin commission percentage
                                                DB::raw('((SUM(moderator_commssion) / SUM(total_amount)) * 100) as moderator_commission_percentage'),  // Moderator commission percentage
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
                                                            ->select([
                                                                DB::raw('DATE_FORMAT(created_at, "%M, %Y") as month_year'),  
                                                                DB::raw('COUNT(*) as units_sold'), 
                                                                DB::raw('SUM(total_amount) as total_amount'),  
                                                                DB::raw('SUM(admin_commssion) as admin_commission_sum'), 
                                                                DB::raw('SUM(moderator_commssion) as moderator_commission_sum'),
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

            $last_month    = $current_time->copy()->subMonth(1)->month;
            $last2ndmonth =$current_time->copy()->subMonth(2)->month;
            $last3ndmonth = $current_time->copy()->subMonth(3)->month;

            $ppv_purchases_today = PpvPurchase::where('moderator_id', $cpp_user_id)
                                                    ->whereDate('created_at', $today)
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
                                                        ->whereYear('created_at', $current_year)
                                                        ->whereMonth('created_at', $current_month)
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
                                                    ->whereYear('created_at', $current_year)
                                                    ->whereMonth('created_at', $last_month)
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
                                                    ->whereYear('created_at', $current_year)
                                                    ->whereMonth('created_at', $last2ndmonth)
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
                                                    ->whereYear('created_at', $current_year)
                                                    ->whereMonth('created_at', $last3ndmonth)
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
                                                        ->whereYear('created_at', $current_year)
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

                $ppv_purchases_last_year = PpvPurchase::where('moderator_id', $cpp_user_id)
                                                    ->whereYear('created_at', $last_year)
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
                                        ->where('uploaded_by', 'CPP')->where('id', $source_id)
                                        ->orderBy('created_at', 'DESC')->first();
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
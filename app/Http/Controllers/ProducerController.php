<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\PpvPurchase;
use App\LiveStream;
use App\Video;
use App\Series;
use App\SeriesSeason;
use App\Audio;
use Theme;

class ProducerController extends Controller
{
    public function __construct()
    {
        $current_timezone = 'Asia/Kolkata';
        $this->current_time = Carbon::now($current_timezone);
    }

    public function home(Request $request)
    {
        $current_time = $this->current_time;
        $cpp_user_id = 1;

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

            'Free_access_with_promotions' =>  $ppv_purchases_total->filter(function ($purchase) {
                                                        return $purchase->type === 'guest'; 
                                                    }),
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
            'cpp_user_id' => $cpp_user_id,
        );

        return view('Producer.home', $data);
    }

    public function stats(Request $request,$source,$source_id)
    {
        $current_time = $this->current_time;
        $cpp_user_id = 1;

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

        return view('Producer.stats', $data);
    }
}
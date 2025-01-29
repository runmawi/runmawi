<?php

namespace App\Http\Controllers;

use \App\User as User;
use \App\Setting as Setting;
use \App\Video as Video;
use \App\VideoCategory as VideoCategory;
use \App\PpvVideo as PpvVideo;
use \App\Subscription as Subscription;
use \Redirect as Redirect;
use Illuminate\Http\Request;
use App\RecentView as RecentView;
use URL;
use Carbon\Carbon as Carbon;
use Auth;
use Hash;
use Illuminate\Support\Facades\Cache;
use Image;
use View;
use App\CategoryVideo as CategoryVideo;
use App\LanguageVideo;
use App\Episode;
use App\LiveStream;
use App\Audio;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use Mail;
use Laravel\Cashier\Invoice;
use App\StorageSetting;
use App\PpvPurchase;
use App\Language;
use App\LoggedDevice;
use App\GuestLoggedDevice;
use GuzzleHttp\Exception\RequestException;
use League\Flysystem\Filesystem;
use PlatformCommunity\Flysystem\BunnyCDN\BunnyCDNAdapter;
use PlatformCommunity\Flysystem\BunnyCDN\BunnyCDNClient;
use PlatformCommunity\Flysystem\BunnyCDN\BunnyCDNRegion;
use Illuminate\Support\Facades\Storage;
use App\UserTranslation;
use App\CurrencySetting;
use Session;
use DB;

class AdminContentAnalyticsController extends Controller
{

    public function ContentAnalytics(Request $request){

        try {

            $monthFilter = $request->input('month_filter');

            $monthCondition = function ($query) use ($monthFilter) {
                if ($monthFilter) {
                    $query->whereRaw('MONTH(ppv_purchases.created_at) = ?', [$monthFilter]);
                }
            };

            $videos_ppv_content = PpvPurchase::join('videos', 'videos.id' , '=', 'ppv_purchases.video_id')
            ->select(
                DB::raw('videos.title'),
                DB::raw('videos.id as videoId'),
                DB::raw('COUNT(ppv_purchases.id) as purchase_count'),       
                DB::raw('ppv_purchases.created_at as ppvcreated_at'),
                DB::raw('MONTHNAME(ppv_purchases.created_at) as month_name'),
                DB::raw('SUM(ppv_purchases.total_amount) as total_amount')
            )
            ->where($monthCondition) 
            ->where('ppv_purchases.status', 'captured') 
            ->groupBy('videos.id',) 
            ->orderBy('purchase_count', 'desc')
            ->get();

            $series_ppv_content = PpvPurchase::join('series', 'series.id' , '=', 'ppv_purchases.series_id')
            ->select(
                DB::raw('series.title'),
                DB::raw('series.id as seriesId'),
                DB::raw('COUNT(ppv_purchases.id) as purchase_count'),       
                DB::raw('ppv_purchases.created_at as ppvcreated_at'),
                DB::raw('MONTHNAME(ppv_purchases.created_at) as month_name'),
                DB::raw('SUM(ppv_purchases.total_amount) as total_amount')
            )
            ->where($monthCondition) 
            ->where('ppv_purchases.status', 'captured') 
            ->groupBy('series.id',) 
            ->orderBy('purchase_count', 'desc')
            ->get();

            $audio_ppv_content = PpvPurchase::join('audio', 'audio.id' , '=', 'ppv_purchases.audio_id')
            ->select(
                DB::raw('audio.title'),
                DB::raw('audio.id as audioId'),
                DB::raw('COUNT(ppv_purchases.id) as purchase_count'),       
                DB::raw('ppv_purchases.created_at as ppvcreated_at'),
                DB::raw('MONTHNAME(ppv_purchases.created_at) as month_name'),
                DB::raw('SUM(ppv_purchases.total_amount) as total_amount')
            )
            ->where($monthCondition) 
            ->where('ppv_purchases.status', 'captured') 
            ->groupBy('audio.id',) 
            ->orderBy('purchase_count', 'desc')
            ->get();

            $live_ppv_content = PpvPurchase::join('live_streams', 'live_streams.id' , '=', 'ppv_purchases.live_id')
            ->select(
                DB::raw('live_streams.title'),
                DB::raw('live_streams.id as liveId'),
                DB::raw('COUNT(ppv_purchases.id) as purchase_count'),       
                DB::raw('ppv_purchases.created_at as ppvcreated_at'),
                DB::raw('MONTHNAME(ppv_purchases.created_at) as month_name'),
                DB::raw('SUM(ppv_purchases.total_amount) as total_amount')
            )
            ->where($monthCondition) 
            ->where('ppv_purchases.status', 'captured') 
            ->groupBy('live_streams.id',) 
            ->orderBy('purchase_count', 'desc')
            ->get();

            $data = [
                "audio_ppv_content" => $audio_ppv_content,
                "videos_ppv_content" => $videos_ppv_content,
                "series_ppv_content" => $series_ppv_content,
                "live_ppv_content" => $live_ppv_content,
                "currency" => CurrencySetting::first(),
                "selectedMonth" => $monthFilter,
            ];

            // dd($videos_ppv_content ,$live_ppv_content ,$audio_ppv_content,$series_ppv_content);

            return view("admin.analytics.content_analytics", $data);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
<?php
namespace App\Http\Controllers;

use App\ModeratorsPermission;
use App\ModeratorsRole;
use App\ModeratorsUser;
use App\PpvPurchase;
use App\CurrencySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use URL;
use App\UserAccess;
use Hash;
use Illuminate\Support\Facades\DB;
use App\Video as Video;
use App\VideoCategory as VideoCategory;
use Image;
use App\Menu as Menu;
use App\Country as Country;
use App\Slider as Slider;
use App\MoviesSubtitles as MoviesSubtitles;
use App\VideoResolution as VideoResolution;
use App\VideosSubtitle as VideosSubtitle;
use App\Language as Language;
use App\VideoLanguage as VideoLanguage;
use App\Subtitle as Subtitle;
use App\Setting as Setting;
use App\PaymentSetting as PaymentSetting;
use App\SystemSetting as SystemSetting;
use App\HomeSetting as HomeSetting;
use Illuminate\Support\Str;
use App\MobileApp as MobileApp;
use App\MobileSlider as MobileSlider;
use App\ThemeSetting as ThemeSetting;
use App\SiteTheme as SiteTheme;
use App\Page as Page;
use App\LiveStream as LiveStream;
use App\LiveCategory as LiveCategory;
use App\User as User;
use Auth;
use App\Role as Role;
use App\Playerui as Playerui;
use App\Plan as Plan;
use App\PaypalPlan as PaypalPlan;
use App\Coupon as Coupon;
use App\Series as Series;
use App\Genre as Genre;
use App\Episode as Episode;
use App\SeriesSeason as SeriesSeason;
use App\Artist;
use App\Seriesartist;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg as FFMpeg;
use ffmpeg\FFProbe;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;
use App\Http\Requests\StoreVideoRequest;
use App\Jobs\ConvertVideoForStreaming;
use Illuminate\Contracts\Filesystem\Filesystem;
use FFMpeg\Filters\Video\VideoFilters;
use App\Videoartist;
use App\AudioCategory as AudioCategory;
use App\AudioAlbums as AudioAlbums;
use Illuminate\Support\Facades\Cache;
use App\Audio as Audio;
use File;
use App\VideoCommission as VideoCommission;
use Mail;
use App\EmailTemplate;
use App\PlayerAnalytic;
use Session;
use View;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use App\Region;
use App\RegionView;
use App\ModeratorPayout;
use App\ChannelPayout;



class ChannelPayoutController extends Controller
{
    public function Payouts(Request $request)
    {
        $user = User::where("id", 1)->first();
        $duedate = $user->package_ends;
        $current_date = date("Y-m-d");
        if ($current_date > $duedate) {
            $client = new Client();
            $url = "https://flicknexs.com/userapi/allplans";
            $params = [
                "userid" => 0,
            ];

            $headers = [
                "api-key" => "k3Hy5qr73QhXrmHLXhpEh6CQ",
            ];
            $response = $client->request("post", $url, [
                "json" => $params,
                "headers" => $headers,
                "verify" => false,
            ]);

            $responseBody = json_decode($response->getBody());
            $settings = Setting::first();
            $data = [
                "settings" => $settings,
                "responseBody" => $responseBody,
            ];
            return View::make("admin.expired_dashboard", $data);
        } else {

            $payouts = PpvPurchase::where("channel_id", "!=", null)
            // ->join("videos", "videos.id", "=", "ppv_purchases.video_id")
            ->join(
                "channels",
                "channels.id",
                "=",
                "ppv_purchases.channel_id"
            )
            ->groupBy("ppv_purchases.channel_id")
            ->get([
                "ppv_purchases.channel_id",
                "channels.channel_name",
                DB::raw(
                    "sum(ppv_purchases.moderator_commssion) as moderator_commssion"
                ),
                DB::raw(
                    "sum(ppv_purchases.admin_commssion) as admin_commssion"
                ),
                DB::raw("sum(ppv_purchases.total_amount) as total_amount"),
                DB::raw("COUNT(ppv_purchases.video_id) as count"),
            ]);

            $last_paid_amount = ChannelPayout::groupBy('user_id')
            ->selectRaw('sum(channel_payouts.commission_paid) as commission_paid, user_id') // do the sum query here
            ->pluck('commission_paid', 'user_id', 'commission_pending'); 
        
            // dd($last_paid_amount);
            // $commission = VideoCommission::first();
            $commission = VideoCommission::where('type','Channel')->first();

            $data = [
                "commission" => $commission,
                "payouts" => $payouts,
                "last_paid_amount" => $last_paid_amount,
            ];
            return view("channel.payouts.index", $data);
        }
    }

    public function EditPayouts($id)
    {
        $user = User::where("id", 1)->first();
        $duedate = $user->package_ends;
        $current_date = date("Y-m-d");
        if ($current_date > $duedate) {
            $client = new Client();
            $url = "https://flicknexs.com/userapi/allplans";
            $params = [
                "userid" => 0,
            ];

            $headers = [
                "api-key" => "k3Hy5qr73QhXrmHLXhpEh6CQ",
            ];
            $response = $client->request("post", $url, [
                "json" => $params,
                "headers" => $headers,
                "verify" => false,
            ]);

            $responseBody = json_decode($response->getBody());
            $settings = Setting::first();
            $data = [
                "settings" => $settings,
                "responseBody" => $responseBody,
            ];
            return View::make("admin.expired_dashboard", $data);
        } else {
            $payouts = PpvPurchase::where("channel_id", "!=", null)
            ->join(
                "channels",
                "channels.id",
                "=",
                "ppv_purchases.channel_id"
            )
                ->where("ppv_purchases.channel_id", $id)
                ->get([
                    "ppv_purchases.channel_id",
                    "channels.channel_name",
                    DB::raw(
                        "sum(ppv_purchases.moderator_commssion) as moderator_commssion"
                    ),
                    DB::raw(
                        "sum(ppv_purchases.admin_commssion) as admin_commssion"
                    ),
                    DB::raw("sum(ppv_purchases.total_amount) as total_amount"),
                    DB::raw("COUNT(ppv_purchases.video_id) as count"),
                ]);
            // dd($payouts);

            $commission = VideoCommission::where('type','Channel')->first();
            
            $settings = Setting::first();

            $last_paid_amount = ChannelPayout::where('user_id',$id)->get([
                DB::raw(
                    "sum(channel_payouts.commission_paid) as commission_paid"
                ) 
            ]);
            
            if(count($last_paid_amount) > 0){ $last_paid = intval($last_paid_amount[0]->commission_paid) ; }else{ $last_paid = 0; }
            // dd($payouts);

            $data = [
                "commission" => $commission,
                "payouts" => $payouts,
                "last_paid" => $last_paid,
            ];


            if ($settings->payout_method == 0) {
                return view("channel.payouts.edit_manualpayouts", $data);
            } elseif ($settings->payout_method == 1) {
                return view("channel.payouts.edit_payment_payouts", $data);
            }
        }
    }
    public function UpdatePayouts(Request $request)
    {
        $user = User::where("id", 1)->first();
        $duedate = $user->package_ends;
        $current_date = date("Y-m-d");
        if ($current_date > $duedate) {
            $client = new Client();
            $url = "https://flicknexs.com/userapi/allplans";
            $params = [
                "userid" => 0,
            ];

            $headers = [
                "api-key" => "k3Hy5qr73QhXrmHLXhpEh6CQ",
            ];
            $response = $client->request("post", $url, [
                "json" => $params,
                "headers" => $headers,
                "verify" => false,
            ]);

            $responseBody = json_decode($response->getBody());
            $settings = Setting::first();
            $data = [
                "settings" => $settings,
                "responseBody" => $responseBody,
            ];
            return View::make("admin.expired_dashboard", $data);
        } else {
            $data = $request->all();
                $last_paid_amount = ChannelPayout::where('user_id',$data['id'])->get([
                    DB::raw(
                        "sum(channel_payouts.commission_paid) as commission_paid"
                    ) 
                ]);
                // dd($last_paid_amount);
                if(count($last_paid_amount) > 0){ $last_paid = intval($last_paid_amount[0]->commission_paid) ; }else{ $last_paid = 0; }

            if (
                !empty($data["payment_type"]) &&
                $data["payment_type"] == "Partial_amount"
            ) {

                if ( $data["commission"] != $data["commission_paid"]) {

                    $paid_amount =   $data["commission"] - $data["commission_paid"] - $last_paid ;
                // dd($paid_amount);
                } else {
                    $paid_amount = $data["commission_paid"];
                }
            } elseif (
                !empty($data["payment_type"]) &&
                $data["payment_type"] == "full_amount"
            ) {
                if ($data["commission_paid"] == $data["commission"]) {
                    $paid_amount = $data["commission_paid"];
                } else {
                    $paid_amount =  $data["commission"] - $data["commission_paid"] - $last_paid;
                }
            }
            // dd($paid_amount);
            $invoice = $data["invoice"];

            $path = public_path() . "/uploads/invoice/";

            if ($invoice != "") {
                //code for remove old file
                if ($invoice != "" && $invoice != null) {
                    $file_old = $path . $invoice;
                    if (file_exists($file_old)) {
                        unlink($file_old);
                    }
                }
                //upload new file
                $file = $invoice;
                $invoice =
                    URL::to("/") .
                    "/public/uploads/invoice/" .
                    str_replace(" ", "_", $file->getClientOriginalName());
                $file->move($path, $file->getClientOriginalName());
            }else{
                $invoice = "";
            }
            // dd($paid_amount);
            $ChannelPayout = new ChannelPayout();
            $ChannelPayout->user_id = $data["id"];
            $ChannelPayout->commission_paid = $data["commission_paid"];
            $ChannelPayout->commission_pending = $paid_amount;
            $ChannelPayout->payment_type = $data["payment_type"];
            $ChannelPayout->invoice = $invoice;
            $ChannelPayout->save();

            return \Redirect::to('/admin/channel/payouts');
        }
    }

    public function ViewPayouts($id)
    {
        $user = User::where("id", 1)->first();
        $duedate = $user->package_ends;
        $current_date = date("Y-m-d");
        if ($current_date > $duedate) {
            $client = new Client();
            $url = "https://flicknexs.com/userapi/allplans";
            $params = [
                "userid" => 0,
            ];

            $headers = [
                "api-key" => "k3Hy5qr73QhXrmHLXhpEh6CQ",
            ];
            $response = $client->request("post", $url, [
                "json" => $params,
                "headers" => $headers,
                "verify" => false,
            ]);

            $responseBody = json_decode($response->getBody());
            $settings = Setting::first();
            $data = [
                "settings" => $settings,
                "responseBody" => $responseBody,
            ];
            return View::make("admin.expired_dashboard", $data);
        } else {
            $payouts = PpvPurchase::where("video_id", "!=", null)
                ->join("videos", "videos.id", "=", "ppv_purchases.video_id")
                ->join(
                    "channels",
                    "channels.id",
                    "=",
                    "ppv_purchases.user_id"
                )
                ->where("videos.uploaded_by", "Channel")
                ->where("ppv_purchases.user_id", $id)
                ->groupBy("ppv_purchases.user_id")
                ->get([
                    "ppv_purchases.user_id",
                    "channels.channel_name",
                    DB::raw(
                        "sum(ppv_purchases.moderator_commssion) as moderator_commssion"
                    ),
                    DB::raw(
                        "sum(ppv_purchases.admin_commssion) as admin_commssion"
                    ),
                    DB::raw("sum(ppv_purchases.total_amount) as total_amount"),
                    DB::raw("COUNT(ppv_purchases.video_id) as count"),
                ]);
            // dd($payouts);

            $commission = VideoCommission::where('type','Channel')->first();
            
            $settings = Setting::first();

            $last_paid_amount = ChannelPayout::where('user_id',$id)->get([
                DB::raw(
                    "sum(channel_payouts.commission_paid) as commission_paid"
                ) 
            ]);
            
            $ChannelPayout = ChannelPayout::where('user_id',$id)->get();
            
            if(count($last_paid_amount) > 0){ $last_paid = intval($last_paid_amount[0]->commission_paid) ; }else{ $last_paid = 0; }

            $data = [
                "commission" => $commission,
                "payouts" => $payouts,
                "last_paid" => $last_paid,
                "ChannelPayout" => $ChannelPayout,

            ];
                return view("channel.payouts.view_payouts", $data);
        }
    }


}
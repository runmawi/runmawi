<?php

namespace App\Http\Controllers;

use URL;
use Auth;
use File;
use Hash;
use Mail;
use View;
use Image;
use Session;
use App\Artist;
use App\Region;
use App\Channel;
use App\RegionView;
use App\UserAccess;
use ffmpeg\FFProbe;
use App\PpvPurchase;
use App\Videoartist;
use App\Menu as Menu;
use App\Page as Page;
use App\Plan as Plan;
use App\Role as Role;
use App\Seriesartist;
use App\User as User;
use App\ChannelPayout;
use App\EmailTemplate;
use GuzzleHttp\Client;
use App\Audio as Audio;
use App\Genre as Genre;
use App\ModeratorsRole;
use App\ModeratorsUser;
use App\Partnerpayment;
use App\PlayerAnalytic;
use App\Video as Video;
use App\CurrencySetting;
use App\ModeratorPayout;
use App\Coupon as Coupon;
use App\Series as Series;
use App\Slider as Slider;
use App\Country as Country;
use App\Episode as Episode;
use App\Setting as Setting;
use Illuminate\Support\Str;
use App\PartnerMonetization;
use Illuminate\Http\Request;
use App\Language as Language;
use App\ModeratorsPermission;
use App\Playerui as Playerui;
use App\Subtitle as Subtitle;
use FFMpeg\Format\Video\X264;
use App\MobileApp as MobileApp;
use App\SiteTheme as SiteTheme;
use FFMpeg\Coordinate\Dimension;
use GuzzleHttp\Message\Response;
use App\LiveStream as LiveStream;
use App\PaypalPlan as PaypalPlan;
use Illuminate\Support\Facades\DB;
use App\AudioAlbums as AudioAlbums;
use App\HomeSetting as HomeSetting;
use App\LiveCategory as LiveCategory;
use App\MobileSlider as MobileSlider;
use App\SeriesSeason as SeriesSeason;
use App\ThemeSetting as ThemeSetting;
use Illuminate\Support\Facades\Cache;
use App\Jobs\ConvertVideoForStreaming;
use FFMpeg\Filters\Video\VideoFilters;
use App\AudioCategory as AudioCategory;
use App\SystemSetting as SystemSetting;
use App\VideoCategory as VideoCategory;
use App\VideoLanguage as VideoLanguage;
use App\Http\Requests\StoreVideoRequest;
use App\PaymentSetting as PaymentSetting;
use App\VideosSubtitle as VideosSubtitle;
use Illuminate\Support\Facades\Validator;
use App\MoviesSubtitles as MoviesSubtitles;
use App\VideoCommission as VideoCommission;
use App\VideoResolution as VideoResolution;
use Illuminate\Contracts\Filesystem\Filesystem;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg as FFMpeg;
use Dompdf\Dompdf;
use Dompdf\Options;

class ChannelAnalyticsController extends Controller
{
    public function IndexVideoAnalytics()
    {
        $user_package = User::where("id", 1)->first();
        $package = $user_package->package;
        if (
            (!empty($package) && $package == "Pro") ||
            (!empty($package) && $package == "Business")
        ) {
            $user = Session::get("channel");
            $user_id = $user->id;
            $settings = Setting::first();

 

            $total_content = Channel::join(
                "videos",
                "videos.user_id",
                "=",
                "channels.id"
            )
            ->where("channels.id", $user_id)
            ->where("videos.uploaded_by", "=", 'channel')
                ->get([
                    \DB::raw("videos.*"),

                    \DB::raw("COUNT(*) as count"),
                    \DB::raw("MONTHNAME(videos.created_at) as month_name"),
                    \DB::raw("channels.channel_name as channel_name"),
                    \DB::raw("channels.email as channelemail"),
                ]);
            $total_content = Video::join(
                "channels",
                "channels.id",
                "=",
                "videos.user_id"
            )
                // ->groupBy("videos.id")
                ->where("channels.id", $user_id)
                ->where("videos.uploaded_by", 'Channel')
                ->get([
                    "videos.*",
                    \DB::raw("COUNT(*) as count"),
                    \DB::raw("MONTHNAME(videos.created_at) as month_name"),
                    \DB::raw("channels.channel_name as channel_name"),
                    \DB::raw("channels.email as channelemail"),
                ]);
            $total_contentss = $total_content->groupBy("month_name");

            // dd($total_content);

            $data = [
                "settings" => $settings,
                "total_content" => $total_content,
                "total_video_count" => count($total_content),
                "total_contentss" => $total_contentss,
            ];
            return view("channel.analytics.video_analytics", $data);
        } else {
            return Redirect::to("/blocked");
        }
    }

    public function VideoStartDateAnalytics(Request $request)
    {
        $user_package = User::where("id", 1)->first();
        $package = $user_package->package;
        if (
            (!empty($package) && $package == "Pro") ||
            (!empty($package) && $package == "Business")
        ) {
            $user = Session::get("channel");
            $user_id = $user->id;
            $data = $request->all();

            $start_time = $data["start_time"];
            $end_time = $data["end_time"];
            if (!empty($start_time) && empty($end_time)) {
                $settings = Setting::first();
                $total_content = Video::join(
                    "channels",
                    "channels.id",
                    "=",
                    "videos.user_id"
                )
                    ->whereDate("videos.created_at", ">=", $start_time)
                    ->where("channels.id", $user_id)
                    ->where("videos.uploaded_by", 'Channel')
                    ->get([
                        "videos.*",
                        \DB::raw("COUNT(*) as count"),
                        \DB::raw("MONTHNAME(videos.created_at) as month_name"),
                        \DB::raw("channels.channel_name as channel_name"),
                        \DB::raw("channels.email as channelemail"),
                    ]);
           
                    // echo "<pre>";print_r($total_content);exit;
            } else {    
            }

            $output = "";
            $i = 1;
            if (count($total_content) > 0) {
                $total_row = $total_content->count();
                if (!empty($total_content)) {
                    foreach ($total_content as $key => $row) {
                        $output .=
                            '
              <tr>
              <td>' .
                            $i++ .
                            '</td>
              <td>' .
                            $row->title .
                            '</td>
              <td>' .
                            $row->channelemail .
                            '</td>    
              <td>' .
                            $row->channel_name .
                            '</td>    
              <td>' .
                            $row->views .
                            '</td>    
              </tr>
              ';
                    }
                } else {
                    $output = '
          <tr>
           <td align="center" colspan="5">No Data Found</td>
          </tr>
          ';
                }
                $value = [
                    "table_data" => $output,
                    "total_data" => $total_row,
                    "total_content" => $total_content,
                ];

                return $value;
            }
        } else {
            return Redirect::to("/blocked");
        }
    }

    public function VideoEndDateAnalytics(Request $request)
    {
        $user_package = User::where("id", 1)->first();
        $package = $user_package->package;
        if (
            (!empty($package) && $package == "Pro") ||
            (!empty($package) && $package == "Business")
        ) {
            $user = Session::get("channel");
            $user_id = $user->id;
            $data = $request->all();

            $start_time = $data["start_time"];
            $end_time = $data["end_time"];

            if (!empty($start_time) && !empty($end_time)) {
               
                    $total_content = Video::join(
                        "channels",
                        "channels.id",
                        "=",
                        "videos.user_id"
                    )
                    ->where("channels.id", $user_id)
                    ->where("videos.uploaded_by", 'Channel')
                    ->whereBetween("videos.created_at", [
                        $start_time,
                        $end_time,
                    ])
                    ->get([
                        "videos.*",
                        \DB::raw("COUNT(*) as count"),
                        \DB::raw("MONTHNAME(videos.created_at) as month_name"),
                        \DB::raw("channels.channel_name as channel_name"),
                        \DB::raw("channels.email as channelemail"),
                    ]);
            } else {
                $total_content = [];
            }

            $output = "";
            $i = 1;
            if (count($total_content) > 0) {
                $total_row = $total_content->count();
                if (!empty($total_content)) {
                    foreach ($total_content as $key => $row) {
                        $output .=
                            '
              <tr>
              <td>' .
                            $i++ .
                            '</td>
              <td>' .
                            $row->title .
                            '</td>
              <td>' .
                            $row->channelemail .
                            '</td>    
              <td>' .
                            $row->channel_name .
                            '</td>    
              <td>' .
                            $row->views .
                            '</td>    
              </tr>
              ';
                    }
                } else {
                    $output = '
          <tr>
           <td align="center" colspan="5">No Data Found</td>
          </tr>
          ';
                }
                $value = [
                    "table_data" => $output,
                    "total_data" => $total_row,
                    "total_content" => $total_content,
                ];

                return $value;
            }
        } else {
            return Redirect::to("/blocked");
        }
    }

    public function VideoExportCsv(Request $request)
    {
        $user_package = User::where("id", 1)->first();
        $package = $user_package->package;
        if (
            (!empty($package) && $package == "Pro") ||
            (!empty($package) && $package == "Business")
        ) {
            $user = Session::get("channel");
            $user_id = $user->id;
            $data = $request->all();

            $start_time = $data["start_time"];
            $end_time = $data["end_time"];
            
            if (!empty($start_time) && empty($end_time)) {

                    $total_content = Video::join(
                        "channels",
                        "channels.id",
                        "=",
                        "videos.user_id"
                    )
                    ->where("channels.id", $user_id)
                    ->where("videos.uploaded_by", 'Channel')
                    ->whereDate("videos.created_at", ">=", $start_time)
                    ->get([
                        "videos.*",
                        \DB::raw("COUNT(*) as count"),
                        \DB::raw("MONTHNAME(videos.created_at) as month_name"),
                        \DB::raw("channels.channel_name as channel_name"),
                        \DB::raw("channels.email as channelemail"),
                    ]);
            } elseif (!empty($start_time) && !empty($end_time)) {

                        $total_content = Video::join(
                            "channels",
                            "channels.id",
                            "=",
                            "videos.user_id"
                        )
                        ->where("channels.id", $user_id)
                        ->where("videos.uploaded_by", 'Channel')
                        ->whereBetween("videos.created_at", [
                            $start_time,
                            $end_time,
                        ])
                        ->get([
                            "videos.*",
                            \DB::raw("COUNT(*) as count"),
                            \DB::raw("MONTHNAME(videos.created_at) as month_name"),
                            \DB::raw("channels.channel_name as channel_name"),
                            \DB::raw("channels.email as channelemail"),
                        ]);
            } else {
                $total_content = Video::join(
                    "channels",
                    "channels.id",
                    "=",
                    "videos.user_id"
                )
                ->where("channels.id", $user_id)
                ->where("videos.uploaded_by", 'Channel')
                ->get([
                    "videos.*",
                    \DB::raw("COUNT(*) as count"),
                    \DB::raw("MONTHNAME(videos.created_at) as month_name"),
                    \DB::raw("channels.channel_name as channel_name"),
                    \DB::raw("channels.email as channelemail"),
                ]);
            }
            $file = "ChannelVideoAnalytics.csv";

            $headers = [
                "Content-Type" => "application/vnd.ms-excel; charset=utf-8",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Content-Disposition" => "attachment; filename=download.csv",
                "Expires" => "0",
                "Pragma" => "public",
            ];
            if (!File::exists(public_path() . "/uploads/csv")) {
                File::makeDirectory(public_path() . "/uploads/csv");
            }
            $filename = public_path("/uploads/csv/" . $file);
            $handle = fopen($filename, "w");
            fputcsv($handle, [
                "Video Name",
                "Email",
                "Uploader Name",
                "Total Views",
            ]);
            if (count($total_content) > 0) {
                foreach ($total_content as $each_user) {
                    fputcsv($handle, [
                        $each_user->title,
                        $each_user->channelemail,
                        $each_user->channel_name,
                        $each_user->views,
                    ]);
                }
            }

            fclose($handle);

            \Response::download($filename, "download.csv", $headers);

            return $file;
        } else {
            return Redirect::to("/blocked");
        }
    }

    public function UserPayouts()
    {
        $user_package = User::where("id", 1)->first();
        $package = $user_package->package;
        if (
            (!empty($package) && $package == "Pro") ||
            (!empty($package) && $package == "Business")
        ) {
            $user = Session::get("channel");
            $user_id = $user->id;
            $settings = Setting::first();
            $total_content = Channel::join(
                "channel_payouts",
                "channel_payouts.user_id",
                "=",
                "channels.id"
            )
                // ->groupBy("channels.id")
                ->where("channels.id", 3)
                ->get([
                    // \DB::raw("COUNT(*) as count"),
                    \DB::raw("MONTHNAME(channel_payouts.created_at) as month_name"),
                    \DB::raw("channel_payouts.*"),
                    \DB::raw("channels.channel_name as channel_name"),
                    \DB::raw("channels.email as channelemail"),
                    // \DB::raw("channel_payouts.id as count"),
                ]);


            // dd($total_content);

            $data = [
                "settings" => $settings,
                "total_content" => $total_content,
                "total_video_count" => count($total_content),
            ];
            return view("channel.analytics.payouts_analytics", $data);
        } else {
            return Redirect::to("/blocked");
        }
    }

    public function PayoutsStartDateAnalytics(Request $request)
    {
        $user_package = User::where("id", 1)->first();
        $package = $user_package->package;
        if (
            (!empty($package) && $package == "Pro") ||
            (!empty($package) && $package == "Business")
        ) {
            $user = Session::get("channel");
            $user_id = $user->id;
            $data = $request->all();

            $start_time = $data["start_time"];
            $end_time = $data["end_time"];
            if (!empty($start_time) && empty($end_time)) {
                $settings = Setting::first();
                $total_content = Channel::join(
                    "channel_payouts",
                    "channel_payouts.user_id",
                    "=",
                    "channels.id"
                )
                    ->whereDate("channel_payouts.created_at", ">=", $start_time)
                    ->where("channels.id", $user_id)
                    ->get([
                        // \DB::raw("COUNT(*) as count"),
                        \DB::raw("MONTHNAME(channel_payouts.created_at) as month_name"),
                        \DB::raw("channel_payouts.*"),
                        \DB::raw("channels.channel_name as channel_name"),
                        \DB::raw("channels.email as channelemail"),
                        // \DB::raw("channel_payouts.id as count"),
                    ]);
            } else {
            }

            $output = "";
            $i = 1;
            if (count($total_content) > 0) {
                $total_row = $total_content->count();
                if (!empty($total_content)) {
                    foreach ($total_content as $key => $row) {
                        $output .=
                            '
              <tr>
              <td>' .
                            $i++ .
                            '</td>
              <td>' .
                            $row->channelemail .
                            '</td>
              <td>' .
                            $row->channel_name .
                            '</td>    
              <td>' .
                            $row->commission_paid .
                            '</td>    
              <td>' .
                            $row->commission_pending .
                            '</td> 
              <td>' .
                            $row->payment_type .
                            '</td>
              <td>' .
                            $row->invoice .
                            '</td>    
              </tr>
              ';
                    }
                } else {
                    $output = '
          <tr>
           <td align="center" colspan="5">No Data Found</td>
          </tr>
          ';
                }
                $value = [
                    "table_data" => $output,
                    "total_data" => $total_row,
                    "total_content" => $total_content,
                ];

                return $value;
            }
        } else {
            return Redirect::to("/blocked");
        }
    }

    public function PayoutsEndDateAnalytics(Request $request)
    {
        $user_package = User::where("id", 1)->first();
        $package = $user_package->package;
        if (
            (!empty($package) && $package == "Pro") ||
            (!empty($package) && $package == "Business")
        ) {
            $user = Session::get("channel");
            $user_id = $user->id;
            $data = $request->all();

            $start_time = $data["start_time"];
            $end_time = $data["end_time"];

            if (!empty($start_time) && !empty($end_time)) {


                $total_content = Channel::join(
                    "channel_payouts",
                    "channel_payouts.user_id",
                    "=",
                    "channels.id"
                )
                    ->whereBetween("channel_payouts.created_at", [
                        $start_time,
                        $end_time,
                    ])
                    ->where("channels.id", $user_id)
                    ->get([
                        // \DB::raw("COUNT(*) as count"),
                        \DB::raw("MONTHNAME(channel_payouts.created_at) as month_name"),
                        \DB::raw("channel_payouts.*"),
                        \DB::raw("channels.channel_name as channel_name"),
                        \DB::raw("channels.email as channelemail"),
                        // \DB::raw("channel_payouts.id as count"),
                    ]);

            } else {
                $total_content = [];
            }

            $output = "";
            $i = 1;
            if (count($total_content) > 0) {
                $total_row = $total_content->count();
                if (!empty($total_content)) {
                    foreach ($total_content as $key => $row) {
                        $output .=
                            '
              <tr>
              <td>' .
                            $i++ .
                            '</td>
              <td>' .
                            $row->channelemail .
                            '</td>
              <td>' .
                            $row->channel_name .
                            '</td>    
              <td>' .
                            $row->commission_paid .
                            '</td>    
              <td>' .
                            $row->commission_pending .
                            '</td> 
              <td>' .
                            $row->payment_type .
                            '</td>
              <td>' .
                            $row->invoice .
                            '</td>     
              </tr>
              ';
        }
    } else {
        $output = '
          <tr>
           <td align="center" colspan="5">No Data Found</td>
          </tr>
          ';
                }
                $value = [
                    "table_data" => $output,
                    "total_data" => $total_row,
                    "total_content" => $total_content,
                ];

                return $value;
            }
        } else {
            return Redirect::to("/blocked");
        }
    }

    public function PayoutsExportCsv(Request $request)
    {
        $user_package = User::where("id", 1)->first();
        $package = $user_package->package;
        if (
            (!empty($package) && $package == "Pro") ||
            (!empty($package) && $package == "Business")
        ) {
            $user = Session::get("channel");
            $user_id = $user->id;
            $data = $request->all();
            // dd($data);exit;

            $start_time = $data["start_time"];
            $end_time = $data["end_time"];
            if (!empty($start_time) && empty($end_time)) {
                $total_content = Channel::join(
                    "channel_payouts",
                    "channel_payouts.user_id",
                    "=",
                    "channels.id"
                )
                    ->whereDate("channel_payouts.created_at", ">=", $start_time)
                    ->where("channels.id", $user_id)
                    ->get([
                        // \DB::raw("COUNT(*) as count"),
                        \DB::raw("MONTHNAME(channel_payouts.created_at) as month_name"),
                        \DB::raw("channel_payouts.*"),
                        \DB::raw("channels.channel_name as channel_name"),
                        \DB::raw("channels.email as channelemail"),
                        // \DB::raw("channel_payouts.id as count"),
                    ]);

            } elseif (!empty($start_time) && !empty($end_time)) {
 
                    $total_content = Channel::join(
                        "channel_payouts",
                        "channel_payouts.user_id",
                        "=",
                        "channels.id"
                    )
                        ->where("channels.id", $user_id)
                        ->whereBetween("channel_payouts.created_at", [
                            $start_time,
                            $end_time,
                        ])        
                        ->where("channels.id", $user_id)
                        ->get([
                            // \DB::raw("COUNT(*) as count"),
                            \DB::raw("MONTHNAME(channel_payouts.created_at) as month_name"),
                            \DB::raw("channel_payouts.*"),
                            \DB::raw("channels.channel_name as channel_name"),
                            \DB::raw("channels.email as channelemail"),
                            // \DB::raw("channel_payouts.id as count"),
                        ]);
            } else {
                $total_content = Channel::join(
                    "channel_payouts",
                    "channel_payouts.user_id",
                    "=",
                    "channels.id"
                )
                    ->where("channels.id", $user_id)
                    ->where("channels.id", $user_id)
                    ->get([
                        // \DB::raw("COUNT(*) as count"),
                        \DB::raw("MONTHNAME(channel_payouts.created_at) as month_name"),
                        \DB::raw("channel_payouts.*"),
                        \DB::raw("channels.channel_name as channel_name"),
                        \DB::raw("channels.email as channelemail"),
                        // \DB::raw("channel_payouts.id as count"),
                    ]);
                    
            }
            $file = "CPPPayoutsAnalytics.csv";

            $headers = [
                "Content-Type" => "application/vnd.ms-excel; charset=utf-8",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Content-Disposition" => "attachment; filename=download.csv",
                "Expires" => "0",
                "Pragma" => "public",
            ];
            if (!File::exists(public_path() . "/uploads/csv")) {
                File::makeDirectory(public_path() . "/uploads/csv");
            }
            $filename = public_path("/uploads/csv/" . $file);
            $handle = fopen($filename, "w");
            fputcsv($handle, [
                "Email",
                "Uploader Name",
                "Commission Paid",
                "Commission Pending",
                "Payment Type",
                "Invoice",
            ]);
            if (count($total_content) > 0) {
                foreach ($total_content as $each_user) {
                    fputcsv($handle, [
                        $each_user->channelemail,
                        $each_user->channel_name,
                        $each_user->commission_paid,
                        $each_user->commission_pending,
                        $each_user->payment_type,
                        $each_user->invoice,
                    ]);
                }
            }

            fclose($handle);

            \Response::download($filename, "download.csv", $headers);

            return $file;
        } else {
            return Redirect::to("/blocked");
        }
    }


    public function ChannelViewsRegion()
    {
        // dd('cpp/view_by_region');
        if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
            return redirect('/admin/restrict');
        }
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
        }else if(check_storage_exist() == 0){
            $settings = Setting::first();

            $data = array(
                'settings' => $settings,
            );

            return View::make('admin.expired_storage', $data);
        } else {
            $Country = Region::get();

            $data = [
                "Country" => $Country,
            ];
            return \View::make(
                "channel.analytics.views_by_region",
                $data
            );
        }
    }

    public function ChannelRegionVideos(Request $request)
    {
        if ($request->ajax()) {
            $output = "";
            $query = $request->get("query");

            if ($query != "") {
                $regions = Region::where("id", "=", $query)->first();

                $region_views = RegionView::leftjoin(
                    "videos",
                    "region_views.video_id",
                    "=",
                    "videos.id"
                )
                    ->where("region_views.countryname", "=", $regions->name)
                    ->where("uploaded_by", "Channel")
                    ->get();

                $data = $region_views->groupBy("countryname");
                $data1 = Video::select("videos.*", "region_views.countryname")
                    ->join(
                        "region_views",
                        "region_views.video_id",
                        "=",
                        "videos.id"
                    )
                    ->orderBy("created_at", "desc")
                    ->where("uploaded_by", "Channel")
                    ->where("region_views.countryname", "=", $regions->name)
                    ->paginate(19);
            } else {
            }
            $i = 1;
            $total_row = $data1->count();
            if ($total_row > 0) {
                foreach ($data as $row) {
                    $output .=
                        '
        <tr>
        <td>' .
                        $i++ .
                        '</td>
         <td>' .
                        $row[0]->title .
                        '</td>
         <td>' .
                        $row[0]->countryname .
                        '</td>
         <td>' .
                        $row[0]->user_ip .
                        '</td>
         <td>' .
                        count($row) .
                        '</td>
        </tr>
        ';
                }
            } else {
                $output = '
       <tr>
        <td align="center" colspan="5">No Data Found</td>
       </tr>
       ';
            }
            $data = [
                "table_data" => $output,
                "total_data" => $total_row,
            ];

            echo json_encode($data);
        }
    }

    public function ChannelAllRegionVideos(Request $request)
    {
        if ($request->ajax()) {
            $output = "";
            $query = $request->get("query");

            if ($query != "") {
                $region_views = RegionView::leftjoin(
                    "videos",
                    "region_views.video_id",
                    "=",
                    "videos.id"
                )
                    ->where("uploaded_by", "Channel")
                    ->get();
                $data = $region_views->groupBy("countryname");

                $data1 = Video::select("videos.*", "region_views.countryname")
                    ->join(
                        "region_views",
                        "region_views.video_id",
                        "=",
                        "videos.id"
                    )
                    ->orderBy("created_at", "desc")
                    ->where("uploaded_by", "Channel")
                    ->paginate(9);
            } else {
            }
            $i = 1;
            $total_row = $data1->count();
            if ($total_row > 0) {
                foreach ($data as $key => $row) {
                    $output .=
                        '
        <tr>
        <td>' .
                        $i++ .
                        '</td>
         <td>' .
                        $row[0]->title .
                        '</td>
         <td>' .
                        $row[0]->countryname .
                        '</td>
         <td>' .
                        $row[0]->user_ip .
                        '</td>
         <td>' .
                        count($row) .
                        '</td>
        </tr>
        ';
                }
            } else {
                $output = '
       <tr>
        <td align="center" colspan="5">No Data Found</td>
       </tr>
       ';
            }
            $data = [
                "table_data" => $output,
                "total_data" => $total_row,
            ];

            echo json_encode($data);
        }
    }

    public function ChannelPartnerMonetization(){

        $user = Session::get('channel');
        $user_id = $user->id;

        $users = PartnerMonetization::where('user_id',  $user_id)
        ->paginate(9);

        $data = [
            "users" => $users,
            "currencySymbol" => currency_symbol(),
        ];
        return view("channel.partner_monetization.partner_monetization_analytics",$data);

    }


    public function ChannelPartnerMonetizationHistory(Request $request)
    {
        $user = Session::get('channel');
        $user_id = $user->id;

        $selectedMonth = $request->input('month');

        $monetizationSummaryQuery = PartnerMonetization::where('user_id', $user_id);

        if ($selectedMonth) {
            $monetizationSummaryQuery->whereMonth('payment_date', $selectedMonth);
        }
        $monetizationSummary = $monetizationSummaryQuery
            ->selectRaw('SUM(total_views) as total_views_sum, SUM(partner_commission) as partner_commission_sum')
            ->first();
        
        $paymentDetailsQuery = Partnerpayment::where('user_id', $user_id);

        if ($selectedMonth) {
            $paymentDetailsQuery->whereMonth('payment_date', $selectedMonth);
        }

        $payment_details = $paymentDetailsQuery->orderByDesc('created_at')->paginate(5);

        $totalAmountPaid = $payment_details->getCollection()->sum('paid_amount');
        $latestPayment = $payment_details->first();

        $data = [
            "monetizationSummary" => $monetizationSummary,
            "totalAmountPaid" => $totalAmountPaid,
            "payment_details" => $latestPayment,
            "payment_histories" => $payment_details,
            "currencySymbol" => currency_symbol(),
        ];

        if ($request->ajax()) {
            return response()->json([
                'totalAmountPaid' => $totalAmountPaid,
                'paymentBalanceAmount' => $latestPayment ? $latestPayment->balance_amount : 0,
            ]);
        }

        return view("channel.partner_monetization.partner_monetization_history", $data);
    }

    

    public function PartnerAnalyticsCSV(Request $request)
    {
        $user_package = User::where("id", 1)->first(); 
        $package = $user_package->package;
        
        if ((!empty($package) && $package == "Pro") || (!empty($package) && $package == "Business")) {
            $user = Session::get("channel");
            $user_id = $user->id;
            $data = $request->all();
    
            $start_time = $data["start_time"];
            $end_time = $data["end_time"];
           
            if (!empty($start_time) && empty($end_time)) {
                $total_content = PartnerMonetization::whereDate("created_at", ">=", $start_time)
                    ->where("user_id", $user_id)
                    ->get();
            } elseif (!empty($start_time) && !empty($end_time)) {
                $total_content = PartnerMonetization::whereBetween("created_at", [$start_time, $end_time])
                    ->where("user_id", $user_id)
                    ->get();
            } else {
                $total_content = PartnerMonetization::where("user_id", $user_id)
                    ->get();
            }
    
            $file = "PartnerMonetizationPayouts.csv";
            $headers = [
                "Content-Type" => "application/vnd.ms-excel; charset=utf-8",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Content-Disposition" => "attachment; filename=download.csv",
                "Expires" => "0",
                "Pragma" => "public",
            ];
    
            if (!File::exists(public_path() . "/uploads/csv")) {
                File::makeDirectory(public_path() . "/uploads/csv");
            }
    
            $filename = public_path("/uploads/csv/" . $file);
            $handle = fopen($filename, "w");
            $currencySymbol = currency_symbol();
            fputcsv($handle, [
                "Content Title",
                "Content Type",
                "Views",
                "Monetized Amount",
                "Admin Commission",
                "Partner Commission"
            ]);
    
            foreach ($total_content as $record) {
                fputcsv($handle, [
                    $record->title,
                    $record->type,
                    $record->total_views,
                    $record->monetization_amount . $currencySymbol,
                    $record->admin_commission . $currencySymbol,
                    $record->partner_commission . $currencySymbol,
                  
                ]);
            }
    
            fclose($handle);
    
            \Response::download($filename, "download.csv", $headers);
    
            return $file;
        } else {
            return Redirect::to("/blocked");
        }
    }



    public function PartnerHistoryCSV(Request $request)
    {
        $user_package = User::where("id", 1)->first(); 
        $package = $user_package->package;
        
        if ((!empty($package) && $package == "Pro") || (!empty($package) && $package == "Business")) {
            $user = Session::get("channel");
            $user_id = $user->id;
            $data = $request->all();
    
            $start_time = $data["start_time"];
            $end_time = $data["end_time"];
           
            if (!empty($start_time) && empty($end_time)) {
                $total_content = Partnerpayment::whereDate("payment_date", ">=", $start_time)
                    ->where("user_id", $user_id)
                    ->get();
            } elseif (!empty($start_time) && !empty($end_time)) {
                $total_content = Partnerpayment::whereBetween("payment_date", [$start_time, $end_time])
                    ->where("user_id", $user_id)
                    ->get();
            } else {
                $total_content = Partnerpayment::where("user_id", $user_id)
                    ->get();
            }
    
            $file = "PartnerMonetizationPayouts.csv";
            $headers = [
                "Content-Type" => "application/vnd.ms-excel; charset=utf-8",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Content-Disposition" => "attachment; filename=download.csv",
                "Expires" => "0",
                "Pragma" => "public",
            ];
    
            if (!File::exists(public_path() . "/uploads/csv")) {
                File::makeDirectory(public_path() . "/uploads/csv");
            }
    
            $filename = public_path("/uploads/csv/" . $file);
            $handle = fopen($filename, "w");
            $currencySymbol = currency_symbol();

            fputcsv($handle, [
                "Month/Year",
                "Paid Amount",
                "Balance Amount",
                "Transaction ID",
                "Payment Method",
            ]);
    
            foreach ($total_content as $record) {
                fputcsv($handle, [
                    $record->payment_date,                  
                    $record->paid_amount . $currencySymbol,                  
                    $record->balance_amount . $currencySymbol,                  
                    $record->transaction_id,                  
                    $record->payment_method == 0 ? 'Manual Payment' : 'Payment Gateway'                  
                ]);
            }
    
            fclose($handle);
    
            \Response::download($filename, "download.csv", $headers);
    
            return $file;
        } else {
            return Redirect::to("/blocked");
        }
    }

    public function PartnerInvoice($id)
    {
        $partnerpayment = Partnerpayment::find($id);
        if (!$partnerpayment) {
            return response()->json(['error' => 'Payment not found'], 404);
        }
        $settings = Setting::first();

        $currencySymbol = currency_symbol();

        $logoPath = public_path('uploads/settings/' . $settings->logo);
        if (file_exists($logoPath)) {
            $logoData = base64_encode(file_get_contents($logoPath));
            $logoSrc = 'data:image/' . pathinfo($logoPath, PATHINFO_EXTENSION) . ';base64,' . $logoData;
        } else {
            $logoSrc = ''; // Fallback if logo file does not exist
        }


        $html = view('channel.partner_monetization.partner_monetization_invoice', compact('partnerpayment','settings','logoSrc','currencySymbol'))->render();
    
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
  
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
    
        $pdfContent = $dompdf->output();
   
        $base64pdf = base64_encode($pdfContent);
        return response($base64pdf, 200)
               ->header('Content-Type', 'text/plain')
               ->header('Content-Disposition', 'attachment; filename="partnerpayment_' . date('d-m-y') . '.pdf"');
    }

}

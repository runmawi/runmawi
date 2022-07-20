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

class CPPAnalyticsController extends Controller
{
    public function IndexVideoAnalytics()
    {
        $user_package = User::where("id", 1)->first();
        $package = $user_package->package;
        if (
            (!empty($package) && $package == "Pro") ||
            (!empty($package) && $package == "Business")
        ) {
            $user = Session::get("user");
            $user_id = $user->id;
            $settings = Setting::first();
            $total_content = ModeratorsUser::join(
                "videos",
                "videos.user_id",
                "=",
                "moderators_users.id"
            )
                ->groupBy("videos.id")
                ->where("moderators_users.id", $user_id)
                ->get([
                    \DB::raw("COUNT(*) as count"),
                    \DB::raw("MONTHNAME(videos.created_at) as month_name"),
                    \DB::raw("videos.*"),
                    \DB::raw("moderators_users.username as cppusername"),
                    \DB::raw("moderators_users.email as cppemail"),
                ]);

            $total_content = Video::join(
                "moderators_users",
                "moderators_users.id",
                "=",
                "videos.user_id"
            )
                ->groupBy("videos.id")
                ->where("moderators_users.id", $user_id)
                ->get([
                    "videos.*",
                    \DB::raw("COUNT(*) as count"),
                    \DB::raw("MONTHNAME(videos.created_at) as month_name"),
                    \DB::raw("MONTHNAME(videos.created_at) as month_name"),
                    \DB::raw("moderators_users.username as cppusername"),
                    \DB::raw("moderators_users.email as cppemail"),
                ]);
            $total_contentss = $total_content->groupBy("month_name");

            // dd($total_content);

            $data = [
                "settings" => $settings,
                "total_content" => $total_content,
                "total_video_count" => count($total_content),
                "total_contentss" => $total_contentss,
            ];
            return view("moderator.cpp.analytics.video_analytics", $data);
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
            $user = Session::get("user");
            $user_id = $user->id;
            $data = $request->all();

            $start_time = $data["start_time"];
            $end_time = $data["end_time"];
            if (!empty($start_time) && empty($end_time)) {
                $settings = Setting::first();
                $total_content = ModeratorsUser::join(
                    "videos",
                    "videos.user_id",
                    "=",
                    "moderators_users.id"
                )
                    ->where("moderators_users.id", $user_id)
                    ->whereDate("videos.created_at", ">=", $start_time)
                    ->groupBy("videos.id")
                    ->get([
                        \DB::raw("COUNT(*) as count"),
                        \DB::raw("MONTHNAME(videos.created_at) as month_name"),
                        \DB::raw("videos.*"),
                        \DB::raw("moderators_users.username as cppusername"),
                        \DB::raw("moderators_users.email as cppemail"),
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
                            $row->title .
                            '</td>
              <td>' .
                            $row->cppemail .
                            '</td>    
              <td>' .
                            $row->cppusername .
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
            $user = Session::get("user");
            $user_id = $user->id;
            $data = $request->all();

            $start_time = $data["start_time"];
            $end_time = $data["end_time"];

            if (!empty($start_time) && !empty($end_time)) {
                $total_content = ModeratorsUser::join(
                    "videos",
                    "videos.user_id",
                    "=",
                    "moderators_users.id"
                )
                    ->where("moderators_users.id", $user_id)
                    ->whereBetween("videos.created_at", [
                        $start_time,
                        $end_time,
                    ])
                    ->groupBy("videos.id")
                    ->get([
                        \DB::raw("COUNT(*) as count"),
                        \DB::raw("MONTHNAME(videos.created_at) as month_name"),
                        \DB::raw("videos.*"),
                        \DB::raw("moderators_users.username as cppusername"),
                        \DB::raw("moderators_users.email as cppemail"),
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
                            $row->cppemail .
                            '</td>    
              <td>' .
                            $row->cppusername .
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
            $user = Session::get("user");
            $user_id = $user->id;
            $data = $request->all();
            // dd($data);exit;
            // if(!empty($data['start_time']) && empty($data['end_time']
            // || empty($data['start_time']) && !empty($data['end_time'])
            // || !empty($data['start_time']) && !empty($data['end_time'])) ){
            $start_time = $data["start_time"];
            $end_time = $data["end_time"];
            // }
            if (!empty($start_time) && empty($end_time)) {
                $total_content = ModeratorsUser::join(
                    "videos",
                    "videos.user_id",
                    "=",
                    "moderators_users.id"
                )
                    ->whereDate("videos.created_at", ">=", $start_time)
                    ->where("moderators_users.id", $user_id)
                    ->groupBy("videos.id")
                    ->get([
                        \DB::raw("COUNT(*) as count"),
                        \DB::raw("MONTHNAME(videos.created_at) as month_name"),
                        \DB::raw("videos.*"),
                        \DB::raw("moderators_users.username as cppusername"),
                        \DB::raw("moderators_users.email as cppemail"),
                    ]);
            } elseif (!empty($start_time) && !empty($end_time)) {
                $total_content = ModeratorsUser::join(
                    "videos",
                    "videos.user_id",
                    "=",
                    "moderators_users.id"
                )
                    ->where("moderators_users.id", $user_id)
                    ->whereBetween("videos.created_at", [
                        $start_time,
                        $end_time,
                    ])
                    ->groupBy("videos.id")
                    ->get([
                        \DB::raw("COUNT(*) as count"),
                        \DB::raw("MONTHNAME(videos.created_at) as month_name"),
                        \DB::raw("videos.*"),
                        \DB::raw("moderators_users.username as cppusername"),
                        \DB::raw("moderators_users.email as cppemail"),
                    ]);
            } else {
                $total_content = ModeratorsUser::join(
                    "videos",
                    "videos.user_id",
                    "=",
                    "moderators_users.id"
                )
                    ->where("moderators_users.id", $user_id)
                    ->groupBy("videos.id")
                    ->get([
                        \DB::raw("COUNT(*) as count"),
                        \DB::raw("MONTHNAME(videos.created_at) as month_name"),
                        \DB::raw("videos.*"),
                        \DB::raw("moderators_users.username as cppusername"),
                        \DB::raw("moderators_users.email as cppemail"),
                    ]);
            }
            //  $file = 'CPPRevenue_' . rand(10, 100000) . '.csv';
            $file = "CPPVideoAnalytics.csv";

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
                        $each_user->cppemail,
                        $each_user->cppusername,
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
}

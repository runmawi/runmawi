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
use App\SeriesGenre;
use Intervention\Image\Facades\Image;
use Intervention\Image\Filters\DemoFilter;
use App\RelatedVideo;
use App\LanguageVideo;
use App\Blockvideo;
use App\ReelsVideo;
use App\CategoryVideo;
use App\PlayerSeekTimeAnalytic;
use App\VideoPlaylist;
use App\Audioartist;
use App\AudioLanguage;
use App\CategoryAudio;
use App\BlockAudio;
use App\LiveLanguage;
use App\CategoryLive;
use App\SeriesSubtitle;
use App\SeriesLanguage;
use App\SeriesCategory;
use App\Channel;
use App\ChannelRoles;

class AdminChannelRolesController extends Controller
{


    public function ChannelRoles(Request $request)
    {
        if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
            return redirect('/admin/restrict');
        }
        $data = Session::all();
        if (!empty($data["password_hash"])) {
            $package_id = auth()->user()->id;
            $user_package = DB::table("users")
                ->where("id", $package_id)
                ->first();
            $package = $user_package->package;
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
                if (
                    $package == "Pro" ||
                    $package == "Business" ||
                    ($package == "" && Auth::User()->role == "admin")
                ) {
                    $permission = ModeratorsPermission::all();
                    $Channels = Channel::all();
                    $data = [
                        "permission" => $permission,
                        "Channels" => $Channels,
                    ];

                    return view("admin.channel_roles.Index", $data);
                } elseif ($package == "Basic") {
                    return view("blocked");
                }
            }
        } else {
            $system_settings = SystemSetting::first();
            $user = User::where("id", "=", 1)->first();
            return view("auth.login", compact("system_settings", "user"));
        }
    }

    public function RolesPermissionStore(Request $request)
    {
        $input = $request->all();
      
        $request->session()->flash("notification", "Successfully Registered Role");

        $user_permission = $request->user_permission;
        if (!empty($user_permission)) {
            $permission = implode(",", $user_permission);
        } else {
            $permission = "";
        }
        
        $data = Session::all();
        if (!empty($data["password_hash"])) {
            $package_id = auth()->user()->id;
            $user_package = DB::table("users")
                ->where("id", $package_id)
                ->first();
            $package = $user_package->package;
            if (
                $package == "Pro" ||
                $package == "Business" ||
                ($package == "" && Auth::User()->role == "admin")
            ) {
                $user_roles = new ChannelRoles();
                $user_roles->role_name = $input["role_name"];
                $user_roles->user_permission = $permission;
                $user_roles->save();

                $channelroles = ChannelRoles::all();
                $permission = ModeratorsPermission::all();
                $data = [
                    "roles" => $channelroles,
                    "permission" => $permission,
                ];
                return redirect()
                    ->back()
                    ->with("message", "Successfully Roles saved!.");

            } elseif ($package == "Basic") {
                return view("blocked");
            }
        } else {
            $system_settings = SystemSetting::first();
            $user = User::where("id", "=", 1)->first();
            return view("auth.login", compact("system_settings", "user"));
        }
    }


    
    public function AllChannelRoles()
    {
        if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
            return redirect('/admin/restrict');
        }
        $data = Session::all();
        if (!empty($data["password_hash"])) {
            $package_id = auth()->user()->id;
            $user_package = DB::table("users")
                ->where("id", $package_id)
                ->first();
            $package = $user_package->package;
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
                if (
                    $package == "Pro" ||
                    $package == "Business" ||
                    ($package == "" && Auth::User()->role == "admin")
                ) {
                    $roles = ChannelRoles::paginate(10);
                    $channelroles = ChannelRoles::all();
                    $permission = ModeratorsPermission::all();
                    $data = [
                        "roles" => $roles,
                        "permission" => $permission,
                    ];

                    return view("admin.channel_roles.ViewRole", $data);
                } elseif ($package == "Basic") {
                    return view("blocked");
                }
            }
        } else {
            $system_settings = SystemSetting::first();
            $user = User::where("id", "=", 1)->first();
            return view("auth.login", compact("system_settings", "user"));
        }
    }

    
    public function RoleEdit($id)
    {
        if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
            return redirect('/admin/restrict');
        }
        $data = Session::all();
        if (!empty($data["password_hash"])) {
            $package_id = auth()->user()->id;
            $user_package = DB::table("users")
                ->where("id", $package_id)
                ->first();
            $package = $user_package->package;
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
                if (
                    $package == "Pro" ||
                    $package == "Business" ||
                    ($package == "" && Auth::User()->role == "admin")
                ) {
                    $channelroles = ChannelRoles::find($id);
                    $permission = $channelroles["user_permission"];
                    $role_permission = explode(",", $permission);


                    $permission = ModeratorsPermission::all();
                    // dd($role_permission);
                    $data = [
                        "roles" => $channelroles,
                        "permission" => $permission,
                        "channel_roles" => $role_permission,
                        "channelspermission" => $role_permission,
                    ];

                    return view("admin.channel_roles.Edit", $data);
                } elseif ($package == "Basic") {
                    return view("blocked");
                }
            }
        } else {
            $system_settings = SystemSetting::first();
            $user = User::where("id", "=", 1)->first();
            return view("auth.login", compact("system_settings", "user"));
        }
    }


    public function RoleUpdate(Request $request)
    {
        $data = Session::all();
        if (!empty($data["password_hash"])) {
            $package_id = auth()->user()->id;
            $user_package = DB::table("users")
                ->where("id", $package_id)
                ->first();
            $package = $user_package->package;
            if (
                $package == "Pro" ||
                $package == "Business" ||
                ($package == "" && Auth::User()->role == "admin")
            ) {
                $data = $request->all();

                $id = $data["id"];
                $user_permission = $data["user_permission"];
                $permission = implode(",", $user_permission);

                $ChannelRoles = ChannelRoles::find($id);
                $ChannelRoles["role_name"] = $data["username"];
                $ChannelRoles["user_permission"] = $permission;

                $ChannelRoles->save();
                return back()->with("message", "Successfully Roles Updated!.");

                return \Redirect::back();
            } elseif ($package == "Basic") {
                return view("blocked");
            }
        } else {
            $system_settings = SystemSetting::first();
            $user = User::where("id", "=", 1)->first();
            return view("auth.login", compact("system_settings", "user"));
        }
    }

    public function RoleDelete($id)
    {
        $data = Session::all();
        if (!empty($data["password_hash"])) {
            $package_id = auth()->user()->id;
            $user_package = DB::table("users")
                ->where("id", $package_id)
                ->first();
            $package = $user_package->package;
            if (
                $package == "Pro" ||
                $package == "Business" ||
                ($package == "" && Auth::User()->role == "admin")
            ) {
                ChannelRoles::destroy($id);

                return \Redirect::back();
            } elseif ($package == "Basic") {
                return view("blocked");
            }
        } else {
            $system_settings = SystemSetting::first();
            $user = User::where("id", "=", 1)->first();
            return view("auth.login", compact("system_settings", "user"));
        }
    }
}
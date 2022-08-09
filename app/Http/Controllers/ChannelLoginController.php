<?php
namespace App\Http\Controllers;

use \App\User as User;
use \Redirect as Redirect;
use Illuminate\Http\Request;
use \App\MobileApp as MobileApp;
use \App\MobileSlider as MobileSlider;
use App\RecentView as RecentView;
use App\Setting as Setting;
use URL;
use Auth;
use Hash;
use Illuminate\Support\Facades\Cache;
use Image;
use View;
use Flash;
use App\Subscription as Subscription;
use \App\Video as Video;
use App\VideoCategory as VideoCategory;
use \App\PpvVideo as PpvVideo;
use \App\CountryCode as CountryCode;
use App;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\SystemSetting as SystemSetting;
use DateTime;
use Session;
use DB;
use Mail;
use App\EmailTemplate;
use App\UserLogs;
use App\Region;
use App\RegionView;
use App\City;
use App\State;
use Illuminate\Support\Str;
use App\LoggedDevice;
use Jenssegers\Agent\Agent;
use App\ApprovalMailDevice;
use App\Language;
use App\Multiprofile;
use App\HomeSetting;
use App\WelcomeScreen;
use App\SubscriptionPlan;
use App\Channel;
use Theme;

class ChannelLoginController extends Controller
{

    public function index(Request $request)
    {
        $settings = Setting::first();
        $data = array(
            'settings' => $settings,
        );
        return \View::make('channel.login', $data);
    }

    public function register(Request $request)
    {
        $settings = Setting::first();
        $data = array(
            'settings' => $settings,
        );
        return \View::make('channel.register', $data);
    }
    public function Store(Request $request)
    {
        $input = $request->all();
        $request->validate(['email_id' => 'required|email|unique:channels,email', 'password' => 'min:6', ]);
        // dd($input);
        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;
        if (!empty($package) && $package == "Pro" || !empty($package) && $package == "Business")
        {

            $intro_video = (isset($input['intro_video'])) ? $input['intro_video'] : '';

            $logopath = URL::to("/public/uploads/channel/");
            $path = public_path() . "/uploads/channel/";

            if ($intro_video != '')
            {
                //code for remove old file
                if ($intro_video != '' && $intro_video != null)
                {
                    $file_old = $path . $intro_video;
                    if (file_exists($file_old))
                    {
                        unlink($file_old);
                    }
                }
                //upload new file
                $randval = Str::random(16);
                $file = $intro_video;
                $intro_video_ext = $randval . '.' . $request->file('intro_video')
                    ->extension();
                $file->move($path, $intro_video_ext);

                $intro_video = URL::to('/') . '/public/uploads/channel/' . $intro_video_ext;

            }
            else
            {
                $intro_video = null;
            }
            // dd($intro_video);
            $string = Str::random(60);
            $channel = new Channel;
            $channel->channel_name = $request->channel_name;
            $channel->email = $request->email_id;
            $channel->password = Hash::make($request->password);
            $channel->mobile_number = $request->mobile_number;
            $channel->ccode = $request->ccode;
            $channel->activation_code = $string;
            $channel->intro_video = $intro_video;
            $channel->status = 0;
            $channel->save();

            $template = EmailTemplate::where('id', '=', 13)->first();
            $heading = $template->heading;
            $settings = Setting::first();
            Mail::send('emails.channel_verify', array(
                'activation_code' => $string,
                'website_name' => $settings->website_name,

            ) , function ($message) use ($request, $template, $heading)
            {
                $message->from(AdminMail() , GetWebsiteName());
                $message->to($request->email_id, $request->channel_name)
                    ->subject($heading . $request->channel_name);
            });
            return redirect('/channel/verify-request')
                ->with('message', 'Successfully Users saved!.');

        }
        else
        {

            return Redirect::to('/blocked');
        }
    }

    public function VerifyRequest(Request $request)
    {

        return Theme::view('verify_request');

    }

    public function Verify($activation_code)
    {
        $user = Channel::where('activation_code', '=', $activation_code)->first();
        $fetch_user = Channel::where('activation_code', '=', $activation_code)->first();
        if ($user)
        {
            // $user = Channel::where('activation_code', '=', $activation_code)->first();
            //   $mobile = $fetch_user->mobile;
            session()->put('register.email', $fetch_user->email);
            return redirect('/channel/login')
                ->with('message', 'You have successfully verified your account. Please login If You Approved below.');
        }
        else
        {
            return redirect('/channel/login')
                ->with('message', 'Invalid Activation.');
        }

    }

    public function Login(Request $request)
    {
        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;
        $input = $request->all();
        $channel = Channel::where('email', '=', $input['email'])->first();

        if (!empty($package) && $package == "Pro" || !empty($package) && $package == "Business")
        {

            if (Hash::check($input['password'], $channel->password))
            {
                // dd($channel_password);
                $channel = Channel::where('email', '=', $input['email'])->first();
                if (!empty($channel) && $channel->status == 0 || $channel->status == 1)
                {
                    $settings = Setting::first();
                    $data = array(
                        'settings' => $settings,
                        'channel' => $channel,
                    );
                    Session::put('channel', $channel);
                    return \View::make('channel.dashboard', $data);
                }
                elseif (!empty($channel) && $channel->status == 0)
                {
                    return redirect('/channel/login')
                        ->with('message', 'Please Wait For Apporval');
                }
                else
                {
                    return redirect('/channel/login')
                        ->with('message', 'Miss Match Login Credentials');
                }
            }
            else
            {
                return redirect('/channel/login')
                    ->with('message', 'Miss Match Login Credentials');
            }

        }
    }
    public function Home(Request $request)
    {
        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;
        if (!empty($package) && $package == "Pro" || !empty($package) && $package == "Business")
        {

            return \View::make('channel.dashboard');
        }
    }
    public function Logout(Request $request)
    {

        $data = \Session::all();
        unset($data['channel']['password']);
        \Session::flush();
        return redirect('/channel/login')->with('message', 'Logged Out Succefully');
    }

    public function IndexDashboard()
    {
        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;
        if (!empty($package) && $package == "Pro" || !empty($package) && $package == "Business")
        {

            try
            {

                $data = \Session::get('channel');

                $channel = Channel::where('email', '=', $data['email'])->first();

                if (!empty($channel))
                {

                    $settings = Setting::first();
                    $data = array(
                        'settings' => $settings,
                        'channel' => $channel,
                    );
                    Session::put('channel', $channel);
                    return \View::make('channel.dashboard', $data);

                }
            }
            catch(\Exception $e)
            {

                return Redirect::to('/blocked');
            }

        }
    }

    public function ChannelLogout(Request $request)
    {
        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;
        if (!empty($package) && $package == "Pro" || !empty($package) && $package == "Business")
        {
            request()->session()
                ->regenerate(true);
            request()
                ->session()
                ->flush();
            $settings = Setting::first();
            $system_settings = SystemSetting::first();
            $user = User::where('id', '=', 1)->first();
            return redirect('/cpp/login')
                ->with('message', 'Successfully Logged Out.');

            return view('moderator.login', compact('system_settings', 'user', 'settings'));
            // return \View::make('auth.login');
            
        }
        else
        {
            return Redirect::to('/blocked');
        }
    }
}


<?php
namespace App\Http\Controllers;

use App\ModeratorsPermission;
use App\ModeratorsRole;
use App\ModeratorsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
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
use \App\MobileApp as MobileApp;
use \App\MobileSlider as MobileSlider;
use App\ThemeSetting as ThemeSetting;
use App\SiteTheme as SiteTheme;
use App\Page as Page;
use App\LiveStream as LiveStream;
use App\LiveCategory as LiveCategory;
use \App\User as User;
use Auth;
use App\Role as Role;
use App\Playerui as Playerui;
use App\Plan as Plan;
use App\PaypalPlan as PaypalPlan;
use App\Coupon as Coupon;
use App\Series as Series;
use \App\Genre as Genre;
use App\Episode as Episode;
use \App\SeriesSeason as SeriesSeason;
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
use App\Settings;
use App\Subscription;
use App\PpvVideo;
use App\RecentView;
use Session;
use Redirect;
use Theme;
use App\CPPSignupMenu;

class ModeratorsLoginController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->Theme = HomeSetting::pluck('theme_choosen')
            ->first();
        Theme::uses($this->Theme);
    }

    public function index()
    {
        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;
        if (!empty($package) && $package == "Pro" || !empty($package) && $package == "Business")
        {
            $settings = Setting::first();
            $user = User::where('id', '=', 1)->first();
            $CPPSignupMenu = CPPSignupMenu::first();
            return Theme::view('moderator.register', compact('settings', 'user', 'CPPSignupMenu'));
        }
        else
        {
            return Redirect::to('/blocked');
        }
    }

    public function Signin()
    {
        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;
        if (!empty($package) && $package == "Pro" || !empty($package) && $package == "Business")
        {
            $settings = Setting::first();
            $system_settings = SystemSetting::first();
            $user = User::where('id', '=', 1)->first();
            return Theme::view('moderator.login', compact('system_settings', 'user', 'settings'));
        }
        else
        {
            return Redirect::to('/blocked');
        }
    }

    public function Login(Request $request)
    {
        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;
        if (!empty($package) && $package == "Pro" || !empty($package) && $package == "Business")
        {
            $input = $request->all();

            $userexits = ModeratorsUser::where('email', '=', $input['email'])->first();

            if (!empty($userexits))
            {

                if ($userexits->status == 1)
                {

                    $user = ModeratorsUser::where('status', '=', 1)->where('email', '=', $input['email'])->where('password', '=', $input['password'])->first();
                    Session::put('user', $user);

                    if (!empty($user))
                    {
                        $id = $user->id;
                        $userrolepermissiom = DB::table('user_accesses')->select('user_accesses.permissions_id', 'moderators_permissions.name', 'moderators_permissions.url')
                            ->join('moderators_permissions', 'moderators_permissions.id', '=', 'user_accesses.permissions_id')
                            ->where(['user_id' => $id])->get();
                        Session::put('userrolepermissiom ', $userrolepermissiom);

                        $settings = Setting::first();

                        $ppv_price = $settings->ppv_price;

                        $Revenue = DB::table('ppv_purchases')->join('videos', 'videos.id', '=', 'ppv_purchases.video_id')
                            ->select('videos.*')
                            ->where('videos.user_id', '=', $id)->get();

                        $Revenue_count = DB::table('ppv_purchases')->join('videos', 'videos.id', '=', 'ppv_purchases.video_id')
                            ->select('videos.*')
                            ->where('videos.user_id', '=', $id)->count();
                        $total_Revenue = $Revenue_count * $ppv_price . '$';

                        $total_video_uploaded = Video::where('user_id', '=', $id)->count();
                        $total_subscription = Subscription::where('stripe_status', '=', 'active')->count();

                        $total_videos = Video::where('active', '=', 1)->count();

                        $total_ppvvideos = PpvVideo::where('active', '=', 1)->count();

                        $total_recent_subscription = Subscription::orderBy('created_at', 'DESC')->whereDate('created_at', '>', \Carbon\Carbon::now()
                            ->today())
                            ->count();
                        $top_rated_videos = Video::where("rating", ">", 7)->get();
                        $recent_views = RecentView::limit(50)->orderBy('id', 'DESC')
                            ->get();
                        $recent_view = $recent_views->unique('video_id');

                        $page = 'admin-dashboard';
                        $data = array(
                            'userrolepermissiom' => $userrolepermissiom,
                            'total_Revenue' => $total_Revenue,
                            'total_video_uploaded' => $total_video_uploaded,
                            'settings' => $settings,
                            'total_subscription' => $total_subscription,
                            'total_recent_subscription' => $total_recent_subscription,
                            'total_videos' => $total_videos,
                            'top_rated_videos' => $top_rated_videos,
                            'recent_views' => $recent_view,
                            'page' => $page,
                            'total_ppvvideos' => $total_ppvvideos,
                            'video_category' => VideoCategory::where('uploaded_by','CPP')->get(),
                        );

                        return \View::make('moderator.dashboard', $data);
                    }
                    else
                    {
                        return redirect('/cpp/login')->with('message', 'Miss Match Login Credentials');
                    }
                }
                elseif ($userexits->status == 0)
                {
                    return redirect('/cpp/login')
                        ->with('message', 'Your Request have been Pending');
                }
                else
                {
                    return redirect('/cpp/login')
                        ->with('message', 'Your Request have been rejected');
                }
            }
            else
            {
                return redirect('/cpp/login')
                    ->with('message', 'Please Register And Login');
            }
        }
        else
        {
            return Redirect::to('/blocked');
        }

    }

    public function Store(Request $request)
    {
        $input = $request->all();

        $request->validate([
                    'email_id' => 'required|email|unique:moderators_users,email',
                    'password' => 'min:6',
                ]);

        $enable_moderator_payment = SiteTheme::first()->pluck('enable_moderator_payment')->first();
        // dd($enable_moderator_payment);
        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;

        if (!empty($package) && $package == "Pro" || !empty($package) && $package == "Business")
        {
            $string = Str::random(60);
            $moderatorsuser = new ModeratorsUser;
            $moderatorsuser->username = $request->username;
            $moderatorsuser->slug = str_replace(" ", "-", $request->username);
            $moderatorsuser->email = $request->email_id;
            $moderatorsuser->mobile_number = $request->mobile_number;
            $moderatorsuser->password = $request->password;
            $password = Hash::make($request->password);
            $moderatorsuser->hashedpassword = $password;
            $moderatorsuser->user_role = 3;
            $moderatorsuser->user_permission = "1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19";
            $moderatorsuser->confirm_password = $request->password;
            $moderatorsuser->ccode = $request->ccode;
            $moderatorsuser->description = $request->description;
            $moderatorsuser->activation_code = $string;
            $moderatorsuser->status = 0;
            $logopath = URL::to('/public/uploads/moderator_albums/');
            $path = public_path() . '/uploads/moderator_albums/';
            $picture = $request['picture'];
            $intro_video = (isset($request['intro_video'])) ? $request['intro_video'] : '';

            if ($picture != '')
            {
                //code for remove old file
                if ($picture != '' && $picture != null)
                {
                    $file_old = $path . $picture;
                    if (file_exists($file_old))
                    {
                        unemail($file_old);
                    }
                }
                //upload new file
                $file = $picture;
                $moderatorsuser->picture = $logopath . '/' . $file->getClientOriginalName();
                $file->move($path, $moderatorsuser->picture);
            }

            $logopath = URL::to('/public/uploads/moderator/');
            $path = public_path() . '/uploads/moderator/';

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
                $intro_video_ext = $randval . '.' . $request->file('intro_video')->extension();
                $file->move($path, $intro_video_ext);

                $moderatorsuser->intro_video = URL::to('/') . '/public/uploads/moderator/' . $intro_video_ext;
            }
            else
            {
                $moderatorsuser->intro_video = null;
            }

            $moderatorsuser->picture = $request->picture == "" ? "Default.png" : $file->getClientOriginalName() ;
            $moderatorsuser->save();

            $user_data = User::where('email', $request->email_id)->first();

            if(empty($user_data)){
                $user = new User();
                $user->package = 'CPP';
                $user->unhashed_password = $request->password;
                $user->name = $request->username;
                $user->role = 'admin';
                $user->username =  $request->username;
                $user->email = $request->email_id;
                $user->password = Hash::make($request->password);
                $user->active = 1;
                $user->save();
            }else{

            }
            
            $user_id = $moderatorsuser->id;
            $str = "1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19";
            $userrolepermissiom = explode(",", $str);
            foreach ($userrolepermissiom as $key => $value)
            {
                $userrolepermissiom = new UserAccess;
                $userrolepermissiom->user_id = $user_id;
                // $userrolepermissiom->role_id = $request->user_role;
                $userrolepermissiom->permissions_id = $value;
                $userrolepermissiom->save();
            }

            $request->session()->put('email_id', $request->email_id);
            $email = $request->session()->get('email_id');
            
                    // Note: While CPP Signup Email - Template for CPP registered user and Admin
            try
            {
                $data = array(
                    'email_subject' => EmailTemplate::where('id', 43)->pluck('heading')->first() ,
                );

                Mail::send('emails.partner_welcome', array('Partner_Name' => $request->username,'website_name' => GetWebsiteName() ,) ,
                    function ($message) use ($data, $request){
                        $message->from(AdminMail() , GetWebsiteName());
                        $message->to($request->email_id, $request->username)->subject($data['email_subject']);
                    });

                $email_log = 'Mail Sent Successfully from Welcome on Partner’s Registration';
                $email_template = "43";
                $user_id = $moderatorsuser->id;

                Email_sent_log($user_id, $email_log, $email_template);
            }
            catch(\Exception $e)
            {
                $email_log = $e->getMessage();
                $email_template = "43";
                $user_id = $moderatorsuser->id;

                Email_notsent_log($user_id, $email_log, $email_template);
            }


                    // Note: While CPP Signup Email - Template for CPP registered user and Admin
            try
            {
                $data = array(
                    'email_subject' => EmailTemplate::where('id', 43)->pluck('heading')->first() ,
                );

                Mail::send('emails.partner_welcome', array('Partner_Name' => $request->username,'website_name' => GetWebsiteName() ,) ,
                    function ($message) use ($data, $request){
                        $message->from(AdminMail() , GetWebsiteName());
                        $message->to(AdminMail())->subject($data['email_subject']);
                    });

                $email_log = 'Mail Sent Successfully from Welcome on Partner’s Registration';
                $email_template = "43";
                $user_id = $moderatorsuser->id;

                Email_sent_log($user_id, $email_log, $email_template);
            }
            catch(\Exception $e)
            {
                $email_log = $e->getMessage();
                $email_template = "43";
                $user_id = $moderatorsuser->id;

                Email_notsent_log($user_id, $email_log, $email_template);
            }

                // Note : using Reject Template for verify , so comment this line  

            // $template = EmailTemplate::where('id', '=', 13)->first();
            // $heading  = $template->heading;
            // $settings = Setting::first();

            // Mail::send('emails.cpp_verify', array(
            //     /* 'activation_code', $user->activation_code,*/
            //     'activation_code' => $string,
            //     'website_name' => $settings->website_name,
            // ), 
            // function ($message) use ($request, $template, $heading){
            //     $message->from(AdminMail() , GetWebsiteName());
            //     $message->to($request->email_id, $request->username)->subject($heading . $request->username);
            // });

            // \Mail::send('emails.verify', array('activation_code' => $string, 'website_name' => $settings->website_name),
            //  function($message)  use ($request) {
            //       $message->to($request->email_id, $request->username)->subject('Verify your email address');
            //    });
            if($enable_moderator_payment == 1){

                return redirect('/cpp-subscriptions-plans')
                ->with('message', 'You have successfully registered. Please Choose Plan to Subscribe.');
            }else{
                return redirect('/cpp/login')
                ->with('message', 'You have successfully registered. Please login If You Approved below.');
            }
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
        $user = ModeratorsUser::where('activation_code', '=', $activation_code)->first();
        $fetch_user = ModeratorsUser::where('activation_code', '=', $activation_code)->first();
        if ($user)
        {
            // print_r($activation_code);
            // exit;
            $user = User::where('activation_code', $activation_code)->update(['activation_code' => null, 'active' => 1]);

            $mobile = $fetch_user->mobile;
            session()
                ->put('register.email', $fetch_user->email);
            return redirect('/cpp/login')
                ->with('message', 'You have successfully verified your account. Please login If You Approved below.');
        }
        else
        {
            // print_r($activation_code);
            // exit;
            return redirect('/cpp/login')
                ->with('message', 'You have successfully verified your account. Please login If You Approved below.');

            //  return redirect('/cpp/signin')->with('message', 'Invalid Activation.');
            
        }

    }
    public function IndexDashboard()
    {
        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;
        if (!empty($package) && $package == "Pro" || !empty($package) && $package == "Business")
        {
            $user = Session::get('user');
            $id = $user->id;

            $userrolepermissiom = DB::table('user_accesses')->select('user_accesses.permissions_id', 'moderators_permissions.name', 'moderators_permissions.url')
                ->join('moderators_permissions', 'moderators_permissions.id', '=', 'user_accesses.permissions_id')
                ->where(['user_id' => $id])->get();

            $settings = Setting::first();

            $ppv_price = $settings->ppv_price;

            $Revenue = DB::table('ppv_purchases')->join('videos', 'videos.id', '=', 'ppv_purchases.video_id')
                ->select('videos.*')
                ->where('videos.user_id', '=', $id)->get();

            $Revenue_count = DB::table('ppv_purchases')->join('videos', 'videos.id', '=', 'ppv_purchases.video_id')
                ->select('videos.*')
                ->where('videos.user_id', '=', $id)->count();
            $total_Revenue = $Revenue_count * $ppv_price . '$';

            $total_video_uploaded = Video::where('user_id', '=', $id)->count();
            $total_subscription = Subscription::where('stripe_status', '=', 'active')->count();

            $total_videos = Video::where('active', '=', 1)->count();

            $total_ppvvideos = PpvVideo::where('active', '=', 1)->count();

            $total_recent_subscription = Subscription::orderBy('created_at', 'DESC')->whereDate('created_at', '>', \Carbon\Carbon::now()
                ->today())
                ->count();

            $top_rated_videos = Video::where("rating", ">", 7)->get();
            $recent_views = RecentView::limit(10)->orderBy('id', 'DESC')
                ->get();
            $recent_view = $recent_views->unique('video_id');

            $page = 'admin-dashboard';
            $data = array(
                'userrolepermissiom' => $userrolepermissiom,
                'total_Revenue' => $total_Revenue,
                'total_video_uploaded' => $total_video_uploaded,
                'settings' => $settings,
                'total_subscription' => $total_subscription,
                'total_recent_subscription' => $total_recent_subscription,
                'total_videos' => $total_videos,
                'top_rated_videos' => $top_rated_videos,
                'recent_views' => $recent_view,
                'page' => $page,
                'total_ppvvideos' => $total_ppvvideos,
                'video_category' => VideoCategory::where('uploaded_by','CPP')->get(),
            );

            return \View::make('moderator.dashboard', $data);
        }
        else
        {
            return Redirect::to('/blocked');
        }

    }

    public function logout(Request $request)
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
        }
        else
        {
            return Redirect::to('/blocked');
        }
    }

    public function PasswordReset()
    {
        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;
        if (!empty($package) && $package == "Pro" || !empty($package) && $package == "Business")
        {
            $settings = Setting::first();
            $user = User::where('id', '=', 1)->first();

            return Theme::view('moderator.reset_password', compact('settings', 'user'));
        }
        else
        {
            return Redirect::to('/blocked');
        }
    }

    
    public function VerifyPasswordReset($email,$token)
    {
        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;
        if (!empty($package) && $package == "Pro" || !empty($package) && $package == "Business")
        {
            $settings = Setting::first();
            $user = User::where('id', '=', 1)->first();

            $decrypt_email = \Crypt::decryptString($email);

            return Theme::view('moderator.verify_reset_password', compact('settings', 'user','decrypt_email','token'));
        }
        else
        {
            return Redirect::to('/blocked');
        }
    }

    
    public function VerifyResetPassword(Request $request)
    {

      $data = $request->all();
      $encrypted = \Crypt::encryptString($request->email);
      $decrypt= \Crypt::decryptString($encrypted);

      $ModeratorsUser = ModeratorsUser::where('email', $request->email)->first();

    if(!empty($ModeratorsUser)){
      $token = Str::random(60);
      $ModeratorsUser = ModeratorsUser::where('email', $request->email)
      ->update(['token' => $token]);

      $verification_code = URL::to('cpp/password/reset').'/'.$encrypted.'/'.$token;

                try
                {
                    $data = array(
                        'email_subject' => EmailTemplate::where('id', 41)->pluck('heading')->first() ,
                    );

                    Mail::send('emails.resetpassword', array('website_name' => GetWebsiteName() ,'verification_code' => $verification_code,) ,
                        function ($message) use ($data, $request){
                            $message->from(AdminMail() , GetWebsiteName());
                            $message->to($request->email)->subject($data['email_subject']);
                        });

                    $email_log = 'Mail Sent Successfully For Reset Password';
                    $email_template = "11";
                    $user_id = $ModeratorsUser->id;

                    Email_sent_log($user_id, $email_log, $email_template);
                }
                catch(\Exception $e)
                {
                    $ModeratorsUser = ModeratorsUser::where('email', $request->email)->first();

                    $email_log = $e->getMessage();
                    $email_template = "11";
                    $user_id = $ModeratorsUser->id;

                    Email_notsent_log($user_id, $email_log, $email_template);
                }

            return Redirect::back()->with('message', 'We have emailed your password reset link!');
        }else{
            return Redirect::back()->with('message', 'Please Enter Valid Email Address');

        }

  }

    public function ResetPassword(Request $request)
    {
      $data = $request->all();
      $user = ModeratorsUser::where('email', $data['email'])->where('token',$request->verify_token)->first();

      if(!empty($user)){

        $user->password = $data['password'];
        $user->hashedpassword = Hash::make($data['password']);
        $user->save();

        $adminuser = User::where('email', $data['email'])->first();
        
        if(!empty($adminuser)){
            $adminuser->password = Hash::make($data['password']);
            $adminuser->unhashed_password = $data['password'];
            $adminuser->save();
        }
  
        return redirect('/cpp/login')
        ->with('message', 'Youre Password Changed Successfully');
        

      }else{

        return Redirect::back()->with('message', 'Please Enter Valid Token to Verify');

      }

  }

}


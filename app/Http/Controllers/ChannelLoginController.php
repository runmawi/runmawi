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
use Illuminate\Support\Facades\Crypt;
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
use App\VideoCommission;
use Theme;
use Intervention\Image\Facades\Image;
use Intervention\Image\Filters\DemoFilter;

class ChannelLoginController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth');
        $settings = Setting::first();
        $this->videos_per_page = $settings->videos_per_page;

        $this->Theme = HomeSetting::pluck('theme_choosen')
            ->first();
        Theme::uses($this->Theme);
    }

    
    public function index(Request $request)
    {
        $settings = Setting::first();
        $data = array(
            'settings' => $settings,
        );
        return Theme::view('Channel.login', $data);

        // return \View::make('channel.login', $data);
    }

    public function register(Request $request)
    {
        $settings = Setting::first();
        $data = array(
            'settings' => $settings,
        );
        return Theme::view('Channel.register', $data);

        // return \View::make('channel.register', $data);
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
            $image = (isset($input['image'])) ? $input['image'] : '';


            $logopath = URL::to("/public/uploads/channel/");
            $path = public_path() . "/uploads/channel/";


            if ($image != '')
            {
                //code for remove old file
                if ($image != '' && $image != null)
                {
                    $file_old = $path . $image;
                    if (file_exists($file_old))
                    {
                        unlink($file_old);
                    }
                }
                //upload new file
                $randval = Str::random(16);
                $file = $image;
                $image_ext = $randval . '.' . $request->file('image')
                    ->extension();
                $file->move($path, $image_ext);

                $image = URL::to('/') . '/public/uploads/channel/' . $image_ext;

            }
            else
            {
                $image = "default_image.jpg";
            }

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
            $channel->channel_slug = str_replace(' ', '_', $request->channel_name);
            $channel->email = $request->email_id;
            $channel->password = Hash::make($request->password);
            $channel->unhased_password = $request->password;
            $channel->mobile_number = $request->mobile_number;
            $channel->ccode = $request->ccode;
            $channel->activation_code = $string;
            $channel->intro_video = $intro_video;
            $channel->channel_image = $image;
            $channel->status = 0;
            $channel->save();

            $user_data = User::where('email', $request->email_id)->first();

            if(empty($user_data)){

                $user = new User();
                $user->package = 'Channel';
                $user->unhashed_password = $request->password;
                $user->name = $request->channel_name;
                $user->role = 'admin';
                $user->username = $request->channel_name;
                $user->email = $request->email_id;
                $user->password = Hash::make($request->password);
                $user->active = 1;
                $user->save();

            }
            $template = EmailTemplate::where('id', '=', 13)->first();
            $heading = $template->heading;
            $settings = Setting::first();
            // Mail::send('emails.channel_verify', array(
            //     'activation_code' => $string,
            //     'website_name' => $settings->website_name,

            // ) , function ($message) use ($request, $template, $heading)
            // {
            //     $message->from(AdminMail() , GetWebsiteName());
            //     $message->to($request->email_id, $request->channel_name)
            //         ->subject($heading . $request->channel_name);
            // });
            // return redirect('/channel/verify-request')
            //     ->with('message', 'Successfully Users saved!.');
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
                $user_id = $user->id;

                Email_sent_log($user_id, $email_log, $email_template);
            }
            catch(\Exception $e)
            {
                $email_log = $e->getMessage();
                $email_template = "43";
                $user_id = 1;

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
                $user_id = 1;

                Email_sent_log($user_id, $email_log, $email_template);
            }
            catch(\Exception $e)
            {
                $email_log = $e->getMessage();
                $email_template = "43";
                $user_id = $user->id;

                Email_notsent_log($user_id, $email_log, $email_template);
            }

            return redirect('/channel/login')
                ->with('message', 'You have successfully registered. Please login If You Approved below.');

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

            $user = Channel::where('email', '=', $input['email'])
                ->where('unhased_password', '=', $input['password'])
                ->first();

            // if (Hash::check($input['password'], $channel->password))

            if(!empty($user) )

            {
                $channel = Channel::where('email', '=', $input['email'])->first();

                if (!empty($channel) && $channel->status == 1 || $channel->status == 1)
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
                        ->with('message', 'Login Credentials Do Not Match With Something on Our Records. 
Please recheck the credentials before you try again!');
                }
            }
            else
            {
                
                return redirect('/channel/login')
                    ->with('message', 'Login Credentials Do Not Match With Something on Our Records. 
Please recheck the credentials before you try again!');
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

            // return view('moderator.login', compact('system_settings', 'user', 'settings'));
            // return \View::make('auth.login');
            
        }
        else
        {
            return Redirect::to('/blocked');
        }
    }

    public function PendingUsers()
    {
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
        } else {
            // $videos = LiveStream::orderBy('created_at', 'DESC')->paginate(9);
            $users = Channel::where("status", "=", 0)
                ->orderBy("created_at", "DESC")
                ->paginate(9);
            // dd($videos);
            $data = [
                "users" => $users,
            ];

            return view("channel.userapproval", $data);
        }
    }

    public function ChannelUsersApproval($id)
    {
        if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
            return redirect('/admin/restrict');
        }
        $user = User::where("id", 1)->first();
        $duedate = $user->package_ends;

        $current_date = date("Y-m-d");
        if ($current_date > $duedate) {
            $client = new Client();
            $url = "https://flicknexs.com/userapi/allplans";
            $params = [ "userid" => 0,];

            $headers = ["api-key" => "k3Hy5qr73QhXrmHLXhpEh6CQ",];

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
        }
        else {
           
            $users = Channel::findOrFail($id);
            $users->status = 1 ;
            $users->save();

            try {

                Mail::send('emails.channel_approved', array('users'=> $users, ),
                function($message) use ($users) {
                    $message->from(AdminMail(),GetWebsiteName());
                    $message->to($users->email)->subject("Approved You're Channel");
                });

            } catch (\Throwable $th) {

                return redirect()->route('ChannelPendingUsers')->with('error',$th->getMessage()  );
            }
          
            return \Redirect::back()->with( "success", "The channel user has been approved !!");
        }
    }

    public function ChannelUsersReject($id)
    {
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
        } else {
            $users = Channel::findOrFail($id);
            $users->status = 2 ;
            $users->save();

            try {
                    Mail::send('emails.channel_rejected', array('users'=> $users ),function($message) use ($users) {
                        $message->from(AdminMail(),GetWebsiteName());
                        $message->to($users->email)->subject("Rejected You're Channel");
                    });
                
            } catch (\Throwable $th) {


                return redirect()->route('ChannelPendingUsers')->with('error',$th->getMessage()  );
            }
        
            return \Redirect::back()->with( "success", "The channel user has been Rejected !!");
        }
    }

    public function ViewChannelMembers()
    {
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
        } else {
            $users = Channel::orderBy("created_at", "DESC")
                ->paginate(9);
            $data = [
                "users" => $users,
            ];

            return View("channel.viewchannelmembers", $data);
        }
    }


    public function Commission(Request $request)
    {
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
        } else {
            $commission = VideoCommission::where('type','Channel')->first();

            $data = [
                "commission" => $commission,
            ];

            return view("channel.commission", $data);

        }
    }

    public function AddCommission(Request $request)
    {
        $data = $request->all();
        // echo "<pre>";
        // print_r($data);exit();
        $id = $data['id'];
        if(!empty($id)){
        $commission = VideoCommission::find($id);
        // $commission = new VideoCommission();
        $commission->type = "Channel";
        $commission->percentage = $data["percentage"];
        $commission->user_id = Auth::user()->id;
        $commission->save();
        }else{
        $commission = new VideoCommission();
        $commission->type = "Channel";
        $commission->percentage = $data["percentage"];
        $commission->user_id = Auth::user()->id;
        $commission->save();
        }
        return \Redirect::back()->with(
            "message",
            "Successfully Updated Percentage!"
        );
    }

    public function PasswordRset()
    {
        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;
        if (!empty($package) && $package == "Pro" || !empty($package) && $package == "Business")
        {
            $settings = Setting::first();
            $user = User::where('id', '=', 1)->first();

            return Theme::view('Channel.reset_password', compact('settings', 'user'));
        }
        else
        {
            return Redirect::to('/blocked');
        }
    }

    
    public function ResetPassword(Request $request)
    {
      $data = $request->all();
      $user = Channel::where('email', $data['email'])->first();
      if(!empty($user)){

        $user->unhased_password = $data['password'];
        $user->password = Hash::make($data['password']);
        $user->save();

        $adminuser = User::where('email', $data['email'])->first();
        if(!empty($adminuser)){
            $adminuser->password = Hash::make($data['password']);
            $adminuser->unhashed_password = $data['password'];
            $adminuser->save();
        }
        return redirect('/channel/login')
        ->with('message', 'Youre Password Changed Successfully');

      }else{

        return Redirect::back()->with('message', 'Please Enter Valid Email');

      }

  }

  public function ChannelMyProfile()
  {
      $data = Session::all();

      $id = $data['channel']->id;
    //   dd($id);

      $Channel = Channel::where('id',$id)->first();

      $data = [
          "channel" => $Channel,
      ];
      // dd($data['user']);
      return view("channel.myprofile",$data);

  }

  public function ChannelUpdateMyProfile(Request $request)
  {
      $Session = Session::all();
      $data = $request->all();
      
      $id = $data['id'];

      
      $channel = Channel::where('id',$id)->first();
      // dd($data);
      if(!empty($data['channel_name'])){
          $channel_name = $data['channel_name'];
      }else{
          $channel_name = $channel->channel_name;
      } 

      if(!empty($data['email'])){
          $email = $data['email'];
      }else{
          $email = $channel->email;
      }  
      if(!empty($data['mobile_number'])){
          $mobile_number = $data['mobile_number'];
      }else{
          $mobile_number = $channel->mobile_number;
      }  


      $image = (isset($data['picture'])) ? $data['picture'] : '';
      $channel_logo = (isset($data['channel_logo'])) ? $data['channel_logo'] : '';
      $channel_banner = (isset($data['channel_banner'])) ? $data['channel_banner'] : '';

      $logopath = URL::to("/public/uploads/channel/");
      $path = public_path() . "/uploads/channel/";

      $image_path = public_path() . "/uploads/channel/";
      
      if($image != '') {   
        if($image != ''  && $image != null){
             $file_old = $image_path.$image;
            if (file_exists($file_old)){
             unlink($file_old);
            }
        }
          $file = $image;

          if(compress_image_enable() == 1){
            
              $filename  = time().'.'.compress_image_format();
              $PC_image     =  'channel_'.$filename ;

              Image::make($file)->save(base_path().'/public/uploads/channel/'.$PC_image,compress_image_resolution() );
              
             $image = URL::to('/') . '/public/uploads/channel/' . $PC_image;
          
            }else{

              $filename  = time().'.'.$file->getClientOriginalExtension();
              $PC_image     =  'channel_'.$filename ;
              Image::make($file)->save(base_path().'/public/uploads/channel/'.$PC_image );
              $image = URL::to('/') . '/public/uploads/channel/' . $PC_image;

          }
        
        }elseif(!empty($channel->channel_image)){
            $image = $channel->channel_image;
        }
        else{
            $image = null;
        } 
   

    //   dd( $image);
      if ($channel_logo != '')
      {
          //code for remove old file
          if ($channel_logo != '' && $channel_logo != null)
          {
              $file_old = $path . $channel_logo;
              if (file_exists($file_old))
              {
                  unlink($file_old);
              }
          }
          //upload new file
          $randval = Str::random(16);
          $file = $channel_logo;

          if(compress_image_enable() == 1){
            
            $filename  = time().'.'.compress_image_format();
            $channel_logo_ext     =  'channel_logo_'.$filename ;

            Image::make($file)->save(base_path().'/public/uploads/channel/'.$channel_logo_ext,compress_image_resolution() );
            
            $channel_logo = URL::to('/') . '/public/uploads/channel/' . $channel_logo_ext;
        
          }else{

            $filename  = time().'.'.$file->getClientOriginalExtension();
            $channel_logo_ext     =  'channel_logo_'.$filename ;
            Image::make($file)->save(base_path().'/public/uploads/channel/'.$channel_logo_ext );
            $channel_logo = URL::to('/') . '/public/uploads/channel/' . $channel_logo_ext;

        }
      

      }elseif(!empty($channel->channel_logo)){
        $channel_logo = $channel->channel_logo;
      }
      else
      {
          $channel_logo = null;
      }
      
      if ($channel_banner != '')
      {
          //code for remove old file
          if ($channel_banner != '' && $channel_banner != null)
          {
              $file_old = $path . $channel_banner;
              if (file_exists($file_old))
              {
                  unlink($file_old);
              }
          }
          //upload new file
          $randval = Str::random(16);
          $file = $channel_banner;
          if(compress_image_enable() == 1){
            
            $filename  = time().'.'.compress_image_format();
            $channel_banner_ext     =  'channel_banner_'.$filename ;

            Image::make($file)->save(base_path().'/public/uploads/channel/'.$channel_banner_ext,compress_image_resolution() );
            
            $channel_banner = URL::to('/') . '/public/uploads/channel/' . $channel_banner_ext;
        
          }else{

            $filename  = time().'.'.$file->getClientOriginalExtension();
            $channel_banner_ext     =  'channel_banner_'.$filename ;
            Image::make($file)->save(base_path().'/public/uploads/channel/'.$channel_banner_ext );
            $channel_banner = URL::to('/') . '/public/uploads/channel/' . $channel_banner_ext;

        }
      
          $channel_banner = URL::to('/') . '/public/uploads/channel/' . $channel_banner_ext;

      }elseif(!empty($channel->channel_banner)){
        $channel_banner = $channel->channel_banner;
      }
      else
      {
          $channel_banner = null;
      }

      $channel->channel_name = $channel_name;
      $channel->email = $email;
      $channel->mobile_number = $mobile_number;
      $channel->channel_image = $image;
      $channel->channel_logo = $channel_logo;
      $channel->channel_banner = $channel_banner;
      $channel->channel_slug = str_replace(' ', '_', $request->channel_name);
      $channel->save();

      return \Redirect::back()->with('message','Update User Profile');

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
          // dd($decrypt_email);

          return Theme::view('Channel.verify_reset_password', compact('settings', 'user','decrypt_email','token'));
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

    $Channel = Channel::where('email', $request->email)->first();

  if(!empty($Channel)){
    $token = Str::random(60);
    $Channel = Channel::where('email', $request->email)
    ->update(['token' => $token]);

    $verification_code = URL::to('channel/password/reset').'/'.$encrypted.'/'.$token;

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
                  $user_id = $Channel->id;

                  Email_sent_log($user_id, $email_log, $email_template);
              }
              catch(\Exception $e)
              {
                  $Channel = Channel::where('email', $request->email)->first();

                  $email_log = $e->getMessage();
                  $email_template = "11";
                  $user_id = $Channel->id;

                  Email_notsent_log($user_id, $email_log, $email_template);
              }

          return Redirect::back()->with('message', 'We have emailed your password reset link!');
      }else{
          return Redirect::back()->with('message', 'Please Enter Valid Email Address');

      }

}

public function destroy($id)
{
    $Channel = Channel::find($id);

    Channel::destroy($id);
    return Redirect::back()->with('message', 'Deleted Channel Partner');
  
}


}


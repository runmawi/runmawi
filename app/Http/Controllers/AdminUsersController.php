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
use App\Devices;
use App\CurrencySetting;
use App\PpvPurchase;
use Theme;
use Response;
use File;
use GuzzleHttp\Client;

class AdminUsersController extends Controller
{

    public function index(Request $request)
    {
        $user =  User::where('id',1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');
        if ($current_date > $duedate)
        {
            $client = new Client();
            $url = "https://flicknexs.com/userapi/allplans";
            $params = [
                'userid' => 0,
            ];
    
            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ'
            ];
            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify'  => false,
            ]);
    
            $responseBody = json_decode($response->getBody());
           $settings = Setting::first();
           $data = array(
            'settings' => $settings,
            'responseBody' => $responseBody,
    );
            return View::make('admin.expired_dashboard', $data);
        }else{
        $user = $request->user();
        //dd($user->hasRole('admin','editor')); // and so on
        // dd($user->can('permission-slug'));
        //dd($user->hasRole('developer')); //will return true, if user has role
        //dd($user->givePermissionsTo('create-tasks'));// will return permission, if not null
        //dd($user->can('create-tasks')); // will return true, if user has permission
        //exit;
        $total_subscription = Subscription::where('stripe_status', '=', 'active')->count();

        $total_videos = Video::where('active', '=', 1)->count();

        $total_ppvvideos = PpvVideo::where('active', '=', 1)->count();

        $total_user_subscription = User::where('role', '=', 'subscriber')->count();

        $total_recent_subscription = Subscription::orderBy('created_at', 'DESC')->whereDate('created_at', '>=', \Carbon\Carbon::now()
            ->today())
            ->count();
        $top_rated_videos = Video::where("rating", ">", 7)->get();

        //    $total_revenew = Subscription::all();
        $total_revenew = Subscription::sum('price');

        $search_value = '';

        if (!empty($search_value)):
            $users = User::where('username', 'LIKE', '%' . $search_value . '%')->orWhere('email', 'LIKE', '%' . $search_value . '%')->orderBy('created_at', 'desc')
                ->take(9000)
                ->get();
        else:
            // $users = User::orderBy('created_at', 'desc')->take(9000)->get();
            $allUsers = User::orderBy('created_at', 'desc')->paginate(10);
        endif;
        // print_r($total_revenew);
        // exit();
        $data = array(
            'users' => $allUsers,
            'total_subscription' => $total_subscription,
            'total_revenew' => $total_revenew,
            'total_recent_subscription' => $total_recent_subscription,
            'total_videos' => $total_videos,
            'top_rated_videos' => $top_rated_videos,
        );
        return \View::make('admin.users.index', $data);
    }
    }

    public function Usersearch(Request $request)
    {
        if ($request->ajax())
        {

            $output = '';
            $query = $request->get('query');

            $slug = URL::to('admin/user/view');
            $edit = URL::to('admin/user/edit');
            $delete = URL::to('admin/user/delete');
            if ($query != '')
            {
                $data = User::where('username', 'LIKE', '%' . $query . '%')->orWhere('mobile', 'LIKE', '%' . $query . '%')->orWhere('email', 'LIKE', '%' . $query . '%')->orderBy('created_at', 'desc')
                    ->paginate(10);
            }
            else 
            {
                return Redirect::to('admin/users');
            }
            $total_row = $data->count();
            if ($total_row > 0)
            {
                foreach ($data as $row)
                {
                    if (!empty($row->username))
                    {
                        $username = $row->username;
                    }
                    else
                    {
                        $username = $row->username ;
                    }
                    if (!empty($row->avatar))
                    {
                        $image_url = URL::to('/') . '/public/uploads/avatars/' . $row->avatar;
                    }
                    else
                    {
                        $image_url = URL::to('/') . '/public/uploads/avatars/' . $row->avatar;
                    }
                    if ($row->active == 1)
                    {
                        $active = "Active";
                        $class = "bg-success";
                    }
                    elseif ($row->active == 0)
                    {
                        $active = "Deactive";
                        $class = "bg-danger";
                    }
                    $output .= '
        <tr>
        <td><img class="img-fluid avatar-50" alt="author-profile" src="' . $image_url . '" alt="" /></td>
        <td>' . $username . '</td>
        <td>' . $row->mobile . '</td>
        <td>' . $username . '</td>
        <td>' . $row->email . '</td>
         <td>' . $row->role . '</td>
        <td class="' . $class . '" style="font-weight:bold;">' . $active . '</td>
         <td> ' . "<a class='iq-bg-warning' data-toggle='tooltip' data-placement='top' title='' data-original-title='View' href=' $slug/$row->id'><i class='lar la-eye'></i>
        </a>" . '
        ' . "<a class='iq-bg-success' data-toggle='tooltip' data-placement='top' title='' data-original-title='Edit' href=' $edit/$row->id'><i class='ri-pencil-line'></i>
        </a>" . '
        ' . "<a class='iq-bg-danger' data-toggle='tooltip' data-placement='top' title='' data-original-title='Delete'  href=' $delete/$row->id'><i class='ri-delete-bin-line'></i>
        </a>" . '
        </td>
        </tr>
        ';
                }
            }
            else
            {
                $output = '
       <tr>
        <td align="center" colspan="5">No Data Found</td>
       </tr>
       ';
            }
            $data = array(
                'table_data' => $output,
                'total_data' => $total_row
            );

            echo json_encode($data);
        }
    }

    public function create()
    {
        $user =  User::where('id',1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');
        if ($current_date > $duedate)
        {
            $client = new Client();
            $url = "https://flicknexs.com/userapi/allplans";
            $params = [
                'userid' => 0,
            ];
    
            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ'
            ];
            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify'  => false,
            ]);
    
            $responseBody = json_decode($response->getBody());
           $settings = Setting::first();
           $data = array(
            'settings' => $settings,
            'responseBody' => $responseBody,
    );
            return View::make('admin.expired_dashboard', $data);
        }else{
        $data = array(
            'post_route' => URL::to('admin/user/store') ,
            'admin_user' => Auth::user() ,
            'button_text' => 'Create User',
        );

        return \View::make('admin.users.create_edit', $data);
    }
    }
    public function view($id)
    {

        $user = User::find($id);

        $current_plan = [];

        $current_plan = User::select(['subscriptions.*', 'plans.plans_name', 'plans.billing_interval', 'plans.days'])->join('subscriptions', 'subscriptions.user_id', '=', 'users.id')
            ->join('plans', 'subscriptions.stripe_plan', '=', 'plans.plan_id')
            ->where('role', '=', 'subscriber')
            ->where('users.id', '=', $user->id)
            ->get();
        $country_name = CountryCode::where('phonecode', '=', $user->ccode)
            ->get();
        //    echo "<pre>";
        // print_r($current_plan);
        // exit();
        $data = array(

            'current_plan' => $current_plan,
            'country_name' => $country_name,
            'users' => $user
        );
        return \View::make('admin.users.view', $data);
    }
    public function store(Request $request)
    {

        $validatedData = $request->validate(['email' => 'required|max:255', 'username' => 'required|max:255', ]);

        $input = $request->all();
       

        if(empty($input['active'])){
            $active = 0 ;
        }
        else{
            $active = 1 ;
        }
        
        $user = Auth::user();

        $path = public_path() . '/uploads/avatars/';

        $input['email'] = $request['email'];

        $path = public_path() . '/uploads/avatars/';

        $logo = $request['avatar'];



        if ($logo != ''  && $logo != null)
        {
            //code for remove old file
            if ($logo != '' && $logo != null)
            {
                $file_old = $path . $logo;
                if (file_exists($file_old))
                {
                    unlink($file_old);
                }
            }
            //upload new file
            $file = $logo;
            $input['avatar'] = $file->getClientOriginalName();
            $user->avatar = $file->getClientOriginalName();

            $file->move($path, $input['avatar']);

        }
        $string = Str::random(60);

        $password = Hash::make($request['passwords']);

        DB::table('users')->insert(
            [
                'username' => $request['username'],
                'email' => $request['email'],
                'mobile' => $request['mobile'],
                'ccode' => $request['ccode'],
                'role' => $request['role'],
                'activation_code' => $string,
                'active' => $active,
                //  terms = $request['terms'],
                'password' => $password,
        ]);



        $settings = Setting::first();

        if ($input['role'] == "subscriber")
        {
            \Mail::send('emails.verify', array(
                'activation_code' => $string,
                'website_name' => $settings->website_name
            ) , function ($message) use ($request, $input)
            {
                $message->to($request->email, $request->name)
                    ->subject('Verify your email address');
            });
        }
        else
        {

        }

        //  $moderatorsuser->description = $request->description;
        //     if ( $input['role'] =='subadmin' ){
        //             $request['role'] ='admin';
        //             $request['sub_admin'] = 1;
        //             $request['stripe_active'] = 1;
        //     } else {
        //          $request['role'] = $request['role'];
        //     }
        if (empty($request['email']))
        {
            return Redirect::to('admin/user/create')->with(array(
                'note' => 'Successfully Created New User',
                'note_type' => 'failed'
            ));

        }
        else
        {

            //  $request['email'] = $request['email'];
            
        }

        $input['terms'] = 0;

        //           if($request['passwords'] == ''){
        

        //             // echo "<pre>";
        //             // print_r($password);
        //             // exit();
        //             $request['password'] = $password;
        //         } else{
        //             // echo "<pre>";
        //             // print_r('$input');
        //             // exit();
        //             $password = Hash::make($request['passwords']);
        //             $request['password'] = $password; }
        // //
        //         $user = User::create($input);
        // Welcome on sub-user registration
        $template = EmailTemplate::where('id', '=', 10)->first();
        $heading = $template->heading;
        //   echo "<pre>";
        // print_r($heading);
        // exit();
        $settings = Setting::find(1);

        if ($input['role'] == "subscriber")
        {

            Mail::send('emails.sub_user', array(
                /* 'activation_code', $user->activation_code,*/
                'name' => $request['username'],
                'email' => $request['email'],
                'password' => $request['passwords'],

            ) , function ($message) use ($request, $user, $heading, $settings)
            {
                $message->from(AdminMail() , $settings->website_name);
                $message->to($request['email'], $request['username'])->subject($heading . $request['username']);
            });

        }
        else
        {

        }

        return Redirect::to('admin/users')->with(array(
            'message' => 'Successfully Created New User',
            'note_type' => 'success'
        ));
    }

    public function update(Request $request)
    {

        $input = $request->all();

        $validatedData = $request->validate(['email' => 'required|max:255', 'id' => 'required|max:255', 'username' => 'required|max:255', ]);

        $id = $request['id'];
        $user = User::find($id);
        $input = $request->all();

        $path = public_path() . '/uploads/avatars/';
        $input['email'] = $request['email'];
        $logo = $request['avatar'];

        if ($logo != '')
        {
            //code for remove old file
            if ($logo != '' && $logo != null)
            {
                $file_old = $path . $logo;
                if (file_exists($file_old))
                {
                    unlink($file_old);
                }
            }
            //upload new file
            $file = $logo;
            $input['avatar'] = $file->getClientOriginalName();
            $file->move($path, $input['avatar']);

        }

        if ($input['role'] == 'subadmin')
        {
            $request['role'] = 'admin';
            $request['sub_admin'] = 1;
            $request['stripe_active'] = 1;
        }
        else
        {
            $request['role'] = $request['role'];
        }

        if (empty($request['email']))
        {
            return Redirect::to('admin/user/create')->with(array(
                'note' => 'Successfully Created New User',
                'note_type' => 'failed'
            ));
        }
        else
        {
            $request['email'] = $request['email'];
        }

        $input['terms'] = 1;
        $input['stripe_active'] = 0;

        if (empty($request['passwords']))
        {
            $input['passwords'] = $user->password;
        }
        else
        {
            $input['passwords'] = $request['passwords'];
        }

        if (empty($input['active']))
        {
            $active_status = '0';
        }
        else
        {
            $active_status = '1';
        }

        if (empty($input['avatar']))
        {
            $avatar_image = null;
        }
        else
        {
            $avatar_image = $input['avatar'];;
        }

            DB::table('users')->where('id', $id)->update(
                [
                    'username' => $input['username'],
                    'email' => $input['email'],
                    'ccode' => $input['ccode'],
                    'mobile' => $input['mobile'],
                    'password' => Hash::make($input['passwords']),
                    'role' => $input['role'],
                    'active' => $active_status,
                    'terms' => $input['terms'],
                    'avatar' => $avatar_image,
                    'stripe_active' => $input['stripe_active'],
                ]);

        return Redirect::to('admin/users')
            ->with(array(
            'message' => 'Successfully Created New User',
            'note_type' => 'success'
        ));
    }

    public function edit($id)
    {
        $user =  User::where('id',1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');
        if ($current_date > $duedate)
        {
            $client = new Client();
            $url = "https://flicknexs.com/userapi/allplans";
            $params = [
                'userid' => 0,
            ];
    
            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ'
            ];
            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify'  => false,
            ]);
    
            $responseBody = json_decode($response->getBody());
           $settings = Setting::first();
           $data = array(
            'settings' => $settings,
            'responseBody' => $responseBody,
    );
            return View::make('admin.expired_dashboard', $data);
        }else{
        $user = User::find($id);
        $data = array(
            'user' => $user,
            'post_route' => URL::to('admin/user/update') ,
            'admin_user' => Auth::user() ,
            'button_text' => 'Update User',
        );
        return View::make('admin.users.create_edit', $data);
    }
    }

    public function SubscriberRevenueStartEndDateRecordofile()
    {

        $Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses($Theme);

        if (Auth::guest())
        {
            return redirect('/login');
        }
        $data = Session::all();

        // $session_password = $data['password_hash'];
        if (empty($data['password_hash']))
        {
            $system_settings = SystemSetting::first();

            return Theme::view('auth.login', compact('system_settings'));

            // return View::make('auth.login', $data);
            
        }
        else
        {

            $user_id = Auth::user()->id;
            $user_role = Auth::user()->role;
            $alldevices = LoggedDevice::where('user_id', '=', Auth::User()->id)
                ->get();

            if ($user_role == 'registered' || $user_role == 'admin')
            {
                $role_plan = $user_role;
                $plans = "";
                $devices_name = "";

            }
            elseif ($user_role == 'subscriber')
            {

                $user_role = Subscription::select('subscription_plans.*')->join('subscription_plans', 'subscription_plans.plan_id', '=', 'subscriptions.stripe_plan')
                    ->where('subscriptions.user_id', $user_id)->orderBy('created_at', 'DESC')
                    ->get();
                //     SELECT
                // subscription_plans.* FROM subscriptions INNER JOIN subscription_plans ON
                // subscriptions.stripe_plan = subscription_plans.plan_id
                // WHERE subscriptions.user_id = 601
                
                if (!empty($user_role[0]))
                {
                    $role_plan = $user_role[0]->plans_name;
                    $plans = SubscriptionPlan::where('plans_name', $role_plan)->first();
                    $devices = Devices::all();
                    $permission = $plans->devices;
                    $user_devices = explode(",", $permission);
                }
                else
                {
                    $role_plan = "No Plan";
                    $plans = "";
                }

                if (!empty($plans->devices))
                {
                    foreach ($devices as $key => $value)
                    {
                        if (in_array($value->id, $user_devices))
                        {
                            $devices_name[] = $value->devices_name;
                        }
                    }
                    $plan_devices = implode(",", $devices_name);
                    if (!empty($plan_devices))
                    {
                        $devices_name = $plan_devices;
                    }
                    else
                    {
                        $devices_name = "";
                    }
                }
                else
                {
                    $devices_name = "";
                }

            }
            // dd($devices_name);

            $user_role = Auth::user()->role;

            $user_details = User::find($user_id);
            $recent_videos = RecentView::orderBy('id', 'desc')->take(10)
                ->get();
            $recent_view = $recent_videos->unique('video_id');

            foreach ($recent_view as $key => $value)
            {
                $videos[] = Video::Where('id', '=', $value->video_id)
                    ->take(10)
                    ->get();
            }
            // dd($videos);
            // $recent_view = $videos->unique('slug');
            $videocategory = VideoCategory::all();
            $language = Language::all();

            // Multiuser profile details
            $Multiuser = Session::get('subuser_id');

            if ($Multiuser != null)
            {
                $users = Multiprofile::where('id', $Multiuser)->pluck('id')
                    ->first();
                $profile_details = Multiprofile::where('id', $users)->get();
            }
            else
            {
                $users = User::where('id', Auth::user()->id)
                    ->pluck('id')
                    ->first();
                $profile_details = Multiprofile::where('parent_id', $users)->get();
            }
            // $video = "";
            if (!empty($video))
            {
                $video = array_unique($videos);
            }
            else
            {
                $video = [];
            }
            // $video = array_unique($videos);
            // dd($plans);
            $data = array(
                'videos' => $video,
                'videocategory' => $videocategory,
                'plans' => $plans,
                'devices_name' => $devices_name,
                'user' => $user_details,
                'role_plan' => $role_plan,
                'user_role' => $user_role,
                'post_route' => URL::to('/profile/update') ,
                'language' => $language,
                'profile_details' => $profile_details,
                'Multiuser' => $Multiuser,
                'alldevices' => $alldevices,
            );
            return Theme::view('SubscriberRevenueStartEndDateRecordofile', $data);
        }
    }
    public function ProfileImage(Request $request)
    {

        $input = $request->all();
        // dd($input);
        $id = $request['user_id'];

        $path = public_path() . '/uploads/avatars/';
        $input['email'] = $request['email'];

        $path = public_path() . '/uploads/avatars/';
        $logo = $request['avatar'];

        if ($logo != '')
        {
            //code for remove old file
            if ($logo != '' && $logo != null)
            {
                $file_old = $path . $logo;
                if (file_exists($file_old))
                {
                    unlink($file_old);
                }
            }
            //upload new file
            $file = $logo;
            $input['avatar'] = $file->getClientOriginalName();
            $file->move($path, $input['avatar']);

        }

        $user_update = User::find($id);
        $user_update->avatar = $file->getClientOriginalName();
        $user_update->save();

        return Redirect::back();

    }
    public function myprofileupdate(Request $request)
    {
        // echo "<pre>";
        $input = $request->all();

      
        $id = $request['user_id'];

        $user = User::find($id);

        //    if ( empty($request['email'])){
        //        return Redirect::to('admin/user/create')->with(array('note' => 'Successfully Created New User', 'note_type' => 'failed') );
        //    } else {
        //         $request['email'] = $request['email'];
        //    }
        

        if (empty($request['password']))
        {
            $input['password'] = $user->password;
        }
        else
        {
            $input['password'] = Hash::make($request['password']);
        }

        $user_update = User::find($id);
        $user_update->email = $input['email'];
        $user_update->password = Hash::make($input['password']);
        $user_update->mobile = $input['mobile'];
        $user_update->username = $input['username'];
        $user_update->DOB = $input['DOB'];
        $user_update->save();

        return Redirect::back();

    }

    public function refferal()
    {
        return View::make('refferal');
    }

    public function profileUpdate(User $user, Request $request)
    {

        $user = User::find(Auth::user()->id);
        $user->username = $request->get('name');
        $user->mobile = $request->get('mobile');
        $user->email = $request->get('email');
        $user->DOB = $request->get('DOB');
        $user->ccode = $request->get('ccode');
        $user->username = $request->get('username');

        if ($request->get('password') != null)
        {
            $user->password =Hash::make($request->get('password'));
        }

        $path = public_path() . '/uploads/avatars/';
        $image_path = public_path() . '/uploads/avatars/';

        $image_req = $request['avatar'];

        $image = (isset($image_req)) ? $image_req : '';

        if ($image != '')
        {
            if ($image != '' && $image != null)    //code for remove old file
            {
                $file_old = $image_path . $image;
                if (file_exists($file_old))
                {
                    unlink($file_old);
                }
            }
            $file = $image;                         //upload new file
            // $user->avatar = $file->getClientOriginalName();
            $user->avatar = str_replace(' ', '_', $file->getClientOriginalName());

            $file->move($image_path, $user->avatar);
        }
        $user->save();
        return back();
    }

    public function mobileapp()
    {
        $user =  User::where('id',1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');
        if ($current_date > $duedate)
        {
            $client = new Client();
            $url = "https://flicknexs.com/userapi/allplans";
            $params = [
                'userid' => 0,
            ];
    
            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ'
            ];
            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify'  => false,
            ]);
    
            $responseBody = json_decode($response->getBody());
           $settings = Setting::first();
           $data = array(
            'settings' => $settings,
            'responseBody' => $responseBody,
    );
            return View::make('admin.expired_dashboard', $data);
        }else{
        $mobile_settings = MobileApp::get();
        $allCategories = MobileSlider::all();
        $welcome_screen = WelcomeScreen::all();
        $data = array(
            'admin_user' => Auth::user() ,
            'mobile_settings' => $mobile_settings,
            'allCategories' => $allCategories,
            'welcome_screen' => $welcome_screen,
        );
        return View::make('admin.mobile.index', $data);
    }
    }

    public function mobileappupdate(Request $request)
    {

        $input = $request->all();

        $path = public_path() . '/uploads/settings/';
        $splash_image = $request['splash_image'];
        $file = $splash_image;
        $input['splash_image'] = $file->getClientOriginalName();
        $file->move($path, $input['splash_image']);

        MobileApp::create(['splash_image' => $input['splash_image'], ]);

        return Redirect::to('admin/mobileapp')->with(array(
            'message' => 'Successfully Updated  Settings!',
            'note_type' => 'success'
        ));

        //   $settings = MobileApp::first();
        //   $path = public_path().'/uploads/settings/';
        //   $splash_image = $request['splash_image'];
        //   if($splash_image != '') {
        //     //code for remove old file
        //     if($splash_image != ''  && $splash_image != null){
        //       $file_old = $path.$splash_image;
        //       if (file_exists($file_old)){
        //         unlink($file_old);
        //       }
        //     }
        //     //upload new file
        //     $file = $splash_image;
        //     $input['splash_image']  = $file->getClientOriginalName();
        //     $file->move($path, $input['splash_image']);
        //   }
        //   $settings->update($input);
        
    }

    public function logout()
    {
        $data = \Session::all();
        // dd($data);
        $agent = new Agent();

        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
        $userIp = $geoip->getip();
        $device_name = '';
        if ($agent->isDesktop())
        {
            $device_name = 'desktop';
        }
        elseif ($agent->isTablet())
        {
            $device_name = 'tablet';
        }
        elseif ($agent->isMobile())
        {
            $device_name = 'mobile';
        }
        elseif ($agent->isMobile())
        {
            $device_name = 'mobile';
        }
        else
        {
            $device_name = 'tv';
        }
        if (!empty($device_name))
        {
            $devices_check = LoggedDevice::where('user_ip', '=', $userIp)->where('user_id', '=', Auth::User()
                ->id)
                ->where('device_name', '=', $device_name)->first();
            if (!empty($devices_check))
            {
                $devices_check = LoggedDevice::where('user_ip', '=', $userIp)->where('user_id', '=', Auth::User()
                    ->id)
                    ->where('device_name', '=', $device_name)->delete();
            }
        }
        Auth::logout();
        unset($data['password_hash']);

        \Session::flush();

        return Redirect::to('/')->with(array(
            'message' => 'You are logged out done',
            'note_type' => 'success'
        ));
    }

    public function destroy($id)
    {

        User::destroy($id);
        return Redirect::to('admin/users')->with(array(
            'message' => 'Successfully Deleted User',
            'note_type' => 'success'
        ));
    }

    public function VerifyDevice($userIp, $id)
    {
        // dd($id);
        $device = LoggedDevice::find($id);
        $username = @$device
            ->user_name->username;
        $email = @$device
            ->user_name->email;
        $user_ip = @$device->user_ip;
        $device_name = @$device->device_name;
        $user_id = @$device->user_id;

        $settings = Setting::find(1);

        // $mail_check = ApprovalMailDevice::where('user_ip','=', $user_ip)->where('device_name','=', $device_name)->first();
        // if(empty($mail_check)){
        // dd($device->user_name->username);
        Mail::send('emails.device_logout', array(
            /* 'activation_code', $user->activation_code,*/
            'name' => $username,
            'email' => $email,
            'user_ip' => $user_ip,
            'device_name' => $device_name,
            'id' => $id,
        ) , function ($message) use ($email, $username, $settings)
        {
            $message->from(AdminMail() , $settings->website_name);
            $message->to($email, $username)->subject('Request to Logout Device');
        });
        $maildevice = new ApprovalMailDevice;
        $maildevice->user_ip = $userIp;
        $maildevice->device_name = $device_name;
        $maildevice->device_name = $user_id;
        $maildevice->status = 0;
        $maildevice->save();
        $message = 'Mail Sent to the' . ' ' . $username;
        return Redirect::back()->with('message', $message);
        // }elseif(!empty($mail_check) && $mail_check->status == 2 || $mail_check->status == 0){
        // return Redirect::back();
        // }
        
    }
    public function LogoutDevice($id)
    {
        $device = LoggedDevice::find($id);
        $username = @$device
            ->user_name->username;
        $email = @$device
            ->user_name->email;
        $device_name = @$device->device_name;
        $user_ip = @$device->user_ip;

        $maildevice = ApprovalMailDevice::orderBy('id', 'DESC')->first();
        $LoggedDevice = LoggedDevice::get();
        if (!empty($LoggedDevice))
        {
            $user_id = $LoggedDevice[0]->user_id;
            $user = User::where('id', $user_id)->first();
            $username = $user->username;
        }
        // dd($user);
        $maildevice->status = 1;
        $maildevice->save();

        LoggedDevice::destroy($id);
        $settings = Setting::find(1);

        if (!empty($user_id))
        {
            Mail::send('emails.register_device_login', array(
                'id' => $user_id,
                'name' => $username,

            ) , function ($message) use ($email, $username, $settings)
            {
                $message->from(AdminMail() , $settings->website_name);
                $message->to($email, $username)->subject('Buy Advanced Plan To Access Multiple Devices');
            });
        }
        return Redirect::to('home');
        // return Redirect::to('/home');
        // return Redirect::back();
        
    }
    public function ApporeDevice($ip, $id, $device_name)
    {
        // $adddevice = new LoggedDevice;
        // $adddevice->user_id = $id;
        // $adddevice->user_ip = $ip;
        // $adddevice->device_name = $device_name;
        // $adddevice->save();
        $data = array(
            'user_ip' => $ip,
            'device_name' => $device_name,
            'id' => $id
        );
        return View::make('device_accept', $data);
        // $message = 'Approved User For Login';
        // return View::make('auth.login')->with('alert', $message);
        
    }
    public function AcceptDevice($user_ip, $device_name, $id)
    {
        // dd($device_name);
        $adddevice = new LoggedDevice;
        $adddevice->user_id = $id;
        $adddevice->user_ip = $user_ip;
        $adddevice->device_name = $device_name;
        $adddevice->save();
        $maildevice = ApprovalMailDevice::where('user_ip', '=', $user_ip)->where('device_name', '=', $device_name)->first();
        $maildevice->status = 1;
        $maildevice->save();
        $system_settings = SystemSetting::first();
        $user = User::where('id', '=', 1)->first();
        $message = 'Approved User to Login';
        return Redirect::to('/')->with('message', $message);

        // return View::make('auth.login')->with('alert', $message);
        
    }
    public function RejectDevice($userIp, $device_name)
    {
        $maildevice = ApprovalMailDevice::where('user_ip', '=', $userIp)->where('device_name', '=', $device_name)->first();
        $maildevice->status = 2;
        $maildevice->save();
        $system_settings = SystemSetting::first();
        $user = User::where('id', '=', 1)->first();
        $message = 'Approved User For Login';
        return Redirect::back('/')->with('message', $message);

    }
    public function export(Request $request)
    {

        $input = $request->all();
        $start_date = $input['start_date'];
        $end_date = $input['end_date'];
        $users = User::all();
        // $start_Date=$input['start_date'];
        // $end_Date=$input['end_date'];
        $country_name = CountryCode::get();

        foreach ($country_name as $key => $values)
        {

            $phonecode[] = $values->phonecode;
            $country_names[] = $values->name;
        }
        foreach ($users as $user_ccode)
        {
            $ccode[] = $user_ccode->ccode;

        }
        $current_plan = User::select(['subscriptions.*', 'users.*', 'subscription_plans.plans_name', 'subscription_plans.billing_interval', 'subscription_plans.days'])
        ->join('subscriptions', 'subscriptions.user_id', '=', 'users.id')
            ->join('subscription_plans', 'subscriptions.stripe_plan', '=', 'subscription_plans.plan_id')
            ->where('role', '=', 'subscriber')
            ->get();
            // dd($current_plan);
        // $current_plan = \DB::table('users')
        // ->select(['subscriptions.*','users.*','plans.plans_name','plans.billing_interval','plans.days'])
        // ->join('subscriptions', 'subscriptions.user_id', '=', 'users.id')
        // ->join('plans', 'subscriptions.stripe_plan', '=', 'plans.plan_id')
        // ->where('role', '=', 'subscriber' )
        // ->get();
        if ($start_date == "" && $end_date == "")
        {

            foreach ($users as $user)
            {
                $user_array[] = array(
                    'Username' => $user->username,
                    'User ID' => $user->id,
                    'Email' => $user->email,
                    'Contact Number' => $user->mobile,
                    'Country Name' => $user->ccode,
                    'ccode' => array() ,
                    'options' => array() ,
                    'User Type' => $user->role,
                    'Active' => $user->active,
                );
                foreach ($current_plan as $plans)
                {
                    if ($plans->user_id == $user->id)
                    {
                        $subscription_date = $current_plan[0]->created_at;
                        $days = $current_plan[0]->days . 'days';
                        $date = date_create($subscription_date);
                        $subscription_date = date_format($date, 'Y-m-d');
                        $end_date = date('Y-m-d', strtotime($subscription_date . ' + ' . $days));
                        // echo $end_date;
                        $user_array['options'][$user->id] = array(
                            'Current Package' => $plans->billing_interval,
                            'Start Date' => $plans->created_at,
                            'End Date' => $end_date,
                        );
                    }else{
                        $user_array['options'] = [];
                    }
                }
                foreach ($country_name as $name)
                {
                    if (in_array($name->phonecode, $ccode))
                    {
                        $coun[$name
                            ->phonecode] = $name->country_name;
                        foreach ($coun as $key => $coun_name)
                        {

                            if ($key == $user->ccode)
                            {
                                $user_array['ccode'][$user->id] = array(
                                    'Country Name' => $coun_name,
                                );

                            }
                        }

                    }
                }

            }
            foreach ($users as $k => $value)
            {
                $package = "";
                $startdate = "";
                $enddate = "";
                if(!empty($user_array['options'])){
                foreach ($user_array['options'] as $keys => $plans)
                {
                    $plankeys[] = $keys;
                    if ($value->id == $keys)
                    {
                        $package = $plans['Current Package'];
                        // print_r($plans['Start Date']);
                        $startdate = $plans['Start Date'];
                        $enddate = $plans['End Date'];
                    }
                }
            }else{
                $package ="";
                        // print_r($plans['Start Date']);
                        $startdate = "";
                        $enddate = "";
            }
                // exit();
                $countryname = "";
                foreach ($user_array['ccode'] as $key => $ccode)
                {
                    $ccodekey[] = $key;
                    if ($value->id == $key)
                    {
                        $countryname = $ccode['Country Name'];
                    }

                }
                $data[] = array(
                    'Username' => $value->username,
                    'User ID' => $value->id,
                    'Email' => $value->email,
                    'Contact Number' => $value['mobile'],
                    'Country Name' => $countryname ? $countryname : NULL,
                    'Current Package' => $package ? $package : NULL,
                    'Start Date' => $startdate ? $startdate : NULL,
                    'End Date' => $enddate ? $enddate : NULL,
                    'User Type' => $value->role,
                    'Active' => $value->active,
                );
            }

            $file_name = 'User.xlsx';

            $spreadsheet = new Spreadsheet();

            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setCellValue('A1', 'Username');

            $sheet->setCellValue('B1', 'User ID');

            $sheet->setCellValue('C1', 'Email');

            $sheet->setCellValue('D1', 'Contact Number');

            $sheet->setCellValue('E1', 'Country Name');

            $sheet->setCellValue('F1', 'Current Package');

            $sheet->setCellValue('G1', 'Start Date');

            $sheet->setCellValue('H1', 'End Date');

            $sheet->setCellValue('I1', 'User Type');

            $sheet->setCellValue('J1', 'Active');

            $count = 2;

            foreach ($data as $row)
            {
                $sheet->setCellValue('A' . $count, $row['Username']);

                $sheet->setCellValue('B' . $count, $row['User ID']);

                $sheet->setCellValue('C' . $count, $row['Email']);

                $sheet->setCellValue('D' . $count, $row['Contact Number']);

                $sheet->setCellValue('E' . $count, $row['Country Name']);

                $sheet->setCellValue('F' . $count, $row['Current Package']);

                $sheet->setCellValue('G' . $count, $row['Start Date']);

                $sheet->setCellValue('H' . $count, $row['End Date']);

                $sheet->setCellValue('I' . $count, $row['User Type']);

                $sheet->setCellValue('J' . $count, $row['Active']);

                $count++;
            }

            $writer = new Xlsx($spreadsheet);

            $writer->save($file_name);

            header("Content-Type: application/vnd.ms-excel");

            header('Content-Disposition: attachment; filename="' . basename($file_name) . '"');

            header('Expires: 0');

            header('Cache-Control: must-revalidate');

            header('Pragma: public');

            header('Content-Length:' . filesize($file_name));

            flush();

            readfile($file_name);

            //  exit;
            return \Redirect::back();
            //    return Excel::download($data, 'users.xlsx');
            
        }
        else
        {
            foreach ($users as $user)
            {
                $user_array[] = array(
                    'Username' => $user->username,
                    'User ID' => $user->id,
                    'Email' => $user->email,
                    'Contact Number' => $user->mobile,
                    'Country Name' => $user->ccode,
                    'ccode' => array() ,
                    'options' => array() ,
                    'User Type' => $user->role,
                    'Active' => $user->active,
                );
                foreach ($current_plan as $plans)
                {
                    if ($plans->user_id == $user->id)
                    {
                        $subscription_date = $current_plan[0]->created_at;
                        $days = $current_plan[0]->days . 'days';
                        $date = date_create($subscription_date);
                        $subscription_date = date_format($date, 'Y-m-d');
                        $end_date = date('Y-m-d', strtotime($subscription_date . ' + ' . $days));
                        // echo $end_date;
                        $user_array['options'][$user->id] = array(
                            'Current Package' => $plans->billing_interval,
                            'Start Date' => $plans->created_at,
                            'End Date' => $end_date,
                        );
                    }
                }
                foreach ($country_name as $name)
                {
                    if (in_array($name->phonecode, $ccode))
                    {
                        $coun[$name
                            ->phonecode] = $name->country_name;
                        foreach ($coun as $key => $coun_name)
                        {

                            if ($key == $user->ccode)
                            {
                                $user_array['ccode'][$user->id] = array(
                                    'Country Name' => $coun_name,
                                );

                            }
                        }

                    }
                }

            }
            
            foreach ($users as $k => $value)
            {
                $package = "";
                $startdate = "";
                $enddate = "";
                if (!empty($user_array['options']))
                {
                foreach ($user_array['options'] as $keys => $plans)
                {
                    $plankeys[] = $keys;
                    if ($value->id == $keys)
                    {
                        $package = $plans['Current Package'];
                        // print_r($plans['Start Date']);
                        $startdate = $plans['Start Date'];
                        $enddate = $plans['End Date'];
                    }
                }
            }else{
                $package ="";
                        // print_r($plans['Start Date']);
                        $startdate = "";
                        $enddate = "";
            }
                // exit();
                $countryname = "";
                foreach ($user_array['ccode'] as $key => $ccode)
                {
                    $ccodekey[] = $key;
                    if ($value->id == $key)
                    {
                        $countryname = $ccode['Country Name'];
                    }

                }
                $data_filter[] = array(
                    'Username' => $value->username,
                    'User ID' => $value->id,
                    'Email' => $value->email,
                    'Contact Number' => $value['mobile'],
                    'Country Name' => $countryname ? $countryname : NULL,
                    'Current Package' => $package ? $package : NULL,
                    'Start Date' => $startdate ? $startdate : NULL,
                    'End Date' => $enddate ? $enddate : NULL,
                    'User Type' => $value->role,
                    'Active' => $value->active,
                );
            }

            $start_date = $input['start_date'];
            $end_date = $input['end_date'];
            // echo "<pre>";
            // print_r($input);
            foreach ($data_filter as $key => $value)
            {
                $subscription_date = $value['Start Date'];
                $date = date_create($subscription_date);
                $subscription_date = date_format($date, 'Y-m-d');
                $subscription_date = date('Y-m-d', strtotime($subscription_date));
                if ($subscription_date >= $input['start_date'] && $value['Start Date'] != null && $value['End Date'] <= $input['end_date'] && $value['End Date'] != null)
                {

                    $data[] = $value;
                }
                else
                {
                    $data = [];

                }
            }
            $file_name = 'User.xlsx';

            $spreadsheet = new Spreadsheet();

            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setCellValue('A1', 'Username');

            $sheet->setCellValue('B1', 'User ID');

            $sheet->setCellValue('C1', 'Email');

            $sheet->setCellValue('D1', 'Contact Number');

            $sheet->setCellValue('E1', 'Country Name');

            $sheet->setCellValue('F1', 'Current Package');

            $sheet->setCellValue('G1', 'Start Date');

            $sheet->setCellValue('H1', 'End Date');

            $sheet->setCellValue('I1', 'User Type');

            $sheet->setCellValue('J1', 'Active');

            $count = 2;

            foreach ($data as $row)
            {
                // echo "<pre>";
                // print_r($row['Username']);
                $sheet->setCellValue('A' . $count, $row['Username']);

                $sheet->setCellValue('B' . $count, $row['User ID']);

                $sheet->setCellValue('C' . $count, $row['Email']);

                $sheet->setCellValue('D' . $count, $row['Contact Number']);

                $sheet->setCellValue('E' . $count, $row['Country Name']);

                $sheet->setCellValue('F' . $count, $row['Current Package']);

                $sheet->setCellValue('G' . $count, $row['Start Date']);

                $sheet->setCellValue('H' . $count, $row['End Date']);

                $sheet->setCellValue('I' . $count, $row['User Type']);

                $sheet->setCellValue('J' . $count, $row['Active']);

                $count++;
            }
            //  exit();
            $writer = new Xlsx($spreadsheet);

            $writer->save($file_name);

            header("Content-Type: application/vnd.ms-excel");

            header('Content-Disposition: attachment; filename="' . basename($file_name) . '"');

            header('Expires: 0');

            header('Cache-Control: must-revalidate');

            header('Pragma: public');

            header('Content-Length:' . filesize($file_name));

            flush();

            readfile($file_name);

            return \Redirect::back();

        }

        //    return Excel::download(new UsersExport, 'users.xlsx');
        return \Redirect::back();

    }

    public function GetState(Request $request)
    {
        $data['states'] = State::where("country_id", $request->country_id)
            ->get(["name", "id"]);
        return response()
            ->json($data);
    }
    public function GetCity(Request $request)
    {
        $data['cities'] = City::where("state_id", $request->state_id)
            ->get(["name", "id"]);
        return response()
            ->json($data);
    }

    public function AnalyticsRevenue()
    {
        $user =  User::where('id',1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');
        if ($current_date > $duedate)
        {
            $client = new Client();
            $url = "https://flicknexs.com/userapi/allplans";
            $params = [
                'userid' => 0,
            ];
    
            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ'
            ];
            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify'  => false,
            ]);
    
            $responseBody = json_decode($response->getBody());
           $settings = Setting::first();
           $data = array(
            'settings' => $settings,
            'responseBody' => $responseBody,
    );
            return View::make('admin.expired_dashboard', $data);
        }else{
        $registered_count = User::where('role', 'registered')->count();
        $subscription_count = User::where('role', 'subscriber')->count();
        $admin_count = User::where('role', 'admin')->count();
        $ppvuser_count = User::join('ppv_purchases', 'users.id', '=', 'ppv_purchases.user_id')->count();

        $data['total_user'] = User::select(\DB::raw("COUNT(*) as count") , \DB::raw("MONTHNAME(created_at) as month_name") , \DB::raw('max(created_at) as createdAt'))->whereYear('created_at', date('Y'))
            ->groupBy('month_name')
            ->orderBy('createdAt')
            ->get();
        // $total_user = User::where('role', '!=', 'admin')->get();
        $total_user = User::where('role', '!=', 'admin')->paginate(10);

        $data1 = array(
            'admin_count' => $admin_count,
            'subscription_count' => $subscription_count,
            'registered_count' => $registered_count,
            'total_user' => $total_user,
            'ppvuser_count' => $ppvuser_count,

        );
        return \View::make('admin.analytics.revenue', ['data1' => $data1, 'data' => $data, 'total_user' => $total_user]);
    }
    }

    public function ListUsers(Request $request)
    {

        $data = $request->all();
        $output = '';
        $role = $data['role'];
        if ($role == "registered")
        {
            $Users = User::where('role', 'registered')->get();
        }
        elseif ($role == "subscriber")
        {
            $Users = User::where('role', 'subscriber')->get();
        }
        elseif ($role == "ppv_users")
        {
            $Users = User::join('ppv_purchases', 'users.id', '=', 'ppv_purchases.user_id')->get();
        }
        else
        {
            $Users = User::where('role', 'admin')->get();
        }
        $total_row = $Users->count();
        if (!empty($Users))
        {
            foreach ($Users as $row)
            {
                if ($row->active == 0)
                {
                    $active = "InActive";
                    $class = "bg-warning";
                }
                elseif ($row->active == 1)
                {
                    $active = "Active";
                    $class = "bg-success";
                }
                if ($row->role == "registered")
                {
                    $role = 'Registered User';
                }
                elseif ($row->role == "subscriber")
                {
                    $role = 'Subscribed User';
                }
                else
                {
                    {
                        $role = 'Admin User';
                    }
                }
                if (@$row
                    ->phoneccode->phonecode == $row->ccode)
                {
                    $phoneccode = @$row
                        ->phoneccode->country_name;
                }
                else
                {
                    $phoneccode = 'No Country Added';
                }
                if ($row->provider == "google")
                {
                    $provider = "Google User";
                }
                elseif ($row->provider == "facebook")
                {
                    $provider = "Facebook User";
                }
                else
                {
                    $provider = 'Web User';
                }
                $output .= '
          <tr>
          <td>' . $row->username  . '</td>
          <td>' . $role . '</td>
          <td>' . $phoneccode . '</td>
          <td>' . $provider . '</td>
          <td>' . $row->created_at . '</td>
          <td>' . $active . '</td>

          </tr>
          ';
            }
        }
        else
        {
            $output = '
         <tr>
          <td align="center" colspan="5">No Data Found</td>
         </tr>
         ';
        }
        $data = array(
            'table_data' => $output,
            'total_data' => $total_row,

        );

        echo json_encode($data);

    }

    public function exportCsv(Request $request)
    {

        $data = $request->all();
        $start_time = $data['start_time'];
        $end_time = $data['end_time'];
        if (!empty($start_time) && empty($end_time))
        {

            $registered_count = User::where('role', 'registered')->whereDate('created_at', '>=', $start_time)->count();
            $subscription_count = User::where('role', 'subscriber')->whereDate('created_at', '>=', $start_time)->count();
            $admin_count = User::where('role', 'admin')->whereDate('created_at', '>=', $start_time)->count();

            $registered = User::where('role', 'registered')->whereDate('created_at', '>=', $start_time)->get();
            $subscription = User::where('role', 'subscriber')->whereDate('created_at', '>=', $start_time)->get();
            $admin = User::where('role', 'admin')->whereDate('created_at', '>=', $start_time)->get();

        }
        elseif (!empty($start_time) && !empty($end_time))
        {

            $registered_count = User::where('role', 'registered')->whereBetween('created_at', [$start_time, $end_time])->count();
            $subscription_count = User::where('role', 'subscriber')->whereBetween('created_at', [$start_time, $end_time])->count();
            $admin_count = User::where('role', 'subscriber')->whereBetween('created_at', [$start_time, $end_time])->count();

            $registered = User::where('role', 'registered')->whereBetween('created_at', [$start_time, $end_time])->get();
            $subscription = User::where('role', 'subscriber')->whereBetween('created_at', [$start_time, $end_time])->get();
            $admin = User::where('role', 'admin')->whereBetween('created_at', [$start_time, $end_time])->get();

        }
        else
        {
            $registered_count = User::where('role', 'registered')->count();
            $subscription_count = User::where('role', 'subscriber')->count();
            $admin_count = User::where('role', 'admin')->count();

            $registered = User::where('role', 'registered')->get();
            $subscription = User::where('role', 'subscriber')->get();
            $admin = User::where('role', 'admin')->get();

        }
        $file = 'users_' . rand(10, 100000) . '.csv';
        $headers = array(
            'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-Disposition' => 'attachment; filename=download.csv',
            'Expires' => '0',
            'Pragma' => 'public',
        );
        if (!File::exists(public_path() . "/uploads/csv"))
        {
            File::makeDirectory(public_path() . "/uploads/csv");
        }
        $filename = public_path("/uploads/csv/" . $file);
        $handle = fopen($filename, 'w');
        fputcsv($handle, ["User Name", "ACC Type", "Country", "Registered ON ", "Source", "Status",]);
        if ($registered_count > 0)
        {
            foreach ($registered as $each_user)
            {
                if ($each_user->active == 0)
                {
                    $active = "InActive";
                    $class = "bg-warning";
                }
                elseif ($each_user->active == 1)
                {
                    $active = "Active";
                    $class = "bg-success";
                }
                if ($each_user->role == "registered")
                {
                    $role = 'Registered User';
                }
                elseif ($each_user->role == "subscriber")
                {
                    $role = 'Subscribed User';
                }
                else
                {
                    $role = 'Admin User';
                }
                if (@$each_user
                    ->phoneccode->phonecode == $each_user->ccode)
                {
                    $phoneccode = @$each_user
                        ->phoneccode->country_name;
                }
                else
                {
                    $phoneccode = 'No Country Added';
                }
                if ($each_user->provider == "google")
                {
                    $provider = "Google User";
                }
                elseif ($each_user->provider == "facebook")
                {
                    $provider = "Facebook User";
                }
                else
                {
                    $provider = 'Web User';
                }
                fputcsv($handle, [$each_user->username, $role, $phoneccode, $each_user->created_at, $provider, $active,

                ]);
            }
        }
        if ($subscription_count > 0)
        {
            foreach ($subscription as $each_user)
            {
                if ($each_user->active == 0)
                {
                    $active = "InActive";
                    $class = "bg-warning";
                }
                elseif ($each_user->active == 1)
                {
                    $active = "Active";
                    $class = "bg-success";
                }
                if ($each_user->role == "registered")
                {
                    $role = 'Registered User';
                }
                elseif ($each_user->role == "subscriber")
                {
                    $role = 'Subscribed User';
                }
                else
                {
                    $role = 'Admin User';
                }
                if (@$each_user
                    ->phoneccode->phonecode == $each_user->ccode)
                {
                    $phoneccode = @$each_user
                        ->phoneccode->country_name;
                }
                else
                {
                    $phoneccode = 'No Country Added';
                }
                if ($each_user->provider == "google")
                {
                    $provider = "Google User";
                }
                elseif ($each_user->provider == "facebook")
                {
                    $provider = "Facebook User";
                }
                else
                {
                    $provider = 'Web User';
                }
                fputcsv($handle, [$each_user->username, $role, $phoneccode, $each_user->created_at, $provider, $active, ]);

            }
        }
        if ($admin_count > 0)
        {
            foreach ($admin as $each_user)
            {
                if ($each_user->active == 0)
                {
                    $active = "InActive";
                    $class = "bg-warning";
                }
                elseif ($each_user->active == 1)
                {
                    $active = "Active";
                    $class = "bg-success";
                }
                if ($each_user->role == "registered")
                {
                    $role = 'Registered User';
                }
                elseif ($each_user->role == "subscriber")
                {
                    $role = 'Subscribed User';
                }
                else
                {
                    $role = 'Admin User';
                }
                if (@$each_user
                    ->phoneccode->phonecode == @$each_user->ccode)
                {
                    $phoneccode = @$each_user
                        ->phoneccode->country_name;
                }
                else
                {
                    $phoneccode = 'No Country Added';
                }
                if ($each_user->provider == "google")
                {
                    $provider = "Google User";
                }
                elseif ($each_user->provider == "facebook")
                {
                    $provider = "Facebook User";
                }
                else
                {
                    $provider = 'Web User';
                }
                fputcsv($handle, [$each_user->username, $role, $phoneccode, $each_user->created_at, $provider, $active,

                ]);

            }
        }
        fclose($handle);

         Response::download($filename, "download.csv", $headers);

         return $file;
    }

    public function StartDateRecord(Request $request)
    {

        $data = $request->all();

        $start_time = $data['start_time'];
        $end_time = $data['end_time'];
        if (!empty($start_time) && empty($end_time))
        {
            $total_users = User::select(\DB::raw("COUNT(*) as count") , \DB::raw("MONTHNAME(created_at) as month_name") , \DB::raw('max(created_at) as createdAt'))->whereYear('created_at', date('Y'))
                ->whereDate('created_at', '>=', $start_time)->groupBy('month_name')
                ->orderBy('createdAt')
                ->get();
            $registered = User::where('role', 'registered')->whereDate('created_at', '>=', $start_time)->count();
            $subscription = User::where('role', 'subscriber')->whereDate('created_at', '>=', $start_time)->count();
            $admin = User::where('role', 'admin')->whereDate('created_at', '>=', $start_time)->count();

        }

        $output = '';
        $Users = User::whereDate('created_at', '>=', $start_time)->get();
        $total_row = $Users->count();
        if (!empty($Users))
        {
            foreach ($Users as $row)
            {
                if ($row->active == 0)
                {
                    $active = "InActive";
                    $class = "bg-warning";
                }
                elseif ($row->active == 1)
                {
                    $active = "Active";
                    $class = "bg-success";
                }
                if ($row->role == "registered")
                {
                    $role = 'Registered User';
                }
                elseif ($row->role == "subscriber")
                {
                    $role = 'Subscribed User';
                }
                else
                {
                    $role = 'Admin User';
                }
                if (@$row
                    ->phoneccode->phonecode == $row->ccode)
                {
                    $phone_ccode = @$row
                        ->phoneccode->country_name;
                }
                else
                {
                    $phone_ccode = 'No Country Added';
                }
                if ($row->provider == "google")
                {
                    $provider = "Google User";
                }
                elseif ($row->provider == "facebook")
                {
                    $provider = "Facebook User";
                }
                else
                {
                    $provider = 'Web User';
                }
                $output .= '
          <tr>
          <td>' . $row->username  . '</td>
          <td>' . $role . '</td>
          <td>' . $phone_ccode . '</td>
          <td>' . $provider . '</td>
          <td>' . $row->created_at . '</td>
          <td>' . $active . '</td>

          </tr>
          ';
            }
        }
        else
        {
            $output = '
         <tr>
          <td align="center" colspan="5">No Data Found</td>
         </tr>
         ';
        }
        $value = array(
            'table_data' => $output,
            'total_data' => $total_row,
            'registered' => $registered,
            'subscription' => $subscription,
            'admin' => $admin,
            'total_users' => $total_users,
        );

        return $value;

    }

    public function StartEndDateRecord(Request $request)
    {

        $data = $request->all();

        $start_time = $data['start_time'];
        $end_time = $data['end_time'];

        if (!empty($start_time) && !empty($end_time))
        {
            $total_users = User::select(\DB::raw("COUNT(*) as count") , \DB::raw("MONTHNAME(created_at) as month_name") , \DB::raw('max(created_at) as createdAt'))->whereYear('created_at', date('Y'))
                ->whereBetween('created_at', [$start_time, $end_time])->groupBy('month_name')
                ->orderBy('createdAt')
                ->get();
            $registered = User::where('role', 'registered')->whereBetween('created_at', [$start_time, $end_time])->count();
            $subscription = User::where('role', 'subscriber')->whereBetween('created_at', [$start_time, $end_time])->count();
            $admin = User::where('role', 'admin')->whereBetween('created_at', [$start_time, $end_time])->count();
        }
        $registered = User::where('role', 'registered')->count();
        $subscription = User::where('role', 'subscriber')->count();
        $admin = User::where('role', 'admin')->count();

        $output = '';
        $Users = User::whereBetween('created_at', [$start_time, $end_time])->get();
        $total_row = $Users->count();
        if (!empty($Users))
        {
            foreach ($Users as $row)
            {
                if ($row->active == 0)
                {
                    $active = "InActive";
                    $class = "bg-warning";
                }
                elseif ($row->active == 1)
                {
                    $active = "Active";
                    $class = "bg-success";
                }
                if ($row->role == "registered")
                {
                    $role = 'Registered User';
                }
                elseif ($row->role == "subscriber")
                {
                    $role = 'Subscribed User';
                }
                else
                {
                    $role = 'Admin User';
                }
                if (@$row
                    ->phoneccode->phonecode == $row->ccode)
                {
                    $phone_ccode = @$row
                        ->phoneccode->country_name;
                }
                else
                {
                    $phone_ccode = 'No Country Added';
                }
                if ($row->provider == "google")
                {
                    $provider = "Google User";
                }
                elseif ($row->provider == "facebook")
                {
                    $provider = "Facebook User";
                }
                else
                {
                    $provider = 'Web User';
                }
                $output .= '
              <tr>
              <td>' . $row->username  . '</td>
              <td>' . $role . '</td>
              <td>' . $phone_ccode . '</td>
              <td>' . $provider . '</td>
              <td>' . $row->created_at . '</td>
              <td>' . $active . '</td>
    
              </tr>
              ';
            }
        }
        else
        {
            $output = '
             <tr>
              <td align="center" colspan="5">No Data Found</td>
             </tr>
             ';
        }
        $value = array(
            'table_data' => $output,
            'total_data' => $total_row,
            'registered' => $registered,
            'subscription' => $subscription,
            'admin' => $admin,
            'total_users' => $total_users,
        );

        return $value;
    }

    public function ViewsRegion()
    {
        $user =  User::where('id',1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');
        if ($current_date > $duedate)
        {
            $client = new Client();
            $url = "https://flicknexs.com/userapi/allplans";
            $params = [
                'userid' => 0,
            ];
    
            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ'
            ];
            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify'  => false,
            ]);
    
            $responseBody = json_decode($response->getBody());
           $settings = Setting::first();
           $data = array(
            'settings' => $settings,
            'responseBody' => $responseBody,
    );
            return View::make('admin.expired_dashboard', $data);
        }else{
        $Country = Region::get();

        $data = array(
            'Country' => $Country,
        );
        return \View::make('admin.analytics.views_by_region', $data);
    }
    }

    public function RevenueRegion()
    {
        $user =  User::where('id',1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');
        if ($current_date > $duedate)
        {
            $client = new Client();
            $url = "https://flicknexs.com/userapi/allplans";
            $params = [
                'userid' => 0,
            ];
    
            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ'
            ];
            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify'  => false,
            ]);
    
            $responseBody = json_decode($response->getBody());
           $settings = Setting::first();
           $data = array(
            'settings' => $settings,
            'responseBody' => $responseBody,
    );
            return View::make('admin.expired_dashboard', $data);
        }else{
        $Country = Region::get();
        $State = State::get();
        $City = City::get();
        // dd($City);
        $data = array(
            'Country' => $Country,
            'State' => $State,
            'City' => $City,

        );
        return \View::make('admin.analytics.revenue_by_region', $data);
    }
    }

    public function RegionVideos(Request $request)
    {
        if ($request->ajax())
        {

            $output = '';
            $query = $request->get('query');

            if ($query != '')
            {
                // $regions =  DB::table('regions')->where('regions.id','=',$query)->first();
                $regions = Region::where('id', '=', $query)->first();

                $region_views = RegionView::leftjoin('videos', 'region_views.video_id', '=', 'videos.id')->where('region_views.countryname', '=', $regions->name)
                    ->get();
                // echo "<pre>";
                // print_r($region_views);
                // exit();
                $data = $region_views->groupBy('countryname');
                // $data1 = DB::table('videos')
                // ->select('videos.*','region_views.countryname')
                // ->join('region_views', 'region_views.video_id', '=', 'videos.id')
                // ->orderBy('created_at', 'desc')
                // ->where('region_views.countryname','=',$regions->name)
                // ->paginate(19);
                $data1 = Video::select('videos.*', 'region_views.countryname')->join('region_views', 'region_views.video_id', '=', 'videos.id')
                    ->orderBy('created_at', 'desc')
                    ->where('region_views.countryname', '=', $regions->name)
                    ->paginate(19);
                // echo "<pre>"; print_r($data);exit();
                
            }
            else
            {

            }
            $i = 1;
            $total_row = $data1->count();
            if ($total_row > 0)
            {
                foreach ($data as $row)
                {
                    $output .= '
        <tr>
        <td>' . $i++ . '</td>
         <td>' . $row[0]->title . '</td>
         <td>' . $row[0]->countryname . '</td>
         <td>' . $row[0]->user_ip . '</td>
         <td>' . count($row) . '</td>
        </tr>
        ';
                }
            }
            else
            {
                $output = '
       <tr>
        <td align="center" colspan="5">No Data Found</td>
       </tr>
       ';
            }
            $data = array(
                'table_data' => $output,
                'total_data' => $total_row
            );

            echo json_encode($data);
        }
    }

    // <td> '."<a class='iq-bg-warning' data-toggle='tooltip' data-placement='top' title='' data-original-title='View' href=' $slug/$row->slug'><i class='lar la-eye'></i>
    // </a>".'
    // '."<a class='iq-bg-success' data-toggle='tooltip' data-placement='top' title='' data-original-title='Edit' href=' $edit/$row->id'><i class='ri-pencil-line'></i>
    // </a>".'
    // '."<a class='iq-bg-danger' data-toggle='tooltip' data-placement='top' title='' data-original-title='Delete'  href=' $delete/$row->id'><i class='ri-delete-bin-line'></i>
    // </a>".'
    // </td>
    public function AllRegionVideos(Request $request)
    {
        
        if ($request->ajax())
        {

            $output = '';
            $query = $request->get('query');

            if ($query != '')
            {
                // foreach($region_views as $video){
                //     $data[$video->countryname] = RegionView::();
                // }
                $region_views = RegionView::leftjoin('videos', 'region_views.video_id', '=', 'videos.id')->get();
                $data = $region_views->groupBy('countryname');

                // echo "<pre>";
                // print_r($grouped);
                // exit();
                // $data1 = DB::table('videos')
                // ->select('videos.*','region_views.countryname')
                // ->join('region_views', 'region_views.video_id', '=', 'videos.id')
                // ->orderBy('created_at', 'desc')
                // ->paginate(9);
                $data1 = Video::select('videos.*', 'region_views.countryname')->join('region_views', 'region_views.video_id', '=', 'videos.id')
                    ->orderBy('created_at', 'desc')
                    ->paginate(9);
                // echo "<pre>"; print_r($data);exit();
                
            }
            else
            {

            }
            $i = 1;
            $total_row = $data1->count();
            if ($total_row > 0)
            {
                foreach ($data as $key => $row)
                {
                    $output .= '
        <tr>
        <td>' . $i++ . '</td>
         <td>' . $row[0]->title . '</td>
         <td>' . $row[0]->countryname . '</td>
         <td>' . $row[0]->user_ip . '</td>
         <td>' . count($row) . '</td>
        </tr>
        ';
                }
            }
            else
            {
                $output = '
       <tr>
        <td align="center" colspan="5">No Data Found</td>
       </tr>
       ';
            }
            $data = array(
                'table_data' => $output,
                'total_data' => $total_row
            );

            echo json_encode($data);
        }
    }
    public function PlanCountry(Request $request)
    {
        if ($request->ajax())
        {

            $output = '';
            $query = $request->get('query');

            if ($query != '')
            {

                // $data = DB::table('subscriptions')
                // ->select('users.username','plans.plans_name')
                // ->join('users', 'users.id', '=', 'subscriptions.user_id')
                // ->join('plans', 'plans.plan_id', '=', 'subscriptions.stripe_plan')
                // ->where('subscriptions.countryname','=',$query)
                // ->paginate(9);
                $data = Subscription::select('users.username', 'plans.plans_name')->join('users', 'users.id', '=', 'subscriptions.user_id')
                    ->join('plans', 'plans.plan_id', '=', 'subscriptions.stripe_plan')
                    ->where('subscriptions.countryname', '=', $query)->paginate(9);

                // echo "<pre>"; print_r($data);exit();
                
            }
            else
            {
                $data = [];
            }
            $i = 1;
            if(count($data) > 0){
            $total_row = $data->count();
            if ($total_row > 0)
            {
                foreach ($data as $row)
                {
                    $output .= '
        <tr>
        <td>' . $i++ . '</td>
        <td>' . $row->username . '</td>
         <td>' . $row->plans_name . '</td>
        </tr>
        ';
                }
            }
            else
            {
                $output = '
       <tr>
        <td align="center" colspan="5">No Data Found</td>
       </tr>
       ';
            }
            $data = array(
                'table_data' => $output,
                'total_data' => $total_row
            );

            echo json_encode($data);
        }
    }
    }

    public function PlanAllCity(Request $request)
    {
        if ($request->ajax())
        {

            $output = '';
            $query = $request->get('query');

            if ($query != '')
            {

                $data = Subscription::select('users.username', 'plans.plans_name')->join('users', 'users.id', '=', 'subscriptions.user_id')
                    ->join('plans', 'plans.plan_id', '=', 'subscriptions.stripe_plan')
                    ->paginate(9);

            }
            else
            {
                $data = [];

            }
            $i = 1;
            if(count($data) > 0){
            $total_row = $data->count();
            if ($total_row > 0)
            {
                foreach ($data as $row)
                {
                    $output .= '
        <tr>
        <td>' . $i++ . '</td>
        <td>' . $row->username . '</td>
         <td>' . $row->plans_name . '</td>
        </tr>
        ';
                }
            }
            else
            {
                $output = '
       <tr>
        <td align="center" colspan="5">No Data Found</td>
       </tr>
       ';
            }
            $data = array(
                'table_data' => $output,
                'total_data' => $total_row
            );

            echo json_encode($data);
        }
    }
    }

    public function PlanAllCountry(Request $request)
    {
        if ($request->ajax())
        {

            $output = '';
            $query = $request->get('query');

            if ($query != '')
            {

                $data = Subscription::select('users.username', 'plans.plans_name')->join('users', 'users.id', '=', 'subscriptions.user_id')
                    ->join('plans', 'plans.plan_id', '=', 'subscriptions.stripe_plan')
                    ->paginate(9);

            }
            else
            {
                $data = [];

            }
            $i = 1;
            if(count($data) > 0){
            $total_row = $data->count();
            if ($total_row > 0)
            {
                foreach ($data as $row)
                {
                    $output .= '
        <tr>
        <td>' . $i++ . '</td>
        <td>' . $row->username . '</td>
         <td>' . $row->plans_name . '</td>
        </tr>
        ';
                }
            }
            else
            {
                $output = '
       <tr>
        <td align="center" colspan="5">No Data Found</td>
       </tr>
       ';
            }
            $data = array(
                'table_data' => $output,
                'total_data' => $total_row
            );

            echo json_encode($data);
        }
        }
    }

    public function PlanState(Request $request)
    {
        if ($request->ajax())
        {

            $output = '';
            $query = $request->get('query');

            if ($query != '')
            {
                $data = Subscription::select('users.username', 'plans.plans_name')->join('users', 'users.id', '=', 'subscriptions.user_id')
                    ->join('plans', 'plans.plan_id', '=', 'subscriptions.stripe_plan')
                // ->where('subscriptions.regionname','=',$query)
                
                    ->paginate(9);
                // echo "<pre>"; print_r($data);exit();
                
            }
            else
            {
                $data = [];

            }
            $i = 1;
            if(count($data) > 0){
            $total_row = $data->count();
            if ($total_row > 0)
            {
                foreach ($data as $row)
                {
                    $output .= '
        <tr>
        <td>' . $i++ . '</td>
        <td>' . $row->username . '</td>
         <td>' . $row->plans_name . '</td>
        </tr>
        ';
                }
            }
            else
            {
                $output = '
       <tr>
        <td align="center" colspan="5">No Data Found</td>
       </tr>
       ';
            }
            $data = array(
                'table_data' => $output,
                'total_data' => $total_row
            );

            echo json_encode($data);
        }
    }
    }

    public function PlanCity(Request $request)
    {
        if ($request->ajax())
        {

            $output = '';
            $query = $request->get('query');

            if ($query != '')
            {
                $data = Subscription::select('users.username', 'plans.plans_name')->join('users', 'users.id', '=', 'subscriptions.user_id')
                    ->join('plans', 'plans.plan_id', '=', 'subscriptions.stripe_plan')
                    ->where('subscriptions.cityname', '=', $query)->paginate(9);
                // echo "<pre>"; print_r($data);exit();
                
            }
            else
            {
                $data = [];
            }
            $i = 1;
            if(count($data) > 0){
            $total_row = $data->count();
            if ($total_row > 0)
            {
                foreach ($data as $row)
                {
                    $output .= '
        <tr>
        <td>' . $i++ . '</td>
        <td>' . $row->username . '</td>
         <td>' . $row->plans_name . '</td>
        </tr>
        ';
                }
            }
            else
            {
                $output = '
       <tr>
        <td align="center" colspan="5">No Data Found</td>
       </tr>
       ';
            }
            $data = array(
                'table_data' => $output,
                'total_data' => $total_row
            );

            echo json_encode($data);
        }
    }
    }

    public function profilePreference(Request $request)
    {
        $data = $request->all();
        $id = $data['user_id'];
        $preference = User::find($id);

        if (!empty($data['preference_language']))
        {
            $preference_language = json_encode($data['preference_language']);
            $preference->preference_language = $preference_language;
        }
        if (!empty($data['preference_genres']))
        {
            $preference_genres = json_encode($data['preference_genres']);
            $preference->preference_genres = $preference_genres;
        }
        $preference->save();

        return Redirect::to('/myprofile')
            ->with(array(
            'message' => 'Successfully Created Preference',
            'note_type' => 'success'
        ));

    }
 public function myprofile()
    {

        $Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses($Theme);

        if (Auth::guest())
        {
            return redirect('/login');
        }
        $data = Session::all();

        // $session_password = $data['password_hash'];
        if (empty($data['password_hash']))
        {
            $system_settings = SystemSetting::first();

            return Theme::view('auth.login', compact('system_settings'));
            
        }
        else
        {

            $user_id = Auth::user()->id;
            $user_role = Auth::user()->role;
            $alldevices = LoggedDevice::where('user_id', '=', Auth::User()->id)
                ->get();

            if ($user_role == 'registered' || $user_role == 'admin')
            {
                $role_plan = $user_role;
                $plans = "";
                $devices_name = "";

            }
            elseif ($user_role == 'subscriber')
            {

                $user_role = Subscription::select('subscription_plans.*')->join('subscription_plans', 'subscription_plans.plan_id', '=', 'subscriptions.stripe_plan')
                    ->where('subscriptions.user_id', $user_id)->orderBy('created_at', 'DESC')
                    ->get();
                //     SELECT
                // subscription_plans.* FROM subscriptions INNER JOIN subscription_plans ON
                // subscriptions.stripe_plan = subscription_plans.plan_id
                // WHERE subscriptions.user_id = 601
                

                if (!empty($user_role[0]))
                {
                    $role_plan = $user_role[0]->plans_name;
                    $plans = SubscriptionPlan::where('plans_name', $role_plan)->first();
                    $devices = Devices::all();
                    $permission = $plans->devices;
                    $user_devices = explode(",", $permission);
                }
                else
                {
                    $role_plan = "No Plan";
                    $plans = "";
                }

                if (!empty($plans->devices))
                {
                    foreach ($devices as $key => $value)
                    {
                        if (in_array($value->id, $user_devices))
                        {
                            $devices_name[] = $value->devices_name;
                        }
                    }
                    $plan_devices = implode(",", $devices_name);
                    if (!empty($plan_devices))
                    {
                        $devices_name = $plan_devices;
                    }
                    else
                    {
                        $devices_name = "";
                    }
                }
                else
                {
                    $devices_name = "";
                }

            }
            $user_role = Auth::user()->role;

            $user_details = User::find($user_id);
            $recent_videos = RecentView::orderBy('id', 'desc')->take(10)
                ->get();
            $recent_view = $recent_videos->unique('video_id');


            foreach ($recent_view as $key => $value)
            {
                $videos[] = Video::Where('id', '=', $value->video_id)
                    ->take(10)
                    ->get();
            }


            // $recent_view = $videos->unique('slug');
            $videocategory = VideoCategory::all();
            $language = Language::all();

         // Multiuser profile details
            $Multiuser = Session::get('subuser_id');

            if ($Multiuser != null)
            {
                $users = Multiprofile::where('id', $Multiuser)->pluck('id')
                    ->first();
                $profile_details = Multiprofile::where('id', $users)->get();
            }
            else
            {
                $users = User::where('id', Auth::user()->id)
                    ->pluck('id')
                    ->first();
                $profile_details = Multiprofile::where('parent_id', $users)->get();
            }

            if (!empty($videos))
            {
                $video = array_unique($videos);
            }
            else
            {
                $video = [];
            }
            $data = array(
                'videos' => $video,
                'videocategory' => $videocategory,
                'plans' => $plans,
                'devices_name' => $devices_name,
                'user' => $user_details,
                'role_plan' => $role_plan,
                'user_role' => $user_role,
                'post_route' => URL::to('/profile/update') ,
                'language' => $language,
                'profile_details' => $profile_details,
                'Multiuser' => $Multiuser,
                'alldevices' => $alldevices,
            );

            return Theme::view('myprofile', $data);
        }
    }
    
    public function Splash_edit(Request $request, $id)
    {

        $Splash = MobileApp::where('id', $id)->first();
        $allCategories = MobileSlider::all();

        $data = array(
            'admin_user' => Auth::user() ,
            'Splash' => $Splash,
            'allCategories' => $allCategories
        );

        return View::make('admin.mobile.splashEdit', $data);

    }

    public function Splash_update(Request $request, $id)
    {
        $input = $request->all();
        $Splash = MobileApp::find($id);

        if ($request->file('splash_image'))
        {
            $path = public_path() . '/uploads/settings/';
            $splash_image = $request['splash_image'];
            $file = $splash_image;
            $input['splash_image'] = $file->getClientOriginalName();
            $file->move($path, $input['splash_image']);

            $Splash->splash_image = $input['splash_image'];
        }
        $Splash->save();

        return Redirect::to('admin/mobileapp')
            ->with(array(
            'message' => 'Successfully updated!',
            'note_type' => 'success'
        ));
    }

    public function Splash_destroy($id)
    {
        $Splash = MobileApp::find($id);
        $Splash->delete();
        return Redirect::to('admin/mobileapp')
            ->with(array(
            'message' => 'Successfully deleted!',
            'note_type' => 'success'
        ));
    }


    public function UserRevenue()
    {
        $user =  User::where('id',1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');
        if ($current_date > $duedate)
        {
            $client = new Client();
            $url = "https://flicknexs.com/userapi/allplans";
            $params = [
                'userid' => 0,
            ];
    
            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ'
            ];
            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify'  => false,
            ]);
    
            $responseBody = json_decode($response->getBody());
           $settings = Setting::first();
           $data = array(
            'settings' => $settings,
            'responseBody' => $responseBody,
    );
            return View::make('admin.expired_dashboard', $data);
        }else{
        $settings = Setting::first();
        $ppv_Revenue = User::join('ppv_purchases', 'users.id', '=', 'ppv_purchases.user_id')
        ->leftjoin('videos', 'videos.id', '=', 'ppv_purchases.video_id')
        ->leftjoin('audio', 'audio.id', '=', 'ppv_purchases.audio_id')
        ->leftjoin('live_streams', 'live_streams.id', '=', 'ppv_purchases.live_id')
        ->leftjoin('subscriptions', 'subscriptions.user_id', '=', 'users.id')
        ->leftjoin('subscription_plans', 'subscription_plans.plan_id', '=', 'subscriptions.stripe_plan')
        ->groupBy('ppv_purchases.user_id')
        ->orderBy('ppv_purchases.created_at')
        ->get(['ppv_purchases.user_id','users.username','users.stripe_id',
         'subscription_plans.plans_name', 'users.role','users.card_type',
         DB::raw('sum(ppv_purchases.total_amount) as count') ,
         \DB::raw("MONTHNAME(ppv_purchases.created_at) as month_name") ,
         DB::raw('COUNT(ppv_purchases.audio_id) as audio_count') , 
         \DB::raw("COUNT(ppv_purchases.video_id) as videos_count"),
         \DB::raw("COUNT(ppv_purchases.live_id) as live_count")
        ]);
        $user_Revenue = User::join('ppv_purchases', 'users.id', '=', 'ppv_purchases.user_id')
        ->leftjoin('videos', 'videos.id', '=', 'ppv_purchases.video_id')
        ->leftjoin('audio', 'audio.id', '=', 'ppv_purchases.audio_id')
        ->leftjoin('live_streams', 'live_streams.id', '=', 'ppv_purchases.live_id')
        ->leftjoin('subscriptions', 'subscriptions.user_id', '=', 'users.id')
        ->leftjoin('subscription_plans', 'subscription_plans.plan_id', '=', 'subscriptions.stripe_plan')
        ->get(['ppv_purchases.user_id','users.username','users.stripe_id','users.card_type','users.ccode',
        'subscription_plans.plans_name', 'users.role','ppv_purchases.total_amount','ppv_purchases.created_at',
        'ppv_purchases.audio_id','ppv_purchases.video_id','ppv_purchases.live_id',
         \DB::raw("MONTHNAME(ppv_purchases.created_at) as month_name") ,
        ]);
        $subscriber_Revenue = User::join('subscriptions', 'subscriptions.user_id', '=', 'users.id')
        ->join('subscription_plans', 'subscription_plans.plan_id', '=', 'subscriptions.stripe_plan')
        ->get(['users.username','users.stripe_id','users.card_type','users.ccode', 'subscription_plans.price as total_amount',
        'subscription_plans.plans_name', 'users.role','subscriptions.created_at',
         \DB::raw("MONTHNAME(subscriptions.created_at) as month_name") ,
         
        ]);
        $usersubscriber_Revenue = User::join('subscriptions', 'subscriptions.user_id', '=', 'users.id')
        ->join('subscription_plans', 'subscription_plans.plan_id', '=', 'subscriptions.stripe_plan')
        ->get(['users.username','users.stripe_id','users.card_type','users.ccode', 'subscription_plans.price as total_amount',
        'subscription_plans.plans_name', 'users.role','subscriptions.created_at',
         \DB::raw("MONTHNAME(subscriptions.created_at) as month_name") ,
        \DB::raw('(subscription_plans.price) as count') ,
        ]);


        $data = array(
            'settings' => $settings,
            'user_Revenue' => $user_Revenue,
            'ppv_Revenue' => $ppv_Revenue,
            'subscriber_Revenue' => $subscriber_Revenue,
            'usersubscriber_Revenue' => $usersubscriber_Revenue,


        );
        return view('admin.analytics.users_revenue_analytics', $data);
    }
}





    public function PayPerviewRevenue()
    {
        $user =  User::where('id',1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');
        if ($current_date > $duedate)
        {
            $client = new Client();
            $url = "https://flicknexs.com/userapi/allplans";
            $params = [
                'userid' => 0,
            ];
    
            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ'
            ];
            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify'  => false,
            ]);
    
            $responseBody = json_decode($response->getBody());
           $settings = Setting::first();
           $data = array(
            'settings' => $settings,
            'responseBody' => $responseBody,
    );
            return View::make('admin.expired_dashboard', $data);
        }else{
        $settings = Setting::first();
        $ppv_Revenue = User::join('ppv_purchases', 'users.id', '=', 'ppv_purchases.user_id')
        ->groupBy('ppv_purchases.user_id')
        ->orderBy('ppv_purchases.created_at')
        ->get([
        'ppv_purchases.user_id',
         DB::raw('sum(ppv_purchases.total_amount) as count') ,
         \DB::raw("MONTHNAME(ppv_purchases.created_at) as month_name") ,
        ]);
        foreach($ppv_Revenue as $d) {
            if($d->count != null){
            $ppv_Revenues[$d->month_name] = $d->count;
            }else{
            $ppv_Revenues[$d->month_name] =  0;
            }
        }
        $user_Revenue = User::join('ppv_purchases', 'users.id', '=', 'ppv_purchases.user_id')
        ->leftjoin('videos', 'videos.id', '=', 'ppv_purchases.video_id')
        ->leftjoin('audio', 'audio.id', '=', 'ppv_purchases.audio_id')
        ->leftjoin('live_streams', 'live_streams.id', '=', 'ppv_purchases.live_id')
        ->leftjoin('subscriptions', 'subscriptions.user_id', '=', 'users.id')
        ->leftjoin('subscription_plans', 'subscription_plans.plan_id', '=', 'subscriptions.stripe_plan')
        ->get(['ppv_purchases.user_id','users.username','users.stripe_id','users.card_type','users.ccode',
        'subscription_plans.plans_name', 'users.role','ppv_purchases.total_amount','ppv_purchases.created_at',
        'ppv_purchases.audio_id','ppv_purchases.video_id','ppv_purchases.live_id',
         \DB::raw("MONTHNAME(ppv_purchases.created_at) as month_name") ,
        ]);
        $subscriber_Revenue = User::join('subscriptions', 'subscriptions.user_id', '=', 'users.id')
        ->join('subscription_plans', 'subscription_plans.plan_id', '=', 'subscriptions.stripe_plan')
        ->get(['users.username','users.stripe_id','users.card_type','users.ccode', 'subscription_plans.price as total_amount',
        'subscription_plans.plans_name', 'users.role','subscriptions.created_at',
         \DB::raw("MONTHNAME(subscriptions.created_at) as month_name") ,
         
        ]);
        $usersubscriber_Revenue = User::join('subscriptions', 'subscriptions.user_id', '=', 'users.id')
        ->join('subscription_plans', 'subscription_plans.plan_id', '=', 'subscriptions.stripe_plan')
        ->get(['users.username','users.stripe_id','users.card_type','users.ccode', 'subscription_plans.price as total_amount',
        'subscription_plans.plans_name', 'users.role','subscriptions.created_at',
         \DB::raw("MONTHNAME(subscriptions.created_at) as month_name") ,
        \DB::raw('(subscription_plans.price) as count') ,
        ]);
        // dd($usersubscriber_Revenue);



        $data = array(
            'settings' => $settings,
            'user_Revenue' => $user_Revenue,
            'ppv_Revenue' => $ppv_Revenues,
            'subscriber_Revenue' => $subscriber_Revenue,
            'usersubscriber_Revenue' => $usersubscriber_Revenue,


        );
        return view('admin.analytics.payperview', $data);
    }
}
    // Subscriber Revenue system 

    public function SubscriberRevenueStartDateRecord(Request $request)
    {
        // 2022-04-01
        $data = $request->all();

        $start_time = $data['start_time'];
        $end_time = $data['end_time'];
        if (!empty($start_time) && empty($end_time))
        {

            $subscriber_Revenue = User::join('subscriptions', 'subscriptions.user_id', '=', 'users.id')
            ->join('subscription_plans', 'subscription_plans.plan_id', '=', 'subscriptions.stripe_plan')
            ->whereDate('subscriptions.created_at', '>=', $start_time)->groupBy('month_name')
            ->get(['users.username','users.stripe_id','users.card_type','users.ccode', 'subscription_plans.price as total_amount',
            'subscription_plans.plans_name', 'users.role','subscriptions.created_at',
             \DB::raw("MONTHNAME(subscriptions.created_at) as month_name") ,
             
            ]);
            $usersubscriber_Revenue = User::join('subscriptions', 'subscriptions.user_id', '=', 'users.id')
            ->join('subscription_plans', 'subscription_plans.plan_id', '=', 'subscriptions.stripe_plan')
            ->whereDate('subscriptions.created_at', '>=', $start_time)->groupBy('month_name')
            ->get(['users.username','users.stripe_id','users.card_type','users.ccode', 'subscription_plans.price as total_amount',
            'subscription_plans.plans_name', 'users.role','subscriptions.created_at',
             \DB::raw("MONTHNAME(subscriptions.created_at) as month_name") ,
            \DB::raw('(subscription_plans.price) as count') ,
            ]);


        }

        $output = '';
        $i = 1;

        $total_row = $subscriber_Revenue->count();
        if (!empty($subscriber_Revenue))
        {
            foreach ($subscriber_Revenue as $key => $row)
            {
                if(!empty($row->stripe_id))  { $stripe_id = $row->stripe_id; } else { $stripe_id = 'No REF'; }
                if(!empty($row->plans_name))  { $plans_name = $row->plans_name ; } else { $plans_name ="Registered";}
                 if(!empty($row->audio_id) ){ $Content = 'Audio' ;}elseif(!empty($row->video_id) ){ $Content =  'Video' ;}elseif(!empty($row->live_id) ){ $Content =  'Live' ;}else{ $Content =  'All Content';}
                 if(@$row->phoneccode->phonecode == $row->ccode)  { $country_name = @$row->phoneccode->country_name ;} else { $country_name = "No Country Added" ;}
                 if(!empty($row->card_type))  { $card_type = @$row->card_type ;} else { $card_type = "No Transaction"; }
                 
                 $output .= '
               <tr>
               <td>' . $i++ . '</td>
               <td>' . $row->username . '</td>
               <td>' . $stripe_id . '</td>
               <td>' . $row->role . '</td>    
               <td>' . $plans_name . '</td>    
               <td>' . $Content . '</td>    
               <td>' . $row->total_amount . '</td>  
               <td>' . $country_name . '</td>    
               <td>' . $row->created_at . '</td>    
               <td>' . $card_type . '</td>    
   
              </tr>
              ';

            }
        }
        else
        {
            $output = '
          <tr>
           <td align="center" colspan="5">No Data Found</td>
          </tr>
          ';
        }
        $value = array(
            'table_data' => $output,
            'total_data' => $total_row,
            'total_Revenue' => $usersubscriber_Revenue,

        );

        return $value;

    }

    public function SubscriberRevenueStartEndDateRecord(Request $request)
    {

        $data = $request->all();

        $start_time = $data['start_time'];
        $end_time = $data['end_time'];

        if (!empty($start_time) && !empty($end_time))
        {

            $subscriber_Revenue = User::join('subscriptions', 'subscriptions.user_id', '=', 'users.id')
            ->join('subscription_plans', 'subscription_plans.plan_id', '=', 'subscriptions.stripe_plan')
            ->whereBetween('subscriptions.created_at', [$start_time, $end_time])->groupBy('month_name')
            ->get(['users.username','users.stripe_id','users.card_type','users.ccode', 'subscription_plans.price as total_amount',
            'subscription_plans.plans_name', 'users.role','subscriptions.created_at',
             \DB::raw("MONTHNAME(subscriptions.created_at) as month_name") ,
             
            ]);
           
        $usersubscriber_Revenue = User::join('subscriptions', 'subscriptions.user_id', '=', 'users.id')
        ->join('subscription_plans', 'subscription_plans.plan_id', '=', 'subscriptions.stripe_plan')
        ->whereBetween('subscriptions.created_at', [$start_time, $end_time])->groupBy('month_name')
        ->get(['users.username','users.stripe_id','users.card_type','users.ccode', 'subscription_plans.price as total_amount',
        'subscription_plans.plans_name', 'users.role','subscriptions.created_at',
         \DB::raw("MONTHNAME(subscriptions.created_at) as month_name") ,
        \DB::raw('(subscription_plans.price) as count') ,
        ]);
           
        }

        $output = '';
        $i = 1;

        $total_row = $subscriber_Revenue->count();
        if (!empty($subscriber_Revenue))
        {
            foreach ($subscriber_Revenue as $key => $row)
            {
                if(!empty($row->stripe_id))  { $stripe_id = $row->stripe_id; } else { $stripe_id = 'No REF'; }
               if(!empty($row->plans_name))  { $plans_name = $row->plans_name ; } else { $plans_name ="Registered";}
                if(!empty($row->audio_id) ){ $Content = 'Audio' ;}elseif(!empty($row->video_id) ){ $Content =  'Video' ;}elseif(!empty($row->live_id) ){ $Content =  'Live' ;}else{ $Content =  'All Content';}
                if(@$row->phoneccode->phonecode == $row->ccode)  { $country_name = @$row->phoneccode->country_name ;} else { $country_name = "No Country Added" ;}
                if(!empty($row->card_type))  { $card_type = @$row->card_type ;} else { $card_type = "No Transaction"; }
                
                $output .= '
              <tr>
              <td>' . $i++ . '</td>
              <td>' . $row->username . '</td>
              <td>' . $stripe_id . '</td>
              <td>' . $row->role . '</td>    
              <td>' . $plans_name . '</td>    
              <td>' . $Content . '</td>    
              <td>' . $row->total_amount . '</td>  
              <td>' . $country_name . '</td>    
              <td>' . $row->created_at . '</td>    
              <td>' . $card_type . '</td>    

              </tr>
              ';

            }
        }
        else
        {
            $output = '
          <tr>
           <td align="center" colspan="5">No Data Found</td>
          </tr>
          ';
        }
        $value = array(
            'table_data' => $output,
            'total_data' => $total_row,
            'total_Revenue' => $usersubscriber_Revenue,
        );

        return $value;
    }




    public function UserSubscriberExportCsv(Request $request)
    {

        $data = $request->all();
        $start_time = $data['start_time'];
        $end_time = $data['end_time'];
        if (!empty($start_time) && empty($end_time))
        {
            $subscriber_Revenue = User::join('subscriptions', 'subscriptions.user_id', '=', 'users.id')
            ->join('subscription_plans', 'subscription_plans.plan_id', '=', 'subscriptions.stripe_plan')
            ->whereDate('subscriptions.created_at', '>=', $start_time)->groupBy('month_name')
            ->get(['users.username','users.stripe_id','users.card_type','users.ccode', 'subscription_plans.price as total_amount',
            'subscription_plans.plans_name', 'users.role','subscriptions.created_at',
             \DB::raw("MONTHNAME(subscriptions.created_at) as month_name") ,
             
            ]);
           
        }
        elseif (!empty($start_time) && !empty($end_time))
        {
            $subscriber_Revenue = User::join('subscriptions', 'subscriptions.user_id', '=', 'users.id')
            ->join('subscription_plans', 'subscription_plans.plan_id', '=', 'subscriptions.stripe_plan')
            ->whereBetween('subscriptions.created_at', [$start_time, $end_time])->groupBy('month_name')
            ->get(['users.username','users.stripe_id','users.card_type','users.ccode', 'subscription_plans.price as total_amount',
            'subscription_plans.plans_name', 'users.role','subscriptions.created_at',
             \DB::raw("MONTHNAME(subscriptions.created_at) as month_name") ,
             
            ]);

        }
        else
        {
            $subscriber_Revenue = User::join('subscriptions', 'subscriptions.user_id', '=', 'users.id')
            ->join('subscription_plans', 'subscription_plans.plan_id', '=', 'subscriptions.stripe_plan')
            ->get(['users.username','users.stripe_id','users.card_type','users.ccode', 'subscription_plans.price as total_amount',
            'subscription_plans.plans_name', 'users.role','subscriptions.created_at',
             \DB::raw("MONTHNAME(subscriptions.created_at) as month_name") ,
             
            ]);

           
        }
        //  $file = 'CPPRevenue_' . rand(10, 100000) . '.csv';
        $file = 'SubscriberRevenue.csv';

        $headers = array(
            'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-Disposition' => 'attachment; filename=download.csv',
            'Expires' => '0',
            'Pragma' => 'public',
        );
        if (!File::exists(public_path() . "/uploads/csv"))
        {
            File::makeDirectory(public_path() . "/uploads/csv");
        }
        $filename = public_path("/uploads/csv/" . $file);
        $handle = fopen($filename, 'w');
        fputcsv($handle, ["User", "Transaction REF", "User Type", "Plan", "Content", "Price", "Country", "Date Time", "Source",]);
        if (count($subscriber_Revenue) > 0)
        {
            foreach ($subscriber_Revenue as $each_user)
            {
                if(!empty($each_user->stripe_id))  { $stripe_id = $each_user->stripe_id; } else { $stripe_id = 'No REF'; }
                if(!empty($each_user->plans_name))  { $plans_name = $each_user->plans_name ; } else { $plans_name ="Registered";}
                 if(!empty($each_user->audio_id) ){ $Content = 'Audio' ;}elseif(!empty($each_user->video_id) ){ $Content =  'Video' ;}elseif(!empty($each_user->live_id) ){ $Content =  'Live' ;}else{$Content =  'All Content' ;}
                 if(@$each_user->phoneccode->phonecode == $each_user->ccode)  { $country_name = @$each_user->phoneccode->country_name ;} else { $country_name = "No Country Added" ;}
                 if(!empty($each_user->card_type))  { $card_type = @$each_user->card_type ;} else { $card_type = "No Transaction"; }

                fputcsv($handle, ['#',$each_user->username, $stripe_id, $each_user->role, $plans_name
                , $Content, $each_user->total_amount, $country_name, $each_user->created_at,$card_type,
                ]);
            }
        }

        fclose($handle);

        \Response::download($filename, "download.csv", $headers);

        return $file;
    }


    public function PayPerviewRevenueStartDateRecord(Request $request)
    {
        // 2022-04-01
        $data = $request->all();

        $start_time = $data['start_time'];
        $end_time = $data['end_time'];
        if (!empty($start_time) && empty($end_time))
        {
            $ppv_Revenue = User::join('ppv_purchases', 'users.id', '=', 'ppv_purchases.user_id')
        ->leftjoin('videos', 'videos.id', '=', 'ppv_purchases.video_id')
        ->leftjoin('audio', 'audio.id', '=', 'ppv_purchases.audio_id')
        ->leftjoin('live_streams', 'live_streams.id', '=', 'ppv_purchases.live_id')
        ->leftjoin('subscriptions', 'subscriptions.user_id', '=', 'users.id')
        ->leftjoin('subscription_plans', 'subscription_plans.plan_id', '=', 'subscriptions.stripe_plan')
        ->whereDate('ppv_purchases.created_at', '>=', $start_time)->groupBy('month_name')
        ->groupBy('ppv_purchases.user_id')
        ->orderBy('ppv_purchases.created_at')
        ->get(['ppv_purchases.user_id','users.username','users.stripe_id',
         'subscription_plans.plans_name', 'users.role','users.card_type',
         DB::raw('sum(ppv_purchases.total_amount) as count') ,
         \DB::raw("MONTHNAME(ppv_purchases.created_at) as month_name") ,
         DB::raw('COUNT(ppv_purchases.audio_id) as audio_count') , 
         \DB::raw("COUNT(ppv_purchases.video_id) as videos_count"),
         \DB::raw("COUNT(ppv_purchases.live_id) as live_count")
        ]);
        $user_Revenue = User::join('ppv_purchases', 'users.id', '=', 'ppv_purchases.user_id')
        ->leftjoin('videos', 'videos.id', '=', 'ppv_purchases.video_id')
        ->leftjoin('audio', 'audio.id', '=', 'ppv_purchases.audio_id')
        ->leftjoin('live_streams', 'live_streams.id', '=', 'ppv_purchases.live_id')
        ->leftjoin('subscriptions', 'subscriptions.user_id', '=', 'users.id')
        ->leftjoin('subscription_plans', 'subscription_plans.plan_id', '=', 'subscriptions.stripe_plan')
        ->whereDate('ppv_purchases.created_at', '>=', $start_time)->groupBy('month_name')
        ->get(['ppv_purchases.user_id','users.username','users.stripe_id','users.card_type','users.ccode',
        'subscription_plans.plans_name', 'users.role','ppv_purchases.total_amount','ppv_purchases.created_at',
        'ppv_purchases.audio_id','ppv_purchases.video_id','ppv_purchases.live_id',
         \DB::raw("MONTHNAME(ppv_purchases.created_at) as month_name") ,
         
        ]);


        }

        $output = '';
        $i = 1;

        $total_row = $user_Revenue->count();
        if (!empty($user_Revenue))
        {
            foreach ($user_Revenue as $key => $row)
            {
                if(!empty($row->stripe_id))  { $stripe_id = $row->stripe_id; } else { $stripe_id = 'No REF'; }
                if(!empty($row->plans_name))  { $plans_name = $row->plans_name ; } else { $plans_name ="Registered";}
                 if(!empty($row->audio_id) ){ $Content = 'Audio' ;}elseif(!empty($row->video_id) ){ $Content =  'Video' ;}elseif(!empty($row->live_id) ){ $Content =  'Live' ;}else{ $Content =  'All Content';}
                 if(@$row->phoneccode->phonecode == $row->ccode)  { $country_name = @$row->phoneccode->country_name ;} else { $country_name = "No Country Added" ;}
                 if(!empty($row->card_type))  { $card_type = @$row->card_type ;} else { $card_type = "No Transaction"; }
                 
                 $output .= '
               <tr>
               <td>' . $i++ . '</td>
               <td>' . $row->username . '</td>
               <td>' . $stripe_id . '</td>
               <td>' . $row->role . '</td>    
               <td>' . $plans_name . '</td>    
               <td>' . $Content . '</td>    
               <td>' . $row->total_amount . '</td>  
               <td>' . $country_name . '</td>    
               <td>' . $row->created_at . '</td>    
               <td>' . $card_type . '</td>    
   
              </tr>
              ';

            }
        }
        else
        {
            $output = '
          <tr>
           <td align="center" colspan="5">No Data Found</td>
          </tr>
          ';
        }
        $value = array(
            'tabledata' => $output,
            'totaldata' => $total_row,
            'ppv_Revenue' => $ppv_Revenue,

        );

        return $value;

    }

    public function PayPerviewRevenueStartEndDateRecord(Request $request)
    {

        $data = $request->all();

        $start_time = $data['start_time'];
        $end_time = $data['end_time'];

        if (!empty($start_time) && !empty($end_time))
        {
            $ppv_Revenue = User::join('ppv_purchases', 'users.id', '=', 'ppv_purchases.user_id')
        ->leftjoin('videos', 'videos.id', '=', 'ppv_purchases.video_id')
        ->leftjoin('audio', 'audio.id', '=', 'ppv_purchases.audio_id')
        ->leftjoin('live_streams', 'live_streams.id', '=', 'ppv_purchases.live_id')
        ->leftjoin('subscriptions', 'subscriptions.user_id', '=', 'users.id')
        ->leftjoin('subscription_plans', 'subscription_plans.plan_id', '=', 'subscriptions.stripe_plan')
        ->whereBetween('ppv_purchases.created_at', [$start_time, $end_time])->groupBy('month_name')
        ->groupBy('ppv_purchases.user_id')
        ->orderBy('ppv_purchases.created_at')
        ->get(['ppv_purchases.user_id','users.username','users.stripe_id',
         'subscription_plans.plans_name', 'users.role','users.card_type',
         DB::raw('sum(ppv_purchases.total_amount) as count') ,
         \DB::raw("MONTHNAME(ppv_purchases.created_at) as month_name") ,
         DB::raw('COUNT(ppv_purchases.audio_id) as audio_count') , 
         \DB::raw("COUNT(ppv_purchases.video_id) as videos_count"),
         \DB::raw("COUNT(ppv_purchases.live_id) as live_count")
        ]);
        $user_Revenue = User::join('ppv_purchases', 'users.id', '=', 'ppv_purchases.user_id')
        ->leftjoin('videos', 'videos.id', '=', 'ppv_purchases.video_id')
        ->leftjoin('audio', 'audio.id', '=', 'ppv_purchases.audio_id')
        ->leftjoin('live_streams', 'live_streams.id', '=', 'ppv_purchases.live_id')
        ->leftjoin('subscriptions', 'subscriptions.user_id', '=', 'users.id')
        ->leftjoin('subscription_plans', 'subscription_plans.plan_id', '=', 'subscriptions.stripe_plan')
        ->whereBetween('ppv_purchases.created_at', [$start_time, $end_time])->groupBy('month_name')
        ->get(['ppv_purchases.user_id','users.username','users.stripe_id','users.card_type','users.ccode',
        'subscription_plans.plans_name', 'users.role','ppv_purchases.total_amount','ppv_purchases.created_at',
        'ppv_purchases.audio_id','ppv_purchases.video_id','ppv_purchases.live_id',
         \DB::raw("MONTHNAME(ppv_purchases.created_at) as month_name") ,
         
        ]);
        
           
        }

        $output = '';
        $i = 1;

        $total_row = $user_Revenue->count();
        if (!empty($user_Revenue))
        {
            foreach ($user_Revenue as $key => $row)
            {
                if(!empty($row->stripe_id))  { $stripe_id = $row->stripe_id; } else { $stripe_id = 'No REF'; }
               if(!empty($row->plans_name))  { $plans_name = $row->plans_name ; } else { $plans_name ="Registered";}
                if(!empty($row->audio_id) ){ $Content = 'Audio' ;}elseif(!empty($row->video_id) ){ $Content =  'Video' ;}elseif(!empty($row->live_id) ){ $Content =  'Live' ;}else{ $Content =  'All Content';}
                if(@$row->phoneccode->phonecode == $row->ccode)  { $country_name = @$row->phoneccode->country_name ;} else { $country_name = "No Country Added" ;}
                if(!empty($row->card_type))  { $card_type = @$row->card_type ;} else { $card_type = "No Transaction"; }
                
                $output .= '
              <tr>
              <td>' . $i++ . '</td>
              <td>' . $row->username . '</td>
              <td>' . $stripe_id . '</td>
              <td>' . $row->role . '</td>    
              <td>' . $plans_name . '</td>    
              <td>' . $Content . '</td>    
              <td>' . $row->total_amount . '</td>  
              <td>' . $country_name . '</td>    
              <td>' . $row->created_at . '</td>    
              <td>' . $card_type . '</td>    

              </tr>
              ';

            }
        }
        else
        {
            $output = '
          <tr>
           <td align="center" colspan="5">No Data Found</td>
          </tr>
          ';
        }
        $value = array(
            'tabledata' => $output,
            'totaldata' => $total_row,
            'ppv_Revenue' => $ppv_Revenue,
        );

        return $value;
    }




    public function PayPerviewRevenueExportCsv(Request $request)
    {

        $data = $request->all();
        $start_time = $data['start_time'];
        $end_time = $data['end_time'];
        if (!empty($start_time) && empty($end_time))
        {
            $user_Revenue = User::join('ppv_purchases', 'users.id', '=', 'ppv_purchases.user_id')
            ->leftjoin('videos', 'videos.id', '=', 'ppv_purchases.video_id')
            ->leftjoin('audio', 'audio.id', '=', 'ppv_purchases.audio_id')
            ->leftjoin('live_streams', 'live_streams.id', '=', 'ppv_purchases.live_id')
            ->leftjoin('subscriptions', 'subscriptions.user_id', '=', 'users.id')
            ->leftjoin('subscription_plans', 'subscription_plans.plan_id', '=', 'subscriptions.stripe_plan')
            ->whereDate('ppv_purchases.created_at', '>=', $start_time)->groupBy('month_name')
            ->get(['ppv_purchases.user_id','users.username','users.stripe_id','users.card_type','users.ccode',
            'subscription_plans.plans_name', 'users.role','ppv_purchases.total_amount','ppv_purchases.created_at',
            'ppv_purchases.audio_id','ppv_purchases.video_id','ppv_purchases.live_id',
             \DB::raw("MONTHNAME(ppv_purchases.created_at) as month_name") ,
             
            ]);
            
            $subscriber_Revenue = User::join('subscriptions', 'subscriptions.user_id', '=', 'users.id')
            ->join('subscription_plans', 'subscription_plans.plan_id', '=', 'subscriptions.stripe_plan')
            ->whereDate('subscriptions.created_at', '>=', $start_time)->groupBy('month_name')
            ->get(['users.username','users.stripe_id','users.card_type','users.ccode', 'subscription_plans.price as total_amount',
            'subscription_plans.plans_name', 'users.role','subscriptions.created_at',
             \DB::raw("MONTHNAME(subscriptions.created_at) as month_name") ,
             
            ]);
           
        }
        elseif (!empty($start_time) && !empty($end_time))
        {
            $user_Revenue = User::join('ppv_purchases', 'users.id', '=', 'ppv_purchases.user_id')
            ->leftjoin('videos', 'videos.id', '=', 'ppv_purchases.video_id')
            ->leftjoin('audio', 'audio.id', '=', 'ppv_purchases.audio_id')
            ->leftjoin('live_streams', 'live_streams.id', '=', 'ppv_purchases.live_id')
            ->leftjoin('subscriptions', 'subscriptions.user_id', '=', 'users.id')
            ->leftjoin('subscription_plans', 'subscription_plans.plan_id', '=', 'subscriptions.stripe_plan')
            ->whereBetween('ppv_purchases.created_at', [$start_time, $end_time])->groupBy('month_name')
            ->get(['ppv_purchases.user_id','users.username','users.stripe_id','users.card_type','users.ccode',
            'subscription_plans.plans_name', 'users.role','ppv_purchases.total_amount','ppv_purchases.created_at',
            'ppv_purchases.audio_id','ppv_purchases.video_id','ppv_purchases.live_id',
             \DB::raw("MONTHNAME(ppv_purchases.created_at) as month_name") ,
             
            ]);
            

        }
        else
        {
            $user_Revenue = User::join('ppv_purchases', 'users.id', '=', 'ppv_purchases.user_id')
            ->leftjoin('videos', 'videos.id', '=', 'ppv_purchases.video_id')
            ->leftjoin('audio', 'audio.id', '=', 'ppv_purchases.audio_id')
            ->leftjoin('live_streams', 'live_streams.id', '=', 'ppv_purchases.live_id')
            ->leftjoin('subscriptions', 'subscriptions.user_id', '=', 'users.id')
            ->leftjoin('subscription_plans', 'subscription_plans.plan_id', '=', 'subscriptions.stripe_plan')
            ->get(['ppv_purchases.user_id','users.username','users.stripe_id','users.card_type','users.ccode',
            'subscription_plans.plans_name', 'users.role','ppv_purchases.total_amount','ppv_purchases.created_at',
            'ppv_purchases.audio_id','ppv_purchases.video_id','ppv_purchases.live_id',
             \DB::raw("MONTHNAME(ppv_purchases.created_at) as month_name") ,
             
            ]);
            

           
        }
        //  $file = 'CPPRevenue_' . rand(10, 100000) . '.csv';
        $file = 'PayPerViewRevenue.csv';

        $headers = array(
            'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-Disposition' => 'attachment; filename=download.csv',
            'Expires' => '0',
            'Pragma' => 'public',
        );
        if (!File::exists(public_path() . "/uploads/csv"))
        {
            File::makeDirectory(public_path() . "/uploads/csv");
        }
        $filename = public_path("/uploads/csv/" . $file);
        $handle = fopen($filename, 'w');
        fputcsv($handle, ["User", "Transaction REF", "User Type", "Plan", "Content", "Price", "Country", "Date Time", "Source",]);
        if (count($user_Revenue) > 0)
        {
            foreach ($user_Revenue as $each_user)
            {
                if(!empty($each_user->stripe_id))  { $stripe_id = $each_user->stripe_id; } else { $stripe_id = 'No REF'; }
                if(!empty($each_user->plans_name))  { $plans_name = $each_user->plans_name ; } else { $plans_name ="Registered";}
                 if(!empty($each_user->audio_id) ){ $Content = 'Audio' ;}elseif(!empty($each_user->video_id) ){ $Content =  'Video' ;}elseif(!empty($each_user->live_id) ){ $Content =  'Live' ;}else{$Content =  'All Content' ;}
                 if(@$each_user->phoneccode->phonecode == $each_user->ccode)  { $country_name = @$each_user->phoneccode->country_name ;} else { $country_name = "No Country Added" ;}
                 if(!empty($each_user->card_type))  { $card_type = @$each_user->card_type ;} else { $card_type = "No Transaction"; }

                fputcsv($handle, ['#',$each_user->username, $stripe_id, $each_user->role, $plans_name
                , $Content, $each_user->total_amount, $country_name, $each_user->created_at,$card_type,
                ]);
            }
        }

        fclose($handle);

        \Response::download($filename, "download.csv", $headers);

        return $file;
    }





}


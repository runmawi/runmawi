<?php
namespace App\Http\Controllers;

use DB;
use App;
use URL;
use Auth;
use File;
use Hash;
use Mail;
use View;
use Flash;
use Image;
use Theme;
use Session;
use Illuminate\Support\Facades\Cache;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DateTime;
use Response;
use \Redirect ;
use App\City;
use App\State;
use App\Region;
use App\Devices;
use App\Language;
use App\UGCVideo;
use App\UserLogs;
use App\Wishlist;
use App\SiteTheme;
use Carbon\Carbon;
use App\RegionView;
use App\Watchlater;
use App\HomeSetting;
use App\PpvPurchase;
use App\TVLoginCode;
use App\LoggedDevice;
use App\Multiprofile;
use App\User ;
use App\EmailTemplate;
use App\WelcomeScreen;
use GuzzleHttp\Client;
use App\TVSplashScreen;
use App\Video;
use App\CurrencySetting;
use App\ContinueWatching;
use App\SubscriptionPlan;
use App\ApprovalMailDevice;
use App\Setting;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use \App\PpvVideo ;
use \App\MobileApp;
use App\RecentView ;
use \App\CountryCode;

use App\Subscription;
use \App\MobileSlider;
use App\SystemSetting;
use App\VideoCategory;
use App\SeriesSeason;
use App\Series;


class AdminUsersController extends Controller
{

    public function index(Request $request)
    {
        if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
            return redirect('/admin/restrict');
        }
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
        }else if(check_storage_exist() == 0){
            $settings = Setting::first();

            $data = array(
                'settings' => $settings,
            );

            return View::make('admin.expired_storage', $data);
        }else{
        $user = $request->user();
        
        $total_subscription = Subscription::where('stripe_status', '=', 'active')->count();
        $total_subscription = Subscription::count();

        $total_videos = Video::where('active', '=', 1)->count();

        $total_ppvvideos = PpvVideo::where('active', '=', 1)->count();

        $total_user_subscription = User::where('role', '=', 'subscriber')->count();

        $total_recent_subscription = Subscription::orderBy('created_at', 'DESC')->whereDate('created_at', '>=', \Carbon\Carbon::now()
            ->today())
            ->count();
            
        $top_rated_videos = Video::where("rating", ">", 7)->get();

        //    $total_revenew = Subscription::all();
        $total_revenew = Subscription::sum('price');

        // Note - users_pagination function used for pagination 
        $allUsers = User::orderBy('created_at', 'desc')->paginate(10);
          
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

    public function users_pagination(Request $request)
    {
        try {

            $query = User::query();

            return DataTables::of($query)

                ->addColumn('select', function ($user) {
                    return '<input type="checkbox" class="user-checkbox" value="' . $user->id . '">';
                })
                ->addColumn('profile', function ($user) {
                    $avatarPath = $user->avatar ? "public/uploads/avatars/{$user->avatar}" : "public/uploads/avatars/default_profile_image.png";
                    return '<img src="' . asset($avatarPath) . '" class="img-fluid avatar-50" alt="author-profile">';
                })
                ->addColumn('status', function ($user) {
                    return $user->active
                        ? '<span class="badge iq-bg-success">Active</span>'
                        : '<span class="badge iq-bg-danger">Deactive</span>';
                })
                ->addColumn('action', function ($user) {
                    $editUrl = route('admin.users.edit', $user->id);
                    $deleteUrl = route('admin.users.destroy', $user->id);
                    $viewUrl = route('admin.users.view', $user->id);

                    return '
                        <div class="d-flex align-items-center list-user-action">
                            <a class="iq-bg-warning" href="' . $viewUrl . '" data-toggle="tooltip" title="View">
                                <img src="' . asset('assets/img/icon/view.svg') . '" class="ply">
                            </a>
                            <a class="iq-bg-success" href="' . $editUrl . '" data-toggle="tooltip" title="Edit">
                                <img src="' . asset('assets/img/icon/edit.svg') . '" class="ply">
                            </a>
                            <a class="iq-bg-danger" href="' . $deleteUrl . '" data-toggle="tooltip" title="Delete" onclick="return confirm(\'Are you sure?\')">
                                <img src="' . asset('assets/img/icon/delete.svg') . '" class="ply">
                            </a>
                           
                        </div>';
                })
                ->rawColumns(['select', 'profile', 'status', 'action','mobile'])
                ->make(true);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
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
        if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
            return redirect('/admin/restrict');
        }
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
        }else if(check_storage_exist() == 0){
            $settings = Setting::first();

            $data = array(
                'settings' => $settings,
            );

            return View::make('admin.expired_storage', $data);
        }else{
        $data = array(
            'post_route' => URL::to('admin/user/store') ,
            'admin_user' => Auth::user() ,
            'button_text' => 'Create User',
            'SubscriptionPlan' => SubscriptionPlan::all(),
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
        $country_name = CountryCode::where('phonecode', '=', $user->ccode)->first();
     
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

        $active = !empty($input['active']) ? 1 : 0  ;

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
                if (file_exists($file_old)) { unlink($file_old);}
            }

            //upload new file
            $file = $logo;
            $input['avatar'] = $file->getClientOriginalName();
            $file->move($path, $input['avatar']);
            $avatar = $file->getClientOriginalName();

        }else{
            $avatar = 'profile.png';
        }
        $string = Str::random(60);

        $password = Hash::make($request['passwords']);

        if($input['role'] == 'subscriber' && !empty($input['plan'])  
        || $input['role'] == 'registered' || $input['role'] == 'admin'){

            $User = new User();
            $User->username = $request['username'];
            $User->email = $request['email'];
            $User->mobile = $request['mobile'];
            $User->ccode = $request['ccode'];
            $User->role = $request['role'];
            $User->activation_code = $string;
            $User->active = $active;
            $User->free_otp_status = !empty($input['free_otp_status']) ? 1 : 0 ;
            $User->otp = !empty($input['free_otp_status']) ? "1234" : null ;
            $User->avatar = $avatar;
            $User->password = $password;
            $User->save();
            $User_id = $User->id;

        }else{

            return Redirect::to('admin/user/create')->with(array(
                'note' => 'Need to Add User',
                'note_type' => 'failed'
            ));
        }

        if($input['role'] == 'subscriber' && !empty($input['plan']) && !empty($User_id)){

            $SubscriptionPlan = SubscriptionPlan::where('plan_id',$input['plan'])->first();

            $current_date = date('Y-m-d h:i:s');    
            $next_date = $SubscriptionPlan->days;
            $date = Carbon::parse($current_date)->addDays($next_date);

            $subscription = new Subscription();
            $subscription->name = $User->username;
            $subscription->price = $SubscriptionPlan->price;
            $subscription->user_id = $User_id;
            $subscription->stripe_id = $SubscriptionPlan->plan_id;
            $subscription->stripe_plan = $SubscriptionPlan->plan_id;
            $subscription->stripe_status  = 'active';
            $subscription->name = $user->username;
            $subscription->days = $SubscriptionPlan->days;
            $subscription->regionname = Region_name();
            $subscription->countryname = Country_name();
            $subscription->cityname = city_name();
            $subscription->PaymentGateway =  $SubscriptionPlan->type;
            $subscription->ends_at = $date;
            $subscription->save();

        }else{
            return Redirect::to('admin/users')->with(array(
                'message' => 'Added User Successfully',
                'note_type' => 'failed'
            ));
        }


        $settings = Setting::first();

        if ($input['role'] == "subscriber")
        {
            try {
                \Mail::send('emails.verify', array(
                    'activation_code' => $string,
                    'website_name' => $settings->website_name
                ) , function ($message) use ($request, $input)
                {
                    $message->to($request->email, $request->name)
                        ->subject('Verify your email address');
                });
            } catch (\Throwable $th) {
                //throw $th;
            }
            
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

        // Welcome on sub-user registration
        $email_subject = EmailTemplate::where('id', '=', 9)->pluck('heading')->first();
       
        $settings = Setting::find(1);

        try {
            Mail::send('emails.sub_user', array(
                /* 'activation_code', $user->activation_code,*/
                'name' => $request['username'],
                'email' => $request['email'],
                'password' => $request['passwords'],
                'parent_name' => Auth::user()->username,
                'Role' => $input['role'] ,
                'website_name' => GetWebsiteName() ,

            ) , function ($message) use ($request, $user, $email_subject, $settings)
            {
                $message->from(AdminMail() , GetWebsiteName());
                $message->to($request['email'], $request['username'])->subject($email_subject);
            });

            $email_log      = 'Mail Sent Successfully from Welcome on sub-user registration E-Mail';
            $email_template = "9";
            $user_id = Auth::user()->id;

            Email_sent_log($user_id,$email_log,$email_template);

        } catch (\Throwable $th) {

            $email_log      = $th->getMessage();
            $email_template = "9";
            $user_id =  Auth::user()->id;
        
            Email_notsent_log($user_id,$email_log,$email_template);
        }
           
        return Redirect::to('admin/users')->with(array(
            'message' => 'Successfully Created New User',
            'note_type' => 'success'
        ));
    }

    public function update(Request $request)
    {

        $validatedData = $request->validate([
            'email' => 'required|max:255|unique:users,email,'.$request->id,
            'id' => 'required|max:255', 
            'username' => 'required|max:255', 
        ]);
        $id = $request['id'];
        $user = User::find($id);
        $input = $request->all();

        $input['email'] = $request['email'];

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
            return Redirect::to('admin/user/create')->with(array( 'note' => 'Successfully Created New User','note_type' => 'failed'));
        }
        else
        {
            $request['email'] = $request['email'];
        }

        $input['terms'] = 1;
        $input['stripe_active'] = 0;
        $input['passwords'] = empty($request['passwords']) ? $user->password : Hash::make($request['passwords']) ;
        $active_status = empty($request['active']) ? "0" : "1" ;

        if($request->hasFile('avatar')){

            $file = $request->avatar;

            if ( $user->avatar != "default_profile_image.png" && File::exists(base_path('public/uploads/avatars/'.$user->avatar))) {
                File::delete(base_path('public/uploads/avatars/'.$user->avatar));
            }

            $filename   = 'user-avatar-'.time().'.'.$file->getClientOriginalExtension();
            Image::make($file)->save(base_path().'/public/uploads/avatars/'.$filename );

            $avatar_image =  $filename ;
        }
        else{
            $avatar_image =  $user->avatar ;
        }

        DB::table('users')->where('id', $id)->update(
            [
                'username'  => $input['username'],
                'email'     => $input['email'],
                'ccode'     => $input['ccode'],
                'mobile'    => $input['mobile'],
                'password'  => $input['passwords'],
                'role'      => $input['role'],
                'active'    => $active_status,
                'free_otp_status' =>  !empty($request['free_otp_status']) ? 1 : 0 , 
                'otp' =>  !empty($request['free_otp_status']) ? "1234" : null , 
                'terms'     => $input['terms'],
                'avatar'    => $avatar_image,
                'stripe_active' => $input['stripe_active'],
                'payment_status'  =>   !empty($input['role']) && $input['role'] == 'subscriber' ? SubscriptionPlan::where('plan_id',$input['plan'])->pluck('type')->first() : null,
            ]);

        $User = User::where('id',$id)->first();

        if($input['role'] == 'subscriber' && !empty($input['plan']) && !empty($id)){

            $SubscriptionPlan = SubscriptionPlan::where('plan_id',$input['plan'])->first();

            $current_date = date('Y-m-d h:i:s');    
            $next_date = $SubscriptionPlan->days;
            $date = Carbon::parse($current_date)->addDays($next_date);
            $Subscription = Subscription::where('user_id',$id)->first();
            if(!empty($Subscription)){
                $User = User::where('id',$id)->first();
                $subscription = Subscription::where('user_id',$id)->first();

                $subscription->name = $User->username;
                $subscription->price = $SubscriptionPlan->price;
                $subscription->user_id = $id;
                $subscription->stripe_id = $SubscriptionPlan->plan_id;
                $subscription->stripe_plan = $SubscriptionPlan->plan_id;
                $subscription->stripe_status  = 'active';
                $subscription->name = $user->username;
                $subscription->days = $SubscriptionPlan->days;
                $subscription->regionname = Region_name();
                $subscription->countryname = Country_name();
                $subscription->cityname = city_name();
                $subscription->PaymentGateway =  $SubscriptionPlan->type;
                $subscription->ends_at = $date;
                $subscription->save();

            }else{

                $subscription = new Subscription();
                $subscription->name = $User->username;
                $subscription->price = $SubscriptionPlan->price;
                $subscription->user_id = $id;
                $subscription->stripe_id = $SubscriptionPlan->plan_id;
                $subscription->stripe_plan = $SubscriptionPlan->plan_id;
                $subscription->stripe_status  = 'active';
                $subscription->name = $user->username;
                $subscription->days = $SubscriptionPlan->days;
                $subscription->regionname = Region_name();
                $subscription->countryname = Country_name();
                $subscription->cityname = city_name();
                $subscription->PaymentGateway =  $SubscriptionPlan->type;
                $subscription->ends_at = $date;
                $subscription->save();
            }

        }else{
            return Redirect::to('admin/user/create')->with(array(
                'note' => 'Need to Add Plan',
                'note_type' => 'failed'
            ));
            return Redirect::to('admin/users')->with(array('message' => 'Need to Select Plan ID','note_type' => 'success'));
        }
        
        return Redirect::to('admin/users')->with(array('message' => 'Successfully Created New User','note_type' => 'success'));
    }

    public function edit($id)
    {
        if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
            return redirect('/admin/restrict');
        }
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
        }else if(check_storage_exist() == 0){
            $settings = Setting::first();

            $data = array(
                'settings' => $settings,
            );

            return View::make('admin.expired_storage', $data);
        }else{
        $user = User::find($id);

        $data = array(
            'user' => $user,
            'post_route' => URL::to('admin/user/update') ,
            'admin_user' => Auth::user() ,
            'button_text' => 'Update User',
            'SubscriptionPlan' => SubscriptionPlan::all(),
        );
        return View::make('admin.users.edit', $data);
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
        if (Auth::guest())
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
            
            $user_update = User::find($id);
            $user_update->avatar = $file->getClientOriginalName();
            $user_update->save();

        }



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
        if ($request->has('username')) {
            $user->username = $request->get('username');
        }
    
        if ($request->has('mobile')) {
            $user->mobile = $request->get('mobile');
        }
    
        if ($request->has('email')) {
            $user->email = $request->get('email');
        }
    
        if ($request->has('DOB')) {
            $user->DOB = $request->get('DOB');
        }
        if ($request->has('username')) {
            $user->username = $request->get('username');
        }
        if ($request->has('ccode')) {
            $user->ccode = $request->get('ccode');
        }
    
        if ($request->has('gender')) {
            $user->gender = $request->get('gender');
        }


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
            $file = $image;                    //upload new file
            // $user->avatar = $file->getClientOriginalName();
            $user->avatar = str_replace(' ', '_', $file->getClientOriginalName());

            $file->move($image_path, $user->avatar);
        }

        $path = public_path() . '/uploads/ugc-banner/';
        $image_path = public_path() . '/uploads/ugc-banner/';

        $image_req = $request['ugc_banner'];

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
            $file = $image;                    //upload new file
            $user->ugc_banner = str_replace(' ', '_', $file->getClientOriginalName());

            $file->move($image_path, $user->ugc_banner);
        }


        $user->save();

        Auth::loginUsingId(Auth::user()->id);

        return redirect()->route('myprofile');
    }

    public function mobileapp()
    {
        if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
            return redirect('/admin/restrict');
        }
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
        }else if(check_storage_exist() == 0){
            $settings = Setting::first();

            $data = array(
                'settings' => $settings,
            );

            return View::make('admin.expired_storage', $data);
        }else{
        $mobile_settings = MobileApp::get();
        $allCategories = MobileSlider::all();
        $welcome_screen = WelcomeScreen::all();
        $tv_splash_screen = TVSplashScreen::all();
        $data = array(
            'admin_user' => Auth::user() ,
            'mobile_settings' => $mobile_settings,
            'allCategories' => $allCategories,
            'welcome_screen' => $welcome_screen,
            'tv_splash_screen' => $tv_splash_screen,
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

        $file =  $request['andriod_splash_image'];
        $input['andriod_splash_image'] = "andriod_splash_image_".time().".".$file->getClientOriginalExtension();
        $file->move($path, $input['andriod_splash_image']);

        MobileApp::create(
                [  'splash_image' => $input['splash_image'],
                   'andriod_splash_image' => $input['andriod_splash_image'],
                ]);

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

    public function device_version(Request $request)
    {
        $MobileApp = MobileApp::get();

        if(count($MobileApp) > 0){
            foreach($MobileApp as $MobileApp_devices){
                MobileApp::where('id',$MobileApp_devices->id)->update([
                   'ios_device_version' => $request->ios_device_version,
               ]);
           }
        }else{
            MobileApp::create([
                'ios_device_version' => $request->ios_device_version,
            ]);
        }

        return redirect()->route('admin.mobileapp');
    }

    public function logout(Request $request)
    {
        if (Auth::guest())
        {
            return redirect('/login');
        }
        $data = \Session::all();
        // dd( $data);
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
        unset($data['password_hash']);
        
        if(!empty($data['user'])){
            unset($data['expiresIn']);
            unset($data['providertoken']);
            unset($data['user']);
            Cache::flush();
        }

        $request->session()->flush();
        $request->session()->regenerate();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        \Session::flush();

        Auth::logout();

        return Redirect::to('/')->with(array(
            'message' => 'You are logged out done',
            'note_type' => 'success'
        ));
    }

    public function destroy($id)
    {
        ContinueWatching::where('user_id',$id)->delete();

        Wishlist::where('user_id',$id)->delete();

        Watchlater::where('user_id',$id)->delete();

        User::find($id)->delete();

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

        try {
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
        } catch (\Throwable $th) {
            //throw $th;
        }
     
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
            try {
                Mail::send('emails.register_device_login', array(
                    'id' => $user_id,
                    'name' => $username,
    
                ) , function ($message) use ($email, $username, $settings)
                {
                    $message->from(AdminMail() , $settings->website_name);
                    $message->to($email, $username)->subject('Buy Advanced Plan To Access Multiple Devices');
                });
            } catch (\Throwable $th) {
                //throw $th;
            }
            
        }
        return Redirect::to('home');
        // return Redirect::to('/home');
        // return Redirect::back();
        
    }


    public function DeviceLogout($userIp,$id)
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
        LoggedDevice::destroy($id);
        $settings = Setting::find(1);


        return Redirect::to('home');
        
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
        if(!empty($maildevice)){
            $maildevice->status = 2;
            $maildevice->save();
        }
        $system_settings = SystemSetting::first();
        $user = User::where('id', '=', 1)->first();
        $message = 'Approved User For Login';
        return Redirect::back('/')->with('message', $message);

    }
    public function exportold(Request $request)
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
        // if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
        //     return redirect('/admin/restrict');
        // }
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
        }else if(check_storage_exist() == 0){
            $settings = Setting::first();

            $data = array(
                'settings' => $settings,
            );

            return View::make('admin.expired_storage', $data);
        }else{
        $registered_count = User::where('role', 'registered')->count();
        $subscription_count = User::where('role', 'subscriber')->count();
        $admin_count = User::where('role', 'admin')->count();
        $ppvuser_count = User::join('ppv_purchases', 'users.id', '=', 'ppv_purchases.user_id')->count();
        $all_users_count = User::count();

        $data['total_user'] = User::select(\DB::raw("COUNT(*) as count") , \DB::raw("MONTHNAME(created_at) as month_name") , \DB::raw('max(created_at) as createdAt'))->whereYear('created_at', date('Y'))
            ->groupBy('month_name')
            ->orderBy('createdAt', "DESC")
            ->get();
        // $total_user = User::where('role', '!=', 'admin')->orderBy('created_at', "DESC")->get();
        $total_user = User::where('role', '!=', 'admin')->paginate(10);

        $data1 = array(
            'admin_count' => $admin_count,
            'subscription_count' => $subscription_count,
            'registered_count' => $registered_count,
            'total_user' => $total_user,
            'ppvuser_count' => $ppvuser_count,
            'activeuser_count' => User::where('active', 1)->count(),
            'inactiveuser_count' => User::where('active',0)->orwhere('active',null)->count(),
            'all_users_count' => User::count(),
            'all_users' => User::get(),
        );
            return \View::make('admin.analytics.revenue', ['data1' => $data1, 'data' => $data, 'total_user' => $total_user, 'all_users' =>  User::get()]);
            // return \View::make('admin.analytics.Userrevenue', ['data1' => $data1, 'data' => $data, 'total_user' => $total_user]);
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
        elseif ($role == "active_users")
        {
            $Users = User::where('active', 1)->get();
        }
        elseif ($role == "inactive_users")
        {
            $Users = User::where('active','!=',  1)->get();
        }
        elseif ($role == "admin")
        {
            $Users = User::where('role', 'admin')->get();
        }
        else
        {
            $Users = User::get();
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
          <td>' . $row->DOB  . '</td>
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
        fputcsv($handle, ["User Name", "ACC Type", "Country", "Registered ON ","DOB", "Source", "Status",]);
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
                fputcsv($handle, [$each_user->username, $role, $each_user->countryname, $each_user->created_at,$each_user->DOB, $provider, $active,

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
                fputcsv($handle, [$each_user->username, $role, $each_user->countryname, $each_user->created_at,$each_user->DOB, $provider, $active, ]);

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
                fputcsv($handle, [$each_user->username, $role, $each_user->countryname, $each_user->created_at,$each_user->DOB, $provider, $active,

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
        if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
            return redirect('/admin/restrict');
        }
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
        }else if(check_storage_exist() == 0){
            $settings = Setting::first();

            $data = array(
                'settings' => $settings,
            );

            return View::make('admin.expired_storage', $data);
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
        if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
            return redirect('/admin/restrict');
        }
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
        }else if(check_storage_exist() == 0){
            $settings = Setting::first();

            $data = array(
                'settings' => $settings,
            );

            return View::make('admin.expired_storage', $data);
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

                // $data = Subscription::select('users.username', 'plans.plans_name')->join('users', 'users.id', '=', 'subscriptions.user_id')
                //     ->join('plans', 'plans.plan_id', '=', 'subscriptions.stripe_plan')
                //     ->paginate(9);
                    $data =  Subscription::select('users.username','subscription_plans.plans_name', 'subscription_plans.plan_id', 'users.id')
                    ->join('users','users.id','=','subscriptions.user_id')
                    ->join('subscription_plans','subscription_plans.plan_id','=','subscriptions.stripe_plan')
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
                // $data = Subscription::select('users.username', 'plans.plans_name')
                // ->join('users', 'users.id', '=', 'subscriptions.user_id')
                //     ->join('plans', 'plans.plan_id', '=', 'subscriptions.stripe_plan')
                // // ->where('subscriptions.regionname','=',$query)
                
                //     ->paginate(9);
                    $data =  Subscription::select('users.username','subscription_plans.plans_name', 'subscription_plans.plan_id', 'users.id')
                    ->join('users','users.id','=','subscriptions.user_id')
                    ->join('subscription_plans','subscription_plans.plan_id','=','subscriptions.stripe_plan')
                    ->where('subscriptions.regionname','=',$query)
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
                // $data = Subscription::select('users.username', 'plans.plans_name')
                // ->join('users', 'users.id', '=', 'subscriptions.user_id')
                //     ->join('plans', 'plans.plan_id', '=', 'subscriptions.stripe_plan')
                //     ->where('subscriptions.cityname', '=', $query)->paginate(9);

            $data =  Subscription::select('users.username','subscription_plans.plans_name', 'subscription_plans.plan_id', 'users.id')
            ->join('users','users.id','=','subscriptions.user_id')
            ->join('subscription_plans','subscription_plans.plan_id','=','subscriptions.stripe_plan')
            ->where('subscriptions.cityname', '=', $query)
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

    public function profilePreference(Request $request)
    {

        $inputs = array(
            'preference_language' => !empty($request->preference_language) ? json_encode($request->preference_language) : null ,
            'preference_genres'   => !empty($request->preference_genres ) ? json_encode($request->preference_genres ) : null ,
        ) ;
        
        User::find($request->user_id)->update($inputs);

        return Redirect::to('/myprofile')->with(array('message' => 'Successfully Created Preference', 'note_type' => 'success'));

    }

    public function handleViewCount_ugc($vid)
    {
        $ugcview = UGCVideo::find($vid);
    
        if (!$ugcview) {
            return null;
        }
    
        $ugcview->views = $ugcview->views + 1;
        $ugcview->save();
    
        Session::put('viewed_ugc_videos.' . $vid, time());
    
        return $ugcview;
    }


    private function handleViewCounts($ugcvideos)
    {
        $updatedVideos = [];
    
        foreach ($ugcvideos as $ugcvideo) {
            $updatedVideo = $this->handleViewCount_ugc($ugcvideo->id);
            if ($updatedVideo) {
                $updatedVideos[] = $updatedVideo;
            }
        }
    
        return $updatedVideos;
    }


    public function myprofile()
    {

        $Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses($Theme);

        $SiteTheme = SiteTheme::first();

        if (Auth::guest())
        {
            return redirect('/login');
        }
        $data = Session::all();

        // $session_password = $data['password_hash'];
        if (Auth::guest())
        {
            $system_settings = SystemSetting::first();

            return Theme::view('auth.login', compact('system_settings'));
            
        }
        else
        {

            $user_id = Auth::user()->id;
            $user_role = Auth::user()->role;
            $alldevices = LoggedDevice::where('user_id', '=', Auth::User()->id)->get();
            $video_quality = SubscriptionPlan::all();

            $UserTVLoginCode = TVLoginCode::where('email',Auth::User()->email)->orderBy('created_at', 'DESC')->first();
            // dd($UserTVLoginCode);
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
            $recent_videos = RecentView::where('user_id',$user_id)->whereNotNull('video_id')->orderBy('id', 'desc')->take(10)
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

            $ugcvideo = UGCVideo::where('user_id', $user_details->id)
            ->withCount([
                'likesDislikes as like_count' => function($query) {
                    $query->where('liked', 1);
                }
                ])
            ->where('active', 1)
            ->orderBy('created_at', 'DESC')
            ->paginate(9);
            $user_data = User::withCount('subscribers')->find($user_details->id);
            $updated_ugcvideos =  $this->handleViewCounts($ugcvideo);
            $ugc_total = $user_details->ugcVideos();
            $totalViews = $ugc_total->sum('views');
            $totalVideos = $ugc_total->where('active',1)->count();

            $user_genrated_content = Wishlist::where('user_id', '=',  $user_id)
            ->where('ugc_video_id', '!=', null)
            ->get();

            $user_genrated_content_array = array();

            foreach ($user_genrated_content as $key => $cfave)
            {
                array_push($user_genrated_content_array, $cfave->ugc_video_id);
            }

            $user_genrated_content_videos = UGCVideo::where('active', '=', '1')->whereIn('id', $user_genrated_content_array)->paginate(9);            

            if ($user_role == 'subscriber')
            {
                $subscriptions_created_at = Subscription::where('subscriptions.user_id', $user_id)->orderBy('created_at', 'DESC')->pluck('created_at')->first();
            }else{
                $subscriptions_created_at = User::where('id', $user_id)->pluck('created_at')->first();
            }
            
            $data = array(
                'recent_videos' => $video,
                'videocategory' => $videocategory,
                'ugcvideos' => $ugcvideo,
                'viewcount' =>  $updated_ugcvideos,
                'totalViews' => $totalViews,
                'totalVideos' => $totalVideos,
                'user_generated_content' => $user_genrated_content_videos,
                'subscriber_count' => $user_data->subscribers_count,
                'plans' => $plans,
                'devices_name' => $devices_name,
                'user' => $user_details,
                'role_plan' => $role_plan,
                'user_role' => $user_role,
                'post_route' => URL::to('/profile/update') ,
                'preference_languages' => $language,
                'profile_details' => $profile_details,
                'Multiuser' => $Multiuser,
                'alldevices' => $alldevices,
                'UserTVLoginCode' => $UserTVLoginCode,
                'video_quality'  => $video_quality,
                'payment_package' => User::where('id',Auth::user()->id)->first() ,
                'LoggedusersCode' => TVLoginCode::where('email',Auth::User()->email)->orderBy('created_at', 'DESC')->get() ,
                'subscriptions_created_at'  => $subscriptions_created_at,
            );

            if(!empty($SiteTheme) && $SiteTheme->my_profile_theme == 0 || $SiteTheme->my_profile_theme ==  null){
                return Theme::view('myprofile', $data);
            }else{
                return Theme::view('myaccount', $data);
            }
        }
    }

    public function TVCode(Request $request)
    {
       
      try{

        TVLoginCode::create([
          'email'    => $request->email,
          'tv_code'  => $request->tv_code,
          'type'  => 'Code',
          'status'   => 0,
       ]);
    
        $response = array(
            'status'=> 'true',
            'message' => 'Added verfication code',
            'tv_code' => $request->tv_code,
        );
    
        } 
        catch (\Throwable $th) {
    
            $response = array(
              'status'=>'false',
              'message'=>$th->getMessage(),
            );
    
        }
        return Redirect::back()
        ->with(array(
        'message' => 'Successfully added!',
        'note_type' => 'success'
    ));
    }

    
    public function RemoveTVCode($id)
    {
       
      try{

    //    TVLoginCode::destroy($id);
    //    $TVLoginCode=TVLoginCode::where('id',$id)->pluck('id');
    // //    $email = $TVLoginCode->email;
    // dd($TVLoginCode);
       TVLoginCode::where('id',$id)->delete();
    
        } 
        catch (\Throwable $th) {
    
            $response = array(
              'status'=>'false',
              'message'=>$th->getMessage(),
            );
    
        }
    // dd($id);
        
        return Redirect::back()
        ->with(array(
        'message' => 'Removed TV Code',
        'note_type' => 'success'
    ));
    }

    public function Splash_edit(Request $request, $source, $id )
    {

        $Splash = MobileApp::where('id', $id)->first();
        $allCategories = MobileSlider::all();

        $data = array(
            'admin_user' => Auth::user() ,
            'Splash' => $Splash,
            'allCategories' => $allCategories,
            'source'   => $source
        );

        return View::make('admin.mobile.splashEdit', $data);

    }

    public function Splash_update(Request $request, $source, $id)
    {
        $input = $request->all();
        $Splash = MobileApp::find($id);

        if ( $source == "ios" && $request->file('splash_image'))
        {
            $path = public_path() . '/uploads/settings/';
            $splash_image = $request['splash_image'];
            $file = $splash_image;
            $input['splash_image'] = $file->getClientOriginalName();
            $file->move($path, $input['splash_image']);

            $Splash->splash_image = $input['splash_image'];

            $Splash->save();

        }

        if ( $source == "andriod" &&  $request->file('andriod_splash_image'))
        {
            $path = public_path() . '/uploads/settings/';
            $file = $request['andriod_splash_image'];
            $input['andriod_splash_image'] = "andriod_splash_image_".time().".".$file->getClientOriginalExtension();
            $file->move($path, $input['andriod_splash_image']);

            $Splash->andriod_splash_image = $input['andriod_splash_image'];

            $Splash->save();

        }

        return Redirect::to('admin/mobileapp')
            ->with(array(
            'message' => 'Successfully updated!',
            'note_type' => 'success'
        ));
    }

    public function Splash_destroy( $source ,$id)
    {
        if( $source == "andriod" ){
            $Splash = MobileApp::find($id)->update([
                "andriod_splash_image" => null ,
            ]);
        }

        if ( $source == "ios" ){
            $Splash = MobileApp::find($id)->update([
                "splash_image" => null ,
            ]);
        }

        $Splash = MobileApp::where('id',$id)->first();

        if( $Splash->splash_image == null && $Splash->andriod_splash_image == null  ){
            $Splash->delete();
        }

        return Redirect::to('admin/mobileapp')
            ->with(array(
            'message' => 'Successfully deleted!',
            'note_type' => 'success'
        ));
    }


    public function UserRevenue()
    {
        // if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
        //     return redirect('/admin/restrict');
        // }
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
        }else if(check_storage_exist() == 0){
            $settings = Setting::first();

            $data = array(
                'settings' => $settings,
            );

            return View::make('admin.expired_storage', $data);
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
        'subscriptions.platform','subscriptions.platform','subscription_plans.plans_name', 'users.role','subscriptions.created_at',
         \DB::raw("MONTHNAME(subscriptions.created_at) as month_name") ,
         
        ]);
        $usersubscriber_Revenue = User::join('subscriptions', 'subscriptions.user_id', '=', 'users.id')
        ->join('subscription_plans', 'subscription_plans.plan_id', '=', 'subscriptions.stripe_plan')
        ->get(['users.username','users.stripe_id','users.card_type','users.ccode', 'subscription_plans.price as total_amount',
        'subscription_plans.plans_name', 'users.role','subscriptions.created_at',
         \DB::raw("MONTHNAME(subscriptions.created_at) as month_name") ,
        \DB::raw('(subscription_plans.price) as count') ,
        ]);
        $subscriber_Revenue = Subscription::
            // join('users', 'subscriptions.user_id', '=', 'users.id')
        join('subscription_plans', 'subscription_plans.plan_id', '=', 'subscriptions.stripe_plan')

        // ->where('subscription_plans.plan_id', '=', 'subscriptions.stripe_plan')
        // ->where('users.role','subscriber')
        // ->select(
        //     // 'users.username', 'users.stripe_id', 'users.card_type', 'users.ccode','users.role',
        //      'subscription_plans.price as total_amount',
        // 'subscription_plans.plans_name',  'subscriptions.created_at',
        // // \DB::raw("MONTHNAME(subscriptions.created_at) as month_name"),
        // \DB::raw('(subscription_plans.price) as count')
    // )
    ->get();

    $subscriber_Revenue = Subscription::join('users', 'subscriptions.user_id', '=', 'users.id')
    ->select(
            'users.username', 'users.stripe_id', 'users.card_type', 'users.ccode','users.role',
             'subscriptions.price as total_amount','subscriptions.platform',
             'subscriptions.stripe_plan as stripe_plan',
        'subscriptions.created_at',
        'subscriptions.countryname',
        'subscriptions.stripe_status',
        'subscriptions.id as subscriptionid',
        // \DB::raw("MONTHNAME(subscriptions.created_at) as month_name"),
        \DB::raw('(subscriptions.price) as count')
    )->orderBy('subscriptions.created_at','desc')
    ->get();

        // dd($subscriber_Revenue);

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
        if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
            return redirect('/admin/restrict');
        }

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
        }else if(check_storage_exist() == 0){
            $settings = Setting::first();

            $data = array(
                'settings' => $settings,
            );

            return View::make('admin.expired_storage', $data);
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
        if(count($ppv_Revenue) > 0){
        foreach($ppv_Revenue as $d) {
            if($d->count != null){
            $ppv_Revenues[$d->month_name] = $d->count;
            }else{
            $ppv_Revenues[$d->month_name] =  0;
            }
        }
    }else{
        $ppv_Revenues =  [];
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
        'subscriptions.platform','subscription_plans.plans_name', 'users.role','subscriptions.created_at',
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
            'subscriptions.platform','subscription_plans.plans_name', 'users.role','subscriptions.created_at',
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
               <td>' . $row->platform . '</td>  
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
            'subscriptions.platform','subscription_plans.plans_name', 'users.role','subscriptions.created_at',
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
               <td>' . $row->platform . '</td>  
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
            'subscriptions.platform','subscription_plans.plans_name', 'users.role','subscriptions.created_at',
             \DB::raw("MONTHNAME(subscriptions.created_at) as month_name") ,
             
            ]);
           
        }
        elseif (!empty($start_time) && !empty($end_time))
        {
            $subscriber_Revenue = User::join('subscriptions', 'subscriptions.user_id', '=', 'users.id')
            ->join('subscription_plans', 'subscription_plans.plan_id', '=', 'subscriptions.stripe_plan')
            ->whereBetween('subscriptions.created_at', [$start_time, $end_time])->groupBy('month_name')
            ->get(['users.username','users.stripe_id','users.card_type','users.ccode', 'subscription_plans.price as total_amount',
            'subscriptions.platform','subscription_plans.plans_name', 'users.role','subscriptions.created_at',
             \DB::raw("MONTHNAME(subscriptions.created_at) as month_name") ,
             
            ]);

        }
        else
        {
            $subscriber_Revenue = User::join('subscriptions', 'subscriptions.user_id', '=', 'users.id')
            ->join('subscription_plans', 'subscription_plans.plan_id', '=', 'subscriptions.stripe_plan')
            ->get(['users.username','users.stripe_id','users.card_type','users.ccode', 'subscription_plans.price as total_amount',
            'subscriptions.platform','subscription_plans.plans_name', 'users.role','subscriptions.created_at',
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
        fputcsv($handle, ["User", "Transaction REF", "User Type", "Plan", "Content", "Platform", "Price", "Country", "Date Time", "Source",]);
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
                , $Content, $each_user->platform, $each_user->total_amount, $country_name, $each_user->created_at,$card_type,
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
            'subscriptions.platform','subscription_plans.plans_name', 'users.role','subscriptions.created_at',
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


    public function update_username(Request $request)
    {
            User::where('id',$request->users_id)->update([
                'username' => $request->user_name ,
            ]);

        return Redirect::back();
        
    }

    public function update_userImage(Request $request)
    {
        $input = $request->all();
        $id = $request['users_id'];
        
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

            $user_update = User::find($id);
            $user_update->avatar = $file->getClientOriginalName();
            $user_update->save();

        }

        return Redirect::back();
    }

    public function update_userEmail(Request $request)
    {
        User::where('id',$request->users_id)->update([
            'email' => $request->user_email ,
        ]);

        $data = \Session::all();
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

        return Redirect::to('/login');

    }

    public function email_exitsvalidation(Request $request)
    {

        $email = $request->get('email');
        
        $user = User::where('email',$email)->first();

        if( $user == null){
              $message = "true";
        }
        else{
          $message = "false";
        }
        return $message;
    }

    public function mobilenumber_exitsvalidation(Request $request)
    {
        $mobile = $request->get('mobile');
        
        $mobile = User::where('mobile',$mobile)->first();

        if( $mobile == null){
              $message = "true";
        }
        else{
          $message = "false";
        }
        return $message;
    }

    public function password_validation(Request $request)
    {
        $password_validation = $request->passwords;

        $inputs = [
            'password' => $password_validation,
        ];
    
        $rules = [
            'password' => 'required|string|min:8|regex:/^(?=.*[A-Z])(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/',
        ];
    
        $validation = \Validator::make( $inputs, $rules );
    
        if ( $validation->fails() ) {

            $message = "false";
        }
        else{
            $message = "true";
        }
            return $message;
    }

    public function import_users_view()
    {
        // User::where('id','!=',"1")->delete();

       return view('admin.users.import_users');
    }

    public function users_import( Request $request) 
    {
        try {

            Excel::import( new UsersImport,request()->file('file') );

            return redirect( route( "users" ))->with(
                "message",
                "Successfully! Users Imported "
            );

        } catch (\Throwable $th) {

            return Redirect::back()->with("import-error-message", $th->getMessage() );
        }
    }

    public function VideoByRegionCSV(Request $request)
    {

        $data = $request->all();
        // $start_time = $data['start_time'];
        // $end_time = $data['end_time'];
        $region_views = RegionView::leftjoin('videos', 'region_views.video_id', '=', 'videos.id')->get();
        $data = $region_views->groupBy('countryname');

        $viewbyregion = Video::select('videos.*', 'region_views.countryname as countryname')->join('region_views', 'region_views.video_id', '=', 'videos.id')
            ->orderBy('created_at', 'desc')
            ->get();
        //  $file = 'CPPRevenue_' . rand(10, 100000) . '.csv';
        $file = 'viewbyregion.csv';
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
        fputcsv($handle, ["#","Title", "Country Name", "User Ip", "View Count", ]);
        if (count($viewbyregion) > 0)
        {
            foreach ($viewbyregion as $each_user)
            {

                fputcsv($handle, ['#',$each_user->title, $each_user->countryname,  $each_user->user_ip,  $each_user->views,
                ]);
            }
        }

        fclose($handle);

        \Response::download($filename, "download.csv", $headers);

        return $file;
    }

    
    public function RevenueRegionCSV(Request $request)
    {

        $data = $request->all();
        $Country = $data['country'];
        $state = $data['state'];
        $city = $data['City'];

        if($Country == 'Allcountry' || $state == 'Allstate' || $city == 'Allcity'){
            $data =  Subscription::select('users.username','subscription_plans.plans_name', 'subscription_plans.plan_id', 'users.id')
                    ->join('users','users.id','=','subscriptions.user_id')
                    ->join('subscription_plans','subscription_plans.plan_id','=','subscriptions.stripe_plan')
                    ->get();
        }else if($Country != '' && $state != '' && $city != '' && $Country != 'Allcountry' && $state != 'Allstate' && $city != 'Allcity'){

            $state = State::where("id", $state)
            ->first();
            $data =  Subscription::select('users.username','subscription_plans.plans_name', 'subscription_plans.plan_id', 'users.id')
                    ->join('users','users.id','=','subscriptions.user_id')
                    ->join('subscription_plans','subscription_plans.plan_id','=','subscriptions.stripe_plan')
                    ->where('subscriptions.cityname', '=', $city)
                    ->get();

        }else {
            $data =  Subscription::select('users.username','subscription_plans.plans_name', 'subscription_plans.plan_id', 'users.id')
                    ->join('users','users.id','=','subscriptions.user_id')
                    ->join('subscription_plans','subscription_plans.plan_id','=','subscriptions.stripe_plan')
                    ->get();
        }
        $file = 'RevenueRegionCSV.csv';

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
        fputcsv($handle, ["ID", "User Name", "Plan Name",]);
        if (count($data) > 0)
        {
            foreach ($data as $each_user)
            {

                fputcsv($handle, ['#',$each_user->username, $each_user->plans_name,
                ]);
            }
        }

        fclose($handle);

        \Response::download($filename, "download.csv", $headers);

        return $file;
    }


    public function PlayerVideosExport(Request $request){
        $user_package = User::where("id", 1)->first();
        $package = $user_package->package;
        if (
            (!empty($package) && $package == "Pro") ||
            (!empty($package) && $package == "Business")
        ) {

   
            $start_time = $data["start_time"];
            $end_time = $data["end_time"];
            if (!empty($start_time) && empty($end_time)) {
                $player_videos = PlayerAnalytic::join('users', 'users.id', '=', 'player_analytics.user_id')
                ->leftjoin('videos', 'videos.id', '=', 'player_analytics.videoid')
                // ->groupBy('player_analytics.videoid')
                ->orderBy('player_analytics.created_at')
                ->whereDate('player_analytics.created_at', '>=', $start_time)            
                ->groupBy('player_analytics.videoid')
                ->get(['player_analytics.videoid','player_analytics.user_id','users.username','videos.title','videos.slug',
                DB::raw('sum(player_analytics.duration) as duration') ,
                 DB::raw('sum(player_analytics.currentTime) as currentTime') ,
                 DB::raw('(player_analytics.seekTime) as seekTime') ,
                 DB::raw('(player_analytics.bufferedTime) as bufferedTime') ,
                 DB::raw('sum(player_analytics.watch_percentage) as watch_percentage') ,
                 \DB::raw("MONTHNAME(player_analytics.created_at) as month_name") ,
                 \DB::raw("COUNT(player_analytics.videoid) as count"),
                 \DB::raw("(player_analytics.watch_percentage) as watchpercentage"),
                ]);

            } elseif (!empty($start_time) && !empty($end_time)) {
 
                $player_videos = PlayerAnalytic::join('users', 'users.id', '=', 'player_analytics.user_id')
                ->leftjoin('videos', 'videos.id', '=', 'player_analytics.videoid')
                // ->groupBy('player_analytics.videoid')
                ->orderBy('player_analytics.created_at')
                ->whereBetween('player_analytics.created_at', [$start_time, $end_time])
                ->groupBy('player_analytics.videoid')
                ->get(['player_analytics.videoid','player_analytics.user_id','users.username','videos.title','videos.slug',
                DB::raw('sum(player_analytics.duration) as duration') ,
                 DB::raw('sum(player_analytics.currentTime) as currentTime') ,
                 DB::raw('(player_analytics.seekTime) as seekTime') ,
                 DB::raw('(player_analytics.bufferedTime) as bufferedTime') ,
                 DB::raw('sum(player_analytics.watch_percentage) as watch_percentage') ,
                 \DB::raw("MONTHNAME(player_analytics.created_at) as month_name") ,
                 \DB::raw("COUNT(player_analytics.videoid) as count"),
                 \DB::raw("(player_analytics.watch_percentage) as watchpercentage"),
                ]);

            } else {

                $player_videos = PlayerAnalytic::join('users', 'users.id', '=', 'player_analytics.user_id')
                ->leftjoin('videos', 'videos.id', '=', 'player_analytics.videoid')
                // $player_videos = PlayerAnalytic::groupBy('videoid')
                ->groupBy('player_analytics.videoid')
                ->orderBy('player_analytics.created_at')
                ->get(['player_analytics.videoid','player_analytics.user_id','users.username','videos.title','videos.slug',
                DB::raw('sum(player_analytics.duration) as duration') ,
                 DB::raw('sum(player_analytics.currentTime) as currentTime') ,
                 DB::raw('sum(player_analytics.seekTime) as seekTime') ,
                 DB::raw('(player_analytics.bufferedTime) as bufferedTime') ,
                 DB::raw('sum(player_analytics.watch_percentage) as watch_percentage') ,
                 \DB::raw("MONTHNAME(player_analytics.created_at) as month_name") ,
                 \DB::raw("COUNT(player_analytics.videoid) as count"),
                 \DB::raw("(player_analytics.watch_percentage) as watchpercentage"),
                //  floor($player_videos[1]->duration / 60)
                ]);
                    
            }
            $file = "PlayerVideosAnalytics.csv";

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
                "Video Slug",
                "Viewed Count",
                "Watch Percentage (Minutes)",
                "Seek Time (Seconds)",
                "Buffered Time (Seconds)",
            ]);
            if (count($player_videos) > 0) {
                foreach ($player_videos as $each_user) {
                    fputcsv($handle, [
                        $each_user->title,
                        $each_user->slug,
                        $each_user->count,
                        gmdate("H:i:s", @$each_user->currentTime),
                        $each_user->seekTime,
                        $each_user->bufferedTime,
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

    public function export(Request $request)
    {

        $user_package = User::where("id", 1)->first();
        $package = $user_package->package;
        if (
            (!empty($package) && $package == "Pro") ||
            (!empty($package) && $package == "Business")
        ) {

        $input = $request->all();
        $start_time = $input['start_time'];
        $end_time = $input['end_time'];

        if (!empty($start_time) && empty($end_time)) {

            
            $users = User::whereDate('users.created_at', '>=', $start_time)            
            ->get();

            $country_name = CountryCode::get();

            $current_plan = User::select(['subscriptions.*', 'users.*', 'subscription_plans.plans_name', 'subscription_plans.billing_interval', 'subscription_plans.days'])
                ->join('subscriptions', 'subscriptions.user_id', '=', 'users.id')
                ->join('subscription_plans', 'subscriptions.stripe_plan', '=', 'subscription_plans.plan_id')
                ->where('role', '=', 'subscriber')
                ->get();
                
        } elseif (!empty($start_time) && !empty($end_time)) {


            
            $users = User::whereBetween('users.created_at', [$start_time, $end_time])->get();

            $country_name = CountryCode::get();

            $current_plan = User::select(['subscriptions.*', 'users.*', 'subscription_plans.plans_name', 'subscription_plans.billing_interval', 'subscription_plans.days'])
                ->join('subscriptions', 'subscriptions.user_id', '=', 'users.id')
                ->join('subscription_plans', 'subscriptions.stripe_plan', '=', 'subscription_plans.plan_id')
                ->where('role', '=', 'subscriber')
                ->get();

        } else {

       
            $users = User::all();

            $country_name = CountryCode::get();

            $current_plan = User::select(['subscriptions.*', 'users.*', 'subscription_plans.plans_name', 'subscription_plans.billing_interval', 'subscription_plans.days'])
                ->join('subscriptions', 'subscriptions.user_id', '=', 'users.id')
                ->join('subscription_plans', 'subscriptions.stripe_plan', '=', 'subscription_plans.plan_id')
                ->where('role', '=', 'subscriber')
                ->get();
        }

        $file = "users.csv";

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
                "User ID",
                "Username",
                "Email",
                "Country Code",
                "Contact Number",
                "Current Package",
                "User Type",
                "User Country",
                "User State",
                "User City",
                "Active",

            ]);
            if (count($users) > 0) {



                foreach ($users as $each_user) {
                    if($each_user->role == 'subscriber'){
                        $current_plan = Subscription::join('subscription_plans', 'subscriptions.stripe_plan', '=', 'subscription_plans.plan_id')
                        ->where('subscriptions.user_id', '=', $each_user->id)
                        ->pluck('subscription_plans.plans_name');
                    }else{
                        $current_plan = '';
                    }
                    $Active = ( $each_user->active == 1 ) ? "Active" :  "IN Active";

                    fputcsv($handle, [
                        $each_user->id,
                        $each_user->username,
                        $each_user->email,
                        $each_user->ccode,
                        $each_user->mobile,
                        $current_plan,
                        $each_user->role,
                        $each_user->country,
                        $each_user->state,
                        $each_user->city,
                        $Active,
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

    public function DOB(Request $request)
    {
        $user = User::where('id',$request->users_id)->first();
        // dd($user);
        
        DB::table('users')->where('id', $request->users_id)->update(
            [
                'DOB'  => $request->DOB,
            ]);
        return Redirect::back()->with(array('message' => 'Successfully Update DOB','note_type' => 'success'));

    }

    public function ManageDevices()

    {

        if (Auth::guest())
        {
            return redirect('/login');            
        }

        $UserTVLoginCode = TVLoginCode::where('email',Auth::User()->email)->orderBy('created_at', 'DESC')->get();

        $devices = $UserTVLoginCode;

        $data = array(
            'devices' => $devices,
            'username' => Auth::User()->username,
        );
        
            return Theme::view('ManageDevice', $data);    
    }

    public function RegisterNewDevice()

    {

        if (Auth::guest())
        {
            return redirect('/login');            
        }

        $UserTVLoginCode = TVLoginCode::where('email',Auth::User()->email)->orderBy('created_at', 'DESC')->get();

        $devices = $UserTVLoginCode;

        $data = array(
            'devices' => $devices,
            'username' => Auth::User()->username,
        );
        
            return Theme::view('RegisterNewDevice', $data);    
    }

    
    public function DeregisterDevice($id)

    {

        if (Auth::guest())
        {
            return redirect('/login');            
        }

        TVLoginCode::where('id',$id)->delete();

        return Redirect::back()->with(array('message' => 'Successfully Deleted Device','note_type' => 'success'));

    }

    public function StoreNewDevice(Request $request)

    {
        $request->all();

        if (Auth::guest())
        {
            return redirect('/login');            
        }

        TVLoginCode::create([
          'email'    => Auth::User()->email,
          'tv_code'  => $request->device_code,
          'type'  => $request->device_type,
          'tv_name'  => $request->device_type,
          'status'   => 0,
       ]);

       $UserTVLoginCode = TVLoginCode::where('email',Auth::User()->email)->orderBy('created_at', 'DESC')->get();

       $devices = $UserTVLoginCode;

       $data = array(
           'devices' => $devices,
           'username' => Auth::User()->username,
       );
       
       return redirect('/manage-devices');            
    }


    
    public function ActivationCode($id)

    {
        $activation_code = User::where('id',$id)->first()->pluck('activation_code');
        $userdata = User::where('id',$id)->first();
        $settings = Setting::first();
                // verify email
                try {
                    \Mail::send('emails.verify', array(
                        'activation_code' => $userdata->activation_code,
                        'website_name' => $settings->website_name
                    ) , function ($message) use ($userdata)
                    {
                        $message->to($userdata->email, $userdata->name)
                            ->subject('Verify your email address');
                    });
                    
                    $email_log      = 'Mail Sent Successfully from Verify';
                    $email_template = "verify";
                    $user_id = $userdata->id;
    
                    Email_sent_log($user_id,$email_log,$email_template);
    
                    // return redirect('/verify-request');
    
                } catch (\Throwable $th) {
    
                    $email_log      = $th->getMessage();
                    $email_template = "verify";
                    $user_id = $userdata->id;
    
                    Email_notsent_log($user_id,$email_log,$email_template);
    
                    // return redirect('/verify-request-sent');
    
                }

       return Redirect::back()->with(array('message' => 'Successfully Sent Mail','note_type' => 'success'));
    }

    
    public function TVSplashScreen(Request $request)
    {

        $input = $request->all();

        $inputs = array();

        
        if($request->hasFile('AndroidTv_splash_screen')){

            $file = $request->AndroidTv_splash_screen;
            $extension = $file->getClientOriginalExtension();

            $filename   = 'AndroidTv-image-'.time().'.'.$file->getClientOriginalExtension();
            
            in_array($extension, ['jpeg', 'jpg', 'png'])  ? Image::make($file)->save(base_path().'/public/uploads/settings/'.$filename ) : ($extension === 'gif' ? $file->move('public/uploads/settings', $filename)  : $file->move('public/uploads/settings', $filename)); 
               
            $inputs +=  ['AndroidTv_splash_screen' => $filename ];
        }

        if($request->hasFile('LG_splash_screen')){

            $file = $request->LG_splash_screen;
            $extension = $file->getClientOriginalExtension();

            $filename   = 'LG-splash-image-'.time().'.'.$file->getClientOriginalExtension();

            in_array($extension, ['jpeg', 'jpg', 'png'])  ? Image::make($file)->save(base_path().'/public/uploads/settings/'.$filename ) : ($extension === 'gif' ? $file->move('public/uploads/settings', $filename)  : $file->move('public/uploads/settings', $filename)); 

            $inputs +=  ['LG_splash_screen' => $filename ];
        }

        if($request->hasFile('RokuTV_splash_screen')){

            $file = $request->RokuTV_splash_screen;
            $extension = $file->getClientOriginalExtension();

            $filename   = 'RokuTV-splash-image-'.time().'.'.$file->getClientOriginalExtension();

            in_array($extension, ['jpeg', 'jpg', 'png'])  ? Image::make($file)->save(base_path().'/public/uploads/settings/'.$filename ) : ($extension === 'gif' ? $file->move('public/uploads/settings', $filename)  : $file->move('public/uploads/settings', $filename)); 

            $inputs +=  ['RokuTV_splash_screen' => $filename ];
        }

        if($request->hasFile('Samsung_splash_screen')){

            $file = $request->Samsung_splash_screen;
            $extension = $file->getClientOriginalExtension();

            $filename   = 'Samsung-splash-image-'.time().'.'.$file->getClientOriginalExtension();

            in_array($extension, ['jpeg', 'jpg', 'png'])  ? Image::make($file)->save(base_path().'/public/uploads/settings/'.$filename ) : ($extension === 'gif' ? $file->move('public/uploads/settings', $filename)  : $file->move('public/uploads/settings', $filename)); 

            $inputs +=  ['Samsung_splash_screen' => $filename ];
        }


        if($request->hasFile('Firetv_splash_screen')){

            $file = $request->Firetv_splash_screen;
            $extension = $file->getClientOriginalExtension();

            $filename   = 'Firetv-splash-image-'.time().'.'.$file->getClientOriginalExtension();

            in_array($extension, ['jpeg', 'jpg', 'png'])  ? Image::make($file)->save(base_path().'/public/uploads/settings/'.$filename ) : ($extension === 'gif' ? $file->move('public/uploads/settings', $filename)  : $file->move('public/uploads/settings', $filename)); 

            $inputs +=  ['Firetv_splash_screen' => $filename ];
        }

        $TVSplashScreen = TVSplashScreen::create($inputs) ;

        return Redirect::to('admin/mobileapp')->with(array(
            'message' => 'Successfully Updated  Settings!',
            'note_type' => 'success'
        ));
        
    }

    public function TV_Splash_edit(Request $request, $id )
    {

        $Splash = TVSplashScreen::where('id', $id)->first();
        $allCategories = MobileSlider::all();

        $data = array(
            'admin_user' => Auth::user() ,
            'Splash' => $Splash,
            'allCategories' => $allCategories,
        );

        return View::make('admin.mobile.TVsplashEdit', $data);

    }

    public function TV_Splash_update(Request $request, $id)
    {

        $input = $request->all();

        $splash_image = TVSplashScreen::findorfail($id);

        $inputs = array();

        if($request->hasFile('AndroidTv_splash_screen')){

            if (File::exists(base_path('public/uploads/settings/'.$request->AndroidTv_splash_screen))) {

                File::delete(base_path('public/uploads/settings/'.$request->AndroidTv_splash_screen));
            }

            $file = $request->AndroidTv_splash_screen;

            $extension = $file->getClientOriginalExtension();

            $filename   = 'Splash-image-'.time().'.'.$file->getClientOriginalExtension();
        
            in_array($extension, ['jpeg', 'jpg', 'png'])  ? Image::make($file)->save(base_path().'/public/uploads/settings/'.$filename ) : ($extension === 'gif' ? $file->move('public/uploads/settings', $filename)  : $file->move('public/uploads/settings', $filename)); 

            $inputs +=  ['AndroidTv_splash_screen' => $filename ];
        }

        if($request->hasFile('LG_splash_screen')){

            if (File::exists(base_path('public/uploads/settings/'.$request->LG_splash_screen))) {

                File::delete(base_path('public/uploads/settings/'.$request->LG_splash_screen));
            }

            $file = $request->LG_splash_screen;

            $extension = $file->getClientOriginalExtension();

            $filename   = 'Andriod-splash-image-'.time().'.'.$file->getClientOriginalExtension();

            in_array($extension, ['jpeg', 'jpg', 'png'])  ? Image::make($file)->save(base_path().'/public/uploads/settings/'.$filename ) : ($extension === 'gif' ? $file->move('public/uploads/settings', $filename)  : $file->move('public/uploads/settings', $filename)); 

            $inputs +=  ['LG_splash_screen' => $filename ];
        }

        
        if($request->hasFile('RokuTV_splash_screen')){

            if (File::exists(base_path('public/uploads/settings/'.$request->RokuTV_splash_screen))) {
        
                File::delete(base_path('public/uploads/settings/'.$request->RokuTV_splash_screen));
            }
            
            $file = $request->RokuTV_splash_screen;

            $extension = $file->getClientOriginalExtension();

            $filename   = 'AndroidTv-splash-screen-'.time().'.'.$file->getClientOriginalExtension();

            in_array($extension, ['jpeg', 'jpg', 'png'])  ? Image::make($file)->save(base_path().'/public/uploads/settings/'.$filename ) : ($extension === 'gif' ? $file->move('public/uploads/settings', $filename)  : $file->move('public/uploads/settings', $filename)); 

            $inputs +=  ['RokuTV_splash_screen' => $filename ];
        }

        if($request->hasFile('Samsung_splash_screen')){

            
            if (File::exists(base_path('public/uploads/settings/'.$request->Samsung_splash_screen))) {
        
                File::delete(base_path('public/uploads/settings/'.$request->Samsung_splash_screen));
            }
            
            $file = $request->Samsung_splash_screen;

            $extension = $file->getClientOriginalExtension();

            $filename   = 'LG-splash-screen-'.time().'.'.$file->getClientOriginalExtension();

            in_array($extension, ['jpeg', 'jpg', 'png'])  ? Image::make($file)->save(base_path().'/public/uploads/settings/'.$filename ) : ($extension === 'gif' ? $file->move('public/uploads/settings', $filename)  : $file->move('public/uploads/settings', $filename)); 

            $inputs +=  ['Samsung_splash_screen' => $filename ];
        }

        if($request->hasFile('Firetv_splash_screen')){

            if (File::exists(base_path('public/uploads/settings/'.$request->Firetv_splash_screen))) {
        
                File::delete(base_path('public/uploads/settings/'.$request->Firetv_splash_screen));
            }
            

            $file = $request->Firetv_splash_screen;

            $extension = $file->getClientOriginalExtension();

            $filename   = 'RokuTV-splash-screen-'.time().'.'.$file->getClientOriginalExtension();

            in_array($extension, ['jpeg', 'jpg', 'png'])  ? Image::make($file)->save(base_path().'/public/uploads/settings/'.$filename ) : ($extension === 'gif' ? $file->move('public/uploads/settings', $filename)  : $file->move('public/uploads/settings', $filename)); 

            $inputs +=  ['Firetv_splash_screen' => $filename ];
        }

        TVSplashScreen::where('id',$id)->update($inputs) ;

        return Redirect::to('admin/mobileapp')
            ->with(array(
            'message' => 'Successfully updated!',
            'note_type' => 'success'
        ));
    }

    
    public function AnalyticsIndex(Request $request)
    {
        try {
            // Default filters
            $revenueType = $request->input('revenue_type', 'overall'); // overall, ppv, subscription
            $dateFilter = $request->input('date_filter', 'last_7_days'); // last_7_days, last_30_days, last_90_days, lifetime

            // Date range logic
            $startDate = null;
            $endDate = now();

            switch ($dateFilter) {
                case 'last_7_days':
                    $startDate = now()->subDays(7);
                    break;
                case 'last_30_days':
                    $startDate = now()->subDays(30);
                    break;
                case 'last_90_days':
                    $startDate = now()->subDays(90);
                    break;
                case 'lifetime':
                    $startDate = null;
                    break;
            }

            // Fetch data based on revenue type
            $ppvRevenue = 0;
            $subscriptionRevenue = 0;
            $ppvData = collect();
            $subscriptionData = collect();
            

            if ($revenueType === 'overall' || $revenueType === 'ppv') {
                $ppvQuery = PpvPurchase::with(['video', 'user'])->orderBy('created_at','DESC');
                if ($startDate) {
                    $ppvQuery->whereBetween('created_at', [$startDate, $endDate]);
                }
                $ppvRevenue = $ppvQuery->sum('total_amount');
                $ppvData = $ppvQuery->paginate(10, ['*'], 'ppv_page'); // Add pagination here
            
                // Add related data transformations
                $ppvData->getCollection()->transform(function ($item) {
                    $item['video_name'] = Video::where('id', $item->video_id)->pluck('title')->first();
                    $item['slug'] = Video::where('id', $item->video_id)->pluck('slug')->first();
                    $item['series_name'] = Series::where('id', $item->series_id)->pluck('title')->first();
                    $item['season_name'] = SeriesSeason::where('id', $item->season_id)->pluck('series_seasons_name')->first();
                    $item['user_name'] = User::where('id',$item->user_id)->pluck('name')->first();
                    return $item;
                });
            }
            
            if ($revenueType === 'overall' || $revenueType === 'subscription') {
                $subscriptionQuery = Subscription::with('user')->orderBy('created_at','DESC');
                if ($startDate) {
                    $subscriptionQuery->whereBetween('created_at', [$startDate, $endDate]);
                }
                $subscriptionRevenue = $subscriptionQuery->sum('price');
                $subscriptionData = $subscriptionQuery->paginate(10, ['*'], 'subscription_page');

                $subscriptionData->getCollection()->transform(function ($item) {
                    $item['user_name'] = User::where('id',$item->user_id)->pluck('name')->first();
                    return $item;
                });
            }
            

            // Calculate total revenue
            $totalRevenue = $ppvRevenue + $subscriptionRevenue;

            // Pass data to the view
            return view('admin.analytics.analyticsIndex', [
                'revenueType' => $revenueType,
                'dateFilter' => $dateFilter,
                'ppvRevenue' => $ppvRevenue,
                'subscriptionRevenue' => $subscriptionRevenue,
                'totalRevenue' => $totalRevenue,
                'ppvData' => $ppvData,
                'subscriptionData' => $subscriptionData,
            ]);
        } catch (\Throwable $th) {
            // return $th->getMessage();
            return abort(404);
        }
    }


    public function TV_Splash_destroy($id)
    {
 
        $Splash = TVSplashScreen::where('id',$id)->delete();

        return Redirect::to('admin/mobileapp')
            ->with(array(
            'message' => 'Successfully deleted!',
            'note_type' => 'success'
        ));
    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->input('ids');
        
        try {
            \DB::table('continue_watchings')->whereIn('user_id', $ids)->delete();
            User::whereIn('id', $ids)->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function updateStripeStatus(Request $request)
        {


            $user = Subscription::find($request->user_id);
            $user->stripe_status = $request->stripe_status;
            $user->save();

            $user_details = User::find($user->user_id);
            
            try {

                $email_subject = "You're Subscription status has been successfully updated" ;

                \Mail::send('emails.subscriptionStatusUpdate', array(
                    'name'          => ucwords($user_details->username),
                    'username'          => ucwords($user_details->username),
                    'stripe_status'          => ucwords($request->stripe_status),
                ), 

                function($message) use ($request,$user_details,$email_subject){

                    $message->from(AdminMail(),GetWebsiteName());
                    $message->to($user_details->email, $user_details->username)->subject($email_subject);
                });

                $email_log      = 'Mail Sent Successfully from Become Subscription';
                $email_template = "45";
                $user_id = $user_details->id;

                Email_sent_log($user_id,$email_log,$email_template);

            } catch (\Throwable $th) {

                $email_log      = $th->getMessage();
                $email_template = "23";
                $user_id = $user_details->id;

                Email_notsent_log($user_id,$email_log,$email_template);
            }


            return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
        }



    //     public function UsersStats(Request $request)
    //     {
    //         try {

    //             $startDate = $request->input('startDate');
    //             $endDate = $request->input('endDate');

    //                 $userStatisticsQuery = User::select(
    //                         DB::raw('DATE_FORMAT(created_at, "%b %Y") as month'), 
    //                         DB::raw('COUNT(id) as new_users'),
    //                         DB::raw('(SELECT COUNT(*) FROM users as u2 WHERE u2.created_at <= users.created_at) as total_users')
    //                     )
    //                     ->groupBy(DB::raw('DATE_FORMAT(created_at, "%b %Y")'))
    //                     ->orderBy('created_at', 'desc')
    //                     ->paginate(10);

    //                 $pastUserStatisticsQuery = User::select(
    //                     DB::raw('DATE(created_at) as basedate'),
    //                     DB::raw('DATE_FORMAT(created_at, "%b %d, %Y") as date'),
    //                     DB::raw('COUNT(id) as new_users'),
    //                     DB::raw('(SELECT COUNT(*) FROM users as u2 WHERE u2.created_at <= users.created_at) as total_users')
    //                 )
    //                 ->where('created_at', '>=', now()->subDays(7))
    //                 ->groupBy(DB::raw('DATE(created_at)'))
    //                 ->orderBy('created_at', 'asc')
    //                 ->get();

    //         if ($request->ajax()) {
    //             return response()->json([
    //                 'userStatistics' => $userStatistics,
    //             ]);
    //         }

    //         $data = array(
    //             'userStatistics' => $userStatisticsQuery,
    //             'PastuserStatisticsQuery' => $pastUserStatisticsQuery,
    //         );

    //         return view('admin.users.users_statistics', $data);
        
    //     } catch (\Throwable $th) {
    //         throw $th;
    //     }
    // }
        
    public function UsersStats(Request $request)
    {
        try {
            $selectedYear = $request->input('year', now()->year);
    
            $currentMonth = now()->month;
    
            $userStatistics = User::select(
                    DB::raw('DATE_FORMAT(created_at, "%b %Y") as month'),
                    DB::raw('YEAR(created_at) as year'),
                    DB::raw('MONTH(created_at) as month_number'),
                    DB::raw('COUNT(id) as new_users')
                )
                ->when($selectedYear == now()->year, function ($query) use ($currentMonth, $selectedYear) {
                    return $query->whereYear('created_at', $selectedYear)
                                 ->whereMonth('created_at', '<=', $currentMonth);
                }, function ($query) use ($selectedYear) {
                    return $query->whereYear('created_at', $selectedYear);
                })
                ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
                ->orderBy('year', 'DESC')
                ->orderBy('month_number', 'DESC')
                ->get()
                ->toArray();
    
              $monthlyData = [];
                $totalUsers = 0; 
        
                for ($month = 1; $month <= $currentMonth; $month++) {
                    $found = false;
                    foreach ($userStatistics as $stat) {
                        if ($stat['month_number'] == $month) {
                            $totalUsers += $stat['new_users']; 
                            $monthlyData[$month] = [
                                'month' => date('M Y', mktime(0, 0, 0, $month, 1, $selectedYear)),
                                'new_users' => $stat['new_users'],
                                'total_users' => $this->getTotalUsersUpToMonth($month, $selectedYear) 
                            ];
                            $found = true;
                            break;
                        }
                    }
                    if (!$found) {
                        $previous_total_users = isset($monthlyData[$month - 1]) ? $monthlyData[$month - 1]['total_users'] : $totalUsers; // Default to the last known total
                        $monthlyData[$month] = [
                            'month' => date('M Y', mktime(0, 0, 0, $month, 1, $selectedYear)),
                            'new_users' => 0,
                            'total_users' => $previous_total_users 
                        ];
                    }
                }
        
                $pastUserStatisticsQuery = User::select(
                        DB::raw('DATE(created_at) as basedate'),
                        DB::raw('DATE_FORMAT(created_at, "%b %d, %Y") as date'),
                        DB::raw('COUNT(id) as new_users'),
                        DB::raw('(SELECT COUNT(*) FROM users as u2 WHERE u2.created_at <= users.created_at) as total_users')
                    )
                    ->where('created_at', '>=', now()->subDays(7))
                    ->groupBy(DB::raw('DATE(created_at)'))
                    ->orderBy('created_at', 'asc')
                    ->get()
                    ->keyBy('basedate');
        
                $lastSevenDays = collect();
                for ($i = 0; $i < 7; $i++) {
                    $lastSevenDays->push(Carbon::now()->subDays($i)->format('Y-m-d'));
                }
        
                $result = [];
                foreach ($lastSevenDays as $date) {
                    $formattedDate = $date;
                    $result[] = [
                        'basedate' => $formattedDate,
                        'date' => Carbon::parse($formattedDate)->format('M d, Y'),
                        'new_users' => $pastUserStatisticsQuery->get($formattedDate)->new_users ?? 0,
                        'total_users' => $pastUserStatisticsQuery->get($formattedDate)->total_users ?? 0
                    ];
                }
        
            $data = [
                'userStatistics' => array_reverse(array_values($monthlyData)),
                'pastUserStatisticsQuery' => $result,
                'currentYear' => now()->year,
                'selectedYear' => $selectedYear,
                'years' => range(now()->year - 10, now()->year), 
            ];
    
            return view('admin.users.users_statistics', $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    
    
    private function getTotalUsersUpToMonth($month, $year)
    {
        return User::where(function ($query) use ($month, $year) {
                $query->whereMonth('created_at', '<=', $month);
            })
            ->whereYear('created_at', '<=', now()->year) 
            ->count();
    }
    
    public function UsersStatsFilter(Request $request)
    {
        try {
            $selectedYear = $request->input('year', now()->year);
            $currentYear = now()->year;
            $currentMonth = now()->month;
    
            $totalUsersUpToYear = User::whereYear('created_at', '<', $selectedYear)->count();
    
            $userStatistics = User::select(
                    DB::raw('DATE_FORMAT(created_at, "%b %Y") as month'),
                    DB::raw('YEAR(created_at) as year'),
                    DB::raw('MONTH(created_at) as month_number'),
                    DB::raw('COUNT(id) as new_users')
                )
                ->whereYear('created_at', $selectedYear) 
                ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
                ->orderBy('month_number')
                ->get()
                ->toArray();
    
            $monthlyData = [];
            $totalUsers = $totalUsersUpToYear; 
    
            $endMonth = ($selectedYear == $currentYear) ? $currentMonth : 12;
    
            for ($month = 1; $month <= $endMonth; $month++) {
                $found = false;
                foreach ($userStatistics as $stat) {
                    if ($stat['month_number'] == $month) {
                        $totalUsers += $stat['new_users']; 
                        $monthlyData[$month] = [
                            'month' => date('M Y', mktime(0, 0, 0, $month, 1, $selectedYear)),
                            'new_users' => $stat['new_users'],
                            'total_users' => $totalUsers 
                        ];
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    $monthlyData[$month] = [
                        'month' => date('M Y', mktime(0, 0, 0, $month, 1, $selectedYear)),
                        'new_users' => 0,
                        'total_users' => $totalUsers
                    ];
                }
            }
    
            $monthlyData = array_reverse(array_values($monthlyData)); 
    
            $pastUserStatisticsQuery = User::select(
                    DB::raw('DATE(created_at) as basedate'),
                    DB::raw('DATE_FORMAT(created_at, "%b %d, %Y") as date'),
                    DB::raw('COUNT(id) as new_users'),
                    DB::raw('(SELECT COUNT(*) FROM users as u2 WHERE u2.created_at <= users.created_at) as total_users')
                )
                ->where('created_at', '>=', now()->subDays(7))
                ->groupBy(DB::raw('DATE(created_at)'))
                ->orderBy('created_at', 'asc')
                ->get()
                ->keyBy('basedate');
    
            $lastSevenDays = collect();
            for ($i = 0; $i < 7; $i++) {
                $lastSevenDays->push(Carbon::now()->subDays($i)->format('Y-m-d'));
            }
    
            $result = [];
            foreach ($lastSevenDays as $date) {
                $formattedDate = $date;
                $result[] = [
                    'basedate' => $formattedDate,
                    'date' => Carbon::parse($formattedDate)->format('M d, Y'),
                    'new_users' => $pastUserStatisticsQuery->get($formattedDate)->new_users ?? 0,
                    'total_users' => $pastUserStatisticsQuery->get($formattedDate)->total_users ?? 0
                ];
            }
    
            $data = [
                'userStatistics' => $monthlyData, 
                'pastUserStatisticsQuery' => $result,
                'currentYear' => now()->year,
                'selectedYear' => $selectedYear,
                'years' => range(now()->year - 10, now()->year),
            ];
    
            return response()->json([
                'userStatistics' => $monthlyData,
                'pastUserStatisticsQuery' => $result,
            ]);
    
            return view('admin.users.users_statistics', $data);
    
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    

    


}
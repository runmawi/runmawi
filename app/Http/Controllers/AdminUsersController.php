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
use Theme;

class AdminUsersController extends Controller
{

   public function index(Request $request)
	{
       
        $user = $request->user();
        //dd($user->hasRole('admin','editor')); // and so on
       
      // dd($user->can('permission-slug'));
       
       //dd($user->hasRole('developer')); //will return true, if user has role
       //dd($user->givePermissionsTo('create-tasks'));// will return permission, if not null
       //dd($user->can('create-tasks')); // will return true, if user has permission

        //exit;
        $total_subscription = Subscription::where('stripe_status','=','active')->count();
        
        $total_videos = Video::where('active','=',1)->count();
       
        $total_ppvvideos = PpvVideo::where('active','=',1)->count();

        $total_user_subscription = User::where('role','=','subscriber')->count();
        
        
       $total_recent_subscription = Subscription::orderBy('created_at', 'DESC')->whereDate('created_at', '>=', \Carbon\Carbon::now()->today())->count();
       $top_rated_videos = Video::where("rating",">",7)->get();
      
    //    $total_revenew = Subscription::all();
       $total_revenew = Subscription::sum('price');

      
        $search_value = '';
        
        if(!empty($search_value)):
            $users = User::where('username', 'LIKE', '%'.$search_value.'%')->orWhere('email', 'LIKE', '%'.$search_value.'%')->orderBy('created_at', 'desc')->get();
        else:
            $users = User::all();
        endif;
// print_r($total_revenew);
// exit();
		$data = array(
			'users' => $users,
            'total_subscription' => $total_subscription,
            'total_revenew' => $total_revenew,
            'total_recent_subscription' => $total_recent_subscription,
            'total_videos' => $total_videos,
            'top_rated_videos' => $top_rated_videos,
			);
		return \View::make('admin.users.index', $data);
	}
    
    public function create(){
        
        $data = array(
            'post_route' => URL::to('admin/user/store'),
            'admin_user' => Auth::user(),
            'button_text' => 'Create User',
            );
        
        return \View::make('admin.users.create_edit', $data);
    }
    public function view($id){
        
    	$user = User::find($id);
  
   
       $current_plan = [];
     
        $current_plan = User::select(['subscriptions.*','plans.plans_name','plans.billing_interval','plans.days'])
        ->join('subscriptions', 'subscriptions.user_id', '=', 'users.id')
        ->join('plans', 'subscriptions.stripe_plan', '=', 'plans.plan_id')
        ->where('role', '=', 'subscriber' )
        ->where('users.id', '=', $user->id )
        ->get();
               $country_name = CountryCode::where('phonecode','=',$user->ccode)->get();
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
    public function store(Request $request){
        
       
         $validatedData = $request->validate([
                'email' => 'required|max:255',
                'username' => 'required|max:255',
            ]);
        
        $input = $request->all();
        // echo "<pre>";
        // print_r($input);
        // exit();
        $user = Auth::user();
        
        
        $path = public_path().'/uploads/avatars/'; 
        
        $input['email'] = $request['email'];
        
        $path = public_path().'/uploads/avatars/';
        
        $logo = $request['avatar'];
        
        if($logo != '') {   
          //code for remove old file
          if($logo != ''  && $logo != null){
               $file_old = $path.$logo;
              if (file_exists($file_old)){
               unlink($file_old);
              }
          }
          //upload new file
          $file = $logo;
          $input['avatar']  = $file->getClientOriginalName();
          $file->move($path, $input['avatar']);
         
     }
     $string = Str::random(60); 

     $password = Hash::make($request['passwords']);

     $user = new User;
     $user->username = $request['username'];
     $user->email = $request['email'];
     $user->mobile = $request['mobile'];
     $password = Hash::make($request['passwords']);
     $user->ccode = $request['ccode'];
     $user->role = $request['role'];
     $user->activation_code = $string;

    //  $user->terms = $request['terms'];
     $user->avatar = $file->getClientOriginalName();
     $user->password = $password;
    $user->save();
    $settings = Setting::first();

    if($input['role'] == "subscriber"){
        \Mail::send('emails.verify', array('activation_code' => $string, 'website_name' => $settings->website_name), function($message)  use ($request,$input) {
            $message->to($request->email,$request->name)->subject('Verify your email address');
         });
    }else{

    }

    //  $moderatorsuser->description = $request->description;
    //     if ( $input['role'] =='subadmin' ){
            
    //             $request['role'] ='admin';
    //             $request['sub_admin'] = 1;
    //             $request['stripe_active'] = 1;
            
    //     } else {
            
    //          $request['role'] = $request['role'];
    //     }
        
        if ( empty($request['email'])){
            return Redirect::to('admin/user/create')->with(array('note' => 'Successfully Created New User', 'note_type' => 'failed') );
            
        } else {
            
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
            $template = EmailTemplate::where('id','=',10)->first();
            $heading =$template->heading; 
            //   echo "<pre>";
            // print_r($heading);
            // exit();
            if($input['role'] == "subscriber"){

            Mail::send('emails.sub_user', array(
                /* 'activation_code', $user->activation_code,*/
                'name'=>$request['username'], 
                'email' => $request['email'], 
                'password' => $request['passwords'], 

                ), function($message) use ($request,$user,$heading) {
                $message->from(AdminMail(),'Flicknexs');
                $message->to($request['email'], $request['username'])->subject($heading.$request['username']);
                });

            }else{

            }



        return Redirect::to('admin/users')->with(array('message' => 'Successfully Created New User', 'note_type' => 'success') );
    }
    
    
    public function update(Request $request){
        
       
        $input = $request->all();
        
         $validatedData = $request->validate([
                'email' => 'required|max:255',
                'id' => 'required|max:255',
                'username' => 'required|max:255',
         ]);
        
        $id = $request['id'];
        
		$user = User::find($id);        
        $input = $request->all();        
       // $user = Auth::user();       
        
        $path = public_path().'/uploads/avatars/';         
        $input['email'] = $request['email'];  
        
        $path = public_path().'/uploads/avatars/';        
        $logo = $request['avatar'];        
        
        if($logo != '') {   
          //code for remove old file
          if($logo != ''  && $logo != null){
               $file_old = $path.$logo;
              if (file_exists($file_old)){
               unlink($file_old);
              }
          }
          //upload new file
          $file = $logo;
          $input['avatar']  = $file->getClientOriginalName();
          $file->move($path, $input['avatar']);
         
     }
      
        if ( $input['role'] =='subadmin' ){
            
                $request['role'] ='admin';
                $request['sub_admin'] = 1;
                $request['stripe_active'] = 1;
            
        } else {
            
             $request['role'] = $request['role'];
        }
        
        if ( empty($request['email'])){
            return Redirect::to('admin/user/create')->with(array('note' => 'Successfully Created New User', 'note_type' => 'failed') );
            
        } else {
            
             $request['email'] = $request['email'];
        }
        
        $input['terms'] = 1;
        $input['stripe_active'] = 0;


        if(empty($request['passwords'])) {
        	$input['passwords'] = $user->password;
        } 
        else { 
                $input['passwords'] = $request['passwords']; 
            }
       
        $user_update = User::find($id);
        $user_update->email = $input['email'];
        $user_update->password = $input['passwords'];
        $user_update->role = $input['role'];
        $user_update->terms = $input['terms'];
        $user_update->stripe_active = $input['stripe_active'];
        $user_update->username = $input['username'];
        $user_update->save();
        
        return Redirect::to('admin/users')->with(array('message' => 'Successfully Created New User', 'note_type' => 'success') );
    }
    
    
    public function edit($id){
        
    	$user = User::find($id);
    	$data = array(
    		'user' => $user,
    		'post_route' => URL::to('admin/user/update'),
    		'admin_user' => Auth::user(),
    		'button_text' => 'Update User',
    		);
    	return View::make('admin.users.create_edit', $data);
    } 
    
    public function myprofile(){

        $Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses($Theme);

        if(Auth::guest()){
            return redirect('/login');
        }
        $data = Session::all();
        // $session_password = $data['password_hash'];
        if (empty($data['password_hash'])) {
            $system_settings = SystemSetting::first();

            return Theme::view('auth.login',compact('system_settings'));

            // return View::make('auth.login', $data);

          }else{
        
    	$user_id = Auth::user()->id;
    	$user_role = Auth::user()->role;
       
        if($user_role == 'registered' || $user_role == 'admin' ){
            $role_plan  = $user_role;
        }elseif($user_role == 'subscriber'){

    $user_role = Subscription::where('subscriptions.user_id','=',$user_id)
    ->join('plans', 'plans.plan_id', '=', 'subscriptions.stripe_plan')
    ->select('plans.plans_name')
    ->get(9);
    //    print_r($user_role);
    //    exit();
       if(!empty($user_role)){
        $role_plan = "No Plan";
       }else{
       $role_plan = $user_role[0]->plans_name;
       }
        }
    	$user_role = Auth::user()->role;

    	$user_details = User::find($user_id);
        $recent_videos = RecentView::orderBy('id', 'desc')->take(10)->get();
        $recent_view = $recent_videos->unique('video_id');

        foreach($recent_view as $key => $value){
        $videos[] = Video::Where('id', '=',$value->video_id)->take(10)->get();
        }
        // dd($videos);
        // $recent_view = $videos->unique('slug');

        $videocategory = VideoCategory::all();
        $language = Language::all();

// Multiuser profile details
        $Multiuser = Session::get('subuser_id');
      
        if($Multiuser != null){
              $users = Multiprofile::where('id',$Multiuser)->pluck('id')->first();
              $profile_details = Multiprofile::where('id', $users)->get();
        } else{  
            $users =User::where('id',Auth::user()->id)->pluck('id')->first();   
            $profile_details = Multiprofile::where('parent_id', $users)->get();
        }


        $video = array_unique($videos);
    	$data = array(
    		'videos' => $video,
    		'videocategory' => $videocategory,
    		'user' => $user_details,
    		'role_plan' => $role_plan,
    		'user_role' => $user_role,
    		'post_route' => URL::to('/profile/update'),
            'language' => $language,
            'profile_details' => $profile_details,
            'Multiuser' => $Multiuser,
    		);
    	return Theme::view('myprofile', $data);
          }
    }
    public function ProfileImage(Request $request){
      
    $input = $request->all();

   $id = $request['user_id'];

   $path = public_path().'/uploads/avatars/';         
   $input['email'] = $request['email'];  
   
   $path = public_path().'/uploads/avatars/';        
   $logo = $request['avatar'];        
   
   if($logo != '') {   
     //code for remove old file
     if($logo != ''  && $logo != null){
          $file_old = $path.$logo;
         if (file_exists($file_old)){
          unlink($file_old);
         }
     }
     //upload new file
     $file = $logo;
     $input['avatar']  = $file->getClientOriginalName();
     $file->move($path, $input['avatar']);
    
}
 
   $user_update = User::find($id);
   $user_update->avatar = $file->getClientOriginalName();
   $user_update->save();
   
   return Redirect::back();

}
    public function myprofileupdate(Request $request){
            // echo "<pre>";
      
        $input = $request->all();
        
        // print_r($input);
        // exit();
       $id = $request['user_id'];
       
       $user = User::find($id);        

       
       if ( empty($request['email'])){
           return Redirect::to('admin/user/create')->with(array('note' => 'Successfully Created New User', 'note_type' => 'failed') );
           
       } else {
           
            $request['email'] = $request['email'];
       }



       if(empty($request['password'])) {
           $input['password'] = $user->password;
       } 
       else { 
               $input['password'] = $request['password']; 
           }
      
       $user_update = User::find($id);
       $user_update->email = $input['email'];
       $user_update->password = Hash::make($input['password']);
       $user_update->mobile = $input['mobile'];
       $user_update->username = $input['username'];
       $user_update->save();
       
       return Redirect::back();
 
    }
    
    public function refferal() {
    	return View::make('refferal');
    }
    
    
    
    public function profileUpdate(User $user,Request $request)
    {


//         $data = $request->validate([
//            'name' => 'required',
//             'email' => 'required|email|unique:users',
//         ]);

//        $user->fill($data);
//        $user->save();
      
         $user = User::find(Auth::user()->id);
         $user->username = $request->get('name');
         $user->mobile = $request->get('mobile');
         $user->email = $request->get('email');
         $user->ccode = $request->get('ccode');
            if (!empty($request->get('password'))) {
               $user->password = $request->get('password');
            }
             $path = public_path().'/uploads/avatars/';
            $image_path = public_path().'/uploads/avatars/';
        
            $image_req = $request['avatar'];
      
           $image = (isset($image_req)) ? $image_req : '';
          
             if($image != '') {   
                  //code for remove old file
                  if($image != ''  && $image != null){
                       $file_old = $image_path.$image;
                      if (file_exists($file_old)){
                       unlink($file_old);
                      }
                  }
                  //upload new file
                  $file = $image;
                  $user->avatar  = $file->getClientOriginalName();
                  $file->move($image_path, $user->avatar);

             }
        
        
        
         $user->save();
        
        
        //Flash::message('Your account has been updated!');
        return back();
    }
    
    
    public function mobileapp() {
          $mobile_settings = MobileApp::get();
          $allCategories = MobileSlider::all();
          $data = array(
            'admin_user' => Auth::user(),
            'mobile_settings' => $mobile_settings,
            'allCategories'=>$allCategories
          );
          return View::make('admin.mobile.index', $data);

    }


    public function mobileappupdate(Request $request) {

        $input = $request->all();

        $path = public_path().'/uploads/settings/';
        $splash_image = $request['splash_image'];
        $file = $splash_image;
        $input['splash_image']  = $file->getClientOriginalName();
        $file->move($path, $input['splash_image']);

        MobileApp::create([
            'splash_image'  => $input['splash_image'] ,
          ]);

        return Redirect::to('admin/mobileapp')->with(array('message' => 'Successfully Updated  Settings!', 'note_type' => 'success') );

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
        if($agent->isDesktop()) {
            $device_name = 'desktop';
        }elseif ($agent->isTablet()) {
            $device_name = 'tablet';
        }elseif ($agent->isMobile()) {
            $device_name = 'mobile';
        }elseif ($agent->isMobile()) {
            $device_name = 'mobile';
        }else {
            $device_name = 'tv';
        }
        if(!empty($device_name)){
            $devices_check = LoggedDevice::where('user_ip','=', $userIp)->where('user_id','=', Auth::User()->id)->where('device_name','=', $device_name)->first();
            if(!empty($devices_check)){
                $devices_check = LoggedDevice::where('user_ip','=', $userIp)->where('user_id','=', Auth::User()->id)->where('device_name','=', $device_name)->delete();
                }
        }
        Auth::logout();
        unset($data['password_hash']);

        \Session::flush();
        
        
        return Redirect::to('/')->with(array('message' => 'You are logged out done', 'note_type' => 'success') );
    }
    
    public function destroy($id)
        {

            User::destroy($id);
            return Redirect::to('admin/users')->with(array('message' => 'Successfully Deleted User', 'note_type' => 'success') );
        }

        public function VerifyDevice($id)
        {
            // dd($id);

            $device = LoggedDevice::find($id);
            $username = @$device->user_name->username;
            $email = @$device->user_name->email;
            $user_ip = @$device->user_ip;
            $device_name = @$device->device_name;

            $mail_check = ApprovalMailDevice::where('user_ip','=', $user_ip)->where('device_name','=', $device_name)->first();

            if(empty($mail_check)){
            // dd($device->user_name->username);

            Mail::send('emails.device_logout', array(
                /* 'activation_code', $user->activation_code,*/
                'name'=>$username, 
                'email' => $email, 
                'user_ip' => $user_ip, 
                'device_name' => $device_name, 
                'id' => $id, 
                ), function($message) use ($email,$username) {
                $message->from(AdminMail(),'Flicknexs');
                $message->to($email, $username)->subject('Request to Logout Device');
                });
                $maildevice = new ApprovalMailDevice;
                $maildevice->user_ip = $userIp;
                $maildevice->device_name = $device_name;
                $maildevice->status = 0;
                $maildevice->save();
            $message = 'Mail Sent to the'.' '.$username;
            return Redirect::back()->with('alert', $message);
            }elseif(!empty($mail_check) && $mail_check->status == 2 || $mail_check->status == 0){
            return Redirect::back();
            }
        }
        public function LogoutDevice($id)
        {
            // dd($id);
            $device = LoggedDevice::find($id);
            $username = @$device->user_name->username;
            $email = @$device->user_name->email;
            $device_name = @$device->device_name;
            $maildevice = ApprovalMailDevice::where('user_ip','=', $user_ip)->where('device_name','=', $device_name)->first();
            $maildevice->status = 1;
            $maildevice->save();

            LoggedDevice::destroy($id);

            
            return Redirect::to('home');
            // return Redirect::to('/home');

            // return Redirect::back();
        }
        public function ApporeDevice($ip,$id,$device_name)
        {
            // $adddevice = new LoggedDevice;
            // $adddevice->user_id = $id;
            // $adddevice->user_ip = $ip;
            // $adddevice->device_name = $device_name;
            // $adddevice->save();
          
            $data = array(
                'user_ip' => $ip,
                'device_name' => $device_name,
                'id'=>$id
              );
              return View::make('device_accept', $data);
            // $message = 'Approved User For Login';
            // return View::make('auth.login')->with('alert', $message);
        }
        public function AcceptDevice($user_ip,$device_name,$id)
        {
            // dd($device_name);
            $adddevice = new LoggedDevice;
            $adddevice->user_id = $id;
            $adddevice->user_ip = $user_ip;
            $adddevice->device_name = $device_name;
            $adddevice->save();
            $maildevice = ApprovalMailDevice::where('user_ip','=', $user_ip)->where('device_name','=', $device_name)->first();
            $maildevice->status = 1;
            $maildevice->save();
            $system_settings = SystemSetting::first();
            $user = User::where('id','=',1)->first();
            $message = 'Approved User For Login';
            return Redirect::to('/')->with('alert', $message);

            // return View::make('auth.login')->with('alert', $message);
        }
        public function RejectDevice($userIp,$device_name)
        {
            $maildevice = ApprovalMailDevice::where('user_ip','=', $userIp)->where('device_name','=', $device_name)->first();
            $maildevice->status = 2;
            $maildevice->save();
            $system_settings = SystemSetting::first();
            $user = User::where('id','=',1)->first();
            $message = 'Approved User For Login';
            return Redirect::back('/')->with('alert', $message);

          
        }
        public function export(Request $request) {

            $input = $request->all();
            $start_date = $input['start_date'];
            $end_date = $input['end_date'] ;
                $users = User::all();
                // $start_Date=$input['start_date'];
                // $end_Date=$input['end_date'];
                $country_name = CountryCode::get();

                foreach($country_name as $key => $values ){

                    $phonecode[] = $values->phonecode;
                    $country_names[] = $values->name;
                    }
                    foreach($users as $user_ccode){
                        $ccode[] =$user_ccode->ccode;
                      
                       } 
                            $current_plan = User::select(['subscriptions.*','users.*','plans.plans_name','plans.billing_interval','plans.days'])
                ->join('subscriptions', 'subscriptions.user_id', '=', 'users.id')
                ->join('plans', 'subscriptions.stripe_plan', '=', 'plans.plan_id')
                ->where('role', '=', 'subscriber' )
                ->get();
                // $current_plan = \DB::table('users')
                // ->select(['subscriptions.*','users.*','plans.plans_name','plans.billing_interval','plans.days'])
                // ->join('subscriptions', 'subscriptions.user_id', '=', 'users.id')
                // ->join('plans', 'subscriptions.stripe_plan', '=', 'plans.plan_id')
                // ->where('role', '=', 'subscriber' )
                // ->get();
            if($start_date =="" &&  $end_date == ""){

                foreach($users as $user) {
                 $user_array[] = array(
                   'Username' => $user->username,
                   'User ID' =>$user->id,
                   'Email' =>$user->email,
                   'Contact Number' =>$user->mobile,
                   'Country Name' =>$user->ccode,
                    'ccode' => array(),
                    'options' => array(),
                   'User Type' =>$user->role,
                   'Active' =>$user->active,
                );
                    foreach($current_plan as $plans){
                        if($plans->user_id == $user->id){                                
                    $subscription_date = $current_plan[0]->created_at;
                    $days = $current_plan[0]->days.'days';
                    $date = date_create($subscription_date);
                    $subscription_date = date_format($date, 'Y-m-d');
                    $end_date= date('Y-m-d', strtotime($subscription_date. ' + ' .$days)); 
                    // echo $end_date; 
                    $user_array['options'][$user->id] =  array(
                        'Current Package' => $plans->billing_interval,  
                        'Start Date' => $plans->created_at,
                        'End Date' =>$end_date,
                    );
                }   
                 }
                 foreach($country_name as $name){
                    if(in_array($name->phonecode,$ccode)){
                        $coun[$name->phonecode] = $name->country_name;
                        foreach($coun as $key => $coun_name){
        
                            if($key == $user->ccode){ 
                               $user_array['ccode'][$user->id] =  array(
                                'Country Name' =>  $coun_name ,
                            );
        
                       }
                         }
                       
                 }
                 }
             
            }
            foreach($users as $k => $value){
            $package = "";
            $startdate = "";
            $enddate = "";
            foreach($user_array['options'] as $keys => $plans){
                $plankeys[]= $keys;
                if($value->id == $keys){
                    $package = $plans['Current Package'];
                    // print_r($plans['Start Date']);
                    $startdate = $plans['Start Date'];
                    $enddate = $plans['End Date'];
                }
                }
                // exit();

                $countryname = "";
            foreach($user_array['ccode'] as $key => $ccode){
                $ccodekey[] = $key;
                if($value->id == $key){
                $countryname = $ccode['Country Name'];
            }

            }               
            $data[] = array(
                'Username' => $value->username,
                'User ID' =>$value->id,
                'Email' =>$value->email,
                'Contact Number' =>$value['mobile'],
                'Country Name' => $countryname ? $countryname :  NULL,
                'Current Package' => $package ? $package :  NULL,
                'Start Date' =>$startdate ? $startdate :  NULL,
                'End Date' =>$enddate ? $enddate :  NULL,
                'User Type' => $value->role,
                'Active' =>$value->active,
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
     
             foreach($data as $row)
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

            }else{ 
                foreach($users as $user) {
                    $user_array[] = array(
                      'Username' => $user->username,
                      'User ID' =>$user->id,
                      'Email' =>$user->email,
                      'Contact Number' =>$user->mobile,
                      'Country Name' =>$user->ccode,
                       'ccode' => array(),
                       'options' => array(),
                      'User Type' =>$user->role,
                      'Active' =>$user->active,
                   );
                       foreach($current_plan as $plans){
                           if($plans->user_id == $user->id){                                
                       $subscription_date = $current_plan[0]->created_at;
                       $days = $current_plan[0]->days.'days';
                       $date = date_create($subscription_date);
                       $subscription_date = date_format($date, 'Y-m-d');
                       $end_date= date('Y-m-d', strtotime($subscription_date. ' + ' .$days)); 
                       // echo $end_date; 
                       $user_array['options'][$user->id] =  array(
                           'Current Package' => $plans->billing_interval,  
                           'Start Date' => $plans->created_at,
                           'End Date' =>$end_date,
                       );
                   }   
                    }
                    foreach($country_name as $name){
                       if(in_array($name->phonecode,$ccode)){
                           $coun[$name->phonecode] = $name->country_name;
                           foreach($coun as $key => $coun_name){
           
                               if($key == $user->ccode){ 
                                  $user_array['ccode'][$user->id] =  array(
                                   'Country Name' =>  $coun_name ,
                               );
           
                          }
                            }
                          
                    }
                    }
                
               }
               foreach($users as $k => $value){
               $package = "";
               $startdate = "";
               $enddate = "";
               foreach($user_array['options'] as $keys => $plans){
                   $plankeys[]= $keys;
                   if($value->id == $keys){
                       $package = $plans['Current Package'];
                       // print_r($plans['Start Date']);
                       $startdate = $plans['Start Date'];
                       $enddate = $plans['End Date'];
                   }
                   }
                   // exit();

                   $countryname = "";
               foreach($user_array['ccode'] as $key => $ccode){
                   $ccodekey[] = $key;
                   if($value->id == $key){
                   $countryname = $ccode['Country Name'];
               }

               }               
               $data_filter[] = array(
                   'Username' => $value->username,
                   'User ID' =>$value->id,
                   'Email' =>$value->email,
                   'Contact Number' =>$value['mobile'],
                   'Country Name' => $countryname ? $countryname :  NULL,
                   'Current Package' => $package ? $package :  NULL,
                   'Start Date' =>$startdate ? $startdate :  NULL,
                   'End Date' =>$enddate ? $enddate :  NULL,
                   'User Type' => $value->role,
                   'Active' =>$value->active,
                );
               }
   
                $start_date = $input['start_date'];
                $end_date = $input['end_date'] ;
                // echo "<pre>";
                // print_r($input);
                foreach($data_filter as $key => $value){
                    $subscription_date = $value['Start Date'];
                    $date = date_create($subscription_date);
                    $subscription_date = date_format($date, 'Y-m-d');
                    $subscription_date = date('Y-m-d', strtotime($subscription_date));
                    if($subscription_date >= $input['start_date'] && $value['Start Date'] != null &&
                    $value['End Date'] <= $input['end_date'] && $value['End Date'] != null
                    ){
                        
                        $data[] = $value;
                    } else {
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
     
             foreach($data as $row)
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
        $data['states'] = State::where("country_id",$request->country_id)
                    ->get(["name","id"]);
        return response()->json($data);
    }
    public function GetCity(Request $request)
    {
        $data['cities'] = City::where("state_id",$request->state_id)
                    ->get(["name","id"]);
        return response()->json($data);
    }

    public function AnalyticsRevenue(){

    $today_log = UserLogs::orderBy('created_at', 'DESC')->whereDate('created_at', '>=', \Carbon\Carbon::now()->today())->count();
    $lastweek_log = UserLogs::select('*')->whereBetween('created_at',[Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->count();
    $month_log = UserLogs::orderBy('created_at', 'DESC')->whereDate('created_at', '>=', \Carbon\Carbon::now()->month())->count();


    $data = array(
        'today_log' => $today_log,
        'lastweek_log' => $lastweek_log,
        'month_log' => $month_log,
        );
           return \View::make('admin.analytics.revenue',$data);
    } 

    public function ViewsRegion(){

    $Country = Region::get();

    $data = array(
        'Country' => $Country,
        );
           return \View::make('admin.analytics.views_by_region',$data);
    }
    
    public function RevenueRegion (){

        $Country = Region::get();
        $State = State::get();
        $City = City::get();
        // dd($City);
        $data = array(
            'Country' => $Country,
            'State' => $State,
            'City' => $City,

    
            );
               return \View::make('admin.analytics.revenue_by_region',$data);
        }

    public function RegionVideos(Request $request)
    {
        if($request->ajax())
     {

      $output = '';
      $query = $request->get('query');

 
      if($query != '')
      {
        // $regions =  DB::table('regions')->where('regions.id','=',$query)->first();
        $regions =  Region::where('id','=',$query)->first();

        $region_views = RegionView::leftjoin('videos', 'region_views.video_id', '=', 'videos.id')->where('region_views.countryname','=',$regions->name)->get();
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
        $data1 = Video::select('videos.*','region_views.countryname')
        ->join('region_views', 'region_views.video_id', '=', 'videos.id')
        ->orderBy('created_at', 'desc')
        ->where('region_views.countryname','=',$regions->name)
        ->paginate(19);
        // echo "<pre>"; print_r($data);exit();

      }
      else
      {

      }
        $i = 1 ; 
      $total_row = $data1->count();
      if($total_row > 0)
      {
       foreach($data as $row)
       {
        $output .= '
        <tr>
        <td>'.$i++.'</td>
         <td>'.$row[0]->title.'</td>
         <td>'.$row[0]->countryname.'</td>
         <td>'.$row[0]->user_ip.'</td>
         <td>'.count($row).'</td>
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
       'table_data'  => $output,
       'total_data'  => $total_row
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
        if($request->ajax())
     {

      $output = '';
      $query = $request->get('query');

 
      if($query != '')
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
        $data1 = Video::select('videos.*','region_views.countryname')
        ->join('region_views', 'region_views.video_id', '=', 'videos.id')
        ->orderBy('created_at', 'desc')
        ->paginate(9);
        // echo "<pre>"; print_r($data);exit();

      }
      else
      {

      }
        $i = 1 ; 
      $total_row = $data1->count();
      if($total_row > 0)
      {
       foreach($data as $key => $row)
       {
        $output .= '
        <tr>
        <td>'.$i++.'</td>
         <td>'.$row[0]->title.'</td>
         <td>'.$row[0]->countryname.'</td>
         <td>'.$row[0]->user_ip.'</td>
         <td>'.count($row).'</td>
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
       'table_data'  => $output,
       'total_data'  => $total_row
      );

      echo json_encode($data);
     }
    }
    public function PlanCountry(Request $request)
    {
        if($request->ajax())
     {

      $output = '';
      $query = $request->get('query');

      if($query != '')
      {
      
        // $data = DB::table('subscriptions')
        // ->select('users.username','plans.plans_name')
        // ->join('users', 'users.id', '=', 'subscriptions.user_id')
        // ->join('plans', 'plans.plan_id', '=', 'subscriptions.stripe_plan')
        // ->where('subscriptions.countryname','=',$query)
        // ->paginate(9);

        $data = Subscription::select('users.username','plans.plans_name')
        ->join('users', 'users.id', '=', 'subscriptions.user_id')
        ->join('plans', 'plans.plan_id', '=', 'subscriptions.stripe_plan')
        ->where('subscriptions.countryname','=',$query)
        ->paginate(9);

        // echo "<pre>"; print_r($data);exit();

      }
      else
      {

      }
        $i = 1 ; 
      $total_row = $data->count();
      if($total_row > 0)
      {
       foreach($data as $row)
       {
        $output .= '
        <tr>
        <td>'.$i++.'</td>
        <td>'.$row->username.'</td>
         <td>'.$row->plans_name.'</td>
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
       'table_data'  => $output,
       'total_data'  => $total_row
      );

      echo json_encode($data);
     }
    }

    public function PlanAllCity(Request $request)
    {
        if($request->ajax())
     {

      $output = '';
      $query = $request->get('query');

      if($query != '')
      {

        $data =Subscription::select('users.username','plans.plans_name')
        ->join('users', 'users.id', '=', 'subscriptions.user_id')
        ->join('plans', 'plans.plan_id', '=', 'subscriptions.stripe_plan')
        ->paginate(9);

      }
      else
      {

      }
        $i = 1 ; 
      $total_row = $data->count();
      if($total_row > 0)
      {
       foreach($data as $row)
       {
        $output .= '
        <tr>
        <td>'.$i++.'</td>
        <td>'.$row->username.'</td>
         <td>'.$row->plans_name.'</td>
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
       'table_data'  => $output,
       'total_data'  => $total_row
      );

      echo json_encode($data);
     }
    }


    public function PlanAllCountry(Request $request)
    {
        if($request->ajax())
     {

      $output = '';
      $query = $request->get('query');

      if($query != '')
      {

        $data = Subscription::select('users.username','plans.plans_name')
        ->join('users', 'users.id', '=', 'subscriptions.user_id')
        ->join('plans', 'plans.plan_id', '=', 'subscriptions.stripe_plan')
        ->paginate(9);

      }
      else
      {

      }
        $i = 1 ; 
      $total_row = $data->count();
      if($total_row > 0)
      {
       foreach($data as $row)
       {
        $output .= '
        <tr>
        <td>'.$i++.'</td>
        <td>'.$row->username.'</td>
         <td>'.$row->plans_name.'</td>
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
       'table_data'  => $output,
       'total_data'  => $total_row
      );

      echo json_encode($data);
     }
    }

    public function PlanState(Request $request)
    {
        if($request->ajax())
     {

      $output = '';
      $query = $request->get('query');

 
      if($query != '')
      {
        $data = Subscription::select('users.username','plans.plans_name')
        ->join('users', 'users.id', '=', 'subscriptions.user_id')
        ->join('plans', 'plans.plan_id', '=', 'subscriptions.stripe_plan')
        // ->where('subscriptions.regionname','=',$query)
        ->paginate(9);
        // echo "<pre>"; print_r($data);exit();

      }
      else
      {

      }
        $i = 1 ; 
      $total_row = $data->count();
      if($total_row > 0)
      {
       foreach($data as $row)
       {
        $output .= '
        <tr>
        <td>'.$i++.'</td>
        <td>'.$row->username.'</td>
         <td>'.$row->plans_name.'</td>
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
       'table_data'  => $output,
       'total_data'  => $total_row
      );

      echo json_encode($data);
     }
    }

    public function PlanCity(Request $request)
    {
        if($request->ajax())
     {

      $output = '';
      $query = $request->get('query');

 
      if($query != '')
      {
        $data = Subscription::select('users.username','plans.plans_name')
        ->join('users', 'users.id', '=', 'subscriptions.user_id')
        ->join('plans', 'plans.plan_id', '=', 'subscriptions.stripe_plan')
        ->where('subscriptions.cityname','=',$query)
        ->paginate(9);
        // echo "<pre>"; print_r($data);exit();

      }
      else
      {

      }
        $i = 1 ; 
      $total_row = $data->count();
      if($total_row > 0)
      {
       foreach($data as $row)
       {
        $output .= '
        <tr>
        <td>'.$i++.'</td>
        <td>'.$row->username.'</td>
         <td>'.$row->plans_name.'</td>
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
       'table_data'  => $output,
       'total_data'  => $total_row
      );

      echo json_encode($data);
     }
    }
    
    public function profilePreference(Request $request)
    {
       $data = $request->all();
       $id = $data['user_id'];
       $preference = User::find($id);  
       
       if(!empty($data['preference_language'])){
            $preference_language =json_encode($data['preference_language']);
            $preference->preference_language =   $preference_language;  
       }
       if(!empty($data['preference_genres'])){
            $preference_genres = json_encode($data['preference_genres']);
            $preference->preference_genres = $preference_genres; 
       }
       $preference->save();  

       return Redirect::to('/myprofile')->with(array('message' => 'Successfully Created Preference', 'note_type' => 'success') );

    }

     public function Splash_edit(Request $request,$id)
    {

        $Splash=MobileApp::where('id',$id)->first();
        $allCategories = MobileSlider::all();

        $data = array(
            'admin_user' => Auth::user(),
            'Splash' => $Splash,
            'allCategories'=>$allCategories
          );

        return View::make('admin.mobile.splashEdit', $data);

    }

    public function Splash_update(Request $request,$id)
    {
        $input = $request->all();
        $Splash = MobileApp::find($id);  

         if( $input['splash_image'] != ''){
            $path = public_path().'/uploads/settings/';
            $splash_image = $request['splash_image'];
            $file = $splash_image;
            $input['splash_image']  = $file->getClientOriginalName();
            $file->move($path, $input['splash_image']);

            $Splash->splash_image =  $input['splash_image'];  
         }
         $Splash->save();  

       return Redirect::to('admin/mobileapp')->with(array('message' => 'Successfully updated!', 'note_type' => 'success') );
    }

    public function Splash_destroy($id)
    {
       $Splash=MobileApp::find($id);
       $Splash->delete();
       return Redirect::to('admin/mobileapp')->with(array('message' => 'Successfully deleted!', 'note_type' => 'success') );
    }

}

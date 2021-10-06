<?php
namespace App\Http\Controllers;

use \App\User as User;
use \Redirect as Redirect;
use Illuminate\Http\Request;
use \App\MobileApp as MobileApp;
use \App\MobileSlider as MobileSlider;
use App\RecentView as RecentView;
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
use DateTime;
use Session;

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
        
        
       $total_recent_subscription = Subscription::orderBy('created_at', 'DESC')->whereDate('created_at', '>', \Carbon\Carbon::now()->today())->count();
       $top_rated_videos = Video::where("rating",">",7)->get();
      
    //    $total_revenew = Subscription::all();
       $total_revenew = Subscription::sum('price');

      
        $search_value = '';
        
        if(!empty($search_value)):
            $users = User::where('username', 'LIKE', '%'.$search_value.'%')->orWhere('email', 'LIKE', '%'.$search_value.'%')->orderBy('created_at', 'desc')->get();
        else:
            $users = User::all();
        endif;
// print_r($total_subscription);
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
     
        $current_plan = \DB::table('users')
        ->select(['subscriptions.*','plans.plans_name','plans.billing_interval','plans.days'])
        ->join('subscriptions', 'subscriptions.user_id', '=', 'users.id')
        ->join('plans', 'subscriptions.stripe_plan', '=', 'plans.plan_id')
        ->where('role', '=', 'subscriber' )
        ->where('users.id', '=', $user->id )
        ->get();
               $country_name = CountryCode::where('phonecode','=',$user->ccode)->get();
   
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
     $password = Hash::make($request['passwords']);

     $user = new User;
     $user->username = $request['username'];
     $user->email = $request['email'];
     $user->mobile = $request['mobile'];
     $password = Hash::make($request['passwords']);
     $user->ccode = $request['ccode'];
     $user->role = $request['role'];
    //  $user->terms = $request['terms'];
     $user->avatar = $file->getClientOriginalName();
     $user->password = $password;
    $user->save();

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
        return Redirect::to('admin/users')->with(array('note' => 'Successfully Created New User', 'note_type' => 'success') );
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
        
        return Redirect::to('admin/users')->with(array('note' => 'Successfully Created New User', 'note_type' => 'success') );
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
        
    	$user_id = Auth::user()->id;
    	$user_details = User::find($user_id);
        $recent_videos = RecentView::orderBy('id', 'desc')->take(10)->get();
        foreach($recent_videos as $key => $value){
        $videos[] = Video::Where('id', '=',$value->video_id)->take(10)->get();
        }
        $videocategory = VideoCategory::all();

        $video = array_unique($videos);
    	$data = array(
    		'videos' => $video,
    		'videocategory' => $videocategory,
    		'user' => $user_details,

    		'post_route' => URL::to('/profile/update')
    		);
    	return View::make('myprofile', $data);
    }
    public function ProfileImage(Request $request){
      
    $input = $request->all();
    //   echo "<pre>";
    //   print_r($input);
    // exit();

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
          $mobile_settings = MobileApp::first();
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
          $settings = MobileApp::first();
          $path = public_path().'/uploads/settings/';
          $splash_image = $request['splash_image'];

          if($splash_image != '') {   
            //code for remove old file
            if($splash_image != ''  && $splash_image != null){
              $file_old = $path.$splash_image;
              if (file_exists($file_old)){
                unlink($file_old);
              }
            }
            //upload new file
            $file = $splash_image;
            $input['splash_image']  = $file->getClientOriginalName();
            $file->move($path, $input['splash_image']);
          }
          $settings->update($input);
          return Redirect::to('admin/mobileapp')->with(array('note' => 'Successfully Updated  Settings!', 'note_type' => 'success') );
    }  

    
    
    
    
    
    
    public function logout()
    {
        $data = \Session::all();

        Auth::logout();
        unset($data['password_hash']);

        \Session::flush();
        
        
        return Redirect::to('/')->with(array('note' => 'You are logged out done', 'note_type' => 'success') );
    }
    
    public function destroy($id)
        {

            User::destroy($id);
            return Redirect::to('admin/users')->with(array('note' => 'Successfully Deleted User', 'note_type' => 'success') );
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
                $current_plan = \DB::table('users')
                ->select(['subscriptions.*','users.*','plans.plans_name','plans.billing_interval','plans.days'])
                ->join('subscriptions', 'subscriptions.user_id', '=', 'users.id')
                ->join('plans', 'subscriptions.stripe_plan', '=', 'plans.plan_id')
                ->where('role', '=', 'subscriber' )
                ->get();
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

    
}

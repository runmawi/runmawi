<?php

namespace App\Http\Controllers;

use App\ModeratorsPermission;
use App\ModeratorsRole;
use App\ModeratorsUser;
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

class ModeratorsUserController extends Controller
{   

  public function index()
  {
    $package_id = auth()->user()->id;
    $user_package =    DB::table('users')->where('id', $package_id)->first();
    $package = $user_package->package;
    if($package == "Pro" || $package == "Business" ){
      $moderatorsrole = ModeratorsRole::all();
      $moderatorspermission = ModeratorsPermission::all();
      $moderatorsuser = ModeratorsUser::all();
      

      $data = array(
   
          'roles' => $moderatorsrole,
          'permission' => $moderatorspermission,

        );

  
       return view('moderator.index',$data);
      }else if($package == "Basic"){

        return view('blocked');
    
    }
  }

  public function store(Request $request)
  {
    $package_id = auth()->user()->id;
    $user_package =    DB::table('users')->where('id', $package_id)->first();
    $package = $user_package->package;
    if($package == "Pro" || $package == "Business" ){
    $input = $request->all();
    // echo "<pre>";  
    // print_r($input);
    // exit();
    $user_permission = $request->user_permission;
 $permission = implode(",",$user_permission);
  

$request->validate([
      'email_id' => 'required|email|unique:moderators_users,email',
      'password' => 'min:6',
      'confirm_password' => 'required_with:password|same:password|min:6'
  ]);
    $moderatorsuser = new ModeratorsUser;
    $moderatorsuser->username = $request->username;
    $moderatorsuser->email = $request->email_id;
    $moderatorsuser->mobile_number = $request->mobile_number;
    $moderatorsuser->password = $request->password;
    $password = Hash::make($moderatorsuser->password);
    $moderatorsuser->hashedpassword = $password;
    $moderatorsuser->confirm_password = $request->confirm_password;
    $moderatorsuser->description = $request->description;
    // $moderatorsuser->hashedpassword = $request->picture;
    $moderatorsuser->user_role = $request->user_role;
    $moderatorsuser->user_permission = $permission;



    $logopath = URL::to('/public/uploads/picture/');
    $path = public_path().'/uploads/picture/';
    $picture = $request['picture'];
if($picture != '') {   
     //code for remove old file
     if($picture != ''  && $picture != null){
          $file_old = $path.$picture;
         if (file_exists($file_old)){
          unemail($file_old);
         }
     }
     //upload new file
     
     $file = $picture;
     $moderatorsuser->picture  = $logopath.'/'.$file->getClientOriginalName();
     $file->move($path, $moderatorsuser->picture);
    
}
if($request->picture == ""){
  // print_r('oldtesting pic');
  // exit();
  $moderatorsuser->picture  = "Default.png";
}else{
  // print_r('testing pic');
  // exit();
    $moderatorsuser->picture = $file->getClientOriginalName();
}

    $moderatorsuser->save();
    $user_id = $moderatorsuser->id;

    foreach($request->user_permission as $value){
    $userrolepermissiom = new UserAccess;
    $userrolepermissiom->user_id = $user_id;
    $userrolepermissiom->role_id = $request->user_role;
    $userrolepermissiom->permissions_id = $value;
    $userrolepermissiom->save();

    }
    $moderatorsrole = ModeratorsRole::all();
    $moderatorspermission = ModeratorsPermission::all();
    $moderatorsuser = ModeratorsUser::all();    
    $data = array(
   
      'roles' => $moderatorsrole,
      'permission' => $moderatorspermission,
      'moderatorsuser' => $moderatorsuser,


    );
    return view('moderator.view',$data);
   
  // return redirect('/moderator')->with('success', 'Users saved!');
}else if($package == "Basic"){

  return view('blocked');

}
}

  public function edit($id)
  {


    $package_id = auth()->user()->id;
    $user_package =    DB::table('users')->where('id', $package_id)->first();
    $package = $user_package->package;
    if($package == "Pro" || $package == "Business" ){
$moderators = ModeratorsUser::find($id);
$useraccess = UserAccess::where('user_id', '=', $id)->get();
$permission=DB::table('user_accesses')->where('user_id', '=', $id)->get();
      $moderatorsrole = ModeratorsRole::all();
      $moderatorspermission = ModeratorsPermission::all();
      $moderatorsuser = ModeratorsUser::all();
      $data = array(
   
          'roles' => $moderatorsrole,
          'permission' => $moderatorspermission,
          'moderatorsuser' => $moderatorsuser,
          'moderators' => $moderators,
          'moderatorspermission' => $permission,
          'useraccess' => $useraccess,


        );

  
       return view('moderator.create_edit',$data);
      }else if($package == "Basic"){

        return view('blocked');
    
    }
  }


  public function update(Request $request)
  {
    $package_id = auth()->user()->id;
    $user_package =    DB::table('users')->where('id', $package_id)->first();
    $package = $user_package->package;
    if($package == "Pro" || $package == "Business" ){
$data = $request->all();

  // $data_delete = UserAccess::destroy('user_id', '=', $id);

// echo "<pre>";  
// print_r($data_delete);
// exit();

$user_permission = $data['user_permission'];
$permission = implode(",",$user_permission);
$id = $data['id'];
$moderatorsuser = ModeratorsUser::find($id);
$moderatorsuser['username'] = $data['username'];
$moderatorsuser['email'] = $data['email_id'];
$moderatorsuser['mobile_number'] = $data['mobile_number'];
$moderatorsuser['description'] = $data['description'];
$moderatorsuser['user_role'] = $data['user_role'];
$moderatorsuser['user_permission'] = $permission;

  $logopath = URL::to('/public/uploads/picture/');
  $path = public_path().'/uploads/picture/';
  $picture = $data['picture'];
  if($picture != '') {   
   //code for remove old file
   if($picture != ''  && $picture != null){
        $file_old = $path.$picture;
       if (file_exists($file_old)){
        unemail($file_old);
       }
   }
   //upload new file
   
   $file = $picture;
   $moderatorsuser->picture  = $logopath.'/'.$file->getClientOriginalName();
   $file->move($path, $moderatorsuser->picture);
  
  }

$moderatorsuser->save();
$user_id = $id;
$moderatorsuser->save();
$user_id = $moderatorsuser->id;


// $userrolepermissiom = UserAccess::where('user_id', '=', $id)->get();
$data_delete = UserAccess::where('user_id','=',$id)->delete();

foreach($data['user_permission'] as $value){
  $userrolepermissiom = new UserAccess;
  $userrolepermissiom->user_id = $user_id;
  $userrolepermissiom->role_id = $request->user_role;
  $userrolepermissiom->permissions_id = $value;
  $userrolepermissiom->save();
  

}

  
       return \Redirect::back();
      }else if($package == "Basic"){

        return view('blocked');
    
    }
  }

  
  public function delete($id)
  {
    $package_id = auth()->user()->id;
    $user_package =    DB::table('users')->where('id', $package_id)->first();
    $package = $user_package->package;
    if($package == "Pro" || $package == "Business" ){

        $moderators = ModeratorsUser::find($id);

        ModeratorsUser::destroy($id);
  
       return \Redirect::back();
      }else if($package == "Basic"){

        return view('blocked');
    
    }
  }
  public function view()
  {
    $package_id = auth()->user()->id;
    $user_package =    DB::table('users')->where('id', $package_id)->first();
    $package = $user_package->package;
    if($package == "Pro" || $package == "Business" ){
      $moderatorsrole = ModeratorsRole::all();
      $moderatorspermission = ModeratorsPermission::all();
      $moderatorsuser = ModeratorsUser::all();
      $data = array(
   
          'roles' => $moderatorsrole,
          'permission' => $moderatorspermission,
          'moderatorsuser' => $moderatorsuser,


        );

  
       return view('moderator.view',$data);
      }else if($package == "Basic"){

        return view('blocked');
    
    }
  }

  public function test(Request $request)
  {


    $user = ModeratorsUser::where('email', '=', $request['email'])->first();
    Hash::check('password', $request['password']);
    


    
    // $user_data =json_decode($user);

    $user_id = $user->id;
   
    if($user_id != ""){
    $id = json_decode($user_id,true);

    }else{
      return false;
    }

    $userrolepermissiom=DB::table('user_accesses')
    ->select('user_accesses.permissions_id','moderators_permissions.name','moderators_permissions.url')
    ->join('moderators_permissions','moderators_permissions.id','=','user_accesses.permissions_id')
    ->where(['user_id' =>$id])
    ->get();
    // return $id;
    // exit();
    if($user != ""){
      $user_data =json_encode($user);
      $userrolepermissiom =json_encode($userrolepermissiom);
    $data = array(
      'user_data' =>  $user_data,
       'userrolepermissiom' => $userrolepermissiom, 

    );
      return $data ;

    }else{
    // print_r($id);exit();

      return  false ;

    }
  }
 public function video_store(Request $request)
  {

$input =$request->all();
$videos_categories = json_decode($input['videos_categories']);
$image =$input['image'];
// echo "<pre>";
// print_r($input);exit();
$path = public_path().'/uploads/videocategory/';
        
$image = $request['image']; 
if($image != '') {   
//code for remove old file
  if($image != ''  && $image != null){
       $file_old = $path.$image;
      if (file_exists($file_old)){
       unlink($file_old);
      }
  }
  //upload new file
  $file = $image;
  $input['image']  = $file->getClientOriginalName();
  $file->move($path, $input['image']);

} else {
   $input['image']  = 'default.jpg';
}
            $s = new VideoCategory();
           
            // $input['parent_id'] = empty($input['parent_id']) ? 0 : $input['parent_id'];

            $path= public_path().'/uploads/videocategory/';
            $s->image =  $file->getClientOriginalName();  //'default.jpg'; 
            $s->slug = $videos_categories->slug; 
            $s->in_home = $videos_categories->in_home; 
            $s->parent_id =empty($videos_categories->parent_id) ? 0 : $videos_categories->parent_id; 
            $s->name = $videos_categories->name; 
            $s->user_id = $videos_categories->user_id; 
            $s->save();
          
       return true;
    
  }
  public function menu_store(Request $request)
  {
    $data =$request->all();

      // return 'test' ;
      
        $last_menu_item = Menu::orderBy('order', 'DESC')->first();
        if(isset($last_menu_item->order)){
            $new_menu_order = intval($last_menu_item->order) + 1;
        } else {
            $new_menu_order = 1;
        }
        $request['order'] = $new_menu_order;
        $menu= Menu::create($data);
        // print_r('last_menu_item');exit();

        // if(isset($menu->id)){
        //     return Redirect::to('admin/menu')->with(array('note' => 'Successfully Added New Menu Item', 'note_type' => 'success') );
        // }
          
       return true;
    
  }
  public function county(Request $request)
  {

      
           $county = new Country();
            $county->country_name = $request['country_name'];
            $county->user_id = $request['user_id'];

            $county->save();

       return 1;
    
  }
   public function slider_store(Request $request)
  {
    $data =$request->all();
    $slider = json_decode($data['slider']);
$active =$slider->active;
$id = $slider->user_id;
    $image =$data['slider_image'];
    $path = public_path().'/uploads/videocategory/';

      if($image != '') {   
        //code for remove old file
            if($image != ''  && $image != null){
                 $file_old = $path.$image;
                if (file_exists($file_old)){
                 unlink($file_old);
                }
            }
            //upload new file
            $file = $image;
            $input['image']  = $file->getClientOriginalName();
            $file->move($path, $input['image']);

        } else {
             $input['image']  = 'default.jpg';
         }
       
           $slider = new Slider();
           $slider->slider = $file->getClientOriginalName();
           $slider->link = $slider->link;
          //  echo "<pre>";
          //  print_r($id);exit();
           $slider->active = $active;

           $slider->user_id = $id;

            
            $slider->save();

       return 1;
    
  }


  public function all_video_store(Request $request)
  {
    $data =$request->all();
    // $request->file('image')
    $video_data =json_decode($data['video_data']);


    $english = $data['english'];
    $german = $data['german'];
    $spanish = $data['spanish'];
    $hindi = $data['hindi'];
    $subtitle_upload =array($english ,$german ,$spanish ,$hindi);

// echo "<pre>";
// print_r($video_data);
// exit();  
$image = (isset($data['image'])) ? $data['image'] : '';
$trailer = (isset($data['trailer'])) ? $data['trailer'] : '';
$mp4_url = (isset($data['video'])) ? $data['video'] : '';
$files = (isset($subtitle_upload)) ? $subtitle_upload : '';
   /* logo upload */

$path = public_path().'/uploads/videos/';
$image_path = public_path().'/uploads/images/';

$image = (isset($data['image'])) ? $data['image'] : '';
$trailer = (isset($data['trailer'])) ? $data['trailer'] : '';
$mp4_url = (isset($data['video'])) ? $data['video'] : '';
$files = (isset($subtitle_upload)) ? $subtitle_upload : '';
   /* logo upload */

$path = public_path().'/uploads/videos/';
$image_path = public_path().'/uploads/images/';
if(!empty($data['artists'])){
 $artistsdata = $data['artists'];
 unset($data['artists']);
}
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
   $data['image']  = $file->getClientOriginalName();
   $file->move($image_path, $data['image']);

} else {
  $data['image']  = 'default.jpg';
} 

if ($video_data->slug != '') {
         $video_data->slug =($video_data->slug);
 }

 if($video_data->slug == ''){
         $video_data->slug = ($video_data->title);    
 }


if($trailer != '') {   
   //code for remove old file
   if($trailer != ''  && $trailer != null){
        $file_old = $path.$trailer;
       if (file_exists($file_old)){
        unlink($file_old);
       }
   }
   //upload new file
   $randval = Str::random(16);
   $file = $trailer;
   $trailer_vid  = $randval.'.'.$request->file('trailer')->extension();
   $file->move($path, $trailer_vid);
   $data['trailer']  = URL::to('/').'/public/uploads/videos/'.$trailer_vid;

} else {
 $data['trailer'] = '';
}


$data['user_id'] = $video_data->user_id;
// $$video_data->user_id = $video_data->user_id;



if(empty($video_data->active)){
 $video_data->active = 0;
} 


if(empty($video_data->year)){
 $video_data->year = 0;
}  else {
 $video_data->year =  $video_data->year;
} 

if(empty($video_data->access)){
 $video_data->access = 0;
}  else {
 $video_data->access =  $video_data->access;
}  


if(empty($video_data->language)){
 $video_data->language = 0;
}  else {
 $video_data->language =  $video_data->language;
} 

if(!empty($video_data->embed_code)){
 $video_data->embed_code = $video_data->embed_code;
} else {
 $video_data->embed_code = '';
}

 if ($video_data->slug != '') {
         $video_data->slug = $request->slug;
 }

 if($video_data->slug == ''){
         $video_data->slug = $video_data->title;    
 }

if(empty($video_data->featured)){
 $video_data->featured = 0;
}  

if(empty($video_data->type)){
 $video_data->type = '';
}

if(empty($data['status'])){
 $data['status'] = 0;
}   

if(empty($data['path'])){
 $data['path'] = 0;
}  
if(isset($video_data->duration)){
     //$str_time = $video_data
     $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $video_data->duration);
     sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
     $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
     $video_data->duration = $time_seconds;
     
}

if(!empty($video_data->embed_code)) {
  
  $video = new Video();
  $video->disk = 'public';
  $video->original_name = 'public';
  $video->path = $path;
  $video->title = $video_data->title;
  $video->slug = $video_data->slug;
  $video->language = $video_data->language;
  $video->image = $data['image'];
  $video->trailer = $data['trailer'];
  $video->mp4_url = $path;
  $video->type = $video_data->type;
  $video->access = $video_data->access;
  $video->embed_code = $video_data->embed_code;
  $video->video_category_id = $video_data->video_category_id;
  $video->details = $video_data->details;
  $video->description = strip_tags($video_data->description);
  $video->user_id = $video_data->user_id;
  $video->save();

}



if($mp4_url != '') {
  
 $rand = Str::random(16);
 $path = $rand . '.' . $request->video->getClientOriginalExtension();
 $request->video->storeAs('public', $path);
  
  $original_name = ($request->video->getClientOriginalName()) ? $request->video->getClientOriginalName() : '';
  
  $video = new Video();
  $video->disk = 'public';
  $video->original_name = 'public';
  $video->path = $rand;
  $video->title = $video_data->title;
  $video->slug = $video_data->slug;
  $video->language = $video_data->language;
  $video->image = $data['image'];
  $video->trailer = $data['trailer'];
  $video->mp4_url = $path;
  $video->type = $video_data->type;
  $video->access = $video_data->access;
  $video->video_category_id = $video_data->video_category_id;
  $video->details = $video_data->details;
  $video->description = strip_tags($video_data->description);
  $video->user_id =$video_data->user_id;
  $video->save(); 
 
  $lowBitrateFormat = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(500);
  $midBitrateFormat  =(new X264('libmp3lame', 'libx264'))->setKiloBitrate(1500);
  $highBitrateFormat = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(3000);
  $converted_name = ConvertVideoForStreaming::handle($path);

  ConvertVideoForStreaming::dispatch($video);

} else {
   
    $video = Video::create($video_data);
}

$shortcodes = $video_data->short_code;
$languages=$video_data->sub_language;
// echo"<pre>";
// print_r($languages);
// exit();
if(!empty( $files != ''  && $files != null)){


 foreach ($files as $key => $val) {

     if(!empty($files[$key])){
       
         $destinationPath ='public/uploads/subtitles/';

         $filename = $video->id.$shortcodes[$key].'.srt';


         $files[$key]->move($destinationPath, $filename);

            $video_subtitle = new VideosSubtitle;

              $video_subtitle->video_id = $video->id;
    
              $video_subtitle->sub_language = $languages[$key];
              // echo"<pre>";
              // print_r($video_subtitle->sub_language);
              // exit();
              $video_subtitle->shortcode = $shortcodes[$key];
              $video_subtitle->url = URL::to('/').'/public/uploads/subtitles/'.$filename;
              // $video_subtitle->user_id = $video_data->user_id;

     $video_subtitle->save();

     }
 }
}

if(!empty($artistsdata)){
 foreach ($artistsdata as $key => $value) {
     $artist = new Videoartist;
     $artist->video_id = $video->id;
     $artist->artist_id = $value;
     $artist->user_id = $video_data->user_id;

     $artist->save();
 }
 
}
// $data =json_decode($data['video_data']);


       return true;
    
  }
  public function payment_setting(Request $request)
  {
    $input =$request->all();
    // $request->file('image')
// echo "<pre>";

//       print_r($data);
//       exit();
      $payment_settings = PaymentSetting::first();
      

      $payment_settings->live_mode = $request['live_mode'];
      $payment_settings->test_secret_key = $request['test_secret_key'];
      $payment_settings->test_publishable_key = $request['test_publishable_key'];
      $payment_settings->live_secret_key = $request['live_secret_key'];
      $payment_settings->live_publishable_key = $request['live_publishable_key'];
      $payment_settings->plan_name = $request['plan_name'];
      $payment_settings->user_id = $request['user_id'];

          
       
  
      if(empty($payment_settings->live_mode) || $payment_settings->live_mode == ''){
              
        $payment_settings->live_mode = 0;
      }
          
          if(empty($payment_settings->test_secret_key)){
              
        $payment_settings->test_secret_key = '';
      }
  
          
      if(empty($payment_settings->test_publishable_key )){
              
        $payment_settings->test_publishable_key  = '';
      }
       
          if(empty($payment_settings->live_secret_key)){
        $payment_settings->live_secret_key  = '';
      }   
          
          if(empty($payment_settings->plan_name)){
        $payment_settings->plan_name   = '';
      } else {
              $payment_settings->plan_name   = $input['plan_name'];
          }
          
          if(empty($payment_settings->live_publishable_key)){
              
        $payment_settings->live_publishable_key  = '';
      }

      if(empty($payment_settings->user_id)){
        $payment_settings->user_id   = '';
      } else {
              $payment_settings->user_id   = $input['user_id'];
          }
          
          $payment_settings->save();
          
       return true;
    
  }
  public function systemsettings(Request $request)
  {
    $data =$request->all();
      $settings = SystemSetting::find(1);
      if (!empty($request->facebook)){
       $settings->facebook = $request->facebook;   
      } else {
          $settings->facebook = 0;  
      }
      
      if (!empty($request->google)){
       $settings->google = $request->google;   
      } else {
          $settings->google = 0;  
      }
      
      $settings->facebook_client_id = $request->facebook_client_id;
      $settings->facebook_secrete_key = $request->facebook_secrete_key;
      $settings->facebook_callback = $request->facebook_callback;
      $settings->google_client_id = $request->google_client_id;
      $settings->google_secrete_key = $request->google_secrete_key;
      $settings->google_callback = $request->google_callback;
      $settings->user_id = $request->user_id;

      $settings->save();
       return 1;
    
  }

  public function homesettings(Request $request)
  {
      $settings = HomeSetting::first();
		$settings->featured_videos = $request['featured_videos'];
		$settings->latest_videos = $request['latest_videos'];
		$settings->category_videos = $request['category_videos'];
		$settings->user_id = $request['user_id'];

        $settings->save();
       return 1;
    
  }


  public function mobileappupdate(Request $request)
  {
    $input = $request->all();
//     echo "<pre>";

// print_r($input);
// exit();
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

return true;
}



public function slider(Request $request)
{
  $input = $request->all();

$slider = json_decode($input['slider']);
$image = $input['slider_image'];
$link = $slider->link;
$active = $slider->active;
$user_id = $slider->user_id;
$s = new MobileSlider();
$slider = new MobileSlider();
$path = public_path().'/uploads/videocategory/';

if($image != '') {   
//code for remove old file
  if($image != ''  && $image != null){
       $file_old = $path.$image;
      if (file_exists($file_old)){
       unlink($file_old);
      }
  }
  //upload new file
  $file = $image;
  $slider->slider  = $file->getClientOriginalName();
  $slider->link  = $link;
  $file->move($path, $slider->slider);
} 

$input['slider']  = $file->getClientOriginalName();
$slider->active = $active;
$slider->user_id = $user_id;

$slider->save();
return true;
}







public function theme_settings(Request $request)
{
  $input = $request->all();
// echo "<pre>";
// print_r($input);
// exit();

$theme_settings = json_decode($input['theme_settings']);
$dark_mode_logo = $input['dark_mode_logo'];
$light_mode_logo = $input['light_mode_logo'];

$light_bg_color = $theme_settings->light_bg_color;
$dark_bg_color = $theme_settings->dark_bg_color;
$user_id = $theme_settings->user_id;






$theme_settings = SiteTheme::first();
$theme_settings->dark_bg_color = $dark_bg_color;
$theme_settings->light_bg_color = $light_bg_color;
$theme_settings->user_id = $user_id;


 $path = public_path().'/uploads/settings/';
 $dark_logo = $dark_mode_logo;
 $light_logo = $light_mode_logo;
    if($dark_logo != '') {   
      //code for remove old file
      if($dark_logo != ''  && $dark_logo != null){
           $file_old = $path.$dark_logo;
          if (file_exists($file_old)){
           unlink($file_old);
          }
      }
      //upload new file
      $file = $dark_logo;
      $theme_settings->dark_mode_logo  = $file->getClientOriginalName();
      $file->move($path, $theme_settings->dark_mode_logo);
    }   
if($light_logo != '') {   
      //code for remove old file
      if($light_logo != ''  && $light_logo != null){
           $file_old = $path.$light_logo;
          if (file_exists($file_old)){
           unlink($file_old);
          }
      }
      //upload new file
      $file = $light_logo;
      $theme_settings->light_mode_logo  = $file->getClientOriginalName();
      $file->move($path, $theme_settings->light_mode_logo);
    }
$theme_settings->save();       
return true;
}



public function site_setting(Request $request)
{
  $input = $request->all();
  $site_setting = json_decode($input['site_setting']);
// echo "<pre>";
// print_r($site_setting->system_email);

// print_r($input);
// exit();


$settings = Setting::find(1);
$settings->demo_mode = $site_setting->demo_mode;
$settings->ppv_hours = $site_setting->ppv_hours;
$settings->videos_per_page = $site_setting->videos_per_page;
$settings->ppv_price = $site_setting->ppv_price;
$settings->website_description = $site_setting->website_description;
$settings->website_name = $site_setting->website_name;
$settings->login_text = $site_setting->login_text;
// $settings->signature = $site_setting->signature;
$settings->system_email = $site_setting->system_email;
$settings->enable_https = $site_setting->enable_https;
$settings->free_registration = $site_setting->free_registration;
$settings->activation_email = $site_setting->activation_email;
$settings->premium_upgrade = $site_setting->premium_upgrade;
$settings->facebook_page_id = $site_setting->facebook_page_id;
$settings->google_page_id = $site_setting->google_page_id;
$settings->twitter_page_id = $site_setting->twitter_page_id;
$settings->youtube_page_id = $site_setting->youtube_page_id;
$settings->google_tracking_id = $site_setting->google_tracking_id;
$settings->signature = $site_setting->signature;
$settings->posts_per_page = $site_setting->posts_per_page;
$settings->google_oauth_key = $site_setting->google_oauth_key;
$settings->coupon_status = $site_setting->coupon_status;
$settings->new_subscriber_coupon = $site_setting->new_subscriber_coupon;
$settings->coupon_code = $site_setting->coupon_code;
// $settings->system_email = $site_setting->system_email;
$settings->discount_percentage = $site_setting->discount_percentage;
$settings->user_id = $site_setting->user_id;
$settings->notification_key = $site_setting->notification_key;
$settings->ppv_status = $site_setting->ppv_status;
    
     $path = public_path().'/uploads/settings/';
     $logo = $input['logo'];
     $favicon = $input['favicon'];
     $login_content = $input['login_content'];

     $notification_icon = $input['notification_icon'];
     $watermark = $request['watermark'];
  
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
      $settings->logo  = $file->getClientOriginalName();
      $file->move($path, $settings->logo);
     
 }
if($watermark != '') {   
      //code for remove old file
      if($watermark != ''  && $watermark != null){
           $file_old = $path.$watermark;
          if (file_exists($file_old)){
           unlink($file_old);
          }
      }
      //upload new file
      $file = $watermark;
      $settings->watermark  = $file->getClientOriginalName();
      $file->move($path, $settings->watermark);
     
 }
    $settings->watermark_right = $request['watermark_right'];
    $settings->watermark_top = $request['watermark_top'];
    
     if(!empty($settings->watermark_right)){
  $settings->watermark_right = $request['watermark_right'];
}
    if(!empty($settings->watermark_top)){
  $settings->watermark_top = $request['watermark_top'];
}if(!empty($settings->watermark_bottom)){
  $settings->watermark_bottom = $request['watermark_bottom'];
}
    if(!empty($settings->watermark_opacity)){
  $settings->watermark_opacity = $request['watermark_opacity'];
} 
    
    if(!empty($settings->watermar_link)){
  $settings->watermar_link = $request['watermar_link'];
}

    if(empty($settings->notification_key)){
  $settings->notification_key = '';
}  

if($login_content != '') {   
      //code for remove old file
      if($login_content != ''  && $login_content != null){
           $login_content_old = $path.$login_content;
          if (file_exists($login_content_old)){
           unlink($file_old);
          }
      }
      //upload new file
      $login_content_file = $login_content;
      $settings->login_content = $login_content_file->getClientOriginalName();
      $login_content_file->move($path, $settings->login_content);
     
 }
    
    if($favicon != '') {   
          //code for remove old file
          if($favicon != ''  && $favicon != null){
               $old_favicon = $path.$favicon;
              if (file_exists($old_favicon)){
                unlink($old_favicon);
              }
          }
          //upload new file
          $favicon_file = $favicon;
          $settings->favicon  = $favicon_file->getClientOriginalName();
          $favicon_file->move($path, $settings->favicon);

     }
    
    
    if($notification_icon != '') {   
          //code for remove old file
          if($notification_icon != ''  && $notification_icon != null){
               $old_favicon = $path.$notification_icon;
              if (file_exists($old_favicon)){
                unlink($old_favicon);
              }
          }
          //upload new file
          $favicon_file = $notification_icon;
          $settings->notification_icon  = $favicon_file->getClientOriginalName();
          $favicon_file->move($path, $settings->notification_icon);

     }

if(empty($settings->ppv_status)){
  $settings->ppv_status = 0;
}

    if(empty($settings->demo_mode)){
  $settings->demo_mode = 0;
}

if(empty($settings->enable_https)){
  $settings->enable_https = 0;
}	
    
    if(empty($settings->new_subscriber_coupon)){
  $settings->new_subscriber_coupon = 0;
}

if(empty($settings->free_registration)){
  $settings->free_registration = 0;
}
    
    if(empty($settings->videos_per_page)){
  $settings->videos_per_page = 0;
}
    
    if(empty($settings->ppv_price)){
  $settings->ppv_price = 0;
}
    if(empty($settings->coupon_code)){
  $settings->coupon_code = 0;
}  
    
    if(empty($settings->discount_percentage)){
  $settings->discount_percentage = 0;
}
    
    if(empty($settings->notification_icon)){
  $settings->notification_icon = '';
}

    //		if(empty($activation_email) || $settings->activation_email = 0){
    //			$settings->activation_email= 0;
    //		} else {
    //            $settings->activation_email= $request->get('activation_email');
    //        }

    $settings->activation_email= $request->get('activation_email');
    $settings->system_email= $request->get('system_email');

   
if(empty($settings->premium_upgrade)){
  $settings->premium_upgrade = 0;
}
    
    if(empty($settings->youtube_page_id)){
  $settings->youtube_page_id = 0;
}
    if(empty($settings->facebook_page_id)){
  $settings->facebook_page_id = 0;
} 
    
    
    $settings->save();

return true;

}


  public function pages(Request $request)
  {
    $data = $request->all();
    $pages = json_decode($data['pages']);
    $title =$pages->title;
    $slug =$pages->slug;
    $body =$pages->body;
    $active =$pages->active;
    $user_id =$pages->user_id;
  // echo "<pre>";
  
  // print_r($pages);
  // exit();
     
  $path = public_path().'/uploads/settings/';
        
  $logo = $data['banner'];

      /* logo upload */

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
        $data['banner']  = $file->getClientOriginalName();
        $file->move($path, $data['banner']);

   }
   $page = new Page();

   $page->title =$pages->title;
   $page->slug =$pages->slug;
   $page->body =$pages->body;
   $page->active =$pages->active;
   $page->user_id =$pages->user_id;
   $page->banner =$file->getClientOriginalName();


   $page->save();




  return true;
}





public function livestream(Request $request)
{
  $data = $request->all();
  $livestream = json_decode($data['livestream']);
  $title =$livestream->title;
  $slug =$livestream->slug;
  $mp4_url =$livestream->mp4_url;
  $details =$livestream->details;
  $description =$livestream->description;
  $video_category_id =$livestream->video_category_id;
  $rating =$livestream->rating;
  $language =$livestream->language;
  $year =$livestream->year;
  $duration =$livestream->duration;
  $access =$livestream->access;
  $featured =$livestream->featured;
  $active =$livestream->active;
  $banner =$livestream->banner;
  $footer =$livestream->footer;
  $user_id =$livestream->user_id;
  $image = $data['image'];
// echo "<pre>";

// print_r($data);
// exit();
   
$image = (isset($data['image'])) ? $data['image'] : '';
$mp4_url = (isset($data['mp4_url'])) ? $data['mp4_url'] : '';

$data['mp4_url']  = $mp4_url;

$path = public_path().'/uploads/livecategory/';

$image_path = public_path().'/uploads/images/';
  
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
      $data['image']  = $file->getClientOriginalName();
      $file->move($image_path, $data['image']);

 } 


$data['user_id'] = $user_id;

//        unset($data['tags']);

if(empty($data['active'])){
    $data['active'] = 0;
}  

if(empty($data['mp4_url'])){
    $data['mp4_url'] = 0;
}   else {
    $data['mp4_url'] =  $data['mp4_url'];
}

if(empty($data['year'])){
    $data['year'] = 0;
}  else {
    $data['year'] =  $data['year'];
} 

if(empty($data['id'])){
    $data['id'] = 0;
}  



if(empty($data['featured'])){
    $data['featured'] = 0;
}  

if(empty($data['status'])){
    $data['status'] = 0;
}  
if(isset($data['duration'])){
        //$str_time = $data
        $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $data['duration']);
        sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
        $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
        $data['duration'] = $time_seconds;
}


$movie = new LiveStream;

$movie->title =$livestream->title;
$movie->details =$livestream->details;
$movie->video_category_id =$livestream->video_category_id;
$movie->description =$livestream->description;
$movie->featured =$livestream->featured;
$movie->language =$livestream->language;
$movie->banner =$livestream->banner;
$movie->duration =$livestream->duration;
$movie->footer =$livestream->footer;
$movie->slug =$livestream->slug;
// $movie->status =$livestream->status;
$movie->image =$file->getClientOriginalName();
$movie->mp4_url =$livestream->mp4_url;
$movie->year =$livestream->year;

$movie->save();
// $shortcodes = $request['short_code'];
// $languages = $request['language'];




return true;
}



public function livestream_categories(Request $request)
{
  $input = $request->all();
  $livestream_categories = json_decode($input['livestream_categories']);
  $name =$livestream_categories->name;
  $slug =$livestream_categories->slug;
  $parent_id =$livestream_categories->parent_id;
  $user_id =$livestream_categories->user_id;

  $image = $input['image'];
// echo "<pre>";

// print_r($livestream_categories);
// exit();


$s = new LiveCategory();

$input['parent_id'] = empty($parent_id) ? 0 : $parent_id;

$path = public_path().'/uploads/livecategory/';

$image = $request['image'];

$slug = $slug; 

if ( $slug != '') {
 $input['slug']  = $slug;
} else {
  $input['slug']  = $name;
}


if($image != '') {   
//code for remove old file

if($image != ''  && $image != null){
  $file_old = $path.$image;
 if (file_exists($file_old)){
  unlink($file_old);
 }
}
//upload new file
$file = $image;
$input['image']  = $file->getClientOriginalName();
$file->move($path, $input['image']);
} else {
$input['image']  = 'default.jpg';
}



$categories = new LiveCategory;

$categories->name =$livestream_categories->name;
$categories->slug =$livestream_categories->slug;
$categories->parent_id =$livestream_categories->parent_id;
$categories->image =$file->getClientOriginalName();


$categories->save();


return true ;

}

public function user_store(Request $request)
{
  $input =$request->all();
  $user_store = json_decode($input['user_store']);
  $email =$user_store->email;
  $ccode =$user_store->ccode;
  $mobile =$user_store->mobile;
  $passwords =$user_store->passwords;
  $role =$user_store->role;
  $_token =$user_store->_token;
  $user_id =$user_store->user_id;

  $avatar = $input['avatar'];
// echo "<pre>";

// print_r($user_store);
// // exit();

//     echo "<pre>";
//     print_r($avatar);exit();
 
    $user = Auth::user();
        
        
        
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
  
 
       $user = new User();
         $user->username = $user_store->username;
         $user->email = $user_store->email;
         $user->ccode = $user_store->ccode;
         $user->mobile = $user_store->mobile;
         $user->password = $user_store->passwords;
         $user->role = $user_store->role;
         $user->cpp_user_id = $user_store->user_id;
         $user->avatar = $file->getClientOriginalName();

          
          $user->save();

     return 1;
  
}


  
public function user_role(Request $request)
{
  $input =$request->all();
  // $email =$user_store->email;
  // $ccode =$user_store->ccode;
  $user_role = json_decode($input['user_role']);
  $slug = $user_role->name.rand(1,10);
    // echo "<pre>";
    // print_r($user_role);exit();
    $roles = new Role();
    $roles->name =  $user_role->name;
    $roles->slug =  $slug;
    $roles->user_id = $user_role->user_id ;


    $roles->save();
  return true;




}
 
public function languagestrans(Request $request)
{
  $input =$request->all();
 
  $languagestrans = json_decode($input['languagestrans']);
    // echo "<pre>";
    // print_r($languagestrans);exit();

          
    $s = new Language();
    $slider = new Language();

  $slider->name = $languagestrans->name;
  $slider->user_id = $languagestrans->user_id;

  $slider->code = substr($languagestrans->name,2);
  
  $file_loc = 'resources/lang/'.$slider->code.'.json';
  fopen($file_loc, "w");
  $myfile = fopen($file_loc, "w") or die("Unable to open file!");
    $txt = "{}";
    fwrite($myfile, $txt);
 
  $slider->save();


  return true;




}


public function video_languages(Request $request)
{
  $input =$request->all();
 
  $video_languages = json_decode($input['video_languages']);
    // echo "<pre>";
    // print_r($video_languages);exit();

     
    $s = new VideoLanguage();
    $slider = new VideoLanguage();

  $slider->name = $video_languages->name;
  $slider->user_id = $video_languages->user_id;


  $slider->save();


  return true;




}
public function playerui_setting(Request $request)
{
  $input = $request->all();
  $playerui_setting = json_decode($input['playerui_setting']);
// echo "<pre>";
// print_r($playerui_setting);

// print_r($input);
// exit();


$playerui = Playerui::find(1);

if($playerui->show_logo == 0){
  $playerui->show_logo = 0;
}else{
  $playerui->show_logo = 1;
}
if($playerui->embed_player == 0){
  $playerui->embed_player = 0;
}else{
  $playerui->embed_player = 1;
}
if($playerui->watermark == 0){
  $playerui->watermark = 0;
}else{
  $playerui->watermark = 1;
}

if($playerui->thumbnail == 0){
  $playerui->thumbnail = 0;
}else{
  $playerui->thumbnail = 1;
}

if($playerui->skip_intro == 0){
  $playerui->skip_intro = 0;
}else{
  $playerui->skip_intro = 1;
}

if($playerui->speed_control == 0){
  $playerui->speed_control = 0;
}else{
  $playerui->speed_control = 1;
}

if($playerui->advance_player == 0){
  $playerui->advance_player = 0;
}else{
  $playerui->advance_player = 1;
}

if($playerui->video_card == 0){
  $playerui->video_card = 0;
}else{
  $playerui->video_card = 1;
}

if($playerui->subtitle == 0){
  $playerui->subtitle = 0;
}else{
  $playerui->subtitle = 1;
}

if($playerui->subtitle_preference == 0){
  $playerui->subtitle_preference = 0;
}else{
  $playerui->subtitle_preference = 1;
}
$playerui->show_logo = $playerui_setting->show_logo;
if(empty($playerui->show_logo)){
  $playerui->show_logo = 0;
}else{
  $playerui->show_logo = 1;
}

$playerui->skip_intro = $playerui_setting->skip_intro;
if(empty($playerui->skip_intro)){
  $playerui->skip_intro = 0;
}else{
  $playerui->skip_intro = 1;
}

$playerui->embed_player = $playerui_setting->embed_player;
if(empty($playerui->embed_player)){
  $playerui->embed_player = 0;
}else{
  $playerui->embed_player = 1;
}

$playerui->watermark = $playerui_setting->watermark;
if(empty($playerui->watermark)){
  $playerui->watermark = 0;
}else{
  $playerui->watermark = 1;
}

$playerui->thumbnail = $playerui_setting->thumbnail;
if(empty($playerui->thumbnail)){
  $playerui->thumbnail = 0;
}else{
  $playerui->thumbnail = 1;
}

$playerui->advance_player = $playerui_setting->advance_player;
if(empty($playerui->advance_player)){
  $playerui->advance_player = 0;
}else{
  $playerui->advance_player = 1;
}

$playerui->speed_control = $playerui_setting->speed_control;
if(empty($playerui->speed_control)){
  $playerui->speed_control = 0;
}else{
  $playerui->speed_control = 1;
}

$playerui->video_card = $playerui_setting->video_card;
if(empty($playerui->video_card)){
  $playerui->video_card = 0;
}else{
  $playerui->video_card = 1;
}

$playerui->subtitle = $playerui_setting->subtitle;
if(empty($playerui->subtitle)){
  $playerui->subtitle = 0;
}else{
  $playerui->subtitle = 1;
}

$playerui->subtitle_preference = $playerui_setting->subtitle_preference;
if(empty($playerui->subtitle_preference)){
  $playerui->subtitle_preference = 0;
}else{
  $playerui->subtitle_preference = 1;
}

$playerui->font = $playerui_setting->font;
$playerui->size = $playerui_setting->size;
$playerui->font_color = $playerui_setting->font_color;
$playerui->background_color = $playerui_setting->background_color;
$playerui->opacity = $playerui_setting->opacity;
//Watermark Settings
$playerui->watermark_right = $playerui_setting->watermark_right;
$playerui->watermark_right = $playerui_setting->watermark_top;
$playerui->watermark_bottom = $playerui_setting->watermark_bottom;
$playerui->watermark_left = $playerui_setting->watermark_left;
$playerui->watermark_opacity = $playerui_setting->watermark_opacity;
$playerui->watermar_link = $playerui_setting->watermar_link;
$playerui->watermar_width = $playerui_setting->watermar_width;
$playerui->user_id = $playerui_setting->user_id;




$logopath = URL::to('/public/uploads/settings/');
$path = public_path().'/uploads/settings/';
$watermark = $request['watermark_logo'];
if($watermark != '') {   
 //code for remove old file
 if($watermark != ''  && $watermark != null){
      $file_old = $path.$watermark;
     if (file_exists($file_old)){
      unlink($file_old);
     }
 }
 //upload new file
 $file = $watermark;
 $playerui->watermark_logo  = $logopath.'/'.$file->getClientOriginalName();
 $file->move($path, $playerui->watermark);

}
$playerui->save();
     return 1;
  
}

public function plans(Request $request)
{
  $input = $request->all();
  $plans = json_decode($input['plans']);

$new_plan = new Plan;
$new_plan->plans_name = $plans->plans_name;
$new_plan->days = $plans->days;
$new_plan->payment_type = $plans->payment_type;
$new_plan->price = $plans->price;
$new_plan->plan_id = $plans->plan_id;
$new_plan->type = $plans->type;
$new_plan->billing_interval = $plans->billing_interval;
$new_plan->user_id = $plans->user_id;

$c_count = Plan::where('plan_id', '=', $new_plan->plan_id)->count();
    if ( $c_count == 0) {
         $new_plan->save();
         return true;
    } else {
        return false;
    }
return true;
}



public function paypalplans(Request $request)
{
  $input = $request->all();
  $paypalplans = json_decode($input['paypalplans']);
// echo "<pre>";
// print_r($input);
// exit();


$new_plan = new PaypalPlan;
$new_plan->name = $paypalplans->plans_name;
$new_plan->payment_type = $paypalplans->payment_type;
$new_plan->type = $paypalplans->price;
$new_plan->description = $paypalplans->price;
$new_plan->plan_id = $paypalplans->plan_id;
$new_plan->user_id = $paypalplans->user_id;


$c_count = PaypalPlan::where('plan_id', '=', $new_plan->plan_id)->count();
if ( $c_count == 0) {
 $new_plan->save();
 return true;
} else {
return false;
}
return true;
}


public function coupons(Request $request)
{
  $input = $request->all();
  $coupons = json_decode($input['coupons']);
  $coupon = new Coupon;
$coupon->coupon_code = $coupons->coupon_code;
$coupon->user_id = $coupons->user_id;
$coupon->save();

return true;
}




public function series_store(Request $request)
{
  $data = $request->all();

  $series_stores = json_decode($data['series_store']);
$image = $data['image'];
$series_upload = $data['series_upload'];


  if(!empty($series_stores->artists)){
    $artistsdata = $series_stores->artists;
    unset($series_stores->artists);
}

         $path = public_path().'/uploads/videos/';
         $image_path = public_path().'/uploads/images/';

    $image = (isset($data['image'])) ? $data['image'] : '';
    if(!empty($image)){
        //$data['image'] = ImageHandler::uploadImage($data['image'], 'images');
        if($image != ''  && $image != null){
               $file_old = $image_path.$image;
              if (file_exists($file_old)){
               unlink($file_old);
              }
          }
          //upload new file
          $file = $image;
          $data['image']  = $file->getClientOriginalName();
          $file->move($image_path, $data['image']);

    } else {
        $data['image'] = 'placeholder.jpg';
    }
// exit();


if(empty($series_stores->active)){
    $series_stores->active = 0;
}

if(empty($series_stores->featured)){
    $series_stores->featured = 0;
}
$series_stores->title = $series_stores->title;
if(isset($series_stores->duration)){
        //$str_time = $series_stores
        $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $series_stores->duration);
        sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
        $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
        $series_stores->duration = $time_seconds;
}


$series = new Series;
$series->title = $series_stores->title;
$series->embed_code = $series_stores->embed_code;
$series->type = $series_stores->type;
$series->description = $series_stores->description;
$series->genre_id = $series_stores->genre_id;
$series->rating = $series_stores->rating;
$series->language = $series_stores->language;
$series->year = $series_stores->year;
// $series->tags = $series_stores->tags;
$series->duration = $series_stores->duration;
$series->access = $series_stores->access;
$series->featured = $series_stores->featured;
$series->active = $series_stores->active;
$series->trailer = "test";
$series->user_id = $series_stores->user_id;




 $series->save();
// print_r($series->id);
// exit();

// $series = Series::create($series_stores);

if(!empty($artistsdata)){
  // echo "test";
    foreach ($artistsdata as $key => $value) {
        $artist = new Seriesartist;
        $artist->series_id =  $series->id;
        $artist->artist_id = $value;
        $artist->artist_id = $series_stores->user_id;

        $artist->save();
     
    }
    
}
// $this->addUpdateSeriesTags($series, $tags);

$resolution_data['series_id'] = $series->id;
$subtitle_data['series_id'] = $series->id;

$series_upload = $data['series_upload'];

if($series_upload) {

 $rand = Str::random(16);
        $path = $rand . '.' . $request->series_upload->getClientOriginalExtension();
    // print_r($path);exit;
        $request->series_upload->storeAs('public', $path);
        $data['mp4_url'] = $path;
    

$update_url = Series::find($resolution_data['series_id']);

$update_url->mp4_url = $data['mp4_url'];

$update_url->save();  



}
/*Subtitle Upload*/
// $files = $request->file('subtitle_upload');
$shortcodes = $request->get('short_code');
$languages = $request->get('language');
return true;
}



public function artists(Request $request)
{
  $data = $request->all();
  $artists_data = json_decode($data['artists']);
$image = $data['image'];
$image_path = public_path().'/uploads/artists/';
$image = (isset($data['image'])) ? $data['image'] : '';
if(!empty($image)){  
      //code for remove old file
      if($image != ''  && $image != null){
           $file_old = $image_path.$image;
          if (file_exists($file_old)){
           unlink($file_old);
          }
      }
      //upload new file
      $file = $image;
      $data['image']  = $file->getClientOriginalName();
      $file->move($image_path, $data['image']);

 } else {
     $data['image']  = 'default.jpg';
 } 
//   echo "<pre>";
//   print_r($artists_data);
// exit();
  $artist = new Artist;
$artist->artist_name = $artists_data->artist_name;
$artist->description = $artists_data->description;
$artist->image = $file->getClientOriginalName();
$artist->user_id = $artists_data->user_id;

       

$artist->save();

return true;
}





public function audios_categories(Request $request)
{
  $data = $request->all();
  $audios_categories = json_decode($data['audios_categories']);
$image = $data['image'];

//   echo "<pre>";
//   print_r($audios_categories);
// exit();


$s = new AudioCategory();

$input['parent_id'] = empty($audios_categories->parent_id) ? 0 : $audios_categories->parent_id;

$path = public_path().'/uploads/audios/';

$image = $request['image'];

$slug = $audios_categories->slug; 

if ( $slug != '') {
 $input['slug']  = $audios_categories->slug;
} else {
  $input['slug']  = $audios_categories->name;
}


if($image != '') {   
//code for remove old file

if($image != ''  && $image != null){
  $file_old = $path.$image;
 if (file_exists($file_old)){
  unlink($file_old);
 }
}
//upload new file
$file = $image;
$input['image']  = $file->getClientOriginalName();
$file->move($path, $input['image']);
} else {
$input['image']  = 'default.jpg';
}


$AudioCategory = new AudioCategory;
$AudioCategory->name = $audios_categories->name;
$AudioCategory->slug = $audios_categories->slug;
$AudioCategory->parent_id = $audios_categories->parent_id;
$AudioCategory->user_id = $audios_categories->user_id;

$AudioCategory->save();



return true;
}






public function audios_album(Request $request)
{
  $data = $request->all();
  $audios_album = json_decode($data['audios_album']);
$image = $data['album'];



$path = public_path().'/uploads/audios/';
        
$image = $request['album'];
//   echo "<pre>";
//   print_r($audios_album);
// exit();
if($image != '') {   
     //code for remove old file

  if($image != ''  && $image != null){
     $file_old = $path.$image;
     if (file_exists($file_old)){
         unlink($file_old);
     }
 }
        //upload new file
 $file = $image;
 $input['image']  = $file->getClientOriginalName();
 $file->move($path, $input['image']);
} else {
 $input['image']  = 'default.jpg';
}


 /*Slug*/
    if ($audios_album->slug != '') {
        $input['slug'] = $audios_album->slug;
    }

    if($request->slug == ''){
        $input['slug'] =$audios_album->albumname;    
    }



$AudioAlbums = new AudioAlbums;
$AudioAlbums->albumname = $audios_album->albumname;
$AudioAlbums->album = $file->getClientOriginalName() ;
$AudioAlbums->slug = $audios_album->slug;
$AudioAlbums->user_id = $audios_album->user_id;

$AudioAlbums->save();



return true;
}




public function audios(Request $request)
{
  $data = $request->all();
  $audios = json_decode($data['audios']);
$image = $data['image'];



$path = public_path().'/uploads/audios/';
        
$image = $request['image'];
//   echo "<pre>";
//   print_r($audios);
// exit();


 /*Slug*/
// if ($audios->slug != '') {
//     $data['slug'] = $this->createSlug($audios->slug);
// }

// if($request->slug == ''){
//     $data['slug'] = $this->createSlug($data['title']);    
// }





$path = public_path().'/uploads/audios/';
        
$image = $request['image'];

if($image != '') {   
     //code for remove old file

  if($image != ''  && $image != null){
     $file_old = $path.$image;
     if (file_exists($file_old)){
         unlink($file_old);
     }
 }
        //upload new file
 $file = $image;
 $input['image']  = $file->getClientOriginalName();
 $file->move($path, $input['image']);
} else {
 $input['image']  = 'default.jpg';
}

// $audio = Audio::create($data);
$arr = $audios->artists;
$artists = implode(",",$arr);
// print_r($artists);
// exit();

$audio = new Audio;
$audio->title = $audios->title;
$audio->slug = $audios->slug;
$audio->type = $audios->type;
$audio->mp3_url = $audios->mp3_url;
$audio->details = $audios->details;
$audio->description = $audios->description;
$audio->artists = $artists;
$audio->album_id = $audios->album_id;
$audio->audio_category_id = $audios->audio_category_id;
$audio->rating = $audios->rating;
$audio->language = $audios->language;
$audio->year = $audios->year;
$audio->access = $audios->access;
$audio->featured = $audios->featured;
$audio->banner = $audios->banner;
$audio->active = $audios->active;
$audio->user_id = $audios->user_id;
$audio->image = $file->getClientOriginalName() ;



$audio->save();




$audio_id = $audio->id;

$audio_upload = ['audio_upload'];

// if($audio_upload){
//     $ffmpeg = FFMpeg\FFMpeg::create();
//     $audioupload = $ffmpeg->open($data['audio_upload']);

//     $audioupload
//     ->save(new ffmpeg\Format\Audio\Mp3('libmp3lame'), 'content/uploads/audios/'.$audio->id.'.mp3');

//     $data['mp3_url'] = URL::to('/').'/content/uploads/audios/'.$audio->id.'.mp3'; 

//     $update_url = Audio::find($audio_id);

//     $update_url->mp3_url = $data['mp3_url'];

//     $update_url->save();  
// }

return true;
}



public function edit_video(Request $request)
{

  $data = $request->all();
  $id =$data["id"];
 
  $video = Video::find($id);


  
  if($video != ""){
    $video_data =json_encode($video);

    return $video_data ;

  }else{
    return  false ;

  }
}

public function update_video(Request $request)
{
  $data = $request->all(); 


  $update_video = json_decode($data['video_data']);
$id = $update_video->id;
$video = Video::findOrFail($id);

if($update_video->slug == ''){
    $data['slug'] = ($update_video->title);    
}

$image = (isset($data['image'])) ? $data['image'] : '';
$trailer = (isset($data['trailer'])) ? $data['trailer'] : '';
$mp4_url2 = (isset($data['video'])) ? $data['video'] : '';
$files = (isset($data['subtitle_upload'])) ? $data['subtitle_upload'] : '';

$update_mp4 = $data['video'];
// echo "<pre>";
// print_r($update_mp4);
// exit();
if(empty($update_video->active)){
$update_video->active = 0;
} 


if(empty($update_video->webm_url)){
$update_video->webm_url = 0;
}  else {
    $update_video->webm_url =  $update_video->webm_url;
}  

if(empty($update_video->ogg_url)){
    $update_video->ogg_url = 0;
}  else {
    $update_video->ogg_url =  $update_video->ogg_url;
}  

if(empty($update_video->year)){
    $update_video->year = 0;
}  else {
    $update_video->year =  $update_video->year;
}   

if(empty($update_video->language)){
    $update_video->language = 0;
}  else {
    $update_video->language = $update_video->language;
} 


//        if(empty($update_video->featured)){
//            $update_video->featured = 0;
//        }  
if(empty($update_video->featured)){
    $update_video->featured = 0;
} 
 if(!empty($update_video->embed_code)){
    $update_video->embed_code = $update_video->embed_code;
} 


if(empty($update_video->active)){
    $update_video->active = 0;
} 
  if(empty($update_video->video_gif)){
    $update_video->video_gif = '';
}

if(empty($update_video->type)){
    $update_video->type = '';
}

 if(empty($update_video->status)){
    $update_video->status = 0;
}   

//            if(empty($update_video['path'])){
//                $update_video['path'] = 0;
//            }  



$path = public_path().'/uploads/videos/';
$image_path = public_path().'/uploads/images/';

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
  $data['image']  = $file->getClientOriginalName();
  $file->move($image_path, $data['image']);

} else {
 $data['image'] = $video->image;
}


if($trailer != '') {   
  //code for remove old file
  if($trailer != ''  && $trailer != null){
       $file_old = $path.$trailer;
      if (file_exists($file_old)){
       unlink($file_old);
      }
  }
  //upload new file
  $file = $trailer;
  $trailer_vid  = $file->getClientOriginalName();
  $file->move($path, $trailer_vid);

  $data['trailer']  = URL::to('/').'/public/uploads/videos/'.$file->getClientOriginalName();

} else {
 $data['trailer'] = $video->trailer;
}  


if( isset( $update_mp4 ) && $request->hasFile('video')){   
  //code for remove old file
    $rand = Str::random(16);
    $path = $rand . '.' . $request->video->getClientOriginalExtension();
    $request->video->storeAs('public', $path);
    $data['mp4_url'] = $path;
 
    $original_name = URL::to('/').'/storage/app/public/'.$path;

}


if(isset($update_video->duration)){
    //$str_time = $data
    $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $update_video->duration);
    sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
    $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
    $update_video->duration = $time_seconds;
}
if(!empty($update_video->embed_code)) {
 $video->embed_code = $update_video->embed_code;
}else {
$video->embed_code = '';
}
// echo "<pre>";
// print_r($update_video);
// exit();
$shortcodes = $update_video->short_code;        
$languages=$update_video->sub_language;
$video->description = strip_tags($update_video->description);
$video->details = $update_video->details;

$video->update($data);

if(!empty( $files != ''  && $files != null)){


foreach ($files as $key => $val) {
    if(!empty($files[$key])){
        
        $destinationPath ='public/uploads/subtitles/';
        $filename = $video->id. '-'.$shortcodes[$key].'.srt';
        $files[$key]->move($destinationPath, $filename);
        $subtitle_data['sub_language'] =$languages[$key]; /*URL::to('/').$destinationPath.$filename; */
        $subtitle_data['shortcode'] = $shortcodes[$key]; 
        $subtitle_data['movie_id'] = $id;
        $subtitle_data['url'] = URL::to('/').'/public/uploads/subtitles/'.$filename; 
        $video_subtitle = MoviesSubtitles::updateOrCreate(array('shortcode' => 'en','movie_id' => $id), $subtitle_data);
    }
}
}
return true;

}

public function destroy_video(Request $request){

  $data = $request->all();
  $id = $data['id'];
  $video = Video::find($id);

  Video::destroy($id);

  return true; 
}

public function edit_video_category(Request $request){

  $data = $request->all();
  $id = $data['id'];
  $categories = VideoCategory::where('id', '=', $id)->get();

  if($categories != ""){
    $category =json_encode($categories);

    return $category ;

  }else{
    return  false ;

  }
}


public function update_video_store(Request $request){

  $input = $request->all();
  

  $input =$request->all();
  $videos_categories = json_decode($input['videos_categories']);
  $image =$input['image'];
  



  $path = public_path().'/uploads/videocategory/';
           
  $id = $videos_categories->id;
  $in_home = $videos_categories->in_home; 
  $category = VideoCategory::find($id);
  // echo "<pre>";
  // print_r($category);
  // exit();
       if (isset($request['image']) && !empty($request['image'])){
              $image = $request['image']; 
           } else {
               $request['image'] = $category->image;
        }

        $slug = $videos_categories->slug; 
        if ( $in_home != '') {
            $input['in_home']  = $videos_categories->in_home;
        } else {
             $input['in_home']  = $videos_categories->in_home;
        }

    
      if( isset($image) && $image!= '') {   
      //code for remove old file
      if ($image != ''  && $image != null) {
          $file_old = $path.$image;
          if (file_exists($file_old)){
                 unlink($file_old);
          }
      }
            //upload new file
            $file = $image;
            $category->image  = $file->getClientOriginalName();
            $file->move($path,$category->image);

        } 
   
      $category->name = $videos_categories->name;
      $category->slug = $videos_categories->slug;
      $category->parent_id = $videos_categories->parent_id;
      $category->in_home = $videos_categories->in_home;

      if ( $category->slug != '') {
        $category->slug  = $videos_categories->slug;
      } else {
         $category->slug  = $videos_categories->name;
      }
     
      $category->save();
return true ;


}



public function destroy_video_category(Request $request){

  $data = $request->all();
  $id = $data['id'];
  VideoCategory::destroy($id);
        $child_cats = VideoCategory::where('parent_id', '=', $id)->get();
        foreach($child_cats as $cats){
            $cats->parent_id = 0;
            $cats->save();
        }

  return true; 
}


public function edit_series(Request $request){

  $data = $request->all();
  $id = $data['id'];
  
  $series = Series::find($id);
  $results = Episode::all();
  //$episode = Episode::all();
  $series_categories = Genre::all();
  $seasons = SeriesSeason::where('series_id','=',$id)->with('episodes')->get();
$data =array(
  'series' => $series,
  'seasons' => $seasons,
  'series_categories' => $series_categories,
  'results' => $results,
);
  return $data; 
}

public function update_series(Request $request){

  $data =$request->all();
  $series_store = json_decode($data['series_store']);

  $id = $series_store->id;
  $series = Series::findOrFail($id);

  /*Slug*/
  if ($series->slug != $request->slug) {
      $data['slug'] = $series_store->slug;
  }

  if($request->slug == '' || $series->slug == ''){
      $data['slug'] = $series_store->title;    
  }
//        $tags = $data['tags'];
//        unset($data['tags']);
//        $this->addUpdateSeriesTags($series, $tags);

  if(isset($series_store->duration)){
          //$str_time = $data
          $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $series_store->duration);
          sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
          $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
          $series_store->duration = $time_seconds;
  }

   $path = public_path().'/uploads/videos/';
   $image_path = public_path().'/uploads/images/';
  
      $image = (isset($data['image'])) ? $data['image'] : '';
      if(!empty($image)){
          //$data['image'] = ImageHandler::uploadImage($data['image'], 'images');
          if($image != ''  && $image != null){
                 $file_old = $image_path.$image;
                if (file_exists($file_old)){
                 unlink($file_old);
                }
            }
            //upload new file
            $file = $image;
            $data['image']  = $file->getClientOriginalName();
            $file->move($image_path, $data['image']);

      } else {
          $data['image'] = 'placeholder.jpg';
      }

  if(empty($series_store->active)){
      $series_store->active = 0;
  }

  if(empty($series_store->featured)){
      $series_store->featured = 0;
  }
  
  $series_upload = $data['series_upload'];
  $resolution_data['series_id'] = $series->id;
  $subtitle_data['series_id'] = $series->id;
  
  if($series_upload) {

          $rand = Str::random(16);
          $path = $rand . '.' . $data['series_upload']->getClientOriginalExtension();
      //print_r($path);exit;
          $data['series_upload']->storeAs('public', $path);
          $data['mp4_url'] = $path;
      
          $update_url = Series::find($resolution_data['series_id']);

          $update_url->mp4_url = $data['mp4_url'];

          $update_url->save();  



  }

  
  $series->title = $series_store->title;
$series->embed_code = $series_store->embed_code;
$series->type = $series_store->type;
$series->description = $series_store->description;
$series->genre_id = $series_store->genre_id;
$series->rating = $series_store->rating;
$series->language = $series_store->language;
$series->year = $series_store->year;
// $series->tags = $series_store->tags;
$series->duration = $series_store->duration;
$series->access = $series_store->access;
$series->featured = $series_store->featured;
$series->active = $series_store->active;
$series->trailer = "test";
$series->user_id = $series_store->user_id;


  
  $series->save();

  if(empty($data['series_upload'])){
      unset($data['series_upload']);
  } 

    /*Subtitle Upload*/
  $files = $request->file('subtitle_upload');
  $shortcodes = $request->get('short_code');
  $languages = $request->get('language');

  // if($request->hasFile('subtitle_upload'))
  // {
  //     foreach ($files as $key => $val) {
  //         if(!empty($files[$key])){
              
  //             $destinationPath ='content/uploads/subtitles/';
  //             $filename = $id. '-'.$shortcodes[$key].'.vtt';
  //             $files[$key]->move($destinationPath, $filename);
  //             $subtitle_data['sub_language'] = $languages[$key]; 
  //             $subtitle_data['series_id'] = $id; 
  //             $subtitle_data['shortcode'] = $shortcodes[$key]; 
  //             $subtitle_data['url'] = URL::to('/').'/content/uploads/subtitles/'.$filename; 
  //             $series_subtitle = SeriesSubtitle::updateOrCreate(array('shortcode' => 'en','series_id' => $id), $subtitle_data);
  //         }
  //     }
  // }
  return true; 
}

public function destory_series(Request $request){

  $data = $request->all();
  $id = $data['id'];
  $series = Series::find($id);
  Series::destroy($id);

  return true; 
}



public function edit_audio(Request $request){

  $data = $request->all();
  
      
  $id = $data['id'];
  
  $audio = Audio::find($id);
 
  return $audio; 
}

public function update_audio(Request $request){

  $data = $request->all();
  // print_r($data);
  //       exit();
  $audios = json_decode($data['audios']);
  $id = $audios->id;
        $audio = Audio::findOrFail($id);


     
        /*Slug*/
        if ($audio->slug != $audios->slug) {
            $data['slug'] = $audios->slug;
        }

        if($request->slug == '' || $audio->slug == ''){
            $data['slug'] = $audios->title;    
        }
        if(isset($audios->duration)){
                //$str_time = $audios
                $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $audios->duration);
                sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                $audios->duration = $time_seconds;
        }


        $path = public_path().'/uploads/audios/';
        
        $image = $request['image'];
        
        if($image != '') {   
             //code for remove old file
        
          if($image != ''  && $image != null){
             $file_old = $path.$image;
             if (file_exists($file_old)){
                 unlink($file_old);
             }
         }
                //upload new file
         $file = $image;
         $data['image']  = $file->getClientOriginalName();
         $file->move($path, $data['image']);
        } else {
         $data['image']  = 'default.jpg';
        }

        if(empty($audios->active)){
            $audios->active = 0;
        }

        if(empty($audios->featured)){
            $audios->featured = 0;
        }
        $arr = $audios->artists;
$artists = implode(",",$arr);
        $audio->title = $audios->title;
        $audio->slug = $audios->slug;
        $audio->type = $audios->type;
        $audio->mp3_url = $audios->mp3_url;
        $audio->details = $audios->details;
        $audio->description = $audios->description;
        $audio->artists = $artists;
        $audio->album_id = $audios->album_id;
        $audio->audio_category_id = $audios->audio_category_id;
        $audio->rating = $audios->rating;
        $audio->language = $audios->language;
        $audio->year = $audios->year;
        $audio->access = $audios->access;
        $audio->featured = $audios->featured;
        $audio->banner = $audios->banner;
        $audio->active = $audios->active;
        $audio->user_id = $audios->user_id;
        $audio->image = $file->getClientOriginalName() ;

        $audio->update($data);

        if(empty($data['audio_upload'])){
            unset($data['audio_upload']);
        } else {
        
        $audio_upload = $data['audio_upload'];













        // if($audio_upload){
        //     $ffmpeg = FFMpeg\FFMpeg::create();
        //     $audio = $ffmpeg->open($data['audio_upload']);

        //     $audio
        //     ->save(new FFMpeg\Format\Audio\Mp3('libmp3lame'), 'content/uploads/audios/'.$id.'.mp3');

        //     $data['mp3_url'] = URL::to('/').'/content/uploads/audios/'.$id.'.mp3'; 

        //     $update_url = Audio::find($id);

        //     $update_url->mp3_url = $data['mp3_url'];

        //     $update_url->save();  
        // }

        }

return true;
}
public function destory_audio(Request $request){

  $data = $request->all();
  $id = $data['id'];
  // print_r($id);
  // exit();
  $audio = Audio::find($id);

        // $this->deleteAudioImages($audio);

        Audio::destroy($id);
 
  return true; 
}

public function edit_audio_categories(Request $request){

  $data = $request->all();
  $id = $data['id'];
  
    
  $categories = AudioCategory::where('id', '=', $id)->get();

  $allCategories = AudioCategory::all();
$data =array(
  'categories' => $categories,
  'allCategories' => $allCategories,

);

  return $data; 
 
  return true; 
}
public function destroy_audio_categories(Request $request){

  $data = $request->all();
  $id = $data['id'];
  
    
  AudioCategory::destroy($id);
            
  $child_cats = AudioCategory::where('parent_id', '=', $id)->get();
  
  foreach($child_cats as $cats){
      $cats->parent_id = 0;
      $cats->save();
  }
  return true; 
}
public function edit_artist_categories(Request $request){

  $data = $request->all();
  $id = $data['id'];
  
    
  $artist = Artist::find($id);
 

  return $artist;   
}
public function update_artist_categories(Request $request){

  $data = $request->all();
  $artists_data = json_decode($data['artists']);
  
  $id = $artists_data->id;
        $artist = Artist::findOrFail($id);
        $image_path = public_path().'/uploads/artists/';
        $image = (isset($data['image'])) ? $data['image'] : '';
        if(empty($data['image'])){
            unset($data['image']);
        } else {
            //code for remove old file
        	if($image != ''  && $image != null){
        		$file_old = $image_path.$image;
        		if (file_exists($file_old)){
        			unlink($file_old);
        		}
        	}
              //upload new file
        	$file = $image;
        	$data['image']  = $file->getClientOriginalName();
        	$file->move($image_path, $data['image']);
        }

        $artist->artist_name = $artists_data->artist_name;
        $artist->description = $artists_data->description;
        $artist->image = $file->getClientOriginalName();
        $artist->user_id = $artists_data->user_id;
        $artist->update($data);


  return true; 
}

public function destroy_artist_categories(Request $request){

  $data = $request->all();
  $id = $data['id'];
  
    
  $artist = Artist::find($id);

  // $this->deleteArtistImages($artist);

  Artist::destroy($id);

  return true; 
}



public function editAlbum(Request $request){

  $data = $request->all();
  $id = $data['id'];
  
  $categories = AudioAlbums::where('id', '=', $id)->get();
  $allAlbums = AudioAlbums::all();
  $allCategories = AudioCategory::all();
$data = array(
  'audioCategories' => $allCategories,
  'allAlbums' => $allAlbums,
  'categories' => $categories

);
  return $data;   
}





public function destroyAlbum(Request $request){

  $data = $request->all();
  $id = $data['id'];
  AudioAlbums::destroy($id);
  
  return true;   
}



public function MobileSliderEdit(Request $request){

  $data = $request->all();
  $id = $data['id'];
  $categories = MobileSlider::where('id', '=', $id)->get();
  $allCategories = MobileSlider::all();
  $data = array (
    'allCategories'=>$allCategories,
    'categories'=>$categories

  );
  return $data; 
}
public function MobileSliderUpdate(Request $request){

  $input = $request->all();

  $mobile_settings = json_decode($input['mobile_settings']);
  $id = $mobile_settings->id;
  $path = public_path().'/uploads/videocategory/';
  // echo "<pre>";
  // print_r($id);
  // exit();
  $id = $mobile_settings->id;
  $in_home = $mobile_settings->active; 
  $link = $mobile_settings->link; 
  $category = MobileSlider::find($id);
       if (isset($request['slider']) && !empty($request['slider'])){
              $image = $request['slider']; 
           } else {
               $request['slider'] = $category->slider;
        }
       // $slug = $request['slug']; 
        if ( $in_home != '') {
            $input['active']  = $request['active'];
        } else {
             $input['active']  = $request['active'];
        }
      if( isset($image) && $image!= '') {   
              //code for remove old file
              if ($image != ''  && $image != null) {
                  $file_old = $path.$image;
                  if (file_exists($file_old)){
                         unlink($file_old);
                  }
              }
              $file = $image;
              $category->slider  = $file->getClientOriginalName();
              $file->move($path,$category->slider);
        } 
      $category->link  = $link;
      $category->active = $in_home;
      $category->slider = $file->getClientOriginalName();
      $category->user_id = $mobile_settings->user_id;

      $category->save();
      
  return true; 
}
public function MobileSliderDelete(Request $request){

  $data = $request->all();
  $id = $data['id'];
  
  MobileSlider::destroy($id);


  return true; 
}


public function page_edit(Request $request){

  $data = $request->all();
  $id = $data['id'];
  $page = Page::find($id);


  return $page; 
}

public function page_update(Request $request){

  $data = $request->all();
  $pages = json_decode($data['pages']);
 
  $id = $pages->id; 
  // $page = Page::findOrFail($id);
  // print_r($pages);
  // exit();
  
  
   $path = public_path().'/uploads/settings/';
  
   $logo = $request['banner'];
  
  /* logo upload */
    
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
    $data['banner']  = $file->getClientOriginalName();
    $file->move($path, $data['banner']);
   
}


  if(!isset($pages->active) || $pages->active == ''){
      $pages->active = 0;
  }
  $page->title =$pages->title;
  $page->slug =$pages->slug;
  $page->body =$pages->body;
  $page->active =$pages->active;
  $page->user_id =$pages->user_id;
  $page->banner =$file->getClientOriginalName();
  $page->update($data);


  return true; 
}

public function page_destory(Request $request){

  $data = $request->all();
  $id = $data['id'];
  $page = Page::find($id);

  Page::destroy($id);


  return true; 
}

public function plans_edit(Request $request){

  $data = $request->all();
  $id = $data['id'];
  $edit_plan =  Plan::where('id', '=', $id)->get();



  return $edit_plan; 
}


public function plans_update(Request $request){

  $data = $request->all();
  $plan = json_decode($data['plans']);
  $id = $plan->id; 
  $plans = Plan::find($id);
  $plans->plans_name = $plan->plans_name;
 $plans->days = $plan->days;
 $plans->payment_type = $plan->payment_type;
 $plans->price  = $plan->price;
    $plans->plan_id  = $plan->plan_id;
    $plans->type  = $plan->type;
 $plans->billing_interval  = $plan->billing_interval;
$plans_count = Plan::where('plans_name', '=', $plans->plans_name)->count();
    $plans->save();


  return true; 
}

public function plans_destory(Request $request){

  $data = $request->all();
  $id = $data['id'];
  Plan::where('id',$id)->delete();



  return true; 
}

public function PaypalEdit(Request $request){

  $data = $request->all();
  $id = $data['id'];
  $edit_plan =  PaypalPlan::where('id', '=', $id)->get();



  return $edit_plan; 
}

public function PaypalUpdate(Request $request){

  $data = $request->all();
  $paypalplans = json_decode($data['paypalplans']);
  $id = $paypalplans->id; 
  $plans = PaypalPlan::find($id);
    	$plans->name = $paypalplans->plans_name;
    	$plans->price = $paypalplans->price;
    	$plans->payment_type = $paypalplans->payment_type;
        $plans->plan_id  = $paypalplans->plan_id;
$plans->user_id = $paypalplans->user_id;

        $plans->save();


  return true; 
}

public function PaypalDelete(Request $request){

  $data = $request->all();
  $id = $data['id'];
  PaypalPlan::where('id',$id)->delete();

  // echo "<pre>";
  //           print_r($id);
  //           exit();


  return true; 
}


public function editcoupons(Request $request){

  $data = $request->all();
  $id = $data['id'];
  $edit_coupons =  Coupon::where('id', '=', $id)->get();


  return $edit_coupons; 
}
public function updatecoupons(Request $request){

  $data = $request->all();
  $coupons = json_decode($data['coupons']);
  
  $id = $coupons->id; 
        // echo "<pre>";
        //     print_r($coupons);
        //     exit();
        $plans = Coupon::find($id);
      $plans->coupon_code = $coupons->coupon_code;
      $plans->user_id = $coupons->user_id;
        $plans->save();


  return true; 
}
public function deletecoupons(Request $request){

  $data = $request->all();
  $id = $data['id'];
  Coupon::where('id',$id)->delete();

  return true; 
}

public function deletecountry(Request $request){

  $data = $request->all();
  $id = $data['id'];
  Country::where('id',$id)->delete();

  return true; 
}


public function SliderEdit(Request $request){

  $data = $request->all();
  $id = $data['id'];
  $categories = Slider::where('id', '=', $id)->get();

  $allCategories = Slider::all();
  $data = array (
    'allCategories'=>$allCategories,
    'categories'=>$categories

  );
  return $data; 
}
public function SliderUpdate(Request $request){

  $input = $request->all();

  $slider = json_decode($input['slider']);
  $id = $slider->id;
    
  $path = public_path().'/uploads/videocategory/';
           
  $id = $slider->id;
  $in_home = $slider->active; 
  $link = $slider->link; 
  // echo "<pre>";
  // print_r($input);
  // exit();
  $category = Slider::find($id);
 
       if (isset($request['slider_image']) && !empty($request['slider_image'])){
              $image = $request['slider_image']; 
           } else {
               $request['slider_image'] = $request['slider_image'];
        }

       // $slug = $request['slug']; 
        if ( $in_home != '') {
            $input['active']  = $slider->active;
        } else {
             $input['active']  = $slider->active;
        }
      if( isset($image) && $image!= '') {   
              //code for remove old file
              if ($image != ''  && $image != null) {
                  $file_old = $path.$image;
                  if (file_exists($file_old)){
                         unlink($file_old);
                  }
              }
              $file = $image;
              $category->slider  = $file->getClientOriginalName();
              $file->move($path,$category->slider);
        } 

      $category->link  = $link;
      $category->active = $slider->active;
      $category->user_id = $slider->user_id;

      $category->save();
      
  return true; 
}
public function SliderDelete(Request $request){

  $input = $request->all();

  // $slider = json_decode($input['slider']);
  $id = $input['id'];
    
  
  Slider::destroy($id);


  return true; 
}

public function menu_edit(Request $request){

  $data = $request->all();
  $id = $data['id'];
  
  $menu = Menu::find($id);



  return $menu; 
}
public function menu_update(Request $request){

  $data = $request->all();
  $id = $data['id'];
  
  Menu::find($data['id'])->update($data);

  return true; 
}
public function menu_destroy(Request $request){

  $data = $request->all();
  $id = $data['id'];
  
  Menu::destroy($id);
  $child_menu_items = Menu::where('parent_id', '=', $id)->get();
  foreach($child_menu_items as $menu_items){
      $menu_items->parent_id = NULL;
      $menu_items->save();
  }


  return true; 
}

public function LanguageEdit(Request $request){

  $data = $request->all();
  $id = $data['id'];
  $categories = VideoLanguage::where('id', '=', $id)->get();
  $allCategories = VideoLanguage::all();
$data =array(
  'categories' => $categories,
  'allCategories' => $allCategories,
);

  return $data; 
}
public function LanguageUpdate(Request $request){

  $data = $request->all();
  $id = $data['id'];
  $id = $data['id'];
  $name = $data['name']; 
  $category = VideoLanguage::find($id);
  $category->name = $data['name'];
  $category->save();
   
  return back()->with('success', 'New Language Updated successfully.');


  return true; 
}
public function LanguageDelete(Request $request){

  $data = $request->all();
  $id = $data['id'];
  VideoLanguage::destroy($id);


  return true; 
}


public function LanguageTransEdit(Request $request){

  $data = $request->all();
  $id = $data['id'];
  $categories = VideoLanguage::where('id', '=', $id)->get();
  $allCategories = VideoLanguage::all();
$data =array(
  'categories' => $categories,
  'allCategories' => $allCategories,
);

  return $data; 
}
public function LanguageTransUpdate(Request $request){

  $data = $request->all();
  $id = $request['id'];
  $name = $request['name']; 
  $category = Language::find($id);
  $category->name = $request['name'];
  $category->save();
   
  return back()->with('success', 'New Language Updated successfully.');


  return true; 
}
public function LanguageTransDelete(Request $request){

  $data = $request->all();
  $id = $data['id'];
  Language::destroy($id);


  return true; 
}



public function user_edit(Request $request){

  $data = $request->all();
  $id = $data['id'];
  // print_r($data);
  // exit();
  // $referral_link ="";
  $user = User::where('id', '=', $id)->first();

  return $user; 
}
public function user_update(Request $request){

  $input =$request->all();
  $user_store = json_decode($input['user_store']);
  $email =$user_store->email;
  $ccode =$user_store->ccode;
  $mobile =$user_store->mobile;
  $passwords =$user_store->passwords;
  $role =$user_store->role;
  $_token =$user_store->_token;
  $user_id =$user_store->user_id;
  $id =$user_store->id;


  $avatar = $input['avatar'];
        
		$user = User::find($id);        
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
      
        if ( $rolerole =='subadmin' ){
            
                $role ='admin';
                $sub_admin = 1;
                $stripe_active = 1;
            
        } else {
            
             $role = $role;
        }
    
        
        $terms = 1;
        $stripe_active = 0;


        if(empty($user_store->passwords)) {
        	$input['passwords'] = $user->password;
        } 
        else { 
                $input['passwords'] = $user_store->passwords; 
            }
       
        $user_update = User::find($id);
        $user_update->email = $user_update->email;
        $user_update->password = $user_update->password;
        $user_update->role = $user_update->role;
        $user_update->terms = $user_update->terms;
        $user_update->stripe_active = $stripe_active;
        $user_update->username = $user_update->username;
        $user_update->save();
   

  return true; 
}
public function user_delete(Request $request){

  $data = $request->all();
  $id = $data['id'];
  User::destroy($id);


  return true; 
}


public function userroles_edit(Request $request){

  $data = $request->all();
  $id = $data['id'];

  $roles = Role::find($id);


  return $roles; 
}
public function userroles_update(Request $request){

  $input =$request->all();
  $user_role = json_decode($input['user_role']);

  $id = $user_role->id;
  $role = Role::find($id);
  $role->name =  $user_role->name;
  $role->save();


  return true; 
}
public function userroles_destroy(Request $request){

  $data = $request->all();
  $id = $data['id'];
  $role = Role::find($id);
  $role->delete();



  return true; 
}


public function refferal() {
  return View::make('refferal');
}

public function livestream_edit(Request $request){

  $data = $request->all();
  $id = $data['id'];

  $video = LiveStream::find($id);
  $video_categories = LiveCategory::all();
  $languages = Language::all();
$data = array(

  'video' => $video,
  'video_categories' => $video_categories,
  'languages' => $languages,

);
  return $data; 
}
public function livestream_update(Request $request){

  $data =$request->all();
  $livestream = json_decode($data['livestream']);

  $id = $livestream->id;
 
  $video = LiveStream::findOrFail($id);  

//  echo "<pre>";
//  print_r($video);
//  exit();
    $image = ($data['image']) ? $data['image'] : '';
    $mp4_url = (isset($livestream->mp4_url)) ? $livestream->mp4_url : '';
 
 if(empty($livestream->active)){
     $livestream->active = 0;
 } 

 if(empty($livestream->ppv_status)){
     $livestream->ppv_status = 0;
 }
 if(empty($livestream->slug)){
     $livestream->slug = 0;
 }
 
 if(empty($livestream->rating)){
     $livestream->rating = 0;
 }
 
 if(empty($livestream->year)){
     $livestream->year = 0;
 }

 if(empty($livestream->featured)){
     $livestream->featured = 0;
 }  
 
  if(empty($livestream->status)){
     $livestream->status = 0;
 }  
 
 if(empty($livestream->type)){
     $livestream->type = '';
 }
 


 
 $path = public_path().'/uploads/livecategory/';
 $image_path = public_path().'/uploads/images/';
   
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
       $data['image']  = $file->getClientOriginalName();
       $file->move($image_path, $data['image']);

  } 

  $livestream->mp4_url  = $livestream->mp4_url;

  if(isset($livestream->duration)){
         //$str_time = $data
         $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $livestream->duration);
         sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
         $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
         $livestream->duration = $time_seconds;
 }


  // $shortcodes =$livestream->mp4_url->short_code;
  // $languages =$livestream->mp4_url->language;

  $video['title'] =$livestream->title;
  $video['details'] =$livestream->details;
  $video['video_category_id'] =$livestream->video_category_id;
  $video['description'] =$livestream->description;
  $video['featured'] =$livestream->featured;
  $video['language'] =$livestream->language;
  $video['banner'] =$livestream->banner;
  $video['duration'] =$livestream->duration;
  $video['footer'] =$livestream->footer;
  $video['slug'] =$livestream->slug;
  // $video['status'] =$livestream->status;
  $video['image'] =$file->getClientOriginalName();
  $video['mp4_url'] =$livestream->mp4_url;
  $video['year'] =$livestream->year;
  
  $video->save();

//  $video->update($data);


  return true; 
}

public function livestreamcategory_edit(Request $request){

  $data = $request->all();
  $id = $data['id'];

  $categories = LiveCategory::where('id', '=', $id)->get();

  $allCategories = LiveCategory::all();
  $data = array(

    'categories' => $categories,
    'allCategories' => $allCategories,
  
  );
    return $data; 
}
public function livestreamcategory_update(Request $request){

  $input =$request->all();
  $livestream_categories = json_decode($input['livestream_categories']);
     
  $path = public_path().'/uploads/livecategory/';

  $id = $livestream_categories->id;
  $category = LiveCategory::find($id);

   if (isset($request['image']) && !empty($request['image'])){
      $image = $request['image']; 
   } else {
       $request['image'] = $category->image;
   }

   if( isset($image) && $image!= '') {   
    //code for remove old file
        if($image != ''  && $image != null){
             $file_old = $path.$image;
            if (file_exists($file_old)){
             unlink($file_old);
            }
        }
        //upload new file
        $file = $image;
        $category->image  = $file->getClientOriginalName();
        $file->move($path,$category->image);

   } 

  
  
  $category->name = $livestream_categories->name;
  $category->slug = $livestream_categories->slug;
  $category->parent_id = $livestream_categories->parent_id;
  
   if ( $category->slug != '') {
    $category->slug  = $livestream_categories->slug;
    } else {
         $category->slug  = $livestream_categories->name;
    }
  
  
  $category->save();

  return true; 
}

public function livestreamcategory_destroy(Request $request){

  $data = $request->all();
  $id = $data['id'];

  LiveCategory::destroy($id);
            
  $child_cats = LiveCategory::where('parent_id', '=', $id)->get();
  
  foreach($child_cats as $cats){
      $cats->parent_id = 0;
      $cats->save();
  }



  return true; 
}



















}

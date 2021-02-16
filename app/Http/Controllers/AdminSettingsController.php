<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use \App\User as User;
use \Redirect as Redirect;
//use Request;
use URL;
use Auth;
use App\Setting as Setting;
use Hash;
use Illuminate\Support\Facades\Cache;
use Image;

//use Illuminate\Http\Request;

class AdminSettingsController extends Controller
{
    public function index() {
        
        $setting = Setting::first();
        
        $data = array(
            'admin_user' => Auth::user(),
			'settings' => $setting,
			);
		return \View::make('admin.settings.index', $data);
        
    }
    
    public function save_settings(Request $request){

		//$input = Request::all();
        $input = $request->all();
		$settings = Setting::find(1);
		$settings->demo_mode = $request['demo_mode'];
		$settings->ppv_hours = $request['ppv_hours'];
		$settings->videos_per_page = $request['videos_per_page'];
		$settings->ppv_price = $request['ppv_price'];
		$settings->website_description = $request['website_description'];
		$settings->website_name = $request['website_name'];
		$settings->login_text = $request['login_text'];
		$settings->signature = $request['signature'];
		$settings->system_email = $request['system_email'];
		$settings->enable_https = $request['enable_https'];
		$settings->free_registration = $request['free_registration'];
		$settings->activation_email = $request->get('activation_email');
		$settings->premium_upgrade = $request['premium_upgrade'];
		$settings->facebook_page_id = $request['facebook_page_id'];
		$settings->google_page_id = $request['google_page_id'];
		$settings->twitter_page_id = $request['twitter_page_id'];
		$settings->youtube_page_id = $request['youtube_page_id'];
		$settings->google_tracking_id = $request['google_tracking_id'];
		$settings->signature = $request['signature'];
		$settings->login_text = $request['login_text'];
		$settings->login_text = $request['login_text'];
		$settings->coupon_status = $request['coupon_status'];
		$settings->new_subscriber_coupon = $request['new_subscriber_coupon'];
		$settings->coupon_code = $request['coupon_code'];
		$settings->earn_amount = $request['earn_amount'];
		$settings->system_email = $request['system_email'];
		$settings->discount_percentage = $request['discount_percentage'];
        
		$settings->notification_key = $request['notification_key'];
        
        $settings->ppv_status = $request['ppv_status'];
        
         $path = public_path().'/uploads/settings/';
         $logo = $request['logo'];
         $favicon = $request['favicon'];
         $login_content = $request['login_content'];

         $notification_icon = $request['notification_icon'];
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
      
        return Redirect::to('admin/settings')->with(array('note' => 'Successfully Updated Site Settings!', 'note_type' => 'success') );

	}
   
    
    
}

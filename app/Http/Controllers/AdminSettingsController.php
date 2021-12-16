<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use \App\User as User;
use \Redirect as Redirect;
//use Request;
use URL;
use Auth;
use App\Setting as Setting;
use App\Playerui as Playerui;
use Hash;
use Illuminate\Support\Facades\Cache;
use Image;

//use Illuminate\Http\Request;

class AdminSettingsController extends Controller
{
    public function index() {
        
        $setting = Setting::first();
        //   echo "<pre>";
        // print_r($setting);
        // exit();
        $data = array(
            'admin_user' => Auth::user(),
			'settings' => $setting,
			);
		return \View::make('admin.settings.index', $data);
        
    }
    
    public function save_settings(Request $request){

		//$input = Request::all();
        $input = $request->all();

        // echo "<pre>";
        // print_r($input);
        // exit();

        if(!empty($request['instagram_page_id'])){
        $instagram_page_id = $request['instagram_page_id'];
        }else{
        $instagram_page_id = null;
        }
        if(!empty($request['linkedin_page_id'])){
          $linkedin_page_id = $request['linkedin_page_id'];
          }else{
          $linkedin_page_id = null;
          }
      if(!empty($request['whatsapp_page_id'])){
        $whatsapp_page_id = $request['whatsapp_page_id'];
        }else{
        $whatsapp_page_id = null;
        }
      if(!empty($request['skype_page_id'])){
        $skype_page_id = $request['skype_page_id'];
        }else{
        $skype_page_id = null;
        }
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
    $settings->ads_on_videos = $request['ads_on_videos'];
		$settings->premium_upgrade = $request['premium_upgrade'];
		$settings->access_free = $request['access_free'];
		$settings->facebook_page_id = $request['facebook_page_id'];
		$settings->google_page_id = $request['google_page_id'];
		$settings->twitter_page_id = $request['twitter_page_id'];
		$settings->instagram_page_id = $instagram_page_id;
		$settings->linkedin_page_id = $linkedin_page_id;
		$settings->whatsapp_page_id = $whatsapp_page_id;
		$settings->skype_page_id = $skype_page_id;
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

    if(empty($settings->ads_on_videos)){
      $settings->ads_on_videos = 0;
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
    if(empty($settings->access_free)){
			$settings->access_free = 0;
		} 
        
        
        $settings->save();
      
        return Redirect::to('admin/settings')->with(array('note' => 'Successfully Updated Site Settings!', 'note_type' => 'success') );

	}
   
  public function playerui_index() {
    // $setting = Setting::first();
 
    $playerui = Playerui::first();

    $data = array(
      'admin_user' => Auth::user(),
      'playerui' => $playerui,
      // 'settings' => $setting,
    );

    return \View::make('admin.players.index', $data);

  }  
  public function playerui_settings() {

    $playerui_settings = Playerui::first();

return view('videolayout.header',compact('playerui_settings') );

  }  
  public function playerui_settings_footer() {

    $playerui_settings = Playerui::first();

return view('videolayout.footer',compact('playerui_settings') );

  }  




  public function storeplayerui(Request $request){
    $input = $request->all();

    $playerui = Playerui::find(1);
    $watermark_right = $request['watermark_right'];

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
    $playerui->show_logo = $request['show_logo'];
    if(empty($playerui->show_logo)){
      $playerui->show_logo = 0;
    }else{
      $playerui->show_logo = 1;
    }

    $playerui->skip_intro = $request['skip_intro'];
    if(empty($playerui->skip_intro)){
      $playerui->skip_intro = 0;
    }else{
      $playerui->skip_intro = 1;
    }

    $playerui->embed_player = $request['embed_player'];
    if(empty($playerui->embed_player)){
      $playerui->embed_player = 0;
    }else{
      $playerui->embed_player = 1;
    }

    $playerui->watermark = $request['watermark'];
    if(empty($playerui->watermark)){
      $playerui->watermark = 0;
    }else{
      $playerui->watermark = 1;
    }

    $playerui->thumbnail = $request['thumbnail'];
    if(empty($playerui->thumbnail)){
      $playerui->thumbnail = 0;
    }else{
      $playerui->thumbnail = 1;
    }

    $playerui->advance_player = $request['advance_player'];
    if(empty($playerui->advance_player)){
      $playerui->advance_player = 0;
    }else{
      $playerui->advance_player = 1;
    }

    $playerui->speed_control = $request['speed_control'];
    if(empty($playerui->speed_control)){
      $playerui->speed_control = 0;
    }else{
      $playerui->speed_control = 1;
    }

    $playerui->video_card = $request['video_card'];
    if(empty($playerui->video_card)){
      $playerui->video_card = 0;
    }else{
      $playerui->video_card = 1;
    }

    $playerui->subtitle = $request['subtitle'];
    if(empty($playerui->subtitle)){
      $playerui->subtitle = 0;
    }else{
      $playerui->subtitle = 1;
    }

    $playerui->subtitle_preference = $request['subtitle_preference'];
    if(empty($playerui->subtitle_preference)){
      $playerui->subtitle_preference = 0;
    }else{
      $playerui->subtitle_preference = 1;
    }

    $playerui->font = $request['font'];
    $playerui->size = $request['size'];
    $playerui->font_color = $request['font_color'];
    $playerui->background_color = $request['background_color'];
    $playerui->opacity = $request['opacity'];
    //Watermark Settings
    $playerui->watermark_right = $request['watermark_right'];
    $playerui->watermark_right = $request['watermark_top'];
    $playerui->watermark_bottom = $request['watermark_bottom'];
    $playerui->watermark_left = $request['watermark_left'];
    $playerui->watermark_opacity = $request['watermark_opacity'];
    $playerui->watermar_link = $request['watermar_link'];
    $playerui->watermar_width = $request['watermar_width'];


    // http://localhost/flicknexs/public/uploads/settings/1

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
     $file->move($path, $playerui->watermark_logo);
    
}
    $playerui->save();
      
    return Redirect::to('admin/players')->with(array('message' => 'Successfully Updated Player Setting UI!', 'note_type' => 'success') );
  }

  public function playerui_settings_episode() {

    $playerui_settings = Playerui::first();

    return view('videolayout.episode_header',compact('playerui_settings') );

  }  

}

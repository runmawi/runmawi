<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\User as User;
use \Redirect as Redirect;
//use Request;
use URL;
use Auth;
use App\Setting as Setting;
use App\Script as Script;
use App\Playerui as Playerui;
use App\AppSetting as AppSetting;
use Hash;
use Illuminate\Support\Facades\Cache;
use Image;
use App\ThumbnailSetting;
use App\RTMP;
use Illuminate\Support\Facades\Storage;
use View;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use App\FooterLink;
use App\LinkingSetting;
use App\CompressImage;
use App\Captcha;
use App\TimeZone;
use App\CommentSection;
use App\WebComment;
use Illuminate\Support\Facades\File;
use App\Jobs\ConvertVideoClip;
use App\Css;
use App\ButtonText;
use App\AdminAccessPermission;

//use Illuminate\Http\Request;

class AdminSettingsController extends Controller
{
    public function index()
    {
        $user = User::where('id', 1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');
        if ($current_date > $duedate) {
            $client = new Client();
            $url = 'https://flicknexs.com/userapi/allplans';
            $params = [
                'userid' => 0,
            ];

            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ',
            ];
            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify' => false,
            ]);

            $responseBody = json_decode($response->getBody());
            $settings = Setting::first();
            $data = [
                'settings' => $settings,
                'responseBody' => $responseBody,
            ];
            return View::make('admin.expired_dashboard', $data);
        }else if(check_storage_exist() == 0){
            $settings = Setting::first();

            $data = array(
                'settings' => $settings,
            );

            return View::make('admin.expired_storage', $data);
        } else {
            //  Delete Existing Image (PC-Image, Mobile-Image, Tablet-Image )
            if (File::exists(base_path('public/uploads/sitemap/sitemap.xml'))) {
                $sitemap = URL::to('public/uploads/sitemap/sitemap.xml');
            }else{
                $sitemap = '';
            }
            $setting = Setting::first();
            $app_settings = AppSetting::first();
            if (!empty($setting->transcoding_resolution)) {
                $resolution = explode(',', $setting->transcoding_resolution);
            } else {
                $resolution = [];
            }
            $script = Script::first();
            $css = Css::pluck('custom_css')->first();
            $button_text = ButtonText::first();
            $TimeZone = TimeZone::get();
            $adminaccesspermission = AdminAccessPermission::first();
            // dd($adminaccesspermission);
            $data = [
                'admin_user' => Auth::user(),
                'app_settings' => $app_settings,
                'script' => $script,
                'TimeZone' => $TimeZone,
                'resolution' => $resolution,
                'settings' => $setting,
                'rtmp_url' => RTMP::all(),
                'captchas' => Captcha::first(),
                'sitemap' => $sitemap,
                'css'     => $css,
                'button_text'  => $button_text,
                'adminaccesspermission'  => $adminaccesspermission,
            ];

            return \View::make('admin.settings.index', $data);
        }
    }

    public function save_settings(Request $request)
    {

        $input = $request->all();

        $video_clip = (isset($input['video_clip'])) ? $input['video_clip'] : '';

        // transcoding_resolution
        if (!empty($request['transcoding_resolution'])) {
            $transcoding_resolution = implode(',', $request['transcoding_resolution']);
        } else {
            $transcoding_resolution = null;
        }

        if (!empty($request['instagram_page_id'])) {
            $instagram_page_id = $request['instagram_page_id'];
        } else {
            $instagram_page_id = null;
        }
        if (!empty($request['linkedin_page_id'])) {
            $linkedin_page_id = $request['linkedin_page_id'];
        } else {
            $linkedin_page_id = null;
        }
        if (!empty($request['whatsapp_page_id'])) {
            $whatsapp_page_id = $request['whatsapp_page_id'];
        } else {
            $whatsapp_page_id = null;
        }
        if (!empty($request['skype_page_id'])) {
            $skype_page_id = $request['skype_page_id'];
        } else {
            $skype_page_id = null;
        }

        $email_page_id = !empty($request['email_page_id']) ? $request['email_page_id'] : null ;

        if (!empty($request['series_season'])) {
            $series_season = $request['series_season'];
        } else {
            $series_season = 0;
        }
        if (!empty($request['payout_method'])) {
            $payout_method = $request['payout_method'];
        } else {
            $payout_method = 0;
        }

        if (!empty($request['transcoding_access'])) {
            $transcoding_access = $request['transcoding_access'];
        } else {
            $transcoding_access = 0;
        }

        if (!empty($request['activation_email'])) {
            $activation_email = $request['activation_email'];
        } else {
            $activation_email = 0;
        }

        if (!empty($request['ios_product_id'])) {
            $ios_product_id = $request['ios_product_id'];
        } else {
            $ios_product_id = null;
        }

        if (!empty($request['ios_plan_price'])) {
            $ios_plan_price = $request['ios_plan_price'];
        } else {
            $ios_plan_price = null;
        }

        // dd($activation_email);
        $settings = Setting::find(1);
        $settings->demo_mode = $request['demo_mode'];
        $settings->default_time_zone = $request['time_zone'];
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
        $settings->activation_email = $activation_email;
        $settings->featured_pre_ad = $request['featured_pre_ad'];
        $settings->featured_mid_ad = $request['featured_mid_ad'];
        $settings->featured_post_ad = $request['featured_post_ad'];
        $settings->cpc_advertiser = $request['cpc_advertiser'];
        $settings->cpc_admin = $request['cpc_admin'];
        $settings->cpv_advertiser = $request['cpv_advertiser'];
        $settings->cpv_admin = $request['cpv_admin'];
        $settings->premium_upgrade = $request['premium_upgrade'];
        $settings->access_free = $request['access_free'];
        $settings->enable_landing_page = $request['enable_landing_page'];

        $settings->facebook_page_id = $request['facebook_page_id'];
        $settings->tiktok_page_id = $request['tiktok_page_id'];
        $settings->google_page_id = $request['google_page_id'];
        $settings->twitter_page_id = $request['twitter_page_id'];
        $settings->instagram_page_id = $instagram_page_id;
        $settings->linkedin_page_id = $linkedin_page_id;
        $settings->whatsapp_page_id = $whatsapp_page_id;
        $settings->email_page_id    = $email_page_id;

        $settings->series_season = $series_season;
        $settings->transcoding_access = $transcoding_access;
        $settings->payout_method = $payout_method;
        $settings->transcoding_resolution = $transcoding_resolution;
        $settings->skype_page_id = $skype_page_id;
        $settings->youtube_page_id = $request['youtube_page_id'];
        $settings->google_tracking_id = $request['google_tracking_id'];
        $settings->google_analytics_link = $request['google_analytics_link'];
        $settings->signature = $request['signature'];
        $settings->login_text = $request['login_text'];
        $settings->login_text = $request['login_text'];
        $settings->coupon_status = $request['coupon_status'];
        $settings->new_subscriber_coupon = $request['new_subscriber_coupon'];
        $settings->coupon_code = $request['coupon_code'];
        $settings->earn_amount = $request['earn_amount'];
        $settings->system_email = $request['system_email'];
        $settings->discount_percentage = $request['discount_percentage'];
        $settings->logo_width = $request['logo_width'];
        $settings->logo_height = $request['logo_height'];
        $settings->ios_plan_price = $ios_plan_price;
        $settings->ios_product_id = $ios_product_id;
        $settings->notification_key = $request['notification_key'];
        $settings->expiry_time_started = $request['expiry_time_started'];
        $settings->expiry_day_notstarted = $request['expiry_day_notstarted'];
        $settings->expiry_hours_notstarted = $request['expiry_hours_notstarted'];
        $settings->expiry_min_notstarted = $request['expiry_min_notstarted'];

        $settings->show_description = $request['show_description'];
        $settings->show_Links_and_details = $request['show_Links_and_details'];
        $settings->show_genre = $request['show_genre'];
        $settings->show_languages = $request['show_languages'];
        $settings->show_recommended_videos = $request['show_recommended_videos'];
        $settings->show_artist = $request['show_artist'];
        $settings->show_subtitle = $request['show_subtitle'];
        $settings->show_views = $request['show_views'];
        
        $settings->homepage_views_all_button_status = $request['homepage_views_all_button_status'];

        $settings->search_title_status  = $request['search_title_status'];
        $settings->search_category_status = $request['search_category_status'];
        $settings->search_tags_status = $request['search_tags_status'];
        $settings->search_description_status = $request['search_description_status'];
        $settings->search_details_status = $request['search_details_status'];

        $settings->ppv_status = $request['ppv_status'];
        $settings->system_address = $request['system_address'];
        $settings->system_phone_number = $request['system_phone_number'];
        $settings->default_ads_status = !empty($request['default_ads_status']) ? 1 : 0 ;
        $settings->ads_on_videos = !empty($request['ads_on_videos']) ? 1 : 0 ;
        $settings->ads_variable_status = !empty($request['ads_variable_status']) ? 1 : 0 ;
        $settings->ads_play_unlimited_period = !empty($request['ads_play_unlimited_period']) ? 1 : 0 ;
        $settings->video = $request->input('video');
        $settings->live = $request->input('live');
        $settings->series = $request->input('series');
        $settings->ads_payment_page_status = $request->input('ads_payment_page_status');

        $path = storage_path('app/public/');

        if($video_clip != '') {
            
            if (File::exists(base_path('storage/app/public/' . $settings->video_clip))) {
                File::delete(base_path('storage/app/public/' . $settings->video_clip));
            }

            //upload new file
            $randval = Str::random(16);
            $file = $video_clip;
            $video_clip_vid = $randval . '.' . $request->file('video_clip')->extension();
            $video_clip_name_with_ext = str_replace(" ", "-", $video_clip_vid); // Replace spaces with dashes and keep extension
            $file->move($path, $video_clip_name_with_ext);
            $video_clip_name_without_ext = pathinfo($video_clip_name_with_ext, PATHINFO_FILENAME);
            $settings->video_clip = $video_clip_name_without_ext; 
            
        } else {
            $settings->video_clip = $settings->video_clip;
        }
        $path = public_path() . '/uploads/settings/';
        $logo = $request['logo'];
        $favicon = $request['favicon'];
        $login_content = $request['login_content'];

        $notification_icon = $request['notification_icon'];
        $watermark = $request['watermark'];

        if ($logo != '') {
            //code for remove old file
            if ($logo != '' && $logo != null) {
                $file_old = $path . $logo;
                if (file_exists($file_old)) {
                    unlink($file_old);
                }
            }
            //upload new file
            $file = $logo;
            $file->move($path, $file->getClientOriginalName());

            $logo_path = public_path('uploads/settings/' . $file->getClientOriginalName());

            Image::make($logo_path)
                ->resize(logo_width(), logo_height())
                ->save(public_path('uploads/settings/' . $file->getClientOriginalName()));

            $settings->logo = $file->getClientOriginalName();
        }
        if ($watermark != '') {
            //code for remove old file
            if ($watermark != '' && $watermark != null) {
                $file_old = $path . $watermark;
                if (file_exists($file_old)) {
                    unlink($file_old);
                }
            }
            //upload new file
            $file = $watermark;
            $settings->watermark = $file->getClientOriginalName();
            $file->move($path, $settings->watermark);
        }
        $settings->watermark_right = $request['watermark_right'];
        $settings->watermark_top = $request['watermark_top'];
        if (!empty($settings->watermark_right)) {
            $settings->watermark_right = $request['watermark_right'];
        }
        if (!empty($settings->watermark_top)) {
            $settings->watermark_top = $request['watermark_top'];
        }
        if (!empty($settings->watermark_bottom)) {
            $settings->watermark_bottom = $request['watermark_bottom'];
        }
        if (!empty($settings->watermark_opacity)) {
            $settings->watermark_opacity = $request['watermark_opacity'];
        }

        if (!empty($settings->watermar_link)) {
            $settings->watermar_link = $request['watermar_link'];
        }

        if (empty($settings->notification_key)) {
            $settings->notification_key = '';
        }

        if ($login_content != '') {
            //code for remove old file
            if ($login_content != '' && $login_content != null) {
                $login_content_old = $path . $login_content;
                if (file_exists($login_content_old)) {
                    unlink($file_old);
                }
            }
            //upload new file
            $login_content_file = $login_content;
            $settings->login_content = $login_content_file->getClientOriginalName();
            $login_content_file->move($path, $settings->login_content);
        }

        if ($favicon != '') {
            //code for remove old file
            if ($favicon != '' && $favicon != null) {
                $old_favicon = $path . $favicon;
                if (file_exists($old_favicon)) {
                    unlink($old_favicon);
                }
            }
            //upload new file
            $favicon_file = $favicon;
            $settings->favicon = $favicon_file->getClientOriginalName();
            $favicon_file->move($path, $settings->favicon);
        }

        if ($notification_icon != '') {
            //code for remove old file
            if ($notification_icon != '' && $notification_icon != null) {
                $old_favicon = $path . $notification_icon;
                if (file_exists($old_favicon)) {
                    unlink($old_favicon);
                }
            }
            //upload new file
            $favicon_file = $notification_icon;
            $settings->notification_icon = $favicon_file->getClientOriginalName();
            $favicon_file->move($path, $settings->notification_icon);
        }

        if ($request->hasFile('email_image')) {

            $file = $request->email_image;

            if (File::exists(base_path('public/uploads/settings/' . $settings->email_image))) {
                File::delete(base_path('public/uploads/settings/' . $settings->email_image));
            }

            if (compress_image_enable() == 1) {
                $filename = 'Email-image-' . time() . '.' . compress_image_format();
                Image::make($file)->save(base_path() . '/public/uploads/settings/' . $filename, compress_image_resolution());
            } else {
                $filename = 'Email-image-' . time() . '.' . $file->getClientOriginalExtension();
                Image::make($file)->save(base_path() . '/public/uploads/settings/' . $filename);
            }

            $settings->email_image = $filename;
        }

        if (empty($settings->ppv_status)) {
            $settings->ppv_status = 0;
        }

        if (empty($settings->demo_mode)) {
            $settings->demo_mode = 0;
        }

        if (empty($settings->enable_https)) {
            $settings->enable_https = 0;
        }

        if (empty($settings->new_subscriber_coupon)) {
            $settings->new_subscriber_coupon = 0;
        }

        if (empty($settings->free_registration)) {
            $settings->free_registration = 0;
        }

        if (empty($settings->videos_per_page)) {
            $settings->videos_per_page = 0;
        }

        if (empty($settings->ppv_price)) {
            $settings->ppv_price = 0;
        }
        if (empty($settings->coupon_code)) {
            $settings->coupon_code = 0;
        }

        if (empty($settings->discount_percentage)) {
            $settings->discount_percentage = 0;
        }

        if (empty($settings->notification_icon)) {
            $settings->notification_icon = '';
        }


        //		if(empty($activation_email) || $settings->activation_email = 0){
        //			$settings->activation_email= 0;
        //		} else {
        //            $settings->activation_email= $request->get('activation_email');
        //        }

        // $settings->activation_email= $request->get('activation_email');
        $settings->system_email = $request->get('system_email');

        if (empty($settings->premium_upgrade)) {
            $settings->premium_upgrade = 0;
        }

        if (empty($settings->youtube_page_id)) {
            $settings->youtube_page_id = 0;
        }
        if (empty($settings->facebook_page_id)) {
            $settings->facebook_page_id = 0;
        }
        if (empty($settings->access_free)) {
            $settings->access_free = 0;
        }

        if (empty($settings->enable_landing_page)) {
            $settings->enable_landing_page = 0;
        }

        if ($request->hasFile('default_video_image')) {

            $default_image_file = $request->default_video_image;

            if (File::exists(base_path('public/uploads/images/' . $settings->default_video_image))) {
                File::delete(base_path('public/uploads/images/' . $settings->default_video_image));
            }

            if (compress_image_enable() == 1) {
                $default_image_filename = 'default_image.' . compress_image_format();
                Image::make($default_image_file)->save(base_path() . '/public/uploads/images/' . $default_image_filename, compress_image_resolution());
            } else {
                $default_image_filename = 'default_image.' . $default_image_file->getClientOriginalExtension();
                Image::make($default_image_file)->save(base_path() . '/public/uploads/images/' . $default_image_filename);
            }

            $settings->default_video_image = $default_image_filename;
        }

        if ($request->hasFile('default_horizontal_image')) {

            $default_horizontal_image = $request->default_horizontal_image;

            if (File::exists(base_path('public/uploads/images/' . $settings->default_horizontal_image))) {
                File::delete(base_path('public/uploads/images/' . $settings->default_horizontal_image));
            }

            if (compress_image_enable() == 1) {

                $default_horizontal_image_filename = 'default_horizontal_image.' . compress_image_format();
                Image::make($default_horizontal_image)->save(base_path() . '/public/uploads/images/' . $default_horizontal_image_filename, compress_image_resolution());
            } 
            else {
                $default_horizontal_image_filename = 'default_horizontal_image.' . $default_horizontal_image->getClientOriginalExtension();
                Image::make($default_horizontal_image)->save(base_path() . '/public/uploads/images/' . $default_horizontal_image_filename);
            }

            $settings->default_horizontal_image = $default_horizontal_image_filename;

        }
        
        $settings->default_ads_url = $request['default_ads_url'];
        $settings->video_clip_enable = !empty($request->video_clip_enable) ?  "1" : "0" ;
        $settings->enable_ppv_rent = !empty($request->enable_ppv_rent) ?  "1" : "0" ;
        $settings->enable_ppv_rent_live = !empty($request->enable_ppv_rent_live) ?  "1" : "0" ;
        $settings->enable_ppv_rent_series = !empty($request->enable_ppv_rent_series) ?  "1" : "0" ;
        $settings->series_networks_status = !empty($request->series_networks_status) ?  "1" : "0" ;
        $settings->videos_expiry_status = !empty($request->videos_expiry_status) ?  "1" : "0" ;
        $settings->epg_status           = !empty($request->epg_status) ?  "1" : "0" ;
        $settings->slider_trailer           = !empty($request->slider_trailer) ?  "1" : "0" ;

        
        // expiry for video
        $settings->started_video_expiry_days  =  $request['started_video_expiry_days'];
        $settings->started_video_expiry_hours =  $request['started_video_expiry_hours'];
        $settings->started_video_expiry_mints =  $request['started_video_expiry_mints'];
        $settings->before_video_expiry_days =    $request['before_video_expiry_days'];
        $settings->before_video_expiry_hours =   $request['before_video_expiry_hours'];
        $settings->before_video_expiry_mints =   $request['before_video_expiry_mints'];
        // expiry for live
        $settings->started_live_expiry_days  =  $request['started_live_expiry_days'];
        $settings->started_live_expiry_hours =  $request['started_live_expiry_hours'];
        $settings->started_live_expiry_mints =  $request['started_live_expiry_mints'];
        $settings->before_live_expiry_days =    $request['before_live_expiry_days'];
        $settings->before_live_expiry_hours =   $request['before_live_expiry_hours'];
        $settings->before_live_expiry_mints =   $request['before_live_expiry_mints'];
        // expiry for season
        $settings->started_season_expiry_days  =  $request['started_season_expiry_days'];
        $settings->started_season_expiry_hours =  $request['started_season_expiry_hours'];
        $settings->started_season_expiry_mints =  $request['started_season_expiry_mints'];
        $settings->before_season_expiry_days =    $request['before_season_expiry_days'];
        $settings->before_season_expiry_hours =   $request['before_season_expiry_hours'];
        $settings->before_season_expiry_mints =   $request['before_season_expiry_mints'];

        $settings->save();

        $button_text = ButtonText::first();

        if (!$button_text) {
            // If no record exists, create a new instance
            $button_text = new ButtonText();
        }

        $button_text->play_text           =  $request['play_text'];
        $button_text->subscribe_text      =  $request['subscribe_text'];
        $button_text->purchase_text       =  $request['purchase_text'];
        $button_text->registered_text     =  $request['registered_text'];
        $button_text->country_avail_text  =  $request['country_avail_text'];
        $button_text->video_visible_text  =  $request['video_visible_text'];
        $button_text->live_visible_text   =  $request['live_visible_text'];
        $button_text->series_visible_text =  $request['series_visible_text'];
        $button_text->play_btn_live       =  $request['play_btn_live'];

        $button_text->save();
        

        $storepath  = URL::to('storage/app/public/');

        if($settings->video_clip_enable == 1 && $video_clip != ''){
            ConvertVideoClip::dispatch($settings,$storepath,$video_clip_name_with_ext,$video_clip_name_without_ext);
        }

        return Redirect::to('admin/settings')->with(['message' => 'Successfully Updated Site Settings!', 'note_type' => 'success']);
    }

    public function playerui_index()
    {
        $user = User::where('id', 1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');

        if ($current_date > $duedate) {
            $client = new Client();
            $url = 'https://flicknexs.com/userapi/allplans';
            $params = [
                'userid' => 0,
            ];

            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ',
            ];
            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify' => false,
            ]);

            $responseBody = json_decode($response->getBody());
            $settings = Setting::first();
            $data = [
                'settings' => $settings,
                'responseBody' => $responseBody,
            ];
            return View::make('admin.expired_dashboard', $data);
        } else if(check_storage_exist() == 0){
            $settings = Setting::first();

            $data = array(
                'settings' => $settings,
            );

            return View::make('admin.expired_storage', $data);
        }
        else {
            $playerui = Playerui::first();

            $data = [
                'admin_user' => Auth::user(),
                'playerui' => $playerui,
            ];

            return \View::make('admin.players.index', $data);
        }
    }
    public function playerui_settings()
    {
        $playerui_settings = Playerui::first();

        return view('videolayout.header', compact('playerui_settings'));
    }
    public function playerui_settings_footer()
    {
        $playerui_settings = Playerui::first();

        return view('videolayout.footer', compact('playerui_settings'));
    }

    public function storeplayerui(Request $request)
    {
        $input = $request->all();

        $playerui = Playerui::find(1);
        $watermark_right = $request['watermark_right'];

        if ($playerui->show_logo == 0) {
            $playerui->show_logo = 0;
        } else {
            $playerui->show_logo = 1;
        }
        if ($playerui->embed_player == 0) {
            $playerui->embed_player = 0;
        } else {
            $playerui->embed_player = 1;
        }
        if ($playerui->watermark == 0) {
            $playerui->watermark = 0;
        } else {
            $playerui->watermark = 1;
        }
        if ($playerui->thumbnail == 0) {
            $playerui->thumbnail = 0;
        } else {
            $playerui->thumbnail = 1;
        }

        if ($playerui->skip_intro == 0) {
            $playerui->skip_intro = 0;
        } else {
            $playerui->skip_intro = 1;
        }

        if ($playerui->speed_control == 0) {
            $playerui->speed_control = 0;
        } else {
            $playerui->speed_control = 1;
        }

        if ($playerui->advance_player == 0) {
            $playerui->advance_player = 0;
        } else {
            $playerui->advance_player = 1;
        }

        if ($playerui->video_card == 0) {
            $playerui->video_card = 0;
        } else {
            $playerui->video_card = 1;
        }

        if ($playerui->subtitle == 0) {
            $playerui->subtitle = 0;
        } else {
            $playerui->subtitle = 1;
        }

        if ($playerui->subtitle_preference == 0) {
            $playerui->subtitle_preference = 0;
        } else {
            $playerui->subtitle_preference = 1;
        }
        $playerui->show_logo = $request['show_logo'];
        if (empty($playerui->show_logo)) {
            $playerui->show_logo = 0;
        } else {
            $playerui->show_logo = 1;
        }

        $playerui->skip_intro = $request['skip_intro'];
        if (empty($playerui->skip_intro)) {
            $playerui->skip_intro = 0;
        } else {
            $playerui->skip_intro = 1;
        }

        $playerui->embed_player = $request['embed_player'];
        if (empty($playerui->embed_player)) {
            $playerui->embed_player = 0;
        } else {
            $playerui->embed_player = 1;
        }

        $playerui->watermark = $request['watermark'];
        if (empty($playerui->watermark)) {
            $playerui->watermark = 0;
        } else {
            $playerui->watermark = 1;
        }

        $playerui->thumbnail = $request['thumbnail'];
        if (empty($playerui->thumbnail)) {
            $playerui->thumbnail = 0;
        } else {
            $playerui->thumbnail = 1;
        }

        $playerui->advance_player = $request['advance_player'];
        if (empty($playerui->advance_player)) {
            $playerui->advance_player = 0;
        } else {
            $playerui->advance_player = 1;
        }

        $playerui->speed_control = $request['speed_control'];
        if (empty($playerui->speed_control)) {
            $playerui->speed_control = 0;
        } else {
            $playerui->speed_control = 1;
        }

        $playerui->video_card = $request['video_card'];
        if (empty($playerui->video_card)) {
            $playerui->video_card = 0;
        } else {
            $playerui->video_card = 1;
        }

        $playerui->subtitle = $request['subtitle'];
        if (empty($playerui->subtitle)) {
            $playerui->subtitle = 0;
        } else {
            $playerui->subtitle = 1;
        }

        $playerui->subtitle_preference = $request['subtitle_preference'];
        if (empty($playerui->subtitle_preference)) {
            $playerui->subtitle_preference = 0;
        } else {
            $playerui->subtitle_preference = 1;
        }

        $playerui->font = $request['font'];
        $playerui->size = $request['size'];
        $playerui->font_color = $request['font_color'];
        $playerui->background_color = $request['background_color'];
        $playerui->opacity = $request['opacity'];

        //Watermark Settings
        $playerui->watermark_right = $request['watermark_right'];
        $playerui->watermark_top = $request['watermark_top'];
        $playerui->watermark_bottom = $request['watermark_bottom'];
        $playerui->watermark_left = $request['watermark_left'];
        $playerui->watermark_opacity = $request['watermark_opacity'];
        $playerui->watermar_link = $request['watermar_link'];
        $playerui->watermar_width = $request['watermar_width'];
        $playerui->video_watermark_enable = $request['video_watermark_enable'];
        $playerui->ads_marker_status = $request['ads_marker_status'];

        // dd($request['video_watermark_enable']);
        $logopath = URL::to('/public/uploads/settings/');
        $path = public_path() . '/uploads/settings/';
        $watermark = $request['watermark_logo'];
        if ($watermark != '') {
            //code for remove old file
            if ($watermark != '' && $watermark != null) {
                $file_old = $path . $watermark;
                if (file_exists($file_old)) {
                    unlink($file_old);
                }
            }
            //upload new file
            $file = $watermark;
            $playerui->watermark_logo = $logopath . '/' . $file->getClientOriginalName();
            $playerui->video_watermark = $file->getClientOriginalName();
            $file->move($path, $playerui->watermark_logo);
        }
        $playerui->save();

        return Redirect::to('admin/players')->with(['message' => 'Successfully Updated Player Setting UI!', 'note_type' => 'success']);
    }

    public function playerui_settings_episode()
    {
        $playerui_settings = Playerui::first();

        return view('videolayout.episode_header', compact('playerui_settings'));
    }
    public function Store_InApp(Request $request)
    {
        $input = $request->all();
        $settings = Setting::find(1);
        $settings->inapp_enable = $request['inapp_enable'];
        $settings->save();

        return 'added';
    }
    public function script_settings(Request $request)
    {
        $input = $request->all();

        if (!empty($input)) {
           
            $script = Script::first();
            if (!empty($script)) {
                $script->header_script = $input['header_script'];
                $script->footer_script = $input['footer_script'];
                $script->user_id = Auth::User()->id;
                $script->save();
            } else {
                $script = new Script();
                $script->header_script = $input['header_script'];
                $script->footer_script = $input['footer_script'];
                $script->user_id = Auth::User()->id;
                $script->save();
            }
        } else {
            return Redirect::to('admin/settings')->with(['message' => 'Please Give Script CDN!', 'note_type' => 'success']);
        }
        return Redirect::to('admin/settings')->with(['message' => 'Successfully Updated Site Settings!', 'note_type' => 'success']);
    }

    public function customCssSettings(Request $request)
    {
        $validatedData = $request->validate([
            'custom_css' => 'nullable|string',
        ]);

        $css = Css::firstOrCreate([]);

        $css->custom_css = $validatedData['custom_css'];
        $css->save();

        return redirect()->back()->with([
            'success' => 'Custom CSS settings updated successfully.',
            'css' => $css
        ]);
    }


    public function ThumbnailSetting(Request $request)
    {
        $user = User::where('id', 1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');
        if ($current_date > $duedate) {
            $client = new Client();
            $url = 'https://flicknexs.com/userapi/allplans';
            $params = [
                'userid' => 0,
            ];

            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ',
            ];
            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify' => false,
            ]);

            $responseBody = json_decode($response->getBody());
            $settings = Setting::first();
            $data = [
                'settings' => $settings,
                'responseBody' => $responseBody,
            ];
            return View::make('admin.expired_dashboard', $data);
        }else if(check_storage_exist() == 0){
            $settings = Setting::first();

            $data = array(
                'settings' => $settings,
            );

            return View::make('admin.expired_storage', $data);
        } else {
            $thumbnail_setting = ThumbnailSetting::first();

            return view('admin.thumbnail.index', compact('thumbnail_setting', $thumbnail_setting));
        }
    }

    public function ThumbnailSetting_Store(Request $request)
    {
        $Thumbnail = ThumbnailSetting::first();

        if (!empty($request->play_button)) {
            $files = $request->play_button;
            $format = $files->getClientOriginalExtension();
            $filename = 'default_play_buttons.svg';
            $file_Exist = base_path('assets/img/default_play_buttons.svg');

            if (file_exists($file_Exist)) {
                unlink(base_path('assets/img/default_play_buttons.svg'));
            }

            $request->play_button->move(base_path('assets/img'), $filename);
            $Thumbnail->play_button = $filename;
        }

        $Thumbnail->title = $request->has('title') ? 1 : 0 ?? 0;
        $Thumbnail->age = $request->has('age') ? 1 : 0 ?? 0;
        $Thumbnail->rating = $request->has('rating') ? 1 : 0 ?? 0;
        $Thumbnail->published_year = $request->has('published_year') ? 1 : 0 ?? 0;
        $Thumbnail->published_on = $request->has('published_on') ? 1 : 0 ?? 0;
        $Thumbnail->duration = $request->has('duration') ? 1 : 0 ?? 0;
        $Thumbnail->category = $request->has('category') ? 1 : 0 ?? 0;
        $Thumbnail->featured = $request->has('featured') ? 1 : 0 ?? 0;
        $Thumbnail->free_or_cost_label = $request->has('free_or_cost_label') ? 1 : 0 ?? 0;
        $Thumbnail->reels_videos = $request->has('reels_videos') ? 1 : 0 ?? 0;
        $Thumbnail->trailer = $request->has('trailer') ? 1 : 0 ?? 0;
        $Thumbnail->enable_description = $request->has('enable_description') ? 1 : 0 ?? 0;
        $Thumbnail->save();

        return redirect()->route('ThumbnailSetting');
    }

    public function footer_link(Request $request)
    {
        $user = User::where('id', 1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');

        if ($current_date > $duedate) {
            $client = new Client();
            $url = 'https://flicknexs.com/userapi/allplans';
            $params = [
                'userid' => 0,
            ];

            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ',
            ];

            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify' => false,
            ]);

            $responseBody = json_decode($response->getBody());
            $settings = Setting::first();

            $data = [
                'settings' => $settings,
                'responseBody' => $responseBody,
            ];
            return View::make('admin.expired_dashboard', $data);
        } else if(check_storage_exist() == 0){
            $settings = Setting::first();

            $data = array(
                'settings' => $settings,
            );

            return View::make('admin.expired_storage', $data);
        }
        else {
            $FooterLink = FooterLink::orderBy('order')->get();
            return view('admin.footer.index', compact('FooterLink', $FooterLink));
        }
    }

    public function footer_link_store(Request $request)
    {
        $FooterLink = FooterLink::create([
            'name' => $request->footer_name,
            'link' => $request->footer_link,
            'column_position' => $request->column_position,
        ]);

        // dd( $FooterLink);

        $FooterLink->order = $FooterLink->id;
        $FooterLink->url_type = $request->url_type ?? 'base_url';
        $FooterLink->save();

        return redirect()->route('footer_link');
    }

    public function footer_order_update(Request $request)
    {
        $footer_order = FooterLink::all();

        foreach ($footer_order as $post) {
            foreach ($request->order as $order) {
                if ($order['id'] == $post->id) {
                    $post->update(['order' => $order['position']]);
                }
            }
        }
        return response('Update Successfully.', 200);
    }

    public function footer_edit($id)
    {
        $footer = FooterLink::where('id', $id)->first();
        return view('admin.footer.edit', compact('footer', $footer));
    }

    public function footer_update(Request $request)
    {
        $footer_menu = FooterLink::find($request->id);
        $footer_menu->name = $request->get('footer_name');
        $footer_menu->url_type = $request->get('url_type');
        $footer_menu->link = $request->get('footer_link');
        $footer_menu->column_position = $request->get('column_position');
        $footer_menu->update();

        return redirect()->route('footer_link');
    }

    public function footer_delete($id)
    {
        FooterLink::destroy($id);
        return redirect()->route('footer_link');
    }

    public function LinkingIndex()
    {

        $user = User::where('id', 1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');
        if ($current_date > $duedate) {
            $client = new Client();
            $url = 'https://flicknexs.com/userapi/allplans';
            $params = [
                'userid' => 0,
            ];

            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ',
            ];
            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify' => false,
            ]);

            $responseBody = json_decode($response->getBody());
            $settings = Setting::first();
            $data = [
                'settings' => $settings,
                'responseBody' => $responseBody,
            ];
            return View::make('admin.expired_dashboard', $data);
        } else if(check_storage_exist() == 0){
            $settings = Setting::first();

            $data = array(
                'settings' => $settings,
            );

            return View::make('admin.expired_storage', $data);
        }
        else {
            $setting = Setting::first();
            $deeplinking_setting = LinkingSetting::first();
            $script = Script::first();

            $data = [
                'admin_user' => Auth::user(),
                'deeplinking_setting' => $deeplinking_setting,
                'script' => $script,
            ];

            return \View::make('admin.settings.deeplinking_setting', $data);
        }
    }

    public function LinkingSave(Request $request)
    {
        $data = $request->all;
        $Linking_Setting = LinkingSetting::first();

        if (empty($Linking_Setting)) {

            $LinkingSetting = new LinkingSetting();
            $LinkingSetting->ios_app_store_id = $request->get('ios_app_store_id');
            $LinkingSetting->ios_url = $request->get('ios_url');
            $LinkingSetting->ipad_app_store_id = $request->get('ipad_app_store_id');
            $LinkingSetting->ipad_url = $request->get('ipad_url');
            $LinkingSetting->android_app_store_id = $request->get('android_app_store_id');
            $LinkingSetting->android_url = $request->get('android_url');
            $LinkingSetting->windows_phone_app_store_id = $request->get('windows_phone_app_store_id');
            $LinkingSetting->windows_phone_url = $request->get('windows_phone_url');
            $LinkingSetting->user_id = Auth::user()->id;
            $LinkingSetting->save();
        }
        else {
            LinkingSetting::first()->update([
                'ios_app_store_id' => $request->get('ios_app_store_id'),
                'ios_url' => $request->get('ios_url'),
                'ipad_app_store_id' => $request->get('ipad_app_store_id'),
                'ipad_url' => $request->get('ipad_url'),
                'android_app_store_id' => $request->get('android_app_store_id'),
                'android_url' => $request->get('android_url'),
                'windows_phone_app_store_id' => $request->get('windows_phone_app_store_id'),
                'windows_phone_url' => $request->get('windows_phone_url'),
                'user_id' => Auth::user()->id,
            ]);
        }

        return redirect('admin/linking_settings')->with(['message' => 'Successfully Updated!', 'note_type' => 'success']);
    }

    public function compress_image(Request $request)
    {
        $Compress_image = CompressImage::first();

        return view('admin.settings.compress_image', compact('Compress_image', $Compress_image));
    }

    public function compress_image_store(Request $request)
    {
        $CompressImage = CompressImage::first();

        $inputs = array(
            'compress_resolution_size' => $request->compress_resolution_size,
            'compress_resolution_format' => $request->compress_resolution_format,
            'enable_compress_image' => $request->enable_compress_image == null ? '0' : '1',
            'enable_multiple_compress_image' => $request->enable_multiple_compress_image == null ? '0' : '1',
            'videos' => $request->videos == null ? '0' : '1',
            'live' => $request->live == null ? '0' : '1',
            'tv_image_live_validation' => $request->tv_image_live_validation == null ? '0' : '1',
            'series' => $request->series == null ? '0' : '1',
            'season' => $request->season == null ? '0' : '1',
            'episode' => $request->episode == null ? '0' : '1',
            'audios' => $request->audios == null ? '0' : '1',
            'width_validation_videos' => $request->width_validation_videos,
            'height_validation_videos' => $request->height_validation_videos,
            'width_validation_player_img' => $request->width_validation_player_img,
            'height_validation_player_img' => $request->height_validation_player_img,
            'width_validation_live' => $request->width_validation_live,
            'height_validation_live' => $request->height_validation_live,
            'live_player_img_width' => $request->live_player_img_width,
            'live_player_img_height' => $request->live_player_img_height,
            'width_validation_series' => $request->width_validation_series,
            'height_validation_series' => $request->height_validation_series,
            'series_player_img_width' => $request->series_player_img_width,
            'series_player_img_height' => $request->series_player_img_height,
            'width_validation_season' => $request->width_validation_season,
            'height_validation_season' => $request->height_validation_season,
            'width_validation_episode' => $request->width_validation_episode,
            'height_validation_episode' => $request->height_validation_episode,
            'episode_player_img_width' => $request->episode_player_img_width,
            'episode_player_img_height' => $request->episode_player_img_height,
            'width_validation_audio' => $request->width_validation_audio,
            'height_validation_audio' => $request->height_validation_audio,
            'audio_player_img_width' => $request->audio_player_img_width,
            'audio_player_img_height' => $request->audio_player_img_height,
        );

        if ($CompressImage == null) {
            CompressImage::create($inputs);
        } else {
            $CompressImage->update($inputs);
        }

        return redirect()
            ->route('compress_image')
            ->with(['message' => 'Successfully Updated!', 'note_type' => 'success']);
    }



    public function captcha(Request $request)
    {
        try {
       
        

            $input = array(
                'captcha_site_key' => $request->captcha_site_key,
                'captcha_secret_key' => $request->captcha_secret_key,
                'enable_captcha' => $request->enable_captcha == null ? '0' : '1',
                'enable_captcha_signup' => $request->enable_captcha_signup == null ? '0' : '1',
                'enable_captcha_contactus' => $request->enable_captcha_contactus == null ? '0' : '1',
            );

            $Env_path = realpath('.env');

            $Captcha = Captcha::first();

            if (is_null($Captcha)) {

                Captcha::create($input);

                // Create Recaptcha .env
                $captcha_secret_key = 'NOCAPTCHA_SECRET=' . $request->captcha_secret_key . PHP_EOL;
                $captcha_site_key = 'NOCAPTCHA_SITEKEY=' . $request->captcha_site_key . PHP_EOL;

                $file_open = fopen($Env_path, 'a');
                fwrite($file_open, $captcha_secret_key);
                fwrite($file_open, $captcha_site_key);
            } 
            else {
                Captcha::first()->update($input);

                // Replace the Captcha in .env

                $Replace_data = [
                    'NOCAPTCHA_SECRET' => $request->captcha_secret_key,
                    'NOCAPTCHA_SITEKEY' => $request->captcha_site_key,
                ];

                file_put_contents($Env_path, implode('', 
                array_map(function($Env_path) use ($Replace_data) {
                    return   stristr($Env_path,'NOCAPTCHA_SECRET') ? "NOCAPTCHA_SECRET=".$Replace_data['NOCAPTCHA_SECRET']."\n" : $Env_path;
                }, file($Env_path))
                ));

                file_put_contents($Env_path, implode('', 
                    array_map(function($Env_path) use ($Replace_data) {
                        return   stristr($Env_path,'NOCAPTCHA_SITEKEY') ? "NOCAPTCHA_SITEKEY=".$Replace_data['NOCAPTCHA_SITEKEY']."\n" : $Env_path;
                    }, file($Env_path))
                ));
            }

            return Redirect::to('admin/settings')->with(['message' => 'Successfully Updated Re-captcha Settings!', 'note_type' => 'success']);
        
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    public function comment_section(Request $request)
    {
        try {
            
            $data = array(
                'comment_section' => CommentSection::first() ,
                'webcomments'     => WebComment::where('approved',0 )->get(),
            );

            return view('admin.settings.comment_section', $data);

        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    public function comment_section_update(Request $request)
    {
        $comment_section = CommentSection::first();

        if ($comment_section == null) {
            CommentSection::create([
                'videos' => $request->videos == null ? '0' : '1',
                'livestream' => $request->livestream == null ? '0' : '1',
                'episode' => $request->episode == null ? '0' : '1',
                'audios' => $request->audios == null ? '0' : '1',
            ]);
        } else {
            CommentSection::first()->update([
                'videos' => $request->videos == null ? '0' : '1',
                'livestream' => $request->livestream == null ? '0' : '1',
                'episode' => $request->episode == null ? '0' : '1',
                'audios' => $request->audios == null ? '0' : '1',
            ]);
        }

        return redirect()
            ->route('comment_section')
            ->with(['message' => 'Successfully Updated!', 'note_type' => 'success']);
    }


    public function comment_status_update(Request $request)
    {
        WebComment::find($request->id)->update(['approved' => $request->status ]);

        $status_button = $request->status == 1 ? "<td><span style='color:green'> Approved </span></td>" : "<td> <span style=color:red'> Not Approved </span></td>" ;

        return response()->json(['success' => true , 'id' => 'status-'.$request->id , 'status_button' => $status_button  ]);
    }   

    
    public function footer_menu_active(Request $request)
    {


        try {

            $category = FooterLink::where('id',$request->active)->update([
                'active' => $request->status,
            ]);

            return response()->json(['message'=>"true"]);

        } catch (\Throwable $th) {
            return response()->json(['message'=>"false"]);
        }
    }

}
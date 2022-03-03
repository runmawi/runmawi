<?php

use Illuminate\Database\Seeder;
use App\Setting;
use Carbon\Carbon;
use App\Deploy;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::truncate();

        $website = Deploy::first();

        if($website != null){
            $website_name = $website->username;
            $domain_url   = $website->Domain_name;
        }
        else{
            $website_name = 'Flicknexs';
            $domain_url   = 'http://Flicknexs.com/';
        }
        $setting = [
            [  'website_name' => $website_name, 
               'website_description' => 'Your Shows Online',
                'logo' => 'trail-logo.png' ,
                'login_content' => 'Landban.png',
                'coupon_status' => '1' ,
                'favicon' => 'fl-logo.png',
                'system_email' => 'demos@webnexs.in' ,
                'coupon_code' => '0' ,
                'signature' => '<p><strong>http://'.$domain_url.'/</strong></p>' ,
                'demo_mode' => '0' ,
                'enable_https' => '0' ,
                'theme' => 'default' ,
                'ppv_status' => '1' ,
                'ppv_hours' => '3' ,
                'ppv_price' => '2' ,
                'discount_percentage' => '0' ,
                'new_subscriber_coupon' => '1' ,
                'login_text' => 'WATCH TV SHOWS & MOVIES ANYWHERE, ANYTIME' ,
                'facebook_page_id' => '@Flicknexs' ,
                'google_page_id' => '@Flicknexs' ,
                'twitter_page_id' => null ,
                'instagram_page_id' => null ,
                'linkedin_page_id' => null ,
                'whatsapp_page_id' => null ,
                'skype_page_id' => null ,
                'notification_icon' => '6.png' ,
                'youtube_page_id' => '0' ,
                'google_tracking_id' => 'webnexs' ,
                'google_oauth_key' => 'Elite' ,
                'notification_key' => 'AAAAHmXXpDg:APA91bEBdjXcOG9V8ukY_If7zH9k4OlU4f5A-b...' ,
                'videos_per_page' => '3' ,
                'posts_per_page' => '12' ,
                'free_registration' => '0' ,
                'activation_email' => '1' ,
                'premium_upgrade' => '1' ,
                'access_free' => '0' ,
                'watermark_top' => null ,
                'watermark_bottom' => null ,
                'watermark_opacity' => null ,
                'watermark_left' => null ,
                'watermark' => 'e-logo.png' ,
                'watermar_link' => null ,
                'ads_on_videos' => '1' ,
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
        ];

        Setting::insert($setting);
}
    }

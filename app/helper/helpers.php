<?php
//use Auth;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\URL; 
use App\Services\MicrosoftGraphAuth;
use Microsoft\Graph\Graph;

function changeDateFormate($date,$date_format){
    
    return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format($date_format); 
    
}

function check_file_exist($url){
    $handle = @fopen($url, 'r');
    if(!$handle){
        return false;
    }else{
        return true;
    }
}

function audiofavorite($audio_id)
{
    if(!Auth::guest()){
    if(isset($favorite->id)){ 
        $status = "active";
    } else {
        $status = "";
    }    
    return $status;
    }else{
        $status = "";
    }

    return $status;
}

function albumfavorite($album_id)
{
    if(!Auth::guest()){
    $favorite = App\Favorite::where('user_id', '=', Auth::user()->id)->where('album_id', '=', $album_id)->first();
    if(isset($favorite->id)){ 
        $status = "active";
    } else {
        $status = "";
    }
    return $status;
}else{
    $status = "";
    return $status;
}

}

function radiofavorite($live_id)
{
    if (!Auth::guest()) {
        $favorite = App\Favorite::where('user_id', Auth::user()->id)->where('live_id', $live_id)->first();
        return isset($favorite->id) ? "active" : "";
    }
    return "";
}
   
function productImagePath($image_name)
{
    return public_path('images/products/'.$image_name);
}

function ReferrerCount($id)
{
    $referrer = App\User::where('referrer_id','=',$id)->where('role','=','subscriber')->count();
    return $referrer;
}

function get_audio_artist($audio_id)
{
    $artist_ids = App\Audioartist::select('artist_id')->where('audio_id',$audio_id)->get();
    $artist_name = array();
    if(!empty($artist_ids)){
        foreach ($artist_ids as $key => $artist_id) {
            $artist_name[] = App\Artist::where('id',$artist_id->artist_id)->first()->artist_name;
        }
        $artist_name = implode(',', $artist_name);
    }
    else{
        $artist_name = "Unknown";     
    }
    return $artist_name;
}


function GetAccessToken()
{
    
$ch = curl_init();
$client= "Aclkx_Wa7Ld0cli53FhSdeDt1293Vss8nSH6HcSDQGHIBCBo42XyfhPFF380DjS8N0qXO_JnR6Gza5p2";
$secret= "ENsYUiqBVMhmR0Lbxgt13QpmV5Hud4PXwsCLUZqCgBm_8mJK14nDZUKdbiTxbLmwNxttkv6M3exT5I3A"; 
curl_setopt($ch, CURLOPT_URL, "https://api.paypal.com/v1/oauth2/token");
    /*curl_setopt($ch, CURLOPT_URL, “https://api.paypal.com/v1/oauth2/token”);*/
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, $client.":".$secret);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
    $result = curl_exec($ch);

    if(empty($result))die("Error: No response.");
    else
    {
    $json = json_decode($result); 
    /*print_r($json-&gt;access_token);*/
     // $accessToken=$json;access_token;
        return "Authorization: Bearer ".$json->access_token;
    }

}


function PaypalSubscriptionStatus(){
    
          $sub_id = Auth::user()->paypal_id;
           $url = "https://api.paypal.com/v1/billing/subscriptions/".$sub_id;
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $headers = array(
               "Content-Type: application/json",
               GetAccessToken(),
            );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            //for debug only!
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $resp = curl_exec($curl);
            curl_close($curl);
            $json = json_decode($resp);
            return $json->status;
}




function IsPpvEnabled(){
    
    $settings = App\Setting::first();
    return $settings->ppv_price; 
}

function IsDemoMode(){
    
    $settings = App\Setting::first();
    return $settings->demo_mode; 
}

function getFavicon(){
    
    $settings = App\Setting::first();
    return URL::to('/public/uploads/settings/'.$settings->favicon); 
}

function IsHttpsEnable(){
    
    $settings = App\Setting::first();
    return $settings->enable_https; 
}

function VideoPerPage(){
    
    $settings = App\Setting::first();
    return $settings->videos_per_page; 
}

function FacebookId(){
    
    $settings = App\Setting::first();
    return $settings->facebook_page_id; 
}

function GoogleId(){
    
    $settings = App\Setting::first();
    return $settings->google_page_id; 
    
}

function TwiterId(){
    
    $settings = App\Setting::first();
    return $settings->twitter_page_id; 
    
}

function YoutubeId(){ 
    $settings = App\Setting::first();
    return $settings->youtube_page_id;   
}

function GoogleTrackingId(){ 
    $settings = App\Setting::first();
    return $settings->google_tracking_id;   
}

function InstagramId(){
    $settings = App\Setting::first();
    return $settings->instagram_page_id;   
}

function SkypeId(){
    $settings = App\Setting::first();
    return $settings->skype_page_id;   
}

function linkedinId(){
    $settings = App\Setting::first();
    return $settings->linkedin_page_id;   
}

function WhatsappId(){
    $settings = App\Setting::first();
    return $settings->whatsapp_page_id;   
}

function FreeRegistration(){
    $settings = App\Setting::first();
    return $settings->free_registration;   
}

function CurrentSubPlan($id) {
    
    $active_user_stripe_plan  = App\Subscription::where('user_id','=',$id)->pluck('stripe_plan');
    return $active_user_stripe_plan[0];   
}
function StripePlanName($stripe_Plan) {
    
    $stripe_plan  = App\SubscriptionPlan::where('plan_id','=',$stripe_Plan)->first();
    return $stripe_plan->plans_name;   
}
function SubStartDate($id) {
    
    $start_date = App\Subscription::where('user_id','=',$id)->pluck('created_at');
    return $start_date[0];   
}
function SubEndDate($id) {
    
    $ends_at = App\Subscription::where('user_id','=',$id)->pluck('ends_at');
    return $ends_at[0];   
}

function CurrentSubPlanName($id) {
    
    $active_user_stripe_plan  = App\Subscription::where('user_id','=',$id)->pluck('stripe_plan');
    $current_plans_name  = App\SubscriptionPlan::where('plan_id','=',$active_user_stripe_plan)->first();
    $current_plans_count = App\SubscriptionPlan::where('plan_id','=',$active_user_stripe_plan)->count();
    
    if ( $current_plans_count > 0){
        $result =  $current_plans_name->plans_name;  
    } else {
        $result =  "No Plan you were choosed";  
    }
    
    return $result;
}

function CurrentPaypalPlan($plan_id) {
    
    $current_plans_name  = App\SubscriptionPlan::where('plan_id','=',$plan_id)->pluck('name');
    $current_plans_count = App\SubscriptionPlan::where('plan_id','=',$current_plans_name)->count();
    
    if ( $current_plans_count > 0){
        $result =  $current_plans_name[0];  
    } else {
        $result =  "No Plan you were choosed";  
    }
    
    return $current_plans_name[0];
}

function CouponStatus() {
     $settings = App\Setting::first();
     return $settings->coupon_status;   
}

function NewSubscriptionCoupon() {
     $settings = App\Setting::first();
     return $settings->new_subscriber_coupon;   
}

function NewSubscriptionCouponCode() {
     $settings = App\Setting::first();
     return $settings->coupon_code;   
}

function DiscountPercentage() {
     $settings = App\Setting::first();
     return $settings->discount_percentage;   
}

function PvvPrice() {
     $settings = App\Setting::first();
     return $settings->ppv_price;   
}
function SubscriptionPlan() {
     $settings = App\PaymentSetting::first();
     return $settings->plan_name;   
}
function PaymentSecreteKey() {
         $payment_settings = App\PaymentSetting::first();
         if ( $payment_settings->live_mode == 1 ) {
              $secret_key  = $payment_settings->live_secret_key;
         } else {
              $secret_key  = $payment_settings->test_secret_key;
         }
         return $secret_key;   
}
function PaymentPublishableKey() {
         $payment_settings = App\PaymentSetting::first();
         if ( $payment_settings->live_mode == 1 ) {
              $publishable_key  = $payment_settings->live_publishable_key;
         } else {
              $publishable_key  = $payment_settings->test_publishable_key;
         }
         return $publishable_key;   
}
function GetCouponPurchase($user_id){
    $get_coupon_count = App\CouponPurchase::where('user_id','=',$user_id)->count();
    return $get_coupon_count;
}
function MailSignature()
{
    $settings = App\Setting::first();
    
    $MailSignature = $settings->signature != null ? $settings->signature :  URL::to('/');

    return "Website URL : " .$MailSignature;  
}
function AdminMail()
{
    $settings =  env('MAIL_FROM_ADDRESS') ;
    return $settings;  
}

//theme settings 

function GetDarkText(){
    $settings = App\SiteTheme::first();
    return $settings->dark_text_color;
}

function GetLightText(){
    $settings = App\SiteTheme::first();
     return $settings->light_text_color;

}

function front_End_text_color()
{
    $settings = App\SiteTheme::first();

    $front_End_text_colors = $settings->theme_mode == "light"  ? $settings->light_text_color : $settings->dark_text_color ;

    return $front_End_text_colors  ;
}

function GetDarkBg()
{
     $settings = App\SiteTheme::first();
     return $settings->dark_bg_color;  
}

function GetLightBg()
{
     $settings = App\SiteTheme::first();
     return $settings->light_bg_color;  
}

function GetDarkLogourl()
{
     $settings = App\SiteTheme::first();
     return URL::to('public/uploads/settings/'.$settings->dark_mode_logo);  
}

function GetDarkLogo()
{
     $settings = App\SiteTheme::first();
     return $settings->dark_mode_logo;  
}

function GetLightLogo()
{
     $settings = App\SiteTheme::first();
     return $settings->light_mode_logo;  
}

function front_end_logo()
{
    $theme = App\SiteTheme::first();
    $settings = App\Setting::first();

    $logo = ($theme->theme_mode == "light" && !empty($theme->light_mode_logo)) ? $theme->light_mode_logo : (($theme != "light" && !empty($theme->dark_mode_logo)) ? $theme->dark_mode_logo : $settings->logo);
    
    return URL::to('public/uploads/settings/'. $logo )  ;
}

function GetCategoryVideoStatus()
{
     $settings = App\HomeSetting::first();
     return $settings->category_videos;  
}

function GetCategoryLiveStatus()
{
     $settings = App\HomeSetting::first();
     return $settings->live_category;  
}

function GetLatestVideoStatus()
{
     $settings = App\HomeSetting::first();
     return $settings->latest_videos;  
}
function GetTrendingVideoStatus()
{
     $settings = App\HomeSetting::first();
     return $settings->featured_videos;  
}

function TotalViewcount(){
    $sum_view = App\Video::all()->sum('views');
    
    return  $sum_view; 
}

function TotalVisitorcount(){
    $sum_visitor= App\Visitor::all()->sum('id');
    
    return  $sum_visitor; 
}

function TotalVideocount(){
    $video_count = App\Video::all()->count('id');
    
    return  $video_count; 
}

function TotalSeriescount(){
    $series_count = App\Series::count();
    
    return  $series_count; 
}
function TotalLivestreamcount(){
    $live_count = App\LiveStream::count();
    
    return  $live_count; 
}
function TotalEpisodescount(){
    $episodes_count = App\Episode::count();
    
    return  $episodes_count; 
}

function TotalSubscribercount(){

    $totalsubscribercount = App\Subscription::all()->count('id');
    
    return  $totalsubscribercount; 
}

function TotalNewSubscribercount(){

    $newsubscribercount = App\Subscription::whereDate('created_at', '>=', \Carbon\Carbon::now()->today())->count();
    
    return  $newsubscribercount; 
}

function GetWebsiteName(){
    $setting = App\Setting::first();
    return  $setting->website_name; 
}

function Getwebsitedescription(){
    $setting = App\Setting::first();
    return  $setting->website_description; 
}

function GetAllVideoCategory(){
    $all_category = App\VideoCategory::all();
    return  $all_category; 
}

function send_password_notification($title,$message,$video_name='',$video_img='',$user_id){
    $fcm_postt ="https://fcm.googleapis.com/fcm/send";
    $settings = App\Setting::first();
    $server_key = $settings->notification_key;
    $notification_icon = $settings->notification_icon;
    $users = App\User::where('token', '!=', '')->where('id','=',$user_id)->get();
    $userdata = App\User::where('token', '!=', '')->where('id','=',$user_id)->first();

    if($userdata != null){
        $user = $userdata->token;
        $headers = array('Authorization:key='.$server_key,'Content-Type:application/json');
        $field = array('to'=>$user,'notification'=>array('title'=> $title,'body'=>strip_tags($message),'tag'=> $video_name,'icon'=> $video_img,'link'=> URL::to('/public/uploads/') . '/settings/' . $notification_icon));
        $payload =json_encode($field);
        $curl_session = curl_init();
        curl_setopt($curl_session, CURLOPT_URL, $fcm_postt);
        curl_setopt($curl_session, CURLOPT_POST, true);
        curl_setopt($curl_session, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_session, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_session, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($curl_session, CURLOPT_POSTFIELDS, $payload);
        curl_exec($curl_session);
        curl_close($curl_session);
        DB::table('notifications')->insert(['user_id' => $user_id, 'title' => $title,'message' => $message]);
    }
    return true;
}

function get_ad($ad_id){
    $ads = App\Advertisement::where('id',$ad_id)->pluck('ads_name')->first();
    return  $ads; 
}

function get_advertiser($advertiser_id,$field){
    $ads = App\Advertiser::where('id',$advertiser_id)->first()->$field;
    return  $ads; 
}

function get_revenue($ad_id){
    $revenue_total = App\Adrevenue::where('ad_id',$ad_id)->sum('advertiser_share');
    return  $revenue_total; 
}

function get_cpv($ad_id){
    $get_cpv = App\Adviews::where('ad_id',$ad_id)->sum('advertiser_share');
    return  $get_cpv; 
}

function get_views($ad_id){
    $total_views = App\Adviews::where('ad_id',$ad_id)->sum('views_count');
    return  $total_views; 
}


function get_video($vid){

    $getdata = App\Video::where('id',$vid)->pluck('title')->first();
    return  $getdata; 
}

function get_adurl(){
    // 
}

function button_bg_color()
{
    $button_color = App\SiteTheme::pluck('button_bg_color')->first();

    if($button_color != null){
        $button_bg_color =  $button_color ;
    }else{
        $button_bg_color =  '#006AFF' ;
    }
    return  $button_bg_color ;
}

function Geofencing(){
    $getfeching = App\Geofencing::first();

    return $getfeching;
}

// function current_timezone()
// {
//     $current_location = new \Victorybiz\GeoIPLocation\GeoIPLocation();
//     $current_ip = $current_location->getip();

//     $apiUrl = "http://ip-api.com/php/{$current_ip}";

//     $response = \Http::get($apiUrl);

//     $data = unserialize($response->body());

//     $timezone = $data['status'] == "success" ? $data['timezone'] : null ;

//     return $timezone ;
// }

function current_timezone()
{
    $current_timezone = null;

    $response = Http::withOptions([
        'verify' => false, 
    ])->get('https://get.geojs.io/v1/ip/geo.json');
    
    if ($response->successful()) {
        $current_timezone = $response->json('timezone'); 
    } else {
        $current_timezone = App\Setting::pluck('default_time_zone')->first();
    }

    return $current_timezone['timezone'];
}

function Country_name(){

    try {
        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
        $userIp = $geoip->getip();
        $countryName = \Location::get($userIp)->countryName;

        return $countryName ;

    } catch (\Throwable $th) {
        return 'Unknown' ;
    }
}

function Country_Code(){

    try {
        
        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
        $userIp = $geoip->getip();
        $Country_Code = \Location::get()->countryCode;

        return $Country_Code ;

    } catch (\Throwable $th) {
        return 'Unknown' ;
    }
}

function city_name(){
    
    $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
    $userIp = $geoip->getip();
    $cityName = $geoip->getcity();

    return $cityName;
}

function Region_name(){
    
    $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
    $userIp = $geoip->getip();
    $regionName = $geoip->getregion();

    return $regionName;
}


function Block_videos(){
     // blocked videos
     $block_videos = App\BlockVideo::where('country_id',Country_name())->get();
     if(!$block_videos->isEmpty()){
         foreach($block_videos as $block_video){
         $blockvideos[]=$block_video->video_id;
       }
   }   
   else{
       $blockvideos[]='';
       
   } 

   return $blockvideos;

}

function Block_audios()
{
     // blocked Audio
     $block_Audio = App\BlockAudio::where('country',Country_name())->get();
        
     if(!$block_Audio->isEmpty()){
         foreach($block_Audio as $blocked_Audios){
         $blocked_Audio[]=$blocked_Audios->audio_id;
         }
     } 
     else{
        $blocked_Audio[]='';
     }   

   return $blocked_Audio;

}

 function compress_image_resolution( )
{
   $compress_image_resolution = App\CompressImage::pluck('compress_resolution_size')->first() ? App\CompressImage::pluck('compress_resolution_size')->first() : '400' ;
   return $compress_image_resolution ;
}

 function compress_image_format( )
{
    $compress_image_format = App\CompressImage::pluck('compress_resolution_format')->first() ?  App\CompressImage::pluck('compress_resolution_format')->first() : 'webp' ;
    return $compress_image_format ;

}

 function compress_image_enable( )
{
    $compress_image_enable = App\CompressImage::pluck('enable_compress_image')->first() ? App\CompressImage::pluck('enable_compress_image')->first() : "0";
    return $compress_image_enable ;
}

function logo_height( )
{
    $logo_height = App\Setting::pluck('logo_height')->first() ? App\Setting::pluck('logo_height')->first()  : "80";
    return $logo_height ;
}

function logo_width( )
{
    $logo_width = App\Setting::pluck('logo_width')->first() ? App\Setting::pluck('logo_width')->first() : "80";
    return $logo_width ;
}

function image_validation_videos(){

    $image_validation_videos = App\CompressImage::pluck('videos')->first() ? App\CompressImage::pluck('videos')->first() : "0";
    return $image_validation_videos ;
}

function image_validation_live(){

     $image_validation_live = App\CompressImage::pluck('live')->first() ? App\CompressImage::pluck('live')->first() : "0";
    return $image_validation_live ;
}

function image_validation_series(){

    $image_validation_series = App\CompressImage::pluck('series')->first() ? App\CompressImage::pluck('series')->first() : "0";
    return $image_validation_series ;
}

function image_validation_season(){

    $image_validation_season = App\CompressImage::pluck('season')->first() ? App\CompressImage::pluck('season')->first() : "0";
    return $image_validation_season ;
}

function image_validation_episode(){

    $image_validation_episode = App\CompressImage::pluck('episode')->first() ? App\CompressImage::pluck('episode')->first() : "0";
    return $image_validation_episode ;
}

function image_validation_audio(){

    $image_validation_audio = App\CompressImage::pluck('audios')->first() ? App\CompressImage::pluck('audios')->first() : "0";
    return  $image_validation_audio ;
}

function Email_sent_log($user_id,$email_log,$email_template){

    App\EmaillogsDetail::create([
        'user_id'        =>  $user_id,
        'email_logs'     =>  $email_log,
        'email_status'   =>  "sent" ,
        'email_template' =>  $email_template,
        'color'          =>  "green" ,
    ]);

}

function Email_notsent_log($user_id,$email_log,$email_template){

    App\EmaillogsDetail::create([
        'user_id'        =>  $user_id,
        'email_logs'     =>  $email_log,
        'email_status'   =>  "Not sent" ,
        'email_template' =>  $email_template,
        'color'          =>  "red" ,
    ]);

    return 'Some Error In Sending Mail, Please take support from Admin' ;
    
}

function style_sheet_link()
{
    $settings = App\SiteTheme::pluck('style_sheet_link')->first();

    $style_sheet_link =  $settings  ?  URL::to('/'). '/assets/css/'.$settings : URL::to('/'). '/assets/css/style.css';

    return $style_sheet_link;
}

function typography_link()
{
    $settings = App\SiteTheme::pluck('typography_link')->first();

    $typography_link =  $settings  ?  URL::to('/'). '/assets/css/'.$settings : URL::to('/'). '/assets/css/typography.css';

    return $typography_link;
}

function get_coupon_code(){

    $get_coupon_code = App\Setting::pluck('coupon_status')->first();

    return $get_coupon_code;
}

function get_enable_captcha()
{
    $get_enable_captcha = App\Captcha::pluck('enable_captcha')->first() ?  App\Captcha::pluck('enable_captcha')->first() : "0" ;
    return $get_enable_captcha;
}

function get_enable_captcha_signup()
{
    return $get_enable_captcha_signup = App\Captcha::pluck('enable_captcha_signup')->first() ?  App\Captcha::pluck('enable_captcha_signup')->first() : "0" ;
}

function get_enable_captcha_contactus()
{
    return $get_enable_captcha_contactus = App\Captcha::pluck('enable_captcha_contactus')->first() ?  App\Captcha::pluck('enable_captcha_contactus')->first() : "0" ;
}

function get_image_loader(){

    $get_image_loader = App\SiteTheme::first();
    return $get_image_loader->loader_setting;

    return $get_image_loader;
}

function ppv_expirytime_started()
{
    $ppv_expirytime_started = App\Setting::pluck('expiry_time_started')->first();

    $expirytime_started = $ppv_expirytime_started != null ?  Carbon\Carbon::now()->addHours($ppv_expirytime_started)->toDateTimeString() : Carbon\Carbon::now()->addHours(3)->toDateTimeString();

    return $expirytime_started;

}

function ppv_expirytime_notstarted()
{
    $expiry_day_notstarted   =  App\Setting::pluck('expiry_day_notstarted')->first();
    $expiry_hours_notstarted =  App\Setting::pluck('expiry_hours_notstarted')->first();
    $expiry_min_notstarted   =  App\Setting::pluck('expiry_min_notstarted')->first();

    $newDateTime = Carbon\Carbon::now()->addDays($expiry_day_notstarted)->addHours($expiry_hours_notstarted)->addMinutes($expiry_min_notstarted)->toDateTimeString();

    return $newDateTime;
}

function currency_symbol(){

    $currency = App\CurrencySetting::pluck('symbol')->first();
    return $currency ;
}

function subscription_trails_status(){

    $subscription_trails_status = App\PaymentSetting::where('payment_type','=','Stripe')->pluck('subscription_trail_status')->first();
    return $subscription_trails_status;

}

function subscription_trails_day(){

    $Trail_days = App\PaymentSetting::where('payment_type','=','Stripe')->pluck('subscription_trail_days')->first();
    $subscription_trails_day = Carbon\Carbon::now()->addDays( $Trail_days );
    return $subscription_trails_day ;

}

function plans_ads_enable()
{
    if(Auth::guest() == true ){
        return 1 ;
    }

    if( Auth::user()->role == "registered" ){
        return 1 ;
    }

    if( Auth::user()->role == "admin" ){
        return 0 ;
    }

    $Subscription_ads_status = App\Subscription::Join('subscription_plans','subscription_plans.plan_id','=','subscriptions.stripe_plan')
                    ->where('subscriptions.user_id',Auth::user()->id)
                    ->latest('subscriptions.created_at')
                    ->pluck('ads_status')
                    ->first();

    if( $Subscription_ads_status != null && $Subscription_ads_status == 1 ){
        return $Subscription_ads_status ;
    }
    elseif(  $Subscription_ads_status == null ){
        return 1 ;
    }else{
        return 1 ;
    }

}

function check_Kidmode()
{
    if( !Auth::guest() ){
        $multiuser = Session::get('subuser_id');
            
        $Mode = $multiuser != null ?  App\Multiprofile::where('id', $multiuser)->first() : App\User::where('id', Auth::User()->id)->first();
            
        $check_Kidmode = $Mode['user_type'] != null && $Mode['user_type'] == "Kids" ? 1 : 0 ;

        return $check_Kidmode ;
    }
    else{
        return 0 ;
    }
}

function Mail_Image()
{
    $settings = App\Setting::first();

    $Mail_Image = $settings != null && $settings->email_image != null ? $settings->email_image : $settings->logo ;

    return public_path('uploads/settings/'. $Mail_Image) ;
}

function default_vertical_image()
{
    $default_vertical_image = App\Setting::pluck('default_video_image')->first();

    return  $default_vertical_image ;
} 

function default_horizontal_image()
{
    $default_horizontal_image = App\Setting::pluck('default_horizontal_image')->first();

    return  $default_horizontal_image ;
}

 function default_vertical_image_url()
{
    $Vertical_Default_Image =  App\Setting::latest()->get()->map(function ($item) {
        $item['default_image'] = $item->default_video_image != null ? URL::to('public/uploads/images/'.$item->default_video_image) : URL::to('public/uploads/images/default_vertical_image.png');
        return $item['default_image'];
    })->first();

    return $Vertical_Default_Image ;

}

 function default_horizontal_image_url()
{
     $Horizontal_Default_Image =  App\Setting::latest()->get()->map(function ($item) {
        $item['default_image'] = $item->default_horizontal_image != null ? URL::to('public/uploads/images/'.$item->default_horizontal_image) : URL::to('public/uploads/images/default_horizontal_image.png');
        return $item['default_image'];
    })->first();

    return $Horizontal_Default_Image ;
}

function check_storage_exist(){

    $StorageSetting = App\StorageSetting::first();
    if(!empty($StorageSetting->site_key && $StorageSetting->site_user && $StorageSetting->site_action)){
    $data = array('key' => $StorageSetting->site_key,
    'action' => $StorageSetting->site_action,
    'user'=> $StorageSetting->site_user);
        
        $url = "https://$StorageSetting->site_IPSERVERAPI/v1/accountdetail";
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        $response = curl_exec($ch);
        $storage = json_decode($response);
        // dd($storage->result->account_info->space_usage);
        if (curl_errno($ch)) {
            $space_available = 0 .' '.'TB';
            $space_usage = 0 .' '.'TB';
            $space_disk = 0 .' '.'TB';
            $response =   1 ;

        } else {
            $space_usage =  @$storage->result->account_info->space_usage;
            $space_disk = @$storage->result->account_info->space_disk  ;
            if(@$space_usage > @$space_disk || @$space_usage == @$space_disk ){
                $response =   0 ;
                
            }else{
                $response =   1 ;
            }

        }
        curl_close($ch);

    }else{
        $space_available = 0 .' '.'TB';
        $space_usage = 0 .' '.'TB';
        $space_disk = 0 .' '.'TB';
        $response =   1 ;

    }

    return  $response ;

}


function package_ends(){

        $user =  App\User::where('id',1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');
        if ($current_date > $duedate)
        {
            $response = 0;

        }else{
             $response = 1;
        }
        return $response;
}

function package_ends_allplans(){

    $user =  App\User::where('id',1)->first();
    $duedate = $user->package_ends;
    $current_date = date('Y-m-d');

        $client = new GuzzleHttp\Client();
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

            $settings = App\Setting::first();
            $data = array(
                'settings' => $settings,
                'responseBody' => $responseBody,
        );
       
    return $data;
}

function MyPlaylistfavorite($MyPlaylist_id)
{
    if(!Auth::guest()){
    // $favorite = App\Favorite::where('user_id', '=', Auth::user()->id)->where('playlist_id', '=', $MyPlaylist_id)->first();
    // if(isset($favorite->id)){ 
    //     $status = "active";
    // } else {
    //     $status = "";
    // }
        $status = "";

    return $status;
}else{
    $status = "";
    return $status;
}

}

function tv_image_live_validation_status()
{
    
   $tv_image_live_validation_status = App\CompressImage::pluck('tv_image_live_validation')->first() ? App\CompressImage::pluck('tv_image_live_validation')->first() : '0' ;
   return $tv_image_live_validation_status ;  
}


function CPV_advertiser_share()    // Cost Pre View - advertiser
{
    $CPV_advertiser_share = App\Setting::pluck('cpv_advertiser')->first();
    return  $CPV_advertiser_share;
}

function CPC_advertiser_share()   // Cost Pre Click - advertiser
{
    $CPC_advertiser_share = App\Setting::pluck('cpc_advertiser')->first();
    return  $CPC_advertiser_share;
}

function TotalRevenue(){

    $Total_PPV_Revenue = App\PpvPurchase::sum('total_amount');
    $Total_Subscription_Revenue = App\Subscription::sum('price');
    $Total_Revenue = $Total_PPV_Revenue + $Total_Subscription_Revenue;

    return  $Total_Revenue; 
}


function TotalMonthlyRevenue(){

    $Month_PPV_Revenue = App\PpvPurchase::whereMonth('created_at', Carbon\Carbon::now()->month)->sum('total_amount');
    $Month_Subscription_Revenue = App\Subscription::whereMonth('created_at', Carbon\Carbon::now()->month)->sum('price');
    $Total_Monthly_Revenue = $Month_PPV_Revenue + $Month_Subscription_Revenue;

    return  $Total_Monthly_Revenue; 
}

            function TotalWeeklyRevenue()
            {
                // Get the current week number
                $weekNumber = Carbon\Carbon::now()->weekOfYear;

                // Calculate weekly PPV revenue
                $Week_PPV_Revenue = App\PpvPurchase::whereYear('created_at', Carbon\Carbon::now()->year)
                                                ->where('created_at', '>=', Carbon\Carbon::now()->startOfWeek())
                                                ->where('created_at', '<=', Carbon\Carbon::now()->endOfWeek())
                                                ->sum('total_amount');

                // Calculate weekly Subscription revenue
                $Week_Subscription_Revenue = App\Subscription::whereYear('created_at', Carbon\Carbon::now()->year)
                                                            ->where('created_at', '>=', Carbon\Carbon::now()->startOfWeek())
                                                            ->where('created_at', '<=', Carbon\Carbon::now()->endOfWeek())
                                                            ->sum('price');

                // Total weekly revenue
                $Total_Weekly_Revenue = $Week_PPV_Revenue + $Week_Subscription_Revenue;

                return $Total_Weekly_Revenue;
            }

            function TotalDailyRevenue()
                    {
                        // Get the current day
                        $today = Carbon\Carbon::now()->toDateString();

                        // Calculate daily PPV revenue
                        $Day_PPV_Revenue = App\PpvPurchase::whereDate('created_at', $today)->sum('total_amount');

                        // Calculate daily Subscription revenue
                        $Day_Subscription_Revenue = App\Subscription::whereDate('created_at', $today)->sum('price');

                        // Total daily revenue
                        $Total_Daily_Revenue = $Day_PPV_Revenue + $Day_Subscription_Revenue;

                        return $Total_Daily_Revenue;
                    }


   
function TotalUsers(){

    $TotalUsers = App\User::count();    
    return  $TotalUsers; 
}



function UserCurrentCurrency(){

    $allCurrency = App\CurrencySetting::first();
    $Currency_symbol = App\Currency::where('country',Country_name())->pluck('code')->first();

    $default_Currency = App\Currency::where('country',@$allCurrency->country)->pluck('code')->first();

    try {

        $response = \Http::get("https://api.exchangerate.host/latest?base=".$default_Currency."&symbols=".$Currency_symbol."");
        $responseBody = json_decode($response->getBody());
        $current_rate = $responseBody->rates->$default_Currency;
  
    } catch (\Throwable $th) {
        // throw $th;
        $current_rate = '';
    }
    // echo "<pre>";
    // print_r(  $responseBody   );exit;
    
    $client = new GuzzleHttp\Client();
    $url = "https://api.exchangerate.host/latest";
    $params = [
        'base' => @$Currency_symbol,
        'symbols' => @$allCurrency->symbol,
    ];

    $headers = [
        'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ'
    ];
    $response = $client->request('get', $url, [
        'json' => $params,
        'headers' => $headers,
        'verify'  => false,
    ]);

    $responseBody = json_decode($response->getBody());
    
    return  $responseBody; 

}

function CurrencyConvert(){


    $To_Currency_symbol = App\Currency::where('country',Country_name())->pluck('code')->first();
    $From_Currency_symbol = 'INR'; 
    $to = $To_Currency_symbol;
    $amount = 200;

    $Currency_Converter = AmrShawky\LaravelCurrency\Facade\Currency::convert()
    ->from($From_Currency_symbol)
    ->to($To_Currency_symbol)
    ->amount($amount)
    ->get();  

    return  $Currency_Converter; 
}



function Currency_Convert($amount){


    $To_Currency_symbol = App\Currency::where('country',Country_name())->pluck('code')->first();

    $Currency_symbol = App\Currency::where('country',Country_name())->pluck('symbol')->first();

    $allCurrency = App\CurrencySetting::first();

    $From_Currency_symbol = App\Currency::where('country',@$allCurrency->country)->pluck('code')->first();

    $api_url = "https://open.er-api.com/v6/latest/$From_Currency_symbol";

    // Make a GET request to the API
    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        // Handle cURL error here
        echo "cURL error: " . curl_error($ch);
    } else {
        // Decode the API response into a JSON object
        $exchangeRates = json_decode($response, true);

        // Check if the conversion rates are available
        if (isset($exchangeRates['rates'])) {
            // Replace 'USD' with the currency code you want to convert to
            $targetCurrency = $To_Currency_symbol;

            // Replace 'amount' with the amount you want to convert
            // $amount = 100; // For example, 100 INR

            if (isset($exchangeRates['rates'][$targetCurrency])) {
                $conversionRate = $exchangeRates['rates'][$targetCurrency];
                $convertedAmount = $amount * $conversionRate;

                // echo "Converted amount: " . $convertedAmount . ' ' . $targetCurrency;
            } else {
                // echo "Conversion rate for {$targetCurrency} not available.";
                $convertedAmount = '';
            }
        } else {
            // echo "Exchange rates data not found in the API response.";
            $convertedAmount = '';
        }
    }
    curl_close($ch);


    return  $Currency_symbol.' '.round($convertedAmount,2); 
}



function Current_currency_symbol($From_Currency_symbol,$amount){


    $Current_currency_symbol = App\Currency::where('country',Country_name())->pluck('symbol')->first();

    return  $Current_currency_symbol; 
}

function PPV_CurrencyConvert($amount){



    $To_Currency_symbol = App\Currency::where('country',Country_name())->pluck('code')->first();

    $Currency_symbol = App\Currency::where('country',Country_name())->pluck('symbol')->first();

    $allCurrency = App\CurrencySetting::first();

    $From_Currency_symbol = App\Currency::where('country',@$allCurrency->country)->pluck('code')->first();

    // $Currency_Converter = AmrShawky\LaravelCurrency\Facade\Currency::convert()
    // ->from($From_Currency_symbol)
    // ->to($To_Currency_symbol)
    // ->amount($amount)
    // ->get();  
    $api_url = "https://open.er-api.com/v6/latest/$From_Currency_symbol";

    // Make a GET request to the API
    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        // Handle cURL error here
        echo "cURL error: " . curl_error($ch);
    } else {
        // Decode the API response into a JSON object
        $exchangeRates = json_decode($response, true);

        // Check if the conversion rates are available
        if (isset($exchangeRates['rates'])) {
            // Replace 'USD' with the currency code you want to convert to
            $targetCurrency = $To_Currency_symbol;

            // Replace 'amount' with the amount you want to convert
            // $amount = 100; // For example, 100 INR

            if (isset($exchangeRates['rates'][$targetCurrency])) {
                $conversionRate = $exchangeRates['rates'][$targetCurrency];
                $convertedAmount = $amount * $conversionRate;

                // echo "Converted amount: " . $convertedAmount . ' ' . $targetCurrency;
            } else {
                // echo "Conversion rate for {$targetCurrency} not available.";
                $convertedAmount = '';
            }
        } else {
            // echo "Exchange rates data not found in the API response.";
            $convertedAmount = '';
        }
    }
    curl_close($ch);

    return  $convertedAmount; 
}

function choosen_player()
{
    $choose_player = App\SiteTheme::pluck('choose_player')->first();
    return $choose_player ;
}

function GoogleTranslate_array_values($datas) {
    $translator = new Stichoza\GoogleTranslate\GoogleTranslate();
    $translator->setSource('en'); // Set the source language
    $translator->setTarget('ta'); // Set the target language

    $translatedUsers = [];
    $collection = new \stdClass();

    foreach ($datas as $data) {
        $object = [];

        // Iterate over each user model in the collection
        foreach ($data->getAttributes() as $key => $value) {
    // Check if the value is not null or empty before translation
            if (!empty($value)) {
                $object[$key] = $translator->translate($value);
            } else {
                // Optionally set the property to null if it's empty
                $object[$key] = null;
            }
        }

        $translatedUsers[] = $object;
    }
    $collection = collect($translatedUsers);
    // dd($translatedUsers);

    return $collection;
}


function GoogleTranslate_array_valueaas($datas)
{
    
    
    $users = $datas;

    // Create a GoogleTranslate instance
    $translator = new Stichoza\GoogleTranslate\GoogleTranslate();
    $translator->setSource('en'); // Set the source language
    $translator->setTarget('hi'); // Set the target language
    
    foreach ($users as $key => $user) {
    // Iterate over each user model in the collection
        foreach ($user->getAttributes() as $key => $value) {
    // Check if the value is not null or empty before translation
            if (!empty($value)) {
              $object[$key]   = $translator->translate($value);
            } else {
                // Optionally set the property to null if it's empty
                $object[$key]  = null;
            }
        }
        $translatedUsers[] = $object;
    }

    $collection = collect($translatedUsers);

    // dd($collection);
    

    return $collection ;
}



function GoogleTranslate_object_values($data)
{
    
    
    $data = $data;

    // Create a GoogleTranslate instance
    $translator = new Stichoza\GoogleTranslate\GoogleTranslate();
    $translator->setSource('en'); // Set the source language
    $translator->setTarget('hi'); // Set the target language
    
   $object = new \stdClass();
        
        // Loop through the attributes and translate them
        foreach ($data->getAttributes() as $key => $value) {
            // Check if the value is not null or empty before translation
            if (!empty($value)) {
                $object->$key = $translator->translate($value);
            }else{
                $object->$key = null;

            }
        }
    

    return $object ;
}


function settings_enable_rent(){

    $settings_enable_rent = App\Setting::first()->pluck('enable_ppv_rent')->first();
    return $settings_enable_rent;

}



//theme settings 

function GetAdminDarkText(){
    $settings = App\SiteTheme::first();
    return $settings->admin_dark_text_color;
}

function GetAdminLightText(){
    $settings = App\SiteTheme::first();
     return $settings->admin_light_text_color;

}

function GetAdminDarkBg()
{
     $settings = App\SiteTheme::first();
     return $settings->admin_dark_bg_color;  
}

function GetAdminLightBg()
{
     $settings = App\SiteTheme::first();
     return $settings->admin_light_bg_color;  
}

function Series_Networks_Status()
{
    $Series_Networks_Status = App\Setting::pluck('series_networks_status')->first();
    return  $Series_Networks_Status; 
}

function videos_expiry_date_status()
{
    $videos_expiry_date_status = App\Setting::pluck('videos_expiry_status')->first();
    return  $videos_expiry_date_status; 
}

function EPG_Status()
{
    $EPG_Status = App\Setting::pluck('EPG_Status')->first();
    return  $EPG_Status; 
}

function Enable_Extract_Image()
{
    $enable_extract_image = App\SiteTheme::pluck('enable_extract_image')->first();
    return  $enable_extract_image; 
}

function admin_ads_pre_post_position()
{
    $admin_ads_pre_post_position = App\SiteTheme::pluck('admin_ads_pre_post_position')->first();
    return  $admin_ads_pre_post_position; 
}

function ads_theme_status()
{
    $themeChosen = App\HomeSetting::pluck('theme_choosen')->first();
    $adsThemeStatus = ($themeChosen == "theme4" || $themeChosen == "theme3" || $themeChosen == "default" ) ? 1 : 0;
    
    return $adsThemeStatus;
}

function TimeZoneScheduler($id)
{

    $TimeZone = App\TimeZone::where('id',$id)->pluck('time_zone')->first();

        date_default_timezone_set($TimeZone);
        $now = date("Y-m-d H:i:s", time());
        $current_time = date("H:i:s", time());
        $time = date("A", time());
        $nowTime = date("H:i:s A", time());
        $data = array(
            'now' => $now  ,
            'current_time' => $current_time  ,            
            'time' => $time  ,            
            'nowTime' => $nowTime  ,            
        );
    return  $data; 
        
}

function SchedulerSocureData($socure_type,$socure_id)
{

    if($socure_type == "Video"){
        $socure_data = App\Video::where('id',$socure_id)->first();
        if(!empty($socure_data) && $socure_data->type == ''){
        // https://test.e360tv.com/storage/app/public/OCHg9md4AfzOTQoP.m3u8
            $m3u8_url = URL::to('/storage/app/public/') . '/' . $socure_data->path . '.m3u8';
            // $m3u8_url = 'https://test.e360tv.com/storage/app/public/OCHg9md4AfzOTQoP.m3u8';
            $command = ['ffprobe', '-v', 'error','-show_entries','format=duration','-of','default=noprint_wrappers=1:nokey=1', $m3u8_url, ];
            $process = new Process($command);
            // try {
                // Run the process
                $process->mustRun();
                $duration = trim($process->getOutput());
                $seconds = round($duration);
            // } catch (ProcessFailedException $exception) {
            //     $error = $exception->getMessage();
            // }

            $data = array(
                'duration' => $duration  ,
                'seconds' => $seconds  ,            
                'type' => 'm3u8'  ,            
                'URL' => URL::to('/storage/app/public/') . '/' . $socure_data->path . '.m3u8'  ,
                'socure_data' => $socure_data  ,
            );

        }else if(!empty($socure_data) && $socure_data->type == 'm3u8_url'){
        $m3u8_url = $socure_data->m3u8_url;
            $command = ['ffprobe', '-v', 'error','-show_entries','format=duration','-of','default=noprint_wrappers=1:nokey=1', $m3u8_url, ];
            $process = new Process($command);
            // try {
                // Run the process
                $process->mustRun();
                $duration = trim($process->getOutput());
                $seconds = round($duration);
            // } catch (ProcessFailedException $exception) {
            //     $error = $exception->getMessage();
            // }
            if($duration == 'N/A'){
                $duration = 3600;
                $seconds  = 3600;
            }
            $data = array(
                'duration' => $duration  ,
                'seconds' => $seconds  ,      
                'type' => 'm3u8'  ,            
                'URL' => $socure_data->m3u8_url  ,      
                'socure_data' => $socure_data  ,
            );
        }else if(!empty($socure_data) && $socure_data->type == 'mp4_url'){
        // echo"<pre>"; print_r($socure_data);exit;
        $mp4_url = $socure_data->mp4_url;
            $ffprobe = \FFMpeg\FFProbe::create();
            $Video_duration = $ffprobe->format($mp4_url)->get('duration');
            $duration = explode(".", $Video_duration)[0];
            $seconds = round($duration);
            $data = array(
                'duration' => $duration  ,
                'seconds' => $seconds  ,   
                'type' => 'mp4'  ,            
                'URL' => $socure_data->mp4_url  ,           
                'socure_data' => $socure_data  ,
            );
        }
    }else if($socure_type == "Episode"){ 
        $socure_data = App\Episode::where('id',$socure_id)->first();
        if(!empty($socure_data) && $socure_data->type == 'file' || $socure_data->type == 'upload' ){
            $mp4_url = $socure_data->mp4_url;
            $ffprobe = \FFMpeg\FFProbe::create();
            $Video_duration = $ffprobe->format($mp4_url)->get('duration');
            $duration = explode(".", $Video_duration)[0];
            $seconds = round($duration);
            $data = array(
                'duration' => $duration  ,
                'seconds' => $seconds  ,        
                'type' => 'mp4'  ,            
                'URL' => $socure_data->mp4_url  ,        
                'socure_data' => $socure_data  ,
            );
        }else if(!empty($socure_data) && $socure_data->type == 'm3u8'){
            $m3u8_url = URL::to('/storage/app/public/') . '/' . $socure_data->path . '.m3u8';
            $command = ['ffprobe', '-v', 'error','-show_entries','format=duration','-of','default=noprint_wrappers=1:nokey=1', $m3u8_url, ];
            $process = new Process($command);
            try {
                // Run the process
                $process->mustRun();
                $duration = trim($process->getOutput());
                $seconds = round($duration);
            } catch (ProcessFailedException $exception) {
                $error = $exception->getMessage();
            }
            $data = array(
                'duration' => $duration  ,
                'seconds' => $seconds  ,      
                'type' => 'm3u8'  ,            
                'URL' => URL::to('/storage/app/public/') . '/' . $socure_data->path . '.m3u8'  ,          
                'socure_data' => $socure_data  ,
            );
        }else if(!empty($socure_data) && $socure_data->type == 'bunny_cdn'){
            $m3u8_url =  $socure_data->url ;
            $command = ['ffprobe', '-v', 'error','-show_entries','format=duration','-of','default=noprint_wrappers=1:nokey=1', $m3u8_url, ];
            $process = new Process($command);
            //  // Initialize variables
            // $duration = null;
            // $seconds = null;
            // $error = null;

            try {
                // Run the process
                $process->mustRun();
                $duration = trim($process->getOutput());
                $seconds = round($duration);
            } catch (ProcessFailedException $exception) {
                $error = $exception->getMessage();
            }
    
            $data = array(
                'duration' => $duration  ,
                'seconds' => $seconds  ,      
                'type' => 'm3u8'  ,            
                'URL' => $socure_data->url  ,          
                'socure_data' => $socure_data  ,
            );
        }
    }else if($socure_type == "LiveStream"){ 
        $socure_data = App\LiveStream::where('id',$socure_id)->first();
        if(!empty($socure_data) && $socure_data->url_type == 'mp4' ){
            $mp4_url = $socure_data->mp4_url ;
            $ffprobe = \FFMpeg\FFProbe::create();
            $Video_duration = $ffprobe->format($mp4_url)->get('duration');
            $duration = explode(".", $Video_duration)[0];
            $seconds = round($duration);
            
            if($duration == 'N/A'|| empty($duration)){
                $duration = 3600;
                $seconds  = 3600;
            }

            $data = array(
                'duration' => $duration  ,
                'seconds' => $seconds  ,   
                'type' => 'mp4'  ,            
                'URL' => $socure_data->mp4_url  ,         
                'socure_data' => $socure_data  ,
            );
        }else if(!empty($socure_data) && $socure_data->url_type == 'live_stream_video'){
            $m3u8_url = $socure_data->live_stream_video;
            $command = ['ffprobe', '-v', 'error','-show_entries','format=duration','-of','default=noprint_wrappers=1:nokey=1', $m3u8_url, ];
            $process = new Process($command);
            // try {
                // Run the process
                $process->mustRun();
                $duration = trim($process->getOutput());
                $seconds = round($duration);
            // } catch (ProcessFailedException $exception) {
            //     $error = $exception->getMessage();
            // }
            if($duration == 'N/A'){
                $duration = 3600;
                $seconds  = 3600;
            }
            $data = array(
                'duration' => $duration  ,
                'seconds' => $seconds  , 
                'type' => 'm3u8'  ,            
                'URL' => $socure_data->live_stream_video  ,             
                'socure_data' => $socure_data  ,
            );
        }else if(!empty($socure_data) && $socure_data->url_type == 'Encode_video'){
            $m3u8_url = $socure_data->hls_url ;
            $command = ['ffprobe', '-v', 'error','-show_entries','format=duration','-of','default=noprint_wrappers=1:nokey=1', $m3u8_url, ];
            $process = new Process($command);
            try {
                // Run the process
                $process->mustRun();
                $duration = trim($process->getOutput());
                $seconds = round($duration);
            } catch (ProcessFailedException $exception) {
                $error = $exception->getMessage();
                $duration = 3600;
                $seconds  = 3600;
            }

            if($duration == 'N/A'){
                $duration = 3600;
                $seconds  = 3600;
            }
            
            $data = array(
                'duration' => $duration  ,
                'seconds' => $seconds  , 
                'type' => 'm3u8'  ,            
                'URL' => $socure_data->hls_url  ,             
                'socure_data' => $socure_data  ,
            );
        }
    }
    // echo"<pre>"; print_r('$socure_data');exit;

    return  $data; 
        
}


function ChannelVideoScheduler($channe_id,$time)
{

    $ChannelVideoScheduler = App\ChannelVideoScheduler::where('channe_id',$channe_id)
                                ->where('choosed_date',$time)
                                ->orderBy('created_at', 'DESC')->first();

    return  $ChannelVideoScheduler; 
        
}


function ChannelVideoSchedulerWithTimeZone($channe_id,$time,$time_zone)
{

    $ChannelVideoSchedulerWithTimeZone = App\ChannelVideoScheduler::where('channe_id',$channe_id)
                                            ->where('choosed_date',$time)
                                            ->where('time_zone',$time_zone)
                                            ->orderBy('created_at', 'DESC')->first();

    return  $ChannelVideoSchedulerWithTimeZone; 
        
}

function chosen_datetime($time)
{

        $next_date = 1;
        $carbonDate = explode("-",$time); 
        if(!empty($carbonDate) && count($carbonDate) > 0 ){
            $choosed_date = $carbonDate[2] . "-" . $carbonDate[0] . "-" . $carbonDate[1];
            $chosen_datetime = \Carbon\Carbon::parse($choosed_date)->addDays($next_date) ;
            $chosen_datetime = $chosen_datetime->format('n-j-Y');
        }else{
            $chosen_datetime = $time;
        }

    return  $chosen_datetime; 

}

function existingVideoSchedulerEntry($time,$channe_id,$start_time)
{

        $existingVideoSchedulerEntry = App\ChannelVideoScheduler::where('choosed_date', chosen_datetime($time))
                ->where('channe_id', $channe_id)
                ->first();

        $current_time = strtotime($start_time);

            if(!empty($existingVideoSchedulerEntry) ){
                return 0;
            }else{
                return 1;
            }

}



function VideoScheduledData($time,$channe_id,$time_zone){
    
    $carbonDate = \Carbon\Carbon::createFromFormat('m-d-Y', $time);
    $time = $carbonDate->format('n-j-Y');
    $ChannelVideoScheduler = App\ChannelVideoScheduler::where('channe_id', $channe_id)
                            ->where('time_zone', $time_zone)
                            ->where('choosed_date', $time)
                            ->orderBy('socure_order', 'ASC')
                            ->join('admin_epg_channels', 'admin_epg_channels.id', '=', 'channel_videos_scheduler.channe_id')
                            ->select('channel_videos_scheduler.*', 'admin_epg_channels.name')
                            ->get();
            $image_URL = URL::to("");
            $edit_svg = URL::to('assets/img/icon/edit.svg');
            $delete_svg = URL::to('assets/img/icon/delete.svg');
            $calender_svg = URL::to('assets/img/icon/cal-event.svg');
            $output = "";
            $i = 1;
            if (count($ChannelVideoScheduler) > 0) {
                $total_row = $ChannelVideoScheduler->count();
                if (!empty($ChannelVideoScheduler)) {
    
                    foreach ($ChannelVideoScheduler as $key => $row) {
                        $output .=
                            '<tr>
                            <td class="border-lft">' . $row->socure_title.
                                            '</td>
                                 
                                <td>' . $row->start_time . '</td>       
                                <td>' . $row->end_time . '</td>    
                                <td>' . $row->duration . '</td>  
                                <td class="border-rigt">
                                    <div class="action-icons">
                                        <button class="btn btn-sm edit-btn" data-toggle="modal" data-target="#editModal" data-id="' . $row->id . '">
                                            <img class="ply" src="'.$edit_svg.'">
                                            
                                        </button>
                                        <button class="btn btn-sm rescheduler-btn" data-toggle="modal" data-target="#rescheduleModal" data-id="' . $row->id . '">
                                            <img class="ply" src="'.$calender_svg.'" width="19px" height="19px">
                                        </button>
                                        <button class="btn btn-sm remove-btn" data-id="' . $row->id . '">
                                            <img class="ply" src="'.$delete_svg.'">                                         
                                        </button>
                                    </div>
                                </td>
                            </tr>';
                }
            } else {

                $output = '
                    <tr>
                        <td align="center" colspan="5">No Data Found</td>
                    </tr>
                    ';
            }
        }else{
            $total_row = 0;
            $ChannelVideoScheduler = [];
        }

        $value["success"] = 1;
        $value["message"] = "Uploaded Successfully!";
        $value["table_data"] = $output;
        $value["total_data"] = $total_row;
        $value["total_content"] = $ChannelVideoScheduler;

    return $value;
}

function Tv_Activation_Code()
{
    $Tv_Activation_Code = App\SiteTheme::pluck('Tv_Activation_Code')->first();
    return  $Tv_Activation_Code; 
}

function Tv_Logged_User_List()
{
    $Tv_Logged_User_List = App\SiteTheme::pluck('Tv_Logged_User_List')->first();
    return  $Tv_Logged_User_List; 
}


function Block_LiveStreams()
{
     // blocked Audio
     $block_live_stream = App\BlockLiveStream::where('country',Country_name())->get();
        
     if(!$block_live_stream->isEmpty()){
         foreach($block_live_stream as $blocked_live_stream){
            $blocked_live_stream[]=$blocked_live_stream->live_id;
         }
     } 
     else{
        $blocked_live_stream[]='';
     }   

   return $blocked_live_stream;

}


function compress_responsive_image_enable()
{
    $compress_responsive_image_enable = App\CompressImage::pluck('enable_multiple_compress_image')->first() ? App\CompressImage::pluck('enable_multiple_compress_image')->first() : 0;
    return $compress_responsive_image_enable ;
}



function send_video_push_notifications($title,$message,$video_name,$video_id,$user_id,$video_img){
    $fcm_postt ="https://fcm.googleapis.com/fcm/send";
    $settings = App\Setting::first();
    $server_key = $settings->notification_key;
    $notification_icon = $settings->notification_icon;

    $users = App\User::where('token', '!=', '')->where('id','=',$user_id)->get();
    $userdata = App\User::where('token', '!=', '')->where('id','=',$user_id)->first();

    if($userdata != null){
        $user = $userdata->token;
        $headers = array('Authorization:key='.$server_key,'Content-Type:application/json');
        $field = array('to'=>$user,'notification'=>array('title'=> $video_name,'body'=>strip_tags($message),'tag'=> $message,'icon'=> $video_img,'link'=> URL::to('/public/uploads/') . '/settings/' . $notification_icon));
        $payload =json_encode($field);
        $curl_session = curl_init();
        curl_setopt($curl_session, CURLOPT_URL, $fcm_postt);
        curl_setopt($curl_session, CURLOPT_POST, true);
        curl_setopt($curl_session, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_session, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_session, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($curl_session, CURLOPT_POSTFIELDS, $payload);
        curl_exec($curl_session);
        curl_close($curl_session);
        DB::table('notifications')->insert(['user_id' => $user_id, 'title' => $title,'message' => $message,'socure_type' => 'Video', 'socure_id' => $video_id ]);
    }
    return true;
}

function Logged_Monetization()
{
    $Logged_Monetization = App\SiteTheme::pluck('enable_logged_device')->first();
    return  $Logged_Monetization; 
}



function SiteVideoScheduler($channe_id,$time)
{

    $SiteVideoScheduler = App\SiteVideoScheduler::where('channe_id',$channe_id)
                                ->where('choosed_date',$time)
                                ->orderBy('created_at', 'DESC')->first();

    return  $SiteVideoScheduler; 
        
}


function SiteVideoSchedulerWithTimeZone($channe_id,$time,$time_zone)
{

    $SiteVideoSchedulerWithTimeZone = App\SiteVideoScheduler::where('channe_id',$channe_id)
                                            ->where('choosed_date',$time)
                                            ->where('time_zone',$time_zone)
                                            ->orderBy('created_at', 'DESC')->first();

    return  $SiteVideoSchedulerWithTimeZone; 
        
}



function existingSiteVideoSchedulerEntry($time,$channe_id,$start_time)
{
    
        $existingVideoSchedulerEntry = App\SiteVideoScheduler::where('choosed_date', chosen_datetime($time))
                ->where('channe_id', $channe_id)
                ->first();

        $current_time = strtotime($start_time);

            if(!empty($existingVideoSchedulerEntry) ){
                return 0;
            }else{
                return 1;
            }

}



function SiteVideoScheduledData($time,$channe_id,$time_zone){
    
    $carbonDate = \Carbon\Carbon::createFromFormat('m-d-Y', $time);
    $time = $carbonDate->format('n-j-Y');
    // print_r($time_zone);exit;
    $SiteVideoScheduler = App\SiteVideoScheduler::where('channe_id', $channe_id)
                            ->where('time_zone', $time_zone)
                            ->where('choosed_date', $time)
                            // ->orderBy('socure_order', 'ASC')
                            ->join('video_schedules', 'video_schedules.id', '=', 'site_videos_scheduler.channe_id')
                            ->select('site_videos_scheduler.*', 'video_schedules.name')
                            ->get();
            $image_URL = URL::to("");
            $edit_svg = URL::to('assets/img/icon/edit.svg');
            $delete_svg = URL::to('assets/img/icon/delete.svg');
            $calender_svg = URL::to('assets/img/icon/cal-event.svg');
            $output = "";
            $i = 1;
            if (count($SiteVideoScheduler) > 0) {
                $total_row = $SiteVideoScheduler->count();
                if (!empty($SiteVideoScheduler)) {
    
                    foreach ($SiteVideoScheduler as $key => $row) {
                        $output .=
                            '<tr>
                            <td class="border-lft">' . $row->socure_title.
                                            '</td>
                                 
                                <td>' . $row->start_time . '</td>       
                                <td>' . $row->end_time . '</td>    
                                <td>' . $row->duration . '</td>  
                                <td class="border-rigt">
                                    <div class="action-icons">

                                        <button class="btn btn-sm rescheduler-btn" data-toggle="modal" data-target="#rescheduleModal" data-id="' . $row->id . '">
                                            <img class="ply" src="'.$calender_svg.'" width="19px" height="19px">
                                        </button>
                                        
                                        <button class="btn btn-sm remove-btn" data-id="' . $row->id . '">
                                            <img class="ply" src="'.$delete_svg.'">                                         
                                        </button>
                                    </div>
                                </td>
                            </tr>';
                }
            } else {

                $output = '
                    <tr>
                        <td align="center" colspan="5">No Data Found</td>
                    </tr>
                    ';
            }
        }else{
            $total_row = 0;
            $SiteVideoScheduler = [];
        }

        $value["success"] = 1;
        $value["message"] = "Uploaded Successfully!";
        $value["table_data"] = $output;
        $value["total_data"] = $total_row;
        $value["total_content"] = $SiteVideoScheduler;

    return $value;
}


function Enable_4k_Conversion()
{
    $enable_4k_conversion = App\SiteTheme::pluck('enable_4k_conversion')->first();
    return $enable_4k_conversion ;
}

function Enable_PPV_Plans()
{
    $enable_ppv_plans = App\SiteTheme::pluck('enable_ppv_plans')->first();
    return $enable_ppv_plans ;
}

function Enable_videoCipher_Upload()
{
    $enable_ppv_plans = App\SiteTheme::pluck('enable_video_cipher_upload')->first();
    return $enable_ppv_plans ;
}

function Enable_Flussonic_Upload()
{
    $Enable_Flussonic_Upload = App\StorageSetting::pluck('flussonic_storage')->first();
    return $Enable_Flussonic_Upload ;
}

function Enable_Flussonic_Upload_Details()
{
    $Enable_Flussonic_Upload_Details = App\StorageSetting::select('flussonic_storage','flussonic_storage_site_base_url','flussonic_storage_Auth_Key','flussonic_storage_tag')->first();
    return $Enable_Flussonic_Upload_Details ;
}


function Enable_Site_Transcoding()
{
    $Enable_Site_Transcoding = App\Setting::pluck('transcoding_access')->first();
    return $Enable_Site_Transcoding ;
}


function Enable_Video_Compression()
{
    $enable_video_compression = App\SiteTheme::pluck('enable_video_compression')->first();
    return $enable_video_compression ;
}


function videocipher_Key(){
    $videocipher_ApiKey = App\StorageSetting::pluck('videocipher_ApiKey')->first();
    return  $videocipher_ApiKey; 
}


function payment_status($item) {
    switch ($item ? $item->payment_gateway : null) {
        case 'razorpay':
            return 'captured';  
        case 'Stripe':
            return 'succeeded';  
        case 'stripe':
            return 'succeeded';  
        default:
            return null;  
    }
}

function sendMicrosoftMail($to, $subject, $bladeTemplate, $data)
{
    try {
        $accessToken = MicrosoftGraphAuth::getAccessToken();
        if (!$accessToken) {
            Log::error("Failed to retrieve Microsoft Graph access token.");
            return false;
        }

        $graph = new Graph();
        $graph->setAccessToken($accessToken);

        $body = view($bladeTemplate, $data)->render();

        $emailMessage = [
            "message" => [
                "subject" => $subject,
                "body" => [
                    "contentType" => "HTML",
                    "content" => $body
                ],
                "toRecipients" => [
                    [
                        "emailAddress" => [
                            "address" => $to
                        ]
                    ]
                ]
            ]
        ];

        $graph->createRequest("POST", "/users/" . env('MICROSOFT_SENDER_EMAIL') . "/sendMail")
            ->attachBody($emailMessage)
            ->execute();

        return true;
    } catch (\Exception $e) {
        // dd($e->getMessage());
        Log::error("Microsoft Mail Error: " . $e->getMessage());
        return false;
    }
}

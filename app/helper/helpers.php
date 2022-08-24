<?php
//use Auth;

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
     $MailSignature = URL::to('/');
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

function GetCategoryVideoStatus()
{
     $settings = App\HomeSetting::first();
     return $settings->category_videos;  
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

function get_ad($ad_id,$field){
    $ads = App\Advertisement::where('id',$ad_id)->first()->$field;
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


function get_video($vid,$field){
    $getdata = App\Video::where('id',$vid)->first()->$field;
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

function Country_name(){
    
    $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
    $userIp = $geoip->getip();
    $countryName = $geoip->getCountry();

    return $countryName;
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



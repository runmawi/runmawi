<?php
//use Auth;

function changeDateFormate($date,$date_format){
    
    return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format($date_format); 
    
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


function FreeRegistration(){
    $settings = App\Setting::first();
    return $settings->free_registration;   
}

function CurrentSubPlan($id) {
    
    $active_user_stripe_plan  = App\Subscription::where('user_id','=',$id)->pluck('stripe_plan');
    return $active_user_stripe_plan[0];   
}
function StripePlanName($stripe_Plan) {
    
    $stripe_plan  = App\Plan::where('plan_id','=',$stripe_Plan)->first();
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
    $current_plans_name  = App\Plan::where('plan_id','=',$active_user_stripe_plan)->first();
    $current_plans_count = App\Plan::where('plan_id','=',$active_user_stripe_plan)->count();
    
    if ( $current_plans_count > 0){
        $result =  $current_plans_name->plans_name;  
    } else {
        $result =  "No Plan you were choosed";  
    }
    
    return $result;
}

function CurrentPaypalPlan($plan_id) {
    
    $current_plans_name  = App\PaypalPlan::where('plan_id','=',$plan_id)->pluck('name');
    $current_plans_count = App\PaypalPlan::where('plan_id','=',$current_plans_name)->count();
    
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
     return $settings->signature;  
}
function AdminMail()
{
     $settings = App\Setting::first();
     return $settings->system_email;  
}

//theme settings 
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

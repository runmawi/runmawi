<head>
   <?php
      $Script = App\Script::pluck('header_script')->toArray();
      $css = App\Css::pluck('custom_css')->toArray();

      $theme = App\SiteTheme::first();
      $theme_mode = $theme->theme_mode;

      $settings = App\Setting::first();
      @$translate_language = $settings->translate_language;
      $website_default_language = $settings->translate_language ? $settings->translate_language : 'en';

      $GetLightText = GetLightText();
      $GetDarkText = GetDarkText();
      $GetLightBg   = GetLightBg();
      $GetWebsiteName  = GetWebsiteName();
      $GetDarkBg    = GetDarkBg();
      $AdminOTPCredentials =  App\AdminOTPCredentials::pluck('status')->first();

      if(Auth::guest()){
         $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
         $userIp = $geoip->getip();
         $UserTranslation = App\UserTranslation::where('ip_address',$userIp)->first();

         if(!empty($UserTranslation)){
             $translate_language = $GetWebsiteName.$UserTranslation->translate_language;
         }else{
             $translate_language = $GetWebsiteName.@$website_default_language;
         }
     }else if(!Auth::guest()){

         $subuser_id=Session::get('subuser_id');
         if($subuser_id != ''){
             $Subuserranslation = App\UserTranslation::where('multiuser_id',$subuser_id)->first();
             if(!empty($Subuserranslation)){
                 $translate_language = $GetWebsiteName.$Subuserranslation->translate_language;
             }else{
                 $translate_language = $GetWebsiteName.@$website_default_language;
             }
         }else if(Auth::user()->id != ''){
             $UserTranslation = App\UserTranslation::where('user_id',Auth::user()->id)->first();
             if(!empty($UserTranslation)){
                 $translate_language = $GetWebsiteName.$UserTranslation->translate_language;
             }else{
                 $translate_language = $GetWebsiteName.@$website_default_language;
             }
         }else{
             $translate_language = $GetWebsiteName.@$website_default_language;
         }

     }else{
         $translate_language = $GetWebsiteName.@$website_default_language;
     }

      \App::setLocale(@$translate_language);


      $TranslationLanguage = App\TranslationLanguage::where('status',1)->get();
      if(!empty(Auth::User()->id)){

         $id = Auth::User()->id;
         $users = App\User::find($id);
         $date = date_create($users->created_at);
         $created_at = date_format($date,"Y-m-d");
         $filldate = date('Y-m-d', strtotime($created_at. ' + 10 day'));
         $currentdate = date('Y-m-d');
         $DOB = $users->DOB;

      }else{

         $currentdate = null ;
         $filldate = null ;
         $DOB = null;

      }

      $data = Session::all();

      // $uri_path = $_SERVER['REQUEST_URI'];
      $uri_path = \Request::getPathInfo();

      $uri_parts = explode('/', $uri_path);
      $request_url = end($uri_parts);
      $uppercase =  ucfirst($request_url);

      if(!Auth::guest() && empty($uppercase) || Auth::guest() && empty($uppercase)){
         $uppercase = "Home" ;
      }else{ }

      ?>

   <?php
      $videos_data = App\Video::where("slug", $request_url)->first();
      $series = App\Series::where("slug", $request_url)->first();
      $episdoe = App\Episode::where("slug", $request_url)->first();
      $livestream = App\LiveStream::where("slug", $request_url)->first();
      $dynamic_page = App\Page::where('slug', '=', $request_url)->first();
      $SiteMeta_page = App\SiteMeta::where('page_slug',  $request_url)->first();
      $SiteMeta_image = !is_null($SiteMeta_page) && !is_null($SiteMeta_page->meta_image) ? $SiteMeta_page->meta_image : null ;
   ?>

   <meta charset="UTF-8">


   <!-- Place this data between the <head> tags of your website -->
   <title>
      <?php
         if(!empty($videos_data)){ echo urldecode($videos_data->title) .' | '. $settings->website_name ;}
         elseif(!empty($series)){ echo urldecode($series->title) .' | '. $settings->website_name ; }
         elseif(!empty($episdoe)){ echo urldecode($episdoe->title) .' | '. $settings->website_name ; }
         elseif(!empty($livestream)){ echo urldecode($livestream->title) .' | '. $settings->website_name ; }
         elseif(!empty($dynamic_page)){ echo urldecode($dynamic_page->meta_title) .' | '. $settings->website_name ; }
         elseif(!empty($SiteMeta_page)){ echo urldecode($SiteMeta_page->page_title) .' | '. $settings->website_name ; }
         else{ echo urldecode($uppercase) .' | ' . $settings->website_name ;}
      ?>
   </title>

   <meta name="description" content="<?php
      if (!empty($videos_data)) { echo str_replace('"', "'", $videos_data->description); }
      elseif(!empty($episdoe)){ echo $episdoe->description  ;}
      elseif(!empty($series)){ echo $series->description ;}
      elseif(!empty($livestream)){ echo $livestream->description  ;}
      elseif(!empty($dynamic_page)){ echo ($dynamic_page->meta_description) ; }
      elseif(!empty($SiteMeta_page)){ echo $SiteMeta_page->meta_description .' | '. $settings->website_name ; }
      else{ echo $settings->website_description   ;}  ?>"
   />

   <meta name="keywords" content="<?php  @$dynamic_page->meta_keywords ? @$dynamic_page->meta_keywords : @$dynamic_page->meta_keywords?>">

   <!-- Schema.org markup for Google+ -->
   <meta itemprop="name" content="<?php
      if(!empty($videos_data)){  echo urldecode($videos_data->title).' | '. $settings->website_name ;}
      elseif(!empty($series)){ echo urldecode($series->title) .' | '. $settings->website_name ; }
      elseif(!empty($episdoe)){ echo urldecode($episdoe->title) .' | '. $settings->website_name ; }
      elseif(!empty($livestream)){ echo urldecode($livestream->title) .' | '. $settings->website_name ; }
      elseif(!empty($dynamic_page)){ echo urldecode($dynamic_page->title) .' | '. $settings->website_name ; }
      elseif(!empty($SiteMeta_page)){ echo urldecode($SiteMeta_page->page_name) .' | '. $settings->website_name ; }
      else{ echo urldecode($uppercase) .' | ' . $settings->website_name ;} ?>"
   />

   <meta itemprop="description" content="<?php
      if (!empty($videos_data)) { echo str_replace('"', "'", $videos_data->description); }
      elseif(!empty($episdoe)){ echo $episdoe->description  ;}
      elseif(!empty($series)){ echo $series->description ;}
      elseif(!empty($livestream)){ echo $livestream->description  ;}
      elseif(!empty($SiteMeta_page)){ echo $SiteMeta_page->meta_description .' | '. $settings->website_name ; }
      else{ echo $settings->website_description   ;}  ?>"
   />

   <meta itemprop="image" content="<?php
      if(!empty($videos_data)){ echo URL::to('/public/uploads/images').'/'.$videos_data->player_image;}
      elseif(!empty($episdoe)){ echo URL::to('/public/uploads/images').'/'.$episdoe->player_image  ;}
      elseif(!empty($series)){ echo URL::to('/public/uploads/images').'/'.$series->player_image ;}
      elseif(!empty($livestream)){ echo URL::to('/public/uploads/images').'/'.$livestream->player_image ;}
      elseif(!empty($SiteMeta_image)){ echo $SiteMeta_image ;}
      else{  echo URL::to('/').'/public/uploads/settings/'. $settings->default_horizontal_image   ;}  ?>"
   />

<!-- Twitter Card data -->
<meta name="twitter:card" content="summary_large_image">

<?php if(!empty($settings->twitter_page_id)){ ?><meta name="twitter:site" content="<?php echo $settings->twitter_page_id ;?>"><?php } ?>

   <meta name="twitter:title" content="<?php
      if(!empty($videos_data)){  echo urldecode($videos_data->title) .' | '. $settings->website_name ;}
      elseif(!empty($series)){ echo urldecode($series->title) .' | '. $settings->website_name ; }
      elseif(!empty($episdoe)){ echo urldecode($episdoe->title) .' | '. $settings->website_name ; }
      elseif(!empty($livestream)){ echo urldecode($livestream->title) .' | '. $settings->website_name ; }
      elseif(!empty($dynamic_page)){ echo urldecode($dynamic_page->title) .' | '. $settings->website_name ; }
      elseif(!empty($SiteMeta_page)){ echo urldecode($SiteMeta_page->page_title) .' | '. $settings->website_name ; }
      else{ echo urldecode($uppercase) .' | ' . $settings->website_name ;} ?>"
   >

   <meta name="twitter:description" content="<?php
      if (!empty($videos_data)) { echo str_replace('"', "'", $videos_data->description); }
      elseif(!empty($episdoe)){ echo $episdoe->description  ;}
      elseif(!empty($series)){ echo $series->description ;}
      elseif(!empty($livestream)){ echo $livestream->description  ;}
      elseif(!empty($SiteMeta_page)){ echo $SiteMeta_page->meta_description .' | '. $settings->website_name ; }
      else{ echo $settings->website_description   ;}  ?>"
   >

   <!-- Twitter summary card with large image must be at least 280x150px -->
   <meta name="twitter:image:src" content="<?php
      if(!empty($videos_data)){ echo URL::to('/public/uploads/images').'/'.$videos_data->player_image;}
      elseif(!empty($episdoe)){ echo URL::to('/public/uploads/images').'/'.$episdoe->player_image;}
      elseif(!empty($series)){ echo URL::to('/public/uploads/images').'/'.$series->player_image ;}
      elseif(!empty($SiteMeta_image)){ echo $SiteMeta_image ;}
      else{  echo URL::to('/').'/public/uploads/settings/'. $settings->default_horizontal_image   ;}  ?>"
   >

   <!-- Open Graph data -->
   <meta property="og:title" content="<?php
      if(!empty($videos_data)){  echo urldecode($videos_data->title).' | '. $settings->website_name ;}
      elseif(!empty($series)){ echo urldecode($series->title) .' | '. $settings->website_name ; }
      elseif(!empty($episdoe)){ echo urldecode($episdoe->title) .' | '. $settings->website_name ; }
      elseif(!empty($livestream)){ echo urldecode($livestream->title) .' | '. $settings->website_name ; }
      elseif(!empty($dynamic_page)){ echo urldecode($dynamic_page->title) .' | '. $settings->website_name ; }
      elseif(!empty($SiteMeta_page)){ echo urldecode($SiteMeta_page->page_title) .' | '. $settings->website_name ; }
      else{ echo urldecode($uppercase) .' | ' . $settings->website_name ;} ?>"
   />

   <meta property="og:image" content="<?php
      if(!empty($videos_data)){ echo URL::to('/public/uploads/images').'/'.$videos_data->player_image;}
      elseif(!empty($episdoe)){ echo URL::to('/public/uploads/images').'/'.$episdoe->player_image  ;}
      elseif(!empty($series)){ echo URL::to('/public/uploads/images').'/'.$series->player_image ;}
      elseif(!empty($SiteMeta_image)){ echo $SiteMeta_image ;}
      else{  echo URL::to('/').'/public/uploads/settings/'. $settings->default_horizontal_image   ;}  ?>"
   />

   <meta property="og:description" content="<?php
      if (!empty($videos_data)) { echo str_replace('"', "'", $videos_data->description); }
      elseif(!empty($episdoe)){ echo $episdoe->description  ;}
      elseif(!empty($series)){ echo $series->description ;}
      elseif(!empty($livestream)){ echo $livestream->description  ;}
      elseif(!empty($SiteMeta_page)){ echo $SiteMeta_page->meta_description .' | '. $settings->website_name ; }
      else{ echo $settings->website_description   ;}  ?>"
   />

<?php if(!empty($settings->website_name)){ ?><meta property="og:site_name" content="<?php echo $settings->website_name ;?>" /><?php } ?>

   <?php  $Linking_Setting = App\LinkingSetting::first();
      $site_url = \Request::url();
      $http_site_url = explode("http://",$site_url);
      $https_site_url = explode("https://",$site_url);
      if(!empty($http_site_url[1])){
         $site_page_url = $http_site_url[1];
      }elseif(!empty($https_site_url[1])){
         $site_page_url = $https_site_url[1];
      }else{
         $site_page_url = "";
      }
   ?>

   <?php if(!empty($Linking_Setting->ios_app_store_id)){ ?>
   <meta property="al:ios:app_store_id" content="<?php  echo $Linking_Setting->ios_app_store_id; ?>" />
   <?php } ?>
   <meta property="al:ios:url" content="<?php echo $site_page_url  ; ?>" />
   <?php if(!empty($Linking_Setting->ipad_app_store_id)){ ?>
   <meta property="al:ipad:app_store_id" content="<?php  echo $Linking_Setting->ipad_app_store_id  ; ?>" />
   <?php } ?>
   <meta property="al:ipad:url" content="<?php echo $site_page_url  ; ?>" />
   <?php if(!empty($Linking_Setting->android_app_store_id)){ ?>
   <meta property="al:android:package" content="<?php  echo $Linking_Setting->android_app_store_id  ; ?>" />
   <?php } ?>
   <meta property="al:android:url" content="<?php echo $site_page_url  ; ?>" />
   <meta property="al:windows_phone:url" content="<?php echo $site_page_url  ; ?>" />
   <?php if(!empty($Linking_Setting->windows_phone_app_store_id)){ ?>
   <meta property="al:windows_phone:app_id" content="<?php  echo $Linking_Setting->windows_phone_app_store_id;?>" />
   <?php } ?>
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">

   <link rel="preload" href="<?= URL::to('assets/css/variable-boots-flick.css') ;?>" as="style">
   <link rel="preload" href="<?= URL::to('assets/css/variable.css') ;?>" as="style">
   <link rel="preload" href="<?= URL::to('assets/css/all.min.css') ;?>" as="style">
   <link rel="preload" href="<?= URL::to('assets/css/remixicon.css') ;?>" as="style">

   <link rel="preload" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'" >

   <!-- Favicon -->
   <link rel="shortcut icon" href="<?php echo getFavicon();?>" type="image/gif" sizes="16x16">
   <input type="hidden" value="<?php echo $settings->google_tracking_id ; ?>" name="tracking_id" id="tracking_id">
   <link rel="shortcut icon" type="image/png" href="<?= URL::to('/'). '/public/uploads/settings/'. $settings->favicon; ?>" />
   
   <!-- Typography CSS  -->
   <link rel="preload" href="<?= typography_link();?>" as="style"/>
   <link rel="stylesheet" href="<?= typography_link();?>" />

   <link rel="preload" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" as="style"/>
   <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
   <!-- Style -->
   <link fetchpriority="high" rel="preload" href="<?= URL::to('assets/css/style.css') ;?>" as="style"/>
   <link rel="stylesheet" href="<?= URL::to('assets/css/style.css') ;?>" />
   <!-- compine.css -->
   <link rel="preload" href="<?= URL::to('/assets/css/compine.css') ;?>" as="style" />

   <!-- js -->
   <link rel="preload" fetchpriority="high" href="<?= URL::to('/assets/js/jquery-3.4.1.min.js') ?>" as="script"/>
   <link rel="preload" fetchpriority="high" href="<?= URL::to('/assets/js/jquery.lazy.min.js');?>" as="script">

   <link rel="preload" href="<?= URL::to('/assets/js/jquery.3.4.1.js') ?>" as="script"/>

   <!-- flickity.js & jquery.magnific-popup.min.js & popper.min.js -->
   <script defer src="<?= URL::to('/assets/js/flick-popper-magnific.js') ;?>"></script>
   <script src="<?= URL::to('/assets/js/flick-popper-magnific.js') ;?>"></script>

   <link rel="preload" href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" as="style">
   <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">



   <!-- <link rel="preload" href="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js" as="script"/>
   <link rel="preload" href="https://cdn.jsdelivr.net/hls.js/latest/hls.js" as="script"/>
   <link rel="preload" href="assets/js/bootstrap.min.js" as="script"/>
   <link rel="preload" href="assets/js/select2.min.js" as="script"/>
   <link rel="preload" href="assets/admin/dashassets/js/google_analytics_tracking_id.js" as="script"/> -->

   <!-- lazyload script -->

   <?php
      if(count($Script) > 0){
         foreach($Script as $Scriptheader){   ?>
            <?= $Scriptheader ?>
         <?php }
      } ?>
      <!-- custom css -->
   <?php
      if(count($css) > 0){
         foreach($css as $customCss){   ?>
            <?= $customCss ?>
         <?php }
      } 
   ?>

<style>
      .fullpage-loader {
      position: fixed;
      top: 0;
      left: 0;
      height: 100%;
      width: 100%;
      overflow: hidden;
      /* background: linear-gradient(180deg, #040404 0%, #3D3D47 100%); */
      background: #000;
      z-index: 9999;
      opacity: 1;
      transition: opacity .5s;
      display: flex;
      justify-content: center;
      align-items: center;
      .fullpage-loader__logo {
      position: relative;
      &:after {
      // this is the sliding white part
      content: '';
      height: 100%;
      width: 100%;
      position: absolute;
      top: 0;
      left: 0;
      animation: shine 2.5s infinite cubic-bezier(0.42, 0, 0.58, 1);
      // opaque white slide
      background: rgba(255,255,255,.8);
      // gradient shine scroll
      background: -moz-linear-gradient(left, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 50%, rgba(255,255,255,0) 100%); /* FF3.6-15 */
      background: -webkit-linear-gradient(left, rgba(255,255,255,0) 0%,rgba(255,255,255,1) 50%,rgba(255,255,255,0) 100%); /* Chrome10-25,Safari5.1-6 */
      background: linear-gradient(to right, rgba(255,255,255,0) 0%,rgba(255,255,255,1) 50%,rgba(255,255,255,0) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
      filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00ffffff', endColorstr='#00ffffff',GradientType=1 ); /* IE6-9 */
      }
      }
      }
      @keyframes shine {
      0% {
      transform: translateX(-100%) skew(-30deg);
      }
      100% {
      transform: translateX(200%) skew(-30deg);
      }
      }
      .fullpage-loader--invisible {
      opacity: 0;
      }
      /* END LOADER CSS */
      svg{
      height: 30px;
      widows: 30px;
      }
      .mk{
      display: none;
      }
      #main-header{ color: #fff; }
      .svg{ color: #fff; }
      #videoPlayer{
      width:100%;
      height: 100%;
      margin: 20px auto;
      }
      i.fas.fa-child{
      font-size: 35px;
      color: white;
      }
      span.kids {
      color: #f7dc59;
      }
      span.family{
      color: #f7dc59;
      }
      i.fa.fa-eercast{
      font-size: 35px;
      color: white;
      }
      a.navbar-brand.iconss {
      font-size: 19px;
      font-style: italic;
      font-family: ui-rounded;
      }
      .switch {
      position: relative;
      display: inline-block;
      width: 50px;
      height: 20px;
      }
      .switch input {
      opacity: 0;
      width: 0;
      height: 0;
      }
      .sliderk {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ddd;
      -webkit-transition: .4s;
      transition: .4s;
      }
      .sliderk:before {
      position: absolute;
      content: "";
      height: 15px;
      width: 15px;
      left: 5px;
      bottom: 2px;
      background-color: white;
      -webkit-transition: .4s;
      transition: .4s;
      }
      input:checked + .sliderk {
      background-color: #2196F3;
      }
      input:focus + .sliderk {
      box-shadow: 0 0 1px #2196F3;
      }
      input:checked + .sliderk:before {
      -webkit-transform: translateX(26px);
      -ms-transform: translateX(26px);
      transform: translateX(26px);
      }
      li.logout_mobile_view.col-sm-6.myp h6{font-weight:600;}
      /* Rounded sliders */
      .sliderk.round {
         border-radius: 34px;
      }
      .sliderk.round:before {
         border-radius: 50%;
      }
      body{background: #000;}
      /* Dark mode and light Mode */
         
      body.dark-theme {
         background: <?php echo $GetDarkBg; ?>!important;
      }
      body.dark-theme i{
         color: <?php echo $GetDarkText; ?>!important;
      }
      body.dark-theme .navbar-right .iq-sub-dropdown, header#main-header.menu-sticky{
         background: <?php echo $GetDarkBg; ?>!important;
      }
      body.dark-theme h1, body.dark-theme h2, body.dark-theme h3, body.dark-theme h4, body.dark-theme h5, body.dark-theme h6{
         color: <?php echo $GetDarkText; ?>!important;
      }
      
      body.dark-theme .navbar-collapse{
         background: <?php echo $GetDarkBg; ?>!important;
      }
      body.dark-theme header .navbar ul li.menu-item a{
         color: <?php echo $GetDarkText; ?>!important;
      }
      body.dark-theme .vpageBanner .content .right , body.dark-theme .vpageBanner .content .right .utilities{
         color: <?php echo $GetDarkText; ?>!important;
      }
      body.dark-theme a, body.dark-theme p{
         color: <?php echo $GetDarkText; ?>;
      }
      body.dark-theme .share-icons.music-play-lists li span i{
         color: <?php echo $GetDarkText; ?>!important;
      }
      body.dark-theme ol.breadcrumb{
         color: <?php echo $GetDarkText; ?>!important;
      }
      body.dark-theme ul.list-group.home-search,.iq-search-bar .search-input{
         background-color: <?php echo $GetDarkBg; ?>!important;
         color: <?php echo $GetDarkText; ?>!important;
      }
      body.dark-theme header#main-header{
         color: <?php echo $GetDarkText; ?>!important;
      }
      body.dark-theme .breadcrumb i {
         color: <?php echo $GetDarkText; ?>!important;
      }
      body.dark-theme #home-slider p, body.dark-theme #home-slider h2{
         color: #fff !important;
      }
      body.dark-theme header .st0, .st2{
         fill: <?php echo $GetDarkText; ?>!important;
         stroke: <?php echo $GetDarkText; ?>!important;
      }
      body.dark-theme header .st6,.st3,.st1 {
         stroke: <?php echo $GetDarkText; ?>!important;
      }
      body.dark-theme header .st5 {
         fill: <?php echo $GetDarkText; ?>!important;
      }
      body.dark-theme header h1, body.dark-theme header h2, body.dark-theme header h3, body.dark-theme header h4, body.dark-theme header h5, body.dark-theme header h6{
         color: <?php echo $GetDarkText; ?>!important;
      }
      body.dark-theme header .cont-item:hover{
         background-color: transparent !important;
      }
      body.dark-theme header .dropdown-menu.categ-head{
         background-color: <?php echo $GetDarkBg; ?>!important;
      }
      body.light-theme {
      background: <?php echo $GetLightBg; ?>!important;
      }
      body.light-theme #home-slider .container-fluid.position-relative.h-100{
         background: linear-gradient(1deg, rgb(255, 255, 255) 0%, transparent 0%), linear-gradient(90deg, rgb(240, 240, 240) 50%, transparent 50%);
      }
      body.light-theme h4, body.light-theme p, body.light-theme span {
      color: <?php echo $GetLightText; ?>;
      }
      body.light-theme .block-description p.epi-name{
      color: <?php echo $GetLightText; ?> !important;
      }
      body.light-theme header#main-header{
      background-color: <?php echo $GetLightBg; ?>!important;
      color: <?php echo $GetLightText; ?> !important;
      box-shadow: 0 0 50px #ccc;
      }
      body.light-theme footer{
      background: <?php echo $GetLightBg; ?>!important;
      color: <?php echo $GetLightText; ?>;
      box-shadow: 0 0 50px #ccc;
      }
      body.light-theme .copyright{
      background-color: <?php echo $GetLightBg; ?>;
      color: <?php echo $GetLightText; ?>;
      }
      body.light-theme .dropdown-item.cont-item{
      color: <?php echo $GetLightText; ?>;
      }
      body.light-theme .s-icon{
      background-color: <?php echo $GetLightBg; ?>;
      box-shadow: 0 0 50px #ccc;
      }
      body.light-theme .search-toggle:hover, header .navbar ul li.menu-item a:hover{
      }
      body.light-theme .dropdown-menu.categ-head{
      background-color: <?php echo $GetLightBg; ?>!important;
      color: <?php echo $GetLightText; ?>!important;
      }
      body.light-theme .search-toggle:hover, header .navbar ul li.menu-item a:hover {
      color: rgb(0, 82, 204)!important;
         font-weight: 500;
      }
      body.light-theme .navbar-right .iq-sub-dropdown{
      background-color: <?php echo $GetLightBg; ?>;
      }
      body.light-theme ul.list-group.home-search{
      background-color: <?php echo $GetLightBg; ?> !important;
      }
      body.light-theme .iq-search-bar .search-input{
         background-color: <?php echo $GetLightBg; ?> !important;
         color: var(--iq-body-text) !important;
      }
      body.light-theme body.light-theme .list-group-item a{
         color: var(--iq-body-text) !important;
      }
      body.light-theme .searchbox h6, body.light-theme .iq-card-body h6{
         color: var(--iq-body-text) !important;
      }
      body.light-theme h1, body.light-theme h2, body.light-theme h3, body.light-theme h4, body.light-theme h5, body.light-theme h6{
         color: var(--iq-body-text) !important;
      }
      body.light-theme .media-body h6{
      color: <?php echo $GetLightText; ?>;
      font-weight: 400;
      }
      body.light-theme .block-description h6{
      color: <?php echo $GetLightText; ?>;
      font-weight: 400;
      }
      body.light-theme .movie-time i{
      color: <?php echo $GetLightText; ?>!important;
      font-weight: 400;
      }
      body.light-theme #translator-table_filter input[type="search"]{
      color: <?php echo $GetLightText; ?>;
      }
      body.light-theme li.breadcrumb-item{
      color: <?php echo $GetLightText; ?>;
      }
      body.light-theme .p-tag1{
      color: <?php echo $GetLightText; ?>!important;
      font-weight: 400;
      } body.light-theme .p-tag{
      color: <?php echo $GetLightText; ?>!important;
      font-weight: 400;
      }
      body.light-theme .movie-time span{
      color: <?php echo $GetLightText; ?>!important;
      font-weight: 400;
      }
      body.light-theme .block-description a{
      color: <?php echo $GetLightText; ?>!important;
      font-weight: 400;
      }

      body.light-theme .block-description{
   background-image: linear-gradient(to bottom, rgb(243 244 247 / 30%), rgb(247 243 243 / 90%), rgb(247 244 244 / 90%), rgb(235 227 227 / 90%));
      backdrop-filter: blur(2px);
      }
      body.light-theme  header .navbar ul li{
      font-weight: 400;
      }
      body.light-theme .slick-nav i{
      color: <?php echo $GetLightText; ?>!important;
      }
      body.light-theme h2{
      color: <?php echo $GetLightText; ?>!important;
      }
      body.light-theme h5{
      color: <?php echo $GetLightText; ?>!important;
      }
      body.light-theme .filter-option-inner-inner{
      color: <?php echo $GetLightText; ?>!important;
      }
      body.light-theme .vid-title{
      color: <?php echo $GetLightText; ?>!important;
      }
      body.light-theme .trending-info h1{
      color: <?php echo $GetLightText; ?>!important;
      }body.light-theme .text-detail{
      color: <?php echo $GetLightText; ?>!important;
      }body.light-theme .share-icons.music-play-lists li span i{
      color: <?php echo $GetLightText; ?>!important;
      }body.light-theme .btn1{
      border: 1px solid <?php echo $GetLightText; ?>!important;
      color: <?php echo $GetLightText; ?>!important;
      }body.light-theme .trending-dec{
      color: <?php echo $GetLightText; ?>!important;
      }
      body.light-theme .no_vid_avail{
      color: <?php echo $GetLightText; ?>!important;
      }
      body.light-theme h6.trash{
      color: black;
      }
      .Search_error_class {
         color: red;
      }
   @media  (min-width:1025px)  { li.logout_mobile_view.menu-item{
      display:none !important;
   } }
   @media (min-width:801px) { li.logout_mobile_view.menu-item{
      display:none !important;
   } }
   @media (max-width: 991px) {
      header .navbar ul li.menu-item a {
         border-top: 1px solid <?php echo $GetDarkText; ?>!important;
      }
   }
   .navbar-right .transdropdownlist{
      width:150px;
   }

   #languageSearch{
         width: 116px;
         font-size: 12px;
         right: 5px;
         position: relative;
      }
      .navbar-toggler{border:none;}
      .pagination a{color:#000 !important;}

      @media (max-width: 768px) {
         .fullpage-loader__logo .video-js {
            width: 500px; 
         }
      }

      @media (max-width: 480px) {
         .fullpage-loader__logo .video-js {
            width: 500px; 
         }
      }
   </style>

</head>

   <!-- loader Start -->
   <?php if( get_image_loader() == 1) { ?>
      <div id="loader" class="fullpage-loader" style="height:100%;width:100%;" >
         <div class="fullpage-loader__logo" style="text-align:center;" >


         <?php if($theme->loader_format == 1 && !(is_null($theme->loader_video))){ ?>
            <video id="loader-video" class="video-js" autoplay muted preload="auto" data-setup='' loop >
               <source src="<?= URL::to('/public/uploads/settings/'.$theme->loader_video) ?>" type='video/mp4'>
            </video>
         <?php } else { ?>
            <?php if($theme_mode == "light" && !empty($theme->light_mode_logo)){ ?>
               <img src="<?= URL::to('/public/uploads/settings/'. $theme->light_mode_logo) ?>" class="c-logo" alt="<?= $settings->website_name ?>">
            <?php } elseif($theme_mode != "light" && !empty($theme->dark_mode_logo)){ ?>
               <img src="<?= URL::to('/public/uploads/settings/'. $theme->dark_mode_logo) ?>" class="c-logo" alt="<?= $settings->website_name ?>">
            <?php } else { ?>
               <img src="<?= URL::to('/public/uploads/settings/'. $settings->logo) ?>" class="c-logo" alt="<?= $settings->website_name ?>">
            <?php } ?>
         <?php } ?>


         </div>
      </div>
   <?php } ?>

   <!-- Header -->
   <header id="main-header">
      <div class="main-header">
         <div class="container-fluid" >
            <div class="row">
               <div class="col-sm-12 mt-2">
                  <nav class="navbar navbar-expand-lg navbar-light p-0">
                     <a href="#" class="navbar-toggler c-toggler" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        <div class="navbar-toggler" data-toggle="collapse">
                           <i class="fa fa-bars" aria-hidden="true"></i>
                        </div>
                     </a>
                     <?php if($theme_mode == "light" && !empty(@$theme->light_mode_logo)){  ?>
                     <a class="navbar-brand mb-0" style="text-align: center;" href="<?php echo URL::to('/') ?>"> <img src="<?php echo URL::to('/').'/public/uploads/settings/'. $theme->light_mode_logo; ?>" class="c-logo" alt="<?php echo $settings->website_name ; ?>"> </a>
                     <?php }elseif($theme_mode != "light" && !empty(@$theme->dark_mode_logo)){ ?>
                     <a class="navbar-brand mb-0" style="text-align: center;" href="<?php echo URL::to('/') ?>"> <img src="<?php echo URL::to('/').'/public/uploads/settings/'. $theme->dark_mode_logo; ?>" class="c-logo" alt="<?php echo $settings->website_name ; ?>"> </a>
                     <?php }else { ?>
                     <a class="navbar-brand mb-0" style="text-align: center;" href="<?php echo URL::to('/') ?>"> <img src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo; ?>" class="c-logo" alt="<?php echo $settings->website_name ; ?>"> </a>
                     <?php } ?>

                     <div class="collapse navbar-collapse" id="navbarSupportedContent">

                        <div class="menu-main-menu-container">

                           <ul id="top-menu" class=" mt-2 nav navbar-nav <?php if ( Session::get('locale') == 'arabic') { echo "navbar-right"; } else { echo "navbar-left";}?>">

                              <?php if(Auth::guest()){ ?>
                                 <?php if($theme->signin_header == 1 ):?>

                                    <li class="menu-item dk" style="display:none;">
                                       <a href="<?php echo URL::to('login') ?>" class="iq-sub-card">
                                          <div class="media align-items-center">

                                             <div class="media-body">
                                                <h6 class="mb-0 " style="font-weight: 500;">Signin</h6>
                                             </div>
                                          </div>
                                       </a>
                                    </li>

                                    <li class="menu-item dk" style="display:none">
                                       <a href="<?php echo URL::to('signup') ?>" class="iq-sub-card">
                                          <div class="media align-items-center">

                                             <div class="media-body">
                                                <h6 class="mb-0 " style="font-weight: 500;">Signup</h6>
                                             </div>
                                          </div>
                                       </a>
                                    </li>
                                 <?php endif ; ?>
                              <?php }elseif(Auth::user()){ ?>
                              <li class="menu-item dk" style="display:none;">
                                 <a href="<?php echo URL::to('myprofile') ?>" class="iq-sub-card">
                                    <div class="media align-items-center">


                                       <div class="media-body">
                                          <h6 class="mb-0 " style="font-weight: 500;">My Profile</h6>
                                       </div>
                                    </div>
                                 </a>
                              </li>
                              <li class="menu-item dk" style="display:none;">
                                 <a href="<?php echo URL::to('/logout') ?>" class="iq-sub-card">
                                    <div class="media align-items-center">


                                       <div class="media-body">
                                          <h6 class="mb-0 " style="font-weight: 500;">Logout</h6>
                                       </div>
                                    </div>
                                 </a>
                              </li>
                              <?php } ?>



                              <div class="col-sm-12 d-flex justify-content-around pt-2 proflogbtn" style="color:white">
                                    <!-- <div class="row "> -->
                           <li class="col-sm-6 ">
                           <a class="navbar-brand mb-0 logout_mobile_view menu-item " style="float:right;" href="<?php echo URL::to('/') ?>"> <img alt="logo" src="<?php echo URL::to('/').'/public/uploads/settings/'. $theme->dark_mode_logo; ?>" class="c-logo" alt="<?php echo $settings->website_name ; ?>"> </a> </li>
                           <li class="dropdown menu-item col-sm-6">

                        <div class="btn-close" data-toggle="collapse">
                        <button type="button" class="navbar-toggler c-toggler p-0 border-0" data-toggle="collapse"
                           data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                           aria-expanded="false" aria-label="Toggle navigation" data-bs-toggle="modal" data-bs-target="#staticBackdrop" style="border-top: none; float:right">
                              <i class="fa fa-times" style="font-size: 20px;"></i>
                        </button>
                        </div>
                     <!-- </a> -->
                              </li>
                           </div>



                              <?php
                                 $stripe_plan = SubscriptionPlan();

                                 if(!Auth::guest() && Auth::User()->role != 'admin' || Auth::guest()){
                                    $menus = App\Menu::orderBy('order', 'asc')->where('in_home','!=',0)->orWhere('in_home', '=', null)->get();
                                 }else{
                                    $menus = App\Menu::orderBy('order', 'asc')->get();
                                 }

                                 $languages = App\Language::all();
                                 $LiveCategory = App\LiveCategory::orderBy('order', 'asc')->get();
                                 foreach ($menus as $menu) {
                                 if ( $menu->in_menu == "video" && $menu->in_menu == 1) {
                                    if(!Auth::guest()){
                                          $Authusers = App\User::where('email',Auth::User()->email)->pluck('role')->first();
                                    }else{
                                       $Authusers = '';
                                    }
                                    if(!empty($Authusers) && $Authusers == 'admin' ){
                                       $cat = App\VideoCategory::orderBy('order', 'asc')->get();
                                    }else{
                                       $cat = App\VideoCategory::orderBy('order', 'asc')->where('in_home','=',1)->get();
                                    }

                                 ?>


                              <li class="dropdown menu-item dskdflex">
                                 <a class="dropdown-toggle justify-content-between " id="down" href="<?php echo URL::to('/').$menu->url;?>" data-toggle="dropdown">
                                  <?php echo (__($menu->name)); ?> <i class="fa fa-angle-down"></i>
                                 </a>
                                 <ul class="dropdown-menu categ-head" style="overflow-x: hidden; border: none; outline: none;" >
                                    <?php foreach ( $cat as $category) { ?>
                                    <li>
                                       <a class="dropdown-item cont-item"  href="<?php echo URL::to('/').'/category/'.$category->slug;?>">
                                       <?php echo (__($category->name)); ?>
                                       </a>
                                    </li>
                                    <?php } ?>
                                 </ul>
                              </li>
                              <?php } elseif ( $menu->in_menu == "movies" && $menu->in_home == 1) {
                                 $cat = App\VideoCategory::orderBy('order', 'asc')->get();
                                 ?>
                              <li class="dropdown menu-item dskdflex">
                                 <a class="dropdown-toggle justify-content-between " id="movie-down" href="<?php echo URL::to('/').$menu->url;?>" data-toggle="dropdown">
                                 <?php echo (__($menu->name));?> <i class="fa fa-angle-down"></i>
                                 </a>
                                 <ul class="dropdown-menu categ-head" style="overflow-x: hidden; border: none; outline: none;" >
                                    <?php foreach ( $languages as $language){ ?>
                                    <li>
                                       <a class="dropdown-item cont-item" href="<?php echo URL::to('/').'/language/'.$language->id.'/'.$language->name;?>">
                                       <?php echo (__($language->name));?>
                                       </a>
                                    </li>
                                    <?php } ?>
                                 </ul>
                              </li>
                              <?php }elseif ( $menu->in_menu == "live" && $menu->in_home == 1) {
                                 $LiveCategory = App\LiveCategory::orderBy('order', 'asc')->get();
                                 ?>
                              <li class="dropdown menu-item dskdflex">
                                 <a class="dropdown-toggle  justify-content-between " id="live-down" href="<?php echo URL::to('/').$menu->url;?>" data-toggle="dropdown">
                                 <?php echo (__($menu->name));?> <i class="fa fa-angle-down"></i>
                                 </a>
                                 <ul class="dropdown-menu categ-head" style="overflow-x: hidden; border: none; outline: none;" >
                                    <?php foreach ( $LiveCategory as $category){ ?>
                                    <li>
                                       <a class="dropdown-item cont-item" href="<?php echo URL::to('/live/category').'/'.$category->name;?>">
                                       <?php echo (__($category->name));?>
                                       </a>
                                    </li>
                                    <?php } ?>
                                 </ul>
                              </li>


                              <!-- Audios dropdown -->
                              <?php }elseif ( $menu->in_menu == "audios" && $menu->in_home == 1) {
                                 $AudioCategory = App\AudioCategory::orderBy('order', 'asc')->get();
                                 ?>
                              <li class="dropdown menu-item dskdflex">
                                 <a class="dropdown-toggle  justify-content-between " id="audio-down" href="<?php echo URL::to('/').$menu->url;?>" data-toggle="dropdown">
                                 <?php echo (__($menu->name));?> <i class="fa fa-angle-down"></i>
                                 </a>
                                 <ul class="dropdown-menu categ-head" style="overflow-x: hidden; border: none; outline: none;" >
                                    <?php foreach ( $AudioCategory as $category){ ?>
                                    <li>
                                       <a class="dropdown-item cont-item" href="<?php echo URL::to('audios/category/').'/'.$category->name;?>">
                                       <?php echo (__($category->name));?>
                                       </a>
                                    </li>
                                    <?php } ?>
                                 </ul>
                              </li>


                              <!-- Tv show dropdown -->

                              <?php }elseif ( $menu->in_menu == "tv_show" && $menu->in_home == 1) {
                                 $tv_shows_series = App\SeriesGenre::get();
                                 ?>
                              <li class="dropdown menu-item ">
                                 <a class="" id="" href="<?php echo URL::to('/').$menu->url;?>" >
                                    <?php echo __($menu->name);?> <i class="fa fa-angle-down"></i>
                                 </a>

                                 <?php if(count($tv_shows_series) > 0 ){ ?>
                                    <ul class="dropdown-menu categ-head" style="overflow-x: hidden; border: none; outline: none;" >
                                       <?php foreach ( $tv_shows_series->take(6) as $key => $tvshows_series){ ?>
                                          <li>
                                             <?php if($key < 5): ?>
                                                <a class="dropdown-item cont-item" href="<?php echo URL::to('/series/category').'/'.$tvshows_series->slug;?>">
                                                   <?php echo $tvshows_series->name;?>
                                                </a>
                                             <?php else: ?>
                                                <a class="dropdown-item cont-item text-primary" href="<?php echo URL::to('/SeriescategoryList');?>">
                                                   <?php echo 'More...';?>
                                                </a>
                                             <?php endif; ?>

                                          </li>
                                       <?php } ?>
                                    </ul>
                                 <?php } ?>
                              </li>
                              <?php } elseif($menu->in_home == 1) { ?>
                                 <li class="menu-item">
                                       <a  href="<?php if($menu->select_url == "add_Site_url"){ echo URL::to('/').$menu->url; }elseif($menu->select_url == "add_Custom_url"){ echo $menu->custom_url;  }?>">
                                          <?php echo __($menu->name);?>
                                       </a>
                                 </li>

                              <?php  } } ?>




                              <?php if(Auth::guest()):  ?>
                                       <div class="col-sm-12 d-flex justify-content-around pt-4 proflogbtn" style="color:white">
                                          <!-- <div class="row "> -->
                                          <li class="logout_mobile_view col-sm-6 myp">
                                                <a href="<?php echo URL::to('login') ?>" class="iq-sub-card">
                                                   <div class="media align-items-center">
                                                      <div class="right-icon">
                                                         <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" x="0" y="0" viewBox="0 0 70 70" style="enable-background:new 0 0 70 70" xml:space="preserve">
                                                            <path class="st5" d="M13.4 33.7c0 .5.2.9.5 1.2.3.3.8.5 1.2.5h22.2l-4 4.1c-.4.3-.6.8-.6 1.3s.2 1 .5 1.3c.3.3.8.5 1.3.5s1-.2 1.3-.6l7.1-7.1c.7-.7.7-1.8 0-2.5l-7.1-7.1c-.7-.6-1.7-.6-2.4.1s-.7 1.7-.1 2.4l4 4.1H15.2c-1 .1-1.8.9-1.8 1.8z"/>
                                                            <path class="st5" d="M52.3 17.8c0-1.4-.6-2.8-1.6-3.7-1-1-2.3-1.6-3.7-1.6H27.5c-1.4 0-2.8.6-3.7 1.6-1 1-1.6 2.3-1.6 3.7v7.1c0 1 .8 1.8 1.8 1.8s1.8-.8 1.8-1.8v-7.1c0-1 .8-1.8 1.8-1.8H47c.5 0 .9.2 1.2.5.3.3.5.8.5 1.2v31.8c0 .5-.2.9-.5 1.2-.3.3-.8.5-1.2.5H27.5c-1 0-1.8-.8-1.8-1.8v-7.1c0-1-.8-1.8-1.8-1.8s-1.8.8-1.8 1.8v7.1c0 1.4.6 2.8 1.6 3.7 1 1 2.3 1.6 3.7 1.6H47c1.4 0 2.8-.6 3.7-1.6 1-1 1.6-2.3 1.6-3.7V17.8z"/>
                                                         </svg>
                                                      </div>
                                                      <div class="media-body">
                                                         <h6 class="mb-0 "><?php echo (__('Signin'));?></h6>
                                                      </div>
                                                   </div>
                                                </a>
                                          </li>
                                          <li class="logout_mobile_view col-sm-6 myp">
                                             <a href="<?php echo URL::to('signup') ?>" class="iq-sub-card">
                                                <div class="media align-items-center">
                                                   <div class="right-icon">
                                                      <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" x="0" y="0" viewBox="0 0 70 70" style="enable-background:new 0 0 70 70" xml:space="preserve">
                                                         <path class="st6" d="M53.4 33.7H30.7M36.4 28.1l-5.7 5.7 5.7 5.7"/>
                                                         <path class="st6" d="M50.5 43.7c-2.1 3.4-5.3 5.9-9.1 7.3-3.7 1.4-7.8 1.6-11.7.4a18.4 18.4 0 0 1-9.6-28.8c2.4-3.2 5.8-5.5 9.6-6.6 3.8-1.1 7.9-1 11.7.4 3.7 1.4 6.9 4 9.1 7.3"/>
                                                      </svg>
                                                   </div>
                                                   <div class="media-body">
                                                      <h6 class="mb-0 "><?php echo (__('Signup'));?></h6>
                                                   </div>
                                                </div>
                                             </a>
                                          </li>
                                       </div>
                                 <?php endif; ?>

                     <?php if(!Auth::guest()){

                        $ModeratorsUser = App\ModeratorsUser::where('email',Auth::user()->email)->first(); ?>

                                 <div class="col-sm-12 d-flex justify-content-around pt-4 proflogbtn" style="color:white">
                                    <!-- <div class="row "> -->
                                    <?php if($theme->enable_channel_btn ==1): ?>
                                       <li class="logout_mobile_view menu-item col-sm-6 channel_contentpr ">
                                       <form method="POST" action="<?php echo URL::to('channel/home') ?>" class="">
                                       <input type="hidden" name="_token" id= "token" value="<?= csrf_token() ?>">
                                       <input id="email" type="hidden"  name="email"  value="<?=  Auth::user()->email ?>"  autocomplete="email" autofocus>
                                       <input id="password" type="hidden"  name="password" value="<?=  @$Channel->unhased_password ?>" autocomplete="current-password" >
                                       <!-- <button type="submit" class="btn btn-primary " style="margin-top: 0%;margin-left: 5%;">CPP Portal </button>                           -->
                                       <button type="submit" class="btn bd w-100" style="padding:11px 16px" ><?php echo (__('Visit Channel Portal'));?> </button> </li>
                                       </form>
                                    <?php endif; ?>
                                    <?php if($theme->enable_cpp_btn ==1): ?>
                                       <li class="logout_mobile_view menu-item col-sm-6 channel_contentpr ">
                                          <form method="POST" action="<?php echo URL::to('cpp/home') ?>" class="">
                                          <input type="hidden" name="_token" id= "token" value="<?= csrf_token() ?>">
                                          <input id="email" type="hidden"  name="email"  value="<?=  Auth::user()->email ?>"  autocomplete="email" autofocus>
                                          <input id="password" type="hidden"  name="password" value="<?=  @$ModeratorsUser->password ?>" autocomplete="current-password" >
                                          <!-- <button type="submit" class="btn btn-primary " style="margin-top: 0%;margin-left: 5%;">CPP Portal </button>                           -->
                                          <button type="submit" class="btn bd w-100" style="padding:11px 16px" ><?php echo (__('Visit CPP Portal'));?></button> </li>
                                       </form>
                                    <?php endif; ?>
                                       
                                 </div>

                                 <div class="col-sm-12 d-flex justify-content-around pt-4 proflogbtn" style="color:white">
                                    <!-- <div class="row "> -->
                                    
                                 <li class="logout_mobile_view menu-item col-sm-6 myp"><a class="btn btn-primary" href="<?php echo URL::to('/logout'); ?>" style="color:#fff !important;">
                                          <?php echo __('Logout');?>
                                                   </a> </li>
                                    <li class="logout_mobile_view menu-item col-sm-6 myp"><a class="btn btn-primary" href="<?php echo URL::to('myprofile') ?>" style="color:#fff !important;">
                                                   <?php echo __('My Profile');?>
                                                </a> </li>
                                 </div>






                           <!-- Mobile responsive buttons -->
                           <div class="col-sm-12 d-flex justify-content-around pt-4 proflogbtn">
                              <div class="row ">
                                 <div class="col-sm-6  menu-item pt-3">
                                       <li class="logout_mobile_view menu-item col-sm-6 myp" style="display:none;">
                                          <a href="<?php echo URL::to('login') ?>" class="iq-sub-card">
                                             <div class="media align-items-center">

                                                <div class="media-body">
                                                   <h6 class="mb-0 " style="font-weight: 500;">Signin</h6>
                                                </div>
                                             </div>
                                          </a>
                                       </li>
                                 </div>
                                 <div class="col-sm-6 menu-item pt-3">
                                       <li class="logout_mobile_view menu-item col-sm-6 myp" style="display:none">
                                          <a href="<?php echo URL::to('signup') ?>" class="iq-sub-card">
                                             <div class="media align-items-center">

                                                <div class="media-body">
                                                   <h6 class="mb-0 " style="font-weight: 500;">Signup</h6>
                                                </div>
                                             </div>
                                          </a>
                                       </li>
                                 </div>

                              </div>
                           </div>

                              <!-- </div> -->
                                 <!-- <li class="logout_mobile_view menu-item btn btn-primary">
                                       <a href="<?php echo URL::to('/logout'); ?>">
                                          <?php echo __('Logout');?>
                                       </a>
                                 </li>
                                 <li class="logout_mobile_view menu-item btn btn-primary">
                                       <a href="<?php echo URL::to('myprofile') ?>">
                                          <?php echo __('My Profile');?>
                                       </a>
                                 </li> -->

                              <?php } ?>
                              <!-- <li class="nav-item dropdown menu-item"> -->
                              <!-- <a class="dropdown-toggle" href="<?php echo URL::to('/').@$menu->url;?>" data-toggle="dropdown">   -->
                              <!-- Movies <i class="fa fa-angle-down"></i> -->
                              <!-- </a> -->
                              <!-- <ul class="dropdown-menu categ-head"> -->
                              <?php //foreach ( $languages as $language) { ?>
                              <li>
                                 <!-- <a class="dropdown-item cont-item" href="<?php //echo URL::to('/').'/language/'.$language->id.'/'.$language->name;?>">  -->
                                 <?php //echo $language->name;?>
                                 <!-- </a> -->
                                 <!-- </li> -->
                                 <?php //} ?>
                                 <!-- </ul> -->
                                 <!-- </li> -->
                                 <!-- signup Mobile view -->
                                  <li>
                               </li>
                                  <div class="col-lg-12 align-items-center justify-content-center appk">
          <?php $app_settings = App\AppSetting::where('id','=',1)->first(); ?>

          <?php if(!empty($app_settings->android_url) || !empty($app_settings->ios_url) || !empty($app_settings->android_tv)){ ?>
              <h5 class="font-weight-bold mb-0  ">Download App</h5>
          <?php } ?>

          <div class=" small m-0 text-white ">
             <div class="map1">
              <?php if(!empty($app_settings->android_url)){ ?>
               <a href="<?= $app_settings->android_url ?>">
                  <img src="<?php echo URL::to('/assets/img/apps1.webp') ?>" alt="App Icon" style="width: 100%; height: auto;">
               </a>

              <?php } ?>
              <?php if(!empty($app_settings->ios_url)){ ?>
               <a href="<?= $app_settings->ios_url ?>">
                  <img src="<?php echo  URL::to('/assets/img/apps.webp')?>" alt="App Icon" style="width: 100%; height: auto;">
               </a>
              <?php } ?>
              <?php if(!empty($app_settings->android_tv)){ ?>
               <a href="<?= $app_settings->android_tv ?>">
                  <img src="<?php echo  URL::to('/assets/img/and.webp')?>" alt="App Icon" style="width: 100%; height: auto;">
               </a>
              <?php } ?>
              </div>

            <!--  <p class="p-0 mr-3 mt-3">Questions? Call 000-800-123-123</p>-->
          </div>
          </div>
                                 <!-- signup End  -->




                                  <div class="mob-w">
                                    <?php
                        if(!Auth::guest()){
                        $ModeratorsUser = App\ModeratorsUser::where('email', Auth::User()->email)->first();
                        $Channel = App\Channel::where('email', Auth::User()->email)->first();
                        }
                        if(!Auth::guest() && !empty($ModeratorsUser)){ ?>
                           <?php if($theme->enable_cpp_btn ==1): ?>
                              <div class="iq-search-bar ml-auto">
                                 <form method="POST" action="<?php echo URL::to('cpp/home') ?>" class="mt-4">
                                    <input type="hidden" name="_token" id= "token" value="<?= csrf_token() ?>">
                                    <input id="email" type="hidden"  name="email"  value="<?=  Auth::user()->email ?>"  autocomplete="email" autofocus>
                                    <input id="password" type="hidden"  name="password" value="<?=  @$ModeratorsUser->password ?>" autocomplete="current-password" >
                                    <button type="submit" class="btn btn-primary " style="margin-top: 0%;margin-left: 5%;"><?php echo (__('Visit CPP Portal'));?></button>
                                 </form>
                              </div>
                           <?php endif; ?>
                     <?php }if(!Auth::guest() && !empty($Channel)){ ?>
                        <?php if($theme->enable_channel_btn ==1): ?>
                           <div class="iq-search-bar ml-auto">
                              <form method="POST" action="<?php echo URL::to('channel/home') ?>" class="mt-4">
                                 <input type="hidden" name="_token" id= "token" value="<?= csrf_token() ?>">
                                 <input id="email" type="hidden"  name="email"  value="<?=  Auth::user()->email ?>"  autocomplete="email" autofocus>
                                 <input id="password" type="hidden"  name="password" value="<?=  @$Channel->unhased_password ?>" autocomplete="current-password" >
                                 <button type="submit" class="btn btn-primary" style="margin-top: 0%;margin-left: 5%;"><?php echo (__('Visit Channel Portal'));?>  </button>
                              </form>
                           </div>
                        <?php endif; ?>
                     <?php } ?></div>

                           </ul>
                        </div>
                     </div>
                     <div class="mobile-more-menu">
                        <button class="more-toggle" id="dropdownMenuButton" aria-label="More Option Button" data-toggle="more-toggle" aria-haspopup="true" aria-expanded="false" style="background-color: transparent; border: none;">
                           <i class="ri-search-line"></i>
                        </button>
                        <div class="more-menu" aria-labelledby="dropdownMenuButton">
                           <div class="navbar-right position-relative">
                              <ul class="d-flex align-items-center justify-content-end list-inline m-0">
                                 <li class="hidden-xs">
                                    <div id="navbar-search-form">
                                    <form role="search" action="<?= route('searchResult') ?>" method="get">
                                       <div>
                                          <i class="fa fa-search"></i>
                                          <input type="text" name="search" class="searches" id="searches" autocomplete="off" placeholder="Type here to Search Videos">
                                       </div>
                                    </form>
                                    </div>
                                    <div id="search_list" class="search_list" style="position: absolute;">
                                    </div>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>



                      <div id="desk-top" class="d-flex align-items-center cppporrr">
                     <?php
                        if(!Auth::guest()){
                        $ModeratorsUser = App\ModeratorsUser::where('email', Auth::User()->email)->first();
                        $Channel = App\Channel::where('email', Auth::User()->email)->first();
                        }
                        if(!Auth::guest() && !empty($ModeratorsUser)){ ?>
                           <?php if($theme->enable_cpp_btn ==1): ?>
                              <div class="iq-search-bar ml-auto">
                                 <form method="POST" action="<?php echo URL::to('cpp/home') ?>" class="mt-4">
                                    <input type="hidden" name="_token" id= "token" value="<?= csrf_token() ?>">
                                    <input id="email" type="hidden"  name="email"  value="<?=  Auth::user()->email ?>"  autocomplete="email" autofocus>
                                    <input id="password" type="hidden"  name="password" value="<?=  @$ModeratorsUser->password ?>" autocomplete="current-password" >
                                    <button type="submit" class="btn bd " style="margin-top: -20%;margin-left: -14%;"><?php echo (__('Visit CPP Portal'));?> </button>
                                 </form>
                              </div>
                           <?php endif; ?>
                     <?php }if(!Auth::guest() && !empty($Channel)){ ?>
                        <?php if($theme->enable_channel_btn ==1): ?>
                           <div class="iq-search-bar ml-auto">
                              <form method="POST" action="<?php echo URL::to('channel/home') ?>" class="mt-4">
                                 <input type="hidden" name="_token" id= "token" value="<?= csrf_token() ?>">
                                 <input id="email" type="hidden"  name="email"  value="<?=  Auth::user()->email ?>"  autocomplete="email" autofocus>
                                 <input id="password" type="hidden"  name="password" value="<?=  @$Channel->unhased_password ?>" autocomplete="current-password" >
                                 <button type="submit" class="btn bd" style="margin-top: -17%;margin-left: -8%;"><?php echo (__('Visit Channel Portal'));?>  </button>
                              </form>
                           </div>
                        <?php endif; ?>
                     <?php } ?></div>
                     <div class="navbar-right menu-right pt-2">
                        <ul class="d-flex align-items-center list-inline m-0" style="gap:10px">
                           <li class="nav-item nav-icon" style="margin-right:5px;margin-bottom:5px;">
                              <a href="<?php echo URL::to('searchResult');?>" aria-label="search" class="search-toggle device-search">
                                 <i class="ri-search-line"></i>
                              </a>

                              <div class="search-box iq-search-bar d-search">
                                 <div class="searchbox">
                                    <div class="form-group position-relative">
                                       <input type="text" name="search" class="text search-input font-size-12 searches" autocomplete="off" placeholder="Type here to Search Videos" />
                                       <i class="search-link ri-search-line"></i>
                                       <?php  include 'public/themes/default/partials/Search_content.php'; ?>
                                    </div>
                                 </div>
                                  <div class="iq-sub-dropdown search_content overflow-auto" id="sidebar-scrollbar" >
                                 <div class="iq-card-body">
                                    <div id="search_list" class="search_list search-toggle device-search" >
                                    </div>
                                 </div>
                              </div>
                              </div>


                           </li>

                           <!-- <?php //if(!Auth::guest()){ ?> -->
                           <!-- Translator Choose -->
                           <?php if(@$theme->translate_checkout == 1){ ?>

                              <li class="nav-item nav-icon ml-2">
                                 <a href="#"  class="search-toggle active" aria-label="Toggle Search" data-toggle="search-toggle">
                                       <svg id="dropdown-icon" xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-translate" viewBox="0 0 16 16">
                                          <path d="M4.545 6.714 4.11 8H3l1.862-5h1.284L8 8H6.833l-.435-1.286H4.545zm1.634-.736L5.5 3.956h-.049l-.679 2.022H6.18z"/>
                                          <path d="M0 2a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v3h3a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-3H2a2 2 0 0 1-2-2V2zm2-1a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h7a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H2zm7.138 9.995c.193.301.402.583.63.846-.748.575-1.673 1.001-2.768 1.292.178.217.451.635.555.867 1.125-.359 2.08-.844 2.886-1.494.777.665 1.739 1.165 2.93 1.472.133-.254.414-.673.629-.890-1.125-.253-2.057-.694-2.820-1.284.681-.747 1.222-1.651 1.621-2.757H14V8h-3v1.047h.765c-.318.844-.740 1.546-1.272 2.13a6.066 6.066 0 0 1-.415-.492 1.988 1.988 0 0 1-.940.31z"/>
                                       </svg>

                                    <!-- <div class="dropdown-content" id="languageDropdown">
                                       <?php foreach($TranslationLanguage as $Language): ?>
                                          <a href="#" class="language-link" id="Language_code" data-Language-code= "<?= @$Language->code ?>"><?= @$Language->name ?></a>
                                       <?php endforeach; ?>
                                    </div> -->

                                 </a>

                                 <div class="iq-sub-dropdown transdropdownlist">
                                    <div class="iq-card shadow-none m-0" >
                                       <div class="iq-card-body " id="languageDropdown" >

                                          <input type="text" id="languageSearch" placeholder="Search languages">

                                          <?php foreach($TranslationLanguage as $Language): ?>
                                          <a href="#" class="language-link iq-sub-card" id="Language_code" data-Language-code= "<?= @$Language->code ?>"><?= @$Language->name ?>
                                             <?php if($GetWebsiteName.$Language->code == $GetWebsiteName.$website_default_language) { ?> <span class="selected-icon" >✔</span> <?php } ?>
                                          </a>
                                          <?php endforeach; ?>
                                          <!-- <a href="#" class="iq-sub-card">
                                             <div class="media align-items-center">
                                                <img src="assets/images/notify/thumb-3.jpg" class="img-fluid mr-3" alt="streamit">
                                                <div class="media-body">
                                                   <h6 class="mb-0 ">The Hero Camp</h6>
                                                   <small class="font-size-12">1 hour ago</small>
                                                </div>
                                             </div>
                                          </a> -->
                                       </div>
                                    </div>
                                 </div>
                              </li>
                           <?php } ?>

                           <!-- <?php // } ?> -->

                           <!-- <li class="nav-item nav-icon"> -->

                              <!-- <?php if(@$theme->translate_checkout == 1){ ?> -->
                              <!--  <svg id="dropdown-icon" xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-translate" viewBox="0 0 16 16">
                                 <path d="M4.545 6.714 4.11 8H3l1.862-5h1.284L8 8H6.833l-.435-1.286H4.545zm1.634-.736L5.5 3.956h-.049l-.679 2.022H6.18z"/>
                                 <path d="M0 2a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v3h3a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-3H2a2 2 0 0 1-2-2V2zm2-1a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h7a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H2zm7.138 9.995c.193.301.402.583.63.846-.748.575-1.673 1.001-2.768 1.292.178.217.451.635.555.867 1.125-.359 2.08-.844 2.886-1.494.777.665 1.739 1.165 2.93 1.472.133-.254.414-.673.629-.890-1.125-.253-2.057-.694-2.820-1.284.681-.747 1.222-1.651 1.621-2.757H14V8h-3v1.047h.765c-.318.844-.740 1.546-1.272 2.13a6.066 6.066 0 0 1-.415-.492 1.988 1.988 0 0 1-.940.31z"/>
                              </svg>
                              <div class="dropdown-content" id="languageDropdown">
                              <?php foreach($TranslationLanguage as $Language): ?>
                                 <a href="#" class="language-link" id="Language_code" data-Language-code= "<?= @$Language->code ?>"><?= @$Language->name ?></a>
                              <?php endforeach; ?>
                              </div> -->
                              <!-- <?php } ?> -->
                              <!-- <svg id="dropdown-icon" style="position: absolute; height: 50px; bottom:4px; width: 9%; " xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-translate" viewBox="0 0 16 16">
                                 <path d="M4.545 6.714 4.11 8H3l1.862-5h1.284L8 8H6.833l-.435-1.286H4.545zm1.634-.736L5.5 3.956h-.049l-.679 2.022H6.18z"/>
                                 <path d="M0 2a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v3h3a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-3H2a2 2 0 0 1-2-2V2zm2-1a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h7a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H2zm7.138 9.995c.193.301.402.583.63.846-.748.575-1.673 1.001-2.768 1.292.178.217.451.635.555.867 1.125-.359 2.08-.844 2.886-1.494.777.665 1.739 1.165 2.93 1.472.133-.254.414-.673.629-.890-1.125-.253-2.057-.694-2.820-1.284.681-.747 1.222-1.651 1.621-2.757H14V8h-3v1.047h.765c-.318.844-.740 1.546-1.272 2.13a6.066 6.066 0 0 1-.415-.492 1.988 1.988 0 0 1-.940.31z"/>
                              </svg>

                           </li> -->
                           <?php if(Auth::guest()): ?>
                              <?php if( $theme->signin_header == 1 ): ?>
                                 <li class="nav-item nav-icon">
                                    <!-- <img src="<?php echo URL::to('/').'/public/uploads/avatars/lockscreen-user.png' ?>" width="40" height="40" class="img-fluid avatar-40 rounded-circle" alt="user">-->
                                    <a href="<?php echo URL::to('login') ?>" class="iq-sub-card">
                                       <div class="media align-items-center">
                                          <div class="right-icon">
                                             <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" x="0" y="0" width="45" height="45" viewBox="0 0 70 70" style="enable-background:new 0 0 70 70" xml:space="preserve">
                                                <path class="st5" d="M13.4 33.7c0 .5.2.9.5 1.2.3.3.8.5 1.2.5h22.2l-4 4.1c-.4.3-.6.8-.6 1.3s.2 1 .5 1.3c.3.3.8.5 1.3.5s1-.2 1.3-.6l7.1-7.1c.7-.7.7-1.8 0-2.5l-7.1-7.1c-.7-.6-1.7-.6-2.4.1s-.7 1.7-.1 2.4l4 4.1H15.2c-1 .1-1.8.9-1.8 1.8z"/>
                                                <path class="st5" d="M52.3 17.8c0-1.4-.6-2.8-1.6-3.7-1-1-2.3-1.6-3.7-1.6H27.5c-1.4 0-2.8.6-3.7 1.6-1 1-1.6 2.3-1.6 3.7v7.1c0 1 .8 1.8 1.8 1.8s1.8-.8 1.8-1.8v-7.1c0-1 .8-1.8 1.8-1.8H47c.5 0 .9.2 1.2.5.3.3.5.8.5 1.2v31.8c0 .5-.2.9-.5 1.2-.3.3-.8.5-1.2.5H27.5c-1 0-1.8-.8-1.8-1.8v-7.1c0-1-.8-1.8-1.8-1.8s-1.8.8-1.8 1.8v7.1c0 1.4.6 2.8 1.6 3.7 1 1 2.3 1.6 3.7 1.6H47c1.4 0 2.8-.6 3.7-1.6 1-1 1.6-2.3 1.6-3.7V17.8z"/>
                                             </svg>
                                          </div>
                                          <div class="media-body">
                                             <h6 class="mb-0 "><?php echo (__('Signin'));?></h6>
                                          </div>
                                       </div>
                                    </a>
                                 </li>

                                 <li class="nav-item nav-icon">
                                    <a href="<?php echo URL::to('signup') ?>" class="iq-sub-card">
                                       <div class="media align-items-center">
                                          <div class="right-icon">
                                             <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" x="0" y="0" width="45" height="45" viewBox="0 0 70 70" style="enable-background:new 0 0 70 70" xml:space="preserve">
                                                <path class="st6" d="M53.4 33.7H30.7M36.4 28.1l-5.7 5.7 5.7 5.7"/>
                                                <path class="st6" d="M50.5 43.7c-2.1 3.4-5.3 5.9-9.1 7.3-3.7 1.4-7.8 1.6-11.7.4a18.4 18.4 0 0 1-9.6-28.8c2.4-3.2 5.8-5.5 9.6-6.6 3.8-1.1 7.9-1 11.7.4 3.7 1.4 6.9 4 9.1 7.3"/>
                                             </svg>
                                          </div>
                                          <div class="media-body">
                                             <h6 class="mb-0 "><?php echo (__('Signup'));?></h6>
                                          </div>
                                       </div>
                                    </a>
                                 </li>
                              <?php endif ; ?>
                           <?php else: ?>
                           <li class="nav-item nav-icon">
                              <a href="#" class="iq-user-dropdown  search-toggle p-0 d-flex align-items-center"
                                 data-toggle="search-toggle">
                                <!-- <img src="<?php echo URL::to('/').'/public/uploads/avatars/' . Auth::user()->avatar ?>" class="img-fluid avatar-40 rounded-circle" alt="user">-->
                                 <p class="mt-3" style="font-size: 14px;">
                                    <?php
                                       $subuser=Session::get('subuser_id');
                                       if($subuser != '' && $subuser != null){
                                          $subuser=App\Multiprofile::where('id',$subuser)->first();
                                         echo  $subuser->user_name  ;
                                       }
                                       else{
                                         echo Auth::user()->username.' '  ;
                                       }

                                       ?>
                                    <i class="ri-arrow-down-s-line"></i>
                                 </p>
                              </a>
                              <?php if(Auth::user()->role == 'registered'): ?>
                              <div class="iq-sub-dropdown iq-user-dropdown">
                                 <div class="iq-card shadow-none m-0">
                                    <div class="iq-card-body p-0 pl-3 pr-3">
                                       <!-- dark mode -->
                                       <div class="toggle mt-2 ">
                                          <i class="fas fa-moon"></i>
                                          <label class="switch toggle mt-3">
                                          <input type="checkbox" id="toggle"  value=<?php echo $theme_mode;  ?>  <?php if($theme_mode == "light") { echo 'checked' ; } ?> />
                                          <span class="sliderk round"></span>
                                          </label>  <i class="fas fa-sun"></i>
                                       </div>
                                       <a href="<?php echo  URL::to('myprofile') ?>" class="iq-sub-card setting-dropdown">
                                          <div class="media align-items-center">
                                             <div class="right-icon">
                                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                   viewBox="0 0 70 70" style="enable-background:new 0 0 70 70;" xml:space="preserve">
                                                   <style type="text/css">
                                                   </style>
                                                   <path class="st0" d="M32,34c-7.4,0-13.4-6-13.4-13.4S24.6,7.1,32,7.1s13.4,6,13.4,13.4S39.4,34,32,34z M32,10.5
                                                      c-5.6,0-10.1,4.5-10.1,10.1S26.4,30.7,32,30.7s10.1-4.5,10.1-10.1S37.6,10.5,32,10.5z"/>
                                                   <path class="st0" d="M38.5,54.2H15.3l0,0v-2.8c0-9,6.8-16.7,15.8-17.2c4.3-0.3,8.4,1.1,11.5,3.6c0.1,0.1,0.3,0.1,0.4,0l1.8-1.8
                                                      c0.3-0.3,0.3-0.5,0.1-0.6c-3.8-3.1-8.6-4.8-13.9-4.5c-10.7,0.6-19,9.9-19,20.6v5.1c0,0.6,0.5,1.1,1.1,1.1h28.8c0.5,0,0.8-0.6,0.4-1
                                                      l-1.4-1.4C40.2,54.5,39.3,54.2,38.5,54.2z"/>
                                                   <path class="st0" d="M62.2,48.6v-2.4c0-0.3-0.2-0.5-0.5-0.5H59c-0.2,0-0.4-0.1-0.5-0.4c-0.1-0.4-0.3-0.7-0.4-1.1
                                                      C58,44,58,43.8,58.2,43.6l1.9-1.9c0.2-0.2,0.2-0.5,0-0.7l-1.7-1.7c-0.2-0.2-0.5-0.2-0.7,0l-2,2c-0.2,0.2-0.4,0.2-0.6,0.1
                                                      c-0.3-0.2-0.7-0.3-1-0.4c-0.2-0.1-0.4-0.3-0.4-0.5v-2.8c0-0.3-0.2-0.5-0.5-0.5h-2.4c-0.3,0-0.5,0.2-0.5,0.5v2.8
                                                      c0,0.2-0.1,0.4-0.4,0.5c-0.4,0.1-0.7,0.2-1,0.4c-0.2,0.1-0.4,0.1-0.6-0.1l-2-2c-0.2-0.2-0.5-0.2-0.7,0L43.9,41
                                                      c-0.2,0.2-0.2,0.5,0,0.7l1.9,1.9c0.2,0.2,0.2,0.4,0.1,0.6c-0.2,0.3-0.3,0.7-0.4,1.1c-0.1,0.2-0.3,0.4-0.5,0.4h-2.7
                                                      c-0.3,0-0.5,0.2-0.5,0.5v2.4c0,0.3,0.2,0.5,0.5,0.5H45c0.2,0,0.4,0.1,0.5,0.4c0.1,0.4,0.3,0.7,0.4,1c0.1,0.2,0.1,0.4-0.1,0.6
                                                      L44.1,53c-0.2,0.2-0.2,0.5,0,0.7l1.7,1.7c0.2,0.2,0.5,0.2,0.7,0l1.9-1.9c0.2-0.2,0.4-0.2,0.6-0.1c0.3,0.2,0.7,0.3,1.1,0.4
                                                      c0.2,0.1,0.4,0.3,0.4,0.5V57c0,0.3,0.2,0.5,0.5,0.5h2.4c0.3,0,0.5-0.2,0.5-0.5v-2.7c0-0.2,0.1-0.4,0.4-0.5c0.4-0.1,0.7-0.3,1-0.4
                                                      c0.2-0.1,0.4-0.1,0.6,0.1l1.9,1.9c0.2,0.2,0.5,0.2,0.7,0l1.7-1.7c0.2-0.2,0.2-0.5,0-0.7l-1.9-1.9c-0.2-0.2-0.2-0.4-0.1-0.6
                                                      c0.2-0.3,0.3-0.7,0.4-1c0.1-0.2,0.3-0.4,0.5-0.4h2.7C62,49.1,62.2,48.9,62.2,48.6z M48.7,47.4c0-0.9,0.4-1.7,1-2.4
                                                      c0.6-0.6,1.5-1,2.4-1s1.7,0.4,2.4,1c0.6,0.6,1,1.5,1,2.4c0,1.7-1.2,3.2-3.3,3.5c-0.1,0-0.1,0-0.2,0C50,50.6,48.7,49.1,48.7,47.4
                                                      L48.7,47.4z"/>
                                                </svg>
                                             </div>
                                             <div class="media-body ml-3">
                                                <h6 class="mb-0 "><?php echo (__('Manage Account'));?></h6>
                                             </div>
                                          </div>
                                       </a>
                                       <?php if($AdminOTPCredentials == 0){ ?>
                                          <a href="<?php echo  URL::to('change-profile') ?>" class="iq-sub-card setting-dropdown">
                                             <div class="media align-items-center" style="padding-left: 6px;">
                                                <div class="right-icon">
                                                   <svg version="1.1" id="Layer_1" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                      <style>.st0{}</style>
                                                      <path class="st0" d="M12.8563 0C9.31855 0 6.42773 2.89086 6.42773 6.42859C6.42773 9.96631 9.31855 12.8572 12.8563 12.8572C16.394 12.8572 19.2849 9.96631 19.2849 6.42859C19.2849 2.89086 16.394 0 12.8563 0ZM12.8563 2.14286C15.2359 2.14286 17.142 4.04895 17.142 6.42859C17.142 8.80822 15.2359 10.7143 12.8563 10.7143C10.4767 10.7143 8.57059 8.80822 8.57059 6.42859C8.57059 4.04895 10.4767 2.14286 12.8563 2.14286Z" fill="black"/>
                                                      <path class="st0" d="M9.64285 15.0002C4.31925 15.0002 0 19.3195 0 24.6431V26.786C2.83825e-05 27.0701 0.11292 27.3426 0.313845 27.5435C0.514771 27.7445 0.787276 27.8574 1.07143 27.8574H12.694C12.8359 27.8594 12.9769 27.8332 13.1086 27.7802C13.2404 27.7273 13.3603 27.6487 13.4614 27.549C13.5625 27.4493 13.6428 27.3305 13.6976 27.1995C13.7524 27.0685 13.7806 26.9279 13.7806 26.786C13.7806 26.644 13.7524 26.5034 13.6976 26.3724C13.6428 26.2414 13.5625 26.1226 13.4614 26.0229C13.3603 25.9232 13.2404 25.8446 13.1086 25.7917C12.9769 25.7388 12.8359 25.7125 12.694 25.7145H2.14285V24.6431C2.14285 20.4695 5.46932 17.1431 9.64285 17.1431H13.9453C14.0872 17.1451 14.2282 17.1188 14.36 17.0659C14.4917 17.013 14.6116 16.9344 14.7127 16.8347C14.8138 16.735 14.8941 16.6162 14.9489 16.4852C15.0037 16.3542 15.0319 16.2136 15.0319 16.0716C15.0319 15.9296 15.0037 15.7891 14.9489 15.6581C14.8941 15.5271 14.8138 15.4083 14.7127 15.3086C14.6116 15.2089 14.4917 15.1303 14.36 15.0774C14.2282 15.0244 14.0872 14.9982 13.9453 15.0002H9.64285Z" fill="black"/>
                                                      <path class="st0" d="M24.17 23.9297C23.673 23.9297 23.27 24.3327 23.27 24.8297C23.27 25.8487 22.441 26.6767 21.422 26.6767H17.072C17.418 26.3247 17.417 25.7597 17.068 25.4097C16.716 25.0577 16.147 25.0577 15.795 25.4097L14.264 26.9397C14.095 27.1087 14 27.3367 14 27.5767C14 27.8147 14.095 28.0447 14.263 28.2137L15.794 29.7447C15.97 29.9207 16.2 30.0087 16.431 30.0087C16.662 30.0087 16.891 29.9207 17.067 29.7447C17.417 29.3947 17.417 28.8287 17.071 28.4767H21.422C23.434 28.4767 25.07 26.8397 25.07 24.8297C25.07 24.3337 24.667 23.9297 24.17 23.9297Z" fill="black"/>
                                                      <path class="st0" d="M17.648 19.531C15.636 19.531 14 21.168 14 23.179C14 23.676 14.403 24.079 14.9 24.079C15.397 24.079 15.8 23.676 15.8 23.179C15.8 22.16 16.629 21.331 17.648 21.331H21.999C21.653 21.683 21.654 22.249 22.003 22.599C22.179 22.775 22.409 22.863 22.639 22.863C22.869 22.863 23.1 22.775 23.276 22.599L24.807 21.068C24.975 20.899 25.07 20.67 25.07 20.431C25.07 20.192 24.975 19.963 24.806 19.794L23.275 18.264C22.923 17.912 22.354 17.912 22.002 18.264C21.653 18.614 21.652 19.179 21.998 19.531H17.648Z" fill="black"/>
                                                   </svg>

                                                </div>
                                                <div class="media-body ml-3">
                                                   <h6 class="mb-0 "><?php echo (__('Change Profile'));?></h6>
                                                </div>
                                             </div>
                                          </a>
                                       <?php } ?>
                                       <a href="<?php echo URL::to('watchlater_list') ?>" class="iq-sub-card setting-dropdown">
                                          <div class="media align-items-center">
                                             <div class="right-icon">
                                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" x="0" y="0" viewBox="0 0 70 70" style="enable-background:new 0 0 70 70" xml:space="preserve">
                                                   <style>.st0{fill:#198fcf;stroke:#198fcf;stroke-width:0;stroke-miterlimit:10}</style>
                                                   <path class="st0" d="M21.5 23.7h14c.2 0 .3.2.3.4v.8c0 .2-.1.4-.3.4h-14c-.2 0-.3-.2-.3-.4V24c0-.1.2-.3.3-.3zM21.5 32h13.4c.2 0 .3.2.3.4v.8c0 .2-.1.4-.3.4H21.5c-.2 0-.3-.2-.3-.4v-.8c0-.2.2-.4.3-.4zM21.5 40.3h23.1c.2 0 .3.2.3.4v.8c0 .2-.1.4-.3.4H21.5c-.2 0-.3-.2-.3-.4v-.7c0-.3.2-.5.3-.5zM21.5 48.7h23.1c.2 0 .3.2.3.4v.8c0 .2-.1.4-.3.4H21.5c-.2 0-.3-.2-.3-.4v-.8c0-.3.2-.4.3-.4z"/>
                                                   <path class="st1" d="M48.4 37c-5.1 0-9.2-4.1-9.2-9.2s4.1-9.2 9.2-9.2 9.2 4.1 9.2 9.2-4.1 9.2-9.2 9.2zm0-16.7c-4.2 0-7.5 3.3-7.5 7.5s3.3 7.5 7.5 7.5 7.5-3.3 7.5-7.5-3.3-7.5-7.5-7.5z" style="fill:#198fcf;stroke:#198fcf;stroke-width:.5;stroke-miterlimit:10"/>
                                                   <path class="st2" d="M52.1 28.7h-3.8c-.4 0-.7-.3-.7-.7v-3.8c0-.2.2-.4.4-.4h.8c.2 0 .4.2.4.4v2.2c0 .4.3.7.7.7h2.2c.2 0 .4.2.4.4v.8c.1.2-.1.4-.4.4z" style="fill:#198fcf"/>
                                                   <path class="st3" d="M54.3 34v20.1c0 1-.8 1.9-1.9 1.9H17.3c-1 0-1.9-.8-1.9-1.9V17.5c0-1 .8-1.9 1.9-1.9h35.1c1 0 1.9.8 1.9 1.9v4.2" style="fill:none;stroke:#198fcf;stroke-width:2;stroke-miterlimit:10"/>
                                                </svg>
                                             </div>
                                             <div class="media-body ml-3">
                                                <h6 class="mb-0 "><?php echo (__('Watch Later'));?></h6>
                                             </div>
                                          </div>
                                       </a>
                                       <a href="<?php echo URL::to('wishlist_list') ?>" class="iq-sub-card setting-dropdown">
                                          <div class="media align-items-center">
                                             <div class="right-icon">
                                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                   viewBox="0 0 70 70" style="enable-background:new 0 0 70 70;" xml:space="preserve">
                                                   <style type="text/css">
                                                      .st0{}
                                                   </style>
                                                   <g>
                                                      <path class="st0" d="M20.9,18.3h-1.2c-0.7,0-1.2-0.5-1.2-1.2s0.5-1.2,1.2-1.2h1.2c0.7,0,1.2,0.5,1.2,1.2S21.5,18.3,20.9,18.3z"/>
                                                      <path class="st0" d="M43.5,18.3H25.6c-0.7,0-1.2-0.5-1.2-1.2s0.5-1.2,1.2-1.2h17.9c0.7,0,1.2,0.5,1.2,1.2S44.1,18.3,43.5,18.3z"/>
                                                      <path class="st0" d="M20.9,25.4h-1.2c-0.7,0-1.2-0.5-1.2-1.2S19,23,19.7,23h1.2c0.7,0,1.2,0.5,1.2,1.2S21.5,25.4,20.9,25.4z"/>
                                                      <path class="st0" d="M43.5,25.4H25.6c-0.7,0-1.2-0.5-1.2-1.2s0.5-1.2,1.2-1.2h17.9c0.7,0,1.2,0.5,1.2,1.2S44.1,25.4,43.5,25.4z"/>
                                                      <path class="st0" d="M20.9,32.5h-1.2c-0.7,0-1.2-0.5-1.2-1.2s0.5-1.2,1.2-1.2h1.2c0.7,0,1.2,0.5,1.2,1.2S21.5,32.5,20.9,32.5z"/>
                                                      <path class="st0" d="M43.5,32.5H25.6c-0.7,0-1.2-0.5-1.2-1.2s0.5-1.2,1.2-1.2h17.9c0.7,0,1.2,0.5,1.2,1.2S44.1,32.5,43.5,32.5z"/>
                                                      <path class="st0" d="M20.9,39.7h-1.2c-0.7,0-1.2-0.5-1.2-1.2s0.5-1.2,1.2-1.2h1.2c0.7,0,1.2,0.5,1.2,1.2S21.5,39.7,20.9,39.7z"/>
                                                      <path class="st0" d="M43.5,39.7H25.6c-0.7,0-1.2-0.5-1.2-1.2s0.5-1.2,1.2-1.2h17.9c0.7,0,1.2,0.5,1.2,1.2S44.1,39.7,43.5,39.7z"/>
                                                      <path class="st0" d="M20.9,46.8h-1.2c-0.7,0-1.2-0.5-1.2-1.2s0.5-1.2,1.2-1.2h1.2c0.7,0,1.2,0.5,1.2,1.2S21.5,46.8,20.9,46.8z"/>
                                                      <path class="st0" d="M56.7,42.9c-1.5-1.5-3.5-2.2-5.5-2.2c-0.3,0-0.5-0.2-0.5-0.5V8.7c0-0.3-0.1-0.6-0.3-0.8s-0.5-0.3-0.8-0.3H13.5
                                                         c-0.6,0-1,0.4-1,1V54c0,0.3,0.1,0.6,0.3,0.8s0.5,0.3,0.8,0.3H39c0.1,0,0.3,0.1,0.4,0.1l6.8,6.8c0.5,0.5,1.2,0.5,1.7,0l8.8-8.8l0,0
                                                         c1.4-1.4,2.2-3.3,2.2-5.2C58.8,46.1,58.1,44.2,56.7,42.9L56.7,42.9z M36.2,44.4H25.6c-0.7,0-1.2,0.5-1.2,1.2s0.5,1.2,1.2,1.2h9.7
                                                         c-0.1,0.4-0.1,0.9-0.1,1.3c0,1.4,0.4,2.7,1.1,3.9c0.2,0.3,0,0.8-0.4,0.8c-3.8,0-17.7,0-20.5,0c-0.3,0-0.5-0.2-0.5-0.5V10.4
                                                         c0-0.3,0.2-0.5,0.5-0.5h32.3c0.3,0,0.5,0.2,0.5,0.5v30.7c0,0.2-0.1,0.3-0.3,0.4c-0.3,0.2-0.6,0.4-0.9,0.6c-1.7-1.3-3.9-1.7-5.9-1.3
                                                         C39,41.3,37.3,42.6,36.2,44.4L36.2,44.4z M55,51.6l-7.6,7.6c-0.2,0.2-0.5,0.2-0.7,0l-7.6-7.6l0,0c-1.3-1.3-1.8-3.1-1.3-4.9
                                                         c0.5-1.7,1.8-3.1,3.6-3.6c2-0.5,4.1,0.2,5.3,1.8c0.2,0.3,0.6,0.3,0.8,0c1.3-1.7,3.4-2.4,5.3-1.8c1.7,0.5,3.1,1.8,3.6,3.6
                                                         C56.8,48.5,56.3,50.4,55,51.6L55,51.6z"/>
                                                   </g>
                                                </svg>
                                             </div>
                                             <div class="media-body ml-3">
                                                <h6 class="mb-0 "><?php echo (__('My Wishlist'));?></h6>
                                             </div>
                                          </div>
                                       </a>
                                       <a href="<?php echo URL::to('purchased-media') ?>" class="iq-sub-card setting-dropdown">
                                          <div class="media align-items-center">
                                             <div class="right-icon">
                                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                   viewBox="0 0 70 70" style="enable-background:new 0 0 70 70;" xml:space="preserve">
                                                   <style type="text/css">
                                                      .st0{stroke-width:0.5;stroke-miterlimit:10;}
                                                   </style>
                                                   <g>
                                                      <path class="st0" d="M45.8,28.7c-0.5,0-0.9-0.4-0.9-0.9V17.5c0-2.4-1.9-4.3-4.3-4.3H30.2c-2.4,0-4.3,1.9-4.3,4.3v10.4
                                                         c0,0.5-0.4,0.9-0.9,0.9s-0.9-0.4-0.9-0.9V17.5c0-3.3,2.7-6,6-6h10.4c3.3,0,6,2.7,6,6v10.4C46.6,28.4,46.2,28.7,45.8,28.7z"/>
                                                      <path class="st0" d="M42.3,23.6H28.5c-0.5,0-0.9-0.4-0.9-0.9s0.4-0.9,0.9-0.9h13.8c0.5,0,0.9,0.4,0.9,0.9
                                                         C43.2,23.2,42.8,23.6,42.3,23.6L42.3,23.6z"/>
                                                      <path class="st0" d="M54.4,52.9h-37c-1,0-1.9-0.8-1.9-1.9V23.7c0-1,0.8-1.9,1.9-1.9h4.2c0.5,0,0.9,0.4,0.9,0.9s-0.4,0.9-0.9,0.9
                                                         h-3.3c-0.6,0-1,0.5-1,1v25.6c0,0.6,0.5,1,1,1h34.2c0.6,0,1-0.5,1-1V24.6c0-0.6-0.5-1-1-1h-3.3c-0.5,0-0.9-0.4-0.9-0.9
                                                         s0.4-0.9,0.9-0.9h4.2c1,0,1.9,0.8,1.9,1.9V52C55.3,52.5,54.9,52.9,54.4,52.9L54.4,52.9z"/>
                                                      <path class="st0" d="M30.2,46c-0.2,0-0.3,0-0.4-0.1c-0.3-0.2-0.4-0.4-0.4-0.7V31.3c0-0.3,0.2-0.6,0.4-0.7c0.3-0.2,0.6-0.2,0.9,0
                                                         l12.1,6.9c0.3,0.2,0.4,0.4,0.4,0.7s-0.2,0.6-0.4,0.7l-12.1,6.9C30.5,46,30.4,46,30.2,46L30.2,46z M31.1,32.8v10.8l9.5-5.4
                                                         L31.1,32.8z"/>
                                                   </g>
                                                </svg>
                                             </div>
                                             <div class="media-body ml-3">
                                                <h6 class="mb-0 "><?php echo (__('Purchased Medias'));?></h6>
                                             </div>
                                          </div>
                                       </a>
                                       <!-- <a href="<?php echo URL::to('my-playlist') ?>" class="iq-sub-card setting-dropdown">
                                          <div class="media align-items-center">
                                             <div class="right-icon">
                                             <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                   viewBox="0 0 70 70" style="enable-background:new 0 0 70 70;" xml:space="preserve">
                                                   <style type="text/css">
                                                      .st0{stroke-width:0.5;stroke-miterlimit:10;}
                                                   </style>
                                                   <g>
                                                      <path class="st0" d="M45.8,28.7c-0.5,0-0.9-0.4-0.9-0.9V17.5c0-2.4-1.9-4.3-4.3-4.3H30.2c-2.4,0-4.3,1.9-4.3,4.3v10.4
                                                         c0,0.5-0.4,0.9-0.9,0.9s-0.9-0.4-0.9-0.9V17.5c0-3.3,2.7-6,6-6h10.4c3.3,0,6,2.7,6,6v10.4C46.6,28.4,46.2,28.7,45.8,28.7z"/>
                                                      <path class="st0" d="M42.3,23.6H28.5c-0.5,0-0.9-0.4-0.9-0.9s0.4-0.9,0.9-0.9h13.8c0.5,0,0.9,0.4,0.9,0.9
                                                         C43.2,23.2,42.8,23.6,42.3,23.6L42.3,23.6z"/>
                                                      <path class="st0" d="M54.4,52.9h-37c-1,0-1.9-0.8-1.9-1.9V23.7c0-1,0.8-1.9,1.9-1.9h4.2c0.5,0,0.9,0.4,0.9,0.9s-0.4,0.9-0.9,0.9
                                                         h-3.3c-0.6,0-1,0.5-1,1v25.6c0,0.6,0.5,1,1,1h34.2c0.6,0,1-0.5,1-1V24.6c0-0.6-0.5-1-1-1h-3.3c-0.5,0-0.9-0.4-0.9-0.9
                                                         s0.4-0.9,0.9-0.9h4.2c1,0,1.9,0.8,1.9,1.9V52C55.3,52.5,54.9,52.9,54.4,52.9L54.4,52.9z"/>
                                                      <path class="st0" d="M30.2,46c-0.2,0-0.3,0-0.4-0.1c-0.3-0.2-0.4-0.4-0.4-0.7V31.3c0-0.3,0.2-0.6,0.4-0.7c0.3-0.2,0.6-0.2,0.9,0
                                                         l12.1,6.9c0.3,0.2,0.4,0.4,0.4,0.7s-0.2,0.6-0.4,0.7l-12.1,6.9C30.5,46,30.4,46,30.2,46L30.2,46z M31.1,32.8v10.8l9.5-5.4
                                                         L31.1,32.8z"/>
                                                   </g>
                                                </svg>
                                             </div>
                                             <div class="media-body ml-3">
                                                <h6 class="mb-0 ">My Playlist</h6>
                                             </div>
                                          </div>
                                       </a>
                                       <a href="<?php echo URL::to('my-music-station') ?>" class="iq-sub-card setting-dropdown">
                                          <div class="media align-items-center">
                                             <div class="right-icon">
                                             <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                   viewBox="0 0 70 70" style="enable-background:new 0 0 70 70;" xml:space="preserve">
                                                   <style type="text/css">
                                                      .st0{stroke-width:0.5;stroke-miterlimit:10;}
                                                   </style>
                                                   <g>
                                                      <path class="st0" d="M45.8,28.7c-0.5,0-0.9-0.4-0.9-0.9V17.5c0-2.4-1.9-4.3-4.3-4.3H30.2c-2.4,0-4.3,1.9-4.3,4.3v10.4
                                                         c0,0.5-0.4,0.9-0.9,0.9s-0.9-0.4-0.9-0.9V17.5c0-3.3,2.7-6,6-6h10.4c3.3,0,6,2.7,6,6v10.4C46.6,28.4,46.2,28.7,45.8,28.7z"/>
                                                      <path class="st0" d="M42.3,23.6H28.5c-0.5,0-0.9-0.4-0.9-0.9s0.4-0.9,0.9-0.9h13.8c0.5,0,0.9,0.4,0.9,0.9
                                                         C43.2,23.2,42.8,23.6,42.3,23.6L42.3,23.6z"/>
                                                      <path class="st0" d="M54.4,52.9h-37c-1,0-1.9-0.8-1.9-1.9V23.7c0-1,0.8-1.9,1.9-1.9h4.2c0.5,0,0.9,0.4,0.9,0.9s-0.4,0.9-0.9,0.9
                                                         h-3.3c-0.6,0-1,0.5-1,1v25.6c0,0.6,0.5,1,1,1h34.2c0.6,0,1-0.5,1-1V24.6c0-0.6-0.5-1-1-1h-3.3c-0.5,0-0.9-0.4-0.9-0.9
                                                         s0.4-0.9,0.9-0.9h4.2c1,0,1.9,0.8,1.9,1.9V52C55.3,52.5,54.9,52.9,54.4,52.9L54.4,52.9z"/>
                                                      <path class="st0" d="M30.2,46c-0.2,0-0.3,0-0.4-0.1c-0.3-0.2-0.4-0.4-0.4-0.7V31.3c0-0.3,0.2-0.6,0.4-0.7c0.3-0.2,0.6-0.2,0.9,0
                                                         l12.1,6.9c0.3,0.2,0.4,0.4,0.4,0.7s-0.2,0.6-0.4,0.7l-12.1,6.9C30.5,46,30.4,46,30.2,46L30.2,46z M31.1,32.8v10.8l9.5-5.4
                                                         L31.1,32.8z"/>
                                                   </g>
                                                </svg>
                                             </div>
                                             <div class="media-body ml-3">
                                                <h6 class="mb-0 ">Music Station</h6>
                                             </div>
                                          </div>
                                       </a> -->
                                       <a href="<?php echo URL::to('logout') ?>" class="iq-sub-card setting-dropdown">
                                          <div class="media align-items-center">
                                             <div class="right-icon">
                                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" x="0" y="0" viewBox="0 0 70 70" style="enable-background:new 0 0 70 70" xml:space="preserve">
                                                   <path class="st6" d="M53.4 33.7H30.7M36.4 28.1l-5.7 5.7 5.7 5.7"/>
                                                   <path class="st6" d="M50.5 43.7c-2.1 3.4-5.3 5.9-9.1 7.3-3.7 1.4-7.8 1.6-11.7.4a18.4 18.4 0 0 1-9.6-28.8c2.4-3.2 5.8-5.5 9.6-6.6 3.8-1.1 7.9-1 11.7.4 3.7 1.4 6.9 4 9.1 7.3"/>
                                                </svg>
                                             </div>
                                             <div class="media-body ml-3">
                                                <h6 class="mb-0 "><?php echo (__('Logout'));?></h6>
                                             </div>
                                          </div>
                                       </a>
                                    </div>
                                 </div>
                              </div>
                              <?php else: ?>
                              <div class="iq-sub-dropdown iq-user-dropdown">
                                 <div class="iq-card shadow-none m-0">
                                    <div class="iq-card-body p-0 pl-3 pr-3">
                                       <a href="#" class="p-0">
                                          <!-- <div class="toggle mt-3 text-right">
                                             <input type="checkbox" id="toggle" />
                                             <label for="toggle"></label>
                                             </div> -->                                                  <!-- dark mode -->
                                          <div class="toggle mt-2 text-left">
                                             <i class="fas fa-moon"></i>
                                             <label class="switch toggle mt-3">
                                             <input type="checkbox" id="toggle"  value=<?php echo $theme_mode;  ?>
                                                <?php if($theme_mode == "light") { echo 'checked' ; } ?> />
                                             <span class="sliderk round"></span>
                                             </label>
                                             <i class="fas fa-sun"></i>
                                          </div>
                                       </a>
                                       <a href="<?php echo  URL::to('myprofile') ?>" class="iq-sub-card  setting-dropdown">
                                          <div class="media align-items-center">
                                             <div class="right-icon">
                                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                   viewBox="0 0 70 70" style="enable-background:new 0 0 70 70;" xml:space="preserve">
                                                   <style type="text/css">
                                                      .st0{}
                                                   </style>
                                                   <g>
                                                      <path class="st0" d="M32,34c-7.4,0-13.4-6-13.4-13.4S24.6,7.1,32,7.1s13.4,6,13.4,13.4S39.4,34,32,34z M32,10.5
                                                         c-5.6,0-10.1,4.5-10.1,10.1S26.4,30.7,32,30.7s10.1-4.5,10.1-10.1S37.6,10.5,32,10.5z"/>
                                                      <path class="st0" d="M38.5,54.2H15.3l0,0v-2.8c0-9,6.8-16.7,15.8-17.2c4.3-0.3,8.4,1.1,11.5,3.6c0.1,0.1,0.3,0.1,0.4,0l1.8-1.8
                                                         c0.3-0.3,0.3-0.5,0.1-0.6c-3.8-3.1-8.6-4.8-13.9-4.5c-10.7,0.6-19,9.9-19,20.6v5.1c0,0.6,0.5,1.1,1.1,1.1h28.8c0.5,0,0.8-0.6,0.4-1
                                                         l-1.4-1.4C40.2,54.5,39.3,54.2,38.5,54.2z"/>
                                                      <path class="st0" d="M62.2,48.6v-2.4c0-0.3-0.2-0.5-0.5-0.5H59c-0.2,0-0.4-0.1-0.5-0.4c-0.1-0.4-0.3-0.7-0.4-1.1
                                                         C58,44,58,43.8,58.2,43.6l1.9-1.9c0.2-0.2,0.2-0.5,0-0.7l-1.7-1.7c-0.2-0.2-0.5-0.2-0.7,0l-2,2c-0.2,0.2-0.4,0.2-0.6,0.1
                                                         c-0.3-0.2-0.7-0.3-1-0.4c-0.2-0.1-0.4-0.3-0.4-0.5v-2.8c0-0.3-0.2-0.5-0.5-0.5h-2.4c-0.3,0-0.5,0.2-0.5,0.5v2.8
                                                         c0,0.2-0.1,0.4-0.4,0.5c-0.4,0.1-0.7,0.2-1,0.4c-0.2,0.1-0.4,0.1-0.6-0.1l-2-2c-0.2-0.2-0.5-0.2-0.7,0L43.9,41
                                                         c-0.2,0.2-0.2,0.5,0,0.7l1.9,1.9c0.2,0.2,0.2,0.4,0.1,0.6c-0.2,0.3-0.3,0.7-0.4,1.1c-0.1,0.2-0.3,0.4-0.5,0.4h-2.7
                                                         c-0.3,0-0.5,0.2-0.5,0.5v2.4c0,0.3,0.2,0.5,0.5,0.5H45c0.2,0,0.4,0.1,0.5,0.4c0.1,0.4,0.3,0.7,0.4,1c0.1,0.2,0.1,0.4-0.1,0.6
                                                         L44.1,53c-0.2,0.2-0.2,0.5,0,0.7l1.7,1.7c0.2,0.2,0.5,0.2,0.7,0l1.9-1.9c0.2-0.2,0.4-0.2,0.6-0.1c0.3,0.2,0.7,0.3,1.1,0.4
                                                         c0.2,0.1,0.4,0.3,0.4,0.5V57c0,0.3,0.2,0.5,0.5,0.5h2.4c0.3,0,0.5-0.2,0.5-0.5v-2.7c0-0.2,0.1-0.4,0.4-0.5c0.4-0.1,0.7-0.3,1-0.4
                                                         c0.2-0.1,0.4-0.1,0.6,0.1l1.9,1.9c0.2,0.2,0.5,0.2,0.7,0l1.7-1.7c0.2-0.2,0.2-0.5,0-0.7l-1.9-1.9c-0.2-0.2-0.2-0.4-0.1-0.6
                                                         c0.2-0.3,0.3-0.7,0.4-1c0.1-0.2,0.3-0.4,0.5-0.4h2.7C62,49.1,62.2,48.9,62.2,48.6z M48.7,47.4c0-0.9,0.4-1.7,1-2.4
                                                         c0.6-0.6,1.5-1,2.4-1s1.7,0.4,2.4,1c0.6,0.6,1,1.5,1,2.4c0,1.7-1.2,3.2-3.3,3.5c-0.1,0-0.1,0-0.2,0C50,50.6,48.7,49.1,48.7,47.4
                                                         L48.7,47.4z"/>
                                                   </g>
                                                </svg>
                                             </div>
                                             <div class="media-body ml-3">
                                                <h6 class="mb-0 "><?php echo (__('Manage Account'));?></h6>
                                             </div>
                                          </div>
                                       </a>
                                       <?php if($AdminOTPCredentials == 0){ ?>
                                          <a href="<?php echo  URL::to('change-profile') ?>" class="iq-sub-card setting-dropdown">
                                             <div class="media align-items-center" style = "padding-left: 6px;">
                                                <div class="right-icon">
                                                   <svg version="1.1" id="Layer_1" viewBox="0 0 40 40 " fill="none" xmlns="http://www.w3.org/2000/svg">
                                                      <style>.st0{}</style>
                                                      <path class="st0" d="M12.8563 0C9.31855 0 6.42773 2.89086 6.42773 6.42859C6.42773 9.96631 9.31855 12.8572 12.8563 12.8572C16.394 12.8572 19.2849 9.96631 19.2849 6.42859C19.2849 2.89086 16.394 0 12.8563 0ZM12.8563 2.14286C15.2359 2.14286 17.142 4.04895 17.142 6.42859C17.142 8.80822 15.2359 10.7143 12.8563 10.7143C10.4767 10.7143 8.57059 8.80822 8.57059 6.42859C8.57059 4.04895 10.4767 2.14286 12.8563 2.14286Z" fill="black"/>
                                                      <path class="st0" d="M9.64285 15.0002C4.31925 15.0002 0 19.3195 0 24.6431V26.786C2.83825e-05 27.0701 0.11292 27.3426 0.313845 27.5435C0.514771 27.7445 0.787276 27.8574 1.07143 27.8574H12.694C12.8359 27.8594 12.9769 27.8332 13.1086 27.7802C13.2404 27.7273 13.3603 27.6487 13.4614 27.549C13.5625 27.4493 13.6428 27.3305 13.6976 27.1995C13.7524 27.0685 13.7806 26.9279 13.7806 26.786C13.7806 26.644 13.7524 26.5034 13.6976 26.3724C13.6428 26.2414 13.5625 26.1226 13.4614 26.0229C13.3603 25.9232 13.2404 25.8446 13.1086 25.7917C12.9769 25.7388 12.8359 25.7125 12.694 25.7145H2.14285V24.6431C2.14285 20.4695 5.46932 17.1431 9.64285 17.1431H13.9453C14.0872 17.1451 14.2282 17.1188 14.36 17.0659C14.4917 17.013 14.6116 16.9344 14.7127 16.8347C14.8138 16.735 14.8941 16.6162 14.9489 16.4852C15.0037 16.3542 15.0319 16.2136 15.0319 16.0716C15.0319 15.9296 15.0037 15.7891 14.9489 15.6581C14.8941 15.5271 14.8138 15.4083 14.7127 15.3086C14.6116 15.2089 14.4917 15.1303 14.36 15.0774C14.2282 15.0244 14.0872 14.9982 13.9453 15.0002H9.64285Z" fill="black"/>
                                                      <path class="st0" d="M24.17 23.9297C23.673 23.9297 23.27 24.3327 23.27 24.8297C23.27 25.8487 22.441 26.6767 21.422 26.6767H17.072C17.418 26.3247 17.417 25.7597 17.068 25.4097C16.716 25.0577 16.147 25.0577 15.795 25.4097L14.264 26.9397C14.095 27.1087 14 27.3367 14 27.5767C14 27.8147 14.095 28.0447 14.263 28.2137L15.794 29.7447C15.97 29.9207 16.2 30.0087 16.431 30.0087C16.662 30.0087 16.891 29.9207 17.067 29.7447C17.417 29.3947 17.417 28.8287 17.071 28.4767H21.422C23.434 28.4767 25.07 26.8397 25.07 24.8297C25.07 24.3337 24.667 23.9297 24.17 23.9297Z" fill="black"/>
                                                      <path class="st0" d="M17.648 19.531C15.636 19.531 14 21.168 14 23.179C14 23.676 14.403 24.079 14.9 24.079C15.397 24.079 15.8 23.676 15.8 23.179C15.8 22.16 16.629 21.331 17.648 21.331H21.999C21.653 21.683 21.654 22.249 22.003 22.599C22.179 22.775 22.409 22.863 22.639 22.863C22.869 22.863 23.1 22.775 23.276 22.599L24.807 21.068C24.975 20.899 25.07 20.67 25.07 20.431C25.07 20.192 24.975 19.963 24.806 19.794L23.275 18.264C22.923 17.912 22.354 17.912 22.002 18.264C21.653 18.614 21.652 19.179 21.998 19.531H17.648Z" fill="black"/>
                                                   </svg>

                                                </div>
                                                <div class="media-body ml-3">
                                                   <h6 class="mb-0 "><?php echo (__('Change Profile'));?></h6>
                                                </div>
                                             </div>
                                          </a>
                                       <?php } ?>
                                       <a href="<?php echo URL::to('watchlater_list') ?>" class="iq-sub-card setting-dropdown">
                                          <div class="media align-items-center">
                                             <div class="right-icon">
                                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" x="0" y="0" viewBox="0 0 70 70" style="enable-background:new 0 0 70 70" xml:space="preserve">
                                                   <style>.st0{fill:#198fcf;stroke:#198fcf;stroke-width:0;stroke-miterlimit:10}</style>
                                                   <path class="st0" d="M21.5 23.7h14c.2 0 .3.2.3.4v.8c0 .2-.1.4-.3.4h-14c-.2 0-.3-.2-.3-.4V24c0-.1.2-.3.3-.3zM21.5 32h13.4c.2 0 .3.2.3.4v.8c0 .2-.1.4-.3.4H21.5c-.2 0-.3-.2-.3-.4v-.8c0-.2.2-.4.3-.4zM21.5 40.3h23.1c.2 0 .3.2.3.4v.8c0 .2-.1.4-.3.4H21.5c-.2 0-.3-.2-.3-.4v-.7c0-.3.2-.5.3-.5zM21.5 48.7h23.1c.2 0 .3.2.3.4v.8c0 .2-.1.4-.3.4H21.5c-.2 0-.3-.2-.3-.4v-.8c0-.3.2-.4.3-.4z"/>
                                                   <path class="st1" d="M48.4 37c-5.1 0-9.2-4.1-9.2-9.2s4.1-9.2 9.2-9.2 9.2 4.1 9.2 9.2-4.1 9.2-9.2 9.2zm0-16.7c-4.2 0-7.5 3.3-7.5 7.5s3.3 7.5 7.5 7.5 7.5-3.3 7.5-7.5-3.3-7.5-7.5-7.5z" style="fill:#198fcf;stroke:#198fcf;stroke-width:.5;stroke-miterlimit:10"/>
                                                   <path class="st2" d="M52.1 28.7h-3.8c-.4 0-.7-.3-.7-.7v-3.8c0-.2.2-.4.4-.4h.8c.2 0 .4.2.4.4v2.2c0 .4.3.7.7.7h2.2c.2 0 .4.2.4.4v.8c.1.2-.1.4-.4.4z" style="fill:#198fcf"/>
                                                   <path class="st3" d="M54.3 34v20.1c0 1-.8 1.9-1.9 1.9H17.3c-1 0-1.9-.8-1.9-1.9V17.5c0-1 .8-1.9 1.9-1.9h35.1c1 0 1.9.8 1.9 1.9v4.2" style="fill:none;stroke:#198fcf;stroke-width:2;stroke-miterlimit:10"/>
                                                </svg>
                                             </div>
                                             <div class="media-body ml-3">
                                                <h6 class="mb-0 "><?php echo (__('Watch Later'));?></h6>
                                             </div>
                                          </div>
                                       </a>
                                       <a href="<?php echo URL::to('wishlist_list') ?>" class="iq-sub-card setting-dropdown">
                                          <div class="media align-items-center">
                                             <div class="right-icon">
                                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                   viewBox="0 0 70 70" style="enable-background:new 0 0 70 70;" xml:space="preserve">
                                                   <style type="text/css">
                                                      .st0{}
                                                   </style>
                                                   <g>
                                                      <path class="st0" d="M20.9,18.3h-1.2c-0.7,0-1.2-0.5-1.2-1.2s0.5-1.2,1.2-1.2h1.2c0.7,0,1.2,0.5,1.2,1.2S21.5,18.3,20.9,18.3z"/>
                                                      <path class="st0" d="M43.5,18.3H25.6c-0.7,0-1.2-0.5-1.2-1.2s0.5-1.2,1.2-1.2h17.9c0.7,0,1.2,0.5,1.2,1.2S44.1,18.3,43.5,18.3z"/>
                                                      <path class="st0" d="M20.9,25.4h-1.2c-0.7,0-1.2-0.5-1.2-1.2S19,23,19.7,23h1.2c0.7,0,1.2,0.5,1.2,1.2S21.5,25.4,20.9,25.4z"/>
                                                      <path class="st0" d="M43.5,25.4H25.6c-0.7,0-1.2-0.5-1.2-1.2s0.5-1.2,1.2-1.2h17.9c0.7,0,1.2,0.5,1.2,1.2S44.1,25.4,43.5,25.4z"/>
                                                      <path class="st0" d="M20.9,32.5h-1.2c-0.7,0-1.2-0.5-1.2-1.2s0.5-1.2,1.2-1.2h1.2c0.7,0,1.2,0.5,1.2,1.2S21.5,32.5,20.9,32.5z"/>
                                                      <path class="st0" d="M43.5,32.5H25.6c-0.7,0-1.2-0.5-1.2-1.2s0.5-1.2,1.2-1.2h17.9c0.7,0,1.2,0.5,1.2,1.2S44.1,32.5,43.5,32.5z"/>
                                                      <path class="st0" d="M20.9,39.7h-1.2c-0.7,0-1.2-0.5-1.2-1.2s0.5-1.2,1.2-1.2h1.2c0.7,0,1.2,0.5,1.2,1.2S21.5,39.7,20.9,39.7z"/>
                                                      <path class="st0" d="M43.5,39.7H25.6c-0.7,0-1.2-0.5-1.2-1.2s0.5-1.2,1.2-1.2h17.9c0.7,0,1.2,0.5,1.2,1.2S44.1,39.7,43.5,39.7z"/>
                                                      <path class="st0" d="M20.9,46.8h-1.2c-0.7,0-1.2-0.5-1.2-1.2s0.5-1.2,1.2-1.2h1.2c0.7,0,1.2,0.5,1.2,1.2S21.5,46.8,20.9,46.8z"/>
                                                      <path class="st0" d="M56.7,42.9c-1.5-1.5-3.5-2.2-5.5-2.2c-0.3,0-0.5-0.2-0.5-0.5V8.7c0-0.3-0.1-0.6-0.3-0.8s-0.5-0.3-0.8-0.3H13.5
                                                         c-0.6,0-1,0.4-1,1V54c0,0.3,0.1,0.6,0.3,0.8s0.5,0.3,0.8,0.3H39c0.1,0,0.3,0.1,0.4,0.1l6.8,6.8c0.5,0.5,1.2,0.5,1.7,0l8.8-8.8l0,0
                                                         c1.4-1.4,2.2-3.3,2.2-5.2C58.8,46.1,58.1,44.2,56.7,42.9L56.7,42.9z M36.2,44.4H25.6c-0.7,0-1.2,0.5-1.2,1.2s0.5,1.2,1.2,1.2h9.7
                                                         c-0.1,0.4-0.1,0.9-0.1,1.3c0,1.4,0.4,2.7,1.1,3.9c0.2,0.3,0,0.8-0.4,0.8c-3.8,0-17.7,0-20.5,0c-0.3,0-0.5-0.2-0.5-0.5V10.4
                                                         c0-0.3,0.2-0.5,0.5-0.5h32.3c0.3,0,0.5,0.2,0.5,0.5v30.7c0,0.2-0.1,0.3-0.3,0.4c-0.3,0.2-0.6,0.4-0.9,0.6c-1.7-1.3-3.9-1.7-5.9-1.3
                                                         C39,41.3,37.3,42.6,36.2,44.4L36.2,44.4z M55,51.6l-7.6,7.6c-0.2,0.2-0.5,0.2-0.7,0l-7.6-7.6l0,0c-1.3-1.3-1.8-3.1-1.3-4.9
                                                         c0.5-1.7,1.8-3.1,3.6-3.6c2-0.5,4.1,0.2,5.3,1.8c0.2,0.3,0.6,0.3,0.8,0c1.3-1.7,3.4-2.4,5.3-1.8c1.7,0.5,3.1,1.8,3.6,3.6
                                                         C56.8,48.5,56.3,50.4,55,51.6L55,51.6z"/>
                                                   </g>
                                                </svg>
                                             </div>
                                             <div class="media-body ml-3">
                                                <h6 class="mb-0 "><?php echo (__('My Wishlist'));?></h6>
                                             </div>
                                          </div>
                                       </a>
                                       <a href="<?php echo URL::to('purchased-media') ?>" class="iq-sub-card setting-dropdown">
                                          <div class="media align-items-center">
                                             <div class="right-icon">
                                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                   viewBox="0 0 70 70" style="enable-background:new 0 0 70 70;" xml:space="preserve">
                                                   <style type="text/css">
                                                      .st0{stroke-width:0.5;stroke-miterlimit:10;}
                                                   </style>
                                                   <g>
                                                      <path class="st0" d="M45.8,28.7c-0.5,0-0.9-0.4-0.9-0.9V17.5c0-2.4-1.9-4.3-4.3-4.3H30.2c-2.4,0-4.3,1.9-4.3,4.3v10.4
                                                         c0,0.5-0.4,0.9-0.9,0.9s-0.9-0.4-0.9-0.9V17.5c0-3.3,2.7-6,6-6h10.4c3.3,0,6,2.7,6,6v10.4C46.6,28.4,46.2,28.7,45.8,28.7z"/>
                                                      <path class="st0" d="M42.3,23.6H28.5c-0.5,0-0.9-0.4-0.9-0.9s0.4-0.9,0.9-0.9h13.8c0.5,0,0.9,0.4,0.9,0.9
                                                         C43.2,23.2,42.8,23.6,42.3,23.6L42.3,23.6z"/>
                                                      <path class="st0" d="M54.4,52.9h-37c-1,0-1.9-0.8-1.9-1.9V23.7c0-1,0.8-1.9,1.9-1.9h4.2c0.5,0,0.9,0.4,0.9,0.9s-0.4,0.9-0.9,0.9
                                                         h-3.3c-0.6,0-1,0.5-1,1v25.6c0,0.6,0.5,1,1,1h34.2c0.6,0,1-0.5,1-1V24.6c0-0.6-0.5-1-1-1h-3.3c-0.5,0-0.9-0.4-0.9-0.9
                                                         s0.4-0.9,0.9-0.9h4.2c1,0,1.9,0.8,1.9,1.9V52C55.3,52.5,54.9,52.9,54.4,52.9L54.4,52.9z"/>
                                                      <path class="st0" d="M30.2,46c-0.2,0-0.3,0-0.4-0.1c-0.3-0.2-0.4-0.4-0.4-0.7V31.3c0-0.3,0.2-0.6,0.4-0.7c0.3-0.2,0.6-0.2,0.9,0
                                                         l12.1,6.9c0.3,0.2,0.4,0.4,0.4,0.7s-0.2,0.6-0.4,0.7l-12.1,6.9C30.5,46,30.4,46,30.2,46L30.2,46z M31.1,32.8v10.8l9.5-5.4
                                                         L31.1,32.8z"/>
                                                   </g>
                                                </svg>
                                             </div>
                                             <div class="media-body ml-3">
                                                <h6 class="mb-0 "><?php echo (__('Purchased Medias'));?></h6>
                                             </div>
                                          </div>
                                       </a>
                                       <!-- <a href="<?php echo URL::to('my-playlist') ?>" class="iq-sub-card setting-dropdown">
                                          <div class="media align-items-center">
                                             <div class="right-icon">
                                             <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                   viewBox="0 0 70 70" style="enable-background:new 0 0 70 70;" xml:space="preserve">
                                                   <style type="text/css">
                                                      .st0{stroke-width:0.5;stroke-miterlimit:10;}
                                                   </style>
                                                   <g>
                                                      <path class="st0" d="M45.8,28.7c-0.5,0-0.9-0.4-0.9-0.9V17.5c0-2.4-1.9-4.3-4.3-4.3H30.2c-2.4,0-4.3,1.9-4.3,4.3v10.4
                                                         c0,0.5-0.4,0.9-0.9,0.9s-0.9-0.4-0.9-0.9V17.5c0-3.3,2.7-6,6-6h10.4c3.3,0,6,2.7,6,6v10.4C46.6,28.4,46.2,28.7,45.8,28.7z"/>
                                                      <path class="st0" d="M42.3,23.6H28.5c-0.5,0-0.9-0.4-0.9-0.9s0.4-0.9,0.9-0.9h13.8c0.5,0,0.9,0.4,0.9,0.9
                                                         C43.2,23.2,42.8,23.6,42.3,23.6L42.3,23.6z"/>
                                                      <path class="st0" d="M54.4,52.9h-37c-1,0-1.9-0.8-1.9-1.9V23.7c0-1,0.8-1.9,1.9-1.9h4.2c0.5,0,0.9,0.4,0.9,0.9s-0.4,0.9-0.9,0.9
                                                         h-3.3c-0.6,0-1,0.5-1,1v25.6c0,0.6,0.5,1,1,1h34.2c0.6,0,1-0.5,1-1V24.6c0-0.6-0.5-1-1-1h-3.3c-0.5,0-0.9-0.4-0.9-0.9
                                                         s0.4-0.9,0.9-0.9h4.2c1,0,1.9,0.8,1.9,1.9V52C55.3,52.5,54.9,52.9,54.4,52.9L54.4,52.9z"/>
                                                      <path class="st0" d="M30.2,46c-0.2,0-0.3,0-0.4-0.1c-0.3-0.2-0.4-0.4-0.4-0.7V31.3c0-0.3,0.2-0.6,0.4-0.7c0.3-0.2,0.6-0.2,0.9,0
                                                         l12.1,6.9c0.3,0.2,0.4,0.4,0.4,0.7s-0.2,0.6-0.4,0.7l-12.1,6.9C30.5,46,30.4,46,30.2,46L30.2,46z M31.1,32.8v10.8l9.5-5.4
                                                         L31.1,32.8z"/>
                                                   </g>
                                                </svg>
                                             </div>
                                             <div class="media-body ml-3">
                                                <h6 class="mb-0 ">My Playlist</h6>
                                             </div>
                                          </div>
                                       </a> -->
                                       <!-- <a href="<?php echo URL::to('my-music-station') ?>" class="iq-sub-card setting-dropdown">
                                          <div class="media align-items-center">
                                             <div class="right-icon">
                                             <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                   viewBox="0 0 70 70" style="enable-background:new 0 0 70 70;" xml:space="preserve">
                                                   <style type="text/css">
                                                      .st0{stroke-width:0.5;stroke-miterlimit:10;}
                                                   </style>
                                                   <g>
                                                      <path class="st0" d="M45.8,28.7c-0.5,0-0.9-0.4-0.9-0.9V17.5c0-2.4-1.9-4.3-4.3-4.3H30.2c-2.4,0-4.3,1.9-4.3,4.3v10.4
                                                         c0,0.5-0.4,0.9-0.9,0.9s-0.9-0.4-0.9-0.9V17.5c0-3.3,2.7-6,6-6h10.4c3.3,0,6,2.7,6,6v10.4C46.6,28.4,46.2,28.7,45.8,28.7z"/>
                                                      <path class="st0" d="M42.3,23.6H28.5c-0.5,0-0.9-0.4-0.9-0.9s0.4-0.9,0.9-0.9h13.8c0.5,0,0.9,0.4,0.9,0.9
                                                         C43.2,23.2,42.8,23.6,42.3,23.6L42.3,23.6z"/>
                                                      <path class="st0" d="M54.4,52.9h-37c-1,0-1.9-0.8-1.9-1.9V23.7c0-1,0.8-1.9,1.9-1.9h4.2c0.5,0,0.9,0.4,0.9,0.9s-0.4,0.9-0.9,0.9
                                                         h-3.3c-0.6,0-1,0.5-1,1v25.6c0,0.6,0.5,1,1,1h34.2c0.6,0,1-0.5,1-1V24.6c0-0.6-0.5-1-1-1h-3.3c-0.5,0-0.9-0.4-0.9-0.9
                                                         s0.4-0.9,0.9-0.9h4.2c1,0,1.9,0.8,1.9,1.9V52C55.3,52.5,54.9,52.9,54.4,52.9L54.4,52.9z"/>
                                                      <path class="st0" d="M30.2,46c-0.2,0-0.3,0-0.4-0.1c-0.3-0.2-0.4-0.4-0.4-0.7V31.3c0-0.3,0.2-0.6,0.4-0.7c0.3-0.2,0.6-0.2,0.9,0
                                                         l12.1,6.9c0.3,0.2,0.4,0.4,0.4,0.7s-0.2,0.6-0.4,0.7l-12.1,6.9C30.5,46,30.4,46,30.2,46L30.2,46z M31.1,32.8v10.8l9.5-5.4
                                                         L31.1,32.8z"/>
                                                   </g>
                                                </svg>
                                             </div>
                                             <div class="media-body ml-3">
                                                <h6 class="mb-0 ">Music Station</h6>
                                             </div>
                                          </div>
                                       </a> -->
                                       <?php
                                       if(Auth::User()->role == "admin"){
                                       if(Auth::user()->package != 'Channel' && Auth::user()->package != 'CPP'){ ?>
                                       <!-- <a href="<?php echo URL::to('admin/subscription-plans') ?>"  class="iq-sub-card setting-dropdown">
                                          <div class="media align-items-center">
                                             <div class="right-icon">
                                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                   viewBox="0 0 70 70" style="enable-background:new 0 0 70 70;" xml:space="preserve">
                                                   <style type="text/css">
                                                      .st0{}
                                                   </style>
                                                   <path class="st0" d="M11.2,22.1v23.2c0,1.4,0.5,2.7,1.5,3.6c1,1,2.3,1.5,3.6,1.5h37.7c1.4,0,2.7-0.5,3.6-1.5c1-1,1.5-2.3,1.5-3.6
                                                      V22.1c0-1.4-0.5-2.7-1.5-3.6c-1-1-2.3-1.5-3.6-1.5H16.4c-1.4,0-2.7,0.5-3.6,1.5C11.8,19.5,11.2,20.8,11.2,22.1L11.2,22.1z
                                                      M16.8,32.3v-3c1.9,0.2,3.7-0.4,5.1-1.7c1.3-1.3,2-3.2,1.7-5.1h23.3c0,0.2,0,0.5,0,0.7c0,1.8,0.7,3.4,2.1,4.6
                                                      c1.3,1.2,3.1,1.7,4.8,1.5v8.8c-1.9-0.2-3.7,0.4-5.1,1.7c-1.3,1.3-2,3.2-1.7,5.1H23.6c0.2-1.9-0.4-3.7-1.7-5.1
                                                      c-1.3-1.3-3.2-2-5.1-1.7L16.8,32.3z M28.4,33.7c0-1.8,0.7-3.5,2-4.8c1.3-1.3,3-2,4.8-2s3.5,0.7,4.8,2c1.3,1.3,2,3,2,4.8
                                                      c0,1.8-0.7,3.5-2,4.8c-1.3,1.3-3,2-4.8,2s-3.5-0.7-4.8-2C29.1,37.3,28.4,35.5,28.4,33.7z"/>
                                                </svg>
                                             </div>
                                             <div class="media-body ml-3">
                                                <h6 class="mb-0 "><?php echo (__('Pricing Plan'));?> </h6>
                                             </div>
                                          </div>
                                       </a> -->
                                       <a href="<?php echo URL::to('admin') ?>" class="iq-sub-card setting-dropdown">
                                          <div class="media align-items-center">
                                             <div class="right-icon">
                                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                   viewBox="0 0 70 70" style="enable-background:new 0 0 70 70;" xml:space="preserve">
                                                   <style type="text/css">
                                                      .st0{}
                                                   </style>
                                                   <g>
                                                      <path class="st0" d="M52.5,37.8c-1.7,0-3.2,0.5-4.5,1.2c-2.4-2-5-3.7-8-4.6c4.5-3,7.2-8.2,6.4-13.8c-0.8-6.4-6.1-11.7-12.5-12.4
                                                         c-4.1-0.5-8.1,0.8-11.2,3.6c-3.1,2.7-4.8,6.6-4.8,10.7c0,4.9,2.5,9.4,6.6,12c-5,1.7-9.3,5.1-12.3,9.5c-1.7,2.6-1.1,6.2,1.3,8
                                                         C19,55.9,25.4,58,32.2,58c4.9,0,9.8-1.2,14.2-3.5c1.7,1.4,3.7,2.3,6.1,2.3c5.2,0,9.5-4.3,9.5-9.5S57.7,37.8,52.5,37.8L52.5,37.8z
                                                         M20.3,22.3c0-3.3,1.4-6.7,3.9-8.9c2.3-2,5-3,7.9-3c0.5,0,1,0,1.4,0.1c5.4,0.6,9.8,4.9,10.4,10.2c0.7,5.6-2.5,10.8-7.9,12.8
                                                         l-3.8,1.4l-3.9-1.4C23.5,31.8,20.3,27.3,20.3,22.3L20.3,22.3z M15.1,49.9c-1.4-1.1-1.8-3.2-0.8-4.8c3.1-4.8,8.2-8.2,13.8-9.3
                                                         l4.2-0.8l4.2,0.8c3.6,0.7,6.8,2.3,9.7,4.5c-1.9,1.7-3.1,4.2-3.1,6.9c0,2,0.6,3.9,1.8,5.5c-3.9,1.9-8.2,2.9-12.5,2.9
                                                         C26,55.6,20.1,53.6,15.1,49.9L15.1,49.9z M52.5,54.5c-3.9,0-7.2-3.2-7.2-7.2s3.2-7.2,7.2-7.2s7.2,3.2,7.2,7.2S56.4,54.5,52.5,54.5z
                                                         M57.5,45.6L55,48l0.6,3.5l-3.1-1.7l-3.1,1.7L50,48l-2.5-2.4l3.5-0.5l1.5-3.1l1.5,3.1L57.5,45.6z"/>
                                                   </g>
                                                </svg>
                                             </div>
                                             <div class="media-body ml-3">
                                                <h6 class="mb-0 "><?php echo (__('Admin')); ?></h6>
                                             </div>
                                          </div>
                                       </a>
                                       <!-- Multiuser Profile -->
                                       <?php
                                          } }
                                          if(Auth::user()->role == "subscriber"){

                                          ?>
                                       <!-- <a href="<?php echo URL::to('choose-profile') ?>" class="iq-sub-card setting-dropdown">
                                          <div class="media align-items-center">
                                             <div class="right-icon">
                                                <img src="<?php echo URL::to('/').'/assets/icons/admin.svg';?> " width="25" height="21">
                                             </div>
                                             <div class="media-body ml-3">
                                                <h6 class="mb-0 ">Multi Profile</h6>
                                             </div>
                                          </div>
                                          </a> -->
                                       <?php
                                          }
                                          ?>
                                       <a href="<?php echo URL::to('logout') ?>" class="iq-sub-card setting-dropdown">
                                          <div class="media align-items-center">
                                             <div class="right-icon">
                                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" x="0" y="0" viewBox="0 0 70 70" style="enable-background:new 0 0 70 70" xml:space="preserve">
                                                   <path class="st6" d="M53.4 33.7H30.7M36.4 28.1l-5.7 5.7 5.7 5.7"/>
                                                   <path class="st6" d="M50.5 43.7c-2.1 3.4-5.3 5.9-9.1 7.3-3.7 1.4-7.8 1.6-11.7.4a18.4 18.4 0 0 1-9.6-28.8c2.4-3.2 5.8-5.5 9.6-6.6 3.8-1.1 7.9-1 11.7.4 3.7 1.4 6.9 4 9.1 7.3"/>
                                                </svg>
                                             </div>
                                             <div class="media-body ml-3">
                                                <h6 class="mb-0 "><?php echo (__('Logout')); ?></h6>
                                             </div>
                                          </div>
                                       </a>
                                    </div>
                                 </div>
                              </div>
                              <?php endif; ?>
                           </li>
                           <?php endif; ?>
                        </ul>
                     </div>
                  </nav>
               </div>
            </div>
         </div>
      </div>
      <?php
         $playerui_settings = App\Playerui::first();
         if($playerui_settings->watermark == 1){ ?>
      <style>
         .plyr__video-wrapper::before {
         position: absolute;
         top: <?php echo $playerui_settings->watermark_top; ?>;
         left: <?php echo $playerui_settings->watermark_left; ?>;
         opacity : <?php echo $playerui_settings->watermark_opacity; ?>;
         z-index: 2;
         content: '';
         height: 150px;
         width: <?php echo $playerui_settings->watermar_width; ?>;
         background: url(<?php echo $playerui_settings->watermark_logo; ?>) no-repeat;
         /* background-size: 100px auto, auto; */
         background-size: contain;
         }
      </style>
      <?php } else{ } ?>
      <script>
         $(document).ready(function() {
         $(".dropdown-toggle").dropdown();
         });

         $(document).ready(function(){
         var currentdate = "<?=  $currentdate ?>";
         var filldate = "<?= $filldate ?>";
         var DOB = "<?= $DOB ?>";

         // console.log(DOB);
         // console.log(currentdate);

         if(filldate == currentdate &&  DOB != null && !empty(DOB)  &&  currentdate != null &&  filldate != null){
         $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 10%; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Add Your DOB for Amazing video experience</div>');
         setTimeout(function() {
         $('.add_watch').slideUp('fast');
         }, 3000);
         }
         });

      </script>

      <script>
         $("#toggle").click(function(){

            var theme_mode = $("#toggle").prop("checked");

            $.ajax({
            url: '<?php echo URL::to("theme-mode") ;?>',
            method: 'post',
            data:
               {
                  "_token": "<?php echo csrf_token(); ?>",
                  mode: theme_mode
               },
               success: (response) => {
                  console.log(response);
               },
            })
         });

      </script>

      <!-- Dark Mode & Light Mode  -->
      <script>
         let theme_modes = $("#toggle").val();

         $(document).ready(function(){

            if( theme_modes == 'light' ){

               body.classList.add('light-theme');

            }
         });
      </script>

      <script>
         $('ul.nav li.dropdown').hover(function() {
         $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(700);
         }, function() {
         $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(700);
         });
      </script>
                  <!-- search validation -->
      <script  src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js" async></script>

      <script>
         $( "#searchResult" ).validate({
            errorClass: 'Search_error_class',
            rules: {
                     search: {
                        required: true,
                     },
                  },

            messages: {
               search: {
                  required: "This Search field is required",
               }
            }
          });
      </script>

<script>
                  document.getElementById('languageSearch').addEventListener('click', function(event) {
            event.stopPropagation();
            });
            document.getElementById('languageSearch').addEventListener('input', function() {
                var searchValue = this.value.toLowerCase();
                var languageLinks = document.querySelectorAll('.language-link');

                languageLinks.forEach(function(languageLink) {
                    var languageName = languageLink.textContent.toLowerCase();
                    if (languageName.includes(searchValue)) {
                        languageLink.style.display = 'block';
                    } else {
                        languageLink.style.display = 'none';
                    }
                });
            });

            document.addEventListener("DOMContentLoaded", function() {
               const dropdownIcon = document.querySelector('.dropdown-icon');
               const dropdownContent = document.querySelector('.dropdown-content');

               // Check if both dropdownIcon and dropdownContent are not null
               if (dropdownIcon && dropdownContent) {
                  document.addEventListener("click", function (event) {
                        // Check if the clicked target is neither dropdownIcon nor within dropdownContent
                        if (event.target !== dropdownIcon && !dropdownContent.contains(event.target)) {
                           dropdownContent.style.display = "none";
                        }
                  });
               }
            });


            // document.addEventListener("click", function (event) {
            //     if (event.target !== dropdownIcon && !dropdownContent.contains(event.target)) {
            //         dropdownContent.style.display = "none";
            //     }
            // });


            // Close the dropdown if the user clicks outside of it
            // document.addEventListener("click", function (event) {
            // if (event.target !== dropdownIcon && !dropdownContent.contains(event.target)) {
            // dropdownContent.style.display = "none";
            // }
            // });



      $(".language-link").click(function(){

         event.preventDefault();
         var languageCode = $(this).data("language-code");

      $.ajax({
            url: '<?php echo URL::to("/translate_language") ;?>',
            method: 'post',
            data:
               {
                  "_token": "<?php echo csrf_token(); ?>",
                  languageCode: languageCode,
               },
               success: (response) => {
                  console.log(response);
                  // alert("Changed The Language !");
                  location.reload();

               },
            })
         });


      </script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var themeMode = '<?= $theme_mode; ?>';

        if (themeMode === 'dark') {
            document.body.classList.add('dark-theme');
        } else if (themeMode === 'light') {
            document.body.classList.add('light-theme');
        }
    });
</script>

<style>
   /* Initially hide the dropdown content */
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
  z-index: 1;
}

/* Style the dropdown links */
.dropdown-content a {
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  color: #333 !important;
}

/* Style the dropdown links on hover */
.dropdown-content a:hover {
  background-color: #007bff;
  color: #fff;
}

/* Style the dropdown content to be visible when the dropdown-icon is clicked */
.show {
  display: block;
}
#languageDropdown{
   display:block !important;
}
     /* video::-webkit-media-controls {
    display: none !important;
  }
  .myvideos{
    height: 420px !important;
  } */
</style>

   </header>
   <!-- Header End -->
   <!-- MainContent End-->

<script>
      // width and height set dynamically
      document.addEventListener('DOMContentLoaded', function() {
      var images = document.querySelectorAll('.c-logo');
      images.forEach(function(image) {
         var renderedWidth = image.clientWidth;
         var renderedHeight = image.clientHeight;

         image.setAttribute('width', renderedWidth);
         image.setAttribute('height', renderedHeight);
      });
   });
</script>
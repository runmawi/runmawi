<!DOCTYPE html>
<html lang="en-US">

<head>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= getFavicon() ?>" type="image/gif" sizes="16x16">

    <?php
    $data = Session::all();
    $theme_mode = App\SiteTheme::pluck('theme_mode')->first();
    $theme = App\SiteTheme::first();
    $home_settings = App\HomeSetting::first();
    
    $uri_path = $_SERVER['REQUEST_URI'];
    $uri_parts = explode('/', $uri_path);
    $request_url = end($uri_parts);
    $uppercase = ucfirst($request_url);
    if ((!empty($data['password_hash']) && empty($uppercase)) || (empty($data['password_hash']) && empty($uppercase))) {
        // dd($uppercase);
        $uppercase = 'Home';
    } else {
    }
    if (!empty(Auth::User()->id)) {
        $id = Auth::User()->id;
        $users = App\User::find($id);
        $date = date_create($users->created_at);
        $created_at = date_format($date, 'Y-m-d');
        $filldate = date('Y-m-d', strtotime($created_at . ' + 10 day'));
        $currentdate = date('Y-m-d');
        $DOB = $users->DOB;
    } else {
        $currentdate = null;
        $filldate = null;
        $DOB = null;
    }
    
    // exit();UA-42534483-14
    $data = Session::all();
    
    ?>
    <!-- Required meta tags -->
    <?php $settings = App\Setting::first(); //echo $settings->website_name; ?>


    <?php if (!empty($data['password_hash'])) {
        $videos_data = App\Video::where('slug', $request_url)->first();
    } //echo $settings->website_name; ?>
    <?php if (!empty($data['password_hash'])) {
        $series = App\Series::where('slug', $request_url)->first();
    } //echo $settings->website_name; ?>
    <?php if (!empty($data['password_hash'])) {
        $episdoe = App\Episode::where('slug', $request_url)->first();
    } //echo $settings->website_name; ?>
    <?php if (!empty($data['password_hash'])) {
        $livestream = App\LiveStream::where('slug', $request_url)->first();
    } //echo $settings->website_name; ?>

    <?php
    $videos_data = App\Video::where('slug', $request_url)->first();
    $series = App\Series::where('slug', $request_url)->first();
    $episdoe = App\Episode::where('slug', $request_url)->first();
    $livestream = App\LiveStream::where('slug', $request_url)->first();
    $dynamic_page = App\Page::where('slug', '=', $request_url)->first();
    $SiteMeta_page = App\SiteMeta::where('page_slug', '=', $request_url)->first();
    $SiteMeta_image = App\SiteMeta::where('page_slug', '=', $request_url)->pluck('meta_image')->first();
    ?>
    <meta charset="UTF-8">
 
<!-- Place this data between the <head> tags of your website -->
<title><?php
      if(!empty($videos_data)){  echo $videos_data->title .' | '. $settings->website_name ;
       }
      elseif(!empty($series)){ echo $series->title .' | '. $settings->website_name ; }
      elseif(!empty($episdoe)){ echo $episdoe->title .' | '. $settings->website_name ; }
      elseif(!empty($livestream)){ echo $livestream->title .' | '. $settings->website_name ; }
      elseif(!empty($dynamic_page)){ echo $dynamic_page->title .' | '. $settings->website_name ; }
      elseif(!empty($SiteMeta_page)){ echo $SiteMeta_page->page_title .' | '. $settings->website_name ; }
      else{ echo $uppercase .' | ' . $settings->website_name ;} ?></title>
<meta name="description" content="<?php 
      if(!empty($videos_data)){ echo $videos_data->description  ;
      }
      elseif(!empty($episdoe)){ echo $episdoe->description  ;}
      elseif(!empty($series)){ echo $series->description ;}
      elseif(!empty($livestream)){ echo $livestream->description  ;}
      elseif(!empty($SiteMeta_page)){ echo $SiteMeta_page->meta_description .' | '. $settings->website_name ; }
      else{ echo $settings->website_description   ;} //echo $settings; ?>" />

<!-- Schema.org markup for Google+ -->
<meta itemprop="name" content="<?php
      if(!empty($videos_data)){  echo $videos_data->title .' | '. $settings->website_name ;
       }
      elseif(!empty($series)){ echo $series->title .' | '. $settings->website_name ; }
      elseif(!empty($episdoe)){ echo $episdoe->title .' | '. $settings->website_name ; }
      elseif(!empty($livestream)){ echo $livestream->title .' | '. $settings->website_name ; }
      elseif(!empty($dynamic_page)){ echo $dynamic_page->title .' | '. $settings->website_name ; }
      elseif(!empty($SiteMeta_page)){ echo $SiteMeta_page->page_name .' | '. $settings->website_name ; }
      else{ echo $uppercase .' | ' . $settings->website_name ;} ?>">
<meta itemprop="description" content="<?php 
      if(!empty($videos_data)){ echo $videos_data->description  ;
      }
      elseif(!empty($episdoe)){ echo $episdoe->description  ;}
      elseif(!empty($series)){ echo $series->description ;}
      elseif(!empty($livestream)){ echo $livestream->description  ;}
      elseif(!empty($SiteMeta_page)){ echo $SiteMeta_page->meta_description .' | '. $settings->website_name ; }
      else{ echo $settings->website_description   ;} //echo $settings; ?>">
<meta itemprop="image" content="<?php 
      if(!empty($videos_data)){ echo URL::to('/public/uploads/images').'/'.$videos_data->image  ;
      }
      elseif(!empty($episdoe)){ echo URL::to('/public/uploads/images').'/'.$episdoe->image  ;}
      elseif(!empty($series)){ echo URL::to('/public/uploads/images').'/'.$series->image ;}
      elseif(!empty($livestream)){ echo URL::to('/public/uploads/images').'/'.$livestream->image ;}
      elseif(!empty($SiteMeta_image)){ echo $SiteMeta_image ;}
      else{  echo URL::to('/').'/public/uploads/settings/'. $settings->default_horizontal_image   ;} //echo $settings; ?>">

<!-- Twitter Card data -->
<meta name="twitter:card" content="summary_large_image">
<?php if(!empty($settings->twitter_page_id)){ ?><meta name="twitter:site" content="<?php echo $settings->twitter_page_id ;?>"><?php } ?>
<meta name="twitter:title" content="<?php
      if(!empty($videos_data)){  echo $videos_data->title .' | '. $settings->website_name ;
       }
      elseif(!empty($series)){ echo $series->title .' | '. $settings->website_name ; }
      elseif(!empty($episdoe)){ echo $episdoe->title .' | '. $settings->website_name ; }
      elseif(!empty($livestream)){ echo $livestream->title .' | '. $settings->website_name ; }
      elseif(!empty($dynamic_page)){ echo $dynamic_page->title .' | '. $settings->website_name ; }
      elseif(!empty($SiteMeta_page)){ echo $SiteMeta_page->page_title .' | '. $settings->website_name ; }
      else{ echo $uppercase .' | ' . $settings->website_name ;} ?>">
<meta name="twitter:description" content="<?php 
      if(!empty($videos_data)){ echo $videos_data->description  ;
      }
      elseif(!empty($episdoe)){ echo $episdoe->description  ;}
      elseif(!empty($series)){ echo $series->description ;}
      elseif(!empty($livestream)){ echo $livestream->description  ;}
      elseif(!empty($SiteMeta_page)){ echo $SiteMeta_page->meta_description .' | '. $settings->website_name ; }
      else{ echo $settings->website_description   ;} //echo $settings; ?>">
<!-- Twitter summary card with large image must be at least 280x150px -->
<meta name="twitter:image:src" content="<?php 
      if(!empty($videos_data)){ echo URL::to('/public/uploads/images').'/'.$videos_data->image  ;
      }
      elseif(!empty($episdoe)){ echo URL::to('/public/uploads/images').'/'.$episdoe->image  ;}
      elseif(!empty($series)){ echo URL::to('/public/uploads/images').'/'.$series->image ;}
      elseif(!empty($livestream)){ echo URL::to('/public/uploads/images').'/'.$livestream->image ;}
      elseif(!empty($SiteMeta_image)){ echo $SiteMeta_image ;}
      else{  echo URL::to('/').'/public/uploads/settings/'. $settings->default_horizontal_image   ;} //echo $settings; ?>">

<!-- Open Graph data -->
<meta property="og:title" content="<?php
      if(!empty($videos_data)){  echo $videos_data->title .' | '. $settings->website_name ;
       }
      elseif(!empty($series)){ echo $series->title .' | '. $settings->website_name ; }
      elseif(!empty($episdoe)){ echo $episdoe->title .' | '. $settings->website_name ; }
      elseif(!empty($livestream)){ echo $livestream->title .' | '. $settings->website_name ; }
      elseif(!empty($dynamic_page)){ echo $dynamic_page->title .' | '. $settings->website_name ; }
      elseif(!empty($SiteMeta_page)){ echo $SiteMeta_page->page_title .' | '. $settings->website_name ; }
      else{ echo $uppercase .' | ' . $settings->website_name ;} ?>" />
<meta property="og:image" content="<?php 
      if(!empty($videos_data)){ echo URL::to('/public/uploads/images').'/'.$videos_data->image  ;
      }
      elseif(!empty($episdoe)){ echo URL::to('/public/uploads/images').'/'.$episdoe->image  ;}
      elseif(!empty($series)){ echo URL::to('/public/uploads/images').'/'.$series->image ;}
      elseif(!empty($livestream)){ echo URL::to('/public/uploads/images').'/'.$livestream->image ;}
      elseif(!empty($SiteMeta_image)){ echo $SiteMeta_image ;}
      else{  echo URL::to('/').'/public/uploads/settings/'. $settings->default_horizontal_image   ;} //echo $settings; ?>" />
<meta property="og:description" content="<?php 
      if(!empty($videos_data)){ echo $videos_data->description  ;
      }
      elseif(!empty($episdoe)){ echo $episdoe->description  ;}
      elseif(!empty($series)){ echo $series->description ;}
      elseif(!empty($livestream)){ echo $livestream->description  ;}
      elseif(!empty($SiteMeta_page)){ echo $SiteMeta_page->meta_description .' | '. $settings->website_name ; }
      else{ echo $settings->website_description   ;} //echo $settings; ?>" />

<?php if(!empty($settings->website_name)){ ?><meta property="og:site_name" content="<?php echo $settings->website_name ;?>" /><?php } ?>


    <?php $Linking_Setting = App\LinkingSetting::first();
    $site_url = \Request::url();
    $http_site_url = explode('http://', $site_url);
    $https_site_url = explode('https://', $site_url);
    if (!empty($http_site_url[1])) {
        $site_page_url = $http_site_url[1];
    } elseif (!empty($https_site_url[1])) {
        $site_page_url = $https_site_url[1];
    } else {
        $site_page_url = '';
    }
    ?>
    <?php if(!empty($Linking_Setting->ios_app_store_id)){ ?>
    <meta property="al:ios:app_store_id" content="<?php echo $Linking_Setting->ios_app_store_id; ?>" /><?php } ?>
    <meta property="al:ios:url" content="<?php echo $site_page_url; ?>" />
    <?php if(!empty($Linking_Setting->ipad_app_store_id)){ ?>
    <meta property="al:ipad:app_store_id" content="<?php echo $Linking_Setting->ipad_app_store_id; ?>" /><?php } ?>
    <meta property="al:ipad:url" content="<?php echo $site_page_url; ?>" />
    <?php if(!empty($Linking_Setting->android_app_store_id)){ ?>
    <meta property="al:android:package" content="<?php echo $Linking_Setting->android_app_store_id; ?>" /><?php } ?>
    <meta property="al:android:url" content="<?php echo $site_page_url; ?>" />
    <meta property="al:windows_phone:url" content="<?php echo $site_page_url; ?>" />
    <?php if(!empty($Linking_Setting->windows_phone_app_store_id)){ ?>
    <meta property="al:windows_phone:app_id" content="<?php echo $Linking_Setting->windows_phone_app_store_id; ?>" /><?php } ?>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <input type="hidden" value="<?php echo $settings->google_tracking_id; ?>" name="tracking_id" id="tracking_id">


    <link rel="preload" as="style" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

    <!-- Bootstrap CSS -->
    <link rel="preload" as="style" href="<?= URL::to('/') . '/assets/css/bootstrap.min.css' ?>" />
    <link rel="stylesheet" href="<?= URL::to('/') . '/assets/css/bootstrap.min.css' ?>" />
    <!-- Typography CSS -->
    <link rel="preload" href="<?= URL::to('assets/css/variable-boots-flick.css') ;?>" as="style">
    <link rel="preload" href="<?= URL::to('assets/css/variable.css') ;?>" as="style">
    <link rel="preload" href="<?= URL::to('assets/css/all.min.css') ;?>" as="style">
    <link rel="preload" href="<?= URL::to('assets/css/remixicon.css') ;?>" as="style">
    <link rel="preload" href="<?= URL::to('assets/css/slick.css') ;?>" as="style">
    <link rel="preload" href="<?= URL::to('assets/css/slick-theme.css') ;?>" as="style">
    <link rel="preload" href="<?= URL::to('assets/css/owl.carousel.min.css') ;?>" as="style">
    <link rel="preload" href="<?= URL::to('assets/css/slick-animation.css') ;?>" as="style">
    <link rel="preload" href="<?= URL::to('/assets/css/compine.css') ;?>" as="style" />
    
    <link rel="preload" href="<?= typography_link();?>" as="style"/>
    <link rel="stylesheet" href="<?= typography_link();?>" />
    <!-- Style -->
    <link href="<?php echo URL::to('public/themes/theme5-nemisha/assets/css/style.css'); ?>" rel="preload" as="style">
    <link href="<?php echo URL::to('public/themes/theme5-nemisha/assets/css/typography.css'); ?>" rel="preload" as="style">
    <link href="<?php echo URL::to('public/themes/theme5-nemisha/assets/css/responsive.css'); ?>" rel="preload" as="style">
    <link href="<?php echo URL::to('public/themes/theme5-nemisha/assets/fonts/font.css'); ?>" rel="preload" as="style">
    
    <link href="<?php echo URL::to('public/themes/theme5-nemisha/assets/css/style.css'); ?>" rel="stylesheet">
    <link href="<?php echo URL::to('public/themes/theme5-nemisha/assets/css/typography.css'); ?>" rel="stylesheet">
    <link href="<?php echo URL::to('public/themes/theme5-nemisha/assets/css/responsive.css'); ?>" rel="stylesheet">
    <link href="<?php echo URL::to('public/themes/theme5-nemisha/assets/fonts/font.css'); ?>" rel="stylesheet">


    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <link rel="prelaod" as="style" href="https://cdn.jsdelivr.net/npm/remixicon@2.2.0/fonts/remixicon.css"> -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/remixicon@2.2.0/fonts/remixicon.css" rel="stylesheet"> -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>

    <!--Flickity CSS -->
    <link rel="preload" href="<?= URL::to('public/themes/theme5-nemisha/assets/css/flickity.css') ?>" as="style">
    <link rel="stylesheet" href="<?= URL::to('public/themes/theme5-nemisha/assets/css/flickity.css') ?>">
    <!--Flickity JavaScript -->
    <link rel="preload" href="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js" as="script">
    <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>

    <!-- Responsive -->
    <!-- <link rel="preload" as="style" href="<?= URL::to('/') . '/assets/css/slick.css' ?>" /> -->

    <!-- <link rel="stylesheet" href="<?= URL::to('/') . '/assets/css/slick.css' ?>" /> -->

    <link rel="preload" href="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" as="script">
    <link rel="preload" href="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js" as="script">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.js" as="script">
    
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://www.googletagmanager.com">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.js"></script>
    
    <?php 
      $Script = App\Script::pluck('header_script')->toArray();
      if(count($Script) > 0){
         foreach($Script as $Scriptheader){   ?>
    <?= $Scriptheader ?>
    <?php } 
        } ?>
</head>
<style>
    .fullpage-loader {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: 100vw;
        overflow: hidden;
        background: #222831;
        opacity: 1;
        transition: opacity .5s;
        display: flex;
        justify-content: center;
        align-items: center;

        .fullpage-loader__logo {
            position: relative;

            &:after {
                /*  this is the sliding white part */
                content: '';
                height: 100%;
                width: 100%;
                position: absolute;
                top: 0;
                left: 0;
                animation: shine 2.5s infinite cubic-bezier(0.42, 0, 0.58, 1);

                /*  opaque white slide */
                background: #222831;
                /* gradient shine scroll */
                background: -moz-linear-gradient(left, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 1) 50%, rgba(255, 255, 255, 0) 100%);
                /* FF3.6-15 */
                background: -webkit-linear-gradient(left, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 1) 50%, rgba(255, 255, 255, 0) 100%);
                /* Chrome10-25,Safari5.1-6 */
                background: linear-gradient(to right, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 1) 50%, rgba(255, 255, 255, 0) 100%);
                /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#00ffffff', endColorstr='#00ffffff', GradientType=1);
                /* IE6-9 */

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

    svg {
        height: 30px;
    }

    #main-header {
        color: #fff;
    }

    .svg {
        color: #fff;
    }

    #videoPlayer {
        width: 100%;
        height: 100%;
        margin: 20px auto;
    }

    .media h6 {
        /* font-family: Chivo;
    font-style: normal;
    font-weight: normal;*/
        font-size: 18px;
        line-height: 29px;
    }

    i.fas.fa-child {
        font-size: 35px;
        color: white;
    }

    span.kids {
        color: #f7dc59;
    }

    span.family {
        color: #f7dc59;
    }

    i.fa.fa-eercast {
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
        display: flex;
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
        bottom: 2.8px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .categ-head {
        padding-left: 40px;
    }

    input:checked+.sliderk {
        background-color: #2196F3;
    }

    input:focus+.sliderk {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.sliderk:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .sliderk.round {
        border-radius: 34px;
    }

    .sliderk.round:before {
        border-radius: 50%;
    }

    .dropdown-toggle::after {
        display: none !important;
    }
    .navbar-light .navbar-toggler{
        border-color:transparent;
    }
    /* Dark mode and light Mode */
    body.light-theme {
        background-color: <?php echo GetLightBg(); ?>;
    }
    body.light-theme .navbar-light .navbar-toggler-icon{background: none !important; }
    body.light-theme i.ri-more-line{
        color: <?php echo GetLightText(); ?>!important;
    }
    body.light-theme #top-menu a{
        color: #fff !important;
    }
    body.light-theme #top-menu h6{
        color: #fff !important;
    }

    body.light-theme h4 {
        color: <?php echo GetLightText(); ?>;
    }

    body.light-theme .hero-title {
        color: #fff !important;
    }

    body.light-theme .play-border {
        border: 1px solid #000;
        box-shadow: 0px 3px 1px -2px rgb(0 0 0 / 20%), 0px 2px 2px 0px rgb(0 0 0 / 14%), 0px 1px 5px 0px rgb(0 0 0 / 12%);
    }

    body.light-theme .desc {
        color: <?php echo GetLightText(); ?> !important;
    }

    body.light-theme label {
        color: <?php echo GetLightText(); ?> !important;
    }

    body.light-theme .bmk p {
        color: #000 !important;
    }

    body.light-theme h5 {
        color: <?php echo GetLightText(); ?> !important;
    }

    body.light-theme .pls i {
        color: #fff !important;
    }

    body.light-theme header#main-header {
        background-color: <?php echo GetLightBg(); ?> !important;
        color: <?php echo GetLightText(); ?>;
        box-shadow: 0 0 50px #ccc;
    }
    body.light-theme #translator-table_filter input[type="search"]{
        color: <?php echo GetLightText(); ?>;
    }
    body.light-theme .ugc-text{
        color:<?php echo GetLightText(); ?> !important;
    }
   .ugc-text{
        color:rgb(255, 255, 255) !important;
    }

    body.light-theme footer {
        background-color: <?php echo GetLightBg(); ?> !important;
        color: <?php echo GetLightText(); ?>;
        box-shadow: 0 0 50px #ccc;

    }

    body.light-theme .copyright {
        background-color: <?php echo GetLightBg(); ?>;
        color: <?php echo GetLightText(); ?>;
    } 
    body.light-theme .see {
       
        color: <?php echo GetLightText(); ?>!important;
    }  
    body.light-theme .drama {
       
        color: <?php echo GetLightText(); ?>!important;
        border-right: 1px solid #000!important;
    } 
    body.light-theme .music-play-lists li {
        background: #ed1c24 !important;
        color: #fff!important;
    }

    #toggleIcon{
        width: 75px;
        height: auto;
    }

    body.light-theme span i {

        color: #fff !important;
    } 
    body.light-theme .movie-time i {

        color: #000 !important;
    } 
    body.light-theme .vid-title{

        color: #000 !important;
    }
    body.light-theme .desc p {

        color: #000 !important;
    }
    body.light-theme .fa-star {

        color: #000 !important;
    }

    body.light-theme .dropdown-item.cont-item {
        color: #fff !important;
    }

    body.light-theme .s-icon {
        background-color: <?php echo GetLightBg(); ?>;
        box-shadow: 0 0 50px #ccc;
    }

    body.light-theme .search-toggle:hover,
    header .navbar ul li.menu-item a:hover {
        color: cornflowerblue !important;
    }

    body.light-theme .dropdown-menu.categ-head {
        /*background-color: <?php echo GetLightBg(); ?>!important;  */
        color: <?php echo GetLightText(); ?> !important;
    }

    body.light-theme .navbar-right .iq-sub-dropdown {
        background-color: <?php echo GetLightBg(); ?>;
    }

    body.light-theme .media-body h6 {
        color: <?php echo GetLightText(); ?>;
    }
    body.light-theme .big-title h1 {
        color: <?php echo GetLightText(); ?>!important;
    }
    body.light-theme #username-title{
        color: <?php echo GetLightText(); ?>!important;
    }

    body.light-theme header .navbar ul li {
        font-weight: 400;
    }

    body.light-theme .slick-nav i {
        color: <?php echo GetLightText(); ?> !important;
    }

    body.light-theme .block-description h6 {
        color: <?php echo GetLightText(); ?> !important;
    }

    body.light-theme footer ul li {
        color: <?php echo GetLightText(); ?> !important;
    }

    body.light-theme h6 {
        color: <?php echo GetLightText(); ?> !important;
    }

    body.light-theme .movie-time i {
        color: <?php echo GetLightText(); ?> !important;
    }

    body.light-theme span {
        color: <?php echo GetLightText(); ?> !important;
    }

    
    body.light-theme h1 {
        color: #000 !important;

    }
    body.light-theme .view-count i {
        color: #000 !important;

    }

    body.light-theme .sea {
        color: #fff !important;

    }

    body.light-theme .h3 {
        color: #000 !important;

    }

    body.light-theme .series_title h1 {
        color: #fff !important;

    }

    body.light-theme .form-control {
        color: #000 !important;
        background: #fff !important;
        border: 1px solid #000 !important;

    }

    body.light-theme .menu-item span {
        color: #fff !important;

    }

    body.light-theme .series_title desc {
        color: #fff !important;

    }

    body.light-theme h2 {
        color: #000 !important;

    }

    body.light-theme .navbar-right .iq-sub-dropdown {
        background-image: linear-gradient(to left, rgb(225 228 233 / 0%)0%, rgb(140 142 147)0%, rgb(205 206 209));

    }

    body.light-theme #home-slider h1.slider-text {
        color: #fff !important;

    }

    .fa-2x {
        font-size: 2em;
    }

    .fa {
        position: relative;

        font-size: 20px;
    }


    .main-menu:hover,
    nav.main-menu.expanded {
        width: 250px;
        overflow: visible;
    }

    .main-menu i {
        font-size: 25px;
        padding: 5px 10px;
    }

    .main-menu {
        background: #212121;

        position: absolute;
        top: 0;
        bottom: 0;
        height: 100%;
        left: 0;
        width: 110px;
        overflow: hidden;
        -webkit-transition: width .05s linear;
        transition: width .05s linear;
        -webkit-transform: translateZ(0) scale(1, 1);
        z-index: 1000;
    }

    .main-menu>ul {
        margin: 7px 0;
    }

    .main-menu li {
        position: relative;
        display: block;
        width: 250px;
        padding: 10px 20px;
    }

    .main-menu li>a {
        position: relative;
        display: table;
        border-collapse: collapse;
        border-spacing: 0;
        color: #999;
        font-family: arial;
        font-size: 14px;
        text-decoration: none;
        -webkit-transform: translateZ(0) scale(1, 1);
        -webkit-transition: all .1s linear;
        transition: all .1s linear;

    }

    .main-menu .nav-icon {
        position: relative;
        display: table-cell;
        width: 60px;
        height: 36px;
        text-align: center;
        vertical-align: middle;
        font-size: 18px;
    }

    .main-menu .nav-text {
        position: relative;
        display: table-cell;
        vertical-align: middle;


    }

    .main-menu li {
        color: #fff;
        font-size: 25px;
    }

    .main-menu>ul.logout {
        position: absolute;
        left: 0;
        bottom: 0;
    }

    .no-touch .scrollable.hover {
        overflow-y: hidden;
    }

    .no-touch .scrollable.hover:hover {
        overflow-y: auto;
        overflow: visible;
    }

    a:hover,
    a:focus {
        text-decoration: none;
    }

    nav {
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        -o-user-select: none;
        user-select: none;
    }

    nav ul,
    nav li {
        outline: 0;
        margin: 0;
        padding: 0;
    }

    .main-menu li:hover>a,
    nav.main-menu li.active>a,
    .dropdown-menu>li>a:hover,
    .dropdown-menu>li>a:focus,
    .dropdown-menu>.active>a,
    .dropdown-menu>.active>a:hover,
    .dropdown-menu>.active>a:focus,
    .no-touch .dashboard-page nav.dashboard-menu ul li:hover a,
    .dashboard-page nav.dashboard-menu ul li.active a {
        color: #fff;
        background-color: #000000;
    }

    .area {
        float: left;
        background: #e2e2e2;
        width: 100%;
        height: 100%;
    }

    @font-face {
        font-family: 'Titillium Web';
        font-style: normal;
        font-weight: 300;
        src: local('Titillium Web Light'), local('TitilliumWeb-Light'),
         url(https://fonts.gstatic.com/s/titilliumweb/v11/NaPDcZTIAOhVxoMyOr9n_E7ffGjD9g.ttf) format('truetype');
        /* src: local('Titillium WebLight'), local('TitilliumWeb-Light'), url(http://themes.googleusercontent.com/static/fonts/titilliumweb/v2/anMUvcNT0H1YN4FII8wpr24bNCNEoFTpS2BTjF6FB5E.woff) format('woff'); */
    }

    .sidebar {
        height: 100%;
        width: 63px;
        position: fixed;
        z-index: 1000;
        top: 0;
        left: 0;
        /* background: linear-gradient(160deg,rgb(0, 0, 0),rgb(0, 0, 0),rgb(0, 0, 0),rgb(0, 0, 0),rgba(245, 74, 145, 0.86) ,rgba(243, 203, 56, 0.9), rgba(245, 74, 145, 0.86),rgb(0, 0, 0)); */
        background-color:rgba(0, 0, 0, 0.8);
        /* background-image:    linear-gradient(165deg, rgba(0, 0, 0, 0.9) 45%,rgba(0, 0, 0, 0.9) 45%,rgba(255, 90, 206, 0.9)   ,rgba(251, 218, 97, 0.9) 70%, rgba(255, 90, 206, 0.9) 90%, rgba(0, 0, 0, 0.9) 100%); */
        color: #fff!important;
        transition: 0.6s;
        overflow-x: hidden;
        padding-top: 70px;
        white-space: nowrap;
    }

    .sidebar a {
        padding-left: 12px;
        text-decoration: none;
        font-size: 18px;
        color: #fff !important;
        display: block;
        font-family: 'futurabook';

    }

    .sidebar a:hover {
        color: #f1f1f1;
    }

    main .sidebar {
        position: absolute;
        top: 0;
        right: 25px;
        font-size: 36px;
        margin-left: 50px;
    }

    .material-icons,
    .icon-text {
        vertical-align: middle;
    }

    .material-icons {
        padding-bottom: 3px;
        margin-right: 30px;
    }

    .akm {
        display: flex !important;

    }

    #main {

        margin-left: 50px;
        transition: margin-left 0.8s;
    }

    .sidebar img {
        padding-right: 10px;
        height: 30px;
        width: 45px;
    }

    .akm {
        display: flex !important;
        align-items: center;
    }

    @media screen and (max-height: 450px) {
        .sidebar {
            padding-top: 15px;
        }

        .sidebar a {
            font-size: 16px;
        }
    }

    #down {
        height: 45px;

    }

    .Search_error_class {
      color: red;
    }
    .mobile-menu-header .btn-close {
        font-weight: 700;
        color: red;
        background-color: transparent;
        border: none;
        position: absolute;
        top: 4%;
        right: 7%;
    }
    @media (min-width: 768px){
    .navbar-expand-lg .navbar-toggler {
        display: none !important;
    }
    }
</style>

<body>
    <!-- loader Start -->
    <?php if( get_image_loader() == 1) { ?>
    <div class="fullpage-loader">
        <div class="fullpage-loader__logo">
            <img class="c-logo  fully" height="200" style=" margin: 0 auto;" src="<?php echo URL::to('/assets/img/nemsatv.png'); ?>"
                alt="<?php echo $settings->website_name; ?>" />

        </div>
    </div>
    <?php } ?>

    <!-- loader Start -->
    <!-- <div id="loading">
         <div id="loading-center">
         </div>
      </div>-->
    <!-- loader END -->
    <!-- Header -->
    <div id="mySidebar" class="sidebar">

        <?php if ($theme_mode == "light" && !empty(@$theme->light_mode_logo)) { ?>
            <a class="mb-0" href="<?php echo URL::to('home'); ?>">
                <img
                    id="toggleIcon"
                    src="<?php echo URL::to('/') . '/public/uploads/settings/' . $theme->dark_mode_logo; ?>"
                    alt="Sidebar Toggle"
                    style="cursor: pointer; position: absolute; top: 2px; left: -2px;"
                />
            </a>
        <?php } else { ?>
            <a class="mb-0" href="<?php echo URL::to('home'); ?>">
                <img
                    id="toggleIcon"
                    src="<?php echo URL::to('/') . '/public/uploads/settings/' . $theme->dark_mode_logo; ?>"
                    alt="Sidebar Toggle"
                    style="cursor: pointer; position: absolute; top: 2px; left: -2px;"
                />
            </a>
        <?php } ?>
 

        <div id="menuIcon" onclick="toggleSidebar()" style="cursor: pointer; padding-left:20px; font-size: 24px;">
            &#9776;
        </div>

        <ul id="" class="nav navbar-nav <?php if (Session::get('locale') == 'arabic') {
            echo 'navbar-right';
        } else {
            echo 'navbar-left';
        } ?>">

            <?php
                                        $stripe_plan = SubscriptionPlan();
                                       //  $menus = App\Menu::all();
                                       $menus = App\Menu::orderBy('order', 'asc')->get();
                                        $languages = App\Language::all();
                                        foreach ($menus as $menu) { 
                                        if ( $menu->in_menu == "video") { 
                                          $cat = App\VideoCategory::orderBy("order")->where('in_home',1)->get();
                                          ?>

            <li class="dropdown menu-item">
                <a class="dropdown-toggle" id="down" href="<?php echo URL::to('/') . $menu->url; ?>" data-toggle="dropdown" aria-label="<?php echo __($menu->name); ?>">
                    <a style="height:45px;" class="d-flex  align-items-center" href="<?php echo URL::to('/categoryList'); ?>" aria-label="<?php echo __($menu->name); ?>"> 
                        <img class="menu-items" src="<?php echo $menu->image; ?>" alt="menu-item" /> <span style="padding-left:10px;" ><?php echo __($menu->name); ?></span> 
                        <!--  <i class="ri-arrow-down-s-line"></i>-->
                    </a>
                </a>


                <ul class="dropdown-menu categ-head">
                    <?php foreach ( $cat->take(4) as $category) { ?>
                    <li>
                        <a class="dropdown-item cont-item" style="text-decoration: none!important;"
                            href="<?php echo URL::to('/') . '/category/' . $category->slug; ?>" aria-label="<?php echo __($category->name); ?>">
                            <?php echo $category->name; ?>
                        </a>
                    </li>
                    <?php } ?>

                    <li>
                        <a class="dropdown-item cont-item" style="text-decoration: none!important;"
                            href="<?php echo URL::to('/categoryList'); ?>" aria-label="More">
                            <?php echo 'More...'; ?>
                        </a>
                    </li>

                </ul>
            </li>
            <?php } elseif ( $menu->in_menu == "movies") { 
                                        $cat = App\VideoCategory::orderBy('order', 'asc')->get();
                                        ?>
            <li class="dropdown menu-item">
                <a class="dropdown-toggle" id="down" href="<?php echo URL::to('/') . $menu->url; ?>" data-toggle="dropdown" aria-label="<?php echo __($menu->name); ?>">
                    <a style="height:45px;" class="d-flex align-items-center" href="<?php echo URL::to('/Movie-list'); ?>" aria-label="<?php echo __($menu->name); ?>"> 
                        <img class="menu-items" src="<?php echo $menu->image; ?>" alt="menu-item"/> <span style="padding-left:10px;" ><?php echo __($menu->name); ?></span>
                        <!--<i class="ri-arrow-down-s-line"></i>-->
                    </a>
                </a>
                <ul class="dropdown-menu categ-head">
                    <?php foreach ( $languages as $language){ ?>
                    <li>
                        <a class="dropdown-item cont-item" href="<?php echo URL::to('/') . '/language/' . $language->id . '/' . $language->name; ?>" aria-label="<?php echo __($language->name); ?>">
                            <?php echo $language->name; ?>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php }elseif ( $menu->in_menu == "live") { 
                                       //  $LiveCategory = App\LiveCategory::all();
                                       $LiveCategory = App\LiveCategory::orderBy('order', 'asc')->get();
                                        ?>
            <li class="dropdown menu-item">
                <a class="dropdown-toggle" id="down" href="<?php echo URL::to('/') . $menu->url; ?>" data-toggle="dropdown" aria-label="<?php echo __($menu->name); ?>">
                    <a style="height:45px;" class="d-flex align-items-center" href="<?php echo URL::to('/Live-list'); ?>" aria-label="<?php echo __($menu->name); ?>"> 
                        <img class="menu-items" src="<?php echo $menu->image; ?>" alt="menu-item"/> <span style="padding-left:10px;" ><?php echo __($menu->name); ?></span>
                        <!-- <i class="ri-arrow-down-s-line"></i>-->
                    </a>
                </a>
                <ul class="dropdown-menu categ-head">
                    <?php foreach ( $LiveCategory as $category){ ?>
                    <li>
                        <a class="dropdown-item cont-item" href="<?php echo URL::to('/live/category') . '/' . $category->slug; ?>" aria-label="<?php echo __($category->name); ?>">
                            <?php echo $category->name; ?>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <!-- Audios dropdown -->
            <?php }elseif ( $menu->in_menu == "audios") { 
                                 $AudioCategory = App\AudioCategory::orderBy('order', 'asc')->get();
                                 ?>
            <li class="dropdown menu-item">
                <a class="dropdown-toggle" style="height:45px;" id="dn" href="<?php echo URL::to('/') . $menu->url; ?>"
                    data-toggle="dropdown" aria-label="<?php echo __($menu->name); ?>">
                    <?php echo __($menu->name); ?> <i class="fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu categ-head">
                    <?php foreach ( $AudioCategory as $category){ ?>
                    <li>
                        <a class="dropdown-item cont-item" href="<?php echo URL::to('/live/category') . '/' . $category->name; ?>" aria-label="<?php echo __($category->name); ?>">
                            <?php echo $category->name; ?>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <!-- Tv show dropdown -->

            <?php }elseif ( $menu->in_menu == "tv_show") { 
                                             $tv_shows_series = App\Series::get();
                                          ?>
            <li class="dropdown menu-item">
                <a class="" id="" href="<?php echo URL::to('/') . $menu->url; ?>" aria-label="<?php echo __($menu->name); ?>"> <a
                        class="d-flex justify-content-between" href="<?php echo URL::to('/Movie-list'); ?>" aria-label="<?php echo __($menu->name); ?>"> <?php echo __($menu->name); ?>

                        <?php echo __($menu->name); ?> <i class="fa fa-angle-down"></i>
                    </a>
                    <?php if(count($tv_shows_series) > 0 ){ ?>
                    <ul class="dropdown-menu categ-head">
                        <?php foreach ( $tv_shows_series->take(6) as $key => $tvshows_series){ ?>
                            <li>
                                <?php if($key < 5): ?>
                                    <a class="dropdown-item cont-item" href="<?php echo URL::to('/play_series') . '/' . $tvshows_series->slug; ?>" aria-label="<?php echo __($tvshows_series->name); ?>">
                                        <?php echo $tvshows_series->title; ?>
                                    </a>
                                <?php else: ?>
                                    <a class="dropdown-item cont-item text-primary" href="<?php echo URL::to('/series/list');?>" aria-label="More"> 
                                        <?php echo 'More...';?> 
                                    </a>
                                <?php endif; ?>
                            </li>
                        <?php } ?>
                    </ul>
                    <?php } ?>
            </li>

            <?php } else { ?>
            <li class="menu-item">
                <a class="akm" href="<?php if ($menu->select_url == 'add_Site_url') {
                    echo URL::to('/') . $menu->url;
                } elseif ($menu->select_url == 'add_Custom_url') {
                    echo $menu->custom_url;
                } ?>" aria-label="<?php echo __($menu->name); ?>">
                    <!-- <img class=""  src="<?php echo URL::to('/assets/img/home.png'); ?>" /> <span class="mt-2" ><?php echo __($menu->name); ?></span> -->
                    <img class="menu-items" src="<?php echo $menu->image; ?>" alt="menu-item" /> <span style="padding-left:10px;" ><?php echo __($menu->name); ?></span>

                </a>
            </li>
            <?php } } ?>
            <!-- <li class="nav-item dropdown menu-item"> -->
            <!-- <a class="dropdown-toggle" href="<?php echo URL::to('/') . $menu->url; ?>" data-toggle="dropdown">   -->
            <!-- Movies <i class="fa fa-angle-down"></i> -->
            <!-- </a> -->
            <!-- <ul class="dropdown-menu categ-head"> -->
            <?php //foreach ( $languages as $language) {
            ?>
            <li>
                <!-- <a class="dropdown-item cont-item" href="<?php //echo URL::to('/').'/language/'.$language->id.'/'.$language->name;
                ?>">  -->
                <?php //echo $language->name;
                ?>
                <!-- </a> -->
                <!-- </li> -->

                <?php //}
                ?>
                <!-- </ul> -->
                <!-- </li> -->
            <li class="">
                <!--<a href="<?php echo URL::to('refferal'); ?>" style="color: #4895d1 !important;list-style: none;
                                                                                               font-weight: bold;
                                                                                               font-size: 16px;">
                                              <?php echo __('Refer and Earn'); ?>
                                            </a>-->
            </li>
        </ul>
    </div>

    <div id="main">
        <header id="main-header">
            <div class="main-header">
                <div class="" style="z-index:10000;" >
                    <div class="row">
                        <div class="col-sm-12">
                            <nav class="navbar navbar-expand-lg navbar-light p-0">
        
                                <a href="#" class="navbar-toggler c-toggler" data-toggle="collapse"
                                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                    aria-expanded="false" aria-label="Toggle navigation">
                                    <div class="navbar-toggler-icon" data-toggle="collapse">
                                        <i class="fa fa-bars" aria-hidden="true"></i>
                                    </div>
                                </a>
                                <!-- <?php if($theme_mode == "light" && !empty(@$theme->light_mode_logo)){  ?>
                                <a class="navbar-brand mb-0" href="<?php echo URL::to('home'); ?>"> <img
                                        src="<?php echo URL::to('/') . '/public/uploads/settings/' . $theme->light_mode_logo; ?>" class="c-logo logo-img" alt="<?php echo $settings->website_name; ?>"> </a>
                                <?php }elseif($theme_mode != "light" && !empty(@$theme->dark_mode_logo)){ ?>
                                <a class="navbar-brand mb-0" href="<?php echo URL::to('home'); ?>"> <img
                                        src="<?php echo URL::to('/') . '/public/uploads/settings/' . $theme->dark_mode_logo; ?>" class="c-logo logo-img" alt="<?php echo $settings->website_name; ?>"> </a>
                                <?php }else { ?>
                                <a class="navbar-brand mb-0" href="<?php echo URL::to('home'); ?>"> <img
                                        src="<?php echo URL::to('/') . '/public/uploads/settings/' . $settings->logo; ?>" class="c-logo logo-img" alt="<?php echo $settings->website_name; ?>"> </a>
                                <?php } ?> -->

                                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                    <div class="mobile-menu-header">
                                        <div class="btn-close" data-toggle="collapse">
                                            <a type="button" href="#" class="navbar-toggler c-toggler p-0 border-0" data-toggle="collapse"
                                                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                                aria-expanded="false" aria-label="Toggle navigation" data-bs-toggle="modal" data-bs-target="#staticBackdrop" style="
                                                border-top: none; float:right"><i class="fa fa-times" style="
                                                font-size: 20px;
                                                color: white;"></i>
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <div class="menu-main-menu-container">
                                        <!--                              <ul id="top-menu" class="navbar-nav ml-auto">
                                 <li class="menu-item">
                                    <a href="<?php echo URL::to('home'); ?>">Home</a>
                                 </li>
                                 <li class="menu-item">
                                    <a href="<?php echo URL::to('home'); ?>">Tv Shows</a>
                                 </li>
                                 <li class="menu-item">
                                    <a href="href="<?php echo URL::to('home'); ?>"">Movies</a>
                                 </li>
                                </ul>-->
                                        <ul id="top-menu" class="nav navbar-nav <?php if (Session::get('locale') == 'arabic') {
                                            echo 'navbar-right';
                                        } else {
                                            echo 'navbar-left';
                                        } ?>">
                                            <?php
                                        $stripe_plan = SubscriptionPlan();
                                        if(!Auth::guest() && Auth::User()->role != 'admin' || Auth::guest()){
                                          $menus = App\Menu::orderBy('order', 'asc')->where('in_home','!=',0)->orWhere('in_home', '=', null)->get();
                                       }else{
                                          $menus = App\Menu::orderBy('order', 'asc')->get();
                                       }                                        $languages = App\Language::all();
                                        foreach ($menus as $menu) { 
                                        if ( $menu->in_menu == "video") { 
                                          $cat = App\VideoCategory::orderBy("order")->where('in_home',1)->get();
                                          ?>
                                            <li class="dropdown menu-item d-flex align-items-center">
                                                <div>  <img  height="30" width="30" class="" src="<?php echo $menu->image; ?>" /> </div>
                                                <div>  <a class="dropdown-toggle" id="down"
                                                    href="<?php echo URL::to('/') . $menu->url; ?>" data-toggle="dropdown">
                                                   
                                                    <a class="d-flex justify-content-between"
                                                        href="<?php echo URL::to('/categoryList'); ?>"> <?php echo __($menu->name); ?>
                                                        <!--  <i class="ri-arrow-down-s-line"></i>-->
                                                    </a>
                                                </a></div>
                                               
                                              


                                                <ul class="dropdown-menu categ-head">
                                                    <?php foreach ( $cat->take(4) as $category) { ?>
                                                    <li>
                                                        <a class="dropdown-item cont-item"
                                                            style="text-decoration: none!important;"
                                                            href="<?php echo URL::to('/') . '/category/' . $category->slug; ?>">
                                                            <?php echo $category->name; ?>
                                                        </a>
                                                    </li>
                                                    <?php } ?>

                                                    <li>
                                                        <a class="dropdown-item cont-item"
                                                            style="text-decoration: none!important;"
                                                            href="<?php echo URL::to('/categoryList'); ?>">
                                                            <?php echo 'More...'; ?>
                                                        </a>
                                                    </li>

                                                </ul>
                                            </li>
                                            <?php } elseif ( $menu->in_menu == "movies") { 
                                        $cat = App\VideoCategory::orderBy('order', 'asc')->get();
                                        ?>
                                            <li class="dropdown menu-item d-flex align-items-center">
                                                <div> <img  height="30" width="30" class="" src="<?php echo $menu->image; ?>" /> </div>
                                                <div>  <a class="dropdown-toggle" id="down"
                                                    href="<?php echo URL::to('/') . $menu->url; ?>" data-toggle="dropdown">
                                                    <a class="d-flex justify-content-between"
                                                        href="<?php echo URL::to('/Movie-list'); ?>"> <?php echo __($menu->name); ?>
                                                        <!--<i class="ri-arrow-down-s-line"></i>-->
                                                    </a>
                                                </a></div>
                                                
                                              
                                                <ul class="dropdown-menu categ-head">
                                                    <?php foreach ( $languages as $language){ ?>
                                                    <li>
                                                        <a class="dropdown-item cont-item"
                                                            href="<?php echo URL::to('/') . '/language/' . $language->id . '/' . $language->name; ?>">
                                                            <?php echo $language->name; ?>
                                                        </a>
                                                    </li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                            <?php }elseif ( $menu->in_menu == "live") { 
                                       //  $LiveCategory = App\LiveCategory::all();
                                       $LiveCategory = App\LiveCategory::orderBy('order', 'asc')->get();
                                        ?>
                                            <li class="dropdown menu-item d-flex d-flex align-items-center">
                                                <div> <img  height="30" width="30" class="" src="<?php echo $menu->image; ?>" /> </div>
                                                <div> <a class="dropdown-toggle" id="down"
                                                    href="<?php echo URL::to('/') . $menu->url; ?>" data-toggle="dropdown">
                                                    <a class="d-flex justify-content-between"
                                                        href="<?php echo URL::to('/Live-list'); ?>"> <?php echo __($menu->name); ?>
                                                        <!-- <i class="ri-arrow-down-s-line"></i>-->
                                                    </a>
                                                </a></div>
                                                
                                               
                                                <ul class="dropdown-menu categ-head">
                                                    <?php foreach ( $LiveCategory as $category){ ?>
                                                    <li>
                                                        <a class="dropdown-item cont-item"
                                                            href="<?php echo URL::to('/live/category') . '/' . $category->name; ?>">
                                                            <?php echo $category->name; ?>
                                                        </a>
                                                    </li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                            <!-- Audios dropdown -->
                                            <?php }elseif ( $menu->in_menu == "audios") { 
                                 $AudioCategory = App\AudioCategory::orderBy('order', 'asc')->get();
                                 ?>
                                            <li class="dropdown menu-item d-flex align-items-center">
                                                <div>  <img  height="30" width="30" class="" src="<?php echo $menu->image; ?>" /> </div>
                                                <div>   <a class="dropdown-toggle" id="dn"
                                                    href="<?php echo URL::to('/') . $menu->url; ?>" data-toggle="dropdown">
                                                    <?php echo __($menu->name); ?> <i class="fa fa-angle-down"></i>
                                                </a></div>
                                               
                                             
                                                <ul class="dropdown-menu categ-head">
                                                    <?php foreach ( $AudioCategory as $category){ ?>
                                                    <li>
                                                        <a class="dropdown-item cont-item"
                                                            href="<?php echo URL::to('/live/category') . '/' . $category->name; ?>">
                                                            <?php echo $category->name; ?>
                                                        </a>
                                                    </li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                            <!-- Tv show dropdown -->

                                            <?php }elseif ( $menu->in_menu == "tv_show") { 
                                             $tv_shows_series = App\Series::get();
                                          ?>
                                            <li class="dropdown menu-item d-flex align-items-center">
                                                <div>  <img  height="30" width="30" class="" src="<?php echo $menu->image; ?>" /> </div>
                                                <div> <a class="" id="" href="<?php echo URL::to('/') . $menu->url; ?>">
                                                    <?php echo __($menu->name); ?> <i class="fa fa-angle-down"></i>
                                                </a></div>
                                               
                                               
                                                <?php if(count($tv_shows_series) > 0 ){ ?>
                                                <ul class="dropdown-menu categ-head">
                                                    <?php foreach ( $tv_shows_series as $tvshows_series){ ?>
                                                    <li>
                                                        <a class="dropdown-item cont-item"
                                                            href="<?php echo URL::to('/play_series') . '/' . $tvshows_series->slug; ?>">
                                                            <?php echo $tvshows_series->title; ?>
                                                        </a>
                                                    </li>
                                                    <?php } ?>
                                                </ul>
                                                <?php } ?>
                                            </li>

                                            <?php } else { ?>
                                            <li class="menu-item d-flex align-items-center">
                                               <div><img  height="30" width="30" class="" src="<?php echo $menu->image; ?>" /> </div> 
                                               <div>  <a href="<?php if ($menu->select_url == 'add_Site_url') {
                                                    echo URL::to('/') . $menu->url;
                                                } elseif ($menu->select_url == 'add_Custom_url') {
                                                    echo $menu->custom_url;
                                                } ?>">
                                                    <?php echo __($menu->name); ?>
                                                </a></div> 
                                           
                                            </li>
                                            <?php } } ?>
                                            <!-- <li class="nav-item dropdown menu-item"> -->
                                            <!-- <a class="dropdown-toggle" href="<?php echo URL::to('/') . $menu->url; ?>" data-toggle="dropdown">   -->
                                            <!-- Movies <i class="fa fa-angle-down"></i> -->
                                            <!-- </a> -->
                                            <!-- <ul class="dropdown-menu categ-head"> -->
                                            <?php //foreach ( $languages as $language) {
                                            ?>
                                            <div class="mobile-side-menus d-flex justify-content-end"> 
                                                <?php if(Auth::guest()): ?>
                                                    <?php if( $theme->signin_header == 1 ): ?>
                                                        <li class="nav-item nav-icon">
                                                            <!-- <img src="<?php echo URL::to('/') . '/public/uploads/avatars/lockscreen-user.png'; ?>" class="img-fluid avatar-40 rounded-circle" alt="user">-->
                                                            <a href="<?php echo URL::to('login'); ?>" class="iq-sub-card">
                                                                <div class="media align-items-center">
                                                                    <div class="right-icon">
                                                                        <svg version="1.1" id="Layer_1"
                                                                            xmlns="http://www.w3.org/2000/svg" x="0"
                                                                            y="0" viewBox="0 0 70 70"
                                                                            style="enable-background:new 0 0 70 70"
                                                                            xml:space="preserve">
                                                                            <path class="st5"
                                                                                d="M13.4 33.7c0 .5.2.9.5 1.2.3.3.8.5 1.2.5h22.2l-4 4.1c-.4.3-.6.8-.6 1.3s.2 1 .5 1.3c.3.3.8.5 1.3.5s1-.2 1.3-.6l7.1-7.1c.7-.7.7-1.8 0-2.5l-7.1-7.1c-.7-.6-1.7-.6-2.4.1s-.7 1.7-.1 2.4l4 4.1H15.2c-1 .1-1.8.9-1.8 1.8z" />
                                                                            <path class="st5"
                                                                                d="M52.3 17.8c0-1.4-.6-2.8-1.6-3.7-1-1-2.3-1.6-3.7-1.6H27.5c-1.4 0-2.8.6-3.7 1.6-1 1-1.6 2.3-1.6 3.7v7.1c0 1 .8 1.8 1.8 1.8s1.8-.8 1.8-1.8v-7.1c0-1 .8-1.8 1.8-1.8H47c.5 0 .9.2 1.2.5.3.3.5.8.5 1.2v31.8c0 .5-.2.9-.5 1.2-.3.3-.8.5-1.2.5H27.5c-1 0-1.8-.8-1.8-1.8v-7.1c0-1-.8-1.8-1.8-1.8s-1.8.8-1.8 1.8v7.1c0 1.4.6 2.8 1.6 3.7 1 1 2.3 1.6 3.7 1.6H47c1.4 0 2.8-.6 3.7-1.6 1-1 1.6-2.3 1.6-3.7V17.8z" />
                                                                        </svg>
                                                                    </div>
                                                                    <div class="media-body ml-3">
                                                                        <h6 class="mb-0 ">Signin</h6>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </li>
                                                        <!-- <li class="nav-item nav-icon">
                                                            <a href="<?php echo URL::to('signup'); ?>" class="iq-sub-card">
                                                                <div class="media align-items-center">
                                                                    <div class="right-icon">
                                                                        <svg version="1.1" id="Layer_1"
                                                                            xmlns="http://www.w3.org/2000/svg" x="0"
                                                                            y="0" viewBox="0 0 70 70"
                                                                            style="enable-background:new 0 0 70 70"
                                                                            xml:space="preserve">
                                                                            <path class="st6"
                                                                                d="M53.4 33.7H30.7M36.4 28.1l-5.7 5.7 5.7 5.7" />
                                                                            <path class="st6"
                                                                                d="M50.5 43.7c-2.1 3.4-5.3 5.9-9.1 7.3-3.7 1.4-7.8 1.6-11.7.4a18.4 18.4 0 0 1-9.6-28.8c2.4-3.2 5.8-5.5 9.6-6.6 3.8-1.1 7.9-1 11.7.4 3.7 1.4 6.9 4 9.1 7.3" />
                                                                        </svg>
                                                                    </div>
                                                                    <div class="media-body ml-3">
                                                                        <h6 class="mb-0 ">Signup</h6>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </li> -->
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                                <?php if(!Auth::guest()){ ?>
                                                    <a href="<?php echo URL::to('logout'); ?>"  class="iq-sub-card setting-dropdown">
                                                        <div class="media align-items-center">
                                                            <div class="right-icon">
                                                                <svg version="1.1" id="Layer_1"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    x="0" y="0"
                                                                    viewBox="0 0 70 70"
                                                                    style="enable-background:new 0 0 70 70"
                                                                    xml:space="preserve">
                                                                    <path class="st6"
                                                                        d="M53.4 33.7H30.7M36.4 28.1l-5.7 5.7 5.7 5.7" />
                                                                    <path class="st6"
                                                                        d="M50.5 43.7c-2.1 3.4-5.3 5.9-9.1 7.3-3.7 1.4-7.8 1.6-11.7.4a18.4 18.4 0 0 1-9.6-28.8c2.4-3.2 5.8-5.5 9.6-6.6 3.8-1.1 7.9-1 11.7.4 3.7 1.4 6.9 4 9.1 7.3" />
                                                                </svg>
                                                            </div>
                                                            <div class="media-body ml-3">
                                                                <h6 class="mb-0 ">Sign Out</h6>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <a href="<?php echo URL::to('myprofile'); ?>"
                                                            class="iq-sub-card setting-dropdown">
                                                            <div class="media align-items-center">
                                                                <div class="right-icon">

                                                                    <svg version="1.1" id="Layer_1"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                        x="0px" y="0px"
                                                                        viewBox="0 0 70 70"
                                                                        style="enable-background:new 0 0 70 70;"
                                                                        xml:space="preserve">
                                                                        <style type="text/css">
                                                                            .st0 {}
                                                                        </style>
                                                                        <g>
                                                                            <path class="st0"
                                                                                d="M32,34c-7.4,0-13.4-6-13.4-13.4S24.6,7.1,32,7.1s13.4,6,13.4,13.4S39.4,34,32,34z M32,10.5
		c-5.6,0-10.1,4.5-10.1,10.1S26.4,30.7,32,30.7s10.1-4.5,10.1-10.1S37.6,10.5,32,10.5z" />
                                                                            <path class="st0"
                                                                                d="M38.5,54.2H15.3l0,0v-2.8c0-9,6.8-16.7,15.8-17.2c4.3-0.5,8.4,1.1,11.5,3.6c0.1,0.1,0.5,0.1,0.4,0l1.8-1.8
		c0.5-0.5,0.5-0.5,0.1-0.6c-3.8-3.1-8.6-4.8-13.9-4.5c-10.7,0.6-19,9.9-19,20.6v5.1c0,0.6,0.5,1.1,1.1,1.1h28.8c0.5,0,0.8-0.6,0.4-1
		l-1.4-1.4C40.2,54.5,39.3,54.2,38.5,54.2z" />
                                                                            <path class="st0"
                                                                                d="M62.2,48.6v-2.4c0-0.5-0.2-0.5-0.5-0.5H59c-0.2,0-0.4-0.1-0.5-0.4c-0.1-0.4-0.5-0.7-0.4-1.1
		C58,44,58,43.8,58.2,43.6l1.9-1.9c0.2-0.2,0.2-0.5,0-0.7l-1.7-1.7c-0.2-0.2-0.5-0.2-0.7,0l-2,2c-0.2,0.2-0.4,0.2-0.6,0.1
		c-0.5-0.2-0.7-0.5-1-0.4c-0.2-0.1-0.4-0.5-0.4-0.5v-2.8c0-0.5-0.2-0.5-0.5-0.5h-2.4c-0.5,0-0.5,0.2-0.5,0.5v2.8
		c0,0.2-0.1,0.4-0.4,0.5c-0.4,0.1-0.7,0.2-1,0.4c-0.2,0.1-0.4,0.1-0.6-0.1l-2-2c-0.2-0.2-0.5-0.2-0.7,0L43.9,41
		c-0.2,0.2-0.2,0.5,0,0.7l1.9,1.9c0.2,0.2,0.2,0.4,0.1,0.6c-0.2,0.5-0.5,0.7-0.4,1.1c-0.1,0.2-0.5,0.4-0.5,0.4h-2.7
		c-0.5,0-0.5,0.2-0.5,0.5v2.4c0,0.5,0.2,0.5,0.5,0.5H45c0.2,0,0.4,0.1,0.5,0.4c0.1,0.4,0.5,0.7,0.4,1c0.1,0.2,0.1,0.4-0.1,0.6
		L44.1,53c-0.2,0.2-0.2,0.5,0,0.7l1.7,1.7c0.2,0.2,0.5,0.2,0.7,0l1.9-1.9c0.2-0.2,0.4-0.2,0.6-0.1c0.5,0.2,0.7,0.5,1.1,0.4
		c0.2,0.1,0.4,0.5,0.4,0.5V57c0,0.5,0.2,0.5,0.5,0.5h2.4c0.5,0,0.5-0.2,0.5-0.5v-2.7c0-0.2,0.1-0.4,0.4-0.5c0.4-0.1,0.7-0.5,1-0.4
		c0.2-0.1,0.4-0.1,0.6,0.1l1.9,1.9c0.2,0.2,0.5,0.2,0.7,0l1.7-1.7c0.2-0.2,0.2-0.5,0-0.7l-1.9-1.9c-0.2-0.2-0.2-0.4-0.1-0.6
		c0.2-0.5,0.5-0.7,0.4-1c0.1-0.2,0.5-0.4,0.5-0.4h2.7C62,49.1,62.2,48.9,62.2,48.6z M48.7,47.4c0-0.9,0.4-1.7,1-2.4
		c0.6-0.6,1.5-1,2.4-1s1.7,0.4,2.4,1c0.6,0.6,1,1.5,1,2.4c0,1.7-1.2,3.2-3.3,3.5c-0.1,0-0.1,0-0.2,0C50,50.6,48.7,49.1,48.7,47.4
		L48.7,47.4z" />
                                                                        </g>
                                                                    </svg>
                                                                </div>
                                                                <div class="media-body ml-3">
                                                                    <h6 class="mb-0 ">Manage Profile</h6>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    <?php } ?>
                                            
                                                </div>

                                                
                                            <li>
                                                 <?php                         
                        if(!Auth::guest()){                                                              
                        $ModeratorsUser = App\ModeratorsUser::where('email', Auth::User()->email)->first();
                        $Channel = App\Channel::where('email', Auth::User()->email)->first();
                        }
                        if(!Auth::guest() && !empty($ModeratorsUser)){ ?>
                                <div class="iq-search-bar d-flex">
                                    <form method="POST" action="<?php echo URL::to('cpp/home'); ?>" class="mt-4">
                                        <input type="hidden" name="_token" id="token" value="<?= csrf_token() ?>">
                                        <input id="email" type="hidden" name="email"
                                            value="<?= Auth::user()->email ?>" autocomplete="email" autofocus>
                                        <input id="password" type="hidden" name="password"
                                            value="<?= @$ModeratorsUser->password ?>" autocomplete="current-password">
                                        <button type="submit" class="btn  "
                                            style="">Visit Content Portal </button>
                                    </form>
                                </div>
                                <?php }if(!Auth::guest() && !empty($Channel)){ ?>
                                <div class="iq-search-bar d-flex">
                                    <form method="POST" action="<?php echo URL::to('channel/home'); ?>" class="mt-4">
                                        <input type="hidden" name="_token" id="token" value="<?= csrf_token() ?>">
                                        <input id="email" type="hidden" name="email"
                                            value="<?= Auth::user()->email ?>" autocomplete="email" autofocus>
                                        <input id="password" type="hidden" name="password"
                                            value="<?= @$Channel->unhased_password ?>"
                                            autocomplete="current-password">
                                        <button type="submit" class="btn "
                                            style="">Visit Channel Portal </button>
                                    </form>
                                </div>
                                <?php } ?>
                                                <!-- <a class="dropdown-item cont-item" href="<?php //echo URL::to('/').'/language/'.$language->id.'/'.$language->name;
                                                ?>">  -->
                                                <?php //echo $language->name;
                                                ?>
                                                <!-- </a> -->
                                                <!-- </li> -->

                                                <?php //}
                                                ?>
                                                <!-- </ul> -->
                                                <!-- </li> -->
                                            <li class="">
                                                <!--<a href="<?php echo URL::to('refferal'); ?>" style="color: #4895d1 !important;list-style: none;
                                                                                               font-weight: bold;
                                                                                               font-size: 16px;">
                                              <?php echo __('Refer and Earn'); ?>
                                            </a>-->
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="mobile-more-menu">
                                    <button class="div.slide-item" id="dropdownMenuButton"
                                        data-toggle="div.slide-item" aria-haspopup="true" aria-expanded="false" aria-label="Drop-Down-Menu">
                                        <i class="ri-more-line"></i>
                                    </button>
                                    <div class="more-menu" aria-labelledby="dropdownMenuButton">
                                        <div class="navbar-right position-relative">
                                            <ul class="d-flex align-items-center justify-content-end list-inline m-0">

                                                <li class="hidden-xs">
                                                    <div id="navbar-search-form">
                                                        <form role="search" id="" action="<?php echo URL::to('searchResult') ; ?>"
                                                            method="POST">
                                                            <input name="_token" type="hidden"
                                                                value="<?php echo csrf_token(); ?>">
                                                            <div>
                                                                
                                                                <input type="text" name="search" class="searches form-control"
                                                                    id="searches" autocomplete="off"
                                                                    placeholder="Search movies,series">
                                                                <i class="fa fa-search">
                                                                </i>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div id="search_list" class="search_list"
                                                        style="position: absolute;">
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <?php                         
                        if(!Auth::guest()){                                                              
                        $ModeratorsUser = App\ModeratorsUser::where('email', Auth::User()->email)->first();
                        $Channel = App\Channel::where('email', Auth::User()->email)->first();
                        }

                        

                        if(!Auth::guest() && !empty($ModeratorsUser)){ ?>
                                <div class="iq-search-bar ml-auto" id="hid">
                                    <form method="POST" action="<?php echo URL::to('cpp/home'); ?>" class="mt-4">
                                        <input type="hidden" name="_token" id="token" value="<?= csrf_token() ?>">
                                        <input id="email" type="hidden" name="email"
                                            value="<?= Auth::user()->email ?>" autocomplete="email" autofocus>
                                        <input id="password" type="hidden" name="password"
                                            value="<?= @$ModeratorsUser->password ?>" autocomplete="current-password">
                                        <button type="submit" class="btn btn-style "
                                            style="margin-top: -14%;margin-left: -14%;font-size: 14px;">Visit Content Portal </button>
                                    </form>
                                </div>                    
                                <?php }if(!Auth::guest() && !empty($Channel)){ ?>
                                <div class="iq-search-bar ml-auto" id="hid">
                                    <form method="POST" action="<?php echo URL::to('channel/home'); ?>" class="mt-4">
                                        <input type="hidden" name="_token" id="token" value="<?= csrf_token() ?>">
                                        <input id="email" type="hidden" name="email"
                                            value="<?= Auth::user()->email ?>" autocomplete="email" autofocus>
                                        <input id="password" type="hidden" name="password"
                                            value="<?= @$Channel->unhased_password ?>"
                                            autocomplete="current-password">
                                        <button type="submit" class="btn btn-style"
                                            style="margin-top: -11%;margin-left: -8%;font-size: 14px;">Visit Channel Portal </button>
                                    </form>
                                </div>
                                
                                <?php } ?>
                                <div class="navbar-right menu-right d-flex">
                                    <ul class="d-flex align-items-center list-inline m-0">
                                        <?php if(Auth::guest()): ?>
                                            <div class="iq-search-bar ml-auto" id="hid">
                                                <a href="<?php echo URL::to('channel/login') ?>">
                                                    <button class="btn btn-style" ><?= __('Visit Channel Portal') ?></button>
                                                </a>
                                            </div> 
                                            <div class="text-right p-1" style="border-radius:20px; font-size: 15px; font-weight:bold; margin:0px 10px; background-color: #ed1c24 " >
                                                <a href="<?php echo URL::to('login'); ?>" style="padding: 15px;">Upload Your Own Content</a>  
                                            </div>
                                        <?php endif ; ?>
                                        
                                        <li class="nav-item nav-icon">
                                            <div class="search-box iq-search-bar d-search">
                                                <form id="searchResult" action="<?php echo URL::to('searchResult'); ?>" method="post" class="searchbox">
                                                    <input name="_token" type="hidden"
                                                        value="<?php echo csrf_token(); ?>" />
                                                    <div class="form-group position-relative" style="background-color: #8080807d;padding-bottom: 2px;">
                                                        <input type="text" name="search" class="text search-input font-size-12 searches"
                                                            placeholder="Type Here" />
                                                        <?php include 'public/themes/theme5-nemisha/partials/Search_content.php'; ?>
                                                    </div>
                                                </form>
                                                <div class="iq-card-body" style="margin-top: -15px;background-color: #000;">
                                                    <div id="search_list"
                                                        class="search_list search-toggle device-search">
                                                    </div>
                                                </div>
                                            </div>

                                            <a href="<?php echo URL::to('/') . '/searchResult'; ?>" class="search-toggle device-search" aria-label="Search-Toogle">
                                                <i class="fa fa-search" aria-hidden="true"></i>
                                            </a>

                                            <div class="iq-sub-dropdown search_content overflow-auto" id="sidebar-scrollbar"></div>
                                        </li>
                                        <li>
                                          
                                                    <div class="bg-cocreataz text-right p-1" style="border-radius:10px;" >
                                                        <a href="<?php echo URL::to('ugc-create'); ?>" >
                                                            <svg  viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <g>
                                                                    <path fill="none" d="M0 0H24V24H0z"/>
                                                                    <path d="M16 4c.552 0 1 .448 1 1v4.2l5.213-3.65c.226-.158.538-.103.697.124.058.084.09.184.09.286v12.08c0 .276-.224.5-.5.5-.103 0-.203-.032-.287-.09L17 14.8V19c0 .552-.448 1-1 1H2c-.552 0-1-.448-1-1V5c0-.552.448-1 1-1h14zm-1 2H3v12h12V6zM9 8l4 4h-3v4H8v-4H5l4-4zm12 .841l-4 2.8v.718l4 2.8V8.84z"/>
                                                                </g>
                                                            </svg>
                                                        </a>
                                                    </div>
                                              
                                        </li>
 
                                        <li class="nav-item nav-icon">
                                         
                                            <div class="iq-sub-dropdown">
                                                <div class="iq-card shadow-none m-0">
                                                    <div class="iq-card-body">
                                                        <a href="#" class="iq-sub-card">
                                                            <div class="media align-items-center">
                                                                <img src="assets/images/notify/thumb-1.jpg"
                                                                    class="img-fluid mr-3" alt="streamit" />
                                                                <div class="media-body">
                                                                    <h6 class="mb-0 ">Boot Bitty</h6>
                                                                    <small class="font-size-12"> just now</small>
                                                                </div>
                                                            </div>
                                                        </a>
                                                        <a href="#" class="iq-sub-card">
                                                            <div class="media align-items-center">
                                                                <img src="assets/images/notify/thumb-2.jpg"
                                                                    class="img-fluid mr-3" alt="streamit" />
                                                                <div class="media-body">
                                                                    <h6 class="mb-0 ">The Last Breath</h6>
                                                                    <small class="font-size-12">15 minutes ago</small>
                                                                </div>
                                                            </div>
                                                        </a>
                                                        <a href="#" class="iq-sub-card">
                                                            <div class="media align-items-center">
                                                                <img src="assets/images/notify/thumb-3.jpg"
                                                                    class="img-fluid mr-3" alt="streamit" />
                                                                <div class="media-body">
                                                                    <h6 class="mb-0 ">The Hero Camp</h6>
                                                                    <small class="font-size-12">1 hour ago</small>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>

                                        <?php if(Auth::guest()): ?>
                                            <?php if( $theme->signin_header == 1 ): ?>
                                                <li class="nav-item nav-icon">
                                                    <!-- <img src="<?php echo URL::to('/') . '/public/uploads/avatars/lockscreen-user.png'; ?>" class="img-fluid avatar-40 rounded-circle" alt="user">-->
                                                    <a href="<?php echo URL::to('login'); ?>" class="iq-sub-card">
                                                        <div class="media align-items-center">
                                                            <div class="right-icon">
                                                                <svg version="1.1" id="Layer_1"
                                                                    xmlns="http://www.w3.org/2000/svg" x="0"
                                                                    y="0" viewBox="0 0 70 70"
                                                                    style="enable-background:new 0 0 70 70"
                                                                    xml:space="preserve">
                                                                    <path class="st5"
                                                                        d="M13.4 33.7c0 .5.2.9.5 1.2.3.3.8.5 1.2.5h22.2l-4 4.1c-.4.3-.6.8-.6 1.3s.2 1 .5 1.3c.3.3.8.5 1.3.5s1-.2 1.3-.6l7.1-7.1c.7-.7.7-1.8 0-2.5l-7.1-7.1c-.7-.6-1.7-.6-2.4.1s-.7 1.7-.1 2.4l4 4.1H15.2c-1 .1-1.8.9-1.8 1.8z" />
                                                                    <path class="st5"
                                                                        d="M52.3 17.8c0-1.4-.6-2.8-1.6-3.7-1-1-2.3-1.6-3.7-1.6H27.5c-1.4 0-2.8.6-3.7 1.6-1 1-1.6 2.3-1.6 3.7v7.1c0 1 .8 1.8 1.8 1.8s1.8-.8 1.8-1.8v-7.1c0-1 .8-1.8 1.8-1.8H47c.5 0 .9.2 1.2.5.3.3.5.8.5 1.2v31.8c0 .5-.2.9-.5 1.2-.3.3-.8.5-1.2.5H27.5c-1 0-1.8-.8-1.8-1.8v-7.1c0-1-.8-1.8-1.8-1.8s-1.8.8-1.8 1.8v7.1c0 1.4.6 2.8 1.6 3.7 1 1 2.3 1.6 3.7 1.6H47c1.4 0 2.8-.6 3.7-1.6 1-1 1.6-2.3 1.6-3.7V17.8z" />
                                                                </svg>
                                                            </div>
                                                            <div class="media-body ml-3">
                                                                <h6 class="mb-0 ">Signin</h6>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <!-- <li class="nav-item nav-icon">
                                                    <a href="<?php echo URL::to('signup'); ?>" class="iq-sub-card">
                                                        <div class="media align-items-center">
                                                            <div class="right-icon">
                                                                <svg version="1.1" id="Layer_1"
                                                                    xmlns="http://www.w3.org/2000/svg" x="0"
                                                                    y="0" viewBox="0 0 70 70"
                                                                    style="enable-background:new 0 0 70 70"
                                                                    xml:space="preserve">
                                                                    <path class="st6"
                                                                        d="M53.4 33.7H30.7M36.4 28.1l-5.7 5.7 5.7 5.7" />
                                                                    <path class="st6"
                                                                        d="M50.5 43.7c-2.1 3.4-5.3 5.9-9.1 7.3-3.7 1.4-7.8 1.6-11.7.4a18.4 18.4 0 0 1-9.6-28.8c2.4-3.2 5.8-5.5 9.6-6.6 3.8-1.1 7.9-1 11.7.4 3.7 1.4 6.9 4 9.1 7.3" />
                                                                </svg>
                                                            </div>
                                                            <div class="media-body ml-3">
                                                                <h6 class="mb-0 ">Signup</h6>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li> -->
                                            <?php endif ; ?>


                                        <?php else: ?>
                                        <li class="nav-item nav-icon">
                                            <a href="#"
                                                class="iq-user-dropdown  search-toggle p-0 d-flex align-items-center"
                                                data-toggle="search-toggle">
                                                
                                                <?php if(Auth::user() && Auth::user()->avatar != null): ?>
                                                    <img src="<?php echo URL::to('public/uploads/avatars/' . Auth::user()->avatar); ?>" class="img-fluid avatar-40 rounded-circle" alt="avatar image">
                                                <?php else: ?>
                                                    <img src="<?php echo URL::to('/assets/img/placeholder.webp'); ?>" class="img-fluid avatar-40 rounded-circle" alt="avatar image">
                                                <?php endif; ?>


                                                <p id="username-title" class="ml-3 mt-3">

                                                    <?php
                                                    $subuser = Session::get('subuser_id');
                                                    if ($subuser != '') {
                                                        $subuser = App\Multiprofile::where('id', $subuser)->first();
                                                        echo $subuser->user_name;
                                                    } else {
                                                        echo Auth::user()->username . ' ' . ' ';
                                                    }
                                                    
                                                    ?>

                                                    <i class="ri-arrow-down-s-line"></i>

                                                </p>
                                            </a>                                            
                                            <?php if(Auth::user()->role == 'registered'): ?>
                                                <div class="iq-sub-dropdown iq-user-dropdown">
                                                    <div class="iq-card shadow-none m-0">
                                                        <div class="iq-card-body p-0 pl-3 pr-3">

                                                            <a href="#" class="p-0" aria-label="dark-light-mode-toggle">
                                                                <div class=" mt-3 d-flex align-items-center justify-content-between col-lg-7 ">
                                                                    <i class="fa fa-moon-o" aria-hidden="true"></i>
                                                                    <label class="switch toggle mt-2">
                                                                        <input type="checkbox" id="toggle" value=<?php echo $theme_mode; ?>
                                                                            <?php if ($theme_mode == 'light') {
                                                                                echo 'checked';
                                                                            } ?> />
                                                                        <span class="sliderk round"></span>
                                                                    </label>
                                                                    <i class="fa fa-sun-o" aria-hidden="true"></i>
                                                                </div>
                                                            </a>

                                                            <a href="<?php echo URL::to('myprofile'); ?>"
                                                                class="iq-sub-card setting-dropdown">
                                                                <div class="media align-items-center">
                                                                    <div class="right-icon">
                                                                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                            x="0px" y="0px" viewBox="0 0 70 70" style="enable-background:new 0 0 70 70;" xml:space="preserve">
                                                                            <style type="text/css">
                                                                                .st0 {}
                                                                            </style>
                                                                            <g>
                                                                                <path class="st0" d="M32,34c-7.4,0-13.4-6-13.4-13.4S24.6,7.1,32,7.1s13.4,6,13.4,13.4S39.4,34,32,34z M32,10.5c-5.6,0-10.1,4.5-10.1,10.1S26.4,30.7,32,30.7s10.1-4.5,10.1-10.1S37.6,10.5,32,10.5z" />
                                                                                <path class="st0" d="M38.5,54.2H15.3l0,0v-2.8c0-9,6.8-16.7,15.8-17.2c4.3-0.5,8.4,1.1,11.5,3.6c0.1,0.1,0.5,0.1,0.4,0l1.8-1.8c0.5-0.5,0.5-0.5,0.1-0.6c-3.8-3.1-8.6-4.8-13.9-4.5c-10.7,0.6-19,9.9-19,20.6v5.1c0,0.6,0.5,1.1,1.1,1.1h28.8c0.5,0,0.8-0.6,0.4-1l-1.4-1.4C40.2,54.5,39.3,54.2,38.5,54.2z" />
                                                                                <path class="st0" d="M62.2,48.6v-2.4c0-0.5-0.2-0.5-0.5-0.5H59c-0.2,0-0.4-0.1-0.5-0.4c-0.1-0.4-0.5-0.7-0.4-1.1C58,44,58,43.8,58.2,43.6l1.9-1.9c0.2-0.2,0.2-0.5,0-0.7l-1.7-1.7c-0.2-0.2-0.5-0.2-0.7,0l-2,2c-0.2,0.2-0.4,0.2-0.6,0.1c-0.5-0.2-0.7-0.5-1-0.4c-0.2-0.1-0.4-0.5-0.4-0.5v-2.8c0-0.5-0.2-0.5-0.5-0.5h-2.4c-0.5,0-0.5,0.2-0.5,0.5v2.8c0,0.2-0.1,0.4-0.4,0.5c-0.4,0.1-0.7,0.2-1,0.4c-0.2,0.1-0.4,0.1-0.6-0.1l-2-2c-0.2-0.2-0.5-0.2-0.7,0L43.9,41c-0.2,0.2-0.2,0.5,0,0.7l1.9,1.9c0.2,0.2,0.2,0.4,0.1,0.6c-0.2,0.5-0.5,0.7-0.4,1.1c-0.1,0.2-0.5,0.4-0.5,0.4h-2.7c-0.5,0-0.5,0.2-0.5,0.5v2.4c0,0.5,0.2,0.5,0.5,0.5H45c0.2,0,0.4,0.1,0.5,0.4c0.1,0.4,0.5,0.7,0.4,1c0.1,0.2,0.1,0.4-0.1,0.6L44.1,53c-0.2,0.2-0.2,0.5,0,0.7l1.7,1.7c0.2,0.2,0.5,0.2,0.7,0l1.9-1.9c0.2-0.2,0.4-0.2,0.6-0.1c0.5,0.2,0.7,0.5,1.1,0.4c0.2,0.1,0.4,0.5,0.4,0.5V57c0,0.5,0.2,0.5,0.5,0.5h2.4c0.5,0,0.5-0.2,0.5-0.5v-2.7c0-0.2,0.1-0.4,0.4-0.5c0.4-0.1,0.7-0.5,1-0.4c0.2-0.1,0.4-0.1,0.6,0.1l1.9,1.9c0.2,0.2,0.5,0.2,0.7,0l1.7-1.7c0.2-0.2,0.2-0.5,0-0.7l-1.9-1.9c-0.2-0.2-0.2-0.4-0.1-0.6c0.2-0.5,0.5-0.7,0.4-1c0.1-0.2,0.5-0.4,0.5-0.4h2.7C62,49.1,62.2,48.9,62.2,48.6z M48.7,47.4c0-0.9,0.4-1.7,1-2.4c0.6-0.6,1.5-1,2.4-1s1.7,0.4,2.4,1c0.6,0.6,1,1.5,1,2.4c0,1.7-1.2,3.2-3.3,3.5c-0.1,0-0.1,0-0.2,0C50,50.6,48.7,49.1,48.7,47.4L48.7,47.4z" />
                                                                            </g>
                                                                        </svg>
                                                                    </div>
                                                                    <div class="media-body ml-3">
                                                                        <h6 class="mb-0 ">Manage Profile</h6>
                                                                    </div>
                                                                </div>
                                                            </a>

                                                            <a href="<?php echo URL::to('watchlater'); ?>"
                                                                class="iq-sub-card setting-dropdown">
                                                                <div class="media align-items-center">
                                                                    <div class="right-icon">
                                                                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" x="0" y="0"
                                                                            viewBox="0 0 70 70" style="enable-background:new 0 0 70 70" xml:space="preserve">
                                                                            <style>
                                                                                .st0 { fill: #198fcf; stroke: #198fcf; stroke-width: .75; stroke-miterlimit: 10 }
                                                                            </style>
                                                                            <path class="st0" d="M21.5 23.7h14c.2 0 .3.2.3.4v.8c0 .2-.1.4-.3.4h-14c-.2 0-.3-.2-.3-.4V24c0-.1.2-.3.3-.3zM21.5 32h13.4c.2 0 .3.2.3.4v.8c0 .2-.1.4-.3.4H21.5c-.2 0-.3-.2-.3-.4v-.8c0-.2.2-.4.3-.4zM21.5 40.5h23.1c.2 0 .3.2.3.4v.8c0 .2-.1.4-.3.4H21.5c-.2 0-.3-.2-.3-.4v-.7c0-.3.2-.5.3-.5zM21.5 48.7h23.1c.2 0 .3.2.3.4v.8c0 .2-.1.4-.3.4H21.5c-.2 0-.3-.2-.3-.4v-.8c0-.3.2-.4.3-.4z" />
                                                                            <path class="st1" d="M48.4 37c-5.1 0-9.2-4.1-9.2-9.2s4.1-9.2 9.2-9.2 9.2 4.1 9.2 9.2-4.1 9.2-9.2 9.2zm0-16.7c-4.2 0-7.5 3.3-7.5 7.5s3.3 7.5 7.5 7.5 7.5-3.3 7.5-7.5-3.3-7.5-7.5-7.5z"
                                                                                style="fill:#198fcf;stroke:#198fcf;stroke-width:.5;stroke-miterlimit:10" />
                                                                            <path class="st2" d="M52.1 28.7h-3.8c-.4 0-.7-.3-.7-.7v-3.8c0-.2.2-.4.4-.4h.8c.2 0 .4.2.4.4v2.2c0 .4.3.7.7.7h2.2c.2 0 .4.2.4.4v.8c.1.2-.1.4-.4.4z"
                                                                                style="fill:#198fcf" />
                                                                            <path class="st3" d="M54.3 34v20.1c0 1-.8 1.9-1.9 1.9H17.3c-1 0-1.9-.8-1.9-1.9V17.5c0-1 .8-1.9 1.9-1.9h35.1c1 0 1.9.8 1.9 1.9v4.2"
                                                                                style="fill:none;stroke:#198fcf;stroke-width:2;stroke-miterlimit:10" />
                                                                        </svg>
                                                                    </div>
                                                                    <div class="media-body ml-3">
                                                                        <h6 class="mb-0 ">Watch Later</h6>
                                                                    </div>
                                                                </div>
                                                            </a>

                                                            <a href="<?php echo URL::to('mywishlists'); ?>"
                                                                class="iq-sub-card setting-dropdown">
                                                                <div class="media align-items-center">
                                                                    <div class="right-icon">
                                                                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 70 70" style="enable-background:new 0 0 70 70;" xml:space="preserve">
                                                                            <style type="text/css"> .st0 {} </style>
                                                                            <g>
                                                                                <path class="st0" d="M20.9,18.3h-1.2c-0.7,0-1.2-0.5-1.2-1.2s0.5-1.2,1.2-1.2h1.2c0.7,0,1.2,0.5,1.2,1.2S21.5,18.3,20.9,18.3z" />
                                                                                <path class="st0" d="M43.5,18.3H25.6c-0.7,0-1.2-0.5-1.2-1.2s0.5-1.2,1.2-1.2h17.9c0.7,0,1.2,0.5,1.2,1.2S44.1,18.3,43.5,18.3z" />
                                                                                <path class="st0" d="M20.9,25.4h-1.2c-0.7,0-1.2-0.5-1.2-1.2S19,23,19.7,23h1.2c0.7,0,1.2,0.5,1.2,1.2S21.5,25.4,20.9,25.4z" />
                                                                                <path class="st0" d="M43.5,25.4H25.6c-0.7,0-1.2-0.5-1.2-1.2s0.5-1.2,1.2-1.2h17.9c0.7,0,1.2,0.5,1.2,1.2S44.1,25.4,43.5,25.4z" />
                                                                                <path class="st0" d="M20.9,32.5h-1.2c-0.7,0-1.2-0.5-1.2-1.2s0.5-1.2,1.2-1.2h1.2c0.7,0,1.2,0.5,1.2,1.2S21.5,32.5,20.9,32.5z" />
                                                                                <path class="st0" d="M43.5,32.5H25.6c-0.7,0-1.2-0.5-1.2-1.2s0.5-1.2,1.2-1.2h17.9c0.7,0,1.2,0.5,1.2,1.2S44.1,32.5,43.5,32.5z" />
                                                                                <path class="st0" d="M20.9,39.7h-1.2c-0.7,0-1.2-0.5-1.2-1.2s0.5-1.2,1.2-1.2h1.2c0.7,0,1.2,0.5,1.2,1.2S21.5,39.7,20.9,39.7z" />
                                                                                <path class="st0" d="M43.5,39.7H25.6c-0.7,0-1.2-0.5-1.2-1.2s0.5-1.2,1.2-1.2h17.9c0.7,0,1.2,0.5,1.2,1.2S44.1,39.7,43.5,39.7z" />
                                                                                <path class="st0" d="M20.9,46.8h-1.2c-0.7,0-1.2-0.5-1.2-1.2s0.5-1.2,1.2-1.2h1.2c0.7,0,1.2,0.5,1.2,1.2S21.5,46.8,20.9,46.8z" />
                                                                                <path class="st0" d="M56.7,42.9c-1.5-1.5-3.5-2.2-5.5-2.2c-0.5,0-0.5-0.2-0.5-0.5V8.7c0-0.5-0.1-0.6-0.5-0.8s-0.5-0.5-0.8-0.5H13.5 c-0.6,0-1,0.4-1,1V54c0,0.5,0.1,0.6,0.5,0.8s0.5,0.5,0.8,0.5H39c0.1,0,0.5,0.1,0.4,0.1l6.8,6.8c0.5,0.5,1.2,0.5,1.7,0l8.8-8.8l0,0 c1.4-1.4,2.2-3.3,2.2-5.2C58.8,46.1,58.1,44.2,56.7,42.9L56.7,42.9z M36.2,44.4H25.6c-0.7,0-1.2,0.5-1.2,1.2s0.5,1.2,1.2,1.2h9.7 c-0.1,0.4-0.1,0.9-0.1,1.3c0,1.4,0.4,2.7,1.1,3.9c0.2,0.5,0,0.8-0.4,0.8c-3.8,0-17.7,0-20.5,0c-0.5,0-0.5-0.2-0.5-0.5V10.4 c0-0.5,0.2-0.5,0.5-0.5h32.3c0.5,0,0.5,0.2,0.5,0.5v30.7c0,0.2-0.1,0.5-0.5,0.4c-0.5,0.2-0.6,0.4-0.9,0.6c-1.7-1.3-3.9-1.7-5.9-1.3 C39,41.3,37.3,42.6,36.2,44.4L36.2,44.4z M55,51.6l-7.6,7.6c-0.2,0.2-0.5,0.2-0.7,0l-7.6-7.6l0,0c-1.3-1.3-1.8-3.1-1.3-4.9 c0.5-1.7,1.8-3.1,3.6-3.6c2-0.5,4.1,0.2,5.3,1.8c0.2,0.5,0.6,0.5,0.8,0c1.3-1.7,3.4-2.4,5.3-1.8c1.7,0.5,3.1,1.8,3.6,3.6 C56.8,48.5,56.3,50.4,55,51.6L55,51.6z" />
                                                                            </g>
                                                                        </svg>
                                                                    </div>
                                                                    <div class="media-body ml-3">
                                                                        <h6 class="mb-0 ">Wish List</h6>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                
                                                            <a href="<?php echo URL::to('logout'); ?>" class="iq-sub-card setting-dropdown">
                                                                <div class="media align-items-center">
                                                                    <div class="right-icon">
                                                                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" x="0" y="0" viewBox="0 0 70 70" style="enable-background:new 0 0 70 70" xml:space="preserve">
                                                                            <path class="st6" d="M53.4 33.7H30.7M36.4 28.1l-5.7 5.7 5.7 5.7" />
                                                                            <path class="st6" d="M50.5 43.7c-2.1 3.4-5.3 5.9-9.1 7.3-3.7 1.4-7.8 1.6-11.7.4a18.4 18.4 0 0 1-9.6-28.8c2.4-3.2 5.8-5.5 9.6-6.6 3.8-1.1 7.9-1 11.7.4 3.7 1.4 6.9 4 9.1 7.3" />
                                                                        </svg>
                                                                    </div>
                                                                    <div class="media-body ml-3">
                                                                        <h6 class="mb-0 ">Sign Out</h6>
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
                                                        <a class="p-0" href="#">
                                                            <div class=" mt-3 d-flex align-items-center justify-content-between col-lg-7 ">
                                                                <i class="fa fa-moon-o" aria-hidden="true"></i>
                                                                <label class="switch toggle mt-2">
                                                                    <input type="checkbox" id="toggle" value=<?php echo $theme_mode; ?>
                                                                        <?php if ($theme_mode == 'light') {
                                                                            echo 'checked';
                                                                        } ?> />
                                                                    <span class="sliderk round"></span>
                                                                </label>
                                                                <i class="fa fa-sun-o" aria-hidden="true"></i>
                                                            </div>
                                                        </a>

                                                        <a href="<?php echo URL::to('myprofile'); ?>"
                                                            class="iq-sub-card  setting-dropdown">
                                                            <div class="media align-items-center">
                                                                <div class="right-icon">
                                                                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 70 70" style="enable-background:new 0 0 70 70;" xml:space="preserve">
                                                                        <style type="text/css"> .st0 {} </style>
                                                                        <g>
                                                                            <path class="st0" d="M32,34c-7.4,0-13.4-6-13.4-13.4S24.6,7.1,32,7.1s13.4,6,13.4,13.4S39.4,34,32,34z M32,10.5 c-5.6,0-10.1,4.5-10.1,10.1S26.4,30.7,32,30.7s10.1-4.5,10.1-10.1S37.6,10.5,32,10.5z" />
                                                                            <path class="st0" d="M38.5,54.2H15.3l0,0v-2.8c0-9,6.8-16.7,15.8-17.2c4.3-0.5,8.4,1.1,11.5,3.6c0.1,0.1,0.5,0.1,0.4,0l1.8-1.8 c0.5-0.5,0.5-0.5,0.1-0.6c-3.8-3.1-8.6-4.8-13.9-4.5c-10.7,0.6-19,9.9-19,20.6v5.1c0,0.6,0.5,1.1,1.1,1.1h28.8c0.5,0,0.8-0.6,0.4-1 l-1.4-1.4C40.2,54.5,39.3,54.2,38.5,54.2z" />
                                                                            <path class="st0" d="M62.2,48.6v-2.4c0-0.5-0.2-0.5-0.5-0.5H59c-0.2,0-0.4-0.1-0.5-0.4c-0.1-0.4-0.5-0.7-0.4-1.1 C58,44,58,43.8,58.2,43.6l1.9-1.9c0.2-0.2,0.2-0.5,0-0.7l-1.7-1.7c-0.2-0.2-0.5-0.2-0.7,0l-2,2c-0.2,0.2-0.4,0.2-0.6,0.1 c-0.5-0.2-0.7-0.5-1-0.4c-0.2-0.1-0.4-0.5-0.4-0.5v-2.8c0-0.5-0.2-0.5-0.5-0.5h-2.4c-0.5,0-0.5,0.2-0.5,0.5v2.8 c0,0.2-0.1,0.4-0.4,0.5c-0.4,0.1-0.7,0.2-1,0.4c-0.2,0.1-0.4,0.1-0.6-0.1l-2-2c-0.2-0.2-0.5-0.2-0.7,0L43.9,41 c-0.2,0.2-0.2,0.5,0,0.7l1.9,1.9c0.2,0.2,0.2,0.4,0.1,0.6c-0.2,0.5-0.5,0.7-0.4,1.1c-0.1,0.2-0.5,0.4-0.5,0.4h-2.7 c-0.5,0-0.5,0.2-0.5,0.5v2.4c0,0.5,0.2,0.5,0.5,0.5H45c0.2,0,0.4,0.1,0.5,0.4c0.1,0.4,0.5,0.7,0.4,1c0.1,0.2,0.1,0.4-0.1,0.6 L44.1,53c-0.2,0.2-0.2,0.5,0,0.7l1.7,1.7c0.2,0.2,0.5,0.2,0.7,0l1.9-1.9c0.2-0.2,0.4-0.2,0.6-0.1c0.5,0.2,0.7,0.5,1.1,0.4 c0.2,0.1,0.4,0.5,0.4,0.5V57c0,0.5,0.2,0.5,0.5,0.5h2.4c0.5,0,0.5-0.2,0.5-0.5v-2.7c0-0.2,0.1-0.4,0.4-0.5c0.4-0.1,0.7-0.5,1-0.4 c0.2-0.1,0.4-0.1,0.6,0.1l1.9,1.9c0.2,0.2,0.5,0.2,0.7,0l1.7-1.7c0.2-0.2,0.2-0.5,0-0.7l-1.9-1.9c-0.2-0.2-0.2-0.4-0.1-0.6 c0.2-0.5,0.5-0.7,0.4-1c0.1-0.2,0.5-0.4,0.5-0.4h2.7C62,49.1,62.2,48.9,62.2,48.6z M48.7,47.4c0-0.9,0.4-1.7,1-2.4 c0.6-0.6,1.5-1,2.4-1s1.7,0.4,2.4,1c0.6,0.6,1,1.5,1,2.4c0,1.7-1.2,3.2-3.3,3.5c-0.1,0-0.1,0-0.2,0C50,50.6,48.7,49.1,48.7,47.4 L48.7,47.4z" />
                                                                        </g>
                                                                    </svg>
                                                                </div>
                                                                <div class="media-body ml-3">
                                                                    <h6 class="mb-0 ">Manage Profile</h6>
                                                                </div>
                                                            </div>
                                                        </a>

                                                        <a href="<?php echo URL::to('watchlater'); ?>"
                                                            class="iq-sub-card setting-dropdown">
                                                            <div class="media align-items-center">
                                                                <div class="right-icon">
                                                                    <svg version="1.1" id="Layer_1"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        x="0" y="0"
                                                                        viewBox="0 0 70 70"
                                                                        style="enable-background:new 0 0 70 70"
                                                                        xml:space="preserve">
                                                                        <style>
                                                                            .st0 {
                                                                                fill: #198fcf;
                                                                                stroke: #198fcf;
                                                                                stroke-width: .75;
                                                                                stroke-miterlimit: 10
                                                                            }
                                                                        </style>
                                                                        <path class="st0"
                                                                            d="M21.5 23.7h14c.2 0 .3.2.3.4v.8c0 .2-.1.4-.3.4h-14c-.2 0-.3-.2-.3-.4V24c0-.1.2-.3.3-.3zM21.5 32h13.4c.2 0 .3.2.3.4v.8c0 .2-.1.4-.3.4H21.5c-.2 0-.3-.2-.3-.4v-.8c0-.2.2-.4.3-.4zM21.5 40.5h23.1c.2 0 .3.2.3.4v.8c0 .2-.1.4-.3.4H21.5c-.2 0-.3-.2-.3-.4v-.7c0-.3.2-.5.3-.5zM21.5 48.7h23.1c.2 0 .3.2.3.4v.8c0 .2-.1.4-.3.4H21.5c-.2 0-.3-.2-.3-.4v-.8c0-.3.2-.4.3-.4z" />
                                                                        <path class="st1"
                                                                            d="M48.4 37c-5.1 0-9.2-4.1-9.2-9.2s4.1-9.2 9.2-9.2 9.2 4.1 9.2 9.2-4.1 9.2-9.2 9.2zm0-16.7c-4.2 0-7.5 3.3-7.5 7.5s3.3 7.5 7.5 7.5 7.5-3.3 7.5-7.5-3.3-7.5-7.5-7.5z"
                                                                            style="fill:#198fcf;stroke:#198fcf;stroke-width:.5;stroke-miterlimit:10" />
                                                                        <path class="st2"
                                                                            d="M52.1 28.7h-3.8c-.4 0-.7-.3-.7-.7v-3.8c0-.2.2-.4.4-.4h.8c.2 0 .4.2.4.4v2.2c0 .4.3.7.7.7h2.2c.2 0 .4.2.4.4v.8c.1.2-.1.4-.4.4z"
                                                                            style="fill:#198fcf" />
                                                                        <path class="st3"
                                                                            d="M54.3 34v20.1c0 1-.8 1.9-1.9 1.9H17.3c-1 0-1.9-.8-1.9-1.9V17.5c0-1 .8-1.9 1.9-1.9h35.1c1 0 1.9.8 1.9 1.9v4.2"
                                                                            style="fill:none;stroke:#198fcf;stroke-width:2;stroke-miterlimit:10" />
                                                                    </svg>
                                                                </div>
                                                                <div class="media-body ml-3">
                                                                    <h6 class="mb-0 ">Watch Later</h6>
                                                                </div>
                                                            </div>
                                                        </a>

                                                        <a href="<?php echo URL::to('mywishlists'); ?>"
                                                            class="iq-sub-card setting-dropdown">
                                                            <div class="media align-items-center">
                                                                <div class="right-icon">
                                                                    <svg version="1.1" id="Layer_1"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                        x="0px" y="0px"
                                                                        viewBox="0 0 70 70"
                                                                        style="enable-background:new 0 0 70 70;"
                                                                        xml:space="preserve">
                                                                        <style type="text/css">
                                                                            .st0 {}
                                                                        </style>
                                                                        <g>
                                                                            <path class="st0" d="M20.9,18.3h-1.2c-0.7,0-1.2-0.5-1.2-1.2s0.5-1.2,1.2-1.2h1.2c0.7,0,1.2,0.5,1.2,1.2S21.5,18.3,20.9,18.3z" />
                                                                            <path class="st0" d="M43.5,18.3H25.6c-0.7,0-1.2-0.5-1.2-1.2s0.5-1.2,1.2-1.2h17.9c0.7,0,1.2,0.5,1.2,1.2S44.1,18.3,43.5,18.3z" />
                                                                            <path class="st0" d="M20.9,25.4h-1.2c-0.7,0-1.2-0.5-1.2-1.2S19,23,19.7,23h1.2c0.7,0,1.2,0.5,1.2,1.2S21.5,25.4,20.9,25.4z" />
                                                                            <path class="st0" d="M43.5,25.4H25.6c-0.7,0-1.2-0.5-1.2-1.2s0.5-1.2,1.2-1.2h17.9c0.7,0,1.2,0.5,1.2,1.2S44.1,25.4,43.5,25.4z" />
                                                                            <path class="st0" d="M20.9,32.5h-1.2c-0.7,0-1.2-0.5-1.2-1.2s0.5-1.2,1.2-1.2h1.2c0.7,0,1.2,0.5,1.2,1.2S21.5,32.5,20.9,32.5z" />
                                                                            <path class="st0" d="M43.5,32.5H25.6c-0.7,0-1.2-0.5-1.2-1.2s0.5-1.2,1.2-1.2h17.9c0.7,0,1.2,0.5,1.2,1.2S44.1,32.5,43.5,32.5z" />
                                                                            <path class="st0" d="M20.9,39.7h-1.2c-0.7,0-1.2-0.5-1.2-1.2s0.5-1.2,1.2-1.2h1.2c0.7,0,1.2,0.5,1.2,1.2S21.5,39.7,20.9,39.7z" />
                                                                            <path class="st0" d="M43.5,39.7H25.6c-0.7,0-1.2-0.5-1.2-1.2s0.5-1.2,1.2-1.2h17.9c0.7,0,1.2,0.5,1.2,1.2S44.1,39.7,43.5,39.7z" />
                                                                            <path class="st0" d="M20.9,46.8h-1.2c-0.7,0-1.2-0.5-1.2-1.2s0.5-1.2,1.2-1.2h1.2c0.7,0,1.2,0.5,1.2,1.2S21.5,46.8,20.9,46.8z" />
                                                                            <path class="st0" d="M56.7,42.9c-1.5-1.5-3.5-2.2-5.5-2.2c-0.5,0-0.5-0.2-0.5-0.5V8.7c0-0.5-0.1-0.6-0.5-0.8s-0.5-0.5-0.8-0.5H13.5 c-0.6,0-1,0.4-1,1V54c0,0.5,0.1,0.6,0.5,0.8s0.5,0.5,0.8,0.5H39c0.1,0,0.5,0.1,0.4,0.1l6.8,6.8c0.5,0.5,1.2,0.5,1.7,0l8.8-8.8l0,0 c1.4-1.4,2.2-3.3,2.2-5.2C58.8,46.1,58.1,44.2,56.7,42.9L56.7,42.9z M36.2,44.4H25.6c-0.7,0-1.2,0.5-1.2,1.2s0.5,1.2,1.2,1.2h9.7 c-0.1,0.4-0.1,0.9-0.1,1.3c0,1.4,0.4,2.7,1.1,3.9c0.2,0.5,0,0.8-0.4,0.8c-3.8,0-17.7,0-20.5,0c-0.5,0-0.5-0.2-0.5-0.5V10.4 c0-0.5,0.2-0.5,0.5-0.5h32.3c0.5,0,0.5,0.2,0.5,0.5v30.7c0,0.2-0.1,0.5-0.5,0.4c-0.5,0.2-0.6,0.4-0.9,0.6c-1.7-1.3-3.9-1.7-5.9-1.3 C39,41.3,37.3,42.6,36.2,44.4L36.2,44.4z M55,51.6l-7.6,7.6c-0.2,0.2-0.5,0.2-0.7,0l-7.6-7.6l0,0c-1.3-1.3-1.8-3.1-1.3-4.9 c0.5-1.7,1.8-3.1,3.6-3.6c2-0.5,4.1,0.2,5.3,1.8c0.2,0.5,0.6,0.5,0.8,0c1.3-1.7,3.4-2.4,5.3-1.8c1.7,0.5,3.1,1.8,3.6,3.6 C56.8,48.5,56.3,50.4,55,51.6L55,51.6z" />
                                                                        </g>
                                                                    </svg>
                                                                </div>
                                                                <div class="media-body ml-3">
                                                                    <h6 class="mb-0 ">Wish List</h6>
                                                                </div>
                                                            </div>
                                                        </a>

                                                        <a href="<?php echo URL::to('admin');
                                                            if(Auth::user()->package != 'Channel' && Auth::user()->package != 'CPP'){  ?>"
                                                            class="iq-sub-card setting-dropdown">
                                                                <div class="media align-items-center">
                                                                    <div class="right-icon">
                                                                        <svg version="1.1" id="Layer_1"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                            x="0px" y="0px" viewBox="0 0 70 70"
                                                                            style="enable-background:new 0 0 70 70;"
                                                                            xml:space="preserve">
                                                                            <style type="text/css">
                                                                                .st0 {}
                                                                            </style>
                                                                            <g>
                                                                                <path class="st0" d="M52.5,37.8c-1.7,0-3.2,0.5-4.5,1.2c-2.4-2-5-3.7-8-4.6c4.5-3,7.2-8.2,6.4-13.8c-0.8-6.4-6.1-11.7-12.5-12.4 c-4.1-0.5-8.1,0.8-11.2,3.6c-3.1,2.7-4.8,6.6-4.8,10.7c0,4.9,2.5,9.4,6.6,12c-5,1.7-9.3,5.1-12.3,9.5c-1.7,2.6-1.1,6.2,1.3,8 C19,55.9,25.4,58,32.2,58c4.9,0,9.8-1.2,14.2-3.5c1.7,1.4,3.7,2.3,6.1,2.3c5.2,0,9.5-4.3,9.5-9.5S57.7,37.8,52.5,37.8L52.5,37.8z M20.5,22.3c0-3.3,1.4-6.7,3.9-8.9c2.3-2,5-3,7.9-3c0.5,0,1,0,1.4,0.1c5.4,0.6,9.8,4.9,10.4,10.2c0.7,5.6-2.5,10.8-7.9,12.8 l-3.8,1.4l-3.9-1.4C23.5,31.8,20.5,27.3,20.5,22.3L20.5,22.3z M15.1,49.9c-1.4-1.1-1.8-3.2-0.8-4.8c3.1-4.8,8.2-8.2,13.8-9.3 l4.2-0.8l4.2,0.8c3.6,0.7,6.8,2.3,9.7,4.5c-1.9,1.7-3.1,4.2-3.1,6.9c0,2,0.6,3.9,1.8,5.5c-3.9,1.9-8.2,2.9-12.5,2.9 C26,55.6,20.1,53.6,15.1,49.9L15.1,49.9z M52.5,54.5c-3.9,0-7.2-3.2-7.2-7.2s3.2-7.2,7.2-7.2s7.2,3.2,7.2,7.2S56.4,54.5,52.5,54.5z M57.5,45.6L55,48l0.6,3.5l-3.1-1.7l-3.1,1.7L50,48l-2.5-2.4l3.5-0.5l1.5-3.1l1.5,3.1L57.5,45.6z" />
                                                                            </g>
                                                                        </svg>
                                                                    </div>
                                                                    <div class="media-body ml-3">
                                                                        <h6 class="mb-0 ">Admin</h6>
                                                                    </div>
                                                                </div>
                                                        </a>
                                                        <!-- Multiuser Profile -->
                                                        <?php
                                          } 
                                          if(Auth::user()->role == "subscriber"){

                                          ?>
                                                        <!-- <a href="<?php echo URL::to('choose-profile'); ?>" class="iq-sub-card setting-dropdown">
                                             <div class="media align-items-center">
                                                <div class="right-icon">
                                                   <img src="<?php echo URL::to('/') . '/assets/icons/admin.svg'; ?> " width="25" height="21">
                                                </div>
                                                <div class="media-body ml-3">
                                                   <h6 class="mb-0 ">Multi Profile</h6>
                                                </div>
                                             </div>
                                          </a> -->

                                                        <?php
                                          }
                                          ?>

                                                        <a href="<?php echo URL::to('logout'); ?>"
                                                            class="iq-sub-card setting-dropdown">
                                                            <div class="media align-items-center">
                                                                <div class="right-icon">
                                                                    <svg version="1.1" id="Layer_1"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        x="0" y="0"
                                                                        viewBox="0 0 70 70"
                                                                        style="enable-background:new 0 0 70 70"
                                                                        xml:space="preserve">
                                                                        <path class="st6"
                                                                            d="M53.4 33.7H30.7M36.4 28.1l-5.7 5.7 5.7 5.7" />
                                                                        <path class="st6"
                                                                            d="M50.5 43.7c-2.1 3.4-5.3 5.9-9.1 7.3-3.7 1.4-7.8 1.6-11.7.4a18.4 18.4 0 0 1-9.6-28.8c2.4-3.2 5.8-5.5 9.6-6.6 3.8-1.1 7.9-1 11.7.4 3.7 1.4 6.9 4 9.1 7.3" />
                                                                    </svg>
                                                                </div>
                                                                <div class="media-body ml-3">
                                                                    <h6 class="mb-0 ">Sign Out</h6>
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
                $(document).ready(function() {
                    var currentdate = "<?= $currentdate ?>";
                    var filldate = "<?= $filldate ?>";
                    var DOB = "<?= $DOB ?>";

                    // console.log(DOB);
                    // console.log(currentdate);

                    if (filldate == currentdate && DOB != null && !empty(DOB) && currentdate != null && filldate != null) {
                        $("body").append(
                            '<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Add Your DOB for Amazing video experience</div>'
                            );
                        setTimeout(function() {
                            $('.add_watch').slideUp('fast');
                        }, 3000);
                    }
                });
            </script>
            <script>
                $("#toggle").click(function() {

                    var theme_mode = $("#toggle").prop("checked");

                    $.ajax({
                        url: '<?php echo URL::to('theme-mode'); ?>',
                        method: 'post',
                        data: {
                            "_token": "<?php echo csrf_token(); ?>",
                            mode: theme_mode
                        },
                        success: (response) => {
                            console.log(response);
                        },
                    })
                });
            </script>

            <link rel="preload" href="<?= URL::to('/') . '/assets/admin/dashassets/js/google_analytics_tracking_id.js' ?>" as="script">
            <script src="<?= URL::to('/') . '/assets/admin/dashassets/js/google_analytics_tracking_id.js' ?>"></script>

            <script>
                var mini = true;
                const lightModeLogo = "<?php echo URL::to('/') . '/public/uploads/settings/' . $theme->light_mode_logo; ?>";
                const darkModeLogo = "<?php echo URL::to('/') . '/public/uploads/settings/' . $theme->dark_mode_logo; ?>";

                function toggleSidebar() {
                const sidebar = document.getElementById("mySidebar");
                const main = document.getElementById("main");
                const toggleIcon = document.getElementById("toggleIcon");

                if (mini) {
                    sidebar.style.width = "250px";
                    sidebar.style.zIndex = "1000"; 
                    sidebar.style.position = "fixed";
                    toggleIcon.src = darkModeLogo; 
                    menuIcon.innerHTML = "&#10006;"; // Close icon
                    mini = false;
                } else {
                    sidebar.style.width = "63px";
                    sidebar.style.zIndex = "1000";
                    sidebar.style.position = "fixed";
                    menuIcon.innerHTML = "&#9776;"; // Hamburger menu
                    toggleIcon.src = darkModeLogo;
                    mini = true;
                }
            }

            </script>
            <script>
                let theme_modes = $("#toggle").val();

                $(document).ready(function() {

                    if (theme_modes == 'light') {

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
        <link rel="preload" href="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js" as="script">
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

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

            document.addEventListener("DOMContentLoaded", function () {
                //  width and height set dynamically
                var images = document.querySelectorAll('.menu-items');
                images.forEach(function(image) {
                    var renderedWidth = image.clientWidth;
                    var renderedHeight = image.clientHeight;

                    image.setAttribute('width', renderedWidth);
                    image.setAttribute('height', renderedHeight);
                });
            });

        </script>

        </header>



        <!-- Header End -->

        <!-- MainContent End-->

<head>
    <?php
      $Script     = App\Script::pluck('header_script')->toArray();
      $theme_mode = App\SiteTheme::pluck('theme_mode')->first();
      $theme      = App\SiteTheme::first();      

      $signin_header = App\SiteTheme::pluck('signin_header')->first();

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
      
      $uri_path = $_SERVER['REQUEST_URI']; 
      $uri_parts = explode('/', $uri_path);
      $request_url = end($uri_parts);
      $uppercase =  ucfirst($request_url);
      
      if(!Auth::guest() && empty($uppercase) || Auth::guest() && empty($uppercase)){
         $uppercase = "Home" ;
      }else{ }
      
      $data = Session::all();
      
      ?>

    <?php

      $settings = App\Setting::first();
   
      $dynamic_page = App\Page::where('slug', '=', $request_url)->first();

      $SiteMeta_page = App\SiteMeta::where('page_slug', '=', $request_url)->first(); 

      $SiteMeta_image = App\SiteMeta::where('page_slug', '=', $request_url)->pluck('meta_image')->first();

      if(!Auth::guest() && Auth::User()->role != 'admin' || Auth::guest()){
         $menus = App\Menu::orderBy('order', 'asc')->where('in_home','!=',0)->orWhere('in_home', '=', null)->get();
      }else{
         $menus = App\Menu::orderBy('order', 'asc')->get();
      }

   ?>

   <meta charset="UTF-8">

    <title>
      <?php
         if(!empty($videos_data)){  echo $videos_data->title .' | '. $settings->website_name ;}
         elseif(!empty($series)){ echo $series->title .' | '. $settings->website_name ; }
         elseif(!empty($episdoe)){ echo $episdoe->title .' | '. $settings->website_name ; }
         elseif(!empty($livestream)){ echo $livestream->title .' | '. $settings->website_name ; }
         elseif(!empty($dynamic_page)){ echo $dynamic_page->title .' | '. $settings->website_name ; }
         elseif(!empty($SiteMeta_page)){ echo $SiteMeta_page->page_title .' | '. $settings->website_name ; }
         else{ echo $uppercase .' | ' . $settings->website_name ;} 
      ?>
    </title>

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

    <meta itemprop="image"
        content="<?php 
      if(!empty($videos_data)){ echo URL::to('/public/uploads/images').'/'.$videos_data->player_image;
      }
      elseif(!empty($episdoe)){ echo URL::to('/public/uploads/images').'/'.$episdoe->player_image  ;}
      elseif(!empty($series)){ echo URL::to('/public/uploads/images').'/'.$series->player_image ;}
      elseif(!empty($livestream)){ echo URL::to('/public/uploads/images').'/'.$livestream->player_image ;}
      elseif(!empty($SiteMeta_image)){ echo $SiteMeta_image ;}
      else{  echo URL::to('/').'/public/uploads/settings/'. $settings->default_horizontal_image   ;} //echo $settings; ?>">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="summary_large_image">
    <?php if(!empty($settings->twitter_page_id)){ ?>
    <meta name="twitter:site" content="<?php echo $settings->twitter_page_id ;?>"><?php } ?>
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
    <meta name="twitter:image:src"
        content="<?php 
      if(!empty($videos_data)){ echo URL::to('/public/uploads/images').'/'.$videos_data->player_image;
      }
      elseif(!empty($episdoe)){ echo URL::to('/public/uploads/images').'/'.$episdoe->player_image;}
      elseif(!empty($series)){ echo URL::to('/public/uploads/images').'/'.$series->player_image ;}
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
    <meta property="og:image"
        content="<?php 
      if(!empty($videos_data)){ echo URL::to('/public/uploads/images').'/'.$videos_data->player_image;
      }
      elseif(!empty($episdoe)){ echo URL::to('/public/uploads/images').'/'.$episdoe->player_image  ;}
      elseif(!empty($series)){ echo URL::to('/public/uploads/images').'/'.$series->player_image ;}
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

    <?php if(!empty($settings->website_name)){ ?>
    <meta property="og:site_name" content="<?php echo $settings->website_name ;?>" /><?php } ?>

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

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo getFavicon();?>" type="image/gif" sizes="16x16">

    <input type="hidden" value="<?php echo $settings->google_tracking_id ; ?>" name="tracking_id" id="tracking_id">

    <link async rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />



                        <!-- font -->
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="shortcut icon" type="image/png" href="<?= URL::to('public/uploads/settings/'.$settings->favicon); ?>" />
    
   <!-- Bootstrap CSS -->
         <link rel="stylesheet" href="<?= URL::to('public/themes/theme7/assets/css/bootstrap.min.css') ?>">

   <!-- Typography CSS -->
      <link rel="stylesheet" href="<?= URL::to('public/themes/theme7/assets/css/typography.css') ?>">

   <!-- Style -->
      <link rel="stylesheet" href="<?= URL::to('public/themes/theme7/assets/css/style.css') ?>">
      
   <!-- Responsive -->
      <link rel="stylesheet" href="<?= URL::to('public/themes/theme7/assets/css/responsive.css') ?>">

   <!-- slick -->
      <link rel="stylesheet" href="<?= URL::to('public/themes/theme7/assets/css/slick.css') ?>">

   <!-- Font Awesome -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

   <!-- Remixicon -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" integrity="sha512-HXXR0l2yMwHDrDyxJbrMD9eLvPe3z3qL3PPeozNTsiHJEENxx8DH2CxmV05iwG0dwoz5n4gQZQyYLUNt1Wdgfg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
      
   <!-- Ply.io -->

    <link rel="stylesheet" href="https://cdn.plyr.io/3.6.9/plyr.css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.js"></script>

    <?php 
      if(count($Script) > 0){
      foreach($Script as $Scriptheader){   ?>
    <?= $Scriptheader ?>
    <?php } 
      } ?>
</head>


<!-- light mode & dark mode -->
<style>

   body.light-theme {
      background: <?php echo GetLightBg(); ?>!important;
   }

   body.light-theme h4, body.light-theme p {
      color: <?php echo GetDarkText(); ?>;
   }

   body.light-theme header#main-header{
      background-color: <?php echo GetLightBg(); ?>!important;  
      color: <?php echo GetLightText(); ?>;
      box-shadow: rgb(0 0 0 / 16%) 0px 3px 10px;
   }

   body.light-theme footer{
      background: <?php echo GetLightBg(); ?>!important;  
      color: <?php echo GetLightText(); ?>;
      box-shadow: rgb(0 0 0 / 16%) 0px 3px 10px;
   }

   body.light-theme .copyright{
      background-color: <?php echo GetLightBg(); ?>;
      color: <?php echo GetLightText(); ?>;
   }

   body.light-theme .s-icon{
      background-color: <?php echo GetLightBg(); ?>; 
      box-shadow: rgb(0 0 0 / 16%) 0px 3px 10px;
   }

   body.light-theme .search-toggle:hover {
      color: <?php echo GetLightText(); ?>!important;
   }

   body.light-theme .dropdown-menu.categ-head{
      background-color: <?php echo GetLightBg(); ?>!important;  
      color: <?php echo GetLightText(); ?>!important;
   }

   body.light-theme .search-toggle:hover {
      color: rgb(0, 82, 204)!important;
      font-weight: 500;
   }

   body.light-theme .navbar-right .iq-sub-dropdown{
      background-color: <?php echo GetLightBg(); ?>;  
   }

   body.light-theme .media-body h6{
      color: <?php echo GetLightText(); ?>;
      font-weight: 400;
   }

   body.light-theme .block-description h6{
      color: <?php echo GetLightText(); ?>;
      font-weight: 400;
   }  

   body.light-theme .movie-time i{
      color: <?php echo GetLightText(); ?>!important;
      font-weight: 400;
   }  

   body.light-theme .p-tag1{
      color: <?php echo GetLightText(); ?>!important;
      font-weight: 400;
   } 
   
   body.light-theme .p-tag{
      color: <?php echo GetLightText(); ?>!important;
      font-weight: 400;
   } 

   body.light-theme .movie-time span{
      color: <?php echo GetLightText(); ?>!important;
      font-weight: 400;
   }

   body.light-theme .block-description a{
      color: <?php echo GetLightText(); ?>!important;
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
      color: <?php echo GetLightText(); ?>!important;
   }

   body.light-theme h2{
      color: <?php echo GetLightText(); ?>!important;
   }

   body.light-theme .filter-option-inner-inner{
      color: <?php echo GetLightText(); ?>!important;
   } 

   body.light-theme .vid-title{
      color: <?php echo GetLightText(); ?>!important;
   }

   body.light-theme .trending-info h1{
      color: <?php echo GetLightText(); ?>!important;
   }

   body.light-theme .text-detail{
      color: <?php echo GetLightText(); ?>!important;
   }

   body.light-theme .share-icons.music-play-lists li span i{
      color: <?php echo GetLightText(); ?>!important;
   }
   
   body.light-theme .btn1{
      border: 1px solid <?php echo GetLightText(); ?>!important;
      color: <?php echo GetLightText(); ?>!important;
   }
   
   body.light-theme .trending-dec{
      color: <?php echo GetLightText(); ?>!important;
   }

   body.light-theme h6.trash{
      color: black;
   }

   /* Dark Mode */

   body.dark-theme {
      background: <?php echo GetDarkBg(); ?>!important;
   }

   body.dark-theme h4, body.dark-theme p {
      color: <?php echo GetDarkText(); ?>;
   }

   body.dark-theme header#main-header{
      background-color: <?php echo GetDarkBg(); ?>!important;  
      color: <?php echo GetDarkText(); ?>;
      box-shadow: rgb(0 0 0 / 16%) 0px 3px 10px;
   }

   body.dark-theme footer{
      background: <?php echo GetDarkBg(); ?>!important;  
      color: <?php echo GetDarkText(); ?>;
      box-shadow: rgb(0 0 0 / 16%) 0px 3px 10px;
   }

   body.dark-theme .copyright{
      background-color: <?php echo GetDarkBg(); ?>;
      color: <?php echo GetDarkText(); ?>;
   }

   body.dark-theme .s-icon{
      background-color: <?php echo GetDarkBg(); ?>; 
      box-shadow: rgb(0 0 0 / 16%) 0px 3px 10px;
   }

   body.dark-theme .search-toggle:hover, header .navbar ul li.menu-item a:hover{
      color: <?php echo GetDarkText(); ?>!important;
   }
   body.light-theme #translator-table_filter input[type="search"]{
      color: <?php echo GetLightText(); ?>;
   }

   body.dark-theme .dropdown-menu.categ-head{
      background-color: <?php echo GetDarkBg(); ?>!important;  
      color: <?php echo GetDarkText(); ?>!important;
   }

   body.dark-theme .search-toggle:hover, header .navbar ul li.menu-item a:hover {
      color: rgb(0, 82, 204)!important;
      font-weight: 500;
   }

   body.dark-theme .navbar-right .iq-sub-dropdown{
      background-color: <?php echo GetDarkBg(); ?>;  
   }

   body.dark-theme .media-body h6{
      color: <?php echo GetDarkText(); ?>;
      font-weight: 400;
   }

   body.dark-theme .block-description h6{
      color: <?php echo GetDarkText(); ?>;
      font-weight: 400;
   }  

   body.dark-theme .movie-time i{
      color: <?php echo GetDarkText(); ?>!important;
      font-weight: 400;
   }  

   body.dark-theme .p-tag1{
      color: <?php echo GetDarkText(); ?>!important;
      font-weight: 400;
   } 
   
   body.dark-theme .p-tag{
      color: <?php echo GetDarkText(); ?>!important;
      font-weight: 400;
   } 

   body.dark-theme .movie-time span{
      color: <?php echo GetDarkText(); ?>!important;
      font-weight: 400;
   }

   body.dark-theme .block-description a{
      color: <?php echo GetDarkText(); ?>!important;
      font-weight: 400;
   } 
   
   body.dark-theme .block-description{
      /* background-image: linear-gradient(to bottom, rgb(243 244 247 / 30%), rgb(247 243 243 / 90%), rgb(247 244 244 / 90%), rgb(235 227 227 / 90%)); */
      backdrop-filter: blur(2px);
   }

   body.dark-theme  header .navbar ul li{
      font-weight: 400;
   }

   body.dark-theme .slick-nav i{
      color: <?php echo GetDarkText(); ?>!important;
   }

   body.dark-theme h2{
      color: <?php echo GetDarkText(); ?>!important;
   }

   body.dark-theme .filter-option-inner-inner{
      color: <?php echo GetDarkText(); ?>!important;
   } 

   body.dark-theme .vid-title{
      color: <?php echo GetDarkText(); ?>!important;
   }

   body.dark-theme .trending-info h1{
      color: <?php echo GetDarkText(); ?>!important;
   }

   body.dark-theme .text-detail{
      color: <?php echo GetDarkText(); ?>!important;
   }

   body.dark-theme .share-icons.music-play-lists li span i{
      color: <?php echo GetDarkText(); ?>!important;
   }
   
   body.dark-theme .btn1{
      border: 1px solid <?php echo GetDarkText(); ?>!important;
      color: <?php echo GetDarkText(); ?>!important;
   }
   
   body.dark-theme .trending-dec{
      color: <?php echo GetDarkText(); ?>!important;
   }

   body.dark-theme h6.trash{
      color: black;
   }

   .Search_error_class {
      color: red;
   }
   .channel-logo {
    border-left: 5px solid  <?php echo GetDarkBg(); ?> !important;
    background: transparent linear-gradient(270deg, rgba(11, 1, 2, 0) 0%, <?php echo button_bg_color(); ?> 100%);
   }
   #trending-slider-nav .slick-current.slick-active .movie-slick { border-color: <?php echo button_bg_color();?> !important; }
   #trending-slider-nav .movie-slick:before { border-top: 20px solid <?php echo button_bg_color(); ?> !important; }
   .dark-theme header .navbar ul li.menu-item a {color: <?php echo GetDarkText(); ?>!important;}
   .light-theme header .navbar ul li.menu-item a {color: <?php echo GetLightText(); ?> !important;}
   .dark-theme ul.f-link li a {color: <?php echo GetDarkText(); ?>;}
   .light-theme ul.f-link li a {color: <?php echo GetLightText(); ?> !important;}
   .dark-theme .text-body{color: <?php echo GetDarkText(); ?> !important;}
   .light-theme .text-body{color: <?php echo GetLightText(); ?> !important;}
   .dark-theme .s-icon {color: <?php echo GetDarkText(); ?> !important;}
   .light-theme .s-icon{color: <?php echo GetLightText(); ?> !important;}
   .dark-theme .iq-search-bar .search-input {color: <?php echo GetDarkText(); ?> !important;}
   .light-theme .iq-search-bar .search-input {color: <?php echo GetLightText(); ?> !important;}
   .light-theme li.list-group-item a {background:<?php echo GetLightBg(); ?>; color: <?php echo GetLightText(); ?> !important;}
   .dark-theme ul.list-group.home-search {background: <?php echo GetDarkBg(); ?> !important;}
   .light-theme ul.list-group.home-search {background: <?php echo GetLightBg(); ?> !important;}
   .dark-theme .iq-search-bar .search-input {background: var(--iq-bg1)!important !important;}
   .light-theme .iq-search-bar .search-input {background:<?php echo GetLightBg(); ?> !important;}
   .dark-theme h1,.dark-theme h2,.dark-theme h3,.dark-theme h4,.dark-theme h5,.dark-theme h6 {color: <?php echo GetDarkText(); ?> !important;}
   .light-theme h1,.light-theme h2,.light-theme h3,.light-theme h4,.light-theme h5,.light-theme h6 {color: <?php echo GetLightText(); ?> !important;}
   .dark-theme .navbar-expand-lg .navbar-nav .dropdown-menu {background:  <?php echo GetDarkBg(); ?> !important; color: <?php echo GetDarkText(); ?>;}
   body.light-theme .navbar-expand-lg .navbar-nav .dropdown-menu {background-color: <?php echo GetLightBg(); ?>!important; color: <?php echo GetLightText(); ?>;}
   body.dark-theme .offcanvas-collapse{
      background-color: <?php echo GetDarkBg(); ?>!important;  
      color: <?php echo GetDarkText(); ?>;
      /* box-shadow: rgb(0 0 0 / 16%) 0px 3px 10px; */
   }
   body.light-theme .offcanvas-collapse{
      background-color: <?php echo GetLightBg(); ?>!important;  
      color: <?php echo GetLightText(); ?>;
      box-shadow: rgb(0 0 0 / 16%) 0px 3px 10px;
   }
   body.dark-theme ul.navbar-nav{
      background-color: <?php echo GetDarkBg(); ?>!important;  
      color: <?php echo GetDarkText(); ?>;
      /* box-shadow: rgb(0 0 0 / 16%) 0px 3px 10px; */
   }
   body.light-theme ul.navbar-nav{
      background-color: <?php echo GetLightBg(); ?>!important;  
      color: <?php echo GetLightText(); ?>;
   }
   .light-theme.onclickbutton_menu{
      color: <?php echo GetLightText(); ?>;
   }
   body.dark-theme .onclickbutton_menu{
      color: <?php echo GetDarkText(); ?>;
   }
   body.light select:valid {
      background: #fcfcfc!important;
      color: #000000!important;
   }
   body.dark-theme select:valid {
      background: <?php echo GetDarkBg(); ?>!important;
      color: <?php echo GetDarkText(); ?>!important;
   }
</style>
<!-- End light mode & dark mode -->


<style>
   body{
      font-family: "Inter", sans-serif !important;
   }
   h1, h2, h3, h4, h5, h6, p, button, input{
      font-family: "Inter", sans-serif !important;
   }
   .switch {
      position: relative;
      display: inline-block;
      width: 50px;
      height: 20px;
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
   .sliderk.round {
      border-radius: 34px;
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
   .sliderk.round:before {
      border-radius: 50%;
   }
   input:checked + .sliderk:before {
      -webkit-transform: translateX(26px);
      -ms-transform: translateX(26px);
      transform: translateX(26px);
   }
   input:checked + .sliderk {
      background-color: #2196F3;
   }
   .iq-search-bar .search-input {
    width: 100%;
    height: 40px;
    padding: 5px 15px 5px 40px;
    border: none;
    border-radius: 0;
    color: var(--iq-white);
    background: var(--iq-bg1);
}
i.search-link.ri-search-line {
    position: absolute;
    left: 15px;
    top: 6px;
    font-size: 16px;
}

   @media (max-width:1100px){
      img.img-fluid.logo{
         width:56%;
      }
      header .navbar ul li.menu-item a{
         font-size:12px;
      }
      .menu-right{
         display:block;
      }
   }
   @media(max-width:991px){
      .screen-res-none{
         display:none !important;
      }
      .screen-res-block form{
         padding: 0 10px;
      }
      header .navbar ul.navbar-nav{
         display:flex;
      }
      .iq-main-slider{
         padding-top:0 !important;
      }
      .search-box{
         top:70px;
      }
      .navbar-right .iq-sub-dropdown{
         right:0
      }
      header .navbar ul li{
         border-bottom:none;
      }
      .navbar-collapse{
         padding-top:20px;
      }
      .c-logo{
         width:50px;
      }
      .btn-close{
         right:20% !important;
         font-size:25px;
      }
   }
   @media (min-width:991px){
      .screen-res-block{
         display:none !important;
      }
   }
</style>

<script>
  $(document).ready(function(){
    $(".btn-close").click(function(){
      $(".navbar-collapse .show").removeClass("show");
      $(".navbar-collapse").addClass("collapse");
      $(".nav-overlay").css("opacity",'0');

    });
  });
</script>
<body>
    <!-- loader Start -->
   <?php if( get_image_loader() == 1) { ?>
      <div class="fullpage-loader">
         <div class="fullpage-loader__logo">

            <?php if($theme_mode == "light" && !empty(@$theme->light_mode_logo)){  ?>

               <img src="<?php echo URL::to('/').'/public/uploads/settings/'. $theme->light_mode_logo; ?>" class="c-logo" alt="<?php echo $settings->website_name ; ?>">

            <?php }elseif($theme_mode != "light" && !empty(@$theme->dark_mode_logo)){ ?> 

               <img src="<?php echo URL::to('/').'/public/uploads/settings/'. $theme->dark_mode_logo; ?>" class="c-logo" alt="<?php echo $settings->website_name ; ?>">

            <?php }else { ?> 

               <img src="<?php echo URL::to('public/uploads/settings/'. $settings->logo ); ?>" class="c-logo" alt="<?php echo $settings->website_name ; ?>">

            <?php } ?>
 
         </div>
      </div>
   <?php } ?>

    <header id="main-header">
  <div class="main-header">
      <div class="container-fluid">
          <div class="row">
              <div class="col-sm-12 p-0">
                  <nav class="navbar navbar-expand-lg navbar-light p-0">
                    
                     <a href="#" class="navbar-toggler c-toggler" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <div class="navbar-toggler-icon" data-toggle="collapse">
                           <span class="navbar-menu-icon navbar-menu-icon--top"></span>
                           <span class="navbar-menu-icon navbar-menu-icon--middle"></span>
                           <span class="navbar-menu-icon navbar-menu-icon--bottom"></span>
                        </div>
                     </a>

                     <a href="<?php echo URL::to('/home'); ?>"> <img class="img-fluid logo" src="<?= front_end_logo() ?>" width="131" height="70" /> </a>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                           <div class="row d-flex justify-content-between screen-res-block">
                              <div class="col-6"><img src="<?= front_end_logo() ?>" class="c-logo" alt="<?=  $settings->website_name ; ?>"></div>
                              <div class="col-6">
                                 <a type="button" class="navbar-toggler btn-close c-toggler p-0 border-0" data-toggle="collapse"
                                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                    aria-expanded="false" aria-label="Toggle navigation" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                       <i class="fa fa-times"></i> 
                                 </a>
                              </div>
                           </div>
                           <div class="menu-main-menu-container">
                              <ul id="top-menu" class=" mt-2 nav navbar-nav ">

                                 <?php  

                                    $video_category = App\VideoCategory::orderBy('order', 'asc')->where('in_menu',1)->get();

                                    $LiveCategory = App\LiveCategory::orderBy('order', 'asc')->get();

                                    $AudioCategory = App\AudioCategory::orderBy('order', 'asc')->get();

                                    $tv_shows_series = App\Series::where('active',1)->get();

                                    $languages = App\Language::all();

                                 ?>

                                 <?php foreach ($menus as $menu) { 

                                    if ( $menu->in_menu == "video" ) {  ?>

                                       <li class="dropdown menu-item dskdflex">
                                          <a class="dropdown-toggle justify-content-between " id="dn" href="<?= URL::to($menu->url) ?>" data-toggle="dropdown">
                                             <?= $menu->name ?> <i class="fa fa-angle-down"></i>
                                          </a>
                                          <ul class="dropdown-menu categ-head">
                                             <?php foreach ( $video_category as $category) : ?>
                                                <li>
                                                   <a class="dropdown-item cont-item" href="<?php echo URL::to('category/'.$category->slug)?>">
                                                      <?= $category->name;?>
                                                   </a>
                                                </li>
                                             <?php endforeach ; ?>
                                          </ul>
                                       </li>

                                    <?php } elseif ( $menu->in_menu == "movies") {  ?>

                                       <li class="dropdown menu-item dskdflex">
                                          <a class="dropdown-toggle justify-content-between " id="dn" href="<?= URL::to($menu->url) ?>" data-toggle="dropdown">
                                                <?= ($menu->name);?> <i class="fa fa-angle-down"></i>
                                          </a>

                                          <ul class="dropdown-menu categ-head">
                                                <?php foreach ( $languages as $language): ?>
                                                <li>
                                                      <a class="dropdown-item cont-item" href="<?= URL::to('language/'.$language->id.'/'.$language->name);?>">
                                                         <?= $language->name;?>
                                                      </a>
                                                </li>
                                                <?php endforeach; ?>
                                          </ul>
                                       </li>

                                    <?php }elseif ( $menu->in_menu == "live") { ?>

                                       <li class="dropdown menu-item dskdflex">
                                          <a class="dropdown-toggle  justify-content-between " id="dn" href="<?= URL::to($menu->url) ?>" data-toggle="dropdown">
                                                <?= $menu->name ?> <?php if(count($LiveCategory) < 0 ){ echo '<i class="fa fa-angle-down"></i>'; } ?> 
                                          </a>

                                          <?php if(count($LiveCategory) < 0 ): ?>
                                             <ul class="dropdown-menu categ-head">
                                                   <?php foreach ( $LiveCategory as $category): ?>
                                                   <li>
                                                         <a class="dropdown-item cont-item" href="<?= URL::to('/live/category/'.$category->name) ?>">
                                                            <?= $category->name ?></a>
                                                   </li>
                                                   <?php endforeach; ?>
                                             </ul>
                                          <?php endif; ?>
                                       </li>

                                    <?php }elseif ( $menu->in_menu == "audios") { ?>

                                       <li class="dropdown menu-item dskdflex">
                                          <a class="dropdown-toggle  justify-content-between " id="dn" href="<?= URL::to('/').$menu->url;?>"
                                                data-toggle="dropdown">
                                                <?= ($menu->name);?> <i class="fa fa-angle-down"></i>
                                          </a>
                                          <ul class="dropdown-menu categ-head">
                                                <?php foreach ( $AudioCategory as $category): ?>
                                                <li>
                                                      <a class="dropdown-item cont-item" href="<?php echo URL::to('audio/'.$category->name);?>">
                                                         <?= $category->name;?>
                                                      </a>
                                                </li>
                                                <?php endforeach; ?>
                                          </ul>
                                       </li>

                                    <?php }elseif ( $menu->in_menu == "tv_show") { ?>
                                          
                                       <li class="dropdown menu-item ">

                                          <a href="<?php echo URL::to('$menu->url')?>">
                                                <?= ($menu->name); ?> <i class="fa fa-angle-down"></i>
                                          </a>

                                          <?php if(count($tv_shows_series) > 0 ){ ?>
                                             <ul class="dropdown-menu categ-head">
                                                <?php foreach ( $tv_shows_series->take(6) as $key => $tvshows_series): ?>
                                                <li>
                                                      <?php if($key < 5): ?>
                                                      <a class="dropdown-item cont-item" href="<?php echo URL::to('play_series/'.$tvshows_series->slug );?>">
                                                            <?= $tvshows_series->title;?>
                                                      </a>
                                                      <?php else: ?>
                                                      <a class="dropdown-item cont-item text-primary" href="<?php echo URL::to('/series/list');?>">
                                                            <?php echo 'More...';?>
                                                      </a>
                                                      <?php endif; ?>
                                                </li>
                                                <?php endforeach; ?>
                                             </ul>
                                          <?php } ?>
                                       </li>

                                    <?php } else { ?>
                                       <li class="menu-item">
                                          <a
                                                href="<?php if($menu->select_url == "add_Site_url"){ echo URL::to( $menu->url ); }elseif($menu->select_url == "add_Custom_url"){ echo $menu->custom_url;  }?>">
                                                <?php echo __($menu->name);?>
                                          </a>
                                       </li>

                                    <?php  } ?>

                                 <?php } ?>
                                 
                              </ul>
                              <div class="d-flex p-2 screen-res-block">
                                 <?php if (!Auth::guest()) {
                                    $userEmail = Auth::user()->email;
                                    $moderatorsUser = App\ModeratorsUser::where('email', $userEmail)->first();
                                    $channel = App\Channel::where('email', $userEmail)->first();

                                    if (!empty($moderatorsUser)) { ?>
                                          <div class="p-2" >
                                             <form method="POST" action="<?= URL::to('cpp/home') ?>" >
                                                <input type="hidden" name="_token" id="token" value="<?= csrf_token() ?>">
                                                <input type="hidden" name="email" value="<?= $userEmail ?>" autocomplete="email" autofocus>
                                                <input type="hidden" name="password" value="<?= @$moderatorsUser->password ?>" autocomplete="current-password">
                                                <button type="submit" class="btn btn-primary" >Visit CPP Portal</button>
                                             </form>
                                          </div>
                                    <?php }
                                    
                                    if (!empty($channel)) { ?>
                                          <div class="p-2" >
                                             <form method="POST" action="<?= URL::to('channel/home') ?>" >
                                                <input type="hidden" name="_token" id="token" value="<?= csrf_token() ?>">
                                                <input type="hidden" name="email" value="<?= $userEmail ?>" autocomplete="email" autofocus>
                                                <input type="hidden" name="password" value="<?= @$channel->unhased_password ?>" autocomplete="current-password">
                                                <button type="submit" class="btn btn-primary" >Visit Channel Portal</button>
                                             </form>
                                          </div>
                                    <?php }
                                 } ?>
                              </div>
                          </div>
                      </div>

                      <!-- Channel and CPP Login -->
                     <div class="d-flex p-2 screen-res-none">
                        <?php if (!Auth::guest()) {
                           $userEmail = Auth::user()->email;
                           $moderatorsUser = App\ModeratorsUser::where('email', $userEmail)->first();
                           $channel = App\Channel::where('email', $userEmail)->first();

                           if (!empty($moderatorsUser)) { ?>
                                 <div class="p-2" >
                                    <form method="POST" action="<?= URL::to('cpp/home') ?>" >
                                       <input type="hidden" name="_token" id="token" value="<?= csrf_token() ?>">
                                       <input type="hidden" name="email" value="<?= $userEmail ?>" autocomplete="email" autofocus>
                                       <input type="hidden" name="password" value="<?= @$moderatorsUser->password ?>" autocomplete="current-password">
                                       <button type="submit" class="btn btn-primary" >Visit CPP Portal</button>
                                    </form>
                                 </div>
                           <?php }
                           
                           if (!empty($channel)) { ?>
                                 <div class="p-2" >
                                    <form method="POST" action="<?= URL::to('channel/home') ?>" >
                                       <input type="hidden" name="_token" id="token" value="<?= csrf_token() ?>">
                                       <input type="hidden" name="email" value="<?= $userEmail ?>" autocomplete="email" autofocus>
                                       <input type="hidden" name="password" value="<?= @$channel->unhased_password ?>" autocomplete="current-password">
                                       <button type="submit" class="btn btn-primary" >Visit Channel Portal</button>
                                    </form>
                                 </div>
                           <?php }
                        } ?>
                     </div>

                      <div class="navbar-right menu-right">
                          <ul class="d-flex align-items-center list-inline m-0">

                              <li class="nav-item nav-icon">
                                  <a href="<?= URL::to('searchResult') ?>" class="search-toggle device-search">
                                      <i class="ri-search-line"></i>
                                  </a>

                                 <div class="search-box iq-search-bar d-search">
                                    <form id="" role="search" action="<?php echo URL::to('searchResult');?>" method="get">
                                       <div class="form-group position-relative">
                                          <input type="text" name="search" class="text search-input font-size-12 searches" id="searches" autocomplete="off" placeholder="Type here to Search Videos">
                                          <i class="search-link ri-search-line"></i>
                                          <?php  include 'public/themes/theme7/partials/Search_content.php'; ?>
                                       </div>
                                    </form>
                                 </div>

                                 <div class="iq-sub-dropdown search_content overflow-auto" id="sidebar-scrollbar" >
                                    <div class="iq-card-body">
                                       <div id="search_list" class="search_list search-toggle device-search" ></div>
                                    </div>
                                 </div>
                              </li>

                              <!-- Notification -->
                              
                              <!-- <li class="nav-item nav-icon">
                                  <a href="#" class="search-toggle" data-toggle="search-toggle">
                                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22"
                                          height="22" class="noti-svg">
                                          <path fill="none" d="M0 0h24v24H0z" />
                                          <path
                                              d="M18 10a6 6 0 1 0-12 0v8h12v-8zm2 8.667l.4.533a.5.5 0 0 1-.4.8H4a.5.5 0 0 1-.4-.8l.4-.533V10a8 8 0 1 1 16 0v8.667zM9.5 21h5a2.5 2.5 0 1 1-5 0z" />
                                      </svg>
                                      <span class="bg-danger dots"></span>
                                  </a>
                                  <div class="iq-sub-dropdown">
                                      <div class="iq-card shadow-none m-0">
                                          <div class="iq-card-body">
                                              <a href="#" class="iq-sub-card">
                                                  <div class="media align-items-center">
                                                      <img src="https://localhost/flicknexs/public/themes/theme7/assets/images/notify/thumb-1.jpg"
                                                          class="img-fluid mr-3" alt="" />
                                                      <div class="media-body">
                                                          <h6 class="mb-0 ">Boot Bitty</h6>
                                                          <small class="font-size-12"> just now</small>
                                                      </div>
                                                  </div>
                                              </a>
                                              <a href="#" class="iq-sub-card">
                                                  <div class="media align-items-center">
                                                      <img src="https://localhost/flicknexs/public/themes/theme7/assets/images/notify/thumb-2.jpg"
                                                          class="img-fluid mr-3" alt="" />
                                                      <div class="media-body">
                                                          <h6 class="mb-0 ">The Last Breath</h6>
                                                          <small class="font-size-12">15 minutes ago</small>
                                                      </div>
                                                  </div>
                                              </a>
                                              <a href="#" class="iq-sub-card">
                                                  <div class="media align-items-center">
                                                      <img src="https://localhost/flicknexs/public/themes/theme7/assets/images/notify/thumb-3.jpg"
                                                          class="img-fluid mr-3" alt="" />
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
                               -->
                              <li class="nav-item nav-icon">
                                    <?php if( !Auth::guest() ) : ?>

                                       <a href="#" class="iq-user-dropdown search-toggle p-0 d-flex align-items-center"
                                          data-toggle="search-toggle">
                                             <?php if(Auth::user() && Auth::user()->avatar != null): ?>
                                                   <img src="<?php echo URL::to('public/uploads/avatars/' . Auth::user()->avatar); ?>" class="img-fluid avatar-40 rounded-circle">
                                             <?php else: ?>
                                                   <img src="<?php echo URL::to('/assets/img/uss.png'); ?>" class="img-fluid avatar-40 rounded-circle" alt="Placeholder Image">
                                             <?php endif; ?>
                                              <!-- <img src="<?= !Auth::guest() && Auth::user()->avatar ? URL::to('public/uploads/avatars/'.Auth::user()->avatar ) : URL::to('/public/themes/theme7/assets/images/user/user.jpg') ?>"
                                                class="img-fluid avatar-40 rounded-circle" alt="user"> -->
                                       </a>

                                  <?php endif; ?>

                                  <div class="iq-sub-dropdown iq-user-dropdown">
                                      <div class="iq-card shadow-none m-0">

                                       <?php if( Auth::guest() ) : ?>

                                          <?php if( $theme->signin_header == 1 ): ?>
                                             <div class="iq-card-body p-0 pl-3 pr-3">
                                                <li class="nav-item nav-icon">
                                                   <a href="<?php echo URL::to('login') ?>" class="iq-sub-card">
                                                      <div class="media align-items-center">
                                                         <div class="right-icon"><i class="ri-login-circle-line text-primary"></i></div>
                                                         <div class="media-body">
                                                            <h6 class="mb-0 ">Signin</h6>
                                                         </div>
                                                      </div>
                                                   </a>
                                                </li>
                                                
                                                <li class="nav-item nav-icon">
                                                   <a href="<?php echo URL::to('signup') ?>" class="iq-sub-card">
                                                      <div class="media align-items-center">
                                                         <div class="right-icon"><i class="ri-logout-circle-line text-primary"></i></div>
                                                         <div class="media-body">
                                                            <h6 class="mb-0 ">Signup</h6>
                                                         </div>
                                                      </div>
                                                   </a>
                                                </li>
                                             </div>
                                          <?php endif; ?>

                                          <?php elseif( !Auth::guest() && Auth::user()->role == "admin"): ?>

                                          <div class="iq-card-body p-0 pl-3 pr-3">
                                             <div class="toggle mt-2 text-left">
                                                <i class="fas fa-moon"></i>
                                                   <label class="switch toggle mt-3">
                                                      <input type="checkbox" id="toggle"  value=<?php echo $theme_mode;  ?> 
                                                         <?php if($theme_mode == "light") { echo 'checked' ; } ?> />
                                                      <span class="sliderk round"></span>
                                                   </label>
                                                <i class="fas fa-sun"></i>
                                             </div>
                                             <a href="<?= URL::to('myprofile') ?>" class="iq-sub-card setting-dropdown">
                                                <div class="media align-items-center">
                                                      <div class="right-icon"><i class="ri-file-user-line text-primary"></i></div>
                                                      <div class="media-body ml-3">
                                                         <h6 class="mb-0 ">Manage Profile</h6>
                                                      </div>
                                                </div>
                                             </a>
                                             

                                             <a href="<?= URL::to('/mywishlists') ?>" class="iq-sub-card setting-dropdown">
                                                <div class="media align-items-center">
                                                      <div class="right-icon"><i class="ri-file-list-line text-primary"></i></div>
                                                      <div class="media-body ml-3">
                                                         <h6 class="mb-0 ">Wishlist</h6>
                                                      </div>
                                                </div>
                                             </a>

                                             <a href="<?= URL::to('/watchlater') ?>" class="iq-sub-card setting-dropdown">
                                                <div class="media align-items-center">
                                                      <div class="right-icon"><i class="ri-file-list-line text-primary"></i></div>
                                                      <div class="media-body ml-3">
                                                         <h6 class="mb-0 ">Watchlater</h6>
                                                      </div>
                                                </div>
                                             </a>

                                             <a href="<?= URL::to('/admin') ?>" class="iq-sub-card setting-dropdown">
                                                <div class="media align-items-center">
                                                      <div class="right-icon"><i class="ri-settings-4-line text-primary"></i></div>
                                                      <div class="media-body ml-3">
                                                         <h6 class="mb-0 ">Admin</h6>
                                                      </div>
                                                </div>
                                             </a>

                                             <a href="<?= URL::to('/logout') ?>" class="iq-sub-card setting-dropdown">
                                                <div class="media align-items-center">
                                                      <div class="right-icon"><i class="ri-logout-circle-line text-primary"></i></div>
                                                      <div class="media-body ml-3">
                                                         <h6 class="mb-0 ">Logout</h6>
                                                      </div>
                                                </div>
                                             </a>
                                          </div>

                                          <?php elseif( !Auth::guest() && Auth::user()->role == "subscriber"): ?>

                                          <div class="iq-card-body p-0 pl-3 pr-3">
                                             <a href="<?= URL::to('myprofile') ?>" class="iq-sub-card setting-dropdown">
                                                <div class="media align-items-center">
                                                      <div class="right-icon"><i class="ri-file-user-line text-primary"></i></div>
                                                      <div class="media-body ml-3">
                                                         <h6 class="mb-0 ">Manage Profile</h6>
                                                      </div>
                                                </div>
                                             </a>

                                             <a href="<?= URL::to('/mywishlists') ?>" class="iq-sub-card setting-dropdown">
                                                <div class="media align-items-center">
                                                      <div class="right-icon"><i class="ri-file-list-line text-primary"></i></div>
                                                      <div class="media-body ml-3">
                                                         <h6 class="mb-0 ">Wishlist</h6>
                                                      </div>
                                                </div>
                                             </a>

                                             <a href="<?= URL::to('/watchlater') ?>" class="iq-sub-card setting-dropdown">
                                                <div class="media align-items-center">
                                                      <div class="right-icon"><i class="ri-file-list-line text-primary"></i></div>
                                                      <div class="media-body ml-3">
                                                         <h6 class="mb-0 ">Watchlater</h6>
                                                      </div>
                                                </div>
                                             </a>
                                             
                                             <a href="<?= URL::to('/logout') ?>" class="iq-sub-card setting-dropdown">
                                                <div class="media align-items-center">
                                                      <div class="right-icon"><i class="ri-logout-circle-line text-primary"></i></div>
                                                      <div class="media-body ml-3">
                                                         <h6 class="mb-0 ">Logout</h6>
                                                      </div>
                                                </div>
                                             </a>
                                          </div>

                                          <?php elseif( !Auth::guest() && Auth::user()->role == "registered"): ?>

                                          <div class="iq-card-body p-0 pl-3 pr-3">

                                             <a href="<?= URL::to('myprofile') ?>" class="iq-sub-card setting-dropdown">
                                                <div class="media align-items-center">
                                                      <div class="right-icon"><i class="ri-file-user-line text-primary"></i></div>
                                                      <div class="media-body ml-3">
                                                         <h6 class="mb-0 ">Manage Profile</h6>
                                                      </div>
                                                </div>
                                             </a>

                                             <a href="<?= URL::to('/mywishlists') ?>" class="iq-sub-card setting-dropdown">
                                                <div class="media align-items-center">
                                                      <div class="right-icon"><i class="ri-file-list-line text-primary"></i></div>
                                                      <div class="media-body ml-3">
                                                         <h6 class="mb-0 ">Wishlist</h6>
                                                      </div>
                                                </div>
                                             </a>

                                             <a href="<?= URL::to('/watchlater') ?>" class="iq-sub-card setting-dropdown">
                                                <div class="media align-items-center">
                                                      <div class="right-icon"><i class="ri-file-list-line text-primary"></i></div>
                                                      <div class="media-body ml-3">
                                                         <h6 class="mb-0 ">Watchlater</h6>
                                                      </div>
                                                </div>
                                             </a>
                                             
                                             <a href="<?= URL::to('/logout') ?>" class="iq-sub-card setting-dropdown">
                                                <div class="media align-items-center">
                                                      <div class="right-icon"><i class="ri-logout-circle-line text-primary"></i></div>
                                                      <div class="media-body ml-3">
                                                         <h6 class="mb-0 ">Logout</h6>
                                                      </div>
                                                </div>
                                             </a>
                                          </div>

                                          <?php endif; ?>
                                      </div>
                                  </div>
                              </li>
                          </ul>
                      </div>
                  </nav>
                  <div class="nav-overlay"></div>
              </div>
          </div>
      </div>
  </div>
</header>

        <?php 
         $playerui_settings = App\Playerui::first();
         if($playerui_settings->watermark == 1){ ?>
        <style>
        .plyr__video-wrapper::before {
            position: absolute;
            top: <?php echo $playerui_settings->watermark_top;
            ?>;
            left: <?php echo $playerui_settings->watermark_left;
            ?>;
            opacity: <?php echo $playerui_settings->watermark_opacity;
            ?>;
            z-index: 2;
            content: '';
            height: 150px;
            width: <?php echo $playerui_settings->watermar_width;
            ?>;
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
            var currentdate = "<?=  $currentdate ?>";
            var filldate = "<?= $filldate ?>";
            var DOB = "<?= $DOB ?>";

            // console.log(DOB);
            // console.log(currentdate);

            if (filldate == currentdate && DOB != null && !empty(DOB) && currentdate != null && filldate !=
                null) {
                $("body").append(
                    '<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Add Your DOB for Amazing video experience</div>'
                    );
                setTimeout(function() {
                    $('.add_watch').slideUp('fast');
                }, 3000);
            }
        });
        </script>
        <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/google_analytics_tracking_id.js';?>"></script>

        <script>
        $("#toggle").click(function() {

            var theme_mode = $("#toggle").prop("checked");

            $.ajax({
                url: '<?php echo URL::to("theme-mode") ;?>',
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

        <!-- Dark Mode & Light Mode  -->
        <script>
        let theme_modes = $("#toggle").val();

        $(document).ready(function() {

         if (theme_modes == 'light') {

            body.classList.remove('dark-theme');
            body.classList.add('light-theme');

            }else if( theme_modes == 'dark' ) {

            body.classList.remove('light-theme');
            body.classList.add('dark-theme');
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
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

        <script>
               $("#searchResult").validate({
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

         

        <style>
         .dropdown-toggle::after{
            display:none;
         }
         ul.dropdown-menu.categ-head{
            overflow:hidden;
         }
        .home-search li.list-group-item{
            text-align:left;
         }

         /* loader style */
         .fullpage-loader {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 100vw;
            overflow: hidden;
            background: linear-gradient(180deg, #040404 0%, #3D3D47 100%);
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
         </style>


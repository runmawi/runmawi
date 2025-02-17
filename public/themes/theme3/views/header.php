<head>
   <?php
   $Script = App\Script::pluck('header_script')->toArray();
   $theme_mode = App\SiteTheme::pluck('theme_mode')->first();
   $theme = App\SiteTheme::first();
   $css = App\Css::pluck('custom_css')->toArray();

   $signin_header = App\SiteTheme::pluck('signin_header')->first();

   if (!empty(Auth::User()->id)) {

      $id = Auth::User()->id;
      $users = App\User::find($id);
      $date = date_create($users->created_at);
      $created_at = date_format($date, "Y-m-d");
      $filldate = date('Y-m-d', strtotime($created_at . ' + 10 day'));
      $currentdate = date('Y-m-d');
      $DOB = $users->DOB;

   } else {

      $currentdate = null;
      $filldate = null;
      $DOB = null;

   }

   $data = Session::all();

   $uri_path = $_SERVER['REQUEST_URI'];
   $uri_parts = explode('/', $uri_path);
   $request_url = end($uri_parts);
   $uppercase = ucfirst($request_url);

   if (!Auth::guest() && empty($uppercase) || Auth::guest() && empty($uppercase)) {
      $uppercase = "Home";
   } else {
   }

   $data = Session::all();

   ?>

   <?php

   $settings = App\Setting::first();

   $dynamic_page = App\Page::where('slug', '=', $request_url)->first();

   $SiteMeta_page = App\SiteMeta::where('page_slug', '=', $request_url)->first();

   $SiteMeta_image = App\SiteMeta::where('page_slug', '=', $request_url)->pluck('meta_image')->first();

   if ($theme->header_position == 0) {

      $menus = App\Menu::orderBy('order', 'asc')->where('in_home', 1)->get();

   } elseif ($theme->header_position == 1) {
      $menus = App\Menu::orderBy('order', 'asc')->where('in_side_menu', 1)->get();
   }
   ?>

   <meta charset="UTF-8">

   <title>
      <?php
      if (!empty($videos_data)) {
         echo $videos_data->title . ' | ' . $settings->website_name;
      } elseif (!empty($series)) {
         echo $series->title . ' | ' . $settings->website_name;
      } elseif (!empty($episdoe)) {
         echo $episdoe->title . ' | ' . $settings->website_name;
      } elseif (!empty($livestream)) {
         echo $livestream->title . ' | ' . $settings->website_name;
      } elseif (!empty($dynamic_page)) {
         echo $dynamic_page->meta_title . ' | ' . $settings->website_name;
      } elseif (!empty($SiteMeta_page)) {
         echo $SiteMeta_page->page_title . ' | ' . $settings->website_name;
      } else {
         echo $uppercase . ' | ' . $settings->website_name;
      }
      ?>
   </title>

   <meta name="description" content="<?php
   if (!empty($videos_data)) {
      echo $videos_data->description;
   } elseif (!empty($episdoe)) {
      echo $episdoe->description;
   } elseif (!empty($series)) {
      echo $series->description;
   } elseif (!empty($livestream)) {
      echo $livestream->description;
   } elseif (!empty($dynamic_page)) {
      echo ($dynamic_page->meta_description);
   } elseif (!empty($SiteMeta_page)) {
      echo $SiteMeta_page->meta_description . ' | ' . $settings->website_name;
   } else {
      echo $settings->website_description;
   } //echo $settings;  ?>" />
   <meta name="keywords"
      content="<?php @$dynamic_page->meta_keywords ? @$dynamic_page->meta_keywords : @$dynamic_page->meta_keywords ?>">

   <!-- Schema.org markup for Google+ -->

   <meta itemprop="name" content="<?php
   if (!empty($videos_data)) {
      echo $videos_data->title . ' | ' . $settings->website_name;
   } elseif (!empty($series)) {
      echo $series->title . ' | ' . $settings->website_name;
   } elseif (!empty($episdoe)) {
      echo $episdoe->title . ' | ' . $settings->website_name;
   } elseif (!empty($livestream)) {
      echo $livestream->title . ' | ' . $settings->website_name;
   } elseif (!empty($dynamic_page)) {
      echo $dynamic_page->title . ' | ' . $settings->website_name;
   } elseif (!empty($SiteMeta_page)) {
      echo $SiteMeta_page->page_name . ' | ' . $settings->website_name;
   } else {
      echo $uppercase . ' | ' . $settings->website_name;
   } ?>">

   <meta itemprop="description" content="<?php
   if (!empty($videos_data)) {
      echo $videos_data->description;
   } elseif (!empty($episdoe)) {
      echo $episdoe->description;
   } elseif (!empty($series)) {
      echo $series->description;
   } elseif (!empty($livestream)) {
      echo $livestream->description;
   } elseif (!empty($SiteMeta_page)) {
      echo $SiteMeta_page->meta_description . ' | ' . $settings->website_name;
   } else {
      echo $settings->website_description;
   } //echo $settings;  ?>">

   <meta itemprop="image"
      content="<?php
      if (!empty($videos_data)) {
         echo URL::to('/public/uploads/images') . '/' . $videos_data->player_image;
      } elseif (!empty($episdoe)) {
         echo URL::to('/public/uploads/images') . '/' . $episdoe->player_image;
      } elseif (!empty($series)) {
         echo URL::to('/public/uploads/images') . '/' . $series->player_image;
      } elseif (!empty($livestream)) {
         echo URL::to('/public/uploads/images') . '/' . $livestream->player_image;
      } elseif (!empty($SiteMeta_image)) {
         echo $SiteMeta_image;
      } else {
         echo URL::to('/') . '/public/uploads/settings/' . $settings->default_horizontal_image;
      } //echo $settings;  ?>">

   <!-- Twitter Card data -->
   <meta name="twitter:card" content="summary_large_image">
   <?php if (!empty($settings->twitter_page_id)) { ?>
      <meta name="twitter:site" content="<?php echo $settings->twitter_page_id; ?>">
   <?php } ?>
   <meta name="twitter:title" content="<?php
   if (!empty($videos_data)) {
      echo $videos_data->title . ' | ' . $settings->website_name;
   } elseif (!empty($series)) {
      echo $series->title . ' | ' . $settings->website_name;
   } elseif (!empty($episdoe)) {
      echo $episdoe->title . ' | ' . $settings->website_name;
   } elseif (!empty($livestream)) {
      echo $livestream->title . ' | ' . $settings->website_name;
   } elseif (!empty($dynamic_page)) {
      echo $dynamic_page->title . ' | ' . $settings->website_name;
   } elseif (!empty($SiteMeta_page)) {
      echo $SiteMeta_page->page_title . ' | ' . $settings->website_name;
   } else {
      echo $uppercase . ' | ' . $settings->website_name;
   } ?>">

   <meta name="twitter:description" content="<?php
   if (!empty($videos_data)) {
      echo $videos_data->description;
   } elseif (!empty($episdoe)) {
      echo $episdoe->description;
   } elseif (!empty($series)) {
      echo $series->description;
   } elseif (!empty($livestream)) {
      echo $livestream->description;
   } elseif (!empty($SiteMeta_page)) {
      echo $SiteMeta_page->meta_description . ' | ' . $settings->website_name;
   } else {
      echo $settings->website_description;
   } //echo $settings;  ?>">

   <!-- Twitter summary card with large image must be at least 280x150px -->
   <meta name="twitter:image:src"
      content="<?php
      if (!empty($videos_data)) {
         echo URL::to('/public/uploads/images') . '/' . $videos_data->player_image;
      } elseif (!empty($episdoe)) {
         echo URL::to('/public/uploads/images') . '/' . $episdoe->player_image;
      } elseif (!empty($series)) {
         echo URL::to('/public/uploads/images') . '/' . $series->player_image;
      } elseif (!empty($SiteMeta_image)) {
         echo $SiteMeta_image;
      } else {
         echo URL::to('/') . '/public/uploads/settings/' . $settings->default_horizontal_image;
      } //echo $settings;  ?>">

   <!-- Open Graph data -->
   <meta property="og:title" content="<?php
   if (!empty($videos_data)) {
      echo $videos_data->title . ' | ' . $settings->website_name;
   } elseif (!empty($series)) {
      echo $series->title . ' | ' . $settings->website_name;
   } elseif (!empty($episdoe)) {
      echo $episdoe->title . ' | ' . $settings->website_name;
   } elseif (!empty($livestream)) {
      echo $livestream->title . ' | ' . $settings->website_name;
   } elseif (!empty($dynamic_page)) {
      echo $dynamic_page->title . ' | ' . $settings->website_name;
   } elseif (!empty($SiteMeta_page)) {
      echo $SiteMeta_page->page_title . ' | ' . $settings->website_name;
   } else {
      echo $uppercase . ' | ' . $settings->website_name;
   } ?>" />
   <meta property="og:image"
      content="<?php
      if (!empty($videos_data)) {
         echo URL::to('/public/uploads/images') . '/' . $videos_data->player_image;
      } elseif (!empty($episdoe)) {
         echo URL::to('/public/uploads/images') . '/' . $episdoe->player_image;
      } elseif (!empty($series)) {
         echo URL::to('/public/uploads/images') . '/' . $series->player_image;
      } elseif (!empty($SiteMeta_image)) {
         echo $SiteMeta_image;
      } else {
         echo URL::to('/') . '/public/uploads/settings/' . $settings->default_horizontal_image;
      } //echo $settings;  ?>" />
   <meta property="og:description" content="<?php
   if (!empty($videos_data)) {
      echo $videos_data->description;
   } elseif (!empty($episdoe)) {
      echo $episdoe->description;
   } elseif (!empty($series)) {
      echo $series->description;
   } elseif (!empty($livestream)) {
      echo $livestream->description;
   } elseif (!empty($SiteMeta_page)) {
      echo $SiteMeta_page->meta_description . ' | ' . $settings->website_name;
   } else {
      echo $settings->website_description;
   } //echo $settings;  ?>" />

   <?php if (!empty($settings->website_name)) { ?>
      <meta property="og:site_name" content="<?php echo $settings->website_name; ?>" />
   <?php } ?>

   <?php $Linking_Setting = App\LinkingSetting::first();
   $site_url = \Request::url();
   $http_site_url = explode("http://", $site_url);
   $https_site_url = explode("https://", $site_url);
   if (!empty($http_site_url[1])) {
      $site_page_url = $http_site_url[1];
   } elseif (!empty($https_site_url[1])) {
      $site_page_url = $https_site_url[1];
   } else {
      $site_page_url = "";
   }
   ?>

   <?php if (!empty($Linking_Setting->ios_app_store_id)) { ?>
      <meta property="al:ios:app_store_id" content="<?php echo $Linking_Setting->ios_app_store_id; ?>" />
   <?php } ?>
   <meta property="al:ios:url" content="<?php echo $site_page_url; ?>" />
   <?php if (!empty($Linking_Setting->ipad_app_store_id)) { ?>
      <meta property="al:ipad:app_store_id" content="<?php echo $Linking_Setting->ipad_app_store_id; ?>" />
   <?php } ?>
   <meta property="al:ipad:url" content="<?php echo $site_page_url; ?>" />
   <?php if (!empty($Linking_Setting->android_app_store_id)) { ?>
      <meta property="al:android:package" content="<?php echo $Linking_Setting->android_app_store_id; ?>" />
   <?php } ?>
   <meta property="al:android:url" content="<?php echo $site_page_url; ?>" />
   <meta property="al:windows_phone:url" content="<?php echo $site_page_url; ?>" />
   <?php if (!empty($Linking_Setting->windows_phone_app_store_id)) { ?>
      <meta property="al:windows_phone:app_id" content="<?php echo $Linking_Setting->windows_phone_app_store_id; ?>" />
   <?php } ?>
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">

   <!-- Favicon -->


   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Sen:wght@400..800&display=swap" rel="stylesheet">

   <link rel="shortcut icon" href="<?php echo getFavicon(); ?>" type="image/gif" sizes="16x16">

   <input type="hidden" value="<?php echo $settings->google_tracking_id; ?>" name="tracking_id" id="tracking_id">

   <link async rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
      integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

   <link rel="preconnect" href="https://fonts.googleapis.com">

   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap">
   <link rel="shortcut icon" type="image/png" href="<?= URL::to('public/uploads/settings/' . $settings->favicon); ?>" />

   <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="<?= URL::to('public/themes/theme3/assets/css/bootstrap.min.css') ?>">

   <!-- Typography CSS -->
   <link rel="stylesheet" href="<?= URL::to('public/themes/theme3/assets/css/typography.css') ?>">

   <!-- Style -->
   <link rel="stylesheet" href="<?= URL::to('public/themes/theme3/assets/css/style.css') ?>">

   <!-- Responsive -->
   <link rel="stylesheet" href="<?= URL::to('public/themes/theme3/assets/css/responsive.css') ?>">

   <!-- slick -->
   <link rel="stylesheet" href="<?= URL::to('public/themes/theme3/assets/css/slick.css') ?>">

   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

   <!-- Remixicon -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css"
      integrity="sha512-HXXR0l2yMwHDrDyxJbrMD9eLvPe3z3qL3PPeozNTsiHJEENxx8DH2CxmV05iwG0dwoz5n4gQZQyYLUNt1Wdgfg=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />

   <!-- Ply.io -->

   <link rel="stylesheet" href="https://cdn.plyr.io/3.6.9/plyr.css" />

   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
      crossorigin="anonymous"></script>

   <script type="text/javascript">
      //	window.addEventListener("resize", function() {
      //		"use strict"; window.location.reload(); 
      //	});

      document.addEventListener("DOMContentLoaded", function () {

         /////// Prevent closing from click inside dropdown
         document.querySelectorAll('.dropdown-menu').forEach(function (element) {
            element.addEventListener('click', function (e) {
               e.stopPropagation();
            });
         })

         // make it as accordion for smaller screens
         if (window.innerWidth < 992) {

            // close all inner dropdowns when parent is closed
            document.querySelectorAll('.navbar .dropdown').forEach(function (everydropdown) {
               everydropdown.addEventListener('hidden.bs.dropdown', function () {
                  // after dropdown is hidden, then find all submenus
                  this.querySelectorAll('.submenu').forEach(function (everysubmenu) {
                     // hide every submenu as well
                     everysubmenu.style.display = 'none';
                  });
               })
            });

            document.querySelectorAll('.dropdown-menu a').forEach(function (element) {
               element.addEventListener('click', function (e) {

                  let nextEl = this.nextElementSibling;
                  if (nextEl && nextEl.classList.contains('submenu')) {
                     // prevent opening link if link needs to open dropdown
                     e.preventDefault();
                     console.log(nextEl);
                     if (nextEl.style.display == 'block') {
                        nextEl.style.display = 'none';
                     } else {
                        nextEl.style.display = 'block';
                     }

                  }
               });
            })
         }
         // end if innerWidth

      }); 
   </script>

   <?php
   if (count($Script) > 0) {
      foreach ($Script as $Scriptheader) { ?>
         <?= $Scriptheader ?>
      <?php }
   } ?>

   <?php
      if(count($css) > 0){
         foreach($css as $customCss){   ?>
            <?= $customCss ?>
         <?php }
      } 
   ?>
</head>

<style>
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
            background: rgba(255, 255, 255, .8);
            // gradient shine scroll
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
      widows: 30px;
   }

   .mk {
      display: none;
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
      font-family: "Sen", sans-serif;
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

   /* Dark mode and light Mode */

   body.light-theme {
      background:
         <?php echo GetLightBg(); ?>
         !important;
   }

   body.light-theme h4,
   body.light-theme p {
      color:
         <?php echo GetLightText(); ?>
      ;
   }

   body.light-theme header#main-header {
      background-color:
         <?php echo GetLightBg(); ?>
         !important;
      color:
         <?php echo GetLightText(); ?>
      ;
      box-shadow: rgb(0 0 0 / 16%) 0px 3px 10px;
   }

   body.light-theme footer {
      background:
         <?php echo GetLightBg(); ?>
         !important;
      color:
         <?php echo GetLightText(); ?>
      ;
      box-shadow: rgb(0 0 0 / 16%) 0px 3px 10px;
   }

   body.light-theme .copyright {
      background-color:
         <?php echo GetLightBg(); ?>
      ;
      color:
         <?php echo GetLightText(); ?>
      ;
   }

   body.light-theme .s-icon {
      background-color:
         <?php echo GetLightBg(); ?>
      ;
      box-shadow: rgb(0 0 0 / 16%) 0px 3px 10px;
   }

   body.light-theme .search-toggle:hover {
      color:
         <?php echo GetLightText(); ?>
         !important;
   }

   body.light-theme .dropdown-menu.categ-head {
      background-color:
         <?php echo GetLightBg(); ?>
         !important;
      color:
         <?php echo GetLightText(); ?>
         !important;
   }

   body.light-theme .search-toggle:hover {
      color: rgb(0, 82, 204) !important;
      font-weight: 500;
   }
   body.light-theme .search-toggle {
      color: #000 !important;
   }

   body.light-theme .navbar-right .iq-sub-dropdown {
      background-color:
         <?php echo GetLightBg(); ?>
      ;
   }

   body.light-theme .media-body h6 {
      color:
         <?php echo GetLightText(); ?>
      ;
      font-weight: 400;
   }

   body.light-theme .block-description h6 {
      color:
         <?php echo GetLightText(); ?>
      ;
      font-weight: 400;
   }

   body.light-theme .movie-time i {
      color:
         <?php echo GetLightText(); ?>
         !important;
      font-weight: 400;
   }

   body.light-theme .p-tag1 {
      color:
         <?php echo GetLightText(); ?>
         !important;
      font-weight: 400;
   }

   body.light-theme .p-tag {
      color:
         <?php echo GetLightText(); ?>
         !important;
      font-weight: 400;
   }

   body.light-theme .movie-time span {
      color:
         <?php echo GetLightText(); ?>
         !important;
      font-weight: 400;
   }

   body.light-theme .block-description a {
      color:
         <?php echo GetLightText(); ?>
         !important;
      font-weight: 400;
   }

   body.light-theme .block-description {
      background-image: linear-gradient(to bottom, rgb(243 244 247 / 30%), rgb(247 243 243 / 90%), rgb(247 244 244 / 90%), rgb(235 227 227 / 90%));
      backdrop-filter: blur(2px);
   }

   body.light-theme header .navbar ul li {
      font-weight: 400;
   }

   body.light-theme .slick-nav i {
      color:
         <?php echo GetLightText(); ?>
         !important;
   }

   body.light-theme h2 {
      color:
         <?php echo GetLightText(); ?>
         !important;
   }

   body.light-theme .filter-option-inner-inner {
      color:
         <?php echo GetLightText(); ?>
         !important;
   }

   body.light-theme .vid-title {
      color:
         <?php echo GetLightText(); ?>
         !important;
   }

   body.light-theme .trending-info h1 {
      color:
         <?php echo GetLightText(); ?>
         !important;
   }

   body.light-theme .text-detail {
      color:
         <?php echo GetLightText(); ?>
         !important;
   }

   body.light-theme .share-icons.music-play-lists li span i {
      color:
         <?php echo GetLightText(); ?>
         !important;
   }

   body.light-theme .btn1 {
      border: 1px solid
         <?php echo GetLightText(); ?>
         !important;
      color:
         <?php echo GetLightText(); ?>
         !important;
   }

   body.light-theme .trending-dec {
      color:
         <?php echo GetLightText(); ?>
         !important;
   }

   body.light-theme h6.trash {
      color: black;
   }

   /* Dark Mode */

   body.dark-theme {
      background:
         <?php echo GetDarkBg(); ?>
         !important;
   }

   body.dark-theme h4,
   body.dark-theme p {
      color:
         <?php echo GetDarkText(); ?>
      ;
   }

   body.dark-theme header#main-header {
      background-color:
         <?php echo GetDarkBg(); ?>
         !important;
      color:
         <?php echo GetDarkText(); ?>
      ;
      box-shadow: rgb(0 0 0 / 16%) 0px 3px 10px;
   }

   body.dark-theme footer {
      background:
         <?php echo GetDarkBg(); ?>
         !important;
      color:
         <?php echo GetDarkText(); ?>
      ;
      box-shadow: rgb(0 0 0 / 16%) 0px 3px 10px;
   }

   body.dark-theme .copyright {
      background-color:
         <?php echo GetDarkBg(); ?>
      ;
      color:
         <?php echo GetDarkText(); ?>
      ;
   }

   body.dark-theme .s-icon {
      background-color:
         <?php echo GetDarkBg(); ?>
      ;
      box-shadow: rgb(0 0 0 / 16%) 0px 3px 10px;
   }

   body.dark-theme .search-toggle:hover,
   header .navbar ul li.menu-item a:hover {
      color:<?php echo GetDarkText(); ?>!important;
   }

   body.light-theme #translator-table_filter input[type="search"] {
      color:
         <?php echo GetLightText(); ?>
      ;
   }

   body.dark-theme .dropdown-menu.categ-head {
      background-color:
         <?php echo GetDarkBg(); ?>
         !important;
      color:
         <?php echo GetDarkText(); ?>
         !important;
   }

   body.dark-theme .search-toggle:hover,
   header .navbar ul li.menu-item a:hover {
      color: rgb(0, 82, 204) !important;
      font-weight: 500;
   }

   body.dark-theme .navbar-right .iq-sub-dropdown {
      background-color:
         <?php echo GetDarkBg(); ?>
      ;
   }

   body.dark-theme .media-body h6 {
      color:
         <?php echo GetDarkText(); ?>
      ;
      font-weight: 400;
   }

   body.dark-theme .block-description h6 {
      color:
         <?php echo GetDarkText(); ?>
      ;
      font-weight: 400;
   }

   body.dark-theme .movie-time i {
      color:
         <?php echo GetDarkText(); ?>
         !important;
      font-weight: 400;
   }

   body.dark-theme .p-tag1 {
      color:
         <?php echo GetDarkText(); ?>
         !important;
      font-weight: 400;
   }

   body.dark-theme .p-tag {
      color:
         <?php echo GetDarkText(); ?>
         !important;
      font-weight: 400;
   }

   body.dark-theme .movie-time span {
      color:
         <?php echo GetDarkText(); ?>
         !important;
      font-weight: 400;
   }

   body.dark-theme .block-description a {
      color:
         <?php echo GetDarkText(); ?>
         !important;
      font-weight: 400;
   }

   body.dark-theme .block-description {
      /* background-image: linear-gradient(to bottom, rgb(243 244 247 / 30%), rgb(247 243 243 / 90%), rgb(247 244 244 / 90%), rgb(235 227 227 / 90%)); */
      backdrop-filter: blur(2px);
   }

   body.dark-theme header .navbar ul li {
      font-weight: 400;
   }

   body.dark-theme .slick-nav i {
      color:
         <?php echo GetDarkText(); ?>
         !important;
   }

   body.dark-theme h2 {
      color:
         <?php echo GetDarkText(); ?>
         !important;
   }

   body.dark-theme .filter-option-inner-inner {
      color:
         <?php echo GetDarkText(); ?>
         !important;
   }

   body.dark-theme .vid-title {
      color:
         <?php echo GetDarkText(); ?>
         !important;
   }

   body.dark-theme .trending-info h1 {
      color:
         <?php echo GetDarkText(); ?>
         !important;
   }

   body.dark-theme .text-detail {
      color:
         <?php echo GetDarkText(); ?>
         !important;
   }

   body.dark-theme .share-icons.music-play-lists li span i {
      color: #d30abe !important;
   }

   body.dark-theme .btn1 {
      border: 1px solid
         <?php echo GetDarkText(); ?>
         !important;
      color:
         <?php echo GetDarkText(); ?>
         !important;
   }

   body.dark-theme .trending-dec {
      color:
         <?php echo GetDarkText(); ?>
         !important;
   }

   body.dark-theme h6.trash {
      color: black;
   }

   .Search_error_class {
      color: red;
   }

   .channel-logo {
      border-left: 5px solid
         <?php echo GetDarkBg(); ?>
         !important;
      background: transparent linear-gradient(270deg, rgba(11, 1, 2, 0) 0%,
            <?php echo button_bg_color(); ?>
            100%);
   }

   #trending-slider-nav .slick-current.slick-active .movie-slick {
      border-color:
         <?php echo button_bg_color(); ?>
         !important;
   }

   #trending-slider-nav .movie-slick:before {
      border-top: 20px solid
         <?php echo button_bg_color(); ?>
         !important;
   }

   .dark-theme header .navbar ul li.menu-item a {
      color:
         <?php echo GetDarkText(); ?>
      ;
   }

   .light-theme header .navbar ul li.menu-item a {
      color:
         <?php echo GetLightText(); ?>
         !important;
   }

   .dark-theme ul.f-link li a {
      color:
         <?php echo GetDarkText(); ?>
      ;
   }

   .light-theme ul.f-link li a {
      color:
         <?php echo GetLightText(); ?>
         !important;
   }

   .dark-theme .text-body {
      color:
         <?php echo GetDarkText(); ?>
         !important;
   }

   .light-theme .text-body {
      color:
         <?php echo GetLightText(); ?>
         !important;
   }

   .dark-theme .s-icon {
      color:
         <?php echo GetDarkText(); ?>
         !important;
   }

   .light-theme .s-icon {
      color:
         <?php echo GetLightText(); ?>
         !important;
   }

   .dark-theme .iq-search-bar .search-input {
      color:
         <?php echo GetDarkText(); ?>
         !important;
   }

   /* .light-theme .iq-search-bar .search-input {
      color:
         <?php echo GetLightText(); ?>
         !important;
   } */

   .dark-theme ul.list-group.home-search {
      background:
         <?php echo GetDarkBg(); ?>
         !important;
   }

   .light-theme ul.list-group.home-search {
      background:
         <?php echo GetLightBg(); ?>
         !important;
   }

   /* .dark-theme .iq-search-bar .search-input {background: <?php echo GetDarkBg(); ?>
   !important;
   }

   */ .light-theme .iq-search-bar .search-input {
      background: <?php echo GetLightText(); ?> !important;
   }

   .dark-theme h1,
   .dark-theme h2,
   .dark-theme h3,
   .dark-theme h4,
   .dark-theme h5,
   .dark-theme h6 {
      color:
         <?php echo GetDarkText(); ?>
         !important;
   }

   .light-theme h1,
   .light-theme h2,
   .light-theme h3,
   .light-theme h4,
   .light-theme h5,
   .light-theme h6 {
      color:
         <?php echo GetLightText(); ?>
         !important;
   }

   body.dark-theme .navbar-expand-lg .navbar-nav .dropdown-menu {
      background:
         <?php echo GetDarkBg(); ?>
         !important;
   }

   body.dark-theme .offcanvas-collapse {
      background-color:
         <?php echo GetDarkBg(); ?>
         !important;
      color:
         <?php echo GetDarkText(); ?>
      ;
      /* box-shadow: rgb(0 0 0 / 16%) 0px 3px 10px; */
   }

   body.light-theme .offcanvas-collapse {
      background-color:
         <?php echo GetLightBg(); ?>
         !important;
      color:
         <?php echo GetLightText(); ?>
      ;
      box-shadow: rgb(0 0 0 / 16%) 0px 3px 10px;
   }

   body.dark-theme ul.navbar-nav {
      background-color:
         <?php echo GetDarkBg(); ?>
         !important;
      color:
         <?php echo GetDarkText(); ?>
      ;
      /* box-shadow: rgb(0 0 0 / 16%) 0px 3px 10px; */
   }

   body.light-theme ul.navbar-nav {
      background-color:
         <?php echo GetLightBg(); ?>
         !important;
      color:
         <?php echo GetLightText(); ?>
      ;
   }

   .light-theme.onclickbutton_menu {
      color:
         <?php echo GetLightText(); ?>
      ;
   }

   body.dark-theme .onclickbutton_menu {
      color:
         <?php echo GetDarkText(); ?>
      ;
   }

   /* .side-colps:not(.show){
   display:block;
} */
   .navbar-collapse.offcanvas-collapse.pt-2.open li.menu-item.d-flex.align-items-center {
      border-bottom: 1px solid rgba(85, 85, 85, 0.3) !important;
      margin-right: 0;
   }

   header#main-header.menu-sticky {
      position: fixed !important;
      top: 0;
      width: 100%;
      /* background: linear-gradient(180deg, #121C28 -35.59%, rgba(11, 18, 28, 0.36) 173.05%) !important; */
      -webkit-box-shadow: 0 0 30px 0 rgba(0, 0, 0, .1);
      -moz-box-shadow: 0 0 30px 0 rgba(0, 0, 0, .1);
      box-shadow: 0 0 30px 0 rgba(0, 0, 0, .1);
      z-index: 999;
   }

   .navbar-collapse.offcanvas-collapse.pt-2.open {
      height: 100vh;
      position: absolute;
   }

   nav.navbar.navbar-expand-lg.navbar-light.p-0 button#navToggle {
      display: none !important;
   }

   div#search_list ul.list-group {
      height: calc(100vh - 120px);
   }
   a.profile-icons.iq-user-dropdown.search-toggle.p-0.d-flex.align-items-center:hover{
      color: #fff !important;
   }
   .dropdown-menu.show{display:none;}
</style>

<style type="text/css">
   /* ============ desktop view ============ */
   @media(min-width: 991px) {
      .offcanvas-collapse {
         top: 59px !important;
      }

      header .navbar-collapse .offcanvas-collapse ul.navbar-nav {
         gap: 10px;
      }
   }

   @media(max-width: 1024px) {
      ul.submenu.dropdown-menu {
         left: 50%;
         top: 86px;
      }
   }

   @media all and (min-width: 992px) {

      .dropdown-menu li {
         position: relative;
      }

      .dropdown-menu .submenu {
         display: none;
         position: absolute;
         left: 100%;
         top: -7px;
      }

      .dropdown-menu .submenu-left {
         right: 100%;
         left: auto;
      }

      .dropdown-menu>li:hover a {
         color: rgb(0, 82, 204) !important;
         font-weight: 500;
      }

      .dropdown-menu>li:hover {
         background-color: #f1f1f1
      }

      li.nav-item.dropdown.menu-item:hover ul.dropdown-menu.primary_menu {
         display: block;
         top: 84%;
      }

      li.nav-item.dropdown.menu-item:hover ul.submenu.dropdown-menu {
         display: none;
      }

      li.nav-item.dropdown.menu-item li:hover ul.submenu.dropdown-menu {
         display: block !important;
      }

      .submenu a.dropdown-item.cont-item {
         color: white !important;
      }

      .submenu.dropdown-menu a.dropdown-item.cont-item:hover {
         color: rgb(0, 82, 204) !important;
      }

   }

   /* ============ desktop view .end// ============ */

   /* ============ small devices ============ */
   @media (max-width: 991px) {

      .dropdown-menu .dropdown-menu {
         margin-left: 0.7rem;
         margin-right: 0.7rem;
         margin-bottom: .5rem;
      }

   }

   /* ============ small devices .end// ============ */

   .dropdown-menu>li:hover a {
      color: #2578c0 !important;
   }

   @media (max-width:1170px) {
      .d-flex button.btn.btn-hover {
         font-size: 10px;
      }

      ul.top-colps li.menu-item a {
         padding: 10px 10px !important;
         font-size: 10px !important;
      }

      ul.top-colps {
         align-items: center;
      }
   }

   @media (max-width:425px) {
      .d-flex button.btn.btn-hover {
         font-size: 12px;
      }
   }

   @media (max-width:768px) {
      ul.dropdown-menu.primary_menu.show {
         top: 100%;
         left: 59px;
      }
   }

   @media (min-width:770px) {
      ul.dropdown-menu.primary_menu.show {
         top: 70%;
         /* left: 41px; */
      }
   }

   @media (max-width:1024px) {
      ul.submenu.dropdown-menu {
         top: 67px;
         left: 93%;
      }
   }

   @media only screen and (max-width: 991px) {
      .navbar-collapse.offcanvas-collapse.pt-2.open {
         top: 77px;
      }

      .iq-main-slider {
         padding-top: 0px !important;
      }

      #home-slider .slick-bg {
         padding: 0;
      }
   }


   @media only screen and (min-width: 1024px) {
      li.menu-item.d-flex.align-items-center {
         padding-left: 6px;
      }
   }

   @media (max-width: 850px) {
      nav.navbar.navbar-expand-lg.navbar-light.p-0 button#navToggle {
         display: block !important;
      }

      nav.navbar.navbar-expand-lg.navbar-light.p-0 {
         display: flex;
         flex-direction: column;
         align-items: flex-start;
         /* text-align: left; */
         /* width: 200px; */
         height: auto;
         position: relative;
         top: -50px;
      }
      header .navbar ul.navbar-nav{
         display: flex !important;
         flex-direction: column !important;
      }

      @media only screen and (max-width: 768px) {
         .logo-text {
            font-size: 10px !important;
         }

         .profile-icons {
            padding: 0 10px;
         }
      }

      @media only screen and (max-width: 600px) {
         .navbar-collapse.offcanvas-collapse.pt-2.open {
            top: 68px;
         }
      }

      @media only screen and (max-width: 528px) {
         .profile-icons {
            border: none !important;
         }

         .search-opacity {
            opacity: 0;
         }
      }

      @media only screen and (max-width: 480px) {
         .navbar-collapse.offcanvas-collapse.pt-2.open {
            top: 77px;
         }
      }

      @media only screen and (max-width: 425px) {
         nav.navbar.navbar-expand-lg.navbar-light.p-0 {
            top: -36px;
         }
      }

     

      .navbar>.container,
      .navbar>.container-fluid {
         flex-direction: column;
         align-items: start;
      }

      div#main_nav {
         padding-left: 0;
      }

      .container-fluid.p-0 {
         display: none;
      }

      .search-display-none {
         position: relative;
         left: 10%;
      }

   }

   @media (min-width:850px) {
      header .navbar ul.navbar-nav {
         display: flex !important;
      }

   }
   @media (min-width:851px) {
      button.navbar-toggler.d-block.border-0.p-0.mr-3.onclickbutton_menu {
         display: none !important;
      }

   }

   @media (max-width:600px) {

      li.nav-item.nav-icon.profile-icons.ml-2.signup-mob-res{
         display: none;
      }
   }
   @media (max-width:500px) {

      .my-account,
      .logo-text {
         display: none;
      }
   }

   @media (max-width:450px) {
      .search-display-none {
         display: none;
      }
   }

   @media (max-width:425px) {
      .top-nav-first {
         padding: 0 !important;
      }
   }

   @media (min-width:992px) {
      .mob_res {
         display: none !important;
      }

      .iq-main-slider {
         padding-top: 0 !important;
      }
   }



   /* Sidebar */
   body.dark-theme .offcanvas {
      background-color:
         <?php echo GetDarkBg(); ?>
         !important;
      color:
         <?php echo GetDarkText(); ?>
      ;
      box-shadow: rgb(0 0 0 / 16%) 0px 3px 10px;
   }

   body.light-theme .offcanvas {
      background-color: #ffffff !important;
      color: #000000;
      box-shadow: rgb(0 0 0 / 16%) 0px 3px 10px;
   }

   header .navbar ul.navbar-nav {
      display: flex;
      text-align: left;
      flex-direction: row;
      justify-content: space-around;
      align-items: start;
   }

   .top-colps ul.navbar-nav {
      display: flex;
      text-align: left;
      flex-direction: row;
      align-items: center;
   }

   header .navbar-collapse .offcanvas-collapse {
      display: flex;
      text-align: left;
      flex-direction: column;
   }

   header .navbar-collapse .offcanvas-collapse ul.navbar-nav {
      display: flex;
      text-align: left;
      flex-direction: column;
   }

   .onclickbutton_menu {
      background: transparent !important;
      /* color: white !important; */
   }

   /* div#main_nav {
   display: block !important;
} */
   .search-box {
      position: absolute;
      left: 25px !important;
      right: 0;
      top: 72px;
      min-width: 25rem;
      width: 100%;
      z-index: 99;
      opacity: 0;
      transform: translate(0, 70px);
      -webkit-transform: translate(0, 70px);
      -webkit-transition: all 0.3s ease-out 0s;
      -moz-transition: all 0.3s ease-out 0s;
      -ms-transition: all 0.3s ease-out 0s;
      -o-transition: all 0.3s ease-out 0s;
      transition: all 0.3s ease-out 0s;
      box-shadow: 0px 0px 20px 0px rgba(0, 0, 0, 0.15);
   }

   .avatar-40 {
      height: 40px !important;
      width: 40px !important;
      min-width: 40px;
      line-height: 40px;
      font-size: 0.6rem;
      padding: 6px;
   }

   .list-group-item {
      text-align: left;
   }

   .top-nav-first {
      padding: 10px 3rem;
   }

   .profile-icons {
      border: 1px solid;
      border-radius: 25px;
      padding: 0px 16px;
   }

   @media (max-width: 991px) {
      .menu-right {
         display: block;
      }
   }
</style>
<script>
   function toggleContainer(iconElement) {
      var container = document.querySelector('.container-fluid.p-0');
      if (window.innerWidth <= 850) {
         container.style.display = (container.style.display === 'none' || container.style.display === '') ? 'block' : 'none';
      } else {
         // Set the display to 'flex' for larger screens
         container.style.display = 'flex';
      }

      // Toggle between "fa-bars" and "fa-times" classes based on the presence of 'fa-bars'
      if (iconElement.classList.contains('fa-bars')) {
         iconElement.classList.remove('fa-bars');
         iconElement.classList.add('fa-times');
      } else {
         iconElement.classList.remove('fa-times');
         iconElement.classList.add('fa-bars');
      }
   }
</script>


<body class="dark-theme">
   <!-- loader Start -->
   <?php if (get_image_loader() == 1) { ?>
      <div class="fullpage-loader">
         <div class="fullpage-loader__logo">
            <img src="<?= front_end_logo() ?>" class="c-logo" alt="<?= $settings->website_name; ?>">

         </div>
      </div>
   <?php } ?>

   <header id="main-header">
      <div class="main-header">
         <div class="container-fluid top-nav-first">
            <div class="row">
               <div
                  class="col-lg-3 col-md-3 col-sm-3 col-3 d-flex align-items-center justify-content-start search-display-none">
                  <div class="navbar-right menu-right">
                     <ul class="d-flex align-items-center list-inline m-0">
                        <li class="nav-item nav-icon profile-icons search-opacity">
                           <a href="<?= URL::to('searchResult') ?>" class="search-toggle device-search"
                              style="font-size:11px;">
                              <i class="ri-search-line"></i>
                              <span class="my-account">
                                 <?= 'Search' ?>
                              </span>
                           </a>

                           <div class="search-box iq-search-bar d-search">
                              <form action="<?= URL::to("searchResult") ?>" class="searchbox" id="searchResult"
                                 method="get">
                                 <div class="form-group position-relative">
                                    <input type="text" class="text search-input font-size-12 searches" name="search"
                                       placeholder="type here to search...">
                                    <i class="search-link ri-search-line"></i>
                                    <?php include 'public/themes/theme3/partials/Search_content.php'; ?>
                                 </div>
                              </form>
                           </div>

                           <div class="iq-sub-dropdown search_content overflow-auto mt-3" id="sidebar-scrollbar"
                              style="width:146px;">
                              <div class="iq-card-body">
                                 <div id="search_list" class="search_list search-toggle device-search"></div>
                              </div>
                           </div>
                        </li>
                     </ul>
                  </div>
               </div>

               <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                  <div class="text-center">
                     <a class="navbar-brand" href="<?= URL::to('/home') ?>"> <img class="img-fluid logo"
                           src="<?= front_end_logo() ?>" width="130px" /> </a>
                     <p class="logo-text" style="font-size:11px;margin:0;">
                        <?= 'Created by Music Fans for Music Fans' ?>
                     </p>
                  </div>
               </div>

               <div class="col-lg-3 col-md-3 col-sm-3 col-3 d-flex align-items-center justify-content-end">
                  <div class="navbar-right menu-right">
                     <ul class="d-flex align-items-center list-inline m-0">
                        <li class="nav-item nav-icon ">
                           <?php if (!Auth::guest()): ?>

                              <a href="#" class="profile-icons iq-user-dropdown search-toggle p-0 d-flex align-items-center"
                                 style="font-size:11px; padding:0 16px !important;" data-toggle="search-toggle">
                                    <?php if(Auth::user() && Auth::user()->avatar === null): ?>
                                          <img src="<?php echo URL::to('/assets/img/uss.png'); ?>" class="img-fluid avatar-40 rounded-circle" alt="Placeholder Image">
                                    <?php else: ?>
                                       <img src="<?php echo URL::to('public/uploads/avatars/' . Auth::user()->avatar); ?>" class="img-fluid avatar-40 rounded-circle">
                                    <?php endif; ?>
                                 <!-- <img src="<?= !Auth::guest() && Auth::user()->avatar ? URL::to('public/uploads/avatars/' . Auth::user()->avatar) : URL::to('/public/themes/theme3/assets/images/user/user.jpg') ?>"87+4 class="img-fluid avatar-40 rounded-circle mr-2" alt="user"> -->
                                 <span class="my-account">
                                    <?= "My Account" ?>
                                 </span>
                              </a>

                           <?php endif; ?>

                           <div class="iq-sub-dropdown iq-user-dropdown">
                              <div class="iq-card shadow-none m-0">

                                 <?php if (Auth::guest()): ?>

                                    <?php if( $theme->signin_header == 1 ): ?>
                                       <div class="iq-card-body p-0 pl-3 pr-3">
                                          <li class="nav-item nav-icon profile-icons">
                                             <a href="<?php echo URL::to('login') ?>" class="iq-sub-card">
                                                <div class="media align-items-center">
                                                   <div class="right-icon"><i class="ri-login-circle-line text-primary"></i></div>
                                                   <div class="media-body">
                                                      <h6 class="mb-0 ">Signin</h6>
                                                   </div>
                                                </div>
                                             </a>
                                          </li>

                                          <li class="nav-item nav-icon profile-icons ml-2 signup-mob-res">
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

                  <?php elseif (!Auth::guest() && Auth::user()->role == "admin"): ?>



                     <div class="iq-card-body p-0 pl-3 pr-3">


                        <div class="toggle mt-2 text-left">
                           <i class="fas fa-moon"></i>
                           <label class="switch toggle mt-3">
                              <input type="checkbox" id="toggle" value=<?php echo $theme_mode; ?>    <?php if ($theme_mode == "light") {
                                         echo 'checked';
                                      } ?> />
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

                        <!-- <a href="<?= URL::to('/admin/subscription-plans') ?>" class="iq-sub-card setting-dropdown">
                                             <div class="media align-items-center">
                                                   <div class="right-icon"><i class="ri-settings-4-line text-primary"></i></div>
                                                   <div class="media-body ml-3">
                                                      <h6 class="mb-0 ">Pricing Plan</h6>
                                                   </div>
                                             </div>
                                          </a> -->

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

                  <?php elseif (!Auth::guest() && Auth::user()->role == "subscriber"): ?>



                     <div class="iq-card-body p-0 pl-3 pr-3">
                        <div class="toggle mt-2 text-left">
                           <i class="fas fa-moon"></i>
                           <label class="switch toggle mt-3">
                              <input type="checkbox" id="toggle" value=<?php echo $theme_mode; ?>    <?php if ($theme_mode == "light") {
                                         echo 'checked';
                                      } ?> />
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

                        <a href="<?= URL::to('/logout') ?>" class="iq-sub-card setting-dropdown">
                           <div class="media align-items-center">
                              <div class="right-icon"><i class="ri-logout-circle-line text-primary"></i></div>
                              <div class="media-body ml-3">
                                 <h6 class="mb-0 ">Logout</h6>
                              </div>
                           </div>
                        </a>
                     </div>

                  <?php elseif (!Auth::guest() && Auth::user()->role == "registered"): ?>



                     <div class="iq-card-body p-0 pl-3 pr-3">
                        <div class="toggle mt-2 text-left">
                           <i class="fas fa-moon"></i>
                           <label class="switch toggle mt-3">
                              <input type="checkbox" id="toggle" value=<?php echo $theme_mode; ?>    <?php if ($theme_mode == "light") {
                                         echo 'checked';
                                      } ?> />
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
      </div>
      </div>
      </div>
      <div class="container-fluid pl-3">
         <div class="row">

            <!-- <?php if ($theme->header_top_position == 1): ?>
                     <div class="col-sm-9 mx-auto header_top_position_img">
                        <img class="img-fluid logo" src=<?= URL::to('public\themes\theme3\views\img\DOWNLOAD-TAPP-TODAY-new-1536x58.png') ?> /> 
                     </div>
                  <?php endif; ?> -->

            <div class="col-sm-12">


               <!-- ============= COMPONENT ============== -->
               <nav class="navbar navbar-expand-lg navbar-light p-0">
                  <button class="navbar-toggler d-block border-0 p-0 mr-3 onclickbutton_menu fa-bar-screen"><i
                        class="fa fa-bars" onclick="toggleContainer(this)" aria-hidden="true"></i></button>


                  <div class="container-fluid p-0">

                     <!-- Header Side Position  -->
                     <?php if ($theme->header_side_position == 1): ?>
                        <button class="navbar-toggler d-block border-0 p-0 mr-3 onclickbutton_menu" type="button"
                           id="navToggle" data-bs-dismiss="offcanvas"><i class="fa fa-bars" onclick="changeIcon(this)"
                              aria-hidden="true"></i></button>
                     <?php endif; ?>

                     <!-- <a class="navbar-brand" href="<?= URL::to('/home') ?>"> <img class="img-fluid logo" src="<?= front_end_logo() ?>" width="50%"/> </a> -->


                     <div class="side-colps navbar navbar-expand-lg navbar-light" id="main_nav">

                     <ul class="navbar-nav top-colps">

                                       <?php  

                                          $header_top_position_menus = App\Menu::orderBy('order', 'asc')->where('in_home',1)->get();
                                                                              
                                          $Parent_video_category = App\VideoCategory::whereIn('id', function ($query) {
                                             
                                             $query->select('parent_id')->from('video_categories');

                                                   })->orwhere('parent_id',0)->orwhere('parent_id',null)->orderBy('order', 'asc')->where('in_menu',1)

                                                ->get()->map(function ($item) {

                                                $item['sub_video_category'] = App\VideoCategory::where('parent_id',$item->id)->orderBy('order', 'asc')->where('in_menu',1)->get();
                                             
                                                return $item;
                                          });

                                          $Parent_live_category = App\LiveCategory::whereIn('id', function ($query) {
                                             
                                             $query->select('parent_id')->from('live_categories');

                                                   })->orwhere('parent_id',0)->orwhere('parent_id',null)->orderBy('order', 'asc')

                                                ->get()->map(function ($item) {

                                                $item['sub_live_category'] = App\LiveCategory::where('parent_id',$item->id)->orderBy('order', 'asc')->get();
                                             
                                                return $item;
                                          });

                                          $Parent_audios_category = App\AudioCategory::whereIn('id', function ($query) {
                                             
                                             $query->select('parent_id')->from('audio_categories');

                                                   })->orwhere('parent_id',0)->orwhere('parent_id',null)->orderBy('order', 'asc')->where('active',1)

                                                ->get()->map(function ($item) {

                                                $item['sub_audios_category'] = App\AudioCategory::where('parent_id',$item->id)->orderBy('order', 'asc')->get();
                                             
                                                return $item;
                                          });

                                          $Parent_series_category = App\SeriesGenre::whereIn('id', function ($query) {
                                             
                                             $query->select('parent_id')->from('series_genre');

                                                   })->orwhere('parent_id',0)->orwhere('parent_id',null)->orderBy('order', 'asc')->where('in_menu',1)

                                                ->get()->map(function ($item) {

                                                $item['sub_series_category'] = App\SeriesGenre::where('parent_id',$item->id)->where('in_menu',1)->orderBy('order', 'asc')->get();
                                             
                                                return $item;
                                          });

                                          $Parent_Series_Networks = App\SeriesNetwork::whereIn('id', function ($query) {
                                             
                                             $query->select('parent_id')->from('series_networks');
                                          
                                                   })->orwhere('parent_id',0)->orwhere('parent_id',null)->orderBy('order', 'asc')->where('in_menu',1)
                                          
                                                ->get()->map(function ($item) {
                                          
                                                $item['Sub_Series_Networks'] = App\SeriesNetwork::where('parent_id',$item->id)->where('in_menu',1)->orderBy('order', 'asc')->get();
                                             
                                                return $item;
                                          });

                                          $tv_shows_series = App\Series::where('active',1)->get();

                                          $languages = App\Language::all();

                                          foreach ($header_top_position_menus as $menu) {

                                             if ( $menu->in_menu == "video" ) {  ?>

                                                <li class="nav-item dropdown menu-item d-flex align-items-center">
                                                   <a class="nav-link dropdown-toggle justify-content-between" id="cate-down" href="<?= URL::to($menu->url) ?>" data-bs-toggle="dropdown">
                                                      <?= $menu->name ?> <i class="fa fa-angle-down"></i>
                                                   </a>

                                                   <ul class="dropdown-menu primary_menu">
                                                      <?php foreach ( $Parent_video_category as $category) : ?>
                                                         <?php if( !is_null($category) ): ?>
                                                            <li>
                                                               <a class="dropdown-item cont-item" href="<?= route('Parent_video_categories',$category->slug) ?>">
                                                                  <?= $category->name;?>
                                                               </a>

                                                               <?php foreach ( $category->sub_video_category as $sub_video_category) : ?>
                                                                  <?php if( !is_null($category) ): ?>
                                                                     <ul class="submenu dropdown-menu">
                                                                        <?php foreach ( $category->sub_video_category as $sub_video_category) : ?>
                                                                           <li>
                                                                              <a class="dropdown-item cont-item" href="<?= route('Parent_video_categories',$sub_video_category->slug)?>">
                                                                                 <?= $sub_video_category->name;?>
                                                                              </a>
                                                                           </li>
                                                                        <?php endforeach ; ?>
                                                                     </ul>
                                                               <?php endif; endforeach ; ?>
                                                            </li>
                                                         <?php endif; ?>
                                                      <?php endforeach ; ?>
                                                   </ul>
                                                      
                                                </li>

                                             <?php } elseif  ( $menu->in_menu == "movies") {  ?>

                                                <li class="nav-item dropdown menu-item d-flex align-items-center">
                                                   <a class="dropdown-toggle justify-content-between " id="movie-down" href="<?= URL::to($menu->url) ?>" data-toggle="dropdown">
                                                         <?= ($menu->name);?> <i class="fa fa-angle-down"></i>
                                                   </a>

                                                   <ul class="dropdown-menu primary_menu">
                                                      <?php foreach ( $languages as $language): ?>
                                                         <li>
                                                            <a class="dropdown-item cont-item" href="<?= URL::to('language/'.$language->id.'/'.$language->name);?>">
                                                               <?= $language->name;?>
                                                            </a>
                                                         </li>
                                                      <?php endforeach; ?>
                                                   </ul>
                                                </li>

                                             <?php } elseif ( $menu->in_menu == "live") { ?>

                                                <li class="nav-item dropdown menu-item d-flex align-items-center">
                                                   <a class="nav-link dropdown-toggle justify-content-between" id="dn" href="<?= URL::to($menu->url) ?>" data-bs-toggle="dropdown">
                                                      <?= $menu->name ?> <i class="fa fa-angle-down"></i>
                                                   </a>

                                                   <ul class="dropdown-menu primary_menu">
                                                      <?php 
                                                         foreach ( $Parent_live_category as $category) :
                                                            if( !is_null($category) ): ?>
                                                               <li>
                                                                  <a class="dropdown-item cont-item" href="<?= URL::to('live/category/'.$category->slug) ?>">
                                                                     <?= $category->name;?>
                                                                  </a>

                                                                  <?php foreach ( $category->sub_live_category as $sub_live_category) : ?>
                                                                     <?php if( !is_null($category) ): ?>
                                                                        <ul class="submenu dropdown-menu">
                                                                           <?php foreach ( $category->sub_live_category as $sub_live_category) : ?>
                                                                              <li>
                                                                                 <a class="dropdown-item cont-item" href="<?= URL::to('live/category/'.$sub_live_category->slug) ?>">
                                                                                    <?= $sub_live_category->name;?>
                                                                                 </a>
                                                                              </li>
                                                                           <?php endforeach ; ?>
                                                                        </ul>
                                                                  <?php endif; endforeach ; ?>
                                                               </li> <?php
                                                            endif; 
                                                         endforeach ; ?>
                                                   </ul>
                                                      
                                                </li>

                                             <?php } elseif ( $menu->in_menu == "audios") { ?>

                                                <li class="nav-item dropdown menu-item d-flex align-items-center">
                                                   <a class="nav-link dropdown-toggle justify-content-between" id="dn" href="<?= URL::to($menu->url) ?>" data-bs-toggle="dropdown">
                                                      <?= $menu->name ?> <i class="fa fa-angle-down"></i>
                                                   </a>

                                                   <ul class="dropdown-menu primary_menu">
                                                      <?php 
                                                         foreach ( $Parent_audios_category as $category) :
                                                            if( !is_null($category) ): ?>
                                                               <li>
                                                                  <a class="dropdown-item cont-item" href="<?= URL::to('audio/'.$category->slug) ?>">
                                                                     <?= $category->name;?>
                                                                  </a>

                                                                  <?php foreach ( $category->sub_audios_category as $sub_audios_category) : ?>
                                                                     <?php if( !is_null($category) ): ?>
                                                                        <ul class="submenu dropdown-menu">
                                                                           <?php foreach ( $category->sub_audios_category as $sub_audios_category) : ?>
                                                                              <li>
                                                                                 <a class="dropdown-item cont-item" href="<?= URL::to('audio/'.$sub_audios_category->slug) ?>">
                                                                                    <?= $sub_audios_category->name;?>
                                                                                 </a>
                                                                              </li>
                                                                           <?php endforeach ; ?>
                                                                        </ul>
                                                                  <?php endif; endforeach ; ?>
                                                               </li> <?php
                                                            endif; 
                                                         endforeach ; ?>
                                                   </ul>
                                                      
                                                </li>

                                             <?php }elseif ( $menu->in_menu == "tv_show") { ?>
                                                
                                                <li class="nav-item active dskdflex menu-item ">

                                                   <a href="<?php echo URL::to($menu->url)?>">
                                                         <?= ($menu->name); ?> <i class="fa fa-angle-down"></i>
                                                   </a>

                                                   <?php if(count($tv_shows_series) > 0 ){ ?>
                                                      <ul class="dropdown-menu categ-head primary_menu">
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

                                             <?php }elseif ( $menu->in_menu == "series") { ?>
                                                
                                                <li class="nav-item dropdown menu-item d-flex align-items-center">
                                                   <a class="nav-link dropdown-toggle justify-content-between" id="dn" href="<?= URL::to($menu->url) ?>" data-bs-toggle="dropdown">
                                                      <?= $menu->name ?> <i class="fa fa-angle-down"></i>
                                                   </a>

                                                   <ul class="dropdown-menu primary_menu">
                                                      <?php 
                                                         foreach ( $Parent_series_category as $category) :
                                                            if( !is_null($category) ): ?>
                                                               <li>
                                                                  <a class="dropdown-item cont-item" href="<?= URL::to('series/category/'.$category->slug) ?>">
                                                                     <?= $category->name;?>
                                                                  </a>

                                                                  <?php foreach ( $category->sub_series_category as $sub_series_category) : ?>
                                                                     <?php if( !is_null($category) ): ?>
                                                                        <ul class="submenu dropdown-menu">
                                                                           <?php foreach ( $category->sub_series_category as $sub_series_category) : ?>
                                                                              <li>
                                                                                 <a class="dropdown-item cont-item" href="<?= URL::to('series/category/'.$category->slug) ?>">
                                                                                    <?= $sub_series_category->name;?>
                                                                                 </a>
                                                                              </li>
                                                                           <?php endforeach ; ?>
                                                                        </ul>
                                                                  <?php endif; endforeach ; ?>
                                                               </li> <?php
                                                            endif; 
                                                         endforeach ; ?>
                                                   </ul>
                                                      
                                                </li>

                                             <?php }elseif ( $menu->in_menu == "networks") { ?>

                                                <li class="nav-item dropdown menu-item d-flex align-items-center">
                                                      <a class="nav-link dropdown-toggle justify-content-between" id="dn" href="<?= URL::to($menu->url) ?>" data-bs-toggle="dropdown">
                                                         <?= $menu->name ?> <i class="fa fa-angle-down"></i>
                                                      </a>

                                                      <ul class="dropdown-menu primary_menu">
                                                         <?php 
                                                            foreach ( $Parent_Series_Networks as $category) :
                                                               if( !is_null($category) ): ?>
                                                                  <li>
                                                                     <a class="dropdown-item cont-item" href="<?= route('Specific_Series_Networks',$category->slug) ?>">
                                                                        <?= $category->name;?>
                                                                     </a>

                                                                     <?php foreach ( $category->Sub_Series_Networks as $Sub_Series_Networks) : ?>
                                                                        <?php if( !is_null($category) ): ?>
                                                                           <ul class="submenu dropdown-menu">
                                                                              <?php foreach ( $category->Sub_Series_Networks as $Sub_Series_Networks) : ?>
                                                                                 <li>
                                                                                    <a class="dropdown-item cont-item" href="<?= route('Specific_Series_Networks',$category->slug) ?>">
                                                                                       <?= $Sub_Series_Networks->name;?>
                                                                                    </a>
                                                                                 </li>
                                                                              <?php endforeach ; ?>
                                                                           </ul>
                                                                     <?php endif; endforeach ; ?>
                                                                  </li> <?php
                                                               endif; 
                                                            endforeach ; ?>
                                                      </ul>
                                                         
                                                   </li>

                                             <?php } else { ?>

                                                <li class="menu-item">
                                                   <a href="<?php if($menu->select_url == "add_Site_url"){ echo URL::to( $menu->url ); }elseif($menu->select_url == "add_Custom_url"){ echo $menu->custom_url;  }?>">
                                                         <?php echo __($menu->name);?>
                                                   </a>
                                                </li>

                                             <?php  } 
                                          } ?>
                                    </ul>
                     </div>

                     <!-- Channel and CPP Login -->
                     <div class="d-flex p-2">
                        <?php if (!Auth::guest()) {
                           $userEmail = Auth::user()->email;
                           $moderatorsUser = App\ModeratorsUser::where('email', $userEmail)->first();
                           $channel = App\Channel::where('email', $userEmail)->first();

                           if (!empty($moderatorsUser)) { ?>
                              <div class="p-2">
                                 <form method="POST" action="<?= URL::to('cpp/home') ?>">
                                    <input type="hidden" name="_token" id="token" value="<?= csrf_token() ?>">
                                    <input type="hidden" name="email" value="<?= $userEmail ?>" autocomplete="email"
                                       autofocus>
                                    <input type="hidden" name="password" value="<?= @$moderatorsUser->password ?>"
                                       autocomplete="current-password">
                                    <button type="submit" class="btn btn-primary">Visit CPP Portal</button>
                                 </form>
                              </div>
                           <?php }

                           if (!empty($channel)) { ?>
                              <div class="p-2">
                                 <form method="POST" action="<?= URL::to('channel/home') ?>">
                                    <input type="hidden" name="_token" id="token" value="<?= csrf_token() ?>">
                                    <input type="hidden" name="email" value="<?= $userEmail ?>" autocomplete="email"
                                       autofocus>
                                    <input type="hidden" name="password" value="<?= @$channel->unhased_password ?>"
                                       autocomplete="current-password">
                                    <button type="submit" class="btn btn-primary">Visit Channel Portal</button>
                                 </form>
                              </div>
                           <?php }
                        } ?>
                     </div>

                     <!-- <div class="navbar-right menu-right">
                                    <ul class="d-flex align-items-center list-inline m-0">

                                       <li class="nav-item nav-icon">
                                             <a href="<?= URL::to('searchResult') ?>" class="search-toggle device-search">
                                                <i class="ri-search-line"></i>
                                             </a>

                                          <div class="search-box iq-search-bar d-search">
                                             <form action="<?= URL::to("searchResult") ?>" class="searchbox" id="searchResult" >
                                             <input name="_token" type="hidden" value="<?= csrf_token(); ?>" />
                                                <div class="form-group position-relative">
                                                   <input type="text" class="text search-input font-size-12 searches"
                                                      placeholder="type here to search...">
                                                   <i class="search-link ri-search-line"></i>
                                                   <?php  // include 'public/themes/theme3/partials/Search_content.php';  ?>
                                                </div>
                                             </form>
                                          </div>

                                          <div class="iq-sub-dropdown search_content overflow-auto mt-3" id="sidebar-scrollbar" style="width:146px;">
                                             <div class="iq-card-body">
                                                <div id="search_list" class="search_list search-toggle device-search" ></div>
                                             </div>
                                          </div>
                                       </li> -->

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
                                                               <img src="https://localhost/flicknexs/public/themes/theme3/assets/images/notify/thumb-1.jpg"
                                                                     class="img-fluid mr-3" alt="" />
                                                               <div class="media-body">
                                                                     <h6 class="mb-0 ">Boot Bitty</h6>
                                                                     <small class="font-size-12"> just now</small>
                                                               </div>
                                                            </div>
                                                         </a>
                                                         <a href="#" class="iq-sub-card">
                                                            <div class="media align-items-center">
                                                               <img src="https://localhost/flicknexs/public/themes/theme3/assets/images/notify/thumb-2.jpg"
                                                                     class="img-fluid mr-3" alt="" />
                                                               <div class="media-body">
                                                                     <h6 class="mb-0 ">The Last Breath</h6>
                                                                     <small class="font-size-12">15 minutes ago</small>
                                                               </div>
                                                            </div>
                                                         </a>
                                                         <a href="#" class="iq-sub-card">
                                                            <div class="media align-items-center">
                                                               <img src="https://localhost/flicknexs/public/themes/theme3/assets/images/notify/thumb-3.jpg"
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
                     <!-- <li class="nav-item nav-icon">
                                             <?php if (!Auth::guest()): ?>

                                                <a href="#" class="iq-user-dropdown search-toggle p-0 d-flex align-items-center"
                                                   data-toggle="search-toggle">
                                                         <img src="<?= !Auth::guest() && Auth::user()->avatar ? URL::to('public/uploads/avatars/' . Auth::user()->avatar) : URL::to('/public/themes/theme3/assets/images/user/user.jpg') ?>"
                                                         class="img-fluid avatar-40 rounded-circle" alt="user">
                                                </a>

                                             <?php endif; ?>

                                             <div class="iq-sub-dropdown iq-user-dropdown">
                                                <div class="iq-card shadow-none m-0">

                                                <?php if (Auth::guest()): ?>

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

                                                   <?php elseif (!Auth::guest() && Auth::user()->role == "admin"): ?>
                                                      
                                                      

                                                      <div class="iq-card-body p-0 pl-3 pr-3">


                                                      <div class="toggle mt-2 text-left">
                                                         <i class="fas fa-moon"></i>
                                                            <label class="switch toggle mt-3">
                                                               <input type="checkbox" id="toggle"  value=<?php echo $theme_mode; ?> 
                                                                  <?php if ($theme_mode == "light") {
                                                                     echo 'checked';
                                                                  } ?> />
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
                                                         </a> -->

                        <!-- <a href="<?= URL::to('/admin/subscription-plans') ?>" class="iq-sub-card setting-dropdown">
                                                            <div class="media align-items-center">
                                                                  <div class="right-icon"><i class="ri-settings-4-line text-primary"></i></div>
                                                                  <div class="media-body ml-3">
                                                                     <h6 class="mb-0 ">Pricing Plan</h6>
                                                                  </div>
                                                            </div>
                                                         </a> -->

                        <!-- <a href="<?= URL::to('/mywishlists') ?>" class="iq-sub-card setting-dropdown">
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

                                                   <?php elseif (!Auth::guest() && Auth::user()->role == "subscriber"): ?>

                                                      <div class="toggle mt-2 ">
                                                         <i class="fas fa-moon"></i>
                                                            <label class="switch toggle mt-3">
                                                               <input type="checkbox" id="toggle"  value=<?php echo $theme_mode; ?>  <?php if ($theme_mode == "light") {
                                                                        echo 'checked';
                                                                     } ?> />
                                                               <span class="sliderk round"></span>
                                                            </label>
                                                         <i class="fas fa-sun"></i>
                                                      </div>

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

                                                   <?php elseif (!Auth::guest() && Auth::user()->role == "registered"): ?>
                                                      
                                                      <div class="toggle mt-2 ">
                                                         <i class="fas fa-moon"></i>
                                                            <label class="switch toggle mt-3">
                                                               <input type="checkbox" id="toggle"  value=<?php echo $theme_mode; ?>  <?php if ($theme_mode == "light") {
                                                                        echo 'checked';
                                                                     } ?> />
                                                               <span class="sliderk round"></span>
                                                            </label>
                                                         <i class="fas fa-sun"></i>
                                                      </div>

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
                                 </div> -->
                  </div> <!-- container-fluid.// -->
               </nav>

               <div class="nav-overlay"></div>
            </div>
         </div>
      </div>
      </div>
   </header>

   <?php

   $playerui_settings = App\Playerui::first();
   if ($playerui_settings->watermark == 1) { ?>
      <style>
         .plyr__video-wrapper::before {
            position: absolute;
            top:
               <?php echo $playerui_settings->watermark_top;
               ?>
            ;
            left:
               <?php echo $playerui_settings->watermark_left;
               ?>
            ;
            opacity:
               <?php echo $playerui_settings->watermark_opacity;
               ?>
            ;
            z-index: 2;
            content: '';
            height: 150px;
            width:
               <?php echo $playerui_settings->watermar_width;
               ?>
            ;
            background: url(<?php echo $playerui_settings->watermark_logo; ?>) no-repeat;
            /* background-size: 100px auto, auto; */
            background-size: contain;
         }
      </style>
   <?php } else {
   } ?>


   <script>

      $(document).ready(function () {
         $(".dropdown-toggle").dropdown();
      });

      $(document).ready(function () {
         var currentdate = "<?= $currentdate ?>";
         var filldate = "<?= $filldate ?>";
         var DOB = "<?= $DOB ?>";

         // console.log(DOB);
         // console.log(currentdate);

         if (filldate == currentdate && DOB != null && !empty(DOB) && currentdate != null && filldate !=
            null) {
            $("body").append(
               '<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Add Your DOB for Amazing video experience</div>'
            );
            setTimeout(function () {
               $('.add_watch').slideUp('fast');
            }, 3000);
         }
      });

   </script>
   <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
   <script>
      // Function to toggle the visibility of the container
      function toggleContainer() {
         var container = document.querySelector('.container-fluid.p-0');
         container.style.display = (container.style.display === 'none') ? 'block' : 'none';
      }

      // Function to change the icon (assuming it's defined in your JavaScript)
      function changeIcon(icon) {
         // Add logic to change the icon if needed
      }
   </script>
   <script src="<?= URL::to('/') . '/assets/admin/dashassets/js/google_analytics_tracking_id.js'; ?>"></script>

   <script>

      $("#toggle").click(function () {

         var theme_mode = $("#toggle").prop("checked");

         $.ajax({
            url: '<?php echo URL::to("theme-mode"); ?>',
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

      //  Dark Mode & Light Mode 

      $(document).ready(function () {

         let theme_modes = $("#toggle").val();

         if (theme_modes == 'light') {

            body.classList.remove('dark-theme');
            body.classList.add('light-theme');

         } else if (theme_modes == 'dark') {

            body.classList.remove('light-theme');
            body.classList.add('dark-theme');
         }
      });

      $('ul.nav li.dropdown').hover(function () {
         $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(700);
      }, function () {
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

   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
      integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
      crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
      integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
      crossorigin="anonymous"></script>

   <style>
      .dropdown-toggle::after {
         display: none;
      }

      ul.dropdown-menu.categ-head {
         overflow: hidden;
      }

      .home-page-close-button {
         position: absolute;
         top: 10px;
         right: 10px;
         background: none;
         border: none;
         font-size: 30px;
         cursor: pointer;
         color: white;
         transition: transform 0.3s ease;
         transform-origin: center center;
         transform: scale(1);
      }

      .home-page-close-button:hover {
         transform: scale(1.2);
      }

      .home-page-bg-img {
         width: 1485px;
         !important
      }

      /* li.nav-item.dropdown.menu-item:hover .dropdown-menu{
         display:block !important;
      } */
      ul.dropdown-menu.show li:hover a.dropdown-item.cont-item {
         color: #2578c0 !important;
      }
   </style>

   <style>
      .offcanvas-collapse.open ul.navbar-nav {
         width: 300px;
         left: 0;
      }

      .offcanvas-collapse {
         position: fixed;
         top: 89px;
         bottom: 0;
         right: 100%;
         left: -300px;
         width: 300px;
         padding-right: 1rem;
         /* padding-left: 1rem; */
         /* overflow-y: auto; */
         visibility: hidden;
         transition-timing-function: ease-in-out;
         transition-duration: .3s;
         transition-property: left, visibility;
      }

      .offcanvas-collapse {
         align-items: start;
         -moz-background-clip: padding;
         -webkit-background-clip: padding;
         /* background-clip: padding-box; */
         /* border-right: 5px solid rgba(0, 0, 0, 0.2); */

      }

      .offcanvas-collapse.open {
         left: -19px;
         visibility: visible;
      }

      .navbar-expand-lg .navbar-nav {
         -ms-flex-direction: column;
         flex-direction: column;
      }

      .nav-scroller {
         position: relative;
         z-index: 2;
         height: 2.75rem;
         overflow-y: hidden;
      }

      .nav-scroller .nav {
         display: -ms-flexbox;
         display: flex;
         -ms-flex-wrap: nowrap;
         flex-wrap: nowrap;
         padding-bottom: 1rem;
         margin-top: -1px;
         overflow-x: auto;
         color: rgba(255, 255, 255, .75);
         text-align: center;
         white-space: nowrap;
         -webkit-overflow-scrolling: touch;
      }

      .nav-underline .nav-link {
         padding-top: .75rem;
         padding-bottom: .75rem;
         font-size: .875rem;
         color: #6c757d;
      }

      .nav-underline .nav-link:hover {
         color: #007bff;
      }

      .nav-underline .active {
         font-weight: 500;
         color: #343a40;
      }
   </style>
   <script>
      $(document).ready(function () {
         console.log("document is ready");
         $('[data-toggle="offcanvas"], #navToggle').on('click', function () {
            $('.offcanvas-collapse').toggleClass('open')
         })
      });
      window.onload = function () {
         console.log("window is loaded");
      };
   </script>

   <script>
      let changeIcon = function (icon) {
         if (icon.classList.contains('fa-bars')) {
            // If 'fa-bars' is present, replace it with 'fa-times'
            icon.classList.remove('fa-bars');
            icon.classList.add('fa-times');
         } else {
            // If 'fa-bars' is not present, replace it with 'fa-bars'
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
         }
      }

      window.onload = function () {
         setTimeout(function () {
            $(".header_top_position_img").fadeOut('fast');
         }, 4000);
      };

   </script>
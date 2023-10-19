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

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap">
    <link rel="shortcut icon" type="image/png" href="<?= URL::to('public/uploads/settings/'.$settings->favicon); ?>" />
    
   <!-- Bootstrap CSS -->
         <link rel="stylesheet" href="<?= URL::to('public/themes/theme6/assets/css/bootstrap.min.css') ?>">

   <!-- Typography CSS -->
      <link rel="stylesheet" href="<?= URL::to('public/themes/theme6/assets/css/typography.css') ?>">

   <!-- Style -->
      <link rel="stylesheet" href="<?= URL::to('public/themes/theme6/assets/css/style.css') ?>">
      
   <!-- Responsive -->
      <link rel="stylesheet" href="<?= URL::to('public/themes/theme6/assets/css/responsive.css') ?>">

   <!-- slick -->
      <link rel="stylesheet" href="<?= URL::to('public/themes/theme6/assets/css/slick.css') ?>">

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


<body>
    <!-- loader Start -->
    <?php if( get_image_loader() == 1 ) { ?>
      <div class="fullpage-loader">
         <div class="fullpage-loader__logo">
               <img src="<?= front_end_logo() ?>" class="c-logo" alt="<?=  $settings->website_name ; ?>">
         </div>
      </div>
    <?php } ?>

    <header id="main-header">
  <div class="main-header">
      <div class="container-fluid">
          <div class="row">
              <div class="col-sm-12">
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

                      <a class="navbar-brand" href="index.html"> <img class="img-fluid logo"
                              src="<?= front_end_logo() ?>"
                              alt="" /> </a>
                      <div class="collapse navbar-collapse" id="navbarSupportedContent">
                          <div class="menu-main-menu-container">
                              <ul id="top-menu" class="navbar-nav ml-auto">
                                 
                                 <?php  foreach ($menus as $key =>  $menu) : ?> 

                                    <li class="menu-item">
                                       <a href="<?= URL::to($menu->url) ?>"> <?= $menu->name ?></a>
                                    </li>

                                 <?php endforeach ;?>
                                  
                              </ul>
                          </div>
                      </div>

                      <!-- Channel and CPP Login -->
                     <div class="d-flex p-2">
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
                                       <button type="submit" class="btn btn-hover" >Visit CPP Portal</button>
                                    </form>
                                 </div>
                           <?php }
                           
                           if (!empty($channel)) { ?>
                                 <div class="p-2" >
                                    <form method="POST" action="<?= URL::to('channel/home') ?>" >
                                       <input type="hidden" name="_token" id="token" value="<?= csrf_token() ?>">
                                       <input type="hidden" name="email" value="<?= $userEmail ?>" autocomplete="email" autofocus>
                                       <input type="hidden" name="password" value="<?= @$channel->unhased_password ?>" autocomplete="current-password">
                                       <button type="submit" class="btn btn-hover" >Visit Channel Portal</button>
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
                                    <form action="<?= URL::to("searchResult") ?>" class="searchbox" id="searchResult" >
                                    <input name="_token" type="hidden" value="<?= csrf_token(); ?>" />
                                       <div class="form-group position-relative">
                                          <input type="text" class="text search-input font-size-12 searches"
                                             placeholder="type here to search...">
                                          <i class="search-link ri-search-line"></i>
                                          <?php  include 'public/themes/theme6/partials/Search_content.php'; ?>
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
                                                      <img src="https://localhost/flicknexs/public/themes/theme6/assets/images/notify/thumb-1.jpg"
                                                          class="img-fluid mr-3" alt="" />
                                                      <div class="media-body">
                                                          <h6 class="mb-0 ">Boot Bitty</h6>
                                                          <small class="font-size-12"> just now</small>
                                                      </div>
                                                  </div>
                                              </a>
                                              <a href="#" class="iq-sub-card">
                                                  <div class="media align-items-center">
                                                      <img src="https://localhost/flicknexs/public/themes/theme6/assets/images/notify/thumb-2.jpg"
                                                          class="img-fluid mr-3" alt="" />
                                                      <div class="media-body">
                                                          <h6 class="mb-0 ">The Last Breath</h6>
                                                          <small class="font-size-12">15 minutes ago</small>
                                                      </div>
                                                  </div>
                                              </a>
                                              <a href="#" class="iq-sub-card">
                                                  <div class="media align-items-center">
                                                      <img src="https://localhost/flicknexs/public/themes/theme6/assets/images/notify/thumb-3.jpg"
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
                                              <img src="<?= !Auth::guest() && Auth::user()->avatar ? URL::to('public/uploads/avatars/'.Auth::user()->avatar ) : URL::to('/public/themes/theme6/assets/images/user/user.jpg') ?>"
                                                class="img-fluid avatar-40 rounded-circle" alt="user">
                                       </a>

                                  <?php endif; ?>

                                  <div class="iq-sub-dropdown iq-user-dropdown">
                                      <div class="iq-card shadow-none m-0">

                                       <?php if( Auth::guest() ) : ?>

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

                                          <?php elseif( !Auth::guest() && Auth::user()->role == "admin"): ?>

                                          <div class="iq-card-body p-0 pl-3 pr-3">
                                             <a href="<?= URL::to('myprofile') ?>" class="iq-sub-card setting-dropdown">
                                                <div class="media align-items-center">
                                                      <div class="right-icon"><i class="ri-file-user-line text-primary"></i></div>
                                                      <div class="media-body ml-3">
                                                         <h6 class="mb-0 ">Manage Profile</h6>
                                                      </div>
                                                </div>
                                             </a>
                                             
                                             <a href="<?= URL::to('/admin/subscription-plans') ?>" class="iq-sub-card setting-dropdown">
                                                <div class="media align-items-center">
                                                      <div class="right-icon"><i class="ri-settings-4-line text-primary"></i></div>
                                                      <div class="media-body ml-3">
                                                         <h6 class="mb-0 ">Pricing Plan</h6>
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

                                          <?php elseif( !Auth::guest() && Auth::user()->role == "subs"): ?>

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

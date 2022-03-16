<!doctype html>
<html lang="en-US">
   <head>
      <?php
$uri_path = $_SERVER['REQUEST_URI']; 
$uri_parts = explode('/', $uri_path);
$request_url = end($uri_parts);
$uppercase =  ucfirst($request_url);
$channel = Session::get('channel'); 

// dd($channel);
// exit();UA-42534483-14
      ?>
      <!-- Required meta tags -->
    <meta charset="UTF-8">
    <?php $settings = App\Setting::first(); //echo $settings->website_name;?>
    <title><?php echo $uppercase.' | ' . $settings->website_name ; ?></title>
    <meta name="description" content= "<?php echo $settings->website_description ; ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <input type="hidden" value="<?php echo $settings->google_tracking_id ; ?>" name="tracking_id" id="tracking_id">
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= URL::to('/'). '/public/uploads/settings/' . $settings->favicon; ?>" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/bootstrap.min.css';?>" />
    <!-- Typography CSS -->
    <link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/typography.css';?>" />
    <!-- Style -->
    <link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/style.css';?>" />
    <!-- Responsive -->
    <link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/responsive.css';?>" />
    <link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/slick.css';?>" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
       
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
   </head>
    <style>
        #main-header{ color: #fff; }
        .svg{ color: #fff; } 
    </style>
   <body>
      <!-- loader Start -->
     <!-- <div id="loading">
         <div id="loading-center">
         </div>
      </div>-->
      <!-- loader END -->
     <!-- Header -->
      <header id="main-header">
         <div class="main-header">
            <div class="container-fluid" style="padding: 0px 40px!important;">
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
                        <a class="navbar-brand" href="#"> <img src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo; ?>" class="c-logo" alt="<?php echo $settings->website_name ; ?>"> </a>
                         
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                           <div class="menu-main-menu-container">
<!--                              <ul id="top-menu" class="navbar-nav ml-auto">
                                 <li class="menu-item">
                                    <a href="<?php echo URL::to('home') ?>">Home</a>
                                 </li>
                                 <li class="menu-item">
                                    <a href="<?php echo URL::to('home') ?>">Tv Shows</a>
                                 </li>
                                 <li class="menu-item">
                                    <a href="href="<?php echo URL::to('home') ?>"">Movies</a>
                                 </li>
                              </ul>-->
                             
                           </div>
                        </div>
                        <div class="mobile-more-menu">
                           <a href="javascript:void(0);" class="more-toggle" id="dropdownMenuButton"
                              data-toggle="more-toggle" aria-haspopup="true" aria-expanded="false">
                           <i class="ri-more-line"></i>
                           </a>
                           <div class="more-menu" aria-labelledby="dropdownMenuButton">
                              <div class="navbar-right position-relative">
                                 <ul class="d-flex align-items-center justify-content-end list-inline m-0">
                                    
                                <li class="hidden-xs">
                                          <div id="navbar-search-form">
                                            <form role="search" action="<?php echo URL::to('/').'/searchResult';?>" method="POST">
                                              <input name="_token" type="hidden" value="<?php echo csrf_token(); ?>">
                                              <div>
                                                <i class="fa fa-search">
                                                </i>
                                                <input type="text" name="search" class="searches" id="searches" autocomplete="off" placeholder="Search">
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
                        <div class="navbar-right menu-right">
                           <ul class="d-flex align-items-center list-inline m-0">
                              <li class="nav-item nav-icon">
                                 <a href="<?php echo URL::to('/').'/searchResult';?>" class="search-toggle device-search">
                                     
                                 <i class="ri-search-line"></i>
                                 </a>
                                 <div class="search-box iq-search-bar d-search">
                                    <form action="<?php echo URL::to('/').'/searchResult';?>" method="post" class="searchbox">
                                        <input name="_token" type="hidden" value="<?php echo csrf_token(); ?>">
                                       <div class="form-group position-relative">
                                          <input type="text" name="search" class="text search-input font-size-12 searches"
                                             placeholder="type here to search...">
                                          <i class="search-link ri-search-line"></i>
                                       </div>
                                    </form>
                                 </div>
                                  <div class="iq-sub-dropdown search_content overflow-auto" id="sidebar-scrollbar" >
                                       <div class="iq-card-body">
                                   <div id="search_list" class="search_list search-toggle device-search" >
                                           </div> </div></div>
                              </li>
                              <li class="nav-item nav-icon">
                                 <!--<a href="#" class="search-toggle" data-toggle="search-toggle">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22"
                                       class="noti-svg">
                                       <path fill="none" d="M0 0h24v24H0z" />
                                       <path
                                          d="M18 10a6 6 0 1 0-12 0v8h12v-8zm2 8.667l.4.533a.5.5 0 0 1-.4.8H4a.5.5 0 0 1-.4-.8l.4-.533V10a8 8 0 1 1 16 0v8.667zM9.5 21h5a2.5 2.5 0 1 1-5 0z" />
                                    </svg>
                                    <span class="bg-danger dots"></span>
                                 </a>-->
                                 <div class="iq-sub-dropdown">
                                    <div class="iq-card shadow-none m-0">
                                       <div class="iq-card-body">
                                          <a href="#" class="iq-sub-card">
                                             <div class="media align-items-center">
                                                <img src="assets/images/notify/thumb-1.jpg" class="img-fluid mr-3"
                                                   alt="streamit" />
                                                <div class="media-body">
                                                   <h6 class="mb-0 ">Boot Bitty</h6>
                                                   <small class="font-size-12"> just now</small>
                                                </div>
                                             </div>
                                          </a>
                                          <a href="#" class="iq-sub-card">
                                             <div class="media align-items-center">
                                                <img src="assets/images/notify/thumb-2.jpg" class="img-fluid mr-3"
                                                   alt="streamit" />
                                                <div class="media-body">
                                                   <h6 class="mb-0 ">The Last Breath</h6>
                                                   <small class="font-size-12">15 minutes ago</small>
                                                </div>
                                             </div>
                                          </a>
                                          <a href="#" class="iq-sub-card">
                                             <div class="media align-items-center">
                                                <img src="assets/images/notify/thumb-3.jpg" class="img-fluid mr-3"
                                                   alt="streamit" />
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
                               <?php 
                              // $channel = Session::get('channel'); 
                               if(empty($channel)): ?>
                              <li class="nav-item nav-icon">
                                    <!-- <img src="<?php echo URL::to('/').'/public/uploads/avatars/lockscreen-user.png' ?>" class="img-fluid avatar-40 rounded-circle" alt="user">-->
                                    <a href="<?php echo URL::to('/channel/login') ?>" class="iq-sub-card">
                                        <div class="media align-items-center">
                                            <div class="right-icon">
                                                <i class="ri-settings-4-line text-primary"></i>
                                            </div>
                                            <div class="media-body ml-3">
                                                <h6 class="mb-0 ">Signin</h6>
                                            </div>
                                        </div>
                                    </a>
                               </li>
                               <li class="nav-item nav-icon">
                                  <a href="<?php echo URL::to('/channel/logout') ?>" class="iq-sub-card">
                                     <div class="media align-items-center">
                                        <div class="right-icon">
                                           <i class="ri-logout-circle-line text-primary"></i>
                                        </div>
                                        <div class="media-body ml-3">
                                           <h6 class="mb-0 ">Signup</h6>
                                        </div>
                                     </div>
                                  </a>
                               </li>
                              <?php else: ?>
                                 <li class="nav-item nav-icon">
                                  <a href="<?php echo URL::to('/channel/logout') ?>" class="iq-sub-card">
                                     <div class="media align-items-center">
                                        <div class="right-icon">
                                           <i class="ri-logout-circle-line text-primary"></i>
                                        </div>
                                        <div class="media-body ml-3">
                                           <h6 class="mb-0 ">LogOut</h6>
                                        </div>
                                     </div>
                                  </a>
                               </li>
                              <?php endif; ?>
                                   
                           </ul>
                        
</div>
                     </nav>
                   
                  </div>
               </div>
            </div>
         </div>
          
          
           <script>
               $(document).ready(function() {
    $(".dropdown-toggle").dropdown();
});
          </script>
          <script>
              const toggle = document.getElementById('toggle');
const body = document.body;

toggle.addEventListener('input', (e) => {
  const isChecked = e.target.checked;
  
  if(isChecked) {
    body.classList.add('dark-theme');
  } else {
    body.classList.remove('dark-theme');
  }
});
          </script>
  <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/google_analytics_tracking_id.js';?>"></script>
      </header>
      <!-- Header End -->
     
       <!-- MainContent End-->
     
  
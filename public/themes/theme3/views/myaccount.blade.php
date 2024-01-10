<!doctype html>
<html lang="en-US">
   <head>

      <?php
$uri_path = $_SERVER['REQUEST_URI']; 
$uri_parts = explode('/', $uri_path);
$request_url = end($uri_parts);
$uppercase =  ucfirst($request_url);
// dd(Auth::User()->id);
$data = Session::all(); 

if(isset($data['user'])){
$id = $data['user']->id ;
$user = App\User::where('id',$id)->first();

}

@$translate_language = App\Setting::pluck('translate_language')->first();
\App::setLocale(@$translate_language);

 ?>
      <!-- Required meta tags -->
    <meta charset="UTF-8">
    <?php $settings = App\Setting::first(); //echo $settings->website_name;?>
    <title><?php echo $uppercase.' | ' . $settings->website_name ; ?></title>
    <meta name="description" content= "<?php echo $settings->website_description ; ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= URL::to('/'). '/public/uploads/settings/' . $settings->favicon; ?>" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/bootstrap.min.css';?>" />
    <!-- Typography CSS -->
    <link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/typography.css';?>" />
    <!-- Style -->
    <link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/style.css';?>" />
       <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Caladea:wght@400;700&family=Inter:wght@100;300&family=Poppins:wght@300&display=swap" rel="stylesheet">
    <!-- Responsive -->
    <link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/responsive.css';?>" />
    <link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/slick.css';?>" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>

   </head>
    <style>
        .btn{
            background-color: #8a0303!important;
        }
        .m-profile{
            min-height: 100vh;
        }
        .img-fluid{
            min-height: 0px!important;
        }
        #main-header{ color: #fff; }
        .svg{ color: #fff; } 
        .form-control {
    height: 45px;
    line-height: 29px!important;
    background: #33333391;
    border: 1px solid var(--iq-body-text);
    font-size: 14px;
    color: var(--iq-secondary);
    border-radius: 4px;
}
#navbarSupportedContent{
   display:none;
}
   .sign-user_card input{
      background-color: rgb(255 255 255) !important;
   }
   /* profile */
   .col-md-12.profile_image {
    display: flex;
   }
        .profile-bg{
            height: 100px;
    width: 150px!important;
        }
        .img-fluid{
            min-height: 0px!important;
        }
   img.multiuser_img {
    padding: 9%;
    border-radius: 70%;
}
        .round:hover{
            color: #000!important;
        }
.name{
    font-size: larger;
    font-family: auto;
    color: white;
    text-align: center;
}
        .bdr{
            
        }
        .round{
            padding: 10px 20px;
            padding: 10px 20px;
    border-radius: 20px!important;
    color: #fff!important;
        }
.circle {
    color: white;
    position: absolute;
    margin-top: -6%;
    margin-left: 20%;
    margin-bottom: 0;
    margin-right: 0;
}
        svg{
            height: 30px;
        }
        .usk li{
            list-style: none;
            padding: 10px 10px;
            cursor: pointer;
        }
        input[type=file]::file-selector-button {
  position: relative;
            top: -2px;
            left: -10px;
}
a{
cursor: pointer;
}

    </style>
   <body>
      <!-- loader Start -->
     <!-- <div id="loading">
         <div id="loading-center">
         </div>
      </div>-->
      <!-- loader END -->
     <!-- Header -->
     
      <header id="main-header" style="padding: 15px 0;">
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
                        <a class="navbar-brand" href="<?php echo URL::to('home') ?>"> <img src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo; ?>" class="c-logo" alt="<?php echo $settings->website_name ; ?>"> </a>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                           <div class="menu-main-menu-container">
          
                             
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
                              <li class="nav-item nav-icon">
                                 <a href="#" class="iq-user-dropdown  search-toggle p-0 d-flex align-items-center"
                                    data-toggle="search-toggle">
                                 <?php if(Auth::guest()): ?>
                                     <img src="<?php echo URL::to('/').'/public/uploads/avatars/lockscreen-user.png' ?>" class="img-fluid avatar-40 rounded-circle" alt="user">
                                      <?php else: ?>
                                 <img src="<?php echo URL::to('/').'/public/uploads/avatars/' . Auth::user()->avatar ?>" class="img-fluid avatar-40 rounded-circle" alt="user">
                                      <?php endif; ?>
                                 </a>
                                   <?php if(Auth::guest()): ?>
                                  <div class="iq-sub-dropdown iq-user-dropdown">
                                    <div class="iq-card shadow-none m-0">
                                       <div class="iq-card-body p-0 pl-3 pr-3">
                                          <a href="<?php echo URL::to('login') ?>" class="iq-sub-card setting-dropdown">
                                             <div class="media align-items-center">
                                                <div class="right-icon">
                                                   <i class="ri-settings-4-line text-primary"></i>
                                                </div>
                                                <div class="media-body ml-3">
                                                   <h6 class="mb-0 ">Signin</h6>
                                                </div>
                                             </div>
                                          </a>
                                          <a href="<?php echo URL::to('signup') ?>" class="iq-sub-card setting-dropdown">
                                             <div class="media align-items-center">
                                                <div class="right-icon">
                                                   <i class="ri-logout-circle-line text-primary"></i>
                                                </div>
                                                <div class="media-body ml-3">
                                                   <h6 class="mb-0 ">Signup</h6>
                                                </div>
                                             </div>
                                          </a>
                                       </div>
                                    </div>
                                 </div>
                                   <?php elseif(Auth::user()->role == 'registered'): ?>
                                   <div class="iq-sub-dropdown iq-user-dropdown">
                                    <div class="iq-card shadow-none m-0">
                                       <div class="iq-card-body p-0 pl-3 pr-3">
                                          <a href="<?php echo  URL::to('myprofile') ?>" class="iq-sub-card setting-dropdown">
                                             <div class="media align-items-center">
                                                <div class="right-icon">
                                                   <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" x="0" y="0" viewBox="0 0 70 70" style="enable-background:new 0 0 70 70" xml:space="preserve"><path class="st5" d="M13.4 33.7c0 .5.2.9.5 1.2.3.3.8.5 1.2.5h22.2l-4 4.1c-.4.3-.6.8-.6 1.3s.2 1 .5 1.3c.3.3.8.5 1.3.5s1-.2 1.3-.6l7.1-7.1c.7-.7.7-1.8 0-2.5l-7.1-7.1c-.7-.6-1.7-.6-2.4.1s-.7 1.7-.1 2.4l4 4.1H15.2c-1 .1-1.8.9-1.8 1.8z"/><path class="st5" d="M52.3 17.8c0-1.4-.6-2.8-1.6-3.7-1-1-2.3-1.6-3.7-1.6H27.5c-1.4 0-2.8.6-3.7 1.6-1 1-1.6 2.3-1.6 3.7v7.1c0 1 .8 1.8 1.8 1.8s1.8-.8 1.8-1.8v-7.1c0-1 .8-1.8 1.8-1.8H47c.5 0 .9.2 1.2.5.3.3.5.8.5 1.2v31.8c0 .5-.2.9-.5 1.2-.3.3-.8.5-1.2.5H27.5c-1 0-1.8-.8-1.8-1.8v-7.1c0-1-.8-1.8-1.8-1.8s-1.8.8-1.8 1.8v7.1c0 1.4.6 2.8 1.6 3.7 1 1 2.3 1.6 3.7 1.6H47c1.4 0 2.8-.6 3.7-1.6 1-1 1.6-2.3 1.6-3.7V17.8z"/></svg>
                                                </div>
                                                <div class="media-body ml-3">
                                                   <h6 class="mb-0 ">My Account</h6>
                                                </div>
                                             </div>
                                          </a>
                                          <a href="<?php echo URL::to('watchlater') ?>" class="iq-sub-card setting-dropdown">
                                             <div class="media align-items-center">
                                                <div class="right-icon">
                                                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" x="0" y="0" viewBox="0 0 70 70" style="enable-background:new 0 0 70 70" xml:space="preserve"><style>.st0{fill:#198fcf;stroke:#198fcf;stroke-width:.75;stroke-miterlimit:10}</style><path class="st0" d="M21.5 23.7h14c.2 0 .3.2.3.4v.8c0 .2-.1.4-.3.4h-14c-.2 0-.3-.2-.3-.4V24c0-.1.2-.3.3-.3zM21.5 32h13.4c.2 0 .3.2.3.4v.8c0 .2-.1.4-.3.4H21.5c-.2 0-.3-.2-.3-.4v-.8c0-.2.2-.4.3-.4zM21.5 40.3h23.1c.2 0 .3.2.3.4v.8c0 .2-.1.4-.3.4H21.5c-.2 0-.3-.2-.3-.4v-.7c0-.3.2-.5.3-.5zM21.5 48.7h23.1c.2 0 .3.2.3.4v.8c0 .2-.1.4-.3.4H21.5c-.2 0-.3-.2-.3-.4v-.8c0-.3.2-.4.3-.4z"/><path class="st1" d="M48.4 37c-5.1 0-9.2-4.1-9.2-9.2s4.1-9.2 9.2-9.2 9.2 4.1 9.2 9.2-4.1 9.2-9.2 9.2zm0-16.7c-4.2 0-7.5 3.3-7.5 7.5s3.3 7.5 7.5 7.5 7.5-3.3 7.5-7.5-3.3-7.5-7.5-7.5z" style="fill:#198fcf;stroke:#198fcf;stroke-width:.5;stroke-miterlimit:10"/><path class="st2" d="M52.1 28.7h-3.8c-.4 0-.7-.3-.7-.7v-3.8c0-.2.2-.4.4-.4h.8c.2 0 .4.2.4.4v2.2c0 .4.3.7.7.7h2.2c.2 0 .4.2.4.4v.8c.1.2-.1.4-.4.4z" style="fill:#198fcf"/><path class="st3" d="M54.3 34v20.1c0 1-.8 1.9-1.9 1.9H17.3c-1 0-1.9-.8-1.9-1.9V17.5c0-1 .8-1.9 1.9-1.9h35.1c1 0 1.9.8 1.9 1.9v4.2" style="fill:none;stroke:#198fcf;stroke-width:2;stroke-miterlimit:10"/></svg>
                                                </div>
                                                <div class="media-body ml-3">
                                                   <h6 class="mb-0 ">Watch list</h6>
                                                </div>
                                             </div>
                                          </a>

                                          {{-- <a href="<?php echo URL::to('showPayperview') ?>" class="iq-sub-card setting-dropdown">
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
                                                   <h6 class="mb-0 ">Rented Movies</h6>
                                                </div>
                                             </div>
                                          </a> --}}

                                          <a href="<?php echo URL::to('logout') ?>" class="iq-sub-card setting-dropdown">
                                             <div class="media align-items-center">
                                                <div class="right-icon">
                                                  <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" x="0" y="0" viewBox="0 0 70 70" style="enable-background:new 0 0 70 70" xml:space="preserve"><path class="st6" d="M53.4 33.7H30.7M36.4 28.1l-5.7 5.7 5.7 5.7"></path><path class="st6" d="M50.5 43.7c-2.1 3.4-5.3 5.9-9.1 7.3-3.7 1.4-7.8 1.6-11.7.4a18.4 18.4 0 0 1-9.6-28.8c2.4-3.2 5.8-5.5 9.6-6.6 3.8-1.1 7.9-1 11.7.4 3.7 1.4 6.9 4 9.1 7.3"></path></svg>
                                                </div>
                                                <div class="media-body ml-3">
                                                   <h6 class="mb-0 ">Logout</h6>
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
                                          <a href="<?php echo  URL::to('myprofile') ?>" class="iq-sub-card  setting-dropdown">
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
                                                   <h6 class="mb-0 ">My Account</h6>
                                                </div>
                                             </div>
                                          </a>
                                          <a href="<?php echo URL::to('watchlater') ?>" class="iq-sub-card setting-dropdown">
                                             <div class="media align-items-center">
                                                <div class="right-icon">
                                                   <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" x="0" y="0" viewBox="0 0 70 70" style="enable-background:new 0 0 70 70" xml:space="preserve"><style>.st0{fill:#198fcf;stroke:#198fcf;stroke-width:.75;stroke-miterlimit:10}</style><path class="st0" d="M21.5 23.7h14c.2 0 .3.2.3.4v.8c0 .2-.1.4-.3.4h-14c-.2 0-.3-.2-.3-.4V24c0-.1.2-.3.3-.3zM21.5 32h13.4c.2 0 .3.2.3.4v.8c0 .2-.1.4-.3.4H21.5c-.2 0-.3-.2-.3-.4v-.8c0-.2.2-.4.3-.4zM21.5 40.3h23.1c.2 0 .3.2.3.4v.8c0 .2-.1.4-.3.4H21.5c-.2 0-.3-.2-.3-.4v-.7c0-.3.2-.5.3-.5zM21.5 48.7h23.1c.2 0 .3.2.3.4v.8c0 .2-.1.4-.3.4H21.5c-.2 0-.3-.2-.3-.4v-.8c0-.3.2-.4.3-.4z"/><path class="st1" d="M48.4 37c-5.1 0-9.2-4.1-9.2-9.2s4.1-9.2 9.2-9.2 9.2 4.1 9.2 9.2-4.1 9.2-9.2 9.2zm0-16.7c-4.2 0-7.5 3.3-7.5 7.5s3.3 7.5 7.5 7.5 7.5-3.3 7.5-7.5-3.3-7.5-7.5-7.5z" style="fill:#198fcf;stroke:#198fcf;stroke-width:.5;stroke-miterlimit:10"/><path class="st2" d="M52.1 28.7h-3.8c-.4 0-.7-.3-.7-.7v-3.8c0-.2.2-.4.4-.4h.8c.2 0 .4.2.4.4v2.2c0 .4.3.7.7.7h2.2c.2 0 .4.2.4.4v.8c.1.2-.1.4-.4.4z" style="fill:#198fcf"/><path class="st3" d="M54.3 34v20.1c0 1-.8 1.9-1.9 1.9H17.3c-1 0-1.9-.8-1.9-1.9V17.5c0-1 .8-1.9 1.9-1.9h35.1c1 0 1.9.8 1.9 1.9v4.2" style="fill:none;stroke:#198fcf;stroke-width:2;stroke-miterlimit:10"/></svg>
                                                </div>
                                                <div class="media-body ml-3">
                                                   <h6 class="mb-0 ">Watch list</h6>
                                                </div>
                                             </div>
                                          </a>

                                          {{-- <a href="<?php echo URL::to('showPayperview') ?>" class="iq-sub-card setting-dropdown">
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
                                                   <h6 class="mb-0 ">Rented Movies</h6>
                                                </div>
                                             </div>
                                          </a> --}}

                                          <?php if(Auth::User()->role == "admin"){ ?>

                                          {{-- <a href="<?php echo URL::to('admin/plans') ?>"  class="iq-sub-card setting-dropdown">
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
                                                   <h6 class="mb-0 ">Pricing Plan</h6>
                                                </div>
                                             </div>
                                          </a> --}}
                                        
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
                                                   <h6 class="mb-0 ">Admin</h6>
                                                </div>
                                             </div>
                                          </a>
                                          <?php } ?>
                                          <a href="<?php echo URL::to('logout') ?>" class="iq-sub-card setting-dropdown">
                                             <div class="media align-items-center">
                                                <div class="right-icon">
                                                 <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" x="0" y="0" viewBox="0 0 70 70" style="enable-background:new 0 0 70 70" xml:space="preserve"><path class="st6" d="M53.4 33.7H30.7M36.4 28.1l-5.7 5.7 5.7 5.7"/><path class="st6" d="M50.5 43.7c-2.1 3.4-5.3 5.9-9.1 7.3-3.7 1.4-7.8 1.6-11.7.4a18.4 18.4 0 0 1-9.6-28.8c2.4-3.2 5.8-5.5 9.6-6.6 3.8-1.1 7.9-1 11.7.4 3.7 1.4 6.9 4 9.1 7.3"/></svg>
                                                </div>
                                                <div class="media-body ml-3">
                                                   <h6 class="mb-0 ">Logout</h6>
                                                </div>
                                             </div>
                                          </a>
                                       </div>
                                    </div>
                                 </div>
                                  <?php endif; ?>
                              </li>
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
          
      </header>
<head>
    <?php 
    $jsonString = file_get_contents(base_path('assets/country_code.json'));   
    $jsondata = json_decode($jsonString, true); 
   //  dd($jsondata);
?>

	


<div class="main-content">
				
    <div class="row">
		
        <!-- TOP Nav Bar -->
      <div class="iq-top-navbar">
         <div class="iq-navbar-custom">
            <nav style="display:none;"  class="navbar navbar-expand-lg navbar-light p-0">
               <div class="iq-menu-bt d-flex align-items-center">
                  <div class="wrapper-menu">
                     <div class="main-circle"><i class="las la-bars"></i></div>
                  </div>
                  <div class="iq-navbar-logo d-flex justify-content-between">
                     <a href="<?php echo URL::to('home') ?>" class="header-logo">
                        <div class="logo-title">
                           <span class="text-primary text-uppercase"><?php $settings = App\Setting::first(); echo $settings->website_name ; ?></span>
                        </div>
                     </a>
                  </div>
               </div>
                
               <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"  aria-label="Toggle navigation">
                  <i class="ri-menu-3-line"></i>
               </button>
               <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav ml-auto navbar-list">
                      <li class="nav-item nav-icon">
                      <a type="button" class="btn btn-primary  noborder-radius btn-login nomargin visitbtn" href="<?php echo URL::to('home') ?>" ><span>Visit site</span></a>
                      </li>
                     <li class="line-height pt-3">
                        <a href="#" class="search-toggle iq-waves-effect d-flex align-items-center">
                           <img src="<?php echo URL::to('/').'/public/uploads/avatars/' . Auth::user()->avatar ?>" class="img-fluid avatar-40 rounded-circle" alt="user">
                        </a>
                        <div class="iq-sub-dropdown iq-user-dropdown">
                           <div class="iq-card shadow-none m-0">
                              <div class="iq-card-body p-0 ">
                                 <div class="bg-primary p-3">
                                    <h5 class="mb-0 text-white line-height">Hello Barry Tech</h5>
                                    <span class="text-white font-size-12">Available</span>
                                 </div>
                                 <a href="profile.html" class="iq-sub-card iq-bg-primary-hover">
                                    <div class="media align-items-center">
                                       <div class="rounded iq-card-icon iq-bg-primary">
                                          <i class="ri-file-user-line"></i>
                                       </div>
                                       <div class="media-body ml-3">
                                          <h6 class="mb-0 ">My Profile</h6>
                                          <p class="mb-0 font-size-12">View personal profile details.</p>
                                       </div>
                                    </div>
                                 </a>
                                 <a href="profile-edit.html" class="iq-sub-card iq-bg-primary-hover">
                                    <div class="media align-items-center">
                                       <div class="rounded iq-card-icon iq-bg-primary">
                                          <i class="ri-profile-line"></i>
                                       </div>
                                       <div class="media-body ml-3">
                                          <h6 class="mb-0 ">Edit Profile</h6>
                                          <p class="mb-0 font-size-12">Modify your personal details.</p>
                                       </div>
                                    </div>
                                 </a>
                                 <a href="account-setting.html" class="iq-sub-card iq-bg-primary-hover">
                                    <div class="media align-items-center">
                                       <div class="rounded iq-card-icon iq-bg-primary">
                                          <i class="ri-account-box-line"></i>
                                       </div>
                                       <div class="media-body ml-3">
                                          <h6 class="mb-0 ">Account settings</h6>
                                          <p class="mb-0 font-size-12">Manage your account parameters.</p>
                                       </div>
                                    </div>
                                 </a>
                                 <a href="privacy-setting.html" class="iq-sub-card iq-bg-primary-hover">
                                    <div class="media align-items-center">
                                       <div class="rounded iq-card-icon iq-bg-primary">
                                          <i class="ri-lock-line"></i>
                                       </div>
                                       <div class="media-body ml-3">
                                          <h6 class="mb-0 ">Privacy Settings</h6>
                                          <p class="mb-0 font-size-12">Control your privacy parameters.</p>
                                       </div>
                                    </div>
                                 </a>
                                 <div class="d-inline-block w-100 text-center p-3">
                                    <a class="bg-primary iq-sign-btn" href="#" role="button">Sign out<i class="ri-login-box-line ml-2"></i></a>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </li>
                  </ul>
               </div>
            </nav>
         </div>
      </div>
      <!-- TOP Nav Bar END -->
		
		</div>
		
		<!--<hr />-->
    
        <!-- MainContent -->
    <section class="m-profile  setting-wrapper pt-0 p-3">        
        <div class="container">
         <!--   <div class="sign-user_card">-->
                <div class="row justify-content-center">
                          

                  <div class="col-md-4">
                     {{-- message --}}

                     @if (Session::has('message'))
                        <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
                  @endif
                        <h2 class="text-center">{{ __('My Account') }}</h2>
                       
                         <div class="row mt-5 align-items-center justify-content-between">
                              <div class="col-md-8">
                                 <span class="text-light font-size-13">{{ __('Email') }}</span>
                                 <div class="p-0">
                                    <span class="text-light font-size-13"> {{ $user->email ? $user->email : " "   }}</span></div>
                              </div>
                              <!-- <div class="col-md-4 text-right">
                                    <a type="button" class="text-white font-size-13" data-toggle="collapse" data-target="#update_userEmails">Change</a>
                              </div> -->
                           </div>

                           <form id="update_userEmail" accept-charset="UTF-8" action="{{ URL::to('/profile/update_userEmail') }}" method="post">
                              @csrf

                              <input type="hidden" name="users_id" value="{{ $user->id }}" />
                              <span id="update_userEmails" class="collapse">
                                       <div class="row mt-3">
                                          <div class="col-md-8">
                                                <input type="text"  name="user_email" class="form-control">
                                          </div>
                                       <div class="col-md-4">
                                             <a type="button" class="btn round update_userEmail">{{ __('Update') }}</a></div>
                                       </div>
                              </span>
                           </form>


                        <hr style="border:0.5px solid #fff;">
                        <div class="row align-items-center">
                            <div class="col-md-5 mt-3">
                                <span class="text-light font-size-13">{{ __('Password') }}</span>
                                <div class="p-0 mt-2">
                                       <span class="text-light font-size-13">*********</span>
                                </div>
                           </div>
                            <div class="col-md-7 mt-2 text-right" style="font-size:14px;">
                                <a href="{{ URL::to('/password/reset') }}" class="f-link text-white font-size-13">{{ __('Send Reset Password Email') }}</a>
                            </div>
                            </div>
                          <hr style="border:0.5px solid #fff;">
                           <div class="row align-items-center">
                              <div class="col-md-8">
                                 <span class="text-light font-size-13">{{ __('Display Name') }}</span>
                                 <div class="p-0">
                                    <span class="text-light font-size-13"><?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?></span></div>
                              </div>
                              <div class="col-md-4 text-right">
                                    <a type="button" class="text-white font-size-13" data-toggle="collapse" data-target="#demo">{{ __('Change') }}</a>
                                 
                              </div>
                           </div>
                           <form id="update_username" accept-charset="UTF-8" action="{{ URL::to('/profile/update_username') }}" method="post">
                              @csrf

                              <input type="hidden" name="users_id" value="{{ $user->id }}" />
                              <span id="demo" class="collapse">
                                       <div class="row mt-3">
                                          <div class="col-md-8">
                                                <input type="text"  name="user_name" class="form-control">
                                          </div>
                                       <div class="col-md-4">
                                             <a type="button" class="btn round update_username">{{ __('Update') }}</a></div>
                                       </div>
                              </span>
                           </form>

                           {{-- Display Image --}}
                           <hr style="border:0.5px solid #fff;">

                           <div class="row align-items-center">
                              <div class="col-md-8">
                                 <span class="text-light font-size-13">{{ __('Display Image') }}</span>
                                 <div class="p-0">
                                    <span class="text-light font-size-13">
                                       <img src="{{ !is_null($user->avatar) ? URL::to('public/uploads/avatars/'.$user->avatar) : URL::to('public/uploads/avatars/theme4_profile_image.png')   }}" height="50px" width="50px" />
                                    </span>
                                 </div>
                              </div>
                              <div class="col-md-4 text-right">
                                    <a type="button" class="text-white font-size-13" data-toggle="collapse" data-target="#user_img">{{ __('Change') }}</a>
                              </div>
                           </div>

                           <form id="update_userimg" accept-charset="UTF-8" action="{{ URL::to('profile/update_userImage') }}"   enctype="multipart/form-data" method="post">
                              @csrf
                              <input type="hidden" name="users_id" value="{{ $user->id }}" />
                              <span id="user_img" class="collapse">
                                       <div class="row mt-3">
                                          <div class="col-md-8">
                                                <input type="file" multiple="true" class="form-control" name="avatar" id="avatar" required/>
                                          </div>
                                       <div class="col-md-4">
                                             <a type="button" class="btn round update_userimg">{{ __('Update') }}</a></div>
                                       </div>
                              </span>
                           </form>

                           {{-- TV Code --}}
                           <hr style="border:0.5px solid #fff;">

                           <div class="row align-items-center">
                              <div class="col-md-8">
                                 <span class="text-light font-size-13">{{ __('Tv Activation Code') }}</span>
                              </div>
                              <div class="col-md-4 text-right">
                                    <a type="button" class="text-white font-size-13" data-toggle="collapse" data-target="#user_tvcode">{{ __('Add') }}</a>
                              </div>
                           </div>

                           
                           <form id="tv-code" accept-charset="UTF-8" action="{{ URL::to('user/tv-code') }}"   enctype="multipart/form-data" method="post">
                              @csrf
                              <input type="hidden" name="users_id" value="{{ $user->id }}" />
                              <input type="hidden" name="email" value="{{ $user->email }}" />
                              <span id="user_tvcode" class="collapse">
                                       <div class="row mt-3">
                                          <div class="col-md-8">
                                                <input type="text" name="tv_code" id="tv_code" value="@if(!empty($UserTVLoginCode->tv_code)){{ $UserTVLoginCode->tv_code .' '. $UserTVLoginCode->uniqueId}}@endif" />
                                          </div>
                                       <div class="col-md-4">
                                       @if(!empty($UserTVLoginCode->tv_code))
                                             <a type="button" href="{{ URL::to('user/tv-code/remove/') }}/{{$UserTVLoginCode->id}}" style="background-color:#df1a10!important;" class="btn round tv-code-remove text-red">{{ __('Remove') }}</a>
                                       @else
                                       <a type="button"  class="btn round tv-code text-white">{{ __('Add') }}</a>
                                       @endif
                                          </div>
                                       </div>
                              </span>
                           </form>

                           {{-- DOB --}}
                           <hr style="border:0.5px solid #fff;">

                           <div class="row align-items-center">
                              <div class="col-md-8">
                                 <span class="text-light font-size-13">{{ __('Date of Birth') }}</span>
                              </div>
                              <div class="col-md-4 text-right">
                                    <a type="button" class="text-white font-size-13" data-toggle="collapse" data-target="#user_DOB">{{ __('Add') }}</a>
                              </div>
                           </div>

                           
                           <form id="DOB" accept-charset="UTF-8" action="{{ URL::to('user/DOB') }}"   enctype="multipart/form-data" method="post">
                              @csrf
                              <input type="hidden" name="users_id" value="{{ $user->id }}" />
                              <input type="hidden" name="email" value="{{ $user->email }}" />
                              <span id="user_DOB" class="collapse">
                                       <div class="row mt-3">
                                          <div class="col-md-8">
                                                <input type="date" id="DOB" name="DOB" value="@if(!empty($user->DOB)){{ $user->DOB }}@endif">

                                          </div>
                                       <div class="col-md-4">
                   
                                       <a type="button"  class="btn round DOB text-white">{{ __('Add') }}</a>
                                          </div>
                                       </div>
                              </span>
                           </form>


                          <hr style="border:0.5px solid #fff;">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <span class="text-light font-size-13">{{ __('Membership Settings') }}</span>

                              <div class="p-0">
                                 <span class="text-light font-size-13">
                                       {{ ucwords( __('Current Membership'). '-'.' '.$user->role) }}
                                    </span><br>

                                    @if(Auth::user()->role == "subscriber" )
                                       <span class="text-light font-size-13">
                                          @php  $subscription_ends_at = \DB::table('users')->where('id',Auth::user()->id)->pluck('subscription_ends_at')->first(); @endphp

                                          @if( !is_null($subscription_ends_at)  && !empty($subscription_ends_at) )
                                             {{   "your subscription renew on ". $subscription_ends_at  }}
                                          @endif
                                       </span>
                                    @endif
                                   
                              </div>
                              
                            </div>

                              <div class="col-md-4 text-right">
                                    @if( (Auth::user()->role == "subscriber" ) )
                                       {{--<a href=" {{ URL::to('/upgrade-subscription_plan') }} class="text-white font-size-13"> Update Payment</a> --}}
                                    @elseif( (Auth::user()->role == "admin" ) )

                                    @else
                                       <a href="<?=URL::to('/becomesubscriber');?>"  class="text-white font-size-13"> {{ __('Subscriber Payment') }}</a>
                                    @endif
                              </div>
                        </div>
                         <hr style="border:0.5px solid #fff;">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <a  href="{{ URL::to('logout') }}" type="button" class="btn round">{{ __('Logout') }}</a>
                            </div>

                            @if(Auth::user()->role == "subscriber" && Auth::user()->payment_status != "Cancel")
                              <div class="col-md-6 text-right">
                                    <a  href="{{ URL::to('/cancelSubscription') }}" class="text-white font-size-13" >{{ __('Cancel Membership') }}</a>
                              </div>
                            @endif
                            
                        </div>
                        </div>
                    </div>
                </div>
          
           <!-- <div class="row ">
               
                <div class="col-lg-4 mb-3 bdr">
                    <h3>Account Setting</h3>
                    <div class="mt-5 text-white p-0">
                        <ul class="usk" style="margin-left: -45px;">
                          <!--  <li><a class="showSingle" target="1">User Settings</a></li>-->
                              <!-- <li><a class="showSingle" target="2">Transaction details</a></li>-->
                             <!--  <li><a class="showSingle" target="3">Plan details</a></li>
                            <li><a class="showSingle" target="1">Manage Profile</a></li>
                            <li><a class="showSingle" target="2">Plan details</a></li>
                            <li><a class="showSingle" target="5">Preference for videos</a></li>
                           <!-- <li><a class="showSingle" target="6">Profile</a></li>
                            <li><a class="showSingle" target="7">Recently Viewd Items</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-8 mb-3">
                    <div class="targetDiv" id="div1">
                    <div class=" d-flex justify-content-between mb-3">
                        <img class="rounded-circle img-fluid d-block  mb-3" height="100" width="100" src="<?= URL::to('/') . '/public/uploads/avatars/' . $user->avatar; ?>"  alt="profile-bg"/>
                        <h4 class="mb-3"><?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?></h4>
                       </div>
                         <div class=""> <!--style="margin-left: 66%;margin-right: 13%;padding-left: 1%;padding-bottom: 0%;"
                    <div class="" id="personal_det">
                    <div class="" >
                        <div class="d-flex align-items-baseline justify-content-between">
                        <div><h5 class="mb-2 pb-3 ">Personal Details</h5></div>
                        <div><a href="javascript:;" onclick="jQuery('#add-new').modal('show');" class="btn btn-primary text-white"><i class="fa fa-plus-circle"></i> Change</a>
                            </div></div>
                        </div>
                        <div class="a-border"></div>
                       <div class="a-border"></div>
                          <div class="row jusitfy-content-center">
                            <div class="col-md-3 mt-3">
                                <h5>Account Details</h5>
                              </div>
                            <div class="col-md-9">
                                 <div class="row align-items-center justify-content-end">
                            <div class="col-md-8 d-flex justify-content-between mt-1 mb-2">
                                <span class="text-light font-size-13">Email</span>
                                <span class="text-light font-size-13"><?php if(!empty($user->email)): ?><?= $user->email ?><?php endif; ?></span>
                            </div>   
                        </div>
                        <div class="row align-items-center justify-content-end">
                            <div class="col-md-8 d-flex justify-content-between mt-1 mb-2">
                                <span class="text-light font-size-13">Username</span>
                                <span class="text-light font-size-13"><?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?></span>
                            </div>   
                        </div>
                        <div class="row align-items-center justify-content-end">
                            <div class="col-md-8 d-flex justify-content-between mt-1 mb-2">
                                <span class="text-light font-size-13">Password</span>
                                <span class="text-light font-size-13"></span>
                            </div>
                        </div>
                        
                      
                           
                       
                              </div>
                        </div>
                          <div class="a-border"></div>
                        <div class="row">
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-9">
                                 <div class="row align-items-center justify-content-end">
                            <div class="col-md-8 d-flex justify-content-between mt-2 mb-2">
                                <span class="text-light font-size-13">Phone</span>
                                <span class="text-light font-size-13"><?php if(!empty($user->mobile)): ?><?= $user->mobile ?><?php endif; ?></span>
                            </div>
                        </div> 
                        <div class="row align-items-center justify-content-end">
                            <div class="col-md-8 d-flex justify-content-between mt-1 mb-2">
                                <span class="text-light font-size-13">DOB</span>
                                <span class="text-light font-size-13"><?php if(!empty($user->DOB)): ?><?= $user->DOB ?><?php endif; ?></span>
                                  
                            </div>
                        </div>
                      
                            </div>
                        </div>
                       
                            </div>
                              <div class="a-border"></div>
                             
                              <div class="mt-3 row align-items-center">
                                  <div class="col-md-3"> <h5 class="card-title mb-2">Update Profile</h5></div>
                                  <div class="col-md-9"> <!-- <form action="<?php if (isset($ref) ) { echo URL::to('/').'/register1?ref='.$ref.'&coupon='.$coupon; } else { echo URL::to('/').'/register1'; } ?>" method="POST" id="stripe_plan" class="stripe_plan" name="member_signup" enctype="multipart/form-data"> 
                        <form action="{{ URL::to('admin/profileupdate') }}" method="POST"  enctype="multipart/form-data">
                        @csrf
                            <div class="row align-items-center">
                                <div class="col-sm-6">
                                    <input type="hidden" name="user_id" value="<?= $user->id ?>" />
                        <input type="file" multiple="true" class="form-control editbtn mt-3" name="avatar" id="avatar" />
                        <!--   <input type="submit" value="<?=__('Update Profile');?>" class="btn btn-primary  noborder-radius btn-login nomargin editbtn" /> 
                                </div>
                                <div class="col-sm-6">
                                     <button type="submit" value="Verify Profile" id="submit" class="btn btn-primary btn-login verify-profile " style="display: none;"> Verify Profile</button>
                        <button class="btn btn-primary noborder-radius btn-login nomargin editbtn " type="submit" name="create-account" value="<?=__('Update Profile');?>">{{ __('Update Profile') }}</button>     
                                </div>
                            </div>
						                    
                        </form>	</div>
                                  <div class="col-md-3"></div></div>
                       
                       	
                    </div>
                        <!-- Add New Modal -->
	<div class="modal fade" id="add-new">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<div class="modal-header">
                    <h4 class="modal-title text-black">Update Profile</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					
				</div>
				
				<div class="modal-body">
					<form id="new-cat-form" accept-charset="UTF-8" action="{{ URL::to('/profile/update') }}" method="post">
						<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
						<input type="hidden" name="user_id" value="<?= $user->id ?>" />
                                
						    <div class="form-group">
		                        <label> Username:</label>
		                        <input type="text" id="username" name="username" value="<?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?>" class="form-control" placeholder="username">
                            </div>
                        
                            <div class="form-group">
		                        <label> Email:</label>
		                        <input type="email" id="email" name="email" value="<?php if(!empty($user->email)): ?><?= $user->email ?><?php endif; ?>" class="form-control" placeholder="Email">
                            </div> 
                        
                        
                            <div class="form-group">
		                        <label>Password:</label><br>
		                        <input type="password"  name="password"   placeholder="Password"  class="form-control"  >
		                    </div> 
                        
                           {{--                         
                              <div class="form-group">
                                 <label> Phone:</label>
                                 <input type="number" id="mobile" name="mobile" value="<?php if(!empty($user->mobile)): ?><?= $user->mobile ?><?php endif; ?>" class="form-control" placeholder="Mobile Number">
                              </div>
                             --}}

                            <div class="form-group">
                              <label> DOB:</label>
                               <input type="date" id="DOB" name="DOB" class="form-control"   value="<?php if(!empty($user->DOB)): ?><?= $user->DOB ?><?php endif; ?>">
                            </div>

				    </form>
				</div>
				
				<div class="modal-footer">
					{{-- <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button> --}}
					<button type="button" class="btn btn-primary" id="submit-new-cat">Save changes</button>
				</div>
			</div>
		</div>
	</div>
                        </div>

             
                    <div class="col-sm-12 mt-4 text-center targetDiv" id="div2">
                     <?php $data = Session::all(); if($user->provider != 'facebook' || $user->provider != 'google'){ ?> 
                        <div class="d-flex justify-content-center">  <img class="rounded-circle img-fluid d-block  mb-3" height="100" width="100" src="<?= URL::to('/') . '/public/uploads/avatars/' . $user->avatar; ?>"  alt="profile-bg"/></div>
                        <?php }else{ ?> 
                        <div class="d-flex justify-content-center">  <img class="rounded-circle img-fluid d-block  mb-3" height="100" width="100" src="<?= $user->provider_avatar; ?>"  alt="profile-bg"/></div>
                           <?php } ?>
                        <h4 class="mb-3"><?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?></h4>
                          <h4 class="mb-3"><?php if(!empty($user->role)): ?><?= $user->role ?><?php endif; ?> as on <?php if(!empty($user->created_at)): ?><?= $user->created_at ?><?php endif; ?></h4>
                          <h4 class="mb-3"></h4>
                        
          <div class="text-center">
                       <?php  if($user_role == 'registered'){ ?>
                              <h6><?php echo 'Registered'." " .'(Free)'; ?> Subscription</h6>                                       
                              <h6></h6>                                       
                           <?php }elseif($user_role == 'subscriber'){ ?>
                              <h6><?php echo $role_plan." " .'(Paid User)'; ?></h6>
                              <br>       
                           <h5 class="card-title mb-0">Available Specification :</h5><br>
                           <h6> Video Quality : <p> <?php if($plans != null || !empty($plans)) {  echo $plans->video_quality ; } else { ' ';} ?></p></h6>  
                           <h6> Video Resolution : <p> <?php if($plans != null || !empty($plans)) {  echo $plans->resolution ; } else { ' ';} ?>  </p></h6>                               
                           <h6> Available Devices : <p> <?php if($plans != null || !empty($plans) ) {  echo $devices_name ; } else { ' ';} ?> </p></h6>                                                                                                                   
                              <!--<h6>Subscription</h6>-->
                           <?php } ?>
                           </div>
                             
                             <!-- -->
                    <div class="row align-items-center justify-content-center mb-3 mt-3">
                         <div class=" text-center colsm-4 ">
                <a href="<?=URL::to('/transactiondetails');?>" class="btn btn-primary btn-login nomargin noborder-radius" >View Transaction Details</a>
            </div>
                            
                            <div class="col-sm-4 text-center">
                               <?php if(Auth::user()->role == "subscriber"){ ?>
                                <a href="<?=URL::to('/upgrade-subscription_plan');?>" class="btn btn-primary editbtn" >Upgrade Plan </a>        
                                <?php }else{ ?>
                        <a href="<?=URL::to('/becomesubscriber');?>" class="btn btn-primary btn-login nomargin noborder-radius" > Become Subscriber</a>
                        <?php } ?>
                            </div>
                        </div>
        </div>
                    
                    <div class="targetDiv" id="div3">
                        <div class="row align-items-center justify-content-between mb-3 mt-3">
                            <div class="col-sm-4">
                       <?php  if($user_role == 'registered'){ ?>
                              <h6><?php echo 'Registered'." " .'(Free)'; ?></h6>                                       
                              <h6>Subscription</h6>                                       
                           <?php }elseif($user_role == 'subscriber'){ ?>
                              <h6><?php echo $role_plan." " .'(Paid User)'; ?></h6>
                              <br>       
                           <h5 class="card-title mb-0">Available Specification :</h5><br>
                           <h6> Video Quality : <p> <?php if($plans != null || !empty($plans)) {  echo $plans->video_quality ; } else { ' ';} ?></p></h6>  
                           <h6> Video Resolution : <p> <?php if($plans != null || !empty($plans)) {  echo $plans->resolution ; } else { ' ';} ?>  </p></h6>                               
                           <h6> Available Devices : <p> <?php if($plans != null || !empty($plans) ) {  echo $devices_name ; } else { ' ';} ?> </p></h6>                                                                                                                   
                              <!--<h6>Subscription</h6>-->
                           <?php } ?>
                           </div>
                            <div class="col-sm-6">
                               <?php if(Auth::user()->role == "subscriber"){ ?>
                                <a href="<?=URL::to('/upgrade-subscription_plan');?>" class="btn btn-primary editbtn" >Upgrade Plan </a>        
                                <?php }else{ ?>
                        <a href="<?=URL::to('/becomesubscriber');?>" class="btn btn-primary btn-login nomargin noborder-radius" > Become Subscriber</a>
                        <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="targetDiv" id="div4">
                     <div class="mb-3" id="updatepic">
                   
                </div>
                    </div>
                    <div class="targetDiv mt-5" id="div5">
                        <div class=" mb-3">
                      <h4 class="card-title mb-0">Preference for videos</h4>
                      <form action="{{ URL::to('admin/profilePreference') }}" method="POST"  >
                      @csrf
                      <input type="hidden" name="user_id" value="<?= $user->id ?>" />
   
                      <div class="col-sm-9 form-group p-0 mt-3">
                        <label><h5>Preference Language</h5></label>
                        <select id="" name="preference_language[]" class="js-example-basic-multiple myselect" style="width: 100%;" multiple="multiple">
                            @foreach($preference_languages as $preference_language)
                                <option value="{{ $preference_language->id }}" >{{$preference_language->name}}</option>
                            @endforeach
                        </select>
                     </div>
   
                     <div class="col-sm-9 form-group p-0 mt-3">
                        <label><h5>Preference Genres</h5></label>
                        <select id="" name="preference_genres[]" class="js-example-basic-multiple myselect" style="width: 100%;" multiple="multiple">
                            @foreach($videocategory as $preference_genres)
                                <option value="{{ $preference_genres->id }}" >{{$preference_genres->name}}</option>
                            @endforeach
                        </select>
                     </div>
   
                      <button class="btn btn-primary noborder-radius btn-login nomargin editbtn mt-2" type="submit" name="create-account" value="<?=__('Update Profile');?>">{{ __('Update Profile') }}</button>                   
                      </form>		
                  </div>
                    </div>
                    <div class="targetDiv" id="div6"><div class=" mb-3">
               <h4 class="card-title mb-0 manage"> My Account</h4>
                  <div class="col-md-12 profile_image">
                      @forelse  ($profile_details as $profile)
                        <div class="">
                                 <img src="{{URL::asset('public/multiprofile/').'/'.$profile->Profile_Image}}" alt="user" class="multiuser_img" style="width:120px">
                                
                                 <h2 class="name">{{ $profile ? $profile->user_name : ''  }}</h2>
                             <div class="circle">
                                    <a  href="{{ URL::to('profileDetails_edit', $profile->id)}}">
                                           <i class="fa fa-pencil"></i> </a>
                                    @if($Multiuser == null)
                                     <a  href="{{ URL::to('profile_delete', $profile->id)}}" onclick="return confirm('Are you sure to delete this Profile?')" >
                                       <i class="fa fa-trash"></i> </a> 
                                    @endif
                                 </div>
                        </div>
                      @empty
                        <div class="col-sm-6">  <p class="name">No Profile</p>  </div>
                      @endforelse
                  </div>    
              </div> </div>
                    <div class="targetDiv" id="div7">
                        <div class="iq-card" id="recentviews" style="background-color:#191919;">
                     <div class="iq-card-header d-flex justify-content-between" >
                        <div class="iq-header-title">
                           <h4 class="card-title">Recently Viewd Items</h4>
                        </div>
                        
                     </div>
                      <div class="iq-card-body">
                        <div class="table-responsive " >
                           <table class="data-tables table movie_table recent_table" style="width:100%">
                              <thead>
                                 <tr>
                                    <th style="width:20%;">Video</th>
                                    <th style="width:10%;">Rating</th>
                                    <th style="width:20%;">Category</th>
                                    <th style="width:10%;">Views</th>
                                   <!-- <th style="width:10%;">User</th>-->
                                     <th style="width:20%;">Date</th> 
                                    <th style="width:10%;"><i class="lar la-heart"></i></th>
                                 </tr>
                              </thead>
                              <tbody>
                              @foreach($recent_videos as $video)
                              @foreach($video as $val)
                                 <tr>
                                    <td>
                                       <div class="media align-items-center">
                                          <div class="iq-movie">
                                          <a href="javascript:void(0);"><img
                                                   src="{{ URL::to('/') . '/public/uploads/images/' . $val->image }}"
                                                   class="img-border-radius avatar-40 img-fluid" alt=""></a>  </div>
                                          <div class="media-body text-white text-left ml-3">
                                             <p class="mb-0"></p>
                                             <small> </small>
                                          </div>
                                       </div>
                                    </td>
                                    <td>{{ $val->rating }}<i class="lar la-star mr-2"></i></td>
                                    <td>@if(isset($val->categories->name)) {{ $val->categories->name }} @endif</td>
                                    <td>{{ $val->views }}</td> 
                                  
                                     <td>{{ $val->created_at }}</td> 
                                    <td><i class="las la-heart text-primary"></i></td>
                                 </tr>
                                 @endforeach                                                                     
                                 @endforeach                                                                     
                              </tbody>
                           </table>
                        </div>
                     </div>
                    </div>
                </div>
<style>
  /* .form-control {
    position: relative;
    font-size: 16px;
    width: 100%;
    height: 45px;
    border-radius: 4px;
   }*/
</style>
                

<!--
                        <div class="row align-items-center justify-content-between">
                            <div class="col-md-8">
                                <span class="text-light font-size-13">Language</span>
                                <p class="mb-0">English</p>
                            </div>
                        </div>
                        <h5 class="mb-3 mt-4 pb-3 a-border">Billing Details</h5>
                        <div class="row justify-content-between mb-3">
                            <div class="col-md-8 r-mb-15">
                                <p>Your next billing date is 19 September 2020.</p>
                                <a href="#" class="btn btn-hover">Cancel Membership</a>
                            </div>
                            <div class="col-md-4 text-md-right text-left">
                                <a href="#" class="text-primary">Update Payment info</a>
                            </div>
                        </div>
                        <h5 class="mb-3 mt-4 pb-3 a-border">Plan Details</h5>
                        <div class="row justify-content-between mb-3">
                            <div class="col-md-8">
                                <p>Premium</p>                                
                            </div>
                            <div class="col-md-4 text-md-right text-left">
                                <a href="pricing-plan.html" class="text-primary">Change Plan</a>
                            </div>
                        </div>
-->
<!--
                        <h5 class="mb-3 pb-3 mt-4 a-border">Setting</h5>
                        <div class="row">
                            <div class="col-12 setting">
                                <a href="#" class="text-body d-block mb-1">Recent device streaming activity</a>
                                <a href="#" class="text-body d-block mb-1">Sign out of all devices </a>
                                <a href="#" class="text-body d-block">Download your person information</a>
                            </div>                            
                        </div>

                    </div>
                </div>
            </div>
            <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-3">
                    <div class="sign-user_card" style="height: 400px;">
                        <h4 class="card-title mb-0">Plan Details</h4>
                        <div class="row align-items-center justify-content-between mb-3 mt-3">
                            <div class="col-sm-4">
                       <?php  if($user_role == 'registered'){ ?>
                              <h6><?php echo 'Registered'." " .'(Free)'; ?></h6>                                       
                              <h6>Subscription</h6>                                       
                           <?php }elseif($user_role == 'subscriber'){ ?>
                              <h6><?php echo $role_plan." " .'(Paid User)'; ?></h6>
                              <br>       
                           <h5 class="card-title mb-0">Available Specification :</h5><br>
                           <h6> Video Quality : <p> <?php if($plans != null ) {  $plans->video_quality ; } else { ' ';} ?></p></h6>  
                           <h6> Video Resolution : <p> <?php if($plans != null ) {  $plans->resolution ; } else { ' ';} ?>  </p></h6>                               
                           <h6> Available Devices : <p> <?php if($plans != null ) {  $plans->devices_name ; } else { ' ';} ?> </p></h6>                                                                                                                   
                              <!--<h6>Subscription</h6>
                           <?php } ?>
                           </div>
                            <div class="col-sm-6">
                               <?php if(Auth::user()->role == "subscriber"){ ?>
                                <a href="<?=URL::to('/upgrade-subscription_plan');?>" class="btn btn-primary editbtn" >Upgrade Plan </a>        
                                <?php }else{ ?>
                        <a href="<?=URL::to('/becomesubscriber');?>" class="btn btn-primary btn-login nomargin noborder-radius text-white" > Become Subscriber</a>
                        <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-3" id="updatepic">
                    <div class="sign-user_card mb-3">
                        <h4 class="card-title mb-2">Manage Profile</h4>
                        <!-- <form action="<?php if (isset($ref) ) { echo URL::to('/').'/register1?ref='.$ref.'&coupon='.$coupon; } else { echo URL::to('/').'/register1'; } ?>" method="POST" id="stripe_plan" class="stripe_plan" name="member_signup" enctype="multipart/form-data"> 
                        <form action="{{ URL::to('/profileupdate') }}" method="POST"  enctype="multipart/form-data">
                        @csrf
						      <input type="hidden" name="user_id" value="<?= $user->id ?>" />
                        <input type="file" multiple="true" class="form-control editbtn" name="avatar" id="avatar" />
                        <!--   <input type="submit" value="<?=__('Update Profile');?>" class="btn btn-primary  noborder-radius btn-login nomargin editbtn" />  <button type="submit" value="Verify Profile" id="submit" class="btn btn-primary btn-login verify-profile " style="display: none;"> Verify Profile</button>
                        <button class="btn btn-primary noborder-radius btn-login nomargin editbtn mt-2" type="submit" name="create-account" value="<?=__('Update Profile');?>">{{ __('Update Profile') }}</button>                   
                        </form>		
                    </div>
                </div>

      <!-- {{-- Preference for videos --}} 
                <div class="col-lg-6 mb-3" id="">
                  <div class="sign-user_card mb-3">
                      <h4 class="card-title mb-0">Preference for videos</h4>
                      <form action="{{ URL::to('admin/profilePreference') }}" method="POST"  >
                      @csrf
                      <input type="hidden" name="user_id" value="<?= $user->id ?>" />
   
                      <div class="col-sm-9 form-group p-0 mt-3">
                        <label><h5>Preference Language</h5></label>
                        <select id="" name="preference_language[]" class="js-example-basic-multiple myselect" style="width: 100%;" multiple="multiple">
                            @foreach($preference_languages as $preference_language)
                                <option value="{{ $preference_language->id }}" >{{$preference_language->name}}</option>
                            @endforeach
                        </select>
                     </div>
   
                     <div class="col-sm-9 form-group p-0 mt-3">
                        <label><h5>Preference Genres</h5></label>
                        <select id="" name="preference_genres[]" class="js-example-basic-multiple myselect" style="width: 100%;" multiple="multiple">
                            @foreach($videocategory as $preference_genres)
                                <option value="{{ $preference_genres->id }}" >{{$preference_genres->name}}</option>
                            @endforeach
                        </select>
                     </div>
   
                      <button class="btn btn-primary noborder-radius btn-login nomargin editbtn mt-2" type="submit" name="create-account" value="<?=__('Update Profile');?>">{{ __('Update Profile') }}</button>                   
                      </form>		
                  </div>
              </div>

<!-- {{-- Multiuser Profile --}} 
         <div class="col-lg-6 mb-3" >
            <div class="sign-user_card mb-3">
               <h4 class="card-title mb-0 manage"> Profile</h4>
                  <div class="col-md-12 profile_image">
                      @forelse  ($profile_details as $profile)
                        <div class="">
                                 <img src="{{URL::asset('public/multiprofile/').'/'.$profile->Profile_Image}}" alt="user" class="multiuser_img" style="width:120px">
                                
                                 <h2 class="name">{{ $profile ? $profile->user_name : ''  }}</h2>
                             <div class="circle">
                                    <a  href="{{ URL::to('profileDetails_edit', $profile->id)}}">
                                           <i class="fa fa-pencil"></i> </a>
                                    @if($Multiuser == null)
                                     <a  href="{{ URL::to('profile_delete', $profile->id)}}" onclick="return confirm('Are you sure to delete this Profile?')" >
                                       <i class="fa fa-trash"></i> </a> 
                                    @endif
                                 </div>
                        </div>
                      @empty
                        <div class="col-sm-6">  <p class="name">No Profile</p>  </div>
                      @endforelse
                  </div>    
              </div> 
            </div>
         </div>
<!-- {{-- Multiuser Profile --}} 
            </div>
       </div>
        </div>
    </section>

    <div id="main-admin-content">
        <div id="content-page" class="content-page">
            <div class="container-fluid">  
<!--
          <div class="row">
                <div class="col-12 col-md-12 col-lg-6" >
           <div class="iq-card">
                    <div class="row" id="card">
                    <div class="col-md-12" >
                  <div class="iq-card-header d-flex justify-content-between align-items-center mb-0 ">
                     <div class="iq-header-title">
                        <h4 class="card-title mb-0">Card Details</h4>
                     </div>
                  </div> 
                  <div class="iq-card-body">
                     <ul class="list-inline p-0 mb-0">
                        <li>
                           <div class="row align-items-center justify-content-between mb-3 mt-3">
                              <div class="col-sm-4">
                                   Card1                                    
                              </div>
                              <div class="col-sm-4">
                                   
                                 								               
                              </div>
                               <div class="col-sm-4">
                                  <a href="<?=URL::to('/transactiondetails');?>" class="btn btn-primary btn-login nomargin noborder-radius" >Transaction Details</a>								               
                              </div>
                           </div>
                        </li>
                     </ul>
                  </div>
                    </div>
                    </div>
                    </div></div>

          </div>


          <div class="row">
          <div class="col-md-12">
                  <div class="iq-card" id="recentviews" style="background-color:#191919;">
                     <div class="iq-card-header d-flex justify-content-between" >
                        <div class="iq-header-title">
                           <h4 class="card-title">Recently Viewd Items</h4>
                        </div>
                        
                     </div>
                      <div class="iq-card-body">
                        <div class="table-responsive " >
                           <table class="data-tables table movie_table recent_table" style="width:100%">
                              <thead>
                                 <tr>
                                    <th style="width:20%;">Video</th>
                                    <th style="width:10%;">Rating</th>
                                    <th style="width:20%;">Category</th>
                                    <th style="width:10%;">Views</th>
                                   <!-- <th style="width:10%;">User</th>
                                     <th style="width:20%;">Date</th> 
                                    <th style="width:10%;"><i class="lar la-heart"></i></th>
                                 </tr>
                              </thead>
                              <tbody>
                              @foreach($recent_videos as $video)
                              @foreach($video as $val)
                                 <tr>
                                    <td>
                                       <div class="media align-items-center">
                                          <div class="iq-movie">
                                          <a href="javascript:void(0);"><img
                                                   src="{{ URL::to('/') . '/public/uploads/images/' . $val->image }}"
                                                   class="img-border-radius avatar-40 img-fluid" alt=""></a>  </div>
                                          <div class="media-body text-white text-left ml-3">
                                             <p class="mb-0"></p>
                                             <small> </small>
                                          </div>
                                       </div>
                                    </td>
                                    <td>{{ $val->rating }}<i class="lar la-star mr-2"></i></td>
                                    <td>@if(isset($val->categories->name)) {{ $val->categories->name }} @endif</td>
                                    <td>{{ $val->views }}</td> 
                                  
                                     <td>{{ $val->created_at }}</td> 
                                    <td><i class="las la-heart text-primary"></i></td>
                                 </tr>
                                 @endforeach                                                                     
                                 @endforeach                                                                     
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
               </div></div>
       
              <div class="container data-mdb-smooth-scroll">
             <div class="row justify-content-center">	
        	   <div class="col-md-12">
                
			   <div class="login-block nomargin">

             <!--<h4 class="my_profile">
                <i class="fa fa-edit"></i> 
                <?php echo __('Update Your Profile Info');?>
              </h4>-->

		<div class="clear"></div>   
		<form method="POST" action="<?= $post_route ?>" id="update_profile_form" accept-charset="UTF-8" file="1" enctype="multipart/form-data">
			<div class="well row">
				<!--<div class="col-sm-6 col-xs-12">
					<div class="row">
						<div class="col-sm-12 col-xs-12">
							<label for="avatar">My Avatar - Elite_<?php echo $user->id;?></label>
							<div id="user-badge">
								<img src="<?= URL::to('/') . '/public/uploads/avatars/' . $user->avatar; ?>" />
								<input type="file" multiple="true" class="form-control" name="avatar" id="avatar" />
							</div>	
						</div>
					</div>
				</div>-->
                <!--popup-->
                <div class="form-popup " id="myForm" style="background:url(<?php echo URL::to('/').'/assets/img/Landban.png';?>) no-repeat;	background-size: cover;padding:40px;display:none;">
                <div class="col-sm-4 details-back">
					<div class="row data-back">
						<div class="well-in col-sm-12 col-xs-12" >
							<?php if($errors->first('name')): ?><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">Ãƒâ€”</button> <strong>Oh snap!</strong> <?= $errors->first('name'); ?></div><?php endif; ?>
							<label for="username" class="lablecolor"><?=__('Username');?></label>
							<input type="text" class="form-control" name="name" id="name" value="<?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?>" />
						</div>
						<div class="well-in col-sm-12 col-xs-12">
							<?php if($errors->first('email')): ?><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">Ãƒâ€”</button> <strong>Oh snap!</strong> <?= $errors->first('email'); ?></div><?php endif; ?>
							<label for="email"><?=__('Email');?></label>
							<input type="text" class="form-control" name="email" id="email" value="<?php if(!empty($user->email)): ?><?= $user->email ?><?php endif; ?>" />
						</div>
						<div class="well-in col-sm-12 col-xs-12">
							<?php if($errors->first('name')): ?><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">Ãƒâ€”</button> <strong>Oh snap!</strong> <?= $errors->first('name'); ?></div><?php endif; ?>
							<label for="username" class="lablecolor"><?=__('Phone Number');?></label>
							<div class="row">
								 <div class="col-sm-6 col-xs-12">
									 <select name="ccode" >
										@foreach($jsondata as $code)
										<option value="{{ $code['dial_code'] }}" <?php if($code['dial_code'] == $user->ccode ) { echo "selected='selected'"; } ?>> {{ $code['name'].' ('. $code['dial_code'] . ')' }}</option>
										@endforeach
									</select>
								</div>
								<div class="col-sm-6 col-xs-12">
									<input type="text" class="form-control" name="mobile" id="mobile" value="<?php if(!empty($user->mobile)): ?><?= $user->mobile ?><?php endif; ?>" />
								</div>
							</div>
						</div>
						<div class="well-in col-sm-12 col-xs-12">
							<label for="password"><?=__('Password');?> (leave empty to keep your original password)</label>
							<input type="password" class="form-control" name="password" id="password"  />
						</div>
						<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
						<div class="col-sm-12 col-xs-12 mt-3">
							<input type="submit" value="<?=__('Update Profile');?>" class="btn btn-primary" />
                             <button type="button" class="btn btn-primary" onclick="closeForm()">Close</button>
						</div>
					</div>
				</div>
                </div>
				
				
                <div class="row" id="subscribe">
<!--                    <a href="<?=URL::to('/becomesubscriber');?>" class="btn btn-primary btn-login nomargin noborder-radius" > Become Subscriber</a>
                    <a href="<?=URL::to('/stripe/billings-details');?>" class="btn btn-primary noborder-radius btn-login nomargin" > View Subscription Details</a>-->
                     
						
					</div>
                
			</div>
			<div class="clear"></div>
		</form>
        </div>
        </div>
       
    </div>
</div>  
</div>
<!--</div>-->
            

		</div>
		<?php $settings = App\Setting::first(); ?>

          <!-- back-to-top End -->
   
       <script>
    $(document).ready(function () {
      $(".thumb-cont").hide();
      $(".show-details-button").on("click", function () {
        var idval = $(this).attr("data-id");
        $(".thumb-cont").hide();
        $("#" + idval).show();
      });
		$(".closewin").on("click", function () {
        var idval = $(this).attr("data-id");
        $(".thumb-cont").hide();
        $("#" + idval).hide();
      });
    });
  </script>
<script>
function about(evt , id) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
    
  }
	
  document.getElementById(id).style.display = "block";
 
}
// Get the element with id="defaultOpen" and click on it
//document.getElementById("defaultOpen").click();
</script>
<!--<script>
  // Prevent closing from click inside dropdown
  $(document).on('click', '.dropdown-menu', function (e) {
    e.stopPropagation();
  });
    
  // make it as accordion for smaller screens
  if ($(window).width() < 992) {
    $('.dropdown-menu a').click(function(e){
      e.preventDefault();
      if($(this).next('.submenu').length){
        $(this).next('.submenu').toggle();
      }
      $('.dropdown').on('hide.bs.dropdown', function () {
        $(this).find('.submenu').hide();
      }
                       )
    }
                               );
  }
</script>-->
<script type="text/javascript">
  $(document).ready(function () {
    $('.searches').on('keyup',function() {
      var query = $(this).val();
      //alert(query);
      // alert(query);
       if (query !=''){
      $.ajax({
        url:"<?php echo URL::to('/search');?>",
        type:"GET",
        data:{
          'country':query}
        ,
        success:function (data) {
          $('.search_list').html(data);
        }
      }
            )
       } else {
            $('.search_list').html("");
       }
    }
                     );
    $(document).on('click', 'li', function(){
      var value = $(this).text();
      $('.search').val(value);
      $('.search_list').html("");
    }
                  );
  }
                   );
</script>
<!--<script>
window.onscroll = function() {myFunction()};

var header = document.getElementById("myHeader");
var sticky = header.offsetTop;

function myFunction() {
  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}
</script>-->

</body>
</html>
	
	
</div>
   <?php 
   if (isset($page) && $page =='admin-dashboard') {
            $visitor_count = TotalVisitorcount();
            $chart_details = "[$total_subscription, $total_recent_subscription, $total_videos, $visitor_count]";
            $chart_lables = "['Total Subscribers', 'New Subscribers', 'Total Videos', 'Total Visitors']";
            $all_category = App\VideoCategory::all();
            $items = array(); 
            $lastmonth = array();      
               foreach($all_category as $category) {
                  $categoty_sum = App\Video::where("video_category_id","=",$category->id)->sum('views');
                  $items[] = "'$category->name'";
                  $lastmonth[] = "'$categoty_sum'";
               }
               $cate_chart = implode(',', $items);
               $last_month_chart = implode(',', $lastmonth);
   }
   ?>


	<!-- Imported styles on this page -->

    
    <script>
function openForm() {
  document.getElementById("myForm").style.display = "block";
    document.getElementById("personal").style.display = "none";
    document.getElementById("subplan").style.display = "none";
     document.getElementById("Profile").style.display = "none";
    document.getElementById("card").style.display = "none";
        document.getElementById("subscribe").style.display = "none";
     document.getElementById("avatar").style.display = "none";
     document.getElementById("recentviews").style.display = "none";
}
</script>

<script>

$(document).ready(function(){
   $('.js-example-basic-multiple').select2({
    width: '100%',
    placeholder: "Select an option",
  });
    
   });

 </script>

<script>
function closeForm() {
  document.getElementById("myForm").style.display = "none";
     document.getElementById("personal").style.display = "block";
    document.getElementById("subplan").style.display = "block";
     document.getElementById("Profile").style.display = "block";
    document.getElementById("card").style.display = "block";
        document.getElementById("subscribe").style.display = "block";
    document.getElementById("avatar").style.display = "block";
     document.getElementById("recentviews").style.display = "block";
}
</script>

   <?php  if (isset($page) && $page =='admin-dashboard') { ?>
   <script>
      $(document).ready(function(){
         if(jQuery('#view-chart-01').length){

var chart_01_lable = $('#chart_01_lable').val();
//alert(chart_01_lable);
   var options = {
      series: <?php echo $chart_details;?>,
      chart: {
      width: 250,
         type: 'donut',
      },
    colors:['#e20e02', '#f68a04', '#007aff','#545e75'],
    labels: <?php echo $chart_lables;?>,
    dataLabels: {
      enabled: false
    },
    stroke: {
        show: false,
        width: 0
    },
    legend: {
        show: false,
    },
    responsive: [{
      breakpoint: 480,
      options: {
        chart: {
          width: 200
        },
        legend: {
          position: 'bottom'
        }
      }
    }]
    };
    console.log(chart_01_lable);
    var chart = new ApexCharts(document.querySelector("#view-chart-01"), options);
    chart.render();
  } 

 if(jQuery('#view-chart-02').length){
        var options = {
          series: [44, 30, 20, 43, 22,20],
          chart: {
          width: 250,
          type: 'donut',
        },
        colors:['#e20e02','#83878a', '#007aff','#f68a04', '#14e788','#545e75'],
        labels: <?php echo "[".$cate_chart."]";?>,
        dataLabels: {
          enabled: false
        },
        stroke: {
            show: false,
            width: 0
        },
        legend: {
            show: false,
          formatter: function(val, opts) {
            return val + " - " + opts.w.globals.series[opts.seriesIndex]
          }
        },
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width: 200
            },
            legend: {
              position: 'bottom'
            }
          }
        }]
        };

        var chart = new ApexCharts(document.querySelector("#view-chart-02"), options);
        chart.render();
    }

    //category chart 

    
 if(jQuery('#view-chart-03').length){
        var options = {
          series: [{
          name: 'This Month',
          data: [44, 55,30,60,7000]
        }, {
          name: 'Last Month',
          data: [35, 41,20,40,100]
        }],
        colors:['#e20e02', '#007aff'],
          chart: {
          type: 'bar',
          height: 230,
          foreColor: '#D1D0CF'
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'rounded'
          },
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
        },
        xaxis: {
          categories: <?php echo "[".$cate_chart."]";?>,
        },
        yaxis: {
          title: {
            text: ''
          }
        },
        fill: {
          opacity: 1
        },
        tooltip: {
            enabled: false,
          y: {
            formatter: function (val) {
              return "$ " + val + " thousands"
            }
          }
        }
        };

        var chart = new ApexCharts(document.querySelector("#view-chart-03"), options);
        chart.render();
    }
});
</script>
<?php } ?>
<script>
            $(".targetDiv").hide(); 
            $(".targetDiv#div1").show();
            $(".showSingle .dimg").hide();
            
            
        
            
          jQuery(function(){
         jQuery('#showall').click(function(){
               jQuery('.targetDiv').show();
               jQuery('.showSingle .limg').show();
                
        });
        jQuery('.showSingle').click(function(){
              jQuery('.targetDiv').hide();
              jQuery('.showSingle .dimg').hide();         
              jQuery('#div'+$(this).attr('target')).show();
        });
});
            
        
        </script>
<script type="text/javascript">

jQuery(document).ready(function($){


   // Add New Category
   $('#submit-new-cat').click(function(){
      $('#new-cat-form').submit();
   });
});

</script>

<script>

      $(document).ready(function(){
         $(".update_username").click(function(){
            $('#update_username').submit();
         });

         $(".update_userimg").click(function(){
            $('#update_userimg').submit();
         });

         $(".update_userEmail").click(function(){
            $('#update_userEmail').submit();
         });

         $(".tv-code").click(function(){
            $('#tv-code').submit();
         });

         $(".DOB").click(function(){
            $('#DOB').submit();
         });

      });

      
   $(document).ready(function(){
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);
    })
      
</script>
<script>
   $('.navbar-toggle a').on('click',function() {
    $('.main-nav').removeClass('open');
});
   </script>
@php
include(public_path('themes/theme3/views/footer.blade.php'));
@endphp
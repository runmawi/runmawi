<!doctype html>
<html lang="en-US">
   <head>

<!-- Favicon -->
   <link rel="shortcut icon" href="<?= getFavicon();?>" type="image/gif" sizes="16x16">
      
<?php
$data = Session::all();
$theme_mode = App\SiteTheme::pluck('theme_mode')->first();

$uri_path = $_SERVER['REQUEST_URI']; 
$uri_parts = explode('/', $uri_path);
$request_url = end($uri_parts);
$uppercase =  ucfirst($request_url);
if(!empty($data['password_hash']) && empty($uppercase) || empty($data['password_hash']) && empty($uppercase)){
// dd($uppercase);
   $uppercase = "Home" ;
}else{

}
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

// exit();UA-42534483-14
$data = Session::all();


      ?>
  <!-- Required meta tags -->
  <?php $settings = App\Setting::first(); //echo $settings->website_name;?>

    
    <?php if(!empty($data['password_hash'])){  $videos_data = App\Video::where('slug',$request_url)->first(); } //echo $settings->website_name; ?>
    <?php if(!empty($data['password_hash'])){ $series = App\Series::where('title',$request_url)->first(); } //echo $settings->website_name; ?>
    <?php if(!empty($data['password_hash'])){ $episdoe = App\Episode::where('title',$request_url)->first(); } //echo $settings->website_name; ?>
    <?php if(!empty($data['password_hash'])){ $livestream = App\LiveStream::where('slug',$request_url)->first(); } //echo $settings->website_name; ?>


    <meta charset="UTF-8">
    <title><?php
   //  dd($data['password_hash']);
      if(!empty($videos_data)){  echo $videos_data->title .' | '. $settings->website_name ;
       }
      elseif(!empty($series)){ echo $series->title .' | '. $settings->website_name ; }
    elseif(!empty($episdoe)){ echo $episdoe->title .' | '. $settings->website_name ; }
    elseif(!empty($livestream)){ echo $livestream->title .' | '. $settings->website_name ; }
    else{ echo $uppercase .' | ' . $settings->website_name ;} ?></title>
    <meta name="description" content= "<?php 
     if(!empty($videos_data)){ echo $videos_data->description  ;
    }
    elseif(!empty($episdoe)){ echo $episdoe->description  ;}
    elseif(!empty($series)){ echo $series->description ;}
    elseif(!empty($livestream)){ echo $livestream->description  ;}
    else{ echo $settings->website_description   ;} //echo $settings; ?>" />

    <meta property="og:title" content="<?php
   //  dd($data['password_hash']);
      if(!empty($videos_data)){  echo $videos_data->title .' | '. $settings->website_name ;
       }
      elseif(!empty($series)){ echo $series->title .' | '. $settings->website_name ; }
    elseif(!empty($episdoe)){ echo $episdoe->title .' | '. $settings->website_name ; }
    elseif(!empty($livestream)){ echo $livestream->title .' | '. $settings->website_name ; }
    else{ echo $uppercase .' | ' . $settings->website_name ;} ?>" />



   <meta property="og:description" content="<?php 
     if(!empty($videos_data)){ echo $videos_data->description  ;
    }
    elseif(!empty($episdoe)){ echo $episdoe->description  ;}
    elseif(!empty($series)){ echo $series->description ;}
    elseif(!empty($livestream)){ echo $livestream->description  ;}
    else{ echo $settings->website_description   ;} //echo $settings; ?>" />



   <meta property="og:image" content="<?php 
     if(!empty($videos_data)){ echo URL::to('/public/uploads/images').'/'.$videos_data->image  ;
    }
    elseif(!empty($episdoe)){ echo URL::to('/public/uploads/images').'/'.$episdoe->image  ;}
    elseif(!empty($series)){ echo URL::to('/public/uploads/images').'/'.$series->image ;}
    elseif(!empty($livestream)){ echo URL::to('/public/uploads/images').'/'.$livestream->image ;}
    else{  echo URL::to('/').'/public/uploads/settings/'. $settings->logo   ;} //echo $settings; ?>" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <input type="hidden" value="<?php echo $settings->google_tracking_id ; ?>" name="tracking_id" id="tracking_id">

     
           
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/bootstrap.min.css';?>" />
    <!-- Typography CSS -->
    <link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/variable.css';?>" />
    <!-- Style -->
      <link href="<?php echo URL::to('public/themes/theme2/assets/css/style.css') ?>" rel="stylesheet">
       <link href="<?php echo URL::to('public/themes/theme2/assets/css/typography.css') ?>" rel="stylesheet">
       <link href="<?php echo URL::to('public/themes/theme2/assets/css/responsive.css') ?>" rel="stylesheet">

       <!-- Icon - Remixicon & fontawesome  -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link href="https://cdn.jsdelivr.net/npm/remixicon@2.2.0/fonts/remixicon.css" rel="stylesheet">
    


    <!-- Responsive -->
    <link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/responsive.css';?>" />
    <link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/slick.css';?>" />
       <link rel="stylesheet" href="https://cdn.plyr.io/3.6.9/plyr.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
       
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.js"></script>

   </head>
    <style>
        svg{
            height: 30px;
        }
        #main-header{ color: #fff; }
        .svg{ color: #fff; } 
        #videoPlayer{
        width:100%;
       height: 100%;
        margin: 20px auto;
    }
        .media h6{
           /* font-family: Chivo;
    font-style: normal;
    font-weight: normal;*/
    font-size: 18px;
    line-height: 29px;
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

/* Rounded sliders */
.sliderk.round {
  border-radius: 34px;
}

.sliderk.round:before {
  border-radius: 50%;
}

/* Dark mode and light Mode */
      body.light-theme {
	      background-color: <?php echo GetLightBg(); ?>;
      }

      body.light-theme h4, body.light-theme p {
         color: <?php echo GetLightText(); ?>;
      }
        body.light-theme header#main-header{
           background-color: <?php echo GetLightBg(); ?>!important;  
            color: <?php echo GetLightText(); ?>;
             box-shadow: 0 0 50px #ccc;
        }
        body.light-theme footer{
            background-color: <?php echo GetLightBg(); ?>!important;  
            color: <?php echo GetLightText(); ?>;
                     box-shadow: 0 0 50px #ccc;

        }
        body.light-theme .copyright{
             background-color: <?php echo GetLightBg(); ?>;
            color: <?php echo GetLightText(); ?>;
        }
        body.light-theme .dropdown-item.cont-item{
             color: <?php echo GetLightText(); ?>!important;
        }
        body.light-theme .s-icon{
           background-color: <?php echo GetLightBg(); ?>; 
             box-shadow: 0 0 50px #ccc;
        }
        body.light-theme .search-toggle:hover, header .navbar ul li.menu-item a:hover{
            color: cornflowerblue!important;
        }
    body.light-theme .dropdown-menu.categ-head{
             background-color: <?php echo GetLightBg(); ?>!important;  
            color: <?php echo GetLightText(); ?>!important;
        }
         body.light-theme .navbar-right .iq-sub-dropdown{
           background-color: <?php echo GetLightBg(); ?>;  
        }
        body.light-theme .media-body h6{
             color: <?php echo GetLightText(); ?>;
        }
        body.light-theme  header .navbar ul li{
            font-weight: 400;
        }
        body.light-theme .slick-nav i{
             color: <?php echo GetLightText(); ?>!important;
        }
         body.light-theme  .block-description h6{
             color: <?php echo GetLightText(); ?>!important;
        }
        body.light-theme footer ul li{
            color: <?php echo GetLightText(); ?>!important;
        }
        body.light-theme h6{
             color: <?php echo GetLightText(); ?>!important;
        }
        body.light-theme .movie-time i{
            color: <?php echo GetLightText(); ?>!important;
        }
        body.light-theme span{
            color: <?php echo GetLightText(); ?>!important;
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
      <header id="main-header">
         <div class="main-header">
            <div class="container-fluid" >
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
                               <ul id="top-menu" class="nav navbar-nav <?php if ( Session::get('locale') == 'arabic') { echo "navbar-right"; } else { echo "navbar-left";}?>">
                                          <?php
                                        $stripe_plan = SubscriptionPlan();
                                        $menus = App\Menu::all();
                                        $languages = App\Language::all();
                                        foreach ($menus as $menu) { 
                                        if ( $menu->in_menu == "video") { 
                                        $cat = App\VideoCategory::all();
                                        ?>
                                       <li class="dropdown menu-item">
                                            <a class="dropdown-toggle" href="<?php echo URL::to('/').$menu->url;?>" data-toggle="dropdown">  
                                              <?php echo __($menu->name);?> <!--<i class="fa fa-angle-down"></i>-->
                                            </a>
                                            <ul class="dropdown-menu categ-head">
                                              <?php foreach ( $cat as $category) { ?>
                                              <li>
                                                <a class="dropdown-item cont-item" style="text-decoration: none!important;" href="<?php echo URL::to('/').'/category/'.$category->slug;?>"> 
                                                  <?php echo $category->name;?> 
                                                </a>
                                              </li>
                                              <?php } ?>
                                            </ul>
                                          </li>
                                          <?php } elseif ( $menu->in_menu == "movies") { 
                                        $cat = App\VideoCategory::all();
                                        ?>
                                          <li class="dropdown menu-item">
                                            <a class="dropdown-toggle" href="<?php echo URL::to('/').$menu->url;?>" data-toggle="dropdown">  
                                              <?php echo __($menu->name);?> <!--<i class="fa fa-angle-down"></i>-->
                                            </a>
                                            <ul class="dropdown-menu categ-head">
                                              <?php foreach ( $languages as $language){ ?>
                                              <li>
                                                <a class="dropdown-item cont-item" href="<?php echo URL::to('/').'/language/'.$language->id.'/'.$language->name;?>"> 
                                                      <?php echo $language->name;?> 
                                                    </a>
                                              </li>
                                              <?php } ?>
                                            </ul>
                                          </li>
                                          <?php }elseif ( $menu->in_menu == "live") { 
                                       //  $LiveCategory = App\LiveCategory::all();
                                       $LiveCategory = App\LiveCategory::get();
                                        ?>
                                          <li class="dropdown menu-item">
                                            <a class="dropdown-toggle" href="<?php echo URL::to('/').$menu->url;?>" data-toggle="dropdown">  
                                              <?php echo __($menu->name);?> <!--<i class="fa fa-angle-down"></i>-->
                                            </a>
                                            <ul class="dropdown-menu categ-head">
                                              <?php foreach ( $LiveCategory as $category){ ?>
                                              <li>
                                              <a class="dropdown-item cont-item" href="<?php echo URL::to('/live/category').'/'.$category->name;?>"> 
                                                      <?php echo $category->name;?> 
                                                    </a>
                                              </li>
                                              <?php } ?>
                                            </ul>
                                          </li>
                                          <?php } else { ?>
                                          <li class="menu-item">
                                            <a href="<?php echo URL::to('/').$menu->url;?>">
                                              <?php echo __($menu->name);?>
                                            </a>
                                          </li>
                                          <?php } } ?>
                                          <!-- <li class="nav-item dropdown menu-item"> -->
                                            <!-- <a class="dropdown-toggle" href="<?php echo URL::to('/').$menu->url;?>" data-toggle="dropdown">   -->
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
                                          <li class="">
                                            <!--<a href="<?php echo URL::to('refferal') ?>" style="color: #4895d1 !important;list-style: none;
                                                                                               font-weight: bold;
                                                                                               font-size: 16px;">
                                              <?php echo __('Refer and Earn');?>
                                            </a>-->
                                          </li>
                                        </ul>
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
                                                <input type="text" name="search" class="searches" id="searches" autocomplete="off" placeholder="Search movies,series">
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
                              <!-- <li class="nav-item nav-icon">
                                  <div class="search-box iq-search-bar d-search">
                                    <form action="<?php echo URL::to('/').'/searchResult';?>" method="post" class="searchbox">
                                        <input name="_token" type="hidden" value="<?php echo csrf_token(); ?>">
                                       <div class="form-group position-relative">
                                          <input type="text" name="search" class="text search-input font-size-12 searches"
                                             placeholder="Search movies,series">
                                          <i class="search-link ri-search-line"></i>
                                       </div>
                                    </form>
                                 </div>
                                 <a href="<?php echo URL::to('/').'/searchResult';?>" class="search-toggle device-search">
                                     
                                 <i class="ri-search-line"></i>
                                 </a>
                                 
                                  <div class="iq-sub-dropdown search_content overflow-auto" id="sidebar-scrollbar" >
                                       <div class="iq-card-body">
                                   <div id="search_list" class="search_list search-toggle device-search" >
                                           </div> </div></div>
                              </li> -->
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
                               <?php if(Auth::guest()): ?>
                              <li class="nav-item nav-icon">
                                    <!-- <img src="<?php echo URL::to('/').'/public/uploads/avatars/lockscreen-user.png' ?>" class="img-fluid avatar-40 rounded-circle" alt="user">-->
                                    <a href="<?php echo URL::to('login') ?>" class="iq-sub-card">
                                        <div class="media align-items-center">
                                            <div class="right-icon">
                                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" x="0" y="0" viewBox="0 0 70 70" style="enable-background:new 0 0 70 70" xml:space="preserve"><path class="st5" d="M13.4 33.7c0 .5.2.9.5 1.2.3.3.8.5 1.2.5h22.2l-4 4.1c-.4.3-.6.8-.6 1.3s.2 1 .5 1.3c.3.3.8.5 1.3.5s1-.2 1.3-.6l7.1-7.1c.7-.7.7-1.8 0-2.5l-7.1-7.1c-.7-.6-1.7-.6-2.4.1s-.7 1.7-.1 2.4l4 4.1H15.2c-1 .1-1.8.9-1.8 1.8z"/><path class="st5" d="M52.3 17.8c0-1.4-.6-2.8-1.6-3.7-1-1-2.3-1.6-3.7-1.6H27.5c-1.4 0-2.8.6-3.7 1.6-1 1-1.6 2.3-1.6 3.7v7.1c0 1 .8 1.8 1.8 1.8s1.8-.8 1.8-1.8v-7.1c0-1 .8-1.8 1.8-1.8H47c.5 0 .9.2 1.2.5.3.3.5.8.5 1.2v31.8c0 .5-.2.9-.5 1.2-.3.3-.8.5-1.2.5H27.5c-1 0-1.8-.8-1.8-1.8v-7.1c0-1-.8-1.8-1.8-1.8s-1.8.8-1.8 1.8v7.1c0 1.4.6 2.8 1.6 3.7 1 1 2.3 1.6 3.7 1.6H47c1.4 0 2.8-.6 3.7-1.6 1-1 1.6-2.3 1.6-3.7V17.8z"/></svg>
                                            </div>
                                            <div class="media-body ml-3">
                                                <h6 class="mb-0 ">Signin</h6>
                                            </div>
                                        </div>
                                    </a>
                               </li>
                               <li class="nav-item nav-icon">
                                  <a href="<?php echo URL::to('signup') ?>" class="iq-sub-card">
                                     <div class="media align-items-center">
                                        <div class="right-icon">
                                       <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" x="0" y="0" viewBox="0 0 70 70" style="enable-background:new 0 0 70 70" xml:space="preserve"><path class="st6" d="M53.4 33.7H30.7M36.4 28.1l-5.7 5.7 5.7 5.7"/><path class="st6" d="M50.5 43.7c-2.1 3.4-5.3 5.9-9.1 7.3-3.7 1.4-7.8 1.6-11.7.4a18.4 18.4 0 0 1-9.6-28.8c2.4-3.2 5.8-5.5 9.6-6.6 3.8-1.1 7.9-1 11.7.4 3.7 1.4 6.9 4 9.1 7.3"/></svg>
                                        </div>
                                        <div class="media-body ml-3">
                                           <h6 class="mb-0 ">Signup</h6>
                                        </div>
                                     </div>
                                  </a>
                               </li>
                              <?php else: ?>
                               <li class="nav-item nav-icon">
                                    <a href="#" class="iq-user-dropdown  search-toggle p-0 d-flex align-items-center"
                                    data-toggle="search-toggle">
                                        <!-- <img src="<?php echo URL::to('/').'/public/uploads/avatars/' . Auth::user()->avatar ?>" class="img-fluid avatar-40 rounded-circle" alt="user">-->
                                        <p class="mt-3" >
                                        
                                        <?php 
                                        $subuser=Session::get('subuser_id');
                                        if($subuser != ''){
                                           $subuser=App\Multiprofile::where('id',$subuser)->first();
                                          echo  $subuser->user_name  ;
                                        }
                                        else{
                                          echo Auth::user()->username.' '.' '  ;
                                        }
                                        
                                        ?> 
                                       
                                        <i class="ri-arrow-down-s-line"></i>
                                       
                                       </p>
                                    </a>
                                   <?php if(Auth::user()->role == 'registered'): ?>
                                   <div class="iq-sub-dropdown iq-user-dropdown">
                                    <div class="iq-card shadow-none m-0">
                                       <div class="iq-card-body p-0 pl-3 pr-3">
                                          <a href="<?php echo  URL::to('myprofile') ?>" class="iq-sub-card setting-dropdown">
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
                                                   <h6 class="mb-0 ">Manage Profile</h6>
                                                </div>
                                             </div>
                                          </a>
                                          <a href="<?php echo URL::to('watchlater') ?>" class="iq-sub-card setting-dropdown">
                                             <div class="media align-items-center">
                                                <div class="right-icon">
                                                  <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" x="0" y="0" viewBox="0 0 70 70" style="enable-background:new 0 0 70 70" xml:space="preserve"><style>.st0{fill:#198fcf;stroke:#198fcf;stroke-width:.75;stroke-miterlimit:10}</style><path class="st0" d="M21.5 23.7h14c.2 0 .3.2.3.4v.8c0 .2-.1.4-.3.4h-14c-.2 0-.3-.2-.3-.4V24c0-.1.2-.3.3-.3zM21.5 32h13.4c.2 0 .3.2.3.4v.8c0 .2-.1.4-.3.4H21.5c-.2 0-.3-.2-.3-.4v-.8c0-.2.2-.4.3-.4zM21.5 40.3h23.1c.2 0 .3.2.3.4v.8c0 .2-.1.4-.3.4H21.5c-.2 0-.3-.2-.3-.4v-.7c0-.3.2-.5.3-.5zM21.5 48.7h23.1c.2 0 .3.2.3.4v.8c0 .2-.1.4-.3.4H21.5c-.2 0-.3-.2-.3-.4v-.8c0-.3.2-.4.3-.4z"/><path class="st1" d="M48.4 37c-5.1 0-9.2-4.1-9.2-9.2s4.1-9.2 9.2-9.2 9.2 4.1 9.2 9.2-4.1 9.2-9.2 9.2zm0-16.7c-4.2 0-7.5 3.3-7.5 7.5s3.3 7.5 7.5 7.5 7.5-3.3 7.5-7.5-3.3-7.5-7.5-7.5z" style="fill:#198fcf;stroke:#198fcf;stroke-width:.5;stroke-miterlimit:10"/><path class="st2" d="M52.1 28.7h-3.8c-.4 0-.7-.3-.7-.7v-3.8c0-.2.2-.4.4-.4h.8c.2 0 .4.2.4.4v2.2c0 .4.3.7.7.7h2.2c.2 0 .4.2.4.4v.8c.1.2-.1.4-.4.4z" style="fill:#198fcf"/><path class="st3" d="M54.3 34v20.1c0 1-.8 1.9-1.9 1.9H17.3c-1 0-1.9-.8-1.9-1.9V17.5c0-1 .8-1.9 1.9-1.9h35.1c1 0 1.9.8 1.9 1.9v4.2" style="fill:none;stroke:#198fcf;stroke-width:2;stroke-miterlimit:10"/></svg>
                                                </div>
                                                <div class="media-body ml-3">
                                                   <h6 class="mb-0 ">Watch Later</h6>
                                                </div>
                                             </div>
                                          </a>
                                          <a href="<?php echo URL::to('mywishlists') ?>" class="iq-sub-card setting-dropdown">
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
                                                   <h6 class="mb-0 ">My Wishlist</h6>
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
                                                   <h6 class="mb-0 ">Purchased Medias</h6>
                                                </div>
                                             </div>
                                          </a>
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
                                  <?php else: ?>
                                 <div class="iq-sub-dropdown iq-user-dropdown">
                                    <div class="iq-card shadow-none m-0">
                                       <div class="iq-card-body p-0 pl-3 pr-3">
                                           <a class="p-0">
                                               <div class=" mt-3 text-right">
                                               <label class="switch toggle mt-3">
  <input type="checkbox" id="toggle"  value=<?php echo $theme_mode;  ?>  <?php if($theme_mode == "light") { echo 'checked' ; } ?> />
  <span class="sliderk round"></span>
</label>
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
                                                   <h6 class="mb-0 ">Manage Profile</h6>
                                                </div>
                                             </div>
                                          </a>
                                          <a href="<?php echo URL::to('watchlater') ?>" class="iq-sub-card setting-dropdown">
                                             <div class="media align-items-center">
                                                <div class="right-icon">
                                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" x="0" y="0" viewBox="0 0 70 70" style="enable-background:new 0 0 70 70" xml:space="preserve"><style>.st0{fill:#198fcf;stroke:#198fcf;stroke-width:.75;stroke-miterlimit:10}</style><path class="st0" d="M21.5 23.7h14c.2 0 .3.2.3.4v.8c0 .2-.1.4-.3.4h-14c-.2 0-.3-.2-.3-.4V24c0-.1.2-.3.3-.3zM21.5 32h13.4c.2 0 .3.2.3.4v.8c0 .2-.1.4-.3.4H21.5c-.2 0-.3-.2-.3-.4v-.8c0-.2.2-.4.3-.4zM21.5 40.3h23.1c.2 0 .3.2.3.4v.8c0 .2-.1.4-.3.4H21.5c-.2 0-.3-.2-.3-.4v-.7c0-.3.2-.5.3-.5zM21.5 48.7h23.1c.2 0 .3.2.3.4v.8c0 .2-.1.4-.3.4H21.5c-.2 0-.3-.2-.3-.4v-.8c0-.3.2-.4.3-.4z"/><path class="st1" d="M48.4 37c-5.1 0-9.2-4.1-9.2-9.2s4.1-9.2 9.2-9.2 9.2 4.1 9.2 9.2-4.1 9.2-9.2 9.2zm0-16.7c-4.2 0-7.5 3.3-7.5 7.5s3.3 7.5 7.5 7.5 7.5-3.3 7.5-7.5-3.3-7.5-7.5-7.5z" style="fill:#198fcf;stroke:#198fcf;stroke-width:.5;stroke-miterlimit:10"/><path class="st2" d="M52.1 28.7h-3.8c-.4 0-.7-.3-.7-.7v-3.8c0-.2.2-.4.4-.4h.8c.2 0 .4.2.4.4v2.2c0 .4.3.7.7.7h2.2c.2 0 .4.2.4.4v.8c.1.2-.1.4-.4.4z" style="fill:#198fcf"/><path class="st3" d="M54.3 34v20.1c0 1-.8 1.9-1.9 1.9H17.3c-1 0-1.9-.8-1.9-1.9V17.5c0-1 .8-1.9 1.9-1.9h35.1c1 0 1.9.8 1.9 1.9v4.2" style="fill:none;stroke:#198fcf;stroke-width:2;stroke-miterlimit:10"/></svg>
                                                </div>
                                                <div class="media-body ml-3">
                                                   <h6 class="mb-0 ">Watch Later</h6>
                                                </div>
                                             </div>
                                          </a>
                                          <a href="<?php echo URL::to('mywishlists') ?>" class="iq-sub-card setting-dropdown">
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
                                                   <h6 class="mb-0 ">My Wishlist</h6>
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
                                                   <h6 class="mb-0 ">Purchased Medias</h6>
                                                </div>
                                             </div>
                                          </a>
                                          <?php if(Auth::User()->role == "admin"){ ?>
                                          <a href="<?php echo URL::to('admin/subscription-plans') ?>"  class="iq-sub-card setting-dropdown">
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
                                          </a>
                                         
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
                              <!-- Multiuser Profile -->
                                          <?php
                                          }
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
          /* .plyr__video-wrapper::before  {
                width: <?php echo $playerui_settings->watermar_width; ?>;
                float: right;
                position: absolute;
                top:<?php echo $playerui_settings->watermark_top; ?>;
                right: <?php echo $playerui_settings->watermark_right; ?>;
                left:<?php echo $playerui_settings->watermark_left; ?>;
                bottom:<?php echo $playerui_settings->watermark_bottom; ?>;
                transform: translate(-50%, 0%);
            } */
            .plyr__video-wrapper::before {
            position: absolute;
            top: <?php echo $playerui_settings->watermark_top; ?>;
            left: <?php echo $playerui_settings->watermark_left; ?>;
            opacity : <?php echo $playerui_settings->watermark_opacity; ?>;
            z-index: 10;
            content: '';
            height: 300px;
            width: <?php echo $playerui_settings->watermar_width; ?>;
            background: url(<?php echo $playerui_settings->watermark_logo; ?>) no-repeat;
            background-size: 100px auto, auto;
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

if(filldate == currentdate &&  DOB != null && !empty(DOB) &&  currentdate != null &&  filldate != null){       
$("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Add Your DOB for Amazing video experience</div>');
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

  <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/google_analytics_tracking_id.js';?>"></script>

  <script>
   let theme_modes = $("#toggle").val();

   $(document).ready(function(){

      if( theme_modes == 'light' ){

         body.classList.add('light-theme');

      }
   });
</script>

      </header>
      <!-- Header End -->
     
       <!-- MainContent End-->
     
  
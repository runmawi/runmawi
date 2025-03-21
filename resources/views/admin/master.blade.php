<!DOCTYPE html>
<html lang="en">

@php
   $favicon_icon = App\Setting::pluck('favicon')->first();
   $AdminAccessPermission = App\AdminAccessPermission::first();
@endphp

<head>

<!-- Favicon -->
   <link rel="shortcut icon" href="<?= URL::to('/'). '/public/uploads/settings/' . $favicon_icon; ?>" />

<?php

@$translate_language = App\Setting::pluck('admin_translate_language')->first();
$translate_checkout = App\SiteTheme::pluck('translate_checkout')->first();

\App::setLocale(@$translate_language);

$uri_path = $_SERVER['REQUEST_URI']; 
$uri_parts = explode('/', $uri_path);
$request_url = end($uri_parts);
$uppercase =  ucfirst($request_url);
$data = Session::all();

// dd($request_url);
if (!empty($data['password_hash'])) {
   $id = auth()->user()->id;
   $user_package =    DB::table('users')->where('id', 1)->first();
   $package = $user_package->package;
   $test = 1;

   $theme_mode = App\SiteTheme::pluck('admin_theme_mode')->first();
   $theme = App\SiteTheme::first();
   // dd($theme_mode);
   ?>
<input type="hidden" id="session" value="session">
<?php if($request_url != "filemanager") { ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<?php } ?>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo $uppercase; ?> | <?php $settings = App\Setting::first(); echo $settings->website_name;?></title>
  <meta name="description" content= "<?php echo $settings->website_description ; ?>" />
  <meta name="author" content="webnexs" />
  <input type="hidden" value="<?php echo $settings->google_tracking_id ; ?>" name="tracking_id" id="tracking_id">
  <?php if($request_url != "filemanager") { ?>

 <!-- <link rel="stylesheet" href="<?= THEME_URL .'/assets/admin/admin/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css'; ?>">
  <link rel="stylesheet" href="<?= THEME_URL .'/assets/admin/admin/css/font-icons/entypo/css/entypo.css'; ?>">
  <link rel="stylesheet" href="<?= THEME_URL .'/assets/admin/admin/css/font-icons/font-awesome/css/font-awesome.min.css'; ?>">
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
  <link rel="stylesheet" href="<?= THEME_URL .'/assets/admin/admin/css/animate.min.css'; ?>">
  <link rel="stylesheet" href="<?= THEME_URL .'/assets/admin/admin/css/core.css'; ?>">
  <link rel="stylesheet" href="<?= THEME_URL .'/assets/admin/admin/css/theme.css'; ?>">
  <link rel="stylesheet" href="<?= THEME_URL .'/assets/admin/admin/css/forms.css'; ?>">
  <link rel="stylesheet" href="<?= THEME_URL .'/assets/admin/admin/css/custom.css'; ?>">
    <script src="<?= THEME_URL ?>/assets/js/admin-homepage.js" type="text/javascript" charset="utf-8"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  @yield('css')

  <script src="<?= URL::to('/').'/assets/admin/admin/js/jquery-1.11.0.min.js'; ?>"></script>
  <script src="<?= THEME_URL .'/assets/admin/admin/js/bootstrap-colorpicker.min.js'; ?>" id="script-resource-13"></script>
  <script src="<?= THEME_URL .'/assets/admin/admin/js/vue.min.js'; ?>"></script>
  
  <script>$.noConflict();</script>-->
<?php } ?>

   <!-- Favicon -->
    <link rel="shortcut icon" href="<?= URL::to('/'). '/public/uploads/settings/' . $settings->favicon; ?>" />
   <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="<?= URL::to('/'). '/assets/admin/dashassets/css/bootstrap.min.css';?>" />
    
   <link rel="stylesheet" href="<?= URL::to('/'). '/assets/admin/dashassets/css/responsive.css';?>" />
<link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" rel="stylesheet">

   <!--datatable CSS -->
   <link rel="stylesheet" href="<?= URL::to('/'). '/assets/admin/dashassets/css/dataTables.bootstrap4.min.css';?>" />
   <!-- Typography CSS -->
   <link rel="stylesheet" href="<?= URL::to('/'). '/assets/admin/dashassets/css/typography.css';?>" />
   <!-- Style CSS -->
   <link rel="stylesheet" href="<?= URL::to('/'). '/assets/admin/dashassets/css/style.css';?>" />
    <link rel="stylesheet" href="<?= URL::to('/'). '/assets/admin/dashassets/css/vod.css';?>" />
   <!-- Responsive CSS -->
   <link rel="stylesheet" href="<?= URL::to('/'). '/assets/admin/dashassets/css/responsive.css';?>" />
    

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
   <link rel="stylesheet" type="text/css" href="<?= URL::to('/'). '/assets/admin/dashassets/css/tourguide.css';?>"   />
    <link rel="stylesheet" type="text/css" href="<?= URL::to('/'). '/assets/admin/dashassets/css/font-awesome.min.css';?>" />
    <?php if($request_url != "filemanager") { ?>

    <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/jquery-3.3.1.slim.min.js';?>"></script>
    <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/popper.min.js';?>"></script>
    <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/bootstrap.min.js';?>"></script>
    <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/tourguide.min.js';?>"></script>
    <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/tourguide.js';?>"></script>


    <?php } ?>


  <!--[if lt IE 9]><script src="<?= THEME_URL .'/assets/admin/admin/js/ie8-responsive-file-warning.js'; ?>"></script><![endif]-->

  <!-- HTML5 shim and Respond.js') }} IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js') }}"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js') }}/1.4.2/respond.min.js') }}"></script>
  <![endif]-->

<style>
    /*table.dataTable thead .sorting{
        display: none!important;
    }*/
    table.dataTable thead .sorting_asc{
        background-image: none!important;
    }
    body.dark {background-color: <?php echo GetAdminDarkBg(); ?>;} /* #9b59b6 */
    body.dark .list-group-item-action:active{background-color: <?php echo GetAdminDarkBg(); ?>!important;} /* #9b59b6 */
    body.dark #progressbar li{background-color: transparent;color:<?php echo GetAdminDarkText(); ?>;} /* #9b59b6 */
    body.dark .modal-content{background-color: <?php echo GetAdminDarkBg(); ?>!important;} /* #9b59b6 */
    body.dark .iq-sidebar-menu .iq-menu li ul li a:hover {
    background-color: <?php echo GetAdminDarkBg(); ?>;
    color: <?php echo GetAdminDarkText(); ?>;
} /* #9b59b6 */
    body.dark .content-page{background-color: <?php echo GetAdminDarkBg(); ?>;} /* #9b59b6 */
    body.dark .btn-black{background-color: <?php echo GetAdminDarkText(); ?>!important;} /* #9b59b6 */
    body.dark .bg-white{background-color: transparent!important;} /* #9b59b6 */
    body.dark #video{background-color: transparent!important;} /* #9b59b6 */
    body.dark .form-control{ color:#646464!important;} /* #9b59b6 */
    body.dark .form-control option{background: <?php echo GetAdminDarkBg(); ?>!important;color: <?php echo GetAdminDarkText(); ?>!important;} /* #9b59b6 */
    body.dark .r1{background-color:  <?php echo GetAdminDarkBg(); ?>;color: <?php echo GetAdminDarkText(); ?>;} /* #9b59b6 */
    body.dark .file{background-color: <?php echo GetAdminDarkBg(); ?>;} /* #9b59b6 */
    body.dark #sidebar-wrapper .list-group{background-color: ;} /* #9b59b6 */
    body.dark .card-title.upload-ui{background-color: transparent;color: <?php echo GetAdminDarkText(); ?>;} /* #9b59b6 */
    body.dark .dropzone{background-color: transparent;color:<?php echo GetAdminDarkText(); ?>;} /* #9b59b6 */
    body.dark .list-group-flush .list-group-item{background-color: <?php echo GetAdminDarkBg(); ?>;color: <?php echo GetAdminDarkText(); ?>;box-shadow: 0px 0px 1px #3e3e3e;} /* #9b59b6 */
    body.dark .black{background-color: <?php echo GetAdminDarkBg(); ?>!important;color:<?php echo GetAdminDarkText(); ?>!important;} /* #9b59b6 */
    body.dark .movie_table tbody td{background-color: <?php echo GetAdminDarkBg(); ?>;color:<?php echo GetAdminDarkText(); ?>;} /* #9b59b6 */
    body.dark .table-striped tbody tr:nth-of-type(odd){background-color:  <?php echo GetAdminDarkBg(); ?>;color: <?php echo GetAdminDarkText(); ?>;} /* #9b59b6 */
    body.dark .movie_table thead th{background-color: <?php echo GetAdminDarkBg(); ?>;color:<?php echo GetAdminDarkText(); ?>!important;} /* #9b59b6 */
    body.dark #msform fieldset{background-color: transparent;padding: 10px;} /* #9b59b6 */
    body.dark .iq-footer{background-color: <?php echo GetAdminDarkBg(); ?>;border-top: 1px solid #000;} /* #9b59b6 */
   /* #9b59b6 */
   
    body.dark table.dataTable tbody tr{background-color: <?php echo GetAdminDarkBg(); ?>;color: <?php echo GetAdminDarkText(); ?>;} /* #9b59b6 */
    body.dark .tab-content{background-color:  <?php echo GetAdminDarkBg(); ?>;} /* #9b59b6 */
    body.dark .iq-card{background-color: <?php echo GetAdminDarkBg(); ?>;} /* #9b59b6 */
    body.dark .iq-card{background-color:<?php echo GetAdminDarkBg(); ?>;} /* #9b59b6 */
    body.dark .iq-top-navbar {background-color: <?php echo GetAdminDarkBg(); ?>;border-bottom: 1px solid #000;} /* #9b59b6 */
    body.dark .iq-sidebar {background-color: <?php echo GetAdminDarkBg(); ?>;border-right: 1px solid #000;} /* #9b59b6 */
    body.dark .iq-menu li a span{color: <?php echo GetAdminDarkText(); ?>;} /* #9b59b6 */
    /*body.dark h1,h2,h3,h4,h5,h6{color: <?php echo GetAdminDarkText(); ?>;}*/
    body.dark label{color: <?php echo GetAdminDarkText(); ?>;}
    body.dark .iq-bg-warning{color: <?php echo GetAdminDarkText(); ?>!important; background:transparent!important;}
    body.dark .iq-bg-success{color: <?php echo GetAdminDarkText(); ?>!important; background:transparent!important;}
    body.dark .iq-bg-danger{ color: <?php echo GetAdminDarkText(); ?>!important; background:transparent!important;}
    body.dark #progressbar li.active{color: blue!important;}
    body.dark #progressbar li img{filter: invert(1);}
    body.dark .ply{filter: invert(1);}
    body.dark .fs-title{color: <?php echo GetAdminDarkText(); ?>;}
    body.dark .panel-body{color: <?php echo GetAdminDarkText(); ?>!important;}
    body.dark .iq-submenu li>a{color: <?php echo GetAdminDarkText(); ?>;}
    body.dark #optionradio{color: <?php echo GetAdminDarkText(); ?>;}
    body.dark .dropzone .dz-message .dz-button{color:<?php echo GetAdminDarkText(); ?>;}
    body.dark th{color: <?php echo GetAdminDarkText(); ?>;}
    body.dark .table-bordered td, .table-bordered th {color: <?php echo GetAdminDarkText(); ?>;}
    body.dark .tags-input-wrapper input{color: #000;}
    body.dark h3{color: <?php echo GetAdminDarkText(); ?>;}
    body.dark h4{color: <?php echo GetAdminDarkText(); ?>;}
    body.dark h5{color: <?php echo GetAdminDarkText(); ?>;}
    body.dark .theme_name{color: <?php echo GetAdminDarkText(); ?>;}
    body.dark h6{color: <?php echo GetAdminDarkText(); ?>;}
    body.dark .upload-ui{color: #000;}
    body.dark div.dataTables_wrapper div.dataTables_info{color: <?php echo GetAdminDarkText(); ?>!important;}
    body.dark div#users_table_paginate a#users_table_previous{color: <?php echo GetAdminDarkText(); ?>!important;}
    body.dark div#users_table_paginate a#users_table_next{color: <?php echo GetAdminDarkText(); ?>!important;}
    body.dark div#users_table_paginate a.paginate_button{color: <?php echo GetAdminDarkText(); ?>!important;}
    body.dark .line{color: <?php echo GetAdminDarkText(); ?>;}
    body.dark .dataTables_info{color: <?php echo GetAdminDarkText(); ?>;}
    body.dark .list-inline-item a{color: <?php echo GetAdminDarkText(); ?>;}
    body.dark .val{color: <?php echo GetAdminDarkText(); ?>;}
    body.dark .main-circle i{color: <?php echo GetAdminDarkText(); ?>;}
    body.dark .text-right{color: <?php echo GetAdminDarkText(); ?>;}
    body.dark .iq-arrow-right{color: <?php echo GetAdminDarkText(); ?>;}
    body.dark .form-group{color: <?php echo GetAdminDarkText(); ?>;}
    body.dark p{color: <?php echo GetAdminDarkText(); ?>!important;}
   body.dark h1, body.dark .support a {color: <?php echo GetAdminDarkText(); ?>;}
   body.dark input {color: <?php echo GetAdminDarkText(); ?>;}
   body.dark select {color: <?php echo GetAdminDarkText(); ?>; background-color: <?php echo GetAdminDarkBg(); ?> !important;}

body.light {background-color: <?php echo GetAdminLightBg(); ?>;} /* #9b59b6 */
    body.light .list-group-item-action:active{background-color: <?php echo GetAdminLightBg(); ?>!important;} /* #9b59b6 */
    body.light #progressbar li{background-color: transparent;color:<?php echo GetAdminLightText(); ?>;} /* #9b59b6 */
    body.light .modal-content{background-color: <?php echo GetAdminLightBg(); ?>!important;} /* #9b59b6 */
    body.light .iq-sidebar-menu .iq-menu li ul li a:hover {
    background-color: <?php echo GetAdminLightBg(); ?>;
    color: <?php echo GetAdminLightText(); ?>;
} /* #9b59b6 */
    body.light .content-page{background-color: <?php echo GetAdminLightBg(); ?>;} /* #9b59b6 */
    body.light .bg-white{background-color: transparent!important;} /* #9b59b6 */
    body.light #video{background-color: transparent!important;} /* #9b59b6 */
    body.light .form-control option{background: <?php echo GetAdminLightBg(); ?>!important;color: <?php echo GetAdminLightText(); ?>!important;} /* #9b59b6 */
    body.light .r1{background-color:  <?php echo GetAdminLightBg(); ?>;color: <?php echo GetAdminLightText(); ?>;} /* #9b59b6 */
    body.light .file{background-color: <?php echo GetAdminLightBg(); ?>;} /* #9b59b6 */
    body.light #sidebar-wrapper .list-group{background-color: ;} /* #9b59b6 */
    body.light .card-title.upload-ui{background-color: transparent;color: <?php echo GetAdminLightText(); ?>;} /* #9b59b6 */
    body.light .dropzone{background-color: transparent;color:<?php echo GetAdminLightText(); ?>;} /* #9b59b6 */
    body.light .list-group-flush .list-group-item{background-color: <?php echo GetAdminLightBg(); ?>;color: <?php echo GetAdminLightText(); ?>;box-shadow: 0px 0px 1px #3e3e3e;} /* #9b59b6 */
    body.light .black{background-color: <?php echo GetAdminLightBg(); ?>!important;color:<?php echo GetAdminLightText(); ?>!important;} /* #9b59b6 */
    body.light .movie_table tbody td{background-color: <?php echo GetAdminLightBg(); ?>;color:<?php echo GetAdminLightText(); ?>;} /* #9b59b6 */
    body.light .table-striped tbody tr:nth-of-type(odd){background-color:  <?php echo GetAdminLightBg(); ?>;color: <?php echo GetAdminLightText(); ?>;} /* #9b59b6 */
    body.light .movie_table thead th{background-color: <?php echo GetAdminLightBg(); ?>;color:<?php echo GetAdminLightText(); ?>!important;} /* #9b59b6 */
    body.light #msform fieldset{background-color: transparent;padding: 10px;} /* #9b59b6 */
    body.light .iq-footer{background-color: <?php echo GetAdminLightBg(); ?>;border-top: 1px solid #000;} /* #9b59b6 */
   /* #9b59b6 */
   
    body.light table.dataTable tbody tr{background-color: <?php echo GetAdminLightBg(); ?>;color: <?php echo GetAdminLightText(); ?>;} /* #9b59b6 */
    body.light .tab-content{background-color:  <?php echo GetAdminLightBg(); ?>;} /* #9b59b6 */
    body.light .iq-card{background-color: <?php echo GetAdminLightBg(); ?>;} /* #9b59b6 */
    body.light .iq-card{background-color:<?php echo GetAdminLightBg(); ?>;} /* #9b59b6 */
    body.light .iq-top-navbar {background-color: <?php echo GetAdminLightBg(); ?>;border-bottom: 1px solid #000;} /* #9b59b6 */
    body.light .iq-sidebar {background-color: <?php echo GetAdminLightBg(); ?>;border-right: 1px solid #000;} /* #9b59b6 */
    body.light .iq-menu li a span{color: <?php echo GetAdminLightText(); ?>;} /* #9b59b6 */
    /*body.light h1,h2,h3,h4,h5,h6{color: <?php echo GetAdminLightText(); ?>;}*/
    body.light label{color: <?php echo GetAdminLightText(); ?>;}
    body.light .iq-bg-warning{color: <?php echo GetAdminDarkBg(); ?>!important; }
    body.light .iq-bg-success{color: <?php echo GetAdminDarkBg(); ?>!important; }
    body.light .iq-bg-danger{ color: <?php echo GetAdminDarkBg(); ?>!important; }
    body.light #progressbar li.active{color: blue!important;}
    body.light #progressbar li img{filter: invert(0);}
    body.light .ply{filter: invert(0);}
    body.light .fs-title{color: <?php echo GetAdminLightText(); ?>;}
    body.light .panel-body{color: <?php echo GetAdminLightText(); ?>!important;}
    body.light .iq-submenu li>a{color: <?php echo GetAdminLightText(); ?>;}
    body.light #optionradio{color: <?php echo GetAdminLightText(); ?>;}
    body.light .dropzone .dz-message .dz-button{color:<?php echo GetAdminLightText(); ?>;}
    body.light th{color: <?php echo GetAdminLightText(); ?>;}
    body.light .table-bordered td, .table-bordered th {color: <?php echo GetAdminLightText(); ?>;}
    body.light .tags-input-wrapper input{color: #000;}
    body.light h3{color: <?php echo GetAdminLightText(); ?>;}
    body.light h4{color: <?php echo GetAdminLightText(); ?>;}
    body.light h5{color: <?php echo GetAdminLightText(); ?>;}
    body.light .theme_name{color: <?php echo GetAdminLightText(); ?>;}
    body.light h6{color: <?php echo GetAdminLightText(); ?>;}
    body.light .upload-ui{color: #000;}
    body.light div.dataTables_wrapper div.dataTables_info{color: <?php echo GetAdminLightText(); ?>!important;}
    body.light .line{color: <?php echo GetAdminLightText(); ?>;}
    body.light .dataTables_info{color: <?php echo GetAdminLightText(); ?>;}
    body.light .list-inline-item a{color: <?php echo GetAdminLightText(); ?>;}
    body.light .val{color: <?php echo GetAdminLightText(); ?>;}
    body.light .main-circle i{color: <?php echo GetAdminLightText(); ?>;}
    body.light .text-right{color: <?php echo GetAdminLightText(); ?>;}
    body.light .iq-arrow-right{color: <?php echo GetAdminLightText(); ?>;}
    body.light .form-group{color: <?php echo GetAdminLightText(); ?>;}
    body.light p{color: <?php echo GetAdminLightText(); ?>!important;}
   body.light h1, body.light .support a {color: <?php echo GetAdminLightText(); ?>;}
   body.light ol.breadcrumb a{color: <?php echo GetAdminLightText(); ?>;font-weight:500;}
   body.light ol.breadcrumb li{color: <?php echo GetAdminLightText(); ?>;}



.checkbox {
  opacity: 0;
  
}
    .list-user-action{
        display: flex;
    }

.checkbox-label {
  background-color: #111;
  width: 50px;
  height: 26px;
  border-radius: 50px;
  position: relative;
  padding: 5px;
  cursor: pointer;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.fa-moon {color: #f1c40f;}

.fa-sun {color: #f39c12;}

.checkbox-label .ball {
  background-color: #fff;
  width: 22px;
  height: 22px;
  position: absolute;
  left: 2px;
  top: 2px;
  border-radius: 50%;
  transition: transform 0.2s linear;
}

.checkbox:checked + .checkbox-label .ball {
  transform: translateX(24px);
}


    .top-left-logo img {
        opacity: 0.9;
        overflow: hidden;
    }
    span{
        font-weight: normal!important;
    }
    .header-logo

    {
       padding-left: 25px;
        
    }
    hr {
        border-top: 1px solid #e2e2e22e!important;
    }
    
    
/* validate */
    .error {
    color: red !important;
    font-size : 14px !important;
}

/* dropzone */
.dropzone .dz-preview .dz-success-mark, .dropzone .dz-preview .dz-error-mark{top: 0;left: 0;margin-left: 0; margin-top: 0;width: 20px;}
.dropzone .dz-preview .dz-success-mark svg, .dropzone .dz-preview .dz-error-mark svg{width: 30px;height: 30px;}
.dz-error-mark g{fill:#FF0000;}
.dz-success-mark path{fill:#008000;}
.ck.ck-powered-by {display: none;}
.ck p{text-transform: none;}
</style>

</head>
<body >
<?php 
// exit();
if($package == "Basic" && auth()->user()->role == "subscriber" || $package == "Basic" && auth()->user()->role == "registered" ){    ?>
<div class="page-container sidebar-collapsed"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
  <!-- Sidebar 1-->
      <div class="iq-sidebar">
         <div class="iq-sidebar- d-flex justify-content-between align-items-center mt-2">
            <a href="<?php echo URL::to('home') ?>" class="header-logo">
               <img src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo ; ?>" class="c-logo" alt="" width="200px" height="100px" style="object-fit:contain;">
               <div class="logo-title">
                  <span class="text-primary text-uppercase"></span>
               </div>
            </a>
            <div class="iq-menu-bt-sidebar">
               <div class="iq-menu-bt align-self-center">
                  <div class="wrapper-menu">
                     <div class="main-circle"><i class="las la-bars"></i></div>
                  </div>
               </div>
            </div>
         </div>
         <div id="sidebar-scrollbar">
            <nav class="iq-sidebar-menu">
               <ul id="iq-sidebar-toggle" class="iq-menu">
               <!-- <li><a href="{{ URL::to('admin/age/index') }}" class="iq-waves-effect"><img class="" src="<?php //echo  URL::to('/assets/img/icon/menu.svg')?>" heigth="40" width="40"><span>Manage Age</span></a></li> -->

                  <li class="views"><a href="<?php echo URL::to('home') ?>" ><i class="ri-arrow-right-line"></i><span></span></a></li>
                  <li  ><a href="<?php echo URL::to('admin') ?>"  class="iq-waves-effect"><img class="ply" height="40" width="40" src="<?php echo  URL::to('/assets/img/icon/home.svg')?>"> <span class="mt-2">Dashboard</span></a></li>
                   <div class="bod"></div>
                   <div  class="men" style="">
                 
                   <p class="lnk" >Video</p>
                   </div>
                   <li data-tour="step: 1; title: All Videos; content: Go to 'Video Library' to add or import content into content library" class=" " data-tour="step: 1; title: All Videos; content: Go to 'Video Library' to add or import content into content library"><a href="#video" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="ply" height="40" width="40" src="<?php echo  URL::to('/assets/img/sidemenu/vi.svg')?>"><span>Video Management </span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                   <ul id="video" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ URL::to('admin/videos/create') }}"><img class="mr-2" height="30" width="30" src="<?php echo  URL::to('/assets/img/icon/add-new-video.svg')?>">Add New Video</a></li>
                        <li><a href="{{ URL::to('admin/CPPVideosIndex') }}">Videos For Approval</a></li>
                        <li><a href="{{ URL::to('admin/Masterlist') }}" class="iq-waves-effect"><span> Master Video List</span></a></li>
                        <li><a href="{{ route('admin.Channel.index') }}" class="iq-waves-effect">Channel</a></li>
                        <li><a href="{{ URL::to('admin/video-schedule') }}" class="iq-waves-effect">Video Schedule</a></li>
                        @if (EPG_Status() == 1)
                           <li><a href="{{ route('admin.epg.index') }}" class="iq-waves-effect"> EPG </a></li>
                        @endif                        <!-- <li><a href="{{ URL::to('admin/test/videoupload') }}" class="iq-waves-effect">Test Server Video Upload</a></li> -->
                        <li><a href="{{ URL::to('admin/assign_videos/partner') }}" class="iq-waves-effect">Move Videos to Partner</a></li>
                        <li data-tour="step: 2; title: Video Category; content: Go to 'Manage Categories' to setup your content categories" class=" " data-tour="step: 2; title: Video Category; content: Go to 'Manage Categories' to setup your content categories"><a href="{{ URL::to('admin/videos/categories') }}">Manage Video Categories</a></li>                    
          </ul></li>
          <!-- <li><a href="#series" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="las la-tv"></i><span>TV Shows </span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
            <ul id="series" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
              <li><a href="{{ URL::to('admin/restrict') }}"><i class="las la-user-plus"></i>List TV Shows </a></li>
              <li><a href="{{ URL::to('admin/restrict') }}"><i class="las la-eye"></i>Add New TV Shows</a></li>

            </ul>
          </li> -->
          <!-- <li> -->
          <!-- <div class="men" style=""> 
                 <p class="" style="color:#0993D2!important;padding-left:30px;font-weight: 600;">Live Video</p>
                 </div>
                     <a href="#live-video" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="las la-film"></i><span>Manage Live Videos</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                     <ul id="live-video" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ URL::to('admin/restrict') }}"><i class="las la-user-plus"></i>All Live Videos</a></li>
                        <li><a href="{{ URL::to('admin/restirct') }}"><i class="las la-eye"></i>Add New Live Video</a></li>
                        <li><a href="{{ URL::to('admin/CPPLiveVideosIndex') }}"><i class="las la-eye"></i>Live Videos For Approval</a></li>
                         <li><a href="{{ URL::to('admin/restrict') }}"><i class="las la-eye"></i>Manage Live Video Categories</a></li>
                     </ul>
                  </li> -->
                    <!-- <div class="men" style="">
                  
                        <p class="" style="color:#0993D2!important;padding-left:30px;font-weight: 600;">Audio </p></div>
          <li><a href="#audios" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="las la-music"></i><span>Audio Management </span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
            <ul id="audios" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
              <li><a href="{{ URL::to('admin/restrict') }}"><i class="las la-music"></i>Audio List</a></li>
              <li><a href="{{ URL::to('admin/restrict') }}"><i class="las la-plus"></i>Add New Audio</a></li>
              <li><a href="{{ URL::to('admin/restrict') }}"><i class="las la-eye"></i>Manage Audio Categories</a></li>
              <li><a href="{{ URL::to('admin/restrict') }}"><i class="las la-eye"></i>Manage Albums</a></li>
            </ul>
          </li>
          <li><a href="#artists" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="las la-user"></i><span>Artist Management </span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
            <ul id="artists" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
              <li><a href="{{ URL::to('admin/restrict') }}"><i class="las la-user-plus"></i>All Artists</a></li>
              <li><a href="{{ URL::to('admin/restrict') }}"><i class="las la-eye"></i>Add New Artist</a></li>

            </ul>
          </li> -->
          


                    <div class="men">
                  
                        <p class="lnk" >Accounts</p></div>
                  <li><a href="#user" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="" src="<?php echo  URL::to('/assets/img/icon/user.svg')?>"><span>Users</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                       <ul id="user" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ URL::to('admin/users') }}"><i class="las la-user-plus"></i>All Users</a></li>
                        <li><a href="{{ URL::to('admin/user/create') }}"><i class="las la-eye"></i>Add New User</a></li>
                        <li><a href="{{ route('import_users_view') }}"> Import Users </a></li>
                        <li><a href="{{ URL::to('admin/MultiUser-limit') }}"><img height="30" width="30" class="mr-2" src="<?php echo  URL::to('/assets/img/icon/add-new-user.svg')?>">Multi User Management</a></li>
                     </ul>
                      
                   </li>
                   <li><a href="{{ URL::to('admin/menu') }}" class="iq-waves-effect"><img class="" src="<?php echo  URL::to('/assets/img/icon/men.svg')?>" heigth="40" width="40"><span>Menu</span></a></li>
                   <li><a href="{{ URL::to('admin/signup') }}" class="iq-waves-effect"><img class="" src="<?php echo  URL::to('/assets/img/icon/men.svg')?>"heigth="40" width="40"><span>Signup Menu</span></a></li>
                  <!-- <li><a href="{{ URL::to('/admin/filemanager') }}" class="iq-waves-effect"><img class="" src="<?php echo  URL::to('/assets/img/icon/file.svg')?>" heigth="40" width="40"><span>Filemanager</span></a></li>-->

                    <div class="men">
                
                   <!-- <p class="" style="color:#0993D2!important;padding-left:30px;font-weight: 600;">Language</p>
                       </div>
                  <li>
                     <a href="#language" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="las la-language"></i><span>Manage Languages </span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                     <ul id="language" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ URL::to('admin/restrict') }}"><i class="las la-user-plus"></i>Video Languages</a></li>
                        <li><a href="{{ URL::to('admin/restrict') }}"><i class="las la-eye"></i>Manage Translations</a></li>
                         <li><a href="{{ URL::to('admin/restrict') }}"><i class="las la-eye"></i>Manage Translate Languages</a></li>
                     </ul>
                  </li>
                    -->
                   <li><a href="{{ URL::to('admin/sliders') }}" class="iq-waves-effect"><img class="" src="<?php echo  URL::to('/assets/img/icon/slider.svg')?>"><span> Sliders</span></a></li>

                   <!-- <li><a href="{{ URL::to('admin/restrict') }}" class="iq-waves-effect"><i class="la la-sliders"></i><span> Test Payment Setting</span></a></li> -->

                    <div class="men">
                   
                   <p class="lnk" >Site</p>
                       </div>
                       <li><a href="{{ URL::to('admin/players') }}" class="iq-waves-effect"><img class="ply" src="<?php echo  URL::to('/assets/img/icon/ply.svg')?>"><span>Player UI</span></a></li>
                   <!-- <li><a href="{{ URL::to('/client') }}" class="iq-waves-effect"><i class="la la-file-video-o"></i><span>File Manager</span></a></li> -->
                   <!-- <li>
                     <a href="#moderators" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i
                        class="las la-user-friends"></i><span>Moderators</span><i
                        class="ri-arrow-right-s-line iq-arrow-right"></i>
                     </a>
                     <ul id="moderators" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ URL::to('admin/restrict') }}"><i class="las la-user-plus"></i> Add Moderators</a></li>
                        <li><a href="{{ URL::to('admin/restrict') }}"><i class="las la-eye"></i> View Moderators</a></li>
                        <li><a href="{{ URL::to('/cpp/restrict/') }}"><i class="las la-eye"></i>Moderators For Approval</a></li>
                        <li><a href="{{ URL::to('admin/restrict') }}"><i class="las la-eye"></i>Add Role</a></li>   
                        <li><a href="{{ URL::to('admin/restrict') }}"><i class="las la-eye"></i>View Role</a></li>
                        <li><a href="{{ URL::to('admin/restrict') }}"><i class="las la-eye"></i>Commission </a></li>

                     </ul>
                  </li> -->
                  <li>
                     <a href="#pages" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="" src="<?php echo  URL::to('/assets/img/icon/page.svg')?>"><span>Pages</span><i
                        class="ri-arrow-right-s-line iq-arrow-right"></i>
                     </a>
                     <ul id="pages" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ URL::to('admin/pages') }}"><i class="las la-user-plus"></i>All Pages</a></li>
                        <li><a href="{{ route('landing_page_index') }}">Landing Page</a></li>
                        <li><a href="{{ route('landing_page_create') }}">Create Landing Page</a></li>
                     </ul>
                  </li>
                   
                    <li>
                     <a href="#plans" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="" src="<?php echo  URL::to('/assets/img/icon/plan.svg')?>"><span>Plans</span><i
                        class="ri-arrow-right-s-line iq-arrow-right"></i>
                     </a>
                     <ul id="plans" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <!-- <li><a href="{{ URL::to('admin/plans') }}"><i class="las la-user-plus"></i>Manage Stripe plans</a></li>
                        <li><a href="{{ URL::to('admin/paypalplans') }}"><i class="las la-eye"></i>Manage Paypal plans</a></li> -->
                        <li><a href="{{ URL::to('admin/subscription-plans') }}"><i class="las la-eye"></i>Manage Subscription plans</a></li>
                        <li><a href="{{ route('inapp_purchase') }}"><img height="30" width="30"  class="mr-2" src="<?php echo  URL::to('/assets/img/icon/manage-sub.svg')?>">Manage In App Purchase Plans</a></li>
                        <li><a href="{{ route('Life-time-subscription-index') }}"> Life time subscription </a></li>
                         <!-- <li><a href="{{ URL::to('admin/coupons') }}"><i class="las la-eye"></i>Manage Stripe Coupons</a></li> -->
                         <li><a href="{{ URL::to('admin/devices') }}"><i class="las la-eye"></i>Devices</a></li>
                     </ul>
                  </li>
                  <li>
                     <a href="#payment_managements" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="ply" src="<?php echo  URL::to('/assets/img/icon/pay.svg')?>">Payment Management</span><i
                        class="ri-arrow-right-s-line iq-arrow-right"></i>
                     </a>
                     <ul id="payment_managements" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ URL::to('admin/payment/total_revenue') }}"><i class="las la-user-plus"></i>Total Revenues</a></li>
                        <li><a href="{{ URL::to('admin/payment/subscription') }}"><i class="las la-eye"></i>Subscription Payments</a></li>
                         <li><a href="{{ URL::to('admin/payment/PayPerView') }}"><i class="las la-eye"></i>PayPerView Payments</a></li>
                     </ul>
                  </li>
                   
                  <div >
                  <!-- <p class="" style="color:#0993D2!important;padding-left:30px;font-weight: 600;">Analytics</p></div> -->
                    <!-- <li>
                     <a href="#analytics_managements" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i
                        class="las la-film"></i><span>Analytics </span><i
                        class="ri-arrow-right-s-line iq-arrow-right"></i>
                     </a>
                     <ul id="analytics_managements" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ URL::to('admin/restrict') }}"><i class="las la-user-plus"></i>Users Analytics </a></li>
                        <li><a href="{{ URL::to('admin/restrict') }}"><i class="las la-eye"></i>Views By Region</a></li>
                         <li><a href="{{ URL::to('admin/restrict') }}"><i class="las la-eye"></i>Revenue by region</a></li>
                     </ul>
                  </li> -->
                  <div >




                    <li>
                     <a href="#settings" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="ply" src="<?php echo  URL::to('/assets/img/icon/setting.svg')?>"><span>Settings</span><i
                        class="ri-arrow-right-s-line iq-arrow-right"></i>
                     </a>
                         <ul id="settings" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                     <li  data-tour="step: 4; title: System Setting; content: Go to Settings to choose different monetization methods Subscription, Pay Per View, PPV Bundles, Coupons, etc for your content or make them free" class=" " data-tour="step: 4; title: Promo code; content: Go to Settings to choose different monetization methods Subscription, Pay Per View, PPV Bundles, Coupons, etc for your content or make them free" ><a href="{{ URL::to('admin/settings') }}"><i class="las la-eye"></i>System Settings</a></li>
                            <li><a href="{{ URL::to('admin/home-settings') }}"><i class="las la-eye"></i>HomePage Settings</a></li>
                            <li><a href="{{ URL::to('admin/linking_settings/') }}"><i class="las la-eye"></i>Link Settings</a></li>
                            <!-- <li><a href="{{ URL::to('admin/order-home-settings') }}"><i class="las la-eye"></i>Order HomePage Settings</a></li> -->
                            <li><a href="{{ URL::to('admin/theme_settings') }}"><i class="las la-eye"></i>Theme Settings</a></li>
                            <li><a href="{{ route('admin_slider_index') }}">Slider</a></li>

                            <li><a href="{{ URL::to('admin/payment_settings') }}"><i class="las la-eye"></i>Payment Settings</a></li>
                            <li><a href="{{ URL::to('admin/email_settings') }}"><i class="las la-eye"></i>Email Settings</a></li>
                            <li><a href="{{ URL::to('admin/storage_settings') }}"><i class="las la-eye"></i>Storage Settings</a></li>
                            <!-- <li><a href="{{ URL::to('admin/email_template') }}"><i class="las la-eye"></i>Email Template</a></li> -->
                            <li><a href="{{ URL::to('admin/mobileapp') }}"><i class="las la-user-plus"></i>Mobile App Settings</a></li>
                            <li><a href="{{ URL::to('admin/system_settings') }}"><i class="las la-eye"></i>Social Login Settings</a></li>
                            <li><a href="{{ URL::to('admin/currency_settings') }}"><i class="las la-eye"></i>Currency Settings</a></li>
                            <li><a href="{{ URL::to('admin/revenue_settings/index') }}"><i class="las la-eye"></i>Revenue Settings</a></li>
                            <li><a href="{{ URL::to('admin/ChooseProfileScreen') }}" class="iq-waves-effect"><i class="ri-price-tag-line"></i><span>Profile Screen</span></a></li>
                            {{-- <li  data-tour="step: 3; title: Manage Theme; content: Go to 'Manage Template' to choose a template for our website from our catalogue" class=" " data-tour="step: 3; title: Manage Theme; content: Go to 'Manage Template' to choose a template for our website from our catalogue"><a href="{{ URL::to('admin/ThemeIntegration') }}" class="iq-waves-effect"><i class="ri-price-tag-line"></i><span>Theme</span></a></li> --}}
                            <li><a href="{{ route('compress_image') }}" class="iq-waves-effect"> Image Settings </a></li>
                            <li><a href="{{ route('homepage_popup') }}" class="iq-waves-effect"> Home Page Pop Up Settings </a></li>
                            <li><a href="{{ route('comment_section') }}" class="iq-waves-effect"> Comment Section Settings </a></li>

                     </ul>
                  </li>
                  <?php }elseif($package == "Pro" && auth()->user()->role == "subscriber" || $package == "Pro" && auth()->user()->role == "registered" ){   ?>
      <div class="page-container sidebar-collapsed"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
 
 
<!-- Sidebar 2-->
      <div class="iq-sidebar">
         <div class="iq-sidebar- d-flex justify-content-between align-items-center mt-2">
            <a href="<?php echo URL::to('home') ?>" class="header-logo">
               <img src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo ; ?>" class="c-logo" alt="" width="200px" height="100px" style="object-fit:contain;">
               <div class="logo-title">
                  <span class="text-primary text-uppercase"></span>
               </div>
            </a>
            <div class="iq-menu-bt-sidebar">
               <div class="iq-menu-bt align-self-center">
                  <div class="wrapper-menu">
                     <div class="main-circle"><i class="las la-bars"></i></div>
                  </div>
               </div>
            </div>
         </div>
         <div id="sidebar-scrollbar">
            <nav class="iq-sidebar-menu">
               <ul id="iq-sidebar-toggle" class="iq-menu">
                  <li class="views"><a href="<?php echo URL::to('/') ?>" ><i class="ri-arrow-right-line"></i><span>Visit site</span></a></li>
                  <li ><a href="<?php echo URL::to('admin') ?>" class="iq-waves-effect"><img class="ply" height="40" width="40" src="<?php echo  URL::to('/assets/img/icon/home.svg')?>"> <span class="mt-2"><span>Dashboard</span></a></li>
                   <div class="bod"></div>
                   <div class="men" style="">
                 
                   <p class="lnk" >Video</p>
                   </div>
                   <li data-tour="step: 1; title: All Videos; content: Go to 'Video Library' to add or import content into content library" class=" " data-tour="step: 1; title: All Videos; content: Go to 'Video Library' to add or import content into content library"><a href="#video" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="ply" height="40" width="40" src="<?php echo  URL::to('/assets/img/sidemenu/vi.svg')?>"><span>Video Management </span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                   <ul id="video" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                         <li><a href="{{ URL::to('admin/videos') }}">All Videos</a></li>
                        <li><a href="{{ URL::to('admin/videos/create') }}">Add New Video</a></li>
                        <li><a href="{{ URL::to('admin/CPPVideosIndex') }}">Videos For Approval</a></li>
                        <li><a href="{{ URL::to('admin/Masterlist') }}" class="iq-waves-effect"><span> Master Video List</span></a></li>
                        <li><a href="{{ URL::to('admin/video-schedule') }}" class="iq-waves-effect">Video Schedule</a></li>
                        <li><a href="{{ route('admin.Channel.index') }}" class="iq-waves-effect">Channel </a></li>
                        @if (EPG_Status() == 1)
                           <li><a href="{{ route('admin.epg.index') }}" class="iq-waves-effect"> EPG </a></li>
                        @endif
                        <!-- <li><a href="{{ URL::to('admin/test/videoupload') }}" class="iq-waves-effect">Test Server Video Upload</a></li> -->
                        <li><a href="{{ URL::to('admin/assign_videos/partner') }}" class="iq-waves-effect">Move Videos to Partner</a></li>
                        <li data-tour="step: 2; title: Video Category; content: Go to 'Manage Categories' to setup your content categories" class=" " data-tour="step: 2; title: Video Category; content: Go to 'Manage Categories' to setup your content categories"><a href="{{ URL::to('admin/videos/categories') }}">Manage Video Categories</a></li>                    
                    
          </ul></li>
          <li><a href="#series" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="ply" height="40" width="40" src="<?php echo  URL::to('/assets/img/icon/tv.svg')?>"><span>TV Shows </span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
            <ul id="series" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
              <li><a href="{{ URL::to('admin/series-list') }}"><i class="las la-user-plus"></i>List TV Shows </a></li>
              <li><a href="{{ URL::to('admin/series/create') }}"><i class="las la-eye"></i>Add New TV Shows</a></li>
              <li data-tour="step: 2; title: Video Category; content: Go to 'Manage Categories' to setup your content categories" class=" " data-tour="step: 2; title: Video Category; content: Go to 'Manage Categories' to setup your content categories"><a href="{{ URL::to('admin/Series/Genre') }}"><img class="mr-2" height="30" width="30" src="<?php echo  URL::to('/assets/img/icon/video-approval.svg')?>">Manage Genre</a></li>  
               @if (Series_Networks_Status() == 1 )
                  <li><a href="{{ route('admin.Network_index') }}">Manage Networks</a></li>
               @endif              <li><a href="{{ URL::to('admin/assign_Series/partner') }}" class="iq-waves-effect">Move TV Shows to Partner</a></li>
              <li><a href="{{ URL::to('admin/CPPSeriesIndex') }}">TV Shows For Approval</a></li>



            </ul>
          </li>
          <li>
          <div class="men" style=""> 
                 <p class="lnk" >Live Stream</p>
                 </div>
                     <a href="#live-video" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="ply" src="<?php echo  URL::to('/assets/img/icon/live.svg')?>"><span>Manage Live Stream</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                     <ul id="live-video" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ URL::to('admin/livestream') }}"><i class="las la-user-plus"></i>All Live Stream</a></li>
                        <li><a href="{{ URL::to('admin/livestream/create') }}"><i class="las la-eye"></i>Add New Live Stream</a></li>
                        <li><a href="{{ URL::to('admin/CPPLiveVideosIndex') }}"><i class="las la-eye"></i>Live Stream For Approval</a></li>
                         <li><a href="{{ URL::to('admin/livestream/categories') }}"><i class="las la-eye"></i>Manage Live Stream Categories</a></li>
                         <li><a href="{{ route('live_event_artist') }}"> Live Event Artist </a></li>
                     </ul>
                  </li>

                    <div class="men" style="">
                  
                        <p class="lnk" >Audio </p></div>
          <li><a href="#audios" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="ply" src="<?php echo  URL::to('/assets/img/icon/music.svg')?>"><span>Audio Management </span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
            <ul id="audios" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
              <li><a href="{{ URL::to('admin/audios') }}"><i class="las la-music"></i>Audio List</a></li>
              <li><a href="{{ URL::to('admin/audios/create') }}"><i class="las la-plus"></i>Add New Audio</a></li>
              <li><a href="{{ URL::to('admin/CPPAudioIndex') }}">Audios For Approval</a></li>
              <li><a href="{{ URL::to('admin/audios/categories') }}"><i class="las la-eye"></i>Manage Audio Categories</a></li>
              <li><a href="{{ URL::to('admin/audios/albums') }}"><i class="las la-eye"></i>Manage Albums</a></li>
            </ul>
          </li>
          <li><a href="#artists" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="ply" src="<?php echo  URL::to('/assets/img/icon/art.svg')?>">
<span>Artist Management </span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
            <ul id="artists" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
              <li><a href="{{ URL::to('admin/artists') }}"><i class="las la-user-plus"></i>All Artists</a></li>
              <li><a href="{{ URL::to('admin/artists/create') }}"><i class="las la-eye"></i>Add New Artist</a></li>

            </ul>
          </li>
          
                    <div class="men">
                  
                        <p class="lnk" >Accounts</p></div>
                  <li><a href="#user" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="las la-user-friends"></i><span>Users</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                       <ul id="user" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ URL::to('admin/users') }}"><i class="las la-user-plus"></i>All Users</a></li>
                        <li><a href="{{ URL::to('admin/user/create') }}"><i class="las la-eye"></i>Add New User</a></li>
                        <li><a href="{{ route('import_users_view') }}"> Import Users </a></li>
                        <li><a href="{{ URL::to('admin/MultiUser-limit') }}"><img height="30" width="30" class="mr-2" src="<?php echo  URL::to('/assets/img/icon/add-new-user.svg')?>">Multi User Management</a></li>
                     </ul>
                      
                   </li>
                   <li><a href="{{ URL::to('admin/menu') }}" class="iq-waves-effect"><img class="" src="<?php echo  URL::to('/assets/img/icon/men.svg')?>"heigth="40" width="40"><span>Menu</span></a></li>
                   <li><a href="{{ URL::to('admin/signup') }}" class="iq-waves-effect"><img class="" src="<?php echo  URL::to('/assets/img/icon/men.svg')?>"heigth="40" width="40"><span>Signup Menu</span></a></li>
                   <!--<li><a href="{{ URL::to('/admin/filemanager') }}" class="iq-waves-effect"><img class="" src="<?php echo  URL::to('/assets/img/icon/file.svg')?>" heigth="40" width="40"><span>Filemanager</span></a></li>-->

                    <div class="men">
                
                   <p class="lnk" >Language</p>
                       </div>
                  <li>
                     <a href="#language" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="ply" src="<?php echo  URL::to('/assets/img/icon/lang.svg')?>"><span>Manage Languages </span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                     <ul id="language" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ URL::to('admin/admin-languages') }}"><i class="las la-user-plus"></i>Video Languages</a></li>
                        <li><a href="{{ URL::to('admin/subtitles/create') }}"><i class="las la-user-plus"></i>Add Subtitle Languages</a></li>
                        <li><a href="{{ URL::to('admin/languages') }}"><i class="las la-eye"></i>Manage Translations</a></li>
                         {{-- <li><a href="{{ URL::to('admin/admin-languages-transulates') }}"><i class="las la-eye"></i>Manage Translate Languages</a></li> --}}
                     </ul>
                  </li>
                   
                   <li><a href="{{ URL::to('admin/sliders') }}" class="iq-waves-effect"><img class="" src="<?php echo  URL::to('/assets/img/icon/slider.svg')?>"><span> Sliders</span></a></li>
                   <!-- <li><a href="{{ URL::to('admin/payment_test') }}" class="iq-waves-effect"><i class="la la-sliders"></i><span> Test Payment Setting</span></a></li> -->

                    <div class="men">
                   
                   <p class="lnk" >Site</p>
                       </div>
                   <li><a href="{{ URL::to('admin/players') }}" class="iq-waves-effect"><img class="ply" src="<?php echo  URL::to('/assets/img/icon/ply.svg')?>"><span>Player UI</span></a></li>

                   <li>
                     <a href="#moderators" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="ply" src="<?php echo  URL::to('/assets/img/icon/mod.svg')?>"><span>Content Partners</span><i
                        class="ri-arrow-right-s-line iq-arrow-right"></i>
                     </a>
                     <ul id="moderators" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ URL::to('moderator') }}"><i class="las la-user-plus"></i>Add Content Partners</a></li>
                        <li><a href="{{ URL::to('admin/moderator-details') }}">Content Details</a></li>
                        <li><a href="{{ URL::to('admin/allmoderator') }}"><i class="las la-eye"></i>View Content Partners</a></li>
                        <li><a href="{{ URL::to('admin/cpp/pendingusers/') }}"><i class="las la-eye"></i>Content Partners For Approval</a></li>
                         <li><a href="{{ URL::to('admin/moderator/role') }}"><i class="las la-eye"></i>Add Role</a></li>
                        <li><a href="{{ URL::to('admin/moderator/Allview') }}"><i class="las la-eye"></i>View Role</a></li>
                        <li><a href="{{ URL::to('admin/moderator/commission') }}"><i class="las la-eye"></i>Commission </a></li>
                        <li><a href="{{ URL::to('admin/moderator/payouts') }}"><i class="las la-eye"></i>Content Partners Payout</a></li>

                     </ul>
                  </li>
                  <li>
                     <a href="#channel" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="ply" height="40" width="40" src="<?php echo  URL::to('/assets/img/icon/cpl.svg')?>"><span>Channel Partners</span><i
                        class="ri-arrow-right-s-line iq-arrow-right"></i>
                     </a>
                     <ul id="channel" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ URL::to('admin/channel/user/create/') }}">Add Channel Partners </a></li>
                        <li><a href="{{ URL::to('admin/channel/view-channel-members/') }}">View Channel Partners </a></li>
                        <li><a href="{{ URL::to('admin/channel/pendingusers/') }}">Channel Partners For Approval</a></li>
                        <li><a href="{{ URL::to('admin/channel/commission') }}">Commission </a></li>
                        <li><a href="{{ URL::to('admin/channel/payouts') }}">Channel Partners Payout</a></li>
                        {{-- <li><a href="{{ route('channel_package_index') }}">Channel Package</a></li>
                        <li><a href="{{ route('channel_package_index') }}">Channel Package</a></li> --}}
                     </ul>
                  </li>
                  <li>
                     <a href="#pages" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="" src="<?php echo  URL::to('/assets/img/icon/page.svg')?>"><span>Pages</span><i
                        class="ri-arrow-right-s-line iq-arrow-right"></i>
                     </a>
                     <ul id="pages" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ URL::to('admin/pages') }}"><i class="las la-user-plus"></i>All Pages</a></li>
                        <li><a href="{{ route('landing_page_index') }}">Landing Page</a></li>
                        <li><a href="{{ route('landing_page_create') }}">Create Landing Page</a></li>
                     </ul>
                  </li>
                   
                    <li>
                     <a href="#plans" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="" src="<?php echo  URL::to('/assets/img/icon/plan.svg')?>"><span>Plans</span><i
                        class="ri-arrow-right-s-line iq-arrow-right"></i>
                     </a>
                     <ul id="plans" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <!-- <li><a href="{{ URL::to('admin/plans') }}"><i class="las la-user-plus"></i>Manage Stripe plans</a></li>
                        <li><a href="{{ URL::to('admin/paypalplans') }}"><i class="las la-eye"></i>Manage Paypal plans</a></li> -->
                        <li><a href="{{ URL::to('admin/subscription-plans') }}"><i class="las la-eye"></i>Manage Subscription plans</a></li>
                        <li><a href="{{ route('inapp_purchase') }}"><img height="30" width="30"  class="mr-2" src="<?php echo  URL::to('/assets/img/icon/manage-sub.svg')?>">Manage In App Purchase Plans</a></li>
                        <li><a href="{{ route('Life-time-subscription-index') }}"> Life time subscription </a></li>
                         <!-- <li><a href="{{ URL::to('admin/coupons') }}"><i class="las la-eye"></i>Manage Stripe Coupons</a></li> -->
                         <li><a href="{{ URL::to('admin/devices') }}"><i class="las la-eye"></i>Devices</a></li>

                     </ul>
                  </li>
                  
                  <li>
                     <a href="#payment_managements" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="ply" src="<?php echo  URL::to('/assets/img/icon/pay.svg')?>"><span>Payment Management</span><i
                        class="ri-arrow-right-s-line iq-arrow-right"></i>
                     </a>
                     <ul id="payment_managements" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ URL::to('admin/payment/total_revenue') }}"><i class="las la-user-plus"></i>Total Revenues</a></li>
                        <li><a href="{{ URL::to('admin/payment/subscription') }}"><i class="las la-eye"></i>Subscription Payments</a></li>
                         <li><a href="{{ URL::to('admin/payment/PayPerView') }}"><i class="las la-eye"></i>PayPerView Payments</a></li>
                     </ul>
                  </li>
                  <div >
                  <!-- <p class="" style="color:#0993D2!important;padding-left:30px;font-weight: 600;">Analytics</p></div> -->
                    <li>
                     <a href="#analytics_managements" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="" src="<?php echo  URL::to('/assets/img/icon/ana.svg')?>"><span>Analytics</span><i
                        class="ri-arrow-right-s-line iq-arrow-right"></i>
                     </a>
                     <ul id="analytics_managements" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ URL::to('admin/analytics/revenue') }}"><i class="las la-user-plus"></i>Users Analytics </a></li>
                        <li><a href="{{ URL::to('admin/users/revenue') }}"><i class="las la-user-plus"></i>Users Revenue </a></li>
                        <li><a href="{{ URL::to('admin/video/purchased-analytics') }}"><i class="las la-user-plus"></i>Purchased Video Analytics </a></li>
                        <li><a href="{{ URL::to('admin/cpp/analytics') }}"><i class="las la-user-plus"></i>CPP Analytics </a></li>
                        <li><a href="{{ URL::to('admin/cpp/video-analytics') }}"><i class="las la-user-plus"></i>CPP Video Analytics </a></li>
                        <li><a href="{{ URL::to('admin/cpp/revenue') }}"><i class="las la-user-plus"></i>CPP Revenue </a></li>
                        <li><a href="{{ URL::to('admin/analytics/ViewsRegion') }}"><i class="las la-eye"></i>Views By Region</a></li>
                         <li><a href="{{ URL::to('admin/analytics/RevenueRegion') }}"><i class="las la-eye"></i>Revenue by Region</a></li>
                        <li><a href="{{ URL::to('admin/live/purchased-analytics') }}">Purchased LiveStream Analytics </a></li>
                     </ul>
                  </li>
                  <div >
                    <li>
                     <a href="#settings" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="ply" src="<?php echo  URL::to('/assets/img/icon/setting.svg')?>"><span>Settings</span><i
                        class="ri-arrow-right-s-line iq-arrow-right"></i>
                     </a>
                     <ul id="settings" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li  data-tour="step: 4; title: Storefront Settings; content: Go to Settings to choose different monetization methods Subscription, Pay Per View, PPV Bundles, Coupons, etc for your content or make them free" class=" " data-tour="step: 4; title: Promo code; content: Go to Settings to choose different monetization methods Subscription, Pay Per View, PPV Bundles, Coupons, etc for your content or make them free" ><a href="{{ URL::to('admin/settings') }}"><i class="las la-eye"></i>Storefront Settings</a></li>
                            <li><a href="{{ URL::to('admin/home-settings') }}"><i class="las la-eye"></i>HomePage Settings</a></li>
                            <li><a href="{{ URL::to('admin/linking_settings/') }}"><i class="las la-eye"></i>Link Settings</a></li>
                           <li><a href="{{ URL::to('admin/age/index') }}" class="iq-waves-effect">Manage Age</a></li>
                            <!-- <li><a href="{{ URL::to('admin/order-home-settings') }}"><i class="las la-eye"></i>Order HomePage Settings</a></li> -->
                            <li><a href="{{ URL::to('admin/theme_settings') }}"><i class="las la-eye"></i>Theme Settings</a></li>
                            <li><a href="{{ route('admin_slider_index') }}">Slider </a></li>

                            {{-- <li><a href="{{ URL::to('admin/payment_settings') }}"><i class="las la-eye"></i>Payment Settings</a></li> --}}
                            <li><a href="{{ URL::to('admin/email_settings') }}"><i class="las la-eye"></i>Email Settings</a></li>
                            <li><a href="{{ URL::to('admin/storage_settings') }}"><i class="las la-eye"></i>Storage Settings</a></li>
                            <!-- <li><a href="{{ URL::to('admin/email_template') }}"><i class="las la-eye"></i>Email Template</a></li> -->
                            <li><a href="{{ URL::to('admin/mobileapp') }}"><i class="las la-user-plus"></i>Mobile App Settings</a></li>
                            <li><a href="{{ URL::to('admin/system_settings') }}"><i class="las la-eye"></i>Social Login Settings</a></li>
                            <li><a href="{{ URL::to('admin/currency_settings') }}"><i class="las la-eye"></i>Currency Settings</a></li>
                            <li><a href="{{ URL::to('admin/revenue_settings/index') }}"><i class="las la-eye"></i>Revenue Settings</a></li>
                            <li><a href="{{ URL::to('admin/ThumbnailSetting') }}" class="iq-waves-effect"><i class="ri-price-tag-line"></i>Thumbnail Settings</a></li>
                            <li><a href="{{ URL::to('admin/ChooseProfileScreen') }}" class="iq-waves-effect"><i class="ri-price-tag-line"></i>Profile Screen</a></li>
                            {{-- <li  data-tour="step: 3; title: Manage Theme; content: Go to 'Manage Template' to choose a template for our website from our catalogue" class=" " data-tour="step: 3; title: Manage Theme; content: Go to 'Manage Template' to choose a template for our website from our catalogue"><a href="{{ URL::to('admin/ThemeIntegration') }}" class="iq-waves-effect"><i class="ri-price-tag-line"></i>Theme</a></li> --}}
                            <li><a href="{{ route('compress_image') }}" class="iq-waves-effect">Image Setting </a></li>
                            <li><a href="{{ route('admin.OTP-Credentials-index') }}" class="iq-waves-effect">{{ (__('OTP Credentials')) }} </a></li>
                            <li><a href="{{ route('partner_monetization_settings') }}" class="iq-waves-effect">{{ (__('Partner Monetization Settings')) }} </a></li>
                            
                           @if ( Auth::user()->plan_name == 'SuperAdmin')
                              <li><a href="{{ route('admin.users-package') }}" class="iq-waves-effect">{{ (__('Users Package Management')) }} </a></li>
                           @endif
                     </ul>
                  </li>
                  <!-- Ads Menu starts -->
               @if($settings->ads_on_videos == 1)
                  <div class="men">
                  <p class="lnk" >Ads Management</p>
                  </div>
                  <li>
                     <a href="#Advertiser" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="" src="<?php echo  URL::to('/assets/img/icon/user.svg')?>"><span>Manage Advertiser </span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                     <ul id="Advertiser" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                           <li><a href="{{ URL::to('admin/advertisers') }}"><i class="las la-user-plus"></i>Advertisers</a></li>
                     </ul>
                  </li>

                  <li><a href="{{ URL::to('admin/ads_categories') }}" class="iq-waves-effect"><img class="" src="<?php echo  URL::to('/assets/img/icon/ad.svg')?>"><span>Ads Categories</span></a></li>

                  <li><a href="{{ URL::to('admin/ads_list') }}" class="iq-waves-effect"><img class="" src="<?php echo  URL::to('/assets/img/icon/ad2.svg')?>"><span>Ads List</span></a></li>

                  <li><a href="{{ URL::to('admin/ads_plans') }}" class="iq-waves-effect"><img class="" src="<?php echo  URL::to('/assets/img/icon/ad3.svg')?>"><span> Ads Plans</span></a></li>

                  <li><a href="{{ URL::to('admin/ads_revenue') }}" class="iq-waves-effect"><img class="" src="<?php echo  URL::to('/assets/img/icon/ana.svg')?>"><span> Ads Revenue</span></a></li>

                  <li><a href="{{ URL::to('admin/calendar-event') }}" class="iq-waves-effect"><img  height="40" width="40" class="" src="<?php echo  URL::to('/assets/img/icon/calender.svg')?>"><span> Calendar Events</span></a></li>
                  
                  <li><a href="{{ URL::to('admin/Ads-TimeSlot') }}" class="iq-waves-effect"><img  height="40" width="40" class="" src="<?php echo  URL::to('/assets/img/icon/campin.svg')?>"><span> Ad Time Slot</span></a></li>

                  <li><a href="{{ route('admin.ads_banners') }}" class="iq-waves-effect"><img  height="40" width="40" class="" src="<?php echo  URL::to('/assets/img/icon/campin.svg')?>"><span> Ad Banners</span></a></li>

                  <li><a href="{{ route('admin.ads_variable') }}" class="iq-waves-effect"><img  height="40" width="40" class="" src="<?php echo  URL::to('/assets/img/icon/campin.svg')?>"><span> Ad variable</span></a></li>

               @endif


                    {{-- Geo Fencing --}}
               <p class="lnk">Geo Fencing</p>

               <li><a href="{{ URL::to('admin/Geofencing') }}" class="iq-waves-effect"><img class="" src="<?php echo  URL::to('/assets/img/icon/geo.svg')?>"><span> Manage Geo Fencing</span></a></li>

               <li><a href="{{ URL::to('admin/countries') }}" class="iq-waves-effect"><img class="" src="<?php echo  URL::to('/assets/img/icon/geo2.svg')?>"><span>Manage Countries</span></a></li>

                  {{-- Clear cache  --}}
                  <li><p class="lnk">Configurations</p></li>

                  <li><a href="{{ route('clear_cache') }}" class="iq-waves-effect">
                        <img height="30" width="30" class="ply" src="<?php echo  URL::to('/assets/img/icon/cc.svg')?>">
                        <span> Cache Management </span>
                     </a>
                  </li>

                  <li><a href="{{ route('env_index') }}" class="iq-waves-effect">
                     <img height="30" width="30" class="" src="<?php echo  URL::to('/assets/img/icon/cc.svg')?>">
                        <span> Debug  </span>
                     </a>
                  </li>

                  <!-- <li><a href="{{ route('access_forbidden') }}" class="iq-waves-effect">
                     <img height="30" width="30" class="" src="<?php echo  URL::to('/assets/img/icon/cc.svg')?>">
                        <span> {{ __('Restrict Access') }}  </span>
                     </a>
                  </li> -->

                  <li><a href="{{ route('seeding-index') }}" class="iq-waves-effect">
                     <img height="30" width="30" class="ply" src="<?php echo  URL::to('/assets/img/icon/cc.svg')?>">
                        <span> Seeding Management  </span>
                     </a>
                  </li>

               
                  <!-- {{-- Contact Us --}} -->
                  <li><p class="lnk">CONTACT US</p></li>

                  <li><a href="{{ URL::to('admin/contact-us/') }}" class="iq-waves-effect">
                        <img height="30" width="30" class="" src="<?php echo  URL::to('/assets/img/icon/cq.svg')?>">
                        <span> Contact Request</span>
                     </a>
                  </li>

                  <!-- {{-- Log Activity --}} -->
                  <li><p class="lnk">Log Activity</p></li>

                  <li><a href="{{ URL::to('admin/UploadlogActivity') }}" class="iq-waves-effect">
                        <img class="ply" height="30" width="30" class="" src="<?php echo  URL::to('/assets/img/icon/upload.svg')?>">
                        <span>Upload Log Activity</span>
                     </a>
                  </li>
                  <li><a href="{{ URL::to('admin/deleted-log') }}" class="iq-waves-effect">
                        <img class="ply" height="30" width="30" class="" src="<?php echo  URL::to('/assets/img/icon/delete.svg')?>">
                        <span>Delete Log</span>
                     </a>
                  </li>

                  <li><a href="{{ URL::to('admin/logActivity') }}" class="iq-waves-effect">
                        <img class="ply" height="30" width="30" class="" src="<?php echo  URL::to('/assets/img/icon/geo.svg')?>">
                        <span>Site Log Activity</span>
                     </a>
                  </li>
                  

                  <!-- Ads Menu ends -->
                  <?php }elseif(  $package == "Business" && auth()->user()->role == "admin" || $package == "Business" && auth()->user()->role == "subscriber" || $package == "Business" && auth()->user()->role == "registered" || $package == "Pro" && auth()->user()->role == "admin"){ ?>
                     <div class="page-container sidebar-collapsed"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
<!-- Sidebar 3-->
      <div class="iq-sidebar">
         <div class="iq-sidebar- d-flex justify-content-between align-items-center mt-2">
            <a href="<?php echo URL::to('home') ?>" class="header-logo">
               <img src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo ; ?>" class="c-logo" alt="" width="200px" height="100px" style="object-fit:contain;">
               <div class="logo-title">
                  <span class="text-primary text-uppercase"></span>
               </div>
            </a>
            <div class="iq-menu-bt-sidebar">
               <div class="iq-menu-bt align-self-center">
                  <div class="wrapper-menu">
                     <div class="main-circle"><i class="las la-bars"></i></div>
                  </div>
               </div>
            </div>
         </div>
         <div id="sidebar-scrollbar">
            <nav class="iq-sidebar-menu">
               <ul id="iq-sidebar-toggle" class="iq-menu">
                  <li class="" ><a href="<?php echo URL::to('admin') ?>" class="iq-waves-effect"> <img class="ply" height="40" width="40" src="<?php echo  URL::to('/assets/img/icon/home.svg')?>"> <span class=""> {{ (__('Dashboard')) }} </span></a></li>
                   <div class="bod"></div>
                   <div class="men" style="">
                 
                   <p class="lnk" >{{ (__('Video')) }}</p>
                   </div>
                   <li data-tour="step: 1; title: All Videos; content: Go to 'Video Library' to add or import content into content library" class=" " data-tour="step: 1; title: All Videos; content: Go to 'Video Library' to add or import content into content library"><a href="#video" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="ply" height="40" width="40" src="<?php echo  URL::to('/assets/img/E360_icons/Video management.svg')?>"> <span class="">{{ (__('Video Management')) }} </span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                   <ul id="video" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                         <li><a href="{{ URL::to('admin/videos') }}">{{ (__('All Videos')) }}</a></li>
                        <li><a href="{{ URL::to('admin/videos/create') }}">{{ (__('Add New Video')) }}</a></li>
                        <li><a href="{{ URL::to('admin/CPPVideosIndex') }}">{{ (__('Videos For Approval')) }}</a></li>
                        <li><a href="{{ URL::to('admin/Masterlist') }}" class="iq-waves-effect">{{ (__('Master Video List')) }}</a></li>
                        <li><a href="{{ URL::to('admin/video-schedule') }}" class="iq-waves-effect">{{ (__('Video Schedule')) }}</a></li>
                        <!-- <li><a href="{{ URL::to('admin/test/videoupload') }}" class="iq-waves-effect">Test Server Video Upload</a></li> -->
                        <li><a href="{{ URL::to('admin/assign_videos/partner') }}" class="iq-waves-effect">Move Videos to Partner</a></li>
                        <li data-tour="step: 2; title: Video Category; content: Go to 'Manage Categories' to setup your content categories" class=" " data-tour="step: 2; title: Video Category; content: Go to 'Manage Categories' to setup your content categories"><a href="{{ URL::to('admin/videos/categories') }}">{{ (__('Manage Video Categories')) }}</a></li>                    
                        @if(!empty(@$AdminAccessPermission) && @$AdminAccessPermission->Video_Manage_Video_Playlist_checkout == 1)
                           <li><a href="{{ URL::to('admin/videos/playlist') }}" class="iq-waves-effect">{{ (__('Manage Video Playlist')) }}</a></li>
                        @endif 
                        @if(!empty(@$AdminAccessPermission) && @$AdminAccessPermission->music_genre_checkout == 1)
                           <li><a href="{{ URL::to('admin/Music/Genre') }}" class="iq-waves-effect">{{ (__('Manage Music Genre')) }}</a></li>
                        @endif 
                        <li><a href="{{ URL::to('admin/transcoding-management') }}" class="iq-waves-effect">{{ (__('Transcoding Management')) }}</a></li>


                    
          </ul></li>
          @if(!empty(@$AdminAccessPermission) && @$AdminAccessPermission->Video_Channel_checkout == 1 || @$AdminAccessPermission->Video_Channel_Video_Scheduler_checkout == 1 || EPG_Status() == 1 )
            <li><a href="#contentchannel" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="ply" height="40" width="40" src="<?php echo  URL::to('/assets/img/E360_icons/Channel management.svg')?>"><span class="">{{ (__('Channel Management')) }} </span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
               <ul id="contentchannel" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
               @if(!empty(@$AdminAccessPermission) && @$AdminAccessPermission->Video_Channel_checkout == 1)
                  <li><a href="{{ route('admin.Channel.index') }}" class="iq-waves-effect">Channel </a></li> 
               @endif      
               @if(!empty(@$AdminAccessPermission) && @$AdminAccessPermission->Video_Channel_Video_Scheduler_checkout == 1)
                  <li><a href="{{ route('VideoScheduler') }}" class="iq-waves-effect">Channel Video Scheduler </a></li>
               @endif   
               @if (EPG_Status() == 1)
                  <li><a href="{{ route('admin.epg.index') }}" class="iq-waves-effect"> EPG </a></li>
               @endif    
               </ul>
            </li>
            @endif    
          <li>
          <li><a href="#series" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="ply" height="40" width="40" src="<?php echo  URL::to('/assets/img/E360_icons/Tv_Shows.svg')?>"><span class="">{{ (__('TV Shows')) }} </span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
            <ul id="series" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
              <li><a href="{{ URL::to('admin/series-list') }}">{{ (__('List TV Shows ')) }}</a></li>
              <li data-tour="step: 2; title: Video Category; content: Go to 'Manage Categories' to setup your content categories" class=" " data-tour="step: 2; title: Video Category; content: Go to 'Manage Categories' to setup your content categories"><a href="{{ URL::to('admin/Series/Genre') }}">{{ (__('Manage Genre')) }}</a></li>                    
               @if (Series_Networks_Status() == 1 )
                  <li><a href="{{ route('admin.Network_index') }}">Manage Networks</a></li>
               @endif              <li><a href="{{ URL::to('admin/CPPSeriesIndex') }}">{{ (__('TV Shows For Approval')) }}</a></li>
              <li><a href="{{ URL::to('admin/assign_Series/partner') }}" class="iq-waves-effect">{{ (__('Move TV Shows to Partner')) }}</a></li>

            </ul>
          </li>
          @if(!empty(@$AdminAccessPermission) && @$AdminAccessPermission->enable_ugc_management == 1)
          <li><a href="#ugcmanagement" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="ply" height="40" width="40" src="<?php echo  URL::to('/assets/img/E360_icons/Channel management.svg')?>"><span class="">{{ (__('UGC Management')) }} </span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
            <ul id="ugcmanagement" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
               <li><a href="{{ route('ugcvideos') }}" class="iq-waves-effect">All UGC Videos</a></li> 
               <li><a href="{{ route('ugcvideos_index') }}" class="iq-waves-effect">UGC Videos For Approval</a></li>
            </ul>
         </li>
         @endif  

                  {{--Radio Station --}}
         <li>
            @if(!empty(@$AdminAccessPermission) && @$AdminAccessPermission->enable_radiostation == 1)

               <div class="men" style="">
                  <p class="lnk" >{{ (__('Radio Station')) }}</p>
               </div>

               <a href="#radio_station" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false">
                  <img class="ply" height="40" width="40" src="{{  URL::to('/assets/img/E360_icons/Manage Live stream.svg') }}"> 
                  <span class="">{{ (__('Radio Station Management')) }} </span><i class="ri-arrow-right-s-line iq-arrow-right"></i>
               </a>
               
               <ul id="radio_station" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                  <li><a href="{{ route('admin.radio-station.index') }}">{{ (__('All Radio station')) }}</a></li>
                  <li><a href="{{ route('admin.radio-station.create') }}">{{ (__('Add New Radio station')) }}</a></li>
               </ul>
            @endif
         </li>


           {{--Live Stream  --}}

         <li>
            <div class="men" style=""> 
               <p class="lnk" >{{ (__('Live Stream')) }}</p>
            </div>

            <a href="#live-video" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false">
               <img height="40" width="40" class="ply" src="{{ URL::to('/assets/img/E360_icons/Manage Live stream.svg') }}">
               <span class="">{{ (__('Manage Live Stream')) }}</span><i class="ri-arrow-right-s-line iq-arrow-right"></i>
            </a>

            <ul id="live-video" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
               <li><a href="{{ route('admin.livestream.index') }}" >{{ (__('All Live Stream')) }}</a></li>
               <li><a href="{{ route('admin.livestream.create') }}">{{ (__('Add New Live Stream')) }}</a></li>
               <li><a href="{{ URL::to('admin/CPPLiveVideosIndex') }}">{{ (__('Live Stream For Approval')) }}</a></li>
               <li><a href="{{ URL::to('admin/livestream/categories') }}">{{ (__('Manage Live Stream Categories')) }}</a></li>
               <li><a href="{{ route('live_event_artist') }}">{{ (__('Live Event Artist')) }}  </a></li>
               {{-- <li><a href="{{ route('livestream_calendar') }}">{{ (__('Live Calendar')) }}  </a></li> --}}
            </ul>
         </li>

            

                  <div class="men" style=""> 

                    <div class="men" style="">
                  
                        <p class="lnk" >{{ (__('Audio')) }} </p></div>
          <li><a href="#audios" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="ply" height="40" width="40" src="<?php echo  URL::to('/assets/img/E360_icons/Audi Manager.svg')?>"><span class="">{{ (__('Audio Management')) }} </span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
            <ul id="audios" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
              <li><a href="{{ URL::to('admin/audios') }}">{{ (__('Audio List')) }}</a></li>
              <li><a href="{{ URL::to('admin/audios/create') }}">{{ (__('Add New Audio')) }}</a></li>
              <li><a href="{{ URL::to('admin/CPPAudioIndex') }}">{{ (__('Audios For Approval')) }}</a></li>
              <li><a href="{{ URL::to('admin/audios/categories') }}">{{ (__('Manage Audio Categories')) }}</a></li>
              <li><a href="{{ URL::to('admin/audios/albums') }}">{{ (__('Manage Albums')) }}</a></li>
            </ul>
          </li>
          <li><a href="#artists" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img height="40" width="40" class="ply" src="<?php echo  URL::to('/assets/img/E360_icons/Artist Management.svg')?>"><span>{{ (__('Artist Management')) }} </span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
            <ul id="artists" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
              <li><a href="{{ URL::to('admin/artists') }}">{{ (__('All Artists')) }}</a></li>
              <li><a href="{{ URL::to('admin/artists/create') }}">{{ (__('Add New Artist')) }} </a></li>
              @if(!empty(@$AdminAccessPermission) && @$AdminAccessPermission->writer_checkout == 1)
                  <li><a href="{{ URL::to('admin/Writer') }}">{{ (__('All Writer')) }}</a></li>
                  <li><a href="{{ URL::to('admin/Writer/create') }}">{{ (__('Add New Writer')) }} </a></li>
              @endif    

            </ul>
          </li>
          
               @if(!empty(@$AdminAccessPermission) && @$AdminAccessPermission->document_category_checkout == 1 || @$AdminAccessPermission->document_upload_checkout == 1 || @$AdminAccessPermission->document_list_checkout == 1)
                  <div class="men">
                     <p class="lnk" >{{ (__('Documents Management')) }}</p>
                  </div>
                  @if(!empty(@$AdminAccessPermission) && @$AdminAccessPermission->document_category_checkout == 1)
                     <li><a href="{{ URL::to('admin/document/genre') }}" class="iq-waves-effect"><img class="ply" src="<?php echo  URL::to('/assets/img/E360_icons/Menu.svg')?>"heigth="40" width="40"><span>{{ (__('Document Genre')) }}</span></a></li>
                  @endif    
                  @if(!empty(@$AdminAccessPermission) && @$AdminAccessPermission->document_upload_checkout == 1)
                  <li><a href="{{ URL::to('admin/document/upload') }}" class="iq-waves-effect"><img class="ply" src="<?php echo  URL::to('/assets/img/E360_icons/Signup.svg')?>"heigth="40" width="40"><span>{{ (__('Document Upload')) }}</span></a></li>
                  @endif 
                  @if(!empty(@$AdminAccessPermission) && @$AdminAccessPermission->document_list_checkout == 1)
                  <li><a href="{{ URL::to('/admin/document/list') }}" class="iq-waves-effect"><img class="" src="<?php echo  URL::to('/assets/img/icon/file.svg')?>" heigth="40" width="40"><span>{{ (__('Document List')) }}</span></a></li>
                  @endif 
               @endif  
                 
                    <div class="men">
                        <p class="lnk" >{{ (__('Accounts')) }}</p>
                     </div>

                     <li>
                       <a href="#user" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img height="40" width="40" class="" src="<?php echo  URL::to('/assets/img/icon/user.svg')?>"><span>{{ (__('Users')) }}</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                       <ul id="user" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                           <li><a href="{{ URL::to('admin/users') }}">{{ (__('All Users')) }}</a></li>
                           <li><a href="{{ URL::to('admin/users-statistics') }}">{{ (__('Users Stats')) }}</a></li>
                           <li><a href="{{ URL::to('admin/user/create') }}">{{ (__('Add New User')) }}</a></li>
                           <li><a href="{{ route('import_users_view') }}">{{ (__('Import Users')) }}  </a></li>
                           <li><a href="{{ URL::to('admin/MultiUser-limit') }}">{{ (__('Multi User Management')) }}</a></li>
                        </ul>
                     </li>

                   <li><a href="{{ URL::to('admin/menu') }}" class="iq-waves-effect"><img class="ply" src="<?php echo  URL::to('/assets/img/E360_icons/Menu.svg')?>"heigth="40" width="40"><span>{{ (__('Menu')) }}</span></a></li>
                   <li><a href="{{ URL::to('admin/signup') }}" class="iq-waves-effect"><img class="ply" src="<?php echo  URL::to('/assets/img/E360_icons/Signup.svg')?>"heigth="40" width="40"><span>{{ (__('Signup Menu')) }}</span></a></li>
                   <li><a href="{{ route('cppsignupindex') }}" class="iq-waves-effect"><img class="" src="<?php echo  URL::to('/assets/img/E360_icons/Signup.svg')?>"heigth="40" width="40"><span>{{ (__('CPP Signup Menu')) }}</span></a></li>
                   <li><a href="{{ route('channelsignupindex') }}" class="iq-waves-effect"><img class="" src="<?php echo  URL::to('/assets/img/E360_icons/Signup.svg')?>"heigth="40" width="40"><span>{{ (__('Channel Signup Menu')) }}</span></a></li>
                   <!--<li><a href="{{ URL::to('/admin/filemanager') }}" class="iq-waves-effect"><img class="" src="<?php echo  URL::to('/assets/img/icon/file.svg')?>" heigth="40" width="40"><span>Filemanager</span></a></li>-->

                     <li>
                        <div class="men" style="">
                           <p class="lnk" >{{ (__('Transaction Details')) }}</p>
                        </div>

                        <a href="#transaction_details" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false">
                           <img class="ply" height="40" width="40" src="<?php echo  URL::to('/assets/img/E360_icons/Payment Management.svg')?>"> 
                           <span class="">{{ (__('Transaction Management')) }} </span><i class="ri-arrow-right-s-line iq-arrow-right"></i>
                        </a>
                        
                        <ul id="transaction_details" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                           <li><a href="{{ route('admin.transaction-details.index') }}">{{ (__('All Transactions')) }}</a></li>
                           <li><a href="{{ URL::to('admin/payment/total_revenue') }}">{{ (__('Total Revenues')) }}</a></li>
                           <li><a href="{{ URL::to('admin/payment/subscription') }}">{{ (__('Subscription Payments')) }}</a></li>
                            <li><a href="{{ URL::to('admin/payment/PayPerView') }}">{{ (__('PayPerView Payments')) }}</a></li>
                        </ul>

                        <a href="#parnter_monetization_payouts" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false">
                           <img class="ply" height="40" width="40" src="{{  URL::to('/assets/img/E360_icons/Manage Live stream.svg') }}"> 
                           <span class="">{{ (__('Partner Payout Management')) }} </span><i class="ri-arrow-right-s-line iq-arrow-right"></i>
                        </a>
                        
                        <ul id="parnter_monetization_payouts" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                           <li><a href="{{ route('partner-monetization-payouts') }}">{{ (__('Partner Payouts')) }}</a></li>
                           <li><a href="{{ route('partner-monetization-analytics') }}">{{ (__('Partner Payouts Analytics')) }}</a></li>
                           <li><a href="{{ route('partner-monetization-history') }}">{{ (__('Partner Payment History')) }}</a></li>
                        </ul>
                     </li>
               
                    <div >
                
                   <p class="lnk" >{{ (__('Language')) }}</p>
                       </div>
                  <li>
                     <a href="#language" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img height="40" width="40"  class="ply" src="<?php echo  URL::to('/assets/img/E360_icons/Manage Language.svg')?>"><span>{{ (__('Manage Languages')) }} </span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                     <ul id="language" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ URL::to('admin/admin-languages') }}">{{ (__('Video Languages')) }}</a></li>
                        <li><a href="{{ URL::to('admin/subtitles/create') }}">{{ (__('Add Subtitle Languages')) }}</a></li>
                        @if(!empty(@$AdminAccessPermission) && @$AdminAccessPermission->Manage_Translate_Languages_checkout == 1)
                           <li><a href="{{ URL::to('admin/translate-languages-index') }}">{{ (__('Manage Translate Languages')) }}</a></li> 
                        @endif 
                        @if(!empty(@$AdminAccessPermission) && @$AdminAccessPermission->Manage_Translations_checkout == 1)
                           <li><a href="{{ URL::to('admin/languages') }}">{{ (__('Manage Translations')) }}</a></li>
                        @endif 
                     </ul>
                  </li>
                   
                   <li><a href="{{ URL::to('admin/sliders') }}" class="iq-waves-effect"><img height="40" width="40" class="ply" src="<?php echo  URL::to('/assets/img/E360_icons/Sliders.svg')?>"><span>{{ (__('Sliders')) }}</span></a></li>
                   <!-- <li><a href="{{ URL::to('admin/payment_test') }}" class="iq-waves-effect"><i class="la la-sliders"></i><span> Test Payment Setting</span></a></li> -->

                    <div class="men">
                   
                   <p class="lnk" >{{ (__('Site')) }}</p>
                       </div>
                   <li><a href="{{ URL::to('admin/players') }}" class="iq-waves-effect"><img height="40" width="40" class="ply" src="<?php echo  URL::to('/assets/img/E360_icons/Players UI.svg')?>"><span>{{ (__('Player UI')) }}</span></a></li>
                   <li>
                     <a href="#moderators" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="ply" height="40" width="40" src="<?php echo  URL::to('/assets/img/E360_icons/Content Partner.svg')?>"><span>{{ (__('Content Partners')) }}</span><i
                        class="ri-arrow-right-s-line iq-arrow-right"></i>
                     </a>
                     <ul id="moderators" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ URL::to('moderator') }}">{{ (__('Add Content Partners')) }}</a></li>
                        <li><a href="{{ URL::to('admin/moderator-details') }}">{{ (__('Content Details')) }}</a></li>
                        <li><a href="{{ URL::to('admin/allmoderator') }}">{{ (__('View Content Partners')) }}</a></li>
                        <li><a href="{{ URL::to('admin/cpp/pendingusers/') }}">{{ (__('Content Partners For Approval')) }}</a></li>
                         <li><a href="{{ URL::to('admin/moderator/role') }}">{{ (__('Add Role')) }}</a></li>
                         <li><a href="{{ URL::to('admin/moderator/Allview') }}">{{ (__('View Role')) }}</a></li>
                         <li><a href="{{ URL::to('admin/moderator/commission') }}">{{ (__('Commission')) }} </a></li>
                        <li><a href="{{ URL::to('admin/moderator/payouts') }}">{{ (__('Content Partners Payout')) }}</a></li>
                        <li><a href="{{ URL::to('admin/moderator-subscription-plans') }}">{{ (__('Moderator Subscription Plans')) }}</a></li>
                     </ul>
                  </li>
                  <li>
                     <a href="#channel" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="ply" height="40" width="40" src="<?php echo  URL::to('/assets/img/icon/cpl.svg')?>"><span>{{ (__('Channel Partners')) }}</span><i
                        class="ri-arrow-right-s-line iq-arrow-right"></i>
                     </a>
                     <ul id="channel" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                     <li><a href="{{ URL::to('admin/channel/user/create/') }}">{{ (__('Add Channel Partners')) }} </a></li>
                     <li><a href="{{ URL::to('admin/channel/view-channel-members/') }}">{{ (__('View Channel Partners')) }} </a></li>
                        <li><a href="{{ URL::to('admin/channel/pendingusers/') }}">{{ (__('Channel Partners For Approval')) }}</a></li>
                        <li><a href="{{ URL::to('admin/channel/commission') }}">{{ (__('Commission')) }} </a></li>
                        <li><a href="{{ URL::to('admin/channel/payouts') }}">{{ (__('Channel Partners Payout')) }}</a></li>
                        {{-- <li><a href="{{ route('channel_package_index') }}">{{ (__('Channel Package')) }}</a></li> --}}
                        <li><a href="{{ URL::to('admin/channel/role') }}">{{ (__('Channel Partners Add Roles')) }}</a></li>
                        <li><a href="{{ URL::to('admin/channel/role/view') }}">{{ (__('Channel Partners Roles')) }}</a></li>
                        <li><a href="{{ URL::to('admin/channel-subscription-plans') }}">{{ (__('Channel Subscription Plans')) }}</a></li>
                     </ul>
                  </li>
                  <li>
                     <a href="#pages" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img height="40" width="40" class="ply" src="<?php echo  URL::to('/assets/img/E360_icons/Pages.svg')?>"><span>{{ (__('Pages')) }}</span><i
                        class="ri-arrow-right-s-line iq-arrow-right"></i>
                     </a>
                     <ul id="pages" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ URL::to('admin/pages') }}">{{ (__('All Pages')) }}</a></li>
                        <li><a href="{{ route('landing_page_index') }}">{{ (__('Landing Page')) }}</a></li>
                        <li><a href="{{ route('landing_page_create') }}">{{ (__('Create Landing Page')) }}</a></li>
                     </ul>
                  </li>
                   
                    <li>
                     <a href="#plans" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img height="40" width="40" class="ply" src="<?php echo  URL::to('/assets/img/E360_icons/Plans.svg')?>"><span>{{ (__('Plans')) }}</span><i
                        class="ri-arrow-right-s-line iq-arrow-right"></i>
                     </a>
                     <ul id="plans" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <!-- <li><a href="{{ URL::to('admin/plans') }}"><i class="las la-user-plus"></i>Manage Stripe plans</a></li>
                        <li><a href="{{ URL::to('admin/paypalplans') }}"><i class="las la-eye"></i>Manage Paypal plans</a></li> -->
                        <li><a href="{{ URL::to('admin/subscription-plans') }}">{{ (__('Manage Subscription plans')) }}</a></li>
                        <li><a href="{{ route('inapp_purchase') }}">{{ (__('Manage In App Purchase Plans')) }}</a></li>
                        <li><a href="{{ route('Life-time-subscription-index') }}">{{ (__('Life time subscription')) }}  </a></li>
                        <li><a href="{{ route('admin.user-channel-subscription-plan.index') }}">{{ (__('User Channel Subscription Plan')) }}  </a></li>
                         <!-- <li><a href="{{ URL::to('admin/coupons') }}"><i class="las la-eye"></i>Manage Stripe Coupons</a></li> -->
                         <li><a href="{{ URL::to('admin/devices') }}">{{ (__('Devices')) }}</a></li>
                     </ul>
                  </li>

                  <div >
                  <!-- <p class="" style="color:#0993D2!important;padding-left:30px;font-weight: 600;">Analytics</p></div> -->
                    <li>
                     <a href="#analytics_managements" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="ply" height="40" width="40" src="<?php echo  URL::to('/assets/img/E360_icons/Analytics.svg')?>"><span>{{ (__('Analytics')) }}</span><i
                        class="ri-arrow-right-s-line iq-arrow-right"></i>
                     </a>
                     <ul id="analytics_managements" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ URL::to('admin/analytics') }}">Revenue Analytics </a></li>
                        <li><a href="{{ URL::to('admin/analytics/revenue') }}">{{ (__('Users Analytics')) }} </a></li>
                        {{-- <li><a href="{{ URL::to('admin/users/revenue') }}">{{ (__('Users Revenue')) }} </a></li> --}}
                        {{-- <li><a href="{{ URL::to('admin/video/purchased-analytics') }}"></i>{{ (__('Purchased Video Analytics')) }} </a></li> --}}
                        <li><a href="{{ URL::to('admin/cpp/analytics') }}">{{ (__('CPP Analytics')) }} </a></li>
                        <li><a href="{{ URL::to('admin/cpp/video-analytics') }}">{{ (__('CPP Video Analytics')) }} </a></li>
                        {{-- <li><a href="{{ URL::to('admin/cpp/revenue') }}">{{ (__('CPP Revenue')) }} </a></li> --}}
                        <li><a href="{{ URL::to('admin/analytics/ViewsRegion') }}">{{ (__('Views By Region')) }}</a></li>
                         {{-- <li><a href="{{ URL::to('admin/analytics/RevenueRegion') }}">{{ (__('Revenue by Region')) }}</a></li> --}}
                         <li><a href="{{ URL::to('admin/analytics/PlayerVideoAnalytics') }}">{{ (__('Player Video Analytics')) }}</a></li>
                         <li><a href="{{ URL::to('admin/analytics/RegionVideoAnalytics') }}">{{ (__('Region Video Analytics')) }}</a></li>
                         <li><a href="{{ URL::to('admin/analytics/PlayerUserAnalytics') }}">{{ (__('Player User Analytics')) }}</a></li>
                        <li><a href="{{ URL::to('admin/livestream-analytics') }}">{{ (__('CPP Live Video')) }} </a></li>
                        {{-- <li><a href="{{ URL::to('admin/live/purchased-analytics') }}">{{ (__('Purchased LiveStream Analytics')) }} </a></li> --}}
                        {{-- <li><a href="{{ URL::to('admin/purchased-analytics') }}">{{ (__('Purchased Content Analytics')) }}</a></li> --}}
                        <li><a href="{{ URL::to('admin/Content-Analytics') }}">{{ (__('Content Analytics')) }}</a></li>

                     </ul>
                  </li>
                  <div >
                    <li>
                        <a href="#settings" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="ply" height="40" width="40" src="<?php echo  URL::to('/assets/img/E360_icons/Setting.svg')?>"><span>{{ (__('Settings')) }}</span><i class="ri-arrow-right-s-line iq-arrow-right"></i> </a>
                        <ul id="settings" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li  data-tour="step: 4; title: Storefront Settings; content: Go to Settings to choose different monetization methods Subscription, Pay Per View, PPV Bundles, Coupons, etc for your content or make them free" class=" " data-tour="step: 4; title: Promo code; content: Go to Settings to choose different monetization methods Subscription, Pay Per View, PPV Bundles, Coupons, etc for your content or make them free" ><a href="{{ URL::to('admin/settings') }}">{{ (__('Storefront Settings')) }}</a></li>
                            <li><a href="{{ URL::to('admin/home-settings') }}">{{ (__('HomePage Settings')) }}</a></li>
                            <!-- <li><a href="{{ URL::to('admin/order-home-settings') }}"><i class="las la-eye"></i>Order HomePage Settings</a></li> -->
                            <li><a href="{{ URL::to('admin/linking_settings/') }}">{{ (__('Link Settings')) }}</a></li>
                           <li><a href="{{ URL::to('admin/age/index') }}" class="iq-waves-effect">{{ (__('Manage Age')) }}</a></li>
                            <li><a href="{{ URL::to('admin/theme_settings') }}">{{ (__('Theme Settings')) }}</a></li>
                            <li><a href="{{ route('admin_slider_index') }}">{{ (__('Slider')) }} </a></li>
                            {{-- <li><a href="{{ URL::to('admin/payment_settings') }}">{{ (__('Payment Settings')) }}</a></li> --}}
                            <li><a href="{{ URL::to('admin/email_settings') }}">{{ (__('Email Settings')) }}</a></li>
                            <li><a href="{{ URL::to('admin/storage_settings') }}">{{ (__('Storage Settings')) }}</a></li>
                            <!-- <li><a href="{{ URL::to('admin/email_template') }}"><i class="las la-eye"></i>Email Template</a></li> -->
                            <li><a href="{{ URL::to('admin/mobileapp') }}">{{ (__('Mobile App Settings')) }}</a></li>
                            <li><a href="{{ URL::to('admin/system_settings') }}">{{ (__('Social Login Settings')) }}</a></li>
                            <li><a href="{{ URL::to('admin/currency_settings') }}">{{ (__('Currency Settings')) }}</a></li>
                            <li><a href="{{ URL::to('admin/revenue_settings/index') }}">{{ (__('Revenue Settings')) }}</a></li>
                            <li><a href="{{ URL::to('admin/ThumbnailSetting') }}" class="iq-waves-effect">{{ (__('Thumbnail Settings')) }}</a></li>
                            <li><a href="{{ URL::to('admin/ChooseProfileScreen') }}" class="iq-waves-effect">{{ (__('Profile Screen')) }}</a></li>
                            {{-- <li  data-tour="step: 3; title: Manage Theme; content: Go to 'Manage Template' to choose a template for our website from our catalogue" class=" " data-tour="step: 3; title: Manage Theme; content: Go to 'Manage Template' to choose a template for our website from our catalogue"><a href="{{ URL::to('admin/ThemeIntegration') }}" class="iq-waves-effect">{{ (__('Theme')) }}</a></li> --}}
                            <li><a href="{{ route('compress_image') }}" class="iq-waves-effect">{{ (__('Image Settings')) }}  </a></li>
                            <li><a href="{{ route('homepage_popup') }}" class="iq-waves-effect">{{ (__('Home page Pop Up settings')) }} </a></li>
                            <li><a href="{{ route('comment_section') }}" class="iq-waves-effect"> {{ (__('Comment Section Settings')) }} </a></li>
                            <li><a href="{{ route('meta_setting') }}" class="iq-waves-effect"> {{ (__('Site Meta Settings')) }} </a></li>
                            <li><a href="{{ route('TV_Settings_Index') }}" class="iq-waves-effect">{{ (__('TV Settings')) }} </a></li>
                            
                            @if(!empty(@$AdminAccessPermission) && @$AdminAccessPermission->Page_Permission_checkout == 1 || Auth::user()->plan_name == 'SuperAdmin')
                              <li><a href="{{ URL::to('admin/access-premission') }}" class="iq-waves-effect">{{ (__('Page Permission Settings')) }}</a></li>
                            @endif 

                           <li><a href="{{ route('admin.OTP-Credentials-index') }}" class="iq-waves-effect">{{ (__('OTP Credentials')) }} </a></li>
                           <li><a href="{{ route('partner_monetization_settings') }}" class="iq-waves-effect">{{ (__('Partner Monetization Settings')) }} </a></li>


                           @if ( Auth::user()->plan_name == 'SuperAdmin')
                              <li><a href="{{ route('admin.users-package') }}" class="iq-waves-effect">{{ (__('Users Package Management')) }} </a></li>
                           @endif

                        </ul>
                    </li>
                    <!-- Ads Menu starts -->
               @if($settings->ads_on_videos == 1)
                  <div class="men">
                    <p class="lnk" >{{ (__('Ads Management')) }}</p>
                  </div>
                  <li>
                     <a href="#Advertiser" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="" height="40" width="40" src="<?php echo  URL::to('/assets/img/icon/manage-avd.svg')?>"><span>{{ (__('Manage Advertiser')) }} </span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                     <ul id="Advertiser" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                           <li><a href="{{ URL::to('admin/advertisers') }}">{{ (__('Advertisers')) }}</a></li>
                     </ul>
                  </li>
                  <li><a href="{{ URL::to('admin/ads_categories') }}" class="iq-waves-effect"><img  height="40" width="40" class="" src="<?php echo  URL::to('/assets/img/icon/ads-cate.svg')?>"><span>{{ (__('Ads Categories')) }}</span></a></li>

                  <li><a href="{{ URL::to('admin/ads_list') }}" class="iq-waves-effect"><img  height="40" width="40" class="" src="<?php echo  URL::to('/assets/img/icon/ads-list.svg')?>"><span>{{ (__('Ads List')) }}</span></a></li>

                  @if ($settings->ads_payment_page_status == 1 )
                     <li><a href="{{ URL::to('admin/ads_plans') }}" class="iq-waves-effect"><img  height="40" width="40" class="" src="<?php echo  URL::to('/assets/img/icon/ads-plan.svg')?>"><span>{{ (__('Ads Plans')) }} </span></a></li>
                  @endif

                  <li><a href="{{ URL::to('admin/ads_revenue') }}" class="iq-waves-effect"><img  height="40" width="40" class="" src="<?php echo  URL::to('/assets/img/icon/ads-rev.svg')?>"><span>{{ (__('Ads Revenue')) }} </span></a></li>

                  <li><a href="{{ URL::to('admin/calendar-event') }}" class="iq-waves-effect"><img  height="40" width="40" class="" src="<?php echo  URL::to('/assets/img/icon/calender.svg')?>"><span>{{ (__('Calendar Events')) }} </span></a></li>
                  
                  {{-- <li><a href="{{ URL::to('admin/ad_campaign') }}" class="iq-waves-effect"><img  height="40" width="40" class="" src="<?php echo  URL::to('/assets/img/icon/campin.svg')?>"><span>{{ (__('Ad Campaigns')) }} </span></a></li> --}}

                  <li><a href="{{ URL::to('admin/Ads-TimeSlot') }}" class="iq-waves-effect"><img  height="40" width="40" class="" src="<?php echo  URL::to('/assets/img/icon/campin.svg')?>"><span>{{ (__('Ad Time Slot')) }} </span></a></li>

                  <li><a href="{{ route('admin.ads_banners') }}" class="iq-waves-effect"><img  height="40" width="40" class="" src="<?php echo  URL::to('/assets/img/icon/campin.svg')?>"><span> {{ (__('Ad Banners')) }} </span></a></li>

                  <li><a href="{{ route('admin.ads_variable') }}" class="iq-waves-effect"><img  height="40" width="40" class="" src="<?php echo  URL::to('/assets/img/icon/campin.svg')?>"><span>  {{ (__('Ad variable')) }}</span></a></li>

               @endif

                
                    {{-- Geo Fencing --}}
               <li><p class="lnk">{{ (__('Geo Fencing')) }}</p></li>

               <li><a href="{{ URL::to('admin/Geofencing') }}" class="iq-waves-effect"><img height="30" width="30" class="ply" src="<?php echo  URL::to('/assets/img/E360_icons/Geofencing.svg')?>"><span>{{ (__('Manage Geo Fencing')) }} </span></a></li>

               <li><a href="{{ URL::to('admin/countries') }}" class="iq-waves-effect"><img height="40" width="40" class="ply" src="<?php echo  URL::to('/assets/img/E360_icons/Manage Countries.svg')?>"><span>{{ (__('Manage Countries')) }}</span></a></li>

               
                 {{-- Clear cache  --}}
                 <li><p class="lnk">{{ (__('Configurations')) }} </p></li>

                 <li><a href="{{ route('clear_cache') }}" class="iq-waves-effect">
                     <img height="30" width="30" class="ply" src="<?php echo  URL::to('/assets/img/E360_icons/Cache Management.svg')?>">
                     <span>{{ (__('Cache Management')) }}  </span>
                     </a>
                  </li>

                  <li><a href="{{ route('env_index') }}" class="iq-waves-effect">
                     <img height="30" width="30" class="ply" src="<?php echo  URL::to('/assets/img/E360_icons/Debug.svg')?>">
                        <span>{{ (__('Debug')) }}   </span>
                     </a>
                  </li>

                  <!-- <li><a href="{{ route('access_forbidden') }}" class="iq-waves-effect">
                     <img height="30" width="30" class="" src="<?php echo  URL::to('/assets/img/icon/cc.svg')?>">
                        <span> {{ __('Restrict Access') }}  </span>
                     </a>
                  </li> -->
                  
                  <li><a href="{{ route('seeding-index') }}" class="iq-waves-effect">
                     <img height="30" width="30" class="ply" src="<?php echo  URL::to('/assets/img/E360_icons/Seeding Management.svg')?>">
                        <span>{{ (__('Seeding Management')) }}   </span>
                     </a>
                  </li>

               <!-- {{-- Contact Us --}} -->
               <li><p class="lnk">{{ (__('CONTACT US')) }}</p></li>

                  <li><a href="{{ URL::to('admin/contact-us/') }}" class="iq-waves-effect">
                        <img height="30" width="30" class="ply" src="<?php echo  URL::to('/assets/img/E360_icons/Contact request.svg')?>">
                        <span>{{ (__('Contact Request')) }} </span>
                     </a>
                  </li>
                  <!-- {{-- Log Activity --}} -->
                  <li><p class="lnk">{{ (__('Log Activity')) }}</p></li>

                  <li><a href="{{ URL::to('admin/UploadlogActivity') }}" class="iq-waves-effect">
                        <img class="ply" height="30" width="30" class="" src="<?php echo  URL::to('/assets/img/icon/upload.svg')?>">
                        <span>{{ (__('Upload Log Activity')) }}</span>
                     </a>
                  </li>

                  <li><a href="{{ URL::to('admin/deleted-log') }}" class="iq-waves-effect">
                     <img class="ply" height="30" width="30" class="" src="<?php echo  URL::to('/assets/img/icon/delete.svg')?>">
                     <span>Delete Log</span>
                  </a>
               </li>
                  
                  <li><a href="{{ URL::to('admin/logActivity') }}" class="iq-waves-effect">
                        <img class="ply" height="30" width="30" class="" src="<?php echo  URL::to('/assets/img/icon/geo.svg')?>">
                        <span>{{ (__('Site Log Activity')) }}</span>
                     </a>
                  </li>
                  
                  <!-- Ads Menu ends -->
                  <?php } elseif(auth()->user()->role == "admin" && $package == "Pro" && $package == "Business"){ ?>
                     <div class="page-container sidebar-collapsed"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
  <!-- Sidebar 4-->
      <div class="iq-sidebar">
         <div class="iq-sidebar- d-flex justify-content-between align-items-center mt-2">
            <a href="<?php echo URL::to('home') ?>" class="header-logo">
               <img src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo ; ?>" class="c-logo" alt="" width="200px" height="100px" style="object-fit:contain;">
               <div class="logo-title">
                  <span class="text-primary text-uppercase"></span>
               </div>
            </a>
            <div class="iq-menu-bt-sidebar">
               <div class="iq-menu-bt align-self-center">
                  <div class="wrapper-menu">
                     <div class="main-circle"><i class="las la-bars"></i></div>
                  </div>
               </div>
            </div>
         </div>
         <div id="sidebar-scrollbar">
            <nav class="iq-sidebar-menu">
               <ul id="iq-sidebar-toggle" class="iq-menu">
                  <li class="views"><a href="<?php echo URL::to('/') ?>" ><i class="ri-arrow-right-line"></i><span>Visit site</span></a></li>
                  <li ><a href="<?php echo URL::to('admin') ?>" class="iq-waves-effect"> <img class="ply" height="40" width="40" src="<?php echo  URL::to('/assets/img/icon/home.svg')?>"> <span class=""><span>Dashboard</span></a></li>
                   <div class="bod"></div>
                   <div style="">
                 
                   <p class="lnk" >Video</p>
                   </div>
                   <li data-tour="step: 1; title: All Videos; content: Go to 'Video Library' to add or import content into content library" class=" " data-tour="step: 1; title: All Videos; content: Go to 'Video Library' to add or import content into content library"><a href="#video" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="ply" height="40" width="40" src="<?php echo  URL::to('/assets/img/sidemenu/vi.svg')?>"><span>Video Management </span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                   <ul id="video" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                         <li><a href="{{ URL::to('admin/videos') }}"><img class="mr-2" height="30" width="30" src="<?php echo  URL::to('/assets/img/icon/all-video.svg')?>">All Videos</a></li>
                        <li><a href="{{ URL::to('admin/videos/create') }}"><img class="mr-2" height="30" width="30" src="<?php echo  URL::to('/assets/img/icon/add-new-video.svg')?>">{{ __('Add New Video') }}</a></li>
                        <li><a href="{{ URL::to('admin/CPPVideosIndex') }}"><img class="mr-2" height="30" width="30" src="<?php echo  URL::to('/assets/img/icon/video-approval.svg')?>">Videos For Approval</a></li>
                        <li><a href="{{ URL::to('admin/Masterlist') }}" class="iq-waves-effect"><img class="mr-2" height="30" width="30" src="<?php echo  URL::to('/assets/img/icon/manage-video-list.svg')?>"><span> Master Video List</span></a></li>
                        <li><a href="{{ route('admin.Channel.index') }}" class="iq-waves-effect">Channel </a></li>
                        <li><a href="{{ URL::to('admin/video-schedule') }}" class="iq-waves-effect">Video Schedule</a></li>
                        @if (EPG_Status() == 1)
                           <li><a href="{{ route('admin.epg.index') }}" class="iq-waves-effect"> EPG </a></li>
                        @endif                        <!-- <li><a href="{{ URL::to('admin/test/videoupload') }}" class="iq-waves-effect">Test Server Video Upload</a></li> -->
                        <li><a href="{{ URL::to('admin/assign_videos/partner') }}" class="iq-waves-effect">Move Videos to Partner</a></li>
                        <li data-tour="step: 2; title: Video Category; content: Go to 'Manage Categories' to setup your content categories" class=" " data-tour="step: 2; title: Video Category; content: Go to 'Manage Categories' to setup your content categories"><a href="{{ URL::to('admin/videos/categories') }}"><img class="mr-2" height="30" width="30" src="<?php echo  URL::to('/assets/img/icon/video-approval.svg')?>">Manage Video Categories</a></li>                    
                    
          </ul></li>
          <li><a href="#series" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="ply" height="40" width="40" src="<?php echo  URL::to('/assets/img/icon/tv.svg')?>"><span>TV Shows </span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
            <ul id="series" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
              <li><a href="{{ URL::to('admin/series-list') }}"><i class="las la-user-plus"></i>List TV Shows </a></li>
              <li><a href="{{ URL::to('admin/series/create') }}"><i class="las la-eye"></i>Add New TV Shows</a></li>
              <li data-tour="step: 2; title: Video Category; content: Go to 'Manage Categories' to setup your content categories" class=" " data-tour="step: 2; title: Video Category; content: Go to 'Manage Categories' to setup your content categories"><a href="{{ URL::to('admin/Series/Genre') }}"><img class="mr-2" height="30" width="30" src="<?php echo  URL::to('/assets/img/icon/video-approval.svg')?>">Manage Genre</a></li>   
               @if (Series_Networks_Status() == 1 )
                  <li><a href="{{ route('admin.Network_index') }}">Manage Networks</a></li>
               @endif
              <li><a href="{{ URL::to('admin/CPPSeriesIndex') }}">TV Shows For Approval</a></li>
              <li><a href="{{ URL::to('admin/assign_Series/partner') }}" class="iq-waves-effect">Move TV Shows to Partner</a></li>


            </ul>
          </li>
          <li>
          <div style=""> 
                 <p class="lnk" >Live Stream</p>
                 </div>
                     <a href="#live-video" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="ply" src="<?php echo  URL::to('/assets/img/icon/live.svg')?>"><span>Manage Live Stream</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                     <ul id="live-video" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ URL::to('admin/livestream') }}"><i class="las la-user-plus"></i>All Live Stream</a></li>
                        <li><a href="{{ URL::to('admin/livestream/create') }}"><i class="las la-eye"></i>Add New Live Stream</a></li>
                        <li><a href="{{ URL::to('admin/CPPLiveVideosIndex') }}"><i class="las la-eye"></i>Live Stream For Approval</a></li>
                         <li><a href="{{ URL::to('admin/livestream/categories') }}"><i class="las la-eye"></i>Manage Live Stream Categories</a></li>
                         <li><a href="{{ route('live_event_artist') }}"> Live Event Artist </a></li>
                     </ul>
                  </li>


                    <div style="">
                  
                        <p class="lnk" >Audio </p></div>
          <li><a href="#audios" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="ply" src="<?php echo  URL::to('/assets/img/icon/music.svg')?>"><span>Audio Management </span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
            <ul id="audios" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
              <li><a href="{{ URL::to('admin/audios') }}"><i class="las la-music"></i>Audio List</a></li>
              <li><a href="{{ URL::to('admin/audios/create') }}"><i class="las la-plus"></i>Add New Audio</a></li>
              <li><a href="{{ URL::to('admin/CPPAudioIndex') }}"><i class="las la-eye">Audios For Approval</a></li>
              <li><a href="{{ URL::to('admin/audios/categories') }}"><i class="las la-eye"></i>Manage Audio Categories</a></li>
              <li><a href="{{ URL::to('admin/audios/albums') }}"><i class="las la-eye"></i>Manage Albums</a></li>
            </ul>
          </li>
          <li><a href="#artists" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="ply" src="<?php echo  URL::to('/assets/img/icon/art.svg')?>">
<span>Artist Management </span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
            <ul id="artists" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
              <li><a href="{{ URL::to('admin/artists') }}"><i class="las la-user-plus"></i>All Artists</a></li>
              <li><a href="{{ URL::to('admin/artists/create') }}"><i class="las la-eye"></i>Add New Artist</a></li>

            </ul>
          </li>
          
                 
                    <div >
                  
                        <p class="lnk" >Accounts</p></div>
                  <li><a href="#user" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="" src="<?php echo  URL::to('/assets/img/icon/user.svg')?>"><span>Users</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                       <ul id="user" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ URL::to('admin/users') }}"><i class="las la-user-plus"></i>All Users</a></li>
                        <li><a href="{{ URL::to('admin/user/create') }}"><i class="las la-eye"></i>Add New User</a></li>
                        <li><a href="{{ route('import_users_view') }}"> Import Users </a></li>
                        <li><a href="{{ URL::to('admin/MultiUser-limit') }}"><img height="30" width="30" class="mr-2" src="<?php echo  URL::to('/assets/img/icon/add-new-user.svg')?>">Multi User Management</a></li>
                     </ul>
                      
                   </li>
                   <li><a href="{{ URL::to('admin/menu') }}" class="iq-waves-effect"><span>Menu</span></a></li>
                   <li><a href="{{ URL::to('admin/signup') }}" class="iq-waves-effect"><img class="" src="<?php echo  URL::to('/assets/img/icon/men.svg')?>"heigth="40" width="40"><span>Signup Menu</span></a></li>
                   <li><a href="{{ URL::to('/admin/filemanager') }}" class="iq-waves-effect"><i class="la la-list"></i><span>Filemanager</span></a></li>
                    <div class="men">
                
                   <p class="lnk" >Language</p>
                       </div>
                  <li>
                     <a href="#language" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="ply" src="<?php echo  URL::to('/assets/img/icon/lang.svg')?>"><span>Manage Languages </span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                     <ul id="language" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ URL::to('admin/admin-languages') }}"><i class="las la-user-plus"></i>Video Languages</a></li>
                        <li><a href="{{ URL::to('admin/subtitles/create') }}"><i class="las la-user-plus"></i>Add Subtitle Languages</a></li>
                        <li><a href="{{ URL::to('admin/languages') }}"><i class="las la-eye"></i>Manage Translations</a></li>
                         {{-- <li><a href="{{ URL::to('admin/admin-languages-transulates') }}"><i class="las la-eye"></i>Manage Translate Languages</a></li> --}}
                     </ul>
                  </li>
                   
                   <li><a href="{{ URL::to('admin/sliders') }}" class="iq-waves-effect"><img class="" src="<?php echo  URL::to('/assets/img/icon/slider.svg')?>"><span>Sliders</span></a></li>
                   <!-- <li><a href="{{ URL::to('admin/payment_test') }}" class="iq-waves-effect"><i class="la la-sliders"></i><span> Test Payment Setting</span></a></li> -->

                    <div >
                   
                   <p class="lnk" >Site</p>
                       </div>
                   <li><a href="{{ URL::to('admin/players') }}" class="iq-waves-effect"><img class="ply" src="<?php echo  URL::to('/assets/img/icon/ply.svg')?>"><span>Player UI</span></a></li>
                   <li>
                     <a href="#moderators" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="ply" height="40" width="40" src="<?php echo  URL::to('/assets/img/icon/cpl.svg')?>"><span>Content Partners</span><i
                        class="ri-arrow-right-s-line iq-arrow-right"></i>
                     </a>
                     <ul id="moderators" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ URL::to('moderator') }}"><i class="las la-user-plus"></i>Add Content Partners</a></li>
                        <li><a href="{{ URL::to('admin/moderator-details') }}">Content Details</a></li>
                        <li><a href="{{ URL::to('admin/allmoderator') }}"><i class="las la-eye"></i>View Content Partners</a></li>
                        <li><a href="{{ URL::to('admin/cpp/pendingusers/') }}"><i class="las la-eye"></i>Content Partners For Approval</a></li>
                         <li><a href="{{ URL::to('admin/moderator/role') }}"><i class="las la-eye"></i>Add Role</a></li>
                         <li><a href="{{ URL::to('admin/moderator/Allview') }}"><i class="las la-eye"></i>View Role</a></li>
                         <li><a href="{{ URL::to('admin/moderator/commission') }}"><i class="las la-eye"></i>Commission </a></li>
                        <li><a href="{{ URL::to('admin/moderator/payouts') }}"><i class="las la-eye"></i>Content Partners Payout</a></li>


                     </ul>
                  </li>
                  <li>
                     <a href="#channel" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="ply" height="40" width="40" src="<?php echo  URL::to('/assets/img/icon/cpl.svg')?>"><span>Channel Partners</span><i
                        class="ri-arrow-right-s-line iq-arrow-right"></i>
                     </a>
                     <ul id="channel" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                     <li><a href="{{ URL::to('admin/channel/user/create/') }}">Add Channel Partners </a></li>
                     <li><a href="{{ URL::to('admin/channel/view-channel-members/') }}">View Channel Partners </a></li>
                        <li><a href="{{ URL::to('admin/channel/pendingusers/') }}">Channel Partners For Approval</a></li>
                        <li><a href="{{ URL::to('admin/channel/commission') }}">Commission </a></li>
                        <li><a href="{{ URL::to('admin/channel/payouts') }}">Channel Partners Payout</a></li>
                        {{-- <li><a href="{{ route('channel_package_index') }}">Channel Package</a></li> --}}
                     </ul>
                  </li>
                  <li>
                     <a href="#pages" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="" src="<?php echo  URL::to('/assets/img/icon/page.svg')?>"><span>Pages</span><i
                        class="ri-arrow-right-s-line iq-arrow-right"></i>
                     </a>
                     <ul id="pages" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ URL::to('admin/pages') }}"><i class="las la-user-plus"></i>All Pages</a></li>
                        <li><a href="{{ route('landing_page_index') }}">Landing Page</a></li>
                        <li><a href="{{ route('landing_page_create') }}">Create Landing Page</a></li>
                     </ul>
                  </li>
                   
                    <li>
                     <a href="#plans" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="" src="<?php echo  URL::to('/assets/img/icon/plan.svg')?>"><span>Plans</span><i
                        class="ri-arrow-right-s-line iq-arrow-right"></i>
                     </a>
                     <ul id="plans" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <!-- <li><a href="{{ URL::to('admin/plans') }}"><i class="las la-user-plus"></i>Manage Stripe plans</a></li>
                        <li><a href="{{ URL::to('admin/paypalplans') }}"><i class="las la-eye"></i>Manage Paypal plans</a></li> -->
                        <li><a href="{{ URL::to('admin/subscription-plans') }}"><i class="las la-eye"></i>Manage Subscription plans</a></li>
                        <li><a href="{{ route('inapp_purchase') }}"><img height="30" width="30"  class="mr-2" src="<?php echo  URL::to('/assets/img/icon/manage-sub.svg')?>">Manage In App Purchase Plans</a></li>
                        <li><a href="{{ route('Life-time-subscription-index') }}"> Life time subscription </a></li>
                         <!-- <li><a href="{{ URL::to('admin/coupons') }}"><i class="las la-eye"></i>Manage Stripe Coupons</a></li> -->
                         <li><a href="{{ URL::to('admin/devices') }}"><i class="las la-eye"></i>Devices</a></li>
                     </ul>
                  </li>

                  <li>
                     <a href="#payment_managements" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="ply" src="<?php echo  URL::to('/assets/img/icon/pay.svg')?>"><span>Payment Management</span><i
                        class="ri-arrow-right-s-line iq-arrow-right"></i>
                     </a>
                     <ul id="payment_managements" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ URL::to('admin/payment/total_revenue') }}"><i class="las la-user-plus"></i>Total Revenues</a></li>
                        <li><a href="{{ URL::to('admin/payment/subscription') }}"><i class="las la-eye"></i>Subscription Payments</a></li>
                         <li><a href="{{ URL::to('admin/payment/PayPerView') }}"><i class="las la-eye"></i>PayPerView Payments</a></li>
                     </ul>
                  </li>
                  <div >
                  <!-- <p class="" style="color:#0993D2!important;padding-left:30px;font-weight: 600;">Analytics</p></div> -->
                    <li>
                     <a href="#analytics_managements" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="" src="<?php echo  URL::to('/assets/img/icon/ana.svg')?>"><span>Analytics</span><i
                        class="ri-arrow-right-s-line iq-arrow-right"></i>
                     </a>
                     <ul id="analytics_managements" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ URL::to('admin/analytics/revenue') }}"><i class="las la-user-plus"></i>Users Analytics </a></li>
                        <li><a href="{{ URL::to('admin/users/revenue') }}"><i class="las la-user-plus"></i>Users Revenue </a></li>
                        <li><a href="{{ URL::to('admin/video/purchased-analytics') }}"><i class="las la-user-plus"></i>Purchased Video Analytics </a></li>
                        <li><a href="{{ URL::to('admin/cpp/analytics') }}"><i class="las la-user-plus"></i>CPP Analytics </a></li>
                        <li><a href="{{ URL::to('admin/cpp/video-analytics') }}"><i class="las la-user-plus"></i>CPP Video Analytics </a></li>
                        <li><a href="{{ URL::to('admin/cpp/revenue') }}"><i class="las la-user-plus"></i>CPP Revenue </a></li>
                        <li><a href="{{ URL::to('admin/analytics/ViewsRegion') }}"><i class="las la-eye"></i>Views By Region</a></li>
                         <li><a href="{{ URL::to('admin/analytics/RevenueRegion') }}"><i class="las la-eye"></i>Revenue by Region</a></li>
                        <li><a href="{{ URL::to('admin/live/purchased-analytics') }}">Purchased LiveStream Analytics </a></li>
                     </ul>
                  </li>
                  <div >
                    <li>
                        <a href="#settings" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="ply" src="<?php echo  URL::to('/assets/img/icon/setting.svg')?>"><span>Settings</span><i class="ri-arrow-right-s-line iq-arrow-right"></i> </a>
                        <ul id="settings" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li  data-tour="step: 4; title: Storefront Settings; content: Go to Settings to choose different monetization methods Subscription, Pay Per View, PPV Bundles, Coupons, etc for your content or make them free" class=" " data-tour="step: 4; title: Promo code; content: Go to Settings to choose different monetization methods Subscription, Pay Per View, PPV Bundles, Coupons, etc for your content or make them free" ><a href="{{ URL::to('admin/settings') }}"><i class="las la-eye"></i>Storefront Settings</a></li>
                            <li><a href="{{ URL::to('admin/home-settings') }}"><i class="las la-eye"></i>HomePage Settings</a></li>
                            <li><a href="{{ URL::to('admin/linking_settings/') }}"><i class="las la-eye"></i>Link Settings</a></li>
                            <li><a href="{{ URL::to('admin/age/index') }}" class="iq-waves-effect">Manage Age</a></li>
                            <!-- <li><a href="{{ URL::to('admin/order-home-settings') }}"><i class="las la-eye"></i>Order HomePage Settings</a></li> -->
                            <li><a href="{{ URL::to('admin/theme_settings') }}"><i class="las la-eye"></i>Theme Settings</a></li>
                            <li><a href="{{ route('admin_slider_index') }}">Slider </a></li>
                            {{-- <li><a href="{{ URL::to('admin/payment_settings') }}"><i class="las la-eye"></i>Payment Settings</a></li> --}}
                            <li><a href="{{ URL::to('admin/email_settings') }}"><i class="las la-eye"></i>Email Settings</a></li>
                            <li><a href="{{ URL::to('admin/storage_settings') }}"><i class="las la-eye"></i>Storage Settings</a></li>
                            <!-- <li><a href="{{ URL::to('admin/email_template') }}"><i class="las la-eye"></i>Email Template</a></li> -->
                            <li><a href="{{ URL::to('admin/mobileapp') }}"><i class="las la-user-plus"></i>Mobile App Settings</a></li>
                            <li><a href="{{ URL::to('admin/system_settings') }}"><i class="las la-eye"></i>Social Login Settings</a></li>
                            <li><a href="{{ URL::to('admin/currency_settings') }}"><i class="las la-eye"></i>Currency Settings</a></li>
                            <li><a href="{{ URL::to('admin/revenue_settings/index') }}"><i class="las la-eye"></i>Revenue Settings</a></li>
                            <li><a href="{{ URL::to('admin/ThumbnailSetting') }}" ><i class="ri-price-tag-line"></i>Thumbnail Settings</a></li>
                            <li><a href="{{ URL::to('admin/ChooseProfileScreen') }}" ><i class="ri-price-tag-line"></i>Profile Screen</a></li>
                            {{-- <li  data-tour="step: 3; title: Manage Theme; content: Go to 'Manage Template' to choose a template for our website from our catalogue" class=" " data-tour="step: 3; title: Manage Theme; content: Go to 'Manage Template' to choose a template for our website from our catalogue"><a href="{{ URL::to('admin/ThemeIntegration') }}" ><i class="ri-price-tag-line"></i>Theme</a></li> --}}
                            <li><a href="{{ route('compress_image') }}" class="iq-waves-effect"> Image Settings </a></li>
                            <li><a href="{{ route('homepage_popup') }}" class="iq-waves-effect"> {{ ucwords('Home page Pop Up settings') }} </a></li>
                            <li><a href="{{ route('comment_section') }}" class="iq-waves-effect"> Comment Section Settings </a></li>
                            <li><a href="{{ route('admin.OTP-Credentials-index') }}" class="iq-waves-effect">{{ (__('OTP Credentials')) }} </a></li>
                            <li><a href="{{ route('partner_monetization_settings') }}" class="iq-waves-effect">{{ (__('Partner Monetization Settings')) }} </a></li>

                              @if ( Auth::user()->plan_name == 'SuperAdmin')
                                 <li><a href="{{ route('admin.users-package') }}" class="iq-waves-effect">{{ (__('Users Package Management')) }} </a></li>
                              @endif
                           </ul>
                    </li>
                    <!-- Ads Menu starts class="iq-waves-effect"-->
               @if($settings->ads_on_videos == 1)
                  <div>
                    <p class="lnk" >Ads Management</p>
                  </div>
                  <li>
                     <a href="#Advertiser" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="" src="<?php echo  URL::to('/assets/img/icon/user.svg')?>"><span>Manage Advertiser </span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                     <ul id="Advertiser" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                           <li><a href="{{ URL::to('admin/advertisers') }}"><i class="las la-user-plus"></i>Advertisers</a></li>
                     </ul>
                  </li>
                  <li><a href="{{ URL::to('admin/ads_categories') }}" class="iq-waves-effect"><img class="" src="<?php echo  URL::to('/assets/img/icon/ad.svg')?>"><span>Ads Categories</span></a></li>

                  <li><a href="{{ URL::to('admin/ads_list') }}" class="iq-waves-effect"><img class="" src="<?php echo  URL::to('/assets/img/icon/ad2.svg')?>"><span>Ads List</span></a></li>

                  <li><a href="{{ URL::to('admin/ads_plans') }}" class="iq-waves-effect"><img class="" src="<?php echo  URL::to('/assets/img/icon/ad3.svg')?>"><span> Ads Plans</span></a></li>

                  <li><a href="{{ URL::to('admin/ads_revenue') }}" class="iq-waves-effect"><img class="" src="<?php echo  URL::to('/assets/img/icon/ana.svg')?>"><span> Ads Revenue</span></a></li>

                  <li><a href="{{ URL::to('admin/calendar-event') }}" class="iq-waves-effect"><img  height="40" width="40" class="" src="<?php echo  URL::to('/assets/img/icon/calender.svg')?>"><span> Calendar Events</span></a></li>
                  
                  {{-- <li><a href="{{ URL::to('admin/ad_campaign') }}" class="iq-waves-effect"><img  height="40" width="40" class="" src="<?php echo  URL::to('/assets/img/icon/campin.svg')?>"><span> Ad Campaigns</span></a></li> --}}

                  <li><a href="{{ URL::to('admin/Ads-TimeSlot') }}" class="iq-waves-effect"><img  height="40" width="40" class="" src="<?php echo  URL::to('/assets/img/icon/campin.svg')?>"><span> Ad Time Slot</span></a></li>

                  <li><a href="{{ route('admin.ads_banners') }}" class="iq-waves-effect"><img  height="40" width="40" class="" src="<?php echo  URL::to('/assets/img/icon/campin.svg')?>"><span> Ad Banners</span></a></li>

                  <li><a href="{{ route('admin.ads_variable') }}" class="iq-waves-effect"><img  height="40" width="40" class="" src="<?php echo  URL::to('/assets/img/icon/campin.svg')?>"><span>  {{ (__('Ad variable')) }}</span></a></li>

               @endif

                       {{-- Geo Fencing --}}
               <li><p class="lnk" >Geo Fencing</p></li>

               <li><a href="{{ URL::to('admin/Geofencing') }}" class="iq-waves-effect"><img class="" src="<?php echo  URL::to('/assets/img/icon/geo.svg')?>"><span> Manage Geo Fencing</span></a></li>

               <li><a href="{{ URL::to('admin/countries') }}" class="iq-waves-effect"><img class="" src="<?php echo  URL::to('/assets/img/icon/geo2.svg')?>"><span>Manage Countries</span></a></li>

                  {{-- Clear cache  --}}
                  <li><p class="lnk">Configurations </p></li>

                  <li><a href="{{ route('clear_cache') }}" class="iq-waves-effect">
                     <img height="30" width="30" class="ply" src="<?php echo  URL::to('/assets/img/icon/cc.svg')?>">
                        <span> Cache Management </span>
                     </a>
                  </li>

                  <li><a href="{{ route('env_index') }}" class="iq-waves-effect">
                     <img height="30" width="30" class="" src="<?php echo  URL::to('/assets/img/icon/cc.svg')?>">
                        <span> Debug  </span>
                     </a>
                  </li>

                  <!-- <li><a href="{{ route('access_forbidden') }}" class="iq-waves-effect">
                     <img height="30" width="30" class="" src="<?php echo  URL::to('/assets/img/icon/cc.svg')?>">
                        <span> {{ __('Restrict Access') }}  </span>
                     </a>
                  </li> -->
                  
                  <li><a href="{{ route('seeding-index') }}" class="iq-waves-effect">
                     <img height="30" width="30" class="ply" src="<?php echo  URL::to('/assets/img/icon/cc.svg')?>">
                        <span> Seeding Management  </span>
                     </a>
                  </li>

                                    <!-- {{-- Contact Us --}} -->
                   <li><p class="lnk">CONTACT US</p></li>

                        <li><a href="{{ URL::to('admin/contact-us/') }}" class="iq-waves-effect">
                              <img height="30" width="30" class="ply" src="<?php echo  URL::to('/assets/img/icon/cq.svg')?>">
                              <span> Contact Request</span>
                           </a>
                        </li>

                   <!-- {{-- Log Activity --}} -->
                  <li><p class="lnk">Log Activity</p></li>

                  <li><a href="{{ URL::to('admin/logActivity') }}" class="iq-waves-effect">
                        <img class="ply" height="30" width="30" class="" src="<?php echo  URL::to('/assets/img/icon/geo.svg')?>">
                        <span>Site Log Activity</span>
                     </a>
                  </li>
                  <!-- Ads Menu ends -->
                  <?php } ?>
                    
               </ul>
            </nav>
         </div>
      </div>

      <div class="main-content">
        
        <div class="row">
        
          <!-- TOP Nav Bar -->
          <div class="iq-top-navbar">
             <div class="iq-navbar-custom">
                <nav class="navbar navbar-expand-lg navbar-light p-0">
                   <div class="iq-menu-bt d-flex align-items-center">
                      <div class="wrapper-menu">
                         <div class="main-circle"><i class="las la-bars"></i></div>
                      </div>
                      <div class="iq-navbar-logo d-flex justify-content-between">
                         <a href="<?php echo URL::to('home') ?>" class="header-logo">
                            <div class="logo-title">
                               <span class="text-primary text-uppercase"><img src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo ; ?>" class="c-logo" width="200"  alt="" style="object-fit:contain;"></span>
                            </div>
                         </a>
                      </div>
                   </div>
                   <?php $TranslationLanguage = App\TranslationLanguage::where('status',1)->get(); ?>
                   <div class="iq-search-bar ml-auto">

                   <!-- Translator Choose -->
                   <?php if(@$translate_checkout == 1){ ?>
                   <div class="right-icon">
                           <svg id="dropdown-icon" style="position: absolute; margin-top: 11px; height: 50px; width: 9%; margin-left: 35%;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-translate" viewBox="0 0 16 16">
                              <path d="M4.545 6.714 4.11 8H3l1.862-5h1.284L8 8H6.833l-.435-1.286H4.545zm1.634-.736L5.5 3.956h-.049l-.679 2.022H6.18z"/>
                              <path d="M0 2a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v3h3a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-3H2a2 2 0 0 1-2-2V2zm2-1a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h7a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H2zm7.138 9.995c.193.301.402.583.63.846-.748.575-1.673 1.001-2.768 1.292.178.217.451.635.555.867 1.125-.359 2.08-.844 2.886-1.494.777.665 1.739 1.165 2.93 1.472.133-.254.414-.673.629-.890-1.125-.253-2.057-.694-2.820-1.284.681-.747 1.222-1.651 1.621-2.757H14V8h-3v1.047h.765c-.318.844-.740 1.546-1.272 2.13a6.066 6.066 0 0 1-.415-.492 1.988 1.988 0 0 1-.940.31z"/>
                           </svg>
                           <div class="dropdown-content" id="languageDropdown">
                           <?php foreach($TranslationLanguage as $Language): ?>
                              <a href="#" class="language-link" id="Language_code" data-Language-code= "{{ @$Language->code }}">{{ @$Language->name }}
                                 <?php if($Language->code == $settings->translate_language) { ?> <span class="selected-icon" >✔</span> <?php } ?>
                              </a>
                           <?php endforeach; ?>
                              <!-- Add more options as needed -->
                           </div>
                     </div>
                   <?php } ?>
                       <div class="pt-2 pull-right">
                            <a class="btn btn-primary" href="<?php echo URL::to('/') ?>" ><span>Visit Website </span><img style="filter: invert(1);" height="25" width="25" class="" src="<?php echo  URL::to('/assets/img/icon/gro.svg')?>"></a>
                       </div>
                      <form action="#" class="searchbox">
                        <!-- <input type="text" class="text search-input" placeholder="Search Here...">
                         <a class="search-link" href="#"><i class="ri-search-line"></i></a>-->
                      </form>
                   </div>
                   <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"  aria-label="Toggle navigation">
                      <i class="ri-menu-3-line"></i>
                   </button>
                   <div class="collapse navbar-collapse" id="navbarSupportedContent">
                      <ul class="navbar-nav ml-auto navbar-list">
                         <li class="nav-item nav-icon search-content">
                            <a href="#" class="search-toggle iq-waves-effect text-gray rounded">
                               <i class="ri-search-line"></i>
                            </a>
                            <form action="#" class="search-box p-0">
                               <input type="text" class="text search-input" placeholder="Type here to search...">
                               <a class="search-link" href="#"><i class="ri-search-line"></i></a>
                            </form>
                         </li>
                        
                         <li class="line-height pt-3">
                            <a href="#" class="search-toggle iq-waves-effect d-flex align-items-center">
                                <?php if(Auth::guest()): ?>
                                         <img src="<?php echo URL::to('/').'/public/uploads/avatars/default.svg' ?>" class="img-fluid avatar-40 rounded-circle" alt="user">
                                          <?php else: ?>
                                     <img src="<?php echo URL::to('/').'/public/uploads/avatars/' . Auth::user()->avatar ?>" class="img-fluid avatar-40 rounded-circle" alt="user">
                                          <?php endif; ?>
                            </a>
                            <div class="iq-sub-dropdown iq-user-dropdown">
                               <div class="iq-card shadow-none m-0">
                                  <div class="iq-card-body p-0 ">
                                     <div class="bg-primary p-3">
                                         <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0 text-white line-height">Hello <?php echo Auth::user()->name; ?> </h5>
                                            <div>
         <input type="checkbox" class="checkbox" id="checkbox" value=<?php echo $theme_mode;  ?>  <?php if($theme_mode == "light") { echo 'checked' ; } ?> />
               <label for="checkbox" class="checkbox-label">
                  <i class="fas fa-moon"></i>
                  <i class="fas fa-sun"></i>
                  <span class="ball"></span>
               </label>
               </div>
                                         </div>
                                        <span class="text-white font-size-12">Available</span>
                                     </div>
                                     <a  href="{{ URL::to('admin/users') }}" class="iq-sub-card iq-bg-primary-hover">
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
                                     <a href="{{ URL::to('/myprofile') }}" class="iq-sub-card iq-bg-primary-hover">
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
    <!--
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
    -->
    <!--
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
    -->
                                     <div class="d-inline-block w-100 text-center p-3">
                                        <a class="bg-primary iq-sign-btn" href="{{ URL::to('/logout') }}" role="button">Sign out<i class="ri-login-box-line ml-2"></i></a>
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
          
      <script>
         $("#checkbox").click(function(){
         
            var theme_mode = $("#checkbox").prop("checked");
         
            $.ajax({
            url: '<?php echo URL::to("admin-theme-mode") ;?>',
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
         let theme_modes = $("#checkbox").val();
         
         $(document).ready(function(){
         
            if( theme_modes == 'dark' ){
               document.body.classList.toggle("dark")
               // const checkbox = document.getElementById("checkbox")
               //    checkbox.addEventListener("change", () => {
               //    document.body.classList.toggle("dark")
               // })
            }else{
               document.body.classList.toggle("light")
            }
         });
      </script>
        <!--<hr />-->
    
        <div id="main-admin-content">
    
          @yield('content')
                
    
        </div>
        
        <!-- Footer -->
        <footer class="iq-footer">
          <div class="container-fluid">
             <div class="row">
                <div class="col-lg-6">
                   <ul class="list-inline mb-0">
                   <?php 
                        $pages = App\Page::all();
                        foreach($pages as $page): 
                        if($page->title == "Privacy Policy" || $page->title =="Terms and Conditions"){ ?>
							<li class="list-inline-item"><a href="<?php echo URL::to('page'); ?><?= '/' . $page->slug ?>"><?= __($page->title) ?></a></li>
						<?php } endforeach; ?>
                      <!-- <li class="list-inline-item"><a href="privacy-policy.html">Privacy Policy</a></li>
                      <li class="list-inline-item"><a href="terms-of-service.html">Terms of Use</a></li> -->
                   </ul>
                </div>
                <div class="col-lg-6 text-right">
                   Copyright <?php echo date('Y'); ?> <a href="<?php echo URL::to('home') ?>"><?php $settings = App\Setting::first(); echo $settings->website_name;?></a>. All Rights Reserved.
                </div>
             </div>
          </div>
       </footer>
      </div>
      
      
    </div>
    
      <!-- Sample Modal (Default skin) -->
      <!--<div class="modal fade" id="sample-modal-dialog-1">
        <div class="modal-dialog">
          <div class="modal-content">
            
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Widget Options - Default Modal</h4>
            </div>
            
            <div class="modal-body">
              <p>Now residence dashwoods she excellent you. Shade being under his bed her. Much read on as draw. Blessing for ignorant exercise any yourself unpacked. Pleasant horrible but confined day end marriage. Eagerness furniture set preserved far recommend. Did even but nor are most gave hope. Secure active living depend son repair day ladies now.</p>
            </div>
            
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
      </div>-->
      
      <!-- Sample Modal (Skin inverted) -->
      <!--<div class="modal invert fade" id="sample-modal-dialog-2">
        <div class="modal-dialog">
          <div class="modal-content">
            
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Widget Options - Inverted Skin Modal</h4>
            </div>
            
            <div class="modal-body">
              <p>Now residence dashwoods she excellent you. Shade being under his bed her. Much read on as draw. Blessing for ignorant exercise any yourself unpacked. Pleasant horrible but confined day end marriage. Eagerness furniture set preserved far recommend. Did even but nor are most gave hope. Secure active living depend son repair day ladies now.</p>
            </div>
            
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
      </div>-->
      
      <!-- Sample Modal (Skin gray) -->
      <!--<div class="modal gray fade" id="sample-modal-dialog-3">
        <div class="modal-dialog">
          <div class="modal-content">
            
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Widget Options - Gray Skin Modal</h4>
            </div>
            
            <div class="modal-body">
              <p>Now residence dashwoods she excellent you. Shade being under his bed her. Much read on as draw. Blessing for ignorant exercise any yourself unpacked. Pleasant horrible but confined day end marriage. Eagerness furniture set preserved far recommend. Did even but nor are most gave hope. Secure active living depend son repair day ladies now.</p>
            </div>
            
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
      </div>-->

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
  <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/jquery.min.js';?>"></script>
  <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/jquery1.min.js';?>"></script>
   <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/popper.min.js';?>"></script>
   <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/jquery.dataTables.min.js';?>"></script>
   <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/dataTables.bootstrap4.min.js';?>"></script>
   <!-- Appear JavaScript -->
   <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/jquery.appear.js';?>"></script>
   <!-- Countdown JavaScript -->
   <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/countdown.min.js';?>"></script>
   <!-- Select2 JavaScript -->
   <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/select2.min.js';?>"></script>
   <!-- Counterup JavaScript -->
   <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/waypoints.min.js';?>"></script>
   <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/jquery.counterup.min.js';?>"></script>
   <!-- Wow JavaScript -->
   <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/wow.min.js';?>"></script>
   <!-- Slick JavaScript -->
   <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/slick.min.js';?>"></script>
   <!-- Owl Carousel JavaScript -->
   <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/owl.carousel.min.js';?>"></script>
   <!-- Magnific Popup JavaScript -->
   <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/jquery.magnific-popup.min.js';?>"></script>
   <!-- Smooth Scrollbar JavaScript -->
   <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/smooth-scrollbar.js';?>"></script>
   <!-- apex Custom JavaScript -->
   <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/apexcharts.js';?>"></script>
   <!-- Chart Custom JavaScript -->
   <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/chart-custom.js';?>"></script>
   <!-- Custom JavaScript -->
   <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/custom.js';?>"></script>
  <!-- End Notifications -->
<?php if($request_url != "filemanager"  && $request_url != 'videos') { ?>
  <?php } ?>
  {{-- ckeditor --}}
  <script src="https://cdn.ckeditor.com/ckeditor5/38.1.1/classic/ckeditor.js"></script>


  @yield('javascript')
 <!--   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

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



if(jQuery('#view-chart-13').length){
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

        var chart = new ApexCharts(document.querySelector("#view-chart-13"), options);
        chart.render();
    }
});
});

</script>
<?php } ?>
    
     <script type="text/javascript">
            $(document).ready(function(){
                $('#submit-update-cat').click(function(){
                    debugger;
                    $('#update-cat-form').submit();
                });
            });
        </script>
  <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/google_analytics_tracking_id.js';?>"></script>
  <?php }else{ ?>
<input type="hidden" id="yes_session" value="yes_session">
<?php } ?>
  <script>
      // alert('$session');
      var session = $('#yes_session').val();
      if(session == "yes_session" ){
          window.location = '<?= URL::to('/') ?>';
      }
   </script>         
    <script>
   //  var tourguide = new Tourguide();
   //  tourguide.start();
</script>
<script>
    const checkbox = document.getElementById("checkbox")
checkbox.addEventListener("change", () => {
   console.log(checkbox);
   thememode = $('#checkbox').val();
   location.reload();
})
          </script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>  

<!-- Translator Choose Script -->
<script>
   // Get the SVG icon and the dropdown content
const dropdownIcon = document.getElementById("dropdown-icon");
const dropdownContent = document.getElementById("languageDropdown");

// Add a click event listener to the SVG icon
dropdownIcon.addEventListener("click", function() {
  // Toggle the visibility of the dropdown content
  if (dropdownContent.style.display === "block") {
    dropdownContent.style.display = "none";
  } else {
    dropdownContent.style.display = "block";
  }
});

$.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

$(".language-link").on("click", function(event) {
  // Prevent the default behavior of the anchor tag
  event.preventDefault();
  var languageCode = $(this).data("language-code");

  $.ajax({
            url: "{{ URL::to('admin/admin_translate_language')  }}",
            type: "post",
                data: {
                  _token: '{{ csrf_token() }}',
                  languageCode: languageCode,
                },      
                  success: function(data){
                     alert("Changed The Language !");
                        setTimeout(function() {
                           location.reload();
                        }, 2000);
                  }
            });

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
  color: #333;
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

</style>

</body>
</html>


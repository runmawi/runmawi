<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Favicon -->
     <link rel="shortcut icon" href="<?= getFavicon();?>" type="image/gif" sizes="16x16">
  
<?php
use Carbon\Carbon;

$uri_path = $_SERVER['REQUEST_URI']; 
$uri_parts = explode('/', $uri_path);
$request_url = end($uri_parts);
$uppercase =  ucfirst($request_url);
$user = Session::get('user'); 
$user = App\ModeratorsUser::where('id',$user->id)->first();
$userrolepermissiom = Session::get('userrolepermissiom '); 

$theme_mode = App\SiteTheme::pluck('CPP_theme_mode')->first();
$theme = App\SiteTheme::first();
// echo "<pre>";
// print_r(auth()->user()->role);
// exit();
?>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo $uppercase; ?> | <?php $settings = App\Setting::first(); echo $settings->website_name;?></title>
  <meta name="description" content= "<?php echo $settings->website_description ; ?>" />
  <meta name="author" content="webnexs" />
  <input type="hidden" value="<?php echo $settings->google_tracking_id ; ?>" name="tracking_id" id="tracking_id">

 <!-- <link rel="stylesheet" href="<?= THEME_URL .'/assets/admin/admin/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css'; ?>">
  <link rel="stylesheet" href="<?= THEME_URL .'/assets/admin/admin/css/font-icons/entypo/css/entypo.css'; ?>">
  <link rel="stylesheet" href="<?= THEME_URL .'/assets/admin/admin/css/font-icons/font-awesome/css/font-awesome.min.css'; ?>">
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
  <link rel="stylesheet" href="<?= THEME_URL .'/assets/admin/admin/css/bootstrap.css'; ?>">
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
   
   <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="<?= URL::to('/'). '/assets/admin/dashassets/css/bootstrap.min.css';?>" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="<?= URL::to('/'). '/assets/admin/dashassets/css/responsive.css';?>" />

   <!--datatable CSS -->
   <link rel="stylesheet" href="<?= URL::to('/'). '/assets/admin/dashassets/css/dataTables.bootstrap4.min.css';?>" />
   <!-- Typography CSS -->
   <link rel="stylesheet" href="<?= URL::to('/'). '/assets/admin/dashassets/css/typography.css';?>" />
   <!-- Style CSS -->
   <link rel="stylesheet" href="<?= URL::to('/'). '/assets/admin/dashassets/css/style.css';?>" />
    <link rel="stylesheet" href="<?= URL::to('/'). '/assets/admin/dashassets/css/vod.css';?>" />
   <!-- Responsive CSS -->
   <link rel="stylesheet" href="<?= URL::to('/'). '/assets/admin/dashassets/css/responsive.css';?>" />

  <!--[if lt IE 9]><script src="<?= THEME_URL .'/assets/admin/admin/js/ie8-responsive-file-warning.js'; ?>"></script><![endif]-->

  <!-- HTML5 shim and Respond.js') }} IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js') }}"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js') }}/1.4.2/respond.min.js') }}"></script>
  <![endif]-->
<style>
  body.dark {background-color: #1d1d1d;} /* #9b59b6 */
    body.dark .list-group-item-action:active{background-color: #1d1d1d!important;} /* #9b59b6 */
    body.dark #progressbar li{background-color: transparent;color: #fff;} /* #9b59b6 */
    body.dark .modal-content{background-color: #1d1d1d!important;} /* #9b59b6 */
    body.dark .iq-sidebar-menu .iq-menu li ul li a:hover {
    background-color: #222428;
    color: #ffffffe6;
} /* #9b59b6 */
    body.dark .content-page{background-color: #1d1d1d;} /* #9b59b6 */
    body.dark .btn-black{background-color: #fff!important;} /* #9b59b6 */
    body.dark .bg-white{background-color: transparent!important;} /* #9b59b6 */
    body.dark #video{background-color: transparent!important;} /* #9b59b6 */
    body.dark .form-control{background: #3e3e3e!important;color: #fff!important;} /* #9b59b6 */
    body.dark .form-control option{background: #3e3e3e!important;color: #fff!important;} /* #9b59b6 */
    body.dark .select2-selection__rendered{background: #3e3e3e!important;} /* #9b59b6 */
    body.dark .r1{background-color:  #222428;color: #ffffffe6;} /* #9b59b6 */
    body.dark .file{background-color: #292c35;} /* #9b59b6 */
    body.dark #sidebar-wrapper .list-group{background-color: ;} /* #9b59b6 */
    body.dark .card-title.upload-ui{background-color: transparent;color: #ffffffe6;} /* #9b59b6 */
    body.dark .dropzone{background-color: transparent;color: #ffffffe6;} /* #9b59b6 */
    body.dark .list-group-flush .list-group-item{background-color: #292c35;color: #fff;box-shadow: 0px 0px 1px #3e3e3e;} /* #9b59b6 */
    body.dark .black{background-color: #222428!important;color: #ffffffe6!important;} /* #9b59b6 */
    body.dark .movie_table tbody td{background-color: #222428;color: #ffffffe6;} /* #9b59b6 */
    body.dark .table-striped tbody tr:nth-of-type(odd){background-color:  #222428;color: #fff;} /* #9b59b6 */
    body.dark .movie_table thead th{background-color: #292c35;color: #ffffffe6!important;} /* #9b59b6 */
    body.dark #msform fieldset{background-color: transparent;padding: 10px;} /* #9b59b6 */
    body.dark .iq-footer{background-color: #1d1d1d;border-top: 1px solid #000;} /* #9b59b6 */
   /* #9b59b6 */
   
    body.dark table.dataTable tbody tr{background-color: #222428;color: #ffffffe6;} /* #9b59b6 */
    body.dark .tab-content{background-color:  #222428;} /* #9b59b6 */
    body.dark .iq-card{background-color: #222428;} /* #9b59b6 */
    body.dark .iq-top-navbar {background-color: #1d1d1d;border-bottom: 1px solid #000;} /* #9b59b6 */
    body.dark .iq-sidebar {background-color: #1d1d1d;border-right: 1px solid #000;} /* #9b59b6 */
    body.dark .iq-menu li a span{color: #ffffffe6;} /* #9b59b6 */
    /*body.dark h1,h2,h3,h4,h5,h6{color: #fff;}*/
    body.dark label{color: #ffffffe6;}
    body.dark .iq-bg-warning{color: #fff!importan; background:transparent!important;}
    body.dark .iq-bg-success{color: #fff!important; background:transparent!important;}
    body.dark .iq-bg-danger{ color: #fff!important; background:transparent!important;}
    body.dark #progressbar li.active{color: blue!important;}
    body.dark #progressbar li img{filter: invert(1);}
    body.dark .ply{filter: invert(1);}
    body.dark .fs-title{color: #ffffffe6;}
    body.dark .panel-body{color: #ffffffe6!important;}
    body.dark .iq-submenu li>a{color: #ffffffe6;}
    body.dark #optionradio{color: #fff;}
    body.dark .dropzone .dz-message .dz-button{color: #fff;}
    body.dark th{color: #ffffffe6;}
    body.dark .table-bordered td, .table-bordered th {color: #ffffffe6;}
    body.dark .tags-input-wrapper input{color: #000;background: #fff!important;}
    body.dark h3{color: #ffffffe6;}
    body.dark h4{color: #ffffffe6;}
    body.dark h5{color: #ffffffe6;}
    body.dark .theme_name{color: #ffffffe6;}
    body.dark h6{color: #ffffffe6;}
    body.dark .upload-ui{color: #000;}
    body.dark div.dataTables_wrapper div.dataTables_info{color: #ffffffe6!important;}
    body.dark .line{color: #fff;}
    body.dark .dataTables_info{color: #ffffffe6;}
    body.dark .list-inline-item a{color: #ffffffe6;}
    body.dark .val{color: #fff;}
    body.dark .main-circle i{color: #ffffffe6;}
    body.dark .text-right{color: #ffffffe6;}
    body.dark .iq-arrow-right{color: #ffffffe6;}
    body.dark .form-group{color: #ffffffe6;}
    body.dark p{color: #ffffffe6!important;}
body.dark h1, body.dark .support a {color: #ffffffe6;}
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
    .progress{
        height: 6px;
    }
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

</style>

</head>
<body >

                 
<?php

// dd($settings);
for($i=0;$i<(count($userrolepermissiom));$i++){    
   $role[] = $userrolepermissiom[$i]->name; 
}

?>
<div class="page-container sidebar-collapsed"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
  <!-- Sidebar-->
      <div class="iq-sidebar">
         <div class=" d-flex justify-content-between align-items-center">
            <a href="<?php echo URL::to('cpp/dashboard') ?>" class="header-logo mt-2">
               <img src="<?php echo URL::to('/').'/public/uploads/settings/'.$settings->logo;?>" class="img-fluid rounded-normal" alt="">
               <div class="logo-title">
               </div>
            </a>
            <div class="iq-menu-bt-sidebar">
               <div class="iq-menu-bt align-self-center">
                  <div class="wrapper-menu mt-2">
                     <div class="main-circle"><i class="las la-bars"></i></div>
                  </div>
               </div>
            </div>
         </div>
         <div id="sidebar-scrollbar">
            <nav class="iq-sidebar-menu">
               <ul id="iq-sidebar-toggle" class="iq-menu">
                  <!-- <li><a href="<?php echo URL::to('home') ?>" class="text-primary"><i class="ri-arrow-right-line"></i><span>Visit site</span></a></li> -->
                  <?php if( in_array( "Dashboard" ,$role)){ ?>
                     
                  <li class="active active-menu"><a href="<?php echo URL::to('/cpp/dashboard') ?>" class="iq-waves-effect"><img height="40" width="40" src="<?php echo  URL::to('/assets/img/icon/home.svg')?>"><span>Dashboard</span></a></li>
                  <?php }else{ } ?>
                  <?php if( in_array( "Video Management" ,$role)){ ?>

 <li><a href="#video" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="" height="40" width="40" src="<?php echo  URL::to('/assets/img/sidemenu/vi.svg')?>"><span>Video Management </span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
 <ul id="video" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
 <?php if( in_array( "All Videos" ,$role)){ ?>
       <li><a href="{{ URL::to('/cpp/videos') }}">All Videos</a></li>
       <?php }else{ } ?>
       <?php if( in_array( "Add New Video" ,$role)){ ?>
       <li><a href="{{ URL::to('/cpp/videos/create') }}">Add New Video</a></li>
       <?php }else{ } ?>
       <?php if( in_array( "Manage Video Categories" ,$role)){ ?>
       <li><a href="{{ URL::to('/cpp/videos/categories') }}">Manage Video Categories</a></li>
       <?php }else{ } ?>

      </ul></li>
<?php }else{ } ?>
                  <?php if( in_array( "Series & Episodes" ,$role)){ ?>
   <li><a href="#series" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="" height="40" width="40" src="<?php echo  URL::to('/assets/img/icon/tv.svg')?>"><span>Series & Episodes </span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
            <ul id="series" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
            <?php if( in_array( "Series List" ,$role)){ ?>
              <li><a href="{{ URL::to('cpp/series_list') }}">Series List</a></li>
              <li><a href="{{ URL::to('cpp/series/create') }}">Add New Series</a></li>
             <?php }else{ } ?>
            <?php if( in_array( "Manage Series Genre" ,$role)){ ?>         
              <!-- <li><a href="{{ URL::to('cpp/Series/Genre') }}"><i class="las la-eye"></i>Manage Series Genre</a></li> -->
              <?php }else{ } ?>
            </ul>
          </li>   
           <?php }else{ } ?>    
           
           <?php if( in_array( "Audio Management" ,$role)){ ?>
           <li><a href="#audios" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="" height="40" width="40" src="<?php echo  URL::to('/assets/img/icon/music.svg')?>"><span>Audio Management </span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
            <ul id="audios" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
            <?php if( in_array( "Audio List" ,$role)){ ?>
              <li><a href="{{ URL::to('/cpp/audios') }}">Audio List</a></li>
              <?php }else{ } ?>    
              <?php if( in_array( "Add New Audio" ,$role)){ ?>
              <li><a href="{{ URL::to('/cpp/audios/create') }}">Add New Audio</a></li>
              <?php }else{ } ?>    
              <?php if( in_array( "Manage Audio Categories" ,$role)){ ?>
              <li><a href="{{ URL::to('/cpp/audios/categories') }}">Manage Audio Categories</a></li>
           <?php }else{ } ?>    
              <?php if( in_array( "Manage Albums" ,$role)){ ?>
              <li><a href="{{ URL::to('/cpp/audios/albums') }}">Manage Albums</a></li>
              <?php }else{ } ?>    
            </ul>
          </li>
          <li><a href="#artists" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img height="40" width="40" class="" src="<?php echo  URL::to('/assets/img/icon/art.svg')?>"><span>Artist Management </span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
            <ul id="artists" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
              <li><a href="{{ URL::to('cpp/artists') }}">All Artists</a></li>
              <li><a href="{{ URL::to('cpp/artists/create') }}"> Add New Artist</a></li>

            </ul>
          </li>
          <?php }else{ } ?>    
          <?php if( in_array( "Artist Management" ,$role)){ ?>

          <li><a href="#artists" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="las la-user"></i><span>Artist Management </span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
            <ul id="artists" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
   <?php if( in_array( "All Artists" ,$role)){ ?>
              <li><a href="{{ URL::to('/cpp/artists') }}">All Artists</a></li>
              <?php }else{ } ?>    
   <?php if( in_array( "Add New Artist" ,$role)){ ?>
              <li><a href="{{ URL::to('/cpp/artists/create') }}">Add New Artist</a></li>
              <?php }else{ } ?>    

            </ul>
          </li>

          <?php }else{ } ?>    

   <?php if( in_array( "Manage Live Videos" ,$role)){ ?>
        
                   <li>
                     <a href="#live-video" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img height="40" width="40" class="" src="<?php echo  URL::to('/assets/img/icon/live.svg')?>"><span>Manage Live Videos</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                     <ul id="live-video" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
       <?php if( in_array( "All Live Videos" ,$role)){ ?>  
                     <li><a href="{{ URL::to('/cpp/livestream') }}">All Live Videos</a></li>
                     <?php }else{ } ?>
       <?php if( in_array( "Add New Live Video" ,$role)){ ?>   
                     <li><a href="{{ URL::to('/cpp/livestream/create') }}">Add New Live Video</a></li>
                     <?php }else{ } ?>
       <?php if( in_array( "Manage Live Video Categories" ,$role)){ ?>   
                     <li><a href="{{ URL::to('/cpp/livestream/categories') }}">Manage Live Video Categories</a></li>
                     <?php }else{ } ?>
                     <li><a href="{{ URL::to('/cpp/live-event-artist') }}">Manage Live Event Create</a></li>
                  </ul>
                  </li>
           <?php }else{ } ?>             
            <?php if( in_array( "Users" ,$role)){ ?>

                  <li><a href="#user" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="las la-user-friends"></i><span>Users</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                       <ul id="user" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
       <?php if( in_array( "All Users" ,$role)){ ?>
                       <li><a href="{{ URL::to('users') }}">All Users</a></li>
                       <?php }else{ } ?>
       <?php if( in_array( "Add New User" ,$role)){ ?> 
                       <li><a href="{{ URL::to('user_create') }}">Add New User</a></li>
                       <?php }else{ } ?>
       <?php if( in_array( "Add User Roles" ,$role)){ ?> 
                       <li><a href="{{ URL::to('admin_roles') }}">Add User Roles</a></li>
                       <?php }else{ } ?>
                     </ul>
                      
                   </li>
           <?php }else{ } ?>             
            <?php if( in_array( "Menu" ,$role)){ ?>

                   <li><a href="{{ URL::to('menu') }}" class="iq-waves-effect"><i class="ri-price-tag-line"></i><span>Menu</span></a></li>
                  <li>
                     <a href="#language" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="las la-list-ul"></i><span>Manage Languages </span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                     <ul id="language" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
       <?php if( in_array( "Video Languages" ,$role)){ ?> 
                     <li><a href="{{ URL::to('admin_languages') }}">Video Languages</a></li>
                     <?php }else{ } ?>
       <?php if( in_array( "Manage Translations" ,$role)){ ?>
                     <li><a href="{{ URL::to('languages') }}">Manage Translations</a></li>
                     <?php }else{ } ?>
       <?php if( in_array( "Manage Transulate Languages" ,$role)){ ?>   
                     <li><a href="{{ URL::to('admin_languages_transulates') }}"><i class="las la-eye"></i>Manage Translate Languages</a></li>
                     <?php }else{ } ?>
                  </ul>
                  </li>
           <?php }else{ } ?>             
            <?php if( in_array( "Manage Countries" ,$role)){ ?>

                    <li><a href="{{ URL::to('managecountry') }}" class="iq-waves-effect"><span>Manage Countries</span></a></li>
           <?php }else{ } ?>             
            <?php if( in_array( "Manage Sliders" ,$role)){ ?>

            <li><a href="{{ URL::to('slider') }}" class="iq-waves-effect"><span>Manage Sliders</span></a></li>
<?php }else{ } ?> 
   <?php if( in_array( "Player UI" ,$role)){ ?>

   <li><a href="{{ URL::to('players') }}" class="iq-waves-effect"><i class="ri-price-tag-line"></i><span>Player UI</span></a></li>
<?php }else{ } ?> 
   <?php if( in_array( "Moderate" ,$role)){ ?>

   <!--    <li><a href="{{ URL::to('moderator') }}" class="iq-waves-effect"><i class="ri-price-tag-line"></i><span>Moderate</span></a></li> -->
<?php }else{ } ?> 
                   
         
   <?php if( in_array( "Pages" ,$role)){ ?>
                  
                  <li>
                     <a href="#pages" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img height="40" width="40" class="" src="<?php echo  URL::to('/assets/img/icon/page.svg')?>"><span>Pages</span><i
                        class="ri-arrow-right-s-line iq-arrow-right"></i>
                     </a>
                     <ul id="pages" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
       <?php if( in_array( "All Pages" ,$role)){ ?>   
                     <li><a href="{{ URL::to('/cpp/pages') }}"><i class="las la-user-plus"></i>All Pages</a></li>
                     <?php }else{ } ?>
                  </ul>
                  </li>


                  
<?php }else{ } ?> 
                  <li>
                     <a href="#analytics_managements" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img height="40" width="40" class="" src="<?php echo  URL::to('/assets/img/icon/ana.svg')?>">
                     <span>Analytics</span><i
                        class="ri-arrow-right-s-line iq-arrow-right"></i>
                     </a>
                     <ul id="analytics_managements" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ URL::to('/cpp/video-analytics') }}">Video Analytics </a></li>
                        <li><a href="{{ URL::to('/cpp/view_by_region') }}">Video View BY Region  </a></li>
                        <li><a href="{{ URL::to('/cpp/payouts') }}">Video Payouts </a></li>
                        <li><a href="{{ URL::to('/cpp/live-payouts') }}">LiveStream Payouts </a></li>
                     </ul>
                  </li>
   <?php if( in_array( "Plans" ,$role)){ ?>
                   
                    <li>
                     <a href="#plans" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i
                        class="las la-film"></i><span>Plans</span><i
                        class="ri-arrow-right-s-line iq-arrow-right"></i>
                     </a>
                     <ul id="plans" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
       <?php if( in_array( "Manage Stripe plans" ,$role)){ ?>  
                     <li><a href="{{ URL::to('plans') }}"><i class="las la-user-plus"></i>Manage Stripe plans</a></li>
                     <?php }else{ } ?>
       <?php if( in_array( "Manage Paypal plans" ,$role)){ ?>
                     <li><a href="{{ URL::to('admin_paypalplans') }}"><i class="las la-eye"></i>Manage Paypal plans</a></li>
                     <?php }else{ } ?>
       <?php if( in_array( "Manage Stripe Coupons" ,$role)){ ?>   
                     <li><a href="{{ URL::to('admin_coupons') }}"><i class="las la-eye"></i>Manage Stripe Coupons</a></li>
                     <?php }else{ } ?>
                  </ul>
                  </li>
<?php }else{ } ?> 

   <?php if( in_array( "Settings" ,$role)){ ?>

                    <li>
                     <a href="#settings" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="ri-settings-4-line "></i><span>Settings</span><i
                        class="ri-arrow-right-s-line iq-arrow-right"></i>
                     </a>
                     <ul id="settings" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                  <?php if( in_array( "Mobile App Settings" ,$role)){ ?>

                        <li><a href="{{ URL::to('admin_mobileapp') }}"><i class="las la-user-plus"></i>Mobile App Settings</a></li>
                        <?php }else{ } ?> 
                        <?php if( in_array( "Site Settings" ,$role)){ ?>

                        <li><a href="{{ URL::to('admin_settings') }}"><i class="las la-eye"></i>Site Settings</a></li>
                        <?php }else{ } ?> 
                        <?php if( in_array( "Payment Settings" ,$role)){ ?>
                        
                        <li><a href="{{ URL::to('admin_payment_settings') }}"><i class="las la-eye"></i>Payment Settings</a></li>
                        <?php }else{ } ?> 
                        <?php if( in_array( "HomePage Settings" ,$role)){ ?>  
                        <li><a href="{{ URL::to('admin_home_settings') }}"><i class="las la-eye"></i>HomePage Settings</a></li>
                        <?php }else{ } ?> 
                        <?php if( in_array( "System Settings" ,$role)){ ?>  
                        <li><a href="{{ URL::to('admin_system_settings') }}"><i class="las la-eye"></i>System Settings</a></li>
                        <?php }else{ } ?> 
                        <?php if( in_array( "Theme Settings" ,$role)){ ?>
 
                        <li><a href="{{ URL::to('admin_theme_settings') }}"><i class="las la-eye"></i>Theme Settings</a></li>
                        <?php }else{ } ?> 
                        

                     </ul>
                  </li>
                  <li>
                     <a href="#analytics_managements" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="" height="40" width="40" src="<?php echo  URL::to('/assets/img/icon/ana.svg')?>"><span>Analytics</span><i
                        class="ri-arrow-right-s-line iq-arrow-right"></i>
                     </a>
                     <ul id="analytics_managements" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ URL::to('/cpp/video-analytics') }}"><i class="las la-user-plus"></i>Video Analytics </a></li>
                        <li><a href="{{ URL::to('/cpp/view_by_region') }}"><i class="las la-user-plus"></i>Video View BY Region  </a></li>
                        <li><a href="{{ URL::to('/cpp/payouts') }}"><i class="las la-user-plus"></i>Payouts </a></li>
                     </ul>
                  </li>
                   <?php }else{

                   } ?>
                  <li><a href="{{ URL::to('/cpp/my-account') }}"><img class="" height="40" width="40" src="<?php echo  URL::to('/assets/img/ab.svg')?>"><span>About My Profile</span></a></li>
               
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
                               <span class="text-primary text-uppercase"><?php $settings = App\Setting::first(); echo $settings->website_name;?></span>
                            </div>
                         </a>
                      </div>
                   </div>


                   <div class="iq-search-bar ml-auto" style="margin-left: 59% !important;margin-top: -1% !important;">
                      <!-- <form method="POST" action="{{ URL::to('login') }}" class="">
                        <input type="text" class="text search-input" placeholder="Search Here...">
                         <a class="search-link" href="#"><i class="ri-search-line"></i></a>
                         <input id="email" type="hidden"  name="email"  value="{{  $user->email }}"  autocomplete="email" autofocus>
                         <input id="password" type="hidden"  name="password" value="{{  $user->password }}" autocomplete="current-password" >
                         <input type="hidden" name="token" id= "token" value="{{ csrf_token() }}">

                         <button type="submit" class="btn btn-hover ab" style="color: blue;">Visit Website</button>
                      </form> -->


                      <form method="POST" action="{{ route('login') }}" class="mt-4">
                         @csrf
						   <input type="hidden" name="previous" value="{{ url()->previous() }}">						

                  <input id="email" type="hidden"  name="email"  value="{{  $user->email }}"  autocomplete="email" autofocus>
                         <input id="password" type="hidden"  name="password" value="{{  $user->password }}" autocomplete="current-password" >
                              <button type="submit" class="btn btn-hover ab" style="">Visit Website </button>                          
                     </form>

                   </div>


                     <?php $Channel = App\Channel::where('email', $user->email)->first(); ?>
                     <?php if(!empty($Channel)){ ?>
                           <div class="iq-search-bar ml-auto">
                           <form method="POST" action="<?php echo URL::to('channel/home') ?>" class="mt-4">
                              <input type="hidden" name="_token" id= "token" value="<?= csrf_token() ?>">
                                    <input id="email" type="hidden"  name="email"  value="<?=  $Channel->email ?>"  autocomplete="email" autofocus>
                                    <input id="password" type="hidden"  name="password" value="<?=  $Channel->unhased_password ?>" autocomplete="current-password" >
                                    <button type="submit" class="btn btn-hover" style="margin-top: -6%;margin-left: -65%;">Channel Visit Portal </button>                          
                           </form>
                        </div>
                        <?php } ?>
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
                             
                                     <img src="<?php echo URL::to('/').'/public/uploads/moderator_albums/' . $user->picture ?>" class="img-fluid avatar-40 rounded-circle" alt="user">
                            </a>
                            <div class="iq-sub-dropdown iq-user-dropdown">
                               <div class="iq-card shadow-none m-0">
                                  <div class="iq-card-body p-0 ">
                                     <div class="bg-primary p-3 d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0 text-white line-height">Hello <?php echo $user->username; ?> </h5>
                                         <div>
              <input type="checkbox" class="checkbox" id="checkbox" value=<?php echo $theme_mode;  ?>  <?php if($theme_mode == "light") { echo 'checked' ; } ?> />
               <label for="checkbox" class="checkbox-label">
                  <i class="fas fa-moon"></i>
                  <i class="fas fa-sun"></i>
                  <span class="ball"></span>
               </label>
               </div>  </div>
                                        <span class="text-white font-size-12">Available</span>
                                   
                                     <a  href="{{ URL::to('cpp/myprofile') }}" class="iq-sub-card iq-bg-primary-hover">
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
                                        <a class="bg-primary iq-sign-btn" href="{{ URL::to('/cpp/logout') }}" role="button">Sign out<i class="ri-login-box-line ml-2"></i></a>
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
    
        <div id="main-admin-content">
    
          @yield('content')
                
    
        </div>
        
        <!-- Footer -->
        <footer class="iq-footer">
          <div class="container-fluid">
             <div class="row">
                <div class="col-lg-6">
                   <ul class="list-inline mb-0">
                      <li class="list-inline-item"><a href="privacy-policy.html">Privacy Policy</a></li>
                      <li class="list-inline-item"><a href="terms-of-service.html">Terms of Use</a></li>
                   </ul>
                </div>
                <div class="col-lg-6 text-right">
              <?php echo $settings->website_name ; ?> - <?php echo Carbon::now()->year ; ?> All Rights Reserved
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

  @yield('javascript')
 <!--   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

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

        
  <script>
         $("#checkbox").click(function(){
         
            var theme_mode = $("#checkbox").prop("checked");
        //  alert(theme_mode);
            $.ajax({
            url: '<?php echo URL::to("cpp-theme-mode") ;?>',
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
            }
         });
      </script>
     <script>
    const checkbox = document.getElementById("checkbox")
checkbox.addEventListener("change", () => {
  document.body.classList.toggle("dark")
})
          </script>                      
    
</body>
</html>
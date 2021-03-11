<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    $jsonString = file_get_contents(base_path('assets/country_code.json'));   

    $jsondata = json_decode($jsonString, true); 
?>

	<!--<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="HelloVideo Admin Panel" />
	<meta name="author" content="" />

	<title><?php $settings = App\Setting::first(); echo $settings->website_name;?></title>

	<link rel="stylesheet" href="<?= THEME_URL .'/assets/admin/admin/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css'; ?>">
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
    <!-- Required meta tags -->
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <title>Flicknexs</title>
   <!-- Favicon -->
   <link rel="shortcut icon" href="<?= URL::to('/'). '/assets/admin/dashassets/images/fl-logo.png';?>" />
   <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="<?= URL::to('/'). '/assets/admin/dashassets/css/bootstrap.min.css';?>" />
    
   <link rel="stylesheet" href="<?= URL::to('/'). '/assets/admin/dashassets/css/responsive.css';?>" />

   <!--datatable CSS -->
   <link rel="stylesheet" href="<?= URL::to('/'). '/assets/admin/dashassets/css/dataTables.bootstrap4.min.css';?>" />
   <!-- Typography CSS -->
   <link rel="stylesheet" href="<?= URL::to('/'). '/assets/admin/dashassets/css/typography.css';?>" />
   <!-- Style CSS -->
   <link rel="stylesheet" href="<?= URL::to('/'). '/assets/admin/dashassets/css/style.css';?>" />
   <!-- Responsive CSS -->
   <link rel="stylesheet" href="<?= URL::to('/'). '/assets/admin/dashassets/css/responsive.css';?>" />
    
    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	<!--[if lt IE 9]><script src="<?= THEME_URL .'/assets/admin/admin/js/ie8-responsive-file-warning.js'; ?>"></script><![endif]-->

	<!-- HTML5 shim and Respond.js') }} IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js') }}"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js') }}/1.4.2/respond.min.js') }}"></script>
	<![endif]-->
<style>

    .top-left-logo img {
        opacity: 0.9;
        overflow: hidden;
    }
    
    
</style>
    <style>
    .form-popup {
  display: none;
    }
    .personal{
        border-top: 1px solid #999;
        padding-bottom: 20px;
    }
    .Subplan{
        border-top: 1px solid #999;
        padding-bottom: 20px;
    }
    .Profile{
        border-top: 1px solid #999;
        padding-bottom: 20px;
    }
     .card{
        border-top: 1px solid #999;
         padding-bottom: 20px;
    }
    .details-back{
       background-color: transparent;
    margin-left: 350px;
    top: 80px;
    }
    .btn-primary {
    background: #4895d1;
    border-color: #4895d1;
}
    .btn-primary:hover, .btn-primary:focus, .btn-primary:active, .btn-primary.active, .open .dropdown-toggle.btn-primary {
    background-color: #4895d1;
    border-color: #4895d1;
}
    .data-back{
        background-color: #333;
    opacity: 0.5;
    height: 460px;
    }
    .editbtn{
        float: right;
    }
    input.form-control#email {
     background-color: #1a1b20; 
     border: none; 
    color: #fff;
    box-shadow: none;
}
    input.form-control#password {
   background-color: #1a1b20; 
     border: none; 
    color: #fff;
    box-shadow: none;
}
    #update_profile_form .form-control {
    background: #1a1b20 !important;
   border: none;
    color: #fff;
}
        select{
            width: 100% !important;
        }
        .content-page {
    overflow: hidden;
     margin-left: 0px !important; 
     padding: unset !important; 
    min-height: 100vh;
    -webkit-transition: all 0.3s ease-out 0s;
    -moz-transition: all 0.3s ease-out 0s;
    -ms-transition: all 0.3s ease-out 0s;
    -o-transition: all 0.3s ease-out 0s;
    transition: all 0.3s ease-out 0s;
    margin-top: 110px;
}
        .iq-top-navbar {
    padding: 0 15px 0 30px;
    min-height: 73px;
    position: fixed;
    top: 0;
    left: auto;
    /* right: 0; */
    width: 100%;
    display: inline-block;
    z-index: 99;
    background: var(--iq-light-card);
    margin: 0;
    transition: all 0.45s ease 0s;
}
        .iq-footer {
    background: var(--iq-light-card);
    padding: 15px;
    margin-left: 0px !important; 
    -webkit-transition: all 0.3s ease-out 0s;
    -moz-transition: all 0.3s ease-out 0s;
    -ms-transition: all 0.3s ease-out 0s;
    -o-transition: all 0.3s ease-out 0s;
    transition: all 0.3s ease-out 0s;
}
</style>

</head>
<body >


<!--<div class="page-container sidebar-collapsed">--><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
  <!-- Sidebar-->
     <!-- <div class="iq-sidebar">
         <div class="iq-sidebar-logo d-flex justify-content-between">
            <a href="<?php echo URL::to('home') ?>" class="header-logo">
               <img <img src="<?php echo URL::to('/'). '/assets/admin/dashassets/images/fl-logo.png';?>" class="img-fluid rounded-normal" alt="">
               <div class="logo-title">
                  <span class="text-primary text-uppercase">Flicknexs</span>
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
                  <li><a href="<?php echo URL::to('home') ?>" target="_blank" class="text-primary"><i class="ri-arrow-right-line"></i><span>Visit site</span></a></li>
                  <li class="active active-menu"><a href="<?php echo URL::to('admin') ?>" class="iq-waves-effect"><i class="las la-home iq-arrow-left"></i><span>Dashboard</span></a></li>
                   
                  <li><a href="#video" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="las la-star-half-alt"></i><span>Video Management </span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                   <ul id="video" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                         <li><a href="{{ URL::to('admin/videos') }}"><i class="las la-user-plus"></i>All Videos</a></li>
                        <li><a href="{{ URL::to('admin/videos/create') }}"><i class="las la-eye"></i>Add New Video</a></li>
                         <li><a href="{{ URL::to('admin/videos/categories') }}"><i class="las la-eye"></i>Manage Video Categories</a></li>
                    
					</ul></li>
                   <li>
                     <a href="#live-video" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="las la-film"></i><span>Manage Live Videos</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                     <ul id="live-video" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ URL::to('admin/livestream') }}"><i class="las la-user-plus"></i>All Live Videos</a></li>
                        <li><a href="{{ URL::to('admin/livestream/create') }}"><i class="las la-eye"></i>Add New Live Video</a></li>
                         <li><a href="{{ URL::to('admin/livestream/categories') }}"><i class="las la-eye"></i>Manage Live Video Categories</a></li>
                     </ul>
                  </li>
                  <li><a href="#user" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="las la-user-friends"></i><span>Users</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                       <ul id="user" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ URL::to('admin/users') }}"><i class="las la-user-plus"></i>All Users</a></li>
                        <li><a href="{{ URL::to('admin/user/create') }}"><i class="las la-eye"></i>Add New User</a></li>
                         <li><a href="{{ URL::to('admin/roles') }}"><i class="las la-eye"></i>Add User Roles</a></li>
                     </ul>
                      
                   </li>
                   <li><a href="{{ URL::to('admin/menu') }}" class="iq-waves-effect"><i class="ri-price-tag-line"></i><span>Menu</span></a></li>
                  <li>
                     <a href="#language" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="las la-list-ul"></i><span>Manage Languages </span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                     <ul id="language" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ URL::to('admin/admin-languages') }}"><i class="las la-user-plus"></i>Video Languages</a></li>
                        <li><a href="{{ URL::to('admin/languages') }}"><i class="las la-eye"></i>Manage Translations</a></li>
                         <li><a href="{{ URL::to('admin/admin-languages-transulates') }}"><i class="las la-eye"></i>Manage Transulate Languages</a></li>
                     </ul>
                  </li>
                    <li><a href="{{ URL::to('admin/countries') }}" class="iq-waves-effect"><i class="ri-price-tag-line"></i><span>Manage Countries</span></a></li>
                   
                   <li><a href="{{ URL::to('admin/sliders') }}" class="iq-waves-effect"><i class="ri-price-tag-line"></i><span>Manage Sliders</span></a></li>
                  
                  <li>
                     <a href="#pages" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i
                       class="las la-file-alt iq-arrow-left"></i><span>Pages</span><i
                        class="ri-arrow-right-s-line iq-arrow-right"></i>
                     </a>
                     <ul id="pages" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ URL::to('admin/pages') }}"><i class="las la-user-plus"></i>All Pages</a></li>
                     </ul>
                  </li>
                   
                    <li>
                     <a href="#plans" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i
                        class="las la-film"></i><span>Plans</span><i
                        class="ri-arrow-right-s-line iq-arrow-right"></i>
                     </a>
                     <ul id="plans" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ URL::to('admin/plans') }}"><i class="las la-user-plus"></i>Manage Stripe plans</a></li>
                        <li><a href="{{ URL::to('admin/paypalplans') }}"><i class="las la-eye"></i>Manage Paypal plans</a></li>
                         <li><a href="{{ URL::to('admin/coupons') }}"><i class="las la-eye"></i>Manage Stripe Coupons</a></li>
                     </ul>
                  </li>
                    <li>
                     <a href="#settings" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="ri-settings-4-line "></i><span>Settings</span><i
                        class="ri-arrow-right-s-line iq-arrow-right"></i>
                     </a>
                     <ul id="settings" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ URL::to('admin/mobileapp') }}"><i class="las la-user-plus"></i>Mobile App Settings</a></li>
                        <li><a href="{{ URL::to('admin/settings') }}"><i class="las la-eye"></i>Site Settings</a></li>
                         <li><a href="{{ URL::to('admin/payment_settings') }}"><i class="las la-eye"></i>Payment Settings</a></li>
                          <li><a href="{{ URL::to('admin/home-settings') }}"><i class="las la-eye"></i>HomePage Settings</a></li>
                          <li><a href="{{ URL::to('admin/system_settings') }}"><i class="las la-eye"></i>System Settings</a></li>
                          <li><a href="{{ URL::to('admin/theme_settings') }}"><i class="las la-eye"></i>Theme Settings</a></li>
                     </ul>
                  </li>
                  
                  <li>
                     <a href="#ui-elements" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="lab la-elementor iq-arrow-left"></i><span>UI Elements</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                     <ul id="ui-elements" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class="elements">
                           <a href="#sub-menu" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="ri-play-circle-line"></i><span>UI Kit</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                           <ul id="sub-menu" class="iq-submenu collapse" data-parent="#ui-elements">
                              <li><a href="ui-colors.html"><i class="las la-palette"></i>colors</a></li>
                              <li><a href="ui-typography.html"><i class="las la-keyboard"></i>Typography</a></li>
                              <li><a href="ui-alerts.html"><i class="las la-tag"></i>Alerts</a></li>
                              <li><a href="ui-badges.html"><i class="lab la-atlassian"></i>Badges</a></li>
                              <li><a href="ui-breadcrumb.html"><i class="las la-bars"></i>Breadcrumb</a></li>
                              <li><a href="ui-buttons.html"><i class="las la-tablet"></i>Buttons</a></li>
                              <li><a href="ui-cards.html"><i class="las la-credit-card"></i>Cards</a></li>
                              <li><a href="ui-carousel.html"><i class="las la-film"></i>Carousel</a></li>
                              <li><a href="ui-embed-video.html"><i class="las la-video"></i>Video</a></li>
                              <li><a href="ui-grid.html"><i class="las la-border-all"></i>Grid</a></li>
                              <li><a href="ui-images.html"><i class="las la-images"></i>Images</a></li>
                              <li><a href="ui-list-group.html"><i class="las la-list"></i>list Group</a></li>
                              <li><a href="ui-media-object.html"><i class="las la-ad"></i>Media</a></li>
                              <li><a href="ui-modal.html"><i class="las la-columns"></i>Modal</a></li>
                              <li><a href="ui-notifications.html"><i class="las la-bell"></i>Notifications</a></li>
                              <li><a href="ui-pagination.html"><i class="las la-ellipsis-h"></i>Pagination</a></li>
                              <li><a href="ui-popovers.html"><i class="las la-eraser"></i>Popovers</a></li>
                              <li><a href="ui-progressbars.html"><i class="las la-hdd"></i>Progressbars</a></li>
                              <li><a href="ui-tabs.html"><i class="las la-database"></i>Tabs</a></li>
                              <li><a href="ui-tooltips.html"><i class="las la-magnet"></i>Tooltips</a></li>
                           </ul>
                        </li>
                        <li class="form">
                           <a href="#forms" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="lab la-wpforms"></i><span>Forms</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                           <ul id="forms" class="iq-submenu collapse" data-parent="#ui-elements">
                              <li><a href="form-layout.html"><i class="las la-book"></i>Form Elements</a></li>
                              <li><a href="form-validation.html"><i class="las la-edit"></i>Form Validation</a></li>
                              <li><a href="form-switch.html"><i class="las la-toggle-off"></i>Form Switch</a></li>
                              <li><a href="form-chechbox.html"><i class="las la-check-square"></i>Form Checkbox</a></li>
                              <li><a href="form-radio.html"><i class="ri-radio-button-line"></i>Form Radio</a></li>
                           </ul>
                        </li>
                        <li>
                           <a href="#wizard-form" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="ri-archive-drawer-line"></i><span>Forms Wizard</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                           <ul id="wizard-form" class="iq-submenu collapse" data-parent="#ui-elements">
                              <li><a href="form-wizard.html"><i class="ri-clockwise-line"></i>Simple Wizard</a></li>
                              <li><a href="form-wizard-validate.html"><i class="ri-clockwise-2-line"></i>Validate Wizard</a></li>
                              <li><a href="form-wizard-vertical.html"><i class="ri-anticlockwise-line"></i>Vertical Wizard</a></li>
                           </ul>
                        </li>
                        <li>
                           <a href="#tables" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="ri-table-line"></i><span>Table</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                           <ul id="tables" class="iq-submenu collapse" data-parent="#ui-elements">
                              <li><a href="tables-basic.html"><i class="ri-table-line"></i>Basic Tables</a></li>
                              <li><a href="data-table.html"><i class="ri-database-line"></i>Data Table</a></li>
                              <li><a href="table-editable.html"><i class="ri-refund-line"></i>Editable Table</a></li>
                           </ul>
                        </li>
                        <li>
                           <a href="#icons" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="ri-list-check"></i><span>Icons</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                           <ul id="icons" class="iq-submenu collapse" data-parent="#ui-elements">
                              <li><a href="icon-dripicons.html"><i class="ri-stack-line"></i>Dripicons</a></li>
                              <li><a href="icon-fontawesome-5.html"><i class="ri-facebook-fill"></i>Font Awesome 5</a></li>
                              <li><a href="icon-lineawesome.html"><i class="ri-keynote-line"></i>line Awesome</a></li>
                              <li><a href="icon-remixicon.html"><i class="ri-remixicon-line"></i>Remixicon</a></li>
                              <li><a href="icon-unicons.html"><i class="ri-underline"></i>unicons</a></li>
                           </ul>
                        </li>
                     </ul>
                  </li>
                  <li>
                     <a href="#pages" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="las la-file-alt iq-arrow-left"></i><span>Pages</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                     <ul id="pages" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li>
                           <a href="#authentication" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="ri-pages-line"></i><span>Authentication</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                           <ul id="authentication" class="iq-submenu collapse" data-parent="#pages">
                              <li><a href="sign-in.html"><i class="las la-sign-in-alt"></i>Login</a></li>
                              <li><a href="sign-up.html"><i class="ri-login-circle-line"></i>Register</a></li>
                              <li><a href="pages-recoverpw.html"><i class="ri-record-mail-line"></i>Recover Password</a></li>
                              <li><a href="pages-confirm-mail.html"><i class="ri-file-code-line"></i>Confirm Mail</a></li>
                              <li><a href="pages-lock-screen.html"><i class="ri-lock-line"></i>Lock Screen</a></li>
                           </ul>
                        </li>
                        <li>
                           <a href="#extra-pages" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="ri-pantone-line"></i><span>Extra Pages</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                           <ul id="extra-pages" class="iq-submenu collapse" data-parent="#pages">
                              <li><a href="pages-timeline.html"><i class="ri-map-pin-time-line"></i>Timeline</a></li>
                              <li><a href="pages-invoice.html"><i class="ri-question-answer-line"></i>Invoice</a></li>
                              <li><a href="blank-page.html"><i class="ri-invision-line"></i>Blank Page</a></li>
                              <li><a href="pages-error.html"><i class="ri-error-warning-line"></i>Error 404</a></li>
                              <li><a href="pages-error-500.html"><i class="ri-error-warning-line"></i>Error 500</a></li>
                              
                              <li><a href="pages-pricing-one.html"><i class="ri-price-tag-2-line"></i>Pricing 1</a></li>
                              <li><a href="pages-maintenance.html"><i class="ri-archive-line"></i>Maintenance</a></li>
                              <li><a href="pages-comingsoon.html"><i class="ri-mastercard-line"></i>Coming Soon</a></li>
                              <li><a href="pages-faq.html"><i class="ri-compasses-line"></i>Faq</a></li>
                           </ul>
                        </li>
                     </ul>
                  </li>
               </ul>
            </nav>
         </div>
      </div>-->

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
                        <!--<img src="<?/*php echo URL::to('/'). '/assets/admin/dashassets/images/fl-logo.png'*/;?>" class="c-logo" alt="Flicknexs">-->
                        <div class="logo-title">
                           <span class="text-primary text-uppercase">Flicknexs</span>
                        </div>
                     </a>
                  </div>
               </div>
               <div class="iq-search-bar ml-auto">
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
                     <li class="nav-item nav-icon">
                        <a href="#" class="search-toggle iq-waves-effect text-gray rounded">
                           <i class="ri-notification-2-line"></i>
                           <span class="bg-primary dots"></span>
                        </a>
                        <div class="iq-sub-dropdown">
                           <div class="iq-card shadow-none m-0">
                              <div class="iq-card-body p-0">
                                 <div class="bg-primary p-3">
                                    <h5 class="mb-0 text-white">All Notifications<small class="badge  badge-light float-right pt-1">4</small></h5>
                                 </div>
                                 <a href="#" class="iq-sub-card" >
                                    <div class="media align-items-center">
                                       <div class="">
                                          <img class="avatar-40 rounded" src="assets/admin/dashassets/images/user/01.jpg" alt="">
                                       </div>
                                       <div class="media-body ml-3">
                                          <h6 class="mb-0 ">Emma Watson Barry</h6>
                                          <small class="float-right font-size-12">Just Now</small>
                                          <p class="mb-0">95 MB</p>
                                       </div>
                                    </div>
                                 </a>
                                 <a href="#" class="iq-sub-card" >
                                    <div class="media align-items-center">
                                       <div class="">
                                          <img class="avatar-40 rounded" src="assets/admin/dashassets/images/user/02.jpg" alt="">
                                       </div>
                                       <div class="media-body ml-3">
                                          <h6 class="mb-0 ">New customer is join</h6>
                                          <small class="float-right font-size-12">5 days ago</small>
                                          <p class="mb-0">Cyst Barry</p>
                                       </div>
                                    </div>
                                 </a>
                                 <a href="#" class="iq-sub-card" >
                                    <div class="media align-items-center">
                                       <div class="">
                                          <img class="avatar-40 rounded" src="assets/admin/dashassets/images/user/03.jpg" alt="">
                                       </div>
                                       <div class="media-body ml-3">
                                          <h6 class="mb-0 ">Two customer is left</h6>
                                          <small class="float-right font-size-12">2 days ago</small>
                                          <p class="mb-0">Cyst Barry</p>
                                       </div>
                                    </div>
                                 </a>
                                 <a href="#" class="iq-sub-card" >
                                    <div class="media align-items-center">
                                       <div class="">
                                          <img class="avatar-40 rounded" src="assets/admin/dashassets/images/user/04.jpg" alt="">
                                       </div>
                                       <div class="media-body ml-3">
                                          <h6 class="mb-0 ">New Mail from Fenny</h6>
                                          <small class="float-right font-size-12">3 days ago</small>
                                          <p class="mb-0">Cyst Barry</p>
                                       </div>
                                    </div>
                                 </a>
                              </div>
                           </div>
                        </div>
                     </li>
                     <li class="nav-item nav-icon dropdown">
                        <a href="#" class="search-toggle iq-waves-effect text-gray rounded">
                           <i class="ri-mail-line"></i>
                           <span class="bg-primary dots"></span>
                        </a>
                        <div class="iq-sub-dropdown">
                           <div class="iq-card shadow-none m-0">
                              <div class="iq-card-body p-0 ">
                                 <div class="bg-primary p-3">
                                    <h5 class="mb-0 text-white">All Messages<small class="badge  badge-light float-right pt-1">5</small></h5>
                                 </div>
                                 <a href="#" class="iq-sub-card">
                                    <div class="media align-items-center">
                                       <div class="">
                                          <img class="avatar-40 rounded" src="assets/admin/dashassets/images/user/01.jpg" alt="">
                                       </div>
                                       <div class="media-body ml-3">
                                          <h6 class="mb-0 ">Barry Emma Watson</h6>
                                          <small class="float-left font-size-12">13 Jun</small>
                                       </div>
                                    </div>
                                 </a>
                                 <a href="#" class="iq-sub-card">
                                    <div class="media align-items-center">
                                       <div class="">
                                          <img class="avatar-40 rounded" src="assets/admin/dashassets/images/user/02.jpg" alt="">
                                       </div>
                                       <div class="media-body ml-3">
                                          <h6 class="mb-0 ">Lorem Ipsum Watson</h6>
                                          <small class="float-left font-size-12">20 Apr</small>
                                       </div>
                                    </div>
                                 </a>
                                 <a href="#" class="iq-sub-card">
                                    <div class="media align-items-center">
                                       <div class="">
                                          <img class="avatar-40 rounded" src="assets/admin/dashassets/images/user/03.jpg" alt="">
                                       </div>
                                       <div class="media-body ml-3">
                                          <h6 class="mb-0 ">Why do we use it?</h6>
                                          <small class="float-left font-size-12">30 Jun</small>
                                       </div>
                                    </div>
                                 </a>
                                 <a href="#" class="iq-sub-card">
                                    <div class="media align-items-center">
                                       <div class="">
                                          <img class="avatar-40 rounded" src="assets/admin/dashassets/images/user/04.jpg" alt="">
                                       </div>
                                       <div class="media-body ml-3">
                                          <h6 class="mb-0 ">Variations Passages</h6>
                                          <small class="float-left font-size-12">12 Sep</small>
                                       </div>
                                    </div>
                                 </a>
                                 <a href="#" class="iq-sub-card">
                                    <div class="media align-items-center">
                                       <div class="">
                                          <img class="avatar-40 rounded" src="assets/admin/dashassets/images/user/05.jpg" alt="">
                                       </div>
                                       <div class="media-body ml-3">
                                          <h6 class="mb-0 ">Lorem Ipsum generators</h6>
                                          <small class="float-left font-size-12">5 Dec</small>
                                       </div>
                                    </div>
                                 </a>
                              </div>
                           </div>
                        </div>
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

		<div id="main-admin-content">

			<div id="content-page" class="content-page">
      <div class="container-fluid">
         <div class="row profile-content ">
            <div class="col-12 col-md-12 col-lg-6 align-self-center">
               <div class="iq-card">
                  <div class="iq-card-body profile-page">
                     <div class="profile-header">
                        <div class="cover-container text-center">
                           <!--<img src="../assets/images/user/1.jpg" alt="profile-bg" class="rounded-circle img-fluid">-->
                            <img height="100" width="100" class="rounded-circle img-fluid" src="<?= URL::to('/') . '/public/uploads/avatars/' . $user->avatar; ?>"  alt="profile-bg"/>
                           <div class="profile-detail mt-3">
                              <h3><?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?></h3>
                             <!-- <p class="text-primary">Web designer</p>
                              <p>Phasellus faucibus mollis pharetra. Proin blandit ac massa.Morbi nulla dolor, ornare at commodo non, feugiat non nisi.</p>-->
                           </div>
                           <div class="iq-social d-inline-block align-items-center">
                              <ul class="list-inline d-flex p-0 mb-0 align-items-center">
                                 <li>
                                    <a href="https://www.facebook.com/share.php?u=https://flicknexs.com/social" target="_blank" class="avatar-40 rounded-circle bg-primary mr-2 facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                 </li>
                                 <li>
                                    <a href="#" class="avatar-40 rounded-circle bg-primary mr-2 twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                 </li>
                                 <li>
                                    <a href="#" class="avatar-40 rounded-circle bg-primary mr-2 youtube"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>
                                 </li>
                                 <li >
                                    <a href="#" class="avatar-40 rounded-circle bg-primary pinterest"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
             </div>
            
               <div class="col-12 col-md-12 col-lg-6" >
                <div class="iq-card">
                    <div class="row" id="personal">
                    <div class="col-md-12" >
                  <div class="iq-card-header d-flex justify-content-between align-items-center mb-0 ">
                     <div class="iq-header-title">
                        <h4 class="card-title mb-0">Personal Details</h4>
                     </div>
                  </div> 
                  <div class="iq-card-body">
                     <ul class="list-inline p-0 mb-0">
                        <li>
                           <div class="row align-items-center justify-content-between mb-3">
                              <div class="col-sm-6">
                                 <h6>Username</h6>                                       
                              </div>
                              <div class="col-sm-6">
                                 <p class="mb-0"><?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?></p>                                       
                              </div>
                           </div>
                        </li>
                        <li>
                           <div class="row align-items-center justify-content-between mb-3">
                              <div class="col-sm-6">
                                 <h6>Email</h6>                                       
                              </div>
                              <div class="col-sm-6">
                                 <p class="mb-0"><?php if(!empty($user->email)): ?><?= $user->email ?><?php endif; ?></p>                                       
                              </div>
                           </div>
                        </li>
                        <li>
                           <div class="row align-items-center justify-content-between mb-3">
                              <div class="col-sm-6">
                                 <h6>Phone</h6>                                       
                              </div>
                              <div class="col-sm-6">
                                 <p class="mb-0"><?php if(!empty($user->mobile)): ?><?= $user->mobile ?><?php endif; ?></p>                                       
                              </div>
                           </div>
                        </li>
                        <li>
                           <div class="row align-items-center justify-content-between mb-3">
                              <div class="col-sm-4">
                                 <h6>Password</h6>                                       
                              </div>
                              <div class="col-sm-4">
                                 <p class="mb-0"></p>                                       
                              </div>
                               <div class="col-sm-4">
                                  <a type="button" class="btn btn-primary  noborder-radius btn-login nomargin editbtn" onclick="openForm()">Edit Profile</a>                                     
                              </div>
                           </div>
                        </li>
                        <li>
                           <div class="row align-items-center justify-content-between mb-3">
                              <div class="col-sm-6">
                                 <h6>Twitter</h6>                                       
                              </div>
                              <div class="col-sm-6">
                                 <p class="mb-0">@Flicknexs</p>                                       
                              </div>
                           </div>
                        </li>                              
                        <li>
                           <div class="row align-items-center justify-content-between mb-3">
                              <div class="col-sm-6">
                                 <h6>Facebook</h6>                                       
                              </div>
                              <div class="col-sm-6">
                                 <p class="mb-0">@Flick_nexs</p>                                       
                              </div>
                           </div>
                        </li>
                     </ul>
                  </div>
                    </div>
                   </div></div>
              </div>
            
             <!--  <div class="iq-card">
                  <div class="iq-card-header d-flex justify-content-between align-items-center mb-0">
                     <div class="iq-header-title">
                        <h4 class="card-title mb-0">Skill Progress</h4>
                     </div>
                  </div> 
                  <div class="iq-card-body">
                     <ul class="list-inline p-0 mb-0">
                        <li>
                           <div class="d-flex align-items-center justify-content-between mb-3">
                              <h6>Biography</h6>
                              <div class="iq-progress-bar-linear d-inline-block mt-1 w-50">
                                 <div class="iq-progress-bar iq-bg-primary">
                                    <span class="bg-primary" data-percent="70"></span>
                                 </div>
                              </div>
                           </div>
                        </li>
                        <li>
                           <div class="d-flex align-items-center justify-content-between mb-3">
                              <h6>Horror</h6>
                              <div class="iq-progress-bar-linear d-inline-block mt-1 w-50">
                                 <div class="iq-progress-bar iq-bg-danger">
                                    <span class="bg-danger" data-percent="50"></span>
                                 </div>
                              </div>
                           </div>
                        </li>
                        <li>
                           <div class="d-flex align-items-center justify-content-between mb-3">
                              <h6>Comic Book</h6>
                              <div class="iq-progress-bar-linear d-inline-block mt-1 w-50">
                                 <div class="iq-progress-bar iq-bg-info">
                                    <span class="bg-info" data-percent="65"></span>
                                 </div>
                              </div>
                           </div>
                        </li>
                        <li>
                           <div class="d-flex align-items-center justify-content-between">
                              <h6>Adventure</h6>
                              <div class="iq-progress-bar-linear d-inline-block mt-1 w-50">
                                 <div class="iq-progress-bar iq-bg-success">
                                    <span class="bg-success" data-percent="85"></span>
                                 </div>
                              </div>
                           </div>
                        </li>
                     </ul>
                  </div>
               </div>-->
            </div>
           
          <div class="row">
          <div class="col-12 col-md-12 col-lg-6" >
           <div class="iq-card">
                    <div class="row" id="subplan">
                    <div class="col-md-12" >
                  <div class="iq-card-header d-flex justify-content-between align-items-center mb-0 ">
                     <div class="iq-header-title">
                        <h4 class="card-title mb-0">Plan Details</h4>
                     </div>
                  </div> 
                  <div class="iq-card-body">
                     <ul class="list-inline p-0 mb-0">
                        <li>
                           <div class="row align-items-center justify-content-between mb-3">
                              <div class="col-sm-4">
                                 <h6>Subcriptions</h6>                                       
                              </div>
                              <div class="col-sm-4">
                                 <p class="mb-0">Free Plan</p>                                       
                              </div>
                                <div class="col-sm-4">
                                 <a href="<?=URL::to('/stripe/billings-details');?>" class="btn btn-primary noborder-radius btn-login nomargin editbtn" >Edit </a>                                       
                              </div>
                           </div>
                        </li>
                     </ul>
                  </div>
                    </div>
                   </div>
               </div>
          </div>
          <div class="col-12 col-md-12 col-lg-6" >
           <div class="iq-card">
                    <div class="row" id="Profile">
                    <div class="col-md-12" >
                  <div class="iq-card-header d-flex justify-content-between align-items-center mb-0 ">
                     <div class="iq-header-title">
                        <h4 class="card-title mb-0">Manage Profile</h4>
                     </div>
                  </div> 
                  <div class="iq-card-body">
                     <ul class="list-inline p-0 mb-0">
                        <li>
                           <div class="row align-items-center justify-content-between mb-3">
                              <div class="col-sm-2">
                                   Avatar                                    
                              </div>
                              <div class="col-sm-4">
                                   <!--<label for="avatar">My Avatar - Elite_<?php echo $user->id;?></label>-->
						       <img height="50" width="50" class="img-fluid rounded-normal" src="<?= URL::to('/') . '/public/uploads/avatars/' . $user->avatar; ?>" />
                                 								               
                              </div>
                                <div class="col-sm-6">
                                    
                                                     <input type="file" multiple="true" class="form-control editbtn" name="avatar" id="avatar" />
                             <input type="submit" value="<?=__('Update Profile');?>" class="btn btn-primary  noborder-radius btn-login nomargin editbtn" />                       
                                 								               
                              </div>
                           </div>
                        </li>
                     </ul>
                  </div>
                    </div>
                   </div>
               </div>
          </div></div>
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
                           <div class="row align-items-center justify-content-between mb-3">
                              <div class="col-sm-4">
                                   Card1                                    
                              </div>
                              <div class="col-sm-4">
                                   
                                 								               
                              </div>
                               <div class="col-sm-4">
                                  
                                   <input type="button" class="btn btn-primary  noborder-radius btn-login nomargin editbtn" value="Card Details" /> 
                                 								               
                              </div>
                           </div>
                        </li>
                     </ul>
                  </div>
                    </div>
                    </div>
                    </div></div>
                <div class="col-12 col-md-12 col-lg-6" >
                 <div class="iq-card">
                    <div class="row" id="subscribe" >
                    <div class="col-md-12" >
                  <div class="iq-card-header d-flex justify-content-between align-items-center mb-0 ">
                     <div class="iq-header-title">
                       
                     </div>
                  </div> 
                  <div class="iq-card-body">
                     <ul class="list-inline p-0 mb-0">
                        <li>
                           <div class="row align-items-center justify-content-between mb-3">
                              <div class="col-sm-6">
                                       <a href="<?=URL::to('/becomesubscriber');?>" class="btn btn-primary btn-login nomargin noborder-radius" > Become Subscriber</a>                                 
                              </div>
                              <div class="col-sm-6">
                                   
                                 	<a href="<?=URL::to('/stripe/billings-details');?>" class="btn btn-primary noborder-radius btn-login nomargin" > View Subscription Details</a>							               
                              </div>
                           </div>
                        </li>
                     </ul>
                  </div>
                    </div>
                   </div>
                    </div></div>
          </div>
          <div class="col-md-12">
                  <div class="iq-card">
                     <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                           <h4 class="card-title">Recently Viewd Items</h4>
                        </div>
                        
                     </div>
                      <div class="iq-card-body">
                        <div class="table-responsive">
                           <table class="data-tables table movie_table" style="width:100%">
                              <thead>
                                 <tr>
                                    <th style="width:20%;">Video</th>
                                    <!--<th style="width:10%;">Rating</th>-->
                                    <th style="width:20%;">Category</th>
                                    <th style="width:10%;">Views</th>
                                   <!-- <th style="width:10%;">User</th>-->
                                    <!-- <th style="width:20%;">Date</th> -->
                                    <th style="width:10%;"><i class="lar la-heart"></i></th>
                                 </tr>
                              </thead>
                              <tbody>
                             
                                 <tr>
                                    <td>
                                       <div class="media align-items-center">
                                          <div class="iq-movie">
                                             <a href="javascript:void(0);"><img src="{{ URL::to('/').'/public/uploads/images/'}}" class="img-border-radius avatar-40 img-fluid" alt=""></a>
                                          </div>
                                          <div class="media-body text-white text-left ml-3">
                                             <p class="mb-0"></p>
                                             <small> </small>
                                          </div>
                                       </div>
                                    </td>
                                    <!--<td><i class="lar la-star mr-2"></i></td>-->
                                    <td></td>
                                    <td>
                                       <i class="lar la-eye "></i>
                                    </td>
                                  
                                    <!-- <td>21 July,2020</td> -->
                                    <td><i class="las la-heart text-primary"></i></td>
                                 </tr>
                                  
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
        <!--    <div class="col-12 col-md-12 col-lg-8">
               <div class="row">
                  <div class="col-md-6">
                     <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                        <div class="iq-card-header d-flex justify-content-between align-items-center mb-0">
                           <div class="iq-header-title">
                              <h4 class="card-title mb-0">Latest Uploads</h4>
                           </div>
                        </div> 
                        <div class="iq-card-body">
                           <ul class="list-inline p-0 mb-0">
                              <li class="d-flex mb-4 align-items-center">
                                 <div class="profile-icon bg-secondary"><span><i class="ri-file-3-fill"></i></span></div>
                                 <div class="media-support-info ml-3">
                                    <h6>Documentation</h6>
                                    <p class="mb-0">48kb</p>
                                 </div>
                                 <div class="iq-card-toolbar">
                                    <div class="dropdown">
                                       <span class="font-size-24" role="menu" id="dropdownMenuButton01" data-toggle="dropdown" aria-expanded="false">
                                          <i class="ri-more-line"></i>
                                       </span>
                                       <div class="dropdown-menu dropdown-menu-right p-0">
                                          <a class="dropdown-item" href="#"><i class="ri-user-unfollow-line mr-2"></i>Share</a>
                                          <a class="dropdown-item" href="#"><i class="ri-close-circle-line mr-2"></i>Delete</a>
                                       </div>
                                    </div>
                                 </div>
                              </li>
                              <li class="d-flex mb-4 align-items-center">
                                 <div class="profile-icon bg-secondary"><span><i class="ri-image-fill"></i></span></div>
                                 <div class="media-support-info ml-3">
                                    <h6>Images</h6>
                                    <p class="mb-0">204kb</p>
                                 </div>
                                 <div class="iq-card-toolbar">
                                    <div class="dropdown">
                                       <span class="font-size-24" role="menu" id="dropdownMenuButton02" data-toggle="dropdown" aria-expanded="false">
                                          <i class="ri-more-line"></i>
                                       </span>
                                       <div class="dropdown-menu dropdown-menu-right p-0" style="">
                                          <a class="dropdown-item" href="#"><i class="ri-user-unfollow-line mr-2"></i>Share</a>
                                          <a class="dropdown-item" href="#"><i class="ri-close-circle-line mr-2"></i>Delete</a>
                                       </div>
                                    </div>
                                 </div>
                              </li>
                              <li class="d-flex mb-4 align-items-center">
                                 <div class="profile-icon bg-secondary"><span><i class="ri-video-fill"></i></span></div>
                                 <div class="media-support-info ml-3">
                                    <h6>Videos</h6>
                                    <p class="mb-0">509kb</p>
                                 </div>
                                 <div class="iq-card-toolbar">
                                    <div class="dropdown"> 
                                       <span class="font-size-24" role="menu" id="dropdownMenuButton03" data-toggle="dropdown" aria-expanded="false">
                                          <i class="ri-more-line"></i>
                                       </span>
                                       <div class="dropdown-menu dropdown-menu-right p-0">
                                          <a class="dropdown-item" href="#"><i class="ri-user-unfollow-line mr-2"></i>Share</a>
                                          <a class="dropdown-item" href="#"><i class="ri-close-circle-line mr-2"></i>Delete</a>
                                       </div>
                                    </div>
                                 </div>
                              </li>
                              <li class="d-flex mb-4 align-items-center">
                                 <div class="profile-icon bg-secondary"><span><i class="ri-file-3-fill"></i></span></div>
                                 <div class="media-support-info ml-3">
                                    <h6>Resources</h6>
                                    <p class="mb-0">48kb</p>
                                 </div>
                                 <div class="iq-card-toolbar">
                                    <div class="dropdown">
                                       <span class="font-size-24" role="menu" id="dropdownMenuButton04" data-toggle="dropdown" aria-expanded="false">
                                          <i class="ri-more-line"></i>
                                       </span>
                                       <div class="dropdown-menu dropdown-menu-right p-0" style="">
                                          <a class="dropdown-item" href="#"><i class="ri-user-unfollow-line mr-2"></i>Share</a>
                                          <a class="dropdown-item" href="#"><i class="ri-close-circle-line mr-2"></i>Delete</a>
                                       </div>
                                    </div>
                                 </div>
                              </li>
                              <li class="d-flex align-items-center">
                                 <div class="profile-icon bg-secondary"><span><i class="ri-refresh-line"></i></span></div>
                                 <div class="media-support-info ml-3">
                                    <h6>Celine Dion</h6>
                                    <p class="mb-0">204kb</p>
                                 </div>
                                 <div class="iq-card-toolbar">
                                    <div class="dropdown">
                                       <span class="font-size-24" role="menu" id="dropdownMenuButton06" data-toggle="dropdown" aria-expanded="false">
                                          <i class="ri-more-line"></i>
                                       </span>
                                       <div class="dropdown-menu dropdown-menu-right p-0">
                                          <a class="dropdown-item" href="#"><i class="ri-user-unfollow-line mr-2"></i>Share</a>
                                          <a class="dropdown-item" href="#"><i class="ri-close-circle-line mr-2"></i>Delete</a>
                                       </div>
                                    </div>
                                 </div>
                              </li>
                           </ul>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                        <div class="iq-card-header d-flex justify-content-between align-items-center mb-0">
                           <div class="iq-header-title">
                              <h4 class="card-title mb-0">Top Books</h4>
                           </div>
                        </div>
                        <div class="iq-card-body">
                           <ul class="list-inline p-0 mb-0">
                              <li>
                                 <div class="iq-details mb-2">
                                    <span class="title">Adventure</span>
                                    <div class="percentage float-right text-primary">95 <span>%</span></div>
                                    <div class="iq-progress-bar-linear d-inline-block w-100">
                                       <div class="iq-progress-bar">
                                          <span class="bg-primary" data-percent="95"></span>
                                       </div>
                                    </div>
                                 </div>                                       
                              </li>
                              <li>
                                 <div class="iq-details mb-2">
                                    <span class="title">Horror</span>
                                    <div class="percentage float-right text-warning">72 <span>%</span></div>
                                    <div class="iq-progress-bar-linear d-inline-block w-100">
                                       <div class="iq-progress-bar">
                                          <span class="bg-warning" data-percent="72"></span>
                                       </div>
                                    </div>
                                 </div>
                              </li>
                              <li>
                               <div class="iq-details mb-2">
                                 <span class="title">Comic Book</span>
                                 <div class="percentage float-right text-info">75 <span>%</span></div>
                                 <div class="iq-progress-bar-linear d-inline-block w-100">
                                    <div class="iq-progress-bar">
                                       <span class="bg-info" data-percent="75"></span>
                                    </div>
                                 </div>
                              </div> 
                           </li>
                           <li>
                              <div class="iq-details mb-2">
                                 <span class="title">Biography</span>
                                 <div class="percentage float-right text-danger">70 <span>%</span></div>
                                 <div class="iq-progress-bar-linear d-inline-block w-100">
                                    <div class="iq-progress-bar">
                                       <span class="bg-danger" data-percent="70"></span>
                                    </div>
                                 </div>
                              </div>
                           </li>
                           <li>
                              <div class="iq-details">
                                 <span class="title">Mystery</span>
                                 <div class="percentage float-right text-success">80 <span>%</span></div>
                                 <div class="iq-progress-bar-linear d-inline-block w-100">
                                    <div class="iq-progress-bar">
                                       <span class="bg-success" data-percent="80"></span>
                                    </div>
                                 </div>
                              </div>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
            <div class="iq-card">
               <div class="iq-card-header d-flex justify-content-between align-items-center mb-0">
                  <div class="iq-header-title">
                     <h4 class="card-title mb-0">Daily Sales</h4>
                  </div>
                  <div class="iq-card-header-toolbar d-flex align-items-center">
                     <div class="dropdown">
                        <span class="dropdown-toggle text-primary" id="dropdownMenuButton05" data-toggle="dropdown">
                           <i class="ri-more-fill"></i>
                        </span>  
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton05">
                           <a class="dropdown-item" href="#"><i class="ri-eye-fill mr-2"></i>View</a>
                           <a class="dropdown-item" href="#"><i class="ri-delete-bin-6-fill mr-2"></i>Delete</a>
                           <a class="dropdown-item" href="#"><i class="ri-pencil-fill mr-2"></i>Edit</a>
                           <a class="dropdown-item" href="#"><i class="ri-printer-fill mr-2"></i>Print</a>
                           <a class="dropdown-item" href="#"><i class="ri-file-download-fill mr-2"></i>Download</a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="iq-card-body">
                <ul class="perfomer-lists m-0 p-0">
                  <li class="d-flex mb-4 align-items-center">
                     <div class="user-img img-fluid"><img class="img-fluid avatar-50 rounded-circle" src="../assets/images/user/06.jpg" alt=""></div>
                     <div class="media-support-info ml-3">
                        <h5>Reading on the World</h5>
                        <p class="mb-0">Lorem Ipsum is simply dummy test</p>
                     </div>
                     <div class="iq-card-header-toolbar d-flex align-items-center">
                        <span class="text-dark"><b>+$82</b></span>
                     </div>
                  </li>
                  <li class="d-flex mb-4 align-items-center">
                     <div class="user-img img-fluid"><img class="img-fluid avatar-50 rounded-circle" src="../assets/images/user/07.jpg" alt=""></div>
                     <div class="media-support-info ml-3">
                        <h5>Little Black Book</h5>
                        <p class="mb-0">Lorem Ipsum is simply dummy test</p>
                     </div>
                     <div class="iq-card-header-toolbar d-flex align-items-center">
                        <span class="text-dark"><b>+$90</b></span>
                     </div>
                  </li>
                  <li class="d-flex align-items-center">
                     <div class="user-img img-fluid"><img class="img-fluid avatar-50 rounded-circle" src="../assets/images/user/08.jpg" alt=""></div>
                     <div class="media-support-info ml-3">
                        <h5>See the More Story</h5>
                        <p class="mb-0">Lorem Ipsum is simply dummy test</p>
                     </div>
                     <div class="iq-card-header-toolbar d-flex align-items-cener">
                        <span class="text-dark"><b>+$85</b></span>
                     </div>
                  </li>
               </ul>
            </div>
         </div>
         <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between align-items-center mb-0">
               <div class="iq-header-title">
                  <h4 class="card-title mb-0">Top Products</h4>
               </div>
               <div class="iq-card-header-toolbar d-flex align-items-center">
                  <div class="dropdown">
                     <span class="dropdown-toggle text-primary" id="dropdownMenuButton07" data-toggle="dropdown">
                        <i class="ri-more-fill"></i>
                     </span>
                     <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton05">
                        <a class="dropdown-item" href="#"><i class="ri-eye-fill mr-2"></i>View</a>
                        <a class="dropdown-item" href="#"><i class="ri-delete-bin-6-fill mr-2"></i>Delete</a>
                        <a class="dropdown-item" href="#"><i class="ri-pencil-fill mr-2"></i>Edit</a>
                        <a class="dropdown-item" href="#"><i class="ri-printer-fill mr-2"></i>Print</a>
                        <a class="dropdown-item" href="#"><i class="ri-file-download-fill mr-2"></i>Download</a>
                     </div>
                  </div>
               </div>
            </div>
            <div class="iq-card-body">
             <ul class="perfomer-lists m-0 p-0">
               <li class="row mb-3 align-items-center justify-content-between">
                  <div class="col-md-8">
                     <h5>Find The Wave Book</h5>
                     <p class="mb-0">General Book</p>
                  </div>
                  <div class="col-md-4 text-right">
                     <div class="iq-card-header-toolbar d-flex align-items-center">
                        <span class="text-primary mr-3"><b>+$92</b></span>
                        <div class="iq-progress-bar-linear d-inline-block mt-1 w-100">
                           <div class="iq-progress-bar iq-bg-primary">
                              <span class="bg-primary" data-percent="92"></span>
                           </div>
                        </div>
                     </div>
                  </div>
               </li>
               <li class="row align-items-center justify-content-between">
                  <div class="col-md-8">
                     <h5>A man with those Faces</h5>
                     <p class="mb-0">Biography Book</p>
                  </div>
                  <div class="col-md-4 text-right">
                     <div class="iq-card-header-toolbar d-flex align-items-center">
                        <span class="text-danger mr-3"><b>+$85</b></span>
                        <div class="iq-progress-bar-linear d-inline-block mt-1 w-100">
                           <div class="iq-progress-bar iq-bg-primary">
                              <span class="bg-danger" data-percent="85"></span>
                           </div>
                        </div>
                     </div>
                  </div>
               </li>                       
            </ul>
         </div>
      </div>
   </div>-->
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
                <div class="form-popup " id="myForm" style="background:url(<?php echo URL::to('/').'/assets/img/Landban.png';?>) no-repeat;	background-size: cover;
    height: 665px;">
                <div class="col-sm-4 details-back">
					<div class="row data-back">
						<div class="well-in col-sm-12 col-xs-12" >
							<?php if($errors->first('name')): ?><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong>Oh snap!</strong> <?= $errors->first('name'); ?></div><?php endif; ?>
							<label for="username" class="lablecolor"><?=__('Username');?></label>
							<input type="text" class="form-control" name="name" id="name" value="<?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?>" />
						</div>
						<div class="well-in col-sm-12 col-xs-12">
							<?php if($errors->first('email')): ?><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong>Oh snap!</strong> <?= $errors->first('email'); ?></div><?php endif; ?>
							<label for="email"><?=__('Email');?></label>
							<input type="text" class="form-control" name="email" id="email" value="<?php if(!empty($user->email)): ?><?= $user->email ?><?php endif; ?>" />
						</div>
						<div class="well-in col-sm-12 col-xs-12">
							<?php if($errors->first('name')): ?><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong>Oh snap!</strong> <?= $errors->first('name'); ?></div><?php endif; ?>
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
						<div class="col-sm-12 col-xs-12">
							<input type="submit" value="<?=__('Update Profile');?>" class="btn btn-primary" />
                             <button type="button" class="btn btn-primary" onclick="closeForm()">Close</button>
						</div>
					</div>
				</div>
                </div>
				
				<!--<div class="col-sm-6 col-xs-12">
					<div class="row">
						<div class="well-in col-sm-12 col-xs-12">
							<?php if($errors->first('name')): ?><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong>Oh snap!</strong> <?= $errors->first('name'); ?></div><?php endif; ?>
							<label for="username" class="lablecolor"><?=__('Username');?></label>
							<input type="text" readonly class="form-control" name="name" id="name" value="<?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?>" />
						</div>
						<div class="well-in col-sm-12 col-xs-12">
							<?php if($errors->first('email')): ?><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong>Oh snap!</strong> <?= $errors->first('email'); ?></div><?php endif; ?>
							<label for="email"><?=__('Email');?></label>
							<input type="text" readonly class="form-control" name="email" id="email" value="<?php if(!empty($user->email)): ?><?= $user->email ?><?php endif; ?>" />
						</div>
						<div class="well-in col-sm-12 col-xs-12">
							<?php if($errors->first('name')): ?><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong>Oh snap!</strong> <?= $errors->first('name'); ?></div><?php endif; ?>
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
									<input type="text" readonly class="form-control" name="mobile" id="mobile" value="<?php if(!empty($user->mobile)): ?><?= $user->mobile ?><?php endif; ?>" />
								</div>
							</div>
						</div>
						<div class="well-in col-sm-12 col-xs-12">
							<label for="password"><?=__('Password');?> (leave empty to keep your original password)</label>
							<input type="password" readonly class="form-control" name="password" id="password"  />
						</div>
						<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
						<div class="col-sm-12 col-xs-12">
							<input type="submit" value="<?=__('Update Profile');?>" class="btn btn-primary" />
						</div>
					</div>
				</div>-->
                <!--new design-->
                
                <!--<div class="row personal" id="personal">
                    <h2>Profile</h2>
                    <div class="col-sm-4">
                        <label for="username" class="lablecolor"><?=__('Username');?></label><br>
                        <label for="email"><?=__('Email');?></label><br>
                        <label for="username" class="lablecolor"><?=__('Phone Number');?></label><br>
                        <label for="password"><?=__('Password');?></label>
                    </div>
                    <div class="col-sm-4">
                    <input type="text" readonly class="form-control" name="name" id="name" value="<?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?>" />
                    <input type="text" readonly class="form-control" name="email" id="email" value="<?php if(!empty($user->email)): ?><?= $user->email ?><?php endif; ?>" />
                    <input type="text" readonly class="form-control" name="mobile" id="mobile" value="<?php if(!empty($user->mobile)): ?><?= $user->mobile ?><?php endif; ?>" />
                    <input type="password" readonly class="form-control" name="password" id="password"  /></div>
                    <div class="col-sm-4">
                        <a type="button" class="btn btn-primary  noborder-radius btn-login nomargin editbtn" onclick="openForm()">Edit Profile</a>
                       
                    </div>
                </div>-->
                <!-- <div class="row Subplan" id="subplan">
                     <h2>Plan Details</h2>
                    <div class="col-sm-4">
                       Subscriptions
                    </div>
                    <div class="col-sm-4">
                        Free Plan
                    </div>
                    
                    <div class="col-sm-4">
                        
                        <a href="<?=URL::to('/stripe/billings-details');?>" class="btn btn-primary noborder-radius btn-login nomargin editbtn" >Edit Plan Details</a>
                    </div>
                </div>-->
               <!--  <div class="row Profile" id="Profile">
                     <h2>Manage Profile</h2>
                    <div class="col-sm-4">
                       Avatar
                    </div>
                    <div class="col-sm-4">
                        <label for="avatar">My Avatar - Elite_<?php echo $user->id;?></label>
						<img height="100" width="100" src="<?= URL::to('/') . '/public/uploads/avatars/' . $user->avatar; ?>" />	
                        
                    </div>
                    <div class="col-sm-4">
                        <div id="user-badge">
								<input type="file" multiple="true" class="form-control editbtn" name="avatar" id="avatar" />
                             <input type="submit" value="<?=__('Update Profile');?>" class="btn btn-primary  noborder-radius btn-login nomargin editbtn" />
							</div>	

                       
                    </div>
                </div>-->
                <!-- <div class="row card" id="card">
                     <h2>Card Details</h2>
                    <div class="col-sm-4">
                       Card1
                    </div>
                    <div class="col-sm-4">
                        
                    </div>
                    <div class="col-sm-4">
                        <input type="button" class="btn btn-primary  noborder-radius btn-login nomargin editbtn" value="Add Card" />
                        <input type="button" class="btn btn-primary  noborder-radius btn-login nomargin editbtn" value="Card Details" />
                       
                    </div>
                </div>-->
                <div class="row" id="subscribe">
<!--                    <a href="<?=URL::to('/becomesubscriber');?>" class="btn btn-primary btn-login nomargin noborder-radius" > Become Subscriber</a>
                    <a href="<?=URL::to('/stripe/billings-details');?>" class="btn btn-primary noborder-radius btn-login nomargin" > View Subscription Details</a>-->
                     
						<div class="col-sm-12 col-xs-12 padding-top-30">
						<?php if ( Auth::user()->role != 'admin') { ?>
							<div class="row">
								<?php if (Auth::user()->role == 'subscriber' && empty(Auth::user()->paypal_id)){ ?>
									<h3> Plan Details:</h3>
									<p><?php echo CurrentSubPlanName(Auth::user()->id);?></p>
								<?php } ?>
								<div class="col-sm-6 col-xs-12 padding-top-30">
									<?php 
                                        $paypal_id = Auth::user()->paypal_id;
                                        if (!empty($paypal_id) && !empty(PaypalSubscriptionStatus() )  ) {
                                        $paypal_subscription = PaypalSubscriptionStatus();
                                        } else {
                                          $paypal_subscription = "";  
                                        }
                                  
									 $stripe_plan = SubscriptionPlan();
									 if ( $user->subscribed($stripe_plan) && empty(Auth::user()->paypal_id) ) { 
										if ($user->subscription($stripe_plan)->ended()) { ?>
											 <a href="<?=URL::to('/renew');?>" class="btn btn-primary noborder-radius margin-bottom-20" > Renew Subscription</a>
									   <?php } else { ?>
									   <a href="<?=URL::to('/cancelSubscription');?>" class="btn btn-danger noborder-radius margin-bottom-20" > Cancel Subscription</a>
											<a href="<?=URL::to('/cancelSubscription');?>" class="btn btn-primary" >Cancel Subscription</a>
									 <?php  } } 
                                    elseif(!empty(Auth::user()->paypal_id) && $paypal_subscription !="ACTIVE" )
                                          {   ?>
                                          <a href="<?=URL::to('/becomesubscriber');?>" class="btn btn-primary btn-login nomargin noborder-radius" > Become Subscriber</a>
                                          
                                    <?php } else { echo $paypal_subscription; ?>
										<a href="<?=URL::to('/becomesubscriber');?>" class="btn btn-primary btn-login nomargin noborder-radius" > Become Subscriber</a>
								  	<?php } ?>
								</div>
                                
                                
								<div class="col-sm-6 col-xs-12 padding-top-30">
									<?php
										$billing_url = URL::to('/').'/paypal/billings-details';
										if (!empty(Auth::user()->paypal_id)){
										  echo "<p><a href='".$billing_url."' class='plan-types'> <i class='fa fa-caret-right'></i> View Billing Details</a></p>";
										} 
									?>
									 <?php if ( $user->subscribed($stripe_plan) ) { 
										if ($user->subscription($stripe_plan)->ended()) { ?>
											 <p><a href="<?=URL::to('/renew');?>" class="plan-types" ><i class="fa fa-caret-right"></i> Renew Subscription</a></p>
									   <?php } else { ?>
										   <p><a href="<?=URL::to('/upgrade-subscription');?>" class="plan-types" ><i class="fa fa-caret-right"></i> Change Plan</a></p>
									 <?php  } } ?>

									<?php if ($user->subscribed($stripe_plan) && $user->subscription($stripe_plan)->onGracePeriod()) { ?>
										 <p><a href="<?=URL::to('/renew');?>" class="plan-types" > Renew Subscription</a></p>
									<?php } ?>

									<?php if ($user->subscribed($stripe_plan)) { ?>
												<a href="<?=URL::to('/stripe/billings-details');?>" class="btn btn-primary noborder-radius btn-login nomargin" > View Subscription Details</a>
									<?php } ?>
								</div>
							</div>
							<?php } ?>
								
						</div>
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
               Copyright 2020 <a href="<?php echo URL::to('home') ?>">Flicknexs</a> All Rights Reserved.
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
   <script src="<?= URL::to('/'). '/assets/admin/dashassets/css/bootstrap.min.css';?>"></script>
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

	<!--@yield('javascript')-->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
function openForm() {
  document.getElementById("myForm").style.display = "block";
    document.getElementById("personal").style.display = "none";
    document.getElementById("subplan").style.display = "none";
     document.getElementById("Profile").style.display = "none";
    document.getElementById("card").style.display = "none";
        document.getElementById("subscribe").style.display = "none";
}
</script>
<script>
function closeForm() {
  document.getElementById("myForm").style.display = "none";
     document.getElementById("personal").style.display = "block";
    document.getElementById("subplan").style.display = "block";
     document.getElementById("Profile").style.display = "block";
    document.getElementById("card").style.display = "block";
        document.getElementById("subscribe").style.display = "block";
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


</body>
</html>
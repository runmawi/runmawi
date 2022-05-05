<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Flicknexs Advertiser Panel</title>
  <meta name="description" content= "" />
  <meta name="author" content="webnexs" />

   <!-- Favicon -->
   <link rel="shortcut icon" href="<?= getFavicon();?>" type="image/gif" sizes="16x16">

   <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="<?= URL::to('/'). '/assets/admin/dashassets/css/bootstrap.min.css';?>" />
    
   <link rel="stylesheet" href="<?= URL::to('/'). '/assets/admin/dashassets/css/responsive.css';?>" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
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
.top-left-logo img{opacity:.9;overflow:hidden}span{font-weight:400!important}.header-logo{padding-left:25px}hr{border-top:1px solid #e2e2e22e!important}*{margin:0;padding:0}html{height:100%}#grad1{background-color::#9c27b0;background-image:linear-gradient(120deg,#ff4081,#81d4fa)}#msform{text-align:center;position:relative;margin-top:20px}#msform fieldset .form-card{background:#fff;border:0 none;border-radius:0;box-shadow:0 2px 2px 2px rgba(0,0,0,.2);padding:20px 40px 30px;box-sizing:border-box;width:94%;margin:0 3% 20px;position:relative}#msform fieldset{background:#fff;border:0 none;border-radius:.5rem;box-sizing:border-box;width:100%;margin:0;padding-bottom:20px;position:relative}#msform fieldset:not(:first-of-type){display:none}#msform fieldset .form-card{text-align:left;color:#9e9e9e}#msform input,#msform textarea{padding:0 8px 4px;border:none;border-bottom:1px solid #ccc;border-radius:0;margin-bottom:25px;margin-top:2px;width:100%;box-sizing:border-box;font-family:montserrat;color:#2c3e50;font-size:16px;letter-spacing:1px}
#msform input:focus,#msform textarea:focus{-moz-box-shadow:none !important;-webkit-box-shadow:none !important;box-shadow:none !important;border:none;font-weight:700;border-bottom:2px solid skyblue;outline-width:0}#msform .action-button{width:100px;background:skyblue;font-weight:700;color:#fff;border:0 none;border-radius:0;cursor:pointer;padding:10px 5px;margin:10px 5px}#msform .action-button:hover,#msform .action-button:focus{box-shadow:0 0 0 2px #fff,0 0 0 3px skyblue}#msform .action-button-previous{width:100px;background:#616161;font-weight:700;color:#fff;border:0 none;border-radius:0;cursor:pointer;padding:10px 5px;margin:10px 5px}#msform .action-button-previous:hover,#msform .action-button-previous:focus{box-shadow:0 0 0 2px #fff,0 0 0 3px #616161}select.list-dt{border:none;outline:0;border-bottom:1px solid #ccc;padding:2px 5px 3px;margin:2px}select.list-dt:focus{border-bottom:2px solid skyblue}.card{z-index:0;border:none;border-radius:.5rem;position:relative}.fs-title{font-size:25px;color:#2c3e50;margin-bottom:10px;font-weight:700;text-align:left}
#progressbar{margin-bottom:30px;overflow:hidden;color:#d3d3d3}#progressbar .active{color:#000}#progressbar li{list-style-type:none;font-size:12px;width:25%;float:left;position:relative}#progressbar #account:before{font-family:FontAwesome;content:"\f023"}#progressbar #personal:before{font-family:FontAwesome;content:"\f007"}#progressbar #payment:before{font-family:FontAwesome;content:"\f09d"}#progressbar #confirm:before{font-family:FontAwesome;content:"\f00c"}#progressbar li:before{width:50px;height:50px;line-height:45px;display:block;font-size:18px;color:#fff;background:#d3d3d3;border-radius:50%;margin:0 auto 10px auto;padding:2px}#progressbar li:after{content:'';width:100%;height:2px;background:#d3d3d3;position:absolute;left:0;top:25px;z-index:-1}#progressbar li.active:before,#progressbar li.active:after{background:skyblue}.radio-group{position:relative;margin-bottom:25px}.radio{display:inline-block;width:204;height:104;border-radius:0;background:#add8e6;box-shadow:0 2px 2px 2px rgba(0,0,0,.2);box-sizing:border-box;cursor:pointer;margin:8px 2px}
.radio:hover{box-shadow:2px 2px 2px 2px rgba(0,0,0,.3)}.radio.selected{box-shadow:1px 1px 2px 2px rgba(0,0,0,.1)}.fit-image{width:100%;object-fit:cover}.pay,.razorpay-payment-button{width:100px;background:skyblue !important;font-weight:700;color:#fff !important;font-family:montserrat !important;border:0 none;border-radius:0;cursor:pointer;padding:10px 5px;margin:10px 5px}
</style>

</head>
<body >
<?php $settings = App\Setting::first(); ?>
<div class="page-container sidebar-collapsed"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
  <!-- Sidebar-->
      <div class="iq-sidebar">
         <div class="iq-sidebar- d-flex justify-content-between align-items-center mt-2">
            <a href="<?php echo URL::to('home') ?>" class="header-logo">
               <img src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo ; ?>" class="c-logo" alt="" >
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
                  <li class="views"><a href="<?php echo URL::to('home') ?>" ><i class="ri-arrow-right-line"></i><span>Visit site</span></a></li>
                  <li class=" "><a href="<?php echo URL::to('advertiser') ?>" class="iq-waves-effect"><i class="las la-home iq-arrow-left"></i><span>Dashboard</span></a></li>
                  <li class=" "><a href="<?php echo URL::to('advertiser') ?>/featured_ads" class="iq-waves-effect"><i class="
la la-list-alt iq-arrow-left"></i><span>Featured Ads</span></a></li>
                  <li class=" "><a href="<?php echo URL::to('advertiser') ?>/upload_featured_ad" class="iq-waves-effect"><i class="
la la-cloud-upload iq-arrow-left"></i><span>Upload Featured Ad</span></a></li>
                  <li class=" "><a href="<?php echo URL::to('advertiser') ?>/featured_ad_history" class="iq-waves-effect"><i class="la la-history iq-arrow-left"></i><span>Featured Ad History</span></a></li>
                  <li class=" "><a href="<?php echo URL::to('advertiser') ?>/list_total_cpc" class="iq-waves-effect"><i class="la la-money iq-arrow-left"></i><span>CPC</span></a></li>
                  <li class=" "><a href="<?php echo URL::to('advertiser') ?>/list_total_cpv" class="iq-waves-effect"><i class="
la la-eye iq-arrow-left"></i><span>CPV</span></a></li>
                  <li class=" "><a href="<?php echo URL::to('advertiser') ?>/ads_campaign" class="iq-waves-effect"><i class="
la la-list-alt iq-arrow-left"></i><span>Ads campaign</span></a></li>
                   <div class="bod"></div>
                   <?php $activeplan =  App\Advertiserplanhistory::where('advertiser_id',session('advertiser_id'))->where('status','active')->count(); ?>
                   @if($activeplan != 0)
                    <div>
                        <p class="" style="color:#0993D2!important;padding-left:30px;font-weight: 600;">Ads Management</p>
                    </div>
                    <li><a href="<?php echo URL::to('advertiser') ?>/ads-list" class="iq-waves-effect"><i class="la la-buysellads"></i><span>Advertisements</span></a></li>

                    <li><a href="<?php echo URL::to('advertiser') ?>/upload_ads" class="iq-waves-effect"><i class="
la la-cloud-upload"></i><span> Upload Ads</span></a></li>

                    <li><a href="<?php echo URL::to('advertiser') ?>/plan_history" class="iq-waves-effect"><i class="
la la-history"></i><span> Plans History</span></a></li>

                    <li><a href="<?php echo URL::to('advertiser') ?>/logout" class="iq-waves-effect"><i class="la la-sign-out"></i><span> Logout</span></a></li>
                    @endif
                    <div >
                 
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
                               <span class="text-primary text-uppercase"></span>
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
                         <li class="line-height pt-3">
                            <a href="#" class="search-toggle iq-waves-effect d-flex align-items-center">
                                <?php if(Auth::guest()): ?>
                                         <img src="<?php echo URL::to('/').'/public/uploads/avatars/default.png' ?>" class="img-fluid avatar-40 rounded-circle" alt="user">
                                          <?php else: ?>
                                     <img src="<?php echo URL::to('/').'/public/uploads/avatars/' . Auth::user()->avatar ?>" class="img-fluid avatar-40 rounded-circle" alt="user">
                                          <?php endif; ?>
                            </a>
                            <div class="iq-sub-dropdown iq-user-dropdown">
                               <div class="iq-card shadow-none m-0">
                                  <div class="iq-card-body p-0 ">
                                     <div class="bg-primary p-3">
                                        <h5 class="mb-0 text-white line-height">Hello  </h5>
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
                                     <div class="d-inline-block w-100 text-center p-3">
                                        <a class="bg-primary iq-sign-btn" href="{{ URL::to('advertiser/logout') }}" role="button">Sign out<i class="ri-login-box-line ml-2"></i></a>
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
        @yield('content')
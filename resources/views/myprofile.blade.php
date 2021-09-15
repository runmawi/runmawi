<?php //include('../header.php');?>
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
    .visitbtn{
        width: 100px !important;
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
        margin: 40px auto;
    }
    .btn-primary {
    background: #ffffff;
    border-color: #4895d1;
}
    .btn-primary:hover, .btn-primary:focus, .btn-primary:active, .btn-primary.active, .open .dropdown-toggle.btn-primary {
    background-color: #4895d1;
    border-color: #4895d1;
    color: #fff;
}
    .data-back{
        background-color: #333;
    opacity: 0.5;
   padding: 20px;
    }
    .editbtn{
        float: right;
    }
    input.form-control#email {
     background-color: #1a1b20; 
   
    color: #fff;
    box-shadow: none;
}
    input.form-control#password {
   background-color: #1a1b20; 
    
    color: #fff;
    box-shadow: none;
}
    #update_profile_form .form-control {
    background: #1a1b20 !important;
   
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
        #mobile{
            height: 25px!important;
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
        .form-control {
    height: 45px;
    line-height: 27px;
    background: transparent !important;
    border: 1px solid var(--iq-body-text);
    font-size: 14px;
    color: var(--iq-white);
    border-radius: 0;
}
          .form-control:focus {
     color: var(--iq-white) !important;
    background-color: #fff;
    border-color: #80bdff;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgb(0 123 255 / 25%);
}
</style>

</head>


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

		<div id="main-admin-content">

			<div id="content-page" class="content-page">
      <div class="container-fluid">
         <div class="row profile-content ">
            <div class="col-12 col-md-12 col-lg-6 align-self-center">
               <div class="iq-card">
                  <div class="iq-card-body profile-page" id="avatar">
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
                                    <a href="https://www.facebook.com/webnexs/" target="_blank" class="avatar-40 rounded-circle bg-primary mr-2 facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                 </li>
                                 <li>
                                    <a href="https://twitter.com/webnexstech" target="_blank" class="avatar-40 rounded-circle bg-primary mr-2 twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                 </li>
                                 <li>
                                    <a href="https://www.youtube.com/channel/UC-d56PhtNHTAMNvZ3idGVZw" target="_blank" class="avatar-40 rounded-circle bg-primary mr-2 youtube"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>
                                 </li>
                                 <li >
                                    <a href="https://in.pinterest.com/webnexs/" class="avatar-40 rounded-circle bg-primary pinterest"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
                <div class="iq-card">
                    <div class="row" id="subscribe" >
                        <div class="col-md-12" >
                            <div class="iq-card-body">
                                <ul class="list-inline p-0 mb-0">
                                    <li>
                                        <div class="row align-items-center justify-content-between mb-3 mt-3">
                                            <div class="col-sm-6">
                                                <?php if ( Auth::user()->role != 'admin') { ?>
                                                   <div class="row">
                                                    <?php if (Auth::user()->role == 'subscriber' && empty(Auth::user()->paypal_id)){ ?>
                                                        <h3> Plan Details:</h3>
                                                        <p style="margin-left: 19px;margin-top: 8px"><?php echo CurrentSubPlanName(Auth::user()->id);?></p>
                                                    <?php } ?>
                                                    <div class="col-sm-12 col-xs-12 padding-top-30">
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
                                
                                                    <div class="col-sm-12 col-xs-12 padding-top-30">
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
                                            <div class="col-sm-6">
<!--                                                <a href="<?=URL::to('/stripe/billings-details');?>" class="btn btn-primary noborder-radius btn-login nomargin" > View Subscription Details</a>	-->
                                                <a href="<?=URL::to('/transactiondetails');?>" class="btn btn-primary btn-login nomargin noborder-radius" >View Transaction Details</a>
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
                               <div class="col-sm-4"></div>
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
                        <li>
                           <div class="row align-items-center justify-content-between mb-3">
                              <div class="col-sm-8"></div>
                               <div class="col-sm-4">
                                  <button type="button" class="btn btn-primary editbtn" onclick="openForm()">Edit Profile</button>                                     
                              </div>
                           </div>
                        </li>
                     </ul>
                  </div>
                    </div>
                   </div></div>
              </div>
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
                                   <div class="row align-items-center justify-content-between mb-3 mt-3">
                                      <div class="col-sm-4">
                                         <h6>Subcriptions</h6>                                       
                                      </div>
                                      <div class="col-sm-4">
                                         <p class="mb-0">Free Plan</p>                                       
                                      </div>
                                        <div class="col-sm-4">
                                         <a href="<?=URL::to('/stripe/billings-details');?>" class="btn btn-primary editbtn" >Edit </a>                                       
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
                           <div class="row align-items-center  mb-3 mt-3">
                              <div class="col-sm-4">
                                   <!--<label for="avatar">My Avatar - Elite_<?php echo $user->id;?></label>-->
						       <img height="50" width="50" class="img-fluid rounded-normal" src="<?= URL::to('/') . '/public/uploads/avatars/' . $user->avatar; ?>" />
                                 								               
                              </div>
                                <div class="col-sm-6 mt-5">
                                     <form action="<?php if (isset($ref) ) { echo URL::to('/').'/register1?ref='.$ref.'&coupon='.$coupon; } else { echo URL::to('/').'/register1'; } ?>" method="POST" id="stripe_plan" class="stripe_plan" name="member_signup" enctype="multipart/form-data">
                        @csrf
                                                     <input type="file" multiple="true" class="form-control editbtn" name="avatar" id="avatar" />
                           <!--   <input type="submit" value="<?=__('Update Profile');?>" class="btn btn-primary  noborder-radius btn-login nomargin editbtn" /> -->     <button type="button" value="Verify Profile" id="submit" class="btn btn-primary btn-login verify-profile " style="display: none;"> Verify Profile</button>
                                  <button class="btn btn-primary noborder-radius btn-login nomargin editbtn mt-2" type="submit" name="create-account">{{ __('Update Profile') }}</button>                   
                                    </form>								               
                              </div>
                           </div>
                        </li>
                     </ul>
                  </div>
                    </div>
                   </div>
               </div>
          </div></div>
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
-->
          <div class="row">
          <div class="col-md-12">
                  <div class="iq-card" id="recentviews">
                     <div class="iq-card-header d-flex justify-content-between" >
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
                                    <th style="width:10%;">Rating</th>
                                    <th style="width:20%;">Category</th>
                                    <th style="width:10%;">Views</th>
                                   <!-- <th style="width:10%;">User</th>-->
                                     <th style="width:20%;">Date</th> 
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
                                    <td><i class="lar la-star mr-2"></i></td>
                                    <td></td>
                                    <td>
                                       <i class="lar la-eye "></i>
                                    </td>
                                  
                                     <td>21 July,2020</td> 
                                    <td><i class="las la-heart text-primary"></i></td>
                                 </tr>
                                  
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
                <div class="form-popup " id="myForm" style="background:url(<?php echo URL::to('/').'/assets/img/Landban.png';?>) no-repeat;	background-size: cover;padding:40px;">
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
     document.getElementById("avatar").style.display = "none";
     document.getElementById("recentviews").style.display = "none";
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



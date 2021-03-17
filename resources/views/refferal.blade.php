<!doctype html>
<html lang="en-US">
   <head>
      <!-- Required meta tags -->
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Flicknexs</title>
       <!--<script type="text/javascript" src="<?php echo URL::to('/').'/assets/js/jquery.hoverplay.js';?>"></script>-->
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
      <!-- Favicon -->
      <link rel="shortcut icon" href="assets/images/fl-logo.png" />
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
      <!-- Typography CSS -->
      <link rel="stylesheet" href="assets/css/typography.css" />
      <!-- Style -->
      <link rel="stylesheet" href="assets/css/style.css" />
      <!-- Responsive -->
      <link rel="stylesheet" href="assets/css/responsive.css" />
       <style>
           .h-100 {
    height: 540px !important;
}
           .blink_me {
    animation: blinker 2s linear infinite;
  }
  @keyframes blinker {
    50% {
      opacity: 0;
    }
  }
           .container{
        height: 540px !important;
    }
    .item{
        margin-top: 60px;
    }
    
        .lablecolor{
        color: #000;
    }
    #update_profile_form label {
    color: #756969;
    } .list-group-item {
        color: #000;
    }
    .referral {
    margin-top: 80px;
}
            a {
    color: var(--iq-body-text) !important;
}
            .navbar-right.menu-right {
    margin-right: -150px !important;
}
              </style>
   </head>
 
             
   <body>
<!-- Header -->
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
                        <a class="navbar-brand" href="<?php echo URL::to('home') ?>"> <img src="<?php echo URL::to('/').'/assets/img/logo.png'?>" class="c-logo" alt="Flicknexs"> </a>
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
                                                <a class="dropdown-item cont-item" href="<?php echo URL::to('/').'/category/'.$category->slug;?>"> 
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
                                          <li class="nav-item dropdown menu-item">
                                            <a class="dropdown-toggle" href="<?php echo URL::to('/').$menu->url;?>" data-toggle="dropdown">  
                                              Movies <!--<i class="fa fa-angle-down"></i>-->
                                            </a>
                                              <ul class="dropdown-menu categ-head">
                                                  <?php foreach ( $languages as $language) { ?>
                                                  <li>
                                                    <a class="dropdown-item cont-item" href="<?php echo URL::to('/').'/language/'.$language->id.'/'.$language->name;?>"> 
                                                      <?php echo $language->name;?> 
                                                    </a>
                                                  </li>

                                                <?php } ?>
                                                </ul>
                                            </li>
                                          <li class="">
                                            <a href="<?php echo URL::to('refferal') ?>" style="color: #4895d1 !important;list-style: none;
                                                                                               font-weight: bold;
                                                                                               font-size: 16px;">
                                              <?php echo __('Refer and Earn');?>
                                            </a>
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
                                 <a href="#" class="search-toggle device-search">
                                 <i class="ri-search-line"></i>
                                 </a>
                                 <div class="search-box iq-search-bar d-search">
                                    <form action="#" class="searchbox">
                                       <div class="form-group position-relative">
                                          <input type="text" class="text search-input font-size-12"
                                             placeholder="type here to search...">
                                          <i class="search-link ri-search-line"></i>
                                       </div>
                                    </form>
                                 </div>
                              </li>
                              <li class="nav-item nav-icon">
                                 <a href="#" class="search-toggle" data-toggle="search-toggle">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22"
                                       class="noti-svg">
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
                                 <a href="#" class="iq-user-dropdown search-toggle p-0 d-flex align-items-center"
                                    data-toggle="search-toggle">
                                 <img src="<?php echo URL::to('/').'/public/uploads/avatars/' . Auth::user()->avatar ?>" class="img-fluid avatar-40 rounded-circle" alt="user">
                                 </a>
                                 <div class="iq-sub-dropdown iq-user-dropdown">
                                    <div class="iq-card shadow-none m-0">
                                       <div class="iq-card-body p-0 pl-3 pr-3">
                                          <a href="<?php echo  URL::to('myprofile') ?>" class="iq-sub-card setting-dropdown">
                                             <div class="media align-items-center">
                                                <div class="right-icon">
                                                   <i class="ri-file-user-line text-primary"></i>
                                                </div>
                                                <div class="media-body ml-3">
                                                   <h6 class="mb-0 ">Manage Profile</h6>
                                                </div>
                                             </div>
                                          </a>
                                          <a href="<?php echo URL::to('watchlaters') ?>" class="iq-sub-card setting-dropdown">
                                             <div class="media align-items-center">
                                                <div class="right-icon">
                                                   <i class="ri-settings-4-line text-primary"></i>
                                                </div>
                                                <div class="media-body ml-3">
                                                   <h6 class="mb-0 ">Watch Later</h6>
                                                </div>
                                             </div>
                                          </a>
                                            <a href="<?php echo URL::to('showPayperview') ?>" class="iq-sub-card setting-dropdown">
                                             <div class="media align-items-center">
                                                <div class="right-icon">
                                                   <i class="ri-settings-4-line text-primary"></i>
                                                </div>
                                                <div class="media-body ml-3">
                                                   <h6 class="mb-0 ">Rented Movies</h6>
                                                </div>
                                             </div>
                                          </a>
                                          <a href="<?php echo URL::to('admin/plans') ?>"  class="iq-sub-card setting-dropdown">
                                             <div class="media align-items-center">
                                                <div class="right-icon">
                                                   <i class="ri-settings-4-line text-primary"></i>
                                                </div>
                                                <div class="media-body ml-3">
                                                   <h6 class="mb-0 ">Pricing Plan</h6>
                                                </div>
                                             </div>
                                          </a>
                                           <a href="<?php echo URL::to('admin') ?>" class="iq-sub-card setting-dropdown">
                                             <div class="media align-items-center">
                                                <div class="right-icon">
                                                   <i class="ri-settings-4-line text-primary"></i>
                                                </div>
                                                <div class="media-body ml-3">
                                                   <h6 class="mb-0 ">Admin</h6>
                                                </div>
                                             </div>
                                          </a>
                                          <a href="<?php echo URL::to('logout') ?>" class="iq-sub-card setting-dropdown">
                                             <div class="media align-items-center">
                                                <div class="right-icon">
                                                   <i class="ri-logout-circle-line text-primary"></i>
                                                </div>
                                                <div class="media-body ml-3">
                                                   <h6 class="mb-0 ">Logout</h6>
                                                </div>
                                             </div>
                                          </a>
                                       </div>
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
      <!-- Header End -->

<?php
if (Auth::user()) { 
    $current_url = url()->current();
    $twitter_share = urlencode(Auth::user()->referral_link);
    $user_id = Auth::user()->id;
    $coupons = App\Coupon::all();
         $user_id = Auth::user()->id;
         foreach($coupons as $coupon) { 
            $coupon_code = $coupon->coupon_code;
         } 
}
?>

<div class="container-fluid" >
    <div class="row page-height margin-top-20">	
        	<div class="col-md-12" align="center">
			<div class="referral">
                
                <?php 
                if ( Auth::user() && Auth::user()->role == 'subscriber') { ?>

                    <h1 class="title"  style="color:#fff;"><i class="fa fa-comments"></i> Tell friends about Flicknexs <a href="<?php echo URL::to('/my-refferals');?>"><span class="pull-right" style="background: #c3ab06;padding: 10px;border-radius: 30px;color: #fff;font-size: 16px;">My referral</span> </a> </h1>
				    <p class="grey-border"></p>
               
		        	<div class="clear"></div>
					
                
                	<div class="referral-body">
						<div class="row">
							<div class="col-md-12">
								<div class=""><h2 class="sub-title">Share this link so your friends can join the conversation around all your favorite TV shows and movies.</h2>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-8">
								<div class="row">
									<p style="padding-left: 15px;">Referral link </p>
                                        <div class="col-sm-8" style="padding-right:0;">
<!-- <input type="text" class="form-control" value="{{ URL::to('/signup').'?ref='.Auth::user()->referral_token }}&coupon={{$coupon_code}}" id="myInput" disabled> -->
                                        <p id="p1" class="form-control" style="background:#fff;">
                                            {{ URL::to('/signup').'?ref='.Auth::user()->referral_token }}&coupon={{$coupon_code}}</p>
                                        </div>
									<div class="col-sm-2">
										<button class="btn btn-primary" onclick="copyToClipboard('#p1')">Copy Link</button>
									</div>
								</div>
								<ul class="list-group mt-3" >
									<li class="list-group-item">Username: <strong>{{ Auth::user()->username }}</strong></li>
									<li class="list-group-item">Email: <strong>{{ Auth::user()->email }}</strong></li>
									<li class="list-group-item">Referrer: <strong>{{ Auth::user()->referrer->name ?? 'Not Specified' }}</strong></li>
									<li class="list-group-item">Referral count: <strong>{{ ReferrerCount(Auth::user()->id)  ?? '0' }}</strong></li>
									<li class="list-group-item">Used Coupon  count: <strong>{{ GetCouponPurchase($user_id)  ?? '0' }}</strong></li>
									<li class="list-group-item">Available Coupon  count: <strong>{{ ReferrerCount(Auth::user()->id)  - GetCouponPurchase($user_id)  ?? '0' }}</strong></li>
								</ul>
							</div>
							<div class="col-md-4">
								<p>Share on Social Media </p>
								<ul class="rrssb-buttons clearfix">
									<li class="rrssb-facebook small">
										<a href="https://www.facebook.com/sharer/sharer.php?u={{ Auth::user()->referral_link }}&coupon={{$coupon_code}}" class="popup">
											<span class="rrssb-icon">
												<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="28px" height="28px" viewBox="0 0 28 28" enable-background="new 0 0 28 28" xml:space="preserve">
													<path d="M27.825,4.783c0-2.427-2.182-4.608-4.608-4.608H4.783c-2.422,0-4.608,2.182-4.608,4.608v18.434
														c0,2.427,2.181,4.608,4.608,4.608H14V17.379h-3.379v-4.608H14v-1.795c0-3.089,2.335-5.885,5.192-5.885h3.718v4.608h-3.726
														c-0.408,0-0.884,0.492-0.884,1.236v1.836h4.609v4.608h-4.609v10.446h4.916c2.422,0,4.608-2.188,4.608-4.608V4.783z"/>
												</svg>
											</span>
										</a>
									</li>
									<li class="rrssb-twitter small">
										<a href="https://twitter.com/intent/tweet?url={{ Auth::user()->referral_link }}&coupon={{$coupon_code}}" class="popup">
											<span class="rrssb-icon">
												<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
													 width="28px" height="28px" viewBox="0 0 28 28" enable-background="new 0 0 28 28" xml:space="preserve">
												<path d="M24.253,8.756C24.689,17.08,18.297,24.182,9.97,24.62c-3.122,0.162-6.219-0.646-8.861-2.32
													c2.703,0.179,5.376-0.648,7.508-2.321c-2.072-0.247-3.818-1.661-4.489-3.638c0.801,0.128,1.62,0.076,2.399-0.155
													C4.045,15.72,2.215,13.6,2.115,11.077c0.688,0.275,1.426,0.407,2.168,0.386c-2.135-1.65-2.729-4.621-1.394-6.965
													C5.575,7.816,9.54,9.84,13.803,10.071c-0.842-2.739,0.694-5.64,3.434-6.482c2.018-0.623,4.212,0.044,5.546,1.683
													c1.186-0.213,2.318-0.662,3.329-1.317c-0.385,1.256-1.247,2.312-2.399,2.942c1.048-0.106,2.069-0.394,3.019-0.851
													C26.275,7.229,25.39,8.196,24.253,8.756z"/>
												</svg>
											</span>
										   <!-- <span class="rrssb-text">twitter</span> -->
										</a>
									</li>
									<!-- <li class="rrssb-email"></li> -->
								</ul>
							</div>
						</div>
                        
                   
                </div>
               
                </div>
            <?php } elseif( Auth::user() && Auth::user()->role == 'registered'){ ?>
                	<div class="referral-body">
						<div class="row">
							<div class="col-md-10 col-sm-offset-1 refernearn">
									<h1 class="text-center"> Refer 'N' Earn with Flicknexs</h1>                                       
									<img src="<?php echo URL::to('/').'/assets/img/users.png';?>" class="img-responsive" />
                                    <p class="text-center">
                                        Flicknexs Refer'N'Earn offer for Coupon Codes. Each user can earn a coupon code after your get subscribed with us. The offer provides Coupon Code on every successful referral Subscriptions.
                                    </p>   
                                
                                    <p class="text-center">Here is a chance to become a Referrer.</p>
									<div class="text-center">
										<a href="<?php echo URL::to('/').'/becomesubscriber';?>" class="btn btn-primary btn-login nomargin noborder-radius text-center"> Become Subscriber</a>
									</div>
                            	</div> 
                            </div>
                        </div>
              
                    
               <?php } else{ ?>
                    <div class="referral-body">
						<div class="row">
							<div class="col-md-10 col-sm-offset-1 refernearn">
								<h1 class="text-center"> Refer 'N' Earn with Flicknexs</h1> 
								<img src="<?php echo URL::to('/').'/assets/img/users.png';?>" class="img-responsive" />
								<p class="text-center">
									Flicknexs Refer'N'Earn offer for Coupon Codes. Each user can earn a coupon code after your get subscribed with us. The offer provides Coupon Code on every successful referral Subscriptions.
								</p>   

							    <p class="text-center">Here is a chance to become a Referrer.</p>
								<div class="text-center">
									<a href="<?php echo URL::to('/').'/login';?>" class="btn btn-primary btn-login nomargin noborder-radius text-center"> Click here to Become Subscriber</a>
								</div>
                            </div>    
						</div>
                     </div>
                <?php } ?>
        </div>
    </div>
</div>



         <!-- back-to-top End -->
      <!-- jQuery, Popper JS -->
      <script src="assets/js/jquery-3.4.1.min.js"></script>
      <script src="assets/js/popper.min.js"></script>
      <!-- Bootstrap JS -->
      <script src="assets/js/bootstrap.min.js"></script>
      <!-- Slick JS -->
      <script src="assets/js/slick.min.js"></script>
      <!-- owl carousel Js -->
      <script src="assets/js/owl.carousel.min.js"></script>
      <!-- select2 Js -->
      <script src="assets/js/select2.min.js"></script>
      <!-- Magnific Popup-->
      <script src="assets/js/jquery.magnific-popup.min.js"></script>
      <!-- Slick Animation-->
      <script src="assets/js/slick-animation.min.js"></script>
      <!-- Custom JS-->
      <script src="assets/js/custom.js"></script>
       <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<script>
function copyToClipboard(element) {
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val($(element).text()).select();
  document.execCommand("copy");
  $temp.remove();
}

</script></body>
       @extends('footer')
    </html>
     
       
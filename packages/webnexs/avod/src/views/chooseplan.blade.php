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
    <link rel="shortcut icon" href="" />
   <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="<?= URL::to('/'). '/assets/admin/dashassets/css/bootstrap.min.css';?>" />
    
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
    body{margin-top:20px}.panel{text-align:center}.panel:hover{box-shadow:0 1px 5px rgba(0,0,0,.4),0 1px 5px rgba(130,130,130,.35)}.panel-body{padding:0;text-align:center}.the-price{background-color:rgba(220,220,220,.17);box-shadow:0 1px 0 #dcdcdc,inset 0 1px 0 #fff;padding:20px;margin:0}.the-price h1{line-height:1em;padding:0;margin:0}.subscript{font-size:25px}.cnrflash{position:absolute;top:-9px;right:4px;z-index:1;overflow:hidden;width:100px;height:100px;border-radius:3px 5px 3px 0}.cnrflash-inner{position:absolute;bottom:0;right:0;width:145px;height:145px;-ms-transform:rotate(45deg);-o-transform:rotate(45deg);-moz-transform:rotate(45deg);-webkit-transform:rotate(45deg);-webkit-transform-origin:100% 100%;-ms-transform-origin:100% 100%;-o-transform-origin:100% 100%;-moz-transform-origin:100% 100%;background-image:linear-gradient(90deg,transparent 50%,rgba(255,255,255,.1) 50%),linear-gradient(0deg,transparent 0,rgba(1,1,1,.2) 50%);background-size:4px,auto,auto,auto;background-color:#aa0101;box-shadow:0 3px 3px 0 rgba(1,1,1,.5),0 1px 0 0 rgba(1,1,1,.5),inset 0 -1px 8px 0 rgba(255,255,255,.3),inset 0 -1px 0 0 rgba(255,255,255,.2)}.cnrflash-inner:after,.cnrflash-inner:before{content:" ";display:block;position:absolute;bottom:-16px;width:0;height:0;border:8px solid maroon}.cnrflash-inner:before{left:1px;border-bottom-color:transparent;border-right-color:transparent}.cnrflash-inner:after{right:0;border-bottom-color:transparent;border-left-color:transparent}.cnrflash-label{position:absolute;bottom:0;left:0;display:block;width:100%;padding-bottom:5px;color:#fff;text-shadow:0 1px 1px rgba(1,1,1,.8);font-size:.95em;font-weight:700;text-align:center}
    
</style>

</head>
<body >



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
                   <div class="bod"></div>
                   
                    <!-- <div>
                        <p class="" style="color:#0993D2!important;padding-left:30px;font-weight: 600;">Ads Management</p>
                    </div>
                    <li><a href="<?php echo URL::to('advertiser') ?>/ads-list" class="iq-waves-effect"><i class="ri-price-tag-line"></i><span>Advertisements</span></a></li>

                    <li><a href="" class="iq-waves-effect"><i class="la la-sliders"></i><span> Upload Ads</span></a></li>

                    <li><a href="" class="iq-waves-effect"><i class="la la-sliders"></i><span> Plans History</span></a></li> -->
                    
                    <li><a href="<?php echo URL::to('advertiser') ?>/logout" class="iq-waves-effect"><i class="la la-sliders"></i><span> Logout</span></a></li>

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
        
        <!--<hr />-->
    
        <div id="main-admin-content">
    
        <div id="content-page" class="content-page">
         <div class="container-fluid">
         <div class="row">
            @foreach($plans as $plan)
        <div class="col-xs-12 col-md-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        {{ $plan->plan_name }}</h3>
                </div>
                <div class="panel-body">
                    <div class="the-price">
                        <h1>
                            ${{$plan->plan_amount}}<span class="subscript">/mo</span></h1>
                    </div>
                    <table class="table">
                        <tr>
                            <td>
                                {{$plan->no_of_ads}} Ads
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span data-planid="{{ $plan->id }}" class="chooseplan"><button class="btn btn-primary">BUY Now</button></span>
                            </td>
                        </tr>
                        
                    </table>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    </div>
 </div>
                
    
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
                   Copyright 2021 <a href="<?php echo URL::to('home') ?>">Flicknexs</a> All Rights Reserved.
                </div>
             </div>
          </div>
       </footer>
      </div>
      
      
    </div>
    
<div class="modal fade" id="paymentModal">
          <div class="modal-dialog" role="document">
           <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Payment Gateway</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
           </button>
        </div>
        <form method="POST" action="{{ url('advertiser/paymentgateway') }}" class="mt-4" autocomplete="off">
        <div class="modal-body">
         @csrf
         <input type="hidden" name="plan_id" id="plan_id" value="">
           <div class="form-check">
             <input class="form-check-input" type="radio" name="paymentgateway" id="stripe" checked value="stripe">
             <label class="form-check-label" for="stripe">
               Stripe Pay using cards
           </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="paymentgateway" id="razorpay" value="razorpay">
          <label class="form-check-label" for="razorpay">
           Razorpay Pay using cards, Netbanking, UPI
        </label>
     </div>

       </div>
       <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="proceedpayment">Next</button>
       </div>
    </div>
 </div>
</div>


  <!-- Imported styles on this page -->
  <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/jquery.min.js';?>"></script>
   <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/popper.min.js';?>"></script>
   <script src="<?= URL::to('/'). '/assets/admin/dashassets/js/jquery.dataTables.min.js';?>"></script>
  
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
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

  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<script type="text/javascript">
<?php if(session('success')){ ?>
    toastr.success("<?php echo session('success'); ?>");
<?php }else if(session('error')){  ?>
    toastr.error("<?php echo session('error'); ?>");
<?php }else if(session('warning')){  ?>
    toastr.warning("<?php echo session('warning'); ?>");
<?php }else if(session('info')){  ?>
    toastr.info("<?php echo session('info'); ?>");

<?php } ?>
$(".chooseplan").click(function(){
   var plan_id = $(this).data('planid');
   $("#plan_id").val(plan_id);
   $("#paymentModal").modal('show');
});


</script>
</body>
</html>
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
   <link rel="shortcut icon" href="<?php echo getFavicon();?>" type="image/gif" sizes="16x16">
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
   <link rel="stylesheet" href="<?= URL::to('/'). '/assets/admin/dashassets/css/advertiserstyle.css';?>" />

  <!--[if lt IE 9]><script src="<?= THEME_URL .'/assets/admin/admin/js/ie8-responsive-file-warning.js'; ?>"></script><![endif]-->

  <!-- HTML5 shim and Respond.js') }} IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js') }}"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js') }}/1.4.2/respond.min.js') }}"></script>
  <![endif]-->
<style>

    .top-left-logo img{opacity:.9;overflow:hidden}span{font-weight:400!important}.header-logo{padding-left:25px}hr{border-top:1px solid #e2e2e22e!important}body{margin-top:20px}.panel{text-align:center}.panel:hover{box-shadow:0 1px 5px rgba(0,0,0,.4),0 1px 5px rgba(130,130,130,.35)}.panel-body{padding:0;text-align:center}.the-price{background-color:rgba(220,220,220,.17);box-shadow:0 1px 0 #dcdcdc,inset 0 1px 0 #fff;padding:20px;margin:0}.the-price h1{line-height:1em;padding:0;margin:0}.subscript{font-size:25px}.cnrflash{position:absolute;top:-9px;right:4px;z-index:1;overflow:hidden;width:100px;height:100px;border-radius:3px 5px 3px 0}.cnrflash-inner{position:absolute;bottom:0;right:0;width:145px;height:145px;-ms-transform:rotate(45deg);-o-transform:rotate(45deg);-moz-transform:rotate(45deg);-webkit-transform:rotate(45deg);-webkit-transform-origin:100% 100%;-ms-transform-origin:100% 100%;-o-transform-origin:100% 100%;-moz-transform-origin:100% 100%;background-image:linear-gradient(90deg,transparent 50%,rgba(255,255,255,.1) 50%),linear-gradient(0deg,transparent 0,rgba(1,1,1,.2) 50%);background-size:4px,auto,auto,auto;background-color:#aa0101;box-shadow:0 3px 3px 0 rgba(1,1,1,.5),0 1px 0 0 rgba(1,1,1,.5),inset 0 -1px 8px 0 rgba(255,255,255,.3),inset 0 -1px 0 0 rgba(255,255,255,.2)}.cnrflash-inner:after,.cnrflash-inner:before{content:" ";display:block;position:absolute;bottom:-16px;width:0;height:0;border:8px solid maroon}.cnrflash-inner:before{left:1px;border-bottom-color:transparent;border-right-color:transparent}.cnrflash-inner:after{right:0;border-bottom-color:transparent;border-left-color:transparent}.cnrflash-label{position:absolute;bottom:0;left:0;display:block;width:100%;padding-bottom:5px;color:#fff;text-shadow:0 1px 1px rgba(1,1,1,.8);font-size:.95em;font-weight:700;text-align:center}.razorpay-payment-button{background:#0993D2;border-radius:2px;color:#fff!important;padding:0 10px;border:0}
    .action_block{display: none;}
    
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
        <div id="content-page" class="content-page">
         <div class="container-fluid">
            <div class="iq-card">

               <div id="admin-container">
                  <div class=" mt-4 p-2">
                     <h3>Payments</h3>
                  </div>
                  <div class="container">
                     <div class="border-d mt-3">
                        <div class=" d-flex col-sm-12  align-items-center">
                           <input type="radio" name="gateway_payment" value="razorpay">
                           <h3 class="ml-4">Razorpay Payment Gateway</h3>
                        </div>
                        <div class="action_block razorpay">
                           <div class="col-sm-6 mt-4 pl-5 ">
                              <form action="{{ route('buyplanrazorpay') }}" method="POST" >
                                 <input type="hidden" name="plan_id" value="{{ $plan_id }}">
                                 @csrf
                                 <script src="https://checkout.razorpay.com/v1/checkout.js"
                                 data-key="{{ env('RAZORPAY_KEY') }}"
                                 data-amount="{{ $plan_amount }}"
                                 data-buttontext="Pay Now using Razorpay Payment Gateway"
                                 data-name="{{ $website_name }}"
                                 data-description="Advertiser Plan Upgrade"
                                 data-image="{{ URL::to('/').'/public/uploads/settings/'. $website_logo }}" 
                                 data-prefill.name="{{$user->company_name}}"
                                 data-prefill.email="{{$user->email_id}}"
                                 data-theme.color="#0993D2">
                              </script>
                           </form>
                        </div>
                        <div class="mt-4 p-2 pl-5">
                          <h3>{{ $plan_name }}</h3>
                          <p class="mt-2">No of Ads - {{ $no_of_ads }}</p>
                          <table class="table table-striped">
                           <thead>
                              <tr style="background: #F2F5FA;border: 0.2px solid rgba(0, 0, 0, 0.5);">
                                 <th class="text-left" scope="col-12">Amount</th>
                                 <th class="text-right" scope="col">$ {{ $plan_value }}</th>
                              </tr>
                           </thead>
                           <tbody>
                              <tr>
                                 <th scope="row">Total</th>

                                 <td class="text-right">$ {{ $plan_value }}</td>
                              </tr>
                              <th></th>
                              <th></th>


                           </tbody>
                        </table>

                     </div>
                  </div>
               </div>
                  
                     <div class="border-d mt-3">
                        <div class=" d-flex col-sm-12  align-items-center">
                           <input type="radio" name="gateway_payment" value="stripe">
                           <h3 class="ml-4">Stripe Payment Gateway</h3>

                        </div>
                        <div class="action_block stripe">
                         <div class="mt-3 pl-5">
                          <div class="form-group row">
                        <input type="hidden" name="plan_id" class="form-controll" id="plan_id" value="{{ $plan_id }}">
                        <div class="col-md-6"> 
                           <input id="card-holder-name" type="text" class="form-control" placeholder="Card Holder Name">
                        </div>
                     </div>
                     <!-- Stripe Elements Placeholder -->
                     <div id="card-element" ></div><br>
                     <div class="sign-up-buttons pay-button">
                         {{-- <a type="button" id="card-button" class="btn btn-primary pay"  data-secret="{{ $intent->client_secret }}">Pay Now</a> --}}
                     </div>
                        <input type="hidden" id="stripe_key" value="{{ env('STRIPE_KEY') }}">
                     </div>
                        
                       
                           <div class="mt-4 p-2 pl-5">
                              <h3>{{ $plan_name }}</h3>
                              <p class="mt-2">No of Ads - {{ $no_of_ads }}</p>
                              <table class="table table-striped">
                                 <thead>
                                    <tr style="background: #F2F5FA;border: 0.2px solid rgba(0, 0, 0, 0.5);">
                                       <th class="text-left" scope="col-12">Amount</th>
                                       <th class="text-right" scope="col">$ {{ $plan_value }}</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <tr>
                                       <th scope="row">Total</th>

                                       <td class="text-right">$ {{ $plan_value }}</td>
                                    </tr>
                                    <th></th>
                                    <th></th>


                                 </tbody>
                              </table>
                              <div class="text-right">

                                 <a type="button" id="card-button" class="btn btn-primary pay processing_alert"  data-secret="{{ $intent->client_secret }}">Pay using Stripe Payment Cateway</a>
                              </div>
                           </div>
                        </div>
                        </div>
                     </div>
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
    
<input type="hidden" id="base_url" value="<?php echo URL::to('/').'/advertiser';?>">
<input type="hidden" id="payment_image" value="<?php echo URL::to('/').'/public/Thumbnai_images';?>">


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

</script>
<script src="https://js.stripe.com/v3/"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>
       var base_url = $('#base_url').val();
       var payment_images = $('#payment_image').val();

       
       var stripe_key = $("#stripe_key").val();
       const stripe = Stripe(stripe_key);
        const elements = stripe.elements();
      var style = {
        base: {
         color: '#303238',
         fontSize: '16px',
         fontFamily: '"Open Sans", sans-serif',
         fontSmoothing: 'antialiased',
         '::placeholder': {
           color: '#ccc',
         },
        },
        CardNumberField : {
           background: '#f1f1f1', 
           padding: '10px',
           borderRadius: '4px', 
           transform: 'none',
        },
        invalid: {
         color: '#e5424d',
         ':focus': {
           color: '#303238',
         },
        },
      };
   
      var elementClasses = {
         class : 'CardNumberField',
         empty: 'empty',
         invalid: 'invalid',
        };

   
      // Create an instance of the card Element.
      var cardElement = elements.create('card', {style: style, classes: elementClasses });


        cardElement.mount('#card-element');
        const cardHolderName = document.getElementById('card-holder-name');
        const cardButton = document.getElementById('card-button');
       
        const clientSecret = cardButton.dataset.secret;
        cardButton.addEventListener('click', async (e) => {
        const { setupIntent, error } = await stripe.confirmCardSetup(
            clientSecret, {
                payment_method: {
                    card: cardElement,
                    billing_details: { name: cardHolderName.value }
                }
            }
        );
        if (error) {
             swal("Your Payment is failed !");
            // Display "error.message" to the user...
        } else {
                var plan_data = $("#plan_id").val();
               
                var py_id = setupIntent.payment_method;
               
                   $.post(base_url+'/buyplan', {
                     py_id:py_id, plan:plan_data, _token: '<?= csrf_token(); ?>' 
                   }, 
                function(data){
                  if(data == 'success'){
                    swal({
                        title: "Success!",
                        text: "You have done  Payment !",
                        icon: payment_images+'/Successful_Payment.gif',
                        closeOnClickOutside: false,
                     });

                    setTimeout(function() {
                        window.location.replace(base_url+'/billing_details');
                     }, 3000);
                 }
                 else{
                  swal('Error');
                  window.location.replace(base_url);
                 }
               });

            // The card has been verified successfully...
        }
    });



$('input[type=radio][name=gateway_payment]').change(function() {
    if (this.value == 'stripe') {
        $(".action_block.razorpay").css('display','none');
        $(".action_block.stripe").css('display','block');
    }
    else if (this.value == 'razorpay') {
        $(".action_block.stripe").css('display','none');
        $(".action_block.razorpay").css('display','block');

    }
});

$(".processing_alert").click(function(){

   swal({
      title: "Processing Payment!",
      text: "Please wait untill the proccessing completed!",
      icon: payment_images+'/processing_payment.gif',
      buttons: false,      
      closeOnClickOutside: false,
   });

  });
</script>

</body>
</html>
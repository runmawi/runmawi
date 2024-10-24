@include('avod::ads_header')

<div id="main-admin-content" style="color: black">
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="iq-card">
                        <div class="justify-content-between d-flex">
                           <h2 class=" mb-3 ml-3 mt-3">Advertisement Payment</h2>
                        </div>
                        <hr>

                        <section class="payment-details">
                            <div class="container payment-details-container">
                                <div class="row">
                                    <div class="col-lg-7 col-md-6 p-0">
                                        <div class="payment-details1">
                                             <p class="" style="font-size: 16px;">Welcome </p>
                                             <div class="medium-heading pb-3 pl-2"> Make a payment for uploads advertisement on your videos </div>
                        
                                            <div class="col-md-12 p-0">
                                                <p class="meth"> Payment Method</p>

                                                <div class="payment-methods d-flex">
                                                    <!-- Stripe -->
                                                    <div class="payment-methodname ml-3">
                                                        <input type="radio" id="stripe_radio_button" class="payment_gateway" name="payment_gateway" value="stripe" checked="checked"> 
                                                        <label class="ml-1"><p> STRIPE </p></label> <br>
                                                    </div>
                                                        
                                                    <!-- Paystack -->
                                
                                                    <!-- Razorpay -->
                                                    <div class="payment-methodname ml-3">
                                                        <input type="radio" id="Razorpay_radio_button" class="payment_gateway" name="payment_gateway" value="Razorpay">
                                                        <label class="ml-1"><p> RAZORPAY </p></label> 
                                                    </div>
                                                        
                                                    <!-- PayPal -->
                                                    <div class="payment-methodname ml-3">
                                                        <input type="radio" id="paypaul_radio_button" class="payment_gateway" name="payment_gateway" value="paypal"> 
                                                        <label class="ml-1"> <p>PAYPAL </p></label> <br>
                                                    </div>
                                                </div>
                                                
                                            </div>      
                        
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="data-plans row align-items-center m-0 p-0">
                                                        <div style="" class="col-md-6 plan_details p-0">
                                                            <a href="#payment_card_scroll">
                                                                <div class="row dg align-items-center mb-4">
                                                                    <div class="col-md-7 p-0">
                                                                        <h5 class=" font-weight-bold"> Annual Subscription </h5>
                                                                        <p>Annual Subscription Membership</p>
                                                                    </div>
                                                                    <div class="vl "></div>
                                                                    <div class="col-md-4 p-2">
                                                                        <h4 class="">₹39.99</h4>
                                                                        <p>Billed as ₹39.99</p>
                                                                    </div>
                                                                </div>
                        
                                                                <div class="d-flex justify-content-between align-items-center ">
                                                                    <div class="bgk"></div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                     
                                                        
                                                        <div style="" class="col-md-6 plan_details p-0">
                                                            <a href="#payment_card_scroll">
                                                                <div class="row dg align-items-center mb-4">
                                                                    <div class="col-md-7 p-0">
                                                                        <h5 class=" font-weight-bold"> Monthly Subscription </h5>
                                                                        <p>Monthly Subscription Membership</p>
                                                                    </div>
                                                                    <div class="vl "></div>
                                                                    <div class="col-md-4 p-2">
                                                                        <h4 class="">₹3.99</h4>
                                                                        <p>Billed as ₹3.99</p>
                                                                    </div>
                                                                </div>
                        
                                                                <div class="d-flex justify-content-between align-items-center ">
                                                                    <div class="bgk"></div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                     
                                                        
                                                        <div style="" class="col-md-6 plan_details p-0">
                                                            <a href="#payment_card_scroll">
                                                                <div class="row dg align-items-center mb-4">
                                                                    <div class="col-md-7 p-0">
                                                                        <h5 class=" font-weight-bold"> RODtv Annual Subscription </h4>
                                                                        <p>RODtv Annual Subscription Membership</p>
                                                                    </div>
                                                                    <div class="vl "></div>
                                                                    <div class="col-md-4 p-2">
                                                                        <h4 class="">₹39.99</h4>
                                                                        <p>Billed as ₹39.99</p>
                                                                    </div>
                                                                </div>
                        
                                                                <div class="d-flex justify-content-between align-items-center ">
                                                                    <div class="bgk"></div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                     
                                                        
                                                        <div style="" class="col-md-6 plan_details p-0>
                                                            <a href="#payment_card_scroll">
                                                                <div class="row dg align-items-center mb-4">
                                                                    <div class="col-md-7 p-0">
                                                                        <h5 class=" font-weight-bold"> RODtv Monthly Subscription </h4>
                                                                        <p>RODtv Monthly Subscription Membership</p>
                                                                    </div>
                                                                    <div class="vl "></div>
                                                                    <div class="col-md-4 p-2">
                                                                        <h4 class="">₹3.99</h4>
                                                                        <p>Billed as ₹3.99</p>
                                                                    </div>
                                                                </div>
                        
                                                                <div class="d-flex justify-content-between align-items-center ">
                                                                    <div class="bgk"></div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                     
                                                        
                                                        <div style="" class="col-md-6 plan_details p-0">
                                                            <a href="#payment_card_scroll">
                                                                <div class="row dg align-items-center mb-4">
                                                                    <div class="col-md-7 p-0">
                                                                        <h5 class=" font-weight-bold"> Test Monthly Subscription </h5>
                                                                        <p>Test Monthly Subscription Membership</p>
                                                                    </div>
                                                                    <div class="vl "></div>
                                                                    <div class="col-md-4 p-2">
                                                                        <h4 class="">₹10</h4>
                                                                        <p>Billed as ₹10</p>
                                                                    </div>
                                                                </div>
                        
                                                                <div class="d-flex justify-content-between align-items-center ">
                                                                    <div class="bgk"></div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                                            </div>
                        
                                                                        
                        
                                                                        </div>
                        
                        
                                            <div class="col-md-12 mt-5" id="payment_card_scroll">
                                                <div class="cont stripe_payment bg-white">
                                                 <div class="d-flex justify-content-between align-items-center">
                                                     <div> <h3>Payment</h3> </div>
                        
                                                    <div>
                                                        <label for="fname">Accepted Cards</label>
                                                        <div class="icon-container">
                                                             <i class="fa fa-cc-visa" style="color: navy;"></i>
                                                             <i class="fa fa-cc-amex" style="color: blue;"></i>
                                                             <i class="fa fa-cc-mastercard" style="color: red;"></i>
                                                             <i class="fa fa-cc-discover" style="color: orange;"></i>
                                                        </div>
                                                    </div>
                                                </div>
                        
                                                <div class="mt-3"></div>
                        
                                                <label for="fname"><i class="fa fa-user"></i> Full Name</label>
                        
                                                <input id="card-holder-name" type="text" class="form-control mb-3" placeholder="Card Holder Name">
                        
                                                <!-- Stripe Elements Placeholder -->
                                                <label for="ccnum"> Card Number</label>
                                                <div id="card-element" style="" class="StripeElement mb-3">
                                                    <div class="stripeElement">
                                                        <input class="stripeElement-input" maxlength="1">
                                                    </div>
                                                </div>
                        
                                                    <!-- Add Promotion Code -->
                                                    <div class="mt-3">
                                                        <label for="fname" style="float: right;cursor: pointer;" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" class="promo"> Add Promotion Code </label>
                                                        <div class="collapse show" id="collapseExample">
                                                            <div class="row p-0">
                                                                <div class="col-lg-6 p-0">
                                                                    <input id="coupon_code_stripe" type="text" class="form-control" placeholder="Add Promotion Code">
                                                                    <input id="final_coupon_code_stripe" name="final_coupon_code_stripe" type="hidden">
                                                                    </div>
                                                                <div class="col-lg-6 p-0"><a type="button" id="couple_apply" class="btn round">Apply</a></div>
                                                                <span id="coupon_message"></span>  
                                                            </div>
                                                        </div>
                                                    </div>
                                                
                                            </div>
                                        
                                        <h4>Summary</h4>
                        
                                        <div class="bg-white mt-4 dgk">
                                             <h4> Due today: <span class="plan_price"> ₹3.99 </span> </h4>
                                             
                                                <div class="d-flex justify-content-between align-items-center mt-2">
                                                    <div class="stripe_payment">
                                                        <p> Amount Deducted for Promotion Code&nbsp;&nbsp; </p>
                                                        <p> Payable Amount &nbsp; </p>
                                                    </div>
                        
                                                    <div class="stripe_payment">
                                                        <p id="promo_code_amt"> ₹0 </p>
                                                        <p id="coupon_amt_deduction"> ₹3.99 </p>
                                                    </div>
                                                </div>
                                            
                                             <hr>
                                             
                                            <p class="text-center mt-3">All state sales taxes apply</p>
                                        </div>
                        
                                         <p class=" mt-3 dp">
                                                  
                                         </p>
                                    </div>
                                                                    
                                            <div class="col-md-12 stripe_payment">
                                                <button id="card-button" class="btn1 btn-lg btn-block font-weight-bold  mt-3 processing_alert" style="background-color: #f5f5f5;">
                                                    Pay Now
                                                </button>
                                            </div>
                                          
                                                                    
                                            <div class="col-md-12 paystack_payment" style="display: none;">
                                                    <button type="submit" class="btn1 btn-lg btn-block font-weight-bold  mt-3 paystack_button processing_alert">
                                                        Pay Now
                                                    </button>
                                            </div>
                        
                                                                    
                                            <div class="col-md-12 Razorpay_payment" style="display: none;">
                                                <button type="submit" class="btn1 btn-lg btn-block font-weight-bold  mt-3 Razorpay_button processing_alert">
                                                    Pay Now
                                                </button>
                                            </div>
                                            
                                            
                                            
                                            
                                            <div class="col-md-12 cinetpay_payment">
                                                <button onclick="" type="submit" class="btn1 btn-lg btn-block font-weight-bold  mt-3 cinetpay_button" style="display: none;">
                                                    Pay Now
                                                </button>
                                            </div>
                                    </div>           
                            </div>
                            </div>
                            </div>
                                </div>
                        </section>
                       

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('avod::ads_footer')


<!-- Imported styles on this page -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/jquery.min.js' ?>"></script>
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/popper.min.js' ?>"></script>
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/jquery.dataTables.min.js' ?>"></script>
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/dataTables.bootstrap4.min.js' ?>"></script>
<!-- Appear JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/jquery.appear.js' ?>"></script>
<!-- Countdown JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/countdown.min.js' ?>"></script>
<!-- Select2 JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/select2.min.js' ?>"></script>
<!-- Counterup JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/waypoints.min.js' ?>"></script>
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/jquery.counterup.min.js' ?>"></script>
<!-- Wow JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/wow.min.js' ?>"></script>
<!-- Slick JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/slick.min.js' ?>"></script>
<!-- Owl Carousel JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/owl.carousel.min.js' ?>"></script>
<!-- Magnific Popup JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/jquery.magnific-popup.min.js' ?>"></script>
<!-- Smooth Scrollbar JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/smooth-scrollbar.js' ?>"></script>
<!-- apex Custom JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/apexcharts.js' ?>"></script>
<!-- Chart Custom JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/chart-custom.js' ?>"></script>
<!-- Custom JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/custom.js' ?>"></script>
<!-- End Notifications -->

<style>
    .iq-top-navbar {
        min-height: 73px;
        position: fixed;
        top: 0;
        /* left: auto; */
        right: 0;
        width: calc(100% - 55px);
        display: inline-block;
        z-index: 99;
        background: /*var(--iq-light-card)*/ #fff;
        margin-right: 25px;
        transition: all 0.45s ease 0s;
        border-bottom: 1px solid #f1f1f1;
    }
    .content-page {
        margin-left: 0px;
        padding: 100px 15px 0;
        transition: all 0.3s ease-out 0s;
    }
    .iq-footer{
        margin-left: 0px !important;
    }
    .payment-details-container{
        margin: 0px 50px;
    }
    .dg {
        padding: 10px;
        color: #000 !important;
        /* background-color: #fff; */
        margin: 5px;
        height: 200px;
        border: 5px solid #ddd;
    }
    .dgk{
        padding: 30px 24px;
        background-color: #f5f5f5 !important;
    }
    #card-element {
        height: 50px;
        background: white;
        padding: 10px;
    }
    .cont {
        background-color: #f5f5f5 !important;
        padding: 36px 47px 70px;
        margin-bottom: 35px;
    }
    .stripeElement{
        margin: 0px !important; 
        padding: 0px !important; 
        border: none !important; 
        display: block !important; 
        background: transparent !important; 
        position: relative !important; 
        opacity: 1 !important;
    }
    .stripeElement-input{
        border: none !important; 
        display: block !important; 
        position: absolute !important; 
        height: 1px !important; 
        top: -1px !important; 
        left: 0px !important; 
        padding: 0px !important; 
        margin: 0px !important; 
        width: 100% !important; 
        opacity: 0 !important; 
        background: transparent !important; 
        pointer-events: none !important; 
        font-size: 16px !important;
    }
    hr{
        border: 2px solid #988585;    
    }
    
</style>

@yield('javascript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
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
</body>

</html>

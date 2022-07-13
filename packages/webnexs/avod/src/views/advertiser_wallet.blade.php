@include('avod::ads_header')
    
        <div id="main-admin-content">

          <div id="content-page" class="content-page">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="iq-card">
                        <h2 class="text-center mb-4">Ads Campaign</h2>
                        <div id="nestable" class="nested-list dd with-margins">
                           <div class="panel panel-default ">
                              <div class="row">
                                <div class="col-md-12 mx-0">
                                   <div class="row justify-content-around text-center">
                                     @foreach($campaigns as $k=>$campaign)
                                    <div class="col-lg-4">
                                        <div class="card bg-success mb-5 mb-lg-0 rounded-lg shadow">
                                            <div class="card-header">
                                                <h5 class="card-title text-white-50 text-uppercase text-center">{{ $campaign->title }}</h5>
                                                <h6 class="h1 text-white text-center">${{$campaign->cost}}</h6>
                                            </div>
                                            <div class="card-body bg-light rounded-bottom" style="color:#111;">
                                                <ul class="list-unstyled mb-4">
                                                    <li class="mb-3"><span class="mr-3"><i class="fas fa-check text-success"></i></span>{{$campaign->no_of_ads}} Ads</li>
                                                </ul>
                                                <input type="radio" name="campaign_val" class="form-control" data-campaign_id="{{$campaign->id}}" data-amount="{{$campaign->cost}}" @if($k == 0) checked @endif>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach 
                                   
                                 </div>
                                 <div id="msform">
                                   <fieldset>
                                      <div class="form-card">
                                       <h2 class="fs-title">Payment</h2>
                                       <div class="col-md-6">
                                          <div class="d-flex align-items-baseline">
                                             <input type="radio" name="gateway_payment" value="razorpay" style="width: 15px;">
                                             <h5 class="ml-4">Razorpay Payment Gateway</h5>
                                          </div>
                                          <div class="action_block razorpay" style="display:none;">
                                             <div class="col-sm-6 mt-4 pl-5 ">
                                                @foreach($campaigns as $k=>$campaign)
                                                <form action="{{ route('buyrz_adcampaign') }}" method="POST" id="rzform{{$campaign->id}}" class="razorpayformclass" style="display: none;">
                                                   @csrf
                                                   <script src="https://checkout.razorpay.com/v1/checkout.js"
                                                   data-key="{{ env('RAZORPAY_KEY') }}"
                                                   data-amount="{{($campaign->cost * 100)}}"
                                                   data-buttontext="Pay Now"
                                                   data-name="Flicknexs"
                                                   data-description="Ad Campaign Purchase"
                                                   data-image="{{URL::to('/')}}/public/uploads/settings/logo (1).png"
                                                   data-prefill.name="{{$user->company_name}}"
                                                   data-prefill.email="{{$user->email_id}}"
                                                   data-theme.color="#0993D2">
                                                </script>
                                                   <input type="hidden" name="campaign_id" value="{{$campaign->id}}">
                                             </form>
                                             @endforeach
                                          </div>
                                       </div>
                                    </div>

                                    <div class="col-md-6">
                                       <div class="d-flex align-items-baseline">
                                          <input type="radio" name="gateway_payment" value="stripe" style="width: 15px;">
                                          <h5 class="ml-4">Stripe Payment Gateway</h5>

                                       </div>
                                       <div class="action_block stripe" style="display:none;">
                                        <div class="mt-3 pl-5">
                                         <div class="form-group row">
                                          <div class="col-md-8"> 
                                             <input id="card-holder-name" type="text" class="form-control" placeholder="Card Holder Name">
                                          </div>
                                       </div>
                                       <!-- Stripe Elements Placeholder -->
                                       <div id="card-element" ></div><br>
                                       <div class="sign-up-buttons pay-button">
                                        <a type="button" id="card-button" class="btn btn-primary pay"  data-secret="{{ $intent->client_secret }}">Pay Now</a></div>
                                        <input type="hidden" id="stripe_key" value="{{ env('STRIPE_KEY') }}">
                                     </div>

                                  </div>
                               </div>
                            </div>
                         </fieldset>
                     </div>
                         <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                      </div>
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
               
                var py_id = setupIntent.payment_method;
                var campaign_id = $('input[name="campaign_val"]:checked').attr('data-campaign_id');
                var amount = $('input[name="campaign_val"]:checked').attr('data-amount');
                   $.post(base_url+'/buycampaign_stripe', {
                     py_id:py_id,campaign_id:campaign_id, amount:amount, _token: '<?= csrf_token(); ?>' 
                   }, 
                function(data){
                  if(data == 'success'){
                    swal("You have done  Payment !");
                    setTimeout(function() {
                    window.location.replace(base_url+'/ads_campaign');
                        
                  }, 2000);
                 }else{
                  swal('Error');
                  window.location.replace(base_url);
                 }
               });

            // The card has been verified successfully...
        }
    });



$('input[type=radio][name=gateway_payment]').change(function() {
   var campaign_id = $('input[type=radio][name=campaign_val]:checked').attr('data-campaign_id');
       $(".razorpayformclass").css('display','none');
       $("#rzform"+campaign_id).css('display','block');
    if (this.value == 'stripe') {
        $(".action_block.razorpay").css('display','none');
        $(".action_block.stripe").css('display','block');
    }
    else if (this.value == 'razorpay') {
      $(".action_block.stripe").css('display','none');
      $(".action_block.razorpay").css('display','block');

    }
});


$('input[type=radio][name=campaign_val]').change(function() {
       var campaign_id = $('input[type=radio][name=campaign_val]:checked').attr('data-campaign_id');
       $(".razorpayformclass").css('display','none');
       $("#rzform"+campaign_id).css('display','block');
});

</script>
</body>
</html>
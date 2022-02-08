@extends('layouts.app')
@include('/header')
@section('content')
<?php 

$plan_id = session()->get('become_plan');
$plan_details = App\SubscriptionPlan::where("plan_id","=",$plan_id)->first();

// dd($plan_details);
?>


<script>
  $( function() {
    $( "#tabs" ).tabs();
    $("tabs li:first").addClass("active");
  });
    
  </script>
<div class="container mb-4">
<div class="row stripe justify-content-center" >
    
     <div class="col-md-6" id="signup-form">
    <div class="overlay payment-loader">
        
         
            <div class="panel-heading">
              <div class="row nomargin text-center pl-4">
                  
                    <h2 class="panel-title" style=" color: #000!important;"><?php echo __('Pay Now');?></h2>
              </div>
            </div>
                <div class="panel-body mt-3">
                  
                    <div class="d-flex">                    <div class="col-sm-6 mt-2">
                    <input type="hidden" name="plan_name" class="form-controll" id="plan_name" value="{{ session()->get('become_plan') }}">
            <input id="card-holder-name"type="text" class="form-control"  placeholder="Name on card" value="">
                
            </div>
            <!-- <div class="col-sm-10 d-flex mt-2"> -->
                <!-- <input type="text" class="ccFormatMonitor form-control" placeholder="Card Number"> -->

                <!-- <input type="text" id="inputExpDate" class="form-control col-sm-2 mt-2" placeholder="MM / YY" maxlength='7'>

                <input type="password" class="cvv form-control col-sm-2 mt-2 mr-2" placeholder="CVV"> -->

            <!-- </div> -->
                    </div>
                    <?php 
                    $coupons = App\Coupon::all();
                    $user_id = Auth::user()->id;
                    $get_referred_count = App\User::where("referrer_id","=",$user_id)->where("role","=","subscriber")->count();
                    foreach($coupons as $coupon) { 
                      if ($get_referred_count > 0) {
                ?>
                        <div class="form-group row">
                          <label for="plan_names" class="col-md-4 col-sm-offset-1 col-form-label text-md-right text-right">{{ __('Coupon Code') }}
                            </label>
                              <div class="col-md-6">
                                    <input type="text" name="coupon_code" id="coupon_code" class="form-control" value="<?php echo $coupon->coupon_code;?>" readonly>
                              </div>
                        </div>
                <?php } }  ?>
				<!-- Stripe Elements Placeholder -->
				<div id="card-element"></div>

				
				<div class="sign-up-buttons pay-button mt-4 pl-3">
					<button id="card-button" class="btn btn-primary"  data-secret="{{ $intent->client_secret }}">
						Pay Now
					</button>
				</div>
			</div>
<div class="overlay"></div>
               
			<div class="payment-option mt-3">
				<div class="invoice" ><h1 style=" color: #000!important;">Invoice</h1></div>
                <div class="d-flex">
					 <svg style="height:20px;" class="svg-inline--fa fa-file fa-w-12" aria-hidden="true" data-prefix="far" data-icon="file" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg=""><path fill="currentColor" d="M369.9 97.9L286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34zM332.1 128H256V51.9l76.1 76.1zM48 464V48h160v104c0 13.3 10.7 24 24 24h104v288H48z"></path></svg><!-- <i class="far fa-file"></i> -->
					 <h4 class="billing-head detail_name text-black" id="detail_name"><?=$plan_details->plans_name;?></h4></div>
				 <p class="grey-border"></p>
				 <div class="">
					 <p class="pay-prtext text-black">Grab this plan for your best Movies to Watch.</p>
				 </div>
				 <div class="table-responsive">
					 <table class="table white-bg m-0 mt-3">
						 <tbody>
							 <tr class="table-secondary">
								 <td>Amount</td>
								 <td class="detail_price" id="detail_price"><?="$".$plan_details->price;?></td>
                             </tr>
						 </tbody>
					 </table>
				 </div>
			</div>
        </div>
        
         
    </div>
</div>

</div>
<input type="hidden" id="base_url" value="<?php echo URL::to('/');?>">
    <script src="https://js.stripe.com/v3/"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script>
// Initiate an Ajax request on button click
$(document).on("click", "card-button", function(){
    $.get("customers.php", function(data){
        $("body").html(data);
    });       
});
$(document).on({
    ajaxStart: function(){
        $("body").addClass("loading"); 
    },
    ajaxStop: function(){ 
        $("body").removeClass("loading"); 
    }    
});
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.js"></script>
<script>
    
   
        var base_url = $('#base_url').val();
    
       const stripe = Stripe('{{ env('STRIPE_KEY') }}');

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
        $("#card-button").html('Processing ...');
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
              $("#card-button").html('Pay Now');
        } else {
                var plan_data = $("#plan_name").val();
                // alert(plan_data);
                var coupon_code = $("#coupon_code").val();
                var py_id = setupIntent.payment_method;

               $.post(base_url+'/Upgrade_Subscription', {
                 py_id:py_id, coupon_code:coupon_code,plan:plan_data,_token:'<?= csrf_token(); ?>' 
               }, 
                function(data){
                    $('#loader').css('display','block');
                    swal("You have done  Payment !");
                    setTimeout(function() {
                        window.location.replace(base_url+'/login');
                  }, 2000);
               });
        }
    });

</script>
 @include('footer')


@endsection

@extends('layouts.app')
@include('/header')
@section('content')
<?php 

$plan_id = session()->get('planname');

$plan_details = App\Plan::where("plan_id","=",$plan_id)->first();
$plan_price = $plan_details->price;
$discount_percentage = DiscountPercentage();
$discount_price = $discount_percentage;
?>
<div class="row" id="signup-form">
    
     <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1" >
    <div class="overlay payment-loader">
            <div class="panel-heading">
              <div class="row nomargin text-center">
                  
                    <h1 class="panel-title"><?php echo __('Pay Now');?></h1>
              </div>
            </div>         
            <div class="panel-body">
				<div class="form-group row">
					<input type="hidden" name="plan_name" class="form-controll" id="plan_name" value="{{ session()->get('planname') }}">
					<div class="col-md-6"> 
						<input id="card-holder-name" type="text" class="form-control" placeholder="Card Holder Name">
					</div>
				</div>
				<!-- Stripe Elements Placeholder -->
				<div id="card-element"></div>
				<div class="sign-up-buttons pay-button">
					<button id="card-button" class="btn btn-primary"  data-secret="{{ $intent->client_secret }}">
						Pay Now
					</button>
				</div>
			</div>
		
			<div class="payment-option">
				<div class="invoice"><h1>Invoice</h1></div>
					 <svg class="svg-inline--fa fa-file fa-w-12" aria-hidden="true" data-prefix="far" data-icon="file" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg=""><path fill="currentColor" d="M369.9 97.9L286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34zM332.1 128H256V51.9l76.1 76.1zM48 464V48h160v104c0 13.3 10.7 24 24 24h104v288H48z"></path></svg><!-- <i class="far fa-file"></i> -->
					 <h4 class="billing-head detail_name" id="detail_name"><?=$plan_details->plans_name;?></h4>
				 <p class="grey-border"></p>
				 <div class="">
					 <p class="pay-prtext">Grab this plan for your best Movies to Watch.</p>
				 </div>
				 <div class="table-responsive">
                     
                     <?php if (NewSubscriptionCoupon() == 1 ) { ?>
					 <table class="table white-bg m-0 mt-3">
						 <tbody>
							 <tr class="table-secondary">
								 <td>Amount</td>
								 <td class="detail_price" id="detail_price"><?="$".$plan_details->price;?></td>
							 </tr>
							 <tr>
								  <td>Discount Coupon</td>
								  <td class="detail_stripe_coupon"  id="detail_stripe_coupon">
                                      <?php echo NewSubscriptionCouponCode();?> - (50% of 1st Month Subscription) 
                                  </td>
							 </tr>
							 <tr>
								 <td>Discount Amount</td>
								 <td class="detail_stripe_coupon"  id="detail_stripe_coupon"><?="$".$discount_price;?></td>
							 </tr>
							 <tr class="table-secondary">
								 <td>Total</td>
								 <td class="total_price"  id="total_price"><?php echo "$";?><?php echo ($plan_details->price) - ($discount_price);?></td>
							 </tr>
						 </tbody>
					 </table>
                     <?php } else { ?>
                      <table class="table white-bg m-0 mt-3">
						 <tbody>
							 <tr class="table-secondary">
								 <td>Amount</td>
								 <td class="detail_price" id="detail_price"><?="$".$plan_details->price;?></td>
							 </tr>
							 <tr>
								  <td>Discount Coupon</td>
								  <td class="detail_stripe_coupon"  id="detail_stripe_coupon">-</td>
							 </tr>
							 <tr>
								 <td>Discount Amount</td>
								 <td class="detail_stripe_coupon"  id="detail_stripe_coupon">-</td>
							 </tr>
							 <tr class="table-secondary">
								 <td>Total</td>
								 <td class="total_price"  id="total_price"><?php echo "$".$plan_details->price;?></td>
							 </tr>
						 </tbody>
					 </table>
                     <?php } ?>
				 </div>
			</div>
        </div>
        
         
    </div>
</div>

<input type="hidden" id="base_url" value="<?php echo URL::to('/');?>">
    <script src="https://js.stripe.com/v3/"></script>

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
            // Display "error.message" to the user...
        } else {
                var plan_data = $("#plan_name").val();
                // alert(plan_data);return false;
                //alert(plan);
                //alert(setupIntent.payment_method);
               var py_id = setupIntent.payment_method;
              // var plan = $('#plan_name').val();

               $.post(base_url+'/register3', {
                 py_id:py_id, plan:plan_data, _token: '<?= csrf_token(); ?>' 
               }, 
                function(data){
                    $('#loader').css('display','block');
                    swal("You have done  Payment !");
                  
                    setTimeout(function() {
                    //location.reload();
                    window.location.replace(base_url+'/login');
                        
                  }, 2000);
               });

            // The card has been verified successfully...
        }
    });

</script>
 @include('footer')


@endsection

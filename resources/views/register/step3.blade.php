@extends('layouts.app')
@include('/header')
@section('content')
<?php 

// $plan_id = session()->get('plan_id');
$plan_id = session()->get('plan_id');
$payment_type = session()->get('payment_type');

// print_r($plan_id);exit();
$plan_details = App\SubscriptionPlan::where("plan_id","=",$plan_id)->first();
$plan_price = $plan_details->price;
$discount_percentage = DiscountPercentage();
$discount_price = $discount_percentage;
?>
<style>
            #card-element{
                /* color: #fff !important; */
                background-color: white; 
                        }
</style>
<input type="hidden" id="payment_type" name="payment_type" value="<?php echo $payment_type ;?>">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">

<div class="row" id="signup-form">
    
     <div class="col-md-8 offset-2">
    <div class="overlay payment-loader">
            <div class="panel-heading">
              <div class="nomargin text-center mb-3">
                  
                    <h1 class="panel-title"><?php echo __('Pay Now');?></h1>
              </div>
            </div>         
            <div class="panel-body">
				<div class="form-group row">
					<input type="hidden" name="plan_name" class="form-controll" id="plan_name" value="{{ session()->get('plan_id') }}">
					<div class="col-md-6"> 
						<input id="card-holder-name" type="text" class="form-control" placeholder="Card Holder Name">
					</div>
				</div>
				<!-- Stripe Elements Placeholder -->
				<div id="card-element" style="color: #fff;height: 45px;background: #262626;padding: 13px;margin-bottom: 20px;border-radius: 5px;"></div>
				<div class="sign-up-buttons pay-button">
					<button id="card-button" class="btn btn-primary"  data-secret="{{ $intent->client_secret }}">
						Pay Now
					</button>
				</div>
			</div>
		
			<div class="payment-option  text-white" style="margin-top: 50px;">
				<div class="invoice"><h1>Invoice</h1></div>
<!--					  <i class="far fa-file"></i> -->
					 <h4 class="billing-head detail_name" id="detail_name"><?=$plan_details->plans_name;?></h4>
				 <p class="grey-border"></p>
				 <div class="">
					 <p class="pay-prtext">Grab this plan for your best Movies to Watch.</p>
				 </div>
				 <div class="table-responsive invoice-table">
                     
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
							 <tr class="table-secondary">
								 <td>Discount Amount</td>
								 <td class="detail_stripe_coupon"  id="detail_stripe_coupon"><?="$".$discount_price;?></td>
							 </tr>
							 <tr>
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
							 <tr class="table-secondary">
								 <td>Discount Amount</td>
								 <td class="detail_stripe_coupon"  id="detail_stripe_coupon">-</td>
							 </tr>
							 <tr>
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
     <script type="text/javascript" src="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://checkout.stripe.com/checkout.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.js"></script>

<script>
    
   
        /*var base_url = $('#base_url').val();
    
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

	*/
		// Create an instance of the card Element.
		/*var cardElement = elements.create('card', {style: style, classes: elementClasses });


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
              $("#card-button").html('Pay Now');*/
            // Display "error.message" to the user...
        /*} else {
                var plan_data = $("#plan_name").val();*/
                // alert(plan_data);return false;
                //alert(plan);
                //alert(setupIntent.payment_method);
              /* var py_id = setupIntent.payment_method;*/
              // var plan = $('#plan_name').val();
                
               /*$.post(base_url+'/register3', {
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
*/
            // The card has been verified successfully...
    /*    }
    });*/


      /*  else {*/
        
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

				var plan_data = $("#plan_name").val();
                var final_payment = $(".final_payment").val();

				$.ajaxSetup({
           headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });


	$(document).ready(function(){

	$.ajax({
        url: base_url+'/admin/Paymentfailed',
        type: "post",
data: {
               _token: '{{ csrf_token() }}',
               plan_data: plan_data,
               error: error,
               amount: final_payment,


         },        success: function(data){


        }
    });

});
                
          
					//    swal("Your Payment is failed !");
					   if(swal("Your Payment is failed !")){
							// alert('test')
					   }
        } else {
        	
                var plan_data = $("#plan_name").val();
                var coupon_code = $("#coupon_code").val();
                var payment_type = $("#payment_type").val();
                var final_payment = $(".final_payment").val();
            
                var py_id = setupIntent.payment_method;
                
                stripe.createToken(cardElement).then(function(result) {
                 console.log(result.token.id);
                    var stripToken = result.token.id;
                   $.post(base_url+'/register3', {
                     py_id:py_id, stripToken:stripToken, payment_type:payment_type, amount:final_payment,plan:plan_data,_token:'<?= csrf_token(); ?>' 
                   }, 

                   function(data){
                   	$('#loader').css('display','block');
                    swal("You have done  Payment !");
                     $("#card-button").html('Pay Now');
                    //alert(stripToken);
                   // return false;
                    setTimeout(function() {
                        window.location.replace(base_url+'/login');
                  }, 2000);
               });
             });
             }
    });
   

</script>
 @include('footer')


@endsection

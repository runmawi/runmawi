@extends('layouts.app')
@include('/header')
@section('content')


<div class="row" id="signup-form">
    
     <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1" >
    <div class="overlay payment-loader">
            <div class="panel-heading">
              <div class="row nomargin text-center">
                  
                    <h1 class="panel-title"><?php echo __('Pay Now');?></h1>
              </div>
            </div>
               <?php 
                   $become_plan = session()->get('become_plan');
                ?>
            <div class="panel-body">
				<div class="form-group row">
					<input type="hidden" name="plan_name" class="form-controll" id="plan_name" value="{{ $become_plan }}">
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
        </div>
    </div>
</div>

<input type="hidden" id="base_url" value="<?php echo URL::to('/');?>">
    <script src="https://js.stripe.com/v3/"></script>

<script>
        var base_url = $('#base_url').val();
    
        const stripe = Stripe('pk_live_51HSfz8LCDC6DTupicxgwkYesACqSItC9sLeguTE5Vw9iZKFCIkZXJxhXNtegHnci0B3KINLSCYeWKUzbFnby4NtT00iYdraqXT');

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
                var plan_data = $("#plan_name").val();
                // alert(plan_data);return false;
                //alert(plan);
                //alert(setupIntent.payment_method);
                var py_id = setupIntent.payment_method;
                //alert(py_id);
                // var plan = $('#plan_name').val();

                   $.post(base_url+'/saveSubscription', {
                     py_id:py_id, plan:plan_data, _token: '<?= csrf_token(); ?>' 
                   }, 
                function(data){
                    swal("You have done  Payment !");
//                   return false;
                    setTimeout(function() {
                    //location.reload();
                    window.location.replace(base_url+'/login');
                        
                  }, 2000);
               });

            // The card has been verified successfully...
        }
    });

</script>
	</div>
</div>
 @include('footer')
@endsection



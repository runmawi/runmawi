@extends('layouts.app')
@include('/header')

@section('content')


<style>
* {
  box-sizing: border-box;
}

.columns {
  float: left;
  width: 25%;
  padding: 8px;
}

.price {
  list-style-type: none;
  
  margin: 0;
  padding: 0;
  -webkit-transition: 0.3s;
  transition: 0.3s;
}

.price:hover {
  box-shadow: 0 8px 12px 0 rgba(0,0,0,0.2)
}

.price .header {
    background-color: #111;
    color: white;
    font-size: 20px;
}

.price li {
 
  padding: 20px;
  text-align: center;
}

.price .grey {
  background-color: #eee;
  font-size: 20px;
}

.button {
  background-color: #ccb209;
  border: none;
  color: white;
  padding: 10px 25px;
  text-align: center;
  text-decoration: none;
  font-size: 18px;
}
    .plan-block {
        margin-top: 20px;
    }

@media only screen and (max-width: 600px) {
  .columns {
    width: 100%;
  }
}
</style>

<div class="row page-height" id="signup-form" >
    
     <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1" >
    <div class="overlay" style="background: rgb(251 251 251 / 0%);">
            <div class="panel-heading">
              <div class="row nomargin text-center">
                    <h1 class="panel-title">Pay Now</h1>
              </div>
            </div>
         
         
            <div class="panel-body">
                
                   <h2>Our Plans</h2>
    
                    <?php 
                        $plans = App\Plan::all();
                           foreach($plans as $plan) {
                        ?>
                            <div class="columns">
                              <ul class="price">
                                <li class="header"><?php echo $plan->plans_name;?></li>
                                <li class=""><a href="#" class="button"><?php echo "$".$plan->price;?></a></li>
                              </ul>
                            </div>
                       <?php } ?>
                
                
				<div class="form-group row">
                    <div class="col-md-6"> 
                         <select name="plan_name" id="plan_name"  class="form-control" >
                            <?php 
                                $plans = App\Plan::all();
                                foreach($plans as $plan) {
                            ?>
                             <option value="<?php echo $plan->plan_id;?>"><?php echo __($plan->plans_name);?></option>
                           <?php } ?>
                        </select>
                    </div>
					<div class="col-md-6"> 
						<input id="card-holder-name" type="text" class="form-control" placeholder="Card Holder Name">
					</div>
                    
				</div>
			
				<!-- Stripe Elements Placeholder -->
				<div id="card-element"></div>
				<div class="sign-up-buttons pay-button">
					<button id="card-button" class="btn btn-primary"  data-secret="{{ $intent->client_secret }}">
						<?php echo __('Pay Now');?>
					</button>
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



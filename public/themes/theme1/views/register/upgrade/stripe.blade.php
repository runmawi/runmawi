@extends('layouts.app')
@include('/header')
@section('content')


<div class="row" id="signup-form">
    
     <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1" >
    <div class="overlay payment-loader">
            <div class="panel-heading">
                
                <?php 
                  $become_plan = session()->get('become_plan');
                ?>
            <!--
                          <div class="row nomargin text-center">

                                <h1 class="panel-title"><php echo __('Pay Now');?></h1>
                          </div>
            -->
            </div>
                   <form action="<?php echo URL::to('/').'/upgradeSubscription';?>" method="POST" id="payment-form" enctype="multipart/form-data">
                                <div class="panel-body">
                                 <input type="hidden" name="plan_name" id="plan_name" value="<?php echo $plans_details->plan_id;?>">
                                            <?php 
                                                    $coupons = App\Coupon::all();
                                                    $user_id = Auth::user()->id;
                                                    $get_referred_count = App\User::where("referrer_id","=",$user_id)->where("role","=","subscriber")->count();
                                                        foreach($coupons as $coupon) { 
                                                           if ($get_referred_count > 0) {
                                                    ?>
                                         <div class="form-group row">
                                            <label for="plan_name" class="col-md-4 col-sm-offset-1 col-form-label text-md-right text-right">{{ __('Coupon Code') }}</label>
                                                <div class="col-md-6">
                                                   
                                                            <input type="text" name="coupon_code" id="coupon_code" class="form-control" value="<?php echo $coupon->coupon_code;?>" readonly>
                                                       
                                                </div>
                                         </div>
                                      <?php } }  ?>
                                   </div>                    
                                    <div class="form-group row">
                                        <div class="col-sm-offset-5">
                                        <div class="pull-right sign-up-buttons">
                                            <button class="btn btn-primary btn-login" id="delete_button" type="submit" name="create-account">{{ __('Upgrade Subscription') }}</button>
                                        </div>
                                        </div>
                                    </div>
                    </form>
        </div>
         
         	<div class="payment-option">
				<div class="invoice"><h1>Invoice</h1></div>
					 <svg class="svg-inline--fa fa-file fa-w-12" aria-hidden="true" data-prefix="far" data-icon="file" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg=""><path fill="currentColor" d="M369.9 97.9L286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34zM332.1 128H256V51.9l76.1 76.1zM48 464V48h160v104c0 13.3 10.7 24 24 24h104v288H48z"></path></svg><!-- <i class="far fa-file"></i> -->
					 <h4 class="billing-head detail_name" id="detail_name"><?=$plans_details->plans_name;?></h4>
				 <p class="grey-border"></p>
				 <div class="">
					 <p class="pay-prtext">Grab this plan for your best Movies to Watch.</p>
				 </div>
				 <div class="table-responsive">
					 <table class="table white-bg m-0 mt-3">
						 <tbody>
							 <tr class="table-secondary">
								 <td>Amount</td>
								 <td class="detail_price" id="detail_price"><?="$".$plans_details->price;?></td>
                             </tr>
						 </tbody>
					 </table>
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
        }
    });

</script>
	</div>
</div>

<script>
$(function() {
   $("#delete_button").click(function(){
      if (confirm("Click OK to continue?")){
         $('form#payment-form').submit();
      } else {
          alert();
      }
   });
});


</script>
 @include('footer')
@endsection



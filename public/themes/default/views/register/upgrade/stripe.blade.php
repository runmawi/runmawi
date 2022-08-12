@extends('layouts.app')

@php
   include(public_path('themes/default/views/header.php'));
@endphp

@section('content')

<?php
    $discount_percentage = DiscountPercentage();
    $discount_price = $discount_percentage;
    $available_coupon = ReferrerCount(Auth::user()->id)  - GetCouponPurchase(Auth::user()->id)  ?? '0';
?>
<div class="row page-height" id="signup-form">
    
                    <div class="col-md-5 col-sm-5 col-sm-offset-1" >
                        <div class="overlay payment-loader">
                            <div class="panel-heading">
                                <?php 
                                    $become_plan = session()->get('become_plan');
                                ?>
                            </div>  
                               <div class="panel-body">
                                     @if($payment_type == "one_time")
                                   
                                        <input type="hidden" value="{{ $payment_type }}" id="payment_type" name="payment_type">
                                            <div class="form-group row">
                                                <input type="hidden" name="plan_name" class="form-controll" id="plan_name" value="{{ $plan_id }}">
                                                <div class="col-md-6"> 
                                                    <input id="card-holder-name" type="text" class="form-control" placeholder="Card Holder Name">
                                                </div>
                                            </div>
                                            <div id="card-element"></div>
                                            <div class="sign-up-buttons pay-button">
                                                
            <?php 
                $coupons = App\Coupon::all();
                $user_id = Auth::user()->id;
               
                $get_referred_count = App\User::where("referrer_id","=",$user_id)->where("role","=","subscriber")->count();
                foreach($coupons as $coupon) { 
                if ( $available_coupon > 0) {
            ?>
               <input type="checkbox" name="is_apply" class="is_apply"> Want to use coupon ?<br>
                    <div class="form-group row coupon_apply" style="display:none;">
                        <label for="plan_name" class="col-md-4 col-sm-offset-1 col-form-label text-md-right text-right">
                            {{ __('Coupon Code') }}</label>
                        <div class="col-md-6">
                        <input type="text" name="coupon_code" id="coupon_code" class="form-control" value="<?php echo $coupon->coupon_code;?>" readonly>
                        </div>
                    </div>
    <?php } }  ?>
    <button id="card-button" class="btn btn-primary"  data-secret="{{ $intent->client_secret }}">
    Pay Now
    </button>
    </div>
    @endif
                                   
                                   @if( (Auth::user()->payment_type != $payment_type) && $payment_type == "recurring")
                                        <input type="hidden" value="{{ $payment_type }}" id="payment_type" name="payment_type">
                                            <div class="form-group row">
                                                <input type="hidden" name="plan_name" class="form-controll" id="plan_name" value="{{ $plan_id }}">
                                                <div class="col-md-6"> 
                                                    <input id="card-holder-name" type="text" class="form-control" placeholder="Card Holder Name">
                                                </div>
                                            </div>
                                            <div id="card-element"></div>
                                                <div class="sign-up-buttons pay-button">
                                                    <button id="card-button" class="btn btn-primary"  data-secret="{{ $intent->client_secret }}">
                                                        Pay Now
                                                    </button>
                                                </div>
                                     @endif
                                </div>
                            </div>
                        </div>
    
   
                    <div class="col-md-5 col-sm-5" >
                            <div class="payment-option">
                                <div class="invoice"><h1>Invoice</h1></div>
                                     <!-- <svg class="svg-inline--fa fa-file fa-w-12" aria-hidden="true" data-prefix="far" data-icon="file" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg=""><path fill="currentColor" d="M369.9 97.9L286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34zM332.1 128H256V51.9l76.1 76.1zM48 464V48h160v104c0 13.3 10.7 24 24 24h104v288H48z"></path></svg><i class="far fa-file"></i> -->
                                     <h4 class="billing-head detail_name" id="detail_name">
                                         {{ $plans_details->plans_name }}
                                     </h4>
                                 <p class="grey-border"></p>
                                 <div class="">
                                     <p class="pay-prtext">Grab this plan for your best Movies to Watch.</p>
                                 </div>
                                <div class="table-responsive">
                     
                     <?php if ($available_coupon > 0 ) { ?>
					 <table class="table white-bg m-0 mt-3">
						 <tbody>
							 <tr class="table-secondary">
								 <td>Amount</td>
								 <td class="detail_price" id="detail_price"><?="$".$plans_details->price;?></td>
							 </tr>
							 <tr>
								  <td>Discount Coupon</td>
								  <td class="detail_stripe_coupon"  id="detail_stripe_coupon">
                                      <?php echo NewSubscriptionCouponCode();?> - (Coupon Appiled for your  Subscription) 
                                  </td>
							 </tr>
							 <tr>
								 <td>Discount Amount</td>
								 <td class="detail_stripe_coupon"  id="detail_stripe_coupon"><?="$".$discount_price;?></td>
							 </tr>
							 <tr class="table-secondary">
								 <td>Total</td>
								 <td class="total_price"  id="total_price"><?php echo "$";?><?php echo ($plans_details->price) - ($discount_price);?></td>
							 </tr>
						 </tbody>
					 </table>
                      <input type="hidden" class="final_payment" value="<?php echo ($plans_details->price) - ($discount_price);?>">
                     <?php } else { ?>
                          <table class="table white-bg m-0 mt-3">
                             <tbody>
                                 <tr class="table-secondary">
                                     <td>Amount</td>
                                     <td class="detail_price" id="detail_price"><?="$".$plans_details->price;?></td>
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
                                     <td class="total_price"  id="total_price"><?php echo "$".$plans_details->price;?></td>
                                 </tr>
                             </tbody>
                         </table>
                          <input type="hidden" class="final_payment" value="{{ $plans_details->price }}">
                         <?php } ?>
                     </div>
                            </div>
                 </div>
        </div>
                @if( (Auth::user()->payment_type == $payment_type) && $payment_type !="one_time" )               
                    @if($payment_type =="recurring")
                            <form action="<?php echo URL::to('/').'/upgradeSubscription';?>" method="POST" id="payment-form" enctype="multipart/form-data">
                                @csrf
                                    <input type="hidden" name="plan_name" id="plan_name" value="<?php echo $plans_details->plan_id;?>">
                                    <?php $coupons = App\Coupon::all();
                                        $user_id = Auth::user()->id;
                                        $get_referred_count = App\User::where("referrer_id","=",$user_id)->where("role","=","subscriber")->count();
                                        foreach($coupons as $coupon) { 
                                                    if ($get_referred_count > 0) {
                                            ?>
                                                    <div class="form-group row coupon_apply" style="display:none;">
                                                        <label for="plan_name" class="col-md-4 col-sm-offset-1 col-form-label text-md-right text-right">{{ __('Coupon Code') }}</label>
                                                            <div class="col-md-6">
                                                                <input type="text" name="coupon_code" id="coupon_code" class="form-control" value="<?php echo $coupon->coupon_code;?>" readonly>
                                                            </div>
                                                    </div>
                                        <?php } }  ?>
                                    <br>       
                                    <div class="form-group row">
                                        <div class="col-sm-offset-5">
                                            <div class="sign-up-buttons">
                                            <button class="btn btn-primary btn-login" id="delete_button" type="submit" name="create-account">{{ __('Change Plan') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                 <input type="hidden" value="{{ $payment_type }}" id="payment_type" name="payment_type">
                            </form>
                        @endif  
                    @endif
                 
    <input type="hidden" id="base_url" value="<?php echo URL::to('/');?>">
    <script src="https://js.stripe.com/v3/"></script>
    <input type="hidden" id="base_url" value="<?php echo URL::to('/');?>">
        <script src="https://js.stripe.com/v3/"></script>
        <script type="text/javascript" src="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://checkout.stripe.com/checkout.js"></script>

<script>
    var payment_type = $("#payment_type").val(); 
       if (payment_type == "recurring") {
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
          // alert('test');
                var plan_data = $("#plan_name").val();
                var coupon_code = $("#coupon_code").val();
                var final_payment = $(".final_payment").val();
                var payment_type = $("#payment_type").val();
                var py_id = setupIntent.payment_method;
                       $.post(base_url+'/upgadeSubscription', {
                         py_id:py_id, coupon_code:coupon_code, payment_type:payment_type,plan:plan_data,_token:'<?= csrf_token(); ?>' 
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
    } else {
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
            swal("Your Payment is failed !");
              $("#card-button").html('Pay Now');
        } else {
                var plan_data = $("#plan_name").val();
                var coupon_code = $("#coupon_code").val();
                var final_payment = $(".final_payment").val();
                var py_id = setupIntent.payment_method;
                var payment_type = $("#payment_type").val();
                stripe.createToken(cardElement).then(function(result) {
                console.log(result.token.id);
                var stripToken = result.token.id;
               $.post(base_url+'/one-to-one-stripe', {
                 py_id:py_id, stripToken:stripToken, amount:final_payment, coupon_code:coupon_code, payment_type:payment_type,plan:plan_data,_token:'<?= csrf_token(); ?>' 
               }, 
                function(data){
                    $('#loader').css('display','block');
                    swal("You have done  Payment !");
                    //return false;
                    setTimeout(function() {
                        window.location.replace(base_url+'/login');
                  }, 2000);
               });
             });
             }
    });
    }

</script>
	
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

$('.is_apply').on('change', function(){
   this.value = this.checked ? 1 : 0;
     if (this.value == 1){
         $('.coupon_apply').css('display','block');
     }else{
        $('.coupon_apply').css('display','none');
     }
}).change();

</script>

@php
    include(public_path('themes/default/views/footer.blade.php'));
@endphp

@endsection



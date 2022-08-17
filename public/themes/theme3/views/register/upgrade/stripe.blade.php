@extends('layouts.app')
@php
   include(public_path('themes\theme1\views\header.php'));
@endphp
<style>
    .form-control{
        border: 1px solid #fff;
    }
    label{
        color: #fff;
    }
    .price {
       font-family: Chivo;
font-size: 25px;
font-style: normal;
font-weight: 400;
line-height: 43px;
letter-spacing: 0em;
text-align: left;

       
    }
    h4{
        font-size: 30px;
    }
    .hk{
        text-decoration: none;
         font-family: Chivo;
font-size: 25px;
font-style: normal;
font-weight: 400;
line-height: 43px;
letter-spacing: 0em;

    }
    .form-control:focus{
        background-color: transparent;
        color: #fff;
    }
   
</style>
@section('content')

<?php
    $discount_percentage = DiscountPercentage();
    $discount_price = $discount_percentage;
    $available_coupon = ReferrerCount(Auth::user()->id)  - GetCouponPurchase(Auth::user()->id)  ?? '0';
?>
<div class="container">
<div class="row page-height mb-5" style="background: linear-gradient(135.05deg, rgba(136, 136, 136, 0.48) 1.85%, rgba(64, 32, 32, 0.13) 38.53%, rgba(81, 57, 57, 0.12) 97.89%);
    padding: 40px 60px 40px;!important;">
    
                    <div class="col-md-6 col-sm-6 " >
                        <h2>Purchase Details</h2>
                        
                       <div class="mt-5 pt-5"> 
                        <h2>STANDARD PLAN</h2>
                        </div>
                        <div class="mt-3">
                            <h4>FIRST 30 DAYS</h4>
                            <div class="d-flex align-items-baseline">
                                 <p class="mt-2 price text-white" style=" text-decoration: line-through;">$799 </p><span class="hk text-white ml-2">$649</span></div>
                            <h4>AFTER 30 DAYS</h4>
                            <p class="price text-white">$649/month</p>
                             <h4 class="mt-5">Expiry Date</h4>
                        </div>
                       <!-- <div class="overlay payment-loader">
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
                            </div>-->
                        </div>
    
   
                    <div class="col-md-6 col-sm-6" >
                        <h2>Enter your Payment Details</h2>
                        <div class="row p-0 mt-5">
                            <div class="col-sm-6">
                        <label>First Name</label>
                        <input type="text" class="form-control">
                                 <div class="mt-3"> 
                                      <label>Card Name</label>
                                                    <input id="card-holder-name" type="text" class="form-control" placeholder="Card Holder Name">
                                                </div>
                                <div class="mt-3">
                      
                            <div class="form-group">
                                <label for="ccnumber">Card Number</label>
                                <div class="input-group">
                                    <input class="form-control" type="text" placeholder="0000 0000 0000 0000" autocomplete="email">
                                    <div class="input-group-append">
                                        <!--<span class="input-group-text">
                                            <i class="mdi mdi-credit-card"></i>
                                        </span>-->
                                    </div>
                                </div>
                            </div>
                       
                    </div>
                            </div>
                            <div class="col-sm-6">
                                  <label>Last Name</label>
                        <input type="text" class="form-control">
                                <div class="mt-3"> 
                                      <label>Expriy Date</label>
                                                    <input id="card-holder-name" type="text" class="form-control" placeholder="EXP">
                                                </div>
                                <div class="mt-3">
                                    <div class="form-group">
                                <label for="cvv">CVV/CVC</label>
                                <input class="form-control" id="cvv" type="text" placeholder="123">
                            </div>
                                    <div class=" d-flex justify-content-end mt-4">
                                     <button id="card-button" class="btn btn-primary"  data-secret="{{ $intent->client_secret }}">
                                                        Pay Now
                                    </button></div>
                                </div>
                                
                            </div>
                            
                            </div>
                        </div>
    </div>
</div>

    <input type="hidden" id="base_url" value="<?php echo URL::to('/');?>">
    <script src="https://js.stripe.com/v3/"></script>
    <input type="hidden" id="base_url" value="<?php echo URL::to('/');?>">
    
        <script src="{{  URL::to('/assets/js/swalalert.min.js')  }}"> </script>
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
    include(public_path('themes\theme1\views\footer.blade.php'));
@endphp

@endsection



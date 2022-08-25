@extends('layouts.app')

@php
    include(public_path('themes/default/views/header.php'));
@endphp

@section('content')


    <script src="https://www.paypal.com/sdk/js?client-id=Aclkx_Wa7Ld0cli53FhSdeDt1293Vss8nSH6HcSDQGHIBCBo42XyfhPFF380DjS8N0qXO_JnR6Gza5p2&vault=true&intent=subscription" data-sdk-integration-source="button-factory">
    </script>
    <style>
        .round{
            background-color: #8a0303!important;
            color: #fff!important;
            padding: 14px 20px;
        }
        #coupon_code_stripe{
            background-color: #ddd;
        }
    * {
      box-sizing: border-box;
    }
        .collapsed{
            font-size: 18px!important;
        }
    .columns {
      float: left;
      width: 25%;
      padding: 8px;
    }
        .promo{
            font-size: 18px;
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
        /* Style the tab */
    .tab {
      overflow: hidden;    text-align: center;
    margin-bottom: 30px;
    }

    /* Style the buttons inside the tab */
    .tab button {
      background-color: inherit;
      border: none;
      outline: none;
      cursor: pointer;
      padding: 14px 16px;
      transition: 0.3s;
      font-size: 17px;
    }

    /* Change background color of buttons on hover */
    .tab button:hover {
      background-color: #111;
    }

    /* Create an active/current tablink class */
    .tab button.active {
      border-bottom: 2px solid #c3ab06;
    }

    /* Style the tab content */
    .tabcontent {
      display: none;
      padding: 6px 12px;
      border: none;
      border-top: none;
    }
    .buttons-container {
        width: 1% !important;
        margin-left: 22%  !important;
    }  
    .hide-box {
        display: none;
    }
        .plandetails{
            margin-top: 70px !important;
    min-height: 450px !important;
        }
        .btn-secondary{
            background-color: #4895d1 !important;
            border: none !important;
        }

        
          input[type=email], input[type=number], input[type=password], input[type=phone], input[type=text] {
    display: block;
    height: 54px;
   
    font-size: 1em;
    color: #000!important;
    background-color: #fff!important;
    border: 1px solid #000;
    border-radius: 2px;
    padding: 0 0.5em;
    -webkit-transition: .2s border ease-in-out;
    transition: .2s border ease-in-out;
}
    /*.sign-user_card {
        background: none !important;
    }*/
#ck-button {
    margin:4px;
/*    background-color:#EFEFEF;*/
    border-radius:4px;
/*    border:1px solid #D0D0D0;*/
    overflow:auto;
    float:left;
}
#ck-button label {
    float:left;
    width:4.0em;
}
    .min{
        min-height: 100vh;
    }
    .sd{
       
  color: #8A0303!important;
        font-weight: 500;
        text-decoration: underline!important;

    }
    p{
        font-size: 14px;
    }
#ck-button label span {
    text-align:center;
    display:block;
    color: #fff;
    background-color: #3daae0;
    border: 1px solid #3daae0;
    padding: 0;
}
#ck-button label input {
    position:absolute;
/*    top:-20px;*/
}

#ck-button input:checked + span {
    background-color:#3daae0;
    color:#fff;
}
    
.mobile-div {
	margin-left: -2%;
	margin-top: 1%;
}
.modal-header {
    padding: 0px 15px;
    border-bottom: 1px solid #e5e5e5 !important;
    min-height: 16.42857143px;
}
#otp {
    padding-left: 15px;
    letter-spacing: 42px;
    border: 0;
   /* background-image: linear-gradient(to right, black 60%, rgb(120, 120, 120) 0%);*/
    background-position: bottom;
    background-size: 50px 1px;
    background-repeat: repeat-x;
    background-position-x: 80px;
}
    #otp:focus {
        border: none;
    }
    /*.sign-up-buttons{
        margin-left: 40% !important;
    }*/.verify-buttons{
        margin-left: 36%;
    }
    .container{
        margin-top: 70px;
    }
    .panel-heading {
    margin-bottom: 1rem;
}
    #tab_nav {
  position: relative;
  overflow: hidden;
  margin: 0 auto;
  margin-top: 25px;
  word-spacing: -5px;
  width: 700px;
  height: 300px;
  margin-bottom: 25px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}

#tab_nav ul {
  margin: 0 auto;
  padding: 0;
  display: inline-block;
}

#tab_nav li {
  background: #222;
  color: white;
  word-spacing: 0;
  width: 134.7px;
  list-style: none;
  display: inline-block;
  margin: 0 auto;
  padding: 20px;
  border-right: 1px solid rgba(0, 0, 0, 0.1);
  font-family: Helvetica, Arial, sans-serif;
  letter-spacing: 3px;
  cursor: pointer;
}

#tab_nav li:first-of-type {
  box-shadow: inset 0 -50px 50px -50px rgba(0, 0, 0, 0.2), 
    inset -1px 0 0 rgba(0, 0, 0, .5);
}

#tab_nav li:last-of-type {
  box-shadow: inset 0 -50px 50px -50px rgba(0, 0, 0, 0.2), 
    inset 1px 0 0 rgba(250, 255, 255, .1);
}

#tab_nav li:hover {
  background: #191919;
}

#tab_nav li:active {
  background: rgba(200,170,118, .5);
}

#tab_nav li span {
  float: right;
  font-weight: bold;
  display: none;
}
    .dgk{
        color: #000!important;
        padding: 30px 24px;
        
        
    }
    .dgk h4{
        font-weight: 600;
         color: #000!important;
    }
        
#tab_nav li:hover span {
  display: block;
}

#tab_nav div {
  position: relative;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: white;
  padding: 25px;
  font-family: Helvetica, Arial, sans-serif;
  word-spacing: 3px;
}
    .dgk h6{
        font-size: 14px;
    }
#tab_nav li div {
  display: none;
  position: absolute;
  top: 60px;
  left: 0;
  width: 100%;
  height: 100%;
  background: white;
  padding: 25px;
  font-family: calibri;
  letter-spacing: 1px;
  z-index: 10;
}

#tab_nav div h1 {
  margin: 0 auto;
  font-family: Helvetica, Arial, sans-serif;
  font-size: 25px;
}

#tab_nav li:focus {
  outline: none;
  background: white;
  color: black;
  box-shadow: 0 -5px 0 white;
}

#tab_nav li:focus div {
  display: block;
}
   /* .form-control {
    background-color: var(--iq-body-text) !important;
    border: 1px solid transparent;
    height: 46px;
    position: relative;
    color: var(--iq-body-bg) !important;
    font-size: 16px;
    width: 100%;
    -webkit-border-radius: 6px;
    border-radius: 6px;
}
    a {
    color: var(--iq-body-text);
    text-decoration: none;
}*/
.phselect{
    width: 100px !important;
    height: 45px !important;
    background: transparent !important;
    color: var(--iq-white) !important;
}

    .custom-file-upload {
    border: 1px solid #ccc;
    display: inline-block;
    padding: 6px 12px;
    cursor: pointer;
}
/*input[type="file"] {
    display: none;
}*/
    .catag {
    padding-right: 150px !important;
}
i.fa.fa-google-plus {
    padding: 10px !important;
}
    option {
    background: #474644 !important;
}
    .reveal{
        margin-left: -92px !important;
    height: 45px !important;
    background: transparent !important;
    color: #fff !important;
    }
    .error {
    color: brown;
    font-family: 'remixicon';
    }
    .small-heading {
  font-size: 14px;
  margin-bottom: 20px;
  }
.medium-heading {
  font-size: 30px;
  font-weight: 700;
}
.container1{
  background-color: #000;
  border-radius: 25px;
  padding: 20px;
  color: #fff;  
}
       
    .vl {
  border-left: 2px solid #000;
  height: 60px;
}
        .btn1{
            background: rgba(138, 3, 3, 1)!important;
            border:none;
            border-radius: 30px;
            padding: 15px;
        }
    label{
        color: #fff!important;
        font-weight: 600;
    }
    .buttonClass {
  font-size:15px;
  
  width:200px;
  height:57px;
  border-width:0px;
  ontolor:#fff;
  border-color:#18ab29;
  font-weight:bold;
  margin-top: 20px;
  border-top-left-radius:10px;
  border-top-right-radius:10px;
  border-bottom-left-radius:10px;
  border-bottom-right-radius:10px;
  background:rgba(138, 3, 3, 1)!important;
        color: #fff;
}

.buttonClass:hover {
  background: rgba(124, 20, 20, 0.8)!important;
}
    .dg{
        padding: 10px;
        color: #000!important;
        background-color: #fff;
        height: 140px;
        width: 330px;
       
    }

    .actives {
        border:5px solid rgba(138, 3, 3, 1)!important;
    }
   
        .dg:hover{
            padding: 10px;
            color: #000!important;
            border:  {{ '5px solid'.button_bg_color() .'!important' }} ;
        }
    .cont{
        background-color: #232c30;
    padding: 36px 47px 70px;
    margin-bottom: 35px;
    }
    #card-button{
        background-color:  {{ button_bg_color() .'!important' }} ;
    }
    
</style>

<style>
    #card-element {
      height: 50px;
      background: #f4f6f7;
      padding: 10px;
    }
    </style>

<script>
  $( function() {
    $( "#tabs" ).tabs();
    $("tabs li:first").addClass("active");
  });
    
</script>

@php
    $SubscriptionPlan = App\SubscriptionPlan::first();
    $signup_payment_content = App\SiteTheme::pluck('signup_payment_content')->first();
@endphp

<section class="flick">
    <div class="container">
        <div align="center"></div>
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-6 p-0">
                <div class="flick1">
                 <div class="small-heading text-white">Step 2 of<span class="ml-2">2</span></div>
                     <p class="text-white" style="font-size: 16px;">Welcome {{ Auth::user()->username ? Auth::user()->username  : " "  }}, </p>
                     <div class="medium-heading text-white pb-3">Save by Paying for the Year Upfront!</div>

                    {{-- <p class="text-white">You will not be charged until the end of your free trial. Cancel anytime.</p>

                    <div class="col-md-6 p-0">
                        <h5> Payment Method</h5>
                        <div class="d-flex align-items-center">
                            <input type="checkbox" id="" name="" value="" checked>
                            <label class="mt-2 ml-2" for="" > Stripe</label><br />
                        </div>
                    </div>       --}}

                <div class="row">
                    <div class="col-md-12">
                        <div class="row align-items-center m-0">
                         @foreach($plans_data as $key => $plan) 
                             @php
                                  $plan_name = $plan[0]->plans_name;
                             @endphp

                             <div style="" class="col-md-6 plan_details"  data-plan-id={{ 'active'.$plan[0]->id  }}  data-plan-price={{ $plan[0]->price }} data-plan_id={{  $plan[0]->plan_id  }} data-payment-type={{ $plan[0]->payment_type }} onclick="plan_details(this)">
                                <div class="row dg align-items-center mb-4" id={{ 'active'.$plan[0]->id  }}>
                                    <div class="col-md-6">
                                        <h4 class="text-black font-weight-bold"> {{ $plan[0]->plans_name  }} </h4>
                                        <p>{{ $plan[0]->plans_name  }} Membership</p>
                                    </div>
                                    
                                    <div class="col-md-6" style="border-left: 1px solid #000; padding: 15px;">
                                        <h4 class="text-black">{{ "$".$plan[0]->price }}</h4>
                                        <p>Billed as {{ "$".$plan[0]->price }}</p>
                                    </div>
                                </div>
                                 <div class="d-flex justify-content-between align-items-center " > 
                                     <div class="bgk">
                                       
                                     </div>
                                     
                                 </div>
                             </div>
                          @endforeach

                         
                        </div>
                    </div>

                    <div class="col-md-12 mt-5 p-0">
                        <div class="cont">
      
                         <div class="d-flex justify-content-between align-items-center">
                             <div>
                                 <h3>Payment</h3>
                             </div>

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

                    <input id="card-holder-name" type="text" class="form-control" placeholder="Card Holder Name">

                     <!-- Stripe Elements Placeholder -->
                     <label for="ccnum"> Card Number</label>
                     <div id="card-element" style=""></div>

                    @if( get_coupon_code() == 1)
                                    <!-- Add Promotion Code -->
                        <div class="mt-3">
                            <label for="fname"  style="float: right; " data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"  class="promo"> Add Promotion Code </label>
                            <div class="collapse" id="collapseExample">
                                <div class="row p-0">
                                    <div class="col-lg-6 p-0" >
                                        <input id="coupon_code_stripe" type="text" class="form-control" placeholder="Add Promotion Code" >
                                        <input id="final_coupon_code_stripe" name="final_coupon_code_stripe" type="hidden" >
                                         </div>
                                    <div class="col-lg-6 p-0"><a type="button" id="couple_apply" class="btn round">Apply</a></div>
                                    <span id="coupon_message"></span>

                                                {{-- Coupon Code from backend(admin) --}}
                                    @if( NewSubscriptionCouponCode() != '0' )
                                        <span id="">  {{ "Recommend a Coupon Code for you - " . NewSubscriptionCouponCode() }} </span>
                                    @endif

                                </div>
                            </div>
                        </div>
                    @endif

                </div>
                
                <h4>Summary</h4>

                <div class="bg-white mt-4 dgk">
                     <h4> Due today: <span class='plan_price'> {{ $SubscriptionPlan ? '$'.$SubscriptionPlan->price : '$0:0' }} </span> </h4>
                     <hr/>
                     {{-- <h6 class="text-black text-center font-weight-bold">You will be charged $56.99 for an annual membership on 05/18/2022. Cancel anytime.</h6> --}}
                    <p class="text-center mt-3">All state sales taxes apply</p>
                </div>

                 <p class="text-white mt-3 dp">
                         {{ $signup_payment_content ? $signup_payment_content : " " }}
                 </p>
            </div>

                    <button id="card-button" class="btn1  btn-lg btn-block font-weight-bold text-white mt-3 processing_alert"   data-secret="{{ session()->get('intent_stripe_key')  }}">
                        Pay Now
                    </button>
                    
                    {{-- <button type="button" class="btn1  btn-lg btn-block font-weight-bold text-white mt-3">Start Your Free Trial</button> --}}
                    <input type="hidden" id="payment_image" value="<?php echo URL::to('/').'/public/Thumbnai_images';?>">

            </div>           
    </div>
    </div>
    </div>
        </div>
</section>

<input type="hidden" id="base_url" value="<?php echo URL::to('/');?>">
<input type="hidden" id="stripe_coupon_code" value="<?php echo NewSubscriptionCouponCode();?>">
<input type="hidden" value="<?php echo DiscountPercentage();?>" id="discount_percentage" class="discount_percentage">
<input type="hidden" value="<?php echo NewSubscriptionCoupon();?>" id="discount_status" class="discount_status">


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

<script type="text/javascript">

    jQuery(document).ready(function($){
        // Add New Category
        $('#submit-new-cat').click(function(){
            $('#payment-form').submit();
        });
    });
</script>

{{-- Stripe Payment --}}
    <input type="hidden"   id="plan_name"    name="plan_name" value = {{  $SubscriptionPlan ? $SubscriptionPlan->plan_id : " " }}  >
    <input type="hidden"   id="payment_type" name="payment_type" value={{ $SubscriptionPlan ? $SubscriptionPlan->payment_type : " " }} >
    <input type="hidden" id="base_url" value="<?php echo URL::to('/');?>">

    <script src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://checkout.stripe.com/checkout.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <script>
    function plan_details(ele){
        var plans_id          = $(ele).attr('data-plan_id');
        var plan_payment_type = $(ele).attr('data-payment-type');
        var plan_price  = $(ele).attr('data-plan-price');
        var plan_id_class = $(ele).attr('data-plan-id');
        
        $('#payment_type').replaceWith('<input type="hidden" name="payment_type" id="payment_type" value="'+ plan_payment_type+'">');
        $('#plan_name').replaceWith('<input type="hidden" name="plan_name" id="plan_name" value="'+ plans_id +'">');
        $('.plan_price').empty(plan_price);
        $('.plan_price').append('$'+plan_price);

        $('.dg' ).removeClass('actives');
        $('#'+plan_id_class ).addClass('actives');
      
    }    
    var base_url = $('#base_url').val();
    const stripe = Stripe('{{ env('STRIPE_KEY') }}');
    const elements = stripe.elements();

    var style = {
        base: {
            iconColor: '#19337c',
            color: '#141414',
            fontSize: '16px',
            fontFamily: '"Open Sans", sans-serif',
            padding: '13px',
            fontSmoothing: 'antialiased',
            '::placeholder': {
            color: '#80828c',
            },
        },
        CardNumberField : {
            background: '#141414', 
            padding: '10px',
            borderRadius: '4px', 
            transform: 'none',
        },
        invalid: {
            color: '#fc0000',
            ':focus': {
            color: '#fc0000',
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
        },       
         success: function(data){
        } });
    });

	
    if( swal({
        title: "Payment Failed!",
        text: "Your Payment is failed",
        type: "warning"
        }).then(function() {
            window.location = base_url+'/home';
        })
    ){ }
    } else {
        	
            var plan_data = $("#plan_name").val();
            var final_coupon_code_stripe = $("#final_coupon_code_stripe").val();
            var payment_type = $("#payment_type").val();
            var final_payment = $(".final_payment").val();
            var py_id = setupIntent.payment_method;
                
            console.log(plan_data);


            stripe.createToken(cardElement).then(function(result) {
                 console.log(result.token.id);

            var stripToken = result.token.id;
            $.get(base_url+'/become_subscriber', {
                     py_id:py_id, 
                     stripToken:stripToken, 
                     payment_type:payment_type, 
                     amount:final_payment,
                     plan:plan_data,
                     coupon_code:final_coupon_code_stripe,
                     _token:'<?= csrf_token(); ?>' 
                   }, 

                function(data){
                        $('#loader').css('display','block');
                        swal({
                            title: "Subscription Purchased Successfully!",
                            text: "Your Payment done Successfully!",
                            icon: payment_images+'/Successful_Payment.gif',
                            buttons: false,      
                            closeOnClickOutside: false,
                        });
                            $("#card-button").html('Pay Now');
                        setTimeout(function() {
                            window.location.replace(base_url+'/login');
                    }, 2000);
               });
            });
        }
    });

</script>

<script>

    window.onload = function(){ 
        $('#active2' ).addClass('actives');
    }

            // Processing Alert 
    var payment_images = $('#payment_image').val();

    $(".processing_alert").click(function(){

        swal({
        title: "Processing Payment!",
        text: "Please wait untill the proccessing completed!",
        icon: payment_images+'/processing_payment.gif',
        buttons: false,      
        closeOnClickOutside: false,
        });

    });

        // Couple validation 
    $("#couple_apply").click(function(){

        var coupon_code = $("#coupon_code_stripe").val();

        $.ajax({
            url: "{{ route('retrieve_stripe_coupon') }}",
            type: "get",
            data: {
                    _token: '{{ csrf_token() }}',
                    coupon_code : coupon_code ,
                },       
                success: function(data){
                    console.log(data.message);
                    $("#coupon_message").text(data.message);
                    $("#coupon_message").css('color', data.color );
                    
                    if(data.status == 'true'){
                        var final_coupon_code = $('#coupon_code_stripe').val();
                        $('#final_coupon_code_stripe').replaceWith('<input type="hidden" name="final_coupon_code_stripe" id="final_coupon_code_stripe" value="'+ final_coupon_code +'">');
                    }
                } 
            });
        });
        
</script>

@php
    include(public_path('themes/default/views/footer.blade.php'));
@endphp

@endsection 
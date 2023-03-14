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

    .promo{
        font-size: 18px;
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
       line-height: 0;
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
        margin: 7px;
        border:5px solid #ddd;
        
       
    }

    .actives {
        border:5px solid #a5a093;
        padding: 10px!important;
    }
   
        .dg:hover{
          transition: 0.5s;
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

    html {
        scroll-behavior: smooth;
    }
    </style>

<script>
  $( function() {
    $( "#tabs" ).tabs();
    $("tabs li:first").addClass("active");
  });
    
</script>
@if (Session::has('message'))
        <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
    @endif

    @if(count($errors) > 0)
        @foreach( $errors->all() as $message )
            <div class="alert alert-danger display-hide" id="successMessage" >
                <button id="successMessage" class="close" data-close="alert"></button>
                <span>{{ $message }}</span>
            </div>
        @endforeach
    @endif
@php
    $SubscriptionPlan = App\SubscriptionPlan::first();
    $AdminLifeTimeSubscription = App\AdminLifeTimeSubscription::first();

    $signup_payment_content = App\SiteTheme::pluck('signup_payment_content')->first();
    $signup_step2_title = App\SiteTheme::pluck('signup_step2_title')->first();

    $Stripe_payment_settings = App\PaymentSetting::where('payment_type','Stripe')->first();
    $PayPal_payment_settings = App\PaymentSetting::where('payment_type','PayPal')->first();
    $Paystack_payment_settings = App\PaymentSetting::where('payment_type','Paystack')->first();
    $Razorpay_payment_settings = App\PaymentSetting::where('payment_type','Razorpay')->first();

                // lable
    $stripe_lable = App\PaymentSetting::where('payment_type','Stripe')->pluck('stripe_lable')->first() ? App\PaymentSetting::where('payment_type','Stripe')->pluck('stripe_lable')->first()  : "Stripe";
    $paypal_lable = App\PaymentSetting::where('payment_type','PayPal')->pluck('paypal_lable')->first() ? App\PaymentSetting::where('payment_type','PayPal')->pluck('paypal_lable')->first() : "PayPal";
    $paystack_lable = App\PaymentSetting::where('payment_type','Paystack')->pluck('paystack_lable')->first() ? App\PaymentSetting::where('payment_type','Paystack')->pluck('paystack_lable')->first() : "paystack";
@endphp

<section class="flick">
    <div class="container">
        <div align="center">
                       
               </div>
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-6">
                <div class="flick1">
                 <div class="small-heading text-white">Step 2 of  <span class="ml-2">2</span></div>
                     <p class="text-white">Hello, {{ $user_mail }}</p>
                     <div class="medium-heading text-white"> {{  $signup_step2_title }} </div>
                     {{-- <p class="text-white">You will not be charged until the end of your free trial. Cancel anytime.</p> --}}
                    <div class="col-md-12 p-0 mt-2">

                        <!-- <h5> Payment Method</h5> -->



                            {{-- @if(!empty($PayPal_payment_settings) && $PayPal_payment_settings->paypal_status == 1)
                                <input type="checkbox" id="Paypal_lable" name="payment_lable" value="Paypal_lable" >
                                <label class=" ml-2 " for="" ><p> {{ $paypal_lable }} </p></label><br />&nbsp;&nbsp;
                            @endif --}}


                            @if(!empty($Stripe_payment_settings) && $Stripe_payment_settings->stripe_status == 1)
                                <div class=" align-items-center">
                                    <input type="radio" id="stripe_radio_button" class="payment_gateway" name="payment_gateway" value="stripe" >
                                    <label class=" ml-2"> <p>{{ $stripe_lable }} </p></label> 
                                </div>
                            @endif

                            @if( !empty($Paystack_payment_settings) && $Paystack_payment_settings->status == 1 )
                                <div class="align-items-center">
                                    <input type="radio" id="paystack_radio_button" class="payment_gateway" name="payment_gateway" value="paystack">
                                    <label class="ml-2" ><p> {{ $paystack_lable }} </p></label> 
                                </div>
                            @endif

                            @if( !empty($PayPal_payment_settings) && $PayPal_payment_settings->paypal_status == 1 )
                                <div class=" align-items-center">
                                    <input type="radio" id="paystack_radio_button" class="payment_gateway" name="payment_gateway" value="paypal">
                                    <label class="mt-2 ml-2" > <p>{{ $paypal_lable }} </p></label>
                                </div>
                            @endif
                            

          </div>      

            <div class="row">
                <div class="col-md-12">
                    <div class="data-plans row align-items-center m-0 p-0">
                        @foreach( $plans_data_signup_checkout as $key => $plan ) 
                            @php
                                $plan_name = $plan->plans_name;
                            @endphp

                            <div style="" class="col-md-6 plan_details p-0"  data-plan-id={{ 'active'.$plan->id  }}  data-plan-price={{ $plan->price }} data-plan_id={{  $plan->plan_id  }} data-payment-type={{ $plan->payment_type }} onclick="plan_details(this)">
                                <a href="#payment_card_scroll" >
                                    <div class="row dg align-items-center mb-4" id={{ 'active'.$plan->id  }}>
                                        <div class="col-md-7 p-0">
                                            <h4 class="text-black font-weight-bold"> {{ $plan->plans_name  }} </h4>
                                            <p>{{ $plan->plans_name  }} Membership</p>
                                        </div>
                                        <div class="vl "></div>
                                        <div class="col-md-4 p-2" >
                                            <h4 class="text-black">{{ "$".$plan->price }}</h4>
                                            <p>Billed as {{ "$".$plan->price }}</p>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center " > 
                                        <div class="bgk"></div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>

                                                {{-- Life Time Subscription --}}

                    @if( $AdminLifeTimeSubscription != null && $AdminLifeTimeSubscription->status == 1 )
                        <div class="LifeTimeSubscription_div row align-items-center m-0 p-0" id="LifeTimeSubscription_div" data-subscription-price={{ $AdminLifeTimeSubscription->price }} onclick="LifeTimeSubscription(this)" >
                            <div style="" class="col-md-6 plan_details p-0 "  >
                                <div class="row dg align-items-center mb-4" >
                                    <div class="col-md-7 p-0">
                                        <h4 class="text-black font-weight-bold"> {{ $AdminLifeTimeSubscription  ? $AdminLifeTimeSubscription->name : " " }} </h4>
                                        <p> {{ $AdminLifeTimeSubscription  ? $AdminLifeTimeSubscription->name : " " . " Membership " }} </p>
                                    </div>
                                    <div class="vl "></div>
                                    <div class="col-md-4 p-2" >
                                        <h4 class="text-black"> {{ currency_symbol().$AdminLifeTimeSubscription->price }}  </h4>
                                        <p class="mb-0">Billed as {{ $AdminLifeTimeSubscription  ? currency_symbol().$AdminLifeTimeSubscription->price : " "  }} </p>
                                        <div class="text-center">
                                            <button  type="submit" class="btn1 btn-lg  text-white " style="font-size:10px !important ; padding:5px 20px ;" >Pay Now</button>
                                       </div>
                                    </div>
                                </div>
                                                {{-- Stripe publishable Key --}}
                                <input type="hidden" id="Stripe_publishable_key" name="Stripe_publishable_key" value="{{ env('STRIPE_KEY')}}">

                                <div class="d-flex justify-content-between align-items-center " > 
                                    <div class="bgk"></div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                    
                    <!-- Stripe Payment -->
                    <div class="col-md-12 mt-5 Stripe_Payment" id="payment_card_scroll" >
                        <div class="cont stripe_payment">
      
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
                            <div class="collapse show" id="collapseExample">
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
                    <h4> Due today: <span class='plan_price'> {{ $SubscriptionPlan ? currency_symbol().$SubscriptionPlan->price : currency_symbol().'0:0' }} </span> </h4>
                    
                    @if( get_coupon_code() == 1)
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <div class="stripe_payment">
                                <p> Amount Deducted for Promotion Code   </p>
                                <p> Payable Amount    </p>
                            </div>
                            
                            <div class="stripe_payment">
                                <p id="promo_code_amt" > {{  '$0'  }} </p>
                                <p id="coupon_amt_deduction"> {{ $SubscriptionPlan ? currency_symbol().$SubscriptionPlan->price : '$0:0'  }} </p>
                            </div>
                        </div>
                    @endif

                     {{-- <div class="d-flex justify-content-between align-items-center mt-2">
                         <div>
                             <p>Annual Membership</p>
                         </div>
                         <div>
                             <p > {{ $SubscriptionPlan ? '$'.$SubscriptionPlan->price * 12 : '$0:0' }} </p>
                         </div>
                     </div> --}}

                     <hr/>
                     {{-- <h6 class="text-black text-center font-weight-bold">You will be charged $56.99 for an annual membership on 05/18/2022. Cancel anytime.</h6> --}}
                     <p class="text-center mt-3">All state sales taxes apply</p>
                 </div>

                 <p class="text-white mt-3 dp">
                         {{ $signup_payment_content ? $signup_payment_content : "By Clicking on Paynow & Start" }}
                 </p>
             <!-- </div> -->

                    <div class="col-md-12 stripe_payment">
                        <button id="card-button" class="btn1  btn-lg btn-block font-weight-bold text-white mt-3 processing_alert"   data-secret="{{ session()->get('intent_stripe_key')  }}">
                            Pay Now
                        </button>
                    </div>
                  
                    <div class="col-md-12 paystack_payment">
                        <button  type="submit" class="btn1 btn-lg btn-block font-weight-bold text-white mt-3 paystack_button processing_alert" >
                            Pay Now
                        </button>
                    </div>
                    
                    <input type="hidden" id="payment_image" value="<?php echo URL::to('/').'/public/Thumbnai_images';?>">
                    <input type="hidden" id="currency_symbol" value="{{ currency_symbol() }}">
            </div>           

            <div class="col-md-12 mt-5 PaypalPayment" id="Paypal_Payment">
                    
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

                    <div id="paypal-button-container-P-6XA79361YH9914942MMPN3BQ"></div>

                </div> 

    
    </div>
    </div>
    </div>
        </div>
        
</section>
    
<?php 
    $ref = Request::get('ref');
    $coupon = Request::get('coupon');
   
?>


        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

<script type="text/javascript">

    jQuery(document).ready(function($){
        // Add New Category
        $('#submit-new-cat').click(function(){
            $('#payment-form').submit();
        });
    });
</script>

   
         <div class="form-group row">
                <div class="col-md-12 text-center">
                    <p class="mt-3 text-white">OR</p>
				      <div class="mt-4 sign-up-buttons">
                   <a type="button" href="<?php echo URL::to('/').'/registerUser';?>" class="btn btn-secondary">
                            <?php echo __('Skip');?>
                        </a>
                    </div>
				</div>
         </div>
          
        </form>         
        </div>
         </div>
    </div>
</div>
    </div>
</div>
<input type="hidden" id="base_url" value="<?php echo URL::to('/');?>">
<input type="hidden" id="stripe_coupon_code" value="<?php echo NewSubscriptionCouponCode();?>">
<input type="hidden" value="<?php echo DiscountPercentage();?>" id="discount_percentage" class="discount_percentage">
<input type="hidden" value="<?php echo NewSubscriptionCoupon();?>" id="discount_status" class="discount_status">

<script>
var base_url = $('#base_url').val();
    
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
    // Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click(); 
</script>

<script>
    $(".plans_name_choose").click(function(){
        // alert($(this).val());
        $("#modal_plan_name").val($(this).val());

    });
</script>

<script>
    $("input[name='plan_name']").change(function(){
       var pid = $(this).val();
       var attr_price = $(this).attr('data-price');
       var discount_status = $("#discount_status").val();
      var plan_name_data =  $(this).attr('data-name');
        
       $('#detail_name').html(plan_name_data);
       $('#detail_price').html(attr_price+" USD");
        
        if ( discount_status == 1) {
            
            $('.coupon_enabled').css("display","block");
            
            var stripe_coupon_code = $("#stripe_coupon_code").val();
           
               var discount = $("#discount_percentage").val();
               var discount_percentage = (attr_price/100)*discount;
               var total_price = (attr_price - discount_percentage);
                $('#detail_stripe_coupon').html(stripe_coupon_code);
                $('#coupon_percentage').html(discount_percentage+" USD");
                $('#total_price').html(total_price+" USD");
        }
       $('.hide-box').css("display","block");
       $('.hide-box').css("  transition-delay","2s");
    
            
    });
    
</script>

<script>
    $("input[name='plan_name']").change(function(){
       var pid = $(this).val();
       var attr_price = $(this).attr('data-price');
       var discount_status = $("#discount_status").val();
      var plan_name_data =  $(this).attr('data-name');
        
       $('#detail_name').html(plan_name_data);
       $('#detail_price').html(attr_price+" USD");
        
        if ( discount_status == 1) {
            
            $('.coupon_enabled').css("display","block");
            
            var stripe_coupon_code = $("#stripe_coupon_code").val();
           
               var discount = $("#discount_percentage").val();
               var discount_percentage = (attr_price/100)*discount;
               var total_price = (attr_price - discount_percentage);
                $('#detail_stripe_coupon').html(stripe_coupon_code);
                $('#coupon_percentage').html(discount_percentage+" USD");
                $('#total_price').html(total_price+" USD");
        }
       $('.hide-box').css("display","block");
       $('.hide-box').css("  transition-delay","2s");
    
            
    });
    
</script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js'></script>

        <script>
            $(function () {
                $("#chkPassport").click(function () {
                    if ($(this).is(":checked")) {
                        $("#dvPassport").show();
                        $("#AddPassport").hide();
                    } else {
                        $("#dvPassport").hide();
                        $("#AddPassport").show();
                    }
                });
            });
        </script>  
<script>
// Add active class to the current button (highlight it)
var header = document.getElementById("myDIV");
var btns = header.getElementsByClassName("btn");
for (var i = 0; i < btns.length; i++) {
  btns[i].addEventListener("click", function() {
  var current = document.getElementsByClassName("active");
  current[0].className = current[0].className.replace(" active", "");
  this.className += " active";
  });
}
</script>
      <script>
            $(function () {
                $("#chkPassports").click(function () {
                    if ($(this).is(":checked")) {
                        $("#dvPassports").show();
                        $("#AddPassports").hide();
                    } else {
                        $("#dvPassports").hide();
                        $("#AddPassports").show();
                    }
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
            let currency_symbols  =  document.getElementById("currency_symbol").value ;

            // alert(plans_id);
            $('#payment_type').replaceWith('<input type="hidden" name="payment_type" id="payment_type" value="'+ plan_payment_type+'">');
            $('#plan_name').replaceWith('<input type="hidden" name="plan_name" id="plan_name" value="'+ plans_id +'">');
            $('.plan_price').empty(plan_price);
            $('.plan_price').append(currency_symbols+plan_price);

            $('#coupon_amt_deduction').empty(plan_price);
            $('#coupon_amt_deduction').append( currency_symbols+plan_price );

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
            window.location = base_url+'/register2';
        })
    ){ }
    } else {
        	
            var plan_data = $("#plan_name").val();
            var coupon_code = $("#coupon_code").val();
            var payment_type = $("#payment_type").val();
            var final_payment = $(".final_payment").val();
            var py_id = setupIntent.payment_method;
            var final_coupon_code_stripe = $("#final_coupon_code_stripe").val();

            console.log(plan_data);
            
            stripe.createToken(cardElement).then(function(result) {
                 console.log(result.token.id);
            var stripToken = result.token.id;
            $.post(base_url+'/register3', {
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
        $('#active1' ).addClass('actives');
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
        var plan_price  =  $(".plan_price").text();

        $.ajax({
            url: "{{ route('retrieve_stripe_coupon') }}",
            type: "get",
            data: {
                    _token: '{{ csrf_token() }}',
                    coupon_code : coupon_code ,
                    plan_price  : plan_price ,
                },       
                success: function(data){
                    console.log(data.message);
                    $("#coupon_message").text(data.message);
                    $("#coupon_amt_deduction").text(data.discount_amt);
                    $("#promo_code_amt").text(data.promo_code_amt);
                    $("#coupon_message").css('color', data.color );
                    
                    if(data.status == 'true'){
                        var final_coupon_code = $('#coupon_code_stripe').val();
                        $('#final_coupon_code_stripe').replaceWith('<input type="hidden" name="final_coupon_code_stripe" id="final_coupon_code_stripe" value="'+ final_coupon_code +'">');
                    }
                } 
            });
    });

</script>


<!-- paypay script -->


<script src="https://www.paypal.com/sdk/js?client-id=AVGcAgzu_FN6jiaO8AAqyaXxFPeVfWMBG9OK2CJbnbgqDpnAsNqEpOQ12-Sor5eK0NRduzL4RddazjoV&vault=true&intent=subscription" data-sdk-integration-source="button-factory"></script>

<script>

    
function paypalplan_details(ele){
            var plans_id          = $(ele).attr('data-plan_id');
            var plan_payment_type = $(ele).attr('data-payment-type');
            var plan_price  = $(ele).attr('data-plan-price');
            var plan_id_class = $(ele).attr('data-plan-id');
            let currency_symbols  =  document.getElementById("currency_symbol").value ;

            // alert(plans_id);
            var classname = 'paypal-button-container-'+plans_id
            $('#paypal-button-container').addClass(classname)
                // alert(classname);
                $("#paypal-button-container").append('<div class:'+classname+';></div>');

            $('#payment_type').replaceWith('<input type="hidden" name="payment_type" id="payment_type" value="'+ plan_payment_type+'">');
            $('#plan_name').replaceWith('<input type="hidden" name="plan_name" id="plan_name" value="'+ plans_id +'">');
            $('.plan_price').empty(plan_price);
            $('.plan_price').append(currency_symbols+plan_price);

            $('.dg' ).removeClass('actives');
            $('#'+plan_id_class ).addClass('actives');


            var plan_data = $("#plan_name").val();
            var coupon_code = $("#coupon_code").val();
            var payment_type = $("#payment_type").val();
            var final_payment = $(".final_payment").val();
            var final_coupon_code_stripe = $("#final_coupon_code_stripe").val();

  paypal.Buttons({
      style: {
          shape: 'pill',
          color: 'white',
          layout: 'vertical',
          label: 'subscribe'
      },
      createSubscription: function(data, actions) {
        return actions.subscription.create({
          /* Creates the subscription */
          plan_id: plans_id
        });
      },
      onApprove: function(data, actions) {
        // alert(data.subscriptionID); // You can add optional success message for the subscriber here
        if(!empty(data.subscriptionID)){
            $.post(base_url+'/paypal-subscription', {
                        payment_type:payment_type, 
                        amount:final_payment,
                        plan:plan_data,
                        plans_id:plans_id,
                        subscriptionID:data.subscriptionID,
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
                            setTimeout(function() {
                                window.location.replace(base_url+'/login');
                        }, 2000);
                });
        }
    }
  }).render('#paypal-button-container-'+plans_id); // Renders the PayPal button


}    

</script>	

<script>

        $('.PaypalPayment').hide();
        $('.paypal_plan_details').hide();

        
        // Razorpay_lable
        $(document).ready(function(){
            $('#Stripe_lable').click(function() {
                if ($('#Stripe_lable').val($(this).is(':checked'))) {
                    $('#Paypal_lable').prop('checked', false);
                    $('.Stripe_Payment').show();
                    $('.stripe_plan_details').show();
                    $('.paypal_plan_details').hide();
                    $('.PaypalPayment').hide();
                }
            });
            $('#Paypal_lable').click(function() {
                if ($(this).val() == 'Paypal_lable') {
                    $('#Stripe_lable').prop('checked', false);
                    $('.PaypalPayment').show();
                    $('.paypal_plan_details').show();
                    $('.stripe_plan_details').hide();
                    $('.Stripe_Payment').hide();
                }
            });
        })
</script>

        {{-- Radio button for payment Gateway  --}}

<script>

    window.onload = function(){
        
        $("#stripe_radio_button").attr('checked', true);
        $('.paystack_payment').hide();

        if( $('input[name="payment_gateway"]:checked').val() == "paystack" ){
            $('.stripe_payment').hide();
        }
    };

    $(document).ready(function(){

        $(".payment_gateway").click(function(){

            $('.paystack_payment,.stripe_payment').hide();

            let payment_gateway =  $('input[name="payment_gateway"]:checked').val();

                if( payment_gateway  == "stripe" ){

                    $('.stripe_payment').show();
                        
                }else if( payment_gateway == "paystack" ){

                    $('.paystack_payment').show();
                }
        });
    });

</script>

                {{-- Paystack Payment --}}
<script>

    $(".paystack_button").click(function(){

        var paystack_plan_id = $("#plan_name").val();

        $.ajax({
            url: "{{ route('Paystack_CreateSubscription') }}",
            type: "post",
            data: {
                    _token: '{{ csrf_token() }}',
                    paystack_plan_id : paystack_plan_id ,
                    async: false,
                },       
                
                success: function( data ,textStatus ){

                if( data.status == true ){
                    window.location.href = data.authorization_url ;
                }

                else if( data.status == false ){
                    swal({
                        title: "Payment Failed!",
                        text: data.message,
                        icon: "warning",
                        }).then(function() {
                            window.location = base_url+'/login';
                        })
                    }
                } 
            });
        });

        $(".payment_gateway").click(function(){

            let payment_gateway =  $('input[name="payment_gateway"]:checked').val();
            let currency_symbol =  document.getElementById("currency_symbol").value ;

            $.ajax({
                url: "{{ route('BecomeSubscriber_Plans') }}",
                type: "get",
                data: {
                        _token: '{{ csrf_token() }}',
                        payment_gateway : payment_gateway ,
                        async: false,
                    },       
                    
                    success: function( response ){

                    var count = response.data.plans_data.length ;

                    if( count <= 0 ){
                        swal({
                            title: "No Plan Found !!",
                            icon: "warning",
                            }).then(function() {
                                location.reload();
                        })
                    }

                    if( count > 0 && response.data.status == true ){

                        html = "";
                        html += '<div class="col-md-12  p-0">';
                            html += '<div class="row align-items-center m-0 p-0 data-plans">';
                                
                                $.each( response.data.plans_data , function( index, plan_data ) {

                                    html += '<a href="#payment_card_scroll" > <div class="col-md-6 plan_details p-0"  data-plan-id="active'+ plan_data.id +'" data-plan-price="'+ plan_data.price +'"  data-plan_id="'+ plan_data.plan_id +'"  data-payment-type="'+ plan_data.payment_type +'" onclick="plan_details(this)">';
                                        html += '<div class="row dg align-items-center mb-4" id="active'+ plan_data.id +'" >';
                                            
                                            html +=   '<div class="col-md-7 p-0">';
                                                html +=   '<h4 class="text-black font-weight-bold">  '+ plan_data.plans_name +'   </h4>';
                                                html +=   '<p>' + plan_data.plans_name + ' Membership </p>';
                                            html += '</div>' ;

                                            html += '<div class="vl "></div>' ;

                                            html += '<div class="col-md-4 p-2" >' ;
                                                html +=    '<h4 class="text-black">'+currency_symbol+ plan_data.price +' </h4>'  ;
                                                html +=    '<p>Billed as '+ currency_symbol + plan_data.price +' </p>' ;
                                            html += '</div>' ;

                                        html += '</div>' ;
                                        html +=' <div class="d-flex justify-content-between align-items-center " > <div class="bgk"></div> </div></a>' ;
                                    html += ' </div>' ;
                                
                                    });
                            html += '</div>';
                        html += '</div>';

                        $('.data-plans').empty('').append(html);

                    } 

                    else if(  response.data.status == false ){
                        swal({
                            title: "No Plan Found !!",
                            icon: "warning",
                            }).then(function() {
                                location.reload();
                            })
                        }
                    } 
            });
        });

        
        // Life Time Subscription

        function LifeTimeSubscription( ele ) {

            let Stripe_publishable_key = document.getElementById("Stripe_publishable_key").value ;
            var subscription_price = $(ele).attr('data-subscription-price');

            var handler = StripeCheckout.configure({

                key: Stripe_publishable_key,
                locale: 'auto',
                panelLabel: "Pay Now", 

                token: function (token) {
                    console.log(' Stripe token Created!!');  console.log( token ); 
                    $('#token_response').html(JSON.stringify(token));

                    $.ajax({
                        url: '{{ route("stripe.lifetime_subscription") }}',
                        method: 'post',
                        data: {
                            "_token": "<?= csrf_token(); ?>",
                            subscription_price: subscription_price  , 
                            stripeToken  : token.id,
                            card_email   : token.email ,
                            card_name    : token.card.name ,
                            card_city    : token.card.address_city,
                            card_country : token.card.country ,
                            card_postal_code   : token.card.address_zip ,
                            card_address_line1 : token.card.address_line1 ,
                        },
                    
                success: function( response ){

                    if( response.data.status == true ){
                        swal({
                            title: "Subscription Purchased Successfully!",
                            text: "Your Payment done Successfully!",
                            icon: payment_images+'/Successful_Payment.gif',
                            buttons: false,      
                            closeOnClickOutside: false,
                        });

                        setTimeout(function() {
                            window.location.href = "{{ route('home')}}";
                        }, 3000);
                    }
                    else if( response.data.status == false ){

                        swal({
                            title: "Payment Failed!",
                            text: "Your Payment is failed",
                            type: "warning"
                            }).then(function() {
                                location.reload();
                            })
                    }
                   
            },
            error: (error) => {
                swal('error');
            
                    }
                })
            
            }
        });

        handler.open({
            name: '{{ GetWebsiteName() }}',
            description: 'Life Time Subscription',
            amount: subscription_price * 100
        });
    } 

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script>
    $(document).ready(function(){
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);
    })
    

    </script>
@php
    include(public_path('themes/default/views/footer.blade.php'));
@endphp

@endsection 
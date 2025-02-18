@extends('layouts.app')

@php
    include public_path('themes/default/views/header.php');


$PayPalpayment = App\PaymentSetting::where('payment_type', 'PayPal')->where('status',1)->first();

$PayPalmode = !is_null($PayPalpayment) ? $PayPalpayment->paypal_live_mode : null;

$paypal_signature = null;
if (!is_null($PayPalpayment)) {
    switch ($PayPalpayment->paypal_live_mode) {
        case 0:
            $paypalClientId = $PayPalpayment->test_paypal_signature;
            break;

        case 1:
            $paypalClientId = $PayPalpayment->live_paypal_signature;
            break;
        default:
            $paypalClientId = null;
            break;
    }
}else{
    $paypalClientId = null;
}

@endphp


@section('content')


<script src="https://www.paypal.com/sdk/js?client-id={{ $paypalClientId }}&vault=true&intent=subscription" data-sdk-integration-source="button-factory"></script>


    <style>
        .round {
            /* background-color: #8a0303 !important; */
            color: #fff !important;

        }

        #coupon_code_stripe {
            background-color: #ddd;
        }

        * {
            box-sizing: border-box;
        }

        .collapsed {
            font-size: 18px !important;
        }

        .columns {
            float: left;
            width: 25%;
            padding: 8px;
        }

        .promo {
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
            box-shadow: 0 8px 12px 0 rgba(0, 0, 0, 0.2)
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
            overflow: hidden;
            text-align: center;
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

        /* .toggle {
            display: flex;
            justify-content: space-between;
            width: 43%;
        } */

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
            margin-left: 22% !important;
        }

        .hide-box {
            display: none;
        }

        .plandetails {
            margin-top: 70px !important;
            min-height: 450px !important;
        }

        .btn-secondary {
            background-color: #4895d1 !important;
            border: none !important;
        }


        input[type=email],
        input[type=number],
        input[type=password],
        input[type=phone],
        input[type=text] {
            display: block;
            height: 54px;

            font-size: 1em;
            color: #000 !important;
            background-color: #fff !important;
            border: 1px solid #000;
            border-radius: 2px;
            padding: 0 0.5em;
            -webkit-transition: .2s border ease-in-out;
            transition: .2s border ease-in-out;
        }

        #ck-button {
            margin: 4px;
            border-radius: 4px;
            overflow: auto;
            float: left;
        }

        #ck-button label {
            float: left;
            width: 4.0em;
        }

        .min {
            min-height: 100vh;
        }

        .sd {
            color: #8A0303 !important;
            font-weight: 500;
            text-decoration: underline !important;
        }

        p {
            font-size: 14px;
        }

        #ck-button label span {
            text-align: center;
            display: block;
            color: #fff;
            background-color: #3daae0;
            border: 1px solid #3daae0;
            padding: 0;
        }

        #ck-button label input {
            position: absolute;
        }

        #ck-button input:checked+span {
            background-color: #3daae0;
            color: #fff;
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
            background-position: bottom;
            background-size: 50px 1px;
            background-repeat: repeat-x;
            background-position-x: 80px;
        }

        #otp:focus {
            border: none;
        }

        .verify-buttons {
            margin-left: 36%;
        }

        .container {
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
            background: rgba(200, 170, 118, .5);
        }

        #tab_nav li span {
            float: right;
            font-weight: bold;
            display: none;
        }

        .dgk {
            color: #000 !important;
            padding: 30px 24px;
        }

        .dgk h4 {
            font-weight: 600;
            color: #000 !important;
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

        .dgk h6 {
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

        .phselect {
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

        .catag {
            padding-right: 150px !important;
        }

        i.fa.fa-google-plus {
            padding: 10px !important;
        }

        option {
            background: #474644 !important;
        }

        .reveal {
            margin-left: -92px !important;
            height: 45px !important;
            background: transparent !important;
            color: #fff !important;
        }

        .error {
            color: brown;
            font-family: 'remixicon';
        }

        .meth {
            color: #fff;
            font-weight: 500;
            font-size: 20px;
        }

        .small-heading {
            font-size: 14px;
            margin-bottom: 20px;
        }

        .medium-heading {
            font-size: 30px;
            font-weight: 700;
        }

        .container1 {
            background-color: #000;
            border-radius: 25px;
            padding: 20px;
            color: #fff;
        }

        .vl {
            border-left: 2px solid #000;
            height: 60px;
        }

        .btn1 {
            /* background: rgba(138, 3, 3, 1) !important; */
            border: none;
            border-radius: 30px;
            padding: 15px;
        }

        label {
            color: #fff !important;
            /* line-height: 0; */

        }

        .buttonClass {
            font-size: 15px;

            width: 200px;
            height: 57px;
            border-width: 0px;
            ontolor: #fff;
            border-color: #18ab29;
            font-weight: bold;
            margin-top: 20px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
            background: rgba(138, 3, 3, 1) !important;
            color: #fff;
        }

        .buttonClass:hover {
            background: rgba(124, 20, 20, 0.8) !important;
        }

        .dg {
            color: #000 !important;
            background-color: #fff;
            margin: 5px;
            border: 5px solid #ddd;
        }

        .actives {
            border: 5px solid rgba(138, 3, 3, 1) !important;
            padding: 0;
        }

        .dg:hover {
            color: #000 !important;
            border: {{ '5px solid' . button_bg_color() . '!important' }};
            transition: 0.5s;
        }

        .cont {
            background-color: #232c30;
            padding: 36px 47px 70px;
            margin-bottom: 35px;
        }

        #card-element {
            height: 50px;
            background: #f4f6f7;
            padding: 10px;
        }

        .blk li {
            font-size: 14px;
        }

        .blk p {
            font-size: 14px;
        }

        html {
            scroll-behavior: smooth;
        }

        .plan_details {
            min-height: 300px;
        }

        .blk {
            /* height: 200px; */
            padding: 10px;
        }

        body.dark-theme .blk p{color: <?php echo GetLightText(); ?> !important}
        body.dark-theme .dgk h4{color: <?php echo GetLightText(); ?> !important}
        body.dark-theme .dgk p{color: <?php echo GetLightText(); ?> !important}

        body.light-theme .blk p{color: <?php echo $GetLightText; ?>!important;}
        body.light-theme .dgk h4{color: <?php echo $GetDarkText; ?>!important;}
        body.light-theme .dgk p{color: <?php echo $GetDarkText; ?>!important;}

        body.dark-theme .ambk {
            background: <?php echo $GetDarkText; ?>!important;
            color: <?php echo $GetDarkBg; ?>!important;
            padding: 10px !important;
        }
        body.dark-theme .ambk h6, body.dark-theme .ambk p{
            color: <?php echo $GetDarkBg; ?>!important;
        }

        body.dark-theme .small-heading, body.dark-theme .medium-heading{
            color: <?php echo $GetDarkText; ?>!important;
        }

        body.light-theme p{
            color: <?php echo GetLightText(); ?> !important;
        }
        body.light-theme .bg-white{
            background: <?php echo $GetDarkBg; ?>!important;
        }
        body.light-theme .small-heading, body.light-theme .medium-heading{
            color: <?php echo GetLightText(); ?> !important;
        }
        body.light-theme p{
            color: <?php echo GetLightText(); ?> !important;
        }
        body.light-theme .text-white{
            color: <?php echo GetLightText(); ?> !important;
        }
        /* p{color: #fff !important;}  */

    </style>


    @php
        $SubscriptionPlan = App\SubscriptionPlan::first();

        $signup_payment_content = App\SiteTheme::pluck('signup_payment_content')->first();
        $signup_step2_title = App\SiteTheme::pluck('signup_step2_title')->first();

        $Stripe_payment_settings = App\PaymentSetting::where('payment_type', 'Stripe')->first();
        $PayPal_payment_settings = App\PaymentSetting::where('payment_type', 'PayPal')->first();
        $Paystack_payment_settings = App\PaymentSetting::where('payment_type', 'Paystack')->first();
        $Razorpay_payment_settings = App\PaymentSetting::where('payment_type', 'Razorpay')->first();
        $CinetPay_payment_settings = App\PaymentSetting::where('payment_type', 'CinetPay')->first();
        $Paydunya_payment_settings = App\PaymentSetting::where('payment_type','Paydunya')->first();
        $recurly_payment_settings = App\PaymentSetting::where('payment_type','Recurly')->where('recurly_status',1)->first();

        // label
        $stripe_label = App\PaymentSetting::where('payment_type', 'Stripe')->pluck('stripe_lable')->first() ? App\PaymentSetting::where('payment_type', 'Stripe')->pluck('stripe_lable')->first() : 'Stripe';
        $paypal_label = App\PaymentSetting::where('payment_type', 'PayPal')->pluck('paypal_lable')->first() ? App\PaymentSetting::where('payment_type', 'PayPal')->pluck('paypal_lable')->first() : 'PayPal';
        $paystack_label = App\PaymentSetting::where('payment_type', 'Paystack')->pluck('paystack_lable')->first() ? App\PaymentSetting::where('payment_type', 'Paystack')->pluck('paystack_lable')->first() : 'paystack';
        $Razorpay_label = App\PaymentSetting::where('payment_type', 'Razorpay')->pluck('Razorpay_lable')->first() ? App\PaymentSetting::where('payment_type', 'Razorpay')->pluck('Razorpay_lable')->first() : 'Razorpay';
        $CinetPay_lable = App\PaymentSetting::where('payment_type', 'CinetPay')->pluck('CinetPay_Lable')->first() ? App\PaymentSetting::where('payment_type', 'CinetPay')->pluck('CinetPay_Lable')->first() : 'CinetPay';
        $Paydunya_label = App\PaymentSetting::where('payment_type','Paydunya')->pluck('paydunya_label')->first() ? App\PaymentSetting::where('payment_type','Paydunya')->pluck('paydunya_label')->first() : "Paydunya";
        $recurly_label = App\PaymentSetting::where('payment_type','Recurly')->pluck('recurly_label')->first() ? App\PaymentSetting::where('payment_type','Recurly')->pluck('recurly_label')->first() : "Recurly";
        
        $CurrencySetting = App\CurrencySetting::pluck('enable_multi_currency')->first();
    @endphp

    <section class="flick p-4">

        <div class="col-sm-12">
            <button href="" onclick="history.back()" style="background: transparent;border:none;cursor: pointer;">
                <svg style="{{ 'color:'. front_End_text_color() }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="64" height="64" fill="currentColor"><path d="M12 2C17.52 2 22 6.48 22 12C22 17.52 17.52 22 12 22C6.48 22 2 17.52 2 12C2 6.48 6.48 2 12 2ZM12 20C16.42 20 20 16.42 20 12C20 7.58 16.42 4 12 4C7.58 4 4 7.58 4 12C4 16.42 7.58 20 12 20ZM12 11H16V13H12V16L8 12L12 8V11Z"></path></svg>
            </button>
        </div>

        <div class="container">

            <div align="center"></div>
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-6 p-0">
                    <div class="flick1">

                        
                        <div class="small-heading">Step 2 of<span class="ml-2">2</span></div>

                        <p style="font-size: 16px;">Welcome {{ Auth::user()->username ? Auth::user()->username : ' ' }}, </p>
                        
                        <div class="medium-heading pb-3"> {{ $signup_step2_title }} </div>

                        <div class="col-md-12 p-0">
                            <p class="meth"> Payment Method</p>
                            <div class="d-flex">

                                            <!-- Stripe -->

                                @if (!empty($Stripe_payment_settings) && $Stripe_payment_settings->stripe_status == 1)
                                    <div class="align-items-center ">
                                        <input type="radio" id="stripe_radio_button" class="payment_gateway" name="payment_gateway" value="stripe">
                                        <label class="ml-2 mt-2"><p> {{ $stripe_label }} </p> </label> <br />
                                    </div>
                                @endif
                                
                                            <!-- Razorpay -->

                                @if (!empty($Razorpay_payment_settings) && $Razorpay_payment_settings->status == 1)
                                    <div class="align-items-center  ml-2">
                                        <input type="radio" id="Razorpay_radio_button" class="payment_gateway" name="payment_gateway" value="Razorpay">
                                        <label class="ml-2 mt-2"> <p> {{ $Razorpay_label }} </p></label><br />
                                    </div>
                                @endif

                                            <!-- Paystack -->

                                @if (!empty($Paystack_payment_settings) && $Paystack_payment_settings->status == 1)
                                    <div class=" align-items-center ml-2">
                                        <input type="radio" id="paystack_radio_button" class="payment_gateway"  name="payment_gateway" value="paystack">
                                        <label class="ml-2 mt-2"><p>{{ $paystack_label }} </p></label> <br />
                                    </div>
                                @endif

                                            <!-- PayPal -->

                                @if (!empty($PayPal_payment_settings) && $PayPal_payment_settings->paypal_status == 1)
                                    <div class="align-items-center  ml-2">
                                        <input type="radio" id="paypaul_radio_button" class="payment_gateway" name="payment_gateway" value="paypal">
                                        <label class="ml-2 mt-2"><p>{{ $paypal_label }} </p> </label> <br />
                                    </div>
                                @endif
                                            <!-- CinetPay -->

                                @if (!empty($CinetPay_payment_settings) && $CinetPay_payment_settings->CinetPay_Status == 1)
                                    <div class=" align-items-center ml-2">
                                        <input type="radio" id="cinetpay_radio_button" class="payment_gateway" name="payment_gateway" value="CinetPay">
                                        <label class="ml-2 mt-2"><p>{{ $CinetPay_lable }} </p></label><br />
                                    </div>
                                @endif
                                
                                     {{-- Paydunya --}}
                                @if(!empty($Paydunya_payment_settings) && $Paydunya_payment_settings->paydunya_status == 1)
                                    <div class=" align-items-center ml-2">
                                        <input type="radio" id="paydunya_radio_button" class="payment_gateway" name="payment_gateway" value="Paydunya" >
                                        <label class="ml-2 mt-2"> <p>{{ __($Paydunya_label) }} </p></label> 
                                    </div>
                                @endif

                                      {{-- Recurly --}}
                                @if(!empty($recurly_payment_settings) && $recurly_payment_settings->recurly_status == 1)
                                    <div class=" align-items-center ml-2">
                                        <input type="radio" id="recurly_radio_button" class="payment_gateway" name="payment_gateway" value="Recurly" >
                                        <label class="ml-2 mt-2"> <p>{{ __($recurly_label) }} </p></label> 
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="data-plans row align-items-center m-0 p-0">
                                    @foreach ($plans_data_signup_checkout as $key => $plan)

                                        @php
                                            $plan_name = $plan->plans_name;
                                        @endphp

                                        <div style="" class="col-md-4 plan_details p-0" data-plan-id="{{ 'active' . $plan->id }}" data-plan-price="{{ $CurrencySetting == 1 ? (Currency_Convert($plan->price)) : currency_symbol(). round($plan->price,2) }}"
                                            data-plan_id={{ $plan->plan_id }} data-pay-type={{ $plan->type }} data-payment-type={{ $plan->payment_type }} onclick="plan_details(this)">


                                            <a href="#payment_card_scroll">

                                                <div class="row dg align-items-center mb-4" id={{ 'active' . $plan->id }}>
                                                    <div class="col-md-12 ambk p-0 text-center">
                                                        <div>
                                                            <h6 class=" font-weight-bold"> {{ $plan->plans_name }} </h6>
                                                            <p class="text-white mb-0"> {{ $CurrencySetting == 1 ? Currency_Convert(($plan->price) ) : currency_symbol(). round($plan->price,2) }} Membership</p>
                                                            <span class='mb-0'> {{ $plan->days }} Days Membership</span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 blk">
                                                        <p > {!! html_entity_decode($plan->plan_content) !!} </p>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center ">
                                                    <div class="bgk"></div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                                                {{-- Summary --}}
                            <div class="col-md-12 mt-5" id="payment_card_scroll">

                                <h4>Summary</h4>

                                <div class="bg-white mt-4 dgk">
                                    <h4> Due today: 
                                        <span class='plan_price Summary'>

                                            @if (  $CurrencySetting == 1 && $SubscriptionPlan )
                                                {{Currency_Convert($SubscriptionPlan->price) }}
                                            @elseif($SubscriptionPlan )
                                                {{  currency_symbol() . round($SubscriptionPlan->price,2 )  }}
                                            @else
                                                {{'0:0'}}
                                            @endif

                                        </span> 
                                    </h4>
                                    <hr />
                                    <p class="text-center mt-3">All state sales taxes apply</p>
                                </div>

                                <p class="text-white mt-3 dp">
                                    {{ $signup_payment_content ? $signup_payment_content : ' ' }}
                                </p>
                            </div>

                                                {{-- Payment Buttons --}}
                           
                            {{-- Stripe --}}  
                            <div class="col-md-12 stripe_payment" style="display: none;">
                                <button type="submit" class="btn bd btn1 btn-lg btn-block font-weight-bold text-white mt-3 stripe_button processing_alert"> Pay Now</button>
                            </div>
                           

                            {{-- Razorpay --}}
                            <div class="col-md-12 Razorpay_payment" style="display: none;">
                                <button type="submit"
                                    class="btn bd btn1 btn-lg btn-block font-weight-bold text-white mt-3 Razorpay_button processing_alert">
                                    Pay Now
                                </button>
                            </div>

                            {{-- Paystack --}}
                            <div class="col-md-12 paystack_payment" style="display: none;">
                                <button type="submit"
                                    class="btn bd btn1 btn-lg btn-block font-weight-bold text-white mt-3 paystack_button processing_alert">
                                    Pay Now
                                </button>
                            </div>

                            {{-- CinetPay --}}
                            <div class="col-md-12 cinetpay_payment" style="display: none;">
                                <button onclick="cinetpay_checkout()" data-subscription-price='100' type="submit"
                                    class="btn bd btn1 btn-lg btn-block font-weight-bold text-white mt-3 cinetpay_button">
                                    Pay Now
                                </button>
                            </div>

                            {{-- Paydunya --}}
                            <div class="col-md-12 Paydunya_payment" style="display: none;">
                                <button  type="submit" class="btn bd btn1 btn-lg btn-block font-weight-bold text-white mt-3 Paydunya_button processing_alert" >
                                    {{ __('Pay Now') }}
                                </button>
                            </div>

                            {{-- Recurly --}}
                            <div class="col-md-12 Recurly_payment" style="display: none;">
                                <form action="{{ route('Recurly.checkout_page') }}" method="post">
                                    @csrf
                                    <input type="hidden" id="plan_name" name="recurly_plan_id" value="{{ $plan_name ?? '' }}">
                                    <input type="hidden" id="payment_current_route_uri" name="payment_current_route_uri" value="{{ $payment_current_route_uri ?? '' }}">
                                    <button type="submit" class="btn bd btn1 btn-lg btn-block font-weight-bold text-white mt-3 processing_alert">
                                        {{ __('Pay Now') }}
                                    </button>
                                </form>
                            </div>

                            <div class="d-flex justify-content-center" style="margin-right:auto;margin-left:auto;">
                                <a class="btn bd  text-white mt-3" href="{{ URL::to('/home') }}">
                                    <span> <i class="ri-home-4-line"></i></span>  {{ __('Go to Home') }}
                                </a>
                            </div>

                            <input type="hidden" id="payment_image" value="<?php echo URL::to('/') . '/public/Thumbnai_images'; ?>">
                            <input type="hidden" id="currency_symbol" value="{{ currency_symbol() }}">
                        </div>

                            {{-- PaypalPayment --}}

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
                            <div id="paypal-button-container"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <input type="hidden" id="base_url" value="<?php echo URL::to('/'); ?>">
    <input type="hidden" id="stripe_coupon_code" value="<?php echo NewSubscriptionCouponCode(); ?>">
    <input type="hidden" value="<?php echo DiscountPercentage(); ?>" id="discount_percentage" class="discount_percentage">
    <input type="hidden" value="<?php echo NewSubscriptionCoupon(); ?>" id="discount_status" class="discount_status">


    <script>
        $(function() {
            $("#tabs").tabs();
            $("tabs li:first").addClass("active");
        });
    </script>

    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('#submit-new-cat').click(function() {
                $('#payment-form').submit();
            });
        });
    </script>

    {{-- cinetpay  Payment Price --}}

    <input type="hidden" id="Cinetpay_Price" name="Cinetpay_Price" value=" ">


    {{-- Stripe Payment --}}
    <input type="hidden" id="plan_name" name="plan_name" value={{ $SubscriptionPlan ? $SubscriptionPlan->plan_id : ' ' }}>
    <input type="hidden" id="payment_type" name="payment_type" value={{ $SubscriptionPlan ? $SubscriptionPlan->payment_type : ' ' }}>
    <input type="hidden" id="base_url" value="<?php echo URL::to('/'); ?>">

    <script src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://checkout.stripe.com/checkout.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <script>

       var base_url = $('#base_url').val();

       function plan_details(ele) {
            // Get data attributes from the clicked element
            var plans_id = $(ele).attr('data-plan_id');
            var plan_payment_type = $(ele).attr('data-payment-type');
            var plan_pay_type = $(ele).attr('data-pay-type');
            var plan_price = $(ele).attr('data-plan-price');
            var plan_id_class = $(ele).attr('data-plan-id');
            var currency_symbols = document.getElementById("currency_symbol").value;


            $('#paypal-button-container').empty().hide();

            if (plan_pay_type === 'PayPal') {
                $('#paypal-button-container').show();
                $('.Stripe_Payment').hide();
                var classname = 'paypal-button-container-' + plans_id;
                $('#paypal-button-container').addClass(classname);
                $("#paypal-button-container").append('<div id="' + classname + '"></div>');

                $('#payment_type').replaceWith('<input type="hidden" name="payment_type" id="payment_type" value="' + plan_payment_type + '">');
                $('#plan_name').replaceWith('<input type="hidden" name="plan_name" id="plan_name" value="' + plans_id + '">');
                $('.plan_price').empty().append(plan_price);
                $('.dg').removeClass('actives');
                $('#' + plan_id_class).addClass('actives');

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
                        label: 'subscribe',
                    },
                    createSubscription: function (data, actions) {
                        return actions.subscription.create({
                            plan_id: plans_id
                        });
                    },
                    onApprove: function(data, actions) {
                        if (data.subscriptionID) {
                            $.post(base_url + '/paypal-subscription', {
                                payment_type: payment_type,
                                amount: final_payment,
                                plan: plan_data,
                                plans_id: plans_id,
                                subscriptionID: data.subscriptionID,
                                orderID: data.orderID,
                                coupon_code: final_coupon_code_stripe,
                                userId: '{{ Auth::user()->id }}',
                                _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            })
                            .done(function (response) {
                                $('#loader').css('display', 'block');
                                swal({
                                    title: "Subscription Purchased Successfully!",
                                    text: "Your Payment was Successful!",
                                    icon: payment_images + '/Successful_Payment.gif',
                                    buttons: false,
                                    closeOnClickOutside: false,
                                });
                                setTimeout(function () {
                                    window.location.replace(base_url + '/myprofile');
                                }, 2000);
                            })
                            .fail(function (xhr, status, error) {
                                swal("Error", "Payment failed. Please try again.", "error");
                            });
                        }
                    }
                }).render('#' + classname);
            }
            else{
                $('#payment_type').replaceWith('<input type="hidden" name="payment_type" id="payment_type" value="' + plan_payment_type + '">');
                $('#plan_name').replaceWith('<input type="hidden" name="plan_name" id="plan_name" value="' + plans_id + '">');
                $('#Cinetpay_Price').replaceWith('<input type="hidden" name="Cinetpay_Price" id="Cinetpay_Price" value="' + plan_price + '">');
                $('.plan_price').empty().append(plan_price);
                $('#coupon_amt_deduction').empty().append(plan_price);


                $('.dg').removeClass('actives');
                $('#' + plan_id_class).addClass('actives');
            }
        }


        window.onload = function() {
            $('#active2').addClass('actives');
        }

        // Processing Alert 

        var payment_images = $('#payment_image').val();

        $(".processing_alert").click(function() {

            swal({
                title: "Processing Payment!",
                text: "Please wait untill the proccessing completed!",
                icon: payment_images + '/processing_payment.gif',
                buttons: false,
                closeOnClickOutside: false,
            });

        });

        // BecomeSubscriber_Plans
   
        $(".payment_gateway").click(function() {

            let payment_gateway = $('input[name="payment_gateway"]:checked').val();
            let currency_symbol = document.getElementById("currency_symbol").value;

            swal({
                title: "Loading...",
                text: "Please wait",
                icon: payment_images + '/Loading.gif',
                buttons: false,
                closeOnClickOutside: false,
                closeOnEsc: false,
            });

            $.ajax({
                url: "{{ route('BecomeSubscriber_Plans') }}",
                type: "get",
                data: {
                    _token: '{{ csrf_token() }}',
                    payment_gateway: payment_gateway,
                    async: false,
                },

                success: function(response) {

                    var count = response.data.plans_data.length;

                    if (count <= 0) {
                        swal({
                            title: "No Plan Found !!",
                            icon: "warning",
                        }).then(function() {
                            location.reload();
                        })
                    }

                    if (count > 0 && response.data.status == true) {

                        html = "";
                        html += '<div class="col-md-12 p-0">';
                        html += '<div class="row align-items-center m-0 p-0 data-plans">';

                        $.each(response.data.plans_data, function(index, plan_data) {

                            html +=
                                '<div class="col-md-6 plan_details p-0"  data-plan-id="active' +
                                plan_data.id + '" data-plan-price="' + plan_data.price +
                                '"  data-plan_id="' + plan_data.plan_id +
                                '"  data-payment-type="' + plan_data.payment_type + '"  data-pay-type="' +  plan_data.type  +
                                '" onclick="plan_details(this)">';
                            html +=
                                '<a href="#payment_card_scroll"> <div class="row dg align-items-center mb-4" id="active' +
                                plan_data.id + '" >';

                            html += '<div class="col-md-12 ambk p-0 text-center">';
                            html += '<h6 class="font-weight-bold">  ' + plan_data.plans_name +
                                '   </h6>';
                            html += '<p class="text-white mb-0">'  + plan_data
                                .price + ' Membership </p>';
                            html += '</div>';

                            html += '<div class="col-md-12 blk" >';
                            html += '<h4 class="text-black"> ' + plan_data.plan_content +
                                ' </h4>';
                            html += '</div>';

                            html += '</div>';
                            html +=
                                ' <div class="d-flex justify-content-between align-items-center " > <div class="bgk"></div> </div> </a>';
                            html += ' </div>';

                        });
                        html += '</div>';
                        html += '</div>';


                        $('.data-plans').empty('').append(html);

                        swal.close();

                    } else if (response.data.status == false) {

                        swal.close();

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

    </script>

    {{-- Radio button for payment Gateway  --}}

    <script>
        window.onload = function() {

            $('.paystack_payment,.stripe_payment,.Razorpay_payment,.cinetpay_button,.Paydunya_payment,.Recurly_payment,.PaypalPayment').hide();
            $('.Summary').empty();

            // $("#stripe_radio_button").attr('checked', true);

            if ($('input[name="payment_gateway"]:checked').val() == "stripe") {
                $('.stripe_payment').show();
            }

            if ($('input[name="payment_gateway"]:checked').val() == "paystack") {
                $('.paystack_payment').show();
            }

            if ($('input[name="payment_gateway"]:checked').val() == "Razorpay") {
                $('.Razorpay_payment').show();
            }

            if ($('input[name="payment_gateway"]:checked').val() == "CinetPay") {
                $('.cinetpay_button').show();
            }

            if ($('input[name="payment_gateway"]:checked').val() == "Paydunya") {
                $('.Paydunya_payment').show();
            }

            if ($('input[name="payment_gateway"]:checked').val() == "Recurly") {
                $('.Recurly_payment').show();
            }

            if ($('input[name="payment_gateway"]:checked').val() == "paypal") {
                $('.PaypalPayment').show();
            }
        };

        $(document).ready(function() {

            $(".payment_gateway").click(function() {

                $('.paystack_payment,.stripe_payment,.Razorpay_payment,.cinetpay_button,.Paydunya_payment,.Recurly_payment,.PaypalPayment').hide();
                
                $('.Summary').empty();

                let payment_gateway = $('input[name="payment_gateway"]:checked').val();

                if (payment_gateway == "stripe") {

                    $('.stripe_payment').show();

                } else if (payment_gateway == "paystack") {

                    $('.paystack_payment').show();

                } else if (payment_gateway == "Razorpay") {

                    $('.Razorpay_payment').show();

                } else if (payment_gateway == "CinetPay") {

                    $('.cinetpay_button').show();

                } else if (payment_gateway == "Paydunya") {

                    $('.Paydunya_payment').show();
                }

                else if (payment_gateway == "Recurly") {

                    $('.Recurly_payment').show();
                }
                else if (payment_gateway == "paypal") {

                    $('.PaypalPayment').show();
                }
                
            });
        });
    </script>

            {{-- Stripe Payment --}}
            
    <script>
        $(".stripe_button").click(function() {

            var Stripe_Plan_id = $("#plan_name").val();

            $.ajax({
                url: "{{ route('Stripe_authorization_url') }}",
                type: "post",
                data: {
                    _token: '{{ csrf_token() }}',
                    Stripe_Plan_id: Stripe_Plan_id,
                    async: false,
                },

                success: function(data, textStatus) {

                    if (data.status == true) {
                        window.location.href = data.authorization_url;
                    } else if (data.status == false) {
                        swal({
                            title: "Payment Failed!",
                            text: data.message,
                            icon: "warning",
                        }).then(function() {
                            location.reload();
                        })
                    }
                }
            });
        });
    </script>
            

            {{-- Razorpay Payment --}}
    
    <script>
        $(".Razorpay_button").click(function() {

            var Razorpay_plan_id = $("#plan_name").val();

            $.ajax({
                url: "{{ route('Razorpay_authorization_url') }}",
                type: "post",
                data: {
                    _token: '{{ csrf_token() }}',
                    Razorpay_plan_id: Razorpay_plan_id,
                    async: false,
                },

                success: function(data, textStatus) {

                    if (data.status == true) {
                        window.location.href = data.authorization_url;
                    } else if (data.status == false) {
                        swal({
                            title: "Payment Failed!",
                            text: data.message,
                            icon: "warning",
                        }).then(function() {
                            location.reload();
                        })
                    }
                }
            });
        });
    </script>

            {{-- Paystack Payment --}}

    <script>
        $(".paystack_button").click(function() {

            var paystack_plan_id = $("#plan_name").val();

            $.ajax({
                url: "{{ route('Paystack_CreateSubscription') }}",
                type: "post",
                data: {
                    _token: '{{ csrf_token() }}',
                    paystack_plan_id: paystack_plan_id,
                    async: false,
                },

                success: function(data, textStatus) {

                    if (data.status == true) {
                        window.location.href = data.authorization_url;
                    } else if (data.status == false) {
                        swal({
                            title: "Payment Failed!",
                            text: data.message,
                            icon: "warning",
                        }).then(function() {
                            location.reload();
                        })
                    }
                }
            });
        });
    </script>

            <!-- Cinetpay Payment -->

    <script src="https://cdn.cinetpay.com/seamless/main.js"></script>

    <script>
        function cinetpay_checkout() {


            let Cinetpay_Price = $('#Cinetpay_Price').val();
            let plan_name = $("#plan_name").val();
            var user_name = '{{ @$intent_stripe->username }}';
            var email = '{{ @$intent_stripe->email }}';
            var mobile = '{{ @$intent_stripe->mobile }}';
            var CinetPay_APIKEY = '{{ @$CinetPay_payment_settings->CinetPay_APIKEY }}';
            var CinetPay_SecretKey = '{{ @$CinetPay_payment_settings->CinetPay_SecretKey }}';
            var CinetPay_SITE_ID = '{{ @$CinetPay_payment_settings->CinetPay_SITE_ID }}';
            var user_id = '{{ @$intent_stripe->id }}';
            var transaction_id = Math.floor(Math.random() * 100000000).toString();
            var currency = '{{ currency_symbol() }}'

            CinetPay.setConfig({
                apikey: CinetPay_APIKEY, //   YOUR APIKEY
                site_id: CinetPay_SITE_ID, //YOUR_SITE_ID
                notify_url: window.location.href,
                return_url: window.location.href,
                // mode: 'PRODUCTION'

            });
            CinetPay.getCheckout({
                transaction_id: transaction_id, // YOUR TRANSACTION ID
                amount: Cinetpay_Price,
                currency: currency,
                channels: 'ALL',
                description: 'paiement',
                //Provide these variables for credit card payments
                customer_name: user_name, //Customer name
                customer_surname: user_name, //The customer's first name
                customer_email: email, //the customer's email
                customer_phone_number: mobile, //the customer's email
                customer_address: "BP 0024", //customer address
                customer_city: "Antananarivo", // The customer's city
                customer_country: "CM", // the ISO code of the country
                customer_state: "CM", // the ISO state code
                //  customer_country: "CI, BF, US, CA, FR",// the ISO code of the country
                //  customer_state: "CM,CA,US",// the ISO state code
                customer_zip_code: "06510", // postcode

            });
            CinetPay.waitResponse(function(data) {
                if (data.status == "REFUSED") {

                    if (alert("Your payment failed")) {
                        window.location.reload();
                    }
                } else if (data.status == "ACCEPTED") {

                    $.ajax({
                        url: '{{ route('CinetPay_Subscription') }}',
                        type: "post",
                        data: {
                            _token: '{{ csrf_token() }}  ',
                            amount: Cinetpay_Price,
                            plan_name: plan_name,
                            email: email,
                            user_name: user_name,
                            user_id: user_id,
                            transaction_id: transaction_id,
                        },
                        success: function(value) {
                            alert("You have done  Payment !");
                            setTimeout(function() {
                                window.location = base_url + '/login';
                            }, 2000);

                        },
                        error: (error) => {
                            swal('error');
                        }
                    });
                }
            });
            CinetPay.onError(function(data) {
                console.log(data);
            });
        }
    </script>

                    {{--  Paydunya Payment  --}}
    <script>

        $(".Paydunya_button").click(function(){

            var Paydunya_plan_id = $("#plan_name").val();

            $.ajax({
                url: "{{ route('Paydunya_checkout') }}",
                type: "post",
                data: {
                        _token: '{{ csrf_token() }}',
                        Paydunya_plan_id : Paydunya_plan_id ,
                        async: false,
                    },       
                    
                    success: function( data ){

                    if( data.status == true ){
                        window.location.href = data.authorization_url ;
                    }

                    else if( data.status == false ){
                        swal({
                            title: "Payment Failed!",
                            text: data.message,
                            icon: "warning",
                            }).then(function() {
                                location.reload();
                            })
                        }
                    } 
                });
        });
    </script>

    @php include public_path('themes/default/views/footer.blade.php'); @endphp

@endsection
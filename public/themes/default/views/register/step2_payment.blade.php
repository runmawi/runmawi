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
            background-color: #8a0303 !important;
            color: #fff !important;
            padding: 14px 20px;
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

        .promo {
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

        /*.sign-user_card {
            background: none !important;
        }*/
        #ck-button {
            margin: 4px;
            /*    background-color:#EFEFEF;*/
            border-radius: 4px;
            /*    border:1px solid #D0D0D0;*/
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
            /*    top:-20px;*/
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
        }*/
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

        /*input[type="file"] {
            display: none;
        }

        */ .catag {
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
            background: rgba(138, 3, 3, 1) !important;
            border: none;
            border-radius: 30px;
            padding: 15px;
        }

        label {
            color: #fff !important;
            line-height: 0;
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
            /*padding: 10px;*/
            color: #000 !important;
            background-color: #fff;
            margin: 7px;
            border: 5px solid #ddd;


        }

        .actives {
            border: 5px solid #a5a093;

        }

        .dg:hover {
            transition: 0.5s;
            color: #000 !important;
            border: {{ '5px solid' . button_bg_color() . '!important' }};
        }

        .cont {
            background-color: #232c30;
            padding: 36px 47px 70px;
            margin-bottom: 35px;
        }

        #card-button {
            background-color: {{ button_bg_color() . '!important' }};
        }

        .blk li {
            font-size: 14px;
        }

        .blk p {
            font-size: 14px;
        }
    </style>

    <style>
        .plan_details {
            min-height: 300px;
        }

        #card-element {
            height: 50px;
            background: #f4f6f7;
            padding: 10px;
        }

        .blk {
            height: 200px;
            padding: 15px;
        }

        .ambk {
            background-color: #000;
            padding: 10px !important;
        }

        html {
            scroll-behavior: smooth;
        }
    </style>

    <script>
        $(function() {
            $("#tabs").tabs();
            $("tabs li:first").addClass("active");
        });
    </script>
    @if (Session::has('message'))
        <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
    @endif

    @if (count($errors) > 0)
        @foreach ($errors->all() as $message)
            <div class="alert alert-danger display-hide" id="successMessage">
                <button id="successMessage" class="close" data-close="alert"></button>
                <span>{{ $message }}</span>
            </div>
        @endforeach
    @endif
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

        // lable
        $stripe_lable = App\PaymentSetting::where('payment_type', 'Stripe')->pluck('stripe_lable')->first() ? App\PaymentSetting::where('payment_type', 'Stripe')->pluck('stripe_lable')->first() : 'Stripe';
        $paypal_lable = App\PaymentSetting::where('payment_type', 'PayPal')->pluck('paypal_lable')->first() ? App\PaymentSetting::where('payment_type', 'PayPal')->pluck('paypal_lable')->first() : 'PayPal';
        $paystack_lable = App\PaymentSetting::where('payment_type', 'Paystack')->pluck('paystack_lable')->first() ? App\PaymentSetting::where('payment_type', 'Paystack')->pluck('paystack_lable')->first() : 'paystack';
        $Razorpay_lable = App\PaymentSetting::where('payment_type', 'Razorpay_lable')->pluck('Razorpay_lable')->first() ? App\PaymentSetting::where('payment_type', 'Razorpay')->pluck('Razorpay_lable')->first() : 'Razorpay';
        $CinetPay_lable = App\PaymentSetting::where('payment_type', 'CinetPay')->pluck('CinetPay_Lable')->first() ? App\PaymentSetting::where('payment_type', 'CinetPay')->pluck('CinetPay_Lable')->first() : 'CinetPay';
        $Paydunya_label = App\PaymentSetting::where('payment_type','Paydunya')->pluck('paydunya_label')->first() ? App\PaymentSetting::where('payment_type','Paydunya')->pluck('paydunya_label')->first() : "Paydunya";
        $recurly_label = App\PaymentSetting::where('payment_type','Recurly')->pluck('recurly_label')->first() ? App\PaymentSetting::where('payment_type','Recurly')->pluck('recurly_label')->first() : "Recurly";

        $CurrencySetting = App\CurrencySetting::pluck('enable_multi_currency')->first();

    @endphp

    <section class="flick">
        
        <div class="col-sm-12">
            <a href="{{ route('home') }}">
                <svg style="{{ 'color:'. front_End_text_color() }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="64" height="64" fill="currentColor"><path d="M12 2C17.52 2 22 6.48 22 12C22 17.52 17.52 22 12 22C6.48 22 2 17.52 2 12C2 6.48 6.48 2 12 2ZM12 20C16.42 20 20 16.42 20 12C20 7.58 16.42 4 12 4C7.58 4 4 7.58 4 12C4 16.42 7.58 20 12 20ZM12 11H16V13H12V16L8 12L12 8V11Z"></path></svg>
            </a>
        </div>

        <div class="container">
            <div align="center">

            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-7">
                    <div class="flick1">
                        <div class="small-heading text-white">Step 2 of <span class="ml-2">2</span></div>
                        <p class="text-white">Hello, {{ $user_mail }}</p>
                        <div class="medium-heading text-white"> {{ $signup_step2_title }} </div>
                        <div class="col-md-12 p-0 mt-2">

                            <div class="d-flex">

                                <!-- Stripe -->
                                @if (!empty($Stripe_payment_settings) && $Stripe_payment_settings->stripe_status == 1)
                                    <div class=" align-items-center ml-2">
                                        <input type="radio" id="stripe_radio_button" class="payment_gateway" name="payment_gateway" value="stripe" >
                                        <label class=" ml-2"> <p>{{ $stripe_lable }} </p> </label>
                                    </div>
                                @endif

                                  <!-- Razorpay -->
                                @if (!empty($Razorpay_payment_settings) && $Razorpay_payment_settings->status == 1)
                                    <div class="align-items-center ml-2">
                                        <input type="radio" id="Razorpay_radio_button" class="payment_gateway" name="payment_gateway" value="Razorpay">
                                        <label class="ml-2"><p> {{ $Razorpay_lable }} </p></label>
                                    </div>
                                @endif

                                 <!-- PayPal -->
                                @if (!empty($PayPal_payment_settings) && $PayPal_payment_settings->paypal_status == 1)
                                    <div class=" align-items-center ml-2">
                                        <input type="radio" id="paypal_radio_button" class="payment_gateway" name="payment_gateway" value="paypal">
                                        <label class="ml-2"><p>{{ $paypal_lable }} </p></label>
                                    </div>
                                @endif

                                <!-- Paystack -->
                                @if (!empty($Paystack_payment_settings) && $Paystack_payment_settings->status == 1)
                                    <div class="align-items-center ml-2">
                                        <input type="radio" id="paystack_radio_button" class="payment_gateway" name="payment_gateway" value="paystack">
                                        <label class="ml-2"><p> {{ $paystack_lable }} </p></label>
                                    </div>
                                @endif

                                  <!-- CinetPay -->
                                @if (!empty($CinetPay_payment_settings) && $CinetPay_payment_settings->CinetPay_Status == 1)
                                    <div class=" align-items-center ml-2">
                                        <input type="radio" id="cinetpay_radio_button" class="payment_gateway" name="payment_gateway" value="CinetPay">
                                        <label class=" ml-2"><p>{{ $CinetPay_lable }} </p></label>
                                    </div>
                                @endif

                                  {{-- Paydunya --}}
                                @if(!empty($Paydunya_payment_settings) && $Paydunya_payment_settings->paydunya_status == 1)
                                    <div class=" align-items-center ml-2">
                                        <input type="radio" id="paydunya_radio_button" class="payment_gateway" name="payment_gateway" value="Paydunya" >
                                        <label class=" ml-2"> <p>{{ __($Paydunya_label) }} </p></label> 
                                    </div>
                                @endif

                                    {{-- Recurly --}}
                                @if(!empty($recurly_payment_settings) && $recurly_payment_settings->recurly_status == 1)
                                    <div class=" align-items-center ml-2">
                                        <input type="radio" id="recurly_radio_button" class="payment_gateway" name="payment_gateway" value="Recurly" checked>
                                        <label class=" ml-2"> <p>{{ __($recurly_label) }} </p></label> 
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

                                        <div style="" class="col-md-6 plan_details p-0" data-plan-id={{ 'active' . $plan->id }} data-plan-price="{{ $CurrencySetting == 1 ? Currency_Convert($plan->price) : round($plan->price,2) }}"
                                            data-plan_id={{ $plan->plan_id }} data-pay-type={{ $plan->type }} data-payment-type={{ $plan->payment_type }} onclick="plan_details(this)">

                                            <a href="#payment_card_scroll">
                                                <div class="row dg align-items-center mb-4" id={{ 'active' . $plan->id }}>
                                                    <div class="col-md-12 ambk p-0 text-center">
                                                        <div>
                                                            <h6 class=" font-weight-bold"> {{ $plan->plans_name }} </h6>
                                                            <p class="text-white mb-0">
                                                                {{ $CurrencySetting == 1 ? Currency_Convert($plan->price) : currency_symbol(). round($plan->price,2) }}
                                                                Membership</p>
                                                            <span class='mb-0'> {{ $plan->days }} Days Membership</span>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 blk">
                                                        <p>@php echo html_entity_decode($plan->plan_content) @endphp</p>
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

                            <!-- Stripe Payment -->
                            <div class="col-md-12 mt-5 Stripe_Payment" id="payment_card_scroll">

                                <h4>Summary</h4>

                                <div class="bg-white mt-4 dgk">
                                    <h4> Due today: <span class='plan_price Summary'>
                                            {{ $SubscriptionPlan ? currency_symbol() . round($SubscriptionPlan->price,2) : currency_symbol() . '0:0' }}
                                        </span>
                                    </h4>
                                    <hr />
                                    <p class="text-center mt-3">All state sales taxes apply</p>
                                </div>

                                <p class="text-white mt-3 dp">
                                    {{ $signup_payment_content ? $signup_payment_content : 'By Clicking on Paynow & Start' }}
                                </p>

                                {{-- Stripe --}}
                                <div class="col-md-12 stripe_payment">
                                    <button type="submit"
                                        class="btn1 btn-lg btn-block font-weight-bold text-white mt-3 stripe_button processing_alert">
                                        Pay Now
                                    </button>
                                </div>

                                {{-- Razorpay --}}
                                <div class="col-md-12 Razorpay_payment">
                                    <button type="submit"
                                        class="btn1 btn-lg btn-block font-weight-bold text-white mt-3 Razorpay_button processing_alert">
                                        Pay Now
                                    </button>
                                </div>

                                 {{-- Paystack --}}
                                 <div class="col-md-12 paystack_payment">
                                    <button type="submit"
                                        class="btn1 btn-lg btn-block font-weight-bold text-white mt-3 paystack_button processing_alert">
                                        Pay Now
                                    </button>
                                </div>

                                {{-- CinetPay --}}
                                <div class="col-md-12 cinetpay_payment">
                                    <button onclick="cinetpay_checkout()" data-subscription-price='100' type="submit"
                                        class="btn1 btn-lg btn-block font-weight-bold text-white mt-3 cinetpay_button">
                                        Pay Now
                                    </button>
                                </div>

                                {{-- Paydunya --}}
                                <div class="col-md-12 Paydunya_payment">
                                    <button  type="submit" class="btn1 btn-lg btn-block font-weight-bold text-white mt-3 Paydunya_button processing_alert" >
                                        {{ __('Pay Now') }}
                                    </button>
                                </div>

                                {{-- Recurly --}}
                                <div class="col-md-12 Recurly_payment">
                                    <form action="{{ route('Recurly.checkout_page') }}" method="post">
                                        @csrf
                                        <input type="hidden" id="plan_name" name="recurly_plan_id" value="{{ $plan_name ?? '' }}">
                                        <button type="submit" class="btn bd btn1 btn-lg btn-block font-weight-bold text-white mt-3 processing_alert">
                                            {{ __('Pay Now') }}
                                        </button>
                                    </form>
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

    <?php
    $ref = Request::get('ref');
    $coupon = Request::get('coupon');
    ?>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('#submit-new-cat').click(function() {
                $('#payment-form').submit();
            });
        });
    </script>

    <div class="form-group row">
        <div class="col-md-12 text-center">
            <p class="mt-3 text-white">OR</p>
            <div class="mt-4 sign-up-buttons">
                <a type="button" href="<?php echo URL::to('/') . '/registerUser'; ?>" class="btn btn-secondary">
                    <?php echo __('Skip'); ?>
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

    <input type="hidden" id="base_url" value="<?php echo URL::to('/'); ?>">
    <input type="hidden" id="stripe_coupon_code" value="<?php echo NewSubscriptionCouponCode(); ?>">
    <input type="hidden" value="<?php echo DiscountPercentage(); ?>" id="discount_percentage" class="discount_percentage">
    <input type="hidden" value="<?php echo NewSubscriptionCoupon(); ?>" id="discount_status" class="discount_status">

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
        $("input[name='plan_name']").change(function() {
            var pid = $(this).val();
            var attr_price = $(this).attr('data-price');
            var discount_status = $("#discount_status").val();
            var plan_name_data = $(this).attr('data-name');

            $('#detail_name').html(plan_name_data);
            $('#detail_price').html(attr_price + " USD");

            if (discount_status == 1) {

                $('.coupon_enabled').css("display", "block");

                var stripe_coupon_code = $("#stripe_coupon_code").val();

                var discount = $("#discount_percentage").val();
                var discount_percentage = (attr_price / 100) * discount;
                var total_price = (attr_price - discount_percentage);
                $('#detail_stripe_coupon').html(stripe_coupon_code);
                $('#coupon_percentage').html(discount_percentage + " USD");
                $('#total_price').html(total_price + " USD");
            }
            $('.hide-box').css("display", "block");
            $('.hide-box').css("  transition-delay", "2s");

        });
    
        $("input[name='plan_name']").change(function() {
            var pid = $(this).val();
            var attr_price = $(this).attr('data-price');
            var discount_status = $("#discount_status").val();
            var plan_name_data = $(this).attr('data-name');

            $('#detail_name').html(plan_name_data);
            $('#detail_price').html(attr_price + " USD");

            if (discount_status == 1) {

                $('.coupon_enabled').css("display", "block");

                var stripe_coupon_code = $("#stripe_coupon_code").val();

                var discount = $("#discount_percentage").val();
                var discount_percentage = (attr_price / 100) * discount;
                var total_price = (attr_price - discount_percentage);
                $('#detail_stripe_coupon').html(stripe_coupon_code);
                $('#coupon_percentage').html(discount_percentage + " USD");
                $('#total_price').html(total_price + " USD");
            }
            $('.hide-box').css("display", "block");
            $('.hide-box').css("  transition-delay", "2s");
        });
    </script>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js'></script>

    <script>
        $(function() {
            $("#chkPassport").click(function() {
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
        $(function() {
            $("#chkPassports").click(function() {
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


    {{-- cinetpay  Payment Price --}}

    <input type="hidden" id="Cinetpay_Price" name="Cinetpay_Price" value=" ">

    {{--  Payment --}}
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
        function plan_details(ele) {

            var plans_id = $(ele).attr('data-plan_id');
            var plan_payment_type = $(ele).attr('data-payment-type');
            var plan_pay_type = $(ele).attr('data-pay-type');
            var plan_price = $(ele).attr('data-plan-price');
            var plan_id_class = $(ele).attr('data-plan-id');
            let currency_symbols = document.getElementById("currency_symbol").value;
            $('#paypal-button-container').empty();
            $('#paypal-button-container').hide();
           

            if(plan_pay_type == 'PayPal'){
                $('#paypal-button-container').show();
                $('.Stripe_Payment').show();
                var plans_id = $(ele).attr('data-plan_id');
                var plan_payment_type = $(ele).attr('data-payment-type');
                var plan_price = $(ele).attr('data-plan-price');
                var plan_id_class = $(ele).attr('data-plan-id');
                let currency_symbols = document.getElementById("currency_symbol").value;

                var classname = 'paypal-button-container-' + plans_id
                $('#paypal-button-container').addClass(classname)
                // $("#paypal-button-container").append('<div class:' + classname + ';></div>');
                $("#paypal-button-container").append('<div id="' + classname + '";></div>');

                $('#payment_type').replaceWith('<input type="hidden" name="payment_type" id="payment_type" value="' +
                    plan_payment_type + '">');
                $('#plan_name').replaceWith('<input type="hidden" name="plan_name" id="plan_name" value="' + plans_id + '">');
                $('.plan_price').empty(plan_price);
                $('.plan_price').append(plan_price);

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
                        label: 'subscribe'
                    },
                    createSubscription: function(data, actions) {
                        return actions.subscription.create({
                            plan_id: plans_id
                        });
                    },
                    onApprove: function(data, actions) {
                        // alert(data.subscriptionID); // You can add optional success message for the subscriber here
                        if (data.subscriptionID) {
                            $.post(base_url + '/paypal-subscription', {
                                    payment_type: payment_type,
                                    amount: final_payment,
                                    plan: plan_data,
                                    plans_id: plans_id,
                                    subscriptionID: data.subscriptionID,
                                    coupon_code: final_coupon_code_stripe,
                                    _token: '<?= csrf_token() ?>'
                                    userId: '{{ @$intent_stripe->id }}',
                                },

                                function(data) {
                                    $('#loader').css('display', 'block');
                                    swal({
                                        title: "Subscription Purchased Successfully!",
                                        text: "Your Payment done Successfully!",
                                        icon: payment_images + '/Successful_Payment.gif',
                                        buttons: false,
                                        closeOnClickOutside: false,
                                    });
                                    setTimeout(function() {
                                        window.location.replace(base_url + '/login');
                                    }, 2000);
                                });
                        }
                    }
                }).render('#paypal-button-container-'+plans_id);
                
            }
            else{
                $('#payment_type').replaceWith('<input type="hidden" name="payment_type" id="payment_type" value="' + plan_payment_type + '">');
                $('#plan_name').replaceWith('<input type="hidden" name="plan_name" id="plan_name" value="' + plans_id + '">');
                $('#Cinetpay_Price').replaceWith('<input type="hidden" name="Cinetpay_Price" id="Cinetpay_Price" value="' + plan_price + '">');
                $('.plan_price').empty(plan_price).append( plan_price);

                $('#coupon_amt_deduction').empty(plan_price);
                $('#coupon_amt_deduction').append(currency_symbols + plan_price);

                $('.dg').removeClass('actives');
                $('#' + plan_id_class).addClass('actives');
            }
           

        }
        var base_url = $('#base_url').val();
    </script>

    <script>
        window.onload = function() {
            $('#active1').addClass('actives');
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
    </script>


    <!-- paypay script -->

    <script src="https://www.paypal.com/sdk/js?client-id={{ $paypalClientId }}&vault=true&intent=subscription" data-sdk-integration-source="button-factory"></script>

    <script>
        // function paypalplan_details(ele) {
        //     var plans_id = $(ele).attr('data-plan_id');
        //     var plan_payment_type = $(ele).attr('data-payment-type');
        //     var plan_price = $(ele).attr('data-plan-price');
        //     var plan_id_class = $(ele).attr('data-plan-id');
        //     let currency_symbols = document.getElementById("currency_symbol").value;

        //     var classname = 'paypal-button-container-' + plans_id
        //     $('#paypal-button-container').addClass(classname)
        //     $("#paypal-button-container").append('<div class:' + classname + ';></div>');

        //     $('#payment_type').replaceWith('<input type="hidden" name="payment_type" id="payment_type" value="' +
        //         plan_payment_type + '">');
        //     $('#plan_name').replaceWith('<input type="hidden" name="plan_name" id="plan_name" value="' + plans_id + '">');
        //     $('.plan_price').empty(plan_price);
        //     $('.plan_price').append(currency_symbols + plan_price);

        //     $('.dg').removeClass('actives');
        //     $('#' + plan_id_class).addClass('actives');


        //     var plan_data = $("#plan_name").val();
        //     var coupon_code = $("#coupon_code").val();
        //     var payment_type = $("#payment_type").val();
        //     var final_payment = $(".final_payment").val();
        //     var final_coupon_code_stripe = $("#final_coupon_code_stripe").val();

        //     paypal.Buttons({
        //         style: {
        //             shape: 'pill',
        //             color: 'white',
        //             layout: 'vertical',
        //             label: 'subscribe'
        //         },
        //         createSubscription: function(data, actions) {
        //             return actions.subscription.create({
        //                 plan_id: plans_id
        //             });
        //         },
        //         onApprove: function(data, actions) {
        //             // alert(data.subscriptionID); // You can add optional success message for the subscriber here
        //             if (!empty(data.subscriptionID)) {
        //                 $.post(base_url + '/paypal-subscription', {
        //                         payment_type: payment_type,
        //                         amount: final_payment,
        //                         plan: plan_data,
        //                         plans_id: plans_id,
        //                         subscriptionID: data.subscriptionID,
        //                         coupon_code: final_coupon_code_stripe,
        //                         _token: '<?= csrf_token() ?>'
        //                     },

        //                     function(data) {
        //                         $('#loader').css('display', 'block');
        //                         swal({
        //                             title: "Subscription Purchased Successfully!",
        //                             text: "Your Payment done Successfully!",
        //                             icon: payment_images + '/Successful_Payment.gif',
        //                             buttons: false,
        //                             closeOnClickOutside: false,
        //                         });
        //                         setTimeout(function() {
        //                             window.location.replace(base_url + '/login');
        //                         }, 2000);
        //                     });
        //             }
        //         }
        //     }).render('#paypal-button-container-' + plans_id); // Renders the PayPal button
        // }
    </script>

    <script>
        $('.PaypalPayment').hide();
        $('.paypal_plan_details').hide();

        $(document).ready(function() {
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
                if ($(this).val() == 'paypal') {
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
        window.onload = function() {

            $('.paystack_payment,.stripe_payment,.Razorpay_payment,.cinetpay_button,.Paydunya_payment,.Recurly_payment,.PaypalPayment').hide();
            $('.Summary').empty();

            // $(".payment_gateway").trigger("click")

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

                } else if (payment_gateway == "paypal") {

                    $('.PaypalPayment').show();

                }
                else if (payment_gateway == "Recurly") {

                    $('.Recurly_payment').show();
                }
            });
        });
    </script>

            {{-- BecomeSubscriber_Plans --}}
     <script>
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
                        html += '<div class="col-md-12  p-0">';
                        html += '<div class="row align-items-center m-0 p-0 data-plans">';

                        $.each(response.data.plans_data, function(index, plan_data) {

                            html +=
                                '<a href="#payment_card_scroll" > <div class="col-md-6 plan_details p-0"  data-plan-id="active' + plan_data.id + '" data-plan-price="' + plan_data.price +
                                    '"  data-plan_id="' + plan_data.plan_id + '"  data-payment-type="' +  plan_data.payment_type + '"  data-pay-type="' +  plan_data.type + '" onclick="plan_details(this)">';
                            html += '<div class="row dg align-items-center mb-4" id="active' +plan_data.id + '" >';

                            html += '<div class="col-md-12 ambk p-0 text-center">';
                                html += '<div>';
                                    html += '<h6 class="font-weight-bold">  ' + plan_data.plans_name +'   </h6>';
                                    html += '<p class="text-white mb-0">' + plan_data.price +' Membership </p>';
                                html += '</div>';
                            html += '</div>';

                            html += '<div class="col-md-12 blk" >' + plan_data.plan_content + '</div>';

                            html += '</div>';
                            html +=' <div class="d-flex justify-content-between align-items-center " > <div class="bgk"></div> </div></a>';
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

    <!-- Cinetpay Payment -->
    <script src="https://cdn.cinetpay.com/seamless/main.js"></script>

    <script>
        function cinetpay_checkout() {

            let Cinetpay_Price = $('#Cinetpay_Price').val();
            let plan_name = $("#plan_name").val();
            var user_name = '{{ @$intent_stripe->username }}';
            var email = '{{ @$user_mail }}';
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
                customer_country: "CI, BF, US, CA, FR", // the ISO code of the country
                customer_state: "CM,CA,US", // the ISO state code
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

                        console.log( data );

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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('#successMessage').fadeOut('fast');
            }, 3000);
        })
    </script>
    @php
        include public_path('themes/default/views/footer.blade.php');
    @endphp

@endsection
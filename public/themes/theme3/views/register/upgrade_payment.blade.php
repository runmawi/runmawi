@extends('layouts.app')

@php
    include public_path('themes/theme3/views/header.php');
@endphp

@section('content')

    <script
        src="https://www.paypal.com/sdk/js?client-id=Aclkx_Wa7Ld0cli53FhSdeDt1293Vss8nSH6HcSDQGHIBCBo42XyfhPFF380DjS8N0qXO_JnR6Gza5p2&vault=true&intent=subscription"
        data-sdk-integration-source="button-factory">
    </script>

    <style>
        .round {
            background-color: #8a0303 !important;
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

        .toggle {
            display: flex;
            justify-content: space-between;
            width: 43%;
            align-items: center;
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
            margin-bottom: 35px;
        }

        #card-element {
            height: 50px;
            background: #f4f6f7;
            padding: 10px;
            border-radius:50px;
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
            height: 200px;
            padding: 10px;
        }

        .ambk {
            background-color: #000;
            padding: 10px !important;
        }
    </style>

    <!-- stepper -->
<style>
    .steps-wrapper {
        display: flex;
        flex-direction: row-resize;
        justify-content: end;
        align-items: center;
        direction: rtl;

        padding: 8px;
    }

    .steps-wrapper .step {
        display: flex;
        align-items: center;

        transition: all ease-in-out 0.2s;
    }

    .step .step-circle {
        width: 25px;
        height: 25px;

        border-radius: 50%;
        border: 6px solid #FF26F6;

        background-color: #fff;
    }

    .step.complete .step-circle {
        background-color: #FF26F6;
    }

    .step.complete ~ .step .step-circle {
        background-color: #FF26F6;
    }

    .step .step-line {
        width: 50px;
        border: 3px solid #FF26F6;
    }
    .plan-card .card {
        border-radius: 1.25rem;
        background-color: #FF26F6;
        border: 3px solid #fff;
    }
    a.text-primary {
        background: #fff;
        padding: 0px 28px;
        border-radius: 26px;
    }
    .input-details{
        width:100%;
        border-radius:35px !important;
        padding:0 27px !important;
    }
    .input-details::placeholder{
        color: #000 !important;
    }
    .details-fields .row{
        margin-bottom:20px;
    }
    .about-plan p{
        font-size:18px;
        line-height:30px;
    }
    .col-sm-4.submit-button button {
        width: 100%;
        border-radius: 35px;
        padding: 14px;
        font-size: 21px;
    }
    .card-body ul li{
        color:white;
    }
    input[type="text"]{
        border-radius:50px !important;
    }
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

        // label
        $stripe_label = App\PaymentSetting::where('payment_type', 'Stripe')->pluck('stripe_lable')->first() ? App\PaymentSetting::where('payment_type', 'Stripe')->pluck('stripe_lable')->first() : 'Stripe';
        $paypal_label = App\PaymentSetting::where('payment_type', 'PayPal')->pluck('paypal_lable')->first() ? App\PaymentSetting::where('payment_type', 'PayPal')->pluck('paypal_lable')->first() : 'PayPal';
        $paystack_label = App\PaymentSetting::where('payment_type', 'Paystack')->pluck('paystack_lable')->first() ? App\PaymentSetting::where('payment_type', 'Paystack')->pluck('paystack_lable')->first() : 'paystack';
        $Razorpay_label = App\PaymentSetting::where('payment_type', 'Razorpay')->pluck('Razorpay_lable')->first() ? App\PaymentSetting::where('payment_type', 'Razorpay')->pluck('Razorpay_lable')->first() : 'Razorpay';
        $CinetPay_lable = App\PaymentSetting::where('payment_type', 'CinetPay')->pluck('CinetPay_Lable')->first() ? App\PaymentSetting::where('payment_type', 'CinetPay')->pluck('CinetPay_Lable')->first() : 'CinetPay';
        $Paydunya_label = App\PaymentSetting::where('payment_type','Paydunya')->pluck('paydunya_label')->first() ? App\PaymentSetting::where('payment_type','Paydunya')->pluck('paydunya_label')->first() : "Paydunya";
        
        $CurrencySetting = App\CurrencySetting::pluck('enable_multi_currency')->first();
    @endphp



    <!-- <section>
    
    <div class="container-fluid mb-5">
        <div class="steps-wrapper pl-0 mb-3">
            <div class="step complete" data-step="3">
                <div class="step-circle" style="background:transparent;"></div>
                <div class="step-line"></div>
            </div>

            <div class="step" data-step="2">
                <div class="step-circle"></div>
                <div class="step-line"></div>
            </div>

            <div class="step" data-step="1">
                <div class="step-circle"></div>
            </div>
        </div>

        <h4><?= "Choose the right plan for you" ?></h4>

        <div class="plan-card">
            <div class="row">
                <div class="col-sm-4">
                    <div class="card" >
                        <div class="card-body">
                            <h5 class="card-title"><?= "Pay Monthly" ?></h5>
                            <p class="card-text"><?= "Rolling month to month" ?></p>
                            <div class="d-flex justify-content-between align-items-end mt-3">
                                <h5>{{ '$7.99' }}</h5>
                                <a href="#payment_card_scroll_dummy" class="text-primary">choose</a>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card" >
                        <div class="card-body">
                            <h5 class="card-title">Pay annually</h5>
                            <p class="card-text"><?= "Full year subscription" ?></p>
                            <div class="d-flex justify-content-between align-items-end mt-3">
                                <span>
                                    <h5>{{ '$7.99' }}</h5>
                                    <p class="font-size-12 m-0">{{ "single payment" }}</p>
                                </span>
                                <a href="#payment_card_scroll_dummy" class="text-primary">choose</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="steps-wrapper payment-sec pl-0 mb-3" id="payment_card_scroll_dummy">
            <div class="step complete" data-step="3">
                <div class="step-circle"></div>
                <div class="step-line"></div>
            </div>

            <div class="step" data-step="2">
                <div class="step-circle"></div>
                <div class="step-line"></div>
            </div>

            <div class="step" data-step="1">
                <div class="step-circle"></div>
            </div>
        </div>
        <h4><?= "Choose the right plan for you" ?></h4>
        <div class="details-fields mt-5 mb-5">
            <div class="row">
                <div class="col-sm-4">
                    <input class="input-details" type="text" placeholder="First name">
                </div>
                <div class="col-sm-4">
                    <input class="input-details" type="text" placeholder="Expiry date (MM/YY)">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <input class="input-details" type="text" placeholder="Last name">
                </div>
                <div class="col-sm-4">
                    <input class="input-details" type="text" placeholder="Security code(CVV)">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <input class="input-details" type="text" placeholder="Card Number">
                </div>
                <div class="col-sm-4">
                    <input class="input-details" type="text" >
                </div>
            </div>
        </div>


        <div class="col-sm-8 mb-5">
            <div class="about-plan">
                <p>{{ "A subscription plan is a purchase option. A subscription plan lets you choose how often a product can be delivered. This is called “delivery frequency” For example, weekly delivery. A subscription plan also gives you the ability to add a percentage discount." }}</p>
            </div>
        </div>

        <div class="col-sm-4 submit-button">
            <button class="btn-primary" type="submit">{{ "Start paid membership" }}</button>
        </div>


    </div>


</section> -->















    <section class="flick p-4">
        <div class="container">
            <div align="center"></div>
            <div class="row ">
                <div class="col-lg-8 col-md-6 p-0">
                    <div class="flick1">
                        
                        <div class="steps-wrapper pl-0 mb-3">
                            <div class="step complete" data-step="3">
                                <div class="step-circle" style="background:transparent;"></div>
                                <div class="step-line"></div>
                            </div>

                            <div class="step" data-step="2">
                                <div class="step-circle"></div>
                                <div class="step-line"></div>
                            </div>

                            <div class="step" data-step="1">
                                <div class="step-circle"></div>
                            </div>
                        </div>

                        <p class="" style="font-size: 16px;">Welcome {{ Auth::user()->username ? Auth::user()->username : ' ' }}, </p>
                        
                        <h6 class="medium-heading  pb-3"> {{ $signup_step2_title }} </h6>

                        <div class="col-md-12 p-0">
                            <p class="meth"> Payment Method</p>
                            <div class="d-flex">

                                            <!-- Stripe -->

                                @if (!empty($Stripe_payment_settings) && $Stripe_payment_settings->stripe_status == 1)
                                    <div class="align-items-center ">
                                        <input type="radio" id="stripe_radio_button" class="payment_gateway" name="payment_gateway" value="stripe">
                                        <label class="ml-2"><p> {{ $stripe_label }} </p> </label> <br />
                                    </div>
                                @endif
                                
                                            <!-- Razorpay -->

                                @if (!empty($Razorpay_payment_settings) && $Razorpay_payment_settings->status == 1)
                                    <div class="align-items-center  ml-2">
                                        <input type="radio" id="Razorpay_radio_button" class="payment_gateway" name="payment_gateway" value="Razorpay">
                                        <label class="ml-2"> <p> {{ $Razorpay_label }} </p></label><br />
                                    </div>
                                @endif

                                            <!-- Paystack -->

                                @if (!empty($Paystack_payment_settings) && $Paystack_payment_settings->status == 1)
                                    <div class=" align-items-center ml-2">
                                        <input type="radio" id="paystack_radio_button" class="payment_gateway"  name="payment_gateway" value="paystack">
                                        <label class="mt-2 ml-2"><p>{{ $paystack_label }} </p></label> <br />
                                    </div>
                                @endif

                                            <!-- PayPal -->

                                @if (!empty($PayPal_payment_settings) && $PayPal_payment_settings->paypal_status == 1)
                                    <div class="align-items-center  ml-2">
                                        <input type="radio" id="paypaul_radio_button" class="payment_gateway" name="payment_gateway" value="paypal">
                                        <label class="mt-2 ml-2"><p>{{ $paypal_label }} </p> </label> <br />
                                    </div>
                                @endif
                                            <!-- CinetPay -->

                                @if (!empty($CinetPay_payment_settings) && $CinetPay_payment_settings->CinetPay_Status == 1)
                                    <div class=" align-items-center ml-2">
                                        <input type="radio" id="cinetpay_radio_button" class="payment_gateway" name="payment_gateway" value="CinetPay">
                                        <label class=" ml-2"><p>{{ $CinetPay_lable }} </p></label><br />
                                    </div>
                                @endif
                                
                                     {{-- Paydunya --}}
                                @if(!empty($Paydunya_payment_settings) && $Paydunya_payment_settings->paydunya_status == 1)
                                    <div class=" align-items-center ml-2">
                                        <input type="radio" id="paydunya_radio_button" class="payment_gateway" name="payment_gateway" value="Paydunya" >
                                        <label class=" ml-2"> <p>{{ __($Paydunya_label) }} </p></label> 
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="plan-card">
                            <div class="row">
                                <div class="col-lg-6 col-12">
                                    @foreach ($plans_data_signup_checkout as $key => $plan)
                                        <div class="card" >
                                            <div class="card-body">
                                                <h5 class="card-title"> {{ $plan->plans_name }} </h5>
                                                <p class="card-text">{!! html_entity_decode($plan->plan_content) !!} </p>
                                                <div class="d-flex justify-content-between align-items-end mt-3">
                                                    <h5>{{ $CurrencySetting == 1 ? Currency_Convert($plan->price) : currency_symbol(). $plan->price }} Membership</h5>
                                                    <a href="#payment_card_scroll" class="text-primary">choose</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>





                        <div class="row col-12 mt-4">
                            <!-- <div class="col-md-12">
                                <div class="data-plans row align-items-center p-0">
                                    @foreach ($plans_data_signup_checkout as $key => $plan)

                                        @php
                                            $plan_name = $plan->plans_name;
                                        @endphp

                                        <div style="" class="col-md-4 plan_details p-0" data-plan-id="{{ 'active' . $plan->id }}" data-plan-price="{{ $CurrencySetting == 1 ? (Currency_Convert($plan->price)) : currency_symbol().$plan->price }}"
                                            data-plan_id={{ $plan->plan_id }} data-payment-type={{ $plan->payment_type }} onclick="plan_details(this)">


                                            <a href="#payment_card_scroll">

                                                <div class="row dg align-items-center mb-4" id={{ 'active' . $plan->id }}>
                                                    <div class="col-md-12 ambk p-0 text-center">
                                                        <div>
                                                            <h6 class=" font-weight-bold"> {{ $plan->plans_name }} </h6>
                                                            <p class="text-white mb-0"> {{ $CurrencySetting == 1 ? Currency_Convert($plan->price) : currency_symbol(). $plan->price }} Membership</p>
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
                            </div> -->

                                <div class="steps-wrapper payment-sec pl-0 mb-3" id="payment_card_scroll_dummy">
                                    <div class="step complete" data-step="3">
                                        <div class="step-circle"></div>
                                        <div class="step-line"></div>
                                    </div>

                                    <div class="step" data-step="2">
                                        <div class="step-circle"></div>
                                        <div class="step-line"></div>
                                    </div>

                                    <div class="step" data-step="1">
                                        <div class="step-circle"></div>
                                    </div>
                                </div>
                                
                                
                <div class="col-md-12" id="payment_card_scroll">
                    <div class="cont stripe_payment" >
                        <!-- <div class="d-flex justify-content-between align-items-center">
                             <div>
                                 <h3>{{ __('Payment') }}</h3>
                             </div>

                            <div>
                                <label for="fname">{{ __('Accepted Cards') }}</label>
                                <div class="icon-container">
                                     <i class="fa fa-cc-visa" style="color: navy;"></i>
                                     <i class="fa fa-cc-amex" style="color: blue;"></i>
                                     <i class="fa fa-cc-mastercard" style="color: red;"></i>
                                     <i class="fa fa-cc-discover" style="color: orange;"></i>
                                </div>
                            </div>
                        </div> -->

                        <div class="mt-3"></div>

                        <!-- <label for="fname"><i class="fa fa-user"></i> {{ __('Full Name') }}</label> -->
                        <!-- <div class="d-flex col-12 p-0">
                            <div class="col-6 p-0">
                                <input id="card-holder-name" type="text" class="form-control" placeholder="Card Holder Name">
                            </div>
                            <div class="col-6">
                                <div id="card-element" style=""></div>
                            </div>
                           
                            
                        </div> -->
                        <!-- Stripe Elements Placeholder -->
                        <!-- <label for="ccnum"> {{ __('Card Number') }}</label> -->
                        <!-- <div id="card-element" style=""></div> -->

                        <!-- @if( get_coupon_code() == 1)
                            <div class="mt-3">
                                <label for="fname"  style="float: right; " data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"  class="promo"> {{ __('Add Promotion Code') }} </label>
                               <div class="collapse show" id="collapseExample">
                                    <div class="row p-0">
                                        <div class="col-lg-6 p-0">
                                            <input id="coupon_code_stripe" type="text" class="form-control" placeholder="{{ __('Add Promotion Code') }}"  style="height:41px;">
                                            <input id="final_coupon_code_stripe" name="final_coupon_code_stripe" type="hidden" >
                                        </div>
                                        <div class="col-lg-6 p-0"><a type="button" id="couple_apply" class="btn round btn-lg">{{ __('Apply') }}</a></div>
                                        <span id="coupon_message"></span>

                                        @if( NewSubscriptionCouponCode() != '0' )
                                            <span id="">  {{ "Recommend a Coupon Code for you - " . NewSubscriptionCouponCode() }} </span>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        @endif -->

                    </div>

                
                    <h4>{{ __('Summary') }}</h4>

                    <div class="bg-white mt-4 dgk">
                        <h4> {{ __('Due today') }}: <span class='plan_price'> {{ $SubscriptionPlan ? currency_symbol().$SubscriptionPlan->price : currency_symbol().'0:0' }} </span> </h4>
                        
                        @if( get_coupon_code() == 1)
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <div class="stripe_payment">
                                    <p class="text-black"> {{ __('Amount Deducted for Promotion Code') }}   </p>
                                    <p class="text-black"> {{ __('Payable Amount') }}   </p>
                                </div>

                                <div class="stripe_payment" >
                                    <p id="promo_code_amt" class="text-black"> {{  currency_symbol().'0'  }} </p>
                                    <p id="coupon_amt_deduction" class="text-black"> {{ $SubscriptionPlan ? currency_symbol().$SubscriptionPlan->price : currency_symbol().'0:0'  }} </p>
                                </div>
                            </div>
                        @endif

                        <hr/>
                        {{-- <h6 class="text-black text-center font-weight-bold">{{ __('You will be charged $56.99 for an annual membership on 05/18/2022. Cancel anytime.') }}</h6> --}}
                        <p class="text-center text-black mt-3">{{ __('All state sales taxes apply') }}</p>
                    </div>
                    <div class="col-md-12 mt-5" id="paypal_card_payment">
                    </div>
                    <p class="text-white mt-3 dp">
                            {{ $signup_payment_content ? $signup_payment_content : " " }}
                    </p>
                </div>



                                                {{-- Summary --}}
                            <!-- <div class="col-md-12 mt-5" id="payment_card_scroll">

                                <h4>Summary</h4>

                                <div class="bg-white mt-4 dgk">
                                    <h4> Due today: 
                                        <span class='plan_price Summary'>

                                            @if (  $CurrencySetting == 1 && $SubscriptionPlan )
                                                {{Currency_Convert($SubscriptionPlan->price) }}
                                            @elseif($SubscriptionPlan )
                                                {{  currency_symbol() . $SubscriptionPlan->price  }}
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
                            </div> -->

                                                {{-- Payment Buttons --}}
                           
                            {{-- Stripe --}}  
                            <div class="col-md-12 stripe_payment">
                                <button type="submit" class="btn btn-primary btn1 btn-lg btn-block font-weight-bold text-white mt-3 stripe_button processing_alert"> Pay Now</button>
                            </div>
                           

                            {{-- Razorpay --}}
                            <!-- <div class="col-md-12 Razorpay_payment">
                                <button type="submit"
                                    class="btn1 btn-lg btn-block font-weight-bold text-white mt-3 Razorpay_button processing_alert">
                                    Pay Now
                                </button>
                            </div> -->

                            {{-- Paystack --}}
                            <!-- <div class="col-md-12 paystack_payment">
                                <button type="submit"
                                    class="btn1 btn-lg btn-block font-weight-bold text-white mt-3 paystack_button processing_alert">
                                    Pay Now
                                </button>
                            </div> -->

                            {{-- CinetPay --}}
                            <!-- <div class="col-md-12 cinetpay_payment">
                                <button onclick="cinetpay_checkout()" data-subscription-price='100' type="submit"
                                    class="btn1 btn-lg btn-block font-weight-bold text-white mt-3 cinetpay_button">
                                    Pay Now
                                </button>
                            </div> -->

                            {{-- Paydunya --}}
                            <!-- <div class="col-md-12 Paydunya_payment">
                                <button  type="submit" class="btn1 btn-lg btn-block font-weight-bold text-white mt-3 Paydunya_button processing_alert" >
                                    {{ __('Pay Now') }}
                                </button>
                            </div> -->

                            <input type="hidden" id="payment_image" value="<?php echo URL::to('/') . '/public/Thumbnai_images'; ?>">
                            <input type="hidden" id="currency_symbol" value="{{ currency_symbol() }}">
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

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

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
    function plan_details(ele){
        var plans_id          = $(ele).attr('data-plan_id');
        var plan_payment_type = $(ele).attr('data-payment-type');
        var plan_price        = $(ele).attr('data-plan-price');
        var plan_id_class     = $(ele).attr('data-plan-id');
        let currency_symbols  =  document.getElementById("currency_symbol").value ;
        var selectedOption = $('input[name="payment_gateway"]:checked').val();

        $('#payment_type').replaceWith('<input type="hidden" name="payment_type" id="payment_type" value="'+ plan_payment_type+'">');
        $('#plan_name').replaceWith('<input type="hidden" name="plan_name" id="plan_name" value="'+ plans_id +'">');
        $('#Cinetpay_Price').replaceWith('<input type="hidden" name="Cinetpay_Price" id="Cinetpay_Price" value="'+ plan_price +'">');
        $('.plan_price').empty(plan_price);
        $('.plan_price').append( currency_symbols+plan_price );

        $('#coupon_amt_deduction').empty(plan_price);
        $('#coupon_amt_deduction').append( currency_symbols+plan_price );

        $('.dg' ).removeClass('actives');
        $('#'+plan_id_class ).addClass('actives');


        
    //   PayPal Payment Gateway

        if (selectedOption == 'paypal') {
            $('#paypal_card_payment').show();

            var dynamicPlanId = getDynamicPlanId(selectedOption, plans_id);
            var dynamicContainerId = 'paypal-button-container-' + dynamicPlanId;
            $('#paypal_card_payment').empty();
            var newContainerDiv = $('<div id="' + dynamicContainerId + '"></div>');
            // Append the new container to the specified parent container
            $('#paypal_card_payment').append(newContainerDiv);

            paypal.Buttons({
                style: {
                    shape: 'rect',
                    color: 'gold',
                    layout: 'vertical',
                    label: 'subscribe'
                },
                createSubscription: function (data, actions) {
                    return actions.subscription.create({
                        /* Creates the subscription */
                        plan_id: dynamicPlanId
                    });
                },
                onApprove: function (data, actions) {
                    // alert(data.subscriptionID); 
                    var subId = data.subscriptionID;

                    $.ajax({
                        url: '{{ URL::to('upgradepaypalsubscription') }}',
                        method: 'post',
                        data: {
                            _token: '{{ csrf_token() }}',
                            plan_id: dynamicPlanId,
                            subId: subId,
                        },
                        success: (response) => {
                            alert("You have done  Payment !");
                            console.log("Server response:", response);

                            setTimeout(function() {
                                window.location.replace(base_url+'/home');
                        }, 2000);

                        },
                        error: (error) => {
                            swal('error');
                        }
                    })
                  
                }
            }).render('#' + dynamicContainerId); 
        }else{
            $('#paypal_card_payment').hide();
        }
      
    }    

    function getDynamicPlanId(selectedOption, plans_id) {
       if (selectedOption === 'paypal') {
        return plans_id;
    } else {
        return 'default_plan_id';
    }
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
            window.location = base_url+'/becomesubscriber';
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

            $.ajax({
                url: "{{ route('become_subscriber') }}",
                type: "get",
                data: {
                        _token  : '{{ csrf_token() }}',
                        py_id   :  py_id, 
                        plan    : plan_data,
                        amount  : final_payment,
                        stripToken   : stripToken, 
                        payment_type : payment_type, 
                        coupon_code  : final_coupon_code_stripe,
                    },       
                    success: function(data){
                        if(data.status == "true"){
                            $('#loader').css('display','block');
                                swal({
                                    title: "Subscription Purchased Successfully!",
                                    text: data.message,
                                    icon: payment_images+'/Successful_Payment.gif',
                                    buttons: false,      
                                    closeOnClickOutside: false,
                                });
                                    $("#card-button").html('Pay Now');
                                setTimeout(function() {
                                    window.location.replace(base_url+'/login');
                            }, 2500);
                        }
                        else{
                            $('#loader').css('display','block');
                                swal({
                                    title: "Payment Failed!",
                                    text: data.message,
                                    icon: payment_images+'/fails_Payment.avif',
                                    buttons: false,      
                                    closeOnClickOutside: false,
                                });
                                    $("#card-button").html('Pay Now');
                                setTimeout(function() {
                                    location.reload();
                            }, 5000);
                        }
                    } });
            });
        }
    });

</script>



    <script>
        function plan_details(ele) {

            var plans_id = $(ele).attr('data-plan_id');
            var plan_payment_type = $(ele).attr('data-payment-type');
            var plan_price = $(ele).attr('data-plan-price');
            var plan_id_class = $(ele).attr('data-plan-id');
            let currency_symbols = document.getElementById("currency_symbol").value;

            $('#payment_type').replaceWith('<input type="hidden" name="payment_type" id="payment_type" value="' + plan_payment_type + '">');
            $('#plan_name').replaceWith('<input type="hidden" name="plan_name" id="plan_name" value="' + plans_id + '">');
            $('#Cinetpay_Price').replaceWith('<input type="hidden" name="Cinetpay_Price" id="Cinetpay_Price" value="' + plan_price + '">');
            $('.plan_price').empty(plan_price);
            $('.plan_price').append( plan_price);

            $('#coupon_amt_deduction').empty(plan_price);
            $('#coupon_amt_deduction').append( plan_price);

            $('.dg').removeClass('actives');
            $('#' + plan_id_class).addClass('actives');

        }

        var base_url = $('#base_url').val();

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
                                '"  data-payment-type="' + plan_data.payment_type +
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

            $('.paystack_payment,.stripe_payment,.Razorpay_payment,.cinetpay_button,.Paydunya_payment').hide();
            $('.Summary').empty();

            $("#stripe_radio_button").attr('checked', true);

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

        };

        $(document).ready(function() {

            $(".payment_gateway").click(function() {

                $('.paystack_payment,.stripe_payment,.Razorpay_payment,.cinetpay_button,.Paydunya_payment').hide();
                
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


    @php
        include public_path('themes/theme3/views/footer.blade.php');
    @endphp

@endsection

@extends('layouts.app')

@include('Channel.header')

@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <style>
        .round { background-color: #8a0303 !important;color: #fff !important;padding: 14px 20px;}
        #coupon_code_stripe {background-color: #ddd;}
        * {box-sizing: border-box;}
        .collapsed {font-size: 18px !important;}
        .promo {font-size: 18px;}
        .columns {float: left;width: 25%;padding: 8px;} 

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
            background: {{ $button_bg_color . '!important' }};
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
            border: {{ '5px solid' . $button_bg_color . '!important' }};
        }

        .dg:hover {
            transition: 0.5s;
            color: #000 !important;
            border: {{ '5px solid' . $button_bg_color . '!important' }};
        }

        .cont {
            background-color: #232c30;
            padding: 36px 47px 70px;
            margin-bottom: 35px;
        }

        #card-button {
            background-color: {{ $button_bg_color . '!important' }};
        }

        .blk li {
            font-size: 14px;
        }

        .blk p {
            font-size: 14px;
        }

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
   

    <section class="flick">
        
        <div class="col-sm-12">
            <a href="{{ route('home') }}">
                <svg style="{{ 'color:'. front_End_text_color() }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="64" height="64" fill="currentColor"><path d="M12 2C17.52 2 22 6.48 22 12C22 17.52 17.52 22 12 22C6.48 22 2 17.52 2 12C2 6.48 6.48 2 12 2ZM12 20C16.42 20 20 16.42 20 12C20 7.58 16.42 4 12 4C7.58 4 4 7.58 4 12C4 16.42 7.58 20 12 20ZM12 11H16V13H12V16L8 12L12 8V11Z"></path></svg>
            </a>
        </div>

        <div class="container">
            <div align="center"></div>
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-7">
                    <div class="flick1">
                        <div class="small-heading text-white">Step 2 of <span class="ml-2">2</span></div>
                        <p class="text-white">Hello, {{ Session::get('email_id') }}</p>
                        <div class="medium-heading text-white"> {{ !is_null($SiteTheme) &&  !is_null($SiteTheme->signup_channel_title) ? $SiteTheme->signup_channel_title : null  }} </div>
                        <div class="col-md-12 p-0 mt-2">

                            <div class="d-flex">

                                <!-- Stripe -->
                                @if (!empty($Stripe_payment_settings) && $Stripe_payment_settings->stripe_status == 1)
                                    <div class=" align-items-center ml-2">
                                        <input type="radio" id="stripe_radio_button" class="payment_gateway" name="payment_gateway" value="stripe" checked>
                                        <label class=" ml-2"> <p>{{ $stripe_lable }} </p> </label>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="data-plans row align-items-center m-0 p-0">
                                    @foreach ($subscriptions_plans as $key => $plan)

                                        <div style="" class="col-md-6 plan_details p-0" data-active-status={{ 'active' . $plan->id }} data-plan-price="{{ $CurrencySetting == 1 ? Currency_Convert($plan->price) : $currency_symbol. round($plan->price,2) }}"
                                            data-plan_id={{ $plan->plan_id }} data-payment-type={{ $plan->payment_type }} onclick="plan_details(this)">

                                            <a href="#payment_card_scroll">
                                                <div class="row dg align-items-center mb-4" id={{ 'active' . $plan->id }}>
                                                    <div class="col-md-12 ambk p-0 text-center">
                                                        <div>
                                                            <h6 class=" font-weight-bold"> {{ $plan->plans_name }} </h6>
                                                            <p class="text-white mb-0">
                                                                {{ $CurrencySetting == 1 ? Currency_Convert($plan->price) : $currency_symbol. round($plan->price,2) }} Membership</p>
                                                                
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 blk"> 
                                                        <p>@php echo 'Video Upload Limit : ' . (!empty($plan->upload_video_limit) ? $plan->upload_video_limit : '∞'); @endphp</p>
                                                        <p>@php echo 'Audio Upload Limit : ' . (!empty($plan->upload_audio_limit) ? $plan->upload_audio_limit : '∞'); @endphp</p>
                                                        <p>@php echo 'LiveStream Upload Limit : ' . (!empty($plan->upload_live_limit) ? $plan->upload_live_limit : '∞'); @endphp</p>
                                                        <p>@php echo 'Episode Upload Limit : ' . (!empty($plan->upload_episode_limit) ? $plan->upload_episode_limit : '∞'); @endphp</p>
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
                                    <h4> Due today: 
                                        <span class='plan_price Summary'>
                                            {{-- {{ $SubscriptionPlan ? $currency_symbol . round($SubscriptionPlan->price,2) : $currency_symbol . '0:0' }} --}}
                                        </span>
                                    </h4>
                                    <hr />
                                    <p class="text-center mt-3">All state sales taxes apply</p>
                                </div>

                                <p class="text-white mt-3 dp">
                                    {{ !is_null($SiteTheme) && !is_null($SiteTheme->signup_payment_content) ? $SiteTheme->signup_payment_content : 'By Clicking on Paynow & Start' }}
                                </p>

                                {{-- Stripe --}}
                                <div class="col-md-12 stripe_payment">
                                    <button type="submit"
                                        class="btn1 btn-lg btn-block font-weight-bold text-white mt-3 stripe_button processing_alert">
                                        Pay Now
                                    </button>
                                </div>

                                <input type="hidden" id="plan_id" name="plan_id" >
                                <input type="hidden" id="payment_image" value="<?php echo URL::to('/') . '/public/Thumbnai_images'; ?>">
                                <input type="hidden" id="currency_symbol" value="{{ $currency_symbol }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
  
    <script>
          // Processing Alert 
        var payment_images = $('#payment_image').val();

        function plan_details(ele) {

            let plan_price = $(ele).attr('data-plan-price');
            let plans_id = $(ele).attr('data-plan_id');
            let currency_symbols = document.getElementById("currency_symbol").value;
            let active_status = $(ele).attr('data-active-status');

            $('.stripe_payment').show();

            $('.plan_price').empty(plan_price).append( plan_price);
            $('#plan_id').replaceWith('<input type="hidden" name="plan_id" id="plan_id" value="' + plans_id + '">');

            $('.dg').removeClass('actives');
            $('#' + active_status).addClass('actives');
        }

            // Stripe Payment 

        $(".stripe_button").click(function() {

            var Stripe_Plan_id = $("#plan_id").val();

            $.ajax({
                url: "{{ route('Channel_Stripe_authorization_url') }}",
                beforeSend: function () {
                    swal({
                        title: "Loading...",
                        text: "Please wait",
                        icon: payment_images + '/Loading.gif',
                        buttons: false,
                        closeOnClickOutside: false,
                        closeOnEsc: false,
                    });
                },
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
  
        $(document).ready(function() {
            $('.stripe_payment').hide();
            setTimeout(function() {
                $('#successMessage').fadeOut('fast');
            }, 3000);
        })
    </script>

    @php include public_path($footer_url); @endphp

@endsection
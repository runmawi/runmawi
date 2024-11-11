@extends('layouts.app')

@php 
    include(public_path("themes/{$current_theme}/views/header.php")); 
@endphp

@section('content')

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

    <section class="flick">

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

        <div class="col-sm-12">
            <a href="{{ route('home') }}">
                <svg style="{{ 'color:' . front_End_text_color() }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="64" height="64" fill="currentColor">
                    <path  d="M12 2C17.52 2 22 6.48 22 12C22 17.52 17.52 22 12 22C6.48 22 2 17.52 2 12C2 6.48 6.48 2 12 2ZM12 20C16.42 20 20 16.42 20 12C20 7.58 16.42 4 12 4C7.58 4 4 7.58 4 12C4 16.42 7.58 20 12 20ZM12 11H16V13H12V16L8 12L12 8V11Z"></path>
                </svg>
            </a>
        </div>

        <div class="container">
            <div align="center"></div>
            
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-7">
                    <div class="flick1">

                        <div class="small-heading text-white">Step 2 of 2 </div>
                            
                            {{-- User Name --}}
                        @guest
                            <p class="text-white">Hello, Guest</p>
                        @else
                            <p class="text-white">Hello, {{ auth()->user()->username }}</p>
                        @endguest

                        <div class="medium-heading text-white"> {{ @$SiteTheme->signup_step2_title }} </div>

                        <div class="col-md-12 p-0 mt-2">
                            <div class="d-flex">

                                <!-- Stripe -->
                                @if (!empty($Stripe_payment_settings) && $Stripe_payment_settings->stripe_status == 1)
                                    <div class=" align-items-center ml-2">
                                        <input type="radio" id="stripe_radio_button" class="payment_gateway" name="payment_gateway" value="stripe" checked>
                                        <label class=" ml-2"> <p>{{ ( $Stripe_payment_settings->stripe_lable  ? $Stripe_payment_settings->stripe_lable : "Pay vai Stripe") }} </p> </label>
                                    </div>
                                @endif

                                    {{-- Recurly --}}
                                @if(!empty($recurly_payment_settings) && $recurly_payment_settings->recurly_status == 1)
                                    <div class=" align-items-center ml-2">
                                        <input type="radio" id="recurly_radio_button" class="payment_gateway" name="payment_gateway" value="Recurly" >
                                        <label class=" ml-2"> <p>{{ ucwords( $recurly_payment_settings->recurly_label ? $recurly_payment_settings->recurly_label : "Pay vai Recurly") }} </p></label> 
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="data-plans row align-items-center m-0 p-0">
                                    @forelse ($plans_data as $item)
                                        <div style="" class="col-md-6 plan_details p-0">
                                            <a href="#payment_card_scroll" onclick="updatePaymentAmount('{{ $item->price }}', '{{ $item->plan_id }}' , '{{ $item->paymentGateway }}' )">
                                                <div class="row dg align-items-center mb-4">

                                                    <div class="col-md-7 p-0">
                                                        <h5 class=" font-weight-bold"> {{ @$item->price }} </h5>
                                                        <p>{{ html_entity_decode(@$item->plan_content) }} </p>
                                                    </div>

                                                    <div class="vl "></div>

                                                    <div class="col-md-4 p-2">
                                                        <h4 class="">{{ currency_symbol() .  $item->price }}</h4>
                                                        <p>Billed as {{ currency_symbol() .  $item->price }}</p>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center ">
                                                    <div class="bgk"></div>
                                                </div>
                                            </a>
                                        </div>
                                    @empty
                                        <p>No plans available</p>
                                    @endforelse
                                </div>
                            </div>

                            <div class="col-md-12 mt-5" id="payment_card_scroll">
                                <h4>Summary</h4>

                                <div class="bg-white mt-4 dgk">
                                    <h4> Due today: <span class="plan_price final_price">  </span></h4>

                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <div class="">
                                            <p> Payable Amount &nbsp; </p>
                                        </div>
                                        <div class="">
                                            <p id="coupon_amt_deduction" class="final_price">  </p>
                                        </div>
                                    </div>
                                    <hr>

                                    <p class="text-center mt-3">All state sales taxes apply</p>
                                </div>
                                <p class=" mt-3 dp"></p>
                            </div>
                            
                                {{-- Stripe --}}
                            <div class="col-md-12 stripe_payment">
                                <button id="stripe-payment-button" data-plan-id="" class="stripe_button btn1 btn-lg btn-block font-weight-bold mt-3 processing_alert" style="background-color: #f5f5f5;">
                                    Pay Now
                                </button>
                            </div>

                                {{-- Recurly --}}
                            <div class="col-md-12 Recurly_payment">
                                <form action="{{ route('channel.Recurly.checkout_page') }}" method="post">
                                    @csrf
                                    <input type="hidden" id="recurly_plan_id" name="recurly_plan_id" value="">
                                    <button type="submit" class="btn bd btn1 btn-lg btn-block font-weight-bold text-white mt-3 processing_alert">
                                        {{ __('Pay Now') }}
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-12 text-center">
                    <p class="mt-3 text-white">OR</p>
                    <div class="mt-4 sign-up-buttons">
                        <a type="button" href="#" class="btn btn-secondary">{{ __('Skip') }}</a>
                    </div>
                </div>
            </div>
    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <script type="text/javascript">

        $(document).ready(function() {
            setTimeout(function() {
                $('#successMessage').fadeOut('fast');
            }, 3000);

            $('.stripe_payment,.Recurly_payment').hide();
        })
  
        function updatePaymentAmount(planAmount,PlanId,PaymentGateway) {

            $('.stripe_payment,.Recurly_payment').hide();

            let currency_symbol = "{{ currency_symbol() }}"; 

            document.querySelectorAll('.final_price').forEach(function(item){
                item.innerText = currency_symbol + planAmount;
            });

            if( PaymentGateway == "Stripe") {

                document.getElementById('stripe-payment-button').setAttribute('data-plan-id', PlanId);
                $('.stripe_payment').show();

            }

            if( PaymentGateway == "Recurly") {
                document.getElementById('recurly_plan_id').value = PlanId;
                $('.Recurly_payment').show();
            }

        }
      
         var payment_images = $('#payment_image').val();

        $(".payment_gateway").click(function() {

            let payment_gateway = $('input[name="payment_gateway"]:checked').val();
            let currency_symbol = "{{ currency_symbol() }}"; 
            
            swal({
                title: "Loading...",
                text: "Please wait",
                icon: payment_images + '/Loading.gif',
                buttons: false,
                closeOnClickOutside: false,
                closeOnEsc: false,
            });

            $.ajax({
                url: "{{ route('channel.payment_gateway_depends_plans') }}",
                type: "get",
                data: {
                    _token: '{{ csrf_token() }}',
                    payment_gateway: payment_gateway
                },
                success: function(response) {
                    const plansData = response.data.plans_data;

                    const plansContainer = $('.data-plans').empty();

                    if (plansData && plansData.length > 0) {
                    
                        const plansHTML = plansData.map(item => `
                            <div class="col-md-6 plan_details p-0">
                                <a href="#payment_card_scroll" onclick="updatePaymentAmount('${item.price}', '${item.plan_id.replace(/\s+/g, ' ').trim()}' , '${item.paymentGateway}')">
                                    <div class="row dg align-items-center mb-4">
                                        <div class="col-md-7 p-0">
                                            <h5 class="font-weight-bold">${item.price}</h5>
                                            <p>${item.plan_content || 'Plan Description'}</p>
                                        </div>
                                        <div class="vl"></div>
                                        <div class="col-md-4 p-2">
                                            <h4>${currency_symbol + item.price}</h4>
                                            <p>Billed as ${currency_symbol + item.price}</p>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="bgk"></div>
                                    </div>
                                </a>
                            </div>
                        `).join(''); 

                        plansContainer.html(plansHTML);
                        swal.close();

                    } else {
                       
                        plansContainer.html('<p>No plans available</p>');
                        swal({
                            title: "No Plan Found !!",
                            icon: "warning",
                        }).then(function() {
                            location.reload();
                        });
                    }
                },
                error: function() {
                    swal({
                        title: "Error fetching plans!",
                        icon: "error",
                    });
                }
            });
        });
    
    </script>

    @php
        include public_path("themes/{$current_theme}/views/footer.blade.php");
    @endphp

@endsection

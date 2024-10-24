@include('avod::ads_header')

<div id="main-admin-content" style="color: black">
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="iq-card">
                        <div class="justify-content-between d-flex">
                            <h2 class=" mb-3 ml-3 mt-3">Advertisement Payment</h2>
                        </div>
                        <hr>

                        <section class="payment-details">
                            <div class="container payment-details-container">
                                <div class="row">
                                    <div class="col-lg-7 col-md-6 p-0">
                                        <div class="payment-details1">
                                            <p class="" style="font-size: 16px;">Welcome </p>
                                            <div class="medium-heading pb-3 pl-2"> Make a payment for uploads advertisement on your videos </div>

                                            <div class="col-md-12 p-0">
                                                <p class="meth"> Payment Method</p>

                                                <input type="hidden" id="payment_image" value="{{ URL::to('/public/Thumbnai_images')  }}">

                                                <div class="payment-methods d-flex">
                                                    <!-- Stripe -->
                                                    @if (!empty($Stripe_payment_settings) && $Stripe_payment_settings->stripe_status == 1)
                                                        <div class="payment-methodname ml-3">
                                                            <input type="radio" id="stripe_radio_button" class="payment_gateway" name="payment_gateway" value="stripe" checked="checked"> 
                                                            <label class="ml-1"><p> {{ @$Stripe_payment_settings->stripe_lable ??  "Stripe" }} </p></label> <br>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="data-plans row align-items-center m-0 p-0">

                                                            @forelse ($Adsplan as $item)
                                                                <div style="" class="col-md-6 plan_details p-0">
                                                                    <a href="#payment_card_scroll" onclick="updatePaymentAmount('{{ $item->plan_amount }}', '{{ $item->plan_id }}')">
                                                                        <div class="row dg align-items-center mb-4">

                                                                            <div class="col-md-7 p-0">
                                                                                <h5 class=" font-weight-bold"> {{ @$item->plan_name }} </h5>
                                                                                <p>{{ @$item->description }} </p>
                                                                            </div>

                                                                            <div class="vl "></div>
                                                                            <div class="col-md-4 p-2">
                                                                                <h4 class="">{{ currency_symbol() .  $item->plan_amount }}</h4>
                                                                                <p>Billed as {{ currency_symbol() .  $item->plan_amount }}</p>
                                                                            </div>
                                                                        </div>

                                                                        <div
                                                                            class="d-flex justify-content-between align-items-center ">
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
                                                            <h4> Due today: <span class="plan_price final_price">   </span></h4>

                                                            <div class="d-flex justify-content-between align-items-center mt-2">
                                                                <div class="stripe_payment">
                                                                    <p> Payable Amount &nbsp; </p>
                                                                </div>

                                                                <div class="stripe_payment">
                                                                    <p id="coupon_amt_deduction" class="final_price">  </p>
                                                                </div>
                                                            </div>
                                                            <hr>

                                                            <p class="text-center mt-3">All state sales taxes apply</p>
                                                        </div>

                                                        <p class=" mt-3 dp"></p>
                                                    </div>
                                                    

                                                    <div class="col-md-12 stripe_payment">
                                                        <button id="stripe-payment-button" data-plan-id="" class="stripe_button btn1 btn-lg btn-block font-weight-bold mt-3 processing_alert" style="background-color: #f5f5f5;">
                                                            Pay Now
                                                        </button>
                                                    </div>

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

@include('avod::ads_footer')

<style>
    .iq-top-navbar {
        min-height: 73px;
        position: fixed;
        top: 0;
        /* left: auto; */
        right: 0;
        width: calc(100% - 55px);
        display: inline-block;
        z-index: 99;
        background:
            /*var(--iq-light-card)*/
            #fff;
        margin-right: 25px;
        transition: all 0.45s ease 0s;
        border-bottom: 1px solid #f1f1f1;
    }

    .content-page {
        margin-left: 0px;
        padding: 100px 15px 0;
        transition: all 0.3s ease-out 0s;
    }

    .iq-footer {
        margin-left: 0px !important;
    }

    .payment-details-container {
        margin: 0px 50px;
    }

    .dg {
        padding: 10px;
        color: #000 !important;
        /* background-color: #fff; */
        margin: 5px;
        height: 200px;
        border: 5px solid #ddd;
    }

    .dgk {
        padding: 30px 24px;
        background-color: #f5f5f5 !important;
    }

    .cont {
        background-color: #f5f5f5 !important;
        padding: 36px 47px 70px;
        margin-bottom: 35px;
    }

    hr {
        border: 2px solid #988585;
    }
</style>

<script src="{{ URL::to('assets/admin/dashassets/js/jquery.min.js') }}"></script>
<script src="{{ URL::to('assets/admin/dashassets/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ URL::to('assets/admin/dashassets/js/custom.js')  }}"></script>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css">

@yield('javascript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script>
    
    function updatePaymentAmount(planAmount,PlanId) {
        let currency_symbol = "{{ currency_symbol() }}"; 

        document.querySelectorAll('.final_price').forEach(function(item){
            item.innerText = currency_symbol + planAmount;
        });

        document.getElementById('stripe-payment-button').setAttribute('data-plan-id', PlanId);
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

    $(".stripe_button").click(function() {

        var Stripe_Plan_id = $('#stripe-payment-button').attr('data-plan-id');

        if (Stripe_Plan_id && Stripe_Plan_id.trim() !== "") {
            
            $.ajax({
                url: "{{ route('Advertisement.Stripe_authorization_url') }}",
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
                            // Do nothing or handle additional logic if needed
                        });
                    }
                }
            });
        } else {
           
            swal({
                title: "Plan Not Selected",
                text: "Please select a Plan before proceeding.",
                icon: "warning",
            });
        }
});


</script>
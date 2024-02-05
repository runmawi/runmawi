@php  include(public_path('themes/theme3/views/header.php')); @endphp

<button id="rzp-button1" hidden>Pay</button>  
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<div class="col-lg-12  h-100">
    <div class="d-flex justify-content-center">
        <img src="{{ URL::to('/public/Thumbnai_images/checkout-processing.gif')}}" alt="" srcset="" class="w-100">
    </div>
</div><div class="col-lg-12  h-100">
    <div class="d-flex justify-content-center">
        <img src="{{ URL::to('/public/Thumbnai_images/checkout-processing.gif')}}" alt="" srcset="" class="w-100">
    </div>
</div>

<script>
var options = {
    "key"          : "{{$response['razorpaykeyId']}}", 
    "amount"       : "{{ $response['amount'] }}",
    "currency"     : "{{$response['currency']}}",
    "name"         : "{{$response['name']}}",
    "description"  : "{{$response['description']}}",
    "order_id"     : "{{$response['orderId']}}", 
    "image"        : "{{ GetDarkLogourl() }}",
    "handler"      : function (response){
        document.getElementById('rzp_paymentid').value = response.razorpay_payment_id;
        document.getElementById('rzp_orderid').value = response.razorpay_order_id;
        document.getElementById('rzp_signature').value = response.razorpay_signature;

        document.getElementById('rzp-paymentresponse').click();
    },
    "prefill": {
        "name": "{{$response['name']}}",
    },
    "notes": {
        "address": "{{$response['address']}}"
    },
    "theme": {
        "color": "#F37254"
    },

    "modal": {
    "ondismiss": function(){
        window.location.href = "{{ URL::to('/category/videos/'.$response['Video_slug']) }} "
        },
    }
};
var rzp1 = new Razorpay(options);
window.onload = function(){
    document.getElementById('rzp-button1').click();
};

document.getElementById('rzp-button1').onclick = function(e){
    rzp1.open();
    e.preventDefault();
}
</script>

<!-- This form is hidden -->
<form action="{{url('/RazorpayVideoRent_Payment')}}" method="POST" hidden>
        <input type="hidden" value="{{csrf_token()}}" name="_token" /> 
        <input type="text" class="form-control" id="rzp_paymentid"  name="rzp_paymentid">
        <input type="text" class="form-control" id="rzp_orderid" name="rzp_orderid">
        <input type="text" class="form-control" id="rzp_signature" name="rzp_signature">

        <input type="text"  name="user_id"   value= {{ $response['user_id'] }} />
        <input type="text"  name="video_id"  value= {{ $response['video_id'] }} />
        <input type="text"  name="amount"    value= {{ $response['amount'] }} />

    <button type="submit" id="rzp-paymentresponse" class="btn btn-primary">Submit</button>
</form>

@php
    include(public_path('themes/theme3/views/footer.blade.php'));
@endphp
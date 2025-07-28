@php  include(public_path('themes/theme3/views/header.php')); @endphp

<button id="rzp-button1" hidden>Pay</button>

<div class="col-lg-12  h-100">
    <div class="d-flex justify-content-center">
        <img src="{{ URL::to('/public/Thumbnai_images/checkout-processing.gif')}}" alt="" srcset="" class="w-100">
    </div>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
var options = {
    "key": "{{$respond['razorpaykeyId']}}", // Enter the Key ID generated from the Dashboard
    "subscription_id": "{{$respond['subscriptionId']}}",
    "currency": "INR",
    "name": "{{$respond['name']}}",
    "description": "{{$respond['description']}}",
    "image": "https://example.com/your_logo",
    "handler": function (response){

        document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
        document.getElementById('razorpay_subscription_id').value = response.razorpay_subscription_id;
        document.getElementById('razorpay_signature').value = response.razorpay_signature;

        document.getElementById('razorpay_respond').click();
    },
    "prefill": {
        "name": "{{$respond['user_name']}}",
        "email": "{{$respond['email']}}",
        "contact": "{{$respond['contactNumber']}}",
    },
    "theme": {
        "color": "#3399cc"
    }
};
var rzp1 = new Razorpay(options);
rzp1.on('payment.failed', function (response){
        alert(response.error.code);
        alert(response.error.description);
        alert(response.error.source);
        alert(response.error.step);
        alert(response.error.reason);
        alert(response.error.metadata.order_id);
        alert(response.error.metadata.payment_id);
});
window.onload = function(){
    document.getElementById('rzp-button1').click();
};
document.getElementById('rzp-button1').onclick = function(e){
    rzp1.open();
    e.preventDefault();
}
</script>


<form action="{{ route('RazorpayCompleted') }}" method="POST" hidden>
    {{ csrf_field() }}
    <input type="text"  name="razorpay_payment_id"       id="razorpay_payment_id" value= />
    <input type="text"  name="razorpay_subscription_id"  id="razorpay_subscription_id"value= />
    <input type="text"  name="razorpay_signature"        id="razorpay_signature" value=  />
    <input type="text"  name="user_id"     id="user_id" value= {{ $respond['user_id'] }} />
    <input type="text"  name="countryName" id="countryName" value= {{ $respond['countryName'] }} />
    <input type="text"  name="cityName"    id="cityName" value= {{ $respond['cityName'] }} />
    <input type="text"  name="regionName"  id="regionName" value= {{ $respond['regionName'] }}   />

    <input type="text"  name="Subscription_primary_id"  id="Subscription_primary_id" value= {{ $respond['Subscription_primary_id'] }}   />

    <button type="submit" id="razorpay_respond">Pay</button>
</form>

@php
    include(public_path('themes/theme3/views/footer.blade.php'));
@endphp
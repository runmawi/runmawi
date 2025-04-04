@php  include(public_path('themes/theme7/views/header.php')); @endphp

<button id="rzp-button1" hidden>{{ __('Pay')  }}</button>  
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<div class="col-lg-12  h-100">
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
        window.location.href = "{{ URL::to('/live/'.$response['live_slug']) }} "
        },
    }
};
var rzp1 = new Razorpay(options);

rzp1.on('payment.failed', function (response) {
    console.error('Payment failed:', response); // Log full response
    
    fetch("{{ url('/RazorpayLiveRent_Paymentfailure') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            user_id: "{{ $response['user_id'] }}",
            video_id: "{{ $response['live_id'] }}",
            amount: "{{ $response['amount'] }}",
            PpvPurchase_id: "{{ $response['PpvPurchase_id'] }}",
            livepurchase_id: "{{ $response['livepurchase_id'] }}",
            order_id: response.error.metadata.order_id,
            payment_id: response.error.metadata.payment_id,
            error_code: response.error.code,
            error_description: response.error.description,
            error_full: JSON.stringify(response.error), // Log entire error object
            failure_reason: response.error.reason 
        })
    }).then(res => res.json())
      .then(data => console.log('Failure API response:', data))
      .catch(err => console.error('Failure API error:', err));
});


window.onload = function(){
    document.getElementById('rzp-button1').click();
};

document.getElementById('rzp-button1').onclick = function(e){
    rzp1.open();
    e.preventDefault();
}
</script>

<!-- This form is hidden -->
<form action="{{url('/RazorpayLiveRent_Payment')}}" method="POST" hidden>
    <input type="hidden" value="{{csrf_token()}}" name="_token" /> 
    <input type="text" class="form-control" id="rzp_paymentid"  name="rzp_paymentid">
    <input type="text" class="form-control" id="rzp_orderid" name="rzp_orderid">
    <input type="text" class="form-control" id="rzp_signature" name="rzp_signature">

    <input type="text"  name="user_id"   value= {{ $response['user_id'] }} />
    <input type="text"  name="live_id"  value= {{ $response['live_id'] }} />
    <input type="text"  name="amount"    value= {{ $response['amount'] }} />

    <input type="text"  name="PpvPurchase_id"  value= {{ $response['PpvPurchase_id'] }} />
    <input type="text"  name="livepurchase_id"  value= {{ $response['livepurchase_id'] }} />

    <button type="submit" id="rzp-paymentresponse" class="btn btn-primary">{{ __('Submit')  }}</button>
</form>

@php
    include(public_path('themes/theme7/views/footer.blade.php'));
@endphp
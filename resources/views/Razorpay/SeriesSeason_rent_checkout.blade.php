@include('header')

<button id="rzp-button1" hidden>Pay</button>  
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>


<script>
var options = {
    "key"          : "{{$response['razorpaykeyId']}}", 
    "amount"       : "{{ $response['amount'] }}",
    "currency"     : "{{$response['currency']}}",
    "name"         : "{{$response['name']}}",
    "description"  : "{{$response['description']}}",
    "order_id"     : "{{$response['orderId']}}", 
    "image"        : "https://example.com/your_logo",
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
        "SeriesSeason_id": "{{$response['SeriesSeason_id']}}",
        "user_id": "{{$response['user_id']}}",
        "ppv_plan": "{{$response['ppv_plan']}}"
    },
    "theme": {
        "color": "#F37254"
    },

    "modal": {
    "ondismiss": function(){
        window.location.href = "{{ URL::to('/play_series/'.$response['Series_slug']) }} "
        },
    }
};
var rzp1 = new Razorpay(options);

rzp1.on('payment.failed', function (response) {
    fetch("{{ url('/RazorpaySeriesSeasonRent_Paymentfailure') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            user_id: "{{ $response['user_id'] }}",
            video_id: "{{ $response['SeriesSeason_id'] }}",
            amount: "{{ $response['amount'] }}",
            PpvPurchase_id: "{{ $response['PpvPurchase_id'] }}",
            order_id: response.error.metadata.order_id,
            payment_id: response.error.metadata.payment_id,
            error_code: response.error.code,
            error_description: response.error.description,
            failure_reason: response.error.reason 
        })
    })
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
<form action="{{url('/RazorpaySeriesSeasonRent_Payment')}}" method="POST" hidden>
    <input type="hidden" value="{{csrf_token()}}" name="_token" /> 
    <input type="text" class="form-control" id="rzp_paymentid"  name="rzp_paymentid">
    <input type="text" class="form-control" id="rzp_orderid" name="rzp_orderid">
    <input type="text" class="form-control" id="rzp_signature" name="rzp_signature">

    <input type="text"  name="user_id"   value= {{ $response['user_id'] }} />
    <input type="text"  name="SeriesSeason_id"  value= {{ $response['SeriesSeason_id'] }} />
    <input type="text"  name="amount"    value= {{ $response['amount'] }} />
    <input type="text"  name="ppv_plan"  value= {{ $response['ppv_plan'] }} />

    <button type="submit" id="rzp-paymentresponse" class="btn btn-primary">Submit</button>
</form>
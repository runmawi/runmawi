<button id="rzp-button1" hidden>Pay</button>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
var options = {
    "key": "{{$respond['razorpaykeyId']}}", // Enter the Key ID generated from the Dashboard
    "amount": "{{$respond['amount']}}", // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
    "currency": "INR",
    "name": "{{$respond['name']}}",
    "description": "{{$respond['description']}}",
    "image": "https://example.com/your_logo",
    "order_id": "{{$respond['orderId']}}", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
    "handler": function (response){

        document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
        document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
        document.getElementById('razorpay_signature').value = response.razorpay_signature;

        document.getElementById('razorpay_respond').click();
    },
    "prefill": {
        "name": "{{$respond['name']}}",
        "email": "{{$respond['email']}}",
        "contact": "{{$respond['contactNumber']}}",
    },
    "notes": {
        "address": "Razorpay Corporate Office"
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
    <input type="text"  name="razorpay_payment_id" id="razorpay_payment_id" value= />
    <input type="text"  name="razorpay_order_id"   id="razorpay_order_id"value= />
    <input type="text"  name="razorpay_signature"  id="razorpay_signature" value=  />
    
    <button type="submit" id="razorpay_respond">Pay</button>
</form>
@include('header')

<button id="paystack_checkout-button" onclick="paystack_checkout();" hidden > Pay </button>   
<input type="hidden" id="authorization_url" value="{{ $authorization_url }}" required />

<script>

    window.onload = function(){
        document.getElementById('paystack_checkout-button').click();
    };

    function paystack_checkout(){
        window.location.href = document.getElementById("authorization_url").value ;
    }
</script>

@include('footer')
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>W3path | laravel Stripe Payment Gateway Integration - W3path.com</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <style>
   .container{
    padding: 0.5%;
   } 
</style>
</head>
<body>
  <div class="container">
    <h2 style="margin-top: 12px;" class="alert alert-success">laravel Stripe Payment Gateway Integration - <a href="https://www.w3path.com" target="_blank" >W3path</a></h2><br>  
 
      
    <input id="card-holder-name" type="text">

    <!-- Stripe Elements Placeholder -->
    <div id="card-element"></div>

    <button id="card-button" data-secret="{{ $intent->client_secret }}">
        Update Payment Method
    </button>
      
      
</div>
 
 
 
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://checkout.stripe.com/checkout.js"></script>
    
    
    <script src="https://js.stripe.com/v3/"></script>

<script>
    const stripe = Stripe('pk_test_51HSfz8LCDC6DTupiV1GHE25fT9hyf8J1hRoWdfmDqHllYfJCW2oGXMe0AGIAlXsPeKI1lkLEQIvwlPoPe2tBMW7o00bP6s0Czo');

    const elements = stripe.elements();
    const cardElement = elements.create('card');

    cardElement.mount('#card-element');
    
    const cardHolderName = document.getElementById('card-holder-name');
    const cardButton = document.getElementById('card-button');
    const clientSecret = cardButton.dataset.secret;

    cardButton.addEventListener('click', async (e) => {
    const { setupIntent, error } = await stripe.confirmCardSetup(
        clientSecret, {
            payment_method: {
                card: cardElement,
                billing_details: { name: cardHolderName.value }
            }
        }
    );

    if (error) {
        
        alert('error');
        // Display "error.message" to the user...
    } else {
        var py_id = setupIntent.payment_method;
        
           $.post('/bop/stripe', {
              py_id:py_id, _token: '<?= csrf_token(); ?>' 
           
           }, 
                  function(data){
               
           });
        
        // The card has been verified successfully...
    }
});
    
</script>

</body>
</html>
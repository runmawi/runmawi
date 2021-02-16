<input id="card-holder-name" type="text">

<!-- Stripe Elements Placeholder -->
<div id="card-element"></div>

<button id="card-button" data-secret="{{ $intent->client_secret }}">
    Update Payment Method
</button>

<script src="https://js.stripe.com/v3/"></script>

<script>
    const stripe = Stripe('pk_test_51HXNaQDXnhJ8HTT773vSW6ylQuKg8wdjOlhWZKvVKPzRDP0xCMCNcFdqIwjqlkCg4M7umCJn1aQQThy37uRfLtxf00xPiEqwXV');

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
            // Display "error.message" to the user...
        } else {
            // The card has been verified successfully...
        }
    });
    
    
</script>
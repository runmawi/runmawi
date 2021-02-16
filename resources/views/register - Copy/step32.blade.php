@extends('layouts.app')
@include('/header')
@section('content')
<div class="row" id="signup-form">
    
     <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1" >
    <div class="overlay" style="background: rgb(251, 251, 251);">
            <div class="panel-heading">
              <div class="row nomargin text-center">
                    <h1 class="panel-title">Pay Now</h1>
              </div>
            </div>
         
         
            
            <div class="form-group row">
            <!--
                <input type="text" name="email" class="form-controll" placeholder="Enter email" value="{{ session()->get('register.email') }}">
                <input type="text" name="password" class="form-controll" placeholder="Enter email" value="{{ session()->get('register.password') }}">
            -->
      
          <input type="hidden" name="plan_name" class="form-controll" id="plan_name" value="{{ session()->get('planname') }}">
            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Card Holder Name') }} :</label>
                <div class="col-md-6"> 
                    <input id="card-holder-name" type="text" class="form-control">
                </div>
        </div>
            <!-- Stripe Elements Placeholder -->
            <div id="card-element"></div>
            <div class="pull-right sign-up-buttons">
                <button id="card-button" class="btn btn-primary"  data-secret="{{ $intent->client_secret }}">
                    Pay Now
                </button>
            </div>
        </div>

<input type="hidden" id="base_url" value="<?php echo URL::to('/');?>">
    <script src="https://js.stripe.com/v3/"></script>

<script>
    

    
        var base_url = $('#base_url').val();
    
        const stripe = Stripe('pk_test_z8OQoKfyOCjAxMfPD7MbzBy200bWaBdwRI');

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

             swal("Your Payment is failed !");
            // Display "error.message" to the user...
        } else {
            var plan_data = $("#plan_name").val();
            // alert(plan_data);return false;
            //alert(plan);
            //alert(setupIntent.payment_method);
               var py_id = setupIntent.payment_method;
              // var plan = $('#plan_name').val();

               $.post(base_url+'/register3', {
                 py_id:py_id, plan:plan_data, _token: '<?= csrf_token(); ?>' 
               }, 
                function(data){
                    swal("You have done  Payment !");
                    setTimeout(function() {
                     //location.reload();
                      window.location.replace(base_url+'/login');
                        
                  }, 2000);
               });

            // The card has been verified successfully...
        }
    });

</script>



@endsection

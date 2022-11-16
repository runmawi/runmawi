@php
    include(public_path('themes/default/views/header.php'));
@endphp

    <div class="col-lg-12  h-100">
        <div class="d-flex justify-content-center">
            <img src="{{ URL::to('/public/Thumbnai_images/checkout-processing.gif')}}" alt="" srcset="" class="w-100">
        </div>
    </div>

<form id="paymentForm">
      <input type="hidden" id="email-address" value="{{ $email }}"  required />
      <input type="hidden" id="publish_key" value="{{ $publish_key }}"  required />
      <input type="hidden" id="amount"      value="{{ $amount }}" required />
      <input type="hidden" id="access_code"  value="{{ $access_code }}" required />
      <input type="hidden" id="redirect_url"  value="{{ ($redirect_url) }}" required />
      <input type="hidden" id="video_id"  value="{{ ($Video_id) }}" required />

      <button id="paystack-button1" onclick="payWithPaystack(event)" hidden>Pay</button>  
</form>
  
<script src="https://js.paystack.co/v1/inline.js"></script> 

<script>

    const paymentForm = document.getElementById('paymentForm');
    
    paymentForm.addEventListener("submit", payWithPaystack, false);

    function payWithPaystack(e) {
        e.preventDefault();

        let handler = PaystackPop.setup({
            
            key    : document.getElementById("publish_key").value ,
            email  : document.getElementById("email-address").value ,
            amount : document.getElementById("amount").value ,
            ref    : document.getElementById("access_code").value , 
            currency: 'NGN',

            onClose: function(){
                    alert('Window closed.');
                    window.location = document.getElementById("redirect_url").value ;
            },

            callback: function(response){

                let reference_code =  response.reference;
                let video_id =  document.getElementById("video_id").value ;

                $.ajax({
                    url: "{{ route('Paystack_Video_Rent_Paymentverify') }}",
                    type: "get",
                    data: {
                        _token: '{{ csrf_token() }}',
                        reference_code : reference_code ,
                        video_id       : video_id ,
                        async: false,
                    },       
                    
                    success: function( response ){

                        if( response.status == true ){
                            alert(' Payment Completed Successfully !');
                            window.location = document.getElementById("redirect_url").value ;
                        }
                        else if( response.status == false  )
                        {
                            alert(' Payment Fails !');
                            window.location = document.getElementById("redirect_url").value ;
                        }

                    } 
                });
            }
        });

        handler.openIframe();
    }

    window.onload = function(){
        document.getElementById('paystack-button1').click();
    };

</script>

@php include(public_path('themes/default/views/footer.blade.php')); @endphp
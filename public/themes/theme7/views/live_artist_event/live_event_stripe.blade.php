<?php 
    include(public_path('themes/theme7/views/header.php'));
?>

<meta name="csrf-token" content="{{ csrf_token() }}">

{{--Live Event Tips  --}}

 <img class=""  src="<?php echo  URL::to('/assets/img/landban.png')?>" style="margin-top:-20px;">

<div class="container">
   <div class="row">
                             
      <div class="col-md-12"><pre id="token_response"></pre></div>
    </div>

    <div class="row">
      <div class="col-md-4">
        <button class="btn btn-primary btn-block" id="trigger" onclick="pay({{ $amount }})" hidden></button>
      </div>
    </div>
</div>
  
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://checkout.stripe.com/checkout.js"></script>
<script src="https://js.stripe.com/v3/"></script>
  
<script type="text/javascript">

document.getElementById("trigger").click();

  $(document).ready(function () {  
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
  });
  
  function pay(amount) {
    var handler = StripeCheckout.configure({
      key: '{{ "$publish_key" }}', // your publisher key id
      locale: 'auto',
      token: function (token) {
        console.log('Token Created!!');
        console.log(token)
        $('#token_response').html(JSON.stringify(token));
  
        $.ajax({
          url: '{{ route("stripePaymentTips") }}',
          method: 'post',
          data: { tokenId: token.id, amount: amount },
          success: (response) => {
              alert(response.message);
              setTimeout(function() {
                window.location.replace("{{ route('live_event_play', $live_event_video_slug ) }}");
            }, 2000);
          },
          error: (error) => {
            console.log(error);
            alert('Oops! Something went wrong')
          }
        })
      }
    });
   
    handler.open({
      name: "{{ GetWebsiteName() }}",
      description: 'TIPS',
      amount: amount * 100
    });
  }

  // Scripe Close - x (Redirection)

  $(document).on("DOMNodeRemoved",".stripe_checkout_app", close);

  function close(){
    window.location.replace("{{ route('live_event_play', $live_event_video_slug ) }}");
  }

</script>

<?php include(public_path('themes/theme7/views/footer.blade.php'));  ?>

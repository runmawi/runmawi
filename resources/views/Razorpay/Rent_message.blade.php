@include('header')

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="main-content">
    <section id="iq-continue">
        <div class="fluid">
           <div class="row">
              <div class="col-sm-12 overflow-hidden">
              </div>
           </div>
        </div>
    </section>
</div>    

<?php
    $URL = $respond['redirect_url'] ?? URL::to('home');
    $status = $respond['status'];
?>
   
<script type="text/javascript">

    $( document ).ready(function() {
        var RedirectUrl = "<?php echo $URL; ?>";
        var Status = "<?php echo $status; ?>" === "true";

        if(Status){
            Swal.fire({
                icon: 'success',
                title: 'Payment Successful!',
                text: 'Your payment has been processed successfully. You can now access the content.',
                timer: 3000,
                allowOutsideClick: false
            }).then(function() {
                window.location.href = RedirectUrl;
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Payment Failed',
                text: 'Sorry! There was an error processing your payment. Please try again.',
                timer: 3000,
                allowOutsideClick: false
            }).then(function() {
                window.location.href = RedirectUrl;
            });
        }
    });
    
</script>

@include('footer')

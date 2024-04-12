@php  
    include(public_path('themes/theme5-nemisha/views/header.php'));
@endphp

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<div class="main-content">
    <section id="iq-continue">
        <div class="fluid">
            <div class="col-lg-12  h-100">
                <div class="d-flex justify-content-center">
                    <img src="{{ URL::to('/public/Thumbnai_images/checkout-processing.gif')}}" alt="" srcset="" class="w-100">
                </div>
            </div>
        </div>
    </section>
</div>    

<?php 
    $URL    = $respond['redirect_url'] ;
    $status = $respond['status'] ;
    $fails_Payment_image        = URL::to('public/Thumbnai_images/fails_Payment.avif');
    $Successful_Payment_image   = URL::to('public/Thumbnai_images/Successful_Payment.gif');
?>
   
<script type="text/javascript">

    $( document ).ready(function() {

        let fails_Payment_image =" <?php echo $fails_Payment_image ?> ";
        let Successful_Payment_image = "<?php echo  $Successful_Payment_image ?>" ;

        let RedirectUrl = "<?php echo $URL; ?>";
        let Status      = {{ $status }} ;

        if(Status == true){

            Swal.fire({
                iconHtml: '<img src='+Successful_Payment_image+'>',
                    iconHtml: '<img src="' + Successful_Payment_image + '" style="max-width: 200px; max-height: 150px;">',

                title: 'Success.',
                text: 'Payment done Successfully',
                timer: 6000,
                allowOutsideClick: false})
                .then(function() {
                    window.location = RedirectUrl;
            });

        }else{

        Swal.fire({
            iconHtml: '<img src="' + fails_Payment_image + '" style="max-width: 200px; max-height: 150px;">',
            title: 'Oops...',
            text: 'Sorry! Payment failure',
            timer: 6000,
            allowOutsideClick: false})
            .then(function() {
                window.location = RedirectUrl;
            });
        }
    });
</script>

@php
    include(public_path('themes/theme5-nemisha/views/footer.blade.php'));
@endphp
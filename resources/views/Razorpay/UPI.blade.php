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

<?php $URL = URL::to('home'); ?>
   
<script type="text/javascript">

    $( document ).ready(function() {
        var RedirectUrl="<?php echo $URL; ?>";
        Swal.fire({
        icon: 'info',
        title: 'Oops...',
        text: 'Sorry! Subscriptions cannot be updated when payment mode is upi',
        // footer: '<a href="">Why do I have this issue?</a>',
        timer: 5000,
        allowOutsideClick: false})
        .then(function() {
            window.location = RedirectUrl;
        });
    });
    
</script>

@include('footer')

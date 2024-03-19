@php  include(public_path('themes/theme6/views/header.php')); @endphp

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
    $URL   = URL::to('/admin/moderator/payouts');
    $status =$respond['status'] ;
?>
   
<script type="text/javascript">

    $( document ).ready(function() {
        var RedirectUrl="<?php echo $URL; ?>";
        var Status     = {{ $status }} ;

        if(Status == true){

        Swal.fire({
            icon: 'success',
            title: 'Success.',
            text: 'Payment done Successfully',
            timer: 5000,
            allowOutsideClick: false})
            .then(function() {
                window.location = RedirectUrl;
            });

        }else{

        Swal.fire({
            icon: 'info',
            title: 'Oops...',
            text: 'Sorry! Payment failure',
            timer: 5000,
            allowOutsideClick: false})
            .then(function() {
                window.location = RedirectUrl;
            });

        }
       
    });
    
</script>

@php
    include(public_path('themes/theme6/views/footer.blade.php'));
@endphp

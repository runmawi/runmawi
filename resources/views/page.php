<?php include('header.php');?>
<style>
    .h-100 { height: 540px !important; }
    .blink_me { animation: blinker 2s linear infinite; } @keyframes blinker { 50% { opacity: 0;}}
    .page-height{ margin-top: 100px; min-height: 540px; }
    .page-wrapper{
        background: #fff;
        padding: 30px 20px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px #141414;
        margin-bottom: 50px;
    }
</style>

    <div class="container">
        <div class="row page-height page-wrapper">
            <div class="col-md-10 page offset-1">
                <h2 class="vid-title text-center text-black"><?php echo __($pager->title); ?></h2>
                <div class="border-line"></div>

                <div class="page-body text-black mt-3">
                    <?php echo __($pager->body); ?>
                </div>
            </div>
        </div>


    </div>     
 <!-- back-to-top End -->
      <!-- jQuery, Popper JS -->
      <script src="<?= URL::to('/'). '/assets/js/jquery-3.4.1.min.js';?>"></script>
      <script src="<?= URL::to('/'). '/assets/js/popper.min.js';?>"></script>
      <!-- Bootstrap JS -->
      <script src="<?= URL::to('/'). '/assets/js/bootstrap.min.js';?>"></script>
      <!-- Slick JS -->
      <script src="<?= URL::to('/'). '/assets/js/slick.min.js';?>"></script>
      <!-- owl carousel Js -->
      <script src="<?= URL::to('/'). '/assets/js/owl.carousel.min.js';?>"></script>
      <!-- select2 Js -->
      <script src="<?= URL::to('/'). '/assets/js/select2.min.js';?>"></script>
      <!-- Magnific Popup-->
      <script src="<?= URL::to('/'). '/assets/js/jquery.magnific-popup.min.js';?>"></script>
      <!-- Slick Animation-->
      <script src="<?= URL::to('/'). '/assets/js/slick-animation.min.js';?>"></script>
      <!-- Custom JS-->
      <script src="<?= URL::to('/'). '/assets/js/custom.js';?>"></script>

 <?php include('footer.blade.php');?>
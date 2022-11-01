<?php
    include(public_path('themes/default/views/header.php'));
?>
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
    .page-body h2{
        color: #000!important;
        font-size: 22px;
        margin-bottom: 10px;
    }
    .page-body h3{
 color: #000!important;
        font-size: 18px;
        font-weight: 400;
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
 

 <?php
    include(public_path('themes/default/views/footer.blade.php'));
?>
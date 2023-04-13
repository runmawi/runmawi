<div style=" background: #edf2f7;">
    <div class="content" style="background: #fff;border: 34px solid #edf2f7;">
        
        <a style="margin-left: 39%;" class="navbar-brand" href="<?php echo URL::to('/') ?>"> <img src="{{ $message->embed( Mail_Image() ) }}" class="c-logo" > </a>

        <h2 class="name" style="color:#3d4852;margin-left: 35px;">Your Verification Code is {{ $otp }} </h2>
        <br>

        <br>
        <?php echo MailSignature(); ?>
    </div>
</div>

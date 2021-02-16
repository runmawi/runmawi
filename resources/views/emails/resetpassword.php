<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <a class="navbar-brand" href="<?php echo URL::to('/');?>">
        <?php $settings = App\Setting::find(1); ?>
        <img style="margin-left: 39%;" src="<?php echo URL::to('/').'/public/uploads/settings/' . $settings->logo; ?>" width="80" height="80">
</a>
        <h2>Verify Your Email Address</h2>

        <div>
         
            Please use the below verification code to reset password
            <?= $verification_code ?>.<br/>

        </div>

    </body>
    <?php echo MailSignature();?>
</html>
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
        <h2>Reset Password</h2>

        <div>
         
           Click here to reset your password: <?php echo URL::to('/').'password/reset/'.$token ;?>
           <br>

        </div>

    </body>
    <?php echo MailSignature();?>
</html>
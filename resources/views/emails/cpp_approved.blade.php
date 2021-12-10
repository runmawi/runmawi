<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <!-- <h2>Verify Your Email Address</h2> -->

        <div>
            Your Account as been Aprroved .
            Please follow the link below to login using email
            <?= URL::to('cpp/login/') ?>.<br/>

        </div>
        <?php echo MailSignature();?>
    </body>
</html>
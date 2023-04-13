<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="utf-8">
</head>

<body>
<a style="margin-left: 39%;" class="navbar-brand" href="<?php echo URL::to('/') ?>"> <img src="{{ $message->embed( Mail_Image() ) }}" class="c-logo" > </a>

    <h2>Verify Your Email Address</h2>

    <div>

        Please use the below verification code to reset password
        <?= $verification_code ?>.<br />

    </div>

</body>
<?php echo MailSignature(); ?>

</html>

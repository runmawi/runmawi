<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>Verify Your Email Address</h2>

        <div>
            Thanks for creating an account with <?= $website_name ?>.
            Please follow the link below to verify your email address
            <?= URL::to('channel/verify/'. $activation_code) ?>.<br/>

        </div>
        <?php echo html_entity_decode(MailSignature());?>
    </body>
</html>


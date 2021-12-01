<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
    <?php $settings = App\Setting::find(1); ?>

        <h2>Approval Mail For New Device</h2>

        <div>
            Thanks for creating an account with <?= $settings->website_name ?>.
            Please follow the link below to Approval a device
            <a href="{{ URL::to('device/login/verify'.'/'.$ip.'/'.$id.'/'.$device_name) }}"><button type="submit">Approve</button></a>
           <br/>
           <a href="{{ URL::to('device/reject'.'/'.$ip.'/'.$device_name) }}"><button type="submit">Reject</button></a>
           <br/>

        </div>
        <?php echo MailSignature();?>
    </body>
</html>
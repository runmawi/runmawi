<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <!-- <h2>Verify Your Email Address</h2> -->
        <div class="content" style="background: #fff;border: 34px solid #edf2f7;">
            <a class="navbar-brand" href="<?php echo URL::to('/cpp/login/');?>">
            <?php $settings = App\Setting::find(1); //dd($settings); ?>
                <img style="margin-left: 39%;" src="<?php echo URL::to('/').'/public/uploads/settings/' . $settings->logo; ?>" width="80" height="80">
            </a>
            <h2 class="name" style="color:#3d4852;margin-left: 35px;">Dear  {{ $users->username }} </h2> <br>
                    <p style="color:#718096;margin-left: 35px;"> Thank you for registering as a Partner at {{ $settings->website_name }}. If you have any questions, please reply to this email and one of our team members will reply to you ASAP.</p>
                    <p style="color:#718096;margin-left: 35px;"> Your login details are as below.</p>
                    <p style="color:#718096;margin-left: 35px;"> Login ID : {{ $users->email }}</p>
                    <p style="color:#718096;margin-left: 35px;"> Password - {{ $users->password }}</p>
            <br>
            <p style="color:#718096;margin-left: 25px;">Sincerely,</p>
            <p style="color:#718096;margin-left: 25px;" >Team {{ $settings->website_name }}</p>
            <p style="color:#718096;margin-left: 25px;"> Website URL : {{ URL::to('/') }} </p>
     </div>
        <div>
            <!-- Your Account as been Aprroved .
            Please follow the link below to login using email -->
            <? //URL::to('cpp/login/') ?><br/>

        </div>
        <?php //echo MailSignature();?>
    </body>
</html>
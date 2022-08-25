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
            <h2 class="name" style="color:#3d4852;margin-left: 35px;">Dear  {{ $users->channel_name }} </h2> <br>
                    <p style="color:#718096;margin-left: 35px;"> Sorry you're  registering as a Channel Partner at {{ $settings->website_name }} has been Rejected. If you have any questions, please reply to this email and one of our team members will reply to you ASAP.</p>
            <br>
            <p style="color:#718096;margin-left: 25px;">Sincerely,</p>
            <p style="color:#718096;margin-left: 25px;" >Team {{ $settings->website_name }}</p>
            <p style="color:#718096;margin-left: 25px;"> Website URL : {{ URL::to('/') }} </p>
     </div>
    </body>
</html>
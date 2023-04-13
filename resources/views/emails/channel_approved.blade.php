<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="utf-8">
</head>

<body>
    <!-- <h2>Verify Your Email Address</h2> -->
    <div class="content" style="background: #fff;border: 34px solid #edf2f7;">
        <a style="margin-left: 39%;" class="navbar-brand" href="<?php echo URL::to('/') ?>"> <img src="{{ $message->embed( Mail_Image() ) }}" class="c-logo" > </a>

        <h2 class="name" style="color:#3d4852;margin-left: 35px;">Dear {{ $users->channel_name }} </h2> <br>
        <p style="color:#718096;margin-left: 35px;"> Thank you for registering as a Partner at
            {{ $settings->website_name }}. If you have any questions, please reply to this email and one of our team
            members will reply to you ASAP.</p>
        <p style="color:#718096;margin-left: 35px;"> Your login details are as below.</p>
        <p style="color:#718096;margin-left: 35px;"> Login ID : {{ $users->email }}</p>
        <br>
        <p style="color:#718096;margin-left: 25px;">Sincerely,</p>
        <p style="color:#718096;margin-left: 25px;">Team {{ $settings->website_name }}</p>
        <p style="color:#718096;margin-left: 25px;"> Website URL : {{ URL::to('/') }} </p>
    </div>
</body>

</html>

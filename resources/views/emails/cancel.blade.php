<div style=" background: #edf2f7;">
    <div class="content" style="background: #fff;border: 34px solid #edf2f7;">

        <div class="content" style="background: #fff;margin: 5%;">
                <?php $settings = App\Setting::first(); ?>
                <a style="margin-left: 39%;" class="navbar-brand" href="<?php echo URL::to('/') ?>"> <img src="{{ $message->embed( Mail_Image() ) }}" class="c-logo" > </a>
        <div>

        <h2 class="name" style="color:#3d4852;margin-left: 35px;">Hello {{ $name }} </h2> <br>

        <p style="color:#718096;margin-left: 35px;"> You have Successfully Cancelled your subscription from Eliteclub.
        </p>
        <p style="color:#718096;margin-left: 35px;"> Your plan details,</p>
        <p style="color:#718096;margin-left: 35px;"> Plan Name - {{ $plan_name }}</p>
        <p style="color:#718096;margin-left: 35px;"> Plan Subscribed Date - {{ $start_date }}</p>
        <p style="color:#718096;margin-left: 35px;"> Plan Cancelled Data - {{ $ends_at }}</p>
        <p style="color:#718096;margin-left: 35px;"> We hope to see you again soon.</p>
        <br>
        <?php echo MailSignature(); ?>
    </div>
</div>

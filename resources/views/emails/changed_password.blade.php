<div style=" background: #edf2f7;">
    <div class="content" style="background: #fff;border: 34px solid #edf2f7;">
        <?php $settings = App\Setting::find(1); ?>
        <a style="margin-left: 39%;" class="navbar-brand" href="<?php echo URL::to('/') ?>"> <img src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo; ?>" class="c-logo" > </a>

        <!-- <h2><?php //echo $heading;?></h2> -->
        <div>
       <p>          Dear <?php echo $username;?>,       </p>
       <p>          Your profile password has been changed successfully on <?php echo $username;?>.       </p>
       <p>      Sincerely,</p>
       <p>      Team <?php echo $settings->website_name;?>       </p>

           <!-- <a href="<?php // echo URL::to('/').'/password/reset/'.$token ;?>">Click here</a> to reset your password: <?php //echo URL::to('/').'/password/reset/'.$token ;?> -->
           <br>
           <p>  <?php echo MailSignature();?>       </p>

    </div>
    </div>

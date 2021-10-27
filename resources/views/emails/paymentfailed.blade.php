<div style=" background: #edf2f7;">
    <div class="content" style="background: #fff;border: 34px solid #edf2f7;">
    <?php $settings = App\Setting::find(1); ?>
    <a style="margin-left: 39%;" class="navbar-brand" href="<?php echo URL::to('/') ?>"> <img src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo; ?>" class="c-logo" > </a>

        <!-- <h2><?php //echo $heading;?></h2> -->
        <div>
       <p>          Dear <?php echo $name;?>,       </p>
       <p>          Your <?php echo $name;?> transaction for <?php echo $price;?> on <?php echo $plan;?> has failed due to <?php echo $error['message']; ?>. This may be a temporary problem, please try again in a few minutes or get in touch with us at support email if the problem persists.       </p>
       <p>          Your <?php echo $name;?> .       </p>
       <p>      Thanks, <?php echo $settings->website_name;?>       </p>

           <!-- <a href="<?php// echo URL::to('/').'/password/reset/'.$token ;?>">Click here</a> to reset your password: <?php //echo URL::to('/').'/password/reset/'.$token ;?> -->
           <br>
           <p>  <?php echo MailSignature();?>       </p>

    </div>
    </div>

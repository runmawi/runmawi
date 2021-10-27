<div style=" background: #edf2f7;">
    <div class="content" style="background: #fff;border: 34px solid #edf2f7;">
    <?php $settings = App\Setting::find(1); ?>
    <a style="margin-left: 39%;" class="navbar-brand" href="<?php echo URL::to('/') ?>"> <img src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo; ?>" class="c-logo" > </a>

        <!-- <h2><?php //echo $heading;?></h2> -->
        <div>
<p> &nbsp;&nbsp;&nbsp;&nbsp;Dear <?php echo $name;?>,&nbsp;&nbsp;&nbsp;&nbsp;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;A new account on <?php echo $name;?> has been created for you by your organization admin <?php echo $settings->website_name;?>. &nbsp;&nbsp;&nbsp;&nbsp;       </p>
<p>  &nbsp;&nbsp;&nbsp;&nbsp;Your login details are as below. &nbsp;&nbsp;&nbsp;&nbsp;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; Login ID : <?php echo $email;?> &nbsp;&nbsp;&nbsp;&nbsp;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; Password : <?php echo $password;?> &nbsp;&nbsp;&nbsp;&nbsp;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; You can set a new password after login in from your user profile.. &nbsp;&nbsp;&nbsp;&nbsp;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; To Log in,  <a href="<?php echo URL::to('/') ;?>">Click here</a>. &nbsp;&nbsp;&nbsp;&nbsp;</p>
 
<p> &nbsp;&nbsp;&nbsp;Regards,&nbsp;&nbsp;&nbsp;&nbsp;</p>
<p>  &nbsp;&nbsp;&nbsp;<?php echo MailSignature();?> &nbsp;&nbsp;&nbsp;&nbsp;</p>


    </div>
    </div>

<div style=" background: #edf2f7;">
    <div class="content" style="background: #fff;border: 34px solid #edf2f7;">
    <?php $settings = App\Setting::find(1); ?>
    <a style="margin-left: 39%;" class="navbar-brand" href="<?php echo URL::to('/') ?>"> <img src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo; ?>" class="c-logo" > </a>

        <!-- <h2><?php //echo $heading;?></h2> -->
        <div>
<p> &nbsp;&nbsp;&nbsp;&nbsp;Dear <?php echo $name;?>,&nbsp;&nbsp;&nbsp;&nbsp;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;Thank you for registering as a Content Partner Portal <?php echo $name;?>. If you have any questions, please reply to this email and one of our team members will reply to you ASAP. &nbsp;&nbsp;&nbsp;&nbsp;       </p>
<p>  &nbsp;&nbsp;&nbsp;&nbsp;Your login details are as below. &nbsp;&nbsp;&nbsp;&nbsp;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; Login ID : <?php echo $email;?> &nbsp;&nbsp;&nbsp;&nbsp;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; Password : <?php echo $password;?> &nbsp;&nbsp;&nbsp;&nbsp;</p>

<p> &nbsp;&nbsp;&nbsp;Sincerely,&nbsp;&nbsp;&nbsp;&nbsp;</p>
<p>&nbsp;&nbsp;&nbsp;Team <?php echo $settings->website_name;?>&nbsp;&nbsp;&nbsp;&nbsp;</p>

<p> &nbsp;&nbsp;&nbsp;<?php echo MailSignature();?> &nbsp;&nbsp;&nbsp;&nbsp;</p>


    </div>
    </div>

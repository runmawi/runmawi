<div style=" background: #edf2f7;">
    <div class="content" style="background: #fff;margin: 5%;">
            <?php $settings = App\Setting::find(1); ?>
			<a style="margin-left: 39%;" class="navbar-brand" href="<?php echo URL::to('/') ?>"> <img src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo; ?>" class="c-logo" > </a>
	<div>
	<?php $template = App\EmailTemplate::where('id','=',23)->get();  ?>

	<!-- <h2><?php //echo $template[0]->template_type;?></h2> -->

	<p>&nbsp;&nbsp;&nbsp;&nbsp;Dear <?php echo $name;?>,&nbsp;&nbsp;&nbsp;</p>
	<p>&nbsp;&nbsp;&nbsp;&nbsp;Welcome to <?php echo $settings->website_name;?>.&nbsp;&nbsp;&nbsp;</p>
	<p>&nbsp;&nbsp;&nbsp;&nbsp;Buy Subscriptions Plan To Access Multiple Devices.&nbsp;&nbsp;&nbsp;</p>

	<p>&nbsp;&nbsp;&nbsp;    Sincerely,&nbsp;&nbsp;&nbsp;</p>
	<p>&nbsp;&nbsp;&nbsp;    Team <?php echo $settings->website_name;?>&nbsp;&nbsp;&nbsp;</p>

</div>
	<p>&nbsp;&nbsp;&nbsp;     <?php echo MailSignature();?>&nbsp;&nbsp;&nbsp;</p>
</div>
</div>
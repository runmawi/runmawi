<div style=" background: #edf2f7;">
    <div class="content" style="background: #fff;margin: 5%;">
            <?php $settings = App\Setting::find(1); ?>
			<a style="margin-left: 39%;" class="navbar-brand" href="<?php echo URL::to('/') ?>"> <img src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo; ?>" class="c-logo" > </a>
	<div>
	<?php $template = App\EmailTemplate::where('id','=',23)->get();  ?>

	<!-- <h2><?php //echo $template[0]->template_type;?></h2> -->

	<p>&nbsp;&nbsp;&nbsp;&nbsp;Dear <?php echo $name;?>,&nbsp;&nbsp;&nbsp;</p>
	<p>&nbsp;&nbsp;&nbsp;&nbsp;We acknowledge the receipt of your request to cancel your <?php echo $plan_name;?> subscription to <?php echo $plan_name;?>.&nbsp;&nbsp;&nbsp;</p>
	<p>&nbsp;&nbsp;&nbsp;&nbsp;There will not be any further charges on your credit card for the same.You will have access to <?php echo $plan_name;?> till <?php echo $ends_at;?>.&nbsp;&nbsp;&nbsp;</p>
	<p>&nbsp;&nbsp;&nbsp;&nbsp;You can renew your subscription back at any time. Just login to Name using the same email/password and purchase a new subscription.&nbsp;&nbsp;&nbsp;</p>
	<p>&nbsp;&nbsp;&nbsp;&nbsp;if you need further assistance, please contact us by support@webnexs.com.&nbsp;&nbsp;&nbsp;</p>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;Your subscription has been cancelled/modified, if you have subscribed through Roku TV/Apple TV/Fire TV/iOS App's In-App Service, please visit the respective dashboard and make the necessary changes to stop being overcharged.&nbsp;&nbsp;&nbsp;</p>

	<p>&nbsp;&nbsp;&nbsp;    Sincerely,&nbsp;&nbsp;&nbsp;</p>
	<p>&nbsp;&nbsp;&nbsp;    Team <?php echo $settings->website_name;?>&nbsp;&nbsp;&nbsp;</p>

</div>
	<p>&nbsp;&nbsp;&nbsp;     <?php echo MailSignature();?>&nbsp;&nbsp;&nbsp;</p>
</div>
</div>







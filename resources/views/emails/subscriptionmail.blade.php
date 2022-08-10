<?php 


$plan_details = App\SubscriptionPlan::where('plan_id','=',$plan_id)->first();
$plan_price = $price;
$discount_percentage = DiscountPercentage();
$discount_price = $discount_percentage;
?>
<div style=" background: #edf2f7;">
    <div class="content" style="background: #fff;margin: 5%;">
        <?php $settings = App\Setting::find(1); ?>
		<a style="margin-left: 39%;" class="navbar-brand" href="<?php echo URL::to('/') ?>"> <img src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo; ?>" class="c-logo" > </a>
	<div>
	<?php $template = App\EmailTemplate::where('id','=',23)->get();  ?>

	<p>&nbsp;&nbsp;&nbsp;&nbsp;Dear <?php echo $name;?>,&nbsp;&nbsp;&nbsp;</p>
	<p>&nbsp;&nbsp;&nbsp;&nbsp;Welcome to <?php echo $settings->website_name;?>.&nbsp;&nbsp;&nbsp;</p>
	<p>&nbsp;&nbsp;&nbsp;&nbsp;Thank you for registering on <?php echo $settings->website_name;?> and subscribing to Plan <?php echo $plan_details->plans_name;?>.&nbsp;&nbsp;&nbsp;</p>
	<p>&nbsp;&nbsp;&nbsp;&nbsp;Click here to confirm your account and you can start watching our videos anytime.&nbsp;&nbsp;&nbsp;</p>
	<p>&nbsp;&nbsp;&nbsp;&nbsp;To view your billing history and invoices please click here.&nbsp;&nbsp;&nbsp;</p>
	<p>&nbsp;&nbsp;&nbsp;&nbsp;if you need further assistance, please contact us by support@webnexs.com.&nbsp;&nbsp;&nbsp;</p>

	<p>&nbsp;&nbsp;&nbsp;    Sincerely,&nbsp;&nbsp;&nbsp;</p>
	<p>&nbsp;&nbsp;&nbsp;    Team <?php echo $settings->website_name;?>&nbsp;&nbsp;&nbsp;</p>

</div>
	<p>&nbsp;&nbsp;&nbsp;     <?php echo MailSignature();?>&nbsp;&nbsp;&nbsp;</p>
</div>
</div>
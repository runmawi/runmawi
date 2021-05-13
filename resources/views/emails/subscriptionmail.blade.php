<?php 

$plan_id = session()->get('planname');


$plan_details = App\Plan::where("plan_id","=",$plan_id)->first();
$plan_price = $plan_details->price;
$discount_percentage = DiscountPercentage();
$discount_price = $discount_percentage;
?>
<div style=" background: #edf2f7;">
    <div class="content" style="background: #fff;margin: 5%;">
    <a class="navbar-brand" href="<?php echo URL::to('/');?>">
            <?php $settings = App\Setting::find(1); ?>
            <img style="margin-left: 39%;" src="<?php echo URL::to('/').'/public/uploads/settings/' . $settings->logo; ?>" width="80" height="80">
    </a>
<hr>
<h2 style="color:#3d4852;margin-left: 5%;">Hello  {{$plan_id }} </h2> <br>
    <p style="color:#718096;margin-left: 5%;"> Welcome to your <b>{{ $plan_id}}</b> of <b>Flicknexs</b>.</p>
<br>
<div style="width: 500px; color:#718096;margin-left: 5%;">
	YOUR MEMBERSHIP<br>
	<table style="width: 500px;color:#718096;">
		<tr><td>Membership:</td><td>Subscriber</td></tr>
		<tr><td>Plan Type:</td><td>{{ $plan_id }}</td></tr>
	</table>
	 <?= URL::to('login/') ?>.<br/>
	<br/>
</div>
<?php echo MailSignature();?>      
</div>
</div>
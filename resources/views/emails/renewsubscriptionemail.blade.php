<div style=" background: #edf2f7;">
    <div class="content" style="background: #fff;margin: 5%;">
        
<a class="navbar-brand" href="<?php echo URL::to('/');?>">
        <?php $settings = App\Setting::find(1); ?>
        <img style="margin-left: 39%;" src="<?php echo URL::to('/').'/public/uploads/settings/' . $settings->logo; ?>" width="80" height="80">
</a>

<h2  style="color:#3d4852;margin-left: 5%;">Hello  {{ $name }} </h2> <br>


<p style="color:#718096;margin-left: 5%;"> Your Premium membership has been Renewed and you have been charged .</b></p>

<p style="color:#718096;margin-left: 5%;">Now you can access the unlimited video and Audios on website and Android & iOS apps.</p>
<br>
<div style="width: 500px; color:#718096;margin-left: 5%;">
	YOUR MEMBERSHIP<br>
	<table  style="width: 500px;color:#718096;">
		<tr><td>Membership:</td><td>Subscriber</td></tr>
		<tr><td>Plan Name:</td><td>{{ $plan }} </td></tr>
	</table>
</div>
</div>
</div>

<?php echo MailSignature();?>
<h2>Hello  {{ $name }} </h2> <br>

<p> Your Premium membership Plan is about to Expiry Today.</b></p>

<p>Please renew your subscription to access the unlimited video and Audios on website and Android & iOS apps.</p>
<br>
<div style="background-color: #efefef;width: 500px;"><br>
	YOUR MEMBERSHIP<br><br>
	<table style="width: 500px;">
		<tr><td>Membership:</td><td>Subscriber</td></tr>
		<tr><td>Plan Type:</td><td>{{ $plan }}</td></tr>
        <tr><td>Ends At:</td><td> {{ $ends_at}} </td></tr>
	</table>
	<br/>

</div>
<br>
<br>
<?php echo MailSignature();?>

<h2>Hello  {{ $name }} </h2> <br>


<p> You have upgraded your membership from Registered user to Premium user by paying {{ $price }} per {{ $billing_interval }} by this transaction.</b>.</p>

<p>Now you can access the unlimited video and Audios on website and Android & iOS apps.</p>
<br>
<div style="background-color: #efefef;width: 500px;">
	YOUR MEMBERSHIP<br>
	<table style="width: 500px;">
		<tr><td>Membership:</td><td>Subscriber</td></tr>
		<tr><td>Plan Type:</td><td>{{ $plan }} ({{ $price }}/{{ $billing_interval }})</td></tr>
        <tr><td>Current Payment:</td><td>{{ $price }}</td></tr>
        <tr><td>Next Payment:</td><td>On {{ $next_billing}} you will be automatically charged {{ $price }} for a {{ $billing_interval }}. </td></tr>
	</table>
	<br/>

</div>
<br>
<br>
<?php echo MailSignature();?>
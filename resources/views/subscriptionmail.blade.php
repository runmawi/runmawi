<h2>Hello  {{ $name }} </h2> <br>


<p> Welcome to your <b>{{ $plan}}</b> of <b>EliteClub</b>.</p>

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
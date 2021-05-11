@extends('layouts.app')

@section('content')
@include('/header')

<body>
	<h3>Transaction Details</h3>
	<table border = "1">
<tr>
<td>user id</td>
<td>Name</td>
<td>Price</td>
<td>days</td>
<td>stripe id</td>
<td>stripe status</td>
<td>stripe plan</td>
<td>quantity</td>
<td>created_at</td>
<td>updated_at</td>
</tr>
@foreach ($subscriptions as $subscription)
<tr>
<td>{{ $subscription->user_id }}</td>
<td>{{ $subscription->name }}</td>
<td>{{ $subscription->price }}</td>
<td>{{ $subscription->days }}</td>
<td>{{ $subscription->stripe_id }}</td>
<td>{{ $subscription->stripe_status }}</td>
<td>{{ $subscription->stripe_plan }}</td>
<td>{{ $subscription->quantity}}</td>
<td>{{ $subscription->created_at}}</td>
<td>{{ $subscription->updated_at }}</td>
</tr>
@endforeach
</table>
</body>
@include('footer')
@endsection 
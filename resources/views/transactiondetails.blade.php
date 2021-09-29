

@include('header')

<div class="container" style="background-color: white">; 
    <div class="row justify-content-center page-height">	
        	<div class="col-md-10 col-sm-offset-1">
                
			<div class="login-block nomargin">

            <h1 class="my_profile" style="color: black;">
                <i class="fa fa-edit"></i> 
                <?php echo __('Transacton History');?>
            </h1>
                
            
                <table class="table">
                      <thead>
                        <tr>
                        <th>Price</th>
                        <th>days</th>
                        <th>stripe id</th>
                        <th>stripe status</th>
                        <th>stripe plan</th>
                        <th>quantity</th>
                        <th>created_at</th>
                        <th>updated_at</th>
                        </tr>
                      </thead>
                      <tbody>
                       
                           
                           
                           
                            @foreach($subscriptions as $key => $subscription )
                           <tr>
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
                            
                       
                       
                      </tbody>
                    </table>

		   <div class="clear"></div>
                
                </div>
        </div>
    </div>
</div>

@extends('footer')
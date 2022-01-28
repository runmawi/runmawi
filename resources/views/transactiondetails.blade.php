

@include('header')

<div class="container mt-4 mb-4" style="background-color: white;border-radius: 10px; padding:20px;box-shadow: 0px 4px 20px rgb(0 0 0 / 5%);">
    <div class="row justify-content-center page-height">	
        	<div class="col-md-12 ">
                
			<div class="login-block ">

            <h2 class="my_profile" style="color: black;">
                <i class="fa fa-edit"></i> 
                <?php echo __('Transacton History');?>
            </h2>
                <hr>
                <div class="bg-strip">
                    <div class="d-flex justify-content-between">
                        <div >
                        <h5 style="color: black;">Make payment</h5></div>
                        <div>
                            <a class="show">Show more transaction</a>
                        </div>
                        
                    </div>
                <div class="row mt-3 p-1" id="">
                    <div class="col-sm-3 bg-white">
                        <img src="{{ URL::to('/assets/img/PayPal-Logo.png') }}" class="w-100 pt-5">
                    </div>
                    <div class="col-sm-3 bg-white ">
                    <img src="{{ URL::to('/assets/img/apple.jpg') }}" width="" class="w-100 pt-4" >
                    </div>
                    <div class="col-sm-3 bg-white">
                           <img src="{{ URL::to('/assets/img/stripe.png') }}" class="w-100 pt-4" >
                    </div>
                    <div class="col-sm-3">
                         <img src="{{ URL::to('/assets/img/maste.jpg') }}" class="w-100" >
                    </div>
                </div>
            </div>
                
                <!-- <div class="mt-5">
                    <table class="table table-bordered text-center">
                            <thead class="thead-light ">
                                <tr>
                                <th scope="col">Status</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Date</th>
                                <th scope="col">Payment type</th>
                                <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <th scope="">Canceled</th>
                                <td>$45.00</td>
                                <td>30 November 2021</td>
                                <td>Payment by paypal</td>
                                    <td><a class="btn1-st">Details</a></td>
                                </tr>
                                <tr>
                                <th scope="row">Approved</th>
                                <td>$35.00</td>
                                <td>30 November 2021</td>
                                <td>Payment by Applepay</td>
                                    <td><a class="btn1-st">Details</a></td>
                                </tr>
                                <tr>
                                <th scope="row">Pending</th>
                                <td>$25.00</td>
                                <td>30 November 2021</td>
                                <td>Payment by Stripe</td>
                                    <td><a class="btn1-st">Details</a></td>
                                </tr>
                            </tbody>
                            </table>
                </div> -->
                
               <div class="mt-5">
               <table class="table table-bordered text-center">
                      <thead>
                        <tr>
                        <th scope="col">Status</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Date</th>
                        <th scope="col">Payment type</th>
                        <!-- <th>Price</th>
                        <th>days</th>
                        <th>stripe id</th>
                        <th>stripe status</th>
                        <th>stripe plan</th>
                        <th>quantity</th>
                        <th>created_at</th>
                        <th>updated_at</th> -->
                        </tr>
                      </thead>
                  <?php  if(!empty($subscriptions)){ ?>

                      <tbody>

                            @foreach($subscriptions as $key => $subscription )
                           <tr>
                            <?php if($subscription->stripe_status == 'active'){ ?>
                            <td class = "bg-success"> <?php echo "Approved"; ?></td>
                            <?php }elseif($subscription->stripe_status == 'inactive'){ ?>
                                <td class = "bg-success"> <?php  echo "Canceled"; ?></td>
                            <?php }else{ ?>
                                <td class = "bg-warning"> <?php  echo "Pending"; ?></td>
                            <?php }?>
                            <td>{{ $subscription->price }}</td>

                            <!-- <td>{{ $subscription->days }}</td>
                            <td>{{ $subscription->stripe_id }}</td>
                            <td>{{ $subscription->stripe_status }}</td>
                            <td>{{ $subscription->stripe_plan }}</td>
                            <td>{{ $subscription->quantity}}</td> -->
                            <td>{{ $subscription->created_at}}</td>
                            <td>Card</td>

                            <!-- <td>{{ $subscription->updated_at }}</td> -->
                           </tr>
                            @endforeach
                            
                            <?php }if(!empty($ppvcharse)){ //dd('test');?>
                                
                            @foreach($ppvcharse as $key => $ppv )
                           <tr>
                            <?php if($ppv->status == 'active'){ ?>
                            <td class = "bg-success"> <?php echo "Approved"; ?></td>
                            <?php }elseif($ppv->status == 'inactive'){ ?>
                                <td class = "bg-success"> <?php  echo "Canceled"; ?></td>
                            <?php }else{ ?>
                                <td class = "bg-warning"> <?php  echo "Pending"; ?></td>
                            <?php }?>
                            <td>{{ $ppv->total_amount }}</td>
                            <td>{{ $ppv->created_at}}</td>
                            <td>Card</td>
                           </tr>
                            @endforeach
                           <?php  }if(!empty($livepurchase)){ ?>
                                
                            @foreach($livepurchase as $key => $live )
                           <tr>
                            <?php if($live->status == 1){ ?>
                            <td class = "bg-success"> <?php echo "Approved"; ?></td>
                            <?php }elseif($live->status == 2){ ?>
                                <td class = "bg-success"> <?php  echo "Canceled"; ?></td>
                            <?php }else{ ?>
                                <td class = "bg-warning"> <?php  echo "Pending"; ?></td>
                            <?php }?>
                            <td>{{ $live->amount }}</td>
           
                            <td>{{ $live->created_at}}</td>
                            <td>Card</td>
                           </tr>
                            @endforeach
                        <?php    } ?>
                        
                      </tbody>
                    </table>
                    </div> 
                    </div> 
		   <div class="clear"></div>
                
                </div>
        </div>
    </div>
</div>

@extends('footer')
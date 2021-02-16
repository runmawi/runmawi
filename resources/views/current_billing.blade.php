@include('header')

 <?php 
    $jsonString = file_get_contents(base_path('assets/country_code.json'));   

    $jsondata = json_decode($jsonString, true); 
?>

				
<!--                <p>Status:   <span class="btn btn-success">{{$status}}</span></p>
               <p>Start Time: {{$start_time}}</p>
               <p>Plan ID:  {{  CurrentPaypalPlan($plan_id) }} </p>
                <?php if ($status == 'ACTIVE'){ ?>
                   <p>Next Billing:   <?php echo $next_billing_date; ?></p>
                   <p>Remaining Days:   <?php echo $remaining_days; ?></p>
                
                  <?php 
                    $date1 = gmdate('c');
                    $date2 = $next_billing_date;
                    $diff = abs(strtotime($date2) - strtotime($date1));
                    $years = floor($diff / (365*60*60*24));
                    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                    DAY : $days;
                ?>
                <?php } ?>-->
                
              
				<div class="container">
					<div class="row justify-content-center">	
							<div class="col-md-10 col-sm-offset-1">
							<div class="login-block nomargin">
							  <div class="row m-0">
									<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 p-0">
										<div class="billing-img-overlay">
											<h4 class="history-head" style="font-weight: 400;">
												<i class="fa fa-calendar-o"></i> Subscription Details
											</h4>
											<div class="clearfix"></div>
											<p class="grey-border"></p>
											<div class="history-div">
												<h5 class="history-head">
													<i class="fa fa-hand-o-right "></i> Status
												</h5>
												<p class="">{{$status}}</p>
											</div>
											<div class="clearfix"></div>
											<p class="grey-border"></p>
											<?php if ($status == 'ACTIVE'){ ?>
											<div class="history-div">
												<h5 class="history-head">
													<i class="fa fa-hand-o-right "></i> Next billing date
												</h5>
												<p class="">{{  date('j-F-Y', strtotime($next_billing_date)) }}</p>
											</div>
								  			<?php } ?>
											<div class="history-div">
												<h5 class="history-head">
													<i class="fa fa-hand-o-right "></i> Remaining Days
												</h5>
												<p class=""><?php if ($status == 'ACTIVE'){echo $remaining_days; }else { echo "0"; } ?>
												</p>
											</div>
											<div class="clearfix"></div>
											<p class="grey-border"></p>
											<div class="history-div">
												<h5 class="history-head">
													<i class="fa fa-hand-o-right "></i> Plan Name
												</h5>
												
												<p class="">{{  CurrentPaypalPlan($plan_id) }} </p>
											</div>
										</div>
										<div class="clearfix"></div>
										<p class="grey-border"></p>
										<div class="text-right">
                                            <?php if ($status == 'ACTIVE'){ ?>
											<a href="<?php echo URL::to('/upgrade-subscription');?>">
												<i class="fa fa-chevron-right"></i>Upgrade Your Plan
											</a>
                                            <?php } ?>
										</div>
										<div class="text-center">
											@if ($status == 'ACTIVE')
											<a href="<?php echo URL::to('/').'/paypal/cancel-subscription';?>"> <span class="pull-right btn btn-primary">Cancel</span></a>
											@endif
										</div>
									</div>

								<div class="col-sm-12 col-md-8 col-lg-8 col-xl-8 p-0">
									<div class="history-content">
										<h4 class="history-head">
											<i class="fa fa-calendar-o"></i> Current Subscription
											
										</h4>
										<p class="grey-border"></p>
										<div class="sub-details">
											<div class="sub-details-header bg-dark text-white">{{  CurrentPaypalPlan($plan_id) }} Plan</div>
											<div class="sub-details-body">
												<table class="table table-bordered m-0">
													<tbody>
														<tr>
															<td>Subscribed Date</td>
															<td>{{  date('j-F-Y', strtotime($start_time)) }}</td>
														</tr>


														<tr>
															<td>Expiry Date</td>
															<td> {{ date('j-F-Y', strtotime($next_billing_date)) }}</td>
														</tr>
														<tr>
															<td>No of Month</td>
															<td>{{  CurrentPaypalPlan($plan_id) }}</td>
														</tr>
														<tr>
															<td>Total Amount</td>
															<td>{{ "$".$response->billing_info->last_payment->amount->value }}</td>
														</tr>
														<tr>
															<td>Paid Amount</td>
												<td>{{ "$".$response->billing_info->last_payment->amount->value }}</td>

														</tr>
														<tr>
															<td>Payment Mode</td>
															<td>PayPal <i class="fa fa-cc-paypal pull-right"></i></td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
										<p class="margin-top-20"><a href="<?php echo URL::to('/').'/paypal/transaction-details';?>"> <span class="btn btn-primary">View Transactions</span></a></p>
									</div>
									
								</div>
								
							</div>
						<div class="clear"></div> 
                </div>
        </div>
    </div>
</div>

@extends('footer')
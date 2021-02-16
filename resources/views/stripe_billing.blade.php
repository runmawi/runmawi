@include('header')

<div class="container ">
    <div class="row justify-content-center">	
        	<div class="col-md-10 col-sm-offset-1 ">
                
			<div class="login-block nomargin">
                <h1 class="my_profile">
                    <i class="fa fa-edit"></i> 
                    <?php echo __('Stripe Subscription Details');?>
                </h1>
                <?php
                    $next_billing = date('Y-m-d', $stirpe_details->current_period_end);
                    $expire_at = date('j-F-Y', $stirpe_details->current_period_end);
                    $subscription_start = date('j-F-Y', $stirpe_details->current_period_start);
                        $now = time(); // or your date as well
                        $to_date = strtotime($next_billing);
                        $datediff = $to_date - $now;
                        $remaining_days = round($datediff / (60 * 60 * 24));  
                        $status = $stirpe_details->status;
                ?>
		      <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
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
												<p class=""><?=ucfirst($stirpe_details->status);?></p>
											</div>
											<div class="clearfix"></div>
											<p class="grey-border"></p>
											
											<div class="history-div">
												<h5 class="history-head">
													<i class="fa fa-hand-o-right "></i> Next billing date
												</h5>
												<p class=""><?=$next_billing;?></p>
											</div>
											<div class="history-div">
												<h5 class="history-head">
													<i class="fa fa-hand-o-right "></i> Remaining Days
												</h5>
												<p class="">
                                                    <?php if ($remaining_days > 0){ echo $remaining_days;} else { echo "0";}?>
												</p>
											</div>
											<div class="clearfix"></div>
											<p class="grey-border"></p>
											<div class="history-div">
												<h5 class="history-head">
													<i class="fa fa-hand-o-right "></i> Plan Name
												</h5>
												
												<p class=""><?= ucfirst(StripePlanName($stripe_Plan));?> </p>
											</div>
										</div>
										<div class="clearfix"></div>
										<p class="grey-border"></p>
										<div class="text-right">
                                            <?php if ($status =='active'){ ?>
											<a href="<?php echo URL::to('/').'/upgrade-subscription';?>">
												<i class="fa fa-chevron-right"></i>Upgrade Your Plan
											</a>
                                            <?php } ?>
										</div>
										<div class="text-center">
										<?php if ($status =='active'){ ?>
											<a href="<?php echo URL::to('/').'/stripe/cancel-subscription';?>"> <span class="pull-right btn btn-primary">Cancel</span></a>
                                            <?php } ?>
										</div>
                                        <?php 
                                        $stripe_plan = SubscriptionPlan();
                                        $user = Auth::user(); if ($user->subscription($stripe_plan)->ended()) { ?>
											
                                        <a href="<?=URL::to('/renew');?>"> <span class="pull-right btn btn-primary">Renew</span></a>
									   <?php }?>
									</div>

								<div class="col-sm-12 col-md-8 col-lg-8 col-xl-8 p-0">
									<div class="history-content">
										<h4 class="history-head">
											<i class="fa fa-calendar-o"></i> Current Subscription
											
										</h4>
										<p class="grey-border"></p>
										<div class="sub-details">
											<div class="sub-details-header bg-dark text-white"><?= ucfirst(StripePlanName($stripe_Plan));?> Plan</div>
											<div class="sub-details-body">
												<table class="table table-bordered m-0">
													<tbody>
														<tr>
															<td>Subscribed Date</td>
															<td><?=$subscription_start;?></td>
														</tr>
														<tr>
															<td>Expiry Date</td>
															<td><?=$expire_at;?></td>
														</tr>
														<tr>
															<td>No of Month</td>
															<td><?= ucfirst(StripePlanName($stripe_Plan));?> </td>
														</tr>
														<tr>
															<td>Total Amount</td>
															<td><?="$".$stirpe_details->plan->amount/100;?></td>
														</tr>
                                                        <?php if (!empty($stirpe_details->discount->coupon->amount_off)) { ?>
                                                            <tr>
                                                                <td>Discount Amount</td>
                                                                <td><?="$".$stirpe_details->discount->coupon->amount_off/100;?></td>
                                                            </tr>
                                                        <?php } ?>
                                                         <?php if (!empty($stirpe_details->discount->coupon->amount_off)) { ?>
														<tr>
															<td>Paid Amount</td>
															<td>
                                                                $<?=($stirpe_details->plan->amount/100) - ($stirpe_details->discount->coupon->amount_off/100);?></td>
														</tr>
                                                         <?php } else {?>
                                                        <tr>
												             <td>Paid Amount</td>
												            <td>
                                                                $<?=($stirpe_details->plan->amount/100);?></td>
														</tr>
                                                        
                                                        <?php } ?> 
														<tr>
															<td>Payment Mode</td>
															<td>Stripe <i class="fa fa-credit-card pull-right "></i> </td>
														</tr>
													</tbody>
												</table>
											</div>
                                           
										</div>
                                     <p class="margin-top-20"><a href="<?php echo URL::to('/').'/stripe/transaction-details';?>"> <span class="btn btn-primary">View Transactions</span></a></p>
									</div>
									
								</div>
								
							</div>
						<div class="clear"></div> 
                </div>
        </div>
    </div>
</div>



@extends('footer')
@include('header')

 <?php 
    $jsonString = file_get_contents(base_path('assets/country_code.json'));   

    $jsondata = json_decode($jsonString, true); 
?>



<div class="container">
    <div class="row justify-content-center">	
        	<div class="col-md-12">
                
			<div class="login-block nomargin">

            <h1 class="my_profile">
                <i class="fa fa-edit"></i> 
                <?php echo __('Update Your Profile Info');?>
            </h1>

		<div class="clear"></div>   
		<form method="POST" action="<?= $post_route ?>" id="update_profile_form" accept-charset="UTF-8" file="1" enctype="multipart/form-data">
			<div class="well row">
				<div class="col-sm-6 col-xs-12">
					<div class="row">
						<div class="col-sm-12 col-xs-12">
							<label for="avatar">My Avatar - Elite_<?php echo $user->id;?></label>
							<div id="user-badge">
								<img src="<?= URL::to('/') . '/public/uploads/avatars/' . $user->avatar; ?>" />
								<input type="file" multiple="true" class="form-control" name="avatar" id="avatar" />
							</div>	
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 col-xs-12 padding-top-30">
						<?php if ( Auth::user()->role != 'admin') { ?>
							<div class="row">
								<?php if (Auth::user()->role == 'subscriber' && empty(Auth::user()->paypal_id)){ ?>
									<h3> Plan Details:</h3>
									<p><?php echo CurrentSubPlanName(Auth::user()->id);?></p>
								<?php } ?>
								<div class="col-sm-6 col-xs-12 padding-top-30">
									<?php 
                                        $paypal_id = Auth::user()->paypal_id;
                                        if (!empty($paypal_id) && !empty(PaypalSubscriptionStatus() )  ) {
                                        $paypal_subscription = PaypalSubscriptionStatus();
                                        } else {
                                          $paypal_subscription = "";  
                                        }
                                  
									 $stripe_plan = SubscriptionPlan();
									 if ( $user->subscribed($stripe_plan) && empty(Auth::user()->paypal_id) ) { 
										if ($user->subscription($stripe_plan)->ended()) { ?>
											 <a href="<?=URL::to('/renew');?>" class="btn btn-primary noborder-radius margin-bottom-20" > Renew Subscription</a>
									   <?php } else { ?>
									   <a href="<?=URL::to('/cancelSubscription');?>" class="btn btn-danger noborder-radius margin-bottom-20" > Cancel Subscription</a>
											<!--<a href="<?=URL::to('/cancelSubscription');?>" class="btn btn-primary" >Cancel Subscription</a>-->
									 <?php  } } 
                                    elseif(!empty(Auth::user()->paypal_id) && $paypal_subscription !="ACTIVE" )
                                          {   ?>
                                          <a href="<?=URL::to('/becomesubscriber');?>" class="btn btn-primary btn-login nomargin noborder-radius" > Become Subscriber</a>
                                          
                                    <?php } else { echo $paypal_subscription; ?>
										<a href="<?=URL::to('/becomesubscriber');?>" class="btn btn-primary btn-login nomargin noborder-radius" > Become Subscriber</a>
								  	<?php } ?>
								</div>
                                
                                
								<div class="col-sm-6 col-xs-12 padding-top-30">
									<?php
										$billing_url = URL::to('/').'/paypal/billings-details';
										if (!empty(Auth::user()->paypal_id)){
										  echo "<p><a href='".$billing_url."' class='plan-types'> <i class='fa fa-caret-right'></i> View Billing Details</a></p>";
										} 
									?>
									 <?php if ( $user->subscribed($stripe_plan) ) { 
										if ($user->subscription($stripe_plan)->ended()) { ?>
											 <p><a href="<?=URL::to('/renew');?>" class="plan-types" ><i class="fa fa-caret-right"></i> Renew Subscription</a></p>
									   <?php } else { ?>
										   <p><a href="<?=URL::to('/upgrade-subscription');?>" class="plan-types" ><i class="fa fa-caret-right"></i> Change Plan</a></p>
									 <?php  } } ?>

									<?php if ($user->subscribed($stripe_plan) && $user->subscription($stripe_plan)->onGracePeriod()) { ?>
										 <p><a href="<?=URL::to('/renew');?>" class="plan-types" > Renew Subscription</a></p>
									<?php } ?>

									<?php if ($user->subscribed($stripe_plan)) { ?>
												<a href="<?=URL::to('/stripe/billings-details');?>" class="btn btn-primary noborder-radius btn-login nomargin" > View Subscription Details</a>
									<?php } ?>
								</div>
							</div>
							<?php } ?>
								
						</div>
					</div>
				</div>
				
				<div class="col-sm-6 col-xs-12">
					<div class="row">
						<div class="well-in col-sm-12 col-xs-12">
							<?php if($errors->first('name')): ?><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong>Oh snap!</strong> <?= $errors->first('name'); ?></div><?php endif; ?>
							<label for="username" class="lablecolor"><?=__('Username');?></label>
							<input type="text" class="form-control" name="name" id="name" value="<?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?>" />
						</div>
						<div class="well-in col-sm-12 col-xs-12">
							<?php if($errors->first('email')): ?><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong>Oh snap!</strong> <?= $errors->first('email'); ?></div><?php endif; ?>
							<label for="email"><?=__('Email');?></label>
							<input type="text" class="form-control" name="email" id="email" value="<?php if(!empty($user->email)): ?><?= $user->email ?><?php endif; ?>" />
						</div>
						<div class="well-in col-sm-12 col-xs-12">
							<?php if($errors->first('name')): ?><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong>Oh snap!</strong> <?= $errors->first('name'); ?></div><?php endif; ?>
							<label for="username" class="lablecolor"><?=__('Phone Number');?></label>
							<div class="row">
								 <div class="col-sm-6 col-xs-12">
									 <select name="ccode" >
										@foreach($jsondata as $code)
										<option value="{{ $code['dial_code'] }}" <?php if($code['dial_code'] == $user->ccode ) { echo "selected='selected'"; } ?>> {{ $code['name'].' ('. $code['dial_code'] . ')' }}</option>
										@endforeach
									</select>
								</div>
								<div class="col-sm-6 col-xs-12">
									<input type="text" class="form-control" name="mobile" id="mobile" value="<?php if(!empty($user->mobile)): ?><?= $user->mobile ?><?php endif; ?>" />
								</div>
							</div>
						</div>
						<div class="well-in col-sm-12 col-xs-12">
							<label for="password"><?=__('Password');?> (leave empty to keep your original password)</label>
							<input type="password" class="form-control" name="password" id="password"  />
						</div>
						<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
						<div class="col-sm-12 col-xs-12">
							<input type="submit" value="<?=__('Update Profile');?>" class="btn btn-primary" />
						</div>
					</div>
				</div>
			</div>
			<div class="clear"></div>
		</form>
        </div>
        </div>
    </div>
</div>

@extends('footer')
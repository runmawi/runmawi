@include('header')

 <?php 
    $jsonString = file_get_contents(base_path('assets/country_code.json'));   

    $jsondata = json_decode($jsonString, true); 
?>

 <?php 
     $paypal_id = Auth::user()->paypal_id;
      if (!empty($paypal_id) && !empty(PaypalSubscriptionStatus())) 
      {
       $paypal_subscription = PaypalSubscriptionStatus();
      } else {
        $paypal_subscription = "";  
     }
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
						    @if ( Auth::user()->role != 'admin')
                            <div class="row">
                              @if (Auth::user()->role == 'subscriber' && !empty(Auth::user()->paypal_id))
                                
                                @if ( $paypal_subscription== 'ACTIVE' )
                                    <a href="<?php echo URL::to('/').'/paypal/cancel-subscription';?>"> 
                                        <span class="btn btn-danger noborder-radius margin-bottom-20">Cancel Subscription </span>
                                    </a>
                                    @elseif ( $paypal_subscription == 'CANCELLED')
                                        <a href="<?php echo URL::to('/').'/upgrade-subscription';?>"> 
                                            <span class="pull-right btn btn-primary">Renew Subscription</span>
                                        </a>
                                
                                @endif
                              @endif
                                
                            <?php 
                                $stripe_plan = SubscriptionPlan(); 
                                $user = Auth::user(); 
                            ?>  
                        @if ( $user->subscribed($stripe_plan) && empty(Auth::user()->paypal_id) )   
                            @if ($user->subscription($stripe_plan)->ended()) 
                                    <a href="<?=URL::to('/renew');?>" class="btn btn-primary noborder-radius margin-bottom-20" > Renew Subscription</a>
                            @elseif($user->subscribed($stripe_plan) && $user->subscription($stripe_plan)->onGracePeriod() )
								<p><a href="<?=URL::to('/renew');?>" class="plan-types" > Renew Subscription</a></p>
                            @else
                                 <p><a href="<?=URL::to('/upgrade-subscription');?>" class="plan-types" ><i class="fa fa-caret-right"></i> Change Plan</a></p>
                           
                            @endif
                            @if ($user->subscribed($stripe_plan))
								    <p>
                                        <a href="{{ URL::to('/stripe/billings-details')}}"  class='plan-types' >  <i class='fa fa-caret-right'></i> View Subscription Details</a>
                                    </p>
								
                                    @endif
                            @endif
                            </div>
                            @endif
                            
                            @if ( Auth::user()->role == 'registered' )
                             <a href="<?=URL::to('/becomesubscriber');?>" class="btn btn-primary btn-login nomargin noborder-radius" > Become Subscriber</a>
                            @endif
                            
						</div>
                        <div class="col-sm-6 col-xs-12 padding-top-30">
                           <?php $billing_url = URL::to('/').'/paypal/billings-details';
                            $upgrade_url = URL::to('/').'/upgrade-subscription';
								if (!empty(Auth::user()->paypal_id)){
								echo "<p><a href='".$billing_url."' class='plan-types'> <i class='fa fa-caret-right'></i> View Billing Details</a></p>";
								} 
                            
                                if (!empty(Auth::user()->paypal_id)){
								echo  "<p><a href='".$upgrade_url."' class='plan-types' ><i class='fa fa-caret-right'></i> Change Plan</a></p>";
								} 
				            ?> 
                            
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
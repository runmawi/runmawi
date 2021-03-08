@include('header')

 <?php 
    $jsonString = file_get_contents(base_path('assets/country_code.json'));   

    $jsondata = json_decode($jsonString, true); 
?>
       <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">-->
        <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
		<!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">-->
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<style>
    .form-popup {
  display: none;
    }
    .personal{
        border-top: 1px solid #999;
        padding-bottom: 20px;
    }
    .Subplan{
        border-top: 1px solid #999;
        padding-bottom: 20px;
    }
    .Profile{
        border-top: 1px solid #999;
        padding-bottom: 20px;
    }
     .card{
        border-top: 1px solid #999;
         padding-bottom: 20px;
    }
    .details-back{
       background-color: transparent;
    margin-left: 350px;
    top: 80px;
    }
    .btn-primary {
    background: #4895d1;
    border-color: #4895d1;
}
    .btn-primary:hover, .btn-primary:focus, .btn-primary:active, .btn-primary.active, .open .dropdown-toggle.btn-primary {
    background-color: #4895d1;
    border-color: #4895d1;
}
    .data-back{
        background-color: #333;
    opacity: 0.5;
    height: 460px;
    }
    .editbtn{
        float: right;
    }
    input.form-control#email {
     background-color: #1a1b20; 
     border: none; 
    color: #fff;
    box-shadow: none;
}
    input.form-control#password {
   background-color: #1a1b20; 
     border: none; 
    color: #fff;
    box-shadow: none;
}
    #update_profile_form .form-control {
    background: #1a1b20 !important;
   border: none;
    color: #fff;
}
    
</style>

<div class="container data-mdb-smooth-scroll">
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
				<!--<div class="col-sm-6 col-xs-12">
					<div class="row">
						<div class="col-sm-12 col-xs-12">
							<label for="avatar">My Avatar - Elite_<?php echo $user->id;?></label>
							<div id="user-badge">
								<img src="<?= URL::to('/') . '/public/uploads/avatars/' . $user->avatar; ?>" />
								<input type="file" multiple="true" class="form-control" name="avatar" id="avatar" />
							</div>	
						</div>
					</div>
				</div>-->
                <!--popup-->
                <div class="form-popup " id="myForm" style="background:url(<?php echo URL::to('/').'/assets/img/Landban.png';?>) no-repeat;	background-size: cover;
    height: 665px;">
                <div class="col-sm-4 details-back">
					<div class="row data-back">
						<div class="well-in col-sm-12 col-xs-12" >
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
                             <button type="button" class="btn btn-primary" onclick="closeForm()">Close</button>
						</div>
					</div>
				</div>
                </div>
				
				<!--<div class="col-sm-6 col-xs-12">
					<div class="row">
						<div class="well-in col-sm-12 col-xs-12">
							<?php if($errors->first('name')): ?><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong>Oh snap!</strong> <?= $errors->first('name'); ?></div><?php endif; ?>
							<label for="username" class="lablecolor"><?=__('Username');?></label>
							<input type="text" readonly class="form-control" name="name" id="name" value="<?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?>" />
						</div>
						<div class="well-in col-sm-12 col-xs-12">
							<?php if($errors->first('email')): ?><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong>Oh snap!</strong> <?= $errors->first('email'); ?></div><?php endif; ?>
							<label for="email"><?=__('Email');?></label>
							<input type="text" readonly class="form-control" name="email" id="email" value="<?php if(!empty($user->email)): ?><?= $user->email ?><?php endif; ?>" />
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
									<input type="text" readonly class="form-control" name="mobile" id="mobile" value="<?php if(!empty($user->mobile)): ?><?= $user->mobile ?><?php endif; ?>" />
								</div>
							</div>
						</div>
						<div class="well-in col-sm-12 col-xs-12">
							<label for="password"><?=__('Password');?> (leave empty to keep your original password)</label>
							<input type="password" readonly class="form-control" name="password" id="password"  />
						</div>
						<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
						<div class="col-sm-12 col-xs-12">
							<input type="submit" value="<?=__('Update Profile');?>" class="btn btn-primary" />
						</div>
					</div>
				</div>-->
                <!--new design-->
                
                <div class="row personal" id="personal">
                    <h2>Profile</h2>
                    <div class="col-sm-4">
                        <label for="username" class="lablecolor"><?=__('Username');?></label><br>
                        <label for="email"><?=__('Email');?></label><br>
                        <label for="username" class="lablecolor"><?=__('Phone Number');?></label><br>
                        <label for="password"><?=__('Password');?></label>
                    </div>
                    <div class="col-sm-4">
                    <input type="text" readonly class="form-control" name="name" id="name" value="<?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?>" />
                    <input type="text" readonly class="form-control" name="email" id="email" value="<?php if(!empty($user->email)): ?><?= $user->email ?><?php endif; ?>" />
                    <input type="text" readonly class="form-control" name="mobile" id="mobile" value="<?php if(!empty($user->mobile)): ?><?= $user->mobile ?><?php endif; ?>" />
                    <input type="password" readonly class="form-control" name="password" id="password"  /></div>
                    <div class="col-sm-4">
                        <a type="button" class="btn btn-primary  noborder-radius btn-login nomargin editbtn" onclick="openForm()">Edit Profile</a>
                       
                    </div>
                </div>
                 <div class="row Subplan" id="subplan">
                     <h2>Plan Details</h2>
                    <div class="col-sm-4">
                       Subscriptions
                    </div>
                    <div class="col-sm-4">
                        Free Plan
                    </div>
                    
                    <div class="col-sm-4">
                        
                        <a href="<?=URL::to('/stripe/billings-details');?>" class="btn btn-primary noborder-radius btn-login nomargin editbtn" >Edit Plan Details</a>
                    </div>
                </div>
                 <div class="row Profile" id="Profile">
                     <h2>Manage Profile</h2>
                    <div class="col-sm-4">
                       Avatar
                    </div>
                    <div class="col-sm-4">
                        <label for="avatar">My Avatar - Elite_<?php echo $user->id;?></label>
						<img height="100" width="100" src="<?= URL::to('/') . '/public/uploads/avatars/' . $user->avatar; ?>" />	
                        
                    </div>
                    <div class="col-sm-4">
                        <div id="user-badge">
								<input type="file" multiple="true" class="form-control editbtn" name="avatar" id="avatar" />
                             <input type="submit" value="<?=__('Update Profile');?>" class="btn btn-primary  noborder-radius btn-login nomargin editbtn" />
							</div>	

                       
                    </div>
                </div>
                 <div class="row card" id="card">
                     <h2>Card Details</h2>
                    <div class="col-sm-4">
                       Card1
                    </div>
                    <div class="col-sm-4">
                        
                    </div>
                    <div class="col-sm-4">
<!--                        <input type="button" class="btn btn-primary  noborder-radius btn-login nomargin editbtn" value="Add Card" />-->
                        <input type="button" class="btn btn-primary  noborder-radius btn-login nomargin editbtn" value="Card Details" />
                       
                    </div>
                </div>
                <div class="row" id="subscribe">
                    <a href="<?=URL::to('/becomesubscriber');?>" class="btn btn-primary btn-login nomargin noborder-radius" > Become Subscriber</a>
                    <a href="<?=URL::to('/stripe/billings-details');?>" class="btn btn-primary noborder-radius btn-login nomargin" > View Subscription Details</a>
                     
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
											<a href="<?=URL::to('/cancelSubscription');?>" class="btn btn-primary" >Cancel Subscription</a>
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
			<div class="clear"></div>
		</form>
        </div>
        </div>
       
    </div>
</div>
 
<!--<div class="form-popup" id="myForm">
  <form action="/action_page.php" class="form-container">
    <h1>Login</h1>

    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="email" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>

    <button type="submit" class="btn">Login</button>
    <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
  </form>
</div>-->
<script>
function openForm() {
  document.getElementById("myForm").style.display = "block";
    document.getElementById("personal").style.display = "none";
    document.getElementById("subplan").style.display = "none";
     document.getElementById("Profile").style.display = "none";
    document.getElementById("card").style.display = "none";
        document.getElementById("subscribe").style.display = "none";
}
</script>
<script>
function closeForm() {
  document.getElementById("myForm").style.display = "none";
     document.getElementById("personal").style.display = "block";
    document.getElementById("subplan").style.display = "block";
     document.getElementById("Profile").style.display = "block";
    document.getElementById("card").style.display = "block";
        document.getElementById("subscribe").style.display = "block";
}
</script>

@extends('footer')
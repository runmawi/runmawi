@include('header')

<style>
    .lablecolor{
        color: #000;
    }
    #update_profile_form label {
    color: #756969;
    } .list-group-item {
        color: #000;
    }
    .referral {
    margin-top: 80px;
}
    
</style>
<?php
if (Auth::user()) { 
    $current_url = url()->current();
    $twitter_share = urlencode(Auth::user()->referral_link);
    $user_id = Auth::user()->id;
    $coupons = App\Coupon::all();
         $user_id = Auth::user()->id;
         foreach($coupons as $coupon) { 
            $coupon_code = $coupon->coupon_code;
         } 
}
?>

<div class="container-fluid">
    <div class="row page-height margin-top-20">	
        	<div class="col-md-12" align="center">
			<div class="referral">
                
                <?php 
                if ( Auth::user() && Auth::user()->role == 'subscriber') { ?>

                    <h1 class="title"  style="color:#fff;"><i class="fa fa-comments"></i> Tell friends about Flicknexs <a href="<?php echo URL::to('/my-refferals');?>"><span class="pull-right" style="background: #c3ab06;padding: 10px;border-radius: 30px;color: #fff;font-size: 16px;">My referral</span> </a> </h1>
				    <p class="grey-border"></p>
               
		        	<div class="clear"></div>
					
                
                	<div class="referral-body">
						<div class="row">
							<div class="col-md-12">
								<div class=""><h2 class="sub-title">Share this link so your friends can join the conversation around all your favorite TV shows and movies.</h2>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-8">
								<div class="row">
									<p style="padding-left: 15px;">Referral link </p>
                                        <div class="col-sm-8" style="padding-right:0;">
<!-- <input type="text" class="form-control" value="{{ URL::to('/signup').'?ref='.Auth::user()->referral_token }}&coupon={{$coupon_code}}" id="myInput" disabled> -->
                                        <p id="p1" class="form-control" style="background:#fff;">
                                            {{ URL::to('/signup').'?ref='.Auth::user()->referral_token }}&coupon={{$coupon_code}}</p>
                                        </div>
									<div class="col-sm-2">
										<button class="btn btn-primary" onclick="copyToClipboard('#p1')">Copy Link</button>
									</div>
								</div>
								<ul class="list-group mt-3" >
									<li class="list-group-item">Username: <strong>{{ Auth::user()->username }}</strong></li>
									<li class="list-group-item">Email: <strong>{{ Auth::user()->email }}</strong></li>
									<li class="list-group-item">Referrer: <strong>{{ Auth::user()->referrer->name ?? 'Not Specified' }}</strong></li>
									<li class="list-group-item">Referral count: <strong>{{ ReferrerCount(Auth::user()->id)  ?? '0' }}</strong></li>
									<li class="list-group-item">Used Coupon  count: <strong>{{ GetCouponPurchase($user_id)  ?? '0' }}</strong></li>
									<li class="list-group-item">Available Coupon  count: <strong>{{ ReferrerCount(Auth::user()->id)  - GetCouponPurchase($user_id)  ?? '0' }}</strong></li>
								</ul>
							</div>
							<div class="col-md-4">
								<p>Share on Social Media </p>
								<ul class="rrssb-buttons clearfix">
									<li class="rrssb-facebook small">
										<a href="https://www.facebook.com/sharer/sharer.php?u={{ Auth::user()->referral_link }}&coupon={{$coupon_code}}" class="popup">
											<span class="rrssb-icon">
												<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="28px" height="28px" viewBox="0 0 28 28" enable-background="new 0 0 28 28" xml:space="preserve">
													<path d="M27.825,4.783c0-2.427-2.182-4.608-4.608-4.608H4.783c-2.422,0-4.608,2.182-4.608,4.608v18.434
														c0,2.427,2.181,4.608,4.608,4.608H14V17.379h-3.379v-4.608H14v-1.795c0-3.089,2.335-5.885,5.192-5.885h3.718v4.608h-3.726
														c-0.408,0-0.884,0.492-0.884,1.236v1.836h4.609v4.608h-4.609v10.446h4.916c2.422,0,4.608-2.188,4.608-4.608V4.783z"/>
												</svg>
											</span>
										</a>
									</li>
									<li class="rrssb-twitter small">
										<a href="https://twitter.com/intent/tweet?url={{ Auth::user()->referral_link }}&coupon={{$coupon_code}}" class="popup">
											<span class="rrssb-icon">
												<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
													 width="28px" height="28px" viewBox="0 0 28 28" enable-background="new 0 0 28 28" xml:space="preserve">
												<path d="M24.253,8.756C24.689,17.08,18.297,24.182,9.97,24.62c-3.122,0.162-6.219-0.646-8.861-2.32
													c2.703,0.179,5.376-0.648,7.508-2.321c-2.072-0.247-3.818-1.661-4.489-3.638c0.801,0.128,1.62,0.076,2.399-0.155
													C4.045,15.72,2.215,13.6,2.115,11.077c0.688,0.275,1.426,0.407,2.168,0.386c-2.135-1.65-2.729-4.621-1.394-6.965
													C5.575,7.816,9.54,9.84,13.803,10.071c-0.842-2.739,0.694-5.64,3.434-6.482c2.018-0.623,4.212,0.044,5.546,1.683
													c1.186-0.213,2.318-0.662,3.329-1.317c-0.385,1.256-1.247,2.312-2.399,2.942c1.048-0.106,2.069-0.394,3.019-0.851
													C26.275,7.229,25.39,8.196,24.253,8.756z"/>
												</svg>
											</span>
										   <!-- <span class="rrssb-text">twitter</span> -->
										</a>
									</li>
									<!-- <li class="rrssb-email"></li> -->
								</ul>
							</div>
						</div>
                        
                   
                </div>
               
                </div>
            <?php } elseif( Auth::user() && Auth::user()->role == 'registered'){ ?>
                	<div class="referral-body">
						<div class="row">
							<div class="col-md-10 col-sm-offset-1 refernearn">
									<h1 class="text-center"> Refer 'N' Earn with Flicknexs</h1>                                       
									<img src="<?php echo URL::to('/').'/assets/img/users.png';?>" class="img-responsive" />
                                    <p class="text-center">
                                        Flicknexs Refer'N'Earn offer for Coupon Codes. Each user can earn a coupon code after your get subscribed with us. The offer provides Coupon Code on every successful referral Subscriptions.
                                    </p>   
                                
                                    <p class="text-center">Here is a chance to become a Referrer.</p>
									<div class="text-center">
										<a href="<?php echo URL::to('/').'/becomesubscriber';?>" class="btn btn-primary btn-login nomargin noborder-radius text-center"> Become Subscriber</a>
									</div>
                            	</div> 
                            </div>
                        </div>
              
                    
               <?php } else{ ?>
                    <div class="referral-body">
						<div class="row">
							<div class="col-md-10 col-sm-offset-1 refernearn">
								<h1 class="text-center"> Refer 'N' Earn with Flicknexs</h1> 
								<img src="<?php echo URL::to('/').'/assets/img/users.png';?>" class="img-responsive" />
								<p class="text-center">
									Flicknexs Refer'N'Earn offer for Coupon Codes. Each user can earn a coupon code after your get subscribed with us. The offer provides Coupon Code on every successful referral Subscriptions.
								</p>   

							    <p class="text-center">Here is a chance to become a Referrer.</p>
								<div class="text-center">
									<a href="<?php echo URL::to('/').'/login';?>" class="btn btn-primary btn-login nomargin noborder-radius text-center"> Click here to Become Subscriber</a>
								</div>
                            </div>    
						</div>
                     </div>
                <?php } ?>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<script>
function copyToClipboard(element) {
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val($(element).text()).select();
  document.execCommand("copy");
  $temp.remove();
}

</script>

@extends('footer')
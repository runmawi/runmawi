@extends('layouts.app')

@section('content')
@include('/header')

<div class="container">
    <div class="row justify-content-center" id="signup-form">
         
                  
        <div class="col-md-10 col-sm-offset-1">
			<div class="login-block">
				<a class="login-logo" href="<?php echo URL::to('/');?>">
                    <?php
                    $settings = App\Setting::first();
                    ?>
                    
                    <img src="<?php echo URL::to('/').'/public/uploads/settings/' . $settings->logo; ?>">
                </a>
            
                <div class="panel-heading"><h1>{{ __('Upgrade Now') }}</h1></div>

                <div class="panel-body">
       
     <form action="<?php echo URL::to('/').'/upgradeSubscription';?>" method="POST" id="payment-form" enctype="multipart/form-data">
        @csrf
         
          <div class="form-group row">
            <label for="plan_name" class="col-md-4 col-sm-offset-1 col-form-label text-right">{{ __('Choose Your Plan') }}</label>
                <div class="col-md-6">
                <select name="plan_name" id="plan_name"  class="form-control" >
                        <?php 
                            $plans = App\SubscriptionPlan::all();
                            $user_id = Auth::user()->id;
                            foreach($plans as $plan) {
                            $current_plan = CurrentSubPlan($user_id);
                              if (  $current_plan !== $plan->plans_name ) {   
                          ?>
                                <option value="<?php echo $plan->plan_id;?>"><?php echo __($plan->plans_name);?></option>
                        <?php } } ?>
                    </select>
                    
                </div>
         </div>     
         
          <?php 
         $available_coupon = count(Auth::user()->referrals)  - GetCouponPurchase($user_id)  ?? '0';
         
         if (CouponStatus() == 1 && $available_coupon > 0){ ?>
             <div class="form-group row">
                <label for="plan_name" class="col-md-4 col-sm-offset-1 col-form-label text-md-right text-right">{{ __('Coupon Code') }}</label>
                    <div class="col-md-6">
                            <?php 
                                $coupons = App\Coupon::all();
                                $user_id = Auth::user()->id;
                                foreach($coupons as $coupon) { ?>
                                <input type="text" name="coupon_code" class="form-control" value="<?php echo $coupon->coupon_code;?>" readonly>
                            <?php } ?>
                    </div>
             </div>
         <?php } ?>
         
        
                <div class="form-group row">
							<div class="col-md-10 col-sm-offset-1">
                                <div class="pull-right sign-up-buttons">

                                    <button class="btn btn-primary btn-login" type="submit" name="create-account">{{ __('Upgrade Subscription') }}</button>

                                </div>
							</div>
                </div>

        </form>
         
         
         </div>
    </div>
</div>
    </div>
</div>
@include('footer')
@endsection 

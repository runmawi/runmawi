@extends('layouts.app')

@section('content')
@include('/header')

<style>
* {
  box-sizing: border-box;
}

.columns {
  float: left;
  width: 25%;
  padding: 8px;
}

.price {
  list-style-type: none;
  
  margin: 0;
  padding: 0;
  -webkit-transition: 0.3s;
  transition: 0.3s;
}

.price:hover {
  box-shadow: 0 8px 12px 0 rgba(0,0,0,0.2)
}

.price .header {
    background-color: #111;
    color: white;
    font-size: 20px;
}

.price li {
 
  padding: 20px;
  text-align: center;
}

.price .grey {
  background-color: #eee;
  font-size: 20px;
}

.button {
  background-color: #ccb209;
  border: none;
  color: white;
  padding: 10px 25px;
  text-align: center;
  text-decoration: none;
  font-size: 18px;
}
    .plan-block {
        margin-top: 20px;
    }
#signup-form label{
  text-align: left !important;
}
@media only screen and (max-width: 600px) {
  .columns {
    width: 100%;
  }
}
</style>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<div class="container">
    

    <div class="row justify-content-center " id="signup-form">
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
       
     <form >
        @csrf
            <div class="form-group row col-sm-offset-1">

               <h2>Our Plans</h2>
    
            <?php 
                $plans = App\Plan::all();
                   foreach($plans as $plan) {
                ?>
                    <div class="columns">
                      <ul class="price">
                        <li class="header"><?php echo $plan->plans_name;?></li>
                        <li class=""><a href="#" class="button"><?php echo "$".$plan->price;?></a></li>
                      </ul>
                    </div>
               <?php } ?>

                <label for="plan_name" class="col-md-4 col-form-label text-right">{{ __('Choose Your Plan') }}</label>
                    <div class="col-md-6 ">
                    <select name="plan_name" id="plan_name"  class="form-control" >
                            <?php 
                                $plans = App\Plan::all();
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
                          <button class="btn btn-primary btn-login btn-submit" type="submit" name="create-account">{{ __('Upgrade Subscription') }}</button>
                  </div>
							</div>
                </div>

        </form>
         
         <input type="hidden" id="base_url" value="<?php echo URL::to('/');?>">
         </div>
    </div>
</div>
    </div>
</div>
<script type="text/javascript">
var base_url = $('#base_url').val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(".btn-submit").click(function(e){

        e.preventDefault();

        var plan_name = $("#plan_name").val();
        var coupon_code = $("#coupon_code").val();
       
 swal({
        title: "Are you sure ??",
            text: 'Want to Change this Plan?', 
            icon: "warning",
            buttons: true,
            dangerMode: true,
     })
       .then((willDelete) => {
          if (willDelete) {
                $.ajax({
                   type:'POST',
                   url:base_url+'/upgradeSubscription',
                   data:{plan_name:plan_name, coupon_code:coupon_code, _token: '<?= csrf_token(); ?>'},
                   success:function(data){
                      swal(data.success);
                      setTimeout(function() {
                        window.location.replace(base_url+'/myprofile'); 
                      }, 2000);
                   }
                });
            } 
          });
      });
</script>
@include('footer')
@endsection 

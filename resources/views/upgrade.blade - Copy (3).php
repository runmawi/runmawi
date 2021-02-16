@extends('layouts.app')

@section('content')
@include('/header')

<script src="https://www.paypal.com/sdk/js?client-id=Aclkx_Wa7Ld0cli53FhSdeDt1293Vss8nSH6HcSDQGHIBCBo42XyfhPFF380DjS8N0qXO_JnR6Gza5p2&vault=true&intent=subscription" data-sdk-integration-source="button-factory"></script>

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

@media only screen and (max-width: 600px) {
  .columns {
    width: 100%;
  }
}
    /* Style the tab */
.tab {
  overflow: hidden;
  margin-left: 33%;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #111;
}

/* Create an active/current tablink class */
.tab button.active {
  border-bottom: 2px solid #c3ab06;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: none;
  border-top: none;
}
.buttons-container {
    width: 1% !important;
    margin-left: 22%  !important;
    }  
    .hide-box {
        display: none;
    }
    
</style>

<script>
  $( function() {
    $( "#tabs" ).tabs();
    $("tabs li:first").addClass("active");
  });
    
  </script>

<div class="container">
    
<?php 
    $ref = Request::get('ref');
    $coupon = Request::get('coupon');
?>
    <div class="row justify-content-center" id="signup-form">
         
                  
        <div class="col-md-10 col-sm-offset-1">
			<div class="login-block">
				<a class="login-logo" href="<?php echo URL::to('/');?>">
                    <?php
                    $settings = App\Setting::find(1);
                    ?>
                    
                    <img src="<?php echo URL::to('/').'/public/uploads/settings/' . $settings->logo; ?>">
                </a>
            
                  <div class="panel-heading"><h1>Choose You Plan</h1></div>

<div class="panel-body">
    
    <div class="tab">
          <button class="tablinks active" onclick="openCity(event, 'London') " id="defaultOpen"><input type="radio" name="payment" id="payment"> Stripe Payment</button>
          <button class="tablinks" onclick="openCity(event, 'Paris')"><input type="radio"  name="payment" id="payment"> Paypal Payment</button>
        </div>

        <div id="London" class="tabcontent">
                 <h2 class="text-center">Our Plans</h2>
    <form>
      @csrf
       <?php 

         $plans = App\Plan::all();
         $user_id = Auth::user()->id;
         foreach($plans as $plan) {
         $current_plan = CurrentSubPlan($user_id);
         if (  $current_plan !== $plan->plans_name ) {   
        
        ?>
            <div class="columns">
              <ul class="price">
                    <li class="header"><input type="radio" name="plan_name" id="plan_name" class="plan_name" value="<?php echo $plan->plan_id;?>" required> 
                         <?php echo $plan->plans_name;?>
                    </li>
                    <li class="">
                        <a href="#" class="button">
                            <?php echo "$".$plan->price;?>
                        </a>
                    </li>
              </ul>
            </div>
        
        <?php } } ?>
        
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
                                <input type="text" name="coupon_code" id="coupon_code" class="form-control" value="<?php echo $coupon->coupon_code;?>" readonly>
                            <?php } ?>
                    </div>
             </div>
         <?php } ?>
         @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

         <div class="form-group row">
							<div class="col-md-10 col-sm-offset-1">
							<div class="pull-right sign-up-buttons">
                                <button class="btn btn-primary btn-login btn-submit update-submit" type="submit" name="create-account">
                                        {{ __('Upgrade Subscription') }}
                                </button>
							  <span>Or</span>
							   <a type="button" href="<?php echo URL::to('/').'/registerUser';?>" class="btn btn-warning"><?php echo __('Skip');?></a>
							</div>
							</div>
         </div>
        </form>
         
        </div>
<div id="Paris" class="tabcontent">
    <h2 class="text-center">Our Subscription Plans</h2>
     <form action="<?php if (isset($ref) ) { echo URL::to('/').'/register2?ref='.$ref.'&coupon='.$coupon; } else { echo URL::to('/').'/register2'; } ?>" method="POST" id="payment-form" enctype="multipart/form-data">
    <?php 
        $plans = App\PaypalPlan::all();
           foreach($plans as $plan) {
        ?>
            <div class="columns">
              <ul class="price">
                <li class="header"> <input type="radio" name="paypal_plan" id="paypal_plan" value="<?php echo $plan->plan_id;?>" required> <?php echo $plan->name;?></li>
                <li class=""><a href="#" class="button"><?php echo "$".$plan->price;?></a></li>
              </ul>
            </div>
       <?php } ?>    
        @csrf
         @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

         <div class="form-group row">
                <div class="col-md-10 col-sm-offset-1">
				      <div class="pull-right sign-up-buttons">
<!--							  <button class="btn btn-primary btn-login" type="submit" name="create-account">{{ __('Pay Now') }}</button>-->
           
							 
							</div>
				</div>
         </div>
        <div class="form-group row">
							<div class="col-md-10 col-sm-offset-1">
							<div class="pull-right sign-up-buttons">
                                <button class="btn btn-primary btn-login btn-submit update-paypal-subscriotion" type="submit" name="create-account">
                                        {{ __('Upgrade Subscription') }}
                                </button>
							  <span>Or</span>
							   <a type="button" href="<?php echo URL::to('/').'/registerUser';?>" class="btn btn-warning"><?php echo __('Skip');?></a>
							</div>
							</div>
         </div>
        </form>         
        </div>
         </div>
    </div>
</div>
    </div>
</div>
<input type="hidden" id="base_url" value="<?php echo URL::to('/');?>">
<script>
var base_url = $('#base_url').val();
    
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
    // Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click(); 
</script>

<script>
    
    $("input[name='name']").change(function(){
       var pid = $(this).val();
       $('#paypal-button-container').html("");
       $('.hide-box').css("display","block");
       $('.hide-box').css("  transition-delay","2s");
            
    });
    
</script>

<script type="text/javascript">
var base_url = $('#base_url').val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(".update-submit").click(function(e){
        e.preventDefault();
        var plan_name = $('input:radio[name=plan_name]:checked').val();
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
    
    $(".update-paypal-subscriotion").click(function(e){
        e.preventDefault();
        var plan_name = $('input:radio[name=paypal_plan]:checked').val();
        // var coupon_code = $("#coupon_code").val();    
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
                           url:base_url+'/upgradePaypal',
                           data:{plan_name:plan_name, _token: '<?= csrf_token(); ?>'},
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
@extends('layouts.app')

@section('content')
@include('/header')
    <script src="https://www.paypal.com/sdk/js?client-id=Aclkx_Wa7Ld0cli53FhSdeDt1293Vss8nSH6HcSDQGHIBCBo42XyfhPFF380DjS8N0qXO_JnR6Gza5p2&vault=true&intent=subscription" data-sdk-integration-source="button-factory">
        
    </script>
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
                          <button class="tablinks" onclick="openCity(event, 'Paris')"><input type="radio" type="radio" name="payment" id="payment"> Paypal Payment</button>
                        </div>

        <div id="London" class="tabcontent">
             
                 <h2 class="text-center">Our Plans</h2>
               
    <form action="<?php if (isset($ref) ) { echo URL::to('/').'/register2?ref='.$ref.'&coupon='.$coupon; } else { echo URL::to('/').'/register2'; } ?>" method="POST" id="payment-form" enctype="multipart/form-data">
    
    <?php 
        $plans = App\Plan::all();
           foreach($plans as $plan) {
        ?>
            <div class="columns">
              <ul class="price">
                <li class="header">
                    <input type="radio" data-price="<?php echo $plan->price;?>" data-name="<?php echo $plan->plans_name;?>" name="plan_name" id="plan_name" value="<?php echo $plan->plan_id;?>" required > <?php echo $plan->plans_name;?></li>
                
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
             
         <div class="row col-offset-1">
        
            <table class="table">
              <thead>
                <tr>
                 
                  <th scope="col">Plan Name</th>
                  <th scope="col" class="detail_name" id="detail_name"></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Amount</td>
                  <td  class="detail_price" id="detail_price"></td>
                </tr>
                <tr>
                  <td>Coupon Code</td>
                  <td class="detail_stripe_coupon"  id="detail_stripe_coupon"></td>
                </tr>
                <tr>
                  <td>Discount Price</td>
                  <td class="coupon_percentage"  id="coupon_percentage"></td>
                </tr>
                <tr>
                  <td>Total Price</td>
                  <td class="total_price"  id="total_price"></td>
                </tr>
              </tbody>
            </table>
        
        </div>
        

         <div class="form-group row">
            
             <div class="col-md-8 col-sm-offset-1">
                <div class="pull-right sign-up-buttons">
				    <button class="btn btn-primary btn-login" type="submit" name="create-account">{{ __('Pay Now') }}</button>
				        <span>Or</span>
				        <a type="button" href="<?php echo URL::to('/').'/registerUser';?>" class="btn btn-warning">
                            <?php echo __('Skip');?>
                        </a>
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
                <li class="header"> <input type="radio" name="name" id="paypal_plan" value="<?php echo $plan->plan_id;?>" required> <?php echo $plan->name;?></li>
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
        <div class="row" >
            <div class="col-sm-offset-1">
                <div class="col-sm-6">
                        <div id="paypal-button-container"></div>
                </div>
                 <div class="col-sm-2 hide-box" style="margin-top: 4%;text-align: center;">
                      <span class=" text-center">(OR)</span>
                </div>
                 <div class="col-sm-4 hide-box" style="margin-top: 2%;">
                        <div class="text-center  pull-left" style="width: 100%;">
                              <a type="button" href="<?php echo URL::to('/').'/registerUser';?>" class="btn btn-lg btn-primary btn-block form-control"><?php echo __('Skip');?></a>
                        </div>
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
<input type="hidden" id="stripe_coupon_code" value="<?php echo NewSubscriptionCouponCode();?>">
<input type="hidden" value="<?php echo DiscountPercentage();?>" id="discount_percentage" class="discount_percentage">
<input type="hidden" value="<?php echo NewSubscriptionCoupon();?>" id="discount_status" class="discount_status">

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
       $('#paypal-button-container').html("");
        var pid = $(this).val();
       $('#paypal-button-container').html("");
       $('.hide-box').css("display","block");
       $('.hide-box').css("  transition-delay","2s");
    
      paypal.Buttons({
          style: {
              shape: 'rect',
              color: 'gold',
              layout: 'vertical',
              label: 'subscribe'
          },
          createSubscription: function(data, actions) {
            return actions.subscription.create({
              'plan_id': pid
            });
          },
          onApprove: function(data, actions) {
              var subId = data.subscriptionID;
               $.post(base_url+'/submitpaypal', {
                 subId:subId , _token: '<?= csrf_token(); ?>' 
               }, 
                function(data){
                    setTimeout(function() {
                    //location.reload();
                    window.location.replace(base_url+'/login');
                        
                  }, 2000);
               });              
              
          }
      }).render('#paypal-button-container');
    });
    
</script>

<script>
    $("input[name='plan_name']").change(function(){
       var pid = $(this).val();
       var attr_price = $(this).attr('data-price');
       var discount_status = $("#discount_status").val();
      var plan_name_data =  $(this).attr('data-name');
        
       $('#detail_name').html(plan_name_data);
       $('#detail_price').html(attr_price+" USD");
        
        if ( discount_status == 1) {
            
            $('.coupon_enabled').css("display","block");
            
            var stripe_coupon_code = $("#stripe_coupon_code").val();
           
               var discount = $("#discount_percentage").val();
               var discount_percentage = (attr_price/100)*discount;
               var total_price = (attr_price - discount_percentage);
                $('#detail_stripe_coupon').html(stripe_coupon_code);
                $('#coupon_percentage').html(discount_percentage+" USD");
                $('#total_price').html(total_price+" USD");
        }
       $('.hide-box').css("display","block");
       $('.hide-box').css("  transition-delay","2s");
    
            
    });
    
</script>




@include('footer')
@endsection 
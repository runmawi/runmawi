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
      overflow: hidden;    text-align: center;
    margin-bottom: 30px;
    }

    /* Style the buttons inside the tab */
    .tab button {
      background-color: inherit;
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
        .plandetails{
            margin-top: 70px !important;
    min-height: 450px !important;
        }
        .btn-secondary{
            background-color: #4895d1 !important;
            border: none !important;
        }

</style>

<script>
  $( function() {
    $( "#tabs" ).tabs();
    $("tabs li:first").addClass("active");
  });
    
  </script>

<div class="container">
    <div class="row justify-content-center page-height" id="signup-form">  
        <div class="col-md-11 col-sm-offset-1 plandetails">
			<div class="login-block">
                    <div class="panel-heading" align="center"><h1>Choose You Plan</h1></div>
                     <div class="panel-body become-sub">
                        <div class="tab">
                          <button class="tablinks active" onclick="openCity(event, 'stripe_pg') " id="defaultOpen">
                            <img width="100" height="auto"src="<?php echo URL::to('/assets/img/1280px-Stripe_Logo,_revised_2016.svg.png');?>">
                          </button>
                        <button class="tablinks payment-logo" onclick="openCity(event, 'paypal_pg')"> 
                            <img width="100" height="auto"src="<?php echo URL::to('/assets/img/PayPal-Logo.png');?>">
                        </button>
                        </div>

<div id="stripe_pg" class="tabcontent"> 
        <form action="<?php echo URL::to('/').'/stripe-subscription';?>" method="POST" id="payment-form" enctype="multipart/form-data">
            <label for="chkPassport">
                    <input type="checkbox" id="chkPassport" />
                     Click here for Recurring subscription!
                 </label>
              <div class="tab-content">
                      <div id="dvPassport" style="display: none" class="tab-pane fade in active">
                  <div class="row">
                        <?php 
                            $plans = App\Plan::where('type','=','Non Refundable')->get();
                               foreach($plans as $plan) {
                                  $plans_name = $plan->plans_name;
                            ?>
                       <div class="col-sm-3">
                        <div class="plan-card">
                            <div class="header">
                                <h3 class="plan-head">
                                    <?php echo $plan->plans_name;?></h3>
                            </div>
                            <div class="plan-price">
                                <p>plan</p>
                                <h4><?php echo "$".$plan->price;?>
                                    <small>
                                    <?php if ($plans_name == 'Monthly') { echo 'for a Month'; } else if ($plans_name == 'Yearly') { echo 'for 1 Year'; } else if ($plans_name == 'Quarterly') { echo 'for 3 Months'; } else if ($plans_name == 'Half Yearly') { echo 'for 6 Months'; } ?>
                                    </small>
                                </h4>
                            </div>
                            <div class="plan-details">
                                <p>Grab this plan for your best Movies to Watch.</p>
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary" data-price="<?php echo $plan->price;?>" data-name="<?php echo $plan->plans_name;?>" name="plan_name" id="plan_name" value="<?php echo $plan->plan_id;?>"  >Pay Now</button>
                                </div>
                            </div>
                        </div>
                    </div>
                           <?php } ?>
                 </div>
         </div>
                <div id="AddPassport" >
                    <div class="row">
                      <?php 
                            $plans = App\Plan::where('type','=','One Time')->get();
                               foreach($plans as $plan) {
                                  $plan_name = $plan->plans_name;
                            ?>
                                    <div class="col-sm-3">
                                        <div class="plan-card">
                                            <div class="header">
                                                <h3 class="plan-head">
                                                    <?php echo $plan->plans_name;?></h3>
                                            </div>
                                            <div class="plan-price">
                                                <p>plan</p>
                                                <h4><?php echo "$".$plan->price;?>
                                                    <small>
                                                    <?php if ($plan_name == 'Monthly') { echo 'for a Month'; } else if ($plan_name == 'Yearly') { echo 'for 1 Year'; } else if ($plan_name == 'Quarterly') { echo 'for 3 Months'; } else if ($plan_name == 'Half Yearly') { echo 'for 6 Months'; } ?>
                                                    </small>
                                                </h4>
                                            </div>
                                            <div class="plan-details">
                                                <p>Grab this plan for your best Movies to Watch.</p>
                                                <div class="mt-4">
                                                    <button type="submit" class="btn btn-primary" data-price="<?php echo $plan->price;?>" data-name="<?php echo $plan->plans_name;?>" name="plan_name" id="plan_name" value="<?php echo $plan->plan_id;?>"  >Pay Now</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                           <?php } ?>
                    </div>
                </div>
              </div>    
        
                
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
             <div class="col-md-11 col-sm-offset-1">
                <div class="sign-up-buttons" align="center">

				       <p> <span>Or</span></p>
				        <a type="button" href="<?php echo URL::to('/').'/myprofile';?>" class="btn btn-secondary">
                            <?php echo __('Skip');?>
                        </a>
				</div>
             </div>
         </div>
        
        </form>
        
        </div>

    <div id="paypal_pg" class="tabcontent">
        <label for="chkPassports">
                    <input type="checkbox" id="chkPassports" />
                     Click here for Recurring subscription!
        </label>
        <form action="<?php echo URL::to('/').'/paypal_subscription';?>" method="POST" id="payment-form" enctype="multipart/form-data">
      
       <div id="dvPassports" style="display: none" class="tab-pane fade in active">
           <div class="row">
            <?php 
           $plans = App\PaypalPlan::where('type','=','Non Refundable')->get();
           foreach($plans as $plan) {
               $plan_name = $plan->name;
        ?>
          <div class="col-sm-3">
				<div class="plan-card">
					<div class="header">
						<h3 class="plan-head">
                            
                            <?php echo $plan->name;?></h3>
					</div>
					<div class="plan-price">
						<p>plan</p>
						<h4><?php echo "$".$plan->price;?>
							<small>
							<?php if ($plan_name == 'Monthly') { echo 'for a Month'; } else if ($plan_name == 'Yearly') { echo 'for 1 Year'; } else if ($plan_name == 'Quarterly') { echo 'for 3 Months'; } else if ($plan_name == 'Half Yearly') { echo 'for 6 Months'; } ?>
							</small>
						</h4>
					</div>
					<div class="plan-details">
						<p>Grab this plan for your best Movies to Watch.</p>
                       
                        <div class="mt-4">
							<button type="submit" class="btn btn-primary"  data-price="<?php echo $plan->price;?>" data-name="<?php echo $plan->plans_name;?>" name="plan_id" id="paypal_plan" value="<?php echo $plan->plan_id;?>"  >Pay Now</button>
						</div>
<!--
						<div class="text-right mt-4">
							<a class="btn btn-primary" href="/invoice">Pay Now</a>
						</div>
-->
					</div>
				</div>
			</div>  
            <?php } ?>
          </div>
         </div>
           
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
               <div id="AddPassports" >
                    <div class="row">
                    <?php 
                       $plans = App\PaypalPlan::where('type','=','One Time')->get();
                       foreach($plans as $plan) {
                           $plan_name = $plan->name;
                    ?>
                   <div class="col-sm-3">
                        <div class="plan-card">
                            <div class="header">
                                <h3 class="plan-head">

                                    <?php echo $plan->name;?></h3>
                            </div>
                            <div class="plan-price">
                                <p>plan</p>
                                <h4><?php echo "$".$plan->price;?>
                                    <small>
                                    <?php if ($plan_name == 'Monthly') { echo 'for a Month'; } else if ($plan_name == 'Yearly') { echo 'for 1 Year'; } else if ($plan_name == 'Quarterly') { echo 'for 3 Months'; } else if ($plan_name == 'Half Yearly') { echo 'for 6 Months'; } ?>
                                    </small>
                                </h4>
                            </div>
                            <div class="plan-details">
                                <p>Grab this plan for your best Movies to Watch.</p>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary"  data-price="<?php echo $plan->price;?>" data-name="<?php echo $plan->plans_name;?>" name="plan_id" id="paypal_plan" value="<?php echo $plan->plan_id;?>"  >Pay Now</button>
                                </div>
                            </div>
                        </div>
                    </div>   
         
       <?php } ?>    
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
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js'></script>

 <script>
        $(function () {
            $("#chkPassport").click(function () {
                if ($(this).is(":checked")) {
                    $("#dvPassport").show();
                    $("#AddPassport").hide();
                } else {
                    $("#dvPassport").hide();
                    $("#AddPassport").show();
                }
            });
        });
   
       $(function () {
                $("#chkPassports").click(function () {
                    if ($(this).is(":checked")) {
                        $("#dvPassports").show();
                        $("#AddPassports").hide();
                    } else {
                        $("#dvPassports").hide();
                        $("#AddPassports").show();
                    }
                });
            });
        </script>


@include('footer')
@endsection 

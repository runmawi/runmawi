@extends('layouts.app')

@section('content')
@partial('category_header')
<head>
     <?php
   $settings = App\Setting::find(1);
//    $plans_data =     Session::get('plans_data');
//    dd($plans_data);

?>
         <!-- Favicon -->
      <link rel="shortcut icon" href="<?= URL::to('/'). '/public/uploads/settings/' . $settings->favicon; ?>" />
</head>
    <script src="https://www.paypal.com/sdk/js?client-id=Aclkx_Wa7Ld0cli53FhSdeDt1293Vss8nSH6HcSDQGHIBCBo42XyfhPFF380DjS8N0qXO_JnR6Gza5p2&vault=true&intent=subscription" data-sdk-integration-source="button-factory">
        
    </script>
    <style>
        .btn_prd_up_22:after {
   position: absolute;
    left: 33.7%;
    top: -8%;
    bottom: calc(50% + 8px);
    width: 1px;
    height: calc(245px - 19px);
    transform: rotate(90deg);
    background: #fff;
    content: "";
    z-index: 0;
}
         .ply{
         background: #000;
            
            padding: 10px;
            border-radius: 50%;
        }
         .btn_prd_up_33:after {
   position: absolute;
    left: 65.7%;
    top: -8%;
    bottom: calc(50% + 8px);
    width: 1px;
    height: calc(245px - 19px);
    transform: rotate(90deg);
    background: #fff;
    content: "";
    z-index: 0;
}
         input[type='radio']:after {
        width: 15px;
        height: 15px;
        border-radius: 15px;
        top: -2px;
        left: -1px;
        position: relative;
        background-color: #d1d3d1;
        content: '';
        display: inline-block;
        visibility: visible;
        border: 2px solid white;
    }
        ul{
            list-style: none;
        }
        .sig{
            background: #161617;
mix-blend-mode: normal;
            padding: 50px;
            border-radius: 20px;
        } .sig1{
            background: #151516;
mix-blend-mode: normal;
            padding: 25px;
            border-radius: 20px;
        }
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
.bg-col p{
        font-family: Chivo;
font-style: normal;
font-weight: 400;
font-size: 26px;
line-height: 31px;
/* identical to box height */
padding-top:10px;
display: flex;
align-items: center;

color: #FFFFFF;
    }
        .container h1{
            padding-left: 10px;
        }
    .bg-col{
       background:rgb(32, 32, 32);

mix-blend-mode: color-dodge;
border-radius: 20px;
    padding: 10px;
    color: #fff;
        height: 150px;
        padding-left: 90px;
        
   
}
    .bl{
       background: #161617;
        padding: 10px;


    }

</style>
<style>
.overlay{
    display: none;
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    z-index: 999;
    background: rgba(255,255,255,0.8) url("loader.gif") center no-repeat;
}
/* Turn off scrollbar when body element has the loading class */
body.loading{
    overflow: hidden;   
}
/* Make spinner image visible when body element has the loading class */
body.loading .overlay{
    display: block;
}
</style>

<script>
  $( function() {
    $( "#tabs" ).tabs();
    $("tabs li:first").addClass("active");
  });
    
  </script>
 <section  class="m-profile setting-wrapper pt-0">
        <div class="container">
            <div class="row sig ">
                <div class="col-md-4 mt-3 pt-3">
                    <h4 class="main-title mb-4">My Account</h4>
                    <p class="text-white">Edit your name or change<br>your password.</p>
                    <ul class="edit p-0 mt-5">
                        
                        <li><div class="d-flex showSingle" target="2">
                                <a href="<?=URL::to('/upgrade-subscription_plan');?>" class="text-white">
                            <img class="ply mr-3" src="<?php echo URL::to('/').'/assets/img/plan.png';  ?>"> 
                                    Plan
                                </a>
</div></li>
                        
                      
                    </ul>
                </div>
                
                <div class="col-md-8 targetDiv" id="div2">
                    <div class="d-flex justify-content-around text-white">
                        <div class="d-felx text-center">
                        <p>Choose plan</p>
                        <input type="radio">
                            <ul>
                                <li class="btn_prd_up_22"></li>
                            </ul>
                        </div>
                        <div class="d-felx text-center">
                        <p>Make payment</p>
                            <input type="radio">
                             <ul>
                                <li class="btn_prd_up_33"></li>
                            </ul>
                        </div>
                        <div class="d-felx text-center">
                        <p>Confirmation</p>
                            <input type="radio"></div>
                    </div>
                <div class="col-md-12 mt-3">
                    <div class="bg-col" onclick="jQuery('#add-new').modal('show');" >
                        <div class="container ">
                          
                        <p>SAVE $594</p>
                        <h1><span class="dl">$</span>1197 <span class="dl1">for 9 months</span></h1></div>
                        </div>
                        
                    </div>
                
                 <div class="col-md-12 mt-3">
                    <div class="bg-col" onclick="jQuery('#add-new').modal('show');" >
                       <div class="container ">
                           
                        <p>SAVE $300</p>
                        <h1><span class="dl">$</span>894 <span class="dl1">for 6 months</span></h1></div> </div>
                      
                    </div>
            
                 <div class="col-md-12 mt-3">
                    <div class="bg-col" onclick="jQuery('#add-new').modal('show');" >
                       <div class="container ">
                           
                                
                        <p>SAVE $99</p>
                        <h1><span class="dl">$</span>498 <span class="dl1">for 3 months</span></h1></div></div>
                        
                    </div>
           
                 <div class="col-md-12 mt-3">
                    <div class="bg-col" onclick="jQuery('#add-new').modal('show');" >
                        <div class="container ">
                          
                        <p></p>
                                <h1><span class="dl">$</span>198 <span class="dl1">for 1 months</span></h1></div></div>
                        
                    </div>
                </div>
                 
                
       
            </div></div>
    </section>
<div class="container">
    <div class="row justify-content-center page-height" id="signup-form">  
        <div class="col-md-11 col-sm-offset-1 plandetails">
			<div class="login-block">
                    <div class="panel-heading" align="center"><h1>Choose Your Plan</h1></div>
                     <div class="panel-body become-sub">
                        <div class="tab">
                          <!-- <button class="tablinks active" onclick="openCity(event, 'stripe_pg') " id="defaultOpen">
                            <img width="100" height="auto"src="<?php // echo URL::to('/assets/img/1280px-Stripe_Logo,_revised_2016.svg.png');?>">
                          </button>
                        <button class="tablinks payment-logo" onclick="openCity(event, 'paypal_pg')"> 
                            <img width="100" height="auto"src="<?php // echo URL::to('/assets/img/PayPal-Logo.png');?>">
                        </button> -->
                        </div>

<div id="stripe_pg" class="tabcontent" style="display:block;"> 
        <!-- <form action="<?php // echo URL::to('/').'/stripe-subscription';?>" method="POST" id="payment-form" enctype="multipart/form-data"> -->
                <div id="AddPassport" >
                    <div class="row">
                      <?php 
                            // $plans = App\Plan::get();

                               foreach($plans_data as $plan) {
                                  $plan_name = $plan[0]->plans_name;
                            ?>
                                    <div class="col-sm-3">
                                        <div class="plan-card">
                                            <div class="header">
                                                <h3 class="plan-head">
                                                    <?php echo $plan[0]->plans_name;?></h3>
                                            </div>
                                            <div class="plan-price">
                                                <p>plan</p>
                                                <h4><?php echo "$".$plan[0]->price;?>
                                                    <small>
                                                    <?php if ($plan_name == 'Monthly') { echo 'for a Month'; } else if ($plan_name == 'Yearly') { echo 'for 1 Year'; } else if ($plan_name == 'Quarterly') { echo 'for 3 Months'; } else if ($plan_name == 'Half Yearly') { echo 'for 6 Months'; } ?>
                                                    </small>
                                                </h4>
                                            </div>
                                            <div class="plan-details">
                                                <p>Grab this plan for your best Movies to Watch.</p>
                                                <p>Available Specification :</p>
                                                <h6 style ="color:yellow;background-color:black;"> Video Quality : <p style ="color:white;"><?php echo $plan[0]->video_quality; ?></p>  
                                                Video Resolution : <p style ="color:white;"><?php echo $plan[0]->resolution; ?></p></h6>   
                                             <?php   
                                                    $permission = $plan[0]->devices;
                                                    $user_devices = explode(",",$permission);   
                                                    foreach($devices as $key => $value){
                                                        if(in_array($value->id, $user_devices)){
                                                            $devices_name[] = $value->devices_name;
                                                        }
                                                    }    
                                                    $plan_devices = implode(",",$devices_name);
                                              ?>
                                                <!-- <h6 style ="color:yellow;background-color:black;"  > Available Devices : <p><?php echo $plan_devices; ?></p></h6>    -->
                                                <div class="mt-4">
                                                <button type="button" id="plans_name_choose" data-price="<?php echo $plan[0]->price;?>" data-name="<?php echo $plan[0]->plans_name;?>"  class="btn btn-primary plans_name_choose" onclick="jQuery('#add-new').modal('show');"  name="plan_name"  value="<?php echo $plan_name;?>">Pay Now
                                            </button>
                                                    <!-- <button type="submit" class="btn btn-primary" data-price="<?php // echo $plan[0]->price;?>" data-name="<?php //echo $plan[0]->plans_name;?>" name="plan_name" id="plan_name" value="<?php // echo $plan[0]->plan_id;?>"  >Pay Now</button> -->
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
              <div class="modal fade" id="add-new">
		<div class="modal-dialog">
			<div class="modal-content">				
				<div class="modal-header">
                    <h4 class="modal-title" style="color: #000">You are one step away from purchasing subscription Gate Way</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				
				<div class="modal-body">
                <form action="<?php echo URL::to('/').'/upgrade-stripe-plan';?>" method="POST" id="payment-form" enctype="multipart/form-data">
                <?php $payment_type = App\PaymentSetting::get(); ?>
					<!-- <form id="new-cat-form" accept-charset="UTF-8" action="{{ URL::to('/register2') }}" method="post"> -->
						<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                        <input type="hidden" name="modal_plan_name" id="modal_plan_name" value="" /><br>
                        <div class="form-group"> 
                           
                            <label class="radio-inline">
                            <?php  foreach($payment_type as $payment){
                          if($payment->status == 1 || $payment->status == 1){ 
                          if($payment->live_mode == 1 && $payment->status == 1){ ?>
                <input type="radio" id="tres_important" checked name="payment_method" value="{{ $payment->payment_type }}">
                <?php if(!empty($payment->stripe_lable)){ echo $payment->stripe_lable ; }else{ echo $payment->payment_type ; } ?>
            </label>
                <?php }elseif($payment->paypal_live_mode == 1 && $payment->status == 1){ ?>
                <label class="radio-inline">
                <input type="radio" id="important" name="payment_method" value="{{ $payment->payment_type }}">
                <?php if(!empty($payment->paypal_lable)){ echo $payment->paypal_lable ; }else{ echo $payment->payment_type ; } ?>
                </label>
                <?php }elseif($payment->live_mode == 0 && $payment->status == 1){ ?>
                <input type="radio" id="tres_important" checked name="payment_method" value="{{ $payment->payment_type }}">
                <?php if(!empty($payment->stripe_lable)){ echo $payment->stripe_lable ; }else{ echo $payment->payment_type ; } ?>
            </label><br>
                          <?php 
						 }elseif( $payment->paypal_live_mode == 0 && $payment->status == 1){ ?>
                <input type="radio" id="important" name="payment_method" value="{{ $payment->payment_type }}">
                <?php if(!empty($payment->paypal_lable)){ echo $payment->paypal_lable ; }else{ echo $payment->payment_type ; } ?>
                </label>
						<?php  } }else{
                            // echo "Please Turn on Payment Mode to Purchase";
                            break;
                         }
                         }?>
                        </div>
                               
				    </form>
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="submit-new-cat">Continue</button>
				</div>
			</div>
		</div>
	</div>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

<script type="text/javascript">

    jQuery(document).ready(function($){


        // Add New Category
        $('#submit-new-cat').click(function(){
            $('#payment-form').submit();
        });
        $(".plans_name_choose").click(function(){
        // alert($(this).val());
        $("#modal_plan_name").val($(this).val());

    });
    });
  
</script>
                
      
        
        <!-- </form> -->
        
        </div>

    <div id="paypal_pg" class="tabcontent" >
        <label for="chkPassports">
                    <input type="checkbox" id="chkPassports" />
                     Click here for Recurring subscription!
        </label>
        <form action="<?php echo URL::to('/').'/paypal_subscription';?>" method="POST" id="payment-form" enctype="multipart/form-data">
      
       <div id="dvPassports" style="display: block;" class="tab-pane fade in active">
           <div class="row">
            <?php 
           $plans = App\SubscriptionPlan::where('type','=','Non Refundable')->get();
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
                            // exit();
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
                                                <p>Grab this plan and watch unlimited movies</p>
                                                <div class="text-right mt-4">
                                                    <button type="submit" class="btn btn-danger" data-price="<?php echo $plan->price;?>" data-name="<?php echo $plan->plans_name;?>" name="plan_name" id="plan_name" value="<?php echo $plan->plan_id;?>"  >Pay Now</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="payment_type" value="one_time">
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


@partial('category_footer')  
@endsection 

@extends('layouts.app')

@section('content')
@php
    include(public_path('themes\theme3\views\header.php'));
@endphp

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
    * {
      box-sizing: border-box;
    }
        .modal-title {
    margin-bottom: 0;
    line-height: 1.5;
   
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
 padding-left: 20px;
color: #FFFFFF;
    }
         .bg-col{
       background:rgb(32, 32, 32);

mix-blend-mode: color-dodge;
border-radius: 20px;
    padding: 10px;
    color: #fff;
        height: 150px;
        width: 650px;
        padding-left: 50px;
        
   
}

    .columns {
      float: left;
      width: 25%;
      padding: 8px;
    }
        .dl{
            font-size: 20px;
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
        h1{
            font-family: Chivo;
font-style: normal;
font-weight: normal;
font-size: 60px;
line-height: 31px;



color: #FFFFFF;
        }
        span{
            font-weight: 100;
            font-size: 40px;
        }
</style>
<style>
    .ak{
        border-right: 2px solid #fff;
    }
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
    .bg-col p{
        font-family: Chivo;
font-style: normal;
font-weight: normal;
font-size: 26px;
line-height: 31px;
/* identical to box height */

display: flex;
align-items: center;

color: #FFFFFF;
    }
    .bg-col{
    background: #C4C4C4;
mix-blend-mode: color-dodge;
border-radius: 20px;
    padding: 10px;
    color: #fff;
        
   
}
    .bl{
       background: #161617;
        padding: 10px;


    }
    .edit li{
        list-style: none;
        padding: 10px 20px;
    }
    .bl1{
        background: linear-gradient(180deg, #000 0%, rgba(0, 0, 0, 0) 100%);
padding: 40px;
border-radius: 20px;
        color: #fff!important;
    }

</style>

<script>
  $( function() {
    $( "#tabs" ).tabs();
    $("tabs li:first").addClass("active");
  });
    
  </script>
 <section class="bl pt-2 mt-2">

        <div class="container mb-3 ">
            <div class="bl1">
            <h1 class="text-white text-center mb-4">Choose Your plan</h1>
            <div class="row justify-content-center mt-5 ">
                
                <div class="col-md-4 col-lg-4 ak padding-20">
                    <h2 class="">Plan Details</h2>
                    <p class="text-white mt-2">Edit your name or change<br>
your password.</p>
                    <ul class="edit">
                        <li>Edit Profile</li>
                        <li>Plan</li>
                        <li>Kids Safemode</li>
                        <li>video Preferences</li>
                    </ul>
                </div>
                <div class="col-md-8 targetDiv" id="div2">
                    <div class="d-flex justify-content-around text-white">
                                 <?php                          
                               foreach($plans_data as $plan) {
                                  $plan_name = $plan[0]->plans_name;
                            ?>
                 <div class="col-md-12 mt-3 p-0">
                    <button  data-price="<?php echo $plan[0]->price;?>" 
                    data-name="<?php echo $plan[0]->plans_name;?>"  
                    class="bg-col plans_name_choose" onclick="jQuery('#add-new').modal('show');" 
                     name="plan_name"  value="<?php echo $plan_name;?>">
                   
                    <div class="container">
                        <p><?php echo $plan[0]->plans_name;?></p>
                        <h1><span class="dl">$</span><?php echo $plan[0]->price;?> </span><span class="dl1">

                        <!-- <h1><span class=""><?php echo "$".' '.$plan[0]->price;?></span><span class="dl1">  -->
                        <?php if ($plan_name == 'Monthly') { echo 'for a Month'; } else if ($plan_name == 'Yearly') { echo 'for 1 Year'; } else if ($plan_name == 'Quarterly') { echo 'for 3 Months'; } else if ($plan_name == 'Half Yearly') { echo 'for 6 Months'; } ?>
                        </span></h1></div>                

                    </button>
                       <?php } ?>
                </div>
            </div>
                       </div>
                        
                    </div>
                
     </div> 
    </section>

              <div class="modal fade" id="add-new">
		<div class="modal-dialog ">
			<div class="modal-content " style=" background:rgb(32, 32, 32);">				
				<div class="modal-header">
                    <h4 class="modal-title">You are one step away from purchasing subscription Gate Way</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				
				<div class="modal-body">
                <form action="<?php echo URL::to('/').'/subscribe-now';?>" method="POST" id="payment-form" enctype="multipart/form-data">
                <?php $payment_type = App\PaymentSetting::get(); ?>
					<!-- <form id="new-cat-form" accept-charset="UTF-8" action="{{ URL::to('/register2') }}" method="post"> -->
						<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                        <input type="hidden" name="modal_plan_name" id="modal_plan_name" value="" /><br>
                        <div class="form-group"> 
                           
                            <label class="radio-inline">
                            <?php  foreach($payment_type as $payment){
                          if($payment->stripe_status == 1 || $payment->paypal_status == 1){ 
                          if($payment->live_mode == 1 && $payment->stripe_status == 1){ ?>
                <input type="radio" id="tres_important" checked name="payment_method" value="{{ $payment->payment_type }}">
                <?php if(!empty($payment->stripe_lable)){ echo $payment->stripe_lable ; }else{ echo $payment->payment_type ; } ?>
            </label>
                <?php }elseif($payment->paypal_live_mode == 1 && $payment->paypal_status == 1){ ?>
                <label class="radio-inline">
                <input type="radio" id="important" name="payment_method" value="{{ $payment->payment_type }}">
                <?php if(!empty($payment->paypal_lable)){ echo $payment->paypal_lable ; }else{ echo $payment->payment_type ; } ?>
                </label>
                <?php }elseif($payment->live_mode == 0 && $payment->stripe_status == 1){ ?>
                <input type="radio" id="tres_important" checked name="payment_method" value="{{ $payment->payment_type }}">
                <?php if(!empty($payment->stripe_lable)){ echo $payment->stripe_lable ; }else{ echo $payment->payment_type ; } ?>
            </label><br>
                          <?php 
						 }elseif( $payment->paypal_live_mode == 0 && $payment->paypal_status == 1){ ?>
                <input type="radio" id="important" name="payment_method" value="{{ $payment->payment_type }}">
                <?php if(!empty($payment->paypal_lable)){ echo $payment->paypal_lable ; }else{ echo $payment->payment_type ; } ?>
                </label>
						<?php  } }else{
                            echo "Please Turn on Payment Mode to Purchase";
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

@php
    include(public_path('themes\theme3\views\footer.blade.php'));
@endphp

@endsection 

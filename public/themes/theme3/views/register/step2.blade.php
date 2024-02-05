@extends('layouts.app')
@include('/header')
@section('content')

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

<div class="">
    
<?php 
    $ref = Request::get('ref');
    $coupon = Request::get('coupon');
   
?>
    <div class="row justify-content-center" id="signup-form">
            <!-- @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif -->
            @if (Session::has('message'))
            <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
                @endif

                @if(count($errors) > 0)
                    @foreach( $errors->all() as $message )
                        <div class="alert alert-danger display-hide" id="successMessage" >
                            <button id="successMessage" class="close" data-close="alert"></button>
                            <span>{{ $message }}</span>
                        </div>
                    @endforeach
                @endif
        <div class="col-md-10 col-sm-offset-1">
			<div class="login-block">
                <div class="panel-heading"><h1>Choose Your Plan</h1></div>
                     <div class="panel-body">
                       <!-- <div class="tab">
                          <button class="tablinks active" onclick="openCity(event, 'stripe_pg') " id="defaultOpen">
                            <img  width="200" height="50" src="<?php echo URL::to('/assets/img/1280px-Stripe_Logo,_revised_2016.svg.png');?>">
                           </button>

                          <button class="tablinks payment-logo" onclick="openCity(event, 'paypal_pg')"> 
                              <img  width="200" height="50" src="<?php echo URL::to('/assets/img/PayPal-Logo.png');?>">
                           </button>

                        </div> -->

    
                         
    <div id="stripe_pg" class="tabcontent" style="display:block;">  
<!--
        <label for="chkPassport">
                    <input type="checkbox" id="chkPassport" />
                     Click here for Recurring subscription!
        </label>
-->
    <!-- <form action="<?php // echo URL::to('/').'/cardstep'; ?>" method="POST" id="payment-form" enctype="multipart/form-data"> -->
     <div class="tab-content">
                <div id="dvPassport" style="display: none" class="tab-pane fade in active">
                  <div class="row">
            <?php 
                // $plans = App\Plan::where('payment_type','=','recurring')->get();
                if(!empty($plans_data)){
                    // dd($plans_data);                                             
                   foreach($plans_data as $plan) {
                      $plans_name = $plan[0]->plans_name;
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
                                    <?php if ($plans_name == 'Monthly') { echo 'for a Month'; } else if ($plans_name == 'Yearly') { echo 'for 1 Year'; } else if ($plans_name == 'Quarterly') { echo 'for 3 Months'; } else if ($plans_name == 'Half Yearly') { echo 'for 6 Months'; } ?>
                                    </small>
                                </h4>
                            </div>
                            <div class="plan-details">
                                <p class="text-black">Grab this plan for your best Movies to Watch.</p>
                                <div class=" mt-4 text-center">
                                    <button type="submit" class="btn btn-primary" data-price="<?php echo $plan[0]->price;?>" data-name="<?php echo $plan[0]->plans_name;?>" name="plan_name" id="plan_name" value="<?php echo $plan[0]->plan_id;?>"  >Pay Now</button>
                                </div>
                            </div>
                        </div>
                    </div>
               <?php } 
               }?>
		</div>
         </div>
         
           <div id="AddPassport" >
                    <div class="row">
                        <?php 
                            // $plans = App\Plan::where('payment_type','=','recurring')->get();
                               foreach($plans_data as $key => $plan) {
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
                                                <div class=" mt-4 text-center">
                                                    
                                                <button type="button" id="plans_name_choose" data-price="<?php echo $plan[0]->price;?>" data-name="<?php echo $plan[0]->plans_name;?>"  class="btn btn-primary plans_name_choose" onclick="jQuery('#add-new').modal('show');"  name="plan_name"  value="<?php echo $plan_name;?>">Pay Now
                                            </button>

                                                <!-- Launch demo modal
                                                </button>
                                                    <button type="submit" class="btn btn-primary" data-price="<?php //echo $plan[0]->price;?>" data-name="<?php // echo //$plan[0]->plans_name;?>" name="plan_name" id="plan_name" value="<?php // echo //$plan[0]->plans_name;?>" >Pay Now</button> -->
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
            <div class="modal fade" id="add-new">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<div class="modal-header">
                <h4 class="modal-title" style="color: #000">You are one step away from purchasing subscription</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					
				</div>
				
				<div class="modal-body">
                <form action="<?php if (isset($ref) ) { echo URL::to('/').'/register2?ref='.$ref.'&coupon='.$coupon; } else { echo URL::to('/').'/register2'; } ?>" method="POST" id="payment-form" enctype="multipart/form-data">

					<!-- <form id="new-cat-form" accept-charset="UTF-8" action="{{ URL::to('/register2') }}" method="post"> -->
						<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                        <input type="hidden" name="modal_plan_name" id="modal_plan_name" value="" />
                        <div class="form-group"> 
                <?php $payment_type = App\PaymentSetting::get(); ?>
                           
                <label class="radio-inline">
                <?php  foreach($payment_type as $payment){
                          if($payment->live_mode == 1){ ?>
                <input type="radio" id="tres_important" checked name="payment_method" value="{{ $payment->payment_type }}">
                <?php if(!empty($payment->stripe_lable)){ echo $payment->stripe_lable ; }else{ echo $payment->payment_type ; } ?>
                </label>
                <?php }elseif($payment->paypal_live_mode == 1){ ?>
                <label class="radio-inline">
                <input type="radio" id="important" name="payment_method" value="{{ $payment->payment_type }}">
                <?php if(!empty($payment->paypal_lable)){ echo $payment->paypal_lable ; }else{ echo $payment->payment_type ; } ?>
                </label>
                <?php }elseif($payment->live_mode == 0){ ?>
                <input type="radio" id="tres_important" checked name="payment_method" value="{{ $payment->payment_type }}">
                <?php if(!empty($payment->stripe_lable)){ echo $payment->stripe_lable ; }else{ echo $payment->payment_type ; } ?>
                </label><br>
                          <?php 
						 }elseif( $payment->paypal_live_mode == 0){ ?>
                <input type="radio" id="important" name="payment_method" value="{{ $payment->payment_type }}">
                <?php if(!empty($payment->paypal_lable)){ echo $payment->paypal_lable ; }else{ echo $payment->payment_type ; } ?>
                </label>
						<?php  } }?>
                        </div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="submit-new-cat">Next</button>
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
    });
</script>








   
         <div class="form-group row">
                <div class="col-md-10 col-sm-offset-1">
				      <div class="pull-right sign-up-buttons">
                   <a type="button" href="<?php echo URL::to('/').'/registerUser';?>" class="btn btn-secondary">
                            <?php echo __('Skip');?>
                        </a>
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
    $(".plans_name_choose").click(function(){
        // alert($(this).val());
        $("#modal_plan_name").val($(this).val());

    });

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
        </script>  

      <script>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script>
    $(document).ready(function(){
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);
    })
    

    </script>


@include('footer')
@endsection 
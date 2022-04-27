@extends('admin.master')
<style>
    .form-control {
    background: #fff!important; */
   
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
$base-margin: 20px;
$blue: #345F90;
$tab-height: 35px;
$tab-border-radius: 35px;

body{
	background: rgba($blue, 0.07);
	font-family: 'Roboto', sans-serif;
	font-weight: 300;
	font-size: 16px;
	line-height: 1.66667;
}
.container{
	width: 75%;
	margin: 3rem auto;
}
h2{
	color: $blue;
	font-size: 24px;
	line-height: 1.25;
	font-family: "Roboto Slab", serif;
	margin-top: $base-margin;
	margin-bottom: $base-margin;
}


.tab-slider--nav{
	width: 100%;
	float: left;
	margin-bottom: $base-margin;
}
.tab-slider--tabs{
	display: block;
	float: left;
	margin: 0;
	padding: 0;
	list-style: none;
	position: relative;
	border-radius: $tab-border-radius;
	overflow: hidden;
	background: #fff;
	height: $tab-height;
	user-select: none; 
	&:after{
		content: "";
		width: 50%;
		background: $blue;
		height: 100%;
		position: absolute;
		top: 0;
		left: 0;
		transition: all 250ms ease-in-out;
		border-radius: $tab-border-radius;
	}
	&.slide:after{
		left: 50%;
	}
}

.tab-slider--trigger {
	font-size: 12px;
	line-height: 1;
	font-weight: bold;
	color: $blue;
	text-transform: uppercase;
	text-align: center;
	padding: 11px $base-margin;
	position: relative;
	z-index: 2;
	cursor: pointer;
	display: inline-block;
	transition: color 250ms ease-in-out;
	user-select: none; 
	&.active {
		color: #fff;
	}
}
.tab-slider--body{
	margin-bottom: $base-margin;
}
</style>
<script>
  $( function() {
    $( "#tabs" ).tabs();
    $("tabs li:first").addClass("active");
  });
    
  </script>
<script src="https://www.paypal.com/sdk/js?client-id=Aclkx_Wa7Ld0cli53FhSdeDt1293Vss8nSH6HcSDQGHIBCBo42XyfhPFF380DjS8N0qXO_JnR6Gza5p2&vault=true&intent=subscription" data-sdk-integration-source="button-factory"></script>
@section('content')
<div id="content-page" class="content-page">
         <div class="container-fluid">
             <div class="row">
                 <div class="col-lg-12">
                  <div class="iq-card iq-card iq-card-block iq-card-stretch iq-card-height">
                     <div class="iq-card-header">
                        <div class="iq-header-title">
                           <!-- <h4 class="card-title text-center" style="color: #4295D2;">User's Of {{ GetWebsiteName() }}</h4> -->
                           <h5>Payment Declined!</h5>
                           <!-- <p>Warning your account is pending deletion, Update your payment to resume service.</p> -->
                           <p>Your Services are up for renewal, Please ask your store owner / admin / accountant to renew now to enjoy streaming services!</p>                  
                          </div>
                     </div>
                        <div>
                        <div class="row justify-content-center page-height" id="signup-form">  
        <div class="col-md-11 col-sm-offset-1 plandetails">
			<div class="login-block">
                    <div class="panel-heading" align="center"><h1>Choose Your Plan</h1></div>
                     <div class="panel-body become-sub">
                        <div class="tab" style="padding-left: 40%;">
                        <div class="tab-slider--nav">
                            <ul class="tab-slider--tabs">
                                <li class="tab-slider--trigger active" rel="tab1">Monthly</li>
                                <li class="tab-slider--trigger" rel="tab2">Yearly</li>
                            </ul>
                        </div>
                        </div>

<div id="stripe_pg" class="tabcontent" style="display:block;"> 
<div class="tab-slider--container">
<div id="tab1" class="tab-slider--body">
<div id="monthlyplans">
        <!-- <form action="<?php  //echo URL::to('/admin/plan/monthly');?>" method="POST" id="payment-form" enctype="multipart/form-data"> -->
                <div id="AddPassport" >
                    <div class="row">
                    <?php 
                    foreach($responseBody->plandata as $plan) {
                                  $plan_name = $plan->plan_name;
                            ?>
                                         <div class="col-sm-3">
                                        <div class="plan-card">
                                            <div class="header">
                                                <h3 class="plan-head">
                                                    <?php echo $plan_name;?></h3>
                                            </div>
                                            <div class="plan-price">
                                                <p>plan</p>

                                                <h4><del><?php echo "$".$plan->monthly_price;?></del> <?php echo "$".$plan->monthly_price_sale;?>
                                                </h4>
                                            </div>
                                            <!-- <div class="plan-price">
                                                <p>Plan Description</p>
                                                <?php //echo $plan->plan_desc; ?>
                                            </div> -->
                                            <div class="plan-details">
                                                <p>Grab this plan for your best Movies to Watch.</p>
                                                <p > Price :<del><?php echo "$".$plan->monthly_price;?></del> <?php echo "$".$plan->monthly_price_sale;?></h6>   
                                                <!-- plan_desc -->
                                                <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />

                                                <input type="hidden" value="<?php echo $plan->plan_slug;?>" id="planname" name="planname">
                                                <input type="hidden" value="monthly" id="monthly" name="monthly">
                                                <div class="mt-4">
        <!-- // https://flicknexs.com/upgrade/basic -->

                                                <a href="{{ URL::to('/admin/upgrade/').'/'.$plan->plan_slug }}"><button type="submit"  class="btn btn-primary ">Pay Now</button></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                           <?php } ?>
                           <!-- </form> -->

                    </div>
                </div>
              </div>    
              @csrf
                            


            </div>
        </div>
    </div>
    </div>
    </div>
    <div id="tab2" class="tab-slider--body">

    <div id="yearlyplan">
        <!-- <form action="<?php  //echo URL::to('/admin/plan/yearly');?>" method="POST" id="payment-form" enctype="multipart/form-data"> -->
                <div id="AddPassport" >
                    <div class="row">
                    <?php 
                                    foreach($responseBody->plandata as $plan) {
                                        $plan_name = $plan->plan_name;
                                    ?>
                                         <div class="col-sm-3">
                                        <div class="plan-card">
                                            <div class="header">
                                                <h3 class="plan-head">
                                                    <?php echo $plan_name;?></h3>
                                            </div>
                                            <div class="plan-price">
                                                <p>plan</p>
                                                <h4><del><?php echo "$".$plan->yearly_price;?></del> <?php echo "$".$plan->yearly_price_sale;?>
                                                </h4>
                                            </div>
                                            <!-- <div class="plan-price">
                                                <p>Plan Description</p>
                                                <?php //echo $plan->plan_desc; ?>
                                            </div> -->
                                            <div class="plan-details">
                                                <p>Grab this plan for your best Movies to Watch.</p>
                                                <p > Price :<del><?php echo "$".$plan->yearly_price;?></del> <?php echo "$".$plan->yearly_price_sale;?></p></h6>   
                                                <!-- plan_desc -->
                                                <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                                                <input type="hidden" value="<?php echo $plan->plan_slug; ?>" id="planname" name="planname">
                                                <input type="hidden" value="yearly" id="yearly" name="yearly">
                                                <div class="mt-4">
                                                <a href="{{ URL::to('/admin/yearly/upgrade/').'/'.$plan->plan_slug }}"><button type="submit" id="yearlyplan" class="btn btn-primary ">Pay Now</button></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                           <?php } ?>
                           <!-- </form> -->
                    </div>
                </div>
              </div>    
              @csrf
                            


            </div>
        </div>
    </div>
    </div>
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



$("document").ready(function(){
  $(".tab-slider--body").hide();
  $(".tab-slider--body:first").show();
});

$(".tab-slider--nav li").click(function() {
  $(".tab-slider--body").hide();
  var activeTab = $(this).attr("rel");
  $("#"+activeTab).fadeIn();
	if($(this).attr("rel") == "tab2"){
		$('.tab-slider--tabs').addClass('slide');
	}else{
		$('.tab-slider--tabs').removeClass('slide');
	}
  $(".tab-slider--nav li").removeClass("active");
  $(this).addClass("active");
});


</script>
            

@stop
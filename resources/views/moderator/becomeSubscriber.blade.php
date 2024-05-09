@extends('moderator.master')
<style>
    .form-control {
    background: #fff!important; */
   
}
* {
      box-sizing: border-box;
    }
li.active {
    color: #0993D2!important;
    background-color: #F2F5FA;
    padding: 10px;
    border-radius: 20px;
}
    li{
       
    }
    
    .columns {
      float: left;
      width: 25%;
      padding: 8px;
    }
    .plan-card{
        background-color: #fff;
        padding: 20px;
        box-shadow: 0 3px 10px rgb(0 0 0 / 0.2);
        border-radius: 20px;
    }
    .plan-card:nth-child(2){
        background-color: red;
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
       
    border-radius: 20px;
       
    }
    .tab li{
        background-color: #fafafa;
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
     background-color: #fafafa!important;
    border-radius: 20px;
    padding: 8px;
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
                           <h4 class="card-title text-center" style="color: #4295D2;">Become a Channel Partner to Unlock Content Uploads </h4>
                           <!-- <h5>Payment Declined!</h5> -->
                           <!-- <p>Warning your account is pending deletion, Update your payment to resume service.</p> -->
                           <!-- <p>Your Services are up for renewal, Please ask your store owner / admin / accountant to renew now to enjoy streaming services!</p>                   -->
                          </div>
                     </div>
                        <div>
                        <div class="row justify-content-center page-height" id="signup-form">  
        <div class="col-md-11 col-sm-offset-1 plandetails">
			<div class="login-block">
                    <div class="panel-heading" align="center">
                      <!-- <h1>Choose Your Plan</h1> -->
                  </div>
                     <div class="panel-body become-sub">
                         <div class="row justify-content-center">
            <p style="text-align: left; font-weight: bold;">*Become a Channel Partner to Unlock Content Uploads !*</p>
            <?php $user = Session::get('user'); ?>
            <br>
            <p>Dear  {{ $user->username }},</p>

<p>We hope you're doing well. We're reaching out to inform you about an exciting opportunity to become a channel partner with us and unlock exclusive benefits, including the ability to upload content directly onto our platform.</p>

<p>As a channel partner, you'll gain access to a range of features designed to elevate your experience and amplify your content distribution efforts. Here's why you should consider becoming a channel partner:</p>

<p>Content Upload Privileges: Gain the ability to upload your content directly onto our platform, reaching our audience and expanding your reach.</p>

<p>Enhanced Visibility: Stand out from the crowd with increased visibility for your content, helping you connect with a broader audience.</p>

<p>Collaborative Opportunities: Access exclusive collaboration opportunities and network with other content creators within our community.</p>

<p>Don't miss out on this chance to take your content distribution to the next level. Join us as a channel partner and unlock a world of possibilities!</p>

<p>If you're interested in learning more about our channel partner program or have any questions, please don't hesitate to reach out to us. We're here to help you every step of the way.</p>

<p>Thank you for considering this opportunity, and we look forward to welcoming you as a valued channel partner!</p>


</div>
<div id="stripe_pg" class="tabcontent" style="display:block;"> 
<div class="tab-slider--container">
<div id="tab1" class="tab-slider--body">
<div id="monthlyplans">
        
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
                <div id="AddPassport" >
                    <div class="row justify-content-center">
                 
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


</script>
            

@stop
@extends('layouts.app')

<!doctype html>
<html lang="en-US">
   <head>
      <?php
$uri_path = $_SERVER['REQUEST_URI']; 
$uri_parts = explode('/', $uri_path);
$request_url = end($uri_parts);
$uppercase =  ucfirst($request_url);

      ?>
      <!-- Required meta tags -->
    <meta charset="UTF-8">
    <?php $settings = App\Setting::first(); //echo $settings->website_name;?>
    <title><?php echo $uppercase.' | ' . $settings->website_name ; ?></title>
    <meta name="description" content= "<?php echo $settings->website_description ; ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= URL::to('/'). '/public/uploads/settings/' . $settings->favicon; ?>" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
      
     <!-- Bootstrap CSS -->
      <!-- Typography CSS -->
         <link rel="stylesheet" href="<?php echo URL::to('public/themes/theme2/assets/css/style.css') ?>" />
         <link rel="stylesheet" href="<?php echo URL::to('public/themes/theme2/assets/css/bootstrap.min.css') ?>" />
      <!-- Style -->
      <link rel="stylesheet" href="<?= typography_link(); ?>" />
      <!-- Responsive -->
      <link rel="stylesheet" href="assets/css/responsive.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js">
  </script>
<style>
    
    .slick-dots li{
          margin: 0;
    }
    .slick-dots li button:before{
        color: blue!important;
        font-size: 30px;
    }
    .slick-dots{
        top: 100%;
        margin: 0;
        left: 0;
        right: 0;
        text-align: center!important;
        bottom: -40px!important;
    }
    .mn{
        margin: 5px 15px;
    }
    @media only screen and (max-width : 320px) {
        .img-lan{
            width: 100%;
        }
        .d-flex{
            flex-wrap: wrap;
        }
        .h-100{
            height: auto!important;
        }
        .div1{
            padding: 0!important;
        }
        .ital{
            width: 100%;
            font-size: 20px;
        }
        .text-right{
            text-align: left!important;
        }
        h1{
            font-size: 40px!important;
        }
         .position-relative{
            margin-top: 0!important;
        }

    }
    .sec-4 h2{
        font-size: 40px;
    }
    .nav-link{
        padding: 5px 20px;
    }
    .adv{
        font-size: 20px;

    }
    .sec-3 h2{
        font-size: 40px;
    }
    .btn{
        border-radius: 4px!important;
    }
    h3{
        font-weight: 600;
    }
     a:link{
        margin-right: 5px;
    }
    h1{
       
font-size: 75px;
font-weight: 600;
line-height: 65px;
letter-spacing: 0em;
text-align: center;

    }
    h1,h2,h3,h4{
        font-family: 'Roboto', sans-serif;

    }
    .sec-2 h2{
        font-size: 40px;
    }
    h2{
        font-weight: 700;
        font-weight: 40px;
    }
    main.py-4{
        padding-bottom: 0!important;
        padding-top: 0!important;
    }
    body{
        background: #fff;
    }
    input{
        color: #000;
    }
    /*.sign-user_card {
        background: none !important;
    }*/
#ck-button {
    margin:4px;
/*    background-color:#EFEFEF;*/
    border-radius:4px;
/*    border:1px solid #D0D0D0;*/
    overflow:auto;
    float:left;
}
#ck-button label {
    float:left;
    width:4.0em;
}
#ck-button label span {
    text-align:center;
    display:block;
    color: #fff;
    background-color: #3daae0;
    border: 1px solid #3daae0;
    padding: 0;
}
#ck-button label input {
    position:absolute;
/*    top:-20px;*/
}

#ck-button input:checked + span {
    background-color:#3daae0;
    color:#fff;
}
    
.mobile-div {
	margin-left: -2%;
	margin-top: 1%;
}
.modal-header {
    padding: 0px 15px;
    border-bottom: 1px solid #e5e5e5 !important;
    min-height: 16.42857143px;
}
#otp {
    padding-left: 15px;
    letter-spacing: 42px;
    border: 0;
   /* background-image: linear-gradient(to right, black 60%, rgb(120, 120, 120) 0%);*/
    background-position: bottom;
    background-size: 50px 1px;
    background-repeat: repeat-x;
    background-position-x: 80px;
}
    #otp:focus {
        border: none;
    }
    /*.sign-up-buttons{
        margin-left: 40% !important;
    }*/.verify-buttons{
        margin-left: 36%;
    }
    .container{
        margin-top: 70px;
    }
    .panel-heading {
    margin-bottom: 1rem;
}
   /* .form-control {
    background-color: var(--iq-body-text) !important;
    border: 1px solid transparent;
    height: 46px;
    position: relative;
    color: var(--iq-body-bg) !important;
    font-size: 16px;
    width: 100%;
    -webkit-border-radius: 6px;
    border-radius: 6px;
}
    a {
    color: var(--iq-body-text);
    text-decoration: none;
}*/
.phselect{
    
    height: 45px !important;
    background: transparent !important;
    color: var(--iq-white) !important;
}
.form-control {
    height: 45px;
    line-height: 45px;
    background: transparent !important;
    border: 1px solid var(--iq-body-text);
    font-size: 14px;
    color: #000!important;
    border-radius: 0;
    margin-bottom: 1rem !important;
}
    .form-control:focus {
    
    background-color: #fff;
    border-color: #80bdff;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgb(0 123 255 / 25%);
}
    .custom-file-upload {
    border: 1px solid #ccc;
    display: inline-block;
    padding: 6px 12px;
    cursor: pointer;
}
/*input[type="file"] {
    display: none;
}*/
    .catag {
    padding-right: 150px !important;
}
i.fa.fa-google-plus {
    padding: 10px !important;
}
    option {
    background: #474644 !important;
}
    .card{
        background: transparent!important;
        border:none!important;
    }
    .reveal{
        margin-left: -92px;
    height: 45px !important;
    background: transparent !important;
    color: #fff !important;
    }
    .error {
    color: brown;
   font-family: 'Roboto', sans-serif;

    }
   
    .agree {
    font-style: normal;
    font-weight: 400;
    font-size: 10px;
    line-height: 18px;
    display: flex;
    align-items: center;
    color: #000;
}
    .get{
   font-family: 'Roboto', sans-serif;

font-style: normal;
font-weight: 500;
font-size: 20px;
line-height: 32px;
}
    .form-group{
        margin-bottom: 0;
    }
    #fileLabel{
        position: absolute;
        top: 8px;
        color: #fff;
        padding: 8px;
        left: 114px;
        background:rgba(11, 11, 11,1);
        font-size: 12px;
    }
      .signup-desktop{
        background-color: #fff;
          border-radius: 5px!important;
        border:none!important;
        font-family: 'Roboto', sans-serif;
          padding: 5px 10px!important;

font-style: normal;
font-weight: 600;

    }
     .nees{
        margin: 2px;
    }
    .nees1{
        margin: 10px;
    }
    .signup-desktop i{
        font-size: 22px;
    }
    .btn-outline-success{
        border: none;
    }
     .signup-desktop:hover{
        background-color: burlywood;
         color: #fff;

    }
    .signup{
       background: rgba(1, 220, 130, 1)!important;
        padding: 10px 30px;
          font-family: 'Roboto', sans-serif;
        font-weight: 600;

    }
    p{
   font-family: 'Roboto', sans-serif;
font-weight: 400;
font-size: 20px;
line-height: 32px;

}
    .nav-link.active{
        color: #fff!important;
       background: #01DC82!important;


    }
    .btn{
        font-weight: 500;
    }
    .poli{
        font-family: 'Roboto', sans-serif;
        font-size: 11px;
    }
    .sec{
        padding: 70px 0 70px 0;
    }
    .in {
    font-size: 35px;
    line-height: 40px;
    font-weight: 600;
    color: #000;
    text-align: left;
    font-family: 'Roboto', sans-serif;
}
    .btn-success{
        color: #000;
    }
    .bg-light {
    background: transparent!important;
    color: #000;
    z-index: 1;
}
    .div1{
       padding:50px 90px 100px 20px;
    }
    .h-100{display: flex;
    justify-content: center;
    flex-direction: column;
    align-items: center;
    align-self: center;}
    .nem{
        color: #01DC82;

    }
    .lan{
        margin-top: 40px;
    }
    .dig{
        font-style: normal;
font-weight: 400;
font-size: 35px;
line-height: 32px;
    }
    .tune li{
        font-size: 20px;
        line-height: 40px;
    }
    .slick-next:before {
    content: '→';
        display: none;
}
    .slick-prev:before {
    content: '←';
          display: none;
}
    .nav-link{
        font-size: 17px;
    }
    .io{
        position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    color: white;
        text-align: center;
    }
</style>

<?php $jsonString = file_get_contents(base_path('assets/country_code.json'));   

$jsondata = json_decode($jsonString, true); ?>

<section class="mb-0" ><!--style="background:url('<?php echo URL::to('/').'/public/uploads/settings/'.$settings->login_content; ?>') no-repeat scroll 0 0;;background-size: cover;"-->
    
   </section>

<section style="background:url('<?php echo URL::to('/').'/public/uploads/settings/'.$settings->login_content; ?>') no-repeat scroll 0 0;;background-size: cover;">
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <?php $jsonString = file_get_contents(base_path('assets/country_code.json'));   

    $jsondata = json_decode($jsonString, true); ?>
<?php 
    $ref = Request::get('ref');
    $coupon = Request::get('coupon');
    // dd($SignupMenu);
?>

<!-- Modal -->
  <div class="modal fade" id="terms" role="dialog" >
    <div class="modal-dialog" style="width: 90%;color: #000;">
    
      <!-- Modal content-->
      <div class="modal-content" >
        <div class="modal-header" style="border:none;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="color:#000;"><?php echo __('Terms and Conditions');?></h4>
        </div>
        <div class="modal-body" >
            <?php
                $terms_page = App\Page::where('slug','terms-and-conditions')->pluck('body');
             ?>
            <p><?php echo $terms_page[0];?></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close');?></button>
        </div>
      </div>
    </div>
  </div>
<style>
    .modal-content {
        background-color: #000000;
    }
</style>

<div class="modal fade" id="loginModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" data-toggle="modal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document" style="width: 50%;">
    <div class="modal-content">
      <div class="modal-header" style="text-align:center;">
        <h5 class="modal-title" id="exampleModalLongTitle"><h1><?=__('Enter the 4-digit Verification code sent');?></h1></h5>
        
      </div>
      <div class="modal-body">
              <form action="" method="POST" id="confirm" >
               
                <!--<label for="username" class="col-md-4 col-sm-offset-1 col-form-label text-md-right"><=__('Enter OTP');?></label>-->
                    <p style="color:green" id="success"></p>
            @csrf
               <div class="well row col-xs-12">
					<div class="otp_width">
						<input type="text" class="form-control" maxlength="4" name="otp" id="otp" value="" style="background-color: #000;" />
						<input type="hidden" class="form-control" name="verify" id="verify_id" value="" />
						<div class="row timerco" >
						 	<p> OTP will Expire in <span id="countdowntimer"></span>
					 	</div>
						<div class="text-center"> 
							<input type="button" value="{{ __('Verify') }}" id="checkotp"  placeholder="Please Enter OTP" class="btn btn-primary btn-login" style="">
						</div>
					 </div> 
				</div>
                  
                <div class="well row col-xs-12" style="padding: 0;">
                   <div class="col-sm-8  col-sm-offset-1">
                   <div class="verify-buttons">
                            
                    </div>
                  </div>
                  </div>
          </form>
      </div>
   
      <div class="modal-footer" style="border:none;">
        
      </div>
    </div>
  </div>
</div>
    </section>
       
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>






 <!-- jQuery, Popper JS -->
      <script src="assets/js/jquery-3.4.1.min.js"></script>
      <script src="assets/js/popper.min.js"></script>
      <!-- Bootstrap JS -->
      <script src="assets/js/bootstrap.min.js"></script>
      <!-- Slick JS -->
      <script src="assets/js/slick.min.js"></script>
      <!-- owl carousel Js -->
      <script src="assets/js/owl.carousel.min.js"></script>
      <!-- select2 Js -->
      <script src="assets/js/select2.min.js"></script>
      <!-- Magnific Popup-->
      <script src="assets/js/jquery.magnific-popup.min.js"></script>
      <!-- Slick Animation-->
      <script src="assets/js/slick-animation.min.js"></script>
      <!-- Custom JS-->
      <script src="assets/js/custom.js"></script>
       <script src="<?= URL::to('/'). '/assets/js/jquery.lazy.js';?>"></script>
      <script src="<?= URL::to('/'). '/assets/js/jquery.lazy.min.js';?>"></script>



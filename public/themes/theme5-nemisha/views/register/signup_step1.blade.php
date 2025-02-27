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
      <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link href="<?php echo URL::to('public/themes/theme5-nemisha/assets/fonts/font.css') ?>" rel="stylesheet">

        <link rel="preload" as="image" href="https://nemisatv.co.za/assets/img/nem-b.webp" alt="header-logo" width="100%" height="100%">

      <!-- Typography CSS -->
         <link rel="stylesheet" href="<?php echo URL::to('public/themes/theme5-nemisha/assets/css/style.css') ?>" />
      <!-- Style -->
      <link rel="stylesheet" href="<?php echo URL::to('public/themes/theme5-nemisha/assets/css/typography.css') ?>" />
      <!-- Responsive -->
      <link rel="stylesheet" href="<?php echo URL::to('public/themes/theme5-nemisha/assets/css/responsive.css') ?>" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js">
  </script>
<style>
     .navbar-collapse{
        padding-left: 25px;
    }
    .btn{
        z-index: 0;
    }
    .sec-3{
        background:#003C3C
!important;
    }
    .sec-4 h2{
        font-size: 40px;
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
    /* h1,h2,h3,h4{
     

    } */
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
    /* .container{
      
    } */
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
    
    width: 100%;
    height: 45px !important;
    background: transparent !important;
    color: var(--iq-white) !important;
}
.form-control {
    height: 45px;
    line-height: 45px;
    background: #fff!important;
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
    .reveal{
        margin-left: -57px;
    height: 45px !important;
    background: #F9CB04  !important;
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
    /* color: #000; */
}
    .get{
   color: #fff;

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

    .poli{
       color:#fff;
        font-size: 11px;
    }
    .in {
    font-size: 35px;
    line-height: 40px;
    font-weight: 600;
    /* color: ; */
    text-align: left;
   
}
       .btn-outline-success{
        border: 1px solid #F9CB04 ;
         color: #F9CB04 !important;
    }
    .btn-outline-success:hover{
        border: 1px solid #F9CB04 ;
        background-color: #F9CB04 !important;
         color: #ffffff!important;
    }
    .btn-success{
        background: #F9CB04 !important;
        border: 1px solid #F9CB04 ;

    }
     .join{
        color: #FFD109;
    }
    .nemi{
        color: #F9CB04 ;
    }
    .bg-light{
        background-color: #fff!important;
    }
    #avatar {
        display: none;
    }

    .custom-file-label {
        display: inline-block;
        position: relative;
        width: 100%;
        padding: 0px 13px;
        cursor: pointer;
        margin-bottom: 17px;
        color: #cacaca !important;
        /* background:rgba(11, 11, 11,1); */
        border-radius: 7px;
        font-size: 16px;
        font-family: inherit;
    }
    .custom-file-label::after{
        line-height: 2.2;
        height: 100%;
    }

    @media (max-width:425px){
    .my-sm-0{
        font-size:14px;
    }
    .login-header-logo{
        width:100px;
    }
}

.ui-datepicker select.ui-datepicker-month, 
        .ui-datepicker select.ui-datepicker-year {
            width: 50%;
            display: inline-block;
            margin: 0 2%;
            padding: 5px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f8f8f8;
        }
        .ui-datepicker {
            font-size: 14px; /* Adjust the overall size of the datepicker */
        }
        .ui-datepicker .ui-datepicker-title {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .ui-datepicker select.ui-datepicker-month option,
        .ui-datepicker select.ui-datepicker-year option {
            padding: 10px;
            background-color: white !important;
            color: #333;
            font-size: 14px;
        }

        .ui-datepicker select.ui-datepicker-month option:hover,
        .ui-datepicker select.ui-datepicker-year option:hover {
    
            color: black !important; 
        }

</style>

<?php $jsonString = file_get_contents(base_path('assets/country_code.json'));   

$jsondata = json_decode($jsonString, true); ?>

<section class="mb-0" style="background:url('<?php echo URL::to('/').'/public/uploads/settings/'.$settings->login_content; ?>') no-repeat scroll 0 0;;background-size: cover;">
    
<nav class="navbar navbar-expand-lg navbar-light bg-light p-0">
        <div class="container-fluid">
  <a class="navbar-brand" href="#"><img class="login-header-logo" src="<?php echo URL::to('/assets/img/cocreataz-final-logo-black.svg'); ?>" style="" width="100%" height="100%"></a>
  <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button> -->

    <div class="justify-content-end" id="navbarSupportedContent">
        <a class="btn btn-outline-success my-2 mr-2 my-sm-0" href="{{ route('login') }}" >Sign in</a>
        <a class="btn btn-success my-2 my-sm-0"  href="{{ route('signup') }}">Sign up</a>
    </div>
</div></nav>
<div class="position-relative">
<div class="fixe" >
      <h1 class="in mt-3 text-center" style="color:#cacaca;">SIGN UP TO <span class="nemi"> COCREATAZ</span></h1>
    <div class="row m-0 p-0 justify-content-center" >
      
        <div class="col-md-5 col-lg-5 ">
            <div class="" style="margin:0 5px auto;">
           
            <div class="p-0" style="margin:5px 4px 5px auto;">
      <div class="row p-0" >
         <div class="col-sm-12 col-md-12 col-lg-12 p-0">

                            {{-- recaptcha --}}
                <div class="col-md-12">
                    @if ($errors->has('g-recaptcha-response'))
                        <span class="alert alert-danger display-hide" id="successMessage" >
                            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                        </span>
                     @endif
                </div>

            <div class="sign-user_card ">                    
               <div class="sign-in-page-data">
                  <div class="sign-in-from w-100 m-auto">
                      <div align="center">
                         <!-- <img src="<?//php// echo URL::to('/').'/public/uploads/settings/'. $settings->logo ; ?>" style="margin-bottom:1rem;"> -->     
                                 <!-- <p class="get">Get 5 free days of COCREATAZ</p>-->
                      </div>
                       
                      
                      <form onsubmit="return ValidationEvent()" action="<?php if (isset($ref) ) { echo URL::to('/').'/register1?ref='.$ref.'&coupon='.$coupon; } else { echo URL::to('/').'/register1'; } ?>" method="POST" id="stripe_plan" class="stripe_plan" name="member_signup" enctype="multipart/form-data">
                        @csrf
                            <div class="form-group">
                            
                                @if (!empty($SignupMenu) && $SignupMenu->username == 1)
                                    <div class="col-md-12">
                                        <input id="username" type="text"  class="form-control alphaonly  @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" placeholder="Username" required autocomplete="off" autofocus>

                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    @endif
                                
                                
                                @if(!empty($SignupMenu) && $SignupMenu->email == 1)
                                    <div class="col-md-12">
                                    <input id="email" type="email" placeholder="Email Address"  class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="off" >
                                    <span class="invalid-feedback" id="email_error" role="alert">Email Already Exits
                                    </span>

                                    @error('email')
                                        <span class="invalid-feedback" id="email_error" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                @endif
                            
                            
                                @if(!empty($SignupMenu) && $SignupMenu->mobile == 1)
                                 <div class="col-md-12">
                                            <div class="row">
                               
                            <div class="col-md-5 col-sm-12">
                              <select class="phselect form-control" name="ccode" id="ccode" >
                              <option>Select Country</option>
                                @foreach($jsondata as $code)
                                <option value="{{  $code['dial_code'] }}" {{ $code['name'] == "United States" ? 'selected' : ''}}>{{ $code['name'].' ('. $code['dial_code'] . ')' }}</option>
                                @endforeach
                            </select>
                            </div>

                            <div class="col-md-7 col-sm-8">
                                <input id="mobile" type="text" maxlength="10" minlength="10" class="form-control @error('email') is-invalid @enderror" name="mobile" placeholder="{{ __('Enter Mobile Number') }}" value="{{ old('mobile') }}" required autocomplete="off" autofocus> 
                                <span class="verify-error"></span>
                                
                                 @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror                                    
                            </div></div>
						

                                </div>
                                
                                @endif
                            
                            
                                @if(!empty($SignupMenu) && $SignupMenu->avatar == 1)
                                    <div class="col-md-12" style="position:relative;">
                                        <input type="file" multiple="true" class="form-control" name="avatar" id="avatar" style="padding: 0px;" placeholder="Choose Profile Image " />
                                        <label for="avatar" class="custom-file-label form-control" >Choose Profile Image</label>
                                      
                                    </div>
                                @endif

                                 @if(!empty($SignupMenu) && $SignupMenu->dob == 1)
                                <div class="col-md-12" style="position:relative;">
                                    <input type="text" id="datepicker" name="dob"  class="datepicker form-control"  placeholder="Choose DOB"  required>
                                 </div>
                                 @endif

                            
                                @if(!empty($SignupMenu) && $SignupMenu->password == 1)
                                
                                 <div class="col-md-12">
                                     <div class="row">
                                     <div class="col-md-12">
                                <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror pwd" name="password" required autocomplete="new-password" style="margin-bottom: 0!important;">
                                          <span style="color:#cacaca;font-style: oblique;font-weight: 400;font-size: 12px;line-height: 25px;">Password must be at least 8 characters long.</span>
                                         </div>
                                         <div >
                                <span class="input-group-btn" id="eyeSlash">
                                   <button class="btn btn-default reveal" onclick="visibility1()" type="button"><i class="fa fa-eye-slash" aria-hidden="true"></i></button>
                                 </span>
                                 <span class="input-group-btn" id="eyeShow" style="display: none;">
                                   <button class="btn btn-default reveal" onclick="visibility1()" type="button"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                 </span>
                                         </div>
                                @if ($errors->has('password_confirmation'))
                                    <span class="text-danger" id="successMessage"  style='padding-left: 22px' >
                                    <strong>Password Not matching.</strong>
                                    </span>
                                    @endif
                                         </div>
                            </div>
                                @endif
                            
                            
                                @if(!empty($SignupMenu) && $SignupMenu->password_confirm == 1)
                            <div class="col-md-12 mb-0">
                                <div class="row">
                                     <div class="col-md-12 mb-0">
                                <input id="password-confirm" type="password" class="form-control mb-0" placeholder="Confirm Password" name="password_confirmation" required autocomplete="new-password" style="margin-bottom: 0!important;">
                                    </div>
                                    <div >
                                 <span class="input-group-btn" id="eyeSlash1">
                                   <button class="btn btn-default reveal" onclick="visibility2()" type="button"><i class="fa fa-eye-slash" aria-hidden="true"></i></button>
                                 </span>
                                 <span class="input-group-btn" id="eyeShow1" style="display: none;">
                                   <button class="btn btn-default reveal" onclick="visibility2()" type="button"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                 </span>
                                    </div>
                                </div>
    
                                <span style="color:#cacaca;font-style: oblique;font-weight: 400;font-size: 12px;line-height: 25px;">Password must be at least 8 characters long.</span>
                            </div>
                                 
                                      
                                @endif
                            </div>  
                            
                       <div class="form-group row">
                        </div>
                            <?php if ( isset($ref)) { ?>
                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-4 col-sm-offset-1 col-form-label text-md-right">{{ __('Referrer ID') }} <span style="color:#4895d1"></span>
                                    </label>
                                    <div class="col-md-6">
                                        <input id="referrer_code" type="text" class="form-control" value="<?php echo $ref;?>" name="referrer_code" readonly>
                                    </div>
                                </div>
                            <?php } ?>
                        
                        <div class="form-group" >
	                             {{-- reCAPTCHA  --}}
                            <div class="col-md-12" id="">
                                @if( get_enable_captcha_signup()  == 1)   
                                    <div class="form-group" style="  margin-top: 30px;">
                                        {!! NoCaptcha::renderJs('en', false, 'onloadCallback') !!}
                                        {!! NoCaptcha::display() !!}
                                    </div>
                                @endif
                            </div>

							<!--<div class="col-md-12" id="mob">
                                <input id="password-confirm" type="checkbox" name="terms" value="1" required>
								<label for="password-confirm" class="col-form-label text-md-right text-black" style="display: inline-block;">{{ __('Yes') }} ,<a data-toggle="modal" data-target="#terms" style="text-decoration:none;color: #fff;"> {{ __('I Agree to Terms and  Conditions' ) }}</a></label>
                            </div>-->

                            <div class="sign-up-buttons col-md-12 mt-3 " align="right">
                                  <button type="button" value="Verify Profile" id="submit" class="btn btn-primary btn-login verify-profile" style="display: none;"> Verify Profile</button>
                                  <!-- <button class="btn  btn-primary btn-block signup" style="display: block;color:#fff;font-size:20px;" type="submit" name="create-account">{{ __('START EXPLORING TODAY') }}</button> -->
                                  <input class="btn  btn-primary btn-block signup" style="border: #f3ece0 !important;color:#fff;font-size:20px;background-color: #F9CB04 !important;display: block;" type="submit" name="create-account" value="START EXPLORING TODAY">

                                 <!-- <p class="text-left poli mb-0 mt-2" >By signing up you agree to COCREATAZ Terms of Service and Privacy Policy. </p> -->
                                 <!-- <div class=" pt-4 mb-2">
                                    <hr style="border-color:#fff;">
                                    <p class="bg-white" style="position: relative;top: -23px;right:50%;z-index: 1;width: 5%;display: flex;justify-content: center;font-size:12px;">Or</p>
                                </div>-->
                            </div>
                                <div class="col-md-12 d-flex align-items-center links" id="mob">
                                    <input id="password-confirm" type="checkbox" name="terms" value="1" required>
                                    <label for="password-confirm" class="col-form-label text-md-right" style="display: inline-block; cursor: pointer;">
                                        <p class="text-left text-white agree mb-0 pl-2" style="color: #cacaca !important">By signing up you agree to COCREATAZ   
                                            <a style="color:#01DC82!important;" href="https://nemisatv.co.za/page/terms-and-conditions" target="_blank" class="ml-1">Terms and Conditions</a>
                                        </p>
                                        </a>
                                    </label>
                                </div>
                           
                        <div class="form-group row mb-0 p-0 m-0 mt-4 justify-content-center">
						
                            <div class="col-md-8 p-0 d-flex justify-content-center">
                                @if ( config('social.google') == 1 )
                            <a href="{{ url('/auth/redirect/google') }}" style="border:none;color:#fff;"  class="btn signup-desktop"><i class="fa fa-google"></i> Google</a>
                                 @endif  
                                @if ( config('social.facebook') == 1 )
                                  <a href="{{ url('/auth/redirect/facebook') }}" class="btn signup-desktop" style="border:none;color:#fff;"><img class="" src="<?php echo  URL::to('/assets/img/ff.png')?>" style=""> Facebook</a>
                                	@endif 
                            </div>
                       
						
                         
					
						</div>
                        </div>
                       
                     
                    </form>
                       <!--<div class="mt-3">
                  <div class="d-flex justify-content-center links text-black">
                     Already have an account? <a href="<?//= URL::to('/login')?>" class="text-primary ml-2">Sign In</a>
                  </div>                        
               </div>-->
                  </div>
                  
               </div>    
               
            </div>
         </div>
      </div>
   </div>

            
        </div>
        </div>
       
    </div>
    </div></div>
   
    <!--<section class="sec-3" style="padding:80px 30px 80px 30px;">
        <div class="container">
            <div class="row align-items-center">
                 <div class="col-lg-6">
                 <img class="w-100 " src="<?//php echo  URL::to('/assets/img/m1.png')?>" style="">
            </div>
            <div class="col-lg-6">
                <h2 class="mb-4">Free edutainment for the digital warrior</h2>
                <p class="text-white mt-2 mb-3">Advancing South Africans for the future with content that is missioned to deliver tangible digital skills to bridge the digital divide.</p>
                <p class="text-white mt-2 mb-3">WATCH EVERYWHERE, STREAM LIVE, QUALITY VIDEOS</p>
                  <a class="btn btn-lg btn-success  my-2 mr-2 my-sm-0 btn-block" style="padding:12px;width:70%;color:#fff!important" href="{{ route('login') }}" ><span>Get Started</span></a>
            </div>
           
        </div></div>
    </section>

   <div class="container">
      <div class="row  align-items-center justify-content-center height-self-center">
         <div class="col-lg-6 col-12 col-md-12 align-self-center">
             <div class="text-center">
                 <img src="<?// php echo URL::to('/').'/public/uploads/settings/'. $settings->logo ; ?>"  style="margin-bottom:1rem;">
             </div>
            
         </div>
          
      </div>
   </div>-->
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
            <p style='color: white;'><?php echo $terms_page[0];?></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close');?></button>
        </div>
      </div>
    </div>
  </div>
<style>
    .modal-content {
        background-color: #F9CB04 ;
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
							<input type="button" value="{{ __('Verify') }}" id="checkotp"  placeholder="Please Enter OTP" class="btn btn-primary btn-login" >
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
@endsection
</section>

       
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include jQuery UI library -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
    jQuery.noConflict();
    (function($) {
        $(document).ready(function() {
            $("#datepicker").datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: "1900:c",
                maxDate: 0  
            });
        });
    })(jQuery);
</script>  

<script>
    $(document).ready(function(){
         $('#error_password').hide();

    });
    function ValidationEvent(form) {

        const email = $('#email').val();  
        const regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

        const isValid = regex.test(email);
        if(!isValid){
            alert("Enter Valid Email Address");
        }

        var password_confirm = '<?= $SignupMenu->password_confirm ?>'; 
        
        if(password_confirm == 0){
            var password_confirmation = 0;
            $('.error_password').hide();
            return true;
        }else{
                var password_confirmation = '<?= $SignupMenu->password_confirmation ?>';
            // alert(password_confirmation);
            // 👇 get passwords from the field using their name attribute
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password-confirm').value;   

            // 👇 check if both match using if-else condition
            if (password != confirmPassword) {
                $('.error_password').show();
            return false;
            } else {
                $('.error_password').hide();
            return true;
            }
        }

        // var fileInput = document.getElementById('avatar');
        // console.log("avatar",avatar);
        
        // if (fileInput.files.length === 0) {
        //     alert("Please select a profile image.");
        //     return false;
        // }
}
function visibility1() {

  var x = document.getElementById('password');
  if (x.type === 'password') {
    x.type = "text";
    $('#eyeShow').show();
    $('#eyeSlash').hide();
  }else {
    x.type = "password";
    $('#eyeShow').hide();
    $('#eyeSlash').show();
  }
}

// function passwordValidation(){
//     const password = $('#password').val();
//     const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#.,])[A-Za-z\d@$!%*?&#]{8,}$/;
//     const isValidPassword = regex.test(password);
//     if(!isValidPassword){
//         console.log("password",password);
        
//         alert("Entered Password is weak, so enter strong password");
//     }
//     return isValidPassword;
// }
</script>
<script>
    function visibility2() {
  var x = document.getElementById('password-confirm');
  if (x.type === 'password') {
    x.type = "text";
    $('#eyeShow1').show();
    $('#eyeSlash1').hide();
  }else {
    x.type = "password";
    $('#eyeShow1').hide();
    $('#eyeSlash1').show();
  }
}
</script>
<script>
    $('.alphaonly').bind('keyup blur',function(){ 
    var node = $(this);
    node.val(node.val().replace(/[^a-z,^A-Z ]/g,'') ); }
);
</script>
<script>
$.ajaxSetup({
           headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });


	$(document).ready(function(){
        $('#email_error').hide();

// $('#email').change(function(){

// 	var email = $('#email').val();
// 	$.ajax({
//         url:"{{ URL::to('/emailvalidation') }}",
//         method:'GET',
//         data: {
//                _token: '{{ csrf_token() }}',
//                email: $('#email').val()

//          },        success: function(value){
// 			console.log(value.email);
//             if(value.user_exits == "yes"){
//             $('#email_error').show();
//             }else{
//             $('#email_error').hide();
//             }
//         }
//     });
// })

});
	
</script>
<script type="text/javascript">
    
function format(item, state) {
  if (!item.id) {
    return item.text;
  }
  var countryUrl = "https://hatscripts.github.io/circle-flags/flags/";
  var url = countryUrl;
  var img = $("<img>", {
    class: "img-flag",
    width: 26,
    src: url + item.element.value.toLowerCase() + ".svg"
  });
  var span = $("<span>", {
    text: " " + item.text
  });
  span.prepend(img);
  return span;
}

$(document).ready(function() {
  $(".js-example-basic-single").select2({
    templateResult: function(item) {
      return format(item, false);
    }
  });

});




   $(document).ready(function () {
      // $('.input-phone').intlInputPhone();
    //$('.js-example-basic-single').select2();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
//     $("#submit").click(function(e){
//         e.preventDefault();
//         var ccode = $("#ccode").val();
//         var mobile = $("#mobile").val();       
//         var url = '{{ url('sendOtp') }}';        
//         if (mobile.length > 5 ){
//             $.ajax({
//                url:url,
//                method:'POST',
//                data:{
//                       ccode:ccode, 
//                       mobile:mobile
//                     },
//                success:function(response){                   
//                    if (response.status == true) {
//                         var veri = response.verify;
//                        $("#verify_id").val(veri);
//                        $("#loginModalLong").modal('show');
//                        timer();
                       
//                        //$('#loginModalLong').show();
                       
//                    } else {
//                         $(".verify-error").html(response.message);
//                         $(".verify-error").css("color","red");
//                    }
//                },
             
//             });
//           } else {
// //               alert(response.message);
// //                   return false;
//                 $("#success").html(response.message);
//                 alert('Length Must be atleast 10');
//           }
//    });  
       
//     $("#checkotp").click(function(e){
//         e.preventDefault();
//         var otp = $("#otp").val(); 
//         var verify_id = $("#verify_id").val();       
//         var username = $("#username").val();       
//         var avatar = $("#avatar").val();       
//         var email = $("#email").val();       
//         var ccode = $("#ccode").val();       
//         var mobile = $("#mobile").val();       
//         var terms = $("#terms").val();       
//         var password_confirmation = $("#password_confirmation").val();       
//         var password = $("#password").val();       
//         var url = '{{ url('verifyOtp') }}'; 
//         let timerOn = true;
        
//         if (otp.length > 0 ){
//             $.ajax({
//                url:url,
//                method:'POST',
//                data:{
//                       otp:otp, 
//                       verify_id:verify_id
//                     },
//                    success:function(response){
//                        if (response.status == true) {
// //                         $('.verify-profile').css('display','none');
// //                         $('.signup').css('display','block');
// //                         $("#mobile").prop("readonly", true);
// //                         $("#verify-error").css("display","none");
// //                         $('.modal').modal('hide');
// //                         var base_url = $('.base_url').val();
// //                         $("#stripe_plan").submit();
// //                           
// //                           alert();
                           
// //                           
// //                           $.post(base_url+'/register1', {
// //                                 py_id:py_id, plan:plan_data, _token: '<?= csrf_token(); ?>' 
// //                               }, 
// //                                function(data){
// //                                    $('#loader').css('display','block');
// //                                    swal("You have done  Payment !");
// //
// //                                    setTimeout(function() {
// //                                    //location.reload();
// //                                    window.location.replace(base_url+'/register2');
// //
// //                                  }, 2000);
// //                               });
//                       } else {
//                         $(".success").html(response.message);
//                         $(".success").css("color","red");
//                         return false;
//                      }
                   
//                },
//             });
//           } else {
//                    alert('Length Must be atleast 4');
//           }
//    });
});

    function timer()
    {
           var timeleft = 300;
            var downloadTimer = setInterval(function(){
                var minutes = Math.floor(timeleft / 60);
                var minutes = Math.floor(timeleft / 60);
                var seconds = timeleft - minutes * 60;
                timeleft--;
                document.getElementById("countdowntimer").textContent = minutes +"minutes:"+seconds+"seconds";
                if(timeleft <= 0)
                    clearInterval(downloadTimer);
            },1000);
    }
    
    
</script>


    <script>
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal 
    btn.onclick = function() {
      modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal

    span.onclick = function() {
      modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }
    
    
    $(document).ready(function() {
        
    });
    
        $('#loginModalLong').modal({backdrop: 'static', keyboard: false}) 
        
    </script>

{{-- Validation --}}
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

    <script>

    var SignupMenu = '<?= $SignupMenu ?>'; 
    console.log(SignupMenu);
    if(SignupMenu && SignupMenu ==""){
        var username = 0;
        var password = 0;
        var password_confirmation = 0;
        var mobile = 0;
        var email = 0;
        var username = 0;
    }else{
        var username = '<?= $SignupMenu->username ?>';
        var password = '<?= $SignupMenu->password ?>';
        var password_confirmation = '<?= $SignupMenu->password_confirmation ?>';
        var mobile = '<?= $SignupMenu->mobile ?>';
        var email = '<?= $SignupMenu->email ?>';
        var username = '<?= $SignupMenu->username ?>';
    }
    // alert(password);
    $( "#stripe_plan" ).validate({
        
        rules: {
                username: {
                    required : function(element) {
                        if(username == 0) { 
                            return true;
                        } else {
                            return false;
                        }
                    }
                    // required: true,
                },
                password:{

                    // required: true,
                    minlength: 8,
                    maxlength: 30,
                    // regx: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])\w{6,}$/,
                    regx: /^(?=.*[A-Z])(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&_])[A-Za-z\d@$!%*#?&_]{8,}$/,
                    required : function(element) {
                        if(password == 0) {
                            return true;
                        } else {
                            return false;
                        }
                    }

            },
            //     password_confirmation: {
            //         required : function(element) {
            //             if(password_confirmation == 0) {
            //                 return true;
            //             } else {
            //                 return false;
            //             }
            //         }
            //     // required: true,
            //     minlength: 8,
            //     maxlength: 30,
            //     equalTo: "#password"
            // },
                mobile: {
                    // required: true,
                    remote: {
                        url: "{{ URL::to('SignupMobile_val') }}" ,
                        type: "post",
                        data: {
                            _token: "{{csrf_token()}}" ,
                            MobileNo: function() {
                            return $( "#mobile" ).val(); }
                        }
                    },
                    required : function(element) {
                        if(mobile == 0) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                },
                email: {

                    // required: true,
                    remote: {
                        url:"{{ URL::to('/emailvalidation') }}",
                        type: "get",
                        data: {
                            _token: "{{csrf_token()}}" ,
                            success: function() {
                            return $('#email').val(); }
                        }
                    },
                    required : function(element) {
                        if(email == 0) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                },
                username: {

                    // required: true,
                    remote: {
                        url:"{{ URL::to('/usernamevalidation') }}",
                        type: "get",
                        data: {
                            _token: "{{csrf_token()}}" ,
                            success: function() {
                            return $('#username').val(); }
                        }
                    },
                    required : function(element) {
                        if(username == 0) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                },
            },

                messages: {
                    mobile: {
                        required: "Please Enter the Mobile Number",
                        remote: "Mobile Number already in taken ! Please try another Mobile Number"
                    },
                    username: {
                         required: "Please Enter the Name",
                         remote: "Name already in taken ! Please try another Username"
                    },
                    email: {
                        required: "Please Enter the Email Id",
                        remote: "Email Id already in taken ! Please try another Email ID"
                    },
                    password: {
                        pwcheck: "Password is not strong enough"
                    }   
                   
                }
    });

    $.validator.addMethod("regx", function(value, element, regexpr) {          
    return regexpr.test(value);
}, "Please enter a valid pasword.");
    </script>
       <script>
           $(document).ready(function() {
    $("#show_hide_password a").on('click', function(event) {
        event.preventDefault();
        if($('#show_hide_password input').attr("type") == "text"){
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass( "fa-eye-slash" );
            $('#show_hide_password i').removeClass( "fa-eye" );
        }else if($('#show_hide_password input').attr("type") == "password"){
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass( "fa-eye-slash" );
            $('#show_hide_password i').addClass( "fa-eye" );
        }
    });
});
       </script>


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

@php
    include(public_path('themes/theme5-nemisha/views/footer.blade.php'));
@endphp

 
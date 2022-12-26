@extends('layouts.app')

<!doctype html>
<html lang="en-US">
   <head>
      <?php
$uri_path = $_SERVER['REQUEST_URI']; 
$uri_parts = explode('/', $uri_path);
$request_url = end($uri_parts);
$uppercase =  ucfirst($request_url);
// print_r($uppercase);
// exit();
      ?>
      <!-- Required meta tags -->
    <meta charset="UTF-8">
    <?php $settings = App\Setting::first(); //echo $settings->website_name;?>
    <title><?php echo $uppercase.' | ' . $settings->website_name ; ?></title>
    <meta name="description" content= "<?php echo $settings->website_description ; ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="preconnect" href="https://fonts.googleapis.com">
       <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= URL::to('/'). '/public/uploads/settings/' . $settings->favicon; ?>" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
     <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
      <!-- Typography CSS -->
         <link rel="stylesheet" href="<?php echo URL::to('public/themes/theme2/assets/css/style.css') ?>" />
      <!-- Style -->
      <link rel="stylesheet" href="<?= typography_link(); ?>" />
      <!-- Responsive -->
      <link rel="stylesheet" href="assets/css/responsive.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js">
  </script>
<style>
    h3{
        font-weight: 600;
    }
     a:link{
        margin-right: 5px;
    }
    h1,h2,h3,h4{
        font-family: 'Roboto', sans-serif;

    }
    h2{
        font-weight: 700;
        font-weight: 40px!important;
    }
    main.py-4{
        padding-bottom: 0!important;
        padding-top: 0!important;
    }
    body{
        background: #fff;
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
    color: var(--iq-white) !important;
    border-radius: 0;
    margin-bottom: 1rem !important;
}
    .form-control:focus {
     color: var(--iq-white) !important;
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
        margin-left: -92px;
    height: 45px !important;
    background: transparent !important;
    color: #fff !important;
    }
    .error {
    color: brown;
    font-family: 'remixicon';
    }
   
    .agree {
    font-style: normal;
    font-weight: 400;
    font-size: 11px;
    line-height: 18px;
    display: flex;
    align-items: center;
    color: #000;
}
    .get{
    font-family: 'Roboto';
font-style: normal;
font-weight: 500;
font-size: 20px;
line-height: 32px;
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
        border:1px solid #252525!important;
        font-family: 'Roboto', sans-serif;

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
    font-family: 'Roboto';

}
    .in {
    font-size: 35px;
    line-height: 40px;
    font-weight: 600;
    color: #000;
    text-align: left;
    font-family: 'Roboto', sans-serif;
}
</style>
<section class="mb-0" ><!--style="background:url('<?php echo URL::to('/').'/public/uploads/settings/'.$settings->login_content; ?>') no-repeat scroll 0 0;;background-size: cover;"-->
    
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
  <a class="navbar-brand" href="#"><img src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo ; ?>"  style="margin-bottom:1rem;"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
    

      <button class="btn btn-outline-success my-2 mr-2 my-sm-0" type="submit">Sign in</button>
      <a class="btn btn-success my-2 my-sm-0"  href="{{ route('signup') }}" style="" >Sign up</a>
    
  </div>
</div></nav>
<div class="position-relative" style="margin-top:-70px;">
<div class="fixe">
    <div class="row m-0 p-0">
        <div class="col-md-4 col-lg-4 p-0">
             <img class="w-100" src="<?php echo  URL::to('/assets/img/h1.png')?>" style="">
             <img class="w-100 mt-2" src="<?php echo  URL::to('/assets/img/h2.png')?>" style="">
        </div>
        <div class="col-md-4 col-lg-4 ">
            <div class="row">
                <div class="col-md-6 p-0">
                    <div class="nees">
                     <img class="w-100 " src="<?php echo  URL::to('/assets/img/h3.png')?>" style=""></div>
                </div>
                <div class="col-md-6 p-0">
                    <div class="nees">
                     <img class="w-100 " src="<?php echo  URL::to('/assets/img/h4.png')?>" style=""></div>
                </div>
            </div>
            <div class="">
      <div class="row justify-content-center align-items-center height-self-center">
         <div class="col-sm-12 col-md-12 col-lg-12 align-self-center">

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
                         <!-- <img src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo ; ?>" style="margin-bottom:1rem;"> -->      <h1 class="in mb-3 text-center text-black">Look Into Nemisa Tv For Realistic Experience<br>Join Now</h1>
                          <p class="get">Get 5 free days of Nemisa Tv</p>
                      </div>
                       <div class="form-group row mb-0 justify-content-center">
						@if ( config('social.google') == 1 )
                           
                            <div class="col-md-3 ">
                            <a href="{{ url('/auth/redirect/google') }}" style="border:none;color:#fff;"  class="btn signup-desktop"><i class="fa fa-google"></i> Google</a>
                            </div>
                        @endif  
						@if ( config('social.facebook') == 1 )
                            <div class="col-md-3 ">
                                <a href="{{ url('/auth/redirect/facebook') }}" class="btn signup-desktop" style="border:none;color:#fff;"><img class="" src="<?php echo  URL::to('/assets/img/ff.png')?>" style=""> Facebook</a>
                            </div>
						@endif 
						</div>
                      <div class=" pt-4 mb-2">
                          <hr>
                          <p class="bg-white" style="position: relative;top: -28px;left: 44%;z-index: 1;width: 10%;display: flex;justify-content: center;font-size:12px;">OR</p>
                      </div>
                      
                      <form action="<?php if (isset($ref) ) { echo URL::to('/').'/register1?ref='.$ref.'&coupon='.$coupon; } else { echo URL::to('/').'/register1'; } ?>" method="POST" id="stripe_plan" class="stripe_plan" name="member_signup" enctype="multipart/form-data">
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
                                    <input id="email" type="email" placeholder="Email Address"  class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="off">
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
                            <div class="col-md-12" style="postion:relative;">
                                <input type="file" multiple="true" class="form-control" style="padding: 0px;" name="avatar" id="avatar" />
                                <label id="fileLabel">Choose Profile Image</label>
                                 </div>
                                 @endif
                           
                            
                                @if(!empty($SignupMenu) && $SignupMenu->password == 1)
                                 <div class="col-md-12">
                                     <div class="row">
                                     <div class="col-md-12">
                                <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror pwd" name="password" required autocomplete="new-password" style="margin-bottom: 0!important;">
                                          <span style="color:#252525;font-family: 'Roboto';font-style: normal;font-weight: 400;font-size: 9px;line-height: 32px;">Password must be at least 8 characters long.</span>
                                         </div>
                                         <div >
                                <span class="input-group-btn" id="eyeSlash">
                                   <button class="btn btn-default reveal" onclick="visibility1()" type="button"><i class="fa fa-eye-slash" aria-hidden="true"></i></button>
                                 </span>
                                 <span class="input-group-btn" id="eyeShow" style="display: none;">
                                   <button class="btn btn-default reveal" onclick="visibility1()" type="button"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                 </span>
                                         </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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
    
                                <span style="color:#000;font-size: 10px;font-style: italic;">Password must be at least 8 characters long.</span>
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
                                @if( get_enable_captcha()  == 1)   
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

                            <div class="sign-up-buttons col-md-12 " align="right">
                                  <button type="button" value="Verify Profile" id="submit" class="btn btn-primary btn-login verify-profile" style="display: none;"> Verify Profile</button>
                                  <button class="btn  btn-primary btn-block signup" style="display: block;color:#000;" type="submit" name="create-account">{{ __('START EXPLORING TODAY') }}</button>
                                </div>
                            </div>
                        <p class="text-left agree mb-0" >By signing up you agree to Nemisa Tv Terms of Service and Privacy Policy. This page is protected by reCAPTCHA and is subject to Google's Terms of Service and Privacy Policy.</p>
                        
                    </form>
                       <!--<div class="mt-3">
                  <div class="d-flex justify-content-center links text-black">
                     Already have an account? <a href="<?= URL::to('/login')?>" class="text-primary ml-2">Sign In</a>
                  </div>                        
               </div>-->
                  </div>
                  
               </div>    
               
            </div>
         </div>
      </div>
   </div>

             <div class="row">
                <div class="col-md-6 p-0">
                    <div class="nees">
                     <img class="w-100 " src="<?php echo  URL::to('/assets/img/r1.png')?>" style=""></div>
                </div>
                <div class="col-md-6 p-0">
                    <div class="nees">
                     <img class="w-100 " src="<?php echo  URL::to('/assets/img/r2.png')?>" style=""></div>
                </div>
            </div>
        
        </div>
        <div class="col-md-4 col-lg-4 p-0">
            <img class="w-100" src="<?php echo  URL::to('/assets/img/h6.png')?>" style="">
            <img class="w-100 mt-2" src="<?php echo  URL::to('/assets/img/h7.png')?>" style="">
        </div>
    </div>
    </div></div>
    <section class="sec-2">
        <div class="container">
            <div class="row align-items-center p-3">
                <div class="col-lg-6">
                    <h2 class="text-center text-black">Nemisa Tv - The <br>World in You</h2>
                </div>
                <div class="col-lg-6">
                    <ul class="tune">
                        <li>Tune in and leave no stone untuned.</li>
                        <li>Beat the bushes of masters.</li>
                        <li>Get connected with global community.</li>
                        <li>Travel your journey with hot pics for you.</li>
.

                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section class="sec-3">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="tn-bg">
                        <h2>34K+</h2>
                        <p>CLASSES</p>
                    </div>
                </div>
                <div class="col-md-3">
                <div class="tn-bg">
                        <h2>800K+</h2>
                        <p>MEMBERS</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="tn-bg">
                        <h2>11K+</h2>
                        <p>TEACHERS</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="tn-bg">
                        <h2>4.8*</h2>
                        <p>APP STORE RATING</p>
                    </div>
                </div>
            </div>
            <h3 class="text-center mt-5">Explore More With Nemisa Tv</h3>
            <div class="mt-5">
                <ul class="nav nav-pills mb-3 justify-content-center " id="pills-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">All Genres</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Musical</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Documentry</a>
                     
                  </li>
                    <li class="nav-item">
                         <a class="nav-link" id="pills-conta-tab" data-toggle="pill" href="#pills-conta" role="tab" aria-controls="pills-conta" aria-selected="false">Animation</a>
                    </li>
                    <li class="nav-item">
                         <a class="nav-link" id="pills-mul-tab" data-toggle="pill" href="#pills-mul" role="tab" aria-controls="pills-mul" aria-selected="false">Multimedia</a>
                    </li>
                    <li class="nav-item">
                         <a class="nav-link" id="pills-cast-tab" data-toggle="pill" href="#pills-cast" role="tab" aria-controls="pills-cast" aria-selected="false">Vodcast</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-new-tab" data-toggle="pill" href="#pills-new" role="tab" aria-controls="pills-new" aria-selected="false">News</a>
                    </li>
                    <li class="nav-item">
                         <a class="nav-link" id="pills-nar-tab" data-toggle="pill" href="#pills-nar" role="tab" aria-controls="pills-nar" aria-selected="false">Webinar</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="pills-Film-tab" data-toggle="pill" href="#pills-Film" role="tab" aria-controls="pills-Film" aria-selected="false">Film & Video</a>
                    </li>
                    <li class="nav-item">
                          <a class="nav-link" id="pills-kids-tab" data-toggle="pill" href="#pills-kids" role="tab" aria-controls="pills-kids" aria-selected="false">Comic & Kids</a>
                    </li><br>
                    <li class="nav-item">
                         <a class="nav-link" id="pills-live-tab" data-toggle="pill" href="#pills-live" role="tab" aria-controls="pills-live" aria-selected="false">Live Recording</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-2d-tab" data-toggle="pill" href="#pills-2d" role="tab" aria-controls="pills-2d" aria-selected="false">2D & 3D Printing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-edu-tab" data-toggle="pill" href="#pills-edu" role="tab" aria-controls="pills-edu" aria-selected="false">Educational</a>
                    </li>
                    <li class="nav-item">
                         <a class="nav-link" id="pills-cas-tab" data-toggle="pill" href="#pills-cas" role="tab" aria-controls="pills-cas" aria-selected="false">Padcast</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-eve-tab" data-toggle="pill" href="#pills-eve" role="tab" aria-controls="pills-eve" aria-selected="false">Event</a>
                    </li>
                    <li class="nav-item">
                         <a class="nav-link" id="pills-rad-tab" data-toggle="pill" href="#pills-rad" role="tab" aria-controls="pills-rad" aria-selected="false">Radio</a>
                    </li>
</ul>
<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
      <div class="row">
          <div class="col-md-3 p-0">
              <div class="card" style="">
   <img class="w-100 " src="<?php echo  URL::to('/assets/img/r1.png')?>" style="">
  <div class="card-body">
    
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
   <div class="d-flex small-t justify-content-between">
       <p class="">Diana and Roma EN</p>
       <p>1H 15Min</p>
      </div>
  </div>
</div>
          </div>
          <div class="col-md-3 p-0">
              <div class="card" style="">
   <img class="w-100 " src="<?php echo  URL::to('/assets/img/r1.png')?>" style="">
  <div class="card-body">
    
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
   <div class="d-flex small-t justify-content-between">
       <p class="">Diana and Roma EN</p>
       <p>1H 15Min</p>
      </div>
  </div>
</div>
          </div>
          <div class="col-md-3 p-0">
               <div class="card" style="">
   <img class="w-100 " src="<?php echo  URL::to('/assets/img/r1.png')?>" style="">
  <div class="card-body">
   
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
   <div class="d-flex small-t justify-content-between">
       <p class="">Diana and Roma EN</p>
       <p>1H 15Min</p>
      </div>
  </div>
          </div>
         
            
      </div>
           <div class="col-md-3 p-0">
               <div class="card" style="">
   <img class="w-100 " src="<?php echo  URL::to('/assets/img/r1.png')?>" style="">
  <div class="card-body">
   
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
   <div class="d-flex small-t justify-content-between">
       <p class="">Diana and Roma EN</p>
       <p>1H 15Min</p>
      </div>
  </div>
              </div>
          </div></div>    <div class="row mt-2">
          <div class="col-md-3 p-0">
              <div class="card" style="">
   <img class="w-100 " src="<?php echo  URL::to('/assets/img/r2.png')?>" style="">
  <div class="card-body">
    
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
   <div class="d-flex small-t justify-content-between">
       <p class="">Diana and Roma EN</p>
       <p>1H 15Min</p>
      </div>
  </div>
</div>
          </div>
          <div class="col-md-3 p-0">
              <div class="card" style="">
   <img class="w-100 " src="<?php echo  URL::to('/assets/img/r2.png')?>" style="">
  <div class="card-body">
    
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
   <div class="d-flex small-t justify-content-between">
       <p class="">Diana and Roma EN</p>
       <p>1H 15Min</p>
      </div>
  </div>
</div>
          </div>
          <div class="col-md-3 p-0">
               <div class="card" style="">
   <img class="w-100 " src="<?php echo  URL::to('/assets/img/r2.png')?>" style="">
  <div class="card-body">
   
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
   <div class="d-flex small-t justify-content-between">
       <p class="">Diana and Roma EN</p>
       <p>1H 15Min</p>
      </div>
  </div>
          </div>
         
            
      </div>
           <div class="col-md-3 p-0">
               <div class="card" style="">
   <img class="w-100 " src="<?php echo  URL::to('/assets/img/r1.png')?>" style="">
  <div class="card-body">
   
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
   <div class="d-flex small-t justify-content-between">
       <p class="">Diana and Roma EN</p>
       <p>1H 15Min</p>
      </div>
  </div>
              </div>
          </div></div></div>
  <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
       <div class="row">
          <div class="col-md-3 p-0">
              <div class="card" style="">
   <img class="w-100 " src="<?php echo  URL::to('/assets/img/r2.png')?>" style="">
  <div class="card-body">
    
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
   <div class="d-flex small-t justify-content-between">
       <p class="">Diana and Roma EN</p>
       <p>1H 15Min</p>
      </div>
  </div>
</div>
          </div>
          <div class="col-md-3 p-0">
              <div class="card" style="">
   <img class="w-100 " src="<?php echo  URL::to('/assets/img/r2.png')?>" style="">
  <div class="card-body">
    
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
   <div class="d-flex small-t justify-content-between">
       <p class="">Diana and Roma EN</p>
       <p>1H 15Min</p>
      </div>
  </div>
</div>
          </div>
          <div class="col-md-3 p-0">
               <div class="card" style="">
   <img class="w-100 " src="<?php echo  URL::to('/assets/img/r2.png')?>" style="">
  <div class="card-body">
   
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
   <div class="d-flex small-t justify-content-between">
       <p class="">Diana and Roma EN</p>
       <p>1H 15Min</p>
      </div>
  </div>
          </div>
         
            
      </div>
           <div class="col-md-3 p-0">
               <div class="card" style="">
   <img class="w-100 " src="<?php echo  URL::to('/assets/img/r1.png')?>" style="">
  <div class="card-body">
   
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
   <div class="d-flex small-t justify-content-between">
       <p class="">Diana and Roma EN</p>
       <p>1H 15Min</p>
      </div>
  </div>
              </div>
          </div></div>
    </div>
  <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
          <div class="row">
          <div class="col-md-3 p-0">
              <div class="card" style="">
   <img class="w-100 " src="<?php echo  URL::to('/assets/img/r2.png')?>" style="">
  <div class="card-body">
    
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
   <div class="d-flex small-t justify-content-between">
       <p class="">Diana and Roma EN</p>
       <p>1H 15Min</p>
      </div>
  </div>
</div>
          </div>
          <div class="col-md-3 p-0">
              <div class="card" style="">
   <img class="w-100 " src="<?php echo  URL::to('/assets/img/r2.png')?>" style="">
  <div class="card-body">
    
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
   <div class="d-flex small-t justify-content-between">
       <p class="">Diana and Roma EN</p>
       <p>1H 15Min</p>
      </div>
  </div>
</div>
          </div>
          <div class="col-md-3 p-0">
               <div class="card" style="">
   <img class="w-100 " src="<?php echo  URL::to('/assets/img/r2.png')?>" style="">
  <div class="card-body">
   
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
   <div class="d-flex small-t justify-content-between">
       <p class="">Diana and Roma EN</p>
       <p>1H 15Min</p>
      </div>
  </div>
          </div>
         
            
      </div>
           <div class="col-md-3 p-0">
               <div class="card" style="">
   <img class="w-100 " src="<?php echo  URL::to('/assets/img/r1.png')?>" style="">
  <div class="card-body">
   
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
   <div class="d-flex small-t justify-content-between">
       <p class="">Diana and Roma EN</p>
       <p>1H 15Min</p>
      </div>
  </div>
              </div>
          </div></div>
    </div>
    <div class="tab-pane fade" id="pills-conta" role="tabpanel" aria-labelledby="pills-conta-tab">    <div class="row">
          <div class="col-md-3 p-0">
              <div class="card" style="">
   <img class="w-100 " src="<?php echo  URL::to('/assets/img/r2.png')?>" style="">
  <div class="card-body">
    
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
   <div class="d-flex small-t justify-content-between">
       <p class="">Diana and Roma EN</p>
       <p>1H 15Min</p>
      </div>
  </div>
</div>
          </div>
          <div class="col-md-3 p-0">
              <div class="card" style="">
   <img class="w-100 " src="<?php echo  URL::to('/assets/img/r2.png')?>" style="">
  <div class="card-body">
    
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
   <div class="d-flex small-t justify-content-between">
       <p class="">Diana and Roma EN</p>
       <p>1H 15Min</p>
      </div>
  </div>
</div>
          </div>
          <div class="col-md-3 p-0">
               <div class="card" style="">
   <img class="w-100 " src="<?php echo  URL::to('/assets/img/r2.png')?>" style="">
  <div class="card-body">
   
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
   <div class="d-flex small-t justify-content-between">
       <p class="">Diana and Roma EN</p>
       <p>1H 15Min</p>
      </div>
  </div>
          </div>
         
            
      </div>
           <div class="col-md-3 p-0">
               <div class="card" style="">
   <img class="w-100 " src="<?php echo  URL::to('/assets/img/r1.png')?>" style="">
  <div class="card-body">
   
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
   <div class="d-flex small-t justify-content-between">
       <p class="">Diana and Roma EN</p>
       <p>1H 15Min</p>
      </div>
  </div>
              </div>
          </div></div></div>
</div>
            </div>
                <div class="text-center mt-5 pt-2">
                    <a class="btn btn-success my-2 my-sm-0" style="font-weight:600;" herf="#">Explore More</a>
            </div></div>
            <div class="container-fluid mt-5 pt-5">
                <h2 class="text-center">Top Pics for You </h2>
                <div class="row mt-4">
                    <div class="col-md-6 p-0">
                        <div class="nees1">
                          <img class="w-100 " src="<?php echo  URL::to('/assets/img/t1.png')?>" style=""></div>
                    </div>
                    <div class="col-md-6 p-0">
                         <div class="nees1">
                             <img class="w-100 " src="<?php echo  URL::to('/assets/img/t2.png')?>" style=""></div>
                    </div>
                    <div class="col-md-6 p-0">
                        <div class="nees1">
                            <img class="w-100 " src="<?php echo  URL::to('/assets/img/t3.png')?>" style=""></div>
                    </div>
                    <div class="col-md-6 p-0">
                        <div class="nees1">
                            <img class="w-100 " src="<?php echo  URL::to('/assets/img/t4.png')?>" style=""></div>
                    </div>
                    <div class="col-md-6 p-0">
                        <div class="nees1">
                            <img class="w-100 " src="<?php echo  URL::to('/assets/img/t5.png')?>" style=""></div>
                    </div>
                    <div class="col-md-6 p-0">
                        <div class="nees1">
                            <img class="w-100 " src="<?php echo  URL::to('/assets/img/t6.png')?>" style=""></div>
                    </div>
                    
                </div>
                
            </div>
    </section>
    <section class="sec-4">
        <div class="container">
            <h2 class="text-center text-black">Members Endorsement</h2>
            <div class="text-center mt-4 mb-3">
                <img  src="<?php echo  URL::to('/assets/img/cli.png')?>" style=""></div>
            <div class="">
                <p class="ital"> <img class="w-20" src="<?php echo  URL::to('/assets/img/comma.png')?>" style="margin-top:-35px;">I come to Nemisa tv for the curation and class quality. That's really worth the cost of membership to me.</p>
                <p class="text-center mt-2">—Jason R, Nemisa Student</p>
            </div>
        </div>
    </section>
    <section class="sec-3">
        <div class="contianer">
            <div class="row align-items-center">
            <div class="col-lg-6">
                <h2>Free edutainment for the digital warrior</h2>
                <p class="text-white mt-2">Advancing South Africans for the future with content that is missioned to deliver tangible digital skills to bridge the digital divide.</p>
                <p class="text-white mt-2">WATCH EVERYWHERE, STREAM LIVE, QUALITY VIDEOS</p>
            </div>
            <div class="col-lg-6">
                 <img class="w-100 " src="<?php echo  URL::to('/assets/img/m1.png')?>" style="">
            </div>
        </div></div>
    </section>

   <!--<div class="container">
      <div class="row  align-items-center justify-content-center height-self-center">
         <div class="col-lg-6 col-12 col-md-12 align-self-center">
             <div class="text-center">
                 <img src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo ; ?>"  style="margin-bottom:1rem;">
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
       @php
    @include(public_path('themes\theme2\views\footer.blade.php'));
@endphp
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
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
                    regx: /^(?=.*[A-Z])(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/,
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
                        url: '{{ URL::to('SignupMobile_val') }}',
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




@endsection 

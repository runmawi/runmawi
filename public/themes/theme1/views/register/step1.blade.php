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

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= URL::to('/'). '/public/uploads/settings/' . $settings->favicon; ?>" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <!-- Bootstrap CSS -->
         <link rel="stylesheet" href="<?php echo URL::to('public/themes/theme1/assets/css/bootstrap.min.css') ?>" />

    <!-- Typography CSS -->
         <link rel="stylesheet" href="<?php echo URL::to('public/themes/theme1/assets/css/typography.css') ?>" />
         
    <!-- Style -->
         <link rel="stylesheet" href="<?php echo URL::to('public/themes/theme1/assets/css/style.css') ?>" />
  
    <!-- font awesome Icon -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

         
      <!-- Responsive -->
       <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Chivo&family=Lato&family=Open+Sans:wght@473&family=Yanone+Kaffeesatz&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="assets/css/responsive.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js">
  </script>
<style>
        .error {
    color: brown;
    font-family: 'Chivo' !important;
    }
    .sign-user_card {
       background: linear-gradient(rgba(136, 136, 136, 0.1) , rgba(64, 32, 32, 0.13), rgba(81, 57, 57, 0.12));!important;

    }
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
    .text-primary{
        text-decoration: underline!important;
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
    .form-control {
    height: 45px!important;
    line-height: 45px;
    background-color: transparent!important;
        letter-spacing: 0px!important;
    border: 1px solid var(--iq-body-text);
    font-size: 14px;
    color: var(--iq-white) !important;
    border-radius: 0;
    margin-bottom: 1rem !important;
    border: none!important;
    border-bottom: 1px solid #fff!important;
       
}
.phselect{
    width: 120px !important;
    height: 45px !important;
    background: transparent !important;
    color: var(--iq-white) !important;
    border:none;
}
    .form-control{
        padding-left: 4px;
        padding-top: 20px;
    }
.form-control {
    height: 45px;
    line-height: 45px;
   background-color: aqua;
    border: 1px solid var(--iq-body-text);
    font-size: 14px;
    color: var(--iq-white) !important;
    border-radius: 0;
    margin-bottom: 0rem !important;
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
    }*/.lab{
        background: rgba(22, 22, 23, 0.5)!important;padding-left:15px; border-radius: 5px!important;padding-bottom:6px;color: #fff!important
    }
    .catag {
    padding-right: 150px !important;
}
    .sign-user_card input{
        background-color: transparent!important;
    }
i.fa.fa-google-plus {
    padding: 10px !important;
}
    option {
    background: #474644 !important;
}
    .reveal{
        margin-left: -92px !important;
        margin-top: 10px;
    height: 45px !important;
    background: transparent !important;
    color: #fff !important;
        position: absolute;
    }
    .sign-in-page{
        background: linear-gradient(135.05deg, rgba(136, 136, 136, 0.48) 1.85%, rgba(64, 32, 32, 0.13) 38.53%, rgba(81, 57, 57, 0.12) 97.89%)!important;
        padding: 40px;
        border-radius: 20px;
        
    } 
    ::placeholder { color: #fff!important; opacity: 1; word-spacing: 9px !important;font-size: 16px!important;letter-spacing: 2px;font-weight: 100!important;text-transform: uppercase;}
:-ms-input-placeholder { color: #d9d5d5 !important;  word-spacing: 9px !important;}
::-ms-input-placeholder { color: #d9d5d5 !important;  word-spacing: 9px !important;}

</style>

<section class="sign-in-page" style="background:url('<?php echo URL::to('/').'/public/uploads/settings/'.$settings->login_content; ?>') no-repeat scroll 0 0;;background-size: cover;">
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <?php $jsonString = file_get_contents(base_path('assets/country_code.json'));   

    $jsondata = json_decode($jsonString, true); ?>
<?php 
    $ref = Request::get('ref');
    $coupon = Request::get('coupon');
    

?>
    

<!--<div class="container">
    <div class="row justify-content-center" id="signup-form">
        <div class="col-md-10 col-sm-offset-1">
			<div class="login-block">
				
                <div class="panel-heading" align="center" ><h5 style="color:#4895d1">{{ __('Enter your Info below to Sign-Up for an Account!') }}</h5></div>
                <div class="panel-body">
                    <form action="<?php if (isset($ref) ) { echo URL::to('/').'/register1?ref='.$ref.'&coupon='.$coupon; } else { echo URL::to('/').'/register1'; } ?>" method="POST" id="stripe_plan" class="stripe_plan" name="member_signup" enctype="multipart/form-data">
                        @csrf
                            <div class="form-group row">
                                <label for="username" class="col-md-4 col-sm-offset-1 col-form-label text-md-right">{{ __('Username') }} <span style="color:#4895d1">*</span></label>

                                <div class="col-md-6">
                                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="off" autofocus>

                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        
                            <div class="form-group row">
                                <label for="username" class="col-md-4 col-sm-offset-1 col-form-label text-md-right ">{{ __('User Profile') }} </label>

                                <div class="col-md-6">
                                        <input type="file" multiple="true" class="form-control" name="avatar" id="avatar" />

                                </div>
                            </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-sm-offset-1 col-form-label text-md-right">{{ __('E-Mail Address') }} <span style="color:#4895d1">*</span></label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="off">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                         
                        <div class="form-group row">
                            <label for="mobile" class="col-md-4 col-sm-offset-1 col-form-label text-md-right">{{ __('Phone Number') }} <span style="color:#4895d1">*</span></label>
                            
                            <div class="form-group">
                               
                            <div class="col-sm-2">
                              <select name="ccode" id="ccode" >
                                @foreach($jsondata as $code)
                                <option data-thumbnail="images/icon-chrome.png" value="{{ $code['dial_code'] }}" <?php if($code['dial_code']) { echo "selected='seletected'"; } ?>> {{ $code['name'].' ('. $code['dial_code'] . ')' }}</option>
                                @endforeach
                            </select>
                            </div>
                            <div class="col-sm-4">
                                <input id="mobile" type="text" class="form-control @error('email') is-invalid @enderror" name="mobile" placeholder="{{ __('Enter Mobile Number') }}" value="{{ old('mobile') }}" required autocomplete="off" autofocus> 
                                <span class="verify-error"></span>
                                
                                 @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror                                    
                            </div>
						</div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-sm-offset-1 col-form-label text-md-right">
                                {{ __('Password') }} <span style="color:#4895d1">*</span>
                            </label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                <span style="color:#4895d1">(Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.)</span>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror                               
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-sm-offset-1 col-form-label text-md-right">{{ __('Confirm Password') }} <span style="color:#4895d1">*</span>
                            </label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
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
                        
                        <div class="form-group row">
							<div class="col-md-4 col-sm-offset-1"></div>
							<div class="col-md-7">
                                <input id="password-confirm" type="checkbox" name="terms" value="1" required>
								<label for="password-confirm" class="col-form-label text-md-right" style="display: inline-block;">{{ __('Yes') }} ,<a data-toggle="modal" data-target="#terms" style="text-decoration:none;color: #fff;"> {{ __('I Agree to Terms and  Conditions and privacy policy' ) }}</a></label>
                            </div>
                        </div>
                        
                       
						<div class="form-group row">
							<div class="col-md-10 col-sm-offset-1">
                                <div class="sign-up-buttons">
                                  <button type="button" value="Verify Profile" id="submit" class="btn btn-primary btn-login verify-profile" style="display: none;"> Verify Profile</button>
                                  <button class="btn btn-lg btn-primary btn-block signup" style="display: block;" type="submit" name="create-account">{{ __('Sign Up Today') }}</button>
                                </div>
							</div>
						</div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>-->
    
<div class="container">
      <div class="row justify-content-center align-items-center height-self-center">
          
         <div class="col-sm-10 col-md-7 col-lg-6 align-self-center text-center">
             <div class="text-center">
               <img src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo ; ?>" style="margin-bottom:1rem;">  
          </div>
            <div class="sign-user_card ">                    
               <div class="sign-in-page-data">
                  <div class="sign-in-from w-100 m-auto">
                      <div align="center">
                               <h3 class="mb-3 text-center text-white">ACCOUNT</h3>
                      </div>
                      <form action="<?php if (isset($ref) ) { echo URL::to('/').'/register1?ref='.$ref.'&coupon='.$coupon; } else { echo URL::to('/').'/register1'; } ?>" method="POST" id="stripe_plan" class="stripe_plan" name="member_signup" enctype="multipart/form-data">
                        @csrf
                            <div class="form-group">
                                <!--<label for="username" class="col-md-4 col-sm-offset-1 col-form-label text-md-right">{{ __('Username') }} <span style="color:#4895d1">*</span></label>-->

                                <div class="col-md-12 lab" style=" ">
                            
                                    <input id="username" type="text"  class="form-control alphaonly  @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" placeholder="ACCOUNT ID" required autocomplete="off" autofocus>

                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12 lab mt-3">
                                <input id="email" type="email" placeholder="EMAIL_ID"  class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="off">
                                <span class="invalid-feedback" id="email_error" role="alert">Email Already Exits
                                </span>

                                @error('email')
                                    <span class="invalid-feedback" id="email_error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                                 <div class="col-md-12 mt-3">
                                            <div class="row p-0 justify-content-between">
                               
                           <div class="col-sm-4 p-0 lab">
                              <select class="phselect" name="ccode" id="ccode" >
                                @foreach($jsondata as $code)
                                <option value="{{  $code['dial_code'] }}" {{ $code['name'] == "United States" ? 'selected' : ''}}>{{ $code['name'].' ('. $code['dial_code'] . ')' }}</option>
                                 <option data-thumbnail="images/icon-chrome.png" value="{{ $code['dial_code'] }}" <?php if($code['dial_code']) ?>> {{ $code['name'].' ('. $code['dial_code'] . ')' }}</option> 
                                @endforeach
                            </select>
                            </div>
                            <div class="col-sm-8 lab">
                                <input id="mobile" type="text" maxlength="10" minlength="10" class="form-control @error('email') is-invalid @enderror" name="mobile" placeholder="{{ __('Moblie') }}" value="{{ old('mobile') }}" required autocomplete="off" autofocus> 
                                <span class="verify-error"></span>
                                
                                 @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror                                    
                            </div></div>
						

                                </div>
                                
                                
                            <div class="col-md-12 lab mt-3">
                               <input type="file" multiple="true" class="form-control" style="padding: 0px;" name="avatar" id="avatar" />
                                 </div>
                                 <div class="col-md-12">
                                     <div class="row">
                                     <div class="col-md-12 lab mt-3">
                                <input id="password" type="password" placeholder="PASSWORD" class="form-control @error('password') is-invalid @enderror pwd" name="password" required autocomplete="new-password">
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
                            <div class="col-md-12">
                                <div class="row">
                                     <div class="col-md-12 lab mt-3">
                                <input id="password-confirm" type="password" class="form-control" placeholder="Confirm Password" name="password_confirmation" required autocomplete="new-password">
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
    

                            </div>
                                 
                            </div>
                          
                        
                            

                       
                         
                        <div class="form-group row">
                           <!-- <label for="mobile" class="col-md-4 col-sm-offset-1 col-form-label text-md-right">{{ __('Phone Number') }} <span style="color:#4895d1">*</span></label>-->
                            
                            <!--<div class="form-group">
                               
                            <div class="col-sm-2">
                              <select name="ccode" id="ccode" >
                                @foreach($jsondata as $code)
                                <option data-thumbnail="images/icon-chrome.png" value="{{ $code['dial_code'] }}" <?php if($code['dial_code']) { echo "selected='seletected'"; } ?>> {{ $code['name'].' ('. $code['dial_code'] . ')' }}</option>
                                @endforeach
                            </select>
                            </div>
                            <div class="col-sm-4">
                                <input id="mobile" type="text" class="form-control @error('email') is-invalid @enderror" name="mobile" placeholder="{{ __('Enter Mobile Number') }}" value="{{ old('mobile') }}" required autocomplete="off" autofocus> 
                                <span class="verify-error"></span>
                                
                                 @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror                                    
                            </div>
						</div>-->
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
                         <div class="form-group row">
                              <div class="col-md-12">
                                <input id="password-confirm" type="checkbox" name="terms" value="1" required>
								<label for="password-confirm" class="col-form-label text-md-right" style="display: inline-block;">{{ __('Yes') }} ,<a data-toggle="modal" data-target="#terms" style="text-decoration:none;color: #fff;"> {{ __('I Agree to Terms and  Conditions' ) }}</a></label>
                            </div>
                          </div>
                      
                          <div class="d-flex justify-content-center links mb-3">
                     Already have an account? <a href="<?= URL::to('/login')?>" class=" ml-2" style="color: #007bff!important;font-weight: 600;">SIGN IN</a>
                  </div>  
                            <div class="sign-up-buttons col-md-12" align="right">
                                  <button type="button" value="Verify Profile" id="submit" class="btn btn-primary btn-login verify-profile" style="display: none;"> Verify Profile</button>
                                  <button class="btn btn-primary btn-block signup" style="display: block;" type="submit" name="create-account">{{ __('SUBMIT') }}</button>
                                </div>
                                                
                       
						<div class="form-group row">
							<div class="col-md-10 col-sm-offset-1">
                                <!--<div class="sign-up-buttons">
                                  <button type="button" value="Verify Profile" id="submit" class="btn btn-primary btn-login verify-profile" style="display: none;"> Verify Profile</button>
                                  <button class="btn btn-lg btn-primary btn-block signup" style="display: block;" type="submit" name="create-account">{{ __('Sign Up Today') }}</button>
                                </div>-->
							</div>
						</div>
                        
                    </form>
                  </div>
               </div>    
               <div class="mt-3">
                                        
               </div>
            </div>
         </div>
      </div>
   </div>

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
    // alert(($('#email').val()));

// 	var email = $('#email').val();
// 	$.ajax({
//         url:"{{ URL::to('/emailvalidation') }}",
//         method:'GET',
// data: {
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
    $("#submit").click(function(e){
        e.preventDefault();
        var ccode = $("#ccode").val();
        var mobile = $("#mobile").val();       
        var url = '{{ url('sendOtp') }}';        
        if (mobile.length > 5 ){
            $.ajax({
               url:url,
               method:'POST',
               data:{
                      ccode:ccode, 
                      mobile:mobile
                    },
               success:function(response){                   
                   if (response.status == true) {
                        var veri = response.verify;
                       $("#verify_id").val(veri);
                       $("#loginModalLong").modal('show');
                       timer();
                       
                       //$('#loginModalLong').show();
                       
                   } else {
                        $(".verify-error").html(response.message);
                        $(".verify-error").css("color","red");
                   }
               },
             
            });
          } else {
//               alert(response.message);
//                   return false;
                $("#success").html(response.message);
                alert('Length Must be atleast 10');
          }
   });  
       
    $("#checkotp").click(function(e){
        e.preventDefault();
        var otp = $("#otp").val(); 
        var verify_id = $("#verify_id").val();       
        var username = $("#username").val();       
        var avatar = $("#avatar").val();       
        var email = $("#email").val();       
        var ccode = $("#ccode").val();       
        var mobile = $("#mobile").val();       
        var terms = $("#terms").val();       
        var password_confirmation = $("#password_confirmation").val();       
        var password = $("#password").val();       
        var url = '{{ url('verifyOtp') }}'; 
        let timerOn = true;
        
        if (otp.length > 0 ){
            $.ajax({
               url:url,
               method:'POST',
               data:{
                      otp:otp, 
                      verify_id:verify_id
                    },
                   success:function(response){
                       if (response.status == true) {
//                         $('.verify-profile').css('display','none');
//                         $('.signup').css('display','block');
//                         $("#mobile").prop("readonly", true);
//                         $("#verify-error").css("display","none");
//                         $('.modal').modal('hide');
//                         var base_url = $('.base_url').val();
//                         $("#stripe_plan").submit();
//                           
//                           alert();
                           
//                           
//                           $.post(base_url+'/register1', {
//                                 py_id:py_id, plan:plan_data, _token: '<?= csrf_token(); ?>' 
//                               }, 
//                                function(data){
//                                    $('#loader').css('display','block');
//                                    swal("You have done  Payment !");
//
//                                    setTimeout(function() {
//                                    //location.reload();
//                                    window.location.replace(base_url+'/register2');
//
//                                  }, 2000);
//                               });
                      } else {
                        $(".success").html(response.message);
                        $(".success").css("color","red");
                        return false;
                     }
                   
               },
            });
          } else {
                   alert('Length Must be atleast 4');
          }
   });
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


$( "#stripe_plan" ).validate({
    rules: {
            username: {
                required: true,
            },
            password:{
                    required: true,
                    minlength: 8,
                    maxlength: 30,
                    // regx: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])\w{6,}$/,
                    regx: /^(?=.*[A-Z])(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/,

            },
                password_confirmation: {
                required: true,
                minlength: 8,
                maxlength: 30,
                equalTo: "#password"
            },
            mobile: {
                required: true,
                remote: {
                    url: '{{ URL::to('SignupMobile_val') }}',
                    type: "post",
                    data: {
                        _token: "{{csrf_token()}}" ,
                        MobileNo: function() {
                        return $( "#mobile" ).val(); }
                    }
                }
            },
            username: {
                    required: true,
                    remote: {
                        url:"{{ URL::to('/usernamevalidation') }}",
                        type: "get",
                        data: {
                            _token: "{{csrf_token()}}" ,
                            success: function() {
                            return $('#username').val(); }
                        }
                    }
                },
            email: {
                required: true,
                remote: {
                    url:"{{ URL::to('/emailvalidation') }}",
                    type: "get",
                    data: {
                        _token: "{{csrf_token()}}" ,
                        success: function() {
                        return $('#email').val(); }
                    }
                }
            }
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
                    remote: "Email Id already in taken ! Please try another Mobile Number"
                },
                password: {
                        pwcheck: "Password is not strong enough"
                    }   
               
            }
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



@include('footer')

@endsection 

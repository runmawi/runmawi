@extends('layouts.app')

<!doctype html>
<html lang="en-US">
   <head>
      <?php
$uri_path = $_SERVER['REQUEST_URI']; 
$uri_parts = explode('/', $uri_path);
$request_url = end($uri_parts);
$uppercase =  ucfirst($request_url);

$theme_mode = App\SiteTheme::pluck('theme_mode')->first();
$theme = App\SiteTheme::first();


        $translate_checkout = App\SiteTheme::pluck('translate_checkout')->first();

        @$translate_language = App\Setting::pluck('translate_language')->first();

        $website_default_language = App\Setting::pluck('website_default_language')->first() ? App\Setting::pluck('website_default_language')->first() : 'en';


        if(Auth::guest()){
        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
        $userIp = $geoip->getip();
        $UserTranslation = App\UserTranslation::where('ip_address',$userIp)->first();

        if(!empty($UserTranslation)){
            $translate_language = GetWebsiteName().$UserTranslation->translate_language;
        }else{
            $translate_language = GetWebsiteName().@$website_default_language;
        }
        }else if(!Auth::guest()){

        $subuser_id=Session::get('subuser_id');
        if($subuser_id != ''){
            $Subuserranslation = App\UserTranslation::where('multiuser_id',$subuser_id)->first();
            if(!empty($Subuserranslation)){
                $translate_language = GetWebsiteName().$Subuserranslation->translate_language;
            }else{
                $translate_language = GetWebsiteName().@$website_default_language;
            }
        }else if(Auth::user()->id != ''){
            $UserTranslation = App\UserTranslation::where('user_id',Auth::user()->id)->first();
            if(!empty($UserTranslation)){
                $translate_language = GetWebsiteName().$UserTranslation->translate_language;
            }else{
                $translate_language = GetWebsiteName().@$website_default_language;
            }
        }else{
            $translate_language = GetWebsiteName().@$website_default_language;
        }

        }else{
        $translate_language = GetWebsiteName().@$website_default_language;
        }

        \App::setLocale(@$translate_language);


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
     <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
      <!-- Typography CSS -->
      <link rel="stylesheet" href="<?= style_sheet_link(); ?>" />
      <!-- Style -->
      <link rel="stylesheet" href="<?= typography_link(); ?>" />
      <!-- Responsive -->
      <link rel="stylesheet" href="assets/css/responsive.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js">
  </script>
<style>
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
        margin-left: -60px;
        height: 45px !important;
        background: transparent !important;
        color: #fff !important;
    }
    .error {
    color: brown;
    font-family: 'remixicon';
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
    #dob{
        /* color: #fff; */
        background:rgba(11, 11, 11,1);
        color-scheme: dark;
    }

    .otp-input-fields {
            margin: auto;
            max-width: 400px;
            width: auto;
            display: flex;
            justify-content: center;
            gap: 10px;
            padding: 20px;

            input {
                height: 40px;
                width: 40px;
                border-radius: 4px;
                border: 1px solid #2f8f1f;
                text-align: center;
                outline: none;
                font-size: 16px;

                &::-webkit-outer-spin-button,
                &::-webkit-inner-spin-button {
                    -webkit-appearance: none;
                    margin: 0;
                }

                /* Firefox */
                &[type=number] {
                    -moz-appearance: textfield;
                }
            }
        }
        button#profileUpdate:hover{color: #fff;}
</style>

<section style="background:url('<?php echo URL::to('/').'/public/uploads/settings/'.$settings->login_content; ?>') no-repeat scroll 0 0;background-attachment: fixed;background-color:#000;background-size:cover;height:auto;min-height:100%;">
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<?php
    $jsonString = file_get_contents(base_path('assets/country_code.json'));   
    $jsondata = json_decode($jsonString, true);
    
    usort($jsondata, function ($a, $b) {
        return strcmp($a['name'], $b['name']);
    });
  
    $ref = Request::get('ref');
    $coupon = Request::get('coupon');
?>

<div class="container">
      <div class="row justify-content-center align-items-center height-self-center">
         <div class="col-sm-9 col-md-7 col-lg-5 align-self-center">

                            {{-- recaptcha --}}
                    @if (Session::has('message'))
                        <div id="successMessage" class="alert alert-success">{{ Session::get('message') }}</div>
                    @endif
                        

                    @if(count($errors) > 0)
                        @foreach( $errors->all() as $message )
                            <div class="alert alert-danger display-hide" id="successMessage" >
                            <button id="successMessage" class="close" data-close="alert"></button>
                            <span>{{ $message }}</span>
                            </div>
                        @endforeach
                    @endif

            <div class="sign-user_card ">                    
               <div class="sign-in-page-data">
                  <div class="sign-in-from w-100 m-auto">

                      <div align="center">
                                      
                            <?php if($theme_mode == "light" && !empty(@$theme->light_mode_logo)){  ?>
                                <img src="<?= URL::to('public/uploads/settings/'. $theme->light_mode_logo)  ?>" style="margin-bottom:1rem;">  
                            <?php }elseif($theme_mode != "light" && !empty(@$theme->dark_mode_logo)){ ?> 
                                <img src="<?= URL::to('public/uploads/settings/'. $theme->dark_mode_logo) ?>" style="margin-bottom:1rem;">  
                            <?php }else { ?> 
                                <img alt="apps-logo" class="apps"  src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo ; ?>"  style="margin-bottom:1rem;"></div></div>
                            <?php } ?>

                          <h3 class="mb-3 text-center">{{ __('Sign Up') }}</h3>
                      </div>
                      <form onsubmit="return ValidationEvent()" action="<?php if (isset($ref) ) { echo URL::to('/').'/register1?ref='.$ref.'&coupon='.$coupon; } else { echo URL::to('/').'/register1'; } ?>" method="POST" id="stripe_plan" class="stripe_plan" name="member_signup" enctype="multipart/form-data">
                        @csrf
                            <div class="form-group">
                            
                                @if (!empty($SignupMenu) && $SignupMenu->username == 1)
                                    <div class="col-md-12">
                                        <input id="username" type="text"  class="form-control alphaonly  @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" placeholder="{{ __('Username') }}" required autocomplete="off" autofocus>

                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    @endif
                                
                                
                                @if(!empty($SignupMenu) && $SignupMenu->email == 1)
                                    <div class="col-md-12">
                                    <input id="email" type="email" placeholder="{{ __('Email Address') }}"  class="form-control email @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="off">
                                    <span class="invalid-feedback" id="email_error_Valid" role="alert">{{ __('Please enter a valid email address') }}
                                    <span class="invalid-feedback" id="email_error" role="alert">{{ __('Email Already Exits') }}
                                    </span>

                                    @error('email')
                                        <span class="invalid-feedback" id="email_error" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                @endif
                            
                                        {{-- Signup Menu - Mobile --}}

                                @if(!empty($SignupMenu) && $SignupMenu->mobile == 1)
                                    <div class="col-md-12">
                                        <div class="row">
                            
                                            <div class="col-md-5 col-sm-12">
                                                <select class="form-control mobile_validation" name="ccode" id="ccode" >
                                                    <option>{{ __('Select Country') }}</option>
                                                    @foreach($jsondata as $code)
                                                        <option value="{{  $code['dial_code'] }}" {{ $code['name'] == "India" ? 'selected' : ''}}>{{ $code['name'].' ('. $code['dial_code'] . ')' }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-7 col-sm-8">
                                                <input id="mobile" type="text" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" required pattern="\d*" maxlength="15" inputmode="numeric" minlength="10" class="form-control mobile_validation" name="mobile" placeholder="{{ __('Enter Mobile Number') }}" value="{{ old('mobile') }}" required autocomplete="off" autofocus> 
                                                <span id="error" style="color: Red; display: none">* {{ __('Enter Only Numbers') }}</span>
                                                @error('mobile')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror                               
                                            </div>
                                            </div>

                                            @if (@$AdminOTPCredentials->status == 1)
                                                
                                                {{-- Mobile Exist Status --}}

                                                <div class="" style="text-align: right;">
                                                    <span style="color: var(--iq-white); font-size: 14px;" class="mob_exist_status"></span>
                                                </div>

                                                <div class="mt-2 d-flex justify-content-end links">
                                                    <button type="button" class="btn btn-hover ab" id="send_otp_button" data-toggle="collapse" data-target="#demo" style="line-height:20px" disabled>Send OTP</button>
                                                </div>                        

                                                <span id="demo" class="collapse">

                                                    <div class="otp-div">
                                                        <div class="otp-input-fields row">
                                                            <input type="number" class="otp__digit otp__field__1" placeholder="-"  name="otp_1">
                                                            <input type="number" class="otp__digit otp__field__2"  placeholder="-" name="otp_2">
                                                            <input type="number" class="otp__digit otp__field__3"  placeholder="-" name="otp_3">
                                                            <input type="number" class="otp__digit otp__field__4"  placeholder="-" name="otp_4">
                                                            <p class="otp_send_message m-0 p-0" > </p>
                                                        </div>
                    
                                                        <div class=" verify-div text-center p-0">
                                                            <button type="submit" class="btn btn-hover ab" id="verify-button" style="line-height:20px" disabled >{{ __('Verify OTP') }}</button>
                                                            <a href="#" id="resend_otp_button" class="text-primary ml-2">{{ __('Resend OTP') }}</a>
                                                        </div>
                                                    </div>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            
                                @if(!empty($SignupMenu) && $SignupMenu->gender == 1)
                                    <div class="col-md-12" style="position:relative; margin-top:10px;">
                                        <select name="gender" class="form-control">
                                            <option value="" disabled selected>{{ __('Select Gender') }}</option>
                                            <option value="male">{{ __('Male') }}</option>
                                            <option value="female">{{ __('Female') }}</option>
                                            <option value="other">{{ __('Other') }}</option>
                                        </select>
                                    </div>
                                @endif
                                @if(!empty($SignupMenu) && $SignupMenu->avatar == 1)
                            <div class="col-md-12" style="postion:relative;">
                                <input type="file" accept="image/*" multiple="true" class="form-control" style="padding: 0px;" name="avatar" id="avatar" />
                                <label id="fileLabel">{{ __('Choose Profile Image') }}</label>
                                 </div>
                                 @endif
                           
                                 @if(!empty($SignupMenu) && $SignupMenu->dob == 1)
                                    <div class="col-md-12" style="postion:relative;">
                                        <input type="text" id="datepicker" name="dob"  class="datepicker form-control"  placeholder="{{ __('Choose DOB') }}"  >
                                    </div>
                                 @endif

                                @if(!empty($SignupMenu) && $SignupMenu->password == 1)
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror pwd" name="password" autocomplete="new-password" onkeyup="checkPass(); return false;">
                                                <p id="password-error" style="color: red;font-size:13px;"></p>
                                            </div>
                                            <div>
                                                <span class="input-group-btn" id="eyeSlash">
                                                    <button class="btn btn-default reveal" onclick="visibility1()" type="button"><i class="fa fa-eye-slash" aria-hidden="true"></i></button>
                                                </span>
                                                <span class="input-group-btn" id="eyeShow" style="display: none;">
                                                    <button class="btn btn-default reveal" onclick="visibility1()" type="button"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            
                            
                                @if(!empty($SignupMenu) && $SignupMenu->password_confirm == 1)
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input id="password-confirm" type="password" class="form-control" placeholder="Confirm Password" name="password_confirmation" required autocomplete="new-password" onkeyup="checkPass(); return false;">
                                                <p id="confirm-password-error" style="color: red;font-size:13px;"></p>
                                            </div>
                                            <div>
                                                <span class="input-group-btn" id="eyeSlash1">
                                                    <button class="btn btn-default reveal" onclick="visibility2()" type="button"><i class="fa fa-eye-slash" aria-hidden="true"></i></button>
                                                </span>
                                                <span class="input-group-btn" id="eyeShow1" style="display: none;">
                                                    <button class="btn btn-default reveal" onclick="visibility2()" type="button"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>           
                                @endif
                            
                                @if(!empty($SignupMenu) && $SignupMenu->country == 1)
                                <div class="col-md-12" style="postion:relative;">
                                    <select class="phselect form-control" name="country" id="country" >
                                        <option>{{ __('Select Country') }}</option>
                                            @foreach($AllCountry as $code)
                                            <option value="{{  $code['name'] }}">{{ $code['name'] }}</option>
                                            @endforeach
                                    </select>  
                                </div>
                                 @endif
                            
                                 @if (!empty($SignupMenu) && $SignupMenu->state == 1)
                                    <div class="col-md-12">
                                        <!-- <input id="state" type="text"  class="form-control alphaonly  @error('state') is-invalid @enderror" name="state" value="{{ old('state') }}" placeholder="state" required autocomplete="off" autofocus> -->
                                        <select class="phselect form-control" name="state" id="state-dropdown" >
                                        <option>{{ __('Select State') }}</option>
                                            <!-- @foreach($State as $code)
                                            <option value="{{  $code['name'] }}">{{ $code['name'] }}</option>
                                            @endforeach -->
                                    </select>  
                                        @error('state')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    @endif

                                    
                                @if (!empty($SignupMenu) && $SignupMenu->city == 1)
                                    <div class="col-md-12">
                                        <!-- <input id="city" type="text"  class="form-control alphaonly  @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" placeholder="city" required autocomplete="off" autofocus> -->
                                        <select class="phselect form-control" name="city" id="city-dropdown" >
                                        <option>{{ __('Select City') }}</option>
                                            <!-- @foreach($State as $code)
                                            <option value="{{  $code['name'] }}">{{ $code['name'] }}</option>
                                            @endforeach -->
                                    </select>  
                                        @error('city')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    @endif

                                    
                                @if(!empty($SignupMenu) && $SignupMenu->support_username == 1)
                                <div class="col-md-12" style="postion:relative;">
                                    <select class="phselect form-control" name="support_username" id="support_username" >
                                        <option>{{ __('Select Support Musician') }}</option>
                                            @foreach($Artists as $Artist)
                                            <option value="{{  $Artist['artist_name'] }}">{{ $Artist['artist_name'] }}</option>
                                            @endforeach
                                    </select>  
                                </div>
                                 @endif
                            
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

							<div class="col-md-12 d-flex" id="mob">
                                <input id="" type="checkbox" checked name="terms" value="1" required>
								<label for="password-confirm" class="col-form-label text-md-right ml-2" style="display: inline-block;text-decoration: underline;
                                cursor: pointer;">{{ __('Yes') }} ,<a data-toggle="modal" data-target="#terms" style="text-decoration:none;color: #fff;"> {{ __('I Agree to Terms and  Conditions' ) }}</a></label>
                            </div>

                            <div class="sign-up-buttons col-md-12 ">
                                <button type="button" value="Verify Profile" id="submit" class="btn btn-primary btn-login verify-profile" style="display: none;"> {{ __('Verify Profile') }}</button>

                                @if (@$AdminOTPCredentials->status == 1)
                                    <button type="submit" id="profileUpdate"  class="btn btn-hover btn-primary btn-block signup signup_submit_otp_button" style="display: block;" name="create-account" disabled >{{ __('Sign Up Today') }}</button>
                                @else
                                    <button id = "profileUpdate"  class="btn btn-hover btn-primary btn-block signup" style="display: block;" type="submit" name="create-account">{{ __('Sign Up Today') }}</button>
                                @endif

                                </div>
                            </div>
                        
                        
                    </form>
                       <div class="mt-3">
                  <div class="d-flex justify-content-center links">
                  {{ __('Already have an account?') }} <a href="<?= URL::to('/login')?>" class="text-primary ml-2">{{ __('Sign In') }}</a>
                  </div>                        
               </div>
                  </div>
                  
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
            <h4 class="modal-title" style="color: white;"><?php echo __('Terms and Conditions');?></h4>
            <button type="button" class="close" data-dismiss="modal" style="color:#fff; opacity:1;">&times;</button>
        </div>
        <div class="modal-body" style='color: white;' >
            <?php
                $terms_page = App\Page::where('slug','terms-and-conditions')->pluck('body');
             ?>
            <p ><?php echo $terms_page[0];?></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-hover" data-dismiss="modal"><?php echo __('Close');?></button>
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
						 	<p> {{ __('OTP will Expire in') }} <span id="countdowntimer"></span>
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
  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include jQuery UI library -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script defer src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script defer src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"async defer></script>                

{{-- password length validation --}}
<script>
    function checkPass() {
        var pass1 = document.getElementById('password');
        var pass2 = document.getElementById('password-confirm');
        var passwordError = document.getElementById('password-error');
        var confirmPasswordError = document.getElementById('confirm-password-error');
        var goodColor = "#66cc66";
        var badColor = "#ff6666";

        // Regular expression to test the password strength
        var strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})");

        // Test the password against the regex
        if (strongRegex.test(pass1.value)) {
            pass1.style.backgroundColor = goodColor;
            passwordError.style.color = goodColor;
            passwordError.innerHTML = "Strong password";
            $('#password-confirm').prop('disabled', false);
            $('#profileUpdate').prop('disabled', false);
        } else {
            pass1.style.backgroundColor = badColor;
            passwordError.style.color = badColor;
            $('#password-confirm').prop('disabled', true);
            $('#profileUpdate').prop('disabled', true);
            passwordError.innerHTML = "Password must be at least 8 characters and include 1 uppercase letter, 1 number, and 1 special character.";
        }

        // Check if the password and confirm password match only if confirm password is not empty
        if (pass2.value !== "") {
            if (pass1.value == pass2.value) {
                pass2.style.backgroundColor = goodColor;
                confirmPasswordError.style.color = goodColor;
                confirmPasswordError.innerHTML = "Password created successfully";
            } else {
                pass2.style.backgroundColor = badColor;
                confirmPasswordError.style.color = badColor;
                confirmPasswordError.innerHTML = "Passwords did not match";
            }
        } else {
            // Clear the message if confirm password is empty
            confirmPasswordError.innerHTML = "";
        }
    }
</script>

<script>
    $(document).ready(function(){
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 5000);
        
    });

    var onloadCallback = function(){}

    $('form[id="stripe_plan"]').validate({
        ignore: [],
        rules: {
            username: 'required',
            email: {
                required: true,
                email: true,
                normalizer: function(value) {
                    return $.trim(value);
                }
            },
        },
        messages: {
            username: 'This field is required',
            email: {
                required: 'Email address is required',
                // email: 'Please enter a valid email address',
            },
        },
        submitHandler: function(form) {
            form.submit();
        }
    });

    
var specialKeys = new Array();
        specialKeys.push(8); //Backspace

    function IsNumeric(e) {
    var keyCode = e.which ? e.which : e.keyCode;
    var inputField = e.target || e.srcElement;
    var inputValue = inputField.value;
    var digitCount = inputValue.replace(/[^0-9]/g, '').length;

    var ret = (keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) !== -1;

    if (digitCount >= 12) {
        alert('Please enter atleast 12 characters');
        ret = ret || specialKeys.indexOf(keyCode) !== -1;
        document.getElementById("error").style.display = ret ? "none" : "inline";
        return false;
    }

    document.getElementById("error").style.display = ret ? "none" : "inline";
    return ret;
}


    $('#email_error').hide();
    $('#email_error_Valid').hide();
    $("#profileUpdate").click(function(){

        var email = $('#email').val();
            $.ajax({
                url:"{{ URL::to('/emailvalidation') }}",
                method:'GET',
                data: {
                        _token: '{{ csrf_token() }}',
                        email: $('#email').val()

                },        success: function(value){
                    // console.log(value);
                    if(value == "false"){
                        $('#email_error').show();
                        return false; // Prevent form submission

                    }else{
                    $('#email_error').hide();
                    }
                }
            });

            // mobile
    });

</script>

<script>
    jQuery.noConflict();
    (function($) {
        $(document).ready(function() {
            $("#datepicker").datepicker();
        });
    })(jQuery);
</script>  

<script>

$(document).ready(function() {

$('#country').on('change', function() {
    
    var country_id = this.value;
    // alert(country_id);
    $("#state-dropdown").html('');
        $.ajax({
        url:"{{url::to('/getState')}}",
        type: "POST",
        data: {
        country_id: country_id,
        _token: '{{csrf_token()}}' 
        },
        dataType : 'json',
        success: function(result){
        $('#state-dropdown').html('<option value="">{{ __('Select State') }}</option>'); 
        $.each(result.states,function(key,value){
        $("#state-dropdown").append('<option value="'+value.name+'">'+value.name+'</option>');
        });
        $('#city-dropdown').html('<option value="">{{ __('Select State First') }}</option>'); 
        }
    });

}); 



        $('#state-dropdown').on('change', function() {
            var state_id = this.value;
            // alert(state_id);
            $("#city-dropdown").html('');
            $.ajax({
            url:"{{url::to('/getCity')}}",
            type: "POST",
            data: {
            state_id: state_id,
            _token: '{{csrf_token()}}' 
            },
            dataType : 'json',
            success: function(result){
            $('#city-dropdown').html('<option value="">Select City</option>'); 
            $.each(result.cities,function(key,value){
            $("#city-dropdown").append('<option value="'+value.name+'">'+value.name+'</option>');
            });
            }
            });
        });
});



    $(document).ready(function(){
         $('#error_password').hide();

    });

    function ValidationEvent(form) {

            // var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
            // var email = $(".email").val();
            // if(!filter.test(email)){
            //     $('#email_error_Valid').show(500);
            //     setTimeout(function() {
            //         $('#email_error_Valid').hide(500); // Hide the element with a slide-up animation
            //     }, 2000);
            //     return false;
            // }
            // $('#email_error_Valid').hide();

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

 $('#email').change(function(){

 	var email = $('#email').val();
 	$.ajax({
         url:"{{ URL::to('/emailvalidation') }}",
         method:'GET',
         data: {
                _token: '{{ csrf_token() }}',
                email: $('#email').val()

          },        success: function(value){
 			// console.log(value);
             if(value == "false"){
             $('#email_error').show();
             }else{
             $('#email_error').hide();
             }
         }
     });
 })

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

// $(document).ready(function() {
//   $(".js-example-basic-single").select2({
//     templateResult: function(item) {
//       return format(item, false);
//     }
//   });

// });




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
// //                                    globalThis.location.replace(base_url+'/register2');
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
    // btn.onclick = function() {
    //   modal.style.display = "block";
    // }

    // When the user clicks on <span> (x), close the modal

    span.onclick = function() {
      modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    globalThis.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }
    
    
    $(document).ready(function() {
        
    });
    
        // $('#loginModalLong').modal({backdrop: 'static', keyboard: false}) 
        
    </script>

{{-- Validation --}}
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

    <script>

    var SignupMenu = '<?= $SignupMenu ?>'; 
    // console.log(SignupMenu);
    if(SignupMenu && SignupMenu ==""){
        var username = 0;
        var password = 0;
        var password_confirmation = 0;
        var mobile = 0;
        var email = 0;
        var username = 0;
        var country = 0;
        var state = 0;
        var city = 0;
        var support_username = 0;

    }else{
        var username = '<?= $SignupMenu->username ?>';
        var password = '<?= $SignupMenu->password ?>';
        var password_confirmation = '<?= $SignupMenu->password_confirmation ?>';
        var mobile = '<?= $SignupMenu->mobile ?>';
        var email = '<?= $SignupMenu->email ?>';
        var username = '<?= $SignupMenu->username ?>';
        var country = '<?= $SignupMenu->country ?>';
        var state = '<?= $SignupMenu->state ?>';
        var city = '<?= $SignupMenu->city ?>';
        var support_username = '<?= $SignupMenu->support_username ?>';
    }
    // alert(password);
//     $( "#stripe_plan" ).validate({
        
//         rules: {
//                 username: {
//                     required : function(element) {
//                         if(username == 0) { 
//                             return true;
//                         } else {
//                             return false;
//                         }
//                     }
//                     // required: true,
//                 },
//                 password:{

//                     // required: true,
//                     minlength: 8,
//                     maxlength: 30,
//                     // regx: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])\w{6,}$/,
//                     regx: /^(?=.*[A-Z])(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/,
//                     required : function(element) {
//                         if(password == 0) {
//                             return true;
//                         } else {
//                             return false;
//                         }
//                     }

//             },
//             //     password_confirmation: {
//             //         required : function(element) {
//             //             if(password_confirmation == 0) {
//             //                 return true;
//             //             } else {
//             //                 return false;
//             //             }
//             //         }
//             //     // required: true,
//             //     minlength: 8,
//             //     maxlength: 30,
//             //     equalTo: "#password"
//             // },
//                 mobile: {
//                     // required: true,
//                     remote: {
//                         url: '{{ URL::to('SignupMobile_val') }}',
//                         type: "post",
//                         data: {
//                             _token: "{{csrf_token()}}" ,
//                             MobileNo: function() {
//                             return $( "#mobile" ).val(); }
//                         }
//                     },
//                     required : function(element) {
//                         if(mobile == 0) {
//                             return true;
//                         } else {
//                             return false;
//                         }
//                     }
//                 },
//                 email: {

//                     // required: true,
//                     remote: {
//                         url:"{{ URL::to('/emailvalidation') }}",
//                         type: "get",
//                         data: {
//                             _token: "{{csrf_token()}}" ,
//                             success: function() {
//                             return $('#email').val(); }
//                         }
//                     },
//                     required : function(element) {
//                         if(email == 0) {
//                             return true;
//                         } else {
//                             return false;
//                         }
//                     }
//                 },
//                 username: {

//                     // required: true,
//                     remote: {
//                         url:"{{ URL::to('/usernamevalidation') }}",
//                         type: "get",
//                         data: {
//                             _token: "{{csrf_token()}}" ,
//                             success: function() {
//                             return $('#username').val(); }
//                         }
//                     },
//                     required : function(element) {
//                         if(username == 0) {
//                             return true;
//                         } else {
//                             return false;
//                         }
//                     }
//                 },
//             },

//                 messages: {
//                     mobile: {
//                         required: "Please Enter the Mobile Number",
//                         remote: "Mobile Number already in taken ! Please try another Mobile Number"
//                     },
//                     username: {
//                          required: "Please Enter the Name",
//                          remote: "Name already in taken ! Please try another Username"
//                     },
//                     email: {
//                         required: "Please Enter the Email Id",
//                         remote: "Email Id already in taken ! Please try another Email ID"
//                     },
//                     password: {
//                         pwcheck: "Password is not strong enough"
//                     }   
                   
//                 }
//     });

//     $.validator.addMethod("regx", function(value, element, regexpr) {          
//     return regexpr.test(value);
// }, "Please enter a valid pasword.");
    </script>

    <script>

        var otp_inputs = document.querySelectorAll(".otp__digit")
        var mykey = "0123456789".split("")
        otp_inputs.forEach((_) => {
            _.addEventListener("keyup", handle_next_input)
        })

        function handle_next_input(event) {
            let current = event.target
            let index = parseInt(current.classList[1].split("__")[2])
            current.value = event.key

            if (event.keyCode == 8 && index > 1) {
                current.previousElementSibling.focus()
            }
            if (index < 4 && mykey.indexOf("" + event.key + "") != -1) {
                var next = current.nextElementSibling;
                next.focus()
            }
            var _finalKey = ""
            for (let {
                    value
                }
                of otp_inputs) {
                _finalKey += value
            }

            if (_finalKey.length == 4) {
                document.getElementById("verify-button").removeAttribute("disabled");
            } else {
                document.getElementById("verify-button").setAttribute("disabled", "disabled");
            }
        }

        $(document).ready(function(){

            $('.signup_submit_otp_button').prop('disabled', true);

            $(".mobile_validation").on("input", function() {

                let mobileNumber = $('#mobile').val();
                let mobileNumber_count = mobileNumber.length;
                let ccode = $('#ccode').val();

                $('.mob_exist_status').text("");

                if( mobileNumber !== "" && mobileNumber_count > 9 ){

                    $.ajax({
                        url: "{{ route('auth.otp.signup-check-mobile-exist') }}",
                        type: "get",
                        data: {
                            mobile: mobileNumber,
                            ccode: ccode
                        },
                        dataType: "json",

                        success: function(response) {
                            if (response.exists) {
                                document.getElementById("send_otp_button").removeAttribute("disabled");
                                $('.mob_exist_status').text("Valid Mobile number, verify Number via OTP to register!").css('color', 'green');;

                            } else {
                                document.getElementById("send_otp_button").setAttribute("disabled", "disabled");
                                $('.mob_exist_status').text("Mobile Number Already exists!").css('color', 'red');
                            }
                        },
                        error: function(error) {
                            console.error('AJAX error:', error);
                            $('.mob_exist_status').text("Mobile Number not exists!").css('color', 'red');
                        }
                    });
                }
            });

            $('#send_otp_button,#resend_otp_button').click(function(){ 

                $('#mobile').attr('readonly', true);
                $('#ccode').attr('disabled', true);

                $('.otp_send_message').text("");

                let mobileNumber = $('#mobile').val();
                let ccode = $('#ccode').val();
                $('.mob_exist_status').text("");

                $.ajax({
                    url: "{{ route('auth.otp.signup-sending-otp') }}",
                    type: "get",
                    data: {
                            mobile: mobileNumber,
                            ccode: ccode
                        },
                    dataType: "json",

                    success: function(response) {
                        if (response.exists) {
                            $("#send_otp_button").hide();
                            $('.mob_exist_status').text( response.message_note ).css('color', 'green');
                            $('.otp-div').show();
                        } else {
                            $('.mob_exist_status').text( response.message_note ).css('color', 'red');
                        }
                    },
                    error: function(error) {
                        console.error('AJAX error:', error);
                    }
                });
            });

            $("#verify-button").click(function(e){
                e.preventDefault();

                let otp = [
                    $('.otp__field__1').val(),
                    $('.otp__field__2').val(),
                    $('.otp__field__3').val(),
                    $('.otp__field__4').val()
                ].join('');

                let mobileNumber = $('#mobile').val();
                let ccode = $('#ccode').val();

                $('.otp_send_message,.mob_exist_status').text("");

                $.ajax({
                    url: "{{ route('auth.otp.signup_otp_verification') }}",
                    type: "GET",
                    data: {
                        mobileNumber: mobileNumber,
                        ccode:ccode,
                        otp: otp,
                    },
                    dataType: "JSON",
                    
                    success: function(response) {
                        if (response.status === true) {
                            $('.otp_send_message').text(response.message_note).css('color', 'green');
                            $('#verify-button').prop('disabled', true);
                            $('.verify-div').hide();
                            $('.signup_submit_otp_button').prop('disabled', false);
                        } else if (response.status === false) {
                            $('.otp__digit').val("");
                            $('.otp_send_message').text(response.message_note).css('color', 'red');
                            $('#verify-button').prop('disabled', false);
                        }
                    },
                    error: function() {
                        $('.otp_send_message').text("An error occurred. Please try again.").css('color', 'red');
                        $('#verify-button').prop('disabled', false);
                    }
                });
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
      <!-- <script src="assets/js/select2.min.js"></script> -->
      <!-- Magnific Popup-->
      <script src="assets/js/jquery.magnific-popup.min.js"></script>
      <!-- Slick Animation-->
      <script src="assets/js/slick-animation.min.js"></script>
      <!-- Custom JS-->
      <script src="assets/js/custom.js"></script>
       <script src="<?= URL::to('/'). '/assets/js/jquery.lazy.js';?>"></script>
      <script src="<?= URL::to('/'). '/assets/js/jquery.lazy.min.js';?>"></script>



@endsection 

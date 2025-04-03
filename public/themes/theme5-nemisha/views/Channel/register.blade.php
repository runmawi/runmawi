@extends('layouts.app')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
  <?php $jsonString = file_get_contents(base_path('assets/country_code.json'));   

    $jsondata = json_decode($jsonString, true); ?>
<link rel="stylesheet" href="<?php echo URL::to('public/themes/theme5-nemisha/assets/css/bootstrap.min.css')?>" rel="stylesheet">
      <!-- Typography CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link href="<?php echo URL::to('public/themes/theme5-nemisha/assets/css/typography.css') ?>" rel="stylesheet">
      <!-- Style -->
      <link href="<?php echo URL::to('public/themes/theme5-nemisha/assets/css/style.css') ?>" rel="stylesheet">
      <link href="<?php echo URL::to('public/themes/theme5-nemisha/assets/css/responsive.css') ?>" rel="stylesheet">
                  <link href="<?php echo URL::to('public/themes/theme5-nemisha/assets/fonts/font.css') ?>" rel="stylesheet">
<style>
    body{
        background-color: #000;
    }
    .py-4{
        padding: 0!important;
    }
</style>
<div class="container">
      <div class="row justify-content-center align-items-center height-self-center">
         <div class="col-sm-9 col-md-7 col-lg-5 align-self-center">
            <div class="sign-user_card ">                    
               <div class="sign-in-page-data">
                  <div class="sign-in-from w-100 m-auto">
                      <div align="center">
                             <img class="mb-2" src="<?php echo URL::to('/assets/img/co-creataz-white.svg'); ?>" width=75 height=75 alt="<?php echo $settings->website_name; ?>" />     <h3 class="mb-3 text-center">Sign Up and Content Partner</h3>
                      </div>
                      <div class="clear"></div>
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
                <div>
                      <form action="{{ URL::to('channel/store') }}" method="POST" id="stripe_plan" class="stripe_plan" name="member_signup" enctype="multipart/form-data">
                        @csrf
                        <div id="step-1">
                            <div class="form-group">

                                @if(!empty(@$ChannelSignupMenu) && @$ChannelSignupMenu->username)
                                <div class="col-md-12">
                                    <input id="channel_name" type="text"  class="form-control alphaonly  @error('channel_name') is-invalid @enderror" name="channel_name" value="{{ old('name') }}" placeholder="Channel Name" required autocomplete="off" autofocus>

                                    @error('channel_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                @endif

                                @if(!empty(@$ChannelSignupMenu) && @$ChannelSignupMenu->email)
                                <div class="col-md-12">
                                <input id="email_id" type="email" placeholder="Email Address"  class="form-control @error('email_id') is-invalid @enderror" name="email_id" value="{{ old('email_id') }}" required autocomplete="off">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            @endif
                            @if(!empty(@$ChannelSignupMenu) && @$ChannelSignupMenu->mobile)
                                 <div class="col-md-12">
                                            <div class="row">
                               
                            <div class="col-sm-4">
                              <select class="phselect" name="ccode" id="ccode" >
                              <option>Select Country</option>
                                @foreach($jsondata as $code)
                                    <option data-thumbnail="images/icon-chrome.png" value="{{ $code['dial_code'] }}" @if($code['name'] == 'South Africa'){{ 'selected' }}@endif > {{ $code['name'].' ('. $code['dial_code'] . ')' }}</option>
                                @endforeach
                            </select>
                            </div>
                            <div class="col-sm-8">
                                <input id="mobile_number" type="text" maxlength="10" minlength="10" class="form-control @error('email') is-invalid @enderror" name="mobile_number" placeholder="{{ __('Enter Mobile Number') }}" value="{{ old('mobile_number') }}" required autocomplete="off" autofocus> 
                                <span class="verify-error"></span>
                                
                                 @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror                                    
                            </div></div>
						

                                </div>
                            @endif
                            @if(!empty(@$ChannelSignupMenu) && @$ChannelSignupMenu->image)
                            <div class="col-md-12">
                                <label for="" style="color: white;">Channel Banner :</label>
                                <input type="file" multiple="true" class="form-control" style="padding: 0px;"  name="image" id="image"/>
                            </div>
                            @endif

                            @if(!empty(@$ChannelSignupMenu) && @$ChannelSignupMenu->thumbnail_image == 1)
                            <div class="col-md-12">
                                <label for="" style="color: white;">Channel Thumbnail</label>
                                <input type="file" multiple="true" class="form-control" style="padding: 0px;"  name="thumbnail" id="thumbnail"/>
                            </div>
                            @endif

                        
                            @if(!empty(@$ChannelSignupMenu) && @$ChannelSignupMenu->upload_video)
                            <div class="col-md-12">
                                <label for="" style="color: white;">Channel Short Video </label>
                                <input type="file" multiple="true" class="form-control" style="padding: 0px;" accept="video/mp4,video/x-m4v,video/*" name="intro_video" id="intro_video"/>
                            </div>
                            @endif
                            <div class="col-md-12">
                                <button class="btn btn-block nextBtn p-2" style="display: block; font-size:15px; background: #ed1c24; color:white;" type="button"
                                    >{{ __('Next') }}</button>
                            </div>
                        </div>
                        </div>
                        <div id="step-2" style="display:none;">
                            <div class="form-group">

                                @if (!empty(@$ChannelSignupMenu) && @$ChannelSignupMenu->bank_details == 1)
                                        <div class="col-md-12">
                                        <label for="" style="color: white;">Bank Details :</label>
                                            <input id="bank_name" type="text" style="font-size: 15px;" class="form-control @error('bank_name') is-invalid @enderror" name="bank_name" value="{{ old('bank_name') }}" placeholder="Bank Name" autocomplete="off">
                                        </div>
                        
                                        <div class="col-md-12">
                                            <input id="branch_name" type="text" style="font-size: 15px;" class="form-control @error('branch_name') is-invalid @enderror" name="branch_name" value="{{ old('branch_name') }}" placeholder="Branch Name" autocomplete="off">
                                        </div>
                        
                                        <div class="col-md-12">
                                            <input id="account_number" type="text" style="font-size: 15px;" class="form-control @error('account_number') is-invalid @enderror" name="account_number" value="{{ old('account_number') }}" placeholder="Account Number" autocomplete="off">
                                        </div>
                                @endif

                                @if (!empty(@$ChannelSignupMenu) && @$ChannelSignupMenu->socialmedia_details == 1)
                                <div class="col-md-12">
                                <label for="" style="color: white;">Social Media :</label>
                                    <input id="facebook" type="text" style="font-size: 15px;" class="form-control @error('facebook') is-invalid @enderror" name="facebook" value="{{ old('facebook') }}" placeholder="Facebook" autocomplete="off">
                                </div>
                                <div class="col-md-12">
                                    <input id="instagram" type="text" style="font-size: 15px;" class="form-control @error('instagram') is-invalid @enderror" name="instagram" value="{{ old('instagram') }}" placeholder="Instagram" autocomplete="off">
                                </div>
                                @endif

                                @if(!empty(@$ChannelSignupMenu) && @$ChannelSignupMenu->password)

                                 <div class="col-md-12">
                                     <div class="row">
                                     <div class="col-md-12">
                                <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror pwd" name="password" required autocomplete="new-password">
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
                            @if(!empty(@$ChannelSignupMenu) && @$ChannelSignupMenu->password_confirm)
                            <div class="col-md-12">
                                <div class="row">
                                     <div class="col-md-12">
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
    
                                <span style="color: var(--iq-white);font-size: 14px;font-style: italic;">(Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.)</span>
                            </div>
                            @endif
                                 
                            </div>

                            <div class="form-group" >
							
                                <div class="col-md-12">
                                    <input id="password-confirm" type="checkbox" name="terms" value="1" required>
                                    <label for="password-confirm" class="col-form-label text-md-right" style="display: inline-block;">{{ __('Yes') }} ,<a data-toggle="modal" data-target="#terms" style="text-decoration:none;color: #fff;"> {{ __('I Agree to Terms and  Conditions' ) }}</a></label>
                                </div>
                                <div class="col-md-12">
                                    <button class="btn btn-block prevBtn p-2" 
                                        style="display: block; font-size:15px; background:transparent; border:white solid 1px; color:white; margin: 10px 0px 10px 0px;" 
                                        type="button" 
                                        onmouseover="this.style.background=' #ed1c24'" 
                                        onmouseout="this.style.background='transparent'">
                                        {{ __('Previous') }}
                                    </button>
                                </div>
                                <div class="sign-up-buttons col-md-12" align="right">
                                      <button type="button" value="Verify Profile" id="submit" class="btn btn-primary btn-login verify-profile" style="display: none;"> Verify Profile</button>
                                      <button class="btn signup w-100 text-white" style="display: block;" type="submit" name="create-account">{{ __('Sign Up Today') }}</button>
                                    </div>
                            </div>
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
               </div>    
               <div class="mt-3">
                  <div class="d-flex justify-content-center links">
                     Already have an account? <a href="<?= URL::to('/channel/login')?>" class="text-primary ml-2">Sign In</a>
                  </div>                        
               </div>
            </div>
         </div>
      </div>
   </div>

@php
    include(public_path('themes/theme5-nemisha/views/footer.blade.php'));
@endphp

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
    .sign-in-page-data h3{
    font-size: 35px!important;
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
   .reveal {
    margin-left: -57px;
    height: 45px !important;
    background: #ed1c24 !important;
    color: #fff !important;
}
    .modal-content {
        background-color: #000000;
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                    <script src="jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function(){
        // $('#message').fadeOut(120);
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);
    })
</script>
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
    document.addEventListener('DOMContentLoaded', function () {
        var currentStep = 1;
        var totalSteps = 2;

        // Next button functionality
        document.querySelector('.nextBtn').addEventListener('click', function () {
            if (currentStep < totalSteps) {
                document.querySelector('#step-' + currentStep).style.display = 'none';
                currentStep++;
                document.querySelector('#step-' + currentStep).style.display = 'block';
            }
        });

        // Previous button functionality
        document.querySelector('.prevBtn').addEventListener('click', function () {
            if (currentStep > 1) {
                document.querySelector('#step-' + currentStep).style.display = 'none';
                currentStep--;
                document.querySelector('#step-' + currentStep).style.display = 'block';
            }
        });
    });
</script>
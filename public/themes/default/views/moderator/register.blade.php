
@extends('layouts.app')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
  <?php $jsonString = file_get_contents(base_path('assets/country_code.json'));   

    $jsondata = json_decode($jsonString, true); ?>
@extends('moderator.header')

<div class="container">
      <div class="row justify-content-center align-items-center height-self-center">
         <div class="col-sm-9 col-md-7 col-lg-5 align-self-center">
            <div class="sign-user_card ">                    
               <div class="sign-in-page-data">
                  <div class="sign-in-from w-100 m-auto">
                      <div align="center">
                          <img src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo ; ?>" style="margin-bottom:1rem;">       <h3 class="mb-3 text-center">CPP Sign Up</h3>
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
                      <form action="{{ URL::to('cpp/moderatoruser/store') }}" method="POST" id="stripe_plan" class="stripe_plan" name="member_signup" enctype="multipart/form-data">
                        @csrf
                            <div class="form-group">

                                <div class="col-md-12">
                                    <input id="username" type="text"  class="form-control alphaonly  @error('name') is-invalid @enderror" name="username" value="{{ old('name') }}" placeholder="Username" required autocomplete="off" autofocus>

                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                <input id="email_id" type="email" placeholder="Email Address"  class="form-control @error('email_id') is-invalid @enderror" name="email_id" value="{{ old('email_id') }}" required autocomplete="off">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                                 <div class="col-md-12">
                                            <div class="row">
                               
                            <div class="col-sm-6">
                              <select class="form-control p-0" name="ccode" id="ccode" >
                                @foreach($jsondata as $code)
                                <option data-thumbnail="images/icon-chrome.png" value="{{ $code['dial_code'] }}" <?php if($code['dial_code']) ?>> {{ $code['name'].' ('. $code['dial_code'] . ')' }}</option>
                                @endforeach
                            </select>
                            </div>
                            <div class="col-sm-6">
                                <input id="mobile" type="text" maxlength="10" minlength="10" class="form-control @error('email') is-invalid @enderror" name="mobile_number" placeholder="{{ __('Enter Mobile Number') }}" value="{{ old('mobile_number') }}" required autocomplete="off" autofocus> 
                                <span class="verify-error"></span>
                                
                                 @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror                                    
                            </div></div>
						

                                </div>
                                
                                
                            <div class="col-md-12">
                                <input type="file" multiple="true" class="form-control" style="padding: 0px;" name="picture" id="picture" />
                                 </div>

                                <div class="col-md-12">
                                <label for="" style="color: white;">Upload your best work  :</label>
                                <input type="file" multiple="true" class="form-control" style="padding: 0px;" accept="video/mp4,video/x-m4v,video/*" name="intro_video" id="intro_video" />
                                 </div>
                                 <div class="col-md-12">
                                     <div class="row">
                                     <div class="col-md-12">
                                <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror pwd" name="password" required autocomplete="new-password">
                                         </div>
                                         <div >
                                <span class="input-group-btn" id="eyeSlash">
                                   <button class="btn btn-default reveal" onclick="visibility1()" type="button" style=" background: transparent !important; color:#ff0000!important "><i class="fa fa-eye-slash" aria-hidden="true"></i></button>
                                 </span>
                                 <span class="input-group-btn" id="eyeShow" style="display: none;">
                                   <button class="btn btn-default reveal" onclick="visibility1()" type="button" style=" background: transparent !important; color:#ff0000!important ;"><i class="fa fa-eye" aria-hidden="true"></i></button>
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
                                     <div class="col-md-12">
                                <input id="password-confirm" type="password" class="form-control" placeholder="Confirm Password" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                    <div >
                              <span class="input-group-btn" id="eyeSlash1">
                                   <button class="btn btn-default reveal" onclick="visibility2()" type="button" style=" background: transparent !important; color:#ff0000!important ; "><i class="fa fa-eye-slash" aria-hidden="true"></i></button>
                                 </span>
                                 <span class="input-group-btn" id="eyeShow1" style="display: none;">
                                   <button class="btn btn-default reveal" onclick="visibility2()" type="button"  style=" background: transparent !important; color:#ff0000!important ; "><i class="fa fa-eye" aria-hidden="true"></i></button>
                                 </span>
                                    </div>
                                </div>
    
                                <span style="color: var(--iq-white);font-size: 10px;font-style: italic;">(Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.)</span>
                            </div>
                                 
                            </div>
                        
                        <div class="form-group" >
							
							<div class="col-md-12">
                                <input id="password-confirm" type="checkbox" name="terms" value="1" required>
								<label for="password-confirm" class="col-form-label text-md-right" style="display: inline-block;">{{ __('Yes') }} ,<a data-toggle="modal" data-target="#terms" style="text-decoration:none;color: #fff;font-size: 12px;"> {{ __('I Agree to Terms and  Conditions' ) }}</a></label>
                            </div>
                            <div class="sign-up-buttons col-md-12" align="right">
                                  <button type="button" value="Verify Profile" id="submit" class="btn btn-primary btn-login verify-profile" style="display: none;"> Verify Profile</button>
                                  <button class="btn btn-hover btn-primary btn-block signup" style="display: block;" type="submit" name="create-account">{{ __('Sign Up Today') }}</button>
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
               <div class="mt-3">
                  <div class="d-flex justify-content-center links">
                     Already have an account? <a href="<?= URL::to('/cpp/login')?>" class="text-primary ml-2">Sign In</a>
                  </div>                        
               </div>
            </div>
         </div>
      </div>
   </div>

@include('footer')
@endsection

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
    width: 100px !important;
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
        margin-left: -92px !important;
    height: 45px !important;
    background: transparent !important;
    color: #fff !important;
    }
    .btn{
      
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


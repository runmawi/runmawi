@extends('layouts.app')
<?php
$settings = App\Setting::find(1);
$system_settings = App\SystemSetting::find(1);
?>
@extends('moderator.header')
<link rel="stylesheet" href="<?= typography_link()?>" />
<!-- Style -->
<link rel="stylesheet" href="<?= style_sheet_link() ;?>" />
<style>
    main.py-4{padding-bottom: 0 !important;}
    #ck-button input:checked+span,#ck-button label span{background-color:#3daae0;color:#fff}
    .form-control,.phselect{background:0 0!important;color:var(--iq-white)!important}
    .form-control,.form-control:focus,.phselect{color:var(--iq-white)!important}
    #ck-button{margin:4px;border-radius:4px;overflow:auto;float:left}
    #ck-button label{float:left;width:4em}
    #ck-button label span{text-align:center;display:block;border:1px solid #3daae0;padding:0}
    #ck-button label input{position:absolute}
    .mobile-div{margin-left:-2%;margin-top:1%}
    input::file-selector-button{width:120px;padding:0}
    input[type=checkbox]{appearance:transparent}
    .modal-header{padding:0 15px;border-bottom:1px solid #e5e5e5!important;min-height:16.42857143px}
    #otp{padding-left:15px;letter-spacing:42px;border:0;background-position:bottom;background-size:50px 1px;background-repeat:repeat-x;background-position-x:80px}
    #otp:focus{border:none}
    .verify-buttons{margin-left:36%}
    .panel-heading{margin-bottom:1rem}.select:after{padding-right:15px}
    .phselect{width:100%;height:45px!important}
    .sign-user_card{padding:0!important}
    .form-control{height:45px;line-height:45px;border:1px solid var(--iq-body-text);font-size:14px;border-radius:0;margin-bottom:1rem!important}
    .form-control:focus{background-color:#fff;border-color:#80bdff;outline:0;box-shadow:0 0 0 .2rem rgb(0 123 255 / 25%)}
    select.form-control {line-height:35px}
    .custom-file-upload{border:1px solid #ccc;display:inline-block;padding:6px 12px;cursor:pointer}
    .btn,.btn-hover,.signup{border-radius:5px!important}
    .main-header{display:none}
    .catag{padding-right:150px!important}
    i.fa.fa-google-plus{padding:10px!important}
    option{background:#474644!important}
    .signup{background-color:#ff0040!important;font-weight:700}
    .btn-hover{height:50px;font-weight:700}
    .reveal{margin-left:-70px !important;height:45px !important;background:0 0 !important;color:#fff !important}
    .modal-content{background-color:#000}
</style>
<section class="mb-0" style="background:url('<?php echo URL::to('/').'/public/uploads/settings/'.$settings->login_content; ?>') no-repeat scroll 0 0;;background-size: cover;">

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<?php $jsonString = file_get_contents(base_path('assets/country_code.json'));   
    $jsondata = json_decode($jsonString, true); 
?>
<div class="container">
    <div class="row justify-content-center align-items-center height-self-center">
        <div class="col-sm-9 col-md-7 col-lg-7 align-self-center mb-5">
            <div class="sign-user_card ">                    
               <div class="sign-in-page-data">
                  <div class="sign-in-from w-100 m-auto text-center">
                      <div>
                          <img src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo ; ?>" style="margin-bottom:1rem;">       
                          <h3 class="mb-3 text-center">Channel Partner Sign Up</h3>
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
                        <form action="{{ URL::to('channel/store') }}" method="POST" id="stripe_plan" class="stripe_plan" name="member_signup" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <div class="col-md-12">
                                <input id="channel_name" type="text"  class="form-control alphaonly  @error('channel_name') is-invalid @enderror" name="channel_name" value="{{ old('name') }}" placeholder="Channel Name" required autocomplete="off" autofocus>
                                @error('channel_name')
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
                                    <div class="col-sm-4">
                                        <select class="phselect" name="ccode" id="ccode" >
                                            <option>Select Country</option>
                                            @foreach($jsondata as $code)
                                                <option data-thumbnail="images/icon-chrome.png" value="{{ $code['dial_code'] }}" <?php if($code['dial_code']) ?>> {{ $code['name'].' ('. $code['dial_code'] . ')' }}</option>
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
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 text-left">
                                <label for="" style="color: white;">Upload Home Page Image  :</label>
                                <input type="file" multiple="true" class="form-control" style="padding: 0px;"  name="image" id="image"/>
                            </div>

                            <div class="col-md-12 text-left">
                                <label for="" style="color: white;">Upload your best work ( Intro Video )  :</label>
                                <input type="file" multiple="true" class="form-control" style="padding: 0px;" accept="video/mp4,video/x-m4v,video/*" name="intro_video" id="intro_video"/>
                            </div>

                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror pwd" name="password" required autocomplete="new-password">
                                    </div>
                                    <div>
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
                            <div class="col-md-12 p-0">
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
                        <!-- <span style="color: var(--iq-white);font-size: 14px;font-style: italic;">
                            (Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.)
                        </span> -->
                        <div class="form-group" >
                            <div class="col-md-12 text-left mb-3" >
                                <input id="password-confirm" type="checkbox" name="terms" value="1" required>
                                <label for="password-confirm" class="col-form-label text-md-right" style="display: inline-block;">{{ __('Yes') }} ,<a data-toggle="modal" data-target="#terms" style="text-decoration:none;color: #fff;"> {{ __('I Agree to Terms and  Conditions' ) }}</a></label>
                            </div>
                            <div class="sign-up-buttons col-md-12">
                                <button type="button" value="Verify Profile" id="submit" class="btn btn-primary btn-login verify-profile" style="display: none;"> Verify Profile</button>
                                <button class="btn btn-hover btn-primary btn-block signup" style="display: block;" type="submit" name="create-account">{{ __('Sign Up Today') }}</button>
                            </div>
                        </div>
                    </form>
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
</div>
</div>
    {{-- Footer --}}
    @php
        include(public_path('themes/default/views/footer.blade.php'));
    @endphp
   
@endsection


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
</body>

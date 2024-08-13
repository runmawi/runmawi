@extends('admin.master')
@section('content')
<?php
    //   echo "<pre>";
    // print_r($moderators->user_role);
    // exit();
    ?>
<style>
    #eyeSlash,#eyeShow {
        position: relative;
        margin-top: -40px;
        margin-left: 89%;
    }
    #eyeSlash1,#eyeShow1 {
        position: absolute;
        margin-top: -46px;
        margin-left: 85%;
    }
</style>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

<script src="category/videos/js/rolespermission.js"></script>


<div id="content-page" class="content-page">
         <div class="container-fluid">
              <div class="iq-card">

<div id="moderator-container">
<!-- This is where -->

	<div class="moderator-section-title">
		<h4><i class="entypo-globe"></i>Add Channel Partner</h4>
	</div>
	<div class="clear"></div>
	@if (Session::has('message'))
                       <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
                        @endif
                        @if(count($errors) > 0)
                        @foreach( $errors->all() as $message )
                        <div class="alert alert-danger display-hide" id="successMessage">
                        <button id="successMessage" class="close" data-close="alert"></button>
                        <span>{{ $message }}</span>
                        </div>
                        @endforeach
                        @endif

                    <form method="POST" action="{{ URL::to('admin/channel/user/store') }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data" id="Moderator_edit">
                        @csrf
                        <div class="col-md-6" style="width: 50%; float: left;">

                        <div class="form-group row">
                            <label for="name" class=" col-form-label text-md-right">{{ __('Channel Name') }}</label>
                                <input id="name" type="text" class="form-control" name="channel_name" value=""  autocomplete="channel_name" autofocus>
                            </div>
                        </div>
                        <div class="col-md-6" style="width: 50%; float: left;">

                        <div class="form-group row">
                            <label for="email" class=" col-form-label text-md-right">{{ __('E-Mail Address') }}</label>


                                <input id="email" type="email" class="form-control " name="email" value=""  autocomplete="email">
                            </div>
                        </div>
                        <div class="col-md-6" style="width: 50%; float: left;">
                        <div class="form-group row">
                            <label for="password" class=" col-form-label text-md-right">{{ __('Channel Password') }}</label>
                                <input id="password" type="password" class="form-control " name="password" autocomplete="email">

                                <span class="input-group-btn" id="eyeSlash">
                                   <button class="btn btn-default reveal1" onclick="visibility1()" type="button"><i class="fa fa-eye-slash" aria-hidden="true"></i></button>
                                 </span>
                                 <span class="input-group-btn" id="eyeShow" style="display: none;">
                                   <button class="btn btn-default reveal2" onclick="visibility1()" type="button"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                 </span>

                            </div>
                        </div>
                        <div class="col-md-6" style="width: 50%; float: left;">

                        <div class="form-group row">
                            <label for="mobile_number" class=" col-form-label text-md-right">{{ __('Mobile Number') }}</label>


                                <input id="mobile_number" type="text" class="form-control " name="mobile_number"  name="mobile_number" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" value="" >
                                <span id="error" style="color: Red; display: none">* {{ __('Enter Only Numbers') }}</span>
                            </div>
                        </div>

                        <div class="col-md-6" style="width: 50%; float: left;">

                        <div class="form-group row">
                            <label for="channel_about" class=" col-form-label text-md-right">{{ __('Channel About') }}</label>



                            <input id="channel_about" type="textarea" class="form-control" name="channel_about" value ="" autocomplete="channel_about">
                            </div>
                        </div>
                        <div class="col-md-6" style="width: 50%; float: left;">
                            <div class="form-group row">
                            <label for="channel_roles" class=" col-form-label text-md-right">{{ __('Channel Roles') }}</label>
                               <select class="form-control" name="channel_roles" id="channel_roles">
                                    <option value="">Select Roles</option>
                                    @if($ChannelRoles->count() > 0)
                                        @foreach($ChannelRoles as $value)
                                        <option value="{{ $value->id }}" >{{ $value->role_name }}</option>
                                        @endForeach
                                    @else
                                        No Record Found
                                    @endif
                               </select>
                            </div>
                        </div>
                        <div class="col-md-6" style="width: 50%; float: left;">
                            <div class="form-group row">
                            <label for="parent_channel_id" class=" col-form-label text-md-right">{{ __('Assign to Channel Partner') }}</label>
                               <select class="form-control" name="parent_channel_id" id="parent_channel_id">
                                    <option value="">Select Channel Partner</option>
                                    @if($Channels->count() > 0)
                                        @foreach($Channels as $value)
                                        <option value="{{ $value->id }}">{{ $value->channel_name }}</option>
                                        @endForeach
                                    @else
                                        No Record Found
                                    @endif
                               </select>
                            </div>
                        </div>
                        <div class="col-md-6" style="width: 50%; float: left;">

                        <div class="form-group row">
                            <label for="picture" class=" col-form-label text-md-right">{{ __('Channel Logo') }}</label>

                                <input id="channel_logo" type="file" class="form-control" id= "channel_logo" name="channel_logo"  value="DefaultImageName">
                               <p class="text" id= "error_picture"> </p>

                            </div>
                        </div>
                        <div class="col-md-6" style="width: 50%; float: left;">

                        <div class="form-group row">
                                <label for="" style="">Upload your best work ( Intro Video )  :</label>
                                <input type="file" multiple="true" class="form-control" style="padding: 0px;" accept="video/mp4,video/x-m4v,video/*" name="intro_video" id="intro_video"/>

                            </div>
                        </div>
                    <br>
                                            <div class="form-group row mb-0">
                                                <div class="col-md-12 offset-md-4">
                                                    <button type="submit" id ="submit" class="btn btn-primary">
                                                        {{ __('Register') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>

                                        </div>
                                </div>
                                </div>
                            </div>
                    @endsection
                    <!-- //    display: flex; -->
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                    <script src="jquery-3.5.1.min.js"></script>

                    <script>
                    //     $(document).ready(function(){
                    //     $('#submit').click(function(){
                    //         if($('#picture').val() == ""){
                    //         $('#error_picture').text('Picture Is Requried');
                    //         $('#error_picture').css('color', 'red');

                    //             return false;
                    //         }else{
                    //             return true;
                    //         }
                    //     });
                    // });
                    </script>

                    <script>
    $(document).ready(function(){
        // $('#message').fadeOut(120);
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);
    })
</script>



@section('javascript')

<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
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
            function visibility2() {
        var x = document.getElementById('confirm_password');
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

        var specialKeys = new Array();
        specialKeys.push(8); //Backspace

    function IsNumeric(e) {
    var keyCode = e.which ? e.which : e.keyCode;
    var inputField = e.target || e.srcElement;
    var inputValue = inputField.value;
    var digitCount = inputValue.replace(/[^0-9]/g, '').length;

    var ret = (keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) !== -1;

    if (digitCount >= 10) {
        alert('Please enter at least 10 characters');
        ret = ret || specialKeys.indexOf(keyCode) !== -1;
        document.getElementById("error").style.display = ret ? "none" : "inline";
        return false;
    }

    document.getElementById("error").style.display = ret ? "none" : "inline";
    return ret;
}

document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('Moderator_form').addEventListener('submit', function(event) {
                var mobileNumber = document.getElementById('mobile_number').value;

                // Check if the mobile number is exactly 10 digits long and contains only numeric characters
                if (mobileNumber.length !== 10 || !/^\d+$/.test(mobileNumber)) {
                    alert("Please enter a valid 10-digit mobile number.");
                    event.preventDefault(); // Prevent form submission
                    return false; // Ensure that the function exits
                }


            });
        });

  $(document).ready(function(){
        // $('#message').fadeOut(120);
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);
    })


$('form[id="Moderator_edit"]').validate({
	rules: {
        channel_name : 'required',
        mobile_number : 'required',
        email : 'required'
	},
	messages: {
        username: 'This field is required',
        mobile_number: 'This field is required',
	},
	submitHandler: function(form) {
	  form.submit();
	}
  });

</script>
	@stop

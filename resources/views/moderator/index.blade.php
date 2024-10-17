@extends('admin.master')
@section('content')

<style>
    .form-group{
        margin: 8px auto;
    }

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
		<h4><i class="entypo-globe"></i> Users</h4> 
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

                    <form method="POST" action="{{ URL::to('moderatoruser/create') }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data" id="Moderator_form"  >
                        @csrf
                        <div class="row">
                        <div class="col-md-6" >
                            <div class="form-group row">
                                <label for="name" class=" col-form-label text-md-right">{{ __('User Name') }}</label>
                                    <input id="name" type="text" class="form-control" name="username" value="{{ old('username') }}"  autocomplete="username" autofocus>
                            </div>
                        </div>

                        <div class="col-md-6" >
                            <div class="form-group row">
                                <label for="email" class=" col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                                <input id="email_id" type="email" class="form-control " name="email_id" value="{{ old('email_id') }}"  autocomplete="email">
                            </div>
                        </div>

                        <div class="col-md-6" >
                            <div class="form-group row">
                                <label for="mobile_number" class=" col-form-label text-md-right">{{ __('Mobile Number') }}</label>
                                <input id="mobile_number" type="text" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" class="form-control " name="mobile_number" value="{{ old('mobile_number') }}"  autocomplete="email">
                                <span id="error" style="color: Red; display: none">* {{ __('Enter Only Numbers') }}</span>
                            </div>
                        </div>

                        <div class="col-md-6" >
                            <div class="form-group row">
                                <label for="password" class=" col-form-label text-md-right">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control " name="password"  autocomplete="new-password">
                                <span class="input-group-btn" id="eyeSlash">
                                   <button class="btn btn-default reveal1" onclick="visibility1()" type="button"><i class="fa fa-eye-slash" aria-hidden="true"></i></button>
                                 </span>
                                 <span class="input-group-btn" id="eyeShow" style="display: none;">
                                   <button class="btn btn-default reveal2" onclick="visibility1()" type="button"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                 </span>
                            </div>
                   
                        </div>


                        <div class="col-md-6" >
                            <div class="form-group row">
                                <label for="password-confirm" class=" col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                                <input id="confirm_password" type="password" class="form-control" name="confirm_password"  autocomplete="new-password">
                            </div>
                            <span class="input-group-btn" id="eyeSlash1">
                                   <button class="btn btn-default reveal" onclick="visibility2()" type="button"><i class="fa fa-eye-slash" aria-hidden="true"></i></button>
                                 </span>
                                 <span class="input-group-btn" id="eyeShow1" style="display: none;">
                                   <button class="btn btn-default reveal" onclick="visibility2()" type="button"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                 </span>
                        </div>

                        <div class="col-md-6" >
                            <div class="form-group row">
                                <label for="user_role" class=" col-form-label text-md-right">{{ __('User Roles') }}</label>
                                    <select class="form-control" id="user_role" name="user_role">
                                        <option value="">Select Roles</option>
                                            @if($roles->count() > 0)
                                                @foreach($roles as $value)
                                                    <option value="{{$value->id}}">{{$value->role_name}}</option>
                                                @endForeach
                                            @else
                                                No Record Found
                                            @endif   
                                    </select>         
                            </div>
                        </div>

                        <!-- <div class="col-md-6" >
                            <label>{{ ucfirst(('Website Show IN')) }} </label>

                                <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                    <div style="color:red;">Off</div>
                                    <div class="mt-1">
                                        <label class="switch">
                                            <input name="show_in" id="show_in"  type="checkbox" @if( @$value->show_in == "1") checked  @endif >
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div style="color:green;">On</div>
                                </div>
                            </div> -->

                        <div class="col-md-6" >
                            <div class="form-group row">
                                <label for="description" class=" col-form-label text-md-right">{{ __('Description') }}</label>
                                <input id="description" type="textarea" class="form-control" name="description"  autocomplete="description">
                            </div>
                        </div>

                        <div class="col-md-6" >
                            <div class="form-group row">
                                <label for="" class=" col-form-label text-md-right">{{ __('Commission Percentage') }}</label>
                                <input type="number" class="form-control" name="commission_percentage" id="commission_percentage"  value="{{ ( !empty($CPP_commission_percentage)) ? $CPP_commission_percentage : null }}" 
                                min="0" max="100" step="1" oninput="this.value = this.value > 100 ? 100 : this.value < 0 ? 0 : this.value;" />
                            </div>
                        </div>

                        <div class="col-md-6" >
                             <div class="form-group row">
                                <label for="picture" class=" col-form-label text-md-right">{{ __('Picture') }}</label>
                                    <input id="picture" type="file" class="form-control"  id= "picture" name="picture" >
                                <p class="text" id= "error_picture"> </p>
                            </div>
                        </div>

                       
                        <!-- <div class="col-md-6" style="width: 50%; float: left;">

                        <div class="form-group row">
                            <label for="user_permission" class=" col-form-label text-md-right">{{ __('User Permission') }}</label>

                            
                            <select class="form-control" name="user_permission">
                            <option value="0">Select Permission</option>

                              
                                </select>             
                                </div>
                                </div> -->
           

<!-- <div id="user_permissions" class="buttons">

<div >
                               
<label for="user_permission" class=" col-form-label text-md-right">{{ __('User Permission') }}</label>
</div>
@foreach($permission as $permissions)

<div  class="col-md-4" style="width: 33%; float: left;">
            <div class="col-md-6" style="width: 50%; float: left;" style="width: 50%; float: left;">
          <label>  {{$permissions->name}}</label>
            <label class="switch">
                      <input type="checkbox"  name="user_permission[]" checked="checked" value="{{$permissions->id}}">
                <span class="slider round"></span>
            </label>
</div>

@endForeach



</div>

</div> -->




                       </div>
                         <div class=" row mb-0">
                            <div class="col-md-12 text-right mt-4 mb-5 ">
                                <button type="submit" class="btn btn-primary">
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


    $(document).ready(function(){
    $('#submit').click(function(){
        if($('#picture').val() == ""){
        $('#error_picture').text('Picture Is Requried');
        $('#error_picture').css('color', 'red');

            return false;
        }else{
            return true;
        }
    });
});



</script>

@section('javascript')

<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script>

// $('#show_in').hide();

// $('#user_role').change(function(){
//         if($('#user_role').val() == "4"){
//         $('#show_in').show();
//         }else{
//             $('#show_in').hide();
//         }
//     });
    

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
// function validateMobileNumber() {

//     var mobileNumber = document.getElementById('mobile_number').value;

//     if (mobileNumber.length !== 10 || !/^\d+$/.test(mobileNumber)) {
//         alert("Please enter a valid 10-digit mobile number.");
//         return false;
//     }

//     return true; 

// }

$('form[id="Moderator_form"]').validate({
	rules: {
        username : 'required',
        mobile_number : 'required',
        password : 'required',
        confirm_password : 'required',
        user_role : 'required',
        email_id : 'required'
	},
	messages: {
        username: 'This field is required',
        mobile_number: 'This field is required',
	},
	submitHandler: function(form) {
	  form.submit();
	}
  });

  $(document).ready(function(){
        // $('#message').fadeOut(120);
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);
    })


</script>
	@stop
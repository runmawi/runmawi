@extends('admin.master')
@section('content')


<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

<script src="category/videos/js/rolespermission.js"></script>


<div id="content-page" class="content-page">
         <div class="container-fluid">
              <div class="">

<div id="moderator-container">
<!-- This is where -->
	
	<div class="moderator-section-title">
		<h3><i class="entypo-globe"></i> Users</h3> 
	</div>
	<div class="clear"></div>


                    <form method="POST" action="{{ URL::to('moderatoruser/create') }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data" id="Moderator_form">
                        @csrf
                        <div class="col-md-6" style="width: 50%; float: left;">
                            <div class="form-group row">
                                <label for="name" class=" col-form-label text-md-right">{{ __('User Name') }}</label>
                                    <input id="name" type="text" class="form-control" name="username" value="{{ old('username') }}"  autocomplete="username" autofocus>
                            </div>
                        </div>

                        <div class="col-md-6" style="width: 50%; float: left;">
                            <div class="form-group row">
                                <label for="email" class=" col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                                <input id="email_id" type="email" class="form-control " name="email_id" value="{{ old('email_id') }}"  autocomplete="email">
                            </div>
                        </div>

                        <div class="col-md-6" style="width: 50%; float: left;">
                            <div class="form-group row">
                                <label for="mobile_number" class=" col-form-label text-md-right">{{ __('Mobile Number') }}</label>
                                <input id="mobile_number" type="number" class="form-control " name="mobile_number" value="{{ old('mobile_number') }}"  autocomplete="email">
                            </div>
                        </div>

                        <div class="col-md-6" style="width: 50%; float: left;">
                            <div class="form-group row">
                                <label for="password" class=" col-form-label text-md-right">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control " name="password"  autocomplete="new-password">
                            </div>
                        </div>


                        <div class="col-md-6" style="width: 50%; float: left;">
                            <div class="form-group row">
                                <label for="password-confirm" class=" col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                                <input id="confirm_password" type="password" class="form-control" name="confirm_password"  autocomplete="new-password">
                            </div>
                        </div>

                        <div class="col-md-6" style="width: 50%; float: left;">
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


                        <div class="col-md-6" style="width: 50%; float: left;">
                            <div class="form-group row">
                                <label for="description" class=" col-form-label text-md-right">{{ __('Description') }}</label>
                                <input id="description" type="textarea" class="form-control" name="description"  autocomplete="description">
                            </div>
                        </div>


                        <div class="col-md-6" style="width: 50%; float: left;">
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


<br>

                        <div class="form-group row mb-0">
                            <div class="col-md-12 d-flex justify-content-end">
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

</script>
	@stop
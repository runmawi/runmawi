@extends('admin.master')
@section('content')
<?php
    //   echo "<pre>";  
    // print_r($moderators->user_role);
    // exit();
    ?>

<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

<script src="category/videos/js/rolespermission.js"></script>


<div id="content-page" class="content-page">
         <div class="container-fluid">
              <div class="iq-card">

<div id="moderator-container">
<!-- This is where -->
	
	<div class="moderator-section-title">
		<h3><i class="entypo-globe"></i>Update Moderator Users</h3> 
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

                    <form method="POST" action="{{ URL::to('admin/moderatoruser/update') }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-6" style="width: 50%; float: left;">

                        <div class="form-group row">
                            <label for="name" class=" col-form-label text-md-right">{{ __('User Name') }}</label>
                            <input id="id" type="hidden" class="form-control" name="id" value="{{  $moderators->id }}"  autocomplete="username" autofocus>

                                <input id="name" type="text" class="form-control" name="username" value="{{ $moderators->username }}"  autocomplete="username" autofocus>
                            </div>
                        </div>
                        <div class="col-md-6" style="width: 50%; float: left;">

                        <div class="form-group row">
                            <label for="email" class=" col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            
                                <input id="email_id" type="email" class="form-control " name="email_id" value="{{ $moderators->email }}"  autocomplete="email">
                            </div>
                        </div>
                        <div class="col-md-6" style="width: 50%; float: left;">

                        <div class="form-group row">
                            <label for="mobile_number" class=" col-form-label text-md-right">{{ __('Mobile Number') }}</label>

                       
                                <input id="mobile_number" type="number" class="form-control " name="mobile_number" value="{{ $moderators->mobile_number }}"  autocomplete="email">
                            </div>
                        </div>
                        <!-- <div class="col-md-6" style="width: 50%; float: left;">

                        <div class="form-group row">
                            <label for="password" class=" col-form-label text-md-right">{{ __('Password') }}</label>

                
                                <input id="password" type="password" class="form-control " name="password"  autocomplete="new-password">
                            </div>
                        </div> -->
                        <!-- <div class="col-md-6" style="width: 50%; float: left;">

                        <div class="form-group row">
                            <label for="password-confirm" class=" col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <input id="confirm_password" type="password" class="form-control" name="confirm_password"  autocomplete="new-password">
                            </div>
                        </div>
 -->

                        <div class="col-md-6" style="width: 50%; float: left;">

                        <div class="form-group row">
                            <label for="description" class=" col-form-label text-md-right">{{ __('Description') }}</label>

                           
                               
                            <input id="description" type="textarea" class="form-control" name="description" value ="{{ $moderators->description }}" autocomplete="description">
                            </div>
                        </div>


                        <div class="col-md-6" style="width: 50%; float: left;">

                        <div class="form-group row">
                            <label for="picture" class=" col-form-label text-md-right">{{ __('Picture') }}</label>

                            <input id="picture" type="hidden" class="form-control" id= "picture" name="picture"  value="">
                           
                                <input id="picture" type="file" class="form-control" id= "picture" name="picture"  value="DefaultImageName">
                               <p class="text" id= "error_picture"> </p>
                      
                            </div>
                            @if(!empty($moderators->picture))
                            <img src="{{ $moderators->picture }}" style="max-height:100px" />
                            @endif
                        </div>

                        <div class="col-md-6" style="width: 50%; float: left;">


                        <div class="form-group row">
                            <label for="user_role" class=" col-form-label text-md-right">{{ __('User Roles') }}</label>

                     
                            <select class="form-control" id="user_role" name="user_role">
                            <option value="">Select Roles</option>

                                    @if($roles->count() > 0)
                                    @foreach($roles as $value)
                                    <!-- <option value="{{$value->id}}">{{$value->role_name}}</option> -->
                                    <option value="{{ $value->id }}" @if(!empty($moderators->user_role) && $moderators->user_role == $value->id){{ 'selected' }}@endif>{{ $value->role_name }}</option>

                                    @endForeach
                                    @else
                                    No Record Found
                                    @endif   

                        </select>         
                        </div>
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
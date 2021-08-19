@extends('admin.master')
<style type="text/css">
	.has-switch .switch-on label {
		background-color: #FFF;color: #000;
	}
	.make-switch{
		z-index:2;
	}
    .iq-card{
        padding: 15px;
    }
    .p1{
        font-size: 12px;
    }
</style>
@section('content')


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
		<h4><i class="entypo-globe"></i> Users</h4> 
	</div>
	<div class="clear"></div>


                    <form method="POST" action="{{ URL::to('moderatoruser/create') }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">
                        @csrf
                        <div class="row" style="padding:15px;">
                        <div class="col-md-6" >

                        <div class="form-group row">
                            <label for="name" class=" col-form-label text-md-right">{{ __('User Name') }}</label>

                                <input id="name" type="text" class="form-control" name="username" value="{{ old('username') }}"  autocomplete="username" autofocus>
                            </div>
                            <div class="form-group row">
                            <label for="password" class=" col-form-label text-md-right">{{ __('Password') }}</label>

                
                                <input id="password" type="password" class="form-control " name="password"  autocomplete="new-password">
                            </div>
                            <div class="form-group row">
                            <label for="password-confirm" class=" col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <input id="confirm_password" type="password" class="form-control" name="confirm_password"  autocomplete="new-password">
                            </div>
                            <div class="form-group row">
                            <label for="email" class=" col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            
                                <input id="email_id" type="email" class="form-control " name="email_id" value="{{ old('email_id') }}"  autocomplete="email">
                            </div>
                        </div>
                        
                        <div class="col-md-6" >

                        <div class="form-group row">
                            <label for="mobile_number" class=" col-form-label text-md-right">{{ __('Mobile Number') }}</label>

                       
                                <input id="mobile_number" type="number" class="form-control " name="mobile_number" value="{{ old('mobile_number') }}"  autocomplete="email">
                            </div>
                            <div class="form-group row">
                            <label for="description" class=" col-form-label text-md-right">{{ __('Description') }}</label>

                           
                               
                            <input id="description" type="textarea" class="form-control" name="description"  autocomplete="description">
                            </div>
                             <div class="form-group row">
                            <label for="picture" class=" col-form-label text-md-right">{{ __('Picture') }}</label>

                           
                                <input id="picture" type="file" class="form-control" name="picture" >
                            </div>
                            
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
                        


<div id="user_permissions" class="buttons">

<div >
                               
<label for="user_permission" class=" col-form-label text-md-right">{{ __('User Permission') }}</label>
</div>
@foreach($permission as $permissions)

<div  class="col-md-4" style="width: 33%; float: left;">
            <!-- <div class="col-md-6" style="width: 50%; float: left;" style="width: 50%; float: left;"> -->
            {{$permissions->name}}
            <label class="switch">
                      <input type="checkbox"  name="user_permission[]" checked="checked" value="{{$permissions->id}}">
                <span class="slider round"></span>
            </label>
</div>

@endForeach



</div>

</div>









<br>









                        <div class="form-group row mb-0 p-3" style="display: flex;
    justify-content: flex-end;">
                            <div class="">
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
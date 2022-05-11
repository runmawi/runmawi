@extends('admin.master')
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
		<h4><i class="entypo-globe"></i>Update Roles</h4> 
	</div>
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
	<div class="clear"></div>


                    <form method="POST" action="{{ URL::to('admin/moderatorsrole/update') }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-12">

                        <div class="form-group row">
                            <label for="name" class=" col-form-label text-md-right"><label>{{ __('User Name') }}</label></label>
                            <input id="id" type="hidden" class="form-control" name="id" value="{{  $roles->id }}"  autocomplete="username" autofocus>

                                <input id="name" type="text" class="form-control" name="username" value="{{ $roles->role_name }}"  autocomplete="username" autofocus>
                            </div>
                        </div>
            
                    <div id="user_permissions" class="buttons">
                    <div >
                                                
                    <label for="user_permission" class=" col-form-label text-md-right"> {{ __('User Permission') }} </label>
                    </div>
                    @foreach($permission as $permissions)
                               
                               <div  class="col-md-4 d-flex align-items-center justify-content-between" style="width: 33%; float:left;">
                                           
                                        <div>  <label  style="color:#000000!important;">{{$permissions->name}}</label></div>
                                           <label class="switch">
                            <input class="form-check-input" type="checkbox" name="user_permission[]" value="{{$permissions->id}}" {{ (in_array($permissions->id, $moderatorspermission)) ? ' checked' : '' }}> 

                                                     <!-- <input type="checkbox"  name="user_permission[]"  value="{{$permissions->id}}"> -->
                                               <span class="slider round"></span>
                                           </label>
                               </div>
                               
                               @endForeach


                    </div>

                    <br>
                                            <div class="form-group row mb-0">
                                                <div class="col-md-12 offset-md-10">
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
                    <script>
    $(document).ready(function(){
        // $('#message').fadeOut(120);
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);
    })
</script>
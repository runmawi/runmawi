@extends('admin.master')
@section('content')


<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

<script src="category/videos/js/rolespermission.js"></script>


<div id="content-page" class="content-page">
         <div class="container-fluid">
              <div class="iq-card">

<div id="user_roles-container">
<!-- This is where -->
	<div class="user_roles-section-title">
        <div class=”panel-body” id="message">
    @if (session()->has('notification'))
    <div class="notification">
        {!! session('notification') !!}
    </div>
@endif
</div>
           
		<h3><i class="entypo-globe"></i> Roles & Permission</h3> 
        <form method="POST" action="{{ URL::to('admin/rolepermission/create') }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                        <div class="col-md-12" >

                        <div class="form-group row">
                            <label for="name" class=" col-form-label text-md-right">{{ __('Role Name') }}</label>

                                <input id="role_name" type="text" class="form-control" name="role_name"  autocomplete="role_name" autofocus>
                            </div>
                        </div>
                        <!-- <div class="col-md-6" style="width: 50%; float: left;">
                                    
                        <label for="permission"><h5>Permission</h5></label>

                        </div>
                        <div class="col-md-6" style="width: 50%; float: left;">
                        
                        <label for="Add"><h5>Add</h5></label>&nbsp;&nbsp;&nbsp;&nbsp;
                        <label for="Update"><h5>Update</h5></label>&nbsp;&nbsp;&nbsp;&nbsp;
                        <label for="View"><h5>View</h5></label>&nbsp;&nbsp;&nbsp;&nbsp;
                        <label for="view"><h5>Delete</h5></label>
                        </div>




                        <div class="col-md-6" style="width: 50%; float: left;">
                                    
                        <label for="permission"><h5>Video</h5></label><br>
                        <label for="permission"><h5>Audio</h5></label>


                        </div>
                        <div class="col-md-6" style="width: 50%; float: left;">
                        <input type="checkbox" name="permission[]" id="video_add" value="1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="checkbox" name="permission[]" id="video_update" value="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="checkbox" name="permission[]" id="video_edit" value="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="checkbox" name="permission[]" id="video_delete" value="4">


                        </div> -->
                        <div >
                               
                               <label for="user_permission" class=" col-form-label text-md-right">{{ __('User Permission') }}</label>
                               </div>
                               @foreach($permission as $permissions)
                               
                               <div  class="col-md-4" style="width: 33%; float: left;">
                                           <!-- <div class="col-md-6" style="width: 50%; float: left;" style="width: 50%; float: left;"> -->
                                           {{$permissions->name}}
                                           <label class="switch">
                                                     <input type="checkbox"  name="user_permission[]"  value="{{$permissions->id}}">
                                               <span class="slider round"></span>
                                           </label>
                               </div>
                               
                               @endForeach
                               
                               
                               
                               </div>
                               
                               </div>
                               

                    <div class="form-group row mb-0"><div class="col-md-12 offset-md-4">
                        <button type="submit" class="btn btn-primary">{{ __('Register') }}</button>
                    </div></div>
                </form>
	        </div>
	    </div>
	</div>
</div>
</div>
<!-- </div> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $('#message').fadeOut(120);
    })
</script>
@stop

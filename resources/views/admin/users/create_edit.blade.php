@extends('admin.master')
<style>
    .p1{
        font-size: 12px!important;
    }
</style>
@section('css')
	<link rel="stylesheet" href="{{ '/application/application/assets/js/tagsinput/jquery.tagsinput.css' }}"/>
@stop


@section('content')

 <?php 
    $jsonString = file_get_contents(base_path('assets/country_code.json'));   

    $jsondata = json_decode($jsonString, true); 
?>
<div id="content-page" class="content-page">
            <div class="container-fluid">
                <div class="iq-card">
<div id="admin-container" style="padding:20px;">
    
<!-- This is where -->
	
	<div class="admin-section-title">
	@if(!empty($user->id))
		<h4><i class="entypo-user"></i> {{ $user->username }}</h4> 
        <hr>
<!--
		<a href="{{ URL::to('user') . '/' . $user->username }}" target="_blank" class="btn btn-black">
			<i class="fa fa-eye"></i> Preview <i class="fa fa-external-link"></i>
		</a>
-->
	@else
		<h4><i class="entypo-user"></i> Add New User</h4> 
	@endif
	</div>
	<div class="clear"></div>

	

		<form method="POST" action="<?= $post_route ?>" id="update_profile_form" accept-charset="UTF-8" file="1" enctype="multipart/form-data">
         <div class="row">
             <div class="col-md-6 mt-2">
			<div id="user-badge">
				@if(isset($user->avatar))<?php $avatar = $user->avatar; ?>@else<?php $avatar = 'default.jpg'; ?>@endif
				<img height="100" width="100" src="<?= URL::to('/') . '/public/uploads/avatars/' . $avatar ?>" />
				<label for="avatar">@if(isset($user->username))<?= ucfirst($user->username). '\'s'; ?>@endif Profile Image</label>
				<input type="file" multiple="true" class="form-control" name="avatar" id="avatar" />
			</div>

			<div class="panel panel-primary mt-2" data-collapsed="0"> <div class="panel-heading"> 
				<!--<div class="panel-title">Username</div>--> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body" style="display: block;"> 
					<?php if($errors->first('username')): ?><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong>Oh snap!</strong> <?= $errors->first('username'); ?></div><?php endif; ?>
                    <label>User's Username</label>
					<input type="text" class="form-control" name="username" id="username" value="<?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?>" />
				</div>
			</div>

			<div class="panel panel-primary mt-2" data-collapsed="0"> <div class="panel-heading"> 
				<!--<div class="panel-title">Email</div>--> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body" style="display: block;"> 
					<?php if($errors->first('email')): ?><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong>Oh snap!</strong> <?= $errors->first('email'); ?></div><?php endif; ?>
					<label>User's Email Address</label>
					<input type="text" class="form-control" name="email" id="email" value="<?php if(!empty($user->email)): ?><?= $user->email ?><?php endif; ?>" />
				</div>
			</div>
             </div>
             <div class="col-md-6">
                 <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				<!--<div class="panel-title">Mobile</div>--> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body" style="display: block;"> 
                      
					<?php if($errors->first('email')): ?><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong>Oh snap!</strong> <?= $errors->first('mobile'); ?></div><?php endif; ?>
					<label>User's Mobile</label>
                    <div class="row">
                       <div class="col-sm-4">
                        <select name="ccode" class="form-control" >
                            @foreach($jsondata as $code)
                            <option value="{{ $code['dial_code'] }}" <?php if(isset($user) && $code['dial_code'] == $user->ccode ) { echo "selected='seletected'"; } ?>> {{ $code['name'].' ('. $code['dial_code'] . ')' }}</option>
                            @endforeach
                          </select>
                        </div>
                      <div class="col-sm-8">
					       <input type="text" class="form-control" name="mobile" id="mobile" value="<?php if(!empty($user->mobile)): ?><?= $user->mobile ?><?php endif; ?>" />
                    </div></div>
				</div>
			</div>

			<div class="panel panel-primary mt-2" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title"><label>Password</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body" style="display: block;">
					@if(isset($user->password))
						<p class="p1">(leave empty to keep your original password)</p>
					@else
						<p class="p1">Enter users password:</p>
					@endif
					<input type="password" class="form-control" name="passwords" id="password" value="" />
				</div>
			</div>
                 <div class="col-sm-6"> 
					<div class="panel panel-primary mt-2" data-collapsed="0"> <div class="panel-heading"> 
						<div class="panel-title"><label>User Role</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body" style="display: block;"> 
						<p class="p1">Select the user's role below</p>
							<select class="form-control"  id="role" name="role">
								<option value="admin" @if(isset($user->role) && $user->role == 'admin' && $user->sub_admin == 0)selected="selected"@endif>Admin</option>
								<option value="registered" @if(isset($user->role) && $user->role == 'registered')selected="selected"@endif>Registered Users (free registration must be enabled)</option>
								<option value="subscriber" @if(isset($user->role) && $user->role == 'subscriber')selected="selected"@endif>Subscriber</option>
                                
							</select>
						</div>
					</div>
				</div>
                 <div class="col-sm-6"> 
					<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
						<!--<div class="panel-title">User Active Status</div>--> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body" style="display: block;"> 
							<label>User Active Status </label>
							<input type="checkbox" id="active" name="active" @if(isset($user->active) && $user->active == 1)checked="checked" value="1" @else value="0" @endif />
						</div>
					</div>
				</div>
             </div>
            </div>
            <!-- row -->
<div class="mt-3"></div>
			@if(isset($user->id))
				<input class="btn btn-primary" type="hidden" id="id" name="id" value="{{ $user->id }}" />
				<input class="btn btn-primary" type="hidden" id="stripe_active" name="stripe_active" value="" />
			@endif
 <div class="mt-2 p-2"  style="display: flex;
    justify-content: flex-end;">
			<input class="btn btn-primary" type="hidden" name="_token" value="<?= csrf_token() ?>" />
     <input class="btn btn-primary" type="submit" value="{{ $button_text }}" class="btn btn-black pull-right" /></div>

			<div class="clear"></div>
		</form>

		<div class="clear"></div>
<!-- This is where now -->
</div>
    </div>
</div>
</div>

	
	
	
	@section('javascript')


	<script type="text/javascript" src="{{ '/application/application/assets/js/tinymce/tinymce.min.js' }}"></script>
	<script type="text/javascript" src="{{ '/application/application/assets/js/tagsinput/jquery.tagsinput.min.js' }}"></script>
	<script type="text/javascript" src="{{ '/application/application/assets/js/jquery.mask.min.js' }}"></script>

	<script type="text/javascript">

	$ = jQuery;

	$(document).ready(function(){

		$('#active, #disabled').change(function() {
			if($(this).is(":checked")) {
		    	$(this).val(1);
		    } else {
		    	$(this).val(0);
		    }
		    console.log('test ' + $(this).is( ':checked' ));
		});

	});



	</script>

	@stop

@stop
@extends('admin.master')
<style>
    .p1{
        font-size: 12px!important;
    }
    .form-contro{
        margin-bottom: 25px!important;
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

					@if(isset($user->activation_code))
					<a href="{{ URL::to('admin/resend/Activation_Code') . '/' . $user->id }}" class="share-ico"><button class="btn btn-primary float-right">Send Email Verification </button></a>
							<!-- <p>Click <a href="{{ URL::to('admin/resend/Activation_Code') . '/' . $user->id }}" class="share-ico"><i class="ri-links-fill"></i> here</a> to Send Activation Code</p> -->
					@endif
					<br>
					<br>
					<br>
					@if (Session::has('message'))
                       <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
                    @endif
                      
					<div class="clear"></div>
					<form method="POST" action="<?= $post_route ?>" id="update_profile_form" accept-charset="UTF-8" file="1" enctype="multipart/form-data" >
						<div class="row">
							<div class="col-md-6 mt-2">
								<div id="user-badge">
									@if(isset($user->avatar))<?php $avatar = $user->avatar; ?>@else<?php $avatar = 'profile.png'; ?>@endif
									<img height="100" width="100" src="<?= URL::to('/') . '/public/uploads/avatars/' . $avatar ?>" />
									<label for="avatar">@if(isset($user->username))<?= ucfirst($user->username). '\'s'; ?>@endif Profile Image</label>
									<input type="file" multiple="true" class="form-control mt-2 mb-3" name="avatar" id="avatar" accept="image/png, image/gif, image/jpeg, image/webp" onchange="validateFileType(this)" />
									<span id="file-type-validation-msg" style="color:red;"></span>
									<!-- <input type="file" multiple="true" class="form-control mt-2 mb-3" name="avatar" id="avatar" accept="image/png, image/gif, image/jpeg, image/webp" /> -->
								</div>

								<div class="panel panel-primary mt-2" data-collapsed="0"> <div class="panel-heading"> 
									<!--<div class="panel-title">Username</div>--> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
									<div class="panel-body" style="display: block;"> 
										<?php if($errors->first('username')): ?><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong>Oh snap!</strong> <?= $errors->first('username'); ?></div><?php endif; ?>
										<label class="mb-1"> Username</label>
										<input type="text" class="form-control mb-3" name="username" id="username" value="<?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?>" />
									</div>
								</div>

								<div class="panel panel-primary mt-2" data-collapsed="0"> <div class="panel-heading"> 
									<!--<div class="panel-title">Email</div>--> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
									<div class="panel-body" style="display: block;"> 
										<?php if($errors->first('email')): ?><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong>Oh snap!</strong> <?= $errors->first('email'); ?></div><?php endif; ?>
										<label class="mb-1">User Email Address</label>
										<input type="text" class="form-control mb-3" name="email" id="email" value="<?php if(!empty($user->email)): ?><?= $user->email ?><?php endif; ?>" />
									</div>
								</div>
							</div>
							<div class="col-md-6 mt-2">
								<div class="panel panel-primary mt-2" data-collapsed="0">
									<div class="panel-heading"> 
											<!--<div class="panel-title">Mobile</div>-->
										<div class="panel-options">
											<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
										</div>
									</div> 
								<div class="panel-body" style="display: block;"> 
									
									<?php if($errors->first('mobile')): ?><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong>Oh snap!</strong> <?= $errors->first('mobile'); ?></div><?php endif; ?>
									<label class="mb-1">User's Mobile</label>
									<div class="row">
										<div class="col-sm-4">
											<select name="ccode" class="form-control mb-3" >
												@foreach($jsondata as $code)
												<option value="{{ $code['dial_code'] }}" <?php if(isset($user) && $code['dial_code'] == $user->ccode ) { echo "selected='seletected'"; } ?>> {{ $code['name'].' ('. $code['dial_code'] . ')' }}</option>
												@endforeach
											</select>
										</div>
										<div class="col-sm-8">
										<input type="text" class="form-control mb-3" name="mobile" id="mobile" value="<?php if(!empty($user->mobile)): ?><?= $user->mobile ?><?php endif; ?>" />
										</div>
									</div>
								</div>
							</div>

							<div class="panel panel-primary mt-2" data-collapsed="0">
								<div class="panel-heading"> 
									<div class="panel-title">
										<label class="mb-1">Password</label>
									</div> 
									<div class="panel-options"> 
										<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> 
									</div>
								</div> 
								<div class="panel-body" style="display: block;">
									@if(isset($user->password))
										<p class="p1">(leave empty to keep your original password)</p>
									@else
										<p class="p1">Enter users password:</p>
									@endif
									<div class="d-flex position-relative">
										<input type="password" class="form-control mb-3" name="passwords" id="password" value="" />
										<div class="position-absolute" style="right:0;">
											<span class="input-group-btn" id="eyeSlash">
												<button class="btn btn-default reveal" onclick="visibility1()" type="button"><i class="fa fa-eye-slash" aria-hidden="true"></i></button>
											</span>
											<span class="input-group-btn" id="eyeShow" style="display: none;">
												<button class="btn btn-default reveal" onclick="visibility1()" type="button"><i class="fa fa-eye" aria-hidden="true"></i></button>
											</span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-12 mt-2 p-0"> 
								<div class="panel panel-primary mt-2" data-collapsed="0">
									<div class="panel-heading"> 
										<div class="panel-title">
											<label class="mb-1">User Role</label>
										</div>
										<div class="panel-options">
											<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
										</div>
									</div> 
									<div class="panel-body" style="display: block;"> 
										<p class="p1">Select the user's role below</p>
										<select class="form-control mb-3"  id="role" name="role">
											<option value="admin" @if(isset($user->role) && $user->role == 'admin' && $user->sub_admin == 0)selected="selected"@endif>Admin</option>
											<option value="registered" @if(isset($user->role) && $user->role == 'registered')selected="selected"@endif>Registered Users (free registration must be enabled)</option>
											<option value="subscriber" @if(isset($user->role) && $user->role == 'subscriber')selected="selected"@endif>Subscriber</option>
											
										</select>
									</div>
								</div>
							</div>
						</div>
						
						@if ( Auth::user()->role != "admin" )
							<div class="col-sm-6 mt-2"> 
								<div class="panel panel-primary" data-collapsed="0"> 
									<div class="panel-heading"> 
										<div class="panel-options"> 
											<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> 
										</div>
									</div>

									<div class="panel-body" style="display: block;"> 
										<label class="mb-1">OTP </label>
										<input type="text" class="form-control mb-3" name="otp" id="otp" value="<?php if(!empty($user->otp)): ?><?= $user->otp ?><?php endif; ?>" />
									</div>
								</div>
							</div>
						@endif

						<div class="col-md-3">
							<label for="">User Active </label>
							<div class="d-flex justify-content-around align-items-center" style="width:50%;">

								<div style="color:red;">OFF</div>

								<div class="mt-1">
									<label class="switch">
										<input type="checkbox" id="active" name="active" @if(isset($user->active) && $user->active == 1)checked="checked" value="1" @else value="0" @endif />
										<span class="slider round"></span>
									</label>
								</div>

								<div style="color:green;">ON</div>
							</div>
							<div class="make-switch" data-on="success" data-off="warning"></div>
						</div>

						<div class="col-md-3">
							<label for="">Free OTP Status</label>
							<div class="d-flex justify-content-around align-items-center" style="width:50%;">

								<div style="color:red;">OFF</div>

								<div class="mt-1">
									<label class="switch">
										<input type="checkbox" id="free_otp_status" name="free_otp_status" {{ $user->free_otp_status == 1 ? 'checked' : '' }}>
										<span class="slider round"></span>
									</label>
								</div>

								<div style="color:green;">ON</div>
							</div>
							<div class="make-switch" data-on="success" data-off="warning"></div>
						</div>

						<div class="col-md-6 mt-2" id="SubscriptionPlan">
							<div class="panel panel-primary mt-2" data-collapsed="0"> 
								<div class="panel-heading"> 
									<div class="panel-options"> 
										<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
									</div>
								</div> 
								<div class="panel-body" style="display: block;"> 
									<label class="mb-1">Choose Subscriber Plan :</label>
									<div class="row">
										<div class="col-sm-12">
											<select name="plan" class="form-control mb-3" >
												@foreach($SubscriptionPlan as $plan)
												<option value="{{ $plan->plan_id }}" > {{ $plan->plans_name .'- '.$plan->type }}</option>
												@endforeach
											</select>
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

							<div class="clear"></div>
						</div>
						<div class="col-md-12 mt-2 p-2"  style="display: flex; justify-content: flex-end;">
							<input class="btn btn-primary" type="hidden" name="_token" value="<?= csrf_token() ?>" />
							<input class="btn btn-primary btn-black pull-right" type="submit" value="{{ $button_text }}"/>
						</div>
					</form>

					<div class="clear"></div>
					<!-- This is where now -->
				</div>
    		</div>
		</div>
	</div>

	
	
	
	@section('javascript')

	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
	<script type="text/javascript" src="{{ '/application/application/assets/js/tinymce/tinymce.min.js' }}"></script>
	<script type="text/javascript" src="{{ '/application/application/assets/js/tagsinput/jquery.tagsinput.min.js' }}"></script>
	<script type="text/javascript" src="{{ '/application/application/assets/js/jquery.mask.min.js' }}"></script>

	<script>
		function validateFileType(input) {
		const allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif|\.webp)$/i;
		for (let i = 0; i < input.files.length; i++) {
			const file = input.files[i];
			if (!allowedExtensions.exec(file.name)) {
			document.getElementById('file-type-validation-msg').textContent = '*Incorrect format. Please upload png,jpg,webp or gif.';
			input.value = ''; // Reset the input value to allow the user to upload again
			return false;
			}
		}
		document.getElementById('file-type-validation-msg').textContent = ''; // Clear the message if all files are valid
		return true;
		}
	</script>

	<script type="text/javascript">


	$ = jQuery;

	$(document).ready(function(){




		$('#SubscriptionPlan').hide();
		
		$('#role').change(function() {
			if($(this).val() == 'subscriber') {
				$('#SubscriptionPlan').show();
		    } else {
				$('#SubscriptionPlan').hide();
		    }
		});

		if($('#role').val() == 'subscriber') {
			$('#SubscriptionPlan').show();
		} else {
			$('#SubscriptionPlan').hide();
		}

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
<script>
    $(document).ready(function(){
        // $('#message').fadeOut(120);
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);



		$('form[id="update_profile_form"]').validate({
        rules: {
			username: "required",
			// mobile: "required",
			// passwords: "required",
			// active: "required",
			// avatar : "required",
			email: {
				required: true,
				email: true
			},
        },
        messages: {
            email: "This field is required",
        },
        submitHandler: function (form) {
            form.submit();
        },
    });

    })
</script>
<script>
    function visibility1() {
        var x = document.getElementById('password');
        if (x.type === 'password') {
            x.type = "text";
            $('#eyeShow').show();
            $('#eyeSlash').hide();
        } else {
            x.type = "password";
            $('#eyeShow').hide();
            $('#eyeSlash').show();
        }
    }
</script>
	@stop

@stop
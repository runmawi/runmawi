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
@section('css')
	<style type="text/css">
	.make-switch{
		z-index:2;
	}
        
      
	</style>

@stop

@section('content')


<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<div id="content-page" class="content-page">
         <div class="container-fluid">
              <div class="iq-card">

<div id="admin-container">
	
	<div class="admin-section-title">
		<h4><i class="entypo-globe"></i> Email Settings</h4> 
        <hr>
	</div>
	<div class="clear"></div>

	

	<form method="POST" action="{{ URL::to('admin/email_settings/save') }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">
		
		<div class="row mt-4">
			
			<div class="col-md-6">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
					<div class="panel-title"><label>Admin Email</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body" style="display: block;"> 
						<input type="text" class="form-control" name="admin_email" id="admin_email" value="@if(!empty($email_settings->admin_email)){{ $email_settings->admin_email }}@endif"  />
					</div> 
				</div>
			</div>

			<div class="col-md-6">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
					<div class="panel-title"><label>Email Host</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body" style="display: block;"> 
						<input type="text" class="form-control" name="email_host" id="email_host" value="@if(!empty($email_settings->host_email)){{ $email_settings->host_email }}@endif"  />
					</div> 
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
					<div class="panel-title"><label>Email Port</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body" style="display: block;"> 
						<input type="text" class="form-control" name="email_port" id="email_port" value="@if(!empty($email_settings->email_port)){{ $email_settings->email_port }}@endif" />
					</div> 
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
					<div class="panel-title"><label>Secure </label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body" style="display: block;"> 
	<select id="secure" name="secure" class="form-control" required>
		<option value="TRUE" @if(!empty($email_settings->secure) && $email_settings->secure == 'TRUE'){{ 'selected' }}@endif> TRUE</option>
		<option value="FALSE" @if(!empty($email_settings->secure) && $email_settings->secure == 'FALSE'){{ 'selected' }}@endif >FALSE</option>
	</select>
					</div> 
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
					<div class="panel-title"><label>Email User</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body" style="display: block;"> 
						<input type="text" class="form-control" name="email_user" id="email_user" value="@if(!empty($email_settings->user_email)){{ $email_settings->user_email }}@endif" />
					</div> 
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
					<div class="panel-title"><label>Email Password</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body" style="display: block;"> 
					<input type="password" class="form-control" name="password" id="password" value="" value="@if(!empty($email_settings->email_password)){{ $email_settings->email_password }}@endif"/>
					</div> 
				</div>
			</div>
			
		</div>
		<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
		<div class="panel-body mt-3" style="display: flex;
    justify-content: flex-end;">
<input type="submit" value="Update Email Settings" class="btn btn-primary " />
            </div>
	</form>

        
 

@stop
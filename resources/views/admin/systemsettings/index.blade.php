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
	.has-switch .switch-on label {
			background-color: #FFF;
			color: #000;
			}
	.make-switch{
		z-index:2;
	}
	</style>
@stop


@section('content')
<div id="content-page" class="content-page">
            <div class="container-fluid">
<div class="iq-card">
<div id="admin-container">
<!-- This is where -->
	
	<div class="admin-section-title">
		<h4><i class="entypo-credit-card"></i> Social Login Settings</h4> 
	</div>
  
	<div class="clear mt-3"></div>
	<form method="POST" action="{{ URL::to('admin/system_settings') }}" accept-charset="UTF-8" enctype="multipart/form-data">
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-primary mt-3" data-collapsed="0"> 
                    <div class="panel-heading"> 
					   <h6 class="panel-title">Facebook Login Details </h6> 
                        <div class="panel-options"><small style="color: #000;">To Create Facebook <a href="https://developers.facebook.com/docs/development/create-an-app/" target="_blank">Click Here</a>.</small></div>
                        <hr />   
                    </div>
					<div class="panel-body" style="display: block;"> 
                        <div class="row">
                           <p class="col-md-6"><label>Enable Facebook:</label></p> 
                            <div  class="d-flex justify-content-around align-items-center" style="width:30%;">
                                <div>ON</div>
                                <div>
                            <label class="switch">
  <input name="facebook" type="checkbox"  @if(!isset($system->facebook) || (isset($system->facebook) && $system->facebook))checked="checked" value="1"@else value="0"@endif>
  <span class="slider round"></span>
</label></div>
                                <div>OFF</div>
                                </div>
                           <!-- <div class="make-switch col-md-6" data-on="success" data-off="warning">
				                <input type="checkbox" @if(!isset($system->facebook) || (isset($system->facebook) && $system->facebook))checked="checked" value="1"@else value="0"@endif name="facebook" id="facebook" />
				            </div> -->
                            </div>
                        
						<label>Client ID:</label> 
						<input type="text" class="form-control" name="facebook_client_id" id="facebook_client_id" placeholder="Client ID" value="@if(!empty($system->facebook_client_id) && Auth::user()->role != 'demo'){{ $system->facebook_client_id }}@endif" />

						<br />
						<label>Secrete Key:</label> 
						<input type="text" class="form-control" name="facebook_secrete_key" id="facebook_secrete_key" placeholder="Secrete Key" value="@if(!empty($system->facebook_secrete_key) && Auth::user()->role != 'demo'){{ $system->facebook_secrete_key }}@endif" />

						<br />
						<label>Call Back URL:</label> 
						<input type="text" class="form-control" name="facebook_callback" id="facebook_callback" placeholder="Call Back URL" value="@if(!empty($system->facebook_callback) && Auth::user()->role != 'demo'){{ $system->facebook_callback }}@endif" />

					</div> 
				</div>
            </div>
            <div class="col-md-6 mt-3">
                <div class="panel panel-primary" data-collapsed="0"> 
                    <div class="panel-heading"> 
					    <h6 class="panel-title">Google Login Details </h6> 
                        <div class="panel-options"><small style="color: #000;">To Create Google <a href="https://developers.google.com/identity/sign-in/web/sign-in" target="_blank">Click Here</a>.</small></div>
                        <hr />
                    </div> 
					<div class="panel-body" style="display: block;"> 
                        <div class="row">
                         <p class="col-md-6"><label>Enable Google:</label></p> 
                            <div class="d-flex justify-content-around align-items-center" style="width:30%;">
                                <div>ON</div>
                                <div>
                            <label class="switch">
  <input name="google" type="checkbox" @if(!isset($system->google) || (isset($system->google) && $system->google))checked="checked" value="1"@else value="0"@endif >
  <span class="slider round"></span>
</label></div>
                                <div>OFF</div>
                                </div>
                            <!--<div class="make-switch col-md-6" data-on="success" data-off="warning">
				                <input type="checkbox" @if(!isset($system->google) || (isset($system->google) && $system->google))checked="checked" value="1"@else value="0"@endif name="google" id="google" />
				            </div>-->
                            </div>
                        
						<label>Client ID:</label> 
						<input type="text" class="form-control" name="google_client_id" id="google_client_id" placeholder="Client ID" value="@if(!empty($system->google_client_id) && Auth::user()->role != 'demo'){{ $system->google_client_id }}@endif" />

						<br />
						<label>Secrete Key:</label> 
						<input type="text" class="form-control" name="google_secrete_key" id="google_secrete_key" placeholder="Secrete Key" value="@if(!empty($system->google_secrete_key) && Auth::user()->role != 'demo'){{ $system->google_secrete_key }}@endif" />

						<br />
						<label>Call Back URL:</label> 
						<input type="text" class="form-control" name="google_callback" id="google_callback" placeholder="Call Back URL" value="@if(!empty($system->google_callback) && Auth::user()->role != 'demo'){{ $system->google_callback }}@endif" />

						
					</div> 
				</div>
			</div>		
            
           
		</div>

		<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
		<div class="panel-body mt-3" style="display: flex;
    justify-content: flex-end;">
<input type="submit" value="Update Settings" class="btn btn-primary " />
            </div>
	</form>

	<div class="clear"></div>

</div>
    </div></div>
</div><!-- admin-container -->

@section('javascript')
	<script src="{{ URL::to('/assets/admin/js/bootstrap-switch.min.js') }}"></script>
	<script type="text/javascript">

		$ = jQuery;

		$(document).ready(function(){

			$('input[type="checkbox"]').change(function() {
				$(this).val(this.checked ? 1 : 0);
			});

		});

	</script>

@stop

@stop
@extends('admin.master')

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
		<h3><i class="entypo-credit-card"></i> Social Login Settings</h3> 
	</div>
  
	<div class="clear"></div>
	<form method="POST" action="{{ URL::to('admin/system_settings') }}" accept-charset="UTF-8" enctype="multipart/form-data">
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
					<div class="panel-title">Facebook Login Deatils </div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body" style="display: block;"> 
                        <div class="row">
                           <p class="col-md-6">Enable Facebook:</p> 
                            <div class="make-switch col-md-6" data-on="success" data-off="warning">
				                <input type="checkbox" @if(!isset($system->facebook) || (isset($system->facebook) && $system->facebook))checked="checked" value="1"@else value="0"@endif name="facebook" id="facebook" />
				            </div>
                            </div>
                        
						<p>Client ID:</p> 
						<input type="text" class="form-control" name="facebook_client_id" id="facebook_client_id" placeholder="Client ID" value="@if(!empty($system->facebook_client_id) && Auth::user()->role != 'demo'){{ $system->facebook_client_id }}@endif" />

						<br />
						<p>Secrete Key:</p> 
						<input type="text" class="form-control" name="facebook_secrete_key" id="facebook_secrete_key" placeholder="Secrete Key" value="@if(!empty($system->facebook_secrete_key) && Auth::user()->role != 'demo'){{ $system->facebook_secrete_key }}@endif" />

						<br />
						<p>Call Back URL:</p> 
						<input type="text" class="form-control" name="facebook_callback" id="facebook_callback" placeholder="Call Back URL" value="@if(!empty($system->facebook_callback) && Auth::user()->role != 'demo'){{ $system->facebook_callback }}@endif" />

					</div> 
				</div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
					<div class="panel-title">Google Login Details </div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body" style="display: block;"> 
                        <div class="row">
                         <p class="col-md-6">Enable Google:</p> 
                            <div class="make-switch col-md-6" data-on="success" data-off="warning">
				                <input type="checkbox" @if(!isset($system->google) || (isset($system->google) && $system->google))checked="checked" value="1"@else value="0"@endif name="google" id="google" />
				            </div>
                            </div>
                        
						<p>Client ID:</p> 
						<input type="text" class="form-control" name="google_client_id" id="google_client_id" placeholder="Client ID" value="@if(!empty($system->google_client_id) && Auth::user()->role != 'demo'){{ $system->google_client_id }}@endif" />

						<br />
						<p>Secrete Key:</p> 
						<input type="text" class="form-control" name="google_secrete_key" id="google_secrete_key" placeholder="Secrete Key" value="@if(!empty($system->google_secrete_key) && Auth::user()->role != 'demo'){{ $system->google_secrete_key }}@endif" />

						<br />
						<p>Call Back URL:</p> 
						<input type="text" class="form-control" name="google_callback" id="google_callback" placeholder="Call Back URL" value="@if(!empty($system->google_callback) && Auth::user()->role != 'demo'){{ $system->google_callback }}@endif" />

						
					</div> 
				</div>
			</div>		
            
           

		</div>

		<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
		<input type="submit" value="Update Payment Settings" class="btn btn-primary pull-right" />

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
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
		<h4><i class="entypo-globe"></i> Upddate APP Settings</h4> 
        <hr>
	</div>
	<div class="clear"></div>

	

	<form method="POST" action="{{ URL::to('admin/app_settings/update') }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">
		
		<div class="row mt-4">
			
			<div class="col-md-12">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
					<div class="panel-title"><label>Android URL</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body" style="display: block;"> 
						<input type="text" class="form-control" name="android_url" id="android_url" value="@if(!empty($app_settings->android_url)){{ $app_settings->android_url }}@endif"  />
					</div> 
				</div>
			</div>

			<div class="col-md-12">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
					<div class="panel-title"><label>IOS URL</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body" style="display: block;"> 
						<input type="text" class="form-control" name="ios_url" id="ios_url" value="@if(!empty($app_settings->ios_url)){{ $app_settings->ios_url }}@endif"  />
					</div> 
				</div>
				</div>
				<div class="col-md-12">

				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
					<div class="panel-title"><label>Status</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body" style="display: block;"> 
					<label class="switch">
					<input type="checkbox"  name="status"  id="status" {{ (!empty($app_settings->status)) && $app_settings->status == 1 ? ' checked' : '' }}>
							<span class="slider round"></span>
						</label>
					</div> 
				</div>
		</div>
		<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
		<input type="hidden" name="id" value="<?= $app_settings->id ?>" />
		<div class="panel-body mt-3" style="display: flex;
            justify-content: flex-end;">
        <input type="submit" value="Update APP Settings" class="btn btn-primary " />
                    </div>
	</form>
                  </div>
             </div>
    </div>
</div>

 

@stop
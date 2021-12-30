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
		<h4><i class="entypo-globe"></i> Revenue Settings</h4> 
        <hr>
	</div>
	<div class="clear"></div>

	

	<form method="POST" action="{{ URL::to('admin/revenue_settings/store') }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">
		
		<div class="row mt-4">
			
			<div class="col-md-6">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
					<div class="panel-title"><label>Admin Commission in %</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body" style="display: block;"> 
						<input type="text" class="form-control" name="admin_commission" id="admin_commission" value="@if(!empty($revenue_settings->admin_commission)){{ $revenue_settings->admin_commission }}@endif"  />
					</div> 
				</div>
			</div>

			<div class="col-md-6">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
					<div class="panel-title"><label>User Commission in %</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body" style="display: block;"> 
						<input type="text" class="form-control" name="user_commission" id="user_commission" value="@if(!empty($revenue_settings->user_commission)){{ $revenue_settings->user_commission }}@endif"  />
					</div> 
				</div>
			</div>
			<!-- <div class="col-md-6 mt-3">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
					<div class="panel-title"><label>Admin Commission in %</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body" style="display: block;"> 
						<input type="text" class="form-control" name="vod_admin_commission" id="vod_admin_commission" value="@if(!empty($revenue_settings->vod_admin_commission)){{ $revenue_settings->vod_admin_commission }}@endif" />
					</div> 
				</div>
			</div>
			<div class="col-md-6 mt-3">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
					<div class="panel-title"><label>User Commission in % </label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body" style="display: block;"> 
                    <input type="text" class="form-control" name="vod_user_commission" id="vod_user_commission" value="@if(!empty($revenue_settings->vod_user_commission)){{ $revenue_settings->vod_user_commission }}@endif" />
					</div> 
				</div>
			</div>
			 -->
		</div>
		<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
		<div class="panel-body mt-3" style="display: flex;
            justify-content: flex-end;">
        <input type="submit" value="UpdateRevenue Settings" class="btn btn-primary " />
                    </div>
	</form>
                  </div>
             </div>
    </div>
</div>

 

@stop
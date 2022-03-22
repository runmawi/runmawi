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
     .black{
        color: #000;
        background: #f2f5fa;
        padding: 20px 20px;
border-radius: 0px 4px 4px 0px;
    }
    .black:hover{
        background: #fff;
         padding: 20px 20px;
        color: rgba(66, 149, 210, 1);

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
      <a class="black"  href="{{ URL::to('admin/home-settings') }}">HomePage</a>
    <a class="black" href="{{ URL::to('admin/theme_settings') }}">Theme Settings</a>
    <a class="black" href="{{ URL::to('admin/payment_settings') }}">Payment Settings</a>
    <a class="black" href="{{ URL::to('admin/email_settings') }}">Email Settings</a>
   <a class="black" href="{{ URL::to('admin/mobileapp') }}">Mobile App Settings</a>
    <a class="black"  href="{{ URL::to('admin/system_settings') }}">Social Login Settings</a>
    <div class="mt-4">
    <a class="black" href="{{ URL::to('admin/currency_settings') }}">Currency Settings</a>
     <a class="black" href="{{ URL::to('admin/revenue_settings/index') }}">Revenue Settings</a>  
    <a class="black" href="{{ URL::to('admin/ChooseProfileScreen') }}" class="iq-waves-effect">Profile Screen</a>
    <a class="black" href="{{ URL::to('admin/ThemeIntegration') }}" class="iq-waves-effect">Theme</a>
    </div>
         <div class="container-fluid mt-5">
              <div class="iq-card">

<div id="admin-container">
	
	<div class="admin-section-title">
		<h4><i class="entypo-globe"></i> Update Revenue Settings</h4> 
        <hr>
	</div>
	<div class="clear"></div>

	

	<form method="POST" action="{{ URL::to('admin/revenue_settings/update') }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">
		
		<div class="row mt-4">
			
			<div class="col-md-6">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
					<div class="panel-title"><label>Live Admin Commission in %</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body" style="display: block;"> 
						<input type="text" class="form-control" name="admin_commission" id="admin_commission" value="@if(!empty($revenue_settings->admin_commission)){{ $revenue_settings->admin_commission }}@endif"  />
					</div> 
				</div>
			</div>

			<div class="col-md-6">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
					<div class="panel-title"><label>Live User Commission in %</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body" style="display: block;"> 
						<input type="text" class="form-control" name="user_commission" id="user_commission" value="@if(!empty($revenue_settings->user_commission)){{ $revenue_settings->user_commission }}@endif"  />
					</div> 
				</div>
			</div>
			<div class="col-md-6 mt-3">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
					<div class="panel-title"><label>VOD Admin Commission in %</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body" style="display: block;"> 
						<input type="text" class="form-control" name="vod_admin_commission" id="vod_admin_commission" value="@if(!empty($revenue_settings->vod_admin_commission)){{ $revenue_settings->vod_admin_commission }}@endif" />
					</div> 
				</div>
			</div>
			<div class="col-md-6 mt-3">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
					<div class="panel-title"><label>VOD User Commission in % </label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body" style="display: block;"> 
                    <input type="text" class="form-control" name="vod_user_commission" id="vod_user_commission" value="@if(!empty($revenue_settings->vod_user_commission)){{ $revenue_settings->vod_user_commission }}@endif" />
					</div> 
				</div>
			</div>
			
		</div>
		<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
		<input type="hidden" name="id" value="<?= isset($revenue_settings->id) ?>" />
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
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
    .code_editor{
        min-height:300px;
    }
    </style>
@stop
@section('content')
<div id="content-page" class="content-page">
    <div class="d-flex">
        <a class="black"  href="{{ URL::to('admin/home-settings') }}">HomePage</a>
        <a class="black" style="background:#fafafa!important;color: #006AFF!important;" href="{{ URL::to('admin/theme_settings') }}">Theme Settings</a>
        <a class="black" href="{{ URL::to('admin/payment_settings') }}">Payment Settings</a>
        <a class="black" href="{{ URL::to('admin/email_settings') }}">Email Settings</a>
        <a class="black" href="{{ URL::to('admin/mobileapp') }}">Mobile App Settings</a>
        <a class="black" href="{{ URL::to('admin/settings') }}">RTMP URL Settings</a>
    </div>
   
    <div class="d-flex">
        <a class="black"  href="{{ URL::to('admin/system_settings') }}">Social Login Settings</a>
        <a class="black" href="{{ URL::to('admin/currency_settings') }}">Currency Settings</a>
        <a class="black" href="{{ URL::to('admin/revenue_settings/index') }}">Revenue Settings</a>  
        <a class="black" href="{{ URL::to('admin/ChooseProfileScreen') }}" class="iq-waves-effect">Profile Screen</a>
        <a class="black" href="{{ URL::to('admin/ThemeIntegration') }}" class="iq-waves-effect">Theme</a>
    </div>
    
            <div class="container-fluid p-0">
                <div class="iq-card">
	<div class="admin-section-title">
		<h4><i class="entypo-monitor"></i> Theme Settings for Default Theme</h4> 
	</div>
	<div class="clear"></div>

<form action="{{ URL::to('/admin/theme_settings/save')}}" method="post" enctype="multipart/form-data">
    
    @csrf
		<div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading"> <div class="panel-title"> <p>Site Background Color</p></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
                <div class="panel-body"> 
                        <div class="row mt-4">
                           <div class="col-sm-4">
                                <div class="input-group color-picker" style="width: 50%;">
                                    <label class="mt-2">Dark Mode</label>
                                    <input type="color" class="form-control ml-1"  name="dark_bg_color" data-format="hex" value="{{ $settings->dark_bg_color}}" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group color-picker" style="width: 50%;">
                                    <label class="mt-2">Light Mode</label>
                                    <input type="color" class="form-control ml-1"  name="light_bg_color" data-format="hex" value="{{ $settings->light_bg_color}}" />
                                </div>
                            </div>
                        </div>
                </div> 
            
            
            <div class="panel-heading mt-3"> 
                <div class="panel-title"> <label>Site Logo</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div>
            </div> 
			   <div class="panel-body"> 
                       <div class="row mt-3">
                           <div class="col-sm-6">
                                <div class="input-group color-picker" >
                                    <label class="mt-2">Dark Mode</label>
                                    <input type="file" class="form-control ml-2"  name="dark_mode_logo"  value="" />
                                </div>
                                <img class="mt-3" src="{{ URL::to('/public/uploads/settings/'.$settings->dark_mode_logo)}}">
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group color-picker" >
                                    <label class="mt-2">Light Mode</label>
                                    <input type="file" class="form-control ml-2"  name="light_mode_logo" value="" />   
                                </div>
                                 <img class="mt-3 text-center"  src="{{ URL::to('/public/uploads/settings/'.$settings->light_mode_logo)}}">
                            </div>
                        </div>
            </div> 
                
        </div>
    <div class="panel-body" style="display: flex;
    justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary " name="submit"> Save Settings</button>
                </div>
</form>
    </div></div>
</div>
	<script src="<?= THEME_URL ?>/assets/js/ace/ace.js" type="text/javascript" charset="utf-8"></script>
	<script>
	    var editor = ace.edit("custom_css");
	    editor.setTheme("ace/theme/textmate");
		editor.getSession().setMode("ace/mode/css");

		var textarea = $('textarea[name="custom_css"]').hide();
		editor.getSession().setValue(textarea.val());
		editor.getSession().on('change', function(){
		  textarea.val(editor.getSession().getValue());
		});

		var editor2 = ace.edit("custom_js");
	    editor2.setTheme("ace/theme/textmate");
		editor2.getSession().setMode("ace/mode/javascript");

		var textarea2 = $('textarea[name="custom_js"]').hide();
		editor2.getSession().setValue(textarea2.val());
		editor2.getSession().on('change', function(){
		  textarea2.val(editor2.getSession().getValue());
		});

	</script>

@stop


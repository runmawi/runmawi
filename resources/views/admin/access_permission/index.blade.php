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
    <div class="d-flex">
         <a class="black"  href="{{ URL::to('admin/home-settings') }}">HomePage</a>
        <a class="black" href="{{ URL::to('admin/theme_settings') }}">Theme Settings</a>
        <a class="black" href="{{ URL::to('admin/payment_settings') }}">Payment Settings</a>
        <a class="black" href="{{ URL::to('admin/email_settings') }}">Email Settings</a>
        <a class="black" href="{{ URL::to('admin/mobileapp') }}">Mobile App Settings</a>
        <a class="black" href="{{ URL::to('admin/settings') }}">RTMP URL Settings</a>
    </div>

    <div class="d-flex">
        <a class="black" style="background:#fafafa!important;color: #006AFF!important;"  href="{{ URL::to('admin/system_settings') }}">Social Login Settings</a>
        <a class="black" href="{{ URL::to('admin/currency_settings') }}">Currency Settings</a>
        <a class="black" href="{{ URL::to('admin/revenue_settings/index') }}">Revenue Settings</a>  
        <a class="black" href="{{ URL::to('admin/ChooseProfileScreen') }}" class="iq-waves-effect">Profile Screen</a>
        <a class="black" href="{{ URL::to('admin/ThemeIntegration') }}" class="iq-waves-effect">Theme</a>
    </div>
<div class="container-fluid  p-0">
    <div class="iq-card">
        <div id="admin-container">
        <!-- This is where -->
            
            <div class="admin-section-title">
                <h4><i class="entypo-credit-card"></i> Access Menu & Page Permission Settings</h4> 
            </div>
        
            <div class="clear mt-3"></div>
                <form method="POST" action="{{ URL::to('admin/access_premission/save') }}" accept-charset="UTF-8" enctype="multipart/form-data">
                        <div class="row align-items-center p-2">
                            <div class="col-sm-6">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between"
                                    style="width: ;">
                                    <div><label class="mt-1">Video Channel </label></div>
                                    <div class="mt-1 d-flex align-items-center justify-content-around">
                                        <div class="mr-2">OFF</div>
                                            <label class="switch mt-2">
                                                <input name="Video_Channel_checkout" type="checkbox"
                                                @if( !empty($AdminAccessPermission) && $AdminAccessPermission->Video_Channel_checkout == 1) checked  @endif>
                                                <span class="slider round"></span>
                                            </label>
                                        <div class="ml-2">ON</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between"
                                    style="width: ;">
                                    <div><label class="mt-1">Video Channel Scheduler </label></div>
                                    <div class="mt-1 d-flex align-items-center justify-content-around">
                                        <div class="mr-2">OFF</div>
                                            <label class="switch mt-2">
                                                <input name="Video_Channel_Video_Scheduler_checkout" type="checkbox"
                                                @if( !empty($AdminAccessPermission) && $AdminAccessPermission->Video_Channel_Video_Scheduler_checkout == 1) checked  @endif>
                                                <span class="slider round"></span>
                                            </label>
                                        <div class="ml-2">ON</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between"
                                    style="width: ;">
                                    <div><label class="mt-1">Video Manage Video Playlist </label></div>
                                    <div class="mt-1 d-flex align-items-center justify-content-around">
                                        <div class="mr-2">OFF</div>
                                            <label class="switch mt-2">
                                                <input name="Video_Manage_Video_Playlist_checkout" type="checkbox"
                                                @if( !empty($AdminAccessPermission) && $AdminAccessPermission->Video_Manage_Video_Playlist_checkout == 1) checked  @endif>
                                                <span class="slider round"></span>
                                            </label>
                                        <div class="ml-2">ON</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between"
                                    style="width: ;">
                                    <div><label class="mt-1">Manage Translate Languages </label></div>
                                    <div class="mt-1 d-flex align-items-center justify-content-around">
                                        <div class="mr-2">OFF</div>
                                            <label class="switch mt-2">
                                                <input name="Manage_Translate_Languages_checkout" type="checkbox"
                                                @if( !empty($AdminAccessPermission) && $AdminAccessPermission->Manage_Translate_Languages_checkout == 1) checked  @endif>
                                                <span class="slider round"></span>
                                            </label>
                                        <div class="ml-2">ON</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between"
                                    style="width: ;">
                                    <div><label class="mt-1">Manage Translations Checkout</label></div>
                                    <div class="mt-1 d-flex align-items-center justify-content-around">
                                        <div class="mr-2">OFF</div>
                                            <label class="switch mt-2">
                                                <input name="Manage_Translations_checkout" type="checkbox"
                                                @if( !empty($AdminAccessPermission) && $AdminAccessPermission->Manage_Translations_checkout == 1) checked  @endif>
                                                <span class="slider round"></span>
                                            </label>
                                        <div class="ml-2">ON</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between"
                                    style="width: ;">
                                    <div><label class="mt-1">Audio Page Checkout</label></div>
                                    <div class="mt-1 d-flex align-items-center justify-content-around">
                                        <div class="mr-2">OFF</div>
                                            <label class="switch mt-2">
                                                <input name="Audio_Page_checkout" type="checkbox"
                                                @if( !empty($AdminAccessPermission) && $AdminAccessPermission->Audio_Page_checkout == 1) checked  @endif>
                                                <span class="slider round"></span>
                                            </label>
                                        <div class="ml-2">ON</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between"
                                    style="width: ;">
                                    <div><label class="mt-1">Content Partner Page Checkout </label></div>
                                    <div class="mt-1 d-flex align-items-center justify-content-around">
                                        <div class="mr-2">OFF</div>
                                            <label class="switch mt-2">
                                                <input name="Content_Partner_Page_checkout" type="checkbox"
                                                @if( !empty($AdminAccessPermission) && $AdminAccessPermission->Content_Partner_Page_checkout == 1) checked  @endif>
                                                <span class="slider round"></span>
                                            </label>
                                        <div class="ml-2">ON</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between"
                                    style="width: ;">
                                    <div><label class="mt-1">Header Top Position Checkout </label></div>
                                    <div class="mt-1 d-flex align-items-center justify-content-around">
                                        <div class="mr-2">OFF</div>
                                            <label class="switch mt-2">
                                                <input name="Header_Top_Position_checkout" type="checkbox"
                                                @if( !empty($AdminAccessPermission) && $AdminAccessPermission->Header_Top_Position_checkout == 1) checked  @endif>
                                                <span class="slider round"></span>
                                            </label>
                                        <div class="ml-2">ON</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between"
                                    style="width: ;">
                                    <div><label class="mt-1">Header Side Position Checkout </label></div>
                                    <div class="mt-1 d-flex align-items-center justify-content-around">
                                        <div class="mr-2">OFF</div>
                                            <label class="switch mt-2">
                                                <input name="Header_Side_Position_checkout" type="checkbox"
                                                @if( !empty($AdminAccessPermission) && $AdminAccessPermission->Header_Side_Position_checkout == 1) checked  @endif>
                                                <span class="slider round"></span>
                                            </label>
                                        <div class="ml-2">ON</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between"
                                    style="width: ;">
                                    <div><label class="mt-1">Extract Images Checkout</label></div>
                                    <div class="mt-1 d-flex align-items-center justify-content-around">
                                        <div class="mr-2">OFF</div>
                                            <label class="switch mt-2">
                                                <input name="Extract_Images_checkout" type="checkbox"
                                                @if( !empty($AdminAccessPermission) && $AdminAccessPermission->Extract_Images_checkout == 1) checked  @endif>
                                                <span class="slider round"></span>
                                            </label>
                                        <div class="ml-2">ON</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between"
                                    style="width: ;">
                                    <div><label class="mt-1">Page Permission Checkout </label></div>
                                    <div class="mt-1 d-flex align-items-center justify-content-around">
                                        <div class="mr-2">OFF</div>
                                            <label class="switch mt-2">
                                                <input name="Page_Permission_checkout" type="checkbox"
                                                @if( !empty($AdminAccessPermission) && $AdminAccessPermission->Page_Permission_checkout == 1) checked  @endif>
                                                <span class="slider round"></span>
                                            </label>
                                        <div class="ml-2">ON</div>
                                    </div>
                                </div>
                            </div>
                            

                        </div>
                        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                        <div class="panel-body mt-3" >
                        <input type="submit" value="Update Settings" class="btn btn-primary " />
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

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
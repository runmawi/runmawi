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
        <a class="black" style="background:#fafafa!important;color: #006AFF!important;" href="{{ URL::to('admin/home-settings') }}">HomePage</a>
        <a class="black" href="{{ URL::to('admin/theme_settings') }}">Theme Settings</a>
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
    
    
    <h4><i class="entypo-monitor"></i> Home Page Settings</h4> 
</div>
<div class="clear"></div>


<form action="{{ URL::to('/admin/home-settings/save')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="panel panel-primary mt-3" data-collapsed="0">
            <div class="panel-heading"> <div class="panel-title"><label>Listing Home Page video</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
                <div class="panel-body"> 
                        <div class="row align-items-center p-2">
                        <!-- <div class="row"> -->
                            
                           <div class="col-sm-4">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                <div><label class="mt-1"> Featured Video </label></div>
                              
                                    <div class="mt-1 d-flex align-items-center justify-content-around">
                                          <div class="mr-2">ON</div>
                                        <label class="switch">
                                        <input name="featured_videos" type="checkbox"  @if ($settings->featured_videos == 1) {{ "checked='checked'" }} @else {{ "" }} @endif>
                                        <span class="slider round"></span>
                                        </label>
                                         <div class="ml-2">OFF</div>
                                    </div>
                                   
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                <div><label class="mt-1"> Latest Video </label></div>
                               
                                    <div class="mt-1 d-flex align-items-center justify-content-around">
                                         <div class="mr-2">ON</div>
                                        <label class="switch">
                                        <input type="checkbox"  @if ($settings->latest_videos == 1) {{ "checked='checked'" }} @else {{ "" }} @endif name="latest_videos" id="latest_videos">
                                        <span class="slider round"></span>
                                        </label>
                                        <div class="ml-2">OFF</div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                <div><label class="mt-1"> Category Video </label></div>
                               
                                    <div class="mt-1 d-flex align-items-center justify-content-around">
                                         <div class="mr-2">ON</div>
                                        <label class="switch">
                                        <input  type="checkbox"  name="category_videos"   @if ($settings->category_videos == 1) {{ "checked='checked'" }} @else {{ "" }} @endif>
                                        <span class="slider round"></span>
                                        </label>
                                           <div class="ml-2">OFF</div>
                                    </div>
                                 
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                <div><label class="mt-1"> Live Video </label></div>
                               
                                    <div class="mt-1 d-flex align-items-center justify-content-around">
                                         <div class="mr-2">ON</div>
                                        <label class="switch">
                                        <input type="checkbox"  @if ($settings->live_videos == 1) {{ "checked='checked'" }} @else {{ "" }} @endif name="live_videos" id="live_videos">
                                        <span class="slider round"></span>
                                        </label>
                                        <div class="ml-2">OFF</div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                <div><label class="mt-1"> Audios </label></div>
                                
                                    <div class="mt-1 d-flex align-items-center justify-content-around">
                                        <div class="mr-2">ON</div>
                                        <label class="switch">
                                        <input type="checkbox"  @if ($settings->audios == 1) {{ "checked='checked'" }} @else {{ "" }} @endif name="audios" id="audios">
                                        <span class="slider round"></span>
                                        </label>
                                        <div class="ml-2">OFF</div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                <div><label class="mt-1"> Albums </label></div>
                                
                                    <div class="mt-1 d-flex align-items-center justify-content-around">
                                        <div class="mr-2">ON</div>
                                        <label class="switch">
                                        <input type="checkbox"  @if ($settings->albums == 1) {{ "checked='checked'" }} @else {{ "" }} @endif name="albums" id="albums">
                                        <span class="slider round"></span>
                                        </label>
                                         <div class="ml-2">OFF</div>
                                    </div>
                                   
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                <div><label class="mt-1"> Series </label></div>
                                
                                    <div class="mt-1 d-flex align-items-center justify-content-around">
                                        <div class="mr-2">ON</div>
                                        <label class="switch">
                                        <input type="checkbox"  @if ($settings->series == 1) {{ "checked='checked'" }} @else {{ "" }} @endif name="series" id="series">
                                        <span class="slider round"></span>
                                        </label>
                                        <div class="ml-2">OFF</div>
                                    </div>
                                    
                                </div>
                            </div>
                        <!-- </div> -->
                        

                            <div class="col-sm-4">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                <div><label class="mt-1"> Recommendation  </label></div>
                               
                                    <div class="mt-1 d-flex align-items-center justify-content-around">
                                           <div class="mr-2">OFF</div>
                                        <label class="switch">
                                        <input type="checkbox"  @if ($settings->Recommendation  == 1) {{ "checked='checked'" }} @else {{ "" }} @endif name="Recommendation" id="Recommendation">
                                        <span class="slider round"></span>
                                        </label>
                                        <div class="ml-2">ON</div>
                                    </div>
                                   
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                <div><label class="mt-1"> Auto Intro Skip  </label></div>
                              
                                    <div class="mt-1 d-flex align-items-center justify-content-around">
                                         <div class="mr-2">OFF</div>
                                        <label class="switch">
                                        <input type="checkbox"  @if ($settings->AutoIntro_skip  == 1) {{ "checked='checked'" }} @else {{ "" }} @endif name="AutoIntro_skip" id="AutoIntro_skip">
                                        <span class="slider round"></span>
                                        </label>
                                        <div class="ml-2">ON</div>
                                    </div>
                                   
                                </div>
                            </div>


                        <!-- </div> -->
        </div>
                        
<div class="row">
    <div class="mt-2 p-2"  style="display: flex; justify-content: flex-end;">
        <button type="submit" class="btn btn-primary mt-3" name="submit"> Save Settings</button>
    </div>
</div>

                
</form>
    </div>
</div>
@stop
<script src="<?= THEME_URL ?>/assets/js/ace/ace.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?= THEME_URL ?>/assets/js/admin-homepage.js" type="text/javascript" charset="utf-8"></script>
<script src="{{ URL::to('/assets/admin/js/bootstrap-switch.min.js') }}"></script>
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
<script type="text/javascript">

		$ = jQuery;

		$(document).ready(function(){

			$('input[type="checkbox"]').change(function() {
				$(this).val(this.checked ? 1 : 0);
			});

		});

	</script>
<!--
        <script>
            $(document).ready(function() { 
            $( ".theme_color" ).on("click", function() { 
            if($(this).is(":checked")) {
            $(this).val(1); } else { $(this).val(0);
            }}); $( ".theme_color" ).on("click", function() { 
            if($(this).is(":checked")) {
            $(this).val(1); } else { $(this).val(0);
            }});});
        </script>
-->

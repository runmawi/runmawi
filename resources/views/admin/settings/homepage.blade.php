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
            <div class="container-fluid">
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
                        <div class="row align-items-center">
                        <!-- <div class="row"> -->
                           <div class="col-sm-4">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                <div><label class="mt-1"> Featured Video </label></div>
                                <div>ON</div>
                                    <div class="mt-1">
                                        <label class="switch">
                                        <input name="featured_videos" type="checkbox"  @if ($settings->featured_videos == 1) {{ "checked='checked'" }} @else {{ "" }} @endif>
                                        <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div>OFF</div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                <div><label class="mt-1"> Latest Video </label></div>
                                <div>ON</div>
                                    <div class="mt-1">
                                        <label class="switch">
                                        <input type="checkbox"  @if ($settings->latest_videos == 1) {{ "checked='checked'" }} @else {{ "" }} @endif name="latest_videos" id="latest_videos">
                                        <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div>OFF</div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                <div><label class="mt-1"> Category Video </label></div>
                                <div>ON</div>
                                    <div class="mt-1">
                                        <label class="switch">
                                        <input  type="checkbox"  name="category_videos"   @if ($settings->category_videos == 1) {{ "checked='checked'" }} @else {{ "" }} @endif>
                                        <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div>OFF</div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                <div><label class="mt-1"> Live Video </label></div>
                                <div>ON</div>
                                    <div class="mt-1">
                                        <label class="switch">
                                        <input type="checkbox"  @if ($settings->live_videos == 1) {{ "checked='checked'" }} @else {{ "" }} @endif name="live_videos" id="live_videos">
                                        <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div>OFF</div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                <div><label class="mt-1"> Audios </label></div>
                                <div>ON</div>
                                    <div class="mt-1">
                                        <label class="switch">
                                        <input type="checkbox"  @if ($settings->audios == 1) {{ "checked='checked'" }} @else {{ "" }} @endif name="audios" id="audios">
                                        <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div>OFF</div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                <div><label class="mt-1"> Albums </label></div>
                                <div>ON</div>
                                    <div class="mt-1">
                                        <label class="switch">
                                        <input type="checkbox"  @if ($settings->albums == 1) {{ "checked='checked'" }} @else {{ "" }} @endif name="albums" id="albums">
                                        <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div>OFF</div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                <div><label class="mt-1"> Series </label></div>
                                <div>ON</div>
                                    <div class="mt-1">
                                        <label class="switch">
                                        <input type="checkbox"  @if ($settings->series == 1) {{ "checked='checked'" }} @else {{ "" }} @endif name="series" id="series">
                                        <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div>OFF</div>
                                </div>
                            </div>
                        <!-- </div> -->
                        

                            <div class="col-sm-4">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                <div><label class="mt-1"> Recommendation  </label></div>
                                <div>OFF</div>
                                    <div class="mt-1">
                                        <label class="switch">
                                        <input type="checkbox"  @if ($settings->Recommendation  == 1) {{ "checked='checked'" }} @else {{ "" }} @endif name="Recommendation" id="Recommendation">
                                        <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div>NO</div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                <div><label class="mt-1"> Auto Intro Skip  </label></div>
                                <div>OFF</div>
                                    <div class="mt-1">
                                        <label class="switch">
                                        <input type="checkbox"  @if ($settings->AutoIntro_skip  == 1) {{ "checked='checked'" }} @else {{ "" }} @endif name="AutoIntro_skip" id="AutoIntro_skip">
                                        <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div>NO</div>
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

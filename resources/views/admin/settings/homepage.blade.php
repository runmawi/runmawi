@extends('admin.master')

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
<div class="admin-section-title">
    <h3><i class="entypo-monitor"></i> Home Page Settings</h3> 
</div>
<div class="clear"></div>

<form action="{{ URL::to('/admin/home-settings/save')}}" method="post" enctype="multipart/form-data">
    @csrf
		<div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading"> <div class="panel-title">Listing Home Page video</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
                <div class="panel-body"> 
                        <div class="row">
                           <div class="col-sm-4">
                                <div class="input-group color-picker" style="width: 50%;">
                                    <label> Featured Video </label>
                                     <div class="make-switch" data-on="success" data-off="warning">
                                       
                                            <input type="checkbox" id="checkbox" class="theme_color" name="featured_videos"   value="{{ $settings->featured_videos}}" @if ($settings->featured_videos == 1) {{ "checked='checked'" }} @else {{ "" }} @endif />
                                    </div>
                                </div>
                            </div>    
                            
                            <div class="col-sm-4">
                                <div class="input-group color-picker" style="width: 50%;">
                                    <label> Latest Video </label>
                                      <div class="input-group color-picker" style="width: 20%;">
                                        <div class="make-switch" data-on="success" data-off="warning">
                                            <input type="checkbox" @if ($settings->latest_videos == 1) {{ "checked='checked'" }} @else {{ "" }} @endif name="latest_videos" id="latest_videos"/>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            
                            <div class="col-sm-4">
                                <div class="input-group color-picker" style="width: 50%;">
                                    <label> Category Video </label>
                                       <div class="make-switch" data-on="success" data-off="warning">
                                            <input type="checkbox" id="checkbox" class="theme_color" name="category_videos"   value="{{ $settings->category_videos}}" @if ($settings->category_videos == 1) {{ "checked='checked'" }} @else {{ "" }} @endif />
                                </div>
                            </div>
                        </div>
                </div> 
            
            </div>  
                <div class="panel-body">
                    <button type="submit" class="btn btn-primary mt-3" name="submit"> Save Settings</button>
                </div>
        </div>
</form>
    </div>
</div>
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

@stop


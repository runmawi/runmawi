@extends('admin.master')
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('dropzone/dist/min/dropzone.min.css')}}">

    <!-- JS -->
    <script src="{{asset('dropzone/dist/min/dropzone.min.js')}}" type="text/javascript"></script>
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
	#optionradio {color: #000;}
    #video_upload {margin-top: 5%;}
   .file {
        padding: 30;
        background: rgba(56, 87, 127, 0.34);
        border-radius: 10px;
        text-align: center;
        margin: 0 auto;
        width: 75%;
    }
    #video_upload .file form{border: 2px dashed;}
    #video_upload .file form i {display: block; font-size: 50px;}
</style>
@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/js/tagsinput/jquery.tagsinput.css') }}" />


@stop


@section('content')

<div id="admin-container" style="margin-left: 320px;
    padding-top: 100px;">
<!-- This is where -->
	    <div class="iq-card">
	<div class="admin-section-title">
	@if(!empty($episodes->id))
		<h4>{{ $episodes->title }}</h4> 
		<!-- {{ URL::to('episodes') . '/' . $episodes->id }} -->
		
		<a href="{{ URL::to('episode') . '/' . @$episodes->series_title->title . '/' . $episodes->slug }}" target="_blank" class="btn btn-primary">
			<i class="fa fa-eye"></i> Preview <i class="fa fa-external-link"></i>
		</a>
	@else
		<h4><i class="entypo-plus"></i> Add New Episode</h4> 
	@endif
        <hr>
	</div>
	<div class="clear"></div>
	<div id="episode_uploads">
	<div class='content file'>
			<h4 class="card-title">Upload Full Episode Here</h4>
			<!-- Dropzone -->
			<form action="{{URL::to('admin/episode_upload')}}" method= "post" class='dropzone' ></form> 
		</div> 
	<p style="margin-top: -3%;margin-left: 50%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Trailers Can Be Uploaded From Video Edit Screen</p>
		
	</div> 
	<div class="text-center" id="buttonNext" style="margin-top: 30px;">
	<input type="button" id="Next" value='Proceed to Next Step' class='btn btn-primary'>
	</div>	

	<?php //dd($season_id); ?>

	<div id="episode_video_data">

	<form method="POST" action="{{ $post_route }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data" id="Episode_new">

@if(!empty($episodes->created_at))
	<div class="row mt-4">
		<div class="col-md-9 mt-4">
@endif
			<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title"><label>Title</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body col-sm-6 p-0" style="display: block;"> 
					<p class="p1">Add the episodes title in the textbox below:</p> 
					<input type="text" class="form-control" name="title" id="title" placeholder="Episode Title" value="@if(!empty($episodes->title)){{ $episodes->title }}@endif"  />
				</div> 
			</div>

@if(!empty($episodes->created_at))
	
		</div>
		<div class="col-sm-3">
			<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title">Created Date</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body" style="display: block;"> 
					<p>Select Date/Time Below</p> 
					<input type="text" class="form-control" name="created_at" id="created_at" placeholder="" value="@if(!empty($episodes->created_at)){{ $episodes->created_at }}@endif"/>
				</div> 
			</div>
		</div>
	</div>
@endif

	<div class="row mt-3"> 
	<div class="col-sm-6">
	<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
		<div class="panel-title"><label>Episode Image Cover</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
		<div class="panel-body" style="display: block;"> 
			@if(!empty($episodes->image))
				<img src="{{ Config::get('site.uploads_dir') . 'images/' . $episodes->image }}" class="episodes-img" width="200"/>
			@endif
			<p class="p1">Select the episodes image (1280x720 px or 16:9 ratio):</p> 
			<input type="file" multiple="true" class="form-control" name="image" id="image" />
			
		</div> 
	</div>
	</div>
	<div class="col-sm-6">
		<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
		<div class="panel-title"><label>Episode Ratings</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
		<div class="panel-body col-sm-6 p-0" style="display: block;"> 
			<p class="p1">IMDb Ratings 10 out of 10 </p>
			<input class="form-control" name="rating" id="rating" value="" onkeyup="NumAndTwoDecimals(event , this);"  >
		</div> 
	</div>
	</div>
	</div>

	<!-- <div class="panel panel-primary mt-3" data-collapsed="0"> <div class="panel-heading"> 
		<div class="panel-title"><label>Episode Source</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
		<div class="panel-body col-sm-6 p-0" style="display: block;"> 
			<label for="type" >Episode Format</label>
			<select class="form-control" id="type" name="type">
				<option value="embed">Embed Code</option>
				<option value="file" @if(!empty($episodes->type) && $episodes->type == 'file'){{ 'selected' }}@endif>Episode File</option>
				<option value="upload" @if(!empty($episodes->type) && $episodes->type == 'upload'){{ 'selected' }}@endif>Upload Episode</option>
			</select> -->

		


			<!-- <div class="new-episodes-file" @if(!empty($episodes->type) && $episodes->type == 'file'){{ 'style="display:block"' }}@else style = "display:none" @endif>
				<label for="mp4_url">Mp4 File URL:</label>
				<input type="text" class="form-control" name="mp4_url" id="mp4_url" value="@if(!empty($episodes->mp4_url)){{ $episodes->mp4_url }}@endif" />
			</div>

			<div class="new-episodes-embed" @if(!empty($episodes->type) && $episodes->type == 'embed')style="display:block"@else style = "display:none" @endif>
				<label for="embed_code">Embed Code:</label>
				<textarea class="form-control" name="embed_code" id="embed_code">@if(!empty($episodes->embed_code)){{ $episodes->embed_code }}@endif</textarea>
			</div>

			<div class="new-episodes-upload" @if(!empty($episodes->type) && $episodes->type == 'upload')style="display:block"@else style = "display:none" @endif>
				<label for="embed_code">Upload Episode</label>
				<input type="file" name="episode_upload" id="episode_upload">
			</div>
			@if(!empty($episodes->type) && ($episodes->type == 'upload' || $episodes->type == 'file'))
			<video width="200" height="200" controls>
			<source src="{{ $episodes->mp4_url }}" type="video/mp4">
			</video>
			@endif
			@if(!empty($episodes->type) && $episodes->type == 'embed')
			<iframe src="{{ $episodes->mp4_url }}"></iframe>
			@endif
		</div> 
	</div> -->
		<div class="panel-body col-sm-6 p-0" style="display: block;"> 
			<label><h6>Age Restrict :</h6></label>
		<select class="form-control" id="age_restrict" name="age_restrict">
				<option selected disabled="">Choose Age</option>
				@foreach($age_categories as $age)
					<option value="{{ $age->id }}" @if(!empty($episodes->age_restrict) && $episodes->age_restrict == $age->id)selected="selected"@endif>{{ $age->slug }}</option>
				@endforeach
			</select>
	</div>

	<div class="row align-items-center"> 
		<div class="col-sm-4"> 
			<div class="panel panel-primary" data-collapsed="0"> 
				<div class="panel-heading"> <div class="panel-title"> <label>Skip Intro Time</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
			<p>Please Give In Seconds</p> 
				<div class="panel-body"> 
					<input class="form-control" name="skip_intro" id="skip_intro" value="@if(!empty($episodes->skip_intro)){{ $episodes->skip_intro }}@endif" >
				</div> 
			</div>
		</div>
		<div class="col-sm-4">
			<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title">Intro Start Time</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
			<p>Please Give In Seconds</p> 
				<div class="panel-body col-sm-6 p-0" style="display: block;"> 
				<input class="form-control" name="intro_start_time" id="intro_start_time" value="@if(!empty($episodes->intro_start_time)){{ $episodes->intro_start_time }}@endif" >
				</div> 
			</div>
		</div>
		<div class="col-sm-4">
			<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title">Intro End Time</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
			<p>Please Give In Seconds</p> 
				<div class="panel-body col-sm-6 p-0" style="display: block;"> 
				<input class="form-control" name="intro_end_time" id="intro_end_time" value="@if(!empty($episodes->intro_end_time)){{ $episodes->intro_end_time }}@endif" >
				</div> 
			</div>
		</div>

		</div>

		<div class="row align-items-center"> 
		<div class="col-sm-4"> 
			<div class="panel panel-primary" data-collapsed="0"> 
			<div class="panel-heading"> <div class="panel-title"> <label>Skip Recap Time</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<p>Please Give In Seconds</p> 
				<div class="panel-body"> 
					<input class="form-control" name="skip_recap" id="skip_recap" value="@if(!empty($episodes->skip_recap)){{ $episodes->skip_recap }}@endif" >
			</div>
		</div>
		</div>

		<div class="col-sm-4 mt-3">
			<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
			<div class="panel-title">Recap Start Time</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
			<p>Please Give In Seconds</p> 
				<div class="panel-body col-sm-6 p-0" style="display: block;"> 
				<input class="form-control" name="recap_start_time" id="recap_start_time" value="@if(!empty($episodes->recap_start_time)){{ $episodes->recap_start_time }}@endif" >
				</div> 
			</div>
		</div>
		<div class="col-sm-4 mt-3">
			<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
			<div class="panel-title">Recap End Time</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
			<p>Please Give In Seconds</p> 
				<div class="panel-body col-sm-6 p-0" style="display: block;"> 
				<input class="form-control" name="recap_end_time" id="recap_end_time" value="@if(!empty($episodes->recap_end_time)){{ $episodes->recap_end_time }}@endif" >
			</div>	 
			</div>
		</div>
		</div>

	<div class="clear"></div>

	<div class="row align-items-center"> 

		<div class="col-sm-4"> 
			<div class="panel panel-primary" data-collapsed="0"> 
				<div class="panel-heading"> <div class="panel-title"> <label>Duration</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body"> 
					<p class="p1">Enter the episode duration in the following format (Hours : Minutes : Seconds)</p> 
					<input class="form-control" name="duration" id="duration" value="@if(!empty($episodes->duration)){{ gmdate('H:i:s', $episodes->duration) }}@endif" >
				</div> 
			</div>
		</div>

		<div class="col-sm-4 mt-3"> 
			<div class="panel panel-primary" data-collapsed="0"> 
				<div class="panel-heading"> <div class="panel-title"> <label>User Access</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body"> 
					<p class="p1">Who is allowed to view this episode?</p>
					<select id="access" class="form-control" name="access">
						<option value="guest" @if(!empty($episodes->access) && $episodes->access == 'guest'){{ 'selected' }}@endif>Guest (everyone)</option>
						<option value="registered" @if(!empty($episodes->access) && $episodes->access == 'registered'){{ 'selected' }}@endif>Registered Users (free registration must be enabled)</option>
						<option value="subscriber" @if(!empty($episodes->access) && $episodes->access == 'subscriber'){{ 'selected' }}@endif>Subscriber (only paid subscription users)</option>
						<?php if($settings->ppv_status == 1){ ?>
						<!-- <option value="ppv" >PPV Users (Pay per movie)</option>    -->
						<?php } else{ ?>
						<!-- <option value="ppv" >PPV Users (Pay per movie)</option>    -->
						<?php } ?>
					</select>
					<div class="clear"></div>
				</div> 
			</div>
		</div>

		<div class="col-sm-4"> 
			<div class="panel panel-primary" data-collapsed="0"> 
				<div class="panel-heading"> <div class="panel-title"> <label>Status Settings</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body"> 
					<div style="display: flex;
						justify-content: start;
						align-items: baseline;">
						<label for="featured" style="float:left; display:block; margin-right:10px;">Is this episode Featured:</label>
						<input type="checkbox" @if(!empty($episodes->featured) && $episodes->featured == 1){{ 'checked="checked"' }}@endif name="featured" value="1" id="featured" />
					</div>
					<div class="clear"></div>
					<div style="display: flex;
						justify-content: start;
						align-items: baseline;">
						<label for="active" style="float:left; display:block; margin-right:10px;">Is this episode Active:</label>
						<input type="checkbox" @if(!empty($episodes->active) && $episodes->active == 1){{ 'checked="checked"' }}@elseif(!isset($episodes->active)){{ 'checked="checked"' }}@endif name="active" value="1" id="active" />
					</div>
					<div class="clear"></div>
					<div style="display: flex;
						justify-content: start;
						align-items: baseline;">
						<label for="banner" style="float:left; display:block; margin-right:10px;">Is this episode display in Banner:</label>
						<input type="checkbox" @if(!empty($episodes->banner) && $episodes->banner == 1){{ 'checked="checked"' }}@endif name="banner" value="1" id="banner" />
					</div>
					<div class="clear"></div>
					<div style="display: flex;
						justify-content: start;
						align-items: baseline;">
						<label for="footer" style="float:left; display:block; margin-right:10px;">Is this episode display in Footer:</label>
						<input type="checkbox" @if(!empty($episodes->footer) && $episodes->footer == 1){{ 'checked="checked"' }}@endif name="footer" value="1" id="footer" />
					</div>
				</div> 
			</div>
		</div>
		</div>

		<div class="row align-items-center"> 

			<!-- <div class="col-sm-4" id="ppv_price"> 
				<div class="panel panel-primary" data-collapsed="0"> 
					<div class="panel-heading"> <div class="panel-title"> <label>PPV Price :</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<input type="text" class="form-control" placeholder="PPV Price" name="ppv_price" id="price" >
		
				</div>
			</div> -->

			<!-- <div class="col-sm-4 mt-3"> 
				<div class="panel panel-primary" data-collapsed="0"> 
					<div class="panel-heading"> <div class="panel-title"> <label>Is this video Is PPV:</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<?php //if($settings->ppv_status == 1){ ?>
					<input type="checkbox" name="ppv_status" value="1" id="ppv_status" />
					<?php// } else{ ?>
						<div class="global_ppv_status">
					<input type="checkbox" name="ppv_status" value="1" id="ppv_status" />
						</div>
						<?php //} ?>
						<div class="clear"></div>
					</div> 
				</div> -->

		@if(isset($series->id))
		<input type="hidden" id="series_id" name="series_id" value="{{ $series->id }}" />
	@endif

	<!-- @if(isset($episodes->id))
		<input type="hidden" id="season_id" name="season_id" value="{{ $season_id }}" />
	@endif -->


	@if(isset($episodes->id))
		<input type="hidden" id="id" name="id" value="{{ $episodes->id }}" />
	@endif
	<input type="hidden" id="episode_id" name="episode_id" value="">

	<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
	<input type="hidden" id="season_id" name="season_id" value="{{ $season_id }}" />
		
	</div><!-- row -->

<div class="mt-3" style="display: flex;
justify-content: flex-end;">
			 <input type="submit" id="submit" value="{{ $button_text }}" class="btn btn-primary pull-right" /></div>
	

</form>
</div>
		<div class="clear"></div>
		<!-- Manage Season -->
            <div class="p-4">
		@if(!empty($episodes))
		<h5>Season & Episodes</h5> 
		<div class="admin-section-title">
		
		<div class="row">

		<table class="table table-striped genres-table">

		<tr class="table-header">
			<th>Seasons</th>
			<th>Episodes</th>
			<th>Operation</th>
			
			@foreach($episodes as $key=>$episode)
			<tr>
				<td valign="bottom"><p>Season {{$key+1}}</p></td>
				<td valign="bottom"><p>{{$episode->title}}</p></td>
				<td>
					<p>
						<a href="{{ URL::to('admin/episode/edit') . '/' . $episode->id }}" class="btn btn-xs btn-info"><span class="fa fa-edit"></span> Edit</a>
						<a href="{{ URL::to('admin/episode/delete') . '/' . $episode->id }}" class="btn btn-xs btn-danger delete"><span class="fa fa-trash"></span> Delete</a>
					</p>
				</td>
			</tr>
			@endforeach
	</table>

		<div class="clear"></div>

		
		</div>
		</div>
		@endif
<!-- This is where now -->
</div>

	
	</div>
	
	@section('javascript')

	<script type="text/javascript" src="{{ URL::to('/assets/admin/js/tinymce/tinymce.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::to('/assets/js/tagsinput/jquery.tagsinput.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::to('/assets/js/jquery.mask.min.js') }}"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>                       
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />
    <script>
        $('#intro_start_time').datetimepicker(
        {
            format: 'hh:mm '
        });
        $('#intro_end_time').datetimepicker(
        {
            format: 'hh:mm '
        });
        $('#recap_start_time').datetimepicker(
        {
            format: 'hh:mm '
        });
        $('#recap_end_time').datetimepicker(
        {
            format: 'hh:mm '
        });
</script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="<?= URL::to('/assets/js/jquery.mask.min.js');?>"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>


<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script>

$('form[id="Episode_new"]').validate({
	rules: {
	  title: 'required',
	  image: 'required',
	},
	messages: {
	  title: 'This field is required',
	  image: 'This field is required',
	},
	submitHandler: function(form) {
	  form.submit();
	}
  });

</script>

	<script type="text/javascript">

	$ = jQuery;
	$(document).ready(function($){
    
    $('#duration').mask("00:00:00");

});
	$(document).ready(function(){

		$('#duration').mask('00:00:00');
		$('#tags').tagsInput();

		$('#type').change(function(){
			if($(this).val() == 'file'){
				$('.new-episodes-file').show();
				$('.new-episodes-embed').hide();
				$('.new-episodes-upload').hide();

			} else if($(this).val() == 'embed'){ 
				$('.new-episodes-file').hide();
				$('.new-episodes-embed').show();
				$('.new-episodes-upload').hide();

			}else{
				$('.new-episodes-file').hide();
				$('.new-episodes-embed').hide();
				$('.new-episodes-upload').show();
				
			}
		});

		tinymce.init({
			relative_urls: false,
		    selector: '#details',
		    toolbar: "styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | preview media | forecolor backcolor | code",
		    plugins: [
		         "advlist autolink link image code lists charmap print preview hr anchor pagebreak spellchecker code fullscreen",
		         "save table contextmenu directionality emoticons template paste textcolor code"
		   ],
		   menubar:false,
		 });

	});

	function NumAndTwoDecimals(e , field) {
		var val = field.value;
		var re = /^([0-9]+[\.]?[0-9]?[0-9]?|[0-9]+)$/g;
		var re1 = /^([0-9]+[\.]?[0-9]?[0-9]?|[0-9]+)/g;
		if (re.test(val)) {
			if(val > 10){
				alert("Maximum value allowed is 10");
				field.value = "";
			}
		} else {
			val = re1.exec(val);
			if (val) {
				field.value = val[0];
			} else {
				field.value = "";
			}
		}

	}

	</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<script>
	// alert();
	$(document).ready(function(){
$('#ppv_price').hide();    
	$("#access").change(function(){
		if($(this).val() == 'ppv'){
			$('#ppv_price').show();
			$('#global_ppv_status').show();

		}else{
			$('#ppv_price').hide();		
			$('#global_ppv_status').hide();				

		}
	});
});

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{asset('dropzone/dist/min/dropzone.min.js')}}" type="text/javascript"></script>
<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

<script>
CKEDITOR.replace( 'summary-ckeditor', {
	filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
	filebrowserUploadMethod: 'form'
});
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
// alert('test');
$('#buttonNext').hide();
$('#episode_video_data').hide();
$('#submit').hide();


Dropzone.autoDiscover = false;
var myDropzone = new Dropzone(".dropzone",{ 
  //   maxFilesize: 900,  // 3 mb
	maxFilesize: 500,
	acceptedFiles: "video/mp4,video/x-m4v,video/*",
});
myDropzone.on("sending", function(file, xhr, formData) {
   formData.append("_token", CSRF_TOKEN);
  // console.log(value)
  this.on("success", function(file, value) {
		console.log(value.video_title);
		$('#buttonNext').show();
	   $('#episode_id').val(value.episode_id);
	   $('#title').val(value.episode_title);
	});
}); 
$('#buttonNext').click(function(){
$('#episode_uploads').hide();
$('#Next').hide();
$('#episode_video_data').show();
$('#submit').show();
});
</script>

	@stop

	@section('javascript')


	@stop
@stop

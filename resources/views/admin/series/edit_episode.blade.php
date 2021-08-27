@extends('admin.master')

@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/js/tagsinput/jquery.tagsinput.css') }}" />
@stop


@section('content')

<div id="admin-container" style="margin-left: 340px;
    padding-top: 100px;">
<!-- This is where -->
	
	<div class="admin-section-title">
	@if(!empty($episodes->id))
		<h4>{{ $episodes->title }}</h4> 
		<a href="{{ URL::to('episodes') . '/' . $episodes->id }}" target="_blank" class="btn btn-info">
			<i class="fa fa-eye"></i> Preview <i class="fa fa-external-link"></i>
		</a>
	@else
		<h3><i class="entypo-plus"></i> Add New Episode</h3> 
	@endif
	</div>
	<div class="clear"></div>

	

		<form method="POST" action="{{ $post_route }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">

		@if(!empty($episodes->created_at))
			<div class="row">
				<div class="col-md-6">
		@endif
					<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
						<div class="panel-title">Title</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body col-sm-8 p-0" style="display: block;"> 
							<p>Add the episodes title in the textbox below:</p> 
							<input type="text" class="form-control" name="title" id="title" placeholder="Episode Title" value="@if(!empty($episodes->title)){{ $episodes->title }}@endif" style=""  />
						</div> 
					</div>

		@if(!empty($episodes->created_at))
			
				</div>
				<div class="col-sm-6">
					<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
						<div class="panel-title">Created Date</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body col-sm-6 p-0" style="display: block;"> 
							<p>Select Date/Time Below</p> 
							<input type="text" class="form-control" name="created_at" id="created_at" placeholder="" value="@if(!empty($episodes->created_at)){{ $episodes->created_at }}@endif"  />
						</div> 
					</div>
				</div>
			</div>
		@endif

			<div class="row"> 
			<div class="col-sm-6">
			<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title">Episode Image Cover</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body col-sm-6 p-0" style="display: block;"> 
					@if(!empty($episodes->image))
						<img src="{{ URL::to('/') . '/public/uploads/images/' . $episodes->image }}" class="episodes-img" width="200"/>
					@endif
					<p>Select the episodes image (1280x720 px or 16:9 ratio):</p> 
					<input type="file" multiple="true" class="form-control" name="image" id="image" />
					
				</div> 
			</div>
			</div>
			<div class="col-sm-6">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title">Episode Ratings</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body col-sm-6 p-0" style="display: block;"> 
					IMDb Ratings 10 out of 10
					<input class="form-control" name="rating" id="rating" value="@if(!empty($episodes->rating)){{ $episodes->rating }}@endif" onkeyup="NumAndTwoDecimals(event , this);"  >
				</div> 
			</div>
			</div>
			</div>

			<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title">Episode Source</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body" style="display: block;"> 
					<label for="type" style="float:left; margin-right:10px; padding-top:1px;">Episode Format</label>
					<select id="type" name="type">
						<option value="embed">Embed Code</option>
						<option value="file" @if(!empty($episodes->type) && $episodes->type == 'file'){{ 'selected' }}@endif>Episode File</option>
						<option value="upload" @if(!empty($episodes->type) && $episodes->type == 'upload'){{ 'selected' }}@endif>Upload Episode</option>
					</select>
					<hr />

					<div class="new-episodes-file" @if(!empty($episodes->type) && $episodes->type == 'file'){{ 'style="display:block"' }}@else style = "display:none" @endif>
						<label for="mp4_url">Mp4 File URL:</label>
						<input type="text" class="form-control" name="mp4_url" id="mp4_url" value="@if(!empty($episodes->mp4_url)){{ $episodes->mp4_url }}@endif" />
						<hr />
						
					</div>

					<div class="new-episodes-embed" @if(!empty($episodes->type) && $episodes->type == 'embed')style="display:block"@else style = "display:none" @endif>
						<label for="embed_code">Embed Code:</label>
						<textarea class="form-control" name="embed_code" id="embed_code">@if(!empty($episodes->embed_code)){{ $episodes->embed_code }}@endif</textarea>
					</div>
                            @error('episode_upload')
                                <div class="alert alert-danger">{{ $episode_upload }}</div>
                            @enderror
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
			</div>

			<div class="clear"></div>

			<div class="clear"></div>


			<div class="row"> 

				<div class="col-sm-4"> 
					<div class="panel panel-primary" data-collapsed="0"> 
						<div class="panel-heading"> <div class="panel-title"> Duration</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body"> 
							<p>Enter the episode duration in the following format (Hours : Minutes : Seconds)</p> 
							<input class="form-control" name="duration" id="duration" value="@if(!empty($episodes->duration)){{ gmdate('H:i:s', $episodes->duration) }}@endif"  >
						</div> 
					</div>
				</div>

				<div class="col-sm-4"> 
					<div class="panel panel-primary" data-collapsed="0"> 
						<div class="panel-heading"> <div class="panel-title"> User Access</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body"> 
							<label for="access" style="float:left; margin-right:10px;">Who is allowed to view this episode?</label>
							<select id="access" name="access">
								<option value="guest" @if(!empty($episodes->access) && $episodes->access == 'guest'){{ 'selected' }}@endif>Guest (everyone)</option>
								<option value="registered" @if(!empty($episodes->access) && $episodes->access == 'registered'){{ 'selected' }}@endif>Registered Users (free registration must be enabled)</option>
								<option value="subscriber" @if(!empty($episodes->access) && $episodes->access == 'subscriber'){{ 'selected' }}@endif>Subscriber (only paid subscription users)</option>
							</select>
							<div class="clear"></div>
						</div> 
					</div>
				</div>

				<div class="col-sm-4"> 
					<div class="panel panel-primary" data-collapsed="0"> 
						<div class="panel-heading"> <div class="panel-title"> Status Settings</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body"> 
							<div>
								<label for="featured" style="float:left; display:block; margin-right:10px;">Is this episode Featured:</label>
								<input type="checkbox" @if(!empty($episodes->featured) && $episodes->featured == 1){{ 'checked="checked"' }}@endif name="featured" value="1" id="featured" />
							</div>
							<div class="clear"></div>
							<div>
								<label for="active" style="float:left; display:block; margin-right:10px;">Is this episode Active:</label>
								<input type="checkbox" @if(!empty($episodes->active) && $episodes->active == 1){{ 'checked="checked"' }}@elseif(!isset($episodes->active)){{ 'checked="checked"' }}@endif name="active" value="1" id="active" />
							</div>
							<div class="clear"></div>
							<div>
								<label for="banner" style="float:left; display:block; margin-right:10px;">Is this episode display in Banner:</label>
								<input type="checkbox" @if(!empty($episodes->banner) && $episodes->banner == 1){{ 'checked="checked"' }}@endif name="banner" value="1" id="banner" />
							</div>
							<div class="clear"></div>
							<div>
								<label for="footer" style="float:left; display:block; margin-right:10px;">Is this episode display in Footer:</label>
								<input type="checkbox" @if(!empty($episodes->footer) && $episodes->footer == 1){{ 'checked="checked"' }}@endif name="footer" value="1" id="footer" />
							</div>
						</div> 
					</div>
				</div>
                <div class="p-3">
                @if(isset($series->id))
				<input type="hidden" id="series_id" name="series_id" value="{{ $episodes->series_id }}" />
			@endif

			@if(isset($season_id))
				<input type="hidden" id="season_id" name="season_id" value="{{ $episodes->season_id }}" />
			@endif


			@if(isset($episodes->id))
				<input type="hidden" id="id" name="id" value="{{ $episodes->id }}" />
			@endif

			<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
			<input type="submit" value="{{ $button_text }}" class="btn btn-success pull-right" />
</div>
			</div><!-- row -->

			
		</form>

		<div class="clear"></div>
	
</div>

	
	
	
	@section('javascript')


	<script type="text/javascript" src="{{ URL::to('/assets/admin/js/tinymce/tinymce.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::to('/assets/js/tagsinput/jquery.tagsinput.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::to('/assets/js/jquery.mask.min.js') }}"></script>

	<script type="text/javascript">

	$ = jQuery;

	$(document).ready(function(){

		$('#duration').mask('00:00:00');
		//$('#tags').tagsInput();

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

	@stop

@stop

@extends('admin.master')

@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/js/tagsinput/jquery.tagsinput.css') }}" />
@stop


@section('content')

<div id="admin-container">
<!-- This is where -->
	
	<div class="admin-section-title">
	@if(!empty($audio->id))
		<h3>{{ $audio->title }}</h3> 
		<a href="{{ URL::to('audio') . '/' . $audio->id }}" target="_blank" class="btn btn-black">
			<i class="fa fa-eye"></i> Preview <i class="fa fa-external-link"></i>
		</a>
	@else
		<h3><i class="entypo-plus"></i> Add New Audio</h3> 
	@endif
	</div>
	<div class="clear"></div>

	

		<form method="POST" action="{{ $post_route }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">

			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
						<div class="panel-title">Title</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body" style="display: block;"> 
							<p>Add the audio title in the textbox below:</p> 
							<input type="text" class="form-control" name="title" id="title" placeholder="Audio Title" value="@if(!empty($audio->title)){{ $audio->title }}@endif" />
						</div> 
					</div>
					</div>
				<div class="col-sm-3">
					<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
						<div class="panel-title">Slug</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body" style="display: block;"> 
							<p>Add the Audio slug:</p> 
							<input type="text" class="form-control" name="slug" id="slug" placeholder="" value="@if(!empty($audio->slug)){{ $audio->slug }}@endif" />
						</div> 
					</div>
				</div>
		@if(!empty($audio->created_at))
			
				
				<div class="col-sm-3">
					<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
						<div class="panel-title">Created Date</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body" style="display: block;"> 
							<p>Select Date/Time Below</p> 
							<input type="text" class="form-control" name="created_at" id="created_at" placeholder="" value="@if(!empty($audio->created_at)){{ $audio->created_at }}@endif" />
						</div> 
					</div>
				</div>
			
		@endif
</div>

			<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title">Audio Image Cover</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body" style="display: block;"> 
					@if(!empty($audio->image))
						<img src="{{ Config::get('site.uploads_dir') . 'images/' . $audio->image }}" class="audio-img" width="200"/>
					@endif
					<p>Select the audio image (1280x720 px or 16:9 ratio):</p> 
					<input type="file" multiple="true" class="form-control" name="image" id="image" />
					
				</div> 
			</div>

			<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title">Audio Source</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body" style="display: block;"> 
					<label for="type" style="float:left; margin-right:10px; padding-top:1px;">Audio Format</label>
					<select id="type" name="type" class="form-control">
						<option value="file" @if(!empty($audio->type) && $audio->type == 'file'){{ 'selected' }}@endif>Audio File</option>
						<option value="upload" @if(!empty($audio->type) && $audio->type == 'upload'){{ 'selected' }}@endif>Upload Audio</option>
					</select>
					<hr />

					<div class="new-audio-file" @if(!empty($audio->type) && $audio->type == 'file'){{ 'style="display:block"' }}@endif>
						<label for="mp3_url">Mp3 File URL:</label>
						<input type="text" class="form-control" name="mp3_url" id="mp3_url" value="@if(!empty($audio->mp3_url)){{ $audio->mp3_url }}@endif" />
					</div>

					<div class="new-audio-upload" @if(!empty($audio->type) && $audio->type == 'upload')style="display:block"@else style = "display:none" @endif>
						<label for="upload">Upload Audio</label>
						<input type="file" name="audio_upload" id="audio_upload">
					</div>
					@if(!empty($audio->type) && ($audio->type == 'upload' || $audio->type == 'file'))
					<br>
                    <audio width="200" height="200" controls>
					<source src="{{ $audio->mp3_url }}" type="audio/mp3">
					</audio>
					@endif
				</div> 
			</div>

			
			<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title">Audio Details, Links, and Info</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body" style="display: block;">
					<textarea class="form-control" name="details" id="details">@if(!empty($audio->details)){{ htmlspecialchars($audio->details) }}@endif</textarea>
				</div> 
			</div>

			<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title">Short Description</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body" style="display: block;"> 
					<p>Add a short description of the audio below:</p> 
					<textarea class="form-control" name="description" id="description">@if(!empty($audio->description)){{ htmlspecialchars($audio->description) }}@endif</textarea>
				</div> 
			</div>
			<div class="row"> 
			<div class="col-sm-6">
			<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title">Category</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body" style="display: block;"> 
					<p>Select a Audio Category Below:</p>
					<select id="audio_category_id" name="audio_category_id" class="form-control">
						<option value="0">Uncategorized</option>
						@foreach($audio_categories as $category)
							<option value="{{ $category->id }}" @if(!empty($audio->audio_category_id) && $audio->audio_category_id == $category->id)selected="selected"@endif>{{ $category->name }}</option>
						@endforeach
					</select>
				</div> 
			</div>
			</div>
			<div class="col-sm-6">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title">Audio Ratings</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body" style="display: block;"> 
					IMDb Ratings 10 out of 10
					<input class="form-control" name="rating" id="rating" value="@if(!empty($audio->rating)){{ $audio->rating }}@endif" onkeyup="NumAndTwoDecimals(event , this);">
				</div> 
			</div>
			</div>
			</div>

			<div class="row"> 
			<div class="col-sm-6">
			<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title">Language</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body" style="display: block;"> 
					<p>Select a Audio Language Below:</p>
					<select class="form-control" id="language" name="language">
						@foreach($languages as $language)
							<option value="{{ $language->id }}" @if(!empty($audio->language) && $audio->language == $language->id)selected="selected"@endif>{{ $language->language }}</option>
						@endforeach
					</select>
				</div> 
			</div>
			</div>
			<div class="col-sm-6">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title">Audio Year</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body" style="display: block;"> 
					Audio Released Year
					<input class="form-control" name="year" id="year" value="@if(!empty($audio->year)){{ $audio->year }}@endif">
				</div> 
			</div>
			</div>
			</div>

			<div class="clear"></div>


			<div class="row"> 

				<div class="col-sm-4"> 
					<div class="panel panel-primary" data-collapsed="0"> 
						<div class="panel-heading"> <div class="panel-title"> Duration</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body"> 
							<p>Enter the audio duration in the following format (Hours : Minutes : Seconds)</p> 
							<input class="form-control" name="duration" id="duration" value="@if(!empty($audio->duration)){{ gmdate('H:i:s', $audio->duration) }}@endif">
						</div> 
					</div>
				</div>

				<div class="col-sm-4"> 
					<div class="panel panel-primary" data-collapsed="0"> 
						<div class="panel-heading"> <div class="panel-title"> User Access</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body"> 
							<label for="access" style="float:left; margin-right:10px;">Who is allowed to view this audio?</label>
							<select id="access" name="access" class="form-control">
								<option value="guest" @if(!empty($audio->access) && $audio->access == 'guest'){{ 'selected' }}@endif>Guest (everyone)</option>
								<option value="registered" @if(!empty($audio->access) && $audio->access == 'registered'){{ 'selected' }}@endif>Registered Users (free registration must be enabled)</option>
								<option value="subscriber" @if(!empty($audio->access) && $audio->access == 'subscriber'){{ 'selected' }}@endif>Subscriber (only paid subscription users)</option>
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
								<label for="featured" style="float:left; display:block; margin-right:10px;">Is this audio Featured:</label>
								<input type="checkbox" @if(!empty($audio->featured) && $audio->featured == 1){{ 'checked="checked"' }}@endif name="featured" value="1" id="featured" />
							</div>
							<div class="clear"></div>
							<div>
								<label for="banner" style="float:left; display:block; margin-right:10px;">Is this Audio display in Banner:</label>
								<input type="checkbox" @if(!empty($audio->banner) && $audio->banner == 1){{ 'checked="checked"' }}@endif name="banner" value="1" id="banner" />
							</div>
							<div class="clear"></div>
							<div>
								<label for="active" style="float:left; display:block; margin-right:10px;">Is this audio Active:</label>
								<input type="checkbox" @if(!empty($audio->active) && $audio->active == 1){{ 'checked="checked"' }}@elseif(!isset($audio->active)){{ 'checked="checked"' }}@endif name="active" value="1" id="active" />
							</div>
						</div> 
					</div>
				</div>

			</div><!-- row -->

			@if(!isset($audio->user_id))
				<input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}" />
			@endif

			@if(isset($audio->id))
				<input type="hidden" id="id" name="id" value="{{ $audio->id }}" />
			@endif

			<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
			<input type="submit" value="{{ $button_text }}" class="btn btn-black pull-right" />

		</form>

		<div class="clear"></div>
<!-- This is where now -->
</div>

	
	
	
	@section('javascript')


	<script type="text/javascript" src="{{ '/flicknexs/application/assets/admin/js/tinymce/tinymce.min.js' }}"></script>
	<script type="text/javascript" src="{{ '/flicknexs/application/assets/js/tagsinput/jquery.tagsinput.min.js' }}"></script>
	<script type="text/javascript" src="{{ '/flicknexs/application/assets/js/jquery.mask.min.js' }}"></script>

	<script type="text/javascript">

	$ = jQuery;

	$(document).ready(function(){

		$('#duration').mask('00:00:00');
		$('#tags').tagsInput();

		$('#type').change(function(){
			if($(this).val() == 'file'){
				$('.new-audio-file').show();
				$('.new-audio-upload').hide();

			}else{
				$('.new-audio-file').hide();
				$('.new-audio-upload').show();
				
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



	</script>

	@stop

@stop

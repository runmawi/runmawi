@extends('admin.master')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop

<style>
   
    .p1{
        font-size: 12px!important;
    }

	span{
		color: gray;
	}
	.progress { position:relative; width:100%; }
	.bar { background-color: #008000; width:0%; height:20px; }
	.percent { position:absolute; display:inline-block; left:50%; color: #7F98B2;}
	[data-tip] {
		position:relative;

	}
	.subtitle1{
		display: flex;
		justify-content: space-between;
		width: 50%;
	}
	[data-tip]:before {
		content:'';
		/* hides the tooltip when not hovered */
		display:none;
		content:'';
		border-left: 5px solid transparent;
		border-right: 5px solid transparent;
		border-bottom: 5px solid #1a1a1a;	
		position:absolute;

		z-index:8;
		font-size:0;
		line-height:0;
		width:0;
		height:0;
	}
	[data-tip]:after {
		display:none;
		content:attr(data-tip);
		position:absolute;

		padding:5px 8px;
		background:#1a1a1a;
		color:#fff;
		z-index:9;
		font-size: 0.75em;
		height:18px;
		line-height:18px;
		-webkit-border-radius: 3px;
		-moz-border-radius: 3px;
		border-radius: 3px;
		white-space:nowrap;
		word-wrap:normal;
	}
	[data-tip]:hover:before,
	[data-tip]:hover:after {
		display:block;
	}
	.select2{
		visibility: visible !important;
	}
</style>

@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="http://malsup.github.com/jquery.form.js"></script>

<div id="content-page" class="content-page">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<div class="iq-card">
					<div class="iq-card-header d-flex justify-content-between">
						<div class="iq-header-title">
							<h4 class="card-title">Add Audio</h4>
						</div>
					</div>
					<div class="iq-card-body">
						<h5>Audio Info Details</h5>
						<form method="POST" action="{{ $post_route }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">

							<div class="row mt-3">
								<div class="col-md-6">
									<div class="panel panel-primary " data-collapsed="0"> <div class="panel-heading"> 
										<div class="panel-title"><label>Title</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
										<div class="panel-body" style="display: block;"> 
											<p class="p1">Add the audio title in the textbox below:</p> 
											<input type="text" class="form-control" name="title" id="title" placeholder="Audio Title" value="@if(!empty($audio->title)){{ $audio->title }}@endif" />
										</div> 
									</div>
								</div>
								<div class="col-sm-3">
									<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
										<div class="panel-title"><label>Slug</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
										<div class="panel-body" style="display: block;"> 
											<p class="p1">Add the Audio slug:</p> 
											<input type="text" class="form-control" name="slug" id="slug" placeholder="" value="@if(!empty($audio->slug)){{ $audio->slug }}@endif" />
										</div> 
									</div>
								</div>
								@if(!empty($audio->created_at))


								<div class="col-sm-3">
									<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
										<div class="panel-title"><label>Created Date</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
										<div class="panel-body" style="display: block;"> 
											<p class="p1">Select Date/Time Below</p> 
											<input type="text" class="form-control" name="created_at" id="created_at" placeholder="" value="@if(!empty($audio->created_at)){{ $audio->created_at }}@endif" />
										</div> 
									</div>
								</div>

								@endif
							</div>

							<div class="panel panel-primary col-sm-6 p-0 mt-3" data-collapsed="0"> <div class="panel-heading"> 
								<div class="panel-title"><label>Audio Image Cover</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
								<div class="panel-body" style="display: block;"> 
									@if(!empty($audio->image))
									<img src="{{ Config::get('site.uploads_dir') . 'images/' . $audio->image }}" class="audio-img" width="200"/>
									@endif
									<p class="p1">Select the audio image (1280x720 px or 16:9 ratio):</p> 
									<input type="file" multiple="true" class="form-control" name="image" id="image" />

								</div> 
							</div>

							<div class="panel panel-primary  mt-3" data-collapsed="0"> <div class="panel-heading"> 
								<div class="panel-title"><label>Audio Source</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
								<div class="panel-body" style="display: block;"> 
									<label for="type" class="mt-2" style="float:left; margin-right:10px; padding-top:1px;">Audio Format</label>
									<select id="type" name="type" class="form-control">
										<option value="file" @if(!empty($audio->type) && $audio->type == 'file'){{ 'selected' }}@endif>Audio File</option>
										<option value="upload" @if(!empty($audio->type) && $audio->type == 'upload'){{ 'selected' }}@endif>Upload Audio</option>
									</select>
								

									<div class="new-audio-file mt-3" @if(!empty($audio->type) && $audio->type == 'file'){{ 'style="display:block"' }}@endif>
										<label for="mp3_url"><label>Mp3 File URL:</label></label>
										<input type="text" class="form-control" name="mp3_url" id="mp3_url" value="@if(!empty($audio->mp3_url)){{ $audio->mp3_url }}@endif" />
									</div>

									<div class="new-audio-upload mt-3" @if(!empty($audio->type) && $audio->type == 'upload')style="display:block"@else style = "display:none" @endif>
										<label  for="upload">Upload Audio</label>
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


								<div class="panel panel-primary mt-3" data-collapsed="0"> <div class="panel-heading"> 
									<div class="panel-title"><label>Audio Details, Links, and Info</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
									<div class="panel-body" style="display: block;">
										<textarea class="form-control" name="details" id="details">@if(!empty($audio->details)){{ htmlspecialchars($audio->details) }}@endif</textarea>
									</div> 
								</div>

								<div class="panel panel-primary mt-3" data-collapsed="0"> <div class="panel-heading"> 
									<div class="panel-title"><label>Short Description</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
									<div class="panel-body" style="display: block;"> 
										<p class="p1">Add a short description of the audio below:</p> 
										<textarea class="form-control" name="description" id="description">@if(!empty($audio->description)){{ htmlspecialchars($audio->description) }}@endif</textarea>
									</div> 
								</div>
								<div class="row mt-3"> 
									<div class="col-sm-6">
										<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
											<div class="panel-title"><label>Cast and Crew</label> </div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
											<div class="panel-body" style="display: block;"> 
												<p>Add artists for the audio below:</p> 
												<select name="artists[]" class="js-example-basic-multiple" style="width: 100%;" multiple="multiple">
													@foreach($artists as $artist)
													@if(in_array($artist->id, $audio_artist))
													<option value="{{ $artist->id }}" selected="true">{{ $artist->artist_name }}</option>
													@else
													<option value="{{ $artist->id }}">{{ $artist->artist_name }}</option>
													@endif 
													@endforeach
												</select>

											</div> 
										</div>
									</div>
									<div class="col-sm-6">
										<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
											<div class="panel-title"><label>Album</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
											<div class="panel-body" style="display: block;"> 
												<p class="p1">Select a Audio Album Below:</p>
												<select id="album_id" name="album_id" class="form-control">
													@foreach($audio_albums as $albums)
													<option value="{{ $albums->id }}" @if(!empty($audio->album_id) && $audio->album_id == $albums->id)selected="selected"@endif>{{ $albums->albumname }}</option>
													@endforeach
												</select>
											</div> 
										</div>
									</div>
									</div>
								<div class="row p-0 mt-3 align-items-center"> 
									<div class="col-sm-6">
										<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
											<div class="panel-title"><label>Category</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
											<div class="panel-body" style="display: block;"> 
												<p class="p1">Select a Audio Category Below:</p>
												<select id="audio_category_id" name="audio_category_id" class="form-control">
													@foreach($audio_categories as $category)
													<option value="{{ $category->id }}" @if(!empty($audio->audio_category_id) && $audio->audio_category_id == $category->id)selected="selected"@endif>{{ $category->name }}</option>
													@endforeach
												</select>
											</div> 
										</div>
									</div>
									<div class="col-sm-6">
										<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
											<div class="panel-title"><label>Audio Ratings</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
											<div class="panel-body" style="display: block;"> 
                                                <p class="p1"> IMDB Ratings 10 out of 10</p>
												<input class="form-control" name="rating" id="rating" value="@if(!empty($audio->rating)){{ $audio->rating }}@endif" onkeyup="NumAndTwoDecimals(event , this);">
											</div> 
										</div>
									</div>
								</div>

								<div class="row mt-3"> 
									<div class="col-sm-6">
										<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
											<div class="panel-title"><label>Language</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
											<div class="panel-body" style="display: block;"> 
												<p class="p1">Select a Audio Language Below:</p>
												<select class="form-control" id="language" name="language">
													@foreach($languages as $language)
													<option value="{{ $language->id }}" @if(!empty($audio->language) && $audio->language == $language->id)selected="selected"@endif>{{ $language->language }}</option>
													@endforeach
												</select>
											</div> 
										</div>
									</div>
									<div class="col-sm-6 ">
										<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
											<div class="panel-title"><label>Audio Year</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
											<div class="panel-body" style="display: block;"> 
                                                <p class="p1">Audio Released Year</p>
												<input class="form-control" name="year" id="year" value="@if(!empty($audio->year)){{ $audio->year }}@endif">
											</div> 
										</div>
									</div>
								</div>

								<div class="clear"></div>


								<div class="row mt-3 align-items-center"> 

									<div class="col-sm-4"> 
										<div class="panel panel-primary" data-collapsed="0"> 
											<div class="panel-heading"> <div class="panel-title"><label> Duration</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
											<div class="panel-body"> 
												<p class="p1">Enter the audio duration in the following format (Hours : Minutes : Seconds)</p> 
												<input class="form-control" name="duration" id="duration" value="@if(!empty($audio->duration)){{ gmdate('H:i:s', $audio->duration) }}@endif">
											</div> 
										</div>
									</div>

									<div class="col-sm-4"> 
										<div class="panel panel-primary" data-collapsed="0"> 
											<div class="panel-heading"> <div class="panel-title"> <label>User Access</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
											<div class="panel-body"> 
												<p class="p1">Who is allowed to view this audio?</p>
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
											<div class="panel-heading"> <div class="panel-title"><label> Status Settings</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
											<div class="panel-body"> 
												<div class="d-flex align-items-baseline">
													<label for="featured" style="float:left; display:block; margin-right:10px;">Is this audio Featured:</label>
													<input type="checkbox" @if(!empty($audio->featured) && $audio->featured == 1){{ 'checked="checked"' }}@endif name="featured" value="1" id="featured" />
												</div>
												<div class="clear"></div>
												<div class="d-flex align-items-baseline">
													<label for="banner" style="float:left; display:block; margin-right:10px;">Is this Audio display in Banner:</label>
													<input type="checkbox" @if(!empty($audio->banner) && $audio->banner == 1){{ 'checked="checked"' }}@endif name="banner" value="1" id="banner" />
												</div>
												<div class="clear"></div>
												<div class="d-flex align-items-baseline">
													<label for="active" style="float:left; display:block; margin-right:10px;">Is this audio Active:</label>
													<input type="checkbox" @if(!empty($audio->active) && $audio->active == 1){{ 'checked="checked"' }}@elseif(!isset($audio->active)){{ 'checked="checked"' }}@endif name="active" value="1" id="active" />
												</div>
											</div> 
										</div>
									</div>
                                    @if(!isset($audio->user_id))
								<input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}" />
								@endif

								@if(isset($audio->id))
								<input type="hidden" id="id" name="id" value="{{ $audio->id }}" />
								@endif
                                   
								</div><!-- row -->

								 <div class="mt-2 p-2"  style="display: flex;
    justify-content: flex-end;">
                                    
								<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
								<input type="submit" value="{{ $button_text }}" class="btn btn-primary pull-right" />
                                    </div>
							</form>

							<div class="clear"></div>
							<!-- This is where now -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<script type="text/javascript">

		$ = jQuery;

		$(document).ready(function(){
			$('.js-example-basic-multiple').select2();
			$('#duration').mask('00:00:00');

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
	@section('javascript')
	@stop

	@stop
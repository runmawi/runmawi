@extends('moderator.master')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop

<style>
   
    .p1{
        font-size: 12px!important;
    }

	.error{
        color: red;
		font-size : 14px !important;
    }

	span{
		color: gray;
	}
    .select2-selection__rendered{
        background-color: #141414!important;
    }
    .select2-container--default.select2-container--focus .select2-selection--multiple{
        border:none!important;
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

	.tags-input-wrapper input{
		border: 1px solid transparent;
		height: 45px;
		position: relative;
		font-size: 14px;
		width: 100%;
		-webkit-border-radius: 6px;
		height: 45px;
		border-radius: 4px;
		/* margin-bottom: 20px; */
		padding-left: 10px;
		font-family: 'Inter';
		font-style: normal;
		font-weight: 400;
		line-height: 19px;
		color: #646464!important;
		background:rgba(250, 250, 250, 1)
	}

	.tags-input-wrapper .tag{
		display: inline-block;
		background-color: #20222c;
		color: white;
		border-radius: 40px;
		padding: 0px 3px 0px 7px;
		margin-right: 5px;
		margin-bottom:5px;
		box-shadow: 0 5px 15px -2px rgba(250 , 14 , 126 , .7)
	}

	.tags-input-wrapper .tag a {
		margin: 0 7px 3px;
		display: inline-block;
		cursor: pointer;
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
						<form method="POST" id="audio_edit" action="{{ $post_route }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">

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

							<div class="row">
								<div class="col-md-6">
									<div class="panel panel-primary mt-3" data-collapsed="0"> 
										<div class="panel-heading"> 
											<div class="panel-title">
												<label class="mb-1">Audio Image Cover</label> 

												@php 
													$width = $compress_image_settings->width_validation_audio;
													$heigth = $compress_image_settings->height_validation_audio

												@endphp
												@if($width !== null && $heigth !== null)
													<p class="p1">{{ ("Select The Audio Image (".''.$width.' x '.$heigth.'px)')}}:</p> 
												@else
													<p class="p1">{{ "Select The Audio Image ( 9:16 Ratio or 1080X1920px )"}}:</p> 
												@endif
											</div> 
											<div class="panel-options"> 
												<a href="#" data-rel="collapse">
													<i class="entypo-down-open"></i>
												</a> 
											</div>
										</div> 
										<div class="panel-body" style="display: block;"> 
											
											<input type="file" multiple="true" class="form-control" name="image" id="image" />
											<span>
												<p id="audio_image_error_msg" style="color:red !important; display:none;">
													* Please upload an image with the correct dimensions.
												</p>
											</span>
											@if(!empty($audio->image))
												<img src="{{ URL::to('/'). '/public/uploads/images/' . $audio->image }}" class="audio-img" width="200"/>
											@endif
										</div> 
									</div>
								</div><br><br>
								<div class="col-sm-6 mt-3">
									<label class="mb-1">Player Audio Thumbnail </label>
									@php 
										$player_width = $compress_image_settings->audio_player_img_width;
										$player_heigth = $compress_image_settings->audio_player_img_height

									@endphp
									@if($player_width !== null && $player_heigth !== null)
									<p class="p1">{{ ("Select The Audio Image (".''.$player_width.' x '.$player_heigth.'px)')}}:</p> 
									@else
										<p class="p1">{{ "Select The Audio Image ( 16:9 Ratio or 1280X720px )"}}:</p> 
									@endif

									<input type="file" name="player_image" id="player_image" >
									<span>
										<p id="audio_player_image_error_msg" style="color:red !important; display:none;">
											* Please upload an image with the correct dimensions.
										</p>
									</span>
									@if(!empty($audio->player_image))
									<div class="col-sm-8 p-0">
										<img src="{{ URL::to('/') . '/public/uploads/images/' . $audio->player_image }}" class="video-img w-100 mt-1" />
									</div>
									@endif
								</div>
							</div>

							<div class="row container-fluid">
								<div class="col-md-8">
									<div class="panel panel-primary col-sm-8 p-0 mt-3" data-collapsed="0"> 
										<div class="panel-heading"> 
											<div class="panel-title">	
												<label class="mb-1">Upload Audio Lyrics</label>
											</div> 
											<div class="panel-options"> 
												<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> 
											</div>
										</div> 
										<span>(Ex:xlsx <a href="{{ URL::to('public/uploads/audiolyrics/SampleLyrics.xlsx') }}" target="_blank">Sample Lyrics File</a>)</span>
										<div class="panel-body" style="display: block;padding-top: 13px;"> 
											@if(!empty($audio->lyrics))
											<div class=" p-0 mb-1">
												<a href='{{ $audio->lyrics }}' target="_blank">Download Uploaded Lyrics File</a>
											</div> 
											@endif
											<input type="file" name="lyrics" id="lyrics" >
											<span class="error-message text-danger"></span>
										</div>	
									</div>
								</div>
							</div>

							{{-- for validate --}} 
							<input type="hidden" id="check_image" name="check_image" value="@if(!empty($audio->image) ) {{ "validate" }} @else {{ " " }} @endif"  />
							<input type="hidden" id="player_check_image" name="player_check_image" value="@if(!empty($audio->player_image) ) {{ "validate" }} @else {{ " " }} @endif"  />

							<div class="panel panel-primary  mt-3" data-collapsed="0"> <div class="panel-heading"> 
								<!-- <div class="panel-title"><label>Audio Source</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>  -->
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
									<div class="panel panel-primary mt-3 col-sm-6 p-0" data-collapsed="0"> <div class="panel-heading"> 
										<div class="panel-title"><label> Search Tag </label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
										<div class="panel-body" style="display: block;"> 
											<input type="text" id="tag-input1" name="searchtags">
										</div> 
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
												<!-- <select id="audio_category_id" name="audio_category_id" class="form-control">
													@foreach($audio_categories as $category)
													<option value="{{ $category->id }}" @if(!empty($audio->audio_category_id) && $audio->audio_category_id == $category->id)selected="selected"@endif>{{ $category->name }}</option>
													@endforeach
												</select> -->
											<select class="form-control js-example-basic-multiple"  name="audio_category_id[]"  id="audio_category_id"  multiple="multiple" >
												@foreach($audio_categories as $category)
												@if(in_array($category->id, $category_id))
												<option value="{{ $category->id }}" selected="true">{{ $category->name }}</option>
												@else
												<option value="{{ $category->id }}">{{ $category->name }}</option>
												@endif      
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
												<!-- <input class="form-control" name="rating" id="rating" value="@if(!empty($audio->rating)){{ $audio->rating }}@endif" onkeyup="NumAndTwoDecimals(event , this);"> -->
												<select  class="js-example-basic-single" style="width: 100%;" name="rating" id="rating" tags= "true" onkeyup="NumAndTwoDecimals(event , this);" >
													<option value="1" {{ $audio->rating == '1' ? 'selected':'' }} >1</option>
													<option value="2" {{ $audio->rating == '2' ? 'selected':'' }} >2</option>
													<option value="3" {{ $audio->rating == '3' ? 'selected':'' }} >3</option>
													<option value="4" {{ $audio->rating == '4' ? 'selected':'' }} >4</option>
													<option value="5" {{ $audio->rating == '5' ? 'selected':'' }} >5</option>
													<option value="6" {{ $audio->rating == '6' ? 'selected':'' }} >6</option>
													<option value="7" {{ $audio->rating == '7' ? 'selected':'' }} >7</option>
													<option value="8" {{ $audio->rating == '8' ? 'selected':'' }} >8</option>
													<option value="9" {{ $audio->rating == '9' ? 'selected':'' }} >9</option>
													<option value="10"{{ $audio->rating == '10' ? 'selected':'' }} >10</option>
												</select>
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
												<!-- <select class="form-control" id="language" name="language">
													@foreach($languages as $language)
													<option value="{{ $language->id }}" @if(!empty($audio->language) && $audio->language == $language->id)selected="selected"@endif>{{ $language->language }}</option>
													@endforeach
												</select> -->
											<select class="form-control js-example-basic-multiple" id="language" name="language[]"  style="width: 100%;" multiple="multiple" >
												@foreach($languages as $language)
												@if(in_array($language->id, $languages_id))
												<option value="{{ $language->id }}" selected="true">{{ $language->name }}</option>
												@else
												<option value="{{ $language->id }}" >{{ $language->name }}</option>					
												@endif 
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
													@if($settings->ppv_status == 1)
														<option value="ppv" @if(!empty($audio->access) && $audio->access == 'ppv'){{ 'selected' }}@endif>PPV Users (Pay per movie)</option>   
													@else
														<option value="ppv" @if(!empty($audio->access) && $audio->access == 'ppv'){{ 'selected' }}@endif>PPV Users (Pay per movie)</option>   
													@endif
												</select>
												<div class="clear"></div>
											</div> 
										</div>
									</div>

									<div class="row col-sm-12" id="ppv_price"> 
										<div class="col-sm-6">
											<label class="p2">PPV Price:</label>
											<input type="text" class="form-control" placeholder="PPV Price" name="ppv_price" id="price" value="@if(!empty($audio->ppv_price)){{ $audio->ppv_price }}@endif">
										</div>

										<div class="col-sm-6">
											<label class="p2"> IOS PPV Price:</label>
											<select  name="ios_ppv_price" class="form-control" id="ios_ppv_price">
												<option value= "" >Select IOS PPV Price: </option>
												@foreach($InappPurchase as $Inapp_Purchase)
													<option value="{{ $Inapp_Purchase->product_id }}"  @if($audio->ios_ppv_price == $Inapp_Purchase->product_id) selected='selected' @endif >{{ $Inapp_Purchase->plan_price }}</option>
												@endforeach
											 </select>										
										</div>
									</div>
									<div class="clear"></div>

									<div class="col-sm-6"> 
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
	</div>

	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<script type="text/javascript" src="{{ URL::to('assets/js/jquery.mask.min.js') }}"></script>

	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

	<script>

	$(document).ready(function() {
    // Attach a click event listener to the upload button
    $("#lyrics").on("change", function() {
        // Create a FormData object to send the file and CSRF token via AJAX
        const formData = new FormData();
        formData.append("lyrics", $("#lyrics")[0].files[0]);
        formData.append("_token", '{{ csrf_token() }}'); // Add the CSRF token

        // Make an AJAX request to the Laravel controller
        $.ajax({
            url:  '{{ URL::to('admin/audios/lyricsFileValidation') }}', // Replace with the actual controller endpoint
            type: "POST",
            data: formData,
            contentType: false, // Set to false to let jQuery set it automatically
            processData: false, // Set to false to prevent jQuery from processing the data
            success: function(response) {
                // Handle the success response from the server
							if(response == 1){
								// alert(response);
								$('.error-message').hide();
								$('#audio_edit').off('submit').on('submit', function(e) {
								});
								return true;
				   				$('#audio_edit').submit();
							}else{
								$('.error-message').show();
								$(".error-message").text(response);
								$('#audio_edit').off('submit').on('submit', function(e) {
									e.preventDefault();
								});
								// e.preventDefault();

								// allowFormSubmission = false;

								return false; // Validate as required if the condition is met
							}
            },
            error: function(xhr, status, error) {
                // Handle the error response from the server
                console.log("Error: " + error);
            }
        });
    });
	$('#audio_edit').on('submit', function(e) {
        // Prevent form submission if the flag is false
        if (!allowFormSubmission) {
            e.preventDefault();
        }
    });
});
		                    // Image upload dimention validation
		// $.validator.addMethod('dimention', function(value, element, param) {
        //     if(element.files.length == 0){
        //         return true; 
        //     }

        //     var width = $(element).data('imageWidth');
        //     var height = $(element).data('imageHeight');
        //     var ratio = $(element).data('imageratio');
		// 	var image_validation_status = "{{  image_validation_audio() }}" ;

        //     if( image_validation_status == "0" || ratio == '0.56' || width == param[0] && height == param[1]){
        //         return true;
        //     }else{
        //         return false;
        //     }
        // },'Please upload an image with 1080 x 1920 pixels dimension or 9:16 ratio');

        //         // player Image upload validation
        // $.validator.addMethod('player_dimention', function(value, element, param) {
        //     if(element.files.length == 0){
        //         return true; 
        //     }

        //     var width = $(element).data('imageWidth');
        //     var height = $(element).data('imageHeight');
        //     var ratio = $(element).data('imageratio');
		// 	var image_validation_status = "{{  image_validation_audio() }}" ;

        //     if(image_validation_status == "0" || ratio == '1.78' || width == param[0] && height == param[1]){
        //         return true;
        //     }else{
        //         return false;
        //     }
        // },'Please upload an image with 1280 x 720 pixels dimension or 16:9 ratio');


        // $('#image').change(function() {

        //     $('#image').removeData('imageWidth');
        //     $('#image').removeData('imageHeight');
        //     $('#image').removeData('imageratio');

        //     var file = this.files[0];
        //     var tmpImg = new Image();

        //     tmpImg.src=window.URL.createObjectURL( file ); 
        //     tmpImg.onload = function() {
        //         width = tmpImg.naturalWidth,
        //         height = tmpImg.naturalHeight;
		// 		ratio =  Number(width/height).toFixed(2) ;

        //         $('#image').data('imageWidth', width);
        //         $('#image').data('imageHeight', height);
        //         $('#image').data('imageratio', ratio);

        //     }
        // });

        // $('#player_image').change(function() {

        //     $('#player_image').removeData('imageWidth');
        //     $('#player_image').removeData('imageHeight');
        //     $('#player_image').removeData('imageratio');

        //     var file = this.files[0];
        //     var tmpImg = new Image();

        //     tmpImg.src=window.URL.createObjectURL( file ); 
        //     tmpImg.onload = function() {
        //         width = tmpImg.naturalWidth,
        //         height = tmpImg.naturalHeight;
		// 		ratio =  Number(width/height).toFixed(2) ;

        //         $('#player_image').data('imageWidth', width);
        //         $('#player_image').data('imageHeight', height);
        //         $('#player_image').data('imageratio', ratio);

        //     }
        // });

		$('form[id="audio_edit"]').validate({
			rules: {
				title : 'required',
				album_id : 'required',
				'language[]': {
					required: true
				},

				image: {
					required: '#check_image:blank',
					dimention:[1080,1920]
				},

				player_image: {
					required: '#player_check_image:blank',
					player_dimention:[1280,720]
				},

			},
			
	
			submitHandler: function(form) {
			form.submit();
			}
		});

	</script>

	{{-- image validation --}}

<script>
    document.getElementById('image').addEventListener('change', function() {
        var file = this.files[0];
        if (file) {
            var img = new Image();
            img.onload = function() {
                var width = img.width;
                var height = img.height;
                console.log(width);
                console.log(height);
                
                var validWidth = {{ $compress_image_settings->width_validation_audio }};
                var validHeight = {{ $compress_image_settings->height_validation_audio }};
                console.log(validWidth);
                console.log(validHeight);

                if (width !== validWidth || height !== validHeight) {
                    document.getElementById('audio_image_error_msg').style.display = 'block';
                    $('.pull-right').prop('disabled', true);
                    document.getElementById('audio_image_error_msg').innerText = 
                        `* Please upload an image with the correct dimensions (${validWidth}x${validHeight}px).`;
                } else {
                    document.getElementById('audio_image_error_msg').style.display = 'none';
                    $('.pull-right').prop('disabled', false);
                }
            };
            img.src = URL.createObjectURL(file);
        }
    });

    document.getElementById('player_image').addEventListener('change', function() {
        var file = this.files[0];
        if (file) {
            var img = new Image();
            img.onload = function() {
                var width = img.width;
                var height = img.height;
                console.log(width);
                console.log(height);
                
                var validWidth = {{ $compress_image_settings->audio_player_img_width }};
                var validHeight = {{ $compress_image_settings->audio_player_img_height }};
                console.log(validWidth);
                console.log(validHeight);

                if (width !== validWidth || height !== validHeight) {
                    document.getElementById('audio_player_image_error_msg').style.display = 'block';
                    $('.pull-right').prop('disabled', true);
                    document.getElementById('audio_player_image_error_msg').innerText = 
                        `* Please upload an image with the correct dimensions (${validWidth}x${validHeight}px).`;
                } else {
                    document.getElementById('audio_player_image_error_msg').style.display = 'none';
                    $('.pull-right').prop('disabled', false);
                }
            };
            img.src = URL.createObjectURL(file);
        }
    });
</script>

	<script type="text/javascript">

		$ = jQuery;

		$(document).ready(function(){
			$('.js-example-basic-multiple').select2();
			$('.js-example-basic-single').select2();
			$('#ppv_price').hide();
			$('#global_ppv_status').hide();
			

			if($("#access").val() == 'ppv'){
				$('#ppv_price').show();
				$('#global_ppv_status').show();

			}else{
				$('#ppv_price').hide();		
				$('#global_ppv_status').hide();				

			}
		$("#access").change(function(){
			if($(this).val() == 'ppv'){
				// alert($(this).val());
				$('#ppv_price').show();
				$('#global_ppv_status').show();

			}else{
				$('#ppv_price').hide();		
				$('#global_ppv_status').hide();				

			}
		});


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
$('#duration').mask('00:00:00');
	</script>

	{{-- Search Tag --}}

	<script>
		(function() {
	
			"use strict"
	
			// Plugin Constructor
			var TagsInput = function(opts) {
				this.options = Object.assign(TagsInput.defaults, opts);
				this.init();
			}
	
			// Initialize the plugin
			TagsInput.prototype.init = function(opts) {
				this.options = opts ? Object.assign(this.options, opts) : this.options;
	
				if (this.initialized)
					this.destroy();
	
				if (!(this.orignal_input = document.getElementById(this.options.selector))) {
					console.error("tags-input couldn't find an element with the specified ID");
					return this;
				}
	
				this.arr = [];
				this.wrapper = document.createElement('div');
				this.input = document.createElement('input');
				init(this);
				initEvents(this);
	
				this.initialized = true;
				return this;
			}
	
			// Add Tags
			TagsInput.prototype.addTag = function(string) {
	
				if (this.anyErrors(string))
					return;
	
				this.arr.push(string);
				var tagInput = this;
	
				var tag = document.createElement('span');
				tag.className = this.options.tagClass;
				tag.innerText = string;
	
				var closeIcon = document.createElement('a');
				closeIcon.innerHTML = '&times;';
	
				// delete the tag when icon is clicked
				closeIcon.addEventListener('click', function(e) {
					e.preventDefault();
					var tag = this.parentNode;
	
					for (var i = 0; i < tagInput.wrapper.childNodes.length; i++) {
						if (tagInput.wrapper.childNodes[i] == tag)
							tagInput.deleteTag(tag, i);
					}
				})
	
	
				tag.appendChild(closeIcon);
				this.wrapper.insertBefore(tag, this.input);
				this.orignal_input.value = this.arr.join(',');
	
				return this;
			}
	
			// Delete Tags
			TagsInput.prototype.deleteTag = function(tag, i) {
				tag.remove();
				this.arr.splice(i, 1);
				this.orignal_input.value = this.arr.join(',');
				return this;
			}
	
			// Make sure input string have no error with the plugin
			TagsInput.prototype.anyErrors = function(string) {
				if (this.options.max != null && this.arr.length >= this.options.max) {
					console.log('max tags limit reached');
					return true;
				}
	
				if (!this.options.duplicate && this.arr.indexOf(string) != -1) {
					console.log('duplicate found " ' + string + ' " ')
					return true;
				}
	
				return false;
			}
	
			// Add tags programmatically 
			TagsInput.prototype.addData = function(array) {
				var plugin = this;
	
				array.forEach(function(string) {
					plugin.addTag(string);
				})
				return this;
			}
	
			// Get the Input String
			TagsInput.prototype.getInputString = function() {
				return this.arr.join(',');
			}
	
			// destroy the plugin
			TagsInput.prototype.destroy = function() {
				this.orignal_input.removeAttribute('hidden');
	
				delete this.orignal_input;
				var self = this;
	
				Object.keys(this).forEach(function(key) {
					if (self[key] instanceof HTMLElement)
						self[key].remove();
	
					if (key != 'options')
						delete self[key];
				});
	
				this.initialized = false;
			}
	
			// Private function to initialize the tag input plugin
			function init(tags) {
				tags.wrapper.append(tags.input);
				tags.wrapper.classList.add(tags.options.wrapperClass);
				tags.orignal_input.setAttribute('hidden', 'true');
				tags.orignal_input.parentNode.insertBefore(tags.wrapper, tags.orignal_input);
			}
	
			// initialize the Events
			function initEvents(tags) {
				tags.wrapper.addEventListener('click', function() {
					tags.input.focus();
				});
	
				tags.input.addEventListener('keydown', function(e) {
					if (!!(~[9, 13, 188].indexOf(e.keyCode))) {
						e.preventDefault();
						var str = tags.input.value.trim();
						if (str == "") return;
						str.split(",").forEach(function(tag) {
							tags.addTag(tag.trim());
						});
						tags.input.value = "";
					}
	
				});
			}
	
	
			// Set All the Default Values
			TagsInput.defaults = {
				selector: '',
				wrapperClass: 'tags-input-wrapper',
				tagClass: 'tag',
				max: null,
				duplicate: false
			}
	
			window.TagsInput = TagsInput;
	
		})();
	
		var tagInput1 = new TagsInput({
			selector: 'tag-input1',
			duplicate: false,
			max: 10
		});
		tagInput1.addData([]);

	</script>
	
	@section('javascript')
	@stop

	


@section('javascript')
	
	

	@stop
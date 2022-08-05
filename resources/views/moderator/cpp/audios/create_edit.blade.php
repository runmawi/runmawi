@extends('moderator.master')
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('dropzone/dist/min/dropzone.min.css')}}">

    <!-- JS -->
    <script src="{{asset('dropzone/dist/min/dropzone.min.js')}}" type="text/javascript"></script>
@section('content')
<style>
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
	.error{
        color: red;
		font-size : 14px !important;
    }
</style>
<div id="content-page" class="content-page">
    <div class="container-fluid">
        <div class="admin-section-title">
            <div class="iq-card">
                <div class="row">
                    <div class="col-md-4">
                        <h4><i class="entypo-archive"></i> Add Audio </h4>
                    </div>
					@if (Session::has('message'))
                       <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
                        @endif
                        @if(count($errors) > 0)
                        @foreach( $errors->all() as $message )
                        <div class="alert alert-danger display-hide" id="successMessage" >
                        <button id="successMessage" class="close" data-close="alert"></button>
                        <span>{{ $message }}</span>
                        </div>
                        @endforeach
                        @endif
                    <div class="col-md-8" align="right">
                        <div id="optionradio"  >
                            <div style="" id="optionradio">
                                <form action="{{URL::to('/cpp/Audiofile')}}" method= "post"  >

                                <input type="radio" value="audio_upload" id="audio_upload" name="audiofile" checked="checked"> Audio Upload &nbsp; &nbsp; &nbsp; &nbsp;
                                <input type="radio" value="audiofile"  id="audiofile" name="audiofile"> Audio File

                                </form>
                                </div>
                        </div>
                    </div>
                </div>
                    <div class="row">
                        <div class="col-md-12">

                            <!-- MP3 Audio -->        
                            <div id="audio_file" style="">
                                <div class="new-audio-file mt-3" @if(!empty($audio->type) && $audio->type == 'file'){{ 'style="display:block"' }}@endif>
                                    <label for="mp3_url"><label>Mp3 File URL:</label></label>
                                    <input type="text" class="form-control" name="mp3_url" id="mp3_url" value="@if(!empty($audio->mp3_url)){{ $audio->mp3_url }}@endif" />
                                </div>
                            </div>

                            <!-- Audio upload -->        
                            <div id="video_upload" style="">
                                <div class='content file'>
                                    <h4 class="card-title">Upload Audio</h4>
                                    <!-- Dropzone -->
                                    <form action="{{URL::to('/cpp/uploadAudio')}}" method= "post" class='dropzone' ></form> 
                                </div> 
                                <div>
<!--                                    <input type="button" id="Next" value='Next' class='btn btn-secondary'>-->
                                </div>
                            </div> 
   
                            <div class="text-center" style="margin-top: 30px;">
                                <input type="button" id="Next" value='Proceed to Next Step' class='btn btn-primary'>
                            </div>
                            <input type="hidden" id="base_url" value="<?php echo URL::to('/cpp/Audiofile');?>">
                        </div>
                    <hr />
                </div>
            </div>
        </div>




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

$(document).ready(function(){
	$('#video_upload').show();
	$('#audio_file').hide();

$('#audio_upload').click(function(){
	$('#video_upload').show();
	$('#audio_file').hide();
	$("#video_upload").addClass('collapse');
	$("#audio_file").removeClass('collapse');

})
$('#audiofile').click(function(){
	$('#video_upload').hide();
	$('#audio_file').show();
	$("#video_upload").removeClass('collapse');
	$("#audio_file").addClass('collapse');

	// $('#audio_upload').removeClass('checked'); 


})
});




</script>
 
    </div> 
</div> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   
<script>
$.ajaxSetup({
           headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });


	$(document).ready(function(){

var url =$('#base_url').val();
$('#mp3_url').change(function(){
	alert($('#mp3_url').val());
	$.ajax({
        url: url,
        type: "post",
data: {
               _token: '{{ csrf_token() }}',
               mp3: $('#mp3_url').val()

         },        success: function(value){
			console.log(value);
			$('#audio_id').val(value.audio_id);
            $('#Next').show();

        }
    });
})

});
	// http://localhost/flicknexs/public/uploads/audios/23.mp3
</script>


	<div id="video_details">

<style>

    .p1{
        font-size: 12px;
    }
    .select2-selection__rendered{
        background-color: #f7f7f7!important;
        border: none!important;
    }
    .select2-container--default .select2-selection--multiple{
        border: none!important;
    }
    #video{
        background-color: #f7f7f7!important;
    }
</style>

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop


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
						<form method="POST" action="{{ $post_route }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data" id="cpp_audio_create">

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
											<input type="text" class="form-control" name="slug" id="slug" placeholder="" value="@if(!empty($audio->slug)){{ $audio->slug }}@endif" readonly />
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
							<div class="panel panel-primary  p-0 mt-3" data-collapsed="0"> <div class="panel-heading"> 
														<div class="panel-title"><label>Audio Image Cover</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
														<div class="panel-body" style="display: block;"> 
															@if(!empty($audio->image))
															<img src="{{ URL::to('/'). '/public/uploads/images/' . $audio->image }}" class="audio-img" width="200"/>
															@endif
															<p class="p1">Select the audio image (1080x1920 px or 9:16 ratio):</p> 
															<input type="file" multiple="true" class="form-control" name="image" id="image" />

														</div> 
													</div>
							</div>
							<div class="col-md-6">
							<div class="panel panel-primary  p-0 mt-3" data-collapsed="0"> <div class="panel-heading"> 
														<div class="panel-title"><label>Player Image Cover</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
														<div class="panel-body" style="display: block;"> 
															@if(!empty($audio->player_image))
															<img src="{{ URL::to('/'). '/public/uploads/images/' . $audio->player_image }}" class="audio-img" width="200"/>
															@endif
															<p class="p1">Select the audio image (1280x720 px or 16:9 ratio):</p> 
															<input type="file" multiple="true" class="form-control" name="player_image" id="player_image" />

														</div> 
													</div>
							</div>

						</div>
							
							<!-- <div class="panel panel-primary  mt-3" data-collapsed="0"> <div class="panel-heading"> 
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
								</div> -->


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
													<option value="{{ $Inapp_Purchase->product_id }}"  @if(!empty($audio->ios_ppv_price) && $audio->ios_ppv_price == $Inapp_Purchase->product_id) selected='selected' @endif >{{ $Inapp_Purchase->plan_price }}</option>
												@endforeach
											 </select>										
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
								<!-- <input type="hidden" name="user_id" id="user_id" value="" /> -->
								@endif

								@if(isset($audio->id))
								<input type="hidden" id="id" name="id" value="{{ $audio->id }}" />
								@endif
                                   
								</div><!-- row -->

								 <div class="mt-2 p-2"  style="display: flex;
    justify-content: flex-end;">
	<input type="hidden" id="audio_id" name="audio_id" value="">
                                    
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
	
				
	<input type="hidden" id="base_url" value="<?php echo URL::to('/');?>">

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<script type="text/javascript" src="{{ URL::to('assets/js/jquery.mask.min.js') }}"></script>
	<script type="text/javascript">

		$ = jQuery;

		$(document).ready(function(){
			$('.js-example-basic-multiple').select2();
			$('#ppv_price').hide();
			$('#global_ppv_status').hide();
			
			$("#access").change(function(){
			if($(this).val() == 'ppv'){
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

	{{-- validate --}}

	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
	<script>

		

			// Image upload dimention validation
		$.validator.addMethod('dimention', function(value, element, param) {
            if(element.files.length == 0){
                return true; 
            }

            var width = $(element).data('imageWidth');
            var height = $(element).data('imageHeight');
            var ratio = $(element).data('imageratio');

            if( ratio == '0.56'|| width == param[0] && height == param[1]){
                return true;
            }else{
                return false;
            }
        },'Please upload an image with 1080 x 1920 pixels dimension or 9:16 ratio');

                // player Image upload validation
        $.validator.addMethod('player_dimention', function(value, element, param) {
            if(element.files.length == 0){
                return true; 
            }

            var ratio = $(element).data('imageratio');
            var width = $(element).data('imageWidth');
            var height = $(element).data('imageHeight');

            if( ratio == '1.78' || width == param[0] && height == param[1]){
                return true;
            }else{
                return false;
            }
        },'Please upload an image with 1280 x 720 pixels dimension or 16:9 ratio');


        $('#image').change(function() {

            $('#image').removeData('imageWidth');
            $('#image').removeData('imageHeight');
            $('#image').removeData('imageratio');

            var file = this.files[0];
            var tmpImg = new Image();

            tmpImg.src=window.URL.createObjectURL( file ); 
            tmpImg.onload = function() {
                width = tmpImg.naturalWidth,
                height = tmpImg.naturalHeight;
				ratio =  Number(width/height).toFixed(2) ;
				
                $('#image').data('imageWidth', width);
                $('#image').data('imageHeight', height);
                $('#image').data('imageratio', ratio);

            }
        });

        $('#player_image').change(function() {

            $('#player_image').removeData('imageWidth');
            $('#player_image').removeData('imageHeight');
            $('#player_image').removeData('imageratio');

            var file = this.files[0];
            var tmpImg = new Image();

            tmpImg.src=window.URL.createObjectURL( file ); 
            tmpImg.onload = function() {
                width = tmpImg.naturalWidth,
                height = tmpImg.naturalHeight;
				ratio =  Number(width/height).toFixed(2) ;
				
                $('#player_image').data('imageWidth', width);
                $('#player_image').data('imageHeight', height);
                $('#player_image').data('imageratio', ratio);
            }
        });

		$('form[id="cpp_audio_create"]').validate({
			rules: {
					image: {
						required: true,
						dimention:[1080,1920]
					},

					player_image: {
						required: true,
						player_dimention:[1280,720]
					},
				title : 'required',
				},
			submitHandler: function(form) {
				form.submit(); }
			});
	</script>



  <input type="hidden" id="base_url" value="<?php echo URL::to('/');?>">
	
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

  $('#Next').hide();
  $('#video_details').hide();




    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone(".dropzone",{ 
      //   maxFilesize: 900,  // 3 mb
        maxFilesize: 500,
        // acceptedFiles: "image/*,audio/*",
        acceptedFiles: ".mp3",

    });
    myDropzone.on("sending", function(file, xhr, formData) {
       formData.append("_token", CSRF_TOKEN);
    //   console.log(value)
      this.on("success", function(file, value) {
            console.log(value.title);
            $('#Next').show();
           $('#audio_id').val(value.audio_id);
           $('#title').val(value.title);

           
        });

    }); 



    $('#Next').click(function(){
  $('#video_upload').hide();
  $('#optionradio').hide();
  $('#audio_file').hide();
  $('#Next').hide();
  $('#video_details').show();

  });
    </script>
	<script>
    $(document).ready(function(){
        // $('#message').fadeOut(120);
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);
    })


	$(document).ready(function(){
		$('#cpp_audio_create').on('mouseup keypress blur change keydown', function(e) {
		var title = $('#title').val();
		var slug_name=title.replace(/ /g,"_");
		$('#slug').val(slug_name);
    })
});

</script>

@section('javascript')


        @stop

@stop
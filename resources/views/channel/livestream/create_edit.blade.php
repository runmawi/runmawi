@extends('channel.master')
<style>
    .p1{
        font-size: 12px!important;
    }
	
	.tags-input-wrapper input{
		border: none;
		background: transparent;
		outline: none;
		width: 140px;
		margin-left: 8px;
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
	.tags-input-wrapper {
		background: transparent;
		padding: 10px;
		border-radius: 4px;
		border: 1px solid #ccc;
	}
</style>
@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/js/tagsinput/jquery.tagsinput.css') }}" />
<style>
   ''
</style>
@stop
 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<style>
    .error{
		color:red;
		font-size : 14px !important;
	}
</style>
@section('content')
<div id="content-page" class="content-page">
         <div class="container-fluid">
             <div class="iq-card">
<div id="admin-container" style="padding: 15px;">
<!-- This is where -->
	
	<div class="admin-section-title">
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif   
        
        
	@if(!empty($video->id))
        <div class="d-flex justify-content-between">
            <div>
		<h4>Live video</h4> </div>
            <div>
			<!-- <a href="{{ URL::to('/live/').$video->slug.'/'. $video->id }}" target="_blank" class="btn btn-primary">
			<i class="fa fa-eye"></i> Preview <i class="fa fa-external-link"></i> -->
		</a></div>
            </div>
	@else
		<h5><i class="entypo-plus"></i> Add New Video</h5> 
	@endif
        <hr>
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
	<div class="clear"></div>

	

		<form method="POST" action="{{ $post_route }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data" style="padding: 15px;" id="cpp_live_video">

		@if(!empty($video->created_at))
			<div class="row">
				<div class="col-md-9">
		@endif
					<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
						<div class="panel-title"><label>Title</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body" style="display: block;"> 
							<p class="p1">Add the video title in the textbox below:</p> 
							<input type="text" class="form-control" name="title" id="title" placeholder="Video Title" value="@if(!empty($video->title)){{ $video->title }}@endif" />
						</div> 
					</div>
                    
                    <div class="panel panel-primary mt-3" data-collapsed="0"> <div class="panel-heading"> 
						<div class="panel-title"><label>Slug</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body" style="display: block;"> 
							<p class="p1">Add the video slug in the textbox below:</p> 
							<input type="text" class="form-control" name="slug" id="slug" placeholder="Video Slug" 
                            value="@if(!empty($video->slug)){{ $video->slug }}@endif" />
						</div> 
					</div>

		@if(!empty($video->created_at))
			
				</div>
				<div class="col-sm-3">
					<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
						<div class="panel-title"><label>Created Date</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body" style="display: block;"> 
							<p class="p1">Select Date/Time Below</p> 
							<input type="text" class="form-control" name="created_at" id="created_at" placeholder="" value="@if(!empty($video->created_at)){{ $video->created_at }}@endif" />
						</div> 
					</div>
				</div>
			</div>
		@endif


		<div class="row">
                    <div class="col-md-6">
                    <div class="row mt-3">
                                        <div class="col-sm-12">
                                            <label class="m-0">Video Image Cover</label>
											@php 
												$width = $compress_image_settings->width_validation_live;
												$heigth = $compress_image_settings->height_validation_live
											@endphp
											@if($width !== null && $heigth !== null)
												<p class="p1">{{ ("Select the Live Stream image (".''.$width.' x '.$heigth.'px)')}}:</p> 
											@else
												<p class="p1">{{ "Select the Live Stream image ( 9:16 Ratio or 1080X1920px )"}}:</p> 
											@endif
                                            <div class="panel-body">
                                                <input type="file" multiple="true" class="form-group" name="image" id="image" />
												<span>
													<p id="live_image_error_msg" style="color:red !important; display:none;">
														* Please upload an image with the correct dimensions.
													</p>
												</span>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="panel-body">
                                                @if(!empty($video->image))
                                                <img src="{{ URL::to('/') . '/public/uploads/images/' . $video->image }}" class="video-imgimg" width="200" />
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="row mt-3">
                                        <div class="col-sm-12">
                                            <label class="m-0">Player Image Cover</label>
											@php 
												$player_width = $compress_image_settings->live_player_img_width;
												$player_heigth = $compress_image_settings->live_player_img_height
											@endphp
											@if($player_width !== null && $player_heigth !== null)
												<p class="p1">{{ ("Select the Live Stream image (".''.$player_width.' x '.$player_heigth.'px)')}}:</p> 
											@else
												<p class="p1">{{ "Select the Live Stream image ( 9:16 Ratio or 1080X1920px )"}}:</p> 
											@endif
                                            <div class="panel-body">
                                                <input type="file" multiple="true" class="form-group" name="player_image" id="player_image" />
												<span>
													<p id="live_player_image_error_msg" style="color:red !important; display:none;">
														* Please upload an image with the correct dimensions.
													</p>
												</span> 
											</div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="panel-body">
                                                @if(!empty($video->player_image))
                                                <img src="{{ URL::to('/') . '/public/uploads/images/' . $video->player_image }}" class="video-imgimg" width="200" />
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                    </div>
                </div>
                                    



			<div class="panel panel-primary mt-2" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title"><label>Video Source</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body" style="display: block;"> 
					<select class="form-control url_type" id="url_type" name="url_type"  >
						<option value="" >Choose URL Format</option>
						<option value="mp4" > MP4/M3U8 URL </option>
						<option value="embed" >Embed URL</option>
						<option value="live_stream_video">Live Stream Video</option>

						@foreach($Rtmp_urls as $key => $urls)
							@php     $number = $key+1;  @endphp
							 <option class="Encode_stream_video" value={{ "Encode_video" }} data-name="{{ $urls->rtmp_url }}" >{{ "RTMP Streaming Video"." ".$number }} </option>
					  	@endforeach 
					</select>
					
					<input type="hidden" name="Rtmp_url" id="Rtmp_url" value="" />

                    <div class="new-video-upload mt-2" id ="mp4_code">
						<label for="embed_code"><label>Live Stream URL</label></label>
						<input type="text" name="mp4_url"  class="form-control" id="mp4_url" value="@if(!empty($video->mp4_url) ) {{ $video->mp4_url}}  @endif">
					</div>

					<div class="new-video-upload mt-2" id="embed_code">
						<label for="embed_code"><label>Live Embed URL</label></label>
						<input type="text" name="embed_url"  class="form-control" id="embed_url" value="@if(!empty($video->embed_url) ) {{ $video->embed_url}}  @endif">
					</div>

					<div class="new-video-upload mt-2" id="live_stream_video">
						<label for=""><label>Live Stream Video</label></label>
						<input type="file" multiple="true" class="form-group" name="live_stream_video"  />
					</div>

					@if(!empty($video->mp4_url) )
					<video width="200" height="200" controls>
					<source src="{{ $video->mp4_url }}" type="video/mp4">
					</video>
					@endif
					
				</div> 
			</div>
			



			<div class="panel panel-primary mt-3" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title"><label>Video Details, Links, and Info</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body" style="display: block; padding:0px;">
					<textarea class="form-control" name="details" id="details">@if(!empty($video->details)){{ htmlspecialchars($video->details) }}@endif</textarea>
				</div> 
			</div>

			<div class="panel panel-primary mt-3" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title"><label>Short Description</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body" style="display: block;"> 
					<p class="p1">Add a short description of the video below:</p> 
					<textarea class="form-control" name="description" id="description">@if(!empty($video->description)){{ htmlspecialchars($video->description) }}@endif</textarea>
				</div> 
			</div>

			<div class="panel panel-primary mt-3" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title"><label> Search Tag </label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body" style="display: block;"> 
					<input type="text" id="tag-input1" name="searchtags">
				</div> 
			</div>

			<div class="row mt-3"> 
			<div class="col-sm-6">
			<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title"><label>Category</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body" style="display: block;"> 
					<p class="p1">Select a Video Category Below:</p>
					<!-- <select class="form-control" id="video_category_id" name="video_category_id">
						@foreach($video_categories as $category)
							<option value="{{ $category->id }}" @if(!empty($video->video_category_id) && $video->video_category_id == $category->id)selected="selected"@endif>{{ $category->name }}</option>
						@endforeach
					</select> -->
				<select name="video_category_id[]" id="video_category_id" class="js-example-basic-multiple" style="width: 100%;" multiple="multiple">
					@foreach($video_categories as $category)
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
				<div class="panel-title"><label>Video Ratings</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body" style="display: block;"> 
                    <p class="p1">IMDb Ratings 10 out of 10</p>
					<!-- <input class="form-control" name="rating" id="rating" value="@if(!empty($video->rating)){{ $video->rating }}@endif" onkeyup="NumAndTwoDecimals(event , this);"> -->
					<select  class="js-example-basic-multiple" style="width: 100%;" name="rating" id="rating" tags= "true" onkeyup="NumAndTwoDecimals(event , this);" multiple="multiple">
					<option value="1" >1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10">10</option>
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
					<p class="p1">Select a Video Language Below:</p>
					<!-- <select class="form-control" id="language" name="language">
						@foreach($languages as $language)
							<option value="{{ $language->id }}" @if(!empty($video->language) && $video->language == $language->id)selected="selected"@endif>{{ $language->language }}</option>
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
			<div class="col-sm-6">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title"><label>Video Year</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body" style="display: block;"> 
                    <p class="p1">Video Created Year</p>
					<input class="form-control" name="year" id="year" value="@if(!empty($video->year)){{ $video->year }}@endif">
				</div> 
			</div>
			</div>
			</div>

            
			
			<div class="clear"></div>
				<div class="row mt-3"> 
			
					<div class="col-sm-6"> 
						<div class="panel panel-primary" data-collapsed="0"> 
							<div class="panel-heading"> 
								<div class="panel-title">
									<label> Duration</label>
								</div> 
								<div class="panel-options"> 
									<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> 
								</div>
							</div> 
							<div class="panel-body"> 
								<p class="p1">Enter the video duration in the following format (Hours : Minutes : Seconds)</p> 
								<input class="form-control" name="duration" id="duration" value="@if(!empty($video->duration)){{ gmdate('H:i:s', $video->duration) }}@endif">
							</div> 
						</div>
					</div>

				<div class="col-sm-6">
					<div class="panel panel-primary" data-collapsed="0"> 
						<div class="panel-heading"> 
							<div class="panel-title">
								<label></label>
							</div> 
							<div class="panel-options"> 
								<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> 
							</div>
						</div> 
						<div class="panel-body" style="display: block;"> 
							<p class="p1">Publish Type</p>
							<div class="form-group"> 
								<label class="radio-inline">
								<input type="radio" id="publish_now" name="publish_type" value = "publish_now" checked>Publish Now <br>
								<input type="radio" id="publish_later" name="publish_type" value = "publish_later" >Publish Later
							</div>
						</div> 
					</div>
				</div>
			</div>

			<div class="clear"></div>
			<div class="row mt-3"> 

			<div class="col-sm-12" id="publishlater">
			<label class="">Publish Time</label>
			<input type="datetime-local" class="form-control" id="publish_time" name="publish_time" value="@if(!empty($video->publish_time)){{ $video->publish_time }}@endif">
			<div class="clear"></div>
			</div>
			</div>
			
			<div class="clear"></div>
			<div class="row mt-3"> 
				<div class="col-sm-6"> 
					<!-- <div class="panel panel-primary" data-collapsed="0"> 
						<div class="panel-heading"> <div class="panel-title"><label> Duration</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body"> 
							<p class="p1">Enter the video duration in the following format (Hours : Minutes : Seconds)</p> 
							<input class="form-control" name="duration" id="duration" value="@if(!empty($video->duration)){{ gmdate('H:i:s', $video->duration) }}@endif">
						</div> 
					</div> -->
                    <div class="panel panel-primary mt-3" data-collapsed="0"> 
						<div class="panel-heading"> <div class="panel-title"> <label>User Access</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body col-sm-6 p-0"> 
							<p class="p1">Who is allowed to view this video?</p>
							<select class="form-control" id="access" name="access">
								<option value="guest" @if(!empty($video->access) && $video->access == 'guest'){{ 'selected' }}@endif>Guest (everyone)</option>
								<option value="subscriber" @if(!empty($video->access) && $video->access == 'subscriber'){{ 'selected' }}@endif>Subscriber (only paid subscription users)</option>
								<option value="ppv" @if(!empty($video->access) && $video->access == 'ppv'){{ 'selected' }}@endif >PPV Users (Pay per movie)</option>   
							</select>
							<div class="clear"></div>
						</div> 
					</div>
				</div>
			
				<div class="row col-sm-6 form-group mt-3" id="ppv_price">
					<div class="col-sm-6">
						<label class="">PPV Price:</label>
						<input type="text" class="form-control" placeholder="PPV Price" name="ppv_price" id="price" value="@if(!empty($video->ppv_price)){{ $video->ppv_price }}@endif">
					</div>

					<div class="col-sm-6">
						<label class="">IOS PPV Price:</label>
						<select  name="ios_ppv_price" class="form-control" id="ios_ppv_price">
                            <option value= "" >Select IOS PPV Price: </option>
                            @foreach($InappPurchase as $Inapp_Purchase)
                                 <option value="{{ $Inapp_Purchase->product_id }}"  >{{ $Inapp_Purchase->plan_price }}</option>
                            @endforeach
                         </select>
					</div>
					
					<div class="clear"></div>
				</div>

				</div>

				<!-- <div class="col-sm-6"> 
					<div class="panel panel-primary" data-collapsed="0"> 
						<div class="panel-heading"> <div class="panel-title"><label> Status Settings</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body"> 
							<div>
								<label for="featured" >Is this video Featured:</label>
								<input type="checkbox" @if(!empty($video->featured) && $video->featured == 1){{ 'checked="checked"' }}@endif name="featured" value="1" id="featured" />
							</div>
							<div class="clear"></div>
							<div>
								<label for="active" >Is this video Active:</label>
								<input type="checkbox" @if(!empty($video->active) && $video->active == 1){{ 'checked="checked"' }}@elseif(!isset($video->active)){{ 'checked="checked"' }}@endif name="active" value="1" id="active" />
							</div>
							<div class="clear"></div>
							<div>
								<label for="banner" >Is this video display in Banner:</label>
								<input type="checkbox" @if(!empty($video->banner) && $video->banner == 1){{ 'checked="checked"' }}@endif name="banner" value="1" id="banner" />
							</div>
							<div>
								<label for="footer" >Is this video display in footer:</label>
								<input type="checkbox" @if(!empty($video->footer) && $video->footer == 1){{ 'checked="checked"' }}@endif name="footer" value="1" id="footer" />
							</div>
						</div> 
					</div>
				</div> -->
			<!-- row -->

			@if(!isset($video->user_id))
			@endif

			@if(isset($video->id))
				<input type="hidden" id="id" name="id" value="{{ $video->id }}" />
			@endif

			<input type="hidden" class="btn btn-primary" name="_token" value="<?= csrf_token() ?>" />
			<input type="submit" value="{{ $button_text }}" class="btn btn-primary pull-right" />

		</form>

		<div class="clear"></div>
<!-- This is where now -->
</div>
    </div></div>
</div>
	
	
	
	@section('javascript')

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.min.js"></script>
	<script type="text/javascript" src="{{ URL::to('/assets/admin/js/tinymce/tinymce.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::to('/assets/js/tagsinput/jquery.tagsinput.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::to('/assets/js/jquery.mask.min.js') }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>

	<!-- {{-- validate --}} -->
		<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

	{{-- Sweet alert --}}
		<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>


	                // Image upload dimention validation
		// 			$.validator.addMethod('dimention', function(value, element, param) {
        //     if(element.files.length == 0){
        //         return true; 
        //     }

        //     var width = $(element).data('imageWidth');
        //     var height = $(element).data('imageHeight');
        //     var ratio = $(element).data('imageratio');
        //     var image_validation_status = "{{  image_validation_live() }}" ;

        //     if( image_validation_status == "0" || ratio == '0.56'|| width == param[0] && height == param[1]){
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
        //     var image_validation_status = "{{  image_validation_live() }}" ;

        //     if( image_validation_status == "0" || ratio == '1.78'||  width == param[0] && height == param[1]){
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

	$('form[id="cpp_live_video"]').validate({				
		rules: {
		  title: 'required',
		  url_type: 'required',
		//   details: 'required',
		//   year: 'required',
		//   description : 'required',
		//   'video_category_id[]' :'required',
		  'language[]' :'required',
	
			mp4_url: {
			required : function(element) {
				var action = $("#url_type").val();
				if(action == "mp4") { 
					return true;
				} else {
					return false;
				}
			 }
			},

			live_stream_video: {
			required : function(element) {
				var action = $("#url_type").val();
				if(action == "live_stream_video") { 
					return true;
				} else {
					return false;
				}
			 }
			},

			image: {
                required: true,
                dimention:[1080,1920]
            },

            player_image: {
                required: true,
                player_dimention:[1280,720]
            },

			embed_url: {
					required : function(element) {
						var action = $("#url_type").val();
						if(action == "embed") { 
							return true;
						} else {
							return false;
						}
					}
				}
			},
		messages: {
		  title: 'This field is required',
		  mp4_url: 'This field is required',
		},
		submitHandler: function(form) {
		  form.submit();
		}
	  });
	</script>
<!-- {{-- End validate --}} -->



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
                    
                    var validWidth = {{ $compress_image_settings->width_validation_live }};
                    var validHeight = {{ $compress_image_settings->height_validation_live }};
                    console.log(validWidth);
                    console.log(validHeight);

                    if (width !== validWidth || height !== validHeight) {
                        document.getElementById('live_image_error_msg').style.display = 'block';
                        $('.pull-right').prop('disabled', true);
                        document.getElementById('live_image_error_msg').innerText = 
                            `* Please upload an image with the correct dimensions (${validWidth}x${validHeight}px).`;
                    } else {
                        document.getElementById('live_image_error_msg').style.display = 'none';
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
                    
                    var validWidth = {{ $compress_image_settings->live_player_img_width }};
                    var validHeight = {{ $compress_image_settings->live_player_img_height }};
                    console.log(validWidth);
                    console.log(validHeight);

                    if (width !== validWidth || height !== validHeight) {
                        document.getElementById('live_player_image_error_msg').style.display = 'block';
                        $('.pull-right').prop('disabled', true);
                        document.getElementById('live_player_image_error_msg').innerText = 
                            `* Please upload an image with the correct dimensions (${validWidth}x${validHeight}px).`;
                    } else {
                        document.getElementById('live_player_image_error_msg').style.display = 'none';
                        $('.pull-right').prop('disabled', false);
                    }
                };
                img.src = URL.createObjectURL(file);
            }
        });
    </script>


{{-- Sweet alert --}}

@php
    $liveStreamVideo_errors = $liveStreamVideo_error;
@endphp

<script type="text/javascript">

    let Stream_error = '{{ $liveStreamVideo_errors }}';

    $( document ).ready(function() {
        if( Stream_error == 1){
            Swal.fire({
            allowOutsideClick:false,
            icon: 'error',
            title: 'Oops...',
            text: 'While Converting the Live Stream video, Something went wrong!',
            }).then(function (result) {
            if (result.value) {
                location.href = '{{ URL::to('channel/livestream/create') }}';
            }
            })
        }
    });
</script>

{{-- Sweet alert --}}


	<script type="text/javascript">

$(document).ready(function(){
	$('#mp4_code').hide();
	$('#embed_code').hide();		
	$("#live_stream_video").hide();

	$('#url_type').change(function(){
		if($("#url_type").val() == 'mp4'){
			$('#mp4_code').show();
			$('#embed_code').hide();	
			$("#live_stream_video").hide();

		}else if($("#url_type").val() == 'embed'){
			$('#embed_code').show();	
			$('#mp4_code').hide();
			$("#live_stream_video").hide();
		}
		else if ($("#url_type").val() == "live_stream_video") {
			$("#embed_code").hide();
			$("#mp4_code").hide();
			$("#live_stream_video").show();
		}
		else if ($("#url_type").val() == "Encode_video") {
                $("#embed_code").hide();
                $("#mp4_code").hide();
                $("#live_stream_video").hide();
        }
	});
});
$(document).ready(function(){
	$('.js-example-basic-multiple').select2();

	$('#publishlater').hide();
	$('#publish_now').click(function(){
		// alert($('#publish_now').val());
		$('#publishlater').hide();
	});
	$('#publish_later').click(function(){
		// alert($('#publish_later').val());
		$('#publishlater').show();
	});

	if($("#publish_now").val() == 'publish_now'){
	$('#publishlater').hide();
	}else if($("#publish_later").val() == 'publish_later'){
		$('#publishlater').show();		
	}
});
	$(document).ready(function(){
		if($("#access").val() == 'ppv'){
				$('#ppv_price').show();
			}else{
				$('#ppv_price').hide();		

			}
    // $('#ppv_price').hide();
	// alert()

		$("#access").change(function(){
			// alert('test');
			if($(this).val() == 'ppv'){
				$('#ppv_price').show();
			}else{
				$('#ppv_price').hide();		

			}
		});
});
	$ = jQuery;

	$(document).ready(function(){

		$('#duration').mask('00:00:00');
		$('#tags').tagsInput();

		$('#type').change(function(){
            
			if($(this).val() == 'file'){
				$('.new-video-file').show();
				$('.new-video-embed').hide();
				$('.new-video-upload').hide();

			} else if($(this).val() == 'embed'){ 
				$('.new-video-file').hide();
				$('.new-video-embed').show();
				$('.new-video-upload').hide();

			}else{
				$('.new-video-file').hide();
				$('.new-video-embed').hide();
				$('.new-video-upload').show();
				
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
<script>
    $(document).ready(function(){
        // $('#message').fadeOut(120);
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);
    })

</script>

<script>

	$(document).on('change', '.url_type', function() {
	
	if($(".url_type").val() == "Encode_video"){
	
		var optionText = $(".url_type option:selected").attr("data-name") ;
	
		$("#Rtmp_url").val(function() {
			$("#Rtmp_url").val(' ');
			return this.value + optionText;
		});
	}
	});
	
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
	@stop

@stop

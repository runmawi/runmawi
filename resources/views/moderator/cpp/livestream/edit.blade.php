@extends('moderator.master')
<style>
    .p1{
        font-size: 12px!important;
    }
	.error{
		color:red;
	}
</style>
@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/js/tagsinput/jquery.tagsinput.css') }}" />
<style>
    ''
</style>
@stop
 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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
			<a href="{{ URL::to('/live/').$video->slug.'/'. $video->id }}" target="_blank" class="btn btn-primary">
			<i class="fa fa-eye"></i> Preview <i class="fa fa-external-link"></i>
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

	

		<form method="POST" action="{{ $post_route }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data" style="padding: 15px;" id="cpp_live_edit">

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


			<div class="panel panel-primary mt-3" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title"><label>Video Image Cover</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body" style="display: block;"> 
					@if(!empty($video->image))
						<img src="{{ URL::to('/') . '/public/uploads/images/' . $video->image }}" class="video-imgimg" width="200"/>
					@endif
					<p class="p1">Select the video image (1280x720 px or 16:9 ratio):</p> 
					<input type="file" multiple="true" class="form-control" name="image" id="image" />
					
				</div> 
			</div>

			<div class="panel panel-primary mt-2" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title"><label>Video Source</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body" style="display: block;"> 
					
					
                    <div class="new-video-upload mt-2">
						<label for="embed_code"><label>Live Stream URL</label></label>
						<input type="url" name="mp4_url"  class="form-control" id="video_upload" value="@if(!empty($video->mp4_url) ) {{ $video->mp4_url}}  @endif">
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
			<div class="row mt-3"> 
			<div class="col-sm-6">
			<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title"><label>Category</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body" style="display: block;"> 
					<p class="p1">Select a Video Category Below:</p>
					<select class="form-control" id="video_category_id" name="video_category_id">
						@foreach($video_categories as $category)
							<option value="{{ $category->id }}" @if(!empty($video->video_category_id) && $video->video_category_id == $category->id)selected="selected"@endif>{{ $category->name }}</option>
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
					<label class="p-2">Rating:</label>
                                    <!-- selected="true" -->
                                    <!-- <input type="text" class="form-control" placeholder="Movie Ratings" name="rating" id="rating" value="@if(!empty($video->rating)){{ $video->rating }}@endif" onkeyup="NumAndTwoDecimals(event , this);"> -->
                                    <select  class="js-example-basic-multiple" style="width: 100%;" name="rating" id="rating" tags= "true" onkeyup="NumAndTwoDecimals(event , this);" multiple="multiple">
                                          <option value="1" @if(!empty($video->rating) && $video->rating == '1'){{ 'selected' }}@endif >1</option>
                                          <option value="2"@if(!empty($video->rating) && $video->rating == '2'){{ 'selected' }}@endif>2</option>
                                          <option value="3"@if(!empty($video->rating) && $video->rating == '3'){{ 'selected' }}@endif>3</option>
                                          <option value="4"@if(!empty($video->rating) && $video->rating == '4'){{ 'selected' }}@endif>4</option>
                                          <option value="5"@if(!empty($video->rating) && $video->rating == '5'){{ 'selected' }}@endif>5</option>
                                          <option value="6"@if(!empty($video->rating) && $video->rating == '6'){{ 'selected' }}@endif>6</option>
                                          <option value="7"@if(!empty($video->rating) && $video->rating == '7'){{ 'selected' }}@endif>7</option>
                                          <option value="8"@if(!empty($video->rating) && $video->rating == '8'){{ 'selected' }}@endif>8</option>
                                          <option value="9"@if(!empty($video->rating) && $video->rating == '9'){{ 'selected' }}@endif>9</option>
                                          <option value="10"@if(!empty($video->rating) && $video->rating == '10'){{ 'selected' }}@endif>10</option>
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
					<select class="form-control" id="language" name="language">
						@foreach($languages as $language)
							<option value="{{ $language->id }}" @if(!empty($video->language) && $video->language == $language->id)selected="selected"@endif>{{ $language->language }}</option>
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
		
			<div class="col-sm-6"> 
			<div class="panel panel-primary" data-collapsed="0"> 
				<div class="panel-heading"> <div class="panel-title"><label> Duration</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body"> 
					<p class="p1">Enter the video duration in the following format (Hours : Minutes : Seconds)</p> 
					<input class="form-control" name="duration" id="duration" value="@if(!empty($video->duration)){{ gmdate('H:i:s', $video->duration) }}@endif">
				</div> 
			</div>
			</div>
			</div>

			<div class="col-sm-6">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title"><label></label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body" style="display: block;"> 
                    <p class="p1">Publish Type</p>
					<div class="form-group"> 
                            <label class="radio-inline">
							<input type="radio" id="publish_now" name="publish_type" value = "publish_now" {{ !empty(($video->publish_type=="publish_now"))? "checked" : "" }}>Publish Now <br>
							<input type="radio" id="publish_later" name="publish_type" value = "publish_later"{{ !empty(($video->publish_type=="publish_later"))? "checked" : "" }} >Publish Later
                        </div></div> 
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
					<div class="panel panel-primary" data-collapsed="0"> 
						<div class="panel-heading"> <div class="panel-title"><label> Duration</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body"> 
							<p class="p1">Enter the video duration in the following format (Hours : Minutes : Seconds)</p> 
							<input class="form-control" name="duration" id="duration" value="@if(!empty($video->duration)){{ gmdate('H:i:s', $video->duration) }}@endif">
						</div> 
					</div>
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
			
				<div class="col-sm-6 form-group mt-3" id="ppv_price">
					<label class="">PPV Price:</label>
					<input type="text" class="form-control" placeholder="PPV Price" name="ppv_price" id="price" value="@if(!empty($video->ppv_price)){{ $video->ppv_price }}@endif">
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
				<input type="hidden" id="publish_status" name="publish_status" value="{{ $video->publish_status }}" >
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

		{{-- validate --}}

		<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
		<script>
			$('form[id="cpp_live_edit"]').validate({
			   
				rules: {
					title : 'required',
					mp4_url : 'required',
					description : 'required',
					slug : 'required',
					year : 'required',
					details : 'required',
					},
				submitHandler: function(form) {
					form.submit(); }
				});
		</script>
		{{-- End validate --}}

	<script type="text/javascript">

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
	@stop

@stop

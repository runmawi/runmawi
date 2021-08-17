@extends('admin.master')
<style>
    .p1{
        font-size: 12px!important;
    }
</style>
@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/js/tagsinput/jquery.tagsinput.css') }}" />
<style>
    ''
</style>
@stop
 

@section('content')
<div id="content-page" class="content-page">
         <div class="container-fluid">
             <div class="iq-card">
<div id="admin-container" style="padding: 20px;">
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
		<h3>{{ $video->title }}</h3> 
		<a href="{{ URL::to('/') . '/ppvVideos/play_videos/' . $video->id }}" target="_blank" class="btn btn-black">
			<i class="fa fa-eye"></i> Preview <i class="fa fa-external-link"></i>
		</a>
	@else
		<h5><i class="entypo-plus"></i> Add New Video</h5> 
	@endif
        <hr>
	</div>
	<div class="clear"></div>

	

		<form method="POST" action="{{ $post_route }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data" style="padding: 30px;">

		@if(!empty($video->created_at))
			<div class="row">
				<div class="col-md-9">
		@endif
					<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
						<div class="panel-title">Title</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body" style="display: block;"> 
							<p class="p1">Add the video title in the textbox below:</p> 
							<input type="text" class="form-control" name="title" id="title" placeholder="Video Title" value="@if(!empty($video->title)){{ $video->title }}@endif" />
						</div> 
					</div>
                    
                    <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
						<div class="panel-title">Slug</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body" style="display: block;"> 
							<p class="p1">Add the video slug in the textbox below:</p> 
							<input type="text" class="form-control" name="slug" id="slug" placeholder="Video Slug" value="@if(!empty($video->slug)){{ $video->slug }}@endif" />
						</div> 
					</div>

		@if(!empty($video->created_at))
			
				</div>
				<div class="col-sm-3">
					<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
						<div class="panel-title">Created Date</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body" style="display: block;"> 
							<p class="p1">Select Date/Time Below</p> 
							<input type="text" class="form-control" name="created_at" id="created_at" placeholder="" value="@if(!empty($video->created_at)){{ $video->created_at }}@endif" />
						</div> 
					</div>
				</div>
			</div>
		@endif


			<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title">Video Image Cover</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body" style="display: block;"> 
					@if(!empty($video->image))
						<img src="{{ URL::to('/') . '/public/uploads/images/' . $video->image }}" class="video-imgimg" width="200"/>
					@endif
					<p class="p1">Select the video image (1280x720 px or 16:9 ratio):</p> 
					<input type="file" multiple="true" class="form-control" name="image" id="image" />
					
				</div> 
			</div>

			<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title">Video Source</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body" style="display: block;"> 
					
					
                    <div class="new-video-upload">
						<label for="embed_code">Live Stream URL</label>
						<input type="url" name="mp4_url"  class="form-control" id="video_upload" value="@if(!empty($video->mp4_url) ) {{ $video->mp4_url}}  @endif">
					</div>
					@if(!empty($video->mp4_url) )
					<video width="200" height="200" controls>
					<source src="{{ $video->mp4_url }}" type="video/mp4">
					</video>
					@endif
					
				</div> 
			</div>
			


			<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title">Video Details, Links, and Info</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body" style="display: block; padding:0px;">
					<textarea class="form-control" name="details" id="details">@if(!empty($video->details)){{ htmlspecialchars($video->details) }}@endif</textarea>
				</div> 
			</div>

			<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title">Short Description</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body" style="display: block;"> 
					<p class="p1">Add a short description of the video below:</p> 
					<textarea class="form-control" name="description" id="description">@if(!empty($video->description)){{ htmlspecialchars($video->description) }}@endif</textarea>
				</div> 
			</div>
			<div class="row"> 
			<div class="col-sm-6">
			<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title">Category</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
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
				<div class="panel-title">Video Ratings</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body" style="display: block;"> 
                    <p class="p1">IMDb Ratings 10 out of 10</p>
					<input class="form-control" name="rating" id="rating" value="@if(!empty($video->rating)){{ $video->rating }}@endif" onkeyup="NumAndTwoDecimals(event , this);">
				</div> 
			</div>
			</div>
			</div>

			<div class="row"> 
			<div class="col-sm-6">
			<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title">Language</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
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
				<div class="panel-title">Video Year</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body" style="display: block;"> 
                    <p class="p1">Video Created Year</p>
					<input class="form-control" name="year" id="year" value="@if(!empty($video->year)){{ $video->year }}@endif">
				</div> 
			</div>
			</div>
			</div>

            
			
			<div class="clear"></div>


			<div class="row"> 

				<div class="col-sm-6"> 
					<div class="panel panel-primary" data-collapsed="0"> 
						<div class="panel-heading"> <div class="panel-title"> Duration</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body"> 
							<p class="p1">Enter the video duration in the following format (Hours : Minutes : Seconds)</p> 
							<input class="form-control" name="duration" id="duration" value="@if(!empty($video->duration)){{ gmdate('H:i:s', $video->duration) }}@endif">
						</div> 
					</div>
                    <div class="panel panel-primary" data-collapsed="0"> 
						<div class="panel-heading"> <div class="panel-title"> User Access</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body"> 
							<label for="access" style="float:left; margin-right:10px;">Who is allowed to view this video?</label>
							<select id="access" name="access">
								<option value="guest" @if(!empty($video->access) && $video->access == 'guest'){{ 'selected' }}@endif>Guest (everyone)</option>
								<option value="subscriber" @if(!empty($video->access) && $video->access == 'subscriber'){{ 'selected' }}@endif>Subscriber (only paid subscription users)</option>
							</select>
							<div class="clear"></div>
						</div> 
					</div>
				</div>

				

				<div class="col-sm-6"> 
					<div class="panel panel-primary" data-collapsed="0"> 
						<div class="panel-heading"> <div class="panel-title"> Status Settings</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
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
				</div>

			</div><!-- row -->

			@if(!isset($video->user_id))
				<input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}" />
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


	<script type="text/javascript" src="{{ URL::to('/assets/admin/js/tinymce/tinymce.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::to('/assets/js/tagsinput/jquery.tagsinput.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::to('/assets/js/jquery.mask.min.js') }}"></script>

	<script type="text/javascript">

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

	@stop

@stop

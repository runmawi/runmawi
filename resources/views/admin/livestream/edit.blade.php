@extends('admin.master')
<style>
    .p1{
        font-size: 15px !important;
    }
    .black{
        color: #000;
        background: #f2f5fa;
        padding: 20px 20px;
border-radius: 0px 4px 4px 0px;
    }
    .black:hover{
        background: #fff;
         padding: 20px 20px;
        color: rgba(66, 149, 210, 1);

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
     <div class="mb-5">
                        <a class="black" href="{{ URL::to('admin/livestream') }}">All Live Videos</a>
                        <a class="black" href="{{ URL::to('admin/livestream/create') }}">Add New Live Video</a>
                        <a class="black" href="{{ URL::to('admin/CPPLiveVideosIndex') }}">Live Videos For Approval</a>
                        <a class="black" href="{{ URL::to('admin/livestream/categories') }}">Manage Live Video Categories</a></div>
         <div class="container-fluid p-0">
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
		<h4>Edit Livestream Video</h4> </div>
            <div>
		<a href="{{ URL::to('/live/').'/'.$video->slug }}" target="_blank" class="btn btn-primary">
			<i class="fa fa-eye"></i> Preview <i class="fa fa-external-link"></i>
		</a>
            </div>
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

	

		<form method="POST" action="{{ $post_route }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data" style="padding: 15px;" id="liveEdit_video">
            
            <div class="row mt-3">
                <div class="col-sm-6">
                    <label class="m-0">Title</label>
                    <p class="p1">Add the video title in the textbox below:</p>

                    <div class="panel-body">
                        <input type="text" class="form-control" name="title" id="title" placeholder="Video Title" value="@if(!empty($video->title)){{ $video->title }}@endif" />
                    </div>
                </div>

                @if(!empty($video->created_at))
                <div class="col-sm-6">
                    <label class="m-0">Published Date</label>
                    <p class="p1">Video Published on Date/Time Below</p>
                    <div class="panel-body">
                        <input type="text" class="form-control" name="created_at" id="created_at" placeholder="" value="@if(!empty($video->created_at)){{ $video->created_at }}@endif" />
                    </div>
                </div>
                @endif

                <div class="col-sm-6">
                    <label class="m-0">Slug</label>
                    <p class="p1">Add the video slug in the textbox below:</p>
                    <div class="panel-body">
                        <input type="text" class="form-control" name="slug" id="slug" placeholder="Video Slug" value="@if(!empty($video->slug)){{ $video->slug }}@endif" />
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-sm-6">
                    <label class="m-0">Video Image Cover</label>
                    <p class="p1">Select the video image (1280x720 px or 16:9 ratio):</p>

                    <div class="panel-body">
                       <input type="file" multiple="true" class="form-control" name="image" id="image" />
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="panel-body">
                        @if(!empty($video->image))
                            <img src="{{ URL::to('/') . '/public/uploads/images/' . $video->image }}" class="video-imgimg" width="200"/>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-sm-6">
                    <label class="m-0">Video Source</label>

                    <div class="panel-body">
                        <select class="form-control url_type" id="url_type" name="url_type">
                            <option value="">Choose URL Format</option>
                            <option value="mp4" @if(!empty($video->url_type) && $video->url_type == 'mp4'){{ 'selected' }}@endif >MP4 URL</option>
                            <option value="embed" @if(!empty($video->url_type) && $video->url_type == 'embed'){{ 'selected' }}@endif>Embed URL</option>
                            <option value="live_stream_video" @if(!empty($video->url_type) && $video->url_type == 'live_stream_video'){{ 'selected' }}@endif>Live Stream Video</option>
                            <option value="Encode_video" @if(!empty($video->url_type) && $video->url_type == 'Encode_video'){{ 'selected' }}@endif>Video Encoder</option>
                        </select>

                            <div class="new-video-upload mt-2" id="mp4_code">
                                <label for="embed_code"><label>Live Stream URL</label></label>
                                <input type="text" name="mp4_url" class="form-control" id="mp4_url" value="@if(!empty($video->mp4_url) ) {{ $video->mp4_url}}  @endif" />
                            </div>

                            <div class="new-video-upload mt-2" id="embed_code">
                                <label for="embed_code"><label>Live Embed URL</label></label>
                                <input type="text" name="embed_url" class="form-control" id="embed_url" value="@if(!empty($video->embed_url) ) {{ $video->embed_url}}  @endif" />
                            </div>

                            <div class="new-video-upload mt-2" id="live_stream_video">
                                <label for="live_stream_video"><label>Live Stream Video</label></label>
                                <input type="file" multiple="true" class="form-group" name="live_stream_video" id="" />                        
                            </div>
                    </div>
                </div>

                @if($video->url_type == "Encode_video")
                    <div class="col-sm-6" id="url_rtmp">
                        <label class="m-0">RTMP URL</label>
                        <div class="panel-body">
                            <input type="text" class="form-control" value="@if( !empty($video->Stream_key) && !empty($settings->rtmp_url) ) {{ $settings->rtmp_url. $video->Stream_key }}  @else {{ 'NO RTML URL '}} @endif" readonly>
                        </div>
                    </div>
                @endif

                <div class="col-sm-6">
                    <div class="panel-body">
                        @if(!empty($video->mp4_url) )
                        <video width="200" height="200" controls>
                            <source src="{{ $video->mp4_url }}" type="video/mp4" />
                        </video>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-sm-12">
                    <label class="m-0">Short Description</label>
                    <p class="p1">Add a short description of the Livestream below:</p>
                    <div class="panel-body">
                        <textarea class="form-control" name="description" id="description">@if(!empty($video->description)){{ htmlspecialchars($video->description) }}@endif</textarea>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-sm-12">
                    <label class="m-0">Video Details, Links, and Info</label>

                    <div class="panel-body">
                        <textarea class="form-control" name="details" id="details">@if(!empty($video->details)){{ htmlspecialchars($video->details) }}@endif</textarea>
                    </div>
                </div>
            </div>

            

            <div class="row mt-3">
                <div class="col-sm-6">
                    <label class="m-0">Category</label>
                    <p class="p1">Select a Video Category Below:</p>

                    <div class="panel-body">
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
                <div class="col-sm-6">
                    <label class="m-0">Language</label>
                    <p class="p1">Select a Video Language Below:</p>

                    <div class="panel-body">
                        <select class="form-control js-example-basic-multiple" id="language" name="language[]" style="width: 100%;" multiple="multiple">
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
            <div class="row mt-3">
                <div class="col-sm-6">
                    <label class="m-0">Video Ratings</label>
                    <p class="p1">Livestream Ratings 10 out of 10</p>

                    <div class="panel-body">
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

                <div class="col-sm-6">
                    <label class="m-0">Video Year</label>
                    <p class="p1">Video Released Year</p>

                    <div class="panel-body">
					   <input class="form-control" name="year" id="year" value="@if(!empty($video->year)){{ $video->year }}@endif">
                    </div>
                </div>
            </div>
            
            
            <div class="row mt-3">
                <div class="col-sm-4">
                    <label class="m-0">Duration</label>
                    <p class="p1">Enter the video duration in (HH : MM : SS)</p>
                    <div class="panel-body">
                        <input class="form-control" name="duration" id="duration" value="@if(!empty($video->duration)){{ gmdate('H:i:s', $video->duration) }}@endif" />
                    </div>
                </div>
                <div class="col-sm-4">
                    <label class="m-0">User Access</label>
                    <p class="p1">Who is allowed to view this video?</p>
                    <div class="panel-body">
                        <select class="form-control" id="access" name="access">
                            <option value="guest" @if(!empty($video->access) && $video->access == 'guest'){{ 'selected' }}@endif>Guest (everyone)</option>
                            <option value="subscriber" @if(!empty($video->access) && $video->access == 'subscriber'){{ 'selected' }}@endif >Subscriber (only paid subscription users)</option>
                            <option value="ppv" @if(!empty($video->access) && $video->access == 'ppv'){{ 'selected' }}@endif >PPV Users (Pay per movie)</option>     
                        </select>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="col-sm-4" id="ppv_price">
                    <label class="m-0">PPV Price</label>
                    <p class="p1">Apply PPV Price from Global Settings?</p>
                    <div class="panel-body">
                        <input type="text" class="form-control" name="ppv_price" id="price" value="<?php if(!empty($video->ppv_price)) { echo $video->ppv_price ; }else{  } ?>" >
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-3">
                <div class="col-sm-4">
                    <label class="m-0">Publish Type</label>
                    <div class="panel-body" style="color: #000;">
                        <input type="radio" id="publish_now" name="publish_type" value = "publish_now" {{ !empty(($video->publish_type=="publish_now"))? "checked" : "" }}> Publish Now <br>
				        <input type="radio" id="publish_later" name="publish_type" value = "publish_later"  {{ !empty(($video->publish_type=="publish_later"))? "checked" : "" }}> Publish Later
                    </div>
                </div>

                <div class="col-sm-4">
                    <div id="publishlater">
                        <label class="m-0">Publish Time</label>
                        <div class="panel-body">
                            <input type="datetime-local" class="form-control" id="publish_time" name="publish_time" value="@if(!empty($video->publish_time)){{ $video->publish_time }}@endif" />
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-4" id="publishlater">
                    <label class="m-0">Status Settings</label>
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
                            <!-- <label for="footer" >Is this video display in footer:</label>
                            <input type="checkbox" @if(!empty($video->footer) && $video->footer == 1){{ 'checked="checked"' }}@endif name="footer" value="1" id="footer" /> -->
                        </div>
                    </div>
                </div>
            </div>
			<!-- row -->

			@if(!isset($video->user_id))
				<input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}" />
			@endif

			@if(isset($video->id))
				<input type="hidden" id="id" name="id" value="{{ $video->id }}" />
				<input type="hidden" id="publish_status" name="publish_status" value="{{ $video->publish_status }}" >
				<!-- <input type="hidden"  name="ppv_price" id="price" value="$video->ppv_price"> -->
			@endif

			<input type="hidden" class="btn btn-primary" name="_token" value="<?= csrf_token() ?>" />
			<input type="submit" value="{{ $button_text }}" class="btn btn-primary pull-right" />

		</form>

		<div class="clear"></div>
<!-- This is where now -->
</div>
    </div></div>
</div>
	
@php
    $liveStreamVideo_errors = $liveStreamVideo_error;
@endphp	
	
	@section('javascript')

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.min.js"></script>
	<script type="text/javascript" src="{{ URL::to('/assets/admin/js/tinymce/tinymce.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::to('/assets/js/tagsinput/jquery.tagsinput.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::to('/assets/js/jquery.mask.min.js') }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
    <script src="<?= URL::to('/assets/js/jquery.mask.min.js');?>"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
   $ = jQuery;
   $(document).ready(function($){
    $("#duration").mask("00:00:00");
   });

  
var Stream_error = '{{ $liveStreamVideo_errors }}';

$( document ).ready(function() {
    if( Stream_error == 1){
        Swal.fire({
        allowOutsideClick:false,
        icon: 'error',
        title: 'Oops...',
        text: 'While Converting the Live Stream video, Something went wrong!',
        }).then(function (result) {
        if (result.value) {
            location.href = "{{ URL::to('admin/livestream/edit') . '/' . $video->id }}";
        }
        })
    }
});


$(document).ready(function(){


//  validate 
	$('form[id="liveEdit_video"]').validate({
	rules: {
	  title: 'required',
	  url_type: 'required',
	 
		mp4_url: {
		required : function(element) {
			var action = $(".url_type").val();
			if(action == "mp4") { 
				return true;
			} else {
				return false;
			}
		 }
		},

		embed_url: {
				required : function(element) {
					var action = $(".url_type").val();
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
	  image: 'This field is required',
	  mp4_url: 'This field is required',

	},
	submitHandler: function(form) {
	  form.submit();
	}
  });

//  End validate

            $('#mp4_code').hide();
            $('#embed_code').hide();
            $('#live_stream_video').hide();	
 

    $("#url_type").change(function(){

        if($("#url_type").val() == 'mp4'){
            $('#mp4_code').show();
            $('#embed_code').hide();
            $('#live_stream_video').hide();	
            $('#url_rtmp').hide();	

        }else if($("#url_type").val() == 'embed'){
            $('#embed_code').show();	
            $('#mp4_code').hide();
            $('#live_stream_video').hide();	
            $('#url_rtmp').hide();	

        }else if($("#url_type").val() == 'live_stream_video'){
            $('#embed_code').hide();	
            $('#mp4_code').hide();
            $('#live_stream_video').show();	
            $('#url_rtmp').hide();	

        }else if ($("#url_type").val() == "Encode_video") {
                $("#embed_code").hide();
                $("#mp4_code").hide();
                $("#live_stream_video").hide();
                $('#url_rtmp').show();	
        }
    });


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

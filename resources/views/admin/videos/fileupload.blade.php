@extends('admin.master')
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
</style>
<div id="content-page content_videopage" class="content-page">
    <div class="container-fluid" id="content_videopage">
        <div class="admin-section-title">
            <div class="iq-card">
                <div class="row">
                    <div class="col-md-4">
                        <h4><i class="entypo-archive"></i> Add Video </h4>
                    </div>
                    <div class="col-md-8" align="right">
                        <div id="optionradio"  >
                                <input type="radio" class="text-black" value="videoupload" id="videoupload" name="videofile" checked="checked"> Video Upload &nbsp;&nbsp;&nbsp;
                                <input type="radio" class="text-black" value="m3u8"  id="m3u8" name="videofile">m3u8 Url &nbsp;&nbsp;&nbsp;
                                <input type="radio" class="text-black" value="videomp4"  id="videomp4" name="videofile"> Video mp4 &nbsp;&nbsp;&nbsp;
                                <input type="radio" class="text-black" value="embed_video"  id="embed_video" name="videofile"> Embed Code              
                        </div>
                    </div>
                </div>
                    <div class="row">
                        <div class="col-md-12">
                            <!-- M3u8 Video --> 
                            <div id="m3u8_url" style="">
                                <div class="new-audio-file mt-3">
                                    <label for="embed_code"><label>m3u8 URL:</label></label>
                                    <input type="text" class="form-control" name="m3u8_video_url" id="m3u8_video_url" value="" />
                                </div>
                            </div> 
                            <!-- Embedded Video -->        
                            <div id="embedvideo" style="">
                                <div class="new-audio-file mt-3">
                                    <label for="embed_code"><label>Embed URL:</label></label>
                                    <input type="text" class="form-control" name="embed_code" id="embed_code" value="" />
                                </div>
                            </div> 

                            <!-- MP4 Video -->        
                            <div id="video_mp4" style="">
                                <div class="new-audio-file mt-3" >
                                    <label for="mp4_url"><label>Mp4 File URL:</label></label>
                                    <input type="text" class="form-control" name="mp4_url" id="mp4_url" value="" />
                                </div>
                            </div> 

                            <!-- Video upload -->        
                            <div id="video_upload" style="">
                            <div class='content file'>
                                    <h4 class="card-title">Upload Full Video Here</h4>
                                    <!-- Dropzone -->
                                    <form action="{{URL::to('uploadFile')}}" method= "post" class='dropzone' ></form> 
                                </div> 
                            <p style="margin-top: -3%;margin-left: 45%;">Trailers Can Be Uploaded From Video Edit Screen</p>
                                
                            </div> 
   
                            <div class="text-center" style="margin-top: 30px;">
                                <input type="button" id="Next" value='Proceed to Next Step' class='btn btn-primary'>
                            </div>
                            <input type="hidden" id="embed_url" value="<?php echo URL::to('/embededcode');?>">
                            <input type="hidden" id="mp4url" value="<?php echo URL::to('/mp4url');?>">
                            <input type="hidden" id="m3u8url" value="<?php echo URL::to('/m3u8url');?>">
                        </div>
                    <hr />
                </div>
            </div>
        </div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
   
$(document).ready(function(){
	$('#video_upload').show();
	$('#video_mp4').hide();
	$('#embedvideo').hide();
	$('#m3u8_url').hide();



$('#videoupload').click(function(){
	$('#video_upload').show();
	$('#video_mp4').hide();
	$('#embedvideo').hide();
	$('#m3u8_url').hide();

	$("#video_upload").addClass('collapse');
	$("#video_mp4").removeClass('collapse');
	$("#embed_video").removeClass('collapse');
	$("#m3u8").removeClass('m3u8');


})
$('#videomp4').click(function(){
	$('#video_upload').hide();
	$('#video_mp4').show();
	$('#embedvideo').hide();
	$('#m3u8_url').hide();

	$("#video_upload").removeClass('collapse');
	$("#video_mp4").addClass('collapse');
	$("#embed_video").removeClass('collapse');
	$("#m3u8").removeClass('m3u8');


})
$('#embed_video').click(function(){
	$('#video_upload').hide();
	$('#video_mp4').hide();
	$('#embedvideo').show();
	$('#m3u8_url').hide();

	$("#video_upload").removeClass('collapse');
	$("#video_mp4").removeClass('collapse');
	$("#embed_video").addClass('collapse');
	$("#m3u8").removeClass('m3u8');


})
$('#m3u8').click(function(){
	$('#video_upload').hide();
	$('#video_mp4').hide();
	$('#embedvideo').hide();
	$('#m3u8_url').show();
	$("#video_upload").removeClass('collapse');
	$("#video_mp4").removeClass('collapse');
	$("#embed_video").removeClass('collapse');
	$("#m3u8").addClass('m3u8');


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

var url =$('#m3u8url').val();
$('#m3u8_video_url').change(function(){
	alert($('#m3u8_video_url').val());
	$.ajax({
        url: url,
        type: "post",
data: {
               _token: '{{ csrf_token() }}',
               m3u8_url: $('#m3u8_video_url').val()

         },        success: function(value){
			console.log(value);
            $('#Next').show();
           $('#video_id').val(value.video_id);

        }
    });
})

});
	
</script>
<script>
$.ajaxSetup({
   headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


$(document).ready(function(){
    var url =$('#mp4url').val();
    $('#mp4_url').change(function(){
    alert($('#mp4_url').val());
    $.ajax({
        url: url,
        type: "post",
    data: {
               _token: '{{ csrf_token() }}',
               mp4_url: $('#mp4_url').val()

         },        success: function(value){
            console.log(value);
            $('#Next').show();
           $('#video_id').val(value.video_id);

        }
        });
    })

});
</script>

<script>
$.ajaxSetup({
           headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });


	$(document).ready(function(){

var url =$('#embed_url').val();
$('#embed_code').change(function(){
	alert($('#embed_code').val());
	$.ajax({
        url: url,
        type: "post",
data: {
               _token: '{{ csrf_token() }}',
               embed: $('#embed_code').val()

         },        success: function(value){
			console.log(value);
            $('#Next').show();
           $('#video_id').val(value.video_id);

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
                                <h4 class="card-title">Add Video</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <h5>Video Info Details</h5>
                            <form method="POST" action="{{ $post_route }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-sm-6 form-group" >
                                                <label class="p-2">Title :</label>
                                                <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="">
                                            </div>
                                            <div class="col-sm-6 form-group" >
                                                <label class="p-2">
                                                Video Slug <a class="" data-toggle="tooltip" data-placement="top" title="Please enter the name of the video again here" data-original-title="this is the tooltip" href="#">
                                                <i class="las la-exclamation-circle"></i></a>:</label>
                                                <input type="text"   class="form-control" name="slug" id="slug" placeholder="Video Slug" value="@if(!empty($video->slug)){{ $video->slug }}@endif">
                                            </div>

                                            <div class="col-sm-6 form-group" >
                                                <label class="p-2">Select Video Category :</label>
                                                <select class="form-control" id="video_category_id" name="video_category_id">
                                                    @foreach($video_categories as $category)
                                                    <option value="{{ $category->id }}" @if(!empty($video->video_category_id) && $video->video_category_id == $category->id)selected="selected"@endif>{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-6 form-group" >                               
                                                <div class="panel panel-primary" data-collapsed="0"> 
                                                    <div class="panel-heading"> 
                                                        <div class="panel-title">
                                                            <labe>Cast and Crew</labe> 
                                                        </div> 
                                                        <div class="panel-options"> 
                                                            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> 
                                                        </div>
                                                    </div> 
                                                    <div class="panel-body" style="display: block;"> 
                                                        <p class="p1">Add artists for the video below:</p> 
                                                        <select  name="artists[]" class="js-example-basic-multiple" style="width: 100%;" multiple="multiple">
                                                            @foreach($artists as $artist)
                                                                @if(in_array($artist->id, $video_artist))
                                                                <option value="{{ $artist->id }}" selected="true">{{ $artist->artist_name }}</option>
                                                                @else
                                                                <option value="{{ $artist->id }}">{{ $artist->artist_name }}</option>
                                                                @endif 
                                                            @endforeach
                                                        </select>
                                                    </div> 
                                                </div>
                                            </div>

                                            <div class="col-sm-6 form-group">
                                                <label class="p-2">Choose Language:</label>
                                                <select class="form-control" id="language" name="language">
                                                    <option selected disabled="">Choose Language</option>
                                                    @foreach($languages as $language)
                                                        <option value="{{ $language->id }}" @if(!empty($video->language) && $video->language == $language->id)selected="selected"@endif>{{ $language->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>   
                                            <div class="col-sm-6 form-group">
                                                <label><h5>Age Restrict :</h5></label>
                                                <select class="form-control" id="age_restrict" name="age_restrict">
                                                    <option selected disabled="">Choose Age</option>
                                                    @foreach($age_categories as $age)
                                                        <option value="{{ $age->id }}" @if(!empty($video->language) && $video->age_restrict == $age->id)selected="selected"@endif>{{ $age->slug }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-sm-12 form-group">
                                                <label>Video Thumbnail <span>(16:9 Ratio or 1280X720px)</span></label><br>
                                                <input type="file" accept="video/mp4,video/x-m4v,video/*" name="image" id="image" >
                                                @if(!empty($video->image))
                                                    <img src="{{ URL::to('/') . '/public/uploads/images/' . $video->image }}" class="video-img" width="200" height="200"/>
                                                @endif
                                            </div>
                                            <div class="col-lg-12 form-group">
                                                <h5 class="mb-3">Video description:</h5>
                                                <textarea  rows="5" class="form-control mt-2" name="description" id="summary-ckeditor"
                                            placeholder="Description">@if(!empty($video->description)){{ strip_tags($video->description) }}@endif</textarea>
                                            </div>
                                            <div class="col-12 form-group">
                                                <textarea   rows="5" class="form-control mt-2" name="details" 
                                            placeholder="Link , and details">@if(!empty($video->details)){{ htmlspecialchars($video->details) }}@endif</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <h5>Video Trailer</h5>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8 form-group">

                                        <label class="p-2">Upload Trailer :</label><br>
                                        <div class="new-video-file form_video-upload" style="position: relative;" @if(!empty($video->type) && $video->type == 'upload') style="display:none" @else style="display:block" @endif >
                                            <input type="file" accept="video/mp4,video/x-m4v,video/*" name="trailer" id="trailer">
                                            <p style="font-size: 14px!important;">Drop and drag the video file</p>
                                        </div>
                                        <span id="remove" class="danger">Remove</span>
                                    </div>
                                    <!-- <input type="file" accept="video/mp4,video/x-m4v,video/*" name="trailer" id="trailer" >
                                    <span id="remove" class="danger">Remove</span> -->
                                    
                                    <div class="col-sm-4 form-group">
                                        <!--<p>Upload Trailer video</p>-->
                                        @if(!empty($video->trailer) && $video->trailer != '')
                                            <video width="200" height="200" controls>
                                            <source src="{{ $video->trailer }}" type="video/mp4">
                                            </video>
                                        @endif
                                    </div>
                                </div>
<!--
                                <div class="row mt-5">
                                    <div class="col-sm-6 form-group">
                                        @if(!empty($video->type) && ($video->type == 'upload' || $video->type == 'file' || $video->type == 'mp4_url' || $video->type == 'm3u8_url' ))
                                        <video width="200" height="200" controls>
                                        <source src="<?=$video->mp4_url; ?>" type="video/mp4">
                                        </video>
                                        @endif
-->
                                        <!-- <label><h5>Video Type :</h5></label>
                                        <select id="type" name="type" class="form-control" required>
                                        <option>--Video Type--</option>
                                        <option value="file" @if(!empty($video->type) && $video->type == 'file'){{ 'selected' }}@endif>Video File</option>
                                        <option value="embed" @if(!empty($video->type) && $video->type == 'embed'){{ 'selected' }}@endif >Embed Code</option>
                                        </select>
                                        @if(!empty($video->type) && ($video->type == 'upload' || $video->type == 'file'))
                                        <video width="200" height="200" controls>
                                        <source src="{{ URL::to('/storage/app/public/').'/'.$video->mp4_url }}" type="video/mp4">
                                        </video>
                                        @endif

                                        </div>
                                        -->

                                        <!-- <div class="d-block position-relative" style="left:80px;top:-50px;">
                                        <div class="new-video-embed" @if(!empty($video->type) && $video->type == 'embed')@else  @endif>
                                        <label for="embed_code">Embed Code:</label>
                                        <textarea class="form-control" name="embed_code" id="embed_code">@if(!empty($video->embed_code)){{ $video->embed_code }}@endif</textarea>
                                        </div> -->

<!--
                                        <div class="new-video-file form_video-upload" @if(!empty($video->type) && $video->type == 'upload') style="display:none" @else style="display:block" @endif>
                                             <input type="file" accept="video/mp4,video/x-m4v,video/*" name="video" id="video">
                                            <p style="font-size: 14px!important;">Drop and drag the video file</p> 
                                        </div>
                                    </div>
                                </div>      
-->
                            <div class="row mt-3">    
                                <div class="panel panel-primary" data-collapsed="0"> 
                                    <div class="panel-heading"> 
                                        <div class="panel-title" style="color: #000;">Subtitles (srt or txt)
                                            <a class="iq-bg-warning" data-toggle="tooltip" data-placement="top" title="Please choose language" data-original-title="this is the tooltip" href="#">
                                                <i class="las la-exclamation-circle"></i>
                                            </a>:
                                        </div> 
                                        <div class="panel-options"> 
                                            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> 
                                        </div>
                                    </div> 
                                    <div class="panel-body" style="display: block;"> 
                                        @foreach($subtitles as $subtitle)
                                        <div class="col-sm-6 form-group" style="float: left;">
                                            <div class="align-items-center" style="clear:both;" >
                                                <label for="embed_code"  style="display:block;">Upload Subtitle {{ $subtitle->language }}</label>
                                                <input class="mt-1" type="file" name="subtitle_upload[]" id="subtitle_upload_{{ $subtitle->short_code }}">
                                                <input class="mt-1"  type="hidden" name="short_code[]" value="{{ $subtitle->short_code }}">
                                                <input class="mt-1"  type="hidden" name="sub_language[]" value="{{ $subtitle->language }}">
                                            </div>
                                        </div>
                                        @endforeach
                                    </div> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 form-group mt-3">
                                    <label class="">Video Duration:</label>
                                    <input type="text" class="form-control" placeholder="Video Duration" name="duration" id="duration" value="@if(!empty($video->duration)){{ gmdate('H:i:s', $video->duration) }}@endif">
                                </div> 
                                <div class="col-sm-6 form-group mt-3">
                                    <label class="">Year:</label>
                                    <input type="text" class="form-control" placeholder="Release Year" name="year" id="year" value="@if(!empty($video->year)){{ $video->year }}@endif">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 form-group mt-3">
                                    <label class="p-2">User Access</label>
                                    <select id="access" name="access"  class="form-control" >
                                        <option value="subscriber" >Subscriber ( Must subscribe to watch )</option>
                                        <option value="registered" >Registered Users( Must register to watch )</option>   
                                        <?php if($settings->ppv_status == 1){ ?>
                                        <option value="ppv" >PPV Users (Pay per movie)</option>   
                                        <?php } else{ } ?>
                                    </select>
                                </div> 
                                <div class="col-sm-6 form-group mt-3">
                                    <div class="row">
                                        <div class="col-sm-6 form-group">
                                            <label class="p-2">Movie Language:</label>
                                            <select class="form-control" id="language" name="language">
                                                <option selected disabled="">Choose Language</option>
                                                @foreach($languages as $language)
                                                    <option value="{{ $language->id }}" @if(!empty($video->language) && $video->language == $language->id)selected="selected"@endif>{{ $language->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            <label class="p-2">Rating:</label>
                                            <input type="text" class="form-control" placeholder="Movie Ratings" name="rating" id="rating" value="@if(!empty($video->rating)){{ $video->rating }}@endif" onkeyup="NumAndTwoDecimals(event , this);">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 form-group mt-3" id="ppv_price">
                                    <label class="">PPV Price:</label>
                                    <input type="text" class="form-control" placeholder="PPV Price" name="ppv_price" id="price" value="@if(!empty($video->ppv_price)){{ $video->ppv_price }}@endif">
                                </div>
                                <div class="col-sm-6 mt-3"> 
                                    <div class="panel panel-primary" data-collapsed="0"> 
                                        <div class="panel-heading"> 
                                            <div class="panel-title">
                                                <label> Status Settings</label>
                                            </div> 
                                            <div class="panel-options"> 
                                                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> 
                                            </div>
                                        </div> 
                                        <div class="panel-body"> 
                                            <div>
                                                <label for="featured">Is this video Featured:</label>
                                                <input type="checkbox" @if(!empty($video->featured) && $video->featured == 1){{ 'checked="checked"' }}@endif name="featured" value="1" id="featured" />
                                            </div>
                                            <div class="clear"></div>
                                            <div>
                                                <label for="active">Is this video Active:</label>
                                                <input type="checkbox" @if(!empty($video->active) && $video->active == 1){{ 'checked="checked"' }}@elseif(!isset($video->active)){{ 'checked="checked"' }}@endif name="active" value="1" id="active" />
                                            </div>
                                            <div class="clear"></div>
                                        </div> 
                                    </div>
                                </div>
                            </div>

                                @if(isset($video->id))
                                    <input type="hidden" id="id" name="id" value="{{ $video->id }}" />
                                @endif

                                <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                                <div class="col-12 form-group" style="display: flex;justify-content: flex-end;">
                                    <button type="submit" style="margin-right: 10px;" class="btn btn-primary" value="{{ $button_text }}">{{ $button_text }}</button>
                                    <button type="reset" class="btn btn-danger">cancel</button>
                                </div>
                                <input type="hidden" id="video_id" name="video_id" value="">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
      <input type="hidden" id="base_url" value="<?php echo URL::to('/');?>">

      <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script type="text/javascript">
 $ = jQuery;
 $('#remove').hide();
 
$(document).ready(function(){
$('#trailer').change(function(){
var remove = $('#trailer').val();
// alert(remove)
if(remove != ""){
 $('#remove').show();
}else{
 $('#remove').hide();
}     
$('#remove').click(function(){ 
   $('#trailer').val("");
 $('#remove').hide();
});

});
});

$(document).ready(function(){
    $('#ppv_price').hide();
    
		$("#access").change(function(){
			if($(this).val() == 'ppv'){
				$('#ppv_price').show();

			}else{
				$('#ppv_price').hide();				
			}
		});
});
	$(document).ready(function(){
    $('.js-example-basic-multiple').select2();
    
		$("#type").change(function(){
			if($(this).val() == 'file'){
				$('.new-video-file').show();
				$('.new-video-embed').show();

			} else if($(this).val() == 'embed'){ 
				$('.new-video-file').hide();
				$('.new-video-embed').show();

			}else{
				$('.new-video-file').hide();
				$('.new-video-embed').hide();
				
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
       alert(); 
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

<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

<script>
CKEDITOR.replace( 'summary-ckeditor', {
    filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
    filebrowserUploadMethod: 'form'
});
</script>

<script>

  $('input[type="checkbox"]').on('change', function(){
     this.value = this.checked ? 1 : 0;
  }).change();
  </script>



        </div>

</div>

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
        acceptedFiles: "video/mp4,video/x-m4v,video/*",
    });
    myDropzone.on("sending", function(file, xhr, formData) {
       formData.append("_token", CSRF_TOKEN);
      // console.log(value)
      this.on("success", function(file, value) {
            console.log(value.video_title);
            $('#Next').show();
           $('#video_id').val(value.video_id);
           $('#title').val(value.video_title);

           
        });

    }); 



    $('#Next').click(function(){
  $('#video_upload').hide();
  $('#video_mp4').hide();
  $('#embedvideo').hide();
  $('#optionradio').hide();
  $('.content_videopage').hide();
  $('#content_videopage').hide();


  $('#Next').hide();
  $('#video_details').show();

  });
    </script>
@extends('moderator.master')
<?php 

?>

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop
 
    <style>
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
.error{
        color: red;
    }
   </style>

@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <!-- <script src="http://malsup.github.com/jquery.form.js"></script> -->
   
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
                     <div class="iq-card-body">
                         <h5>Video Info Details</h5>
                        <form method="POST" action="{{ $post_route }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data" id="cpp_video_edit">
                        <div class="row">
                              <div class="col-lg-12">
                                 <div class="row">
                                    <input type="hidden" class="form-control"  name="ppv_price" id="price" value="@if(!empty($video->ppv_price)){{ $video->ppv_price }}@endif">
                                    <div class="col-sm-6 form-group" >
                                        <label class="p-2">Title :</label>
                                       <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="@if(!empty($video->title)){{ $video->title }}@endif">
                                    </div>
                                    <div class="col-sm-6 form-group" >
                                         <label class="p-2">
                                             Video Slug <a class="iq-bg-warning" data-toggle="tooltip" data-placement="top" title="Please enter the name of the video again here" data-original-title="this is the tooltip" href="#">
                                             <i class="las la-exclamation-circle"></i></a>:</label>
                                       <input type="text"   class="form-control" name="slug" id="slug" placeholder="Video Slug" value="@if(!empty($video->slug)){{ $video->slug }}@endif">
                                    </div>
                                    
                                     <div class="col-sm-6 form-group" >
                                       <label class="p-2">Select Video Category :</label>
                                       <select class="form-control" id="video_category_id" name="video_category_id">
                                           <option value="">Choose Category </option>
						                        @foreach($video_categories as $category)
                                          <option value="{{ $category->id }}" @if(!empty($video->video_category_id) && $video->video_category_id == $category->id)selected="selected"@endif>{{ $category->name }}</option>
						                        @endforeach

                                       </select>
                                                                          </div>
                                           <div class="col-sm-6 form-group" >                               
                                          <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
                                      <div class="panel-title">Cast and Crew </div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
                                      <div class="panel-body" style="display: block;"> 
                                        <p>Add artists for the video below:</p> 
                                        <select name="artists[]" class="js-example-basic-multiple" style="width: 100%;" multiple="multiple">
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
                              <div class="col-sm-6 form-group mt-3">
                                         <label><h5>Age Restrict :</h5></label>
                                         <select class="form-control" id="age_restrict" name="age_restrict">
                                                    <option selected disabled="">Choose Age</option>
                                                    @foreach($age_categories as $age)
                                                        <option value="{{ $age->slug }}" @if(!empty($video->language) && $video->age_restrict == $age->slug)selected="selected"@endif>{{ $age->slug }}</option>
                                                    @endforeach
                                                </select>
                                      </div>
                                 <div class="col-sm-12 form-group">
                                     
                                      <label>Thumbnail <span>(16:9 Ratio or 1280X720px)</span></label><br>
                                     <input type="file"  name="image" id="image" >
                                  
                                     @if(!empty($video->image))
                                       <img src="{{ URL::to('/') . '/public/uploads/images/' . $video->image }}" class="video-img" width="200" height="200"/>
                                    @endif
                                 </div>
                                   <!-- <div class="col-md-6 form-group">
                                       <select class="form-control" id="video_category_id" name="video_category_id">
                                       <option value="0">Uncategorized</option>
						                        @foreach($video_categories as $category)
                                          <option value="{{ $category->id }}" @if(!empty($video->video_category_id) && $video->video_category_id == $category->id)selected="selected"@endif>{{ $category->name }}</option>
						                        @endforeach

                                       </select>
                                    </div>
                                    <div class="col-sm-6 form-group">
                                          <select id="type" name="type" class="form-control" required>
                                             <option>--Select Video Type--</option>
                                             <option value="file" @if(!empty($video->type) && $video->type == 'file'){{ 'selected' }}@endif>Video File</option>
                                             <option value="embed" @if(!empty($video->type) && $video->type == 'embed'){{ 'selected' }}@endif >Embed Code</option>
                                          </select>   
                                    </div>-->
                                     
                                    <div class="col-lg-12 form-group">
                                        <h5>Video description:</h5>
                                       <textarea  rows="5" class="form-control" name="description" id="summary-ckeditor"
                                          placeholder="Description">@if(!empty($video->description)){{ strip_tags($video->description) }}@endif</textarea>
                                    </div>
                                    <div class="col-12 form-group">
                                       <textarea   rows="5" class="form-control" name="details" 
                                          placeholder="Link , and details">@if(!empty($video->details)){{ htmlspecialchars($video->details) }}@endif</textarea>
                                    </div>
                                 </div>
                              </div>
                              
                            
                           </div>
                            <div>
                                <h5>Video Upload</h5>
                            </div>
                            <div class="row mt-5">
                            <?php  if(!empty($video->embed_code)){ ?>
                                <div class="col-sm-6 form-group">
                                <label for="embed_code"><label>Embed URL:</label></label>
                                    <input type="text" class="form-control" name="embed_code" value="@if(!empty($video->embed_code)){{ $video->embed_code }}@endif"  />
                                </div>
                                <?php   }elseif(!empty($video->mp4_url) && !empty($video->path)){ ?>
                                <div class="col-sm-6 form-group">
                                    <?php if(!empty($video->embed_code  || $video->mp4_url  || $video->m3u8_url )) { ?>
                                    @if(!empty($video->type) && ($video->type == 'upload' || $video->type == 'file' || $video->type == 'mp4_url' || $video->type == 'm3u8_url' ))
                                    <video width="200" height="200" controls>
                                    <source src="<?=$video->mp4_url; ?>" type="video/mp4">
                                    </video>
                                    @endif
                                    <?php }else{
                                        echo "NO Video Uploaded";
                                        }?>
                                </div>
                                <?php   } elseif(!empty($video->mp4_url)){ ?>
                                <div class="col-sm-6 form-group">
                                <label for="mp4_url">Mp4 URL:</label>
                                    <input type="text" class="form-control" name="mp4_url" id="mp4_url" value="@if(!empty($video->mp4_url)){{ $video->mp4_url }}@endif" />
                                </div>
                                <?php  }elseif(!empty($video->m3u8_url)){ ?>
                                <div class="col-sm-12 form-group">
                                    <div class="col-sm-8">
                                <label for="m3u8_url">m3u8 URL:</label>
                                    <input type="text" class="form-control" name="m3u8_url" id="m3u8_url" value="@if(!empty($video->m3u8_url)){{ $video->m3u8_url }}@endif">
                                    </div>
                                </div>
                                   <?php } ?>
                            </div>
                            <div class="row">
                                <label class="p-2">Upload Trailer :</label>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div style="position: relative" class="form_video-upload"  @if(!empty($video->type) && $video->type == 'upload') style="display:none" @else style="display:block" @endif>
                                        <input type="file" accept="video/mp4,video/x-m4v,video/*" name="trailer" id="trailer" >
                                        <p style="font-size: 14px!important;">Drop and drag the video file</p>
                                    </div>
                                </div>
                                <div class="col-sm-6 form-group">
                                <?php if(!empty($video->trailer) && $video->trailer != '') { ?>
                                    @if(!empty($video->trailer) && $video->trailer != '')
                                    <video width="200" height="200" controls>
                                        <source src="{{ $video->trailer }}" type="video/mp4">
                                    </video>
                                    @endif
                                    <?php }else{
                                        echo "NO Video Uploaded";
                                        }?>
                                </div>

                            </div>
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
                                <div class="col-sm-6 form-group">
                                    <label class="">Video Duration:</label>
                                    <input type="text" class="form-control" placeholder="Video Duration" name="duration" id="duration" value="@if(!empty($video->duration)){{ gmdate('H:i:s', $video->duration) }}@endif">
                                </div> 
                                <div class="col-sm-6 form-group">
                                    <label class="">Year:</label>
                                    <input type="text" class="form-control" placeholder="Release Year" name="year" id="year" value="@if(!empty($video->year)){{ $video->year }}@endif">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6 form-group">
                                <label class="p-2">Rating:</label>
                                    <!-- selected="true" -->
                                    <!-- <input type="text" class="form-control" placeholder="Movie Ratings" name="rating" id="rating" value="@if(!empty($video->rating)){{ $video->rating }}@endif" onkeyup="NumAndTwoDecimals(event , this);"> -->
                                    <select  class="js-example-basic-single" style="width: 100%;" name="rating" id="rating" tags= "true" onkeyup="NumAndTwoDecimals(event , this);" >
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
                                <div class="col-sm-6 form-group">
                                    <label class="p-2">User Access:</label>
                                    <select id="access" name="access"  class="form-control" >
                                        <option value="subscriber" @if(!empty($video->access) && $video->access == 'subscriber'){{ 'selected' }}@endif>Subscriber ( Must subscribe to watch )</option>
                                        <!-- <option value="guest" @if(!empty($video->access) && $video->access == 'guest'){{ 'selected' }}@endif>Guest (everyone)</option> -->
                                        <option value="registered" @if(!empty($video->access) && $video->access == 'registered'){{ 'selected' }}@endif>Registered Users( Must register to watch )</option>   
                                        <?php if($settings->ppv_status == 1){ ?>
                                        <option value="ppv" @if(!empty($video->access) && $video->access == 'ppv'){{ 'selected' }}@endif>PPV Users (Pay per movie)</option>   
                                        <?php } else{ ?>
                                        <option value="ppv" @if(!empty($video->access) && $video->access == 'ppv'){{ 'selected' }}@endif>PPV Users (Pay per movie)</option>   
                                        <?php } ?>
                                    </select>
                                </div> 
                                
                                
                            <!--
                            <div class="col-sm-6 form-group">>
                            <label class="">Movie Language:</label>
                            <select class="form-control" id="language" name="language">
                            <option selected disabled="">Choose Language</option>
                            @foreach($languages as $language)
                            <option value="{{ $language->id }}" @if(!empty($video->language) && $video->language == $language->id)selected="selected"@endif>{{ $language->name }}</option>
                            @endforeach
                            </select>
                            </div>
                            -->
                                
                            </div>
                            <div class="row">
                                <div class="col-sm-6 form-group mt-3" id="ppv_price">
                                    <label class="">PPV Price:</label>
                                    <input type="text" class="form-control" placeholder="PPV Price" name="ppv_price" id="price" value="@if(!empty($video->ppv_price)){{ $video->ppv_price }}@endif">
                                </div>
                                <div class="col-sm-6 form-group mt-3" id="ppv_price">
                                <?php if($settings->ppv_status == 1){ ?>
                                    <label for="global_ppv">Get Pricing from Global PPV Rates Set:</label>
                                    <input type="checkbox" name="global_ppv" id="global_ppv"  {{$video->global_ppv == '1' ? 'checked' : ''}}  />
                                    <?php } else{ ?>
                                        <div class="global_ppv_status">
                                        <label for="global_ppv">Get Pricing from Global PPV Rates Set:</label>
                                    <input type="checkbox" name="global_ppv" id="global_ppv" {{$video->global_ppv == '1' ? 'checked' : ''}}   />
                                        </div>
                                        <?php } ?>
                                </div>
                                <div class="col-sm-6 form-group mt-3"> 
                                    <label for="enable">Is this video :</label>
                                        <div class="make-switch d-flex align-items-center" data-on="success" data-off="warning">
                                    <div><label class="mr-1">Enable</label></div>
                                 <div>
                                   <label class="switch">
                                <input type="checkbox"  @if ($video->enable == 1) {{ "checked='checked'" }} @else {{ "" }} @endif name="enable" id="enable">
                                <span class="slider round"></span>
                                </label></div>
                                <div><label class="ml-1">Disable</label></div>
                                </div>
                                </div>
                         
                        <div>
                            <h5>Publish Type</h5>
                                </div>
                            <div class="row">

                                <div class="col-sm-6 form-group mt-3" >
                                    <!-- <label class="">Choose Ad Name</label> -->
                            <input type="radio" id="publish_now" name="publish_type" value = "publish_now" {{ !empty(($video->publish_type=="publish_now"))? "checked" : "" }}>Publish Now <br>
							<input type="radio" id="publish_later" name="publish_type" value = "publish_later"{{ !empty(($video->publish_type=="publish_later"))? "checked" : "" }} >Publish Later
                                </div>
                                <div class="col-sm-6 form-group mt-3" id="publishlater">
                                    <label class="">Publish Time</label>
			                    <input type="datetime-local" class="form-control" id="publish_time" name="publish_time" value="@if(!empty($video->publish_time)){{ $video->publish_time }}@endif">
                                </div>
                            </div>
                            <div class="row">
                            <div class="col-sm-4 form-group mt-3">
                            <label class="">Skip Intro Time</label>
				            <p>Please Give In Seconds</p> 
                            <input type="text" class="form-control" id="skip_intro" name="skip_intro" value="@if(!empty($video->skip_intro)){{ $video->skip_intro }}@endif">
                            </div>
                            <div class="col-sm-4 form-group mt-3">
                            <label class="">Recap Start Time</label>
                            <p>Please Give In Seconds</p> 
                            <input type="text"  class="form-control without" id="intro_start_time" name="intro_start_time" value="@if(!empty($video->intro_start_time)){{ $video->intro_start_time }}@endif" >
                            </div>
                            <div class="col-sm-4 form-group mt-3">
                            <label class="">Recap End Time</label>
                            <p>Please Give In Seconds</p> 
                            <input type="text"  class="form-control without" id="intro_end_time" name="intro_end_time" value="@if(!empty($video->intro_end_time)){{ $video->intro_end_time }}@endif" >
                            </div>
                            </div>

                            <div class="row">
                            <div class="col-sm-4 form-group mt-3">
                            <label class="">Skip Recap Time</label>
                            <p>Please Give In Seconds</p> 
                            <input type="text" class="form-control" id="skip_recap" name="skip_recap" value="@if(!empty($video->skip_recap)){{ $video->skip_recap }}@endif">
                            </div>
                            <div class="col-sm-4 form-group mt-3">
                            <label class="">Recap Start Time</label>
                            <p>Please Give In Seconds</p> 
                            <input type="text"  class="form-control without" id="recap_start_time" name="recap_start_time"  value="@if(!empty($video->recap_start_time)){{ $video->recap_start_time }}@endif">
                            </div>
                            <div class="col-sm-4 form-group mt-3">
                            <label class="">Recap End Time</label>
                            <p>Please Give In Seconds</p> 
                            <input type="text"  class="form-control without" id="recap_end_time" name="recap_end_time"  value="@if(!empty($video->recap_end_time)){{ $video->recap_end_time }}@endif" >
                            </div>
                            </div>

                              @if(isset($video->id))
                                 <input type="hidden" id="id" name="id" value="{{ $video->id }}" />
                                 <input type="hidden" id="publish_status" name="publish_status" value="{{ $video->publish_status }}" >
                                 <input type="hidden" id="type" name="type" value="{{ $video->type }}" />
                              @endif

                              <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                              <div class="col-12 d-flex justify-content-end form-group ">
                                 <button type="submit" class="btn btn-primary mr-2" value="{{ $button_text }}">{{ $button_text }}</button>
                                 <button type="reset" class="btn btn-danger">cancel</button>
                              </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
          <style type="text/css">

.without::-webkit-datetime-edit-ampm-field {
   display: none;
 }
</style>

	<input type="hidden" id="base_url" value="<?php echo URL::to('/');?>">
	
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>                       
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />
     <script>
        $('#intro_start_time').datetimepicker(
        {
            format: 'hh:mm '
        });
        $('#intro_end_time').datetimepicker(
        {
            format: 'hh:mm '
        });
        $('#recap_start_time').datetimepicker(
        {
            format: 'hh:mm '
        });
        $('#recap_end_time').datetimepicker(
        {
            format: 'hh:mm '
        });
</script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css" /> -->
<!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" /> -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>
<script type="text/javascript">
//     $(function () {
//         $('#timepicker').timepicker({
//             showMeridian: false,
//             showInputs: true
//         });
//     });
</script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="<?= URL::to('/assets/js/jquery.mask.min.js');?>"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
  <script type="text/javascript">
 $ = jQuery;

 $(document).ready(function($){
    
    $('#duration').mask("00:00:00");

});

 $('#publishlater').hide();
 
$(document).ready(function(){
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
	$('#publishlater').show();
	}else if($("#publish_later").val() == 'publish_later'){
		$('#publishlater').hide();		
	}
});
	$(document).ready(function(){
    $('.js-example-basic-multiple').select2();
    $('.js-example-basic-single').select2();

    
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
        $(document).ready(function(){
    // $('#ppv_price').hide();
    if($("#access").val() == 'ppv'){
				$('#ppv_price').show();
				$('#global_ppv_status').show();


			}else{
				$('#ppv_price').hide();		
				$('#global_ppv_status').hide();				

			}
    
		$("#access").change(function(){
			if($(this).val() == 'ppv'){
				$('#ppv_price').show();
				$('#global_ppv_status').hide();

			}else{
				$('#ppv_price').hide();		
				$('#global_ppv_status').show();				

			}
		});
    });

// alert();

 

		// tinymce.init({
		// 	relative_urls: false,
		//     selector: '#details',
		//     toolbar: "styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | preview media | forecolor backcolor | code",
		//     plugins: [
		//          "advlist autolink link image code lists charmap print preview hr anchor pagebreak spellchecker code fullscreen",
		//          "save table contextmenu directionality emoticons template paste textcolor code"
		//    ],
		//    menubar:false,
		//  });

	});

	

   function NumAndTwoDecimals(e , field) {
    //    alert(); 
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
      <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

<script>
    $(document).ready(function(){
        // $('#message').fadeOut(120);
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);
    })
</script>
@section('javascript')

	{{-- validate --}}

	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
	<script>
		$('form[id="cpp_video_edit"]').validate({
			rules: {
                title : 'required',
                video_category_id : 'required'
				},
			submitHandler: function(form) {
				form.submit(); }
			});
	</script>

@stop

@stop

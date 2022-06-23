@extends('admin.master')

@include('admin.favicon')

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
        background: rgb(255 255 255 / 100%);
        border-radius: 10px;
        text-align: center;
        margin: 0 auto;
        /*width: 75%;*/
        border: 2px dashed;
    }
   #video_upload .file form i {display: block; font-size: 50px;}


   
   .form-control1 {
	 display: block;
	 width: 100%;
	 font-size: 14px;
	 height: 34px;
	 padding: 4px 8px;
	 margin-bottom: 15px;
}
 *, *:before, *:after {
	 box-sizing: border-box;
}
 .tags-container {
	 display: flex;
	 flex-flow: row wrap;
	 margin-bottom: 15px;
	 width: 100%;
	 min-height: 34px;
	 padding: 2px 5px;
	 font-size: 14px;
	 line-height: 1.6;
	 background-color: transparent;
	 border: 1px solid #ccc;
	 border-radius: 1px;
	 overflow: hidden;
	 word-wrap: break-word;
	 box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
}
 input.tag-input {
	 flex: 3;
	 border: 0;
	 outline: 0;
}
 .tag {
	 position: relative;
	 margin: 2px 6px 2px 0;
	 padding: 1px 20px 1px 8px;
	 font-size: inherit;
	 font-weight: 400;
	 text-align: center;
	 color: #20222c;
     height: 30px;
     display: flex;
     align-items: center;
	 background-color: #f8f9fa;
	 border-radius: 3px;
	 transition: background-color 0.3s ease;
	 cursor: default;
}
 .tag:first-child {
	 margin-left: 0;
}
 .tag--marked {
	 background-color: #6fadd7;
}
 .tag--exists {
	 background-color: #edb5a1;
	 animation: shake 1s linear;
}
 .tag__name {
	 margin-right: 3px;
}
 .tag__remove {
	  position: absolute;
	 right: 0;
	 bottom: 0;
	 width: 20px;
	 height: 100%;
	 padding: 0 5px;
	 font-size: 16px;
	 font-weight: 400;
	 transition: opacity 0.3s ease;
	 opacity: 0.5;
	 cursor: pointer;
	 border: 0;
	 background-color: #000;
	 color: #fff;
}
 .tag__remove:hover {
	 opacity: 1;
}
 .tag__remove:focus {
	 outline: 5px auto #fff;
}
 @keyframes shake {
	 0%, 100% {
		 transform: translate3d(0, 0, 0);
	}
	 10%, 30%, 50%, 70%, 90% {
		 transform: translate3d(-5px, 0, 0);
	}
	 20%, 40%, 60%, 80% {
		 transform: translate3d(5px, 0, 0);
	}
}
</style>
<div id=" content_videopage" class="content-page">
    <div class="mt-5 d-flex">
                        <a class="black" href="{{ URL::to('admin/videos') }}">All Videos</a>
                        <a class="black" style="background:#fafafa!important;color: #006AFF!important;" href="{{ URL::to('admin/videos/create') }}">Add New Video</a>
                        <a class="black" href="{{ URL::to('admin/CPPVideosIndex') }}">Videos For Approval</a>
                        <a class="black" href="{{ URL::to('admin/Masterlist') }}" class="iq-waves-effect"> Master Video List</a>
                       <a class="black" href="{{ URL::to('admin/videos/categories') }}">Manage Video Categories</a>
                       <a class="black"  href="{{ URL::to('admin/ActiveSlider') }}">Active Slider List</a>
                     </div>
   <div class="container-fluid p-0" id="content_videopage">
      <div class="admin-section-title">
         <div class="iq-card">
            <div class="row">
               
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
                        <label for="embed_code">Embed URL:</label>
                        <p class="p1">Example URL Format : ( https://www.youtube.com/embed/*xxxxxxxxx*/) ) </p>
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
                        <h3 class="card-title upload-ui font-weight-bold">Upload Full Video Here</h4>
                        <!-- Dropzone -->
                        <form action="{{URL::to('admin/uploadFile')}}" method= "post" class='dropzone' ></form>
                        <div class="row justify-content-center">
                           <div class="col-md-9 text-center">
                           <p class="c1" style="margin-left: 25%;">Trailers Can Be Uploaded From Video Edit Screen</p>
                           </div>
                           <div class="col-md-3" style="display: flex;" >
                           <p id="speed">speed: 0kbs</p>&nbsp;&nbsp;&nbsp;
                           <p id="average">average: 0kbs</p>
                           </div>
                        </div>
                     </div>
                     
                  </div>
                  <div class="text-center" style="margin-top: 30px;">
                     <input type="button" id="Next" value='Proceed to Next Step' class='btn btn-primary'>
                  </div>
                  <input type="hidden" id="embed_url" value="<?php echo URL::to('/admin/embededcode');?>">
                  <input type="hidden" id="mp4url" value="<?php echo URL::to('/admin/mp4url');?>">
                  <input type="hidden" id="m3u8url" value="<?php echo URL::to('/admin/m3u8url');?>">
               </div>
               <hr />
            </div>

               <div class="col-md-12 text-right">
                  <div id="optionradio"  >
                     <input type="radio" class="text-black" value="videoupload" id="videoupload" name="videofile" checked="checked"> Video Upload &nbsp;&nbsp;&nbsp;
                     <input type="radio" class="text-black" value="m3u8"  id="m3u8" name="videofile"> m3u8 Url &nbsp;&nbsp;&nbsp;
                     <input type="radio" class="text-black" value="videomp4"  id="videomp4" name="videofile"> Video mp4 &nbsp;&nbsp;&nbsp;
                     <input type="radio" class="text-black" value="embed_video"  id="embed_video" name="videofile"> Embed Code              
                  </div>
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
         	//$("#embed_video").addClass('collapse');
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
        // alert($('#m3u8_video_url').val());
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
       // alert($('#mp4_url').val());
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
   	// alert($('#embed_code').val());
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
   <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
   @stop
   @section('content')
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
   <script src="https://malsup.github.io/jquery.form.js"></script>
   <div id="content-page" class="content-page1" style="padding:0px!important;">
      
      <div class="container-fluid">
          
           <div class="iq-card " style="padding:40px;">
         <div class="row justify-content-center">
            <div class="col-11 col-sm-10 col-md-10 col-lg-12 col-xl-12 text-center p-0 mt-3 mb-2">
               <div class="px-0 pt-4 pb-0 mt-12 mb-3 col-md-12">
                  <!-- <h2 id="heading">Sign Up Your User Account</h2>
                     <p>Fill all form field to go to next step</p> -->
                  <form method="POST" action="{{ $post_route }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data" id="msform">
                     <!-- progressbar -->
                     <ul id="progressbar">
                        <li class="active" id="account"><img class="" src="<?php echo  URL::to('/assets/img/icon/1.svg')?>">Video Details</li>
                        <li id="personal"><img class="" src="<?php echo  URL::to('/assets/img/icon/2.svg')?>">Category</li>
                        <li id="useraccess_ppvprice"><img class="" src="<?php echo  URL::to('/assets/img/icon/3.svg')?>">User Video Access</li>
                        <!-- <li id="payment"><strong>Upload Image & Trailer</strong></li> -->
                        <li id="payment"><img class="" src="<?php echo  URL::to('/assets/img/icon/4.svg')?>">Upload Image &amp; Trailer</li>
                        <li id="confirm"><img class="" src="<?php echo  URL::to('/assets/img/icon/5.svg')?>">Ads Management</li>
                     </ul>
                     <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                     </div>
                     <br> <!-- fieldsets -->
                     <fieldset id="slug_validate">
                        <div class="form-card">
                           <div class="row">
                              <div class="col-7">
                                 <h2 class="fs-title">Video Information:</h2>
                              </div>
                              <div class="col-5">
                                 <!-- <h2 class="steps">Step 1 - 4</h2> -->
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-sm-6 form-group" >
                                 <label class="m-0">Title :</label>
                                 <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="">
                              </div>

                              <div class="col-sm-6 form-group" >
                                 <label class="m-0">
                                    Video Slug 
                                    <a class="" data-toggle="tooltip" data-placement="top" title="Please enter the URL Slug" data-original-title="this is the tooltip" href="#">
                                       <i class="las la-exclamation-circle"></i>
                                    </a>:
                                  </label>

                                 <input type="text"   class="form-control" name="slug" id="slug" placeholder="Video Slug" value="@if(!empty($video->slug)){{ $video->slug }}@endif">
                                 <span><p id="slug_error" style="color:red;">This slug already used </p></span>
                              </div>

                           </div>
                           <div class="row">
                              <div class="col-sm-6 form-group">
                                 <label class="m-0">
                                    Age Restrict :
                                 </label>
                                 <select class="form-control" id="age_restrict" name="age_restrict">
                                    <option selected  value="0">Choose Age</option>
                                    @foreach($age_categories as $age)
                                    <option value="{{ $age->age }}" @if(!empty($video->language) && $video->age_restrict == $age->slug)selected="selected"@endif>{{ $age->slug }}</option>
                                    @endforeach
                                 </select>
                              </div>
                              <div class="col-sm-6 form-group ">
                                 <label class="m-0">Rating:</label>
                                 <!-- <input type="text" class="form-control" placeholder="Movie Ratings" name="rating" id="rating" value="@if(!empty($video->rating)){{ $video->rating }}@endif" onkeyup="NumAndTwoDecimals(event , this);"> -->
                                 <select  class="js-example-basic-single" style="width: 100%;" name="rating" id="rating" tags= "true" onkeyup="NumAndTwoDecimals(event , this);">
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
                           <div class="row">
                              <div class="col-lg-12 form-group">
                                 <label class="m-0">Video Description:</label>
                                 <textarea  rows="5" class="form-control mt-2" name="description" id="summary-ckeditor"
                                    placeholder="Description">@if(!empty($video->description)){{ strip_tags($video->description) }}@endif</textarea>
                              </div>
                              <div class="col-12 form-group">
                                 <label class="m-0">Links &amp; Details:</label>
                                 <textarea   rows="5" class="form-control mt-2" name="details" id="links-ckeditor"
                                    placeholder="Link , and details">@if(!empty($video->details)){{ strip_tags($video->details) }}@endif</textarea>
                              </div>
                           </div>
                            <div class="row">
                              <div class="col-sm-4 form-group">
                                 <label class="m-0">Skip Intro Time <small>(Please Give In Seconds)</small></label>
                                 <input type="text" class="form-control" id="skip_intro" name="skip_intro" value="@if(!empty($video->skip_intro)){{ gmdate('H:i:s', $video->skip_intro) }}@endif">
                                 <span><p id="error_skip_intro_time" style="color:red;">* Fill Skip Intro Time </p></span>
                              </div>
                              <div class="col-sm-4 form-group">
                                 <label class="m-0">Intro Start Time <small>(Please Give In Seconds)</small></label>
                                 <input type="text" class="form-control" id="intro_start_time" name="intro_start_time" value="@if(!empty($video->intro_start_time)){{ gmdate('H:i:s', $video->intro_start_time) }}@endif">
                                 <span><p id="error_intro_start_time" style="color:red;">* Fill Intro Start Time </p></span>
                              </div>
                              <div class="col-sm-4 form-group">
                                 <label class="m-0">Intro End Time <small>(Please Give In Seconds)</small></label>
                                 <input type="text" class="form-control" id="intro_end_time" name="intro_end_time" value="@if(!empty($video->intro_end_time)){{ gmdate('H:i:s', $video->intro_end_time) }}@endif">
                                 <span><p id="error_intro_end_time" style="color:red;">* Fill Intro End Time </p></span>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-sm-4 form-group">
                                 <label class="m-0">Skip Recap <small>(Please Give In Seconds)</small></label>
                                 <input type="text" class="form-control" id="skip_recap" name="skip_recap" value="@if(!empty($video->skip_recap)){{ gmdate('H:i:s', $video->skip_recap) }}@endif">
                                 <span><p id="error_skip_recap_time" style="color:red;">* Fill Skip Recap Time </p></span>
                              </div>
                              <div class="col-sm-4 form-group">
                                 <label class="m-0">Recap Start Time <small>(Please Give In Seconds)</small></label>
                                 <input type="text" class="form-control" id="recap_start_time" name="recap_start_time" value="@if(!empty($video->recap_start_time)){{ gmdate('H:i:s', $video->recap_start_time) }}@endif">
                                 <span><p id="error_recap_start_time" style="color:red;" >* Fill Recap Start Time </p></span>
                              </div>
                              <div class="col-sm-4 form-group">
                                 <label class="m-0">Recap End Time <small>(Please Give In Seconds)</small></label>
                                 <input type="text" class="form-control" id="recap_end_time" name="recap_end_time" value="@if(!empty($video->recap_end_time)){{ gmdate('H:i:s', $video->recap_end_time) }}@endif">
                                 <span><p id="error_recap_end_time" style="color:red;" >* Fill Recap End Time </p></span>
                              </div>
                           </div>
                           <div class="row">
                              {{-- <div class="col-sm-6 form-group">
                                 <label class="m-0">Video Duration:</label>
                                 <input type="text" class="form-control" placeholder="Video Duration" name="duration" id="duration" value="@if(!empty($video->duration)){{ gmdate('H:i:s', $video->duration) }}@endif">
                              </div> --}}
                              <div class="col-sm-4 form-group">
                                 <label class="m-0">Year:</label>
                                 <input type="text" class="form-control" placeholder="Release Year" name="year" id="year" value="@if(!empty($video->year)){{ $video->year }}@endif">
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-sm-6 form-group">
                                 <label class="mb-2" style="display:block;">Publish Type</label>
                                 <input type="radio" id="publish_now" name="publish_type" value = "publish_now" checked="checked" > Publish Now <br>
                                 <input type="radio" id="publish_later" name="publish_type" value = "publish_later" > Publish Later
                              </div>
                              <div class="col-sm-6 form-group" id="publishlater">
                                 <label class="m-0">Publish Time</label>
                                 <input type="datetime-local" class="form-control" id="publish_time" name="publish_time" >
                              </div>
                           </div>
                        </div>
                        <input type="button" name="next" class="next action-button" id="next2" value="Next" />
                     </fieldset>

                     <fieldset class="Next3">
                        <div class="form-card">
                           <div class="row">
                              <div class="col-sm-6 form-group" >
                                 <label class="m-0">Select Video Category :</label>
                                 <select class="form-control js-example-basic-multiple" id="video_category_id" name="video_category_id[]" style="width: 100%;" multiple="multiple">
                                    <!-- {{-- <option value="">Choose category</option>  --}} -->
                                    @foreach($video_categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                 </select>
                                 <span><p id="error_video_Category" style="color:red;" >* Choose the Video Category </p></span>
                              </div>
                              <div class="col-sm-6 form-group" >
                                 <div class="panel panel-primary" data-collapsed="0">
                                    <div class="panel-heading">
                                       <div class="panel-title">
                                          <label class="m-0">Cast and Crew : <small>( Add artists for the video below )</small></label>
                                       </div>
                                       <div class="panel-options"> 
                                          <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> 
                                       </div>
                                    </div>
                                    <div class="panel-body" style="display: block;">
                                       
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
                           </div>
                           <div class="row">
                              <div class="col-sm-6 form-group">
                                 <label class="m-0">Choose Language:</label>
                                 <select class="form-control js-example-basic-multiple" id="language" name="language[]" style="width: 100%;" multiple="multiple">
                                    <!-- <option selected disabled="">Choose Language</option> -->
                                    @foreach($languages as $language)
                                    <option value="{{ $language->id }}" >{{ $language->name }}</option>
                                    @endforeach
                                 </select>
                                 <span><p id="error_language" style="color:red;" >* Choose the Language </p></span>

                              </div>
                              
                              <div class="col-sm-6 form-group">
                                 <label class="m-0" style="display:block;">E-Paper: <small>(Upload your PDF file)</small></label>
                                 <input type="file" class="form-group" name="pdf_file" accept="application/pdf" id="" multiple>
                              </div>

                              <div class="col-sm-6 form-group">
                                 <label class="m-0" style="display:block;">Reels Videos: </label>
                                 <input type="file" class="form-group" name="reels_videos[]" accept="video/mp4,video/x-m4v,video/*" id="" multiple>
                              </div>

                              <div class="col-sm-6 form-group">
                                 <label class="m-0">Reels Thumbnail: <small>(9:16 Ratio or 720X1080px)</small></label>
                                 <input type="file" class="form-group" name="reels_thumbnail"  id=""  >
                              </div>

                              <div class="col-sm-6 form-group">
                                 <label class="m-0" style="display:block;">URL Link </label>
                                 <input type="text" class="form-control" name="url_link" accept="" id="url_link" >
                              </div>

                              <div class="col-sm-6 form-group">
                                 <label class="m-0">URL Start Time <small>Format (HH:MM:SS)</small></label>
                                 <input type="text" class="form-control" name="url_linktym" accept="" id="url_linktym" >
                              </div>
                           </div>
                           <div class="row mt-5">
                              <div class="panel panel-primary" data-collapsed="0">
                                 <div class="panel-heading col-sm-12">
                                    <div class="panel-title" style="color: #000;"> <label class="m-0"><h3 class="fs-title">Subtitles (srt or txt) :</h3></label>
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
                        </div>
                        <input type="button" name="next" class="next action-button" id="next3" value="Next" /> <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                     </fieldset>
                     <fieldset>
                        <div class="form-card">
                           <div class="row">
                              <div class="col-sm-12">
                                    <h2 class="fs-title">Geo-location for Videos</h2>
                               </div>
                           </div>
                           <div class="row">
                              {{-- 
                              <div class="col-md-4">
                                 <label class="">Recommendation </label>
                                 <input type="text" class="form-control" id="Recommendation " name="Recommendation" >
                              </div>
                              --}}
                              {{-- Block country --}}
                              <div class="col-sm-6 form-group">
                                 <label class="m-0">Block Country </label>
                                 <p class="p1">( Choose the countries for block the videos )</p>
                                 <select  name="country[]" class="js-example-basic-multiple" style="width: 100%;" multiple="multiple">
                                    @foreach($countries as $country)
                                    <option value="{{ $country->country_name }}" >{{ $country->country_name }}</option>
                                    @endforeach
                                 </select>
                              </div>
                              {{-- country --}}
                              <div class="col-sm-6 form-group">
                                 <label class="m-0"> Country </label>
                                 <p class="p1">( Choose the countries videos )</p>
                                 <select  name="video_country" class="form-control" id="country">
                                    <option value="All">Select Country </option>
                                    @foreach($countries as $country)
                                    <option value="{{ $country->country_name }}" >{{ $country->country_name }}</option>
                                    @endforeach
                                 </select>
                              </div>
                           </div>
                            
                           <div class="row">
                              <div class="col-sm-6 form-group">
                                 <label class="m-0">User Access</label>
                                 <select id="access" name="access"  class="form-control" >
                                    <option value="guest" >Guest ( Everyone )</option>
                                    <option value="subscriber" >Subscriber ( Must subscribe to watch )</option>
                                    <option value="registered" >Registered Users( Must register to watch )</option>
                                    <?php if($settings->ppv_status == 1){ ?>
                                    <option value="ppv" >PPV Users (Pay per movie)</option>
                                    <?php } else{ ?>
                                    <option value="ppv" >PPV Users (Pay per movie)</option>
                                    <?php } ?>
                                 </select>
                              </div>
                              <div class="col-sm-6 form-group mt-3" id="ppv_price">
                                 <label class="">PPV Price:</label>
                                 <input type="text" class="form-control" placeholder="PPV Price" name="ppv_price" id="price" value="@if(!empty($video->ppv_price)){{ $video->ppv_price }}@endif">
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-sm-6 form-group mt-3" >
                                 <label for="">Search Tags </label>
                                    <!-- <input type="text" class="form-control" id="#inputTag" name="searchtags" value="" data-role="tagsinput"> -->
                                    <input type="text" id="exist-values" class="tagged form-control1" data-removeBtn="true" name="searchtags" value="" >
                                 </div>

                                 <div class="col-sm-6 form-group">
                                       <label class="m-0">Related Videos:</label>
                                       <select  name="related_videos[]" class="form-control js-example-basic-multiple" style="width: 100%;" multiple="multiple">
                                          <!-- <option value="">Choose Videos</option> -->
                                             @foreach($related_videos as $key => $related_video)
                                                <option value="{{ $related_video->id }}"  > {{ $related_video->title }}</option>
                                             @endforeach
                                       </select>
                                    </div>
                           </div>

                           <div class="row">
                              <div class="col-sm-6 form-group mt-3" id="ppv_price">
                                 <?php if($settings->ppv_status == 1){ ?>
                                 <label for="global_ppv">Is this video Is Global PPV:</label>
                                 <input type="checkbox" name="global_ppv" value="1" id="global_ppv" />
                                 <?php } else{ ?>
                                 <div class="global_ppv_status">
                                    <!-- <label for="global_ppv">Is this video Is PPV:</label>
                                       <input type="checkbox" name="global_ppv" value="1" id="global_ppv" /> -->
                                 </div>
                                 <?php } ?>
                              </div>
                               <div class="col-sm-6 mt-3">
                                 <div class="panel panel-primary" data-collapsed="0">
                                    <div class="panel-heading">
                                       <div class="panel-title">
                                          <label><h3 class="fs-title">Status Settings</h3>
                                          </label>
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
                                       <div>
                                          <label for="banner">Is this video Banner:</label>
                                          <input type="checkbox" @if(!empty($video->banner) && $video->banner == 1){{ 'checked="checked"' }}@elseif(!isset($video->banner)){{ 'checked="checked"' }}@endif name="banner" value="1" id="banner" />
                                       </div>
                                       <div class="clear"></div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <!-- </div> -->
                        </div>
                        <input type="button" name="next" class="next action-button" value="Next" />
                        <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                     </fieldset>

              {{-- Upload Image & Trailer --}}

                     <fieldset>
                        <div class="form-card">
                           <div class="row">
                              <div class="col-7">
                                 <h3 class="fs-title">Image Upload:</h3>
                              </div>
                              <div class="col-5">
                                 <!-- <h2 class="steps">Step 3 - 4</h2> -->
                              </div>
                           </div>

                           <div class="row">
                              <div class="col-sm-6 form-group">
                              <label class="mb-1">Video Thumbnail <span>(9:16 Ratio or 720X1080px)</span></label><br>
                                 <input type="file" name="image" id="image" >
                                 @if(!empty($video->image))
                                    <img src="{{ URL::to('/') . '/public/uploads/images/' . $video->image }}" class="video-img w-100" />
                                 @endif
                              </div>

                              <div class="col-sm-6 form-group">
                                 <label class="mb-1">Player Thumbnail <span>(16:9 Ratio or 1280X720px)</span></label><br>
                                 <input type="file" name="player_image" id="player_image" >
                                 @if(!empty($video->player_image))
                                 <img src="{{ URL::to('/') . '/public/uploads/images/' . $video->player_image }}" class="video-img w-100" />
                                 @endif
                              </div>
                           </div>

                           <div class="row">

                              <div class="col-7">
                                 <h2 class="fs-title">Trailer Upload:</h2>
                              </div>

                              <div class="col-sm-6">
                                 <label class="m-0">Video Trailer Type:</label>
                                 <select  class="trailer_type form-control"  style="width: 100%;" class="" name="trailer_type" id="trailer_type">                              
                                    <option   value="null"> Select the Video Trailer Type </option>
                                    <option value="video_mp4"> Video Upload </option>
                                    <option value="m3u8_url">  m3u8 Url </option>
                                    <option value="mp4_url">   mp4 Url</option>
                                    <option value="embed_url">  Embed Code</option>
                                 </select>
                              </div>
                           </div>

                           <div class="row trailer_m3u8_url">
                              <div class="col-sm-6 form-group" >
                                 <label class="m-0"> Trailer m3u8 Url :</label>
                                 <input type="text" class="form-control" name="m3u8_trailer" id="" value="">
                              </div>
                           </div>

                           <div class="row trailer_mp4_url">
                              <div class="col-sm-6 form-group" >
                                 <label class="m-0"> Trailer mp4 Url :</label>
                                 <input type="text" class="form-control" name="mp4_trailer" id="" value="">
                              </div>
                           </div>

                           <div class="row trailer_embed_url">
                              <div class="col-sm-6 form-group" >
                                 <label class="m-0">Trailer Embed Code :</label>
                                 <input type="text" class="form-control" name="embed_trailer" id="" value="">
                              </div>
                           </div>


                           <div class="row trailer_video_upload">
                              <div class="col-sm-8 form-group">
                                 <label class="m-0">Upload Trailer :</label><br>
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

                        <div class="row">
                           <div class="col-sm-8  form-group">
                              <label class="m-0">Trailer Description:</label>
                              <textarea  rows="5" class="form-control mt-2" name="trailer_description" id="trailer-ckeditor"
                                 placeholder="Trailer Description">
                              </textarea>
                           </div>
                        </div>

               </div>
               <input type="button" name="next" class="next action-button" value="Next" />
               <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
               </fieldset>
               <fieldset>
               <div class="form-card">
               <div class="row">

                  <div class="col-7">
                     <h2 class="fs-title">ADS Management:</h2>
                  </div>

                  <div class="col-5">
                     <!-- <h2 class="steps">Step 3 - 4</h2> -->
                  </div>


               {{-- Ads Category--}}
                     <div class="col-sm-6 form-group mt-3">
                        <label class="">Choose Ad Category</label>
                        <select class="form-control" name="ads_category">
                           <option value=" ">Select Category</option>
                           @foreach($ads_category as $ad)
                              <option value="{{ $ad->id }}" > {{ ucwords($ad->name) }}</option>
                           @endforeach
                        </select>
                     </div>

                  {{-- <div class="col-sm-6 form-group mt-3">
                     <label class="">Choose Ad Name</label>
                     <select class="form-control" name="ads_id">
                        <option value="0">Select Ads</option>
                        @foreach($ads as $ad)
                           <option value="{{$ad->id}}">{{$ad->ads_name}}</option>
                        @endforeach
                     </select>
                  </div> --}}

                  {{-- <div class="col-sm-6 form-group mt-3">
                     <label class="">Default Ads</label>
                     <label class="switch">
                        <input name="default_ads" type="checkbox">
                        <span class="slider round"></span>
                     </label>
                  </div> --}}

                  {{-- <div class="col-sm-6 form-group mt-3">
                     <label class="">Choose Ad Roll</label>
                     <select class="form-control" name="ad_roll">
                        <option value="0">Select Ad Roll</option>
                        <option value="1">Pre</option>
                        <option value="2">Mid</option>
                        <option value="3">Post</option>
                     </select>
                  </div> --}}
           
               </div> 
               @if(isset($video->id))
               <input type="hidden" id="id" name="id" value="{{ $video->id }}" />
               @endif
               <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
               <input type="hidden" id="video_id" name="video_id" value="">
               </div> 
               <button type="submit" style="margin-right: 10px;" class="btn btn-primary" value="{{ $button_text }}">{{ $button_text }}</button>
               <!-- <input type="button" name="next" class="next action-button" value="Submit" />  -->
               <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
               </fieldset>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
</div>
</div>
<style>
#heading {
    text-transform: uppercase;
    color: #673AB7;
    font-weight: normal
}

#msform {
    text-align: center;
    position: relative;
    margin-top: 20px
}
#progressbar #useraccess_ppvprice:before {
    font-family: FontAwesome;
    content: "\f030"
}
#msform fieldset {
    background: white;
    border: 0 none;
    border-radius: 0.5rem;
    box-sizing: border-box;
    width: 100%;
    margin: 0;
    padding-bottom: 20px;
    position: relative;
}

.form-card {
    text-align: left;
}

#msform fieldset:not(:first-of-type) {
    display: none;
}

#msform input,
#msform textarea {
    padding: 8px 15px 8px 15px;
    /*border: 1px solid #e6e8eb;*/
    border-radius: 0px;
    margin-bottom: 10px;
    margin-top: 2px;
    box-sizing: border-box;
    color: #000;
   
    font-size: 14px;
}

#msform input:focus,
#msform textarea:focus {
    -moz-box-shadow: none !important;
    -webkit-box-shadow: none !important;
    box-shadow: none !important;
    border: 1px solid #e5e5e5;
    outline-width: 0
}

#msform .action-button {
    width: 100px;
    background: #0993D2;
    font-weight: 500;
    color: white;
    border: 0 none;
    border-radius: 4px;
    cursor: pointer;
    padding: 7px 5px;
    margin: 10px 0px 10px 5px;
    float: right;
}

#msform .action-button:hover,
#msform .action-button:focus {
    background-color: #56c3e8
}

#msform .action-button-previous {
    width: 100px;
    background: #616161;
    font-weight: 500;
    color: white;
    border: 0 none;
    border-radius: 4px;
    cursor: pointer;
    padding: 7px 5px;
    margin: 10px 5px 10px 0px;
    float: right
}

#msform .action-button-previous:hover,
#msform .action-button-previous:focus {
    background-color: #000000
}

.card {
    z-index: 0;
    border: none;
    position: relative
}

.fs-title {
    font-size: 20px;
    color: #000;
    margin-bottom: 15px;
    text-align: left;
    font-weight: 500;
}

.purple-text {
    color: #673AB7;
    font-weight: normal
}

.steps {
    font-size: 25px;
    color: gray;
    margin-bottom: 10px;
    font-weight: normal;
    text-align: right
}

.fieldlabels {
    color: gray;
    text-align: left
}
.progress {height:0.25rem !important;}
#progressbar {
    margin-bottom: 10px;
    overflow: hidden;
    color: black;
    /* border: 1px solid #f5f5f5; /
    border-radius: 5px;
    box-shadow: 0px 0px 15px #e1e1e1; */
}

#progressbar li.active {
    color: #000000!important; font-weight:500;
}

#progressbar li {
    list-style-type: none;
    font-size: 15px;
    width: 16%;
    float: left;
    position: relative;
    font-weight: 400;
    background-color: white;
    padding: 10px;
    line-height: 19px;
}

#progressbar #account:before {
    font-family: FontAwesome;
    content: "\f13e"
}

#progressbar #personal:before {
    font-family: FontAwesome;
    content: "\f007"
}

#progressbar #payment:before {
    font-family: FontAwesome;
    content: "\f030"
}

#progressbar #confirm:before {
    font-family: FontAwesome;
    content: "\f00c"
}

#progressbar li:before {
    width: 50px;
    height: 50px;
    line-height: 45px;
    display: block;
    font-size: 20px;
    color: #ffffff;
    background: lightgray;
    border-radius: 50%;
    margin: 0 auto 10px auto;
    padding: 2px;
        display:none;
}

#progressbar li:after {
    content: '';
    width: 100%;
    height: 2px;
    background: lightgray;
    position: absolute;
    left: 0;
    top: 25px;
    z-index: -1
}

#progressbar li.active:before, #progressbar li.active:after {
    background: #4ca3d9;
}
.progress-bar {
    background-color: #673AB7
}

.fit-image {
    width: 100%;
    object-fit: cover
}
#msform input[type="file"]{border: 0; width: 100%;}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
   $(document).ready(function(){
   
   var current_fs, next_fs, previous_fs; //fieldsets
   var opacity;
   var current = 1;
   var steps = $("fieldset").length;
   
   setProgressBar(current);
   
   $(".next").click(function(){
   
   current_fs = $(this).parent();
   next_fs = $(this).parent().next();
   
   //Add Class Active
   $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
   
   //show the next fieldset
   next_fs.show();
   //hide the current fieldset with style
   current_fs.animate({opacity: 0}, {
   step: function(now) {
   // for making fielset appear animation
   opacity = 1 - now;
   
   current_fs.css({
   'display': 'none',
   'position': 'relative'
   });
   next_fs.css({'opacity': opacity});
   },
   duration: 500
   });
   setProgressBar(++current);
   });
   
   $(".previous").click(function(){
   
   current_fs = $(this).parent();
   previous_fs = $(this).parent().prev();
   
   //Remove class active
   $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
   
   //show the previous fieldset
   previous_fs.show();
   
   //hide the current fieldset with style
   current_fs.animate({opacity: 0}, {
   step: function(now) {
   // for making fielset appear animation
   opacity = 1 - now;
   
   current_fs.css({
   'display': 'none',
   'position': 'relative'
   });
   previous_fs.css({'opacity': opacity});
   },
   duration: 500
   });
   setProgressBar(--current);
   });
   
   function setProgressBar(curStep){
   var percent = parseFloat(100 / steps) * curStep;
   percent = percent.toFixed();
   $(".progress-bar")
   .css("width",percent+"%")
   }
   
   $(".submit").click(function(){
   return false;
   })
   
   });
</script>
<input type="hidden" id="base_url" value="<?php echo URL::to('/');?>">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>                       
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
<script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />
<script>


         // validation for slug

$(document).ready(function(){

      $('#slug_error').hide();
      $('#slug_validate').on('keyup blur keypress mouseover', function(e) {

         var title = $('#title').val();
         var slug_name=title.replace(/ /g,"_");

         if($('#slug').val().length == 0 ){
            var slug = $('#slug').val(slug_name);
         }else{
            var slug = $('#slug').val();
         }
      
         $.ajax({
         type: "POST", 
         dataType: "json", 
         url: "{{ url('admin/video_slug_validate') }}",
               data: {
                  _token  : "{{csrf_token()}}" ,
                  slug : slug,
                  type : "create",
                  video_id: null,
         },
         success: function(data) {
               console.log(data.message);
               if(data.message == "true"){
                  
                  $('#next2').attr('disabled','disabled');
                  $('#slug_error').show();
               }
               else if(data.message = "false"){
                  $('#next2').removeAttr('disabled');
                  $('#slug_error').hide();

               }
            },
         });
      })
});

  
$(document).ready(function($){
   // validation Skip 
      $('#error_intro_start_time').hide();
      $('#error_intro_end_time').hide();
      $('#error_skip_intro_time').hide();
      

   $('#intro_start_time').on('keyup keypress change', function(event) {
          $('#error_intro_start_time').hide();

      if($('#skip_intro').val() == ""){
         $('#error_skip_intro_time').show();
         $('#error_intro_end_time').show();
         $('#next2').attr('disabled','disabled');
      }
      else if($('#skip_intro').val() != "" && $('#skip_intro').val() <= $('#intro_start_time').val() ){

            $("#error_skip_intro_time").empty();
            $("#error_skip_intro_time").append("Skip intro time always greater than intro Start time");
            $('#error_skip_intro_time').show();
            $('#error_intro_end_time').show();
            $('#error_intro_start_time').hide();

            $('#next2').attr('disabled','disabled');
      }
      else{
         $('#error_skip_intro_time').hide();
            $('#next2').removeAttr('disabled');
      }
   });


   $('#skip_intro').on('keyup keypress change', function(event) {
      if($('#intro_start_time').val() == ""){
         $('#error_intro_start_time').show();
         $('#error_intro_end_time').show();
         $('#next2').attr('disabled','disabled');
      }
      else if($('#intro_start_time').val() != "" && $('#skip_intro').val() <= $('#intro_start_time').val() ){
            $("#error_skip_intro_time").empty();
            $("#error_skip_intro_time").append("Skip intro time always lesser than intro Start time ");
            $('#error_skip_intro_time').show();
            $('#next2').attr('disabled','disabled');
      }
      else{
         $('#error_skip_intro_time').hide();
            $('#next2').removeAttr('disabled');
      }
   });

   $('#intro_end_time').on('keyup keypress change', function(event) {

      if($('#intro_start_time').val() == ""){
         $('#error_intro_start_time').show();
         $('#next2').attr('disabled','disabled');
      }
      else if($('#intro_start_time').val() != "" && $('#intro_start_time').val() >= $('#intro_end_time').val() ){
            $("#error_intro_end_time").empty();
            $("#error_intro_end_time").append("End recap time always greater than recap start time ");
            $('#error_intro_end_time').show();
            $('#next2').attr('disabled','disabled');
      }
      else if($('#intro_start_time').val() != "" && $('#skip_intro').val() <= $('#intro_end_time').val() ){
            $("#error_intro_end_time").empty();
            $("#error_intro_end_time").append("End intro time always lesser than Skip intro time ");
            $('#error_intro_end_time').show();
            $('#next2').attr('disabled','disabled');
      }
      else{
         $('#error_intro_end_time').hide();
            $('#next2').removeAttr('disabled');
      }
   });


   // validation Recap 

      $('#error_recap_start_time').hide();
      $('#error_recap_end_time').hide();
      $('#error_skip_recap_time').hide();

   $('#recap_start_time').on('keyup keypress change', function(event) {
          $('#error_recap_start_time').hide();

      if($('#skip_recap').val() == ""){
         $('#error_skip_recap_time').show();
         $('#error_recap_end_time').show();
         $('#next2').attr('disabled','disabled');
      }
      else if($('#skip_recap').val() != "" && $('#skip_recap').val() <= $('#recap_start_time').val() ){

            $("#error_recap_start_time").empty();
            $("#error_recap_start_time").append("Skip intro time always greater than intro Start time");
            $('#error_recap_start_time').show();
            $('#error_recap_end_time').show();
            $('#error_recap_start_time').hide();

            $('#next2').attr('disabled','disabled');
      }
      else{
         $('#error_skip_recap_time').hide();
            $('#next2').removeAttr('disabled');
      }
   });

   $('#skip_recap').on('keyup keypress change', function(event) {
      if($('#recap_start_time').val() == ""){
         $('#error_recap_start_time').show();
         $('#error_recap_end_time').show();
         $('#next2').attr('disabled','disabled');
      }
      else if($('#recap_start_time').val() != "" && $('#skip_recap').val() <= $('#recap_start_time').val() ){
            $("#error_skip_recap_time").empty();
            $("#error_skip_recap_time").append("Skip Recap time always lesser than recap Start time ");
            $('#error_skip_recap_time').show();
            $('#next2').attr('disabled','disabled');
      }
      else{
         $('#error_skip_recap_time').hide();
            $('#next2').removeAttr('disabled');
      }
   });

   $('#recap_end_time').on('keyup keypress change', function(event) {

      if($('#skip_recap').val() == ""){
         $('#error_recap_start_time').show();
         $('#next2').attr('disabled','disabled');
      }
      else if($('#recap_start_time').val() != "" && $('#recap_start_time').val() >= $('#recap_end_time').val() ){
            $("#error_recap_end_time").empty();
            $("#error_recap_end_time").append("End intro time always greater than intro start time ");
            $('#error_recap_end_time').show();
            $('#next2').attr('disabled','disabled');
      }
      else if($('#recap_start_time').val() != "" && $('#skip_recap').val() <= $('#recap_end_time').val() ){
            $("#error_recap_end_time").empty();
            $("#error_recap_end_time").append("End recap time always lesser than Skip recap time ");
            $('#error_recap_end_time').show();
            $('#next2').attr('disabled','disabled');
      }
      else{
         $('#error_recap_end_time').hide();
            $('#next2').removeAttr('disabled');
      }
   });

// video category
   $('#error_video_Category').hide();
   $('#error_language').hide();

   $('.Next3').on('keyup keypress blur change click mouseover', function(event) {

   if( $('#language').val() == null || $('#video_category_id').val() == null ){

      if($('#language').val() == null){
         $('#error_language').show();
      }else{
         $('#error_language').hide();
      }

      if($('#video_category_id').val() == null){
         $('#error_video_Category').show();
      }else{
         $('#error_video_Category').hide();
      }
      
      $('#next3').attr('disabled','disabled');
   }  
   else{
      $('#error_language').hide();
      $('#error_video_Category').hide();

      $('#next3').removeAttr('disabled');
   }

});

  

});


   // $('#intro_start_time').datetimepicker(
   // {
   //     format: 'hh:mm '
   // });
   // $('#intro_end_time').datetimepicker(
   // {
   //     format: 'hh:mm '
   // });
   // $('#recap_start_time').datetimepicker(
   // {
   //     format: 'hh:mm '
   // });
   // $('#recap_end_time').datetimepicker(
   // {
   //     format: 'hh:mm '
   // });
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.js"></script>
<script src="<?= URL::to('/assets/js/jquery.mask.min.js');?>"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
<script type="text/javascript">
   $ = jQuery;
   
   $(document).ready(function($){
      $('#duration').mask("00:00:00");
      $('#intro_start_time').mask("00:00:00");
      $('#intro_end_time').mask("00:00:00");
      $('#recap_start_time').mask("00:00:00");
      $('#recap_end_time').mask("00:00:00");
      $('#skip_intro').mask("00:00:00");
      $('#skip_recap').mask("00:00:00");
      $('#url_linktym').mask("00:00:00");

      
   });
   
   
    $(document).ready(function(){
   $('#publishlater').hide();
   
       // $('#duration').mask('00:00:00');
   
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
   });
   
   // $(document).ready(function(){
   //     $('#global_ppv_status').hide();
   // 		$("#access").change(function(){
   // 			if($(this).val() == 'ppv'){
   // 				$('#global_ppv_status').show();
   
   // 			}else{
   // 				$('#global_ppv_status').hide();				
   // 			}
   // 		});
   // });
   
   
   
   
   
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

   CKEDITOR.replace( 'links-ckeditor', {
       filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
       filebrowserUploadMethod: 'form'
   });

   CKEDITOR.replace( 'trailer-ckeditor', {
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
   //   $('#video_upload').hide();
   //   $('#video_mp4').hide();
   //   $('#embedvideo').hide();
   //   $('#optionradio').hide();
   //   $('.content_videopage').hide();
   //   $('#content_videopage').hide();
   
   
   
     Dropzone.autoDiscover = false;
     var myDropzone = new Dropzone(".dropzone",{ 
       //   maxFilesize: 900,  // 3 mb
         maxFilesize: 150000000,
         acceptedFiles: "video/mp4,video/x-m4v,video/*",
     });
     myDropzone.on("sending", function(file, xhr, formData) {
        formData.append("_token", CSRF_TOKEN);
        checkUploadSpeed( 10, function ( speed, average ) {
        document.getElementById( 'speed' ).textContent = 'speed: ' + speed + 'kbs';
        document.getElementById( 'average' ).textContent = 'average: ' + average + 'kbs';
    } );
       // console.log(value)
       this.on("success", function(file, value) {
             console.log(value.video_title);
             $('#Next').show();
            $('#video_id').val(value.video_id);
            $('#title').val(value.video_title);
   
            
         });
   
     }); 
     function checkUploadSpeed( iterations, update ) {
        var average = 0,
            index = 0,
            timer = window.setInterval( check, 5000 ); //check every 5 seconds
        check();

        function check() {
            var xhr = new XMLHttpRequest(),
                url = '?cache=' + Math.floor( Math.random() * 10000 ), //random number prevents url caching
                data = getRandomString( 1 ), //1 meg POST size handled by all servers
                startTime,
                speed = 0;
            xhr.onreadystatechange = function ( event ) {
                if( xhr.readyState == 4 ) {
                    speed = Math.round( 1024 / ( ( new Date() - startTime ) / 1000 ) );
                    average == 0 
                        ? average = speed 
                        : average = Math.round( ( average + speed ) / 2 );
                    update( speed, average );
                    index++;
                    if( index == iterations ) {
                        window.clearInterval( timer );
                    };
                };
            };
            xhr.open( 'POST', url, true );
            startTime = new Date();
            xhr.send( data );
        };

        function getRandomString( sizeInMb ) {
            var chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789~!@#$%^&*()_+`-=[]\{}|;':,./<>?", //random data prevents gzip effect
                iterations = sizeInMb * 1024 * 1024, //get byte count
                result = '';
            for( var index = 0; index < iterations; index++ ) {
                result += chars.charAt( Math.floor( Math.random() * chars.length ) );
            };     
            return result;
        };
    };
    

   
   
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
<script>
   $(document).ready(function(){
       // $('#message').fadeOut(120);
       setTimeout(function() {
           $('#successMessage').fadeOut('fast');
       }, 3000);
   })
</script>
@section('javascript')
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script>
   $('form[id="video_form"]').validate({
       ignore: [],
   	rules: {
   	  title : 'required',
   	  image : 'required',
         trailer : 'required',
       //   video_country : 'required',
         'video_category_id[]': {
                   required: true
               }
   	},
   	messages: {
   	  title: 'This field is required',
   	  image: 'This field is required',
         trailer : 'This field is required',
       //   video_country : 'This field is required',
         video_category_id: {
                   required: 'This field is required',
               }
   	},
   	submitHandler: function(form) {
   	  form.submit();
   	}
     });

     $(document).ready(function(){

         $('.trailer_video_upload').hide();
         $('.trailer_m3u8_url').hide();
         $('.trailer_mp4_url').hide();
         $('.trailer_embed_url').hide();


      $(".trailer_type").change(function(){
         var trailer_type = $('.trailer_type').val();

        
         if(trailer_type == 'video_mp4' ){
            $('.trailer_video_upload').show();
            $('.trailer_m3u8_url').hide();
            $('.trailer_mp4_url').hide();
            $('.trailer_embed_url').hide();
         }
         else if(trailer_type == 'm3u8_url'){
            $('.trailer_video_upload').hide();
            $('.trailer_m3u8_url').show();
            $('.trailer_mp4_url').hide();
            $('.trailer_embed_url').hide();
         }
         else if(trailer_type == 'mp4_url'){
            $('.trailer_video_upload').hide();
            $('.trailer_m3u8_url').hide();
            $('.trailer_mp4_url').show();
            $('.trailer_embed_url').hide();
         }
         else if(trailer_type == 'embed_url'){
            $('.trailer_video_upload').hide();
            $('.trailer_m3u8_url').hide();
            $('.trailer_mp4_url').hide();
            $('.trailer_embed_url').show();
         }
         else if(trailer_type == 'null' ){
            $('.trailer_video_upload').hide();
            $('.trailer_m3u8_url').hide();
            $('.trailer_mp4_url').hide();
            $('.trailer_embed_url').hide();
         }
      });
      });
   



   // https://github.com/k-ivan/Tags
(function() {

'use strict';

// Helpers
function $$(selectors, context) {
  return (typeof selectors === 'string') ? (context || document).querySelectorAll(selectors) : [selectors];
}
function $(selector, context) {
  return (typeof selector === 'string') ? (context || document).querySelector(selector) : selector;
}
function create(tag, attr) {
  var element = document.createElement(tag);
  if(attr) {
    for(var name in attr) {
      if(element[name] !== undefined) {
        element[name] = attr[name];
      }
    }
  }
  return element;
}
function whichTransitionEnd() {
  var root = document.documentElement;
  var transitions = {
    'transition'       : 'transitionend',
    'WebkitTransition' : 'webkitTransitionEnd',
    'MozTransition'    : 'mozTransitionEnd',
    'OTransition'      : 'oTransitionEnd otransitionend'
  };

  for(var t in transitions){
    if(root.style[t] !== undefined){
      return transitions[t];
    }
  }
  return false;
}
function oneListener(el, type, fn, capture) {
  capture = capture || false;
  el.addEventListener(type, function handler(e) {
    fn.call(this, e);
    el.removeEventListener(e.type, handler, capture)
  }, capture);
}
function hasClass(cls, el) {
  return new RegExp('(^|\\s+)' + cls + '(\\s+|$)').test(el.className);
}
function addClass(cls, el) {
  if( ! hasClass(cls, el) )
    return el.className += (el.className === '') ? cls : ' ' + cls;
}
function removeClass(cls, el) {
  el.className = el.className.replace(new RegExp('(^|\\s+)' + cls + '(\\s+|$)'), '');
}
function toggleClass(cls, el) {
  ( ! hasClass(cls, el)) ? addClass(cls, el) : removeClass(cls, el);
}

function Tags(tag) {

  var el = $(tag);

  if(el.instance) return;
  el.instance = this;

  var type = el.type;
  var transitionEnd = whichTransitionEnd();

  var tagsArray = [];
  var KEYS = {
    ENTER: 13,
    COMMA: 188,
    BACK: 8
  };
  var isPressed = false;

  var timer;
  var wrap;
  var field;

  function init() {

    // create and add wrapper
    wrap = create('div', {
      'className': 'tags-container',
    });
    field = create('input', {
      'type': 'text',
      'className': 'tag-input',
      'placeholder': el.placeholder || ''
    });

    wrap.appendChild(field);

    if(el.value.trim() !== '') {
      hasTags();
    }

    el.type = 'hidden';
    el.parentNode.insertBefore(wrap, el.nextSibling);

    wrap.addEventListener('click', btnRemove, false);
    wrap.addEventListener('keydown', keyHandler, false);
    wrap.addEventListener('keyup', backHandler, false);
  }

  function hasTags() {
    var arr = el.value.trim().split(',');
    arr.forEach(function(item) {
      item = item.trim();
      if(~tagsArray.indexOf(item)) {
        return;
      }
      var tag = createTag(item);
      tagsArray.push(item);
      wrap.insertBefore(tag, field);
    });
  }

  function createTag(name) {
    var tag = create('div', {
      'className': 'tag',
      'innerHTML': '<span class="tag__name">' + name + '</span>'+
                   '<button class="tag__remove">&times;</button>'
    });
//       var tagName = create('span', {
//         'className': 'tag__name',
//         'textContent': name
//       });
//       var delBtn = create('button', {
//         'className': 'tag__remove',
//         'innerHTML': '&times;'
//       });
    
//       tag.appendChild(tagName);
//       tag.appendChild(delBtn);
    return tag;
  }

  function btnRemove(e) {
    e.preventDefault();
    if(e.target.className === 'tag__remove') {
      var tag  = e.target.parentNode;
      var name = $('.tag__name', tag);
      wrap.removeChild(tag);
      tagsArray.splice(tagsArray.indexOf(name.textContent), 1);
      el.value = tagsArray.join(',')
    }
    field.focus();
  }

  function keyHandler(e) {

    if(e.target.tagName === 'INPUT' && e.target.className === 'tag-input') {

      var target = e.target;
      var code = e.which || e.keyCode;

      if(field.previousSibling && code !== KEYS.BACK) {
        removeClass('tag--marked', field.previousSibling);
      }

      var name = target.value.trim();

      // if(code === KEYS.ENTER || code === KEYS.COMMA) {
      if(code === KEYS.ENTER) {

        target.blur();

        addTag(name);

        if(timer) clearTimeout(timer);
        timer = setTimeout(function() { target.focus(); }, 10 );
      }
      else if(code === KEYS.BACK) {
        if(e.target.value === '' && !isPressed) {
          isPressed = true;
          removeTag();
        }
      }
    }
  }
  function backHandler(e) {
    isPressed = false;
  }

  function addTag(name) {

    // delete comma if comma exists
    name = name.toString().replace(/,/g, '').trim();

    if(name === '') return field.value = '';

    if(~tagsArray.indexOf(name)) {

      var exist = $$('.tag', wrap);

      Array.prototype.forEach.call(exist, function(tag) {
        if(tag.firstChild.textContent === name) {

          addClass('tag--exists', tag);

          if(transitionEnd) {
            oneListener(tag, transitionEnd, function() {
              removeClass('tag--exists', tag);
            });
          } else {
            removeClass('tag--exists', tag);
          }


        }

      });

      return field.value = '';
    }

    var tag = createTag(name);
    wrap.insertBefore(tag, field);
    tagsArray.push(name);
    field.value = '';
    el.value += (el.value === '') ? name : ',' + name;
  }

  function removeTag() {
    if(tagsArray.length === 0) return;

    var tags = $$('.tag', wrap);
    var tag = tags[tags.length - 1];

    if( ! hasClass('tag--marked', tag) ) {
      addClass('tag--marked', tag);
      return;
    }

    tagsArray.pop();

    wrap.removeChild(tag);

    el.value = tagsArray.join(',');
  }

  init();

  /* Public API */

  this.getTags = function() {
    return tagsArray;
  }

  this.clearTags = function() {
    if(!el.instance) return;
    tagsArray.length = 0;
    el.value = '';
    wrap.innerHTML = '';
    wrap.appendChild(field);
  }

  this.addTags = function(name) {
    if(!el.instance) return;
    if(Array.isArray(name)) {
      for(var i = 0, len = name.length; i < len; i++) {
        addTag(name[i])
      }
    } else {
      addTag(name);
    }
    return tagsArray;
  }

  this.destroy = function() {
    if(!el.instance) return;

    wrap.removeEventListener('click', btnRemove, false);
    wrap.removeEventListener('keydown', keyHandler, false);
    wrap.removeEventListener('keyup', keyHandler, false);

    wrap.parentNode.removeChild(wrap);

    tagsArray = null;
    timer = null;
    wrap = null;
    field = null;
    transitionEnd = null;

    delete el.instance;
    el.type = type;
  }
}

window.Tags = Tags;

})();

// Use
var tags = new Tags('.tagged');

document.getElementById('get').addEventListener('click', function(e) {
e.preventDefault();
alert(tags.getTags());
});
document.getElementById('clear').addEventListener('click', function(e) {
e.preventDefault();
tags.clearTags();
});
document.getElementById('add').addEventListener('click', function(e) {
e.preventDefault();
tags.addTags('New');
});
document.getElementById('addArr').addEventListener('click', function(e) {
e.preventDefault();
tags.addTags(['Steam Machines', 'Nintendo Wii U', 'Shield Portable']);
});
document.getElementById('destroy').addEventListener('click', function(e) {
e.preventDefault();
if(this.textContent === 'destroy') {
  tags.destroy();
  this.textContent = 'reinit';
} else {
  this.textContent = 'destroy';
  tags = new Tags('.tagged');
}

});

</script>
@stop




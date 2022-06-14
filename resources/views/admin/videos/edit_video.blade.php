@extends('admin.master')
@include('admin.favicon')
<!DOCTYPE html>
<html>
  <head>
    <!-- <title>Drag and Drop file upload with Dropzone in Laravel 7</title> -->

    <!-- Meta -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- CSS -->
	<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">

    <link rel="stylesheet" type="text/css" href="{{asset('dropzone/dist/min/dropzone.min.css')}}">

    <!-- JS -->
    
    <script src="{{asset('dropzone/dist/min/dropzone.min.js')}}" type="text/javascript"></script>
<style>
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
  </head>
  <body>
  @section('content')
  
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
                  <input type="hidden" id="embed_url" value="<?php echo URL::to('/admin/UpdateEmbededcode');?>">
                  <input type="hidden" id="mp4url" value="<?php echo URL::to('/admin/Updatemp4url');?>">
                  <input type="hidden" id="m3u8url" value="<?php echo URL::to('/admin/Updatem3u8url');?>">

                  <div class='content' id="video_upload">
                <!-- Dropzone -->
                <form action="{{ URL::to('admin/uploadEditVideo') }}" method= "post"  class='dropzone' >
                </form> 
                </div> 
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
      </div>
   </div>
   </div>
 
    <!-- Script -->
    <script>
    var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
    var videoid = '<?= $video->id ?>' ;

    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone(".dropzone",{ 
        maxFilesize: 150000000,
        acceptedFiles: "video/mp4,video/x-m4v,video/*",
    });
    myDropzone.on("sending", function(file, xhr, formData) {
        formData.append('videoid',videoid);
       formData.append("_token", CSRF_TOKEN);
       this.on("success", function(file, value) {
          
         if(value.video_id == videoid){
                     swal("Video Update Successfull !");
                  }
         
        });
    }); 
    </script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{ URL::to('/assets/admin/js/sweetalert.min.js') }}"></script>

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


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $.ajaxSetup({
              headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
       });
   
    $(document).ready(function(){

       var url =$('#m3u8url').val();
      var videoid = '<?= $video->id ?>' ;

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
                                     if(value.video_id == videoid){
                     swal("URL Update Successfull !");
                  }
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
      var videoid = '<?= $video->id ?>' ;

       var url =$('#mp4url').val();
       $('#mp4_url').change(function(){
       // alert($('#mp4_url').val());
       $.ajax({
           url: url,
           type: "post",
       data: {
                  _token: '{{ csrf_token() }}',
                  mp4_url: $('#mp4_url').val(),
                  videoid: videoid,
   
            },        success: function(value){
               console.log(value);
               if(value.video_id == videoid){
                     swal("URL Update Successfull !");
                  }
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
         var videoid = '<?= $video->id ?>' ;
   
   var url =$('#embed_url').val();
   $('#embed_code').change(function(){
   	// alert($('#embed_code').val());
   	$.ajax({
           url: url,
           type: "post",
   data: {
                  _token: '{{ csrf_token() }}',
                  embed: $('#embed_code').val(),
                  videoid: videoid,

   
            },        success: function(value){
   			console.log(value);
            if(value.video_id == videoid){
                     swal("URL Update Successfull !");
                  }
           }
       });
   })
   
   });
   	// http://localhost/flicknexs/public/uploads/audios/23.mp3
</script>

  </body>
</html>

@stop
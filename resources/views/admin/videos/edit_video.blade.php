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
    <link rel="stylesheet" type="text/css" href="{{asset('dropzone/dist/min/dropzone.min.css')}}">

    <!-- JS -->
    
    <script src="{{asset('dropzone/dist/min/dropzone.min.js')}}" type="text/javascript"></script>

  </head>
  <body>
  @section('content')
  
    <div id=" content_videopage" class="content-page">
        <div class="mt-5 d-flex">
            <a class="black1" href="{{ URL::to('admin/videos') }}">All Videos</a>
            <a class="black1" style="background:#fafafa!important;color: #006AFF!important;" href="{{ URL::to('admin/videos/create') }}">Add New Video</a>
            <a class="black1" href="{{ URL::to('admin/CPPVideosIndex') }}">Videos For Approval</a>
            <a class="black1" href="{{ URL::to('admin/Masterlist') }}" class="iq-waves-effect"> Master Video List</a>
            <a class="black1" href="{{ URL::to('admin/videos/categories') }}">Manage Video Categories</a>
            <a class="black1"  href="{{ URL::to('admin/ActiveSlider') }}">Active Slider List</a>
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
                        <!-- <label for="embed_code"><label>m3u8 URL:</label></label>
                        <input type="text" class="form-control" name="m3u8_video_url" id="m3u8_video_url" value="" /> -->
                     </div>
                  </div>
                  <!-- Embedded Video -->        
                  <div id="embedvideo" style="">
                     <div class="new-audio-file mt-3">
                        <!-- <label for="embed_code"><label>Embed URL:</label></label>
                        <input type="text" class="form-control" name="embed_code" id="embed_code" value="" /> -->
                     </div>
                  </div>
                  <!-- MP4 Video -->        
                  <div id="video_mp4" style="">
                     <div class="new-audio-file mt-3" >
                        <!-- <label for="mp4_url"><label>Mp4 File URL:</label></label>
                        <input type="text" class="form-control" name="mp4_url" id="mp4_url" value="" /> -->
                     </div>
                  </div>

                  <div class='content'>
                <!-- Dropzone -->
                <form action="{{ URL::to('admin/uploadEditVideo') }}" method= "post"  class='dropzone' >
                </form> 
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
          
        });
    }); 
    </script>

  </body>
</html>

@stop
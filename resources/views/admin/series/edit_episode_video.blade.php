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

    <!-- CSS -->
  <link rel="stylesheet" type="text/css" href="{{asset('dropzone/dist/min/dropzone.min.css')}}" />

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

    .dz-progress{  
      opacity: 1 !important;
      background: #0993d2 !important;
      top: 82% !important;
      font-weight: 800 !important;
      font-size: 10px;
      height: 14px !important;
      text-align: center;
    }

      </style>
  </head>
  <body>
  @section('content')
  
    <div id=" content_videopage" class="content-page">
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
                  <div class='content' id="video_upload" style="margin-left: 36%;">
                    <form action="{{ $dropzone_url }}" method= "post"  class='dropzone' >
                    </form> 
                </div> 
             </div>
        </div>

        </div>
      </div>
   </div>
   </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 
    <!-- Script -->
    <script>
      var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
      var Episodeid = '<?= $videos->id ?>';
      var series_id = '<?= $videos->series_id ?>';
      var season_id = '<?= $videos->season_id ?>';
  
      Dropzone.autoDiscover = false;
      var myDropzone = new Dropzone(".dropzone", {
          maxFilesize: 150000000,
          acceptedFiles: "video/mp4,video/x-m4v,video/*"
      });
  
      // Add progress event listener
      myDropzone.on("uploadprogress", function(file, progress) {
          // Target the automatically created dz-progress div and update its content
          var progressDiv = file.previewElement.querySelector(".dz-progress");
          if (progressDiv) {
              progressDiv.innerHTML = Math.round(progress) + "%";
          }
      });
  
      myDropzone.on("sending", function(file, xhr, formData) {
          formData.append('Episodeid', Episodeid);
          formData.append("_token", CSRF_TOKEN);
      });
  
      myDropzone.on("success", function(file, response) {
          if (response.episode_id == Episodeid) {
              swal("Episode Update Successful!");
              window.location.href = "/season/edit/" + series_id + "/" + season_id;
          }
      });
  </script>

  </body>
</html>

@stop
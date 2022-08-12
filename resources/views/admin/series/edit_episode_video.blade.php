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
                <form action="{{ URL::to('admin/EpisodeVideoUpload') }}" method= "post"  class='dropzone' >
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
    var Episodeid = '<?= $videos->id ?>' ;

    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone(".dropzone",{ 
        maxFilesize: 150000000,
        acceptedFiles: "video/mp4,video/x-m4v,video/*",
    });
    myDropzone.on("sending", function(file, xhr, formData) {
        formData.append('Episodeid',Episodeid);
       formData.append("_token", CSRF_TOKEN);
       this.on("success", function(file, value) {
          
         if(value.video_id == videoid){
                     swal("Episode Update Successfull !");
                  }
         
        });
    }); 
    </script>

  </body>
</html>

@stop
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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    .dropzone .dz-preview .dz-progress{height:14px !important;}
    span#upload-percentage{position: absolute;right: 30%;bottom: -3px;font-weight:800 !important;font-size:10px;color:#000;}
    .dropzone .dz-preview .dz-progress .dz-upload{border-radius:5px;}
    .dropzone .dz-preview .dz-progress {overflow: visible;top: 82%;border: none;}
    .dz-cancel {color: #FF0000;background: none;border: none;}
    .dz-cancel:hover {text-decoration: underline;}
    .dropzone .dz-preview.dz-complete .dz-progress {opacity: 1;}
    .dropzone .dz-preview .dz-success-mark svg, .dropzone .dz-preview .dz-error-mark svg {
        width: 30px;
        height: 30px;
    }
    .dropzone .dz-preview .dz-success-mark, .dropzone .dz-preview .dz-error-mark {
        top: 0;
        left: 0;
        margin-left: 0;
        margin-top: 0;
        width: 20px;
    }
    .dz-success-mark path {
        fill: #008000;
    }
    .dz-error-mark g {
        fill: #FF0000;
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
                              <h3 class="card-title upload-ui">Upload Full Episode Here</h3>
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
                        <div class="">
                              <div class='content' id="video_upload">
                                  @if(@$theme_settings->enable_bunny_cdn == 1)
      
                                      <label for="stream_bunny_cdn_episode">BunnyCDN URL:</label>
                                          <!-- videolibrary -->
                                          <select class="phselect form-control" name="UploadlibraryID" id="UploadlibraryID" >
                                                  <option value="">{{ __('Choose Stream Library from Bunny CDN') }}</option>
                                                  @foreach($videolibrary as $library)
                                                  <option value="{{  @$library['Id'] }}" data-library-ApiKey="{{ @$library['ApiKey'] }}">{{ @$library['Name'] }}</option>
                                                  @endforeach
                                          </select> 
                                          @else
                                          
                                              <input type="hidden" name="UploadlibraryID" id="UploadlibraryID" value="">
                                          @endif 
                                          <br>
                                        <div class="content file UploadEnable">
                                                
                                                <!-- Dropzone -->
                                                <form action="{{ $dropzone_url }}" method="post" class="dropzone" id="my-dropzone"></form>
                                            </div>
                            </div> 
                        </div>
                    </div>

        </div>
      </div>
   </div>
   </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>

          var enable_bunny_cdn = '<?= @$theme_settings->enable_bunny_cdn ?>';
           var enable_Flussonic_Upload = '<?= Enable_Flussonic_Upload() ?>';
  
           if(enable_bunny_cdn == 1 || enable_Flussonic_Upload == 1){
              $('.UploadEnable').hide();
           }
  
              $('#UploadlibraryID').change(function(){
                 if($('#UploadlibraryID').val() != null && $('#UploadlibraryID').val() != ''){
                    // alert($('#UploadlibraryID').val());
                    $('.UploadEnable').show();
                 }else{
                  // alert($('#UploadlibraryID').val());
                    $('.UploadEnable').hide();
                 }
              });
      </script>
 
    <!-- Script -->
    <script>
      var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
      var Episodeid = '<?= $videos->id ?>';
      var series_id = '<?= $videos->series_id ?>';
      var season_id = '<?= $videos->season_id ?>';
  
      Dropzone.autoDiscover = false;
      var myDropzone = new Dropzone(".dropzone", {
          maxFilesize: 150000000,
          acceptedFiles: "video/mp4,video/x-m4v,video/x-matroska,video/mkv",
        });
  
      myDropzone.on("uploadprogress", function(file, progress) {
          var progressElement = file.previewElement.querySelector('.dz-upload-percentage');
          
          if (progressElement) {
            progressElement.textContent = Math.round(progress) + '%';
          }

          if (Math.round(progress) === 100) {
            var cancelButton = file.previewElement.querySelector('.dz-cancel');
            if (cancelButton) {
                  cancelButton.style.opacity = '0';
            }
          }
      });

          myDropzone.on("addedfile", function(file) {
            var cancelButton = file.previewElement.querySelector('.dz-cancel');
            cancelButton.addEventListener('click', function() {
                var confirmCancel = confirm("Are you sure you want to cancel the upload?");
                if (confirmCancel) {
                      myDropzone.removeFile(file);
                }
            });
          });
  
      myDropzone.on("sending", function(file, xhr, formData) {
          formData.append('Episodeid', Episodeid);
          formData.append("_token", CSRF_TOKEN);
          formData.append("UploadlibraryID", $('#UploadlibraryID').val());
      });
  
      myDropzone.on("success", function(file, response) {
        if (response.Episode_id == Episodeid) {
            Swal.fire({
                title: "Episode Update Successful!",
                icon: "success"
            }).then(() => {
              window.history.back();
            });
        }
    });
  </script>
  
  </body>
</html>

@stop
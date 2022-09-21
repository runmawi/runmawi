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
<div id="content-page" class="content-page">
        <div class="iq-card">
        <div class="col-md-12">
            <div class="iq-card-header  justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Test Server Video Upload :</h4>
                </div>
            </div>

            <div class="row">
                    <div class="col-md-12">
                    <!-- Video upload -->   
                        <div id="video_upload" style="">
                            <div class='content file'>
                                <h3 class="card-title upload-ui font-weight-bold">Upload Full Video Here</h4>
                                <!-- Dropzone -->
                                <form action="{{URL::to('admin/test/server/videoupload/')}}" method= "post" class='dropzone' ></form>
                                <div class="row justify-content-center">
                                    <div class="col-md-9 text-center">
                                    <p class="c1" style="margin-left: 25%;">Trailers Can Be Uploaded From Video Edit Screen</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
            
        </div>
    </div>
</div>

    @section('javascript')

        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="<?= URL::to('/assets/js/jquery.mask.min.js');?>"></script>
        
        <script type="text/javascript">

            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

            Dropzone.autoDiscover = false;
                var myDropzone = new Dropzone(".dropzone",{ 
                    maxFilesize: 150000000,
                    acceptedFiles: "video/mp4,video/x-m4v,video/*",
                });
            myDropzone.on("sending", function(file, xhr, formData) {
                formData.append("_token", CSRF_TOKEN);
                // console.log(value)
                this.on("success", function(file, value) {
                    // console.log(value.video_title);
                });
            }); 
        </script>

    @stop

@stop

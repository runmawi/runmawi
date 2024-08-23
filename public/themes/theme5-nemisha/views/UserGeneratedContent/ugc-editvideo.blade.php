@php
    include public_path('themes/theme5-nemisha/views/header.php');
@endphp

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

    .file {
        background: rgb(255 255 255 / 100%);
        border-radius: 10px;
        text-align: center;
        margin: 0 auto;
        /*width: 75%;*/
        border: 2px dashed;
    }

    .ugc_edit{
      margin: 40px 80px; 
      border-radius: 10px;
    }
    .ugc_upload{
      background-color: #fff; 
      padding:5px 10px;
      border-radius:10px; 
      margin-top: 20px;
    }

    .ugc-buttons {
      background-color: #fff;
      border-radius: 10px;
      padding: 10px;
   }

   .video-form-control{
        width:100%;
        background-color: #c9c8c888 ;
        border:none;
        padding: 5px 10px;
        border-radius: 7px;
    }


</style>
    <div id=" content_videopage" class="content-page">
       
                <div class="container-fluid p-0" id="content_videopage">
                    <div class="admin-section-title">
                        <div class="iq-card ugc_edit ">
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
                  <div id="m3u8_url" class="ugc-buttons" >
                     <div class="new-audio-file mt-3">
                        <label for="embed_code"><label>m3u8 URL:</label></label>
                        <input type="text" class="video-form-control" name="m3u8_video_url" id="m3u8_video_url" value="" />
                     </div>
                     <div class="new-audio-file mt-3">
                        <button class="btn btn-primary"  id="submit_m3u8">Submit</button>
                     </div>
                  </div>
                  <!-- Embedded Video -->        
                  <div id="embedvideo" class="ugc-buttons" >
                     <div class="new-audio-file mt-3">
                        <label for="embed_code"><label>Embed URL:</label></label>
                        <input type="text" class="video-form-control" name="embed_code" id="embed_code" value="" />
                     </div>
                     <div class="new-audio-file mt-3">
                        <button class="btn btn-primary"  id="submit_embed">Submit</button>
                     </div>
                  </div>
                  <!-- MP4 Video -->        
                  <div id="video_mp4" class="ugc-buttons" >
                     <div class="new-audio-file mt-3" >
                        <label for="mp4_url"><label>Mp4 File URL:</label></label>
                        <input type="text" class="video-form-control" name="mp4_url" id="mp4_url" value="" />
                     </div>
                     <div class="new-audio-file mt-3">
                        <button class="btn btn-primary"  id="submit_mp4">Submit</button>
                     </div>
                  </div>
                  <input type="hidden" id="embed_url" value="<?php echo URL::to('ugc/updateembededcode');?>">
                  <input type="hidden" id="mp4url" value="<?php echo URL::to('ugc/updatemp4url');?>">
                  <input type="hidden" id="m3u8url" value="<?php echo URL::to('ugc/updatem3u8url');?>">

                  <div class='content file' id="video_upload">
                        <h3 class="card-title upload-ui text-black pt-5 font-weight-bold">Upload Your Own Content</h3>
                        <form action="{{ $dropzone_url }}" method= "post"  class='dropzone' ></form> 
                  </div> 
               </div>
               <div class="col-md-12 text-right ugc_upload">
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
         })
         $('#videomp4').click(function(){
         	$('#video_upload').hide();
         	$('#video_mp4').show();
         	$('#embedvideo').hide();
         	$('#m3u8_url').hide();   
         })
         $('#embed_video').click(function(){
         	$('#video_upload').hide();
         	$('#video_mp4').hide();
         	$('#embedvideo').show();
         	$('#m3u8_url').hide();  
         })
         $('#m3u8').click(function(){
         	$('#video_upload').hide();
         	$('#video_mp4').hide();
         	$('#embedvideo').hide();
         	$('#m3u8_url').show();   
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

       var url =$('#m3u8url').val();
      var videoid = '<?= $video->id ?>' ;

       $('#submit_m3u8').click(function(){
        // alert($('#m3u8_video_url').val());
        $.ajax({
               url: url,
               type: "post",
       data: {
                      _token: '{{ csrf_token() }}',
                      m3u8_url: $('#m3u8_video_url').val(),
                      videoid:videoid
                },        success: function(value){
                console.log(value);
                   $('#Next').show();
                                     if(value.video_id == videoid){
                     swal(value.message);
                  }
               }
           });
       })

    });

    $(document).ready(function(){
      var videoid = '<?= $video->id ?>' ;

       var url =$('#mp4url').val();
       $('#submit_mp4').click(function(){
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
                  swal(value.message);
                  }
           }
           });
       })
   
   }); 
     
   $(document).ready(function(){
         var videoid = '<?= $video->id ?>' ;
   
         var url =$('#embed_url').val();
         $('#submit_embed').click(function(){
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
               swal(value.message);
                  }
           }
       });
   })
   
   });
   	
</script>

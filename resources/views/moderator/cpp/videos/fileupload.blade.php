@extends('moderator.master')
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('dropzone/dist/min/dropzone.min.css')}}">
    <!-- JS -->
    <script src="{{asset('dropzone/dist/min/dropzone.min.js')}}" type="text/javascript"></script>
@section('content')
<style>
    .iq-sidebar-menu .iq-menu li ul li a {
    padding: 20px 20px 10px 40px!important;
}
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #e4e4e4;
    border: 1px solid #aaa;
    border-radius: 4px;
    cursor: default;
    float: left;
    margin: 13px 5px;
    padding: 5px;
    font-size: 12px;
    font-weight: 500;
    color: #000;
}
    #optionradio {color: #000;text-align: end;}
    #video_upload {margin-top: 5%;}
   .file {
    background: rgb(255 255 255 / 100%);
     border-radius: 10px; 
    text-align: center;
    margin: 0 auto;
    /* width: 75%; */
    border: 2px dashed;
}
    .card-title {
    padding: 30px;
    background: #f9f9f9;
    font-size: 1.25rem;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
        margin-bottom: 0!important;
}
    #video_upload .file form{}
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
	 background-color: transparent;
	 color: #fff;
	 line-height: 1;
}
 .tag__remove:hover {
	 opacity: 1;
}
 .tag__remove:focus {
	 outline: 5px auto #fff;
}


	
.tags-input-wrapper{
    background: transparent;
    padding: 10px;
    border-radius: 4px;
    max-width: 400px;
    border: 1px solid #ccc
}
.tags-input-wrapper input{
    border: none;
    background: transparent;
    outline: none;
    width: 140px;
    margin-left: 8px;
}
.tags-input-wrapper .tag{
    display: inline-block;
    background-color: #20222c;
    color: white;
    border-radius: 40px;
    padding: 0px 3px 0px 7px;
    margin-right: 5px;
    margin-bottom:5px;
    box-shadow: 0 5px 15px -2px rgba(250 , 14 , 126 , .7)
}
.tags-input-wrapper .tag a {
    margin: 0 7px 3px;
    display: inline-block;
    cursor: pointer;
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
<div id="content-page content_videopage" class="content-page">
    <div class="container-fluid" id="content_videopage">
        <div class="admin-section-title">
            <div class="iq-card">
                <div class="row">
                    <div class="col-md-4">
                        <h4><i class="entypo-archive"></i> Add Video </h4>
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
                   
                </div><hr>
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

                            <!-- BunnyCDN Video -->        
                                <div id="bunnycdnvideo" style="">
                                    <div class="new-audio-file mt-3">
                                        <label for="bunny_cdn_linked_video">BunnyCDN URL:</label>
                                        <!-- videolibrary -->
                                        <select class="phselect form-control" name="videolibrary" id="videolibrary" >
                                                <option>{{ __('Choose Stream Library from Bunny CDN') }}</option>
                                                    @foreach($videolibrary as $library)
                                                    <option value="{{  @$library['Id'] }}" data-library-ApiKey="{{ @$library['ApiKey'] }}">{{ @$library['Name'] }}</option>
                                                    @endforeach
                                        </select>  
                                    </div>
                                        
                                    <div class="new-audio-file mt-3">
                                        <select class="form-control" id="bunny_cdn_linked_video" name="bunny_cdn_linked_video">
                                        <!-- <option selected  value="0">Choose Videos from Bunny CDN</option> -->
                                        </select>
                                    </div>
                                    <div class="new-audio-file mt-3">
                                        <button class="btn btn-primary"  id="submit_bunny_cdn">Submit</button>
                                    </div>
                                </div>


                                             <!-- Flussonic Video -->        
                            <div id="flussonicstoragevideo" style="">
                                <div class="new-audio-file mt-3">
                                    <label for="Flussonic_linked_video">Flussonic Upload Path:</label>
                                    <!-- FlussonicUploadlibrary -->
                                    <select class="phselect form-control" name="FlussonicUploadlibrary" id="FlussonicUploadlibrary" >
                                            <option>{{ __('Choose Stream Library from Flussonic Path') }}</option>
                                                @foreach($FlussonicUploadlibrary as $key => $Uploadlibrary)
                                                    <option value="{{  @$key }}" data-FlussonicUploadlibraryID-key="{{ @$Uploadlibrary['url'] }}">{{ @$Uploadlibrary['url'] }}</option>
                                                @endforeach
                                    </select>  
                                </div>
                                    
                                <div class="new-audio-file mt-3">
                                    <select class="form-control" id="Flussonic_linked_video" name="Flussonic_linked_video">
                                    </select>
                                </div>
                                <div class="new-audio-file mt-3">
                                    <button class="btn btn-primary"  id="submit_Flussonic_storage">Submit</button>
                                </div>
                            </div>

                            <!-- Video upload -->        
                            <div id="video_upload" style="">

                            @if(Enable_Flussonic_Upload() == 1)
                                
                                <label for="flussonic_upload_video">Flussonic Library:</label>
                                <!-- FlussonicUploadlibraryID -->
                                <select class="phselect form-control" name="FlussonicUploadlibraryID" id="FlussonicUploadlibraryID" >
                                        <option value="">{{ __('Choose Stream Library from Flussonic') }}</option>
                                            @foreach($FlussonicUploadlibrary as $key => $Uploadlibrary)
                                            <option value="{{  @$key }}" data-FlussonicUploadlibraryID-key="{{ @$Uploadlibrary['url'] }}">{{ @$Uploadlibrary['url'] }}</option>
                                            @endforeach
                                </select>  

                                <br>
                            @else
                                <input type="hidden" name="FlussonicUploadlibraryID" id="FlussonicUploadlibraryID" value="">
                            @endif

                            @if(@$theme_settings->enable_bunny_cdn == 1)
                        
                                <label for="bunny_cdn_upload_video">BunnyCDN Library:</label>
                                <!-- UploadlibraryID -->
                                <select class="phselect form-control" name="UploadlibraryID" id="UploadlibraryID" >
                                        <option value="">{{ __('Choose Stream Library from Bunny CDN') }}</option>
                                            @foreach($videolibrary as $library)
                                            <option value="{{  @$library['Id'] }}" data-library-ApiKey="{{ @$library['ApiKey'] }}">{{ @$library['Name'] }}</option>
                                            @endforeach
                                </select>  

                                <br>
                            @else
                                <input type="hidden" name="UploadlibraryID" id="UploadlibraryID" value="">
                            @endif
                            
                            <div class='content file UploadEnable'>
                                    <h4 class="card-title">Upload Full Video Here</h4>
                                    <!-- Dropzone -->
                                    <form action="{{URL::to('/cpp/uploadFile')}}" method= "post" class='dropzone' ></form> 
                                        <p class="text-center mt-2 mb-0">Trailers Can Be Uploaded From Video Edit Screen</p>
                                </div> 
                            </div> 
     
                            <div class="text-center" style="margin-top: 30px;">
                                <input type="button" id="Next" value='Proceed to Next Step' class='btn btn-primary'>
                            </div>
                            <input type="hidden" id="embed_url" value="<?php echo URL::to('/cpp/embededcode');?>">
                            <input type="hidden" id="mp4url" value="<?php echo URL::to('/cpp/mp4url');?>">
                            <input type="hidden" id="m3u8url" value="<?php echo URL::to('/cpp/m3u8url');?>">
                        </div>
                    <hr />
                </div>
                 <div class="col-md-12" align="center">
                        <div id="optionradio"  >
                                <input type="radio" class="text-black" value="videoupload" id="videoupload" name="videofile" checked="checked"> Video Upload &nbsp;&nbsp;&nbsp;
                                <input type="radio" class="text-black" value="m3u8"  id="m3u8" name="videofile">m3u8 Url &nbsp;&nbsp;&nbsp;
                                <input type="radio" class="text-black" value="videomp4"  id="videomp4" name="videofile"> Video mp4 &nbsp;&nbsp;&nbsp;
                                <input type="radio" class="text-black" value="embed_video"  id="embed_video" name="videofile"> Embed Code   
                                @if(@$theme_settings->enable_bunny_cdn == 1)
                                <input type="radio" class="text-black" value="bunny_cdn_video"  id="bunny_cdn_video" name="videofile"> Bunny CDN Videos              
                            @endif

                            @if(Enable_Flussonic_Upload() == 1)
                                <input type="radio" class="text-black" value="flussonic_storage_video"  id="flussonic_storage_video" name="videofile"> Flussonic Videos              
                            @endif           
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
                  $('.UploadEnable').hide();
               }
            });


            $('#FlussonicUploadlibraryID').change(function(){
               if($('#FlussonicUploadlibraryID').val() != null && $('#FlussonicUploadlibraryID').val() != ''){
               // alert($('#FlussonicUploadlibraryID').val());
                  $('.UploadEnable').show();
               }else{
                  $('.UploadEnable').hide();
               }
            });

         $(document).ready(function() {
            $('#bunny_cdn_linked_video').select2();
         });

         $(document).ready(function() {
            $('#Flussonic_linked_video').select2();
         });

         $(document).ready(function(){


            $('#FlussonicUploadlibrary').on('change', function() {
                  
                  var FlussonicUploadlibraryID = this.value;
                  $("#Flussonic_linked_video").html('');
                     $.ajax({
                     url:"{{url::to('cpp/FlussonicUploadlibrary')}}",
                     type: "POST",
                     data: {
                     FlussonicUploadlibraryID: FlussonicUploadlibraryID,
                     _token: '{{csrf_token()}}' 
                     },
                     dataType : 'json',
                     success: function(result){
                        var streamvideos = result.streamvideos.files;
                        console.log(result.streamvideos.files); 
                        var StreamURL = result.StreamURL;

                  $('#Flussonic_linked_video').html('<option value="">Choose Videos from Flussonic</option>'); 

                     $.each(streamvideos, function(key, value) {
                           var videoUrl = StreamURL + value.name + '/index.m3u8';
                           // console.log(videoUrl); 
                           $("#Flussonic_linked_video").append('<option value="' + videoUrl + '">' + value.name + '</option>');
                        });
                     }
                  });

               }); 


            $('#videolibrary').on('change', function() {
                  
                  var videolibrary_id = this.value;
                  $("#bunny_cdn_linked_video").html('');
                     $.ajax({
                     url:"{{url::to('cpp/bunnycdn_videolibrary')}}",
                     type: "POST",
                     data: {
                     videolibrary_id: videolibrary_id,
                     _token: '{{csrf_token()}}' 
                     },
                     dataType : 'json',
                     success: function(result){
                        // alert();
                  // var streamUrl = '{{$streamUrl}}' ;
                  var streamvideos = result.streamvideos;
                  var PullZoneURl = result.PullZoneURl;
                  var decodedStreamVideos = JSON.parse(streamvideos);

                  // console.log(decodedStreamVideos);


                  $('#bunny_cdn_linked_video').html('<option value="">Choose Videos from Bunny CDN</option>'); 

                     $.each(decodedStreamVideos.items, function(key, value) {
                        console.log(value.title);
                        var videoUrl = PullZoneURl + '/' + value.guid + '/playlist.m3u8';
                        $("#bunny_cdn_linked_video").append('<option value="' + videoUrl + '">' + value.title + '</option>');
                        // $("#bunny_cdn_linked_video").append('<option value="'+videoUrl+'">'+value.title+'</option>');
                     });

                  // old code 
                     // $('#bunny_cdn_linked_video').html('<option value="">Choose Videos from Bunny CDN</option>'); 
                     // $.each(result.items,function(key,value){
                     //    console.log(value.title);
                     //    $("#bunny_cdn_linked_video").append('<option value="'+streamUrl+'/'+value.guid+'/'+'playlist.m3u8'+'">'+value.title+'</option>');

                     // // $("#bunny_cdn_linked_video").append('<option value="'+value.title+'">'+value.title+'</option>');
                     // });
                     }
                  });

               }); 


         	$('#video_upload').show();
         	$('#video_mp4').hide();
         	$('#embedvideo').hide();
         	$('#m3u8_url').hide();
         	$('#bunnycdnvideo').hide();
         	$('#flussonicstoragevideo').hide();
         
         
         $('#videoupload').click(function(){
         	$('#video_upload').show();
         	$('#video_mp4').hide();
         	$('#embedvideo').hide();
         	$('#m3u8_url').hide();
         	$('#bunnycdnvideo').hide();
         	$('#flussonicstoragevideo').hide();

         
         	$("#video_upload").addClass('collapse');
         	$("#video_mp4").removeClass('collapse');
         	$("#embed_video").removeClass('collapse');
         	$("#bunny_cdn_video").removeClass('collapse');
         	$("#flussonic_storage_video").removeClass('collapse');
         	$("#m3u8").removeClass('m3u8');
         
         
         })
         $('#videomp4').click(function(){
         	$('#video_upload').hide();
         	$('#video_mp4').show();
         	$('#embedvideo').hide();
         	$('#m3u8_url').hide();
         	$('#bunnycdnvideo').hide();
         	$('#flussonicstoragevideo').hide();
         
         	$("#video_upload").removeClass('collapse');
         	$("#video_mp4").addClass('collapse');
         	$("#embed_video").removeClass('collapse');
         	$("#bunny_cdn_video").removeClass('collapse');
         	$("#flussonic_storage_video").removeClass('collapse');
         	$("#m3u8").removeClass('m3u8');
         
         
         })
         $('#embed_video').click(function(){
         	$('#video_upload').hide();
         	$('#video_mp4').hide();
         	$('#embedvideo').show();
         	$('#m3u8_url').hide();
         	$('#bunnycdnvideo').hide();
         	$('#flussonicstoragevideo').hide();
         
         	$("#video_upload").removeClass('collapse');
         	$("#video_mp4").removeClass('collapse');
         	//$("#embed_video").addClass('collapse');
         	$("#bunny_cdn_video").removeClass('collapse');
         	$("#flussonic_storage_video").removeClass('collapse');
         	$("#m3u8").removeClass('m3u8');
         
         
         })
         $('#m3u8').click(function(){
         	$('#video_upload').hide();
         	$('#video_mp4').hide();
         	$('#embedvideo').hide();
         	$('#m3u8_url').show();
         	$('#bunnycdnvideo').hide();
         	$('#flussonicstoragevideo').hide();

         	$("#video_upload").removeClass('collapse');
         	$("#video_mp4").removeClass('collapse');
         	$("#embed_video").removeClass('collapse');
         	$("#bunny_cdn_video").removeClass('collapse');
         	$("#flussonic_storage_video").removeClass('collapse');
         	$("#m3u8").addClass('m3u8');
         
         })

            $('#bunny_cdn_video').click(function(){

               $('#video_upload').hide();
               $('#video_mp4').hide();
               $('#embedvideo').hide();
               $('#m3u8_url').hide();
               $('#bunnycdnvideo').show();
               $('#flussonicstoragevideo').hide();

               $("#video_upload").removeClass('collapse');
               $("#video_mp4").removeClass('collapse');
               $("#embed_video").removeClass('collapse');
               $("#flussonic_storage_video").removeClass('collapse');
               $("#m3u8").addClass('m3u8');
            })

            $('#flussonic_storage_video').click(function(){

               $('#video_upload').hide();
               $('#video_mp4').hide();
               $('#embedvideo').hide();
               $('#m3u8_url').hide();
               $('#bunnycdnvideo').hide();
               $('#flussonicstoragevideo').show();

               $("#video_upload").removeClass('collapse');
               $("#video_mp4").removeClass('collapse');
               $("#embed_video").removeClass('collapse');
               $("#bunny_cdn_video").removeClass('collapse');
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

            if(value.total_uploads == 0){
                location.reload();
            }
            
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

            if(value.total_uploads == 0){
                location.reload();
            }
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

            if(value.total_uploads == 0){
                location.reload();
            }

			console.log(value);
            $('#Next').show();
           $('#video_id').val(value.video_id);

        }
    });
})


$('#submit_bunny_cdn').click(function(){
   	// alert($('#embed_code').val());
   	$.ajax({
           url: '{{ URL::to('/cpp/stream_bunny_cdn_video') }}',
           type: "post",
   data: {
                  _token: '{{ csrf_token() }}',
                  bunny_cdn_linked_video: $('#bunny_cdn_linked_video').val()
   
            },        success: function(value){
   			console.log(value);
               $('#Next').show();
              $('#video_id').val(value.video_id);
   
           }
       });
   })

   
   $('#submit_Flussonic_storage').click(function(){
   	// alert($('#embed_code').val());
   	$.ajax({
           url: '{{ URL::to('/cpp/Flussonic_Storage_UploadURL') }}',
           type: "post",
            data: {
                  _token: '{{ csrf_token() }}',
                  Flussonic_linked_video: $('#Flussonic_linked_video').val()
   
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
        <script src="https://malsup.github.com/jquery.form.js"></script>

    <div id="content-page" class="content-page1">
    <div class="container-fluid">
        <div class="iq-card p-3">
    <div class="row justify-content-center">
        <div class="col-11 col-sm-10 col-md-10 col-lg-12 col-xl-12 text-center p-0 mt-3 mb-2">
            <div class="px-0 pt-4 pb-0 mt-12 mb-3 col-md-12">
                <!-- <h2 id="heading">Sign Up Your User Account</h2>
                <p>Fill all form field to go to next step</p> -->
                <form method="POST" action="{{ $post_route }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data" id="msform">
                    <!-- progressbar -->
                    <ul id="progressbar">
                        <li class="active" id="videot"><img class="" src="<?php echo  URL::to('/assets/img/icon/1.svg')?>">Video</li>
                          <li class="" id="account"><img class="" src="<?php echo  URL::to('/assets/img/icon/1.svg')?>">Video Details</li>
                  <li id="personal"><img class="" src="<?php echo  URL::to('/assets/img/icon/2.svg')?>">Category</li>
                  <li id="useraccess_ppvprice"><img class="" src="<?php echo  URL::to('/assets/img/icon/3.svg')?>">User Video Access</li>
                  <li id="payment"><img class="" src="<?php echo  URL::to('/assets/img/icon/4.svg')?>">Upload Image &amp; Trailer</li>
                  <li id="confirm"><img class="" src="<?php echo  URL::to('/assets/img/icon/5.svg')?>">Ads Management &amp; Transcoding</li>
                        
                    </ul>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                    </div> <br> <!-- fieldsets -->
                    <fieldset>
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
                                    <label class="p-2">Title :</label>
                                    <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="">
                                </div>
                                <div class="col-sm-6 form-group" >
                                    <label class="p-2">
                                    Video Slug <a class="" data-toggle="tooltip" data-placement="top" title="Please enter the name of the video again here" data-original-title="this is the tooltip" href="#">
                                    <i class="las la-exclamation-circle"></i></a>:</label>
                                    <input type="text"   class="form-control" name="slug" id="slug" placeholder="Video Slug" value="@if(!empty($video->slug)){{ $video->slug }}@endif">
                                </div>
                                </div>
                            <div class="row">
                                 
                                <div class="col-sm-6 form-group">
                                <label>Age Restrict :</label>
                                <select class="form-control" id="age_restrict" name="age_restrict">
                                    <option selected  value="0">Choose Age</option>
                                    @foreach($age_categories as $age)
                                        <option value="{{ $age->age }}" @if(!empty($video->language) && $video->age_restrict == $age->slug)selected="selected"@endif>{{ $age->slug }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6 form-group ">                                       
                                    <label class="p-2">Rating:</label>
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

                                <div class="col-sm-4 form-group mt-3">
                                <label class="">Skip Intro Time</label>
                                <p>Please Give In Seconds</p> 
                                <input type="text" class="form-control" id="skip_intro" name="skip_intro" >
                                </div>
                                <div class="col-sm-4 form-group mt-3">
                                <label class="">Intro Start Time</label>
                                <p>Please Give In Seconds</p> 
                                <input type="text" class="form-control" id="intro_start_time" name="intro_start_time" >
                                </div>
                                <div class="col-sm-4 form-group mt-3">
                                <label class="">Intro End Time</label>
                                <p>Please Give In Seconds</p> 
                                <input type="text" class="form-control" id="intro_end_time" name="intro_end_time" >
                                </div>
                                </div>

                                <div class="row">
                                <div class="col-sm-4 form-group mt-3">
                                <label class="">Skip Recap </label>
                                <p>Please Give In Seconds</p> 
                                <input type="text" class="form-control" id="skip_recap" name="skip_recap" >
                                </div>
                                <div class="col-sm-4 form-group mt-3">
                                <label class="">Recap Start Time</label>
                                <p>Please Give In Seconds</p> 
                                <input type="text" class="form-control" id="recap_start_time" name="recap_start_time" >
                                </div>
                                <div class="col-sm-4 form-group mt-3">
                                <label class="">Recap End Time</label>
                                <p>Please Give In Seconds</p> 
                                <input type="text" class="form-control" id="recap_end_time" name="recap_end_time" >
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
                                    <label class=""><h4>Publish Type</h4></label>
                                    
                                    <div class="d-flex align-items-baseline">
                                         <div> <input type="radio" id="publish_now" name="publish_type" value = "publish_now" checked="checked" ></div>
                                 
                                        <div><label class="ml-2">Publish Now</label></div> 
                                   </div>
                                    <div class="d-flex align-items-baseline"><div> <input type="radio" id="publish_later" name="publish_type" value = "publish_later" ></div> 
                                   <div><label class="ml-2">Publish Later</label></div> 
                                   </div>
                                   
                                    
                                </div>

                                <div class="col-sm-6 form-group mt-3" id="publishlater">
                                <label class="">Publish Time</label>
                                <input type="datetime-local" class="form-control" id="publish_time" name="publish_time" >
                                </div>
                                </div>
                            <div class="row">

                            <div class="col-lg-12 form-group">
                            <h5 class="mb-3">Video description:</h5>
                            <textarea  rows="5" class="form-control mt-2" name="description" id="summary-ckeditor"
                        placeholder="Description">@if(!empty($video->description)){{ strip_tags($video->description) }}@endif</textarea>
                        </div>
                        <div class="col-12 form-group">
                                <textarea   rows="5" class="form-control mt-2" name="details" id="links-ckeditor"
                            placeholder="Link , and details">@if(!empty($video->details)){{ htmlspecialchars($video->details) }}@endif</textarea>
                            </div>
                                </div>

                      </div> <input type="button" name="next" class="next action-button ml-3" value="Next" />
                    </fieldset>
                    <fieldset class="Next3">
                        <div class="form-card">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="fs-title">Video Category:</h2>
                                </div>
                                <div class="col-5">
                                    <!-- <h2 class="steps">Step 2 - 4</h2> -->
                                </div>
                            </div>


                            <div class="row">

                            <div class="col-sm-6 form-group" >
                                <label class="p-2">Select Video Category :</label>
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
                                            <label>Cast and Crew</label> 
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
                                </div>

                                <div class="row">
                                    <div class="col-sm-6 form-group">
                                        <label class="p-2">Choose Language:</label>
                                        <select class="form-control js-example-basic-multiple" id="language" name="language[]" style="width: 100%;" multiple="multiple">
                                            <!-- <option selected disabled="">Choose Language</option> -->
                                            @foreach($languages as $language)
                                            <option value="{{ $language->id }}">{{ $language->name }}</option>
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
                                        <input type="file" class="form-group" name="reels_videos" accept="video/mp4,video/x-m4v,video/*" id="" multiple>
                                    </div>


                                    <div class="col-sm-6 form-group">
                                        <label class="m-0" style="display:block;">URL Link </label>
                                        <input type="text" class="form-group form-control" name="url_link" accept="" id="url_link" >
                                    </div>
    
                                    <div class="col-sm-6 form-group">
                                        <label class="m-0">URL Start Time <small>Format (HH:MM:SS)</small></label>
                                        <input type="text" class="form-group form-control" name="url_linktym" accept="" id="url_linktym" >
                                    </div>
                                </div>

                                
                                            <div class="row mt-5">    
                                <div class="panel panel-primary" data-collapsed="0"> 
                                    <div class="panel-heading"> 
                                        <div class="panel-title" style="color: #000;">Subtitles (WebVTT (.vtt) or SubRip (.srt)) :</h3>
                                            <a href="{{ URL::to('/ExampleSubfile.vtt') }}" download="sample.vtt" class="btn btn-primary">Download Sample .vtt</a>
                                            <a href="{{ URL::to('/Examplefile.srt') }}" download="sample.vtt" class="btn btn-primary">Download Sample .srt</a>
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
                        </div> <input type="button" name="next" id="next3" class="next action-button" value="Next" /> <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                    </fieldset>
            
                    <fieldset>
                        <div class="form-card">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="fs-title">User Access:</h2>
                                </div>
                                <div class="col-5">
                                    <!-- <h2 class="steps">Step 3 - 4</h2> -->
                                </div>
                            </div> 
                            <div class="row">
                                    {{-- <div class="col-md-4">
                                        <label class="">Recommendation </label>
                                        <input type="text" class="form-control" id="Recommendation " name="Recommendation" >
                                    </div> --}}


                                {{-- Block country --}}
                                    <div class="col-sm-4 form-group">
                                        <label><h5>Block Country</h5></label>
                                        <p class="p1">Choose the countries for block the videos</p> 
                                        <select  name="country[]" class="js-example-basic-multiple" style="width: 100%;" multiple="multiple">
                                            @foreach($countries as $country)
                                                <option value="{{ $country->country_name }}" >{{ $country->country_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                {{-- country --}}
                                    <div class="col-sm-4 form-group">
                                        <label><h5>Country</h5></label>
                                        <p class="p1">Choose the countries videos</p> 
                                        <select  name="video_country" class="form-control" id="country">
                                        <option value="All">Select Country </option>
                                            @foreach($countries as $country)
                                                <option value="{{ $country->country_name }}" >{{ $country->country_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                </div>
                            <div class="row">
                                <div class="col-sm-6 form-group mt-3">
                                    <label class="p-2">User Access</label>
                                    <select id="access" name="access"  class="form-control" >
                                        <option value="guest" >Guest ( everyone )</option>
                                        <option value="subscriber" >Subscriber ( Must subscribe to watch )</option>
                                        <option value="registered" >Registered Users( Must register to watch )</option>   
                                        <?php if($settings->ppv_status == 1){ ?>
                                        <option value="ppv" >PPV Users (Pay per movie)</option>   
                                        <?php } else{ ?>
                                        <option value="ppv" >PPV Users (Pay per movie)</option>   
                                        <?php } ?>
                                    </select>
                                </div> 
                                </div>

                                <div class="row" id="ppv_price">
                                    <div class="col-sm-6 form-group mt-3" >
                                      <label class="">PPV Price:</label>
                                      <input type="text" class="form-control" placeholder="PPV Price" name="ppv_price" id="price" value="@if(!empty($video->ppv_price)){{ $video->ppv_price }}@endif">
                                    </div>

                                  <div class="col-sm-6 form-group mt-3" >
                                    <label class="">IOS PPV Price:</label>
                                        <select  name="ios_ppv_price" class="form-control" id="ios_ppv_price">
                                          <option value= "" >Select IOS PPV Price: </option>
                                          @foreach($InappPurchase as $Inapp_Purchase)
                                            <option value="{{ $Inapp_Purchase->product_id }}"  @if(!empty($video->ppv_price) &&  $video->ios_ppv_price == $Inapp_Purchase->product_id) selected='selected' @endif >{{ $Inapp_Purchase->plan_price }}</option>
                                          @endforeach
                                      </select>
                                  </div>
                                </div>

                            <div class="row">
                                <div class="col-sm-6 form-group mt-3 d-flex" id="ppv_price">
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
                                </div>
                            <div class="row">
                            <!-- <div class="row"> -->
                              <div class="col-sm-6 form-group mt-3" id="ppv_price">
                                 <label for="">Search Tags </label>
                                 <input type="text"  class="form-control1"  id="tag-input1" name="searchtags" >
                                 </div>
                           <!-- </div> -->
                                <!-- <div class="col-sm-6 mt-3"> 
                                    <div class="panel panel-primary" data-collapsed="0"> 
                                        <div class="panel-heading"> 
                                            <div class="panel-title">
                                                <label><h3>Status Settings</h3> </label>
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
                                </div> -->
                                
                                <div class="col-sm-6 form-group">
                                       <label class="m-0">Related Videos:</label>
                                       <select  name="related_videos[]" class="form-control js-example-basic-multiple" style="width: 100%;" multiple="multiple">
                                          <!-- <option value="">Choose Videos</option> -->
                                             @foreach($related_videos as $key => $video)
                                                <option value="{{ $video->id }}"  > {{ $video->title }}</option>
                                             @endforeach
                                       </select>
                                    </div>
                            </div>
                          
                            <!-- </div> -->

                        </div>  <input type="button" name="next" class="next action-button" value="Next" />
                         <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                    </fieldset>
                    <fieldset>
                        <div class="form-card">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="fs-title">Image Upload:</h2>
                                </div>
                                <div class="col-5">
                                    <!-- <h2 class="steps">Step 3 - 4</h2> -->
                                </div>
                            </div> 
                            <div class="row">
                            <div class="col-sm-6 form-group">
                              <label class="mb-1">Video Thumbnail </label><br>
                                @php 
                                    $width = $compress_image_settings->width_validation_videos;
                                    $heigth = $compress_image_settings->height_validation_videos;
                                @endphp
                                @if($width !== null && $heigth !== null)
                                    <p class="p1">{{ ("Video Thumbnail (".''.$width.' x '.$heigth.'px)')}}:</p> 
                                @else
                                    <p class="p1">{{ "Video Thumbnail ( 9:16 Ratio or 1080X1920px )"}}:</p> 
                                @endif
                                 <input type="file" name="image" id="image" >
                                 <span>
                                    <p id="video_image_error_msg" style="color:red !important; display:none;">
                                        * Please upload an image with the correct dimensions.
                                    </p>
                                </span>
                              </div>
                              <div class="col-sm-6 form-group">
                              <label class="mb-1">Player Thumbnail </label><br>
                                @php 
                                    $player_width = $compress_image_settings->width_validation_player_img;
                                    $player_heigth = $compress_image_settings->height_validation_player_img;
                                @endphp
                                @if($player_width !== null && $player_heigth !== null)
                                    <p class="p1">{{ ("Player Thumbnail (".''.$player_width.' x '.$player_heigth.'px)')}}:</p> 
                                @else
                                    <p class="p1">{{ "Player Thumbnail ( 16:9 Ratio or 1280X720px )"}}:</p> 
                                @endif
                              <input type="file" name="player_image" id="player_image" >
                              <span>
                                <p id="player_video_image_error_msg" style="color:red !important; display:none;">
                                   * Please upload an image with the correct dimensions.
                                </p>
                             </span>
                              @if(!empty($video->player_image))
                              <img src="{{ URL::to('/') . '/public/uploads/images/' . $video->player_image }}" class="video-img w-100" />
                              @endif
                              </div>
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
                        </div> 
                        <input type="button" name="next" class="next action-button update_upload_img" value="Next" />
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
                                <div class="col-sm-6 form-group mt-3">
                                    <label class="">Choose Ad Name</label>
                                    <select class="form-control" name="ads_id">
                                        <option value="0">Select Ads</option>
                                        @foreach($ads as $ad)
                                        <option value="{{$ad->id}}">{{$ad->ads_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
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
    * {
    margin: 0;
    padding: 0
}

html {
    height: 100%
}

p {
    color: grey
}

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

#msform fieldset {
    background: white;
    border: 0 none;
    border-radius: 0.5rem;
    box-sizing: border-box;
    width: 100%;
    margin: 0;
    padding-bottom: 20px;
    position: relative
}

.form-card {
    text-align: left;
    padding: 20px;
}

#msform fieldset:not(:first-of-type) {
    display: none
}

#msform input,
#msform textarea {
    padding: 8px 15px 8px 15px;
   
    border-radius: 0px;
    margin-bottom: 25px;
    margin-top: 8px;
  
    box-sizing: border-box;
  
    color: #2C3E50;
  
    font-size: 16px;
    letter-spacing: 1px
}

#msform input:focus,
#msform textarea:focus {
    -moz-box-shadow: none !important;
    -webkit-box-shadow: none !important;
    box-shadow: none !important;
    border: 1px solid #673AB7;
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
    margin: 10px 28px 10px 5px;
    float: right;
}

#msform .action-button:hover,
#msform .action-button:focus {
    background-color: #311B92
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
    float: right;
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
    font-size: 25px;
    color: #673AB7;
    margin-bottom: 15px;
    font-weight: normal;
    text-align: left
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

#progressbar {
    margin-bottom: 30px;
    overflow: hidden;
    color: lightgrey
}

#progressbar .active {
    color: #673AB7
}

#progressbar li {
    list-style-type: none;
    font-size: 15px;
    width: 16%;
    float: left;
    position: relative;
    font-weight: 400;
    color: #000;
    padding: 10px;
}

#progressbar #account:before {
    font-family: FontAwesome;
    content: "\f13e"
}

#progressbar #personal:before {
    font-family: FontAwesome;
    content: "\f007"
}

#progressbar #useraccess_ppvprice:before {
    font-family: FontAwesome;
    content: "\f030"
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
    display: none;
    
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

#progressbar li.active:before,
#progressbar li.active:after {
    /*background: #673AB7*/
}

.progress {
    height: 20px
}

.progress-bar {
    background-color: #673AB7
}

.fit-image {
    width: 100%;
    object-fit: cover
}
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

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>                       
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
    <script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>

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

<script src="https://cdn.ckeditor.com/ckeditor5/38.1.1/classic/ckeditor.js"></script>

<script>
        ClassicEditor
            .create( document.querySelector( '#summary-ckeditor' ) )
            .catch( error => {
                console.error( error );
            } );
            ClassicEditor
            .create( document.querySelector( '#links-ckeditor' ) )
            .catch( error => {
                console.error( error );
            } );
            ClassicEditor
            .create( document.querySelector( '#trailer-ckeditor' ) )
            .catch( error => {
                console.error( error );
            } );
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
        maxFilesize: 15000000000,
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

        formData.append("UploadlibraryID", $('#UploadlibraryID').val());
        formData.append("FlussonicUploadlibraryID", $('#FlussonicUploadlibraryID').val());
       formData.append("_token", CSRF_TOKEN);
      // console.log(value)
      this.on("success", function(file, value) {
        // console.log(value);
            if(value.total_uploads == 0){
                location.reload();
            }
            console.log(value);
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

</script>

<script>

$(document).ready(function(){

   $('#error_video_Category').hide();
   $('#error_language').hide();
   $('#image_error_msg').hide();
   $('#player_image_error_msg').hide();

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


    // $('#image').on('change', function(event) {

    //     $('#image').removeData('imageWidth');
    //     $('#image').removeData('imageHeight');
    //     $('#image').removeData('imageratio');

    //     var file = this.files[0];
    //     var tmpImg = new Image();

    //     tmpImg.src=window.URL.createObjectURL( file ); 
    //     tmpImg.onload = function() {
    //         width = tmpImg.naturalWidth,
    //         height = tmpImg.naturalHeight;
    //         ratio =  Number(width/height).toFixed(2) ;
    //         image_validation_status = "{{  image_validation_videos() }}" ;

    //         $('#image').data('imageWidth', width);
    //         $('#image').data('imageHeight', height);
    //         $('#image').data('imageratio', ratio);

    //         if(  image_validation_status == "0" ||  ratio == '0.56'|| width == '1080' && height == '1920' ){
    //             $('.update_upload_img').removeAttr('disabled');
    //             $('#image_error_msg').hide();
    //         }
    //         else{
    //             $('.update_upload_img').attr('disabled','disabled');
    //             $('#image_error_msg').show();
    //         }
    //     }
    // });


    // $('#player_image').on('change', function(event) {

    //     $('#player_image').removeData('imageWidth');
    //     $('#player_image').removeData('imageHeight');
    //     $('#player_image').removeData('imageratio');

    //     var file = this.files[0];
    //     var tmpImg = new Image();

    //     tmpImg.src=window.URL.createObjectURL( file ); 
    //     tmpImg.onload = function() {
    //     width = tmpImg.naturalWidth,
    //     height = tmpImg.naturalHeight;
    //     ratio =  Number(width/height).toFixed(2) ;
    //     image_validation_status = "{{  image_validation_videos() }}" ;

    //     $('#player_image').data('imageWidth', width);
    //     $('#player_image').data('imageHeight', height);
    //     $('#player_image').data('imageratio', ratio);

    //     if(  image_validation_status == "0" ||   ratio == '1.78' || width == '1280' && height == '720' ){
    //         $('.update_upload_img').removeAttr('disabled');
    //         $('#player_image_error_msg').hide();
    //     }
    //      else{
    //         $('.update_upload_img').attr('disabled','disabled');
    //         $('#player_image_error_msg').show();
    //     }
    //     }
    // });
});

 </script>

<script>
    $(document).ready(function(){
    
       $('#image_error_msg,#player_image_error_msg,#tv_image_image_error_msg').hide();
 
       $('#image').on('change', function(event) {
 
 
             var file = this.files[0];
             var tmpImg = new Image();
 
             tmpImg.src=window.URL.createObjectURL( file ); 
             tmpImg.onload = function() {
                width = tmpImg.naturalWidth,
                height = tmpImg.naturalHeight;
                image_validation_status = "{{  image_validation_videos() }}" ;
                console.log(width);
                var validWidth = {{ $compress_image_settings->width_validation_videos ?: 1080 }};
                var validHeight = {{ $compress_image_settings->height_validation_videos ?: 1920 }};
                console.log('validWidth ' + validWidth);
                console.log(validHeight);
 
                if (width !== validWidth || height !== validHeight) {
                      document.getElementById('video_image_error_msg').style.display = 'block';
                      $('.update_upload_img').prop('disabled', true);
                      document.getElementById('video_image_error_msg').innerText = 
                         `* Please upload an image with the correct dimensions (${validWidth}x${validHeight}px).`;
                   } else {
                      document.getElementById('video_image_error_msg').style.display = 'none';
                      $('.update_upload_img').prop('disabled', false);
                   }
             }
       });
      
       $('#player_image').on('change', function(event) {
 
          var file = this.files[0];
          var player_Img = new Image();
 
          player_Img.src=window.URL.createObjectURL( file ); 
          player_Img.onload = function() {
          var width = player_Img.naturalWidth;
          var height = player_Img.naturalHeight;
          image_validation_status = "{{  image_validation_videos() }}" ;
          console.log('player width ' + width)
 
          var valid_player_Width = {{ $compress_image_settings->width_validation_player_img ?: 1280 }};
          var valid_player_Height = {{ $compress_image_settings->height_validation_player_img ?: 720 }};
          console.log(valid_player_Width + 'player width');
 
          if (width !== valid_player_Width || height !== valid_player_Height) {
                document.getElementById('player_image_error_msg').style.display = 'block';
                $('.update_upload_img').prop('disabled', true);
                document.getElementById('player_image_error_msg').innerText = 
                   `* Please upload an image with the correct dimensions (${validWidth}x${validHeight}px).`;
          } else {
                document.getElementById('player_image_error_msg').style.display = 'none';
                $('.update_upload_img').prop('disabled', false);
          }
          }
       });
    });
 
 </script>

 
{{-- <script>
    document.getElementById('image').addEventListener('change', function() {
        var file = this.files[0];
        if (file) {
            var img = new Image();
            img.onload = function() {
                var width = img.width;
                var height = img.height;
                console.log(width);
                console.log(height);
                
                var validWidth = {{ $compress_image_settings->width_validation_videos }};
                var validHeight = {{ $compress_image_settings->height_validation_videos }};
                console.log(validWidth);
                console.log(validHeight);
 
                if (width !== validWidth || height !== validHeight) {
                   
                    document.getElementById('video_image_error_msg').style.display = 'block';
                    $('.update_upload_img').prop('disabled', true);
                    document.getElementById('video_image_error_msg').innerText = 
                        `* Please upload an image with the correct dimensions (${validWidth}x${validHeight}px).`;
                } else {
                   
                    document.getElementById('video_image_error_msg').style.display = 'none';
                    $('.update_upload_img').prop('disabled', false);
                }
            };
            img.src = URL.createObjectURL(file);
        }
    });
 
    document.getElementById('player_image').addEventListener('change', function() {
        var file = this.files[0];
        if (file) {
            var img = new Image();
            img.onload = function() {
                var width = img.width;
                var height = img.height;
                console.log(width);
                console.log(height);
                
                var validWidth = {{ $compress_image_settings->width_validation_player_img }};
                var validHeight = {{ $compress_image_settings->height_validation_player_img }};
                console.log(validWidth);
                console.log(validHeight);
                
                if (width !== validWidth || height !== validHeight) {
                   console.log('failed')
                    document.getElementById('player_video_image_error_msg').style.display = 'block';
                    $('.update_upload_img').prop('disabled', true);
                    document.getElementById('player_video_image_error_msg').innerText = 
                        `* Please upload an image with the correct dimensions (${validWidth}x${validHeight}px).`;
                } else {
                   console.log('success')
                    document.getElementById('player_video_image_error_msg').style.display = 'none';
                    $('.update_upload_img').prop('disabled', false);
                }
            };
            img.src = URL.createObjectURL(file);
        }
    });
 
 </script> --}}

@include('admin.videos.search_tag'); 

@stop

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
    .content-page {
    overflow: hidden;
        margin-left: 300px;}
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
	 color: #fff;
     height: 30px;
     display: flex;
     align-items: center;
	 background-color: #000;
	 border-radius: 30px;
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
 .tag__name {
	 margin-right: 3px;
     color: #fff!important;
}
 .tag__remove {
	 position: absolute;
	 right: 0;
	 bottom: 0;
	 width: 20px;
	 height: 100%;
	 padding: 0 0px;
	 font-size: 16px;
	 font-weight: 400;
	 transition: opacity 0.3s ease;
	border: none;
	 cursor: pointer;
	 border-radius: 30px;
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
.gridContainer{
   display: grid;
   grid-template-columns: repeat(5, calc(100% / 5));
}
.gridItem{
   padding:5px;
}
   .dropzone .dz-preview .dz-progress{height:14px !important;}
    span#upload-percentage{position: absolute;right: 30%;bottom: -3px;font-weight:800 !important;font-size:10px;}
    .dropzone .dz-preview .dz-progress .dz-upload{border-radius:5px;}
    .dropzone .dz-preview .dz-progress {overflow: visible;top: 82%;border: none;}
    .dz-cancel {color: #FF0000;background: none;border: none;padding: 5px;}
   .dz-cancel:hover {text-decoration: underline;}
   .dropzone .dz-preview.dz-complete .dz-progress {opacity: 1;}

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
                     <div class="new-audio-file mt-3">
                        <button class="btn btn-primary"  id="submit_m3u8">Submit</button>
                     </div>
                  </div>
                  <!-- Embedded Video -->        
                  <div id="embedvideo" style="">
                     <div class="new-audio-file mt-3">
                        <label for="embed_code">Embed URL:</label>
                        <p class="p1">Example URL Format : ( https://www.youtube.com/embed/*xxxxxxxxx*/) ) </p>
                        <input type="text" class="form-control" name="embed_code" id="embed_code" value="" />
                     </div>
                     <div class="new-audio-file mt-3">
                        <button class="btn btn-primary"  id="submit_embed">Submit</button>
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

                  <!-- MP4 Video -->        
                  <div id="video_mp4" style="">
                     <div class="new-audio-file mt-3" >
                        <label for="mp4_url"><label>Mp4 File URL:</label></label>
                        <input type="text" class="form-control" name="mp4_url" id="mp4_url" value="" />
                     </div>
                     <div class="new-audio-file mt-3">
                        <button class="btn btn-primary"  id="submit_mp4">Submit</button>
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
                     <div class="content file UploadEnable">
                           <h3 class="card-title upload-ui font-weight-bold">Upload Full Video Here</h3>
                           <!-- Dropzone -->
                           <form action="{{ $post_dropzone_url }}" method="post" class="dropzone"></form>
                           <div class="row justify-content-center">
                                 <div class="col-md-9 text-center">
                                    <p class="c1">Trailers Can Be Uploaded From Video Edit Screen</p>
                                 </div>
                           </div>
                        </div>

                       <!-- Dropzone template -->
                     <div id="template" style="display: none;">
                        <div class="dz-preview dz-file-preview">
                           <div class="dz-image"><img data-dz-thumbnail/></div>
                           <div class="dz-details">
                              <button class="dz-cancel" type="button">Cancel</button>
                              <div class="dz-filename"><span data-dz-name></span></div>
                              <div class="dz-size" data-dz-size></div>
                              <div class="dz-progress"> <span class="dz-upload" data-dz-uploadprogress></span><span class="dz-upload-percentage" id="upload-percentage">0%</span></div>
                              <div class="dz-error-message"><span data-dz-errormessage></span></div>
                              <div class="dz-success-mark">
                                    <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                       <title>Check</title> 
                                       <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> 
                                          <path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF"></path> 
                                       </g> 
                                    </svg>
                              </div>
                              <div class="dz-error-mark"> 
                                    <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"> 
                                       <title>Error</title> 
                                       <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> 
                                          <g stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475"> <path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z"></path> 
                                          </g> 
                                       </g> 
                                    </svg> 
                              </div>
                                
                           </div>
                               
                        </div>
                     </div>
                           <!-- <div class="col-md-3" style="display: flex;" >
                           <p id="speed">speed: 0kbs</p>&nbsp;&nbsp;&nbsp;
                           <p id="average">average: 0kbs</p>
                           </div> -->
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
      <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
      <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>


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
                     url:"{{url::to('admin/FlussonicUploadlibrary')}}",
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
                     url:"{{url::to('admin/bunnycdn_videolibrary')}}",
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
               // $("#bunny_cdn_video").removeClass('collapse');
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
       $('#submit_m3u8').click(function(){
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
       $('#submit_mp4').click(function(){
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
   $('#submit_embed').click(function(){
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
   

      $('#submit_bunny_cdn').click(function(){
   	// alert($('#embed_code').val());
   	$.ajax({
           url: '{{ URL::to('/admin/stream_bunny_cdn_video') }}',
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
           url: '{{ URL::to('/admin/Flussonic_Storage_UploadURL') }}',
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
                                 <!-- <span><p id="slug_error" style="color:red;">This slug already used </p></span> -->
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
                                 <label class="m-0">Skip Intro Time <small>(Duration Time In (HH : MM : SS))</small></label>
                                 <input type="text" class="form-control" id="skip_intro" name="skip_intro" value="@if(!empty($video->skip_intro)){{ gmdate('H:i:s', $video->skip_intro) }}@endif">
                                 <span><p id="error_skip_intro_time" style="color:red !important;">* Fill Skip Intro Time </p></span>
                              </div>

                              <div class="col-sm-4 form-group">
                                 <label class="m-0">Intro Start Time <small>(Duration Time In (HH : MM : SS))</small></label>
                                 <input type="text" class="form-control" id="intro_start_time" name="intro_start_time" value="@if(!empty($video->intro_start_time)){{ gmdate('H:i:s', $video->intro_start_time) }}@endif">
                                 <span><p id="error_intro_start_time" style="color:red !important;">* Fill Intro Start Time </p></span>
                              </div>

                              <div class="col-sm-4 form-group">
                                 <label class="m-0">Intro End Time <small>(Duration Time In (HH : MM : SS))</small></label>
                                 <input type="text" class="form-control" id="intro_end_time" name="intro_end_time" value="@if(!empty($video->intro_end_time)){{ gmdate('H:i:s', $video->intro_end_time) }}@endif">
                                 <span><p id="error_intro_end_time" style="color:red !important;">* Fill Intro End Time </p></span>
                              </div>
                           </div>

                           <div class="row">
                              <div class="col-sm-4 form-group">
                                 <label class="m-0"> Recap Time <small>(Duration Time In (HH : MM : SS))</small></label> <br>
                                 <span> <small> Recap Time Always Lesser than video duration </small> </span>
                                 <input type="text" class="form-control" id="skip_recap" name="skip_recap" value="@if(!empty($video->skip_recap)){{ gmdate('H:i:s', $video->skip_recap) }}@endif">
                              </div>

                              <div class="col-sm-4 form-group">
                                 <label class="m-0">Recap Start Time <small>(Duration Time In (HH : MM : SS))</small></label> <br>
                                 <span> <small> Start Time Always Lesser Than End Time </small> </span>
                                 <input type="text" class="form-control" id="recap_start_time" name="recap_start_time" value="@if(!empty($video->recap_start_time)){{ gmdate('H:i:s', $video->recap_start_time) }}@endif">
                              </div>

                              <div class="col-sm-4 form-group">
                                 <label class="m-0">Recap End Time <small>(Duration Time In (HH : MM : SS))</small></label> <br>
                                 <span> <small> Recap Time Always Greater than video duration </small> </span>
                                 <input type="text" class="form-control" id="recap_end_time" name="recap_end_time" value="@if(!empty($video->recap_end_time)){{ gmdate('H:i:s', $video->recap_end_time) }}@endif">
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

                              <div class="col-sm-6">
                                 <label class="m-0"> Enable Free Duration <small>(Enable / Disable Free Duration)</small></label>                        
                                 <div class="panel-body">
                                     <div class="mt-1">
                                         <label class="switch">
                                          <input name="free_duration_status"  id="free_duration_status" type="checkbox" >
                                          <span class="slider round"></span>
                                         </label>
                                     </div>
                                 </div>
                             </div>
         
                              <div class="col-sm-6 form-group">
                                 <label class="m-0"> Free Duration <small> In (HH : MM : SS)</small></label>
                                 <input type="text" class="form-control" placeholder="HH:MM:SS" name="free_duration" id="free_duration" >
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

                           @if (videos_expiry_date_status() == 1)
                              <div class="row">
                                 <div class="col-sm-4 form-group mt-3" id="">
                                    <label class="">Expiry Date & Time</label>
                                    <input type="datetime-local" class="form-control" id="expiry_date" name="expiry_date" >
                                 </div>
                              </div>
                           @endif

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
                                 <span><p id="error_video_Category" style="color:red !important; " >* Choose the Video Category </p></span>
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
                                 <span><p id="error_language" style="color:red !important;" >* Choose the Language </p></span>

                              </div>
                              
                              <div class="col-sm-6 form-group">
                                 <label class="m-0" style="display:block;">E-Paper: <small>(Upload your PDF file)</small></label>
                                 <input type="file" class="form-group" name="pdf_file" accept="application/pdf" id="" multiple>
                              </div>
                              <div class="col-sm-6 form-group">
                                 <label class="m-0">Choose Playlist:</label>
                                 <select class="form-control js-example-basic-multiple playlists" id="playlist" name="playlist[]" style="width: 100%;" multiple="multiple">
                                    <!-- <option selected disabled="">Choose Language</option> -->
                                    @foreach($AdminVideoPlaylist as $Video_Playlist)
                                    <option value="{{ $Video_Playlist->id }}" >{{ $Video_Playlist->title }}</option>
                                    @endforeach
                                 </select>

                              </div>
                              <div class="col-sm-6 form-group">
                                 <label class="m-0" style="display:block;">Reels Videos: </label>
                                 <div class="d-flex justify-content-around align-items-center" style="width:60%;">
                                    <div style="color:red;">Decode Reels </div>
                                    <div class="mt-1">
                                          <label class="switch">
                                             <input name="enable_reel_conversion"  type="checkbox"  >
                                             <span class="slider round"></span>
                                          </label>
                                    </div>
                                    <div style="color:green;">Encode Reels </div>
                                 </div>
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
                                    <div class="panel-title" style="color: #000;"> <label class="m-0"><h3 class="fs-title">Subtitles (WebVTT (.vtt) or SubRip (.srt)) :</h3>
                                    <a href="{{ URL::to('/ExampleSubfile.vtt') }}" download="sample.vtt" class="btn btn-primary">Download Sample .vtt</a>
                                    <a href="{{ URL::to('/Examplefile.srt') }}" download="sample.srt" class="btn btn-primary">Download Sample .srt</a></label>
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
                                 <label class="m-0"> Available Country </label>
                                 <p class="p1">( Choose the countries videos )</p>
                                 <select  name="video_country[]" class="js-example-basic-multiple" style="width: 100%;" multiple="multiple"  id="country">
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
                           </div>
                                          {{-- PPV Price --}}
                                 
                              <div class="row" id="ppv_price" >
                                 <div class="col-sm-6 form-group" >
                                    <label class="m-0">PPV Price:</label>
                                    <input type="text" class="form-control" placeholder="PPV Price" name="ppv_price" id="price" value="@if(!empty($video->ppv_price)){{ $video->ppv_price }}@endif">
                                    <span id="error_ppv_price" style="color:red;">*Enter the PPV Price </span>
                                 </div>
            
                                 <div class="col-sm-6 form-group" >
                                    <label class="m-0">IOS PPV Price:</label>
                                       <select  name="ios_ppv_price" class="form-control" id="ios_ppv_price">
                                          <option value= "" >Select IOS PPV Price: </option>
                                          @foreach($InappPurchase as $Inapp_Purchase)
                                             <option value="{{ $Inapp_Purchase->product_id }}" >{{ $Inapp_Purchase->plan_price }}</option>
                                          @endforeach
                                       </select>
                                 </div>
                              </div>

                              <div class="row" id="quality_ppv_price" >
                              <!-- <div class="col-sm-6 form-group" >
                                    <label class="m-0">PPV Price:</label>
                                    <input type="text" class="form-control" placeholder="PPV Price" name="ppv_price_240p"  value="@if(!empty($video->ppv_price_240p)){{ $video->ppv_price_240p }}@endif">
                                    <span id="error_ppv_price" style="color:red;">*Enter the 240 PPV Price </span>
                                 </div>
                                 <div class="col-sm-6 form-group" >
                                    <label class="m-0">PPV Price:</label>
                                    <input type="text" class="form-control" placeholder="PPV Price" name="ppv_price_360p"  value="@if(!empty($video->ppv_price_360p)){{ $video->ppv_price_360p }}@endif">
                                    <span id="error_ppv_price" style="color:red;">*Enter the 360 PPV Price </span>
                                 </div> -->
                                 <div class="col-sm-6 form-group" >
                                    <label class="m-0">PPV Price for 480 Plan:</label>
                                    <input type="text" class="form-control" placeholder="PPV Price" name="ppv_price_480p"  value="@if(!empty($video->ppv_price_480p)){{ $video->ppv_price_480p }}@endif">
                                    <span id="error_quality_ppv_price" style="color:red;">*Enter the 480 PPV Price </span>
                                 </div>
                                 <div class="col-sm-6 form-group" >
                                    <label class="m-0">PPV Price for 720 Plan:</label>
                                    <input type="text" class="form-control" placeholder="PPV Price" name="ppv_price_720p"  value="@if(!empty($video->ppv_price_720p)){{ $video->ppv_price_720p }}@endif">
                                    <span id="error_quality_ppv_price" style="color:red;">*Enter the 720 PPV Price </span>
                                 </div>
                                 <div class="col-sm-6 form-group" >
                                    <label class="m-0">PPV Price for 1080 Plan:</label>
                                    <input type="text" class="form-control" placeholder="PPV Price" name="ppv_price_1080p"  value="@if(!empty($video->ppv_price_1080p)){{ $video->ppv_price_1080p }}@endif">
                                    <span id="error_quality_ppv_price" style="color:red;">*Enter the 1080 PPV Price </span>
                                 </div>

                                 <!-- <div class="col-sm-6 form-group" >
                                    <label class="m-0">IOS 240 PPV Price:</label>
                                       <select  name="ios_ppv_price_240p" class="form-control" id="ios_ppv_price_240p">
                                          <option value= "" >Select IOS PPV Price: </option>
                                          @foreach($InappPurchase as $Inapp_Purchase)
                                             <option value="{{ $Inapp_Purchase->product_id }}" >{{ $Inapp_Purchase->plan_price }}</option>
                                          @endforeach
                                       </select>
                                 </div>

                                 <div class="col-sm-6 form-group" >
                                    <label class="m-0">IOS PPV Price:</label>
                                       <select  name="ios_ppv_price_360p" class="form-control" id="ios_ppv_price_360p">
                                          <option value= "" >Select 360 IOS PPV Price: </option>
                                          @foreach($InappPurchase as $Inapp_Purchase)
                                             <option value="{{ $Inapp_Purchase->product_id }}" >{{ $Inapp_Purchase->plan_price }}</option>
                                          @endforeach
                                       </select>
                                 </div> -->
                                 <div class="col-sm-6 form-group" >
                                    <label class="m-0">IOS PPV Price for 480 Plan:</label>
                                       <select  name="ios_ppv_price_480p" class="form-control" id="ios_ppv_price_480p">
                                          <option value= "" >Select 480 IOS PPV Price: </option>
                                          @foreach($InappPurchase as $Inapp_Purchase)
                                             <option value="{{ $Inapp_Purchase->product_id }}" >{{ $Inapp_Purchase->plan_price }}</option>
                                          @endforeach
                                       </select>
                                 </div>
                                 <div class="col-sm-6 form-group" >
                                    <label class="m-0">IOS PPV Price for 720 Plan:</label>
                                       <select  name="ios_ppv_price_720p" class="form-control" id="ios_ppv_price_720p">
                                          <option value= "" >Select 720 IOS PPV Price: </option>
                                          @foreach($InappPurchase as $Inapp_Purchase)
                                             <option value="{{ $Inapp_Purchase->product_id }}" >{{ $Inapp_Purchase->plan_price }}</option>
                                          @endforeach
                                       </select>
                                 </div>
                                 <div class="col-sm-6 form-group" >
                                    <label class="m-0">IOS PPV Price for 1080 Plan:</label>
                                       <select  name="ios_ppv_price_1080p" class="form-control" id="ios_ppv_price_1080p">
                                          <option value= "" >Select 1080 IOS PPV Price: </option>
                                          @foreach($InappPurchase as $Inapp_Purchase)
                                             <option value="{{ $Inapp_Purchase->product_id }}" >{{ $Inapp_Purchase->plan_price }}</option>
                                          @endforeach
                                       </select>
                                 </div>
                              </div>


                           <div class="row align-items-center">
                              <div class="col-sm-6 form-group mt-3" >
                                 <label for="">Search Tags </label>
                                    <input type="text"  class="form-control1"  id="tag-input1" name="searchtags" >
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

                              <div id="ppv_options" style="display: none;">
                                 <input type="radio" name="ppv_option" id="ppv_gobal_price" value="1">
                                 <label for="ppv_gobal_price">Set Global Price</label><br>
                                 <input type="radio" name="ppv_option" id="global_ppv_price" value="2">
                                 <label for="global_ppv_price">Get Settings Global Price</label>
                              </div>

                              <div id="price_input_container" class="col-sm-6 form-group mt-3" style="display: none;">
                                 <label for="ppv_price">Enter Global Price:</label>
                                 <input type="text" class="form-control" name="set_gobal_ppv_price" id="set_gobal_ppv_price" placeholder="Enter price">
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
                                          <label for="featured">Enable this video as Featured:</label>
                                          <input type="checkbox" @if(!empty($video->featured) && $video->featured == 1){{ 'checked="checked"' }}@endif name="featured" value="1" id="featured" />
                                       </div>
                                       <div class="clear"></div>
                                       <div>
                                          <label for="active">Enable this Video:</label>
                                          <input type="checkbox" @if(!empty($video->active) && $video->active == 1){{ 'checked="checked"' }}@elseif(!isset($video->active)){{ 'checked="checked"' }}@endif name="active" value="1" id="active" />
                                       </div>
                                       <div class="clear"></div>
                                       <div>
                                          <label for="banner">Enable this Video as Slider:</label>
                                          <input type="checkbox" @if(!empty($video->banner) && $video->banner == 1){{ 'checked="checked"' }}@elseif(!isset($video->banner)){{ 'checked="checked"' }}@endif name="banner" value="1" id="banner" />
                                       </div>
                                       <div class="clear"></div>

                                       <div>
                                          <label class="" for="banner">Enable this Today Top Video :</label>
                                          <input type="checkbox" name="today_top_video" @if(!empty($video->today_top_video) && $video->today_top_video == 1){{ 'checked="checked"' }}@elseif(!isset($video->today_top_video)){{ 'checked="checked"' }}@endif name="today_top_video" value="1" id="today_top_video" />
                                       </div>

                                       <div class="clear"></div>

                                    </div>
                                 </div>
                              </div>
                           </div>
                           <!-- </div> -->
                        </div>
                        <input type="button" name="next" class="next action-button" value="Next" id="nextppv" />
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
                                 <div id="ImagesContainer" class="gridContainer mt-3"></div>
                                 @php 
                                    $width = $compress_image_settings->width_validation_videos;
                                    $heigth = $compress_image_settings->height_validation_videos;
                                 @endphp
                                 @if($width !== null && $heigth !== null)
                                    <p class="p1">{{ ("Video Thumbnail (".''.$width.' x '.$heigth.'px)')}}:</p> 
                                 @else
                                    <p class="p1">{{ "Video Thumbnail ( 720X1280px )"}}:</p> 
                                 @endif
                                  <input type="file" name="image" id="image" accept="image/png, image/webp, image/jpeg">
                                 <span>
                                    <p id="video_image_error_msg" style="color:red !important; display:none;">
                                       * Please upload an image with the correct dimensions.
                                    </p>
                                 </span>
                                 @if(!empty($video->image) && ($video->image) != null)
                                    <img src="{{ URL::to('/') . '/public/uploads/images/' . $video->image }}" class="video-img w-100" />
                                 @endif
                              </div>

                              <div class="col-sm-6 form-group">
                                <div id="ajaxImagesContainer" class="gridContainer mt-3"></div>
                                @php 
                                    $player_width = $compress_image_settings->width_validation_player_img;
                                    $player_heigth = $compress_image_settings->height_validation_player_img;
                                 @endphp
                                 @if($player_width !== null && $player_heigth !== null)
                                    <p class="p1">{{ ("Player Thumbnail (".''.$player_width.' x '.$player_heigth.'px)')}}:</p> 
                                 @else
                                    <p class="p1">{{ "Player Thumbnail ( 1280X720px )"}}:</p> 
                                 @endif
                                 <input type="file" accept="image/png, image/webp, image/jpeg" name="player_image" id="player_image" >
                                 <span>
                                    <p id="player_image_error_msg" style="color:red !important; display:none;">
                                       * Please upload an image with the correct dimensions.
                                    </p>
                                 </span>
                                 @if(!empty($video->player_image))
                                 <img src="{{ URL::to('/') . '/public/uploads/images/' . $video->player_image }}" class="video-img w-100" />
                                 @endif
                              </div>
                           </div>                              

                           <div class="row">
                              <div class="col-sm-6 form-group">
                                <div id="TVImagesContainer" class="gridContainer mt-3"></div>
                                        {{-- Video TV Thumbnail --}}
                                 <label class="mb-1">  Video TV Thumbnail  </label><br>
                                 <input type="file" name="video_tv_image" id="video_tv_image" >
                                 {{-- <span><p id="tv_image_image_error_msg" style="color:red;" >* Please upload an image with 1920  x 1080  pixels dimension or 16:9 ratio </p></span> --}}
                                 @if(!empty($video->video_tv_image))
                                    <div class="col-sm-8 p-0">
                                       <img src="{{ URL::to('/') . '/public/uploads/images/' .$video->video_tv_image }}" class="video-img w-100 mt-1" />
                                    </div>
                                 @endif
                              </div>
                           </div>

                                          {{-- Video Title Thumbnail --}}

                           <div class="row">
                              <div class="col-sm-6 form-group">
                                 <label class="mb-1"> Video Title Thumbnail </label><br>
                                 <input type="file" name="video_title_image" id="video_title_image" >
                                 @if(!empty($video->video_title_image))
                                    <img src="{{ URL::to('/') . '/public/uploads/images/' . $video->video_title_image }}" class="video-img w-100" />
                                 @endif
                              </div>

                              <div class="col-sm-6 form-group">
                                 <label class="mb-1">Enable Video Title Thumbnail</label><br>
                                 <div class="mt-1">
                                    <label class="switch">
                                       <input name="enable_video_title_image" class="" id="enable_video_title_image" type="checkbox" >
                                       <span class="slider round"></span>
                                    </label>
                                 </div>
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
               <input type="button" id="next_input" name="next" class="next action-button update_upload_img" value="Next" />
               <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
               </fieldset>

                              {{-- ADS Management --}}
                  @include('admin.videos.fileupload_ads_fieldset'); 

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

$(document).ready(function() {
   $('#error_ppv_price').hide();

        // Function to check the price input and update button states
        function checkPriceInput() {
            var priceInput = $('#price').val().trim();
            var isGlobalPPVChecked = $('#global_ppv').is(':checked');

            if (!priceInput && !isGlobalPPVChecked) {
                $('#error_ppv_price').show();
                $('#nextppv').attr('disabled', 'disabled');
                $('#submit_button').attr('disabled', 'disabled');
            } else {
                $('#error_ppv_price').hide();
                $('#nextppv').removeAttr('disabled');
                $('#submit_button').removeAttr('disabled');
            }
        }

        // Event handler for global PPV checkbox change
        $('#global_ppv').change(function() {
            var isChecked = $(this).is(':checked');
            if (isChecked) {
                $('#error_ppv_price').hide();
                $('#nextppv').removeAttr('disabled');
                $('#submit_button').removeAttr('disabled');
                $('#price').off('focusout keyup change', checkPriceInput); // Disable price input validation
            } else {
                checkPriceInput();
                $('#price').on('focusout keyup change', checkPriceInput); // Enable price input validation
            }
        });

        // Event handler for access change
        $('#access').change(function() {

            
         var enable_ppv_plans = '<?= @$theme_settings->enable_ppv_plans ?>';
         var transcoding_access = '<?= @$settings->transcoding_access ?>';
            if(enable_ppv_plans == 1 && transcoding_access == 1){
               $('#submit_button').removeAttr('disabled');
            }else{
               if ($(this).val() == 'ppv') {
                  $('#price').on('focusout keyup change', checkPriceInput);
                  $('#global_ppv').on('change', checkPriceInput);
                  $('#msform').on('submit', function(event) {
                     var priceInput = $('#price').val().trim();
                     var isGlobalPPVChecked = $('#global_ppv').is(':checked');

                     if (!priceInput && !isGlobalPPVChecked) {
                           event.preventDefault(); // Prevent form submission
                           $('#error_ppv_price').show();
                           $('#nextppv').attr('disabled', 'disabled');
                           $('#submit_button').attr('disabled', 'disabled');
                     } else {
                           $('#error_ppv_price').hide();
                           $('#nextppv').removeAttr('disabled');
                           $('#submit_button').removeAttr('disabled');
                     }
                  });
               } else {
                  $('#price').off('focusout keyup change', checkPriceInput);
                  $('#global_ppv').off('change', checkPriceInput);
                  $('#msform').off('submit');
                  $('#error_ppv_price').hide();
                  $('#nextppv').removeAttr('disabled');
                  $('#submit_button').removeAttr('disabled');
               }
            }
        });

        // Event handler for the "Next" button click
        $('#nextppv').click(function(event) {
            event.preventDefault(); // Prevent form submission
            var priceInput = $('#price').val().trim();
            var isGlobalPPVChecked = $('#global_ppv').is(':checked');

            if (!priceInput && !isGlobalPPVChecked) {
                $('#error_ppv_price').show();
                $(this).attr('disabled', 'disabled');
                $('#submit_button').attr('disabled', 'disabled');
            } else {
                $('#error_ppv_price').hide();
                $(this).removeAttr('disabled');
                $('#submit_button').removeAttr('disabled');
            }
        });

        $('#access').trigger('change');
    });

document.addEventListener('DOMContentLoaded', function () {
        var globalPpvCheckbox = document.getElementById('global_ppv');
        var ppvOptionsDiv = document.getElementById('ppv_options');
        var priceInputContainer = document.getElementById('price_input_container');
        var ppvGlobalPriceRadio = document.getElementById('ppv_gobal_price');

        // Show/hide the radio buttons based on the initial state of the checkbox
        ppvOptionsDiv.style.display = globalPpvCheckbox.checked ? 'block' : 'none';

        // Add an event listener to the checkbox to show/hide the radio buttons
        globalPpvCheckbox.addEventListener('change', function () {
            ppvOptionsDiv.style.display = this.checked ? 'block' : 'none';
            // Hide the price input when checkbox is unchecked
            if (!this.checked) {
                priceInputContainer.style.display = 'none';
            }
        });

        // Add an event listener to the "Set Global Price" radio button
        ppvGlobalPriceRadio.addEventListener('change', function () {
            priceInputContainer.style.display = this.checked ? 'block' : 'none';
        });

        // Hide the price input container if "Add Global Price" is selected
        var globalPpvPriceRadio = document.getElementById('global_ppv_price');
        globalPpvPriceRadio.addEventListener('change', function () {
            if (this.checked) {
                priceInputContainer.style.display = 'none';
            }
        });
    });

    
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

// $(document).ready(function(){

//       $('#image_error_msg').hide();
//       $('#player_image_error_msg,#tv_image_image_error_msg').hide();

//       $('#slug_error').hide();
//       $('#slug_validate').on('keyup blur keypress mouseover', function(e) {

//          var title = $('#title').val();
//          var slug_name=title.replace(/ /g,"_");

//          if($('#slug').val().length == 0 ){
//             var slug = $('#slug').val(slug_name);
//          }else{
//             var slug = $('#slug').val();
//          }
      
//          $.ajax({
//          type: "POST", 
//          dataType: "json", 
//          url: "{{ url('admin/video_slug_validate') }}",
//                data: {
//                   _token  : "{{csrf_token()}}" ,
//                   slug : slug,
//                   type : "create",
//                   video_id: null,
//          },
//          success: function(data) {
//                console.log(data.message);
//                if(data.message == "true"){
                  
//                   $('#next2').attr('disabled','disabled');
//                   $('#slug_error').show();
//                }
//                else if(data.message = "false"){
//                   $('#next2').removeAttr('disabled');
//                   $('#slug_error').hide();

//                }
//             },
//          });
//       })
// });

  
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
      $('#free_duration').mask("00:00:00");
      $("#video_js_mid_advertisement_sequence_time").mask("00:00:00");

      $("#andriod_mid_sequence_time").mask("00:00:00");
      $("#ios_mid_sequence_time").mask("00:00:00");
      $("#tv_mid_sequence_time").mask("00:00:00");
      $("#samsung_mid_sequence_time").mask("00:00:00");
      $("#lg_mid_sequence_time").mask("00:00:00");
      $("#roku_mid_sequence_time").mask("00:00:00");
   });

   $(document).ready(function() {

      $('.ads_devices').select2();

      $('.website-ads-button, .Andriod-ads-button, .IOS-ads-button, .TV-ads-button, .Roku-ads-button, .LG-ads-button, .Samsung-ads-button').hide();

      $('.ads_devices').on('change', function() {
         var selectedValues = $(this).val();
         
         $('.website-ads-button, .Andriod-ads-button, .IOS-ads-button, .TV-ads-button, .Roku-ads-button, .LG-ads-button, .Samsung-ads-button').hide();
         
         selectedValues.forEach(function(value) {
               switch(value) {
                  case 'website':
                     $('.website-ads-button').show();
                     break;
                  case 'android':
                     $('.Andriod-ads-button').show();
                     break;
                  case 'IOS':
                     $('.IOS-ads-button').show();
                     break;
                  case 'TV':
                     $('.TV-ads-button').show();
                     break;
                  case 'roku':
                     $('.Roku-ads-button').show();
                     break;
                  case 'lg':
                     $('.LG-ads-button').show();
                     break;
                  case 'samsung':
                     $('.Samsung-ads-button').show();
                     break;
                  default:
                     break;
               }
         });
      });
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
       $('#quality_ppv_price').hide();
       $('#global_ppv_status').hide();
       
   		$("#access").change(function(){

            var enable_ppv_plans = '<?= @$theme_settings->enable_ppv_plans ?>';
            var transcoding_access = '<?= @$settings->transcoding_access ?>';

            if(transcoding_access == 1 && enable_ppv_plans == 1){
               if($(this).val() == 'ppv'){
                  $('#quality_ppv_price').show();
                  $('#global_ppv_status').show();
      
               }else{
                  $('#quality_ppv_price').hide();		
                  $('#global_ppv_status').hide();				
      
               }
            }else{
               if($(this).val() == 'ppv'){
   				$('#ppv_price').show();
   				$('#global_ppv_status').show();
   
               }else{
                  $('#ppv_price').hide();		
                  $('#global_ppv_status').hide();				
      
               }
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
        var MAX_RETRIES = 3;
        var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

        function handleError(e, t) {
        if (e.previewElement) {
            e.previewElement.classList.add("dz-error");
            if (typeof t !== "string" && t.error) {
                t = t.error;
            }
            var r = e.previewElement.querySelectorAll("[data-dz-errormessage]");
            r.forEach(function(element) {
                element.textContent = t;
            });
        }
    }

    var myDropzone = new Dropzone(".dropzone", {
    parallelUploads: 2,
    maxFilesize: 150000000, // 150MB
    acceptedFiles: "video/mp4,video/x-m4v,video/x-matroska,video/mkv",
    previewTemplate: document.getElementById('template').innerHTML,
    init: function() {
        this.on("sending", function(file, xhr, formData) {
         
            formData.append("UploadlibraryID", $('#UploadlibraryID').val());
            formData.append("FlussonicUploadlibraryID", $('#FlussonicUploadlibraryID').val());
            formData.append("_token", CSRF_TOKEN);

            if (!file.retryCount) {
                file.retryCount = 0;
            }
            if (!file.userCanceled) {
                file.userCanceled = false;
            }

            // Add cancel button event listener
            file.previewElement.querySelector('.dz-cancel').addEventListener('click', function () {
                console.log("Cancel button clicked for file: " + file.name);
                sendErrorLog(file.name, "Cancel button clicked for file");
                file.userCanceled = true; // Mark the file as user-canceled
                xhr.abort();
                alert("Upload canceled for file: " + file.name);
                handleError(file, "Upload canceled by user.");
                file.previewElement.querySelector('.dz-cancel').innerHTML = " "; 

                // Mark file as completed in Dropzone
                file.status = Dropzone.CANCELED;

                // Trigger queue processing
                myDropzone.processQueue();
            });
        });

        this.on("uploadprogress", function (file, progress) {
            var progressElement = file.previewElement.querySelector('.dz-upload-percentage');
            progressElement.textContent = Math.round(progress) + '%';
        });

        this.on("success", function (file, response) {
            // console.log(file);
            // console.log(response);

            if (response.success == 2) {
                sendErrorLog(file.name, "File not uploaded!");
                alert("File not uploaded!");
            } else if (response.error == 3) {
                console.log(response.error);
                sendErrorLog(file.name, "File not uploaded. Choose Library!");
                alert("File not uploaded. Choose Library!");
            } else if (response.success == 'video_upload_limit_exist') {
                Swal.fire("You have reached your video upload limit for this month.");
                sendErrorLog(file.name, "You have reached your video upload limit for this month.");
                $('#Next').hide();
            } else {
               sendErrorLog(file.name, response);
                $('#Next').show();
                $('#video_id').val(response.video_id);
                $('#title').val(response.video_title);
                file.previewElement.querySelector('.dz-cancel').innerHTML = " "; 
            }
        });

        this.on("error", function (file, response) {
            if (!file.userCanceled && file.retryCount < MAX_RETRIES) {
                file.retryCount++;
                setTimeout(function () {
                    myDropzone.removeFile(file);
                    myDropzone.addFile(file);
                }, 1000);
            } else if (file.userCanceled) {
                console.log("File upload canceled by user: " + file.name);
                sendErrorLog(file.name, "File upload canceled by user");
            } else {
                alert("Failed to upload the file after " + MAX_RETRIES + " attempts.");
                sendErrorLog(file.name, "Failed to upload the file after " + MAX_RETRIES + " attempts.");
                file.previewElement.querySelector('.dz-cancel').innerHTML = " "; 
            }
            myDropzone.processQueue(); 
        });

        this.on("queuecomplete", function () {
            const files = this.files;
            files.forEach(function (file) {
               if (file.status === Dropzone.SUCCESS) {
                     sendErrorLog(file.name, "File processed successfully.");
               } else if (file.status === Dropzone.ERROR) {
                  if (file.xhr) {
                     const serverResponse = file.xhr.response;
                     sendErrorLog(file.name, `Error: ${serverResponse}`);
                  } else {
                     sendErrorLog(file.name, "Unknown error occurred.");
                  }
               }
            });
        });

        function sendErrorLog(filename, errorMessage) {
            $.post("<?php echo URL::to('/admin/UploadErrorLog'); ?>", {
                _token: CSRF_TOKEN,
                filename: filename,
                socure_type: "Video",
                error: errorMessage
            }, function(response) {
               //  console.log("Error log submitted:", response);
            }).fail(function(xhr) {
               //  console.error("Failed to log error:", xhr.responseText);
            });
        }

    }
});
         
   //   Dropzone.autoDiscover = false;
   //   var myDropzone = new Dropzone(".dropzone",{ 
   //     //   maxFilesize: 900,  // 3 mb
   //       parallelUploads: 10,
   //       maxFilesize: 150000000,
   //       acceptedFiles: "video/mp4,video/x-m4v,video/*",
   //   });
   //   myDropzone.on("sending", function(file, xhr, formData) {
   //      formData.append("UploadlibraryID", $('#UploadlibraryID').val());
   //      formData.append("_token", CSRF_TOKEN);
   // //      checkUploadSpeed( 10, function ( speed, average ) {
   // //      document.getElementById( 'speed' ).textContent = 'speed: ' + speed + 'kbs';
   // //      document.getElementById( 'average' ).textContent = 'average: ' + average + 'kbs';
   // //  } );
   //     // console.log(value)
   //     this.on("success", function(file, value) {
   //       console.log(value.video_title);
   //       if(value.success == 2){
   //          swal("File not uploaded !");   
   //          location.reload();
   //       }if(value.error == 3){
   //       console.log(value.error);
   //          alert("File not uploaded Choose Library!");   
   //          location.reload();
   //       }else{
   //          $('#Next').show();
   //          $('#video_id').val(value.video_id);
   //          $('#title').val(value.video_title);
   //       }
   //       });
   
   //   }); 
   //   function checkUploadSpeed( iterations, update ) {
   //      var average = 0,
   //          index = 0,
   //          timer = window.setInterval( check, 5000 ); //check every 5 seconds
   //      check();

   //      function check() {
   //          var xhr = new XMLHttpRequest(),
   //              url = '?cache=' + Math.floor( Math.random() * 10000 ), //random number prevents url caching
   //              data = getRandomString( 1 ), //1 meg POST size handled by all servers
   //              startTime,
   //              speed = 0;
   //          xhr.onreadystatechange = function ( event ) {
   //              if( xhr.readyState == 4 ) {
   //                  speed = Math.round( 1024 / ( ( new Date() - startTime ) / 1000 ) );
   //                  average == 0 
   //                      ? average = speed 
   //                      : average = Math.round( ( average + speed ) / 2 );
   //                  update( speed, average );
   //                  index++;
   //                  if( index == iterations ) {
   //                      window.clearInterval( timer );
   //                  };
   //              };
   //          };
   //          xhr.open( 'POST', url, true );
   //          startTime = new Date();
   //          xhr.send( data );
   //      };

   //      function getRandomString( sizeInMb ) {
   //          var chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789~!@#$%^&*()_+`-=[]\{}|;':,./<>?", //random data prevents gzip effect
   //              iterations = sizeInMb * 1024 * 1024, //get byte count
   //              result = '';
   //          for( var index = 0; index <div iterations; index++ ) {
   //              result += chars.charAt( Math.floor( Math.random() * chars.length ) );
   //          };     
   //          return result;
   //      };
   //  };
    

   
   
   $('#Next').click(function(){
   $('#video_upload').hide();
   $('#video_mp4').hide();
   $('#embedvideo').hide();
   $('#bunnycdnvideo').hide();
   $('#flussonicstoragevideo').hide();
   $('#optionradio').hide();
   $('.content_videopage').hide();
   $('#content_videopage').hide();
   
   
   $('#Next').hide();
   $('#video_details').show();

   $.ajax({
        url: '{{ URL::to('admin/videos/extractedimage') }}',
        type: "post",
        data: {
            _token: '{{ csrf_token() }}',
            video_id: $('#video_id').val()
        },
        success: function(value) {
            // console.log(value.ExtractedImage.length);

            if (value && value.ExtractedImage.length > 0) {
                $('#ajaxImagesContainer').empty();
                $('#ImagesContainer').empty();
                var ExtractedImage = value.ExtractedImage;
                var previouslySelectedElement = null;
                var previouslySelectedVideoImag = null;
                var previouslySelectedTVImage = null;

                ExtractedImage.forEach(function(Image, index) {
                    var imgElement = $('<div class="gridItem"><img src="' + Image.image_path + '" class="ajax-image m-1 w-100 h-100" /></div>');
                    var ImagesContainer = $('<div class="gridItem"><img src="' + Image.image_path + '" class="video-image m-1 w-100 h-100" /></div>');
                    var TVImagesContainer = $('<div class="gridItem"><img src="' + Image.image_path + '" class="tv-video-image m-1 w-100 h-100" /></div>');

                    imgElement.click(function() {
                        $('.ajax-image').css('border', 'none');
                        // Remove border from the previously selected image
                        if (previouslySelectedElement) {
                           previouslySelectedElement.css('border', 'none');
                        }
                        imgElement.css('border', '2px solid red');
                        var clickedImageUrl = Image.image_path;

                        var SelectedImageUrl = Image.image_original_name;
                        // console.log('SelectedImageUrl Image URL:', SelectedImageUrl);
                        previouslySelectedElement = $(this);

                        $('#selectedImageUrlInput').val(SelectedImageUrl);
                    });
                                    // Default selection for the first image
                     if (index === 0) {
                           imgElement.click();
                     }
                    $('#ajaxImagesContainer').append(imgElement);

                    ImagesContainer.click(function() {
                        $('.video-image').css('border', 'none');
                        if (previouslySelectedVideoImag) {
                           previouslySelectedVideoImag.css('border', 'none');
                        }
                        ImagesContainer.css('border', '2px solid red');
                        
                        var clickedImageUrl = Image.image_path;

                        var VideoImageUrl = Image.image_original_name;
                        // console.log('SelectedImageUrl Image URL:', SelectedImageUrl);
                        previouslySelectedVideoImag = $(this);

                        $('#videoImageUrlInput').val(VideoImageUrl);
                    });

                    if (index === 0) {
                     ImagesContainer.click();
                     }

                    $('#ImagesContainer').append(ImagesContainer);

                    TVImagesContainer.click(function() {
                        $('.tv-video-image').css('border', 'none');
                        if (previouslySelectedTVImage) {
                           previouslySelectedTVImage.css('border', 'none');
                        }
                        TVImagesContainer.css('border', '2px solid red');
                        
                        var clickedImageUrl = Image.image_path;

                        var TVImageUrl = Image.image_original_name;
                        previouslySelectedTVImage = $(this);

                        $('#SelectedTVImageUrlInput').val(TVImageUrl);
                  });

                  if (index === 0) {
                     TVImagesContainer.click();
                  }

                  $('#TVImagesContainer').append(TVImagesContainer);


                });
            } else {
                     var SelectedImageUrl = '';

                     $('#selectedImageUrlInput').val(SelectedImageUrl);
                    $('#videoImageUrlInput').val(SelectedImageUrl);
                    $('#SelectedTVImageUrlInput').val(SelectedImageUrl);
               //  $('#ajaxImagesContainer').html('<p>No images available.</p>');
            }
        },
        error: function(error) {

            var SelectedImageUrl = '';

            $('#selectedImageUrlInput').val(SelectedImageUrl);
            $('#videoImageUrlInput').val(SelectedImageUrl);
            $('#SelectedTVImageUrlInput').val(SelectedImageUrl);
            console.error(error);
        }
    });
   
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
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
   // document.getElementById('image').addEventListener('change', function() {
   //     var file = this.files[0];
   //     if (file) {
   //         var img = new Image();
   //         img.onload = function() {
   //             var width = img.width;
   //             var height = img.height;
   //             console.log(width);
   //             console.log(height);
               
   //             var validWidth = {{ $compress_image_settings->width_validation_videos }};
   //             var validHeight = {{ $compress_image_settings->height_validation_videos }};
   //             console.log(validWidth);
   //             console.log(validHeight);

   //             if (width > validWidth || height > validHeight) {
   //                 document.getElementById('video_image_error_msg').style.display = 'block';
   //                 $('#next_input').prop('disabled', true);
   //                 document.getElementById('video_image_error_msg').innerText = 
   //                     `* Please upload an image with the correct dimensions (${validWidth}x${validHeight}px).`;
   //             } else {
   //                 document.getElementById('video_image_error_msg').style.display = 'none';
   //                 $('#next_input').prop('disabled', false);
   //             }
   //         };
   //         img.src = URL.createObjectURL(file);
   //     }
   // });

   // document.getElementById('player_image').addEventListener('change', function() {
   //     var file = this.files[0];
   //     if (file) {
   //         var img = new Image();
   //         img.onload = function() {
   //             var width = img.width;
   //             var height = img.height;
   //             console.log(width);
   //             console.log(height);
               
   //             var validWidth = {{ $compress_image_settings->width_validation_player_img }};
   //             var validHeight = {{ $compress_image_settings->height_validation_player_img }};
   //             console.log(validWidth);
   //             console.log(validHeight);
               
   //             if (width > validWidth || height > validHeight) {
   //                 document.getElementById('player_image_error_msg').style.display = 'block';
   //                 $('#next_input').prop('disabled', true);
   //                 document.getElementById('player_image_error_msg').innerText = 
   //                     `* Please upload an image with the correct dimensions (${validWidth}x${validHeight}px).`;
   //             } else {
   //                 document.getElementById('player_image_error_msg').style.display = 'none';
   //                 $('#next_input').prop('disabled', false);
   //             }
   //         };
   //         img.src = URL.createObjectURL(file);
   //     }
   // });
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
            var validWidth = {{ $compress_image_settings->width_validation_videos ?: 720 }};
            var validHeight = {{ $compress_image_settings->height_validation_videos ?: 1280 }};
            console.log('validWidth ' + validWidth);
            console.log('uploading img width: ' + validHeight);

            if (width !== validWidth || height !== validHeight) {
                     document.getElementById('video_image_error_msg').style.display = 'block';
                     $('#next_input').prop('disabled', true);
                     document.getElementById('video_image_error_msg').innerText = 
                        `* Please upload an image with the correct dimensions (${validWidth}x${validHeight}px).`;
                  } else {
                     document.getElementById('video_image_error_msg').style.display = 'none';
                     $('#next_input').prop('disabled', false);
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
               console.log('player width' + valid_player_Width );
      
               if (width !== valid_player_Width || height !== valid_player_Height) {
                     document.getElementById('player_image_error_msg').style.display = 'block';
                     $('#next_input').prop('disabled', true);
                     document.getElementById('player_image_error_msg').innerText = 
                        `* Please upload an image with the correct dimensions (${valid_player_Width}x${valid_player_Height}px).`;
               } else {
                     document.getElementById('player_image_error_msg').style.display = 'none';
                     $('#next_input').prop('disabled', false);
               }
            }
         });
      });
   
</script>

@include('admin.videos.search_tag'); 

@include('admin.videos.Ads_videos'); 

@stop
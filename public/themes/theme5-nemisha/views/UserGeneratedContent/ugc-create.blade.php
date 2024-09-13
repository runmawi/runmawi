@php
    include( public_path('themes/theme5-nemisha/views/header.php'));
@endphp

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
      margin: 10px 100px; 
      border-radius: 10px;
   }
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

   .ugc-icon{
    width: 100px;
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

   @media (max-width:500px) {
      .content-page{
          margin: 10px;
          border-radius: 10px;
          padding: 10px;
      }
   }

   .ugc-buttons {
      background-color: #fff;
      border-radius: 10px;
      padding: 10px;
   }

</style>
<div id=" content_videopage" class="content-page">
   <div class="container-fluid p-0" id="content_videopage">
      <div class="admin-section-title">
         <div class="">
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
               <div class="col-md-12 ">
                  <!-- M3u8 Video --> 
                  <div id="m3u8_url" class="ugc-buttons" style="">
                     <div class="new-audio-file">
                        <label for="embed_code"><label>m3u8 URL:</label></label>
                        <input type="text" class="video-form-control" style="border-radius: 7px;" name="m3u8_video_url" id="m3u8_video_url" value="" />
                     </div>
                     <div class="new-audio-file mt-3">
                        <button class="btn btn-primary"  id="submit_m3u8">Submit</button>
                     </div>
                  </div>
                  <!-- Embedded Video -->        
                  <div id="embedvideo" class="ugc-buttons">
                     <div class="new-audio-file">
                        <label for="embed_code">Embed URL:</label>
                        <p class="p1">Example URL Format : ( https://www.youtube.com/embed/*xxxxxxxxx*/) ) </p>
                        <input type="text" class="video-form-control" name="embed_code" id="embed_code" value="" />
                     </div>
                     <div class="new-audio-file mt-3">
                        <button class="btn btn-primary"  id="submit_embed">Submit</button>
                     </div>
                  </div>
                  
                  <!-- MP4 Video -->        
                  <div id="video_mp4" class="ugc-buttons" >
                     <div class="new-audio-file" >
                        <label for="mp4_url"><label>Mp4 File URL:</label></label>
                        <input type="text" class="video-form-control" name="mp4_url" id="mp4_url" value="" />
                     </div>
                     <div class="new-audio-file mt-3">
                        <button class="btn btn-primary"  id="submit_mp4">Submit</button>
                     </div>
                  </div>
                  <!-- Video upload -->   
                  <div id="video_upload" >
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
                           <h3 class="card-title upload-ui text-black pt-5 font-weight-bold">Upload Your Own Content</h3>
                           <!-- Dropzone --> 
                           <form action="{{ $post_dropzone_url }}" method="post" class="dropzone "></form>
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
                  <div class="text-center" style="margin: 20px;">
                     <input type="button" id="Next" value='Proceed to Next Step' class='btn btn-primary'>
                  </div>
                  <input type="hidden" id="embed_url" value="<?php echo URL::to('ugc/embededcode');?>">
                  <input type="hidden" id="mp4url" value="<?php echo URL::to('ugc/mp4url');?>">
                  <input type="hidden" id="m3u8url" value="<?php echo URL::to('ugc/m3u8url');?>">
               </div>

            </div>

               <div class="col-md-12 text-right" style="background-color: #fff; padding:5px 10px; marging:10px; border-radius:10px; " >
                  <div id="optionradio"  >
                     <input type="radio" class="text-black" value="videoupload" id="videoupload" name="videofile" checked="checked"> Video Upload &nbsp;&nbsp;&nbsp;
                     <input type="radio" class="text-black" value="m3u8"  id="m3u8" name="videofile"> m3u8 Url &nbsp;&nbsp;&nbsp;
                     <input type="radio" class="text-black" value="videomp4"  id="videomp4" name="videofile"> Video mp4 &nbsp;&nbsp;&nbsp;
                     <input type="radio" class="text-black" value="embed_video"  id="embed_video" name="videofile"> Embed Code   
                  {{-- @if(@$theme_settings->enable_bunny_cdn == 1)
                     <input type="radio" class="text-black" value="bunny_cdn_video"  id="bunny_cdn_video" name="videofile"> Bunny CDN Videos              
                  @endif --}}
                  </div>
               </div>
         </div>
          
      </div>
      {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
      <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script> --}}


      {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
      <script>

         var enable_bunny_cdn = '<?= @$theme_settings->enable_bunny_cdn ?>';
         if(enable_bunny_cdn == 1){
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

         // $(document).ready(function() {
         //    $('#bunny_cdn_linked_video').select2();
         // });

         $(document).ready(function(){

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
         
         
         $('#videoupload').click(function(){
         	$('#video_upload').show();
         	$('#video_mp4').hide();
         	$('#embedvideo').hide();
         	$('#m3u8_url').hide();
         	$('#bunnycdnvideo').hide();      
         })
         $('#videomp4').click(function(){
         	$('#video_upload').hide();
         	$('#video_mp4').show();
         	$('#embedvideo').hide();
         	$('#m3u8_url').hide();
         	$('#bunnycdnvideo').hide();
         })
         $('#embed_video').click(function(){
         	$('#video_upload').hide();
         	$('#video_mp4').hide();
         	$('#embedvideo').show();
         	$('#m3u8_url').hide();
         	$('#bunnycdnvideo').hide();
         })
         $('#m3u8').click(function(){
         	$('#video_upload').hide();
         	$('#video_mp4').hide();
         	$('#embedvideo').hide();
         	$('#m3u8_url').show();
         	$('#bunnycdnvideo').hide();
         })

         $('#bunny_cdn_video').click(function(){

            $('#video_upload').hide();
            $('#video_mp4').hide();
            $('#embedvideo').hide();
            $('#m3u8_url').hide();
            $('#bunnycdnvideo').show();
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

   $(document).ready(function(){
       var url =$('#mp4url').val();
       $('#submit_mp4').click(function(){
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

   });
   	
</script>

<div id="video_details">
   <style>
      .p1{
      font-size: 12px;
      color: black !important;
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
      
      <div class="container-fluid" >
          
         <div class="iq-card " style="padding:40px;">
         <div class="row justify-content-center">
            <div class="col-11 col-sm-10 col-md-10 col-lg-12 col-xl-12 text-center mx-auto p-0 mb-2">
               <div class="px-0 pb-0 mb-3 col-md-12">
                  <form method="POST" action="{{ $post_route }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data" id="msform">
                    
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
                                 <input type="text" class="video-form-control" style="border-radius: 7px;" name="title" id="title" placeholder="Title" value="">
                              </div>

                              <div class="col-sm-6 form-group" >
                                 <label class="m-0">
                                    Video Slug 
                                    <a class="" data-toggle="tooltip" data-placement="top" title="Please enter the URL Slug" data-original-title="this is the tooltip" href="#">
                                       <i class="las la-exclamation-circle"></i>
                                    </a>:
                                  </label>

                                 <input type="text"   class="video-form-control" style="border-radius: 7px;" name="slug" id="slug" placeholder="Video Slug" value="@if(!empty($video->slug)){{ $video->slug }}@endif">
                                 <!-- <span><p id="slug_error" style="color:red;">This slug already used </p></span> -->
                              </div>

                           </div>
                         
                           <div class="row">
                              <div class="col-lg-12 form-group">
                                 <label class="m-0">Video Description:</label>
                                 <textarea  rows="5" class="form-control mt-2" name="description" id="summary-ckeditor"
                                    placeholder="Description">@if(!empty($video->description)){{ strip_tags($video->description) }}@endif</textarea>
                              </div>
                          
                           </div>
                       


                            <div class="row">
                              <div class="col-sm-6 form-group">
                                 {{-- <div id="ImagesContainer" class="gridContainer mt-3"></div> --}}
                                 <label class="mb-1">Video Thumbnail <span>(9:16 Ratio or 1080X1920px)</span></label><br>
                                 <input type="file" name="image" id="image" >
                                 <span><p id="image_error_msg" style="color:red;" >* Please upload an image with 1080 x 1920 pixels dimension or ratio 9:16 </p></span>
                                 @if(!empty($video->image) && ($video->image) != null)
                                    <img src="{{ URL::to('/') . '/public/uploads/images/' . $video->image }}" class="video-img w-100" />
                                 @endif
                              </div>
         
                           </div>      

                           <div class="row mt-5">
                              <div class="panel panel-primary" data-collapsed="0">
                                 <div class="panel-heading col-sm-12">
                                    <div class="panel-title" style="color: #000;"> <label class="m-0"><h3 class="fs-title">Subtitles (WebVTT (.vtt)) :</h3></label>
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
       
                           @if(isset($video->id))
                           <input type="hidden" id="id" name="id" value="{{ $video->id }}" />
                           @endif
   
                           <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                           <input type="hidden" id="video_id" name="video_id" value="">
                           <input type="hidden" id="selectedImageUrlInput" name="selected_image_url" value="">
                           <input type="hidden" id="videoImageUrlInput" name="video_image_url" value="">
                           <input type="hidden" id="SelectedTVImageUrlInput" name="selected_tv_image_url" value="">

                        </div>

                        <button type="submit" class="btn btn-primary" value="{{ $button_text }}">{{ $button_text }}</button>
                        {{-- <input type="button" name="next" class="next action-button" id="next2" value="Next" /> --}}
                     </fieldset>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
</div>
</div>

@php
include (public_path('themes/theme5-nemisha/views/footer.blade.php'))
@endphp


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
    padding: 30px;
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

.fit-image {
    width: 100%;
    object-fit: cover
}
#msform input[type="file"]{border: 0; width: 100%;}

.video-form-control{
        width:100%;
        background-color: #c9c8c888 ;
        border:none;
        padding: 5px 10px;
        border-radius: 7px;
    }

</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

   $(".submit").click(function(){
   return false;
   })

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

      $('#image_error_msg').hide();
      $('#player_image_error_msg,#tv_image_image_error_msg').hide();

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
         url: "{{ url('ugc/video_slug_validate') }}",
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

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
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
            parallelUploads: 10,
            maxFilesize: 150000000, // 150MB
            acceptedFiles: "video/mp4,video/x-m4v,video/*",
            previewTemplate: document.getElementById('template').innerHTML,
            init: function() {
                this.on("sending", function(file, xhr, formData) {
                    formData.append("UploadlibraryID", $('#UploadlibraryID').val());
                    formData.append("_token", CSRF_TOKEN);

                    // Initialize retry counter and canceled flag if they don't exist
                    if (!file.retryCount) {
                        file.retryCount = 0;
                    }
                    if (!file.userCanceled) {
                        file.userCanceled = false;
                    }

                    // Add cancel button event listener
                    file.previewElement.querySelector('.dz-cancel').addEventListener('click', function() {
                        console.log("Cancel button clicked for file: " + file.name); // Log for debugging
                        file.userCanceled = true; // Mark the file as user-canceled
                        xhr.abort();
                        file.previewElement.querySelector('.dz-cancel').innerHTML = " ";
                        // myDropzone.removeFile(file);
                        alert("Upload canceled for file: " + file.name);
                        handleError(file, "Upload canceled by user.");
                    });
                });

                this.on("uploadprogress", function(file, progress) {
                    var progressElement = file.previewElement.querySelector('.dz-upload-percentage');
                    progressElement.textContent = Math.round(progress) + '%';
                });

                this.on("success", function(file, response) {
                    console.log(file);
                    console.log(response);
                   
                    if (response.success == 2) {
                        swal("File not uploaded!");   
                    } else if (response.error == 3) {
                        console.log(response.error);
                        alert("File not uploaded. Choose Library!");   
                    }
                    else if (response.success == 'video_upload_limit_exist') { 
                        myDropzone.removeFile(file);  
                        Swal.fire("You have reached your video upload limit for this month.");
                        $('#Next').hide();
                     }
                     else {
                        $('#Next').show();
                        $('#video_id').val(response.video_id);
                        $('#title').val(response.video_title);
                        file.previewElement.querySelector('.dz-cancel').innerHTML = " ";
                    }
                });

                this.on("error", function(file, response) {
                    if (!file.userCanceled && file.retryCount < MAX_RETRIES) {
                        file.retryCount++;
                        setTimeout(function() {
                            myDropzone.removeFile(file);  
                            myDropzone.addFile(file);     
                        }, 1000); 
                    } else if (file.userCanceled) {
                        console.log("File upload canceled by user: " + file.name);
                    } else {
                        alert("Failed to upload the file after " + MAX_RETRIES + " attempts.");
                    }
                });
            }
        });
         
 
   $('#Next').click(function(){  
   $('#video_upload').hide();
   $('#video_mp4').hide();
   $('#embedvideo').hide();
   $('#bunnycdnvideo').hide();
   $('#optionradio').hide();
   $('.content_videopage').hide();
   $('#content_videopage').hide();
   
   
   $('#Next').hide();
   $('#video_details').show();

   $.ajax({
        url: '{{ URL::to('ugc/extractedimage') }}',
        type: "post",
        data: {
            _token: '{{ csrf_token() }}',
            video_id: $('#video_id').val()
        },
        success: function(value) {
             console.log(value.ExtractedImage.length);

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

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

$(document).ready(function(){
   
   $('#image_error_msg,#player_image_error_msg,#tv_image_image_error_msg').hide();

   $('#image').on('change', function(event) {

         $('#image').removeData('imageWidth');
         $('#image').removeData('imageHeight');
         $('#image').removeData('imageratio');

         var file = this.files[0];
         var tmpImg = new Image();

         tmpImg.src=window.URL.createObjectURL( file ); 
         tmpImg.onload = function() {
             width = tmpImg.naturalWidth,
             height = tmpImg.naturalHeight;
				 ratio =  Number(width/height).toFixed(2) ;
            image_validation_status = "{{  image_validation_videos() }}" ;

             $('#image').data('imageWidth', width);
             $('#image').data('imageHeight', height);
             $('#image').data('imageratio', ratio);

             if( image_validation_status == "0" || ratio == '0.56'|| width == '1080' && height == '1920' ){
               $('.update_upload_img').removeAttr('disabled');
               $('#image_error_msg').hide();
             }
             else{
               $('.update_upload_img').attr('disabled','disabled');
               $('#image_error_msg').show();
             }
         }
   });
     
   $('#player_image').on('change', function(event) {
      
      $('#player_image').removeData('imageWidth');
      $('#player_image').removeData('imageHeight');
      $('#player_image').removeData('imageratio');

      var file = this.files[0];
      var tmpImg = new Image();

      tmpImg.src=window.URL.createObjectURL( file ); 
      tmpImg.onload = function() {
         width = tmpImg.naturalWidth,
         height = tmpImg.naturalHeight;
			ratio =  Number(width/height).toFixed(2) ;
         image_validation_status = "{{  image_validation_videos() }}" ;

         $('#player_image').data('imageWidth', width);
         $('#player_image').data('imageHeight', height);
         $('#player_image').data('imageratio', ratio);

         if( image_validation_status == "0" ||  ratio == '1.78' || width == '1280' && height == '720' ){
            $('.update_upload_img').removeAttr('disabled');
            $('#player_image_error_msg').hide();
         }
         else{
            $('.update_upload_img').attr('disabled','disabled');
            $('#player_image_error_msg').show();
         }
      }
   });

});

</script>


@stop
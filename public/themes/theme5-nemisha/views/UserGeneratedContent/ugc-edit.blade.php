@php
    include public_path('themes/theme5-nemisha/views/header.php');
@endphp


@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop
<?php
   $embed_url = URL::to('/category/videos/embed');
   $embed_media_url = $embed_url . '/' . $video->slug;
   $url_path = '<iframe width="853" height="480" src="'.$embed_media_url.'" frameborder="0" allowfullscreen></iframe>';
   $media_url = URL::to('ugc/video-player').'/'.$video->slug;
   ?>
<style>
   span{
   color: gray;
   }
   .progress { position:relative; width:100%; }
   .bar { background-color: #008000; width:0%; height:20px; }
   .percent { position:absolute; display:inline-block; left:50%; color: #7F98B2;}
   [data-tip] {
   position:relative;
   }
    #video{
        width: 100%;
    }
   .subtitle1{
   display: flex;
   justify-content: space-between;
   width: 50%;
   }
   [data-tip]:before {
   content:'';
   /* hides the tooltip when not hovered */
   display:none;
   content:'';
   border-left: 5px solid transparent;
   border-right: 5px solid transparent;
   border-bottom: 5px solid #1a1a1a;	
   position:absolute;
   z-index:8;
   font-size:0;
   line-height:0;
   width:0;
   height:0;
   }
   [data-tip]:after {
   display:none;
   content:attr(data-tip);
   position:absolute;
   padding:5px 8px;
   background:#1a1a1a;
   color:#fff;
   z-index:9;
   font-size: 0.75em;
   height:18px;
   line-height:18px;
   -webkit-border-radius: 3px;
   -moz-border-radius: 3px;
   border-radius: 3px;
   white-space:nowrap;
   word-wrap:normal;
   }
   [data-tip]:hover:before,
   [data-tip]:hover:after {
   display:block;
   }
    .plyr--video {height: 350px;}
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
	 outline: 1px auto #fff;
}

	
.tags-input-wrapper{
    background: #fff;
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
    padding: 0px 3px 0px 7px;
    margin-right: 5px;
    margin-bottom:5px;
    /* box-shadow: 0 5px 15px -2px rgba(250 , 14 , 126 , .7) */
    border: 1px solid #aaa;
    border-radius: 4px;
    background-color: #e4e4e4;
    color: #000;
    font-size: 12px;
    font-weight: 500;
}
.tags-input-wrapper .tag a {
    margin: 0 7px 3px;
    display: inline-block;
    cursor: pointer;
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
</style>
<link rel="stylesheet" href="https://cdn.plyr.io/3.6.9/plyr.css" />
<!-- <link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/style.css';?>" /> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://malsup.github.io/jquery.form.js"></script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>
<div id="content-page" class="content-page">
<div id="content-page" class="">
<div class="container-fluid p-0">
<div class="row">
<div class="col-sm-12">
<div class="iq-card">

<br>

{{-- @if($video->type == 'mp4_url')
   <h5> Mp4: {{ $video->mp4_url }}</h5>

   @elseif ($video->type == 'm3u8_url')
   <h5> M3U8 URL : {{ $video->m3u8_url }}</h5>

   @elseif($video->type == 'embed')
   <h5> Embeded : {{ $video->embed_code }}</h5>

   @elseif ($video->type == '')
   <h5> M3U8 : {{ URL::to('/storage/app/public/').'/'.$video->path . '.m3u8' }}</h5>

   @elseif ($video->type == 'aws_m3u8') 
   <h5> Aws M3U8 : {{ @$video->m3u8_url }}</h5>

@endif --}}
                       

@if($page == 'Edit' && $video->status == 0  && $video->type != 'embed' && $video->type != 'mp4_url' && $video->type != 'm3u8_url')
      <div class="col-sm-12">
         Video Transcoding is under Progress
         <div class="progress">
            <div class="low_bar"></div >
         </div>
         <div class="low_percent">0%</div >
      </div>
      @endif
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

<?php 
 $filename = $video->path.'.mp4';
 $path = storage_path('app/public/'.$filename);
?>
{{-- @if($video->processed_low >= 100 && $video->type == "")
   @if (file_exists($path))
      <a class="iq-bg-warning mt-2"  href="{{ URL::to('admin/videos/filedelete') . '/' . $video->id }}" style="margin-left: 85%;"><button class="btn btn-secondary" > Delete Original File</button></a>
   @endif
@endif --}}


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<div >
<div class="container-fluid">
   <div class="row ">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center p-0  mb-2">
         <div class="px-0  pb-0  mb-3 col-md-12">
            <form id="msform" method="POST" action="{{ $post_route }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">
               @csrf 
              
               @if($video->processed_low >= 100 && $video->type == "" || $video->type == "mp4_url"   || $video->type == "m3u8_url" || $video->type == "aws_m3u8" || $video->type == "embed")

               <fieldset id="player_data">
                  <div>
                     <div class="row">
                      <div id="video_container" class="fitvid col-sm-12" atyle="z-index: 9999;" >
                        @if($video->type == 'mp4_url')
                           <video id="videoPlayer"  class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'  type="video/mp4">
                              <source src="<?php if(!empty($video->mp4_url)){   echo $video->mp4_url; }else {  echo $video->trailer; } ?>"  type='video/mp4' label='auto' >
                           </video>
                           @elseif ($video->type == 'm3u8_url')
                           <video  id="videoPlayer" class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' src="<?php echo $video->trailer; ?>"  type="video/mp4" >
                              <source src="<?php if($video->type == "m3u8_url"){ echo $video->m3u8_url; }else { echo $video->trailer; } ?>" type="application/x-mpegURL" label='auto' >
                           </video>
                           @elseif($video->type == 'embed')
                           <div class="plyr__video-embed" id="player">
                              <iframe
                                 src="<?php if(!empty($video->embed_code)){ echo $video->embed_code; }else { echo $video->trailer;} ?>"
                                 allowfullscreen
                                 allowtransparency
                                 allow="autoplay"
                                 ></iframe>
                           </div>
                           @elseif ($video->type == '')
                           <video id="video"  controls crossorigin playsinline poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' >
                              <source 
                                 type="application/x-mpegURL" 
                                 src="<?php echo URL::to('/storage/app/public/').'/'.$video->path . '.m3u8'; ?>"
                                 >
                           </video>
                           @elseif ($video->type == 'aws_m3u8') 
                           <video id="video"  controls crossorigin playsinline poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' >
                              <source 
                                 type="application/x-mpegURL" 
                                 src="<?php if($video->type == "aws_m3u8"){ echo $video->m3u8_url; }else { echo $video->trailer; } ?>"
                                 >
                           </video>
                        @endif
                        </div>
                         </div>
                         

                      </div> 
                     <input type="button" name="next" class="next action-button" id="nextplayer" value="Next"  /> 
               </fieldset>
               @endif
               <fieldset id="slug_validate">
               <div class="form-card">
                                       {{-- video id --}}
                  <input type="hidden" value="{{ $video->id }}" name="videos_id" > 
              
               <div class="row">
                   <div class="col-sm-6 form-group" >
                        <label class="m-0">Title :</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="@if(!empty($video->title)){{ $video->title }}@endif">
                   </div>

                  <div class="col-sm-6 form-group" >
                     <label class="m-0"> Video Slug 
                        <a class="iq-bg-warning" data-toggle="tooltip" data-placement="top" title="Please enter the URL Slug" data-original-title="Please enter the URL Slug" href="#">
                           <i class="las la-exclamation-circle"></i>
                        </a>:
                     </label>
                     <input type="text"   class="form-control" name="slug" id="slug" placeholder="Video Slug" value="@if(!empty($video->slug)){{ $video->slug }}@endif">
                     <span><p id="slug_error" style="color:red;">This slug already used </p></span>

                  </div>
               </div>
   
               <div class="row">
                   <div class="col-lg-12 form-group">
                        <label class="m-0">Video Description:</label>
                        <textarea  rows="5" class="form-control mt-2" name="description" id="summary-ckeditor"
                      placeholder="Description">@if(!empty($video->description)){{ ($video->description) }}@endif</textarea>
                   </div>
                   {{-- <div class="col-12 form-group">
                        <label class="m-0">Links &amp; Details</label>
                        <textarea   rows="5" class="form-control mt-2" name="details" id="links-ckeditor"
                      placeholder="Link and details">@if(!empty($video->details)){{ ($video->details) }}@endif</textarea>
                   </div> --}}
               </div>
               
               <div class="row">
                  <div class="col-7">
                        <h2 class="fs-title">Image Upload:</h2>
                  </div>
                  <div class="col-5"></div>
               </div>

               <div class="row">
                  <div class="col-sm-6 form-group">
                     {{-- <div id="VideoImagesContainer" class="gridContainer mt-3"></div> --}}
                     @php 
                        $width = $compress_image_settings->width_validation_videos;
                        $heigth = $compress_image_settings->height_validation_videos;
                     @endphp
                     @if($width !== null && $heigth !== null)
                        <p class="p1">{{ ("Video Thumbnail (".''.$width.' x '.$heigth.'px)')}}:</p> 
                     @else
                        <p class="p1"  style="color:black !important;">{{ "Video Thumbnail ( 9:16 Ratio or 1080X1920px )"}}:</p> 
                     @endif
                     <input type="file" name="image" id="image" />
                     <span>
                         <p id="video_image_error_msg" style="color:red !important; display:none;">
                             * Please upload an image with the correct dimensions.
                         </p>
                     </span>
                     @if(!empty($video->image) && ($video->image) != null )
                     <div class="col-sm-8 p-0">
                         <img src="{{ URL::to('/') . '/public/uploads/images/' . $video->image }}" class="video-img w-100 mt-1" />
                     </div>
                     @endif
                 </div>
                 
                 <div class="col-sm-6 form-group">
                     {{-- <div id="VideoPlayerImagesContainer" class="gridContainer mt-3"></div> --}}
                     @php 
                        $player_width = $compress_image_settings->width_validation_player_img;
                        $player_heigth = $compress_image_settings->height_validation_player_img;
                     @endphp
                     @if($player_width !== null && $player_heigth !== null)
                        <p class="p1">{{ ("Player Thumbnail (".''.$player_width.' x '.$player_heigth.'px)')}}:</p> 
                     @else
                        <p class="p1" style="color:black !important;">{{ "Player Thumbnail ( 16:9 Ratio or 1280X720px )"}}:</p> 
                     @endif
                     <div class="panel-body">
                        <input type="file" name="player_image" id="player_image" />
                        <span>
                           <p id="player_image_error_msg" style="color:red !important; display:none;">
                              * Please upload an image with the correct dimensions.
                           </p>
                        </span>
                        @if(!empty($video->player_image))
                        <div class="col-sm-8 p-0">
                           <img src="{{ URL::to('/') . '/public/uploads/images/' . $video->player_image }}" class="video-img w-100 mt-1" />
                        </div>
                        @endif
                     </div>
                 </div>

               </div>
               <div class="">
               <button type="submit" style = "float: right; margin: 10px 5px 10px 0px; vertical-align: middle;" class="btn btn-primary" value="{{ $button_text }}">{{ $button_text }}</button>
               </div>
               {{-- <button type="submit" class="btn btn-primary mr-2" value="{{ $button_text }}">{{ $button_text }}</button> --}}
            </div>
            </fieldset>

            </form>
         </div>
      </div>
   </div>
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
   background-color: white;
   padding: 50px;
   border-radius:10px;
   }
   #msform fieldset:not(:first-of-type) {
   display: none;
   }
    #msform input[type="text"],#msform input[type="date"],
   #msform textarea {
   padding: 8px 15px 8px 15px;
/*   border: 1px solid #e6e8eb;*/
   border-radius: 0px;
   margin-bottom: 25px;
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
       padding: 0;
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
   #progressbar #videot:before {
   font-family: FontAwesome;
   content: "\f03d"
   }
   #progressbar #account:before {
   font-family: FontAwesome;
   content: "\f129"
   } 
   #progressbar #personal:before {
   font-family: FontAwesome;
   content: "\f007"
   }
   #progressbar #payment:before {
   font-family: FontAwesome;
   content: "\f03e"
   }
   #progressbar #confirm:before {
   font-family: FontAwesome;
   content: "\f03d"
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
    #progressbar li img{
        width: 125px;
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
   background: #48bbe5;
   }
   .fit-image {
   width: 100%;
   object-fit: cover
   }
    #progressbar li img {
    width: 125px;
    display: block;
    margin: 0 auto;
}
   #msform input[type="file"]{border: 0; width: 100%;}
   .ck.ck-powered-by {display: none;}
</style>

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
   $('html, body').animate({scrollTop: '0px'}, 300);
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
   $('html, body').animate({scrollTop: '0px'}, 300);   
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

<style>
   .without::-webkit-datetime-edit-ampm-field {
   display: none;
   }
</style>

<input type="hidden" id="base_url" value="<?php echo URL::to('/');?>">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>                       
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />
<script>

         // validation for slug

$(document).ready(function(){

   $('#slug_error').hide();
	$('#slug_validate').on('blur mouseover', function(e) {
     
      var video_id = "{{ $video->id }}";
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
      url: "{{ url('admin/video_slug_validate') }}",
            data: {
               _token  : "{{csrf_token()}}" ,
               slug: slug,
               type: "edit",
               video_id: video_id,
             
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

<script src="<?= URL::to('/assets/js/jquery.mask.min.js');?>"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>


<script src="<?= URL::to('/assets/js/jquery.mask.min.js');?>"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.js"></script>



<script type="text/javascript">


   var SITEURL = "{{URL('/')}}";
   // $(function() {
   //     $(document).ready(function()
   //     {
   //         var bar = $('.bar');
   //         var percent = $('.percent');
   //           $('#form').ajaxForm({
   //             beforeSend: function() {
   //                 var percentVal = '0%';
   //                 bar.width(percentVal)
   //                 percent.html(percentVal);
   //             },
   //             uploadProgress: function(event, position, total, percentComplete) {
   //                 var percentVal = percentComplete + '%';
   //                 bar.width(percentVal)
   //                 percent.html(percentVal);
   //             },
   //             complete: function(xhr) {
   //                 alert('Successfully Updated Video!');
   //                 window.location.href = "{{ URL::to('admin/videos') }}";
   //             }
   //           });
   //     }); 
   //  }); 
   
   if (($("#page").val() == 'Edit') && ($("#status").val() == 0)) {
   	setInterval(function(){ 
   		$.getJSON('<?php echo URL::to("/admin/get_processed_percentage/");?>'+'/'+$("#id").val(), function(data) {
   			$('.low_bar').width(data.processed_low+'%');
            if(data.processed_low == null){
   			$('.low_percent').html('Transcoding is Queued. Waiting for Server to Respond');
            }else{
   			$('.low_percent').html(data.processed_low+'%');
            }
   		});
   	}, 3000);
   }
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/tinymce.min.js"></script>

<script type="text/javascript">
   $ = jQuery;
   

   $(document).ready(function(){


   $('#videot').click(function(){
      $(".progress-bar").css({"width":"17%"});
      $('#player_data').show();
      $('#slug_validate').hide();
      $('#videocategory_data').hide();
      $('#video_access_data').hide();
      $('#upload_datas').hide();
      $('#ads_data').hide();

   });
   $('#account').click(function(){
      $(".progress-bar").css({"width":"33%"});
     $('#player_data').hide();
      $('#slug_validate').show();
      $('#videocategory_data').hide();
      $('#video_access_data').hide();
      $('#upload_datas').hide();
      $('#ads_data').hide();

   });
   $('#personal').click(function(){

      $(".progress-bar").css({"width":"50%"});

      $('#player_data').hide();
      $('#slug_validate').hide();
      $('#videocategory_data').show();
      $('#video_access_data').hide();
      $('#upload_datas').hide();
      $('#ads_data').hide();

   });
   $('#useraccess_ppvprice').click(function(){
      $(".progress-bar").css({"width":"67%"});

      $('#player_data').hide();
      $('#slug_validate').hide();
      $('#videocategory_data').hide();
      $('#video_access_data').show();
      $('#upload_datas').hide();
      $('#ads_data').hide();

   });
   $('#payment').click(function(){
      $(".progress-bar").css({"width":"83%"});

      $('#player_data').hide();
      $('#slug_validate').hide();
      $('#videocategory_data').hide();
      $('#video_access_data').hide();
      $('#upload_datas').show();
      $('#ads_data').hide();

   });
   $('#confirm').click(function(){
      $(".progress-bar").css({"width":"100%"});

      $('#player_data').hide();
      $('#slug_validate').hide();
      $('#videocategory_data').hide();
      $('#video_access_data').hide();
      $('#upload_datas').hide();
      $('#ads_data').show();

   });
});
   $(document).ready(function($){
      
      $("#inputTag").tagsinput('items');
      
      $('.js-example-basic-multiple').select2();
      $('.js-example-basic-single').select2();
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

   CKEDITOR.replace( 'links-ckeditor', {
       filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
       filebrowserUploadMethod: 'form'
   });

   CKEDITOR.replace( 'trailer-ckeditor', {
       filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
       filebrowserUploadMethod: 'form'
   });
   
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script>
   $('input[type="checkbox"]').on('change', function(){
   this.value = this.checked ? 1 : 0;
   }).change();
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>
   $(document).ready(function(){
       // $('#message').fadeOut(120);
       setTimeout(function() {
           $('#successMessage').fadeOut('fast');
       }, 3000);
   })
   

</script>
<script src="https://cdn.plyr.io/3.6.3/plyr.polyfilled.js"></script>
<script src="https://cdn.rawgit.com/video-dev/hls.js/18bb552/dist/hls.min.js"></script>
<script src="https://cdn.plyr.io/3.5.10/plyr.js"></script>
<script src="https://cdn.jsdelivr.net/hls.js/latest/hls.js"></script>
<script>
   var type = '<?= $video->type ?>';
   if(type != "" && type != 'aws_m3u8'){
   // alert('type');

       const player = new Plyr('#videoPlayer',{
         controls: [
                     'play-large',
                     'restart',
                     'rewind',
                     'play',
                     'fast-forward',
                     'progress',
                     'current-time',
                     'mute',
                     'volume',
                     'captions',
                     'settings',
                     'pip',
                     'airplay',
                     'fullscreen',
                  ],
  
       });
       $("#nextplayer").click(function(){
      player.stop();
   });
   }else if(type == 'aws_m3u8'){
   // alert(type);

      document.addEventListener("DOMContentLoaded", () => {
   const video = document.querySelector("video");
   const source = video.getElementsByTagName("source")[0].src;
   
   // For more options see: https://github.com/sampotts/plyr/#options
   // captions.update is required for captions to work with hls.js
   const defaultOptions = {};
   
   if (Hls.isSupported()) {
   // For more Hls.js options, see https://github.com/dailymotion/hls.js
   const hls = new Hls();
   hls.loadSource(source);
   
   // From the m3u8 playlist, hls parses the manifest and returns
   // all available video qualities. This is important, in this approach,
   // we will have one source on the Plyr player.
   hls.on(Hls.Events.MANIFEST_PARSED, function (event, data) {
   
     // Transform available levels into an array of integers (height values).
     const availableQualities = hls.levels.map((l) => l.height)
   
     // Add new qualities to option
     defaultOptions.quality = {
       default: availableQualities[0],
       options: availableQualities,
       // this ensures Plyr to use Hls to update quality level
       forced: true,        
       onChange: (e) => updateQuality(e),
     }
   
     // Initialize here
     const player = new Plyr(video, defaultOptions);
     
   $("#nextplayer").click(function(){
      player.stop();
   });
   });
   hls.attachMedia(video);
   window.hls = hls;

   } else {
   // default options with no quality update in case Hls is not supported
   const player = new Plyr(video, defaultOptions);

   $("#nextplayer").click(function(){
      alert();
      player.stop();
   });
   }
   
   function updateQuality(newQuality) {
   window.hls.levels.forEach((level, levelIndex) => {
     if (level.height === newQuality) {
       console.log("Found quality match with " + newQuality);
       window.hls.currentLevel = levelIndex;
     }
   });
   }
   });
   }
   else{
         document.addEventListener("DOMContentLoaded", () => {
   const video = document.querySelector("video");
   const source = video.getElementsByTagName("source")[0].src;
   
   // For more options see: https://github.com/sampotts/plyr/#options
   // captions.update is required for captions to work with hls.js
   const defaultOptions = {};
   
   if (Hls.isSupported()) {
   // For more Hls.js options, see https://github.com/dailymotion/hls.js
   const hls = new Hls();
   hls.loadSource(source);
   
   // From the m3u8 playlist, hls parses the manifest and returns
   // all available video qualities. This is important, in this approach,
   // we will have one source on the Plyr player.
   hls.on(Hls.Events.MANIFEST_PARSED, function (event, data) {
   
     // Transform available levels into an array of integers (height values).
     const availableQualities = hls.levels.map((l) => l.height)
   
     // Add new qualities to option
     defaultOptions.quality = {
       default: availableQualities[0],
       options: availableQualities,
       // this ensures Plyr to use Hls to update quality level
       forced: true,        
       onChange: (e) => updateQuality(e),
     }
   
     // Initialize here
     const player = new Plyr(video, defaultOptions);
     
   $("#nextplayer").click(function(){
      player.stop();
   });
   });
   hls.attachMedia(video);
   window.hls = hls;

   } else {
   // default options with no quality update in case Hls is not supported
   const player = new Plyr(video, defaultOptions);

   $("#nextplayer").click(function(){
      alert();
      player.stop();
   });
   }
   
   function updateQuality(newQuality) {
   window.hls.levels.forEach((level, levelIndex) => {
     if (level.height === newQuality) {
       console.log("Found quality match with " + newQuality);
       window.hls.currentLevel = levelIndex;
     }
   });
   }
   });
   
   }

   function EmbedCopy() {
   // var media_path = $('#media_url').val();
   var media_path = '<?= $url_path ?>';
   var url =  navigator.clipboard.writeText(window.location.href);
   var path =  navigator.clipboard.writeText(media_path);
   $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Copied Embed URL</div>');
              setTimeout(function() {
               $('.add_watch').slideUp('fast');
              }, 3000);
   // console.log(url);
   // console.log(media_path);
   // console.log(path);
   }





</script>


<script src="https://cdn.plyr.io/3.5.10/plyr.js"></script>

<script>

  const player = new Plyr('#videoPlayer1'); 

  var trailer_video_m3u8 = <?php echo json_encode($video->trailer) ; ?> ;
  var trailer_video_type =  <?php echo json_encode($video->trailer_type) ; ?> ;
  

  if(trailer_video_type == "m3u8_url"){
    (function () {
      var video = document.querySelector('#videoPlayer1');

      if (Hls.isSupported()) {
          var hls = new Hls();
          hls.loadSource(trailer_video_m3u8);
          hls.attachMedia(video);
          hls.on(Hls.Events.MANIFEST_PARSED,function() {
        });
      }
      
    })();

  }else if(trailer_video_type == "m3u8"){
  document.addEventListener("DOMContentLoaded", () => {
  const videom3u8 = document.querySelector('#videom3u8');
  // alert(video);
  const sources = videom3u8.getElementsByTagName("source")[0].src;
//   alert(sources);
  const defaultOptions = {};

  if (Hls.isSupported()) {
    const hlstwo = new Hls();
    hlstwo.loadSource(sources);
    hlstwo.on(Hls.Events.MANIFEST_PARSED, function (event, data) {

      const availableQualities = hlstwo.levels.map((l) => l.height)

      // Add new qualities to option
      defaultOptions.quality = {
        default: availableQualities[0],
        options: availableQualities,
        // this ensures Plyr to use Hls to update quality level
        forced: true,        
        onChange: (e) => updateQuality(e),
      }

      // Initialize here
      const player = new Plyr(videom3u8, defaultOptions);
    });
    hlstwo.attachMedia(videom3u8);
    window.hlstwo = hlstwo;
  }

  function updateQuality(newQuality) {
    window.hlstwo.levels.forEach((level, levelIndex) => {
      if (level.height === newQuality) {
        console.log("Found quality match with " + newQuality);
        window.hlstwo.currentLevel = levelIndex;
      }
    });
  }
});

  }
   

</script>

<script>
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
                    document.getElementById('player_image_error_msg').style.display = 'block';
                    $('#useraccess_ppvprice').prop('disabled', true);
                    document.getElementById('player_image_error_msg').innerText = 
                        `* Please upload an image with the correct dimensions (${validWidth}x${validHeight}px).`;
                } else {
                    document.getElementById('player_image_error_msg').style.display = 'none';
                    $('.update_upload_img').prop('disabled', false);
                }
            };
            img.src = URL.createObjectURL(file);
        }
    });

</script>



<script>
   
   $(document).ready(function(){

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

                if(  image_validation_status == "0" || ratio == '0.56'|| width == '1080' && height == '1920' ){
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

            if(  image_validation_status == "0" || ratio == '1.78' || width == '1280' && height == '720' ){
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


@section('javascript')
@stop

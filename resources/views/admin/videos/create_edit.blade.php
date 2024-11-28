@extends('admin.master')
@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop
<?php
   $embed_url = URL::to('/category/videos/embed');
   $embed_media_url = $embed_url . '/' . $video->slug;
   $url_path = '<iframe width="853" height="480" src="'.$embed_media_url.'" frameborder="0" allowfullscreen></iframe>';
   $media_url = URL::to('/category/videos').'/'.$video->slug;
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
button[data-plyr="captions"] {
    display: none !important;
}
.sample-file.d-flex a{font-size: 12px;margin-right: 5px;}
</style>
<link rel="stylesheet" href="https://cdn.plyr.io/3.6.9/plyr.css" />
<!-- <link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/style.css';?>" /> -->
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://malsup.github.io/jquery.form.js"></script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>
<div id="content-page" class="content-page">
    <div class="mt-5 d-flex">
                        <a class="black" href="{{ URL::to('admin/videos') }}">All Videos</a>
                        <a class="black" href="{{ URL::to('admin/videos/create') }}">Add New Video</a>
                        <a class="black" href="{{ URL::to('admin/CPPVideosIndex') }}">Videos For Approval</a>
                        <a class="black" href="{{ URL::to('admin/Masterlist') }}" class="iq-waves-effect"> Master Video List</a>
                       <a class="black" href="{{ URL::to('admin/videos/categories') }}">Manage Video Categories</a>
                       <a class="black"  href="{{ URL::to('admin/ActiveSlider') }}">Active Slider List</a>
                     </div>
<div id="content-page" class="">
<div class="container-fluid p-0">
<div class="row">
<div class="col-sm-12">
<div class="iq-card">
<div class="iq-card-header d-flex justify-content-between">
   <div class="iq-header-title">
      <h4 class="card-title">Add Video</h4>
   </div>
   <div class="d-flex justify-content-between">
            <div>
                <a href="{{ URL::to('category/videos') . '/' . $video->slug }}" target="_blank" class="btn btn-primary">
                    <i class="fa fa-eye"></i> Preview <i class="fa fa-external-link"></i>
                </a>
            </div>
        </div>
           
      
</div>
<br>

@if($video->type == 'mp4_url')
   <h5> Mp4: {{ $video->mp4_url }}</h5>

   @elseif ($video->type == 'm3u8_url')
   <h5> M3U8 URL : {{ $video->m3u8_url }}</h5>

   @elseif($video->type == 'embed')
   <h5> Embeded : {{ $video->embed_code }}</h5>

   @elseif ($video->type == '')
   <h5> M3U8 : {{ URL::to('/storage/app/public/').'/'.$video->path . '.m3u8' }}</h5>

   @elseif ($video->type == 'aws_m3u8') 
   <h5> Aws M3U8 : {{ @$video->m3u8_url }}</h5>

@endif
                       

@if($page == 'Edit' && $video->status == 0  && $video->type != 'embed' && $video->type != 'mp4_url' && $video->type != 'm3u8_url')
      <div class="col-sm-12">
         Video Transcoding is under Progress
         <div class="progress">
            <div class="low_bar"></div >
         </div>
         <div class="low_percent">0%</div >
      </div>
      @endif

   @if($page == 'Edit' && $video->status == 0  && Enable_Video_Compression() == 1)
      <div class="col-sm-12 CompressionVideo">
         Video Compression is under Progress
         <div class="Compression_progress">
            <div class="Compression_low_bar"></div >
         </div>
         <div class="Compression_low_percent">0%</div >
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


<h5 class="p-1 mt-3 ml-3" style="font-weight: normal;">Video Info Details</h5>
<?php 
 $filename = $video->path.'.mp4';
 $path = storage_path('app/public/'.$filename);
?>
@if($video->processed_low >= 100 && $video->type == "")
   @if (file_exists($path))
      <a class="iq-bg-warning mt-2"  href="{{ URL::to('admin/videos/filedelete') . '/' . $video->id }}" style="margin-left: 85%;"><button class="btn btn-secondary" > Delete Original File</button></a>
   @endif
@endif


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<div >
<div class="container-fluid">
   <div class="row ">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center p-0  mb-2">
         <div class="px-0  pb-0  mb-3 col-md-12">
            <form id="msform" method="POST" action="{{ $post_route }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">
               <!-- progressbar -->
               <ul id="progressbar">
                  @if($video->processed_low >= 100   && $video->type == "" || $video->type == "mp4_url"   || $video->type == "m3u8_url" || $video->type == "embed")
                  <li class="active" id="videot"><img class="" src="<?php echo  URL::to('/assets/img/icon/1.svg')?>">Video</li>
                  @endif
                  <li class="" id="account"><img class="" src="<?php echo  URL::to('/assets/img/icon/1.svg')?>">Video Details</li>
                  <li id="personal"><img class="" src="<?php echo  URL::to('/assets/img/icon/2.svg')?>">Category</li>
                  <li id="useraccess_ppvprice"><img class="" src="<?php echo  URL::to('/assets/img/icon/3.svg')?>">User Video Access</li>
                  <li id="payment"><img class="" src="<?php echo  URL::to('/assets/img/icon/4.svg')?>">Upload Image &amp; Trailer</li>
                  <li id="confirm"><img class="" src="<?php echo  URL::to('/assets/img/icon/5.svg')?>">Ads Management &amp; Transcoding</li>
               </ul>
               <div class="progress">
                  <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
               </div>
               <br> <!-- fieldsets -->
               @if($video->processed_low >= 100 && $video->type == "" || $video->type == "mp4_url"   || $video->type == "m3u8_url" || $video->type == "aws_m3u8" || $video->type == "embed")

               <fieldset id="player_data">
                  <div class="form-card">
                     <div class="row">
                        <div class="col-6">
                           <h2 class="fs-title p-0">Video Player</h2>
                        </div>
                        @if($video->access != 'ppv')
                           @if($video->active == 1  && $video->status == 1 && !empty($video->publish_type) || $video->active == 0  && empty($video->publish_type) || $video->enable == 0 && empty($video->publish_type) || $video->status == 0 && empty($video->publish_type) )
                        <div class="col-3">
                            <label for=""><h3 class="fs-title m-0">Embed Link:</h3></label>
                            <p>Click <a href="#"onclick="EmbedCopy();" class="share-ico"><i class="ri-links-fill"></i> here</a> to get the Embedded URL</p>
                            </div>

                            <div class="col-3">
                            <label for=""><h3 class="fs-title m-0">Social Share:</h3></label>
                           <div class="share-box">
                                 <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $media_url ?>" class="share-ico"><i class="ri-facebook-fill"></i></a>&nbsp;  <!-- Facebook -->
                                 <a href="https://twitter.com/intent/tweet?text=<?= $media_url ?>" class="share-ico"><i class="ri-twitter-fill"></i></a> <!-- Twitter -->
                              </div>
                        </div>
                           @endif
                        @endif

                      <div id="video_container" class="fitvid col-sm-12" atyle="z-index: 9999;" >
                        @if($video->type == 'mp4_url')
                           <video id="videoPlayer"  class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'  type="video/mp4">
                              <source src="<?php if(!empty($video->mp4_url)){   echo $video->mp4_url; }else {  echo $video->trailer; } ?>"  type='video/mp4' label='auto' >
                                 <?php  if(isset($MoviesSubtitles)){
                                    foreach ($MoviesSubtitles as $key => $subtitles_file) { ?>
                                       <track kind="captions" src="<?= $subtitles_file->url ?>" srclang="<?= $subtitles_file->sub_language ?>"
                                          label="<?= $subtitles_file->shortcode ?>" default>
                                 <?php } }  ?>
                              </video>
                           @elseif ($video->type == 'm3u8_url')
                           <video  id="videoPlayer" class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' src="<?php echo $video->trailer; ?>"  type="video/mp4" >
                              <source src="<?php if($video->type == "m3u8_url"){ echo $video->m3u8_url; }else { echo $video->trailer; } ?>" type="application/x-mpegURL" label='auto' >
                                 <?php  if(isset($MoviesSubtitles)){
                                    foreach ($MoviesSubtitles as $key => $subtitles_file) { ?>
                                       <track kind="captions" src="<?= $subtitles_file->url ?>" srclang="<?= $subtitles_file->sub_language ?>"
                                          label="<?= $subtitles_file->shortcode ?>" default>
                                 <?php } }  ?>
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
                              <source type="application/x-mpegURL" src="<?php echo URL::to('/storage/app/public/').'/'.$video->path . '.m3u8'; ?>">
                                 <?php  if(isset($MoviesSubtitles)){
                                    foreach ($MoviesSubtitles as $key => $subtitles_file) { ?>
                                       <track kind="captions" src="<?= $subtitles_file->url ?>" srclang="<?= $subtitles_file->sub_language ?>"
                                          label="<?= $subtitles_file->shortcode ?>" default>
                                 <?php } }  ?>
                           </video>
                           @elseif ($video->type == 'aws_m3u8') 
                           <video id="video"  controls crossorigin playsinline poster="<?= URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' >
                              <source 
                                 type="application/x-mpegURL" 
                                 src="<?php if($video->type == "aws_m3u8"){ echo $video->m3u8_url; }else { echo $video->trailer; } ?>"
                                 >
                                 <?php  if(isset($MoviesSubtitles)){
                                    foreach ($MoviesSubtitles as $key => $subtitles_file) { ?>
                                       <track kind="captions" src="<?= $subtitles_file->url ?>" srclang="<?= $subtitles_file->sub_language ?>"
                                          label="<?= $subtitles_file->shortcode ?>" default>
                                 <?php } }  ?>
                           </video>
                        @endif
                        </div>
                         </div>
<!--
                          <div class="col-6 text-center">
                              <p>@if(!empty($video->title)){{ $video->title }}@endif</p>
                              <p>@if(!empty($video->description)){{ ($video->description) }}@endif</p>
                              <p>$video->title</p>
                              <p>$video->title</p>
                          </div>
-->

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
                  
         {{-- Age Restrict --}}
                  <div class="col-sm-6 form-group">
                     <label class="m-0">Age Restrict:</label>
                     <select class="form-control" id="age_restrict" name="age_restrict">
                        <option value="">Choose Age</option>
                           @foreach($age_categories as $key => $age)
                              <option value="{{ $age->age }}"  {{  ($video->age_restrict == $age->age ) ? 'selected' : '' }} > {{ $age->slug }}</option>
                           @endforeach
                     </select>
                  </div>

               <div class="col-sm-6 form-group ">                                       
                     <label class="m-0">Rating:</label>
                     <!-- <input type="text" class="form-control" placeholder="Movie Ratings" name="rating" id="rating" value="@if(!empty($video->rating)){{ $video->rating }}@endif" onkeyup="NumAndTwoDecimals(event , this);"> -->
                     <select  class="js-example-basic-single" style="width: 100%;" name="rating" id="rating" tags= "true" onkeyup="NumAndTwoDecimals(event , this);" >
                        <option value="1" {{ $video->rating == '1' ? 'selected':'' }} >1</option>
                        <option value="2" {{ $video->rating == '2' ? 'selected':'' }} >2</option>
                        <option value="3" {{ $video->rating == '3' ? 'selected':'' }} >3</option>
                        <option value="4" {{ $video->rating == '4' ? 'selected':'' }} >4</option>
                        <option value="5" {{ $video->rating == '5' ? 'selected':'' }} >5</option>
                        <option value="6" {{ $video->rating == '6' ? 'selected':'' }} >6</option>
                        <option value="7" {{ $video->rating == '7' ? 'selected':'' }} >7</option>
                        <option value="8" {{ $video->rating == '8' ? 'selected':'' }} >8</option>
                        <option value="9" {{ $video->rating == '9' ? 'selected':'' }} >9</option>
                        <option value="10"{{ $video->rating == '10' ? 'selected':'' }} >10</option>
                     </select>
                  </div>
               </div>
              
               
               <div class="row">
                   <div class="col-lg-12 form-group">
                        <label class="m-0">Video Description:</label>
                        <textarea  rows="5" class="form-control mt-2" name="description" id="summary-ckeditor"
                      placeholder="Description">@if(!empty($video->description)){{ ($video->description) }}@endif</textarea>
                   </div>
                   <div class="col-12 form-group">
                        <label class="m-0">Links &amp; Details</label>
                        <textarea   rows="5" class="form-control mt-2" name="details" id="links-ckeditor"
                      placeholder="Link and details">@if(!empty($video->details)){{ ($video->details) }}@endif</textarea>
                   </div>
               </div>
                <div class="row">
                    <div class="col-sm-4 form-group mt-3">
                        <label class="m-0">Skip Intro Time <small>(Duration Time In (HH : MM : SS))</small></label>
                        <input type="text" class="form-control" id="skip_intro" name="skip_intro" value="@if(!empty($video->skip_intro)){{ $video->skip_intro }}@endif" placeholder="HH:MM:SS">
                        <span><p id="error_skip_intro_time" style="color:red !important;">* Fill Skip Intro Time </p></span>
                     </div>
                    <div class="col-sm-4 form-group mt-3">
                        <label class="m-0">Intro Start Time <small>(Duration Time In (HH : MM : SS))</small></label>
                        <input type="text"  class="form-control without" id="intro_start_time" name="intro_start_time" value="@if(!empty($video->intro_start_time)){{ $video->intro_start_time }}@endif" placeholder="HH:MM:SS" >
                        <span><p id="error_intro_start_time" style="color:red !important;">* Fill Intro Start Time </p></span>
                    </div>
                    <div class="col-sm-4 form-group mt-3">
                        <label class="m-0">Intro End Time <small>(Duration Time In (HH : MM : SS))</small></label>
                        <input type="text"  class="form-control without" id="intro_end_time" name="intro_end_time" value="@if(!empty($video->intro_end_time)){{ $video->intro_end_time }}@endif" placeholder="HH:MM:SS">
                        <span><p id="error_intro_end_time" style="color:red !important; ">* Fill Intro End Time </p></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 form-group mt-3">
                        <label class="m-0"> Recap Time <small>(Duration Time In (HH : MM : SS))</small></label> <br>
                        <span> <small> Recap Time Always Lesser than video duration </small> </span>
                        <input type="text" class="form-control" id="skip_recap" name="skip_recap" value="@if(!empty($video->skip_recap)){{ $video->skip_recap }}@endif" placeholder="HH:MM:SS" >
                     </div>
                    <div class="col-sm-4 form-group mt-3">
                        <label class="m-0">Recap Start Time <small>(Duration Time In (HH : MM : SS))</small></label><br>
                        <span> <small> Start Time Always Lesser Than End Time </small> </span>
                        <input type="text"  class="form-control without" id="recap_start_time" name="recap_start_time"  value="@if(!empty($video->recap_start_time)){{ $video->recap_start_time }}@endif" placeholder="HH:MM:SS" >
                    </div>
                    <div class="col-sm-4 form-group mt-3">
                        <label class="m-0">Recap End Time <small>(Duration Time In (HH : MM : SS))</small></label><br> 
                        <span> <small> Recap Time Always Greater than video duration </small> </span>
                        <input type="text"  class="form-control without" id="recap_end_time" name="recap_end_time"  value="@if(!empty($video->recap_end_time)){{ $video->recap_end_time }}@endif" placeholder="HH:MM:SS">
                    </div>
                </div>

                  <div class="row">
                     <div class="col-sm-6 form-group">
                        <label class="m-0">Video Duration:</label>
                        <input type="text" class="form-control" placeholder="Video Duration" name="duration" id="duration" value="@if(!empty($video->duration)){{ gmdate('H:i:s', $video->duration) }}@endif">
                     </div> 
                     <div class="col-sm-6 form-group">
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
                                 <input name="free_duration_status"  id="free_duration_status" type="checkbox"  {{ !empty($video->free_duration_status) && $video->free_duration_status == 1 ? "checked" : null }} >
                                 <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                     <div class="col-sm-6 form-group">
                        <label class="m-0"> Free Duration <small>Enter The Live Stream Free Duration In (HH : MM : SS)</small></label>
                        <input type="text" class="form-control" placeholder="HH:MM:SS" name="free_duration" id="free_duration"  value="@if(!empty($video->free_duration)){{ gmdate('H:i:s', $video->free_duration) }}@endif" />
                     </div>
                  </div>


                <div class="row">
                    <div class="col-sm-6 form-group mt-3" >
                        <label class="mb-2" style="display:block;">Publish Type</label>
                        <input type="radio" id="publish_now" name="publish_type" value = "publish_now" {{ !empty(($video->publish_type=="publish_now"))? "checked" : "" }}> Publish Now <br>
                        <input type="radio" id="publish_later" name="publish_type" value = "publish_later"{{ !empty(($video->publish_type=="publish_later"))? "checked" : "" }} > Publish Later
                    </div>
                    <div class="col-sm-6 form-group mt-3" id="publishlater">
                        <label class="">Publish Time</label>
                        <input type="datetime-local" class="form-control" id="publish_time" name="publish_time" value="@if(!empty($video->publish_time)){{ $video->publish_time }}@endif" >
                    </div>
                </div>

               @if (videos_expiry_date_status() == 1)
                  <div class="row">
                     <div class="col-sm-4 form-group mt-3" id="">
                        <label class="">Expiry Date & Time</label>
                        <input type="datetime-local" class="form-control" id="expiry_date" name="expiry_date" value="@if(!empty($video->expiry_date)){{ $video->expiry_date }}@endif" >
                     </div>
                  </div>     
               @endif

               </div> <input type="button" name="next" id="next2" class="next action-button" value="Next" /><input type="button" name="previous" class="previous action-button-previous" value="Previous" />
               <button type="submit" style = "float: right;
    margin: 10px 5px 10px 0px;
    vertical-align: middle;" class="btn btn-primary" value="{{ $button_text }}">{{ $button_text }}</button>
               
               </fieldset>
               <fieldset class="Next3" id="videocategory_data">
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
               <label class="m-0">Select Video Category :</label>
               <select class="form-control js-example-basic-multiple"  name="video_category_id[]"  id="video_category_id" style="width: 100%;" multiple="multiple" >
               @foreach($video_categories as $category)
               @if(in_array($category->id, $category_id))
               <option value="{{ $category->id }}" selected="true">{{ $category->name }}</option>
               <!-- <option value="{{ $category->id }}" @if(!empty($video->video_category_id) && $video->video_category_id == $category->id)selected="selected"@endif>{{ $category->name }}</option> -->
               @else
               <option value="{{ $category->id }}">{{ $category->name }}</option>
               @endif      
               @endforeach
               </select>
               <span><p id="error_video_Category" style="color:red !important;" >* Choose the Video Category </p></span>
               </div>
               <div class="col-sm-6 form-group" >                               
               <div class="panel panel-primary" data-collapsed="0"> 
               <div class="panel-heading"> 
               <div class="panel-title">
                   <label class="m-0">Cast and Crew :<small>( Add artists for the video below )</small></label> 
               </div> 
               <div class="panel-options"> 
               <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> 
               </div>
               </div> 

                  <div class="panel-body" style="display: block;"> 
                     <select name="artists[]" class="js-example-basic-multiple" style="width: 100%;" multiple="multiple">
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
                  <select class="form-control js-example-basic-multiple languages" id="language" name="language[]" style="width: 100%;" multiple="multiple">
                     <!-- <option selected disabled="">Choose Language</option> -->
                     @foreach($languages as $language)
                        @if(in_array($language->id, $languages_id))
                           <option value="{{ $language->id }}" selected="true">{{ $language->name }}</option>
                        @else
                           <option value="{{ $language->id }}" >{{ $language->name }}</option>
                        @endif 
                     @endforeach
                  </select>
               <span><p id="error_language" style="color:red !important;" >* Choose the Language </p></span>

               </div> 
               <div class="col-sm-4 form-group">
                    <label class="m-0">E-Paper: <small>(Upload your PDF file)</small> </label>
                    <input type="file" class="form-group" name="pdf_file" accept="application/pdf" id="" >
                   @if(!empty($video->pdf_files))
                        <span class='pdf_file' >
                            <a href="{{ URL::to('/') . '/public/uploads/videoPdf/' . $video->pdf_files }}" style="font-size:48px;" class="fa fa-file-pdf-o" width="" height="" download></a>
                            {{'Download file'}}
                        </span>
                   @endif
               </div>
               <div class="col-sm-6 form-group">
               <label class="m-0">Choose Playlist:</label>
                  <select class="form-control js-example-basic-multiple playlists" id="playlist" name="playlist[]" style="width: 100%;" multiple="multiple">
                     @foreach($AdminVideoPlaylist as $Video_Playlist)
                        @if(in_array($Video_Playlist->id, $Playlist_id))
                           <option value="{{ $Video_Playlist->id }}" selected="true">{{ $Video_Playlist->title }}</option>
                        @else
                           <option value="{{ $Video_Playlist->id }}" >{{ $Video_Playlist->title }}</option>
                        @endif 
                     @endforeach
                  </select>

               </div> 
                  <div class="col-sm-6 form-group">
                     <label class="m-0">Reels videos: <small>( Upload the 1 min Videos )</small></label>
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
                     <input type="file" class="form-group" name="reels_videos[]" accept="video/mp4,video/x-m4v,video/*" id="" multiple >

                     @if(!empty($Reels_videos) && count($Reels_videos) > 0 )
                        <div class="d-flex">
                              @foreach($Reels_videos as $reelsVideo)
                                 <video width="200" height="200" controls style="padding: 6px;">
                                    <source src="{{ URL::to('/') . '/public/uploads/reelsVideos/shorts/' . $reelsVideo->reels_videos }}" type="video/mp4">
                                 </video>
                              @endforeach
                           </div>
                     @endif
                  </div>

                  <div class="col-sm-6 form-group">
                     <label class="m-0">Reels Thumbnail: <small>(9:16 Ratio or 720X1080px)</small></label>
                     <input type="file" class="form-group" name="reels_thumbnail"  id=""  >

                        @if($video->reels_thumbnail != null )
                                 <img src="{{ URL::to('/') . '/public/uploads/images/' . $video->reels_thumbnail }}" width="200" height="200"  class="" />
                        @endif
                  </div>
                    </div>

            
            <div class="row">
                <div class="col-sm-6 form-group">
                    <label class="m-0">URL Link <small>( Please Enter Link with https )</small></label>
                    <input type="text" class="form-control" name="url_link" accept="" id="url_link" value="@if(!empty($video->url_link)){{ $video->url_link }}@endif" />
                </div>
            
                <div class="col-sm-6 form-group">
                    <label class="m-0">URL Start Time <small>( HH:MM:SS )</small></label>
                    <input type="text" class="form-control" name="url_linktym" accept="" id="url_linktym" value="@if(!empty($video->url_linktym)){{ $video->url_linktym }}@endif" />
                </div>
            </div>
                <hr />
               <div class="row">    
                  <div class="panel panel-primary" data-collapsed="0"> 
                     <div class="panel-heading"> 
                        <div class="panel-title col-sm-12 d-flex justify-content-between aign-items-center"> 
                            <h6 class="fs-title">
                                Subtitles (WebVTT (.vtt) or SubRip (.srt)) :
                            </h6>
                            <div class="sample-file d-flex align-items-center">
                                <a href="{{ URL::to('/ExampleSubfile.vtt') }}" download="sample.vtt" class="btn btn-primary">Download sample .vtt</a>
                                <a href="{{ URL::to('/Examplefile.srt') }}" download="sample.srt" class="btn btn-primary">Download sample .srt</a>
                                <a class="iq-bg-warning" data-toggle="tooltip" data-placement="top" title="Upload Subtitles" data-original-title="Upload Subtitles" href="#">
                                    <i class="las la-exclamation-circle"></i>
                                </a>
                            </div>
                        </div> 
                        <div class="panel-options"> 
                            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> 
                        </div>
                     </div>
                     <div class="panel-body mt-3" style="display:flex;flex-wrap:wrap;"> 
                        @foreach($subtitles as $subtitle)

                           <div class="col-sm-6 form-group" style="float: left;">
                              <div class="align-items-center" style="clear:both;">
                                 <label for="embed_code"  style="display:block;">Upload Subtitle {{ $subtitle->language }}</label>
                                 <?php //dd($movies_subtitles->sub_language); ?>
                                 @if(@$subtitlescount > 0)
                                    @foreach($MoviesSubtitles as $movies_subtitles)

                                       @if(@$movies_subtitles->sub_language == $subtitle->language)

                                       Uploaded Subtitle : <a href="{{ @$movies_subtitles->url }}" download="{{ @$movies_subtitles->sub_language }}">{{ @$movies_subtitles->sub_language }}</a>
                                       &nbsp;&nbsp;&nbsp;
                                       <a class="iq-bg-danger" data-toggle="tooltip" data-placement="top" title=""
                                          data-original-title="Delete" onclick="return confirm('Are you sure?')" href="{{ URL::to('admin/subtitle/delete') . '/' . $movies_subtitles->id }}">
                                          <img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/delete.svg';  ?>"></a>
                                    @endif

                                    @endforeach
                                 @endif

                                 <input class="mt-1" type="file" name="subtitle_upload[]" id="subtitle_upload_{{ $subtitle->short_code }}">
                                 <input class="mt-1"  type="hidden" name="short_code[]" value="{{ $subtitle->short_code }}">
                                 <input class="mt-1"  type="hidden" name="sub_language[]" value="{{ $subtitle->language }}">
                              </div>
                           </div>
                        @endforeach
                     </div> 
                  </div>
               </div>
               </div> <input type="button" name="next" class="next action-button" value="Next" id="next3"/> 
               <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
               <button type="submit" class="btn btn-primary" style = "margin-left: 26%;position: absolute;margin-top: .8%;" value="{{ $button_text }}">{{ $button_text }}</button>
               </fieldset>
               <fieldset id="video_access_data">
               <div class="form-card">

               {{-- <div class="row">
                  <div class="col-7">
                     <h2 class="fs-title">Video Access </h2>
                  </div>
               </div>  --}}

               {{-- <div class="row">
                  <div class="col-md-4">
                     <label class="m-0">Recommendations</label>
                     <input type="text" class="form-control" id="Recommendation " name="Recommendation" value="@if(!empty($video->Recommendation)){{ $video->Recommendation }}@endif">
                  </div> 
               </div> --}}

               <div class="row">
                   <div class="col-sm-12">
                    <h2 class="fs-title">Geo-location for Videos</h2>
               </div>

               <!-- {{-- Block country --}} -->
               <div class="col-sm-6 form-group">
                   <label class="m-0">Block Country</label>
                     <select  name="country[]" class="js-example-basic-multiple" style="width: 100%;" multiple="multiple">
                     <option value="All">Select Country </option>
                        @foreach($countries as $country)
                           @if(in_array($country->country_name, $block_countries))
                              <option value="{{ $country->country_name  }}" selected="true">{{ $country->country_name }}</option>
                           @else
                              <option value="{{ $country->country_name  }}">{{$country->country_name }}</option>
                           @endif 
                        @endforeach
                     </select>
               </div>

                  <!-- {{-- country --}} -->
                  <div class="col-sm-6 form-group">
                     <label class="m-0">Available Country</label>
                     <select  name="video_country[]" class="js-example-basic-multiple" style="width: 100%;" multiple="multiple">
                        <option value="All"> Select Country </option>
                        @foreach($countries as $country) 
                           <option value="{{ $country->country_name }}" @if( !empty(json_decode($video->country)) && in_array( $country->country_name, json_decode($video->country) ))selected='selected' @endif >{{ $country->country_name }}</option>
                        @endforeach
                     </select>
                  </div>
               </div>

               <div class="row">
                  <div class="col-sm-6 form-group mt-3">
                     <label class="m-0">User Access</label>
                     <select id="access" name="access"  class="form-control" >
                        <option value="guest" @if(!empty($video->access) && $video->access == 'guest'){{ 'selected' }}@endif>Guest (everyone)</option>

                        <option value="subscriber" @if(!empty($video->access) && $video->access == 'subscriber'){{ 'selected' }}@endif>Subscriber ( Must subscribe to watch )</option>

                        <option value="registered" @if(!empty($video->access) && $video->access == 'registered'){{ 'selected' }}@endif>Registered Users( Must register to watch )</option>   

                        @if($settings->ppv_status == 1)
                           <option value="ppv" @if(!empty($video->access) && $video->access == 'ppv'){{ 'selected' }}@endif>PPV Users (Pay per movie)</option>   
                        @else
                           <option value="ppv" @if(!empty($video->access) && $video->access == 'ppv'){{ 'selected' }}@endif>PPV Users (Pay per movie)</option>   
                        @endif
                        
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
                                 <option value="{{ $Inapp_Purchase->product_id }}"  @if($video->ios_ppv_price == $Inapp_Purchase->product_id) selected='selected' @endif >{{ $Inapp_Purchase->plan_price }}</option>
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
               <div class="row">
                   <div class="col-sm-6 form-group mt-3" id="ppv_price">
                       <?php if($settings->ppv_status == 1){ ?>
                            <label for="global_ppv">Get Pricing from Global PPV Rates Set:</label>
                            <input type="checkbox" name="global_ppv" id="global_ppv"  {{$video->global_ppv == '1' ? 'checked' : ''}}  />
                       <?php } else{ ?>
                            <div class="global_ppv_status">
                                <label for="global_ppv">Get Pricing from Global PPV Rates Set:</label>
                                <input type="checkbox" name="global_ppv" id="global_ppv" {{$video->global_ppv == '1' ? 'checked' : ''}}   />
                            </div>
                       <?php } ?>
                   </div>


                   <div id="ppv_options" style="display: none;">
                     <input type="radio" name="ppv_option" id="ppv_gobal_price" value="1" {{ ($video->ppv_option == 1)? "checked" : "" }}>
                     <label for="ppv_gobal_price">Set Global Price</label><br>
                     <input type="radio" name="ppv_option" id="global_ppv_price" value="2" {{ ($video->ppv_option == 2)? "checked" : "checked" }}>
                     <label for="global_ppv_price">Get Settings Global Price</label>
                  </div>

                  <div id="price_input_container" class="col-sm-6 form-group mt-3" style="display: none;">
                     <label for="ppv_price">Enter Global Price:</label>
                     <input type="text" class="form-control" name="set_gobal_ppv_price" id="set_gobal_ppv_price" placeholder="Enter price" value="{{ $video->ppv_price  }}">
                  </div>

                   <div class="col-sm-6 form-group mt-3" id="ppv_price">
                  <label for="">  Search Tags</label>
                     <input type="text" id="tag-input1" class="tagged form-control1" data-removeBtn="true" name="searchtags" >
                     <!-- <input type="text" class="form-control" id="#inputTag" name="searchtags" value="" data-role="tagsinput"> -->
                  </div>
               </div>

            
                  <div class="row">
                     <div class="col-sm-6 form-group" >
                        <label class="m-0">Related Videos :</label>
                        <select  name="related_videos[]" class="form-control js-example-basic-multiple" style="width: 100%;" multiple="multiple">
                           @foreach($related_videos as $related_video)
                              @if(in_array($related_video->id, $all_related_videos))
                                 <option value="{{ $related_video->id }}" selected="true">{{ $related_video->title }}</option>
                              @else
                                 <option value="{{ $related_video->id }}"  > {{ $related_video->title }}</option>
                              @endif   
                           @endforeach
                        </select>
                     </div>
                  </div>

            
                   <div class="row">
                       <div class="col-sm-6 "> 
                           <div class="panel panel-primary" data-collapsed="0"> 
                               <div class="panel-heading"> 
                                   <div class="panel-title">
                                        <label class="m-0"><h3 class="fs-title">Status Settings</h3> </label>
                                   </div> 
                                   <div class="panel-options"> 
                                        <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> 
                                   </div>
                               </div> 
                               <div class="panel-body"> 
                                   <div>
                                        <label class="" for="featured">Enable this video as Featured:</label>
                                        <input type="checkbox" @if(!empty($video->featured) && $video->featured == 1){{ 'checked="checked"' }}@endif name="featured" value="1" id="featured" />
                                   </div>

                                   <div class="clear"></div>

                                   <div>
                                       <label class="" for="active">Enable this Video:</label>
                                       <input type="checkbox" @if(!empty($video->active) && $video->active == 1){{ 'checked="checked"' }}@elseif(!isset($video->active)){{ 'checked="checked"' }}@endif name="active" value="1" id="active" />
                                   </div>

                                    <div class="clear"></div>
                                   <div>

                                       <label class="" for="banner">Enable this Video as Slider:</label>
                                       <input type="checkbox" @if(!empty($video->banner) && $video->banner == 1){{ 'checked="checked"' }}@elseif(!isset($video->banner)){{ 'checked="checked"' }}@endif name="banner" value="1" id="banner" />
                                   </div>
                                   <div class="clear"></div>

                                    <div>
                                       <label class="" for="banner">Enable this Today Top Video :</label>
                                       <input type="checkbox" name="today_top_video" value={{ $video->today_top_video }}  {{ $video->today_top_video ? 'checked' : null }}/>
                                    </div>

                                    <div class="clear"></div>
                               </div> 
                           </div>
                       </div>
                   </div>
                </div> 

                            <input type="button" name="next" class="next action-button" value="Next" id="nextppv" />
                            <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                            <button type="submit" class="btn btn-primary "style = "margin-left: 26%;position: absolute;margin-top: .8%;" value="{{ $button_text }}">{{ $button_text }}</button>
  
               </fieldset>

               <fieldset id="upload_datas">
                  <div class="form-card">
                        <div class="row">
                           <div class="col-7">
                                 <h2 class="fs-title">Image Upload:</h2>
                           </div>
                           <div class="col-5"></div>
                        </div>

                        <div class="row">
                           <div class="col-sm-6 form-group">
                              <div id="VideoImagesContainer" class="gridContainer mt-3"></div>
                              @php 
                                 $width = $compress_image_settings->width_validation_videos;
                                 $heigth = $compress_image_settings->height_validation_videos;
                              @endphp
                              @if($width !== null && $heigth !== null)
                                 <p class="p1">{{ ("Video Thumbnail (".''.$width.' x '.$heigth.'px)')}}:</p> 
                              @else
                                 <p class="p1">{{ "Video Thumbnail ( 720X1280px )"}}:</p> 
                              @endif
                              <input type="file" name="image" id="image" accept="image/png, image/webp, image/jpeg"/>
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
                              <div id="VideoPlayerImagesContainer" class="gridContainer mt-3"></div>
                              @php 
                                 $player_width = $compress_image_settings->width_validation_player_img;
                                 $player_heigth = $compress_image_settings->height_validation_player_img;
                              @endphp
                              @if($player_width !== null && $player_heigth !== null)
                                 <p class="p1">{{ ("Player Thumbnail (".''.$player_width.' x '.$player_heigth.'px)')}}:</p> 
                              @else
                                 <p class="p1">{{ "Player Thumbnail ( 1280X720px )"}}:</p> 
                              @endif
                              <div class="panel-body">
                                 <input type="file" name="player_image" id="player_image" accept="image/png, image/webp, image/jpeg"/>
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

                        {{-- Video TV Thumbnail --}}

                        <div class="row">
                           <div class="col-sm-6 form-group">
                              <div id="VideoTVImagesContainer" class="gridContainer mt-3"></div>
                              <label class="mb-1">  Video TV Thumbnail  </label><br>
                              <input type="file" name="video_tv_image" id="video_tv_image" >
                              <span><p id="tv_image_image_error_msg" style="color:red;" >* Please upload an image with 1920 X 1080 pixels dimension or 16:9 ratio </p></span>
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
                                 <div class="col-sm-8 p-0">
                                    <img src="{{ URL::to('/') . '/public/uploads/images/' .$video->video_title_image }}" class="video-img w-100 mt-1" />
                                 </div>
                              @endif
                           </div>

                           <div class="col-sm-6 form-group">
                              <label class="mb-1">Enable Video Title Thumbnail </label><br>
                              <div class="mt-1">
                                 <label class="switch">
                                    <input name="enable_video_title_image" class="" id="enable_video_title_image" type="checkbox" @if( $video->enable_video_title_image == "1") checked  @endif >
                                    <span class="slider round"></span>
                                 </label>
                              </div>
                           </div>
                        </div>
                  
                      <div class="row mb-4">

                        <div class="col-7">
                           <h2 class="fs-title">Trailer Upload:</h2>
                           <label class="m-0">Video Trailer Type:</label>
                           <select  class="trailer_type form-control"  style="width: 100%;" class="" name="trailer_type" id="trailer_type">    
                              <option   value="null"> Select the Video Trailer Type </option>
                              <option  @if( $video->trailer_type == 'video_mp4' || $video->trailer_type == 'm3u8' ) {{ 'selected' }} @endif value="video_mp4" >Video Upload</option>
                              <!-- <option {{ $video->trailer_type == 'video_mp4' ? 'selected' : '' }}  value="video_mp4"> Video Upload </option> -->
                              <option @if( $video->trailer_type == 'm3u8_url' ) {{ 'selected' }} @endif   value="m3u8_url">  m3u8 Url </option>
                              <option @if( $video->trailer_type == 'mp4_url' ) {{ 'selected' }} @endif    value="mp4_url">   mp4 Url</option>
                              <option @if( $video->trailer_type == 'embed_url' ) {{ 'selected' }} @endif  value="embed_url">  Embed Code</option>
                           </select>
                        </div>
                     </div>

                     <div class="selected-options">
                           <div class="row trailer_m3u8_url">
                              <div class="col-sm-6 form-group" >
                                 <label class="m-0"> Trailer m3u8 Url :</label>
                                 <input type="text" class="form-control" name="m3u8_trailer" id="" value="@if(!empty($video->trailer) && $video->trailer_type == 'm3u8_url' ){{ $video->trailer }}@endif">
                                 @if($video->trailer_type !=null && $video->trailer_type == "m3u8_url" )
                                    <video id="videoPlayer1" width="560" height="315" controls>
                                       <source src="{{ $video->trailer }}" type="application/x-mpegURL">
                                    </video>
                                 @endif

                              </div>
                           </div>

                     
                           <div class="row trailer_mp4_url">
                              <div class="col-sm-6 form-group" >
                                 <label class="m-0"> Trailer mp4 Url :</label>
                                 <input type="text" class="form-control" name="mp4_trailer" id="" value="@if(!empty($video->trailer) && $video->trailer_type == 'mp4_url' ){{ $video->trailer }}@endif">

                                 @if(!empty($video->trailer) && $video->trailer != '' && $video->trailer_type != null &&  $video->trailer_type == 'mp4_url'  )
                                    <video width="560" height="315" controls>
                                       <source src="{{ $video->trailer }}" type="video/mp4" />
                                    </video>
                                 @endif
                              </div>
                           </div>

                           <div class="row trailer_embed_url">
                              <div class="col-sm-6 form-group" >
                                 <label class="m-0">Trailer Embed Code :</label>
                                 <input type="text" class="form-control" name="embed_trailer" id="" value="@if(!empty($video->trailer) && $video->trailer_type == 'embed_url' ){{ $video->trailer }}@endif">

                                 @if(!empty($video->trailer) && $video->trailer != '' && $video->trailer_type != null &&  $video->trailer_type == 'embed_url' )
                                    <iframe width="560" height="315"  src="{{ $video->trailer }}" frameborder="0" allowfullscreen></iframe>
                                 @endif

                              </div>
                           </div>


                        <div class="row trailer_video_upload">
                              <div class="col-sm-8 form-group">
                                 <label class="m-0">Upload Trailer :</label><br />
                                 <div class="new-video-file form_video-upload" style="position: relative;" @if(!empty($video->type) && $video->type == 'upload') style="display:none" @else style="display:block" @endif >
                                    <input type="file" accept="video/mp4,video/x-m4v,video/*" name="trailer" id="trailer" />
                                    <p style="font-size: 14px !important;">Drop and drag the video file</p>
                                 </div>
                                 <!-- <span id="remove" class="danger">Remove</span> -->
                           </div>
                           <!-- <input type="file" accept="video/mp4,video/x-m4v,video/*" name="trailer" id="trailer" >
                                 <span id="remove" class="danger">Remove</span> -->
                              <div class="col-sm-8 mt-5 form-group">
                                 <!--<p>Upload Trailer video</p>-->
                                 @if(!empty($video->trailer) && $video->trailer != '' && $video->trailer_type != null &&  $video->trailer_type == 'video_mp4' )
                                 <video width="500" height="200" controls>
                                    <source src="{{ $video->trailer }}" type="video/mp4" />
                                 </video>
                                 @elseif(!empty($video->trailer) && $video->trailer != '' && $video->trailer_type != null &&  $video->trailer_type == 'm3u8' )
                                 <video  id="videom3u8"width="50" height="50" controls type="application/x-mpegURL">
                              <source type="application/x-mpegURL" src="{{ $video->trailer }}">
                                 </video>
                                 @endif
                           </div>
                        </div>
                     </div>

                    

                     <div class="row mt-3">
                        <div class="col-sm-8  form-group">
                           <label class="m-0">Trailer Description:</label>
                           <textarea  rows="5" class="form-control mt-2" name="trailer_description" id="trailer-ckeditor"
                              placeholder="Description">@if(!empty($video->trailer_description)){{ ($video->trailer_description) }}@endif
                           </textarea>
                        </div>
                     </div>

                  </div>
                  <input type="button" name="next" class="next action-button update_upload_img" value="Next" />
                  <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                  <button type="submit" class="btn btn-primary update_upload_img" style = "margin-left: 26%;position: absolute;margin-top: .8%;" value="{{ $button_text }}">{{ $button_text }}</button>
              </fieldset>
              <fieldset id="ads_data">
               {{-- ADS Management --}}
                     
                     <input type="hidden" id="selectedImageUrlInput" name="selected_image_url" value="">
                     <input type="hidden" id="videoImageUrlInput" name="video_image_url" value="">
                     <input type="hidden" id="SelectedTVImageUrlInput" name="selected_tv_image_url" value="">
                     <input type="hidden" name="_token" value="<?= csrf_token() ?>" />

                     @include('admin.videos.create_edit_ads_fieldset')

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
   
   body.light #progressbar li.active ,#progressbar li.active {
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

   /* #progressbar li.active:before, #progressbar li.active:after {
   background: #48bbe5;
   } */
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
                           $('#price').hide();
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
    var globalPpvPriceRadio = document.getElementById('global_ppv_price');
    var ppvPriceInput = document.getElementById('set_gobal_ppv_price');

    // Show/hide the radio buttons based on the initial state of the checkbox
    ppvOptionsDiv.style.display = globalPpvCheckbox.checked ? 'block' : 'none';

    // Show the price input container if ppv_price is not empty
    if (ppvPriceInput.value.trim() !== '') {
        priceInputContainer.style.display = 'block';
        ppvGlobalPriceRadio.checked = true;
    }

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


$(document).ready(function($){
   // validation Skip 
      $('#error_intro_start_time').hide();
      $('#error_intro_end_time').hide();
      $('#error_skip_intro_time').hide();
      $('#player_image_error_msg,#tv_image_image_error_msg').hide();
      $('#image_error_msg').hide();

      

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

   if( $('.languages').val() == null || $('#video_category_id').val() == null ){

      if($('.languages').val() == null){
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
</script>

<script src="<?= URL::to('/assets/js/jquery.mask.min.js');?>"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

<script type="text/javascript">

   $(document).ready(function($){
      $('#duration').mask("00:00:00");
      $('#intro_start_time').mask("00:00:00");
      $('#intro_end_time').mask("00:00:00");
      $('#recap_start_time').mask("00:00:00");
      $('#recap_end_time').mask("00:00:00");
      $('#skip_intro').mask("00:00:00");
      $('#skip_recap').mask("00:00:00");
      $('#url_linktym').mask("00:00:00");
      $("#free_duration").mask("00:00:00");

      $("#video_js_mid_advertisement_sequence_time").mask("00:00:00");
      $("#andriod_mid_sequence_time").mask("00:00:00");
      $("#ios_mid_sequence_time").mask("00:00:00");
      $("#tv_mid_sequence_time").mask("00:00:00");
      $("#samsung_mid_sequence_time").mask("00:00:00");
      $("#lg_mid_sequence_time").mask("00:00:00");
      $("#roku_mid_sequence_time").mask("00:00:00");
   });
</script>

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
            if(data.processed_low == null && data.watermark_transcoding_progress == 1){
   			$('.low_percent').html('Watermark encoding on the video, Transcoding will be started after watermark encoding completed.');
            }else if(data.processed_low == null){
   			$('.low_percent').html('Transcoding is Queued. Waiting for Server to Respond');
            }else{
   			$('.low_percent').html(data.processed_low+'%');
            }
   		});
   	}, 3000);
   }


   if (($("#page").val() == 'Edit') && ($("#status").val() == 0)) {
   	setInterval(function(){ 
   		$.getJSON('<?php echo URL::to("/admin/get_compression_processed_percentage/");?>'+'/'+$("#id").val(), function(data) {
   			$('.Compression_low_bar').width(data.stream_path+'%');
            if(data.stream_path == null){
   			$('.Compression_low_percent').html('Video Compression is Queued. Waiting for Server to Respond');
            }else{
   			$('.Compression_low_percent').html(data.stream_path+'%');
            }
            if (data.stream_path == 100) {
                $('.CompressionVideo').hide();
                clearInterval(interval); 
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

      $.ajax({
        url: '{{ URL::to('admin/videos/extractedimage') }}',
        type: "post",
        data: {
            _token: '{{ csrf_token() }}',
            video_id : "{{ $video->id }}",
        },
        success: function(value) {
            // console.log(value.ExtractedImage.length);

            if (value && value.ExtractedImage.length > 0) {
                $('#VideoImagesContainer').empty();
                $('#VideoPlayerImagesContainer').empty();
                var ExtractedImage = value.ExtractedImage;
                var previouslySelectedElement = null;
                var previouslySelectedVideoImag = null;
                var previouslySelectedTVImage = null;

                ExtractedImage.forEach(function(Image, index) {
                    var imgElement = $('<div class="gridItem"><img src="' + Image.image_path + '" class="ajax-image m-1 w-100 h-100" /></div>');
                    var VideoPlayerImagesContainer = $('<div class="gridItem"><img src="' + Image.image_path + '" class="video-image m-1 w-100 h-100" /></div>');
                    var VideoTVImagesContainer = $('<div class="gridItem"><img src="' + Image.image_path + '" class="tv-video-image m-1 w-100 h-100" /></div>');

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
                     // if (index === 0) {
                     //       imgElement.click();
                     // }
                    $('#VideoImagesContainer').append(imgElement);

                    VideoPlayerImagesContainer.click(function() {
                        $('.video-image').css('border', 'none');
                        if (previouslySelectedVideoImag) {
                           previouslySelectedVideoImag.css('border', 'none');
                        }
                        VideoPlayerImagesContainer.css('border', '2px solid red');
                        
                        var clickedImageUrl = Image.image_path;

                        var VideoImageUrl = Image.image_original_name;
                        // console.log('SelectedImageUrl Image URL:', SelectedImageUrl);
                        previouslySelectedVideoImag = $(this);

                        $('#videoImageUrlInput').val(VideoImageUrl);
                    });

                  //   if (index === 0) {
                  //    VideoPlayerImagesContainer.click();
                  //    }

                    $('#VideoPlayerImagesContainer').append(VideoPlayerImagesContainer);

                    VideoTVImagesContainer.click(function() {
                        $('.tv-video-image').css('border', 'none');
                        if (previouslySelectedTVImage) {
                           previouslySelectedTVImage.css('border', 'none');
                        }
                        VideoTVImagesContainer.css('border', '2px solid red');
                        
                        var clickedImageUrl = Image.image_path;

                        var TVImageUrl = Image.image_original_name;
                        previouslySelectedTVImage = $(this);

                        $('#SelectedTVImageUrlInput').val(TVImageUrl);
                  });

                  // if (index === 0) {
                  //    VideoTVImagesContainer.click();
                  // }

                  $('#VideoTVImagesContainer').append(VideoTVImagesContainer);


                });
            } else {
                     var SelectedImageUrl = '';

                     $('#selectedImageUrlInput').val(SelectedImageUrl);
                    $('#videoImageUrlInput').val(SelectedImageUrl);
                    $('#SelectedTVImageUrlInput').val(SelectedImageUrl);
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

      // $('#player_data').hide();
      // $('#slug_validate').hide();
      // $('#videocategory_data').hide();
      // $('#video_access_data').hide();
      // $('#upload_datas').hide();
      // $('#ads_data').hide();

   // Function to handle tab switching
   function switchTab(tabId, progressWidth) {
      $(".progress-bar").css({ "width": progressWidth });
      
      // Hide all sections
      $('#player_data').hide();
      $('#slug_validate').hide();
      $('#videocategory_data').hide();
      $('#video_access_data').hide();
      $('#upload_datas').hide();
      $('#ads_data').hide();

      // Show the current section
      $(tabId).show();
   }

   // Tab click event handlers
   $('#videot').click(function() {
      switchTab('#player_data', '17%');
      $('#player_data').css('opacity','1');
      $("#videot").addClass("active");
   });

   $('#account').click(function() {
      switchTab('#slug_validate', '33%');
      $('#slug_validate').css('opacity','1');
      $("#account").addClass("active");
   });

   $('#personal').click(function() {
      switchTab('#videocategory_data', '50%');
      $('#videocategory_data').css('opacity','1');
      $("#personal").addClass("active");
   });

   $('#useraccess_ppvprice').click(function() {
      switchTab('#video_access_data', '67%');
      $('#video_access_data').css('opacity','1');
      $("#useraccess_ppvprice").addClass("active");
   });

   $('#payment').click(function() {
      switchTab('#upload_datas', '83%');
      $('#upload_datas').css('opacity','1');
      $("#payment").addClass("active");
   });

   $('#confirm').click(function() {
      switchTab('#ads_data', '100%');
      $('#ads_data').css('opacity','1');
      $('#ads_eidt_files').css('opacity','1');
      $('#ads_eidt_files').show();
   });

});
   $(document).ready(function($){
      
      $("#inputTag").tagsinput('items');
      
      $('.js-example-basic-multiple').select2();
      $('.js-example-basic-single').select2();
   });

   $(document).ready(function() {

      $('.ads_devices').select2();

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
                     
                     
                  // Add cases for other devices if needed
                  default:
                     break;
               }
         });
      });
   });


   
   $('#publishlater').hide();
   
   $(document).ready(function(){
   
   
   
   $('#publishlater').hide();
   $('#publish_now').click(function(){
   	// alert($('#publish_now').val());
   	$('#publishlater').hide();
   });
   $('#publish_later').click(function(){
   	// alert($('#publish_later').val());
   	$('#publishlater').show();
   });
   
   if($("#publish_now").val() == 'publish_now'){
   $('#publishlater').show();
   }else if($("#publish_later").val() == 'publish_later'){
   	$('#publishlater').hide();		
   }
   });
   
   
   $(document).ready(function(){
   
      
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
          $(document).ready(function(){
      // $('#ppv_price').hide();
      // $('#global_ppv_status').hide();

      var enable_ppv_plans = Number('<?= @$theme_settings->enable_ppv_plans ?>');
      var transcoding_access = Number('<?= @$settings->transcoding_access ?>');

      if (enable_ppv_plans === 1 && transcoding_access === 1) {

         if ($("#access").val() === 'ppv') {
            $('#quality_ppv_price').show();
            $('#global_ppv_status').hide();
            $('#ppv_price').hide();

         } else {
            $('#quality_ppv_price').hide();
            $('#global_ppv_status').hide();
            $('#ppv_price').hide();
         }

      } else {
         if ($("#access").val() === 'ppv') {
            $('#ppv_price').show();
            $('#global_ppv_status').show();
            $('#quality_ppv_price').hide();
         } else {
            $('#ppv_price').hide();
            $('#global_ppv_status').hide();
            $('#quality_ppv_price').hide();
         }
      }

      
      
   	$("#access").change(function(){

         
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
                  $('#global_ppv_status').hide();
         
               }else{
                  $('#ppv_price').hide();		
                  $('#global_ppv_status').show();				
         
               }
            }
   	   });
      });
   
   // alert();
   
   
   
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


   
   $(document).ready(function(){
         $('.trailer_video_upload').hide();
         $('.trailer_m3u8_url').hide();
         $('.trailer_mp4_url').hide();
         $('.trailer_embed_url').hide();

      var trailer_types = <?php echo json_encode($video['trailer_type']); ?>;

      if( trailer_types == 'video_mp4'){
         $('.trailer_video_upload').show();

      }else if(trailer_types == 'm3u8_url'){
         $('.trailer_m3u8_url').show();

      }else if(trailer_types == 'mp4_url'){
         $('.trailer_mp4_url').show();
      }
      else if(trailer_types == 'embed_url'){
         $('.trailer_embed_url').show();
      }


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
   //  document.getElementById('image').addEventListener('change', function() {
   //      var file = this.files[0];
   //      if (file) {
   //          var img = new Image();
   //          img.onload = function() {
   //              var width = img.width;
   //              var height = img.height;
   //              console.log(width);
   //              console.log(height);
                
   //              var validWidth = {{ $compress_image_settings->width_validation_videos }};
   //              var validHeight = {{ $compress_image_settings->height_validation_videos }};
   //              console.log(validWidth);
   //              console.log(validHeight);

   //              if (width !== validWidth || height !== validHeight) {
   //                  document.getElementById('video_image_error_msg').style.display = 'block';
   //                  $('.update_upload_img').prop('disabled', true);
   //                  document.getElementById('video_image_error_msg').innerText = 
   //                      `* Please upload an image with the correct dimensions (${validWidth}x${validHeight}px).`;
   //              } else {
   //                  document.getElementById('video_image_error_msg').style.display = 'none';
   //                  $('.update_upload_img').prop('disabled', false);
   //              }
   //          };
   //          img.src = URL.createObjectURL(file);
   //      }
   //  });

   //  document.getElementById('player_image').addEventListener('change', function() {
   //      var file = this.files[0];
   //      if (file) {
   //          var img = new Image();
   //          img.onload = function() {
   //              var width = img.width;
   //              var height = img.height;
   //              console.log(width);
   //              console.log(height);
                
   //              var validWidth = {{ $compress_image_settings->width_validation_player_img }};
   //              var validHeight = {{ $compress_image_settings->height_validation_player_img }};
   //              console.log(validWidth);
   //              console.log(validHeight);
                
   //              if (width !== validWidth || height !== validHeight) {
   //                  document.getElementById('player_image_error_msg').style.display = 'block';
   //                  $('#useraccess_ppvprice').prop('disabled', true);
   //                  document.getElementById('player_image_error_msg').innerText = 
   //                      `* Please upload an image with the correct dimensions (${validWidth}x${validHeight}px).`;
   //              } else {
   //                  document.getElementById('player_image_error_msg').style.display = 'none';
   //                  $('.update_upload_img').prop('disabled', false);
   //              }
   //          };
   //          img.src = URL.createObjectURL(file);
   //      }
   //  });

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
                  `* Please upload an image with the correct dimensions (${valid_player_Width}x${valid_player_Height}px).`;
         } else {
               document.getElementById('player_image_error_msg').style.display = 'none';
               $('.update_upload_img').prop('disabled', false);
         }
         }
      });
   });

   </script>

   <script>

   (function() {

        "use strict"

        // Plugin Constructor
        var TagsInput = function(opts) {
            this.options = Object.assign(TagsInput.defaults, opts);
            this.init();
        }

        // Initialize the plugin
        TagsInput.prototype.init = function(opts) {
            this.options = opts ? Object.assign(this.options, opts) : this.options;

            if (this.initialized)
                this.destroy();

            if (!(this.orignal_input = document.getElementById(this.options.selector))) {
                console.error("tags-input couldn't find an element with the specified ID");
                return this;
            }

            this.arr = [];
            this.wrapper = document.createElement('div');
            this.input = document.createElement('input');
            init(this);
            initEvents(this);

            this.initialized = true;
            return this;
        }

        // Add Tags
        TagsInput.prototype.addTag = function(string) {

            if (this.anyErrors(string))
                return;

            this.arr.push(string);
            var tagInput = this;

            var tag = document.createElement('span');
            tag.className = this.options.tagClass;
            tag.innerText = string;

            var closeIcon = document.createElement('a');
            closeIcon.innerHTML = '&times;';

            // delete the tag when icon is clicked
            closeIcon.addEventListener('click', function(e) {
                e.preventDefault();
                var tag = this.parentNode;

                for (var i = 0; i < tagInput.wrapper.childNodes.length; i++) {
                    if (tagInput.wrapper.childNodes[i] == tag)
                        tagInput.deleteTag(tag, i);
                }
            })


            tag.appendChild(closeIcon);
            this.wrapper.insertBefore(tag, this.input);
            this.orignal_input.value = this.arr.join(',');

            return this;
        }

        // Delete Tags
        TagsInput.prototype.deleteTag = function(tag, i) {
            tag.remove();
            this.arr.splice(i, 1);
            this.orignal_input.value = this.arr.join(',');
            return this;
        }

        // Make sure input string have no error with the plugin
        TagsInput.prototype.anyErrors = function(string) {
            if (this.options.max != null && this.arr.length >= this.options.max) {
                console.log('max tags limit reached');
                return true;
            }

            if (!this.options.duplicate && this.arr.indexOf(string) != -1) {
                console.log('duplicate found " ' + string + ' " ')
                return true;
            }

            return false;
        }

        // Add tags programmatically 
        TagsInput.prototype.addData = function(array) {
            var plugin = this;

            array.forEach(function(string) {
                plugin.addTag(string);
            })
            return this;
        }

        // Get the Input String
        TagsInput.prototype.getInputString = function() {
            return this.arr.join(',');
        }

        // destroy the plugin
        TagsInput.prototype.destroy = function() {
            this.orignal_input.removeAttribute('hidden');

            delete this.orignal_input;
            var self = this;

            Object.keys(this).forEach(function(key) {
                if (self[key] instanceof HTMLElement)
                    self[key].remove();

                if (key != 'options')
                    delete self[key];
            });

            this.initialized = false;
        }

        // Private function to initialize the tag input plugin
        function init(tags) {
            tags.wrapper.append(tags.input);
            tags.wrapper.classList.add(tags.options.wrapperClass);
            tags.orignal_input.setAttribute('hidden', 'true');
            tags.orignal_input.parentNode.insertBefore(tags.wrapper, tags.orignal_input);
        }

        // initialize the Events
        function initEvents(tags) {
            tags.wrapper.addEventListener('click', function() {
                tags.input.focus();
            });

            tags.input.addEventListener('keydown', function(e) {
                if (!!(~[9, 13, 188].indexOf(e.keyCode))) {
                    e.preventDefault();
                    var str = tags.input.value.trim();
                    if (str == "") return;
                    str.split(",").forEach(function(tag) {
                        tags.addTag(tag.trim());
                    });
                    tags.input.value = "";
                }

            });
        }


        // Set All the Default Values
        TagsInput.defaults = {
            selector: '',
            wrapperClass: 'tags-input-wrapper',
            tagClass: 'tag',
            max: null,
            duplicate: false
        }

        window.TagsInput = TagsInput;

    })();

        
    var tagInput1 = new TagsInput({
        selector: 'tag-input1',
        duplicate : false,
        max : 10
    });

    var tagsdata = '<?= $video->search_tags ?>';
	

	if(tagsdata == ""){
            tagInput1.addData([])
    }
    else{
        var search_tag = "<?= $video->search_tags ?>";
        var tagsArray = search_tag.split(',');

        for (var i = 0; i < tagsArray.length; i++) {
            tagInput1.addData([tagsArray[i]]);
        }
   }
		

   </script>

@include('admin.videos.Ads_edit_videos')

@section('javascript')
@stop
@stop

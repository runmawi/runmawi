@extends('admin.master')
@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop
<?php
   $embed_url = URL::to('/category/videos/embed');
   $embed_media_url = $embed_url . '/' . $video->slug;
   $url_path = '<iframe width="853" height="480" src="'.$embed_media_url.'" frameborder="0" allowfullscreen></iframe>';
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
                       <a class="black" href="{{ URL::to('admin/videos/categories') }}">Manage Video Categories</a></div>
<div id="content-page" class="">
<div class="container-fluid p-0">
<div class="row">
<div class="col-sm-12">
<div class="iq-card">
<div class="iq-card-header d-flex justify-content-between">
   <div class="iq-header-title">
      <h4 class="card-title">Add Video</h4>
   </div>
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

<h5 class="p-1 mt-3 ml-3" style="font-weight: normal;">Video Info Details</h5>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<div >
<div class="container-fluid">
   <div class="row ">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center p-0  mb-2">
         <div class="px-0  pb-0  mb-3 col-md-12">
            <form id="msform" method="POST" action="{{ $post_route }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">
               <!-- progressbar -->
               <ul id="progressbar">
                  @if($video->status == 1)
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
               @if($video->status == 1)
               <fieldset>
                  <div class="form-card">
                     <div class="row">
                        <div class="col-6">
                           <h2 class="fs-title p-0">Video Player</h2>
                        </div>
                        <div class="col-6">
                            <label for=""><h3 class="fs-title m-0">Player Embed Link:</h3></label>
                            <p>Click <a href="#"onclick="EmbedCopy();" class="share-ico"><i class="ri-links-fill"></i> here</a> to get the Embedded URL</p>
                        </div>
                     </div>
                      <div id="video_container" class="fitvid" atyle="z-index: 9999;">
                        @if($video->type == 'mp4_url')
                           <video id="videoPlayer"  class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'  type="video/mp4">
                              <source src="<?php if(!empty($video->mp4_url)){   echo $video->mp4_url; }else {  echo $video->trailer; } ?>"  type='video/mp4' label='auto' >
                           </video>
                           @elseif ($video->type == 'm3u8_url')
                           <video  id="videoPlayer" class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' src="<?php echo $video->trailer; ?>"  type="video/mp4" >
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
                           <video id="video"  controls crossorigin playsinline poster="<?= URL::to('/') . '/public/uploads/images/' . $video->image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' >
                              <source 
                                 type="application/x-mpegURL" 
                                 src="<?php echo URL::to('/storage/app/public/').'/'.$video->path . '.m3u8'; ?>"
                                 >
                           </video>
                        
                        @endif
                        </div>
<!--
                          <div class="col-6 text-center">
                              <p>@if(!empty($video->title)){{ $video->title }}@endif</p>
                              <p>@if(!empty($video->description)){{ strip_tags($video->description) }}@endif</p>
                              <p>$video->title</p>
                              <p>$video->title</p>
                          </div>
-->

                      </div> 
                     <input type="button" name="next" class="next action-button" id="nextplayer" value="Next"  /> 
               </fieldset>
               @endif
               <fieldset>
               <div class="form-card">
              
               <div class="row">
                   <div class="col-sm-6 form-group" >
                        <label class="m-0">Title :</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="@if(!empty($video->title)){{ $video->title }}@endif">
                   </div>
               <div class="col-sm-6 form-group" >
               <label class="m-0">
               Video Slug <a class="iq-bg-warning" data-toggle="tooltip" data-placement="top" title="Please enter the URL Slug" data-original-title="Please enter the URL Slug" href="#">
               <i class="las la-exclamation-circle"></i></a>:</label>
               <input type="text"   class="form-control" name="slug" id="slug" placeholder="Video Slug" value="@if(!empty($video->slug)){{ $video->slug }}@endif">
               </div>
               </div>
               <div class="row">
               <div class="col-sm-6 form-group">
               <label class="m-0">Age Restrict:</label>
               <select class="form-control" id="age_restrict" name="age_restrict">
               <option selected disabled="">Choose Age</option>
               @foreach($age_categories as $age)
               <option value="{{ $age->age }}" @if(!empty($video->age_restrict) && $age->age == $video->age_restrict)selected="selected"@endif>{{ $age->slug }}</option>
               @endforeach
               </select>
               </div>
               <div class="col-sm-6 form-group ">                                       
               <label class="m-0">Rating:</label>
               <!-- <input type="text" class="form-control" placeholder="Movie Ratings" name="rating" id="rating" value="@if(!empty($video->rating)){{ $video->rating }}@endif" onkeyup="NumAndTwoDecimals(event , this);"> -->
               <select  class="js-example-basic-single" style="width: 100%;" name="rating" id="rating" tags= "true" onkeyup="NumAndTwoDecimals(event , this);" >
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
                        <label class="m-0">Links &amp; Details</label>
                        <textarea   rows="5" class="form-control mt-2" name="details" id="links-ckeditor"
                      placeholder="Link and details">@if(!empty($video->details)){{ htmlspecialchars($video->details) }}@endif</textarea>
                   </div>
               </div>
                <div class="row">
                    <div class="col-sm-4 form-group mt-3">
                        <label class="m-0">Skip Intro Time <small>(Please Give In Seconds)</small></label>
                        <input type="text" class="form-control" id="skip_intro" name="skip_intro" value="@if(!empty($video->skip_intro)){{ $video->skip_intro }}@endif">
                        <span><p id="error_skip_intro_time" style="color:red;">* Fill Skip Intro Time </p></span>
                     </div>
                    <div class="col-sm-4 form-group mt-3">
                        <label class="m-0">Intro Start Time <small>(Please Give In Seconds)</small></label>
                        <input type="text"  class="form-control without" id="intro_start_time" name="intro_start_time" value="@if(!empty($video->intro_start_time)){{ $video->intro_start_time }}@endif" >
                        <span><p id="error_intro_start_time" style="color:red;">* Fill Intro Start Time </p></span>
                    </div>
                    <div class="col-sm-4 form-group mt-3">
                        <label class="m-0">Intro End Time <small>(Please Give In Seconds)</small></label>
                        <input type="text"  class="form-control without" id="intro_end_time" name="intro_end_time" value="@if(!empty($video->intro_end_time)){{ $video->intro_end_time }}@endif" >
                        <span><p id="error_intro_end_time" style="color:red;">* Fill Intro End Time </p></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 form-group mt-3">
                        <label class="m-0">Skip Recap Time <small>(Please Give In Seconds)</small></label> 
                        <input type="text" class="form-control" id="skip_recap" name="skip_recap" value="@if(!empty($video->skip_recap)){{ $video->skip_recap }}@endif">
                        <span><p id="error_skip_recap_time" style="color:red;">* Fill Skip Recap Time </p></span>
                     </div>
                    <div class="col-sm-4 form-group mt-3">
                        <label class="m-0">Recap Start Time <small>(Please Give In Seconds)</small></label>
                        <input type="text"  class="form-control without" id="recap_start_time" name="recap_start_time"  value="@if(!empty($video->recap_start_time)){{ $video->recap_start_time }}@endif">
                        <span><p id="error_recap_start_time" style="color:red;" >* Fill Recap Start Time </p></span>
                    </div>
                    <div class="col-sm-4 form-group mt-3">
                        <label class="m-0">Recap End Time <small>(Please Give In Seconds)</small></label> 
                        <input type="text"  class="form-control without" id="recap_end_time" name="recap_end_time"  value="@if(!empty($video->recap_end_time)){{ $video->recap_end_time }}@endif" >
                        <span><p id="error_recap_end_time" style="color:red;" >* Fill Recap End Time </p></span>
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
               </div> <input type="button" name="next" id="next2" class="next action-button" value="Next" /><input type="button" name="previous" class="previous action-button-previous" value="Previous" />
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
               <span><p id="error_video_Category" style="color:red;" >* Choose the Video Category </p></span>
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
               <select class="form-control js-example-basic-multiple" id="language" name="language[]" style="width: 100%;" multiple="multiple">
               <!-- <option selected disabled="">Choose Language</option> -->
               @foreach($languages as $language)
               @if(in_array($language->id, $languages_id))
               <option value="{{ $language->id }}" selected="true">{{ $language->name }}</option>
               @else
               <option value="{{ $language->id }}" >{{ $language->name }}</option>
               @endif 
               @endforeach
               </select>
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
               <div class="col-sm-4 form-group">
                   <label class="m-0">Reels videos: <small>( Upload the 1 min Videos )</small></label>
                   <input type="file" class="form-group" name="reels_videos" accept="video/mp4,video/x-m4v,video/*" id="" >
                   @if(!empty($video->reelvideo) && $video->reelvideo != null )
                        <video width="200" height="200" controls>
                        <source src="{{ URL::to('/') . '/public/uploads/reelsVideos/' . $video->reelvideo }}" type="video/mp4">
                   </video>
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
               <div class="panel-title col-sm-12"> <h3 class="fs-title">Subtitles (srt or txt)
               <a class="iq-bg-warning" data-toggle="tooltip" data-placement="top" title="Upload Subtitles" data-original-title="Upload Subtitles" href="#">
               <i class="las la-exclamation-circle"></i>
               </a>:</h3>
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
               </div> <input type="button" name="next" class="next action-button" value="Next" id="next3"/> <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
               </fieldset>
               <fieldset>
               <div class="form-card">
               <div class="row">
               <div class="col-7">
               <h2 class="fs-title">Video Access </h2>
               </div>
               </div> 
               <div class="row">
               <div class="col-md-4">
               <label class="m-0">Recommendations</label>
               <input type="text" class="form-control" id="Recommendation " name="Recommendation" value="@if(!empty($video->Recommendation)){{ $video->Recommendation }}@endif">
               </div> 
               </div>
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
                       @if(in_array($country->country_name, $video_artist))
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
               <select  name="video_country" class="form-control" id="country">
                   <option value="All">Select Country </option>
                   @foreach($countries as $country)
                        <option value="{{ $country->country_name }}"  @if($video->country=== $country->country_name) selected='selected' @endif >{{ $country->country_name }}</option>
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
                    <?php if($settings->ppv_status == 1){ ?>
                        <option value="ppv" @if(!empty($video->access) && $video->access == 'ppv'){{ 'selected' }}@endif>PPV Users (Pay per movie)</option>   
                    <?php } else{ ?>
                    <option value="ppv" @if(!empty($video->access) && $video->access == 'ppv'){{ 'selected' }}@endif>PPV Users (Pay per movie)</option>   
                <?php } ?>
                </select>
               </div> 
                <div class="col-sm-6 form-group mt-3" id="ppv_price">
                    <label class="m-0">PPV Price:</label>
                    <input type="text" class="form-control" placeholder="PPV Price" name="ppv_price" id="price" value="@if(!empty($video->ppv_price)){{ $video->ppv_price }}@endif">
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
                                        <label class="" for="featured">Is this video Featured:</label>
                                        <input type="checkbox" @if(!empty($video->featured) && $video->featured == 1){{ 'checked="checked"' }}@endif name="featured" value="1" id="featured" />
                                   </div>
                                   <div class="clear"></div>
                                   <div>
                                       <label class="" for="active">Is this video Active:</label>
                                       <input type="checkbox" @if(!empty($video->active) && $video->active == 1){{ 'checked="checked"' }}@elseif(!isset($video->active)){{ 'checked="checked"' }}@endif name="active" value="1" id="active" />
                                   </div>
                                    <div class="clear"></div>
                                   <div>
                                       <label class="" for="banner">Is this video Banner:</label>
                                       <input type="checkbox" @if(!empty($video->banner) && $video->banner == 1){{ 'checked="checked"' }}@elseif(!isset($video->banner)){{ 'checked="checked"' }}@endif name="banner" value="1" id="banner" />
                                   </div>
                                    <div class="clear"></div>
                               </div> 
                           </div>
                       </div>
                   </div>
                </div> 

                            <input type="button" name="next" class="next action-button" value="Next" />
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
               <label class="mb-1">Video Thumbnail <span>(16:9 Ratio or 720X1080px)</span></label><br>
               <input type="file" name="image" id="image" >
               @if(!empty($video->image))
               <img src="{{ URL::to('/') . '/public/uploads/images/' . $video->image }}" class="video-img" width="200" height="200"/>
               @endif
               </div>
               <div class="col-sm-6 form-group">
               <label class="mb-1">Player Thumbnail <span>(16:9 Ratio or 1280X720px)</span></label><br>
               <input type="file" name="player_image" id="player_image" >
               @if(!empty($video->player_image))
               <img src="{{ URL::to('/') . '/public/uploads/images/' . $video->player_image }}" class="video-img" width="200" height="200"/>
               @endif
               </div>
               </div>
               <div class="row">
               <div class="col-sm-8 form-group">
               <label class="m-0">Upload Trailer :</label><br>
               <div class="new-video-file form_video-upload" style="position: relative;" @if(!empty($video->type) && $video->type == 'upload') style="display:none" @else style="display:block" @endif >
               <input type="file" accept="video/mp4,video/x-m4v,video/*" name="trailer" id="trailer">
               <p style="font-size: 14px!important;">Drop and drag the video file</p>
               </div>
               <!-- <span id="remove" class="danger">Remove</span> -->
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
               <input type="button" name="next" class="next action-button" value="Next" />
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
                                 <option value="{{$ad->id}}"  @if( $ads_paths == $ad->id ) {{ 'selected' }} @endif  >{{$ad->ads_name}}</option>
                              @endforeach
                           </select>
                        </div>


                        <div class="col-sm-6 form-group mt-3">
                           <label class="">Default Ads</label>
                              <label class="switch">
                                 <input name="default_ads" type="checkbox" @if( $video->default_ads == "1") checked  @endif >
                                 <span class="slider round"></span>
                              </label>
                        </div>
                        
                        {{-- <div class="col-sm-6 form-group mt-3">
                           <label class="">Choose Ad Roll</label>
                           <select class="form-control" name="ad_roll">
                              <option value="0"  >Select Ad Roll</option>
                              <option value="1"  @if( $ads_rolls == 'Pre' ) {{ 'selected' }} @endif   >Pre</option>
                              <option value="2"  @if( $ads_rolls == 'Mid' ) {{ 'selected' }} @endif   >Mid</option>
                              <option value="3"  @if( $ads_rolls == 'Post' ) {{ 'selected' }} @endif   >Post</option>
                           </select>
                        </div> --}}
                     </div>
                     <div class="row">
                        @if($page == 'Edit' && $video->status == 0)
                        <div class="col-7">
                           <h2 class="fs-title">Transcoding:</h2>
                        </div>
                        @endif
                        <div class="col-sm-6 form-group mt-3">
                           <div id="success">
                           </div>
                           <div class="row text-center">
                              <input type="hidden" id="page" value="{{ $page }}">
                              @if(isset($video->id))
                              <input type="hidden" id="status" value="{{ $video->status }}">
                              @else
                              <input type="hidden" id="status" value="0">
                              @endif
                              @if($page == 'Create' || $page == 'Edit')
                              <!-- <div class="progress">
                                 <div class="bar"></div >
                                 </div>
                                 <div class="percent">0%</div > -->
                              @endif
                              @if($page == 'Edit' && $video->status == 0)
                              <br><br><br>
                              <div class="col-sm-12">
                                 Video Transcoding is under Progress
                                 <div class="progress">
                                    <div class="low_bar"></div >
                                 </div>
                                 <div class="low_percent">0%</div >
                              </div>
                              @endif
                           </div>
                        </div>
                     </div>
                     @if(isset($video->id))
                     <input type="hidden" id="id" name="id" value="{{ $video->id }}" />
                     <input type="hidden" id="publish_status" name="publish_status" value="{{ $video->publish_status }}" >
                     <input type="hidden" id="type" name="type" value="{{ $video->type }}" />                                @endif
                     <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                     <!-- <input type="hidden" id="video_id" name="video_id" value=""> -->
                  </div>
                  <button type="submit" class="btn btn-primary mr-2" value="{{ $button_text }}">{{ $button_text }}</button>
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


   // validation Recap 

      $('#error_recap_start_time').hide();
      $('#error_recap_end_time').hide();
      $('#error_skip_recap_time').hide();

   $('#recap_start_time').on('keyup keypress change', function(event) {
          $('#error_recap_start_time').hide();

      if($('#skip_recap').val() == ""){
         $('#error_skip_recap_time').show();
         $('#error_recap_end_time').show();
         $('#next2').attr('disabled','disabled');
      }
      else if($('#skip_recap').val() != "" && $('#skip_recap').val() <= $('#recap_start_time').val() ){

            $("#error_recap_start_time").empty();
            $("#error_recap_start_time").append("Skip intro time always greater than intro Start time");
            $('#error_recap_start_time').show();
            $('#error_recap_end_time').show();
            $('#error_recap_start_time').hide();

            $('#next2').attr('disabled','disabled');
      }
      else{
         $('#error_skip_recap_time').hide();
            $('#next2').removeAttr('disabled');
      }
   });

   $('#skip_recap').on('keyup keypress change', function(event) {
      if($('#recap_start_time').val() == ""){
         $('#error_recap_start_time').show();
         $('#error_recap_end_time').show();
         $('#next2').attr('disabled','disabled');
      }
      else if($('#recap_start_time').val() != "" && $('#skip_recap').val() <= $('#recap_start_time').val() ){
            $("#error_skip_recap_time").empty();
            $("#error_skip_recap_time").append("Skip Recap time always lesser than recap Start time ");
            $('#error_skip_recap_time').show();
            $('#next2').attr('disabled','disabled');
      }
      else{
         $('#error_skip_recap_time').hide();
            $('#next2').removeAttr('disabled');
      }
   });

   $('#recap_end_time').on('keyup keypress change', function(event) {

      if($('#skip_recap').val() == ""){
         $('#error_recap_start_time').show();
         $('#next2').attr('disabled','disabled');
      }
      else if($('#recap_start_time').val() != "" && $('#recap_start_time').val() >= $('#recap_end_time').val() ){
            $("#error_recap_end_time").empty();
            $("#error_recap_end_time").append("End intro time always greater than intro start time ");
            $('#error_recap_end_time').show();
            $('#next2').attr('disabled','disabled');
      }
      else if($('#recap_start_time').val() != "" && $('#skip_recap').val() <= $('#recap_end_time').val() ){
            $("#error_recap_end_time").empty();
            $("#error_recap_end_time").append("End recap time always lesser than Skip recap time ");
            $('#error_recap_end_time').show();
            $('#next2').attr('disabled','disabled');
      }
      else{
         $('#error_recap_end_time').hide();
            $('#next2').removeAttr('disabled');
      }
   });

   $('#error_video_Category').hide();

   $('.Next3').on('keyup keypress blur change click mouseover', function(event) {
      if($('#video_category_id').val() == null){
         $('#error_video_Category').show();
         $('#next3').attr('disabled','disabled');
      }  
      else{
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
   			$('.low_percent').html(data.processed_low+'%');
   		});
   	}, 3000);
   }
</script>
<script type="text/javascript">
   $ = jQuery;
   
   $(document).ready(function($){
      
   
      $('.js-example-basic-multiple').select2();
      $('.js-example-basic-single').select2();
   
      // $('#duration').mask("00:00:00");

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
      if($("#access").val() == 'ppv'){
   			$('#ppv_price').show();
   			$('#global_ppv_status').show();
   
   
   		}else{
   			$('#ppv_price').hide();		
   			$('#global_ppv_status').hide();				
   
   		}
      
   	$("#access").change(function(){
   		if($(this).val() == 'ppv'){
   			$('#ppv_price').show();
   			$('#global_ppv_status').hide();
   
   		}else{
   			$('#ppv_price').hide();		
   			$('#global_ppv_status').show();				
   
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
<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script>
   CKEDITOR.replace( 'summary-ckeditor', {
       filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
       filebrowserUploadMethod: 'form'
   });

   CKEDITOR.replace( 'links-ckeditor', {
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
<script src="plyr-plugin-capture.js"></script>
<script src="<?= URL::to('/'). '/assets/admin/dashassets/js/plyr-plugin-capture.js';?>"></script>
<script src="https://cdn.plyr.io/3.5.10/plyr.js"></script>
<script src="https://cdn.jsdelivr.net/hls.js/latest/hls.js"></script>
<script>
   var type = '<?= $video->type ?>';
   
   if(type != ""){
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
   'capture'
   ],
   i18n:{
   // your other i18n
   capture: 'capture'
   }
   
       });
       $("#nextplayer").click(function(){
      player.stop();
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
@section('javascript')
@stop
@stop
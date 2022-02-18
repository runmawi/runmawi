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
   </style>
<link rel="stylesheet" href="https://cdn.plyr.io/3.6.9/plyr.css" />
<!-- <link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/style.css';?>" /> -->

@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="http://malsup.github.com/jquery.form.js"></script>
        
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>
   
 <div id="content-page" class="">
         <div class="container-fluid">
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
                     <div class="iq-card-body">
                         <h5>Video Info Details</h5>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<div id="" class="content-page1">
    <div class="container-fluid">
    <div class="row ">
        <div class="col-11 col-sm-10 col-md-10 col-lg-12 col-xl-12 text-center p-0 mt-3 mb-2">
            <div class="px-0 pt-4 pb-0 mt-12 mb-3 col-md-12">
                <h2 id="heading">Sign Up Your User Account</h2>
                <p>Fill all form field to go to next step</p>
                <form id="msform" method="POST" action="{{ $post_route }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">
                    <!-- progressbar -->
                    <ul id="progressbar">
                    @if($video->status == 1)
                        <li class="active" id="account"><strong>Video</strong></li>
                        @endif
                        <li class="active" id="account"><strong>Video Details</strong></li>
                        <li id="personal"><strong>Category</strong></li>
                        <li id="useraccess_ppvprice"><strong>User Video Access</strong></li>
                        <!-- <li id="payment"><strong>Upload Image & Trailer</strong></li> -->
                        <li id="payment"><strong>Upload Image & Trailer</strong></li>
                        <li id="confirm"><strong>Ads Management & Transcoding</strong></li>
                        <!-- <li id="confirm"><strong>Ads Management</strong></li> -->
                      

                    </ul>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                    </div> <br> <!-- fieldsets -->
                    @if($video->status == 1)
                    <fieldset>
                           <div class="form-card">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="fs-title">Video Player:</h2>
                                </div>
                            </div>
                            <div class="row">
                                <label for="">Player Embed Link:</label>
                                <p>Click Icon to copy the URL</p>
                                <li>
                                <span><a href="#"onclick="EmbedCopy();" class="share-ico"><i class="ri-links-fill"></i></a></span>
                                </li>
                            </div>
                        <div class="row">
                    @if($video->type == 'mp4_url')
                        <div id="video_container" class="fitvid" atyle="z-index: 9999;">
                        <video id="videoPlayer"  class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'  type="video/mp4" >
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
   
                    </div>
                <!-- </div> -->
                <input type="button" name="next" class="next action-button" value="Next" /> <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                </fieldset>
                    @endif
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
                            <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="@if(!empty($video->title)){{ $video->title }}@endif">
                        </div>
                        <div class="col-sm-6 form-group" >
                                <label class="p-2">
                                    Video Slug <a class="iq-bg-warning" data-toggle="tooltip" data-placement="top" title="Please enter the name of the video again here" data-original-title="this is the tooltip" href="#">
                                    <i class="las la-exclamation-circle"></i></a>:</label>
                            <input type="text"   class="form-control" name="slug" id="slug" placeholder="Video Slug" value="@if(!empty($video->slug)){{ $video->slug }}@endif">
                        </div>
                                </div>
                            <div class="row">
                                 
                                <div class="col-sm-6 form-group">
                                <label><h5>Age Restrict :</h5></label>
                                <select class="form-control" id="age_restrict" name="age_restrict">
                                        <option selected disabled="">Choose Age</option>
                                        @foreach($age_categories as $age)
                                            <option value="{{ $age->age }}" @if(!empty($video->language) && $video->age_restrict == $age->slug)selected="selected"@endif>{{ $age->slug }}</option>
                                        @endforeach
                                    </select>
                            </div>
                            <div class="col-sm-6 form-group ">                                       
                                    <label class="p-2">Rating:</label>
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

                                <div class="col-sm-4 form-group mt-3">
                            <label class="">Skip Intro Time</label>
				            <p>Please Give In Seconds</p> 
                            <input type="text" class="form-control" id="skip_intro" name="skip_intro" value="@if(!empty($video->skip_intro)){{ $video->skip_intro }}@endif">
                            </div>
                            <div class="col-sm-4 form-group mt-3">
                            <label class="">Intro Start Time</label>
                            <p>Please Give In Seconds</p> 
                            <input type="text"  class="form-control without" id="intro_start_time" name="intro_start_time" value="@if(!empty($video->intro_start_time)){{ $video->intro_start_time }}@endif" >
                            </div>
                            <div class="col-sm-4 form-group mt-3">
                            <label class="">Intro End Time</label>
                            <p>Please Give In Seconds</p> 
                            <input type="text"  class="form-control without" id="intro_end_time" name="intro_end_time" value="@if(!empty($video->intro_end_time)){{ $video->intro_end_time }}@endif" >
                            </div>
                            </div>

                                <div class="row">
                                <div class="col-sm-4 form-group mt-3">
                            <label class="">Skip Recap Time</label>
                            <p>Please Give In Seconds</p> 
                            <input type="text" class="form-control" id="skip_recap" name="skip_recap" value="@if(!empty($video->skip_recap)){{ $video->skip_recap }}@endif">
                            </div>
                            <div class="col-sm-4 form-group mt-3">
                            <label class="">Recap Start Time</label>
                            <p>Please Give In Seconds</p> 
                            <input type="text"  class="form-control without" id="recap_start_time" name="recap_start_time"  value="@if(!empty($video->recap_start_time)){{ $video->recap_start_time }}@endif">
                            </div>
                            <div class="col-sm-4 form-group mt-3">
                            <label class="">Recap End Time</label>
                            <p>Please Give In Seconds</p> 
                            <input type="text"  class="form-control without" id="recap_end_time" name="recap_end_time"  value="@if(!empty($video->recap_end_time)){{ $video->recap_end_time }}@endif" >
                            </div>
                            </div>
                                <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label class="">Video Duration:</label>
                                    <input type="text" class="form-control" placeholder="Video Duration" name="duration" id="duration" value="@if(!empty($video->duration)){{ gmdate('H:i:s', $video->duration) }}@endif">
                                </div> 
                                <div class="col-sm-6 form-group">
                                    <label class="">Year:</label>
                                    <input type="text" class="form-control" placeholder="Release Year" name="year" id="year" value="@if(!empty($video->year)){{ $video->year }}@endif">
                                </div>
                            </div>
                            <div class="row">

                            <div class="col-sm-6 form-group mt-3" >
                                    <!-- <label class="">Choose Ad Name</label> -->
                            <input type="radio" id="publish_now" name="publish_type" value = "publish_now" {{ !empty(($video->publish_type=="publish_now"))? "checked" : "" }}>Publish Now <br>
							<input type="radio" id="publish_later" name="publish_type" value = "publish_later"{{ !empty(($video->publish_type=="publish_later"))? "checked" : "" }} >Publish Later
                                </div>
                                <div class="col-sm-6 form-group mt-3" id="publishlater">
                                    <label class="">Publish Time</label>
			                    <input type="datetime-local" class="form-control" id="publish_time" name="publish_time" value="@if(!empty($video->publish_time)){{ $video->publish_time }}@endif">
                                </div>
                                </div>
                            <div class="row">

                            <div class="col-lg-12 form-group">
                            <h5 class="mb-3">Video description:</h5>
                            <textarea  rows="5" class="form-control mt-2" name="description" id="summary-ckeditor"
                        placeholder="Description">@if(!empty($video->description)){{ strip_tags($video->description) }}@endif</textarea>
                        </div>
                        <div class="col-12 form-group">
                                <textarea   rows="5" class="form-control mt-2" name="details" 
                            placeholder="Link , and details">@if(!empty($video->details)){{ htmlspecialchars($video->details) }}@endif</textarea>
                            </div>
                                </div>

                      </div> <input type="button" name="next" class="next action-button" value="Next" />
                    </fieldset>
                    <fieldset>
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
                                    <select class="form-control js-example-basic-multiple"  name="video_category_id[]"  id="video_category_id"  multiple="multiple" >
                                            @foreach($video_categories as $category)
                                            @if(in_array($category->id, $category_id))
                                        <option value="{{ $category->id }}" selected="true">{{ $category->name }}</option>
                                        <!-- <option value="{{ $category->id }}" @if(!empty($video->video_category_id) && $video->video_category_id == $category->id)selected="selected"@endif>{{ $category->name }}</option> -->
                                        @else
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endif      
                                        @endforeach
                                    </select>
                            </div>
                            <div class="col-sm-6 form-group" >                               
                                <div class="panel panel-primary" data-collapsed="0"> 
                                    <div class="panel-heading"> 
                                        <div class="panel-title">
                                            <labe>Cast and Crew</labe> 
                                        </div> 
                                        <div class="panel-options"> 
                                            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> 
                                        </div>
                                    </div> 
                                    <div class="panel-body" style="display: block;"> 
                                        <p class="p1">Add artists for the video below:</p> 
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
                                                <label class="p-2">Choose Language:</label>
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
                                            </div>   
                                            <div class="row mt-5">    
                                <div class="panel panel-primary" data-collapsed="0"> 
                                    <div class="panel-heading"> 
                                        <div class="panel-title" style="color: #000;">Subtitles (srt or txt)
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
                        </div> <input type="button" name="next" class="next action-button" value="Next" /> <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
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
                            <div class="col-md-4">
                                    <label class="">Recommendation </label>
                                    <input type="text" class="form-control" id="Recommendation " name="Recommendation" value="@if(!empty($video->Recommendation)){{ $video->Recommendation }}@endif">
                                </div> 


                                <!-- {{-- Block country --}} -->
                                    <div class="col-sm-4 form-group">
                                        <label><h5>Block Country</h5></label>
                                        <p class="p1">Choose the countries for block the videos</p> 
                                        <select  name="country[]" class="js-example-basic-multiple" style="width: 100%;" multiple="multiple">
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
                                    <div class="col-sm-4 form-group">
                                        <label><h5>Country</h5></label>
                                        <p class="p1">Choose the countries videos</p> 
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
                                    <label class="p-2">User Access</label>
                                    <select id="access" name="access"  class="form-control" >
                                        <option value="subscriber" @if(!empty($video->access) && $video->access == 'subscriber'){{ 'selected' }}@endif>Subscriber ( Must subscribe to watch )</option>
                                        <!-- <option value="guest" @if(!empty($video->access) && $video->access == 'guest'){{ 'selected' }}@endif>Guest (everyone)</option> -->
                                        <option value="registered" @if(!empty($video->access) && $video->access == 'registered'){{ 'selected' }}@endif>Registered Users( Must register to watch )</option>   
                                        <?php if($settings->ppv_status == 1){ ?>
                                        <option value="ppv" @if(!empty($video->access) && $video->access == 'ppv'){{ 'selected' }}@endif>PPV Users (Pay per movie)</option>   
                                        <?php } else{ ?>
                                        <option value="ppv" @if(!empty($video->access) && $video->access == 'ppv'){{ 'selected' }}@endif>PPV Users (Pay per movie)</option>   
                                        <?php } ?>
                                    </select>
                                </div> 
                                </div>

                            <div class="row">
                                <div class="col-sm-6 form-group mt-3" id="ppv_price">
                                    <label class="">PPV Price:</label>
                                    <input type="text" class="form-control" placeholder="PPV Price" name="ppv_price" id="price" value="@if(!empty($video->ppv_price)){{ $video->ppv_price }}@endif">
                                </div>
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

                                <div class="col-sm-6 mt-3"> 
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
                            <label>Video Thumbnail <span>(16:9 Ratio or 1280X720px)</span></label><br>
                            <input type="file" name="image" id="image" >
                            @if(!empty($video->image))
                                <img src="{{ URL::to('/') . '/public/uploads/images/' . $video->image }}" class="video-img" width="200" height="200"/>
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
                                        <option value="{{$ad->id}}">{{$ad->ads_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6 form-group mt-3">
                                    <label class="">Choose Ad Roll</label>
                                    <select class="form-control" name="ad_roll">
                                        <option value="0">Select Ad Roll</option>
                                        <option value="1">Pre</option>
                                        <option value="2">Mid</option>
                                        <option value="3">Post</option>
                                    </select>
                                </div>
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
    position: relative
}

.form-card {
    text-align: left
}

#msform fieldset:not(:first-of-type) {
    display: none
}

#msform input,
#msform textarea {
    padding: 8px 15px 8px 15px;
    border: 1px solid #ccc;
    border-radius: 0px;
    margin-bottom: 25px;
    margin-top: 2px;
    width: 100%;
    box-sizing: border-box;
    color: #000;
    background-color: #ECEFF1;
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
    background: #673AB7;
    font-weight: bold;
    color: white;
    border: 0 none;
    border-radius: 0px;
    cursor: pointer;
    padding: 10px 5px;
    margin: 10px 0px 10px 5px;
    float: right
}

#msform .action-button:hover,
#msform .action-button:focus {
    background-color: #311B92
}

#msform .action-button-previous {
    width: 100px;
    background: #616161;
    font-weight: bold;
    color: white;
    border: 0 none;
    border-radius: 0px;
    cursor: pointer;
    padding: 10px 5px;
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
    color: black;
    /* border: 1px solid #f5f5f5; /
    border-radius: 5px;
    box-shadow: 0px 0px 15px #e1e1e1; */
}

#progressbar li.active {
    color: #000000!important;
}

#progressbar li {
    list-style-type: none;
    font-size: 15px;
    width: 20%;
    float: left;
    position: relative;
    font-weight: 400;
    background-color: white;
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
    padding: 2px
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
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="<?= URL::to('/assets/js/jquery.mask.min.js');?>"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.css" rel="stylesheet"/>
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
    </script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

    <script>

      $('input[type="checkbox"]').on('change', function(){
			   this.value = this.checked ? 1 : 0;
			}).change();
      </script>
      <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

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
    });
    hls.attachMedia(video);
    window.hls = hls;
  } else {
    // default options with no quality update in case Hls is not supported
    const player = new Plyr(video, defaultOptions);
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

@php
    include public_path('themes/theme5-nemisha/views/header.php');
    $settings = App\Setting::first();
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
        padding: 30px;
        border-radius: 10px;
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
    
    .video-form-control{
        width:100%;
        background-color: #c9c8c888 ;
        border:none;
    }
    </style>


<div class="container-fluid">
          
    <div class="iq-card " style="padding:40px;">
  <div class="row justify-content-center">
     <div class="col-11 col-sm-10 col-md-10 col-lg-12 col-xl-12 text-center p-0 mb-2">
        <div class="px-0 pb-0 mb-3 col-md-12">
           <!-- <h2 id="heading">Sign Up Your User Account</h2>
              <p>Fill all form field to go to next step</p> -->
           <form method="POST" accept-charset="UTF-8" file="1" enctype="multipart/form-data" id="msform">
              <!-- progressbar -->
              <ul id="progressbar">
                 <li class="active" id="account">
                     <div class="col">
                         <div class=""><img class="ugc-icon" src="<?php echo  URL::to('/assets/img/icon/1.svg')?>"></div>
                         <div class=""> Video Details</div>
                     </div>
                 </li>
                 <li id="personal">
                     <div class="col">
                         <div class=""><img class="ugc-icon" src="<?php echo  URL::to('/assets/img/icon/2.svg')?>"></div>
                         <div class="">Category</div>
                     </div>    
                 </li>
                 <li id="useraccess_ppvprice">
                     <div class="col">
                         <div class=""><img class="ugc-icon" src="<?php echo  URL::to('/assets/img/icon/3.svg')?>"></div>
                         <div class=""> User Video Access</div>
                     </div>        
                 </li>
                 <!-- <li id="payment"><strong>Upload Image & Trailer</strong></li> -->
                 <li id="payment">
                     <div class="col">
                         <div class=""><img class="ugc-icon" src="<?php echo  URL::to('/assets/img/icon/4.svg')?>"></div>
                         <div class=""> Upload Image &amp; Trailer</div>
                     </div>       
                 </li>
                 {{-- <li id="confirm"><img class="ugc-icon" src="<?php echo  URL::to('/assets/img/icon/5.svg')?>">Ads Management</li> --}}
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
                          <input type="text" class="video-form-control" style="border-radius: 7px;" name="title" id="title" placeholder="Title" value="">
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
                             {{-- @foreach($age_categories as $age)
                             <option value="{{ $age->age }}" @if(!empty($video->language) && $video->age_restrict == $age->slug)selected="selected"@endif>{{ $age->slug }}</option>
                             @endforeach --}}
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
                          <label class="m-0"> Free Duration <small>Enter The Live Stream Free Duration In (HH : MM : SS)</small></label>
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
                             {{-- @foreach($video_categories as $category)
                             <option value="{{ $category->id }}">{{ $category->name }}</option>
                             @endforeach --}}
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
                                   {{-- @foreach($artists as $artist)
                                   @if(in_array($artist->id, $video_artist))
                                   <option value="{{ $artist->id }}" selected="true">{{ $artist->artist_name }}</option>
                                   @else
                                   <option value="{{ $artist->id }}">{{ $artist->artist_name }}</option>
                                   @endif 
                                   @endforeach --}}
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
                             {{-- @foreach($languages as $language)
                             <option value="{{ $language->id }}" >{{ $language->name }}</option>
                             @endforeach --}}
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
                             {{-- @foreach($AdminVideoPlaylist as $Video_Playlist)
                             <option value="{{ $Video_Playlist->id }}" >{{ $Video_Playlist->title }}</option>
                             @endforeach --}}
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
                             <div class="panel-title" style="color: #000;"> <label class="m-0"><h3 class="fs-title">Subtitles (WebVTT (.vtt)) :</h3></label>
                             </div>
                             <div class="panel-options"> 
                                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> 
                             </div>
                          </div>
                          <div class="panel-body" style="display: block;">
                             {{-- @foreach($subtitles as $subtitle)
                             <div class="col-sm-6 form-group" style="float: left;">
                                <div class="align-items-center" style="clear:both;" >
                                   <label for="embed_code"  style="display:block;">Upload Subtitle {{ $subtitle->language }}</label>
                                   <input class="mt-1" type="file" name="subtitle_upload[]" id="subtitle_upload_{{ $subtitle->short_code }}">
                                   <input class="mt-1"  type="hidden" name="short_code[]" value="{{ $subtitle->short_code }}">
                                   <input class="mt-1"  type="hidden" name="sub_language[]" value="{{ $subtitle->language }}">
                                </div>
                             </div>
                             @endforeach --}}
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
                       
                       {{-- Block country --}}
                       <div class="col-sm-6 form-group">
                          <label class="m-0">Block Country </label>
                          <p class="p1">( Choose the countries for block the videos )</p>
                          <select  name="country[]" class="js-example-basic-multiple" style="width: 100%;" multiple="multiple">
                             {{-- @foreach($countries as $country)
                             <option value="{{ $country->country_name }}" >{{ $country->country_name }}</option>
                             @endforeach --}}
                          </select>
                       </div>
                       {{-- country --}}
                       <div class="col-sm-6 form-group">
                          <label class="m-0"> Available Country </label>
                          <p class="p1">( Choose the countries videos )</p>
                          <select  name="video_country[]" class="js-example-basic-multiple" style="width: 100%;" multiple="multiple"  id="country">
                             <option value="All">Select Country </option>
                                {{-- @foreach($countries as $country)
                                   <option value="{{ $country->country_name }}" >{{ $country->country_name }}</option>
                                @endforeach --}}
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
                             {{-- <?php if($settings->ppv_status == 1){ ?>
                             <option value="ppv" >PPV Users (Pay per movie)</option>
                             <?php } else{ ?>
                             <option value="ppv" >PPV Users (Pay per movie)</option>
                             <?php } ?> --}}
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
                                   {{-- @foreach($InappPurchase as $Inapp_Purchase)
                                      <option value="{{ $Inapp_Purchase->product_id }}" >{{ $Inapp_Purchase->plan_price }}</option>
                                   @endforeach --}}
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
                                      {{-- @foreach($related_videos as $key => $related_video)
                                         <option value="{{ $related_video->id }}"  > {{ $related_video->title }}</option>
                                      @endforeach --}}
                                </select>
                             </div>
                    </div>

                    <div class="row">
                       <div class="col-sm-6 form-group mt-3" id="ppv_price">
                          {{-- <?php if($settings->ppv_status == 1){ ?>
                          <label for="global_ppv">Is this video Is Global PPV:</label>
                          <input type="checkbox" name="global_ppv" value="1" id="global_ppv" />
                          <?php } else{ ?>
                          <div class="global_ppv_status">
                             <!-- <label for="global_ppv">Is this video Is PPV:</label>
                                <input type="checkbox" name="global_ppv" value="1" id="global_ppv" /> -->
                          </div>
                          <?php } ?> --}}
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
                          <label class="mb-1">Video Thumbnail <span>(9:16 Ratio or 1080X1920px)</span></label><br>
                          <input type="file" name="image" id="image" >
                          <span><p id="image_error_msg" style="color:red;" >* Please upload an image with 1080 x 1920 pixels dimension or ratio 9:16 </p></span>
                          @if(!empty($video->image) && ($video->image) != null)
                             <img src="{{ URL::to('/') . '/public/uploads/images/' . $video->image }}" class="video-img w-100" />
                          @endif
                       </div>

                       <div class="col-sm-6 form-group">
                         <div id="ajaxImagesContainer" class="gridContainer mt-3"></div>
                          <label class="mb-1">Player Thumbnail <span>(16:9 Ratio or 1280X720px)</span></label><br>
                          <input type="file" name="player_image" id="player_image" >
                          <span><p id="player_image_error_msg" style="color:red;" >* Please upload an image with 1280 x 720 pixels dimension or ratio 16:9 </p></span>
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
                          <span><p id="tv_image_image_error_msg" style="color:red;" >* Please upload an image with 1920  x 1080  pixels dimension or 16:9 ratio </p></span>
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
                          <input type="file" accept="video/mp4,video/x-gm4v,video/*" name="trailer" id="trailer">
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
        <input type="button" name="next" class="next action-button update_upload_img" value="Next" />
        <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
        </fieldset>

                       {{-- ADS Management --}}
           @include('admin.videos.fileupload_ads_fieldset'); 

        </form>
     </div>
  </div>
</div>
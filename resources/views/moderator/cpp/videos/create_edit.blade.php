@extends('moderator.master')
<?php 

?>

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop
 
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
.error{
        color: red;
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

@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <!-- <script src="http://malsup.github.com/jquery.form.js"></script> -->
   
 <div id="content-page" class="content-page">
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
                        <form method="POST" action="{{ $post_route }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data" id="cpp_video_edit">
                        <div class="row">
                              <div class="col-lg-12">
                                 <div class="row">
                                    <input type="hidden" class="form-control"  name="ppv_price" id="price" value="@if(!empty($video->ppv_price)){{ $video->ppv_price }}@endif">
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
                                    
                                     <div class="col-sm-6 form-group" >
                                       <label class="p-2">Select Video Category :</label>
                                       <!-- <select class="form-control" id="video_category_id" name="video_category_id">
                                           <option value="">Choose Category </option>
						                        @foreach($video_categories as $category)
                                          <option value="{{ $category->id }}" @if(!empty($video->video_category_id) && $video->video_category_id == $category->id)selected="selected"@endif>{{ $category->name }}</option>
						                        @endforeach

                                       </select> -->
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
                                          <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
                                      <div class="panel-title">Cast and Crew </div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
                                      <div class="panel-body" style="display: block;"> 
                                        <p>Add artists for the video below:</p> 
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
                                    
                                      <div class="col-sm-6 form-group">
                                  <label class="p-2">Choose Language:</label>
                                 <!-- <select class="form-control" id="language" name="language">
                                    <option selected disabled="">Choose Language</option>
                                    @foreach($languages as $language)
							                  <option value="{{ $language->id }}" @if(!empty($video->language) && $video->language == $language->id)selected="selected"@endif>{{ $language->name }}</option>
						                  @endforeach
                              </select> -->
                              <select class="form-control js-example-basic-multiple" id="language" name="language[]" style="width: 100%;" multiple="multiple">
                                @foreach($languages as $language)
                                    @if(in_array($language->id, $languages_id))
                                    <option value="{{ $language->id }}" selected="true">{{ $language->name }}</option>
                                    @else
                                    <option value="{{ $language->id }}" >{{ $language->name }}</option>
                                    @endif 
                                @endforeach
                            </select>
                              </div>   
                              <div class="col-sm-6 form-group mt-3">
                                         <label><h5>Age Restrict :</h5></label>
                                         <select class="form-control" id="age_restrict" name="age_restrict">
                                                    <option selected disabled="">Choose Age</option>
                                                    @foreach($age_categories as $age)
                                                        <option value="{{ $age->slug }}" @if(!empty($video->language) && $video->age_restrict == $age->slug)selected="selected"@endif>{{ $age->slug }}</option>
                                                    @endforeach
                                                </select>
                                      </div>
                                 <div class="col-sm-12 form-group">
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
                                 <!-- <label class="mb-1">Video Thumbnail <span>(16:9 Ratio or 720X1080px)</span></label><br>
                                     <input type="file"  name="image" id="image" >
                                  
                                     @if(!empty($video->image))
                                       <img src="{{ URL::to('/') . '/public/uploads/images/' . $video->image }}" class="video-img" width="200" height="200"/>
                                    @endif -->
                                 </div>
                                   <!-- <div class="col-md-6 form-group">
                                       <select class="form-control" id="video_category_id" name="video_category_id">
                                       <option value="0">Uncategorized</option>
						                        @foreach($video_categories as $category)
                                          <option value="{{ $category->id }}" @if(!empty($video->video_category_id) && $video->video_category_id == $category->id)selected="selected"@endif>{{ $category->name }}</option>
						                        @endforeach

                                       </select>
                                    </div>
                                    <div class="col-sm-6 form-group">
                                          <select id="type" name="type" class="form-control" required>
                                             <option>--Select Video Type--</option>
                                             <option value="file" @if(!empty($video->type) && $video->type == 'file'){{ 'selected' }}@endif>Video File</option>
                                             <option value="embed" @if(!empty($video->type) && $video->type == 'embed'){{ 'selected' }}@endif >Embed Code</option>
                                          </select>   
                                    </div>-->
                                     
                                    <div class="col-lg-12 form-group">
                                        <h5>Video description:</h5>
                                       <textarea  rows="5" class="form-control" name="description" id="summary-ckeditor"
                                          placeholder="Description">@if(!empty($video->description)){{ strip_tags($video->description) }}@endif</textarea>
                                    </div>
                                    <div class="col-12 form-group">
                                       <textarea   rows="5" class="form-control" name="details" 
                                          placeholder="Link , and details">@if(!empty($video->details)){{ htmlspecialchars($video->details) }}@endif</textarea>
                                    </div>
                                 </div>
                              </div>
                              
                            
                           </div>
                            <div>
                                <h5>Video Upload</h5>
                            </div>
                            <div class="row mt-5">
                            <?php  if(!empty($video->embed_code)){ ?>
                                <div class="col-sm-6 form-group">
                                <label for="embed_code"><label>Embed URL:</label></label>
                                    <input type="text" class="form-control" name="embed_code" value="@if(!empty($video->embed_code)){{ $video->embed_code }}@endif"  />
                                </div>
                                <?php   }elseif(!empty($video->mp4_url) && !empty($video->path)){ ?>
                                <div class="col-sm-6 form-group">
                                    <?php if(!empty($video->embed_code  || $video->mp4_url  || $video->m3u8_url )) { ?>
                                    @if(!empty($video->type) && ($video->type == 'upload' || $video->type == 'file' || $video->type == 'mp4_url' || $video->type == 'm3u8_url' ))
                                    <video width="200" height="200" controls>
                                    <source src="<?=$video->mp4_url; ?>" type="video/mp4">
                                    </video>
                                    @endif
                                    <?php }else{
                                        echo "NO Video Uploaded";
                                        }?>
                                </div>
                                <?php   } elseif(!empty($video->mp4_url)){ ?>
                                <div class="col-sm-6 form-group">
                                <label for="mp4_url">Mp4 URL:</label>
                                    <input type="text" class="form-control" name="mp4_url" id="mp4_url" value="@if(!empty($video->mp4_url)){{ $video->mp4_url }}@endif" />
                                </div>
                                <?php  }elseif(!empty($video->m3u8_url)){ ?>
                                <div class="col-sm-12 form-group">
                                    <div class="col-sm-8">
                                <label for="m3u8_url">m3u8 URL:</label>
                                    <input type="text" class="form-control" name="m3u8_url" id="m3u8_url" value="@if(!empty($video->m3u8_url)){{ $video->m3u8_url }}@endif">
                                    </div>
                                </div>
                                   <?php } ?>
                            </div>
                            <div class="row">
                                <label class="p-2">Upload Trailer :</label>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div style="position: relative" class="form_video-upload"  @if(!empty($video->type) && $video->type == 'upload') style="display:none" @else style="display:block" @endif>
                                        <input type="file" accept="video/mp4,video/x-m4v,video/*" name="trailer" id="trailer" >
                                        <p style="font-size: 14px!important;">Drop and drag the video file</p>
                                    </div>
                                </div>
                                <div class="col-sm-6 form-group">
                                <?php if(!empty($video->trailer) && $video->trailer != '') { ?>
                                    @if(!empty($video->trailer) && $video->trailer != '')
                                    <video width="200" height="200" controls>
                                        <source src="{{ $video->trailer }}" type="video/mp4">
                                    </video>
                                    @endif
                                    <?php }else{
                                        echo "NO Video Uploaded";
                                        }?>
                                </div>

                            </div>

                        <div class="row mt-3">    
                            <div class="col-sm-6">
                                <label class="m-0">E-Paper: <small>(Upload your PDF file)</small> </label>
                                <input type="file" class="form-group" name="pdf_file" accept="application/pdf" id="" >
                               @if(!empty($video->pdf_files))
                                    <span class='pdf_file' >
                                        <a href="{{ URL::to('/') . '/public/uploads/videoPdf/' . $video->pdf_files }}" style="font-size:48px;" class="fa fa-file-pdf-o" width="" height="" download></a>
                                        {{'Download file'}}
                                    </span>
                               @endif
                           </div>
                           
                           <div class="col-sm-6">
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



                            <div class="row mt-3">    
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

                {{-- Ads   --}}
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label class="">Choose Ad Name</label>
                                    <select class="form-control" name="ads_id">
                                        <option value="0">Select Ads</option>
                                        @foreach($ads as $ad)
                                            <option value="{{$ad->id}}"  @if( $ads_paths == $ad->id ) {{ 'selected' }} @endif  >{{$ad->ads_name}}</option>
                                        @endforeach
                                     </select>                                
                                </div>
                            
                                {{-- <div class="col-sm-6 form-group">
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
                                <div class="col-sm-6 form-group">
                                <label class="p-2">Rating:</label>
                                    <!-- selected="true" -->
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
                                <div class="col-sm-6 form-group">
                                    <label class="p-2">User Access:</label>
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
                                
                                
                            <!--
                            <div class="col-sm-6 form-group">>
                            <label class="">Movie Language:</label>
                            <select class="form-control" id="language" name="language">
                            <option selected disabled="">Choose Language</option>
                            @foreach($languages as $language)
                            <option value="{{ $language->id }}" @if(!empty($video->language) && $video->language == $language->id)selected="selected"@endif>{{ $language->name }}</option>
                            @endforeach
                            </select>
                            </div>
                            -->
                                
                            </div>
                            <div class="row">
                            <div class="col-sm-6 form-group mt-3" >
                                    <label for="">Search Tags</label>
                                        <input type="text" id="exist-values" class="tagged form-control1" data-removeBtn="true" name="searchtags" value="@if(!empty($video->search_tags)){{ $video->search_tags }}@endif" >
                                        <!-- <input type="text" class="form-control" id="#inputTag" name="searchtags" value="" data-role="tagsinput"> -->
                                    </div>
                                </div>
                                <div class="col-sm-6 form-group p-0" >
                                    <label class="m-0">Related Videos :</label>
                                    <select  name="related_videos[]" class="form-control js-example-basic-multiple" style="width: 100%;" multiple="multiple">
                                    @foreach($related_videos as $video)
                                    @if(in_array($video->id, $all_related_videos))
                                    <option value="{{ $video->id }}" selected="true">{{ $video->title }}</option>
                                    @else
                                    <option value="{{ $video->id }}"  > {{ $video->title }}</option>
                                    @endif      
                                    @endforeach
                                    </select>
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
                                              <option value="{{ $Inapp_Purchase->product_id }}"  @if($video->ios_ppv_price == $Inapp_Purchase->product_id) selected='selected' @endif >{{ $Inapp_Purchase->plan_price }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                  </div>
                           
                            <div class="row align-items-center">
                                <div class="col-sm-6 form-group mt-3" >
                                    @if($settings->ppv_status == 1)
                                        <label for="global_ppv">Get Pricing from Global PPV Rates Set:</label>
                                        <input type="checkbox" name="global_ppv" id="global_ppv"  {{$video->global_ppv == '1' ? 'checked' : ''}}  />
                                    @else
                                        <div class="global_ppv_status">
                                          <label for="global_ppv">Get Pricing from Global PPV Rates Set:</label>
                                          <input type="checkbox" name="global_ppv" id="global_ppv" {{$video->global_ppv == '1' ? 'checked' : ''}}   />
                                        </div>
                                    @endif
                                </div>

                                <div class="col-sm-6 form-group mt-3"> 
                                    <label for="enable">Is this video :</label>
                                        <div class="make-switch d-flex align-items-center" data-on="success" data-off="warning">
                                    <div><label class="mr-1">Enable</label></div>
                                 <div>
                                   <label class="switch">
                                <input type="checkbox"  @if ($video->enable == 1) {{ "checked='checked'" }} @else {{ "" }} @endif name="enable" id="enable">
                                <span class="slider round"></span>
                                </label></div>
                                <div><label class="ml-1">Disable</label></div>
                                </div>
                                </div>
                            </div>
                     
                          
                                
                            <div class="row mt-2 p-0">
                                  <div class="col-sm-6 form-group mt-3" >
                                      <h5>Publish Type</h5>

                                    <!-- <label class="">Choose Ad Name</label> -->
                            <input type="radio" id="publish_now" name="publish_type" value = "publish_now" {{ !empty(($video->publish_type=="publish_now"))? "checked" : "" }}>Publish Now 
							<input type="radio" id="publish_later" name="publish_type" value = "publish_later"{{ !empty(($video->publish_type=="publish_later"))? "checked" : "" }} >Publish Later
                                </div>
                                <div class="col-sm-6 form-group mt-3" id="publishlater">
                                    <label class="">Publish Time</label>
			                    <input type="datetime-local" class="form-control" id="publish_time" name="publish_time" value="@if(!empty($video->publish_time)){{ $video->publish_time }}@endif">
                                </div>
                            </div></div>
                            <div class="row">
                            <div class="col-sm-4 form-group mt-3">
                            <label class="">Skip Intro Time</label>
				            <p>Please Give In Seconds</p> 
                            <input type="text" class="form-control" id="skip_intro" name="skip_intro" value="@if(!empty($video->skip_intro)){{ $video->skip_intro }}@endif">
                            </div>
                            <div class="col-sm-4 form-group mt-3">
                            <label class="">Recap Start Time</label>
                            <p>Please Give In Seconds</p> 
                            <input type="text"  class="form-control without" id="intro_start_time" name="intro_start_time" value="@if(!empty($video->intro_start_time)){{ $video->intro_start_time }}@endif" >
                            </div>
                            <div class="col-sm-4 form-group mt-3">
                            <label class="">Recap End Time</label>
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

                              @if(isset($video->id))
                                 <input type="hidden" id="id" name="id" value="{{ $video->id }}" />
                                 <input type="hidden" id="publish_status" name="publish_status" value="{{ $video->publish_status }}" >
                                 <input type="hidden" id="type" name="type" value="{{ $video->type }}" />
                              @endif

                              <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                              <div class="col-12 d-flex justify-content-end form-group ">
                                 <button type="submit" class="btn btn-primary mr-2" value="{{ $button_text }}">{{ $button_text }}</button>
                                 <button type="reset" class="btn btn-danger">cancel</button>
                              </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
          <style type="text/css">

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
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css" /> -->
<!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" /> -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>
<script type="text/javascript">
//     $(function () {
//         $('#timepicker').timepicker({
//             showMeridian: false,
//             showInputs: true
//         });
//     });
</script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
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

 

		// tinymce.init({
		// 	relative_urls: false,
		//     selector: '#details',
		//     toolbar: "styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | preview media | forecolor backcolor | code",
		//     plugins: [
		//          "advlist autolink link image code lists charmap print preview hr anchor pagebreak spellchecker code fullscreen",
		//          "save table contextmenu directionality emoticons template paste textcolor code"
		//    ],
		//    menubar:false,
		//  });

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
@section('javascript')

	{{-- validate --}}

	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
	<script>
		$('form[id="cpp_video_edit"]').validate({
			rules: {
                title : 'required',
                video_category_id : 'required'
				},
			submitHandler: function(form) {
				form.submit(); }
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

@stop

@stop

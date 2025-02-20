@extends('admin.master')


<style>
    .p1{
        font-size: 15px !important;
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

.modal {
    display: none; /* Hidden by default */
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
}
   
.modal-content {
    position: absolute;
    background-color: #fff;
    border-radius: 10px;
    border: 1px solid #888;
    width: 50%; /* Adjust the width for medium size */
    max-width: 60%; /* Maximum width limit */
    height: 70%;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}

.submit-btn{
    padding: 7px;
    color: #fafafa;
    cursor: pointer;
    border-radius: 7px
}

.close-icon{
    font-size: 20px;
    font-weight:bold;
    cursor: pointer;"
}

@keyframes animatetop {
    from { top: -300px; opacity: 0; }
    to { top: 50%; opacity: 1; }
}
</style>

@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/js/tagsinput/jquery.tagsinput.css') }}" />
<style>
    ''
</style>


@stop
 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<?php
   $embed_url = URL::to('/live/embed');
   $embed_media_url = $embed_url . '/' . $video->slug;
   $url_path = '<iframe width="853" height="480" src="'.$embed_media_url.'" frameborder="0" allowfullscreen></iframe>';
   $media_url = URL::to('/live').'/'.$video->slug;
   ?>

@section('content')
<div id="content-page" class="content-page">

     <div class=" d-flex">
        <a class="black" style="background:#fafafa!important;color: #006AFF!important;" href="{{ route( $inputs_details_array['all_list_route'] ) }}">{{ "All " . $inputs_details_array['text_main_name'] . " Stream" }}						</a>
        <a class="black" href="{{ route( $inputs_details_array['create_route'] ) }}">{{ "Add New ". $inputs_details_array['text_main_name'] ."Stream"}}</a>
        @if ( $inputs_details_array['stream_upload_via'] != "radio_station" )
            <a class="black" href="{{ URL::to('admin/CPPLiveVideosIndex') }}">{{  $inputs_details_array['text_main_name'] }} Live stream For Approval</a>
        @endif
     </div>

         <div class="container-fluid p-0">
             <div class="iq-card">
<div id="admin-container" style="padding: 15px;">
<!-- This is where -->
	
	<div class="admin-section-title">
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif   

        
        
	@if(!empty($video->id))
        <div class="d-flex justify-content-between">
            <div>
		<h4>Edit {{ $inputs_details_array['text_main_name'] }} Video</h4> </div>
            <div>
		<a href="{{ route( $inputs_details_array['view_route'],$video->slug) }}" target="_blank" class="btn btn-primary">
			<i class="fa fa-eye"></i> Preview <i class="fa fa-external-link"></i>
		</a>
            </div>
        </div>
	@else
		<h5><i class="entypo-plus"></i> Add New Video</h5> 
	@endif
        <hr>
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
	<div class="clear"></div>

                        <div class="col-3">
                            <label for=""><h5 class="fs-title m-0">Embed Link:</h5></label>
                            <p>Click <a href="#"onclick="EmbedCopy();" class="share-ico"><i class="ri-links-fill"></i> here</a> to get the Embedded URL</p>
                            </div>


		<form method="POST" action="{{ route($inputs_details_array['post_route']) }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data" style="padding: 15px;" id="liveEdit_video">
            
            <div class="row mt-3">
                <div class="col-sm-6">
                    <label class="m-0">Title</label>
                    <p class="p1">Add the {{  $inputs_details_array['text_main_name'] }} title in the textbox below:</p>

                    <div class="panel-body">
                        <input type="text" class="form-control" name="title" id="title" placeholder="Video Title" value="@if(!empty($video->title)){{ $video->title }}@endif" />
                    </div>
                </div>

                @if(!empty($video->created_at))
                <div class="col-sm-6">
                    <label class="m-0">Published Date</label>
                    <p class="p1">{{  $inputs_details_array['text_main_name'] }} Published on Date/Time Below</p>
                    <div class="panel-body">
                        <input type="text" class="form-control" name="created_at" id="created_at" placeholder="" value="@if(!empty($video->created_at)){{ $video->created_at }}@endif" />
                    </div>
                </div>
                @endif

                <div class="col-sm-6">
                    <label class="m-0">Slug</label>
                    <p class="p1">Add the {{  $inputs_details_array['text_main_name'] }} slug in the textbox below:</p>
                    <div class="panel-body">
                        <input type="text" class="form-control" name="slug" id="slug" placeholder="Video Slug" value="@if(!empty($video->slug)){{ $video->slug }}@endif" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                <div class="mt-3">
                            <div class="">
                                <label class="m-0">{{  $inputs_details_array['text_main_name'] }} Image Cover</label>
                                @php 
                                    $width = $compress_image_settings->width_validation_live;
                                    $heigth = $compress_image_settings->height_validation_live
                                @endphp
                                @if($width !== null && $heigth !== null)
                                    <p class="p1">{{ ("Select the {$inputs_details_array['text_main_name']} image (".''.$width.' x '.$heigth.'px)')}}:</p> 
                                @else
                                    <p class="p1">{{ "Select the {$inputs_details_array['text_main_name']} image ( 720 x 1280px )"}}:</p> 
                                @endif

                                <div class="panel-body">
                                <input type="file" multiple="true" class="form-control" name="image" id="image" accept="image/webp"/>
                                <span>
                                    <p id="live_image_error_msg" style="color:red !important; display:none;">
                                        * Please upload an image with the correct dimensions.
                                    </p>
                                </span>    
                            </div>
                            </div>

                            <div class="mt-2 text-center">
                                <div class="panel-body">
                                    @if(!empty($video->image))
                                        <img src="{{ URL::to('/') . '/public/uploads/images/' . $video->image }}" class="video-imgimg w-100" width=""/>
                                    @endif
                                </div>
                            </div>
                        </div>
                </div>
                <div class="col-md-6">
                <div class="row mt-3">
                            <div class="">
                                <label class="m-0">Player Image Cover</label>
                                @php 
                                    $player_width = $compress_image_settings->live_player_img_width;
                                    $player_heigth = $compress_image_settings->live_player_img_height
                                @endphp
                                @if($player_width !== null && $player_heigth !== null)
                                    <p class="p1">{{ ("Select the {$inputs_details_array['text_main_name']} image (".''.$player_width.' x '.$player_heigth.'px)')}}:</p> 
                                @else
                                    <p class="p1">{{ "Select the {$inputs_details_array['text_main_name']} image ( 1280 x 720px )"}}:</p> 
                                @endif

                                <div class="panel-body">
                                <input type="file" multiple="true" class="form-control" name="player_image" id="player_image" accept="image/webp"/>
                                <span>
                                    <p id="live_player_image_error_msg" style="color:red !important; display:none;">
                                        * Please upload an image with the correct dimensions.
                                    </p>
                                </span>     
                            </div>
                            </div>

                            <div class="mt-2 text-center">
                                <div class="panel-body">
                                    @if(!empty($video->player_image))
                                        <img src="{{ URL::to('/') . '/public/uploads/images/' . $video->player_image }}" class="video-imgimg" width="200"/>
                                    @endif
                                </div>
                            </div>
                        </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-sm-6">
                    <div class="">
                        <label class="m-0">TV Image Cover</label>
                        <p class="p1"> Select the {{  $inputs_details_array['text_main_name'] }} image (1920 X 1080  Or 16:9 Ratio)  :</p>
                        <div class="panel-body">
                            <input type="file" multiple="true" class="form-group" name="live_stream_tv_image" id=live_stream_tv_image accept="image/*" />
                        </div>
                    </div>

                    <div class="mt-2 text-center">
                        <div class="panel-body">
                            @if(!empty($video->Tv_live_image))
                                <img src="{{ URL::to('/') . '/public/uploads/images/' . $video->Tv_live_image }}" class="video-imgimg" width="200"/>
                            @endif
                        </div>
                    </div>
                </div>
           </div>

                     {{-- for validate --}} 
               <input type="hidden" id="check_image" name="check_image" value="@if(!empty($video->image) ) {{ "validate" }} @else {{ " " }} @endif"  />
               <input type="hidden" id="player_check_image" name="player_check_image" value="@if(!empty($video->player_image) ) {{ "validate" }} @else {{ " " }} @endif"  />
               <input type="hidden" id="tv_check_image" name="tv_check_image" value="@if(!empty($video->Tv_live_image) ) {{ "validate" }} @else {{ " " }} @endif"  />
               <input type="hidden" name="tv_image_live_validation_status" id="tv_image_live_validation_status" value="{{ tv_image_live_validation_status() }}" />


            <div class="row mt-3">
                <div class="col-sm-6">
                    <div id="source_err_validtion_navigation"></div> <!-- Target element for scrolling -->
                    <label class="m-0">{{  $inputs_details_array['text_main_name'] }} Source</label>

                    <div class="panel-body">
                        <select class="form-control url_type" id="url_type" name="url_type">
                            <option value="">Choose URL Format</option>

                            @if ( $currentRouteName != "admin.radio-station.index")
                                @if ( $inputs_details_array['stream_upload_via'] != "radio_station" )
                                <option value="mp4" @if(!empty($video->url_type) && $video->url_type == 'mp4'){{ 'selected' }}@endif > MP4/M3U8 URL </option>
                                <option value="embed" @if(!empty($video->url_type) && $video->url_type == 'embed'){{ 'selected' }}@endif>Embed URL</option>
                                <option value="live_stream_video" @if(!empty($video->url_type) && $video->url_type == 'live_stream_video'){{ 'selected' }}@endif>{{  $inputs_details_array['text_main_name'] }} Video</option>
                                <option value="m3u_url" @if(!empty($video->url_type) && $video->url_type == 'm3u_url'){{ 'selected' }}@endif> M3U URL </option>
                                @endif
                            @endif
                            <option value="embed" @if(!empty($video->url_type) && $video->url_type == 'embed'){{ 'selected' }}@endif>Embed URL</option>
                            <option value="acc_audio_file" @if(!empty($video->url_type) && $video->url_type == 'acc_audio_file'){{ 'selected' }}@endif > Mp3/AAC Audio File </option>
                            <option value="acc_audio_url" @if(!empty($video->url_type) && $video->url_type == 'acc_audio_url'){{ 'selected' }}@endif > Mp3/AAC Audio URL </option>

                        	@if(!empty($video->url_type) && $video->url_type == 'Encode_video')
                                @foreach($Rtmp_urls as $key => $urls)
                                    <option class="Encode_stream_video" value={{ "Encode_video" }} data-name="{{ $urls->rtmp_url }}" data-hls-url="{{ $urls->hls_url  }}" @if( $urls->rtmp_url == $video->rtmp_url ) {{ 'selected' }} @endif >{{ "RTMP Streaming"." ".($key+1) }} </option>
                                @endforeach 
					        @else
                                 @foreach($Rtmp_urls as $key => $urls)
                                    @php     $number = $key+1;  @endphp
                                    <option class="Encode_stream_video" value={{ "Encode_video" }} data-name="{{ $urls->rtmp_url }}" data-hls-url="{{ $urls->hls_url  }}">{{ "Streaming Video"." ".$number }} </option>
                                @endforeach 
                            @endif
                        </select>

				        <input type="hidden" name="Rtmp_url" id="Rtmp_url" value="" />
                        <input type="hidden" name="hls_url" id="hls_url" value="" />

                            <div class="new-video-upload mt-2" id="mp4_code">
                                <label for="embed_code"><label>{{  $inputs_details_array['text_main_name'] }} URL</label></label>
                                <input type="text" name="mp4_url" class="form-control" id="mp4_url" value="@if(!empty($video->mp4_url) ) {{ $video->mp4_url}}  @endif" />
                            </div>

                            <div class="new-video-upload mt-2" id="embed_code">
                                <label for="embed_code"><label>Live Embed URL</label></label>
                                <input type="text" name="embed_url" class="form-control" id="embed_url" value="@if(!empty($video->embed_url) ) {{ $video->embed_url}}  @endif" />
                            </div>

                            <div class="new-video-upload mt-2" id="m3u_urls">
                                <label for="m3u_url"><label class="mb-1"> M3U URL</label></label>
                                <input type="text" name="m3u_url" class="form-control" id="m3u_url" value="@if(!empty($video->m3u_url) ) {{ $video->m3u_url}}  @endif" />
                            </div>

                            <div class="new-video-upload mt-2" id="live_stream_video">
                                <label for="live_stream_video"><label>{{  $inputs_details_array['text_main_name'] }} Video</label></label>
                                <input type="file" multiple="true" accept="video/mp4,video/x-m4v,video/*" class="form-group live_stream_url_value" name="live_stream_video" id="" />                        
                            </div>

                            <div class="new-video-upload mt-2" id="acc_audio_file">
                                <label for=""><label>ACC Audio File</label></label>
                                <input type="file" multiple="true" accept=".mp3,audio/*" class="form-group audio_stream_url_value" name="acc_audio_file"  />
                            </div>

                            <div class="new-video-upload mt-2 acc_audio_url" id="acc_audio_url">
                                <label><label class="mb-1"> ACC Audio URL</label></label>
                                <input type="text" name="acc_audio_url" class="form-control acc_audio_url_value" value="@if(!empty($video->acc_audio_url) ) {{ $video->acc_audio_url}}  @endif" />
                            </div>

                                            {{-- Audio Upload  --}}
                            <div class="new-video-upload mt-2 uplaod_audio_file" id="uplaod_audio_file">
                                <audio controls controlsList="nodownload">
                                    <source src="@if(!empty($video->acc_audio_file) ) {{ $video->acc_audio_file}}  @endif">
                                  </audio>
                            </div>
                            <a href="#source_err_validtion_navigation">
                                <span id="source_err_validtion" style="color:red;display:none;">Please enter the live url</span>
                            </a>
                            
                            
                    </div>
                </div>

                @if($video->url_type == "Encode_video")
                    <div class="col-sm-6" id="url_rtmp">
                        <label class="m-0">RTMP URL</label>
                        <div class="panel-body">
                            <input type="text" class="form-control" value="@if( !empty($video->Stream_key) && !empty($settings->rtmp_url) ) {{ $video->rtmp_url }}  @else {{ 'NO RTML URL '}} @endif" readonly>
                        </div>
                    </div>
                @endif

                <div class="col-sm-6">
                    <div class="panel-body">
                        @if(!empty($video->mp4_url) )
                        <video width="200" height="200" controls>
                            <source src="{{ $video->mp4_url }}" type="video/mp4" />
                        </video>
                        @endif
                    </div>
                </div>
            </div>


            @if(!empty($video->url_type) && $video->url_type == 'Encode_video')
                <div class="row mt-3">
                    <div class="col-sm-12">
                        <label class="m-0">Streaming Video</label>
                        <div class="panel-body">
                            @if(!empty($video->image))
                            <a class="text-white btn-cl"  data-toggle="modal" data-target="#Stream_video">
                                 <img src="{{ URL::to('/') . '/public/uploads/images/' . $video->image }}" class="video-imgimg" width="150"/>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            @if(!empty($video->url_type) && $video->url_type == 'live_stream_video')
                <div class="row mt-3">
                    <div class="col-sm-12">
                        <label class="m-0">Live Streaming Video</label>
                        <div class="panel-body">
                            @if(!empty($video->image))
                            <a class="text-white btn-cl"  data-toggle="modal" data-target="#Livevideo_upload">
                                 <img src="{{ URL::to('/') . '/public/uploads/images/' . $video->image }}" class="video-imgimg" width="150"/>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

                                 {{-- Re-Stream  --}}
                    <div class="row mt-3">
                        <div class="col-sm-6">
                            <label class="m-0">Enable ReStream</label>
                            <div class="panel-body">
                                <div class="mt-1">
                                    <label class="switch">
                                        <input name="enable_restream" class="enable_restream" id="enable_restream" type="checkbox" @if(!empty($video->enable_restream) && $video->enable_restream == 1){{ 'checked="checked"' }}@elseif(!isset($video->enable_restream)){{ 'checked="checked"' }}@endif >
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label class="m-0">Search Tags</label>
                            <div class="panel-body">
                                <input type="text" id="tag-input1" name="searchtags" >
                            </div>
                        </div>
                    </div>

                                    {{-- YouTube Stream  --}}

                        <div class="row mt-3" id="youtube_restream_url">
                            <div class="col-sm-6">
                                <div class="panel-body">
                                    <div class="mt-2" >
                                        <label class="mb-1"> YouTube Stream (RTMP URL) </label>
                                        <input type="text" name="youtube_restream_url" class="form-control" id="YT_restream_url" placeholder="YouTube Stream Url" value="@if(!empty($video->youtube_restream_url) ) {{ $video->youtube_restream_url}}  @endif" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="panel-body">
                                    <div class="mt-2" id="">
                                        <label class="mb-1"> YouTube Stream Key </label>
                                        <input type="text" name="youtube_streamkey" class="form-control" id="youtube_streamkey" placeholder="YouTube Stream Key" value="@if(!empty($video->youtube_streamkey) ) {{ $video->youtube_streamkey}}  @endif" />
                                    </div>
                                </div>
                            </div>
                        </div>
                                    
                                                {{-- fb Restream --}}

                        <div class="row mt-3" id="fb_restream_url">
                            <div class="col-sm-6">
                                <div class="panel-body">
                                    <div class="mt-2" id="">
                                        <label class="mb-1"> FaceBook Stream (RTMP URL) </label>
                                        <input type="text" name="fb_restream_url" class="form-control" id="facebook_restream_url" placeholder="Facebook Stream" value="@if(!empty($video->fb_restream_url) ) {{ $video->fb_restream_url}} @endif" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6" >
                                <div class="panel-body">
                                    <div class="mt-2" id="">
                                        <label class="mb-1"> FaceBook Stream Key </label>
                                        <input type="text" name="fb_streamkey" class="form-control" id="" placeholder="Facebook Stream Key" value="@if(!empty($video->fb_streamkey) ) {{ $video->fb_streamkey}}  @endif" />
                                    </div>
                                </div>
                            </div>
                        </div>

                                                {{-- Twitter Restream --}}
                        <div class="row mt-3" id="twitter_restream_url">
                            <div class="col-sm-6">
                                <div class="panel-body">
                                    <div class="mt-2" >
                                        <label class="mb-1"> Twitter Stream (RTMP URL) </label>
                                        <input type="text" name="twitter_restream_url" class="form-control"  id="Twitter_Restream_url" placeholder="Twitter Stream" value="@if(!empty($video->twitter_restream_url) ) {{ $video->twitter_restream_url}} @endif" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="panel-body">
                                    <div class="mt-2" >
                                        <label class="mb-1"> Twitter Stream Key </label>
                                        <input type="text" name="twitter_streamkey" class="form-control" id="twitter_streamkey" placeholder="Twitter Stream" value="@if(!empty($video->twitter_streamkey) ) {{ $video->twitter_streamkey}}  @endif" />
                                    </div>
                                </div>
                            </div>
                        </div>

           
            <div class="row mt-3">
                <div class="col-sm-12">
                    <label class="m-0">Short Description</label>
                    <p class="p1">Add a short description of the {{ $inputs_details_array['text_main_name'] }} below:</p>
                    <div class="panel-body">
                        <textarea class="form-control" name="description" id="description">@if(!empty($video->description)){{($video->description) }}@endif</textarea>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-sm-12">
                    <label class="m-0"> Details, Links, and Info</label>

                    <div class="panel-body">
                        <textarea class="form-control" name="details" id="details">@if(!empty($video->details)){{($video->details) }}@endif</textarea>
                    </div>
                </div>
            </div>

            

            <div class="row mt-3">
                <div class="col-sm-6">
                    <label class="m-0">Category</label>
                    <p class="p1">Select a {{  $inputs_details_array['text_main_name'] }} Category Below:</p>

                    <div class="panel-body">
                        <select name="video_category_id[]" id="video_category_id" class="js-example-basic-multiple" style="width: 100%;" multiple="multiple">
                            @foreach($video_categories as $category)
                            @if(in_array($category->id, $category_id))
                            <option value="{{ $category->id }}" selected="true">{{ $category->name }}</option>
                            @else
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endif 
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <label class="m-0">Language</label>
                    <p class="p1">Select a {{  $inputs_details_array['text_main_name'] }} Language Below:</p>

                    <div class="panel-body">
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
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-sm-6">
                    <label class="m-0">{{  $inputs_details_array['text_main_name'] }} Ratings</label>
                    <p class="p1">{{ $inputs_details_array['text_main_name'] }} Ratings 10 out of 10</p>

                    <div class="panel-body">
                        <select  class="js-example-basic-single" style="width: 100%;" name="rating" id="rating" tags= "true" onkeyup="NumAndTwoDecimals(event , this);" >
                            <option value="1" @if(!empty($video->rating) && $video->rating == '1'){{ 'selected' }}@endif >1</option>
                            <option value="2"@if(!empty($video->rating) && $video->rating == '2'){{ 'selected' }}@endif>2</option>
                            <option value="3"@if(!empty($video->rating) && $video->rating == '3'){{ 'selected' }}@endif>3</option>
                            <option value="4"@if(!empty($video->rating) && $video->rating == '4'){{ 'selected' }}@endif>4</option>
                            <option value="5"@if(!empty($video->rating) && $video->rating == '5'){{ 'selected' }}@endif>5</option>
                            <option value="6"@if(!empty($video->rating) && $video->rating == '6'){{ 'selected' }}@endif>6</option>
                            <option value="7"@if(!empty($video->rating) && $video->rating == '7'){{ 'selected' }}@endif>7</option>
                            <option value="8"@if(!empty($video->rating) && $video->rating == '8'){{ 'selected' }}@endif>8</option>
                            <option value="9"@if(!empty($video->rating) && $video->rating == '9'){{ 'selected' }}@endif>9</option>
                            <option value="10"@if(!empty($video->rating) && $video->rating == '10'){{ 'selected' }}@endif>10</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-6">
                    <label class="m-0">{{  $inputs_details_array['text_main_name'] }} Year</label>
                    <p class="p1">{{  $inputs_details_array['text_main_name'] }} Released Year</p>

                    <div class="panel-body">
					   <input class="form-control" name="year" id="year" value="@if(!empty($video->year)){{ $video->year }}@endif">
                    </div>
                </div>
            </div>

                        {{-- Ads --}}
            
            @if( choosen_player() == 1  && ads_theme_status() == 1)    {{-- Video.Js Player--}}

                @if ( admin_ads_pre_post_position() == 1  )

                    <div class="row ">

                        <div class="col-sm-6 form-group mt-3">                        {{-- Pre/Post-Advertisement--}}

                            <label> {{ ucwords( 'Choose the Pre / Post-Position Advertisement' ) }}    </label>
                            
                            <select class="form-control" name="pre_post_ads" >

                                <option value=" " > Select the Post / Pre-Position Advertisement </option>

                                <option value="random_ads" {{  ( $video->pre_post_ads == "random_ads" ) ? 'selected' : '' }} > Random Ads </option>

                                @foreach ($video_js_Advertisements as $video_js_Advertisement)
                                    <option value="{{ $video_js_Advertisement->id }}"  {{  ( $video->pre_post_ads == $video_js_Advertisement->id ) ? 'selected' : '' }} > {{ $video_js_Advertisement->ads_name }}</option>
                                @endforeach
                            
                            </select>
                        </div>
                    </div>
                    
                @elseif ( admin_ads_pre_post_position() == 0 )

                    <div class="row mt-3">

                        <div class="col-sm-6 form-group mt-3">                        {{-- Pre-Advertisement --}}
                            <label> {{ ucwords( 'Choose the Pre-Position Advertisement' ) }}  </label>
                            
                            <select class="form-control" name="pre_ads" >

                                <option value=" " > Select the Pre-Position Advertisement </option>

                                <option value="random_ads" {{  ( $video->pre_ads == "random_ads" ) ? 'selected' : '' }} > Random Ads </option>

                                @foreach ($video_js_Advertisements as $video_js_Advertisement)
                                    <option value="{{ $video_js_Advertisement->id }}"  {{  ( $video->pre_ads == $video_js_Advertisement->id ) ? 'selected' : '' }} > {{ $video_js_Advertisement->ads_name }}</option>
                                @endforeach
                                
                            </select>
                        </div>

                        <div class="col-sm-6 form-group mt-3">                        {{-- Post-Advertisement--}}
                            <label> {{ ucwords( 'Choose the Post-Position Advertisement' ) }}    </label>
                            
                            <select class="form-control" name="post_ads" >

                                <option value=" " > Select the Post-Position Advertisement </option>

                                <option value="random_ads" {{  ( $video->post_ads == "random_ads" ) ? 'selected' : '' }} > Random Ads </option>

                                @foreach ($video_js_Advertisements as $video_js_Advertisement)
                                    <option value="{{ $video_js_Advertisement->id }}"  {{  ( $video->post_ads == $video_js_Advertisement->id ) ? 'selected' : '' }} > {{ $video_js_Advertisement->ads_name }}</option>
                                @endforeach
                            
                            </select>
                        </div>
                    </div>

                @endif

                <div class="row">
                    <div class="col-sm-6 form-group mt-3">            {{-- Mid-Advertisement--}}
                        <label> {{ ucwords( 'choose the Mid-Position Advertisement Category' ) }}  </label>
                        <select class="form-control" name="mid_ads" >

                            <option value=" " > Select the Mid-Position Advertisement Category </option>

                            <option value="random_category"  {{  ( $video->mid_ads == "random_category" ) ? 'selected' : '' }} > Random Category </option>

                            @foreach( $ads_category as $ads_category )
                            <option value="{{ $ads_category->id }}"  {{  ( $video->mid_ads == $ads_category->id ) ? 'selected' : '' }} > {{ $ads_category->name }}</option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-sm-6 form-group mt-3">                        {{-- Mid-Advertisement sequence time--}}
                        <label> {{ ucwords( 'Mid-Advertisement Sequence Time' ) }}   </label>
                        <input type="text" class="form-control" name="video_js_mid_advertisement_sequence_time"  placeholder="HH:MM:SS"  id="video_js_mid_advertisement_sequence_time" value="{{ $video->video_js_mid_advertisement_sequence_time }}" >
                    </div>

                </div>
            
                    {{-- Ply.io --}}
            @else   

                @if ( $inputs_details_array['stream_upload_via'] != "radio_station" )
                <div class="row mt-3">
                    <div class="col-sm-6"  >
                        <label class="m-0">Choose Ads Position</label>
                        <select class="form-control" name="ads_position" id="ads_position" >

                            <option value=" ">Select the Ads Position </option>
                            <option value="pre"  @if(($video->ads_position != null ) && $video->ads_position == 'pre'){{ 'selected' }}@endif >  Pre-Ads Position</option>
                            <option value="mid"  @if(($video->ads_position != null ) && $video->ads_position == 'mid'){{ 'selected' }}@endif >  Mid-Ads Position</option>
                            <option value="post" @if(($video->ads_position != null ) && $video->ads_position == 'post'){{ 'selected' }}@endif > Post-Ads Position</option>
                            <option value="all"  @if(($video->ads_position != null ) && $video->ads_position == 'all'){{ 'selected' }}@endif >   All Ads Position</option>
                        </select>
                    </div>

                    <div class="col-sm-6"  >
                        <label class="">Choose Advertisement </label>
                        <select class="form-control" name="live_ads" id="live_ads" >
                            <option value=" ">Select the Advertisement </option>
                            @if( $video->live_ads != null)
                                @php $ads_name = App\Advertisement::where('id',$video->live_ads)->pluck('ads_name')->first() ;@endphp
                                <option value="{{ $video->live_ads }}" {{ 'selected' }}> {{ $ads_name }} </option>
                            @endif
                        </select>
                    </div>
                </div>
                @endif
            @endif

            @if ( $inputs_details_array['stream_upload_via'] != "radio_station" )   
            <div class="row mt-3">
                <div class="col-sm-6">
                    <label class="m-0">Enable Free Duration</label>
                    <p class="p1">Enable / Disable Free Duration</p>
                    <div class="panel-body">
                        <div class="mt-1">
                            <label class="switch">
                                <input name="free_duration_status"  id="free_duration_status" type="checkbox"  {{ !empty($video->free_duration_status) && $video->free_duration_status == 1 ? "checked" : null }} >
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <label class="m-0">Free Duration</label>
                    <p class="p1">Enter the {{  $inputs_details_array['text_main_name'] }} Free duration in (HH : MM : SS)</p>
                    <div class="panel-body">
                        <input class="form-control" name="free_duration" placeholder="HH:MM:SS" id="free_duration" value="@if(!empty($video->free_duration)){{ gmdate('H:i:s', $video->free_duration) }}@endif" />
                    </div>
                </div>
            </div>
            @endif
            
            <div class="row mt-3">

                @if ( $inputs_details_array['stream_upload_via'] != "radio_station" )   
                <div class="col-sm-6">
                    <label class="m-0">Duration</label>
                    <p class="p1">Enter the {{  $inputs_details_array['text_main_name'] }} duration in (HH : MM : SS)</p>
                    <div class="panel-body">
                        <input class="form-control" name="duration" id="duration" placeholder="HH:MM:SS" value="@if(!empty($video->duration)){{ gmdate('H:i:s', $video->duration) }}@endif" />
                    </div>
                </div>
                @endif
                
                <div class="col-sm-6">
                    <label class="m-0">Block Country</label>
                    <p class="p1">( Choose the countries for block the {{  $inputs_details_array['text_main_name'] }} )</p>
                    <div class="panel-body">
                        <select  name="country[]" class="js-example-basic-multiple" style="width: 100%;" multiple="multiple">
                                @foreach($countries as $country)
                                @if(in_array($country->country_name, $block_countries))
                                    <option value="{{ $country->country_name  }}" selected="true">{{ $country->country_name }}</option>
                                @else
                                    <option value="{{ $country->country_name  }}">{{$country->country_name }}</option>
                                @endif 
                                @endforeach
                            </select>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>

                {{-- Macros --}}

            @if ( $inputs_details_array['stream_upload_via'] != "radio_station" )
            <div class="row mt-3">

                <div class="col-sm-6">
                    <label class="m-0">{{ __( ucwords('ads content id') ) }}</label>
                    <p class="p1">Add the Live stream Ads content id in the textbox below:</p>
                    <div class="panel-body">
                        <input type="text" class="form-control" name="ads_content_id"  placeholder="Live stream Ads content id" value="{{ @$video->ads_content_id }}" />
                    </div>
                </div>

                <div class="col-sm-6">
                    <label class="m-0">{{ __( ucwords('Ads content title') ) }}</label>
                    <p class="p1">Add the Live stream Ads content title in the textbox below:</p>
                    <div class="panel-body">
                        <input type="text" class="form-control" name="ads_content_title"  placeholder="Live stream Ads content title" value="{{ @$video->ads_content_title }}" />
                    </div>
                </div>
            </div>

            <div class="row mt-3">

                <div class="col-sm-6">
                    <label class="m-0">{{ __( ucwords('Ads content category') ) }}</label>
                    <p class="p1">Add the Live stream Ads content category in the textbox below:</p>
                    <div class="panel-body">
                        <input type="text" class="form-control" name="ads_content_category"  placeholder="Live stream Ads content category" value="{{ $video->ads_content_category }}" />
                    </div>
                </div>

                <div class="col-sm-6">
                    <label class="m-0">{{ __( ucwords('Ads content language') ) }}</label>
                    <p class="p1">Add the Live stream Ads content language in the textbox below:</p>
                    <div class="panel-body">
                        <input type="text" class="form-control" name="ads_content_language"  placeholder="Live stream Ads content language" value="{{ @$video->ads_content_language }}" />
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-sm-6">
                    <label class="m-0">{{ __( ucwords('Ads content genre') ) }}</label>
                    <p class="p1">Add the Live stream Ads content genre in the textbox below:</p>
                    <div class="panel-body">
                        <input type="text" class="form-control" name="ads_content_genre"  placeholder="Live stream Ads content genre" value="{{ @$video->ads_content_genre }}"  />
                    </div>
                </div>
            </div>
            @endif

                     {{-- User Access --}}
            <div class="row mt-3">
                <div class="col-sm-6">
                    <label class="m-0">User Access</label>
                    <p class="p1">Who is allowed to view this {{  $inputs_details_array['text_main_name'] }}?</p>
                    <div class="panel-body">
                        <select class="form-control" id="access" name="access">
                            <option value="guest" @if(!empty($video->access) && $video->access == 'guest'){{ 'selected' }}@endif>Guest (everyone)</option>
                            <option value="subscriber" @if(!empty($video->access) && $video->access == 'subscriber'){{ 'selected' }}@endif >Subscriber (only paid subscription users)</option>
                            <option value="ppv" @if(!empty($video->access) && $video->access == 'ppv'){{ 'selected' }}@endif >PPV Users (Pay per movie)</option>     
                        </select>
                        <div class="clear"></div>
                    </div>
                </div>

                <div class="col-sm-3 ppv_price">
                    <label class="m-0">PPV Price</label>
                    <p class="p1">Apply PPV Price from Global Settings?</p>
                    <div class="panel-body">
                        <input type="text" class="form-control" name="ppv_price" id="price" value="<?php if(!empty($video->ppv_price)) { echo $video->ppv_price ; }else{  } ?>" >
                        <div class="clear"></div>
                    </div>
                </div>

                <div class="col-sm-3 ppv_price">
                    <label class="m-0"> IOS PPV Price</label>
                    <p class="p1">Apply IOS PPV Price from Global Settings?</p>
                    <div class="panel-body">
                        <select  name="ios_ppv_price" class="form-control" id="ios_ppv_price">
                            <option value= "" >Select IOS PPV Price: </option>
                            @foreach($InappPurchase as $Inapp_Purchase)
                                 <option value="{{ $Inapp_Purchase->product_id }}"  @if($video->ios_ppv_price == $Inapp_Purchase->product_id) selected='selected' @endif >{{ $Inapp_Purchase->plan_price }}</option>
                            @endforeach
                         </select>
                    </div>
                </div>
            </div>
            
            <div class="row mt-3">

                <div class="col-sm-4">
                    <label class="m-0">Publish Type</label>
                    <div class="panel-body" style="color: #000;">
                        <input type="radio" id="publish_now" name="publish_type" value = "publish_now" {{ !empty(($video->publish_type=="publish_now"))? "checked" : "" }}> <label for="publish_now" style="font-weight: 500; font-size:14px;"> {{ __('Publish Now')}}</label> <br>
				        <input type="radio" id="publish_later" name="publish_type" value = "publish_later"  {{ !empty(($video->publish_type=="publish_later")) ? "checked" : "" }}> <label for="publish_later" style="font-weight: 500; font-size:14px;"> {{ __('Publish Later')}}</label> <br>

                        @if ( $inputs_details_array['stream_upload_via'] != "radio_station" )
                            <input type="radio" id="recurring"     name="publish_type"  value="recurring_program"  {{ !empty(($video->publish_type=="recurring_program"))? "checked" : "" }} /> <label for="recurring" style="font-weight: 500; font-size:14px;"> {{ __('Recurring Program')}}</label> <br />
                        @endif

                        @if ( $inputs_details_array['stream_upload_via'] == "radio_station" )
                            <input type="radio" id="scheduleprogram" name="publish_type" value="schedule_program" {{ !empty(($video->publish_type=="schedule_program"))? "checked" : "" }} /> <label for="scheduleprogram" style="font-weight: 500; font-size:14px;"> {{ __('Schedule Program')}}</label> <br />
                        @endif
                    </div>
                </div>

        
                {{-- Schedule Program Modal --}}

                @if ( $inputs_details_array['stream_upload_via'] == "radio_station" )
                    <div class="modal" data-keyboard="false" data-backdrop="static" id="schedule_program_modal"  tabindex="-1" role="dialog">
                        <div class="modal-content" style="overflow-y: auto;">
                            <div class="modal-header d-flex justify-content-between">
                                <div class=""><h4>Schedule Program</h4></div>
                                <div class="close-icon">&times;</div>
                            </div>
                    
                            <div class="modal-body">
                                <div class="row mt-2">
                                    <div class="col-sm-12">
                                        <label class="m-0">Program Days <small>(Select the Multiple days)</small></label>
                                        <div class="panel-body">
                                            <select class="form-control js-example-basic-multiple" id="scheduler_program_days" name="scheduler_program_days[]" style="width: 100%;" multiple="multiple">
                                                <option value="0" {{ !empty($video->scheduler_program_days) && in_array("0", json_decode($video->scheduler_program_days)) ? 'selected' : '' }}>Sunday</option>
                                                <option value="1" {{ !empty($video->scheduler_program_days) && in_array("1", json_decode($video->scheduler_program_days)) ? 'selected' : '' }}>Monday</option>
                                                <option value="2" {{ !empty($video->scheduler_program_days) && in_array("2", json_decode($video->scheduler_program_days)) ? 'selected' : '' }}>Tuesday</option>
                                                <option value="3" {{ !empty($video->scheduler_program_days) && in_array("3", json_decode($video->scheduler_program_days)) ? 'selected' : '' }}>Wednesday</option>
                                                <option value="4" {{ !empty($video->scheduler_program_days) && in_array("4", json_decode($video->scheduler_program_days)) ? 'selected' : '' }}>Thursday</option>
                                                <option value="5" {{ !empty($video->scheduler_program_days) && in_array("5", json_decode($video->scheduler_program_days)) ? 'selected' : '' }}>Friday</option>
                                                <option value="6" {{ !empty($video->scheduler_program_days) && in_array("6", json_decode($video->scheduler_program_days)) ? 'selected' : '' }}>Saturday</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                </div>
                    
                                <table class="table custom-table" id="program-fields-table" style="margin-top: 10px;">
                                    <thead style="border-bottom: none !important;">
                                        <tr>
                                            <th> <label> # </label></th> 
                                            <th> <label>  Program Title </label></th>
                                            <th> <label> Start Time <small>(24-hrs format)</small> </label> </th>
                                            <th> <label>End Time <small>(24-hrs format)</small> </label> </th>
                                            <th> <label> Action </label></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse ($scheduler_program['scheduler_program_title'] as $index => $title)
                                            <tr class="program-fields">
                                                <td>{{ $index + 1 }}</td>

                                                <td>
                                                    <input class="form-control" placeholder="Enter the Show Name" name="scheduler_program_title[]" value="{{ $title }}" required />
                                                </td>

                                                <td>
                                                    <input type="time" class="form-control" name="scheduler_program_start_time[]" value="{{ $scheduler_program['scheduler_program_start_time'][$index] ?? '' }}" required />
                                                </td>

                                                <td>
                                                    <input type="time" class="form-control" name="scheduler_program_end_time[]" value="{{ $scheduler_program['scheduler_program_end_time'][$index] ?? '' }}" required />
                                                </td>

                                                <td class="d-flex justify-content-center align-items-center p-3">
                                                    <i class="fa fa-plus-circle add-program-btn mx-2"></i>
                                                    <i class="fa fa-minus-circle remove-program-btn mx-2"></i>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr class="program-fields">
                                                <td>{{ 1 }}</td>

                                                <td>
                                                    <input class="form-control" placeholder="Enter the Show Name" name="scheduler_program_title[]"  required />
                                                </td>

                                                <td>
                                                    <input type="time" class="form-control" name="scheduler_program_start_time[]" required />
                                                </td>

                                                <td>
                                                    <input type="time" class="form-control" name="scheduler_program_end_time[]"  required />
                                                </td>

                                                <td class="d-flex justify-content-center align-items-center p-3">
                                                    <i class="fa fa-plus-circle add-program-btn mx-2"></i>
                                                </td>
                                            </tr>
                                            
                                        @endforelse

                                    </tbody>
                                </table>
                                
                            </div>
                    
                            <div class="modal-footer" style="background:#ffffff">
                                <div class="submit-btn btn-primary" id="submitModal"> Schedule </div>
                            </div>

                        </div>
                    </div>
                @endif

                <div class="col-sm-4" >
                    <div id="publishlater" style="{{ !empty($video->publish_time)  ? '' : 'display: none' }}">
                        <label class="m-0">Publish Time</label>
                        <div class="panel-body">
                            <input type="datetime-local" class="form-control" id="publish_time" name="publish_time" value="@if(!empty($video->publish_time)){{ $video->publish_time }}@endif" style="display: block !important"/>
                            <span class="text-danger" style="display:none;">*This field is required</span>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-4" id="">
                    <label class="m-0">Status Settings</label>
                    <div class="panel-body">
                        <div>
                            <label for="featured" >Is this {{  $inputs_details_array['text_main_name'] }} Featured:</label>
                            <input type="checkbox" @if(!empty($video->featured) && $video->featured == 1){{ 'checked="checked"' }}@endif name="featured" value="1" id="featured" />
                        </div>
                        <div class="clear"></div>
                        <div>
                            <label for="active" >Is this {{  $inputs_details_array['text_main_name'] }} Active:</label>
                            <input type="checkbox" @if(!empty($video->active) && $video->active == 1){{ 'checked="checked"' }}@elseif(!isset($video->active)){{ 'checked="checked"' }}@endif name="active" value="1" id="active" />
                        </div>
                        <div class="clear"></div>
                        <div>
                            <label for="banner" >Is this {{  $inputs_details_array['text_main_name'] }} display in Banner:</label>
                            <input type="checkbox" @if(!empty($video->banner) && $video->banner == 1){{ 'checked="checked"' }}@endif name="banner" value="1" id="banner" />
                        </div>
                        <div>
                            <!-- <label for="footer" >Is this video display in footer:</label>
                            <input type="checkbox" @if(!empty($video->footer) && $video->footer == 1){{ 'checked="checked"' }}@endif name="footer" value="1" id="footer" /> -->
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recurring Program  --}}
            
            <div class="row mt-3">

                <div class="col-sm-3 recurring_timezone" style="{{  !empty($video->recurring_timezone)  ? '' : 'display: none' }}">
                    <label class="m-0">{{ __('Recurring Time Zone')}} </label>
                    <select class="form-control" name="recurring_timezone"  >
                        @foreach ($Timezone as $item)
                            <option value={{ $item->id }} {{ $item->id == $video->recurring_timezone ? "selected" : null }}>{{ $item->time_zone  }} </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-sm-3" id="recurring_program" style="{{  $video->publish_type == 'recurring_program' ? '' : 'display: none' }}">
                    <label class="m-0">{{ __('Recurring Program')}} </label>
                    <select class="form-control" name="recurring_program"  id="recurring_program_dropdown">
                        <option value=" ">Select the Recurring Period </option>
                        <option value="daily" {{ !empty(($video->recurring_program=="daily"))? "selected" : "" }} >  Daily </option>
                        <option value="weekly" {{ !empty(($video->recurring_program=="weekly"))? "selected" : "" }} >  Weekly </option>
                        <option value="monthly" {{ !empty(($video->recurring_program=="monthly"))? "selected" : "" }} > Monthly </option>
                        <option value="custom" {{ !empty(($video->recurring_program=="custom"))? "selected" : "" }} > Custom Time Period</option>
                    </select>
                </div>

                <div class="col-sm-2 recurring_program_week_day" style="{{ !is_null($video->recurring_program_week_day)  ? '' : 'display: none' }}" >
                    <label class="m-0">{{ __('Week Days ')}} </label>
                    <select class="form-control" name="recurring_program_week_day" >
                        <option value="1"  {{ !empty(($video->recurring_program_week_day== 1))? "selected" : "" }}  >  Monday </option>
                        <option value="2"  {{ !empty(($video->recurring_program_week_day==2))? "selected" : "" }} >  Tuesday </option>
                        <option value="3"  {{ !empty(($video->recurring_program_week_day==3))? "selected" : "" }} > Wednesday </option>
                        <option value="4"  {{ !empty(($video->recurring_program_week_day==4))? "selected" : "" }} > Thrusday</option>
                        <option value="5"  {{ !empty(($video->recurring_program_week_day==5))? "selected" : "" }} > Friday</option>
                        <option value="6"  {{ !empty(($video->recurring_program_week_day== 6))? "selected" : "" }} > Saturday</option>
                        <option value="7"  {{ !empty(($video->recurring_program_week_day==7))? "selected" : "" }}  > Sunday </option>
                    </select>
                </div>

                <div class="col-sm-2 recurring_program_month_day"  style="{{ !empty($video->recurring_program_month_day)  ? '' : 'display: none' }}">
                    <label class="m-0">{{ __('Month Days ')}} </label>
                    <select class="form-control" name="recurring_program_month_day" >
                        @for ($i = 1; $i <= 31 ; $i++)
                            <option value="{{ $i }}" {{ !empty(($video->recurring_program_month_day == $i ))? "selected" : "" }} > {{ $i }} </option>
                        @endfor
                    </select>
                </div>

                <div class="col-sm-2 program_time"  style="{{ !empty($video->program_start_time)  ? '' : 'display: none' }}" >
                    <label class="m-0">Program Start Time   </label>
                    <div class="panel-body">
                        <input type="time" class="form-control prog-start-time" name="program_start_time" value="{{ !empty($video->program_start_time) ? $video->program_start_time : null }}" />
                    </div>
                </div>

                <div class="col-sm-2 program_time" style="{{ !empty($video->program_end_time)  ? '' : 'display: none' }}" >
                    <label class="m-0">Program End Time   </label>
                    <div class="panel-body">
                        <input type="time" class="form-control prog-end-time" name="program_end_time" value="{{ !empty($video->program_end_time) ? $video->program_end_time : null }}" />
                    </div>
                </div>

                <div class="col-sm-3 custom_program_time"  style="{{  !empty($video->custom_start_program_time) ? '' : 'display: none' }}" >
                    <label class="m-0">Custom Start Program Time </label>
                    <div class="panel-body">
                        <input type="datetime-local" class="form-control" id="custom_start_program_time" name="custom_start_program_time" value="{{ !empty($video->custom_start_program_time) ? $video->custom_start_program_time : null }}"  />
                    </div>
                </div>

                <div class="col-sm-3 custom_program_time"  style="{{  !empty($video->custom_end_program_time) ? '' : 'display: none' }}" >
                    <label class="m-0">Custom End Program Time </label>
                    <div class="panel-body">
                        <input type="datetime-local" class="form-control" id="custom_end_program_time" name="custom_end_program_time" value="{{ !empty($video->custom_end_program_time) ? $video->custom_end_program_time : null }}"  />
                    </div>
                </div>

                <div class="clear"></div>
            </div>
            <br>
                    
			<!-- row -->

			@if(!isset($video->user_id))
				<input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}" />
			@endif

			@if(isset($video->id))
				<input type="hidden" id="id" name="id" value="{{ $video->id }}" />
				<input type="hidden" id="publish_status" name="publish_status" value="{{ $video->publish_status }}" >
				<!-- <input type="hidden"  name="ppv_price" id="price" value="$video->ppv_price"> -->
			@endif

			<input type="hidden" class="btn btn-primary" name="_token" value="<?= csrf_token() ?>" />
			<input type="submit" value="{{ $button_text }}" class="btn btn-primary pull-right" />

		</form>
<input type="hidden" name="search_tag" id="search_tag" value="{{ $video->search_tags }}">
		<div class="clear"></div>
<!-- This is where now -->
</div>
    </div></div>

       
                    <!-- Restream Modal -->
        <input type="hidden" class="btn btn-primary btn-lg" data-toggle="modal" id="restream_button" data-backdrop="static" data-target="#myModal">

        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="border:none;">
                        <button type="button" class="close restream_modal_close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <h4 class="modal-title text-center">Choose A Platfrom</h4>
                        <div class="container mt-5">

                            <div class="row">

                                <div class="col-md-4 youtube_col"> 
                                    <a class="youtube_btn btn btn-outline-primary">
                                        <img class="w-50" src="<?php echo  URL::to('/assets/img/you.png')?>" >
                                        <p class="mb-0 Youtube">Youtube</p>
                                    </a>
                                </div>

                                <div class="col-md-4 facebook_col"> 
                                    <a class="facebook_btn btn btn-outline-primary" value="ss">
                                        <img class="w-100" src="<?php echo  URL::to('/assets/img/face.jpg')?>" >
                                        <p class="mb-0 Facebook">Facebook</p>
                                    </a>
                                </div>

                                <div class="col-md-4 twitter_col"> 
                                    <a class="twitter_btn btn btn-outline-primary">
                                        <img class="w-50" src="<?php echo  URL::to('/assets/img/twitter.png')?>" >
                                        <p class="mb-0 Twitters" value="sss">Twitter</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer p-4" style="background:#0000FF;border:none; justify-content: space-between;">
                        <p class="text-white">Get more power from Restream </p>
                        <button type="button" class="btn btn-secondary restream_modal_save" data-dismiss="modal"> Save</button>
                    </div>
                </div>
            </div>
        </div>
</div>
	
@php
    $liveStreamVideo_errors = $liveStreamVideo_error;
@endphp	
	
	@section('javascript')

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.min.js"></script>
	<script type="text/javascript" src="{{ URL::to('/assets/admin/js/tinymce/tinymce.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::to('/assets/js/tagsinput/jquery.tagsinput.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::to('/assets/js/jquery.mask.min.js') }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
    <script src="<?= URL::to('/assets/js/jquery.mask.min.js');?>"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdn.ckeditor.com/ckeditor5/38.1.1/classic/ckeditor.js"></script>


<script>
    $(document).ready(function() {
        var previousValue = $('#access').val();
        var access_pass = '<?= $access_password ?>';
        var access_btn_staus = '<?= $access_btn_staus ?>';
        console.log('access_btn_staus: ' + access_btn_staus);
        
        
        if(access_btn_staus == 1){
            $('#access').change(function() {
                var newValue = $(this).val();

                if (newValue !== previousValue) {
                    var password = prompt("Please enter your password:");

                    if (password === access_pass ) {
                        previousValue = newValue;
                    } else {
                        $(this).val(previousValue);
                        alert("Incorrect password. Access level not changed.");
                    }
                }
            });

            $('.pull-right').click(function(event) {
                if ($('#access').val() === previousValue) {
                    return true;
                } else {
                    event.preventDefault();
                    alert("Please change the access level back or enter the correct password.");
                }
            });
        };
    });
</script>

<script>
         ClassicEditor
            .create( document.querySelector( '#details' ) )
            .catch( error => {
                console.error( error );
            } );

         ClassicEditor
            .create( document.querySelector( '#description' ) )
            .catch( error => {
                console.error( error );
            } );
</script>
{{-- 
<!-- Empty url validation Live Stream Source -->
<script>
    $(document).ready(function() {
        function validateForm(event) {
            let urlType = $('#url_type').val(); // Get the selected URL type
            var url_value = $('#mp4_url').val();
            var embed_url_value = $('#embed_url').val();
            var live_stream_url_value = $('.live_stream_url_value').val();
            var m3u_url_value = $('#m3u_url').val();
            var acc_audio_file_value = $('.audio_stream_url_value').val();
            var acc_audio_url_value = $('.acc_audio_url_value').val();

            // If urlType is not selected or invalid, prevent form submission
            if (urlType === '') {
                $('#source_err_validtion').show().text('Please select a URL type.');
                $('html, body').animate({
                    scrollTop: $('#source_err_validtion_navigation').offset().top
                }, 500);
                event.preventDefault();
                return false;
            }

            // Validate based on selected urlType
            if (urlType === 'mp4' && !url_value) {
                $('#source_err_validtion').show().text('Please enter the MP4 URL.');
                $('html, body').animate({
                    scrollTop: $('#source_err_validtion_navigation').offset().top
                }, 500);
                event.preventDefault();
            } else if (urlType === 'embed' && !embed_url_value) {
                $('#source_err_validtion').show().text('Please enter the Embed URL.');
                $('html, body').animate({
                    scrollTop: $('#source_err_validtion_navigation').offset().top
                }, 500);
                event.preventDefault();
            } else if (urlType === 'live_stream_video' && !live_stream_url_value) {
                $('#source_err_validtion').show().text('Please select a Live Stream video.');
                $('html, body').animate({
                    scrollTop: $('#source_err_validtion_navigation').offset().top
                }, 500);
                event.preventDefault();
            } else if (urlType === 'm3u_url' && !m3u_url_value) {
                $('#source_err_validtion').show().text('Please enter the M3U URL.');
                $('html, body').animate({
                    scrollTop: $('#source_err_validtion_navigation').offset().top
                }, 500);
                event.preventDefault();
            } else if (urlType === 'acc_audio_file' && !acc_audio_file_value) {
                $('#source_err_validtion').show().text('Please upload an AAC audio file.');
                $('html, body').animate({
                    scrollTop: $('#source_err_validtion_navigation').offset().top
                }, 500);
                event.preventDefault();
            } else if (urlType === 'acc_audio_url' && !acc_audio_url_value) {
                $('#source_err_validtion').show().text('Please enter the AAC audio URL.');
                $('html, body').animate({
                    scrollTop: $('#source_err_validtion_navigation').offset().top
                }, 500);
                event.preventDefault();
            } else {
                $('#source_err_validtion').hide(); // Hide the error if validation passes
            }
        }

        // Trigger validation when form is submitted
        $('#liveEdit_video').on('submit', function(event) {
            validateForm(event);
        });

        // Trigger validation when url type is changed
        $('#url_type').change(function() {
            validateForm(); // Ensure validation runs when user changes the url_type
        });
    });



</script> --}}

<script type="text/javascript">
   $ = jQuery;

   $(document).ready(function($){
    $("#duration").mask("00:00:00");
    $("#free_duration").mask("00:00:00");
    $("#video_js_mid_advertisement_sequence_time").mask("00:00:00");

   });
  
    var Stream_error = '{{ $liveStreamVideo_errors }}';

    $( document ).ready(function() {
		var Stream_error = '{{ $Stream_error }}';
		var Rtmp_url   = "{{ $Rtmp_url ? $Rtmp_url : 'No RTMP URL Added' }}" ;	
		var Stream_keys = '{{ $Stream_key }}';
		var Title = "{{ 'RTMP Streaming Details for'.' '. $title }}";
		var Rtmp_url   = "{{ $Rtmp_url ? $Rtmp_url : 'No RTMP URL Added' }}" ;
		var hls_url   = "{{ $hls_url ? $hls_url : 'No HLS URL Added' }}" ;

	
		if( Stream_error == 1){
			Swal.fire({
			allowOutsideClick:false,
			icon: 'success',
			title: Title,
			html: '<div class="col-md-12">' + 'RTMP URL :  ' + Rtmp_url + '</div>' +"<br>"+ 
					  '<div class="col-md-12">' + 'Stream Key :  ' +  Stream_keys + '</div>'+"<br>"
                      ,
			}).then(function (result) {
			if (result.value) {
				@php
						session()->forget('Stream_key');
						session()->forget('Stream_error');
				@endphp
				location.href = "{{ route( $inputs_details_array['edit_route'], $video->id )}}";
			}
			})
		}
	});

     // Restream Script 

     $(document).ready(function(){
        
        if (!$('#YT_restream_url').val()) {
            $('#youtube_restream_url').hide();
        }

        if (!$('#Twitter_Restream_url').val()) {
            $('#twitter_restream_url').hide();
        }

        if (!$('#facebook_restream_url').val()) {
            $('#fb_restream_url').hide();
        }
        
        $(".restream_modal_close").click(function() {
            $("#enable_restream").attr("checked", false);
        });

        $("#enable_restream").change(function(){
            var enable_restream  = $("#enable_restream").prop("checked");
            if(enable_restream == true){
                document.getElementById("restream_button").click();
            }

            if(enable_restream == false){
                $('#fb_restream_url').hide();
                $('#youtube_restream_url').hide();
                $('#twitter_restream_url').hide();
            }
        });

        $(".youtube_col").click(function(){
            $(".youtube_btn").toggleClass('active');
            $(".Youtube").toggleClass('restream_active');
        });

        $(".facebook_col").click(function(){
            $(".facebook_btn").toggleClass('active');
            $(".Facebook").toggleClass('restream_active');
        });

        $(".twitter_col").click(function(){
            $(".twitter_btn").toggleClass('active');
            $(".Twitters").toggleClass('restream_active');
        });

        $(".restream_modal_save").click(function(){

            $('#fb_restream_url').hide();
            $('#youtube_restream_url').hide();
            $('#twitter_restream_url').hide();

            var inputs =  $('.restream_active');
           
            for(var i=0 ; i < inputs.length; i++  )
            {
                if( $(inputs[i]).html() == "Facebook"){
                    $('#fb_restream_url').show();
                }

                if( $(inputs[i]).html() == "Youtube"){
                    $('#youtube_restream_url').show();
                }

                if( $(inputs[i]).html() == "Twitter"){
                    $('#twitter_restream_url').show();
                }
            }
        });
    });


$(document).ready(function(){

                    // Image upload dimention validation
        // $.validator.addMethod('dimention', function(value, element, param) {
        //     if(element.files.length == 0){
        //         return true; 
        //     }

        //     var width = $(element).data('imageWidth');
        //     var height = $(element).data('imageHeight');
        //     var ratio = $(element).data('imageratio');
        //     var image_validation_status = "{{  image_validation_live() }}" ;

        //     if( image_validation_status == "0" ||  ratio == '0.56'|| width == param[0] && height == param[1]){
        //         return true;
        //     }else{
        //         return false;
        //     }
        // },'Please upload an image with 1080 x 1920 pixels dimension or 9:16 ratio');

        //         // player Image upload validation
        // $.validator.addMethod('player_dimention', function(value, element, param) {
        //     if(element.files.length == 0){
        //         return true; 
        //     }

        //     var width = $(element).data('imageWidth');
        //     var height = $(element).data('imageHeight');
        //     var ratio = $(element).data('imageratio');
        //     var image_validation_status = "{{  image_validation_live() }}" ;

        //     if( image_validation_status == "0" ||  ratio == '1.78' || width == param[0] && height == param[1]){
        //         return true;
        //     }else{
        //         return false;
        //     }
        // },'Please upload an image with 1280 x 720 pixels dimension or 16:9 ratio');

        //                         // TV Image upload validation
        // $.validator.addMethod('tv_image_dimention', function(value, element, param) {
        //     if(element.files.length == 0){
        //         return true; 
        //     }

        //     var width = $(element).data('imageWidth');
        //     var height = $(element).data('imageHeight');
        //     var ratio = $(element).data('imageratio');
        //     var image_validation_status = "{{  image_validation_live() }}" ;

        //     if( image_validation_status == "0" || ratio == '1.78' ||  width == param[0] && height == param[1]){
        //         return true;
        //     }else{
        //         return false;
        //     }
        // },'Please upload an image with 1920  x 1080 pixels dimension or 16:9 ratio');


        // $('#image').change(function() {

        //     $('#image').removeData('imageWidth');
        //     $('#image').removeData('imageHeight');
        //     $('#image').removeData('imageratio');

        //     var file = this.files[0];
        //     var tmpImg = new Image();

        //     tmpImg.src=window.URL.createObjectURL( file ); 
        //     tmpImg.onload = function() {
        //         width = tmpImg.naturalWidth,
        //         height = tmpImg.naturalHeight;
		// 		ratio =  Number(width/height).toFixed(2) ;
        //         $('#image').data('imageWidth', width);
        //         $('#image').data('imageHeight', height);
        //         $('#image').data('imageratio', ratio);
        //     }
        // });

        // $('#player_image').change(function() {

        //     $('#player_image').removeData('imageWidth');
        //     $('#player_image').removeData('imageHeight');
        //     $('#player_image').removeData('imageratio');

        //     var file = this.files[0];
        //     var tmpImg = new Image();

        //     tmpImg.src=window.URL.createObjectURL( file ); 
        //     tmpImg.onload = function() {
        //         width = tmpImg.naturalWidth,
        //         height = tmpImg.naturalHeight;
		// 		ratio =  Number(width/height).toFixed(2) ;
        //         $('#player_image').data('imageWidth', width);
        //         $('#player_image').data('imageHeight', height);
        //         $('#player_image').data('imageratio', ratio);
        //     }
        // });

        // $('#live_stream_tv_image').change(function() {

        //     $('#live_stream_tv_image').removeData('imageWidth');
        //     $('#live_stream_tv_image').removeData('imageHeight');
        //     $('#live_stream_tv_image').removeData('imageratio');

        //     var file = this.files[0];
        //     var tmpImg = new Image();

        //     tmpImg.src=window.URL.createObjectURL( file ); 
        //     tmpImg.onload = function() {
        //         width = tmpImg.naturalWidth,
        //         height = tmpImg.naturalHeight;
		// 		ratio =  Number(width/height).toFixed(2) ;
                
        //         $('#live_stream_tv_image').data('imageWidth', width);
        //         $('#live_stream_tv_image').data('imageHeight', height);
        //         $('#live_stream_tv_image').data('imageratio', ratio);
        //     }
        // });



    //  validate 
	$('form[id="liveEdit_video"]').validate({
	rules: {
	  title: 'required',
	  url_type: 'required',
      duration: 'required',
      'language[]': {
                required: true
            },

        image: {
            required: '#check_image:blank',
            dimention:[1080,1920]
        },

        player_image: {
            required: '#player_check_image:blank',
            player_dimention:[1280,720]
        },

        live_stream_tv_image: {

             required: function (element) {

                   var action =  $("#tv_image_live_validation_status").val(); 
                   var tv_check_image = $('#tv_check_image').val()
                    if (action == '1' && tv_check_image != "validate" ) {
                        return true;
                    } else {
                        return false;
                    }
            },

            tv_image_dimention:[1920,1080]
        },

        publish_time: {
            required: function (element) {

                var action =$("input[type=radio][name=publish_type]").val();

                if (action == "publish_now") {
                     return true;
                } else {
                    return false;
                }
            },
        },
	 
		mp4_url: {
		required : function(element) {
			var action = $(".url_type").val();
			if(action == "mp4") { 
				return true;
			} else {
				return false;
			}
		 }
		},

        m3u_url: {
            required: function (element) {
                var action = $(".url_type").val();
                if (action == "m3u_url") {
                    return true;
                } else {
                    return false;
                }
            },
        },

        acc_audio_url: {
            required: function (element) {
                var action = $(".url_type").val();
                if (action == "acc_audio_url") {
                    return true;
                } else {
                    return false;
                }
            },
        },

        acc_audio_file: {
            required: function (element) {
                var action = $(".url_type").val();
                if (action == "acc_audio_file") {
                    return true;
                } else {
                    return false;
                }
            },
        },

		embed_url: {
			required : function(element) {
			    var action = $(".url_type").val();
				if(action == "embed") { 
						return true;
				} else {
						return false;
				}
			}
		},

        ppv_price: {
            required: function (element) {
                var ppv_price = $("#access").val();
                if (ppv_price == "ppv") {
                    return true;
                } else {
                    return false;
                }
            },
            },
		},
	messages: {
	  title: 'This field is required',
	  mp4_url: 'This field is required',
	},
	submitHandler: function(form) {
	  form.submit();
	}
  });

    //  End validate

    if($("#url_type").val() == 'mp4')
    {
        $('#mp4_code').show();
        $('#embed_code,#live_stream_video,#url_rtmp,#m3u_urls,#acc_audio_file,#acc_audio_url,#uplaod_audio_file').hide();
    }
    else if($("#url_type").val() == 'embed')
    {
        $('#embed_code').show();
        $('#mp4_code,#live_stream_video,#url_rtmp,#m3u_urls,#acc_audio_file,#acc_audio_url,#uplaod_audio_file').hide();
    }
    else if ($("#url_type").val() == "Encode_video") 
    {
        $('#embed_code,#mp4_code,#live_stream_video,#m3u_urls,#acc_audio_file,#acc_audio_url,#url_rtmp,#uplaod_audio_file').hide();
    }
    else if ($("#url_type").val() == "m3u_url") 
    {
        $("#m3u_urls").show();
        $('#embed_code','#mp4_code','#live_stream_video','#url_rtmp','#acc_audio_file','#acc_audio_url,#uplaod_audio_file').hide();
    }
    else if ($("#url_type").val() == "live_stream_video") 
    {
        $('#embed_code,#mp4_code,#url_rtmp,#acc_audio_file,#acc_audio_url,#m3u_urls,#live_stream_video,#uplaod_audio_file').hide();
    }
    else if ($("#url_type").val() == "acc_audio_file") 
    {
        $("#acc_audio_file,#uplaod_audio_file").show();
        $('#embed_code,#mp4_code,#url_rtmp,#acc_audio_url,#m3u_urls,#live_stream_video,#acc_audio_file').hide();
    }
    else if ($("#url_type").val() == "acc_audio_url") 
    {
        $('#embed_code,#mp4_code,#url_rtmp,#acc_audio_file,#m3u_urls,#live_stream_video,#uplaod_audio_file').hide();
        $("#acc_audio_url").show();
    }
    else if ($("#url_type").val() == " ") 
    {
        $('#embed_code','#mp4_code','#live_stream_video','#url_rtmp','#acc_audio_file','#acc_audio_url','#m3u_urls,#uplaod_audio_file').hide();
    }

    $("#url_type").change(function(){

        $("#mp4_code").hide();
        $("#embed_code").hide();
        $("#live_stream_video").hide();
        $("#m3u_urls").hide();
        $("#acc_audio_file").hide();
        $(".acc_audio_url").hide();
        $(".uplaod_audio_file").hide();


        if($("#url_type").val() == 'mp4'){
            $('#mp4_code').show();
        }
        else if($("#url_type").val() == 'embed')
        {
            $('#embed_code').show();	
        }
        else if($("#url_type").val() == 'live_stream_video')
        {
            $('#live_stream_video').show();	
        }
        else if ($("#url_type").val() == "Encode_video")
         {
            $('#url_rtmp').show();	
        }
        else if ($("#url_type").val() == "m3u_url") 
        {
            $("#m3u_urls").show();
        }
        else if ($("#url_type").val() == "acc_audio_file") 
        {
            $("#acc_audio_file").show();
        }
        else if ($("#url_type").val() == "acc_audio_url") 
        {
            $(".acc_audio_url").show();
        }
        else if ($("#url_type").val() == " ") 
        {
            $('#embed_code','#mp4_code','#live_stream_video','#acc_audio_file','#acc_audio_url','#m3u_urls').hide();
        }
    });

	$('.js-example-basic-multiple').select2();
	$('.js-example-basic-single').select2();


});

    $(document).ready(function () {
        
        $("input[name='publish_type']").on('click change', function () {
            
            $("#publishlater, #recurring_program , .custom_program_time , .program_time,.recurring_program_week_day, .recurring_program_month_day,.recurring_timezone").hide();

            let publishType = $("input[name='publish_type']:checked").val();
            // console.log('type: ' + publishType);

            if ( publishType == "publish_now" ) {
                $('.pull-right').prop("disabled", false);
            }

            if ( publishType == "publish_later" ) {
                $("#publishlater").show();
                $(".text-danger").show();
                $('.pull-right').prop("disabled", true);
            }

            if( publishType == "recurring_program" ){
                $("#recurring_program , .recurring_timezone").show();
                $(".text-danger").show();
                $('.pull-right').prop("disabled", true);
            }

            if( publishType == "schedule_program" ){
                var modal = document.getElementById("schedule_program_modal");
                modal.style.display = "block"; 
                modal.style.background = 'rgba(0, 0, 0, 0.7)';
            }
        });
        
        $("#publish_time").change(function(){
            var publishLaterValue = $('#publish_time').val();
            // console.log('value of publish later: ' + publishLaterValue);
            if(publishLaterValue !== null && publishLaterValue !== '') { 
                $('.pull-right').prop("disabled", false);
                $(".text-danger").hide();
            } else {
                $('.pull-right').prop("disabled", true);
            }
        });

        $(".prog-end-time").change(function(){
            var startValue = $('.prog-start-time').val();
            var endValue = $('.prog-end-time').val();
            // console.log('value of startValue: ' + startValue);
            // console.log('value of endValue: ' + endValue);
            if(startValue !== null && startValue !== '' && endValue !== null && endValue !== '') { 
                $('.pull-right').prop("disabled", false);
                $(".text-danger").hide();
            } else {
                $('.pull-right').prop("disabled", true);
            }
        });

        $("#custom_end_program_time").change(function(){
            var startValue = $('#custom_start_program_time').val();
            var endValue = $('#custom_end_program_time').val();
            // console.log('value of startValue: ' + startValue);
            // console.log('value of endValue: ' + endValue);
            if(startValue !== null && startValue !== '' && endValue !== null && endValue !== '') { 
                $('.pull-right').prop("disabled", false);
                $(".text-danger").hide();
            } else {
                $('.pull-right').prop("disabled", true);
            }
        });



        $("#recurring_program").change(function () {

            $(" .custom_program_time , .program_time, .recurring_program_week_day , .recurring_program_month_day").hide();

            let recurring_program_dropdown = $('#recurring_program_dropdown').val();

            if( recurring_program_dropdown != " " &&  recurring_program_dropdown == "custom"){

                $('.custom_program_time').show();

            }
            else if( recurring_program_dropdown != " " &&  recurring_program_dropdown != "custom" ){
                
                if (recurring_program_dropdown  == "weekly") {
                    $('.recurring_program_week_day').show();
                }

                if (recurring_program_dropdown  == "monthly") {
                    $('.recurring_program_month_day').show();
                }

                $('.program_time').show();
            }
        });
    });

    $(document).ready(function () {
        if ($("#access").val() == "ppv") {
            $(".ppv_price").show();
        } else {
            $(".ppv_price").hide();
        }

        $("#access").change(function () {
            if ($(this).val() == "ppv") {
                $(".ppv_price").show();
            } else {
                $(".ppv_price").hide();
            }
        });
    });


	$ = jQuery;

	$(document).ready(function(){

		$('#duration').mask('00:00:00');
		$('#tags').tagsInput();

		$('#type').change(function(){
            
			if($(this).val() == 'file'){
				$('.new-video-file').show();
				$('.new-video-embed').hide();
				$('.new-video-upload').hide();

			} else if($(this).val() == 'embed'){ 
				$('.new-video-file').hide();
				$('.new-video-embed').show();
				$('.new-video-upload').hide();

			}else{
				$('.new-video-file').hide();
				$('.new-video-embed').hide();
				$('.new-video-upload').show();
				
			}
		});

		

	});

	function NumAndTwoDecimals(e , field) {
        
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

    {{-- image validation --}}

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
                    
                    var validWidth = {{ $compress_image_settings->width_validation_live ?: 720 }};
                    var validHeight = {{ $compress_image_settings->height_validation_live ?: 1280 }};
                    console.log(validWidth);
                    console.log(validHeight);

                    if (width !== validWidth || height !== validHeight) {
                        document.getElementById('live_image_error_msg').style.display = 'block';
                        $('.pull-right').prop('disabled', true);
                        document.getElementById('live_image_error_msg').innerText = 
                            `* Please upload an image with the correct dimensions (${validWidth}x${validHeight}px).`;
                    } else {
                        document.getElementById('live_image_error_msg').style.display = 'none';
                        $('.pull-right').prop('disabled', false);
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
                    
                    var validWidthPlayer = {{ $compress_image_settings->live_player_img_width ?:1280 }};
                    var validHeightPlayer = {{ $compress_image_settings->live_player_img_height ?:720 }};
                    console.log(validWidthPlayer);
                    console.log(validHeightPlayer);

                    if (width !== validWidthPlayer || height !== validHeightPlayer) {
                        document.getElementById('live_player_image_error_msg').style.display = 'block';
                        $('.pull-right').prop('disabled', true);
                        document.getElementById('live_player_image_error_msg').innerText = 
                            `* Please upload an image with the correct dimensions (${validWidthPlayer}x${validHeightPlayer}px).`;
                    } else {
                        document.getElementById('live_player_image_error_msg').style.display = 'none';
                        $('.pull-right').prop('disabled', false);
                    }
                };
                img.src = URL.createObjectURL(file);
            }
        });
    </script>

<script>
	$(document).ready(function(){
        var tagsdata = '<?= $video->search_tags ?>';
    });

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


    var datasearch = $("#search_tags").val();
    var tagsdata = '<?= $video->search_tags ?>';


    var tagInput1 = new TagsInput({
            selector: 'tag-input1',
            duplicate : false,
            max : 10
        });

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

<script>
    $(document).ready(function(){
        // $('#message').fadeOut(120);
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);
    })


</script>


<script>
	$(document).on('change', '.url_type', function() {
	if($(".url_type").val() == "Encode_video"){
	
		var optionText = $(".url_type option:selected").attr("data-name") ;
        var hls_url = $(".url_type option:selected").attr("data-hls-url") ;
	
		$("#Rtmp_url").val(function() {
			$("#Rtmp_url").val(' ');
			return this.value + optionText;
		});

        $("#hls_url").val(function() {
                    $("#hls_url").val(' ');
	                return this.value + hls_url;
	    });
	}
	});

    function EmbedCopy() {
   // var media_path = $('#media_url').val();
   var media_path = '<?= $url_path ?>';
   var url =  navigator.clipboard.writeText(window.location.href);
   var path =  navigator.clipboard.writeText(media_path);
   $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Copied Embed URL</div>');
              setTimeout(function() {
               $('.add_watch').slideUp('fast');
              }, 3000);
   }
	
</script>

{{-- live Streaming  --}}

        @php 
            if(!empty($video->rtmp_url && $video->Stream_key)){
                $Stream_video = $video->rtmp_url.$video->Stream_key.".m3u8"; 
            }else{
                $Stream_video = null ;
            }

            if(!empty($video->url_type && $video->live_stream_video) && $video->url_type == "live_stream_video" ){
                $liveStream_upload = $video->live_stream_video; 
            }else{
                $liveStream_upload = null ;
            }

        @endphp

        <script src="<?= URL::to('/'). '/assets/js/playerjs.js';?>"></script>

        <script>
            var Stream_live_videos =" {{ ($Stream_video) }}";

            var player = new Playerjs({id:"Stream_live_player", file:Stream_live_videos,autoplay:1});

                $("#Streamclose").click(function(){
                    var player = new Playerjs({id:"Stream_live_player", file:Stream_live_videos,stop:1});
                });


            var liveStream_URL =" {{ ($liveStream_upload) }}";

            var player = new Playerjs({id:"LiveStream_Upload_player", file:liveStream_URL,autoplay:1});

                $("#Livevideo_uploadclose").click(function(){
                    var player = new Playerjs({id:"LiveStream_Upload_player", file:liveStream_URL,stop:1});
                });

        </script>

        @include('admin.livestream.Ads_live'); 

	@stop
@stop

{{-- Video Encoder {{  $inputs_details_array['text_main_name'] }} Modal --}}
<div class="modal fade" id="Stream_video" tabindex="-1" role="dialog" aria-labelledby="Stream_video" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
            <div class="modal-body" id="Stream_live_player" style="height: 200px !important; width: auto;" >  </div>

            <div class="modal-footer" style="">
                <button type="button" class="btn btn-secondary" id="Streamclose" data-dismiss="modal">Close</button>
            </div>
      </div>
    </div>
</div>


{{-- {{  $inputs_details_array['text_main_name'] }} Video Upload Modal --}}

<div class="modal fade" id="Livevideo_upload" tabindex="-1" role="dialog" aria-labelledby="Livevideo_upload" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
            <div class="modal-body" id="LiveStream_Upload_player" style="height: 200px !important; width: auto;" >  </div>

            <div class="modal-footer" style="">
                <button type="button" class="btn btn-secondary" id="Livevideo_uploadclose" data-dismiss="modal">Close</button>
            </div>
      </div>
    </div>
</div>

<style>
    .modal-body{
        position: unset;
    }
    .modal-footer{
        background: black;
    }
</style>

{{-- Schedule Program --}}

<script>

    $(document).ready(function () {

        $(document).on('click', '.add-program-btn', function () {

            var rowCount = $('.program-fields').length;
            
            rowCount++; 

            let newRow = `
                <tr class="program-fields">
                    <td>${rowCount}</td> <!-- Dynamic S.No -->
                    <td>
                        <input class="form-control" placeholder="Enter the Show Name" name="scheduler_program_title[]" required/>
                    </td>

                    <td>
                        <input type="time" class="form-control" name="scheduler_program_start_time[]" required/>
                    </td>

                    <td>
                        <input type="time" class="form-control" name="scheduler_program_end_time[]" required />
                    </td>

                    <td class="d-flex justify-content-center align-items-center p-3">
                        <i class="fa fa-plus-circle add-program-btn mx-2"></i>
                        <i class="fa fa-minus-circle remove-program-btn mx-2"></i>
                    </td>
                </tr>`;
            $('#program-fields-table tbody').append(newRow);
        });

        $(document).on('click', '.remove-program-btn', function () {
            $(this).closest('tr').remove();
            updateSerialNumbers(); 
        });

        function updateSerialNumbers() {
            $('#program-fields-table tbody tr').each(function(index) {
                $(this).find('td:first').text(index + 1); 
            });
            rowCount = $('#program-fields-table tbody tr').length; 
        }

        $('.close-icon').on('click', function () {

            if (confirm('Are you sure to Close ?') == true) {
                $('#schedule_program_modal').hide();
            }
        });

        $(document).on('click', '#submitModal', function () {

            var isValid = true; 
            var timeSlots = [];

            $(".is-invalid").removeClass("is-invalid");
            $(".error-message").remove();

            var scheduler_program_days = $('#scheduler_program_days').val();

            if (!scheduler_program_days || scheduler_program_days.length === 0) {
                isValid = false;
                var $schedulerProgramDaysInput = $('#scheduler_program_days');
                showErrorMessage($schedulerProgramDaysInput, "Scheduler program days is required.");
            }

            var previousEndTime = null;

            $(".program-fields").each(function() {

                var $titleInput = $(this).find('input[name="scheduler_program_title[]"]');
                var $startTimeInput = $(this).find('input[name="scheduler_program_start_time[]"]');
                var $endTimeInput = $(this).find('input[name="scheduler_program_end_time[]"]');

                var title = $titleInput.val();
                var startTime = $startTimeInput.val();
                var endTime = $endTimeInput.val();
                
                if (!title) {
                    isValid = false;
                    showErrorMessage($titleInput, "Program title is required.");
                }
                
                if (!startTime) {
                    isValid = false;
                    showErrorMessage($startTimeInput, "Start time is required.");
                }
                
                if (!endTime) {
                    isValid = false;
                    showErrorMessage($endTimeInput, "End time is required.");
                }
                
                if (startTime && endTime) {
                    if (startTime >= endTime) {
                        isValid = false;
                        showErrorMessage($startTimeInput, "Start time must be earlier than end time.");
                        showErrorMessage($endTimeInput, "End time must be later than start time.");
                    }

                    if (isValid && timeSlots.some(slot => slot.startTime === startTime && slot.endTime === endTime)) {
                        isValid = false;
                        showErrorMessage($startTimeInput, "A program with the same start and end time already exists.");
                        showErrorMessage($endTimeInput, "A program with the same start and end time already exists.");
                    }

                    if (isValid) {
                        timeSlots.push({ startTime: startTime, endTime: endTime });
                    }

                    if (previousEndTime && startTime === previousEndTime) {
                        isValid = false;
                        showErrorMessage($startTimeInput, "Start time should not match previous end time.");
                    }

                    previousEndTime = endTime;
                }

            });

            if (isValid) {
                $("#schedule_program_modal").hide();
            }
        });
    });

    function showErrorMessage($input, message) {
        var $error = $("<span>").addClass("error-message text-danger").text(message);
        $input.addClass("is-invalid").after($error);
    }
    
</script>
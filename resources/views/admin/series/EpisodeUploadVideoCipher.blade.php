@extends('admin.master')
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta charset="utf-8" />
<meta name="csrf-token" content="{{ csrf_token() }}" />

<!-- CSS -->
<link rel="stylesheet" type="text/css" href="{{asset('dropzone/dist/min/dropzone.min.css')}}" />

<!-- JS -->
<script src="{{asset('dropzone/dist/min/dropzone.min.js')}}" type="text/javascript"></script>
<style type="text/css">


    .dz-error-mark {
        
    }
    .has-switch .switch-on label {
        background-color: #fff;
        color: #000;
    }
    .make-switch {
        z-index: 2;
    }
    .iq-card {
        padding: 15px;
    }
    .p1 {
        font-size: 12px;
    }
    #optionradio {
        color: #000;
    }
    #video_upload {
        margin-top: 5%;
    }
    .file {
        background: rgb(255 255 255 / 100%);
        border-radius: 10px;
        text-align: center;
        margin: 0 auto;
        width: 75%;
        border: 2px dashed;
    }
    #video_upload .file form i {
        display: block;
        font-size: 50px;
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
        background-color: #fa0e7e;
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
    .dropzone .dz-preview .dz-progress{overflow:visible;top:82%;border:none;}
    .dropzone .dz-preview.dz-complete .dz-progress{opacity: 1;}
    p#cancel-message {padding: .75rem 1.25rem;margin-bottom: 1rem;border: 1px solid transparent; border-radius: .25rem;color: #721c24; background-color: #f8d7da; border-color: #f5c6cb; position: absolute;right: 0;}

    body.dark input{color: <?php echo GetAdminDarkText(); ?>;}
	body.dark input{background-color: <?php echo GetAdminDarkBg(); ?>;}
	body.light input{color: <?php echo GetAdminLightText(); ?>;}

</style>
<style>
    .admin-section-title {
        height: 500px; /* Set a fixed height for your container */
        overflow-y: auto; /* Enable vertical scrolling */
    }
    .bc-icons-2 .breadcrumb-item+.breadcrumb-item::before {
        content: none;
    }

    body.light-theme ol.breadcrumb {
        background-color: transparent !important;
        font-size: revert;
    }
    .dropzone .dz-preview .dz-progress{height:14px !important;}
    span#upload-percentage{position: absolute;right: 30%;bottom: -3px;font-weight:800 !important;font-size:10px;}
    .dropzone .dz-preview .dz-progress .dz-upload{border-radius:5px;}
</style>

@section('css')
<link rel="stylesheet" href="{{ URL::to('/assets/js/tagsinput/jquery.tagsinput.css') }}" />

@stop @section('content')


<div id="content-page" class="content-page">

    <!-- BREADCRUMBS -->
    <div class="row mr-2">
        <div class="nav container-fluid pl-0 mar-left " id="nav-tab" role="tablist">
            <div class="bc-icons-2">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="black-text"
                            href="{{ URL::to('admin/series-list') }}">{{ ucwords(__('Tv Shows List')) }}</a>
                        <i class="ri-arrow-right-s-line iq-arrow-right" aria-hidden="true"></i>
                    </li>
                    
                    <li class="breadcrumb-item">
                        <a class="black-text"
                            href="{{ URL::to('admin/series/edit/'.$series->id )  }}"> {{ __($series->title) }}
                        </a>
                        
                    <i class="ri-arrow-right-s-line iq-arrow-right" aria-hidden="true"></i>
                    </li>
                    <li class="breadcrumb-item">{{ __("Manage Episodes") }}</li>
               
                </ol>
            </div>
        </div>
    </div>

    <p id="cancel-message" class="alert alert-danger" style="display:none;"></p>
    <div class="container-fluid">
        <!-- This is where -->
        <div class="iq-card">
            <div class="admin-section-titles">
                @if(!empty($episodes->id))
                <h4>{{ $episodes->title }}</h4>
                <!-- {{ URL::to('episodes') . '/' . $episodes->id }} -->

                <a href="{{ URL::to('episode') . '/' . @$episodes->series_title->title . '/' . $episodes->slug }}" target="_blank" class="btn btn-primary"> <i class="fa fa-eye"></i> Preview <i class="fa fa-external-link"></i> </a>
                @else
                <h4><i class="entypo-plus"></i> Add New Episode</h4>
                @endif
                <hr />
            </div>
            <div class="clear"></div>
          
            <div class="text-center" id="buttonNext" style="margin-top: 30px;">
                <input type="button" id="Next" value="Proceed to Next Step" class="btn btn-primary" />
            </div>
            <br>

            <?php //dd($season_id); ?>

            <div id="episode_video_data">
                <form method="POST" action="{{ $post_route }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data" id="Episode_new">
                    @if(!empty($episodes->created_at))
                    <div class="row mt-4">
                        <div class="col-md-9 mt-4">
                            @endif
                            <div class="panel panel-primary" data-collapsed="0">
                                <div class="panel-heading">
                                    <div class="panel-title"><label>Title</label></div>
                                    <div class="panel-options">
                                        <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                    </div>
                                </div>
                                <div class="panel-body col-sm-6 p-0" style="display: block;">
                                    <p class="p1">Add the episodes title in the textbox below:</p>
                                    <input type="text" class="form-control" name="title" id="title" placeholder="Episode Title" value="@if(!empty($episodes->title)){{ $episodes->title }}@endif" />
                                </div>
                            </div>

                            @if(!empty($episodes->created_at))
                        </div>
                        <div class="col-sm-3">
                            <div class="panel panel-primary" data-collapsed="0">
                                <div class="panel-heading">
                                    <div class="panel-title">Created Date</div>
                                    <div class="panel-options">
                                        <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                    </div>
                                </div>
                                <div class="panel-body" style="display: block;">
                                    <p>Select Date/Time Below</p>
                                    <input type="text" class="form-control" name="created_at" id="created_at" placeholder="" value="@if(!empty($episodes->created_at)){{ $episodes->created_at }}@endif" />
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="row mt-3">
                        <div class="col-sm-6">
                            <div class="col-md-3">
                                <div id="ImagesContainer" class="d-flex mt-3"></div>
                            </div>
                            <div class="panel panel-primary" data-collapsed="0">
                                <div class="panel-heading">
                                    <div class="panel-title"><label>Episode Image Cover</label></div>
                                    <div class="panel-options">
                                        <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                    </div>
                                </div>
                                <div class="panel-body" style="display: block;">
                                    @if(!empty($episodes->image))
                                    <img src="{{ Config::get('site.uploads_dir') . 'images/' . $episodes->image }}" class="episodes-img" width="200" />
                                    @endif
                                    @php 
                                        $width = $compress_image_settings->width_validation_episode;
                                        $heigth = $compress_image_settings->height_validation_episode
                                    @endphp
                                    @if($width !== null && $heigth !== null)
                                        <p class="p1">{{ ("Select the episodes image (".''.$width.' x '.$heigth.'px)')}}:</p> 
                                    @else
                                        <p class="p1">{{ "Select the episodes image (1080 X 1920px or 9:16 ratio)"}}:</p> 
                                    @endif
                                    <input type="file" multiple="true" class="form-control" name="image" id="image" />
                                    <span>
                                        <p id="season_image_error_msg" style="color:red !important; display:none;">
                                            * Please upload an image with the correct dimensions.
                                        </p>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-sm-6">
                                <div class="col-md-3">
                                    <div id="ajaxImagesContainer" class="d-flex mt-3"></div>
                                    </div>
                            <label class="m-0">Episode Player Image</label>
                            @php 
                                $player_width = $compress_image_settings->episode_player_img_width;
                                $player_heigth = $compress_image_settings->episode_player_img_height;
                            @endphp
                            @if($player_width !== null && $player_heigth !== null)
                                <p class="p1">{{ ("Select the player image (".''.$player_width.' x '.$player_heigth.'px)')}}:</p> 
                            @else
                                <p class="p1">{{ "Select the player image ( 1280 X 720px or 16:9 Ratio )"}}:</p> 
                            @endif

                            <div class="panel-body">
                                @if(!empty($episodes->player_image))
                                    <img src="{{ URL::to('/') . '/public/uploads/images/' . $episodes->player_image }}" class="episodes-img" width="200" />
                                @endif
                                <input type="file" multiple="true" class="form-group" name="player_image" id="player_image" />
                                <span>
                                    <p id="season_thum_image_error_msg" style="color:red !important; display:none;">
                                        * Please upload an image with the correct dimensions.
                                    </p>
                                </span>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="col-md-3">
                                <div id="TVImagesContainer" class="d-flex mt-3"></div>
                                        {{-- Video TV Thumbnail --}}
                                </div>
                            <label class="m-0">Episode TV Image</label>
                            <p class="p1">Select the player image ( 16:9 Ratio or 1920 X 1080 px)</p>
    
                            <div class="panel-body">
                                <input type="file" multiple="true" class="form-group" name="tv_image" id="tv_image" />
                                @if(!empty($episodes->tv_image))
                                    <img src="{{ URL::to('/') . '/public/uploads/images/' . $episodes->tv_image }}" class="episodes-img" width="200" />
                                @endif
                            </div>
                        </div>
    
                    </div>
                    @if($series_seasons_type == 'VideoCipher')
                    <div class="col-sm-12 row">

                        <div class="col-sm-6">
                            <label class="m-0">Choose Episode ID for 480p </label>
                            <p class="p1">Episode ID for 480p Plan</p>
                            <input class="form-control episode_id_group" name="episode_id_480p" id="episode_id_480p" />
                        </div>
                        <div class="col-sm-6">
                            <label class="m-0">Choose Episode ID for 720p </label>
                            <p class="p1">Episode ID for 720p Plan</p>
                            <input class="form-control episode_id_group" name="episode_id_720p" id="episode_id_720p" />
                        </div>
                    </div>
                        <div class="col-sm-6">
                            <label class="m-0">Choose Episode ID for 1080p </label>
                            <p class="p1">Episode ID for 1080p Plan</p>
                            <input class="form-control episode_id_group" name="episode_id_1080p" id="episode_id_1080p" />
                        </div>
                    
                    </div>
                    @elseif($series_seasons_type == 'm3u8')
                    <div class="row mt-3">
                        <div class="col-sm-12">
                            <label class="m-0">Upload M3U8 URL </label>
                            <input class="form-control m3u8_url" name="m3u8_url" id="m3u8_url" />
                        </div>
                    </div>

                    @elseif($series_seasons_type == 'videomp4')
                    <div class="row mt-3">
                        <div class="col-sm-12">
                            <label class="m-0">Upload MP4 URL </label>
                            <input class="form-control mp4_url" name="mp4_url" id="mp4_url" />
                        </div>
                    </div>
                    @elseif($series_seasons_type == 'embed_video')
                    <div class="row mt-3">
                        <div class="col-sm-12">
                            <label class="m-0">Upload Embeded URL </label>
                            <input class="form-control embed_video_url" name="embed_video_url" id="embed_video_url" />
                        </div>
                    </div>
                    @endif

                                      {{-- for validate --}} 
                        <input type="hidden" id="check_Tv_image" name="check_Tv_image" value="@if(!empty($episodes->tv_image) ) {{ "validate" }} @else {{ " " }} @endif"  />

                        <div class="col-sm-12">
                            <label class="m-0"> Episode Description </label>
                            <p class="p1"> Add a description of the Episode below: </p> 
                            <div class="panel-body">
                                <textarea class="form-control " name="episode_description" id="description_editor"> @if(!empty($episodes->episode_description)){{ ($episodes->episode_description) }} @endif </textarea>
                            </div>
                        </div>
                    <div class="row mt-3">
                        <div class="col-sm-12">
                            <div class="panel panel-primary" data-collapsed="0">
                                <div class="panel-heading">
                                    <div class="panel-title"><label>Episode Ratings</label></div>
                                    <div class="panel-options">
                                        <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                    </div>
                                </div>
                                <div class="panel-body col-sm-6 p-0" style="display: block;">
                                    <p class="p1">IMDb Ratings 10 out of 10</p>
                                    <input class="form-control" name="rating" id="rating" value="" onkeyup="NumAndTwoDecimals(event , this);" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="panel panel-primary mt-3" data-collapsed="0"> <div class="panel-heading"> 
		<div class="panel-title"><label>Episode Source</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
		<div class="panel-body col-sm-6 p-0" style="display: block;"> 
			<label for="type" >Episode Format</label>
			<select class="form-control" id="type" name="type">
				<option value="embed">Embed Code</option>
				<option value="file" @if(!empty($episodes->type) && $episodes->type == 'file'){{ 'selected' }}@endif>Episode File</option>
				<option value="upload" @if(!empty($episodes->type) && $episodes->type == 'upload'){{ 'selected' }}@endif>Upload Episode</option>
			</select> -->

                    <!-- <div class="new-episodes-file" @if(!empty($episodes->type) && $episodes->type == 'file'){{ 'style="display:block"' }}@else style = "display:none" @endif>
				<label for="mp4_url">Mp4 File URL:</label>
				<input type="text" class="form-control" name="mp4_url" id="mp4_url" value="@if(!empty($episodes->mp4_url)){{ $episodes->mp4_url }}@endif" />
			</div>

			<div class="new-episodes-embed" @if(!empty($episodes->type) && $episodes->type == 'embed')style="display:block"@else style = "display:none" @endif>
				<label for="embed_code">Embed Code:</label>
				<textarea class="form-control" name="embed_code" id="embed_code">@if(!empty($episodes->embed_code)){{ $episodes->embed_code }}@endif</textarea>
			</div>

			<div class="new-episodes-upload" @if(!empty($episodes->type) && $episodes->type == 'upload')style="display:block"@else style = "display:none" @endif>
				<label for="embed_code">Upload Episode</label>
				<input type="file" name="episode_upload" id="episode_upload">
			</div>
			@if(!empty($episodes->type) && ($episodes->type == 'upload' || $episodes->type == 'file'))
			<video width="200" height="200" controls>
			<source src="{{ $episodes->mp4_url }}" type="video/mp4">
			</video>
			@endif
			@if(!empty($episodes->type) && $episodes->type == 'embed')
			<iframe src="{{ $episodes->mp4_url }}"></iframe>
			@endif
		</div> 
	</div> -->
                <div class="row">
                    <div class="panel-body col-sm-6" style="display: block;">
                        <label><h6>Age Restrict :</h6></label>
                        <select class="form-control" id="age_restrict" name="age_restrict">
                            <option selected disabled="">Choose Age</option>
                            @foreach($age_categories as $age)
                            <option value="{{ $age->id }}" @if(!empty($episodes->age_restrict) && $episodes->age_restrict == $age->id)selected="selected"@endif>{{ $age->slug }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6 p-0" style="display: block;">
                        <label>Search Tags :</label>
                        <div class="panel-body">
                        <input class="form-control" type="text" id="tag-input1" name="searchtags">
                        </div>

                    </div>
		    </div> 


                    <div class="row align-items-center">
                        <div class="col-sm-4">
                            <div class="panel panel-primary" data-collapsed="0">
                                <label class="m-0">Skip Intro Time <small>(Please Give In Seconds)</small></label>

                                <div class="panel-body">
                                    <input class="form-control" name="skip_intro" id="skip_intro" value="@if(!empty($episodes->skip_intro)){{ $episodes->skip_intro }}@endif" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="panel panel-primary" data-collapsed="0">
                                <label class="m-0">Intro Start Time <small>(Please Give In Seconds)</small></label>
                                <div class="panel-body" style="display: block;">
                                    <input class="form-control" name="intro_start_time" id="intro_start_time" value="@if(!empty($episodes->intro_start_time)){{ $episodes->intro_start_time }}@endif" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="panel panel-primary" data-collapsed="0">
                                <label class="m-0">Intro End Time <small>(Please Give In Seconds)</small></label>
                                <div class="panel-body" style="display: block;">
                                    <input class="form-control" name="intro_end_time" id="intro_end_time" value="@if(!empty($episodes->intro_end_time)){{ $episodes->intro_end_time }}@endif" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row align-items-center">
                        <div class="col-sm-4">
                            <div class="panel panel-primary" data-collapsed="0">
                                <label class="m-0">Skip Recap Time <small>(Please Give In Seconds)</small></label>
                                <div class="panel-body">
                                    <input class="form-control" name="skip_recap" id="skip_recap" value="@if(!empty($episodes->skip_recap)){{ $episodes->skip_recap }}@endif" />
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4 mt-3">
                            <div class="panel panel-primary" data-collapsed="0">
                                <label class="m-0">Recap Start Time <small>(Please Give In Seconds)</small></label>
                                <div class="panel-body" style="display: block;">
                                    <input class="form-control" name="recap_start_time" id="recap_start_time" value="@if(!empty($episodes->recap_start_time)){{ $episodes->recap_start_time }}@endif" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 mt-3">
                            <div class="panel panel-primary" data-collapsed="0">
                                <label class="m-0">Recap End Time <small>(Please Give In Seconds)</small></label>
                                <div class="panel-body" style="display: block;">
                                    <input class="form-control" name="recap_end_time" id="recap_end_time" value="@if(!empty($episodes->recap_end_time)){{ $episodes->recap_end_time }}@endif" />
                                </div>
                            </div>
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

                           
                @if( choosen_player() == 1 && ads_theme_status() == 1)    {{-- Video.Js Player--}}

                    @if ( admin_ads_pre_post_position() == 1 )

                        <div class="col-sm-6 form-group mt-3">                        {{-- Pre/Post-Advertisement--}}

                            <label> {{ ucwords( 'Choose the Pre / Post-Position Advertisement' ) }}    </label>
                            
                            <select class="form-control" name="pre_post_ads" >

                                <option value=" " > Select the Post / Pre-Position Advertisement </option>

                                <option value="random_ads" > Random Ads </option>

                                @foreach ($video_js_Advertisements as $video_js_Advertisement)
                                    <option value="{{ $video_js_Advertisement->id }}" > {{ $video_js_Advertisement->ads_name }}</option>
                                @endforeach
                            
                            </select>
                        </div>
                        
                    @elseif ( admin_ads_pre_post_position() == 0 )

                        <div class="row mt-3">

                            <div class="col-sm-6 form-group mt-3">                        {{-- Pre-Advertisement --}}
                                <label> {{ ucwords( 'Choose the Pre-Position Advertisement' ) }}  </label>
                                
                                <select class="form-control" name="pre_ads" >

                                    <option value=" " > Select the Pre-Position Advertisement </option>

                                    <option value="random_ads"> Random Ads </option>

                                    @foreach ($video_js_Advertisements as $video_js_Advertisement)
                                        <option value="{{ $video_js_Advertisement->id }}"  > {{ $video_js_Advertisement->ads_name }}</option>
                                    @endforeach
                                    
                                </select>
                            </div>

                            <div class="col-sm-6 form-group mt-3">                        {{-- Post-Advertisement--}}
                                <label> {{ ucwords( 'Choose the Post-Position Advertisement' ) }}    </label>
                                
                                <select class="form-control" name="post_ads" >

                                    <option value=" " > Select the Post-Position Advertisement </option>

                                    <option value="random_ads"> Random Ads </option>

                                    @foreach ($video_js_Advertisements as $video_js_Advertisement)
                                        <option value="{{ $video_js_Advertisement->id }}"> {{ $video_js_Advertisement->ads_name }}</option>
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

                                <option value="random_category"> Random Category </option>

                                @foreach( $ads_category as $ads_category )
                                    <option value="{{ $ads_category->id }}" > {{ $ads_category->name }}</option>
                                @endforeach

                            </select>
                        </div>

                        <div class="col-sm-6 form-group mt-3">                        {{-- Mid-Advertisement sequence time--}}
                            <label> {{ ucwords( 'Mid-Advertisement Sequence Time' ) }}   </label>
                            <input type="text" class="form-control" name="video_js_mid_advertisement_sequence_time"  placeholder="HH:MM:SS"  id="video_js_mid_advertisement_sequence_time"  >
                        </div>

                    </div>
                
                        {{-- Ply.io --}}
                @else    
                    <div class="row mt-3">
                        <div class="col-sm-6"  >
                            <label class="m-0">Choose Ads Position</label>
                            <select class="form-control" name="ads_position" id="ads_position" >
                               <option value=" ">Select the Ads Position </option>
                               <option value="pre"  >  Pre-Ads Position</option>
                               <option value="mid"  >  Mid-Ads Position</option>
                               <option value="post" > Post-Ads Position</option>
                               <option value="all" > All Ads Position</option>
                            </select>
                        </div>
    
                        <div class="col-sm-6"  >
                            <label class="">Choose Advertisement </label>
                            <select class="form-control" name="episode_ads" id="episode_ads" >
                               <option value=" ">Select the Advertisement </option>
                            </select>
                        </div>
                    </div>
                @endif

                    <div class="clear"></div>

                    <div class="row align-items-center">
                        <div class="col-sm-4">
                            <div class="panel panel-primary" data-collapsed="0">
                                <div class="panel-heading">
                                    <div class="panel-title"><label>Duration</label></div>
                                    <div class="panel-options">
                                        <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <p class="p1">Enter the episode duration in the following format (Hours : Minutes : Seconds)</p>
                                    <input type="text" class="form-control" name="duration" id="duration" value="@if(!empty($episodes->duration)){{ gmdate('H:i:s', $episodes->duration) }}@endif"  readonly/>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="col-sm-4 mt-3">
                            <div class="panel panel-primary" data-collapsed="0">
                                <div class="panel-heading">
                                    <div class="panel-title"><label>User Access</label></div>
                                    <div class="panel-options">
                                        <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <p class="p1">Who is allowed to view this episode?</p>
                                    <select id="access" class="form-control" name="access">
                                        <option value="guest" @if(!empty($episodes->access) && $episodes->access == 'guest'){{ 'selected' }}@endif>Guest (everyone)</option>
                                        <option value="registered" @if(!empty($episodes->access) && $episodes->access == 'registered'){{ 'selected' }}@endif>Registered Users (free registration must be enabled)</option>
                                        <option value="subscriber" @if(!empty($episodes->access) && $episodes->access == 'subscriber'){{ 'selected' }}@endif>Subscriber (only paid subscription users)</option>
                                        <?php if($settings->ppv_status == 1){ ?>
                                        <option value="ppv" >PPV Users (Pay per movie)</option>   
                                        <?php } else{ ?>
                                        <option value="ppv" >PPV Users (Pay per movie)</option>   
                                        <?php } ?>
                                    </select>
                                    <div class="clear"></div>
                                </div>
                            </div>
                        </div> -->

                        <div class="col-sm-4">
                            <div class="panel panel-primary" data-collapsed="0">
                                <div class="panel-heading">
                                    <div class="panel-title"><label>Status Settings</label></div>
                                    <div class="panel-options">
                                        <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div style="display: flex; justify-content: start; align-items: baseline;">
                                        <label for="featured" style="float: left; display: block; margin-right: 10px;">Is this episode Featured:</label>
                                        <input type="checkbox" @if(!empty($episodes->featured) && $episodes->featured == 1){{ 'checked="checked"' }}@endif name="featured" value="1" id="featured" />
                                    </div>
                                    <div class="clear"></div>
                                    <div style="display: flex; justify-content: start; align-items: baseline;">
                                        <label for="active" style="float: left; display: block; margin-right: 10px;">Is this episode Active:</label>
                                        <input type="checkbox" @if(!empty($episodes->active) && $episodes->active == 1){{ 'checked="checked"' }}@elseif(!isset($episodes->active)){{ 'checked="checked"' }}@endif name="active" value="1"
                                        id="active" />
                                    </div>
                                    <div class="clear"></div>
                                    <div style="display: flex; justify-content: start; align-items: baseline;">
                                        <label for="banner" style="float: left; display: block; margin-right: 10px;">Is this episode display in Banner:</label>
                                        <input type="checkbox" @if(!empty($episodes->banner) && $episodes->banner == 1){{ 'checked="checked"' }}@endif name="banner" value="1" id="banner" />
                                    </div>
                                    <div class="clear"></div>
                                    <div style="display: flex; justify-content: start; align-items: baseline;">
                                        <label for="footer" style="float: left; display: block; margin-right: 10px;">Is this episode display in Footer:</label>
                                        <input type="checkbox" @if(!empty($episodes->footer) && $episodes->footer == 1){{ 'checked="checked"' }}@endif name="footer" value="1" id="footer" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row align-items-center">
                        <!-- <div class="col-sm-4" id="ppv_price"> 
				<div class="panel panel-primary" data-collapsed="0"> 
					<div class="panel-heading"> <div class="panel-title"> <label>PPV Price :</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<input type="text" class="form-control" placeholder="PPV Price" name="ppv_price" id="price" >
		
				</div>
			</div> -->

                        <!-- <div class="col-sm-4 mt-3"> 
				<div class="panel panel-primary" data-collapsed="0"> 
					<div class="panel-heading"> <div class="panel-title"> <label>Is this video Is PPV:</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<?php //if($settings->ppv_status == 1){ ?>
					<input type="checkbox" name="ppv_status" value="1" id="ppv_status" />
					<?php // } else{ ?>
						<div class="global_ppv_status">
					<input type="checkbox" name="ppv_status" value="1" id="ppv_status" />
						</div>
						<?php //} ?>
						<div class="clear"></div>
					</div> 
				</div> -->

                        @if(isset($series->id))
                        <input type="hidden" id="series_id" name="series_id" value="{{ $series->id }}" />
                        @endif

                        <!-- @if(isset($episodes->id))
		<input type="hidden" id="season_id" name="season_id" value="{{ $season_id }}" />
	@endif -->

                        @if(isset($episodes->id))
                        <input type="hidden" id="id" name="id" value="{{ $episodes->id }}" />
                        <input type="hidden" id="selectedImageUrlInput" name="selected_image_url" value="">
                        <input type="hidden" id="videoImageUrlInput" name="video_image_url" value="">
                        @endif
                        <input type="hidden" id="episode_id" name="episode_id" value="" />
                        <input type="hidden" id="selectedImageUrlInput" name="selected_image_url" value="">
                        <input type="hidden" id="videoImageUrlInput" name="video_image_url" value="">
                        <input type="hidden" id="SelectedTVImageUrlInput" name="selected_tv_image_url" value="">
                        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                        <input type="hidden" id="season_id" name="season_id" value="{{ $season_id }}" />
                    </div>
                    <!-- row -->

                    <div class="mt-3" style="display: flex; justify-content: flex-end;">
                        <input type="submit" id="submit" value="{{ $button_text }}" class="btn btn-primary pull-right" />
                    </div>
                </form>
            </div>
            <div class="clear"></div>
            <!-- Manage Episode Order -->
                <div class="float-right">
                    <button id="delete-selected" style="padding:6px 10px; border-radius:9px;" class="btn btn-danger">Delete Selected</button>
                    <input type="text" id="searchInput" placeholder="Search...">
                </div>

            <div class="p-4">

                @if(!empty($episodes))
                <h3 class="card-title">Seasons &amp; Episodes</h3>
  
                <div class="admin-section-title">
                    <div class="row ml-0"  id="orderepisode">

                        <table class="table table-bordered iq-card text-center" id="categorytbl" >
                            <thead>
                            <tr class="table-header r1">
                                <th><input type="checkbox" id="select-all"></th>
                                <th><label>Episode </label></th>
                                <th><label>Episode Name</label></th>
                                <th><label>Episode Duration</label></th>
                                <th><label>Slider</label></th>
                                <th><label>Status</label></th>
                                <th><label>Action</label></th>
                            </tr>
                            </thead>

                        <tbody id="search-episodes">
                            @foreach($episodes as $key => $episode)
                                <input type="hidden" class="seriesid" id="seriesid" value="{{ $episode->series_id }}">
                                <input type="hidden" class="season_id" id="season_id" value="{{ $episode->season_id }}">
                                <!-- <tr id="{{ $episode->id }}"> -->
                                    <tr id="episode-{{ $episode->id }}">
                                    <td><input type="checkbox" class="episode-checkbox" value="{{ $episode->id }}"></td>
                                    <td valign="bottom"><p> Episode {{ $episode->episode_order }}</p></td>
                                    <td valign="bottom"><p>{{ $episode->title }}</p></td>
                                    <td valign="bottom"><p>@if(!empty($episode->duration)){{ gmdate('H:i:s', $episode->duration) }}@endif</p></td>
                                    <td valign="bottom">
                                        <div class="mt-1">
                                            <label class="switch">
                                                <input name="video_status" class="video_status" id="{{ 'video_'.$episode->id }}" type="checkbox" @if( $episode->banner == "1") checked  @endif data-video-id={{ $episode->id }}  data-type="video" onchange="update_episode_banner(this)" >
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </td>

                                    <?php if($episode->active == null){ ?>
                                    <td > <p class = "bg-warning video_active"><?php echo "Draft"; ?></p></td>
                                             <?php }elseif($episode->active == 1){ ?>
                                    <td > <p class = "bg-success video_active"><?php  echo "Published"; ?></p></td>
                                             <?php } ?>
                                    <td>
                                        <div class=" align-items-center">
                                            <?php if($theme_settings->enable_video_cipher_upload == 1){ ?>
                                            <a href="{{ URL::to('admin/episode/episode_edit') . '/' . $episode->id }}" class="btn btn-xs btn-primary"><span class="fa fa-edit"></span>Edit Video</a>
                                            <?php } ?>
                                            <a href="{{ URL::to('admin/episode/edit') . '/' . $episode->id }}" class="btn btn-xs btn-primary"><span class="fa fa-edit"></span> Edit</a>
                                            <a href="{{ URL::to('admin/episode/delete') . '/' . $episode->id }}" class="btn btn-xs btn-danger delete" onclick="return confirm('Are you sure?')" ><span class="fa fa-trash"></span> Delete</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        </table>

                        <div class="clear"></div>
                    </div>
                </div>
                @endif
                <!-- This is where now -->
            </div>
        </div>
    </div>
    <style>
       
       .dz-cancel {
           color: #FF0000;
           background: none;
           border: none;
           padding: 5px;
       }
       .dz-cancel:hover {
           text-decoration: underline;
       }
   </style>
    @section('javascript')
    
    <script type="text/javascript" src="{{ URL::to('/assets/admin/js/tinymce/tinymce.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::to('/assets/js/tagsinput/jquery.tagsinput.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::to('/assets/js/jquery.mask.min.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />
   

     {{-- image validation --}}
    <script>
        
        document.getElementById('episode_image').addEventListener('change', function() {
            var file = this.files[0];
            if (file) {
                var img = new Image();
                img.onload = function() {
                    var width = img.width;
                    var height = img.height;
                    console.log(width);
                    console.log(height);
                    
                    var validWidth = {{ $compress_image_settings->width_validation_episode }};
                    var validHeight = {{ $compress_image_settings->height_validation_episode }};
                    console.log(validWidth);
                    console.log(validHeight);

                    if (width !== validWidth || height !== validHeight) {
                        document.getElementById('season_image_error_msg').style.display = 'block';
                        $('.pull-right').prop('disabled', true);
                        document.getElementById('season_image_error_msg').innerText = 
                            `* Please upload an image with the correct dimensions (${validWidth}x${validHeight}px).`;
                    } else {
                        document.getElementById('season_image_error_msg').style.display = 'none';
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
                    
                    var validWidth = {{ $compress_image_settings->episode_player_img_width }};
                    var validHeight = {{ $compress_image_settings->episode_player_img_height }};
                    console.log(validWidth);
                    console.log(validHeight);

                    if (width !== validWidth || height !== validHeight) {
                        document.getElementById('season_thum_image_error_msg').style.display = 'block';
                        $('.pull-right').prop('disabled', true);
                        document.getElementById('season_thum_image_error_msg').innerText = 
                            `* Please upload an image with the correct dimensions (${validWidth}x${validHeight}px).`;
                    } else {
                        document.getElementById('season_thum_image_error_msg').style.display = 'none';
                        $('.pull-right').prop('disabled', false);
                    }
                };
                img.src = URL.createObjectURL(file);
            }
        });
    </script>

   <script>


document.getElementById('select-all').addEventListener('change', function() {
        let checkboxes = document.querySelectorAll('.episode-checkbox');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });

    document.getElementById('delete-selected').addEventListener('click', function() {
        let selected = [];
        document.querySelectorAll('.episode-checkbox:checked').forEach(checkbox => {
            selected.push(checkbox.value);
        });

        if(selected.length > 0) {
            if(confirm('Are you sure you want to delete the selected episodes?')) {
                fetch("{{ route('admin.episodes.deleteSelected') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ids: selected})
                }).then(response => response.json())
                .then(data => {
                    if(data.success) {
                        selected.forEach(id => {
                            document.getElementById('episode-' + id).remove();
                        });
                    } else {
                        alert('An error occurred while deleting episodes.');
                    }
                });
            }
        } else {
            alert('No episodes selected.');
        }
    });

            $(document).ready(function(){
                $("#searchInput").on("keyup", function() {
                    var value = $(this).val().toLowerCase();
                    $("#search-episodes tr").filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });
            });

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

        // $("#intro_start_time").datetimepicker({
        //     format: "hh:mm ",
        // });
        // $("#intro_end_time").datetimepicker({
        //     format: "hh:mm ",
        // });
        // $("#recap_start_time").datetimepicker({
        //     format: "hh:mm ",
        // });
        // $("#recap_end_time").datetimepicker({
        //     format: "hh:mm ",
        // });
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script src="<?= URL::to('/assets/js/jquery.mask.min.js');?>"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

    <script>
         	$('#bunnycdnvideo').hide();
             $('#episodeupload').click(function(){
                $('#episode_uploads').show();
                $('#bunnycdnvideo').hide();
                // $("#episode_uploads").addClass('collapse');
                // $("#bunny_cdn_video").removeClass('collapse');         
            })
            
            $('#bunny_cdn_video').click(function(){

                $('#episode_uploads').hide();
                $('#bunnycdnvideo').show();
                $("#episode_uploads").removeClass('collapse');
                // $("#bunny_cdn_video").removeClass('collapse');

            })



   $(document).ready(function(){
            
         $(document).ready(function() {
            $('#stream_bunny_cdn_episode').select2();
         });

    
            $('#episodelibrary').on('change', function() {
                  
                  var episodelibrary_id = this.value;
                  $("#stream_bunny_cdn_episode").html('');
                     $.ajax({
                     url:"{{url::to('admin/bunnycdn_episodelibrary')}}",
                     type: "POST",
                     data: {
                     episodelibrary_id: episodelibrary_id,
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


                  $('#stream_bunny_cdn_episode').html('<option value="">Choose Videos from Bunny CDN</option>'); 

                     $.each(decodedStreamVideos.items, function(key, value) {
                        console.log(value.title);
                        var videoUrl = PullZoneURl + '/' + value.guid + '/playlist.m3u8';
                        $("#stream_bunny_cdn_episode").append('<option value="' + videoUrl + '">' + value.title + '</option>');
                        // $("#stream_bunny_cdn_episode").append('<option value="'+videoUrl+'">'+value.title+'</option>');
                     });

                     }
                });

            }); 



      $('#submit_bunny_cdn').click(function(){
            $.ajax({
                url: '{{ URL::to('/admin/stream_bunny_cdn_episode') }}',
                type: "post",
                 data: {
                        _token: '{{ csrf_token() }}',
                        stream_bunny_cdn_episode: $('#stream_bunny_cdn_episode').val(),
                        series_id : '<?= $series->id ?>' ,
                        season_id : '<?= $season_id ?>' ,
        
                    },        success: function(value){
                        console.log(value);
                                       // console.log(value);
                        $("#buttonNext").hide();
                        $("#episode_id").val(value.Episode_id);
            
                    }
                });
            })

        });
        
        CKEDITOR.replaceAll( 'description_editor', {
            toolbar : 'simple'
        });

        // Image upload dimention validation
		$.validator.addMethod('dimention', function(value, element, param) {
            if(element.files.length == 0){
                return true; 
            }

            var width = $(element).data('imageWidth');
            var height = $(element).data('imageHeight');
            var ratio = $(element).data('imageratio');
            var image_validation_status = "{{  image_validation_episode() }}" ;


            if( image_validation_status == "0" || ratio == '0.56' || ratio == '1.78' || width == param[0] && height == param[1]){
                return true;
            }else{
                return false;
            }
        },'Please upload an image with 1080 x 1920 pixels dimension or 9:16 Ratio or 16:9 Ratio ');

                // player Image upload validation
        $.validator.addMethod('player_dimention', function(value, element, param) {
            if(element.files.length == 0){
                return true; 
            }

            var width = $(element).data('imageWidth');
            var height = $(element).data('imageHeight');
            var ratio = $(element).data('imageratio');
            var image_validation_status = "{{  image_validation_episode() }}" ;

            if( image_validation_status == "0" || ratio == '1.78'|| width == param[0] && height == param[1]){
                return true;
            }else{
                return false;
            }
        },'Please upload an image with 1280 x 720 pixels dimension  or 16:9 Ratio');

                // TV Image upload validation

        $.validator.addMethod('tv_image_dimention', function(value, element, param) {
            if(element.files.length == 0){
                return true; 
            }

            var width = $(element).data('imageWidth');
            var height = $(element).data('imageHeight');
            var ratio = $(element).data('imageratio');
            var image_validation_status = "{{  image_validation_episode() }}" ;

            if( image_validation_status == "0" || ratio == '1.78'|| width == param[0] && height == param[1]){
                return true;
            }else{
                return false;
            }
        },'Please upload an image with 1920 X 1080 pixels dimension  or 16:9 Ratio');


        $('#image').change(function() {
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
                $('#image').data('imageWidth', width);
                $('#image').data('imageHeight', height);
                $('#image').data('imageratio', ratio);

            }
        });

        $('#player_image').change(function() {

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

                $('#player_image').data('imageWidth', width);
                $('#player_image').data('imageHeight', height);
                $('#player_image').data('imageratio', ratio);

            }
        });


        $('#tv_image').change(function() {

            $('#tv_image').removeData('imageWidth');
            $('#tv_image').removeData('imageHeight');
            $('#tv_image').removeData('imageratio');

            var file = this.files[0];
            var tmpImg = new Image();

            tmpImg.src=window.URL.createObjectURL( file ); 
            tmpImg.onload = function() {
                width = tmpImg.naturalWidth,
                height = tmpImg.naturalHeight;
				ratio =  Number(width/height).toFixed(2) ;

                $('#tv_image').data('imageWidth', width);
                $('#tv_image').data('imageHeight', height);
                $('#tv_image').data('imageratio', ratio);

            }
        });

        $('form[id="Episode_new"]').validate({
            rules: {
                title: "required",
                episode_id_480p: {
                    required: function (element) {
                        return $('#episode_id_720p').val() === "" && $('#episode_id_1080p').val() === "";
                    }
                },
                episode_id_720p: {
                    required: function (element) {
                        return $('#episode_id_480p').val() === "" && $('#episode_id_1080p').val() === "";
                    }
                },
                episode_id_1080p: {
                    required: function (element) {
                        return $('#episode_id_480p').val() === "" && $('#episode_id_720p').val() === "";
                    }
                }
            },
            messages: {
                title: "This field is required",
                episode_id_480p: "Please fill in at least one Episode ID (480p, 720p, or 1080p).",
                episode_id_720p: "Please fill in at least one Episode ID (480p, 720p, or 1080p).",
                episode_id_1080p: "Please fill in at least one Episode ID (480p, 720p, or 1080p)."
                
 
            },
            submitHandler: function (form) {
                form.submit();
            }
        });


        // $('form[id="Episode_new"]').validate({
        //     rules: {
        //         title: "required",
                

        //         // image: {
        //         //     required: true,
        //         //     dimention:[1080,1920]
        //         // },

        //         // player_image: {
        //         //     required: true,
        //         //     player_dimention:[1280,720]
        //         // },

        //         // tv_image: {
        //         //     required: true,
        //         //     tv_image_dimention:[1920,1080]
        //         // },
        //     },
        //     messages: {
        //         title: "This field is required",
        //     },
        //     submitHandler: function (form) {
        //         form.submit();
        //     },
        // });
    </script>

    <script type="text/javascript">
        $ = jQuery;
        $(document).ready(function ($) {
            $("#duration").mask("00:00:00");
                $('#intro_start_time').mask("00:00:00");
                $('#intro_end_time').mask("00:00:00");
                $('#recap_start_time').mask("00:00:00");
                $('#recap_end_time').mask("00:00:00");
                $('#skip_intro').mask("00:00:00");
                $('#skip_recap').mask("00:00:00");
                $('#video_js_mid_advertisement_sequence_time').mask("00:00:00");
        });
        
        $(document).ready(function () {
            $("#duration").mask("00:00:00");
            $("#tags").tagsInput();

            $("#type").change(function () {
                if ($(this).val() == "file") {
                    $(".new-episodes-file").show();
                    $(".new-episodes-embed").hide();
                    $(".new-episodes-upload").hide();
                } else if ($(this).val() == "embed") {
                    $(".new-episodes-file").hide();
                    $(".new-episodes-embed").show();
                    $(".new-episodes-upload").hide();
                } else {
                    $(".new-episodes-file").hide();
                    $(".new-episodes-embed").hide();
                    $(".new-episodes-upload").show();
                }
            });

            tinymce.init({
                relative_urls: false,
                selector: "#details",
                toolbar: "styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | preview media | forecolor backcolor | code",
                plugins: ["advlist autolink link image code lists charmap print preview hr anchor pagebreak spellchecker code fullscreen", "save table contextmenu directionality emoticons template paste textcolor code"],
                menubar: false,
            });
        });

        function NumAndTwoDecimals(e, field) {
            var val = field.value;
            var re = /^([0-9]+[\.]?[0-9]?[0-9]?|[0-9]+)$/g;
            var re1 = /^([0-9]+[\.]?[0-9]?[0-9]?|[0-9]+)/g;
            if (re.test(val)) {
                if (val > 10) {
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <script>
        // alert();
        $(document).ready(function () {
            $("#ppv_price").hide();
            $("#access").change(function () {
                if ($(this).val() == "ppv") {
                    $("#ppv_price").show();
                    $("#global_ppv_status").show();
                } else {
                    $("#ppv_price").hide();
                    $("#global_ppv_status").hide();
                }
            });
        });
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{asset('dropzone/dist/min/dropzone.min.js')}}" type="text/javascript"></script>
    <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

    <script>
        CKEDITOR.replace("summary-ckeditor", {
            filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: "form",
        });
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
    var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
    // alert('test');
    $("#buttonNext").hide();
    $("#episode_video_data").show();
    $("#submit").show();
    var series_id = '<?= $series->id ?>';
    var season_id = '<?= $season_id ?>';
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
            maxFilesize: 15000000000000000, // 15000MB
            acceptedFiles: "video/mp4,video/x-m4v,video/*",
            previewTemplate: document.getElementById('template').innerHTML,
            init: function() {
                this.on("sending", function(file, xhr, formData) {
                    formData.append('series_id', series_id);
                    formData.append('season_id', season_id);
                    formData.append("UploadlibraryID", $('#UploadlibraryID').val());
                    formData.append("_token", CSRF_TOKEN);

                    // Initialize retry counter and canceled flag if they don't exist
                    if (!file.retryCount) {
                        file.retryCount = 0;
                    }
                    if (!file.userCanceled) {
                        file.userCanceled = false;
                    }

                    file.previewElement.querySelector('.dz-cancel').addEventListener('click', function() {
                        console.log("Cancel button clicked for file: " + file.name);
                        file.userCanceled = true; 
                        xhr.abort();
                        file.previewElement.querySelector('.dz-cancel').innerHTML = " ";
                        // alert("Upload canceled for file: " + file.name);
                        handleError(file, "Upload canceled by user.");
                        var cancelMessage = "Upload canceled for file: " + file.name;
                        var messageElement = document.getElementById('cancel-message');
                        messageElement.innerHTML = cancelMessage;
                        messageElement.style.display = 'block'; 
                        setTimeout(function() {
                            messageElement.style.display = 'none'; 
                        }, 5000);
                    });
                });
                this.on("uploadprogress", function(file, progress) {
                    var progressElement = file.previewElement.querySelector('.dz-upload-percentage');
                    progressElement.textContent = Math.round(progress) + '%';
                });
                
                this.on("success", function (file, value) {
                    if (value.error == 3) {
                        console.log(value.error);
                        alert("File not uploaded. Choose Library!");
                        location.reload();
                    } else {
                        $("#buttonNext").hide();
                        $("#episode_id").val(value.episode_id);
                        $("#title").val(value.episode_title);
                        $("#duration").val(value.episode_duration);
                        file.previewElement.querySelector('.dz-cancel').innerHTML = " ";
                    }
                });

                this.on("error", function(file, response) {
                    if (!file.userCanceled && file.retryCount < MAX_RETRIES) {
                        file.retryCount++;
                        setTimeout(function() {
                            myDropzone.removeFile(file);  // Remove the failed file from Dropzone
                            myDropzone.addFile(file);     // Requeue the file for upload
                        }, 1000); 
                    } else if (file.userCanceled) {
                        console.log("File upload canceled by user: " + file.name);
                    } else {
                        alert("Failed to upload the file after " + MAX_RETRIES + " attempts.");
                    }
                });
            }
        });

    // Dropzone.autoDiscover = false;
    // var myDropzone = new Dropzone(".dropzone", {
    //     //   maxFilesize: 900,  // 3 mb
    //     parallelUploads: 10,
    //     maxFilesize: 15000,
    //     acceptedFiles: "video/mp4,video/x-m4v,video/*",
    // });

    // myDropzone.on("sending", function (file, xhr, formData) {
    //     formData.append('series_id', series_id);
    //     formData.append('season_id', season_id);
    //     formData.append("UploadlibraryID", $('#UploadlibraryID').val());
    //     formData.append("_token", CSRF_TOKEN);
    //     // console.log(value)
    // });

    // // Add the event listener for upload progress
    // myDropzone.on("uploadprogress", function(file, progress) {
    //     var progressElement = document.getElementById('upload-percentage');
    //     progressElement.textContent = Math.round(progress) + '%';
    // });

    // myDropzone.on("success", function (file, value) {
    //     if (value.error == 3) {
    //         console.log(value.error);
    //         alert("File not uploaded Choose Library!");
    //         location.reload();
    //     }
    //     // console.log(value);
    //     $("#buttonNext").show();
    //     $("#episode_id").val(value.episode_id);
    //     $("#title").val(value.episode_title);
    //     $("#duration").val(value.episode_duration);
    // });
    $("#Next").hide();

    $("#buttonNext").click(function () {
        $('#bunnycdnvideo').hide();
        $("#episode_uploads").hide();
        $('#optionradio').hide();
        $("#Next").hide();
        $("#episode_video_data").show();
        $("#submit").show();

        $.ajax({
            url: '{{ URL::to('admin/episode/extractedimage') }}',
            type: "post",
            data: {
                _token: '{{ csrf_token() }}',
                episode_id: $('#episode_id').val()
            },
            success: function(value) {
                // console.log(value.ExtractedImage.length);

                if (value && value.ExtractedImage.length > 0) {
                    $('#ajaxImagesContainer').empty();
                    $('#ImagesContainer').empty();
                    var ExtractedImage = value.ExtractedImage;
                    var ExtractedImage = value.ExtractedImage;

                    var previouslySelectedElement = null;
                    var previouslySelectedVideoImag = null;
                    var previouslySelectedTVImage = null;

                    ExtractedImage.forEach(function(Image, index) {
                        var imgElement = $('<img src="' + Image.image_path + '" class="ajax-image m-1 w-100" />');
                        var ImagesContainer = $('<img src="' + Image.image_path + '" class="video-image m-1 w-100" />');
                        var TVImagesContainer = $('<img src="' + Image.image_path + '" class="tv-video-image m-1 w-100" />');

                        imgElement.click(function() {
                            $('.ajax-image').css('border', 'none');
                            if (previouslySelectedElement) {
                                previouslySelectedElement.css('border', 'none');
                            }
                            imgElement.css('border', '2px solid red');
                            var clickedImageUrl = Image.image_path;

                            var SelectedImageUrl = Image.image_original_name;
                            console.log('SelectedImageUrl Image URL:', SelectedImageUrl);
                            previouslySelectedElement = $(this);

                            $('#selectedImageUrlInput').val(SelectedImageUrl);
                        });

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
                            console.log('VideoImageUrl Image URL:', VideoImageUrl);
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

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
		
<script type="text/javascript">
   $(function () {
    $("#categorytbl").sortable({
        items: 'tr:not(tr:first-child)',
        cursor: 'pointer',
        axis: 'y',
        dropOnEmpty: false,
        start: function (e, ui) {
            ui.item.addClass("selected");
        },
        stop: function (e, ui) {
            ui.item.removeClass("selected");
            var selectedData = [];
            $(this).find("tr").each(function (index) {
                if (index > 0) { // Skip header row
                    $(this).find("td").eq(1).html(index); // Update the episode order display
                    selectedData.push($(this).attr("id").replace('episode-', '')); // Get episode ID
                }
            });
            var seriesid = $('.seriesid').val();
            var season_id = $('.season_id').val();
            updateOrder(selectedData, seriesid, season_id);
        }
    });
});

function updateOrder(data, seriesid, season_id) {
    $.ajax({
        url: '{{ URL::to('admin/episode_order') }}',
        type: 'post',
        data: {
            position: data,
            seriesid: seriesid,
            season_id: season_id,
            _token: "{{ csrf_token() }}",
        },
        success: function (data) {
            $("#orderepisode").html(data);
        },
        error: function (xhr, status, error) {
            // alert('An error occurred: ' + xhr.responseText);
        }
    });
}
</script>

<script>
	function update_episode_banner(ele){

	var video_id = $(ele).attr('data-video-id');
	var status   = '#video_'+video_id;
	var video_Status = $(status).prop("checked");

	if(video_Status == true){
		  var banner_status  = '1';
		  var check = confirm("Are you sure you want to active this slider?");  

	}else{
		  var banner_status  = '0';
		  var check = confirm("Are you sure you want to remove this slider?");  
	}


	if(check == true){ 

	   $.ajax({
				type: "POST", 
				dataType: "json", 
				url: "{{ url('admin/episode_slider_update') }}",
					  data: {
						 _token  : "{{csrf_token()}}" ,
						 video_id: video_id,
						 banner_status: banner_status,
				},
				success: function(data) {
					  if(data.message == 'true'){
						//  location.reload();
					  }
					  else if(data.message == 'false'){
						 swal.fire({
						 title: 'Oops', 
						 text: 'Something went wrong!', 
						 allowOutsideClick:false,
						 icon: 'error',
						 title: 'Oops...',
						 }).then(function() {
							location.href = '{{ URL::to('admin/ActiveSlider') }}';
						 });
					  }
				   },
			 });
	}else if(check == false){
	   $(status).prop('checked', true);

	}
	}
</script>


@include('admin.series.search_tag'); 

@include('admin.series.Ads_episode'); 

    @stop 
    
    @section('javascript') 
    
    @stop 
    
@stop
</div>

@extends('admin.master')

<style>
    
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

    .gridContainer{
   display: grid;
   grid-template-columns: repeat(5, calc(100% / 5));
}

.bc-icons-2 .breadcrumb-item+.breadcrumb-item::before {
        content: none;
    }

    body.light-theme ol.breadcrumb {
        background-color: transparent !important;
        font-size: revert;
    }

    .progress { position:relative; width:100%; }
   .bar { background-color: #008000; width:0%; height:20px; }
   .percent { position:absolute; display:inline-block; left:50%; color: #7F98B2;}
   [data-tip] {
   position:relative;
   }

   #progressbar #useraccess_ppvprice:before {
   font-family: FontAwesome;
   content: "\f030"
   }
   .progress {height:0.25rem !important;}

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

   #progressbar li img {
    width: 125px;
    display: block;
    margin: 0 auto;
}
.sample-file.d-flex a{font-size: 12px;margin-right: 5px;}
.top-options a, .top-options button, .top-options .src-btn{font-size: 10px;border-radius: 4px;}
#epi-prev .my-video.vjs-fluid {
    height: 67vh !important;
}
.source_list {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 130px;
    float: right;
}
</style>
{{-- video-js Style --}}

    <link href="https://cdnjs.cloudflare.com/ajax/libs/videojs-ima/1.11.0/videojs.ima.css" rel="stylesheet">
    <!-- <link href="https://unpkg.com/video.js@7/dist/video-js.min.css" rel="stylesheet" /> -->
    <link href="{{ asset('public/themes/default/assets/css/video-js/videojs.min.css') }}" rel="stylesheet" >
    <link href="https://cdn.jsdelivr.net/npm/videojs-hls-quality-selector@1.1.4/dist/videojs-hls-quality-selector.min.css" rel="stylesheet">
    <link href="{{ URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.css') }}" rel="stylesheet" >
    <link href="{{ asset('public/themes/default/assets/css/video-js/videos-player.css') }}" rel="stylesheet" >
    <link href="{{ asset('public/themes/default/assets/css/video-js/video-end-card.css') }}" rel="stylesheet" >
    <link href="{{ URL::to('node_modules\@filmgardi\videojs-skip-button\dist\videojs-skip-button.css') }}" rel="stylesheet" >
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

{{-- video-js Script --}}

    <script src="//imasdk.googleapis.com/js/sdkloader/ima3.js"></script>
    <script src="{{ asset('assets/js/video-js/video.min.js') }}"></script>
    <script src="{{ asset('assets/js/video-js/videojs-contrib-quality-levels.js') }}"></script>
    <script src="{{ asset('assets/js/video-js/videojs-http-source-selector.js') }}"></script>
    <script src="{{ asset('assets/js/video-js/videojs.ads.min.js') }}"></script>
    <script src="{{ asset('assets/js/video-js/videojs.ima.min.js') }}"></script>
    <script src="{{ asset('assets/js/video-js/videojs-hls-quality-selector.min.js') }}"></script>
    <script src="{{ asset('assets/js/video-js/end-card.js') }}"></script>
    <script src="{{ URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.js') }}"></script>
    <script src="{{ URL::to('node_modules/@filmgardi/videojs-skip-button/dist/videojs-skip-button.min.js') }}"></script>
    <script src="{{ URL::to('node_modules/@videojs/plugin-concat/dist/videojs-plugin-concat.min.js') }}"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

@section('css')

<?php
$series = App\Series::where('id',$episodes->series_id)->first()  ;
// dd($series->title);
$media_url = URL::to('/episode/').'/'.$series->slug.'/'.$episodes->slug;
$embed_media_url = URL::to('/episode/embed').'/'.$series->slug.'/'.$episodes->slug;
$url_path = '<iframe width="853" height="480" src="'.$embed_media_url.'"  allowfullscreen></iframe>';

    if($episodes->type == 'm3u8'){
        $episodeURL =   URL::to('/storage/app/public/').'/'.$episodes->path . '.m3u8'  ;
        $episode_player_type =  'application/x-mpegURL' ;
    }elseif ($episodes->type == 'file' || $episodes->type == 'upload'){
        $episodeURL =   $episodes->mp4_url  ;
        $episode_player_type =  'video/mp4' ;
    }elseif ($episodes->type == 'm3u8_url'){
        $episodeURL =   $episodes->url  ;
        $episode_player_type =  'application/x-mpegURL' ;
    }elseif($episodes->type == 'bunny_cdn'){
       $episodeURL =   $episodes->url  ;
       $episode_player_type =  'application/x-mpegURL' ;
   }else{
        $episodeURL =  null ;
        $episode_player_type =  null ;
   }
?>

    

<link rel="stylesheet" href="{{ URL::to('/assets/js/tagsinput/jquery.tagsinput.css') }}" />
@stop @section('content')
<div id="content-page" class="content-page">

    <div class="container-fluid">
        @if(!empty($episodes->id))
                        
            <div class="top-options row d-flex align-items-center justify-content-end">
                <a href="{{URL::to('episode') . '/' . @$episodes->series_title->slug . '/' . $episodes->slug }}" target="_blank" class="btn btn-primary"> <i class="fa fa-eye"></i> Preview <i class="fa fa-external-link"></i> </a>
                
                <?php 
                    $filename = $episodes->path.'.mp4';
                    $path = storage_path('app/public/'.$filename);
                ?>
                {{-- @if($episodes->status == 1 && $episodes->status == 1  )
                    <a href="#" class="btn btn-lg btn-primary pull-right ml-2" data-toggle="modal" data-target="#largeModal">Player Perview</a>
                @endif  --}}

                @if($episodes->processed_low >= 100 && $episodes->type == "m3u8")
                    @if (file_exists($path))
                        <a class="iq-bg-warning ml-2"  href="{{ URL::to('admin/episode/filedelete') . '/' . $episodes->id }}"><button class="btn btn-danger" > Delete Original File</button></a>
                    @endif
                @endif
                
                <span class="btn btn-primary src-btn position-relative ml-2" onclick="sourceDownload()">Download video source</span>
            </div>
        @endif
    </div>

    @php
        $m3u8_url = URL::to('/storage/app/public/'. $episodes->path .'.m3u8')   ;
    @endphp

    <div class="source_list mb-2" style="display: none;padding-right:5px;">
        <a href="{{ $episodes->mp4_url}}" download="{{$episodes->title.'.mp4'}}" style="color:#000000;font-size:12px;"><span><i class="fa fa-download pr-2" aria-hidden="true"></i>MP4</span></a>
        @if($episodes->type == 'm3u8')
            <a href="{{ $m3u8_url}}" download="{{$episodes->title.'.m3u8'}}" style="color:#000000;font-size:12px;"><span><i class="fa fa-download pr-2" aria-hidden="true"></i>M3U8</span></a>
        @endif
    </div>

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

                    <li class="breadcrumb-item"><a class="black-text" href="{{ URL::to('admin/season/edit') . '/' . $series->id  . '/' . $episodes->season_id }}">{{ __('Manage Episodes') }} </a><i class="ri-arrow-right-s-line iq-arrow-right" aria-hidden="true"></i></li>
                    <li class="breadcrumb-item">{{ __($episodes->title) }}</li>
                </ol>
            </div>
        </div>
    </div>

    <div>
        @if($page == 'Edit' && $episodes->status == 0  && $episodes->type == "m3u8")
            <div class="col-sm-12">
                Video Transcoding is under Progress
                <div class="progress">
                    <div class="low_bar"></div >
                </div>
                <div class="low_percent">0%</div >
            </div>
        @endif
    </div>
    @if($episodes->status == 1 && $episodes->status == 1  )
        <div id="epi-prev">
            <video id="my-video" class="vjs-theme-city my-video video-js vjs-big-play-centered vjs-play-control vjs-fluid vjs_video_1462 vjs-controls-enabled vjs-picture-in-picture-control vjs-workinghover vjs-v7 vjs-quality-selector vjs-has-started vjs-paused vjs-layout-x-large vjs-user-inactive" controls
                width="auto" height="auto" poster="{{ URL::to('public/uploads/images/'.$episodes->player_image) }}" playsinline="playsinline"
                >
                <source src="{{ $episodeURL }}" type="{{ $episode_player_type }}">

                    @if(isset($playerui_settings['subtitle']) && $playerui_settings['subtitle'] == 1 && isset($SeriesSubtitle) && count($SeriesSubtitle) > 0)
                    @foreach($SeriesSubtitle as $subtitles_file)
                        <track kind="subtitles" src="{{ $subtitles_file->url }}" srclang="{{ $subtitles_file->sub_language }}"
                            label="{{ $subtitles_file->shortcode }}" @if($loop->first) default @endif >
                    @endforeach
                @endif
            </video>
        </div>
    @endif
    <div class="container-fluid">
        <!-- This is where -->
        <div class="iq-card">
            <div class="admin-section-title">

           <!--  @if($episodes->status == 1 && $episodes->status == 1  )
                <a  style="margin-right: 16%;margin-top: -4%;" href="#" class="btn btn-lg btn-primary pull-right" data-toggle="modal" data-target="#largeModal">Preview Player</a>
            @endif   -->

            <br>
            @if($episodes->processed_low >= 100 && $episodes->type == "m3u8")
                @if (file_exists($path))
                    <a class="iq-bg-warning mt-2"  href="{{ URL::to('admin/episode/filedelete') . '/' . $episodes->id }}" style="margin-left: 65%;"><button class="btn btn-secondary" > Delete Original File</button></a>
                @endif
            @endif   
            

            <div class="container">                
                <div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Episode Player</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <video id="my-video" class="vjs-theme-city my-video video-js vjs-big-play-centered vjs-play-control vjs-fluid vjs_video_1462 vjs-controls-enabled vjs-picture-in-picture-control vjs-workinghover vjs-v7 vjs-quality-selector vjs-has-started vjs-paused vjs-layout-x-large vjs-user-inactive" controls
                            width="auto" height="auto" poster="{{ $episodes->player_image }}" playsinline="playsinline"
                            >
                            <source src="{{ $episodeURL }}" type="{{ $episode_player_type }}">

                                @if(isset($SeriesSubtitle))
                                    @foreach($SeriesSubtitle as $subtitles_file)
                                        <track kind="subtitles" src="{{ $subtitles_file->url }}" srclang="{{ $subtitles_file->sub_language }}"
                                            label="{{ $subtitles_file->shortcode }}" @if($loop->first) default @endif >
                                    @endforeach
                                @endif
                        </video>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                    </div>
                </div>
                </div>

            </div>
            <hr />
            <div class="clear"></div>

            <form method="POST" action="{{ $post_route }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data" id="Episode_edit">
                
                <div class="row ">
                    <div class="col-md-6 mb-3">
                        <label class="m-0" ><h4 class="fs-title m-0">Embed Link:</h4></label>
                        <p>Click <a href="#"onclick="EmbedCopy();" class="share-ico"><i class="ri-links-fill"></i> here</a> to get the Embedded URL</p>
                    </div>
    
                    <div class="col-md-6 mb-3">
                        <label class="m-0" ><h4 class="fs-title m-0">Social Share:</h4></label>
                        <div class="share-box">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $media_url ?>" class="share-ico"><i class="ri-facebook-fill"></i></a>&nbsp;  <!-- Facebook -->
                            <a href="https://twitter.com/intent/tweet?text=<?= $media_url ?>" class="share-ico"><i class="ri-twitter-fill"></i></a> <!-- Twitter -->
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <label class="m-0">Title</label>
                        <p class="p1">Add the episodes title in the textbox below:</p>

                        <div class="panel-body">
                            <input type="text" class="form-control" name="title" id="title" placeholder="Episode Title" value="@if(!empty($episodes->title)){{ $episodes->title }}@endif" style="" />
                        </div>
                    </div>
                    @if(!empty($episodes->created_at))
                    <div class="col-sm-6 mb-3">
                        <label class="m-0">Created Date</label>
                        <p class="p1">Select Date/Time Below</p>
                        
                        <div class="panel-body">
                            <input type="text" class="form-control" name="created_at" id="created_at" placeholder="" value="@if(!empty($episodes->created_at)){{ $episodes->created_at }}@endif" />
                        </div>
                    </div>
                    @endif
                    <div class="col-sm-6 mb-3">
                        <label class="m-0">Slug</label>
                        <p class="p1">Add the episodes Slug in the textbox below:</p>
                        
                        <div class="panel-body">
                            <input type="text" class="form-control" name="slug" id="slug" placeholder="Episode Slug" value="@if(!empty($episodes->slug)){{ $episodes->slug }}@endif" />
                        </div>
                    </div>
                </div>
                

                <div class="row mb-3">
                    <div class="col-sm-6">
                        <div id="ImagesContainer" class="gridContainer mt-3"></div>
                        <label class="m-1">Episode Image Cover</label>
                        @php 
                            $width = $compress_image_settings->width_validation_episode;
                            $heigth = $compress_image_settings->height_validation_episode
                        @endphp
                        @if($width !== null && $heigth !== null)
                            <p class="p1">{{ ("Select the episodes image with (".''.$width.' x '.$heigth.'px)')}}:</p> 
                        @else
                            <p class="p1">{{ "Select the episodes image with ( 720x1280px )"}}:</p> 
                        @endif
                        <div class="panel-body">
                            <input type="file" multiple="true" class="form-group" name="image" id="episode_image" accept="image/webp"/>

                            <span>
                                <p id="season_image_error_msg" style="color:red !important; display:none;">
                                    * Please upload an image with the correct dimensions.
                                </p>
                            </span>
                            @if(!empty($episodes->image))
                                <img src="{{ URL::to('/') . '/public/uploads/images/' . $episodes->image }}" class="episodes-img" width="200" />
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-6">
                         <div id="ajaxImagesContainer" class="gridContainer mt-3"></div>
                        <label class="m-0">Episode Player Image</label>
                        @php 
                            $player_width = $compress_image_settings->episode_player_img_width;
                            $player_heigth = $compress_image_settings->episode_player_img_height;
                        @endphp
                        @if($player_width !== null && $player_heigth !== null)
                            <p class="p1">{{ ("Select the episodes image with (".''.$player_width.' x '.$player_heigth.'px)')}}:</p> 
                        @else
                            <p class="p1">{{ "Select the episodes image with ( 1280x720px )"}}:</p> 
                        @endif
                        {{-- <p class="p1">Select the player image ( 16:9 Ratio or 1280X720px)</p> --}}

                        <div class="panel-body">
                            <input type="file" multiple="true" class="form-group" name="player_image" id="player_image" accept="image/webp"/>

                            <span>
                                <p id="player_image_error_msg" style="color:red !important; display:none;">
                                    * Please upload an image with the correct dimensions.
                                </p>
                            </span>
                            @if(!empty($episodes->player_image))
                                <img src="{{ URL::to('/') . '/public/uploads/images/' . $episodes->player_image }}" class="episodes-img" width="200" />
                            @endif
                        </div>
                    </div>

                         {{-- for validate --}} 
                    <input type="hidden" id="check_image" name="check_image" value="@if(!empty($episodes->image) ) {{ "validate" }} @else {{ " " }} @endif"  />
                    <input type="hidden" id="player_check_image" name="player_check_image" value="@if(!empty($episodes->player_image) ) {{ "validate" }} @else {{ " " }} @endif"  />
                </div>

                <div class="row mb-3">

                    <div class="col-sm-6">
                        <div id="TVImagesContainer" class="gridContainer mt-3"></div>
                        <label class="m-0">Episode TV Image</label>
                        <p class="p1">Select the player image ( 16:9 Ratio or 1920 X 1080  px)</p>

                        <div class="panel-body">
                            <input type="file" multiple="true" class="form-group" name="tv_image" id="tv_image" accept="image/webp"/>
                            @if(!empty($episodes->tv_image))
                                <img src="{{ URL::to('/') . '/public/uploads/images/' . $episodes->tv_image }}" class="episodes-img" width="200" />
                            @endif
                        </div>
                    </div>

                         {{-- for validate --}} 
                    <input type="hidden" id="check_Tv_image" name="check_Tv_image" value="@if(!empty($episodes->tv_image) ) {{ "validate" }} @else {{ " " }} @endif"  />
                </div>


                <div class="row mb-3">
                    <div class="col-sm-12">
                        <label class="m-0"> Episode Description </label>
                        <p class="p1"> Add a description of the Episode below: </p> 
                        <div class="panel-body">
					        <textarea class="form-control" name="episode_description" id="description_editor"> @if(!empty($episodes->episode_description)){{ ($episodes->episode_description) }} @endif </textarea>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-6">
                        <label class="m-0">Episode Ratings</label>
                        <p class="p1">IMDb Ratings 10 out of 10</p>
                        <div class="panel-body">
                            <input class="form-control" name="rating" id="rating" value="@if(!empty($episodes->rating)){{ $episodes->rating }}@endif" onkeyup="NumAndTwoDecimals(event , this);" />
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label class="m-0">Search Tags</label>
                        <div class="panel-body">
							<input type="text" id="tag-input1" name="searchtags" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-6">
                        <label class="m-0">Episode Source</label>
                        <p class="p1">Episode Format</p>

                        <div class="panel-body">
                            <select id="type" name="type" class="form-control">
                                <!-- <option value="embed">Embed Code</option> -->
                                <option value="embed" @if(!empty($episodes->type) && $episodes->type == 'embed'){{ 'selected' }}@endif>Episode File</option>
                                <option value="file" @if(!empty($episodes->type) && $episodes->type == 'file'){{ 'selected' }}@endif>Episode File</option>
                                <option value="upload" @if(!empty($episodes->type) && $episodes->type == 'upload'){{ 'selected' }}@endif>Upload Episode</option>
                                <option value="aws_m3u8" @if(!empty($episodes->type) && $episodes->type == 'aws_m3u8'){{ 'selected' }}@endif>AWS Upload Episode</option>
                                <option value="bunny_cdn" @if(!empty($episodes->type) && $episodes->type == 'bunny_cdn'){{ 'selected' }}@endif>Bunny CDN Upload Episode</option>
                            </select>
                            <hr />
                        </div>
                        
                        <div class="panel-body">
                            <div class="new-episodes-file" @if(!empty($episodes->type) && $episodes->type == 'file'){{ 'style="display:block"' }}@else style = "display:none" @endif>
                                <label for="mp4_url">Mp4 File URL:</label>
                                <input type="text" class="form-control" name="mp4_url" id="mp4_url" value="@if(!empty($episodes->mp4_url)){{ $episodes->mp4_url }}@endif" />
                            </div>
                            <div class="new-episodes-embed" @if(!empty($episodes->type) && $episodes->type == 'embed')style="display:block"@else style = "display:none" @endif>
                                <label for="embed_code">Embed Code:</label>
                                <textarea class="form-control" name="embed_code" id="embed_code">@if(!empty($episodes->embed_code)){{ $episodes->embed_code }}@endif</textarea>
                            </div>
                            @error('episode_upload')
                            <div class="alert alert-danger">{{ $episode_upload }}</div>
                            @enderror
                            <div class="new-episodes-upload" @if(!empty($episodes->type) && $episodes->type == 'upload')style="display:block"@else style = "display:none" @endif>
                                <label for="embed_code">Upload Episode</label>
                                <input type="file" name="episode_upload" id="episode_upload" />
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">

                        @if(!empty($episodes->type) && ($episodes->type == 'upload' || $episodes->type == 'file'  || $episodes->type == 'aws_m3u8'))
                        <video width="200" height="200" controls>
                            <source src="{{ $episodes->mp4_url }}" type="video/mp4" />
                        </video>
                        @endif @if(!empty($episodes->type) && $episodes->type == 'embed')
                        <iframe src="{{ $episodes->mp4_url }}"></iframe>
                        @endif
                        
                    </div>
                </div>

                {{--
                <div class="panel-body col-sm-6 p-0" style="display: block;">
                    <label><h6>Age Restrict :</h6></label>
                    <select class="form-control" id="age_restrict" name="age_restrict">
                        <option selected disabled="">Choose Age</option>
                        @foreach($age_categories as $age)
                        <option value="{{ $age->id }}" @if(!empty($episodes->age_restrict) && $episodes->age_restrict == $age->id)selected="selected"@endif>{{ $age->slug }}</option>
                        @endforeach
                    </select>
                </div>
                --}}

                <div class="clear"></div>

                <div class="row mt-3">
                    <div class="col-sm-4">
                        
                        <label class="m-0">Skip Intro Time <small>(Please Give In Seconds)</small></label>
                        <div class="panel-body">
                            <input class="form-control" name="skip_intro" id="skip_intro" value="@if(!empty($episodes->skip_intro)){{ $episodes->skip_intro }}@endif" />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label class="m-0">Intro Start Time <small>(Please Give In Seconds)</small></label>
                        <div class="panel-body">
                            <input class="form-control" name="intro_start_time" id="intro_start_time" value="@if(!empty($episodes->intro_start_time)){{ $episodes->intro_start_time }}@endif" />
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <label class="m-0">Intro End Time <small>(Please Give In Seconds)</small></label>
                        <div class="panel-body">
                            <input class="form-control" name="intro_end_time" id="intro_end_time" value="@if(!empty($episodes->intro_end_time)){{ $episodes->intro_end_time }}@endif" />
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-sm-4">
                     <label class="m-0">Skip Recap Time <small>(Please Give In Seconds)</small></label>
                        <div class="panel-body">
                            <input class="form-control" name="skip_recap" id="skip_recap" value="@if(!empty($episodes->skip_recap)){{ $episodes->skip_recap }}@endif" />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label class="m-0">Recap Start Time <small>(Please Give In Seconds)</small></label>
                        <div class="panel-body">
                            <input class="form-control" name="recap_start_time" id="recap_start_time" value="@if(!empty($episodes->recap_start_time)){{ $episodes->recap_start_time }}@endif" />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label class="m-0">Recap End Time <small>(Please Give In Seconds)</small></label>
                        <div class="panel-body">
                            <input class="form-control" name="recap_end_time" id="recap_end_time" value="@if(!empty($episodes->recap_end_time)){{ $episodes->recap_end_time }}@endif" />
                        </div>
                    </div>
                </div>
                
                <div class="row mt-5">    
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
                                        <label for="embed_code" style="display:block;">Upload Subtitle {{ $subtitle->language }}</label>
                                        
                                        @if(@$subtitlescount > 0)
                                            @foreach($SeriesSubtitle as $movies_subtitles)
                                                @if(@$movies_subtitles->sub_language == $subtitle->language)
                                                    Uploaded Subtitle : 
                                                    <a href="{{ @$movies_subtitles->url }}" download="{{ @$movies_subtitles->sub_language }}">{{ @$movies_subtitles->sub_language }}</a>
                                                    &nbsp;&nbsp;&nbsp;
                                                    <a class="iq-bg-danger" data-toggle="tooltip" data-placement="top" title="Delete" 
                                                       data-original-title="Delete" 
                                                       onclick="return confirm('Are you sure?')" 
                                                       href="{{ URL::to('admin/episode/subtitle/delete') . '/' . $movies_subtitles->id }}">
                                                       <img class="ply" src="{{ URL::to('/') }}/assets/img/icon/delete.svg">
                                                    </a>
                                                @endif
                                            @endforeach
                                        @endif
                                        
                                        <input class="mt-1" type="file" name="subtitle_upload[]" id="subtitle_upload_{{ $subtitle->short_code }}">
                                        <input class="mt-1" type="hidden" name="short_code[]" value="{{ $subtitle->short_code }}">
                                        <input class="mt-1" type="hidden" name="sub_language[]" value="{{ $subtitle->language }}">
                                    </div>
                                </div>
                            @endforeach
                        </div> 
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-sm-4">
                        <label class="m-0">Duration</label>
                        <p class="p1">Enter the episode duration in (HH : MM : SS)</p>

                        <div class="panel-body">
                            <input class="form-control" name="duration" id="duration" value="@if(!empty($episodes->duration)){{ gmdate('H:i:s', $episodes->duration) }}@endif" onblur="formatDuration(this)" />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label class="m-0">Free content Duration</label>
                        <p class="p1">Enter the episode duration in (HH : MM : SS) </p>

                        <div class="panel-body">
                            <input class="form-control" name="free_content_duration" id="free_content_duration" value="@if(!empty($episodes->free_content_duration)){{ gmdate('H:i:s', $episodes->free_content_duration) }}@endif" />
                        </div>
                    </div>
                    <!-- <div class="col-sm-4">
                        <label class="m-0">User Access</label>
                        <p class="p1">Who is allowed to view this episode?</p>

                        <div class="panel-body">
                            <select id="access" name="access" class="form-control" >
                                    <option value="guest" @if(!empty($episodes->access) && $episodes->access == 'guest'){{ 'selected' }}@endif>Guest (everyone)</option>
                                    <option value="registered" @if(!empty($episodes->access) && $episodes->access == 'registered'){{ 'selected' }}@endif>Registered Users (free registration must be enabled)</option>
                                    <option value="subscriber" @if(!empty($episodes->access) && $episodes->access == 'subscriber'){{ 'selected' }}@endif>Subscriber (only paid subscription users)</option>
                                    <?php if($settings->ppv_status == 1){ ?>
                                    <option value="ppv" @if(!empty($episodes->access) && $episodes->access == 'ppv'){{ 'selected' }}@endif>PPV Users (Pay per movie)</option>   
                                    <?php } else{ ?>
                                    <option value="ppv" @if(!empty($episodes->access) && $episodes->access == 'ppv'){{ 'selected' }}@endif>PPV Users (Pay per movie)</option>   
                                    <?php } ?>
                            </select>
                            <div class="clear"></div>
                        </div>
                    </div> -->
                </div>

                        {{-- Ads Management  --}}

                @if ( admin_ads_pre_post_position() == 1  )

                    <div class="col-sm-6 form-group mt-3">                        {{-- Pre/Post-Advertisement--}}

                        <label> {{ ucwords( 'Choose the Pre / Post-Position Advertisement' ) }}    </label>
                        
                        <select class="form-control" name="pre_post_ads" >

                            <option value=" " > Select the Post / Pre-Position Advertisement </option>

                            <option value="random_ads" {{  ( $episodes->pre_post_ads == "random_ads" ) ? 'selected' : '' }} > Random Ads </option>

                            @foreach ($video_js_Advertisements as $video_js_Advertisement)
                                <option value="{{ $video_js_Advertisement->id }}"  {{  ( $episodes->pre_post_ads == $video_js_Advertisement->id ) ? 'selected' : '' }} > {{ $video_js_Advertisement->ads_name }}</option>
                            @endforeach
                        
                        </select>
                    </div>
                    
                @elseif ( admin_ads_pre_post_position() == 0 )

                    <div class="row mt-3">

                        <div class="col-sm-6 form-group mt-3">                        {{-- Pre-Advertisement --}}
                            <label> {{ ucwords( 'Choose the Pre-Position Advertisement' ) }}  </label>
                            
                            <select class="form-control" name="pre_ads" >

                                <option value=" " > Select the Pre-Position Advertisement </option>

                                <option value="random_ads" {{  ( $episodes->pre_ads == "random_ads" ) ? 'selected' : '' }} > Random Ads </option>

                                @foreach ($video_js_Advertisements as $video_js_Advertisement)
                                    <option value="{{ $video_js_Advertisement->id }}"  {{  ( $episodes->pre_ads == $video_js_Advertisement->id ) ? 'selected' : '' }} > {{ $video_js_Advertisement->ads_name }}</option>
                                @endforeach
                                
                            </select>
                        </div>

                        <div class="col-sm-6 form-group mt-3">                        {{-- Post-Advertisement--}}
                            <label> {{ ucwords( 'Choose the Post-Position Advertisement' ) }}    </label>
                            
                            <select class="form-control" name="post_ads" >

                                <option value=" " > Select the Post-Position Advertisement </option>

                                <option value="random_ads" {{  ( $episodes->post_ads == "random_ads" ) ? 'selected' : '' }} > Random Ads </option>

                                @foreach ($video_js_Advertisements as $video_js_Advertisement)
                                    <option value="{{ $video_js_Advertisement->id }}"  {{  ( $episodes->post_ads == $video_js_Advertisement->id ) ? 'selected' : '' }} > {{ $video_js_Advertisement->ads_name }}</option>
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

                            <option value="random_category"  {{  ( $episodes->mid_ads == "random_category" ) ? 'selected' : '' }} > Random Category </option>

                            @foreach( $ads_category as $ads_category )
                            <option value="{{ $ads_category->id }}"  {{  ( $episodes->mid_ads == $ads_category->id ) ? 'selected' : '' }} > {{ $ads_category->name }}</option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-sm-6 form-group mt-3">                        {{-- Mid-Advertisement sequence time--}}
                        <label> {{ ucwords( 'Mid-Advertisement Sequence Time' ) }}   </label>
                        <input type="text" class="form-control" name="video_js_mid_advertisement_sequence_time"  placeholder="HH:MM:SS"  id="video_js_mid_advertisement_sequence_time" value="{{ $episodes->video_js_mid_advertisement_sequence_time }}" >
                    </div>

                </div>
                        
                <div class="row mt-3">
                    <div class="col-sm-6">
                        <label class="m-0">Status Settings</label>
                        <div class="panel-body">
                            <div>
                                <label class="m-0" >Is this episode Featured:</label>
                                <input type="checkbox" @if(!empty($episodes->featured) && $episodes->featured == 1){{ 'checked="checked"' }}@endif name="featured" value="1" id="featured" />
                            </div>
                            <div class="clear"></div>
                            <div>
                                <label class="m-0">Is this episode Active:</label>
                                <input type="checkbox" @if(!empty($episodes->active) && $episodes->active == 1){{ 'checked="checked"' }}@endif name="active" value="1"
                                id="active" />
                            </div>
                            <div class="clear"></div>
                            <div>
                                <label class="m-0">Is this episode display in Banner:</label>
                                <input type="checkbox" @if(!empty($episodes->banner) && $episodes->banner == 1){{ 'checked="checked"' }}@endif name="banner" value="1" id="banner" />
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <!-- <div class="col-sm-4" id="ppv_price"> 
					<div class="panel panel-primary" data-collapsed="0"> 
						<div class="panel-heading"> <div class="panel-title"> <label>PPV Price :</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<input type="text" class="form-control" placeholder="PPV Price" name="ppv_price" id="price" value="@if(!empty($episodes->ppv_price)){{ $episodes->ppv_price }}@endif">

					</div>
				</div> -->

                    <div class="col-sm-4 mt-3">
                        <div class="panel panel-primary" data-collapsed="0">
                            <!-- <div class="panel-heading"> <div class="panel-title"> <label>Is this video Is Global PPV:</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>  -->
                            <?php //if($settings->ppv_status == 1){ ?>
                            <!-- <label for="global_ppv">Is this video Is Global PPV:</label> -->
                            <!-- <input type="checkbox" name="ppv_status" value="1" id="ppv_status"@if(!empty($episodes->ppv_status) && $episodes->ppv_status == 1){{ 'checked="checked"' }}@elseif(!isset($episodes->ppv_status)){{ 'checked="checked"' }}@endif /> -->
                            <?php //} else{ ?>
                            <!-- <div class="global_ppv_status"> -->
                            <!-- <label for="global_ppv">Is this video Is PPV:</label> -->
                            <!-- <input type="checkbox" name="ppv_status" value="1" id="ppv_status"@if(!empty($episodes->ppv_status) && $episodes->ppv_status == 1){{ 'checked="checked"' }}@elseif(!isset($episodes->ppv_status)){{ 'checked="checked"' }}@endif /> -->
                            <!-- </div> -->
                            <?php //} ?>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="col-sm-8 p-3">
                        @if(isset($series->id))
                        <input type="hidden" id="series_id" name="series_id" value="{{ $episodes->series_id }}" />
                        @endif @if(isset($episodes->id))
                        <input type="hidden" id="season_id" name="season_id" value="{{ $episodes->season_id }}" />
                        @endif @if(isset($episodes->id))
                        <input type="hidden" id="id" name="id" value="{{ $episodes->id }}" />
                        @endif
                        <input type="hidden" id="selectedImageUrlInput" name="selected_image_url" value="">
                        <input type="hidden" id="videoImageUrlInput" name="video_image_url" value="">
                        <input type="hidden" id="SelectedTVImageUrlInput" name="selected_tv_image_url" value="">
                        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                        <input type="submit" value="{{ $button_text }}" class="btn btn-primary pull-right" />
                    </div>
                </div>
                <!-- row -->
            </form>

            <div class="clear"></div>
        </div>
    </div>
        @section('javascript')

        <script type="text/javascript" src="{{ URL::to('/assets/admin/js/tinymce/tinymce.min.js') }}"></script>
        <script type="text/javascript" src="{{ URL::to('/assets/js/tagsinput/jquery.tagsinput.min.js') }}"></script>
        <script type="text/javascript" src="{{ URL::to('/assets/js/jquery.mask.min.js') }}"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

       
        
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var player = videojs('my-video', { // Video Js Player
                    aspectRatio: '16:9',
                    fill: true,
                    playbackRates: [0.5, 1, 1.5, 2, 3, 4],
                    fluid: true,
                    controlBar: {
                        volumePanel: { inline: false },
                        children: {
                            'playToggle': {},
                            // 'currentTimeDisplay': {},
                            'liveDisplay': {},
                            'flexibleWidthSpacer': {},
                            'progressControl': {},
                            'remainingTimeDisplay': {},
                            'fullscreenToggle': {},
                            // 'audioTrackButton': {},
                            'subtitlesButton': {},
                        },
                        pictureInPictureToggle: true,
                    },
                    html5: {
                        vhs: {
                            overrideNative: true,
                        }
                    }
                });
                const text = document.querySelector('.vjs-text-track-cue');
                console.log("text",text);
                
            });
        </script>

        <style>
            .vjs-text-track-cue {
                inset: 583.333px 0px 0px !important;
            }
        </style>

        <script>            
         
            $(document).ready(function ($) {

                $("#duration").mask("00:00:00");
                $('#intro_start_time').mask("00:00:00");
                $('#intro_end_time').mask("00:00:00");
                $('#recap_start_time').mask("00:00:00");
                $('#recap_end_time').mask("00:00:00");
                $('#skip_intro').mask("00:00:00");
                $('#skip_recap').mask("00:00:00");
            });

            $(document).ready(function () {
                
                $("#ppv_price").hide();
                $("#global_ppv_status").hide();
                // alert($(this).val());
                if ($("#access").val() == "ppv") {
                    // alert($(this).val());
                    $("#ppv_price").show();
                    $("#global_ppv_status").show();
                } else {
                    $("#ppv_price").hide();
                    $("#global_ppv_status").hide();
                }
                $("#access").change(function () {
                    if ($(this).val() == "ppv") {
                        // alert($(this).val());
                        $("#ppv_price").show();
                        $("#global_ppv_status").show();
                    } else {
                        $("#ppv_price").hide();
                        $("#global_ppv_status").hide();
                    }
                });
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
        <script type="text/javascript">
            $ = jQuery;

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

        @section('javascript')

        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
        <script src="https://cdn.ckeditor.com/ckeditor5/38.1.1/classic/ckeditor.js"></script>
        <script>
                 ClassicEditor
                    .create( document.querySelector( '#description_editor' ) )
                    .catch( error => {
                        console.error( error );
                    } );
                    </script>

        {{-- image validation --}}
        <script>
           $(document).ready(function(){
                $('#episode_image').on('change', function(event) {
                    var file = this.files[0];
                    var tmpImg = new Image();

                    tmpImg.src=window.URL.createObjectURL( file ); 
                    tmpImg.onload = function() {
                    width = tmpImg.naturalWidth,
                    height = tmpImg.naturalHeight;
                    console.log('img width: ' + width);
                    var validWidth = {{ $compress_image_settings->width_validation_episode ?: 720 }};
                    var validHeight = {{ $compress_image_settings->height_validation_episode ?: 1280 }};
                    console.log('validation width:  ' + validWidth);

                    if (width !== validWidth || height !== validHeight) {
                            document.getElementById('season_image_error_msg').style.display = 'block';
                            $('.pull-right').prop('disabled', true);
                            document.getElementById('season_image_error_msg').innerText = 
                                `* Please upload an image with the correct dimensions (${validWidth}x${validHeight}px).`;
                        } else {
                            document.getElementById('season_image_error_msg').style.display = 'none';
                            $('.pull-right').prop('disabled', false);
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
                    console.log('player width ' + width)

                    var valid_player_Width = {{ $compress_image_settings->episode_player_img_width ?: 1280 }};
                    var valid_player_Height = {{ $compress_image_settings->episode_player_img_height ?: 720 }};
                    console.log('validation player width:  ' + valid_player_Width);

                    if (width !== valid_player_Width || height !== valid_player_Height) {
                        $('#player_image_error_msg').show();
                        $('.update_btn').prop('disabled', true);
                        document.getElementById('player_image_error_msg').innerText = 
                        `* Please upload an image with the correct dimensions (${valid_player_Width}x${valid_player_Height}px).`;
                    } else {
                        $('#player_image_error_msg').hide();
                        $('.update_btn').prop('disabled', false);
                    }
                    }
                });
            });
        </script>


        <script>

                        // Validation

            $.validator.addMethod('greaterThan', function(value, element) {
                var intro_start_time = $("#intro_start_time").val();
                var intro_end_time = $('#intro_end_time').val();
                return intro_start_time < intro_end_time;
            });

            $.validator.addMethod('Skipintro_greaterThan', function(value, element) {
                var intro_end_time = $("#intro_end_time").val();
                var skip_time = $('#skip_intro').val();
                return skip_time > intro_end_time;
            });


            $.validator.addMethod('RecapgreaterThan', function(value, element) {
                var recap_start_time = $("#recap_start_time").val();
                var recap_end_time = $('#recap_end_time').val();
                return recap_start_time < recap_end_time;
            });

            $.validator.addMethod('Recapintro_greaterThan', function(value, element) {
                var recap_end_time = $("#recap_end_time").val();
                var skip_recap = $('#skip_recap').val();
                return skip_recap > recap_end_time;
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

            if( image_validation_status == "0" || ratio == '0.56'|| ratio == '1.78' || width == param[0] && height == param[1]){
                return true;
            }else{
                return false;
            }
        },'Please upload an image with 1080 x 1920 pixels dimension  or 9:16 Ratio or 16:9 Ratio ');

                // player Image upload validation
        $.validator.addMethod('player_dimention', function(value, element, param) {
            if(element.files.length == 0){
                return true; 
            }

            var width = $(element).data('imageWidth');
            var height = $(element).data('imageHeight');
            var ratio = $(element).data('imageratio');
            var image_validation_status = "{{  image_validation_episode() }}" ;

            if( image_validation_status == "0" || ratio == '1.78'||  width == param[0] && height == param[1]){
                return true;
            }else{
                return false;
            }
        },'Please upload an image with 1280 x 720 pixels dimension  or 16:9 Ratio');


        $.validator.addMethod('tv_image_dimention', function(value, element, param) {
            if(element.files.length == 0){
                return true; 
            }

            var width = $(element).data('imageWidth');
            var height = $(element).data('imageHeight');
            var ratio = $(element).data('imageratio');
            var image_validation_status = "{{  image_validation_episode() }}" ;

            if( image_validation_status == "0" || ratio == '1.78'||  width == param[0] && height == param[1]){
                return true;
            }else{
                return false;
            }
        },'Please upload an image with 1920 X 1080  pixels dimension  or 16:9 Ratio');

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


        $("#Episode_edit").validate({
            rules: {
                title: { 
                    required: true, 
                },

                // image: {
                //     required: '#check_image:blank',
                //     dimention:[1080,1920]
                // },

                // player_image: {
                //     required: '#player_check_image:blank',
                //     player_dimention:[1280,720]
                // },

                // tv_image: {
                //     required: '#check_Tv_image:blank',
                //     tv_image_dimention:[1920,1080]
                // },


                intro_start_time: {
                    required: function(element){
                        if($('#skip_intro').val() !='' || $('#intro_end_time').val() !='' ){
                             return true;
                        } else {
                             return false;
                        }
                    },
                    greaterThan:function(element){
                        if($('#skip_intro').val() !='' || $('#intro_end_time').val() !='' ){
                             return true;
                        } else {
                             return false;
                        }
                    },
                },

                skip_intro: {
                    required: function(element){
                        if($('#intro_start_time').val() !='' || $('#intro_end_time').val() !='' ){
                             return true;
                        } else {
                             return false;
                        }
                    },
                    Skipintro_greaterThan:function(element){
                        if($('#intro_start_time').val() !='' || $('#intro_end_time').val() !='' ){
                             return true;
                        } else {
                             return false;
                        }
                    },
                },

                intro_end_time: {
                    required: function(element){
                        if($('#intro_start_time').val() !='' || $('#skip_intro').val() !='' ){
                             return true;
                        } else {
                             return false;
                        }
                    },
                    Skipintro_greaterThan:function(element){
                        if($('#intro_start_time').val() !='' || $('#intro_end_time').val() !='' ){
                             return true;
                        } else {
                             return false;
                        }
                    },
                },
                
                recap_start_time: {
                    required: function(element){
                        if($('#skip_recap').val() !='' || $('#recap_end_time').val() !='' ){
                             return true;
                        } else {
                             return false;
                        }
                    },
                    RecapgreaterThan:function(element){
                        if($('#skip_recap').val() !='' || $('#recap_end_time').val() !='' ){
                             return true;
                        } else {
                             return false;
                        }
                    },
                },

                skip_recap: {
                    required: function(element){
                        if($('#recap_start_time').val() !='' || $('#recap_end_time').val() !='' ){
                             return true;
                        } else {
                             return false;
                        }
                    },
                    Recapintro_greaterThan:function(element){
                        if($('#recap_start_time').val() !='' || $('#recap_end_time').val() !='' ){
                             return true;
                        } else {
                             return false;
                        }
                    },
                },
                recap_end_time: {
                    required: function(element){
                        if($('#recap_start_time').val() !='' || $('#skip_recap').val() !='' ){
                             return true;
                        } else {
                             return false;
                        }
                    },
                    Recapintro_greaterThan:function(element){
                        if($('#recap_start_time').val() !='' || $('#skip_recap').val() !='' ){
                             return true;
                        } else {
                             return false;
                        }
                    },
                },
            },

            messages: {
                intro_start_time: "Please Enter the valid Intro Start Time,  Lesser than End Time",
                intro_end_time: "Please Enter the valid Intro End Time,  Greater than End Time",
                skip_intro: "Please Enter the valid Skip Intro Time,  Greater than End Time",

                recap_start_time: "Please Enter the valid Intro Start Time,  Lesser than End Time",
                recap_end_time: "Please Enter the valid Intro End Time,  Greater than End Time",
                skip_recap: "Please Enter the valid Skip Intro Time,  Greater than End Time",
        }
        });

        // Search Tag

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
	
    var tagsdata = '<?= $episodes->search_tags ?>';

	if(tagsdata == ""){
            tagInput1.addData([])
    }
    else{
        var search_tag = "<?= $episodes->search_tags ?>";
        var tagsArray = search_tag.split(',');

        for (var i = 0; i < tagsArray.length; i++) {
            tagInput1.addData([tagsArray[i]]);
        }
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
 
    }
    $.ajax({
            url: '{{ URL::to('admin/episode/extractedimage') }}',
            type: "post",
            data: {
                _token: '{{ csrf_token() }}',
                episode_id: $('#id').val(),
            },
            success: function(value) {
                // console.log(value.ExtractedImage.length);

                if (value && value.ExtractedImage.length > 0) {
                    $('#ajaxImagesContainer').empty();
                    $('#ImagesContainer').empty();
                    var ExtractedImage = value.ExtractedImage;
                    var ExtractedImage = value.ExtractedImage;
                    var episodeimage = "{{ $episodes->image }}";
                    var episodeplayer_image = "{{ $episodes->player_image }}";
                    var episodetv_image = "{{ $episodes->tv_image }}";
                    // alert(index);
                    // alert(episodeplayer_image);
                    // alert(episodetv_image);
                    var previouslySelectedElement = null;
                    var previouslySelectedVideoImag = null;
                    var previouslySelectedTVImage = null;
                    
                    ExtractedImage.forEach(function(Image,index ) {
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

                        // if (Image.image_original_name === imgElement) {
                        //     alert();
                        //     imgElement.trigger('click');
                        // }
                        // console.log(Image);
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
                        // if (index === 0) {
                        //     ImagesContainer.click();
                        //     }
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
                        
                        // if (index === 0) {
                        //     TVImagesContainer.click();
                        // }
                        $('#TVImagesContainer').append(TVImagesContainer);

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

                var page = '{{ $page }}' ;
                var status = '{{ $episodes->status }}' ;

                if ((page == 'Edit') && (status == 0)) {
                    setInterval(function(){ 
                        $.getJSON('<?php echo URL::to("/admin/get_processed_percentage_episode/");?>'+'/'+$('#id').val(), function(data) {
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

<script>
    function sourceDownload() {
        $('.source_list').toggle();
    }

    $(document).on('click', function(event) {
        if (!$(event.target).closest('.src-btn, .source_list').length) {
            $('.source_list').hide();
        }
    });
</script>


        @include('admin.series.Ads_episode'); 
        @include('admin.series.palyer_script'); 

        @stop @stop 
    </div>
</div>

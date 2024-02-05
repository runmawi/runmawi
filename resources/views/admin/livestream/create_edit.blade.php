@extends('admin.master')

<style>
    
    .select2-selection__rendered {
        background-color: #f7f7f7 !important;
        border: none !important;
    }
    .select2-container--default .select2-selection--multiple {
        border: none !important;
    }
    #video {
        background-color: #f7f7f7 !important;
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
    .upgrade{
        text-decoration: underline;
        color: #000;
    }
    .twitter{
        text-align: center;
        margin: 10px;
       box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        padding: 10px 10px 10px 10px;
        border-radius: 10px;
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
} */
</style>

@section('css')
<link rel="stylesheet" href="{{ URL::to('/assets/js/tagsinput/jquery.tagsinput.css') }}" />

@stop
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@section('content')
<div id="content-page" class="content-page">
     <div class="d-flex">
                        <a class="black" href="{{ URL::to('admin/livestream') }}">All Live Stream</a>
                        <a class="black" style="background:#fafafa!important;color: #006AFF!important;" href="{{ URL::to('admin/livestream/create') }}">Add New Live Stream</a>
                        <a class="black" href="{{ URL::to('admin/CPPLiveVideosIndex') }}">Live Stream For Approval</a>
                        <a class="black" href="{{ URL::to('admin/livestream/categories') }}">Manage Live Stream Categories</a></div>
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
                    @endif @if(!empty($video->id))
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>Live video</h4>
                        </div>
                        <div>
                            <a href="{{ URL::to('/live/').$video->slug.'/'. $video->id }}" target="_blank" class="btn btn-primary"> <i class="fa fa-eye"></i> Preview <i class="fa fa-external-link"></i> </a>
                        </div>
                    </div>
                    @else
                    <h5><i class="entypo-plus"></i> Add New LiveStream</h5>
                    @endif
                    <hr />
                </div>
                @if (Session::has('message'))
                <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
                @endif @if(count($errors) > 0) @foreach( $errors->all() as $message )
                <div class="alert alert-danger display-hide" id="successMessage">
                    <button id="successMessage" class="close" data-close="alert"></button>
                    <span>{{ $message }}</span>
                </div>
                @endforeach @endif
                <div class="clear"></div>

                <form method="POST" action="{{ $post_route }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data" style="" id="live_video">
                    <div class="row mt-3">
                        <div class="col-sm-6">
                            <label class="m-0">Title</label>
                            <p class="p1">Add the Live stream title in the textbox below:</p>

                            <div class="panel-body">
                                <input type="text" class="form-control" name="title" id="title" placeholder="Live stream Title" value="@if(!empty($video->title)){{ $video->title }}@endif" />
                            </div>
                        </div>

                        @if(!empty($video->created_at))
                        <div class="col-sm-6">
                            <label class="m-0">Published Date</label>
                            <p class="p1">Live stream  Published on Date/Time Below</p>
                            <div class="panel-body">
                                <input type="text" class="form-control" name="created_at" id="created_at" placeholder="" value="@if(!empty($video->created_at)){{ $video->created_at }}@endif" />
                            </div>
                        </div>
                        @endif

                        <div class="col-sm-6">
                            <label class="m-0">Slug</label>
                            <p class="p1">Add the Live stream  slug in the textbox below:</p>
                            <div class="panel-body">
                                <input type="text" class="form-control" name="slug" id="slug" placeholder="Live stream Slug" value="@if(!empty($video->slug)){{ $video->slug }}@endif" />
                            </div>
                        </div>
                    </div>
                <div class="row mt-2 align-items-center">
                    <div class="col-md-6">
                   
                                        <div class="">
                                            <label class="m-0">Live Stream Image Cover</label>
                                            <p class="p1">Select the Live stream  image ( 9:16 Ratio or 1080X1920px ):</p>

                                            <div class="panel-body">
                                                <input type="file" multiple="true" class="form-group" name="image" id="image" accept="image/*"/>
                                            </div>
                                        </div>

                                        <div class="mt-2 text-center">
                                            <div class="panel-body">
                                                @if(!empty($video->image))
                                                <img src="{{ URL::to('/') . '/public/uploads/images/' . $video->image }}" class="video-imgimg" width="200" />
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                    
                    <div class="col-md-6">
                    <div class="row mt-3">
                                        <div class="">
                                            <label class="m-0">Player Image Cover</label>
                                            <p class="p1">Select the Live stream  image( 16:9 Ratio or 1920X1080px ):</p>

                                            <div class="panel-body">
                                                <input type="file" multiple="true" class="form-group" name="player_image" id="player_image" accept="image/*"/>
                                            </div>
                                        </div>

                                        <div class="mt-2 text-center">
                                            <div class="panel-body">
                                                @if(!empty($video->player_image))
                                                <img src="{{ URL::to('/') . '/public/uploads/images/' . $video->player_image }}" class="video-imgimg" width="200" />
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                    </div>
                </div>
                                    

                    <div class="row mt-3">
                        <div class="col-sm-6">
                            <label class="m-0">Live Stream Source</label>
                            <p class="p1">Select the Live Stream Source :</p>
                            <div class="panel-body">
                                <select class="form-control url_type" id="url_type" name="url_type" >
                                    <option value="" >Choose URL Format</option>
                                    <option value="mp4"> MP4/M3U8 URL </option>
                                    <option value="embed"> Embed URL</option>
                                    <option value="live_stream_video"> Live Stream Video</option>
                                    <option value="m3u_url"> M3U URL </option>
                                    <option value="acc_audio_file"> Mp3/AAC Audio File </option>
                                    <option value="acc_audio_url"> Mp3/AAC Audio URL </option>
                                    @foreach($Rtmp_urls as $key => $urls)
                                        <option class="Encode_stream_video" value={{ "Encode_video" }} data-name="{{ $urls->rtmp_url }}" data-hls-url="{{ $urls->hls_url  }}" >{{ "RTMP Streaming"." ". ($key+1) }} </option>
                                    @endforeach 
                                </select>

                                <input type="hidden" name="Rtmp_url" id="Rtmp_url" value="" />
                                <input type="hidden" name="hls_url" id="hls_url" value="" />
                                <input type="hidden" name="tv_image_live_validation_status" id="tv_image_live_validation_status" value="{{ tv_image_live_validation_status() }}" />


                                <div class="new-video-upload mt-2" id="mp4_code">
                                    <label for="embed_code"><label class="mb-1">Live Stream URL </label></label>
                                    <input type="text" name="mp4_url" class="form-control" id="mp4_url" value="@if(!empty($video->mp4_url) ) {{ $video->mp4_url}}  @endif" />
                                </div>

                                <div class="new-video-upload mt-2" id="embed_code">
                                    <label for="embed_code"><label class="mb-1">Live Embed URL (Add the url from SRC tag)</label></label>
                                    <input type="text" name="embed_url" class="form-control" id="embed_url" value="@if(!empty($video->embed_url) ) {{ $video->embed_url}}  @endif" />
                                </div>

                                <div class="new-video-upload mt-2" id="m3u_urls">
                                    <label for="m3u_url"><label class="mb-1"> M3U URL</label></label>
                                    <input type="text" name="m3u_url" class="form-control" id="m3u_url" value="@if(!empty($video->m3u_url) ) {{ $video->m3u_url}}  @endif" />
                                </div>

                                <div class="new-video-upload mt-2" id="acc_audio_file">
                                    <label for=""><label>ACC Audio File</label></label>
                                    <input type="file" multiple="true"  accept=".mp3,audio/*" class="form-group" name="acc_audio_file"  />
                                </div>

                                <div class="new-video-upload mt-2" id="acc_audio_url">
                                    <label><label class="mb-1"> ACC Audio URL</label></label>
                                    <input type="text" name="acc_audio_url" class="form-control" id="acc_audio_url" value="@if(!empty($video->acc_audio_url) ) {{ $video->acc_audio_url}}  @endif" />
                                </div>

                                <div class="new-video-upload mt-2" id="live_stream_video">
                                    <label for=""><label>Live Stream Video</label></label>
                                    <input type="file" multiple="true" accept="video/mp4,video/x-m4v,video/*" class="form-group" name="live_stream_video"  />
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label class="m-0">TV Image Cover</label>
                            <div class="panel-body">
                                <div class="new-video-upload mt-2" id="">
                                    <p class="p1">Select The Live Stream TV Image  (1920 X 1080  Or 16:9 Ratio) :</p>
                                    <input type="file" multiple="true" class="form-group" name="live_stream_tv_image" id=live_stream_tv_image  accept="image/*" />
                                </div>
                            </div>
                        </div>

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
                                    
                                        {{-- Re-Stream  --}}
                    <div class="row mt-3 d-flex ">
                        <div class="col-sm-6">
                            <label class="m-0">Enable Re-Stream</label>
                            <div class="panel-body">
                                <div class="mt-1">
                                    <label class="switch">
                                        <input name="enable_restream" class="enable_restream" id="enable_restream" type="checkbox" >
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label class="m-0">Search Tags</label>
                            <div class="panel-body">
                                <input type="text" id="tag-input1" name="searchtags">
                            </div>
                        </div>
                    </div>

                                    {{-- YouTube Stream  --}}
                    <div class="row mt-3" id="youtube_restream_url">
                        <div class="col-sm-6">
                            <div class="panel-body">
                                <div class="mt-2" >
                                    <label class="mb-1"> YouTube Stream (RTMP URL) </label>
                                    <input type="text" name="youtube_restream_url" class="form-control" id="youtube_restream_url" placeholder="YouTube Stream Url" value="@if(!empty($video->youtube_restream_url) ) {{ $video->youtube_restream_url}}  @endif" />
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
                                <div class="mt-2" id="fb_restream_url">
                                    <label class="mb-1"> FaceBook Stream (RTMP URL) </label>
                                    <input type="text" name="fb_restream_url" class="form-control" id="" placeholder="Facebook Stream" value="@if(!empty($video->fb_restream_url) ) {{ $video->fb_restream_url}}  @endif" />
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
                                    <input type="text" name="twitter_restream_url" class="form-control" id="" placeholder="Twitter Stream" value="@if(!empty($video->twitter_restream_url) ) {{ $video->twitter_restream_url}}  @endif" />
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
                            <p class="p1">Add a short description of the Livestream below:</p>
                            <div class="panel-body">
                                <textarea class="form-control" name="description" id="description">@if(!empty($video->description)){{ htmlspecialchars($video->description) }}@endif</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-sm-12">
                            <label class="m-0">Live Stream Details, Links, and Info</label>

                            <div class="panel-body">
                                <textarea class="form-control" name="details" id="details">@if(!empty($video->details)){{ htmlspecialchars($video->details) }}@endif</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-sm-6">
                            <label class="m-0">Category</label>
                            <p class="p1">Select a Live Stream Category Below:</p>

                            <div class="panel-body">
                                <select name="video_category_id[]" id="video_category_id" class="js-example-basic-multiple" style="width: 100%;" multiple="multiple">
                                    @foreach($video_categories as $category) @if(in_array($category->id, $category_id))
                                    <option value="{{ $category->id }}" selected="true">{{ $category->name }}</option>
                                    @else
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endif @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="m-0">Language</label>
                            <p class="p1">Select a Live Stream Language Below:</p>

                            <div class="panel-body">
                                <select class="form-control js-example-basic-multiple" id="language" name="language[]" style="width: 100%;" multiple="multiple">
                                    @foreach($languages as $language) @if(in_array($language->id, $languages_id))
                                    <option value="{{ $language->id }}" selected="true">{{ $language->name }}</option>
                                    @else
                                    <option value="{{ $language->id }}">{{ $language->name }}</option>
                                    @endif @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-sm-6">
                            <label class="m-0">Live Stream  Ratings</label>
                            <p class="p1">Live stream Ratings 10 out of 10</p>

                            <div class="panel-body">
                                <select class="js-example-basic-multiple" style="width: 100%;" name="rating" id="rating" tags="true" onkeyup="NumAndTwoDecimals(event , this);" multiple="multiple">
                                    <option value="1">1</option>
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

                        <div class="col-sm-6">
                            <label class="m-0">Live Stream Year</label>
                            <p class="p1">Live Stream  Released Year</p>

                            <div class="panel-body">
                                <input class="form-control" name="year" id="year" value="@if(!empty($video->year)){{ $video->year }}@endif" />
                            </div>
                        </div>
                    </div>

                    @if( choosen_player() == 1  && ads_theme_status() == 1)    {{-- Video.Js Player--}}

                        @if ( admin_ads_pre_post_position() == 1  )

                            <div class="col-sm-6 form-group mt-3">                        {{-- Pre/Post-Advertisement--}}

                                <label> {{ ucwords( 'Choose the Pre / Post-Position Advertisement' ) }}    </label>
                                
                                <select class="form-control" name="pre_post_ads" >

                                    <option value=" " > Select the Post / Pre-Position Advertisement </option>

                                    <option value="random_ads"> Random Ads </option>

                                    @foreach ($video_js_Advertisements as $video_js_Advertisement)
                                        <option value="{{ $video_js_Advertisement->id }}"  > {{ $video_js_Advertisement->ads_name }}</option>
                                    @endforeach
                                
                                </select>
                            </div>
                            
                        @elseif ( admin_ads_pre_post_position() == 0 )

                            <div class="row mt-3">

                                <div class="col-sm-6 form-group mt-3">                        {{-- Pre-Advertisement --}}
                                    <label> {{ ucwords( 'Choose the Pre-Position Advertisement' ) }}  </label>
                                    
                                    <select class="form-control" name="pre_ads" >

                                        <option value=" " > Select the Pre-Position Advertisement </option>
        
                                        <option value="random_ads" > Random Ads </option>
        
                                        @foreach ($video_js_Advertisements as $video_js_Advertisement)
                                            <option value="{{ $video_js_Advertisement->id }}" > {{ $video_js_Advertisement->ads_name }}</option>
                                        @endforeach
                                        
                                    </select>
                                </div>

                                <div class="col-sm-6 form-group mt-3">                        {{-- Post-Advertisement--}}
                                    <label> {{ ucwords( 'Choose the Post-Position Advertisement' ) }}    </label>
                                    
                                    <select class="form-control" name="post_ads" >

                                        <option value=" " > Select the Post-Position Advertisement </option>
        
                                        <option value="random_ads"> Random Ads </option>
        
                                        @foreach ($video_js_Advertisements as $video_js_Advertisement)
                                            <option value="{{ $video_js_Advertisement->id }}" > {{ $video_js_Advertisement->ads_name }}</option>
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

                                    <option value="random_category" > Random Category </option>

                                    @foreach( $ads_category as $ads_category )
                                    <option value="{{ $ads_category->id }}" > {{ $ads_category->name }}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="col-sm-6 form-group mt-3">                        {{-- Mid-Advertisement sequence time--}}
                                <label> {{ ucwords( 'Mid-Advertisement Sequence Time' ) }}   </label>
                                <input type="text" class="form-control" name="video_js_mid_advertisement_sequence_time"  placeholder="HH:MM:SS"  id="video_js_mid_advertisement_sequence_time" value="" >
                            </div>

                        </div>
                        
                                {{-- Ply.io --}}
                    @else    

                                                {{-- Ads Position --}}
                        <div class="row mt-3">
                            <div class="col-sm-6"  >
                                <label class="m-0">Choose Ads Position</label>
                                <select class="form-control" name="ads_position" id="ads_position" >
                                <option value=" ">Select the Ads Position </option>
                                <option value="pre">  Pre-Ads Position</option>
                                <option value="mid">  Mid-Ads Position</option>
                                <option value="post"> Post-Ads Position</option>
                                <option value="all" > All Ads Position</option>
                                </select>
                            </div>

                            <div class="col-sm-6"  >
                                <label class="">Choose Advertisement </label>
                                <select class="form-control" name="live_ads" id="live_ads" >
                                <option value=" ">Select the Advertisement </option>
                                </select>
                            </div>
                        </div>
                    @endif

                    <div class="row mt-3">
                        <div class="col-sm-6">
                            <label class="m-0">Enable Free Duration</label>
                            <p class="p1">Enable / Disable Free Duration</p>
                            <div class="panel-body">
                                <div class="mt-1">
                                    <label class="switch">
                                        <input name="free_duration_status" class="free_duration_status" id="free_duration_status" type="checkbox" >
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label class="m-0">Free Duration</label>
                            <p class="p1">Enter the Live Stream Free duration in (HH : MM : SS)</p>
                            <div class="panel-body">
                                <input class="form-control" name="free_duration" id="free_duration" value="" />
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-sm-6">
                            <label class="m-0">Duration</label>
                            <p class="p1">Enter the Live Stream duration in (HH : MM : SS)</p>
                            <div class="panel-body">
                                <input class="form-control" name="duration" id="duration" value="@if(!empty($video->duration)){{ gmdate('H:i:s', $video->duration) }}@endif" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="m-0">User Access</label>
                            <p class="p1">Who is allowed to view this Live Stream ?</p>
                            <div class="panel-body">
                                <select class="form-control" id="access" name="access">
                                    <option value="guest" @if(!empty($video->access) && $video->access == 'guest'){{ 'selected' }}@endif>Guest (everyone)</option>
                                    <option value="subscriber" @if(!empty($video->access) && $video->access == 'subscriber'){{ 'selected' }}@endif>Subscriber (only paid subscription users)</option>
                                    <option value="ppv" @if(!empty($video->access) && $video->access == 'ppv'){{ 'selected' }}@endif >PPV Users (Pay per movie)</option>
                                </select>
                                <div class="clear"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3" id="ppv_price">
                        <div class="col-sm-6">
                            <label class="m-0">PPV Price</label>
                            <p class="p1">Apply PPV Price from Global Settings?  <input type="checkbox" id="ppv_purchase_active" /> </p>
                            <div class="panel-body">
                                <input type="text" class="form-control" placeholder="PPV Price" name="ppv_price" id="price" value="@if(!empty($video->ppv_price)){{ $video->ppv_price }}@endif" />
                                <div class="clear"></div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label class="m-0"> IOS PPV Price</label>
                            <p class="p1">Apply IOS PPV Price from Global Settings?</p>
                            <div class="panel-body">
                                <select  name="ios_ppv_price" class="form-control" id="ios_ppv_price">
                                    <option value= "" >Select IOS PPV Price: </option>
                                    @foreach($InappPurchase as $Inapp_Purchase)
                                    <option value="{{ $Inapp_Purchase->product_id }}"> {{ $Inapp_Purchase->plan_price }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-sm-4">
                            <label class="m-0">Publish Type</label>
                            <div class="panel-body p2" style="color: black;">
                                <input type="radio" id="publish_now" name="publish_type"  value="publish_now" checked /> Publish Now&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
                                <input type="radio" id="publish_later" name="publish_type"  value="publish_later" /> Publish Later
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div id="publishlater">
                                <label class="m-0">Publish Time</label>
                                <div class="panel-body">
                                    <input type="datetime-local" class="form-control" id="publish_time" name="publish_time" value="@if(!empty($video->publish_time)){{ $video->publish_time }}@endif" />
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4" id="publishlater">
                            <label class="m-0">Status Settings</label>
                            <div class="panel-body">
                                <div>
                                    <label class="p2" for="featured">Is this Live stream Featured:</label>
                                    <input type="checkbox" @if(!empty($video->featured) && $video->featured == 1){{ 'checked="checked"' }}@endif name="featured" value="1" id="featured" />
                                </div>
                                <div class="clear"></div>
                                <div>
                                    <label class="p2" for="active">Is this Live stream Active:</label>
                                    <input type="checkbox" @if(!empty($video->active) && $video->active == 1){{ 'checked="checked"' }}@elseif(!isset($video->active)){{ 'checked="checked"' }}@endif name="active" value="1" id="active" />
                                </div>
                                <div class="clear"></div>
                                <div>
                                    <label class="p2" for="banner">Is this Live stream display in Banner:</label>
                                    <input type="checkbox" @if(!empty($video->banner) && $video->banner == 1){{ 'checked="checked"' }}@endif name="banner" value="1" id="banner" />
                                </div>
                                <div>
                                    <!-- <label for="footer" >Is this video display in footer:</label>
                            <input type="checkbox" @if(!empty($video->footer) && $video->footer == 1){{ 'checked="checked"' }}@endif name="footer" value="1" id="footer" /> -->
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <!-- row -->

                    @if(!isset($video->user_id))
                    <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}" />
                    @endif @if(isset($video->id))
                    <input type="hidden" id="id" name="id" value="{{ $video->id }}" />
                    <input type="hidden" name="ppv_price" id="price" value="$video->ppv_price" />
                    @endif
                    
                    <input type="hidden" class="btn btn-primary" name="_token" value="<?= csrf_token() ?>" />
                    <div class="d-flex justify-content-end">
                    <input type="submit" value="{{ $button_text }}" class="btn btn-primary" /></div>
                </form>

                <div class="clear"></div>
                <!-- This is where now -->
            </div>
        </div>
        
    
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

@section('javascript')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.min.js"></script>
<script type="text/javascript" src="{{ URL::to('/assets/admin/js/tinymce/tinymce.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('/assets/js/tagsinput/jquery.tagsinput.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('/assets/js/jquery.mask.min.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>

<!-- {{-- validate --}} -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<script src="<?= URL::to('/assets/js/jquery.mask.min.js');?>"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
<script src="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>

<script type="text/javascript">

        $ = jQuery;

        $(document).ready(function($){
            $("#duration").mask("00:00:00");
            $("#free_duration").mask("00:00:00");
            $("#inputTag").tagsinput('items');
            $("#video_js_mid_advertisement_sequence_time").mask("00:00:00");
        });

            // Live Stream Validation
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

                // Image upload dimention validation
        $.validator.addMethod('dimention', function(value, element, param) {
            if(element.files.length == 0){
                return true; 
            }

            var width = $(element).data('imageWidth');
            var height = $(element).data('imageHeight');
            var ratio = $(element).data('imageratio');
            var image_validation_status = "{{  image_validation_live() }}" ;

            if( image_validation_status == "0" || ratio == '0.56'|| width == param[0] && height == param[1]){
                return true;
            }else{
                return false;
            }
        },'Please upload an image with 1080 x 1920 pixels dimension or 9:16 ratio');

                // player Image upload validation
        $.validator.addMethod('player_dimention', function(value, element, param) {
            if(element.files.length == 0){
                return true; 
            }

            var width = $(element).data('imageWidth');
            var height = $(element).data('imageHeight');
            var ratio = $(element).data('imageratio');
            var image_validation_status = "{{  image_validation_live() }}" ;

            if( image_validation_status == "0" || ratio == '1.78' ||  width == param[0] && height == param[1]){
                return true;
            }else{
                return false;
            }
        },'Please upload an image with 1280 x 720 pixels dimension or 16:9 ratio');

                        // TV Image upload validation
                        
        $.validator.addMethod('tv_image_dimention', function(value, element, param) {
            if(element.files.length == 0){
                return true; 
            }

            var width = $(element).data('imageWidth');
            var height = $(element).data('imageHeight');
            var ratio = $(element).data('imageratio');
            var image_validation_status = "{{  image_validation_live() }}" ;

            if( image_validation_status == "0" || ratio == '1.78' ||  width == param[0] && height == param[1]){
                return true;
            }else{
                return false;
            }
        },'Please upload an image with 1920 X 1080 pixels dimension or 16:9 ratio');


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

        $('#live_stream_tv_image').change(function() {

            $('#live_stream_tv_image').removeData('imageWidth');
            $('#live_stream_tv_image').removeData('imageHeight');
            $('#live_stream_tv_image').removeData('imageratio');

            var file = this.files[0];
            var tmpImg = new Image();

            tmpImg.src=window.URL.createObjectURL( file ); 
            tmpImg.onload = function() {
                width = tmpImg.naturalWidth,
                height = tmpImg.naturalHeight;
				ratio =  Number(width/height).toFixed(2) ;

                $('#live_stream_tv_image').data('imageWidth', width);
                $('#live_stream_tv_image').data('imageHeight', height);
                $('#live_stream_tv_image').data('imageratio', ratio);
            }
        });


    $('form[id="live_video"]').validate({
        rules: {
            title: "required",
            url_type: "required",
            duration: "required",
            'language[]': {
                required: true
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
                required: function (element) {
                    var action = $(".url_type").val();
                    if (action == "mp4") {
                        return true;
                    } else {
                        return false;
                    }
                },
            },

            image: {
                required: true,
                dimention:[1080,1920]
            },

            player_image: {
                required: true,
                player_dimention:[1280,720]
            },

            live_stream_tv_image: {
                required: function (element) {
                    var action =  $("#tv_image_live_validation_status").val(); 
                    if (action == '1' ) {
                        return true;
                    } else {
                        return false;
                    }
                },
                tv_image_dimention:[1920,1080]
            },

            live_stream_video: {
                required: function (element) {
                    var action = $(".url_type").val();
                    if (action == "live_stream_video") {
                        return true;
                    } else {
                        return false;
                    }
                },
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
                required: function (element) {
                    var action = $(".url_type").val();
                    if (action == "embed") {
                        return true;
                    } else {
                        return false;
                    }
                },
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
            title: "This field is required",
            image: "This field is required",
            mp4_url: "This field is required",
            image: {
                required: "This field is required",
            },
        },
        submitHandler: function (form) {
            form.submit();
        },
    });
</script>
<!-- {{-- end validate --}} -->


{{-- Restream  Script--}}

<script>

    $(document).ready(function(){
        $('#fb_restream_url').hide();
        $('#youtube_restream_url').hide();
        $('#twitter_restream_url').hide();

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

</script>

<script>

    $('#ppv_purchase_active').on('change', function(event) {
        
        var ppv_gobal_price = {{ $ppv_gobal_price }};
        $('#price').val('');

        var ppv_purchase_active = $("#ppv_purchase_active").prop("checked");
            if(ppv_purchase_active == true){
                $("#price").val(ppv_gobal_price);
            }
        });
</script>

{{-- Sweet alert --}}

@php
    $liveStreamVideo_errors = $liveStreamVideo_error;
@endphp

<script type="text/javascript">

    let Stream_error = '{{ $liveStreamVideo_errors }}';

    $( document ).ready(function() {
        if( Stream_error == 1){
            Swal.fire({
            allowOutsideClick:false,
            icon: 'error',
            title: 'Oops...',
            text: 'While Converting the Live Stream video, Something went wrong!',
            }).then(function (result) {
            if (result.value) {
                location.href = '{{ URL::to('admin/livestream/create') }}';
            }
            })
        }
    });
</script>

{{-- Sweet alert --}}

<script type="text/javascript">
    $(document).ready(function () {

        $("#mp4_code").hide();
        $("#embed_code").hide();
        $("#live_stream_video").hide();
        $("#m3u_urls").hide();
        $("#acc_audio_file").hide();
        $("#acc_audio_url").hide();
        
        $("#url_type").change(function () {

            $("#mp4_code").hide();
            $("#embed_code").hide();
            $("#live_stream_video").hide();
            $("#m3u_urls").hide();
            $("#acc_audio_file").hide();
            $("#acc_audio_url").hide();

            if ($("#url_type").val() == "mp4") {
                $("#mp4_code").show();
                $("#embed_code").hide();
                $("#live_stream_video").hide();
                $("#m3u_urls").hide();
                $("#acc_audio_file").hide();
                $("#acc_audio_url").hide();
            } 
            else if ($("#url_type").val() == "embed") {
                $("#embed_code").show();
                $("#mp4_code").hide();
                $("#live_stream_video").hide();
                $("#m3u_urls").hide();
                $("#acc_audio_file").hide();
                $("#acc_audio_url").hide();
            }
            else if ($("#url_type").val() == "live_stream_video") {
                $("#embed_code").hide();
                $("#mp4_code").hide();
                $("#live_stream_video").show();
                $("#m3u_urls").hide();
                $("#acc_audio_file").hide();
                $("#acc_audio_url").hide();
            }
            else if ($("#url_type").val() == "Encode_video") {
                $("#embed_code").hide();
                $("#mp4_code").hide();
                $("#live_stream_video").hide();
                $("#m3u_urls").hide();
                $("#acc_audio_file").hide();
                $("#acc_audio_url").hide();
            }
            else if ($("#url_type").val() == "m3u_url") {
                $("#embed_code").hide();
                $("#mp4_code").hide();
                $("#live_stream_video").hide();
                $("#m3u_urls").show();
                $("#acc_audio_file").hide();
                $("#acc_audio_url").hide();
            }
            else if ($("#url_type").val() == "acc_audio_file") {
                $("#embed_code").hide();
                $("#mp4_code").hide();
                $("#live_stream_video").hide();
                $("#m3u_urls").hide();
                $("#acc_audio_file").show();
                $("#acc_audio_url").hide();
            }
            else if ($("#url_type").val() == "acc_audio_url") {
                $("#embed_code").hide();
                $("#mp4_code").hide();
                $("#live_stream_video").hide();
                $("#m3u_urls").hide();
                $("#acc_audio_file").hide();
                $("#acc_audio_url").show();
            }
            else if ($("#url_type").val() == " ") {
                $("#embed_code").hide();
                $("#mp4_code").hide();
                $("#live_stream_video").hide();
                $("#m3u_urls").hide();
                $("#acc_audio_file").hide();
                $("#acc_audio_url").hide();
            }
        });
    });


    $(document).ready(function () {
        $("#publishlater").hide();

        if ($("#publish_now").val() == "publish_now") {
            $("#publishlater").hide();
        } else if ($("#publish_later").val() == "publish_later") {
            $("#publishlater").show();
        }

        $("#publish_now").click(function () {
            $("#publishlater").hide();
        });

        $("#publish_later").click(function () {
            $("#publishlater").show();
        });

        if ($("#publish_now").val() == "publish_now") {
            $("#publishlater").hide();
        } else if ($("#publish_later").val() == "publish_later") {
            $("#publishlater").show();
        }
    });

    $(document).ready(function () {
        if ($("#access").val() == "ppv") {
            $("#ppv_price").show();
        } else {
            $("#ppv_price").hide();
        }

        $("#access").change(function () {
            if ($(this).val() == "ppv") {
                $("#ppv_price").show();
            } else {
                $("#ppv_price").hide();
            }
        });
    });

    $ = jQuery;

    $(document).ready(function () {
        $(".js-example-basic-multiple").select2();

        $("#tags").tagsInput();

        $("#type").change(function () {
            if ($(this).val() == "file") {
                $(".new-video-file").show();
                $(".new-video-embed").hide();
                $(".new-video-upload").hide();
            } else if ($(this).val() == "embed") {
                $(".new-video-file").hide();
                $(".new-video-embed").show();
                $(".new-video-upload").hide();
            } else {
                $(".new-video-file").hide();
                $(".new-video-embed").hide();
                $(".new-video-upload").show();
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
    <script>
        $(document).ready(function () {
            // $('#message').fadeOut(120);
            setTimeout(function () {
                $("#successMessage").fadeOut("fast");
            }, 3000);

        });
    </script>

@include('admin.livestream.search_tag'); 

@include('admin.livestream.Ads_live'); 

@stop @stop
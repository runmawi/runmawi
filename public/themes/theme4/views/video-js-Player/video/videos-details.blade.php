@php  include public_path('themes/theme4/views/header.php'); @endphp
@php
    $embed_media_url = URL::to('category/videos/embed/'.$videodetail->slug);
    $url_path = '<iframe width="853" height="480" src="' . $embed_media_url . '"  allowfullscreen></iframe>';
@endphp

@if(Auth::check() && !Auth::guest())
    @php
        $user_name = Auth::user()->username;
        $user_img = Auth::user()->avatar;
        $user_avatar = $user_img !== 'default.png' ? URL::to('public/uploads/avatars/') . '/' . $user_img : URL::to('/assets/img/placeholder.webp');
    @endphp
@endif

{{-- Style Link--}}
    <link rel="stylesheet" href="{{ asset('public/themes/theme4/assets/css/video-js/video-details.css') }}">

{{-- video-js Style --}}

    <link href="https://cdnjs.cloudflare.com/ajax/libs/videojs-ima/1.11.0/videojs.ima.css" rel="stylesheet">
    <link href="https://unpkg.com/video.js@7/dist/video-js.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/@videojs/themes@1/dist/fantasy/index.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/videojs-hls-quality-selector@1.1.4/dist/videojs-hls-quality-selector.min.css" rel="stylesheet">
    <link href="{{ URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.css') }}" rel="stylesheet" >
    {{-- <link href="{{ asset('public/themes/theme4/assets/css/video-js/videos-player.css') }}" rel="stylesheet" > --}}

{{-- video-js Script --}}

    <script src="{{ asset('public/themes/theme4/assets/js/video-js/video.min.js') }}"></script>
    <script src="{{ asset('public/themes/theme4/assets/js/video-js/videojs-contrib-quality-levels.js') }}"></script>
    <script src="{{ asset('public/themes/theme4/assets/js/video-js/videojs-http-source-selector.js') }}"></script>
    <script src="{{ asset('public/themes/theme4/assets/js/video-js/videojs-hls-quality-selector.min.js') }}"></script>
    <script src="{{ URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.js') }}"></script>

    
<style>
    /* payment modal */
    #purchase-modal-dialog{max-width: 100% !important;margin: 0;}
    #purchase-modal-dialog .modal-content{min-height: 100vh;max-height: 245vh;}
    #purchase-modal-dialog .modal-header.align-items-center{height: 70px;border: none;}
    #purchase-modal-dialog .modal-header.align-items-center .col-12{height: 50px;}
    #purchase-modal-dialog .modal-header.align-items-center .d-flex.align-items-center.justify-content-end{height: 50px;}
    #purchase-modal-dialog .modal-header.align-items-center img{height: 100%;width: 100%;}
    .col-sm-7.col-12.details{border-radius: 10px;padding: 0 1.5rem;}
    /* .modal-open .modal{overflow-y: hidden;} */
    div#video-purchase-now-modal{padding-right: 0 !important;}
    .movie-rent.btn{width: 100%;padding: 10px 15px;background-color: #000 !important;}
    .col-md-12.btn {margin-top: 2rem;}
    .d-flex.justify-content-between.title{border-bottom: 1px solid rgba(255, 255, 255, .5);padding: 10px 0;}
    .btn-primary-dark {background-color: rgba(var(--btn-primary-rgb), 0.8); /* Darker version */}
    .title-popup {white-space: normal; overflow: visible; text-overflow: clip;  word-break: break-word;line-height: 1.5;text-align: left;}
    .btn-primary-light {background-color: rgba(var(--btn-primary-rgb), 0.3); /* Lighter version */}
    .close-btn {color: #fff;background: #000;padding: 0;border: 2px solid #fff;border-radius: 50%;line-height: 1;width: 30px;height: 30px;cursor: pointer;outline: none;}
    .payment_btn {width: 20px;height: 20px;margin-right: 10px;}
    .quality_option {width: 15px;height: 15px;margin-right: 10px;}
    span.descript::before {content: '•';margin-right: 5px;color: white;font-size: 16px;}
    input[type="radio"].payment_btn,input[type="radio"].quality_option {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        width: 20px;
        height: 20px;
        border: 2px solid white;
        border-radius: 50%;
        background-color: transparent;
        cursor: pointer;
        position: relative;
    }
    
    input[type="radio"].payment_btn:checked,input[type="radio"].quality_option:checked {
        background-color: black;
        border-color: white;
    }
    
    input[type="radio"].payment_btn:checked::before, input[type="radio"].quality_option:checked::before {
        content: '';
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: white;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    
    body.dark-theme .navbar-collapse {
        background: transparent !important;
    }
    body.dark-theme .music-play-lists li:hover span {
        color: <?php echo $GetDarkText; ?>!important;
    }
    body.dark-theme .share:hover .share-box a {
        color: <?php echo $GetDarkText; ?>!important;
    }
    body.dark-theme .sectionArtists .artistHeading, body.dark-theme .sectionArtists .listItems .listItem .name{color: <?php echo $GetDarkText; ?>!important;}
    
    body.dark-theme .vpageBanner .content .right .circleRating .CircularProgressbar-text {
        fill: <?php echo $GetDarkText; ?>!important;
    }

    body.light-theme h4, body.light-theme p, body.light-theme h3 body.light-theme li {
        color: <?php echo GetLightText(); ?>!important;
    }
    body.light-theme .movie-rent h3.title-popup,body.light-theme .movie-rent h5{
        color: <?php echo GetDarkText(); ?>!important;
    }
    body.light-theme label.text-white {
        color: <?php echo GetDarkText(); ?>!important;
    }
    body.light-theme #price-display {
        color: <?php echo GetDarkText(); ?>!important;
    }
    body.light-theme .bg-dark {
        background-color: <?php echo GetLightBg(); ?>!important;
    }
    body.light-theme .vpageBanner .content .right .utilities {
        color: <?php echo GetLightText(); ?>;
    }
    body.light-theme .CircularProgressbar-text {
        fill: <?php echo GetLightText(); ?>!important;
    }
    body.light-theme .artistHeading {
        color: <?php echo GetLightText(); ?>;
    }
    body.light-theme .name.titleoverflow {
        color: <?php echo GetLightText(); ?>;
    }
    body.light-theme .name {
        color: <?php echo GetLightText(); ?>;
    }
    body.light-theme .artistHeading {
        color: <?php echo GetLightText(); ?>;
    }
    body.light-theme .genre {
        color: <?php echo GetLightText(); ?> !important;
    }
    body.light-theme .heading {
        color: <?php echo GetLightText(); ?> !important;
    }
    body.light-theme .infoItem {
        color: <?php echo GetLightText(); ?> !important;
    }
    body.light-theme .artistHeading {
        color: <?php echo GetLightText(); ?> !important;
    }
    body.light-theme .info {
        color: <?php echo GetLightText(); ?> !important;
    }
    body.dark .modal.show .modal-dialog{background-color: <?php echo $GetLightBg; ?> !important;}
    
    body.light-theme .vpageBanner .opacity-layer {
        background:none;
    }
    body.light-theme .share-box a{color: <?php echo $GetLightText; ?> !important;}
    body.light-theme .share-box span{color: <?php echo $GetLightText; ?> !important;}

    #video-purchase-now-modal .modal-footer{
            background: transparent;
            border-top: 1px solid black;
    }
    
    #quality-options {
        margin-bottom: 20px;
    }
    
    .main-label {
        font-weight: bold;
        margin-bottom: 10px;
        display: block;
    }
    
    .quality-options-group {
        display: flex;
        gap: 20px; 
        align-items: center;
    }
    
    .quality-options-group .radio-inline {
        margin-right: 0; 
    }
    
    #guest-qualitys{display:none;}
    .btn-primary:hover{color:#fff;}
    .title {
        white-space: normal; /* Allows text to wrap onto the next line */
        overflow-wrap: break-word; /* Break long words if necessary */
        word-wrap: break-word; /* Ensure long words are wrapped in older browsers */
    }
    .mob_res_show {display:none !important;}
    
    .btn-primary {
        background-color: var(--btn-primary-color);
    }

    .btn-primary-dark {
        background-color: rgba(var(--btn-primary-color-rgb), 0.5);
    }

    .btn-primary-light {
        background-color: rgba(var(--btn-primary-color-rgb), 0.2);
    }
    @media (min-width: 1400px) and (max-width: 2565px) {
        .my-video.vjs-fluid{
            height: 50vh !important;
        }
        .row.plays_btn_res.m-0{margin-bottom: 2rem !important;}
    }
    @media (max-width:720px){
        .vpageBanner .content .left .posterImg{width:50% !important;}
        .mob_res_show{display:flex !important;}
        .mob_res_hide{display: none;}
        .vpageBanner .content .right svg{height: 40px !important;}
        .row.plays_btn_res {justify-content: center;}
        a.btn.play_button{width: 100%;display: flex;justify-content: center;margin: 1rem 0 0;}
        body.dark-theme .navbar-collapse {background: <?php echo $GetDarkBg; ?>!important;}
    }
    
    .opacity-layer{display: none;}
    .trailer-play{display: none;}
    .trailer-img:hover .img_thum_trailer{opacity: 0.3 !important;}
    .trailer-img:hover .trailer-play {top: 40%;left:2%;cursor: pointer;display: block;}

    .video-js-trailer-modal-dialog {
        /* max-width: 800px; */
        margin: 30px auto;
    }

    .video-js-trailer-modal-body {
        position: relative;
        padding: 0px;
    }

    .video-js-trailer-modal-close {
        position: absolute;
        right: -30px;
        top: 0;
        z-index: 999;
        font-size: 2rem;
        font-weight: normal;
        color: #fff;
        opacity: 1;
    }
    .vjs-controls-enabled .vjs-control-bar {
        display: flex !important;
        opacity: 1 !important;
    }
    .share-box {
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.9s ease, visibility 0s 9s; /* 3s delay for hiding */
    }

    .share:hover .share-box {
        opacity: 1;
        visibility: visible;
        transition: opacity 0.9s ease, visibility 0s 0s; /* Remove delay when hovered */
    }
    
        
    #trailermodal .my-video.vjs-fluid, #trailermodal .modal-content{height: 68vh !important;}
    #trailermodal .embed-responsive{height: 100%;}
    @media screen and (min-width: 1900px){
        #trailermodal .my-video.vjs-fluid{height: 35vh !important;}
        .modal-dialog-centered{align-items: unset;top: 15%;}
        .modal-dialog{max-width: 700px;}
        .trailer-img:hover .trailer-play{left: 1%;}
    }
    @media only screen and (min-height: 2160px){
        #trailermodal .my-video.vjs-fluid{height: 20vh !important;}
        .modal-dialog{max-width: 1000px;}
    }
    @media (max-width:768px){
        .video-js-trailer-modal-close{right: 0;}
        #trailermodal .my-video.vjs-fluid{height: 42vh !important;}
    }
    .embed-responsive::before{display: none;}
    .modal-content{background-color: transparent;}
    .channels-list .channel-row .video-list .item img{opacity: 1;}
    .item.is-selected:hover .controls{opacity: 1;}
</style>

{{-- Section content --}}

    <div class="vpageBanner">
        <div class="backdrop-img">    {{-- Background image --}}
            <span class=" lazy-load-image-background blur lazy-load-image-loaded"  style="color: transparent; display: inline-block;">
                <!-- <img src="{{ optional($videodetail)->player_image_url }}"> -->
            </span>
        </div>

        <!-- <div class="opacity-layer"></div> -->

                {{-- Message Note --}}
        <div id="message-note" ></div>

        <div class="pageWrapper m-0">
                
                            {{-- Breadcrumbs  --}}
            <div class="scp-breadcrumb">
                <ul class="breadcrumb p-0">
                
                    <li><a href="{{ route('latest-videos') }}">{{ ucwords(__('videos')) }}</a> <i class="fa fa-angle-right mx-2" aria-hidden="true"></i> </li>
                
                    @foreach( $videodetail->categories as $key => $category )

                        <li class="breadcrumb-item"> <a href="{{ route('video_categories',[ $category->slug ]) }}">{{ $category->name }}</a> </li>

                    @endforeach
                    
                    <li> <i class="fa fa-angle-right mx-2" aria-hidden="true"></i> </li>
                
                    <li class="active">{{ (strlen($videodetail->title) > 50) ? ucwords(substr($videodetail->title,0,120).'...') : ucwords($videodetail->title) }}</li>
                
                </ul>
            </div>

            <div class="content">
                <div class="left">
                    <span class=" lazy-load-image-background blur lazy-load-image-loaded" style="color: transparent; display: inline-block;">
                        <img class="posterImg"  src="{{ $videodetail->image_url }}" >
                    </span>
                </div>

                <div class="right">
                    <h4 class="title">    {{--  Title & Year--}}
                        {{ optional($videodetail)->title }} 
                    </h4>

                    <div class="utilities d-flex align-items-center">  
                        {{ optional($videodetail)->year }} 
                        <i class="fas fa-circle"></i>

                        {{ $videodetail->duration != null ? gmdate('H:i:s', $videodetail->duration)  : null  }} 
                        <i class="fas fa-circle"></i> 

                        {{ optional($videodetail)->age_restrict }}
                         
                        @if ($setting->show_views == 1)
                            <i class="fas fa-circle"></i>
                            @if(isset($view_increment) && $view_increment == true )
                                {{ ( $movie->views + 1) . " views" }}
                            @else
                                {{ $videodetail->views . " views" }} 
                            @endif
                        @endif
                    </div>
                   
                    @if ( $setting->show_Links_and_details == 1 &&  optional($videodetail)->details )  {{-- Details --}}
                        <div class="subtitle">  
                            {!! html_entity_decode(optional($videodetail)->details) !!}
                        </div>
                    @endif

                    @if ($setting->show_genre == 1 && !$videodetail->categories->isEmpty() )        {{-- categories --}}
                        <div class="genres">  
                            @foreach ( $videodetail->categories as $item )
                                <div class="genre">
                                    <a href="{{ route('video_categories',[ $item->slug ]) }}"> {{ $item->name }} </a>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-xs-12 d-flex">
                            <ul class="list-inline p-0 share-icons music-play-lists">
                                        <!-- Watchlater -->
                                    <li class="share">
                                        <span  data-toggle="modal"  data-video-id={{ $videodetail->id }} onclick="video_watchlater(this)" >
                                            <i class="video-watchlater {{ $videodetail->watchlater_exist ? 'fa fa-minus' : 'fa fa-plus' }}"></i>

                                        </span>
                                        <div class="share-box box-watchtrailer " onclick="video_watchlater(this)" style="top:41px">
                                            <div class="playbtn"  data-toggle="modal">  
                                                <span class="text" style="background-color: transparent; font-size: 14px; width:124px; height:21px">
                                                {{ !empty($videodetail->watchlater_exist) ? "Remove from Watchlist" : "Add To Watchlist"  }}
                                                </span>
                                            </div>
                                        </div>
                                    </li>

                                            <!-- Wishlist -->
                                    <li class="share">
                                        <span data-video-id={{ $videodetail->id }} onclick="video_wishlist(this)" >
                                            <i class="video-wishlist {{ !is_null( $videodetail->wishlist_exist ) ? 'ri-heart-fill' : 'ri-heart-line'  }}"></i>
                                        </span>
                                        <div class="share-box box-watchtrailer " onclick="video_wishlist(this)" style="top:41px">
                                            <div class="playbtn"  data-toggle="modal">  
                                                <span class="text" style="background-color: transparent; font-size: 14px; width:124px; height:21px">
                                                {{ !is_null($videodetail->wishlist_exist) ? "Remove from Wishlist" : "Add To Wishlist"  }}
                                                </span>
                                            </div>
                                        </div>
                                    </li>

                                <!-- Like -->
                                <li class="share">
                                    <span data-video-id={{ $videodetail->id }}  onclick="video_like(this)" >
                                        <i class="video-like {{ !is_null( $videodetail->Like_exist ) ? 'ri-thumb-up-fill' : 'ri-thumb-up-line'  }}"></i>
                                    </span>
                                    <div class="share-box box-watchtrailer " onclick="video_like(this)" style="top:41px">
                                        <div class="playbtn"  data-toggle="modal">  
                                            <span class="text" style="background-color: transparent; font-size: 14px; width:124px; height:21px">
                                                <!-- {{ __('Like video') }} -->
                                                {{ !is_null( $videodetail->Like_exist ) ? "Remove Like" : "Like Video" }}
                                            </span>
                                        </div>
                                    </div>
                                </li>

                                <!-- Dislike -->
                                <li class="share">
                                    <span data-video-id={{ $videodetail->id }}  onclick="video_dislike(this)" >
                                        <i class="video-dislike {{ !is_null( $videodetail->dislike_exist ) ? 'ri-thumb-down-fill' : 'ri-thumb-down-line'  }}"></i>
                                    </span>
                                    <div class="share-box box-watchtrailer " onclick="video_dislike(this)" style="top:41px">
                                        <div class="playbtn"  data-toggle="modal">  
                                            <span class="text" style="background-color: transparent; font-size: 14px; width:124px; height:21px">
                                                <!-- {{ __('Dislike video') }} -->
                                                {{ !is_null( $videodetail->Like_exist ) ? "Remove Dislike" : "Dislike Video" }}
                                            </span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div class="mob_res_show d-flex">

                                @php include public_path("themes/{$current_theme}/views/partials/social-share.php"); @endphp 

                                <div class="circleRating">  {{-- Rating --}}
                                    <svg class="CircularProgressbar " viewBox="0 0 100 100" data-test-id="CircularProgressbar" >
                                        <path class="CircularProgressbar-trail" d="M 50,50m 0,-46a 46,46 0 1 1 0,92a 46,46 0 1 1 0,-92" stroke-width="8" fill-opacity="0" style="stroke-dasharray: 289.027px, 289.027px; stroke-dashoffset: 0px;"></path>
                                        <path class="CircularProgressbar-path" d="M 50,50m 0,-46a 46,46 0 1 1 0,92a 46,46 0 1 1 0,-92" stroke-width="8" fill-opacity="0" style="stroke: orange; stroke-dasharray: 289.027px, 289.027px; stroke-dashoffset: 101.159px;"></path>
                                        <text class="CircularProgressbar-text" style="font-size:35px" x="50" y="50"> {{ optional($videodetail)->rating }}  </text>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row plays_btn_res m-0">
                        @if ( $videodetail->users_video_visibility_status == false && $videodetail->type == 'VideoCipher')

                            @if ( Enable_PPV_Plans() == 1 && !is_null($videodetail->ppv_price_480p) && $videodetail->access == 'ppv'
                            || Enable_PPV_Plans() == 1 && !is_null($videodetail->ppv_price_720p) && $videodetail->access == 'ppv'
                            || Enable_PPV_Plans() == 1 && !is_null($videodetail->ppv_price_1080p) && $videodetail->access == 'ppv') 
                                <a class="btn play_button" data-toggle="modal" data-target="#video-purchase-now-modal">
                                    <div class="playbtn" style="gap:5px">
                                        {!! $play_btn_svg !!}
                                        <span class="text pr-2 text-white"> {{ __( !empty($button_text->purchase_text) ? $button_text->purchase_text : 'Purchase Now' ) }} </span>
                                    </div>
                                </a>
                            @else
                            
                                @if ( $videodetail->users_video_visibility_Rent_button || $videodetail->users_video_visibility_becomesubscriber_button || $videodetail->users_video_visibility_register_button || $videodetail->users_video_visibility_block_button )
                                    <a class="btn play_button" {{ $videodetail->users_video_visibility_Rent_button ? 'data-toggle=modal data-target=#video-purchase-now-modal' : 'href=' . $videodetail->users_video_visibility_redirect_url }}>
                                        <div class="playbtn" style="gap:5px">
                                            {!! $play_btn_svg !!}
                                            <span class="text pr-2 text-white"> {{ __( $videodetail->users_video_visibility_status_button ) }} </span>
                                        </div>
                                    </a>

                                    @if( Auth::guest() && $videodetail->access == "ppv" && $subscribe_btn == 1 || Auth::check() && Auth::user()->role == "registered" && $videodetail->access == "ppv" && $subscribe_btn == 1)
                                        <a class="btn play_button" href="{{ URL::to('/becomesubscriber') }}">
                                            <div class="playbtn" style="gap:5px">
                                                {!! $play_btn_svg !!}
                                                <span class="text pr-2 text-white"> {{ __( !empty($button_text->subscribe_text) ? $button_text->subscribe_text : 'Subscribe Now' ) }} </span>
                                            </div>
                                        </a>
                                    @endif

                                @endif
                            @endif

                            {{-- subscriber & PPV  --}}

                            {{-- @if ( $videodetail->access == "subscriber" && !is_null($videodetail->ppv_price) )
                                <a class="btn" data-toggle="modal" data-target="#video-purchase-now-modal">
                                    <div class="playbtn" style="gap:5px">
                                        {!! $play_btn_svg !!}
                                        <span class="text pr-2"> {{ __( 'Purchase Now' ) }} </span>
                                    </div>
                                </a>
                            @endif  --}}

                        @else 
                            @if ( Enable_PPV_Plans() == 1 && Enable_videoCipher_Upload() == 1 && $videodetail->access == 'guest' && $videodetail->type == 'VideoCipher'
                            || Enable_PPV_Plans() == 1 && Enable_videoCipher_Upload() == 1 &&  $videodetail->access == 'registered' && $videodetail->type == 'VideoCipher'
                             || Enable_PPV_Plans() == 1 && Enable_videoCipher_Upload() == 1 &&  $videodetail->access == 'subscriber' && $videodetail->type == 'VideoCipher'
                             || !Auth::guest() && Auth::user()->role == 'admin' && Enable_PPV_Plans() == 1 && Enable_videoCipher_Upload() == 1 &&  $videodetail->access == 'ppv' && $videodetail->type == 'VideoCipher')
                             
                                <div class="dropdown btn" id="guest-qualitys-selct">
                                    <div class="playbtn" style="gap:5px;">
                                        {!! $play_btn_svg !!}
                                        <span class="playbtn" class="playbtn" style="gap:5px" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ __( $videodetail->users_video_visibility_status_button ) }}
                                        </span>
                                    </div>
                                </div>
                                <div id="guest-qualitys">
                                    <div class="quality-dropdown-menu d-flex"  aria-labelledby="dropdownMenuButton" style="gap:5px;">
                                        @if(!empty($videodetail->video_id_480p)) <span class="text pr-2 btn btn-primary"><a class="dropdown-item btn btn-primary" href="{{ $videodetail->users_video_visibility_redirect_url.'/480p' }}">Watch In 480P</a></span> @endif
                                        @if(!empty($videodetail->video_id_720p)) <span class="text pr-2 btn btn-primary"><a class="dropdown-item btn btn-primary" href="{{ $videodetail->users_video_visibility_redirect_url.'/720p' }}">Watch In 720P</a></span> @endif
                                        @if(!empty($videodetail->video_id_1080p)) <span class="text pr-2 btn btn-primary"><a class="dropdown-item btn btn-primary" href="{{ $videodetail->users_video_visibility_redirect_url.'/1080p' }}">Watch In 1080P</a></span> @endif
                                    </div>
                                </div>
                            
                            @elseif(Enable_PPV_Plans() == 0 && $videodetail->users_video_visibility_status == 'true')
                                <a class="btn play_button" href="{{ $videodetail->users_video_visibility_redirect_url }}">
                                    <div class="playbtn" style="gap:5px">
                                        {!! $play_btn_svg !!}
                                        <span class="text pr-2 text-white"> {{ __( $videodetail->users_video_visibility_status_button ) }} </span>
                                    </div>
                                </a>
                            @elseif(Enable_PPV_Plans() == 0 && $videodetail->access == 'ppv')
                                <a class="btn play_button" data-toggle="modal" data-target="#video-purchase-now-modal">
                                    <div class="playbtn" style="gap:5px">
                                        {!! $play_btn_svg !!}
                                        <span class="text pr-2 text-white"> {{ __( !empty($button_text->purchase_text) ? $button_text->purchase_text : 'Purchase Now' ) }} </span>
                                    </div>
                                </a>
                            @else
                                <a class="btn play_button" href="{{ $videodetail->users_video_visibility_redirect_url }}">
                                    <div class="playbtn" style="gap:5px">
                                        {!! $play_btn_svg !!}
                                        <span class="text pr-2 text-white"> {{ __( $videodetail->users_video_visibility_status_button ) }} </span>
                                    </div>
                                </a>
                            @endif
                            
                            @if ( Enable_PPV_Plans() == 1 && !is_null($videodetail->ppv_price_480p) &&  $videodetail->users_video_visibility_status == true || Enable_PPV_Plans() == 1 && !is_null($videodetail->ppv_price_720p) &&  $videodetail->users_video_visibility_status == true  || Enable_PPV_Plans() == 1 && !is_null($videodetail->ppv_price_1080p) &&  $videodetail->users_video_visibility_status == true )
                                @if ( !is_null($videodetail->PPV_Access) && $videodetail->PPV_Access != '1080p')
                                    <a class="btn play_button" data-toggle="modal" data-target="#video-purchase-now-modal">
                                        <div class="playbtn" style="gap:5px">
                                            {!! $play_btn_svg !!}
                                            <span class="text pr-2 text-white"> {{ __( 'Upgrade Now' ) }} </span>
                                        </div>
                                    </a>
                                @endif
                            @endif
                            
                        @endif

                        <div class="mob_res_hide">
                            @php include public_path("themes/{$current_theme}/views/partials/social-share.php"); @endphp 
                        </div>
                       
                        @if( optional($videodetail)->trailer )

                            <ul class="list-inline p-0 m-0 share-icons music-play-lists">
                                <li class="share sharemobres">
                                    <span  data-bs-toggle="modal" data-bs-target="#trailermodal">   {{-- Trailer --}}
                                        <i class="fa fa-play"></i>
                                    </span>

                                    <div class="share-box box-watchtrailer">
                                        <div class="playbtn"  data-bs-toggle="modal" data-bs-target="#trailermodal">     {{-- Trailer --}}
                                            <span class="text" style="background-color: transparent; font-size: 14px; width:84px">{{ __('Watch Trailer') }}</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>

                            @php include public_path("themes/{$current_theme}/views/video-js-Player/video/videos-trailer.blade.php"); @endphp   

                        @endif
                        
                        <div class="mob_res_hide">
                            <div class="circleRating">  {{-- Rating --}}
                                <svg class="CircularProgressbar " viewBox="0 0 100 100" data-test-id="CircularProgressbar" >
                                    <path class="CircularProgressbar-trail" d="M 50,50m 0,-46a 46,46 0 1 1 0,92a 46,46 0 1 1 0,-92" stroke-width="8" fill-opacity="0" style="stroke-dasharray: 289.027px, 289.027px; stroke-dashoffset: 0px;"></path>
                                    <path class="CircularProgressbar-path" d="M 50,50m 0,-46a 46,46 0 1 1 0,92a 46,46 0 1 1 0,-92" stroke-width="8" fill-opacity="0" style="stroke: orange; stroke-dasharray: 289.027px, 289.027px; stroke-dashoffset: 101.159px;"></path>
                                    <text class="CircularProgressbar-text" style="font-size:35px" x="50" y="50"> {{ optional($videodetail)->rating }}  </text>
                                </svg>
                            </div>
                        </div>
                    </div>

                    @if( $setting->show_description == 1 && optional($videodetail)->description )   {{-- Description --}}
                        <div class="overview mt-3">
                            <div class="heading">{{ __('Description') }}</div>
                            <div class="description">
                                {!!  html_entity_decode( optional($videodetail)->description ) !!}
                            </div>
                        </div>
                    @endif

                    <div class="info">       {{-- publish_status --}}
                        <div class="infoItem">
                            <span classname="text bold">{{ __('Status') }}: </span>
                            <span class="text">{{ $videodetail->video_publish_status }}</span>
                        </div>
                    </div>


                    @if ( $setting->show_languages == 1 &&  !$videodetail->Language->isEmpty())   {{-- Languages --}}
                        <div class="info">      
                            <span classname="text bold"> {{ __('Languages') }}:&nbsp;</span> 
                            @foreach( $videodetail->Language as $item )
                                <span class="text">
                                    <span><a href="{{ URL::to('language/'. $item->language_id . '/' . $item->name ) }} "> {{ $item->name }} </a>   </span>
                                </span>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>
    
            @if ($setting->show_artist == 1 && !$videodetail->artists->isEmpty() ) {{-- Artists --}}
                <div class="sectionArtists">   
                    <h6 class="artistHeading">{{ __('Top Cast') }}</h6>
                    <div class="listItems">
                        @foreach ( $videodetail->artists as $item )
                            <a href="{{ route('artist',[ $item->artist_slug ])}}">
                                <div class="listItem">
                                    <div class="profileImg">
                                        <span class="lazy-load-image-background blur lazy-load-image-loaded" style="color: transparent; display: inline-block;">
                                            <img  src="{{ URL::to('public/uploads/artists/'. $item->image ) }}" />
                                        </span>
                                    </div>
                                    <div class="name">{{ $item->artist_name }}</div>
                                    <div class="character">{{ str_replace('_', ' ', $item->artist_type) }}</div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Broadcast  -->

            <div class="sectionArtists broadcast">   
                <h6 class="artistHeading">
                    {{ ucwords(__('Promos & Resources')) }}
                </h6>
                        

                    <div class="listItems">

                        @if( optional($videodetail)->trailer )
                                <a>
                                    <div class="listItem" data-bs-toggle="modal" data-bs-target="#trailermodal" >
                                        <div class="profileImg trailer-img">
                                            <span class="lazy-load-image-background blur lazy-load-image-loaded position-relative" style="color: transparent; display: inline-block;">
                                                <img class="img_thum_trailer" src="{{ optional($videodetail)->image_url }}">
                                            </span>
                                            <span class="trailer-play position-absolute">
                                                <i class="fa fa-play mr-1" ></i>{{ __('Trailer') }} 
                                            </span>

                                        </div>
                                        
                                        <div class="name titleoverflow"> {{ strlen($videodetail->title) > 20 ? substr($videodetail->title, 0, 21) . '...' : $videodetail->title }}  <span class="traileroverflow"> {{ __('Trailer') }}</span></div>
                                    </div>
                                </a>
                            @endif
                            
                            <!-- Modal -->
                            <div class="modal fade" id="trailermodal" tabindex="-1" aria-labelledby="trailermodalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <button type="button" class="btn-close close video-js-trailer-modal-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            
                                            <div class="embed-responsive embed-responsive-16by9">
                                                <?php if($videodetail->trailer_type == "embed_url" ) : ?>
                                                    <iframe width="100%" height="auto"  src="{{ $videodetail->trailer }}" frameborder="0" allowfullscreen></iframe>
                                                <?php elseif($videodetail->trailer_type == "m3u8" ): ?>
                                                    <video id="video-js-trailer-player" class="vjs-theme-city my-video video-js vjs-big-play-centered vjs-fluid" poster="<?= URL::to('public/uploads/images/'.$videodetail->player_image) ?>" controls width="100%" height="auto">
                                                        <source src="<?= $videodetail->trailer ?>" type="application/x-mpegURL">
                                                    </video>
                                                <?php elseif($videodetail->trailer_type == "m3u8_url" ): ?>
                                                    <video id="video-js-trailer-player" class="vjs-theme-city my-video video-js vjs-big-play-centered vjs-fluid" poster="<?= URL::to('public/uploads/images/'.$videodetail->player_image) ?>" controls width="100%" height="auto">
                                                        <source src="<?= $videodetail->trailer ?>" type="application/x-mpegURL">
                                                    </video>
                                                <?php else: ?>
                                                    <video id="video-js-trailer-player" class="vjs-theme-city my-video video-js vjs-big-play-centered vjs-fluid" poster="<?= URL::to('public/uploads/images/'.$videodetail->player_image) ?>" controls width="100%" height="auto">
                                                        <source src="<?= $videodetail->trailer ?>" type="video/mp4">
                                                    </video>                 
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @if(  $videodetail->Reels_videos->isNotEmpty() )            {{-- E-Paper --}}
                                                                
                            @php  include public_path('themes/theme4/views/video-js-Player/video/Reels-videos.blade.php'); @endphp
                        
                        @endif

                        @if( optional($videodetail)->pdf_files )            {{-- E-Paper --}}
                            <div class="listItem">
                                <div class="profileImg">
                                    <span class="lazy-load-image-background blur lazy-load-image-loaded" style="color: transparent; display: inline-block;">
                                        <a href="{{ $videodetail->pdf_files_url }}" style="font-size:93px; color: #a51212 !important;" class="fa fa-file-pdf-o " download></a>
                                    </span>
                                </div>
                                <div class="name">{{ __('Document') }}</div>
                            </div>
                        @endif
                            
                    </div>
                    
            </div>

            {{-- comment Section --}}

            @if( $CommentSection != null && $CommentSection->videos == 1 )
                <div class="sectionArtists">   
                    <h6 class="artistHeading"> {{ __('Comments') }} </h6>
                        <div class="overflow-hidden">
                            @php include public_path('themes/theme4/views/comments/index.blade.php') @endphp
                        </div>
                </div>
            @endif

                        {{-- Recommended videos Section --}}

            @if ( ( $videodetail->recommended_videos)->isNotEmpty() ) 

                <div class=" container-fluid video-list  overflow-hidden p-0">
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title">{{ ucwords( __('recommended videos')) }}</h4> 
                    </div>

                    <div class="channels-list">
                        <div class="channel-row">
                            <div id="trending-slider-nav" class="video-list latest-video">
                                @foreach ($videodetail->recommended_videos as $key => $recommended_video)
                                    <div class="item" data-index="{{ $key }}">
                                        <div>
                                            <img src="{{ URL::to('/public/uploads/images/' . $recommended_video->image) }}" class="w-100">
                                            <div class="controls">
                                                <a href="{{ URL::to('category/videos/' . $recommended_video->slug) }}">
                                                    <button class="playBTN"> <i class="fas fa-play"></i></button>
                                                </a>

                                                <!-- <nav>
                                                    <button class="moreBTN" tabindex="0" data-bs-toggle="modal" data-bs-target= <?= "#Recommend_series-episode-videos-Modal-".$key ?> ><i class="fas fa-info-circle"></i><span>More info</span></button>
                                                </nav> -->

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            @endif

        </div>

        <div class="videoPopup ">
            <div class="opacityLayer"></div>
            <div class="videoPlayer">
                <span class="closeBtn">{{ __('Close') }}</span>
                <div style="width: 100%; height: 100%;">
                    <!-- Placeholder for video player -->
                </div>
            </div>
        </div>
    </div>

        {{-- Rent Modal  --}}                
        <div class="modal fade" id="video-purchase-now-modal" tabindex="-1" role="dialog" aria-labelledby="video-purchase-now-modal-Title" aria-hidden="true">
            <div id="purchase-modal-dialog" class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content container-fluid bg-dark">

                    <div class="modal-header align-items-center">
                        <div class="row">
                            <div class="col-12">
                                <?php if($theme_mode == "light" && !empty($theme->light_mode_logo)){ ?>
                                    <img src="<?= URL::to('/public/uploads/settings/'. $theme->light_mode_logo) ?>" class="c-logo" alt="<?= $settings->website_name ?>">
                                 <?php } elseif($theme_mode != "light" && !empty($theme->dark_mode_logo)){ ?>
                                    <img src="<?= URL::to('/public/uploads/settings/'. $theme->dark_mode_logo) ?>" class="c-logo" alt="<?= $settings->website_name ?>">
                                 <?php } else { ?>
                                    <img src="<?= URL::to('/public/uploads/settings/'. $settings->logo) ?>" class="c-logo" alt="<?= $settings->website_name ?>">
                                 <?php } ?>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-end">
                            @if(Auth::check() && (Auth::user()->role == 'registered' || Auth::user()->role == 'subscriber' || Auth::user()->role == 'admin'))
                                <img src="{{ $user_avatar }}" alt="{{ $user_name }}">
                                <h5 class="pl-4">{{ $user_name }}</h5>
                            @endif
                            
                        </div>
                    </div>

                    <div class="modal-body">
                        <div class="row justify-content-between m-0">
                            <h3 class="font-weight-bold">{{ $videodetail->title}}</h3>
                            <button type="button" class="close-btn" data-dismiss="modal" aria-label="Close">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </button>
                        </div>
                        <p class="text-white">{{ 'You are currently on plan.' }}</p>
                        <div class="row justify-content-between m-0" style="gap: 4rem;">
                            <div class="col-sm-4 col-12 p-0" style="">
                                <img class="img__img w-100" src="{{ $videodetail->player_image_url }}" class="img-fluid" alt="{{ $videodetail->title }}" style="border-radius: 10px;">
                            </div>

                            <div class="col-sm-7 col-12 details">

                                <div class="movie-rent btn">

                                    <div class="">
                                        <h3 class="font-weight-bold title-popup">{{ $videodetail->title }}</h3>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div class="col-8 d-flex justify-content-start p-0">
                                            <span class="descript text-white">{{ $setting->video }}</span>
                                        </div>
                                        <div class="col-4">
                                            @if (Enable_PPV_Plans() == 0)
                                                <h3 class="pl-2" style="font-weight:700;" id="price-display">{{ $currency->enable_multi_currency == 1 ? Currency_Convert($videodetail->ppv_price) :  "{$currency->symbol} {$videodetail->ppv_price}" }}</h3>
                                            @elseif( Enable_PPV_Plans() == 1 )
                                                <h3 class="pl-2" style="font-weight:700;" id="price-display"> {{ $currency->enable_multi_currency == 1 ? Currency_Convert($videodetail->ppv_price_480p) :  $currency->symbol .$videodetail->ppv_price_480p }}</h3>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-0 mt-3 p-0 text-left">
                                        <h5 style="font-size:17px;line-height: 23px;" class="text-white mb-2"> {{ __('Select payment method') }} : </h5>
                                    </div>

                                    <!-- Stripe Button -->
                                    @if ($stripe_payment_setting && $stripe_payment_setting->payment_type == 'Stripe' && Enable_PPV_Plans() == 0)
                                        <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center text-white">
                                            <input type="radio" class="payment_btn" id="tres_important"  name="payment_method" value="{{ $stripe_payment_setting->payment_type }}" data-value="stripe">
                                            {{ $stripe_payment_setting->payment_type }}
                                        </label>
                                    @elseif( $stripe_payment_setting && $stripe_payment_setting->payment_type == 'Stripe' && Enable_PPV_Plans() == 1 )
                                        <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center text-white">
                                            <input type="radio" class="payment_btn" id="tres_important"  name="payment_method" value="{{ $stripe_payment_setting->payment_type }}" data-value="stripe">
                                            {{ $stripe_payment_setting->payment_type }}
                                        </label>

                                        <div id="quality-options" style="display:none;">
                                            <label class="main-label text-left text-white mt-4">{{ __('Choose Video Quality') }}</label>
                                            <div class="quality-options-group">
                                                <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center text-white">
                                                    <input type="radio" class="quality_option" name="quality" value="480p" checked>
                                                    Low Quality
                                                </label>
                                                <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center text-white">
                                                    <input type="radio" class="quality_option" name="quality" value="720p">
                                                    Medium Quality
                                                </label>
                                                <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center text-white">
                                                    <input type="radio" class="quality_option" name="quality" value="1080p">
                                                    High Quality
                                                </label>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Razorpay Button -->
        
                                    @if ($Razorpay_payment_setting && $Razorpay_payment_setting->payment_type == 'Razorpay' && Enable_PPV_Plans() == 0)
                                        <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center text-white">
                                            <input type="radio" class="payment_btn" id="important" name="payment_method" value="{{ $Razorpay_payment_setting->payment_type }}" data-value="Razorpay">
                                            {{ $Razorpay_payment_setting->payment_type }}
                                        </label>
                                    @elseif( $Razorpay_payment_setting && $Razorpay_payment_setting->payment_type == 'Razorpay' && Enable_PPV_Plans() == 1 )
                                        <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center text-white">
                                            <input type="radio" class="payment_btn" id="important" name="payment_method" value="{{ $Razorpay_payment_setting->payment_type }}" data-value="Razorpay">
                                            {{ $Razorpay_payment_setting->payment_type }}
                                        </label>

                                        <div id="razorpay-quality-options" style="display:none;">
                                            <label class="main-label text-left text-white mt-4">{{ __('Choose Video Quality') }}</label>
                                            <div class="quality-options-group">
                                                <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center text-white">
                                                    <input type="radio" class="quality_option" name="quality" value="480p" checked>
                                                    Low Quality
                                                </label>
                                                <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center text-white">
                                                    <input type="radio" class="quality_option" name="quality" value="720p">
                                                    Medium Quality
                                                </label>
                                                <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center text-white">
                                                    <input type="radio" class="quality_option" name="quality" value="1080p">
                                                    High Quality
                                                </label>
                                            </div>
                                        </div>
                                    @endif
                                  
                                    <!-- paypal payment -->
                                    @if (!empty($paypal_payment_setting) && $paypal_payment_setting->payment_type == 'PayPal' && Enable_PPV_Plans() == 0)
                                        <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center text-white">
                                            <input type="radio" class="payment_btn" id="paypal_pay" name="payment_method" value="{{ $paypal_payment_setting->payment_type }}" data-video-id="{{$videodetail->id}}" data-video-ppv="{{$videodetail->ppv_price}}" data-value="PayPal">
                                            {{ $paypal_payment_setting->payment_type }}
                                        </label>
                                    @elseif( $paypal_payment_setting && $paypal_payment_setting->payment_type == 'PayPal' && Enable_PPV_Plans() == 1 )
                                        <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center text-white">
                                            <input type="radio" class="payment_btn" id="paypal_pay" name="payment_method" value="{{ $paypal_payment_setting->payment_type }}" data-value="PayPal">
                                            {{ $paypal_payment_setting->payment_type }}
                                        </label>

                                        <div id="paypal-quality-options" style="display:none;">
                                            <label class="main-label text-left text-white mt-4">{{ __('Choose Video Quality') }}</label>
                                            <div class="quality-options-group">
                                                <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center text-white">
                                                    <input type="radio" class="quality_option" name="quality" value="480p" checked>
                                                    Low Quality
                                                </label>
                                                <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center text-white">
                                                    <input type="radio" class="quality_option" name="quality" value="720p">
                                                    Medium Quality
                                                </label>
                                                <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center text-white">
                                                    <input type="radio" class="quality_option" name="quality" value="1080p">
                                                    High Quality
                                                </label>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class=" becomesubs-page">
                                    @if ( Enable_PPV_Plans() == 0 && ( $videodetail->access == "ppv" && !is_null($videodetail->ppv_price) ) || $videodetail->access == "subscriber" && !is_null($videodetail->ppv_price)   )
                                        <div class="Stripe_button row mt-3 justify-content-around">  
                                            <div class="Stripe_button col-md-6 col-6 btn"> <!-- Stripe Button -->
                                                <button class="btn btn-primary w-100"
                                                    onclick="location.href ='{{  $currency->enable_multi_currency == 1 ? route('Stripe_payment_video_PPV_Purchase',[ $videodetail->id,PPV_CurrencyConvert($videodetail->ppv_price) ]) : route('Stripe_payment_video_PPV_Purchase',[ $videodetail->id, $videodetail->ppv_price ]) }}' ;">
                                                    {{ __('Pay now') }}
                                                </button>
                                            </div>
                                            <div class="Stripe_button col-md-5 col-5 btn">
                                                <button type="button" class="btn btn-primary w-100" data-dismiss="modal" aria-label="Close">
                                                    {{'Cancel'}}
                                                </button>
                                            </div>
                                        </div>

                                    @elseif( $videodetail->access == "ppv" && !is_null($videodetail->ppv_price_480p) && !is_null($videodetail->ppv_price_720p) && !is_null($videodetail->ppv_price_1080p) && Enable_PPV_Plans() == 1 )

                                        <div class="Stripe_button"> <!-- Stripe Button -->
                                    
                                        </div>

                                    @endif

                                    @if ( $videodetail->access == "ppv" && !is_null($videodetail->ppv_price) && Enable_PPV_Plans() == 0)
                                        <div class="row mt-3 justify-content-around"> 
                                            <div class="Razorpay_button col-md-6 col-6 btn"> <!-- Razorpay Button -->
                                                @if ($Razorpay_payment_setting && $Razorpay_payment_setting->payment_type == 'Razorpay')
                                                    <button class="btn btn-primary w-100"
                                                        onclick="location.href ='{{ route('RazorpayVideoRent', [$videodetail->id, $videodetail->ppv_price]) }}' ;">
                                                        {{ __('Pay now') }}
                                                    </button>
                                                @endif
                                            </div>
                                            <div class="Razorpay_button col-md-5 col-5 btn">
                                                <button type="button" class="btn btn-primary w-100" data-dismiss="modal" aria-label="Close">
                                                    {{'Cancel'}}
                                                </button>
                                            </div>
                                        </div>
                                    @elseif( $videodetail->access == "ppv" && !is_null($videodetail->ppv_price_480p) && !is_null($videodetail->ppv_price_720p) && !is_null($videodetail->ppv_price_1080p) && Enable_PPV_Plans() == 1 )

                                        <div class="row mt-3 justify-content-around"></div>
                                            <div class="Razorpay_button"> <!-- Razorpay Button -->

                                        </div>

                                    @endif

                                    @if ( $videodetail->access == "ppv" && !is_null($videodetail->ppv_price) && Enable_PPV_Plans() == 0)
                                        <div class="row mt-3 justify-content-around"> 
                                            <div class="paypal_button col-12"> <!-- paypal Button -->
                                                @if ($paypal_payment_setting && $paypal_payment_setting->payment_type == 'PayPal')
                                                    <div class="row mt-3 justify-content-around" id="paypal_pay_now"> 
                                                        <div class="col-md-6 col-6 btn">
                                                            <button class="btn btn-primary w-100"
                                                                onclick="paypal_checkout()">
                                                                {{ __('Pay now') }}
                                                            </button>
                                                        </div>
                                                        <div class="col-md-5 col-5 btn w-100">
                                                            <button type="button" class="btn btn-primary w-100" data-dismiss="modal" aria-label="Close">
                                                                {{'Cancel'}}
                                                            </button>
                                                        </div>
                                                    </div>

                                                        <div class="payment_card_payment">
                                                            <div id="paypal-button-container"></div>
                                                        </div>
                                                        
                                                     <!-- <button onclick="paypal_checkout()" class="btn2 btn-outline-primary"><?php echo __('Continue'); ?></button> -->
                                                    <!-- <div id="paypal-button-container-{{$videodetail->id}}-{{$videodetail->ppv_price}}"></div> -->
                                                @endif
                                            </div>
                                        </div>
                                    @elseif( $videodetail->access == "ppv" && !is_null($videodetail->ppv_price_480p) && !is_null($videodetail->ppv_price_720p) && !is_null($videodetail->ppv_price_1080p) && Enable_PPV_Plans() == 1 )

                                        <div class="row mt-3 justify-content-around"></div>
                                            <div class="paypal_button"> <!-- paypal Button -->

                                        </div>

                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


<style>
     body.light-theme .vpageBanner .content .right .utilities {color: <?php echo $GetLightText; ?>;}
     body.light-theme .add-a-comment {color: <?php echo $GetLightText; ?>;}
     body.light-theme .infoItem span {color: <?php echo $GetLightText; ?>;opacity:1 !important;}
     body.light-theme .info span {color: <?php echo $GetLightText; ?>;opacity:1 !important;}
     body.light-theme ul.breadcrumb.p-0 a, body.light-theme ul.breadcrumb.p-0 li{color: <?php echo $GetLightText; ?>;}
</style>

<script>

    function paypal_checkout() {
        $('#paypal_pay_now').hide();

        const amount = '{{ $videodetail->ppv_price }}';
        let element = document.querySelector('.paypal-button[aria-label="Debit or Credit Card"]');
        console.log("element",element);

        paypal.Buttons({
            createOrder: function (data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: amount,
                            // currency_code: 'USD'
                        }
                    }]
                });
            },
            onApprove: function (data, actions) {
                return actions.order.capture().then(function (details) {
                    // console.log(details);
                    const paymentId = details.id;
                    $.ajax({
                        url: '{{ URL::to('paypal-ppv-video') }}',
                        method: 'post',
                        data: {
                            _token: '<?= csrf_token() ?>',
                            amount: amount,
                            video_id: '<?= @$videodetail->id ?>',
                            paymentId: paymentId,
                        },
                        success: (response) => {
                            console.log("Server response:", response);
                            setTimeout(function() {
                                location.reload();
                            }, 2000);


                        },
                        error: (error) => {
                            swal('error');
                        }
                    });

                });
                
            },
            onError: function (err) {
                console.error(err);
            }
        }).render('#paypal-button-container');
        console.log("pb",paypal.Buttons());
        
    }

    $(document).ready(function() {
        $('.open-modal-btn').click(function() {
            var title = $(this).data('title');
            var message = $(this).data('message');
            console.log(title);
            console.log(message);
            $('#modalTitle').text(title);
            $('#modalMessage').text(message);
        });
    });

    $(document).ready(function() {
        
        var Enable_PPV_Plans = '{{ Enable_PPV_Plans() }}';

        $('.Razorpay_button,.Stripe_button,.paypal_button').hide();

        if (Enable_PPV_Plans == 1) {
                // Only execute this block if PPV plans are enabled
                var ppv_price_480p = '{{ $videodetail->ppv_price_480p }}';

                $(".payment_btn").click(function() {
                    $('.Razorpay_button, .Stripe_button, .paypal_button, #quality-options, #razorpay-quality-options, #paypal-quality-options').hide();

                    let payment_gateway = $('input[name="payment_method"]:checked').val();
                    if (payment_gateway == "Stripe") {
                        $('#quality-options').show();
                        $('#razorpay-quality-options').hide();
                        $('#paypal-quality-options').hide();
                        updateContinueButton();
                    } else if (payment_gateway == "Razorpay") {
                        $('#razorpay-quality-options').show();
                        $('#quality-options').hide();
                        $('#paypal-quality-options').hide();
                        updateContinueButton();
                    } else if (payment_gateway == "PayPal") {
                        $('#razorpay-quality-options').hide();
                        $('#quality-options').hide();
                        $('#paypal-quality-options').show();
                        updateContinueButton();
                    }
                });

                $("input[name='quality']").change(function() {
                    updateContinueButton();
                });

                function updateContinueButton() {
                    let payment_gateway = $('input[name="payment_method"]:checked').val();

                    const selectedQuality = $('input[name="quality"]:checked').val() || '480p';
                    const ppv_price = selectedQuality === '480p' ? '{{ $videodetail->ppv_price_480p }}' :
                                        selectedQuality === '720p' ? '{{ $videodetail->ppv_price_720p }}' :
                                        '{{ $videodetail->ppv_price_1080p }}';

                    $('#price-display').text('{{ $currency->symbol }}' + ' ' + ppv_price);

                    const videoId = '{{ $videodetail->id }}';
                    const isMultiCurrencyEnabled = {{ $currency->enable_multi_currency }};
                    const amount = isMultiCurrencyEnabled ? PPV_CurrencyConvert(ppv_price) : ppv_price;

                    if(payment_gateway == "Stripe"){

                        const routeUrl = `{{ route('Stripe_payment_video_PPV_Plan_Purchase', ['ppv_plan' => '__PPV_PLAN__','video_id' => '__VIDEO_ID__', 'amount' => '__AMOUNT__']) }}`
                        .replace('__PPV_PLAN__', selectedQuality)
                        .replace('__VIDEO_ID__', videoId)
                        .replace('__AMOUNT__', amount);

                        const continueButtonHtml = `
                            <button class="btn btn-primary col-12 ppv_price_${selectedQuality}"
                                onclick="location.href ='${routeUrl}';">
                                {{ __('Continue') }}
                            </button>
                        `;

                        $('.Stripe_button').html(continueButtonHtml).show();

                    }else if(payment_gateway == "Razorpay"){

                        const routeUrl = `{{ route('RazorpayVideoRent_PPV', ['ppv_plan' => '__PPV_PLAN__','video_id' => '__VIDEO_ID__', 'amount' => '__AMOUNT__']) }}`
                        .replace('__PPV_PLAN__', selectedQuality)
                        .replace('__VIDEO_ID__', videoId)
                        .replace('__AMOUNT__', amount);

                        const continueButtonHtml = `
                            <button class="btn btn-primary col-12 ppv_price_${selectedQuality}"
                                onclick="location.href ='${routeUrl}';">
                                {{ __('Continue') }}
                            </button>
                        `;

                        $('.Razorpay_button').html(continueButtonHtml).show();

                    }

                }

                $(".payment_btn:checked").trigger('click');
            }
            else{
            $(".payment_btn").click(function() {

                var Video_id = $(this).attr('data-video-id');
                var Video_ppv_price = $(this).attr('data-video-ppv');
                
                // You can now use Video_id and Video_ppv_price
                console.log("Video ID: " + Video_id);
                console.log("Video PPV Price: " + Video_ppv_price);
                $('.Razorpay_button,.Stripe_button').hide();
                

                let payment_gateway = $('input[name="payment_method"]:checked').val();

                if (payment_gateway == "Stripe") {

                    $('.Stripe_button').show();
                    $('.paypal_button').hide();

                } else if (payment_gateway == "Razorpay") {

                    $('.Razorpay_button').show();
                    $('.paypal_button').hide();

                } else if (payment_gateway == "PayPal") {

                    $('.paypal_button').show();
                    // paypal.Buttons({
                    //     style: {
                    //         shape: 'rect',
                    //         color: 'gold',
                    //         layout: 'vertical',
                    //         label: 'subscribe'
                    //     },
                    //     createSubscription: function(data, actions) {
                    //         return actions.subscription.create({
                    //         /* Creates the subscription */
                    //         plan_id: 'P-5H799559D92641634M3UTMXQ'
                    //         });
                    //     },
                    //     onApprove: function(data, actions) {
                    //         alert(data.subscriptionID); // You can add optional success message for the subscriber here
                    //     }
                    // }).render('#paypal-button-container-' + Video_id + '-' + Video_ppv_price);
                    // console.log('#paypal-button-container-' + Video_id + '-' + Video_ppv_price);

                } 
                
                
            });
        }

    });


    // guest qualtiy selection
    $(document).ready(function(){

        $('#guest-qualitys-selct').on('click', function(){
            console.log('yes true');
            $('#guest-qualitys').show();
            $('#guest-qualitys-selct').hide();
        })
    })

</script>

<script>
    $(document).ready(function() {
        
        var Url_type = '<?php echo @$videodetail->trailer_type ; ?>';
        var originalSrc = '<?php echo @$videodetail->trailer ; ?>';

        if(Url_type === 'embed_url'){
            console.log('Url_type ' + Url_type);
            var iframeplayer = videojs('video-js-trailer-player_embed');
            $('#trailermodal').on('hidden.bs.modal', function () {
                console.log('modal close');
                $('#video-js-trailer-player_embed_html5_api').attr('src', '');
            });

            $('#trailermodal').on('shown.bs.modal', function () {
                console.log('modal open');
                $('#video-js-trailer-player_embed_html5_api').attr('src', originalSrc);
            });
            $(".video-js-trailer-modal-close").click(function() {
                console.log('close btn');
                $('#trailermodal').modal('hide');
            });
        }else{
            var player = videojs('video-js-trailer-player', {
                aspectRatio: '16:9',
                fluid: true,
                controlBar: {
                    volumePanel: { inline: false },
                    children: {
                        'playToggle': {},
                        'liveDisplay': {},
                        'flexibleWidthSpacer': {},
                        'progressControl': {},
                        'remainingTimeDisplay': {},
                        'fullscreenToggle': {}, 
                    }
                }
            });

            player.on('mouseout', function() {
                // console.log("hover out..");
                $('.vjs-big-play-button').hide();
                $('.vjs-control-bar').attr('style', 'display: none !important;');
            });

            // Show controls when mouse enters
            player.on('mouseover', function() {
                // console.log("hovering..");
                $('.vjs-big-play-button').show();
                $('.vjs-control-bar').show();
            });

            // Close button functionality
            $(".btn-close").click(function() {
                player.pause();
                $('#trailermodal').modal('hide');
            });
        }
    });

    var elem = document.querySelector('.latest-video');
    var flkty = new Flickity(elem, {
        cellAlign: 'left',
        contain: true,
        groupCells: true,
        pageDots: false,
        draggable: true,
        freeScroll: true,
        imagesLoaded: true,
        lazyload:true,
    });
    
</script>
@php 
    include public_path('themes/theme4/views/video-js-Player/video/videos-details-script-file.blade.php');
    include public_path('themes/theme4/views/video-js-Player/video/videos-details-script-stripe.blade.php');
    include public_path('themes/theme4/views/footer.blade.php'); 
@endphp
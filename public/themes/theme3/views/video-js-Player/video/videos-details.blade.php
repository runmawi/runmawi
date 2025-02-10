@php 
     include public_path('themes/theme3/views/header.php'); 
@endphp

{{-- Style Link--}}
    <link rel="stylesheet" href="{{ asset('public/themes/theme3/assets/css/video-js/video-details.css') }}">


    {{-- video-js Style --}}

    <link href="https://cdnjs.cloudflare.com/ajax/libs/videojs-ima/1.11.0/videojs.ima.css" rel="stylesheet">
    <link href="{{ asset('public/themes/theme3/assets/css/video-js/videojs.min.css') }}" rel="stylesheet" >
    <!-- <link href="https://unpkg.com/@videojs/themes@1/dist/fantasy/index.css" rel="stylesheet"> -->
    <link href="https://cdn.jsdelivr.net/npm/videojs-hls-quality-selector@1.1.4/dist/videojs-hls-quality-selector.min.css" rel="stylesheet">
    <link href="{{ URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.css') }}" rel="stylesheet" >
    <link href="{{ asset('public/themes/theme3/assets/css/video-js/videos-player.css') }}" rel="stylesheet" >
    <link href="{{ asset('public/themes/theme3/assets/css/video-js/video-end-card.css') }}" rel="stylesheet" >
    <link href="{{ URL::to('node_modules\@filmgardi\videojs-skip-button\dist\videojs-skip-button.css') }}" rel="stylesheet" >

{{-- video-js Script --}}

    <script src="//imasdk.googleapis.com/js/sdkloader/ima3.js"></script>
    <script src="{{ asset('public/themes/theme3/assets/js/video-js/video.min.js') }}"></script>
    <script src="{{ asset('public/themes/theme3/assets/js/video-js/videojs-contrib-quality-levels.js') }}"></script>
    <script src="{{ asset('public/themes/theme3/assets/js/video-js/videojs-http-source-selector.js') }}"></script>
    <script src="{{ asset('public/themes/theme3/assets/js/video-js/videojs.ads.min.js') }}"></script>
    <script src="{{ asset('public/themes/theme3/assets/js/video-js/videojs.ima.min.js') }}"></script>
    <script src="{{ asset('public/themes/theme3/assets/js/video-js/videojs-hls-quality-selector.min.js') }}"></script>
    <script src="{{ URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.js') }}"></script>
    <script src="{{ asset('public/themes/theme3/assets/js/video-js/end-card.js') }}"></script>
    <script src="{{ URL::to('node_modules/@filmgardi/videojs-skip-button/dist/videojs-skip-button.min.js') }}"></script>


    <style>
        #my-video_ima-ad-container div{ overflow:hidden;}
        #my-video{ position:relative; }
        /* .staticback-btn{display:none;} */
        .staticback-btn{ display: inline-block; position: absolute; background: transparent; z-index: 1;  top: 5%; left:1%; color: white; border: none; cursor: pointer;font-size: 25px; }
        .vpageSection .backdrop-img {
            height: calc(100vh - 148px);
            overflow: hidden;
        }
        .col-lg-6.col-sm-6.col-12.vpageContent {
            padding: 2rem 0 0;
        }
        .desc {
            font-size: 16px;
            line-height: 30px;
            overflow-y: scroll;
            scrollbar-width: none;
            max-height: 230px;
        }
        a.btn.play-btn {
            border-radius: 35px !important;
            padding: 6px 27px;
            font-weight: bold;
            align-items: center;
            display: flex;
        }
        .btn.focus, .btn:focus{
            box-shadow:none;
        }
        a:hover {
            color: #fff;
        }
        a.btn.play-btn.pl-inf {
            background: transparent !important;
            border: 1px solid #fff !important;
        }
        a.btn.play-btn.pl-inf:hover{
            background-color: #d30abe !important;
            border: 1px solid #d30abe !important;
        }
        .text-white{
            color:#fff !important;
        }
        .favorites-slider .slick-next{right: 10px;}
        .favorites-slider .slick-prev{left: 10px;}
        .breadcrumb-item a{font-size: 14px;}
        .text-white.mb-3.title{font-size: 2.052em}
        @media (max-width:660px){
            .desc{
                font-size: 15px;
                line-height: 27px;
            }
        }
        @media (max-width:470px){
            .desc{
                font-size: 14px;
                line-height: 25px;
            }
        }
        @media (max-width:320px){
            .desc{
                font-size: 13px;
                line-height: 23px;
            }
            a.btn.play-btn{
                padding: 6px 17px;
            }
        }

    </style>


{{-- Message Note --}}

<div id="message-note" ></div>

{{-- Section content --}}




    <div class="container-fluid p-0" style="position: relative;">
        @if ( $videodetail->type == "embed" )
            <iframe class="responsive-iframe" src="<?= $videodetail->videos_url ?>" poster="<?= $videodetail->player_image_url ?>"
                frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen>
            </iframe>
        @else

            <button class="staticback-btn" onclick="history.back()" title="Back Button">
                <i class="fa fa-chevron-left" aria-hidden="true"></i>
            </button>

            <button class="custom-skip-forward-button">
                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg" style="font-size: 38px;"><path fill="none" stroke-width="2" d="M20.8888889,7.55555556 C19.3304485,4.26701301 15.9299689,2 12,2 C6.4771525,2 2,6.4771525 2,12 C2,17.5228475 6.4771525,22 12,22 L12,22 C17.5228475,22 22,17.5228475 22,12 M22,4 L22,8 L18,8 M9,16 L9,9 L7,9.53333333 M17,12 C17,10 15.9999999,8.5 14.5,8.5 C13.0000001,8.5 12,10 12,12 C12,14 13,15.5000001 14.5,15.5 C16,15.4999999 17,14 17,12 Z M14.5,8.5 C16.9253741,8.5 17,11 17,12 C17,13 17,15.5 14.5,15.5 C12,15.5 12,13 12,12 C12,11 12.059,8.5 14.5,8.5 Z"></path></svg>
            </button>  

            <button class="custom-skip-backward-button">
                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg" style="font-size: 38px;"><path fill="none" stroke-width="2" d="M3.11111111,7.55555556 C4.66955145,4.26701301 8.0700311,2 12,2 C17.5228475,2 22,6.4771525 22,12 C22,17.5228475 17.5228475,22 12,22 L12,22 C6.4771525,22 2,17.5228475 2,12 M2,4 L2,8 L6,8 M9,16 L9,9 L7,9.53333333 M17,12 C17,10 15.9999999,8.5 14.5,8.5 C13.0000001,8.5 12,10 12,12 C12,14 13,15.5000001 14.5,15.5 C16,15.4999999 17,14 17,12 Z M14.5,8.5 C16.9253741,8.5 17,11 17,12 C17,13 17,15.5 14.5,15.5 C12,15.5 12,13 12,12 C12,11 12.059,8.5 14.5,8.5 Z"></path></svg>
            </button> 

            <video id="my-video" class="vjs-theme-city my-video video-js vjs-big-play-centered vjs-play-control customVideoPlayer vjs-fluid vjs_video_1462 vjs-controls-enabled vjs-picture-in-picture-control vjs-workinghover vjs-v7 vjs-quality-selector vjs-has-started vjs-paused vjs-layout-x-large vjs-user-inactive" controls 
                    width="auto" height="auto" poster="{{ $videodetail->player_image_url }}" playsinline="playsinline"
                    autoplay>
                <source src="{{ $videodetail->videos_url }}" type="{{ $videodetail->video_player_type }}">
            </video>
        @endif
    </div>



    <section class="contents-section">

     

        <div class="container-fluid g-border">
            <div class="row align-items-center">
                <div class="col-sm-12 col-md-12 col-xs-12">


                    
                    <h1 class="text-white mb-3 mt-3 title">{{ \Illuminate\Support\Str::limit($videodetail->title,80) }}</h1>

                    <!-- Year, Running time, Age -->
                    <?php
                        if (!empty($video->duration)) {
                            $seconds = $video->duration;
                            $H = floor($seconds / 3600);
                            $i = ($seconds / 60) % 60;
                            $s = $seconds % 60;
                            $time = sprintf('%02dh %02dm', $H, $i);
                        } else {
                            $time = 'Not Defined';
                        }
                        //  dd($video->duration);
                    ?>

                    <?php if (!Auth::guest()) { ?>
                        <div class="row">
                            <div class="col-sm-6 col-md-6 col-xs-12">
                                <ul class="list-inline p-0 share-icons music-play-lists mt-4">
                                            <!-- Watchlater -->
                                    <li class="share">
                                        <span  data-toggle="modal"  data-video-id={{ $videodetail->id }} onclick="video_watchlater(this)" >
                                            <i class="video-watchlater {{ !is_null($videodetail->watchlater_exist) ? "fal fa-minus" : "ri-add-circle-fill "  }}"></i>
                                        </span>
                                        <div class="share-box box-watchtrailer " onclick="video_watchlater(this)" style="top:41px; z-index:9;">
                                            <div class="playbtn"  data-toggle="modal">  
                                                <span class="text" style="background-color: transparent; font-size: 14px; width:124px;">Add To Watchlist</span>
                                            </div>
                                        </div>
                                    </li>

                                            <!-- Wishlist -->
                                    <li class="share">
                                        <span data-video-id={{ $videodetail->id }} onclick="video_wishlist(this)" >
                                            <i class="video-wishlist {{ !is_null( $videodetail->wishlist_exist ) ? 'fa fa-heart' : 'fa fa-heart-o'  }}"></i>
                                        </span>
                                        <div class="share-box box-watchtrailer " onclick="video_wishlist(this)" style="top:41px; z-index:9;">
                                            <div class="playbtn"  data-toggle="modal">  
                                                <span class="text" style="background-color: transparent; font-size: 14px; width:124px;">Add To Wishlist</span>
                                            </div>
                                        </div>
                                    </li>

                                    @php include public_path('themes/theme7/views/partials/social-share.php'); @endphp  

                                    <!-- <li>
                                        <span data-video-id={{ $videodetail->id }}  onclick="video_like(this)" >
                                            <i class="video-like {{ !is_null( $videodetail->Like_exist ) ? 'ri-thumb-up-fill' : 'ri-thumb-up-line'  }}"></i>
                                        </span>
                                    </li>

                                    <li>
                                        <span data-video-id={{ $videodetail->id }}  onclick="video_dislike(this)" >
                                            <i class="video-dislike {{ !is_null( $videodetail->dislike_exist ) ? 'ri-thumb-down-fill' : 'ri-thumb-down-line'  }}"></i>
                                        </span>
                                    </li> -->
                                </ul>
                            </div>


                            <div class="col-sm-6 col-md-6 col-xs-12 p-0">
                                <ul class="list-inline p-0 mt-4 rental-lists ">
                                    <!-- Subscribe -->
                                    <li>
                                        <?php
                                        $user = Auth::user();
                                        if (($user->role != "subscriber" && $video->access != 'guest' && $user->role != "admin")) { ?>
                                            <a href="<?php echo URL::to('/becomesubscriber'); ?>"><span
                                                    class="view-count btn btn-primary subsc-video"><?php echo __('Subscribe'); ?>
                                                </span></a>
                                        <?php } ?>
                                    </li>
                                    <!-- PPV button -->
                                    <li>
                                        <?php //if ( ($ppv_exist == 0 ) && ($user->role!="subscriber" && $user->role!="admin" || ($user->role="subscriber" && $video->global_ppv == 1 ))  ) {
                                            ?>
                                        <?php if (@$ppv_exist == 0 && $video->global_ppv != null && $user->role != "admin" || @$ppv_exist == 0 && $video->ppv_price != null && $user->role != "admin") { ?>

                                            <!-- && ($video->global_ppv == 1 ) -->
                                            <button data-toggle="modal" data-target="#exampleModalCenter"
                                                class="view-count btn btn-primary rent-video">
                                                <?php echo __('Purchase Now'); ?> </button>
                                        <?php } ?>
                                    </li>
                                    <li>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    <?php } ?>


                    <!-- Trailer  -->

                    @if( optional($videodetail)->trailer )
                        <div class="col-sm-9 col-12 p-0 mt-5">
                            <div>
                                <div class="img__wrap">
                                    <img class="img__img " src="<?php echo URL::to('/') . '/public/uploads/images/' . $video->player_image; ?>" class="img-fluid" alt="" height="200" width="300">
                                    <div class="img__description_layer" data-bs-toggle="modal" data-bs-target="#trailermodal">
                                        <h6 class="text-center">{{ "Trailer" }}</h6>
                                        <div class="hover-buttons text-center" data-bs-toggle="modal" data-bs-target="#trailermodal">
                                            <span class="text-white mt-2">
                                                <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                Play Now
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="modal fade" id="trailermodal" tabindex="-1" aria-labelledby="trailermodalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <button type="button" class="btn-close close video-js-trailer-modal-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            
                                            <div class="embed-responsive embed-responsive-16by9">
                                                <?php if($videodetail->trailer_type == "embed_url" ) : ?>
                                                    <iframe width="100%" height="auto"  src="{{ $videodetail->trailer }}" frameborder="0" allowfullscreen></iframe>
                                                <?php elseif($videodetail->trailer_type == "m3u8" ): ?>
                                                    <video id="video-js-trailer" class="vjs-theme-city my-video video-js vjs-big-play-centered vjs-fluid" poster="<?= URL::to('public/uploads/images/'.$videodetail->player_image) ?>" controls width="100%" height="auto">
                                                        <source src="<?= $videodetail->trailer ?>" type="application/x-mpegURL">
                                                    </video>
                                                <?php elseif($videodetail->trailer_type == "m3u8_url" ): ?>
                                                    <video id="video-js-trailer" class="vjs-theme-city my-video video-js vjs-big-play-centered vjs-fluid" poster="<?= URL::to('public/uploads/images/'.$videodetail->player_image) ?>" controls width="100%" height="auto">
                                                        <source src="<?= $videodetail->trailer ?>" type="application/x-mpegURL">
                                                    </video>
                                                <?php else: ?>
                                                    <video id="video-js-trailer" class="vjs-theme-city my-video video-js vjs-big-play-centered vjs-fluid" poster="<?= URL::to('public/uploads/images/'.$videodetail->player_image) ?>" controls width="100%" height="auto">
                                                        <source src="<?= $videodetail->trailer ?>" type="video/mp4">
                                                    </video>                 
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Trailer End  -->

                    

                    

                </div>
                    

            </div>

        </div>


        <div class="container-fluid">
            <div class="col-md-7 col-sm-7 col-12 p-0">

                <!-- Description -->

                <div class="descrption-video-details">
                    @if (!empty($videodetail->description))
                        <h4 class="mt-3">Description</h4>
                        <p class="trending-dec w-100 mb-0 text-white mt-2 text-justify">
                        @php
                            $description = $videodetail->description;

                            if (strlen($description) > 950) {
                                $decodedDescription = htmlspecialchars_decode($description, ENT_QUOTES);
                                $shortDescription = strip_tags(substr($decodedDescription, 0, 950));
                                $shortDescrp=str_replace('&nbsp;', ' ', $shortDescription);

                                //$shortDescriptionFirst = htmlspecialchars_decode(substr($description, 0, 990), ENT_QUOTES);
                                //$shortDescription = htmlspecialchars(strip_tags($shortDescriptionFirst), ENT_QUOTES, 'UTF-8');
                                $fullDescription = htmlspecialchars_decode($description, ENT_QUOTES);
                            }
                        @endphp

                        @if (strlen($description) > 990)
                            <p id="artistDescription" style="color:#fff;">{{ strip_tags(htmlspecialchars_decode($shortDescrp)) }}... <a href="javascript:void(0);" class="text-primary" onclick="toggleDescription()">See More</a></p>
                            <div id="fullDescription" style="display:none;">{!! $fullDescription !!} <a href="javascript:void(0);" class="text-primary" onclick="toggleDescription()">See Less</a></div>
                        @else
                            <p id="artistDescription">{{ strip_tags($description) }}</p>
                        @endif

                        </p>
                    @endif
                </div>



                <div class="cate-lang-status-details">

                    @if(!empty($video->age_restrict))
                        <div class="info">      
                            <span classname="text bold"> Age:&nbsp;</span> 
                            <span class="text">
                                <span style="color:var(--iq-primary) !important;font-weight:600;">{{ $video->age_restrict }}</span>
                            </span>
                        </div>
                    @endif
                    @if(!empty($video->duration))
                        <div class="info">      
                            <span classname="text bold"> Duration:&nbsp;</span> 
                            <span class="text">
                                <span style="color:var(--iq-primary) !important;font-weight:600;">{{ $time }}</span>
                            </span>
                        </div>
                    @endif
                    @if(!empty($video->year))
                        <div class="info">      
                            <span classname="text bold"> Year:&nbsp;</span> 
                            <span class="text">
                                <span style="color:var(--iq-primary) !important;font-weight:600;">{{ $video->year }}</span>
                            </span>
                        </div>
                    @endif
                        <div class="info">      
                            <span classname="text bold"> Languages:&nbsp;</span> 
                            @if ($videodetail->Language->isNotEmpty())
                                @php
                                    $languageNames = $videodetail->Language->pluck('name')->implode(', ');
                                @endphp

                                <span class="text">
                                    <span style="color:var(--iq-primary) !important;font-weight:600;">{{ $languageNames }}</span>
                                </span>
                            @endif

                        </div>

                    @if ( $setting->show_languages == 1 &&  !$videodetail->Language->isEmpty())   {{-- Languages --}}
                        <div class="info">      
                            <span classname="text bold"> Languages:&nbsp;</span> 
                            @if ($videodetail->Language->isNotEmpty())
                                @php
                                    $languageNames = $videodetail->Language->pluck('name')->implode(', ');
                                @endphp

                                <span class="text">
                                    <span style="color:var(--iq-primary) !important;font-weight:600;">{{ $languageNames }}</span>
                                </span>
                            @endif

                        </div>
                    @endif

                    @if ($videodetail->categories->isNotEmpty())
                        <div class="info">
                            <span classname="text bold"> Categories:&nbsp;</span> 
                            @php
                                $categoryNames = $videodetail->categories->pluck('name')->implode(', ');
                            @endphp

                                    <span class="text">
                                        <span style="color:var(--iq-primary) !important;font-weight:600;">{!! $categoryNames !!}</span>
                                    </span>
                        </div>
                    @endif

                    @if ($setting->show_artist == 1 && !$videodetail->artists->isEmpty() )
                        <div class="info">
                            <span classname="text bold"> Top Cast:&nbsp;</span>
                            @php
                                $artistNames = $videodetail->artists->pluck('artist_name')->implode(', ');
                            @endphp

                            @if ($artistNames)
                                <span class="text">
                                    <span style="color:var(--iq-primary) !important;font-weight:600;">{!! $artistNames !!}</span>
                                </span>
                            @endif
                        </div>
                    @endif
                </div>


                
            </div>
        </div>



            <div class="vpageSection container-fluid">

                <!-- Broadcast  -->

                <div class="container-fluid sectionArtists broadcast">   

                        @if( optional($videodetail)->trailer_videos_url )
                            <div class="artistHeading">
                                {{ ucwords('Promos & Resources ') }}
                            </div>
                        @endif
                            
                        <div class="listItems">

                            @if( optional($videodetail)->trailer_videos_url )
                                <a>
                                    <div class="listItem" data-toggle="modal" data-target="#video-js-trailer-modal" >
                                        <div class="profileImg">
                                            <span class="lazy-load-image-background blur lazy-load-image-loaded" style="color: transparent; display: inline-block;">
                                                <img src="{{ optional($videodetail)->image_url }}">
                                            </span>

                                            @php include public_path('themes/theme6/views/video-js-Player/video/videos-trailer.blade.php'); @endphp   

                                        </div>
                                        
                                        <div class="name titleoverflow"> {{ strlen($videodetail->title) > 20 ? substr($videodetail->title, 0, 21) . '...' : $videodetail->title }}  <span class="traileroverflow"> Trailer</span></div>
                                    </div>
                                </a>
                            @endif

                            @if(  $videodetail->Reels_videos->isNotEmpty() )            {{-- E-Paper --}}
                                                                    
                                @php  include public_path('themes/theme6/views/video-js-Player/video/Reels-videos.blade.php'); @endphp
                            
                            @endif

                            @if( optional($videodetail)->pdf_files )            {{-- E-Paper --}}
                                <div class="listItem">
                                    <div class="profileImg">
                                        <span class="lazy-load-image-background blur lazy-load-image-loaded" style="color: transparent; display: inline-block;">
                                            <a href="{{ $videodetail->pdf_files_url }}" style="font-size:93px; color: #a51212 !important;" class="fa fa-file-pdf-o " download></a>
                                        </span>
                                    </div>
                                    <div class="name">Document</div>
                                </div>
                            @endif
                            
                        </div>
                        
                </div>

                {{-- comment Section --}}

                @if( $CommentSection != null && $CommentSection->videos == 1 )
                    <div class="sectionArtists container-fluid">   
                        <div class="artistHeading"> Comments </div>
                            <div class="overflow-hidden">
                                @php 
                                    include public_path('themes/theme3/views/comments/index.blade.php')
                                @endphp
                            </div>
                        </div>
                    </div>
                @endif

                <div class="rec-video col mt-5 p-0">
                    {{-- Recommended videos Section --}}

                    @if ( ( $videodetail->recommended_videos)->isNotEmpty() ) 

                        <div class="video-list overflow-hidden">

                            <h4 class="iq-main-header d-flex align-items-center justify-content-between" style="color:#fffff;">{{ ucwords('recommended videos') }}</h4> 

                            <div class="slider" data-slick='{"slidesToShow": 4, "slidesToScroll": 4, "autoplay": false}'>

                                <div class="favorites-contens">

                                    <ul class="favorites-slider list-inline  row p-0 mb-0">

                                        @foreach ( $videodetail->recommended_videos as $recommended_video)
                                        
                                            <li class="slide-item">
                                                <div class="block-images position-relative">
                                                    <!-- block-images -->
                                                    <div class="border-bg">
                                                        <div class="img-box">
                                                            <a class="playTrailer" href="{{ URL::to('category/videos/' . $recommended_video->slug) }}">
                                                                <img loading="lazy" class="img-fluid loading w-100" data-src="{{ URL::to('/public/uploads/images/' . $recommended_video->image) }}">
                                                            </a>
                                                        </div>
                                                    </div>
                                                            
                                                    <div class="block-description">
                                                        
                                                        <div class="hover-buttons">
                                                            <a class="" href="{{ URL::to('category/videos/' . $recommended_video->slug) }}">
                                                                <div class="playbtn" style="gap:5px">    {{-- Play --}}
                                                                    <span class="text pr-2"> Play </span>
                                                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="30px" height="80px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                                                                        <polygon class="triangle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="73.5,62.5 148.5,105.8 73.5,149.1 " style="stroke: white !important;"></polygon>
                                                                        <circle class="circle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" style="stroke: white !important;"></circle>
                                                                    </svg>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
</section>

<script>
    function toggleDescription() {

        var shortDesc = document.getElementById('artistDescription');
        var fullDesc = document.getElementById('fullDescription');

        if (shortDesc.style.display === 'none') {
            shortDesc.style.display = 'block';
            fullDesc.style.display = 'none';
        } else {
            shortDesc.style.display = 'none';
            fullDesc.style.display = 'block';
        }
    }
</script>

<script>
    

    $(document).ready(function() {
      
        $(".left").hide();

        $("#moreInfoBtn").click(function() {
          
            $(".left").toggle();
           
            var buttonText = $(".left").is(":visible") ? "Less information" : "More information";
            
            $("#moreInfoBtn span").text(buttonText);
        });
    });
</script>


<script>
    $(document).ready(function() {
        
        var Url_type = '<?php echo @$videodetail->trailer_type ; ?>';
        var originalSrc = '<?php echo @$videodetail->trailer ; ?>';

        if(Url_type === 'embed_url'){
            console.log('Url_type ' + Url_type);
            var iframeplayer = videojs('video-js-trailer_embed');
            $('#trailermodal').on('hidden.bs.modal', function () {
                console.log('modal close');
                $('#video-js-trailer_embed_html5_api').attr('src', '');
            });

            $('#trailermodal').on('shown.bs.modal', function () {
                console.log('modal open');
                $('#video-js-trailer_embed_html5_api').attr('src', originalSrc);
            });
            $(".video-js-trailer-modal-close").click(function() {
                console.log('close btn');
                $('#trailermodal').modal('hide');
            });
        }else{
            var player = videojs('video-js-trailer', {
                aspectRatio: '16:9',
                fluid: true,
                controlBar: {
                    volumePanel: { inline: false },
                    children: {
                        'playToggle': {},
                        'liveDisplay': {},
                        'flexibleWidthSpacer': {},
                        'progressControl': {},
                        // 'remainingTimeDisplay': {},
                        'fullscreenToggle': {}, 
                    }
                }
            });

            // Close button functionality
            $(".btn-close").click(function() {
                player.pause();
                console.log('player closed');
                $('#trailermodal').modal('hide');
            });
        }
    });

    
</script>



<style>
      body.light-theme .descrption-video-details p {color: <?php echo GetLightText(); ?>!important;}
      body.light-theme .cate-lang-status-details {color: <?php echo GetLightText(); ?>!important;}
      body.light-theme ul.breadcrumb.breadcrumb-csp.p-0 a {color: <?php echo GetLightText(); ?>!important;}
      body.dark-theme .cate-lang-status-details {color: <?php echo GetDarkText(); ?>!important;}
      body.dark-theme ul.breadcrumb.breadcrumb-csp.p-0 a {color: <?php echo GetDarkText(); ?>!important;}

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
</style>

@php 
    //include public_path('themes/theme4/views/video-js-Player/video/videos-details-script-file.blade.php');
    //include public_path('themes/theme4/views/video-js-Player/video/videos-details-script-stripe.blade.php');
    //include public_path('themes/theme3/views/footer.blade.php'); 
@endphp
@php 

    include public_path('themes/theme3/views/video-js-Player/video/videos_script_file.blade.php');
    include public_path('themes/theme3/views/video-js-Player/video/videos_ads.blade.php');
    include public_path('themes/theme3/views/video-js-Player/video/player_script.blade.php');
    include public_path('themes/theme3/views/video-js-Player/video/videos-details-script-file.blade.php');
    include public_path('themes/theme3/views/footer.blade.php'); 

@endphp
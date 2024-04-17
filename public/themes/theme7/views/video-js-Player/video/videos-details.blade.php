@php  include public_path('themes/theme7/views/header.php'); @endphp


<style>
    body.light-theme h4, body.light-theme p {
        color: <?php echo GetLightText(); ?>;
    }
    body.light-theme .vpageBanner .content .right .utilities {
        color: <?php echo GetLightText(); ?>;
    }
    body.light-theme .artistHeading {
        color: <?php echo GetLightText(); ?>;
    }
    body.light-theme ul.breadcrumb.breadcrumb-csp li, body.light-theme ul.breadcrumb.breadcrumb-csp li a{
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
    body.light-theme label.text-white {
        color: <?php echo GetLightText(); ?> !important;
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
    body.light-theme .info {
        color: <?php echo GetLightText(); ?> !important;
    }
    body.light-theme .vpageBanner .opacity-layer {
        background:none;
    }
    .share-box{
        top: 42px;
        width: 117px;
    }
</style>


{{-- Style Link--}}
    <link rel="stylesheet" href="{{ asset('public/themes/theme7/assets/css/video-js/video-details.css') }}">

{{-- video-js Style --}}

    <link href="https://cdnjs.cloudflare.com/ajax/libs/videojs-ima/1.11.0/videojs.ima.css" rel="stylesheet">
    <link href="https://unpkg.com/video.js@7/dist/video-js.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/@videojs/themes@1/dist/fantasy/index.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/videojs-hls-quality-selector@1.1.4/dist/videojs-hls-quality-selector.min.css" rel="stylesheet">
    <link href="{{ URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.css') }}" rel="stylesheet" >
    {{-- <link href="{{ asset('public/themes/theme7/assets/css/video-js/videos-player.css') }}" rel="stylesheet" > --}}

{{-- video-js Script --}}

    <script src="{{ asset('public/themes/theme7/assets/js/video-js/video.min.js') }}"></script>
    <script src="{{ asset('public/themes/theme7/assets/js/video-js/videojs-contrib-quality-levels.js') }}"></script>
    <script src="{{ asset('public/themes/theme7/assets/js/video-js/videojs-http-source-selector.js') }}"></script>
    <script src="{{ asset('public/themes/theme7/assets/js/video-js/videojs-hls-quality-selector.min.js') }}"></script>
    <script src="{{ URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.js') }}"></script>

{{-- Section content --}}

    <div class="vpageBanner">
        <div class="backdrop-img">    {{-- Background image --}}
            <span class=" lazy-load-image-background blur lazy-load-image-loaded"  style="color: transparent; display: inline-block;">
                <img src="{{ optional($videodetail)->player_image_url }}">
            </span>
        </div>

        <div class="opacity-layer"></div>

                {{-- Message Note --}}
        <div id="message-note" ></div>

        <div class="pageWrapper">
                
                            {{-- Breadcrumbs  --}}
            <div class="scp-breadcrumb">
                <ul class="breadcrumb breadcrumb-csp">
                
                    <li><a href="{{ route('latest-videos') }}">{{ ucwords('videos') }}</a> <i class="fa fa-angle-right mx-2" aria-hidden="true"></i> </li>
                
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
                        <div class="col-sm-6 col-md-6 col-xs-12">
                            <ul class="list-inline p-0 share-icons music-play-lists">
                                        <!-- Watchlater -->
                                <li class="share">
                                    <span  data-toggle="modal"  data-video-id={{ $videodetail->id }} onclick="video_watchlater(this)" >
                                        <i class="video-watchlater {{ !is_null($videodetail->watchlater_exist) ? "fal fa-minus" : "fal fa-plus "  }}"></i>
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

                                <!-- Like -->
                                <li>
                                    <span data-video-id={{ $videodetail->id }}  onclick="video_like(this)" >
                                        <i class="video-like {{ !is_null( $videodetail->Like_exist ) ? 'ri-thumb-up-fill' : 'ri-thumb-up-line'  }}"></i>
                                    </span>
                                </li>

                                <!-- Dislike -->
                                <li>
                                    <span data-video-id={{ $videodetail->id }}  onclick="video_dislike(this)" >
                                        <i class="video-dislike {{ !is_null( $videodetail->dislike_exist ) ? 'ri-thumb-down-fill' : 'ri-thumb-down-line'  }}"></i>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="row m-0">  
                        <a class="btn btn-primary" href="{{ route('video-js-fullplayer',[ optional($videodetail)->slug ])}}">
                            <div class="playbtn" style="gap:5px">    {{-- Play --}}
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="80px" height="80px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                                    <polygon class="triangle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="73.5,62.5 148.5,105.8 73.5,149.1 " style="stroke: white !important;"></polygon>
                                    <circle class="circle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" style="stroke: white !important;"></circle>
                                </svg>
                                <span class="text pr-2"> Watch Now </span>
                            </div>
                        </a>

                        @php include public_path('themes/theme7/views/partials/social-share.php'); @endphp  
                        
                       
                        @if( optional($videodetail)->trailer_videos_url )

                            <ul class="list-inline p-0 m-0 share-icons music-play-lists">
                                <li class="share sharemobres">
                                    <span  data-toggle="modal" data-target="#video-js-trailer-modal">   {{-- Trailer --}}
                                        <i class="fal fa-play"></i>
                                    </span>

                                    <div class="share-box box-watchtrailer">
                                        <div class="playbtn"  data-toggle="modal" data-target="#video-js-trailer-modal">     {{-- Trailer --}}
                                            <span class="text" style="background-color: transparent; font-size: 14px; width:84px">Watch Trailer</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>

                            @php include public_path('themes/theme7/views/video-js-Player/video/videos-trailer.blade.php'); @endphp   

                        @endif
                        
                        
                        <div class="circleRating">  {{-- Rating --}}
                            <svg class="CircularProgressbar " viewBox="0 0 100 100" data-test-id="CircularProgressbar" >
                                <path class="CircularProgressbar-trail" d="M 50,50m 0,-46a 46,46 0 1 1 0,92a 46,46 0 1 1 0,-92" stroke-width="8" fill-opacity="0" style="stroke-dasharray: 289.027px, 289.027px; stroke-dashoffset: 0px;"></path>
                                <path class="CircularProgressbar-path" d="M 50,50m 0,-46a 46,46 0 1 1 0,92a 46,46 0 1 1 0,-92" stroke-width="8" fill-opacity="0" style="stroke: orange; stroke-dasharray: 289.027px, 289.027px; stroke-dashoffset: 101.159px;"></path>
                                <text class="CircularProgressbar-text" x="50" y="50"> {{ optional($videodetail)->rating }}  </text>
                            </svg>
                        </div>


                        {{-- <?php   $user = Auth::user(); 
                                if (  ($user->role!="subscriber" && $videodetail->access != 'guest' && $user->role!="admin") ) { ?>
                                <a href="<?php echo URL::to('/becomesubscriber'); ?>">
                                    <span class="view-count btn btn-primary subsc-video">
                                        <?php echo __('Subscribe'); ?>
                                    </span>
                                </a>
                        <?php } ?>

                        <?php if (  $videodetail->global_ppv != null && $user->role!="admin" && $videodetail->ppv_price != null  && $user->role!="admin") { ?>
                            <button data-toggle="modal" data-target="#exampleModalCenter" class="view-count btn btn-primary rent-video">
                                <?php echo __('Purchase Now'); ?> 
                            </button>
                        <?php } else { ?>
                            <a class="view-count btn btn-primary rent-video text-white" href="<?php echo URL::to('/login'); ?>">
                                <?php echo __('Rent'); ?>
                            </a>
                        <?php } ?> --}}
                    </div>


                    @if(!empty($videodetail->description )) {{-- Description --}}
                        <div class="overview">
                            <div class="heading">Description</div>
                            <div class="description">
                            <?php
                                $description = $videodetail->description;

                                if (strlen($description) > 290) {
                                    $shortDescriptionfirst = htmlspecialchars_decode(substr($description, 0, 290), ENT_QUOTES );
                                    $shortDescription = htmlspecialchars(strip_tags($shortDescriptionfirst), ENT_QUOTES, 'UTF-8');
                                    $fullDescription = htmlspecialchars_decode($description, ENT_QUOTES);

                                    echo "<p id='artistDescription' style='color:#fff !important;'>$shortDescription... <a href='javascript:void(0);' class='text-primary' onclick='toggleDescription()'>See More</a></p>";
                                    echo "<div id='fullDescription' style='display:none;'>$fullDescription <a href='javascript:void(0);' class='text-primary' onclick='toggleDescription()'>See Less</a></div>";
                                } else {
                                    echo "<p id='artistDescription'>$description</p>";
                                }
                            ?>
                            </div>
                        </div>
                    @endif


                    <div class="info">       {{-- publish_status --}}
                        <div classname="infoItem">
                            <span classname="text bold">Status: </span>
                            <span class="text">{{ $videodetail->video_publish_status }}</span>
                        </div>
                    </div>


                    @if ( $setting->show_languages == 1 &&  !$videodetail->Language->isEmpty())   {{-- Languages --}}
                        <div class="info">      
                            <span classname="text bold"> Languages:&nbsp;</span> 
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
                    <div class="artistHeading">Top Cast</div>
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
                <div class="artistHeading">
                    {{ ucwords('Promos & Resources ') }}
                </div>
                        

                    <div class="listItems">

                        @if( optional($videodetail)->trailer_videos_url )
                            <a>
                                <div class="listItem" data-toggle="modal" data-target="#video-js-trailer-modal" >
                                    <div class="profileImg">
                                        <span class="lazy-load-image-background blur lazy-load-image-loaded" style="color: transparent; display: inline-block;">
                                            <img src="{{ optional($videodetail)->image_url }}">
                                        </span>

                                        @php include public_path('themes/theme7/views/video-js-Player/video/videos-trailer.blade.php'); @endphp   

                                    </div>
                                    
                                    <div class="name titleoverflow"> {{ strlen($videodetail->title) > 20 ? substr($videodetail->title, 0, 21) . '...' : $videodetail->title }}  <span class="traileroverflow"> Trailer</span></div>
                                </div>
                            </a>
                        @endif

                        @if(  $videodetail->Reels_videos->isNotEmpty() )            {{-- E-Paper --}}
                                                                
                            @php  include public_path('themes/theme7/views/video-js-Player/video/Reels-videos.blade.php'); @endphp
                        
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
                <div class="sectionArtists">   
                    <div class="artistHeading"> Comments </div>
                        <div class="overflow-hidden">
                            @php include public_path('themes/theme7/views/comments/index.blade.php') @endphp
                        </div>
                </div>
            @endif

                        {{-- Recommended videos Section --}}

            @if ( ( $videodetail->recommended_videos)->isNotEmpty() ) 

                <div class=" container-fluid video-list  overflow-hidden p-0">

                    <h4 class="iq-main-header d-flex align-items-center justify-content-between" style="color:#fffff;">{{ ucwords('recommended videos') }}</h4> 

                    <div class="slider" data-slick='{"slidesToShow": 4, "slidesToScroll": 4, "autoplay": false}'>

                        <div class="favorites-contens">

                            <ul class="favorites-slider list-inline p-0 mb-0">

                                @foreach ( $videodetail->recommended_videos as $recommended_video)
                                
                                    <li class="slide-item">
                                        <div class="block-images position-relative">
                                            <!-- block-images -->
                                            <div class="border-bg">
                                                <div class="img-box">
                                                    <a class="playTrailer" href="{{ URL::to('category/videos/' . $recommended_video->slug) }}">
                                                        <img loading="lazy" class="img-fluid" data-src="{{ URL::to('/public/uploads/images/' . $recommended_video->image) }}">
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

        <div class="videoPopup ">
            <div class="opacityLayer"></div>
            <div class="videoPlayer">
                <span class="closeBtn">Close</span>
                <div style="width: 100%; height: 100%;">
                    <!-- Placeholder for video player -->
                </div>
            </div>
        </div>
    </div>


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

@php 
    include public_path('themes/theme7/views/video-js-Player/video/videos-details-script-file.blade.php');
    include public_path('themes/theme7/views/footer.blade.php'); 
@endphp
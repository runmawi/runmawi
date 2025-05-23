@php  include public_path('themes/theme5-nemisha/views/header.php'); @endphp

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
</style>


{{-- Style Link--}}
    <link rel="stylesheet" href="{{ asset('public/themes/theme5-nemisha/assets/css/video-js/video-details.css') }}">



    <link href="https://cdnjs.cloudflare.com/ajax/libs/videojs-ima/1.11.0/videojs.ima.css" rel="stylesheet">
    <link href="https://unpkg.com/video.js@7/dist/video-js.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/@videojs/themes@1/dist/fantasy/index.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/videojs-hls-quality-selector@1.1.4/dist/videojs-hls-quality-selector.min.css" rel="stylesheet">
    <link href="{{ URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.css') }}" rel="stylesheet" >
    {{-- <link href="{{ asset('public/themes/theme5-nemisha/assets/css/video-js/videos-player.css') }}" rel="stylesheet" > --}}



    <script src="{{ asset('public/themes/theme5-nemisha/assets/js/video-js/video.min.js') }}"></script>
    <script src="{{ asset('public/themes/theme5-nemisha/assets/js/video-js/videojs-contrib-quality-levels.js') }}"></script>
    <script src="{{ asset('public/themes/theme5-nemisha/assets/js/video-js/videojs-http-source-selector.js') }}"></script>
    <script src="{{ asset('public/themes/theme5-nemisha/assets/js/video-js/videojs-hls-quality-selector.min.js') }}"></script>
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
                <ul class="breadcrumb">
                
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
                        <i class="fas fa-circle"></i> 
                        
                        @if(isset($view_increment) && $view_increment == true )
                            {{ ( $movie->views + 1) . " views" }}
                        @else
                            {{ $videodetail->views . " views" }} 
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
                        <div class="col-sm-6 col-md-6 col-xs-12">
                            <ul class="list-inline p-0 share-icons music-play-lists">
                                        <!-- Watchlater -->
                                    <li class="share">
                                        <span  data-toggle="modal"  data-video-id={{ $videodetail->id }} onclick="video_watchlater(this)" >
                                            <i class="video-watchlater {{ !is_null($videodetail->watchlater_exist) ? "fal fa-minus" : "fal fa-plus "  }}"></i>
                                        </span>
                                        <div class="share-box box-watchtrailer " onclick="video_watchlater(this)" style="top:45px">
                                            <div class="playbtn"  data-toggle="modal">  
                                                <span class="text" style="background-color: transparent; font-size: 14px; width:124px; height:21px">
                                                    <!-- {{ __('Add To Watchlist') }} -->
                                                    {{ !is_null($videodetail->watchlater_exist) ? "Remove from Watchlist" : "Add To Watchlist"  }}
                                                </span>
                                            </div>
                                        </div>
                                    </li>

                                            <!-- Wishlist -->
                                    <li class="share">
                                        <span data-video-id={{ $videodetail->id }} onclick="video_wishlist(this)" >
                                            <i class="video-wishlist {{ !is_null( $videodetail->wishlist_exist ) ? 'ri-heart-fill' : 'ri-heart-line'  }}"></i>
                                        </span>
                                        <div class="share-box box-watchtrailer " onclick="video_wishlist(this)" style="top:45px">
                                            <div class="playbtn"  data-toggle="modal">  
                                                <span class="text" style="background-color: transparent; font-size: 14px; width:124px; height:21px">
                                                    <!-- {{ __('Add To Wishlist') }} -->
                                                    {{ !is_null($videodetail->wishlist_exist) ? "Remove from Wishlist" : "Add To Wishlist"  }}
                                                </span>
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

                    <div class="row">
                        @if ( $videodetail->users_video_visibility_status == false )
                            @if ( $videodetail->users_video_visibility_Rent_button || $videodetail->users_video_visibility_becomesubscriber_button || $videodetail->users_video_visibility_register_button || $videodetail->users_video_visibility_block_button )
                                <a class="btn" {{ $videodetail->users_video_visibility_Rent_button ? 'data-toggle=modal data-target=#video-purchase-now-modal' : 'href=' . $videodetail->users_video_visibility_redirect_url }}>
                                    <div class="playbtn" style="gap:5px">
                                        {!! $play_btn_svg !!}
                                        <span class="text pr-2"> {{ __( $videodetail->users_video_visibility_status_button ) }} </span>
                                    </div>
                                </a>

                                @if( !Auth::guest() && Auth::user()->role == "registered" && $videodetail->access == "ppv")
                                    <a class="btn" href="{{ URL::to('/becomesubscriber') }}">
                                        <div class="playbtn" style="gap:5px">
                                            {!! $play_btn_svg !!}
                                            <span class="text pr-2"> {{ __( 'Subscribe Now' ) }} </span>
                                        </div>
                                    </a>
                                @endif

                            @endif

                            {{-- subscriber & PPV  --}}

                            @if ( $videodetail->access == "subscriber" && !is_null($videodetail->ppv_price) )
                                <a class="btn" href="{{ $currency->enable_multi_currency == 1 ? route('Stripe_payment_video_PPV_Purchase',[ $videodetail->id,PPV_CurrencyConvert($videodetail->ppv_price) ]) : route('Stripe_payment_video_PPV_Purchase',[ $videodetail->id, $videodetail->ppv_price ]) }}">
                                    <div class="playbtn" style="gap:5px">
                                        {!! $play_btn_svg !!}
                                        <span class="text pr-2"> {{ __( 'Purchase Now' ) }} </span>
                                    </div>
                                </a>
                            @endif 
                        @else
                            <a class="btn" href="{{ $videodetail->users_video_visibility_redirect_url }}">
                                <div class="playbtn" style="gap:5px">
                                    {!! $play_btn_svg !!}
                                    <span class="text pr-2"> {{ __( $videodetail->users_video_visibility_status_button ) }} </span>
                                </div>
                            </a>
                        @endif

                            
                        @php include public_path('themes/default/views/partials/social-share.php'); @endphp 
                        
                       
                        @if( optional($videodetail)->trailer_videos_url )

                            <ul class="list-inline p-0 m-0 share-icons music-play-lists">
                                <li class="share sharemobres">
                                    <span  data-toggle="modal" data-target="#video-js-trailer-modal">   {{-- Trailer --}}
                                        <i class="fal fa-play"></i>
                                    </span>

                                    <div class="share-box box-watchtrailer">
                                        <div class="playbtn"  data-toggle="modal" data-target="#video-js-trailer-modal">     {{-- Trailer --}}
                                            <span class="text" style="background-color: transparent; font-size: 14px; width:84px">{{ __('Watch Trailer') }}</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>

                            @php include public_path('themes/default/views/video-js-Player/video/videos-trailer.blade.php'); @endphp   

                        @endif
                        
                        
                        <div class="circleRating">  {{-- Rating --}}
                            <svg class="CircularProgressbar " viewBox="0 0 100 100" data-test-id="CircularProgressbar" >
                                <path class="CircularProgressbar-trail" d="M 50,50m 0,-46a 46,46 0 1 1 0,92a 46,46 0 1 1 0,-92" stroke-width="8" fill-opacity="0" style="stroke-dasharray: 289.027px, 289.027px; stroke-dashoffset: 0px;"></path>
                                <path class="CircularProgressbar-path" d="M 50,50m 0,-46a 46,46 0 1 1 0,92a 46,46 0 1 1 0,-92" stroke-width="8" fill-opacity="0" style="stroke: orange; stroke-dasharray: 289.027px, 289.027px; stroke-dashoffset: 101.159px;"></path>
                                <text class="CircularProgressbar-text" x="50" y="50"> {{ optional($videodetail)->rating }}  </text>
                            </svg>
                        </div>
                    </div>

                    @if( $setting->show_description == 1 && optional($videodetail)->description )   {{-- Description --}}
                        <div class="overview">
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
                    <div class="artistHeading">{{ __('Top Cast') }}</div>
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

            @if(($videodetail->trailer) !== null || ($videodetail->reelvideo) !== null || ($videodetail->pdf_files) !== null)
                <div class="sectionArtists broadcast">   
                    <div class="artistHeading">
                        {{ ucwords(__('Promos & Resources')) }}
                    </div>
                            

                        <div class="listItems">

                            @if( optional($videodetail)->trailer )
                                <a>
                                    <div class="listItem" data-toggle="modal" data-target="#video-js-trailer-modal" >
                                        <div class="profileImg">
                                            <span class="lazy-load-image-background blur lazy-load-image-loaded" style="color: transparent; display: inline-block;">
                                                <img src="{{ optional($videodetail)->image_url }}">
                                            </span>

                                            @php include public_path('themes/default/views/video-js-Player/video/videos-trailer.blade.php'); @endphp   

                                        </div>
                                        
                                        <div class="name titleoverflow"> {{ strlen($videodetail->title) > 20 ? substr($videodetail->title, 0, 21) . '...' : $videodetail->title }}  <span class="traileroverflow"> {{ __('Trailer') }}</span></div>
                                    </div>
                                </a>
                            @endif

                            @if(  $videodetail->Reels_videos->isNotEmpty() )            {{-- E-Paper --}}
                                                                    
                                @php  include public_path('themes/default/views/video-js-Player/video/Reels-videos.blade.php'); @endphp
                            
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
            @endif

            {{-- comment Section --}}

            @if( $CommentSection != null && $CommentSection->videos == 1 )
                <div class="sectionArtists">   
                    <div class="artistHeading"> {{ __('Comments') }} </div>
                        <div class="overflow-hidden">
                            @php include public_path('themes/theme5-nemisha/views/comments/index.blade.php') @endphp
                        </div>
                </div>
            @endif

                        {{-- Recommended videos Section --}}

            @if ( ( $videodetail->recommended_videos)->isNotEmpty() ) 

                <div class=" container-fluid video-list  overflow-hidden">

                    <h4 class="Continue Watching" style="color:#fffff;">{{ ucwords( __('recommended videos')) }}</h4> 

                    <div class="slider" data-slick='{"slidesToShow": 4, "slidesToScroll": 4, "autoplay": false}'>

                        <div class="favorites-contens">
                            <div class="recommended-video home-sec list-inline row p-0 mb-0">

                                @foreach ( $videodetail->recommended_videos as $recommended_video)
                                
                                    <div class="items">
                                        <div class="block-images position-relative">
                                            <div class="border-bg">
                                                <div class="img-box">
                                                    <a class="playTrailer" href="{{ URL::to('category') . '/videos/' . $recommended_video->slug }}">
                                                        <img class="img-fluid w-100 flickity-lazyloaded" src="{{ $recommended_video->image ? URL::to('/public/uploads/images/'.$recommended_video->image) : $default_vertical_image_url }}" alt="{{ $recommended_video->title }}">
                                                    </a>

                                                    @if($ThumbnailSetting->free_or_cost_label == 1)
                                                        @switch(true)
                                                            @case($recommended_video->access == 'subscriber')
                                                                <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                            @break
                                                            @case($recommended_video->access == 'registered')
                                                                <p class="p-tag">{{ __('Register Now') }}</p>
                                                            @break
                                                            @case(!empty($recommended_video->ppv_price))
                                                                <p class="p-tag">{{ $currency->symbol . ' ' . $recommended_video->ppv_price }}</p>
                                                            @break
                                                            @case(!empty($recommended_video->global_ppv) && $recommended_video->ppv_price == null)
                                                                <p class="p-tag">{{ $recommended_video->global_ppv . ' ' . $currency->symbol }}</p>
                                                            @break
                                                            @case($recommended_video->global_ppv == null && $recommended_video->ppv_price == null)
                                                                <p class="p-tag">{{ __('Free') }}</p>
                                                            @break
                                                        @endswitch
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="block-description">
                                                <a class="playTrailer" href="{{ URL::to('category') . '/videos/' . $recommended_video->slug }}">

                                                    @if($ThumbnailSetting->free_or_cost_label == 1)
                                                        @switch(true)
                                                            @case($recommended_video->access == 'subscriber')
                                                                <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                            @break
                                                            @case($recommended_video->access == 'registered')
                                                                <p class="p-tag">{{ __('Register Now') }}</p>
                                                            @break
                                                            @case(!empty($recommended_video->ppv_price))
                                                                <p class="p-tag">{{ $currency->symbol . ' ' . $recommended_video->ppv_price }}</p>
                                                            @break
                                                            @case(!empty($recommended_video->global_ppv) && $recommended_video->ppv_price == null)
                                                                <p class="p-tag">{{ $recommended_video->global_ppv . ' ' . $currency->symbol }}</p>
                                                            @break
                                                            @case($recommended_video->global_ppv == null && $recommended_video->ppv_price == null)
                                                                <p class="p-tag">{{ __('Free') }}</p>
                                                            @break
                                                        @endswitch
                                                    @endif
                                                </a>

                                                <div class="hover-buttons text-white">
                                                    <a href="{{ URL::to('category') . '/videos/' . $recommended_video->slug }}" aria-label="movie">
                                                        @if($ThumbnailSetting->title == 1)
                                                            <p class="epi-name text-left mt-2 m-0">
                                                                {{ strlen($recommended_video->title) > 17 ? substr($recommended_video->title, 0, 18).'...' : $recommended_video->title }}
                                                            </p>
                                                        @endif

                                                        <p class="desc-name text-left m-0 mt-1">
                                                            {{ strlen($recommended_video->description) > 75 ? substr(html_entity_decode(strip_tags($recommended_video->description)), 0, 75) . '...' : strip_tags($recommended_video->description) }}
                                                        </p>

                                                        <div class="movie-time d-flex align-items-center pt-2">
                                                            @if($ThumbnailSetting->age == 1 && !($recommended_video->age_restrict == 0))
                                                                <span class="position-relative badge p-1 mr-2">{{ $recommended_video->age_restrict . ' +' }}</span>
                                                            @endif

                                                            @if($ThumbnailSetting->duration == 1)
                                                                <span class="position-relative text-white mr-2">
                                                                    {{ (floor($recommended_video->duration / 3600) > 0 ? floor($recommended_video->duration / 3600) . 'h ' : '') . floor(($recommended_video->duration % 3600) / 60) . 'm' }}
                                                                </span>
                                                            @endif
                                                            @if($ThumbnailSetting->published_year == 1 && !($recommended_video->year == 0))
                                                                <span class="position-relative badge p-1 mr-2">
                                                                    {{ __($recommended_video->year) }}
                                                                </span>
                                                            @endif
                                                            @if($ThumbnailSetting->featured == 1 && $recommended_video->featured == 1)
                                                                <span class="position-relative text-white">
                                                                {{ __('Featured') }}
                                                                </span>
                                                            @endif
                                                        </div>

                                                        <div class="movie-time d-flex align-items-center pt-1">
                                                            @php
                                                                $CategoryThumbnail_setting = App\CategoryVideo::join('video_categories', 'video_categories.id', '=', 'categoryvideos.category_id')
                                                                    ->where('categoryvideos.video_id', $recommended_video->id)
                                                                    ->pluck('video_categories.name');        
                                                            @endphp

                                                            @if($ThumbnailSetting->category == 1 && count($CategoryThumbnail_setting) > 0)
                                                                <span class="text-white">
                                                                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                                    {{ implode(', ', $CategoryThumbnail_setting->toArray()) }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </a>

                                                    <a class="epi-name mt-2 mb-0 btn" href="{{ URL::to('category') . '/videos/' . $recommended_video->slug }}">
                                                        <img class="d-inline-block ply" alt="ply" src="{{ URL::to('/assets/img/default_play_buttons.svg') }}" width="10%" height="10%"/>{{ __('Watch Now') }} 
                                                    </a>
                                                </div>
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

    <script>
        var elem = document.querySelector('.recommended-video');
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
    include public_path('themes/default/views/video-js-Player/video/videos-details-script-file.blade.php');
    include public_path('themes/default/views/video-js-Player/video/videos-details-script-stripe.blade.php');
    include public_path('themes/default/views/footer.blade.php'); 
@endphp
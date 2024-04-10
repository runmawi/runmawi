<?php

$data = App\Series::where('active', '=', '1')
    ->get()
    ->map(function ($item) {
        $item['image_url'] = URL::to('/public/uploads/images/' . $item->image);
        $item['Player_image_url'] = URL::to('/public/uploads/images/' . $item->player_image);
        $item['season_count'] = App\SeriesSeason::where('series_id', $item->id)->count();
        $item['episode_count'] = App\Episode::where('series_id', $item->id)->count();

        $item['Series_Category'] = App\SeriesCategory::select('category_id', 'series_id', 'name', 'slug')
            ->join('series_genre', 'series_genre.id', '=', 'series_categories.category_id')
            ->where('series_id', $item->id)
            ->get();

        $item['Series_Language'] = App\SeriesLanguage::select('language_id', 'series_id', 'name', 'slug')
            ->join('languages', 'languages.id', '=', 'series_languages.language_id')
            ->where('series_id', $item->id)
            ->get();

        $item['Series_artist'] = App\Seriesartist::select('artist_id', 'artist_name as name', 'artist_slug')
            ->join('artists', 'artists.id', '=', 'series_artists.artist_id')
            ->where('series_id', $item->id)
            ->get();

        $item['season'] = App\SeriesSeason::where('series_id', $item->id)->get();

        $item['Episode_details'] = $item->Series_depends_episodes;

        $item['Season_Trailer_details'] = App\SeriesSeason::where('series_id', $item->id)->whereNotNull('trailer_type')->whereNotNull('trailer')
                                            ->get()->map(function ($item) {
                                                
                                                switch (true) {

                                                case $item['trailer_type'] === "mp4_url":
                                                    $item['trailer_videos_url']  =  $item->trailer ;
                                                    $item['trailer_video_player_type'] =  'video/mp4' ;
                                                break;

                                                case $item['trailer_type'] === "m3u8_url" :
                                                    $item['trailer_videos_url']  =  $item->trailer ;
                                                    $item['trailer_video_player_type'] =  'application/x-mpegURL' ;
                                                break;

                                                default:
                                                    $item['trailer_videos_url']    = null ;
                                                    $item['trailer_video_player_type']   =  null ;
                                                break;
                                                }

                                                return $item;
                                            });

        $item['Episode_Similar_content'] = App\Episode::where('series_id','!=',$item->id)->where('status','1')->where('active',1)->get();

        return $item;
    });
?>
<style>
    .slidebtns #trending-slider-nav .slick-arrow{
        display: block !important;
        padding-top: 6px;
    }
</style>
@if (!empty($data) && $data->isNotEmpty())
    <section id="iq-trending" class="s-margin">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title"><a href="show-category.html">Trending</a></h4>
                    </div>
                    <div class="trending-contens slidebtns">
                        <ul id="trending-slider-nav" class="list-inline p-0 mb-0 row align-items-center ">
                            @foreach ($data as $series_details)
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="movie-slick position-relative">
                                            <img src="{{ $series_details->image_url }}" class="img-fluid">
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <ul id="trending-slider" class="list-inline p-0 m-0  d-flex align-items-center">
                            @foreach ($data as $key => $series_details )
                                <li>
                                    <div class="tranding-block position-relative"
                                        style="background-image: url( {{ $series_details->Player_image_url }} );">
                                        <div class="trending-custom-tab">
                                            <div class="tab-title-info position-relative">
                                                <ul class="trending-pills d-flex nav nav-pills justify-content-center align-items-center text-center"
                                                    role="tablist">

                                                    <!-- <li class="nav-item">
                                                        <a class="nav-link active show" data-toggle="pill"  href="{{'#trending-data-overview-'.$key }}" role="tab"
                                                            aria-selected="true">Overview</a>
                                                    </li> -->
<!-- 
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="pill" href="{{ '#trending-data-Episodes-'.$key }}"
                                                            role="tab" aria-selected="false">Episodes</a>
                                                    </li>

                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="pill" href="{{ '#trending-data-Trailers-'.$key }}"
                                                            role="tab" aria-selected="false">Trailers</a>
                                                    </li>

                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="pill" href="{{ '#trending-data-Similar-'.$key }}"
                                                            role="tab" aria-selected="false">Similar Like This</a>
                                                    </li> -->
                                                    
                                                </ul>
                                            </div>
                                                            
                                            <div class="trending-content">

                                                                {{-- overview --}}
                                                <div id="{{'trending-data-overview-'.$key }}" class="overview-tab tab-pane fade active show">
                                                    <div class="trending-info align-items-center w-100 animated fadeInUp">
                                                        <!-- <a href="javascript:void(0);" tabindex="0">
                                                            <div class="res-logo">
                                                                <div class="channel-logo">
                                                                    <img src="{{ front_end_logo() }}"
                                                                        class="c-logo" alt="streamit">
                                                                </div>
                                                            </div>
                                                        </a> -->

                                                        <h1 class="trending-text text-uppercase">{{ optional($series_details)->title }}</h1>

                                                        <div class="d-flex align-items-center text-white text-detail">
                                                            <span class="ml-3">{{ $series_details->season_count . " Seasons" }} </span>
                                                            <span class="trending-year">{{ optional($series_details)->year }}</span>
                                                        </div>

                                                        <div class="d-flex align-items-center series mb-4">
                                                            <!-- <img src="{{ front_end_logo() }}" class="img-fluid" alt=""> -->
                                                            <span class="text-gold ml-3"> {{ "#". ($key+1) ." in Series Today" }} </span>
                                                        </div>
                                                        <div class="col-md-6 pl-0">
                                                            <p class="trending-dec">{!! html_entity_decode( optional($series_details)->details) !!}</p>
                                                        </div>

                                                        <div class="p-btns">
                                                            <div class="d-flex align-items-center p-0">
                                                                <a href="{{ URL::to('play_series/'.$series_details->slug) }}" class="btn btn-hover mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i>Play Now</a>
                                                                {{-- <a href="#" class="btn btn-hover" tabindex="0"><i class="ri-add-line"></i>My List</a> --}}
                                                            </div>
                                                        </div>
                                                        <div class="trending-list mt-4">

                                                            @if ( $series_details->Series_artist->isNotEmpty() )
                                                                <div class="text-primary title">Starring:
                                                                    <span class="text-body"> 
                                                                        @foreach($series_details->Series_artist as $item )
                                                                            <a href="{{ route('artist',[ $item->artist_slug ])}}">{{ $item->name }}</a> {{ !$loop->last ? ',' : '' }}
                                                                        @endforeach
                                                                    </span>
                                                                </div>
                                                            @endif

                                                            @if ( ($series_details->Series_Category)->isNotEmpty() )
                                                                <div class="text-primary title">Genres: 
                                                                    <span class="text-body"> 
                                                                        @foreach($series_details->Series_Category as  $item)
                                                                            <a href=" {{  URL::to('/series/category'.'/'.$item->slug ) }}">{{ $item->name }}</a> {{ !$loop->last ? ',' : '' }} 
                                                                        @endforeach
                                                                    </span>
                                                                </div>
                                                            @endif
                                                            
                                                            @if ( $series_details->Series_Language->isNotEmpty() )
                                                                <div class="text-primary title">This Is:
                                                                    <span class="text-body">
                                                                        @foreach($series_details->Series_Language as $item)
                                                                            <a href="{{ URL::to('language/'. $item->language_id . '/' . $item->name ) }}">{{ $item->name }}</a> {{ !$loop->last ? ',' : '' }}
                                                                        @endforeach
                                                                    </span>
                                                                </div>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>

                                                                {{--  Episode --}}
                                                <!-- <div id="{{ 'trending-data-Episodes-'.$key }}" class="overlay-tab tab-pane fade">
                                                    <div class="trending-info align-items-center w-100 animated fadeInUp">
                                                        <a href="#" tabindex="0">
                                                            <div class="channel-logo">
                                                                <img src="{{ front_end_logo() }}" class="c-logo" alt="">
                                                            </div>
                                                        </a>

                                                        <h1 class="trending-text text-uppercase"> {{ optional($series_details)->title }}</h1></h1>

                                                        <div class="iq-custom-select d-inline-block sea-epi">
                                                            <select name="cars" class="form-control season-select">
                                                                @foreach ( $series_details->season as $key =>  $item )
                                                                    <option value="{{ 'season-'.$item }}">{{ 'Season '.($key+1 )}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div> 

                                                        <div class="episodes-contens mt-4">
                                                            <div
                                                                class="owl-carousel owl-theme episodes-slider1 list-inline p-0 mb-0">
                                                                
                                                                @foreach ($series_details->Episode_details as  $item)
                                                                    <div class="e-item">
                                                                        <div class="block-image position-relative">
                                                                            <a href="{{ URL::to('episode/'.$series_details->slug .'/'. $item->slug ) }}">
                                                                                <img src="{{ $item->player_image ? URL::to('public/uploads/images/'. $item->player_image ) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                                                            </a>
                                                                            <div class="episode-number">{{ ($key+1) }}</div>
                                                                            <div class="episode-play-info">
                                                                                <div class="episode-play">
                                                                                    <a href="{{ URL::to('episode/'.$series_details->slug .'/'. $item->slug ) }}" tabindex="0"><i class="ri-play-fill"></i></a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="episodes-description text-body mt-2">
                                                                            <div
                                                                                class="d-flex align-items-center justify-content-between">
                                                                                <a href="{{ URL::to('episode/'.$series_details->slug .'/'. $item->slug ) }}">{{ 'Episode ' .$item->episode_order }} </a>
                                                                                <span class="text-primary">                           
                                                                                    {{ $item->duration !=null ? Carbon\CarbonInterval::seconds($item->duration)->cascade()->format('%im %ss') : null }}
                                                                                </span>
                                                                            </div>
                                                                            <div class="mb-0">
                                                                                {!! html_entity_decode( optional($item)->episode_description) !!}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> -->

                                                                {{-- Trailers --}}
                                                <!-- <div id="{{ 'trending-data-Trailers-'.$key }}" class="overlay-tab tab-pane fade">
                                                    <div class="trending-info align-items-center w-100 animated fadeInUp">
                                                        <a href="#" tabindex="0">
                                                            <div class="channel-logo">
                                                                <img src="{{ front_end_logo() }}" class="c-logo" alt="">
                                                            </div>
                                                        </a>
                                                        <h1 class="trending-text text-uppercase"> {{ optional($series_details)->title }}</h1>

                                                        <div class="episodes-contens mt-4">
                                                            <div class="owl-carousel owl-theme episodes-slider1 list-inline p-0 mb-0">
                                                                @if( ($series_details->Season_Trailer_details)->isNotEmpty())

                                                                    @foreach ($series_details->Season_Trailer_details as $Season_Trailer_details_key =>   $item)
                                                                        <div class="e-item">
                                                                            <div class="block-image position-relative">

                                                                                <img src="{{ $item->image ? $item->image : default_vertical_image_url() }}" class="img-fluid" alt="">

                                                                                <div class="episode-play-info">
                                                                                    <div class="episode-play">
                                                                                        <a tabindex="0"><i class="ri-play-fill" data-toggle="modal" data-target={{ "#series_episode_overview-trailer-".$key.'-'.$Season_Trailer_details_key }} ></i></a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            <div class="episodes-description text-body mt-2">
                                                                                <div  class="d-flex align-items-center justify-content-between">
                                                                                    {{ $item->series_seasons_name }} </a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> -->
                                                                    
                                                                    {{-- Similar --}}
                                                <div id="{{ 'trending-data-Similar-'.$key }}" class="overlay-tab tab-pane fade">
                                                    <div class="trending-info align-items-center w-100 animated fadeInUp">
                                                        <a href="#" tabindex="0">
                                                            <div class="channel-logo">
                                                                <img src="{{ front_end_logo() }}" class="c-logo" alt="">
                                                            </div>
                                                        </a>

                                                        <h1 class="trending-text text-uppercase">{{ optional($series_details)->title }}</h1>

                                                        <div class="episodes-contens mt-4">
                                                            <div class="owl-carousel owl-theme episodes-slider1 list-inline p-0 mb-0">
                                                                @foreach ( $series_details->Episode_Similar_content as   $item )
                                                                    <div class="e-item">
                                                                        <div class="block-image position-relative">
                                                                            <a href="{{  URL::to('episode/'.$series_details->slug .'/'. $item->slug  ) }}">
                                                                                <img src="{{ $item->player_image ? URL::to('public/uploads/images/'. $item->player_image ) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                                                            </a>
                                                                            <div class="episode-number">{{ ($key+1) }}</div>
                                                                            <div class="episode-play-info">
                                                                                <div class="episode-play">
                                                                                    <a href="{{  URL::to('episode/'.$series_details->slug .'/'. $item->slug  ) }}" tabindex="0"><i class="ri-play-fill"></i></a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="episodes-description text-body mt-2">
                                                                            <div
                                                                                class="d-flex align-items-center justify-content-between">
                                                                                <a href="{{  URL::to('episode/'.$series_details->slug .'/'. $item->slug  ) }}">{{ 'Episode ' .$item->episode_order }} </a>
                                                                                <span class="text-primary">                           
                                                                                    {{ $item->duration !=null ? Carbon\CarbonInterval::seconds($item->duration)->cascade()->format('%im %ss') : null }}
                                                                                </span>
                                                                            </div>
                                                                            <div class="mb-0">{!! html_entity_decode( optional($item)->episode_description) !!}</div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Trailer Modal --}}

    <!-- @foreach ($data as $key => $series_details )
        @foreach ($series_details->Season_Trailer_details as $Season_Trailer_details_key =>   $item)

            <div class="modal fade" id='{{ "series_episode_overview-trailer-".$key.'-'.$Season_Trailer_details_key }}'  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="video-js-trailer-modalLabel" aria-hidden="true">
                <div class="modal-dialog video-js-trailer-modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body video-js-trailer-modal-body">
            
                            <button type="button" class="close video-js-trailer-modal-close"  data-series-episode-overview-modal-key="{{ 'series_episode_overview-trailer-'.$key.'-'.$Season_Trailer_details_key }}"  
                                onclick="video_js_trailer_modal_close(this)" >
                                <span aria-hidden="true">&times;</span>
                            </button>
            
                            <div class="embed-responsive embed-responsive-16by9">
                                <video id="series_episode_overview-video-js-trailer-player" class="video-js vjs-theme-fantasy vjs-icon-hd embed-responsive-item video-btn" controls
                                        preload="auto" width="100%" height="auto" poster=" {{ $item->image }}" >
                                        <source src="{{ $item->trailer_videos_url }}" type="{{ $item->trailer_video_player_type }}">
                                </video>       
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach -->
@endif

{{-- Style Link--}}
    <link rel="stylesheet" href="{{ asset('public/themes/theme6/assets/css/video-js/video-details.css') }}">

{{-- video-js Style --}}

    <link href="https://cdnjs.cloudflare.com/ajax/libs/videojs-ima/1.11.0/videojs.ima.css" rel="stylesheet">
    <link href="https://unpkg.com/video.js@7/dist/video-js.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/@videojs/themes@1/dist/fantasy/index.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/videojs-hls-quality-selector@1.1.4/dist/videojs-hls-quality-selector.min.css" rel="stylesheet">
    <link href="{{ URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.css') }}" rel="stylesheet" >

{{-- video-js Script --}}

    <script src="{{ asset('public/themes/theme6/assets/js/video-js/video.min.js') }}"></script>
    <script src="{{ asset('public/themes/theme6/assets/js/video-js/videojs-http-source-selector.js') }}"></script>
    <script src="{{ asset('public/themes/theme6/assets/js/video-js/videojs-hls-quality-selector.min.js') }}"></script>
    <script src="{{ URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.js') }}"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const videoElements = document.querySelectorAll('#series_episode_overview-video-js-trailer-player');

        videoElements.forEach(function(videoElement) {

            var player = videojs(videoElement, {  // Video Js Player  - Trailer
                aspectRatio: '16:9',
                fluid: true,

                controlBar: {
                    volumePanel: {
                        inline: false
                    },

                    children: {
                        'playToggle': {},
                        'currentTimeDisplay': {},
                        'timeDivider': {},
                        'durationDisplay': {},
                        'liveDisplay': {},

                        'flexibleWidthSpacer': {},
                        'progressControl': {},

                        'settingsMenuButton': {
                            entries: [
                                'playbackRateMenuButton'
                            ]
                        },
                        'fullscreenToggle': {}
                    }
                }
            });

            player.hlsQualitySelector({ // Hls Quality Selector - M3U8 
                displayCurrentQuality: true,
            });

            $(".video-js-trailer-modal-close").click(function(){
                player.pause();  
            });

        });
    });

    function video_js_trailer_modal_close(ele) {
        const series_episode_overview_modal_key = $(ele).attr('data-series-episode-overview-modal-key');
        $('#'+series_episode_overview_modal_key).modal('hide');
    }

</script>

<style>
    .video-js-trailer-modal-dialog {
        max-width: 800px;
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
    #trending-slider-nav .slick-current.slick-active .movie-slick{
        border-color:transparent !important;
    }
</style>
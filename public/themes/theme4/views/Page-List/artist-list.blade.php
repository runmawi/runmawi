@php
    include public_path("themes/{$current_theme}/views/header.php");
@endphp
<!-- MainContent -->

<section id="iq-favorites">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">

                <div class="iq-main-header align-items-center justify-content-between">
                    <h4 class="main-title fira-sans-condensed-regular"> {{ $order_settings_list[8]->header_name ? __($order_settings_list[8]->header_name) : '' }} </h4>
                </div>

                @if (($artist_pagelist)->isNotEmpty())
                    
                    <div class="trending-contens sub_dropdown_image mt-3" id="home-latest-videos-container">
                        <div id="trending-slider-nav" class="series-networks-slider-nav list-inline p-0 mar-left row align-items-center">
                    
                            @forelse($artist_pagelist as $key => $artist)
                                <div class="network-image">
                                    <div class="movie-sdivck position-relative">
                                        <img src="{{ $artist->image ? URL::to('public/uploads/artists/'.$artist->image) : $default_vertical_image_url }}" class="img-fluid w-100" alt="{{ $artist->artist_name}}">                                        
                                        
                                        <div class="controls">        
                                            <a href="{{ URL::to('category/videos/'.$artist->slug) }}">
                                                <button class="playBTN"> <i class="fas fa-play"></i></button>
                                            </a>
                                            <nav>
                                                <button class="moreBTN" tabindex="0" data-bs-toggle="modal" data-bs-target="#artist-list-{{ $key }}"><i class="fas fa-info-circle"></i><span>More info</span></button>
                                            </nav>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal -->
                                <div class="modal fade info_model" id="artist-list-{{ $key }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                                        <div class="container">
                                            <div class="modal-content" style="border:none;background:transparent;">
                                                <div class="res-view-hide position-absolute mb-2">
                                                    <button type="button" class="btn-close-white" aria-label="Close" data-bs-dismiss="modal">
                                                        <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="col-lg-12">
                                                        <div class="row">
                                                            <div class="col-lg-6 mb-3">
                                                                <img  src="{{ $artist->image ? URL::to('public/uploads/artists/'.$artist->image) : $default_vertical_image_url }}" alt="{{ $artist->artist_name}}">
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="row">
                                                                    <div class="col-lg-10 col-md-10 col-sm-10">
                                                                        <h2 class="caption-h2">{{ optional($artist)->artist_name }}</h2>
                                                                    </div>
                                                                    <div class="res-view-show col-lg-2 col-md-2 col-sm-2">
                                                                        <button type="button" class="btn-close-white" aria-label="Close" data-bs-dismiss="modal">
                                                                            <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                    
                                                                <div class="trending-dec">{!! html_entity_decode( $artist->description ) ??  $artist->description  !!}</div>
                                                            
                                                                    <a href="{{ URL::to('artist/'.$artist->artist_slug) }}" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0">
                                                                        <i class="far fa-eye mr-2" aria-hidden="true"></i> {{ "View Content" }}
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-md-12 text-center mt-4"
                                    style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                                    <p>
                                    <h3 class="text-center">{{ __('No Contents Available') }}</h3>
                                </div>
                            @endforelse
                        </div>
                        <div class="col-md-12 pagination justify-content-end">
                            {!! $artist_pagelist->links() !!}
                        </div>

                    </div>  
                @else
                    <div class="col-md-12 text-center mt-4" style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                        <h3 class="text-center">{{ __('No Contents Available') }}</h3>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<style>

    div#trending-slider-nav{display: flex;
        flex-wrap: wrap;}
        .network-image{flex: 0 0 16.666%;max-width: 16.666%;}
        /* .network-image img{width: 100%; height:auto;} */
        .movie-sdivck{padding:2px;}
        .sub_dropdown_image .network-image:hover .controls {
        opacity: 1;
        background-image: linear-gradient(0deg, black, transparent);
        border: 2px solid #2578c0 !important;
    }

    .controls {
        position: absolute;
        padding: 4px;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        width: 100%;
        z-index: 3;
        opacity: 0;
        -webkit-transition: all .15s ease;
        transition: all .15s ease;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
    }
    .controls nav {
        position: absolute;
        -webkit-box-align: end;
        -ms-flex-align: end;
        align-items: flex-end;
        right: 4px;
        top: 4px;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
    }
    .blob {
        margin: 10px;
        height: 22px;
        width: 59px;
        border-radius:25px;
        box-shadow: 0 0 0 0 rgba(255, 0, 0, 1);
        transform: scale(1);
        animation: pulse 2s infinite;
        position:absolute;
        top:0;
    }

    @media (max-width:1024px){
        .modal-body{padding:0 !important;}
    }
    @media (max-width:768px){
        .network-image{flex: 0 0 33.333%;max-width:33.333%;}
    }
    @media (max-width:500px){
        .network-image{flex: 0 0 50%;max-width:50%;}
    }

    @keyframes pulse {
        0% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(0, 0, 0, 0.7);
        }

        70% {
            transform: scale(1);
            box-shadow: 0 0 0 10px rgba(0, 0, 0, 0);
        }

        100% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(0, 0, 0, 0);
        }
    }
</style>
<?php include(public_path('themes/theme4/views/footer.blade.php'));  ?>
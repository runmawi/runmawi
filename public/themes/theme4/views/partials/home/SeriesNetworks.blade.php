<?php include public_path('themes/theme4/views/header.php'); ?>

<style>
    .main-content{
        overflow: hidden;
    }
    /* <!-- BREADCRUMBS  */
    .bc-icons-2 .breadcrumb-item+.breadcrumb-item::before {
        content: none;
    }

    ol.breadcrumb {
        color: white;
        background-color: transparent !important;
        font-size: revert;
    }
    .bc-icons-2 {
    font-size: 13px;
}
    
    .card-image {
        height: 124px;
        width: 124px;
        padding: 24px 8px 16px;
        -webkit-margin-end: 12px;
        margin-inline-end: 12px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        background: transparent;
        border-radius: 8px;
        overflow: hidden;
    }

    @media (min-width: 550px) {
        .card-image {
            height: 146px;
            width: 146px;
            -webkit-margin-end: 16px;
            margin-inline-end: 16px;
            display: flex;
            align-items: center;
            justify-content: space-evenly;
        }
    }

    @media (min-width: 550px) {
        .card__text {
            font-size: 14px;
            line-height: 19px;
        }
    }

    .card_image {
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card_text {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        font-size: 15px;
        font-weight: 400;
        line-height: 18px;
        text-align: center;
        max-height: 38px;
        color: #c6c8cd;
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
    }
    .category-cover {
        z-index: 0;
        height: 100%;
        top: 0;
        right: 0;
        overflow: hidden;
        width: 74%;
        mask-image: -webkit-gradient(linear, left top, right top, from(transparent), color-stop(50%, black));
        mask-image: linear-gradient(to right, transparent 0%, black 50%);
        -webkit-mask-image: -webkit-gradient(linear, left top, right top, from(transparent), color-stop(50%, black));
        -webkit-mask-image: linear-gradient(to right, transparent 0%, black 50%);
        position: absolute;
        pointer-events: none;
        
    }
    h3.vsub {font-size: 20px;}
    .position-rel{
        position: relative;
    }
    .position-absu{
        position:absolute;
        z-index: 9;
    }

    .controls{
        opacity: 0;
    }
    
    .sub_dropdown_image li:hover .controls {
        opacity: 1;
        background-image: linear-gradient(0deg, black, transparent);
        border: 2px solid #2578c0 !important;
        
    }
    
     .controls{
        position: absolute;
        padding: 4px;
        top: 0px;
        right: 0px;
        bottom: 0px;
        left: 0px;
        width:100%;
        z-index: 3;
        opacity: 0;
        -webkit-transition: all 0.15s ease;
        transition: all 0.15s ease;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
    }
    
     .playBTN{
        font-size: 20px;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        line-height: 1;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        border-radius: 50%;
        color: #fff;
        border: none;
        background-color: rgba(51, 51, 51, 0.4);
        -webkit-transition: background-color 0.15s ease;
        transition: background-color 0.15s ease;
        cursor: pointer;
        outline: none;
        padding: 0;
        position: absolute;
        top: 50%;
        left: 50%;
        width: 50px;
        height: 50px;
        -webkit-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }
    
      .playBTN:hover{
        background-color: #fff;
        color: #000;
    }
    
      .playBTN i{
        position: relative;
        left: 2px;
        top: 1px;
    }
    .moreBTN:hover span {
        width: auto;
        margin-left: 4px;
    }
    
    .controls .trending-dec{
        margin: auto 0 0;
        color: #fff;
        padding: 2px;
        font-size: calc(12px + 0.15vw);
        width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 17px;
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
    .moreBTN {
        color: #fff;
        -webkit-box-flex: 1;
        -ms-flex: 1;
        flex: 1;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        justify-items: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        background-color: rgba(51, 51, 51, 0.4);
        border: none;
        padding: 8px;
        border-radius: 4px;
        -webkit-box-shadow: none;
        box-shadow: none;
        font-size: calc(12px + 0.25vmin);
        font-weight: bold;
        -webkit-transition: all 0.2s ease;
        transition: all 0.2s ease;
        cursor: pointer;
        outline: none;
        line-height: 14px;
    }
    .moreBTN:hover {
        background-color: #fff;
        color: #000;
    }
    .moreBTN span {
        width: 0;
        margin-left: 0;
        overflow: hidden;
        white-space: nowrap;
        display: inline-block;
    }
    .favorites-slider .slick-prev, #trending-slider-nav .slick-prev,#trending-slider-nav .slick-next{top:30%;}
   
</style>


<div class="main-content p-0">
    <section id="iq-favorites ">
        <div class="container-fluid p-0">

            @if ($series_networks_pagelist->isNotEmpty())
                <div class="">
                    <!-- BREADCRUMBS -->
                    <div class="position-absu p-0">
                        <div class="container-fluid nav-div m-0 p-0" id="nav-tab" role="tablist">
                            <div class="bc-icons-2">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a class="black-text"
                                            href="{{ route('series.tv-shows') }}">{{ ucwords('Channel') }}</a>
                                        <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                                    </li>

                                    <li class="breadcrumb-item"><a class="black-text"
                                            href="{{ route('SeriescategoryList') }}">{{ ucwords('category') }}</a>
                                        <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                                    </li>

                                    <li class="breadcrumb-item">
                                        <a class="black-text">
                                            {{ strlen($series_data->name) > 50 ? ucwords(substr($series_data->name, 0, 120) . '...') : ucwords($series_data->name) }}
                                        </a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 iq-main-header d-flex align-items-center justify-content-between h-250 position-rel" style="height: 60vh;">
                        <div class="caption">
                            <h2>{{ optional($series_data)->name }}</h2> 
                        </div>
                        <div class="dropdown_thumbnail">
                            <img class="w-100 img-responsive" src="{{ $series_data->banner_image ? URL::to('public/uploads/seriesNetwork/' . $series_data->banner_image) : $default_vertical_image_url }}" alt="Videos" style="object-fit: cover; height: 350px;" />
                        </div>
                    </div> 
                </div>

                <div class="container-fluid pl-0">
                    <div class="row">
                        <div class="col-sm-12 page-height pr-0">
                            <div class="trending-contens sub_dropdown_image mt-3">
                                <div id="trending-slider-nav" class="series-networks-slider-nav list-inline p-0 mar-left row align-items-center">
                                    @foreach ($series_networks_pagelist as $key => $Series_Genre)                                        
                                        <div class="network-image">
                                            <div class="movie-sdivck position-relative">
                                                <img src="{{ $Series_Genre->image ?  URL::to('public/uploads/images/'.$Series_Genre->image) : default_vertical_image_url() }}" class="img-fluid w-100" alt="Videos" width="300" height="200">
                                                <div class="controls">        
                                                    <a href="{{ route('network.play_series',$Series_Genre->slug) }}">
                                                        <button class="playBTN"> <i class="fas fa-play"></i></button>
                                                    </a>
                                                    <nav>
                                                        <button class="moreBTN" tabindex="0" data-bs-toggle="modal" data-bs-target="#network-series-{{ $key }}"><i class="fas fa-info-circle"></i><span>More info</span></button>
                                                    </nav>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal -->
                                        <div class="modal fade info_model" id="network-series-{{ $key }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                                                <div class="container">
                                                    <div class="modal-content" style="border:none; background:transparent;">
                                                        <div class="modal-body">
                                                            <div class="col-lg-12">
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <img src="{{ $Series_Genre->image ?  URL::to('public/uploads/images/'.$Series_Genre->image) : default_vertical_image_url() }}" class="img-fluid w-100" alt="Videos" width="300" height="200">
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="row">
                                                                            <div class="col-lg-10 col-md-10 col-sm-10">
                                                                                <h2 class="caption-h2">{{ optional($Series_Genre)->title }}</h2>
                                                                            </div>
                                                                            <div class="col-lg-2 col-md-2 col-sm-2">
                                                                                <button type="button" class="btn-close-white" aria-label="Close" data-bs-dismiss="modal">
                                                                                    <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        @if (optional($Series_Genre)->description)
                                                                            <div class="trending-dec">{!! html_entity_decode( optional($Series_Genre)->description) !!}</div>
                                                                        @endif
                                                                        <a href="{{ route('network.play_series',$Series_Genre->slug) }}" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0">
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
                                    @endforeach
                                </div>

                                <div class="col-md-12 pagination justify-content-end">
                                    {!! $series_networks_pagelist->links() !!}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-md-12 text-center mt-4" style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                    <p>
                    <h3 class="text-center">{{ __('No Video Available') }}</h3>
                </div>
            @endif


        </div>
    </section>
</div>



<style>

    div#trending-slider-nav{display: flex;
        flex-wrap: wrap;}
        .network-image{flex: 0 0 16.666%;max-width: 16.666%;}
        .network-image img{width: 100%; height:auto;}
        .movie-sdivck{padding:2px;}
        #trending-slider-nav div.slick-slide{padding:2px;}
        div#trending-slider-nav .slick-slide.slick-current .movie-sdivck.position-relative{border:2px solid red}
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
        @media (max-width:1024px){
            .modal-body{padding:0 !important;}
        }
        @media (max-width:768px){
            .network-image{flex: 0 0 33.333%;max-width:33.333%;}
        }
        @media (max-width:500px){
            .network-image{flex: 0 0 50%;max-width:50%;}
        }
    </style>

@php
    include public_path('themes/theme4/views/footer.blade.php');
@endphp
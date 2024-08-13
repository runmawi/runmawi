
@php
    include public_path("themes/{$current_theme}/views/header.php");
@endphp

<section id="iq-favorites" class="pagelist">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">

                <div class="iq-main-header d-flex align-items-center justify-content-between">
                    <h2 class="main-title fira-sans-condensed-regular">
                            {{ $order_settings_list[33]->header_name ? __($order_settings_list[33]->header_name) : '' }}
                    </h2>  
                </div>

                @if (($epg_pagelist)->isNotEmpty())

                    <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">
                            @forelse($epg_pagelist as $key => $epg_channel_data)
                                <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                    <div class="block-images position-relative">
                                        <div class="border-bg">
                                            <div class="img-box">
                                                <a class="playTrailer" href="{{ route('Front-End.Channel-video-scheduler',$epg_channel_data->slug )}}">
                                                    <img class="img-fluid w-100 flickity-lazyloaded" src="{{ $epg_channel_data->image_url }}" alt="{{ $epg_channel_data->title }}">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="poistion-absolute">
                                            <div class="controls">        
                                                <a href="{{ route('Front-End.Channel-video-scheduler',$epg_channel_data->slug )}}">
                                                    <button class="playBTN"> <i class="fas fa-play"></i></button>
                                                </a>
                                                {{-- <nav>
                                                    <button class="moreBTN" tabindex="0" data-toggle="modal" data-target="#Home-epg-channel-Modal-{{ $key }}"><i class="fas fa-info-circle"></i><span>More info</span></button>
                                                </nav> --}}
                                            </div>
                                        </div>
                                    </div>
                                </li>
                    
                                <!-- Modal -->
                                <div class="modal fade info_model" id="Home-epg-channel-Modal-{{ $key }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                                        <div class="container">
                                            <div class="modal-content" style="border:none;background:transparent;">
                                                <div class="modal-body">
                                                    <div class="col-lg-12">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <img  src="{{ $epg_channel_data->Player_image_url }}" alt="modal">
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="row">
                                                                    <div class="col-lg-10 col-md-10 col-sm-10">
                                                                        <h2 class="caption-h2">{{ optional($epg_channel_data)->name }}</h2>
                                                                    </div>
                                                                    <div class="col-lg-2 col-md-2 col-sm-2">
                                                                        <button type="button" class="btn-close-white" aria-label="Close"  data-dismiss="modal">
                                                                            <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                @if (optional($epg_channel_data)->description)
                                                                    <div class="trending-dec mt-4">{!! html_entity_decode( optional($epg_channel_data)->description) !!}</div>
                                                                @endif
                                                                <a href="{{ route('Front-End.Channel-video-scheduler',$epg_channel_data->slug )}}" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0" ><i class="far fa-eye mr-2" aria-hidden="true"></i> View Content </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-md-12 text-center mt-4" style="background: url(<?= URL::to('/assets/img/watch.png') ?>);height: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                                    <p>
                                    <h3 class="text-center">{{ __('No Video Available') }}</h3>
                                </div>
                            @endforelse
                        </ul>
                        <div class="col-md-12 pagination justify-content-end">
                            {!! $epg_pagelist->links() !!}
                        </div>
                    </div>
                
                @else
                    <div class="col-md-12 text-center mt-4"
                        style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                        <p>
                        <h3 class="text-center">{{ __('No Video Available') }}</h3>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
<?php include public_path("themes/$current_theme/views/footer.blade.php"); ?>


<style>

    div#trending-slider-nav{display: flex;flex-wrap: wrap;}
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
    .block-images:hover .controls{
        opacity: 1;
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
    .playBTN {
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
        -webkit-transition: background-color .15s ease;
        transition: background-color .15s ease;
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
    .playBTN i {
        position: relative;
        left: 2px;
        top: 1px;
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
        font-weight: 700;
        -webkit-transition: all .2s ease;
        transition: all .2s ease;
        cursor: pointer;
        outline: none;
        line-height: 14px;
    }
    .moreBTN span {
        width: 0;
        margin-left: 0;
        overflow: hidden;
        white-space: nowrap;
        display: inline-block;
    }
    .moreBTN:hover {
        background-color: #fff;
        color: #000;
    }
    .moreBTN:hover span {
        width: auto;
        margin-left: 4px;
    }
</style>

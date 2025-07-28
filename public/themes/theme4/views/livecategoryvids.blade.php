@php
    include(public_path('themes/theme4/views/header.php'));
    $currency = App\CurrencySetting::first();
@endphp
<style>
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

</style>

<div class="main-content ">
    <section id="iq-trending">
        <div class="container-fluid">
            <div class="row ">
            <div class="col-sm-12 iq-main-header d-flex align-items-center justify-content-between h-250" style="height: 250px;">
                    <div class="caption">
                        <h2>{{ optional($parentCategories)->name }}</h2> 
                    </div>
                    <div class="category-cover">
                        <img class="w-100 img-responsive" src="{{ $parentCategories->image ? URL::to('public/uploads/livecategory/' . $parentCategories->image) : default_vertical_image_url() }}" />
                    </div>
                </div> 
            </div>
        </div>
    </section>

    <section id="iq-trending" class="s-margin">
        <div class="container-fluid pl-0">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">
                                
                    @if ($live_videos->isNotEmpty())
                        <div class="trending-contens sub_dropdown_image mt-3">
                            <div id="trending-slider-nav" class="series-networks-slider-nav list-inline p-0 mar-left row align-items-center">
                                @foreach ($live_videos as $key => $livestream_videos)                                        
                                    <div class="network-image">
                                        <div class="movie-sdivck position-relative">
                                            <img src="{{ $livestream_videos->image ?  URL::to('public/uploads/images/'.$livestream_videos->image) : default_vertical_image_url() }}" class="img-fluid w-100" alt="Videos" width="300" height="200">
                                            <div class="controls">        
                                                <a href="{{ URL::to('live/'.$livestream_videos->slug) }}">
                                                    <button class="playBTN"> <i class="fas fa-play"></i></button>
                                                </a>
                                                <nav>
                                                    <button class="moreBTN" tabindex="0" data-bs-toggle="modal" data-bs-target="#live-cate-{{ $key }}"><i class="fas fa-info-circle"></i><span>More info</span></button>
                                                </nav>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal -->
                                    <div class="modal fade info_model" id="live-cate-{{ $key }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                                            <div class="container">
                                                <div class="modal-content" style="border:none; background:transparent;">
                                                    <div class="modal-body">
                                                        <div class="col-lg-12">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <img src="{{ $livestream_videos->player_image ?  URL::to('public/uploads/images/'.$livestream_videos->player_image) : default_vertical_image_url() }}" class="img-fluid w-100" alt="Videos" width="300" height="200">
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="row">
                                                                        <div class="col-lg-10 col-md-10 col-sm-10">
                                                                            <h2 class="caption-h2">{{ optional($livestream_videos)->title }}</h2>
                                                                        </div>
                                                                        <div class="col-lg-2 col-md-2 col-sm-2">
                                                                            <button type="button" class="btn-close-white" aria-label="Close" data-bs-dismiss="modal">
                                                                                <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    @if (optional($livestream_videos)->description)
                                                                        <div class="trending-dec">{!! html_entity_decode( optional($livestream_videos)->description) !!}</div>
                                                                    @endif
                                                                    <a href="{{ URL::to('live/'.$livestream_videos->slug) }}" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0">
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
                                {!! $live_videos->links() !!}
                            </div>

                        </div>

                    @else
                        <div class="col-md-12 text-center mt-4" style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                            <p>
                            <h3 class="text-center">{{ __('No Video Available') }}</h3>
                        </div>
                    @endif
                </div>
            </div>
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
    include(public_path('themes/theme4/views/footer.blade.php'));
@endphp
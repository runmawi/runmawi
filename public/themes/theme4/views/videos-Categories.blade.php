<?php include public_path('themes/theme4/views/header.php'); ?>

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

<div class="main-content p-0">
    <section id="iq-trending">
        <div class="container-fluid">
            <div class="row ">
            <div class="col-sm-12 iq-main-header d-flex align-items-center justify-content-between h-250" style="height: 250px;">
                    <div class="caption">
                        <h2>{{ optional($VideosCategory)->name }}</h2> 
                    </div>
                    <div class="category-cover">
                        <img class="w-100 img-responsive" src="{{ $VideosCategory->image ? URL::to('public/uploads/videocategory/' . $VideosCategory->image) : default_vertical_image_url() }}" />
                    </div>
                </div> 
            </div>
        </div>
    </section>
    <section id="iq-trending" class="s-margin">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">

                    <div class="trending-contens">

                        <ul id="trending-slider-nav" class="list-inline p-0 mb-0 row align-items-center">
                            @foreach ($Parent_videos_categories as $key => $Parent_videos_category)
                                <li class="card-image">
                                    <a href="{{ route('video_categories', $Parent_videos_category->slug) }}">
                                        <div class="movie-slick position-relative">
                                            <div class="card_image">
                                                <img src="{{ $Parent_videos_category->image ? URL::to('public/uploads/videocategory/' . $Parent_videos_category->image) : default_vertical_image_url() }}"
                                                    class="img-fluid">
                                            </div>
                                        </div>
                                        <!-- <p class="card_text">{{ optional($Parent_videos_category)->name }} </p> -->
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if (!empty($video_categories_videos) && $video_categories_videos->isNotEmpty())
        <section id="iq-trending" class="s-margin">
            <div class="container-fluid pl-0">
                <div class="row">
                    <div class="col-sm-12 overflow-hidden">
                        <div class="caption">
                            <h3 class="vsub">Videos</h3> 
                        </div>        
                        {{-- Header --}}
                        <div class="iq-main-header d-flex align-items-center justify-content-between">
                            {{-- <h4 class="main-title pl-5"><a href="{{ $order_settings_list[1]->url ? URL::to($order_settings_list[1]->url) : null }} ">{{ optional($order_settings_list[1])->header_name }}</a></h4> --}}
                        </div>

                        <div class="trending-contens">
                            <ul id="trending-slider-nav" class="latest-videos-slider-nav list-inline p-0 ml-5 row align-items-center">
                                @foreach ($video_categories_videos as $latest_video)
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="movie-slick position-relative">
                                                <img src="{{ $latest_video->image ?  URL::to('public/uploads/images/'.$latest_video->image) : default_vertical_image_url() }}" class="img-fluid" >
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            <ul id="trending-slider latest-videos-slider" class="list-inline p-0 m-0 align-items-center latest-videos-slider">
                                @foreach ($video_categories_videos as $key => $latest_video )
                                    <li>
                                        <div class="tranding-block position-relative trending-thumbnail-image" style="background-image: url({{ $latest_video->player_image ?  URL::to('public/uploads/images/'.$latest_video->player_image) : default_horizontal_image_url() }}); background-repeat: no-repeat;background-size: cover;">
                                            <button class="close_btn">×</button>

                                            <div class="trending-custom-tab">
                                                <div class="trending-content">
                                                    <div id="" class="overview-tab tab-pane fade active show">
                                                        <div class="trending-info align-items-center w-100 animated fadeInUp">

                                                            <h2 class="trending-text big-title text-uppercase">{{ optional($latest_video)->title }}</h2>

                                                            @if (optional($latest_video)->description)
                                                                <div class="trending-dec">{!! html_entity_decode( optional($latest_video)->description) !!}</div>
                                                            @endif

                                                            <div class="p-btns">
                                                                <div class="d-flex align-items-center p-0">
                                                                    <a href="{{ URL::to('category/videos/'.$latest_video->slug) }}" class="button-groups btn btn-hover  mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                                    <a href="#" class="btn btn-hover button-groups mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> More Info </a>
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
    @endif
</div> 

<script>
    
    $( window ).on("load", function() {
        $('.latest-videos-slider').hide();
    });

    $(document).ready(function() {

        $('.latest-videos-slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            fade: true,
            draggable: false,
            asNavFor: '.latest-videos-slider-nav',
        });

        $('.latest-videos-slider-nav').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            asNavFor: '.latest-videos-slider',
            dots: false,
            arrows: true,
            nextArrow: '<a href="#" class="slick-arrow slick-next"></a>',
            prevArrow: '<a href="#" class="slick-arrow slick-prev"></a>',
            infinite: false,
            focusOnSelect: true,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 6,
                        slidesToScroll: 1,
                    },
                },
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 5,
                        slidesToScroll: 1,
                    },
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                    },
                },
            ],
        });

        $('.latest-videos-slider-nav').on('click', function() {
            $( ".close_btn" ).trigger( "click" );
            $('.latest-videos-slider').show();
        });

        $('body').on('click', '.close_btn', function() {
            $('.latest-videos-slider').hide();
        });
    });
</script>

@php include public_path('themes/theme4/views/footer.blade.php'); @endphp
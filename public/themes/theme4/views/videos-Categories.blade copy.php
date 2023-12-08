<?php include public_path('themes/theme4/views/header.php'); ?>

<style>
    .card-image {
        background: #1c2933;
        height: 124px;
        width: 124px;
        padding: 24px 8px 16px;
        -webkit-margin-end: 12px;
        margin-inline-end: 12px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        background: #1c2933;
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
            font-size: 16px;
            line-height: 19px;
        }
    }

    .card_image {
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        width: 50px;
        height: 50px;
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
        font-size: 16px;
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
</style>

<div class="main-content" style="background-image:linear-gradient(90deg, black, transparent), url({{ $VideosCategory->image ? URL::to('public/uploads/videocategory/' . $VideosCategory->image) : default_vertical_image_url() }}); background-repeat: no-repeat;background-size: cover;" >
    <section id="iq-trending" class="s-margin">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">

                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h3 class="main-title">{{ optional($VideosCategory)->name }}</h4>
                    </div>

                    <div class="trending-contens">

                        <ul id="trending-slider-nav"
                            class="latest-videos-slider-nav list-inline p-0 mb-0 row align-items-center">
                            @foreach ($Parent_videos_categories as $key => $Parent_videos_category)
                                <li class="card-image">
                                    <a href="{{ route('video_categories', $Parent_videos_category->slug) }}">
                                        <div class="movie-slick position-relative">
                                            <div class="card_image">
                                                <img src="{{ $Parent_videos_category->image ? URL::to('public/uploads/videocategory/' . $Parent_videos_category->image) : default_vertical_image_url() }}"
                                                    class="img-fluid">
                                            </div>
                                        </div>
                                    </a>
                                    <p class="card_text">{{ optional($Parent_videos_category)->name }} </p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if (!empty($video_categories) && $video_categories->isNotEmpty())
        <div class="container-fluid category-tab-content mt-4" id="category-videos-tab-content" style="padding-left: 56px;">
            @foreach ($video_categories as $key => $video_categories)
                <div class="col-sm-12 overflow-hidden">

                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title">{{ $video_categories->name }}</h4>
                    </div>

                    <div class="trending-contens">
                        <ul id="trending-slider-nav" class='{{ "slider-for category-based-videos-slider-nav-".$key ." list-inline p-0 mb-0 row align-items-center"}}'>
                            @foreach ($video_categories->category_videos as $videos)
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="movie-slick position-relative">
                                            <img src="{{ $videos->image ? URL::to('public/uploads/images/' . $videos->image) : default_vertical_image_url() }}" class="img-fluid">
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <ul id="trending-slider category-based-videos-slider"
                            class='{{"list-inline p-0 m-0 align-items-center category-based-videos-slider-".$key }}'>
                            @foreach ($video_categories->category_videos as $videos)
                                <li>
                                    <div class="tranding-block position-relative trending-thumbnail-image" >
                                        <button class="close_btn btn">×</button>
                                        <div class="trending-custom-tab">
                                            <div class="trending-content">
                                                <div id="" class="overview-tab tab-pane fade active show">
                                                    <div class="trending-info align-items-center w-100 animated fadeInUp">
                                                        <div class="caption pl-5">
                                                            <h2 class="caption-h2">{{ optional($videos)->title }}</h2>

                                                            @if ($videos->year != null && $videos->year != 0)
                                                                <div class="d-flex align-items-center text-white text-detail">
                                                                    <span
                                                                        class="trending">{{ $videos->year != null && $videos->year != 0 ? $videos->year : null }}</span>
                                                                </div>
                                                            @endif

                                                            @if (optional($videos)->description)
                                                                <div class="trending-dec">{!! html_entity_decode(optional($videos)->description) !!}</div>
                                                            @endif

                                                            <div class="p-btns">
                                                                <div class="d-flex align-items-center p-0">
                                                                    <a href="{{ URL::to('category/videos/' . $videos->slug) }}" class="button-groups btn btn-hover  mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                                </div>
                                                            </div>
                                                            <div class="dropdown_thumbnail">
                                                                <img  src="{{ $videos->player_image ? URL::to('public/uploads/images/' . $videos->player_image) : default_horizontal_image_url() }}" alt="">
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
            @endforeach
        </div>
    @endif
</div> 


<script>
    $(window).on("load", function() {
        $('.category-based-videos-slider-0.slick-initialized').css('display','none !important');
    });

    $(document).ready(function() {

        $('.slider-for').each(function(key, item) {

            var slider_nav = '.category-based-videos-slider-nav-' + key;
            var slider = '.category-based-videos-slider-' + key;

            var sliderToHide = $('.category-based-videos-slider-0').css('display','block !important');

            $(slider)
    .on('init', function(slick) {
        $(slider).css("overflow","visible");
    }).slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
                fade: true,
                draggable: false,
                asNavFor: slider_nav,
            });

            $(slider_nav).slick({
                slidesToShow: 6,
                slidesToScroll: 1,
                asNavFor: slider,
                dots: false,
                arrows: true,
                nextArrow: '<a href="#" class="slick-arrow slick-next"></a>',
                prevArrow: '<a href="#" class="slick-arrow slick-prev"></a>',
                infinite: false,
                focusOnSelect: true,
                responsive: [{
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1,
                        },
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                        },
                    },
                ],
            });

            $(document).on('click', slider_nav, function () {
                alert(slider);
                $('.category-based-videos-slider-0').css('display','none !important');
            });
        });

        $('body').on('click', '.close_btn', function() {
            $('.category-based-videos-slider').hide();
        });

        $('.slider-container').on('init', function (event, slick) {
            $('.category-based-videos-slider-0').css('background-color', 'red');
        });
    });

</script>

@php include public_path('themes/theme4/views/footer.blade.php'); @endphp
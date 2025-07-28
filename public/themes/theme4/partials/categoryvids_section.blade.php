@if (!empty($categoryVideos['video_categories']) && $categoryVideos['video_categories']->isNotEmpty())
    <div class="container-fluid category-tab-content" id="category-videos-tab-content">
        @foreach ($categoryVideos['video_categories'] as $video_categories)
            <div class="col-sm-12 overflow-hidden">

                <div class="iq-main-header d-flex align-items-center justify-content-between">
                    <h4 class="main-title">{{ $video_categories->name }}</h4>
                </div>

                <div class="trending-contens">
                    <ul id="trending-slider-nav" class="category-based-videos-slider-nav list-inline p-0 mb-0 row align-items-center">
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
                        class="list-inline p-0 m-0 align-items-center category-based-videos-slider">
                        @foreach ($video_categories->category_videos as $key => $videos)
                            <li>
                                <div class="tranding-block position-relative trending-thumbnail-image" style="background-image: url({{ $videos->player_image ? URL::to('public/uploads/images/' . $videos->player_image) : default_horizontal_image_url() }}); background-repeat: no-repeat;background-size: cover;">
                                    <button class="close_btn btn">×</button>
                                    <div class="trending-custom-tab">
                                        <div class="trending-content">
                                            <div id="" class="overview-tab tab-pane fade active show">
                                                <div class="trending-info align-items-center w-100 animated fadeInUp">

                                                    <h2 class="trending-text big-title text-uppercase">
                                                        {{ optional($videos)->title }}</h2>

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
@else
    <div class="col-md-12 text-center mt-4" style="background: url(<?=URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
        <p ><h3 class="text-center">No video Available</h3>
    </div>
@endif

<script>
    $(window).on("load", function() {
        $('.category-based-videos-slider').hide();
    });

    $(document).ready(function() {

        $('.category-based-videos-slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            draggable: false,
            asNavFor: '.category-based-videos-slider-nav',
        });

        $('.category-based-videos-slider-nav').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            asNavFor: '.category-based-videos-slider',
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

        $('.category-based-videos-slider-nav').on('click', function() {
            $(".close_btn").trigger("click");
            $('.category-based-videos-slider').show();
        });

        $('body').on('click', '.close_btn', function() {
            $('.category-based-videos-slider').hide();
        });
    });
</script>
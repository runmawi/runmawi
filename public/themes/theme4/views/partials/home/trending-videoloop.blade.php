@if (!empty($data) && $data->isNotEmpty())
    <section id="iq-trending" class="s-margin">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">
                                    
                                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title"><a href="{{ $order_settings_list[0]->url ? URL::to($order_settings_list[0]->url) : null }} ">{{ optional($order_settings_list[0])->header_name }}</a></h4>
                    </div>

                    <div class="trending-contens">
                        <ul id="trending-slider-nav" class="featured-videos-slider-nav list-inline p-0 mb-0 row align-items-center">
                            @foreach ($data as $featured_videos)
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="movie-slick position-relative">
                                            <img src="{{ $featured_videos->image ?  URL::to('public/uploads/images/'.$featured_videos->image) : default_vertical_image_url() }}" class="img-fluid" >
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <ul id="trending-slider featured-videos-slider" class="list-inline p-0 m-0 align-items-center featured-videos-slider">
                            @foreach ($data as $key => $featured_videos )
                                <li>
                                    <div class="tranding-block position-relative" style="background-image: url({{ $featured_videos->player_image ?  URL::to('public/uploads/images/'.$featured_videos->player_image) : default_horizontal_image_url() }});">
                                        <button class="close_btn">×</button>

                                        <div class="trending-custom-tab">
                                            <div class="trending-content">
                                                <div id="" class="overview-tab tab-pane fade active show">
                                                    <div class="trending-info align-items-center w-100 animated fadeInUp">

                                                        <h1 class="trending-text big-title text-uppercase">{{ optional($featured_videos)->title }}</h1>

                                                        <div class="d-flex align-items-center text-white text-detail">
                                                            <span class="trending">{{ ($featured_videos->year != null && $featured_videos->year != 0) ? $featured_videos->year : null   }}</span>
                                                        </div>

                                                        <p class="trending-dec">{!! html_entity_decode( optional($featured_videos)->description) !!}</p>

                                                        <div class="p-btns">
                                                            <div class="d-flex align-items-center p-0">
                                                                <a href="{{ URL::to('category/videos/'.$featured_videos->slug) }}" class="btn btn-hover mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                                <a href="#" class="btn btn-hover mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> More Info </a>
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

<script>
    
    $( window ).on("load", function() {
        $('.featured-videos-slider').hide();
    });

    $(document).ready(function() {

        $('.featured-videos-slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            draggable: false,
            asNavFor: '.featured-videos-slider-nav',
        });

        $('.featured-videos-slider-nav').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            asNavFor: '.featured-videos-slider',
            dots: false,
            arrows: true,
            nextArrow: '<a href="#" class="slick-arrow slick-next"></a>',
            prevArrow: '<a href="#" class="slick-arrow slick-prev"></a>',
            infinite: true,
            centerMode: true,
			centerPadding: 0,
            focusOnSelect: true,
            responsive: [
                {
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

        $('.featured-videos-slider-nav').on('click', function() {
            $( ".close_btn" ).trigger( "click" );
            $('.featured-videos-slider').show();
        });

        $('body').on('click', '.close_btn', function() {
            $('.featured-videos-slider').hide();
        });
    });
</script>
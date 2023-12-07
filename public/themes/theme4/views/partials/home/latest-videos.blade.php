@if (!empty($data) && $data->isNotEmpty())
    <section id="iq-trending" class="s-margin">
        <div class="container-fluid pl-0">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">
                                    
                                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title pl-5"><a href="{{ $order_settings_list[1]->url ? URL::to($order_settings_list[1]->url) : null }} ">{{ optional($order_settings_list[1])->header_name }}</a></h4>
                        <h4 class="main-title"><a href="{{ $order_settings_list[1]->url ? URL::to($order_settings_list[1]->url) : null }} ">{{ "view all" }}</a></h4>
                    </div>

                    <div class="trending-contens">
                        <ul id="trending-slider-nav" class="latest-videos-slider-nav list-inline p-0 ml-5 row align-items-center">
                            @foreach ($data as $latest_video)
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
                            @foreach ($data as $key => $latest_video )
                                <li>
                                    <div class="tranding-block position-relative trending-thumbnail-image" >
                                        <button class="drp-close">×</button>

                                        <div class="trending-custom-tab">
                                            <div class="trending-content">
                                                <div id="" class="overview-tab tab-pane fade active show">
                                                    <div class="trending-info align-items-center w-100 animated fadeInUp">

                                                    <div class="caption pl-5">
                                                            <h2 class="caption-h2">{{ optional($latest_video)->title }}</h2>

                                                        {{-- @if ( $latest_video->year != null && $latest_video->year != 0)
                                                            <div class="d-flex align-items-center text-white text-detail">
                                                                <span class="trending">{{ ($latest_video->year != null && $latest_video->year != 0) ? $latest_video->year : null   }}</span>
                                                            </div>
                                                        @endif  --}}

                                                        @if (optional($latest_video)->description)
                                                            <div class="trending-dec">{!! htmlspecialchars(substr(optional($latest_video)->description, 0, 100)) !!}</div>
                                                        @endif

                                                        <div class="p-btns">
                                                            <div class="d-flex align-items-center p-0">
                                                                <a href="{{ URL::to('category/videos/'.$latest_video->slug) }}" class="button-groups btn btn-hover  mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                                <a href="{{ URL::to('category/videos/'.$latest_video->slug) }}" class="btn btn-hover button-groups mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> More Info </a>
                                                            </div>
                                                        </div>
                                                        </div>

                                                        <div class="dropdown_thumbnail">
                                                            <img  src="{{ $latest_video->player_image ?  URL::to('public/uploads/images/'.$latest_video->player_image) : default_horizontal_image_url() }}" alt="">
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
        $('.latest-videos-slider').hide();
    });

    $(document).ready(function() {

        $('.latest-videos-slider').slick({
            slidesToShow: 6,
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
            $( ".drp-close" ).trigger( "click" );
            $('.latest-videos-slider').show();
        });

        $('body').on('click', '.drp-close', function() {
            $('.latest-videos-slider').hide();
        });
    });
</script>
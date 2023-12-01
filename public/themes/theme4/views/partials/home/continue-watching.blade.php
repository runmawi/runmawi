@if (!empty($data) && $data->isNotEmpty())

    <section id="iq-favorites">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">

                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title"><a href="#">{{ ucwords('continue watching') }}</a></h4>
                        <h4 class="main-title"><a href="#">{{ ucwords('view all') }}</a></h4>
                    </div>

                    <div class="trending-contens">
                        <ul id="trending-slider-nav" class="cnt-videos-slider-nav list-inline p-0 mb-0 row align-items-center">
                            @foreach ($data as $key => $video_details)
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="movie-slick position-relative">
                                            <img src="{{ $video_details->image ?  URL::to('public/uploads/images/'.$video_details->image) : default_vertical_image_url() }}" class="img-fluid" >
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <ul id="trending-slider cnt-videos-slider" class="list-inline p-0 m-0 align-items-center cnt-videos-slider">
                            @foreach ($data as $key => $video_details )
                                <li>
                                    <div class="tranding-block position-relative trending-thumbnail-image" style="background-image: url({{ $video_details->player_image ?  URL::to('public/uploads/images/'.$video_details->player_image) : default_horizontal_image_url() }}); background-repeat: no-repeat;background-size: cover;">
                                        <button class=" close_btn">×</button>

                                        <div class="trending-custom-tab">
                                            <div class="trending-content">
                                                <div id="" class="overview-tab tab-pane fade active show">
                                                    <div class="trending-info align-items-center w-100 animated fadeInUp">

                                                        <h2 class="trending-text big-title text-uppercase">{{ optional($video_details)->title }}</h2>

                                                        <!-- @if ( $video_details->year != null && $video_details->year != 0)
                                                            <div class="d-flex align-items-center text-white text-detail">
                                                                <span class="trending">{{ ($video_details->year != null && $video_details->year != 0) ? $video_details->year : null   }}</span>
                                                            </div>
                                                        @endif -->

                                                        @if (optional($video_details)->description)
                                                            <div class="trending-dec">{!! html_entity_decode( optional($video_details)->description) !!}</div>
                                                        @endif

                                                        <div class="p-btns">
                                                            <div class="d-flex align-items-center p-0">
                                                                <a href="{{ URL::to('category/videos/'.$video_details->slug) }}" class="btn btn-hover button-groups mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
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





<script>
    
    $( window ).on("load", function() {
        $('.cnt-videos-slider').hide();
    });

    $(document).ready(function() {

        $('.cnt-videos-slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            draggable: false,
            asNavFor: '.cnt-videos-slider-nav',
        });

        $('.cnt-videos-slider-nav').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            asNavFor: '.cnt-videos-slider',
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

        $('.cnt-videos-slider-nav').on('click', function() {
            $( ".close_btn" ).trigger( "click" );
            $('.cnt-videos-slider').show();
        });

        $('body').on('click', '.close_btn', function() {
            $('.cnt-videos-slider').hide();
        });
    });
</script>
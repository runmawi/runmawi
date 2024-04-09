@if (!empty($data) && $data->isNotEmpty())

    <section id="iq-favorites">
        <div class="container-fluid pl-0">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">

                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-name mar-left"><a href="{{ $order_settings_list[10]->url ? URL::to($order_settings_list[10]->url) : null }} ">{{ optional($order_settings_list[10])->header_name }}</a></h4>
                        <h4 class="main-name"><a href="{{ $order_settings_list[10]->url ? URL::to($order_settings_list[10]->url) : null }} ">{{ 'View all' }}</a></h4>
                    </div>

                    <div class="favorites-contens">
                            <ul id="trending-slider-nav" class="schedule-nav list-inline p-0 mar-left row align-items-center">
                                @foreach ($data as $key => $video_details)
                                    <li class="slick-slide">
                                        <a href="javascript:void(0);">
                                            <div class="movie-slick position-relative">
                                                <img src="{{ $video_details->image ?  $video_details->image : default_vertical_image_url() }}" class="img-fluid" >
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            <ul id="trending-slider schedule" class="list-inline p-0 m-0 align-items-center schedule">
                                @foreach ($data as $key => $video_details)
                                    <li class="slick-slide">
                                        <div class="tranding-block position-relative trending-thumbnail-image" >
                                            <button class="drp-close">×</button>

                                            <div class="trending-custom-tab">
                                                <div class="trending-content">
                                                    <div id="" class="overview-tab tab-pane fade active show">
                                                        <div class="trending-info align-items-center w-100 animated fadeInUp">

                                                            <div class="caption pl-4">
                                                                <h2 class="caption-h2">{{ strlen($video_details->name) > 17 ? substr($video_details->name, 0, 18) . '...' : $video_details->name }}</h2>

                                                                <div class="p-btns">
                                                                    <div class="d-flex align-items-center p-0">
                                                                        <a href="{{ URL::to('schedule/videos/embed/'.$video_details->slug ) }}" class="button-groups btn btn-hover  mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="dropdown_thumbnail">
                                                                <img  src="{{ $video_details->image ?  $video_details->image : default_vertical_image_url() }}" alt="">
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
        $('.schedule').hide();
    });

    $(document).ready(function() {

        $('.schedule').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            arrows: true,
            fade: true,
            draggable: false,
            asNavFor: '.schedule-nav',
        });

        $('.schedule-nav').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            asNavFor: '.schedule',
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

        $('.schedule-nav').on('click', function() {
            $( ".drp-close" ).trigger( "click" );
            $('.schedule').show();
        });

        $('body').on('click', '.drp-close', function() {
            $('.schedule').hide();
        });
    });
</script>
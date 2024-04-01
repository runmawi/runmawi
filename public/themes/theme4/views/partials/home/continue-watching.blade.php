@if (!empty($data) && $data->isNotEmpty())

    <section id="iq-favorites">
        <div class="container-fluid pl-0">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">

                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title mar-left"><a href="#">{{ ucwords('continue watching') }}</a></h4>
                        <h4 class="main-title"><a href="#">{{ ucwords('view all') }}</a></h4>
                    </div>

                    <div class="trending-contens">
                        <ul id="trending-slider-nav" class="cnt-videos-slider-nav list-inline p-0 mar-left row align-items-center">
                            @foreach ($data as $key => $video_details)
                                <li class="slick-slide">
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
                                <li class="slick-slide">
                                    <div class="tranding-block position-relative trending-thumbnail-image" >
                                        <button class="  drp-close">×</button>

                                        <div class="trending-custom-tab">
                                            <div class="trending-content">
                                                <div id="" class="overview-tab tab-pane fade active show">
                                                    <div class="trending-info align-items-center w-100 animated fadeInUp">

                                                        <div class="caption pl-4">
                                                            <h2 class="caption-h2">{{ optional($video_details)->title }}</h2>

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
                                                                    <a class="btn btn-hover button-groups mr-2" tabindex="0" data-bs-toggle="modal" data-bs-target="{{ '#Home-continue-videos-Modal-'.$key }}"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="dropdown_thumbnail">
                                                            <img  src="{{ $video_details->player_image ?  URL::to('public/uploads/images/'.$video_details->player_image) : default_horizontal_image_url() }}" alt="">
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

        
        @foreach ($data as $key => $video_details )
            <div class="modal fade info_model" id="{{ "Home-continue-videos-Modal-".$key }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                    <div class="container">
                        <div class="modal-content" style="border:none; background:transparent;">
                            <div class="modal-body">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <img  src="{{ $video_details->player_image ?  URL::to('public/uploads/images/'.$video_details->player_image) : default_horizontal_image_url() }}" alt="" width="100%">
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-10 col-md-10 col-sm-10">
                                                    <h2 class="caption-h2">{{ optional($video_details)->title }}</h2>

                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-2">
                                                    <button type="button" class="btn-close-white" aria-label="Close"  data-bs-dismiss="modal">
                                                        <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                            

                                            @if (optional($video_details)->description)
                                                <div class="trending-dec mt-4">{!! html_entity_decode( optional($video_details)->description) !!}</div>
                                            @endif

                                            <a href="{{ URL::to('category/videos/'.$video_details->slug) }}" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0" ><i class="far fa-eye mr-2" aria-hidden="true"></i> View Content </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach


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
            slidesToScroll: 4,
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

        $(document).ready(function() {
            var sliderVisible = false;

            $('.cnt-videos-slider-nav').on('click', function() {
                $(".drp-close").trigger("click");
                if (!sliderVisible) {
                    $('.cnt-videos-slider').show();
                    sliderVisible = true;
                } else {
                    $('.cnt-videos-slider').hide();
                    sliderVisible = false;
                }
            });
        });

        $('body').on('click', '.drp-close', function() {
            $('.cnt-videos-slider').hide();
        });
    });
</script>


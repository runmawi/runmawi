@if (!empty($data) && $data->isNotEmpty())
    <section id="iq-trending" class="s-margin">
        <div class="container-fluid pl-0">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">
                                    
                                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title pl-4">
                            <a href="#">{{ "Latest Episodes" }}</a>
                        </h4>                   
                    </div>

                    <div class="trending-contens">
                        <ul id="trending-slider-nav" class="Latest-Episode-slider-nav list-inline p-0 ml-4 row align-items-center">
                            @foreach ($data as $episode_details)
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="movie-slick position-relative">
                                            <img src="{{ $episode_details->image ? URL::to('public/uploads/images/'.$episode_details->image) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <ul id="trending-slider Latest-Episode-slider" class="list-inline p-0 m-0 align-items-center Latest-Episode-slider">
                            @foreach ($data as $key => $episode_details )
                                <li>
                                    <div class="tranding-block position-relative trending-thumbnail-image">
                                        <button class="drp-close">×</button>

                                        <div class="trending-custom-tab">
                                            <div class="trending-content">
                                                <div id="" class="overview-tab tab-pane fade active show">
                                                    <div class="trending-info align-items-center w-100 animated fadeInUp">

                                                        <div class="caption pl-4">
                                                            <h2 class="caption-h2">{{ optional($episode_details)->title }}</h2>

                                                            @if (optional($episode_details)->episode_description)
                                                                <div class="trending-dec">{!! html_entity_decode( optional($episode_details)->episode_description) !!}</div>
                                                            @endif


                                                            <div class="p-btns">
                                                                <div class="d-flex align-items-center p-0">
                                                                    <a href="{{ URL::to('episode/'. $episode_details->series_title->slug.'/'.$episode_details->slug ) }}" class="button-groups btn btn-hover  mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                                    <a href="{{ URL::to('episode/'. $episode_details->series_title->slug.'/'.$episode_details->slug ) }}" class="btn btn-hover button-groups mr-2" tabindex="0"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="dropdown_thumbnail">
                                                            <img  src="{{ $episode_details->player_image ?  URL::to('public/uploads/images/'.$episode_details->player_image) : default_horizontal_image_url() }}" alt="">
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
        $('.Latest-Episode-slider').hide();
    });

    $(document).ready(function() {

        $('.Latest-Episode-slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            draggable: false,
            asNavFor: '.Latest-Episode-slider-nav',
        });

        $('.Latest-Episode-slider-nav').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            asNavFor: '.Latest-Episode-slider',
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

        $('.Latest-Episode-slider-nav').on('click', function() {
            $( ".drp-close" ).trigger( "click" );
            $('.Latest-Episode-slider').show();
        });

        $('body').on('click', '.drp-close', function() {
            $('.Latest-Episode-slider').hide();
        });
    });
</script>
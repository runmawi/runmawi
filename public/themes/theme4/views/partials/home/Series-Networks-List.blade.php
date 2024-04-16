<?php include public_path('themes/theme4/views/header.php'); ?>


@if (!empty($series_data) && $series_data->isNotEmpty())
    <section id="iq-trending" class="s-margin">
        <div class="container-fluid pl-0">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">
                                    
                                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title mar-left">{{ 'TV Shows Networks' }}</h4>
                    </div>

                    <div class="trending-contens">
                        <ul id="trending-slider-nav" class="series-networks-slider-nav list-inline p-0 mar-left row align-items-center">
                            @foreach ($series_data as $series_network_list)
                                <li class="slick-slide">
                                    <a href="javascript:void(0);">
                                        <div class="movie-slick position-relative">
                                            <img src="{{ $series_network_list->image_url }}" class="img-fluid" alt="Videos">
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <ul id="trending-slider series-networks-slider" class="list-inline p-0 m-0 align-items-center series-networks-slider">
                            @foreach ($series_data as $key => $series_network_list )
                                <li class="slick-slide">
                                    <div class="tranding-block position-relative trending-thumbnail-image" >
                                        <button class="drp-close">×</button>

                                        <div class="trending-custom-tab">
                                            <div class="trending-content">
                                                <div id="" class="overview-tab tab-pane fade active show">
                                                    <div class="trending-info align-items-center w-100 animated fadeInUp">

                                                        <div class="caption pl-4">
                                                                <h2 class="caption-h2">{{ optional($series_network_list)->name }}</h2>

                                                            <div class="p-btns">
                                                                <div class="d-flex align-items-center p-0">
                                                                    <a href="{{ URL::to('series/category/'. $series_network_list->slug) }}" class="button-groups btn btn-hover  mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Visit </a>
                                                                    {{-- <a href="#" class="btn btn-hover button-groups mr-2" tabindex="0"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a> --}}
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="dropdown_thumbnail">
                                                            <img  src="{{ $series_network_list->banner_image_url  }}" alt="Videos">
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
        $('.series-networks-slider').hide();
    });

    $(document).ready(function() {

        $('.series-networks-slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            draggable: false,
            asNavFor: '.series-networks-slider-nav',
        });

        $('.series-networks-slider-nav').slick({
            slidesToShow: 6,
            slidesToScroll: 4,
            asNavFor: '.series-networks-slider',
            dots: false,
            arrows: true,
            nextArrow: '<a href="#" aria-label="arrow" class="slick-arrow slick-next"></a>',
            prevArrow: '<a href="#" aria-label="arrow" class="slick-arrow slick-prev"></a>',
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

        $('.series-networks-slider-nav').on('click', function() {
            $( ".drp-close" ).trigger( "click" );
            $('.series-networks-slider').show();
        });

        $('body').on('click', '.drp-close', function() {
            $('.series-networks-slider').hide();
        });
    });
</script>


@php
    include public_path('themes/theme4/views/footer.blade.php');
@endphp
@php
    $data = App\SeriesNetwork::where('in_home',1)->orderBy('order')->get()->map(function ($item) {
                $item['image_url'] = $item->image != null ? URL::to('public/uploads/seriesNetwork/'.$item->image ) : default_vertical_image_url() ;
                $item['banner_image_url'] = $item->banner_image != null ?  URL::to('public/uploads/seriesNetwork/'.$item->banner_image ) : default_horizontal_image_url();
                return $item;
            });
@endphp

@if (!empty($data) && $data->isNotEmpty())
    <section id="iq-trending" class="s-margin">
        <div class="container-fluid pl-0">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">
                                    
                                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title pl-5"><a href="{{ $order_settings_list[30]->url ? URL::to($order_settings_list[30]->url) : null }} ">{{ optional($order_settings_list[30])->header_name }}</a></h4>
                        <h4 class="main-title"><a href="{{ $order_settings_list[30]->url ? URL::to($order_settings_list[30]->url) : null }} ">{{ 'view all' }}</a></h4>
                    </div>

                    <div class="trending-contens">
                        <ul id="trending-slider-nav" class="series-networks-slider-nav list-inline p-0 ml-5 row align-items-center">
                            @foreach ($data as $series_networks)
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="movie-slick position-relative">
                                            <img src="{{ $series_networks->image_url }}" class="img-fluid" >
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <ul id="trending-slider series-networks-slider" class="list-inline p-0 m-0 align-items-center series-networks-slider">
                            @foreach ($data as $key => $series_networks )
                                <li>
                                    <div class="tranding-block position-relative trending-thumbnail-image" >
                                        <button class="drp-close">×</button>

                                        <div class="trending-custom-tab">
                                            <div class="trending-content">
                                                <div id="" class="overview-tab tab-pane fade active show">
                                                    <div class="trending-info align-items-center w-100 animated fadeInUp">

                                                        <div class="caption pl-5">
                                                                <h2 class="caption-h2">{{ optional($series_networks)->name }}</h2>

                                                            <div class="p-btns">
                                                                <div class="d-flex align-items-center p-0">
                                                                    <a href="{{ URL::to('series/category/'. $series_networks->slug) }}" class="button-groups btn btn-hover  mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Visit </a>
                                                                    {{-- <a href="#" class="btn btn-hover button-groups mr-2" tabindex="0"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a> --}}
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="dropdown_thumbnail">
                                                            <img  src="{{ $series_networks->banner_image_url  }}" alt="">
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
            slidesToScroll: 1,
            asNavFor: '.series-networks-slider',
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

        $('.series-networks-slider-nav').on('click', function() {
            $( ".drp-close" ).trigger( "click" );
            $('.series-networks-slider').show();
        });

        $('body').on('click', '.drp-close', function() {
            $('.series-networks-slider').hide();
        });
    });
</script>
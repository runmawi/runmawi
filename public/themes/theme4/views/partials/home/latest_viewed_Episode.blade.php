<?php

// latest viewed Videos

if (Auth::guest() != true) {
    $data = App\RecentView::Select('episodes.*', 'episodes.slug as episode_slug', 'series.id', 'series.slug as series_slug', 'recent_views.episode_id', 'recent_views.user_id')
        ->join('episodes', 'episodes.id', '=', 'recent_views.episode_id')
        ->join('series', 'series.id', '=', 'episodes.series_id')
        ->where('recent_views.user_id', Auth::user()->id)
        ->groupBy('recent_views.episode_id')
        ->get();
} else {
    $data = [];
}

?>

@if (!empty($data) && $data->isNotEmpty())

    <section id="iq-favorites iq-trending">
        <div class="container-fluid pl-0">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">

                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title pl-5"><a href="{{ $order_settings_list[18]->url ? URL::to($order_settings_list[18]->url) : null }} ">{{ optional($order_settings_list[18])->header_name }}</a></h4>
                        <h4 class="main-title"><a href="{{ $order_settings_list[18]->url ? URL::to($order_settings_list[18]->url) : null }} ">{{ 'view all' }}</a></h4>
                    </div>

                    <div class="trending-contens">
                        <ul id="trending-slider-nav" class="latest-videos-slider-nav list-inline p-0 ml-5 row align-items-center">
                            @foreach ($data as $key => $latest_view_episode)
                                <li >
                                    <a href="javascript:void(0);">
                                        <div  class="movie-slick position-relative">
                                            <img src="{{ $latest_view_episode->image ? URL::to('public/uploads/images/'.$latest_view_episode->image) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                         </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>


                        <ul id="trending-slider latest-videos-slider" class="list-inline p-0 m-0 align-items-center latest-videos-slider">
                            @foreach ($data as $key => $latest_view_episode)
                                <li>
                                    <div class="tranding-block position-relative trending-thumbnail-image" >
                                        <button class="drp-close">×</button>

                                        <div class="trending-custom-tab">
                                            <div class="trending-content">
                                                <div id="" class="overview-tab tab-pane fade active show">
                                                    <div class="trending-info align-items-center w-100 animated fadeInUp">

                                                        <div class="caption pl-5">
                                                                <h2 class="caption-h2">{{ optional($latest_view_episode)->title }}</h2>

                                                            <!-- @if ( $latest_view_episode->year != null && $latest_view_episode->year != 0)
                                                                <div class="d-flex align-items-center text-white text-detail">
                                                                    <span class="trending">{{ ($latest_view_episode->year != null && $latest_view_episode->year != 0) ? $latest_view_episode->year : null   }}</span>
                                                                </div>
                                                            @endif -->

                                                            @if (optional($latest_view_episode)->description)
                                                                <div class="trending-dec">{!! html_entity_decode( optional($latest_view_episode)->description) !!}</div>
                                                            @endif

                                                            <div class="p-btns">
                                                                <div class="d-flex align-items-center p-0">
                                                                    <a href="{{ URL::to('category/videos/'.$latest_view_episode->slug) }}" class="button-groups btn btn-hover mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                                    <a href="{{ URL::to('category/videos/'.$latest_view_episode->slug) }}" class="button-groups btn btn-hover mr-2" tabindex="0"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="dropdown_thumbnail">
                                                            <img  src="{{ $latest_view_episode->player_image ?  URL::to('public/uploads/images/'.$latest_view_episode->player_image) : default_horizontal_image_url() }}" alt="">
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
            slidesToShow: 1,
            initialSlide:0,
            slidesToScroll: 1,
            arrows: false,
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

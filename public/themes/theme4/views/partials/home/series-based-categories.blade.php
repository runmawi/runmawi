<?php
    $data = App\SeriesGenre::query()
        ->whereHas('category_series', function ($query) {
        })
        ->with([
            'category_series' => function ($audios_videos) {
                $audios_videos
                    ->select('series.*')
                    ->where('series.active', 1)
                    ->latest('series.created_at');
            },
        ])
        ->select('series_genre.id', 'series_genre.name', 'series_genre.slug', 'series_genre.order')
        ->orderBy('series_genre.order')
        ->get();

    $data->each(function ($category) {
        $category->category_series->transform(function ($item) {
            $item['image_url'] = URL::to('public/uploads/images/' . $item->image);
            $item['Player_image_url'] = URL::to('public/uploads/images/' . $item->player_image);
            $item['description'] = $item->description;
            $item['source'] = 'Series';
            $item['source_Name'] = 'category_series';
            return $item;
        });
        $category->source = 'Series_Genre_videos';
        return $category;
    });

?>

@if (!empty($data) && $data->isNotEmpty())

    @foreach ($data as $key => $series_genre)
        <section id="iq-favorites">
            <div class="container-fluid pl-0">
                <div class="row">
                    <div class="col-sm-12 overflow-hidden">

                        {{-- Header --}}
                        <div class="iq-main-header d-flex align-items-center justify-content-between">
                            <h4 class="main-title pl-5"><a href="">{{ optional($series_genre)->name }}</a></h4>
                            <h4 class="main-title"><a href="">{{ 'View all' }}</a></h4>
                        </div>

                        <div class="trending-contens">
                        <ul id="trending-slider-nav" class="cnt-videos-slider-nav list-inline p-0 ml-5 row align-items-center">
                            @foreach ($series_genre->category_series as $key => $series_details)
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="movie-slick position-relative">
                                            <img src="{{ $series_details->image ?  URL::to('public/uploads/images/'.$series_details->image) : default_vertical_image_url() }}" class="img-fluid" >
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <ul id="trending-slider cnt-videos-slider" class="list-inline p-0 m-0 align-items-center cnt-videos-slider">
                            @foreach ($series_genre->category_series as $key => $series_details)
                                <li>
                                    <div class="tranding-block position-relative trending-thumbnail-image" >
                                        <button class="  drp-close">×</button>

                                        <div class="trending-custom-tab">
                                            <div class="trending-content">
                                                <div id="" class="overview-tab tab-pane fade active show">
                                                    <div class="trending-info align-items-center w-100 animated fadeInUp">

                                                        <div class="caption pl-5">
                                                            <h2 class="caption-h2">{{ optional($series_details)->title }}</h2>

                                                            <!-- @if ( $series_details->year != null && $series_details->year != 0)
                                                                <div class="d-flex align-items-center text-white text-detail">
                                                                    <span class="trending">{{ ($series_details->year != null && $series_details->year != 0) ? $series_details->year : null   }}</span>
                                                                </div>
                                                            @endif -->

                                                            @if (optional($series_details)->description)
                                                                <div class="trending-dec">{!! html_entity_decode( optional($series_details)->description) !!}</div>
                                                            @endif

                                                            <div class="p-btns">
                                                                <div class="d-flex align-items-center p-0">
                                                                    <a href="{{ URL::to('play_series/' . $series_details->slug) }}" class="btn btn-hover button-groups mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                                    <a href="#" class="btn btn-hover button-groups mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> More Info </a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="dropdown_thumbnail">
                                                            <img  src="{{ $series_details->player_image ?  URL::to('public/uploads/images/'.$series_details->player_image) : default_horizontal_image_url() }}" alt="">
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
    @endforeach
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
            $( ".drp-close" ).trigger( "click" );
            $('.cnt-videos-slider').show();
        });

        $('body').on('click', '.drp-close', function() {
            $('.cnt-videos-slider').hide();
        });
    });
</script>



                        
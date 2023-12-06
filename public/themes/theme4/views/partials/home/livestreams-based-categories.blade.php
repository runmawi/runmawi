<?php

$data = App\LiveCategory::query()
    ->whereHas('category_livestream', function ($query) {
        $query->where('live_streams.active', 1)->where('live_streams.status', 1);
    })

    ->with([
        'category_livestream' => function ($live_stream_videos) {
            $live_stream_videos
                ->select('live_streams.id', 'live_streams.title', 'live_streams.slug', 'live_streams.year', 'live_streams.rating', 'live_streams.access', 'live_streams.ppv_price', 'live_streams.publish_type', 'live_streams.publish_status', 'live_streams.publish_time', 'live_streams.duration', 'live_streams.rating', 'live_streams.image', 'live_streams.featured', 'live_streams.player_image', 'live_streams.description')
                ->where('live_streams.active', 1)
                ->where('live_streams.status', 1)
                ->latest('live_streams.created_at');
        },
    ])
    ->select('live_categories.id', 'live_categories.name', 'live_categories.slug', 'live_categories.order')
    ->orderBy('live_categories.order')
    ->get();

$data->each(function ($category) {
    $category->category_livestream->transform(function ($item) {
        $item['image_url'] = URL::to('public/uploads/images/' . $item->image);
        $item['Player_image_url'] = URL::to('public/uploads/images/' . $item->player_image);
        $item['description'] = $item->description;
        $item['source'] = 'Livestream';
        return $item;
    });
    $category->source = 'live_category';
    return $category;
});

?>


@if (!empty($data) && $data->isNotEmpty())

    @foreach( $data as $key => $live_Category )
        <section id="iq-trending" class="s-margin">
            <div class="container-fluid pl-0">
                <div class="row">
                    <div class="col-sm-12 overflow-hidden">
                                        
                                        {{-- Header --}}
                        <div class="iq-main-header d-flex align-items-center justify-content-between">
                            <h4 class="main-title pl-5"><a
                                href="{{ URL::to('live/category/' . $live_Category->slug) }}">{{ optional($live_Category)->name }}</a>
                            </h4>
                            <h4 class="main-title"><a
                                href="{{ URL::to('live/category/' . $live_Category->slug) }}">{{ 'view all' }}</a>
                            </h4>
                        </div>

                        <div class="trending-contens">
                            <ul id="trending-slider-nav" class="{{ 'category-live-slider-nav list-inline p-0 ml-5 row align-items-center' }}" data-key-id="{{$key}}">

                                @foreach ($live_Category->category_livestream as $livestream_videos )
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="movie-slick position-relative">
                                                <img src="{{ $livestream_videos->image ?  URL::to('public/uploads/images/'.$livestream_videos->image) : default_vertical_image_url() }}" class="img-fluid" >
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            <ul id="trending-slider" class= "{{ 'category-live-slider list-inline p-0 m-0 align-items-center category-live-'.$key }}" >
                                @foreach ($live_Category->category_livestream as $livestream_videos )
                                    <li>
                                        <div class="tranding-block position-relative home-page-bg-img" >
                                            <button class="drp-close">×</button>

                                            <div class="trending-custom-tab">
                                                <div class="trending-content">
                                                    <div id="" class="overview-tab tab-pane fade active show">
                                                        <div class="trending-info align-items-center w-100 animated fadeInUp">

                                                            <div class="caption pl-5">
                                                                <h2 class="caption-h2">{{ optional($livestream_videos)->title }}</h1>

                                                                @if ( $livestream_videos->year != null && $livestream_videos->year != 0 )
                                                                    <div class="d-flex align-items-center text-white text-detail">
                                                                        <span class="trending">{{ ($livestream_videos->year != null && $livestream_videos->year != 0) ? $livestream_videos->year : null   }}</span>
                                                                    </div>
                                                                @endif
                                                                                                                            
                                                                @if ( optional($livestream_videos)->description )
                                                                    <p class="trending-dec">{!! html_entity_decode( optional($livestream_videos)->description) !!}</p>
                                                                @endif

                                                                <div class="p-btns">
                                                                    <div class="d-flex align-items-center p-0">
                                                                        <a href="{{ URL::to('live/' . $livestream_videos->slug) }}" class="btn btn-hover mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                                        <a href="#" class="btn btn-hover mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> More Info </a>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="dropdown_thumbnail">
                                                                <img  src="{{ $livestream_videos->player_image ?  URL::to('public/uploads/images/'.$livestream_videos->player_image) : default_horizontal_image_url() }}" alt="">
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
        $('.category-live-slider').hide();
    });

    $(document).ready(function() {

        $('.category-live-slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            draggable: false,
            asNavFor: '.category-live-slider-nav',
        });

        $('.category-live-slider-nav').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            asNavFor: '.category-live-slider',
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
        
        $('.category-live-slider-nav').click(function() {

            $( ".drp-close" ).trigger( "click" );

             let category_key_id = $(this).attr("data-key-id");
             $('.category-live-slider').hide();
             $('.category-live-' + category_key_id).show();
        });

        $('body').on('click', '.drp-close', function() {
            $('.category-live-slider').hide();
        });
    });
</script>
<?php

$data = App\LiveCategory::query()->limit(15)
    ->whereHas('category_livestream', function ($query) {
        $query->where('live_streams.active', 1)->where('live_streams.status', 1);
    })

    ->with([
        'category_livestream' => function ($live_stream_videos) {
            $live_stream_videos
                ->select('live_streams.id', 'live_streams.title', 'live_streams.slug', 'live_streams.year', 'live_streams.rating', 'live_streams.access', 'live_streams.ppv_price', 'live_streams.publish_type', 
                        'live_streams.publish_status', 'live_streams.publish_time', 'live_streams.duration', 'live_streams.rating', 'live_streams.image', 'live_streams.featured', 'live_streams.player_image', 
                        'live_streams.description','live_streams.recurring_program','live_streams.program_start_time','live_streams.program_end_time','live_streams.recurring_timezone',
                        'live_streams.custom_start_program_time','live_streams.recurring_timezone')
                ->where('live_streams.active', 1)
                ->where('live_streams.status', 1)
                ->latest('live_streams.created_at')
                ->limit(15);
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
                            <h4 class="main-title mar-left"><a
                                href="{{ URL::to('live/category/' . $live_Category->slug) }}">{{ optional($live_Category)->name }}</a>
                            </h4>
                            <h4 class="main-title"><a
                                href="{{ URL::to('live/category/' . $live_Category->slug) }}">{{ 'view all' }}</a>
                            </h4>
                        </div>

                        <div class="trending-contens">
                            <ul id="trending-slider-nav" class="{{ 'category-live-slider-nav list-inline p-0 mar-left row align-items-center' }}" data-key-id="{{$key}}">

                                @foreach ($live_Category->category_livestream as $livestream_videos )
                                    <li class="slick-slide">
                                        <a href="javascript:;">
                                            <div class="movie-slick position-relative">
                                                    <img src="{{ $livestream_videos->image ?  URL::to('public/uploads/images/'.$livestream_videos->image) : $default_vertical_image_url }}" class="img-fluid" alt="livestream_videos" width="300" height="200">
                                            </div>
                                            
                                            @if ($livestream_videos->publish_type == "publish_now" || ($livestream_videos->publish_type == "publish_later" && Carbon\Carbon::today()->now()->greaterThanOrEqualTo($livestream_videos->publish_time))) 
                                                <div ><img class="blob" src="public\themes\theme4\views\img\Live-Icon.png" alt="livestream_videos" width="100%"></div>
                                            @endif
                                        </a>
                                    </li>


                                @endforeach
                            </ul>

                            <ul id="trending-slider" class= "{{ 'theme4-slider category-live-slider list-inline p-0 m-0 align-items-center category-live-'.$key }}" style="display:none;">
                                @foreach ($live_Category->category_livestream as $livestream_videos )
                                    <li class="slick-slide">
                                        <div class="tranding-block position-relative home-page-bg-img trending-thumbnail-image">
                                            <button class="drp-close">×</button>

                                            <div class="trending-custom-tab">
                                                <div class="trending-content">
                                                    <div id="" class="overview-tab tab-pane fade active show h-100">
                                                        <div class="trending-info align-items-center w-100 animated fadeInUp">

                                                            <div class="caption pl-4">
                                                                <h2 class="caption-h2">{{ optional($livestream_videos)->title }}</h1>

                                                                @if ($livestream_videos->publish_type == "publish_now" || ($livestream_videos->publish_type == "publish_later" && Carbon\Carbon::today()->now()->greaterThanOrEqualTo($livestream_videos->publish_time))) 
                                                                    <ul class="vod-info">
                                                                        <li><span></span> LIVE NOW</li>
                                                                    </ul>
                                                                @elseif ($livestream_videos->publish_type == "publish_later")
                                                                    <span class="trending"> {{ 'Live Start On '. Carbon\Carbon::parse($livestream_videos->publish_time)->isoFormat('YYYY-MM-DD h:mm A') }} </span>
                                                                
                                                                @elseif ( $livestream_videos->publish_type == "recurring_program" && $livestream_videos->recurring_program != "custom" )
                                                                    <span class="trending"> {{ 'Live Streaming '. $livestream_videos->recurring_program ." from ". Carbon\Carbon::parse($livestream_videos->program_start_time)->isoFormat('h:mm A') ." to ". Carbon\Carbon::parse($livestream_videos->program_end_time)->isoFormat('h:mm A') . ' - ' . App\TimeZone::where('id', $livestream_videos->recurring_timezone)->pluck('time_zone')->first() }} </span>
    
                                                                @elseif ( $livestream_videos->publish_type == "recurring_program" && $livestream_videos->recurring_program == "custom" )
                                                                    <span class="trending"> {{ 'Live Streaming On '. Carbon\Carbon::parse($livestream_videos->custom_start_program_time)->format('j F Y g:ia') . ' - ' . App\TimeZone::where('id', $livestream_videos->recurring_timezone)->pluck('time_zone')->first() }} </span>
                                                                @endif

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
                                                                        <a href="{{ URL::to('live/'.$livestream_videos->slug) }}" class="button-groups btn btn-hover mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                                        <a href="#" class="button-groups btn btn-hover mr-2" tabindex="0" data-bs-toggle="modal" data-bs-target="{{ '#Home-Livestream-basedcategory-Modal-'.$key }}"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="dropdown_thumbnail">
                                                                    <img  src="{{ $livestream_videos->player_image ?  URL::to('public/uploads/images/'.$livestream_videos->player_image) : $default_horizontal_image_url }}" alt="livestream_videos">
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


            @foreach ($data as $key => $livestream_videos )
            <div class="modal fade info_model" id="{{ "Home-Livestream-basedcategory-Modal-".$key }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                    <div class="container">
                        <div class="modal-content" style="border:none; background:transparent;">
                            <div class="modal-body">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <img  src="{{ $livestream_videos->player_image ?  URL::to('public/uploads/images/'.$livestream_videos->player_image) : $default_horizontal_image_url }}" alt="modal">
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-10 col-md-10 col-sm-10">
                                                    <h2 class="caption-h2">{{ optional($livestream_videos)->title }}</h2>

                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-2">
                                                    <button type="button" class="btn-close-white" aria-label="Close"  data-bs-dismiss="modal">
                                                        <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                            

                                            @if (optional($livestream_videos)->description)
                                                <div class="trending-dec mt-4">{!! html_entity_decode( optional($livestream_videos)->description) !!}</div>
                                            @endif

                                            <a href="{{ URL::to('live/'.$livestream_videos->slug) }}" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0" ><i class="far fa-eye mr-2" aria-hidden="true"></i> View Content </a>
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
            slidesToScroll: 6,
            asNavFor: '.category-live-slider',
            dots: false,
            arrows: true,
            prevArrow: '<a href="#" class="slick-arrow slick-prev" aria-label="Previous" type="button">Previous</a>',
            nextArrow: '<a href="#" class="slick-arrow slick-next" aria-label="Next" type="button">Next</a>',
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

<style>

    .blob {
        margin: 10px;
        height: 22px;
        width: 59px;
        box-shadow: 0 0 0 0 rgba(255, 0, 0, 1);
        transform: scale(1);
        animation: pulse 2s infinite;
        position:absolute;
        top:0;
    }
    
    @keyframes pulse {
        0% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(0, 0, 0, 0.7);
        }
    
        70% {
            transform: scale(1);
            box-shadow: 0 0 0 10px rgba(0, 0, 0, 0);
        }
    
        100% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(0, 0, 0, 0);
        }
    }
    </style>
@php
    include(public_path('themes/theme3/views/header.php'));
    $currency = App\CurrencySetting::first();
@endphp
<style>
    .card-image {
        height: 124px;
        width: 124px;
        padding: 24px 8px 16px;
        -webkit-margin-end: 12px;
        margin-inline-end: 12px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        background: transparent;
        border-radius: 8px;
        overflow: hidden;
    }

    @media (min-width: 550px) {
        .card-image {
            height: 146px;
            width: 146px;
            -webkit-margin-end: 16px;
            margin-inline-end: 16px;
            display: flex;
            align-items: center;
            justify-content: space-evenly;
        }
    }

    @media (min-width: 550px) {
        .card__text {
            font-size: 14px;
            line-height: 19px;
        }
    }

    .card_image {
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card_text {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        font-size: 15px;
        font-weight: 400;
        line-height: 18px;
        text-align: center;
        max-height: 38px;
        color: #c6c8cd;
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
    }
    .category-cover {
        z-index: 0;
        height: 100%;
        top: 0;
        right: 0;
        overflow: hidden;
        width: 74%;
        mask-image: -webkit-gradient(linear, left top, right top, from(transparent), color-stop(50%, black));
        mask-image: linear-gradient(to right, transparent 0%, black 50%);
        -webkit-mask-image: -webkit-gradient(linear, left top, right top, from(transparent), color-stop(50%, black));
        -webkit-mask-image: linear-gradient(to right, transparent 0%, black 50%);
        position: absolute;
        pointer-events: none;
        
    }
    h3.vsub {font-size: 20px;}

</style>

<div class="main-content ">
    <section id="iq-trending">
        <div class="container-fluid">
            <div class="row ">
            <div class="col-sm-12 iq-main-header d-flex align-items-center justify-content-between h-250" style="height: 250px;">
                    <div class="caption">
                        <h2>{{ optional($parentCategories)->name }}</h2> 
                    </div>
                    <div class="category-cover">
                        <img class="w-100 img-responsive" src="{{ $parentCategories->image ? URL::to('public/uploads/livecategory/' . $parentCategories->image) : default_vertical_image_url() }}" />
                    </div>
                </div> 
            </div>
        </div>
    </section>

    <section id="iq-trending" class="s-margin">
        <div class="container-fluid pl-0">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">
                                    
                    <div class="trending-contens">
                        <ul id="trending-slider-nav" class="livestream-videos-slider-nav list-inline p-0 ml-5 row align-items-center">
                            @foreach ($live_videos as $livestream_videos)
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="movie-slick position-relative">
                                            <img src="{{ $livestream_videos->image ?  URL::to('public/uploads/images/'.$livestream_videos->image) : default_vertical_image_url() }}" class="img-fluid" >
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <ul id="trending-slider" class="list-inline p-0 m-0  align-items-center livestream-videos-slider">
                            @foreach ($live_videos as $key => $livestream_videos )
                                <li>
                                    <div class="tranding-block position-relative trending-thumbnail-image"                                        >
                                        <button class="drp-close">×</button>

                                        <div class="trending-custom-tab">
                                            <div class="trending-content">
                                                <div id="" class="overview-tab tab-pane fade active show">
                                                    <div class="trending-info align-items-center w-100 animated fadeInUp">

                                                        <div class="caption pl-5">
                                                                <h2 class="caption-h2">{{ optional($livestream_videos)->title }}</h2>

                                                            @if ($livestream_videos->publish_type == "publish_now" || ($livestream_videos->publish_type == "publish_later" && Carbon\Carbon::today()->now()->greaterThanOrEqualTo($livestream_videos->publish_time))) 
                                                                <ul class="vod-info">
                                                                    <li><span></span> LIVE NOW</li>
                                                                </ul>
                                                            @elseif ($livestream_videos->publish_type == "publish_later")
                                                                <span class="trending"> {{ 'Live Start On '. Carbon\Carbon::parse($livestream_videos->publish_time)->isoFormat('YYYY-MM-DD h:mm A') }} </span>
                                                            @endif

                                                            <div class="trending-dec">{!! html_entity_decode( $livestream_videos->description ) ?  $livestream_videos->description : " No description Available" !!}</div>
                                                        
                                                            <div class="p-btns">
                                                                <div class="d-flex align-items-center p-0">
                                                                    <a href="{{ URL::to('live/'.$livestream_videos->slug) }}" class="button-groups btn btn-hover mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                                    <a href="{{ URL::to('live/'.$livestream_videos->slug) }}" class="button-groups btn btn-hover mr-2" tabindex="0"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a>
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
</div>

<script>
    
    $( window ).on("load", function() {
        $('.livestream-videos-slider').hide();
    });

    $(document).ready(function() {

        $('.livestream-videos-slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            draggable: false,
            asNavFor: '.livestream-videos-slider-nav',
        });

        $('.livestream-videos-slider-nav').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            asNavFor: '.livestream-videos-slider',
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

        $('.livestream-videos-slider-nav').on('click', function() {
            $( ".drp-close" ).trigger( "click" );
            $('.livestream-videos-slider').show();
        });

        $('body').on('click', '.drp-close', function() {
            $('.livestream-videos-slider').hide();
        });
    });
</script>

@php
    include(public_path('themes/theme3/views/footer.blade.php'));
@endphp
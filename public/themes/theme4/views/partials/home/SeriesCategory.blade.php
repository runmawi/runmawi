<?php include public_path('themes/theme4/views/header.php'); ?>

<style>
    .main-content{
        overflow: hidden;
    }
    /* <!-- BREADCRUMBS  */
    .bc-icons-2 .breadcrumb-item+.breadcrumb-item::before {
        content: none;
    }

    ol.breadcrumb {
        color: white;
        background-color: transparent !important;
        font-size: revert;
    }

    
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
    .position-rel{
        position: relative;
    }
    .position-absu{
        position:absolute;
    }
   
</style>


<div class="main-content p-0">
    <section id="iq-trending">
        <div class="container-fluid p-0">
            <div class=" pl-5">
                 <!-- BREADCRUMBS -->
                 <div class="position-absu p-0">
                    <div class="container-fluid nav-div m-0 p-0" id="nav-tab" role="tablist">
                        <div class="bc-icons-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="black-text"
                                        href="{{ route('series.tv-shows') }}">{{ ucwords('Channel') }}</a>
                                    <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                                </li>

                                <li class="breadcrumb-item"><a class="black-text"
                                        href="{{ route('SeriescategoryList') }}">{{ ucwords('category') }}</a>
                                    <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                                </li>

                                <li class="breadcrumb-item">
                                    <a class="black-text">
                                        {{ strlen($CategorySeries->name) > 50 ? ucwords(substr($CategorySeries->name, 0, 120) . '...') : ucwords($CategorySeries->name) }}
                                    </a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            <div class="col-sm-12 iq-main-header d-flex align-items-center justify-content-between h-250 position-rel" style="height: 250px;">
                    <div class="caption">
                        <h2>{{ optional($CategorySeries)->name }}</h2> 
                    </div>
                    <div class="category-cover">
                        <img class="w-100 img-responsive" src="{{ $CategorySeries->image ? URL::to('public/uploads/videocategory/' . $CategorySeries->image) : default_vertical_image_url() }}" />
                    </div>
                </div> 
            </div>
        </div>
    </section>

    


        <section id="iq-favorites ">
            <div class="container-fluid pl-0">
                <div class="row">
                    <div class="col-sm-12 page-height pr-0">
                        <div class="iq-main-header align-items-center justify-content-between">
                            <h4 class="movie-title pl-5">{{ @$CategorySeries->name }}</h4>
                        </div>

                    

                        <div class="favorites-contens">
                            <ul id="trending-slider-nav" class="latest-videos-slider-nav list-inline pl-5 m-0 row align-items-center">
                                @if (isset($SeriesGenre))
                                    @foreach ($SeriesGenre as $Series_Genre)
                                        <li>
                                            <a href="javascript:void(0);">
                                                <div class="movie-slick position-relative">
                                                    <img src="{{ URL::to('/public/uploads/images/' . @$Series_Genre->image) }}" class="img-fluid" >
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>

                            <ul id="trending-slider latest-videos-slider" class="list-inline p-0 m-0 align-items-center latest-videos-slider">
                            @if (isset($SeriesGenre))
                                    @foreach ($SeriesGenre as $Series_Genre)
                                    <li>
                                        <div class="tranding-block position-relative trending-thumbnail-image">
                                            <button class="drp-close">×</button>

                                            <div class="trending-custom-tab">
                                                <div class="trending-content">
                                                    <div id="" class="overview-tab tab-pane fade active show">
                                                        <div class="trending-info align-items-center w-100 animated fadeInUp">
                                                            <div class="caption pl-5">
                                                            <h2 class="caption-h2">{{ strlen(@$Series_Genre->title) > 17 ? substr(@$Series_Genre->title, 0, 18) . '...' : @$Series_Genre->title }}</h2>
                                                                @if (optional($Series_Genre)->description)
                                                                        <div class="trending-dec">{!! html_entity_decode( optional($Series_Genre)->description) !!}</div>
                                                                    @endif

                                                                <div class="p-btns">
                                                                        <div class="d-flex align-items-center p-0">
                                                                            <a href="{{ URL::to('category/videos/'.$Series_Genre->slug) }}" class="button-groups btn btn-hover  mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                                            <a href="{{ URL::to('category/videos/'.$Series_Genre->slug) }}" class="btn btn-hover button-groups mr-2" tabindex="0"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                            <div class="dropdown_thumbnail">
                                                                    <img  src="{{ URL::to('/public/uploads/images/' . @$Series_Genre->image) }}" alt="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                @endif
                            </ul>

                            

                            
                        </div>
                    </div>
                </div>
            </div>
        </section>
</div>


<script>
    
    $( window ).on("load", function() {
        $('.latest-videos-slider').hide();
    });

    $(document).ready(function() {

        $('.latest-videos-slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
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


<?php
    include public_path('themes/default/views/footer.blade.php');
?>
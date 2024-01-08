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
    .bc-icons-2 {
    font-size: 13px;
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
        z-index: 9;
    }

    .controls{
        opacity: 0;
    }
    
    .sub_dropdown_image li:hover .controls {
        opacity: 1;
        background-image: linear-gradient(0deg, black, transparent);
        border: 2px solid #2578c0 !important;
        
    }
    
     .controls{
        position: absolute;
        padding: 4px;
        top: 0px;
        right: 0px;
        bottom: 0px;
        left: 0px;
        width:100%;
        z-index: 3;
        opacity: 0;
        -webkit-transition: all 0.15s ease;
        transition: all 0.15s ease;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
    }
    
     .playBTN{
        font-size: 20px;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        line-height: 1;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        border-radius: 50%;
        color: #fff;
        border: none;
        background-color: rgba(51, 51, 51, 0.4);
        -webkit-transition: background-color 0.15s ease;
        transition: background-color 0.15s ease;
        cursor: pointer;
        outline: none;
        padding: 0;
        position: absolute;
        top: 50%;
        left: 50%;
        width: 50px;
        height: 50px;
        -webkit-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }
    
      .playBTN:hover{
        background-color: #fff;
        color: #000;
    }
    
      .playBTN i{
        position: relative;
        left: 2px;
        top: 1px;
    }
    .moreBTN:hover span {
        width: auto;
        margin-left: 4px;
    }
    
    .controls .trending-dec{
        margin: auto 0 0;
        color: #fff;
        padding: 2px;
        font-size: calc(12px + 0.15vw);
        width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 17px;
    }
    .controls nav {
        position: absolute;
        -webkit-box-align: end;
        -ms-flex-align: end;
        align-items: flex-end;
        right: 4px;
        top: 4px;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
    }
    .moreBTN {
        color: #fff;
        -webkit-box-flex: 1;
        -ms-flex: 1;
        flex: 1;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        justify-items: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        background-color: rgba(51, 51, 51, 0.4);
        border: none;
        padding: 8px;
        border-radius: 4px;
        -webkit-box-shadow: none;
        box-shadow: none;
        font-size: calc(12px + 0.25vmin);
        font-weight: bold;
        -webkit-transition: all 0.2s ease;
        transition: all 0.2s ease;
        cursor: pointer;
        outline: none;
        line-height: 14px;
    }
    .moreBTN:hover {
        background-color: #fff;
        color: #000;
    }
    .moreBTN span {
        width: 0;
        margin-left: 0;
        overflow: hidden;
        white-space: nowrap;
        display: inline-block;
    }
   
</style>


<div class="main-content p-0">
    <section id="iq-favorites ">
        <div class="container-fluid p-0">
            <div class=" mar-left">
                 <!-- BREADCRUMBS -->
                 <div class="position-absu p-0">
                    <div class="container-fluid nav-div m-0 p-0" id="nav-tab" role="tablist">
                        <div class="bc-icons-2">
                            <ol class="breadcrumb pl-0">
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
            <div class="col-sm-12 iq-main-header d-flex align-items-center justify-content-between h-250 position-rel pl-0" style="height: 250px;">
                    <div class="caption">
                        <h2>{{ optional($CategorySeries)->name }}</h2> 
                    </div>
                    <div class="dropdown_thumbnail" >
                        <img class="w-100 img-responsive" src="{{ $CategorySeries->banner_image ? URL::to('public/uploads/videocategory/' . $CategorySeries->banner_image) : default_vertical_image_url() }}" style="object-fit: cover; height: 350px;" />
                    </div>
                </div> 
            </div>
        </div>

        <div class="container-fluid pl-0 mar-left">
            <div class="row">
                <div class="col-sm-12 page-height pr-0">
                    <div class="favorites-contens">
                        <ul id="trending-slider-nav" class="series-category-slider-nav list-inline mar-left m-0 row align-items-center">
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

                        <ul id="trending-slider series-category-slider" class="list-inline p-0 m-0 align-items-center series-category-slider">
                            @if (isset($SeriesGenre))
                                @foreach ($SeriesGenre as $Series_Genre)
                                    <li>
                                        <div class="tranding-block position-relative trending-thumbnail-image">
                                            <button class="drp-close">×</button>

                                            <div class="trending-custom-tab">
                                                <div class="trending-content">
                                                    <div id="" class="overview-tab tab-pane fade active show">
                                                        <div class="trending-info align-items-center w-100 animated fadeInUp">
                                                            <div class="caption pl-4">
                                                            <h2 class="caption-h2">{{ strlen(@$Series_Genre->title) > 17 ? substr(@$Series_Genre->title, 0, 18) . '...' : @$Series_Genre->title }}</h2>
                                                                @if (optional($Series_Genre)->description)
                                                                    <div class="trending-dec">{!! html_entity_decode( optional($Series_Genre)->description) !!}</div>
                                                                @endif

                                                                <div class="p-btns">
                                                                    <div class="d-flex align-items-center p-0">
                                                                        <a href="{{ URL::to('play_series/'.$Series_Genre->slug) }}" class="button-groups btn btn-hover  mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                                        <a href="{{ URL::to('play_series/'.$Series_Genre->slug) }}" class="btn btn-hover button-groups mr-2" tabindex="0"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="trending-contens sub_dropdown_image mt-3">
                                                                <ul id="trending-slider-nav" class= "{{ 'pl-4 m-0  series-depends-episode-slider' }}" >
                                                                    @foreach ($Series_Genre->Series_depends_episodes as $episode )
                                                                        <li>
                                                                            <a href="{{ URL::to('episode/'.$Series_Genre->slug.'/'.$episode->slug ) }}">
                                                                                <div class=" position-relative">
                                                                                    <img src="{{ $episode->image_url }}" class="img-fluid" >
                                                                                    <div class="controls">
                                                                                        <a href="{{ URL::to('episode/'.$Series_Genre->slug.'/'.$episode->slug ) }}">
                                                                                            <button class="playBTN"> <i class="fas fa-play"></i></button>
                                                                                        </a>

                                                                                        <nav>
                                                                                            <button class="moreBTN"><i class="fas fa-info-circle"></i><span>More info</span></button>
                                                                                        </nav>
                                                                                        
                                                                                        @php
                                                                                            $series_seasons_name = App\SeriesSeason::where('id',$episode->season_id)->pluck('series_seasons_name')->first() ;
                                                                                        @endphp
                                                                                        
                                                                                        <p class="trending-dec" >

                                                                                            @if ( !is_null($series_seasons_name) )
                                                                                                {{ "Season - ". $series_seasons_name  }}  <br>
                                                                                            @endif

                                                                                            {{ "Episode - " . optional($episode)->title  }} <br>

                                                                                            {!! (strip_tags(substr(optional($episode)->episode_description, 0, 50))) !!}
                                                                                        </p>

                                                                                    </div>
                                                                                </div>
                                                                            </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
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
        $('.series-category-slider').hide();
    });

    $(document).ready(function() {

        $('.series-category-slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            fade: true,
            draggable: false,
            asNavFor: '.series-category-slider-nav',
        });

        $('.series-category-slider-nav').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            asNavFor: '.series-category-slider',
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

        $('.series-category-slider-nav').on('click', function() {
            $( ".drp-close" ).trigger( "click" );
            $('.series-category-slider').show();

            $('.series-depends-episode-slider').slick({
                dots: false,
                infinite: false,
                speed: 300,
                slidesToShow: 6,
                slidesToScroll: 4,
            });
        });

        $('body').on('click', '.drp-close', function() {
            $('.series-category-slider').hide();
        });
    });
</script>

@php
    include public_path('themes/default/views/footer.blade.php');
@endphp
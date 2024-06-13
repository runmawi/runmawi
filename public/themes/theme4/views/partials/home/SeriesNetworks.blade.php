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
    .favorites-slider .slick-prev, #trending-slider-nav .slick-prev,#trending-slider-nav .slick-next{top:30%;}
   
</style>


<div class="main-content p-0">
    <section id="iq-favorites ">
        <div class="container-fluid p-0">
            <div class="">
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
                                        {{ strlen($series_data->name) > 50 ? ucwords(substr($series_data->name, 0, 120) . '...') : ucwords($series_data->name) }}
                                    </a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            <div class="col-sm-12 iq-main-header d-flex align-items-center justify-content-between h-250 position-rel" style="height: 60vh;">
                    <div class="caption">
                        <h2>{{ optional($series_data)->name }}</h2> 
                    </div>
                    <div class="dropdown_thumbnail" >
                            <img class="w-100 img-responsive" src="{{ $series_data->banner_image ? URL::to('public/uploads/seriesNetwork/' . $series_data->banner_image) : $default_vertical_image_url }}" alt="Videos" style="object-fit: cover; height: 350px;" />
                    </div>
                </div> 
            </div>
        </div>

        <div class="container-fluid pl-0">
            <div class="row">
                <div class="col-sm-12 page-height pr-0">
                    <div class="favorites-contens">
                        @if (isset($series_data->Series_depends_Networks))

                            <div id="tv-networks" class="channels-list">
                                <!-- top slider -->
                                <div class="channel-row">
                                    <div id="trending-slider-nav" class="video-list series-networkpage-video" data-flickity>
                                        @foreach ($series_data->Series_depends_Networks as $key => $Series_Genre)
                                            <div class="item" data-index="{{ $key }}">
                                                <div>
                                                    <img src="{{ URL::to('/public/uploads/images/' . @$Series_Genre->image) }}" class="flickity-lazyloaded" alt="latest_series"  width="300" height="200">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- dropdown content -->
                                <div id="videoInfo" class="series-networkpage-dropdown" style="display:none;">
                                    <button class="drp-close">×</button>
                                    <div class="vib" style="display:block;">
                                        @foreach ($series_data->Series_depends_Networks as $key => $Series_Genre)
                                            <div class="w-100">
                                                <div class="caption" data-index="{{ $key }}">
                                                    <h2 class="caption-h2">{{ strlen(@$Series_Genre->title) > 17 ? substr(@$Series_Genre->title, 0, 18) . '...' : @$Series_Genre->title }}</h2>
                                                    @if (optional($Series_Genre)->description)
                                                        <div class="trending-dec">{!! html_entity_decode(strip_tags( optional($Series_Genre)->description)) !!}</div>
                                                    @endif

                                                    <div class="p-btns">
                                                        <div class="d-flex align-items-center p-0">
                                                            <a href="{{ route('network.play_series',$Series_Genre->slug) }}" class="button-groups btn btn-hover  mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                            <a href="{{ route('network.play_series',$Series_Genre->slug) }}" class="btn btn-hover button-groups mr-2" tabindex="0"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="thumbnail" data-index="{{ $key }}">
                                                    <img src="{{ URL::to('/public/uploads/images/' . @$Series_Genre->image) }}" class="flickity-lazyloaded" alt="latest_series" width="300" height="200">
                                                </div>

                                                <!-- depend slider -->
                                                <div id="{{ 'trending-slider-nav' }}" class="{{ 'network-depends-slider networks-depends-series-slider-'.$key .' content-list'}}" data-index="{{ $key }}" >
                                                    @foreach ($Series_Genre->Series_depends_episodes as $episode_key => $episode ) 
                                                        <div class="depends-row">
                                                            <div class="depend-items">
                                                                <a href="{{ URL::to('networks/episode/'.$Series_Genre->slug.'/'.$episode->slug ) }}">
                                                                    <div class=" position-relative">
                                                                        <img src="{{ $episode->image_url }}" class="img-fluid" alt="Videos">
                                                                        <div class="controls">
                                                                            <a href="{{ URL::to('networks/episode/'.$Series_Genre->slug.'/'.$episode->slug ) }}">
                                                                                <button class="playBTN"> <i class="fas fa-play"></i></button>
                                                                            </a>

                                                                            <nav ><button class="moreBTN" tabindex="0" data-bs-toggle="modal" data-bs-target="{{ '#Home-SeriesNetwork-series-Modal-'.$key.'-'.$episode_key  }}"><i class="fas fa-info-circle"></i><span>More info</span></button></nav>

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
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @foreach ($series_data->Series_depends_Networks as $key => $Series_Genre)
            @foreach ($Series_Genre->Series_depends_episodes as $episode_key => $episode )
                <div class="modal fade info_model" id="{{ 'Home-SeriesNetwork-series-Modal-'.$key.'-'.$episode_key  }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                        <div class="container">
                            <div class="modal-content" style="border:none; background:transparent;">
                                <div class="modal-body">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                    <img class="lazy" src="{{ URL::to('public/uploads/images/'.$episode->player_image) }}" alt="{{ $episode->title }}">
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-lg-10 col-md-10 col-sm-10">
                                                        <h2 class="caption-h2">{{ optional($episode)->title }}</h2>
                                                    </div>

                                                    <div class="col-lg-2 col-md-2 col-sm-2">
                                                        <button type="button" class="btn-close-white" aria-label="Close"  data-bs-dismiss="modal">
                                                            <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                        </button>
                                                    </div>
                                                </div>
                                                
                                                <p class="trending-dec mt-3" >
                                                    @if ( !is_null($series_seasons_name) )
                                                        {{ "Season - ". $series_seasons_name  }}  <br>
                                                    @endif
                                                </p>
                                                <p class="trending-dec mt-3" >
                                                    {!! (strip_tags(optional($episode)->episode_description)) !!}
                                                </p>

                                                <a href="{{ URL::to('networks/episode/'.$Series_Genre->slug.'/'.$episode->slug ) }}" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0" ><i class="far fa-eye mr-2" aria-hidden="true"></i> View Content </a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach
    </section>
</div>


<script>
    var elem = document.querySelector('.series-networkpage-video');
    var flkty = new Flickity(elem, {
        cellAlign: 'left',
        contain: true,
        groupCells: true,
        pageDots: false,
        draggable: true,
        freeScroll: true,
        imagesLoaded: true,
        lazyload: true,
    });

    document.querySelectorAll('.series-networkpage-video .item').forEach(function(item) {
        item.addEventListener('click', function() {
            document.querySelectorAll('.series-networkpage-video .item').forEach(function(item) {
                item.classList.remove('current');
            });

            this.classList.add('current');

            var index = this.getAttribute('data-index');

            document.querySelectorAll('.series-networkpage-dropdown .caption').forEach(function(caption) {
                caption.style.display = 'none';
            });
            document.querySelectorAll('.series-networkpage-dropdown .thumbnail').forEach(function(thumbnail) {
                thumbnail.style.display = 'none';
            });

            document.querySelectorAll('.series-networkpage-dropdown .network-depends-slider').forEach(function(slider) {
                slider.style.display = 'none';
            });

            var selectedSlider = document.querySelector('.series-networkpage-dropdown .network-depends-slider[data-index="' + index + '"]');
            if (selectedSlider) {
                selectedSlider.style.display = 'block';
                setTimeout(function() { // Ensure the element is visible before initializing Flickity
                    var flkty = new Flickity(selectedSlider, {
                        cellAlign: 'left',
                        contain: true,
                        groupCells: true,
                        adaptiveHeight: true,
                        pageDots: false,
                    });
                }, 0);
            }

            var selectedCaption = document.querySelector('.series-networkpage-dropdown .caption[data-index="' + index + '"]');
            var selectedThumbnail = document.querySelector('.series-networkpage-dropdown .thumbnail[data-index="' + index + '"]');
            if (selectedCaption && selectedThumbnail) {
                selectedCaption.style.display = 'block';
                selectedThumbnail.style.display = 'block';
            }

            document.getElementsByClassName('series-networkpage-dropdown')[0].style.display = 'flex';
        });
    });

    $('body').on('click', '.drp-close', function() {
        $('.series-networkpage-dropdown').hide();
    });
</script>

@php
    include public_path('themes/theme4/views/footer.blade.php');
@endphp
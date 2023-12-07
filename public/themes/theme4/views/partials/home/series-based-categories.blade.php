<?php

    $data = App\SeriesGenre::query()->whereHas('category_series', function ($query) {})
        ->with([
            'category_series' => function ($series) {
                $series->select('series.*')->where('series.active', 1)->latest('series.created_at');
            },
        ])
        ->select('series_genre.id', 'series_genre.name', 'series_genre.slug', 'series_genre.order')
        ->orderBy('series_genre.order')
        ->get();

    $data->each(function ($category) {
        $category->category_series->transform(function ($item) {

            $item['image_url']        = !is_null($item->image)  ? URL::to('public/uploads/images/'.$item->image) : default_vertical_image() ;
            $item['Player_image_url'] = !is_null($item->player_image)  ? URL::to('public/uploads/images/'.$item->player_image ) : default_horizontal_image_url() ;

            $item['upload_on'] =  Carbon\Carbon::parse($item->created_at)->isoFormat('MMMM Do YYYY'); 

            $item['duration_format'] =  !is_null($item->duration) ?  Carbon\Carbon::parse( $item->duration)->format('G\H i\M'): null ;

            $item['Series_depends_episodes'] = App\Series::find($item->id)->Series_depends_episodes
                                                    ->map(function ($item) {
                                                        $item['image_url']  = !is_null($item->image) ? URL::to('public/uploads/images/'.$item->image) : default_vertical_image() ;
                                                        return $item;
                                                });

            $item['source'] = 'Series';
            return $item;
        });
        $category->source = 'Series_Genre';
        return $category;
    });
?>

@if (!empty($data) && $data->isNotEmpty())

    @foreach( $data as $key => $series_genre )
        <section id="iq-trending" class="s-margin">
            <div class="container-fluid pl-0">
                <div class="row">
                    <div class="col-sm-12 overflow-hidden">
                                        
                                        {{-- Header --}}
                        <div class="iq-main-header d-flex align-items-center justify-content-between">
                            <h4 class="main-title pl-5"><a href="{{ route('SeriesCategory',[$series_genre->slug] )}}">{{ optional($series_genre)->name }}</a></h4>
                            <h4 class="main-title pl-5"><a href="{{ route('SeriesCategory',[$series_genre->slug] )}}">{{ "view all" }}</a></h4>
                        </div>

                        <div class="trending-contens">
                            <ul id="trending-slider-nav" class="{{ 'series-genre-videos-slider-nav list-inline p-0 ml-5 row align-items-center' }}" data-key-id="{{$key}}">

                                @foreach ($series_genre->category_series as $series )
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="movie-slick position-relative">
                                                <img src="{{ $series->image_url }}" class="img-fluid" >
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            <ul id="trending-slider" class= "{{ 'series-genre-videos-slider list-inline p-0 m-0 align-items-center category-series-'.$key }}" >
                                @foreach ($series_genre->category_series as $series )
                                    <li>
                                        <div class="tranding-block position-relative trending-thumbnail-image" >
                                            <button class="drp-close">×</button>
                                            <div class="trending-custom-tab">
                                                <div class="trending-content">
                                                    <div id="" class="overview-tab tab-pane fade active show">
                                                        <div class="trending-info align-items-center w-100 animated fadeInUp">

                                                            <div class="caption pl-5">
                                                                <h2 class="caption-h2">{{ optional($series)->title }}</h2>
                                                                                                                            
                                                                @if ( optional($series)->description )
                                                                    <div class="trending-dec">{!! htmlspecialchars(substr(optional($series)->description, 0, 100)) !!}</div>
                                                                @endif

                                                                <div class="p-btns">
                                                                    <div class="d-flex align-items-center p-0">
                                                                        <a href="{{ URL::to('play_series/' . $series->slug) }}" class="button-groups btn btn-hover mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                                        <a href="{{ URL::to('play_series/' . $series->slug) }}" class="button-groups btn btn-hover mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> More Info </a>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="trending-contens sub_dropdown_image mt-3">
                                                                <ul id="trending-slider-nav" class= "{{ 'pl-5 m-0  series-depends-episode-slider-'.$key }}" >
                                                                    @foreach ($series->Series_depends_episodes as $episode )
                                                                        <li>
                                                                            <a href="">
                                                                                <div class=" position-relative">
                                                                                    <img src="{{ $episode->image_url }}" class="img-fluid" >
                                                                                        <div class="controls">
                                                                                        <a href="{{ URL::to('episode/'.$series->slug.'/'.$episode->slug ) }}">
                                                                                            <button class="playBTN">
                                                                                                <i class="fas fa-play"></i>
                                                                                            </button>
                                                                                            </a>
                                                                                            <nav>
                                                                                                <button class="moreBTN">
                                                                                                    <i class="fas fa-info-circle"></i>
                                                                                                    <span>More info</span>
                                                                                                </button>
                                                                                            </nav>
                                                                                            @if ( optional($series)->description )
                                                                                                <p class="trending-dec">{!! htmlspecialchars(substr(optional($series)->description, 0, 50)) !!}</p>
                                                                                            @endif
                                                                                        </div>
                                                                                </div>
                                                                                

                                                                                {{-- <p>{!! html_entity_decode( optional($episode)->episode_description) !!} </p> --}}

                                                                                <!-- <div class="d-flex align-items-center text-white text-detail">
                                                                                    <span class="ml-3">{{ "S ".$episode->season_id  }} </span>
                                                                                    <span class="ml-3">{{ "E ".$episode->episode_order  }} </span>
                                                                                </div> -->
                                                                                </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>

                                                            <div class="dropdown_thumbnail">
                                                                <img  src="{{ $series->Player_image_url }}" alt="">
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
        $('.series-genre-videos-slider').hide();
    });

    $(document).ready(function() {

        $('.series-genre-videos-slider').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            arrows: true,
            fade: true,
            draggable: false,
            asNavFor: '.series-genre-videos-slider-nav',
        });

        $('.series-genre-videos-slider-nav').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            asNavFor: '.series-genre-videos-slider',
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
        
        $('.series-genre-videos-slider-nav').click(function() {

            $( ".drp-close" ).trigger( "click" );

             let category_key_id = $(this).attr("data-key-id");
             $('.series-genre-videos-slider').hide();
             $('.category-series-' + category_key_id).show();

            $('.series-depends-episode-slider-'+ category_key_id).slick({
                dots: false,
                infinite: false,
                speed: 300,
                slidesToShow: 6,
                slidesToScroll: 4,
            });
        });

        $('body').on('click', '.drp-close', function() {
            $('.series-genre-videos-slider').hide();
        });
    });

</script>               

<style>

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
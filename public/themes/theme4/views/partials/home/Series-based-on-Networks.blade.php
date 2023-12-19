<?php

$data = App\SeriesNetwork::where('in_home', 1)->orderBy('order')->get()->map(function ($item) {

$item['Series_depends_Networks'] = App\Series::where('series.active', 1)
            ->whereJsonContains('network_id', [(string)$item->id])

            ->latest('series.created_at')->get()->map(function ($item) { 
    
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
    return $item;
});
?>

@if (!empty($data) && $data->isNotEmpty())

    @foreach( $data as $key => $series_networks )
        <section id="iq-trending" class="s-margin">
            <div class="container-fluid pl-0">
                <div class="row">
                    <div class="col-sm-12 overflow-hidden">
                                        
                        @if (!empty($series_networks->Series_depends_Networks))
                                                                    {{-- Header --}}
                            <div class="iq-main-header d-flex align-items-center justify-content-between">
                                <h4 class="main-title pl-4"><a href="{{ route('Specific_Series_Networks',[$series_networks->slug] )}}">{{ optional($series_networks)->name }}</a></h4>
                                <h4 class="main-title"><a href="{{ route('Specific_Series_Networks',[$series_networks->slug] )}}">{{ "view all" }}</a></h4>
                            </div>
                        @endif

                        <div class="trending-contens">
                            <ul id="trending-slider-nav" class="{{ 'series-networks-videos-slider-nav list-inline p-0 ml-4 row align-items-center' }}" data-key-id="{{$key}}">

                                @foreach ($series_networks->Series_depends_Networks as $series )
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="movie-slick position-relative">
                                                <img src="{{ $series->image_url }}" class="img-fluid" >
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            <ul id="trending-slider" class= "{{ 'series-networks-videos-slider list-inline p-0 m-0 align-items-center category-series-'.$key }}" >
                                @foreach ($series_networks->Series_depends_Networks as $series )
                                    <li>
                                        <div class="tranding-block position-relative trending-thumbnail-image" >
                                            <button class="drp-close">×</button>
                                            <div class="trending-custom-tab">
                                                <div class="trending-content">
                                                    <div id="" class="overview-tab tab-pane fade active show">
                                                        <div class="trending-info align-items-center w-100 animated fadeInUp">

                                                            <div class="caption pl-4">
                                                                <h2 class="caption-h2">{{ optional($series)->title }}</h2>
                                                                                                                            
                                                                @if ( optional($series)->description )
                                                                    <div class="trending-dec">{!! html_entity_decode(substr(optional($series)->description, 0, 50)) !!}</div>
                                                                @endif

                                                                <div class="p-btns">
                                                                    <div class="d-flex align-items-center p-0">
                                                                        <a href="{{ URL::to('play_series/' . $series->slug) }}" class="button-groups btn btn-hover mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                                        <a href="{{ URL::to('play_series/' . $series->slug) }}" class="button-groups btn btn-hover mr-2" tabindex="0"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="trending-contens sub_dropdown_image mt-3">
                                                                <ul id="trending-slider-nav" class= "{{ 'pl-4 m-0  series-depends-episode-slider-'.$key }}" >
                                                                    @foreach ($series->Series_depends_episodes as $episode )
                                                                        <li>
                                                                            <a href="{{ URL::to('episode/'.$series->slug.'/'.$episode->slug ) }}">
                                                                                <div class=" position-relative">
                                                                                    <img src="{{ $episode->image_url }}" class="img-fluid" >
                                                                                    <div class="controls">
                                                                                        <a href="{{ URL::to('episode/'.$series->slug.'/'.$episode->slug ) }}">
                                                                                            <button class="playBTN"> <i class="fas fa-play"></i></button>
                                                                                        </a>

                                                                                        <nav>
                                                                                            <button class="moreBTN"><i class="fas fa-info-circle"></i><span>More info</span></button>
                                                                                        </nav>
                                                                                        
                                                                                        <p class="trending-dec" >
                                                                                            {{ " S".$episode->season_id ." E".$episode->episode_order  }} 
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
        $('.series-networks-videos-slider').hide();
    });

    $(document).ready(function() {

        $('.series-networks-videos-slider').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            arrows: true,
            fade: true,
            draggable: false,
            asNavFor: '.series-networks-videos-slider-nav',
        });

        $('.series-networks-videos-slider-nav').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            asNavFor: '.series-networks-videos-slider',
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
        
        $('.series-networks-videos-slider-nav').click(function() {

            $( ".drp-close" ).trigger( "click" );

             let category_key_id = $(this).attr("data-key-id");
             $('.series-networks-videos-slider').hide();
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
            $('.series-networks-videos-slider').hide();
        });
    });

</script>              


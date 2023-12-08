@php
    $data->map(function($item){
        $item['Series_depends_episodes'] = App\Series::find($item->id)->Series_depends_episodes
                                                    ->map(function ($item) {
                                                        $item['image_url']  = !is_null($item->image) ? URL::to('public/uploads/images/'.$item->image) : default_vertical_image() ;
                                                        return $item;
                                                });

            return $item;
    });
@endphp

@if (!empty($data) && $data->isNotEmpty())
    <section id="iq-trending" class="s-margin">
        <div class="container-fluid pl-0">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">
                                    
                                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title pl-5">
                            <a href="{{ $order_settings_list[4]->url ? URL::to($order_settings_list[4]->url) : null }} ">{{ optional($order_settings_list[4])->header_name }}</a>
                        </h4>                   
                        <h4 class="main-title">
                            <a href="{{ $order_settings_list[4]->url ? URL::to($order_settings_list[4]->url) : null }} ">{{ 'view all' }}</a>
                        </h4>                   
                     </div>

                    <div class="trending-contens">
                        <ul id="trending-slider-nav" class="series-slider-nav list-inline p-0 ml-5 row align-items-center"  >
                            @foreach ($data as $series_key => $latest_series)
                                <li data-series-id={{ $series_key }} onclick="series_slider_nav(this)" >
                                    <a href="javascript:void(0);" >
                                        <div class="movie-slick position-relative">
                                            <img src="{{ $latest_series->image ?  URL::to('public/uploads/images/'.$latest_series->image) : default_vertical_image_url() }}" class="img-fluid" >
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <ul id="trending-slider series-slider" class="list-inline p-0 m-0 align-items-center series-slider">
                            @foreach ($data as $key => $latest_series )
                                <li>
                                    <div class="tranding-block position-relative trending-thumbnail-image">
                                        <button class="drp-close">×</button>

                                        <div class="trending-custom-tab">
                                            <div class="trending-content">
                                                <div id="" class="overview-tab tab-pane fade active show">
                                                    <div class="trending-info align-items-center w-100 animated fadeInUp">

                                                        <div class="caption pl-5">
                                                                <h2 class="caption-h2">{{ optional($latest_series)->title }}</h2>

                                                            @if (optional($latest_series)->description)
                                                                <div class="trending-dec">{!! html_entity_decode( optional($latest_series)->description) !!}</div>
                                                            @endif

                                                            <div class="d-flex align-items-center text-white text-detail">
                                                                {{ App\SeriesSeason::where('series_id',$latest_series->id)->count() . " Seasons" }}  
                                                                {{ App\Episode::where('series_id',$latest_series->id)->count() . " Episodes" }}                 
                                                            </div>


                                                            <div class="p-btns">
                                                                <div class="d-flex align-items-center p-0">
                                                                    <a href="{{ URL::to('play_series/'.$latest_series->slug) }}" class="button-groups btn btn-hover  mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                                    {{-- <a href="#" class="btn btn-hover button-groups mr-2" tabindex="0"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a> --}}
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="trending-contens sub_dropdown_image mt-3">
                                                            <ul id="{{ 'trending-slider-nav' }}" value="{{ $key }}" class= "{{ 'latest-series-depends-episode-slider-'.$key .' pl-5 m-0'}}">
                                                                @foreach ($latest_series->Series_depends_episodes as $episode )
                                                                    <li>
                                                                        <a href="{{ URL::to('episode/'.$latest_series->slug.'/'.$episode->slug ) }}">
                                                                            <div class=" position-relative">
                                                                                <img src="{{ $episode->image_url }}" class="img-fluid" >
                                                                                <div class="controls">
                                                                                    <a href="{{ URL::to('episode/'.$latest_series->slug.'/'.$episode->slug ) }}">
                                                                                        <button class="playBTN"> <i class="fas fa-play"></i></button>
                                                                                    </a>

                                                                                    <nav><button class="moreBTN"><i class="fas fa-info-circle"></i><span>More info</span></button></nav>
                                                                                    
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
                                                            <img  src="{{ $latest_series->player_image ?  URL::to('public/uploads/images/'.$latest_series->player_image) : default_horizontal_image_url() }}" alt="">
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
        $('.series-slider').hide();
    });

    $(document).ready(function() {

        $('.series-slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            draggable: false,
            asNavFor: '.series-slider-nav',
        });

        $('.series-slider-nav').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            asNavFor: '.series-slider',
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

        $('body').on('click', '.drp-close', function() {
            $('.series-slider').hide();
        });
    });

    
    function series_slider_nav(ele){

        $( ".drp-close" ).trigger( "click" );
        $('.series-slider').show();

        var category_key_id = $(ele).attr('data-series-id');

        $('.latest-series-depends-episode-slider-' + category_key_id).slick({
            dots: false,
            infinite: false,
            speed: 300,
            slidesToShow: 6,
            slidesToScroll: 4,
        });
    }

</script>
@php
    $data->map(function($item){
        $item['Series_depends_episodes'] = App\Series::find($item->id)->Series_depends_episodes
                                                    ->map(function ($item) {
                                                        $item['image_url']  = !is_null($item->image) ? URL::to('public/uploads/images/'.$item->image) : $default_vertical_image_url ;
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
                        <h4 class="main-title pl-4">
                            <a href="{{ $order_settings_list[4]->url ? URL::to($order_settings_list[4]->url) : null }} ">{{ optional($order_settings_list[4])->header_name }}</a>
                        </h4>                   
                        <h4 class="main-title">
                            <a href="{{ $order_settings_list[4]->url ? URL::to($order_settings_list[4]->url) : null }} ">{{ 'view all' }}</a>
                        </h4>                   
                     </div>

                    <div class="trending-contens">
                        <ul id="trending-slider-nav" class="series-slider-nav list-inline p-0 ml-4 row align-items-center"  >
                            @foreach ($data as $series_key => $latest_series)
                                <li class="slick-slide" data-series-id={{ $series_key }} onclick="series_slider_nav(this)" >
                                    <a href="javascript:;">
                                        <div class="movie-slick position-relative">
                                            <img src="{{ $latest_series->image ?  URL::to('public/uploads/images/'.$latest_series->image) : $default_vertical_image_url }}" class="img-fluid lazy w-100" alt="latest_series">
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <ul id="trending-slider series-slider" class="list-inline p-0 m-0 align-items-center series-slider theme4-slider" style="display:none;">
                            @foreach ($data as $key => $latest_series )
                                <li class="slick-slide">
                                    <div class="tranding-block position-relative trending-thumbnail-image">
                                        <button class="drp-close">×</button>

                                        <div class="trending-custom-tab">
                                            <div class="trending-content">
                                                <div id="" class="overview-tab tab-pane fade active show h-100">
                                                    <div class="trending-info align-items-center w-100 animated fadeInUp">

                                                        <div class="caption pl-4">
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
                                                            <ul id="{{ 'trending-slider-nav' }}" value="{{ $key }}" class= "{{ 'latest-series-depends-episode-slider-'.$key .' pl-4 m-0'}}">
                                                                @foreach ($latest_series->Series_depends_episodes as $episode_key => $episode_details )
                                                                    <li class="slick-slide">
                                                                        <a href="{{ URL::to('episode/'.$latest_series->slug.'/'.$episode_details->slug ) }}">
                                                                            <div class=" position-relative">
                                                                                <img src="{{ $episode_details->image_url }}" class="img-fluid lazy" alt="series">
                                                                                <div class="controls">
                                                                                    <a href="{{ URL::to('episode/'.$latest_series->slug.'/'.$episode_details->slug ) }}">
                                                                                        <button class="playBTN"> <i class="fas fa-play"></i></button>
                                                                                    </a>

                                                                                    <nav ><button class="moreBTN" tabindex="0" data-bs-toggle="modal" data-bs-target="{{ '#Latest-series-Modal-'.$key.'-'.$episode_key  }}"><i class="fas fa-info-circle"></i><span>More info</span></button></nav>
                                                                                    
                                                                                    <p class="trending-dec" >
                                                                                        {{ " S".$episode_details->season_id ." E".$episode_details->episode_order  }} 
                                                                                        {!! (strip_tags(substr(optional($episode_details)->episode_description, 0, 50))) !!}
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>

                                                        <div class="dropdown_thumbnail">
                                                                <img  src="{{ $latest_series->player_image ?  URL::to('public/uploads/images/'.$latest_series->player_image) : $default_horizontal_image_url }}" alt="latest_series">
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


        {{-- Series Modal --}}

        @foreach ($data as $key => $latest_series )

            @foreach ($latest_series->Series_depends_episodes as $episode_key => $episode_details )
                <div class="modal fade info_model" id="{{ 'Latest-series-Modal-'.$key.'-'.$episode_key }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                        <div class="container">
                            <div class="modal-content" style="border:none; background:transparent;">
                                <div class="modal-body">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <img class="lazy" src="{{ $episode_details->player_image ?  URL::to('public/uploads/images/'.$episode_details->player_image) : $default_horizontal_image_url }}" alt="series">
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-lg-10 col-md-10 col-sm-10">
                                                        <h2 class="caption-h2">{{ optional($episode_details)->title }}</h2>
                                                    </div>

                                                    <div class="col-lg-2 col-md-2 col-sm-2">
                                                        <button type="button" class="btn-close-white" aria-label="Close"  data-bs-dismiss="modal">
                                                            <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                        </button>
                                                    </div>
                                                </div>

                                                @if (optional($episode_details)->episode_description)
                                                    <div class="trending-dec mt-4">{!! html_entity_decode( optional($episode_details)->episode_description) !!}</div>
                                                @endif

                                                <a href="{{ URL::to('play_series/'.$episode_details->slug) }}" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0" ><i class="far fa-eye mr-2" aria-hidden="true"></i> View Content </a>

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
            slidesToScroll: 6,
            asNavFor: '.series-slider',
            dots: false,
            arrows: true,
            centerMode:false,
            prevArrow: '<a href="#" class="slick-arrow slick-prev" aria-label="Previous" type="button">Previous</a>',
            nextArrow: '<a href="#" class="slick-arrow slick-next" aria-label="Next" type="button">Next</a>',
            infinite: true,
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

        $('body').on('click', '.slick-arrow', function() {
            $('.livestream-videos-slider').hide();
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
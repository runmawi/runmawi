@if (!empty($Series_based_on_category) && $Series_based_on_category->isNotEmpty())

    @foreach( $Series_based_on_category as $key => $series_genre )
        <section id="iq-trending" class="s-margin">
            <div class="container-fluid pl-0">
                <div class="row">
                    <div class="col-sm-12 overflow-hidden">
                                        
                                        {{-- Header --}}
                        <div class="iq-main-header d-flex align-items-center justify-content-between">
                            <h4 class="main-title mar-left"><a href="{{ route('SeriesCategory',[$series_genre->slug] )}}">{{ optional($series_genre)->name }}</a></h4>
                            <h4 class="main-title"><a href="{{ route('SeriesCategory',[$series_genre->slug] )}}">{{ "view all" }}</a></h4>
                        </div>

                        <div class="trending-contens">
                            <ul id="trending-slider-nav" class="{{ 'series-genre-videos-slider-nav list-inline p-0 mar-left row align-items-center' }}" data-key-id="{{$key}}">

                                @foreach ($series_genre->category_series as $series )
                                    <li class="slick-slide">
                                        <a href="javascript:void(0);">
                                            <div class="movie-slick position-relative">
                                                    <img src="{{ $series->image_url }}" class="img-fluid" alt="Videos">
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            <ul id="trending-slider" class= "{{ 'series-genre-videos-slider list-inline p-0 m-0 align-items-center category-series-'.$key }}" >
                                @foreach ($series_genre->category_series as $series_genre_key => $series )
                                    <li class="slick-slide">
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
                                                                        {{-- <a href="{{ URL::to('play_series/' . $series->slug) }}" class="button-groups btn btn-hover mr-2" tabindex="0"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a> --}}
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="trending-contens sub_dropdown_image mt-3">
                                                                <ul id="trending-slider-nav" class= "{{ 'pl-4 m-0  series-depends-episode-slider-'.$key }}" >
                                                                    @foreach ($series->Series_depends_episodes as $episode_key => $episode )
                                                                        <li>
                                                                            <a href="{{ URL::to('episode/'.$series->slug.'/'.$episode->slug ) }}">
                                                                                <div class=" position-relative">
                                                                                    <img src="{{ $episode->image_url }}" class="img-fluid" alt="Videos">
                                                                                    <div class="controls">
                                                                                        
                                                                                        <a href="{{ URL::to('episode/'.$series->slug.'/'.$episode->slug ) }}">
                                                                                            <button class="playBTN"> <i class="fas fa-play"></i></button>
                                                                                        </a>

                                                                                        <nav ><button class="moreBTN" tabindex="0" data-bs-toggle="modal" data-bs-target="{{ '#Home-series-based-categories-episode-Modal-'.$key.'-'.$series_genre_key.'-'.$episode_key }}"><i class="fas fa-info-circle"></i><span>More info</span></button></nav>

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
                                                                @if ( $multiple_compress_image == 1)
                                                                    <img  alt="latest_series" src="{{$series->player_image ?  URL::to('public/uploads/images/'.$series->player_image) : default_horizontal_image_url() }}"
                                                                        srcset="{{ URL::to('public/uploads/PCimages/'.$series->responsive_player_image.' 860w') }},
                                                                        {{ URL::to('public/uploads/Tabletimages/'.$series->responsive_player_image.' 640w') }},
                                                                        {{ URL::to('public/uploads/mobileimages/'.$series->responsive_player_image.' 420w') }}" >
                                                                @else
                                                                    <img  src="{{ $series->Player_image_url }}" alt="Videos">
                                                                @endif
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

    {{-- Series depends Episode Modal --}}

    @foreach( $Series_based_on_category as $key => $series_genre )
        @foreach ($series_genre->category_series as $series_genre_key => $series )
            @foreach ($series->Series_depends_episodes as $episode_key =>  $episode )
                <div class="modal fade info_model" id="{{ 'Home-series-based-categories-episode-Modal-'.$key.'-'.$series_genre_key.'-'.$episode_key }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                        <div class="container">
                            <div class="modal-content" style="border:none; background:transparent;">
                                <div class="modal-body">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                @if ( $multiple_compress_image == 1)
                                                    <img  alt="latest_series" src="{{$series->player_image ?  URL::to('public/uploads/images/'.$series->player_image) : default_horizontal_image_url() }}"
                                                        srcset="{{ URL::to('public/uploads/PCimages/'.$series->responsive_player_image.' 860w') }},
                                                        {{ URL::to('public/uploads/Tabletimages/'.$series->responsive_player_image.' 640w') }},
                                                        {{ URL::to('public/uploads/mobileimages/'.$series->responsive_player_image.' 420w') }}" >
                                                @else
                                                    <img  src="{{ $series->Player_image_url }}" alt="Videos">
                                                @endif
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

                                                @if (optional($episode)->episode_description)
                                                    <div class="trending-dec mt-4">{!! html_entity_decode( optional($episode)->episode_description) !!}</div>
                                                @endif

                                                <a href="{{ URL::to('episode/'.$series->slug.'/'.$episode->slug ) }}" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0" ><i class="far fa-eye mr-2" aria-hidden="true"></i> View Content </a>

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
            slidesToScroll: 4,
            asNavFor: '.series-genre-videos-slider',
            dots: false,
            arrows: true,
            nextArrow: '<a href="#" aria-label="arrow" class="slick-arrow slick-next"></a>',
            prevArrow: '<a href="#" aria-label="arrow" class="slick-arrow slick-prev"></a>',
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

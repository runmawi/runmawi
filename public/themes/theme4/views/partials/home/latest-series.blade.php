@if (!empty($data) && $data->isNotEmpty())
    <section id="iq-trending" class="s-margin">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">
                                    
                                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title">
                            <a href="{{ $order_settings_list[4]->url ? URL::to($order_settings_list[4]->url) : null }} ">{{ optional($order_settings_list[4])->header_name }}</a>
                        </h4>                   
                     </div>

                    <div class="trending-contens">
                        <ul id="trending-slider-nav" class="series-slider-nav list-inline p-0 mb-0 row align-items-center">
                            @foreach ($data as $latest_series)
                                <li>
                                    <a href="javascript:void(0);">
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
                                    <div class="tranding-block position-relative trending-thumbnail-image" style="background-image: url({{ $latest_series->player_image ?  URL::to('public/uploads/images/'.$latest_series->player_image) : default_horizontal_image_url() }}); background-repeat: no-repeat;background-size: cover;">
                                        <button class="close_btn">×</button>

                                        <div class="trending-custom-tab">
                                            <div class="trending-content">
                                                <div id="" class="overview-tab tab-pane fade active show">
                                                    <div class="trending-info align-items-center w-100 animated fadeInUp">

                                                        <h2 class="trending-text big-title text-uppercase">{{ optional($latest_series)->title }}</h2>

                                                        @if (optional($latest_series)->description)
                                                            <div class="trending-dec">{!! html_entity_decode( optional($latest_series)->description) !!}</div>
                                                        @endif

                                                        <div class="movie-time d-flex align-items-center my-2">
                                                            <span class="text-white"> 
 
                                                            </span>
                                                        </div>

                                                        <div class="d-flex align-items-center text-white text-detail">
                                                            {{ App\SeriesSeason::where('series_id',$latest_series->id)->count() . " Seasons" }}  
                                                            {{ App\Episode::where('series_id',$latest_series->id)->count() . " Episodes" }}                 
                                                        </div>


                                                        <div class="p-btns">
                                                            <div class="d-flex align-items-center p-0">
                                                                <a href="{{ URL::to('play_series/'.$latest_series->slug) }}" class="button-groups btn btn-hover  mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                                {{-- <a href="#" class="btn btn-hover button-groups mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> More Info </a> --}}
                                                            </div>
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
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                    },
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                    },
                },
            ],
        });

        $('.series-slider-nav').on('click', function() {
            $( ".close_btn" ).trigger( "click" );
            $('.series-slider').show();
        });

        $('body').on('click', '.close_btn', function() {
            $('.series-slider').hide();
        });
    });
</script>
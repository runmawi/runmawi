@php
    $data = App\SeriesNetwork::where('in_home',1)->orderBy('order')->limit(15)->get()->map(function ($item) {
                $item['image_url'] = $item->image != null ? URL::to('public/uploads/seriesNetwork/'.$item->image ) : default_vertical_image_url() ;
                $item['banner_image_url'] = $item->banner_image != null ?  URL::to('public/uploads/seriesNetwork/'.$item->banner_image ) : default_horizontal_image_url();

                $item['series'] = App\Series::select('id','title','slug','access','active','ppv_status','featured','duration','image','embed_code',
                                                                                                    'mp4_url','webm_url','ogg_url','url','tv_image','player_image','details','description','network_id')
                                                                                                    ->where('active', '1')->whereJsonContains('network_id',["$item->id"])
                                                                                                    ->latest()->limit(15)->get()->map(function ($item) {
                                                                                                            $item['image_url'] = $item->image != null ?  URL::to('public/uploads/images/'.$item->image) : default_vertical_image_url() ;
                                                                                                            $item['Player_image_url'] = $item->player_image != null ?  URL::to('public/uploads/images/'.$item->player_image) : default_horizontal_image_url() ;
                                                                                                            $item['TV_image_url'] = $item->tv_image != null ?  URL::to('public/uploads/images/'.$item->tv_image) : default_horizontal_image_url() ;       
                                                                                                            $item['season_count'] =  App\SeriesSeason::where('series_id',$item->id)->count();
                                                                                                            $item['episode_count'] =  App\Episode::where('series_id',$item->id)->count();
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
                        <h4 class="main-title mar-left"><a href="{{ $order_settings_list[30]->url ? URL::to($order_settings_list[30]->url) : null }} ">{{ optional($order_settings_list[30])->header_name }}</a></h4>
                        <h4 class="main-title"><a href="{{ $order_settings_list[30]->url ? URL::to($order_settings_list[30]->url) : null }} ">{{ 'view all' }}</a></h4>
                    </div>

                    <div class="trending-contens">
                        <ul id="trending-slider-nav" class="series-networks-slider-nav list-inline p-0 mar-left row align-items-center">
                            @foreach ($data as $series_networks)
                                <li class="slick-slide">
                                    <a href="javascript:void(0);">
                                        <div class="movie-slick position-relative">
                                            <img src="{{ $series_networks->image_url }}" class="img-fluid lazy" alt="network">
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <ul id="trending-slider series-networks-slider" class="list-inline p-0 m-0 align-items-center series-networks-slider" style="display:none;">
                            @foreach ($data as $key => $series_networks )
                                <li class="slick-slide">
                                    <div class="tranding-block position-relative trending-thumbnail-image" >
                                        <button class="drp-close">×</button>

                                        <div class="trending-custom-tab">
                                            <div class="trending-content">
                                                <div id="" class="overview-tab tab-pane fade active show">
                                                    <div class="trending-info align-items-center w-100 animated fadeInUp">

                                                        <div class="caption pl-4">
                                                                <h2 class="caption-h2">{{ optional($series_networks)->name }}</h2>

                                                            <div class="p-btns">
                                                                <div class="d-flex align-items-center p-0">
                                                                    <a href="{{ route('Specific_Series_Networks',$series_networks->slug) }}" class="button-groups btn btn-hover  mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Visit </a>
                                                                    {{-- <a href="#" class="btn btn-hover button-groups mr-2" tabindex="0"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a> --}}
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="trending-contens sub_dropdown_image mt-3">
                                                            <ul  id="{{ 'trending-slider-nav' }}" value="{{ $key }}" class= "{{ 'networks-depends-series-slider-'.$key .' pl-4 m-0'}}" >

                                                                @foreach ($series_networks->series as $series_key  => $series_details )
                                                                    <li class="slick-slide">
                                                                        <a href="{{ route('network.play_series',$series_details->slug) }}">
                                                                            <div class=" position-relative">
                                                                                <img src="{{ $series_details->image ?  URL::to('public/uploads/images/'.$series_details->image) : default_vertical_image_url() }}" class="img-fluid" >                                                                                <div class="controls">
                                                                                   
                                                                                    <a href="{{ route('network.play_series',$series_details->slug) }}">
                                                                                        <button class="playBTN"> <i class="fas fa-play"></i></button>
                                                                                    </a>

                                                                                    <nav ><button class="moreBTN" tabindex="0" data-bs-toggle="modal" data-bs-target="{{ '#Home-SeriesNetwork-series-Modal-'.$key.'-'.$series_key  }}"><i class="fas fa-info-circle"></i><span>More info</span></button></nav>
                                                                                    
                                                                                    <p class="trending-dec" >
                                                                                        {{ $series_details->season_count ." S ".$series_details->episode_count .' E' }} <br>
                                                                                        {{ optional($series_details)->title   }} <br>
                                                                                        {!! (strip_tags(substr(optional($series_details)->description, 0, 50))) !!}
                                                                                    </p>
                                                                                   
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>

                                                        <div class="dropdown_thumbnail">
                                                            <img  src="{{ $series_networks->banner_image_url  }}" alt="">
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

        @foreach ($data as $key => $series_networks )

            @foreach ($series_networks->series as $series_key => $series_details )
                <div class="modal fade info_model" id="{{ 'Home-SeriesNetwork-series-Modal-'.$key.'-'.$series_key }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                        <div class="container">
                            <div class="modal-content" style="border:none; background:transparent;">
                                <div class="modal-body">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <img class="lazy" src="{{ $series_details->player_image ?  URL::to('public/uploads/images/'.$series_details->player_image) : default_horizontal_image_url() }}" alt="player-img" width="100%">
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-lg-10 col-md-10 col-sm-10">
                                                        <h2 class="caption-h2">{{ optional($series_details)->title }}</h2>
                                                    </div>

                                                    <div class="col-lg-2 col-md-2 col-sm-2">
                                                        <button type="button" class="btn-close-white" aria-label="Close"  data-bs-dismiss="modal">
                                                            <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                        </button>
                                                    </div>
                                                </div>
                                                
                                                <div class="trending-dec mt-4" >
                                                    {{ $series_details->season_count ." Series ".$series_details->episode_count .' Episodes' }} 
                                                </div>

                                                @if (optional($series_details)->details)
                                                    <div class="trending-dec mt-4">{!! html_entity_decode( optional($series_details)->details) !!}</div>
                                                @endif

                                                <a href="{{ URL::to('play_series/'.$series_details->slug) }}" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0" ><i class="far fa-eye mr-2" aria-hidden="true"></i> View Content </a>

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
    $(window).on("load", function() {
        $('.series-networks-slider').hide();
    });

    $(document).ready(function() {
        $('.series-networks-slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            fade: true,
            draggable: false,
            asNavFor: '.series-networks-slider-nav',
        });

        $('.series-networks-slider-nav').slick({
            slidesToShow: 6,
            slidesToScroll: 4,
            asNavFor: '.series-networks-slider',
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

        $('.series-networks-slider-nav').on('click', function() {
            $('.series-networks-slider').show();
        });

        $('body').on('click', '.drp-close', function() {
            $('.series-networks-slider').hide();
        });

        $('.slick-next, .slick-prev').on('click', function(event) {
            event.preventDefault();
            event.stopPropagation();
        });
        $('.networks-depends-series-slider-' + category_key_id).slick({
            dots: false,
            infinite: false,
            speed: 300,
            slidesToShow: 6,
            slidesToScroll: 4,
        });
    });
</script>



<style>
    .series-networks-slider-nav a.slick-slide.slick-current.slick-active{
        display:none;
    }
    a[aria-controls="1"] {
        display:none;
    }

</style>
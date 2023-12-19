@if (!empty($data) && $data->isNotEmpty())
    <section id="iq-trending" class="s-margin">
        <div class="container-fluid pl-0">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">
                                    
                                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title pl-5"><a href="{{ $order_settings_list[19]->url ? URL::to($order_settings_list[19]->url) : null }} ">{{ optional($order_settings_list[19])->header_name }}</a></h4>
                        <h4 class="main-title"><a href="{{ $order_settings_list[19]->url ? URL::to($order_settings_list[19]->url) : null }} ">{{ 'view all' }}</a></h4>
                    </div>

                    <div class="trending-contens">
                        <ul id="trending-slider-nav" class="series-category-slider-nav list-inline p-0 ml-5 row align-items-center">
                            @foreach ($data as $seriesGenre)
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="movie-slick position-relative">
                                            <img src="{{ $seriesGenre->image ?  URL::to('public/uploads/videocategory/'.$seriesGenre->image) : default_vertical_image_url() }}" class="img-fluid" >
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <ul id="trending-slider series-category-slider" class="list-inline p-0 m-0 align-items-center series-category-slider">
                            @foreach ($data as $key => $seriesGenre )
                                <li>
                                    <div class="tranding-block position-relative trending-thumbnail-image" >
                                        <button class="drp-close">×</button>

                                        <div class="trending-custom-tab">
                                            <div class="trending-content">
                                                <div id="" class="overview-tab tab-pane fade active show">
                                                    <div class="trending-info align-items-center w-100 animated fadeInUp">

                                                        <div class="caption pl-5">
                                                                <h2 class="caption-h2">{{ optional($seriesGenre)->name }}</h2>

                                                            <div class="p-btns">
                                                                <div class="d-flex align-items-center p-0">
                                                                    <a href="{{ URL::to('series/category/'. $seriesGenre->slug) }}" class="button-groups btn btn-hover  mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Visit </a>
                                                                    {{-- <a href="#" class="btn btn-hover button-groups mr-2" tabindex="0"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a> --}}
                                                                </div>
                                                            </div>
                                                        </div>

                                                        
                                                        <div class="trending-contens sub_dropdown_image mt-3">
                                                            <ul id="{{ 'trending-slider-nav' }}"  class= "Category-depends-series pl-5 m-0">

                                                                <?php

                                                                    $SeriesCategory = App\SeriesCategory::where('category_id',$seriesGenre->id)->groupBy('series_id')->pluck('series_id'); 

                                                                    $series = App\Series::select('id','title','slug','access','active','ppv_status','featured','duration','image','embed_code',
                                                                                                    'mp4_url','webm_url','ogg_url','url','tv_image','player_image','details','description')
                                                                                                    ->where('active', '1')->whereIn('id',$SeriesCategory);

                                                                    $series = $series->latest()->limit(30)->get()->map(function ($item) {
                                                                                $item['image_url'] = $item->image != null ?  URL::to('public/uploads/images/'.$item->image) : Vertical_Default_Image() ;
                                                                                $item['Player_image_url'] = $item->player_image != null ?  URL::to('public/uploads/images/'.$item->player_image) : Horizontal_Default_Image() ;
                                                                                $item['TV_image_url'] = $item->tv_image != null ?  URL::to('public/uploads/images/'.$item->tv_image) : Horizontal_Default_Image() ;       
                                                                                $item['season_count'] =  App\SeriesSeason::where('series_id',$item->id)->count();
                                                                                $item['episode_count'] =  App\Episode::where('series_id',$item->id)->count();
                                                                                return $item;
                                                                            });  
                                                                    
                                                                ?>

                                                                @foreach ($series as $series_details )
                                                                    <li>
                                                                        <a href="{{ URL::to('play_series/'.$series_details->slug) }}">
                                                                            <div class=" position-relative">
                                                                                <img src="{{ $series_details->image ?  URL::to('public/uploads/images/'.$series_details->image) : default_vertical_image_url() }}" class="img-fluid" >                                                                                <div class="controls">
                                                                                   
                                                                                    <a href="{{ URL::to('play_series/'.$series_details->slug) }}">
                                                                                        <button class="playBTN"> <i class="fas fa-play"></i></button>
                                                                                    </a>

                                                                                    <nav><button class="moreBTN"><i class="fas fa-info-circle"></i><span>More info</span></button></nav>
                                                                                    
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
                                                            <img  src="{{ $seriesGenre->banner_image ?  URL::to('public/uploads/videocategory/'.$seriesGenre->banner_image) : default_horizontal_image_url() }}" alt="">
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
        $('.series-category-slider').fadeOut();
    });

    $(document).ready(function() {

        $('.series-category-slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
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

        $('.Category-depends-series').slick({
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
            $('.series-category-slider').fadeIn();
        });

        $('body').on('click', '.drp-close', function() {
            $('.series-category-slider').hide();
        });
    });
</script>
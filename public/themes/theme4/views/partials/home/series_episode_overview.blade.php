<?php

$data = App\Series::where('active', '1')->limit(15)
    ->get()
    ->map(function ($item) {
        $item['image_url'] = URL::to('/public/uploads/images/' . $item->image);
        $item['Player_image_url'] = URL::to('/public/uploads/images/' . $item->player_image);
        $item['season_count'] = App\SeriesSeason::where('series_id', $item->id)->count();
        $item['episode_count'] = App\Episode::where('series_id', $item->id)->count();

        $item['Series_Category'] = App\SeriesCategory::select('category_id', 'series_id', 'name', 'slug')
            ->join('series_genre', 'series_genre.id', '=', 'series_categories.category_id')
            ->where('series_id', $item->id)
            ->limit(15)
            ->get();

        $item['Series_Language'] = App\SeriesLanguage::select('language_id', 'series_id', 'name', 'slug')
            ->join('languages', 'languages.id', '=', 'series_languages.language_id')
            ->where('series_id', $item->id)
            ->limit(15)
            ->get();

        $item['Series_artist'] = App\Seriesartist::select('artist_id', 'artist_name as name', 'artist_slug')
            ->join('artists', 'artists.id', '=', 'series_artists.artist_id')
            ->where('series_id', $item->id)
            ->limit(15)
            ->get();

        $item['season'] = App\SeriesSeason::where('series_id', $item->id)->limit(15)->get();

        $item['Episode_details'] = $item->theme4_Series_depends_episodes;

        $item['Episode_Traler_details'] = $item->theme4_Series_depends_episodes;

        $item['Episode_Similar_content'] = App\Episode::where('series_id','!=',$item->id)->where('status','1')->where('active',1)->limit(15)->get();

        return $item;
    });

?>

@if (!empty($data) && $data->isNotEmpty())
    <section id="iq-trending" class="s-margin">
        <div class="container-fluid pl-0">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title mar-left"><a href="#">{{ optional($order_settings_list[29])->header_name }}</a></h4>
                    </div>

                    <div class="trending-contens">

                        <ul id="trending-slider-nav" class="trending-nav list-inline p-0 mar-left row align-items-center">
                            @foreach ($data as $Episode_details)
                                <li class="slick-slide">
                                    <a href="javascript:;">
                                        <div class="movie-slick position-relative">
                                            @if ( $multiple_compress_image == 1)
                                                <img class="img-fluid position-relative" alt="{{ $Episode_details->title }}" src="{{ $Episode_details->image ?  URL::to('public/uploads/images/'.$Episode_details->image) : default_vertical_image_url() }}"
                                                    srcset="{{ URL::to('public/uploads/PCimages/'.$Episode_details->responsive_image.' 860w') }},
                                                    {{ URL::to('public/uploads/Tabletimages/'.$Episode_details->responsive_image.' 640w') }},
                                                    {{ URL::to('public/uploads/mobileimages/'.$Episode_details->responsive_image.' 420w') }}" >
                                            @else
                                                <img src="{{ $Episode_details->image_url }}" class="img-fluid" alt="Videos">
                                            @endif
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        

                        <ul id="trending-slider trending" class="list-inline p-0 m-0 align-items-center trending theme4-slider">
                                @foreach ($Episode_details->Episode_details as $key => $item)
                                    <li class="slick-slide">
                                        <div class="tranding-block position-relative trending-thumbnail-image" >
                                            <button class="drp-close">×</button>

                                            <div class="trending-custom-tab">
                                                <div class="trending-content">
                                                    <div id="" class="overview-tab tab-pane fade active show h-100">
                                                        <div class="trending-info align-items-center w-100 animated fadeInUp">

                                                            <div class="caption pl-4">
                                                                <h2 class="caption-h2">{{ optional($Episode_details)->title }}</h2>

                                                                @if (optional($Episode_details)->description)
                                                                <div class="trending-dec">{!! html_entity_decode( optional($Episode_details)->description) !!}</div>
                                                            @endif
                                                                <div class="p-btns">
                                                                    <div class="d-flex align-items-center p-0">
                                                                        <a href="{{ URL::to('episode/'.$item->series_id .'/'. $item->id ) }}" class="button-groups btn btn-hover  mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play </a>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="dropdown_thumbnail">
                                                                @if ( $multiple_compress_image == 1)
                                                                    <img  alt="latest_series" src="{{$item->player_image ?  URL::to('public/uploads/images/'.$item->player_image) : default_horizontal_image_url() }}"
                                                                        srcset="{{ URL::to('public/uploads/PCimages/'.$item->responsive_player_image.' 860w') }},
                                                                        {{ URL::to('public/uploads/Tabletimages/'.$item->responsive_player_image.' 640w') }},
                                                                        {{ URL::to('public/uploads/mobileimages/'.$item->responsive_player_image.' 420w') }}" >
                                                                @else
                                                                    <img  src="{{ $item->player_image ? URL::to('public/uploads/images/'. $item->player_image ) : default_vertical_image_url() }}" alt="Videos">
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
@endif


<script>
    
    $( window ).on("load", function() {
        $('.trending').hide();
    });

    $(document).ready(function() {

        $('.trending').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            fade: true,
            draggable: false,
            asNavFor: '.trending-nav',
        });

        $('.trending-nav').slick({
            slidesToShow: 6,
            slidesToScroll: 6,
            asNavFor: '.trending',
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

        $('.trending-nav').on('click', function() {
            $( ".drp-close" ).trigger( "click" );
            $('.trending').show();
        });

        $('body').on('click', '.drp-close', function() {
            $('.trending').hide();
        });
    });
</script>
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

        $item['Episode_details'] = $item->Series_depends_episodes;

        $item['Episode_Traler_details'] = $item->Series_depends_episodes;

        $item['Episode_Similar_content'] = App\Episode::where('series_id','!=',$item->id)->where('status','1')->where('active',1)->limit(15)->get();

        return $item;
    });

?>

@if (!empty($data) && $data->isNotEmpty())
    <section id="iq-favorites">
        <div class="container-fluid overflow-hidden">
            <div class="row">
                <div class="col-sm-12">
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title mar-left"><a href="#">{{ optional($order_settings_list[29])->header_name }}</a></h4>
                    </div>

                    <div class="favorites-contens">
                        <div class="series-episode home-sec list-inline row p-0 mb-0">
                            @foreach($data as $Episode_details)
                                <div class="items">
                                    <div class="block-images position-relative">
                                        <div class="border-bg">
                                            <div class="img-box">
                                                <a class="playTrailer" href="#">
                                                    @if ( $multiple_compress_image == 1)
                                                        <img class="img-fluid position-relative" alt="{{ $Episode_details->title }}" data-flickity-lazyload="{{ $Episode_details->image ?  URL::to('public/uploads/images/'.$Episode_details->image) : $default_vertical_image_url }}"
                                                            srcset="{{ URL::to('public/uploads/PCimages/'.$Episode_details->responsive_image.' 860w') }},
                                                            {{ URL::to('public/uploads/Tabletimages/'.$Episode_details->responsive_image.' 640w') }},
                                                            {{ URL::to('public/uploads/mobileimages/'.$Episode_details->responsive_image.' 420w') }}" >
                                                    @else
                                                        <img data-flickity-lazyload="{{ $Episode_details->image_url }}" data-src="{{ $Episode_details->image_url }}" class="img-fluid w-100" alt="{{ $Episode_details->title }}">
                                                    @endif
                                                </a>
                                            </div>
                                        </div>
                                        <div class="block-description">
                                            <a class="playTrailer" href="#">
                                                {{-- <img src="{{ $Episode_details->Player_image_url }}" data-src="{{ $Episode_details->Player_image_url }}" class="img-fluid w-100" alt="{{ $Episode_details->title }}"> --}}
                                            </a>
                                            <div class="hover-buttons text-white">
                                                <a href="#">
                                                    <p class="epi-name text-left m-0">{{ __($Episode_details->title) }}</p>
                                                    <div class="movie-time d-flex align-items-center my-2"></div>
                                                </a>
                                                <a class="epi-name mt-2 mb-0 btn" href="{{ URL::to('play_series/'.$Episode_details->slug) }}">
                                                    <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                    {{ __('Play Now')}}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif

<script>
    var elem = document.querySelector('.series-episode');
    var flkty = new Flickity(elem, {
        cellAlign: 'left',
        contain: true,
        groupCells: false,
        pageDots: false,
        draggable: true,
        freeScroll: true,
        imagesLoaded: true,
        lazyLoad: 7,
    });
 </script>
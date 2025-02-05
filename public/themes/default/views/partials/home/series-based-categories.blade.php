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
        <section id="iq-favorites iq-favorites-{{ $key }}">
            <div class="container-fluid overflow-hidden">
                <div class="row">
                    <div class="col-sm-12 ">

                          {{-- Header --}}
                        <div class="iq-main-header d-flex align-items-center justify-content-between">
                            <h4 class="main-title"><a href="{{ route('SeriesCategory',[$series_genre->slug] )}}">{{ optional($series_genre)->name }}</a></h4>
                            @if($settings->homepage_views_all_button_status == 1)
                                <h4 class="main-title view-all">
                                    <a href="{{ route('SeriesCategory',[$series_genre->slug] )}}"> 
                                        {{ __('View all') }}
                                    </a>
                                </h4>
                            @endif
                        </div>

                        <div class="tvthrillers-contens">
                            <div class="series-based-category home-sec list-inline row p-0 mb-0" id="series-category-{{ $key }}">
                                @foreach ($series_genre->category_series as $series_video)
                                    <div class="items">
                                        <div class="block-images position-relative">
                                            <!-- block-images -->
                                            <div class="border-bg">
                                                <div class="img-box">
                                                    <a class="playTrailer" href="{{ url('play_series/' . $series_video->slug) }}">
                                                        <img class="img-fluid w-100" loading="lazy" data-src="{{ $series_video->image ? URL::to('public/uploads/images/' . $series_video->image) : $default_vertical_image_url }}" src="{{ $series_video->image ? URL::to('public/uploads/images/' . $series_video->image) : $default_vertical_image_url }}" alt="{{ $series_video->title }}">
                                                    </a>
                                                    @if($ThumbnailSetting->free_or_cost_label == 1)
                                                        @switch(true)
                                                            @case($series_video->access == 'subscriber')
                                                                <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                            @break

                                                            @case($series_video->access == 'registered')
                                                                <p class="p-tag">{{ __('Register Now') }}</p>
                                                            @break

                                                            @case(!empty($series_video->ppv_price))
                                                                <p class="p-tag">{{ $currency->symbol . ' ' . $series_video->ppv_price }}</p>
                                                            @break

                                                            @case(!empty($series_video->global_ppv) || (!empty($series_video->global_ppv) && $series_video->ppv_price == null))
                                                                <p class="p-tag">{{ $series_video->global_ppv . ' ' . $currency->symbol }}</p>
                                                            @break

                                                            @case($series_video->global_ppv == null && $series_video->ppv_price == null)
                                                                <p class="p-tag">{{ __('Free') }}</p>
                                                            @break
                                                        @endswitch
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="block-description">
                                                <a class="playTrailer" href="{{ url('play_series/' . $series_video->slug) }}">
                                                    {{-- <img class="img-fluid w-100" loading="lazy" data-src="{{ $series_video->image ? URL::to('public/uploads/images/' . $series_video->player_image) : $default_vertical_image_url }}" src="{{ $series_video->image ? URL::to('public/uploads/images/' . $series_video->player_image) : $default_vertical_image_url }}" alt="{{ $series_video->title }}"> --}}
                                                    @if($ThumbnailSetting->free_or_cost_label == 1)
                                                        @switch(true)
                                                            @case($series_video->access == 'subscriber')
                                                                <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                            @break

                                                            @case($series_video->access == 'registered')
                                                                <p class="p-tag">{{ __('Register Now') }}</p>
                                                            @break

                                                            @case(!empty($series_video->ppv_price))
                                                                <p class="p-tag">{{ $currency->symbol . ' ' . $series_video->ppv_price }}</p>
                                                            @break

                                                            @case(!empty($series_video->global_ppv) || (!empty($series_video->global_ppv) && $series_video->ppv_price == null))
                                                                <p class="p-tag">{{ $series_video->global_ppv . ' ' . $currency->symbol }}</p>
                                                            @break

                                                            @case($series_video->global_ppv == null && $series_video->ppv_price == null)
                                                                <p class="p-tag">{{ __('Free') }}</p>
                                                            @break
                                                        @endswitch
                                                    @endif
                                                </a>

                                                <div class="hover-buttons text-white">
                                                    <a href="{{ url('play_series/' . $series_video->slug) }}">
                                                        @if($ThumbnailSetting->title == 1)
                                                            <!-- Title -->
                                                            <p class="epi-name text-left mt-2 m-0">
                                                                {{ strlen($series_video->title) > 17 ? substr($series_video->title, 0, 18) . '...' : $series_video->title }}
                                                            </p>
                                                        @endif

                                                        @if($ThumbnailSetting->enable_description == 1)
                                                            <p class="desc-name text-left m-0 mt-1">
                                                                {{ strlen($series_video->description) > 75 ? substr(html_entity_decode(strip_tags($series_video->description)), 0, 75) . '...' : strip_tags($series_video->description) }}
                                                            </p>
                                                        @endif

                                                        <div class="movie-time d-flex align-items-center pt-2">
                                                            @if($ThumbnailSetting->age == 1 && !($series_video->age_restrict == 0))
                                                                <span class="position-relative badge p-1 mr-2">{{ $series_video->age_restrict }}</span>
                                                            @endif

                                                            @if($ThumbnailSetting->duration == 1)
                                                                <span class="position-relative text-white mr-2">
                                                                    {{ (floor($series_video->duration / 3600) > 0 ? floor($series_video->duration / 3600) . 'h ' : '') . floor(($series_video->duration % 3600) / 60) . 'm' }}
                                                                </span>
                                                            @endif
                                                            @if($ThumbnailSetting->published_year == 1 && !($series_video->year == 0))
                                                                <span class="position-relative badge p-1 mr-2">
                                                                    {{ __($series_video->year) }}
                                                                </span>
                                                            @endif
                                                            @if($ThumbnailSetting->featured == 1 && $series_video->featured == 1)
                                                                <span class="position-relative text-white">
                                                                   {{ __('Featured') }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </a>

                                                    <a class="epi-name mt-2 mb-0 btn" type="button" href="{{ URL::to('play_series/'.$series_video->slug) }}">
                                                        <i class="fa fa-play mr-1" aria-hidden="true"></i> {{ __('Watch Now') }}
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
    @endforeach
@endif

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var elems = document.querySelectorAll('.series-based-category');
        elems.forEach(function (elem) {
            new Flickity(elem, {
                cellAlign: 'left',
                contain: true,
                groupCells: true,
                pageDots: false,
                draggable: true,
                freeScroll: true,
                imagesLoaded: true,
                lazyLoad: true
            });
        });
    });
 </script>
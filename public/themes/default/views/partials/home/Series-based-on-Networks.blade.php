@if (!empty($data) && $data->isNotEmpty())

    @foreach($data as $section_key => $series_networks)
        @if (!empty($series_networks->Series_depends_Networks) && ($series_networks->Series_depends_Networks)->isNotEmpty())
        <section id="iq-trending iq-favorites-{{ $section_key }}" >
            <div class="container-fluid overflow-hidden">
                <div class="row">
                    <div class="col-sm-12">
                                        
                        {{-- Header --}}
                        <div class="iq-main-header d-flex align-items-center justify-content-between">
                            <h4 class="main-title mar-left"><a href="{{ route('Specific_Series_Networks', [$series_networks->slug]) }}">{{ optional($series_networks)->name }}</a></h4>
                            <h4 class="main-title view-all"><a href="{{ route('Specific_Series_Networks', [$series_networks->slug]) }}">{{ "View all" }}</a></h4>
                        </div>

                        <div class="favorites-contens">
                            <div class="series-based-network home-sec list-inline row p-0 mb-0" id="network-category-{{ $section_key }}">
                                @foreach ($series_networks->Series_depends_Networks as $key => $series)
                                    <div class="items">
                                        <div class="block-images position-relative">
                                            <div class="border-bg">
                                                <div class="img-box">
                                                    <a class="playTrailer" href="{{ route('network.play_series', $series->slug) }}">
                                                        <img data-src="{{ $series->image_url ? $series->image_url : $default_vertical_image_url }}" data-flickity-lazyload="{{ $series->image_url ? $series->image_url : $default_vertical_image_url }}" class="img-fluid w-100" alt="{{ $series->title }}" width="300" height="200">
                                                    </a>

                                                    @if($ThumbnailSetting->free_or_cost_label == 1)

                                                        @switch(true)
                                                            @case($series->access == 'subscriber')
                                                                <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                            @break

                                                            @case($series->access == 'registered')
                                                                <p class="p-tag">{{ __('Register Now') }}</p>
                                                            @break

                                                            @case(!empty($series->ppv_price))
                                                                <p class="p-tag">{{ $currency->symbol . ' ' . $series->ppv_price }}</p>
                                                            @break

                                                            @case(!empty($series->global_ppv) || (!empty($series->global_ppv) && $series->ppv_price == null))
                                                                <p class="p-tag">{{ $series->global_ppv . ' ' . $currency->symbol }}</p>
                                                            @break

                                                            @case(empty($series->global_ppv) && $series->ppv_price == null)
                                                                <p class="p-tag">{{ __('Free') }}</p>
                                                            @break
                                                        @endswitch
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="block-description">
                                                <a class="playTrailer" href="{{ route('network.play_series', $series->slug) }}">
                                                {{-- <img data-src="{{ $series->Player_image_url ? $series->Player_image_url : $default_vertical_image_url }}" src="{{ $series->Player_image_url ? $series->Player_image_url : $default_vertical_image_url }}" class="img-fluid w-100" alt="{{ $series->title }}" width="300" height="200"> --}}

                                                    @if($ThumbnailSetting->free_or_cost_label == 1)

                                                        @switch(true)
                                                            @case($series->access == 'subscriber')
                                                                <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                            @break

                                                            @case($series->access == 'registered')
                                                                <p class="p-tag">{{ __('Register Now') }}</p>
                                                            @break

                                                            @case(!empty($series->ppv_price))
                                                                <p class="p-tag">{{ $currency->symbol . ' ' . $series->ppv_price }}</p>
                                                            @break

                                                            @case(!empty($series->global_ppv) || (!empty($series->global_ppv) && $series->ppv_price == null))
                                                                <p class="p-tag">{{ $series->global_ppv . ' ' . $currency->symbol }}</p>
                                                            @break

                                                            @case(empty($series->global_ppv) && $series->ppv_price == null)
                                                                <p class="p-tag">{{ __('Free') }}</p>
                                                            @break
                                                        @endswitch
                                                    @endif
                                                </a>

                                                <div class="hover-buttons text-white">
                                                    <a href="{{ route('network.play_series', $series->slug) }}">
                                                        @if($ThumbnailSetting->title == 1)
                                                            <!-- Title -->
                                                            <p class="epi-name text-left mt-2 m-0">
                                                                {{ strlen($series->title) > 17 ? substr($series->title, 0, 18) . '...' : $series->title }}
                                                            </p>
                                                        @endif

                                                        @if($ThumbnailSetting->enable_description == 1)
                                                            <p class="desc-name text-left m-0 mt-1">
                                                                {{ strlen($series->description) > 75 ? substr(html_entity_decode(strip_tags($series->description)), 0, 75) . '...' : strip_tags($series->description) }}
                                                            </p>
                                                        @endif

                                                        <div class="movie-time d-flex align-items-center pt-2">
                                                            @if($ThumbnailSetting->age == 1 && !($series->age_restrict == 0))
                                                                <span class="position-relative badge p-1 mr-2">{{ $series->age_restrict }}</span>
                                                                <!-- <div class="badge badge-secondary p-1 mr-2">{{ $series->status . ' +' }}</div> -->
                                                            @endif

                                                            @if($ThumbnailSetting->duration == 1)
                                                                <!-- Duration -->
                                                                <span class="position-relative text-white mr-2">
                                                                    {{ (floor($series->duration / 3600) > 0 ? floor($series->duration / 3600) . 'h ' : '') . floor(($series->duration % 3600) / 60) . 'm' }}
                                                                </span>
                                                            @endif

                                                            @if($ThumbnailSetting->published_year == 1 && !($series->year == 0))
                                                                <!-- published_year -->
                                                                <span class="position-relative badge p-1 mr-2">
                                                                    {{ __($series->year) }}
                                                                </span>
                                                            @endif

                                                            @if($ThumbnailSetting->featured == 1 && $series->featured == 1)
                                                                <!-- Featured -->
                                                                <span class="position-relative text-white">
                                                                   {{ __('Featured') }}
                                                                </span>
                                                            @endif
                                                        </div>

                                                        <div class="movie-time d-flex align-items-center pt-1">
                                                            @php
                                                                $CategoryThumbnail_setting = App\CategoryLive::join('live_categories', 'live_categories.id', '=', 'livecategories.category_id')
                                                                    ->where('livecategories.live_id', $series->id)
                                                                    ->pluck('live_categories.name');
                                                            @endphp
                                                            @if($ThumbnailSetting->category == 1 && count($CategoryThumbnail_setting) > 0)
                                                                <span class="text-white">
                                                                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                                    {{ implode(', ', $CategoryThumbnail_setting->toArray()) }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </a>

                                                    <a class="epi-name mt-2 mb-0 btn" type="button" class="text-white d-flex align-items-center"
                                                    href="{{ route('network.play_series', $series->slug) }}">
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
        @endif
    @endforeach
@endif

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var elems = document.querySelectorAll('.series-based-network');
        elems.forEach(function (elem) {
            new Flickity(elem, {
                cellAlign: 'left',
                contain: true,
                groupCells: false,
                pageDots: false,
                draggable: true,
                freeScroll: true,
                imagesLoaded: true,
                lazyLoad: 7,
            });
        });
    });
 </script>
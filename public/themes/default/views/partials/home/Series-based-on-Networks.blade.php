@if (!empty($data) && $data->isNotEmpty())

    @foreach($data as $section_key => $series_networks)
        @if (!empty($series_networks->Series_depends_Networks) && ($series_networks->Series_depends_Networks)->isNotEmpty())
        <section id="iq-favorites-{{ $section_key }}" >
            <div class="container-fluid overflow-hidden">
                <div class="row">
                    <div class="col-sm-12">
                                        
                        {{-- Header --}}
                        <div class="iq-main-header d-flex align-items-center justify-content-between">
                            <h4 class="main-title mar-left"><a href="{{ route('Specific_Series_Networks', [$series_networks->slug]) }}">{{ optional($series_networks)->name }}</a></h4>
                            <h4 class="main-title"><a href="{{ route('Specific_Series_Networks', [$series_networks->slug]) }}">{{ "view all" }}</a></h4>
                        </div>

                        <div class="favorites-contens">
                            <ul class="favorites-slider list-inline row p-0 mb-0">
                                @foreach ($series_networks->Series_depends_Networks as $key => $series)
                                    <li class="slide-item">
                                        <div class="block-images position-relative">
                                            <div class="border-bg">
                                                <div class="img-box">
                                                    <a class="playTrailer" href="{{ route('network.play_series', $series->slug) }}">
                                                        <img data-src="{{ $series->image_url ? $series->image_url : $default_vertical_image_url }}" src="{{ $series->image_url ? $series->image_url : $default_vertical_image_url }}" class="img-fluid w-100" alt="{{ $series->title }}" width="300" height="200">
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

                                                    <!-- @if($ThumbnailSetting->published_on == 1)
                                                        <p class="published_on1">{{ $publish_day }} <span>{{ $publish_time }}</span></p>
                                                    @endif -->
                                                </div>
                                            </div>

                                            <div class="block-description">
                                                <a class="playTrailer" href="{{ route('network.play_series', $series->slug) }}">
                                                <img data-src="{{ $series->Player_image_url ? $series->Player_image_url : $default_vertical_image_url }}" src="{{ $series->Player_image_url ? $series->Player_image_url : $default_vertical_image_url }}" class="img-fluid w-100" alt="{{ $series->title }}" width="300" height="200">

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
                                                            <p class="epi-name text-left m-0">
                                                                {{ strlen($series->title) > 17 ? substr($series->title, 0, 18) . '...' : $series->title }}
                                                            </p>
                                                        @endif

                                                        <div class="movie-time d-flex align-items-center pt-1">
                                                            @if($ThumbnailSetting->age == 1)
                                                                <!-- <div class="badge badge-secondary p-1 mr-2">{{ $series->status . ' +' }}</div> -->
                                                            @endif

                                                            @if($ThumbnailSetting->duration == 1)
                                                                <!-- Duration -->
                                                                <span class="text-white">
                                                                    <i class="fa fa-clock-o"></i>
                                                                    {{ gmdate('H:i:s', $series->duration) }}
                                                                </span>
                                                            @endif
                                                        </div>

                                                        @if($ThumbnailSetting->published_year == 1 || $ThumbnailSetting->rating == 1)
                                                            <div class="movie-time d-flex align-items-center pt-1">
                                                                @if($ThumbnailSetting->rating == 1)
                                                                    <!--Rating  -->
                                                                    <div class="badge badge-secondary p-1 mr-2">
                                                                        <span class="text-white">
                                                                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                                            {{ __($series->rating) }}
                                                                        </span>
                                                                    </div>
                                                                @endif

                                                                @if($ThumbnailSetting->published_year == 1)
                                                                    <!-- published_year -->
                                                                    <div class="badge badge-secondary p-1 mr-2">
                                                                        <span class="text-white">
                                                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                            {{ __($series->year) }}
                                                                        </span>
                                                                    </div>
                                                                @endif

                                                                @if($ThumbnailSetting->featured == 1 && $series->featured == 1)
                                                                    <!-- Featured -->
                                                                    <div class="badge badge-secondary p-1 mr-2">
                                                                        <span class="text-white">
                                                                            <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                                        </span>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endif

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

                                                    <a class="epi-name mt-3 mb-0 btn" type="button" class="text-white d-flex align-items-center"
                                                    href="{{ route('network.play_series', $series->slug) }}">
                                                        <img class="d-inline-block ply" alt="ply" src="{{ URL::to('/assets/img/default_play_buttons.svg') }}" width="10%" height="10%" /> {{ __('Watch Now') }}
                                                    </a>
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
    @endforeach

@endif
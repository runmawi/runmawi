
@php
    include public_path("themes/{$current_theme}/views/header.php");
@endphp
<section id="iq-favorites" class="pagelist">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header d-flex align-items-center justify-content-center">
                    <h4 class="main-title fira-sans-condensed-regular">
                        {{ $order_settings_list[4]->header_name ? __($order_settings_list[4]->header_name) : '' }}
                    </h4>
                </div>

                @if ($latest_series_pagelist->isNotEmpty())
                    <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">
                            @forelse($latest_series_pagelist as $key => $series)
                                <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                    <div class="block-images position-relative">
                                        <div class="border-bg">
                                            <div class="img-box">
                                                <a class="playTrailer" href="{{ url('/play_series/' . $series->slug) }}">
                                                    <img class="img-fluid w-100 flickity-lazyloaded" 
                                                         src="{{ $series->image ? asset('public/uploads/images/'.$series->image) : $default_vertical_image_url }}" 
                                                         alt="{{ $series->title }}">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="block-description">
                                            <div class="hover-buttons d-flex">
                                                <a class="text-white" href="{{ url('/play_series/' . $series->slug) }}" aria-label="Latest-Series">
                                                    <img class="ply" src="{{ asset('assets/img/default_play_buttons.svg') }}" alt="play">
                                                </a>
                                            </div>
                                        </div>

                                        <div class="mt-2">
                                            <div class="movie-time align-items-center justify-content-between my-2">
                                                <a href="{{ url('/play_series/' . $series->slug) }}">
                                                    <h6>{{ Str::limit($series->title, 18, '...') }}</h6>
                                                </a>
                                                @if($ThumbnailSetting->age == 1 && $series->age_restrict > 0)
                                                    <div class="badge badge-secondary p-1 mr-2">{{ $series->age_restrict }} +</div>
                                                @endif
                                                <div class="badge badge-secondary p-1 mr-2">
                                                    {{ \App\SeriesSeason::where('series_id', $series->id)->count() }} Season
                                                </div>
                                                <div class="badge badge-secondary p-1 mr-2">
                                                    {{ \App\Episode::where('series_id', $series->id)->count() }} Episodes
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <div class="col-md-12 text-center mt-4"
                                     style="background: url({{ asset('assets/img/watch.png') }}); height: 500px; background-position: center; background-repeat: no-repeat; background-size: contain;">
                                    <h3 class="text-center">{{ __('No Series Video Available') }}</h3>
                                </div>
                            @endforelse
                        </ul>

                        <div class="col-md-12 pagination justify-content-end">
                            {!! $latest_series_pagelist->links() !!}
                        </div>
                    </div>
                @else
                    <div class="col-md-12 text-center mt-4"
                         style="background: url({{ asset('assets/img/watch.png') }}); height: 500px; background-position: center; background-repeat: no-repeat; background-size: contain;">
                        <h3 class="text-center">{{ __('No Series Video Available') }}</h3>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
<?php include public_path("themes/$current_theme/views/footer.blade.php"); ?>

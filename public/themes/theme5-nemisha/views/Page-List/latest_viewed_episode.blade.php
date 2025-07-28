@php
    include public_path("themes/{$current_theme}/views/header.php");
@endphp


<section id="iq-favorites" class="pagelist">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header d-flex align-items-center justify-content-between">
                    <h2 class="main-title fira-sans-condensed-regular">
                        {{ $order_settings_list[18]->header_name ? __($order_settings_list[18]->header_name) : '' }}
                    </h2>
                </div>

                @if ($latest_viewed_episode_pagelist->isNotEmpty())
                    <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">
                            @foreach ($latest_viewed_episode_pagelist as $episode)
                                <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                    <div class="block-images position-relative">
                                        <div class="border-bg">
                                            <div class="img-box">
                                                <a class="playTrailer" href="{{ url('/episode/' . $episode->series_slug . '/' . $episode->episode_slug) }}">
                                                    <img class="img-fluid w-100 flickity-lazyloaded" 
                                                         src="{{ $episode->image ? url('/public/uploads/images/' . $episode->image) : $default_vertical_image_url }}" 
                                                         alt="{{ $episode->title }}">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="block-description">
                                            <div class="hover-buttons text-white">
                                                <a href="{{ url('/episode/' . $episode->series_slug . '/' . $episode->episode_slug) }}" aria-label="movie">
                                                    <img class="ply" src="{{ url('/assets/img/default_play_buttons.svg') }}" alt="play" />
                                                </a>
                                            </div>
                                        </div>

                                        <div class="p-0">
                                            <div class="mt-2 d-flex justify-content-between p-0">
                                                @if ($ThumbnailSetting->title)
                                                    <h6>{{ Str::limit($episode->title, 18, '...') }}</h6>
                                                @endif

                                                @if ($ThumbnailSetting->age)
                                                    <div class="badge badge-secondary">{{ $episode->age_restrict }}+</div>
                                                @endif
                                            </div>

                                            <div class="movie-time my-2">
                                                @if ($ThumbnailSetting->duration)
                                                    <span class="text-white">
                                                        <i class="fa fa-clock-o"></i>
                                                        {{ gmdate('H:i:s', $episode->duration) }}
                                                    </span>
                                                @endif

                                                @if ($ThumbnailSetting->rating && $episode->rating)
                                                    <span class="text-white">
                                                        <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                        {{ __($episode->rating) }}
                                                    </span>
                                                @endif

                                                @if ($ThumbnailSetting->featured && $episode->featured)
                                                    <span class="text-white">
                                                        <i class="fa fa-flag" aria-hidden="true"></i>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="movie-time my-2">
                                                @if ($ThumbnailSetting->published_year && $episode->year)
                                                    <span class="text-white">
                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                        {{ __($episode->year) }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="movie-time my-2">
                                                @php
                                                    $CategoryThumbnail_setting = App\CategoryVideo::join('video_categories', 'video_categories.id', '=', 'categoryvideos.category_id')
                                                        ->where('categoryvideos.video_id', $episode->id)
                                                        ->pluck('video_categories.name');
                                                @endphp

                                                @if ($ThumbnailSetting->category && $CategoryThumbnail_setting->isNotEmpty())
                                                    <span class="text-white">
                                                        <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                        {{ $CategoryThumbnail_setting->implode(', ') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                        <div class="col-md-12 pagination justify-content-end">
                            {!! $latest_viewed_episode_pagelist->links() !!}
                        </div>
                    </div>
                @else
                    <div class="col-md-12 text-center mt-4"
                        style="background: url({{ url('/assets/img/watch.png') }});height: 500px;background-position: center;background-repeat: no-repeat;background-size: contain;">
                        <h3 class="text-center">{{ __('No Series Video Available') }}</h3>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<?php include public_path("themes/$current_theme/views/footer.blade.php"); ?>


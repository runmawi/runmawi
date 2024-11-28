@php
    include public_path("themes/{$current_theme}/views/header.php");
@endphp
<section id="iq-favorites" class="pagelist">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">

                <div class="iq-main-header d-flex align-items-center justify-content-center">
                    <h4 class="main-title fira-sans-condensed-regular">
                      {{ $order_settings_list[0]->header_name ? __($order_settings_list[0]->header_name) : '' }}
                    </h4>
                </div>

                @if ($featured_videos_pagelist->isNotEmpty())
                    <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">
                            @forelse($featured_videos_pagelist as $watchlater_video)
                                <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                    <a href="{{ url('category/videos/' . $watchlater_video->slug) }}"
                                        aria-label="video">
                                        <div class="block-images position-relative">
                                            <div class="img-box">
                                                <a href="{{ url('category/videos/' . $watchlater_video->slug) }}">
                                                    <img src="{{ url('/public/uploads/images/' . $watchlater_video->image) }}"
                                                        class="img-fluid w-100 h-50 flickity-lazyloaded"
                                                        alt="{{ $watchlater_video->title }}">
                                                </a>
                                                @if ($ThumbnailSetting->published_on)
                                                    <p class="published_on1">{{ $publish_time }}</p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="block-description">
                                            <div class="hover-buttons">
                                                <a href="{{ url('category/videos/' . $watchlater_video->slug) }}"
                                                    aria-label="Latest-Video">
                                                    <img class="ply"
                                                        src="{{ url('/assets/img/default_play_buttons.svg') }}"
                                                        alt="play" />
                                                </a>
                                            </div>
                                        </div>

                                        <div class="p-0">
                                            <div class="mt-2 d-flex justify-content-between p-0">
                                                @if ($ThumbnailSetting->title)
                                                    <h6>{{ Str::limit($watchlater_video->title, 18, '...') }}</h6>
                                                @endif

                                                @if ($ThumbnailSetting->age)
                                                    <div class="badge badge-secondary">
                                                        {{ $watchlater_video->age_restrict }}+</div>
                                                @endif
                                            </div>

                                            <div class="movie-time my-2">
                                                @if ($ThumbnailSetting->duration)
                                                    <span class="text-white">
                                                        <i class="fa fa-clock-o"></i>
                                                        {{ gmdate('H:i:s', $watchlater_video->duration) }}
                                                    </span>
                                                @endif

                                                @if ($ThumbnailSetting->rating && $watchlater_video->rating)
                                                    <span class="text-white">
                                                        <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                        {{ $watchlater_video->rating }}
                                                    </span>
                                                @endif

                                                @if ($ThumbnailSetting->featured && $watchlater_video->featured)
                                                    <span class="text-white">
                                                        <i class="fa fa-flag" aria-hidden="true"></i>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="movie-time my-2">
                                                @if ($ThumbnailSetting->published_year && $watchlater_video->year)
                                                    <span class="text-white">
                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                        {{ $watchlater_video->year }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="movie-time my-2">
                                                @php
                                                    $CategoryThumbnail_setting = App\CategoryVideo::join(
                                                        'video_categories',
                                                        'video_categories.id',
                                                        '=',
                                                        'categoryvideos.category_id',
                                                    )
                                                        ->where('categoryvideos.video_id', $watchlater_video->id)
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
                                    </a>
                                </li>
                            @empty
                                <div class="col-md-12 text-center mt-4"
                                    style="background: url({{ url('/assets/img/watch.png') }}); height: 500px; background-position: center; background-repeat: no-repeat; background-size: contain;">
                                    <h3 class="text-center">{{ __('No Video Available') }}</h3>
                                </div>
                            @endforelse
                        </ul>

                        <div class="col-md-12 pagination justify-content-end">
                            {!! $featured_videos_pagelist->links() !!}
                        </div>
                    </div>
                @else
                    <div class="col-md-12 text-center mt-4"
                        style="background: url({{ url('/assets/img/watch.png') }}); height: 500px; background-position: center; background-repeat: no-repeat; background-size: contain;">
                        <h3 class="text-center">{{ __('No Video Available') }}</h3>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<?php include public_path("themes/$current_theme/views/footer.blade.php"); ?>

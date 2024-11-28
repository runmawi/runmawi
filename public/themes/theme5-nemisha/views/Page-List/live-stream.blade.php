
@php
    include public_path("themes/{$current_theme}/views/header.php");
@endphp

<section id="iq-favorites" class="pagelist">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header d-flex align-items-center justify-content-between">
                    <h2 class="main-title fira-sans-condensed-regular">
                        {{ $order_settings_list[3]->header_name ? __($order_settings_list[3]->header_name) : '' }}
                    </h2>
                </div>

                @if ($live_list_pagelist->isNotEmpty())
                    <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">
                            @forelse($live_list_pagelist as $key => $video)
                                <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                    <div class="block-images position-relative">
                                        <div class="border-bg">
                                            <div class="img-box">
                                                <a class="playTrailer" href="{{ url('/live/' . $video->slug) }}">
                                                    <img class="img-fluid w-100 flickity-lazyloaded" 
                                                         src="{{ $video->image ? asset('public/uploads/images/' . $video->image) : $default_vertical_image_url }}" 
                                                         alt="{{ $video->title }}" />

                                                    <div class="p-0">
                                                        <div class="mt-2 d-flex justify-content-between p-0">
                                                            @if($ThumbnailSetting->title == 1)
                                                                <h6>{{ Str::limit($video->title, 18, '...') }}</h6>
                                                            @endif

                                                            @if($ThumbnailSetting->age == 1)
                                                                <div class="badge badge-secondary">{{ $video->age_restrict . '+' }}</div>
                                                            @endif
                                                        </div>

                                                        <div class="movie-time my-2">
                                                            <!-- Duration -->
                                                            @if($ThumbnailSetting->duration == 1)
                                                                <span class="text-white">
                                                                    <i class="fa fa-clock-o"></i>
                                                                    {{ gmdate('H:i:s', $video->duration) }}
                                                                </span>
                                                            @endif

                                                            <!-- Rating -->
                                                            @if($ThumbnailSetting->rating == 1 && $video->rating != null)
                                                                <span class="text-white">
                                                                    <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                                    {{ __($video->rating) }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </a>

                                                @if($ThumbnailSetting->free_or_cost_label == 1)
                                                    @if($video->access == 'subscriber')
                                                        <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                    @elseif($video->access == 'registered')
                                                        <p class="p-tag">{{ __('Register Now') }}</p>
                                                    @elseif(!empty($video->ppv_price))
                                                        <p class="p-tag1">{{ $currency->symbol . ' ' . $video->ppv_price }}</p>
                                                    @else
                                                        <p class="p-tag">{{ __('Free') }}</p>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <div class="col-md-12 text-center mt-4"
                                     style="background: url({{ asset('assets/img/watch.png') }}); height: 500px; background-position: center; background-repeat: no-repeat; background-size: contain;">
                                    <h3 class="text-center">{{ __('No Video Available') }}</h3>
                                </div>
                            @endforelse
                        </ul>

                        <div class="col-md-12 pagination justify-content-end">
                            {!! $live_list_pagelist->links() !!}
                        </div>
                    </div>
                @else
                    <div class="col-md-12 text-center mt-4"
                         style="background: url({{ asset('assets/img/watch.png') }}); height: 500px; background-position: center; background-repeat: no-repeat; background-size: contain;">
                        <h3 class="text-center">{{ __('No Video Available') }}</h3>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>


<?php include public_path("themes/$current_theme/views/footer.blade.php"); ?>

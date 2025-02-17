
@php
    include public_path("themes/{$current_theme}/views/header.php");
@endphp

<section id="iq-favorites" class="pagelist">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">

                @if (($watchlater_pagelist)->isNotEmpty())

                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h2 class="main-title fira-sans-condensed-regular">
                                {{ $order_settings_list[36]->header_name ? __($order_settings_list[36]->header_name) : '' }}
                        </h2>  
                    </div>

                    <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">
                            @forelse($watchlater_pagelist as $key => $watchlater)
                                <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                    <div class="block-images position-relative">
                                        <div class="border-bg">
                                            <div class="img-box">
                                                <a class="playTrailer" href="{{ URL::to('category') . '/videos/' . $watchlater->slug }}">
                                                    <img class="img-fluid w-100 flickity-lazyloaded" src="{{ $watchlater->image ? URL::to('/public/uploads/images/'.$watchlater->image) : $default_vertical_image_url }}" alt="{{ $watchlater->title }}">
                                                </a>

                                                @if($ThumbnailSetting->free_or_cost_label == 1)
                                                    @switch(true)
                                                        @case($watchlater->access == 'subscriber')
                                                            <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                        @break
                                                        @case($watchlater->access == 'registered')
                                                            <p class="p-tag">{{ __('Register Now') }}</p>
                                                        @break
                                                        @case(!empty($watchlater->ppv_price))
                                                            <p class="p-tag">{{ $currency->symbol . ' ' . $watchlater->ppv_price }}</p>
                                                        @break
                                                        @case(!empty($watchlater->global_ppv) && $watchlater->ppv_price == null)
                                                            <p class="p-tag">{{ $watchlater->global_ppv . ' ' . $currency->symbol }}</p>
                                                        @break
                                                        @case($watchlater->global_ppv == null && $watchlater->ppv_price == null)
                                                            <p class="p-tag">{{ __('Free') }}</p>
                                                        @break
                                                    @endswitch
                                                @endif
                                            </div>
                                        </div>
                                        <div class="block-description">
                                            <a class="playTrailer" href="{{ URL::to('category') . '/videos/' . $watchlater->slug }}">

                                                @if($ThumbnailSetting->free_or_cost_label == 1)
                                                    @switch(true)
                                                        @case($watchlater->access == 'subscriber')
                                                            <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                        @break
                                                        @case($watchlater->access == 'registered')
                                                            <p class="p-tag">{{ __('Register Now') }}</p>
                                                        @break
                                                        @case(!empty($watchlater->ppv_price))
                                                            <p class="p-tag">{{ $currency->symbol . ' ' . $watchlater->ppv_price }}</p>
                                                        @break
                                                        @case(!empty($watchlater->global_ppv) && $watchlater->ppv_price == null)
                                                            <p class="p-tag">{{ $watchlater->global_ppv . ' ' . $currency->symbol }}</p>
                                                        @break
                                                        @case($watchlater->global_ppv == null && $watchlater->ppv_price == null)
                                                            <p class="p-tag">{{ __('Free') }}</p>
                                                        @break
                                                    @endswitch
                                                @endif
                                            </a>

                                            <div class="hover-buttons text-white">
                                                <a href="{{ URL::to('category') . '/videos/' . $watchlater->slug }}" aria-label="movie">
                                                    @if($ThumbnailSetting->title == 1)
                                                        <p class="epi-name text-left mt-2 m-0">
                                                            {{ strlen($watchlater->title) > 17 ? substr($watchlater->title, 0, 18).'...' : $watchlater->title }}
                                                        </p>
                                                    @endif

                                                    @if($ThumbnailSetting->enable_description == 1)
                                                        <p class="desc-name text-left m-0 mt-1">
                                                            {{ strlen($watchlater->description) > 75 ? substr(html_entity_decode(strip_tags($watchlater->description)), 0, 75) . '...' : strip_tags($watchlater->description) }}
                                                        </p>
                                                    @endif

                                                    <div class="movie-time d-flex align-items-center pt-2">
                                                        @if($ThumbnailSetting->age == 1 && !($watchlater->age_restrict == 0))
                                                            <span class="position-relative p-1 mr-2">{{ $watchlater->age_restrict}}</span>
                                                        @endif

                                                        @if($ThumbnailSetting->duration == 1)
                                                            <span class="position-relative text-white mr-2">
                                                                {{ (floor($watchlater->duration / 3600) > 0 ? floor($watchlater->duration / 3600) . 'h ' : '') . floor(($watchlater->duration % 3600) / 60) . 'm' }}
                                                            </span>
                                                        @endif
                                                        @if($ThumbnailSetting->published_year == 1 && !($watchlater->year == 0))
                                                            <span class="position-relative p-1 mr-2">
                                                                {{ __($watchlater->year) }}
                                                            </span>
                                                        @endif
                                                        @if($ThumbnailSetting->featured == 1 && $watchlater->featured == 1)
                                                            <span class="position-relative text-white">
                                                               {{ __('Featured') }}
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <div class="movie-time d-flex align-items-center pt-1">
                                                        @php
                                                            $CategoryThumbnail_setting = App\CategoryVideo::join('video_categories', 'video_categories.id', '=', 'categoryvideos.category_id')
                                                                ->where('categoryvideos.video_id', $watchlater->id)
                                                                ->pluck('video_categories.name');        
                                                        @endphp

                                                        @if($ThumbnailSetting->category == 1 && count($CategoryThumbnail_setting) > 0)
                                                            <span class="text-white">
                                                                <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                                {{ implode(', ', $CategoryThumbnail_setting->toArray()) }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </a>

                                                <a class="epi-name mt-2 mb-0 btn" href="{{ URL::to('category') . '/videos/' . $watchlater->slug }}">
                                                    <img class="d-inline-block ply" alt="ply" src="{{ URL::to('/assets/img/default_play_buttons.svg') }}" width="10%" height="10%"/> {{ __('Watch Now') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <div class="col-md-12 text-center mt-4"
                                    style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                                    <p>
                                    <h3 class="text-center">{{ __('No Video Available') }}</h3>
                                </div>
                            @endforelse
                        </ul>

                        <div class="col-md-12 pagination justify-content-end">
                            {!! $watchlater_pagelist->links() !!}
                        </div>

                    </div>
                @else
                    <div class="col-md-12 text-center mt-4"
                        style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                        <p>
                        <h3 class="text-center">{{ __('No WatchLater Available') }}</h3>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
<?php include public_path("themes/$current_theme/views/footer.blade.php"); ?>

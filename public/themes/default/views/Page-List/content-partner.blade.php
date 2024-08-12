
@php
    include public_path("themes/{$current_theme}/views/header.php");
@endphp

<section id="iq-favorites" class="pagelist">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header d-flex align-items-center justify-content-between">
                    <h2 class="main-title fira-sans-condensed-regular">
                            {{ $order_settings_list[14]->header_name ? __($order_settings_list[14]->header_name) : '' }}
                    </h2>  
                </div>

                @if (($content_partner_pagelist)->isNotEmpty())

                    <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">
                            @forelse($content_partner_pagelist as $key => $content)
                                <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                    <div class="block-images position-relative">
                                        <div class="border-bg">
                                            <div class="img-box">
                                                <a class="playTrailer" href="{{ URL::to('/channel/' . $content->channel_slug) }}">
                                                <img src="{{ $content->channel_logo ? $content->channel_logo : $default_vertical_image_url }}" src="{{ $content->channel_logo ? $content->channel_logo : $default_vertical_image_url }}" class="img-fluid w-100" alt="{{ $content->channel_name }}">
                                                </a>

                                                <!-- @if($ThumbnailSetting->free_or_cost_label == 1)
                                                    @switch(true)
                                                        @case($content->access == 'subscriber')
                                                            <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                        @break
                                                        @case($content->access == 'registered')
                                                            <p class="p-tag">{{ __('Register Now') }}</p>
                                                        @break
                                                        @case(!empty($content->ppv_price))
                                                            <p class="p-tag">{{ $currency->symbol . ' ' . $content->ppv_price }}</p>
                                                        @break
                                                        @case(!empty($content->global_ppv) && $content->ppv_price == null)
                                                            <p class="p-tag">{{ $content->global_ppv . ' ' . $currency->symbol }}</p>
                                                        @break
                                                        @case($content->global_ppv == null && $content->ppv_price == null)
                                                            <p class="p-tag">{{ __('Free') }}</p>
                                                        @break
                                                    @endswitch
                                                @endif -->
                                            </div>
                                        </div>
                                        <div class="block-description">
                                            <!-- <a class="playTrailer" href="{{ URL::to('/channel/' . $content->slug) }}">

                                                @if($ThumbnailSetting->free_or_cost_label == 1)
                                                    @switch(true)
                                                        @case($content->access == 'subscriber')
                                                            <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                        @break
                                                        @case($content->access == 'registered')
                                                            <p class="p-tag">{{ __('Register Now') }}</p>
                                                        @break
                                                        @case(!empty($content->ppv_price))
                                                            <p class="p-tag">{{ $currency->symbol . ' ' . $content->ppv_price }}</p>
                                                        @break
                                                        @case(!empty($content->global_ppv) && $content->ppv_price == null)
                                                            <p class="p-tag">{{ $content->global_ppv . ' ' . $currency->symbol }}</p>
                                                        @break
                                                        @case($content->global_ppv == null && $content->ppv_price == null)
                                                            <p class="p-tag">{{ __('Free') }}</p>
                                                        @break
                                                    @endswitch
                                                @endif
                                            </a> -->

                                            <div class="hover-buttons text-white">
                                                <a href="{{ URL::to('/channel/' . $content->slug) }}" aria-label="movie">
                                                    <!-- @if($ThumbnailSetting->title == 1) -->
                                                        <p class="epi-name text-left mt-2 m-0">
                                                            {{ strlen($content->title) > 17 ? substr($content->title, 0, 18).'...' : $content->title }}
                                                        </p>
                                                    <!-- @endif -->

                                                    <!-- <p class="desc-name text-left m-0 mt-1">
                                                        {{ strlen($content->description) > 75 ? substr(html_entity_decode(strip_tags($content->description)), 0, 75) . '...' : strip_tags($content->description) }}
                                                    </p>

                                                    <div class="movie-time d-flex align-items-center pt-2">
                                                        @if($ThumbnailSetting->age == 1 && !($content->age_restrict == 0))
                                                            <span class="position-relative badge p-1 mr-2">{{ $content->age_restrict}}</span>
                                                        @endif

                                                        @if($ThumbnailSetting->duration == 1)
                                                            <span class="position-relative text-white mr-2">
                                                                {{ (floor($content->duration / 3600) > 0 ? floor($content->duration / 3600) . 'h ' : '') . floor(($content->duration % 3600) / 60) . 'm' }}
                                                            </span>
                                                        @endif
                                                        @if($ThumbnailSetting->published_year == 1 && !($content->year == 0))
                                                            <span class="position-relative badge p-1 mr-2">
                                                                {{ __($content->year) }}
                                                            </span>
                                                        @endif
                                                        @if($ThumbnailSetting->featured == 1 && $content->featured == 1)
                                                            <span class="position-relative text-white">
                                                               {{ __('Featured') }}
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <div class="movie-time d-flex align-items-center pt-1">
                                                        @php 
                                                            $contentSeason = App\SeriesSeason::where('series_id', $content->id)->count(); 
                                                            echo $contentSeason . ' Season';
                                                        @endphp
                                                    </div> -->
                                                </a>

                                                <a class="epi-name mt-2 mb-0 btn" href="{{ URL::to('/channel/' . $content->channel_slug) }}">
                                                    <!-- <img class="d-inline-block ply" alt="ply" src="{{ URL::to('/assets/img/default_play_buttons.svg') }}" width="10%" height="10%"/> {{ __('Watch Now') }} -->
                                                    <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                    {{ __('Visit Channel') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <div class="col-md-12 text-center mt-4"
                                    style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                                    <p>
                                    <h3 class="text-center">{{ __('No Channel Available') }}</h3>
                                </div>
                            @endforelse
                        </ul>

                        <div class="col-md-12 pagination justify-content-end">
                            {!! $content_partner_pagelist->links() !!}
                        </div>

                    </div>
                @else
                    <div class="col-md-12 text-center mt-4"
                        style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                        <p>
                        <h3 class="text-center">{{ __('No Channel Available') }}</h3>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
<?php include public_path("themes/$current_theme/views/footer.blade.php"); ?>

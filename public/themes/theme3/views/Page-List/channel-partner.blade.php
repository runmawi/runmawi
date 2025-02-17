
@php
    include public_path("themes/{$current_theme}/views/header.php");
@endphp

<section id="iq-favorites" class="pagelist">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header d-flex align-items-center justify-content-between">
                    <h2 class="main-title fira-sans-condensed-regular">
                            {{ $order_settings_list[13]->header_name ? __($order_settings_list[13]->header_name) : '' }}
                    </h2>  
                </div>

                @if (($channel_partner_pagelist)->isNotEmpty())

                    <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">
                            @forelse($channel_partner_pagelist as $key => $channel)
                                <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                    <div class="block-images position-relative">
                                        <div class="border-bg">
                                            <div class="img-box">
                                                <a class="playTrailer" href="{{ URL::to('/channel/' . $channel->channel_slug) }}">
                                                <img src="{{ $channel->channel_logo ? $channel->channel_logo : $default_vertical_image_url }}" src="{{ $channel->channel_logo ? $channel->channel_logo : $default_vertical_image_url }}" class="img-fluid w-100" alt="{{ $channel->channel_name }}">
                                                </a>

                                                <!-- @if($ThumbnailSetting->free_or_cost_label == 1)
                                                    @switch(true)
                                                        @case($channel->access == 'subscriber')
                                                            <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                        @break
                                                        @case($channel->access == 'registered')
                                                            <p class="p-tag">{{ __('Register Now') }}</p>
                                                        @break
                                                        @case(!empty($channel->ppv_price))
                                                            <p class="p-tag">{{ $currency->symbol . ' ' . $channel->ppv_price }}</p>
                                                        @break
                                                        @case(!empty($channel->global_ppv) && $channel->ppv_price == null)
                                                            <p class="p-tag">{{ $channel->global_ppv . ' ' . $currency->symbol }}</p>
                                                        @break
                                                        @case($channel->global_ppv == null && $channel->ppv_price == null)
                                                            <p class="p-tag">{{ __('Free') }}</p>
                                                        @break
                                                    @endswitch
                                                @endif -->
                                            </div>
                                        </div>
                                        <div class="block-description">
                                            <!-- <a class="playTrailer" href="{{ URL::to('/channel/' . $channel->slug) }}">

                                                @if($ThumbnailSetting->free_or_cost_label == 1)
                                                    @switch(true)
                                                        @case($channel->access == 'subscriber')
                                                            <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                        @break
                                                        @case($channel->access == 'registered')
                                                            <p class="p-tag">{{ __('Register Now') }}</p>
                                                        @break
                                                        @case(!empty($channel->ppv_price))
                                                            <p class="p-tag">{{ $currency->symbol . ' ' . $channel->ppv_price }}</p>
                                                        @break
                                                        @case(!empty($channel->global_ppv) && $channel->ppv_price == null)
                                                            <p class="p-tag">{{ $channel->global_ppv . ' ' . $currency->symbol }}</p>
                                                        @break
                                                        @case($channel->global_ppv == null && $channel->ppv_price == null)
                                                            <p class="p-tag">{{ __('Free') }}</p>
                                                        @break
                                                    @endswitch
                                                @endif
                                            </a> -->

                                            <div class="hover-buttons text-white">
                                                <a href="{{ URL::to('/channel/' . $channel->slug) }}" aria-label="movie">
                                                    <!-- @if($ThumbnailSetting->title == 1) -->
                                                        <p class="epi-name text-left mt-2 m-0">
                                                            {{ strlen($channel->title) > 17 ? substr($channel->title, 0, 18).'...' : $channel->title }}
                                                        </p>
                                                    <!-- @endif -->

                                                    <!-- <p class="desc-name text-left m-0 mt-1">
                                                        {{ strlen($channel->description) > 75 ? substr(html_entity_decode(strip_tags($channel->description)), 0, 75) . '...' : strip_tags($channel->description) }}
                                                    </p>

                                                    <div class="movie-time d-flex align-items-center pt-2">
                                                        @if($ThumbnailSetting->age == 1 && !($channel->age_restrict == 0))
                                                            <span class="position-relative badge p-1 mr-2">{{ $channel->age_restrict}}</span>
                                                        @endif

                                                        @if($ThumbnailSetting->duration == 1)
                                                            <span class="position-relative text-white mr-2">
                                                                {{ (floor($channel->duration / 3600) > 0 ? floor($channel->duration / 3600) . 'h ' : '') . floor(($channel->duration % 3600) / 60) . 'm' }}
                                                            </span>
                                                        @endif
                                                        @if($ThumbnailSetting->published_year == 1 && !($channel->year == 0))
                                                            <span class="position-relative badge p-1 mr-2">
                                                                {{ __($channel->year) }}
                                                            </span>
                                                        @endif
                                                        @if($ThumbnailSetting->featured == 1 && $channel->featured == 1)
                                                            <span class="position-relative text-white">
                                                               {{ __('Featured') }}
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <div class="movie-time d-flex align-items-center pt-1">
                                                        @php 
                                                            $channelSeason = App\SeriesSeason::where('series_id', $channel->id)->count(); 
                                                            echo $channelSeason . ' Season';
                                                        @endphp
                                                    </div> -->
                                                </a>

                                                <a class="epi-name mt-2 mb-0 btn" href="{{ URL::to('/channel/' . $channel->channel_slug) }}">
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
                            {!! $channel_partner_pagelist->links() !!}
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

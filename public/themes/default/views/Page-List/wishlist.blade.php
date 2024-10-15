
@php
    include public_path("themes/{$current_theme}/views/header.php");
@endphp

<section id="iq-favorites" class="pagelist">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">

                @if (($wishlist_pagelist)->isNotEmpty())

                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h2 class="main-title fira-sans-condensed-regular">
                                {{ $order_settings_list[37]->header_name ? __($order_settings_list[37]->header_name) : '' }}
                        </h2>  
                    </div>

                    <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">
                            @forelse($wishlist_pagelist as $key => $wishlist)
                                <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                    <div class="block-images position-relative">
                                        <div class="border-bg">
                                            <div class="img-box">
                                                <a class="playTrailer" href="{{ URL::to('category') . '/videos/' . $wishlist->slug }}">
                                                    <img class="img-fluid w-100 flickity-lazyloaded" src="{{ $wishlist->image ? URL::to('/public/uploads/images/'.$wishlist->image) : $default_vertical_image_url }}" alt="{{ $wishlist->title }}">
                                                </a>

                                                @if($ThumbnailSetting->free_or_cost_label == 1)
                                                    @switch(true)
                                                        @case($wishlist->access == 'subscriber')
                                                            <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                        @break
                                                        @case($wishlist->access == 'registered')
                                                            <p class="p-tag">{{ __('Register Now') }}</p>
                                                        @break
                                                        @case(!empty($wishlist->ppv_price))
                                                            <p class="p-tag">{{ $currency->symbol . ' ' . $wishlist->ppv_price }}</p>
                                                        @break
                                                        @case(!empty($wishlist->global_ppv) && $wishlist->ppv_price == null)
                                                            <p class="p-tag">{{ $wishlist->global_ppv . ' ' . $currency->symbol }}</p>
                                                        @break
                                                        @case($wishlist->global_ppv == null && $wishlist->ppv_price == null)
                                                            <p class="p-tag">{{ __('Free') }}</p>
                                                        @break
                                                    @endswitch
                                                @endif
                                            </div>
                                        </div>
                                        <div class="block-description">
                                            <a class="playTrailer" href="{{ URL::to('category') . '/videos/' . $wishlist->slug }}">

                                                @if($ThumbnailSetting->free_or_cost_label == 1)
                                                    @switch(true)
                                                        @case($wishlist->access == 'subscriber')
                                                            <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                        @break
                                                        @case($wishlist->access == 'registered')
                                                            <p class="p-tag">{{ __('Register Now') }}</p>
                                                        @break
                                                        @case(!empty($wishlist->ppv_price))
                                                            <p class="p-tag">{{ $currency->symbol . ' ' . $wishlist->ppv_price }}</p>
                                                        @break
                                                        @case(!empty($wishlist->global_ppv) && $wishlist->ppv_price == null)
                                                            <p class="p-tag">{{ $wishlist->global_ppv . ' ' . $currency->symbol }}</p>
                                                        @break
                                                        @case($wishlist->global_ppv == null && $wishlist->ppv_price == null)
                                                            <p class="p-tag">{{ __('Free') }}</p>
                                                        @break
                                                    @endswitch
                                                @endif
                                            </a>

                                            <div class="hover-buttons text-white">
                                                <a href="{{ URL::to('category') . '/videos/' . $wishlist->slug }}" aria-label="movie">
                                                    @if($ThumbnailSetting->title == 1)
                                                        <p class="epi-name text-left mt-2 m-0">
                                                            {{ strlen($wishlist->title) > 17 ? substr($wishlist->title, 0, 18).'...' : $wishlist->title }}
                                                        </p>
                                                    @endif

                                                    @if($ThumbnailSetting->enable_description == 1)
                                                        <p class="desc-name text-left m-0 mt-1">
                                                            {{ strlen($wishlist->description) > 75 ? substr(html_entity_decode(strip_tags($wishlist->description)), 0, 75) . '...' : strip_tags($wishlist->description) }}
                                                        </p>
                                                    @endif

                                                    <div class="movie-time d-flex align-items-center pt-2">
                                                        @if($ThumbnailSetting->age == 1 && !($wishlist->age_restrict == 0))
                                                            <span class="position-relative badge p-1 mr-2">{{ $wishlist->age_restrict}}</span>
                                                        @endif

                                                        @if($ThumbnailSetting->duration == 1)
                                                            <span class="position-relative text-white mr-2">
                                                                {{ (floor($wishlist->duration / 3600) > 0 ? floor($wishlist->duration / 3600) . 'h ' : '') . floor(($wishlist->duration % 3600) / 60) . 'm' }}
                                                            </span>
                                                        @endif
                                                        @if($ThumbnailSetting->published_year == 1 && !($wishlist->year == 0))
                                                            <span class="position-relative badge p-1 mr-2">
                                                                {{ __($wishlist->year) }}
                                                            </span>
                                                        @endif
                                                        @if($ThumbnailSetting->featured == 1 && $wishlist->featured == 1)
                                                            <span class="position-relative text-white">
                                                               {{ __('Featured') }}
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <div class="movie-time d-flex align-items-center pt-1">
                                                        @php
                                                            $CategoryThumbnail_setting = App\CategoryVideo::join('video_categories', 'video_categories.id', '=', 'categoryvideos.category_id')
                                                                ->where('categoryvideos.video_id', $wishlist->id)
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

                                                <a class="epi-name mt-2 mb-0 btn" href="{{ URL::to('category') . '/videos/' . $wishlist->slug }}">
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
                            {!! $wishlist_pagelist->links() !!}
                        </div>

                    </div>
                @else
                    <div class="col-md-12 text-center mt-4"
                        style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                        <p>
                        <h3 class="text-center">{{ __('No Wishlist Available') }}</h3>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
<?php include public_path("themes/$current_theme/views/footer.blade.php"); ?>

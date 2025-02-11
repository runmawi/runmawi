<?php

$data = App\LiveCategory::query()->limit(15)
    ->whereHas('category_livestream', function ($query) {
        $query->where('live_streams.active', 1)->where('live_streams.status', 1);
    })

    ->with([
        'category_livestream' => function ($live_stream_videos) {
            $live_stream_videos
                ->select('live_streams.id', 'live_streams.title', 'live_streams.slug', 'live_streams.year', 'live_streams.rating', 'live_streams.access', 'live_streams.ppv_price', 'live_streams.publish_type', 
                        'live_streams.publish_status', 'live_streams.publish_time', 'live_streams.duration', 'live_streams.rating', 'live_streams.image', 'live_streams.featured', 'live_streams.player_image', 
                        'live_streams.description','live_streams.recurring_program','live_streams.program_start_time','live_streams.program_end_time','live_streams.recurring_timezone',
                        'live_streams.custom_start_program_time','live_streams.recurring_timezone')
                ->where('live_streams.active', 1)
                ->where('live_streams.status', 1)
                ->latest('live_streams.created_at')
                ->limit(15);
        },
    ])
    ->select('live_categories.id', 'live_categories.name', 'live_categories.slug', 'live_categories.order')
    ->orderBy('live_categories.order')
    ->get();

$data->each(function ($category) {
    $category->category_livestream->transform(function ($item) {
        $item['image_url'] = URL::to('public/uploads/images/' . $item->image);
        $item['Player_image_url'] = URL::to('public/uploads/images/' . $item->player_image);
        $item['description'] = $item->description;
        $item['source'] = 'Livestream';
        return $item;
    });
    $category->source = 'live_category';
    return $category;
});

?>

@if (!empty($data) && $data->isNotEmpty())

    @foreach( $data as $key => $live_Category )
        @php
            $id = !Auth::guest() && !empty($data['password_hash']) ? Auth::user()->id : 0;
        @endphp

        <section id="iq-favorites">
            <div class="container-fluid overflow-hidden">
                <div class="row">
                    <div class="col-sm-12 ">
                                
                        <div class="iq-main-header d-flex align-items-center justify-content-between">
                            <!-- <h4 class="main-title"><a href="{{ URL::to('home') }}">Latest Videos</a></h4> -->
                            <a href="{{ URL::to('/live/category/') . '/' . $live_Category->slug }}" class="category-heading" style="text-decoration:none;color:#fff">
                                <h4 class="movie-title">
                                    @if(!empty($live_Category->home_genre))
                                        {{ __('Live') . ' ' . __($live_Category->home_genre) }}
                                    @else
                                        {{ __('Live') . ' ' . __($live_Category->name) }}
                                    @endif
                                </h4>
                            </a>
                            @if($settings->homepage_views_all_button_status == 1)
                                <h4 class="main-title view-all">
                                    <a href="{{ URL::to('/live/category/') . '/' . $live_Category->slug }}">{{ __('View all') }}</a>
                                </h4>
                            @endif
                        </div>

                        <div class="favorites-contens">
                            <div class="livestream-based-category home-sec list-inline row p-0 mb-0">
                                @php
                                    $id = !Auth::guest() && !empty($data['password_hash']) ? Auth::user()->id : 0;
                                @endphp

                                @foreach ($live_Category->category_livestream as $livestream )
                                    
                                    <div class="items">
                                        <div class="block-images position-relative">
                                            <div class="border-bg">
                                                <div class="img-box">
                                                    <a class="playTrailer" href="{{ URL::to('live/'.$livestream->slug) }}">
                                                        <img class="img-fluid w-100 flickity-lazyloaded" data-flickity-lazyload="{{ $livestream->image ? URL::to('public/uploads/images/'. $livestream->image) : $default_vertical_image_url }}" alt="{{ $livestream->title }}">
                                                    </a>

                                                    @if($ThumbnailSetting->free_or_cost_label == 1)

                                                        @switch(true)
                                                            @case($livestream->access == 'subscriber')
                                                                <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                            @break

                                                            @case($livestream->access == 'registered')
                                                                <p class="p-tag">{{ __('Register Now') }}</p>
                                                            @break

                                                            @case(!empty($livestream->ppv_price))
                                                                <p class="p-tag">{{ $currency->symbol . ' ' . $livestream->ppv_price }}</p>
                                                            @break

                                                            @case(!empty($livestream->global_ppv) || (!empty($livestream->global_ppv) && $livestream->ppv_price == null))
                                                                <p class="p-tag">{{ $livestream->global_ppv . ' ' . $currency->symbol }}</p>
                                                            @break

                                                            @case(empty($livestream->global_ppv) && $livestream->ppv_price == null)
                                                                <p class="p-tag">{{ __('Free') }}</p>
                                                            @break
                                                        @endswitch
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="block-description">
                                                <a class="playTrailer" href="{{ URL::to('live') . '/' . $livestream->slug }}">
                                                    {{-- <img class="img-fluid w-100" loading="lazy" data-src="{{ $livestream->player_image ? URL::to('public/uploads/images/'. $livestream->player_image) : $default_vertical_image_url }}" src="{{ $livestream->player_image ? URL::to('public/uploads/images/'. $livestream->player_image) : $default_vertical_image_url }}" alt="{{ $livestream->title }}"> --}}

                                                    @if($ThumbnailSetting->free_or_cost_label == 1)

                                                        @switch(true)
                                                            @case($livestream->access == 'subscriber')
                                                                <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                            @break

                                                            @case($livestream->access == 'registered')
                                                                <p class="p-tag">{{ __('Register Now') }}</p>
                                                            @break

                                                            @case(!empty($livestream->ppv_price))
                                                                <p class="p-tag">{{ $currency->symbol . ' ' . $livestream->ppv_price }}</p>
                                                            @break

                                                            @case(!empty($livestream->global_ppv) || (!empty($livestream->global_ppv) && $livestream->ppv_price == null))
                                                                <p class="p-tag">{{ $livestream->global_ppv . ' ' . $currency->symbol }}</p>
                                                            @break

                                                            @case(empty($livestream->global_ppv) && $livestream->ppv_price == null)
                                                                <p class="p-tag">{{ __('Free') }}</p>
                                                            @break
                                                        @endswitch
                                                    @endif
                                                </a>

                                                <div class="hover-buttons text-white">
                                                    <a href="{{ URL::to('live') . '/' . $livestream->slug }}">
                                                        @if($ThumbnailSetting->title == 1)
                                                            <!-- Title -->
                                                            <p class="epi-name text-left m-0 mt-2">
                                                                {{ strlen($livestream->title) > 17 ? substr($livestream->title, 0, 18) . '...' : $livestream->title }}
                                                            </p>
                                                        @endif

                                                        @if($ThumbnailSetting->enable_description == 1)
                                                            <p class="desc-name text-left m-0 mt-1">
                                                                {{ strlen($livestream->description) > 75 ? substr(html_entity_decode(strip_tags($livestream->description)), 0, 75) . '...' : strip_tags($livestream->description) }}
                                                            </p>
                                                        @endif

                                                        <div class="movie-time d-flex align-items-center pt-2">
                                                            @if($ThumbnailSetting->age == 1 && !($livestream->age_restrict == 0))
                                                                <span class="position-relative badge p-1 mr-2">{{ $livestream->age_restrict}}</span>
                                                            @endif

                                                            @if($ThumbnailSetting->duration == 1)
                                                                <span class="position-relative text-white mr-2">
                                                                    {{ (floor($livestream->duration / 3600) > 0 ? floor($livestream->duration / 3600) . 'h ' : '') . floor(($livestream->duration % 3600) / 60) . 'm' }}
                                                                </span>
                                                            @endif
                                                            @if($ThumbnailSetting->published_year == 1 && !($livestream->year == 0))
                                                                <span class="position-relative badge p-1 mr-2">
                                                                    {{ __($livestream->year) }}
                                                                </span>
                                                            @endif
                                                            @if($ThumbnailSetting->featured == 1 && $livestream->featured == 1)
                                                                <span class="position-relative text-white">
                                                                   {{ __('Featured') }}
                                                                </span>
                                                            @endif
                                                        </div>

                                                        <div class="movie-time d-flex align-items-center pt-1">
                                                            @php
                                                                $CategoryThumbnail_setting = App\CategoryLive::join('live_categories', 'live_categories.id', '=', 'livecategories.category_id')
                                                                    ->where('livecategories.live_id', $livestream->id)
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
                                                    href="{{ URL::to('/') . '/live/' . $livestream->slug }}">
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
    @endforeach
@endif

<script>
    var elem = document.querySelector('.livestream-based-category');
    var flkty = new Flickity(elem, {
        cellAlign: 'left',
        contain: true,
        groupCells: false,
        pageDots: false,
        draggable: true,
        freeScroll: true,
        imagesLoaded: true,
        lazyLoad: 7,
    });
 </script>
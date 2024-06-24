@if (!empty($data) && $data->isNotEmpty())

    <section id="iq-favorites">
        <div class="container-fluid overflow-hidden">
            <div class="row">
                <div class="col-sm-12 ">

                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title"><a href="">{{ __('Top Most Watched Videos') }} </a></h4> 
                        @if($settings->homepage_views_all_button_status == 1)
                            <h4 class="main-title"><a href="">{{ __('View All') }}</a></h4>
                        @endif
                    </div>
                    <div class="favorites-contens">
                        <ul class="favorites-slider list-inline row p-0 mb-0">
                            @isset($data)
                                @foreach($data as $most_watched_video)
                                    <li class="slide-item">
                                        <div class="block-images position-relative">
                                            <div class="border-bg">
                                                <div class="img-box">
                                                    <a class="playTrailer" href="{{ URL::to('category/videos/' . $most_watched_video->slug) }}">
                                                        <img class="img-fluid w-100" loading="lazy" data-src="{{ $most_watched_video->image ? URL::to('/public/uploads/images/' . $most_watched_video->image) : $default_vertical_image_url }}" src="{{ $most_watched_video->image ? URL::to('/public/uploads/images/' . $most_watched_video->image) : $default_vertical_image_url }}" alt="{{ $most_watched_video->title }}"> 
                                                    </a>

                                                    <!-- PPV price -->
                                                    @if($ThumbnailSetting->free_or_cost_label == 1)
                                                        @if($most_watched_video->access == 'subscriber')
                                                            <p class="p-tag"><i class="fas fa-crown" style='color:gold'></i></p>
                                                        @elseif($most_watched_video->access == 'registered')
                                                            <p class="p-tag">{{ __('Register Now') }}</p>
                                                        @elseif(!empty($most_watched_video->ppv_price))
                                                            <p class="p-tag1">{{ $currency->symbol . ' ' . $most_watched_video->ppv_price }}</p>
                                                        @elseif(!empty($most_watched_video->global_ppv) || (!empty($most_watched_video->global_ppv) && $most_watched_video->ppv_price == null))
                                                            <p class="p-tag1">{{ $most_watched_video->global_ppv . ' ' . $currency->symbol }}</p>
                                                        @elseif($most_watched_video->global_ppv == null && $most_watched_video->ppv_price == null)
                                                            <p class="p-tag">{{ __('Free') }}</p>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="block-description">
                                                <a class="playTrailer" href="{{ URL::to('category/videos/' . $most_watched_video->slug) }}">
                                                    <img class="img-fluid w-100" loading="lazy" data-src="{{ $most_watched_video->player_image ? URL::to('/public/uploads/images/' . $most_watched_video->player_image) : $default_vertical_image_url }}" src="{{ $most_watched_video->player_image ? URL::to('/public/uploads/images/' . $most_watched_video->player_image) : $default_vertical_image_url }}" alt="{{ $most_watched_video->title }}"> 
                                                </a>

                                                <!-- PPV price -->
                                                @if($ThumbnailSetting->free_or_cost_label == 1)
                                                    @if($most_watched_video->access == 'subscriber')
                                                        <p class="p-tag"><i class="fas fa-crown" style='color:gold'></i></p>
                                                    @elseif($most_watched_video->access == 'registered')
                                                        <p class="p-tag">{{ __('Register Now') }}</p>
                                                    @elseif(!empty($most_watched_video->ppv_price))
                                                        <p class="p-tag1">{{ $currency->symbol . ' ' . $most_watched_video->ppv_price }}</p>
                                                    @elseif(!empty($most_watched_video->global_ppv) || (!empty($most_watched_video->global_ppv) && $most_watched_video->ppv_price == null))
                                                        <p class="p-tag1">{{ $most_watched_video->global_ppv . ' ' . $currency->symbol }}</p>
                                                    @elseif($most_watched_video->global_ppv == null && $most_watched_video->ppv_price == null)
                                                        <p class="p-tag">{{ __('Free') }}</p>
                                                    @endif
                                                @endif

                                                <div class="hover-buttons text-white">
                                                    <a href="{{ URL::to('category/videos/' . $most_watched_video->slug) }}">
                                                        @if($ThumbnailSetting->title == 1)
                                                            <p class="epi-name text-left m-0">
                                                                {{ strlen($most_watched_video->title) > 17 ? substr($most_watched_video->title, 0, 18) . '...' : $most_watched_video->title }}
                                                            </p>
                                                        @endif

                                                        <div class="movie-time d-flex align-items-center pt-1">
                                                            @if($ThumbnailSetting->age == 1 && !($most_watched_video->age_restrict == 0))
                                                                <div class="badge badge-secondary p-1 mr-2">{{ $most_watched_video->age_restrict . ' +' }}</div>
                                                            @endif

                                                            @if($ThumbnailSetting->duration == 1)
                                                                <span class="text-white">
                                                                    <i class="fa fa-clock-o"></i>
                                                                    {{ gmdate('H:i:s', $most_watched_video->duration) }}
                                                                </span>
                                                            @endif
                                                        </div>

                                                        @if($ThumbnailSetting->published_year == 1 || $ThumbnailSetting->rating == 1)
                                                            <div class="movie-time d-flex align-items-center pt-2">
                                                                @if($ThumbnailSetting->rating == 1)
                                                                    <div class="badge badge-secondary p-1 mr-2">
                                                                        <span class="text-white">
                                                                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                                            {{ __($most_watched_video->rating) }}
                                                                        </span>
                                                                    </div>
                                                                @endif

                                                                @if($ThumbnailSetting->published_year == 1)
                                                                    <div class="badge badge-secondary p-1 mr-2">
                                                                        <span class="text-white">
                                                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                            {{ __($most_watched_video->year) }}
                                                                        </span>
                                                                    </div>
                                                                @endif

                                                                @if($ThumbnailSetting->featured == 1 && $most_watched_video->featured == 1)
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
                                                                $CategoryThumbnail_setting = App\CategoryVideo::join('video_categories', 'video_categories.id', '=', 'categoryvideos.category_id')
                                                                    ->where('categoryvideos.video_id', $most_watched_video->id)
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

                                                    <a class="epi-name mt-3 mb-0 btn" href="{{ URL::to('category/videos/' . $most_watched_video->slug) }}">
                                                        <img class="d-inline-block ply" alt="ply" src="{{ URL::to('/assets/img/default_play_buttons.svg') }}" width="10%" height="10%"/> {{ __('Watch Now') }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            @endisset
                        </ul>
                    </div>
                
                </div>
            </div>
        </div>
    </section>

@endif
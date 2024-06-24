
@if (!empty($data) && $data->isNotEmpty())
    <section id="iq-favorites">
        <div class="container-fluid overflow-hidden">
            <div class="row">
                <div class="col-sm-12">

                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title"><a href="">{{ __('Most Watched Videos - User') }}</a></h4>
                        @if($settings->homepage_views_all_button_status == 1)
                            <h4 class="main-title"><a href="">{{ __('View All') }}</a></h4>
                        @endif
                    </div>
                    <div class="favorites-contens">
                        <ul class="favorites-slider list-inline row p-0 mb-0">
                            @foreach($data as $watchlater_video)
                                <li class="slide-item">
                                    <div class="block-images position-relative">
                                        <!-- block-images -->
                                        <div class="border-bg">
                                            <div class="img-box">
                                                <a class="playTrailer" href="{{ url('category/videos/' . $watchlater_video->slug) }}">
                                                    <img class="img-fluid w-100" loading="lazy" data-src="{{ $watchlater_video->image ? URL::to('/public/uploads/images/' . $watchlater_video->image) : $default_vertical_image_url }}" src="{{ $watchlater_video->image ? URL::to('/public/uploads/images/' . $watchlater_video->image) : $default_vertical_image_url }}" alt="{{ $watchlater_video->title }}">
                                                </a>

                                                <!-- PPV price -->
                                                @if($ThumbnailSetting->free_or_cost_label == 1)
                                                    @switch(true)
                                                        @case($watchlater_video->access == 'subscriber')
                                                            <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                        @break
                                                        @case($watchlater_video->access == 'registered')
                                                            <p class="p-tag">{{ __('Register Now') }}</p>
                                                        @break
                                                        @case(!empty($watchlater_video->ppv_price))
                                                            <p class="p-tag">{{ $currency->symbol . ' ' . $watchlater_video->ppv_price }}</p>
                                                        @break
                                                        @case(!empty($watchlater_video->global_ppv) && $watchlater_video->ppv_price == null)
                                                            <p class="p-tag">{{ $watchlater_video->global_ppv . ' ' . $currency->symbol }}</p>
                                                        @break
                                                        @case($watchlater_video->global_ppv == null && $watchlater_video->ppv_price == null)
                                                            <p class="p-tag">{{ __('Free') }}</p>
                                                        @break
                                                    @endswitch
                                                @endif
                                            </div>
                                        </div>

                                        <div class="block-description">
                                            <a class="playTrailer" href="{{ url('category/videos/' . $watchlater_video->slug) }}">
                                            <img class="img-fluid w-100" loading="lazy" data-src="{{ $watchlater_video->player_image ? URL::to('/public/uploads/images/' . $watchlater_video->player_image) : $default_vertical_image_url }}" src="{{ $watchlater_video->player_image ? URL::to('/public/uploads/images/' . $watchlater_video->player_image) : $default_vertical_image_url }}" alt="{{ $watchlater_video->title }}">

                                                <!-- PPV price -->
                                                @if($ThumbnailSetting->free_or_cost_label == 1)
                                                    @switch(true)
                                                        @case($watchlater_video->access == 'subscriber')
                                                            <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                        @break
                                                        @case($watchlater_video->access == 'registered')
                                                            <p class="p-tag">{{ __('Register Now') }}</p>
                                                        @break
                                                        @case(!empty($watchlater_video->ppv_price))
                                                            <p class="p-tag">{{ $currency->symbol . ' ' . $watchlater_video->ppv_price }}</p>
                                                        @break
                                                        @case(!empty($watchlater_video->global_ppv) && $watchlater_video->ppv_price == null)
                                                            <p class="p-tag">{{ $watchlater_video->global_ppv . ' ' . $currency->symbol }}</p>
                                                        @break
                                                        @case($watchlater_video->global_ppv == null && $watchlater_video->ppv_price == null)
                                                            <p class="p-tag">{{ __('Free') }}</p>
                                                        @break
                                                    @endswitch
                                                @endif
                                            </a>

                                            <div class="hover-buttons text-white">
                                                <a href="{{ url('category/videos/' . $watchlater_video->slug) }}">
                                                    @if($ThumbnailSetting->title == 1)
                                                        <!-- Title -->
                                                        <p class="epi-name text-left m-0">
                                                            {{ (strlen($watchlater_video->title) > 17) ? substr($watchlater_video->title, 0, 18) . '...' : $watchlater_video->title }}
                                                        </p>
                                                    @endif

                                                    <div class="movie-time d-flex align-items-center pt-1">
                                                        @if($ThumbnailSetting->age == 1)
                                                            <!-- Age -->
                                                            <div class="badge badge-secondary p-1 mr-2">{{ $watchlater_video->age_restrict . ' +' }}</div>
                                                        @endif

                                                        @if($ThumbnailSetting->duration == 1)
                                                            <!-- Duration -->
                                                            <span class="text-white"><i class="fa fa-clock-o"></i> {{ gmdate('H:i:s', $watchlater_video->duration) }}</span>
                                                        @endif
                                                    </div>

                                                    @if($ThumbnailSetting->published_year == 1 || $ThumbnailSetting->rating == 1)
                                                        <div class="movie-time d-flex align-items-center pt-1">
                                                            @if($ThumbnailSetting->rating == 1)
                                                                <!-- Rating -->
                                                                <div class="badge badge-secondary p-1 mr-2">
                                                                    <span class="text-white">
                                                                        <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                                        {{ __($watchlater_video->rating) }}
                                                                    </span>
                                                                </div>
                                                            @endif

                                                            @if($ThumbnailSetting->published_year == 1)
                                                                <!-- Published Year -->
                                                                <div class="badge badge-secondary p-1 mr-2">
                                                                    <span class="text-white">
                                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                        {{ __($watchlater_video->year) }}
                                                                    </span>
                                                                </div>
                                                            @endif

                                                            @if($ThumbnailSetting->featured == 1 && $watchlater_video->featured == 1)
                                                                <!-- Featured -->
                                                                <div class="badge badge-secondary p-1 mr-2">
                                                                    <span class="text-white">
                                                                        <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                                    </span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endif

                                                    <div class="movie-time d-flex align-items-center pt-1">
                                                        <!-- Category Thumbnail setting -->
                                                        @php
                                                            $CategoryThumbnail_setting = App\CategoryVideo::join('video_categories', 'video_categories.id', '=', 'categoryvideos.category_id')
                                                                ->where('categoryvideos.video_id', $watchlater_video->id)
                                                                ->pluck('video_categories.name');
                                                        @endphp

                                                        @if($ThumbnailSetting->category == 1 && count($CategoryThumbnail_setting) > 0)
                                                            <span class="text-white">
                                                                <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                                @php
                                                                    $Category_Thumbnail = array();
                                                                    foreach($CategoryThumbnail_setting as $key => $CategoryThumbnail) {
                                                                        $Category_Thumbnail[] = $CategoryThumbnail;
                                                                    }
                                                                    echo implode(', ', $Category_Thumbnail);
                                                                @endphp
                                                            </span>
                                                        @endif
                                                    </div>
                                                </a>

                                                <a class="epi-name mt-3 mb-0 btn" href="{{ url('category/videos/' . $watchlater_video->slug) }}">
                                                    <img class="d-inline-block ply" alt="ply" src="{{ url('/assets/img/default_play_buttons.svg') }}" width="10%" height="10%" /> Watch Now
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>
@endif

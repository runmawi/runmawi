@if(!empty($data) && $data->isNotEmpty())

    <section id="iq-favorites">
        <div class="container-fluid overflow-hidden">
            <div class="row">
                <div class="col-sm-12 ">

                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title">
                            <a href="{{ $order_settings_list[3]->header_name ? URL::to('/') . '/' . $order_settings_list[3]->url : '' }}">
                                {{ $order_settings_list[3]->header_name ? __($order_settings_list[3]->header_name) : '' }}
                            </a>
                        </h4>
                        @if($settings->homepage_views_all_button_status == 1)
                            <h4 class="main-title">
                                <a href="{{ $order_settings_list[3]->header_name ? URL::to('/') . '/' . $order_settings_list[3]->url : '' }}">{{ __('View All') }}</a>
                            </h4>
                        @endif
                    </div>

                    <div class="favorites-contens">
                        <ul class="favorites-slider list-inline row p-0 mb-0">
                            @if(isset($data))
                                @foreach($data as $video)
                                    @php
                                        $publish_time = 'Published';
                                        $publish_day = '';

                                        if (!empty($video->publish_time)) {
                                            date_default_timezone_set('Asia/Kolkata');
                                            $current_date = Date("M d , y H:i:s");
                                            $date = date_create($current_date);
                                            $currentdate = date_format($date, "D h:i");
                                            $publish_time = date("D h:i", strtotime($video->publish_time));

                                            if ($video->publish_type == 'publish_later') {
                                                if ($currentdate < $publish_time) {
                                                    $publish_time = \Carbon\Carbon::parse($video->created_at, 'Asia/Kolkata')->format('h:i');
                                                    $publish_day = \Carbon\Carbon::parse($video->created_at, 'Asia/Kolkata')->format('l');
                                                }
                                            } elseif ($video->publish_type == 'publish_now') {
                                                $currentdate = date_format($date, "y M D");
                                                $publish_time = date("y M D", strtotime($video->created_at));

                                                if ($currentdate == $publish_time) {
                                                    $publish_time = \Carbon\Carbon::parse($video->created_at, 'Asia/Kolkata')->format('h:i');
                                                    $publish_day = \Carbon\Carbon::parse($video->created_at, 'Asia/Kolkata')->format('l');
                                                }
                                            }
                                        }
                                    @endphp

                                    <li class="slide-item">
                                        <div class="block-images position-relative">
                                            <div class="border-bg">
                                                <div class="img-box">
                                                    <a class="playTrailer" href="{{ URL::to('/') . '/live/' . $video->slug }}">
                                                        <img class="img-fluid w-100" loading="lazy" data-src="{{ $video->image ? URL::to('/public/uploads/images/' . $video->image) : $default_vertical_image_url }}" src="{{ $video->image ? URL::to('/public/uploads/images/' . $video->image) : $default_vertical_image_url }}" alt="{{ $video->title }}" />
                                                    </a>

                                                    @if($ThumbnailSetting->free_or_cost_label == 1)
                                                        @if($video->access == 'subscriber')
                                                            <p class="p-tag"><i class="fas fa-crown" style='color:gold'></i></p>
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

                                            <div class="block-description">
                                                <a class="playTrailer" href="{{ URL::to('/') . '/live/' . $video->slug }}">
                                                    <img class="img-fluid w-100" loading="lazy" data-src="{{ $video->player_image ? URL::to('/public/uploads/images/' . $video->player_image) : $default_vertical_image_url }}" src="{{ $video->player_image ? URL::to('/public/uploads/images/' . $video->player_image) : $default_vertical_image_url }}" alt="{{ $video->title }}" />
                                                </a>

                                                @if($ThumbnailSetting->free_or_cost_label == 1)
                                                    @if($video->access == 'subscriber')
                                                        <p class="p-tag"><i class="fas fa-crown" style='color:gold'></i></p>
                                                    @elseif($video->access == 'registered')
                                                        <p class="p-tag">{{ __('Register Now') }}</p>
                                                    @elseif(!empty($video->ppv_price))
                                                        <p class="p-tag1">{{ $currency->symbol . ' ' . $video->ppv_price }}</p>
                                                    @else
                                                        <p class="p-tag">{{ __('Free') }}</p>
                                                    @endif
                                                @endif

                                                <div class="hover-buttons text-white">
                                                    <a href="{{ URL::to('/') . '/live/' . $video->slug }}">
                                                        @if($ThumbnailSetting->title == 1)
                                                            <p class="epi-name text-left m-0">{{ strlen($video->title) > 17 ? substr($video->title, 0, 18) . '...' : $video->title }}</p>
                                                        @endif

                                                        <div class="movie-time d-flex align-items-center my-2">
                                                            @if($ThumbnailSetting->duration == 1)
                                                                <span class="text-white">
                                                                    <i class="fa fa-clock-o"></i>
                                                                    {{ gmdate('H:i:s', $video->duration) }}
                                                                </span>
                                                            @endif
                                                        </div>

                                                        @if($ThumbnailSetting->published_year == 1 || $ThumbnailSetting->rating == 1)
                                                            <div class="movie-time d-flex align-items-center my-2">
                                                                @if($ThumbnailSetting->rating == 1)
                                                                    <div class="badge badge-secondary p-1 mr-2">
                                                                        <span class="text-white">
                                                                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                                            {{ __($video->rating) }}
                                                                        </span>
                                                                    </div>
                                                                @endif

                                                                @if($ThumbnailSetting->published_year == 1)
                                                                    <div class="badge badge-secondary p-1 mr-2">
                                                                        <span class="text-white">
                                                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                            {{ __($video->year) }}
                                                                        </span>
                                                                    </div>
                                                                @endif

                                                                @if($ThumbnailSetting->featured == 1 && $video->featured == 1)
                                                                    <div class="badge badge-secondary p-1 mr-2">
                                                                        <span class="text-white">
                                                                            <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                                        </span>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endif

                                                        <div class="movie-time d-flex align-items-center my-2">
                                                            @php
                                                                $CategoryThumbnail_setting = App\LiveCategory::join('livecategories', 'livecategories.category_id', '=', 'live_categories.id')
                                                                    ->where('livecategories.live_id', $video->id)
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

                                                    <a class="epi-name mt-3 mb-0 btn" href="{{ URL::to('/') . '/live/' . $video->slug }}">
                                                        <img class="d-inline-block ply" alt="ply" src="{{ URL::to('/assets/img/default_play_buttons.svg') }}" width="10%" height="10%" />
                                                        Live Now
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endif

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
                            <h5 class="main-title view-all">
                                <a href="{{ $order_settings_list[3]->header_name ? URL::to('/') . '/' . $order_settings_list[3]->url : '' }}">{{ __('View all') }}</a>
                            </h5>
                        @endif
                    </div>

                    <div class="favorites-contens">
                        <div class="live-video home-sec list-inline row p-0 mb-0">
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

                                    <div class="items">
                                        <div class="block-images position-relative">
                                            <div class="border-bg">
                                                <div class="img-box">
                                                    <a class="playTrailer" href="{{ URL::to('/') . '/live/' . $video->slug }}"  aria-label="LiveStream-PlayTrailer">
                                                        <img class="img-fluid w-100 flickity-lazyloaded" data-flickity-lazyload="{{ $video->image ? URL::to('/public/uploads/images/' . $video->image) : $default_vertical_image_url }}" alt="{{ $video->title }}"/>
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
                                                <a class="playTrailer" href="{{ URL::to('/') . '/live/' . $video->slug }}" aria-label="LiveStream-PlayTrailer">
                                                    {{-- <img class="img-fluid w-100" loading="lazy" data-src="{{ $video->player_image ? URL::to('/public/uploads/images/' . $video->player_image) : $default_vertical_image_url }}" src="{{ $video->player_image ? URL::to('/public/uploads/images/' . $video->player_image) : $default_vertical_image_url }}" alt="{{ $video->title }}" /> --}}
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
                                                            <p class="epi-name text-left m-0 mt-2">{{ strlen($video->title) > 17 ? substr($video->title, 0, 18) . '...' : $video->title }}</p>
                                                        @endif

                                                        @if($ThumbnailSetting->enable_description == 1)
                                                            <p class="desc-name text-left m-0 mt-1">
                                                                {{ strlen($video->description) > 75 ? (html_entity_decode(strip_tags($video->description))) . '...' : strip_tags($video->description) }}
                                                            </p>
                                                        @endif

                                                        <div class="movie-time d-flex align-items-center my-2 pt-2">
                                                            @if($ThumbnailSetting->age == 1 && !($video->age_restrict == 0))
                                                                <span class="position-relative badge p-1 mr-2">{{ $video->age_restrict}}</span>
                                                            @endif

                                                            @if($ThumbnailSetting->duration == 1)
                                                                <span class="position-relative text-white mr-2">
                                                                    {{ (floor($video->duration / 3600) > 0 ? floor($video->duration / 3600) . 'h ' : '') . floor(($video->duration % 3600) / 60) . 'm' }}
                                                                </span>
                                                            @endif
                                                            @if($ThumbnailSetting->published_year == 1 && !($video->year == 0))
                                                                <span class="position-relative badge p-1 mr-2">
                                                                    {{ __($video->year) }}
                                                                </span>
                                                            @endif
                                                            @if($ThumbnailSetting->featured == 1 && $video->featured == 1)
                                                                <span class="position-relative text-white">
                                                                   {{ __('Featured') }}
                                                                </span>
                                                            @endif
                                                        </div>

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

                                                    <a class="epi-name mt-2 mb-0 btn" href="{{ URL::to('/') . '/live/' . $video->slug }}">
                                                        <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                        {{ __(!empty($button_text->play_btn_live)? $button_text->play_btn_live : 'Live Now') }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endif

<script>
    var elem = document.querySelector('.live-video');
    if (elem) {
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
    } else {
        console.error("Carousel element not found");
    }
 </script>
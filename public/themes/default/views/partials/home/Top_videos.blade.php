@if (!empty($data) && $data->isNotEmpty())

    <section id="iq-favorites">
        <div class="container-fluid overflow-hidden">
            <div class="row">
                <div class="col-sm-12 ">

                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title"><a href="">{{ __('Top Most Watched Videos') }} </a></h4> 
                        @if($settings->homepage_views_all_button_status == 1)
                            <h4 class="main-title view-all"><a href="">{{ __('View all') }}</a></h4>
                        @endif
                    </div>
                    <div class="favorites-contens">
                        <div class="top-video home-sec list-inline row p-0 mb-0">
                            @foreach($data as $most_watched_video)
                                <div class="items">
                                    <div class="block-images position-relative">
                                        <div class="border-bg">
                                            <div class="img-box">
                                                <a class="playTrailer" href="{{ URL::to('category/videos/' . $most_watched_video->slug) }}">
                                                    <img class="img-fluid w-100 flickity-lazyloaded" src="{{ $most_watched_video->image ? URL::to('/public/uploads/images/' . $most_watched_video->image) : $default_vertical_image_url }}" alt="{{ $most_watched_video->title }}"> 
                                                </a>

                                                <!-- PPV price -->
                                                @if($ThumbnailSetting->free_or_cost_label == 1)
                                                    @switch(true)
                                                        @case($most_watched_video->access == 'subscriber')
                                                            <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                        @break
                                                        @case($most_watched_video->access == 'registered')
                                                            <p class="p-tag">{{ __('Register Now') }}</p>
                                                        @break
                                                        @case(!empty($most_watched_video->ppv_price))
                                                            <p class="p-tag">{{ $currency->symbol . ' ' . $most_watched_video->ppv_price }}</p>
                                                        @break
                                                        @case(!empty($most_watched_video->global_ppv) || (!empty($most_watched_video->global_ppv) && $most_watched_video->ppv_price == null))
                                                            <p class="p-tag">{{ $most_watched_video->global_ppv . ' ' . $currency->symbol }}</p>
                                                        @break
                                                        @case($most_watched_video->global_ppv == null && $most_watched_video->ppv_price == null)
                                                            <p class="p-tag">{{ __('Free') }}</p>
                                                        @break
                                                    @endswitch
                                                @endif
                                            </div>
                                        </div>

                                        <div class="block-description">
                                            <a class="playTrailer" href="{{ URL::to('category/videos/' . $most_watched_video->slug) }}">
                                                
                                                <!-- PPV price -->
                                                @if($ThumbnailSetting->free_or_cost_label == 1)
                                                    @switch(true)
                                                        @case($most_watched_video->access == 'subscriber')
                                                            <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                        @break
                                                        @case($most_watched_video->access == 'registered')
                                                            <p class="p-tag">{{ __('Register Now') }}</p>
                                                        @break
                                                        @case(!empty($most_watched_video->ppv_price))
                                                            <p class="p-tag">{{ $currency->symbol . ' ' . $most_watched_video->ppv_price }}</p>
                                                        @break
                                                        @case(!empty($most_watched_video->global_ppv) || (!empty($most_watched_video->global_ppv) && $most_watched_video->ppv_price == null))
                                                            <p class="p-tag">{{ $most_watched_video->global_ppv . ' ' . $currency->symbol }}</p>
                                                        @break
                                                        @case($most_watched_video->global_ppv == null && $most_watched_video->ppv_price == null)
                                                            <p class="p-tag">{{ __('Free') }}</p>
                                                        @break
                                                    @endswitch
                                                @endif
                                            </a>
                                            <div class="hover-buttons text-white">
                                                <a href="{{ URL::to('category/videos/' . $most_watched_video->slug) }}">
                                                    @if($ThumbnailSetting->title == 1)
                                                        <p class="epi-name text-left m-0 mt-2">
                                                            {{ strlen($most_watched_video->title) > 17 ? substr($most_watched_video->title, 0, 18) . '...' : $most_watched_video->title }}
                                                        </p>
                                                    @endif

                                                    @if($ThumbnailSetting->enable_description == 1)
                                                        <p class="desc-name text-left m-0 mt-1">
                                                            {{ strlen($most_watched_video->description) > 75 ? substr(html_entity_decode(strip_tags($most_watched_video->description)), 0, 75) . '...' : strip_tags($most_watched_video->description) }}
                                                        </p>
                                                    @endif

                                                    <div class="movie-time d-flex align-items-center pt-2">
                                                        @if($ThumbnailSetting->age == 1 && !($most_watched_video->age_restrict == 0))
                                                        <span class="position-relative badge p-1 mr-2">{{ $most_watched_video->age_restrict}}</span>
                                                        @endif

                                                        @if($ThumbnailSetting->duration == 1)
                                                            <span class="position-relative text-white mr-2">
                                                                {{ (floor($most_watched_video->duration / 3600) > 0 ? floor($most_watched_video->duration / 3600) . 'h ' : '') . floor(($most_watched_video->duration % 3600) / 60) . 'm' }}
                                                            </span>
                                                        @endif

                                                        @if($ThumbnailSetting->published_year == 1 && !($most_watched_video->year == 0))
                                                            <span class="position-relative badge p-1 mr-2">
                                                                {{ __($most_watched_video->year) }}
                                                            </span>
                                                        @endif

                                                        @if($ThumbnailSetting->featured == 1 && $most_watched_video->featured == 1)
                                                            <span class="position-relative text-white">
                                                                {{ __('Featured') }}
                                                            </span>
                                                        @endif
                                                    </div>

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

                                                <a class="epi-name mt-2 mb-0 btn" href="{{ URL::to('category/videos/' . $most_watched_video->slug) }}">
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
@endif

<script>
    var elem = document.querySelector('.top-video');
    var flkty = new Flickity(elem, {
        cellAlign: 'left',
        contain: true,
        groupCells: true,
        pageDots: false,
        draggable: true,
        freeScroll: true,
        imagesLoaded: true,
        lazyload: true,
    });
 </script>
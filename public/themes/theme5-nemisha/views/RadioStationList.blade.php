@php
    include(public_path('themes/theme5-nemisha/views/header.php'));
@endphp

<!-- MainContent -->

<div class="main-content">
    <section id="iq-favorites">
        <div class="container-fluid">
            <div class="row pageheight">
                <div class="col-sm-12 overflow-hidden">
                    <div class="iq-main-header align-items-center">
                        <h4>{{ __("Radio Station") }}</h4>
                    </div>
                    <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-4">
                            @if (count($station) > 0)
                                @foreach($station as $category_video)
                                    <li class="slide-item col-sm-2 col-md-2 col-xs-12 margin-bottom-30">
                                        <a href="{{ url('/radio-station/' . $category_video->slug) }}">
                                            <div class="block-images position-relative">
                                                <div class="img-box">
                                                    <img src="{{ url('/public/uploads/images/' . $category_video->image) }}" class="img-fluid" alt="">
                                                    
                                                    @if (!empty($category_video->ppv_price))
                                                        <p class="p-tag1">{{ $currency->symbol . ' ' . $category_video->ppv_price }}</p>
                                                    @elseif (!empty($category_video->global_ppv) || (!empty($category_video->global_ppv) && $category_video->ppv_price == null))
                                                        <p class="p-tag1">{{ $currency->symbol . ' ' . $category_video->global_ppv }}</p>
                                                    @else
                                                        <p class="p-tag">Free</p>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="block-description"></div>
                                            
                                            @if ($ThumbnailSetting->title == 1) <!-- Title -->
                                                <a href="{{ url('/radio-station/' . $category_video->slug) }}">
                                                    <h6>{{ strlen($category_video->title) > 17 ? substr($category_video->title, 0, 18) . '...' : $category_video->title }}</h6>
                                                </a>
                                            @endif  
                                            
                                            <div class="movie-time d-flex align-items-center pt-1">

                                                @if ($ThumbnailSetting->duration == 1) <!-- Duration -->
                                                    <span class="text-white">
                                                        <i class="fa fa-clock-o"></i> {{ gmdate('H:i:s', $category_video->duration) }}
                                                    </span>
                                                @endif
                                            </div>

                                            @if ($ThumbnailSetting->published_year == 1 || $ThumbnailSetting->rating == 1)
                                                <div class="movie-time d-flex align-items-center pt-1">
                                                    @if ($ThumbnailSetting->rating == 1) <!-- Rating -->
                                                        <div class="badge badge-secondary p-1 mr-2">
                                                            <span class="text-white">
                                                                <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                                {{ __($category_video->rating) }}
                                                            </span>
                                                        </div>
                                                    @endif

                                                    @if ($ThumbnailSetting->published_year == 1) <!-- Published Year -->
                                                        <div class="badge badge-secondary p-1 mr-2">
                                                            <span class="text-white">
                                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                {{ __($category_video->year) }}
                                                            </span>
                                                        </div>
                                                    @endif

                                                    @if ($ThumbnailSetting->featured == 1 && $category_video->featured == 1) <!-- Featured -->
                                                        <div class="badge badge-secondary p-1 mr-2">
                                                            <span class="text-white">
                                                                <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif

                                            <div class="movie-time my-2">
                                                <!-- Category Thumbnail Setting -->
                                                @php
                                                    $CategoryThumbnail_setting = App\CategoryLive::join('live_categories', 'live_categories.id', '=', 'livecategories.category_id')
                                                        ->where('livecategories.live_id', $category_video->id)
                                                        ->pluck('live_categories.name');
                                                @endphp

                                                @if ($ThumbnailSetting->category == 1 && count($CategoryThumbnail_setting) > 0)
                                                    <span class="text-white">
                                                        <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                        {{ implode(', ', $CategoryThumbnail_setting->toArray()) }}
                                                    </span>
                                                @endif
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            @else
                                <div class="col-md-12 text-center mt-4" style="background: url({{ url('/assets/img/watch.png') }}); height: 500px; background-position: center; background-repeat: no-repeat; background-size: cover; height: 500px !important;">
                                    <p>
                                        <h2 style="position: absolute; top: 50%; left: 50%; color: white;">No Contents Available</h2>
                                    </p>
                                </div>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


@php
    include(public_path('themes/theme5-nemisha/views/footer.blade.php'));
@endphp
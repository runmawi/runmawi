@if (!empty($data) && $data->isNotEmpty())

    <section id="iq-favorites">
        <div class="container-fluid overflow-hidden">
            <div class="row">
                <div class="col-sm-12">
       
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title"><a>{{ ucwords("Top Movies in " . Country_name() . " Today") }}</a></h4>
                            @if($settings->homepage_views_all_button_status == 1)
                                <h4 class="main-title"><a href="">{{ __('View All') }}</a></h4>      
                            @endif            
                    </div>
                    <div class="favorites-contens">
                        <ul class="favorites-slider list-inline row p-0 mb-0">
                            @if(isset($data))
                                @foreach($data as $Most_watched_countries)
                                    <li class="slide-item">
                                        <div class="block-images position-relative">
                                            <!-- block-images -->
                                            <div class="border-bg">
                                                <div class="img-box">
                                                    <a class="playTrailer" href="{{ URL::to('category/videos/' . $Most_watched_countries->slug) }}">
                                                        <img class="img-fluid w-100" loading="lazy" data-src="{{ $Most_watched_countries->image ? URL::to('/public/uploads/images/' . $Most_watched_countries->image) : $default_vertical_image_url }}" alt="{{ $Most_watched_countries->title }}"> 
                                                    </a>

                                                    <!-- PPV price -->
                                                    @if($ThumbnailSetting->free_or_cost_label == 1) 
                                                        @switch(true)
                                                            @case($Most_watched_countries->access == 'subscriber')
                                                                <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                            @break
                                                            @case($Most_watched_countries->access == 'registered')
                                                                <p class="p-tag">{{ __('Register Now') }}</p>
                                                            @break
                                                            @case(!empty($Most_watched_countries->ppv_price))
                                                                <p class="p-tag">{{ $currency->symbol . ' ' . $Most_watched_countries->ppv_price }}</p>
                                                            @break
                                                            @case(!empty($Most_watched_countries->global_ppv) && $Most_watched_countries->ppv_price == null)
                                                                <p class="p-tag">{{ $Most_watched_countries->global_ppv . ' ' . $currency->symbol }}</p>
                                                            @break
                                                            @case($Most_watched_countries->global_ppv == null && $Most_watched_countries->ppv_price == null)
                                                                <p class="p-tag">{{ __('Free') }}</p>
                                                            @break
                                                        @endswitch 
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="block-description">
                                                <a class="playTrailer" href="{{ URL::to('category/videos/' . $Most_watched_countries->slug) }}">
                                                    <img class="img-fluid w-100" loading="lazy" data-src="{{ $Most_watched_countries->player_image ? URL::to('/public/uploads/images/' . $Most_watched_countries->player_image) : $default_vertical_image_url }}" alt="{{ $Most_watched_countries->title }}"> 
                                                </a>

                                                <!-- PPV price -->
                                                @if($ThumbnailSetting->free_or_cost_label == 1)  
                                                    @switch(true)
                                                        @case($Most_watched_countries->access == 'subscriber')
                                                            <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                        @break
                                                        @case($Most_watched_countries->access == 'registered')
                                                            <p class="p-tag">{{ __('Register Now') }}</p>
                                                        @break
                                                        @case(!empty($Most_watched_countries->ppv_price))
                                                            <p class="p-tag">{{ $currency->symbol . ' ' . $Most_watched_countries->ppv_price }}</p>
                                                        @break
                                                        @case(!empty($Most_watched_countries->global_ppv) && $Most_watched_countries->ppv_price == null)
                                                            <p class="p-tag">{{ $Most_watched_countries->global_ppv . ' ' . $currency->symbol }}</p>
                                                        @break
                                                        @case($Most_watched_countries->global_ppv == null && $Most_watched_countries->ppv_price == null)
                                                            <p class="p-tag">{{ __('Free') }}</p>
                                                        @break
                                                    @endswitch 
                                                @endif

                                                <div class="hover-buttons text-white">
                                                    <a href="{{ URL::to('category/videos/' . $Most_watched_countries->slug) }}">
                                                        @if($ThumbnailSetting->title == 1)  
                                                            <!-- Title -->
                                                            <p class="epi-name text-left m-0">
                                                                {{ (strlen($Most_watched_countries->title) > 17) ? substr($Most_watched_countries->title, 0, 18) . '...' : $Most_watched_countries->title }}
                                                            </p>
                                                        @endif  

                                                        <div class="movie-time d-flex align-items-center pt-1">
                                                            @if($ThumbnailSetting->age == 1)
                                                                <!-- Age -->
                                                                <div class="badge badge-secondary p-1 mr-2">{{ $Most_watched_countries->age_restrict . ' +' }}</div>
                                                            @endif

                                                            @if($ThumbnailSetting->duration == 1)
                                                                <!-- Duration -->
                                                                <span class="text-white"><i class="fa fa-clock-o"></i> {{ gmdate('H:i:s', $Most_watched_countries->duration) }}</span>
                                                            @endif
                                                        </div>
                                                        
                                                        @if($ThumbnailSetting->published_year == 1 || $ThumbnailSetting->rating == 1)
                                                            <div class="movie-time d-flex align-items-center pt-1">
                                                                @if($ThumbnailSetting->rating == 1)
                                                                    <!-- Rating -->
                                                                    <div class="badge badge-secondary p-1 mr-2">
                                                                        <span class="text-white">
                                                                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                                            {{ __($Most_watched_countries->rating) }}
                                                                        </span>
                                                                    </div>
                                                                @endif

                                                                @if($ThumbnailSetting->published_year == 1)
                                                                    <!-- Published year -->
                                                                    <div class="badge badge-secondary p-1 mr-2">
                                                                        <span class="text-white">
                                                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                            {{ __($Most_watched_countries->year) }}
                                                                        </span>
                                                                    </div>
                                                                @endif

                                                                @if($ThumbnailSetting->featured == 1 && $Most_watched_countries->featured == 1)
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
                                                                    ->where('categoryvideos.video_id', $Most_watched_countries->id)
                                                                    ->pluck('video_categories.name');        
                                                            @endphp
                                                            @if($ThumbnailSetting->category == 1 && count($CategoryThumbnail_setting) > 0)
                                                                <span class="text-white">
                                                                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                                    @php
                                                                        $Category_Thumbnail = [];
                                                                        foreach($CategoryThumbnail_setting as $CategoryThumbnail) {
                                                                            $Category_Thumbnail[] = $CategoryThumbnail; 
                                                                        }
                                                                        echo implode(', ', $Category_Thumbnail);
                                                                    @endphp
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </a>
                                                    <a class="epi-name mt-3 mb-0 btn" href="{{ URL::to('category/videos/' . $Most_watched_countries->slug) }}">
                                                        <img class="d-inline-block ply" alt="ply" src="{{ URL::to('/') . '/assets/img/default_play_buttons.svg' }}" width="10%" height="10%"/> Watch Now
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

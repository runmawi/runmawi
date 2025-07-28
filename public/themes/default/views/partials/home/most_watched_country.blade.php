@if (!empty($data) && $data->isNotEmpty())

    <section id="iq-favorites">
        <div class="container-fluid overflow-hidden">
            <div class="row">
                <div class="col-sm-12">
       
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title"><a>{{ ucwords("Top Movies in " . Country_name() . " Today") }}</a></h4>
                            @if($settings->homepage_views_all_button_status == 1)
                                <h4 class="main-title view-all"><a href="">{{ __('View all') }}</a></h4>      
                            @endif            
                    </div>
                    <div class="favorites-contens">
                        <div class="most-watched-country home-sec list-inline row p-0 mb-0">
                            @if(isset($data))
                                @foreach($data as $Most_watched_countries)
                                    <div class="items">
                                        <div class="block-images position-relative">
                                            <!-- block-images -->
                                            <div class="border-bg">
                                                <div class="img-box">
                                                    <a class="playTrailer" href="{{ URL::to('category/videos/' . $Most_watched_countries->slug) }}">
                                                        <img class="img-fluid w-100" loading="lazy" data-src="{{ $Most_watched_countries->image ? URL::to('/public/uploads/images/' . $Most_watched_countries->image) : $default_vertical_image_url }}" data-flickity-lazyload="{{ $Most_watched_countries->image ? URL::to('/public/uploads/images/' . $Most_watched_countries->image) : $default_vertical_image_url }}" alt="{{ $Most_watched_countries->title }}"> 
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
                                                    {{-- <img class="img-fluid w-100" loading="lazy" data-src="{{ $Most_watched_countries->player_image ? URL::to('/public/uploads/images/' . $Most_watched_countries->player_image) : $default_vertical_image_url }}" src="{{ $Most_watched_countries->player_image ? URL::to('/public/uploads/images/' . $Most_watched_countries->player_image) : $default_vertical_image_url }}" alt="{{ $Most_watched_countries->title }}">  --}}
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
                                                            <p class="epi-name text-left m-0 mt-2">
                                                                {{ (strlen($Most_watched_countries->title) > 17) ? substr($Most_watched_countries->title, 0, 18) . '...' : $Most_watched_countries->title }}
                                                            </p>
                                                        @endif  

                                                        @if($ThumbnailSetting->enable_description == 1)
                                                            <p class="desc-name text-left mt-2 m-0 mt-1">
                                                                {{ strlen($Most_watched_countries->description) > 75 ? substr(html_entity_decode(strip_tags($Most_watched_countries->description)), 0, 75) . '...' : strip_tags($Most_watched_countries->description) }}
                                                            </p>
                                                        @endif

                                                        <div class="movie-time d-flex align-items-center pt-2">
                                                            @if($ThumbnailSetting->age == 1 && !($Most_watched_countries->age_restrict == 0))
                                                                <span class="position-relative badge p-1 mr-2">{{ $Most_watched_countries->age_restrict}}</span>
                                                            @endif

                                                            @if($ThumbnailSetting->duration == 1)
                                                                <span class="position-relative text-white mr-2">
                                                                    {{ (floor($Most_watched_countries->duration / 3600) > 0 ? floor($Most_watched_countries->duration / 3600) . 'h ' : '') . floor(($Most_watched_countries->duration % 3600) / 60) . 'm' }}
                                                                </span>
                                                            @endif
                                                            @if($ThumbnailSetting->published_year == 1 && !($Most_watched_countries->year == 0))
                                                                <span class="position-relative badge p-1 mr-2">
                                                                    {{ __($Most_watched_countries->year) }}
                                                                </span>
                                                            @endif
                                                            @if($ThumbnailSetting->featured == 1 && $Most_watched_countries->featured == 1)
                                                                <span class="position-relative text-white">
                                                                   {{ __('Featured') }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                        
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
                                                                    {{ implode(', ', $CategoryThumbnail_setting->toArray()) }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </a>
                                                    <a class="epi-name mt-2 mb-0 btn" href="{{ URL::to('category/videos/' . $Most_watched_countries->slug) }}">
                                                        <i class="fa fa-play mr-1" aria-hidden="true"></i>{{ __('Watch Now') }}
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
    var elem = document.querySelector('.most-watched-country');
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
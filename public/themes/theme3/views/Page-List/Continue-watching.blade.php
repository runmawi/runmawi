
@php
    include public_path("themes/{$current_theme}/views/header.php");
@endphp

<section id="iq-favorites" class="pagelist">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">

                @if(count($Video_cnt) > 0 || count($episode_cnt) > 0)

                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h2 class="main-title fira-sans-condensed-regular">
                            {{ __('Continue Watching List') }} 
                        </h2>  
                    </div>

                    <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">
                            @foreach($Video_cnt as $key => $video_details)
                                <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                    <div class="block-images position-relative">
                                        <div class="border-bg">
                                            <div class="img-box">
                                                <a class="playTrailer" href="{{ URL::to('category') . '/videos/' . $video_details->slug }}">
                                                    <img class="img-fluid w-100 flickity-lazyloaded" src="{{ $video_details->image ? URL::to('/public/uploads/images/'.$video_details->image) : $default_vertical_image_url }}" alt="{{ $video_details->title }}">
                                                </a>

                                                @if($ThumbnailSetting->free_or_cost_label == 1)
                                                    @switch(true)
                                                        @case($video_details->access == 'subscriber')
                                                            <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                        @break
                                                        @case($video_details->access == 'registered')
                                                            <p class="p-tag">{{ __('Register Now') }}</p>
                                                        @break
                                                        @case(!empty($video_details->ppv_price))
                                                            <p class="p-tag">{{ $currency->symbol . ' ' . $video_details->ppv_price }}</p>
                                                        @break
                                                        @case(!empty($video_details->global_ppv) && $video_details->ppv_price == null)
                                                            <p class="p-tag">{{ $video_details->global_ppv . ' ' . $currency->symbol }}</p>
                                                        @break
                                                        @case($video_details->global_ppv == null && $video_details->ppv_price == null)
                                                            <p class="p-tag">{{ __('Free') }}</p>
                                                        @break
                                                    @endswitch
                                                @endif
                                            </div>
                                        </div>
                                        <div class="block-description">
                                            <a class="playTrailer" href="{{ URL::to('category') . '/videos/' . $video_details->slug }}">

                                                @if($ThumbnailSetting->free_or_cost_label == 1)
                                                    @switch(true)
                                                        @case($video_details->access == 'subscriber')
                                                            <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                        @break
                                                        @case($video_details->access == 'registered')
                                                            <p class="p-tag">{{ __('Register Now') }}</p>
                                                        @break
                                                        @case(!empty($video_details->ppv_price))
                                                            <p class="p-tag">{{ $currency->symbol . ' ' . $video_details->ppv_price }}</p>
                                                        @break
                                                        @case(!empty($video_details->global_ppv) && $video_details->ppv_price == null)
                                                            <p class="p-tag">{{ $video_details->global_ppv . ' ' . $currency->symbol }}</p>
                                                        @break
                                                        @case($video_details->global_ppv == null && $video_details->ppv_price == null)
                                                            <p class="p-tag">{{ __('Free') }}</p>
                                                        @break
                                                    @endswitch
                                                @endif
                                            </a>

                                            <div class="hover-buttons text-white">
                                                <a href="{{ URL::to('category') . '/videos/' . $video_details->slug }}" aria-label="movie">
                                                    @if($ThumbnailSetting->title == 1)
                                                        <p class="epi-name text-left mt-2 m-0">
                                                            {{ strlen($video_details->title) > 17 ? substr($video_details->title, 0, 18).'...' : $video_details->title }}
                                                        </p>
                                                    @endif

                                                    @if($ThumbnailSetting->enable_description == 1)
                                                        <p class="desc-name text-left m-0 mt-1">
                                                            {{ strlen($video_details->description) > 75 ? substr(html_entity_decode(strip_tags($video_details->description)), 0, 75) . '...' : strip_tags($video_details->description) }}
                                                        </p>
                                                    @endif

                                                    <div class="movie-time d-flex align-items-center pt-2">
                                                        @if($ThumbnailSetting->age == 1 && !($video_details->age_restrict == 0))
                                                            <span class="position-relative p-1 mr-2">{{ $video_details->age_restrict}}</span>
                                                        @endif

                                                        @if($ThumbnailSetting->duration == 1)
                                                            <span class="position-relative text-white mr-2">
                                                                {{ (floor($video_details->duration / 3600) > 0 ? floor($video_details->duration / 3600) . 'h ' : '') . floor(($video_details->duration % 3600) / 60) . 'm' }}
                                                            </span>
                                                        @endif
                                                        @if($ThumbnailSetting->published_year == 1 && !($video_details->year == 0))
                                                            <span class="position-relative p-1 mr-2">
                                                                {{ __($video_details->year) }}
                                                            </span>
                                                        @endif
                                                        @if($ThumbnailSetting->featured == 1 && $video_details->featured == 1)
                                                            <span class="position-relative text-white">
                                                               {{ __('Featured') }}
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <div class="movie-time d-flex align-items-center pt-1">
                                                        @php
                                                            $CategoryThumbnail_setting = App\CategoryVideo::join('video_categories', 'video_categories.id', '=', 'categoryvideos.category_id')
                                                                ->where('categoryvideos.video_id', $video_details->id)
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

                                                <a class="epi-name mt-2 mb-0 btn" href="{{ URL::to('category') . '/videos/' . $video_details->slug }}">
                                                    <img class="d-inline-block ply" alt="ply" src="{{ URL::to('/assets/img/default_play_buttons.svg') }}" width="10%" height="10%"/> {{ __('Watch Now') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach

                            @foreach ($episode_cnt as $episode_key => $episode)
                                <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                    <div class="block-images position-relative">
                                        <div class="border-bg">
                                            <div class="img-box">
                                                <a class="playTrailer" href="{{ URL::to('/play_series/' . $episode->slug) }}">
                                                    <img class="img-fluid w-100 flickity-lazyloaded" src="{{ $episode->image ? URL::to('/public/uploads/images/'.$episode->image) : $default_vertical_image_url }}" alt="{{ $episode->title }}">
                                                </a>

                                                @if($ThumbnailSetting->free_or_cost_label == 1)
                                                    @switch(true)
                                                        @case($episode->access == 'subscriber')
                                                            <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                        @break
                                                        @case($episode->access == 'registered')
                                                            <p class="p-tag">{{ __('Register Now') }}</p>
                                                        @break
                                                        @case(!empty($episode->ppv_price))
                                                            <p class="p-tag">{{ $currency->symbol . ' ' . $episode->ppv_price }}</p>
                                                        @break
                                                        @case(!empty($episode->global_ppv) && $episode->ppv_price == null)
                                                            <p class="p-tag">{{ $episode->global_ppv . ' ' . $currency->symbol }}</p>
                                                        @break
                                                        @case($episode->global_ppv == null && $episode->ppv_price == null)
                                                            <p class="p-tag">{{ __('Free') }}</p>
                                                        @break
                                                    @endswitch
                                                @endif
                                            </div>
                                        </div>
                                        <div class="block-description">
                                            <a class="playTrailer" href="{{ URL::to('/play_series/' . $episode->slug) }}">

                                                @if($ThumbnailSetting->free_or_cost_label == 1)
                                                    @switch(true)
                                                        @case($episode->access == 'subscriber')
                                                            <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                        @break
                                                        @case($episode->access == 'registered')
                                                            <p class="p-tag">{{ __('Register Now') }}</p>
                                                        @break
                                                        @case(!empty($episode->ppv_price))
                                                            <p class="p-tag">{{ $currency->symbol . ' ' . $episode->ppv_price }}</p>
                                                        @break
                                                        @case(!empty($episode->global_ppv) && $episode->ppv_price == null)
                                                            <p class="p-tag">{{ $episode->global_ppv . ' ' . $currency->symbol }}</p>
                                                        @break
                                                        @case($episode->global_ppv == null && $episode->ppv_price == null)
                                                            <p class="p-tag">{{ __('Free') }}</p>
                                                        @break
                                                    @endswitch
                                                @endif
                                            </a>

                                            <div class="hover-buttons text-white">
                                                <a href="{{ URL::to('/play_series/' . $episode->slug) }}" aria-label="movie">
                                                    @if($ThumbnailSetting->title == 1)
                                                        <p class="epi-name text-left mt-2 m-0">
                                                            {{ strlen($episode->title) > 17 ? substr($episode->title, 0, 18).'...' : $episode->title }}
                                                        </p>
                                                    @endif

                                                    @if($ThumbnailSetting->enable_description == 1)
                                                        <p class="desc-name text-left m-0 mt-1">
                                                            {{ strlen($episode->description) > 75 ? substr(html_entity_decode(strip_tags($episode->description)), 0, 75) . '...' : strip_tags($episode->description) }}
                                                        </p>
                                                    @endif

                                                    <div class="movie-time d-flex align-items-center pt-2">
                                                        @if($ThumbnailSetting->age == 1 && !($episode->age_restrict == 0))
                                                            <span class="position-relative badge p-1 mr-2">{{ $episode->age_restrict}}</span>
                                                        @endif

                                                        @if($ThumbnailSetting->duration == 1)
                                                            <span class="position-relative text-white mr-2">
                                                                {{ (floor($episode->duration / 3600) > 0 ? floor($episode->duration / 3600) . 'h ' : '') . floor(($episode->duration % 3600) / 60) . 'm' }}
                                                            </span>
                                                        @endif
                                                        @if($ThumbnailSetting->published_year == 1 && !($episode->year == 0))
                                                            <span class="position-relative badge p-1 mr-2">
                                                                {{ __($episode->year) }}
                                                            </span>
                                                        @endif
                                                        @if($ThumbnailSetting->featured == 1 && $episode->featured == 1)
                                                            <span class="position-relative text-white">
                                                            {{ __('Featured') }}
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <div class="movie-time d-flex align-items-center pt-1">
                                                        @php 
                                                            $episodeSeason = App\SeriesSeason::where('series_id', $episode->id)->count(); 
                                                            echo $episodeSeason . ' Season';
                                                        @endphp
                                                    </div>
                                                </a>

                                                <a class="epi-name mt-2 mb-0 btn" href="{{ URL::to('/play_series/' . $episode->slug) }}">
                                                    <img class="d-inline-block ply" alt="ply" src="{{ URL::to('/assets/img/default_play_buttons.svg') }}" width="10%" height="10%"/> {{ __('Watch Now') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                    </div>
                @else
                    <div class="col-md-12 text-center mt-4"
                        style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                        <p>
                        <h3 class="text-center">{{ __('No video_details Available') }}</h3>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
<?php include public_path("themes/$current_theme/views/footer.blade.php"); ?>

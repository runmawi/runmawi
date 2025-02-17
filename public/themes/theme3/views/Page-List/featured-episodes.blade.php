
@php
    include public_path("themes/{$current_theme}/views/header.php");
@endphp

<section id="iq-favorites" class="pagelist">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header d-flex align-items-center justify-content-between">
                    <h2 class="main-title fira-sans-condensed-regular">
                            {{ 'Featured Episodes' }}
                    </h2>  
                </div>

                @if (($featured_episodes_pagelist)->isNotEmpty())

                    <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">
                            @forelse($featured_episodes_pagelist as $key => $featured_episodes)
                                <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                    <div class="block-images position-relative">
                                        <div class="border-bg">
                                            <div class="img-box">
                                                <a class="playTrailer" href="{{ URL::to('episode/'. $featured_episodes->series_title->slug.'/'.$featured_episodes->slug ) }}">
                                                    <img class="img-fluid w-100" loading="lazy" src="{{ $featured_episodes->image ? URL::to('public/uploads/images/'.$featured_episodes->image) : $default_vertical_image_url }}" data-src="{{ $featured_episodes->image ? URL::to('public/uploads/images/'.$featured_episodes->image) : $default_vertical_image_url }}" alt="{{ $featured_episodes->title }}">
                                                </a>
                                            </div>
                                        </div>
                                                
                                        <div class="block-description">

                                            <div class="hover-buttons text-white">
                                                <a href="{{ URL::to('episode/'. $featured_episodes->series_title->slug.'/'.$featured_episodes->slug ) }}">
                                                    @if($ThumbnailSetting->title == 1)
                                                        <p class="epi-name text-left m-0">
                                                            {{ strlen($featured_episodes->title) > 17 ? substr($featured_episodes->title, 0, 18) . '...' : $featured_episodes->title }}
                                                        </p>
                                                    @endif

                                                    @if($ThumbnailSetting->enable_description == 1)
                                                        <p class="desc-name text-left m-0 mt-1">
                                                            {{ strlen($featured_episodes->episode_description) > 75 ? substr(html_entity_decode(strip_tags($featured_episodes->episode_description)), 0, 75) . '...' : strip_tags($featured_episodes->episode_description) }}
                                                        </p>
                                                    @endif

                                                    <div class="movie-time d-flex align-items-center pt-1">
                                                        @if($ThumbnailSetting->age == 1 && !($featured_episodes->age_restrict == 0))
                                                        <span class="position-relative badge p-1 mr-2">{{ $featured_episodes->age_restrict}}</span>
                                                        @endif

                                                        @if($ThumbnailSetting->duration == 1)
                                                        <span class="position-relative text-white mr-2">
                                                            {{ (floor($featured_episodes->duration / 3600) > 0 ? floor($featured_episodes->duration / 3600) . 'h ' : '') . floor(($featured_episodes->duration % 3600) / 60) . 'm' }}
                                                        </span>
                                                        @endif
                                                        @if($ThumbnailSetting->published_year == 1 && !($featured_episodes->year == 0))
                                                        <span class="position-relative badge p-1 mr-2">
                                                            {{ __($featured_episodes->year) }}
                                                        </span>
                                                        @endif
                                                        @if($ThumbnailSetting->featured == 1 && $featured_episodes->featured == 1)
                                                        <span class="position-relative text-white">
                                                            {{ __('Featured') }}
                                                        </span>
                                                        @endif
                                                    </div>
                                                </a>
                                            
                                                <a class="epi-name mt-2 mb-0 btn" href="{{ URL::to('episode/'. $featured_episodes->series_title->slug.'/'.$featured_episodes->slug ) }}">
                                                    <img class="d-inline-block ply" alt="ply" src="{{ url('assets/img/default_play_buttons.svg') }}" width="10%" height="10%" />{{ __('Watch Now') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <div class="col-md-12 text-center mt-4"
                                    style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                                    <p>
                                    <h3 class="text-center">{{ __('No Series Video Available') }}</h3>
                                </div>
                            @endforelse
                        </ul>

                        <div class="col-md-12 pagination justify-content-end">
                            {!! $featured_episodes_pagelist->links() !!}
                        </div>

                    </div>
                @else
                    <div class="col-md-12 text-center mt-4"
                        style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                        <p>
                        <h3 class="text-center">{{ __('No Series Video Available') }}</h3>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
<?php include public_path("themes/$current_theme/views/footer.blade.php"); ?>

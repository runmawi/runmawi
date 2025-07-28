
@php
    include public_path("themes/{$current_theme}/views/header.php");
@endphp
<section id="iq-favorites" class="pagelist">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">

                <div class="iq-main-header d-flex align-items-center justify-content-between">
                    <h2 class="main-title fira-sans-condensed-regular">
                            {{ $order_settings_list[5]->header_name ? __($order_settings_list[5]->header_name) : '' }}
                    </h2>  
                </div>

                @if (($audio_list_pagelist)->isNotEmpty())

                    <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">
                            @forelse($audio_list_pagelist as $key => $audio)
                                <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                    <div class="block-images position-relative">
                                        <!-- block-images -->
                                        <div class="border-bg">
                                           <div class="img-box">
                                                 <a class="playTrailer" href="{{ URL::to('audio/'.$audio->slug) }}">
                                                    <img class="img-fluid w-100 flickity-lazyloaded" src="{{ $audio->image ? URL::to('public/uploads/images/'.$audio->image) : $default_vertical_image_url }}" alt="{{ $audio->title }}">
                                                 </a>   
                                           </div>
                                        </div>
                                        <div class="block-description">
                                            <div class="hover-buttons text-white">
                                                <a href="{{ URL::to('audio/'.$audio->slug) }}" aria-label="movie">
                                                    @if($ThumbnailSetting->title == 1)
                                                        <p class="epi-name text-left mt-2 m-0">
                                                            {{ strlen($audio->title) > 17 ? substr($audio->title, 0, 18).'...' : $audio->title }}
                                                        </p>
                                                    @endif

                                                    @if($ThumbnailSetting->enable_description == 1)
                                                        <p class="desc-name text-left m-0 mt-1">
                                                            {{ strlen($audio->description) > 75 ? substr(html_entity_decode(strip_tags($audio->description)), 0, 75) . '...' : strip_tags($audio->description) }}
                                                        </p>
                                                    @endif

                                                    <div class="movie-time d-flex align-items-center pt-2">

                                                        @if($ThumbnailSetting->duration == 1)
                                                            <span class="position-relative text-white mr-2">
                                                                {{ (floor($audio->duration / 3600) > 0 ? floor($audio->duration / 3600) . 'h ' : '') . floor(($audio->duration % 3600) / 60) . 'm' }}
                                                            </span>
                                                        @endif
                                                        @if($ThumbnailSetting->published_year == 1 && !($audio->year == 0))
                                                            <span class="position-relative p-1 mr-2">
                                                                {{ __($audio->year) }}
                                                            </span>
                                                        @endif
                                                        @if($ThumbnailSetting->featured == 1 && $audio->featured == 1)
                                                            <span class="position-relative text-white">
                                                               {{ __('Featured') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </a>

                                                <a class="epi-name mt-2 mb-0 btn" href="{{ URL::to('audio/'.$audio->slug) }}">
                                                    <img class="d-inline-block ply" alt="ply" src="{{ URL::to('/assets/img/default_play_buttons.svg') }}" width="10%" height="10%"/> {{ __('Play Now') }}
                                                </a>
                                            </div>
                                        </div>
                                     </div>
                                </li>
                            @empty
                                <div class="col-md-12 text-center mt-4"
                                    style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                                    <p>
                                    <h3 class="text-center">{{ __('No Audio Available') }}</h3>
                                </div>
                            @endforelse
                        </ul>

                        <div class="col-md-12 pagination justify-content-end">
                            {!! $audio_list_pagelist->links() !!}
                        </div>

                    </div>
                @else
                    <div class="col-md-12 text-center mt-4"
                        style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                        <p>
                        <h3 class="text-center">{{ __('No Audio Available') }}</h3>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
<?php include public_path("themes/$current_theme/views/footer.blade.php"); ?>

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

                @if ($audio_list_pagelist->isNotEmpty())

                    {{-- @dd($audio_list_pagelist); --}}
                    <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">
                            @forelse($audio_list_pagelist as $key => $audio)
                                <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                    <div class="block-images position-relative">
                                        <!-- block-images -->
                                        <div class="border-bg">
                                            <div class="img-box">
                                                <a class="playTrailer" href="{{ URL::to('album/' . $audio->slug) }}">
                                                    <img class="img-fluid w-100 flickity-lazyloaded"
                                                        src="{{ URL::to('/') . '/public/uploads/images/' . $audio->image }}"
                                                        alt="{{ $audio->albumname }}">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="block-description">
                                            <div class="hover-buttons text-white">
                                                <a class="epi-name mt-5 mb-0"
                                                    href="{{ URL::to('album/' . $audio->slug) }}">
                                                    <i class="ri-play-fill"></i>
                                                </a>
                                                <a href="{{ URL::to('album/' . $audio->slug) }}">
                                                    <p class="epi-name text-left m-0 mt-3">{{ $audio->title }}</p>
                                                </a>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <span
                                                        class="text-white"><small>{{ get_audio_artist($audio->id) }}</small></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="p-0">
                                            <div class="movie-time my-2">

                                                <span class="text-white">
                                                    <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                    <?php echo __($audio->title); ?>
                                                </span>
                                                <span class="text-white">
                                                    <i class="fa fa-clock-o"></i>
                                                    <?php echo gmdate('H:i:s', $audio->duration); ?>
                                                </span>
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

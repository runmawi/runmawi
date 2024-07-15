
@php
    include public_path("themes/{$current_theme}/views/header.php");
@endphp

<section id="iq-favorites">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">

                @if (($latest_videos_pagelist)->isNotEmpty())

                    <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">
                            @forelse($latest_videos_pagelist as $key => $video)
                                <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                    <a href="{{ URL::to('category/videos'.$video->slug) }}">
                                        <div class="block-images position-relative">
                                            <div class="img-box">
                                                <img src="{{ $video->image_url }}" class="img-fluid w-100" alt="">
                                                @if (!empty($video->ppv_price))
                                                    <p class="p-tag1">{{ $currency->symbol . ' ' . $video->ppv_price }}</p>
                                                @elseif(!empty($video->global_ppv || (!empty($video->global_ppv) && $video->ppv_price == null)))
                                                    <p class="p-tag1">{{ $video->global_ppv . ' ' . $currency->symbol }}</p>
                                                @elseif($video->global_ppv == null && $video->ppv_price == null)
                                                    <p class="p-tag">{{ __('Free') }}</p>
                                                @endif
                                            </div>

                                            <div class="block-description">
                                                @if ($ThumbnailSetting->title == 1)
                                                    <!-- Title -->
                                                    <a href="{{ URL::to('category/videos'.$video->slug) }}">
                                                        <h6><?php echo strlen($video->title) > 17 ? substr($video->title, 0, 18) . '...' : $video->title; ?></h6>
                                                    </a>
                                                @endif

                                                <div class="movie-time d-flex align-items-center pt-1">
                                                    @if ($ThumbnailSetting->age == 1)
                                                        <!-- Age -->
                                                        <div class="badge badge-secondary p-1 mr-2">{{ $video->age_restrict . ' ' . '+' }} </div>
                                                    @endif

                                                    @if ($ThumbnailSetting->duration == 1)
                                                        <!-- Duration -->
                                                        <span class="text-white"><i class="fa fa-clock-o"></i>
                                                            <?= gmdate('H:i:s', $video->duration) ?>
                                                         </span>
                                                    @endif
                                                </div>

                                                @if ($ThumbnailSetting->published_year == 1 || $ThumbnailSetting->rating == 1)
                                                    <div class="movie-time d-flex align-items-center pt-1">
                                                        @if ($ThumbnailSetting->rating == 1)
                                                            <!--Rating  -->
                                                            <div class="badge badge-secondary p-1 mr-2">
                                                                <span class="text-white">
                                                                    <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                                    {{ $video->rating }}
                                                                </span>
                                                            </div>
                                                        @endif

                                                        @if ($ThumbnailSetting->published_year == 1)
                                                            <!-- published_year -->
                                                            <div class="badge badge-secondary p-1 mr-2">
                                                                <span class="text-white">
                                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                    {{ $video->year }}
                                                                </span>
                                                            </div>
                                                        @endif

                                                        @if ($ThumbnailSetting->featured == 1 && $video->featured == 1)
                                                            <!-- Featured -->
                                                            <div class="badge badge-secondary p-1 mr-2">
                                                                <span class="text-white">
                                                                    <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                                </span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endif

                                                <div class="hover-buttons">
                                                    <a href="{{ URL::to('category/videos'.$video->slug) }}">
                                                        <span class="text-white">
                                                            <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                            {{ __('Videos Watch Now') }} 
                                                        </span>
                                                    </a>
                                                    <div>
                                                    </div>
                                                </div>

                                                <div>
                                                    <button type="button" class="show-details-button"
                                                        data-toggle="modal" data-target="#myModal<?= $video->id ?>">
                                                        <span class="text-center thumbarrow-sec">
                                                            <!-- <img src="<?php echo URL::to('/') . '/assets/img/arrow-red.png'; ?>" class="thumbarrow thumbarrow-red" alt="right-arrow">-->
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @empty
                                <div class="col-md-12 text-center mt-4"
                                    style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                                    <p>
                                    <h3 class="text-center">{{ __('No Video Available') }}</h3>
                                </div>
                            @endforelse
                        </ul>

                        <div class="col-md-12 pagination justify-content-end">
                            {!! $latest_videos_pagelist->links() !!}
                        </div>

                    </div>
                @else
                    <div class="col-md-12 text-center mt-4"
                        style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                        <p>
                        <h3 class="text-center">{{ __('No Video Available') }}</h3>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
<?php include public_path("themes/$current_theme/views/footer.blade.php"); ?>


@php
    include public_path("themes/{$current_theme}/views/header.php");
@endphp

<section id="iq-favorites" class="pagelist">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">

                <div class="iq-main-header d-flex align-items-center justify-content-between">
                    <h2 class="main-title fira-sans-condensed-regular">
                            {{ $order_settings_list[3]->header_name ? __($order_settings_list[3]->header_name) : '' }}
                    </h2>  
                </div>

                @if (($live_list_pagelist)->isNotEmpty())

                    <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">
                            @forelse($live_list_pagelist as $key => $video)
                                <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                    <div class="block-images position-relative">
                                        <div class="border-bg">
                                            <div class="img-box">
                                                <a class="playTrailer" href="{{ URL::to('/') . '/live/' . $video->slug }}">
                                                    <img class="img-fluid w-100 flickity-lazyloaded" src="{{ $video->image ? URL::to('/public/uploads/images/' . $video->image) : $default_vertical_image_url }}" alt="{{ $video->title }}" />

                                                    <div class="p-0">
                                                        <div class="mt-2 d-flex justify-content-between p-0">
                                                            <?php if($ThumbnailSetting->title == 1): ?>
                                                                <h6><?php echo (strlen($video->title) > 17) ? substr($video->title, 0, 18).'...' : $video->title; ?></h6>
                                                            <?php endif; ?>
                        
                                                            <?php if($ThumbnailSetting->age == 1): ?>
                                                                <div class="badge badge-secondary"><?php echo $video->age_restrict.'+'; ?></div>
                                                            <?php endif; ?>
                                                        </div>
                        
                                                        <div class="movie-time my-2">
                                                            <!-- Duration -->
                                                            <?php if($ThumbnailSetting->duration == 1): ?>
                                                                <span class="text-white">
                                                                    <i class="fa fa-clock-o"></i>
                                                                    <?php echo gmdate('H:i:s', $video->duration); ?>
                                                                </span>
                                                            <?php endif; ?>
                        
                                                            <!-- Rating -->
                                                            <?php if($ThumbnailSetting->rating == 1 && $video->rating != null): ?>
                                                                <span class="text-white">
                                                                    <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                                    <?php echo __($video->rating); ?>
                                                                </span>
                                                            <?php endif; ?>
                                                                                            
                                                        </div>
                        
                                                
                                                    </div>

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
                                    </div>
                                    
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
                            {!! $live_list_pagelist->links() !!}
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

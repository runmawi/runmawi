
@php
    include public_path("themes/{$current_theme}/views/header.php");
@endphp

<section id="iq-favorites" class="pagelist">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">

                <div class="iq-main-header d-flex align-items-center justify-content-center">
                    <h4 class="main-title fira-sans-condensed-regular">
                            {{ $order_settings_list[0]->header_name ? __($order_settings_list[0]->header_name) : '' }}
                    </h4>  
                </div>

                @if (($featured_videos_pagelist)->isNotEmpty())

                    <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">
                            @forelse($featured_videos_pagelist as $key => $watchlater_video)
                                <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                    <a href="<?php echo URL::to('category') . '/videos/' . $watchlater_video->slug ?>" aria-label= "video">
                                        <div class="block-images position-relative"> 
                                            <div class="img-box">
                                                <a href="<?php echo URL::to('category') . '/videos/' . $watchlater_video->slug ?>">
                                                    <img src="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image; ?>" class="img-fluid w-100 h-50 flickity-lazyloaded" alt="<?php echo $watchlater_video->title; ?>">
                                                </a>
            
                                                <!-- PPV price -->
                                                <?php if($ThumbnailSetting->free_or_cost_label == 1): ?>
                                                    <?php if(!empty($watchlater_video->ppv_price)): ?>
                                                        <p class="p-tag1"><?php echo $currency->symbol.' '.$watchlater_video->ppv_price; ?></p>
                                                    <?php elseif(!empty($watchlater_video->global_ppv) && $watchlater_video->ppv_price == null): ?>
                                                        <p class="p-tag1"><?php echo $watchlater_video->global_ppv.' '.$currency->symbol; ?></p>
                                                    <?php elseif($watchlater_video->global_ppv == null && $watchlater_video->ppv_price == null): ?>
                                                        <p class="p-tag"><?php echo "Free"; ?></p>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                                
                                                <?php if($ThumbnailSetting->published_on == 1): ?>                                            
                                                    <p class="published_on1"><?php echo $publish_time; ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
            
                                        <div class="block-description">
                                            <div class="hover-buttons">
                                                <a class="" href="<?php echo URL::to('category') . '/videos/' . $watchlater_video->slug ?>" aria-label="Latest-Video"> 
                                                    <img class="ply" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg'; ?>" alt="play" /> 
                                                </a>
                                            </div>
                                        </div>
            
                                        <div class="p-0">
                                            <div class="mt-2 d-flex justify-content-between p-0">
                                                <?php if($ThumbnailSetting->title == 1): ?>
                                                    <h6><?php echo (strlen($watchlater_video->title) > 17) ? substr($watchlater_video->title, 0, 18).'...' : $watchlater_video->title; ?></h6>
                                                <?php endif; ?>
            
                                                <?php if($ThumbnailSetting->age == 1): ?>
                                                    <div class="badge badge-secondary"><?php echo $watchlater_video->age_restrict.'+'; ?></div>
                                                <?php endif; ?>
                                            </div>
            
                                            <div class="movie-time my-2">
                                                <!-- Duration -->
                                                <?php if($ThumbnailSetting->duration == 1): ?>
                                                    <span class="text-white">
                                                        <i class="fa fa-clock-o"></i>
                                                        <?php echo gmdate('H:i:s', $watchlater_video->duration); ?>
                                                    </span>
                                                <?php endif; ?>
            
                                                <!-- Rating -->
                                                <?php if($ThumbnailSetting->rating == 1 && $watchlater_video->rating != null): ?>
                                                    <span class="text-white">
                                                        <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                        <?php echo __($watchlater_video->rating); ?>
                                                    </span>
                                                <?php endif; ?>
            
                                                <!-- Featured -->
                                                <?php if($ThumbnailSetting->featured == 1 && $watchlater_video->featured == 1): ?>
                                                    <span class="text-white">
                                                        <i class="fa fa-flag" aria-hidden="true"></i>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
            
                                            <div class="movie-time my-2">
                                                <!-- published_year -->
                                                <?php if($ThumbnailSetting->published_year == 1 && $watchlater_video->year != null): ?>
                                                    <span class="text-white">
                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                        <?php echo __($watchlater_video->year); ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
            
                                            <div class="movie-time my-2">
                                                <!-- Category Thumbnail setting -->
                                                <?php
                                                $CategoryThumbnail_setting = App\CategoryVideo::join('video_categories','video_categories.id','=','categoryvideos.category_id')
                                                    ->where('categoryvideos.video_id',$watchlater_video->id)
                                                    ->pluck('video_categories.name');        
                                                ?>
            
                                                <?php if($ThumbnailSetting->category == 1 && count($CategoryThumbnail_setting) > 0): ?>
                                                    <span class="text-white">
                                                        <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                        <?php echo implode(', ', $CategoryThumbnail_setting->toArray()); ?>
                                                    </span>
                                                <?php endif; ?>
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
                            {!! $featured_videos_pagelist->links() !!}
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

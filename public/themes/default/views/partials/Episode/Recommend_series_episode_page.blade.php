    
    <div class="iq-main-header pl-3">
        <h4 class="main-title"> <?= __('Series') ?></h4>
    </div>

    <div class="col-sm-12 overflow-hidden">
        <div class="favorites-contens">
            <div class="recom-series home-sec list-inline row mb-0 pl-0">
                <?php  
                    $ThumbnailSetting = App\ThumbnailSetting::first();
                    foreach($series_lists as $key => $series_list):
                ?>
                <div class="items">
                    <div class="block-images position-relative">

                        <!-- block-images -->
                        <div class="border-bg">
                            <div class="img-box">
                                <a class="playTrailer"
                                href="<?= URL::to('play_series/' . $series_list->slug) ?>">
                                <img class="img-fluid w-100 flickity-lazyloaded"
                                    src="<?php echo URL::to('/') . '/public/uploads/images/' . $series_list->image; ?>" alt="episode">
                                </a>

                                <?php if($ThumbnailSetting->free_or_cost_label == 1): ?>
                                    <?php if($series_list->access == 'subscriber'): ?>
                                        <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                                    <?php elseif($series_list->access == 'registered'): ?>
                                        <p class="p-tag"><?php echo __('Register Now'); ?></p>
                                    <?php elseif(!empty($series_list->ppv_status)): ?>
                                        <p class="p-tag"><?php echo $currency->symbol . ' ' . $settings->ppv_price; ?></p>
                                    <?php elseif(!empty($series_list->ppv_status) || (!empty($series_list->ppv_status) && $series_list->ppv_status == null)): ?>
                                        <p class="p-tag"><?php echo $currency->symbol . ' ' . $settings->ppv_status; ?></p>
                                    <?php elseif($series_list->ppv_status == null && $series_list->ppv_price == null): ?>
                                        <p class="p-tag"><?php echo __('Free'); ?></p>
                                    <?php endif; ?>
                                <?php endif; ?>

                            </div>
                        </div>

                        <div class="block-description">
                        <a class="playTrailer"
                            href="<?= URL::to('play_series/' . $series_list->slug) ?>">
                            <?php if($ThumbnailSetting->free_or_cost_label == 1): ?>
                                <?php if($series_list->access == 'subscriber'): ?>
                                    <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                                <?php elseif($series_list->access == 'registered'): ?>
                                    <p class="p-tag"><?php echo __('Register Now'); ?></p>
                                <?php elseif(!empty($series_list->ppv_status)): ?>
                                    <p class="p-tag"><?php echo $currency->symbol . ' ' . $settings->ppv_price; ?></p>
                                <?php elseif(!empty($series_list->ppv_status) || (!empty($series_list->ppv_status) && $series_list->ppv_status == null)): ?>
                                    <p class="p-tag"><?php echo $currency->symbol . ' ' . $settings->ppv_status; ?></p>
                                <?php elseif($series_list->ppv_status == null && $series_list->ppv_price == null): ?>
                                    <p class="p-tag"><?php echo __('Free'); ?></p>
                                <?php endif; ?>
                            <?php endif; ?>
                        </a>

                        <div class="hover-buttons text-white">
                            <a  href="<?= URL::to('play_series/' . $series_list->slug) ?>">

                                <p class="epi-name text-left m-0 mt-2">
                                    <?php echo __($series_list->title); ?>
                                </p>
                                <?php if($ThumbnailSetting->enable_description == 1 ) : ?>
                                    <p class="desc-name text-left m-0 mt-1">
                                        <?= strlen($series_list->description) > 75 ? substr(html_entity_decode(strip_tags($series_list->description)), 0, 75) . '...' : strip_tags($series_list->description) ?>
                                    </p>
                                <?php endif; ?>
                                <div class="movie-time d-flex align-items-center my-2">

                                    <?php if($ThumbnailSetting->age == 1 && !($series_list->age_restrict == 0)): ?>
                                        <span class="position-relative badge p-1 mr-2"><?php echo $series_list->age_restrict . ' +'; ?></span>
                                    <?php endif; ?>
                                
                                    <?php if($ThumbnailSetting->published_year == 1 && !($series_list->year == 0)): ?>
                                        <span class="position-relative badge p-1 mr-2">
                                            <?php echo __($series_list->year); ?>
                                        </span>
                                    <?php endif; ?>
                                
                                    <?php if($ThumbnailSetting->featured == 1 && $series_list->featured == 1): ?>
                                        <span class="position-relative text-white">
                                            <?php echo __('Featured'); ?>
                                        </span>
                                    <?php endif; ?>
                                
                                </div>
                                

                                <div class="movie-time d-flex align-items-center my-2">
                                    <span class="position-relative badge p-1 mr-2">
                                        <?php 
                                            $SeriesSeason = App\SeriesSeason::where('series_id', $series_list->id)->count(); 
                                            echo $SeriesSeason . ' Season';
                                    ?>
                                    </span>
                                    <span class="position-relative badge p-1 mr-2">
                                        <?php 
                                            $Episode = App\Episode::where('series_id', $series_list->id)->count(); 
                                            echo $Episode . ' Episodes';
                                        ?>
                                    </span>
                            </div>
                            </a>


                            <a class="epi-name mt-3 mb-0 btn"
                            href="<?= URL::to('play_series/' . $series_list->slug) ?>">
                            <i class="fa fa-play mr-1" aria-hidden="true"></i>
                            <?= __('Watch Series') ?>
                            </a>
                        </div>
                        </div>
                    </div>
                </div>
                
                <?php endforeach; ?>
            </div>
        </div>
    </div>

<script>
    var elem = document.querySelector('.recom-series');
    var flkty = new Flickity(elem, {
        cellAlign: 'left',
        contain: true,
        groupCells: true,
        pageDots: false,
        draggable: true,
        freeScroll: true,
        imagesLoaded: true,
        lazyload:true,
    });
  </script>
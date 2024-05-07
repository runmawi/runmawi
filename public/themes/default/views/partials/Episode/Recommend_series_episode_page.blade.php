<div class="iq-main-header pl-3">
    <h4 class="main-title"> <?= __('Series') ?></h4>
</div>

<div class="col-sm-12 overflow-hidden">
    <div class="favorites-contens ml-2">
        <ul class="favorites-slider list-inline row mb-0">
            <?php  
                $ThumbnailSetting = App\ThumbnailSetting::first();
                foreach($series_lists as $key => $series_list):
            ?>
            <li class="slide-item">
                <div class="block-images position-relative">

                    <!-- block-images -->
                    <div class="border-bg">
                    <div class="img-box">
                        <a class="playTrailer"
                        href="<?= URL::to('play_series/' . $series_list->slug) ?>">
                        <img class="img-fluid w-100" loading="lazy"
                            data-src="<?php echo URL::to('/') . '/public/uploads/images/' . $series_list->image; ?>" alt="episode">
                        </a>


                        <?php if ($ThumbnailSetting->free_or_cost_label == 1) { ?>
                        <?php if (!empty($series_list->ppv_price == 1)) { ?>
                            <p class="p-tag1">
                            <?php echo $currency->symbol . ' ' . $series_list->ppv_price; ?>
                            </p>
                        <?php } elseif (!empty($series_list->ppv_status || !empty($series_list->ppv_status) && $series_list->ppv_price == 1)) { ?>
                            <p class="p-tag1">
                            <?php echo $series_list->ppv_status . ' ' . $currency->symbol; ?>
                            </p>
                        <?php } elseif ($series_list->ppv_status == null && $series_list->ppv_price == null) { ?>
                            <p class="p-tag">
                            <?php echo (__('Free')); ?>
                            </p>
                        <?php } ?>
                        <?php } ?>
                    </div>
                    </div>

                    <div class="block-description">
                    <a class="playTrailer"
                        href="<?= URL::to('play_series/' . $series_list->slug) ?>">
                        <img class="img-fluid w-100" loading="lazy"
                        data-src="<?php echo URL::to('/') . '/public/uploads/images/' . $series_list->player_image; ?>"
                        alt="episode">



                        <?php if ($ThumbnailSetting->free_or_cost_label == 1) { ?>
                        <?php if (!empty($series_list->ppv_price == 1)) { ?>
                            <p class="p-tag1">
                            <?php echo $currency->symbol . ' ' . $series_list->ppv_price; ?>
                            </p>
                        <?php } elseif (!empty($series_list->ppv_status || !empty($series_list->ppv_status) && $series_list->ppv_price == 1)) { ?>
                            <p class="p-tag1">
                            <?php echo $series_list->ppv_status . ' ' . $currency->symbol; ?>
                            </p>
                        <?php } elseif ($series_list->ppv_status == null && $series_list->ppv_price == null) { ?>
                            <p class="p-tag">
                            <?php echo (__('Free')); ?>
                            </p>
                        <?php } ?>
                        <?php } ?>
                    </a>
                    <?php if ($ThumbnailSetting->free_or_cost_label == 1) { ?>
                        <?php if (!empty($series_list->ppv_price == 1)) { ?>
                        <p class="p-tag1">
                            <?php echo $currency->symbol . ' ' . $series_list->ppv_price; ?>
                        </p>
                        <?php } elseif (!empty($series_list->ppv_status || !empty($series_list->ppv_status) && $series_list->ppv_price == 1)) { ?>
                        <p class="p-tag1">
                            <?php echo $series_list->ppv_status . ' ' . $currency->symbol; ?>
                        </p>
                        <?php } elseif ($series_list->ppv_status == null && $series_list->ppv_price == null) { ?>
                        <p class="p-tag">
                            <?php echo (__('Free')); ?>
                        </p>
                        <?php } ?>
                    <?php } ?>

                    <div class="hover-buttons text-white">
                        <a  href="<?= URL::to('play_series/' . $series_list->slug) ?>">

                            <p class="epi-name text-left m-0">
                                <?php echo __($series_list->title); ?>
                            </p>

                            <div class="movie-time align-items-center my-2">
                                <div class="badge badge-secondary p-1 mr-2">
                                    <?php
                                        $SeriesSeason = App\SeriesSeason::where('series_id', $series_list->id)->count();
                                        echo $SeriesSeason . ' ' . 'Season';
                                    ?>
                                </div>
                                <div class="badge badge-secondary p-1 mr-2">
                                    <?php
                                        $Episode = App\Episode::where('series_id', $series_list->id)->count();
                                        echo $Episode . ' ' . 'Episodes';
                                    ?>
                                </div>
                            </div>
                        </a>


                        <a class="epi-name mt-3 mb-0 btn"
                        href="<?= URL::to('play_series/' . $series_list->slug) ?>">
                        <i class="fa fa-play mr-1" aria-hidden="true"></i>
                        Watch Series
                        </a>
                    </div>
                    </div>
                </div>
            </li>
            
            <?php endforeach; ?>
        </ul>
    </div>
</div>

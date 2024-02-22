<div class="iq-main-header d-flex align-items-center justify-content-between">
    <h4 class="main-title"><a href="">
            <?php echo (__('Preference By Genres')); ?>
        </a></h4>
    <h4 class="main-title"><a href="">
            <?php echo (__('View All')); ?>
        </a></h4>
</div>
<div class="favorites-contens">
    <ul class="favorites-slider list-inline  row p-0 mb-0">
        <?php if (isset($preference_genres)):
            foreach ($preference_genres as $preference_genre):
                ?>

                <li class="slide-item">
                    <div class="block-images position-relative">
                        <!-- block-images -->
                        <div class="border-bg">
                            <div class="img-box">
                                <a class="playTrailer"
                                    href="<?php echo URL::to('category') ?><?= '/videos/' . $preference_genre->slug ?>">
                                    <img loading="lazy"
                                        data-src="<?php echo URL::to('/') . '/public/uploads/images/' . $preference_genre->image; ?>"
                                        class="img-fluid loading w-100" alt="p-img">

                                </a>

                                <!-- PPV price -->
                                <?php if ($ThumbnailSetting->free_or_cost_label == 1) { ?>
                                    <?php if ($preference_genre->access == 'subscriber') { ?>
                                        <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                                    <?php } elseif (!empty($preference_genre->ppv_price)) { ?>
                                        <p class="p-tag1">
                                            <?php echo $currency->symbol . ' ' . $preference_genre->ppv_price; ?>
                                        </p>
                                    <?php } elseif ($preference_genre->access == 'registered') { ?>
                                        <p class="p-tag">
                                            <?php echo (__('Register Now')); ?>
                                        </p>
                                    <?php } elseif (!empty($preference_genre->global_ppv || !empty($preference_genre->global_ppv) && $preference_genre->ppv_price == null)) { ?>
                                        <p class="p-tag1">
                                            <?php echo $preference_genre->global_ppv . ' ' . $currency->symbol; ?>
                                        </p>
                                    <?php } elseif ($preference_genre->global_ppv == null && $preference_genre->ppv_price == null) { ?>
                                        <p class="p-tag">
                                            <?php echo (__('Free')); ?>
                                        </p>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>

                        
                    </div>
                </li>
            <?php endforeach; endif; ?>
    </ul>
</div>
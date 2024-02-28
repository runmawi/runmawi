<div class="iq-main-header d-flex align-items-center justify-content-between">
    <h4 class="main-title"><a href="">
            <?php echo (__('Most Watched Videos - User')); ?>
        </a></h4>
    <h4 class="main-title"><a href="">
            <?php echo (__('View All')); ?>
        </a></h4>
</div>
<div class="favorites-contens">
    <ul class="favorites-slider list-inline  row p-0 mb-0">
        <?php  if(isset($most_watch_user)) :
                    foreach($most_watch_user as $watchlater_video): 
                ?>

        <li class="slide-item">
            <div class="block-images position-relative">
                <!-- block-images -->
                <div class="border-bg">
                    <div class="img-box">
                        <a class="playTrailer"
                            href="<?php echo URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>">
                            <img loading="lazy"
                                data-src="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>"
                                class="img-fluid loading w-100" alt="m-img">

                        </a>

                        <!-- PPV price -->

                        <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>
                        <?php   if($watchlater_video->access == 'subscriber' ){ ?>
                        <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                        <?php }elseif($watchlater_video->access == 'registered'){?>
                        <p class="p-tag">
                            <?php echo (__('Register Now')); ?>
                        </p>
                        <?php } elseif(!empty($watchlater_video->ppv_price)){?>
                        <p class="p-tag1">
                            <?php echo $currency->symbol.' '.$watchlater_video->ppv_price; ?>
                        </p>
                        <?php }elseif( !empty($watchlater_video->global_ppv || !empty($watchlater_video->global_ppv) && $watchlater_video->ppv_price == null)){ ?>
                        <p class="p-tag1">
                            <?php echo $watchlater_video->global_ppv.' '.$currency->symbol; ?>
                        </p>
                        <?php }elseif($watchlater_video->global_ppv == null && $watchlater_video->ppv_price == null ){ ?>
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
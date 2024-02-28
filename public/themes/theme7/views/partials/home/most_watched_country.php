<div class="iq-main-header d-flex align-items-center justify-content-between">
        <h4 class="main-title"><a href=""><?php echo (__('Most Watched Videos in')); ?> <?php echo $countryName;?></a></h4>    
        <h4 class="main-title"><a href=""><?php echo (__('View All')); ?></a></h4>                  
</div>
    <div class="favorites-contens">
        <ul class="favorites-slider list-inline  row p-0 mb-0">
                <?php  if(isset($Most_watched_country)) :
                    foreach($Most_watched_country as $Most_watched_countries): 
                ?>

                <li class="slide-item">
                    <div class="block-images position-relative">
                        <!-- block-images -->
                        <div class="border-bg">
                            <div class="img-box">
                                    <a class="playTrailer" href="<?php echo URL::to('category') ?><?= '/videos/' . $Most_watched_countries->slug ?>">
                                       <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$Most_watched_countries->image;  ?>" class="img-fluid loading w-100" alt="m-img"> 
                                      
                                    </a>

                                <!-- PPV price -->
                                    
                                    <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>  
                                       
                                            <?php  if($Most_watched_countries->access == 'subscriber' ){ ?>
                                                <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                                            <?php }elseif($Most_watched_countries->access == 'registered'){?>
                                            <p class="p-tag"><?php echo (__('Register Now')); ?></p>
                                            <?php } elseif(!empty($Most_watched_countries->ppv_price)){?>
                                                <p class="p-tag1"><?php echo $currency->symbol.' '.$Most_watched_countries->ppv_price; ?></p>
                                            <?php }elseif( !empty($Most_watched_countries->global_ppv || !empty($Most_watched_countries->global_ppv) && $Most_watched_countries->ppv_price == null)){ ?>
                                                <p class="p-tag1"><?php echo $Most_watched_countries->global_ppv.' '.$currency->symbol; ?></p>
                                            <?php }elseif($Most_watched_countries->global_ppv == null && $Most_watched_countries->ppv_price == null ){ ?>
                                                <p class="p-tag"><?php echo (__('Free')); ?></p>
                                            <?php } ?>
                                       
                                    <?php } ?>
                                   
                                </div>
                                </div>

                                
                                    <div>
                </li>
                         <?php endforeach; endif; ?>
        </ul>
    </div>
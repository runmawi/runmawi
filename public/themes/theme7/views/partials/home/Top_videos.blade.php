<div class="iq-main-header d-flex align-items-center justify-content-between">
    <h4 class="main-title"><a href=""><?php echo (__('Top Most Watched Videos')); ?> </a></h4>                      
</div>
<div class="favorites-contens">
    <ul class="favorites-slider list-inline  row p-0 mb-0">
            <?php  if(isset($top_most_watched)) :
                foreach($top_most_watched as $most_watched_video): 
            ?>

            <li class="slide-item">
                <div class="block-images position-relative">
                    <!-- block-images -->
                    <div class="border-bg">
                    <div class="img-box">
                
                                <a class="playTrailer" href="<?php echo URL::to('category') ?><?= '/videos/' . $most_watched_video->slug ?>">
                                     <img alt="Top-img" loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$most_watched_video->image;  ?>" class="img-fluid loading w-100" alt=""> 
                                  
                                </a>

                                <!-- PPV price -->
                               
                                    <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>  
                                        <?php  if($most_watched_video->access == 'subscriber' ){ ?>
                                            <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                                            <?php }elseif($most_watched_video->access == 'registered'){?>
                                            <p class="p-tag"><?php echo (__('Register Now')); ?></p>
                                            <?php } elseif(!empty($most_watched_video->ppv_price)){?>
                                            <p class="p-tag1"><?php echo $currency->symbol.' '.$most_watched_video->ppv_price; ?></p>
                                        <?php }elseif( !empty($most_watched_video->global_ppv || !empty($most_watched_video->global_ppv) && $most_watched_video->ppv_price == null)){ ?>
                                            <p class="p-tag1"><?php echo $most_watched_video->global_ppv.' '.$currency->symbol; ?></p>
                                        <?php }elseif($most_watched_video->global_ppv == null && $most_watched_video->ppv_price == null ){ ?>
                                            <p class="p-tag"><?php echo (__('Free')); ?></p>
                                        <?php } ?>
                                    <?php } ?>
                                   
                            </div>
                            </div>

                            <div class="block-description">
                            <a class="playTrailer" href="<?php echo URL::to('category') ?><?= '/videos/' . $most_watched_video->slug ?>">
                                     <img alt="Top-img" loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$most_watched_video->player_image;  ?>" class="img-fluid loading w-100" alt=""> 
                                  
                                

                                <!-- PPV price -->
                               
                                    <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>  
                                        <?php  if($most_watched_video->access == 'subscriber' ){ ?>
                                            <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                                            <?php }elseif($most_watched_video->access == 'registered'){?>
                                            <p class="p-tag"><?php echo (__('Register Now')); ?></p>
                                            <?php } elseif(!empty($most_watched_video->ppv_price)){?>
                                            <p class="p-tag1"><?php echo $currency->symbol.' '.$most_watched_video->ppv_price; ?></p>
                                        <?php }elseif( !empty($most_watched_video->global_ppv || !empty($most_watched_video->global_ppv) && $most_watched_video->ppv_price == null)){ ?>
                                            <p class="p-tag1"><?php echo $most_watched_video->global_ppv.' '.$currency->symbol; ?></p>
                                        <?php }elseif($most_watched_video->global_ppv == null && $most_watched_video->ppv_price == null ){ ?>
                                            <p class="p-tag"><?php echo (__('Free')); ?></p>
                                        <?php } ?>
                                    <?php } ?>
                                    </a>
                                    <!-- PPV price -->
                               
                                    <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>  
                                        <?php  if($most_watched_video->access == 'subscriber' ){ ?>
                                            <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                                            <?php }elseif($most_watched_video->access == 'registered'){?>
                                            <p class="p-tag"><?php echo (__('Register Now')); ?></p>
                                            <?php } elseif(!empty($most_watched_video->ppv_price)){?>
                                            <p class="p-tag1"><?php echo $currency->symbol.' '.$most_watched_video->ppv_price; ?></p>
                                        <?php }elseif( !empty($most_watched_video->global_ppv || !empty($most_watched_video->global_ppv) && $most_watched_video->ppv_price == null)){ ?>
                                            <p class="p-tag1"><?php echo $most_watched_video->global_ppv.' '.$currency->symbol; ?></p>
                                        <?php }elseif($most_watched_video->global_ppv == null && $most_watched_video->ppv_price == null ){ ?>
                                            <p class="p-tag"><?php echo (__('Free')); ?></p>
                                        <?php } ?>
                                    <?php } ?>

                                

                                    <div class="hover-buttons text-white">
                                <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $most_watched_video->slug ?>">
                                <?php if($ThumbnailSetting->title == 1) { ?>  
                                              <!-- Title -->
                                        <p class="epi-name text-left m-0"><?php  echo (strlen($most_watched_video->title) > 17) ? substr($most_watched_video->title,0,18).'...' : $most_watched_video->title; ?></p>
                                    
                                 <?php } ?>  

                                 <div class="movie-time d-flex align-items-center pt-1">
                                    <?php if($ThumbnailSetting->age == 1) { ?>
                                    <!-- Age -->
                                    <div class="badge badge-secondary p-1 mr-2"><?php echo $most_watched_video->age_restrict.' '.'+' ?></div>
                                    <?php } ?>

                                    <?php if($ThumbnailSetting->duration == 1) { ?>
                                    <!-- Duration -->
                                    <span class="text-white">
                                        <i class="fa fa-clock-o"></i>
                                        <?= gmdate('H:i:s', $most_watched_video->duration); ?>
                                    </span>
                                    <?php } ?>
                                </div>

                               
                                <?php if(($ThumbnailSetting->published_year == 1) || ($ThumbnailSetting->rating == 1)) {?>
                                    <div class="movie-time d-flex align-items-center pt-2">
                                        <?php if($ThumbnailSetting->rating == 1) { ?>
                                        <!--Rating  -->
                                        <div class="badge badge-secondary p-1 mr-2">
                                            <span class="text-white">
                                                <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                <?php echo __($most_watched_video->rating); ?>
                                            </span>
                                        </div>
                                        <?php } ?>

                                        <?php if($ThumbnailSetting->published_year == 1) { ?>
                                        <!-- published_year -->
                                        <div class="badge badge-secondary p-1 mr-2">
                                          <span class="text-white">
                                              <i class="fa fa-calendar" aria-hidden="true"></i>
                                              <?php echo __($most_watched_video->year); ?>
                                          </span>
                                        </div>
                                        <?php } ?>

                                        <?php if($ThumbnailSetting->featured == 1 && $most_watched_video->featured == 1) { ?>
                                        <!-- Featured -->
                                        <div class="badge badge-secondary p-1 mr-2">
                                          <span class="text-white">
                                           <i class="fa fa-flag-o" aria-hidden="true"></i>
                                          </span>
                                        </div>
                                        <?php }?>
                                    </div>
                                <?php } ?>
                                
                                <div class="movie-time d-flex align-items-center pt-1">
                                    <!-- Category Thumbnail  setting -->
                                   <?php
                                   $CategoryThumbnail_setting =  App\CategoryVideo::join('video_categories','video_categories.id','=','categoryvideos.category_id')
                                               ->where('categoryvideos.video_id',$most_watched_video->id)
                                               ->pluck('video_categories.name');        
                                   ?>
                                   <?php  if ( ($ThumbnailSetting->category == 1 ) &&  ( count($CategoryThumbnail_setting) > 0 ) ) { ?>
                                   <span class="text-white">
                                       <i class="fa fa-list-alt" aria-hidden="true"></i>
                                       <?php
                                           $Category_Thumbnail = array();
                                               foreach($CategoryThumbnail_setting as $key => $CategoryThumbnail){
                                               $Category_Thumbnail[] = $CategoryThumbnail ; 
                                               }
                                           echo implode(','.' ', $Category_Thumbnail);
                                       ?>
                                   </span>
                                   <?php } ?>
                               </div>
                                </a>

                                <a class="epi-name mt-3 mb-0 btn" href="<?php echo URL::to('category') ?><?= '/videos/' . $most_watched_video->slug ?>" >
                                    <img class="d-inline-block ply" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>"  width="10%" height="10%"/> Watch Now
                                </a>
                            </div>
                        </div>
                    </div>
            </li>
                     <?php endforeach; endif; ?>
    </ul>
</div>
<div class="iq-main-header d-flex align-items-center justify-content-between">
    <h4 class="main-title"><a href=""> Top Most Watching Videos</a></h4>
</div>
<div class="favorites-contens">
    <ul class="favorites-slider list-inline row p-0 mb-0">
        <?php  if(isset($top_most_watched)) :
                foreach($top_most_watched as $most_watched_video): 
            ?>

        <li class="slide-item">
            <a href="<?php echo URL::to('home') ?>">
                <div class="block-images position-relative">
                    <div class="img-box">
                        <a href="<?php echo URL::to('category') ?><?= '/videos/' . $most_watched_video->slug ?>">
                            <!-- <img src="<?php echo URL::to('/').'/public/uploads/images/'.$most_watched_video->image;  ?>" class="img-fluid" alt=""> -->
                            <video width="100%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$most_watched_video->image;  ?>" data-play="hover">
                                <source src="<?php echo $most_watched_video->trailer;  ?>" type="video/mp4" />
                            </video>
                        </a>

                        <!-- PPV price -->
                        <div class="corner-text-wrapper">
                            <div class="corner-text">
                                <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>
                                <?php  if(!empty($most_watched_video->ppv_price)){?>
                                <p class="p-tag1"><?php echo $currency->symbol.' '.$most_watched_video->ppv_price; ?></p>
                                <?php }elseif( !empty($most_watched_video->global_ppv || !empty($most_watched_video->global_ppv) && $most_watched_video->ppv_price == null)){ ?>
                                <p class="p-tag1"><?php echo $most_watched_video->global_ppv.' '.$currency->symbol; ?></p>
                                <?php }elseif($most_watched_video->global_ppv == null && $most_watched_video->ppv_price == null ){ ?>
                                <p class="p-tag"><?php echo "Free"; ?></p>
                                <?php } ?>
                                <?php } ?>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="block-description">
                    <div class="hover-buttons">
                        <a class="" href="<?php echo URL::to('category') ?><?= '/videos/' . $most_watched_video->slug ?>">
                            <img class="ply" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>" />
                        </a>
                    </div>
                </div>

                <div class="mt-2 d-flex justify-content-between p-0">
                    <?php if($ThumbnailSetting->title == 1) { ?>
                    <h6><?php  echo (strlen($most_watched_video->title) > 17) ? substr($most_watched_video->title,0,18).'...' : $most_watched_video->title; ?></h6>
                    <?php } ?>

                    <?php if($ThumbnailSetting->age == 1) { ?>
                    <div class="badge badge-secondary"><?php echo $most_watched_video->age_restrict.' '.'+' ?></div>
                    <?php } ?>
                </div>
                <div class="movie-time my-2">
                  
                    <!-- Duration -->

                    <?php if($ThumbnailSetting->duration == 1) { ?>
                    <span class="text-white">
                        <i class="fa fa-clock-o"></i>
                        <?= gmdate('H:i:s', $most_watched_video->duration); ?>
                    </span>
                    <?php } ?>

                    <!-- Rating -->

                    <?php if($ThumbnailSetting->rating == 1 && $most_watched_video->rating != null) { ?>
                    <span class="text-white">
                        <i class="fa fa-star-half-o" aria-hidden="true"></i>
                        <?php echo __($most_watched_video->rating); ?>
                    </span>
                    <?php } ?>

                    <?php if($ThumbnailSetting->featured == 1 && $most_watched_video->featured == 1) { ?>
                        <!-- Featured -->
                        <span class="text-white">
                            <i class="fa fa-flag" aria-hidden="true"></i>
                        </span>
                    <?php }?>
                </div>

                <div class="movie-time my-2">
                    <!-- published_year -->

                    <?php  if ( ($ThumbnailSetting->published_year == 1) && ( $most_watched_video->year != null ) ) { ?>
                    <span class="text-white">
                        <i class="fa fa-calendar" aria-hidden="true"></i>
                        <?php echo __($most_watched_video->year); ?>
                    </span>
                    <?php } ?>
                </div>

                <div class="movie-time my-2">
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
        </li>
        <?php endforeach; endif; ?>
    </ul>
</div>
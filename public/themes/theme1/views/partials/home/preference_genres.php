<div class="iq-main-header d-flex align-items-center justify-content-between">
    <h4 class="main-title"><a href=""><?= (__('Preference By Genres'))  ?> </a></h4>
</div>
<div class="favorites-contens">
    <ul class="favorites-slider list-inline row p-0 mb-0">
        <?php  if(isset($preference_genres)) :
                    foreach($preference_genres as $preference_genre): 
                ?>

        <li class="slide-item">
            <a href="<?php echo URL::to('home') ?>">
                <div class="block-images position-relative">
                    <div class="img-box">
                        <a href="<?php echo URL::to('category') ?><?= '/videos/' . $preference_genre->slug ?>">
                            <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$preference_genre->image;  ?>" class="img-fluid w-100" alt=""> 
                            <!--<video width="100%" height="auto" class="play-video lazy" poster="<?php echo URL::to('/').'/public/uploads/images/'.$preference_genre->image;  ?>" data-play="hover">
                                <source src="<?php echo $preference_genre->trailer;  ?>" type="video/mp4" />
                            </video>-->
                        </a>
                    </div>
                    <div class="block-description">
                        <div class="hover-buttons">
                            <a class="text-white btn-cl" href="<?php echo URL::to('category') ?><?= '/videos/' . $preference_genre->slug ?>"> <img class="ply" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>" /> </a>
                        </div>
                    </div>

                        <!-- PPV price -->
                        
                                    <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>
                                    <?php  if($preference_genre->access == 'subscriber' ){ ?>
                                  <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                                  <?php }elseif(!empty($preference_genre->ppv_price)){?>
                                    <p class="p-tag1"><?php echo $currency->symbol.' '.$preference_genre->ppv_price; ?></p>
                                    <?php }elseif( !empty($preference_genre->global_ppv || !empty($preference_genre->global_ppv) && $preference_genre->ppv_price == null)){ ?>
                                    <p class="p-tag1"><?php echo $preference_genre->global_ppv.' '.$currency->symbol; ?></p>
                                    <?php }elseif($preference_genre->global_ppv == null && $preference_genre->ppv_price == null ){ ?>
                                    <p class="p-tag"><?php echo __("Free"); ?></p>
                                    <?php } ?>
                                    <?php } ?>
                              

                   
                </div>
                
                <div class="mt-2 d-flex justify-content-between p-0">
                    <?php if($ThumbnailSetting->title == 1) { ?>
                    <h6><?php  echo (strlen($preference_genre->title) > 17) ? substr($preference_genre->title,0,18).'...' : $preference_genre->title; ?></h6>
                    <?php } ?>

                    <?php if($ThumbnailSetting->age == 1) { ?>
                    <div class="badge badge-secondary"><?php echo $preference_genre->age_restrict.' '.'+' ?></div>
                    <?php } ?>
                </div>
                <div class="movie-time my-2">
                    <!-- Duration -->

                    <?php if($ThumbnailSetting->duration == 1) { ?>
                    <span class="text-white">
                        <i class="fa fa-clock-o"></i>
                        <?= gmdate('H:i:s', $preference_genre->duration); ?>
                    </span>
                    <?php } ?>

                    <!-- Rating -->

                    <?php if($ThumbnailSetting->rating == 1 && $preference_genre->rating != null) { ?>
                    <span class="text-white">
                        <i class="fa fa-star-half-o" aria-hidden="true"></i>
                        <?php echo __($preference_genre->rating); ?>
                    </span>
                    <?php } ?>

                    <?php if($ThumbnailSetting->featured == 1 && $preference_genre->featured == 1) { ?>
                    <!-- Featured -->
                    <span class="text-white">
                        <i class="fa fa-flag" aria-hidden="true"></i>
                    </span>
                    <?php }?>
                </div>

                <div class="movie-time my-2">
                    <!-- published_year -->

                    <?php  if ( ($ThumbnailSetting->published_year == 1) && ( $preference_genre->year != null ) ) { ?>
                    <span class="text-white">
                        <i class="fa fa-calendar" aria-hidden="true"></i>
                        <?php echo __($preference_genre->year); ?>
                    </span>
                    <?php } ?>
                </div>

                <div class="movie-time my-2">
                    <!-- Category Thumbnail  setting -->
                    <?php
                    $CategoryThumbnail_setting =  App\CategoryVideo::join('video_categories','video_categories.id','=','categoryvideos.category_id')
                                ->where('categoryvideos.video_id',$preference_genre->id)
                                ->pluck('video_categories.name');        
                    ?>
                    <?php  if ( ($ThumbnailSetting->category == 1 ) &&  ( count($CategoryThumbnail_setting) > 0 ) ) { ?>
                    <span class="text-white">
                        <i class="fa fa-list-alt" aria-hidden="true"></i>
                        <?php
                            $Category_Thumbnail = array();
                                foreach($CategoryThumbnail_setting as $key => $CategoryThumbnail){
                                $Category_Thumbnail[] = $CategoryThumbnail ; 
                                echo (__($CategoryThumbnail).' ');
                                }
                            // echo implode(','.' ', $Category_Thumbnail);
                        ?>
                    </span>
                    <?php } ?>
                </div>

            </a>
        </li>
        <?php endforeach; endif; ?>
    </ul>
</div>

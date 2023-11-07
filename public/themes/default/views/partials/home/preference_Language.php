<div class="iq-main-header d-flex align-items-center justify-content-between">
        <h4 class="main-title"><a href=""><?php echo (__('Preference By language')); ?> </a></h4>                      
</div>
    <div class="favorites-contens">
        <ul class="favorites-slider list-inline  row p-0 mb-0">
                <?php  if(isset($preference_Language)) :
                    foreach($preference_Language as $preference_Languages): 
                ?>

                <li class="slide-item">
                    <div class="block-images position-relative">
                        <!-- block-images -->
                            <div class="border-bg">
                                <div class="img-box">
                                    <a class="playTrailer" href="<?php echo URL::to('category') ?><?= '/videos/' . $preference_Languages->slug ?>">
                                        <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$preference_Languages->image;  ?>" class="img-fluid loading w-100" alt="p-img"> 
                                        
                                    </a>

                                <!-- PPV price -->   
                                    <div class="corner-text-wrapper">
                                    <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?> 
                                        <div class="corner-text">
                                            <?php  if($preference_Languages->access == 'subscriber' ){ ?>
                                                <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                                            <?php }elseif($preference_Languages->access == 'registered'){?>
                                                <p class="p-tag"><?php echo "Register Now"; ?></p>
                                                <?php } elseif(!empty($preference_Languages->ppv_price)){?>
                                                <p class="p-tag1"><?php echo $currency->symbol.' '.$preference_Languages->ppv_price; ?></p>
                                            <?php }elseif( !empty($preference_Languages->global_ppv || !empty($preference_Languages->global_ppv) && $preference_Languages->ppv_price == null)){ ?>
                                                <p class="p-tag1"><?php echo $preference_Languages->global_ppv.' '.$currency->symbol; ?></p>
                                            <?php }elseif($preference_Languages->global_ppv == null && $preference_Languages->ppv_price == null ){ ?>
                                                <p class="p-tag"><?php echo "Free"; ?></p>
                                            <?php } ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                </div>

                                <div class="block-description">
                                <a class="playTrailer" href="<?php echo URL::to('category') ?><?= '/videos/' . $preference_Languages->slug ?>">
                                        <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$preference_Languages->player_image;  ?>" class="img-fluid loading w-100" alt="p-img"> 
                                        
                                    

                                <!-- PPV price -->   
                                    <div class="corner-text-wrapper">
                                    <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?> 
                                        <div class="corner-text">
                                            <?php  if($preference_Languages->access == 'subscriber' ){ ?>
                                                <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                                            <?php }elseif($preference_Languages->access == 'registered'){?>
                                                <p class="p-tag"><?php echo "Register Now"; ?></p>
                                                <?php } elseif(!empty($preference_Languages->ppv_price)){?>
                                                <p class="p-tag1"><?php echo $currency->symbol.' '.$preference_Languages->ppv_price; ?></p>
                                            <?php }elseif( !empty($preference_Languages->global_ppv || !empty($preference_Languages->global_ppv) && $preference_Languages->ppv_price == null)){ ?>
                                                <p class="p-tag1"><?php echo $preference_Languages->global_ppv.' '.$currency->symbol; ?></p>
                                            <?php }elseif($preference_Languages->global_ppv == null && $preference_Languages->ppv_price == null ){ ?>
                                                <p class="p-tag"><?php echo "Free"; ?></p>
                                            <?php } ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    </a>
                                     <!-- PPV price -->   
                                     <div class="corner-text-wrapper">
                                    <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?> 
                                        <div class="corner-text">
                                            <?php  if($preference_Languages->access == 'subscriber' ){ ?>
                                                <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                                            <?php }elseif($preference_Languages->access == 'registered'){?>
                                                <p class="p-tag"><?php echo "Register Now"; ?></p>
                                                <?php } elseif(!empty($preference_Languages->ppv_price)){?>
                                                <p class="p-tag1"><?php echo $currency->symbol.' '.$preference_Languages->ppv_price; ?></p>
                                            <?php }elseif( !empty($preference_Languages->global_ppv || !empty($preference_Languages->global_ppv) && $preference_Languages->ppv_price == null)){ ?>
                                                <p class="p-tag1"><?php echo $preference_Languages->global_ppv.' '.$currency->symbol; ?></p>
                                            <?php }elseif($preference_Languages->global_ppv == null && $preference_Languages->ppv_price == null ){ ?>
                                                <p class="p-tag"><?php echo "Free"; ?></p>
                                            <?php } ?>
                                        </div>
                                        <?php } ?>
                                    </div>



                            <div class="hover-buttons text-white">
                                <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $preference_Languages->slug ?>">
                                <?php if($ThumbnailSetting->title == 1) { ?> 
                                               <!-- Title -->
                                               <p class="epi-name text-left m-0">
                                                <?php  echo (strlen($preference_Languages->title) > 17) ? substr($preference_Languages->title,0,18).'...' : $preference_Languages->title; ?></p>
                                    
                                <?php } ?>   

                                <div class="movie-time d-flex align-items-center pt-1">
                                      <?php if($ThumbnailSetting->age == 1) { ?>
                                      <!-- Age -->
                                      <div class="badge badge-secondary p-1 mr-2"><?php echo $preference_Languages->age_restrict.' '.'+' ?></div>
                                      <?php } ?>

                                      <?php if($ThumbnailSetting->duration == 1) { ?>
                                      <!-- Duration -->
                                      <span class="text-white">
                                          <i class="fa fa-clock-o"></i>
                                          <?= gmdate('H:i:s', $preference_Languages->duration); ?>
                                      </span>
                                      <?php } ?>
                                </div>

                                <?php if(($ThumbnailSetting->published_year == 1) || ($ThumbnailSetting->rating == 1)) {?>
                                    <div class="movie-time d-flex align-items-center pt-1">
                                        <?php if($ThumbnailSetting->rating == 1) { ?>
                                        <!--Rating  -->
                                        <div class="badge badge-secondary p-1 mr-2">
                                            <span class="text-white">
                                                <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                <?php echo __($preference_Languages->rating); ?>
                                            </span>
                                        </div>
                                        <?php } ?>

                                        <?php if($ThumbnailSetting->published_year == 1) { ?>
                                        <!-- published_year -->
                                        <div class="badge badge-secondary p-1 mr-2">
                                          <span class="text-white">
                                              <i class="fa fa-calendar" aria-hidden="true"></i>
                                              <?php echo __($preference_Languages->year); ?>
                                          </span>
                                        </div>
                                        <?php } ?>

                                        <?php if($ThumbnailSetting->featured == 1 && $preference_Languages->featured == 1) { ?>
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
                                                  ->where('categoryvideos.video_id',$preference_Languages->pre_video_id)
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
                                    
                                    
                                   
                                       <a class="epi-name mt-3 mb-0 btn" href="<?php echo URL::to('category') ?><?= '/videos/' . $preference_Languages->slug ?>" >
                                         <img class="d-inline-block ply" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>"  width="10%" height="10%"/> Watch Now
                                      </a>
                                </div>
                            </div>
                        </div>
                </li>
                         <?php endforeach; endif; ?>
        </ul>
    </div>
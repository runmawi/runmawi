<div class="iq-main-header d-flex align-items-center justify-content-between">
        <h4 class="main-title"><a href="">Preference By language </a></h4>                      
</div>
    <div class="favorites-contens">
        <ul class="favorites-slider list-inline  row p-0 mb-0">
                <?php  if(isset($preference_Language)) :
                    foreach($preference_Language as $preference_Languages): 
                ?>

                <li class="slide-item">
                    <a href="<?php echo URL::to('home') ?>">
                        <div class="block-images position-relative">
                                <div class="img-box">
                                    <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $preference_Languages->slug ?>">
                                        <!-- <img src="<?php echo URL::to('/').'/public/uploads/images/'.$preference_Languages->image;  ?>" class="img-fluid" alt=""> -->
                                        <video width="100%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$preference_Languages->image;  ?>"  data-play="hover" >
                                            <source src="<?php echo $preference_Languages->trailer;  ?>" type="video/mp4">
                                        </video>
                                    </a>

                                <!-- PPV price -->   
                                    <div class="corner-text-wrapper">
                                    <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?> 
                                        <div class="corner-text">
                                            <?php  if(!empty($preference_Languages->ppv_price)){?>
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

                                <div class="block-description">


                                <?php if($ThumbnailSetting->title == 1) { ?>            <!-- Title -->
                                    <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $preference_Languages->slug ?>">
                                         <h6><?php echo __($preference_Languages->title); ?></h6>
                                    </a>
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
                                    
                                    
                                   <div class="hover-buttons">
                                       <a class="text-white d-flex" href="<?php echo URL::to('category') ?><?= '/videos/' . $preference_Languages->slug ?>" >
                                         <img class="ply" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>"  width="10%" height="10%"/> Watch Now
                                      </a>
                                    <!-- <div>
                                       <a href="<?php echo URL::to('category') ?><?= '/wishlist/' . $preference_Languages->slug ?>" class="text-white mt-4"><i class="fa fa-plus" aria-hidden="true"></i> Add to Watchlist</a>
                                </div> -->
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
                         <?php endforeach; endif; ?>
        </ul>
    </div>
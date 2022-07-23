<?php 
    include(public_path('themes/default/views/header.php'));
?>

 <!-- MainContent -->
<section id="iq-favorites">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-sm-12 page-height">
                     <div class="iq-main-header align-items-center justify-content-between">
                        <h3 class="vid-title">Latest Videos</h3>                     
                     </div>
                     <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">
                            <?php if(isset($latestvideo['latest_videos'])) :
                           foreach($latestvideo['latest_videos'] as $latest_video): ?>
                           <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                              <a href="<?php echo URL::to('home') ?>">
                                 <div class="block-images position-relative">
                                    <div class="img-box">
                                       <img src="<?php echo URL::to('/').'/public/uploads/images/'.$latest_video->image;  ?>" class="img-fluid" alt="">
                                   
                                   
                                          <?php  if(!empty($latest_video->ppv_price)){?>
                                          <p class="p-tag1" ><?php echo $latestvideo['currency']->symbol.' '.$latest_video->ppv_price; ?></p>
                                          <?php }elseif( !empty($latest_video->global_ppv || !empty($latest_video->global_ppv) && $latest_video->ppv_price == null)){ ?>
                                            <p class="p-tag1"><?php echo $latest_video->global_ppv.' '. $latestvideo['currency']->symbol; ?></p>
                                            <?php }elseif($latest_video->global_ppv == null && $latest_video->ppv_price == null ){ ?>
                                            <p class="p-tag" ><?php echo "Free"; ?></p>
                                            <?php } ?>
                                     
                                </div>
                                 
                                    <div class="block-description">
                                    
                                    <?php if( $latestvideo['ThumbnailSetting']->title == 1) { ?>            <!-- Title -->
                                        <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $latest_video->slug ?>">
                                             <h6><?php  echo (strlen($latest_video->title) > 17) ? substr($latest_video->title,0,18).'...' : $latest_video->title; ?></h6>
                                        </a>
                                    <?php } ?>  

                                    <div class="movie-time d-flex align-items-center pt-1">
                                        <?php if($latestvideo['ThumbnailSetting']->age == 1) { ?>
                                        <!-- Age -->
                                            <div class="badge badge-secondary p-1 mr-2"><?php echo $latest_video->age_restrict.' '.'+' ?></div>
                                        <?php } ?>

                                        <?php if($latestvideo['ThumbnailSetting']->duration == 1) { ?>
                                        <!-- Duration -->
                                            <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $latest_video->duration); ?></span>
                                        <?php } ?>
                                    </div>


                                    <?php if(($latestvideo['ThumbnailSetting']->published_year == 1) || ($latestvideo['ThumbnailSetting']->rating == 1)) {?>
                                    <div class="movie-time d-flex align-items-center pt-1">
                                        <?php if($latestvideo['ThumbnailSetting']->rating == 1) { ?>
                                        <!--Rating  -->
                                        <div class="badge badge-secondary p-1 mr-2">
                                            <span class="text-white">
                                                <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                <?php echo __($latest_video->rating); ?>
                                            </span>
                                        </div>
                                        <?php } ?>

                                        <?php if($latestvideo['ThumbnailSetting']->published_year == 1) { ?>
                                        <!-- published_year -->
                                        <div class="badge badge-secondary p-1 mr-2">
                                          <span class="text-white">
                                              <i class="fa fa-calendar" aria-hidden="true"></i>
                                              <?php echo __($latest_video->year); ?>
                                          </span>
                                        </div>
                                        <?php } ?>

                                        <?php if($latestvideo['ThumbnailSetting']->featured == 1 &&  $latest_video->featured == 1) { ?>
                                        <!-- Featured -->
                                        <div class="badge badge-secondary p-1 mr-2">
                                          <span class="text-white">
                                          <i class="fa fa-flag-o" aria-hidden="true"></i>
                                          </span>
                                        </div>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                                       <div class="hover-buttons">
                                           <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $latest_video->slug ?>">	
                                          <span class="text-white">
                                          <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                          Watch Now
                                          </span>
                                           </a>
                                           <div>
                                           <!-- <a   href="" class="text-white mt-4"><i class="fa fa-plus" aria-hidden="true"></i> Add to Watchlist</a> -->
                     </div>
                                       </div>
                                       <div>
                                            <button type="button" class="show-details-button" data-toggle="modal" data-target="#myModal<?= $latest_video->id;?>">
                                                <span class="text-center thumbarrow-sec">
                                                   <!-- <img src="<?php echo URL::to('/').'/assets/img/arrow-red.png';?>" class="thumbarrow thumbarrow-red" alt="right-arrow">-->
                                                </span>
                                            </button>
                                        </div>
                                    </div>

                                   <!-- <div class="block-social-info">
                                       <ul class="list-inline p-0 m-0 music-play-lists">
                                          <li><span><i class="ri-volume-mute-fill"></i></span></li>
                                          <li><span><i class="ri-heart-fill"></i></span></li>
                                          <li><span><i class="ri-add-line"></i></span></li>
                                       </ul>
                                    </div>-->

                                 </div>
                              </a>
                           </li>
                           
                            <?php endforeach; 
		                          endif; ?>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>

<?php include(public_path('themes/default/views/footer.blade.php'));  ?>

<?php 
    include(public_path('themes/theme3/views/header.php'));
?>

 <!-- MainContent -->
<section id="iq-favorites">
      <h3 class="vid-title text-center mt-4 mb-5">Latest Videos</h3> 
            <div class="container-fluid">
               <div class="row">
                  
                  <div class="col-sm-12 page-height">
                     <div class="iq-main-header align-items-center justify-content-between">
                                           
                     </div>
                     <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">
                        <?php if(isset($latestvideo['latest_videos'])) :
                          foreach($latestvideo['latest_videos'] as $latest_video): ?>
                           <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                              <a href="<?php echo URL::to('home') ?>">
                                 <div class="block-images position-relative">
                                    <div class="img-box">
                                       <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$latest_video->image;  ?>" class="img-fluid" alt="">
                                   
                                   
                                </div>
                                    <div class="block-description">
                                       
                                       <div class="hover-buttons">
                                           <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $latest_video->slug ?>">	
                                         <img class="ply" src="<?php echo URL::to('/').'/assets/img/play.svg';  ?>">                                  
                                           </a>
                                           <div>
                                           <!-- <a   href="" class="text-white mt-4"><i class="fa fa-plus" aria-hidden="true"></i> Add to Watchlist</a> -->
                     </div>
                                       </div> </div>
                                      
                                   

                                   <!-- <div class="block-social-info">
                                       <ul class="list-inline p-0 m-0 music-play-lists">
                                          <li><span><i class="ri-volume-mute-fill"></i></span></li>
                                          <li><span><i class="ri-heart-fill"></i></span></li>
                                          <li><span><i class="ri-add-line"></i></span></li>
                                       </ul>
                                    </div>-->

                                 </div>
                                  <div>

                                    <div class="mt-2 d-flex justify-content-between p-0">
                                       <?php if($latestvideo['ThumbnailSetting']->title == 1) { ?>
                                           <h6><?php  echo (strlen($latest_video->title) > 17) ? substr($latest_video->title,0,18).'...' : $latest_video->title; ?></h6>
                                       <?php } ?>

                                       <?php if($latestvideo['ThumbnailSetting']->age == 1) { ?>
                                           <div class="badge badge-secondary"><?php echo $latest_video->age_restrict.' '.'+' ?></div>
                                       <?php } ?>
                                    </div>


                                    <div class="movie-time my-2">
                      
                                       <!-- Duration -->
                  
                                       <?php if($latestvideo['ThumbnailSetting']->duration == 1) { ?>
                                       <span class="text-white">
                                          <i class="fa fa-clock-o"></i>
                                          <?= gmdate('H:i:s', $latest_video->duration); ?>
                                       </span>
                                       <?php } ?>
                  
                                       <!-- Rating -->
                  
                                       <?php if($latestvideo['ThumbnailSetting']->rating == 1 && $latest_video->rating != null) { ?>
                                       <span class="text-white">
                                          <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                          <?php echo __($latest_video->rating); ?>
                                       </span>
                                       <?php } ?>
                  
                                       <?php if($latestvideo['ThumbnailSetting']->featured == 1 && $latest_video->featured == 1) { ?>
                                          <!-- Featured -->
                                          <span class="text-white">
                                             <i class="fa fa-flag" aria-hidden="true"></i>
                                          </span>
                                       <?php }?>
                                    </div>
                                     
                                    <div class="movie-time my-2">
                                          <!-- published_year -->
                     
                                          <?php  if ( ($latestvideo['ThumbnailSetting']->published_year == 1) && ( $latest_video->year != null ) ) { ?>
                                          <span class="text-white">
                                             <i class="fa fa-calendar" aria-hidden="true"></i>
                                             <?php echo __($latest_video->year); ?>
                                          </span>
                                          <?php } ?>
                                    </div>

                                    <div class="movie-time my-2">
                                          <!-- Category Thumbnail  setting -->
                                          <?php
                                          $CategoryThumbnail_setting =  App\CategoryVideo::join('video_categories','video_categories.id','=','categoryvideos.category_id')
                                                      ->where('categoryvideos.video_id',$latest_video->id)
                                                      ->pluck('video_categories.name');        
                                          ?>
                                          <?php  if ( ($latestvideo['ThumbnailSetting']->category == 1 ) &&  ( count($CategoryThumbnail_setting) > 0 ) ) { ?>
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

<?php include(public_path('themes/theme3/views/footer.blade.php'));  ?>
                                
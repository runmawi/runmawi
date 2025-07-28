<?php 
    include(public_path('themes/theme1/views/header.php'));
?>

 <!-- MainContent -->
<section id="iq-favorites">
   <?php if( (isset($respond_data['videos']) && count($respond_data['videos']) > 0 )) {?>
      {{-- <h3 class="vid-title text-center mt-4 mb-5">Latest Videos</h3>  --}}
            <div class="container-fluid" style="padding: 0px 40px!important;background: linear-gradient(135.05deg, rgba(136, 136, 136, 0.48) 1.85%, rgba(64, 32, 32, 0.13) 38.53%, rgba(81, 57, 57, 0.12) 97.89%);">
               <div class="row">
                  <div class="col-sm-12 page-height">
                     <div class="iq-main-header align-items-center justify-content-between"></div>
                     <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">

                        <?php if(isset($respond_data['videos'])) :
                          foreach($respond_data['videos'] as $key => $video): ?>
                           <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                              <a href="<?php echo URL::to('category') ?><?= '/videos/' . $video->slug ?>">
                                 <div class="block-images position-relative">
                                    <div class="img-box">
                                       <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$video->image;  ?>" class="img-fluid w-100" alt="">
                                    </div>

                                    <div class="block-description">
                                       <div class="hover-buttons">
                                          <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $video->slug ?>">	
                                             <img class="ply" src="<?php echo URL::to('/').'/assets/img/play.svg';  ?>">                                  
                                          </a>
                                       <div>
                                    </div>
                                 </div> </div>
                                 </div>
                                  <div>

                                    <div class="mt-2 d-flex justify-content-between p-0">
                                       <?php if($respond_data['ThumbnailSetting']->title == 1) { ?>
                                           <h6><?php  echo (strlen($video->title) > 17) ? substr($video->title,0,18).'...' : $video->title; ?></h6>
                                       <?php } ?>

                                       <?php if($respond_data['ThumbnailSetting']->age == 1) { ?>
                                           <div class="badge badge-secondary"><?php echo $video->age_restrict.' '.'+' ?></div>
                                       <?php } ?>
                                    </div>


                                    <div class="movie-time my-2">
                      
                                       <!-- Duration -->
                  
                                       <?php if($respond_data['ThumbnailSetting']->duration == 1) { ?>
                                       <span class="text-white">
                                          <i class="fa fa-clock-o"></i>
                                          <?= gmdate('H:i:s', $video->duration); ?>
                                       </span>
                                       <?php } ?>
                  
                                       <!-- Rating -->
                  
                                       <?php if($respond_data['ThumbnailSetting']->rating == 1 && $video->rating != null) { ?>
                                       <span class="text-white">
                                          <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                          <?php echo __($video->rating); ?>
                                       </span>
                                       <?php } ?>
                  
                                       <?php if($respond_data['ThumbnailSetting']->featured == 1 && $video->featured == 1) { ?>
                                          <!-- Featured -->
                                          <span class="text-white">
                                             <i class="fa fa-flag" aria-hidden="true"></i>
                                          </span>
                                       <?php }?>
                                    </div>
                                     
                                    <div class="movie-time my-2">
                                          <!-- published_year -->
                     
                                          <?php  if ( ($respond_data['ThumbnailSetting']->published_year == 1) && ( $video->year != null ) ) { ?>
                                          <span class="text-white">
                                             <i class="fa fa-calendar" aria-hidden="true"></i>
                                             <?php echo __($video->year); ?>
                                          </span>
                                          <?php } ?>
                                    </div>

                                    <div class="movie-time my-2">
                                          <!-- Category Thumbnail  setting -->
                                          <?php
                                          $CategoryThumbnail_setting =  App\CategoryVideo::join('video_categories','video_categories.id','=','categoryvideos.category_id')
                                                      ->where('categoryvideos.video_id',$video->id)
                                                      ->pluck('video_categories.name');        
                                          ?>
                                          <?php  if ( ($respond_data['ThumbnailSetting']->category == 1 ) &&  ( count($CategoryThumbnail_setting) > 0 ) ) { ?>
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

                        <div class="col-md-12 pagination justify-content-end" >
                           {!!  $respond_data['videos']->links() !!}
                        </div>

                     </div>
                  </div>
               </div>
            </div>
   <?php } else{?>
      <div class="col-md-12 text-center mt-4" style="background: url(<?=URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                    <p ><h3 class="text-center">{{ __('No Video Available') }}</h3>
                </div>
   <?php } ?>

<?php include(public_path('themes/theme1/views/footer.blade.php'));  ?>                              
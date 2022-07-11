<?php 
    include(public_path('themes/theme1/views/header.php'));
?>

<section id="iq-favorites">
      <h3 class="vid-title text-center mt-4 mb-5">Featured Videos</h3> 
            <div class="container-fluid" style="padding: 0px 40px!important;background: linear-gradient(135.05deg, rgba(136, 136, 136, 0.48) 1.85%, rgba(64, 32, 32, 0.13) 38.53%, rgba(81, 57, 57, 0.12) 97.89%);">
           
               <div class="row">
                  <div class="col-sm-12 page-height">
                     <div class="iq-main-header align-items-center justify-content-between"></div>
                     <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">
                           @if(count($featured_videos) > 0)
                              @if(isset($featured_videos)) 
                                 @foreach($featured_videos as $featured_video)
                                    <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                       <a href="<?php echo URL::to('home') ?>">
                                          <div class="block-images position-relative">

                                             <div class="img-box">
                                                <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$featured_video->image;  ?>" class="img-fluid" alt="">
                                             </div>

                                             <div class="block-description">
                                                <div class="hover-buttons">
                                                   <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $featured_video->slug ?>">	
                                                      <img class="ply" src="<?php echo URL::to('/').'/assets/img/play.svg';  ?>">                                  
                                                   </a>
                                                <div>
                                             </div>

                                          </div> </div>
                                          </div>

                                          <div>
                                             <div class="mt-2 d-flex justify-content-between p-0">
                                                <?php if($ThumbnailSetting->title == 1) { ?>
                                                   <h6><?php  echo (strlen($featured_video->title) > 17) ? substr($featured_video->title,0,18).'...' : $featured_video->title; ?></h6>
                                                <?php } ?>

                                                <?php if($ThumbnailSetting->age == 1) { ?>
                                                   <div class="badge badge-secondary"><?php echo $featured_video->age_restrict.' '.'+' ?></div>
                                                <?php } ?>
                                             </div>

                                             <div class="movie-time my-2"> <!-- Duration -->
                                                @if($ThumbnailSetting->duration == 1)
                                                   <span class="text-white">
                                                      <i class="fa fa-clock-o"></i>
                                                      {{ gmdate('H:i:s', $featured_video->duration)  }}
                                                   </span>
                                                @endif
                           
                                             
                                                @if($ThumbnailSetting->rating == 1 && $featured_video->rating != null) 
                                                   <span class="text-white">  <!-- Rating -->
                                                      <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                      <?php echo __($featured_video->rating); ?>
                                                   </span>
                                                @endif
                           
                                                @if($ThumbnailSetting->featured == 1 && $featured_video->featured == 1) 
                                                   <span class="text-white">   <!-- Featured -->
                                                      <i class="fa fa-flag" aria-hidden="true"></i>
                                                   </span>
                                                @endif
                                             </div>
                                             
                                             <div class="movie-time my-2">  <!-- published_year -->
                                                @if ( ($ThumbnailSetting->published_year == 1) && ( $featured_video->year != null ) ) 
                                                      <span class="text-white">
                                                         <i class="fa fa-calendar" aria-hidden="true"></i>
                                                         <?php echo __($featured_video->year); ?>
                                                      </span>
                                                @endif
                                             </div>

                                             <div class="movie-time my-2">
                                                   <!-- Category Thumbnail  setting -->
                                                   <?php
                                                   $CategoryThumbnail_setting =  App\CategoryVideo::join('video_categories','video_categories.id','=','categoryvideos.category_id')
                                                               ->where('categoryvideos.video_id',$featured_video->id)
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
                                             
                                          </div>
                                       </a>
                                    </li>
                                 @endforeach
                              @endif
                           @else
                              <div class="col-md-12 text-center mt-4" style="background: url(<?=URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:cover;height: 500px!important;">
                                 <p><h2 style="position: absolute;top: 50%;left: 50%;color: white;">No video Available</h2>
                              </div>
                           @endif
                        </ul>
                     </div>
                  </div>
               </div>
            </div>

<?php include(public_path('themes/theme1/views/footer.blade.php'));  ?>



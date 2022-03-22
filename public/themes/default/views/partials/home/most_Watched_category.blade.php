<style>
    .playvid {
        display: block;
        width: 280%;
        height: auto !important;
        margin-left: -410px;
    }

    .btn.btn-primary.close {
        margin-right: -17px;
        background-color: #4895d1 !important;
    }

    button.close {
        padding: 9px 30px !important;
        border: 0;
        -webkit-appearance: none;
    }

    .close {
        margin-right: -429px !important;
        margin-top: -1461px !important;
    }

    .modal-footer {
        border-bottom: 0px !important;
        border-top: 0px !important;

    }

</style>
        <div class="col-sm-12 overflow-hidden">
            <div class="iq-main-header d-flex align-items-center justify-content-between">
                <!-- <h4 class="main-title"><a href="<?php echo URL::to('home') ?>">Latest Videos</a></h4> -->
                <a href="<?php echo URL::to('/category/').'/'.$category->slug;?>" class="category-heading"
                    style="text-decoration:none;color:#fff">
                    <h4 class="movie-title">
                        <?php 
                         $setting= \App\HomeSetting::first();
                            if($setting['Recommendation'] !=null && $setting['Recommendation'] != 0 ):

                         echo __('Most watched videos from '.$category->name.' Genre');?>
                    </h4>
                </a>
            </div>
            <div class="favorites-contens">
                <ul class="favorites-slider list-inline  row p-0 mb-0">
                <?php  
                if(!empty($data['password_hash'])) { 
                          $id = Auth::user()->id ; } else { $id = 0 ; } ?>
                    <?php  if(isset($top_category_videos)) :
                       foreach($top_category_videos as $category_video):
                        
                        ?>
                    <li class="slide-item">
                            <div class="block-images position-relative">
                            <!-- block-images -->
                            <a href="<?php echo URL::to('category') ?><?= '/videos/' . $category_video->slug ?>">
                                    <!-- <img src="<?php echo URL::to('/').'/public/uploads/images/'.$category_video->image;  ?>"
                                        class="img-fluid" alt=""> -->
                                        <video  width="100%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$category_video->mobile_image;  ?>"  data-play="hover" >
                                            <source src="<?php echo $category_video->trailer;  ?>" type="video/mp4">
                                            </video>
                                    </a>
                                <div class="corner-text-wrapper">
                                    <div class="corner-text">
                                    <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?> 
                                        <p class="p-tag1">  
                                            <?php if(!empty($category_video->ppv_price)) {
                                                   echo $category_video->ppv_price.' '.$currency->symbol ; 
                                                } elseif(!empty($category_video->global_ppv) && $category_video->ppv_price == null) {
                                                    echo $category_video->global_ppv .' '.$currency->symbol;
                                                } elseif(empty($category_video->global_ppv) && $category_video->ppv_price == null) {
                                                    echo "Free"; 
                                                }
                                            ?>
                                        </p>
                                    <?php }?>
                                    </div>
                                </div>
                                <div class="block-description">

                                    <?php if($ThumbnailSetting->title == 1) { ?>            <!-- Title -->
                                        <a href="<?php echo URL::to('category') ?><?= '/videos/' . $category_video->slug ?>">
                                            <h6> <?php echo __($category_video->title); ?> </h6>
                                        </a>
                                    <?php } ?>   

                                    <div class="movie-time d-flex align-items-center pt-1">
                                        <?php if($ThumbnailSetting->age == 1) { ?>
                                        <!-- Age -->
                                        <div class="badge badge-secondary p-1 mr-2"><?php echo $category_video->age_restrict.' '.'+' ?></div>
                                        <?php } ?>
  
                                        <?php if($ThumbnailSetting->duration == 1) { ?>
                                        <!-- Duration -->
                                        <span class="text-white">
                                            <i class="fa fa-clock-o"></i>
                                            <?= gmdate('H:i:s', $category_video->duration); ?>
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
                                                    <?php echo __($category_video->rating); ?>
                                                </span>
                                            </div>
                                            <?php } ?>
    
                                            <?php if($ThumbnailSetting->published_year == 1) { ?>
                                            <!-- published_year -->
                                            <div class="badge badge-secondary p-1 mr-2">
                                              <span class="text-white">
                                                  <i class="fa fa-calendar" aria-hidden="true"></i>
                                                  <?php echo __($category_video->year); ?>
                                              </span>
                                            </div>
                                            <?php } ?>
    
                                            <?php if($ThumbnailSetting->featured == 1 && $category_video->featured == 1) { ?>
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
                                                   ->where('categoryvideos.video_id',$category_video->id)
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
                                        <a type="button" class="text-white d-flex"
                                            href="<?php echo URL::to('category') ?><?= '/videos/' . $category_video->slug ?>">
                                                <img class="ply" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>"  width="10%" height="10%"/> Watch Now
                                        </a>
                                    <div>
                              </div>
                                       <!-- <a   href="<?php // echo URL::to('category') ?><? // '/wishlist/' . $cont_video->slug ?>" class="text-white mt-4"><i class="fa fa-plus" aria-hidden="true"></i> Add to Watchlist -->
                       <!-- </a> -->
                    </div>

                        <!--
                           <div>
                               <button class="show-details-button" data-id="<?= $category_video->id;?>">
                                   <span class="text-center thumbarrow-sec">
                                       <img src="<?php echo URL::to('/').'/assets/img/arrow-red.png';?>" class="thumbarrow thumbarrow-red" alt="right-arrow">
                                   </span>
                                       </button></div>
                        -->
                                </div>
                              
                            </div>
                    </li>
                    <?php           
                          endforeach; 
                     endif; endif; ?>
                </ul>
            </div>
        </div>


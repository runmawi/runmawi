<div class="fluid">
    <div class="col-sm-12 overflow-hidden p-0">
        <div class="iq-main-header d-flex align-items-center justify-content-between">
            <!-- <h4 class="main-title"><a href="<?php echo URL::to('home') ?>">Latest Videos</a></h4> -->
            <a href="<?php echo URL::to('/category/').'/'.$category->slug;?>" class="category-heading" style="text-decoration: none; color: #fff;">
                <h4 class="movie-title">
                    <?php 
                         $setting= \App\HomeSetting::first();
                            if($setting['Recommendation'] !=null && $setting['Recommendation'] != 0 ):

                         echo __('Most watched videos from '.$category->name.' Genre');?>
                </h4>
            </a>
        </div>
        <div class="favorites-contens">
            <ul class="favorites-slider list-inline row p-0 mb-0">
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
                            <video width="100%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$category_video->image;  ?>" data-play="hover">
                                <source src="<?php echo $category_video->trailer;  ?>" type="video/mp4" />
                            </video>

                            <!-- PPV price -->
                            <div class="corner-text-wrapper">
                                <div class="corner-text">
                                    <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>
                                    <?php  if(!empty($category_video->ppv_price)){?>
                                    <p class="p-tag1"><?php echo $currency->symbol.' '.$category_video->ppv_price; ?></p>
                                    <?php }elseif( !empty($category_video->global_ppv || !empty($category_video->global_ppv) && $category_video->ppv_price == null)){ ?>
                                    <p class="p-tag1"><?php echo $category_video->global_ppv.' '.$currency->symbol; ?></p>
                                    <?php }elseif($category_video->global_ppv == null && $category_video->ppv_price == null ){ ?>
                                    <p class="p-tag"><?php echo "Free"; ?></p>
                                    <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="block-description">
                        <div class="hover-buttons">
                            <a type="button" class="text-white btn-cl" href="<?php echo URL::to('category') ?><?= '/videos/' . $category_video->slug ?>"> <img class="ply" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>" /> </a>
                            <!--   <div class="">
                                        <span style="color: white;"class="mywishlist <?php if(isset($mywishlisted->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $category_video->id ?>">
                            <i style="" <?php if(isset($mywishlisted->id)): ?> class="ri-heart-fill" <?php else: ?> class="ri-heart-line " <?php endif; ?> style="" ></i>
                          </span>
                          <div style="color:white;" id="<?= $category_video->id ?>"><?php if(@$category_video->mywishlisted->user_id == $id && @$category_video->mywishlisted->video_id == $category_video->id  ) { echo "Remove From Wishlist"; } else { echo "Add To Wishlist" ; } ?></div> 
                              </div>
                                       <!-- <a   href="<?php // echo URL::to('category') ?><? // '/wishlist/' . $category_video->slug ?>" class="text-white mt-4"><i class="fa fa-plus" aria-hidden="true"></i> Add to Watchlist -->
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
                   

                    <div class="mt-2 d-flex justify-content-between p-0">
                        <?php if($ThumbnailSetting->title == 1) { ?>
                        <h6><?php  echo (strlen($category_video->title) > 17) ? substr($category_video->title,0,18).'...' : $category_video->title; ?></h6>
                        <?php } ?>
    
                        <?php if($ThumbnailSetting->age == 1) { ?>
                        <div class="badge badge-secondary"><?php echo $category_video->age_restrict.' '.'+' ?></div>
                        <?php } ?>
                    </div>
                    <div class="movie-time my-2">
                      
                        <!-- Duration -->
    
                        <?php if($ThumbnailSetting->duration == 1) { ?>
                        <span class="text-white">
                            <i class="fa fa-clock-o"></i>
                            <?= gmdate('H:i:s', $category_video->duration); ?>
                        </span>
                        <?php } ?>
    
                        <!-- Rating -->
    
                        <?php if($ThumbnailSetting->rating == 1 && $category_video->rating != null) { ?>
                        <span class="text-white">
                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                            <?php echo __($category_video->rating); ?>
                        </span>
                        <?php } ?>
    
                        <?php if($ThumbnailSetting->featured == 1 && $category_video->featured == 1) { ?>
                            <!-- Featured -->
                            <span class="text-white">
                                <i class="fa fa-flag" aria-hidden="true"></i>
                            </span>
                        <?php }?>
                    </div>
    
                    <div class="movie-time my-2">
                        <!-- published_year -->
    
                        <?php  if ( ($ThumbnailSetting->published_year == 1) && ( $category_video->year != null ) ) { ?>
                        <span class="text-white">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                            <?php echo __($category_video->year); ?>
                        </span>
                        <?php } ?>
                    </div>

                    <div class="movie-time my-2">
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

                </li>
                <?php           
                          endforeach; 
                     endif; endif; ?>
            </ul>
        </div>
    </div>
</div>

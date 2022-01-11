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
                                        <video  width="100%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$category_video->image;  ?>"  data-play="hover" >
                                            <source src="<?php echo $category_video->trailer;  ?>" type="video/mp4">
                                            </video>
                                    </a>
                                <div class="corner-text-wrapper">
                                    <div class="corner-text">
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
                                    </div>
                                </div>
                                <div class="block-description">
                                    <a href="<?php echo URL::to('category') ?><?= '/videos/' . $category_video->slug ?>">
                                        <h6>
                                            <?php echo __($category_video->title); ?>
                                        </h6>
                                    </a>
                                    <div class="movie-time d-flex align-items-center my-2">
                                        <div class="badge badge-secondary p-1 mr-2"><?php echo $category_video->age_restrict ?></div>
                                        <span class="text-white"><i class="fa fa-clock-o"></i>
                                            <?= gmdate('H:i:s', $category_video->duration); ?>
                                        </span>
                                    </div>
                                    <div class="hover-buttons">
                                        <a type="button" class="text-white"
                                            href="<?php echo URL::to('category') ?><?= '/videos/' . $category_video->slug ?>">

                                            <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                            Watch Now

                                        </a>
                                        <div>
                                        <span style="color: white;"class="mywishlist <?php if(isset($mywishlisted->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $category_video->id ?>">
                            <i style="" <?php if(isset($mywishlisted->id)): ?> class="ri-heart-fill" <?php else: ?> class="ri-heart-line " <?php endif; ?> style="" ></i>
                          </span>
                          <div style="color:white;" id="<?= $category_video->id ?>"><?php if(@$category_video->mywishlisted->user_id == $id && @$category_video->mywishlisted->video_id == $category_video->id  ) { echo "Remove From Wishlist"; } else { echo "Add To Wishlist" ; } ?></div> 
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


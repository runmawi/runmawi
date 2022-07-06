  <div class="favorites-contens">
                        <ul class="category-page list-inline  row p-0 mb-4">
                            <?php if (count($categoryVideos['categoryVideos']) > 0) { ?>         
                                    @foreach($categoryVideos['categoryVideos']  as $category_video) 
                                    <li class="slide-item col-sm-2 col-md-2 col-xs-12 margin-bottom-30">
                                        <a href="<?php echo URL::to('category') ?><?= '/videos/' . $category_video->slug ?>">
                                            <div class="block-images position-relative">
                                                <div class="img-box">
                                                    <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$category_video->image;  ?>" class="img-fluid" alt="" width="">
                                                 </div>
                                            </div>

                                            <div class="block-description" >
                                                <div class="hover-buttons">
                                                    <a  class="text-white btn-cl"  href="<?php echo URL::to('category') ?><?= '/videos/' . $category_video->slug ?>">
                                                        <img class="ply" src="<?php echo URL::to('/').'/assets/img/play.png';  ?>">                                      
                                                    
                                                        @if($categoryVideos['ThumbnailSetting']->free_or_cost_label == 1) 
                                                            @if(!empty($category_video->ppv_price))
                                                                <p class="p-tag1">
                                                                     {{ $currency->symbol.' '.$category_video->ppv_price }}
                                                                </p>
                                                            @elseif( !empty($category_video->global_ppv || !empty($category_video->global_ppv) && $category_video->ppv_price == null)){ ?>
                                                                <p class="p-tag1">
                                                                     {{ $category_video->global_ppv.' '.$currency->symbol }} 
                                                                </p>
                                                            @elseif($category_video->global_ppv == null && $category_video->ppv_price == null )
                                                                <p class="p-tag">
                                                                    {{ "Free" }}
                                                                </p>
                                                            @endif
                                                        @endif

                                                    </a>
                                                </div>
                                                </div>

                                                <div>
                                                    <div class="movie-time d-flex align-items-center justify-content-between my-2">
                                                        <?php if($categoryVideos['ThumbnailSetting']->title == 1) { ?>
                                                            <h6><?php  echo (strlen($category_video->title) > 17) ? substr($category_video->title,0,18).'...' : $category_video->title; ?></h6>
                                                        <?php } ?>
                 
                                                        <?php if($categoryVideos['ThumbnailSetting']->age == 1) { ?>
                                                            <div class="badge badge-secondary"><?php echo $category_video->age_restrict.' '.'+' ?></div>
                                                        <?php } ?>
                                                    </div>

                                                    <div class="movie-time my-2">
                      
                                                        <!-- Duration -->
                                   
                                                        <?php if($categoryVideos['ThumbnailSetting']->duration == 1) { ?>
                                                        <span class="text-white">
                                                           <i class="fa fa-clock-o"></i>
                                                           <?= gmdate('H:i:s', $category_video->duration); ?>
                                                        </span>
                                                        <?php } ?>
                                   
                                                        <!-- Rating -->
                                   
                                                        <?php if($categoryVideos['ThumbnailSetting']->rating == 1 && $category_video->rating != null) { ?>
                                                        <span class="text-white">
                                                           <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                           <?php echo __($category_video->rating); ?>
                                                        </span>
                                                        <?php } ?>
                                   
                                                        <?php if($categoryVideos['ThumbnailSetting']->featured == 1 && $category_video->featured == 1) { ?>
                                                           <!-- Featured -->
                                                           <span class="text-white">
                                                              <i class="fa fa-flag" aria-hidden="true"></i>
                                                           </span>
                                                        <?php }?>
                                                     </div>

                                                     <div class="movie-time my-2">
                                                        <!-- published_year -->
                                   
                                                        <?php  if ( ($categoryVideos['ThumbnailSetting']->published_year == 1) && ( $category_video->year != null ) ) { ?>
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
                                                                ->where('categoryvideos.video_id',$category_video->video_id)
                                                                ->pluck('video_categories.name');       

                                                    ?>
                                                    <?php  if ( ($categoryVideos['ThumbnailSetting']->category == 1 ) &&  ( count($CategoryThumbnail_setting) > 0 ) ) { ?>
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
                                                <!--
                                                <div class="block-social-info">
                                                    <ul class="list-inline p-0 m-0 music-play-lists">
                                                        <li><span><i class="ri-volume-mute-fill"></i></span></li>
                                                        <li><span><i class="ri-heart-fill"></i></span></li>
                                                        <li><span><i class="ri-add-line"></i></span></li>
                                                    </ul>
                                                </div>
                                                    -->
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                                <?php } else { ?>
                                            <!-- <p class="no_video"> <?php echo __('No Video Found');?></p> -->
                                            <!-- <p><h2>No Media in My Watchlater</h2></p> -->
                                        <div class="col-md-12 text-center mt-4" style="background: url(<?=URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:cover;height: 500px!important;">
                                <p ><h2 style="position: absolute;top: 50%;left: 50%;color: white;">No video Available</h2>
                                </div>
                            <?php } ?>
                    
                                                              
                           
                        </ul>
                         
                    </div>
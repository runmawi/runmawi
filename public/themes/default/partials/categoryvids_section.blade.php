<div class="favorites-contens data" >
    <ul class="category-page list-inline  row p-0 mb-4">
        <?php if (count($data['categoryVideos']) > 0) { ?>         
                @forelse($data['categoryVideos']  as $key => $testinfg) 

                <li class="slide-item col-sm-2 col-md-2 col-xs-12 margin-bottom-30">
                    <a href="<?php echo URL::to('category') ?><?= '/videos/' . $testinfg->slug ?>">
                        <div class="block-images position-relative">
                            <div class="img-box">
                            <img src="<?php echo URL::to('/').'/public/uploads/images/'.$testinfg->image;  ?>" class="img-fluid w-100" alt="" width="">
                            
                      <?php  if(!empty($testinfg->ppv_price)){?>
                      <p class="p-tag1" ><?php echo $data['currency']->symbol.' '.$testinfg->ppv_price; ?></p>
                      <?php }elseif( !empty($testinfg->global_ppv || !empty($testinfg->global_ppv) && $testinfg->ppv_price == null)){ ?>
                        <p class="p-tag1"><?php echo $testinfg->global_ppv.' '.$data['currency']->symbol; ?></p>
                                <?php }elseif($testinfg->global_ppv == null && $testinfg->ppv_price == null ){ ?>
                                <p class="p-tag"><?php echo "Free"; ?></p>
                                <?php } ?>
                           
                    </div>
                            <!-- </div> -->

                        <div class="block-description">
                                
                            <?php if($data['ThumbnailSetting']->title == 1) { ?>            <!-- Title -->
                                <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $testinfg->slug ?>">
                                         <h6><?php  echo (strlen($testinfg->title) > 17) ? substr($testinfg->title,0,18).'...' : $testinfg->title; ?></h6>
                                </a>
                            <?php } ?>  
                                
                            <div class="movie-time d-flex align-items-center pt-1">
                                    <?php if($data['ThumbnailSetting']->age == 1) { ?>
                                    <!-- Age -->
                                        <div class="badge badge-secondary p-1 mr-2"><?php echo $testinfg->age_restrict.' '.'+' ?></div>
                                    <?php } ?>

                                    <?php if($data['ThumbnailSetting']->duration == 1) { ?>
                                    <!-- Duration -->
                                        <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $testinfg->duration); ?></span>
                                    <?php } ?>
                            </div>


                            <?php if(($data['ThumbnailSetting']->published_year == 1) || ($data['ThumbnailSetting']->rating == 1)) {?>
                                <div class="movie-time d-flex align-items-center pt-1">
                                    <?php if($data['ThumbnailSetting']->rating == 1) { ?>
                                        <!--Rating  -->
                                        <div class="badge badge-secondary p-1 mr-2">
                                            <span class="text-white">
                                                <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                <?php echo __($testinfg->rating); ?>
                                            </span>
                                        </div>
                                    <?php } ?>

                                    <?php if($data['ThumbnailSetting']->published_year == 1) { ?>
                                        <!-- published_year -->
                                        <div class="badge badge-secondary p-1 mr-2">
                                          <span class="text-white">
                                              <i class="fa fa-calendar" aria-hidden="true"></i>
                                              <?php echo __($testinfg->year); ?>
                                          </span>
                                        </div>
                                    <?php } ?>

                                    <?php if($data['ThumbnailSetting']->featured == 1 &&  $testinfg->featured == 1) { ?>
                                        <!-- Featured -->
                                    <div class="badge badge-secondary p-1 mr-2">
                                          <span class="text-white">
                                            <i class="fa fa-flag-o" aria-hidden="true"></i>
                                          </span>
                                        </div>
                                        <?php } ?>
                                    </div>
                                <?php } ?>

                                <div class="movie-time my-2">
                                    <!-- Category Thumbnail  setting -->
                                    <?php
                                    $CategoryThumbnail_setting =  App\CategoryVideo::join('video_categories','video_categories.id','=','categoryvideos.category_id')
                                                ->where('categoryvideos.video_id',$testinfg->video_id)
                                                ->pluck('video_categories.name');        
                                    ?>
                                    <?php  if ( ($data['ThumbnailSetting']->category == 1 ) &&  ( count($CategoryThumbnail_setting) > 0 ) ) { ?>
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
                                    <a  class="text-white"  href="<?php echo URL::to('category') ?><?= '/videos/' . $testinfg->slug ?>">
                                        <span class=""><i class="fa fa-play mr-1" aria-hidden="true"></i>Watch Now</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
        @empty

        @endforelse
        <?php } else { ?>
                <div class="col-md-12 text-center mt-4" style="background: url(<?=URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
           <p ><h3 class="text-center">No video Available</h3>
        </div>
         <?php } ?>
    </ul>
 </div>
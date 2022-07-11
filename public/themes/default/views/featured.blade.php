<?php 
    include(public_path('themes/default/views/header.php'));
?>

<section id="iq-favorites">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header align-items-center justify-content-between">
                    <h3 class="vid-title">Featured Videos </h3>                     
                </div>

                <div class="favorites-contens">
                    <ul class="category-page list-inline row p-0 mb-0">

                    @if(count($featured_videos) > 0 )
                        @if(isset($featured_videos)) 
                           @foreach($featured_videos as $featured_video)

                           <li class="slide-item col-sm-2 col-md-2 col-xs-12">

                              <a href="<?php echo URL::to('home') ?>">
                                <div class="block-images position-relative">

                                    <div class="img-box">
                                       <img src="<?php echo URL::to('/').'/public/uploads/images/'.$featured_video->image;  ?>" class="img-fluid" alt="">
                                        <?php  if(!empty($featured_video->ppv_price)){?>
                                          <p class="p-tag1" ><?php echo $currency->symbol.' '.$featured_video->ppv_price; ?></p>
                                          <?php }elseif( !empty($featured_video->global_ppv || !empty($featured_video->global_ppv) && $featured_video->ppv_price == null)){ ?>
                                            <p class="p-tag1"><?php echo $featured_video->global_ppv.' '.$currency->symbol; ?></p>
                                            <?php }elseif($featured_video->global_ppv == null && $featured_video->ppv_price == null ){ ?>
                                            <p class="p-tag" ><?php echo "Free"; ?></p>
                                        <?php } ?>
                                    </div>
                                 
                                    <div class="block-description" >
                                    
                                        <?php if($ThumbnailSetting->title == 1) { ?>            <!-- Title -->
                                            <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $featured_video->slug ?>">
                                                <h6><?php  echo (strlen($featured_video->title) > 17) ? substr($featured_video->title,0,18).'...' : $featured_video->title; ?></h6>
                                            </a>
                                        <?php } ?>  

                                        <div class="movie-time d-flex align-items-center pt-1">
                                            <?php if($ThumbnailSetting->age == 1) { ?>
                                            <!-- Age -->
                                                <div class="badge badge-secondary p-1 mr-2"><?php echo $featured_video->age_restrict.' '.'+' ?></div>
                                            <?php } ?>

                                            <?php if($ThumbnailSetting->duration == 1) { ?>
                                            <!-- Duration -->
                                                <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $featured_video->duration); ?></span>
                                            <?php } ?>
                                        </div>


                                        <?php if(($ThumbnailSetting->published_year == 1) || ($ThumbnailSetting->rating == 1)) {?>
                                            <div class="movie-time d-flex align-items-center pt-1">
                                                <?php if($ThumbnailSetting->rating == 1) { ?>
                                                <!--Rating  -->
                                                <div class="badge badge-secondary p-1 mr-2">
                                                    <span class="text-white">
                                                        <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                        <?php echo __($featured_video->rating); ?>
                                                    </span>
                                                </div>
                                                <?php } ?>

                                                <?php if($ThumbnailSetting->published_year == 1) { ?>
                                                <!-- published_year -->
                                                <div class="badge badge-secondary p-1 mr-2">
                                                <span class="text-white">
                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                    <?php echo __($featured_video->year); ?>
                                                </span>
                                                </div>
                                                <?php } ?>

                                                <?php if($ThumbnailSetting->featured == 1 &&  $featured_video->featured == 1) { ?>
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
                                            <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $featured_video->slug ?>">	
                                                <span class="text-white">
                                                    <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                    Watch Now
                                                </span>
                                            </a>
                                        <div>
                                    </div>

                                </div>

                                <div>
                                    <button type="button" class="show-details-button" data-toggle="modal" data-target="#myModal<?= $featured_video->id;?>">
                                        <span class="text-center thumbarrow-sec">
                                            <!-- <img src="<?php echo URL::to('/').'/assets/img/arrow-red.png';?>" class="thumbarrow thumbarrow-red" alt="right-arrow">-->
                                        </span>
                                    </button>
                                </div>
                                </div>

                                 </div>
                              </a>
                           </li>
                          @endforeach
                        @endif
                        @else
                            <div class="col-md-12 text-center mt-4" style="background: url(<?=URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                                <p ><h3 class="text-center">No Featured Available</h3>
                            </div>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include(public_path('themes/default/views/footer.blade.php'));  ?>
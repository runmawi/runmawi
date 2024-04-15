<section id="iq-favorites">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header align-items-center justify-content-between">
                    <h4 class="vid-title"><?php echo __('Series Category'); ?></h4>                     
                </div>
                <div class="favorites-contens">
                    <ul class="category-page list-inline row p-0 mb-0">
                      <?php if(isset($SeriesCategory)) {
                        foreach($SeriesCategory as $Series_Category){ ?>
                            <li class="slide-item">
                                <div class="block-images position-relative">
                                
                                                    <!-- block-images -->
                                    <div class="border-bg">
                                        <div class="img-box">
                                            <a class="playTrailer" href="<?php echo URL::to('/play_series'.'/'.$Series_Category->slug ) ?>">
                                                <img class="img-fluid w-100" loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.@$Series_Category->image;  ?>"  alt="series">
                                            </a>

                                            <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?> 
                                                <?php if($Series_Category->access == 'subscriber' ){ ?>
                                                    <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                                                <?php }elseif($Series_Category->access == 'registered'){?>
                                                    <p class="p-tag"><?php echo (__('Register Now')); ?></p>
                                                <?php } elseif(!empty($Series_Category->ppv_status)){?>
                                                    <p class="p-tag1"><?php echo $currency->symbol.' '.$settings->ppv_price; ?></p>
                                                <?php }elseif(!empty($Series_Category->ppv_status || !empty($Series_Category->ppv_status) && $Series_Category->ppv_status == null)){ ?>
                                                    <p class="p-tag1"><?php echo $currency->symbol.' '.$settings->ppv_status; ?></p>
                                                <?php }elseif($Series_Category->ppv_status == null && $Series_Category->ppv_price == null ){ ?>
                                                    <p class="p-tag"><?php echo (__('Free')); ?></p>
                                                <?php } ?>
                                            <?php } ?>
                                        
                                        </div>
                                    </div>

                                    <div class="block-description">
                                        <a class="playTrailer" href="<?php echo URL::to('/play_series'.'/'.$Series_Category->slug ) ?>">
                                            <img class="img-fluid w-100" loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.@$Series_Category->player_image;  ?>" alt="series">
                                    

                                            <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?> 
                                                <?php if($Series_Category->access == 'subscriber' ){ ?>
                                                    <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                                                <?php }elseif($Series_Category->access == 'registered'){?>
                                                    <p class="p-tag"><?php echo (__('Register Now')); ?></p>
                                                <?php } elseif(!empty($Series_Category->ppv_status)){?>
                                                    <p class="p-tag1"><?php echo $currency->symbol.' '.$settings->ppv_price; ?></p>
                                                <?php }elseif(!empty($Series_Category->ppv_status || !empty($Series_Category->ppv_status) && $Series_Category->ppv_status == null)){ ?>
                                                    <p class="p-tag1"><?php echo $currency->symbol.' '.$settings->ppv_status; ?></p>
                                                <?php }elseif($Series_Category->ppv_status == null && $Series_Category->ppv_price == null ){ ?>
                                                    <p class="p-tag"><?php echo (__('Free')); ?></p>
                                                <?php } ?>
                                            <?php } ?>
                                        </a>
                                        <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?> 
                                            <?php if($Series_Category->access == 'subscriber' ){ ?>
                                                <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                                            <?php }elseif($Series_Category->access == 'registered'){?>
                                                <p class="p-tag"><?php echo (__('Register Now')); ?></p>
                                            <?php } elseif(!empty($Series_Category->ppv_status)){?>
                                                <p class="p-tag1"><?php echo $currency->symbol.' '.$settings->ppv_price; ?></p>
                                            <?php }elseif(!empty($Series_Category->ppv_status || !empty($Series_Category->ppv_status) && $Series_Category->ppv_status == null)){ ?>
                                                <p class="p-tag1"><?php echo $currency->symbol.' '.$settings->ppv_status; ?></p>
                                            <?php }elseif($Series_Category->ppv_status == null && $Series_Category->ppv_price == null ){ ?>
                                                <p class="p-tag"><?php echo (__('Free')); ?></p>
                                            <?php } ?>
                                        <?php } ?>

                                        <div class="hover-buttons text-white"> 
                                            <a class="text-white" href="<?php echo URL::to('/play_series'.'/'.$Series_Category->slug ) ?>" >
                                                <p class="epi-name text-left m-0"><?php echo __($Series_Category->title); ?></p>
                                    
                                                <div class="movie-time d-flex align-items-center my-2">
                                                    <p class="badge badge-secondary p-1 mr-2"><?php echo $Series_Category->age_restrict.' '.'+' ?></p>
                                                    <p class="badge badge-secondary p-1 mr-2"><?php 
                                                    $SeriesSeason = App\SeriesSeason::where('series_id',$Series_Category->id)->count(); 
                                                    echo $SeriesSeason.' '.'Season'
                                                    ?></p>
                                                    <p class="badge badge-secondary p-1 mr-2"><?php 
                                                    $Episode = App\Episode::where('series_id',$Series_Category->id)->count(); 
                                                    echo $Episode.' '.'Episodes'
                                                    ?></p>

                                                </div>
                                            </a>

                                    
                                            <a class="epi-name mt-5 mb-0 btn" href="<?php echo URL::to('/play_series'.'/'.$Series_Category->slug ) ?>" >
                                                <i class="fa fa-play mr-1" aria-hidden="true"></i> <?= ('Watch Series') ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>






                            <!-- <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                <a href="<?php echo URL::to('/play_series'.'/'.$Series_Category->slug ) ?> ">
                                    <div class="block-images position-relative">
                                        <div class="img-box">
                                            <img src="<?php echo URL::to('/').'/public/uploads/images/'.@$Series_Category->image;  ?>" class="img-fluid w-100" alt="">
                                        </div>
                            
                                        <div class="block-description" >
                                                <a href="<?php echo URL::to('/play_series'.'/'.$Series_Category->slug ) ?>">
                                                    <h6><?php  echo (strlen(@$Series_Category->title) > 17) ? substr(@$Series_Category->title,0,18).'...' : @$Series_Category->title; ?></h6>
                                                </a>
                                            <div class="hover-buttons"><div>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" class="show-details-button" data-toggle="modal" data-target="#myModal<?= @$Series_Category->id;?>">
                                            <span class="text-center thumbarrow-sec"></span>
                                        </button>
                                    </div> </div> </div>
                                </a>
                            </li> -->
                            
                           <?php } } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>



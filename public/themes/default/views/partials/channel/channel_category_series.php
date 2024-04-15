<section id="iq-favorites">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header align-items-center justify-content-between">
                    <h4 class="vid-title"><?php echo __('Series Category'); ?></h4>                     
                </div>
                <div class="favorites-contens">
                    <ul class="favorites-slider category-page list-inline row p-0 mb-0">
                      <?php if(isset($SeriesCategory)) {
                        foreach($SeriesCategory as $Series_Category){ ?>
                        
                            <li class="slide-item">
                                <a class="playTrailer" href="<?php echo URL::to('/play_series'.'/'.$Series_Category->slug ) ?> ">
                                    <div class="block-images position-relative">
                                        <div class="img-box">
                                            <img src="<?php echo URL::to('/').'/public/uploads/images/'.@$Series_Category->image;  ?>" class="img-fluid w-100" alt="">
                                        </div>
                            
                                        <div class="block-description" >
                                            <a class="playTrailer" href="<?php echo URL::to('/play_series'.'/'.$Series_Category->slug ) ?>">
                                                <img class="img-fluid w-100" loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.@$Series_Category->player_image;  ?>" alt="series">
                                            </a>
                                            <div class="hover-buttons text-white">
                                                <a href="<?php echo URL::to('/play_series'.'/'.$Series_Category->slug ) ?>">
                                                    <p class="epi-name text-left m-0"><?php  echo (strlen(@$Series_Category->title) > 17) ? substr(@$Series_Category->title,0,18).'...' : @$Series_Category->title; ?></p>
                                                </a>

                                                <a class="epi-name mt-5 mb-0 btn" href="<?php echo URL::to('/play_series'.'/'.$Series_Category->slug ) ?>" >
                                                    <i class="fa fa-play mr-1" aria-hidden="true"></i> <?=  ('Watch Series') ?>
                                                </a>
                                            </div>
                                        </div>
                                        <div>
                                            <button type="button" class="show-details-button" data-toggle="modal" data-target="#myModal<?= @$Series_Category->id;?>">
                                                <span class="text-center thumbarrow-sec"></span>
                                            </button>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            
                        <?php } } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>



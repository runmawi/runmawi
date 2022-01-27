<div class="iq-main-header d-flex align-items-center justify-content-between">
        <h4 class="main-title"><a href="">Most Watching Videos in <?php echo $countryName;?></a></h4>                      
</div>
    <div class="favorites-contens">
        <ul class="favorites-slider list-inline  row p-0 mb-0">
                <?php  if(isset($Most_watched_country)) :
                    foreach($Most_watched_country as $Most_watched_countries): 
                ?>

                <li class="slide-item">
                    <a href="<?php echo URL::to('home') ?>">
                        <div class="block-images position-relative">
                                <div class="img-box">
                                    <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $Most_watched_countries->slug ?>">
                                        <!-- <img src="<?php echo URL::to('/').'/public/uploads/images/'.$Most_watched_countries->image;  ?>" class="img-fluid" alt=""> -->
                                        <video width="100%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$Most_watched_countries->image;  ?>"  data-play="hover" >
                                            <source src="<?php echo $Most_watched_countries->trailer;  ?>" type="video/mp4">
                                        </video>
                                    </a>
                                    <div class="corner-text-wrapper">
                                        <div class="corner-text">
                                            <?php  if(!empty($Most_watched_countries->ppv_price)){?>
                                                <p class="p-tag1"><?php echo $currency->symbol.' '.$Most_watched_countries->ppv_price; ?></p>
                                            <?php }elseif( !empty($Most_watched_countries->global_ppv || !empty($Most_watched_countries->global_ppv) && $Most_watched_countries->ppv_price == null)){ ?>
                                                <p class="p-tag1"><?php echo $Most_watched_countries->global_ppv.' '.$currency->symbol; ?></p>
                                            <?php }elseif($Most_watched_countries->global_ppv == null && $Most_watched_countries->ppv_price == null ){ ?>
                                                <p class="p-tag"><?php echo "Free"; ?></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="block-description">
                                    <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $Most_watched_countries->slug ?>">
                                         <h6><?php echo __($Most_watched_countries->title); ?></h6>
                                    </a>
                                    <div class="movie-time d-flex align-items-center my-2">
                                        <div class="badge badge-secondary p-1 mr-2"><?php echo $Most_watched_countries->age_restrict ?></div>
                                        <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $Most_watched_countries->duration); ?></span>
                                    </div>
                                    
                                   <div class="hover-buttons">
                                       <a class="text-white" href="<?php echo URL::to('category') ?><?= '/videos/' . $Most_watched_countries->slug ?>" >
                                             <i class="fa fa-play mr-1" aria-hidden="true"></i> Watch Now
                                      </a>
                                    <div>
                                       <!-- <a href="<?php echo URL::to('category') ?><?= '/wishlist/' . $Most_watched_countries->slug ?>" class="text-white mt-4"><i class="fa fa-plus" aria-hidden="true"></i> Add to Watchlist</a> -->
                                </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
                         <?php endforeach; endif; ?>
        </ul>
    </div>
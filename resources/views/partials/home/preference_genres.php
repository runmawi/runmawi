<div class="iq-main-header d-flex align-items-center justify-content-between">
        <h4 class="main-title"><a href="">Preference By Genres </a></h4>                      
</div>
    <div class="favorites-contens">
        <ul class="favorites-slider list-inline  row p-0 mb-0">
                <?php  if(isset($preference_genres)) :
                    foreach($preference_genres as $preference_genre): 
                ?>

                <li class="slide-item">
                    <a href="<?php echo URL::to('home') ?>">
                        <div class="block-images position-relative">
                                <div class="img-box">
                                    <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $preference_genre->slug ?>">
                                         <img src="<?php echo URL::to('/').'/public/uploads/images/'.$preference_genre->image;  ?>" class="img-fluid" alt=""> -->
                                         <!-- <video width="100%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$preference_genre->image;  ?>"  data-play="hover" >
                                            <source src="<?php echo $preference_genre->trailer;  ?>" type="video/mp4">
                                        </video>-->
                                    </a>
                                    <div class="corner-text-wrapper">
                                        <div class="corner-text">
                                            <?php  if(!empty($preference_genre->ppv_price)){?>
                                                <p class="p-tag1"><?php echo $currency->symbol.' '.$preference_genre->ppv_price; ?></p>
                                            <?php }elseif( !empty($preference_genre->global_ppv || !empty($preference_genre->global_ppv) && $preference_genre->ppv_price == null)){ ?>
                                                <p class="p-tag1"><?php echo $preference_genre->global_ppv.' '.$currency->symbol; ?></p>
                                            <?php }elseif($preference_genre->global_ppv == null && $preference_genre->ppv_price == null ){ ?>
                                                <p class="p-tag"><?php echo "Free"; ?></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="block-description">
                                    <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $preference_genre->slug ?>">
                                         <h6><?php echo __($preference_genre->title); ?></h6>
                                    </a>
                                    <div class="movie-time d-flex align-items-center my-2">
                                        <div class="badge badge-secondary p-1 mr-2"><?php echo $preference_genre->age_restrict ?></div>
                                        <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $preference_genre->duration); ?></span>
                                    </div>
                                    
                                   <div class="hover-buttons">
                                       <a class="text-white" href="<?php echo URL::to('category') ?><?= '/videos/' . $preference_genre->slug ?>" >
                                             <i class="fa fa-play mr-1" aria-hidden="true"></i> Watch Now
                                      </a>
                                    <!-- <div>
                                       <a href="<?php echo URL::to('category') ?><?= '/wishlist/' . $preference_genre->slug ?>" class="text-white mt-4"><i class="fa fa-plus" aria-hidden="true"></i> Add to Watchlist</a>
                                </div> -->
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
                         <?php endforeach; endif; ?>
        </ul>
    </div>
<div class="iq-main-header d-flex align-items-center justify-content-between">
        <h4 class="main-title"><a href="">Preference By language </a></h4>                      
</div>
    <div class="favorites-contens">
        <ul class="favorites-slider list-inline  row p-0 mb-0">
                <?php  if(isset($preference_Language)) :
                    foreach($preference_Language as $preference_Languages): 
                ?>

                <li class="slide-item">
                    <a href="<?php echo URL::to('home') ?>">
                        <div class="block-images position-relative">
                                <div class="img-box">
                                    <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $preference_Languages->slug ?>">
                                         <img src="<?php echo URL::to('/').'/public/uploads/images/'.$preference_Languages->image;  ?>" class="img-fluid" alt=""> -->
                                          <!--<video width="100%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$preference_Languages->image;  ?>"  data-play="hover" >
                                            <source src="<?php echo $preference_Languages->trailer;  ?>" type="video/mp4">
                                        </video>-->
                                    </a>
                                    <div class="corner-text-wrapper">
                                        <div class="corner-text">
                                            <?php  if(!empty($preference_Languages->ppv_price)){?>
                                                <p class="p-tag1"><?php echo $currency->symbol.' '.$preference_Languages->ppv_price; ?></p>
                                            <?php }elseif( !empty($preference_Languages->global_ppv || !empty($preference_Languages->global_ppv) && $preference_Languages->ppv_price == null)){ ?>
                                                <p class="p-tag1"><?php echo $preference_Languages->global_ppv.' '.$currency->symbol; ?></p>
                                            <?php }elseif($preference_Languages->global_ppv == null && $preference_Languages->ppv_price == null ){ ?>
                                                <p class="p-tag"><?php echo "Free"; ?></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="block-description">
                                    <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $preference_Languages->slug ?>">
                                         <h6><?php echo __($preference_Languages->title); ?></h6>
                                    </a>
                                    <div class="movie-time d-flex align-items-center my-2">
                                        <div class="badge badge-secondary p-1 mr-2"><?php echo $preference_Languages->age_restrict ?></div>
                                        <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $preference_Languages->duration); ?></span>
                                    </div>
                                    
                                   <div class="hover-buttons">
                                       <a class="text-white" href="<?php echo URL::to('category') ?><?= '/videos/' . $preference_Languages->slug ?>" >
                                             <i class="fa fa-play mr-1" aria-hidden="true"></i> Watch Now
                                      </a>
                                    <!-- <div>
                                       <a href="<?php echo URL::to('category') ?><?= '/wishlist/' . $preference_Languages->slug ?>" class="text-white mt-4"><i class="fa fa-plus" aria-hidden="true"></i> Add to Watchlist</a>
                                </div> -->
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
                         <?php endforeach; endif; ?>
        </ul>
    </div>
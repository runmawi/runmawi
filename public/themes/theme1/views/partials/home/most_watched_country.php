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
                                    
                                </div>
                        </div>
                                <div class="block-description">
                                   
                                   <div class="hover-buttons">
                                       <a class="text-white btn-cl" href="<?php echo URL::to('category') ?><?= '/videos/' . $Most_watched_countries->slug ?>" >
                                             <img class="ply" src="<?php echo URL::to('/').'/assets/img/play.svg';  ?>">                                        </a>
                                    <div>
                                       <!-- <a href="<?php echo URL::to('category') ?><?= '/wishlist/' . $Most_watched_countries->slug ?>" class="text-white mt-4"><i class="fa fa-plus" aria-hidden="true"></i> Add to Watchlist</a> -->
                                </div>
                                </div>
                            </div>
                        <div class="mt-2">
                             <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $Most_watched_countries->slug ?>">
                                         <h6><?php echo __($Most_watched_countries->title); ?></h6>
                                    </a>
                                    <div class="movie-time d-flex align-items-center my-2">
                                        <div class="badge badge-secondary p-1 mr-2"><?php echo $Most_watched_countries->age_restrict ?></div>
                                        <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $Most_watched_countries->duration); ?></span>
                                    </div>
                                    
                        </div>
                    </a>
                </li>
                         <?php endforeach; endif; ?>
        </ul>
    </div>
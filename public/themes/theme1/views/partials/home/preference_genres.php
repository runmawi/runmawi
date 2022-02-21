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
                                        <!-- <img src="<?php echo URL::to('/').'/public/uploads/images/'.$preference_genre->image;  ?>" class="img-fluid" alt=""> -->
                                        <video width="100%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$preference_genre->image;  ?>"  data-play="hover" >
                                            <source src="<?php echo $preference_genre->trailer;  ?>" type="video/mp4">
                                        </video>
                                    </a>
                                    
                                </div>
                        </div>
                                <div class="block-description">
                                    
                                   <div class="hover-buttons">
                                       <a class="text-white btn-cl" href="<?php echo URL::to('category') ?><?= '/videos/' . $preference_genre->slug ?>" >
                                              <img class="ply" src="<?php echo URL::to('/').'/assets/img/play.svg';  ?>">                                        </a>
                                    <!-- <div>
                                       <a href="<?php echo URL::to('category') ?><?= '/wishlist/' . $preference_genre->slug ?>" class="text-white mt-4"><i class="fa fa-plus" aria-hidden="true"></i> Add to Watchlist</a>
                                </div> -->
                                </div>
                            </div>
                        <div class="mt-2 d-flex justify-content-between">
                                  <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $preference_genre->slug ?>">
                                         <h6><?php  echo (strlen($preference_genre->title) > 19) ? substr($preference_genre->title,0,20).'...' : $preference_genre->title; ?></h6>
                                    </a>
                             <div class="badge badge-secondary p-1 mr-2"><?php echo $preference_genre->age_restrict ?></div></div>
                                    <div class="movie-time d-flex align-items-center my-2">
                                       
                                        <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $preference_genre->duration); ?></span>
                                    </div>
                              
                        
                    </a>
                </li>
                         <?php endforeach; endif; ?>
        </ul>
    </div>
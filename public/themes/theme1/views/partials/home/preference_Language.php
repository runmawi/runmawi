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
                                        <!-- <img src="<?php echo URL::to('/').'/public/uploads/images/'.$preference_Languages->image;  ?>" class="img-fluid" alt=""> -->
                                        <video width="100%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$preference_Languages->mobile_image;  ?>"  data-play="hover" >
                                            <source src="<?php echo $preference_Languages->trailer;  ?>" type="video/mp4">
                                        </video>
                                    </a>
                                   
                                </div>
 </div>
                                <div class="block-description">
                                    
                                   <div class="hover-buttons">
                                       <a class="text-white btn-cl" href="<?php echo URL::to('category') ?><?= '/videos/' . $preference_Languages->slug ?>" >
                                               <img class="ply" src="<?php echo URL::to('/').'/assets/img/play.svg';  ?>">                                        </a>
                                    <!-- <div>
                                       <a href="<?php echo URL::to('category') ?><?= '/wishlist/' . $preference_Languages->slug ?>" class="text-white mt-4"><i class="fa fa-plus" aria-hidden="true"></i> Add to Watchlist</a>
                                </div> -->
                                </div>
                            </div>
                        <div class="mt-2 d-flex justify-content-between">
                               <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $preference_Languages->slug ?>">
                                         <h6><?php  echo (strlen($preference_Languages->title) > 19) ? substr($preference_Languages->title,0,20).'...' : $preference_Languages->title; ?></h6>
                                    </a>
                             <div class="badge badge-secondary p-1 mr-2"><?php echo $preference_Languages->age_restrict ?></div></div>
                                    <div class="movie-time d-flex align-items-center my-2">
                                       
                                        <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $preference_Languages->duration); ?></span>
                                    </div>
                                 
                       
                    </a>
                </li>
                         <?php endforeach; endif; ?>
        </ul>
    </div>
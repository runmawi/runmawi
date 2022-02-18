<div class="iq-main-header d-flex align-items-center justify-content-between">
        <h4 class="main-title"><a href="">Most Watching Videos - User</a></h4>                      
</div>
    <div class="favorites-contens">
        <ul class="favorites-slider list-inline  row p-0 mb-0">
                <?php  if(isset($most_watch_user)) :
                    foreach($most_watch_user as $watchlater_video): 
                ?>

                <li class="slide-item">
                    <a href="<?php echo URL::to('home') ?>">
                        <div class="block-images position-relative">
                                <div class="img-box">
                                    <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>">
                                        <!-- <img src="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>" class="img-fluid" alt=""> -->
                                        <video width="100%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->mobile_image;  ?>"  data-play="hover" >
                                            <source src="<?php echo $watchlater_video->trailer;  ?>" type="video/mp4">
                                        </video>
                                    </a>
                                  
                                </div>
                        </div>
                                <div class="block-description">
                                    
                                   <div class="hover-buttons">
                                       <a class="text-white btn-cl" href="<?php echo URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>" >
                                           <img class="ply" src="<?php echo URL::to('/').'/assets/img/play.svg';  ?>">                                        </a>
                                   
                                </div>
                            </div>
                        <div class="mt-2">
                                  <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>">
                                         <h6><?php echo __($watchlater_video->title); ?></h6>
                                    </a>
                                    <div class="movie-time d-flex align-items-center my-2">
                                        <div class="badge badge-secondary p-1 mr-2"><?php echo $watchlater_video->age_restrict ?></div>
                                        <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $watchlater_video->duration); ?></span>
                                    </div>
                              
                        </div>
                    </a>
                </li>
                         <?php endforeach; endif; ?>
        </ul>
    </div>
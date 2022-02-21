<div class="iq-main-header d-flex align-items-center justify-content-between">
    <h4 class="main-title"><a href=""> Top Most Watching Videos</a></h4>                      
</div>
<div class="favorites-contens">
    <ul class="favorites-slider list-inline  row p-0 mb-0">
            <?php  if(isset($top_most_watched)) :
                foreach($top_most_watched as $most_watched_video): 
            ?>

            <li class="slide-item">
                <a href="<?php echo URL::to('home') ?>">
                    <div class="block-images position-relative">
                            <div class="img-box">
                                <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $most_watched_video->slug ?>">
                                    <!-- <img src="<?php echo URL::to('/').'/public/uploads/images/'.$most_watched_video->image;  ?>" class="img-fluid" alt=""> -->
                                    <video width="100%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$most_watched_video->image;  ?>"  data-play="hover" >
                                        <source src="<?php echo $most_watched_video->trailer;  ?>" type="video/mp4">
                                    </video>
                                </a>
                                
                            </div>
                    </div>
                            
                    <div class="block-description">
                        <div class="hover-buttons">
                            <a class="" href="<?php echo URL::to('category') ?><?= '/videos/' . $most_watched_video->slug ?>" >
                                <img class="ply" src="<?php echo URL::to('/').'/assets/img/play.svg';  ?>">                                        
                            </a>
                        </div>
                    </div>

                    <div class="mt-2 d-flex justify-content-between">
                        <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $most_watched_video->slug ?>">
                             <h6><?php  echo (strlen($most_watched_video->title) > 19) ? substr($most_watched_video->title,0,20).'...' : $most_watched_video->title; ?></h6>
                         </a>
                        <div class="badge badge-secondary p-1 mr-2">
                            <?php echo $most_watched_video->age_restrict ?>
                        </div>
                    </div>

                    <div class="movie-time d-flex align-items-center my-2">
                        <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $most_watched_video->duration); ?></span>
                    </div>
                    
                </a>
            </li>
                     <?php endforeach; endif; ?>
    </ul>
</div>
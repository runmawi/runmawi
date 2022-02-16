<div class="iq-main-header d-flex align-items-center justify-content-between">
    <h4 class="main-title">Reels</h4>                                          
</div>
<div class="favorites-contens">
    <ul class="favorites-slider list-inline  row p-0 mb-0">
            <?php  if(isset($Reels_videos)) :
                foreach($Reels_videos as $reel): 
            ?>
            <li class="slide-item">
                    <div class="block-images position-relative">
                            <div class="img-box">
                                <a  href="<?php echo URL::to('Reals_videos') ?><?= '/videos/' . $reel->slug ?>">
                                    <video width="100%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$reel->image;  ?>"  data-play="hover" >
                                        <source src="<?php echo $reel->trailer;  ?>" type="video/mp4">
                                    </video>
                                </a>
                            </div>
                                
                            <div class="block-description">
                                <a  href="<?php echo URL::to('Reals_videos') ?><?= '/videos/' . $reel->slug ?>">
                                     <h6><?php echo __($reel->title); ?></h6>
                                </a>
                                
                               <div class="hover-buttons">
                                   <a class="text-white" href="<?php echo URL::to('Reals_videos') ?><?= '/videos/' . $reel->slug ?>" >
                                         <i class="fa fa-play mr-1" aria-hidden="true"></i> Watch Now
                                  </a>
                            </div>
                        </div>
                    </div>
                </a>
            </li>
                     <?php endforeach; endif; ?>
    </ul>
</div>
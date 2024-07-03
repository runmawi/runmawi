<section id="">
        <div class="row">

            <div class="favorites-contens sub_dropdown_image ">
                <ul class="series-networks-slider-nav favorites-slider list-inline row mb-0">
                    <?php
                     if(isset($Related_videos)) :
                        foreach($Related_videos as $related_video): ?>

                    <li class="slide-item">
                        <a  href="<?php echo URL::to('live/'.$related_video->slug ) ?>">	
                            <div class="position-relative">
                                    <img src="<?php echo URL::to('/').'/public/uploads/images/'.$related_video->image;  ?>" class="img-fluid w-100" alt="">
                                    <div class="controls">
                                        <a href="<?php echo URL::to('live/'.$related_video->slug ) ?>">
                                            <button class="playBTN"> <i class="fas fa-play"></i></button>
                                        </a>
                                    </div>
                            </div>
                        </a>
                    </li>
                    <?php endforeach; endif; ?>
                </ul>
            </div>
        </div>
    </section>

    

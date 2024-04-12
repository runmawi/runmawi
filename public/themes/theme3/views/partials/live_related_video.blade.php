    <section id="">
        <div class="row">
          <div class="col-sm-12 ">
                <div class="iq-main-header align-items-center justify-content-between">
            </div>

            <div class="favorites-contens">
               <ul class="favorites-slider list-inline  row p-0 mb-0">
                    <?php
                    if(isset($Related_videos)) :
                        foreach($Related_videos as $related_video): ?>
                            <li class="slide-item">
                                <a href="<?php echo URL::to('live/'.$related_video->slug ) ?>">
                                    <div class="block-images position-relative">
                                        <div class="img-box">
                                            <img src="<?php echo URL::to('/').'/public/uploads/images/'.$related_video->image;  ?>" class="img-fluid" alt="">
                                        </div>
                                        <div class="block-description">
                                            <div class="hover-buttons">
                                                <a class="" href="<?php echo URL::to('live/'.$related_video->slug ) ?>">
                                                    <div class="playbtn" style="gap:5px">   
                                                        <span class="text pr-2"> <?= (__('Play')) ?> </span>
                                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="30px" height="80px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                                                            <polygon class="triangle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="73.5,62.5 148.5,105.8 73.5,149.1 " style="stroke: white !important;"></polygon>
                                                            <circle class="circle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" style="stroke: white !important;"></circle>
                                                        </svg>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        <?php endforeach;
                    endif; ?>
               </ul>
            </div>








            <!-- <div class="favorites-contens ">
                <ul class="favorites-slider list-inline row mb-0">
                    <?php
                     if(isset($Related_videos)) :
                        foreach($Related_videos as $related_video): ?>

                    <li class="slide-item">
                        <a  href="<?php echo URL::to('live/'.$related_video->slug ) ?>">	
                            <div class="block-images position-relative">
                                <div class="img-box">
                                    <img src="<?php echo URL::to('/').'/public/uploads/images/'.$related_video->image;  ?>" class="img-fluid w-100" alt="">
                                </div>

                                <div class="block-description">
                                    <h6><?php  echo (strlen($related_video->title) > 15) ? substr($related_video->title,0,15).'...' : $related_video->title; ?></h6>

                                    <div class="movie-time  align-items-center my-2">
                                        <div class="badge badge-secondary p-1 mr-2"><?php echo $related_video->age_restrict.' '.'+' ?></div>
                                        <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $related_video->duration); ?></span>
                                    </div>

                                    <div class="hover-buttons">
                                        <a  href="<?php echo URL::to('live/'.$related_video->slug ) ?>">	
                                            <span class="text-white">
                                                <i class="fa fa-play mr-1" aria-hidden="true"></i> Play Now
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <?php endforeach; endif; ?>
                </ul>
            </div> -->
        </div>
    </section>
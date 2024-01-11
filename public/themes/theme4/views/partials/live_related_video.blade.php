    <section id="">
        <div class="row">
          <div class="col-sm-12 ">
                <div class="iq-main-header align-items-center justify-content-between">
            </div>

            <div class="favorites-contens sub_dropdown_image ">
                <ul class="favorites-slider list-inline row mb-0">
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

                                        <nav>
                                        <button class="moreBTN" tabindex="0" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fas fa-info-circle"></i><span>More info</span></button>
                                        </nav>
                                                                                        
                                        <!-- <p class="trending-dec" >
                                            {{ $related_video->description}}
                                        </p> -->
                                    </div>

                                <!-- <div class="block-description">
                                    <h6><?php  echo (strlen($related_video->title) > 15) ? substr($related_video->title,0,15).'...' : $related_video->title; ?></h6>

                                    <div class="movie-time  align-items-center my-2">
                                        <div class="badge badge-secondary p-1 mr-2"><?php echo $related_video->age_restrict.' '.'+' ?></div>
                                        <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $related_video->duration); ?></span>
                                    </div>

                                    <div class="hover-buttons">
                                        <a  href="<?php echo URL::to('live/'.$related_video->slug ) ?>">	
                                            <span class="text-white">
                                                <i class="fa fa-play mr-1" aria-hidden="true"></i> {{ __('Play Now') }}
                                            </span>
                                        </a>
                                    </div>
                                </div> -->
                            </div>
                        </a>
                    </li>
                    <?php endforeach; endif; ?>
                </ul>
            </div>
        </div>
    </section>
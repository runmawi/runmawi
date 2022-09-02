 <!-- MainContent -->
<section id="iq-favorites">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 overflow-hidden">
                <div class="favorites-contens">
                    <ul class="favorites-slider list-inline row p-0 mb-0">
                        <?php if(isset($Related_videos)) :
                           foreach($Related_videos as $related_video): ?>
                           
                            <li class="slide-item">
                                <a  href="<?php echo URL::to('live/'.$related_video->slug ) ?>">	
                                <div class="block-images position-relative">
                                    <div class="img-box">
                                       <img src="<?php echo URL::to('/').'/public/uploads/images/'.$related_video->image;  ?>" class="img-fluid" alt="">
                                     </div>
                                </div>

                                <div class="block-description">
                                    <div class="hover-buttons">
                                        <a  href="<?php echo URL::to('live/'.$related_video->slug ) ?>">	
                                          <span class="btn btn-hover"><i class="fa fa-play mr-1" aria-hidden="true"></i>Play Now</span>
                                        </a>
                                    </div>
                                <div>

                                <button type="button" class="show-details-button" data-toggle="modal" data-target="#myModal<?= $related_video->id;?>">
                                    <span class="text-center thumbarrow-sec">
                                        <img src="<?php echo URL::to('/').'/assets/img/arrow-red.png';?>" class="thumbarrow thumbarrow-red" alt="right-arrow">
                                    </span>
                                </button>
                                </div>
                                        </div>
                                  <div class="mt-2">
                                      <h6><?php echo __($related_video->title); ?></h6>
                                       <div class="movie-time d-flex align-items-center my-2">
                                          <div class="badge badge-secondary p-1 mr-2">13+</div>
                                          <span class="text-white"><i class="fa fa-clock-o"></i><?= gmdate('H:i:s', $related_video->duration); ?></span>
                                       </div>
                                 </div>
                              </a>
                           </li>
                            <?php endforeach; 
		                          endif; ?>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
</section>

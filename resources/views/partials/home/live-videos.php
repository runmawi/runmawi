<div class="iq-main-header d-flex align-items-center justify-content-between">
                    <h4 class="main-title">Live Videos</h4>                      
                 </div>
                 <div class="favorites-contens">
                    <ul class="favorites-slider list-inline  row p-0 mb-0">
                         <?php  if(isset($livetream)) :
                         foreach($livetream as $video): ?>
                       <li class="slide-item">
                          <a href="<?php echo URL::to('home') ?>">
                             <div class="block-images position-relative">
                                <div class="img-box">
                                <a href="<?= URL::to('/') ?><?= '/live/play/' . $video->id ?>">
                                   <img src="<?php echo URL::to('/').'/public/uploads/images/'.$video->image;  ?>" class="img-fluid img-zoom" alt="">
                                 </a>      
                                 <div class="corner-text-wrapper">
                                        <div class="corner-text">
                                          <?php  if(!empty($video->ppv_price)){?>
                                          <p class="p-tag"><?php echo $video->ppv_price.' '.$currency->symbol; ?></p>
                                          <?php }elseif($video->ppv_price == null ){ ?>
                                            <p class="p-tag"><?php echo "Free"; ?></p>
                                            <?php } ?>
                                        </div>
                                    </div>                 
                                </div>
                                <div class="block-description">
                                <a href="<?= URL::to('/') ?><?= '/live/play/' . $video->id ?>">
                                <i class="ri-play-fill"></i>
                             </a>                       
                                    
                                   <div class="hover-buttons">
                                   <div class="d-flex align-items-center justify-content-between">
                                <a href="<?= URL::to('/') ?><?= '/live/play/' . $video->id ?>">
                          <span class="text-white"><?= ucfirst($video->title); ?></span>
                             </a>                       
                       </div>
                       <a href="<?= URL::to('/') ?><?= '/live/play/' . $video->id ?>">
                          <h6 class="epi-name text-white mb-0"><i class="fa fa-clock-o"></i> Live Now</h6>
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
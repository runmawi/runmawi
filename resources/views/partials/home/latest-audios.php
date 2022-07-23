<div class="iq-main-header d-flex align-items-center justify-content-between">
                    <h4 class="main-title"><a href="<?php echo URL::to('/audios') ?>">Audios</a></h4>                      
                 </div>
                 <div class="favorites-contens">
                    <ul class="favorites-slider list-inline  row p-0 mb-0">
                         <?php  if(isset($audios)) :
                         foreach($audios as $audio): ?>
                       <li class="slide-item">
                          <a href="<?php echo URL::to('home') ?>">
                             <!-- block-images -->
                             <div class="block-images position-relative">
                                <div class="img-box">
                                <img src="<?php echo URL::to('/').'/public/uploads/images/'.$audio->player_image;?>" class="img-fluid img-zoom" alt="">
                                </div>
                                <div class="block-description" style="top:40px !important;">
                                <a href="<?= URL::to('audio') ?><?= '/' . $audio->slug ?>">
                        <i class="ri-play-fill"></i>
                     </a>                     
                                   <div class="hover-buttons">
                                   <a href="<?= URL::to('audio') ?><?= '/' . $audio->slug ?>">
                  <h6 class="epi-name text-white mb-0"><?php echo $audio->title; ?></h6>
               </a>
                <div class="d-flex align-items-center justify-content-between">
                    <span class="text-white"><small><?php echo get_audio_artist($audio->id); ?></small></span>
                    <span class="text-primary"><small><?php echo gmdate('H:i:s', $audio->duration); ?>m</small></span>
               </div>
                                   </div>
                                
                                    </div>
                              
                             </div>
                          </a>
                       </li>

                        <?php endforeach; 
                                   endif; ?>
                    </ul>
                 </div>

      
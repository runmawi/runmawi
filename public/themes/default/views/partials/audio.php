

 <div class="favorites-contens">
                    <ul class="favorites-slider list-inline  row p-0 mb-0 ">
                        <?php if(isset($audios)) :
                        foreach($audios as $audio): ?>
                       <li class="slide-item ">
                         <a href="<?= URL::to('audio') ?><?= '/' . $audio->slug ?>">
                             <div class="block-images position-relative">
                             <!-- block-images -->
                                <div class="img-box">
                                
                                  <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$audio->image;?>" class="img-fliud w-100" alt="">
                                 
                                     
                              
                                       
                                 </div>
                              
                                <div class="block-description">
                                 
                               <a href="<?= URL::to('audio') ?><?= '/' . $audio->slug ?>">
                  <h6 class="epi-name text-white mb-0"><?php echo $audio->title; ?></h6>
               </a>   
                                
                                

                                  <div class="hover-buttons text-white">
                                                            <a class="d-flex align-items-center" href="<?= URL::to('audio') ?><?= '/' . $audio->slug ?>">
                       <img class="ply mr-1" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>" /> Play Now
                     </a>

                                  
                                    </div>
                                </div>
                             </div>
                          </a>
                       </li>
                       <?php                     
                        endforeach; 
                                   endif; ?>
                    </ul>
                 </div>

<?php if(count($latest_audios) > 0) : ?>
<div class="iq-main-header d-flex align-items-center justify-content-between">
                    <!-- <h4 class="main-title"><a href="<?php //echo URL::to('/latest_audios') ?>"> -->
                     <h4 class="main-title"><a href="<?php if ($order_settings_list[5]->header_name) { echo URL::to('/').'/'.$order_settings_list[5]->url ;} else { echo "" ; } ?>">

                    <!-- Audios -->
                    <?php if ($order_settings_list[5]->header_name) { echo __($order_settings_list[5]->header_name) ;} else { echo "" ; } ?>
                  </a></h4>
                  <h4 class="main-title"><a href="<?php if ($order_settings_list[5]->header_name) { echo URL::to('/').'/'.$order_settings_list[5]->url ;} else { echo "" ; } ?>"><?php echo (__('View All')); ?></a></h4>                      
                 </div>
                 <div class="favorites-contens">
                    <ul class="favorites-slider list-inline  row p-0 mb-0">
                         <?php  if(isset($latest_audios)) :
                         foreach($latest_audios as $audio): ?>
                       <li class="slide-item">
                          <div class="block-images position-relative">
                             <!-- block-images -->
                             <div class="border-bg">
                             <div class="img-box">
                                   <a href="<?php echo URL::to('audio') ?><?= '/' . $audio->slug ?>">
                                       <img class="img-fluid w-100" loading="lazy" src="<?php echo URL::to('/').'/public/uploads/images/'.$audio->image;?>"  alt="audio">
                                    </a>  
                              </div>
                              </div>


                                <div class="block-description mt-3" >
                                <!-- <a href="<?php echo URL::to('audio') ?><?= '/' . $audio->slug ?>">
                                <img src="<?php echo URL::to('/').'/public/uploads/images/'.$audio->image;?>" class="img-fluid w-100" alt="audio">
                                    </a> -->

                                <div class="hover-buttons text-white">
                                <a class="epi-name mt-5 mb-0 text-center" href="<?= URL::to('audio') ?><?= '/' . $audio->slug ?>">
                        <i class="ri-play-fill"></i>                    
                                  
                                   <a href="<?= URL::to('audio') ?><?= '/' . $audio->slug ?>">
                                   <p class="epi-name text-left mt-3"><?php echo $audio->title; ?></p>
               </a>
                <div class="d-flex align-items-center justify-content-between">
                    <span class="text-white"><small><?php echo get_audio_artist($audio->id); ?></small></span>
                    <span class="text-primary"><small><?php echo gmdate('H:i:s', $audio->duration); ?>m</small></span>
               </div>
                                   
                                
                                    </div>
                              
                             </div>
                             </div>
                       </li>

                        <?php endforeach; 
                                   endif; 
                                ?>
                    </ul>
                 </div>
                 <?php  endif; ?>
      
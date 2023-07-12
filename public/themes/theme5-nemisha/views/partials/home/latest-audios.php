<?php if(count($audios) > 0) : ?>

      <div class="iq-main-header d-flex align-items-center justify-content-between">

      <?php if( Route::currentRouteName() == "ChannelHome"){?>

         <h4 class="main-title"><a href="<?php echo route('Channel_Audios_list',Request::segment(2)); ?>">
            <?php if ($order_settings_list[5]->header_name) { echo $order_settings_list[5]->header_name ;} else { echo "" ; } ?>
            </a>
         </h4>             
         
         <a class="see" href="<?php echo route('Channel_Audios_list',Request::segment(2)); ?>">See All </a>

      <?php }else{ ?>

         <h4 class="main-title"><a href="<?php if ($order_settings_list[5]->header_name) { echo URL::to('/').'/'.$order_settings_list[5]->url ;} else { echo "" ; } ?>">
            <?php if ($order_settings_list[5]->header_name) { echo $order_settings_list[5]->header_name ;} else { echo "" ; } ?>
            </a>
         </h4>             
         
         <a class="see" href="<?php if ($order_settings_list[5]->header_name) { echo $order_settings_list[5]->header_name ;} else { echo "" ; } ?>">See All </a>

      <?php } ?>

      </div>
                 <div class="favorites-contens">
                    <ul class="favorites-slider list-inline  row p-0 mb-0">
                         <?php  if(isset($audios)) :
                         foreach($audios as $audio): ?>
                       <li class="slide-item">
                          <a href="<?= URL::to('audio') ?><?= '/' . $audio->slug ?>">
                             <!-- block-images -->
                             <div class="block-images position-relative">
                                <div class="img-box">
                                <img src="<?php echo URL::to('/').'/public/uploads/images/'.$audio->image;?>" class="img-fluid img-zoom w-100" alt="">
                                </div> </div>
                                <div class="block-description" > </div>
                                           
                                   <div class="hover-buttons">
                                   <a href="<?= URL::to('audio') ?><?= '/' . $audio->slug ?>">
                  <h6 class="epi-name text-white mb-0"><?php echo $audio->title; ?></h6>
               </a>
               <!-- <div class="d-flex align-items-center justify-content-between">
                    <span class="text-white"><small><?php echo get_audio_artist($audio->id); ?></small></span>
                    <span class="text-primary"><small><?php echo gmdate('H:i:s', $audio->duration); ?>m</small></span>
               </div>-->
                                   </div>
                                
                                   
                              
                            
                          </a>
                       </li>

                        <?php endforeach; 
                                   endif; ?>
                    </ul>
                 </div>

                 <?php       endif; ?>
      
<?php if (count($audios) > 0): ?>
   <div class="iq-main-header d-flex align-items-center justify-content-between">
      <h4 class="main-title"><a
            href="<?php if ($order_settings_list[5]->header_name) {
               echo URL::to('/') . '/' . $order_settings_list[5]->url;
            } else {
               echo "";
            } ?>">

            <!-- Audios -->
            <?php if ($order_settings_list[5]->header_name) {
               echo (__($order_settings_list[5]->header_name));
            } else {
               echo "";
            } ?>
         </a></h4>
   </div>
   <div class="favorites-contens">
      <ul class="favorites-slider list-inline  row p-0 mb-0">
         <?php if (isset($audios)):
            foreach ($audios as $audio): ?>
               <li class="slide-item">
                  <a href="<?php echo URL::to('home') ?>">
                     <!-- block-images -->
                     <div class="block-images position-relative">
                           <div class="img-box">
                              <img src="<?php echo URL::to('/') . '/public/uploads/images/' . $audio->image; ?>" class="img-fluid lazyload w-100"
                                 alt="">
                           </div>
                           <div class="block-description">
                              <div class="hover-buttons text-white">
                                 <a class="" href="<?= URL::to('audio') ?><?= '/' . $audio->slug ?>"> <img class="ply" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>" /> </a>
                              
                              </div>
                           </div>
                              <a href="<?= URL::to('audio') ?><?= '/' . $audio->slug ?>">
                                 <h6 class="epi-name text-white mb-0">
                                    <?php echo $audio->title; ?>
                                 </h6>
                              </a>
                              <div class="d-flex align-items-center justify-content-between">
                                 <span class="text-white"><small>
                                       <?php echo get_audio_artist($audio->id); ?>
                                    </small></span>
                                 <span class="text-primary"><small>
                                       <?php echo gmdate('H:i:s', $audio->duration); ?>m
                                    </small></span>
                              </div>

                     </div>
                  </a>
               </li>

            <?php endforeach;
         endif; ?>
      </ul>
   </div>

<?php endif; ?>
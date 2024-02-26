<?php if (count($latest_audios) > 0): ?>
   <div class="iq-main-header d-flex align-items-center justify-content-between">
      <!-- <h4 class="main-title"><a href="<?php //echo URL::to('/latest_audios')  ?>"> -->
      <h4 class="main-title"><a
            href="<?php if ($order_settings_list[5]->header_name) {
               echo URL::to('/') . '/' . $order_settings_list[5]->url;
            } else {
               echo "";
            } ?>">

            <!-- Audios -->
            <?php if ($order_settings_list[5]->header_name) {
               echo __($order_settings_list[5]->header_name);
            } else {
               echo "";
            } ?>
         </a></h4>
      <h4 class="main-title"><a
            href="<?php if ($order_settings_list[5]->header_name) {
               echo URL::to('/') . '/' . $order_settings_list[5]->url;
            } else {
               echo "";
            } ?>">
            <?php echo (__('View All')); ?>
         </a></h4>
   </div>
   <div class="favorites-contens">
      <ul class="favorites-slider list-inline  row p-0 mb-0">
         <?php if (isset($latest_audios)):
            foreach ($latest_audios as $audio): ?>
               <li class="slide-item">
                  <div class="block-images position-relative">
                     <!-- block-images -->
                     <div class="border-bg">
                        <div class="img-box">
                           <a href="<?php echo URL::to('audio') ?><?= '/' . $audio->slug ?>">
                              <img src="<?php echo URL::to('/') . '/public/uploads/images/' . $audio->image; ?>"
                                 class="img-fluid w-100" alt="audio">
                           </a>
                        </div>
                     </div>


                     
                  </div>
               </li>

            <?php endforeach;
         endif;
         ?>
      </ul>
   </div>
<?php endif; ?>
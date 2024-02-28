<?php if (count($albums) > 0): ?>
   <div class="iq-main-header d-flex align-items-center justify-content-between">
      <h4 class="main-title"><a href="<?php if ($order_settings_list[6]->header_name) {
         echo URL::to('/') . '/' . $order_settings_list[6]->url;
      } else {
         echo "";
      } ?>">
            <?php if ($order_settings_list[6]->header_name) {
               echo __($order_settings_list[6]->header_name);
            } else {
               echo "";
            } ?>
            <!-- Albums -->
         </a></h4>
      <h4 class="main-title"><a href="<?php if ($order_settings_list[6]->header_name) {
         echo URL::to('/') . '/' . $order_settings_list[6]->url;
      } else {
         echo "";
      } ?>">
            <?php echo (__('View All')); ?>
         </a></h4>
   </div>
   <div class="favorites-contens">
      <ul class="favorites-slider list-inline  row p-0 mb-0">
         <?php if (isset($albums)):
            foreach ($albums as $album): ?>
               <li class="slide-item">
                  <div class="block-images position-relative">
                     <!-- block-images -->
                     <div class="border-bg">
                        <div class="img-box">
                           <a class="playTrailer" href="<?php echo URL::to('album') ?><?= '/' . $album->slug ?>">
                              <img src="<?php echo URL::to('/') . '/public/uploads/albums/' . $album->album; ?>"
                                 class="img-fluid w-100" alt="album">
                           </a>
                        </div>
                     </div>

                     
               </li>

            <?php endforeach;
         endif; ?>
      </ul>
   </div>
<?php endif; ?>
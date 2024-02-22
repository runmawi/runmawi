<?php
if (count($VideoSchedules) > 0): ?>
   <?php if (!Auth::guest() && !empty($data['password_hash'])) {
      $id = Auth::user()->id;
   } else {
      $id = 0;
   } ?>
   <div class="iq-main-header d-flex align-items-center justify-content-between">
      <h4 class="main-title"><a
            href="<?php if ($order_settings_list[10]->header_name) {
               echo URL::to('/') . '/' . $order_settings_list[10]->url;
            } else {
               echo "";
            } ?>">
            <?php if ($order_settings_list[10]->header_name) {
               echo __($order_settings_list[10]->header_name);
            } else {
               echo "";
            } ?>
         </a></h4>
   </div>
   <div class="favorites-contens">
      <ul class="favorites-slider list-inline  row p-0 mb-0">
         <?php if (isset($VideoSchedules)):
            foreach ($VideoSchedules as $Schedule):
               ?>
               <li class="slide-item">
                  <div class="block-images position-relative">
                     <!-- block-images -->
                     <div class="border-bg">
                        <div class="img-box">
                           <a class="playTrailer"
                              href="<?php echo URL::to("/schedule/videos/embed") ?><?= '/' . $Schedule->slug ?>">
                              <img loading="lazy" data-src="<?php echo $Schedule->image; ?>" class="img-fluid loading w-100"
                                 alt=""></a>
                           </a>
                        </div>
                     </div>


                     
                  </div>
               </li>
            <?php
            endforeach;
         endif; ?>
      </ul>
   </div>
<?php endif; ?>
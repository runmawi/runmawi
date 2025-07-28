<?php if (count($audios) > 0): ?>
   <div class="iq-main-header d-flex align-items-center justify-content-between">
      <h4 class="main-title"><a href="<?php if ($order_settings_list[5]->header_name) {
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
                  <a href="<?= URL::to('audio') ?><?= '/' . $audio->slug ?>">
                     <div class="block-images position-relative">
                        <!-- block-images -->
                        <div class="img-box">
                           <img loading="lazy"
                              data-src="<?php echo URL::to('/') . '/public/uploads/images/' . $audio->image; ?>"
                              class="img-fluid lazyload w-100" alt="">
                        </div>
                        <div class="block-description">
                           <div class="hover-buttons text-white">
                              <a class="" href="<?= URL::to('audio') ?><?= '/' . $audio->slug ?>"> <img
                                    class="ply" src="<?php echo URL::to('/') . '/assets/img/default_play_buttons.svg'; ?>" /> </a>

                           </div>
                        </div>


                     </div>




                     <div class="mt-2 d-flex justify-content-between p-0">
                        <?php if ($ThumbnailSetting->title == 1) { ?>
                           <h6>
                              <?php echo (mb_strlen($audio->title) > 17) ? mb_substr($audio->title, 0, 18) . '...' : $audio->title; ?>
                           </h6>
                        <?php } ?>

                        <?php if ($ThumbnailSetting->age == 1) { ?>
                           <div class="badge badge-secondary">
                              <?php echo $audio->age_restrict . ' ' . '+' ?>
                           </div>
                        <?php } ?>
                     </div>
                     <div class="movie-time my-2">


                        <!-- Duration -->

                        <?php if ($ThumbnailSetting->duration == 1) { ?>
                           <span class="text-white">
                              <i class="fa fa-clock-o"></i>
                              <?= gmdate('H:i:s', $audio->duration); ?>
                           </span>
                        <?php } ?>

                        <!-- Rating -->

                        <?php if ($ThumbnailSetting->rating == 1 && $audio->rating != null) { ?>
                           <span class="text-white">
                              <i class="fa fa-star-half-o" aria-hidden="true"></i>
                              <?php echo __($audio->rating); ?>
                           </span>
                        <?php } ?>

                        <?php if ($ThumbnailSetting->featured == 1 && $audio->featured == 1) { ?>
                           <!-- Featured -->
                           <span class="text-white">
                              <i class="fa fa-flag" aria-hidden="true"></i>
                           </span>
                        <?php } ?>
                     </div>

                     <div class="movie-time my-2">
                        <!-- published_year -->

                        <?php if (($ThumbnailSetting->published_year == 1) && ($audio->year != null)) { ?>
                           <span class="text-white">
                              <i class="fa fa-calendar" aria-hidden="true"></i>
                              <?php echo __($audio->year); ?>
                           </span>
                        <?php } ?>
                     </div>

                     <div class="movie-time my-2">
                        <!-- Category Thumbnail  setting -->
                        <?php
                        $CategoryThumbnail_setting = App\CategoryVideo::join('video_categories', 'video_categories.id', '=', 'categoryvideos.category_id')
                           ->where('categoryvideos.video_id', $audio->id)
                           ->pluck('video_categories.name');
                        ?>
                        <?php if (($ThumbnailSetting->category == 1) && (count($CategoryThumbnail_setting) > 0)) { ?>
                           <span class="text-white">
                              <i class="fa fa-list-alt" aria-hidden="true"></i>
                              <?php
                              $Category_Thumbnail = array();
                              foreach ($CategoryThumbnail_setting as $key => $CategoryThumbnail) {
                                 $Category_Thumbnail[] = $CategoryThumbnail;
                                 echo (__($CategoryThumbnail) . ' ');
                              }
                              // echo implode(','.' ', $Category_Thumbnail);
                              ?>
                           </span>
                        <?php } ?>
                     </div>
                  </a>
               </li>


               

            <?php endforeach;
         endif; ?>
      </ul>
   </div>

<?php endif; ?>
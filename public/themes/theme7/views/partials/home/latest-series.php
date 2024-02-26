<?php
if (isset($latest_series)):
  $order_settings = App\OrderHomeSetting::orderBy('order_id', 'asc')->get();
  $order_settings_list = App\OrderHomeSetting::get();
  $ThumbnailSetting = App\ThumbnailSetting::first();

  ?>
  <div class="iq-main-header d-flex align-items-center justify-content-between">
    <h4 class="main-title">
      <!-- Recently Added Series -->
      <a
        href="<?php if ($order_settings_list[4]->header_name) {
          echo URL::to('/') . '/' . $order_settings_list[4]->url;
        } else {
          echo "";
        } ?>">
        <!-- <a href="<?php //echo URL::to('/Series-list' )  ?>"> -->
        <?php if ($order_settings_list[4]->header_name) {
          echo __($order_settings_list[4]->header_name);
        } else {
          echo "";
        }
        ?>
      </a>
    </h4>
    <h4 class="main-title"><a
        href="<?php if ($order_settings_list[4]->header_name) {
          echo URL::to('/') . '/' . $order_settings_list[4]->url;
        } else {
          echo "";
        } ?>">
        <?php echo (__('View All')); ?>
      </a> </h4>

  </div>
  <div class="favorites-contens">
    <ul class="favorites-slider list-inline  row p-0 mb-0">
      <?php if (isset($latest_series)):
        foreach ($latest_series as $latest_serie): ?>
          <li class="slide-item">
            <div class="block-images position-relative">

              <!-- block-images -->
              <div class="border-bg">
                <div class="img-box">
                  <a class="playTrailer" href="<?php echo URL::to('/play_series' . '/' . $latest_serie->slug) ?>">
                    <img data-src="<?php echo URL::to('/') . '/public/uploads/images/' . $latest_serie->image; ?>"
                      class="img-fluid lazyload w-100" alt="series">
                  </a>

                  <?php if ($ThumbnailSetting->free_or_cost_label == 1) { ?>
                    <?php if ($latest_serie->access == 'subscriber') { ?>
                      <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                    <?php } elseif ($latest_serie->access == 'registered') { ?>
                      <p class="p-tag">
                        <?php echo (__('Register Now')); ?>
                      </p>
                    <?php } elseif (!empty($latest_serie->ppv_status)) { ?>
                      <p class="p-tag1">
                        <?php echo $currency->symbol . ' ' . $settings->ppv_price; ?>
                      </p>
                    <?php } elseif (!empty($latest_serie->ppv_status || !empty($latest_serie->ppv_status) && $latest_serie->ppv_status == null)) { ?>
                      <p class="p-tag1">
                        <?php echo $currency->symbol . ' ' . $settings->ppv_status; ?>
                      </p>
                    <?php } elseif ($latest_serie->ppv_status == null && $latest_serie->ppv_price == null) { ?>
                      <p class="p-tag">
                        <?php echo (__('Free')); ?>
                      </p>
                    <?php } ?>
                  <?php } ?>

                </div>
              </div>

              
            </div>
          </li>
        <?php endforeach;
      endif; ?>
    </ul>
  </div>
<?php endif; ?>
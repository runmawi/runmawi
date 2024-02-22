<?php
if (isset($latest_series)):
  $order_settings = App\OrderHomeSetting::orderBy('order_id', 'asc')->get();
  $order_settings_list = App\OrderHomeSetting::get();
  $channels = App\Channel::get();
  $settings = App\Setting::first();
  ?>
  <div class="iq-main-header d-flex align-items-center justify-content-between">
    <h4 class="main-title">
      <!-- Recently Added Series -->
      <a
        href="<?php if ($order_settings_list[13]->header_name) {
          echo URL::to('/') . '/' . $order_settings_list[13]->url;
        } else {
          echo "";
        } ?>">
        <!-- <a href="<?php //echo URL::to('/Series-list' )  ?>"> -->
        <?php if ($order_settings_list[13]->header_name) {
          echo __($order_settings_list[13]->header_name);
        } else {
          echo "";
        }
        ?>
      </a>
    </h4>
    <h4 class="main-title"><a
        href="<?php if ($order_settings_list[13]->header_name) {
          echo URL::to('/') . '/' . $order_settings_list[13]->url;
        } else {
          echo "";
        } ?>">
        <?php echo (__('View All')); ?>
      </a></h4>
  </div>
  <div class="favorites-contens">
    <ul class="favorites-slider list-inline  row p-0 mb-0">
      <?php if (isset($channels)):
        foreach ($channels as $channel): ?>
          <li class="slide-item">
            <div class="block-images position-relative">
              <!-- block-images -->
              <div class="border-bg">
                <div class="img-box">
                  <a class="playTrailer" href="<?php echo URL::to('/channel' . '/' . $channel->channel_slug) ?>">
                    <img
                      src="<?php if ($channel->channel_image == 'default_image.jpg') {
                        echo URL::to('/') . '/public/uploads/images/' . $settings->default_video_image;
                      } else {
                        echo $channel->channel_image;
                      } ?>"
                      class="img-fluid w-100" alt="channel">
                  </a>
                </div>
              </div>

              
            </div>
          </li>
        <?php endforeach;
      endif; ?>
    </ul>
  </div>
<?php endif; ?>
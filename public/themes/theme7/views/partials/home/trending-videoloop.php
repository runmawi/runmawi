<div class="iq-main-header d-flex align-items-center justify-content-between">
  <h4 class="main-title">
    <a
      href="<?php if ($order_settings_list[0]->header_name) {
        echo URL::to('/') . '/' . $order_settings_list[0]->url;
      } else {
        echo "";
      } ?>">
      <?php if ($order_settings_list[0]->header_name) {
        echo __($order_settings_list[0]->header_name);
      } else {
        echo "";
      } ?>
      <!-- Featured Movies -->
    </a>
  </h4>
  <h4 class="main-title"><a
      href="<?php if ($order_settings_list[0]->header_name) {
        echo URL::to('/') . '/' . $order_settings_list[0]->url;
      } else {
        echo "";
      } ?>">
      <?php echo (__('View All')); ?>
    </a></h4>
</div>
<div class="favorites-contens">
  <ul class="favorites-slider list-inline  row p-0 mb-0">
    <?php if (isset($featured_videos)):
      if (!Auth::guest() && !empty($data['password_hash'])) {
        $id = Auth::user()->id;
      } else {
        $id = 0;
      }
      foreach ($featured_videos as $watchlater_video):

        if (!empty($watchlater_video->publish_time) && !empty($watchlater_video->publish_time)) {
          $currentdate = date("M d , y H:i:s");
          date_default_timezone_set('Asia/Kolkata');
          $current_date = Date("M d , y H:i:s");
          $date = date_create($current_date);
          $currentdate = date_format($date, "D h:i");
          $publish_time = date("D h:i", strtotime($watchlater_video->publish_time));
          if ($watchlater_video->publish_type == 'publish_later') {
            if ($currentdate < $publish_time) {
              $publish_time = date("D h:i", strtotime($watchlater_video->publish_time));
            } else {
              $publish_time = 'Published';
            }
          } elseif ($watchlater_video->publish_type == 'publish_now') {
            $currentdate = date_format($date, "y M D");

            $publish_time = date("y M D", strtotime($watchlater_video->publish_time));

            if ($currentdate == $publish_time) {
              $publish_time = 'Today' . ' ' . date("h:i", strtotime($watchlater_video->publish_time));
            } else {
              $publish_time = 'Published';
            }
          } else {
            $publish_time = '';
          }
        } else {
          $publish_time = '';
        }

        ?>
        <li class="slide-item">
          <div class="block-images position-relative">

            <!-- block-images -->
            <div class="border-bg">
              <div class="img-box">
                <a class="playTrailer" href="<?php echo URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>"
                  aria-label="Trending">
                  <img alt="f-img" loading="lazy"
                    data-src="<?php echo URL::to('/') . '/public/uploads/images/' . $watchlater_video->image; ?>"
                    class="img-fluid loading w-100" alt="">
                </a>


                <!-- PPV price -->

                <!-- <p class="p-tag" style=""><?php //echo $watchlater_video->ppv_price ;  ?></p> -->
                <?php if ($ThumbnailSetting->free_or_cost_label == 1) { ?>
                  <?php if ($watchlater_video->access == 'subscriber') { ?>
                    <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                  <?php } elseif (!empty($watchlater_video->ppv_price)) { ?>
                    <p class="p-tag1">
                      <?php echo $currency->symbol . ' ' . $watchlater_video->ppv_price; ?>
                    </p>
                  <?php } elseif (!empty($watchlater_video->global_ppv || !empty($watchlater_video->global_ppv) && $watchlater_video->ppv_price == null)) { ?>
                    <p class="p-tag1">
                      <?php echo $watchlater_video->global_ppv . ' ' . $currency->symbol; ?>
                    </p>
                  <?php } elseif ($watchlater_video->global_ppv == null && $watchlater_video->ppv_price == null) { ?>
                    <p class="p-tag">
                      <?php echo (__('Free')); ?>
                    </p>
                  <?php } ?>
                <?php } ?>

                <!-- <?php if ($ThumbnailSetting->published_on == 1) { ?>                                            
                                        <p class="published_on1"><?php echo $publish_time; ?></p>
                                    <?php } ?> -->
              </div>
            </div>

            
          </div>
        </li>
      <?php
      endforeach;
    endif; ?>
  </ul>
</div>

<script>
  $('.mywishlist').click(function () {
    var video_id = $(this).data('videoid');
    if ($(this).data('authenticated')) {
      $(this).toggleClass('active');
      if ($(this).hasClass('active')) {
        $.ajax({
          url: "<?php echo URL::to('/mywishlist'); ?>",
          type: "POST",
          data: { video_id: $(this).data('videoid'), _token: '<?= csrf_token(); ?>' },
          dataType: "html",
          success: function (data) {
            if (data == "Added To Wishlist") {

              $('#' + video_id).text('');
              $('#' + video_id).text('Remove From Wishlist');
              $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Media added to wishlist</div>');
              setTimeout(function () {
                $('.add_watch').slideUp('fast');
              }, 3000);
            } else {

              $('#' + video_id).text('');
              $('#' + video_id).text('Add To Wishlist');
              $("body").append('<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white;">Media removed from wishlist</div>');
              setTimeout(function () {
                $('.remove_watch').slideUp('fast');
              }, 3000);
            }
          }
        });
      }
    } else {
      window.location = '<?= URL::to('login') ?>';
    }
  });

</script>
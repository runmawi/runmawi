<?php if (count($livetream) > 0): ?>
  <div class="iq-main-header d-flex align-items-center justify-content-between">
    <h4 class="main-title">
      <!-- Live Videos -->
      <a
        href="<?php if ($order_settings_list[3]->header_name) {
          echo URL::to('/') . '/' . $order_settings_list[3]->url;
        } else {
          echo "";
        } ?>">
        <?php if ($order_settings_list[3]->header_name) {
          echo __($order_settings_list[3]->header_name);
        } else {
          echo "";
        } ?>
      </a>
    </h4>
    <h4 class="main-title"><a
        href="<?php if ($order_settings_list[3]->header_name) {
          echo URL::to('/') . '/' . $order_settings_list[3]->url;
        } else {
          echo "";
        } ?>">
        <?php echo (__('View All')); ?>
      </a></h4>
  </div>
  <div class="favorites-contens">
    <ul class="favorites-slider list-inline row p-0 mb-0">
      <?php if (isset($livetream)):
        foreach ($livetream as $video):
          if (!empty($video->publish_time)) {
            $currentdate = date("M d , y H:i:s");
            date_default_timezone_set('Asia/Kolkata');
            $current_date = Date("M d , y H:i:s");
            $date = date_create($current_date);
            $currentdate = date_format($date, "D h:i");
            $publish_time = date("D h:i", strtotime($video->publish_time));
            if ($video->publish_type == 'publish_later') {
              if ($currentdate < $publish_time) {
                $publish_time = date("D h:i", strtotime($video->publish_time));
                $publish_time = \Carbon\Carbon::create($video->created_at, 'Asia/Kolkata')->format('h:i');
                $publish_day = \Carbon\Carbon::create($video->created_at, 'Asia/Kolkata')->format('l');

              } else {
                $publish_time = 'Published';
                $publish_day = '';
              }
            } elseif ($video->publish_type == 'publish_now') {
              $currentdate = date_format($date, "y M D");

              $publish_time = date("y M D", strtotime($video->created_at));

              if ($currentdate == $publish_time) {
                $publish_time = date("D h:i", strtotime($video->created_at));
                $publish_time = \Carbon\Carbon::create($video->created_at, 'Asia/Kolkata')->format('h:i');
                $publish_day = \Carbon\Carbon::create($video->created_at, 'Asia/Kolkata')->format('l');

              } else {
                $publish_time = 'Published';
                $publish_day = '';

              }
            } else {
              $publish_time = 'Published';
              $publish_day = '';

            }
          } else {
            date_default_timezone_set('Asia/Kolkata');
            $current_date = Date("M d , y H:i:s");
            $date = date_create($current_date);
            $currentdate = date_format($date, "y M D");

            $publish_time = date("y M D", strtotime($video->created_at));

            if ($currentdate == $publish_time) {
              $publish_time = date("D h:i", strtotime($video->created_at));
              $publish_day = \Carbon\Carbon::create($video->created_at, 'Asia/Kolkata')->format('l');

              $publish_time = \Carbon\Carbon::create($video->created_at, 'Asia/Kolkata')->format('h:i');

            } else {
              $publish_time = 'Published';
              $publish_day = '';

            }
          }
          ?>
          <!-- .@$video->categories->name. -->
          <li class="slide-item">
            <div class="block-images position-relative">
              <!-- block-images -->
              <div class="border-bg">
                <div class="img-box">
                  <a class="playTrailer" href="<?= URL::to('/') ?><?= '/live' . '/' . $video->slug ?>">
                    <img src="<?php echo URL::to('/') . '/public/uploads/images/' . $video->image; ?>" class="img-fluid w-100"
                      alt="live" />
                  </a>

                  <!-- PPV price -->

                  <?php if ($ThumbnailSetting->free_or_cost_label == 1) { ?>

                    <?php if ($video->access == 'subscriber') { ?>
                      <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                    <?php } elseif ($video->access == 'registered') { ?>
                      <p class="p-tag">
                        <?php echo (__('Register Now')); ?>
                      </p>
                    <?php } elseif (!empty($video->ppv_price)) { ?>
                      <p class="p-tag1">
                        <?php echo $currency->symbol . ' ' . $video->ppv_price; ?>
                      </p>
                    <?php } elseif ($video->ppv_price == null) { ?>
                      <p class="p-tag">
                        <?php echo (__('Free')); ?>
                      </p>
                    <?php } ?>
                  <?php } ?>

                  <!-- <?php if ($ThumbnailSetting->published_on == 1) { ?>      
                          <p class="published_on1"><?php echo $publish_day; ?> <span><?php echo $publish_time; ?></span></p>
                        <?php } ?> -->
                </div>
              </div>

              
            </div>
          </li>

        <?php endforeach;
      endif; ?>
    </ul>
  </div>
<?php endif; ?>


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
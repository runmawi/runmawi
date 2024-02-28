<?php

// latest viewed Livestream

if (Auth::guest() != true) {

    $latest_view_livestream = App\RecentView::join('live_streams', 'live_streams.id', '=', 'recent_views.live_id')
        ->where('recent_views.user_id', Auth::user()->id)
        ->groupBy('recent_views.live_id')
        ->get();
} else {
    $latest_view_livestream = array();
}

if (count($latest_view_livestream) > 0):
    ?>

    <div class="iq-main-header d-flex align-items-center justify-content-between">
        <h4 class="main-title">
            <a href="<?php if ($order_settings_list[16]->header_name) {
                echo URL::to('/') . '/' . $order_settings_list[16]->url;
            } else {
                echo '';
            } ?>">

                <?php if ($order_settings_list[16]->header_name) {
                    echo __($order_settings_list[16]->header_name);
                } else {
                    echo '';
                } ?>
            </a>
        </h4>
        <h4 class="main-title"><a href="<?php if ($order_settings_list[16]->header_name) {
            echo URL::to('/') . '/' . $order_settings_list[16]->url;
        } else {
            echo '';
        } ?>">
                <?php echo (__('View All')); ?>
            </a></h4>
    </div>

    <div class="favorites-contens">
        <ul class="favorites-slider list-inline  row p-0 mb-0">
            <?php

            if (isset($latest_view_livestream)):

                foreach ($latest_view_livestream as $key => $latest_view_livestreams):

                    if (!empty($latest_view_livestreams->publish_time) && !empty($latest_view_livestreams->publish_time)) {
                        $currentdate = date("M d , y H:i:s");
                        date_default_timezone_set('Asia/Kolkata');
                        $current_date = Date("M d , y H:i:s");
                        $date = date_create($current_date);
                        $currentdate = date_format($date, "D h:i");
                        $publish_time = date("D h:i", strtotime($latest_view_livestreams->publish_time));

                        if ($latest_view_livestreams->publish_type == 'publish_later') {
                            if ($currentdate < $publish_time) {
                                $publish_time = date("D h:i", strtotime($latest_view_livestreams->publish_time));
                            } else {
                                $publish_time = 'Published';
                            }
                        } elseif ($latest_view_livestreams->publish_type == 'publish_now') {
                            $currentdate = date_format($date, "y M D");

                            $publish_time = date("y M D", strtotime($latest_view_livestreams->publish_time));

                            if ($currentdate == $publish_time) {
                                $publish_time = date("D h:i", strtotime($latest_view_livestreams->publish_time));
                            } else {
                                $publish_time = 'Published';
                            }
                        } else {
                            $publish_time = 'Published';

                        }
                    } else {

                        date_default_timezone_set('Asia/Kolkata');
                        $current_date = Date("M d , y H:i:s");
                        $date = date_create($current_date);
                        $currentdate = date_format($date, "y M D");

                        $publish_time = date("y M D", strtotime($latest_view_livestreams->publish_time));

                        if ($currentdate == $publish_time) {
                            $publish_time = date("D h:i", strtotime($latest_view_livestreams->publish_time));
                        } else {
                            $publish_time = 'Published';
                        }

                    }
                    ?>

                    <li class="slide-item">
                        <div class="block-images position-relative">
                            <!-- block-images -->
                            <div class="border-bg">
                                <div class="img-box">
                                    <a class="playTrailer" href="<?= URL::to('live/' . $latest_view_livestreams->slug); ?>">
                                        <img loading="lazy"
                                            data-src="<?php echo URL::to('/') . '/public/uploads/images/' . $latest_view_livestreams->image; ?>"
                                            class="img-fluid loading w-100" alt="l-img">
                                    </a>

                                    <?php if ($ThumbnailSetting->free_or_cost_label == 1) { ?>
                                        <?php if ($latest_view_livestreams->access == 'subscriber') { ?>
                                            <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                                        <?php } elseif ($latest_view_livestreams->access == 'registered') { ?>
                                            <p class="p-tag">
                                                <?php echo (__('Register Now')); ?>
                                            </p>
                                        <?php } elseif (!empty($latest_view_livestreams->ppv_price)) { ?>
                                            <p class="p-tag1">
                                                <?php echo $currency->symbol . ' ' . $latest_view_livestreams->ppv_price; ?>
                                            </p>
                                        <?php } elseif (!empty($latest_view_livestreams->global_ppv || !empty($latest_view_livestreams->global_ppv) && $latest_view_livestreams->ppv_price == null)) { ?>
                                            <p class="p-tag1">
                                                <?php echo $latest_view_livestreams->global_ppv . ' ' . $currency->symbol; ?>
                                            </p>
                                        <?php } elseif ($latest_view_livestreams->global_ppv == null && $latest_view_livestreams->ppv_price == null) { ?>
                                            <p class="p-tag">
                                                <?php echo 'Free'; ?>
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
                <?php endforeach;
            endif; ?>
        </ul>
    </div>
<?php endif; ?>
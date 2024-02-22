<?php

// latest viewed Videos

if (Auth::guest() != true) {

    $latest_view_audios = App\RecentView::join('audio', 'audio.id', '=', 'recent_views.audio_id')
        ->where('recent_views.user_id', Auth::user()->id)
        ->groupBy('recent_views.audio_id');

    if (Geofencing() != null && Geofencing()->geofencing == 'ON') {
        $latest_view_audios = $latest_view_audios->whereNotIn('audio.id', Block_audios());
    }
    $latest_view_audios = $latest_view_audios->get();
} else {
    $latest_view_audios = array();
}

if (count($latest_view_audios) > 0):
    ?>

    <div class="iq-main-header d-flex align-items-center justify-content-between">
        <h4 class="main-title">
            <a href="<?php if ($order_settings_list[17]->header_name) {
                echo URL::to('/') . '/' . $order_settings_list[17]->url;
            } else {
                echo '';
            } ?>">

                <?php if ($order_settings_list[17]->header_name) {
                    echo __($order_settings_list[17]->header_name);
                } else {
                    echo '';
                } ?>
            </a>
        </h4>
        <h4 class="main-title"><a href="<?php if ($order_settings_list[17]->header_name) {
            echo URL::to('/') . '/' . $order_settings_list[17]->url;
        } else {
            echo '';
        } ?>">
                <?php echo (__('View All')); ?>
            </a></h4>
    </div>

    <div class="favorites-contens">
        <ul class="favorites-slider list-inline  row p-0 mb-0">
            <?php

            if (isset($latest_view_audios)):

                foreach ($latest_view_audios as $key => $latest_view_audio): ?>

                    <li class="slide-item">
                        <div class="block-images position-relative">
                            <!-- block-images -->
                            <div class="border-bg">
                                <div class="img-box">
                                    <a class="playTrailer" href="<?= URL::to('audio/' . $latest_view_audio->slug); ?>">
                                        <img loading="lazy"
                                            data-src="<?php echo URL::to('/') . '/public/uploads/images/' . $latest_view_audio->image; ?>"
                                            class="img-fluid loading w-100" alt="l-img">
                                    </a>

                                    <?php if ($ThumbnailSetting->free_or_cost_label == 1) { ?>

                                    <?php } ?>

                                    <!-- <?php if ($ThumbnailSetting->published_on == 1) { ?>
                                        <p class="published_on1"><?= "Published"; ?></p>
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
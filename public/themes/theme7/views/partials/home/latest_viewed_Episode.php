<?php

// latest viewed Videos

if (Auth::guest() != true) {
    $latest_view_episodes = App\RecentView::Select('episodes.*', 'episodes.slug as episode_slug', 'series.id', 'series.slug as series_slug', 'recent_views.episode_id', 'recent_views.user_id')
        ->join('episodes', 'episodes.id', '=', 'recent_views.episode_id')
        ->join('series', 'series.id', '=', 'episodes.series_id')
        ->where('recent_views.user_id', Auth::user()->id)
        ->groupBy('recent_views.episode_id')
        ->get();
} else {
    $latest_view_episodes = [];
}

?>

<div class="iq-main-header d-flex align-items-center justify-content-between">
    <h4 class="main-title">
        <a href="<?php if ($order_settings_list[18]->header_name) {
            echo URL::to('/') . '/' . $order_settings_list[18]->url;
        } else {
            echo '';
        } ?>">

            <?php if ($order_settings_list[18]->header_name) {
                echo __($order_settings_list[18]->header_name);
            } else {
                echo '';
            } ?>
        </a>
    </h4>
    <h4 class="main-title"><a href="<?php if ($order_settings_list[18]->header_name) {
        echo URL::to('/') . '/' . $order_settings_list[18]->url;
    } else {
        echo '';
    } ?>">
            <?php echo (__('View All')); ?>
        </a></h4>
</div>

<div class="favorites-contens">
    <ul class="favorites-slider list-inline  row p-0 mb-0">
        <?php

        if (isset($latest_view_episodes)):

            foreach ($latest_view_episodes as $key => $latest_view_episode): ?>


                <li class="slide-item">
                    <div class="block-images position-relative">
                        <!-- block-images -->
                        <div class="border-bg">
                            <div class="img-box">
                                <a class="playTrailer"
                                    href="<?= URL::to('/episode' . '/' . $latest_view_episode->series_slug . '/' . $latest_view_episode->episode_slug); ?>">
                                    <img loading="lazy"
                                        data-src="<?php echo URL::to('/') . '/public/uploads/images/' . $latest_view_episode->image; ?>"
                                        class="img-fluid loading w-100" alt="l-img">
                                </a>

                                <?php if ($ThumbnailSetting->free_or_cost_label == 1) { ?>
                                <?php } ?>
                            </div>
                        </div>

                        
                    </div>
                </li>
            <?php endforeach;
        endif; ?>
    </ul>
</div>
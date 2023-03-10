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
                echo $order_settings_list[18]->header_name;
            } else {
                echo '';
            } ?>
        </a>
    </h4>
</div>


<div class="favorites-contens">
    <ul class="favorites-slider list-inline  row p-0 mb-0">
        <?php  if(isset($latest_view_episodes)) :
    					 foreach($latest_view_episodes as $key => $latest_view_episodes) {
?>
        <li class="slide-item">
            <a class="text-white "
                href="<?= URL::to('/episode' . '/' . $latest_view_episodes->series_slug . '/' . $latest_view_episodes->episode_slug) ?> ">
                <!-- block-images -->
                <div class="block-images position-relative">
                    <div class="img-box">
                        <img src="<?php echo URL::to('/') . '/public/uploads/images/' . $latest_view_episodes->image; ?>" class="img-fluid w-100" alt="">
                    </div>
                </div>
                <div class="block-description">
                    <div class="hover-buttons d-flex">
                        <a class="text-white "
                            href="<?= URL::to('/episode' . '/' . $latest_view_episodes->series_slug . '/' . $latest_view_episodes->episode_slug) ?> ">
                            <img class="ply" src="<?php echo URL::to('/') . '/assets/img/play.svg'; ?>">
                        </a>
                    </div>
                </div>
                <div>
                    <div class="movie-time d-flex align-items-center justify-content-between my-2">
                        <a class="text-white "
                            href="<?= URL::to('/episode' . '/' . $latest_view_episodes->series_slug . '/' . $latest_view_episodes->episode_slug) ?> ">
                            <h6><?php echo __($latest_view_episodes->title); ?></h6>
                        </a>
                        <div class="badge badge-secondary p-1 mr-2"><?php echo $latest_view_episodes->age_restrict . ' ' . '+'; ?></div>
                    </div>
                    <span class="text-white"><i class="fa fa-clock-o"></i>
                        <?= gmdate('H:i:s', $latest_view_episodes->duration) ?></span>
                </div>
            </a>
        </li>
        <?php  } 
      // }
    endif; ?>
    </ul>
</div>

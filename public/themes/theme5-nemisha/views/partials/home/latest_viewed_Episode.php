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
    <h5 class="main-title">
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
    </h5>
</div>

<div class="favorites-contens"> 
    <div class="latest-viewed-episode home-sec list-inline row p-0 mb-0">
        <?php  if(isset($latest_view_episodes)) :
                foreach($latest_view_episodes as $key => $latest_view_episode):  ?>

        <div class="items">
            <a href="<?= URL::to('/episode' . '/' . $latest_view_episode->series_slug . '/' . $latest_view_episode->episode_slug); ?>">
                <div class="block-images position-relative">

                    <!-- block-images -->
                    <div class="img-box">
                        <img src="<?php echo URL::to('/') . '/public/uploads/images/' . $latest_view_episode->image; ?>" class="img-fluid lazyload w-100"
                            alt="<?php echo $latest_view_episode->title; ?>">
                    </div>
                </div>

                <div class="block-description">
                    <div class="hover-buttons text-white">
                        <a class="" href="<?= URL::to('/episode' . '/' . $latest_view_episode->series_slug . '/' . $latest_view_episode->episode_slug) ?>"> <img
                                class="ply" src="<?php echo URL::to('/') . '/assets/img/default_play_buttons.svg'; ?>" /> </a>
                        <div></div>
                    </div>
                </div>

                <div class="mt-2 d-flex justify-content-between p-0">
                    <?php if($ThumbnailSetting->title == 1) { ?>
                        <h6><?php echo strlen($latest_view_episode->title) > 17 ? substr($latest_view_episode->title, 0, 18) . '...' : $latest_view_episode->title; ?></h6>
                    <?php } ?>

                    <?php if($ThumbnailSetting->age == 1) { ?>
                        <div class="badge badge-secondary"><?php echo $latest_view_episode->age_restrict . ' ' . '+'; ?></div>
                    <?php } ?>
                </div>

                <div class="movie-time my-2">

                    <!-- Duration -->
                    <?php if($ThumbnailSetting->duration == 1) { ?>
                        <span class="text-white">
                            <i class="fa fa-clock-o"></i>
                            <?= gmdate('H:i:s', $latest_view_episode->duration) ?>
                        </span>
                    <?php } ?>

                    <!-- Rating -->

                    <?php if($ThumbnailSetting->rating == 1 && $latest_view_episode->rating != null) { ?>
                        <span class="text-white">
                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                            <?php echo __($latest_view_episode->rating); ?>
                        </span>
                    <?php } ?>

                    <?php if($ThumbnailSetting->featured == 1 && $latest_view_episode->featured == 1) { ?>
                    <!-- Featured -->
                        <span class="text-white">
                            <i class="fa fa-flag" aria-hidden="true"></i>
                        </span>
                    <?php }?>
                </div>
            </a>
        </div>
        <?php                     
            endforeach; 
            endif; 
        ?>
    </div>
</div>

<script>
    var elem = document.querySelector('.latest-viewed-episode');
    var flkty = new Flickity(elem, {
        cellAlign: 'left',
        contain: true,
        groupCells: true,
        pageDots: false,
        draggable: true,
        freeScroll: true,
        imagesLoaded: true,
        lazyload:true,
    });
</script>
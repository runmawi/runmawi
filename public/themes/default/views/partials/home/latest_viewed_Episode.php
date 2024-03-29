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
        } ?>"><?php echo (__('View All')); ?></a></h4>
</div>

<div class="favorites-contens">
    <ul class="favorites-slider list-inline  row p-0 mb-0">
        <?php  
        
        if(isset($latest_view_episodes)) :

            foreach($latest_view_episodes as $key => $latest_view_episode):  ?>
                
                
                <li class="slide-item">
                    <div class="block-images position-relative">
                        <!-- block-images -->
                        <div class="border-bg">
                            <div class="img-box">
                                <a class="playTrailer" href="<?= URL::to('/episode' . '/' . $latest_view_episode->series_slug . '/' . $latest_view_episode->episode_slug); ?>">
                                    <img class="img-fluid w-100" loading="lazy" data-src="<?php echo URL::to('/') . '/public/uploads/images/' . $latest_view_episode->image; ?>"  alt="l-img">
                                </a>

                                    <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?> 
                                    <?php } ?>
                            </div>
                            </div>
                            
                            <div class="block-description">
                                <a class="playTrailer" href="<?= URL::to('/episode' . '/' . $latest_view_episode->series_slug . '/' . $latest_view_episode->episode_slug); ?>">
                                    <img class="img-fluid w-100" loading="lazy" data-src="<?php echo URL::to('/') . '/public/uploads/images/' . $latest_view_episode->player_image; ?>" alt="l-img">
                                        
                                        <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?> 
                                            <?php } ?>
                                </a>
                                <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?> 
                                            <?php } ?>
                                            

                              <div class="hover-buttons text-white">
                              <a href="<?= URL::to('/episode' . '/' . $latest_view_episode->series_slug . '/' . $latest_view_episode->episode_slug); ?>">
                                    <?php if($ThumbnailSetting->title == 1) { ?>  
                                             <!-- Title -->
                                             <p class="epi-name text-left m-0"><?php echo strlen($latest_view_episode->title) > 17 ? substr($latest_view_episode->title, 0, 18) . '...' : $latest_view_episode->title; ?></p>
                                    <?php } ?>

                                    <div class="movie-time d-flex align-items-center pt-1">
                                        <?php if($ThumbnailSetting->age == 1) { ?>      <!-- Age -->
                                            <div class="badge badge-secondary p-1 mr-2"><?php echo $latest_view_episode->age_restrict . ' ' . '+'; ?></div>
                                        <?php } ?>

                                        <?php if($ThumbnailSetting->duration == 1) { ?>   <!-- Duration -->
                                            <span class="text-white">
                                                <i class="fa fa-clock-o"></i>
                                                <?= gmdate('H:i:s', $latest_view_episode->duration) ?>
                                            </span>
                                        <?php } ?>
                                    </div>

                                    <?php if(($ThumbnailSetting->published_year == 1) || ($ThumbnailSetting->rating == 1)) {?>
                                        <div class="movie-time d-flex align-items-center pt-1">
                                            <?php if($ThumbnailSetting->rating == 1) { ?>   <!--Rating  -->
                                                <div class="badge badge-secondary p-1 mr-2">
                                                    <span class="text-white">
                                                        <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                        <?php echo __($latest_view_episode->rating); ?>
                                                    </span>
                                                </div>
                                            <?php } ?>

                                            <?php if($ThumbnailSetting->featured == 1 && $latest_view_episode->featured == 1) { ?>  <!-- Featured -->
                                                <div class="badge badge-secondary p-1 mr-2">
                                                    <span class="text-white">
                                                        <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                    </span>
                                                </div>
                                            <?php }?>
                                        </div>
                                    <?php } ?>
                                 </a>

                                  
                                        <a class="epi-name mt-3 mb-0 btn"
                                            href="<?= URL::to('/episode' . '/' . $latest_view_episode->series_slug . '/' . $latest_view_episode->episode_slug); ?>">
                                            <img class="d-inline-block ply" alt="ply" src="<?php echo URL::to('/') . '/assets/img/default_play_buttons.svg'; ?>" width="10%"
                                                height="10%" /> Watch Now
                                        </a>
                                        </div>
            </div>
         </div>
                </li>
            <?php endforeach; 
        endif; ?>
    </ul>
</div>

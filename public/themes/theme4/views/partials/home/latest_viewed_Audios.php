<?php

   // latest viewed Videos

   if(Auth::guest() != true ){

        $latest_view_audios =  App\RecentView::join('audio', 'audio.id', '=', 'recent_views.audio_id')
            ->where('recent_views.user_id',Auth::user()->id)
            ->groupBy('recent_views.audio_id');

            if(Geofencing() !=null && Geofencing()->geofencing == 'ON'){
                $latest_view_audios = $latest_view_audios  ->whereNotIn('audio.id',Block_audios());
            }
            $latest_view_audios = $latest_view_audios->get();
   }
   else
   {
        $latest_view_audios = array() ;
   }

    if(count($latest_view_audios) > 0) : 
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
            } ?></a>
    </h4>
</div>

<div class="favorites-contens">
    <ul class="favorites-slider list-inline  row p-0 mb-0">
        <?php  
        
        if(isset($latest_view_audios)) :

            foreach($latest_view_audios as $key => $latest_view_audio): ?>
                
                <li class="slide-item">
                    <div class="block-images position-relative">
                        <!-- block-images -->
                        <div class="border-bg">
                            <div class="img-box">
                                <a class="playTrailer" href="<?= URL::to('audio/'. $latest_view_audio->slug ); ?>">
                                    <img loading="lazy" data-src="<?php echo URL::to('/') . '/public/uploads/images/' . $latest_view_audio->image; ?>" class="img-fluid loading w-100"
                                        alt="l-img">
                                </a>

                                    <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>
                                       
                                    <?php } ?>

                                    <?php if($ThumbnailSetting->published_on == 1) { ?>
                                        <p class="published_on1"><?= "Published"; ?></p>
                                    <?php  } ?>
                               
                            </div>
                            </div>
                            
                            <div class="block-description">
                            <a class="playTrailer" href="<?= URL::to('audio/'. $latest_view_audio->slug ); ?>">
                                    <img loading="lazy" data-src="<?php echo URL::to('/') . '/public/uploads/images/' . $latest_view_audio->player_image; ?>" class="img-fluid loading w-100"
                                        alt="l-img">
                                

                                    <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>
                                       
                                    <?php } ?>
                            </a>
                            <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>
                                       
                                       <?php } ?>
                        <div class="hover-buttons text-white">
                                <a href="<?= URL::to('audio/'. $latest_view_audio->slug ); ?>">
                                    <?php if($ThumbnailSetting->title == 1) { ?>
                                               <!-- Title -->
                                    <p class="epi-name text-left m-0">
                                                <?php echo strlen($latest_view_audio->title) > 17 ? substr($latest_view_audio->title, 0, 18) . '...' : $latest_view_audio->title; ?></p>
                                    <?php } ?>

                                    <div class="movie-time d-flex align-items-center pt-1">
                                        <?php if($ThumbnailSetting->age == 1) { ?>      <!-- Age -->
                                            <div class="badge badge-secondary p-1 mr-2"><?php echo $latest_view_audio->age_restrict . ' ' . '+'; ?></div>
                                        <?php } ?>

                                        <?php if($ThumbnailSetting->duration == 1) { ?>   <!-- Duration -->
                                            <span class="text-white">
                                                <i class="fa fa-clock-o"></i>
                                                <?= gmdate('H:i:s', $latest_view_audio->duration) ?>
                                            </span>
                                        <?php } ?>
                                    </div>

                                    <?php if(($ThumbnailSetting->published_year == 1) || ($ThumbnailSetting->rating == 1)) {?>
                                        <div class="movie-time d-flex align-items-center pt-1">
                                            <?php if($ThumbnailSetting->rating == 1) { ?>   <!--Rating  -->
                                                <div class="badge badge-secondary p-1 mr-2">
                                                    <span class="text-white">
                                                        <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                        <?php echo __($latest_view_audio->rating); ?>
                                                    </span>
                                                </div>
                                            <?php } ?>

                                            <?php if($ThumbnailSetting->published_year == 1) { ?>   <!-- published_year -->
                                                <div class="badge badge-secondary p-1 mr-2">
                                                    <span class="text-white">
                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                        <?php echo __($latest_view_audio->year); ?>
                                                    </span>
                                                </div>
                                            <?php } ?>

                                            <?php if($ThumbnailSetting->featured == 1 && $latest_view_audio->featured == 1) { ?>  <!-- Featured -->
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
                                            href="<?= URL::to('audio/'. $latest_view_audio->slug ); ?>">
                                            <img class="d-inline-block ply" alt="ply" src="<?php echo URL::to('/') . '/assets/img/default_play_buttons.svg'; ?>" width="10%"
                                                height="10%" /> Play Now
                                        </a>
                                        </div>  
                                        </div>
                                        </div>
                </li>
            <?php endforeach; 
        endif; ?>
    </ul>
</div>

<?php  endif; ?>

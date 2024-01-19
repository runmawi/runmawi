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
                echo (__($order_settings_list[17]->header_name));
            } else {
                echo '';
            } ?></a>
    </h4>
</div>


<div class="favorites-contens">
    <ul class="favorites-slider list-inline row p-0 mb-0">
        <?php  if(isset($latest_view_audios)) :
        
            foreach($latest_view_audios as $key =>  $latest_view_audio): ?>

                <li class="slide-item">
                    <a href="<?php echo URL::to('category/videos/'.$latest_view_audio->slug ); ?>">

                        <div class="block-images position-relative">
                            <div class="img-box">
                                <a href="<?php echo URL::to('category/videos/'.$latest_view_audio->slug ); ?>">
                                    <img loading="lazy" data-src="<?php echo URL::to('/') . '/public/uploads/images/' . $latest_view_audio->image; ?>" class="img-fluid w-100" alt="">
                                </a>

                                <?php if($ThumbnailSetting->published_on == 1) { ?>
                                    <p class="published_on1"><?= "Published"; ?></p>
                                <?php  } ?>
                            </div>
                        </div>

                        <div class="block-description">
                            <div class="hover-buttons">
                                <a class="" href="<?php echo URL::to('audio/' .$latest_view_audio->slug); ?>"> 

                                <img class="ply" src="<?php echo URL::to('/') . '/assets/img/default_play_buttons.svg'; ?>" /> </a>
                            
                                <div class="hover-buttons d-flex"> </div>
                            </div>
                        </div>

                        <div class="p-0">
                            <div class="mt-2 d-flex justify-content-between p-0">
                                <?php if($ThumbnailSetting->title == 1) { ?>
                                    <h6><?php echo strlen($latest_view_audio->title) > 17 ? substr($latest_view_audio->title, 0, 18) . '...' : $latest_view_audio->title; ?></h6>
                                <?php } ?>
                            </div>

                            <div class="movie-time my-2">
                                <!-- Duration -->

                                <?php if($ThumbnailSetting->duration == 1) { ?>
                                    <span class="text-white">
                                        <i class="fa fa-clock-o"></i>
                                            <?= gmdate('H:i:s', $latest_view_audio->duration) ?>
                                    </span>
                                <?php } ?>

                                <!-- Rating -->

                                <?php if($ThumbnailSetting->rating == 1 && $latest_view_audio->rating != null) { ?>
                                    <span class="text-white">
                                        <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                        <?php echo __($latest_view_audio->rating); ?>
                                    </span>
                                <?php } ?>

                                <?php if($ThumbnailSetting->featured == 1 && $latest_view_audio->featured == 1) { ?>
                                <!-- Featured -->
                                    <span class="text-white">
                                        <i class="fa fa-flag" aria-hidden="true"></i>
                                    </span>
                                <?php }?>
                            </div>

                            <div class="movie-time my-2">
                                <!-- published_year -->
                                <?php  if ( ($ThumbnailSetting->published_year == 1) && ( $latest_view_audio->year != null ) ) { ?>
                                    <span class="text-white">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                        <?php echo __($latest_view_audio->year); ?>
                                    </span>
                                <?php } ?>
                            </div>
                    </a>
                </li>
            <?php                     
                endforeach; 
                    endif; ?>
    </ul>
</div>

<?php  endif; ?>
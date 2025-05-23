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
    <h5 class="main-title">
        <a href="<?php if ($order_settings_list[17]->header_name) {
            echo URL::to('/') . '/' . $order_settings_list[17]->url;
        } else {
            echo '';
        } ?>">

            <?php if ($order_settings_list[17]->header_name) {
                echo $order_settings_list[17]->header_name;
            } else {
                echo '';
            } ?></a>
    </h5>
    <a class="see" href="<?php echo !empty($order_settings_list[17]->header_name) ? URL::to('/') . '/' . $order_settings_list[17]->url : ""; ?>"> See All </a>
</div>

<div class="favorites-contens"> 
  <div class="latest-viewed-audio home-sec list-inline row p-0 mb-0">
        <?php  if(isset($latest_view_audios)) :
                foreach($latest_view_audios as $key => $latest_view_audio):  ?>

        <div class="items">
            <a href="<?= URL::to('audio/' . $latest_view_audio->slug); ?>">
                <div class="block-images position-relative">

                    <!-- block-images -->
                    <div class="img-box">
                        <img src="<?php echo URL::to('/') . '/public/uploads/images/' . $latest_view_audio->image; ?>" class="img-fluid lazyload w-100 h-50 "
                            alt="<?php echo $latest_view_audio->title; ?>">
                    </div>
                </div>

                <div class="block-description">
                    <div class="hover-buttons text-white">
                        <a href="<?= URL::to('audio/' . $latest_view_audio->slug); ?>">
                            <img class="ply" src="<?php echo URL::to('/') . '/assets/img/default_play_buttons.svg'; ?>" alt="play"/> 
                        </a>
                        <div></div>
                    </div>
                </div>

                <div class="mt-2 d-flex justify-content-between p-0">
                    <?php if($ThumbnailSetting->title == 1) { ?>
                        <h5 style="font-size:1.0em; font-weight:500;"><?php echo strlen($latest_view_audio->title) > 17 ? substr($latest_view_audio->title, 0, 18) . '...' : $latest_view_audio->title; ?></h5>
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

                    <?php  if ( ($ThumbnailSetting->published_year == 1) &&  ( $latest_view_audio->year != null ) ) { ?>
                    <span class="text-white">
                        <i class="fa fa-calendar" aria-hidden="true"></i>
                            <?php echo __($latest_view_audio->year); ?>
                    </span>
                    <?php } ?>
                </div>
            </a>
        </div>
        <?php                     
            endforeach; 
            endif; 
        ?>
    </div>
</div>

<?php  endif; ?>

<script>
    var elem = document.querySelector('.latest-viewed-audio');
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
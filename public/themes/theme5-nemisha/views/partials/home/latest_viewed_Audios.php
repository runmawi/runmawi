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
                echo $order_settings_list[17]->header_name;
            } else {
                echo '';
            } ?></a>
    </h4>
</div>

<div class="favorites-contens">
    <ul class="favorites-slider list-inline  row p-0 mb-0">
        <?php  if(isset($latest_view_audios)) :
                foreach($latest_view_audios as $key => $latest_view_audio): ?>
        <li class="slide-item">
            <a href="<?php echo URL::to('home'); ?>">

                <!-- block-images -->
                <div class="block-images position-relative">
                    <div class="img-box">
                        <img src="<?php echo URL::to('/') . '/public/uploads/images/' . $latest_view_audio->image; ?>" class="img-fluid img-zoom w-100" alt="">
                    </div>
                    <div class="block-description" style="top:40px !important;">
                        <a href="<?= URL::to('audio/' . $latest_view_audio->slug) ?>">
                            <i class="ri-play-fill"></i>
                        </a>
                        <div class="hover-buttons">
                            <a href="<?= URL::to('audio/' . $latest_view_audio->slug) ?>">
                                <h6 class="epi-name text-white mb-0"><?php echo $latest_view_audio->title; ?></h6>
                            </a>
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="text-white"><small><?php echo get_audio_artist($latest_view_audio->id); ?></small></span>
                                <span class="text-primary"><small><?php echo gmdate('H:i:s', $latest_view_audio->duration); ?>m</small></span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </li>
        <?php endforeach; endif; ?>
    </ul>
</div>

<?php  endif; ?>

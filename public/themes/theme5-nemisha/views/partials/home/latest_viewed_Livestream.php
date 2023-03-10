<?php

   // latest viewed Livestream

   if(Auth::guest() != true ){

    $latest_view_livestream =  App\RecentView::join('live_streams', 'live_streams.id', '=', 'recent_views.live_id')
        ->where('recent_views.user_id',Auth::user()->id)
        ->groupBy('recent_views.live_id')
        ->get();
   }
   else
   {
        $latest_view_livestream = array() ;
   }

    if(count($latest_view_livestream) > 0) :  
?>

<div class="iq-main-header d-flex align-items-center justify-content-between">
    <h4 class="main-title">
        <a href="<?php if ($order_settings_list[16]->header_name) {
            echo URL::to('/') . '/' . $order_settings_list[16]->url;
        } else {
            echo '';
        } ?>">

            <?php if ($order_settings_list[16]->header_name) {
                echo $order_settings_list[16]->header_name;
            } else {
                echo '';
            } ?></a>
    </h4>
</div>

<div class="favorites-contens">
    <ul class="favorites-slider list-inline row p-0 mb-0">
        <?php  if(isset($latest_view_livestream)) :
                foreach($latest_view_livestream as $key => $latest_view_livestream): ?>

        <li class="slide-item">
            <a href="<?= URL::to('live/' . $latest_view_livestream->slug) ?>">

                <div class="block-images position-relative">
                    <div class="img-box">
                        <a href="<?= URL::to('live/' . $latest_view_livestream->slug) ?>">
                            <img loading="lazy" data-src="<?php echo URL::to('/') . '/public/uploads/images/' . $latest_view_livestream->image; ?>" class="img-fluid w-100" alt="" />
                        </a>

                        <!-- PPV price -->
                        <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>
                            <?php  if(!empty($latest_view_livestream->ppv_price)){?>
                                <p class="p-tag1"><?php echo $currency->symbol . ' ' . $latest_view_livestream->ppv_price; ?></p>
                            <?php }elseif($latest_view_livestream->ppv_price == null ){ ?>
                                <p class="p-tag"><?php echo 'Free'; ?></p>
                            <?php } ?>
                    </div>
                    <?php } ?>

                    <?php if($ThumbnailSetting->published_on == 1) { ?>
                        <p class="published_on1"><?php echo $publish_day; ?> <span><?php echo $publish_time; ?></span></p>
                    <?php  } ?>
                </div>

                <div class="block-description">
                    <div class="hover-buttons">
                        <a class="text-white d-flex justify-content-center align-items-center"
                            href="<?= URL::to('live/' . $latest_view_livestream->slug) ?>">
                                <img class="ply mr-2" style="width: 13%; height: 13%;" src="<?php echo URL::to('/') . '/assets/img/default_play_buttons.svg'; ?>" />
                        </a>
                    </div>
                </div>

                <div class="">
                    <div class="movie-time my-2">
                        <!-- Duration -->
                        <?php if($ThumbnailSetting->duration == 1) { ?>
                            <span class="text-white">
                                <i class="fa fa-clock-o"></i>
                                <?= gmdate('H:i:s', $latest_view_livestream->duration) ?>
                            </span>
                        <?php } ?>

                        <!-- Rating -->
                        <?php if($ThumbnailSetting->rating == 1 && $latest_view_livestream->rating != null) { ?>
                            <span class="text-white">
                                <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                <?php echo __($latest_view_livestream->rating); ?>
                            </span>
                        <?php } ?>

                        <?php if($ThumbnailSetting->featured == 1 && $latest_view_livestream->featured == 1) { ?>
                        <!-- Featured -->
                            <span class="text-white">
                                <i class="fa fa-flag" aria-hidden="true"></i>
                            </span>
                        <?php }?>
                    </div>

                    <div class="movie-time my-2">
                        <!-- published_year -->
                        <?php  if ( ($ThumbnailSetting->published_year == 1) && ( $latest_view_livestream->year != null ) ) { ?>
                            <span class="text-white">
                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                <?php echo __($latest_view_livestream->year); ?>
                            </span>
                        <?php } ?>
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-between">
                    <?php if($ThumbnailSetting->title == 1) { ?>
                    <a href="<?= URL::to('live/' . $latest_view_livestream->slug) ?>">
                        <span
                            class="text-white"><?= strlen($latest_view_livestream->title) > 17 ? substr($latest_view_livestream->title, 0, 18) . '...' : $latest_view_livestream->title ?>
                        </span>
                    </a>
                    <?php } ?>
                </div>
            </a>
        </li>

        <?php endforeach; endif; ?>
    </ul>
</div>
<?php endif; ?>
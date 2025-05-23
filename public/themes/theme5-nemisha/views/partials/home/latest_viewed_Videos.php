<?php

   // latest viewed Videos

   if(Auth::guest() != true ){

            $latest_view_videos = App\RecentView::join('videos', 'videos.id', '=', 'recent_views.video_id')
            ->where('recent_views.user_id',Auth::user()->id)
            ->where('videos.status', 1)
            ->where('videos.draft', 1) 
            ->where('videos.active', 1) 
            ->groupBy('recent_views.video_id')
            ->orderBy('recent_views.created_at', 'desc'); 

            if (Geofencing() != null && Geofencing()->geofencing == 'ON') {
                $latest_view_videos = $latest_view_videos->whereNotIn('videos.id', Block_videos());
            }

            $latest_view_videos = $latest_view_videos->get();
   }
   else
   {
        $latest_view_videos = array() ;
   }

    if(count($latest_view_videos) > 0) :  
?>


<div class="iq-main-header d-flex align-items-center justify-content-between">
    <h5 class="main-title">
        <a href="<?php if ($order_settings_list[15]->header_name) {
            echo URL::to('/') . '/' . $order_settings_list[15]->url;
        } else {
            echo '';
        } ?>">

            <?php if ($order_settings_list[15]->header_name) {
                echo $order_settings_list[15]->header_name;
            } else {
                echo '';
            } ?></a>
    </h5>
    <a class="see" href="<?php echo !empty($order_settings_list[15]->header_name) ? URL::to('/') . '/' . $order_settings_list[15]->url : ""; ?>"> See All </a>
</div>

<div class="favorites-contens"> 
    <div class="latest-viewed-video home-sec list-inline row p-0 mb-0">
        <?php  if(isset($latest_view_videos)) :
                foreach($latest_view_videos as $key => $latest_view_video):  ?>

        <div class="items">
            <a href="<?php echo URL::to('category/videos' . $latest_view_video->slug); ?>">
                <div class="block-images position-relative">

                    <!-- block-images -->
                    <div class="img-box">
                        <img src="<?php echo URL::to('/') . '/public/uploads/images/' . $latest_view_video->image; ?>" class="img-fluid w-100 h-50"
                            alt="<?php echo $latest_view_video->title; ?>">

                        <!-- PPV price -->
                        <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>
                        <?php  if(!empty($latest_view_video->ppv_price)){?>
                        <p class="p-tag1"><?php echo $currency->symbol . ' ' . $latest_view_video->ppv_price; ?></p>
                        <?php }elseif( !empty($latest_view_video->global_ppv || !empty($latest_view_video->global_ppv) && $latest_view_video->ppv_price == null)){ ?>
                        <p class="p-tag1"><?php echo $latest_view_video->global_ppv . ' ' . $currency->symbol; ?></p>
                        <?php }elseif($latest_view_video->global_ppv == null && $latest_view_video->ppv_price == null ){ ?>
                        <p class="p-tag"><?php echo 'Free'; ?></p>
                        <?php } ?>
                        <?php } ?>
                    </div>
                </div>

                <div class="block-description">
                    <div class="hover-buttons text-white">
                        <a class="" href="<?php echo URL::to('category'); ?><?= '/videos/' . $latest_view_video->slug ?>"> 
                            <img class="ply" src="<?php echo URL::to('/') . '/assets/img/default_play_buttons.svg'; ?>" alt="play" /> </a>
                        <div></div>
                    </div>
                </div>

                <div class="mt-2 d-flex justify-content-between p-0">
                    <?php if($ThumbnailSetting->title == 1) { ?>
                    <h5 style="font-size:1.0em; font-weight:500;"><?php echo strlen($latest_view_video->title) > 17 ? substr($latest_view_video->title, 0, 18) . '...' : $latest_view_video->title; ?></h5>
                    <?php } ?>

                    <?php if($ThumbnailSetting->age == 1) { ?>
                    <div class="badge badge-secondary"><?php echo $latest_view_video->age_restrict . ' ' . '+'; ?></div>
                    <?php } ?>
                </div>

                <div class="movie-time my-2">

                    <!-- Duration -->
                    <?php if($ThumbnailSetting->duration == 1) { ?>
                    <span class="text-white">
                        <i class="fa fa-clock-o"></i>
                        <?= gmdate('H:i:s', $latest_view_video->duration) ?>
                    </span>
                    <?php } ?>

                    <!-- Rating -->

                    <?php if($ThumbnailSetting->rating == 1 && $latest_view_video->rating != null) { ?>
                    <span class="text-white">
                        <i class="fa fa-star-half-o" aria-hidden="true"></i>
                        <?php echo __($latest_view_video->rating); ?>
                    </span>
                    <?php } ?>

                    <?php if($ThumbnailSetting->featured == 1 && $latest_view_video->featured == 1) { ?>
                    <!-- Featured -->
                    <span class="text-white">
                        <i class="fa fa-flag" aria-hidden="true"></i>
                    </span>
                    <?php }?>
                </div>

                <div class="movie-time my-2">
                    <!-- published_year -->

                    <?php  if ( ($ThumbnailSetting->published_year == 1) &&  ( $latest_view_video->year != null ) ) { ?>
                    <span class="text-white">
                        <i class="fa fa-calendar" aria-hidden="true"></i>
                        <?php echo __($latest_view_video->year); ?>
                    </span>
                    <?php } ?>
                </div>

                <div class="movie-time my-2">
                    <!-- Category Thumbnail  setting -->
                    <?php
                    $CategoryThumbnail_setting = App\CategoryVideo::join('video_categories', 'video_categories.id', '=', 'categoryvideos.category_id')
                        ->where('categoryvideos.video_id', $latest_view_video->id)
                        ->pluck('video_categories.name');
                    ?>
                    <?php  if ( ($ThumbnailSetting->category == 1 ) &&  ( count($CategoryThumbnail_setting) > 0 ) ) { ?>
                    <span class="text-white">
                        <i class="fa fa-list-alt" aria-hidden="true"></i>
                        <?php
                        $Category_Thumbnail = [];
                        foreach ($CategoryThumbnail_setting as $key => $CategoryThumbnail) {
                            $Category_Thumbnail[] = $CategoryThumbnail;
                        }
                        echo implode(',' . ' ', $Category_Thumbnail);
                        ?>
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
<?php endif; ?>

<script>
    var elem = document.querySelector('.latest-viewed-video');
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
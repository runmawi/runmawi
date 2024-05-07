<?php   
if( count($latest_video) > 0 || count($latest_episode) > 0 ) : ?>

    <div class="iq-main-header d-flex align-items-center justify-content-between">
        <h2 class="main-title">
            <a href="<?php echo $order_settings_list[38]->url ? URL::to('/') . '/' . $order_settings_list[38]->url : ''; ?>">
                <?php echo $order_settings_list[38]->header_name ? __($order_settings_list[38]->header_name) : ''; ?>
            </a>
        </h2>
        <?php if( $settings->homepage_views_all_button_status == 1 ):?>
        <h2 class="main-title">
            <a href="<?php echo $order_settings_list[38]->url ? URL::to('/') . '/' . $order_settings_list[38]->url : ''; ?>">
                <?php echo __('View All'); ?>
            </a>
        </h2>
        <?php endif; ?>
    </div>

    <div class="favorites-contens">
        <ul class="favorites-slider list-inline  row p-0 mb-0">

            {{-- Latest Videos --}}
            <?php  if(isset($latest_video)) :
                foreach($latest_video->slice(0, 8) as $key => $latest_videos_data): 

                    if (!empty($latest_videos_data->publish_time) && !empty($latest_videos_data->publish_time)){

                        $currentdate = date("M d , y H:i:s");
                        date_default_timezone_set('Asia/Kolkata');
                        $current_date = Date("M d , y H:i:s");
                        $date = date_create($current_date);
                        $currentdate = date_format($date, "D h:i");
                        $publish_time = date("D h:i", strtotime($latest_videos_data->publish_time));

                        if ($latest_videos_data->publish_type == 'publish_later'){

                            $publish_time = $currentdate < $publish_time ? date("D h:i", strtotime($latest_videos_data->publish_time)) : 'Published'; 
                        }
                        elseif ($latest_videos_data->publish_type == 'publish_now')
                        {
                            $currentdate = date_format($date, "y M D");

                            $publish_time = date("y M D", strtotime($latest_videos_data->publish_time));

                            if ($currentdate == $publish_time)
                            {
                                $publish_time = date("D h:i", strtotime($latest_videos_data->publish_time));
                            }else{
                                $publish_time = 'Published';
                            }
                            }else{
                            $publish_time = 'Published';
                            }
                    }else{

                            date_default_timezone_set('Asia/Kolkata');
                            $current_date = Date("M d , y H:i:s");
                            $date = date_create($current_date);
                            $currentdate = date_format($date, "y M D");

                            $publish_time = date("y M D", strtotime($latest_videos_data->publish_time));

                                if ($currentdate == $publish_time)
                                {
                                $publish_time = date("D h:i", strtotime($latest_videos_data->publish_time));
                                }else{
                                $publish_time = 'Published';
                                }
                    }
                    ?>

                    <li class="slide-item">
                        <div class="block-images position-relative">
                        
                            <div class="border-bg">
                                <div class="img-box">

                                    <a class="playTrailer" href="<?php echo URL::to('category'); ?><?= '/videos/' . $latest_videos_data->slug ?>">
                                        <?php $imageUrl = $latest_videos_data->image ? URL::to('/') . '/public/uploads/images/' . $latest_videos_data->image : $settings->default_video_image; ?>
                                        <img class="img-fluid w-100" loading="lazy" data-src="<?php echo $imageUrl; ?>"
                                            class="img-fluid w-100" alt="l-img">
                                    </a>

                                    <!-- PPV price -->

                                    <?php if ($ThumbnailSetting->free_or_cost_label == 1): ?>
                                        <?php if ($latest_videos_data->access == 'subscriber'): ?>
                                            <p class="p-tag"><i class="fas fa-crown" style="color: gold"></i></p>
                                        <?php elseif ($latest_videos_data->access == 'registered'): ?>
                                            <p class="p-tag"><?php echo __('Register Now'); ?></p>
                                        <?php elseif (!empty($latest_videos_data->ppv_price)): ?>
                                            <p class="p-tag1"><?php echo $currency->symbol . ' ' . $latest_videos_data->ppv_price; ?></p>
                                        <?php elseif (!empty($latest_videos_data->global_ppv) || ($latest_videos_data->global_ppv !== null && $latest_videos_data->ppv_price == null)): ?>
                                            <p class="p-tag1"><?php echo $latest_videos_data->global_ppv . ' ' . $currency->symbol; ?></p>
                                        <?php else: ?>
                                            <p class="p-tag"><?php echo __('Free'); ?></p>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                </div>
                            </div>

                            <div class="block-description">
                                <a class="playTrailer" href="<?php echo URL::to('category'); ?><?= '/videos/' . $latest_videos_data->slug ?>">
                                    <?php $imageSrc = !empty($latest_videos_data->player_image) ? $latest_videos_data->player_image : $settings->default_video_image; ?>
                                    <img class="img-fluid w-100" loading="lazyload" src="<?php echo URL::to('/') . '/public/uploads/images/' . $imageSrc; ?>" alt="playerimage">

                                    <!-- PPV price -->

                                    <?php if ($ThumbnailSetting->free_or_cost_label == 1): ?>
                                        <?php if ($latest_videos_data->access == 'subscriber'): ?>
                                            <p class="p-tag"><i class="fas fa-crown" style="color: gold"></i></p>
                                        <?php elseif ($latest_videos_data->access == 'registered'): ?>
                                            <p class="p-tag"><?php echo __('Register Now'); ?></p>
                                        <?php elseif (!empty($latest_videos_data->ppv_price)): ?>
                                            <p class="p-tag1"><?php echo $currency->symbol . ' ' . $latest_videos_data->ppv_price; ?></p>
                                        <?php elseif (!empty($latest_videos_data->global_ppv) || ($latest_videos_data->global_ppv !== null && $latest_videos_data->ppv_price == null)): ?>
                                            <p class="p-tag1"><?php echo $latest_videos_data->global_ppv . ' ' . $currency->symbol; ?></p>
                                        <?php else: ?>
                                            <p class="p-tag"><?php echo __('Free'); ?></p>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                </a>

                                <?php if ($ThumbnailSetting->free_or_cost_label == 1): ?>
                                    <?php if ($latest_videos_data->access == 'subscriber'): ?>
                                        <p class="p-tag"><i class="fas fa-crown" style='color:gold'></i></p>
                                    <?php elseif ($latest_videos_data->access == 'registered'): ?>
                                        <p class="p-tag"><?php echo __('Register Now'); ?></p>
                                    <?php elseif (!empty($latest_videos_data->ppv_price)): ?>
                                        <p class="p-tag1"><?php echo $currency->symbol . ' ' . $latest_videos_data->ppv_price; ?></p>
                                    <?php elseif (!empty($latest_videos_data->global_ppv) || (!empty($latest_videos_data->global_ppv) && $latest_videos_data->ppv_price == null)): ?>
                                        <p class="p-tag1"><?php echo $latest_videos_data->global_ppv . ' ' . $currency->symbol; ?></p>
                                    <?php elseif ($latest_videos_data->global_ppv == null && $latest_videos_data->ppv_price == null): ?>
                                        <p class="p-tag"><?php echo __('Free'); ?></p>
                                    <?php endif; ?>
                                <?php endif; ?>
                            

                                <div class="hover-buttons text-white">
                                    <a href="<?php echo URL::to('category'); ?><?= '/videos/' . $latest_videos_data->slug ?>" aria-label="movie">
                                        <?php if($ThumbnailSetting->title == 1) { ?>

                                        <!-- Title -->

                                        <p class="epi-name text-left m-0">
                                            <?php echo strlen($latest_videos_data->title) > 17 ? substr($latest_videos_data->title, 0, 18) . '...' : $latest_videos_data->title; ?></p>

                                        <?php } ?>

                                        <div class="movie-time d-flex align-items-center pt-1">
                                            <?php if($ThumbnailSetting->age == 1) { ?>
                                            <!-- Age -->
                                            <div class="badge badge-secondary p-1 mr-2"><?php echo $latest_videos_data->age_restrict . ' ' . '+'; ?></div>
                                            <?php } ?>

                                            <?php if($ThumbnailSetting->duration == 1) { ?>
                                            <!-- Duration -->
                                            <span class="text-white">
                                                <i class="fa fa-clock-o"></i>
                                                <?= gmdate('H:i:s', $latest_videos_data->duration) ?>
                                            </span>
                                            <?php } ?>
                                        </div>

                                        <?php if(($ThumbnailSetting->published_year == 1) || ($ThumbnailSetting->rating == 1)) {?>
                                        <div class="movie-time d-flex align-items-center pt-1">
                                            <?php if($ThumbnailSetting->rating == 1) { ?>
                                                        <!--Rating  -->
                                                <div class="badge badge-secondary p-1 mr-2">
                                                    <span class="text-white">
                                                        <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                        <?php echo __($latest_videos_data->rating); ?>
                                                    </span>
                                                </div>
                                            <?php } ?>

                                            <?php if($ThumbnailSetting->published_year == 1) { ?>
                                                        <!-- published_year -->
                                                <div class="badge badge-secondary p-1 mr-2">
                                                    <span class="text-white">
                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                        <?php echo __($latest_videos_data->year); ?>
                                                    </span>
                                                </div>
                                            <?php } ?>

                                            <?php if($ThumbnailSetting->featured == 1 && $latest_videos_data->featured == 1) { ?>
                                                        <!-- Featured -->
                                                <div class="badge badge-secondary p-1 mr-2">
                                                    <span class="text-white">
                                                        <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                    </span>
                                                </div>
                                            <?php }?>
                                        </div>
                                        <?php } ?>

                                        <div class="movie-time d-flex align-items-center pt-1">
                                            <!-- Category Thumbnail  setting -->
                                            <?php
                                            $CategoryThumbnail_setting = App\CategoryVideo::join('video_categories', 'video_categories.id', '=', 'categoryvideos.category_id')
                                                ->where('categoryvideos.video_id', $latest_videos_data->id)
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

                                    <a class="epi-name mt-3 mb-0 btn" href="<?= URL::to('category/videos/' . $latest_videos_data->slug) ?>" >
                                    <img class="d-inline-block ply" alt="ply" src="<?php echo URL::to('assets/img/default_play_buttons.svg') ?>" width="10%"
                                            height="10%" /> Watch Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>

                    
                <?php  endforeach; 
            endif; ?>

            
            {{-- Latest Videos --}}
            <?php  if(isset($latest_episode)) :

                foreach($latest_episode->slice(0, 8) as $key => $latest_episode_data): ?>

                    <li class="slide-item">
                        <div class="block-images position-relative">
                            <!-- block-images -->
                            <div class="border-bg">
                                <div class="img-box">
                                    <a class="playTrailer" href="<?= URL::to('episode' . '/' . $latest_episode_data->series->slug . '/' . $latest_episode_data->slug); ?>">
                                        <img class="img-fluid w-100" loading="lazy" data-src="<?= URL::to('public/uploads/images/'.$latest_episode_data->image) ?>"  alt="l-img">
                                    </a>
                                        <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?> 
                                        <?php } ?>
                                </div>
                            </div>
                                    
                            <div class="block-description">
                                <a class="playTrailer" href="<?= URL::to('episode' . '/' . $latest_episode_data->series->slug . '/' . $latest_episode_data->slug); ?>">
                                    <img class="img-fluid w-100" loading="lazy" data-src="<?= URL::to('public/uploads/images/'.$latest_episode_data->image) ?>" alt="l-img">
                                </a>
                                <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?> 
                                            <?php } ?>
                                            

                                <div class="hover-buttons text-white">
                                    <a href="<?= URL::to('/episode' . '/' . $latest_episode_data->series->slug . '/' . $latest_episode_data->slug); ?>">
                                        <?php if($ThumbnailSetting->title == 1) { ?>  
                                                <!-- Title -->
                                                <p class="epi-name text-left m-0"><?php echo strlen($latest_episode_data->title) > 17 ? substr($latest_episode_data->title, 0, 18) . '...' : $latest_episode_data->title; ?></p>
                                        <?php } ?>

                                        <div class="movie-time d-flex align-items-center pt-1">
                                            <?php if($ThumbnailSetting->age == 1) { ?>      <!-- Age -->
                                                <div class="badge badge-secondary p-1 mr-2"><?php echo $latest_episode_data->age_restrict . ' ' . '+'; ?></div>
                                            <?php } ?>

                                            <?php if($ThumbnailSetting->duration == 1) { ?>   <!-- Duration -->
                                                <span class="text-white">
                                                    <i class="fa fa-clock-o"></i>
                                                    <?= gmdate('H:i:s', $latest_episode_data->duration) ?>
                                                </span>
                                            <?php } ?>
                                        </div>

                                        <?php if(($ThumbnailSetting->published_year == 1) || ($ThumbnailSetting->rating == 1)) {?>
                                            <div class="movie-time d-flex align-items-center pt-1">
                                                <?php if($ThumbnailSetting->rating == 1) { ?>   <!--Rating  -->
                                                    <div class="badge badge-secondary p-1 mr-2">
                                                        <span class="text-white">
                                                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                            <?php echo __($latest_episode_data->rating); ?>
                                                        </span>
                                                    </div>
                                                <?php } ?>

                                                <?php if($ThumbnailSetting->featured == 1 && $latest_episode_data->featured == 1) { ?>  <!-- Featured -->
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
                                        href="<?= URL::to('/episode' . '/' . $latest_episode_data->series->slug . '/' . $latest_episode_data->slug); ?>">
                                        <img class="d-inline-block ply" alt="ply" src="<?php echo URL::to('/') . '/assets/img/default_play_buttons.svg'; ?>" width="10%"
                                            height="10%" /> Watch Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>

                    
                <?php  endforeach; 
            endif; ?>
        </ul>
    </div>
<?php endif; ?>

<style>
    .i {
        text-decoration: none;
        text-decoration-line: none;
        text-decoration-style: initial;
        text-decoration-color: initial;
        outline-color: initial;
        outline-style: none;
        outline-width: medium;
        outline: medium none;
    }
</style>

<script>
    $('.mywishlist').click(function() {
        var video_id = $(this).data('videoid');
        if ($(this).data('authenticated')) {
            $(this).toggleClass('active');
            if ($(this).hasClass('active')) {
                $.ajax({
                    url: "<?php echo URL::to('/mywishlist'); ?>",
                    type: "POST",
                    data: {
                        video_id: $(this).data('videoid'),
                        _token: '<?= csrf_token() ?>'
                    },
                    dataType: "html",
                    success: function(data) {
                        if (data == "Added To Wishlist") {

                            $('#' + video_id).text('');
                            $('#' + video_id).text('Remove From Wishlist');
                            $("body").append(
                                '<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Media added to wishlist</div>'
                                );
                            setTimeout(function() {
                                $('.add_watch').slideUp('fast');
                            }, 3000);
                        } else {

                            $('#' + video_id).text('');
                            $('#' + video_id).text('Add To Wishlist');
                            $("body").append(
                                '<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white;">Media removed from wishlist</div>'
                                );
                            setTimeout(function() {
                                $('.remove_watch').slideUp('fast');
                            }, 3000);
                        }
                    }
                });
            }
        } else {
            window.location = '<?= URL::to('login') ?>';
        }
    });
</script>
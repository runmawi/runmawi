<?php if(count($latest_video) > 0): ?>
    <?php if(!Auth::guest() && !empty($data['password_hash'])) { $id = Auth::user()->id; } else { $id = 0; } ?>

    <div class="iq-main-header d-flex align-items-center justify-content-between">
        <!-- Header Link -->
        <?php if(Route::currentRouteName() == "ChannelHome"){ ?>
            <h5 class="main-title">
                <a href="<?php echo route('Channel_videos_list', Request::segment(2)); ?>">
                    <?php echo $order_settings_list[1]->header_name ?? ""; ?>
                </a>
            </h5>
            <a class="see" href="<?php echo route('Channel_videos_list', Request::segment(2)); ?>"> See All </a>
        <?php } else { ?>
            <h5 class="main-title">
                <a href="<?php echo !empty($order_settings_list[1]->header_name) ? URL::to('/') . '/' . $order_settings_list[1]->url : ""; ?>">
                    <?php echo $order_settings_list[1]->header_name ?? ""; ?>
                </a>
            </h5>
            <a class="see" href="<?php echo !empty($order_settings_list[1]->header_name) ? URL::to('/') . '/' . $order_settings_list[1]->url : ""; ?>"> See All </a>
        <?php } ?>
    </div>

    <div class="favorites-contens"> 
        <div class="latest-video home-sec list-inline row p-0 mb-0">
            <?php if(isset($latest_video)) : ?>
                <?php foreach($latest_video as $watchlater_video): ?>
                    <?php
                    if (!empty($watchlater_video->publish_time)) {
                        $currentdate = date("M d , y H:i:s");
                        date_default_timezone_set('Asia/Kolkata');
                        $current_date = date("M d , y H:i:s");
                        $date = date_create($current_date);
                        $currentdate = date_format($date, "D h:i");
                        $publish_time = date("D h:i", strtotime($watchlater_video->publish_time));

                        if ($watchlater_video->publish_type == 'publish_later') {
                            $publish_time = ($currentdate < $publish_time) ? date("D h:i", strtotime($watchlater_video->publish_time)) : 'Published';
                        } elseif ($watchlater_video->publish_type == 'publish_now') {
                            $currentdate = date_format($date, "y M D");
                            $publish_time = date("y M D", strtotime($watchlater_video->publish_time));
                            $publish_time = ($currentdate == $publish_time) ? 'Today' . ' ' . date("h:i", strtotime($watchlater_video->publish_time)) : 'Published';
                        } else {
                            $publish_time = '';
                        }
                    } else {
                        $publish_time = '';
                    }
                    ?>

                    <div class="items">
                        <a href="<?php echo URL::to('category') . '/videos/' . $watchlater_video->slug ?>" aria-label= "video">
                            <div class="block-images position-relative"> 
                                <div class="img-box">
                                    <a href="<?php echo URL::to('category') . '/videos/' . $watchlater_video->slug ?>">
                                        <img src="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image; ?>" class="img-fluid w-100 h-50" alt="<?php echo $watchlater_video->title; ?>">
                                    </a>

                                    <!-- PPV price -->
                                    <?php if($ThumbnailSetting->free_or_cost_label == 1): ?>
                                        <?php if(!empty($watchlater_video->ppv_price)): ?>
                                            <p class="p-tag1"><?php echo $currency->symbol.' '.$watchlater_video->ppv_price; ?></p>
                                        <?php elseif(!empty($watchlater_video->global_ppv) && $watchlater_video->ppv_price == null): ?>
                                            <p class="p-tag1"><?php echo $watchlater_video->global_ppv.' '.$currency->symbol; ?></p>
                                        <?php elseif($watchlater_video->global_ppv == null && $watchlater_video->ppv_price == null): ?>
                                            <p class="p-tag"><?php echo "Free"; ?></p>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    
                                    <?php if($ThumbnailSetting->published_on == 1): ?>                                            
                                        <p class="published_on1"><?php echo $publish_time; ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="block-description">
                                <div class="hover-buttons">
                                    <a class="" href="<?php echo URL::to('category') . '/videos/' . $watchlater_video->slug ?>" aria-label="Latest-Video"> 
                                        <img class="ply" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg'; ?>" alt="play" /> 
                                    </a>
                                </div>
                            </div>

                            <div class="p-0">
                                <div class="mt-2 d-flex justify-content-between p-0">
                                    <?php if($ThumbnailSetting->title == 1): ?>
                                        <h5 style="font-size:1.0em; font-weight:500;"><?php echo (strlen($watchlater_video->title) > 17) ? substr($watchlater_video->title, 0, 18).'...' : $watchlater_video->title; ?></h5>
                                    <?php endif; ?>

                                    <?php if($ThumbnailSetting->age == 1): ?>
                                        <div class="badge badge-secondary"><?php echo $watchlater_video->age_restrict.'+'; ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="movie-time my-2">
                                    <!-- Duration -->
                                    <?php if($ThumbnailSetting->duration == 1): ?>
                                        <span class="text-white">
                                            <i class="fa fa-clock-o"></i>
                                            <?php echo gmdate('H:i:s', $watchlater_video->duration); ?>
                                        </span>
                                    <?php endif; ?>

                                    <!-- Rating -->
                                    <?php if($ThumbnailSetting->rating == 1 && $watchlater_video->rating != null): ?>
                                        <span class="text-white">
                                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                            <?php echo __($watchlater_video->rating); ?>
                                        </span>
                                    <?php endif; ?>

                                    <!-- Featured -->
                                    <?php if($ThumbnailSetting->featured == 1 && $watchlater_video->featured == 1): ?>
                                        <span class="text-white">
                                            <i class="fa fa-flag" aria-hidden="true"></i>
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <div class="movie-time my-2">
                                    <!-- published_year -->
                                    <?php if($ThumbnailSetting->published_year == 1 && $watchlater_video->year != null): ?>
                                        <span class="text-white">
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                            <?php echo __($watchlater_video->year); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <div class="movie-time my-2">
                                    <!-- Category Thumbnail setting -->
                                    <?php
                                    $CategoryThumbnail_setting = App\CategoryVideo::join('video_categories','video_categories.id','=','categoryvideos.category_id')
                                        ->where('categoryvideos.video_id',$watchlater_video->id)
                                        ->pluck('video_categories.name');        
                                    ?>

                                    <?php if($ThumbnailSetting->category == 1 && count($CategoryThumbnail_setting) > 0): ?>
                                        <span class="text-white">
                                            <i class="fa fa-list-alt" aria-hidden="true"></i>
                                            <?php echo implode(', ', $CategoryThumbnail_setting->toArray()); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
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
    .flickity-prev-next-button{
        top: 35%;
    }
</style>
<script>
    $('.mywishlist').click(function(){
        var video_id = $(this).data('videoid');
            if($(this).data('authenticated')){
                $(this).toggleClass('active');
                if($(this).hasClass('active')){
                        $.ajax({
                            url: "<?php echo URL::to('/mywishlist');?>",
                            type: "POST",
                            data: { video_id : $(this).data('videoid'), _token: '<?= csrf_token(); ?>'},
                            dataType: "html",
                            success: function(data) {
                              if(data == "Added To Wishlist"){
                                $('#'+video_id).text('') ;
                                $('#'+video_id).text('Remove From Wishlist');
                                $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Media added to wishlist</div>');
                              setTimeout(function() {
                                $('.add_watch').slideUp('fast');
                              }, 3000);
                              }else{
                                $('#'+video_id).text('') ;
                                $('#'+video_id).text('Add To Wishlist');
                                $("body").append('<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white;">Media removed from wishlist</div>');
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


    var elem = document.querySelector('.latest-video');
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
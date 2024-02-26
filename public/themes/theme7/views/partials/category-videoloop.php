<style>
    .playvid {
        display: block;
        width: 280%;
        height: auto !important;
        margin-left: -410px;
    }

    .btn.btn-primary.close {
        margin-right: -17px;
        background-color: #4895d1 !important;
    }

    button.close {
        padding: 9px 30px !important;
        border: 0;
        -webkit-appearance: none;
    }

    .close {
        margin-right: -429px !important;
        margin-top: -1461px !important;
    }

    .modal-footer {
        border-bottom: 0px !important;
        border-top: 0px !important;
    }
</style>
<div class="container-fluid overflow-hidden">
    <div class="row">
        <div class="col-sm-12 ">
            <div class="iq-main-header d-flex align-items-center justify-content-between">
                <a href="<?php echo URL::to('/category/') . '/' . $category->slug; ?>" class="category-heading"
                    style="text-decoration:none;color:#fff">
                    <h4 class="movie-title">
                        <?php
                        if (!empty($category->home_genre)) {
                            echo __($category->home_genre);
                        } else {
                            echo __($category->name);
                        }
                        ?>
                    </h4>
                </a>
            </div>
            <div class="favorites-contens">
                <ul class="favorites-slider list-inline  row p-0 mb-0">
                    <?php if (!Auth::guest() && !empty($data['password_hash'])) {
                        $id = Auth::user()->id;
                    } else {
                        $id = 0;
                    } ?>
                    <?php if (isset($videos)):
                        foreach ($videos as $category_video):
                            if (!empty($category_video->publish_time) && !empty($category_video->publish_time)) {
                                $currentdate = date("M d , y H:i:s");
                                date_default_timezone_set('Asia/Kolkata');
                                $current_date = Date("M d , y H:i:s");
                                $date = date_create($current_date);
                                $currentdate = date_format($date, "D h:i");
                                $publish_time = date("D h:i", strtotime($category_video->publish_time));
                                if ($category_video->publish_type == 'publish_later') {
                                    if ($currentdate < $publish_time) {
                                        $publish_time = date("D h:i", strtotime($category_video->publish_time));
                                    } else {
                                        $publish_time = 'Published';
                                    }
                                } elseif ($category_video->publish_type == 'publish_now') {
                                    $currentdate = date_format($date, "y M D");

                                    $publish_time = date("y M D", strtotime($category_video->publish_time));

                                    if ($currentdate == $publish_time) {
                                        $publish_time = 'Today' . ' ' . date("h:i", strtotime($category_video->publish_time));
                                    } else {
                                        $publish_time = 'Published';
                                    }
                                } else {
                                    $publish_time = '';
                                }
                            } else {
                                $publish_time = '';
                            }
                            ?>
                            <li class="slide-item">
                                <div class="block-images position-relative">
                                    <!-- block-images -->
                                    <div class="border-bg">
                                        <div class="img-box">
                                            <a class="playTrailer"
                                                href="<?php echo URL::to('category'); ?><?= '/videos/' . $category_video->slug ?>">
                                                <img src="<?php echo URL::to('/') . '/public/uploads/images/' . $category_video->image; ?>"
                                                    class="img-fluid w-100" alt="cate">
                                            </a>

                                            <?php if ($ThumbnailSetting->free_or_cost_label == 1) { ?>
                                                <p class="p-tag1">
                                                    <?php if ($category_video->access == 'subscriber') { ?>
                                                    <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                                                <?php } elseif ($category_video->access == 'registered') { ?>
                                                    <p class="p-tag">
                                                        <?php echo (__('Register Now')); ?>
                                                    </p>
                                                <?php } elseif (!empty($category_video->ppv_price)) {
                                                        echo $currency->symbol . ' ' . $category_video->ppv_price;
                                                    } elseif (!empty($category_video->global_ppv) && $category_video->ppv_price == null) {
                                                        echo $currency->symbol . ' ' . $category_video->global_ppv;
                                                    } elseif (empty($category_video->global_ppv) && $category_video->ppv_price == null) {
                                                        echo __("Free");
                                                    }
                                                    ?>
                                                </p>
                                            <?php } ?>
                                            <!-- <?php if ($ThumbnailSetting->published_on == 1) { ?>
                                    <p class="published_on1"><?php echo $publish_time; ?></p>
                                    <?php } ?> -->
                                        </div>
                                    </div>

                                    
                                </div>
                            </li>
                        <?php endforeach; endif; ?>

                    <!-- Episode -->
                    <?php if (isset($Episode_videos)):
                        foreach ($Episode_videos as $key => $Episode_video): ?>
                            <li class="slide-item">
                                <a
                                    href="<?php echo URL::to('episode'); ?><?= '/' . @$Episode_video->series_slug . '/' . $Episode_video->slug ?>">
                                    <div class="block-images position-relative">
                                        <div class="img-box">
                                            <!-- block-images -->
                                            <img src="<?php echo URL::to('/') . '/public/uploads/images/' . $Episode_video->image; ?>"
                                                class="img-fluid" alt="">
                                            <?php if ($ThumbnailSetting->free_or_cost_label == 1) { ?>
                                                <!-- <p class="p-tag1"> -->
                                                <?php
                                                // if(!empty($Episode_video->ppv_price)) {
                                                // echo $currency->symbol.' '.$Episode_video->ppv_price ;
                                                // } elseif(!empty($Episode_video->global_ppv) && $Episode_video->ppv_price == null) {
                                                //     echo $currency->symbol .' '.$Episode_video->global_ppv;
                                                // } elseif(empty($Episode_video->global_ppv) && $Episode_video->ppv_price == null) {
                                                //     echo "Free";
                                                // }
                                                ?>
                                                <!-- </p> -->
                                            <?php } ?>
                                        </div>

                                    </div>
                                </a>
                            </li>
                        <?php endforeach; endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    $('.mywishlist').click(function () {
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
                    success: function (data) {
                        if (data == "Added To Wishlist") {

                            $('#' + video_id).text('');
                            $('#' + video_id).text('Remove From Wishlist');
                            $("body").append(
                                '<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Media added to wishlist</div>'
                            );
                            setTimeout(function () {
                                $('.add_watch').slideUp('fast');
                            }, 3000);
                        } else {

                            $('#' + video_id).text('');
                            $('#' + video_id).text('Add To Wishlist');
                            $("body").append(
                                '<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white;">Media removed from wishlist</div>'
                            );
                            setTimeout(function () {
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
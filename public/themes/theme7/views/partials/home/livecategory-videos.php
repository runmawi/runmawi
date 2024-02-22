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




<?php

$setting = \App\HomeSetting::first();
// dd($live_videos);
$currency = App\CurrencySetting::first();

?>
<?php if (count($live_videos) > 0): ?>


    <div class="mb-5">
        <div class="row">
            <div class="col-sm-12 overflow-hidden">
                <div class="iq-main-header d-flex align-items-center justify-content-between">
                    <!-- <h4 class="main-title"><a href="<?php echo URL::to('home') ?>">Latest Videos</a></h4> -->
                    <a href="<?= URL::to('/') ?><?= '/LiveCategory' . '/' . $category->slug ?>" class="category-heading"
                        style="text-decoration:none;color:#fff">
                        <h4 class="movie-title">
                            <?php
                            echo __($category->name); ?>
                        </h4>
                    </a>
                    <h4 class="main-title"><a href="<?= URL::to('/') ?><?= '/LiveCategory' . '/' . $category->slug ?>">
                            <?php echo (__('View All')); ?>
                        </a></h4>
                </div>
                <div class="favorites-contens">
                    <ul class="favorites-slider list-inline  row p-0 mb-0">
                        <?php if (!Auth::guest() && !empty($data['password_hash'])) {
                            $id = Auth::user()->id;
                        } else {
                            $id = 0;
                        } ?>
                        <?php if (isset($videos)):
                            foreach ($live_videos as $category_video):

                                ?>
                                <li class="slide-item">
                                    <div class="block-images position-relative">

                                        <!-- block-images -->
                                        <div class="border-bg">
                                            <div class="img-box">
                                                <a class="playTrailer"
                                                    href="<?= URL::to('/') ?><?= '/live' . '/' . $category_video->slug ?>">
                                                    <img src="<?php echo URL::to('/') . '/public/uploads/images/' . $category_video->image; ?>"
                                                        class="img-fluid w-100" alt="live-c">
                                                </a>

                                                <!-- PPV price -->

                                                <?php if ($ThumbnailSetting->free_or_cost_label == 1) { ?>
                                                    <p class="p-tag1">
                                                        <?php if ($category_video->access == 'subscriber') { ?>
                                                        <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                                                    <?php } elseif ($category_video->access == 'registered') { ?>
                                                        <p class="p-tag">
                                                            <?php echo "Register Now"; ?>
                                                        </p>
                                                    <?php } elseif (!empty($category_video->ppv_price)) {
                                                            echo $category_video->ppv_price . ' ' . $currency->symbol;
                                                        } elseif (!empty($category_video->global_ppv) && $category_video->ppv_price == null) {
                                                            echo $category_video->global_ppv . ' ' . $currency->symbol;
                                                        } elseif (empty($category_video->global_ppv) && $category_video->ppv_price == null) {
                                                            echo "Free";
                                                        }
                                                        ?>
                                                    </p>
                                                <?php } ?>

                                            </div>
                                        </div>
                                        
                                    </div>
                                </li>
                            <?php
                            endforeach;
                        endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<script>
    $('.mywishlist').click(function () {
        var video_id = $(this).data('videoid');
        if ($(this).data('authenticated')) {
            $(this).toggleClass('active');
            if ($(this).hasClass('active')) {
                $.ajax({
                    url: "<?php echo URL::to('/mywishlist'); ?>",
                    type: "POST",
                    data: { video_id: $(this).data('videoid'), _token: '<?= csrf_token(); ?>' },
                    dataType: "html",
                    success: function (data) {
                        if (data == "Added To Wishlist") {

                            $('#' + video_id).text('');
                            $('#' + video_id).text('Remove From Wishlist');
                            $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Media added to wishlist</div>');
                            setTimeout(function () {
                                $('.add_watch').slideUp('fast');
                            }, 3000);
                        } else {

                            $('#' + video_id).text('');
                            $('#' + video_id).text('Add To Wishlist');
                            $("body").append('<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white;">Media removed from wishlist</div>');
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
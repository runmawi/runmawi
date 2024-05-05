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
                <a href="<?php echo URL::to('/series/category') . '/' . $category->slug; ?>" class="category-heading" style="text-decoration:none;color:#fff">
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
                <?php if( $settings->homepage_views_all_button_status == 1 ):?> 
                    <h4 class="main-title"><a href="<?php echo URL::to('/series/category') . '/' . $category->slug; ?>"><?php echo (__('View All')); ?></a></h4>
                <?php endif; ?>    
            </div>
            <div class="favorites-contens">
                <ul class="favorites-slider list-inline  row p-0 mb-0">
                    <?php if (!Auth::guest() && !empty($data['password_hash'])) {
                        $id = Auth::user()->id;
                    } else {
                        $id = 0;
                    } ?>
                    <?php  if(isset($series)) :
                            foreach($series as $series_video): 
                        ?>
                    <li class="slide-item">
                        <div class="block-images position-relative">
                            <!-- block-images -->
                            <div class="border-bg">
                            <div class="img-box">
                                <a class="playTrailer" href="<?php echo URL::to('play_series'); ?><?= '/' . $series_video->slug ?>">
                                    <img class="img-fluid w-100" loading="lazy" data-src="<?php echo URL::to('/') . '/public/uploads/images/' . $series_video->image; ?>"  alt="cate">
                                </a>
                                    
                                    <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>
                                    <p class="p-tag1">
                                        <?php  if($series_video->access == 'subscriber' ){ ?>
                                    <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                                    <?php }elseif($series_video->access == 'registered'){?>
                                    <p class="p-tag"><?php echo (__('Register Now')); ?></p>
                                    <?php } 
                                       elseif(!empty($series_video->ppv_price)) {
                                          echo $currency->symbol.' '.$series_video->ppv_price ; 
                                          } elseif(!empty($series_video->global_ppv) && $series_video->ppv_price == null) {
                                             echo $currency->symbol .' '.$series_video->global_ppv;
                                          } elseif(empty($series_video->global_ppv) && $series_video->ppv_price == null) {
                                             echo "Free"; 
                                          }
                                       ?>
                                    </p>
                                    <?php } ?>
                                    
                                </div>
                                </div>


                                <div class="block-description">
                                <a class="playTrailer" href="<?php echo URL::to('play_series'); ?><?= '/' . $series_video->slug ?>">
                                    <img class="img-fluid w-100" loading="lazy" data-src="<?php echo URL::to('/') . '/public/uploads/images/' . $series_video->player_image; ?>" alt="cate">
                                
                                    
                                    <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>
                                    <p class="p-tag1">
                                        <?php  if($series_video->access == 'subscriber' ){ ?>
                                    <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                                    <?php }elseif($series_video->access == 'registered'){?>
                                    <p class="p-tag"><?php echo (__('Register Now')); ?></p>
                                    <?php } 
                                       elseif(!empty($series_video->ppv_price)) {
                                          echo $currency->symbol.' '.$series_video->ppv_price ; 
                                          } elseif(!empty($series_video->global_ppv) && $series_video->ppv_price == null) {
                                             echo $currency->symbol .' '.$series_video->global_ppv;
                                          } elseif(empty($series_video->global_ppv) && $series_video->ppv_price == null) {
                                             echo "Free"; 
                                          }
                                       ?>
                                    </p>
                                    <?php } ?>
                                    </a>
                                    <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>
                                    <p class="p-tag1">
                                        <?php  if($series_video->access == 'subscriber' ){ ?>
                                    <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                                    <?php }elseif($series_video->access == 'registered'){?>
                                    <p class="p-tag"><?php echo (__('Register Now')); ?></p>
                                    <?php } 
                                       elseif(!empty($series_video->ppv_price)) {
                                          echo $currency->symbol.' '.$series_video->ppv_price ; 
                                          } elseif(!empty($series_video->global_ppv) && $series_video->ppv_price == null) {
                                             echo $currency->symbol .' '.$series_video->global_ppv;
                                          } elseif(empty($series_video->global_ppv) && $series_video->ppv_price == null) {
                                             echo "Free"; 
                                          }
                                       ?>
                                    </p>
                                    <?php } ?>



                                    <div class="hover-buttons text-white">
                                    <a href="<?php echo URL::to('play_series'); ?><?= '/' . $series_video->slug ?>">
                                        <?php if($ThumbnailSetting->title == 1) { ?>
                                        <!-- Title -->
                                        <p class="epi-name text-left m-0">
                                            <?php echo strlen($series_video->title) > 17 ? substr($series_video->title, 0, 18) . '...' : $series_video->title; ?>
                                        </p>
                                        <?php } ?>
                                        <div class="movie-time d-flex align-items-center pt-1">
                                            
                                            <?php if($ThumbnailSetting->duration == 1) { ?>
                                            <!-- Duration -->
                                             <span class="text-white">
                                                   <i class="fa fa-clock-o"></i>
                                                   <?= gmdate('H:i:s', $series_video->duration) ?>
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
                                                      <?php echo __($series_video->rating); ?>
                                                   </span>
                                             </div>
                                            <?php } ?>
                                           
                                            <?php if($ThumbnailSetting->featured == 1 && $series_video->featured == 1) { ?>
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
                                             $CategoryThumbnail_setting = App\SeriesCategory::join('series_genre', 'series_genre.id', '=', 'series_categories.category_id')
                                                   ->where('series_categories.series_id', $category->id)
                                                   ->pluck('series_genre.name');
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

                                  
                                            <a class="epi-name mt-3 mb-0 btn" type="button" 
                                                href="<?php echo URL::to('play_series'); ?><?= '/' . $series_video->slug ?>">
                                                <img class="d-inline-block ply" alt="ply" src="<?php echo URL::to('/') . '/assets/img/default_play_buttons.svg'; ?>"
                                                    width="10%" height="10%" /> Watch Now
                                            </a>
                                        </div>
                                </div>
                            </div>
                    </li>
                    <?php   endforeach;  endif; ?>

                </ul>
            </div>
        </div>
    </div>
</div>

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

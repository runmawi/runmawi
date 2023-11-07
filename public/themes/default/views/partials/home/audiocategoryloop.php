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

            <div class="iq-main-header d-flex align-items-center justify-content-between">
                <a href="<?php echo URL::to('/audios/category') . '/' . $category->slug; ?>" class="category-heading" style="text-decoration:none;color:#fff">
                    <h4 class="movie-title">
                        <?php
                        if (!empty($category->name)) {
                            echo __($category->name);
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
                    <?php  if(isset($audios)) :
                            foreach($audios as $audio): 
                        ?>
                    <li class="slide-item">
                        <div class="block-images position-relative">
                            <!-- block-images -->
                            <div class="border-bg">
                            <div class="img-box">
                                <a href="<?php echo URL::to('audio'); ?><?= '/' . $audio->slug ?>">
                                    <img src="<?php echo URL::to('/') . '/public/uploads/images/' . $audio->image; ?>" class="img-fluid w-100" alt="cate">
                                </a>
                            
                                    
                                    <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>
                                    <p class="p-tag1">
                                        <?php  if($audio->access == 'subscriber' ){ ?></p>
                                    <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                                    <?php }elseif($audio->access == 'registered'){?>
                                          <p class="p-tag"><?php echo "Register Now"; ?></p>
                                          <?php }
                                       elseif(!empty($audio->ppv_price)) {
                                          echo $currency->symbol.' '.$audio->ppv_price ; 
                                          }  elseif( $audio->ppv_price == null) {
                                             echo "Free"; 
                                          }
                                       ?>
                                    
                                    <?php } ?>
                                    
                                </div>
                                </div>
                                <div class="block-description">
                                <a href="<?php echo URL::to('audio'); ?><?= '/' . $audio->slug ?>">
                                    <img src="<?php echo URL::to('/') . '/public/uploads/images/' . $audio->player_image; ?>" class="img-fluid w-100" alt="cate">
                                
                            
                                    
                                    <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>
                                    <p class="p-tag1">
                                        <?php  if($audio->access == 'subscriber' ){ ?></p>
                                    <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                                    <?php }elseif($audio->access == 'registered'){?>
                                          <p class="p-tag"><?php echo "Register Now"; ?></p>
                                          <?php }
                                       elseif(!empty($audio->ppv_price)) {
                                          echo $currency->symbol.' '.$audio->ppv_price ; 
                                          }  elseif( $audio->ppv_price == null) {
                                             echo "Free"; 
                                          }
                                       ?>
                                    
                                    <?php } ?>
                                    </a>
                                    <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>
                                    <p class="p-tag1">
                                        <?php  if($audio->access == 'subscriber' ){ ?></p>
                                    <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                                    <?php }elseif($audio->access == 'registered'){?>
                                          <p class="p-tag"><?php echo "Register Now"; ?></p>
                                          <?php }
                                       elseif(!empty($audio->ppv_price)) {
                                          echo $currency->symbol.' '.$audio->ppv_price ; 
                                          }  elseif( $audio->ppv_price == null) {
                                             echo "Free"; 
                                          }
                                       ?>
                                    
                                    <?php } ?>

                                <div class="hover-buttons text-white">
                                    <a href="<?php echo URL::to('audio'); ?><?= '/' . $audio->slug ?>">
                                        <?php if($ThumbnailSetting->title == 1) { ?>
                                        <!-- Title -->
                                        <p class="epi-name text-left m-0">
                                            <?php echo strlen($audio->title) > 17 ? substr($audio->title, 0, 18) . '...' : $audio->title; ?>
                                        </p>
                                        <?php } ?>
                                        <div class="movie-time d-flex align-items-center pt-1">
                                            
                                            <?php if($ThumbnailSetting->duration == 1) { ?>
                                            <!-- Duration -->
                                             <span class="text-white">
                                                   <i class="fa fa-clock-o"></i>
                                                   <?= gmdate('H:i:s', $audio->duration) ?>
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
                                                      <?php echo __($audio->rating); ?>
                                                   </span>
                                             </div>
                                            <?php } ?>
                                           
                                            <?php if($ThumbnailSetting->featured == 1 && $audio->featured == 1) { ?>
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
                                             $CategoryThumbnail_setting = App\CategoryAudio::
                                                    join('audio_categories', 'audio_categories.id', '=', 'category_audios.category_id')
                                                   ->where('category_audios.audio_id', $category->id)
                                                   ->pluck('audio_categories.name');
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

                                       
                                            <a type="button" class="epi-name mt-3 mb-0 btn"
                                                href="<?php echo URL::to('audio'); ?><?= '/' . $audio->slug ?>">
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

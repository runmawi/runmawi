<div class="iq-main-header d-flex align-items-center justify-content-between">
    <h4 class="main-title"><a href="<?php echo URL::to('/latest-videos') ?>">Featured Movies</a></h4>
</div>
<div class="favorites-contens">
    <ul class="favorites-slider list-inline row p-0 mb-0">
        <?php  if(isset($featured_videos)) :
                      if(!empty($data['password_hash'])) { 
                          $id = Auth::user()->id ; } else { $id = 0 ; } foreach($featured_videos as $watchlater_video): ?>
        <li class="slide-item">
            <a href="<?php echo URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>">
                <!-- block-images -->
                <div class="block-images position-relative">
                    <div class="img-box">
                        <video width="100%" height="auto" class="play-video lazy" poster="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>" data-play="hover">
                            <source src="<?php echo $watchlater_video->trailer;  ?>" type="video/mp4" />
                        </video>

                        <!-- PPV price -->
                       
                                    <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>
                                    <?php  if(!empty($watchlater_video->ppv_price)){?>
                                    <p class="p-tag1"><?php echo $currency->symbol.' '.$watchlater_video->ppv_price; ?></p>
                                    <?php }elseif( !empty($watchlater_video->global_ppv || !empty($watchlater_video->global_ppv) && $watchlater_video->ppv_price == null)){ ?>
                                    <p class="p-tag1"><?php echo $watchlater_video->global_ppv.' '.$currency->symbol; ?></p>
                                    <?php }elseif($watchlater_video->global_ppv == null && $watchlater_video->ppv_price == null ){ ?>
                                    <p class="p-tag"><?php echo "Free"; ?></p>
                                    <?php } ?>
                                    <?php } ?>
                            

                    <!-- </div> -->
                </div>
                <div class="block-description">
                    <div class="hover-buttons">
                        <a class="text-white" href="<?php echo URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>"> <img class="ply" src="<?php echo URL::to('/').'/assets/img/play.svg';  ?>" /> </a>

                        <div class="d-flex">
                            <!-- <a   href="<?php //echo URL::to('category') ?><? // '/wishlist/' . $watchlater_video->slug ?>" class="text-white mt-4"><i class="fa fa-plus" aria-hidden="true"></i> Add to Watchlist -->
                            <!-- </a> -->
                            <!-- <span style="color: white;"class="mywishlist <?php //if(isset($mywishlisted->id)): ?>active<?php //endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $watchlater_video->id ?>">
                                            <i style="" <?php //if(isset($mywishlisted->id)): ?> class="ri-heart-fill" <?php // else: ?> class="ri-heart-line " <?php //endif; ?> style="" ></i>
                                            </span>
                                            <div style="color:white;" id="<?= $watchlater_video->id ?>"><?php  //if(@$watchlater_video->mywishlisted->user_id == $id && @$watchlater_video->mywishlisted->video_id == $watchlater_video->id  ) { echo "Remove From Wishlist"; } else { echo "Add To Wishlist" ; } ?></div> 
                                            </div> -->
                        </div>
                    </div>

                    <!--
                                    <div>
                                        <button class="show-details-button" data-id="<?= $watchlater_video->id;?>">
                                            <span class="text-center thumbarrow-sec">
                                                <img src="<?php echo URL::to('/').'/assets/img/arrow-red.png';?>" class="thumbarrow thumbarrow-red" alt="right-arrow">
                                            </span>
                                                </button>
                                    </div>
-->
                </div>
                <div class="mt-2 d-flex justify-content-between p-0">
                    <?php if($ThumbnailSetting->title == 1) { ?>
                    <h6><?php  echo (strlen($watchlater_video->title) > 17) ? substr($watchlater_video->title,0,18).'...' : $watchlater_video->title; ?></h6>
                    <?php } ?>

                    <?php if($ThumbnailSetting->age == 1) { ?>
                    <div class="badge badge-secondary"><?php echo $watchlater_video->age_restrict.' '.'+' ?></div>
                    <?php } ?>
                </div>
                <div class="movie-time my-2">
                    <!-- Duration -->

                    <?php if($ThumbnailSetting->duration == 1) { ?>
                    <span class="text-white">
                        <i class="fa fa-clock-o"></i>
                        <?= gmdate('H:i:s', $watchlater_video->duration); ?>
                    </span>
                    <?php } ?>

                    <!-- Rating -->

                    <?php if($ThumbnailSetting->rating == 1 && $watchlater_video->rating != null) { ?>
                    <span class="text-white">
                        <i class="fa fa-star-half-o" aria-hidden="true"></i>
                        <?php echo __($watchlater_video->rating); ?>
                    </span>
                    <?php } ?>

                    <?php if($ThumbnailSetting->featured == 1 && $watchlater_video->featured == 1) { ?>
                    <!-- Featured -->
                    <span class="text-white">
                        <i class="fa fa-flag" aria-hidden="true"></i>
                    </span>
                    <?php }?>
                </div>

                <div class="movie-time my-2">
                    <!-- published_year -->

                    <?php  if ( ($ThumbnailSetting->published_year == 1) && ( $watchlater_video->year != null ) ) { ?>
                    <span class="text-white">
                        <i class="fa fa-calendar" aria-hidden="true"></i>
                        <?php echo __($watchlater_video->year); ?>
                    </span>
                    <?php } ?>
                </div>

                <div class="movie-time my-2">
                    <!-- Category Thumbnail  setting -->
                    <?php
                    $CategoryThumbnail_setting =  App\CategoryVideo::join('video_categories','video_categories.id','=','categoryvideos.category_id')
                                ->where('categoryvideos.video_id',$watchlater_video->id)
                                ->pluck('video_categories.name');        
                    ?>
                    <?php  if ( ($ThumbnailSetting->category == 1 ) &&  ( count($CategoryThumbnail_setting) > 0 ) ) { ?>
                    <span class="text-white">
                        <i class="fa fa-list-alt" aria-hidden="true"></i>
                        <?php
                            $Category_Thumbnail = array();
                                foreach($CategoryThumbnail_setting as $key => $CategoryThumbnail){
                                $Category_Thumbnail[] = $CategoryThumbnail ; 
                                }
                            echo implode(','.' ', $Category_Thumbnail);
                        ?>
                    </span>
                    <?php } ?>
                </div>
            </a>
        </li>
        <?php      
                        endforeach; 
                                   endif; ?>
    </ul>
</div>


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
</script>

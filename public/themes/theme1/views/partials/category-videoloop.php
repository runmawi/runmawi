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

$setting= \App\HomeSetting::first();

if($setting['Recommendation'] !=null || $setting['Recommendation'] != 0 ):
if(isset($videos)) :
        foreach($videos as $category_video):
            $top_category_videos = App\RecentView::select('recent_views.video_id','videos.*',DB::raw('COUNT(recent_views.video_id) AS count')) 
                ->join('videos', 'videos.id', '=', 'recent_views.video_id') ->join('categoryvideos', 'categoryvideos.video_id', '=', 'videos.id') ->groupBy('video_id')->orderByRaw('count DESC' ) ->where('category_id','=','data') ->limit(20)
->get(); if(isset($top_category_videos)) : foreach($top_category_videos as $top_category_video): ?>
<!-- Top videos      -->
<div class="">
    <div class="row">
        <div class="col-sm-12 overflow-hidden">
            <div class="iq-main-header d-flex align-items-center justify-content-between">
                <!-- <h4 class="main-title"><a href="<?php echo URL::to('home') ?>">Latest Videos</a></h4> -->
                <a href="<?php echo URL::to('/category/').'/'.$category->slug;?>" class="category-heading" style="text-decoration: none; color: #fff;">
                    <h4 class="movie-title">
                        <?php 
                            echo __('Most watched videos from '.$category->name.' Genre');?>
                    </h4>
                </a>
            </div>
            <div class="favorites-contens">
                <ul class="favorites-slider list-inline row p-0 mb-0">
                    <li class="slide-item">
                        <div class="block-images position-relative">
                            <a href="<?php echo URL::to('category') ?><?= '/videos/' . $top_category_video->slug ?>">
                                <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$top_category_video->player_image;  ?>"
                                            class="img-fluid" alt="">
                                <!--<video width="100%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$top_category_video->player_image;  ?>" data-play="hover">
                                    <source src="<?php echo $top_category_video->trailer;  ?>" type="video/mp4" />
                                </video>-->
                            </a>
                        </div>
                        <div class="block-description">
                            <div class="hover-buttons">
                                <a type="button" class="text-white" href="<?php echo URL::to('category') ?><?= '/videos/' . $top_category_video->slug ?>"> <img class="ply" src="<?php echo URL::to('/').'/assets/img/play.png';  ?>" /> </a>
                            </div>
                        </div>
                        <div class="mt-2">
                            <a href="<?php echo URL::to('category') ?><?= '/videos/' . $top_category_video->slug ?>">
                                <h6><?php echo __($top_category_video->title); ?></h6>
                            </a>
                            <div class="movie-time d-flex align-items-center my-2">
                                <div class="badge badge-secondary p-1 mr-2"><?php echo $top_category_video->age_restrict.' '.'+' ?></div>
                                <span class="text-white">
                                    <i class="fa fa-clock-o"></i>
                                    <?= gmdate('H:i:s', $top_category_video->duration); ?>
                                </span>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php           
                          endforeach;  endif;    endforeach; 
                     endif;  endif; 
                     ?>

<div class="">
    <div class="row">
        <div class="col-sm-12 overflow-hidden">
            <div class="iq-main-header d-flex align-items-center justify-content-between">
                <!-- <h4 class="main-title"><a href="<?php echo URL::to('home') ?>">Latest Videos</a></h4> -->
                <a href="<?php echo URL::to('/category/').'/'.$category->slug;?>" class="category-heading" style="text-decoration: none; color: #fff;">
                    <h4 class="movie-title">
                        <?php 
                          echo __($category->name);?>
                    </h4>
                </a>
            </div>
            <div class="favorites-contens">
                <ul class="favorites-slider list-inline row p-0 mb-0">
                    <?php  if(!empty($data['password_hash'])) { 
                          $id = Auth::user()->id ; } else { $id = 0 ; } ?>
                    <?php  if(isset($videos)) :
                       foreach($videos as $category_video):
                        
                        ?>
                    <li class="slide-item">
                        <div class="block-images position-relative">
                            <!-- block-images -->
                            <a href="<?php echo URL::to('category') ?><?= '/videos/' . $category_video->slug ?>">
                                <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$category_video->player_image;  ?>"
                                        class="img-fluid" alt=""> 
                                <!--<video width="100%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$category_video->player_image;  ?>" data-play="hover">
                                    <source src="<?php echo $category_video->trailer;  ?>" type="video/mp4" />
                                </video>-->
                            </a>
                            <!-- PPV price -->
                          
                                    <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>
                                    <?php  if(!empty($category_video->ppv_price)){?>
                                    <p class="p-tag1"><?php echo $currency->symbol.' '.$category_video->ppv_price; ?></p>
                                    <?php }elseif( !empty($category_video->global_ppv || !empty($category_video->global_ppv) && $category_video->ppv_price == null)){ ?>
                                    <p class="p-tag1"><?php echo $category_video->global_ppv.' '.$currency->symbol; ?></p>
                                    <?php }elseif($category_video->global_ppv == null && $category_video->ppv_price == null ){ ?>
                                    <p class="p-tag"><?php echo "Free"; ?></p>
                                    <?php } ?>
                                    <?php } ?>
                              

                        </div>
                        <div class="block-description">
                            <div class="hover-buttons">
                                <a type="button" class="text-white btn-cl" href="<?php echo URL::to('category') ?><?= '/videos/' . $category_video->slug ?>">
                                    <img class="ply" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>" />
                                </a>
                                <div class="d-flex">
                                    <!-- <span style="color: white;"class="mywishlist <?php // if(isset($mywishlisted->id)): ?>active<?php // endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $category_video->id ?>">
                            <i style="" <?php //if(isset($mywishlisted->id)): ?> class="ri-heart-fill" <?php //else: ?> class="ri-heart-line " <?php //endif; ?> style="" ></i>
                          </span>
                          <div style="color:white;" id="<?= $category_video->id ?>"><?php // if(@$category_video->mywishlisted->user_id == $id && @$category_video->mywishlisted->video_id == $category_video->id  ) { echo "Remove From Wishlist"; } else { echo "Add To Wishlist" ; } ?></div> 
                              </div> -->
                                    <!-- <a   href="<?php // echo URL::to('category') ?><? // '/wishlist/' . $category_video->slug ?>" class="text-white mt-4"><i class="fa fa-plus" aria-hidden="true"></i> Add to Watchlist -->
                                    <!-- </a> -->
                                </div>

                                <!--
                           <div>
                               <button class="show-details-button" data-id="<?= $category_video->id;?>">
                                   <span class="text-center thumbarrow-sec">
                                       <img src="<?php echo URL::to('/').'/assets/img/arrow-red.png';?>" class="thumbarrow thumbarrow-red" alt="right-arrow">
                                   </span>
                                       </button></div>
                        -->
                            </div>
                        </div>
                        <div class="mt-2 d-flex justify-content-between p-0">
                    <?php if($ThumbnailSetting->title == 1) { ?>
                    <h6><?php  echo (strlen($category_video->title) > 17) ? substr($category_video->title,0,18).'...' : $category_video->title; ?></h6>
                    <?php } ?>

                    <?php if($ThumbnailSetting->age == 1) { ?>
                    <div class="badge badge-secondary"><?php echo $category_video->age_restrict.' '.'+' ?></div>
                    <?php } ?>
                </div>
                <div class="movie-time my-2">
                  
                    <!-- Duration -->

                    <?php if($ThumbnailSetting->duration == 1) { ?>
                    <span class="text-white">
                        <i class="fa fa-clock-o"></i>
                        <?= gmdate('H:i:s', $category_video->duration); ?>
                    </span>
                    <?php } ?>

                    <!-- Rating -->

                    <?php if($ThumbnailSetting->rating == 1 && $category_video->rating != null) { ?>
                    <span class="text-white">
                        <i class="fa fa-star-half-o" aria-hidden="true"></i>
                        <?php echo __($category_video->rating); ?>
                    </span>
                    <?php } ?>

                    <?php if($ThumbnailSetting->featured == 1 && $category_video->featured == 1) { ?>
                        <!-- Featured -->
                        <span class="text-white">
                            <i class="fa fa-flag" aria-hidden="true"></i>
                        </span>
                    <?php }?>
                </div>

                <div class="movie-time my-2">
                    <!-- published_year -->

                    <?php  if ( ($ThumbnailSetting->published_year == 1) && ( $category_video->year != null ) ) { ?>
                    <span class="text-white">
                        <i class="fa fa-calendar" aria-hidden="true"></i>
                        <?php echo __($category_video->year); ?>
                    </span>
                    <?php } ?>
                </div>

                <div class="movie-time my-2">
                    <!-- Category Thumbnail  setting -->
                    <?php
                    $CategoryThumbnail_setting =  App\CategoryVideo::join('video_categories','video_categories.id','=','categoryvideos.category_id')
                                ->where('categoryvideos.video_id',$category_video->video_id)
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
                       
                    </li>
                    <?php           
                          endforeach; 
                     endif; ?>
                </ul>
            </div>
        </div>
    </div>
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
                                $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Media added to wishlist</div>');
                              setTimeout(function() {
                                $('.add_watch').slideUp('fast');
                              }, 3000);
                              }else{

                                $('#'+video_id).text('') ;
                                $('#'+video_id).text('Add To Wishlist');
                                $("body").append('<div class="remove_watch" style="z-index: 100; position: fixed; top: px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white;">Media removed from wishlist</div>');
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

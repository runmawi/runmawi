<?php  if(count($series) > 0 && $countDataFreeseriesCategories > 0 )  : ?>
<div class="iq-main-header d-flex align-items-center justify-content-between">
<h4 class="main-title">
        <!-- Data Free series -->
   <a href="<?php echo URL::to('/series/category/').'/'.$DataFreeseriesCategories->slug;?>" class="category-heading" style="text-decoration: none; color: #fff;">
     
         <?php 
         if(!empty($DataFreeseriesCategories->home_genre)){ echo $DataFreeseriesCategories->name ; }else{ echo $DataFreeseriesCategories->name ; }  
         //   echo __($category->name);
            ?>
     
   </a>
        </h4>
</div>
<div class="favorites-contens">
    <ul class="favorites-slider list-inline row p-0 mb-0">
        <?php  if(isset($series)) :
                         foreach($series as $category_series):
                            ?>
        <!-- .@$video->categories->name. -->
        <li class="slide-item">
            <a href="<?= URL::to('/') ?><?= '/play_series'.'/' . $category_series->slug ?>">
                <!-- block-images -->
                <div class="block-images position-relative">
                    <div class="img-box">
                    <a href="<?php echo URL::to('') ?><?= '/play_series/' . $category_series->slug ?>">
                                <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$category_series->image;  ?>"
                                        class="img-fluid w-100" alt=""> 
                            </a>
                        <!-- PPV price -->
                        <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?> 
                                    <?php  if(!empty($category_series->ppv_price)){?>
                                         <p class="p-tag1"><?php echo $currency->symbol.' '.$category_series->ppv_price; ?></p>
                                    <?php }elseif( !empty($category_series->global_ppv || !empty($category_series->global_ppv) && $category_series->ppv_price == null)){ ?>
                                        <p class="p-tag1"><?php echo $category_series->global_ppv.' '.$currency->symbol; ?></p>
                                    <?php }elseif($category_series->global_ppv == null && $category_series->ppv_price == null ){ ?>
                                        <p class="p-tag"><?php echo "Free"; ?></p>
                                    <?php } ?>
                                <?php } ?>

                            </div>
                        
                </div>
                <div class="block-description">
                            <div class="hover-buttons">
                                <a type="button" class="text-white btn-cl" href="<?php echo URL::to('') ?><?= '/play_series/' . $category_series->slug ?>">
                                    <img class="ply" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>" />
                                </a>                       
                            </div>
                        </div>

                        <div class="mt-2 d-flex justify-content-between p-0">
                            <?php if($ThumbnailSetting->title == 1) { ?>
                                <h6><?php  echo (strlen($category_series->title) > 17) ? substr($category_series->title,0,18).'...' : $category_series->title; ?></h6>
                            <?php } ?>


                        </div>

                        <div class="movie-time my-2">
                        


                            <!-- Rating -->

                            <?php if($ThumbnailSetting->rating == 1 && $category_series->rating != null) { ?>
                                <span class="text-white">
                                    <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                    <?php echo __($category_series->rating); ?>
                                </span>
                            <?php } ?>

                            <?php if($ThumbnailSetting->featured == 1 && $category_series->featured == 1) { ?>
                                <!-- Featured -->
                                <span class="text-white">
                                    <i class="fa fa-flag" aria-hidden="true"></i>
                                </span>
                            <?php }?>
                        </div>

                        <div class="movie-time my-2">
                            <!-- published_year -->

                            <?php  if ( ($ThumbnailSetting->published_year == 1) && ( $category_series->year != null ) ) { ?>
                                <span class="text-white">
                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                    <?php echo __($category_series->year); ?>
                                </span>
                            <?php } ?>
                        </div>

        </li>

        <?php endforeach; 
                                   endif; ?>
    </ul>
</div>
<?php endif; ?>



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

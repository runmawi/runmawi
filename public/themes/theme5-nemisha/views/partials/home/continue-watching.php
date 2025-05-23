<?php  if(count($cnt_watching) > 0) :  ?>
<?php  if(!Auth::guest() && !empty($data['password_hash'])) { 
 $id = Auth::user()->id ; } else { $id = 0 ; } ?>
<div class="iq-main-header d-flex align-items-center justify-content-between">
    <h5 class="main-title"><a href="<?php echo URL::to('continue_watching_list') ?>">Continue Watching</a></h5>
    <a class="see" href="<?php echo URL::to('continue_watching_list') ?>">See All</a>
</div>
<div class="favorites-contens"> 
<div class="continue-watching home-sec list-inline row p-0 mb-0">
        <?php  if(isset($cnt_watching)) :
                         foreach($cnt_watching as $cont_video): 
                          ?>
        <div class="items">
            <a href="<?php echo URL::to('category') ?><?= '/videos/' . $cont_video->slug ?>" aria-label="videos">
                <div class="block-images position-relative">
                    <!-- block-images -->
                    <div class="img-box">
                        <img src="<?php echo URL::to('/').'/public/uploads/images/'.$cont_video->image;  ?>" class="img-fluid lazyload w-100 h-50" alt="">
                       <!-- <video width="100%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$cont_video->image;  ?>" data-play="hover">
                            <source src="<?php echo $cont_video->trailer;  ?>" type="video/mp4" />
                        </video>
                        
                            <!-- PPV price -->
                           
                                    <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>
                                    <?php  if(!empty($cont_video->ppv_price)){?>
                                    <p class="p-tag1"><?php echo $currency->symbol.' '.$cont_video->ppv_price; ?></p>
                                    <?php }elseif( !empty($cont_video->global_ppv || !empty($cont_video->global_ppv) && $cont_video->ppv_price == null)){ ?>
                                    <p class="p-tag1"><?php echo $cont_video->global_ppv.' '.$currency->symbol; ?></p>
                                    <?php }elseif($cont_video->global_ppv == null && $cont_video->ppv_price == null ){ ?>
                                    <p class="p-tag"><?php echo "Free"; ?></p>
                                    <?php } ?>
                                    <?php } ?>
                             
                    </div>
                </div>

                
                <div class="block-description">
                    <div class="hover-buttons text-white">
                        <a class="" href="<?php echo URL::to('category') ?><?= '/videos/' . $cont_video->slug ?>" aria-label="Continue-Watching"> 
                            <img class="ply" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>" alt="play" /> </a>
                        <div></div>
                    </div>
                </div>

                <div class="mt-2 d-flex justify-content-between p-0">
                    <?php if($ThumbnailSetting->title == 1) { ?>
                    <h6><?php  echo (strlen($cont_video->title) > 150) ? substr($cont_video->title,0,150).'...' : $cont_video->title; ?></h6>
                    <?php } ?>

                    <?php if($ThumbnailSetting->age == 1) { ?>
                    <div class="badge badge-secondary"><?php echo $cont_video->age_restrict.' '.'+' ?></div>
                    <?php } ?>
                </div>
                <div class="movie-time my-2">
                  

                    <!-- Duration -->

                    <?php if($ThumbnailSetting->duration == 1) { ?>
                    <span class="text-white">
                        <i class="fa fa-clock-o"></i>
                        <?= gmdate('H:i:s', $cont_video->duration); ?>
                    </span>
                    <?php } ?>

                    <!-- Rating -->

                    <?php if($ThumbnailSetting->rating == 1 && $cont_video->rating != null) { ?>
                    <span class="text-white">
                        <i class="fa fa-star-half-o" aria-hidden="true"></i>
                        <?php echo __($cont_video->rating); ?>
                    </span>
                    <?php } ?>

                    <?php if($ThumbnailSetting->featured == 1 && $cont_video->featured == 1) { ?>
                    <!-- Featured -->
                    <span class="text-white">
                        <i class="fa fa-flag" aria-hidden="true"></i>
                    </span>
                    <?php }?>
                </div>

                <div class="movie-time my-2">
                    <!-- published_year -->

                    <?php  if ( ($ThumbnailSetting->published_year == 1) &&  ( $cont_video->year != null ) ) { ?>
                    <span class="text-white">
                        <i class="fa fa-calendar" aria-hidden="true"></i>
                        <?php echo __($cont_video->year); ?>
                    </span>
                    <?php } ?>
                </div>

                <div class="movie-time my-2">
                    <!-- Category Thumbnail  setting -->
                    <?php
                    $CategoryThumbnail_setting =  App\CategoryVideo::join('video_categories','video_categories.id','=','categoryvideos.category_id')
                                ->where('categoryvideos.video_id',$cont_video->id)
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
        </div>
        <?php                     
                        endforeach; 
                                   endif; ?>
    </div>
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

<!-- Flickity Slider -->
<script>
    var elem = document.querySelector('.continue-watching');
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
<?php  if(count($livetream) > 0) : ?>
<div class="iq-main-header d-flex align-items-center justify-content-between">
    <h4 class="main-title">Live Videos</h4>
</div>
<div class="favorites-contens">
    <ul class="favorites-slider list-inline row p-0 mb-0">
        <?php  if(isset($livetream)) :
                         foreach($livetream as $video): ?>
        <!-- .@$video->categories->name. -->
        <li class="slide-item">
            <a href="<?= URL::to('/') ?><?= '/live'.'/' . $video->slug ?>">
                <!-- block-images -->
                <div class="block-images position-relative">
                    <div class="img-box">
                        <a href="<?= URL::to('/') ?><?= '/live'.'/' . $video->slug ?>">
                            <img src="<?php echo URL::to('/').'/public/uploads/images/'.$video->image;  ?>" class="img-fluid img-zoom" alt="" />
                        </a>
                    </div>
                </div>
                <div class="block-description" style="top: 40px !important;"></div>
               
                <div class="hover-buttons">
                    <div class="d-flex align-items-center justify-content-between">

                    <?php if($ThumbnailSetting->title == 1) { ?>
                        <a href="<?= URL::to('/') ?><?= '/live'.'/' . $video->slug ?>">
                            <span class="text-white"><?= (strlen($video->title) > 17) ? substr($video->title,0,18).'...' : $video->title; ?></span>
                        </a>
                    <?php } ?>

                     
                    </div>

                    <div class="movie-time my-2">
                        <!-- Duration -->
    
                        <?php if($ThumbnailSetting->duration == 1) { ?>
                        <span class="text-white">
                            <i class="fa fa-clock-o"></i>
                            <?= gmdate('H:i:s', $video->duration); ?>
                        </span>
                        <?php } ?>
    
                        <!-- Rating -->
    
                        <?php if($ThumbnailSetting->rating == 1 && $video->rating != null) { ?>
                        <span class="text-white">
                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                            <?php echo __($video->rating); ?>
                        </span>
                        <?php } ?>
    
                        <?php if($ThumbnailSetting->featured == 1 && $video->featured == 1) { ?>
                            <!-- Featured -->
                            <span class="text-white">
                                <i class="fa fa-flag" aria-hidden="true"></i>
                            </span>
                        <?php }?>
                    </div>
    
                    <div class="movie-time my-2">
                        <!-- published_year -->
    
                        <?php  if ( ($ThumbnailSetting->published_year == 1) && ( $video->year != null ) ) { ?>
                        <span class="text-white">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                            <?php echo __($video->year); ?>
                        </span>
                        <?php } ?>
                    </div>
                    <a href="<?= URL::to('/') ?><?= '/live'.'/' . $video->slug ?>">
                        <h6 class="epi-name text-white mb-0"><i class="fa fa-play" aria-hidden="true"></i> Live Now</h6>
                    </a>
                </div>
            </a>
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

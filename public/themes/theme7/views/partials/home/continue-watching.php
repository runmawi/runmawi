<?php  if(count($cnt_watching) > 0) : ?>
<?php  if(!Auth::guest() && !empty($data['password_hash'])) { 
   $id = Auth::user()->id ; } else { $id = 0 ; } ?>
<div class="iq-main-header d-flex align-items-center justify-content-between">
   <h4 class="main-title"><a href="<?php echo URL::to('continue-watching-list') ?>"><?php echo (__('Continue watching')); ?></a></h4>
   <h4 class="main-title"><a href="<?php echo URL::to('continue-watching-list') ?>"> <?php echo (__('View All')); ?></a> </h4>
</div>
<div class="favorites-contens">
   <ul class="favorites-slider list-inline  row p-0 mb-0">
      <?php  if(isset($cnt_watching)) :
         foreach($cnt_watching as $cont_video): 
          ?>
      <li class="slide-item">
         <div class="block-images position-relative">
            <!-- block-images -->
            <div class="border-bg">
               <div class="img-box">
                  <a class="playTrailer" href="<?php echo URL::to('category') ?><?= '/videos/' . $cont_video->slug ?>" aria-label="movie">
                     <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$cont_video->image;  ?>" class="img-fluid lazyload w-100" alt="img">
                  </a>
                  <!-- PPV price -->
                  <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>  
                  <?php if($cont_video->access == 'subscriber' ){ ?>
                     <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                     <?php }elseif($cont_video->access == 'registered'){?>
                        <p class="p-tag"><?php echo (__('Register Now')); ?></p>
                        <?php }elseif(!empty($cont_video->ppv_price)){?>
                  <p class="p-tag1"><?php echo $currency->symbol.' '.$cont_video->ppv_price; ?></p>
                  <?php }elseif( !empty($cont_video->global_ppv || !empty($cont_video->global_ppv) && $cont_video->ppv_price == null)){ ?>
                  <p class="p-tag1"><?php echo $cont_video->global_ppv.' '.$currency->symbol; ?></p>
                  <?php }elseif($cont_video->global_ppv == null && $cont_video->ppv_price == null ){ ?>
                  <p class="p-tag"><?php echo (__('Free')); ?></p>
                  <?php } ?>
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

 
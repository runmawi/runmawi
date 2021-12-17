<?php  if(count($livetream) > 0) : ?>
<div class="iq-main-header d-flex align-items-center justify-content-between">
                    <h4 class="main-title">Live Videos</h4>                      
                 </div>
                 <div class="favorites-contens">
                    <ul class="favorites-slider list-inline  row p-0 mb-0">
                         <?php  if(isset($livetream)) :
                         foreach($livetream as $video): ?>
                       <li class="slide-item">
                       <a href="<?= URL::to('/') ?><?= '/live'.'/'.@$video->categories->name.'/' . $video->slug ?>">
                          <a href="<?php echo URL::to('home') ?>">
                             <div class="block-images position-relative">
                                <div class="img-box">
                                <a href="<?= URL::to('/') ?><?= '/live'.'/'.@$video->categories->name.'/' . $video->slug ?>">
                                   <img src="<?php echo URL::to('/').'/public/uploads/images/'.$video->image;  ?>" class="img-fluid img-zoom" alt="">
                                 </a>      
                                 <div class="corner-text-wrapper">
                                        <div class="corner-text">
                                          <?php  if(!empty($video->ppv_price)){?>
                                          <p class="p-tag1"><?php echo $currency->symbol.' '.$video->ppv_price; ?></p>
                                          <?php }elseif($video->ppv_price == null ){ ?>
                                            <p class="p-tag"><?php echo "Free"; ?></p>
                                            <?php } ?>
                                        </div>
                                    </div>                 
                                </div>
                                <div class="block-description">
                                <a href="<?= URL::to('/') ?><?= '/live'.'/'.@$video->categories->name.'/' . $video->slug ?>">
                                <i class="ri-play-fill"></i>
                             </a>                       
                  <!-- <span style="color: white;"class="mywishlist <?php// if(isset($mywishlisted->id)): ?>active<?php //endif; ?>" data-authenticated="<?// !Auth::guest() ?>" data-videoid="<?// $watchlater_video->id ?>"><i style="color: white;" <?php //if(isset($mywishlisted->id)): ?> class="ri-heart-fill" <?php //else: ?> class="ri-heart-line" <?php //endif; ?> >Add to Watchlist</i></span> -->
                                    
                                   <div class="hover-buttons">
                                   <div class="d-flex align-items-center justify-content-between">
                                <a href="<?= URL::to('/') ?><?= '/live'.'/'.@$video->categories->name.'/' . $video->slug ?>">
                          <span class="text-white"><?= ucfirst($video->title); ?></span>
                             </a>                       
                       </div>
                       <a href="<?= URL::to('/') ?><?= '/live'.'/'.@$video->categories->name.'/' . $video->slug ?>">
                          <h6 class="epi-name text-white mb-0"><i class="fa fa-clock-o"></i> Live Now</h6>
                       </a>
                                   </div>
                                                    </div>
                              
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
       if($(this).data('authenticated')){
         $.post('<?= URL::to('mywishlist') ?>', { video_id : $(this).data('videoid'), _token: '<?= csrf_token(); ?>' }, function(data){});
         $(this).toggleClass('active');
         $(this).html("");
             if($(this).hasClass('active')){
              $(this).html('<i class="ri-heart-fill"></i>');
             }else{
               $(this).html('<i class="ri-heart-line"></i>');

             }
             
       } else {
         window.location = '<?= URL::to('login') ?>';
       }
     });

</script>
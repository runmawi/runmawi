<?php  if(count($cnt_watching) > 0) : ?>
  <?php  if(!empty($data['password_hash'])) { 
 $id = Auth::user()->id ; } else { $id = 0 ; } ?>
<div class="iq-main-header d-flex align-items-center justify-content-between">
<h4 class="main-title"><a href="<?php echo URL::to('home') ?>">Continue Watching</a></h4>                      
                 </div>
                 <div class="favorites-contens">
                    <ul class="favorites-slider list-inline  row p-0 mb-0">
                         <?php  if(isset($cnt_watching)) :
                         foreach($cnt_watching as $cont_video): 
                          ?>
                       <li class="slide-item">
                          <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $cont_video->slug ?>">
                             <div class="block-images position-relative">
                             <!-- block-images -->
                                <div class="img-box">
                                
                                   <!-- <img src="<?php echo URL::to('/').'/public/uploads/images/'.$cont_video->image;  ?>" class="img-fluid" alt=""> -->
                                   <video width="100%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$cont_video->image;  ?>"  data-play="hover" >
                                    <source src="<?php echo $cont_video->trailer;  ?>" type="video/mp4">
                                      </video>
                                     
                                     <div class="corner-text-wrapper">
                                        <div class="corner-text">
                                          <?php  if(!empty($cont_video->ppv_price)){?>
                                          <p class="p-tag1"><?php echo $currency->symbol.' '.$cont_video->ppv_price; ?></p>
                                          <?php }elseif( !empty($cont_video->global_ppv || !empty($cont_video->global_ppv) && $cont_video->ppv_price == null)){ ?>
                                            <p class="p-tag1"><?php echo $cont_video->global_ppv.' '.$currency->symbol; ?></p>
                                            <?php }elseif($cont_video->global_ppv == null && $cont_video->ppv_price == null ){ ?>
                                            <p class="p-tag"><?php echo "Free"; ?></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="block-description">
                                   <h6><?php echo __($cont_video->title); ?></h6>
                                   <div class="movie-time d-flex align-items-center">
                                      <div class="badge badge-secondary p-1 mr-2"><?php echo $cont_video->age_restrict.' '.'+' ?></div>
                                      <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $cont_video->duration); ?></span>
                                   </div>
                                    
                                    
                                    
                                    <div class="hover-buttons text-white">
                                        <a class="text-white" href="<?php echo URL::to('category') ?><?= '/videos/' . $cont_video->slug ?>" >
                                            <i class="fa fa-play mr-1" aria-hidden="true"></i>Watch Now
                                        </a>
                                        <div>
                                    <!-- <a   href="<?php  // echo URL::to('category') ?><?  // '/wishlist/' . $cont_video->slug ?>" class="text-white mt-4"><i class="fa fa-plus" aria-hidden="true"></i> Add to Watchlist -->
                                    <!-- </a> -->
                                    
                                            <!-- <div class="d-flex" style="color:white;" id="<?= $cont_video->id ?>">
                                                <span style="color: white;"class="mywishlist <?php // if(isset($mywishlisted->id)): ?>active<?php //endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $cont_video->id ?>">
                                    <i style="" <?php // if(isset($mywishlisted->id)): ?> class="ri-heart-fill" <?php //else: ?> class="ri-heart-line " <?php // endif; ?> style="" ></i>

                                                </span>
                                              <div style="color:white;" id="<?= $cont_video->id ?>"><?php // if(@$cont_video->mywishlisted->user_id == $id && @$watchlater_video->cont_video->video_id == $cont_video->id  ) { echo "Remove From Wishlist"; } else { echo "Add To Wishlist" ; } ?></div> 

                                            </div>  -->
                                        </div>
                                    </div>
                                </div>
                              </div>
                          </a>
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
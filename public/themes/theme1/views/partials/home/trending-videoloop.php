
  
<div class="iq-main-header d-flex align-items-center justify-content-between">
                    <h4 class="main-title"><a href="<?php echo URL::to('/latest-videos') ?>">Featured Movies</a></h4>                      
                 </div>
                 <div class="favorites-contens">
                    <ul class="favorites-slider list-inline  row p-0 mb-0">
                         <?php  if(isset($featured_videos)) :
                      if(!empty($data['password_hash'])) { 
                          $id = Auth::user()->id ; } else { $id = 0 ; } 
                         foreach($featured_videos as $watchlater_video): 
                          ?>
                       <li class="slide-item">
                          <a href="<?php echo URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>">
                             <!-- block-images -->
                             <div class="block-images position-relative">
                                <div class="img-box">
                                   <video width="100%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>"  data-play="hover" >
                                    <source src="<?php echo $watchlater_video->trailer;  ?>" type="video/mp4">
                                      </video>
                                 </div>
                              </div>
                                        <div class="block-description">
                                            
                                            <div class="hover-buttons">
                                            <a class="text-white" href="<?php echo URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>" >

                                                                                         <img class="ply" src="<?php echo URL::to('/').'/assets/img/play.svg';  ?>">                                        </a>

                                            <div class="d-flex">
                                            <!-- <a   href="<?php //echo URL::to('category') ?><? // '/wishlist/' . $cont_video->slug ?>" class="text-white mt-4"><i class="fa fa-plus" aria-hidden="true"></i> Add to Watchlist -->
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
                              <div>
                                  <h6><?php  echo (strlen($watchlater_video->title) > 19) ? substr($watchlater_video->title,0,20).'...' : $watchlater_video->title; ?></h6>
                                            <div class="movie-time d-flex align-items-center my-2">
                                                <div class="badge badge-secondary p-1 mr-2"><?php echo $watchlater_video->age_restrict.' '.'+' ?></div>
                                                <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $watchlater_video->duration); ?></span>
                                            </div>

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
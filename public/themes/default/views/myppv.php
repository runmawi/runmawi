<?php include ('header.php'); ?>

<section id="iq-favorites">
        <div class="fluid">
           <div class="row">
<?php if (count($ppv) > 0 ||  count($ppvlive) > 0): ?>
  <div class="col-sm-12 overflow-hidden">

<div class="iq-main-header d-flex align-items-center justify-content-between">
                    <h4 class="main-title"><a href="#">Rental Videos</a></h4>                      
                 </div>
                 <div class="favorites-contens">
                    <ul class="favorites-slider list-inline  row p-0 mb-0">
                         <?php 
                         if (isset($ppv)):
        foreach ($ppv as $watchlater_video):
?>
                       <li class="slide-item">
                          <a href="<?php echo URL::to('home') ?>">
                             <div class=" position-relative">
                                <div class="img-box">
                                <a  href="<?php echo URL::to('category') ?><?='/videos/' . $watchlater_video->slug ?>">
                                   <!-- <img src="<?php echo URL::to('/') . '/public/uploads/images/' . $watchlater_video->player_image; ?>" class="img-fluid" alt=""> -->
                                   <video width="100%" height="auto" class="play-video" poster="<?php echo URL::to('/') . '/public/uploads/images/' . $watchlater_video->player_image; ?>"  data-play="hover" >
                                    <source src="<?php echo $watchlater_video->trailer; ?>" type="video/mp4">
                                      </video>
                                     </a>
                                   
                                          <?php if (!empty($watchlater_video->ppv_price))
            { ?>
                                          <p class="p-tag1"><?php echo $currency->symbol . ' ' . $watchlater_video->ppv_price; ?></p>
                                          <?php
            }
            elseif (!empty($watchlater_video->global_ppv || !empty($watchlater_video->global_ppv) && $watchlater_video->ppv_price == null))
            { ?>
                                            <p class="p-tag1"><?php echo $watchlater_video->global_ppv . ' ' . $currency->symbol; ?></p>
                                            <?php
            }
            elseif ($watchlater_video->global_ppv == null && $watchlater_video->ppv_price == null)
            { ?>
                                            <p class="p-tag"><?php echo "Free"; ?></p>
                                            <?php
            } ?>
                                      
                                </div>
                                <div class="block-description">
                                    <a  href="<?php echo URL::to('category') ?><?='/videos/' . $watchlater_video->slug ?>">
                                   <h6><?php echo __($watchlater_video->title); ?></h6>
                                    </a>
                                   <div class="movie-time d-flex align-items-center my-2">
                                      <div class="badge badge-secondary p-1 mr-2"><?php echo $watchlater_video->age_restrict ?></div>
                                      <span class="text-white"><i class="fa fa-clock-o"></i> <?=gmdate('H:i:s', $watchlater_video->duration); ?></span>
                                   </div>
                                    
                                    
                                    
                                   <div class="hover-buttons d-flex">
                                       <a class="text-white" href="<?php echo URL::to('category') ?><?='/videos/' . $watchlater_video->slug ?>" >
                                    
                                      <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                      Watch Now
                                      
                                       </a>
                                       <div >
                                    <!-- <a style="color: white;"class="mywishlist <?php // if(isset($mywishlisted->id)): ?>active<?php //endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $watchlater_video->id ?>">
                                        <i style="" <?php //if(isset($watchlater_video->id)): ?> class="ri-heart-fill" <?php //else: ?> class="ri-heart-line " <?php //endif; ?> style="" ></i>
                                    <div style="color:white;" id="<?= $watchlater_video->id ?>">
                                        <?php // if(@$watchlater_video->mywishlisted->user_id == Auth::user()->id && @$watchlater_video->mywishlisted->video_id == $watchlater_video->id  ) { echo "Remove From Wishlist"; } 
                                       // else { echo "Add To Wishlist" ; } ?>
                                    </div> 
                                    </a> -->
                                    </div>
                              
                             </div>
                          </a>
                       </li>
                       <?php
        endforeach;
    endif; ?>
                    </ul>
                 </div>
                 <?php
 ?>
                 </div>
           </div>
        </div>




      
  <div class="col-sm-12 overflow-hidden">

<div class="iq-main-header d-flex align-items-center justify-content-between">
                    <h4 class="main-title"><a href="#">Rental Live Videos</a></h4>                      
                 </div>
                 <div class="favorites-contens">
                    <ul class="favorites-slider list-inline  row p-0 mb-0">
                         <?php if (isset($ppvlive)):
        foreach ($ppvlive as $watchlater_video):
?>
                       <li class="slide-item">
                          <a href="<?php echo URL::to('home') ?>">
                             <div class=" position-relative">
                                <div class="img-box">
                                <a  href="<?php echo URL::to('category') ?><?='/videos/' . $watchlater_video->slug ?>">
                                   <!-- <img src="<?php echo URL::to('/') . '/public/uploads/images/' . $watchlater_video->player_image; ?>" class="img-fluid" alt=""> -->
                                   <video width="100%" height="auto" class="play-video" poster="<?php echo URL::to('/') . '/public/uploads/images/' . $watchlater_video->player_image; ?>"  data-play="hover" >
                                    <source src="<?php echo $watchlater_video->trailer; ?>" type="video/mp4">
                                      </video>
                                     </a>
                                     <div class="corner-text-wrapper">
                                        <div class="corner-text">
                                          <?php if (!empty($watchlater_video->ppv_price))
            { ?>
                                          <p class="p-tag1"><?php echo $currency->symbol . ' ' . $watchlater_video->ppv_price; ?></p>
                                          <?php
            }
            elseif (!empty($watchlater_video->global_ppv || !empty($watchlater_video->global_ppv) && $watchlater_video->ppv_price == null))
            { ?>
                                            <p class="p-tag1"><?php echo $watchlater_video->global_ppv . ' ' . $currency->symbol; ?></p>
                                            <?php
            }
            elseif ($watchlater_video->global_ppv == null && $watchlater_video->ppv_price == null)
            { ?>
                                            <p class="p-tag"><?php echo "Free"; ?></p>
                                            <?php
            } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="block-description">
                                    <a  href="<?php echo URL::to('category') ?><?='/videos/' . $watchlater_video->slug ?>">
                                   <h6><?php echo __($watchlater_video->title); ?></h6>
                                    </a>
                                   <div class="movie-time d-flex align-items-center my-2">
                                      <div class="badge badge-secondary p-1 mr-2"><?php echo $watchlater_video->age_restrict ?></div>
                                      <span class="text-white"><i class="fa fa-clock-o"></i> <?=gmdate('H:i:s', $watchlater_video->duration); ?></span>
                                   </div>
                                    
                                    
                                    
                                   <div class="hover-buttons">
                                       <a class="text-white" href="<?php echo URL::to('category') ?><?='/videos/' . $watchlater_video->slug ?>" >
                                    
                                      <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                      Watch Now
                                      
                                       </a>
                                       <div class="hover-buttons">
                          <span style="color: white;"class="livemywishlist <?php if (isset($mywishlisted->id)): ?>active<?php
            endif; ?>" data-authenticated="<?=!Auth::guest() ?>" data-videoid="<?=$watchlater_video->id ?>"><i style="" <?php if (isset($mywishlisted->id)): ?> class="ri-heart-fill" <?php
            else: ?> class="ri-heart-line " <?php
            endif; ?> style="" ></i><span id="addwatchlist"> Add to Watchlist </span> </span>

                                    </div>
                              
                             </div>
                          </a>
                       </li>
                       <?php
        endforeach;
    endif; 
   else:
   ?>
   <p><h2>No Rented in Video</h2></p>
                 <div class="col-md-12 text-center mt-4">
             <img class="w-50" src="<?php echo  URL::to('/assets/img/sub.png')?>">
         </div>
                    </ul>
                 </div>
                 <?php
endif; ?>
                 </div>
           </div>
        </div>
        </div>

</section>
            <style>
              .i{
                text-decoration: none;
                text-decoration-line: none;
                text-decoration-style: initial;
                text-decoration-color: initial;
                outline-color: initial;
                outline-style: none;
                outline-width: medium;
                outline: medium none;
              }
            </style>


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
<?php include ('footer.blade.php'); ?>

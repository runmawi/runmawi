
  
<div class="iq-main-header d-flex align-items-center justify-content-between">
                    <h4 class="main-title">
<a href="<?php if ($order_settings_list[0]->header_name) { echo URL::to('/').'/'.$order_settings_list[0]->url ;} else { echo "" ; } ?>">                   
  <?php if ($order_settings_list[0]->header_name) { echo $order_settings_list[0]->header_name ;} else { echo "" ; } ?>
                    <!-- Featured Movies -->
                  </a></h4>                      
                 </div>
                 <div class="favorites-contens">
                    <ul class="favorites-slider list-inline  row p-0 mb-0">
                         <?php  if(isset($featured_videos)) :
                      if(!Auth::guest() && !empty($data['password_hash'])) { 
                          $id = Auth::user()->id ; } else { $id = 0 ; } 
                         foreach($featured_videos as $watchlater_video): 

                          if (!empty($watchlater_video->publish_time) && !empty($watchlater_video->publish_time))
                          {
                            $currentdate = date("M d , y H:i:s");
                            date_default_timezone_set('Asia/Kolkata');
                            $current_date = Date("M d , y H:i:s");
                            $date = date_create($current_date);
                            $currentdate = date_format($date, "D h:i");
                            $publish_time = date("D h:i", strtotime($watchlater_video->publish_time));
                            if ($watchlater_video->publish_type == 'publish_later')
                            {
                                if ($currentdate < $publish_time)
                                {
                                  $publish_time = date("D h:i", strtotime($watchlater_video->publish_time));
                                }else{
                                  $publish_time = 'Published';
                                }
                            }
                            elseif ($watchlater_video->publish_type == 'publish_now')
                            {
                              $currentdate = date_format($date, "y M D");

                              $publish_time = date("y M D", strtotime($watchlater_video->publish_time));

                                if ($currentdate == $publish_time)
                                {
                                  $publish_time = 'Today'.' '.date("h:i", strtotime($watchlater_video->publish_time));
                                }else{
                                  $publish_time = 'Published';
                                }
                            }else{
                              $publish_time = '';
                          }
                          }else{
                              $publish_time = '';
                          }
                          
                          ?>
                       <li class="slide-item">
                         <div class="block-images position-relative">
                         
                             <!-- block-images -->
                             <div class="border-bg">
                                <div class="img-box">
                                <a class="playTrailer" href="<?php echo URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>" aria-label="Trending">
                                <img alt="f-img" loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>"
                                        class="img-fluid loading w-100" alt=""> 
                        </a>
                                
                                       
                                     <!-- PPV price -->
                                        
                                                <!-- <p class="p-tag" style=""><?php //echo $watchlater_video->ppv_price ; ?></p> -->
                                        <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>          
                                                <?php  if($watchlater_video->access == 'subscriber' ){ ?>
                                                  <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                                            <?php }elseif(!empty($watchlater_video->ppv_price)){?>
                                          <p class="p-tag1"><?php echo $currency->symbol.' '.$watchlater_video->ppv_price; ?></p>
                                          <?php }elseif( !empty($watchlater_video->global_ppv || !empty($watchlater_video->global_ppv) && $watchlater_video->ppv_price == null)){ ?>
                                            <p class="p-tag1"><?php echo $watchlater_video->global_ppv.' '.$currency->symbol; ?></p>
                                            <?php }elseif($watchlater_video->global_ppv == null && $watchlater_video->ppv_price == null ){ ?>
                                            <p class="p-tag"><?php echo "Free"; ?></p>
                                            <?php } ?>
                                        <?php } ?>

                                        <?php if($ThumbnailSetting->published_on == 1) { ?>                                            
                                        <p class="published_on1"><?php echo $publish_time; ?></p>
                                    <?php  } ?>
                                            </div>
                                        </div>

                                        <div class="block-description">
                                        <a class="playTrailer" href="<?php echo URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>" aria-label="Trending">
                                <img alt="f-img" loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->player_image;  ?>"
                                        class="img-fluid loading w-100" alt=""> 
                        
                                
                                       
                                     <!-- PPV price -->
                                        
                                                <!-- <p class="p-tag" style=""><?php //echo $watchlater_video->ppv_price ; ?></p> -->
                                        <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>          
                                                <?php  if($watchlater_video->access == 'subscriber' ){ ?>
                                                  <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                                            <?php }elseif(!empty($watchlater_video->ppv_price)){?>
                                          <p class="p-tag1"><?php echo $currency->symbol.' '.$watchlater_video->ppv_price; ?></p>
                                          <?php }elseif( !empty($watchlater_video->global_ppv || !empty($watchlater_video->global_ppv) && $watchlater_video->ppv_price == null)){ ?>
                                            <p class="p-tag1"><?php echo $watchlater_video->global_ppv.' '.$currency->symbol; ?></p>
                                            <?php }elseif($watchlater_video->global_ppv == null && $watchlater_video->ppv_price == null ){ ?>
                                            <p class="p-tag"><?php echo "Free"; ?></p>
                                            <?php } ?>
                                        <?php } ?>
                                        </a>
                                        <!-- PPV price -->
                                        
                                                <!-- <p class="p-tag" style=""><?php //echo $watchlater_video->ppv_price ; ?></p> -->
                                                <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?>          
                                                <?php  if($watchlater_video->access == 'subscriber' ){ ?>
                                                  <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                                            <?php }elseif(!empty($watchlater_video->ppv_price)){?>
                                          <p class="p-tag1"><?php echo $currency->symbol.' '.$watchlater_video->ppv_price; ?></p>
                                          <?php }elseif( !empty($watchlater_video->global_ppv || !empty($watchlater_video->global_ppv) && $watchlater_video->ppv_price == null)){ ?>
                                            <p class="p-tag1"><?php echo $watchlater_video->global_ppv.' '.$currency->symbol; ?></p>
                                            <?php }elseif($watchlater_video->global_ppv == null && $watchlater_video->ppv_price == null ){ ?>
                                            <p class="p-tag"><?php echo "Free"; ?></p>
                                            <?php } ?>
                                        <?php } ?>
                                        
                                        
                                        <div class="hover-buttons text-white">
                                        <a href="<?php echo URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>" aria-label="Trending">
                                        <?php if($ThumbnailSetting->title == 1) { ?> 
                                                     <!-- Title -->
                                                     <p class="epi-name text-left m-0">
                                                      <?php  echo (strlen($watchlater_video->title) > 17) ? substr($watchlater_video->title,0,18).'...' : $watchlater_video->title; ?></p>
                                        <?php } ?>

                                        <div class="movie-time d-flex align-items-center pt-1">
                                          <?php if($ThumbnailSetting->age == 1) { ?>
                                          <!-- Age -->
                                          <div class="badge badge-secondary p-1 mr-2"><?php echo $watchlater_video->age_restrict.' '.'+' ?></div>
                                          <?php } ?>

                                          <?php if($ThumbnailSetting->duration == 1) { ?>
                                          <!-- Duration -->
                                          <span class="text-white">
                                              <i class="fa fa-clock-o"></i>
                                              <?= gmdate('H:i:s', $watchlater_video->duration); ?>
                                          </span>
                                          <?php } ?>
                                        </div>  

                                  <?php if(($ThumbnailSetting->published_year == 1) || ($ThumbnailSetting->rating == 1)) {?>
                                    <div class="movie-time d-flex align-items-center pt-1">
                                        <?php if($ThumbnailSetting->rating == 1) { ?>
                                        <!--Rating  -->
                                        <div class="badge badge-secondary p-1 mr-2">
                                            <span class="text-white">
                                                <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                <?php echo __($watchlater_video->rating); ?>
                                            </span>
                                        </div>
                                        <?php } ?>

                                        <?php if($ThumbnailSetting->published_year == 1) { ?>
                                        <!-- published_year -->
                                        <div class="badge badge-secondary p-1 mr-2">
                                          <span class="text-white">
                                              <i class="fa fa-calendar" aria-hidden="true"></i>
                                              <?php echo __($watchlater_video->year); ?>
                                          </span>
                                        </div>
                                        <?php } ?>

                                        <?php if($ThumbnailSetting->featured == 1 && $watchlater_video->featured == 1) { ?>
                                          <!-- Featured -->
                                          <div class="badge badge-secondary p-1 mr-2">
                                            <span class="text-white">
                                            <i class="fa fa-flag-o" aria-hidden="true"></i>
                                            </span>
                                          </div>
                                          <?php }?>
                                      </div>
                                  <?php } ?>  

                                  <div class="movie-time d-flex align-items-center pt-1">
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


                                            
                                            <a class="epi-name mt-3 mb-0 btn" href="<?php echo URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>" >
                                                <img class="d-inline-block ply" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>"  width="10%" height="10%"/> Watch Now
                                            </a>
                                            </div>
                                            </div>
                                            </div>
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
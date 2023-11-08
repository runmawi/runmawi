<div class="iq-main-header d-flex align-items-center justify-content-between">
  <h4 class="main-title"><?php echo (__('Recently Added Episodes')); ?></h4>                      
</div>
<?php
      $ThumbnailSetting = App\ThumbnailSetting::first();
?>
<div class="favorites-contens">
  <ul class="favorites-slider list-inline  row p-0 mb-0">
    <?php  if(isset($latest_episodes)) :
    					 foreach($latest_episodes as $key => $latest_episode) {
        // foreach($latest_series as $latest_serie) { 
?>
        <li class="slide-item">
          <div class="block-images position-relative">
          
                             <!-- block-images -->
            <div class="border-bg">
              <div class="img-box">
              <a class="playTrailer" href="<?php if($latest_episode->series_id == @$latest_episode->series_title->id){ echo URL::to('/episode'.'/'.@$latest_episode->series_title->slug.'/'.$latest_episode->slug) ; }?> ">
                <img data-src="<?php echo URL::to('/').'/public/uploads/images/'.$latest_episode->image;  ?>" class="img-fluid lazyload w-100" alt="episode">
              </a>


                <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?> 
                    <?php  if(!empty($latest_episode->ppv_price == 1)){?>
                    <p class="p-tag1"><?php echo $currency->symbol.' '.$latest_episode->ppv_price; ?></p>
                    <?php }elseif( !empty($latest_episode->ppv_status || !empty($latest_episode->ppv_status) && $latest_episode->ppv_price == 1)){ ?>
                      <p class="p-tag1"><?php echo $latest_episode->ppv_status.' '.$currency->symbol; ?></p>
                      <?php }elseif($latest_episode->ppv_status == null && $latest_episode->ppv_price == null ){ ?>
                      <p class="p-tag"><?php echo (__('Free')); ?></p>
                      <?php } ?>
                    <?php } ?>
              </div>
              </div>

              <div class="block-description">
              <a class="playTrailer" href="<?php if($latest_episode->series_id == @$latest_episode->series_title->id){ echo URL::to('/episode'.'/'.@$latest_episode->series_title->slug.'/'.$latest_episode->slug) ; }?> ">
                <img data-src="<?php echo URL::to('/').'/public/uploads/images/'.$latest_episode->player_image;  ?>" class="img-fluid lazyload w-100" alt="episode">
              


                <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?> 
                    <?php  if(!empty($latest_episode->ppv_price == 1)){?>
                    <p class="p-tag1"><?php echo $currency->symbol.' '.$latest_episode->ppv_price; ?></p>
                    <?php }elseif( !empty($latest_episode->ppv_status || !empty($latest_episode->ppv_status) && $latest_episode->ppv_price == 1)){ ?>
                      <p class="p-tag1"><?php echo $latest_episode->ppv_status.' '.$currency->symbol; ?></p>
                      <?php }elseif($latest_episode->ppv_status == null && $latest_episode->ppv_price == null ){ ?>
                      <p class="p-tag"><?php echo (__('Free')); ?></p>
                      <?php } ?>
                    <?php } ?>
                </a>
                <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?> 
                    <?php  if(!empty($latest_episode->ppv_price == 1)){?>
                    <p class="p-tag1"><?php echo $currency->symbol.' '.$latest_episode->ppv_price; ?></p>
                    <?php }elseif( !empty($latest_episode->ppv_status || !empty($latest_episode->ppv_status) && $latest_episode->ppv_price == 1)){ ?>
                      <p class="p-tag1"><?php echo $latest_episode->ppv_status.' '.$currency->symbol; ?></p>
                      <?php }elseif($latest_episode->ppv_status == null && $latest_episode->ppv_price == null ){ ?>
                      <p class="p-tag"><?php echo (__('Free')); ?></p>
                      <?php } ?>
                    <?php } ?>

                <div class="hover-buttons text-white">
              <a href="<?php if($latest_episode->series_id == @$latest_episode->series_title->id){ echo URL::to('/episode'.'/'.@$latest_episode->series_title->slug.'/'.$latest_episode->slug) ; }?> ">
                 
              <p class="epi-name text-left m-0"><?php echo __($latest_episode->title); ?></p>
               
                <div class="movie-time d-flex align-items-center my-2">
                  <div class="badge badge-secondary p-1 mr-2"><?php echo $latest_episode->age_restrict.' '.'+' ?></div>
                 <!-- <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $latest_episode->duration); ?></span>-->
                </div>
                </a>

                
                <a class="epi-name mt-3 mb-0 btn" href="<?php if($latest_episode->series_id == @$latest_episode->series_title->id){ echo URL::to('/episode'.'/'.@$latest_episode->series_title->slug.'/'.$latest_episode->slug) ; }?> ">
                    <i class="fa fa-play mr-1" aria-hidden="true"></i>
                   Watch Series
                  </a>
                </div>
              </div>
            </div>
        </li>
      <?php  } 
      // }
    endif; ?>
  </ul>
</div>
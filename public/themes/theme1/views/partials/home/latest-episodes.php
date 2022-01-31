<div class="iq-main-header d-flex align-items-center justify-content-between">
  <h4 class="main-title">Recently Added Episodes</h4>                      
</div>
<?php
?>
<div class="favorites-contens">
  <ul class="favorites-slider list-inline  row p-0 mb-0">
    <?php  if(isset($latest_episodes)) :
    					 foreach($latest_episodes as $key => $latest_episode) {
        // foreach($latest_series as $latest_serie) { 
?>
        <li class="slide-item">
          <a href="<?php if($latest_episode->series_id == @$latest_episode->series_title->id){ echo URL::to('/episode'.'/'.@$latest_episode->series_title->title.'/'.$latest_episode->slug) ; }?> ">
                             <!-- block-images -->
            <div class="block-images position-relative">
              <div class="img-box">
                <img src="<?php echo URL::to('/').'/public/uploads/images/'.$latest_episode->image;  ?>" class="img-fluid w-100" alt="">
                <div class="corner-text-wrapper">
                  <div class="corner-text">
                    <?php  if(!empty($latest_episode->ppv_price)){?>
                    <p class="p-tag1"><?php echo $currency->symbol.' '.$latest_episode->ppv_price; ?></p>
                    <?php }elseif( !empty($latest_episode->ppv_status || !empty($latest_episode->ppv_status) && $latest_episode->ppv_price == null)){ ?>
                      <p class="p-tag1"><?php echo $latest_episode->ppv_status.' '.$currency->symbol; ?></p>
                      <?php }elseif($latest_episode->ppv_status == null && $latest_episode->ppv_price == null ){ ?>
                      <p class="p-tag"><?php echo "Free"; ?></p>
                      <?php } ?>
                  </div>
              </div>
              </div></div>
              <div class="block-description">
              
                <div class="hover-buttons d-flex">
                <a class="text-white btnk" href="<?php if($latest_episode->series_id == @$latest_episode->series_title->id){ echo URL::to('/episode'.'/'.@$latest_episode->series_title->title.'/'.$latest_episode->slug) ; }?> ">
                    <i class="fa fa-play mr-1" aria-hidden="true"></i>
                  
                  </a>
                </div>
              </div>
              <div>
                  <a href="<?php if($latest_episode->series_id == @$latest_episode->series_title->id){ echo URL::to('/episode'.'/'.@$latest_episode->series_title->title.'/'.$latest_episode->slug) ; }?> ">
                  <h6><?php echo __($latest_episode->title); ?></h6>
                </a>
                <div class="movie-time d-flex align-items-center my-2">
                  <div class="badge badge-secondary p-1 mr-2"><?php echo $latest_episode->age_restrict.' '.'+' ?></div>
                  <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $latest_episode->duration); ?></span>
                </div>
            </div>
          </a>
        </li>
      <?php  } 
      // }
    endif; ?>
  </ul>
</div>
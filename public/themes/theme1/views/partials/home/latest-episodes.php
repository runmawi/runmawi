<?php  if(isset($latest_episodes)) : ?>
<div class="iq-main-header d-flex align-items-center justify-content-between">
  <h4 class="main-title"><?= (__('Recently Added Episodes'))  ?></h4>                      
</div>
<?php  endif; ?>
<div class="favorites-contens">
  <ul class="favorites-slider list-inline  row p-0 mb-0">
    <?php  if(isset($latest_episodes)) :
    					 foreach($latest_episodes as $key => $latest_episode) {
        // foreach($latest_series as $latest_serie) { 
?>
        <li class="slide-item">
          <a href="<?php if($latest_episode->series_id == @$latest_episode->series_title->id){ echo URL::to('/episode'.'/'.@$latest_episode->series_title->slug.'/'.$latest_episode->slug) ; }?> ">
                             <!-- block-images -->
            <div class="block-images position-relative">
              <div class="img-box">
                <img src="<?php echo URL::to('/').'/public/uploads/images/'.$latest_episode->image;  ?>" class="img-fluid w-100" alt="">
                
              </div>
              <div class="block-description">
              
                <div class="hover-buttons d-flex">
                <a class="text-white " href="<?php if($latest_episode->series_id == @$latest_episode->series_title->id){ echo URL::to('/episode'.'/'.@$latest_episode->series_title->slug.'/'.$latest_episode->slug) ; }?> ">
                    <i class="fa fa-play mr-1"></i> <?= __('Watch Now') ?> 
                  
                  </a>
                </div>
              </div>
            </div>
              
              <div>
                  
                <div class="movie-time d-flex align-items-center justify-content-between my-2">
                    <a href="<?php if($latest_episode->series_id == @$latest_episode->series_title->id){ echo URL::to('/episode'.'/'.@$latest_episode->series_title->slug.'/'.$latest_episode->slug) ; }?> ">
                  <h6><?php echo __($latest_episode->title); ?></h6>
                </a>
                  <div class="badge badge-secondary p-1 mr-2"><?php echo $latest_episode->age_restrict.' '.'+' ?></div>
                </div>
                                    <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $latest_episode->duration); ?></span>

            </div>
          </a>
        </li>
      <?php  } 
      // }
    endif; ?>
  </ul>
</div>
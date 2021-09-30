<div class="iq-main-header d-flex align-items-center justify-content-between">
  <h4 class="main-title">Latest Episodes</h4>                      
</div>
<?php
?>
<div class="favorites-contens">
  <ul class="favorites-slider list-inline  row p-0 mb-0">
    <?php  if(isset($latest_episodes)) :
    					 foreach($latest_episodes as $key => $latest_episode) {
        foreach($latest_series as $latest_serie) { 
?>
        <li class="slide-item">
          <a href="<?php if($latest_episode->series_id == $latest_serie->id){ echo URL::to('/episode'.'/'.$latest_serie->title.'/'.$latest_episode->title) ?>/<?= $latest_episode->id ; } ?>">
            <div class="block-images position-relative">
              <div class="img-box">
                <img src="<?php echo URL::to('/').'/public/uploads/images/'.$latest_episode->image;  ?>" class="img-fluid" alt="">
              </div>
              <div class="block-description">
              <a href="<?php if($latest_episode->series_id == $latest_serie->id){ echo URL::to('/episode'.'/'.$latest_serie->title.'/'.$latest_episode->title) ?>/<?= $latest_episode->id ; } ?>">
                  <h6><?php echo __($latest_episode->title); ?></h6>
                </a>
                <div class="movie-time d-flex align-items-center my-2">
                  <div class="badge badge-secondary p-1 mr-2">13+</div>
                  <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $latest_episode->duration); ?></span>
                </div>
                <div class="hover-buttons">
                <a href="<?php if($latest_episode->series_id == $latest_serie->id){ echo URL::to('/episode'.'/'.$latest_serie->title.'/'.$latest_episode->title) ?>/<?= $latest_episode->id ; } ?>">
                    <i class="fa fa-play mr-1" aria-hidden="true"></i>
                    Play Now
                  </a>
                </div>
              </div>
            </div>
          </a>
        </li>
      <?php  } }
    endif; ?>
  </ul>
</div>
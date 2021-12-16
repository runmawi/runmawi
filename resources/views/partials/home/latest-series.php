<style>
    .block-description {position: absolute; left:20px; top: 50px!important; bottom: 0;z-index: 999; display: flex; justify-content: center; flex-direction: column; opacity: 0;font-size: 12px; }

</style>
<div class="iq-main-header d-flex align-items-center justify-content-between">
  <h4 class="main-title">Latest Series</h4>                      
</div>
<div class="favorites-contens">
  <ul class="favorites-slider list-inline  row p-0 mb-0">
    <?php  if(isset($latest_series)) :
      foreach($latest_series as $latest_serie): ?>
        <li class="slide-item">
          <a href="<?php echo URL::to('/play_series'.'/'.$latest_serie->title ) ?>">
            <div class="block-images position-relative">
              <div class="img-box">
                <img src="<?php echo URL::to('/').'/public/uploads/images/'.$latest_serie->image;  ?>" class="img-fluid" alt="">
              </div>
              <div class="block-description">
                <a href="<?php echo URL::to('/play_series'.'/'.$latest_serie->title) ?> ">

              <h6><?php echo __($latest_serie->title); ?></h6>
                </a>
                <div class="movie-time d-flex align-items-center my-2">
                  <div class="badge badge-secondary p-1 mr-2">13+</div>
                  <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $latest_serie->duration); ?></span>
                </div>
                <div class="hover-buttons">
                  <a class="text-white" href="<?php echo URL::to('/play_series'.'/'.$latest_serie->title) ?> " >
                    <i class="fa fa-play mr-1" aria-hidden="true"></i>
                   Watch Series
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
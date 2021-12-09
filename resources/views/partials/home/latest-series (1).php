<?php  if(count($latest_series) > 0) : ?>
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
              <a class="btn btn-primary btn-hover" href="<?php echo URL::to('/play_series'.'/'.$latest_serie->title) ?>" >
                <img src="<?php echo URL::to('/').'/public/uploads/images/'.$latest_serie->image;  ?>" class="img-fluid" alt="">
                </a>
              </div>
              <div class="block-description">
                <a href="<?php echo URL::to('/play_series'.'/'.$latest_serie->title) ?>">
                  <h6><?php echo __($latest_serie->title); ?></h6>
                </a>
                <div class="movie-time d-flex align-items-center my-2">
                  <div class="badge badge-secondary p-1 mr-2">13+</div>
                  <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $latest_serie->duration); ?></span>
                </div>
                <div class="hover-buttons">
                  <a class="btn btn-primary btn-hover" href="<?php echo URL::to('/play_series'.'/'.$latest_serie->title) ?>" >
                    <i class="fa fa-play mr-1" aria-hidden="true"></i>
                    Play Now
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
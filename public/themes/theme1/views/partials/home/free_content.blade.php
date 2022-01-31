<div class="iq-main-header d-flex align-items-center justify-content-between">
    <h4 class="main-title">Free Content Videos</h4>                      
  </div>
  <?php
  ?>
  <div class="favorites-contens">
    <ul class="favorites-slider list-inline  row p-0 mb-0">
      <?php  if(isset($free_episodes)) :
                           foreach($free_episodes as $key => $free_episode) {
          foreach($free_series as $free_serie) { 
  ?>
          <li class="slide-item">
            <a href="<?php if($free_episode->series_id == $free_serie->id){ echo URL::to('/episode'.'/'.$free_serie->title.'/'.$free_episode->title) ; }?> ">
              <div class="block-images position-relative">
                <div class="img-box">
                  <img src="<?php echo URL::to('/').'/public/uploads/images/'.$free_episode->image;  ?>" class="img-fluid w-100" alt="">
                </div></div>
                <div class="block-description">
                
                  <div class="hover-buttons">
                  <a class="text-white btnk" href="<?php if($free_episode->series_id == $free_serie->id){ echo URL::to('/episode'.'/'.$free_serie->title.'/'.$free_episode->title) ; }?> ">
                      <i class="fa fa-play mr-1" aria-hidden="true"></i>
                   
                    </a>
                  </div>
                </div>
                <div>
                    <a href="<?php if($free_episode->series_id == $free_serie->id){ echo URL::to('/episode'.'/'.$free_serie->title.'/'.$free_episode->title) ; }?> ">
                    <h6><?php echo __($free_episode->title); ?></h6>
                  </a>
                  <div class="movie-time d-flex align-items-center my-2">
                    <div class="badge badge-secondary p-1 mr-2"><?php echo $free_episode->age_restrict.' '.'+' ?></div>
                    <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $free_episode->duration); ?></span>
                  </div>
              </div>
            </a>
          </li>
        <?php  } }
      endif; ?>
    </ul>
  </div>
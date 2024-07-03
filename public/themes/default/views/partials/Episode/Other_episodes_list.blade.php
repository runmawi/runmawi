<div class="iq-main-header pl-3 ">
    <h4 class="main-title"><?= __('Episode') ?> </h4>
</div>

<div class="col-sm-12 overflow-hidden">
    <div class="favorites-contens">
        <div class="other-episode home-sec list-inline row mb-0 pl-0">
            <?php  
            $ThumbnailSetting = App\ThumbnailSetting::first();
      foreach($season as $key => $seasons):
         foreach($seasons->episodes as $key => $episodes):
             if($episodes->id != $episode->id): ?>

            <div class="items">
          <div class="block-images position-relative">

            <!-- block-images -->
            <div class="border-bg">
              <div class="img-box">
                <a class="playTrailer" href="<?= $settings->enable_https ? secure_url('episodes') : URL::to('episode') . '/' . @$episodes->series_title->slug . '/' . $episodes->slug ?>">
                  <img class="img-fluid w-100 flickity-lazyloaded" src="<?php echo URL::to('/') . '/public/uploads/images/' . $episodes->image; ?>" alt="episode">
                </a>

                <?php if($ThumbnailSetting->free_or_cost_label == 1): ?>
                    <?php if($episodes->access == 'subscriber'): ?>
                        <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                    <?php elseif($episodes->access == 'registered'): ?>
                        <p class="p-tag"><?php echo __('Register Now'); ?></p>
                    <?php elseif(!empty($episodes->ppv_status)): ?>
                        <p class="p-tag"><?php echo $currency->symbol . ' ' . $settings->ppv_price; ?></p>
                    <?php elseif(!empty($episodes->ppv_status) || (!empty($episodes->ppv_status) && $episodes->ppv_status == null)): ?>
                        <p class="p-tag"><?php echo $currency->symbol . ' ' . $settings->ppv_status; ?></p>
                    <?php elseif($episodes->ppv_status == null && $episodes->ppv_price == null): ?>
                        <p class="p-tag"><?php echo __('Free'); ?></p>
                    <?php endif; ?>
                <?php endif; ?>

               </div>
            </div>

            <div class="block-description">
              <a class="playTrailer" href="<?= $settings->enable_https ? secure_url('episodes') : URL::to('episode') . '/' . @$episodes->series_title->slug . '/' . $episodes->slug ?>">
                
                <?php if($ThumbnailSetting->free_or_cost_label == 1): ?>
                    <?php if($episodes->access == 'subscriber'): ?>
                        <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                    <?php elseif($episodes->access == 'registered'): ?>
                        <p class="p-tag"><?php echo __('Register Now'); ?></p>
                    <?php elseif(!empty($episodes->ppv_status)): ?>
                        <p class="p-tag"><?php echo $currency->symbol . ' ' . $settings->ppv_price; ?></p>
                    <?php elseif(!empty($episodes->ppv_status) || (!empty($episodes->ppv_status) && $episodes->ppv_status == null)): ?>
                        <p class="p-tag"><?php echo $currency->symbol . ' ' . $settings->ppv_status; ?></p>
                    <?php elseif($episodes->ppv_status == null && $episodes->ppv_price == null): ?>
                        <p class="p-tag"><?php echo __('Free'); ?></p>
                    <?php endif; ?>
                <?php endif; ?>
              </a>
              

              <div class="hover-buttons text-white">
                <a  href="<?= $settings->enable_https ? secure_url('episodes') : URL::to('episode') . '/' . @$episodes->series_title->slug . '/' . $episodes->slug ?> ">

                  
                      <p class="epi-name text-left m-0 mt-2">
                          <?= strlen($episodes->title) > 17 ? substr($episodes->title, 0, 18) . '...' : $episodes->title ?>
                      </p>
                 
                  <p class="desc-name text-left m-0 mt-1">
                      <?= strlen($episodes->episode_description) > 75 ? substr(html_entity_decode(strip_tags($episodes->episode_description)), 0, 75) . '...' : $episodes->episode_description ?>
                  </p>

                  <div class="movie-time d-flex align-items-center pt-1">
                    <?php if($ThumbnailSetting->age == 1 && !($episodes->age_restrict == 0)): ?>
                        <span class="position-relative badge p-1 mr-2"><?php echo $episodes->age_restrict . ' +'; ?></span>
                    <?php endif; ?>
                
                    <?php if($ThumbnailSetting->duration == 1): ?>
                        <span class="position-relative text-white mr-2">
                            <?php 
                                echo (floor($episodes->duration / 3600) > 0 ? floor($episodes->duration / 3600) . 'h ' : '') . floor(($episodes->duration % 3600) / 60) . 'm';
                            ?>
                        </span>
                    <?php endif; ?>
                
                    <?php if($ThumbnailSetting->published_year == 1 && !($episodes->year == 0)): ?>
                        <span class="position-relative badge p-1 mr-2">
                            <?php echo __($episodes->year); ?>
                        </span>
                    <?php endif; ?>
                
                    <?php if($ThumbnailSetting->featured == 1 && $episodes->featured == 1): ?>
                        <span class="position-relative text-white">
                            <?php echo __('Featured'); ?>
                        </span>
                    <?php endif; ?>
                </div>
                
                  
                </a>


                <a class="epi-name mt-3 mb-0 btn"
                  href="<?= $settings->enable_https ? secure_url('episodes') : URL::to('episode') . '/' . @$episodes->series_title->slug . '/' . $episodes->slug ?> ">
                  <i class="fa fa-play mr-1" aria-hidden="true"></i>
                  <?= __('Play Now') ?>
                </a>
              </div>
            </div>
          </div>
        </div>

            <?php endif; ?>
            <?php endforeach; ?>
            <?php endforeach; ?>
      </div>
    </div>
</div>

<script>
  var elem = document.querySelector('.other-episode');
  var flkty = new Flickity(elem, {
      cellAlign: 'left',
      contain: true,
      groupCells: true,
      pageDots: false,
      draggable: true,
      freeScroll: true,
      imagesLoaded: true,
      lazyload:true,
  });
</script>
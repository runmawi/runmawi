<div class="iq-main-header pl-3 ">
    <h4 class="main-title"><?= __('Episode') ?> </h4>
</div>

<div class="col-sm-12 overflow-hidden">
    <div class="favorites-contens ml-2">
        <ul class="favorites-slider list-inline row mb-0">
            <?php  
            $ThumbnailSetting = App\ThumbnailSetting::first();
      foreach($season as $key => $seasons):
         foreach($seasons->episodes as $key => $episodes):
             if($episodes->id != $episode->id): ?>

            <li class="slide-item">
          <div class="block-images position-relative">

            <!-- block-images -->
            <div class="border-bg">
              <div class="img-box">
                <a class="playTrailer" href="<?= $settings->enable_https ? secure_url('episodes') : URL::to('episode') . '/' . @$episodes->series_title->slug . '/' . $episodes->slug ?>">
                  <img class="img-fluid w-100" loading="lazy" data-src="<?php echo URL::to('/') . '/public/uploads/images/' . $episodes->image; ?>" alt="episode">
                </a>


                <?php if ($ThumbnailSetting->free_or_cost_label == 1) { ?>
                  <?php if (!empty($episodes->ppv_price == 1)) { ?>
                    <p class="p-tag1">
                      <?php echo $currency->symbol . ' ' . $episodes->ppv_price; ?>
                    </p>
                  <?php } elseif (!empty($episodes->ppv_status || !empty($episodes->ppv_status) && $episodes->ppv_price == 1)) { ?>
                    <p class="p-tag1">
                      <?php echo $episodes->ppv_status . ' ' . $currency->symbol; ?>
                    </p>
                  <?php } elseif ($episodes->ppv_status == null && $episodes->ppv_price == null) { ?>
                    <p class="p-tag">
                      <?php echo (__('Free')); ?>
                    </p>
                  <?php } ?>
                <?php } ?>
              </div>
            </div>

            <div class="block-description">
              <a class="playTrailer" href="<?= $settings->enable_https ? secure_url('episodes') : URL::to('episode') . '/' . @$episodes->series_title->slug . '/' . $episodes->slug ?>">
                <img class="img-fluid w-100" loading="lazy"  data-src="<?php echo URL::to('/') . '/public/uploads/images/' . $episodes->player_image; ?>" alt="episode">



                <?php if ($ThumbnailSetting->free_or_cost_label == 1) { ?>
                  <?php if (!empty($episodes->ppv_price == 1)) { ?>
                    <p class="p-tag1">
                      <?php echo $currency->symbol . ' ' . $episodes->ppv_price; ?>
                    </p>
                  <?php } elseif (!empty($episodes->ppv_status || !empty($episodes->ppv_status) && $episodes->ppv_price == 1)) { ?>
                    <p class="p-tag1">
                      <?php echo $episodes->ppv_status . ' ' . $currency->symbol; ?>
                    </p>
                  <?php } elseif ($episodes->ppv_status == null && $episodes->ppv_price == null) { ?>
                    <p class="p-tag">
                      <?php echo (__('Free')); ?>
                    </p>
                  <?php } ?>
                <?php } ?>
              </a>
              <?php if ($ThumbnailSetting->free_or_cost_label == 1) { ?>
                <?php if (!empty($episodes->ppv_price == 1)) { ?>
                  <p class="p-tag1">
                    <?php echo $currency->symbol . ' ' . $episodes->ppv_price; ?>
                  </p>
                <?php } elseif (!empty($episodes->ppv_status || !empty($episodes->ppv_status) && $episodes->ppv_price == 1)) { ?>
                  <p class="p-tag1">
                    <?php echo $episodes->ppv_status . ' ' . $currency->symbol; ?>
                  </p>
                <?php } elseif ($episodes->ppv_status == null && $episodes->ppv_price == null) { ?>
                  <p class="p-tag">
                    <?php echo (__('Free')); ?>
                  </p>
                <?php } ?>
              <?php } ?>

              <div class="hover-buttons text-white">
                <a  href="<?= $settings->enable_https ? secure_url('episodes') : URL::to('episode') . '/' . @$episodes->series_title->slug . '/' . $episodes->slug ?> ">

                  <p class="epi-name text-left m-0">
                    <?php echo __($episodes->title); ?>
                  </p>

                  <div class="movie-time d-flex align-items-center my-2">
                    <div class="badge badge-secondary p-1 mr-2">
                      <?php echo $episodes->age_restrict . ' ' . '+' ?>
                    </div>
                    <!-- <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $episodes->duration); ?></span>-->
                  </div>
                </a>


                <a class="epi-name mt-3 mb-0 btn"
                  href="<?= $settings->enable_https ? secure_url('episodes') : URL::to('episode') . '/' . @$episodes->series_title->slug . '/' . $episodes->slug ?> ">
                  <i class="fa fa-play mr-1" aria-hidden="true"></i>
                  Play Now
                </a>
              </div>
            </div>
          </div>
        </li>

            <?php endif; ?>
            <?php endforeach; ?>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
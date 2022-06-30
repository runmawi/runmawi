
    <?php 
     if(isset($latest_series)) :
      $order_settings = App\OrderHomeSetting::orderBy('order_id', 'asc')->get();  
      $order_settings_list = App\OrderHomeSetting::get(); 
      ?>
<div class="iq-main-header d-flex align-items-center justify-content-between">
  <h4 class="main-title">
    <!-- Recently Added Series -->
    <a href="<?php echo URL::to('/Series-list' ) ?>">
  <?php if ($order_settings_list[4]->header_name) 
      {
        echo $order_settings_list[4]->header_name ;
        }
        else {
            echo "" ; 
        } 
  ?>
  </a>
  </h4>  
</div>
<div class="favorites-contens">
  <ul class="favorites-slider list-inline  row p-0 mb-0">
    <?php  if(isset($latest_series)) :
      foreach($latest_series as $latest_serie): ?>
        <li class="slide-item">
          <a href="<?php echo URL::to('/play_series'.'/'.$latest_serie->slug ) ?>">
                             <!-- block-images -->
            <div class="block-images position-relative">
              <div class="img-box">
                <img src="<?php echo URL::to('/').'/public/uploads/images/'.$latest_serie->image;  ?>" class="img-fluid" alt="">
               
                    <?php  if(!empty($latest_serie->ppv_status)){?>
                    <p class="p-tag1"><?php echo $currency->symbol.' '.$settings->ppv_price; ?></p>
                    <?php }elseif(!empty($latest_serie->ppv_status || !empty($latest_serie->ppv_status) && $latest_serie->ppv_status == null)){ ?>
                      <p class="p-tag1"><?php echo $currency->symbol.' '.$settings->ppv_status; ?></p>
                      <?php }elseif($latest_serie->ppv_status == null && $latest_serie->ppv_price == null ){ ?>
                      <p class="p-tag"><?php echo "Free"; ?></p>
                      <?php } ?>
                 
              </div>

              <div class="block-description">
                <a href="<?php echo URL::to('/play_series'.'/'.$latest_serie->slug) ?> ">

              <h6><?php echo __($latest_serie->title); ?></h6>
               
                <div class="movie-time d-flex align-items-center my-2">
                  <div class="badge badge-secondary p-1 mr-2"><?php echo $latest_serie->age_restrict.' '.'+' ?></div>
                  <!--<span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $latest_serie->duration); ?></span>-->
                </div>
                <div class="hover-buttons d-flex">
                  <a class="text-white" href="<?php echo URL::to('/play_series'.'/'.$latest_serie->slug) ?> " >
                    <i class="fa fa-play mr-1" aria-hidden="true"></i>
                   Watch Series
                  </a>
                </div>
                     </a>
              </div>
            </div>
          </a>
        </li>
      <?php endforeach; 
    endif; ?>
  </ul>
</div>
<?php endif; ?>

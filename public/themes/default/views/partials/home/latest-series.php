
    <?php 
     if(isset($latest_series)) :
      $order_settings = App\OrderHomeSetting::orderBy('order_id', 'asc')->get();  
      $order_settings_list = App\OrderHomeSetting::get(); 
      ?>
<div class="iq-main-header d-flex align-items-center justify-content-between">
  <h4 class="main-title">
    <!-- Recently Added Series -->
<a href="<?php if ($order_settings_list[4]->header_name) { echo URL::to('/').'/'.$order_settings_list[4]->url ;} else { echo "" ; } ?>">
    <!-- <a href="<?php //echo URL::to('/Series-list' ) ?>"> -->
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
                <img src="<?php echo URL::to('/').'/public/uploads/images/'.$latest_serie->image;  ?>" class="img-fluid w-100" alt="series">
               
                    <?php if($latest_serie->access == 'subscriber' ){ ?>
                        <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>
                        <?php }elseif($latest_serie->access == 'registered'){?>
                        <p class="p-tag2"><img alt="logo" src="<?php echo URL::to('/').'/assets/icons/register.png'; ?>" width=10 class="c-logo" ></p>
                        <?php } elseif(!empty($latest_serie->ppv_status)){?>
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
                  <div class="badge badge-secondary p-1 mr-2"><?php 
                  $SeriesSeason = App\SeriesSeason::where('series_id',$latest_serie->id)->count(); 
                  echo $SeriesSeason.' '.'Season'
                  ?></div>
                  <div class="badge badge-secondary p-1 mr-2"><?php 
                  $Episode = App\Episode::where('series_id',$latest_serie->id)->count(); 
                  echo $Episode.' '.'Episodes'
                  ?></div>

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

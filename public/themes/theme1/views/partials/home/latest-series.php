<?php  if(isset($latest_series)) :

  $order_settings = App\OrderHomeSetting::orderBy('order_id', 'asc')->get();  
  $order_settings_list = App\OrderHomeSetting::get(); 
  ?>

<div class="iq-main-header d-flex align-items-center justify-content-between">
   <h4 class="main-title">
    <!-- Recently Added Series -->
    <a href="<?php if ($order_settings_list[4]->header_name) { echo URL::to('/').'/'.$order_settings_list[4]->url ;} else { echo "" ; } ?>">
      <?php if ($order_settings_list[4]->header_name) { echo $order_settings_list[4]->header_name ;} else { echo "" ; } ?>
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
                <img src="<?php echo URL::to('/').'/public/uploads/images/'.$latest_serie->image;  ?>" class="img-fluid w-100" alt="">
              </div> 
               </div>
              <div class="block-description">
               
                <div class="hover-buttons d-flex">
                  <a class="text-white " href="<?php echo URL::to('/play_series'.'/'.$latest_serie->slug) ?> " >
                    <img class="ply" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>" />
                  
                  </a>
                </div>
              </div>
              
              <div class="mt-2">
                  
                <div class="movie-time d-flex align-items-center justify-content-between my-2">
                     <a href="<?php echo URL::to('/play_series'.'/'.$latest_serie->slug) ?> ">

              <h6><?php echo __($latest_serie->title); ?></h6>
                </a>
                  <div class="badge badge-secondary p-1 mr-2"><?php echo $latest_serie->age_restrict.' '.'+' ?></div>
                 
                </div>
                   <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $latest_serie->duration); ?></span>
              </div>
          
          </a>
        </li>
      <?php endforeach; 
    endif; ?>
  </ul>
</div>
<?php  endif; ?>

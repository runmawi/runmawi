
<?php 
     if(isset($latest_series)) :
      $order_settings = App\OrderHomeSetting::orderBy('order_id', 'asc')->get();  
      $order_settings_list = App\OrderHomeSetting::get(); 
      $channels = App\Channel::get(); 

      ?>
<div class="iq-main-header d-flex align-items-center justify-content-between">
  <h5 class="main-title">
    <!-- Recently Added Series -->
<a href="<?php if ($order_settings_list[13]->header_name) { echo URL::to('/').'/'.$order_settings_list[13]->url ;} else { echo "" ; } ?>">
    <!-- <a href="<?php //echo URL::to('/Series-list' ) ?>"> -->
  <?php if ($order_settings_list[13]->header_name) 
      {
        echo $order_settings_list[13]->header_name ;
        }
        else {
            echo "" ; 
        } 
  ?>
  </a>
  </h5>  
</div>
<div class="favorites-contens">
  <div class="favorites-slider list-inline  row p-0 mb-0">
    <?php  if(isset($channels)) :
      foreach($channels as $channel): ?>
        <div class="slide-item">
          <a href="<?php echo URL::to('/channel'.'/'.$channel->channel_slug  ) ?>" aria-label="videos">
                             <!-- block-images -->
            <div class="block-images position-relative">
              <div class="img-box">
                <img src="<?php echo $channel->channel_image;  ?>" class="img-fluid w-100" alt="channel">                 
                </div></div>

              <div class="block-description"></div>
                <a href="<?php echo URL::to('/channel'.'/'.$channel->slug) ?> " aria-label="Channel-Partner">

              <h6><?php echo __($channel->channel_name); ?></h6>
                               <!-- </div> -->
                <div class="hover-buttons d-flex">
                  <a class="text-white" href="<?php echo URL::to('/channel'.'/'.$channel->channel_slug) ?>" aria-label="Channel-Partner" >
                    <i class="fa fa-play mr-1" aria-hidden="true"></i>
                   Visit Channel
                  </a>
                </div>
                     </a>
            
          </a>
        </div>
      <?php endforeach; 
    endif; ?>
  </div>
</div>
<?php endif; ?>

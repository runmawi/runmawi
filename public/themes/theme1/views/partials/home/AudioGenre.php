
<?php 
     if(isset($latest_series)) :
      $order_settings = App\OrderHomeSetting::orderBy('order_id', 'asc')->get();  
      $order_settings_list = App\OrderHomeSetting::where('video_name','Audio_Genre')->first(); 
      $AudioCategory = App\AudioCategory::get();

      ?>
<div class="iq-main-header d-flex align-items-center justify-content-between">
  <h4 class="main-title">
    <!-- Recently Added Series -->
<a href="<?php if ($order_settings_list->header_name) { echo URL::to('/').'/'.$order_settings_list->url ;} else { echo "" ; } ?>">
    <!-- <a href="<?php //echo URL::to('/Series-list' ) ?>"> -->
  <?php if ($order_settings_list->header_name) 
      {
        echo (__($order_settings_list->header_name)) ;
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
    <?php  if(isset($AudioCategory)) :
      foreach($AudioCategory as $Audio_Category): ?>
        <li class="slide-item">
          <a href="<?php echo URL::to('/audios/category'.'/'.$Audio_Category->slug  ) ?>">
                             <!-- block-images -->
            <div class="block-images position-relative">
              <div class="img-box">
                <img src="<?php echo URL::to('/').'/public/uploads/audios/'.@$Audio_Category->image;  ?>" class="img-fluid w-100" alt="">

              </div>

              <div class="block-description">
                <div class="hover-buttons d-flex">
                  <a class="text-white" href="<?php echo URL::to('/audios/category'.'/'.$Audio_Category->slug  ) ?> " >
                    <i class="fa fa-play mr-1" aria-hidden="true"></i>
                  </a>
                </div>
                
              </div>
            </div>
          </a>
          <a href="<?php echo URL::to('/audios/category'.'/'.$Audio_Category->slug  ) ?> ">
            <h6><?php echo __($Audio_Category->name); ?></h6>
          </a>
        </li>
      <?php endforeach; 
    endif; ?>
  </ul>
</div>
<?php endif; ?>

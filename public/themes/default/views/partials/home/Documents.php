<?php 
     if(isset($latest_series)) :
      $order_settings = App\OrderHomeSetting::orderBy('order_id', 'asc')->get();  
      $order_Documents_settings_list = App\OrderHomeSetting::where('video_name','Document')->first(); 
      $Documents = App\Document::orderBy('created_at', 'asc')->limit(30)->get();
      ?>
<div class="iq-main-header d-flex align-items-center justify-content-between">
  <h4 class="main-title">
    <!-- Recently Added Series -->
<a href="<?php if ($order_Documents_settings_list->header_name) { echo URL::to('/').'/'.$order_Documents_settings_list->url ;} else { echo "" ; } ?>">
    <!-- <a href="<?php //echo URL::to('/Series-list' ) ?>"> -->
  <?php if ($order_Documents_settings_list->header_name) 
      {
        echo __($order_Documents_settings_list->header_name) ;
        }
        else {
            echo "" ; 
        } 

  ?>
  </a>
  </h4> 
  <h4 class="main-title"><a href="<?php if ($order_Documents_settings_list->header_name) { echo URL::to('/').'/'.$order_Documents_settings_list->url ;} else { echo "" ; } ?>"><?php echo (__('View All')); ?></a></h4> 
</div>
<div class="favorites-contens">
  <ul class="favorites-slider list-inline  row p-0 mb-0">
    <?php  if(isset($Documents)) :
      foreach($Documents as $Document): ?>
        <li class="slide-item">
          <div class="block-images position-relative">
            <!-- block-images -->
            <div class="border-bg">
            <div class="img-box">
          <a class="playTrailer" target="_blank" href="<?php echo URL::to('public/uploads/Document/'.$Document->document) ?>">
                <img src="<?php echo URL::to('/').'/public/uploads/Document/'.@$Document->image;  ?>" class="img-fluid w-100" alt="">
          </a>
              </div>
              </div>

              <div class="block-description">
              <a class="playTrailer" target="_blank" href="<?php echo URL::to('public/uploads/Document/'.$Document->document) ?>">
                <img class="img-fluid w-100" loading="lazy" src="<?php echo URL::to('/').'/public/uploads/Document/'.@$Document->image;  ?>" alt="doc">
          </a>

          <div class="hover-buttons text-white">
                <a href="<?php echo URL::to('/document'.'/'.$Document->slug  ) ?> ">
                <p class="epi-name text-left m-0"><?php echo __($Document->name); ?></p>
                </a>
                              
                
                  <a class="epi-name mt-5 mb-0 btn" target="_blank" href="<?php echo URL::to('public/uploads/Document/'.$Document->document) ?>">
                    <i class="fa fa-play mr-1" aria-hidden="true"></i>
                   View Document
                  </a>
                </div>
              </div>
            </div>
        </li>
      <?php endforeach; 
    endif; ?>
  </ul>
</div>
<?php endif; ?>

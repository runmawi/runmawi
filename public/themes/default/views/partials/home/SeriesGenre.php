<?php 
        $SeriesGenre = App\SeriesGenre::all();
        if(isset($SeriesGenre)) : ?>
<div class="iq-main-header d-flex align-items-center justify-content-between">
  <h4 class="main-title"><a href="<?php if ($order_settings_list[19]->header_name) { echo URL::to('/').'/'.$order_settings_list[19]->url ;} else { echo "" ; } ?>">
    <?php if ($order_settings_list[19]->header_name) { echo $order_settings_list[19]->header_name ;} else { echo "" ; } ?>
    </a></h4>            
</div>
<?php
 endif;
?>
<div class="favorites-contens">
  <ul class="favorites-slider list-inline  row p-0 mb-0">
    <?php  if(isset($SeriesGenre)) :
    					 foreach($SeriesGenre as $key => $Series_Genre) {
            ?>
        <li class="slide-item">
          <div class="block-images position-relative">
            <!-- block-images -->
            <div class="border-bg">
            <div class="img-box">
                <a class="playTrailer" href="<?php echo URL::to('/series/category'.'/'.$Series_Genre->slug  ) ?> ">
                <img data-src="<?php echo URL::to('/').'/public/uploads/videocategory/'.$Series_Genre->image;  ?>" class="img-fluid lazyload w-100" alt="">
               </a>
                  
              </div>
              </div>
              
              <div class="block-description">
              <a href="<?php echo URL::to('/series/category'.'/'.$Series_Genre->slug  ) ?> ">
                  <h6><?php echo __($Series_Genre->name); ?></h6>
                </a>
                <div class="movie-time d-flex align-items-center my-2">
                  
                  
                </div>
                <div class="hover-buttons d-flex">
                <a class="text-white" href="<?php echo URL::to('/series/category'.'/'.$Series_Genre->slug  ) ?> ">
                    <i class="fa fa-play mr-1" aria-hidden="true"></i>
                   Visit Series Category Video
                  </a>
                </div>
              </div>
            </div>
          </a>
        </li>
      <?php  } 
      // }
    endif; ?>
  </ul>
</div>
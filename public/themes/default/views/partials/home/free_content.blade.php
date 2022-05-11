<div class="iq-main-header d-flex align-items-center justify-content-between">
  <h4 class="main-title">Free Content Videos</h4>                      
</div>
<?php
?>
<div class="favorites-contens">
  <ul class="favorites-slider list-inline  row p-0 mb-0">
    <?php  if(isset($free_Contents)) :
    					 foreach($free_Contents as $key => $free_Content) {
        // foreach($latest_series as $latest_serie) { 
?>
        <li class="slide-item">
          <a href="<?php if($free_Content->series_id == @$free_Content->series_title->id){ echo URL::to('/episode'.'/'.@$free_Content->series_title->title.'/'.$free_Content->slug) ; }?> ">
                             <!-- block-images -->
            <div class="block-images position-relative">
              <div class="img-box">
                <img src="<?php echo URL::to('/').'/public/uploads/images/'.$free_Content->image;  ?>" class="img-fluid w-100" alt="">
               
                    <?php  if(!empty($free_Content->ppv_price == 1)){?>
                    <p class="p-tag1"><?php echo $currency->symbol.' '.$free_Content->ppv_price; ?></p>
                    <?php }elseif( !empty($free_Content->ppv_status || !empty($free_Content->ppv_status) && $free_Content->ppv_price == 1)){ ?>
                      <p class="p-tag1"><?php echo $free_Content->ppv_status.' '.$currency->symbol; ?></p>
                      <?php }elseif($free_Content->ppv_status == null && $free_Content->ppv_price == null ){ ?>
                      <p class="p-tag"><?php echo "Free"; ?></p>
                      <?php } ?>
                 
              </div>
              <div class="block-description">
              <a href="<?php if($free_Content->series_id == @$free_Content->series_title->id){ echo URL::to('/episode'.'/'.@$free_Content->series_title->title.'/'.$free_Content->slug) ; }?> ">
                  <h6><?php echo __($free_Content->title); ?></h6>
                </a>
                <div class="movie-time d-flex align-items-center my-2">
                  <div class="badge badge-secondary p-1 mr-2"><?php echo $free_Content->age_restrict.' '.'+' ?></div>
                  <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $free_Content->duration); ?></span>
                </div>
                <div class="hover-buttons d-flex">
                <a class="text-white" href="<?php if($free_Content->series_id == @$free_Content->series_title->id){ echo URL::to('/episode'.'/'.@$free_Content->series_title->title.'/'.$free_Content->slug) ; }?> ">
                    <i class="fa fa-play mr-1" aria-hidden="true"></i>
                   Watch Series
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
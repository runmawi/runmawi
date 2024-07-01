<?php if(count($free_Contents) > 0) : ?>
<div class="iq-main-header d-flex align-items-center justify-content-between">
  <h4 class="main-title"><?php echo (__('Free Episodes')); ?></h4>                  
</div>
<?php
endif;
 $ThumbnailSetting = App\ThumbnailSetting::first();
 ?>
<div class="favorites-contens">
  <ul class="free-content list-inline  row p-0 mb-0">
    <?php  if(isset($free_Contents)) :
    					 foreach($free_Contents as $key => $free_Content) {
        // foreach($latest_series as $latest_serie) { 
    ?>
        <div class="items">
          <div class="block-images position-relative">
            <!-- block-images -->
            <div class="border-bg">
            <div class="img-box">
                <a class="playTrailer" href="<?php if($free_Content->series_id == @$free_Content->series_title->id){ echo URL::to('/episode'.'/'.@$free_Content->series_title->slug.'/'.$free_Content->slug) ; }?> ">
                <img class="img-fluid w-100" loading="lazy" src="<?php echo URL::to('/').'/public/uploads/images/'.$free_Content->image;  ?>"  alt="content">
                </a>
                
                <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?> 

                    <?php  if(!empty($free_Content->ppv_price == 1)){?>
                    <p class="p-tag1"><?php echo $currency->symbol.' '.$free_Content->ppv_price; ?></p>
                    <?php }elseif( !empty($free_Content->ppv_status || !empty($free_Content->ppv_status) && $free_Content->ppv_price == 1)){ ?>
                      <p class="p-tag1"><?php echo $free_Content->ppv_status.' '.$currency->symbol; ?></p>
                      <?php }elseif($free_Content->ppv_status == null ){ ?>
                      <p class="p-tag"><?php echo (__('Free')); ?></p>
                      <?php } ?>
                  <?php } ?>
                 
              </div>
              </div>

              <div class="block-description">
              <a class="playTrailer" href="<?php if($free_Content->series_id == @$free_Content->series_title->id){ echo URL::to('/episode'.'/'.@$free_Content->series_title->slug.'/'.$free_Content->slug) ; }?> ">
                <img class="img-fluid w-100" loading="lazy" src="<?php echo URL::to('/').'/public/uploads/images/'.$free_Content->player_image;  ?>" alt="">
                
                
                <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?> 

                    <?php  if(!empty($free_Content->ppv_price == 1)){?>
                    <p class="p-tag1"><?php echo $currency->symbol.' '.$free_Content->ppv_price; ?></p>
                    <?php }elseif( !empty($free_Content->ppv_status || !empty($free_Content->ppv_status) && $free_Content->ppv_price == 1)){ ?>
                      <p class="p-tag1"><?php echo $free_Content->ppv_status.' '.$currency->symbol; ?></p>
                      <?php }elseif($free_Content->ppv_status == null ){ ?>
                      <p class="p-tag"><?php echo (__('Free')); ?></p>
                      <?php } ?>
                  <?php } ?>
                  </a>
                  <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?> 
              </div>

<?php  if(!empty($free_Content->ppv_price == 1)){?>
<p class="p-tag1"><?php echo $currency->symbol.' '.$free_Content->ppv_price; ?></p>
<?php }elseif( !empty($free_Content->ppv_status || !empty($free_Content->ppv_status) && $free_Content->ppv_price == 1)){ ?>
  <p class="p-tag1"><?php echo $free_Content->ppv_status.' '.$currency->symbol; ?></p>
  <?php }elseif($free_Content->ppv_status == null ){ ?>
  <p class="p-tag"><?php echo (__('Free')); ?></p>
  <?php } ?>
<?php } ?>

            <div class="hover-buttons text-white">
              <a href="<?php if($free_Content->series_id == @$free_Content->series_title->id){ echo URL::to('/episode'.'/'.@$free_Content->series_title->slug.'/'.$free_Content->slug) ; }?> ">
              <p class="epi-name text-left m-0"><?php echo __($free_Content->title); ?></p>
               
                <div class="movie-time d-flex align-items-center my-2">
                  <div class="badge badge-secondary p-1 mr-2"><?php echo $free_Content->age_restrict.' '.'+' ?></div>
                  <!--<span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $free_Content->duration); ?></span>-->
                </div>
              </a>


               
                <a class="epi-name mt-2 mb-0 btn" href="<?php if($free_Content->series_id == @$free_Content->series_title->id){ echo URL::to('/episode'.'/'.@$free_Content->series_title->slug.'/'.$free_Content->slug) ; }?> ">
                    <i class="fa fa-play mr-1" aria-hidden="true"></i>
                   Watch Series
                  </a>
                </div>
              </div>
            </div>
        </li>
      <?php  } 
      // }
    endif; ?>
  </ul>
</div>

<script>
  var elem = document.querySelector('.free-content');
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
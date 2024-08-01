
<?php 
     if(isset($latest_series)) :
      $order_settings = App\OrderHomeSetting::orderBy('order_id', 'asc')->get();  
      $order_settings_list = App\OrderHomeSetting::where('video_name','Audio_Genre')->first(); 
      $AudioCategory = App\AudioCategory::get();

      ?>
<div class="iq-main-header d-flex align-items-center justify-content-between">
  <h5 class="main-title">
    <!-- Recently Added Series -->
<a href="<?php if ($order_settings_list->header_name) { echo URL::to('/').'/'.$order_settings_list->url ;} else { echo "" ; } ?>">
    <!-- <a href="<?php //echo URL::to('/Series-list' ) ?>"> -->
  <?php if ($order_settings_list->header_name) 
      {
        echo $order_settings_list->header_name ;
        }
        else {
            echo "" ; 
        } 
  ?>
  </a>
  </h5>  
</div>
<div class="favorites-contens"> 
  <div class="audio-genre home-sec list-inline row p-0 mb-0">
    <?php  if(isset($AudioCategory)) :
      foreach($AudioCategory as $Audio_Category): ?>
        <div class="items">
          <a href="<?php echo URL::to('/audios/category'.'/'.$Audio_Category->slug  ) ?>">
                             <!-- block-images -->
            <div class="block-images position-relative">
              <div class="img-box">
                <img src="<?php echo URL::to('/').'/public/uploads/audios/'.@$Audio_Category->image;  ?>" class="img-fluid w-100 h-50 flickity-lazyloaded" alt="AudioGenre">

              </div>

              <div class="block-description">
                <a href="<?php echo URL::to('/audios/category'.'/'.$Audio_Category->slug  ) ?> ">

              <h6><?php echo __($Audio_Category->name); ?></h6>
                               <!-- </div> -->
                <div class="hover-buttons d-flex">
                  <a class="text-white" href="<?php echo URL::to('/audios/category'.'/'.$Audio_Category->slug  ) ?> " >
                    <i class="fa fa-play mr-1" aria-hidden="true"></i>
                   Visit Audio Category
                  </a>
                </div>
                     </a>
              </div>
            </div>
          </a>
        </div>
      <?php endforeach; 
    endif; ?>
  </div>
</div>
<?php endif; ?>

<script>
    var elem = document.querySelector('.audio-genre');
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
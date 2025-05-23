<?php  if(isset($latest_series)) :

  $order_settings = App\OrderHomeSetting::orderBy('order_id', 'asc')->get();  
  $order_settings_list = App\OrderHomeSetting::get(); 
  ?>

<div class="iq-main-header d-flex align-items-center justify-content-between">
  <?php if( Route::currentRouteName() == "ChannelHome"){?>

      <h5 class="main-title">
            <a href="<?php echo route('Channel_series_list',Request::segment(2)); ?>">
              <?php if ($order_settings_list[4]->header_name) { echo $order_settings_list[4]->header_name ;} else { echo "" ; } ?>
            </a>
        </h5>  

      <a class="see" href="<?php echo route('Channel_series_list',Request::segment(2)); ?>">See All </a>

  <?php }else{ ?>
    
    <h5 class="main-title">
          <a href="<?php if ($order_settings_list[4]->header_name) { echo URL::to('/').'/'.$order_settings_list[4]->url ;} else { echo "" ; } ?>">
            <?php if ($order_settings_list[4]->header_name) { echo $order_settings_list[4]->header_name ;} else { echo "" ; } ?>
          </a>
      </h5>  

      <a class="see" href="<?php if ($order_settings_list[4]->header_name) { echo URL::to('/').'/'.$order_settings_list[4]->url ;} else { echo "" ; } ?>">See All </a>

  <?php } ?>

</div>
<div class="favorites-contens"> 
  <div class="latest-series home-sec list-inline row p-0 mb-0">
    <?php  if(isset($latest_series)) :
      foreach($latest_series as $latest_serie): ?>
        <div class="items">
          <a href="<?php echo URL::to('/play_series'.'/'.$latest_serie->slug ) ?>" aria-label="videos">
                             <!-- block-images -->
            <div class="block-images position-relative">
              <div class="img-box">
                <img src="<?php echo URL::to('/').'/public/uploads/images/'.$latest_serie->image;  ?>" class="img-fluid w-100 h-50" alt="<?php echo $latest_serie->title; ?>">
              </div> </div>
              
              <div class="block-description">
               
                <div class="hover-buttons d-flex">
                  <a class="text-white " href="<?php echo URL::to('/play_series'.'/'.$latest_serie->slug) ?> " aria-label="Latest-Series">
                    <img class="ply" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>" alt="play"> 
                  </a>
                </div>
              </div>
              <div class="mt-2">
                  
                <div class="movie-time align-items-center justify-content-between my-2">
                     <a href="<?php echo URL::to('/play_series'.'/'.$latest_serie->slug) ?> ">
                        <h5 style="font-size:1.0em; font-weight:500;"><?php  echo (strlen($latest_serie->title) > 17) ? substr($latest_serie->title,0,18).'...' : $latest_serie->title; ?></h5>
                    </a>

                    <div class="badge badge-secondary p-1 mr-2"><?php echo $latest_serie->age_restrict.' '.'+' ?></div>

                    <div class="badge badge-secondary p-1 mr-2">
                      <?php 
                        $SeriesSeason = App\SeriesSeason::where('series_id',$latest_serie->id)->count(); 
                        echo $SeriesSeason.' '.'Season'
                      ?>
                    </div>

                  <div class="badge badge-secondary p-1 mr-2">
                    <?php 
                      $Episode = App\Episode::where('series_id',$latest_serie->id)->count(); 
                      echo $Episode.' '.'Episodes'
                    ?>
                  </div>
                  
                </div>
                   <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $latest_serie->duration); ?></span>
              </div>
           
          </a>
        </div>
      <?php endforeach; 
    endif; ?>
  </div>
</div>
<?php  endif; ?>

<!-- Flickity Slider -->
<script>
    var elem = document.querySelector('.latest-series');
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
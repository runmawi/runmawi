<div class="iq-main-header d-flex align-items-center justify-content-between">
  <h5 class="main-title">Recently Added Episodes</h5>                      
</div>
<?php
?>
    <div class="favorites-contens"> 
      <div class="latest-episode home-sec list-inline row p-0 mb-0">
    <?php  if(isset($latest_episodes)) :
    					 foreach($latest_episodes as $key => $latest_episode) {
        // foreach($latest_series as $latest_serie) { 
?>
        <div class="items">
          <a href="<?php if($latest_episode->series_id == @$latest_episode->series_title->id){ echo URL::to('/episode'.'/'.@$latest_episode->series_title->slug.'/'.$latest_episode->slug) ; }?> ">
                             <!-- block-images -->
            <div class="block-images position-relative">
              <div class="img-box">
                <img src="<?php echo URL::to('/').'/public/uploads/images/'.$latest_episode->image;  ?>" class="img-fluid w-100 h-50 flickity-lazyloaded" alt="<?php echo $latest_episode->series_title; ?>">
                
              </div></div>
              <div class="block-description">
              
                <div class="hover-buttons d-flex">
                <a class="text-white " href="<?php if($latest_episode->series_id == @$latest_episode->series_title->id){ echo URL::to('/episode'.'/'.@$latest_episode->series_title->slug.'/'.$latest_episode->slug) ; }?> ">
                     <img class="ply" src="<?php echo URL::to('/').'/assets/img/play.svg';  ?>"> 
                  
                  </a>
                </div>
              </div>
              <div>
                  
                <div class="movie-time d-flex align-items-center justify-content-between my-2">
                    <a href="<?php if($latest_episode->series_id == @$latest_episode->series_title->id){ echo URL::to('/episode'.'/'.@$latest_episode->series_title->slug.'/'.$latest_episode->slug) ; }?> ">
                  <h6><?php echo __($latest_episode->title); ?></h6>
                </a>
                  <div class="badge badge-secondary p-1 mr-2"><?php echo $latest_episode->age_restrict.' '.'+' ?></div>
                </div>
                                    <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $latest_episode->duration); ?></span>

            </div>
          </a>
        </div>
      <?php  } 
      // }
    endif; ?>
  </div>
</div>

<script>
    var elem = document.querySelector('.latest-audios');
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
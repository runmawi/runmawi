<div class="iq-main-header d-flex align-items-center justify-content-between">
  <h4 class="main-title">Free Content Videos</h4>                      
</div>

<div class="favorites-contens"> 
  <div class="free-content home-sec list-inline row p-0 mb-0">
    <?php  if(isset($free_Contents)) :
    					 foreach($free_Contents as $key => $free_Content) { ?>
        <div class="items">
          <a href="<?php if($free_Content->series_id == @$free_Content->series_title->id){ echo URL::to('/episode'.'/'.@$free_Content->series_title->slug.'/'.$free_Content->slug) ; }?> ">
                             <!-- block-images -->
            <div class="block-images position-relative">
              <div class="img-box">
                <img src="<?php echo URL::to('/').'/public/uploads/images/'.$free_Content->image;  ?>" class="img-fluid w-100 h-50" alt="<?php echo $free_Content->title; ?>">
                
              </div></div>
              <div class="block-description">
              
                <div class="hover-buttons d-flex">
                <a class="text-white " href="<?php if($free_Content->series_id == @$free_Content->series_title->id){ echo URL::to('/episode'.'/'.@$free_Content->series_title->slug.'/'.$free_Content->slug) ; }?> ">
                     <img class="ply" src="<?php echo URL::to('/').'/assets/img/play.svg';  ?>"> 
                  
                  </a>
                </div>
              </div>
              <div>
                  
                <div class="movie-time d-flex align-items-center justify-content-between my-2">
                    <a href="<?php if($free_Content->series_id == @$free_Content->series_title->id){ echo URL::to('/episode'.'/'.@$free_Content->series_title->slug.'/'.$free_Content->slug) ; }?> ">
                  <h6><?php echo __($free_Content->title); ?></h6>
                </a>
                  <div class="badge badge-secondary p-1 mr-2"><?php echo $free_Content->age_restrict.' '.'+' ?></div>
                </div>
                                    <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $free_Content->duration); ?></span>

            </div>
          </a>
        </div>
      <?php  } 
    endif; ?>
  </div>
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
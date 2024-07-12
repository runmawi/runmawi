<?php 
        $SeriesGenre = App\SeriesGenre::all();
        if(isset($SeriesGenre)) : ?>
<div class="iq-main-header d-flex align-items-center justify-content-between">
  <h5 class="main-title"> Series Genre</h5>                      
</div>
<?php
 endif;
?>
<div class="favorites-contens">
  <div class="favorites-slider list-inline  row p-0 mb-0">
    <?php  if(isset($SeriesGenre)) :
    					 foreach($SeriesGenre as $key => $Series_Genre) {
            ?>
        <div class="slide-item">
          <a href="<?php echo URL::to('/series/category'.'/'.$Series_Genre->slug  ) ?> ">
                             <!-- block-images -->
            <div class="block-images position-relative">
              <div class="img-box">
                <img src="<?php echo URL::to('/').'/public/uploads/videocategory/'.$Series_Genre->image;  ?>" class="img-fluid w-100" alt="">
               
                  
              </div> </div>
              <div class="block-description">   </div>
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
           
           
          </a>
        </div>
      <?php  } 
      // }
    endif; ?>
  </div>
</div>
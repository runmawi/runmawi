<?php  if(count($albums) > 0) : ?>
<div class="iq-main-header d-flex align-items-center justify-content-between">
<h5 class="main-title"><a href="<?php if ($order_settings_list[6]->header_name) { echo URL::to('/').'/'.$order_settings_list[6]->url ;} else { echo "" ; } ?>">
    <?php if ($order_settings_list[6]->header_name) { echo $order_settings_list[6]->header_name ;} else { echo "" ; } ?>
    <!-- Albums -->
</a></h5>      
<a href="<?php if ($order_settings_list[6]->header_name) { echo URL::to('/').'/'.$order_settings_list[6]->url ;} else { echo "" ; } ?>" class="see" >See All</a>
</div>
<div class="favorites-contens"> 
   <div class="latest-albums home-sec list-inline row p-0 mb-0">
     <?php  if(isset($albums)) :
     foreach($albums as $album): ?>
   <div class="items">
   <a href="<?php echo URL::to('album') ?><?= '/' . $album->slug ?>" aria-label="videos">
         <div class="block-images position-relative">
                             <!-- block-images -->
            <div class="img-box">
            <img src="<?php echo URL::to('/').'/public/uploads/albums/'.$album->album;?>" class="img-fluid w-100 h-50" alt="<?php echo $album->albumname; ?>">
            </div>  </div>
            <div class="block-description" >  </div>
               <a href="<?= URL::to('album') ?><?= '/' . $album->slug ?>" aria-label="Podcasts">
               </a>                         
               <div class="hover-buttons">
               <a href="<?= URL::to('album') ?><?= '/' . $album->slug ?>" alt="<?php echo $album->albumname; ?>">
                  <h5 style="font-size:1.0em; font-weight:500;" class="epi-name text-white mb-0"><?php echo $album->albumname; ?></h5>
               </a>
                <div class="d-flex align-items-center justify-content-between">
                  <span class="text-white"><small><?php echo get_audio_artist($album->id); ?></small></span>
               </div>
               </div>

              

       
      </a>
     </div>

    <?php endforeach; 
               endif; ?>
</div>
</div>
<?php endif; ?>

<style>
   .flickity-prev-next-button{
      top: 32%;
   }
</style>

<script>
    var elem = document.querySelector('.latest-albums');
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
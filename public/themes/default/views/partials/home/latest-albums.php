<?php  if(count($albums) > 0) : ?>
<div class="iq-main-header d-flex align-items-center justify-content-between">
    <h4 class="main-title"><a href="<?php if ($order_settings_list[6]->header_name) { echo URL::to('/').'/'.$order_settings_list[6]->url ;} else { echo "" ; } ?>">
    <?php if ($order_settings_list[6]->header_name) { echo $order_settings_list[6]->header_name ;} else { echo "" ; } ?>
    <!-- Albums -->
</a></h4>                      
</div>
<div class="favorites-contens">
<ul class="favorites-slider list-inline  row p-0 mb-0">
     <?php  if(isset($albums)) :
     foreach($albums as $album): ?>
   <li class="slide-item">
      <a href="<?php echo URL::to('home') ?>">
         <div class="block-images position-relative">
                             <!-- block-images -->
            <div class="img-box">
            <img src="<?php echo URL::to('/').'/public/uploads/albums/'.$album->album;?>" class="img-fluid w-100" alt="">
            </div>
            <div class="block-description" >
            <a href="<?= URL::to('album') ?><?= '/' . $album->slug ?>">
                        <i class="ri-play-fill"></i>
                     </a>                         
               <div class="hover-buttons">
               <a href="<?= URL::to('album') ?><?= '/' . $album->slug ?>">
                  <h6 class="epi-name text-white mb-0"><?php echo $album->albumname; ?></h6>
               </a>
                <div class="d-flex align-items-center justify-content-between">
                  <span class="text-white"><small><?php echo get_audio_artist($album->id); ?></small></span>
               </div>
               </div>

                </div>

         </div>
      </a>
   </li>

    <?php endforeach; 
               endif; ?>
</ul>
</div>
<?php endif; ?>
<?php if(isset($audios)) :
foreach($audios as $audio): ?>
<div class="iq-main-header col-md-2 p-0">
    <div class="favorites-contens">           
        <div class="epi-box ">
            <div class="epi-img position-relative">
               <img src="<?php echo URL::to('/').'/public/uploads/images/'.$audio->image;?>" class="img-fluid img-zoom w-100" alt="">
               <div class="episode-play-info">
                  <div class="episode-play">
                     <a href="<?= URL::to('audio') ?><?= '/' . $audio->slug ?>">
                        <i class="ri-play-fill"></i>
                     </a>
                  </div>
               </div>
            </div>
            <div class="epi-desc p-3"> 
               <a href="<?= URL::to('audio') ?><?= '/' . $audio->slug ?>">
                  <h6 class="epi-name text-white mb-0"><?php echo $audio->title; ?></h6>
               </a>
                <div class="d-flex align-items-center ">
                    <span class="text-white mr-2"><small><?php echo get_audio_artist($audio->id); ?></small></span>
                    <span class="text-primary"><small><?php echo gmdate('H:i:s', $audio->duration); ?>m</small></span>
               </div>
            </div>
        </div>
    </div>
</div>


<?php endforeach; 
endif; ?>
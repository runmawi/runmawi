<?php include('header.php'); ?>
<div class="container mt-4 audio-list-page">

       <div class="block-space">
           <div class="row">
              <div class="col-sm-12 overflow-hidden">
                 <div class="iq-main-header d-flex align-items-center justify-content-between">
                    <?php if(isset($page_title)): ?>
                    <!-- <h4 class="main-title" style = "color:white;">Audio</h4> -->
                    <!-- <a href="#" class="text-primary">View all</a> -->
                    <?php endif; ?> 
                 </div>
              </div>
           </div>
        </div>
		<div class="row nomargin">
        <?php if(isset($audios_category)) :
foreach($audios_category as $audio): ?>
<div class="iq-main-header col-md-3 d-flex align-items-center justify-content-between">
    <div class="favorites-contens">           
        <div class="epi-box">
            <div class="epi-img position-relative">
               <img src="<?php echo URL::to('/').'/public/uploads/images/'.$audio->image;?>" class="img-fluid img-zoom" alt="">
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
                <div class="d-flex align-items-center justify-content-between">
                    <span class="text-white"><small><?php echo get_audio_artist($audio->id); ?></small></span>
                    <span class="text-primary"><small><?php echo gmdate('H:i:s', $audio->duration); ?>m</small></span>
               </div>
            </div>
        </div>
    </div>
</div>


<?php endforeach; 
endif; ?>
			
		</div>
      <?php //if($audios_count > 0){   include('partials/pagination.php'); }else{} ?>

</div>
<?php include('header.php'); ?>

<div class="container mt-4 audio-list-page">

       <div class="block-space">
           <div class="row">
              <div class="col-sm-12 overflow-hidden">
                 <div class="iq-main-header d-flex align-items-center justify-content-between">
                    <?php if(isset($page_title)): ?>
                    <h4 class="main-title">Today Trending</h4>
                    <a href="#" class="text-primary">View all</a>
                    <?php endif; ?> 
                 </div>
              </div>
           </div>
        </div>
		<div class="row nomargin">
			<?php if(isset($audios) ||  isset($audios_category)) { include('partials/audio.php'); } ?>
			
		</div>
      <?php if($audios_count > 0){   include('partials/pagination.php'); }else{} ?>


	<?php //include('partials/pagination.php'); ?>

</div>
<div class="container mt-2">
       <div class="block-space">
           <div class="row">
              <div class="col-sm-12 overflow-hidden">
                 <div class="iq-main-header d-flex align-items-center justify-content-between">
                    <?php if(isset($page_title)): ?>
                    <h4 class="main-title">Albums</h4>
                    <a href="#" class="text-primary">View all</a>
                    <?php endif; ?> 
                 </div>
              </div>
           </div>
        </div>
		<div class="row nomargin">

			<?php 
			if(isset($albums)) { 
				foreach($albums as $album): ?>
					<div class="iq-main-header col-md-3 d-flex align-items-center justify-content-between">
						<div class="favorites-contens">
				            <div class="epi-box">
                                <div class="epi-img position-relative">
                                   <img src="<?php echo URL::to('/').'/public/uploads/albums/'.$album->album;?>" class="img-fluid img-zoom" alt="">
                                   <div class="episode-play-info">
                                      <div class="episode-play">
                                         <a href="<?= URL::to('album') ?><?= '/' . $album->slug ?>">
                                            <i class="ri-play-fill"></i>
                                         </a>
                                      </div>
                                   </div>
                                </div>
                                <div class="epi-desc p-3"> 
                                   <a href="<?= URL::to('album') ?><?= '/' . $album->slug ?>">
                                      <h6 class="epi-name text-white mb-0"><?php echo $album->albumname; ?></h6>
                                   </a>
                                    <div class="d-flex align-items-center justify-content-between">
                                      <span class="text-white"><small><?php if($audios_count > 0){  echo get_audio_artist($audio->id); }else{}  ?></small></span>
                                   </div>
                                </div>
                            </div>
						</div>
					</div>


				<?php endforeach; } ?>
			</div>
         <?php if($audios_count > 0){   include('partials/pagination.php'); }else{} ?>

	<?php// include('partials/pagination.php'); ?>

</div>
<div class="container mt-2">

		<div class="block-space">
           <div class="row">
              <div class="col-sm-12 overflow-hidden">
                 <div class="iq-main-header d-flex align-items-center justify-content-between">
                    <?php if(isset($page_title)): ?>
                    <h4 class="main-title">Artists</h4>
                    <a href="#" class="text-primary">View all</a>
                    <?php endif; ?> 
                 </div>
              </div>
           </div>
        </div>
		<div class="row nomargin">

			<?php 
			if(isset($artists)) { 
				foreach($artists as $artist): ?>
					<div class="iq-main-header col-md-3 d-flex align-items-center justify-content-between">
						<div class="favorites-contens">
                            <div class="epi-box">
                                <div class="epi-img position-relative">
                                   <img src="<?php echo URL::to('/').'/public/uploads/artists/'.$artist->image;?>" class="img-fluid img-zoom" alt="">
                                   <div class="episode-play-info">
                                      <div class="episode-play">
                                         <a href="<?= URL::to('artist') ?><?= '/' . $artist->id ?>">
                                            <i class="ri-play-fill"></i>
                                         </a>
                                      </div>
                                   </div>
                                </div>
                                <div class="epi-desc p-3">
                                   <a href="<?= URL::to('artist') ?><?= '/' . $artist->id ?>">
                                      <h6 class="epi-name text-white mb-0"><?php echo $artist->artist_name; ?></h6>
                                   </a>
                                </div>
                            </div>
						</div>
					</div>


				<?php endforeach; 
			} ?> 
			

		</div>

      <?php if($audios_count > 0){   include('partials/pagination.php'); }else{} ?>

	<?php //include('partials/pagination.php'); ?>

</div>


<?php include('footer.blade.php'); ?>
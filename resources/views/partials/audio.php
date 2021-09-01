<?php if(isset($audios)) :
foreach($audios as $audio): ?>
<div class="iq-main-header col-md-3 d-flex align-items-center justify-content-between">
<div class="favorites-contens">
    <ul class="favorites-slider list-inline  row p-0 mb-0">
        <li class="slide-item">
	<article class="block expand">
		<a class="block-thumbnail" href="<?= URL::to('audio') ?><?= '/' . $audio->slug ?>">
			<!-- <div class="thumbnail-overlay"></div> -->
            <div class="play-button">
                <div class="play-block">
                    <i class="fa fa-play flexlink" aria-hidden="true"></i> 
                </div>
                <div class="detail-block">
              <!--  <p class="movie-title"><?= $audio->title; ?></p>-->
                </div>
            </div>
			<img src="<?php echo URL::to('/').'/public/uploads/images/'.$audio->image;?>" width="280">
		</a>
         <div class="block-contents">
            <p class="movie-title padding p1"><?php echo $audio->title; ?></p>
        </div>
		
	</article>
        </li>
    </ul>
</div>
</div>


<?php endforeach; 
endif; ?>
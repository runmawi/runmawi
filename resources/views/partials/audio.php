<?php if(isset($audios)) :
foreach($audios as $audio): ?>
<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 new-art">
	<article class="block expand">
		<a class="block-thumbnail" href="<?= URL::to('audio') ?><?= '/' . $audio->slug ?>">
			<!-- <div class="thumbnail-overlay"></div> -->
            <div class="play-button">
                <div class="play-block">
                    <i class="fa fa-play flexlink" aria-hidden="true"></i> 
                </div>
                <div class="detail-block">
                <p class="movie-title"><?= $audio->title; ?></p>
                </div>
            </div>
			<img src="<?php echo URL::to('/').'/public/uploads/images/'.$audio->image;?>">
		</a>
         <div class="block-contents">
            <p class="movie-title padding"><?php echo $audio->title; ?></p>
        </div>
		
	</article>
</div>
<?php endforeach; 
endif; ?>
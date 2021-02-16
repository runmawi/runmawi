<?php if(isset($albums)) :
foreach($albums as $album): ?>
<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 new-art">
	<article class="block expand">
		<a class="block-thumbnail" href="<?= ($settings->enable_https) ? secure_url('audio') : URL::to('audio') ?><?= '/' . $album->slug ?>">
			<!-- <div class="thumbnail-overlay"></div> -->
            <div class="play-button">
                <div class="play-block">
                    <i class="fa fa-play flexlink" aria-hidden="true"></i> 
                </div>
                <div class="detail-block">
                <p class="movie-title"><?= $album->albumname; ?></p>
                </div>
            </div>
			<img src="<?php echo URL::to('/').'/content/uploads/albums/'.$album->album;?>">
		</a>
         <div class="block-contents">
            <p class="movie-title padding"><?php echo $album->title; ?></p>
        </div>
		
	</article>
</div>
<?php endforeach; 
endif; ?>
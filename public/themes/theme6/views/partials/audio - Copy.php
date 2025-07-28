<?php if(isset($audios_category)) :
foreach($audios_category as $audio): ?>
<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 new-art">
	<article class="block">
		<a class="block-thumbnail" href="<?= ($settings->enable_https) ? secure_url('audio') : URL::to('audio') ?><?= '/' . $audio->id ?>">
			<!-- <div class="thumbnail-overlay"></div> -->
            <div class="play-button">
                <div class="play-block">
                    <i class="fa fa-play flexlink" aria-hidden="true"></i> 
                </div>
                <div class="detail-block">
                <p class="movie-title"><?= $audio->title; ?></p>
                <p class="movie-rating">
                    <span class="star-rate"><i class="fa fa-star"></i><?= $audio->rating;?></span>
                    <span class="viewers"><i class="fa fa-eye"></i>(<?= $audio->views;?>)</span>
                    <span class="running-time"><i class="fa fa-clock-o"></i><?= TimeHelper::convert_seconds_to_HMS($audio->duration); ?></span>
                </p>
                </div>
                <div class="thriller"> <p><?= $audio->audio_category_id;?></p></div>
            </div>
			<img src="<?= ImageHandler::getImage($audio->image, 'medium')  ?>">
		</a>
		<div class="block-contents">
            <p class="movie-title padding"><?= $audio->title; ?> <span><?= TimeHelper::convert_seconds_to_HMS($audio->duration); ?></span></p>
			<!-- <p class="date"><?= date("F jS, Y", strtotime($audio->created_at)); ?>
				<?php if($audio->access == 'guest'): ?>
					<span class="label label-info">Free</span>
				<?php elseif($audio->access == 'subscriber'): ?>
					<span class="label label-success">Subscribers Only</span>
				<?php elseif($audio->access == 'registered'): ?>
					<span class="label label-warning">Registered Users</span>
				<?php endif; ?>
			</p>
			<p class="desc"><?php if(strlen($audio->description) > 90){ echo substr($audio->description, 0, 90) . '...'; } else { echo $audio->description; } ?></p>
-->
		</div>
	</article>
</div>
<?php endforeach; 
endif; ?>
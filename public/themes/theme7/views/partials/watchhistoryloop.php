<?php if(isset($watchhistory_videos)) :
foreach($watchhistory_videos as $watchhistory_video): ?>
<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 new-art">
	<article class="block expand">
		<a class="block-thumbnail" href="<?= ($settings->enable_https) ? secure_url('watchhistory_video') : URL::to('watchhistory_video') ?><?= '/' . $watchhistory_video->id ?>">
			<div class="thumbnail-overlay"></div>
			<span class="play-button"></span>
			<img src="<?= ImageHandler::getImage($watchhistory_video->image, 'medium')  ?>">
			<div class="details">
				<h2><?= $watchhistory_video->title; ?> <span><?= TimeHelper::convert_seconds_to_HMS($watchhistory_video->duration); ?></span></h2>
            </div>
		</a>
		<div class="block-contents">
			<p class="date"><?= date("F jS, Y", strtotime($watchhistory_video->created_at)); ?>
				<?php if($watchhistory_video->access == 'guest'): ?>
					<span class="label label-info">Free</span>
				<?php elseif($watchhistory_video->access == 'subscriber'): ?>
					<span class="label label-success">Subscribers Only</span>
				<?php elseif($watchhistory_video->access == 'registered'): ?>
					<span class="label label-warning">Registered Users</span>
				<?php endif; ?>
			</p>
			<p class="desc"><?php if(strlen($watchhistory_video->description) > 90){ echo substr($watchhistory_video->description, 0, 90) . '...'; } else { echo $watchhistory_video->description; } ?></p>
		</div>
	</article>
</div>
<?php endforeach; 
endif; ?>
<div class="clear"></div>
<?php if(isset($watchhistory_movies)) :
foreach($watchhistory_movies as $watchhistory_movie): ?>
<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 new-art">
	<article class="block expand">
		<a class="block-thumbnail" href="<?= ($settings->enable_https) ? secure_url('mywatchhistory') : URL::to('watchhistory_movie') ?><?= '/' . $watchhistory_movie->id ?>">
			<div class="thumbnail-overlay"></div>
			<span class="play-button"></span>
			<img src="<?= ImageHandler::getImage($watchhistory_movie->image, 'medium')  ?>">
			<div class="details">
				<h2><?= $watchhistory_movie->title; ?> <span><?= TimeHelper::convert_seconds_to_HMS($watchhistory_movie->duration); ?></span></h2>
            </div>
		</a>
		<div class="block-contents">
			<p class="date"><?= date("F jS, Y", strtotime($watchhistory_movie->created_at)); ?>
				<?php if($watchhistory_movie->access == 'guest'): ?>
					<span class="label label-info">Free</span>
				<?php elseif($watchhistory_movie->access == 'subscriber'): ?>
					<span class="label label-success">Subscribers Only</span>
				<?php elseif($watchhistory_movie->access == 'registered'): ?>
					<span class="label label-warning">Registered Users</span>
				<?php endif; ?>
			</p>
			<p class="desc"><?php if(strlen($watchhistory_movie->description) > 90){ echo substr($watchhistory_movie->description, 0, 90) . '...'; } else { echo $watchhistory_movie->description; } ?></p>
		</div>
	</article>
</div>
<?php endforeach;
endif; ?>
<div class="clear"></div>
<?php if(isset($watchhistory_episodes)) :
foreach($watchhistory_episodes as $watchhistory_episode): ?>
<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 new-art">
	<article class="block expand">
		<a class="block-thumbnail" href="<?= ($settings->enable_https) ? secure_url('mywatchhistory') : URL::to('watchhistory_episode') ?><?= '/' . $watchhistory_episode->id ?>">
			<div class="thumbnail-overlay"></div>
			<span class="play-button"></span>
			<img src="<?= ImageHandler::getImage($watchhistory_episode->image, 'medium')  ?>">
			<div class="details">
				<h2><?= $watchhistory_episode->title; ?> <span><?= TimeHelper::convert_seconds_to_HMS($watchhistory_episode->duration); ?></span></h2>
            </div>
		</a>
		<div class="block-contents">
			<p class="date"><?= date("F jS, Y", strtotime($watchhistory_episode->created_at)); ?>
				<?php if($watchhistory_episode->access == 'guest'): ?>
					<span class="label label-info">Free</span>
				<?php elseif($watchhistory_episode->access == 'subscriber'): ?>
					<span class="label label-success">Subscribers Only</span>
				<?php elseif($watchhistory_episode->access == 'registered'): ?>
					<span class="label label-warning">Registered Users</span>
				<?php endif; ?>
			</p>
			<p class="desc"><?php if(strlen($watchhistory_episode->description) > 90){ echo substr($watchhistory_episode->description, 0, 90) . '...'; } else { echo $watchhistory_episode->description; } ?></p>
		</div>
	</article>
</div>
<?php endforeach;
endif; ?>

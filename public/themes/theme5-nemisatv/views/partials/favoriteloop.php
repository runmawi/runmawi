<?php if(isset($favorite_videos)) :
foreach($favorite_videos as $favorite_video): ?>
<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 new-art">
	<article class="block expand">
		<a class="block-thumbnail" href="<?= ($settings->enable_https) ? secure_url('favorite_video') : URL::to('favorite_video') ?><?= '/' . $favorite_video->id ?>">
			<div class="thumbnail-overlay"></div>
			<span class="play-button"></span>
			<img src="<?= ImageHandler::getImage($favorite_video->image, 'medium')  ?>">
			<div class="details">
				<h2><?= $favorite_video->title; ?> <span><?= TimeHelper::convert_seconds_to_HMS($favorite_video->duration); ?></span></h2>
            </div>
		</a>
		<div class="block-contents">
			<p class="date"><?= date("F jS, Y", strtotime($favorite_video->created_at)); ?>
				<?php if($favorite_video->access == 'guest'): ?>
					<span class="label label-info">Free</span>
				<?php elseif($favorite_video->access == 'subscriber'): ?>
					<span class="label label-success">Subscribers Only</span>
				<?php elseif($favorite_video->access == 'registered'): ?>
					<span class="label label-warning">Registered Users</span>
				<?php endif; ?>
			</p>
			<p class="desc"><?php if(strlen($favorite_video->description) > 90){ echo substr($favorite_video->description, 0, 90) . '...'; } else { echo $favorite_video->description; } ?></p>
		</div>
	</article>
</div>
<?php endforeach; 
endif; ?>
<div class="clear"></div>
<?php if(isset($favorite_movies)) :
foreach($favorite_movies as $favorite_movie): ?>
<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 new-art">
	<article class="block">
		<a class="block-thumbnail" href="<?= ($settings->enable_https) ? secure_url('favorite') : URL::to('favorite_movie') ?><?= '/' . $favorite_movie->id ?>">
			<div class="thumbnail-overlay"></div>
			<span class="play-button"></span>
			<img src="<?= ImageHandler::getImage($favorite_movie->image, 'medium')  ?>">
			<div class="details">
				<h2><?= $favorite_movie->title; ?> <span><?= TimeHelper::convert_seconds_to_HMS($favorite_movie->duration); ?></span></h2>
            </div>
		</a>
		<div class="block-contents">
			<p class="date"><?= date("F jS, Y", strtotime($favorite_movie->created_at)); ?>
				<?php if($favorite_movie->access == 'guest'): ?>
					<span class="label label-info">Free</span>
				<?php elseif($favorite_movie->access == 'subscriber'): ?>
					<span class="label label-success">Subscribers Only</span>
				<?php elseif($favorite_movie->access == 'registered'): ?>
					<span class="label label-warning">Registered Users</span>
				<?php endif; ?>
			</p>
			<p class="desc"><?php if(strlen($favorite_movie->description) > 90){ echo substr($favorite_movie->description, 0, 90) . '...'; } else { echo $favorite_movie->description; } ?></p>
		</div>
	</article>
</div>
<?php endforeach;
endif; ?>
<div class="clear"></div>
<?php if(isset($favorite_episodes)) :
foreach($favorite_episodes as $favorite_episode): ?>
<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 new-art">
	<article class="block">
		<a class="block-thumbnail" href="<?= ($settings->enable_https) ? secure_url('favorite') : URL::to('favorite_episode') ?><?= '/' . $favorite_episode->id ?>">
			<div class="thumbnail-overlay"></div>
			<span class="play-button"></span>
			<img src="<?= ImageHandler::getImage($favorite_episode->image, 'medium')  ?>">
			<div class="details">
				<h2><?= $favorite_episode->title; ?> <span><?= TimeHelper::convert_seconds_to_HMS($favorite_episode->duration); ?></span></h2>
            </div>
		</a>
		<div class="block-contents">
			<p class="date"><?= date("F jS, Y", strtotime($favorite_episode->created_at)); ?>
				<?php if($favorite_episode->access == 'guest'): ?>
					<span class="label label-info">Free</span>
				<?php elseif($favorite_episode->access == 'subscriber'): ?>
					<span class="label label-success">Subscribers Only</span>
				<?php elseif($favorite_episode->access == 'registered'): ?>
					<span class="label label-warning">Registered Users</span>
				<?php endif; ?>
			</p>
			<p class="desc"><?php if(strlen($favorite_episode->description) > 90){ echo substr($favorite_episode->description, 0, 90) . '...'; } else { echo $favorite_episode->description; } ?></p>
		</div>
	</article>
</div>
<?php endforeach;
endif; ?>

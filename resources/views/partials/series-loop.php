<?php if(isset($videos)) :
foreach($videos as $video): ?>
<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 new-art">
	<article class="block expand">
        <a class="block-thumbnail" href="<?= ($settings->enable_https) ? secure_url('videos_category') : URL::to('video') ?><?= '/' . $video->id ?>">
            <div class="play-button">
                <div class="play-block">
                    <i class="fa fa-play flexlink" aria-hidden="true"></i> 
                </div>
                <div class="detail-block">
                <p class="movie-title"><?= ucfirst($video->title); ?></p>
                <p class="movie-rating">
                    <span class="star-rate"><i class="fa fa-star"></i><?= $video->rating;?></span>
                    <span class="viewers"><i class="fa fa-eye"></i>(<?= $video->views;?>)</span>
                    <span class="running-time"><i class="fa fa-clock-o"></i><?=  gmdate("H:i:s",$video->duration); ?></span>
                </p>
                </div>
                 <div class="thriller"> <p><?=$video->title;?></p></div> 
            </div>
            <img src="<?php echo URL::to('/').'/public/uploads/images/'.$video->image;  ?>">
        </a>
         <div class="block-contents">
            <p class="movie-title padding"><?php echo $video->title; ?></p>
        </div>
	</article>
</div>
<?php endforeach; 
endif; ?>

<?php if(isset($videos_category)) :
foreach($videos_category as $videos_cat): ?>
<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 new-art">
	<article class="block expand">
        <a class="block-thumbnail" href="<?= ($settings->enable_https) ? secure_url('videos_category') : URL::to('videos_category') ?><?= '/' . $videos_cat->id ?>">
            <div class="play-button">
                <div class="play-block">
                    <i class="fa fa-play flexlink" aria-hidden="true"></i> 
                </div>
                <div class="detail-block">
                <p class="movie-title"><?= ucfirst($videos_cat->title); ?></p>
                <p class="movie-rating">
                    <span class="star-rate"><i class="fa fa-star"></i><?= $videos_cat->rating;?></span>
                    <span class="viewers"><i class="fa fa-eye"></i>(<?= $videos_cat->views;?>)</span>
                    <span class="running-time"><i class="fa fa-clock-o"></i><?=  gmdate("H:i:s",$videos_cat->duration); ?></span>
                </p>
                </div>
                 <div class="thriller"> <p><?= $videos_cat->title;?></p></div> 
            </div>
            <img src="<?php echo URL::to('/').'/public/uploads/images/'.$videos_cat->image;  ?>">
        </a>
         <div class="block-contents">
            <p class="movie-title padding"><?php echo $videos_cat->title; ?></p>
        </div>
	</article>
</div>
<?php endforeach; 
endif; ?>



<?php if(isset($movies)) :
foreach($movies as $movie): ?>
<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 new-art">
	<article class="block expand">
        <a class="block-thumbnail" href="<?= ($settings->enable_https) ? secure_url('movie') : URL::to('play_movie') ?><?= '/' . $movie->slug ?>">
            <div class="play-button">
                <div class="play-block">
                    <i class="fa fa-play flexlink" aria-hidden="true"></i> 
                </div>
                <div class="detail-block">
                <p class="movie-title"><?= ucfirst($movie->title); ?></p>
                <p class="movie-rating">
                    <span class="star-rate"><i class="fa fa-star"></i><?= $movie->rating;?></span>
                    <span class="viewers"><i class="fa fa-eye"></i>(<?= $movie->views;?>)</span>
                    <span class="running-time"><i class="fa fa-clock-o"></i><?=  gmdate("H:i:s",$movie->duration); ?></span>
                </p>
                </div>
                <div class="thriller"> <p><?= $movie->title;?></p></div>
            </div>
            <img src="<?php echo URL::to('/').'/public/uploads/images/'.$movie->image;  ?>">
        </a>
         <div class="block-contents">
            <p class="movie-title padding"><?php echo $movie->title; ?></p>
        </div>
	</article>
</div>
<?php endforeach;
endif; ?>

<?php if(isset($movies_genre)) :
foreach($movies_genre as $movies_cat): ?>
<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 new-art">
	<article class="block expand">
        <a class="block-thumbnail" href="<?php echo URL::to('/').'/play_movie/'.$movies_cat->slug;?>">
            <div class="play-button">
                <div class="play-block">
                    <i class="fa fa-play flexlink" aria-hidden="true"></i> 
                </div>
                <div class="detail-block">
                <p class="movie-title"><?= ucfirst($movies_cat->title); ?></p>
                <p class="movie-rating">
                    <span class="star-rate"><i class="fa fa-star"></i><?= $movies_cat->rating;?></span>
                    <span class="viewers"><i class="fa fa-eye"></i>(<?= $movies_cat->views;?>)</span>
                    <span class="running-time"><i class="fa fa-clock-o"></i><?=  gmdate("H:i:s",$movies_cat->duration); ?></span>
                </p>
                </div>
                <div class="thriller"> <p><?= $movies_cat->title;?></p></div>
            </div>
            <img src="<?php echo URL::to('/').'/public/uploads/images/'.$movie->image;  ?>">
        </a>
         <div class="block-contents">
            <p class="movie-title padding"><?php echo $movie->title; ?></p>
        </div>
	</article>
</div>
<?php endforeach; 
endif; ?>

<?php if(isset($series)) :
foreach($series as $seriess): ?>
<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 new-art">
	<article class="block expand">
         <a class="block-thumbnail" href="<?= URL::to('play_series') ?><?= '/' . $seriess->id ?>">
            <div class="play-button">
                <div class="play-block">
                    <i class="fa fa-play flexlink" aria-hidden="true"></i> 
                </div>
                <div class="detail-block">
                <p class="movie-title"><?= ucfirst($seriess->title); ?></p>
                <p class="movie-rating">
                    <span class="star-rate"><i class="fa fa-star"></i><?= $seriess->rating;?></span>
                    <span class="viewers"><i class="fa fa-eye"></i>(<?= $seriess->views;?>)</span>
                    <span class="running-time"><i class="fa fa-clock-o"></i><?=  gmdate("H:i:s",$seriess->duration); ?></span>
                </p>
                </div>
                <div class="thriller"> <p><?= $seriess->title;?></p></div>
            </div>
            <img src="<?php echo URL::to('/').'/public/uploads/images/'.$seriess->image;  ?>">
        </a>
         <div class="block-contents">
            <p class="movie-title padding"><?php echo $seriess->title; ?></p>
        </div>
	</article>
</div>
<?php endforeach;
endif; ?>

<?php if(isset($episodes)) :
foreach($episodes as $episode): ?>
<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 new-art">
	<article class="block expand">
	    <a class="block-thumbnail" href="<?= ($settings->enable_https) ? secure_url('episode') : URL::to('episodes') ?><?= '/' . $episode->slug ?>">
            <div class="play-button">
                <div class="play-block">
                    <i class="fa fa-play flexlink" aria-hidden="true"></i> 
                </div>
                <div class="detail-block">
                <p class="movie-title"><?= ucfirst($episode->title); ?></p>
                <p class="movie-rating">
                    <span class="star-rate"><i class="fa fa-star"></i><?= $episode->rating;?></span>
                    <span class="viewers"><i class="fa fa-eye"></i>(<?= $episode->views;?>)</span>
                    <span class="running-time"><i class="fa fa-clock-o"></i><?=  gmdate("H:i:s",$episode->duration); ?></span>
                </p>
                </div>
                <div class="thriller"> <p><?= $episode->title;?></p></div>
            </div>
            <img src="<?php echo URL::to('/').'/public/uploads/images/'.$episode->image;  ?>">
        </a>
         <div class="block-contents">
            <p class="movie-title padding"><?php echo $episode->title; ?></p>
        </div>
	</article>
</div>
<?php endforeach;
endif; ?>




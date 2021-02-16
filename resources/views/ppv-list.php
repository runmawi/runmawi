<?php include('header.php'); ?>

<div class="container search-results">

		<?php if(count($videos) >= 1): ?>
			
			<h3>Pay Per View Video</h3>
		
			<div class="row">

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
                                        <span class="running-time"><i class="fa fa-clock-o"></i><?= $video->duration; ?></span>
                                    </p>
                                    </div>
                                    <!-- <div class="thriller"> <p><?// $video->genre->name;?></p></div> -->
                                </div>
                                <img src="<?= URL::to('/').'/public/uploads/images/'.$video->image;  ?>">
                            </a>
                             <div class="block-contents">
                                <p class="movie-title padding"><?php echo $video->title; ?></p>
                            </div>
                        </article>
                    </div>
                    <?php endforeach; 
                    endif; ?>

			</div>
		<?php endif; ?>
	

		

</div>

<?php include('footer.blade.php'); ?>